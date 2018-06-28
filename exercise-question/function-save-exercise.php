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

$question = $_REQUEST['question'];
$score = $_REQUEST['score'];
$choiceA = $_REQUEST['choiceA'];
$choiceB = $_REQUEST['choiceB'];
$choiceC = $_REQUEST['choiceC'];
$choiceD = $_REQUEST['choiceD'];
$answer = $_REQUEST['answer'];
$exercise_id = $_REQUEST['exercise_id'];
$numrow = $_REQUEST['numrow'];
$sum_score = 0;
$date = new DateTime();


for($r=0;$r<$numrow;$r++) {
    $sum_score = $sum_score + $score[$r];
    $question_i = $question[$r];
    $score_i = $score[$r];
    $choiceA_i = $choiceA[$r];
    $choiceB_i = $choiceB[$r];
    $choiceC_i = $choiceC[$r];
    $choiceD_i = $choiceD[$r];
    $answer_i = $answer[$r];

    $insert_exercise_question = "INSERT INTO exercise_question(id,exercise_id, question, score, createdAt, updatedAt)VALUES (NULL,'" . $exercise_id . "', '" . $question_i . "', '" . $score_i . "','" . $date->format('Y-m-d H:i:s') . "','" . $date->format('Y-m-d H:i:s') . "')";
    $conn->query($insert_exercise_question);
        $last_question_id = $conn->insert_id;



  if($answer_i == "1"){

    $insert_exercise_question_choiceA = "INSERT INTO exercise_question_choice(id,exercise_question_id, choice, status, createdAt, updatedAt)VALUES (NULL, '".$last_question_id."', '".$choiceA_i."', 'RIGHT' ,'" . $date->format('Y-m-d H:i:s') . "','" . $date->format('Y-m-d H:i:s') . "')";
    $insert_exercise_question_choiceB = "INSERT INTO exercise_question_choice(id,exercise_question_id, choice, status, createdAt, updatedAt)VALUES (NULL, '".$last_question_id."', '".$choiceB_i."', 'WRONG' ,'" . $date->format('Y-m-d H:i:s') . "','" . $date->format('Y-m-d H:i:s') . "')";
    $insert_exercise_question_choiceC = "INSERT INTO exercise_question_choice(id,exercise_question_id, choice, status, createdAt, updatedAt)VALUES (NULL, '".$last_question_id."', '".$choiceC_i."', 'WRONG' ,'" . $date->format('Y-m-d H:i:s') . "','" . $date->format('Y-m-d H:i:s') . "')";
    $insert_exercise_question_choiceD = "INSERT INTO exercise_question_choice(id,exercise_question_id, choice, status, createdAt, updatedAt)VALUES (NULL, '".$last_question_id."', '".$choiceD_i."', 'WRONG' ,'" . $date->format('Y-m-d H:i:s') . "','" . $date->format('Y-m-d H:i:s') . "')";
  }

  else if($answer_i == "2"){
      $insert_exercise_question_choiceA = "INSERT INTO exercise_question_choice(id,exercise_question_id, choice, status, createdAt, updatedAt)VALUES (NULL, '".$last_question_id."', '".$choiceA_i."', 'WRONG' ,'" . $date->format('Y-m-d H:i:s') . "','" . $date->format('Y-m-d H:i:s') . "')";
      $insert_exercise_question_choiceB = "INSERT INTO exercise_question_choice(id,exercise_question_id, choice, status, createdAt, updatedAt)VALUES (NULL, '".$last_question_id."', '".$choiceB_i."', 'RIGHT' ,'" . $date->format('Y-m-d H:i:s') . "','" . $date->format('Y-m-d H:i:s') . "')";
      $insert_exercise_question_choiceC = "INSERT INTO exercise_question_choice(id,exercise_question_id, choice, status, createdAt, updatedAt)VALUES (NULL, '".$last_question_id."', '".$choiceC_i."', 'WRONG' ,'" . $date->format('Y-m-d H:i:s') . "','" . $date->format('Y-m-d H:i:s') . "')";
      $insert_exercise_question_choiceD = "INSERT INTO exercise_question_choice(id,exercise_question_id, choice, status, createdAt, updatedAt)VALUES (NULL, '".$last_question_id."', '".$choiceD_i."', 'WRONG' ,'" . $date->format('Y-m-d H:i:s') . "','" . $date->format('Y-m-d H:i:s') . "')";

  }
  else if($answer_i == "3"){
      $insert_exercise_question_choiceA = "INSERT INTO exercise_question_choice(id,exercise_question_id, choice, status, createdAt, updatedAt)VALUES (NULL, '".$last_question_id."', '".$choiceA_i."', 'WRONG' ,'" . $date->format('Y-m-d H:i:s') . "','" . $date->format('Y-m-d H:i:s') . "')";
      $insert_exercise_question_choiceB = "INSERT INTO exercise_question_choice(id,exercise_question_id, choice, status, createdAt, updatedAt)VALUES (NULL, '".$last_question_id."', '".$choiceB_i."', 'WRONG' ,'" . $date->format('Y-m-d H:i:s') . "','" . $date->format('Y-m-d H:i:s') . "')";
      $insert_exercise_question_choiceC = "INSERT INTO exercise_question_choice(id,exercise_question_id, choice, status, createdAt, updatedAt)VALUES (NULL, '".$last_question_id."', '".$choiceC_i."', 'RIGHT' ,'" . $date->format('Y-m-d H:i:s') . "','" . $date->format('Y-m-d H:i:s') . "')";
      $insert_exercise_question_choiceD = "INSERT INTO exercise_question_choice(id,exercise_question_id, choice, status, createdAt, updatedAt)VALUES (NULL, '".$last_question_id."', '".$choiceD_i."', 'WRONG' ,'" . $date->format('Y-m-d H:i:s') . "','" . $date->format('Y-m-d H:i:s') . "')";

  }
  else if($answer_i == "4"){
      $insert_exercise_question_choiceA = "INSERT INTO exercise_question_choice(id,exercise_question_id, choice, status, createdAt, updatedAt)VALUES (NULL, '".$last_question_id."', '".$choiceA_i."', 'WRONG' ,'" . $date->format('Y-m-d H:i:s') . "','" . $date->format('Y-m-d H:i:s') . "')";
      $insert_exercise_question_choiceB = "INSERT INTO exercise_question_choice(id,exercise_question_id, choice, status, createdAt, updatedAt)VALUES (NULL, '".$last_question_id."', '".$choiceB_i."', 'WRONG' ,'" . $date->format('Y-m-d H:i:s') . "','" . $date->format('Y-m-d H:i:s') . "')";
      $insert_exercise_question_choiceC = "INSERT INTO exercise_question_choice(id,exercise_question_id, choice, status, createdAt, updatedAt)VALUES (NULL, '".$last_question_id."', '".$choiceC_i."', 'WRONG' ,'" . $date->format('Y-m-d H:i:s') . "','" . $date->format('Y-m-d H:i:s') . "')";
      $insert_exercise_question_choiceD = "INSERT INTO exercise_question_choice(id,exercise_question_id, choice, status, createdAt, updatedAt)VALUES (NULL, '".$last_question_id."', '".$choiceD_i."', 'RIGHT' ,'" . $date->format('Y-m-d H:i:s') . "','" . $date->format('Y-m-d H:i:s') . "')";

  }

  $conn->query($insert_exercise_question_choiceA);
  $conn->query($insert_exercise_question_choiceB);
  $conn->query($insert_exercise_question_choiceC);
  $conn->query($insert_exercise_question_choiceD);


}

$update_score = "UPDATE exercise SET total_score='".$sum_score."' WHERE id='".$exercise_id."'";
$conn->query($update_score);

print "
<script language='javascript'>
   window.close();
</script>
";

?>
