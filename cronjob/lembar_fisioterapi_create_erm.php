<?php
include('C:/xampp/htdocs/nsimrs/config/config.php');
include('C:/xampp/htdocs/nsimrs/shared/connect_db.php');
include('C:/xampp/htdocs/nsimrs/shared/function.php');

include('C:/xampp/htdocs/nsimrs/lib/vendor/autoload.php');
include('C:/xampp/htdocs/nsimrs/lib/html2openxml/HTMLtoOpenXML.php');
include('C:/xampp/htdocs/nsimrs/edoc_rekammedik/new/erm_create_lembar_fisioterapi.php');

ini_set('max_execution_time', '300');

function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = htmlspecialchars($ret);
	return $ret;
}

$qry_ri = 'SELECT DISTINCT RAWAT_ID,PENUNJANG_ID,JNS_ORDER,NO_SJP 
		FROM t_pemeriksaan_fisioterapi
		WHERE ST_CREATE_ERM IS NULL';
$get_ri = mysql_query($qry_ri) or die(mysql_error());
while($dat_ri = mysql_fetch_array($get_ri)){
	$idx = $dat_ri['RAWAT_ID'];
	$pnj = $dat_ri['PENUNJANG_ID'];
	$ord = $dat_ri['JNS_ORDER'];
	$sjp = $dat_ri['NO_SJP'];

	erm_lembar_fisioterapi($idx,$pnj,$ord,$sjp);
	
	mysql_query('UPDATE t_pemeriksaan_fisioterapi SET ST_CREATE_ERM = "1"
			WHERE RAWAT_ID = "' . $idx . '"
			AND PENUNJANG_ID = "' . $pnj . '"
			AND JNS_ORDER = "' . $ord . '"
			AND NO_SJP = "' . $sjp . '"') or die(mysql_error());
}	
?>