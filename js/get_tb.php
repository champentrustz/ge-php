<?
header ("Content-Type:text/plain;Charset=TIS-620");

set_time_limit(-1);
session_start ();
$path = "../";
include ($path.'include/config.php');
include ($path.'include/class_db.php'); 
include ($path.'include/class_display.php'); 
include ($path.'include/function.php'); 
$CLASS['db']   = new db();
$CLASS['db']->connect (); 
$CLASS['disp']   = new display();
$db   = $CLASS['db']; 
$disp   = $CLASS['disp']; 



print '<select name="tambon"  class="textbox">';
 print '<option value="">เลือกตำบล /แขวง</option>';
    $disp->ddw_list_selected("select tambon_id ,tambon_name  from tambon_tb  where  amphur_id= $ap_code and province_id =$pv_code    order by    tambon_name ","tambon_name","tambon_id",'') ;
 print '</select>&nbsp;&nbsp;<span class="alertred">*</span>';
?>