<?php
include PATH."/class/users.class.php";

class admin_functions extends users_functions {

	public function users() {
		$this->check_permissions('admin');
		$sql = "
		SELECT
			`u`.`id`,
			`u`.`first`,
			`u`.`last`,
			`u`.`email`,
			`u`.`groupID`,
			`g`.`group_name`

		FROM 
			`users` u

		LEFT JOIN `groups` g ON `u`.`groupID` = `g`.`id`

		WHERE 1

		ORDER BY `u`.`last` ASC, `u`.`first` ASC
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$id = $row['id'];
			foreach ($row as $key=>$value) {
				$data['users'][$id]['id'] = $row['id'];
				$data['users'][$id]['username'] = $row['username'];
				$data['users'][$id]['first'] = $row['first'];
				$data['users'][$id]['last'] = $row['last'];
				$data['users'][$id]['email'] = $row['email'];
				$data['users'][$id]['group_name'] = $row['group_name'];
			}
		}
		$dir = "/admin";
		$template = "users.tpl";
		$this->load_smarty($data,$template,$dir);		
	}

	public function edituser() {
		$this->check_permissions('admin');

		$sql = "
		SELECT
			`u`.`id`,
			`u`.`first`,
			`u`.`last`,
			`u`.`email`,
			`u`.`uuname`,
			`u`.`groupID`,
			`g`.`group_name`

		FROM 
			`users` u

		LEFT JOIN `groups` g ON `u`.`groupID` = `g`.`id`

		WHERE
			`u`.`id` = '$_GET[id]'
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			foreach ($row as $key=>$value) {
				$data[$key] = $value;
			}
		}
		$dir = "/admin";
		$template = "editusers.tpl";
		$this->load_smarty($data,$template,$dir);	
	}

	public function deleteuser() {
		$this->check_permissions('admin');
		$sql = "DELETE FROM `users` WHERE `id` = '$_GET[id]'";
		$result = $this->new_mysql($sql);
		if ($result == "TRUE") {
			print "<div class=\"alert alert-success\">The user was delete. Loading...</div>";
		} else {
			print "<div class=\"alert alert-danger\">The new user failed to delete. Loading...</div>";
		}
		$redirect = "/users";
		?>
		<script>
		setTimeout(function() {
			window.location.replace('<?=$redirect;?>')
		}
		,2000);
		</script>
		<?php		

	}

	public function newuser() {
		$this->check_permissions('admin');
		$dir = "/admin";
		$template = "newuser.tpl";
		$this->load_smarty(null,$template,$dir);
	}

	public function saveuser() {
		$this->check_permissions('admin');
		$password = $_POST['password'];
		$hash = password_hash($password, PASSWORD_DEFAULT);
		$sql = "INSERT INTO `users` 
		(`uuname`,`password`,`first`,`last`,`email`,`groupID`)
		VALUES
		('$_POST[uuname]','$hash','$_POST[first]','$_POST[last]','$_POST[email]','$_POST[groupID]')
		";
		$result = $this->new_mysql($sql);
		if ($result == "TRUE") {
			print "<div class=\"alert alert-success\">The new user was created and an email was sent. Loading...</div>";
			$subj = "Welcome $_POST[first] $_POST[last] to ".SITE_NAME;
			$body = "$_POST[first],<br>
			Your online account to ".SITE_NAME." was just created. To get started please visit:<br>
			".SITEURL."<br>
			username: $_POST[uuname]<br>
			password: $password<br>
			";
			mail($_POST['email'],$sub,$body,MAILHEADERS);

		} else {
			print "<div class=\"alert alert-danger\">The new user failed to create. Loading...</div>";
		}
		$redirect = "/users";
		?>
		<script>
		setTimeout(function() {
			window.location.replace('<?=$redirect;?>')
		}
		,2000);
		</script>
		<?php
	}

	public function updateuser() {
		$this->check_permissions('admin');
		$password = $_POST['password'];
		$hash = password_hash($password, PASSWORD_DEFAULT);
		if ($_POST['password'] != "") {
			$sql_pw = ",`password` = '$hash'";
		}
		$sql = "UPDATE `users` SET `first` = '$_POST[first]', `last` = '$_POST[last]', 
		`email` = '$_POST[email]' $sql_pw WHERE `id` = '$_POST[id]'";
		$result = $this->new_mysql($sql);
		if ($result == "TRUE") {
			print "<div class=\"alert alert-success\">The user was updated. Loading...</div>";
		} else {
			print "<div class=\"alert alert-danger\">The new user failed to update. Loading...</div>";
		}
		$redirect = "/users";
		?>
		<script>
		setTimeout(function() {
			window.location.replace('<?=$redirect;?>')
		}
		,2000);
		</script>
		<?php
	}

} // class admin extends users
?>