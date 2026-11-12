<?php
$irna_id = $_POST['irna_id'];
$irna_edukasi_id = $_POST['irna_edukasi_id'];
$hambatan_tidakada = '';
if(isset($_POST['hambatan_tidakada'])) $hambatan_tidakada = $_POST['hambatan_tidakada'];
$hambatan_penglihatan = '';
if(isset($_POST['hambatan_penglihatan'])) $hambatan_penglihatan = $_POST['hambatan_penglihatan'];
$hambatan_pendengaran = '';
if(isset($_POST['hambatan_pendengaran'])) $hambatan_pendengaran = $_POST['hambatan_pendengaran'];
$hambatan_emosional = '';
if(isset($_POST['hambatan_emosional'])) $hambatan_emosional = $_POST['hambatan_emosional'];
$hambatan_jasmani = '';
if(isset($_POST['hambatan_jasmani'])) $hambatan_jasmani = $_POST['hambatan_jasmani'];
$hambatan_kepercayaan = '';
if(isset($_POST['hambatan_kepercayaan'])) $hambatan_kepercayaan = $_POST['hambatan_kepercayaan'];
$hambatan_bahasa = '';
if(isset($_POST['hambatan_bahasa'])) $hambatan_bahasa = $_POST['hambatan_bahasa'];
$hambatan_pendidikan = '';
if(isset($_POST['hambatan_pendidikan'])) $hambatan_pendidikan = $_POST['hambatan_pendidikan'];
$hambatan_motivasi = '';
if(isset($_POST['hambatan_motivasi'])) $hambatan_motivasi = $_POST['hambatan_motivasi'];
$hambatan_proses_fikir = '';
if(isset($_POST['hambatan_proses_fikir'])) $hambatan_proses_fikir = $_POST['hambatan_proses_fikir'];
$hambatan_budaya = '';
if(isset($_POST['hambatan_budaya'])) $hambatan_budaya = $_POST['hambatan_budaya'];
$hambatan_lainnya = '';
if(isset($_POST['hambatan_lainnya'])) $hambatan_lainnya = $_POST['hambatan_lainnya'];
$hambatan_lainnya_ket = '';
if(isset($_POST['hambatan_lainnya_ket'])) $hambatan_lainnya_ket = $_POST['hambatan_lainnya_ket'];
$bicara = '';
if(isset($_POST['bicara'])) $bicara = $_POST['bicara'];
$agama = '';
if(isset($_POST['agama'])) $agama = $_POST['agama'];
$agama_ket = $_POST['agama_ket'];
$bahasa_indonesia = '';
if(isset($_POST['bahasa_indonesia'])) $bahasa_indonesia = $_POST['bahasa_indonesia'];
$bahasa_indonesia_aktif_pasif = '';
if(isset($_POST['bahasa_indonesia_aktif_pasif'])) $bahasa_indonesia_aktif_pasif = $_POST['bahasa_indonesia_aktif_pasif'];
$bahasa_daerah = '';
if(isset($_POST['bahasa_daerah'])) $bahasa_daerah = $_POST['bahasa_daerah'];
$bahasa_daerah_ket = $_POST['bahasa_daerah_ket'];
$bahasa_inggris = '';
if(isset($_POST['bahasa_inggris'])) $bahasa_inggris = $_POST['bahasa_inggris'];
$bahasa_inggris_aktif_pasif = '';
if(isset($_POST['bahasa_inggris_aktif_pasif'])) $bahasa_inggris_aktif_pasif = $_POST['bahasa_inggris_aktif_pasif'];
$bahasa_lainnya = '';
if(isset($_POST['bahasa_lainnya'])) $bahasa_lainnya = $_POST['bahasa_lainnya'];
$bahasa_lainnya_ket = $_POST['bahasa_lainnya_ket'];
$budaya_pantangan_makan = '';
if(isset($_POST['budaya_pantangan_makan'])) $budaya_pantangan_makan = $_POST['budaya_pantangan_makan'];
$budaya_pantangan_makan_ket = $_POST['budaya_pantangan_makan_ket'];
$budaya_jam_makan = '';
if(isset($_POST['budaya_jam_makan'])) $budaya_jam_makan = $_POST['budaya_jam_makan'];
$budaya_jam_makan_ket = $_POST['budaya_jam_makan_ket'];
$budaya_lainnya = '';
if(isset($_POST['budaya_lainnya'])) $budaya_lainnya = $_POST['budaya_lainnya'];
$budaya_lainnya_ket = $_POST['budaya_lainnya_ket'];
$budaya_tidakada = '';
if(isset($_POST['budaya_tidakada'])) $budaya_tidakada = $_POST['budaya_tidakada'];
$pendidikan = '';
if(isset($_POST['pendidikan'])) $pendidikan = $_POST['pendidikan'];
$penerjemah = '';
if(isset($_POST['penerjemah'])) $penerjemah = $_POST['penerjemah'];
$penerjemah_ket = $_POST['penerjemah_ket'];
$bahasa_isarat = '';
if(isset($_POST['bahasa_isarat'])) $bahasa_isarat = $_POST['bahasa_isarat'];
$bahasa_isarat_ket = $_POST['bahasa_isarat_ket'];
$emosional = '';
if(isset($_POST['emosional'])) $emosional = $_POST['emosional'];
$emosional_ket = $_POST['emosional_ket'];
$motivasi = '';
if(isset($_POST['motivasi'])) $motivasi = $_POST['motivasi'];
$motivasi_ket = $_POST['motivasi_ket'];
$pembelajaran_penyakit = '';
if(isset($_POST['pembelajaran_penyakit'])) $pembelajaran_penyakit = $_POST['pembelajaran_penyakit'];
$pembelajaran_pengobatan = '';
if(isset($_POST['pembelajaran_pengobatan'])) $pembelajaran_pengobatan = $_POST['pembelajaran_pengobatan'];
$pembelajaran_diit = '';
if(isset($_POST['pembelajaran_diit'])) $pembelajaran_diit = $_POST['pembelajaran_diit'];
$pembelajaran_terapi = '';
if(isset($_POST['pembelajaran_terapi'])) $pembelajaran_terapi = $_POST['pembelajaran_terapi'];
$pembelajaran_alatmedis = '';
if(isset($_POST['pembelajaran_alatmedis'])) $pembelajaran_alatmedis = $_POST['pembelajaran_alatmedis'];
$pembelajaran_nyeri = '';
if(isset($_POST['pembelajaran_nyeri'])) $pembelajaran_nyeri = $_POST['pembelajaran_nyeri'];
$pembelajaran_rehabilitasi = '';
if(isset($_POST['pembelajaran_rehabilitasi'])) $pembelajaran_rehabilitasi = $_POST['pembelajaran_rehabilitasi'];
$pembelajaran_perawatan = '';
if(isset($_POST['pembelajaran_perawatan'])) $pembelajaran_perawatan = $_POST['pembelajaran_perawatan'];
$pembelajaran_lainnya = '';
if(isset($_POST['pembelajaran_lainnya'])) $pembelajaran_lainnya = $_POST['pembelajaran_lainnya'];
$pembelajaran_lainnya_ket = $_POST['pembelajaran_lainnya_ket'];

