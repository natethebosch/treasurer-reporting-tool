<?php
/**
 * @Author: Nate Bosscher (c) 2015
 * @Date:   2016-04-11 10:31:33
 * @Last Modified by:   Nate Bosscher
 * @Last Modified time: 2016-04-12 12:39:18
 */

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../src/include.php";

if(array_key_exists('action', $_GET) && $_GET['action'] == "unsubscribe"){ ?>
	Unsubscribe
<?php 
	die();
}

if(count($_GET) != 0){

	try{
		// provides authentication and returns parameters of the url's intent
		$intent = Mail::decodeMailLink($_GET);

		switch($intent->type){
			case MailLinkType::TRES_DL_ALL:

				if(array_key_exists("year", $_POST)){

					// generate .zip of files
					$tmpFilePath = Receipt::generateZipOfReceiptsForYear(intval($_POST['year']));

					// download the file
					header('Content-Description: File Transfer');
				    header('Content-Type: application/octet-stream');
				    header('Content-Disposition: attachment; filename="receipts-' . $_POST['year'] . '.zip"');
				    header('Expires: 0');
				    header('Cache-Control: must-revalidate');
				    header('Pragma: public');
				    header('Content-Length: ' . filesize($tmpFilePath));
				    readfile($tmpFilePath);

				    @unlink($tmpFilePath);

				    die();
				}else{

					// ask for a year to download
					include_once __DIR__ . "/download-all.php";
					die();
				}
			case MailLinkType::COMM_DENY:
			case MailLinkType::COMM_CONFIRM:
				if(array_key_exists('confirmed', $_POST)){

					// can assume that the receipt exists since it made it past the authentication in decodeMailLink
					// and since there's no delete functionality on this system
					$r = Receipt::getReceiptForId($intent->receiptId);

					// getCommitteeEmailForName should not throw any exceptions since $r->committee was validated 
					// upon creation of the receipt
					if($intent->type == MailLinkType::COMM_CONFIRM){
						$action = "CONFIRM";
						$r->confirm(Config::getCommitteeEmailForName($r->committee), $intent->authCode);
					}else{
						$action = "DENY";
						$r->deny(Config::getCommitteeEmailForName($r->committee), $intent->authCode);
					}

					include_once __DIR__ . "/committee-action-success.php";
					die();
				}else{
					if($intent->type == MailLinkType::COMM_CONFIRM){
						$action = "CONFIRM";
					}else{
						$action = "DENY";
					}

					include_once __DIR__ . "/committee-action.php";
					die();
				}
				break;
		}
	}catch(Exception $e){
		// print_r($e);
		if($e->getCode() == Exceptions::INVALID_MAIL_LINK){
			include_once __DIR__ . "/invalid-mail-link.php";
		}else if($e->getCode() == Exceptions::AUTH_CODE_NOT_FOUND){
			include_once __DIR__ . "/invalid-auth-code.php";
		}else if($e->getCode() == Exceptions::AUTH_ADMIN_FAILED){

			if(array_key_exists("regenerate-admin-auth", $_POST)){

				$success = true;
				try{
					Mail::emailTreasurerAccessLink();
				}catch(Exception $e){
					$success = false;
				}

				include_once __DIR__ . "/auth-admin-regenerated.php";
				die();
			}

			include_once __DIR__ . "/auth-admin-failed.php";
		}else if($e->getCode() == Exceptions::AUTH_ADMIN_OUTDATED){

			if(array_key_exists("action", $_POST) && $_POST['action'] == "regenerate-admin-auth"){

				$success = true;
				try{
					Mail::emailTreasurerAccessLink();
				}catch(Exception $e){
					$success = false;
				}

				include_once __DIR__ . "/auth-admin-regenerated.php";
				die();
			}

			include_once __DIR__ . "/auth-admin-outdated.php";
		}else{
			echo $e->getTraceAsString();
			die("UNDEFINED EXCEPTION " . $e->getMessage());
		}

		die();
	}
} 

if(count($_POST) != 0){
	try{
		$r = Receipt::accept($_POST, $_FILES);
		if($r == false){
			echo "0";
		}else{
			echo "1";
		}
	}catch(Exception $e){
		echo "0";
		echo $e->getMessage();
		echo $e->getTraceAsString();	
	}
}else{
	include_once __DIR__ . "/default.php";
}

// /unsubscribe

// if(admin-dl-page) allow:
// 	/resend-admin

