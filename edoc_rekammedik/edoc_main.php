<?php
function setGarisIfNull($str){
	$ret = $str;
	if(trim($str) == '' or $str == '00/00/0000') $ret = '__________';
	
	return $ret;	
}

function extractRujukanLab($nl){
	$ret = '';
	if(!empty($nl)){
		$arr_nl = explode('|',$nl);
		if(sizeof($arr_nl) > 0) $ret = $arr_nl[1]; 
	}
	
	return $ret;
}

function saveData($nomr,$idx,$jns_rawat,$doc_id,$filename,$username,$no_ext,$nama_ext){
	if($no_ext == '') $no_ext = '-';
	if($username == ''){
		$sql = 'SELECT USER_UPLOAD FROM t_rm_dokumen_file 
				WHERE JENIS_DOKUMEN_ID = "' . $doc_id . '"
				AND NOMR = "' . $nomr . '"
				AND RAWAT_ID = "' . $idx . '" 
				AND JNS_PERAWATAN = "' . $jns_rawat . '"
				AND ORDER_PENUNJANG = "' . $no_ext . '"';
		$get = mysql_query($sql) or die();
		if(mysql_num_rows($get) > 0){
			$dat = mysql_fetch_assoc($get);
			$username = $dat['USER_UPLOAD'];
		}	
	}
	mysql_query('DELETE FROM t_rm_dokumen_file
			WHERE JENIS_DOKUMEN_ID = "' . $doc_id . '"
			AND NOMR = "' . $nomr . '"
			AND RAWAT_ID = "' . $idx . '" 
			AND JNS_PERAWATAN = "' . $jns_rawat . '"
			AND ORDER_PENUNJANG = "' . $no_ext . '"') or die(mysql_error());

	mysql_query('INSERT INTO t_rm_dokumen_file(JENIS_DOKUMEN_ID,NOMR,RAWAT_ID,JNS_PERAWATAN,
			NAMA_FILE,ST_SISTEM,USER_UPLOAD,ORDER_PENUNJANG,NAMA_PENUNJANG)
			VALUES("' . $doc_id . '","' . $nomr . '","' . $idx . '","' . $jns_rawat . '",
			"' . $filename . '","1","' . $username . '","' . $no_ext . '","' . $nama_ext . '")') or die(mysql_error());
}

function setHeader($nomr,$nama_pasien){
	$header = '<table width="100%" style="vertical-align: bottom; font-size: 9pt; color: #000000;"><tr>
		<td width="67%"><span style="font-weight: bold;">' . formatNoMR($nomr) . ' ' . strtoupper($nama_pasien) . '</span></td>
		<td width="33%" style="text-align: right;"><span style="font-weight: bold;">{PAGENO}</span></td>
		</tr></table>';
		
	return $header;	
}	

function setFooter($doc){
	$footer = '<table width="100%" style="vertical-align: bottom; font-size: 9pt; color: #000000; border-top: 1px solid #000000;" ><tr>
		<td align="center"><i>' . $doc . ' ' . getNow() . '</i></td>
		</tr></table>';
		
	return $footer;	
}

function createFolder($nomr){
	global $rmfile_path;
	
	if(!file_exists($rmfile_path . '/' . $nomr)){
		@mkdir($rmfile_path . '/' . $nomr, 0700, true);
	}
}

$edoc_logo = 'edoc_rekammedik/edoc_logo.jpg';
$paper_width = 220;
$paper_height = 340;
$adline = '__________';

include('lib/mpdf/mpdf.php');	
include('edoc_rekammedik/edoc_create_resep.php');
include('edoc_rekammedik/edoc_create_farmasi.php');
?>