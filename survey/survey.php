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

$monthdis = date('n');


if($search == 'true'){
    $semester = $_REQUEST['semester-year'];
    $semester = substr($semester,0,1);
    $year = $_REQUEST['semester-year'];
    $year = substr($year,2,6);
}
else if($search == 'duplicate'){
    $semester = $_REQUEST['semester'];
    $year = $_REQUEST['year'];
}
else {

$semester_sql="SELECT DISTINCT semester,year FROM survey_course order by year desc ,  semester desc ";
$query_semester=mysqli_query($conn,$semester_sql);
$fetch_semester=mysqli_fetch_assoc($query_semester);
$semester = $fetch_semester['semester'];
$year = $fetch_semester['year'];
}





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


    <script>

        async function showTeacher(){



            const resp = await fetch('http://ge-tss.ssru.ac.th/index.php/Checkinapi/getOfficerAll', {
                method: 'post',
                headers: {
                    Accept: 'application/json',
                },
                body: JSON.stringify({
                    apiKey : "afab7e2f35fe11c45116e2315e7387b6",
                    sReturn : "1",
                }),
            });
            const  data  = await resp.json();
            const dataAll = data.data;

            var dataTeacher = dataAll.teacher;
            var dataTA = dataAll.ta;

            var dataTeacherArray = [];

            $( "#teacher" ).on( "click", function() {
                dataTeacherArray = [];
                dataTeacher.forEach(function(teacher,index) {

                    dataTeacherArray[index] = {'label':teacher.teacherPosition+' '+teacher.teacherName+' '+teacher.teacherLastname,'value':teacher.teacherPosition+' '+teacher.teacherName+' '+teacher.teacherLastname};

                });
            });


            $( "#ta" ).on( "click", function() {
                dataTeacherArray = [];
                dataTA.forEach(function(TA,index) {

                    dataTeacherArray[index] = {'label':TA.taName+' '+TA.taLastname,'value':TA.taName+' '+TA.taLastname};

                });
                });

            $( "#lecturer" ).on( "click", function() {
                dataTeacherArray = [];
            dataTA.forEach(function(TA,index) {

                dataTeacherArray[index] = {'label':TA.taName+' '+TA.taLastname,'value':TA.taName+' '+TA.taLastname};

            });
          });





            var options = {
                source: function(request, response) {
                    var results = $.ui.autocomplete.filter(dataTeacherArray, request.term);
                    response(results.slice(0, 10));},
                select: function(event, ui) {
                    event.preventDefault();
                    $(this).val(ui.item.value);

                }
            };
            $(document).on('keydown.autocomplete ', '#search', function() {

                $(this).autocomplete(options);

            });

        }


    </script>

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


</script>

<script>

    $(document).ready(function(){
        $("#myBtn").click(function(){
            $("#myModal").modal();
        });
    });

</script>





