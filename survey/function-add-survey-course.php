<?php
session_start();
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

$survey_id = $_REQUEST['survey_id'];
$numrow = $_REQUEST['numrow'];
$checkCourse = $_REQUEST['checkCourse'];
$date = new DateTime();
$semester = $_SESSION['semester'];
$year = $_SESSION['year'];


for($r=0;$r<$numrow;$r++) {

    $checkCourse_i = $checkCourse[$r];
    $stringCourse = (string)$checkCourse_i;
    $courseDetail = explode('-', $stringCourse);


    $insert_survey_course = "INSERT INTO survey_course(id,survey_id, course_id, group_id, name, group_name, semester , year,  createdAt, updatedAt)VALUES (NULL,'" . $survey_id . "', '" . $courseDetail[0] . "', '" . $courseDetail[1] . "', '" . $courseDetail[2] . "', '" . $courseDetail[3] . "', '" . $semester . "', '" . $year . "', '" . $date->format('Y-m-d H:i:s') . "','" . $date->format('Y-m-d H:i:s') . "')";
    $conn->query($insert_survey_course);

}




?>

<script language='javascript'>
    window.close();
</script>


