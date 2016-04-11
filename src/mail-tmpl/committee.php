<?php
/**
 * @Author: Nate Bosscher (c) 2015
 * @Date:   2016-04-11 10:06:37
 * @Last Modified by:   Nate Bosscher
 * @Last Modified time: 2016-04-11 16:51:55
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
<body>
	<table>
		<tbody>
			<tr>
				<td></td><td style="width: 300px">
					<h1>Please review this receipt.</h1>
				</td><td></td>
			</tr><tr>
				<td></td><td>
					<?php MailTemplateHelper::formatReceiptAsHTML($receipt); ?>
				</td><td></td>
			</tr>
			<tr>
				<td></td><td>
					<a href="<?php echo $links['confirm']; ?>">Confirm</a>
					<a href="<?php echo $links['deny']; ?>">Deny</a>
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
Please review this receipt.

<?php MailTemplateHelper::formatReceiptAsText($receipt); ?>

Confirm: <?php echo $links['confirm'] ?>
Deny: <?php echo $links['deny']; ?>

Thanks!
<?php
$text = ob_get_clean();