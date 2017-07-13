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

		if ($_GET['projectID'] != "") {
			$projectID = $_GET['projectID'];
		}
		if ($_POST['projectID'] != "") {
			$projectID = $_POST['projectID'];
		}

		if ($_POST['Page_Label'] != "") {
			$s="1";
			$Page_Label = "AND `x`.`Page_Label` LIKE '%$_POST[Page_Label]%'";
		}
		if ($_POST['Page_Index'] != "") {
			$s="1";
			$Page_Index = "AND `x`.`Page_Index` LIKE '%$_POST[Page_Index]%'";
		}
		if ($_POST['Author'] != "") {
			$s="1";
			$Author = "AND `x`.`Author` LIKE '%$_POST[Author]%'";
		}
		if ($_POST['Date'] != "") {
			$s="1";
			$Date = "AND `x`.`Date` LIKE '%$_POST[Date]%'";
		}
		if ($_POST['Creation_Date'] != "") {
			$s="1";
			$Creation_Date = "AND `x`.`Creation_Date` LIKE '%$_POST[Creation_Date]%'";
		}
		if ($_POST['Comments'] != "") {
			$s="1";
			$Comments = "AND `x`.`Comments` LIKE '%$_POST[Comments]%'";
		}
		if ($_POST['Category'] != "") {
			$s="1";
			$Category = "AND `x`.`Category` LIKE '%$_POST[Category]%'";
		}
		if ($_POST['Comment_Type'] != "") {
			$s="1";
			$Comment_Type = "AND `x`.`Comment_Type` LIKE '%$_POST[Comment_Type]%'";
		}
		if ($_POST['Discipline'] != "") {
			$s="1";
			$Discipline = "AND `x`.`Discipline` LIKE '%$_POST[Discipline]%'";
		}
		if ($_POST['Importance'] != "") {
			$s="1";
			$Importance = "AND `x`.`Importance` LIKE '%$_POST[Importance]%'";
		}
		if ($_POST['Cost_Reduction'] != "") {
			$s="1";
			$Cost_Reduction = "AND `x`.`Cost_Reduction` LIKE '%$_POST[Cost_Reduction]%'";
		}

		switch ($_GET['field']) {

			case "Page_Label":
				$order = "ORDER BY `x`.`$_GET[field]` $_GET[direction]";
				$url2 = "/$_GET[field]/$_GET[direction]";
			break;

			case "Page_Index":
				$order = "ORDER BY `x`.`$_GET[field]` $_GET[direction]";
				$url2 = "/$_GET[field]/$_GET[direction]";
			break;

			case "Author":
				$order = "ORDER BY `x`.`$_GET[field]` $_GET[direction]";
				$url2 = "/$_GET[field]/$_GET[direction]";
			break;

			case "Date":
				$order = "ORDER BY `x`.`$_GET[field]` $_GET[direction]";
				$url2 = "/$_GET[field]/$_GET[direction]";
			break;

			case "Creation_Date":
				$order = "ORDER BY `x`.`$_GET[field]` $_GET[direction]";
				$url2 = "/$_GET[field]/$_GET[direction]";
			break;

			case "Comments":
				$order = "ORDER BY `x`.`$_GET[field]` $_GET[direction]";
				$url2 = "/$_GET[field]/$_GET[direction]";
			break;

			case "Category":
				$order = "ORDER BY `x`.`$_GET[field]` $_GET[direction]";
				$url2 = "/$_GET[field]/$_GET[direction]";
			break;

			case "Comment_Type":
				$order = "ORDER BY `x`.`$_GET[field]` $_GET[direction]";
				$url2 = "/$_GET[field]/$_GET[direction]";
			break;

			case "Discipline":
				$order = "ORDER BY `x`.`$_GET[field]` $_GET[direction]";
				$url2 = "/$_GET[field]/$_GET[direction]";
			break;

			case "Importance":
				$order = "ORDER BY `x`.`$_GET[field]` $_GET[direction]";
				$url2 = "/$_GET[field]/$_GET[direction]";
			break;

			case "Cost_Reduction":
				$order = "ORDER BY `x`.`$_GET[field]` $_GET[direction]";
				$url2 = "/$_GET[field]/$_GET[direction]";
			break;


			default:
			$order = "ORDER BY `x`.`Date` ASC, `x`.`Category` ASC";
			break;
		}
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
			1
			AND `x`.`projectID` = '$projectID'
			$Page_Label
			$Page_Index
			$Author
			$Date
			$Creation_Date
			$Comments
			$Category
			$Comment_Type
			$Discipline
			$Importance
			$Cost_Reduction



		$order
		";

		//print "$sql<br>";

        // page numbers
        if ($s!="1") {
        	$url = "/viewreview/$projectID/pages/";
	        $show_pages = $this->page_numbers($sql,$url,$url2);
	        if ($_GET['stop'] == "") {
	            $stop = "0";
	        } else {
	            $stop = $_GET['stop'];
	        }
	        $sql .= " LIMIT $stop,20";
			$data['page_numbers'] = $show_pages;
		}
        

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