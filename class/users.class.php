<?php
include PATH."/class/common.class.php";

class users_functions extends common_functions {

	public function forgotpassword() {
		$template = "forgotpassword.tpl";
		$this->load_smarty(null,$template);
	}

	public function profile() {
		$sql = "
		SELECT 
			`u`.`first`,
			`u`.`last`,
			`u`.`email`,
			`u`.`uuname`,
			`s`.`state`

		FROM `users` u

		LEFT JOIN `state` s ON `u`.`default_state` = `s`.`state_id`
		
		WHERE 
			`u`.`id` = '$_SESSION[id]'
		";

		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			foreach ($row as $key=>$value) {
				$data[$key] = $value;
			}
		}
		$template = "profile.tpl";
		$this->load_smarty($data,$template);
	}

	public function update_profile() {
		$hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
		if ($_POST['password'] != "") {
			$sql_pw = ",`password` = '$hash'";
		}
		$sql = "UPDATE `users` SET `first` = '$_POST[first]', `last` = '$_POST[last]',
		`email` = '$_POST[email]' $sql_pw WHERE `id` = '$_SESSION[id]'";
		$result = $this->new_mysql($sql);
		print "<div class=\"alert alert-info\">Your profile was updated. Loading...</div>";
		$redirect = "/";
		?>
		<script>
		setTimeout(function() {
			window.location.replace('<?=$redirect;?>')
		}
		,2000);
		</script>
		<?php
	}

	public function resetpw() {
		if ($_POST['go'] == "") {
			$password = $this->randomPassword();
			$hash = password_hash($password, PASSWORD_DEFAULT);
			$sql = "SELECT `id`,`first`,`uuname`,`email` FROM `users` WHERE `email` = '$_POST[email]'";
			$result = $this->new_mysql($sql);
			while ($row = $result->fetch_assoc()) {
				// record found
				$sql2 = "UPDATE `users` SET `password` = '$hash' WHERE `id` = '$row[id]'";
				$result2 = $this->new_mysql($sql2);
				$subj = "Password reset on ".SITE_NAME;
				$body = "$row[first],<br>
				Your online account to ".SITE_NAME." password was reset. To login please visit:<br>
				".SITEURL."<br>
				username: $row[uuname]<br>
				password: $password<br>
				";
				mail($row['email'],$sub,$body,MAILHEADERS);

			}
			print "<div class=\"alert alert-success\">If the email was entered correctly your password should be sent to you.</div><br>";

		} else {
			// nope, this is a robot
		}
	}

	public function randomPassword() {
	    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	    $pass = array(); //remember to declare $pass as an array
	    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	    for ($i = 0; $i < 8; $i++) {
	        $n = rand(0, $alphaLength);
	        $pass[] = $alphabet[$n];
	    }
	    return implode($pass); //turn the array into a string
	}

	public function login() {
		$sql = "
		SELECT 
			`id`,`first`,`last`,`email`,`groupID`,`uuname`,`password`,`userType`
		FROM 
			`users` 
		WHERE 
			`uuname` = '$_POST[uuname]'
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			if (password_verify($_POST['password'], $row['password'])) {
				// login good
				foreach ($row as $key=>$value) {
					$_SESSION[$key] = $value;
				}
				$token = $this->encode(rand(100,5000), MASTER_KEY);
				$expire = date("U");
				$expire = $expire + EXPIRE;
				$sql2 = "UPDATE `users` SET `token` = '$token', `expire` = '$expire' WHERE `id` = '$row[id]'";
				$result2 = $this->new_mysql($sql2);
				$_SESSION['token'] = $token;
				$this->load_smarty(null,'login_msg.tpl');
				?>
                        <script>
                        setTimeout(function() {
                                window.location.replace('/')
                        }
                        ,2000);
                        </script>
                <?php
			} else {
				print '
					<div class="row top-buffer">
						<div class="col-sm-2">&nbsp;</div>
						<div class="col-sm-8">
							<div class="alert alert-danger">Login failed. Loading...</div>
						</div>
						<div class="col-sm-2">&nbsp;</div>
					</div>
				';
				?>
                        <script>
                        setTimeout(function() {
                                window.location.replace('/')
                        }
                        ,2000);
                        </script>
                <?php
			}
		}
	}

	public function check_login() {
		$time = date("U");
		$sql = "
		SELECT 
			`uuname`,`password` 
		FROM 
			`users` 
		WHERE 
			`uuname` = '$_SESSION[uuname]'
			AND `token` = '$_SESSION[token]'
			AND `expire` > '$time'
		";
		$found = "0";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$found = "1";
		}

		if ($_SESSION['uuname'] == "") {
			$found = "0";
		}
		if ($_SESSION['token'] == "") {
			$found = "0";
		}
		switch ($found) {
			case "0":
			return "FALSE";
			break;
			case "1":
			return "TRUE";
			break;
			default:
			return "FALSE";
			break;
		}
	} // public function check_login()

	public function logout() {
		$sql = "UPDATE `users` SET `expire` = '0' WHERE `id` = '$_SESSION[id]'";
		$result = $this->new_mysql($sql);

		$_SESSION = array();

		session_destroy();
		$this->load_smarty(null,'header.tpl');
		$this->load_smarty(null,'logout.tpl');
		?>
		<script>
			setTimeout(function() {
				window.location.replace('index.php')
			}
			,2000);
		</script>
		<?php
	} // public function logout


} // class users extends common
?>