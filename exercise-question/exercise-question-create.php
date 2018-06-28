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

$exercise_id = $_SESSION['exercise_id'];

$exercise_sql="SELECT * FROM exercise WHERE id = '".$exercise_id."'";
$query_exercise=mysqli_query($conn,$exercise_sql);
$fetch_exercise=mysqli_fetch_assoc($query_exercise);

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

<script language="JavaScript">

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
</script>


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

    <div class="col-md-12">
        <h3><?=$fetch_exercise['name'];?></h3>
    </div>

	<form data-toggle="validator" action="function-save-exercise.php" method="post" name="form_save">

	<?php

$exercise_sql="SELECT * FROM exercise WHERE id = '".$exercise_id."'";
$query_exercise=mysqli_query($conn,$exercise_sql);
$fetch_exercise=mysqli_fetch_assoc($query_exercise);


	for($i=1;$i<=$fetch_exercise['amount'];$i++){
		?>

		<div class="col-md-6">
		<div class="panel panel-default">
  <div class="panel-heading">คำถามข้อที่ <?php print $i?></div>
  <div class="panel-body">

      <div class="form-horizontal">
          <div class="form-group">
              <label class="control-label col-md-2" for="question">คำถาม</label>
              <div class="col-md-10">
				<input type="text" class="form-control" name="question[]" id="question" required>
              </div>

          </div>
		</div>


      <div class="form-horizontal">
          <div class="form-group">
              <label  class="control-label col-md-2" for="score">คะแนน</label>
              <div class="col-md-4">
              <input type="number" min=1 class="form-control" name="score[]" id="score" value="1" step="0.1" required>
              </div>
          </div>
      </div>


		<div class="form-horizontal">
            <div class="form-group">
                <label for="choiceA" class="control-label col-md-2">ก.</label>
                <div class="col-md-10">
				<input type="text" class="form-control" name="choiceA[]" id="choiceA" required>
                </div>

            </div>
		</div>

      <div class="form-horizontal">
          <div class="form-group">
              <label for="choiceB" class="control-label col-md-2">ข.</label>
              <div class="col-md-10">
                  <input type="text" class="form-control" name="choiceB[]" id="choiceB" required>
              </div>
          </div>
      </div>

      <div class="form-horizontal">
          <div class="form-group">
              <label for="choiceC" class="control-label col-md-2">ค.</label>
              <div class="col-md-10">
              <input type="text" class="form-control" name="choiceC[]" id="choiceC"  required>
              </div>
          </div>
      </div>

      <div class="form-horizontal">
          <div class="form-group">
              <label for="choiceD" class="control-label col-md-2">ง.</label>
              <div class="col-md-10">
                  <input type="text" class="form-control" name="choiceD[]" id="choiceD" required>
              </div>
          </div>
      </div>



      <div class="form-horizontal">
          <div class="form-group">
			<div class="col-md-4 col-md-offset-8">
				<select name="answer[]" class="form-control" required>
					<option value = "">*คำตอบ</option>
					<option value="1" >ก.</option>
					<option value="2" >ข.</option>
					<option value="3" >ค.</option>
					<option value="4" >ง.</option>
			 </select>
			</div>
          </div>
		</div>



  </div>
</div>
</div>

		<?php


	}?>
	<input type="hidden" name="numrow" value="<?php print $i-1?>">
	<input type="hidden" name="exercise_id" value="<?php print $exercise_id?>">
	<div class="col-md-12">
		<button class="btn btn-success btn-block" type="submit">บันทึก</button>
        <br/>
        <br/>
        <br/>
	</div>


</form>


</div>
</body>
</html>
