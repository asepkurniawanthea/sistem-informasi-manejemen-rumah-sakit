<?php
$irna_id = $_POST['irna_id'];
$pegawai_id = $_POST['pegawai_id'];
$pegawai_rawat_id = $_POST['pegawai_rawat_id'];
$pegawai_rawat_id_2 = $_POST['pegawai_rawat_id_2'];
$pegawai_rawat_id_3 = $_POST['pegawai_rawat_id_3'];
$pasien_masuk = $_POST['pasien_masuk'];
$ruang_id = $_POST['ruang_id'];
$tmp_tidur = $_POST['tmp_tidur'];
$log_pindah_id = $_POST['log_pindah_id'];
$user_name = currentUser();

$_err = '';
if (empty($pegawai_id))
    $_err = $_err . 'Dokter Pelaksana Harus Diisi. \n';
if (empty($ruang_id))
    $_err = $_err . 'Ruang Rawat Harus Diisi. \n';
//if (empty($tmp_tidur))
    //$_err = $_err . 'Nomor Tempat Tidur Harus Diisi. \n';

if (empty($_err)) {
			if ($_SESSION['SES_SIMRS_ADMIN'] == '1'){
				mysql_query('UPDATE t_irna SET PEGAWAI_ID = "' . $pegawai_id . '",
							RUANG_ID = "' . $ruang_id . '",NO_TMP_TIDUR = "' . $tmp_tidur . '",
							PEGAWAI_RAWAT_ID = "' . $pegawai_rawat_id . '",
							PEGAWAI_RAWAT_ID_2 = "' . $pegawai_rawat_id_2 . '",
							PEGAWAI_RAWAT_ID_3 = "' . $pegawai_rawat_id_3 . '",
							USER_IRNA_MASUK = "' . $user_name . '"
							WHERE IRNA_ID = "' . $_POST['irna_id'] . '"') or die(mysql_error());
				
				$sql_log = 'SELECT IRNA_LOG_ID FROM t_irna_log
							WHERE IRNA_ID = "' . $_POST['irna_id'] . '"
							AND TANGGAL_MASUK IS NOT NULL
							AND JNS_UPDATE = "R"
							ORDER BY IRNA_LOG_ID DESC LIMIT 1';
				$get_log = mysql_query($sql_log) or die(mysql_error());			
				$dat_log = mysql_fetch_assoc($get_log);	
				mysql_query('UPDATE t_irna_log
								SET RUANG_ID_BARU = "' . $ruang_id . '",
								PEGAWAI_ID = "' . $pegawai_id . '",
								PEGAWAI_RAWAT_ID = "' . $pegawai_rawat_id . '",
								PEGAWAI_RAWAT_ID_2 = "' . $pegawai_rawat_id_2 . '",
								PEGAWAI_RAWAT_ID_3 = "' . $pegawai_rawat_id_3 . '"
								WHERE IRNA_LOG_ID = "' . $dat_log['IRNA_LOG_ID'] . '"') or die(mysql_error());
			}		
?>
       <script language="JavaScript" >
            alert('Simpan Pasien Masuk Berhasil.');
			window.location = "index.php?link=<?php echo md5('ranappasienperiksa'); ?>";
       </script>
<?php
} else {
    $msg_info = $_err;
}
?>