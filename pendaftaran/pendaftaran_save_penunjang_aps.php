<?php
$_err = '';
$penunjang_id = $_POST['penunjang_id'];
$jenis_bayar_id = $_POST['jenis_bayar_id'];
$user_name = currentUser();

if (isset($_POST['simpan'])) {		
	if (empty($_err)) {
		$deskripsi = 'Penunjang (APS)';
		$no_tarif = getNomorHarian('Tarif');
		
		$no_sjp = getNomorHarian('SJP');
		$reg_user = $user_name;
		$tgl_daftar = getNow();
		
		$no_bayar = 'NULL';
		$st_bayar = 'NULL';
		if(!in_array($jenis_bayar_id,getArrNonJaminan())){
			$no_bayar = '"' . getNomorHarian('Kasir') . '"';
			$st_bayar = '"Lunas"';
		}
		
		$sql_unit = 'SELECT UNIT_ID,NO_ORDER,RAWAT_ID FROM t_ipenunjang WHERE PENUNJANG_ID = "' . $penunjang_id . '"';
		$get_unit = mysql_query($sql_unit) or die(mysql_error());
		$dat_unit = mysql_fetch_assoc($get_unit);
		$unit_id = $dat_unit['UNIT_ID'];
		$xnomor_order = $dat_unit['NO_ORDER'];
		$xrawat_id = $dat_unit['RAWAT_ID'];

		mysql_query('UPDATE t_ipenunjang SET DESKRIPSI = "' . $deskripsi . '"
					WHERE PENUNJANG_ID = "' . $penunjang_id . '"') or die(mysql_error());	
		mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_DAFTAR = "' . $tgl_daftar . '",
				UNIT_PENUNJANG_ID = "' . $unit_id . '",NO_TARIF = "' . $no_tarif . '",
				NO_SJP = "' . $no_sjp . '",SHIFT_PENDAFTARAN = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
				USER_PENDAFTARAN = "' . $reg_user . '",
				JENIS_BAYAR_ID = (SELECT JENIS_BAYAR_ID FROM t_ipenunjang WHERE PENUNJANG_ID = "' . $penunjang_id . '"),
				ST_PRINT = "1",ST_BAYAR = ' . $st_bayar . ',NO_PEMBAYARAN = ' . $no_bayar . '
				WHERE PENUNJANG_ID =  "' . $penunjang_id . '"') or die(mysql_error());	
		if($unit_id == '45'){
			include('lis/simrs2lis.php');
			lis_create_order($penunjang_id,$xnomor_order,'APS');
		}						
?>
<script language="JavaScript" >
	alert('Simpan Data Penunjang Berhasil.');
	window.open('http://localhost/nsimrs_print/print_pembayaran_karcis_penunjang_aps.php?idx=<?php echo $penunjang_id; ?>&no=<?php echo $no_tarif; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
	window.location = "index.php?link=<?php echo md5('pendaftaranviewaps'); ?>&idx=<?php echo $penunjang_id; ?>&no=<?php echo $no_tarif; ?>&ord=<?php echo $ord; ?>&jnsp=1";
</script>
<?php		
		}else{
			$msg_info = $_err;
		}
}
?>