<?php
$_err = '';
$tgl_rencana = $_POST['tgl_rencana']; 
$dokter_operasi = $_POST['dokter_operasi'];
$dokter_pengirim = $_POST['dokter_pengirim'];
$user_name = currentUser();

	$_err = '';
		if (empty($tgl_rencana))
			$_err = $_err . 'Tanggal Rencana Operasi Harus Diisi. \n';
		if (empty($dokter_operasi))
			$_err = $_err . 'Dokter Pelaksana Operasi Harus Diisi. \n';	
		if (empty($dokter_pengirim))
			$_err = $_err . 'Dokter Pengirim Harus Diisi. \n';	
		
		if (empty($_err)) {
				$nomor_order = getNomorBulanan('IOPERASI');
				mysql_query('INSERT INTO t_operasi(TANGGAL_ORDER,JNS_ORDER,NO_ORDER,RAWAT_ID,TANGGAL_RENCANA_OPERASI,PEGAWAI_ID,
						UNIT_ID,NOMR,USER_ORDER,PEGAWAI_PELAKSANA_ID,RUANG_ID,
						KELAS_RAWAT,KELAS_JAMINAN,JENIS_BAYAR_ID) VALUES(NOW(),"IRN","' . $nomor_order . '",
						"' . $irna_id . '",STR_TO_DATE("' . $tgl_rencana . '","%d/%m/%Y"),"' . $dokter_pengirim . '",
						"50","' . $nomr . '","' . $user_name . '",
						"' . $dokter_operasi . '","' . $ruang_id . '",
						(SELECT KELAS_RAWAT FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"),
						(SELECT KELAS_JAMINAN FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"),
						(SELECT JENIS_BAYAR_ID FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"))') or die(mysql_error());
?>
<script language="JavaScript" >
	alert('Simpan Data Permintaan Operasi Berhasil.');
	window.location = "<?php echo currentUrl(); ?>";
</script>
<?php			
		}else{
			$msg_info = $_err;
		}
?>