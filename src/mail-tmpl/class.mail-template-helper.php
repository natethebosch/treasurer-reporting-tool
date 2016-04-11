<?php
/**
 * @Author: Nate Bosscher (c) 2015
 * @Date:   2016-04-11 10:32:13
 * @Last Modified by:   Nate Bosscher
 * @Last Modified time: 2016-04-11 10:45:54
 */

class MailTemplateHelper{
	/**
	 * generates an html table of valid information for the receipt
	 * @param  Receipt $receipt [description]
	 * @return [type]           [description]
	 */
	static function formatReceiptAsHTML(Receipt $receipt){
		$output = "";
		$output .= "<table><tbody>"; // starting padding

		if($receipt->status != Receipt::STATUS_UNDEF){
			if($receipt->status == Receipt::STATUS_CONFIRMED)
				$output .= "<tr><th>" . "[CONFIRMED]" . "</th></tr>";
			else if($receipt->status == Receipt::STATUS_DENIED)
				$output .= "<tr><th>" . "[DENIED]" . "</th></tr>";
		}

		$output .= "<tr><th>" . "Amount" . "</th><td> " . $receipt->amount . "</td></tr>";
		$output .= "<tr><th>" . "Committee Line" . "</th><td> " . $receipt->committee . " : " . $receipt->budgetLineItem . "</td></tr>";
		$output .= "<tr><th>" . "Submitted by" . "</th><td> " . $receipt->submitter . "</td></tr>";
		$output .= "<tr><th>" . "Purchased on" . "</th><td> " . $receipt->dateOfPurchase->format("Y-m-d") . "</td></tr>";

		if($receipt->reviewedBy){
			$output .= "<tr><th>" . "Reviewed by" . "</th><td> " . $receipt->reviewedBy . "</td></tr>";
			$output .= "<tr><th>" . "Reviewed on" . "</th><td> " . $receipt->reviewedDate->format("Y-m-d H:i:s") . "</td></tr>";
			$output .= "<tr><th>" . "Reviewed auth" . "</th><td> " . $receipt->reviewedUsingCode . "</td></tr>";
		}


		$output .= "<tr><th>" . "Description" . "</th></tr><tr><td colspan=\"2\">" . $receipt->description . "</td></tr>";

		$output .= "</tbody></table>"; // ending padding
	}

	/**
	 * generates a nice text layout of valid receipt information
	 * @param  Receipt $receipt [description]
	 * @return [type]           [description]
	 */
	static function formatReceiptAsText(Receipt $receipt){
		$output = "";
		$output .= "\n"; // starting padding

		if($receipt->status != Receipt::STATUS_UNDEF){
			if($receipt->status == Receipt::STATUS_CONFIRMED)
				$output .= "[CONFIRMED]" . "\n";
			else if($receipt->status == Receipt::STATUS_DENIED)
				$output .= "[DENIED]" . "\n";
		}

		$output .= "Amount: " . $receipt->amount . "\n";
		$output .= "Committee Line: " . $receipt->committee . " : " . $receipt->budgetLineItem . "\n";
		$output .= "Submitted by: " . $receipt->submitter . "\n";
		$output .= "Purchased on: " . $receipt->dateOfPurchase->format("Y-m-d") . "\n";

		if($receipt->reviewedBy){
			$output .= "Reviewed by: " . $receipt->reviewedBy . "\n";
			$output .= "Reviewed on: " . $receipt->reviewedDate->format("Y-m-d H:i:s") . "\n";
			$output .= "Reviewed auth: " . $receipt->reviewedUsingCode . "\n";
		}


		$output .= "Description: " . $receipt->description . "\n";

		$output .= "\n"; // ending padding
	}
}