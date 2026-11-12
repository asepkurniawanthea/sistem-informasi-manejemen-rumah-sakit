<?php
include('C:/xampp/htdocs/nsimrs/config/config.php');
include('C:/xampp/htdocs/nsimrs/shared/connect_db.php');
include('C:/xampp/htdocs/nsimrs/shared/function.php');

include('C:/xampp/htdocs/nsimrs/lib/vendor/autoload.php');
include('C:/xampp/htdocs/nsimrs/lib/html2openxml/HTMLtoOpenXML.php');
include('C:/xampp/htdocs/nsimrs/edoc_rekammedik/new/erm_create_perkembangan_pasien_terintegrasi_ranap.php');

ini_set('max_execution_time', '300');

function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = htmlspecialchars($ret);
	return $ret;
}

$qry_rj = 'SELECT IRNA_ID,NOMR FROM t_irna
		WHERE NO_PENDAFTARAN IS NOT NULL
		AND ST_BATAL IS NULL	
		AND ST_CREATE_ERM_CPPT IS NULL';
$get_rj = mysql_query($qry_rj) or die(mysql_error());
while($dat_rj = mysql_fetch_array($get_rj)){
	$idx = $dat_rj['IRNA_ID'];
	$nomr = $dat_rj['NOMR'];

	erm_perkembangan_pasien_terintegrasi_ranap($idx);	
	
	mysql_query('UPDATE t_irna SET ST_CREATE_ERM_CPPT = "1"
			WHERE IRNA_ID = "' . $idx . '"') or die(mysql_error());
}	
?>