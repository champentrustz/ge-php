<?php
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

$course_id = $_GET['course_id'];
$group_id = $_GET['group_id'];



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
    $( document ).ready(function() {
        showStudent();
    });
</script>

<script>

    $(document).ready(function() {

        setTimeout(function(){  $('#table-student').DataTable({
            "pageLength": 100,
        }); }, 1500);


    } );


</script>


<script>




    async function showStudent() {

        var courseID =  '<?php print $course_id;?>';
        var groupID =   '<?php print $group_id;?>';


        const resp = await fetch('http://ge-tss.ssru.ac.th/index.php/Checkinapi/getStudentInGroup', {
            method: 'post',
            headers: {
                Accept: 'application/json',
            },
            body: JSON.stringify({
                apiKey: "afab7e2f35fe11c45116e2315e7387b6",
                sReturn: "1",
                subject_id : courseID,
                group_id : groupID
            }),
        });
        const data = await resp.json();
        const dataAll = data.data;


        const respAttend = await fetch('http://ge-tss.ssru.ac.th/index.php/Checkinapi/getDataAttendBySubject', {
            method: 'post',
            headers: {
                Accept: 'application/json',
            },
            body: JSON.stringify({
                apiKey: "afab7e2f35fe11c45116e2315e7387b6",
                sReturn: "1",
                course_id : courseID,
                group_id : groupID
            }),
        });
        const dataResp = await respAttend.json();
        const dataAttend = dataResp.data;



        var showStudent =null;
        let numStudent = 0;

        if(dataAll.length > 0){
            dataAll.forEach(function(student,index) {
                numStudent++;
                var scoreStudent = 0;

                dataAttend.forEach(function(dataAttend) {


                    dataAttend.aStudentAttend.forEach(function(attend) {



                            if(student.student_id === attend.oStudent.studentID){



                                attend.aAttend.forEach(function(attendStudent) {

                                    if(attendStudent.attend_time_exit !== null && attendStudent.attend_time_exit !== '00:00'){

                                        if(attendStudent.attend_status === 'C' || attendStudent.attend_status === 'CL'){

                                            scoreStudent += (10/6);
                                        }
                                    }



                                })


                            }



                    });
                });



                index += 1;

                showStudent += '<tr class="text-center"><td>'+index+'</td><td>'+student.student_id+'</td><td>'+student.student_name+' '+student.student_lastname+'</td><td>'+scoreStudent.toFixed(2)+'</td></tr>'

            });
            $( "#show-student" ).html(showStudent);
            $( "#num-student" ).html('<input type="hidden" value='+numStudent+'>');
        }




    }
</script>









<div class="container">
    <br />



    <div class="col-md-12">

        <br/>
        <div class="col-md-12 text-right">

            <form action="function-send-email.php" method="post">

            <div id="num-student">

            </div>

        <button class="btn btn-success"><span class="glyphicon glyphicon-envelope"></span> ส่งอีเมล</button>
            <br/>
            <br/>
            </form>
        </div>




        <table class="table table-bordered" cellspacing="0" id="table-student" ">

            <thead>
            <tr>
                <th class="text-center">ที่</th>
                <th class="text-center">รหัสนักศึกษา</th>
                <th class="text-center">ชื่อ - นามสกุล</th>
                <th class="text-center">คะแนน</th>



            </tr>
            </thead>
            <tbody id="show-student">

            <?php
            $course_sql="SELECT * FROM Course WHERE deleteAt is NULL";
            $query_course=mysqli_query($conn,$course_sql);
            $i = 0;
            while($fetch_course=mysqli_fetch_assoc($query_course)){

                $i++

                ?>


                <?php
            }
            ?>



            </tbody>

        </table>


    </div>

</div>



</body>
</html>
