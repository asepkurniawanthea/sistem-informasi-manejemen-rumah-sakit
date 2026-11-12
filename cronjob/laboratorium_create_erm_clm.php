<?php
include('C:/xampp/htdocs/nsimrs/config/config.php');
include('C:/xampp/htdocs/nsimrs/shared/connect_db.php');
include('C:/xampp/htdocs/nsimrs/shared/function.php');

include('C:/xampp/htdocs/nsimrs/lib/vendor/autoload.php');
include('C:/xampp/htdocs/nsimrs/lib/html2openxml/HTMLtoOpenXML.php');
include('C:/xampp/htdocs/nsimrs/edoc_rekammedik/new/erm_create_laboratorium_clm.php');

ini_set('max_execution_time', '300');

function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = htmlspecialchars($ret);
	return $ret;
}

$qry_lab = 'SELECT DISTINCT * FROM (
		SELECT t_ipenunjang.PENUNJANG_ID,
		t_ipenunjang.RAWAT_ID,
		t_ipenunjang.JNS_ORDER,
		t_ipenunjang.NO_ORDER,	
		t_ipenunjang_tarif.NO_TARIF,
		t_ipenunjang.NO_LABORATORIUM
		FROM t_ipenunjang
		INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
		INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
		INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
		WHERE t_ipenunjang.JNS_ORDER <> "APS"
		AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
		AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
		OR m_tarif.UNIT_ID = "45")
		AND t_ipenunjang.RESULT_FR_LIS = "1"
		AND t_ipenunjang.ST_CREATE_ERM_LR IS NULL
		UNION ALL
		SELECT t_ipenunjang.PENUNJANG_ID,
		t_ipenunjang.PENUNJANG_ID AS RAWAT_ID,
		t_ipenunjang.JNS_ORDER,
		t_ipenunjang.NO_ORDER,	
		t_ipenunjang_tarif.NO_TARIF,
		t_ipenunjang.NO_LABORATORIUM
		FROM t_ipenunjang
		INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
		INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
		INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
		WHERE t_ipenunjang.JNS_ORDER = "APS"
		AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
		AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1")
		AND t_ipenunjang.RESULT_FR_LIS = "1"
		AND t_ipenunjang.ST_CREATE_ERM_LR IS NULL
	) t_order';
	
$get_lab = mysql_query($qry_lab) or die(mysql_error());
while($dat_lab = mysql_fetch_array($get_lab)){
	$penunjang_id = $dat_lab['PENUNJANG_ID'];
	$rawat_id = $dat_lab['RAWAT_ID'];
	$jns_order = $dat_lab['JNS_ORDER'];
	$no_order = $dat_lab['NO_ORDER'];
	$no_tarif = $dat_lab['NO_TARIF'];
	$no_laboratorium = $dat_lab['NO_LABORATORIUM'];
	
	$idx = $rawat_id;
	if($jns_order == 'APS') {
		$idx = $penunjang_id;
	}	
	
	erm_laboratorium_clm($idx,strtolower($jns_order),$no_order);	
		
	mysql_query('UPDATE t_ipenunjang 
		JOIN t_ipenunjang_tarif 
		ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
		SET t_ipenunjang.ST_CREATE_ERM_LR = "1"
		WHERE t_ipenunjang.JNS_ORDER = "' . strtoupper($jns_order) . '"
		' . ((strtolower($ord) == 'aps') ? 'AND t_ipenunjang.PENUNJANG_ID = "' . $penunjang_id . '"' : 'AND t_ipenunjang.RAWAT_ID = "' . $rawat_id . '"') . '
		AND t_ipenunjang_tarif.NO_TARIF = "' . $no_tarif . '"') or die(mysql_error());		
}	
?>