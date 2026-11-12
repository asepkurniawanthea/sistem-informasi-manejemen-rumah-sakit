<?php
include('C:/xampp/htdocs/nsimrs/config/config.php');
include('C:/xampp/htdocs/nsimrs/shared/connect_db.php');


$get = mysql_query('SELECT NIP, ALAMAT FROM db_sdm.r_pegawai_ori') or die(mysql_error());
while($dat = mysql_fetch_array($get)){
	mysql_query('UPDATE db_sdm.r_pegawai_ori 
		SET ALAMAT = "' . ucwords(strtolower($dat['ALAMAT'])) . '"
		WHERE NIP = "' . $dat['NIP'] . '"') or die(mysql_error());
}
?>