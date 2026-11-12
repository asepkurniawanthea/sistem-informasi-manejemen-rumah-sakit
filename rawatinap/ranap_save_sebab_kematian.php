<?php
$irna_id = $_POST['irna_id'];
$user_name = currentUser();
$sebab_kematian = $_POST['sebab_kematian_1'] . '|*|' . $_POST['sebab_kematian_2'] . '|*|' . $_POST['sebab_kematian_3'] . '|*|' . $_POST['sebab_kematian_4'];
$mati_redupaksa = $_POST['mati_redupaksa_1'] . '|*|' . $_POST['mati_redupaksa_2'] . '|*|' . $_POST['mati_redupaksa_3'];
$kelahiran_mati = $_POST['kelahiran_mati_1'] . '|*|' . $_POST['kelahiran_mati_2'];
$persalinan_mati = $_POST['persalinan_mati_1'] . '|*|' . $_POST['persalinan_mati_2'];
$operasi_mati = $_POST['operasi_mati_1'] . '|*|' . $_POST['operasi_mati_2'];

$sql_cek_no_ranap = 'SELECT NO_RAWAT FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
$get_cek_no_ranap = mysql_query($sql_cek_no_ranap) or die(mysql_error());
$dat_cek_no_ranap = mysql_fetch_assoc($get_cek_no_ranap);

if (empty($dat_cek_no_ranap['NO_RAWAT']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {	
	
	mysql_query('UPDATE t_irna SET SEBAB_KEMATIAN = "' . $sebab_kematian . '",
				SEBAB_KEMATIAN_REDUPAKSA = "' . $mati_redupaksa . '",
				SEBAB_KEMATIAN_KELAHIRAN = "' . $kelahiran_mati . '",
				SEBAB_KEMATIAN_PERSALINAN = "' . $persalinan_mati . '",
				SEBAB_KEMATIAN_OPERASI = "' . $operasi_mati . '",USER_IRNA = "' . $user_name . '"
				WHERE IRNA_ID = "' . $_POST['irna_id'] . '"') or die(mysql_error());
}	
?>
<script language="JavaScript" >
	alert('Simpan Data Sebab Kematian Berhasil.');
	window.location = "<?php echo currentUrl(); ?>";
</script>