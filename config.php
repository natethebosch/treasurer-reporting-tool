<?php
/**
 * @Author: Nate Bosscher (c) 2015
 * @Date:   2016-04-11 08:44:43
 * @Last Modified by:   Nate Bosscher
 * @Last Modified time: 2016-04-12 14:09:48
 */

date_default_timezone_set("America/Toronto");

// base url without trailing slash
define ("URL_ROOT", "<url-root>");

define("DB_DBNAME", "<database-name>");
define("DB_SERVER", "<database-server>");
define("DB_USER", "<database-user>");
define("DB_PWD", "<database-password>");

define("FROM_EMAIL", "<email>");
define("SMTP_HOST", "<email-smtp-server>");
define("SMTP_USER", "<email>");
define("SMTP_PWD", "<email-password>");

define("INFO", __DIR__ . "/data/info.json");
define("DATA_DIR", __DIR__ . "/data");

define("ENCRYPTION_METHOD", "AES-256-CBC");
define("SECRETE", "<random-password-at-least-64-chars-long>");