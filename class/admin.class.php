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
			`u`.`userType`,
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
				$data['users'][$id]['userType'] = $row['userType'];
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
			`u`.`userType`,
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
		(`uuname`,`password`,`first`,`last`,`email`,`groupID`,`userType`)
		VALUES
		('$_POST[uuname]','$hash','$_POST[first]','$_POST[last]','$_POST[email]','$_POST[groupID]',
		'$_POST[userType]')
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
		`email` = '$_POST[email]', `userType` = '$_POST[userType]', `groupID` = '$_POST[groupID]'
		 $sql_pw WHERE `id` = '$_POST[id]'";
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

    public function user_states() {
		$this->check_permissions('admin');

        $sql = "SELECT * FROM `users` WHERE `id` = '$_GET[id]'";
        $result = $this->new_mysql($sql);
        $row = $result->fetch_assoc();
        print "<h2><a href=\"/users\">Users</a> : DOTs Access : $row[first] $row[last]</h2>
        <form action=\"/index.php\" method=\"post\">
        <input type=\"hidden\" name=\"id\" value=\"$_GET[id]\">
        <input type=\"hidden\" name=\"section\" value=\"state_access\">
        <table class=\"table\">
        <tr>
                <td><b>State</b></td><td><b>Enabled</b></td>
                <td><b>State</b></td><td><b>Enabled</b></td>
        </tr>";

        $sql2 = "
        SELECT 
        	s.* 

        FROM 
        	`state` s, `dots` d

        WHERE 
        	`s`.`state_id` = `d`.`stateID`

        ORDER BY `state` ASC";
        $result2 = $this->new_mysql($sql2);
        while ($row2 = $result2->fetch_assoc()) {

			if ($counter == "0") {
	            $x++;
	            if ($x % 2) {
	                    $bgcolor="bgcolor=#C0C0C0";
	            } else {
	                    $bgcolor="bgcolor=#FFFFFF";
	            }


	            print "<tr $bgcolor>";
			}
			$counter++;


	        print "<td>$row2[state]</td>";
	        $sql3 = "SELECT `access` FROM `state_access` WHERE `state_access`.`stateID` = '$row2[state_id]' AND `state_access`.`userID` = '$_GET[id]'";
	        $result3 = $this->new_mysql($sql3);
	        $checked = "";
	        while ($row3 = $result3->fetch_assoc()) {
	                if ($row3['access'] == "Yes") {
	                        $checked = "checked";
	                }
	        }
	        print "<td><input type=\"checkbox\" name=\"state_$row2[state_id]\" value=\"checked\" $checked></td>";

	        if ($counter == "2") {
	                print "</tr>";
	                $counter = "0";
	        }
	    }
		print "<tr><td colspan=2><input type=\"submit\" class=\"btn btn-primary\" value=\"Save\"></td></tr>";
		print "</table></form>";
    }

    public function state_access() {
		$this->check_permissions('admin');

        $sql = "DELETE FROM `state_access` WHERE `userID` = '$_POST[id]'";
        $result = $this->new_mysql($sql);

        $sql2 = "SELECT * FROM `state` ORDER BY `state` ASC";
        $result2 = $this->new_mysql($sql2);


        while ($row2 = $result2->fetch_assoc()) {
            $i = "state_";
            $i .= $row2['state_id'];
            $check = $_POST[$i];
            if ($check == "checked") {
                $sql3 = "INSERT INTO `state_access` (`userID`,`stateID`,`access`) VALUES ('$_POST[id]','$row2[state_id]','Yes')";
                $result3 = $this->new_mysql($sql3);
            }
        }
		print "<div class=\"alert alert-success\">The user was updated. Loading...</div>";

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