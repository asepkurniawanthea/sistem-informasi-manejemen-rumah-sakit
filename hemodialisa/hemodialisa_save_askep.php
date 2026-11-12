<?php
function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = str_replace('|','!',$str);
	$ret = htmlspecialchars($ret);
	return $ret;
}

$irja_id = $_POST['irja_id'];
$user_name = currentUser();

$keluhan_utama = replace_quote($_POST['keluhan_utama']); 
$riwayat_penyakit = replace_quote($_POST['riwayat_penyakit']); 
$riwayat_penyakit_keluarga = replace_quote($_POST['riwayat_penyakit_keluarga']); 
$genogram = '';//$_POST['genogram']); 
$tekanan_darah = replace_quote($_POST['tekanan_darah']); 
$frekuensi_nafas = replace_quote($_POST['frekuensi_nafas']); 
$suhu_tubuh = replace_quote($_POST['suhu_tubuh']); 
$frekuensi_nadi = replace_quote($_POST['frekuensi_nadi']); 
$berat_badan = replace_quote($_POST['berat_badan']); 
$tinggi_badan = replace_quote($_POST['tinggi_badan']); 
$pemeriksaan_fisik_terkait_keluhan = replace_quote($_POST['pemeriksaan_fisik_terkait_keluhan']); 
$hubungan_keluarga = '';
if(isset($_POST['hubungan_keluarga'])) $hubungan_keluarga = $_POST['hubungan_keluarga']; 
$status_psikologis = '';
if(isset($_POST['status_psikologis'])) $status_psikologis = $_POST['status_psikologis']; 
$keterangan_status_psikologis = replace_quote($_POST['keterangan_status_psikologis']); 
$penurunan_berat_badan = '';
if(isset($_POST['penurunan_berat_badan'])) $penurunan_berat_badan = $_POST['penurunan_berat_badan']; 
$tidak_nafsu_makan = '';
if(isset($_POST['tidak_nafsu_makan'])) $tidak_nafsu_makan = $_POST['tidak_nafsu_makan']; 
$diagnosis_khusus = '';
if(isset($_POST['diagnosis_khusus'])) $diagnosis_khusus = $_POST['diagnosis_khusus']; 
$keterangan_diagnosis_khusus = replace_quote($_POST['keterangan_diagnosis_khusus']);
$status_fungsional = '';
if(isset($_POST['status_fungsional'])) $status_fungsional = $_POST['status_fungsional'];
$keterangan_status_fungsional = replace_quote($_POST['keterangan_status_fungsional']);
$cara_berjalan = '';
if(isset($_POST['cara_berjalan'])) $cara_berjalan = $_POST['cara_berjalan'];
$cara_duduk = '';
if(isset($_POST['cara_duduk'])) $cara_duduk = $_POST['cara_duduk'];
$nyeri = '';
if(isset($_POST['nyeri'])) $nyeri = $_POST['nyeri'];
$skala_nyeri = '';
if(isset($_POST['skala_nyeri'])) $skala_nyeri = $_POST['skala_nyeri'];
$lokasi_nyeri = replace_quote($_POST['lokasi_nyeri']);
$durasi_nyeri = '';
$frekuensi_nyeri = replace_quote($_POST['frekuensi_nyeri']);
$pemicu_nyeri = replace_quote($_POST['pemicu_nyeri']);
$kualitas_nyeri = replace_quote($_POST['kualitas_nyeri']);
$nyeri_hilang = '';
if(isset($_POST['nyeri_hilang'])) $nyeri_hilang = $_POST['nyeri_hilang'];
$keterangan_nyeri_hilang = replace_quote($_POST['keterangan_nyeri_hilang']);

