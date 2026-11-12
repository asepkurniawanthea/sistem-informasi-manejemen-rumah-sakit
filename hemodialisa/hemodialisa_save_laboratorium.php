<?php
$_err = '';
$irja_id = $_POST['irja_id'];
$user_name = currentUser();
$jenis_bayar_id = $_POST['jenis_bayar_id'];
$nomr = $_POST['nomr'];

$_err = '';
if (isset($_POST['simpan'])) {
		if(empty($jns_order)){
			//
			$nomor_order = getNomorBulanan('IPENUNJANG');
		
		$no_bayar = 'NULL';
		$st_bayar = 'NULL';
		if($jenis_bayar_id != '1' and $jenis_bayar_id != '18'){
			$no_bayar = '"' . getNomorHarian('Kasir') . '"';
			$st_bayar = '"Lunas"';
		}
		$nomor = getNomorHarian('Tarif');
		$no_sjp = getNomorHarian('SJP');
		
		$penunjang_id = '';
		$reg_user = $user_name;
		$tgl_daftar = getNow();
		
		$sql_penj_id = 'SELECT PENUNJANG_ID FROM t_ipenunjang
					WHERE RAWAT_ID = "' . $irja_id . '" 
					AND t_ipenunjang.JNS_PENUNJANG = "LAB" AND t_ipenunjang.JNS_ORDER = "IRJ"
					AND NO_ORDER IS NULL';
		$get_penj_id = mysql_query($sql_penj_id) or die(mysql_error());
		while($dat_penj_id = mysql_fetch_array($get_penj_id)){
			$penj_id = $dat_penj_id['PENUNJANG_ID']; 
			mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_DAFTAR = "' . $tgl_daftar . '",
					UNIT_PENUNJANG_ID = "45",
					ST_BAYAR = ' . $st_bayar . ',NO_TARIF = "' . $nomor . '",NO_SJP = "' . $no_sjp . '",
					NO_PEMBAYARAN = ' . $no_bayar . ',
					USER_PENDAFTARAN = "' . $reg_user . '",
					JENIS_BAYAR_ID = "' . $jenis_bayar_id . '"
					WHERE PENUNJANG_ID =  "' . $penj_id . '"') or die(mysql_error());
		}	
			
		mysql_query('UPDATE t_ipenunjang SET NO_ORDER = "' . $nomor_order . '", 
					DESKRIPSI = "Laboratorium (Poliklinik)",PEGAWAI_ID = (SELECT PEGAWAI_ID FROM t_irja WHERE IRJA_ID = "' . $irja_id . '"),
					NOMR = "' . $nomr . '",TANGGAL_ORDER = NOW(),
					UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '",JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
					USER_ORDER = "' . $user_name . '"
					WHERE RAWAT_ID = "' . $irja_id . '" 
					AND t_ipenunjang.JNS_PENUNJANG = "LAB" AND t_ipenunjang.JNS_ORDER = "IRJ"
					AND NO_ORDER IS NULL') or die(mysql_error());
			//
			
		include('lis/simrs2lis.php');
		lis_create_order($_GET['idx'],$nomor_order,'IRJ');
		
		mysql_query('UPDATE t_irja SET USER_IRJA = "' . $user_name . '" 
					WHERE IRJA_ID = "' . $_GET['idx'] . '"') or die(mysql_error());		
		}	
	
	if(empty($_err)){
?>
<script language="JavaScript" >
	alert('Simpan Data Order Laboratorium Berhasil.');
	window.location = "<?php echo currentUrl(); ?>";
</script>
<?php		
	}else{
		$msg_info = $_err;
	}
}
?>