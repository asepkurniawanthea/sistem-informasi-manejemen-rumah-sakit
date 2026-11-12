<?php
$_err = '';
$operasi_id = $_POST['operasi_id'];
$user_name = currentUser();
$jenis_bayar_id = $_POST['jenis_bayar_id'];
$pegawai_id = $_POST['pegawai_id'];
$kelas_rawat = $_POST['kelas_rawat'];
$kelas_jaminan = $_POST['kelas_jaminan'];
$tanggal = $_POST['tanggal'] . ' ' . $_POST['jam'] . ':' . $_POST['menit'];


if (isset($_POST['simpan'])) {
    $qry_tmp = 'SELECT * FROM t_operasi_tarif WHERE OPERASI_ID = "' . $operasi_id . '"';
    $get_tmp = mysql_query($qry_tmp);
    $_err = '';
	if (mysql_num_rows($get_tmp) == 0)
        $_err = 'Tindakan Harus Diisi. \n';
		
    $sql_cek_no_ranap = 'SELECT NO_OPERASI FROM t_operasi WHERE OPERASI_ID = "' . $operasi_id . '"';
	$get_cek_no_ranap = mysql_query($sql_cek_no_ranap) or die(mysql_error());
	$dat_cek_no_ranap = mysql_fetch_assoc($get_cek_no_ranap);
	if (empty($dat_cek_no_ranap['NO_OPERASI'])  or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
	if (empty($_err)) {
		$no_bayar = 'NULL';
		$st_bayar = 'NULL';
		if($jenis_bayar_id <> '1' and $jenis_bayar_id != '18'){
			$no_bayar = '"' . getNomorHarian('Kasir') . '"';
			$st_bayar = '"Lunas"';
		}
		$deskripsi = 'Tindakan (Kamar Operasi)';
		$nomor = getNomorHarian('Tarif');	
		mysql_query('UPDATE t_operasi_tarif SET NO_TARIF = "' . $nomor . '", NO_PEMBAYARAN = ' . $no_bayar . ',
					PEGAWAI_PELAKSANA_ID = "' . $pegawai_id . '",
					TGL_TARIF = ' . fieldDatetime($tanggal) . ',
					ST_BAYAR = ' . $st_bayar . ',
					KELAS_JAMINAN = "' . $kelas_jaminan . '",
					KELAS_RAWAT = "' . $kelas_rawat . '",
					JENIS_BAYAR_ID = "' . $jenis_bayar_id . '"
					WHERE OPERASI_ID = "' . $operasi_id . '" AND NO_TARIF IS NULL
					AND DESKRIPSI = "' . $deskripsi . '"') or die(mysql_error());
		mysql_query('UPDATE t_operasi SET USER_OPERASI = "' . $user_name . '" WHERE OPERASI_ID = "' . $operasi_id . '"') or die(mysql_error());
?>
<script language="JavaScript" >
	alert('Simpan Data Tindakan Operasi Berhasil.');
	window.location = "<?php echo currentUrl(); ?>";
</script>
<?php		
		}else{
			$msg_info = $_err;
		}
	}
}
?>