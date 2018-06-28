<?php

$survey_id = $_REQUEST['survey_id'];
$course_id = $_REQUEST['course_id'];
$group_id = $_REQUEST['group_id'];
$semester = $_REQUEST['semester'];
$year = $_REQUEST['year'];


$nameExcel = 'summary'.$course_id.'-'.$group_id.'-'.$semester.'-'.$year.'.xls';
header("Content-Disposition: attachment; filename=$nameExcel");
header("Content-Type: application/xls");

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





$survey_course_sql="SELECT * FROM survey_course WHERE course_id = '".$course_id."' and group_id = '".$group_id."' and deletedAt IS NULL LIMIT 1";
$query_survey_course=mysqli_query($conn,$survey_course_sql);
$fetch_survey_course = mysqli_fetch_assoc($query_survey_course)


?>


<?php


//วันภาษาไทย
$ThDay = array ( "อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์" );
//เดือนภาษาไทย
$ThMonth = array ( "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน","พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม","กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม" );

//กำหนดคุณสมบัติ
$week = date( "w" ); // ค่าวันในสัปดาห์ (0-6)
$months = date( "m" )-1; // ค่าเดือน (1-12)
$day = date( "j" ); // ค่าวันที่(1-31)
$years = date( "Y" )+543; // ค่า ค.ศ.บวก 543 ทำให้เป็น ค.ศ.


?>

<?php
$monthdis = date('n');
if($monthdis>=8  && $monthdis <=12){
    $mdis =1;
}else{
    $mdis =2;
}
?>



<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">




</head>

<style>

    @font-face {
        font-family: 'TH Sarabun New';
        src: url('../fonts/thsarabunnew-webfont.eot') format('embedded-opentype'),
        url('../fonts/thsarabunnew-webfont.woff') format('woff'),
        url('../fonts/thsarabunnew-webfont.ttf')  format('truetype');
        font-weight: normal;
        font-style: normal;
    }


    div {
        font-family: 'TH Sarabun New', sans-serif;
        font-size: 12px;
    }

    hr {
        background-color: #fff;
        border-top: 2px dotted #8c8b8b;
    }


</style>


<script>

    $(document).ready(function() {
        $('#data-table').DataTable();
    } );


</script>



<body>



<div class="container">






                <p class="text-center">
                    <strong>ผลสรุปประเมินความพึงพอใจผู้สอนหมวดวิชาศึกษาทั่วไปปีการศึกษา <?php print $mdis?>/<?php print $years?></strong>
                </p>
                <p class="text-center">
                    <strong>วิชา <?php print $course_id?> <?php print $fetch_survey_course['name']?></strong>
                </p>
                <p class="text-center">
                    <strong>สำนักวิชาการศึกษาทั่วไปและนวัตกรรมการเรียนรู้อิเล็กทรอนิกส์</strong>
                </p>
                <p class="text-center">
                    <strong>วันที่  <?php print $day?>  เดือน  <?php print $ThMonth[$months]?>  พ.ศ.  <?php print $years?></strong>
                </p>

                <br>

    <table class="table" cellspacing="0" style="font-size: 12px">
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


        $test_sql="SELECT MIN(id) as id, topic_id FROM survey_question WHERE survey_id = '".$fetch_survey_course['survey_id']."' GROUP BY topic_id";
        $query_test=mysqli_query($conn,$test_sql);
        $avg = 0;
        while($fetch_test=mysqli_fetch_assoc($query_test)){

            $survey_question_sql="SELECT * FROM survey_question WHERE survey_id = '".$fetch_survey_course['survey_id']."' AND topic_id = '".$fetch_test['topic_id']."' and question != ''";
            $query_survey_question=mysqli_query($conn,$survey_question_sql);
            $i = 0;
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

                            $score_sql="SELECT * FROM survey_score WHERE survey_course_id = '".$fetch_survey_course['id']."' AND survey_question_id = '".$fetch_survey_question['id']."'";
                            $query_score=mysqli_query($conn,$score_sql);
                            $sumX = 0;
                            $n = 0;

                            while($fetch_score=mysqli_fetch_assoc($query_score)){
                                $n++;
                                $sumX = $sumX + $fetch_score['score'];
                            }
                            $avgX = $sumX / $n;

                            $sumAvg = $sumAvg + $avgX;
                            $percent = ($avgX *100.00) / 5;
                            $sumXiXbar = 0;
                            $score_sql_again="SELECT * FROM survey_score WHERE survey_course_id = '".$fetch_survey_course['id']."' AND survey_question_id = '".$fetch_survey_question['id']."'";
                            $query_score_again=mysqli_query($conn,$score_sql_again);
                            while($fetch_score_again=mysqli_fetch_assoc($query_score_again)){
                                $sumXiXbar += pow($fetch_score_again['score']-$avgX,2);
                            }

                            $sd = $sumXiXbar / ($n - 1);
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
                                if($percent >= 80){
                                    ?>
                                    มากที่สุด

                                    <?php
                                }
                                elseif($percent >=60 && $percent < 80){

                                    ?>

                                    มาก

                                    <?php

                                }
                                elseif($percent >=40 && $percent < 60){

                                    ?>

                                    ปานกลาง
                                    <?php

                                }
                                elseif($percent >=20 && $percent < 40){

                                    ?>

                                    น้อย
                                    <?php

                                }
                                elseif($percent < 20){

                                    ?>

                                    น้อยที่สุด
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

                        }
                    }



                    ?>
                </tr>


                <?php
            }

            $avg = $sumAvg / $i;

            $percentTopic = ($avg * 100) / 5 ;

            $avgSD = $sumSD/$i;

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
                    if($percentTopic >= 80){
                        ?>
                        มากที่สุด

                        <?php
                    }
                    elseif($percentTopic >=60 && $percentTopic < 80){

                        ?>

                        มาก

                        <?php

                    }
                    elseif($percentTopic >=40 && $percentTopic < 60){

                        ?>

                        ปานกลาง
                        <?php

                    }
                    elseif($percentTopic >=20 && $percentTopic < 40){

                        ?>

                        น้อย
                        <?php

                    }
                    elseif($percentTopic < 20){

                        ?>

                        น้อยที่สุด
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

            </div>










</body>
</html>
