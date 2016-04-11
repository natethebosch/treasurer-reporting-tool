<?php
/**
 * @Author: Nate Bosscher (c) 2015
 * @Date:   2016-04-11 10:24:38
 * @Last Modified by:   Nate Bosscher
 * @Last Modified time: 2016-04-11 16:52:00
 */

require_once __DIR__ . "/class.mail-template-helper.php";

/**
 * expects $receipt to the the Receipt for this email
 * expects $link to be the admin link
 */

$subject = "[Expense Nofication] " . $receipt->committee . " - " . $receipt->budgetLineItem . " Expense";

if($receipt->status == Receipt::STATUS_CONFIRMED)
	$textStatus = "confirmed";
else if($receipt->status == Receipt::STATUS_DENIED)
	$textStatus = "denied";

ob_start();
?><html>
<head></head>
<body>
	<table>
		<tbody>
			<tr>
				<td></td><td style="width: 300px">
					<h1>This reciept has been <?php echo $textStatus; ?></h1>
				</td><td></td>
			</tr><tr>
				<td></td><td>
					<?php MailTemplateHelper::formatReceiptAsHTML($receipt); ?>
				</td><td></td>
			</tr>
			<tr>
				<td></td><td>
					Download bulk receipts using link <a href="<?php echo $link; ?>"><?php echo $link; ?></a>
				</td><td></td>
			</tr>
			<tr><td></td><td>Thanks!</td><td></td></tr>
		</tbody>
	</table>

	<a href="<?php echo URL_ROOT; ?>/unsubscribe">Unsubscribe</a>

</body>
</html><?php

$html = ob_get_clean();

ob_start();
?>
This receipt has been <?php echo $textStatus; ?>.

<?php MailTemplateHelper::formatReceiptAsText($receipt); ?>

Download bulk receipts using link <?php echo $link; ?>

Thanks!
<?php
$text = ob_get_clean();