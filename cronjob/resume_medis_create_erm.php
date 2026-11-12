<?php
include('C:/xampp/htdocs/nsimrs/config/config.php');
include('C:/xampp/htdocs/nsimrs/shared/connect_db.php');
include('C:/xampp/htdocs/nsimrs/shared/function.php');
include('C:/xampp/htdocs/nsimrs/shared/enum_function.php');

include('C:/xampp/htdocs/nsimrs/lib/vendor/autoload.php');
include('C:/xampp/htdocs/nsimrs/lib/html2openxml/HTMLtoOpenXML.php');
include('C:/xampp/htdocs/nsimrs/edoc_rekammedik/new/erm_create_resume_medis.php');

ini_set('max_execution_time', '300');

function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = htmlspecialchars($ret);
	return $ret;
}

$qry_ri = 'SELECT IRNA_ID,NOMR FROM t_irna
		WHERE NO_PENDAFTARAN IS NOT NULL
		AND ST_BATAL IS NULL	
		AND ST_CREATE_ERM_RM IS NULL';
$get_ri = mysql_query($qry_ri) or die(mysql_error());
while($dat_ri = mysql_fetch_array($get_ri)){
	$idx = $dat_ri['IRNA_ID'];
	$nomr = $dat_ri['NOMR'];

	erm_resume_medis($idx,'','','');
	
	mysql_query('UPDATE t_irna SET ST_CREATE_ERM_RM = "1"
			WHERE IRNA_ID = "' . $idx . '"') or die(mysql_error());
}	
?>