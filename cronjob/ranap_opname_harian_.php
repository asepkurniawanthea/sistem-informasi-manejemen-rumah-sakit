<?php

include('C:/xampp/htdocs/nsimrs/config/config.php');
include('C:/xampp/htdocs/nsimrs/shared/connect_db.php');
include('C:/xampp/htdocs/nsimrs/shared/function.php');

$sql_opname = 'SELECT t_irna.IRNA_ID,t_irna.NOMR,
				t_irna.RUANG_ID,t_irna.PEGAWAI_ID,
				t_irna.PEGAWAI_RAWAT_ID,t_irna.JENIS_BAYAR_ID,
				t_irna.NO_TMP_TIDUR
				FROM t_irna
				WHERE t_irna.PASIEN_MASUK IS NOT NULL
				AND t_irna.PASIEN_KELUAR IS NULL
				AND t_irna.ST_PULANG IS NULL
				AND t_irna.ST_BATAL IS NULL';
$get_opname = mysql_query($sql_opname) or die(mysql_error());
while($dat_opname = mysql_fetch_array($get_opname)){
	mysql_query('INSERT INTO t_irna_opname(
				RUANG_ID,TANGGAL_OPNAME,IRNA_ID,
				NOMR,PEGAWAI_ID,PEGAWAI_RAWAT_ID,
				JENIS_BAYAR_ID,NO_TMP_TIDUR) VALUES(
				"' . $dat_opname['RUANG_ID'] . '",DATE_ADD(NOW(),INTERVAL -1 DAY),"' . $dat_opname['IRNA_ID'] . '",
				"' . $dat_opname['NOMR'] . '","' . $dat_opname['PEGAWAI_ID'] . '","' . $dat_opname['PEGAWAI_RAWAT_ID'] . '",
				"' . $dat_opname['JENIS_BAYAR_ID'] . '","' . $dat_opname['NO_TMP_TIDUR'] . '")') or die(mysql_error());
}				
?>