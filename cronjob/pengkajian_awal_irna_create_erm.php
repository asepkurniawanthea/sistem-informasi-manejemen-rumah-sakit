<?php
include('C:/xampp/htdocs/nsimrs/config/config.php');
include('C:/xampp/htdocs/nsimrs/shared/connect_db.php');
include('C:/xampp/htdocs/nsimrs/shared/function.php');

ini_set('max_execution_time', '300');

function replace_newline($str){
	$ret = preg_replace('/\r|\n/','\n',trim($str));
	$ret = str_replace('\n','<br>',$ret);
	$ret = str_replace('<br><br>','<br>',$ret);
	return $ret;
}

function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = htmlspecialchars($ret);
	return $ret;
}

include('C:/xampp/htdocs/nsimrs/lib/vendor/autoload.php');
include('C:/xampp/htdocs/nsimrs/lib/html2openxml/HTMLtoOpenXML.php');
include('C:/xampp/htdocs/nsimrs/edoc_rekammedik/new/erm_create_pengkajian_awal_medis_kusta_ranap.php');
include('C:/xampp/htdocs/nsimrs/edoc_rekammedik/new/erm_create_pengkajian_awal_medis_mata_ranap.php');
include('C:/xampp/htdocs/nsimrs/edoc_rekammedik/new/erm_create_pengkajian_awal_medis_gigi_ranap.php');
include('C:/xampp/htdocs/nsimrs/edoc_rekammedik/new/erm_create_pengkajian_awal_medis_umum_ranap.php');

$qry_ri = 'SELECT IRNA_ID,NOMR,PAM FROM t_irna
		WHERE NO_PENDAFTARAN IS NOT NULL
		AND ST_BATAL IS NULL	
		AND ST_CREATE_ERM_PAM IS NULL';
$get_ri = mysql_query($qry_ri) or die(mysql_error());
while($dat_ri = mysql_fetch_array($get_ri)){
	$idx = $dat_ri['IRNA_ID'];
	$nomr = $dat_ri['NOMR'];
	$pam = $dat_ri['PAM'];

	if($pam == '38') erm_pengkajian_awal_medis_umum_ranap($idx,'','','');
	if($pam == '5') erm_pengkajian_awal_medis_gigi_ranap($idx,'','','');
	if($pam == '29') erm_pengkajian_awal_medis_mata_ranap($idx,'','','');
	if($pam == '35') erm_pengkajian_awal_medis_kusta_ranap($idx,'','','');
	
	mysql_query('UPDATE t_irna SET ST_CREATE_ERM_PAM = "1"
			WHERE IRNA_ID = "' . $idx . '"') or die(mysql_error());
}	
?>