<script>
    function editSurvey(survey_id,course_id,group_id,semester,year){
        const win = window.open('function-session-edit.php?survey_id='+survey_id+'&course_id='+course_id+'&group_id='+group_id+'&semester='+semester+'&year='+year,'session-edit ','width=1200,height=1000');
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




    <div class="col-sm-12">
    <button type="button" class="btn btn-success" id="myBtn" onclick="showTeacher()"><span class="glyphicon glyphicon-plus"></span> สร้างแบบประเมิน</button>
    </div>


<br/>
    <br/>
    <hr/>




    <div class="col-sm-12 text-right">
        <form action="survey.php?search=true" method="post">
        <strong>ภาคเรียน</strong>

        <select class="btn" name="semester-year">
            <?php

            $semester_sql="SELECT DISTINCT semester,year FROM survey_course order by year desc ,  semester desc ";
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


        <br/>



           <table class="table table-bordered" cellspacing="0" id="table-survey">
               <thead>
               <tr>
                   <th class="text-center">ลำดับ</th>
                   <th class="text-center">ชื่อแบบประเมิน</th>
                   <th class="text-center">ผู้สอน</th>
                   <th class="text-center">วิชา</th>
                   <th class="text-center">กลุ่ม</th>
                   <th class="text-center"><span class="glyphicon glyphicon-cog"></span></th>
                   <th class="text-center"><span class="glyphicon glyphicon-cog"></span></th>
                   <th class="text-center"><span class="glyphicon glyphicon-cog"></span></th>
                   <th class="text-center"><span class="glyphicon glyphicon-cog"></span></th>



               </tr>
               </thead>
               <tbody>

               <?php

        $survey_sql="SELECT * FROM survey WHERE deletedAt is NULL";
        $query_survey=mysqli_query($conn,$survey_sql);
        $i = 1;
        while($fetch_survey=mysqli_fetch_assoc($query_survey)){
            $survey_course_sql="SELECT * FROM survey_course WHERE survey_id = '".$fetch_survey['id']."' and semester = '".$semester."' and year = '".$year."' and deletedAt IS NULL order by course_id asc, group_id asc";
            $query_survey_course=mysqli_query($conn,$survey_course_sql);
            $row_survey_course = $query_survey_course->num_rows;

                while ($fetch_survey_course = mysqli_fetch_assoc($query_survey_course)) {



                        $course_id = $fetch_survey_course['course_id'];

                    ?>

                    <tr>
                        <td class="text-center"><?php print $i?></td>
                        <td class="text-center"><?php print $fetch_survey['topic']?></td>
                        <td class="text-center"><?php print $fetch_survey['teacher_name']?></td>
                        <td class="text-center"><?php print $fetch_survey_course['course_id']?></td>
                        <td class="text-center"><?php print $fetch_survey_course['group_name']?></td>
                        <td class="text-center">
                            <button onclick=" window.open('summary-survey.php?survey_course_id=<?php print $fetch_survey_course['id']?>&course_id=<?php print $fetch_survey_course['course_id']?>&group_id=<?php print $fetch_survey_course['group_id']?>&semester=<?php print $fetch_survey_course['semester']?>&year=<?php print $fetch_survey_course['year']?>','summary-survey ','width=1200,height=1000');" class="btn btn-success btn-xs">สรุปผล</button>
                        </td>
                        <td class="text-center">
                            <button onclick="editSurvey(<?php print $fetch_survey['id']?>,'<?php print $fetch_survey_course['course_id']?>',<?php print $fetch_survey_course['group_id']?>,<?php print $fetch_survey_course['semester']?>,<?php print $fetch_survey_course['year']?>)" class="btn btn-warning btn-xs">แก้ไข</button>
                        </td>
                        <td class="text-center">
                            <a href="function-duplicate-survey.php?survey_course_id=<?php print $fetch_survey_course['id']?>&semester=<?php print $semester?>&year=<?php print $year?>" class="btn btn-info btn-xs">ทำซ้ำ</a>
                        </td>
                        <td class="text-center">
                            <a href="function-delete-survey.php?survey_course_id=<?php print $fetch_survey_course['id']?>&semester=<?php print $semester?>&year=<?php print $year?>" class="btn btn-danger btn-xs">ลบ</a>
                        </td>

                    </tr>

                    <?php
                    $i++;
                }
                }
 ?>



               </tbody>

           </table>

        <div class="modal fade" id="myModal" role="dialog">

            <div class="modal-dialog">

                <form data-toggle="validator" action="function-add-survey.php" method="post" name="add">

                <!-- Modal content-->
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">สร้างแบบประเมิน</h4>
                    </div>
                    <div class="modal-body">





                        <strong>ชื่อแบบประเมิน</strong>
                            <input type="text" class="form-control" name="topic" required>
                        <p></p>

                        <strong>ภาคการศึกษา</strong>
                            <input type="number" class="form-control " name="semester" min="1" style="width:150px" required>

                        <p></p>

                        <strong>ปีการศึกษา (พ.ศ.)</strong>
                        <input type="number" class="form-control " name="year" style="width:150px" required>

                        <p></p>


                        <p></p>

                        <strong>แบบประเมินสำหรับ</strong>
                        <p></p>
                        <label class="radio-inline"><input type="radio" name="type" value="TEACHER" id="teacher" required>อาจารย์</label>
                        <label class="radio-inline"><input type="radio" name="type" value="TA" id="ta" required>ผู้ช่วยสอน</label>
                        <label class="radio-inline"><input type="radio" name="type" value="LECTURER" id="lecturer" required>วิทยากร</label>

                        <p></p>


                        <strong>ชื่อผู้สอน</strong>
                        <br>
                        <input type="text" id="search" name='teacher_name' class="form-control " required>


                        <p></p>


                        <strong>จำนวนคำถามรวมหัวข้อ</strong>
                            <input input type="number" min=1 class="form-control" name="amount" required>
                        <p></p>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" >บันทึก</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>

                    </div>

                </div>
                </form>
            </div>

        </div>

    </div>

    </div>



</body>
</html>
