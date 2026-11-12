<?php 
$uname = $_GET['uname'];
$sname = $fs_path . '/' . $_GET['sname'];
header('Content-type: text/csv');
header('Content-type: application/octet-stream');
header('Content-type: application/x-msdownload'); 
header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-type: application/x-msdownload'); 
header('Content-Disposition: attachment; filename="' . $uname . '"');
header('Pragma: no-cache');
header('Expires: 0'); 
readfile($sname);
?>