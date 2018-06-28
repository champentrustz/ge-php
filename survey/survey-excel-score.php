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

$survey_id = $_REQUEST['survey_id'];
$course_id = $_REQUEST['course_id'];
$group_id = $_REQUEST['group_id'];
$semester = $_REQUEST['semester'];
$year = $_REQUEST['year'];


$nameExcel = 'score'.$course_id.'-'.$group_id.'-'.$semester.'-'.$year.'.xls';
header("Content-Disposition: attachment; filename=$nameExcel");
header("Content-Type: application/xls");

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


<script>

    $(document).ready(function() {
        $('#data-table').DataTable();
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


            <div class="table-responsive">
                <table class="table table-bordered " style="font-size: 12px" id="data-table-score">
                    <thead>

                    <th class="text-center ">ที่</th>
                    <th class="text-center ">หัวข้อ</th>
                    <?php
                    $sql_num_student="SELECT DISTINCT student_id FROM survey_score WHERE survey_course_id = '".$fetch_survey_course['id']."'";
                    $query_num_student=mysqli_query($conn,$sql_num_student);
                    $num = 0;
                    while($fetch_num_student=mysqli_fetch_assoc($query_num_student)){
                        $num ++;
                        ?>
                        <th class="text-center"><?php print $num?></th>
                        <?php
                    }
                    ?>
                    </thead>
                    <tbody>
                    <?php
                    $sql_question="SELECT * FROM survey_question WHERE survey_id = '".$fetch_survey_course['survey_id']."'";
                    $query_question=mysqli_query($conn,$sql_question);
                    $numQuestion = 0;
                    while($fetch_question=mysqli_fetch_assoc($query_question)){
                        if($fetch_question['type'] == 'QUESTION'){
                            $numQuestion++;
                            ?>
                            <tr>
                            <td class="text-center"><?php print $numQuestion?></td>
                            <td><?php print $fetch_question['question']?></td>
                            <?php
                        }
                        elseif($fetch_question['type'] == 'TOPIC'){
                            $numQuestion=0;
                        }


                        $sql_question_score="SELECT * FROM survey_score WHERE survey_course_id = '".$fetch_survey_course['id']."' and survey_question_id = '".$fetch_question['id']."'";
                        $query_question_score=mysqli_query($conn,$sql_question_score);
                        while($fetch_question_score=mysqli_fetch_assoc($query_question_score)){
                            ?>
                            <td class="text-center" data-container="body" data-toggle="tooltip" title="<?php print $fetch_question_score['student_first_name']?> <?php print $fetch_question_score['student_last_name'] ?>"><?php print $fetch_question_score['score']?></td>

                            <?php
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



</body>
</html>
