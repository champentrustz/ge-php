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

$exercise_id = $_REQUEST['exercise_id'];
$student_id = $_REQUEST['student_id'];
$numrow = $_REQUEST['numrow'];
$choice_right = $_REQUEST['choice_right'];
$score = $_REQUEST['score'];
$sum_score = 0;
$question_number = 0;
$date = new DateTime();

for($r=0;$r<$numrow;$r++){
  $question_number++;
  $choice_choose_i = $_REQUEST['exercise'.$question_number];
  $choice_right_i = $choice_right[$r];
  $score_i = $score[$r];

  if($choice_choose_i == $choice_right_i){

      $sum_score += $score_i;

  }


}

$insert_student_score = "INSERT INTO exercise_student_score (id,exercise_id, student_id, total_score, createdAt, updatedAt)VALUES(NULL, '".$exercise_id."', '".$student_id."', '".$sum_score."','" . $date->format('Y-m-d H:i:s') . "','" . $date->format('Y-m-d H:i:s') . "')";
$conn->query($insert_student_score);

print "
<script language='javascript'>
  window.close();
</script>
";



?>
