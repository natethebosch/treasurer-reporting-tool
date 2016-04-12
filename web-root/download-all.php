<?php
/**
 * @Author: Nate Bosscher (c) 2015
 * @Date:   2016-04-11 11:49:15
 * @Last Modified by:   Nate Bosscher
 * @Last Modified time: 2016-04-12 11:58:49
 */

require_once __DIR__ . "/pt.header.php";

?>

<div class="msg-box">
	<h2>Bulk Download Receipts</h2>
	<form method="POST">
		Select a year to download <select name="year">
			<?php for($i = 0; $i < 10; $i++): ?>
				<option><?php echo date("Y") - $i; ?></option>
			<?php endfor; ?>
		</select>
		<br><br>
		<input type="submit" value="Download" />
	</form>
</div>

<?php 

require_once __DIR__ . "/pt.footer.php";