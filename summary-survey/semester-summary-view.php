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
$semester = $_REQUEST['semester'];
$year = $_REQUEST['year'];
$survey_id = null;
$sumX = array();
$n = array();
$x = array();
$arrayScore = array();
$course_name = null;
$student_name = array();
$student_last_name = array();
$remarks = array();


    $survey_sql="SELECT * FROM survey WHERE topic like '%" . $survey_name . "%' and semester = '" . $semester . "' and year = '" . $year . "' and  deletedAt is NULL";
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
?>





<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <script  type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script  type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script  type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src=" https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>



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

    hr {
        background-color: #fff;
        border-top: 2px dotted #8c8b8b;
    }


</style>


<script>

    $(document).ready(function() {
        $('#data-table').DataTable({
            "pageLength": 100,
        });
    } );


</script>

<script>

    $(document).ready(function() {
        $('#data-table-score').DataTable({
            "bSort": false
        });
    } );


</script>

<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>


<body>



<div class="container">
    <br />



    <br/>


    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#menu1">ค่าเฉลี่ย</a></li>
        <li><a data-toggle="tab" href="#menu2">กราฟ</a></li>
        <li><a data-toggle="tab" href="#menu3">คะแนน</a></li>
        <li><a data-toggle="tab" href="#menu4">ข้อเสนอแนะ</a></li>
    </ul>

    <div class="tab-content">


        <div id="menu1" class="tab-pane fade in active">



            <br>
            <br>
            <div class="col-md-12 text-right">


                <a class="btn btn-success" href="semester-summary-excel.php?survey_name=<?php print $survey_name?>&semester=<?php print $semester?>&year=<?php print $year?>"><span class="glyphicon glyphicon-download-alt"></span> ดาวน์โหลดไฟล์ excel</a>
                <br>
                <br>

                <p class="text-center">
                    <strong><?php print $survey_name?></strong>
                </p>
                <p class="text-center">
                    <strong>ภาคเรียนที่ <?php print $semester?>/<?php print $year?></strong>
                </p>
                <p class="text-center">
                    <strong>สำนักวิชาการศึกษาทั่วไปและนวัตกรรมการเรียนรู้อิเล็กทรอนิกส์</strong>
                </p>

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





            </div>
        </div>
        <div id="menu2" class="tab-pane fade">



            <br>
            <br>

            <!--            <a class="btn btn-success" href="survey-excel-graph.php?survey_id=--><?php //print $survey_id?><!--&course_id=--><?php //print $course_id?><!--&group_id=--><?php //print $group_id?><!--"><span class="glyphicon glyphicon-download-alt"></span> ดาวน์โหลดไฟล์ excel</a>-->
            <br>
            <br>

            <?php

            $sql_question_topic="SELECT * FROM survey_question WHERE survey_id = '".$survey_id."' and type = 'TOPIC'";
            $query_question_topic=mysqli_query($conn,$sql_question_topic);
            $numJS = 0;

            while($fetch_question_topic=mysqli_fetch_assoc($query_question_topic)) {
                $numJS++;
                ?>

                <div class="col-md-8" style="margin-left: 100px;">
                    <canvas   id="myChart<?php print $numJS?>"></canvas>
                </div>
                <br/>
                <br/>


                <?php
            }

            ?>

            <br/>

        </div>

        <div id="menu3" class="tab-pane fade">

            <br>
            <br>

            <div class="col-md-12 text-right">
                <a class="btn btn-success" href="semester-summary-score-excel.php?survey_name=<?php print $survey_name?>&semester=<?php print $semester?>&year=<?php print $year?>"><span class="glyphicon glyphicon-download-alt"></span> ดาวน์โหลดไฟล์ excel</a>
            </div>
            <div class="col-md-12">
                <br>
                <br>



                <div class="table-responsive">
                    <table class="table table-bordered " style="font-size: 12px">
                        <thead>

                        <th class="text-center ">ที่</th>
                        <th class="text-center ">หัวข้อ</th>
                        <?php

                        for ($i = 1 ; $i <= $sumN ; $i++){

                            ?>

                            <th class="text-center"><?php print $i?></th>

                            <?php

                        }

                        ?>
                        </thead>
                        <tbody>
                        <?php
                        $sql_question="SELECT * FROM survey_question WHERE survey_id = '".$survey_id."' and question != ''";
                        $query_question=mysqli_query($conn,$sql_question);
                        $numQuestion = 0;
                        $numChoice = 0;
                        while($fetch_question=mysqli_fetch_assoc($query_question)){
                            if($fetch_question['type'] == 'QUESTION'){
                                $numQuestion++;
                                ?>
                                <tr>
                                <td class="text-center"><?php print $numQuestion?></td>
                                <td><?php print $fetch_question['question']?></td>

                                <?php
                                $numChoice++;

                                for($j=0 ;$j<$sumN; $j++){




                                    ?>
                                    <td class="text-center" data-container="body" data-toggle="tooltip"
                                        title="<?php print $student_name[$numChoice-1][$j]?> <?php print $student_last_name[$numChoice-1][$j]?>"><?php print $x[$numChoice-1][$j]?></td>

                                    <?php

                                }
                            }
                            elseif($fetch_question['type'] == 'TOPIC'){
                                $numQuestion=0;
                            }

                            ?>
                            </tr>
                            <?php

                        }


                        ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        <div id="menu4" class="tab-pane fade">

            <br>
            <br>
            <div class="col-md-12">

                <div class="text-right">
                    <a class="btn btn-success" href="semester-summary-remark-excel.php?survey_name=<?php print $survey_name?>&semester=<?php print $semester?>&year=<?php print $year?>"><span class="glyphicon glyphicon-download-alt"></span> ดาวน์โหลดไฟล์ excel</a>
                </div>
                <br>
                <br>

                <table class="table table-bordered" cellspacing="0" style="font-size: 12px" id="data-table">
                    <thead>

                    <th class="text-center">ที่</th>
                    <th class="text-center">รหัสนักศึกษา</th>
                    <th class="text-center">ชื่อ - นามสกุล</th>
                    <th class="text-center">ข้อคิดเห็น/ข้อเสนอแนะ</th>
                    </thead>
                    <tbody>

                    <?php

                    $num = 0;
                    foreach ($remarks as $remark){

                        $num++;
                        ?>
                        <tr>
                            <td class="text-center"><?php print $num?></td>
                            <td class="text-center"><?php print $remark['student_id']?></td>
                            <td class="text-center"><?php print $remark['student_first_name']?> <?php print $remark['student_last_name']?></td>
                            <td class="text-center"><?php print $remark['remark']?></td>
                        </tr>
                        <?php
                    }
                    ?>

                    </tbody>
                </table>

            </div>
        </div>





        <!--        -->

    </div>







