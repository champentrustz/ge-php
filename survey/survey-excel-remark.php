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

$nameExcel = 'remark'.$course_id.'-'.$group_id.'-'.$semester.'-'.$year.'.xls';
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
    <br />




            <div class="col-md-12">


                <table class="table table-bordered" cellspacing="0" style="font-size: 12px" id="data-table">
                    <thead>

                    <th class="text-center">ที่</th>
                    <th class="text-center">รหัสนักศึกษา</th>
                    <th class="text-center">ชื่อ - นามสกุล</th>
                    <th class="text-center">ข้อคิดเห็น/ข้อเสนอแนะ</th>
                    </thead>
                    <tbody>

                    <?php

                    $comment_sql="SELECT * FROM survey_remark WHERE survey_course_id = '".$fetch_survey_course['id']."'";
                    $query_comment=mysqli_query($conn,$comment_sql);
                    $num = 0;
                    while($fetch_comment=mysqli_fetch_assoc($query_comment)){

                        $num++;
                        ?>
                        <tr>
                            <td class="text-center"><?php print $num?></td>
                            <td class="text-center"><?php print $fetch_comment['student_id']?></td>
                            <td class="text-center"><?php print $fetch_comment['student_first_name']?> <?php print $fetch_comment['student_last_name']?></td>
                            <td class="text-center"><?php print $fetch_comment['remark']?></td>
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
