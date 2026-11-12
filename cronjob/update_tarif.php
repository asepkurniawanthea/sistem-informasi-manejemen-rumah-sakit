<?php
include('C:/xampp/htdocs/nsimrs/config/config.php');
include('C:/xampp/htdocs/nsimrs/shared/connect_db.php');

$get_tarif = mysql_query('SELECT * FROM m_tarif_temp') or die(mysql_error());
while($dat_tarif = mysql_fetch_array($get_tarif)){
	$id_tarif = $dat_tarif['TARIF_ID'];
	$jasa_sarana = $dat_tarif['JASA_SARANA_HCU'];
	$jasa_pelayanan = $dat_tarif['JASA_PELAYANAN_HCU'];
	$tarif_hcu = $dat_tarif['TARIF_HCU'];
	
	$get_tarif_old = mysql_query('SELECT * FROM m_tarif WHERE TARIF_ID = "' . $id_tarif . '"') or die(mysql_error());
	while($dat_tarif_old = mysql_fetch_array($get_tarif_old)){
	
		mysql_query('UPDATE m_tarif SET ST_AKTIF = NULL WHERE TARIF_ID = "' . $id_tarif . '"') or die(mysql_error());
		
		mysql_query('INSERT INTO m_tarif (KODE_TARIF,NAMA_TARIF,SATUAN, KODE_TARIF_GROUP, 
			JASA_SARANA, JASA_DOKTER, JASA_RS, JASA_PELAYANAN, TARIF_NON_KELAS, 
			JASA_SARANA_KELAS_3, JASA_PELAYANAN_KELAS_3, TARIF_KELAS_3, 
			JASA_SARANA_KELAS_2, JASA_PELAYANAN_KELAS_2, TARIF_KELAS_2, 
			JASA_SARANA_KELAS_1, JASA_PELAYANAN_KELAS_1, TARIF_KELAS_1, 
			JASA_SARANA_KELAS_UTAMA, JASA_PELAYANAN_KELAS_UTAMA, TARIF_KELAS_UTAMA, 
			JASA_SARANA_KELAS_UTAMA_2, JASA_PELAYANAN_KELAS_UTAMA_2, TARIF_KELAS_UTAMA_2, 
			JASA_SARANA_KELAS_PERINA_SEHAT, JASA_PELAYANAN_KELAS_PERINA_SEHAT, TARIF_KELAS_PERINA_SEHAT, 
			JASA_SARANA_KELAS_PERINA_SAKIT, JASA_PELAYANAN_KELAS_PERINA_SAKIT, TARIF_KELAS_PERINA_SAKIT, 
			JASA_SARANA_HCU, JASA_PELAYANAN_HCU, TARIF_HCU, 
			JASA_SARANA_ICU, JASA_PELAYANAN_ICU, TARIF_ICU, 
			JASA_SARANA_NICU, JASA_PELAYANAN_NICU, TARIF_NICU, 
			JASA_SARANA_PICU, JASA_PELAYANAN_PICU, TARIF_PICU, 
			JASA_SARANA_ICCU, JASA_PELAYANAN_ICCU, TARIF_ICCU, 
			JASA_SARANA_PERINA, JASA_PELAYANAN_PERINA, TARIF_PERINA, 
			ICD_CODE, USER_RM, TAHUN_UPDATE, ST_AKTIF, 
			USER_ADMIN, UNIT_ID, ODC, KELAS_ODC, 
			IMUNISASI, MCU, ST_TEMP)
			VALUES(
			"' . $dat_tarif_old['KODE_TARIF'] . '","' . $dat_tarif_old['NAMA_TARIF'] . '",
			"' . $dat_tarif_old['SATUAN'] . '","' . $dat_tarif_old['KODE_TARIF_GROUP'] . '",
			"' . $dat_tarif_old['JASA_SARANA'] . '","' . $dat_tarif_old['JASA_DOKTER'] . '",
			"' . $dat_tarif_old['JASA_RS'] . '","' . $dat_tarif_old['JASA_PELAYANAN'] . '",
			"' . $dat_tarif_old['TARIF_NON_KELAS'] . '","' . $dat_tarif_old['JASA_SARANA_KELAS_3'] . '",
			"' . $dat_tarif_old['JASA_PELAYANAN_KELAS_3'] . '","' . $dat_tarif_old['TARIF_KELAS_3'] . '",
			"' . $dat_tarif_old['JASA_SARANA_KELAS_2'] . '","' . $dat_tarif_old['JASA_PELAYANAN_KELAS_2'] . '",
			"' . $dat_tarif_old['TARIF_KELAS_2'] . '","' . $dat_tarif_old['JASA_SARANA_KELAS_1'] . '",
			"' . $dat_tarif_old['JASA_PELAYANAN_KELAS_1'] . '","' . $dat_tarif_old['TARIF_KELAS_1'] . '",
			"' . $dat_tarif_old['JASA_SARANA_KELAS_UTAMA'] . '","' . $dat_tarif_old['JASA_PELAYANAN_KELAS_UTAMA'] . '",
			"' . $dat_tarif_old['TARIF_KELAS_UTAMA'] . '","' . $dat_tarif_old['JASA_SARANA_KELAS_UTAMA_2'] . '",
			"' . $dat_tarif_old['JASA_PELAYANAN_KELAS_UTAMA_2'] . '","' . $dat_tarif_old['TARIF_KELAS_UTAMA_2'] . '",
			"' . $dat_tarif_old['JASA_SARANA_KELAS_PERINA_SEHAT'] . '",
			"' . $dat_tarif_old['JASA_PELAYANAN_KELAS_PERINA_SEHAT'] . '",
			"' . $dat_tarif_old['TARIF_KELAS_PERINA_SEHAT'] . '","' . $dat_tarif_old['JASA_SARANA_KELAS_PERINA_SAKIT'] . '",
			"' . $dat_tarif_old['JASA_PELAYANAN_KELAS_PERINA_SAKIT'] . '",
			"' . $dat_tarif_old['TARIF_KELAS_PERINA_SAKIT'] . '",
			"' . $jasa_sarana . '", "' . $jasa_pelayanan . '", "' . $tarif_hcu . '", 
			"' . $dat_tarif_old['JASA_SARANA_ICU'] . '","' . $dat_tarif_old['JASA_PELAYANAN_ICU'] . '",
			"' . $dat_tarif_old['TARIF_ICU'] . '","' . $dat_tarif_old['JASA_SARANA_NICU'] . '",
			"' . $dat_tarif_old['JASA_PELAYANAN_NICU'] . '","' . $dat_tarif_old['TARIF_NICU'] . '",
			"' . $dat_tarif_old['JASA_SARANA_PICU'] . '","' . $dat_tarif_old['JASA_PELAYANAN_PICU'] . '",
			"' . $dat_tarif_old['TARIF_PICU'] . '","' . $dat_tarif_old['JASA_SARANA_ICCU'] . '",
			"' . $dat_tarif_old['JASA_PELAYANAN_ICCU'] . '","' . $dat_tarif_old['TARIF_ICCU'] . '",
			"' . $dat_tarif_old['JASA_SARANA_PERINA'] . '","' . $dat_tarif_old['JASA_PELAYANAN_PERINA'] . '",
			"' . $dat_tarif_old['TARIF_PERINA'] . '","' . $dat_tarif_old['ICD_CODE'] . '",
			"' . $dat_tarif_old['USER_RM'] . '","' . $dat_tarif_old['TAHUN_UPDATE'] . '",
			"' . $dat_tarif_old['ST_AKTIF'] . '","' . $dat_tarif_old['USER_ADMIN'] . '","' . $dat_tarif_old['UNIT_ID'] . '",
			"' . $dat_tarif_old['ODC'] . '","' . $dat_tarif_old['KELAS_ODC'] . '","' . $dat_tarif_old['IMUNISASI'] . '",
			"' . $dat_tarif_old['MCU'] . '","' . $dat_tarif_old['ST_TEMP'] . '")');
	}	
}					
?>