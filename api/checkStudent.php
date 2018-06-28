<?php

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-alloworigin,
access-control-allow-methods, access-control-allow-headers');

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



$content = file_get_contents("php://input");

$jsonArray = json_decode($content,true);

$teacherDegree = $jsonArray['teacherDegree'];

$course_id = $jsonArray['course_id'];
$course_section = $jsonArray['course_section'];
$course_start = $jsonArray['course_start'];
$course_end = $jsonArray['course_end'];
$course_date = $jsonArray['course_date'];


$check_sql="SELECT * FROM course_checkstudent WHERE courseID = '".$course_id."' and section = '".$course_section."' and checkinDate LIKE  '%{$course_date}%'";
$query_check=mysqli_query($conn,$check_sql);
$i = 1;
$checkArray = array();
while($fetch_check=mysqli_fetch_assoc($query_check)){

    $checkStart = substr($fetch_check['checkinDate'],'10','6');


    if(strtotime($checkStart) >= strtotime($course_start) && strtotime($checkStart) <= strtotime($course_end)) {

        $checkArray[] = $fetch_check;

    }
}


echo json_encode($checkArray);

