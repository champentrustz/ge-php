<?php

$course_id = $_REQUEST['course_id'];
$course_section = $_REQUEST['course_section'];

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
    body {
        height: 200px;
        width: 100%;
    }
    html {
        height: 200px;
        width: 100%;
    }
</style>


<body>


<div class="container">
    <br />

    <form action="function-upload-file.php" method="post" enctype="multipart/form-data">
        <div class="panel panel-default">
            <div class="panel-heading">อัพโหลดไฟล์</div>
            <div class="panel-body">
                <input type="file" name="fileToUpload" id="fileToUpload">
                <input type="hidden" name="course_id" value="<?php print $course_id?>">
                <input type="hidden" name="course_section" value="<?php print $course_section?>">
                <br/>
                <button class="btn btn-success" type="submit" name="submit">อัพโหลด</button>
            </div>
        </div>
    </form>
</div>


</body>
</html>
