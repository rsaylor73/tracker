<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);

//error_reporting(E_ALL);
include "../include/settings.php";
include "../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;

$logged = $core->check_login();
if ($logged == "TRUE") {

	$new_agency = $linkID->escape_string($_GET['new_agency']);
	$first = $linkID->escape_string($_GET['first']);
	$last = $linkID->escape_string($_GET['last']);
	$email = $linkID->escape_string($_GET['email']);
	$phone = $linkID->escape_string($_GET['phone']);

	$sql = "INSERT INTO `agency` (`name`,`active`) VALUES ('$new_agency','Yes')";
	$result = $core->new_mysql($sql);

	$id = $linkID->insert_id;

	$sql = "INSERT INTO `agency_contacts` 
		(`agencyID`,`first`,`last`,`email`,`phone`,`active`)
	VALUES
		('$id','$first','$last','$email','$phone','Yes')
	";
	$result = $core->new_mysql($sql);
	$id2 = $linkID->insert_id;

	// get agencts
	$sql = "SELECT `id`,`name` FROM `agency` WHERE `active` = 'Yes' ORDER BY `name` ASC";
	$result = $core->new_mysql($sql);
	while ($row = $result->fetch_assoc()) {
		if ($row['id'] == $id) {
			$options .= "<option selected value=\"$row[id]\">$row[name]</option>";
		} else {
			$options .= "<option value=\"$row[id]\">$row[name]</option>";
		}
	}

	// get contacts
	$sql = "SELECT `id`,`first`,`last` FROM `agency_contacts` WHERE `agencyID` = '$id' ORDER BY `last` ASC, `first` ASC
	";
	$result = $core->new_mysql($sql);
	while ($row = $result->fetch_assoc()) {
		if ($row['id'] == $id2) {
			$options2 .= "<option selected value=\"$row[id]\">$row[first] $row[last]</option>";
		} else {
			$options2 .= "<option value=\"$row[id]\">$row[first] $row[last]</option>";
		}
	}

	?>
	<div class="row top-buffer">
 		<div class="col-sm-3">Agency:</div>
 		<div class="col-sm-3">
 			<select name="agencyID" class="form-control" onchange="get_contacts(this.form)">
 			<?=$options;?>
 			</select>
 		</div>
 		<div class="col-sm-3">Contact:</div>
 		<div class="col-sm-3" id="contacts">
 			<select name="contactID" class="form-control" onchange="release_button()">
 			<?=$options2;?>
 			</select>
 		</div>
 	</div>
 	<script>document.getElementById('s1').disabled = false;</script>

	<?php

}
?>