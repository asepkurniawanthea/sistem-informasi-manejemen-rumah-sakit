<?php
$irna_id = $_POST['irna_id'];
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
	mysql_query('INSERT INTO t_irna_pemeriksaan_fisik(IRNA_ID,TANGGAL_PERIKSA,FREKUENSI_NADI,SUHU,PERNAFASAN,TEKANAN_DARAH_A,
					TEKANAN_DARAH_B,BERAT_BADAN,TINGGI_BADAN,PEGAWAI_ID)
					VALUES("' . $irna_id . '",' . fieldDatetime($tanggal) . ',"' . $frekuensi_nadi . '",
					"' . $suhu_tubuh . '","' . $frekuensi_nafas . '","' . $tekanan_darah_a . '",
					"' . $tekanan_darah_b . '","' . $berat_badan . '","' . $tinggi_badan . '","' . $pegawai_id . '")') or die(mysql_error());
}

?>
 <script language="JavaScript" >
		setTimeout(opener.location.reload(), 3000);
</script>
