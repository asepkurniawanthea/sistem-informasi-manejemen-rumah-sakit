<?php
$irja_id = $_POST['irja_id'];
$alergi = $_POST['alergi'];

$user_name = currentUser();

$_err = '';
if (empty($alergi))
    $_err = $_err . 'Alergi Harus Diisi. \n';

if (empty($_err)) {
		$sql_cek_no_klinik = 'SELECT NO_KLINIK FROM t_irja WHERE IRJA_ID = "' . $irja_id . '"';
		$get_cek_no_klinik = mysql_query($sql_cek_no_klinik) or die(mysql_error());
		$dat_cek_no_klinik = mysql_fetch_assoc($get_cek_no_klinik);
		if (empty($dat_cek_no_klinik['NO_KLINIK']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {	
			mysql_query('UPDATE t_irja SET ALERGI = "' . $alergi . '",USER_IRJA = "' . $user_name . '"
				WHERE IRJA_ID = "' . $irja_id . '"') or die(mysql_error());
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