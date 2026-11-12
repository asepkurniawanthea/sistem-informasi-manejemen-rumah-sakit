<?php
$_err = '';
$penunjang_id = $_POST['penunjang_id'];
$user_name = currentUser();

if (isset($_POST['simpan'])) {		
	if (empty($_err)) {
		$no_bayar = '"' . getNomorHarian('Kasir') . '"';
		$st_bayar = '"Lunas"';
		$deskripsi = 'Penunjang (Kasir)';
		$no_tarif = getNomorHarian('Tarif');
		
		$no_sjp = getNomorHarian('SJP');
		$reg_user = $user_name;
		$tgl_daftar = getNow();
		
		$sql_unit = 'SELECT UNIT_ID FROM t_ipenunjang WHERE PENUNJANG_ID = "' . $penunjang_id . '"';
		$get_unit = mysql_query($sql_unit) or die(mysql_error());
		$dat_unit = mysql_fetch_assoc($get_unit);
		$unit_id = $dat_unit['UNIT_ID'];

		mysql_query('UPDATE t_ipenunjang SET DESKRIPSI = "' . $deskripsi . '"') or die(mysql_error());	
		mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_DAFTAR = "' . $tgl_daftar . '",
							UNIT_PENUNJANG_ID = "' . $unit_id . '",
							ST_BAYAR = ' . $st_bayar . ',NO_TARIF = "' . $no_tarif . '",NO_SJP = "' . $no_sjp . '",
							NO_PEMBAYARAN = ' . $no_bayar . ',
							SHIFT_PENDAFTARAN = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",USER_PENDAFTARAN = "' . $reg_user . '",
							JENIS_BAYAR_ID = "1", TANGGAL_BAYAR = NOW(), USER_KASIR = "' . $reg_user . '",
							SHIFT_KASIR = "' . $_SESSION['SES_SIMRS_SHIFT'] . '"
							WHERE PENUNJANG_ID =  "' . $penunjang_id . '"') or die(mysql_error());			
?>
<script language="JavaScript" >
	alert('Simpan Data Penunjang Berhasil.');
	window.location = "index.php?link=<?php echo md5('pembayarandetailbayarpenunjang'); ?>&idx=<?php echo $penunjang_id; ?>&no=<?php echo $no_tarif; ?>&ord=<?php echo $ord; ?>&jnsp=1";
</script>
<?php		
		}else{
			$msg_info = $_err;
		}
}
?>