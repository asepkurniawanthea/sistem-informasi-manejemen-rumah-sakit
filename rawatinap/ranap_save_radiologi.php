<?php
$_err = '';
$irna_id = $_POST['irna_id'];
$user_name = currentUser();
$jenis_bayar_id = $_POST['jenis_bayar_id'];
$nomr = $_POST['nomr'];
$ruang_id = $_POST['ruang_id'];
$kelas_rawat = $_POST['kelas_rawat'];

$sql_jenis_bayar = 'SELECT JENIS_BAYAR_ID FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
$get_jenis_bayar = mysql_query($sql_jenis_bayar) or die(mysql_error());
$dat_jenis_bayar = mysql_fetch_assoc($get_jenis_bayar);
$jenis_bayar_id = $dat_jenis_bayar['JENIS_BAYAR_ID'];

if (isset($_POST['simpan'])) {
    $_err = '';
	if(empty($_POST['pegawai_id']))
		$_err .= 'Dokter Pengirim Harus Diisi. \n';	
		
	if (empty($_err)) {
		$deskripsi = 'Radiologi (Ruang Rawat)';
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
			
		$sql_penj_id = 'SELECT PENUNJANG_ID FROM t_ipenunjang
							WHERE RAWAT_ID = "' . $irna_id . '" 
							AND t_ipenunjang.JNS_PENUNJANG = "RAD" AND t_ipenunjang.JNS_ORDER = "IRN"
							AND NO_ORDER IS NULL';
		$get_penj_id = mysql_query($sql_penj_id) or die(mysql_error());
		while($dat_penj_id = mysql_fetch_array($get_penj_id)){
			$penj_id = $dat_penj_id['PENUNJANG_ID']; 
			mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_DAFTAR = "' . $tgl_daftar . '",
							UNIT_PENUNJANG_ID = "17",
							ST_BAYAR = ' . $st_bayar . ',NO_TARIF = "' . $nomor . '",NO_SJP = "' . $no_sjp . '",
							NO_PEMBAYARAN = ' . $no_bayar . ',JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
							USER_PENDAFTARAN = "' . $reg_user . '"
							WHERE PENUNJANG_ID =  "' . $penj_id . '"') or die(mysql_error());
			}	
			
			mysql_query('UPDATE t_ipenunjang SET NO_ORDER = "' . $nomor_order . '", 
					DESKRIPSI = "' . $deskripsi . '",PEGAWAI_ID = "' . $pegawai_id . '",
					NOMR = "' . $nomr . '",TANGGAL_ORDER = NOW(),
					UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '",RUANG_ID = "' . $ruang_id . '",
					JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",USER_ORDER = "' . $user_name . '"
					WHERE RAWAT_ID = "' . $irna_id . '" 
					AND t_ipenunjang.JNS_PENUNJANG = "RAD" AND t_ipenunjang.JNS_ORDER = "IRN"
					AND NO_ORDER IS NULL') or die(mysql_error());
?>
<script language="JavaScript" >
	alert('Simpan Data Order Radiologi Berhasil.');
	window.location = "<?php echo currentUrl(); ?>";
</script>
<?php		
		}else{
			$msg_info = $_err;
		}
}
?>