$status_bunuh_diri = replace_quote($_POST['status_bunuh_diri']);
$diagnosis_khusus_dm = '';
if(isset($_POST['diagnosis_khusus_dm'])) $diagnosis_khusus_dm = $_POST['diagnosis_khusus_dm'];
$diagnosis_khusus_kemoterapi = '';
if(isset($_POST['diagnosis_khusus_kemoterapi'])) $diagnosis_khusus_kemoterapi = $_POST['diagnosis_khusus_kemoterapi'];
$diagnosis_khusus_hemodialisa = '';
if(isset($_POST['diagnosis_khusus_hemodialisa'])) $diagnosis_khusus_hemodialisa = $_POST['diagnosis_khusus_hemodialisa'];
$diagnosis_khusus_geriatri = '';
if(isset($_POST['diagnosis_khusus_geriatri'])) $diagnosis_khusus_geriatri = $_POST['diagnosis_khusus_geriatri'];
$diagnosis_khusus_imunitas = '';
if(isset($_POST['diagnosis_khusus_imunitas'])) $diagnosis_khusus_imunitas = $_POST['diagnosis_khusus_imunitas'];
$diagnosis_khusus_lain = '';
if(isset($_POST['diagnosis_khusus_lain'])) $diagnosis_khusus_lain = $_POST['diagnosis_khusus_lain'];
$keterangan_status_fungsional_ketergantungan = replace_quote($_POST['keterangan_status_fungsional_ketergantungan']);

$resiko_jatuh = '';
if(isset($_POST['resiko_jatuh'])) $resiko_jatuh = $_POST['resiko_jatuh'];
$keterangan_resiko_jatuh = replace_quote($_POST['keterangan_resiko_jatuh']);
$status_nyeri_hilang = '';
if(isset($_POST['status_nyeri_hilang'])) $status_nyeri_hilang = $_POST['status_nyeri_hilang'];
$keterangan_status_nyeri_hilang = replace_quote($_POST['keterangan_status_nyeri_hilang']);

$riwayat_alergi_obat = replace_quote($_POST['riwayat_alergi_obat']);
$diagnosa_keperawatan = replace_quote($_POST['diagnosa_keperawatan']);
$rencana_keperawatan = replace_quote($_POST['rencana_keperawatan']);
$implementasi_keperawatan = replace_quote($_POST['implementasi_keperawatan']);
$evaluasi_keperawatan = replace_quote($_POST['evaluasi_keperawatan']);

$st_selesai = 'NULL';
if(isset($_POST['selesai'])) $st_selesai = '"1"';

