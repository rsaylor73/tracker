<?php
session_start();

// init
include_once "include/settings.php";
include_once "include/templates.php";


$check = $core->check_login();
if ($check == "TRUE") {
	$core->save_project();
} else {
    print "<font color=red>Your session has expired. Please log in.</font><br>";
}
?>