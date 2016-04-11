<?php
/**
 * @Author: Nate Bosscher (c) 2015
 * @Date:   2016-04-11 11:00:47
 * @Last Modified by:   Nate Bosscher
 * @Last Modified time: 2016-04-11 17:27:53
 */

// turn warnings into exceptions
set_error_handler(function($errno, $errstr, $errfile, $errline, $errcontext) {
    // error was suppressed with the @-operator
    if (0 === error_reporting()) {
        return false;
    }

    throw new Exception($errstr, $errno);
});

require_once __DIR__ . "/vendor/autoload.php";

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/class.exceptions.php";
require_once __DIR__ . "/class.authenticator.php";
require_once __DIR__ . "/class.config.php";
require_once __DIR__ . "/class.mail-link-type.php";
require_once __DIR__ . "/class.mail-link-intent.php";
require_once __DIR__ . "/class.mail.php";
require_once __DIR__ . "/class.receipt.php";
require_once __DIR__ . "/act.db.php";
