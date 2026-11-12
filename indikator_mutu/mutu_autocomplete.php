<?php
$connect = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
mysql_select_db($database_5, $connect) or die(mysql_error());

$q = strtolower($_GET['q']);
if (!$q)
    return;

if(isset($_GET['dt_param']) && !isset($_GET['dt_param2'])){
	$field = '';
	if($_GET['dt_param'] == 'fasilitas') $field = 'FASILITAS';
	if($_GET['dt_param'] == 'pelayanan') $field = 'PELAYANAN';
	if($_GET['dt_param'] == 'ruangan') $field = 'RUANGAN';
	if($_GET['dt_param'] == 'unit_pelayanan') $field = 'UNIT_PELAYANAN';
	if($_GET['dt_param'] == 'nama_observer') $field = 'NAMA_OBSERVER';
		
	if($field != ''){
		$data = mysql_query('SELECT ' . $field . '
							FROM mutu_kepatuhan_cuci_tangan 
							WHERE ' . $field . ' LIKE "%' . $q . '%"
							ORDER BY ' . $field) or die(mysql_error());					
	}
	while ($row = mysql_fetch_array($data)) {
		echo $row[$field] . " \n ";
	}
}

if(isset($_GET['dt_param']) && isset($_GET['dt_param2'])){
	$field = '';
	if($_GET['dt_param'] == 'pengumpul') $field = 'PENGUMPUL_DATA';
	if($_GET['dt_param'] == 'keterangan') $field = 'KETERANGAN_PENGUMPUL_DATA';
		
	if($field != ''){
		$data = mysql_query('SELECT ' . $field . '
							FROM mutu_pengukuran_kepuasan_pasien_dan_keluarga 
							WHERE ' . $field . ' LIKE "%' . $q . '%"
							ORDER BY ' . $field) or die(mysql_error());					
	}
	while ($row = mysql_fetch_array($data)) {
		echo $row[$field] . " \n ";
	}
}

if(isset($_GET['mutu_param'])){
	if($_GET['mutu_param'] == 'nama_petugas'){
		$data = mysql_query('SELECT * FROM (
							SELECT "1" AS APP,pgw.PEGAWAI_ID,pgw.NAMA_PEGAWAI
							FROM db_simrs.m_pegawai pgw
							WHERE pgw.NAMA_PEGAWAI LIKE "%' . $q . '%"
							UNION ALL
							SELECT "2" AS APP,pgw.PEGAWAI_ID,pgw.NAMA_PEGAWAI
							FROM db_inventorirs.m_pegawai pgw
							WHERE pgw.NAMA_PEGAWAI LIKE "%' . $q . '%"
							) t_pegawai 
							ORDER BY NAMA_PEGAWAI') or die(mysql_error());
		while ($row = mysql_fetch_array($data)) {
		$id_pegawai = $row['APP'] . substr('00000',0,5 - strlen($row['PEGAWAI_ID'])) . $row['PEGAWAI_ID']; 
		echo $id_pegawai . '--' . $row['NAMA_PEGAWAI'] . " \n ";
	}					
	}
}
?>