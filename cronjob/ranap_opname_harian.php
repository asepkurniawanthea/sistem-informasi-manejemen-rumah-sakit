<?php

include('C:/xampp/htdocs/nsimrs/config/config.php');
include('C:/xampp/htdocs/nsimrs/shared/connect_db.php');
include('C:/xampp/htdocs/nsimrs/shared/function.php');

mysql_query('INSERT INTO t_irna_opname_kamar (RUANG_ID,TANGGAL_OPNAME,JML_TMP_TIDUR)
	SELECT RUANG_ID,NOW(),JML_TMP_TIDUR	FROM m_ruang 
	WHERE ST_AKTIF = "1"') or die(mysql_error());

$sql_opname = 'SELECT t_irna.IRNA_ID,
				t_irna.NOMR,
				t_irna.RUANG_ID,
				t_irna.NO_TMP_TIDUR
				FROM t_irna
				WHERE t_irna.PASIEN_MASUK IS NOT NULL
				AND t_irna.PASIEN_KELUAR IS NULL
				AND t_irna.ST_PULANG IS NULL
				AND t_irna.ST_BATAL IS NULL';
$get_opname = mysql_query($sql_opname) or die(mysql_error());
while($dat_opname = mysql_fetch_array($get_opname)){
	mysql_query('INSERT INTO t_irna_opname(
				TANGGAL_OPNAME,
				IRNA_ID,
				NOMR,
				RUANG_ID,
				NO_TMP_TIDUR) VALUES(
				NOW(),
				"' . $dat_opname['IRNA_ID'] . '",
				"' . $dat_opname['NOMR'] . '",
				"' . $dat_opname['RUANG_ID'] . '",
				"' . $dat_opname['NO_TMP_TIDUR'] . '")') or die(mysql_error());
}	
?>