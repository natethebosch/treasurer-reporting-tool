<?php
/**
 * @Author: Nate Bosscher (c) 2015
 * @Date:   2016-04-11 09:12:49
 * @Last Modified by:   Nate Bosscher
 * @Last Modified time: 2016-04-12 12:28:33
 */


/**
 * Encapsultes the Receipt and provides functionality to create, approve, deny and list Receipts
 */
class Receipt{
	const STATUS_UNDEF = -1;
	const STATUS_CONFIRMED = 1;
	const STATUS_DENIED = 0;

	const DATE_FORMAT = "Y-m-d";

	public $id;
	public $submitter;
	public $dateOfPurchase;
	public $photoDir;
	public $committee;
	public $budgetLineItem;
	public $amount;
	public $description;
	public $dateOfSubmission;
	public $status;
	public $reviewedBy;
	public $reviewedDate;
	public $reviewedUsingCode;

	function __construct($dbRecord = null){
		$this->id = -1; // for database query safety.
		$this->reviewedBy = false; // to prevent mail template errors
		$this->status = self::STATUS_UNDEF;

		if($dbRecord != null){
			$this->id = $dbRecord['id'];
			$this->submitter = $dbRecord['submitter'];
			$this->dateOfPurchase = new DateTime($dbRecord['dateOfPurchase']);
			$this->photoDir = $dbRecord['photoDir'];
			$this->committee = $dbRecord['committee'];
			$this->budgetLineItem = $dbRecord['budgetLineItem'];
			$this->amount = $dbRecord['amount'];
			$this->description = $dbRecord['description'];
			$this->dateOfSubmission = new DateTime($dbRecord['dateOfSubmission']);
			$this->status = $dbRecord['status'];
			$this->reviewedBy = $dbRecord['reviewedBy'];
			$this->reviewedDate = new DateTime($dbRecord['reviewedDate']);
			$this->reviewedUsingCode = $dbRecord['reviewedUsingCode'];
		}
	}

