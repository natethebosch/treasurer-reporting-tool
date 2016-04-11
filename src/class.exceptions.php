<?php
/**
 * @Author: Nate Bosscher (c) 2015
 * @Date:   2016-04-11 11:31:07
 * @Last Modified by:   Nate Bosscher
 * @Last Modified time: 2016-04-11 16:10:42
 */

/**
 * Exceptions is an enumeration of possible exceptions
 */
class Exceptions{
	const INFO_UNREADABLE = 1;
	const INVALID_MAIL_LINK = 2;
	const COMMITTEE_NOT_FOUND = 3;
	const MAIL_FAILED = 4;
	const AUTH_CODE_NOT_FOUND = 5;
	const AUTH_ADMIN_FAILED = 6;
	const AUTH_ADMIN_OUTDATED = 7;
}