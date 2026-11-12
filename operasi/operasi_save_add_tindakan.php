<?php
$irna_id = $_GET['irna_id'];
$tarif_id = $_GET['tarif_id'];
$pegawai_id = 'NULL';
if(isset($_GET['pegawai_id']))
	$pegawai_id = '"' . $_GET['pegawai_id'] . '"';
	
	$sql_cek_no_operasi = 'SELECT NO_OPERASI FROM t_operasi WHERE IRNA_ID = "' . $irna_id . '"';
	$get_cek_no_operasi = mysql_query($sql_cek_no_operasi) or die(mysql_error());
	$dat_cek_no_operasi = mysql_fetch_assoc($get_cek_no_operasi);
	if (empty($dat_cek_no_operasi['NO_OPERASI']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {		       
			mysql_query('INSERT INTO t_operasi_tarif(IRNA_ID,TARIF_ID,PEGAWAI_ID)
						VALUES("' . $irna_id . '","' . $tarif_id . '",' . $pegawai_id . ')') or die(mysql_error());
			 
	}
