<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../include/settings.php";
include "../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {
	$new_time = date("U");
	$new_time = $new_time + EXPIRE;
	$sql = "UPDATE `users` SET `expire` = '$new_time' WHERE `id` = '$_SESSION[id]'";
	$result = $core->new_mysql($sql);
} else {
	print "too bad!";
}
?>