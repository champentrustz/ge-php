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

$search = $_REQUEST['search'];
$course_id = $_REQUEST['course_id'];

if($search === 'true'){
    $semester = $_REQUEST['semester-year'];
    $semester = substr($semester,0,1);
    $year = $_REQUEST['semester-year'];
    $year = substr($year,2,6);
}
else {
    $semester_sql = "SELECT DISTINCT semester,year FROM survey_course WHERE course_id = '" . $course_id . "' order by year desc ,  semester desc ";
    $query_semester = mysqli_query($conn, $semester_sql);
    $fetch_semester = mysqli_fetch_assoc($query_semester);
    $semester = $fetch_semester['semester'];
    $year = $fetch_semester['year'];
}
$course_name = null;
$array_survey = array();
$arrayUnique = array();
$survey_course_sql="SELECT distinct survey_id,name FROM survey_course WHERE course_id='".$course_id."' and semester = '".$semester."' and year = '".$year."' and  deletedAt is NULL";
$query_survey_course=mysqli_query($conn,$survey_course_sql);
while($fetch_survey_course=mysqli_fetch_assoc($query_survey_course)){
    $course_name = $fetch_survey_course['name'];
    $survey_sql = "SELECT * FROM survey WHERE id='" . $fetch_survey_course['survey_id'] . "' and semester = '" . $semester . "' and year = '" . $year . "' and topic NOT LIKE '%[copy]%'  and  deletedAt is NULL";
    $query_survey = mysqli_query($conn, $survey_sql);
    $i = 1;
    while ($fetch_survey = mysqli_fetch_assoc($query_survey)) {
        $array_survey[] = $fetch_survey;

    }
}

function unique_multidim_array($array, $key) {
    $temp_array = array();
    $i = 0;
    $key_array = array();

    foreach($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;

        }
        $i++;
    }
    return $temp_array;
}

$details = unique_multidim_array($array_survey,'topic');











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



</script>



<body>



<div class="container">
    <br />






    <div class="col-sm-12 text-right">
        <form action="course-summary.php?course_id=<?php print $course_id?>&search=true" method="post">
            <strong>ภาคเรียน</strong>

            <select class="btn" name="semester-year">
                <?php

                $semester_sql="SELECT DISTINCT semester,year FROM survey_course WHERE course_id = '" . $course_id . "' order by year desc ,  semester desc ";;
                $query_semester=mysqli_query($conn,$semester_sql);
                while($fetch_semester=mysqli_fetch_assoc($query_semester)){
                    ?>
                    <option value="<?php print $fetch_semester['semester']?>-<?php print $fetch_semester['year']?>" <?php if($fetch_semester['semester'] == $semester && $fetch_semester['year'] == $year) echo 'selected'?>><?php print $fetch_semester['semester']?>/<?php print $fetch_semester['year']?></option>
                    <?php
                }
                ?>
            </select>
            <button class="btn btn-primary" type="submit">ค้นหา</button>
        </form>
    </div>

    <br/>
    <br/>


    <div class="col-md-12">

        <label>รายการแบบประเมินวิชา <?php print $course_id?> <?php print $course_name?></label>


        <br/>
        <br/>


        <table class="table table-bordered" cellspacing="0" id="data-table">
            <thead>
            <tr>
                <th class="text-center">ที่</th>
                <th class="text-center">ชื่อแบบประเมิน</th>
                <th class="text-center"><span class="glyphicon glyphicon-cog"></span></th>



            </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;
            foreach ($details as $detail) {



                ?>

                <tr>
                    <td class="text-center"><?php print $i?></td>
                    <td class="text-center"><?php print $detail['topic'] ?></td>
                    <td class="text-center">
                        <button onclick=" window.open('course-summary-view.php?course_id=<?php print $course_id?>&survey_name=<?php print $detail['topic']?>&semester=<?php print $detail['semester']?>&year=<?php print $detail['year']?>','summary-survey ','width=1200,height=1000');"
                                class="btn btn-success btn-xs">สรุปผล
                        </button>
                    </td>


                </tr>


                <?php
                $i++;
            }
            ?>



            </tbody>

        </table>


    </div>







    <!--        -->

</div>




</body>
</html>