	/**
	 * creates a new receipt given POST params and FILE params
	 * @param  [type] $params [description]
	 * @return [type]         [description]
	 */
	static function accept($params, $files){
		global $db;

		try{
			Config::getCommitteeEmailForName($params['committee']);
		}catch(Exception $e){
			echo $e->getTraceAsString();
			return false;
		}

		// setup query
		$stmt = $db->prepare("INSERT INTO `receipts` SET 
			submitter=?, 
			dateOfPurchase=?, 
			photoDir=?, 
			committee=?, 
			budgetLineItem=?, 
			amount=?,
			description=?,
			dateOfSubmission=NOW(),
			status=?");

		// move files into place
		$created = false;
		$folder = "";
		while(!$created){
			$folder = "/receipts" . date("/Y/m-d/H-i-s/");

			try{
				if(!mkdir(DATA_DIR . $folder, 0777, true)){
					die("Permissions error");
				}

				// no exception so we're ok
				$created = true;
			}catch(Exception $e){
				// try again
				sleep(1);
				echo $e->getTraceAsString();
				die();
			}
		}
	
		$ct = 0;
		foreach($files as $k => $v){
			$ext = pathinfo($_POST[$k . "-type"], PATHINFO_EXTENSION);

			// move tmp_file to correct location
			if(!move_uploaded_file($v['tmp_name'], DATA_DIR  . $folder . "$ct." . $ext)){
				die("Couldn't move " . $v['tmp_name'] . " to " . DATA_DIR  . $folder . "$ct." . $ext);
			}

			// convert encodeing from base64
			$fname = DATA_DIR  . $folder . "$ct." . $ext;
			file_put_contents($fname, base64_decode(file_get_contents($fname)));

			$ct++;
		}

		$status = self::STATUS_UNDEF;
		$date = date("Y-m-d", strtotime($params['dateOfPurchase']));

		// perform query
		$stmt->bind_param("sssssdsi", $params['submitter'], 
			$date, 
			$folder, 
			$params['committee'], 
			$params['budgetLineItem'],
			$params['amount'],
			$params['description'],
			$status);

		$stmt->execute();

		if($db->error){
			die('db-error ' . $db->error);
		}

		// notify the committee
		Mail::notifyCommittee(self::getReceiptForId($db->insert_id));


		return true;
	}

	/**
	 * update database record to show that the receipt has been confirmed
	 * trigger mail to treasuer
	 * @param  [type] $reviewer [description]
	 * @param  [type] $code     [description]
	 * @return [type]           [description]
	 */
	function confirm($reviewer, $code){
		global $db;

		try{
			// update db record
			$stmt = $db->prepare("UPDATE `receipts` SET status=?, reviewedBy=?, reviewedDate=NOW(), reviewedUsingCode=? WHERE id=?");
			$this->status = self::STATUS_CONFIRMED;
			$stmt->bind_param("issi", $this->status, $reviewer, $code, $this->id);
			
			$stmt->execute();

			// notify treasurer
			Mail::notifyTreasurer($this);

			return true;
		}catch(Exception $e){
			return false;
		}
	}

	/**
	 * update database record to show that the receipt has been denied
	 * trigger mail to treasuer
	 * @param  [type] $reviewer [description]
	 * @param  [type] $code     [description]
	 * @return [type]           [description]
	 */
	function deny($reviewer, $code){
		global $db;

		try{
			// update db record
			$stmt = $db->prepare("UPDATE `receipts` SET status=?, reviewedBy=?, reviewedDate=NOW(), reviewedUsingCode=? WHERE id=?");
			$this->status = self::STATUS_DENIED;
			$stmt->bind_param("issi", $this->status, $reviewer, $code, $this->id);
			
			$stmt->execute();

			// notify treasuer
			Mail::notifyTreasurer($this);

			return true;
		}catch(Exception $e){
			return false;
		}
	}

	/**
	 * returns a list of receipt files based on photoDir (full path spec)
	 * @return [type] [description]
	 */
	function getFiles(){
		$output = array();

		foreach(scandir(DATA_DIR . $this->photoDir) as $v){
			if($v[0] != '.')
				$output[] = DATA_DIR . $this->photoDir . "/$v";
		}

		return $output;
	}

	/**
	 * builds a form of receipt data in a csv format
	 * returns a string of the csv
	 * @return [type] [description]
	 */
	static function getFormCSVAsString($receipts){
		$header = "Ambassadors Christian School,,,,Name:,NAME,,
Expense Reimbursement Form,,,,Date:,DATE,,
,,,,,,,
Date of Purchase,Description,Committee,Budget Line Item,Approved By,Approved Date,Amount,GST,PST,NET";

		$footer = ",,,,,,,
,,,,,,,
,,,,,Totals,SUM_AMOUNT,,,
,,,,,Paid By:,,
,,,,,Chq #:,,
,,,,,Date:,,
* Date formats as Y-m-d";

		$sum = 0;

		$rows = array();
		foreach($receipts as $k => $v){

			// build row
			$row = array();
			$row[] = $v->dateOfPurchase->format(Receipt::DATE_FORMAT);
			$row[] = $v->description;
			$row[] = $v->committee;
			$row[] = $v->budgetLineItem;
			$row[] = $v->reviewedBy;
			$row[] = $v->reviewedDate->format(Receipt::DATE_FORMAT);
			$row[] = $v->amount;

			// add trailing 3 empty fields
			$row[] = "";
			$row[] = "";
			$row[] = "";

			// escape any special characters
			foreach($row as $rk => $rv){
				if(preg_match("/[\"\n,]+/", $rv)){
					$row[$rk] = '"'.str_replace('"', '""', $rv) . '"';
				}
			}

			// form csv
			$rows[] = implode(",", $row);

			// accumulator for SUM
			$sum += $v->amount;
		}

		// format main csv section
		$main = implode("\n", $rows);

		// insert placeholder values
		$footer = str_replace("SUM_AMOUNT", $sum, $footer);

		reset($receipts);
		$header = str_replace("NAME", current($receipts)->submitter, $header);
		$header = str_replace("DATE", current($receipts)->dateOfSubmission->format(Receipt::DATE_FORMAT), $header);

		return $header . "\n" . $main . "\n" . $footer;
	}

	/**
	 * return Receipt
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	static function getReceiptForId($id){
		global $db;

		$r = $db->query("SELECT * FROM `receipts` WHERE id=$id");
		if($db->error)
			die("db-error " . $db->error);

		if($r == null || $r->num_rows != 1)
			die('db-error receipt not found');

		return new Receipt($r->fetch_assoc());
	}

	/**
	 * gets a list from the database of receipts for a given year and 
	 * returns it as a list of Receipt objects
	 * @param  [type] $year [description]
	 * @return [type]       [description]
	 */
	static function getReceiptsForYear($year){
		global $db;

		$r = $db->query("SELECT * FROM `receipts` WHERE YEAR(dateOfSubmission)=" . intval($year) . " AND status=" . Receipt::STATUS_CONFIRMED);
		
		if($db->error){
			die("db-error " . $db->error);
		}

		if($r == null){
			return array();;
		}

		$output = array();
		for($i = 0; $i < $r->num_rows; $i++)
			$output[] = new Receipt($r->fetch_assoc());

		return $output;
	}

	/**
	 * returns the path to a zip file containing the receipts and documents for the given year
	 * @param  [type] $year [description]
	 * @return [type]       [description]
	 */
	static function generateZipOfReceiptsForYear($year){

		// get all the receipts for the year
		$list = self::getReceiptsForYear($year);

		// arrange into y-m-d => submitter => array(receipts)
		$ymdList = array();
		foreach($list as $v){
			$date = $v->dateOfSubmission->format(Receipt::DATE_FORMAT);
			if(!array_key_exists($date, $ymdList))
				$ymdList[$date] = array();

			if(!array_key_exists($v->submitter, $ymdList[$date]))
				$ymdList[$date][$v->submitter] = array();

			$ymdList[$date][$v->submitter][] = $v;
		}


		$fname = tempnam("/tmp", "tres-rep-");

		$zip = new ZipArchive();
		$zip->open($fname, ZIPARCHIVE::CREATE);
		$zip->addEmptyDir($year);

		foreach($ymdList as $date => $submitterList){
			$zip->addEmptyDir($year . "/" . $date);

			foreach($submitterList as $name => $receipts){
				$zip->addEmptyDir($year . "/" . $date . "/" . $name);

				foreach($receipts as $k => $receipt)
					foreach($receipt->getFiles() as $fk => $f)
						$zip->addFile($f, $year . "/" . $date . "/" . $name . "/receipt-" . $k . "-file-" . $fk . "." . pathinfo($f, PATHINFO_EXTENSION));

				$zip->addFromString($year . "/" . $date . "/" . $name . "/form.csv", Receipt::getFormCSVAsString($receipts));
			}
		}

		$zip->close();

		return $fname;
	}
}