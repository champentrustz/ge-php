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

$exercise_sql="SELECT * FROM exercise WHERE id = '".$exercise_id."'";
$query_exercise=mysqli_query($conn,$exercise_sql);
$fetch_exercise=mysqli_fetch_assoc($query_exercise);

?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>

    <script  type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script  type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script language="JavaScript">

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


    <form data-toggle="validator" action="function-update-exercise.php" method="post" name="form_save">

        <div class="col-md-12">
            <input class="form-control" value="<?=$fetch_exercise['name'];?>" name="exercise_name">
            <br/>

        </div>

        <?php

        $exercise_question_sql="SELECT * FROM exercise_question WHERE exercise_id = '".$fetch_exercise['id']."'";
        $query_exercise_question=mysqli_query($conn,$exercise_question_sql);
        $i = 0;
            while($fetch_exercise_question=mysqli_fetch_assoc($query_exercise_question)){


                $i++;

                ?>

                <input type="hidden" name="exercise_question_id[]" value="<?php print $fetch_exercise_question['id']?>">

                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">คำถามข้อที่ <?php print $i?></div>
                        <div class="panel-body">

                            <div class="form-horizontal">
                                <div class="form-group">
                                    <label class="control-label col-md-2" for="question">คำถาม</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="question[]" value="<?php print $fetch_exercise_question['question']?>" required>
                                    </div>

                                </div>
                            </div>

                            <div class="form-horizontal">
                                <div class="form-group">
                                    <label  class="control-label col-md-2" for="score">คะแนน</label>
                                    <div class="col-md-4">
                                        <input type="number" min=1 class="form-control" name="score[]" value="<?php print $fetch_exercise_question['score']?>" step="0.1" required>
                                    </div>
                                </div>
                            </div>

                            <?php
                            $exercise_question_choice_sql="SELECT * FROM exercise_question_choice WHERE exercise_question_id = '".$fetch_exercise_question['id']."'";
                            $query_exercise_question_choice=mysqli_query($conn,$exercise_question_choice_sql);
                            $j = 0;
                            $choiceThai = ['ก.','ข.','ค.','ง.'];
                            $choiceEng = ['A','B','C','D'];
                            $choiceA = false;
                            $choiceB = false;
                            $choiceC = false;
                            $choiceD = false;
                            while($fetch_exercise_question_choice=mysqli_fetch_assoc($query_exercise_question_choice)){

                                if($j==0) {
                                    ?>
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label for="choiceA" class="control-label col-md-2"><?php print $choiceThai[$j]?></label>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" name="choice<?php print $choiceEng[$j] ?>[]" value="<?php print $fetch_exercise_question_choice['choice']?>" required>
                                                <input type="hidden" name="choice<?php print $choiceEng[$j] ?>_id[]" value="<?php print $fetch_exercise_question_choice['id']?>">

                                            </div>

                                        </div>
                                    </div>


                                    <?php

                                    if($fetch_exercise_question_choice['status'] == "RIGHT"){

                                        $choiceA = true;
                                    }
                                    }
                                    if($j==1){
                                        ?>

                            <div class="form-horizontal">
                                <div class="form-group">
                                    <label for="choiceA" class="control-label col-md-2"><?php print $choiceThai[$j]?></label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="choice<?php print $choiceEng[$j] ?>[]" value="<?php print $fetch_exercise_question_choice['choice']?>" required>
                                        <input type="hidden" name="choice<?php print $choiceEng[$j] ?>_id[]" value="<?php print $fetch_exercise_question_choice['id']?>">

                                    </div>

                                </div>
                            </div>

                                        <?php
                                        if($fetch_exercise_question_choice['status'] == "RIGHT"){

                                            $choiceB = true;
                                        }

                                    }
                                        if($j==2) {
                                        ?>
                                            <div class="form-horizontal">
                                                <div class="form-group">
                                                    <label for="choiceA" class="control-label col-md-2"><?php print $choiceThai[$j]?></label>
                                                    <div class="col-md-10">
                                                        <input type="text" class="form-control" name="choice<?php print $choiceEng[$j] ?>[]" value="<?php print $fetch_exercise_question_choice['choice']?>" required>
                                                        <input type="hidden" name="choice<?php print $choiceEng[$j] ?>_id[]" value="<?php print $fetch_exercise_question_choice['id']?>">

                                                    </div>

                                                </div>
                                            </div>

                                        <?php
                                            if($fetch_exercise_question_choice['status'] == "RIGHT"){

                                                $choiceC = true;
                                            }
                                     }
                                    if($j==3){
                                    ?>

                                        <div class="form-horizontal">
                                            <div class="form-group">
                                                <label for="choiceA" class="control-label col-md-2"><?php print $choiceThai[$j]?></label>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" name="choice<?php print $choiceEng[$j] ?>[]" value="<?php print $fetch_exercise_question_choice['choice']?>" required>
                                                    <input type="hidden" name="choice<?php print $choiceEng[$j] ?>_id[]" value="<?php print $fetch_exercise_question_choice['id']?>">

                                                </div>

                                            </div>
                                        </div>
                                    <?php
                                        if($fetch_exercise_question_choice['status'] == "RIGHT"){

                                            $choiceD = true;
                                        }

                                }
                                ?>
                            <?php
                                $j++;
                            }
                            ?>

                            <div class="form-horizontal">
                                <div class="form-group">
                                    <div class="col-md-4 col-md-offset-8">
                                        <select name="answer[]" class="form-control" required>
                                            <option value="1" <?php if($choiceA == true)echo "selected"?>>ก.</option>
                                            <option value="2" <?php if($choiceB == true)echo "selected"?>>ข.</option>
                                            <option value="3" <?php if($choiceC == true)echo "selected"?>>ค.</option>
                                            <option value="4" <?php if($choiceD == true)echo "selected"?>>ง.</option>
                                        </select>
                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>

    <?php


    }

        ?>
        <input type="hidden" name="numrow" value="<?php print $i?>">
        <input type="hidden" name="exercise_id" value="<?php print $exercise_id?>">
        <div class="col-md-12">
            <button class="btn btn-success btn-block" type="submit">บันทึก</button>
            <br />
            <br />
            <br />
        </div>


    </form>


</div>
</body>
</html>
