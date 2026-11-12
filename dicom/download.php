<?php
$param_filename = $_GET['dicomdownload'];
$arr_filename = explode('-',$param_filename);
$nomr = $arr_filename[0];
$filename = substr($param_filename,7,strlen($param_filename) - 6); 
header('Content-type: text/csv');
header('Content-type: application/octet-stream');
header('Content-type: application/x-msdownload'); 
header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-type: application/x-msdownload'); 
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Pragma: no-cache');
header('Expires: 0'); 
readfile($dicom_path . '/' . $nomr . '/' . $filename);
?>