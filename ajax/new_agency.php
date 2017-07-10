<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);

//error_reporting(E_ALL);
include "../include/settings.php";
include "../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;

$logged = $core->check_login();
if ($logged == "TRUE") {
	print "
	<form name=\"myform2\">
	<div class=\"row top-buffer\">
		<div class=\"col-sm-3\">Type in agency name:</div>
		<div class=\"col-sm-3\">
			<input type=\"text\" name=\"new_agency\" placeholder=\"Agency name\" class=\"form-control\">
		</div>
	</div>
	<div class=\"row top-buffer\">
		<div class=\"col-sm-2\">Type in contact info:</div>
		<div class=\"col-sm-2\">
			<input type=\"text\" name=\"first\" placeholder=\"First Name\" class=\"form-control\">
		</div>
		<div class=\"col-sm-2\">
			<input type=\"text\" name=\"last\" placeholder=\"Last Name\" class=\"form-control\">
		</div>
		<div class=\"col-sm-2\">
			<input type=\"text\" name=\"email\" placeholder=\"Email\" class=\"form-control\">
		</div>
		<div class=\"col-sm-2\">
			<input type=\"text\" name=\"phone\" placeholder=\"Phone\" class=\"form-control\">
		</div>
		<div class=\"col-sm-2\">
			<input type=\"button\" value=\"Save Contact\" class=\"btn btn-success\" 
			onclick=\"save_contact(this.form)\">
		</div>
	</div>
	</form>
	";

	?>
<script>
function save_contact(myform) {
	$.get('/ajax/save_new_agency.php',
	$(myform).serialize(),
	function(php_msg) {
        $("#new_agency").html(php_msg);
	});
}
</script>
	<?php
}
?>