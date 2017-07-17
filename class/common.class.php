<?php
include PATH."/class/jwt_helper.php";

class common_functions extends JWT {

	public function home_page() {
		$template = "dashboard.tpl";
		$data['date'] = date("Y");
		$this->load_smarty($data,$template);
	}

	public function check_permissions($method) {
		switch ($_SESSION['groupID']) {
			case "0":
			print "<div class=\"alert alert-danger\"><b>ERROR:</b>You do not have access.</div>";
			die;
			break;

			// admin
			case "1":
			$access = array('newproject','editproject','projects','deleteproject','review','insertdata','reports','admin');
			break;

			// projects
			case "2":
			$access = array('newproject','editproject','projects','deleteproject','review','insertdata','reports');
			break;

			// reviews
			case "3":
			$access = array('review','insertdata','reports');
			break;

			// reports
			case "4":
			$access = array('reports');
			break;
		}

		$access_granted = "0";
		foreach ($access as $key=>$value) {
			if ($value == $method) {
				$access_granted = "1";
			}
		}
		if ($access_granted == "0") {
			print "<div class=\"alert alert-danger\"><b>ERROR:</b>You do not have access.</div>";
			die;
		}
		// The following needs to be added to the UI

		/*
			admin
			-- all

			projects
			- editproject
			- projects
			- deleteproject
			- review
			- insertdata
			- reports

			reviews
			- review
			- insertdata
			- reports

			reports
			- reports

		*/


		// editproject
		// projects	
		// deleteproject
		// review
		// insertdata
		// reports
		// admin
			
	}

	public function return_safe($var) {
		$var = $this
			->linkID
			->escape_string($var);
		return($var);
	}

} // class common extends core
?>