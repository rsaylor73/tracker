<?php
include PATH."/class/review.class.php";

class reports_functions extends review_functions {

	public function reports() {
		$this->check_permissions('reports');

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

		$dir = "/report";
		$template = "report.tpl";
		$this->load_smarty($data,$template,$dir);
	} // public function projects()

	public function viewreport() {
		$this->check_permissions('reports');

		$sql = "
		SELECT
			`p`.`id`,
			`p`.`dotproject`,
			`p`.`subaccount`

		FROM
			`projects` p

		WHERE
			`p`.`id` = '$_GET[projectID]'
		";

		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			foreach ($row as $key=>$value) {
				$data[$key] = $value;
			}
		}

		// get category data:
		$sql = "
		SELECT
			DISTINCT `Category`
		
		FROM
			`xml_data`

		WHERE
			`projectID` = '$_GET[projectID]'
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$cat_sql .= "COUNT(CASE WHEN `Category` = '$row[Category]' 
			THEN `Category` END) AS '$row[Category]',";
			$categories[] = $row['Category'];
		}
		$cat_sql = substr($cat_sql, 0,-1);

		$sql = "
		SELECT
			COUNT(`Category`) AS 'total',
			$cat_sql

		FROM
			`xml_data`

		WHERE
			`projectID` = '$_GET[projectID]'
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			foreach ($categories as $key=>$value) {
				$chart_data1 .= "{name: '".$value."',y: ".$row[$value]."},";
			}
		}
		$chart_data1 = substr($chart_data1,0,-1);

		$id = "container_1";
		$data['chart1_id'] = $id;
		$pie_js = $this->pie_chart($id,$chart_data1,'Comment Distributed by Category');
		print "$pie_js";

		$dir = "/report";
		$template = "viewreport.tpl";
		$this->load_smarty($data,$template,$dir);
	}

} // class reports extends admin
?>