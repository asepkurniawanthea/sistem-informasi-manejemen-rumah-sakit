<?php
include('C:/xampp/htdocs/nsimrs/config/config.php');
include('C:/xampp/htdocs/nsimrs/shared/connect_db.php');
include('C:/xampp/htdocs/nsimrs/shared/function.php');

include('C:/xampp/htdocs/nsimrs/lib/vendor/autoload.php');
include('C:/xampp/htdocs/nsimrs/lib/html2openxml/HTMLtoOpenXML.php');
include('C:/xampp/htdocs/nsimrs/edoc_rekammedik/new/erm_create_transfer_pasien.php');

ini_set('max_execution_time', '300');

function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = htmlspecialchars($ret);
	return $ret;
}

$qry_ri = 'SELECT IRNA_TRANSFER_ID,INTERNAL_EKSTERNAL FROM t_irna_transfer_pasien
		WHERE ST_CREATE_ERM IS NULL';
$get_ri = mysql_query($qry_ri) or die(mysql_error());
while($dat_ri = mysql_fetch_array($get_ri)){
	$idx = $dat_ri['IRNA_TRANSFER_ID'];
	$in_eks = $dat_ri['INTERNAL_EKSTERNAL'];

	erm_transfer_pasien($idx,'2',$in_eks);
	
	mysql_query('UPDATE t_irna_transfer_pasien SET ST_CREATE_ERM = "1"
		WHERE IRNA_TRANSFER_ID = "' . $idx . '"
		AND INTERNAL_EKSTERNAL = "' . $in_eks . '"') or die(mysql_error());
}	
?>