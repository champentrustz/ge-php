<?php
setlocale(LC_ALL,'C.UTF-8');
$file_name_doc = $_REQUEST['filename'];
$course_id = $_REQUEST['course_id'];
$course_section = $_REQUEST['course_section'];

$file_name = "/var/www/ge/upload-file/".$course_id."-".$course_section."/".$file_name_doc;
if(unlink($file_name)){
    echo "ลบไฟล์สำเร็จ!";
    header("Refresh:2; url=view-file.php");
}
else{
    echo "ลบไฟล์ไม่สำเร็จ! กรุณาลองใหม่อีกครั้ง";
    header("Refresh:2; url=view-file.php");
}

