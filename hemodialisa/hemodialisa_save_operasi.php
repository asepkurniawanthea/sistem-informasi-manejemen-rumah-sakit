<?php
$_err = '';
$operasi_id = $_POST['operasi_id'];
$tgl_rencana = $_POST['tgl_rencana']; 
$dokter_operasi = $_POST['dokter_operasi'];
$dokter_pengirim = $_POST['dokter_pengirim'];
$user_name = currentUser();

if (isset($_POST['simpan'])) {
		
    $sql_cek_no_klinik = 'SELECT NO_KLINIK FROM t_irja WHERE IRJA_ID = "' . $irja_id . '"';
	$get_cek_no_klinik = mysql_query($sql_cek_no_klinik) or die(mysql_error());
	$dat_cek_no_klinik = mysql_fetch_assoc($get_cek_no_klinik);
	if (empty($dat_cek_no_klinik['NO_KLINIK']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
	
	$_err = '';
	if ($st_approve == ''){
		if (empty($tgl_rencana))
			$_err = $_err . 'Tanggal Rencana Operasi Harus Diisi. \n';
		if (empty($dokter_operasi))
			$_err = $_err . 'Dokter Pelaksana Operasi Harus Diisi. \n';	
		if (empty($dokter_pengirim))
			$_err = $_err . 'Dokter Pengirim Harus Diisi. \n';	
		
		if (empty($_err)) {
			if(empty($operasi_id)){
				$nomor_order = getNomorBulanan('IOPERASI');
				mysql_query('INSERT INTO t_operasi(TANGGAL_ORDER,JNS_ORDER,NO_ORDER,RAWAT_ID,TANGGAL_RENCANA_OPERASI,
						PEGAWAI_ID,UNIT_ID,NOMR,USER_ORDER,PEGAWAI_PELAKSANA_ID,
						KELAS_RAWAT,KELAS_JAMINAN,JENIS_BAYAR_ID) VALUES(NOW(),"IRJ","' . $nomor_order . '",
						"' . $irja_id . '",STR_TO_DATE("' . $tgl_rencana . '","%d/%m/%Y"),"' . $dokter_pengirim . '",
						"' . $_SESSION['SES_SIMRS_UNIT_ID'] . '","' . $nomr . '","' . $user_name . '",
						"' . $dokter_operasi . '","3","3",
						(SELECT JENIS_BAYAR_ID FROM t_irja WHERE IRJA_ID = "' . $irja_id . '"))') or die(mysql_error());
			}else{
				mysql_query('UPDATE t_operasi SET TANGGAL_RENCANA_OPERASI = STR_TO_DATE("' . $tgl_rencana . '","%d/%m/%Y"), 
							PEGAWAI_ID = "' . $dokter_pengirim . '", USER_ORDER = "' . $user_name . '",
							PEGAWAI_PELAKSANA_ID = "' . $dokter_operasi . '"
							WHERE OPERASI_ID = "' . $operasi_id . '"') or die(mysql_error());
			}
?>
<script language="JavaScript" >
	alert('Simpan Data Permintaan Operasi Berhasil.');
	window.location = "<?php echo currentUrl(); ?>";
</script>
<?php			
		}else{
			$msg_info = $_err;
		}
	}
}
}
?>