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

$course_id = $_REQUEST['course_id'];
$course_section = $_REQUEST['course_section'];
$student_id = $_REQUEST['student_id'];
$student_gender = $_REQUEST['student_gender'];
$semester = $_REQUEST['semester'];
$year = $_REQUEST['year'];
$first_name = $_REQUEST['first_name'];
$last_name = $_REQUEST['last_name'];

if($student_gender == 'W'){
    $student_gender = 0; //0 = woman
}
else{
    $student_gender = 1;
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


<script>




    function doSurvey(survey_course_id,student_id,student_gender,semester,year){

        var course_id = '<?php echo $course_id?>';
        var group_id = '<?php echo $course_section?>';
        var first_name = '<?php echo $first_name?>';
        var last_name = '<?php echo $last_name?>';

        const win = window.open('function-session-do-survey.php?survey_course_id='+survey_course_id+'&student_id='+student_id+'&student_gender='+student_gender+'&course_id='+course_id+'&group_id='+group_id+'&semester='+semester+'&year='+year+'&first_name='+first_name+'&last_name='+last_name,'session-do-survey ','width=1200,height=1000');
        var timer = setInterval(function() {
            if(win.closed) {
                clearInterval(timer);
                window.location.reload();
            }
        }, 500);
    }

</script>





<div class="container">
    <br />



    <table class="table">
        <thead>
        <tr>
            <th class="text-center">ที่</th>
            <th class="text-center">ชื่อแบบประเมิน</th>
            <th class="text-center">ชื่ออาจารย์ / วิทยากร</th>
            <th class="text-center"><span class="glyphicon glyphicon-cog"></span></th>
        </tr>
        </thead>
        <tbody>
        <?php

        $survey_course_sql="SELECT * FROM survey_course WHERE course_id = '".$course_id."' and group_id = '".$course_section."' and semester = '".$semester."' and year = '".$year."' and deletedAt is NULL";
        $query_survey_course=mysqli_query($conn,$survey_course_sql);
        $row_survey_course = $query_survey_course->num_rows;
        $i = 0;
        if($row_survey_course > 0) {

            while ($fetch_survey_course = mysqli_fetch_assoc($query_survey_course)) {

                $survey__sql="SELECT * FROM survey WHERE id = '".$fetch_survey_course['survey_id']."' and topic NOT LIKE '%[copy]%' and deletedAt is NULL";
                $query_survey=mysqli_query($conn,$survey__sql);
                while ($fetch_survey = mysqli_fetch_assoc($query_survey)) {


                    $survey_score_sql="SELECT * FROM survey_score WHERE survey_course_id = '".$fetch_survey_course['id']."' and student_id = '".$student_id."' and deletedAt is NULL";
                    $query_survey_score=mysqli_query($conn,$survey_score_sql);
                    $row_survey_score = $query_survey_score->num_rows;
                    $i++;

                    ?>

                    <tr>
                        <td class="text-center"><?php print $i?></td>
                        <td class="text-center"><?php print $fetch_survey['topic'] ?></td>
                        <td class="text-center"><?php print $fetch_survey['teacher_name'] ?></td>
                        <td class="text-center">
                            <?php if($row_survey_score > 0) {

                                ?>

                                <button class="btn btn-success btn-xs" disabled>ทำแบบประเมิน</button>

                                <?php

                    }else{
                                ?>
                                <button onclick="doSurvey(<?php print $fetch_survey_course['id']?>,<?php print $student_id?>,<?php print $student_gender?>,<?php print $semester?>,<?php print $year?>)" class="btn btn-success btn-xs">ทำแบบประเมิน</button>

                            <?php
                    }
                            ?>
                        </td>
                    </tr>


                    <?php
                }


            }
        }
        else{
            ?>

        <tr>
            <td colspan="3">
                <br>
            <ul class="list-group">
                <li class="list-group-item text-danger">
            ไม่พบแบบประเมิน
                </li>
            </ul>
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
