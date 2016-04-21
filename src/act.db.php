<?php
/**
 * @Author: Nate Bosscher (c) 2015
 * @Date:   2016-04-11 11:02:29
 * @Last Modified by:   Nate Bosscher
 * @Last Modified time: 2016-04-12 13:24:58
 */
try{
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PWD, DB_DBNAME);
}catch(Exception $e){
    include_once __DIR__ . "/../install.php";
    echo "Database Error - " . $e->getMessage();
	die();
}

if($db->error){
	include_once __DIR__ . "/../install.php";
	die("Database Error - ".$db->error);
}
