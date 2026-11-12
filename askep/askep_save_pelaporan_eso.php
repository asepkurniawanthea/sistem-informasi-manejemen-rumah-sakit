<?php
$_err = '';
$irna_id = $_POST['irna_id'];
$pelaporan_eso_id = $_POST['pelaporan_eso_id'];
$tanggal = $_POST['tanggal'];
$perawat = $_POST['perawat'];
$user_name = currentUser();

$sql_cek_no_rawat = 'SELECT ST_ASKEP FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
$get_cek_no_rawat = mysql_query($sql_cek_no_rawat) or die(mysql_error());
$dat_cek_no_rawat = mysql_fetch_assoc($get_cek_no_rawat);
if (empty($dat_cek_no_rawat['ST_ASKEP'])  or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
	if (empty($_err)) {
		
		$penyakit_utama = $_POST['penyakit_utama'];
		$kesudahan_penyakit_utama = '';
		if(isset($_POST['kesudahan_penyakit_utama'])) $kesudahan_penyakit_utama = $_POST['kesudahan_penyakit_utama'];
		$penyakit_lain_menyertai = '';
		for($x=1;$x < 8; $x++){
			if(isset($_POST['penyakit_lain_menyertai_' . $x])) {
				$penyakit_lain_menyertai = $penyakit_lain_menyertai . $_POST['penyakit_lain_menyertai_' . $x] . '|';
			}else{
				$penyakit_lain_menyertai = $penyakit_lain_menyertai . '|';
			}
		}	
		$tanggal_mulai_terjadi = $_POST['tanggal_mulai_terjadi'];
		$bentuk_eso = $_POST['bentuk_eso'];
		$data_laboratorium = $_POST['data_laboratorium'];
		$kesudahan_eso = '';
		if(isset($_POST['kesudahan_eso'])) $kesudahan_eso = $_POST['kesudahan_eso'];
		$tanggal_kesudahan_eso = $_POST['tanggal_kesudahan_eso'];
		$reaksi_eso = $_POST['reaksi_eso'];
		$tindakan = $_POST['tindakan'];
		$reaksi_hilang = '';
		if(isset($_POST['reaksi_hilang'])) $reaksi_hilang = $_POST['reaksi_hilang'];
		$reaksi_timbul = '';
		if(isset($_POST['reaksi_timbul'])) $reaksi_timbul = $_POST['reaksi_timbul'];
		$alghoritma_naranjo = '';
		for($x=1;$x < 11; $x++){
			if(isset($_POST['alghoritma_naranjo_' . $x])) {
				$alghoritma_naranjo = $alghoritma_naranjo . $_POST['alghoritma_naranjo_' . $x] . '|';
			}else{
				$alghoritma_naranjo = $alghoritma_naranjo . '|';
			}
		}	
		
		if(empty($pelaporan_eso_id)){
			mysql_query('INSERT INTO t_irna_askep_pelaporan_eso (PELAPORAN_ESO_ID,PENYAKIT_UTAMA,KESUDAHAN_PENYAKIT_UTAMA,
						PENYAKIT_LAIN_MENYERTAI,TANGGAL_MULAI_TERJADI,BENTUK_ESO,DATA_LABORATORIUM,KESUDAHAN_ESO,
						TANGGAL_KESUDAHAN_ESO,REAKSI_ESO,TINDAKAN,REAKSI_HILANG,REAKSI_TIMBUL,ALGHORITMA_NARANJO,TANGGAL,
						PERAWAT,USER_ASKEP) VALUES 
						("'.$irna_id.'","'.$penyakit_utama.'","'.$kesudahan_penyakit_utama.'",
						"'.$penyakit_lain_menyertai.'",STR_TO_DATE("'.$tanggal_mulai_terjadi.'","%d/%m/%Y"),"'.$bentuk_eso.'",
						"'.$data_laboratorium.'","'.$kesudahan_eso.'",STR_TO_DATE("'.$tanggal_kesudahan_eso.'","%d/%m/%Y"),
						"'.$reaksi_eso.'","'.$tindakan.'","'.$reaksi_hilang.'","'.$reaksi_timbul.'","'.$alghoritma_naranjo.'",
						STR_TO_DATE("'.$tanggal.'","%d/%m/%Y"),"'.$perawat.'","'.$user_name.'")') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_irna_askep_pelaporan_eso SET PENYAKIT_UTAMA = "'.$penyakit_utama.'",
						KESUDAHAN_PENYAKIT_UTAMA = "'.$kesudahan_penyakit_utama.'",
						PENYAKIT_LAIN_MENYERTAI = "'.$penyakit_lain_menyertai.'",
						TANGGAL_MULAI_TERJADI = STR_TO_DATE("'.$tanggal_mulai_terjadi.'","%d/%m/%Y"),BENTUK_ESO = "'.$bentuk_eso.'",
						DATA_LABORATORIUM = "'.$data_laboratorium.'",KESUDAHAN_ESO = "'.$kesudahan_eso.'",
						TANGGAL_KESUDAHAN_ESO = STR_TO_DATE("'.$tanggal_kesudahan_eso.'","%d/%m/%Y"),REAKSI_ESO = "'.$reaksi_eso.'",
						TINDAKAN = "'.$tindakan.'",REAKSI_HILANG = "'.$reaksi_hilang.'",REAKSI_TIMBUL = "'.$reaksi_timbul.'",
						ALGHORITMA_NARANJO = "'.$alghoritma_naranjo.'",TANGGAL = STR_TO_DATE("'.$tanggal.'","%d/%m/%Y"),
						PERAWAT = "'.$perawat.'",USER_ASKEP = "'.$user_name.'" 
						WHERE PELAPORAN_ESO_ID = "'.$pelaporan_eso_id.'"') or die(mysql_error());
		}
		
		$eso_obat_id = $_POST['eso_obat_id'];
		$nama_obat = $_POST['nama_obat'];
		$bentuk_sediaan = $_POST['bentuk_sediaan'];
		$nomor_batch = $_POST['nomor_batch'];
		$obat_dicurigai = '';
		if(isset($_POST['obat_dicurigai'])) $obat_dicurigai = $_POST['obat_dicurigai'];
		$cara_pemberian = $_POST['cara_pemberian'];
		$tanggal_akhir_pemberian = $_POST['tanggal_akhir_pemberian'];
		$indikasi_penggunaan = $_POST['indikasi_penggunaan'];
		
		if(!empty($nama_obat) or !empty($bentuk_sediaan) or !empty($nomor_batch) or !empty($obat_dicurigai) or !empty($cara_pemberian) 
			or !empty($tanggal_akhir_pemberian) or !empty($indikasi_penggunaan)){
				
			if(empty($eso_obat_id)){
				mysql_query('INSERT INTO t_irna_askep_pelaporan_eso_obat (PELAPORAN_ESO_ID,KODE_OBAT,NAMA_OBAT,BENTUK_SEDIAAN,NOMOR_BATCH,
							OBAT_DICURIGAI,CARA_PEMBERIAN,TANGGAL_AKHIR_PEMBERIAN,INDIKASI_PENGGUNAAN) 
							VALUES ("'.$irna_id.'","","'.$nama_obat.'","'.$bentuk_sediaan.'","'.$nomor_batch.'","'.$obat_dicurigai.'",
							"'.$cara_pemberian.'",STR_TO_DATE("'.$tanggal_akhir_pemberian.'","%d/%m/%Y"),"'.$indikasi_penggunaan.'")') or die(mysql_error());
			}else{
				mysql_query('UPDATE t_irna_askep_pelaporan_eso_obat SET KODE_OBAT = "",
							NAMA_OBAT = "'.$nama_obat.'",BENTUK_SEDIAAN = "'.$bentuk_sediaan.'",
							NOMOR_BATCH = "'.$nomor_batch.'",OBAT_DICURIGAI = "'.$obat_dicurigai.'",
							CARA_PEMBERIAN = "'.$cara_pemberian.'",
							TANGGAL_AKHIR_PEMBERIAN = STR_TO_DATE("'.$tanggal_akhir_pemberian.'","%d/%m/%Y"),
							INDIKASI_PENGGUNAAN = "'.$indikasi_penggunaan.'"
							WHERE ESO_OBAT_ID = "'.$eso_obat_id.'"') or die(mysql_error());
			}
		}
?>
<script language="JavaScript" >
	alert('Simpan Data Pelaporan E.S.O Berhasil.');
	window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=peso&idx=<?php echo $_GET['idx']; ?>";
</script>
<?php		
		}else{
			$msg_info = $_err;
		}
}
?>