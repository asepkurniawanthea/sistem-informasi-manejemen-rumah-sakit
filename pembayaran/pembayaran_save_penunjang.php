<?php
$_err = '';
$penunjang_id = $_POST['penunjang_id'];
$user_name = currentUser();
$jenis_bayar_id = $_POST['jenis_bayar_id'];
$nomr = $_POST['nomr'];
$unit_id = $_POST['unit_id'];
$ruang_id = $_POST['ruang_id'];
$kelas_rawat = $_POST['kelas_rawat'];
$ord = $_POST['ord'];
$kasir = $_POST['kasir'];
$pegawai_id = $_POST['pegawai_id'];

if (isset($_POST['simpan'])) {
    $qry_tmp = 'SELECT * FROM t_ipenunjang WHERE RAWAT_ID = "' . $penunjang_id . '"';
    $get_tmp = mysql_query($qry_tmp);
    $_err = '';
	if (mysql_num_rows($get_tmp) == 0)
        $_err = 'Penunjang Harus Diisi. \n';
		
	if (empty($_err)) {
			$nomor_order = getNomorBulanan('IPENUNJANG');
			$no_bayar = 'NULL';
			$st_bayar = 'NULL';
			if($jenis_bayar_id <> '1'){
				$no_bayar = '"' . getNomorHarian('Kasir') . '"';
				$st_bayar = '"Lunas"';
			}
			$nomor = getNomorHarian('Tarif');
			$no_sjp = getNomorHarian('SJP');
		
			$reg_user = $user_name;
			$tgl_daftar = getNow();
			
			$sql_penj_id = 'SELECT PENUNJANG_ID FROM t_ipenunjang
							WHERE RAWAT_ID = "' . $penunjang_id . '" 
							AND t_ipenunjang.JNS_PENUNJANG = "PNJ" AND t_ipenunjang.JNS_ORDER = "' . strtoupper($ord) . '"
							AND NO_ORDER IS NULL';
			$get_penj_id = mysql_query($sql_penj_id) or die(mysql_error());
			while($dat_penj_id = mysql_fetch_array($get_penj_id)){
				$penj_id = $dat_penj_id['PENUNJANG_ID']; 
				mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_DAFTAR = "' . $tgl_daftar . '",
							ST_BAYAR = ' . $st_bayar . ' ,NO_TARIF = "' . $nomor . '",NO_SJP = "' . $no_sjp . '",
							NO_PEMBAYARAN = ' . $no_bayar . ',
							USER_PENDAFTARAN = "' . $reg_user . '",
							USER_KASIR = "' . $user_name . '",TANGGAL_BAYAR = NOW(),
							SHIFT_KASIR = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
							JENIS_BAYAR_ID = "' . $jenis_bayar_id . '"
							WHERE PENUNJANG_ID =  "' . $penj_id . '"') or die(mysql_error());
			}	
			
			mysql_query('UPDATE t_ipenunjang SET NO_ORDER = "' . $nomor_order . '", 
					DESKRIPSI = "Penunjang (Kasir)",PEGAWAI_ID = "' . $pegawai_id . '",
					NOMR = "' . $nomr . '",TANGGAL_ORDER = NOW(),
					UNIT_ID = "' . $unit_id . '",JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
					RUANG_ID = "' . $ruang_id . '",
					KELAS_RAWAT = "' . $kelas_rawat . '",
					USER_ORDER = "' . $user_name . '"
					WHERE RAWAT_ID = "' . $penunjang_id . '" 
					AND t_ipenunjang.JNS_PENUNJANG = "PNJ" AND t_ipenunjang.JNS_ORDER = "' . strtoupper($ord) . '"
					AND NO_ORDER IS NULL') or die(mysql_error());
		
?>
<script language="JavaScript" >
	alert('Simpan Data Penunjang Berhasil.');
	<?php if($ord == 'aps'){ ?>
	//window.location = "index.php?link=<?php echo md5('pembayarandetailbayarpenunjang'); ?>&idx=<?php echo $penunjang_id; ?>&ord=<?php echo $ord; ?>&opt=<?php echo $opt; ?>";
	<?php }else if($ord == 'irj'){ 
		if($kasir == 'umum'){ ?>	
			window.location = "index.php?link=<?php echo md5('pembayarandetailbayarpoliklinik'); ?>&idx=<?php echo $penunjang_id; ?>&ord=<?php echo $ord; ?>&kasir=<?php echo $kasir; ?>";
		<?php }else if($kasir == 'kusta'){ ?>
			window.location = "index.php?link=<?php echo md5('pembayarandetailbayarkusta'); ?>&idx=<?php echo $penunjang_id; ?>&ord=<?php echo $ord; ?>&kasir=<?php echo $kasir; ?>";
		<?php }else if($kasir == 'igd'){ ?>
			window.location = "index.php?link=<?php echo md5('pembayarandetailbayarigd'); ?>&idx=<?php echo $penunjang_id; ?>&ord=<?php echo $ord; ?>&kasir=<?php echo $kasir; ?>";
		<?php } }else{ ?>
	window.location = "index.php?link=<?php echo md5('pembayarandetailbayarrawatinap'); ?>&idx=<?php echo $penunjang_id; ?>";
	<?php } ?>
</script>
<?php		
		}else{
			$msg_info = $_err;
		}
}
?>