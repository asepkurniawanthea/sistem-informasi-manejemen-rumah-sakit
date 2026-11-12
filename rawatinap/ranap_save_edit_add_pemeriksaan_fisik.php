<?php
$irna_id = $_POST['irna_id'];
$irna_pemeriksaan_id = $_POST['irna_pemeriksaan_id'];
$tekanan_darah_a = $_POST['tekanan_darah_a'];
$tekanan_darah_b = $_POST['tekanan_darah_b'];
$frekuensi_nafas = $_POST['frekuensi_nafas'];
$suhu_tubuh = $_POST['suhu_tubuh'];
$frekuensi_nadi = $_POST['frekuensi_nadi'];
$berat_badan = $_POST['berat_badan'];
$tinggi_badan = $_POST['tinggi_badan'];
$tanggal = $_POST['tanggal'] . ' ' . $_POST['jam'] . ':' . $_POST['menit'] . ':01';
$pegawai_id = $_POST['pegawai_id'];

$sql_cek_no_ranap = 'SELECT NO_RAWAT FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
$get_cek_no_ranap = mysql_query($sql_cek_no_ranap) or die(mysql_error());
$dat_cek_no_ranap = mysql_fetch_assoc($get_cek_no_ranap);

if (empty($dat_cek_no_ranap['NO_RAWAT']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {		       
	mysql_query('UPDATE t_irna_pemeriksaan_fisik SET TANGGAL_PERIKSA = ' . fieldDatetime($tanggal) . ',
					FREKUENSI_NADI="'.$frekuensi_nadi.'",SUHU="'.$suhu_tubuh.'",PERNAFASAN="'.$frekuensi_nafas.'",TEKANAN_DARAH_A="'.$tekanan_darah_a.'",
					TEKANAN_DARAH_B="'.$tekanan_darah_b.'",BERAT_BADAN="'.$berat_badan.'",TINGGI_BADAN="'.$tinggi_badan.'",PEGAWAI_ID="'.$pegawai_id.'" WHERE IRNA_PEMERIKSAAN_FISIK_ID="'.$irna_pemeriksaan_id.'"') or die(mysql_error());
}

?>
 <script language="JavaScript" >
		setTimeout(opener.location.reload(), 3000);
		window.close();
</script>
