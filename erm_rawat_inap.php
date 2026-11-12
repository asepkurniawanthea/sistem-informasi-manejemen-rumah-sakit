<?php
$user_name ='';
include('config/config.php');
include('shared/connect_db.php');
include('shared/function.php');
include('edoc_rekammedik/edoc_main.php');

$sql_trans = 'SELECT t_irna.IRNA_ID 
			FROM t_irna
			WHERE t_irna.NO_PENDAFTARAN IS NOT NULL AND t_irna.ST_BATAL IS NULL 
			AND DATE(t_irna.PASIEN_KELUAR) >= STR_TO_DATE(DATE_FORMAT(DATE_ADD(NOW(),INTERVAL - 7 DAY),"%Y-%m-%d"),"%Y-%m-%d")
			AND DATE(t_irna.PASIEN_KELUAR) <= STR_TO_DATE(DATE_FORMAT(NOW(),"%Y-%m-%d"),"%Y-%m-%d")';
$get_trans = mysql_query($sql_trans) or die(mysql_error());
$x = mysql_num_rows($get_trans);
while($dat_trans = mysql_fetch_array($get_trans)){
	$irna_id = $dat_trans['IRNA_ID'];
	
	//create_pdf_identitas($irna_id,'RI');
	//create_pdf_ringkasan_masuk_rawat_inap($irna_id);
	//create_pdf_pengkajian_awal($irna_id,'RI');
	//create_pdf_resume_medis($irna_id);
	//create_pdf_resep($irna_id,'RI');
	//create_pdf_catatan_perkembangan_pasien($irna_id,'RI');
	//create_pdf_pemberian_edukasi($irna_id,'RI');
	//create_pdf_rencana_pemulangan($irna_id,'RI');
	//create_pdf_rekonsiliasi_obat($irna_id);
	create_pdf_asuhan_keperawatan_rawat_inap($irna_id);
	//create_pdf_ringkasan_riwayat_masuk_keluar_rawat_inap($irna_id);
		
}

mysql_data_seek($get_trans, 0);
while($dat_trans = mysql_fetch_array($get_trans)){
	$irna_id = $dat_trans['IRNA_ID'];
	//create_pdf_farmasi($irna_id,'RI');	
}

?>