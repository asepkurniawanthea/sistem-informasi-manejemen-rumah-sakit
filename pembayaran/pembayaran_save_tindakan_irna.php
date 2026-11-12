<?php
$_err = '';
$irna_id = $_POST['irna_id'];
$user_name = currentUser();
$jenis_bayar_id = $_POST['jenis_bayar_id'];
$kelas_rawat = $_POST['kelas_rawat'];
$ruang_id = $_POST['ruang_id'];
$pegawai_id = $_POST['pegawai_id'];
$kelas_jaminan = $_POST['kelas_jaminan'];

if (isset($_POST['simpan'])) {
    $qry_tmp = 'SELECT * FROM t_irna_tarif WHERE IRNA_ID = "' . $irna_id . '"';
    $get_tmp = mysql_query($qry_tmp);
    $_err = '';
	if (mysql_num_rows($get_tmp) == 0)
        $_err = 'Tindakan Harus Diisi. \n';
		
	if (empty($_err)) {
		$no_bayar = 'NULL';
		if($jenis_bayar_id <> '1'){
			$no_bayar = '"' . getNomorHarian('Kasir') . '"';
		}
		$deskripsi = 'Tindakan (Kasir)';
		$nomor = getNomorHarian('Tarif');
		
		mysql_query('UPDATE t_irna_tarif SET NO_TARIF = "' . $nomor . '", NO_PEMBAYARAN = ' . $no_bayar . ',
					DESKRIPSI = "' . $deskripsi . '",ST_BAYAR = "Lunas",	
					USER_KASIR = "' . $user_name . '",TGL_BAYAR = NOW(),
					SHIFT_ID = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
					RUANG_ID = "' . $ruang_id . '",
					KELAS_RAWAT = "' . $kelas_rawat . '",
					KELAS_JAMINAN = "' . $kelas_jaminan . '",
					JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
					PEGAWAI_ID = "' . $pegawai_id . '"
					WHERE IRNA_ID = "' . $irna_id . '" AND NO_TARIF IS NULL') or die(mysql_error());

$link = 'pembayarandetailbayarrawatinap';
?>
<script language="JavaScript" >
	alert('Simpan Data Tindakan Berhasil.');
	window.location = "index.php?link=<?php echo md5($link); ?>&idx=<?php echo $irna_id; ?>";
</script>
<?php		
		}else{
			$msg_info = $_err;
		}
}
?>