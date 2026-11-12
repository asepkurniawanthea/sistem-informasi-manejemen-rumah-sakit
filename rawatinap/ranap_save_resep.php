<?php
$_err = '';
$irna_id = $_POST['irna_id'];
$user_name = currentUser();

if (isset($_POST['simpan'])) {
    $_err = '';
	if(empty($_POST['pegawai_id']))
		$_err .= 'Dokter Pengirim Harus Diisi. \n';	
		
	if (empty($_err)) {
		$nomor = getNomorBulanan('IRNA');
		
		$tgl_resep = 'NOW()';
		$pegawai = $_POST['pegawai_id'];
		$st_resep = 'NULL';
		$sql_temp_resep = 'SELECT DATE_FORMAT(TGL_RESEP_TEMP,"%Y-%m-%d %H:%i:%s") AS TGL_RESEP_TEMP,
						PEGAWAI_ID_TEMP,NO_RESEP_TEMP,ST_RESEP_TEMP
						FROM t_irna_resep 
						WHERE IRNA_ID = "' . $irna_id . '"
						AND NO_RESEP IS NULL AND NO_RESEP_TEMP IS NOT NULL';
		$get_temp_resep = mysql_query($sql_temp_resep) or die(mysql_error());
		if(mysql_num_rows($get_temp_resep) > 0){
			$dat_temp_resep = mysql_fetch_assoc($get_temp_resep);
			$tgl_resep = 'STR_TO_DATE("' . $dat_temp_resep['TGL_RESEP_TEMP'] . '","%Y-%m-%d %H:%i:%s")';
			$pegawai = $dat_temp_resep['PEGAWAI_ID_TEMP'];
			$nomor = $dat_temp_resep['NO_RESEP_TEMP'];
			$st_resep = '"' . $dat_temp_resep['ST_RESEP_TEMP'] . '"';
		}
		
		mysql_query('UPDATE t_irna_resep SET NO_RESEP = "' . $nomor . '",
					TGL_RESEP = ' . $tgl_resep . ',	PEGAWAI_ID = "' . $_POST['pegawai_id'] . '",
					ST_RESEP = ' . $st_resep . ',TGL_RESEP_TEMP = NULL,
					PEGAWAI_ID_TEMP = NULL,NO_RESEP_TEMP = NULL,ST_RESEP_TEMP = NULL,
					RUANG_ID = (SELECT RUANG_ID FROM t_irna WHERE IRNA_ID = "' . $irna_id . '")
					WHERE IRNA_ID = "' . $irna_id . '" AND NO_RESEP IS NULL') or die(mysql_error());
		
		mysql_query('UPDATE t_irna SET USER_IRNA = "' . $user_name . '",
				ST_CREATE_ERM_RESEP = NULL	
				WHERE IRNA_ID = "' . $irna_id . '"') or die(mysql_error());	
?>
<script language="JavaScript" >
	alert('Simpan Data Resep Berhasil.');
	window.location = "<?php echo currentUrl(); ?>";
</script>
<?php		
		}else{
			$msg_info = $_err;
		}
}
?>