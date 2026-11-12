<?php
if(isset($_GET['idx']) and isset($_GET['ord']) and isset($_GET['nomor']) 
		and isset($_GET['form']) and isset($_GET['nomr'])){
	$idx = $_GET['idx'];
	$ord = $_GET['ord'];
	$nomor = $_GET['nomor'];
	$form = $_GET['form'];
	$nomr = $_GET['nomr'];
	
	if($ord == 'aps') $jns_perawatan = '1';
	if($ord == 'irj') $jns_perawatan = '1';
	if($ord == 'irn') $jns_perawatan = '2';
	if($ord == 'hrj') $jns_perawatan = '1';
	if($ord == 'hri') $jns_perawatan = '2';
	if($ord == 'ori') $jns_perawatan = '2';
	if($ord == 'orj') $jns_perawatan = '1';
	
	$filepath = $rmfile_path . '/pdf/' . $jns_perawatan . '/' . $nomr . '/' . $idx . '/';
	$filename = $nomr . '_' . strtoupper($ord) . $idx . '_5_' . $nomor . '_' . $form . '.pdf';
	
	if(file_exists($filepath . $filename)){
		header("Content-Length: " . filesize ($filepath . $filename)); 
		header("Content-type: application/pdf"); 
		header("Content-disposition: inline; filename=$filename");
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		readfile($filepath . $filename);
	}else{
		echo 'File Tidak Ditemukan. Silahkan Simpan Dahulu.';
	}
}	
?>