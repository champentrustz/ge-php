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
$nameExcel = '(สรุปแบบประเมินรายบุคคล)'.$teacher_name.'-ข้อคิดเห็น-'.$survey_name.'-'.$semester.'-'.$year.'.xls';
header("Content-Disposition: attachment; filename=$nameExcel");
header("Content-Type: application/xls");

?>


<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">



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

<body>



    <table class="table table-bordered " style="font-size: 12px">
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
                <td class="text-center"><?php print $remark['student_first_name']?> <?php print $fetch_comment['student_last_name']?></td>
                <td class="text-center"><?php print $remark['remark']?></td>
            </tr>
            <?php
        }
        ?>


        </tbody>
    </table>

</body>
</html>



