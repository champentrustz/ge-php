<?php

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-alloworigin,
access-control-allow-methods, access-control-allow-headers');

$servername = "localhost";
$username = "root";
$password = "PAssw0rdGESSRU";
$dbname = "ssrulm";

date_default_timezone_set('Asia/Bangkok');

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



$content = file_get_contents("php://input");

$jsonArray = json_decode($content,true);

$studentCode = $jsonArray['studentCode'];
$semester = $jsonArray['semester'];
$year = $jsonArray['year'];

$sql_student = "select * from tb_students where  tb_student_code='".$studentCode."' and tb_student_status='1'";
$result = mysqli_query($conn, $sql_student);
$count = mysqli_num_rows($result);
$studentArray = array();
$studentTime = array();
$studentTimeLate = array();
$studentRule = array();
if($count > 0){
    while ($row = mysqli_fetch_assoc($result)) {
        $sql_student_room = "select * from tb_rooms where  tb_room_id='".$row['tb_student_degree']."' ";
        $result_student_room = mysqli_query($conn, $sql_student_room);
        $row_room = mysqli_fetch_assoc($result_student_room);
        $studentArray[] = $row + $row_room;
    }

    $sql_student_time = "select * from tb_times where  tb_time_stucode='".$studentCode."' and tb_time_type != '1' and tb_time_type_update = '0' and tb_time_semester = '".$semester."' and tb_time_year = '".$year."'";
    $result_student_time = mysqli_query($conn, $sql_student_time);
    while ($row_time = mysqli_fetch_assoc($result_student_time)) {
        $studentTime[] = $row_time;
    }

    $sql_student_time_late = "select * from tb_times where  tb_time_stucode='".$studentCode."' and tb_time_type != '1' and tb_time_type_update = '2' and tb_time_semester = '".$semester."' and tb_time_year = '".$year."'";
    $result_student_time_late = mysqli_query($conn, $sql_student_time_late);
    while ($row_time_late = mysqli_fetch_assoc($result_student_time_late)) {
        $studentTimeLate[] = $row_time_late;
    }

    $sql_student_rule = "select * from tb_rules where  tb_student_code='".$studentCode."' and tb_time_semester = '".$semester."' and tb_time_year = '".$year."'";
    $result_student_rule = mysqli_query($conn, $sql_student_rule);
    while ($row_rule = mysqli_fetch_assoc($result_student_rule)) {
        $sql_student_rule_type = "select * from tb_ruletypes where  tb_ruletype_id='".$row_rule['tb_ruletype_id']."'";
        $result_student_rule_type = mysqli_query($conn, $sql_student_rule_type);
        $row_rule_type = mysqli_fetch_assoc($result_student_rule_type);
        $studentRule[] = $row_rule + $row_rule_type ;
    }



    $studentData = array('data' => $studentArray,
        'time_absent' => $studentTime,
        'time_late' => $studentTimeLate,
        'rule' => $studentRule);

    $studentDataAll  = array();
    $studentDataAll[]  = $studentData;
}



echo json_encode($studentDataAll);

