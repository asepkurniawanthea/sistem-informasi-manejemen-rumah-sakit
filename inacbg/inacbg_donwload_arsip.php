<?php
if(isset($_GET['sep']) and isset($_GET['id']) and isset($_GET['rawat'])){
$sep = $_GET['sep'];
$id = $_GET['id'];
$rawat = $_GET['rawat'];

header('Content-type: text/csv');
header('Content-type: application/octet-stream');
header('Content-type: application/x-msdownload'); 
header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-type: application/x-msdownload'); 
header('Content-Disposition: attachment; filename="' . $sep . '.zip"');
header('Pragma: no-cache');
header('Expires: 0'); 
readfile($eklaim_arsip_path . '/' . $sep . '.zip');
}
?>