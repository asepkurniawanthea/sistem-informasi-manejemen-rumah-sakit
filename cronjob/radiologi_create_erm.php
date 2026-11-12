<?php
include('C:/xampp/htdocs/nsimrs/config/config.php');
include('C:/xampp/htdocs/nsimrs/shared/connect_db.php');

$qry_rad = 'SELECT DISTINCT t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_PEMERIKSAAN_ID,
		t_ipenunjang_tarif_pemeriksaan.REVISI,t_ipenunjang.JNS_ORDER,
		t_ipenunjang.NOMR,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_TARIF,
		DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR
		FROM t_ipenunjang
		INNER JOIN t_ipenunjang_tarif 
		ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
		INNER JOIN t_ipenunjang_tarif_pemeriksaan 
		ON (t_ipenunjang_tarif.PENUNJANG_TARIF_ID = t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_ID)
		INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
		INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
		WHERE (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
			OR m_tarif.UNIT_ID = "17") 
		AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
		AND t_ipenunjang_tarif_pemeriksaan.ST_CREATE_ERM_RADIOLOGI IS NULL';
	
$get_rad = mysql_query($qry_rad) or die(mysql_error());
while($dat_rad = mysql_fetch_array($get_rad)){
	$idx = $dat_rad['PENUNJANG_TARIF_PEMERIKSAAN_ID'];
	$ord = strtolower($dat_rad['JNS_ORDER']);
	$rawat_id = $dat_rad['RAWAT_ID'];
	$nomr = $dat_rad['NOMR'];
	$nomor = $dat_rad['NO_TARIF'];
	$rev = $dat_rad['REVISI'];
	$tanggal = $dat_rad['TANGGAL_DAFTAR'];
	
	$jns_perawatan = '1';
	if(strtolower($ord) == 'irn') $jns_perawatan = '2';
	if(strtolower($ord) == 'ori') $jns_perawatan = '2';

	if(!file_exists($rmfile_path . '/pdf/' . $jns_perawatan . '/' . $nomr . '/' . $rawat_id)){
		@mkdir($rmfile_path . '/pdf/' . $jns_perawatan . '/' . $nomr . '/' . $rawat_id, 0700, true);
	}
	
	$nama_file = $nomr . '_' . strtoupper($ord) . $rawat_id . '_6_' . $nomor . '_' . $idx . '_' . $rev;		
	
	mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE RAWAT_ID = "' . $rawat_id . '"
				AND JNS_PERAWATAN = "' . $jns_perawatan . '"
				AND JENIS_DOKUMEN_ID = "6"
				AND ORDER_PENUNJANG = "' . strtoupper($ord) . $nomor . $idx . $rev . '"') or die(mysql_error());
				
	mysql_query('INSERT INTO t_rm_dokumen_file(JENIS_DOKUMEN_ID,NOMR,RAWAT_ID,JNS_PERAWATAN,NAMA_FILE,ST_SISTEM,
				ORDER_PENUNJANG,TANGGAL) VALUES("6","' . $nomr . '","' . $rawat_id . '","' . $jns_perawatan . '",
				"' . $nama_file . '.pdf","1","' . strtoupper($ord) . $nomor . $idx . $rev . '",
				STR_TO_DATE("' . $tanggal . '","%d/%m/%Y"))') or die(mysql_error());	
	
	$link_main = '"http://192.168.1.2/nsimrs/radiologi/radiologi_to_pdf.php?idx=' . $idx . '&ord=' . $ord . '"';
	$link_footer = '"http://192.168.1.2/nsimrs/radiologi/radiologi_to_pdf_footer.php?idx=' . $idx . '&ord=' . $ord . '"';
	$file_target = '"' . $rmfile_path . '/pdf/' . $jns_perawatan . '/' . $nomr . '/' . $rawat_id . '/' . $nama_file . '.pdf';

	exec($htmltopdf_tool_path . ' --footer-html ' . $link_footer . ' ' . $link_main . ' ' . $file_target);	
	
	mysql_query('UPDATE t_ipenunjang_tarif_pemeriksaan SET ST_CREATE_ERM_RADIOLOGI = "1"
			WHERE PENUNJANG_TARIF_PEMERIKSAAN_ID = "' . $idx . '"') or die(mysql_error());		
}	
?>