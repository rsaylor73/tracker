<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);

//error_reporting(E_ALL);
include "include/settings.php";
include "include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;

// header
$logged = $core->check_login();
if ($logged == "TRUE") {
                $sql = "SELECT `expire` FROM `users` WHERE `id` = '$_SESSION[id]'";
                $result = $core->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
                        $expires = $row['expire'];
                        $time = date("U");
                        $time_left = $expires - $time;
                        $time_left = $time_left - 300;
                        $smarty->assign('counter',$time_left);
                }
        $smarty->assign('name',$_SESSION['first'] . " " . $_SESSION['last']);
        $smarty->assign('logged','yes');
}

// init
$section = "";

if ($_GET['section'] != "") {
        $section = $_GET['section'];
}
if ($_POST['section'] != "") {
        $section = $_POST['section'];
}

switch ($section) {
        default:
        $smarty->display('header.tpl');
        break;
}

if ($section == "login") {
        $core->load_module('login');
} else {
        $check_login = $core->check_login();
        if ($check_login == "FALSE") {
                $smarty->display('login.tpl');
        } else {
                if ($section == "") {
                        $core->load_module('home_page');
                }

                if ($section != "") {
                        $core->load_module($section);
                }
        }
}

switch ($section) {
        default:
        $date = date("Y");
        $smarty->assign('date',$date);
        $smarty->display('footer.tpl');
        break;
}
?>