<?php
include('C:/xampp/htdocs/nsimrs/config/config.php');
include('C:/xampp/htdocs/nsimrs/shared/connect_db.php');
include('C:/xampp/htdocs/nsimrs/shared/function.php');

include('C:/xampp/htdocs/nsimrs/lib/vendor/autoload.php');
include('C:/xampp/htdocs/nsimrs/lib/html2openxml/HTMLtoOpenXML.php');
include('C:/xampp/htdocs/nsimrs/edoc_rekammedik/new/erm_create_pemantauan_hemodialisa_harian.php');

ini_set('max_execution_time', '300');

function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = htmlspecialchars($ret);
	return $ret;
}

$qry_ri = 'SELECT h.HEMODIALISA_ID,h.JNS_ORDER,h.RAWAT_ID
		FROM t_hemodialisa h
		INNER JOIN t_hemodialisa_pemantauan_hemodialisis a	
		ON (h.HEMODIALISA_ID = a.HEMODIALISA_ID) 
		WHERE a.ST_CREATE_ERM IS NULL';
$get_ri = mysql_query($qry_ri) or die(mysql_error());
while($dat_ri = mysql_fetch_array($get_ri)){
	$idx = $dat_ri['HEMODIALISA_ID'];
	$jns_order = $dat_ri['JNS_ORDER'];
	$idxord = $dat_ri['RAWAT_ID'];

	erm_pemantauan_hemodialisa_harian($idx,$jns_order,$idxord);
	
	mysql_query('UPDATE t_hemodialisa_pemantauan_hemodialisis SET ST_CREATE_ERM = "1"
		WHERE HEMODIALISA_ID = "' . $idx . '"') or die(mysql_error());
}

$qry_ri = 'SELECT h.IRJA_ID
		FROM t_irja_pemantauan_hemodialisis h
		WHERE h.ST_CREATE_ERM IS NULL';
$get_ri = mysql_query($qry_ri) or die(mysql_error());
while($dat_ri = mysql_fetch_array($get_ri)){
	$idx = $dat_ri['IRJA_ID'];
	$jns_order = '';
	$idxord = $dat_ri['IRJA_ID'];

	erm_pemantauan_hemodialisa_harian($idx,$jns_order,$idxord);
	
	mysql_query('UPDATE t_irja_pemantauan_hemodialisis SET ST_CREATE_ERM = "1"
		WHERE IRJA_ID = "' . $idx . '"') or die(mysql_error());
}	
?>