<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);

//error_reporting(E_ALL);
include "../include/settings.php";
include "../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;

$logged = $core->check_login();
if ($logged == "TRUE") {

	$sql = "SELECT `stateID` FROM `dots` WHERE `id` = '$_GET[dotID]'";
	$result = $core->new_mysql($sql);
	while ($row = $result->fetch_assoc()) {
		$stateID = $row['stateID'];
	}

	$sql = "INSERT INTO `contacts` (`stateID`,`first`,`last`,`email`,`phone`) VALUES
	('$stateID','$_GET[first]','$_GET[last]','$_GET[email]','$_GET[phone]')
	";
	$result = $core->new_mysql($sql);

	$sql = "
	SELECT
		`c`.`id`,
		`c`.`first`,
		`c`.`last`,
		`c`.`email`

	FROM
		`dots` d, `contacts` c

	WHERE
		`d`.`id` = '$_GET[dotID]'
		AND `d`.`stateID` = `c`.`stateID`

	ORDER BY `c`.`last` ASC, `c`.`first` ASC
	";
	$result = $core->new_mysql($sql);
	while ($row = $result->fetch_assoc()) {
		$contacts .= "<option value=\"$row[id]\">$row[first] $row[last]</option>";
	}

	?>
 	<div class="row top-buffer">
 		<div class="col-sm-6">Contact:</div>
 		<div class="col-sm-4" id="contacts">
            <select name="contacts" class="form-control"><?=$contacts?></select>
        </div>
        <div class="col-sm-2"><input type="button" value="Add New" onclick="new_contact(this.form)" class="btn btn-primary"></div>
    </div>
    <?php
}
