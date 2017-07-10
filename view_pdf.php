<?php
session_start();

// init
include_once "include/settings.php";
include_once "include/templates.php";

$check = $core->check_login();
if ($check == "TRUE") {
    $pdf_file = $_GET['pdf_file'];
    if(file_exists(ATTACHMENTS.'/'.$pdf_file)) {
        $filename=ATTACHMENTS .'/'.$pdf_file;
        header("Content-type:application/pdf");
        header("Content-Disposition:inline;filename=".basename($filename));
        header('Content-Length: ' . filesize($filename));
        header("Cache-control: private"); //use this to open files directly                     
        readfile($filename);
    } else {
        header('HTTP/1.0 404 Not Found');
        echo "<h1>404 Not Found</h1>";
        echo "The page that you have requested could not be found.";
    }
} else {
    print "<font color=red>Your session has expired. Please log in.</font><br>";
}
?>