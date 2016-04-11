<?php
/**
 * @Author: Nate Bosscher (c) 2015
 * @Date:   2016-04-11 11:30:43
 * @Last Modified by:   Nate Bosscher
 * @Last Modified time: 2016-04-11 17:25:54
 */

/**
 * provides authentication service for the app.
 * 
 * code is an encrypted integer id for a receipt.
 * 
 * adminCode is the current quarter as an integer, encrypted. 
 * 		This means that the admin code will be invalid at the change of the quarter.
 */
class Authenticator{

	/**
	 * creates a code used to securely retrieve a receipt
	 * @param  Receipt $receipt [description]
	 * @return [type]           [description]
	 */
	static function generateCode(Receipt $receipt){

		return @openssl_encrypt(strval($receipt->id), ENCRYPTION_METHOD, SECRETE);
	}

	/**
	 * retrieves a receipt for the corresponding code
	 * @param  [type] $code [description]
	 * @return [type]       [description]
	 */
	static function redeemCode($code){
		global $db;
		
		// decrypt
		$id = @openssl_decrypt($code, ENCRYPTION_METHOD, SECRETE);
		
		// check that it's a number
		if(strval(intval($id)) != $id)
			throw new Exception("", Exceptions::AUTH_CODE_NOT_FOUND);

		// check that id exists
		$r = $db->query("SELECT COUNT(*) as ct FROM `receipts` WHERE id=" . $id);

		if($r != null){
			$r = $r->fetch_assoc();

			if($r['ct'] == 1)
				return $id;
		}

		throw new Exception("", Exceptions::AUTH_CODE_NOT_FOUND);
	}

	/**
	 * validates an administrator access code
	 * @param  [type] $code [description]
	 * @return [type]       [description]
	 */
	static function validateAdminCode($code){

		// decrypt
		$_quarter = @openssl_decrypt($code, ENCRYPTION_METHOD, SECRETE);

		if(strval(intval($_quarter)) != $_quarter){
			throw new Exception("", Exceptions::AUTH_ADMIN_FAILED);	
		}

		$quarter = ceil(date("m")  / 4) + date('Y') * 4;
		if($_quarter == $quarter){
			return true;
		}else{
			throw new Exception("", Exceptions::AUTH_ADMIN_OUTDATED);
		}
	}

	/**
	 * gets or generates the admin access code
	 * @return [type] [description]
	 */
	static function getAdminCode(){
		$quarter = ceil(date("m")  / 4) + date('Y') * 4;

		return @openssl_encrypt($quarter, ENCRYPTION_METHOD, SECRETE);
	}
}