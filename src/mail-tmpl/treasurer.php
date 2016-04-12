<?php
/**
 * @Author: Nate Bosscher (c) 2015
 * @Date:   2016-04-11 10:24:38
 * @Last Modified by:   Nate Bosscher
 * @Last Modified time: 2016-04-12 14:48:47
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
<body style="margin:0;font-family: Roboto, sans-serif;">
	<table style="width:100%;height:400px; border-collapse: collapse;">
		<tbody>
			<tr>
				<td style="background-color: #343A55;"></td><td style="padding: 10px; width: 400px;background-color: #343A55;">
					<h1 style="color: #dabd38; font-size: 20px;margin:0; font-weight: normal;">
						This reciept has been <?php echo $textStatus; ?></h1>
				</td><td style="background-color: #343A55;"></td>
			</tr><tr>
				<td></td><td>
					<?php echo MailTemplateHelper::formatReceiptAsHTML($receipt); ?>
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

	<a style="font-size: 12px;color:#343A55;padding: 10px;" href="<?php echo URL_ROOT; ?>/unsubscribe">Unsubscribe</a>

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