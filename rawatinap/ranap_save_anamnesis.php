<?php
$irna_id = $_POST['irna_id'];
$anamnesis = $_POST['anamnesis'];
$pemeriksaan_fisik = $_POST['pemeriksaan_fisik'];
$pemeriksaan_penunjang = $_POST['pemeriksaan_penunjang'];
$alasan_dirawat = $_POST['alasan_dirawat'];
$terapi = $_POST['terapi'];
$hasil_konsul = $_POST['hasil_konsul'];
$diet = $_POST['diet'];
$intruksi = $_POST['intruksi'];
$user_name = currentUser();

$_err = '';
if (empty($_err)) {
		$sql_cek_no_ranap = 'SELECT NO_RAWAT FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
		$get_cek_no_ranap = mysql_query($sql_cek_no_ranap) or die(mysql_error());
		$dat_cek_no_ranap = mysql_fetch_assoc($get_cek_no_ranap);
		if (empty($dat_cek_no_ranap['NO_RAWAT']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {	
			mysql_query('UPDATE t_irna SET ANAMNESIS = "' . $anamnesis . '", PEMERIKSAAN_FISIK = "' . $pemeriksaan_fisik . '",
				PEMERIKSAAN_PENUNJANG = "' . $pemeriksaan_penunjang . '",ALASAN_DIRAWAT = "' . $alasan_dirawat . '",
				THERAPI = "' . $terapi . '",MONITORING = "' . $hasil_konsul . '",USER_IRNA = "' . $user_name . '",
				DIET = "' . $diet . '",EVALUASI = "' . $intruksi . '"
				WHERE IRNA_ID = "' . $_POST['irna_id'] . '"') or die(mysql_error());
		}	
?>
<script language="JavaScript" >
	alert('Simpan Data Pemeriksaan & Terapi Berhasil.');
	window.location = "<?php echo currentUrl(); ?>";
</script>
<?php		
} else {
    $msg_info = $_err;
	}
?>