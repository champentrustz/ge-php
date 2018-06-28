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

$survey_id = $_SESSION['latest_record'];
$survey_sql="SELECT * FROM survey WHERE id = '".$survey_id."'";
$query_survey=mysqli_query($conn,$survey_sql);
$fetch_survey=mysqli_fetch_assoc($query_survey);




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
</style>

<script>




</script>


<body>





<div class="container">
    <br />

    <div class="col-md-12">
        <h3><?=$fetch_survey['topic'];?></h3>
    </div>

    <form data-toggle="validator" action="function-save-survey-question.php" method="post" >


                    <div class="col-md-12">




                        <table class="table table-bordered" cellspacing="0" >
                            <thead>
                            <tr>


                                <th class="text-center">ประเภท</th>
                                <th class="text-center">หัวข้อ / ประเด็นคำถาม</th>


                            </tr>
                            </thead>
                            <tbody>

        <?php


        for($i=1;$i<=$fetch_survey['amount'];$i++){
            ?>

        <tr id="select-type<?php print $i?>">




            <td class="text-center">
                <select name="type[]" class="form-control" id="type-question<?php print $i?>">
                    <option value="QUESTION" selected>คำถาม</option>
                    <option value="TOPIC">หัวข้อ</option>
                </select>
            </td>
            <td class="text-center">
                <input type="text" class="form-control" name="question[]" >
            </td>


        </tr>


            <?php


        }?>
                            </tbody>
                        </table>
                    </div>

        <input type="hidden" name="numrow" value="<?php print $fetch_survey['amount']?>">
        <input type="hidden" name="survey_id" value="<?php print $survey_id?>">
        <div class="col-md-12">
            <button class="btn btn-success btn-block" type="submit">บันทึกแบบประเมิน</button>
            <br/>
            <br/>
            <br/>
            <br/>
        </div>


    </form>


</div>

<script>
    const length = '<?php print $i?>';
    let type = null;
    setInterval(function(){
        for(let i = 0 ; i< length ; i++){
            type = $( "#type-question"+i ).val();
            if(type == 'TOPIC'){
                $( "#select-type"+i ).addClass( "bg-info" );
            }
            else{
                $( "#select-type"+i ).removeClass( "bg-info" );
            }


        }



    }, 200);



</script>

</body>
</html>
