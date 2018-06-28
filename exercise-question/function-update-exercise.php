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

$exercise_name = $_REQUEST['exercise_name'];
$question = $_REQUEST['question'];
$score = $_REQUEST['score'];
$choiceA = $_REQUEST['choiceA'];
$choiceB = $_REQUEST['choiceB'];
$choiceC = $_REQUEST['choiceC'];
$choiceD = $_REQUEST['choiceD'];
$choiceA_id = $_REQUEST['choiceA_id'];
$choiceB_id = $_REQUEST['choiceB_id'];
$choiceC_id = $_REQUEST['choiceC_id'];
$choiceD_id = $_REQUEST['choiceD_id'];
$exercise_question_id = $_REQUEST['exercise_question_id'];
$answer = $_REQUEST['answer'];
$exercise_id = $_REQUEST['exercise_id'];
$numrow = $_REQUEST['numrow'];
$sum_score = 0;
$date = new DateTime();

$update_exercise_name = "UPDATE exercise SET name='".$exercise_name."' WHERE id='".$exercise_id."'";
$conn->query($update_exercise_name);

for($r=0;$r<$numrow;$r++) {
    $sum_score = $sum_score + $score[$r];
    $question_i = $question[$r];
    $score_i = $score[$r];
    $choiceA_i = $choiceA[$r];
    $choiceB_i = $choiceB[$r];
    $choiceC_i = $choiceC[$r];
    $choiceD_i = $choiceD[$r];
    $choiceA_id_i = $choiceA_id[$r];
    $choiceB_id_i = $choiceB_id[$r];
    $choiceC_id_i = $choiceC_id[$r];
    $choiceD_id_i = $choiceD_id[$r];
    $exercise_question_id_i = $exercise_question_id[$r];
    $answer_i = $answer[$r];

    print $sum_score.'<br/>';
    print $question_i.'<br/>';
    print $score_i.'<br/>';
    print $choiceA_i.'<br/>';
    print $choiceB_i.'<br/>';
    print $choiceC_i.'<br/>';
    print $choiceD_i.'<br/>';
    print $choiceA_id_i.'<br/>';
    print $choiceB_id_i.'<br/>';
    print $choiceC_id_i.'<br/>';
    print $choiceD_id_i.'<br/>';
    print $exercise_question_id_i.'<br/>';
    print $answer_i.'<br/>';


    $update_exercise_question = "UPDATE exercise_question SET question='".$question_i."', score='".$score_i."' WHERE id='".$exercise_question_id_i."'";
    $conn->query($update_exercise_question);

//
//
//
    if($answer_i == "1"){

        $update_exercise_question_choiceA = "UPDATE exercise_question_choice SET choice='".$choiceA_i."', status='RIGHT' WHERE id='".$choiceA_id_i."' ";
        $update_exercise_question_choiceB = "UPDATE exercise_question_choice SET choice='".$choiceB_i."', status='WRONG' WHERE id='".$choiceB_id_i."' ";
        $update_exercise_question_choiceC = "UPDATE exercise_question_choice SET choice='".$choiceC_i."', status='WRONG' WHERE id='".$choiceC_id_i."' ";
        $update_exercise_question_choiceD = "UPDATE exercise_question_choice SET choice='".$choiceD_i."', status='WRONG' WHERE id='".$choiceD_id_i."' ";
    }

    else if($answer_i == "2"){
        $update_exercise_question_choiceA = "UPDATE exercise_question_choice SET choice='".$choiceA_i."', status='WRONG' WHERE id='".$choiceA_id_i."' ";
        $update_exercise_question_choiceB = "UPDATE exercise_question_choice SET choice='".$choiceB_i."', status='RIGHT' WHERE id='".$choiceB_id_i."' ";
        $update_exercise_question_choiceC = "UPDATE exercise_question_choice SET choice='".$choiceC_i."', status='WRONG' WHERE id='".$choiceC_id_i."' ";
        $update_exercise_question_choiceD = "UPDATE exercise_question_choice SET choice='".$choiceD_i."', status='WRONG' WHERE id='".$choiceD_id_i."' ";

    }
    else if($answer_i == "3"){
        $update_exercise_question_choiceA = "UPDATE exercise_question_choice SET choice='".$choiceA_i."', status='WRONG' WHERE id='".$choiceA_id_i."' ";
        $update_exercise_question_choiceB = "UPDATE exercise_question_choice SET choice='".$choiceB_i."', status='WRONG' WHERE id='".$choiceB_id_i."' ";
        $update_exercise_question_choiceC = "UPDATE exercise_question_choice SET choice='".$choiceC_i."', status='RIGHT' WHERE id='".$choiceC_id_i."' ";
        $update_exercise_question_choiceD = "UPDATE exercise_question_choice SET choice='".$choiceD_i."', status='WRONG' WHERE id='".$choiceD_id_i."' ";

    }
    else if($answer_i == "4"){
        $update_exercise_question_choiceA = "UPDATE exercise_question_choice SET choice='".$choiceA_i."', status='WRONG' WHERE id='".$choiceA_id_i."' ";
        $update_exercise_question_choiceB = "UPDATE exercise_question_choice SET choice='".$choiceB_i."', status='WRONG' WHERE id='".$choiceB_id_i."' ";
        $update_exercise_question_choiceC = "UPDATE exercise_question_choice SET choice='".$choiceC_i."', status='WRONG' WHERE id='".$choiceC_id_i."' ";
        $update_exercise_question_choiceD = "UPDATE exercise_question_choice SET choice='".$choiceD_i."', status='RIGHT' WHERE id='".$choiceD_id_i."' ";

    }

    $conn->query($update_exercise_question_choiceA);
    $conn->query($update_exercise_question_choiceB);
    $conn->query($update_exercise_question_choiceC);
    $conn->query($update_exercise_question_choiceD);


}

$update_score = "UPDATE exercise SET total_score='".$sum_score."' WHERE id='".$exercise_id."'";
$conn->query($update_score);

print "
<script language='javascript'>
   window.close();
</script>
";

?>
