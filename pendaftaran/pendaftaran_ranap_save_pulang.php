<?php
$pasien_pulang_id = $_POST['pasien_pulang_id'];
$irna_id = $_POST['irna_id'];
$ket_pasien_pulang = $_POST['ket_pasien_pulang'];
$pasien_keadaan_pulang_id = $_POST['pasien_keadaan_pulang_id'];
$tgl_keluar = $_POST['tgl_keluar'];
$jam_keluar = $_POST['jam_keluar'];
$menit_keluar = $_POST['menit_keluar'];

$user_name = currentUser();

$_err = '';
if (empty($pasien_pulang_id))
    $_err = $_err . 'Cara Pulang Harus Diisi. \n';
if (empty($pasien_keadaan_pulang_id))
    $_err = $_err . 'Keadaan Pulang Harus Diisi. \n';

if (empty($_err)) {
	mysql_query('UPDATE t_irna SET PASIEN_PULANG_ID = "' . $pasien_pulang_id . '", 
				PASIEN_KELUAR = ' . fieldDatetime($tgl_keluar . ' ' . $jam_keluar . ':' . $menit_keluar . ':01') . ',ST_PULANG = "1", 
				KET_PASIEN_PULANG = "' . $ket_pasien_pulang . '",
				KEADAAN_PULANG_ID = "' . $pasien_keadaan_pulang_id . '",
				USER_PENDAFTARAN = "' . $user_name . '"
				WHERE IRNA_ID = "' . $irna_id  . '"') or die(mysql_error());		
    ?>
    <script language="JavaScript" >
        alert('Simpan Data Pasien Pulang Berhasil.');
		window.location = "<?php echo currentUrl(); ?>";
    </script>
    <?php
} else {
    $msg_info = $_err;
}
?>