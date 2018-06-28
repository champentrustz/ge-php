<?php
setlocale(LC_ALL,'C.UTF-8');
$file_name_doc = $_REQUEST['filename'];
$course_id = $_REQUEST['course_id'];
$course_section = $_REQUEST['course_section'];

$file_name = "/var/www/ge/upload-file/".$course_id."-".$course_section."/".$file_name_doc;


    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file_name).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file_name));
    readfile($file_name);
    exit;

?>