$_err = '';
if (empty($_err)) {
		if(empty($irna_edukasi_id)){
					mysql_query('INSERT INTO t_irna_edukasi (IRNA_EDUKASI_ID,HAMBATAN_TIDAKADA,HAMBATAN_PENGLIHATAN,HAMBATAN_PENDENGARAN,
							HAMBATAN_EMOSIONAL,HAMBATAN_JASMANI,HAMBATAN_KEPERCAYAAN,HAMBATAN_BAHASA,HAMBATAN_PENDIDIKAN,HAMBATAN_MOTIVASI,
							HAMBATAN_PROSES_FIKIR,HAMBATAN_BUDAYA,HAMBATAN_LAINNYA,HAMBATAN_LAINNYA_KET,BICARA,AGAMA,AGAMA_KET,
							BAHASA_INDONESIA,BAHASA_INDONESIA_AKTIF_PASIF,BAHASA_DAERAH,BAHASA_DAERAH_KET,BAHASA_INGGRIS,
							BAHASA_INGGRIS_AKTIF_PASIF,BAHASA_LAINNYA,BAHASA_LAINNYA_KET,BUDAYA_PANTANGAN_MAKAN,BUDAYA_PANTANGAN_MAKAN_KET,
							BUDAYA_JAM_MAKAN,BUDAYA_JAM_MAKAN_KET,BUDAYA_LAINNYA,BUDAYA_LAINNYA_KET,BUDAYA_TIDAKADA,PENDIDIKAN,PENERJEMAH,
							PENERJEMAH_KET,BAHASA_ISARAT,BAHASA_ISARAT_KET,EMOSIONAL,EMOSIONAL_KET,MOTIVASI,MOTIVASI_KET,
							PEMBELAJARAN_PENYAKIT,PEMBELAJARAN_PENGOBATAN,PEMBELAJARAN_DIIT,PEMBELAJARAN_TERAPI,PEMBELAJARAN_ALATMEDIS,
							PEMBELAJARAN_NYERI,PEMBELAJARAN_REHABILITASI,PEMBELAJARAN_PERAWATAN,PEMBELAJARAN_LAINNYA,PEMBELAJARAN_LAINNYA_KET,
							TGL_ASSESMENT,REGISTER) 
							VALUES ("'.$irna_id.'","'.$hambatan_tidakada.'","'.$hambatan_penglihatan.'","'.$hambatan_pendengaran.'",
							"'.$hambatan_emosional.'","'.$hambatan_jasmani.'","'.$hambatan_kepercayaan.'","'.$hambatan_bahasa.'",
							"'.$hambatan_pendidikan.'","'.$hambatan_motivasi.'","'.$hambatan_proses_fikir.'","'.$hambatan_budaya.'",
							"'.$hambatan_lainnya.'","'.$hambatan_lainnya_ket.'","'.$bicara.'","'.$agama.'","'.$agama_ket.'",
							"'.$bahasa_indonesia.'","'.$bahasa_indonesia_aktif_pasif.'","'.$bahasa_daerah.'","'.$bahasa_daerah_ket.'",
							"'.$bahasa_inggris.'","'.$bahasa_inggris_aktif_pasif.'","'.$bahasa_lainnya.'","'.$bahasa_lainnya_ket.'",
							"'.$budaya_pantangan_makan.'","'.$budaya_pantangan_makan_ket.'","'.$budaya_jam_makan.'",
							"'.$budaya_jam_makan_ket.'","'.$budaya_lainnya.'","'.$budaya_lainnya_ket.'","'.$budaya_tidakada.'",
							"'.$pendidikan.'","'.$penerjemah.'","'.$penerjemah_ket.'","'.$bahasa_isarat.'","'.$bahasa_isarat_ket.'",
							"'.$emosional.'","'.$emosional_ket.'","'.$motivasi.'","'.$motivasi_ket.'","'.$pembelajaran_penyakit.'",
							"'.$pembelajaran_pengobatan.'","'.$pembelajaran_diit.'","'.$pembelajaran_terapi.'","'.$pembelajaran_alatmedis.'",
							"'.$pembelajaran_nyeri.'","'.$pembelajaran_rehabilitasi.'","'.$pembelajaran_perawatan.'","'.$pembelajaran_lainnya.'",
							"'.$pembelajaran_lainnya_ket.'",
							NOW(),"' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '")') or die(mysql_error());	
				}else{
					mysql_query('UPDATE t_irna_edukasi SET HAMBATAN_TIDAKADA = "'.$hambatan_tidakada.'",HAMBATAN_PENGLIHATAN = "'.$hambatan_penglihatan.'",
							HAMBATAN_PENDENGARAN = "'.$hambatan_pendengaran.'",HAMBATAN_EMOSIONAL = "'.$hambatan_emosional.'",
							HAMBATAN_JASMANI = "'.$hambatan_jasmani.'",HAMBATAN_KEPERCAYAAN = "'.$hambatan_kepercayaan.'",
							HAMBATAN_BAHASA = "'.$hambatan_bahasa.'",HAMBATAN_PENDIDIKAN = "'.$hambatan_pendidikan.'",
							HAMBATAN_MOTIVASI = "'.$hambatan_motivasi.'",HAMBATAN_PROSES_FIKIR = "'.$hambatan_proses_fikir.'",
							HAMBATAN_BUDAYA = "'.$hambatan_budaya.'",HAMBATAN_LAINNYA = "'.$hambatan_lainnya.'",
							HAMBATAN_LAINNYA_KET = "'.$hambatan_lainnya_ket.'",BICARA = "'.$bicara.'",AGAMA = "'.$agama.'",AGAMA_KET = "'.$agama_ket.'",
							BAHASA_INDONESIA = "'.$bahasa_indonesia.'",BAHASA_INDONESIA_AKTIF_PASIF = "'.$bahasa_indonesia_aktif_pasif.'",
							BAHASA_DAERAH = "'.$bahasa_daerah.'",BAHASA_DAERAH_KET = "'.$bahasa_daerah_ket.'",BAHASA_INGGRIS = "'.$bahasa_inggris.'",
							BAHASA_INGGRIS_AKTIF_PASIF = "'.$bahasa_inggris_aktif_pasif.'",BAHASA_LAINNYA = "'.$bahasa_lainnya.'",
							BAHASA_LAINNYA_KET = "'.$bahasa_lainnya_ket.'",BUDAYA_PANTANGAN_MAKAN = "'.$budaya_pantangan_makan.'",
							BUDAYA_PANTANGAN_MAKAN_KET = "'.$budaya_pantangan_makan_ket.'",BUDAYA_JAM_MAKAN = "'.$budaya_jam_makan.'",
							BUDAYA_JAM_MAKAN_KET = "'.$budaya_jam_makan_ket.'",BUDAYA_LAINNYA = "'.$budaya_lainnya.'",
							BUDAYA_LAINNYA_KET = "'.$budaya_lainnya_ket.'",BUDAYA_TIDAKADA = "'.$budaya_tidakada.'",PENDIDIKAN = "'.$pendidikan.'",
							PENERJEMAH = "'.$penerjemah.'",PENERJEMAH_KET = "'.$penerjemah_ket.'",BAHASA_ISARAT = "'.$bahasa_isarat.'",
							BAHASA_ISARAT_KET = "'.$bahasa_isarat_ket.'",EMOSIONAL = "'.$emosional.'",EMOSIONAL_KET = "'.$emosional_ket.'",
							MOTIVASI = "'.$motivasi.'",MOTIVASI_KET = "'.$motivasi_ket.'",PEMBELAJARAN_PENYAKIT = "'.$pembelajaran_penyakit.'",
							PEMBELAJARAN_PENGOBATAN = "'.$pembelajaran_pengobatan.'",PEMBELAJARAN_DIIT = "'.$pembelajaran_diit.'",
							PEMBELAJARAN_TERAPI = "'.$pembelajaran_terapi.'",PEMBELAJARAN_ALATMEDIS = "'.$pembelajaran_alatmedis.'",
							PEMBELAJARAN_NYERI = "'.$pembelajaran_nyeri.'",PEMBELAJARAN_REHABILITASI = "'.$pembelajaran_rehabilitasi.'",
							PEMBELAJARAN_PERAWATAN = "'.$pembelajaran_perawatan.'",PEMBELAJARAN_LAINNYA = "'.$pembelajaran_lainnya.'",
							PEMBELAJARAN_LAINNYA_KET = "'.$pembelajaran_lainnya_ket.'",
							TGL_ASSESMENT = NOW(),
							REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
							ST_CREATE_ERM = NULL
							WHERE IRNA_EDUKASI_ID = "'.$irna_edukasi_id.'"') or die(mysql_error());	
				}		
				
				$k = 1;
				while ($k <= 41){
					mysql_query('DELETE FROM t_irna_edukasi_detail WHERE IRNA_EDUKASI_ID = "' . $irna_id . '" AND ISI_EDUKASI_ID = "' . $k . '"') or die(mysql_error());
					if(isset($_POST['isi_edukasi_' . $k])){
						$isi_edu_des = '';
						if(isset($_POST['isi_edukasi_des_' . $k])) $isi_edu_des = $_POST['isi_edukasi_des_' . $k]; 
						mysql_query('INSERT INTO t_irna_edukasi_detail(IRNA_EDUKASI_ID,ISI_EDUKASI_ID,ISI_EDUKASI_DES,
									TANGGAL,RUANGAN,TINGKAT_PEMAHAMAN,JAM_1,JAM_2,PROFESI,METODE,PENERIMA_PENDIDIKAN,
									EVALUASI_RESPONSE,PEMBERI_EDUKASI,PENERIMA_EDUKASI,PEMBERI_EDUKASI_2,PENERIMA_EDUKASI_2)
									VALUES("' . $irna_id . '","' . $_POST['isi_edukasi_' . $k] . '","' . $isi_edu_des . '",
									STR_TO_DATE("' . $_POST['tgl_edu_' . $k] . '","%d/%m/%Y"),"' . $_POST['ruang_edu_' . $k] . '",
									"' . $_POST['pemahaman_edu_' . $k] . '","' . $_POST['jam_edu_1_' . $k] . ':' . $_POST['menit_edu_1_' . $k] . '",
									"' . $_POST['jam_edu_2_' . $k] . ':' . $_POST['menit_edu_2_' . $k] . '","' . $_POST['profesi_edu_' . $k] . '",
									"' . $_POST['metode_edu_' . $k] . '","' . $_POST['penerima_edu_' . $k] . '","' . $_POST['evaluasi_edu_' . $k] . '",
									"' . $_POST['pemberi_edu_' . $k] . '","' . $_POST['penerima_edu_' . $k] . '",
									"' . $_POST['pemberi_edu_2_' . $k] . '","' . $_POST['penerima_edu_2_' . $k] . '")') or die(mysql_error());
					}
				$k++; 
	}			
    ?>
    <script language="JavaScript" >
        alert('Simpan Data Edukasi Pasien Berhasil.');
		window.location = "<?php echo currentUrl(); ?>";
    </script>
    <?php
} else {
    $msg_info = $_err;
}
?>