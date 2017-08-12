<?php
include PATH."/class/reports.class.php";

class projects_functions extends reports_functions {

	public function new_project() {

		$sql = "
		SELECT
			`c`.`id`,
			`c`.`first`,
			`c`.`last`,
			`c`.`email`

		FROM
			`dots` d, `contacts` c

		WHERE
			`d`.`id` = '$_GET[id]'
			AND `d`.`stateID` = `c`.`stateID`

		ORDER BY `c`.`last` ASC, `c`.`first` ASC
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$contacts .= "<option value=\"$row[id]\">$row[first] $row[last]</option>";
		}

		$sql = "SELECT `stateID` FROM `dots` WHERE `id` = '$_GET[id]'";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$stateID = $row['stateID'];
		}
		$sql = "SELECT `state` FROM `state` WHERE `state_id` = '$stateID'";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$state = $row['state'];
		}

		$data['projecttype'] = $this->getProjectTypes($projecttypeID);
		$data['region'] = $this->getRegion($regionID,$state);
		$data['contacts'] = $contacts;
		$data['dotID'] = $_GET['id'];
		$template = "newproject.tpl";
		$dir = "/projects";
		$this->load_smarty($data,$template,$dir);
	}


	public function save_project() {
		$this->check_permissions('newproject');

		// insert into DB
		foreach ($_POST as $key=>$value) {
			switch($key) {
				case "dotproject":
				case "subaccount":
				case "description":
				case "projecttypeID":
				case "est_const_cost":
				case "est_ad_date":
				case "date_received":
				case "date_completed":
				case "contacts":
				case "regionID":
				case "dotID":
				$p[$key] = $this->linkID->escape_string($value);
				break;
			}
		}

		$sql = "
		INSERT INTO `projects` 
		(`dotproject`,`subaccount`,`projecttypeID`,
		`est_const_cost`,`est_ad_date`,
		`contactID`,`regionID`,`description`,`dotID`)
		VALUES
		('$p[dotproject]','$p[subaccount]','$p[projecttypeID]',
		'$p[est_const_cost]','$p[est_ad_date]',
		'$p[contacts]','$p[regionID]','$p[description]','$p[dotID]')
		";

		$result = $this->new_mysql($sql);
		$projectID = $this->linkID->insert_id;
		//$this->process_xml($projectID);
		$redirect = "/dots/$_POST[dotID]";
		print '<div class="alert alert-success">The project was created. Loading...</div>';
		?>
		<script>
		setTimeout(function() {
			window.location.replace('<?=$redirect;?>')
		}
		,2000);
		</script>
		<?php
	}




} // class projects extends reports
?>