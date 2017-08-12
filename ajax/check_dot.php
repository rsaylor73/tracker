<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);

//error_reporting(E_ALL);
include "../include/settings.php";
include "../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;

$logged = $core->check_login();
if ($logged == "TRUE") {

	$sql = "
	SELECT
		`dotproject`

	FROM
		`projects`

	WHERE
		`dotID` = '$_GET[dotID]'
	";
	$result = $core->new_mysql($sql);
	while ($row = $result->fetch_assoc()) {
		if ($row['dotproject'] == $_GET['dotproject']) {
			print "<div class=\"alert alert-danger\">The DOT Project # has been used</div>";
		}
	}
}