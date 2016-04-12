<?php
/**
 * @Author: Nate Bosscher (c) 2015
 * @Date:   2016-04-11 10:51:06
 * @Last Modified by:   Nate Bosscher
 * @Last Modified time: 2016-04-12 14:49:19
 */

require_once __DIR__ . "/class.mail-template-helper.php";

/**
 * expects $link to be the admin link
 */

$subject = "Admin Access Link";

ob_start();
?><html>
<head></head>
<body style="margin:0;font-family: Roboto, sans-serif;">
	<table style="width:100%;height:400px; border-collapse: collapse;">
		<tbody>
			<tr>
				<td style="background-color: #343A55;"></td><td style="padding: 10px; width: 400px;background-color: #343A55;">
					<h1 style="color: #dabd38; font-size: 20px;margin:0; font-weight: normal;">
						You can access the admin download panel using this link
					</h1>
				</td><td style="background-color: #343A55;"></td>
			</tr><tr>
				<td></td><td>
					<a href="<?php echo $link; ?>"><?php echo $link; ?></a>
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
You can access the admin download panel using this link. 

<?php echo $link; ?>

Thanks!
<?php
$text = ob_get_clean();