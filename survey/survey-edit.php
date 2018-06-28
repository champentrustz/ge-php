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

$survey_id = $_SESSION['survey_id'];
$course_id = $_SESSION['course_id'];
$group_id = $_SESSION['group_id'];
$semester = $_SESSION['semester'];
$year = $_SESSION['year'];



$survey_sql="SELECT * FROM survey WHERE id = '".$survey_id."'";
$query_survey=mysqli_query($conn,$survey_sql);
$fetch_survey=mysqli_fetch_assoc($query_survey);


$survey_course_sql="SELECT * FROM survey_course WHERE id = '".$fetch_survey['id']."' and course_id = '".$course_id."' and group_id = '".$group_id."' and semester = '".$semester."' and year = '".$year."'";
$query_survey_course=mysqli_query($conn,$survey_course_sql);
$fetch_survey_course=mysqli_fetch_assoc($query_survey_course);



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

    setInterval(function(){ showTeacher(); }, 500);

    $( document ).ready(function() {
        var typeRadio = '<?php print $fetch_survey['type']?>';
        if (typeRadio === 'TEACHER') {
            $("#teacher").attr('checked', 'checked');
        }
        else if (typeRadio === 'TA') {
            $("#ta").attr('checked', 'checked');
        }
        else if (typeRadio === 'LECTURER') {
            $("#lecturer").attr('checked', 'checked');
        }
    });

</script>




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

            var dataTeacherArray = []

            if ($("#teacher").is(':checked')) {


                dataTeacherArray = [];
                dataTeacher.forEach(function (teacher, index) {

                    dataTeacherArray[index] = {
                        'label': teacher.teacherPosition + ' ' + teacher.teacherName + ' ' + teacher.teacherLastname,
                        'value': teacher.teacherPosition + ' ' + teacher.teacherName + ' ' + teacher.teacherLastname
                    };

                });
            }


            else if ($("#ta").is(':checked')) {
                dataTeacherArray = [];
                dataTA.forEach(function (TA, index) {

                    dataTeacherArray[index] = {
                        'label': TA.taName + ' ' + TA.taLastname,
                        'value': TA.taName + ' ' + TA.taLastname
                    };

                });
            }

            else if ($("#lecturer").is(':checked')) {

                dataTeacherArray = [];
                dataTA.forEach(function(TA,index) {

                    dataTeacherArray[index] = {'label':TA.taName+' '+TA.taLastname,'value':TA.taName+' '+TA.taLastname};

                });
            }









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







<div class="container">
    <br />

    <form data-toggle="validator" action="function-edit-survey.php" method="post" >

    <div class="col-md-12">
        <div class="form-group">
            <label for="topic">ชื่อแบบประเมิน</label>
            <input class="form-control" type="text" id="topic" name="topic" value="<?php print $fetch_survey['topic']?>" required >
        </div>


            <div class="form-group">
                <label for="type">แบบประเมินสำหรับ</label>
                <br/>
                <label class="radio-inline"><input type="radio" name="type-radio" value="TEACHER" id="teacher" required >อาจารย์</label>
                <label class="radio-inline"><input type="radio" name="type-radio" value="TA" id="ta" required >ผู้ช่วยสอน</label>
                <label class="radio-inline"><input type="radio" name="type-radio" value="LECTURER" id="lecturer" required>วิทยากร</label>
            </div>

        <div class="form-group">
            <label for="teacher">ชื่อผู้สอน</label>
            <input type="text" id="search" name='teacher_name' class="form-control " value="<?php print $fetch_survey['teacher_name']?>" required>
        </div>

        <div class="form-group">
            <label for="semester">ภาคเรียน</label>
            <input type="number" id="semester" name="semester" class="form-control" style="width: 15%" value="<?php print $semester?>" required>
        </div>


        <div class="form-group">
            <label for="year">ปีการศึกษา</label>
            <input type="number" id="year" name="year" class="form-control" style="width: 15%" value="<?php print $year?>" required>
        </div>
        <br/>

    </div>



        <div class="col-md-12">




            <table class="table table-bordered" cellspacing="0" >
                <thead>
                <tr>

                    <th class="text-center">ประเภท</th>
                    <th class="text-center">หัวข้อ / ประเด็นคำถาม</th>


                </tr>
                </thead>
                <tbody>

        <?php

        $survey_question_sql="SELECT * FROM survey_question WHERE survey_id = '".$survey_id."'";
        $query_survey_question=mysqli_query($conn,$survey_question_sql);
        $arr_question[] = null;
        while($fetch_survey_question = mysqli_fetch_assoc($query_survey_question)){
            $arr_question[] = $fetch_survey_question['question'];
            $arr_type[] = $fetch_survey_question['type'];
            $id[] = $fetch_survey_question['id'];
        }



        for($i=0;$i<$fetch_survey['amount'];$i++) {




                    ?>

            <tr id="select-type<?php print $i?>">



                <td class="text-center">
                    <select name="type[]" class="form-control" id="type-question<?php print $i?>">
                        <option value="QUESTION" <?php if($arr_type[$i] == "QUESTION") echo "selected"?>>คำถาม</option>
                        <option value="TOPIC" <?php if($arr_type[$i] == "TOPIC") echo "selected"?>>หัวข้อ</option>
                    </select>
                </td>

                <td class="text-center">
                    <input type="text" class="form-control" name="question[]"
                           value="<?php print $arr_question[$i+1]?>">
                </td>


            </tr>



                    <input type="hidden" name="primary_id[]" value="<?php print $id[$i] ?>">
                    <input type="hidden" name="survey_question_id[]" value="<?php print $fetch_survey_question['id'] ?>">

        <?php

        }?>

                </tbody>
            </table>
        </div>
        <input type="hidden" name="numrow" value="<?php print $fetch_survey['amount']?>">
        <input type="hidden" name="survey_id" value="<?php print $survey_id?>">

        <div class="col-md-12">
            <button class="btn btn-success btn-block" type="submit">บันทึกแบบประเมิน</button>
            <br/>
            <br/>
            <br/>
            <br/>
        </div>


    </form>


</div>

<script>
    const length = '<?php print $i?>';
    let type = null;
    setInterval(function(){
        for(let i = 0 ; i< length ; i++){
            type = $( "#type-question"+i ).val();
            if(type == 'TOPIC'){
                $( "#select-type"+i ).addClass( "bg-info" );
            }
            else{
                $( "#select-type"+i ).removeClass( "bg-info" );
            }


        }



    }, 200);



</script>

</body>
</html>
