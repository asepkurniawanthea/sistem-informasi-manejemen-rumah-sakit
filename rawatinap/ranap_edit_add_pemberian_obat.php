<?php
$irna_id = $_POST['irna_id'];
$irna_id1 = $_POST['irna_id1'];
$tanggal = $_POST['tanggal'];
$jam = $_POST['jam'];
$menit = $_POST['menit'];
if(isset($_POST['insidentil'])) {
	$insidentil = '1';
} else { 
	$insidentil = '';
}
$nama_obat = $_POST['nama_obat'];
$dosis = $_POST['dosis'];
$pegawai_id = $_POST['pegawai_id'];

	$sql_cek_no_ranap = 'SELECT NO_RAWAT FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
	$get_cek_no_ranap = mysql_query($sql_cek_no_ranap) or die(mysql_error("oke1"));
	$dat_cek_no_ranap = mysql_fetch_assoc($get_cek_no_ranap);

	
		$connect_3= mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error("oke2"));
		mysql_select_db($database_3, $connect_3) or die(mysql_error("oke"));
		
		$persediaan = explode('--',$nama_obat);
		
			$persediaan_id = $persediaan[0]; 
			$sql_persediaan = 'SELECT m_persediaan_group.PERSEDIAAN_GROUP,m_persediaan_farmasi.SATUAN,
							m_persediaan_farmasi.HARGA_BELI,m_persediaan_farmasi.HARGA_JUAL,
							m_persediaan_farmasi.NAMA_PERSEDIAAN
							FROM m_persediaan_farmasi
							INNER JOIN m_persediaan_group ON (m_persediaan_farmasi.PERSEDIAAN_GROUP_ID = m_persediaan_group.PERSEDIAAN_GROUP_ID)
							WHERE m_persediaan_farmasi.PERSEDIAAN_ID = "' . $persediaan_id . '"';
			$get_persediaan = mysql_query($sql_persediaan) or die(mysql_error("oke3"));
			$dat_persediaan = mysql_fetch_assoc($get_persediaan);
			$nama_persediaan = $dat_persediaan['NAMA_PERSEDIAAN']; 
			$jenis_persediaan = $dat_persediaan['PERSEDIAAN_GROUP'];
			$satuan = $dat_persediaan['SATUAN'];
			$harga_beli = $dat_persediaan['HARGA_BELI'];
			$harga_jual = $dat_persediaan['HARGA_JUAL'];
		
			$connect= mysql_connect($hostname, $username, $password) or die(mysql_error("oke4"));
			mysql_select_db($database, $connect) or die(mysql_error("oke5"));			
		
			mysql_query('UPDATE t_irna_pemberian_obat SET NAMA_PERSEDIAAN="'.$nama_persediaan.'",PERSEDIAAN_ID="'.$persediaan_id.'",JUMLAH_KELUAR="'.$dosis.'",SATUAN="'.$satuan.'",HARGA_BELI="'.$harga_beli.'",HARGA_JUAL="'.$harga_jual.'",PEGAWAI_ID="'.$pegawai_id.'",INSIDENTIL="'.$insidentil.'" WHERE PEMBERIAN_OBAT_ID="'.$irna_id1.'"') or die(mysql_error());
		 
	

?>
 <script language="JavaScript" >
		setTimeout(opener.location.reload(), 3000);
</script>
