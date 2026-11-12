<?php
$irna_id = $_POST['irna_id'];
$irna_keluar_masuk_id = $_POST['irna_keluar_masuk_id'];
$tanggal = $_POST['tanggal'];
$jam = $_POST['jam'];
$menit = $_POST['menit'];
$jenis_keluar_masuk = $_POST['jenis_keluar_masuk'];
$catatan = $_POST['catatan'];
$pegawai_id = $_POST['pegawai_id'];


$sql_cek_no_ranap = 'SELECT NO_RAWAT FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
$get_cek_no_ranap = mysql_query($sql_cek_no_ranap) or die(mysql_error());
$dat_cek_no_ranap = mysql_fetch_assoc($get_cek_no_ranap);

if (empty($dat_cek_no_ranap['NO_RAWAT']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {		       
		mysql_query('UPDATE t_irna_catatan_keluar_masuk SET TANGGAL = ' .  fieldDatetime($tanggal . ' ' . $jam . ':' . $menit . ':01') . ',
					JENIS_KELUAR_MASUK="'.$jenis_keluar_masuk.'",CATATAN="'.$catatan.'",PEGAWAI_ID="'.$pegawai_id.'" WHERE KELUAR_MASUK_ID="'.$irna_keluar_masuk_id.'"') or die(mysql_error());
}	 
?>
 <script language="JavaScript" >
		setTimeout(opener.location.reload(), 3000);
		window.close();
</script>
