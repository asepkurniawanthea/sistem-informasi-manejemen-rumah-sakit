<?php
include('C:/xampp/htdocs/nsimrs/config/config.php');
include('C:/xampp/htdocs/nsimrs/shared/connect_db.php');
include('C:/xampp/htdocs/nsimrs/shared/function.php');

include('C:/xampp/htdocs/nsimrs/lib/vendor/autoload.php');
include('C:/xampp/htdocs/nsimrs/lib/html2openxml/HTMLtoOpenXML.php');
include('C:/xampp/htdocs/nsimrs/edoc_rekammedik/new/erm_create_operasi_persetujuan_dokter.php');

ini_set('max_execution_time', '300');

function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = htmlspecialchars($ret);
	return $ret;
}

erm_operasi_persetujuan_dokter(9999);

$qry_ri = 'SELECT PERSETUJUAN_DOKTER_ID
		FROM t_operasi_persetujuan_dokter
		WHERE ST_CREATE_ERM IS NULL';
$get_ri = mysql_query($qry_ri) or die(mysql_error());
while($dat_ri = mysql_fetch_array($get_ri)){
	$idx = $dat_ri['PERSETUJUAN_DOKTER_ID'];

	erm_operasi_persetujuan_dokter($idx);
	
	mysql_query('UPDATE t_operasi_persetujuan_dokter SET ST_CREATE_ERM = "1"
		WHERE PERSETUJUAN_DOKTER_ID = "' . $idx . '"') or die(mysql_error());
}	
?>