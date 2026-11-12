<?php
include('C:/xampp/htdocs/nsimrs/config/config.php');
include('C:/xampp/htdocs/nsimrs/shared/connect_db.php');
include('C:/xampp/htdocs/nsimrs/shared/function.php');

include('C:/xampp/htdocs/nsimrs/lib/vendor/autoload.php');
include('C:/xampp/htdocs/nsimrs/lib/html2openxml/HTMLtoOpenXML.php');
include('C:/xampp/htdocs/nsimrs/edoc_rekammedik/new/erm_create_pengkajian_awal_kebidanan_d_kandungan.php');

ini_set('max_execution_time', '300');

function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = htmlspecialchars($ret);
	return $ret;
}

$qry_ri = 'SELECT IRJA_ID
		FROM t_irja_pengkajian_awal_kandungan
		WHERE ST_CREATE_ERM IS NULL';
$get_ri = mysql_query($qry_ri) or die(mysql_error());
while($dat_ri = mysql_fetch_array($get_ri)){
	$idx = $dat_ri['IRJA_ID'];

	erm_pengkajian_awal_kebidanan_d_kandungan($idx);
	
	mysql_query('UPDATE t_irja_pengkajian_awal_kandungan SET ST_CREATE_ERM = "1"
		WHERE IRJA_ID = "' . $idx . '"') or die(mysql_error());
}	
?>