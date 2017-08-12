<?php

// these files are not linked just a place to store code that was not used
// from project changes. Might be usefull in the future.

	private function getAgency($id='') {
		$sql = "
		SELECT
			`id`,
			`name`
		FROM
			`agency` a

		WHERE
			`active` = 'Yes'

		ORDER BY `name` ASC
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			if ($id == $row['id']) {
				$option .= "<option selected value=\"$row[id]\">$row[name]</option>";
			} else {
				$option .= "<option value=\"$row[id]\">$row[name]</option>";
			}
		}
		return($option);
	}

	private function getContacts($agencyID,$contactID) {
		$sql = "SELECT `id`,`first`,`last` FROM `agency_contacts` 
		WHERE `agencyID` = '$agencyID' ORDER BY `last` ASC, `first` ASC
		";
	
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			if ($row['id'] == $contactID) {
				$options .= "<option selected value=\"$row[id]\">$row[first] $row[last]</option>";
			} else {
				$options .= "<option value=\"$row[id]\">$row[first] $row[last]</option>";
			}
		}
		return($options);

	}

	public function deleteproject() {
		$this->check_permissions('deleteproject');
		$sql = "DELETE FROM `projects` WHERE `id` = '$_GET[id]'";
		$result = $this->new_mysql($sql);
		$redirect = "/projects";
		print '<div class="alert alert-success">The project was deleted. Loading...</div>';
		?>
		<script>
		setTimeout(function() {
			window.location.replace('<?=$redirect;?>')
		}
		,2000);
		</script>
		<?php	

	}

	public function update_project() {
		$this->check_permissions('editproject');

		$fileName2 = $_FILES['pdf_file']['name'];
		$tmpName2  = $_FILES['pdf_file']['tmp_name'];
		$fileSize2 = $_FILES['pdf_file']['size'];
		$fileType2 = $_FILES['pdf_file']['type'];

		if ($fileName2 != "") {
			// PDF File Upload
			$file2 = date("U");
			$file2 .= "_";
			$file2 .= rand(10,100);
			$file2 .= "_.pdf";
			move_uploaded_file($tmpName2, "../uploads/$file2");
			$pdf_sql = ",`pdf_filename` = '$file2'";
		}

		foreach ($_POST as $key=>$value) {
			switch($key) {
				case "dotproject":
				case "subaccount":
				case "submittalID":
				case "route":
				case "projecttypeID":
				case "est_const_cost":
				case "est_ad_date":
				case "date_received":
				case "date_completed":
				case "agencyID":
				case "contactID":
				case "regionID":
				$p[$key] = $this->linkID->escape_string($value);
				break;
			}
		}

		$sql = "
		UPDATE `projects` SET 
		`dotproject` = '$p[dotproject]',
		`subaccount` = '$p[subaccount]',
		`submittalID` = '$p[submittalID]',
		`route` = '$p[route]',
		`projecttypeID` = '$p[projecttypeID]',
		`est_const_cost` = '$p[est_const_cost]',
		`est_ad_date` = '$p[est_ad_date]',
		`date_received` = '$p[date_received]',
		`date_completed` = '$p[date_completed]',
		`agencyID` = '$p[agencyID]',
		`contactID` = '$p[contactID]',
		`regionID` = '$p[regionID]'
		$pdf_sql 
		WHERE `id` = '$_POST[id]'
		";

		$result = $this->new_mysql($sql);
		$redirect = "/projects";
		print '<div class="alert alert-success">The project was updated. Loading...</div>';
		?>
		<script>
		setTimeout(function() {
			window.location.replace('<?=$redirect;?>')
		}
		,2000);
		</script>
		<?php
	}

	public function editproject() {
		$this->check_permissions('editproject');

		$sql = "
		SELECT
			`p`.`id`,
			`p`.`dotproject`,
			`p`.`subaccount`,
			`p`.`route`,
			`p`.`est_const_cost`,
			`p`.`est_ad_date`,
			`p`.`date_received`,
			`p`.`date_completed`,
			`p`.`pdf_filename`,
			`p`.`submittalID`,
			`p`.`projecttypeID`,
			`p`.`regionID`,
			`p`.`agencyID`,
			`p`.`contactID`,
			`p`.`pdf_filename`,
			`a`.`name` AS 'agenct_name',
			`c`.`first`,
			`c`.`last`,
			`c`.`email`,
			`c`.`phone`,
			`pt`.`project_type`,
			`s`.`Description`

		FROM
			`projects` p

		LEFT JOIN `agency` a ON `p`.`agencyID` = `a`.`id`
		LEFT JOIN `agency_contacts` c ON `p`.`contactID` = `c`.`id`
		INNER JOIN `project_type` pt ON `p`.`projecttypeID` = `pt`.`id`
		INNER JOIN `SubmittalTypes` s ON `p`.`submittalID` = `s`.`id`

		WHERE
			`p`.`id` = '$_GET[id]'
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			foreach ($row as $key=>$value) {
				$data[$key] = $value;
			}

			$submittalID = $row['submittalID'];
			$projecttypeID = $row['projecttypeID'];
			$regionID = $row['regionID'];
			$agencyID = $row['agencyID'];
			$contactID = $row['contactID'];
		}

		$data['SubmittalTypes'] = $this->getSubmittalTypes($submittalID);
		$data['projecttype'] = $this->getProjectTypes($projecttypeID);
		$data['region'] = $this->getRegion($regionID);
		$data['agency'] = $this->getAgency($agencyID);
		$data['contacts'] = $this->getContacts($agencyID,$contactID);

		$dir = "/projects";
		$template = "editproject.tpl";
		$this->load_smarty($data,$template,$dir);		
	}

	public function OLDprojects() {
		$this->check_permissions('projects');

		// ANSI 92 join
		$sql = "
		SELECT
			`p`.`id`,
			`p`.`dotproject`,
			`p`.`subaccount`,
			`p`.`route`,
			`p`.`est_const_cost`,
			`p`.`est_ad_date`,
			`p`.`date_received`,
			`p`.`date_completed`,
			`a`.`name` AS 'agenct_name',
			`c`.`first`,
			`c`.`last`,
			`c`.`email`,
			`c`.`phone`,
			`pt`.`project_type`,
			`s`.`Description`

		FROM
			`projects` p

		LEFT JOIN `agency` a ON `p`.`agencyID` = `a`.`id`
		LEFT JOIN `agency_contacts` c ON `p`.`contactID` = `c`.`id`
		INNER JOIN `project_type` pt ON `p`.`projecttypeID` = `pt`.`id`
		INNER JOIN `SubmittalTypes` s ON `p`.`submittalID` = `s`.`id`

		WHERE
			1
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$id = $row['id'];
			foreach ($row as $key=>$value) {
				$data['project'][$id][$key] = $value;
			}
		}


		$dir = "/projects";
		$template = "projects.tpl";
		$this->load_smarty($data,$template,$dir);
	} // public function projects()

	public function newproject() {
		$this->check_permissions('newproject');

		$data['SubmittalTypes'] = $this->getSubmittalTypes(null);
		$data['projecttype'] = $this->getProjectTypes(null);
		$data['region'] = $this->getRegion(null);
		$data['agency'] = $this->getAgency(null);
		$dir = "/projects";
		$template = "newproject.tpl";
		$this->load_smarty($data,$template,$dir);
	}

