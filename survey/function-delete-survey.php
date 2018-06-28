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




        $delete_survey_course = "UPDATE survey_course SET deletedAt = '" . $date->format('Y-m-d H:i:s') . "' WHERE id = '".$survey_course_id."' ";
        $conn->query($delete_survey_course);





header("Refresh:1; url=survey.php?semester=$semester&year=$year&search=duplicate");

?>



