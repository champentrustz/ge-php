<?php
$servername = "localhost";
$username = "root";
$password = "PAssw0rdGESSRU";
$dbname = "ssrulm";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$check_id = $_REQUEST['check_id'];
$remark = $_REQUEST['remark'];
$status = $_REQUEST['status'];
$teacher_id = $_REQUEST['teacher_id'];
$date = new DateTime();


$update_check = "UPDATE course_checkstudent SET note='".$remark."', status = '".$status."', teacherID = '".$teacher_id."' WHERE ID='".$check_id."'";

$conn->query($update_check);


?>

<script language="javascript">window.history.back();</script>

