<?php
$user_name ='';
include('config/config.php');
include('shared/connect_db.php');
include('shared/function.php');
include('edoc_rekammedik/edoc_main.php');

$sql_trans = 'SELECT t_hemodialisa.HEMODIALISA_ID 
			FROM t_hemodialisa
			WHERE t_hemodialisa.ST_BATAL IS NULL 
			AND STR_TO_DATE(DATE_FORMAT(t_hemodialisa.PASIEN_MASUK,"%Y-%m-%d"),"%Y-%m-%d") >= STR_TO_DATE(DATE_FORMAT(DATE_ADD(NOW(),INTERVAL - 7 DAY),"%Y-%m-%d"),"%Y-%m-%d")
			AND STR_TO_DATE(DATE_FORMAT(t_hemodialisa.PASIEN_MASUK,"%Y-%m-%d"),"%Y-%m-%d") <= STR_TO_DATE(DATE_FORMAT(NOW(),"%Y-%m-%d"),"%Y-%m-%d")';
$get_trans = mysql_query($sql_trans) or die(mysql_error());
$x = mysql_num_rows($get_trans);
while($dat_trans = mysql_fetch_array($get_trans)){
	$hemodialisa_id = $dat_trans['HEMODIALISA_ID'];
	
	create_pdf_hemodialisa($hemodialisa_id);
		
}

?>