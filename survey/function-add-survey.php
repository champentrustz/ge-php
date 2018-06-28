

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



$topic = $_REQUEST['topic'];
$type = $_REQUEST['type'];
$semester = $_REQUEST['semester'];
$year = $_REQUEST['year'];
$teacherName = $_REQUEST['teacher_name'];
$amount = $_REQUEST['amount'];
$date = new DateTime();


$insert_survey = "INSERT INTO survey(id,topic, teacher_name, amount, type, semester, year, createdAt, updatedAt)VALUES (NULL,'" . $topic . "', '" . $teacherName . "', '" . $amount . "', '" . $type . "', '" . $semester . "', '" . $year . "', '" . $date->format('Y-m-d H:i:s') . "','" . $date->format('Y-m-d H:i:s') . "')";
$conn->query($insert_survey);
$latest_record = $conn->insert_id;

session_start();
$_SESSION['latest_record'] = $latest_record;
$_SESSION['semester'] = $semester;
$_SESSION['year'] = $year;


?>
<script>

    var popUp = window.open('survey-question.php','survey-question','width=1200,height=1000');
    var timer = setInterval(function() {
        if(popUp.closed) {
            clearInterval(timer);
            window.location.href = 'survey.php';
        }
    }, 500);
    if (popUp == null || typeof(popUp)=='undefined') {
        fetch('delete_api.php?survey_id='+'<?php print $latest_record?>');
        alert('กรุณาปิดการบล็อคของ Popup และลองใหม่อีกครั้ง');
    }
    else {
        popUp.focus();

    }
</script>


