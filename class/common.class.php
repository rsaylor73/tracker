<?php
include PATH."/class/jwt_helper.php";

class common_functions extends JWT {

	public function home_page() {
		$template = "dashboard.tpl";
		$data['date'] = date("Y");
		$this->load_smarty($data,$template);
	}

	public function check_permissions($method) {
		// The following needs to be added to the UI

		// editproject
		// projects	
		// deleteproject
		// review
			
	}

} // class common extends core
?>