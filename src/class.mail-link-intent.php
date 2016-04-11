<?php
/**
 * @Author: Nate Bosscher (c) 2015
 * @Date:   2016-04-11 17:26:35
 * @Last Modified by:   Nate Bosscher
 * @Last Modified time: 2016-04-11 17:27:41
 */

class MailLinkIntent{
	function __construct($type, $receiptId = null, $authCode = null){
		$this->type = $type;
		$this->receiptId = $receiptId;
		$this->authCode = $authCode;
	}
}