<?php
$user_name ='';
include('config/config.php');
include('shared/connect_db.php');
include('shared/function.php');
include('shared/enum_function.php');

include('lib/vendor/autoload.php');
include('lib/vendor/rkorebrits/htmltoopenxml/Archives/Scripts/HTMLtoOpenXML.php');
include('inacbg/inacbg_create_billing.php');
include('inacbg/inacbg_create_sep.php');
include('inacbg/inacbg_create_sjp.php');

function is_valid_name($file) {
  return preg_match('/^([-\.\w]+)$/', $file) > 0;
}

$arr_erm = array();
$sql_arr_erm = 'SELECT JENIS_DOKUMEN_ID,JENIS_DOKUMEN,LIST_ORDER FROM m_rm_jenis_dokumen';
$get_arr_erm = mysql_query($sql_arr_erm) or die(mysql_error());
while($dat_arr_erm = mysql_fetch_array($get_arr_erm)){
	$nama_dok_file = strtolower(str_replace(' ','_',$dat_arr_erm['JENIS_DOKUMEN']));
	$nama_prefix = substr('00',0,2 - strlen($dat_arr_erm['LIST_ORDER'])) . $dat_arr_erm['LIST_ORDER'];
	$arr_erm[$dat_arr_erm['JENIS_DOKUMEN_ID']] = $nama_prefix . '_' . $nama_dok_file;  
}

$sql_trans = 'SELECT CASE WHEN t_irna.JENIS_BAYAR_ID = 12 THEN t_irna.NO_SEP ELSE t_irna.NO_SJP END AS NO_SEP,
			t_irna.IRNA_ID,t_irna.JENIS_BAYAR_ID
			FROM t_irna
			WHERE t_irna.NO_PENDAFTARAN IS NOT NULL AND t_irna.ST_BATAL IS NULL
			AND STR_TO_DATE(DATE_FORMAT(t_irna.PASIEN_KELUAR,"%Y-%m-%d"),"%Y-%m-%d") >= STR_TO_DATE(DATE_FORMAT(DATE_ADD(NOW(),INTERVAL - 7 DAY),"%Y-%m-%d"),"%Y-%m-%d")';
$get_trans = mysql_query($sql_trans) or die(mysql_error());
while($dat_trans = mysql_fetch_array($get_trans)){
	$no_sep = $dat_trans['NO_SEP'];
	$id = $dat_trans['IRNA_ID'];
	$jenis_bayar = $dat_trans['JENIS_BAYAR_ID'];
	
	if(is_valid_name($no_sep)){
		if(!file_exists($eklaim_arsip_path . '/pdf/' . $no_sep)){
			@mkdir($eklaim_arsip_path . '/pdf/' . $no_sep, 0700, true);
		}

		if(!file_exists($eklaim_arsip_path . '/doc/' . $no_sep)){
			@mkdir($eklaim_arsip_path . '/doc/' . $no_sep, 0700, true);
		}
		
		if(!file_exists($eklaim_arsip_path . '/' . $no_sep)){
			@mkdir($eklaim_arsip_path . '/' . $no_sep, 0700, true);
		}
	
		inacbg_create_billing('1',$id,$no_sep);
		inacbg_create_sep('1',$id,$no_sep,$jenis_bayar);
		inacbg_create_sjp('1',$id,$no_sep);
	
		//copy file to sep
		$fl_source = $eklaim_arsip_path . '/pdf/' . $no_sep . '/01_billing.pdf';
		$fl_target = $eklaim_arsip_path . '/' . $no_sep . '/01_billing.pdf';
		if(file_exists($fl_source)) copy($fl_source,$fl_target);
		$fl_source = $eklaim_arsip_path . '/pdf/' . $no_sep . '/01_sjp.pdf';
		$fl_target = $eklaim_arsip_path . '/' . $no_sep . '/01_sjp.pdf';
		if(file_exists($fl_source)) copy($fl_source,$fl_target);
		$fl_source = $eklaim_arsip_path . '/pdf/' . $no_sep . '/01_sep.pdf';
		$fl_target = $eklaim_arsip_path . '/' . $no_sep . '/01_sep.pdf';
		if(file_exists($fl_source)) copy($fl_source,$fl_target);
		
		//copy file from erm
		$sql_erm = 'SELECT FILE_ID,JENIS_DOKUMEN_ID,TANGGAL,NOMR,RAWAT_ID,JNS_PERAWATAN,
				ORDER_PENUNJANG,NAMA_PENUNJANG,NAMA_FILE
				FROM t_rm_dokumen_file
				WHERE RAWAT_ID = "' . $id . '"
				AND JNS_PERAWATAN = "2"';
		$get_erm = mysql_query($sql_erm) or die(mysql_error());
		while($dat_erm = mysql_fetch_array($get_erm)){
			$fl_source = $rmfile_path . '/pdf/' . $dat_erm['JNS_PERAWATAN'] . '/' . $dat_erm['NOMR'] . '/' . $dat_erm['RAWAT_ID'] . '/' . $dat_erm['NAMA_FILE']; 
			$fl_target = $eklaim_arsip_path . '/' . $no_sep . '/' . $arr_erm[$dat_erm['JENIS_DOKUMEN_ID']] . '_' . $dat_erm['FILE_ID'] . '.pdf';
			if(file_exists($fl_source)){
				copy($fl_source,$fl_target);	
			}
		}	
		
		shell_exec($ziptool_path . ' a -tzip ' . $eklaim_arsip_path . '/' . $no_sep . '.zip ' . $eklaim_arsip_path . '/' . $no_sep);
	}
}
?>