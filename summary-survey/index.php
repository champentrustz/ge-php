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

if($search === 'true'){
    $semester = $_REQUEST['semester-year'];
    $semester = substr($semester,0,1);
    $year = $_REQUEST['semester-year'];
    $year = substr($year,2,6);
}
else {
    $semester_sql = "SELECT DISTINCT semester,year FROM survey order by year desc ,  semester desc ";
    $query_semester = mysqli_query($conn, $semester_sql);
    $fetch_semester = mysqli_fetch_assoc($query_semester);
    $semester = $fetch_semester['semester'];
    $year = $fetch_semester['year'];
}

$course_name = null;
$array_survey = array();
$arrayUnique = array();
$survey_sql="SELECT * FROM survey WHERE semester = '".$semester."' and year = '".$year."' and  deletedAt is NULL and topic not like '%[copy]%'";
$query_survey=mysqli_query($conn,$survey_sql);
$i = 1;
while($fetch_survey=mysqli_fetch_assoc($query_survey)){
    $array_survey[] = $fetch_survey;
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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>

    <script  type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script  type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>



</head>



<style>
    .ui-autocomplete
    {
        z-index: 99999; //Maximum and top of everything (not absolutely :| )
    }

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

    $(document).ready(function() {
        $('#table-survey').DataTable({
            "pageLength": 100,
        });
    } );

    $(document).ready(function() {
        $('#table-teacher').DataTable({
            "pageLength": 100,
        });
    } );

    $(document).ready(function() {
        $('#table-semester').DataTable({
            "pageLength": 100,
        });
    } );



    $(document).ready(function() {
        var search = '<?php print $search?>';


        if(search == 'true'){
            $( "#menu1-active" ).removeClass( "active" );
            $( "#menu3-active" ).addClass( "active" );
            $( "#menu1" ).removeClass( "fade in active" );
            $( "#menu3" ).addClass( "fade in active" );



        }
    });





</script>







<!--<script>-->
<!--    function editSurvey(survey_id,course_id,group_id,semester,year){-->
<!--        const win = window.open('function-session-edit.php?survey_id='+survey_id+'&course_id='+course_id+'&group_id='+group_id+'&semester='+semester+'&year='+year,'session-edit ','width=1200,height=1000');-->
<!--        var timer = setInterval(function() {-->
<!--            if(win.closed) {-->
<!--                clearInterval(timer);-->
<!--                window.location.reload();-->
<!--            }-->
<!--        }, 500);-->
<!--    }-->
<!---->
<!--</script>-->








<div class="container">
    <br />



    <ul class="nav nav-tabs">
        <li class="active" id="menu1-active"><a data-toggle="tab" href="#menu1">สรุปผลรายวิชา</a></li>
        <li id="menu2-active"><a data-toggle="tab" href="#menu2">สรุปผลรายบุคคล</a></li>
        <li id="menu3-active"><a data-toggle="tab" href="#menu3">สรุปรายภาคเรียน</a></li>

    </ul>

    <div class="tab-content">


        <div id="menu1" class="tab-pane fade in active">




                <br/>



                <table class="table table-bordered" cellspacing="0" id="table-survey">
                    <thead>
                    <tr>
                        <th class="text-center">ที่</th>
                        <th class="text-center">รหัสวิชา</th>
                        <th class="text-center">ชื่อวิชา</th>
                        <th class="text-center"><span class="glyphicon glyphicon-cog"></span></th>



                    </tr>
                    </thead>
                    <tbody>

                    <?php

                    $course_sql="SELECT DISTINCT code,name FROM Course order by code asc";
                    $query_course=mysqli_query($conn,$course_sql);
                    $i = 1;
                    while($fetch_course=mysqli_fetch_assoc($query_course)){




                            ?>

                            <tr>
                                <td class="text-center"><?php print $i?></td>
                                <td class="text-center"><?php print $fetch_course['code']?></td>
                                <td class="text-center"><?php print $fetch_course['name']?></td>
                                <td class="text-center">
                                    <button onclick=" window.open('course-summary.php?course_id=<?php print $fetch_course['code']?>','course-summary ','width=1200,height=1000');" class="btn btn-success btn-xs">สรุปผล</button>
                                </td>

                            </tr>

                            <?php
                        $i++;

                    }
                    ?>



                    </tbody>

                </table>




        </div>

        <div id="menu2" class="tab-pane">




            <br/>



            <table class="table table-bordered" cellspacing="0" id="table-teacher">
                <thead>
                <tr>
                    <th class="text-center">ที่</th>
                    <th class="text-center">ชื่อผู้สอน</th>
                    <th class="text-center"><span class="glyphicon glyphicon-cog"></span></th>



                </tr>
                </thead>
                <tbody>

                <?php

                $survey_sql="SELECT DISTINCT teacher_name FROM survey";
                $query_survey=mysqli_query($conn,$survey_sql);
                $i = 1;
                while($fetch_survey=mysqli_fetch_assoc($query_survey)){




                    ?>

                    <tr>
                        <td class="text-center"><?php print $i?></td>
                        <td class="text-center"><?php print $fetch_survey['teacher_name']?></td>
                        <td class="text-center">
                            <button onclick=" window.open('teacher-summary.php?teacher_name=<?php print $fetch_survey['teacher_name']?>','teacher-summary ','width=1200,height=1000');" class="btn btn-success btn-xs">แบบประเมิน</button>
                        </td>

                    </tr>

                    <?php
                    $i++;

                }
                ?>



                </tbody>

            </table>




        </div>

        <div id="menu3" class="tab-pane">

            <br/>






        <div class="col-md-12">

            <div class="col-sm-12 text-right">
                <form action="index.php?search=true" method="post">
                    <strong>ภาคเรียน</strong>

                    <select class="btn" name="semester-year">
                        <?php

                        $semester_sql="SELECT DISTINCT semester,year FROM survey order by year desc ,  semester desc ";
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




            <table class="table table-bordered" cellspacing="0" id="table-semester">
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
                            <button onclick=" window.open('semester-summary-view.php?survey_name=<?php print $detail['topic']?>&semester=<?php print $detail['semester']?>&year=<?php print $detail['year']?>','summary-survey ','width=1200,height=1000');"
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
        </div>


    </div>




</div>



</body>
</html>
