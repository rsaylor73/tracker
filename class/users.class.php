<?php
include PATH."/class/common.class.php";

class users_functions extends common_functions {

	public function login() {
		$sql = "
		SELECT 
			`id`,`first`,`last`,`email`,`userType`,`uuname`,`password` 
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