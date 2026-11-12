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
		
		//perawat penanggungjawab
		
		//end perawat penanggungjawab
		
		//status keperawatan
		$status_keperawatan_id = $_POST['status_keperawatan_id'];
		$keluhan_utama = $_POST['keluhan_utama'];
		
		if(empty($status_keperawatan_id)){
			mysql_query('INSERT INTO t_irna_askep_kajian_status_keperawatan(IRNA_ID,KELUHAN_UTAMA)
						VALUES("' . $irna_id . '","' . $keluhan_utama . '")') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_irna_askep_kajian_status_keperawatan SET KELUHAN_UTAMA = "' . $keluhan_utama . '"
						WHERE STATUS_KEPERAWATAN_ID = "' . $status_keperawatan_id . '"') or die(mysql_error());
		}
		//end status keperawatan
		
		//status kesehatan pasien
		
		//end status kesehatan pasien
?>
<script language="JavaScript" >
	alert('Simpan Data Pengkajian Keperawatan Berhasil.');
	window.location = "<?php echo currentUrl(); ?>";
</script>
<?php		
		}else{
			$msg_info = $_err;
		}
	}
}
?>