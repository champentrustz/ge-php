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

$survey_course_id = $_SESSION['survey_course_id'];
$student_gender = $_REQUEST['gender'];
$semester = $_SESSION['semester'];
$year = $_SESSION['year'];
$first_name = $_SESSION['first_name'];
$last_name = $_SESSION['last_name'];

$survey_course_sql="SELECT * FROM survey_course WHERE id = '".$survey_course_id."'";
$query_survey_course=mysqli_query($conn,$survey_course_sql);
$fetch_survey_course = mysqli_fetch_assoc($query_survey_course);


if($student_gender == 0){
    $student_gender = "W";
}
else{
    $student_gender = "M";
}
$question_id = $_REQUEST['question_id'];
$numrow = $_REQUEST['numrow'];
$arr_score[] = null;
for($i = 0 ; $i <= $numrow ; $i++){
    $arr_score[$i] = $_REQUEST['score'.$i];
}
$remark = $_REQUEST['remark'];
$student_id = $_REQUEST['student_id'];
$date = new DateTime();

for($j = 0 ; $j<$numrow ; $j++){
    $question_id_i = $question_id[$j];

    $insert_survey_score = "INSERT INTO survey_score(id,survey_course_id, survey_question_id, student_id, score, student_gender, semester, year, student_first_name, student_last_name , course_id, createdAt, updatedAt)VALUES (NULL,'" . $survey_course_id . "', '" . $question_id_i . "', '" . $student_id . "', '" . $arr_score[$j] . "','" . $student_gender . "', '" . $semester . "' , '" . $year . "', '" . $first_name . "', '" . $last_name . "', '" . $fetch_survey_course['course_id'] . "', '" . $date->format('Y-m-d H:i:s') . "','" . $date->format('Y-m-d H:i:s') . "')";
    $conn->query($insert_survey_score);


}

$insert_survey_remark = "INSERT INTO survey_remark(id,survey_course_id, question_number, remark, semester , year , student_gender, student_first_name, student_last_name, student_id, course_id, createdAt, updatedAt)VALUES (NULL,'" . $survey_course_id . "', '1', '" . $remark . "', '" . $semester . "' , '" . $year . "', '" . $student_gender . "', '" . $first_name . "', '" . $last_name . "', '" . $student_id . "', '" . $fetch_survey_course['course_id'] . "', '" . $date->format('Y-m-d H:i:s') . "','" . $date->format('Y-m-d H:i:s') . "')";
$conn->query($insert_survey_remark);




?>
<script language='javascript'>
    window.close();
</script>



