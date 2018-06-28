<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "ssrulm";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$exercise_id = $_REQUEST['exercise_id'];
$student_id = $_REQUEST['student_id'];

$exercise_sql="SELECT * FROM exercise WHERE id = '".$exercise_id."'";
$query_exercise=mysqli_query($conn,$exercise_sql);
$fetch_exercise=mysqli_fetch_assoc($query_exercise);

?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link href="../css/bootstrap.css"rel="stylesheet">
    <script  type="text/javascript" src="../js/jquery.js"></script>
    <script  type="text/javascript" src="../js/bootstrap.js"></script>

    <link rel="shortcut icon" href="../favicon/favicon.ico" />




    <?php

    function ThDate()
    {
//วันภาษาไทย
        $ThDay = array ( "อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์" );
//เดือนภาษาไทย
        $ThMonth = array ( "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน","พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม","กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม" );

//กำหนดคุณสมบัติ
        $week = date( "w" ); // ค่าวันในสัปดาห์ (0-6)
        $months = date( "m" )-1; // ค่าเดือน (1-12)
        $day = date( "d" ); // ค่าวันที่(1-31)
        $years = date( "Y" )+543; // ค่า ค.ศ.บวก 543 ทำให้เป็น ค.ศ.

        return "วัน$ThDay[$week]
		ที่ $day
		เดือน $ThMonth[$months]
		พ.ศ. $years";
    }

    ?>

    <script language="JavaScript">


                function test() {
                    window.close();
                }

    </script>

</head>

<body>


<div class="container">
    <br />

        <button class="btn btn-success btn-block" type="submit" onclick="test()">ส่งคำตอบ</button>

</div>
</body>
</html>
