<?php
$user_name ='';
include('config/config.php');
include('shared/connect_db.php');
include('shared/function.php');
include('shared/enum_function.php');
include('edoc_rekammedik/edoc_main.php');

$sql_trans = 'SELECT t_operasi.OPERASI_ID 
			FROM t_operasi
			WHERE t_operasi.NO_PENDAFTARAN IS NOT NULL AND t_operasi.ST_APPROVE = "1" 
			AND t_operasi.TANGGAL_OPERASI >= STR_TO_DATE(DATE_FORMAT(DATE_ADD(NOW(),INTERVAL - 7 DAY),"%Y-%m-%d"),"%Y-%m-%d")
			AND t_operasi.TANGGAL_OPERASI <= STR_TO_DATE(DATE_FORMAT(NOW(),"%Y-%m-%d"),"%Y-%m-%d")';
$get_trans = mysql_query($sql_trans) or die(mysql_error());
$x = mysql_num_rows($get_trans);
while($dat_trans = mysql_fetch_array($get_trans)){
	$operasi_id = $dat_trans['OPERASI_ID'];
	
	create_pdf_operasi($operasi_id);
		
}

?>