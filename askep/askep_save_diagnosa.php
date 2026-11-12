<?php
$_err = '';
$irna_id = $_POST['irna_id'];
$user_name = currentUser();

if (isset($_POST['simpan'])) {
   
    $sql_cek_no_rawat = 'SELECT ST_ASKEP FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
	$get_cek_no_rawat = mysql_query($sql_cek_no_rawat) or die(mysql_error());
	$dat_cek_no_rawat = mysql_fetch_assoc($get_cek_no_rawat);
	if (empty($dat_cek_no_rawat['ST_ASKEP'])  or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
	if (empty($_err)) {
		$nomor = getNomorBulanan('ASKEP');
		mysql_query('UPDATE t_irna_askep_diagnosa
				SET TGL_DIAGNOSA = NOW(),
				USER_RANAP = "' . $username . '",
				NO_ASKEP = "' . $nomor . '"
				WHERE IRNA_ID = "' . $irna_id . '" AND NO_ASKEP IS NULL') or die(mysql_error());
?>
<script language="JavaScript" >
	alert('Simpan Data Diagnosa Keperawatan Berhasil.');
	window.location = "<?php echo currentUrl(); ?>";
</script>
<?php		
		}else{
			$msg_info = $_err;
		}
	}
}
?>