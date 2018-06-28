<?php

$survey_id = $_REQUEST['survey_id'];
$course_id = $_REQUEST['course_id'];
$group_id = $_REQUEST['group_id'];


    //$nameExcel = $course_id.'-'.$group_id.'.xls';
//header("Content-Disposition: attachment; filename=$nameExcel");
//header("Content-Type: application/xls");

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





<body>



<div class="container">




        <br>
        <br>

        <?php

        $sql_question_topic="SELECT * FROM survey_question WHERE survey_id = '".$fetch_survey_course['survey_id']."' and type = 'TOPIC'";
        $query_question_topic=mysqli_query($conn,$sql_question_topic);
        $numJS = 0;

        while($fetch_question_topic=mysqli_fetch_assoc($query_question_topic)) {
            $numJS++;
            ?>




                        <div class="chart-container" style="position: relative; height:400px; width:1000px">
                         <canvas id="myChart<?php print $numJS?>"></canvas>
                        </div>


            <br/>
            <br/>


            <?php
        }
        ?>

        <br/>



</div>





<script>

    <?php
    $sql_question_topic="SELECT * FROM survey_question WHERE survey_id = '".$fetch_survey_course['survey_id']."' and type = 'TOPIC'";
    $query_question_topic=mysqli_query($conn,$sql_question_topic);
    $numJS = 0;
    $questionNameArray = array();
    $scoreArray = array();

    while($fetch_question_topic=mysqli_fetch_assoc($query_question_topic)){
    $numJS++;

    $sql_question="SELECT * FROM survey_question WHERE survey_id = '".$fetch_survey_course['survey_id']."' and topic_id = '".$fetch_question_topic['topic_id']."' and type = 'QUESTION'";
    $query_question=mysqli_query($conn,$sql_question);
    while($fetch_question=mysqli_fetch_assoc($query_question)){
        $questionNameArray[] = $fetch_question['question'];
        $sql_question_score="SELECT * FROM survey_score WHERE survey_course_id = '".$fetch_survey_course['id']."' and survey_question_id = '".$fetch_question['id']."'";
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
                    <?php foreach ($scoreArray as $score){

                    print $score.',';
                }

                    ?>
                ],
                backgroundColor: [
                    <?php
                    foreach ($questionNameArray as $questionName) {
                        echo "'rgba(54, 162, 235, 0.2)',";
                    }
                    ?>

                ],
                borderColor: [
                    <?php
                    foreach ($questionNameArray as $questionName) {
                        echo "'rgba(54, 162, 235, 1)',";
                    }
                    ?>

                ],
                borderWidth: 1
            }]
        },
        options: {

            responsive: true,
            maintainAspectRatio: false,

            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }],
                xAxes: [{
                    ticks: {
                        autoSkip: false,
                        minRotation: 25
                    }
                }]
            }
        }
    });



    <?php
    unset($questionNameArray);
    unset($scoreArray);
    }
    ?>



</script>




</body>
</html>
