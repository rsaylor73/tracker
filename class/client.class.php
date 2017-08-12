<?php
include PATH."/class/jwt_helper.php";

class client_functions extends JWT {

	public function client() {
		$data = null;

		$template = "client.tpl";
		$dir = "/client";
		$this->load_smarty($data,$template,$dir);
	}

}
?>