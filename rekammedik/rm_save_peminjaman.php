<?php
$peminjaman_buku_id = $_POST['peminjaman_buku_id'];
$nomr = $_POST['nomr'];
$nama_peminjam = $_POST['nama_peminjam'];
$nik = $_POST['nik'];
$no_telepon = $_POST['no_telepon'];
$instansi = $_POST['instansi'];
$tgl_pinjam = $_POST['tgl_pinjam'];
$ket_pinjam = trim($_POST['ket_pinjam']);
$nama_user = currentUser();

$_err = '';
if (empty($nama_peminjam))
       $_err = $_err . 'Nama Peminjam Harus Diisi. \n';
if (empty($nik))
       $_err = $_err . 'NIK Harus Diisi. \n';
if (empty($no_telepon))
       $_err = $_err . 'Nomor Telepon Harus Diisi. \n';
if (empty($instansi))
       $_err = $_err . 'Instansi Harus Diisi. \n';
if (empty($tgl_pinjam))
    $_err = $_err . 'Tanggal Peminjaman Harus Diisi. \n';
if (empty($ket_pinjam))
    $_err = $_err . 'Ket. Peminjaman Harus Diisi. \n';

if (empty($_err)) {
        mysql_query('INSERT INTO t_rm_peminjaman_buku (NOMR,NAMA_PEMINJAM,NIK,NO_TELEPON,INSTANSI,TGL_PINJAM,KET_PINJAM,USER_RM) 
					VALUES ("' . $nomr . '","' . $nama_peminjam . '","' . $nik . '","' . $no_telepon . '","' . $instansi . '",
					CONCAT(' . fieldDate($tgl_pinjam) . '," ",CURTIME()),"' . $ket_pinjam . '","' . $nama_user . '")') or die(mysql_error());
}
if (!empty($_err)) {
    $msg_info = $_err;
} else {
    ?>
    <script language="JavaScript" >
		alert('Simpan Data Peminjaman RM Berhasil.');
        window.location = "index.php?link=<?php echo md5('rmpeminjaman'); ?>";
    </script>
    <?php
}
?>