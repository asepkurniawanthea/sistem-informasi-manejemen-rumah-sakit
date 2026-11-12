<?php
$_err = '';
$operasi_id = $_POST['operasi_id'];
$rawat_id = $_POST['rawat_id'];
$user_name = currentUser();
$jenis_bayar_id = $_POST['jenis_bayar_id'];
$nomr = $_POST['nomr'];
$ruang_id = $_POST['ruang_id'];
$unit_id = $_POST['unit_id'];
$kelas_rawat = $_POST['kelas_rawat'];
$order_operasi = $_POST['order_operasi'];

if (isset($_POST['simpan'])) {
    $qry_tmp = 'SELECT * FROM t_ipenunjang WHERE OPERASI_ID = "' . $operasi_id . '"';
    $get_tmp = mysql_query($qry_tmp);
    $_err = '';
	if (mysql_num_rows($get_tmp) == 0)
        $_err = 'Radiologi Harus Diisi. \n';
		
    $sql_cek_no_operasi = 'SELECT NO_OPERASI FROM t_operasi WHERE OPERASI_ID = "' . $operasi_id . '"';
	$get_cek_no_operasi = mysql_query($sql_cek_no_operasi) or die(mysql_error());
	$dat_cek_no_operasi = mysql_fetch_assoc($get_cek_no_operasi);
	if (empty($dat_cek_no_operasi['NO_OPERASI'])  or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
	if (empty($_err)) {
		$deskripsi = 'Radiologi (Kamar Operasi)';
		$nomor_order = getNomorBulanan('IPENUNJANG');
		$pegawai_id = $_POST['pegawai_id'];
			
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
							WHERE OPERASI_ID = "' . $operasi_id . '" 
							AND t_ipenunjang.JNS_PENUNJANG = "RAD" AND t_ipenunjang.JNS_ORDER = "' . $order_operasi . '"
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
					UNIT_ID = "' . $unit_id . '",RUANG_ID = "' . $ruang_id . '",
					JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",USER_ORDER = "' . $user_name . '"
					WHERE OPERASI_ID = "' . $operasi_id . '" 
					AND t_ipenunjang.JNS_PENUNJANG = "RAD" 
					AND t_ipenunjang.JNS_ORDER = "' . $order_operasi . '"
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
}
?>