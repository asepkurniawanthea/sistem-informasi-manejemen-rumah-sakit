<?php
$_err = '';
$irna_id = $_POST['irna_id'];
$ruang_id = $_POST['ruang_id'];
$kelas_rawat = $_POST['kelas_rawat'];
$user_name = currentUser();
$jenis_bayar_id = $_POST['jenis_bayar_id'];
$nomr = $_POST['nomr'];

$sql_jenis_bayar = 'SELECT JENIS_BAYAR_ID FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
$get_jenis_bayar = mysql_query($sql_jenis_bayar) or die(mysql_error());
$dat_jenis_bayar = mysql_fetch_assoc($get_jenis_bayar);
$jenis_bayar_id = $dat_jenis_bayar['JENIS_BAYAR_ID'];

if (isset($_POST['order'])) {
    $_err = '';
	if(empty($_POST['pegawai_id']))
		$_err .= 'Dokter Pengirim Harus Diisi. \n';	
	
	if (empty($_err)) {
		$deskripsi = 'Bank Darah (Laboratorium)';
		$nomor_order = getNomorBulanan('IPENUNJANG');
		$pegawai_id = $_POST['pegawai_id'];
			
		$no_bayar = 'NULL';
		$st_bayar = 'NULL';
		if(!in_array($jenis_bayar_id,getArrNonJaminan())){
			$no_bayar = '"' . getNomorHarian('Kasir') . '"';
			$st_bayar = '"Lunas"';
		}
		$nomor = getNomorHarian('Tarif');
		$no_sjp = getNomorHarian('SJP');
		
		$penunjang_id = '';
		$reg_user = $user_name;
		$tgl_daftar = getNow();
			
		mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,BANK_DARAH,JNS_ORDER,RAWAT_ID,NO_ORDER,DESKRIPSI,PEGAWAI_ID,
					NOMR,TANGGAL_ORDER,RUANG_ID,KELAS_RAWAT,USER_ORDER,JENIS_BAYAR_ID) VALUES(
					"LAB","1","IRN","' . $irna_id . '","' . $nomor_order . '","' . $deskripsi . '",
					"' . $pegawai_id . '","' . $nomr . '",NOW(),"' . $ruang_id . '","' . $kelas_rawat . '",
					"' . $user_name . '","' . $jenis_bayar_id . '")') or die(mysql_error());
								
		$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
					FROM t_ipenunjang 
					WHERE t_ipenunjang.JNS_PENUNJANG = "LAB" 
					AND t_ipenunjang.JNS_ORDER = "IRN"
					AND t_ipenunjang.BANK_DARAH = "1"
					AND t_ipenunjang.RAWAT_ID = "' . $irna_id . '" 
					AND t_ipenunjang.NO_ORDER = "' . $nomor_order . '"
					ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
		$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
		$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
		$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];
			
		mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI,TANGGAL_DAFTAR,UNIT_PENUNJANG_ID,
			JENIS_BAYAR_ID,ST_BAYAR,NO_TARIF,NO_SJP,NO_PEMBAYARAN,USER_PENDAFTARAN) 
			VALUES("' . $penunjang_id . '","0",0,NOW(),"45","' . $jenis_bayar_id . '",
			' . $st_bayar . ',"' . $nomor . '","' . $no_sjp . '",' . $no_bayar . ',"' . $reg_user . '")') or die(mysql_error());
?>
<script language="JavaScript" >
	alert('Simpan Data Order Bank Darah Berhasil.');
	window.location = "<?php echo currentUrl(); ?>";
</script>
<?php		
		}else{
			$msg_info = $_err;
		}
}
?>