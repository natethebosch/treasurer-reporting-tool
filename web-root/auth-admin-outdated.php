<?php
/**
 * @Author: Nate Bosscher (c) 2015
 * @Date:   2016-04-11 11:49:15
 * @Last Modified by:   Nate Bosscher
 * @Last Modified time: 2016-04-12 12:32:00
 */

require_once __DIR__ . "/pt.header.php";

?>

<div class="msg-box">
	<h2>Authentication Failed</h2>
	<p>
		Your link appears to be invalid. It's possible that the authentication key has been time-reset. To email the treasurer a new link click regenerate below.
	</p>
	<form method="POST">
		<input type="hidden" name="action" value="regenerate-admin-auth" />
		<input type="submit" value="Regenerate" />
	</form>
</div>

<?php 

require_once __DIR__ . "/pt.footer.php";