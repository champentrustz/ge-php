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

$survey_id = $_REQUEST['survey_id'];
$type = $_REQUEST['type'];
$numrow = $_REQUEST['numrow'];
$question = $_REQUEST['question'];
$id = $_REQUEST['primary_id'];
$topic = $_REQUEST['topic'];
$type_radio = $_REQUEST['type-radio'];
$teacher_name = $_REQUEST['teacher_name'];
$semester = $_REQUEST['semester'];
$year = $_REQUEST['year'];

$date = new DateTime();


$update_survey = "UPDATE survey SET topic='".$topic."',teacher_name='".$teacher_name."',type='".$type_radio."', semester='".$semester."', year = '".$year."' WHERE id='$survey_id'";
$conn->query($update_survey);

for($r=0;$r<$numrow;$r++) {

    $question_i = $question[$r];
    $id_i = $id[$r];
    $type_i = $type[$r];
    $update_survey_question = "UPDATE survey_question SET question='$question_i',type='$type_i' WHERE id='$id_i'";

    $conn->query($update_survey_question);


}

session_start();

$_SESSION['semester'] = $semester;
$_SESSION['year'] = $year;


?>
<script language="javascript">window.location.href = 'survey-edit-select-course.php'</script>
