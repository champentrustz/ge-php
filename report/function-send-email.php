<?php
/**
 * This example shows making an SMTP connection with authentication.
 */

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set("Asia/Bangkok");

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-alloworigin,
access-control-allow-methods, access-control-allow-headers');

require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$date_day = date("Y-m-d");

function display_date($date,$type){//shortthai, longthai, shorteng, longeng
    if($date!='0000-00-00' && $date){
        $arr = explode("-",$date);
        if($arr[2]<10){
            $arr[2] = substr($arr[2],1,1);
        }
        $datevalue = $arr[2]." ".convert_month($arr[1],$type)." ".cut_zero($arr[0]+543);
    }else{
        $datevalue = "";
    }
    return $datevalue;
}

function convert_month($month,$language){
    if($language=='longthai'){
        if($month=='01' || $month=='1'){
            $month = "มกราคม";
        }elseif($month=='02' || $month=='2'){
            $month = "กุมภาพันธ์";
        }elseif($month=='03' || $month=='3'){
            $month = "มีนาคม";
        }elseif($month=='04' || $month=='4'){
            $month = "เมษายน";
        }elseif($month=='05' || $month=='5'){
            $month = "พฤษภาคม";
        }elseif($month=='06' || $month=='6'){
            $month = "มิถุนายน";
        }elseif($month=='07' || $month=='7'){
            $month = "กรกฎาคม";
        }elseif($month=='08' || $month=='8'){
            $month = "สิงหาคม";
        }elseif($month=='09' || $month=='9'){
            $month = "กันยายน";
        }elseif($month=='10'){
            $month = "ตุลาคม";
        }elseif($month=='11'){
            $month = "พฤศจิกายน";
        }elseif($month=='12'){
            $month = "ธันวาคม";
        }
        return $month;
    }elseif($language=='shortthai'){
        if($month=='01' || $month=='1'){
            $month = "ม.ค.";
        }elseif($month=='02' || $month=='2'){
            $month = "ก.พ.";
        }elseif($month=='03' || $month=='3'){
            $month = "มี.ค.";
        }elseif($month=='04' || $month=='4'){
            $month = "เม.ย.";
        }elseif($month=='05' || $month=='5'){
            $month = "พ.ค.";
        }elseif($month=='06' || $month=='6'){
            $month = "มิ.ย.";
        }elseif($month=='07' || $month=='7'){
            $month = "ก.ค.";
        }elseif($month=='08' || $month=='8'){
            $month = "ส.ค.";
        }elseif($month=='09' || $month=='9'){
            $month = "ก.ย.";
        }elseif($month=='10'){
            $month = "ต.ค.";
        }elseif($month=='11'){
            $month = "พ.ย.";
        }elseif($month=='12'){
            $month = "ธ.ค.";
        }
        return $month;
    }elseif($language=='shorteng'){
        if($month=='01' || $month=='1'){
            $month = "Jan";
        }elseif($month=='02' || $month=='2'){
            $month = "Feb";
        }elseif($month=='03' || $month=='3'){
            $month = "Mar";
        }elseif($month=='04' || $month=='4'){
            $month = "Apr";
        }elseif($month=='05' || $month=='5'){
            $month = "May";
        }elseif($month=='06' || $month=='6'){
            $month = "Jun";
        }elseif($month=='07' || $month=='7'){
            $month = "Jul";
        }elseif($month=='08' || $month=='8'){
            $month = "Aug";
        }elseif($month=='09' || $month=='9'){
            $month = "Sep";
        }elseif($month=='10'){
            $month = "Oct";
        }elseif($month=='11'){
            $month = "Nov";
        }elseif($month=='12'){
            $month = "Dec";
        }
        return $month;
    }elseif($language=='longeng'){
        if($month=='01'  || $month=='1'){
            $month = "January";
        }elseif($month=='02' || $month=='2'){
            $month = "February";
        }elseif($month=='03' || $month=='3'){
            $month = "March";
        }elseif($month=='04' || $month=='4'){
            $month = "April";
        }elseif($month=='05' || $month=='5'){
            $month = "May";
        }elseif($month=='06' || $month=='6'){
            $month = "June";
        }elseif($month=='07' || $month=='7'){
            $month = "July";
        }elseif($month=='08' || $month=='8'){
            $month = "August";
        }elseif($month=='09' || $month=='9'){
            $month = "September";
        }elseif($month=='10'){
            $month = "October";
        }elseif($month=='11'){
            $month = "November";
        }elseif($month=='12'){
            $month = "December";
        }
        return $month;
    }
}

function cut_zero($val){
    $cut = substr($val,0,1);
    if($cut=='0'){
        $val = substr($val,1,1);
    }
    return $val;
}

$content = file_get_contents("php://input");

$jsonArray = json_decode($content,true);

$student_data = $jsonArray['student_data'];
$teacher_email = $jsonArray['teacher_email'];
$course_id = $jsonArray['course_id'];
$group_name = $jsonArray['group_name'];

$table_html = '';
$i =0;
$status = null;
foreach ($student_data as $data){
    $i++;
    if($data['status'] == 'NORMAL'){
        $status = 'มาเรียน';
    }
    elseif ($data['status'] == 'LATE'){
        $status = 'มาสาย';
    }
    elseif ($data['status'] == 'ABSENT'){
        $status = 'ขาดเรียน';
    }
    $table_html .= '<tr>
<td>'.$i.'</td>
<td>'.$data['studentID'].'</td>
<td>'.$data['firstName'].' '.$data['lastName'].'</td>
<td>'.$status.'</td>
</tr>';

}


    $mail = new PHPMailer();

        //Server settings
        $mail->SMTPDebug = 2;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'gesc@om4you.com';                 // SMTP username
        $mail->Password = 'Oo29765834';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to
        $mail->CharSet = 'UTF-8';

        //Recipients

        foreach($teacher_email as $teacher) {
            if($teacher['email'] != '') {
                $mail->setFrom('gesc@om4you.com', 'สำนักวิชาการศึกษาทั่วไปฯ');
                $mail->addAddress($teacher['email'], 'champ');     // Add a recipient
                //Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'รายงานการเข้าห้องเรียนของนักศึกษา วิชา : ' . $course_id . ' กลุ่มที่ : ' . $group_name . ' วันที่ ' . display_date($date_day, 'shortthai');
                $mail->Body = '<table>
<tr>
<th class="text-center">ที่</th>
<th class="text-center">รหัสนักศึกษา</th>
<th class="text-center">ชื่อ - นามสกุล</th>
<th class="text-center">สถานะ</th>
</tr>
<tbody>
' . $table_html . '
</tbody>
</table>';

                $mail->send();

                $mail->ClearAllRecipients();
                $mail->ClearAttachments();
            }
        }




