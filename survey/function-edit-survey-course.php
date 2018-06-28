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
$semester = $_SESSION['semester'];
$year = $_SESSION['year'];
$date = new DateTime();



$sql_survey_course = "select * from survey_course where  survey_id='".$survey_id."'";
$result_survey_course = mysqli_query($conn, $sql_survey_course);
while ($row = mysqli_fetch_assoc($result_survey_course)) {

    $delete = 1;

for($r=0;$r<$numrow;$r++) {


    $checkCourse_i = $checkCourse[$r];
    $stringCourse = (string)$checkCourse_i;
    $courseDetail = explode('-', $stringCourse);

    if($row['course_id'] === $courseDetail[0] && $row['group_id'] === $courseDetail[1] && $row['semester'] === $semester && $row['year'] === $year){
            $delete = 0;
    }


}

if($delete === 1){
    $delete_survey_course = "UPDATE survey_course SET deletedAt='".$date->format('Y-m-d H:i:s')."' WHERE id='".$row['id']."'";
    $conn->query($delete_survey_course);
}

}




for($r=0;$r<$numrow;$r++) {

    $checkCourse_i = $checkCourse[$r];
    $stringCourse = (string)$checkCourse_i;
    $courseDetail = explode('-', $stringCourse);

    $sql_check_course_survey = "SELECT * FROM survey_course WHERE survey_id = '".$survey_id."' and course_id = '".$courseDetail[0]."' and group_id = '".$courseDetail[1]."' and deletedAt is NULL";
    $result_check_course_survey = mysqli_query($conn, $sql_check_course_survey);
    $count = mysqli_num_rows($result_check_course_survey);

    if($count === 0){
        $insert_survey_course = "INSERT INTO survey_course(id,survey_id, course_id, group_id, name, group_name, semester, year, createdAt, updatedAt)VALUES (NULL,'" . $survey_id . "', '" . $courseDetail[0] . "', '" . $courseDetail[1] . "', '" . $courseDetail[2] . "', '" . $courseDetail[3] . "' , '" . $semester . "', '" . $year . "','" . $date->format('Y-m-d H:i:s') . "','" . $date->format('Y-m-d H:i:s') . "')";
        $conn->query($insert_survey_course);
    }


}




?>

<script language='javascript'>
    window.close();
</script>


