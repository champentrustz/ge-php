<?php
setlocale(LC_ALL,'C.UTF-8');
$course_id = $_REQUEST['course_id'];
$course_section = $_REQUEST['course_section'];
$target_dir = "/var/www/ge/upload-file/".$course_id."-".$course_section."/";
if(is_dir($target_dir) == TRUE) {

    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;

    if (file_exists($target_file)) {
        echo "ผิดพลาด! ไฟล์นี้ถูกอัพโหลดบนเซิร์ฟเวอร์อยู่แล้ว";
        $uploadOk = 0;
    }
    if ($uploadOk == 0) {
        echo "ผิดพลาด! ไฟล์ไม่ถูกอัพโหลด";
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            chmod($target_file, 0777);
            echo "สำเร็จ! ไฟล์ " . basename($_FILES["fileToUpload"]["name"]) . " ถูกอัพโหลดเรียบร้อย";
            header("Refresh:2; url=upload-file.php");

        } else {
            echo "ผิดพลาด! พบปัญหาในการอัพโหลดไฟล์";
            header("Refresh:2; url=upload-file.php");
        }
    }
}


else {



    mkdir("/var/www/ge/upload-file/".$course_id."-".$course_section, 0777);
    $target_file = $target_dir. basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;

    if (file_exists($target_file)) {
        echo "ผิดพลาด! ไฟล์นี้ถูกอัพโหลดบนเซิร์ฟเวอร์อยู่แล้ว";
        $uploadOk = 0;
    }

// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "ผิดพลาด! ไฟล์ไม่ถูกอัพโหลด";
// if everything is ok, try to upload filed
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            chmod($target_file, 0777);
            echo "สำเร็จ! ไฟล์ " . basename($_FILES["fileToUpload"]["name"]) . " ถูกอัพโหลดเรียบร้อย";
            header("Refresh:2; url=upload-file.php");


        } else {
            echo "ผิดพลาด! พบปัญหาในการอัพโหลดไฟล์";
            header("Refresh:2; url=upload-file.php");

        }
    }
}


        ?>