<?php
include('C:/xampp/htdocs/nsimrs/config/config.php');
include('C:/xampp/htdocs/nsimrs/shared/connect_db.php');

$qry_rad = 'SELECT HEMODIALISA_ID,DATE_FORMAT(TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_DAFTAR,
	NOMR,RAWAT_ID,JNS_ORDER
	FROM t_hemodialisa
	WHERE ST_CREATE_ERM_RESEP IS NULL';
	
$get_rad = mysql_query($qry_rad) or die(mysql_error());
while($dat_rad = mysql_fetch_array($get_rad)){
	$idx = $dat_rad['HEMODIALISA_ID'];
	$nomr = $dat_rad['NOMR'];
	$tanggal = $dat_rad['TANGGAL_DAFTAR'];
	$rawat_id = $dat_rad['RAWAT_ID'];
	$order = $dat_rad['JNS_ORDER'];

	$jns_perawatan = '1';
	if($order == 'IRN') $jns_perawatan = '2';
	
	if(!file_exists($rmfile_path . '/pdf/' . $jns_perawatan . '/' . $nomr . '/' . $rawat_id)){
		@mkdir($rmfile_path . '/pdf/' . $jns_perawatan . '/' . $nomr . '/' . $rawat_id, 0700, true);
	}
	
	$nama_file = $nomr . '_' . $rawat_id . '_' . $idx . '_12';		
	
	mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE RAWAT_ID = "' . $rawat_id . '"
				AND JNS_PERAWATAN = "' . $jns_perawatan . '"
				AND JENIS_DOKUMEN_ID = "12"
				AND NAMA_FILE = "' . $nama_file . '.pdf"') or die(mysql_error());
				
	mysql_query('INSERT INTO t_rm_dokumen_file(JENIS_DOKUMEN_ID,NOMR,RAWAT_ID,JNS_PERAWATAN,NAMA_FILE,ST_SISTEM,TANGGAL) 
				VALUES("12","' . $nomr . '","' . $rawat_id . '","' . $jns_perawatan . '",
				"' . $nama_file . '.pdf","1",STR_TO_DATE("' . $tanggal . '","%d/%m/%Y"))') or die(mysql_error());	
	
	$link_main = '"http://192.168.1.2/nsimrs/hemodialisa/resep_to_pdf.php?idx=' . $idx . '"';
	$link_footer = '"http://192.168.1.2/nsimrs/hemodialisa/resep_to_pdf_footer.php?idx=' . $idx . '"';
	$file_target = '"' . $rmfile_path . '/pdf/' . $jns_perawatan . '/' . $nomr . '/' . $rawat_id . '/' . $nama_file . '.pdf';

	exec($htmltopdf_tool_path . ' --footer-html ' . $link_footer . ' ' . $link_main . ' ' . $file_target);	
	
	mysql_query('UPDATE t_hemodialisa SET ST_CREATE_ERM_RESEP = "1"
			WHERE HEMODIALISA_ID = "' . $idx . '"') or die(mysql_error());		
}	
?>