<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);

//error_reporting(E_ALL);
include "../include/settings.php";
include "../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;

$logged = $core->check_login();
if ($logged == "TRUE") {
	$sql = "SELECT `id`,`first`,`last` FROM `agency_contacts` WHERE `agencyID` = '$_GET[agencyID]' AND `active` = 'Yes'";
	$result = $core->new_mysql($sql);
	$option = "<option value=\"\">Select</option>";
	while ($row = $result->fetch_assoc()) {
		$option .= "<option value=\"$row[id]\">$row[first] $row[last]</option>";
		$found = "1";
	}
	if ($found != "1") {
		$option = "<option value=\"\">Error: none found</option>";
	}

	?>
	<select name="contactID" class="form-control" onchange="release_button()" required>
	<?=$option;?>
	</select>

	<?php
}
?>