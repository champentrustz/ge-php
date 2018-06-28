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
        $('#table-course').DataTable({
            "pageLength": 100,

        });

    } );


</script>









<div class="container">
    <br />



    <div class="col-md-12">

        <br/>



        <table class="table table-bordered" cellspacing="0" id="table-course" range="50">
            <thead>
            <tr>
                <th class="text-center">ที่</th>
                <th class="text-center">รหัสวิชา</th>
                <th class="text-center">ชื่อวิชา</th>
                <th class="text-center">กลุ่ม</th>
                <th class="text-center"><span class="glyphicon glyphicon-cog"></span></th>



            </tr>
            </thead>
            <tbody>

            <?php
            $course_sql="SELECT * FROM Course WHERE deleteAt is NULL order by code asc, section asc";
            $query_course=mysqli_query($conn,$course_sql);
            $i = 0;
            while($fetch_course=mysqli_fetch_assoc($query_course)){

            $i++

            ?>

            <tr class="text-center">
                <td><?php print $i?></td>
                <td><?php print $fetch_course['code']?></td>
                <td><?php print $fetch_course['name']?></td>
                <td><?php print $fetch_course['group_name']?></td>
                <td class="text-center">
                    <button onclick=" window.open('attend-report.php?course_id=<?php print $fetch_course['code']?>&group_id=<?php print $fetch_course['section']?>','attend-report ','width=1200,height=1000');" class="btn btn-success btn-xs">สรุปผล</button>
                </td>
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
