<?php
include('C:/xampp/htdocs/nsimrs/config/config.php');
include('C:/xampp/htdocs/nsimrs/shared/connect_db.php');
include('C:/xampp/htdocs/nsimrs/shared/function.php');

include('C:/xampp/htdocs/nsimrs/lib/vendor/autoload.php');
include('C:/xampp/htdocs/nsimrs/lib/html2openxml/HTMLtoOpenXML.php');
include('C:/xampp/htdocs/nsimrs/edoc_rekammedik/new/erm_create_laboratorium_from_lis.php');

function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = htmlspecialchars($ret);
	return $ret;
}

$qry_lab = 'SELECT * FROM (
		SELECT t_ipenunjang.PENUNJANG_ID,
		t_ipenunjang.RAWAT_ID,
		t_ipenunjang.JNS_ORDER,
		t_ipenunjang.NO_ORDER,	
		t_ipenunjang.RESULT_FR_LIS,
		t_ipenunjang_tarif.NO_TARIF,
		SUM(CASE WHEN t_ipenunjang_tarif.ST_DIAGNOSA IS NULL THEN 1 ELSE 0 END) AS ST_PERIKSA
		FROM t_ipenunjang
		INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
		INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
		INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
		WHERE t_ipenunjang.JNS_ORDER <> "APS"
		AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) >= STR_TO_DATE("01/09/2020","%d/%m/%Y")
		AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) <= STR_TO_DATE(DATE_FORMAT(NOW(),"%d/%m/%Y"),"%d/%m/%Y")
		AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
		AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
		OR m_tarif.UNIT_ID = "45")
		GROUP BY t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF
		UNION ALL
		SELECT t_ipenunjang.PENUNJANG_ID,
		t_ipenunjang.PENUNJANG_ID AS RAWAT_ID,
		t_ipenunjang.JNS_ORDER,
		t_ipenunjang.NO_ORDER,	
		t_ipenunjang.RESULT_FR_LIS,
		t_ipenunjang_tarif.NO_TARIF,
		SUM(CASE WHEN t_ipenunjang_tarif.ST_DIAGNOSA IS NULL THEN 1 ELSE 0 END) AS ST_PERIKSA
		FROM t_ipenunjang
		INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
		INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
		INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
		WHERE t_ipenunjang.JNS_ORDER = "APS"
		AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) >= STR_TO_DATE("01/09/2020","%d/%m/%Y")
		AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) <= STR_TO_DATE(DATE_FORMAT(NOW(),"%d/%m/%Y"),"%d/%m/%Y")
		AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
		AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1")
		GROUP BY t_ipenunjang.PENUNJANG_ID
	) t_order
	WHERE RESULT_FR_LIS IS NULL';
	
$get_lab = mysql_query($qry_lab) or die(mysql_error());
while($dat_lab = mysql_fetch_array($get_lab)){
	$penunjang_id = $dat_lab['PENUNJANG_ID'];
	$rawat_id = $dat_lab['RAWAT_ID'];
	$jns_order = $dat_lab['JNS_ORDER'];
	$no_order = $dat_lab['NO_ORDER'];
	$no_tarif = $dat_lab['NO_TARIF'];
	
	$visit_no = $rawat_id;
	$idx = $rawat_id;
	if($jns_order == 'APS') {
		$visit_no = 'P' . $penunjang_id;
		$idx = $penunjang_id;
	}	
	
	$qry_lis = 'SELECT b.ONO,a.TEST_CD,a.TEST_NM,a.TEST_GROUP,a.REF_RANGE,a.DATA_TYP, 
		(CASE WHEN a.DATA_TYP ="FT" THEN a.RESULT_FT else a.RESULT_VALUE END) AS RESULT_VALUE,
		(CASE WHEN a.FLAG="N" THEN "" ELSE a.FLAG END) AS FLAG,
		a.UNIT,a.TEST_COMMENT,
		a.VALIDATE_BY,a.VALIDATE_ON	
		FROM db_lis.resdt a, 
		db_lis.reshd b 
		WHERE b.ono = "' . $no_order . '"
		AND b.VISITNO = "' . $visit_no . '"	
		AND a.ono=b.ono 
		AND a.RESULT_VALUE<>"!" 
		AND a.RESULT_FT<>"!"  
		ORDER BY DISP_SEQ ASC';
	$get_lis = mysql_query($qry_lis) or die(mysql_error());
	if(mysql_num_rows($get_lis) > 0){
		echo $no_order . ' ';
		/*mysql_query('DELETE FROM t_laboratorium_lis_data
				WHERE RAWAT_ID = "' . $rawat_id . '"
				AND JNS_ORDER = "' . $jns_order . '"
				AND NO_ORDER = "' . $no_order . '"') or die();*/
				
		while($dat_lis = mysql_fetch_array($get_lis)){
			$kode_petugas = '';
			$nama_petugas = '';
			$arr_petugas = explode('^',$dat_lis['VALIDATE_BY']);
			if(sizeof($arr_petugas) > 0){
				$kode_petugas = $arr_petugas[0];
				$nama_petugas = $arr_petugas[1];
			}	
			
			mysql_query('INSERT INTO t_laboratorium_lis_data (PENUNJANG_ID,RAWAT_ID,JNS_ORDER,NO_ORDER,
				NO_TARIF,KODE_TEST,NAMA_TEST,GROUP_TEST,RUJUKAN,TIPE_DATA,HASIL,FLAG,SATUAN,
				KETERANGAN_HASIL,KODE_PETUGAS,NAMA_PETUGAS,TGL_VALIDASI,TGL_TRANS) VALUES(
				"' . $penunjang_id . '","' . $rawat_id . '","' . $jns_order . '","' . $no_order . '",
				"' . $no_tarif . '","' . $dat_lis['TEST_CD'] . '","' . $dat_lis['TEST_NM'] . '",
				"' . $dat_lis['TEST_GROUP'] . '","' . replace_quote($dat_lis['REF_RANGE']) . '","' . $dat_lis['DATA_TYP'] . '",
				"' . replace_quote($dat_lis['RESULT_VALUE']) . '","' . $dat_lis['FLAG'] . '","' . replace_quote($dat_lis['UNIT']) . '",
				"' . replace_quote($dat_lis['TEST_COMMENT']) . '","' . $kode_petugas . '","' . replace_quote($nama_petugas) . '",
				STR_TO_DATE("' . $dat_lis['VALIDATE_ON'] . '","%Y%m%d%H%i%s"),NOW())') or die(mysql_error());
		}
		
		$nomor_laboratorium = getNomorHarian('Laboratorium');
		erm_laboratorium_from_lis($idx,strtolower($jns_order),$no_order);	
		
		mysql_query('UPDATE t_ipenunjang SET RESULT_FR_LIS = "1",
			NO_LABORATORIUM = "' . $nomor_laboratorium . '"
			WHERE PENUNJANG_ID = "' . $penunjang_id . '"
			AND JNS_ORDER = "' . $jns_order . '"
			AND NO_ORDER = "' . $no_order . '"') or die(mysql_error());
	}		
}	
?>