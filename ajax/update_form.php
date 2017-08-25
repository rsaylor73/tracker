<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../include/settings.php";
include "../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {

	switch ($_GET['label']) {
		case "Project #":
		$sql = "UPDATE `projects` SET `dotproject` = '$_GET[dotproject]' WHERE `id` = '$_GET[projectID]'";
		break;

		case "Sub Account":
		$sql = "UPDATE `projects` SET `subaccount` = '$_GET[subaccount]' WHERE `id` = '$_GET[projectID]'";
		break;

		case "projecttypeID": // view project
		$sql = "UPDATE `projects` SET `projecttypeID` = '$_GET[projecttypeID]' WHERE `id`= ' $_GET[projectID]'";
		break;

		case "description": // view project
		$sql = "UPDATE `projects` SET `description` = '$_GET[description]' WHERE `id` = '$_GET[projectID]'";
		break;

		case "est_const_cost": // view project
		$sql = "UPDATE `projects` SET `est_const_cost` = '$_GET[est_const_cost]' WHERE `id` = '$_GET[projectID]'";
		break;

		case "est_ad_date": // view project
		$sql = "UPDATE `projects` SET `est_ad_date` = '$_GET[est_ad_date]' WHERE `id` = '$_GET[projectID]'";
		break;

		case "regionID": // view project
		$sql = "UPDATE `projects` SET `regionID` = '$_GET[regionID]' WHERE `id` = '$_GET[projectID]'";
		break;

		case "contactID": // view project
		$sql = "UPDATE `projects` SET `contactID` = '$_GET[contacts]' WHERE `id` = '$_GET[projectID]'";
		break;

		case "Project Phase":
		$sql = "UPDATE `review` SET `project_phase` = '$_GET[project_phase]' WHERE `reviewID` = '$_GET[reviewID]'";
		break;

		case "Review Type":
		$sql = "UPDATE `review` SET `review_type` = '$_GET[review_type]' WHERE `reviewID` = '$_GET[reviewID]'";
		break;

		case "Date Received":
		$sql = "UPDATE `review` SET `date_received` = '$_GET[date_received]' WHERE `reviewID` = '$_GET[reviewID]'";
		break;

		case "Date Completed":
		$sql = "UPDATE `review` SET `date_completed` = '$_GET[date_completed]' WHERE `reviewID` = '$_GET[reviewID]'";
		break;

	}
	$result = $core->new_mysql($sql);
	if ($result == "TRUE") {
		?>
		<div class="alert alert-success" id="success-alert"><?=$_GET['label']?> has been updated.</div>

		<script>
		$(document).ready (function(){
			$("#success-alertNO").alert();
	        $("#success-alertNO").fadeTo(2000, 500).slideUp(500, function(){
	        	$("#success-alertNO").slideUp(500);
	        	});
		});
		</script>
		<?php
	} else {
		?>
		<div class="alert alert-danger" id="danger-alert"><?=$_GET['label']?> failed to updated.</div>

		<script>
		$(document).ready (function(){
			$("#danger-alertNO").alert();
	        $("#danger-alertNO").fadeTo(2000, 500).slideUp(500, function(){
	        	$("#danger-alertNO").slideUp(500);
	        	});
		});
		</script>
		<?php
	}
}