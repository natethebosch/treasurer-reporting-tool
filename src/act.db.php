<?php
/**
 * @Author: Nate Bosscher (c) 2015
 * @Date:   2016-04-11 11:02:29
 * @Last Modified by:   Nate Bosscher
 * @Last Modified time: 2016-04-11 11:03:34
 */

$db = @mysqli_connect(DB_SERVER, DB_USER, DB_PWD, DB_DBNAME);

if($db->error){
	die("Database Error");
}