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
		$redirect = "/projects/$_POST[dotID]/$projectID";
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

	public function list_project() {
		$this->check_permissions('newproject');

		$sql = "
		SELECT
			`c`.`id`,
			`c`.`first`,
			`c`.`last`,
			`c`.`email`

		FROM
			`dots` d, `contacts` c

		WHERE
			`d`.`id` = '$_GET[dotID]'
			AND `d`.`stateID` = `c`.`stateID`

		ORDER BY `c`.`last` ASC, `c`.`first` ASC
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$contacts .= "<option value=\"$row[id]\">$row[first] $row[last]</option>";
		}

		$sql = "SELECT `stateID` FROM `dots` WHERE `id` = '$_GET[dotID]'";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$stateID = $row['stateID'];
		}
		$sql = "SELECT `state` FROM `state` WHERE `state_id` = '$stateID'";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$state = $row['state'];
		}

		$sql = "SELECT `id`,`dotproject` FROM `projects` WHERE `dotID` = '$_GET[dotID]' ORDER BY `dotproject` ASC";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$dotproject .= "<option value=\"$row[id]\">$row[dotproject]</option>";
		}

		$data['dotproject'] = $dotproject;
		$data['dotID'] = $_GET['dotID'];
		$data['projecttype'] = $this->getProjectTypes($projecttypeID);
		$data['region'] = $this->getRegion($regionID,$state);
		$data['contacts'] = $contacts;

		$year = date("Y");
		$p_year = $year - 1;
		$n_year = $year + 1;

		$year_select = "
		<option>$p_year</option>
		<option>$year</option>
		<option>$n_year</option>
		";
		$data['year_select'] = $year_select;

		$template = "list_projects.tpl";
		$dir = "/projects";
		$this->load_smarty($data,$template,$dir);
	}

	public function search_project() {
		$this->check_permissions('review');

		$sql = "
		SELECT
			`d`.`logo`

		FROM
			`dots` d

		WHERE
			`d`.`id` = '$_POST[dotID]'
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$data['logo'] = $row['logo'];
			$data['dotID'] = $_POST['dotID'];
		}

		// filters
		if ($_POST['region'] != "") {
			$s1 = "AND `r`.`id` = '$_POST[region]'";
		}

		if ($_POST['dotproject'] != "") {
			$s2 = "AND `p`.`id` = '$_POST[dotproject]'";
		}

		if (($_POST['start_date'] != "") && ($_POST['end_date'] != "")) {
			$date1 = date("Y-m-d", strtotime($_POST['start_date']));
			$date2 = date("Y-m-d", strtotime($_POST['end_date']));
			$s3 = "AND `p`.`est_ad_date` BETWEEN '$date1' AND '$date2'";
		}

		if ($_POST['year'] != "") {
			$s4 = "AND DATE_FORMAT(`p`.`est_ad_date`,'%Y') = '$_POST[year]'";
		}

		if ($_POST['quarter'] != "") {
			$year = date("Y");
			switch ($_POST['quarter']) {
				case "1":
					$date1 = $year . "-01-01";
					$date2 = $year . "-03-31";
				break;

				case "2":
					$date1 = $year . "-04-01";
					$date2 = $year . "-06-30";
				break;

				case "3":
					$date1 = $year . "-07-01";
					$date2 = $year . "-09-30";
				break;

				case "4":
					$date1 = $year . "-10-01";
					$date2 = $year . "-12-31";
				break;
			}
			$s4 = "AND `p`.`est_ad_date` BETWEEN '$date1' AND '$date2'";
		}

		if ($_POST['project_type'] != "") {
			$s5 = "AND `p`.`projecttypeID` = '$_POST[project_type]'";
		}

		if ($_POST['contactID'] != "") {
			$s6 = "AND `p`.`contactID` = '$_POST[contactID]'";
		}

		// query data
		$sql = "
		SELECT
			`p`.`id`,
			`p`.`dotproject`,
			`p`.`subaccount`,
			`p`.`projecttypeID`,
			`pt`.`project_type`,
			`p`.`regionID`,
			`r`.`name` AS 'region_name',
			`p`.`description`

		FROM
			`projects` p,
			`project_type` pt,
			`region` r

		WHERE
			`p`.`dotID` = '$_POST[dotID]'
			AND `p`.`projecttypeID` = `pt`.`id`
			AND `p`.`regionID` = `r`.`id`
			$s1
			$s2
			$s3
			$s4
			$s5
			$s6
		";

		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$i = $row['id'];
			foreach ($row as $key=>$value) {
				$data['results'][$i][$key] = $value;
			}
		}


		$template = "search_project.tpl";
		$dir = "/projects";
		$this->load_smarty($data,$template,$dir);
	}

} // class projects extends reports
?>