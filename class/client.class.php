<?php
include PATH."/class/jwt_helper.php";

class client_functions extends JWT {

	public function client() {
		//$data = null;
		if ($_SESSION['userType'] != "client") {
			print "<div class=\"alert alert-danger\">Sorry, you do not have access.</div>";
			die;
		}

		$sql = "
		SELECT
			`s`.`stateID`
		FROM
			`state_access` s

		WHERE
			`s`.`userID` = '$_SESSION[id]'

		LIMIT 1
		";
		$stateID = "0";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$stateID = $row['stateID'];
		}
		if ($stateID == "0") {
			print "<div class=\"alert alert-danger\">Sorry but you do not have any DOTs assigned.</div>";
			die;
		}

		// load DOT
		$sql = "
		SELECT
			`d`.`id` AS 'dotID',
			`d`.`name`,
			`d`.`logo`

		FROM
			`dots` d

		WHERE
			`d`.`stateID` = '$stateID'

		LIMIT 1
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			foreach ($row as $key=>$value) {
				$data[$key] = $value;
			}
			$dotID = $row['dotID'];
		}
		$data['id'] = $dotID;

		// Get reviews
		$year = date("Y");
		$sql = "
		SELECT
			COUNT(`r`.`projectID`) AS 'total'

		FROM
			`projects` p,
			`review` r

		WHERE
			`p`.`dotID` = '$dotID'
			AND `p`.`id` = `r`.`projectID`
			AND DATE_FORMAT(`r`.`date_received`,'%Y') = '$year'
		";
		$total = "0";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$total_reviews = $row['total'];
		}

		// get total comments

		$sql = "
		SELECT
			`r`.*

		FROM
			`projects` p, `review` r

		WHERE
			`p`.`dotID` = '$dotID'
			AND `p`.`id` = `r`.`projectID`
			AND DATE_FORMAT(`r`.`date_received`,'%Y') = '$year'
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$reviewID .= "$row[reviewID],";
		}
		$reviewID = substr($reviewID,0,-1);
		$sql = "
		SELECT COUNT(`Comments`) AS 'total' FROM `xml_data` WHERE `reviewID` IN ($reviewID)
		";


		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$total_comments = $row['total'];
		}

		$len = strlen($total_comments);
		switch ($len) {
			case "1":
			$pre = "000000000";
			break;

			case "2":
			$pre = "00000000";
			break;

			case "3":
			$pre = "0000000";
			break;

			case "4":
			$pre = "000000";
			break;

			case "5":
			$pre = "00000";
			break;

			case "6":
			$pre = "0000";
			break;

			case "7":
			$pre = "000";
			break;

			case "8":
			$pre = "00";
			break;

			case "9":
			$pre = "0";
			break;
		}

		$data['total_comments'] = $pre . $total_comments;

		// get total comments

		@$total_comments_avg = floor($total_comments / $total_reviews);


		$len = strlen($total_comments_avg);
		switch ($len) {
			case "1":
			$pre = "000000000";
			break;

			case "2":
			$pre = "00000000";
			break;

			case "3":
			$pre = "0000000";
			break;

			case "4":
			$pre = "000000";
			break;

			case "5":
			$pre = "00000";
			break;

			case "6":
			$pre = "0000";
			break;

			case "7":
			$pre = "000";
			break;

			case "8":
			$pre = "00";
			break;

			case "9":
			$pre = "0";
			break;
		}

		$data['total_comments_avg'] = $pre . $total_comments_avg;
		// cost savings
		$sql = "
		SELECT
			`r`.`reviewID`,
			`p`.`id`
		FROM
			`projects` p,
			`review` r

		WHERE
			`p`.`dotID` = '$dotID'
			AND `p`.`id` = `r`.`projectID`
			AND DATE_FORMAT(`r`.`date_received`,'%Y') = '$year'
		";
		$total_cost_reduction = "0";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$sql2 = "SELECT DISTINCT `series` FROM `xml_data` WHERE `projectID` = '$row[id]' 
			AND `reviewID` = '$row[reviewID]' ORDER BY `series` DESC LIMIT 1";
			$result2 = $this->new_mysql($sql2);
			while ($row2 = $result2->fetch_assoc()) {
				$series = $row2['series'];
			}

			$sql2 = "
			SELECT
				`x`.`Cost_Reduction`
			FROM
				`xml_data` x

			WHERE
				`x`.`projectID` = '$row[id]'
				AND `x`.`reviewID` = '$row[reviewID]'
				AND `x`.`series` = '$series'
			";
			$result2 = $this->new_mysql($sql2);
			while ($row2 = $result2->fetch_assoc()) {
				$cost_reduction = $row2['Cost_Reduction'];
				$cost_reduction = str_replace("$","",$cost_reduction);
				$cost_reduction = str_replace(",", "", $cost_reduction);
				$total_cost_reduction = $total_cost_reduction + $cost_reduction;
			}
		}
		$data['total_cost_reduction'] = $total_cost_reduction;

		// graph 1
		$category_data = $this->client_dashboard_graphs_category($dotID);
		$category_data1 = $category_data['data1'];
		if(is_array($category_data1)) {
			$total = array_sum($category_data1);
			foreach($category_data1 as $key=>$value) {
				$per = floor(($value / $total) * 100);
				$data1 .= "{name: '$key',y: $per,drilldown: '$key'},";

				$category_data2 = $category_data['data2'][$key];
				$data2 = "";
				if(is_array($category_data2)) {
					$total2 = array_sum($category_data2);
					foreach($category_data2 as $k2=>$v2) {
						$per2 = floor(($v2 / $total2) * 100);
						$data2 .= "['$k2',$per2],";
					}
					$data2 = substr($data2,0,-1);
					$data3 .= "{name: '$key', id: '$key', data: [$data2]},";
				}
			}
			$data1 = substr($data1,0,-1);
			$data3 = substr($data3,0,-1);
		}

		$chart1 = $this->pie_chart_drill('container1',$data1,$data3,'Number of Comments by Category','Click the slices to view Comment Types of each Category.','Categories');
		print "$chart1";


		// graph 2
		$data1 = "";
		$data2 = "";
		$data3 = "";
		$category_data = $this->client_dashboard_graphs_discipline($dotID);
		$category_data1 = $category_data['data1'];
		if(is_array($category_data1)) {
			$total = array_sum($category_data1);
			foreach($category_data1 as $key=>$value) {
				$per = floor(($value / $total) * 100);
				$data1 .= "{name: '$key',y: $per,drilldown: '$key'},";

				$category_data2 = $category_data['data2'][$key];
				$data2 = "";
				if(is_array($category_data2)) {
					$total2 = array_sum($category_data2);
					foreach($category_data2 as $k2=>$v2) {
						$per2 = floor(($v2 / $total2) * 100);
						$data2 .= "['$k2',$per2],";
					}
					$data2 = substr($data2,0,-1);
					$data3 .= "{name: '$key', id: '$key', data: [$data2]},";
				}
			}
			$data1 = substr($data1,0,-1);
			$data3 = substr($data3,0,-1);
		}

		$chart2 = $this->pie_chart_drill('container2',$data1,$data3,'Number of Comments by Discipline','Click the slices to view Categories of each Discipline.','Discipline');
		print "$chart2";

		// graph 3

		$chart3 = $this->combo_chart($dotID);
		print "$chart3";

		// graph 4
		$y = date("Y");
		$title = "$y Year-to-Date Reviews";
		$chart4 = $this->gauge('container4',$title,$total_reviews);
		print "$chart4";

		$template = "client.tpl";
		$dir = "/client";
		$this->load_smarty($data,$template,$dir);
	}

	public function client_load_project() {
		if ($_SESSION['userType'] != "client") {
			print "<div class=\"alert alert-danger\">Sorry, you do not have access.</div>";
			die;
		}
		$sql = "SELECT `id`,`dotproject` FROM `projects` WHERE `dotID` = '$_GET[id]'";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$options .= "<option value=\"$row[id]\">$row[dotproject]</option>";
		}	
		$data['options'] = $options;
		$template = "client_open_project.tpl";
		$dir = "/client";
		$this->load_smarty($data,$template,$dir);	
	}

	public function client_upload_file() {
		if ($_SESSION['userType'] != "client") {
			print "<div class=\"alert alert-danger\">Sorry, you do not have access.</div>";
			die;
		}

		$sql = "SELECT `id`,`dotproject` FROM `projects` WHERE `dotID` = '$_GET[id]'";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$options .= "<option value=\"$row[id]\">$row[dotproject]</option>";
		}	
		$data['options'] = $options;
		$data['dotID'] = $_GET['id'];
		$template = "client_upload_file.tpl";
		$dir = "/client";
		$this->load_smarty($data,$template,$dir);	
	}

	public function save_client_file() {
		if ($_SESSION['userType'] != "client") {
			print "<div class=\"alert alert-danger\">Sorry, you do not have access.</div>";
			die;
		}

		$projectID = $_POST['projectID'];
		$fileName = $_FILES['pdf_file']['name'];
		$tmpName  = $_FILES['pdf_file']['tmp_name'];
		$fileSize = $_FILES['pdf_file']['size'];
		$fileType = $_FILES['pdf_file']['type'];
		if ($fileName != "") {
			$file1 = date("U");
			$file1 .= "_";
			$file1 .= rand(10,100);
			$file1 .= "_.pdf";
			move_uploaded_file($tmpName, "../uploads/$file1");
			$date = date("Ymd");

			$sql = "INSERT INTO `client_files` 
			(`projectID`,`dotID`,`pdf_file_server`,`pdf_file_client`,`date`,`pdf_file_size`,`pdf_file_type`) 
			VALUES 
			('$_POST[projectID]','$_POST[dotID]','$file1','$fileName','$date','$fileSize','$fileType')
			";

			print "<div class=\"alert alert-success\">The PDF file was added. Loading...</div>";
			$result = $this->new_mysql($sql);
			$redirect = "/";
			?>
			<script>
			setTimeout(function() {
				window.location.replace('<?=$redirect;?>')
			}
			,2000);
			</script>
			<?php			
		} else {
			print "<div class=\"alert alert-danger\">You did not select a PDF file. Loading...</div>";
			$result = $this->new_mysql($sql);
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
	}

	public function client_view_project() {
		if ($_SESSION['userType'] != "client") {
			print "<div class=\"alert alert-danger\">Sorry, you do not have access.</div>";
			die;
		}

		$sql = "
		SELECT
			`p`.`id` AS 'projectID',
			`p`.`dotproject`,
			`p`.`subaccount`,
			`p`.`projecttypeID`,
			`p`.`description`,
			`p`.`est_const_cost`,
			`p`.`est_ad_date`,
			`p`.`regionID`,
			`p`.`contactID`,
			`d`.`logo`,
			`d`.`id` AS 'dotID',
			`pt`.`project_type`,
			`r`.`name` AS 'regionName',
			`c`.`first`,
			`c`.`last`

		FROM
			`projects` p

		LEFT JOIN `dots` d ON `p`.`dotID` = `d`.`id`
		LEFT JOIN `project_type` pt ON `p`.`projecttypeID` = `pt`.`id`
		LEFT JOIN `region` r ON `p`.`regionID` = `r`.`id`
		LEFT JOIN `contacts` c ON `p`.`contactID` = `c`.`id`

		WHERE
			`p`.`id` = '$_GET[id]'
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			foreach($row as $key=>$value) {
				$data[$key] = $value;
			}
			$dotID = $row['dotID'];
			$contactID = $row['contactID'];
			$projectID = $row['projectID'];
		}

		// locate reviews
		$sql = "
		SELECT
			`s`.`Description`,
			`r`.`reviewID` AS 'id'
		FROM
			`review` r,
			`SubmittalTypes` s

		WHERE
			`r`.`projectID` = '$projectID'
			AND `r`.`project_phase` = `s`.`id`
		";
		$i = "0";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$r_found = "1";
			foreach ($row as $key=>$value) {
				$data['review'][$i][$key] = $value;
			}
			$i++;
		}
		if ($r_found != "1") {
			$data['r_error'] = "1";
		}


		$template = "client_view_project.tpl";
		$dir = "/projects";
		$this->load_smarty($data,$template,$dir);
	}

	public function client_list_project() {
		if ($_SESSION['userType'] != "client") {
			print "<div class=\"alert alert-danger\">Sorry, you do not have access.</div>";
			die;
		}

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

		$template = "client_list_projects.tpl";
		$dir = "/client";
		$this->load_smarty($data,$template,$dir);
	}

	public function client_search_project() {
		if ($_SESSION['userType'] != "client") {
			print "<div class=\"alert alert-danger\">Sorry, you do not have access.</div>";
			die;
		}

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


		$template = "client_search_project.tpl";
		$dir = "/client";
		$this->load_smarty($data,$template,$dir);
	}

	public function client_view_report() {
		if ($_SESSION['userType'] != "client") {
			print "<div class=\"alert alert-danger\">Sorry, you do not have access.</div>";
			die;
		}

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
		}

		$adata = $_POST;
		unset($adata['section']);
		unset($adata['dotID']);

		if(is_array($adata)) {
			foreach ($adata as $key=>$value) {
				$projectID = substr($key,1);
				$projects .= "'$projectID',";
			}
			$projects = substr($projects,0,-1);

		} else {
			print "<div class=\"alert alert-danger\">You did not select any projects.</div>";
			die;
		}

		// graph 1
		$category_data = $this->client_report_graphs_category($projects);
		$category_data1 = $category_data['data1'];
		if(is_array($category_data1)) {
			$total = array_sum($category_data1);
			foreach($category_data1 as $key=>$value) {
				$per = floor(($value / $total) * 100);
				$data1 .= "{name: '$key',y: $per,drilldown: '$key'},";

				$category_data2 = $category_data['data2'][$key];
				$data2 = "";
				if(is_array($category_data2)) {
					$total2 = array_sum($category_data2);
					foreach($category_data2 as $k2=>$v2) {
						$per2 = floor(($v2 / $total2) * 100);
						$data2 .= "['$k2',$per2],";
					}
					$data2 = substr($data2,0,-1);
					$data3 .= "{name: '$key', id: '$key', data: [$data2]},";
				}
			}
			$data1 = substr($data1,0,-1);
			$data3 = substr($data3,0,-1);
		}

		$chart1 = $this->pie_chart_drill('container1',$data1,$data3,'Number of Comments by Category','Click the slices to view Comment Types of each Category.','Categories');
		print "$chart1";

		// graph 2
		$data1 = "";
		$data2 = "";
		$data3 = "";
		$category_data = $this->client_report_graphs_discipline($projects);
		$category_data1 = $category_data['data1'];
		if(is_array($category_data1)) {
			$total = array_sum($category_data1);
			foreach($category_data1 as $key=>$value) {
				$per = floor(($value / $total) * 100);
				$data1 .= "{name: '$key',y: $per,drilldown: '$key'},";

				$category_data2 = $category_data['data2'][$key];
				$data2 = "";
				if(is_array($category_data2)) {
					$total2 = array_sum($category_data2);
					foreach($category_data2 as $k2=>$v2) {
						$per2 = floor(($v2 / $total2) * 100);
						$data2 .= "['$k2',$per2],";
					}
					$data2 = substr($data2,0,-1);
					$data3 .= "{name: '$key', id: '$key', data: [$data2]},";
				}
			}
			$data1 = substr($data1,0,-1);
			$data3 = substr($data3,0,-1);
		}

		$chart2 = $this->pie_chart_drill('container2',$data1,$data3,'Number of Comments by Discipline','Click the slices to view Categories of each Discipline.','Discipline');
		print "$chart2";

		$template = "client_view_report.tpl";
		$dir = "/client";
		$this->load_smarty($data,$template,$dir);

	}

	public function client_dashboard_graphs_category($dotID) {

		$year = date("Y");
		$sql = "
		SELECT
			`r`.`reviewID`

		FROM
			`projects` p,
			`review` r

		WHERE
			`p`.`dotID` = '$dotID'
			AND `p`.`id` = `r`.`projectID`
			AND DATE_FORMAT(`r`.`date_received`,'%Y') = '$year'
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$review[] = $row['reviewID'];
		}

		$data = array();
		if(is_array($review)) {
			foreach ($review as $k=>$v) {
				$series = "1";
				$sql2 = "SELECT DISTINCT `series` FROM `xml_data` WHERE 
				`reviewID` = '$v' ORDER BY `series` DESC LIMIT 1";
				$result2 = $this->new_mysql($sql2);
				while ($row2 = $result2->fetch_assoc()) {
					$series = $row2['series'];
				}

				$sql2 = "SELECT `Category`,`Comment_Type` FROM `xml_data` WHERE `reviewID` = '$v' AND `series` = '$series'";
				$result2 = $this->new_mysql($sql2);
				while ($row2 = $result2->fetch_assoc()) {
					$category = $row2['Category'];
					$type = $row2['Comment_Type'];
					$data['data1'][$category]++;
					$data['data2'][$category][$type]++;

				}
			}
		}
		return($data);
	}

	private function client_report_graphs_category($projects) {

		$sql = "
		SELECT
			`r`.`reviewID`

		FROM
			`projects` p,
			`review` r

		WHERE
			`p`.`id` IN ($projects)
			AND `p`.`id` = `r`.`projectID`
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$review[] = $row['reviewID'];
		}

		$data = array();
		if(is_array($review)) {
			foreach ($review as $k=>$v) {
				$series = "1";
				$sql2 = "SELECT DISTINCT `series` FROM `xml_data` WHERE 
				`reviewID` = '$v' ORDER BY `series` DESC LIMIT 1";
				$result2 = $this->new_mysql($sql2);
				while ($row2 = $result2->fetch_assoc()) {
					$series = $row2['series'];
				}

				$sql2 = "SELECT `Category`,`Comment_Type` FROM `xml_data` WHERE `reviewID` = '$v' AND `series` = '$series'";
				$result2 = $this->new_mysql($sql2);
				while ($row2 = $result2->fetch_assoc()) {
					$category = $row2['Category'];
					$type = $row2['Comment_Type'];
					$data['data1'][$category]++;
					$data['data2'][$category][$type]++;

				}
			}
		}
		return($data);
	}



	public function client_dashboard_graphs_discipline($dotID) {

		$year = date("Y");
		$sql = "
		SELECT
			`r`.`reviewID`

		FROM
			`projects` p,
			`review` r

		WHERE
			`p`.`dotID` = '$dotID'
			AND `p`.`id` = `r`.`projectID`
			AND DATE_FORMAT(`r`.`date_received`,'%Y') = '$year'
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$review[] = $row['reviewID'];
		}

		$data = array();
		if(is_array($review)) {
			foreach ($review as $k=>$v) {
				$series = "1";
				$sql2 = "SELECT DISTINCT `series` FROM `xml_data` WHERE 
				`reviewID` = '$v' ORDER BY `series` DESC LIMIT 1";
				$result2 = $this->new_mysql($sql2);
				while ($row2 = $result2->fetch_assoc()) {
					$series = $row2['series'];
				}

				$sql2 = "SELECT `Discipline`,`Category` FROM `xml_data` WHERE `reviewID` = '$v' AND `series` = '$series'";
				$result2 = $this->new_mysql($sql2);
				while ($row2 = $result2->fetch_assoc()) {
					$category = $row2['Discipline'];
					$type = $row2['Category'];
					$data['data1'][$category]++;
					$data['data2'][$category][$type]++;

				}
			}
		}
		return($data);
	}

	private function client_report_graphs_discipline($projects) {

		$sql = "
		SELECT
			`r`.`reviewID`

		FROM
			`projects` p,
			`review` r

		WHERE
			`p`.`id` IN ($projects)
			AND `p`.`id` = `r`.`projectID`
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$review[] = $row['reviewID'];
		}

		$data = array();
		if(is_array($review)) {
			foreach ($review as $k=>$v) {
				$series = "1";
				$sql2 = "SELECT DISTINCT `series` FROM `xml_data` WHERE 
				`reviewID` = '$v' ORDER BY `series` DESC LIMIT 1";
				$result2 = $this->new_mysql($sql2);
				while ($row2 = $result2->fetch_assoc()) {
					$series = $row2['series'];
				}

				$sql2 = "SELECT `Discipline`,`Category` FROM `xml_data` WHERE `reviewID` = '$v' AND `series` = '$series'";
				$result2 = $this->new_mysql($sql2);
				while ($row2 = $result2->fetch_assoc()) {
					$category = $row2['Discipline'];
					$type = $row2['Category'];
					$data['data1'][$category]++;
					$data['data2'][$category][$type]++;

				}
			}
		}
		return($data);
	}

}
?>