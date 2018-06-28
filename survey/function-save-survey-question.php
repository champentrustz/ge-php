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
$date = new DateTime();
$j = 0;

for($r=0;$r<$numrow;$r++) {

    $question_i = $question[$r];
    $type_i = $type[$r];

    if($type_i == "TOPIC"){
        $j++;
    }

    $insert_survey_question = "INSERT INTO survey_question(id,survey_id, topic_id, question, type, createdAt, updatedAt)VALUES (NULL,'" . $survey_id . "', '" . $j . "', '" . $question_i . "', '" . $type_i . "', '" . $date->format('Y-m-d H:i:s') . "','" . $date->format('Y-m-d H:i:s') . "')";
    $conn->query($insert_survey_question);
}




?>
<script language="javascript">window.location.href = 'survey-select-course.php';</script>


