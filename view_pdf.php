<?php
session_start();

// init
include_once "include/settings.php";
include_once "include/templates.php";

$check = $core->check_login();
if ($check == "TRUE") {

    $sql = "
    SELECT
        `pdf_file_server`,
        `pdf_file_client`,
        `pdf_file_type`,
        `pdf_file_size`
    FROM
        `review`

    WHERE
        `reviewID` = '$_GET[pdf_file]'
    ";
    $result = $core->new_mysql($sql);
    while ($row = $result->fetch_assoc()) {
        $pdf_file = $row['pdf_file_server'];
        $original_name = $row['pdf_file_client'];
    }

    if(file_exists(ATTACHMENTS.'/'.$pdf_file)) {
        $filename=ATTACHMENTS .'/'.$pdf_file;
        header("Content-type:application/pdf");
        header("Content-Disposition:inline;filename=".basename($original_name));
        header('Content-Length: ' . filesize($filename));
        header("Cache-control: private"); //use this to open files directly                     
        readfile($filename);
    } else {
        header('HTTP/1.0 404 Not Found');
        echo "<h1>404 PDF Not Found or the review does not have a PDF file.</h1>";
        echo "The page that you have requested could not be found.";
    }
} else {
    print "<font color=red>Your session has expired. Please log in.</font><br>";
}
?>