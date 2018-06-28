<?php
session_start();

$survey_id = $_REQUEST['survey_id'];
$course_id = $_REQUEST['course_id'];
$group_id = $_REQUEST['group_id'];
$semester = $_REQUEST['semester'];
$year = $_REQUEST['year'];
$_SESSION['survey_id'] = $survey_id;
$_SESSION['course_id'] = $course_id;
$_SESSION['group_id'] = $group_id;
$_SESSION['semester'] = $semester;
$_SESSION['year'] = $year;

?>
<script language="javascript">window.location.href = 'survey-edit.php';</script>
