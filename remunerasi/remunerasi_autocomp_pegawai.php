<?php
$q = strtolower($_GET['q']);
if (!$q)
    return;

$connect_7 = mysql_connect($hostname_7, $username_7, $password_7) or die(mysql_error());
mysql_select_db($database_7, $connect_7) or die(mysql_error());

$qry = 'SELECT NIP,NAMA_PEGAWAI
		FROM r_pegawai_ori
		WHERE NAMA_PEGAWAI LIKE "%' . $q . '%"
		ORDER BY NAMA_PEGAWAI'; 	

$data = mysql_query($qry) or die(mysql_error());
while ($row = mysql_fetch_array($data)) {
    echo $row['NIP'] . '--' . $row['NAMA_PEGAWAI'] . " \n ";
}
?>