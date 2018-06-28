<?php

setlocale(LC_ALL,'C.UTF-8');
$course_id = $_REQUEST['course_id'];
$course_section = $_REQUEST['course_section'];


$files = glob("/var/www/ge/upload-file/".$course_id."-".$course_section."/*");



?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

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


<div class="container">
    <br />

    <form action="function-upload-file.php" method="post" enctype="multipart/form-data">
        <div class="panel panel-default">
            <div class="panel-heading">เอกสาร</div>
            <div class="panel-body">
                <table class="table">

                    <tbody>

                    <?php

                    $initialFile = 0;

                    foreach ($files as $filename) {

                        $initialFile = 1;

                        ?>
                        <tr>
                            <td><?php echo "".basename($filename)?></td>
                            <td class="text-right"><a href="function-download-file.php?course_id=<?php print $course_id?>&course_section=<?php print $course_section?>&filename=<?php print basename($filename)?>" class="btn btn-warning">ดาวน์โหลด</a></td>
                            <td class="text-right"><a href="function-delete-file.php?course_id=<?php print $course_id?>&course_section=<?php print $course_section?>&filename=<?php print basename($filename)?>" class="btn btn-danger">ลบ</a></td>
                        </tr>
                        <?php
                    }
                    if($initialFile == 0){
                        ?>

                        <li class="list-group-item h5" style="color: #9e9e9e">ไม่พบเอกสารประกอบการสอน</li>

                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</div>
</body>
</html>
