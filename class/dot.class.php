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

	public function manage_dot() {
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

}
?>