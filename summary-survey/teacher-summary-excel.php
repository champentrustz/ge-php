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

$survey_name = $_REQUEST['survey_name'];
$teacher_name = $_REQUEST['teacher_name'];
$semester = $_REQUEST['semester'];
$year = $_REQUEST['year'];
$survey_id = null;
$sumX = array();
$n = array();
$x = array();
$student_name = array();
$student_last_name = array();
$remarks = array();
$arrayScore = array();
$course_name = null;


$survey_sql="SELECT * FROM survey WHERE topic like '%" . $survey_name . "%' and semester = '" . $semester . "' and year = '" . $year . "' and teacher_name like '%".$teacher_name."%' and  deletedAt is NULL";
$query_survey=mysqli_query($conn,$survey_sql);
$sumN = 0;

while($fetch_survey = mysqli_fetch_assoc($query_survey)){
    $survey_id = $fetch_survey['id'];
    $survey_question_sql = "SELECT * FROM survey_question WHERE survey_id = '" . $fetch_survey['id'] . "' AND type = 'QUESTION' AND question != ''";
    $query_survey_question = mysqli_query($conn, $survey_question_sql);
    $i = 0;

    $survey_course_sql = "SELECT * FROM survey_course WHERE survey_id = '" . $fetch_survey['id'] . "' AND semester = '".$semester."' AND year = '".$year."' and deletedAt is NULL ";
    $query_survey_course = mysqli_query($conn, $survey_course_sql);
    while($fetch_course_question = mysqli_fetch_assoc($query_survey_course)) {


        $remark_sql = "SELECT * FROM survey_remark WHERE survey_course_id = '" . $fetch_course_question['id'] . "' AND semester = '".$semester."' AND year = '".$year."' and deletedAt is NULL ";
        $query_remark = mysqli_query($conn, $remark_sql);
        while($fetch_remark = mysqli_fetch_assoc($query_remark)) {
            $remarks[] = $fetch_remark;
        }

    }


    while ($fetch_survey_question = mysqli_fetch_assoc($query_survey_question)) {


        $score_sql="SELECT * FROM survey_score WHERE  survey_question_id = '".$fetch_survey_question['id']."'";
        $query_score=mysqli_query($conn,$score_sql);



        while($fetch_score=mysqli_fetch_assoc($query_score)){


            $n[$i]++;
            $x[$i][] = $fetch_score['score'];
            $student_name[$i][] = $fetch_score['student_first_name'];
            $student_last_name[$i][] = $fetch_score['student_last_name'];
            $sumX[$i] += (int)$fetch_score['score'];
        }


        $i++;
    }

    $row_count=mysqli_num_rows($query_score);
    $sumN += $row_count;

}


$nameExcel = '(สรุปแบบประเมินรายบุคคล)'.$teacher_name.'-'.$survey_name.'-'.$semester.'-'.$year.'.xls';
header("Content-Disposition: attachment; filename=$nameExcel");
header("Content-Type: application/xls");

?>




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

    hr {
        background-color: #fff;
        border-top: 2px dotted #8c8b8b;
    }


</style>



<p class="text-center">
    <strong><?php print $survey_name?></strong>
</p>
<p class="text-center">
    <strong>ภาคเรียนที่ <?php print $semester?>/<?php print $year?></strong>
</p>
<p class="text-center">
    <strong>สำนักวิชาการศึกษาทั่วไปและนวัตกรรมการเรียนรู้อิเล็กทรอนิกส์</strong>
</p>

<dvi class="text-left">
    <strong><?php print $teacher_name?></strong>
</dvi>

<br>


