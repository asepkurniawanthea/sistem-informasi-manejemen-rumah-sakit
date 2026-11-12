<?php
include('C:/xampp/htdocs/nsimrs/config/config.php');
include('C:/xampp/htdocs/nsimrs/shared/connect_db.php');
include('C:/xampp/htdocs/nsimrs/shared/function.php');

include('C:/xampp/htdocs/nsimrs/lib/vendor/autoload.php');
include('C:/xampp/htdocs/nsimrs/lib/html2openxml/HTMLtoOpenXML.php');
include('C:/xampp/htdocs/nsimrs/edoc_rekammedik/new/erm_create_asuhan_gizi.php');

ini_set('max_execution_time', '300');

function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = htmlspecialchars($ret);
	return $ret;
}

$qry_ri = 'SELECT IRNA_ID,IRNA_ASUHAN_ID FROM t_irna_asuhan_gizi
		WHERE ST_CREATE_ERM IS NULL';
$get_ri = mysql_query($qry_ri) or die(mysql_error());
while($dat_ri = mysql_fetch_array($get_ri)){
	$idx = $dat_ri['IRNA_ID'];
	$asuhan_id = $dat_ri['IRNA_ASUHAN_ID'];

	erm_asuhan_gizi($idx,$asuhan_id,'','','');
	
	mysql_query('UPDATE t_irna_asuhan_gizi SET ST_CREATE_ERM = "1"
			WHERE IRNA_ASUHAN_ID = "' . $asuhan_id . '"') or die(mysql_error());
}	
?>