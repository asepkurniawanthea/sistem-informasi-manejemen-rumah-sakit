<?php
$_err = '';
$irna_id = $_POST['irna_id'];
$pengendalian_infeksi_id = $_POST['pengendalian_infeksi_id'];
$user_name = currentUser();

$sql_cek_no_rawat = 'SELECT ST_ASKEP FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
$get_cek_no_rawat = mysql_query($sql_cek_no_rawat) or die(mysql_error());
$dat_cek_no_rawat = mysql_fetch_assoc($get_cek_no_rawat);
if (empty($dat_cek_no_rawat['ST_ASKEP'])  or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
	if (empty($_err)) {
	$no_for_sur = $_POST['no_for_sur'];
	$tgl_keluar = $_POST['tgl_keluar'];
	$faktor_resiko = $_POST['faktor_resiko'];
	$cara_dirawat = '';
	if(isset($_POST['cara_dirawat'])) $cara_dirawat = $_POST['cara_dirawat'];
	$sebab_keluar = $_POST['sebab_keluar'];
	$diagnosa_akhir = $_POST['diagnosa_akhir'];
	$faktor_resiko_operasi = $_POST['faktor_resiko_operasi'];
	$ahli_bedah = $_POST['ahli_bedah'];
	$scrube_nurse = $_POST['scrube_nurse'];
	$jenis_operasi = '';
	for($i=1;$i<6;$i++){
		if(isset($_POST['jenis_operasi_' . $i])) {
			$jenis_operasi = $jenis_operasi . $_POST['jenis_operasi_' . $i] . '|';
		}else{
			$jenis_operasi = $jenis_operasi . '|';
		}	
	}	
	$tipe_operasi = '';
	if(isset($_POST['tipe_operasi'])) $tipe_operasi = $_POST['tipe_operasi'];
	$jenis_luka = '';
	if(isset($_POST['jenis_luka'])) $jenis_luka = $_POST['jenis_luka'];
	$lama_operasi = '';
	if(isset($_POST['lama_operasi'])) $lama_operasi = $_POST['lama_operasi'];
	$asa_score = $_POST['asa_score'];
	$risk_score = $_POST['risk_score'];
	$tgl_pasang_cateter_perifer = $_POST['tgl_pasang_cateter_perifer'];
	$tgl_pasang_cateter_sentral = $_POST['tgl_pasang_cateter_sentral'];
	$tgl_pasang_cateter_urine = $_POST['tgl_pasang_cateter_urine'];
	$tgl_pasang_ventilasi_mekanik = $_POST['tgl_pasang_ventilasi_mekanik'];
	$sd_pasang_cateter_perifer = $_POST['sd_pasang_cateter_perifer'];
	$sd_pasang_cateter_sentral = $_POST['sd_pasang_cateter_sentral'];
	$sd_pasang_cateter_urine = $_POST['sd_pasang_cateter_urine'];
	$sd_pasang_ventilasi_mekanik = $_POST['sd_pasang_ventilasi_mekanik'];
	$bb_lahir = $_POST['bb_lahir'];
	$bb_sekarang = $_POST['bb_sekarang'];
	$kondisi_gizi = $_POST['kondisi_gizi'];
	$pemakaian_antibiotika = '';
	for($i=1;$i<3;$i++){
		if(isset($_POST['pemakaian_antibiotika_' . $i])) {
			$pemakaian_antibiotika = $pemakaian_antibiotika . $_POST['pemakaian_antibiotika_' . $i] . '|';
		}else{
			$pemakaian_antibiotika = $pemakaian_antibiotika . '|';
		}	
	}
	$nama_jenis_obat = $_POST['nama_jenis_obat'];
	$pemeriksaan_kultur = '';
	for($i=1;$i<5;$i++){
		if(isset($_POST['pemeriksaan_kultur_' . $i])) {
			$pemeriksaan_kultur = $pemeriksaan_kultur . $_POST['pemeriksaan_kultur_' . $i] . '|';
		}else{
			$pemeriksaan_kultur = $pemeriksaan_kultur . '|';
		}	
	}
	$temp = $_POST['temp'];
	$hasil_kultur = $_POST['hasil_kultur'];
	$infeksi_nosokimial = $_POST['infeksi_nosokimial'];
	$bakteremia = $_POST['bakteremia'];
	$vap = $_POST['vap'];
	$saluran_kemih = $_POST['saluran_kemih'];
	$luka_operasi = $_POST['luka_operasi'];
	$dekubitus = $_POST['dekubitus'];
	$plebitis = $_POST['plebitis'];
	$infeksi_lain = $_POST['infeksi_lain'];

	if(empty($pengendalian_infeksi_id)){
		mysql_query('INSERT INTO t_irna_askep_pengendalian_infeksi (PENGENDALIAN_INFEKSI_ID,NO_FOR_SUR,TGL_KELUAR,CARA_DIRAWAT,SEBAB_KELUAR,
					DIAGNOSA_AKHIR,FAKTOR_RESIKO,FAKTOR_RESIKO_OPERASI,AHLI_BEDAH,SCRUBE_NURSE,JENIS_OPERASI,TIPE_OPERASI,JENIS_LUKA,
					LAMA_OPERASI,ASA_SCORE,RISK_SCORE,TGL_PASANG_CATETER_PERIFER,TGL_PASANG_CATETER_SENTRAL,TGL_PASANG_CATETER_URINE,
					TGL_PASANG_VENTILASI_MEKANIK,SD_PASANG_CATETER_PERIFER,SD_PASANG_CATETER_SENTRAL,SD_PASANG_CATETER_URINE,
					SD_PASANG_VENTILASI_MEKANIK,BB_LAHIR,BB_SEKARANG,KONDISI_GIZI,PEMAKAIAN_ANTIBIOTIKA,NAMA_JENIS_OBAT,PEMERIKSAAN_KULTUR,
					TEMP,HASIL_KULTUR,INFEKSI_NOSOKIMIAL,BAKTEREMIA,VAP,SALURAN_KEMIH,LUKA_OPERASI,DEKUBITUS,PLEBITIS,INFEKSI_LAIN,USER_ASKEP) 
					VALUES ("'.$irna_id.'","'.$no_for_sur.'",STR_TO_DATE("'.$tgl_keluar.'","%d/%m/%Y"),"'.$cara_dirawat.'","'.$sebab_keluar.'",
					"'.$diagnosa_akhir.'","'.$faktor_resiko.'","'.$faktor_resiko_operasi.'","'.$ahli_bedah.'","'.$scrube_nurse.'",
					"'.$jenis_operasi.'","'.$tipe_operasi.'","'.$jenis_luka.'","'.$lama_operasi.'","'.$asa_score.'","'.$risk_score.'",
					STR_TO_DATE("'.$tgl_pasang_cateter_perifer.'","%d/%m/%Y"),STR_TO_DATE("'.$tgl_pasang_cateter_sentral.'","%d/%m/%Y"),
					STR_TO_DATE("'.$tgl_pasang_cateter_urine.'","%d/%m/%Y"),STR_TO_DATE("'.$tgl_pasang_ventilasi_mekanik.'","%d/%m/%Y"),
					STR_TO_DATE("'.$sd_pasang_cateter_perifer.'","%d/%m/%Y"),STR_TO_DATE("'.$sd_pasang_cateter_sentral.'","%d/%m/%Y"),
					STR_TO_DATE("'.$sd_pasang_cateter_urine.'","%d/%m/%Y"),STR_TO_DATE("'.$sd_pasang_ventilasi_mekanik.'","%d/%m/%Y"),
					"'.$bb_lahir.'","'.$bb_sekarang.'","'.$kondisi_gizi.'","'.$pemakaian_antibiotika.'","'.$nama_jenis_obat.'",
					"'.$pemeriksaan_kultur.'","'.$temp.'","'.$hasil_kultur.'","'.$infeksi_nosokimial.'","'.$bakteremia.'","'.$vap.'",
					"'.$saluran_kemih.'","'.$luka_operasi.'","'.$dekubitus.'","'.$plebitis.'","'.$infeksi_lain.'","'.$user_name.'")') or die(mysql_error());
	}else{
		mysql_query('UPDATE t_irna_askep_pengendalian_infeksi SET NO_FOR_SUR = "'.$no_for_sur.'",TGL_KELUAR = STR_TO_DATE("'.$tgl_keluar.'","%d/%m/%Y"),
					CARA_DIRAWAT = "'.$cara_dirawat.'",SEBAB_KELUAR = "'.$sebab_keluar.'",DIAGNOSA_AKHIR = "'.$diagnosa_akhir.'",
					FAKTOR_RESIKO = "'.$faktor_resiko.'",FAKTOR_RESIKO_OPERASI = "'.$faktor_resiko_operasi.'",AHLI_BEDAH = "'.$ahli_bedah.'",
					SCRUBE_NURSE = "'.$scrube_nurse.'",JENIS_OPERASI = "'.$jenis_operasi.'",TIPE_OPERASI = "'.$tipe_operasi.'",
					JENIS_LUKA = "'.$jenis_luka.'",LAMA_OPERASI = "'.$lama_operasi.'",ASA_SCORE = "'.$asa_score.'",
					RISK_SCORE = "'.$risk_score.'",TGL_PASANG_CATETER_PERIFER = STR_TO_DATE("'.$tgl_pasang_cateter_perifer.'","%d/%m/%Y"),
					TGL_PASANG_CATETER_SENTRAL = STR_TO_DATE("'.$tgl_pasang_cateter_sentral.'","%d/%m/%Y"),
					TGL_PASANG_CATETER_URINE = STR_TO_DATE("'.$tgl_pasang_cateter_urine.'","%d/%m/%Y"),
					TGL_PASANG_VENTILASI_MEKANIK = STR_TO_DATE("'.$tgl_pasang_ventilasi_mekanik.'","%d/%m/%Y"),
					SD_PASANG_CATETER_PERIFER = STR_TO_DATE("'.$sd_pasang_cateter_perifer.'","%d/%m/%Y"),
					SD_PASANG_CATETER_SENTRAL = STR_TO_DATE("'.$sd_pasang_cateter_sentral.'","%d/%m/%Y"),
					SD_PASANG_CATETER_URINE = STR_TO_DATE("'.$sd_pasang_cateter_urine.'","%d/%m/%Y"),
					SD_PASANG_VENTILASI_MEKANIK = STR_TO_DATE("'.$sd_pasang_ventilasi_mekanik.'","%d/%m/%Y"),
					BB_LAHIR = "'.$bb_lahir.'",BB_SEKARANG = "'.$bb_sekarang.'",KONDISI_GIZI = "'.$kondisi_gizi.'",
					PEMAKAIAN_ANTIBIOTIKA = "'.$pemakaian_antibiotika.'",NAMA_JENIS_OBAT = "'.$nama_jenis_obat.'",
					PEMERIKSAAN_KULTUR = "'.$pemeriksaan_kultur.'",TEMP = "'.$temp.'",HASIL_KULTUR = "'.$hasil_kultur.'",
					INFEKSI_NOSOKIMIAL = "'.$infeksi_nosokimial.'",BAKTEREMIA = "'.$bakteremia.'",VAP = "'.$vap.'",
					SALURAN_KEMIH = "'.$saluran_kemih.'",LUKA_OPERASI = "'.$luka_operasi.'",DEKUBITUS = "'.$dekubitus.'",
					PLEBITIS = "'.$plebitis.'",INFEKSI_LAIN = "'.$infeksi_lain.'",USER_ASKEP = "'.$user_name.'"
					WHERE PENGENDALIAN_INFEKSI_ID = "'.$pengendalian_infeksi_id.'"') or die(mysql_error());
	}
	
	$infeksi_rawat_id = $_POST['infeksi_rawat_id'];
	$ruang_rawat = $_POST['ruang_rawat'];
	$tanggal_dirawat = $_POST['tanggal_dirawat'];
	$sd_dirawat = $_POST['sd_dirawat'];
	 
	if(!empty($ruang_rawat)){
		if(empty($infeksi_rawat_id)){
			mysql_query('INSERT INTO t_irna_askep_pengendalian_infeksi_rawat (PENGENDALIAN_INFEKSI_ID,RUANG_RAWAT,TANGGAL_DIRAWAT,SD_DIRAWAT) 
					VALUES ("'.$irna_id.'","'.$ruang_rawat.'",STR_TO_DATE("'.$tanggal_dirawat.'","%d/%m/%Y"),STR_TO_DATE("'.$sd_dirawat.'","%d/%m/%Y"))') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_irna_askep_pengendalian_infeksi_rawat SET RUANG_RAWAT = "'.$ruang_rawat.'",
						TANGGAL_DIRAWAT = STR_TO_DATE("'.$tanggal_dirawat.'","%d/%m/%Y"),
						SD_DIRAWAT = STR_TO_DATE("'.$sd_dirawat.'","%d/%m/%Y") 
						WHERE INFEKSI_RAWAT_ID = "'.$infeksi_rawat_id.'"') or die(mysql_error());	
		}
	}
	
	//save pemakaian alat medis
	$sql_tanggal = 'SELECT DATE_FORMAT(SELECTED_DATE,"%d/%m/%Y") AS SELECTED_DATE 
				FROM (SELECT ADDDATE("1970-01-01",T4.I*10000 + T3.I*1000 + T2.I*100 + T1.I*10 + T0.I) SELECTED_DATE FROM
					(SELECT 0 I UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) T0,
					(SELECT 0 I UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) T1,
					(SELECT 0 I UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) T2,
					(SELECT 0 I UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) T3,
					(SELECT 0 I UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) T4) V
				WHERE SELECTED_DATE';				
	$id_alatmedis = '';
	if(empty($infeksi_rawat_id)){
		$id_alatmedis = $irna_id;
	}else{
		$id_alatmedis = $infeksi_rawat_id;
	}	
	mysql_query('DELETE FROM t_irna_askep_pengendalian_infeksi_alat_medis 
				WHERE PENGENDALIAN_INFEKSI_ID = "' . $id_alatmedis . '"') or die(mysql_error());
				
	if($tgl_pasang_cateter_perifer != '' and $tgl_pasang_cateter_perifer != '00/00/0000'){
		if($sd_pasang_cateter_perifer =='' or $sd_pasang_cateter_perifer =='00/00/0000'){
			mysql_query('INSERT INTO t_irna_askep_pengendalian_infeksi_alat_medis(
							PENGENDALIAN_INFEKSI_ID,TANGGAL,IVL) VALUES(
							"' . $id_alatmedis . '",
							STR_TO_DATE("' . $tgl_pasang_cateter_perifer . '","%d/%m/%Y"),
							"1")') or die(mysql_error());
		}else{
			$sql_tanggal_ls = $sql_tanggal . ' BETWEEN STR_TO_DATE("' . $tgl_pasang_cateter_perifer . '","%d/%m/%Y") 
				AND STR_TO_DATE("' . $sd_pasang_cateter_perifer . '","%d/%m/%Y")';
			$get_tanggal_ls = mysql_query($sql_tanggal_ls) or die(mysql_error());
			while($dat_tanggal_ls = mysql_fetch_array($get_tanggal_ls)){
				mysql_query('INSERT INTO t_irna_askep_pengendalian_infeksi_alat_medis(
							PENGENDALIAN_INFEKSI_ID,TANGGAL,IVL) VALUES(
							"' . $id_alatmedis . '",
							STR_TO_DATE("' . $dat_tanggal_ls['SELECTED_DATE'] . '","%d/%m/%Y"),
							"1")') or die(mysql_error());
			}	
		}
	}
	if($tgl_pasang_cateter_sentral != '' and $tgl_pasang_cateter_sentral != '00/00/0000'){
		if($sd_pasang_cateter_sentral =='' or $sd_pasang_cateter_sentral =='00/00/0000'){
			mysql_query('INSERT INTO t_irna_askep_pengendalian_infeksi_alat_medis(
							PENGENDALIAN_INFEKSI_ID,TANGGAL,CVL) VALUES(
							"' . $id_alatmedis . '",
							STR_TO_DATE("' . $tgl_pasang_cateter_sentral . '","%d/%m/%Y"),
							"1")') or die(mysql_error());
		}else{
			$sql_tanggal_ls = $sql_tanggal . ' BETWEEN STR_TO_DATE("' . $tgl_pasang_cateter_sentral . '","%d/%m/%Y") 
				AND STR_TO_DATE("' . $sd_pasang_cateter_sentral . '","%d/%m/%Y")';
			$get_tanggal_ls = mysql_query($sql_tanggal_ls) or die(mysql_error());
			while($dat_tanggal_ls = mysql_fetch_array($get_tanggal_ls)){
				mysql_query('INSERT INTO t_irna_askep_pengendalian_infeksi_alat_medis(
							PENGENDALIAN_INFEKSI_ID,TANGGAL,CVL) VALUES(
							"' . $id_alatmedis . '",
							STR_TO_DATE("' . $dat_tanggal_ls['SELECTED_DATE'] . '","%d/%m/%Y"),
							"1")') or die(mysql_error());
			}	
		}
	}
	if($tgl_pasang_cateter_urine != '' and $tgl_pasang_cateter_urine != '00/00/0000'){
		if($sd_pasang_cateter_urine =='' or $sd_pasang_cateter_urine =='00/00/0000'){
			mysql_query('INSERT INTO t_irna_askep_pengendalian_infeksi_alat_medis(
							PENGENDALIAN_INFEKSI_ID,TANGGAL,UC) VALUES(
							"' . $id_alatmedis . '",
							STR_TO_DATE("' . $tgl_pasang_cateter_urine . '","%d/%m/%Y"),
							"1")') or die(mysql_error());
		}else{
			$sql_tanggal_ls = $sql_tanggal . ' BETWEEN STR_TO_DATE("' . $tgl_pasang_cateter_urine . '","%d/%m/%Y") 
				AND STR_TO_DATE("' . $sd_pasang_cateter_urine . '","%d/%m/%Y")';
			$get_tanggal_ls = mysql_query($sql_tanggal_ls) or die(mysql_error());
			while($dat_tanggal_ls = mysql_fetch_array($get_tanggal_ls)){
				mysql_query('INSERT INTO t_irna_askep_pengendalian_infeksi_alat_medis(
							PENGENDALIAN_INFEKSI_ID,TANGGAL,UC) VALUES(
							"' . $id_alatmedis . '",
							STR_TO_DATE("' . $dat_tanggal_ls['SELECTED_DATE'] . '","%d/%m/%Y"),
							"1")') or die(mysql_error());
			}	
		}
	}
	if($tgl_pasang_ventilasi_mekanik != '' and $tgl_pasang_ventilasi_mekanik != '00/00/0000'){
		if($sd_pasang_ventilasi_mekanik =='' or $sd_pasang_ventilasi_mekanik =='00/00/0000'){
			mysql_query('INSERT INTO t_irna_askep_pengendalian_infeksi_alat_medis(
							PENGENDALIAN_INFEKSI_ID,TANGGAL,ETT) VALUES(
							"' . $id_alatmedis . '",
							STR_TO_DATE("' . $tgl_pasang_ventilasi_mekanik . '","%d/%m/%Y"),
							"1")') or die(mysql_error());
		}else{
			$sql_tanggal_ls = $sql_tanggal . ' BETWEEN STR_TO_DATE("' . $tgl_pasang_ventilasi_mekanik . '","%d/%m/%Y") 
				AND STR_TO_DATE("' . $sd_pasang_ventilasi_mekanik . '","%d/%m/%Y")';
			$get_tanggal_ls = mysql_query($sql_tanggal_ls) or die(mysql_error());
			while($dat_tanggal_ls = mysql_fetch_array($get_tanggal_ls)){
				mysql_query('INSERT INTO t_irna_askep_pengendalian_infeksi_alat_medis(
							PENGENDALIAN_INFEKSI_ID,TANGGAL,ETT) VALUES(
							"' . $id_alatmedis . '",
							STR_TO_DATE("' . $dat_tanggal_ls['SELECTED_DATE'] . '","%d/%m/%Y"),
							"1")') or die(mysql_error());
			}	
		}
	}	
?>
<script language="JavaScript" >
	alert('Simpan Data Pengendalian Infeksi Berhasil.');
	window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=sppi&idx=<?php echo $_GET['idx']; ?>";
</script>
<?php		
		}else{
			$msg_info = $_err;
		}
	}
?>