<table class="table table-bordered" cellspacing="0" style="font-size: 12px">
    <thead>

    <th class="text-center">หัวข้อ</th>
    <th class="text-center">x&#772;</th>
    <th class="text-center">S.D.</th>
    <th class="text-center">ร้อยละ</th>
    <th class="text-center">ระดับความพึงพอใจ</th>
    </thead>
    <tbody>


    <?php

    $percentTopicArray = array();


    $test_sql="SELECT MIN(id) as id, topic_id FROM survey_question WHERE survey_id = '".$survey_id."' GROUP BY topic_id";
    $query_test=mysqli_query($conn,$test_sql);
    $avg = 0;
    $i = 0;
    while($fetch_test=mysqli_fetch_assoc($query_test)){

        $survey_question_sql="SELECT * FROM survey_question WHERE survey_id = '".$survey_id."' AND topic_id = '".$fetch_test['topic_id']."'";
        $query_survey_question=mysqli_query($conn,$survey_question_sql);
        $j = 0;
        $sumAvg = 0;
        $sumSD = 0;
        while($fetch_survey_question=mysqli_fetch_assoc($query_survey_question)){


            ?>
            <tr>
                <?php
                if($fetch_survey_question['type'] == "TOPIC" && $fetch_survey_question['question'] != ''){
                    ?>
                    <td colspan="6"><strong><?php print $fetch_survey_question['question']?></strong></td>
                    <?php
                }
                else{

                    if($fetch_survey_question['question'] != ''){


                        $avgX = $sumX[$i] / $n[$i];
                        $avgX2digit = number_format((float)$avgX, 2, '.', '');

                        $sumAvg = $sumAvg + $avgX;
                        $percent = ($avgX *100.00) / 5;
                        $sumXiXbar = 0;


                        foreach ($x[$i] as $score){

                            $sumXiXbar += pow($score - $avgX,2);

                        }



                        $sd = $sumXiXbar / ($n[$i] - 1);
                        $sumSD += $sd;



                        ?>

                        <td><?php print $i+1?>. <?php print $fetch_survey_question['question']?></td>
                        <td class="text-center"><?php if(is_nan($avgX)){
                                print 0;
                            }
                            else{
                                print number_format((float)$avgX, 2, '.', '');
                            }

                            ?></td>
                        <td class="text-center"><?php if(is_nan($sd)){
                                print 0;
                            }
                            else{
                                print number_format((float)$sd, 2, '.', '');
                            }

                            ?></td>
                        <td class="text-center"><?php if(is_nan($percent)){
                                print 0;
                            }
                            else{
                                print number_format((float)$percent, 2, '.', '');
                            }

                            ?></td>
                        <td class="text-center"><?php
                            if($avgX2digit >= 4.51){
                                ?>
                                มากที่สุด

                                <?php
                            }
                            elseif($avgX2digit >=3.51 && $avgX2digit <= 4.50){

                                ?>

                                มาก

                                <?php

                            }
                            elseif($avgX2digit >=2.51 && $avgX2digit <= 3.50){

                                ?>

                                ปานกลาง
                                <?php

                            }
                            elseif($avgX2digit >=1.51 && $avgX2digit <= 2.50){

                                ?>

                                น้อย
                                <?php

                            }
                            elseif($avgX2digit >=1.00 && $avgX2digit <= 1.50){

                                ?>

                                ไม่มีความพึงพอใจ
                                <?php

                            }
                            else{

                                ?>

                                -
                                <?php

                            }

                            ?>
                        </td>
                        <?php

                        $i++;
                        $j++;

                    }
                }



                ?>
            </tr>


            <?php
        }

        $avg = $sumAvg / $j;

        $avg2digit = number_format((float)$avg, 2, '.', '');

        $percentTopic = ($avg * 100) / 5 ;

        $avgSD = $sumSD/$j;

        $percentTopicArray[] = $percentTopic;




        ?>

        <tr>
            <td class="text-center"><strong>เฉลี่ย</strong></td>
            <td class="text-center"><?php if(is_nan($avg)){
                    print 0;
                }
                else{
                    print number_format((float)$avg, 2, '.', '');
                }

                ?></td>
            <td class="text-center"><?php if(is_nan($avgSD)){
                    print 0;
                }
                else{
                    print number_format((float)$avgSD, 2, '.', '');
                }

                ?></td>
            <td class="text-center"><?php if(is_nan($percentTopic)){
                    print 0;
                }
                else{
                    print number_format((float)$percentTopic, 2, '.', '');
                }

                ?></td>
            <td class="text-center"><?php
                if($avg2digit >= 4.51){
                    ?>
                    มากที่สุด

                    <?php
                }
                elseif($avg2digit >=3.51 && $avg2digit <= 4.50){

                    ?>

                    มาก

                    <?php

                }
                elseif($avg2digit >=2.51 && $avg2digit <= 3.50){

                    ?>

                    ปานกลาง
                    <?php

                }
                elseif($avg2digit >=1.51 && $avg2digit <= 2.50){

                    ?>

                    น้อย
                    <?php

                }
                elseif($avg2digit >=1.00 && $avg2digit <= 1.50){

                    ?>

                    ไม่มีความพึงพอใจ
                    <?php

                }
                else{

                    ?>

                    -
                    <?php

                }

                ?>
            </td>
        </tr>

        <?php


    }



    ?>


    </tbody>




</table>





