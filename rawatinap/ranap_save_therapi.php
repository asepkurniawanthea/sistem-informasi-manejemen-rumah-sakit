<?php
$irna_id = $_POST['irna_id'];
$therapi = $_POST['therapi'];
$monitoring = $_POST['monitoring'];
$evaluasi = $_POST['evaluasi'];
$user_name = currentUser();

$_err = '';
if (empty($therapi))
    $_err = $_err . 'Therapi Harus Diisi. \n';
if (empty($monitoring))
    $_err = $_err . 'Monitoring Fisik Harus Diisi. \n';
if (empty($evaluasi))
    $_err = $_err . 'Evaluasi Penunjang Harus Diisi. \n';

if (empty($_err)) {
		$sql_cek_no_ranap = 'SELECT NO_RAWAT FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
		$get_cek_no_ranap = mysql_query($sql_cek_no_ranap) or die(mysql_error());
		$dat_cek_no_ranap = mysql_fetch_assoc($get_cek_no_ranap);
		if (empty($dat_cek_no_ranap['NO_RAWAT']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {	
			mysql_query('UPDATE t_irna SET THERAPI = "' . $therapi . '", MONITORING = "' . $monitoring . '",
				EVALUASI = "' . $evaluasi . '",USER_IRNA = "' . $user_name . '"
				WHERE IRNA_ID = "' . $irna_id . '"') or die(mysql_error());
		}
?>	
<script language="JavaScript" >
	alert('Simpan Data Therapi Berhasil.');
	window.location = "<?php echo currentUrl(); ?>";
</script>	
<?php
} else {
    $msg_info = $_err;
}
?>