</div>


<script>

    <?php
    $sql_question_topic="SELECT * FROM survey_question WHERE survey_id = '".$survey_id."' and type = 'TOPIC' and question != ''";
    $query_question_topic=mysqli_query($conn,$sql_question_topic);
    $numJS = 0;
    $questionNameArray = array();
    $scoreArray = array();

    $num = 0;
    $topic = 0;

    while($fetch_question_topic=mysqli_fetch_assoc($query_question_topic)){
    $numJS++;


    $sql_question="SELECT * FROM survey_question WHERE survey_id = '".$survey_id."' and topic_id = '".$fetch_question_topic['topic_id']."' and type = 'QUESTION' and question != ''";
    $query_question=mysqli_query($conn,$sql_question);

    while($fetch_question=mysqli_fetch_assoc($query_question)){
        $num++;
        $questionNameArray[] = $fetch_question['question'];
        $sql_question_score="SELECT * FROM survey_score WHERE course_id = '".$course_id."' and survey_question_id = '".$fetch_question['id']."'";
        $query_question_score=mysqli_query($conn,$sql_question_score);
        $sumScore = 0;
        $nAll = 0;
        while($fetch_question_score=mysqli_fetch_assoc($query_question_score)){
            $nAll++;
            $sumScore += $fetch_question_score['score'];
        }
        $xBar = $sumScore / $nAll;
        $scoreArray[] = $xBar;
    }



    ?>



    var myChart = new Chart(document.getElementById("myChart"+<?php print $numJS?>), {
        type: 'bar',
        data: {
            labels: [
                <?php foreach ($questionNameArray as $questionName){

                print '"'.$questionName.'",';
            }
                ?>
            ],
            datasets: [{

                label: '<?php print $fetch_question_topic['question']?>',
                data: [
                    <?php for ($i = $topic ; $i < $num ; $i++){

                    print $sumX[$i]/$n[$i].',';
                }

                    ?>
                ],
                backgroundColor: [
                    <?php
                    foreach ($questionNameArray as $questionName) {
                        echo "'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',";
                    }
                    ?>

                ],
                borderColor: [
                    <?php
                    foreach ($questionNameArray as $questionName) {
                        echo "'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',";
                    }
                    ?>

                ],
                borderWidth: 1
            }]
        },
        options: {

            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }],
                xAxes: [{
                    ticks: {
                        autoSkip: false,
                        minRotation: 25,
                        maxRotation: 0
                    }
                }]
            }
        }
    });



    <?php
    unset($questionNameArray);
    unset($scoreArray);
    $topic = $num;
    }
    ?>



</script>



</body>
</html>
