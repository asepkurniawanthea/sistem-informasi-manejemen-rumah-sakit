<?php
include('C:/xampp/htdocs/nsimrs/config/config.php');
include('C:/xampp/htdocs/nsimrs/shared/connect_db.php');

$qry_rad = 'SELECT e.IRNA_EDUKASI_ID,r.NOMR,
	DATE_FORMAT(r.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR
	FROM t_irna_edukasi e 
	INNER JOIN t_irna r
	ON (e.IRNA_EDUKASI_ID = r.IRNA_ID)
	WHERE e.ST_CREATE_ERM IS NULL';
	
$get_rad = mysql_query($qry_rad) or die(mysql_error());
while($dat_rad = mysql_fetch_array($get_rad)){
	$idx = $dat_rad['IRNA_EDUKASI_ID'];
	$nomr = $dat_rad['NOMR'];
	$tanggal = $dat_rad['TANGGAL_DAFTAR'];
	
	$jns_perawatan = '2';

	if(!file_exists($rmfile_path . '/pdf/' . $jns_perawatan . '/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/pdf/' . $jns_perawatan . '/' . $nomr . '/' . $idx, 0700, true);
	}
	
	$nama_file = $nomr . '_' . $idx . '_10';		
	
	mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE RAWAT_ID = "' . $idx . '"
				AND JNS_PERAWATAN = "' . $jns_perawatan . '"
				AND JENIS_DOKUMEN_ID = "10"
				AND NAMA_FILE = "' . $nama_file . '.pdf"') or die(mysql_error());
				
	mysql_query('INSERT INTO t_rm_dokumen_file(JENIS_DOKUMEN_ID,NOMR,RAWAT_ID,JNS_PERAWATAN,NAMA_FILE,ST_SISTEM,TANGGAL) 
				VALUES("10","' . $nomr . '","' . $idx . '","' . $jns_perawatan . '",
				"' . $nama_file . '.pdf","1",STR_TO_DATE("' . $tanggal . '","%d/%m/%Y"))') or die(mysql_error());	
	
	$link_main = '"http://192.168.1.2/nsimrs/rawatinap/pemberian_edukasi_to_pdf.php?idx=' . $idx . '"';
	$link_footer = '"http://192.168.1.2/nsimrs/rawatinap/pemberian_edukasi_to_pdf_footer.php?idx=' . $idx . '"';
	$file_target = '"' . $rmfile_path . '/pdf/' . $jns_perawatan . '/' . $nomr . '/' . $idx . '/' . $nama_file . '.pdf';

	exec($htmltopdf_tool_path . ' --footer-html ' . $link_footer . ' ' . $link_main . ' ' . $file_target);	
	
	mysql_query('UPDATE t_irna_edukasi SET ST_CREATE_ERM = "1"
			WHERE IRNA_EDUKASI_ID = "' . $idx . '"') or die(mysql_error());		
}	
?>