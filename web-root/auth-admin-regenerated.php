<?php
/**
 * @Author: Nate Bosscher (c) 2015
 * @Date:   2016-04-12 12:32:26
 * @Last Modified by:   Nate Bosscher
 * @Last Modified time: 2016-04-12 12:38:11
 */

// expectes $success to contain status for whether the email was successfully sent or not.

require_once __DIR__ . "/pt.header.php";

?>

<div class="msg-box">
<?php if($success): ?>
	<h2>Authentication Regenerated</h2>
	<p>
		Your treasurer should receive an email shortly with the new link.
	</p>
<?php else: ?>
	<h2>Authentication Regeneration Failed</h2>
	<p>
		Something went wrong. Please contact your administrator.
	</p>
<?php endif; ?>
</div>

<?php 

require_once __DIR__ . "/pt.footer.php";