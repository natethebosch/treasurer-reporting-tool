<?php
/**
 * @Author: Nate Bosscher (c) 2015
 * @Date:   2016-04-11 10:06:37
 * @Last Modified by:   Nate Bosscher
 * @Last Modified time: 2016-04-12 14:46:43
 */

require_once __DIR__ . "/class.mail-template-helper.php";

/**
 * expects $receipt to the the Receipt for this email
 * expects $link['confirm'] to have a confirm link
 * expects $link['deny'] to have a deny link
 */

$subject = "[Expense Review] " . $receipt->budgetLineItem . " from " . $receipt->submitter;

ob_start();
?><html>
<head></head>
<body style="margin:0;font-family: Roboto, sans-serif;">
	<table style="width:100%;height:400px; border-collapse: collapse;">
		<tbody>
			<tr>
				<td style="background-color: #343A55;"></td><td style="padding: 10px; width: 400px;background-color: #343A55;">
					<h1 style="color: #dabd38; font-size: 20px;margin:0; font-weight: normal;">Please review this receipt</h1>
				</td><td style="background-color: #343A55;"></td>
			</tr><tr>
				<td></td><td style="width:400px;padding: 20px 10px;">
					<?php echo MailTemplateHelper::formatReceiptAsHTML($receipt); ?>
				</td><td></td>
			</tr>
			<tr>
				<td></td><td>
					<a style="display:inline-block; background-color: #3F90DC; border: 1px solid #4C87CA; border-radius: 5px; color: white; padding: 5px 10px; text-decoration:none;" href="<?php echo $links['confirm']; ?>">Confirm</a>
					<a style="display:inline-block; background-color: #3F90DC; border: 1px solid #4C87CA; border-radius: 5px; color: white; padding: 5px 10px; text-decoration:none;" href="<?php echo $links['deny']; ?>">Deny</a>
				</td><td></td>
			</tr>
		</tbody>
	</table>

	<a style="font-size: 12px;color:#343A55;padding: 10px;" href="<?php echo URL_ROOT; ?>/unsubscribe">Unsubscribe</a>

</body>
</html><?php

$html = ob_get_clean();

ob_start();
?>
Please review this receipt.

<?php echo MailTemplateHelper::formatReceiptAsText($receipt); ?>

Confirm: <?php echo $links['confirm'] ?>
Deny: <?php echo $links['deny']; ?>

<?php
$text = ob_get_clean();