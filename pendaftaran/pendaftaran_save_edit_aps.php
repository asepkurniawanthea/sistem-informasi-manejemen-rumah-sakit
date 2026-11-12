<?php
$_err = '';
$penunjang_id = $_POST['penunjang_id'];
$user_name = currentUser();

if (isset($_POST['simpan'])) {		
	if (empty($_err)) {
		
		$no_bayar = 'NULL';
		$st_bayar = 'NULL';
		if(!in_array($_POST['jenis_bayar_id'],getArrNonJaminan())){
			$no_bayar = '"' . getNomorHarian('Kasir') . '"';
			$st_bayar = '"Lunas"';
		}
		
		mysql_query('UPDATE t_ipenunjang
					SET TANGGAL_PERMINTAAN = ' . fieldDate($_POST['tgl_permintaan']) . ',
					PENGIRIM = "' . $_POST['dokter_pengirim'] . '",
					INSTANSI_PENGIRIM = "' . $_POST['instansi_pengirim'] . '",
					ALAMAT_INSTANSI_PENGIRIM = "' . $_POST['alamat_instansi_pengirim'] . '",
					NO_TELP_INSTANSI_PENGIRIM = "' . $_POST['telp_instansi_pengirim'] . '",
					DIAGNOSA_PENGIRIM = "' . $_POST['diagnosa'] . '",
					JENIS_BAYAR_ID = "' . $_POST['jenis_bayar_id'] . '"
					WHERE PENUNJANG_ID = "' . $penunjang_id . '"') or die(mysql_error());	
		mysql_query('UPDATE t_ipenunjang_tarif SET SHIFT_PENDAFTARAN = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
					USER_PENDAFTARAN = "' . $user_name . '",
					ST_PRINT = "1",
					JENIS_BAYAR_ID = "' . $_POST['jenis_bayar_id'] . '",
					ST_BAYAR = ' . $st_bayar . ',NO_PEMBAYARAN = ' . $no_bayar . '
					WHERE PENUNJANG_ID =  "' . $penunjang_id . '"') or die(mysql_error());	

		if($_POST['unit_id_ls'] == '45') {
			include('lis/simrs2lis.php');
			lis_cancel_order('P' . $penunjang_id,$_POST['no_order']);
			lis_create_order($penunjang_id,$_POST['no_order'],'APS');
		}	
		
?>
<script language="JavaScript" >
	alert('Simpan Data Penunjang Berhasil.');
	window.open('http://localhost/nsimrs_print/print_pembayaran_karcis_aps_edit.php?idx=<?php echo $penunjang_id; ?>&no=<?php echo $_GET['no']; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
	window.location = "index.php?link=<?php echo md5('pendaftaranlistaps'); ?>";
</script>
<?php		
		}else{
			$msg_info = $_err;
		}
}
?>