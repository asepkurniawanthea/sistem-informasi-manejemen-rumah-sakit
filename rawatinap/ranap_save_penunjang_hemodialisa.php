<?php
$_err = '';
$irna_id = $_POST['irna_id'];
$user_name = currentUser();
$jenis_bayar_id = $_POST['jenis_bayar_id'];
$ruang_id = $_POST['ruang_id'];
$kelas_rawat = $_POST['kelas_rawat'];
$nomr = $_POST['nomr'];

if (isset($_POST['simpan'])) {
    $qry_tmp = 'SELECT * FROM t_ipenunjang WHERE RAWAT_ID = "' . $irna_id . '"';
    $get_tmp = mysql_query($qry_tmp);
    $_err = '';
	if (mysql_num_rows($get_tmp) == 0)
        $_err = 'Penunjang Harus Diisi. \n';
		
    $sql_cek_no_klinik = 'SELECT NO_RAWAT FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
	$get_cek_no_klinik = mysql_query($sql_cek_no_klinik) or die(mysql_error());
	$dat_cek_no_klinik = mysql_fetch_assoc($get_cek_no_klinik);
	if (empty($dat_cek_no_klinik['NO_RAWAT'])  or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
	if (empty($_err)) {
		$deskripsi = 'Penunjang (Rawat Inap)';
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
						AND t_ipenunjang.JNS_PENUNJANG = "HMD" AND t_ipenunjang.JNS_ORDER = "IRN"
						AND NO_ORDER IS NULL';
		$get_penj_id = mysql_query($sql_penj_id) or die(mysql_error());
		while($dat_penj_id = mysql_fetch_array($get_penj_id)){
			$penj_id = $dat_penj_id['PENUNJANG_ID']; 
			mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_DAFTAR = "' . $tgl_daftar . '",
						UNIT_PENUNJANG_ID = "55",
						ST_BAYAR = ' . $st_bayar . ',NO_TARIF = "' . $nomor . '",NO_SJP = "' . $no_sjp . '",
						NO_PEMBAYARAN = ' . $no_bayar . ',
						USER_PENDAFTARAN = "' . $reg_user . '",
						JENIS_BAYAR_ID = "' . $jenis_bayar_id . '"
						WHERE PENUNJANG_ID =  "' . $penj_id . '"') or die(mysql_error());
		}	
			
			mysql_query('UPDATE t_ipenunjang SET NO_ORDER = "' . $nomor_order . '", 
					DESKRIPSI = "' . $deskripsi . '",PEGAWAI_ID = "' . $pegawai_id . '",
					NOMR = "' . $nomr . '",TANGGAL_ORDER = NOW(),
					RUANG_ID = "' . $ruang_id . '",KELAS_RAWAT = "' . $kelas_rawat . '",
					JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
					USER_ORDER = "' . $user_name . '"
					WHERE RAWAT_ID = "' . $irna_id . '" 
					AND t_ipenunjang.JNS_PENUNJANG = "HMD" AND t_ipenunjang.JNS_ORDER = "IRN"
					AND NO_ORDER IS NULL') or die(mysql_error());
?>
<script language="JavaScript" >
	alert('Simpan Data Order Penunjang Hemodialisa Berhasil.');
	window.location = "<?php echo currentUrl(); ?>";
</script>
<?php		
		}else{
			$msg_info = $_err;
		}
	}
}
?>