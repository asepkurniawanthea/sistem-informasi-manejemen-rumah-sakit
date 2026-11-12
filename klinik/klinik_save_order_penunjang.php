<?php
$_err = '';
$irja_id = $_POST['irja_id'];
$unit_id = $_SESSION['SES_SIMRS_UNIT_ID'];
$user_name = currentUser();
$jenis_bayar_id = $_POST['jenis_bayar_id'];
$unit_penunjang_id = $_POST['penunjang_unit_id'];
$nomr = $_POST['nomr'];

$sql_jenis_bayar = 'SELECT JENIS_BAYAR_ID FROM t_irja WHERE IRJA_ID = "' . $irja_id . '"';
$get_jenis_bayar = mysql_query($sql_jenis_bayar) or die(mysql_error());
$dat_jenis_bayar = mysql_fetch_assoc($get_jenis_bayar);
$jenis_bayar_id = $dat_jenis_bayar['JENIS_BAYAR_ID'];

if (isset($_POST['order'])) {
    
	$_err = '';
	if (empty($unit_penunjang_id)) 
        $_err = 'Penunjang Tujuan Harus Diisi. \n';
	if(currentModul() == 'igd' and empty($_POST['pegawai_id']))
		$_err .= 'Dokter Pengirim Harus Diisi. \n';	
	
	if (empty($_err)) {
		$deskripsi = 'Penunjang (Poliklinik)';
		if (currentModul() == 'igd') $deskripsi = 'Penunjang (IGD)';
		$nomor_order = getNomorBulanan('IPENUNJANG');
		$pegawai_id = $_POST['pegawai_id'];
			
		$no_bayar = 'NULL';
		$st_bayar = 'NULL';
		if($jenis_bayar_id <> '1'){
			$no_bayar = '"' . getNomorHarian('Kasir') . '"';
			$st_bayar = '"Lunas"';
		}
		$nomor = getNomorHarian('Tarif');
		$no_sjp = getNomorHarian('SJP');
		
		$penunjang_id = '';
		$reg_user = $user_name;
		$tgl_daftar = getNow();
			
		mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID,NO_ORDER,DESKRIPSI,PEGAWAI_ID,
					NOMR,TANGGAL_ORDER,UNIT_ID,USER_ORDER,JENIS_BAYAR_ID) VALUES(
					"PNJ","IRJ","' . $irja_id . '","' . $nomor_order . '","' . $deskripsi . '",
					"' . $pegawai_id . '","' . $nomr . '",NOW(),"' . $unit_id . '",
					"' . $user_name . '","' . $jenis_bayar_id . '")') or die(mysql_error());
								
			$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "PNJ" AND t_ipenunjang.JNS_ORDER = "IRJ"
									AND t_ipenunjang.RAWAT_ID = "' . $irja_id . '" AND t_ipenunjang.NO_ORDER = "' . $nomor_order . '"
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
			$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
			$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
			$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];
			
			mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI,TANGGAL_DAFTAR,UNIT_PENUNJANG_ID,
									JENIS_BAYAR_ID,ST_BAYAR,NO_TARIF,NO_SJP,NO_PEMBAYARAN,USER_PENDAFTARAN) 
									VALUES("' . $penunjang_id . '","0",0,NOW(),"' . $unit_penunjang_id . '","' . $jenis_bayar_id . '",
									' . $st_bayar . ',"' . $nomor . '","' . $no_sjp . '",' . $no_bayar . ',"' . $reg_user . '")') or die(mysql_error());
			
			mysql_query('UPDATE t_irja SET USER_IRJA = "' . $user_name . '" 
					WHERE IRJA_ID = "' . $_GET['idx'] . '"') or die(mysql_error());		
?>
<script language="JavaScript" >
	alert('Simpan Data Order Penunjang Berhasil.');
	window.location = "<?php echo currentUrl(); ?>";
</script>
<?php		
		}else{
			$msg_info = $_err;
		}
}
?>