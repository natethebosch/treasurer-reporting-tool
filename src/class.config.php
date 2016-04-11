<?php
/**
 * @Author: Nate Bosscher (c) 2015
 * @Date:   2016-04-11 09:27:39
 * @Last Modified by:   Nate Bosscher
 * @Last Modified time: 2016-04-11 16:10:19
 */

/**
 * Config works as an adapter into info.json
 */
class Config{
	static function getCommitteeEmailForName($name){
		$info = json_decode(file_get_contents(DATA_DIR . "/info.json"), true);
		if($info == null)
			throw new Exception("", Exceptions::INFO_UNREADABLE);

		if(array_key_exists($name, $info['committees']))
			return $info['committees'][$name];
		
		throw new Exception($name, Exceptions::COMMITTEE_NOT_FOUND);
	}

	static function getTreasurerEmail(){
		return Config::getCommitteeEmailForName("Treasurer");
	}
}