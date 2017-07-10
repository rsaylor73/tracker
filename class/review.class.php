<?php
include PATH."/class/admin.class.php";

class review_functions extends admin_functions {

	public function review() {
		$this->check_permissions('review');

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


		$dir = "/review";
		$template = "review.tpl";
		$this->load_smarty($data,$template,$dir);
	} // public function projects()


} // class reports extends admin
?>