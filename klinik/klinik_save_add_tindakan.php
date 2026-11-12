<?php
$irja_id = $_GET['irja_id'];
$tarif_id = $_GET['tarif_id'];
$pegawai_id = 'NULL';
if(isset($_GET['pegawai_id']))
	$pegawai_id = '"' . $_GET['pegawai_id'] . '"';
	
	$sql_cek_no_klinik = 'SELECT NO_KLINIK FROM t_irja WHERE IRJA_ID = "' . $irja_id . '"';
	$get_cek_no_klinik = mysql_query($sql_cek_no_klinik) or die(mysql_error());
	$dat_cek_no_klinik = mysql_fetch_assoc($get_cek_no_klinik);
	if (empty($dat_cek_no_klinik['NO_KLINIK']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {		       
			mysql_query('INSERT INTO t_irja_tarif(IRJA_ID,TARIF_ID,PEGAWAI_ID)
						VALUES("' . $irja_id . '","' . $tarif_id . '",' . $pegawai_id . ')') or die(mysql_error());
			 
	}
