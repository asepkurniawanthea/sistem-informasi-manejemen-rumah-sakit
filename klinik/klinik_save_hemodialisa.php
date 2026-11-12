<?php

$_err = '';
$irja_id = $_POST['irja_id'];
$unit_id = $_SESSION['SES_SIMRS_UNIT_ID'];
$user_name = currentUser();
$jenis_bayar_id = $_POST['jenis_bayar_id'];
$pegawai_id = $_POST['pegawai_id'];
$nomr = $_POST['nomr'];

$sql_jenis_bayar = 'SELECT JENIS_BAYAR_ID FROM t_irja WHERE IRJA_ID = "' . $irja_id . '"';
$get_jenis_bayar = mysql_query($sql_jenis_bayar) or die(mysql_error());
$dat_jenis_bayar = mysql_fetch_assoc($get_jenis_bayar);
$jenis_bayar_id = $dat_jenis_bayar['JENIS_BAYAR_ID'];

if (isset($_POST['simpan'])) {
    $sql = 'SELECT t_hemodialisa.HEMODIALISA_ID FROM t_hemodialisa
			WHERE t_hemodialisa.JNS_ORDER = "IRJ" AND t_hemodialisa.RAWAT_ID = "' . $irja_id . '"
			AND t_hemodialisa.PEGAWAI_PERIKSA_ID IS NULL';
	$get = mysql_query($sql) or die(mysql_error());			
	if(mysql_num_rows($get) == 0){
		$nomor_order = getNomorBulanan('IPENUNJANG');
		$no_sjp = getNomorHarian('SJP');
		mysql_query('INSERT INTO t_hemodialisa(TANGGAL_ORDER,JNS_ORDER,NO_ORDER,RAWAT_ID,PEGAWAI_ID,NOMR,USER_ORDER,JENIS_BAYAR_ID,UNIT_ID,NO_SJP)
			VALUES(NOW(),"IRJ","' . $nomor_order . '","' . $irja_id . '","' . $pegawai_id . '","' . $nomr . '","' . $user_name . '",
			"' . $jenis_bayar_id . '","' . $_SESSION['SES_SIMRS_UNIT_ID'] . '","' . $no_sjp . '")') or die(mysql_error());
	}		
	
	mysql_query('UPDATE t_irja SET USER_IRJA = "' . $user_name . '" 
					WHERE IRJA_ID = "' . $_GET['idx'] . '"') or die(mysql_error());	
?>
<script language="JavaScript" >
	alert('Simpan Data Order Hemodialisa Berhasil.');
	window.location = "<?php echo currentUrl(); ?>";
</script>
<?php		
}
?>