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


$course_id = $_REQUEST['course_id'];
$course_section = $_REQUEST['course_section'];
$course_start = $_REQUEST['course_start'];
$course_end = $_REQUEST['course_end'];
$course_date = $_REQUEST['course_date'];
$teacher_id = $_REQUEST['teacher_id'];






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

<script>

    $(document).ready(function() {
        $('#table-check').DataTable();
    } );


</script>

<body>







<div class="container">
    <br />




    <div class="col-md-12">

        <br/>



           <table class="table table-bordered" cellspacing="0" id="table-check">
               <thead>
               <tr>
                   <th class="text-center">ลำดับ</th>
                   <th class="text-center">รหัสนักศึกษา</th>
                   <th class="text-center">ชื่อ-สกุล</th>
                   <th class="text-center">สถานะ</th>
                   <th class="text-center">หมายเหตุ</th>
                   <th class="text-center"><span class="glyphicon glyphicon-cog"></span></th>


               </tr>
               </thead>
               <tbody>

               <?php
               $check_sql="SELECT * FROM course_checkstudent WHERE courseID = '".$course_id."' and section = '".$course_section."' and checkinDate LIKE  '%{$course_date}%'";
                $query_check=mysqli_query($conn,$check_sql);
                 $i = 0;
                while($fetch_check=mysqli_fetch_assoc($query_check)){

                    $checkStart = substr($fetch_check['checkinDate'],'10','6');



                    if(strtotime($checkStart) >= strtotime($course_start) && strtotime($checkStart) <= strtotime($course_end)){

                        $i++;

                        ?>

                        <tr>
                            <form action="function-edit-check.php" method="post" >
                             <input type="hidden" name="check_id" class="form-control" value="<?php print $fetch_check['ID']?>">
                            <td class="text-center"><?php print $i?></td>
                            <td class="text-center"><?php print $fetch_check['studentID']?></td>
                            <td class="text-center"><?php print $fetch_check['firstName']?> <?php print $fetch_check['lastName']?></td>
                            <td class="text-center">
                                <select name="status" class="btn">
                                    <option  value="NORMAL" <?php if($fetch_check['status'] == "NORMAL")echo "selected";?>>มาตรงเวลา</option>
                                    <option  value="LATE" <?php if($fetch_check['status'] == "LATE")echo "selected";?>>มาสาย</option>
                                    <option  value="ABSENT" <?php if($fetch_check['status'] == "ABSENT")echo "selected";?>>ขาดเรียน</option>
                                </select>
                            </td>
                            <td class="text-center">
                                <input type="hidden" name="teacher_id" class="form-control" value="<?php print $teacher_id?>">
                                <input type="text" name="remark" class="form-control" value="<?php print $fetch_check['note']?>">
                            </td>
                            <td class="text-center">
                                <button type="submit" class="btn btn-warning btn-xs">แก้ไข</button>
                            </td>
                            </form>

                        </tr>

                        <?php

                    }


                ?>



               <?php


            }
 ?>



               </tbody>

           </table>


    </div>

    </div>


</div>
</body>
</html>
