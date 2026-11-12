<?php
include('C:/xampp/htdocs/nsimrs/config/config.php');
include('C:/xampp/htdocs/nsimrs/shared/connect_db.php');

$qry_rad = 'SELECT IRJA_ID,DATE_FORMAT(TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,NOMR
	FROM t_irja
	WHERE ST_CREATE_ERM_RESEP IS NULL
	AND NO_PENDAFTARAN IS NOT NULL';
	
$get_rad = mysql_query($qry_rad) or die(mysql_error());
while($dat_rad = mysql_fetch_array($get_rad)){
	$idx = $dat_rad['IRJA_ID'];
	$nomr = $dat_rad['NOMR'];
	$tanggal = $dat_rad['TANGGAL_DAFTAR'];

	if(!file_exists($rmfile_path . '/pdf/1/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/pdf/1/' . $nomr . '/' . $idx, 0700, true);
	}
	
	$nama_file = $nomr . '_' . $idx . '_12';		
	
	mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE RAWAT_ID = "' . $idx . '"
				AND JNS_PERAWATAN = "1"
				AND JENIS_DOKUMEN_ID = "12"') or die(mysql_error());
				
	mysql_query('INSERT INTO t_rm_dokumen_file(JENIS_DOKUMEN_ID,NOMR,RAWAT_ID,JNS_PERAWATAN,NAMA_FILE,ST_SISTEM,TANGGAL) 
				VALUES("12","' . $nomr . '","' . $idx . '","1",
				"' . $nama_file . '.pdf","1",STR_TO_DATE("' . $tanggal . '","%d/%m/%Y"))') or die(mysql_error());	
	
	$link_main = '"http://192.168.1.2/nsimrs/klinik/resep_to_pdf.php?idx=' . $idx . '"';
	$link_footer = '"http://192.168.1.2/nsimrs/klinik/resep_to_pdf_footer.php?idx=' . $idx . '"';
	$file_target = '"' . $rmfile_path . '/pdf/1/' . $nomr . '/' . $idx . '/' . $nama_file . '.pdf';

	exec($htmltopdf_tool_path . ' --footer-html ' . $link_footer . ' ' . $link_main . ' ' . $file_target);	
	
	mysql_query('UPDATE t_irja SET ST_CREATE_ERM_RESEP = "1"
			WHERE IRJA_ID = "' . $idx . '"') or die(mysql_error());		
}	
?>