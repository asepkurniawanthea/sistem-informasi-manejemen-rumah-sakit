<?php
include('C:/xampp/htdocs/nsimrs/config/config.php');
include('C:/xampp/htdocs/nsimrs/shared/connect_db.php');

$qry_kontrol = 'SELECT DISTINCT k.IRNA_ID,i.NOMR,
	DATE_FORMAT(i.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR 
	FROM t_irna_kontrol_istimewa k 
	INNER JOIN t_irna i
	ON (k.IRNA_ID = i.IRNA_ID)
	WHERE k.ST_CREATE_ERM IS NULL';
	
$get_kontrol = mysql_query($qry_kontrol) or die(mysql_error());
while($dat_kontrol = mysql_fetch_array($get_kontrol)){
	$idx = $dat_kontrol['IRNA_ID'];
	$nomr = $dat_kontrol['NOMR'];
	$tanggal = $dat_kontrol['TANGGAL_DAFTAR'];
	
	$jns_perawatan = '2';

	if(!file_exists($rmfile_path . '/pdf/' . $jns_perawatan . '/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/pdf/' . $jns_perawatan . '/' . $nomr . '/' . $idx, 0700, true);
	}
	
	$nama_file = $nomr . '_' . $idx . '_64';		
	
	mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE RAWAT_ID = "' . $idx . '"
				AND JNS_PERAWATAN = "' . $jns_perawatan . '"
				AND JENIS_DOKUMEN_ID = "64"
				AND NAMA_FILE = "' . $nama_file . '.pdf"') or die(mysql_error());
				
	mysql_query('INSERT INTO t_rm_dokumen_file(JENIS_DOKUMEN_ID,NOMR,RAWAT_ID,JNS_PERAWATAN,NAMA_FILE,ST_SISTEM,TANGGAL) 
				VALUES("64","' . $nomr . '","' . $idx . '","' . $jns_perawatan . '",
				"' . $nama_file . '.pdf","1",STR_TO_DATE("' . $tanggal . '","%d/%m/%Y"))') or die(mysql_error());	
	
	$link_main = '"http://192.168.1.2/nsimrs/rawatinap/kontrol_istimewa_to_pdf.php?idx=' . $idx . '"';
	$link_footer = '"http://192.168.1.2/nsimrs/rawatinap/kontrol_istimewa_to_pdf_footer.php?idx=' . $idx . '"';
	$file_target = '"' . $rmfile_path . '/pdf/' . $jns_perawatan . '/' . $nomr . '/' . $idx . '/' . $nama_file . '.pdf';

	exec($htmltopdf_tool_path . ' -O landscape --footer-html ' . $link_footer . ' ' . $link_main . ' ' . $file_target);	
	
	mysql_query('UPDATE t_irna_kontrol_istimewa SET ST_CREATE_ERM = "1"
			WHERE IRNA_ID = "' . $idx . '"') or die(mysql_error());		
}	
?>