<?php
/**
 * @Author: Nate Bosscher (c) 2015
 * @Date:   2016-04-11 11:49:15
 * @Last Modified by:   Nate Bosscher
 * @Last Modified time: 2016-04-12 11:57:31
 */

require_once __DIR__ . "/pt.header.php";

$action = ($intent->type == MailLinkType::COMM_CONFIRM ? "confirm" : "deny");

?>

<div class="msg-box">
	<h2>Receipt Processing</h2>
	<form method="POST">
		<input type="hidden" name="confirmed" value="1" />
		Are you sure you would like to <b><?php echo $action; ?></b> this receipt?
		<br>
		<br>
		<input type="submit" value="Ok" />
	</form>
</div>

<?php 

require_once __DIR__ . "/pt.footer.php";