$st_save = true;
if(!isPerawat($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])) $st_save = false;
if($st_save){
	
	if(empty($jns_order)){

		if(!empty($_POST['idx_askep'])){
			mysql_query('UPDATE t_irja_askep SET KELUHAN_UTAMA = "' . $keluhan_utama . '",
				RIWAYAT_PENYAKIT = "' . $riwayat_penyakit . '",RIWAYAT_PENYAKIT_KELUARGA = "' . $riwayat_penyakit_keluarga . '",
				GENOGRAM = "' . $genogram . '",TEKANAN_DARAH = "' . $tekanan_darah . '",FREKUENSI_NAFAS = "' . $frekuensi_nafas . '",
				SUHU_TUBUH = "' . $suhu_tubuh . '",FREKUENSI_NADI = "' . $frekuensi_nadi . '",BERAT_BADAN = "' . $berat_badan . '",
				TINGGI_BADAN = "' . $tinggi_badan . '",PEMERIKSA_FISIK_TERKAIT_KELUHAN = "' . $pemeriksaan_fisik_terkait_keluhan . '",
				HUBUNGAN_KELUARGA = "' . $hubungan_keluarga . '",STATUS_PSIKOLOGIS = "' . $status_psikologis . '",
				KETERANGAN_STATUS_PSIKOLOGIS = "' . $keterangan_status_psikologis . '",PENURUNAN_BERAT_BADAN = "' . $penurunan_berat_badan . '",
				TIDAK_NAFSU_MAKAN = "' . $tidak_nafsu_makan . '",DIAGNOSIS_KHUSUS = "' . $diagnosis_khusus . '",
				KETERANGAN_DIAGNOSIS_KHUSUS = "' . $keterangan_diagnosis_khusus . '",STATUS_FUNGSIONAL = "' . $status_fungsional . '",
				KETERANGAN_STATUS_FUNGSIONAL = "' . $keterangan_status_fungsional . '",CARA_BERJALAN = "' . $cara_berjalan . '",
				CARA_DUDUK = "' . $cara_duduk . '",NYERI = "' . $nyeri . '",SKALA_NYERI = "' . $skala_nyeri . '",
				LOKASI_NYERI = "' . $lokasi_nyeri . '",DURASI_NYERI = "' . $durasi_nyeri . '",FREKUENSI_NYERI = "' . $frekuensi_nyeri . '",
				NYERI_HILANG = "' . $nyeri_hilang . '",KETERANGAN_NYERI_HILANG = "' . $keterangan_nyeri_hilang . '",
				PEMICU_NYERI = "' . $pemicu_nyeri . '",KUALITAS_NYERI = "' . $kualitas_nyeri . '",
				USER_KLINIK = "' . $user_name . '",
				ST_SELESAI = ' . $st_selesai . ',
				STATUS_PSIKOLOGIS_BUNUH_DIRI = "' . $status_bunuh_diri . '",
				DIAGNOSA_KHUSUS_DM = "' . $diagnosis_khusus_dm . '",
				DIAGNOSA_KHUSUS_KEMOTERAPI = "' . $diagnosis_khusus_kemoterapi . '",
				DIAGNOSA_KHUSUS_HEMODIALISA = "' . $diagnosis_khusus_hemodialisa . '",
				DIAGNOSA_KHUSUS_GERIATRI = "' . $diagnosis_khusus_geriatri . '",
				DIAGNOSA_KHUSUS_IMUNITAS = "' . $diagnosis_khusus_imunitas . '",
				DIAGNOSA_KHUSUS_LAIN = "' . $diagnosis_khusus_lain . '",
				KETERANGAN_STATUS_FUNGSIONAL_KETERGANTUNGAN = "' . $keterangan_status_fungsional_ketergantungan . '",
				RESIKO_JATUH = "' . $resiko_jatuh . '",
				KETERANGAN_RESIKO_JATUH = "' . $keterangan_resiko_jatuh . '",
				STATUS_NYERI_HILANG = "' . $status_nyeri_hilang . '",
				KETERANGAN_STATUS_NYERI_HILANG = "' . $keterangan_status_nyeri_hilang . '",
				RIWAYAT_ALERGI_OBAT = "' . $riwayat_alergi_obat . '",
				DIAGNOSA_KEPERAWATAN = "' . $diagnosa_keperawatan . '",
				RENCANA_KEPERAWATAN = "' . $rencana_keperawatan . '",
				IMPELEMENTASI_KEPERAWATAN = "' . $implementasi_keperawatan . '",
				EVALUASI_KEPERAWATAN = "' . $evaluasi_keperawatan . '",
				TGL_ASSESMENT = NOW(),
				PEGAWAI_ID = "' . $_SESSION['SES_SIMRS_PEGAWAI_ID'] . '",
				ST_CREATE_ERM = NULL
				WHERE IRJA_ASKEP_ID = "' . $irja_id . '"') or die(mysql_error());
		}else{
			mysql_query('INSERT INTO t_irja_askep(IRJA_ASKEP_ID,KELUHAN_UTAMA,RIWAYAT_PENYAKIT,RIWAYAT_PENYAKIT_KELUARGA,
					GENOGRAM,TEKANAN_DARAH,FREKUENSI_NAFAS,SUHU_TUBUH,FREKUENSI_NADI,BERAT_BADAN,
					TINGGI_BADAN,PEMERIKSA_FISIK_TERKAIT_KELUHAN,HUBUNGAN_KELUARGA,
					STATUS_PSIKOLOGIS,KETERANGAN_STATUS_PSIKOLOGIS,PENURUNAN_BERAT_BADAN,TIDAK_NAFSU_MAKAN,
					DIAGNOSIS_KHUSUS,KETERANGAN_DIAGNOSIS_KHUSUS,STATUS_FUNGSIONAL,KETERANGAN_STATUS_FUNGSIONAL,
					CARA_BERJALAN,CARA_DUDUK,NYERI,SKALA_NYERI,LOKASI_NYERI,DURASI_NYERI,FREKUENSI_NYERI,
					NYERI_HILANG,KETERANGAN_NYERI_HILANG,USER_KLINIK,ST_SELESAI,STATUS_PSIKOLOGIS_BUNUH_DIRI,
					DIAGNOSA_KHUSUS_DM,DIAGNOSA_KHUSUS_KEMOTERAPI,DIAGNOSA_KHUSUS_HEMODIALISA,
					DIAGNOSA_KHUSUS_GERIATRI,DIAGNOSA_KHUSUS_IMUNITAS,DIAGNOSA_KHUSUS_LAIN,KETERANGAN_STATUS_FUNGSIONAL_KETERGANTUNGAN,
					RESIKO_JATUH,KETERANGAN_RESIKO_JATUH,
					STATUS_NYERI_HILANG,KETERANGAN_STATUS_NYERI_HILANG,RIWAYAT_ALERGI_OBAT,
					DIAGNOSA_KEPERAWATAN,RENCANA_KEPERAWATAN,IMPELEMENTASI_KEPERAWATAN,EVALUASI_KEPERAWATAN,
					TGL_ASSESMENT,PEMICU_NYERI,KUALITAS_NYERI,PEGAWAI_ID)
					VALUES("' . $irja_id . '",
					"' . $keluhan_utama . '","' . $riwayat_penyakit . '","' . $riwayat_penyakit_keluarga . '",
					"' . $genogram . '","' . $tekanan_darah . '","' . $frekuensi_nafas . '","' . $suhu_tubuh . '",
					"' . $frekuensi_nadi . '","' . $berat_badan . '","' . $tinggi_badan . '","' . $pemeriksaan_fisik_terkait_keluhan . '",
					"' . $hubungan_keluarga . '","' . $status_psikologis . '","' . $keterangan_status_psikologis . '",
					"' . $penurunan_berat_badan . '","' . $tidak_nafsu_makan . '","' . $diagnosis_khusus . '",
					"' . $keterangan_diagnosis_khusus . '","' . $status_fungsional . '","' . $keterangan_status_fungsional . '",
					"' . $cara_berjalan . '","' . $cara_duduk . '","' . $nyeri . '","' . $skala_nyeri . '",
					"' . $lokasi_nyeri . '","' . $durasi_nyeri . '","' . $frekuensi_nyeri . '",
					"' . $nyeri_hilang . '","' . $keterangan_nyeri_hilang . '","' . $user_name . '",' . $st_selesai .',
					"' . $status_bunuh_diri . '","' . $diagnosis_khusus_dm . '","' . $diagnosis_khusus_kemoterapi . '","' . $diagnosis_khusus_hemodialisa . '",
					"' . $diagnosis_khusus_geriatri . '","' . $diagnosis_khusus_imunitas . '","' . $diagnosis_khusus_lain . '",
					"' . $keterangan_status_fungsional_ketergantungan . '",
					"' . $resiko_jatuh . '","' . $keterangan_resiko_jatuh . '",
					"' . $status_nyeri_hilang . '","' . $keterangan_status_nyeri_hilang . '",
					"' . $riwayat_alergi_obat . '","' . $diagnosa_keperawatan . '",
					"' . $rencana_keperawatan . '","' . $implementasi_keperawatan . '",
					"' . $evaluasi_keperawatan . '",NOW(),"' . $pemicu_nyeri . '","' . $kualitas_nyeri . '",
					"' . $_SESSION['SES_SIMRS_PEGAWAI_ID'] . '")') or die(mysql_error());
		}
	}else{
		if(!empty($_POST['idx_askep'])){
			mysql_query('UPDATE t_hemodialisa_askep SET KELUHAN_UTAMA = "' . $keluhan_utama . '",
				RIWAYAT_PENYAKIT = "' . $riwayat_penyakit . '",RIWAYAT_PENYAKIT_KELUARGA = "' . $riwayat_penyakit_keluarga . '",
				GENOGRAM = "' . $genogram . '",TEKANAN_DARAH = "' . $tekanan_darah . '",FREKUENSI_NAFAS = "' . $frekuensi_nafas . '",
				SUHU_TUBUH = "' . $suhu_tubuh . '",FREKUENSI_NADI = "' . $frekuensi_nadi . '",BERAT_BADAN = "' . $berat_badan . '",
				TINGGI_BADAN = "' . $tinggi_badan . '",PEMERIKSA_FISIK_TERKAIT_KELUHAN = "' . $pemeriksaan_fisik_terkait_keluhan . '",
				HUBUNGAN_KELUARGA = "' . $hubungan_keluarga . '",STATUS_PSIKOLOGIS = "' . $status_psikologis . '",
				KETERANGAN_STATUS_PSIKOLOGIS = "' . $keterangan_status_psikologis . '",PENURUNAN_BERAT_BADAN = "' . $penurunan_berat_badan . '",
				TIDAK_NAFSU_MAKAN = "' . $tidak_nafsu_makan . '",DIAGNOSIS_KHUSUS = "' . $diagnosis_khusus . '",
				KETERANGAN_DIAGNOSIS_KHUSUS = "' . $keterangan_diagnosis_khusus . '",STATUS_FUNGSIONAL = "' . $status_fungsional . '",
				KETERANGAN_STATUS_FUNGSIONAL = "' . $keterangan_status_fungsional . '",CARA_BERJALAN = "' . $cara_berjalan . '",
				CARA_DUDUK = "' . $cara_duduk . '",NYERI = "' . $nyeri . '",SKALA_NYERI = "' . $skala_nyeri . '",
				LOKASI_NYERI = "' . $lokasi_nyeri . '",DURASI_NYERI = "' . $durasi_nyeri . '",FREKUENSI_NYERI = "' . $frekuensi_nyeri . '",
				NYERI_HILANG = "' . $nyeri_hilang . '",KETERANGAN_NYERI_HILANG = "' . $keterangan_nyeri_hilang . '",
				PEMICU_NYERI = "' . $pemicu_nyeri . '",KUALITAS_NYERI = "' . $kualitas_nyeri . '",
				USER_KLINIK = "' . $user_name . '",
				ST_SELESAI = ' . $st_selesai . ',
				STATUS_PSIKOLOGIS_BUNUH_DIRI = "' . $status_bunuh_diri . '",
				DIAGNOSA_KHUSUS_DM = "' . $diagnosis_khusus_dm . '",
				DIAGNOSA_KHUSUS_KEMOTERAPI = "' . $diagnosis_khusus_kemoterapi . '",
				DIAGNOSA_KHUSUS_HEMODIALISA = "' . $diagnosis_khusus_hemodialisa . '",
				DIAGNOSA_KHUSUS_GERIATRI = "' . $diagnosis_khusus_geriatri . '",
				DIAGNOSA_KHUSUS_IMUNITAS = "' . $diagnosis_khusus_imunitas . '",
				DIAGNOSA_KHUSUS_LAIN = "' . $diagnosis_khusus_lain . '",
				KETERANGAN_STATUS_FUNGSIONAL_KETERGANTUNGAN = "' . $keterangan_status_fungsional_ketergantungan . '",
				RESIKO_JATUH = "' . $resiko_jatuh . '",
				KETERANGAN_RESIKO_JATUH = "' . $keterangan_resiko_jatuh . '",
				STATUS_NYERI_HILANG = "' . $status_nyeri_hilang . '",
				KETERANGAN_STATUS_NYERI_HILANG = "' . $keterangan_status_nyeri_hilang . '",
				RIWAYAT_ALERGI_OBAT = "' . $riwayat_alergi_obat . '",
				DIAGNOSA_KEPERAWATAN = "' . $diagnosa_keperawatan . '",
				RENCANA_KEPERAWATAN = "' . $rencana_keperawatan . '",
				IMPELEMENTASI_KEPERAWATAN = "' . $implementasi_keperawatan . '",
				EVALUASI_KEPERAWATAN = "' . $evaluasi_keperawatan . '",
				TGL_ASSESMENT = NOW(),
				PEGAWAI_ID = "' . $_SESSION['SES_SIMRS_PEGAWAI_ID'] . '",
				ST_CREATE_ERM = NULL
				WHERE HEMODIALISA_ASKEP_ID = "' . $irja_id . '"') or die(mysql_error());
		}else{
			mysql_query('INSERT INTO t_hemodialisa_askep(HEMODIALISA_ASKEP_ID,KELUHAN_UTAMA,RIWAYAT_PENYAKIT,RIWAYAT_PENYAKIT_KELUARGA,
					GENOGRAM,TEKANAN_DARAH,FREKUENSI_NAFAS,SUHU_TUBUH,FREKUENSI_NADI,BERAT_BADAN,
					TINGGI_BADAN,PEMERIKSA_FISIK_TERKAIT_KELUHAN,HUBUNGAN_KELUARGA,
					STATUS_PSIKOLOGIS,KETERANGAN_STATUS_PSIKOLOGIS,PENURUNAN_BERAT_BADAN,TIDAK_NAFSU_MAKAN,
					DIAGNOSIS_KHUSUS,KETERANGAN_DIAGNOSIS_KHUSUS,STATUS_FUNGSIONAL,KETERANGAN_STATUS_FUNGSIONAL,
					CARA_BERJALAN,CARA_DUDUK,NYERI,SKALA_NYERI,LOKASI_NYERI,DURASI_NYERI,FREKUENSI_NYERI,
					NYERI_HILANG,KETERANGAN_NYERI_HILANG,USER_KLINIK,ST_SELESAI,STATUS_PSIKOLOGIS_BUNUH_DIRI,
					DIAGNOSA_KHUSUS_DM,DIAGNOSA_KHUSUS_KEMOTERAPI,DIAGNOSA_KHUSUS_HEMODIALISA,
					DIAGNOSA_KHUSUS_GERIATRI,DIAGNOSA_KHUSUS_IMUNITAS,DIAGNOSA_KHUSUS_LAIN,KETERANGAN_STATUS_FUNGSIONAL_KETERGANTUNGAN,
					RESIKO_JATUH,KETERANGAN_RESIKO_JATUH,
					STATUS_NYERI_HILANG,KETERANGAN_STATUS_NYERI_HILANG,RIWAYAT_ALERGI_OBAT,
					DIAGNOSA_KEPERAWATAN,RENCANA_KEPERAWATAN,IMPELEMENTASI_KEPERAWATAN,EVALUASI_KEPERAWATAN,
					TGL_ASSESMENT,PEMICU_NYERI,KUALITAS_NYERI,PEGAWAI_ID)
					VALUES("' . $irja_id . '",
					"' . $keluhan_utama . '","' . $riwayat_penyakit . '","' . $riwayat_penyakit_keluarga . '",
					"' . $genogram . '","' . $tekanan_darah . '","' . $frekuensi_nafas . '","' . $suhu_tubuh . '",
					"' . $frekuensi_nadi . '","' . $berat_badan . '","' . $tinggi_badan . '","' . $pemeriksaan_fisik_terkait_keluhan . '",
					"' . $hubungan_keluarga . '","' . $status_psikologis . '","' . $keterangan_status_psikologis . '",
					"' . $penurunan_berat_badan . '","' . $tidak_nafsu_makan . '","' . $diagnosis_khusus . '",
					"' . $keterangan_diagnosis_khusus . '","' . $status_fungsional . '","' . $keterangan_status_fungsional . '",
					"' . $cara_berjalan . '","' . $cara_duduk . '","' . $nyeri . '","' . $skala_nyeri . '",
					"' . $lokasi_nyeri . '","' . $durasi_nyeri . '","' . $frekuensi_nyeri . '",
					"' . $nyeri_hilang . '","' . $keterangan_nyeri_hilang . '","' . $user_name . '",' . $st_selesai .',
					"' . $status_bunuh_diri . '","' . $diagnosis_khusus_dm . '","' . $diagnosis_khusus_kemoterapi . '","' . $diagnosis_khusus_hemodialisa . '",
					"' . $diagnosis_khusus_geriatri . '","' . $diagnosis_khusus_imunitas . '","' . $diagnosis_khusus_lain . '",
					"' . $keterangan_status_fungsional_ketergantungan . '",
					"' . $resiko_jatuh . '","' . $keterangan_resiko_jatuh . '",
					"' . $status_nyeri_hilang . '","' . $keterangan_status_nyeri_hilang . '",
					"' . $riwayat_alergi_obat . '","' . $diagnosa_keperawatan . '",
					"' . $rencana_keperawatan . '","' . $implementasi_keperawatan . '",
					"' . $evaluasi_keperawatan . '",NOW(),"' . $pemicu_nyeri . '","' . $kualitas_nyeri . '",
					"' . $_SESSION['SES_SIMRS_PEGAWAI_ID'] . '")') or die(mysql_error());
		}
		
	}
	
	/*
	include('lib/vendor/autoload.php');
	include('lib/html2openxml/HTMLtoOpenXML.php');
	include('edoc_rekammedik/new/erm_create_pengkajian_awal_keperawatan_hemodialisa.php');
	erm_pengkajian_awal_keperawatan_hemodialisa($irja_id,$_POST['ls_assesment'],$_POST['tgl_skr'],$_POST['ls_final'],$jns_order,$_POST['idxord']);
	*/
}else{
	$msg_info = 'Harus Oleh Perawat/ Bidan.';
}
?>	
<script language="JavaScript" >
	alert('Simpan Data Pengkajian Keperawatan Berhasil.');
	window.location = "<?php echo currentUrl(); ?>";
</script>	