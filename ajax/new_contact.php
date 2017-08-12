<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);

//error_reporting(E_ALL);
include "../include/settings.php";
include "../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;

$logged = $core->check_login();
if ($logged == "TRUE") {

	?>
	<form name="myform2">
	<input type="hidden" name="dotID" value="<?=$_GET['dotID']?>">
	<div class="row top-buffer">
		<div class="col-sm-6">
			<input type="text" name="first" placeholder="First Name" class="form-control">
		</div>
		<div class="col-sm-6">
			<input type="text" name="last" placeholder="Last Name" class="form-control">
		</div>
	</div>
	<div class="row top-buffer">
		<div class="col-sm-6">
			<input type="text" name="email" placeholder="Email" class="form-control">
		</div>
		<div class="col-sm-6">
			<input type="text" name="phone" placeholder="Phone" class="form-control">
		</div>
	</div>
	<div class="row top-buffer">
		<div class="col-sm-12">
			<input type="button" value="Save Contact" onclick="save_contact(this.form)" class="btn btn-primary">
		</div>
	</div>
	</form>

	<script>
	function save_contact(myform) {
		$.get('/ajax/save_contact.php',
		$(myform).serialize(),
		function(php_msg) {
	        $("#contacts").html(php_msg);
		});
	}
	</script>
	<?php
}
?>