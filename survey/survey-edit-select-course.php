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
$survey_sql="SELECT * FROM survey WHERE id = '".$survey_id."'";
$query_survey=mysqli_query($conn,$survey_sql);
$fetch_survey=mysqli_fetch_assoc($query_survey);




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
    $(document).ready(function() {

        $('#data-table').DataTable({
            "pageLength": 100,
        });


    } );

</script>


<script>

    setInterval(function(){

        var numberOfChecked = $('input:checkbox:checked').length;
        $("#numrow").html("<input type='hidden' name='numrow' value="+numberOfChecked+" >");

    }, 100);



</script>










<div class="container">
    <br />



    <div class="col-md-12">

        <br/>


        <form action="function-edit-survey-course.php" method="post">

        <table class="table table-bordered" cellspacing="0" id="data-table">



            <thead>
            <tr>
                <th class="text-center"><span class="glyphicon glyphicon-check"></span></th>
                <th class="text-center">รหัสวิชา</th>
                <th class="text-center">ชื่อวิชา</th>
                <th class="text-center">กลุ่ม</th>



            </tr>
            </thead>
            <tbody>

            <?php
            $course_sql="SELECT * FROM Course WHERE deleteAt is NULL order by code asc , section asc";
            $query_course=mysqli_query($conn,$course_sql);
            $i = 0;
            while($fetch_course=mysqli_fetch_assoc($query_course)){

                $i++;
                $check = 0;

                    $survey_course_sql="SELECT * FROM survey_course WHERE survey_id = '".$survey_id."' and deletedAt is NULL";
                    $query_survey_course=mysqli_query($conn,$survey_course_sql);
                     while($fetch_survey_course=mysqli_fetch_assoc($query_survey_course)){

                         if($fetch_survey_course['course_id'] == $fetch_course['code'] && $fetch_survey_course['group_id'] == $fetch_course['section']){

                             $check = 1;
                         }
                     }

            ?>


            <tr class="text-center">
                <?php if($check == 1){
                    ?>
                    <td><input type="checkbox" name="checkCourse[]" value="<?php print $fetch_course['code'].'-'.$fetch_course['section'].'-'.$fetch_course['name'].'-'.$fetch_course['group_name']?>" checked></td>
                <?php
                }
                else{
                    ?>
                    <td><input type="checkbox" name="checkCourse[]" value="<?php print $fetch_course['code'].'-'.$fetch_course['section'].'-'.$fetch_course['name'].'-'.$fetch_course['group_name']?>"></td>
                <?php
                }
                ?>

                <td><?php print $fetch_course['code']?></td>
                <td><?php print $fetch_course['name']?></td>
                <td><?php print $fetch_course['group_name']?></td>
            </tr>

                <?php
                }
                ?>



            </tbody>

            <div id="numrow">

            </div>
            <input type="hidden" name="survey_id" value="<?php print $survey_id?>">





        </table>

            <br/>
                <button class="btn btn-success btn-block" type="submit">บันทึกแบบประเมิน</button>
            <br/>
            <br/>
            <br/>
            <br/>


        </form>


    </div>

</div>




</body>


</html>
