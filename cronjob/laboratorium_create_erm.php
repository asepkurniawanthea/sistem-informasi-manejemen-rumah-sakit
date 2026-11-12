<?php
include('C:/xampp/htdocs/nsimrs/config/config.php');
include('C:/xampp/htdocs/nsimrs/shared/connect_db.php');
include('C:/xampp/htdocs/nsimrs/shared/function.php');

include('C:/xampp/htdocs/nsimrs/lib/vendor/autoload.php');
include('C:/xampp/htdocs/nsimrs/lib/html2openxml/HTMLtoOpenXML.php');
include('C:/xampp/htdocs/nsimrs/edoc_rekammedik/new/erm_create_laboratorium_from_lis.php');

ini_set('max_execution_time', '300');

function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = htmlspecialchars($ret);
	return $ret;
}

$qry_src = 'SELECT DISTINCT b.ONO,c.VISITNO
		FROM db_lis.resdt a 
		INNER JOIN db_lis.reshd b
		ON (a.ONO = b.ONO)	
		INNER JOIN db_lis.lis_order c
		ON (b.ONO = c.ONO)	
		WHERE a.FLAG_RD IS NULL';
$get_src = mysql_query($qry_src) or die(mysql_error());
while($dat_src = mysql_fetch_array($get_src)){
	
	$x_order = substr($dat_src['VISITNO'],0,1);
	$qry_lab = 'SELECT DISTINCT t_ipenunjang.PENUNJANG_ID,
			CASE WHEN t_ipenunjang.JNS_ORDER = "APS" 
				THEN t_ipenunjang.PENUNJANG_ID 
				ELSE t_ipenunjang.RAWAT_ID END AS RAWAT_ID,
			t_ipenunjang.JNS_ORDER,
			t_ipenunjang.NO_ORDER,	
			t_ipenunjang_tarif.NO_TARIF
			FROM t_ipenunjang
			INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
			WHERE t_ipenunjang.NO_ORDER = "' . $dat_src['ONO'] . '"
			' . (($x_order == 'P') ? 'AND t_ipenunjang.PENUNJANG_ID = "' . str_replace('P','',$dat_src['VISITNO']) . '"' : 'AND t_ipenunjang.RAWAT_ID = "' . $dat_src['VISITNO'] . '"');
					
	$get_lab = mysql_query($qry_lab) or die(mysql_error());
	$dat_lab = mysql_fetch_assoc($get_lab);
	
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
		mysql_query('DELETE FROM t_laboratorium_lis_data
				WHERE RAWAT_ID = "' . $rawat_id . '"
				AND JNS_ORDER = "' . $jns_order . '"
				AND NO_ORDER = "' . $no_order . '"') or die();
				
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
		erm_laboratorium_from_lis($idx,strtolower($jns_order),$no_order,$nomor_laboratorium);	
		
		mysql_query('UPDATE t_ipenunjang SET RESULT_FR_LIS = "1",
			NO_LABORATORIUM = "' . $nomor_laboratorium . '"
			WHERE PENUNJANG_ID = "' . $penunjang_id . '"
			AND JNS_ORDER = "' . $jns_order . '"
			AND NO_ORDER = "' . $no_order . '"') or die(mysql_error());
			
		mysql_query('UPDATE db_lis.resdt a
			INNER JOIN db_lis.reshd b
			ON (a.ONO = b.ONO)	
			INNER JOIN db_lis.lis_order c
			ON (b.ONO = c.ONO)	
			SET a.FLAG_RD = "1"
			WHERE b.ono = "' . $no_order . '"
			AND b.VISITNO = "' . $visit_no . '"	') or die(mysql_error());	
	
	}		
}	
?>