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
		`r`.`reviewID`,
		`s`.`Description`

	FROM
		`review` r, `SubmittalTypes` s

	WHERE
		`r`.`projectID` = '$_GET[dotproject]'
		AND `r`.`project_phase` = `s`.`id`

	ORDER BY `s`.`Description` ASC
	";
	$result = $core->new_mysql($sql);
	while ($row = $result->fetch_assoc()) {
		$opt .= "<option value=\"$row[reviewID]\">$row[Description]</option>";
	}
	if ($opt == "") {
		$opt = "<option value=\"\">There are none please click Add New Review</option>";
	}
	print '
	<div class="row top-buffer">
		<div class="col-sm-6">Project Phase:</div>
		<div class="col-sm-6">
			<select name="project_phase" id="project_phase" class="form-control" onchange="check_dropdown()">
			<option selected value="">Select</option>
			'.$opt.'
			</select>
		</div>
	</div>	
	';

	?>
	<script>
	function check_dropdown() {

	    var review = $('#project_phase :selected').val();
	    var url = '/review/' + review;
	    window.location.href=url;
	    
	}
	</script>
	<?php
}
?>