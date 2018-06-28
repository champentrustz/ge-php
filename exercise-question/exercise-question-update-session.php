<?php

session_start();
$_SESSION['exercise_id'] = $_REQUEST['exercise_id'];
?>
<script language="javascript">window.location.href = 'exercise-question-update.php'</script>
