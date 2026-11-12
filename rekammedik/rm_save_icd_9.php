<?php
$icd_code = $_POST['icd_code'];
$deskripsi = $_POST['deskripsi'];
$nama_user = currentUser();

$_err = '';
if (empty($deskripsi))
    $_err = $_err . 'Deskripsi Harus Diisi. \n';

if (!empty($_err)) {
    $msg_info = 'Isian ICD Belum Lengkap.';
} else {
    mysql_query('UPDATE m_icd_9cm
				SET DESKRIPSI = "' . $deskripsi . '",
				USER_RM = "' . $nama_user . '"
				WHERE ICD_CODE = "' . $icd_code . '"') or die(mysql_error());
    ?>
    <script language="JavaScript" >
        alert('Data Perubahan ICD Berhasil Disimpan.');
		window.location = "index.php?link=<?php echo '33b808bd25bf819d5bc4a8dc1584e724'; ?>";
    </script>
    <?php
}
?>