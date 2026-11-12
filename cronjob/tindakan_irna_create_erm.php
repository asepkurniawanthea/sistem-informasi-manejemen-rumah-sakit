<?php
include('C:/xampp/htdocs/nsimrs/config/config.php');
include('C:/xampp/htdocs/nsimrs/shared/connect_db.php');
include('C:/xampp/htdocs/nsimrs/shared/function.php');

include('C:/xampp/htdocs/nsimrs/lib/vendor/autoload.php');
include('C:/xampp/htdocs/nsimrs/lib/html2openxml/HTMLtoOpenXML.php');
include('C:/xampp/htdocs/nsimrs/edoc_rekammedik/new/erm_create_tindakan_rawat_inap.php');

ini_set('max_execution_time', '300');

function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = htmlspecialchars($ret);
	return $ret;
}

$qry_ri = 'SELECT IRNA_ID,IRNA_TARIF_ID  
		FROM t_irna_tarif
		WHERE ST_CREATE_ERM IS NULL';
$get_ri = mysql_query($qry_ri) or die(mysql_error());
while($dat_ri = mysql_fetch_array($get_ri)){
	$idx = $dat_ri['IRNA_ID'];
	$trf = $dat_ri['IRNA_TARIF_ID'];

	erm_tindakan_rawat_inap($idx,$trf);
	
	mysql_query('UPDATE t_irna_tarif SET ST_CREATE_ERM = "1"
		WHERE IRNA_ID = "' . $idx . '" 
		AND IRNA_TARIF_ID = "' . $trf . '"') or die(mysql_error());
}	
?>