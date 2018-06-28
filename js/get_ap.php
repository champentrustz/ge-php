<?
header ("Content-Type:text/plain;Charset=windows-874");
set_time_limit(-1);
session_start ();
$path = "../";
include ($path.'include/config.php');
include ($path.'include/class_db.php'); 
include ($path.'include/class_display.php'); 
include ($path.'include/function.php'); 
$CLASS['db']   = new db();
$CLASS['db']->connect(); 
$CLASS['disp']   = new display();
$db   = $CLASS['db']; 
$disp   = $CLASS['disp']; 

print ' <select name="amphur" id="ap_id" onChange="get_tb(form1.province.value,this.value);"  class="textbox">';
print '<option value="">เลือกอำเภอ /เขต</option>';
print    $disp->ddw_list_selected("select tb_amphur_id ,tb_amphur_name  from tb_amphur  where  tb_province_id='$province'   order by    tb_amphur_name ","tb_amphur_name","tb_amphur_id",'') ;
print '</select>&nbsp;&nbsp;<span class="alertred">*</span>';
?>