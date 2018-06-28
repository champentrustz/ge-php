<?php


$file_name = "/var/www/ge/download/ChromeStandaloneSetup64.exe";


header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.basename($file_name).'"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($file_name));
readfile($file_name);
exit;

?>