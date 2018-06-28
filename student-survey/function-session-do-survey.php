<?php
session_start();

$survey_course_id = $_REQUEST['survey_course_id'];
$student_id = $_REQUEST['student_id'];
$course_id = $_REQUEST['course_id'];
$group_id = $_REQUEST['group_id'];
$student_gender = $_REQUEST['student_gender'];
$semester = $_REQUEST['semester'];
$first_name = $_REQUEST['first_name'];
$last_name = $_REQUEST['last_name'];
$year = $_REQUEST['year'];
$_SESSION['survey_course_id'] = $survey_course_id;
$_SESSION['student_id'] = $student_id;
$_SESSION['student_gender'] = $student_gender;
$_SESSION['course_id'] = $course_id;
$_SESSION['group_id'] = $group_id;
$_SESSION['semester'] = $semester;
$_SESSION['year'] = $year;
$_SESSION['first_name'] = $first_name;
$_SESSION['last_name'] = $last_name;


?>
<script language="javascript">window.location.href = 'do-survey.php';</script>
