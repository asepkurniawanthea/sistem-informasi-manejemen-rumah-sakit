<?php
include('C:/xampp/htdocs/nsimrs/config/config.php');
include('C:/xampp/htdocs/nsimrs/shared/connect_db.php');
include('C:/xampp/htdocs/nsimrs/shared/function.php');

include('C:/xampp/htdocs/nsimrs/lib/vendor/autoload.php');
include('C:/xampp/htdocs/nsimrs/lib/html2openxml/HTMLtoOpenXML.php');
include('C:/xampp/htdocs/nsimrs/edoc_rekammedik/new/erm_create_tindakan_hemodialisa.php');

ini_set('max_execution_time', '300');

function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = htmlspecialchars($ret);
	return $ret;
}

$qry_ri = 'SELECT h.HEMODIALISA_ID,h.JNS_ORDER,h.RAWAT_ID,a.HEMODIALISA_TARIF_ID
		FROM t_hemodialisa h
		INNER JOIN t_hemodialisa_tarif a	
		ON (h.HEMODIALISA_ID = a.HEMODIALISA_ID) 
		WHERE a.ST_CREATE_ERM IS NULL';
$get_ri = mysql_query($qry_ri) or die(mysql_error());
while($dat_ri = mysql_fetch_array($get_ri)){
	$idx = $dat_ri['HEMODIALISA_ID'];
	$jns_order = $dat_ri['JNS_ORDER'];
	$idxord = $dat_ri['RAWAT_ID'];
	$trf = $dat_ri['HEMODIALISA_TARIF_ID'];

	erm_tindakan_hemodialisa($idx,$trf,$jns_order,$idxord);
	
	mysql_query('UPDATE t_hemodialisa_tarif SET ST_CREATE_ERM = "1"
		WHERE HEMODIALISA_TARIF_ID = "' . $trf . '"') or die(mysql_error());
}	
?>