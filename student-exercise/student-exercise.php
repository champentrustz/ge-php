<?php
session_start();
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

$exercise_id = $_SESSION['exercise_id'];
$student_id = $_SESSION['student_id'];


$exercise_sql="SELECT * FROM exercise WHERE id = '".$exercise_id."'";
$query_exercise=mysqli_query($conn,$exercise_sql);
$fetch_exercise=mysqli_fetch_assoc($query_exercise);


$score_sql="SELECT * FROM exercise_student_score WHERE exercise_id = '".$exercise_id."' and student_id = '".$student_id."' ";
$query_score=mysqli_query($conn,$score_sql);
$row_score = mysqli_num_rows($query_score);


 ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>

    <script  type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script  type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>




    <?php

function ThDate()
{
//วันภาษาไทย
$ThDay = array ( "อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์" );
//เดือนภาษาไทย
$ThMonth = array ( "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน","พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม","กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม" );

//กำหนดคุณสมบัติ
$week = date( "w" ); // ค่าวันในสัปดาห์ (0-6)
$months = date( "m" )-1; // ค่าเดือน (1-12)
$day = date( "d" ); // ค่าวันที่(1-31)
$years = date( "Y" )+543; // ค่า ค.ศ.บวก 543 ทำให้เป็น ค.ศ.

return "วัน$ThDay[$week]
		ที่ $day
		เดือน $ThMonth[$months]
		พ.ศ. $years";
}

?>

    <script language="JavaScript">


//        function refreshOpener() {
//            window.opener.location.reload();
//            setTimeout("self.close()",1000);
//        }

</script>

</head>

<style>
    @font-face {
        font-family: 'CSChatThaiUI';
        src: url('../fonts/CSChatThaiUI.eot') format('embedded-opentype'),
        url('../fonts/CSChatThaiUI.ttf')  format('truetype');
        font-weight: normal;
        font-style: normal;
    }

    * {
        font-family: 'CSChatThaiUI', sans-serif;
        font-size: 14px;
    }
</style>

<body>


<div class="container">
	<br />

    <?php if($row_score > 0) : ?>

    <h3 class="text-center text-danger">ขออภัย คุณได้ทำแบบฝึกหัดนี้ไปแล้ว</h3>


    <?php else : ?>

        <form data-toggle="validator" action="function-save-student-exercise.php" method="post" name="form_save">
            <div class="col-md-12">
                <h3><?=$fetch_exercise['name'];?> (คะแนนรวม <?=$fetch_exercise['total_score'];?> คะแนน)</h3>
            </div>


            <?php
            $number_question = 0;
            $exercise_question_sql="SELECT * FROM exercise_question WHERE exercise_id = '".$exercise_id."'";
            $query_exercise_question=mysqli_query($conn,$exercise_question_sql);

            while($fetch_exercise_question=mysqli_fetch_assoc($query_exercise_question)){


                $number_question++;

                ?>

                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="col-md-12">
                                <h5><?=$number_question;?>) <?=$fetch_exercise_question['question'];?> (<?=$fetch_exercise_question['score'];?> คะแนน)</h5>
                                <input type="hidden" name="score[]" value=<?=$fetch_exercise_question['score'];?>>
                            </div>
                            <br />
                            <div class="col-md-12">
                                <div class="radio">

                                    <?php
                                    $number_choice = 0;
                                    $exercise_question_choice_sql="SELECT * FROM exercise_question_choice WHERE exercise_question_id = '".$fetch_exercise_question['id']."'";
                                    $query_exercise_question_choice=mysqli_query($conn,$exercise_question_choice_sql);
                                    while($fetch_exercise_question_choice=mysqli_fetch_assoc($query_exercise_question_choice)){
                                        $number_choice++;
                                        if($fetch_exercise_question_choice['status'] == "RIGHT"){
                                            ?>
                                            <input type="hidden" name="choice_right[]" value=<?=$number_choice?>>
                                            <?php
                                        }
                                        ?>
                                        <p>
                                            <label><input type="radio" name="exercise<?=$number_question;?>" value="<?=$number_choice;?>"required><?=$fetch_exercise_question_choice['choice'];?></label>
                                        </p>
                                        <?php
                                    }

                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
            }

            ?>
            <input type="hidden" name="numrow" value="<?=$number_question;?>">
            <input type="hidden" name="exercise_id" value="<?=$exercise_id;?>">
            <input type="hidden" name="student_id" value="<?=$student_id;?>">
            <?php if($student_id == null) :  ?>

            <?php else:?>
                <div class="col-md-12">
                    <button class="btn btn-success btn-block" type="submit">ส่งคำตอบ</button>
                    <br />
                </div>
            <?php endif?>





        </form>



    <?php endif ?>






</div>
</body>
</html>
