<?php
include PATH."/class/client.class.php";

class dot_functions extends client_functions {

	public function dots() {
		if ($_SESSION['userType'] != 'staff') {
			die;
		}

		$sql = "SELECT `stateID` FROM `state_access` WHERE `userID` = '$_SESSION[id]'";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$dots .= "'$row[stateID]',";
		}
		$dots = substr($dots,0,-1);
		if ($dots == "") {
			$dots = "''";
		}

		$counter = "0";
		$sql = "SELECT `id`,`name`,`logo` FROM `dots` WHERE `active` = 'Yes' AND `stateID` IN ($dots)";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			foreach ($row as $key=>$value) {
				$data['dots'][$counter][$key] = $value;
			}
			$counter++;
		}

		if ($counter == "0") {
			$data['error'] = "1";
		}

		$template = "dots.tpl";
		$dir = "dots";
		$this->load_smarty($data,$template,$dir);
	}

	public function manage_dotOLD() {
		if ($_SESSION['userType'] != 'staff') {
			die;
		}


		$sql = "SELECT `stateID` FROM `state_access` WHERE `userID` = '$_SESSION[id]'";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$dots .= "'$row[stateID]',";
		}
		$dots = substr($dots,0,-1);
		if ($dots == "") {
			$dots = "''";
		}

		$counter = "0";
		$sql = "SELECT `id`,`name`,`logo` FROM `dots` WHERE `active` = 'Yes' AND `stateID` IN ($dots) AND `id` = '$_GET[id]'";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$data['id'] = $row['id'];
			$data['name'] = $row['name'];
			$data['logo'] = $row['logo'];

			$counter++;
		}

		if ($counter == "0") {
			$data['error'] = "1";
		}

		$template = "manage_dot.tpl";
		$dir = "dots";
		$this->load_smarty($data,$template,$dir);
	}

	public function new_dot_project() {

	}

	// new
	public function manage_dot() {
		//$data = null;
		if ($_SESSION['userType'] != 'staff') {
			die;
		}

		$_SESSION['dot_dashboard'] = $_GET['id'];

		$sql = "
		SELECT
			`s`.`stateID`
		FROM
			`state_access` s, `dots` d

		WHERE
			`s`.`userID` = '$_SESSION[id]'
			AND `s`.`stateID` = `d`.`stateID`
			AND `d`.`id` = '$_GET[id]'

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

		$template = "dot_dashboard.tpl";
		$dir = "/dots";
		$this->load_smarty($data,$template,$dir);
	}


}
?>