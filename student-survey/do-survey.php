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

$survey_course_id = $_SESSION['survey_course_id'];
$student_id = $_SESSION['student_id'];
$student_gender = $_SESSION['student_gender'];
$course_id = $_SESSION['course_id'];
$group_id = $_SESSION['group_id'];
$semester = $_SESSION['semester'];
$year = $_SESSION['year'];

$survey_course_sql="SELECT * FROM survey_course WHERE id = '".$survey_course_id."' and deletedAt IS NULL LIMIT 1";
$query_survey_course=mysqli_query($conn,$survey_course_sql);
$fetch_survey_course = mysqli_fetch_assoc($query_survey_course);


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

    hr {
        background-color: #fff;
        border-top: 2px dotted #8c8b8b;
    }


</style>



<body>




<div class="container">
    <br />

    <div class="col-md-8 col-md-offset-2">

    <div class="text-center">
        <img src="http://58.181.171.138/php/img/ssru-logo.png" style="height: 80px;width: 100px">
    </div>
    <p></p>
    <p class="text-center">
        แบบประมินความพึงพอใจผู้สอน
    </p>
        <p class="text-center">
            วิชา <?php print $course_id?> <?php print $fetch_survey_course['name']?> กลุ่มที่ <?php print $fetch_survey_course['group_name']?>
        </p>
    <p class="text-center">
        มหาวิทยาลัยราชภัฎสวนสุนันทา
    </p>
    <p class="text-center">
       วันที่  <?php print $day?>  เดือน  <?php print $ThMonth[$months]?>  พ.ศ.  <?php print $years?>
    </p>
    <p class="text-center">
        <hr style="width: 80%">
    </p>
<!--    <p >-->
<!--    <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;คำอธิบาย</strong> : สำนักวิชาการศึกษาทั่วไปฯ ได้จัดทำแบบประเมินโครงการ เพื่อประเมินผลการดำเนินงานโครงการและนำข้อมูลที่ได้ไปใช้ในการปรับปรุงการดำเนินงานในครั้งต่อไป ในแบบประเมินโครงการมีทั้งหมด 3 ขั้นตอน ดังนี้-->
<!--    </p>-->
<!--     <p>-->
<!--         <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ตอนที่ 1</strong> สถานภาพทั่วไปของผู้เข้าร่วมโครงการ-->
<!--     </p>-->
<!--        <p>-->
<!--            <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ตอนที่ 2</strong> ประเมินระดับความพึงพอใจ-->
<!--        </p>-->
<!--        <p>-->
<!--            <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ตอนที่ 3</strong> ข้อเสนอแนะและความคิดเห็นเพิ่มเติมของผู้เข้าร่วมโครงการ-->
<!--        </p>-->
<!--        <p>-->
<!--            <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ตอนที่ 1</strong> สถานภาพทั่วไป-->
<!--        </p>-->
<!--        <p>-->
<!--            <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1. เพศ :</strong> --><?php //if($student_gender == 0){echo "หญิง";} else {echo "ชาย";}?>
<!--        </p>-->
<!--        <p>-->
<!--            <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. สถานะ : </strong> นักศึกษา-->
<!--        </p>-->
<!--        <p>-->
<!--            <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ตอนที่ 2</strong> ประเมินระดับความพึงพอใจ-->
<!--        </p>-->


        <form data-toggle="validator" action="function-save-do-survey.php" method="post" >

        <table class="table table-bordered" cellspacing="0" style="font-size: 12px">
            <thead>
            <tr>
                <th class="text-center"  rowspan="2">ประเด็นความคิดเห็น</th>
                <th class="text-center" colspan="5">ระดับความพึงพอใจ</th>

            </tr>
            <tr>
                <td class="text-center"><strong>มากที่สุด (5)</strong></td>
                <td class="text-center"><strong>มาก (4)</strong></td>
                <td class="text-center"><strong>ปานกลาง (3)</strong></td>
                <td class="text-center"><strong>น้อย (2)</strong></td>
                <td class="text-center"><strong>น้อยที่สุด (1)</strong></td>
            </tr>
            </thead>
            <tbody>

            <?php

            $survey_question_sql="SELECT * FROM survey_question WHERE survey_id = '".$fetch_survey_course['survey_id']."' ";
            $query_survey_question=mysqli_query($conn,$survey_question_sql);
            $i = 0;
            while($fetch_survey_question=mysqli_fetch_assoc($query_survey_question)){
                ?>
            <tr>
            <?php
                if($fetch_survey_question['type'] == "TOPIC"){
                    ?>

                    <td colspan="6"><strong><?php print $fetch_survey_question['question']?></strong></td>
            <?php
                }
                else{

                    if($fetch_survey_question['question'] != ''){
                        ?>
                        <input class="text-center" type="hidden" name="question_id[]" value="<?php print $fetch_survey_question['id']?>">
                        <td><?php print $fetch_survey_question['question']?></td>
                        <td class="text-center"><input  type="radio" name="score<?php print $i?>" value="5" required></td>
                        <td class="text-center"><input  type="radio" name="score<?php print $i?>" value="4" required></td>
                        <td class="text-center"><input  type="radio" name="score<?php print $i?>" value="3" required></td>
                        <td class="text-center"><input  type="radio" name="score<?php print $i?>" value="2" required></td>
                        <td class="text-center"><input  type="radio" name="score<?php print $i?>" value="1" required></td>

                        <?php

                        $i++;

                    }
                }
                ?>
            </tr>

                <?php
            }
            ?>


            </tbody>




        </table>

            <strong>ข้อเสนอแนะ</strong>
            <input class="form-control" type="text" name="remark" style="font-size: 12px">
            <input class="form-control" type="hidden" name="gender" value="<?php print $student_gender?>">
            <input class="form-control" type="hidden" name="student_id" value="<?php print $student_id?>">
            <input class="form-control" type="hidden" name="numrow" value="<?php print $i?>">
            <br>

        <button class="btn btn-success btn-block" type="submit">บันทึก</button>

            <br>

        </form>

    </div>





</div>
</body>
</html>
