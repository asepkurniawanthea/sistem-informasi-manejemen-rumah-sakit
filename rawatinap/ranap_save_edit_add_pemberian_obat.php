<?php
$irna_id = $_POST['irna_id'];
$pemberian_obat_id = $_POST['pemberian_obat_id'];
$tanggal = $_POST['tanggal'];
$jam = $_POST['jam'];
$menit = $_POST['menit'];
$insidentil = '';
$obat_dari_luar = '';
$obat_resep = '';
if(isset($_POST['insidentil'])) $insidentil = '1';
if(isset($_POST['obat_dari_luar'])) $obat_dari_luar = '1';
if(isset($_POST['obat_resep'])) $obat_resep = '1';
$nama_obat = $_POST['nama_obat'];
$dosis = $_POST['dosis'];
$status_dosis = $_POST['status_dosis'];
$pegawai_id = $_POST['pegawai_id'];

$sql_cek_no_ranap = 'SELECT NO_RAWAT FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
$get_cek_no_ranap = mysql_query($sql_cek_no_ranap) or die(mysql_error());
$dat_cek_no_ranap = mysql_fetch_assoc($get_cek_no_ranap);

if (empty($dat_cek_no_ranap['NO_RAWAT']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {		       
	$persediaan_id = '';
	$nama_persediaan = '';
	$jenis_persediaan = '';
	$satuan = '';
	$harga_beli = '0';
	$harga_jual = '0';
	$jumlah_keluar = '0';
	if(is_numeric($dosis)) $jumlah_keluar = $dosis; 
	$formularium = '';
	$formularium_nas = '';
	
	$persediaan = explode('[',$nama_obat);
	if(count($persediaan)> 1){
		$connect_3= mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
		mysql_select_db($database_3, $connect_3) or die(mysql_error());
		$nama_persediaan = $persediaan[0]; 
		$sql_persediaan = 'SELECT m_persediaan_group.PERSEDIAAN_GROUP,m_persediaan_farmasi.SATUAN,
							m_persediaan_farmasi.HARGA_BELI,m_persediaan_farmasi.HARGA_JUAL,
							m_persediaan_farmasi.NAMA_PERSEDIAAN,m_persediaan_farmasi.PERSEDIAAN_ID,
							m_persediaan_farmasi.FORMULARIUM,m_persediaan_farmasi.FORMULARIUM_NASIONAL
							FROM m_persediaan_farmasi
							INNER JOIN m_persediaan_group ON (m_persediaan_farmasi.PERSEDIAAN_GROUP_ID = m_persediaan_group.PERSEDIAAN_GROUP_ID)
							WHERE m_persediaan_farmasi.NAMA_PERSEDIAAN = "' . trim($nama_persediaan) . '"';
		$get_persediaan = mysql_query($sql_persediaan) or die(mysql_error());
		$dat_persediaan = mysql_fetch_assoc($get_persediaan);
		$nama_persediaan = $dat_persediaan['NAMA_PERSEDIAAN']; 
		$jenis_persediaan = $dat_persediaan['PERSEDIAAN_GROUP'];
		$satuan = $dat_persediaan['SATUAN'];
		$harga_beli = $dat_persediaan['HARGA_BELI'];
		$harga_jual = $dat_persediaan['HARGA_JUAL'];
		$persediaan_id = $dat_persediaan['PERSEDIAAN_ID']; 
		$formularium = $dat_persediaan['FORMULARIUM']; 
		$formularium_nas = $dat_persediaan['FORMULARIUM_NASIONAL']; 
	}else{
		$nama_persediaan = $nama_obat;
	}			
	
	$connect= mysql_connect($hostname, $username, $password) or die(mysql_error());
	mysql_select_db($database, $connect) or die(mysql_error());
		
	mysql_query('UPDATE t_irna_pemberian_obat
				SET TANGGAL = ' . fieldDatetime($tanggal . ' ' . $jam . ':' . $menit . ':01') . ',
				RESEP = "' . $obat_resep . '",
				INSIDENTIL = "' . $insidentil . '",
				PERSEDIAAN_ID = "' . $persediaan_id . '",
				NAMA_PERSEDIAAN = "' . $nama_persediaan . '",
				JENIS_PERSEDIAAN = "' . $jenis_persediaan . '",
				SATUAN = "' . $satuan . '",
				DOSIS = "' . $dosis . '",
				JUMLAH_KELUAR = "' . $jumlah_keluar . '",
				HARGA_BELI = "' . $harga_beli . '",
				HARGA_JUAL = "' . $harga_jual . '",
				STATUS_DOSIS = "' . $status_dosis . '",
				OBAT_DR_LUAR = "' . $obat_dari_luar . '",
				FORMULARIUM = "' . $formularium . '",
				FORMULARIUM_NASIONAL = "' . $formularium_nas . '",
				PEGAWAI_ID = "' . $pegawai_id . '"
				WHERE PEMBERIAN_OBAT_ID = "' . $pemberian_obat_id . '"') or die(mysql_error());
}
?>
 <script language="JavaScript" >
		setTimeout(opener.location.reload(), 3000);
		window.close();
</script>