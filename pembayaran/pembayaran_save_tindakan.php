<?php
$_err = '';
$irja_id = $_POST['irja_id'];
$user_name = currentUser();
$jenis_bayar_id = $_POST['jenis_bayar_id'];

if (isset($_POST['simpan'])) {
    $qry_tmp = 'SELECT * FROM t_irja_tarif WHERE IRJA_ID = "' . $irja_id . '"';
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
		$no_sjp = getNomorHarian('SJP');
		
		mysql_query('UPDATE t_irja_tarif SET NO_TARIF = "' . $nomor . '", NO_PEMBAYARAN = ' . $no_bayar . ',
					ST_BAYAR = "Lunas",	
					USER_KASIR = "' . $user_name . '",TGL_BAYAR = NOW(),
					SHIFT_ID = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
					JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
					USER_PENDAFTARAN = "' . $user_name . '"
					WHERE IRJA_ID = "' . $irja_id . '" AND NO_TARIF IS NULL
					AND DESKRIPSI = "' . $deskripsi . '"') or die(mysql_error());
$kasir = 'umum'; 
		$link = 'pembayarandetailbayarpoliklinik';
		if(isset($_GET['kasir'])){
			$kasir = $_GET['kasir'];
			if($kasir == 'igd') $link = 'pembayarandetailbayarigd';
			if($kasir == 'kusta') $link = 'pembayarandetailbayarkusta';
		}
?>
<script language="JavaScript" >
	alert('Simpan Data Tindakan Berhasil.');
	window.location = "index.php?link=<?php echo md5($link); ?>&kasir=<?php echo $kasir; ?>&idx=<?php echo $irja_id; ?>";
</script>
<?php		
		}else{
			$msg_info = $_err;
		}
}
?>