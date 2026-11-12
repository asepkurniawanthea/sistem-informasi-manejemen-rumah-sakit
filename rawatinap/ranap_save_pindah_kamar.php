<?php
$irna_id = $_POST['irna_id'];
$user_name = currentUser();
$pindah = '';
if(isset($_POST['pindah'])) $pindah = $_POST['pindah'];

if($pindah == '1'){

	$ruang_id_baru = $_POST['ruang_id_baru'];
	$tmp_tidur_baru = $_POST['tmp_tidur'];
	$dokter_pjawab = $_POST['dokter_pjawab'];
	$dokter_prawat = $_POST['dokter_prawat'];
	$dokter_prawat_2 = $_POST['dokter_prawat_2'];
	$dokter_prawat_3 = $_POST['dokter_prawat_3'];
	$keterangan = $_POST['keterangan'];
	$irna_log_id = '';

	$_err = '';
	if (empty($ruang_id_baru))
		$_err = $_err . 'Ruang Rawat Baru Harus Diisi. \n';
	if (empty($keterangan))
		$_err = $_err . 'Keterangan Harus Diisi. \n';

	if (empty($_err)) {
				$sql_cek_no_ranap = 'SELECT NO_RAWAT,NOMR,JENIS_BAYAR_ID,
									RUANG_ID,PEGAWAI_ID,
									PEGAWAI_RAWAT_ID,PEGAWAI_RAWAT_ID_2,PEGAWAI_RAWAT_ID_3,
									DATE_FORMAT(PASIEN_MASUK,"%d-%m-%Y %H:%i:%s") AS TANGGAL_MASUK	
									FROM t_irna WHERE IRNA_ID = "' . $_POST['irna_id'] . '"';
				$get_cek_no_ranap = mysql_query($sql_cek_no_ranap) or die(mysql_error());
				$dat_cek_no_ranap = mysql_fetch_assoc($get_cek_no_ranap);

					$qry_pindah = 'SELECT DATE_FORMAT(t_irna_log.TANGGAL_MASUK,"%d-%m-%Y %H:%i:%s") AS TANGGAL_MASUK
								 FROM t_irna_log
								 WHERE t_irna_log.IRNA_ID = "' . $_POST['irna_id'] . '"
								 AND t_irna_log.JNS_UPDATE = "R"
								 AND t_irna_log.TANGGAL_MASUK IS NOT NULL
								 ORDER BY t_irna_log.TANGGAL_MASUK DESC LIMIT 1';
					$get_pindah = mysql_query($qry_pindah) or die(mysql_error());
					if(mysql_num_rows($get_pindah) > 0){
						$dat_pindah = mysql_fetch_assoc($get_pindah);
						$tgl_masuk = $dat_pindah['TANGGAL_MASUK']; 
					}else{
						$tgl_masuk = $dat_cek_no_ranap['TANGGAL_MASUK']; 
					}
					
					if(!empty($_POST['idlog'])){
						$irna_log_id = $_POST['idlog']; 
						mysql_query('UPDATE t_irna_log SET TANGGAL_UPDATE = NOW(),
							RUANG_ID_BARU = "' . $ruang_id_baru . '",
							KETERANGAN_PINDAH = "' . $keterangan . '",
							USER_IRNA = "' . $user_name . '",
							TANGGAL_KELUAR = NOW(),
							LAMA_DIRAWAT = DATEDIFF(NOW(),STR_TO_DATE("' . $tgl_masuk . '","%d-%m-%Y %H:%i:%s")) 
							WHERE IRNA_LOG_ID = "' . $irna_log_id . '"') or die(mysql_error());
					}else{
						mysql_query('INSERT INTO t_irna_log(IRNA_ID,NOMR,TANGGAL_UPDATE,JNS_UPDATE,
							RUANG_ID_ASAL,RUANG_ID_BARU,PEGAWAI_ID,PEGAWAI_RAWAT_ID,PEGAWAI_RAWAT_ID_2,
							PEGAWAI_RAWAT_ID_3,KETERANGAN_PINDAH,USER_IRNA,TANGGAL_KELUAR,JENIS_BAYAR_ID,
							LAMA_DIRAWAT)
							VALUES("' . $irna_id . '","' . $nomr . '",NOW(),"R",
							"' . $dat_cek_no_ranap['RUANG_ID'] . '","' . $ruang_id_baru . '",
							"' . $dat_cek_no_ranap['PEGAWAI_ID'] . '","' . $dat_cek_no_ranap['PEGAWAI_RAWAT_ID'] . '",
							"' . $dat_cek_no_ranap['PEGAWAI_RAWAT_ID_2'] . '","' . $dat_cek_no_ranap['PEGAWAI_RAWAT_ID_3'] . '",
							"' . $keterangan . '","' . $user_name . '",NOW(),"' . $dat_cek_no_ranap['JENIS_BAYAR_ID'] . '",
							DATEDIFF(NOW(),STR_TO_DATE("' . $tgl_masuk . '","%d-%m-%Y %H:%i:%s")))') or die(mysql_error());
					}		

					if($irna_log_id == ''){
						$sql_log_id = 'SELECT IRNA_LOG_ID FROM t_irna_log
								WHERE IRNA_ID = "' . $irna_id . '"
								ORDER BY IRNA_LOG_ID DESC LIMIT 1';
						$get_log_id = mysql_query($sql_log_id) or die(mysql_error());
						$dat_log_id = mysql_fetch_assoc($get_log_id);			
						$irna_log_id = $dat_log_id['IRNA_LOG_ID'];
					}	
			
					$st_save = mysql_query('UPDATE t_irna SET RUANG_ID = "' . $ruang_id_baru . '",PEGAWAI_ID = "' . $dokter_pjawab . '",
							PEGAWAI_RAWAT_ID = "' . $dokter_prawat . '",PEGAWAI_RAWAT_ID_2 = "' . $dokter_prawat_2 . '",
							PEGAWAI_RAWAT_ID_3 = "' . $dokter_prawat_3 . '",NO_TMP_TIDUR = "' . $tmp_tidur_baru . '",ST_PINDAH = "1",
							LOG_PINDAH_ID = "' . $irna_log_id . '",USER_IRNA = "' . $user_name . '"
							WHERE IRNA_ID = "' . $irna_id . '"') or die(mysql_error());
				?>
				<script language="JavaScript" >
					alert('Simpan Data Pindah Ruang Berhasil.');
					 window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=pndh&idx=<?php echo $_GET['idx']; ?>";
				</script>
				<?php

	} else {
		$msg_info = $_err;
	}
}else{
	
	$st_save = mysql_query('UPDATE t_irna SET NO_TMP_TIDUR = "' . $_POST['tmp_tidur_new_kamar'] . '",
						USER_IRNA = "' . $user_name . '"
						WHERE IRNA_ID = "' . $irna_id . '"') or die(mysql_error());
	?>
	<script language="JavaScript" >
		alert('Simpan Data Pindah Ruang Berhasil.');
		window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=pndh&idx=<?php echo $_GET['idx']; ?>";
	</script>
	<?php
}	
?>