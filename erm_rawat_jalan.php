<?php
$user_name ='';
include('config/config.php');
include('shared/connect_db.php');
include('shared/function.php');
include('edoc_rekammedik/edoc_main.php');

$sql_trans = 'SELECT t_irja.IRJA_ID 
			FROM t_irja
			WHERE t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL 
			AND t_irja.TANGGAL_DAFTAR >= STR_TO_DATE(DATE_FORMAT(DATE_ADD(NOW(),INTERVAL - 7 DAY),"%Y-%m-%d"),"%Y-%m-%d")
			AND t_irja.TANGGAL_DAFTAR <= STR_TO_DATE(DATE_FORMAT(NOW(),"%Y-%m-%d"),"%Y-%m-%d")';
$get_trans = mysql_query($sql_trans) or die(mysql_error());
$x = mysql_num_rows($get_trans);
while($dat_trans = mysql_fetch_array($get_trans)){
	$irja_id = $dat_trans['IRJA_ID'];
	
	//create_pdf_pengkajian_awal($irja_id,'RJ');
	//create_pdf_catatan_perkembangan_pasien($irja_id,'RJ');
	//create_pdf_asuhan_keperawatan_rawat_jalan($irja_id);
	//create_pdf_pemberian_edukasi($irja_id,'RJ');
	//create_pdf_rencana_pemulangan($irja_id,'RJ');
	//create_pdf_terapi_monitoring_rawat_jalan($irja_id);
	create_pdf_resep($irja_id,'RJ');
	//create_pdf_kusta($irja_id);
	//create_pdf_identitas($irja_id,'RJ');
	//create_pdf_ringkasan_kunjungan_rawat_jalan($irja_id);
		
}

mysql_data_seek($get_trans, 0);
while($dat_trans = mysql_fetch_array($get_trans)){
	$irja_id = $dat_trans['IRJA_ID'];
	create_pdf_farmasi($irja_id,'RJ');	
}

?>