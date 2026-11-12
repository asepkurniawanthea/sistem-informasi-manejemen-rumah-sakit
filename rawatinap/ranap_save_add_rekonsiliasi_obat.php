<?php
$irna_id = $_POST['irna_id'];
$nama_obat = $_POST['nama_obat'];
$dosis = $_POST['dosis'];
$frekuensi = $_POST['frekuensi'];
$rute_pemberian = $_POST['rute_pemberian'];
$tanggal_mulai = $_POST['tanggal_mulai'];
$tanggal_stop = $_POST['tanggal_stop'];
if(isset($_POST['selama_perawatan'])) $selama_perawatan = '1';
if(isset($_POST['saat_pulang'])) $saat_pulang = '1';

$sql_cek_no_ranap = 'SELECT NO_RAWAT FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
$get_cek_no_ranap = mysql_query($sql_cek_no_ranap) or die(mysql_error());
$dat_cek_no_ranap = mysql_fetch_assoc($get_cek_no_ranap);

if (empty($dat_cek_no_ranap['NO_RAWAT']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {		       
	mysql_query('INSERT INTO t_irna_rekonsiliasi_obat(IRNA_ID,NAMA_OBAT,DOSIS,
				FREKUENSI,RUTE_PEMBERIAN,TGL_MULAI,TGL_STOP,DILANJUTKAN_SELAMA_PERAWATAN,
				DILANJUTKAN_SAAT_PULANG)
				VALUES("' . $irna_id . '","' . $nama_obat . '","' . $dosis . '","' . $frekuensi . '",
				"' . $rute_pemberian . '",STR_TO_DATE("' . $tanggal_mulai . '","%d/%m/%Y"),STR_TO_DATE("' . $tanggal_stop . '","%d/%m/%Y"),"' . $selama_perawatan . '","' . $saat_pulang . '")') or die(mysql_error());
	$nama_obat = '';
	$dosis = '';
	$frekuensi = '';
	$rute_pemberian = '';
	$tanggal_mulai = '';
	$tanggal_stop = '';
	$selama_perawatan = '';
	$saat_pulang = '';
}
?>
 <script language="JavaScript" >
		setTimeout(opener.location.reload(), 3000);
</script>