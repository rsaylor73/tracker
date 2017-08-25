<?php
include PATH."/class/review.class.php";

class reports_functions extends review_functions {

	public function view_reportOLD() {
		$this->check_permissions('reports');

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

		$template = "view_report.tpl";
		$dir = "/report";
		$this->load_smarty($data,$template,$dir);

		print "<pre>";
		print_r($_POST);
		print "</pre>";
	}

	public function view_report() {
		$this->check_permissions('reports');

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
		$category_data = $this->report_graphs_category($projects);
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
		$category_data = $this->report_graphs_discipline($projects);
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

		$template = "view_report.tpl";
		$dir = "/report";
		$this->load_smarty($data,$template,$dir);

	}

	private function report_graphs_category($projects) {

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

	private function report_graphs_discipline($projects) {

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

} // class reports extends admin
?>