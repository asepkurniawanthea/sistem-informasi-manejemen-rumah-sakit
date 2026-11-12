<?php
$irna_id = $_POST['irna_id'];
$alergi = $_POST['alergi'];

$user_name = currentUser();

$_err = '';
if (empty($alergi))
    $_err = $_err . 'Alergi Harus Diisi. \n';

if (empty($_err)) {
		$sql_cek_no_klinik = 'SELECT NO_RAWAT FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
		$get_cek_no_klinik = mysql_query($sql_cek_no_klinik) or die(mysql_error());
		$dat_cek_no_klinik = mysql_fetch_assoc($get_cek_no_klinik);
		if (empty($dat_cek_no_klinik['NO_RAWAT']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {	
			mysql_query('UPDATE t_irna SET ALERGI = "' . $alergi . '",USER_IRJA = "' . $user_name . '"
				WHERE IRNA_ID = "' . $irna_id . '"') or die(mysql_error());
		}
?>	
<script language="JavaScript" >
	alert('Simpan Data Alergi Berhasil.');
	window.location = "<?php echo currentUrl(); ?>";
</script>	
<?php
} else {
    $msg_info = $_err;
}
?>