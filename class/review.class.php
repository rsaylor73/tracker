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

	public function viewreview() {
		$this->check_permissions('review');

		// ANSI 92
		$sql = "
		SELECT
			`x`.`id`,
			`x`.`projectID`,
			`x`.`Page_Label`,
			`x`.`Page_Index`,
			`x`.`Author`,
			`x`.`Date`,
			`x`.`Creation_Date`,
			`x`.`Comments`,
			`x`.`Category`,
			`x`.`Comment_Type`,
			`x`.`Discipline`,
			`x`.`Importance`,
			`x`.`Cost_Reduction`,
			`p`.`dotproject`,
			`p`.`subaccount`,
			`p`.`pdf_filename`,
			`s`.`Description`

		FROM
			`xml_data` x

		LEFT JOIN `projects` p ON `x`.`projectID` = `p`.`id`
		LEFT JOIN `SubmittalTypes` s ON `p`.`submittalID` = `s`.`id`

		WHERE
			`x`.`projectID` = '$_GET[projectID]'

		ORDER BY `x`.`Date` ASC, `x`.`Category` ASC
		";

        // page numbers
        $url = "/viewreview/$_GET[projectID]/pages/";
        $show_pages = $this->page_numbers($sql,$url);
        if ($_GET['stop'] == "") {
            $stop = "0";
        } else {
            $stop = $_GET['stop'];
        }
        $sql .= " LIMIT $stop,20";
		$data['page_numbers'] = $show_pages;
        

		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			foreach ($row as $key=>$value) {
				$i = $row['id'];
				$data['review_data'][$i][$key] = $value;
			}
			$data['projectID'] = $row['projectID'];
		}

		$template = "viewreview.tpl";
		$dir = "/review";
		$this->load_smarty($data,$template,$dir);

	} // public function viewreview()


} // class reports extends admin
?>