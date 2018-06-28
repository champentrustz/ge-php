<?php

session_start();
$_SESSION['exercise_id'] = $_REQUEST['exercise_id'];
$_SESSION['student_id'] = $_REQUEST['student_id'];
?>
<script language="javascript">window.location.href = 'student-exercise.php'</script>
