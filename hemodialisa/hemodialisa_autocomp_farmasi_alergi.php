<?php
$q = strtolower($_GET['q']);
if (!$q)
    return;

$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
mysql_select_db($database_3, $connect_3) or die(mysql_error());

$qry = 'SELECT m_persediaan_farmasi.NAMA_PERSEDIAAN,m_persediaan_farmasi.FORMULARIUM,m_persediaan_farmasi.FORMULARIUM_NASIONAL
		FROM m_persediaan_farmasi
		WHERE m_persediaan_farmasi.NAMA_PERSEDIAAN LIKE "' . $q . '%"
		AND m_persediaan_farmasi.ALKES IS NULL
		ORDER BY m_persediaan_farmasi.NAMA_PERSEDIAAN'; 	

$data = mysql_query($qry) or die(mysql_error());
while ($row = mysql_fetch_array($data)) {
    echo $row['NAMA_PERSEDIAAN'] . " \n ";
}
?>