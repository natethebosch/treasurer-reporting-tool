<?php
/**
 * @Author: Nate Bosscher (c) 2015
 * @Date:   2016-04-11 10:51:06
 * @Last Modified by:   Nate Bosscher
 * @Last Modified time: 2016-04-11 16:51:58
 */

require_once __DIR__ . "/class.mail-template-helper.php";

/**
 * expects $link to be the admin link
 */

$subject = "Admin Access Link";

ob_start();
?><html>
<head></head>
<body>
	<table>
		<tbody>
			<tr>
				<td></td><td style="width: 300px">
					<h1>You can access the admin download panel using this link</h1>
				</td><td></td>
			</tr><tr>
				<td></td><td>
					<a href="<?php echo $link; ?>"><?php echo $link; ?></a>
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
You can access the admin download panel using this link. 

<?php echo $link; ?>

Thanks!
<?php
$text = ob_get_clean();