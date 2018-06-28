

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

$survey_course_id = $_REQUEST['survey_course_id'];
$semester = $_REQUEST['semester'];
$year = $_REQUEST['year'];
$date = new DateTime();

$sql_survey_course = "SELECT *  FROM survey_course WHERE id = '".$survey_course_id."'";
$result_survey_course = mysqli_query($conn, $sql_survey_course);
$row_survey_course = mysqli_fetch_assoc($result_survey_course);

$sql_survey = "SELECT *  FROM survey WHERE id = '".$row_survey_course['survey_id']."'";
$result_survey = mysqli_query($conn, $sql_survey);
$row_survey = mysqli_fetch_assoc($result_survey);
$newName = $row_survey['topic'].'[copy]';

$insert_survey = "INSERT INTO survey(id,topic, teacher_name, amount, type, semester, year, createdAt, updatedAt)VALUES (NULL,'" . $newName . "', '" . $row_survey['teacher_name'] . "', '" . $row_survey['amount'] . "', '" . $row_survey['type'] . "', '" . $row_survey['semester'] . "', '" . $row_survey['year'] . "', '" . $date->format('Y-m-d H:i:s') . "','" . $date->format('Y-m-d H:i:s') . "')";
$conn->query($insert_survey);
$latest_record = $conn->insert_id;



$insert_survey_course = "INSERT INTO survey_course(id,survey_id, course_id, group_id, name, group_name, semester , year,  createdAt, updatedAt)VALUES (NULL,'" . $latest_record . "', '" . $row_survey_course['course_id'] . "', '" . $row_survey_course['group_id'] . "', '" . $row_survey_course['name'] . "', '" . $row_survey_course['group_name'] . "', '" . $row_survey_course['semester'] . "', '" . $row_survey_course['year'] . "', '" . $date->format('Y-m-d H:i:s') . "','" . $date->format('Y-m-d H:i:s') . "')";
$conn->query($insert_survey_course);




$sql_survey_question = "SELECT *  FROM survey_question WHERE survey_id = '".$row_survey['id']."'";
$result_survey_question = mysqli_query($conn, $sql_survey_question);
while($row_survey_question = mysqli_fetch_assoc($result_survey_question)){

    $insert_survey_question = "INSERT INTO survey_question(id,survey_id, topic_id, question, type, createdAt, updatedAt)VALUES (NULL,'" . $latest_record . "', '" . $row_survey_question['topic_id'] . "', '" . $row_survey_question['question'] . "', '" . $row_survey_question['type'] . "', '" . $date->format('Y-m-d H:i:s') . "','" . $date->format('Y-m-d H:i:s') . "')";
    $conn->query($insert_survey_question);

}


header("Refresh:1; url=survey.php?semester=$semester&year=$year&search=duplicate");





