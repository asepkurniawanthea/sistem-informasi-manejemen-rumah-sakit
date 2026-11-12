<?php
$peminjaman_buku_id = $_POST['peminjaman_buku_id'];
$tgl_kembali = $_POST['tgl_kembali'];
$ket_kembali = trim($_POST['ket_kembali']);
$nama_user = currentUser();

$_err = '';
if (empty($tgl_kembali))
    $_err = $_err . 'Tanggal Pengembalian Harus Diisi. \n';
if (empty($ket_kembali))
    $_err = $_err . 'Ket. Pengembalian Harus Diisi. \n';

if (empty($_err)) {
        mysql_query('UPDATE t_rm_peminjaman_buku
					SET TGL_KEMBALI = CONCAT(' . fieldDate($tgl_kembali) . '," ",CURTIME()),
					KET_KEMBALI = "' . $ket_kembali . '",
					USER_RM = "' . $nama_user . '"
					WHERE PEMINJAMAN_RM_ID = "' . $peminjaman_buku_id . '"') or die(mysql_error());
}
if (!empty($_err)) {
    $msg_info = $_err;
} else {
    ?>
    <script language="JavaScript" >
		alert('Simpan Data Pengembalian RM Berhasil.');
        window.location = "index.php?link=<?php echo md5('rmpeminjaman'); ?>";
    </script>
    <?php
}
?>