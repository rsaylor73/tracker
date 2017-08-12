<?php
include PATH."/class/dot.class.php";

class common_functions extends dot_functions {

	public function home_page() {

		switch ($_SESSION['userType']){
			case "staff":
				$this->dots();
			break;

			case "client":
				$this->client();
			break;

			default:
			print "<div class=\"alert alert-danger\">Error: your account is not setup.</div>";
			die;
			break;
		}



		/*
		if ($_SESSION['default_state'] == "") {
			$data['alert'] = "1";
		}
		$sql = "SELECT `state` FROM `state` WHERE `state_id` = '$_SESSION[default_state]'";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$data['default_state'] = $row['state'];
		}
		$template = "dashboard.tpl";
		$data['date'] = date("Y");
		$this->load_smarty($data,$template);
		*/
	}

	public function check_permissions($method) {
		switch ($_SESSION['groupID']) {
			case "0":
			print "<div class=\"alert alert-danger\"><b>ERROR:</b>You do not have access.</div>";
			die;
			break;

			// admin
			case "1":
			$access = array('newproject','editproject','projects','deleteproject','review','insertdata','reports','admin');
			break;

			// projects
			case "2":
			$access = array('newproject','editproject','projects','deleteproject','review','insertdata','reports');
			break;

			// reviews
			case "3":
			$access = array('review','insertdata','reports');
			break;

			// reports
			case "4":
			$access = array('reports');
			break;
		}

		$access_granted = "0";
		foreach ($access as $key=>$value) {
			if ($value == $method) {
				$access_granted = "1";
			}
		}
		if ($access_granted == "0") {
			print "<div class=\"alert alert-danger\"><b>ERROR:</b>You do not have access.</div>";
			die;
		}		
	}

	public function return_safe($var) {
		$var = $this
			->linkID
			->escape_string($var);
		return($var);
	}

    public function change_state() {
            $sql = "
            SELECT
                    `state`.`state_id`,
                    `state`.`state`
            FROM
                    `state_access`,`state`
            WHERE
                    `state_access`.`userID` = '$_SESSION[id]'
                    AND `state_access`.`stateID` = `state`.`state_id`
            ORDER BY `state`.`state` ASC
            ";
            $result = $this->new_mysql($sql);
            while ($row = $result->fetch_assoc()) {
                    $options .= "<option value=\"$row[state_id]\">$row[state]</option>";
            }
            if ($options == "") {
                    print "<br><font color=red>ERROR: Please ask an administrator to assign one or more states to your account.</font><br>";
                    die;
            }
            print "
            <h2>Please select your default state to work with:</h2>
            <form action=\"/index.php\" method=\"post\">
            <input type=\"hidden\" name=\"section\" value=\"save_change_state\">
            <div class=\"row top-buffer\">
            <div class=\"col-sm-2\">
            Select Default State: 
            </div>
            <div class=\"col-sm-2\">
            <select name=\"default_state\" class=\"form-control\" required><option selected value=\"\">Select</option>$options</select>
            </div>
            <div class=\"col-sm-2\"><input type=\"submit\" value=\"Save\" class=\"btn btn-primary\"></div>
            </div>
            </form><br>
            ";

    }

    public function save_change_state() {
        $_SESSION['ProjectID'] = "";
        $sql = "UPDATE `users` SET `default_state` = '$_POST[default_state]' WHERE `id` = '$_SESSION[id]'";
        $result = $this->new_mysql($sql);
		$_SESSION['default_state'] = $_POST['default_state'];


		print "<div class=\"alert alert-success\">The default state was updated. Loading...</div>";

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

	public function getSubmittalTypes($id='',$state='') {
		$sql = "
		SELECT
			`id`,`Description`,`category`
		FROM
			`SubmittalTypes` s

		WHERE
			1
			AND `category` = '$state'

		ORDER BY `category` ASC, `Description` ASC
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			if ($category != $row['category']) {
				if ($category != "") {
					$option .= "</optgroup>";
				}
				$option .= "<optgroup label=\"$row[category]\">";
				$category = $row['category'];
			}
			if ($row['id'] == $id) {
				$option .= "<option selected value=\"$row[id]\">$row[Description]</option>";
			} else {
				$option .= "<option value=\"$row[id]\">$row[Description]</option>";
			}
		}
		$option .= "</optgroup>";
		return($option);
	} // getSubmittalTypes($id='')

	public function getProjectTypes($id='') {
		$sql = "
		SELECT
			`id`,`project_type`
		FROM
			`project_type`
		WHERE
			1
		ORDER BY `project_type` ASC
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			if ($row['id'] == $id) {
				$option .= "<option selected value=\"$row[id]\">$row[project_type]</option>";
			} else {
				$option .= "<option value=\"$row[id]\">$row[project_type]</option>";
			}			
		}
		return($option);
	}

	public function getRegion($id='',$state='') {
		$sql = "
		SELECT
			`id`,`name`,`category`
		FROM
			`region`
		WHERE
			1
			AND `category` = '$state'
		ORDER BY `category` ASC,`name` ASC
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			if ($category != $row['category']) {
				if ($category != "") {
					$option .= "</optgroup>";
				}
				$option .= "<optgroup label=\"$row[category]\">";
				$category = $row['category'];
			}
			if ($row['id'] == $id) {
				$option .= "<option selected value=\"$row[id]\">$row[name]</option>";
			} else {
				$option .= "<option value=\"$row[id]\">$row[name]</option>";
			}			
		}
		$option .= "</optgroup>";
		return($option);
	}



} // class common extends core
?>