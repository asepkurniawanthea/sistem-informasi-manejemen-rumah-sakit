<?php
$irja_id = $_GET['idx'];

if (isset($_POST['irja_id']))
    include('klinik/klinik_save_edukasi_pasien.php');

$qry_edukasi_pasien = 'SELECT IRJA_EDUKASI_ID,HAMBATAN_TIDAKADA,HAMBATAN_PENGLIHATAN,HAMBATAN_PENDENGARAN,HAMBATAN_EMOSIONAL,
					HAMBATAN_JASMANI,HAMBATAN_KEPERCAYAAN,HAMBATAN_BAHASA,HAMBATAN_PENDIDIKAN,HAMBATAN_MOTIVASI,HAMBATAN_PROSES_FIKIR,
					HAMBATAN_BUDAYA,HAMBATAN_LAINNYA,HAMBATAN_LAINNYA_KET,BICARA,AGAMA,AGAMA_KET,BAHASA_INDONESIA,BAHASA_INDONESIA_AKTIF_PASIF,
					BAHASA_DAERAH,BAHASA_DAERAH_KET,BAHASA_INGGRIS,BAHASA_INGGRIS_AKTIF_PASIF,BAHASA_LAINNYA,BAHASA_LAINNYA_KET,
					BUDAYA_PANTANGAN_MAKAN,BUDAYA_PANTANGAN_MAKAN_KET,BUDAYA_JAM_MAKAN,BUDAYA_JAM_MAKAN_KET,BUDAYA_LAINNYA,
					BUDAYA_LAINNYA_KET,BUDAYA_TIDAKADA,PENDIDIKAN,PENERJEMAH,PENERJEMAH_KET,BAHASA_ISARAT,BAHASA_ISARAT_KET,
					EMOSIONAL,EMOSIONAL_KET,MOTIVASI,MOTIVASI_KET,PEMBELAJARAN_PENYAKIT,PEMBELAJARAN_PENGOBATAN,PEMBELAJARAN_DIIT,
					PEMBELAJARAN_TERAPI,PEMBELAJARAN_ALATMEDIS,PEMBELAJARAN_NYERI,PEMBELAJARAN_REHABILITASI,PEMBELAJARAN_PERAWATAN,
					PEMBELAJARAN_LAINNYA,PEMBELAJARAN_LAINNYA_KET
					FROM t_irja_edukasi
					WHERE IRJA_EDUKASI_ID = "' . $irja_id . '"';
$get_edukasi_pasien = mysql_query($qry_edukasi_pasien) or die(mysql_error());
$dat_edukasi_pasien = mysql_fetch_assoc($get_edukasi_pasien);

$irja_edukasi_id = $dat_edukasi_pasien['IRJA_EDUKASI_ID'];
$hambatan_tidakada = $dat_edukasi_pasien['HAMBATAN_TIDAKADA'];
$hambatan_penglihatan = $dat_edukasi_pasien['HAMBATAN_PENGLIHATAN'];
$hambatan_pendengaran = $dat_edukasi_pasien['HAMBATAN_PENDENGARAN'];
$hambatan_emosional = $dat_edukasi_pasien['HAMBATAN_EMOSIONAL'];
$hambatan_jasmani = $dat_edukasi_pasien['HAMBATAN_JASMANI'];
$hambatan_kepercayaan = $dat_edukasi_pasien['HAMBATAN_KEPERCAYAAN'];
$hambatan_bahasa = $dat_edukasi_pasien['HAMBATAN_BAHASA'];
$hambatan_pendidikan = $dat_edukasi_pasien['HAMBATAN_PENDIDIKAN'];
$hambatan_motivasi = $dat_edukasi_pasien['HAMBATAN_MOTIVASI'];
$hambatan_proses_fikir = $dat_edukasi_pasien['HAMBATAN_PROSES_FIKIR'];
$hambatan_budaya = $dat_edukasi_pasien['HAMBATAN_BUDAYA'];
$hambatan_lainnya = $dat_edukasi_pasien['HAMBATAN_LAINNYA'];
$hambatan_lainnya_ket = $dat_edukasi_pasien['HAMBATAN_LAINNYA_KET'];
$bicara = $dat_edukasi_pasien['BICARA'];
$agama = $dat_edukasi_pasien['AGAMA'];
$agama_ket = $dat_edukasi_pasien['AGAMA_KET'];
$bahasa_indonesia = $dat_edukasi_pasien['BAHASA_INDONESIA'];
$bahasa_indonesia_aktif_pasif = $dat_edukasi_pasien['BAHASA_INDONESIA_AKTIF_PASIF'];
$bahasa_daerah = $dat_edukasi_pasien['BAHASA_DAERAH'];
$bahasa_daerah_ket = $dat_edukasi_pasien['BAHASA_DAERAH_KET'];
$bahasa_inggris = $dat_edukasi_pasien['BAHASA_INGGRIS'];
$bahasa_inggris_aktif_pasif = $dat_edukasi_pasien['BAHASA_INGGRIS_AKTIF_PASIF'];
$bahasa_lainnya = $dat_edukasi_pasien['BAHASA_LAINNYA'];
$bahasa_lainnya_ket = $dat_edukasi_pasien['BAHASA_LAINNYA_KET'];
$budaya_pantangan_makan = $dat_edukasi_pasien['BUDAYA_PANTANGAN_MAKAN'];
$budaya_pantangan_makan_ket = $dat_edukasi_pasien['BUDAYA_PANTANGAN_MAKAN_KET'];
$budaya_jam_makan = $dat_edukasi_pasien['BUDAYA_JAM_MAKAN'];
$budaya_jam_makan_ket = $dat_edukasi_pasien['BUDAYA_JAM_MAKAN_KET'];
$budaya_lainnya = $dat_edukasi_pasien['BUDAYA_LAINNYA'];
$budaya_lainnya_ket = $dat_edukasi_pasien['BUDAYA_LAINNYA_KET'];
$budaya_tidakada = $dat_edukasi_pasien['BUDAYA_TIDAKADA'];
$pendidikan = $dat_edukasi_pasien['PENDIDIKAN'];
$penerjemah = $dat_edukasi_pasien['PENERJEMAH'];
$penerjemah_ket = $dat_edukasi_pasien['PENERJEMAH_KET'];
$bahasa_isarat = $dat_edukasi_pasien['BAHASA_ISARAT'];
$bahasa_isarat_ket = $dat_edukasi_pasien['BAHASA_ISARAT_KET'];
$emosional = $dat_edukasi_pasien['EMOSIONAL'];
$emosional_ket = $dat_edukasi_pasien['EMOSIONAL_KET'];
$motivasi = $dat_edukasi_pasien['MOTIVASI'];
$motivasi_ket = $dat_edukasi_pasien['MOTIVASI_KET'];
$pembelajaran_penyakit = $dat_edukasi_pasien['PEMBELAJARAN_PENYAKIT'];
$pembelajaran_pengobatan = $dat_edukasi_pasien['PEMBELAJARAN_PENGOBATAN'];
$pembelajaran_diit = $dat_edukasi_pasien['PEMBELAJARAN_DIIT'];
$pembelajaran_terapi = $dat_edukasi_pasien['PEMBELAJARAN_TERAPI'];
$pembelajaran_alatmedis = $dat_edukasi_pasien['PEMBELAJARAN_ALATMEDIS'];
$pembelajaran_nyeri = $dat_edukasi_pasien['PEMBELAJARAN_NYERI'];
$pembelajaran_rehabilitasi = $dat_edukasi_pasien['PEMBELAJARAN_REHABILITASI'];
$pembelajaran_perawatan = $dat_edukasi_pasien['PEMBELAJARAN_PERAWATAN'];
$pembelajaran_lainnya = $dat_edukasi_pasien['PEMBELAJARAN_LAINNYA'];
$pembelajaran_lainnya_ket = $dat_edukasi_pasien['PEMBELAJARAN_LAINNYA_KET'];

$ruang_arr = array();
$ruang_arr_id = array();
$qry_ruang = 'SELECT m_unit.UNIT_ID,m_unit.NAMA_UNIT
				FROM m_unit
				WHERE m_unit.IRJA IS NOT NULL';
$get_ruang = mysql_query($qry_ruang) or die(mysql_error());				
while($dat_ruang = mysql_fetch_array($get_ruang)){
	$ruang_arr[] = $dat_ruang['NAMA_UNIT'];
	$ruang_arr_id[] = $dat_ruang['UNIT_ID'];
}

$jam = date('H');
$menit = date('i');

$isi_edu_arr[1] = 'Edukasi tentang pemasangan gelang identifikasi';
$isi_edu_arr[2] = 'Edukasi tentang etika batuk, alergi, resiko jatuh, dan keselamatan pasien';
$isi_edu_arr[3] = 'Informasi tentang penyimpanan barang berharga milik pasien';
$isi_edu_arr[4] = 'Cuci tangan';
$isi_edu_arr[5] = 'Personal hygiene';
$isi_edu_arr[6] = 'Informasi tentang pelayanan kerohanian';
$isi_edu_arr[7] = 'Informasi tentang hak pasien dan keluarga untuk berpatisipasi dalam rencana pelayanan dan pengobatan';
$isi_edu_arr[8] = 'Informasi tentang hak pasien dan keluarga untuk berpatisipasi dalam keputusan pengobatan';
$isi_edu_arr[9] = 'Informasi tentang cara penyampaian keluhan dan hak dalam ikut berpartisipasi menyelesaikan masalahnya';
$isi_edu_arr[10] = 'Informasi tentang kerahasiaan informasi pasien di rekam medis dan pembukaannya (pelepasan informasi)';
$isi_edu_arr[11] = 'Manajemen nyeri';
$isi_edu_arr[12] = 'Kondisi kesehatan & diagnosis pasti';
$isi_edu_arr[13] = 'Informasi tentang Second Opinion';
$isi_edu_arr[14] = 'Informasi kepada pasien dan keluarga untuk diperbolehkan menolak pengobatan';
$isi_edu_arr[15] = 'Informasi tentang alternatif pelayanan kesehatan';
$isi_edu_arr[16] = 'Informasi tentang hasil pelayanan dan pengobatan';
$isi_edu_arr[17] = 'Informasi tentang hasil yang tidak diantisipasi dalam pelayanan dan pengobatan';
$isi_edu_arr[18] = 'Informasi tentang pemeriksaan penunjang diluar RSKS terkait hubungan, jenis dan kualitas pemeriksaan di tempat rujukan';
$isi_edu_arr[19] = 'Keamanan dan efektifitas penggunaan peralatan medis';
$isi_edu_arr[20] = 'Informed Consent tentang';
$isi_edu_arr[21] = 'Informed Consent tentang';
$isi_edu_arr[22] = 'Penggunaan obat-obatan, potensi efek samping obat dan pencegahan terhadap potensi interaksi obat OTC<br >(over the counter) dan obat- obatan yang dibawa pulang serta penyimpanannya';
$isi_edu_arr[23] = 'Informasi dan edukasi tentang diit dan/ atau pembatasan diit pasien';
$isi_edu_arr[24] = 'Tehnik Rehabilitasi tentang';
$isi_edu_arr[25] = 'Perawatan luka';
$isi_edu_arr[26] = 'Informasi dan edukasi tentang risiko, manfaat dan risiko anestesi oleh dokter anestesi';
$isi_edu_arr[27] = 'Informasi dan edukasi tentang risiko, manfaat dan risiko prosedur bedah yang direncanakan yang dilakukan oleh dokter bedah';
$isi_edu_arr[28] = 'Discharge planning';
$isi_edu_arr[29] = 'Rujukan ke komunitas';
$isi_edu_arr[30] = '';
$isi_edu_arr[31] = '';
$isi_edu_arr[32] = '';
$isi_edu_arr[33] = '';
$isi_edu_arr[34] = '';
$isi_edu_arr[35] = '';
$isi_edu_arr[36] = '';
$isi_edu_arr[37] = '';
$isi_edu_arr[38] = '';
$isi_edu_arr[39] = '';
$isi_edu_arr[40] = '';
$isi_edu_arr[41] = '';

$tanggal = array();
$isi_edukasi = array();
$isi_edukasi_des = array();
$ruangan = array();
$pemahaman = array();
$jam_1 = array();
$menit_1 = array();
$jam_2 = array();
$menit_2 = array();
$profesi = array();
$metode = array();
$penerima = array();
$evaluasi = array();
$pemberi_edukasi = array();
$pemberi_edukasi_2 = array();
$penerima_edukasi = array();
$penerima_edukasi_2 = array();

$qry_edukasi_detail = 'SELECT IRJA_EDUKASI_ID,ISI_EDUKASI_ID,DATE_FORMAT(TANGGAL,"%d/%m/%Y") AS TANGGAL,RUANGAN,TINGKAT_PEMAHAMAN,JAM_1,JAM_2,
					PROFESI,METODE,PENERIMA_PENDIDIKAN,EVALUASI_RESPONSE,PEMBERI_EDUKASI,PENERIMA_EDUKASI,
					PEMBERI_EDUKASI_2,PENERIMA_EDUKASI_2,ISI_EDUKASI_DES
					FROM t_irja_edukasi_detail
					WHERE IRJA_EDUKASI_ID = "' . $irja_id . '"';
$get_edukasi_detail = mysql_query($qry_edukasi_detail) or die(mysql_error());
while ($dat_edukasi_detail = mysql_fetch_array($get_edukasi_detail)){
	$tanggal[$dat_edukasi_detail['ISI_EDUKASI_ID']] = $dat_edukasi_detail['TANGGAL'];
	$isi_edukasi[$dat_edukasi_detail['ISI_EDUKASI_ID']] = $dat_edukasi_detail['ISI_EDUKASI_ID'];
	$isi_edukasi_des[$dat_edukasi_detail['ISI_EDUKASI_ID']] = $dat_edukasi_detail['ISI_EDUKASI_DES'];
	$ruangan[$dat_edukasi_detail['ISI_EDUKASI_ID']] = $dat_edukasi_detail['RUANGAN'];
	$pemahaman[$dat_edukasi_detail['ISI_EDUKASI_ID']] = $dat_edukasi_detail['TINGKAT_PEMAHAMAN'];
	$jam_1_array = explode(':',$dat_edukasi_detail['JAM_1']);
	if(sizeof($jam_1_array) == 2){
		$jam_1[$dat_edukasi_detail['ISI_EDUKASI_ID']] = $jam_1_array[0];
		$menit_1[$dat_edukasi_detail['ISI_EDUKASI_ID']] = $jam_1_array[1];
	}
	$jam_2_array = explode(':',$dat_edukasi_detail['JAM_2']);
	if(sizeof($jam_2_array) == 2){	
		$jam_2[$dat_edukasi_detail['ISI_EDUKASI_ID']] = $jam_2_array[0];
		$menit_2[$dat_edukasi_detail['ISI_EDUKASI_ID']] = $jam_2_array[1];
	}	
	$profesi[$dat_edukasi_detail['ISI_EDUKASI_ID']] = $dat_edukasi_detail['PROFESI'];
	$metode[$dat_edukasi_detail['ISI_EDUKASI_ID']] = $dat_edukasi_detail['METODE'];
	$penerima[$dat_edukasi_detail['ISI_EDUKASI_ID']] = $dat_edukasi_detail['PENERIMA_PENDIDIKAN'];
	$evaluasi[$dat_edukasi_detail['ISI_EDUKASI_ID']] = $dat_edukasi_detail['EVALUASI_RESPONSE'];
	$pemberi_edukasi[$dat_edukasi_detail['ISI_EDUKASI_ID']] = $dat_edukasi_detail['PEMBERI_EDUKASI'];
	$pemberi_edukasi_2[$dat_edukasi_detail['ISI_EDUKASI_ID']] = $dat_edukasi_detail['PEMBERI_EDUKASI_2'];
	$penerima_edukasi[$dat_edukasi_detail['ISI_EDUKASI_ID']] = $dat_edukasi_detail['PENERIMA_EDUKASI'];
	$penerima_edukasi_2[$dat_edukasi_detail['ISI_EDUKASI_ID']] = $dat_edukasi_detail['PENERIMA_EDUKASI_2'];
}					
?>
<form name="formedukasi" id="formedukasi" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
	<input type="hidden" name="irja_edukasi_id" id="irja_edukasi_id" value="<?php echo $irja_edukasi_id; ?>" />
    <input type="hidden" name="nomr" id="nomr" value="<?php echo $nomr; ?>" />
<table border="0" width="80%" class="tableData">
<tr>
    <td width="250px">Hambatan Edukasi</td>
	<td>
		<input type="checkbox" name="hambatan_tidakada" id="hambatan_tidakada" value="1" <?php if($hambatan_tidakada=="1") echo 'checked="checked"'; ?> />&nbsp;Tidak ada hambatan
		<input type="checkbox" name="hambatan_penglihatan" id="hambatan_penglihatan" value="1" <?php if($hambatan_penglihatan=="1") echo 'checked="checked"'; ?> />&nbsp;Gangguan penglihatan
		<input type="checkbox" name="hambatan_pendengaran" id="hambatan_pendengaran" value="1" <?php if($hambatan_pendengaran=="1") echo 'checked="checked"'; ?> />&nbsp;Gangguan pendengaran
		<input type="checkbox" name="hambatan_emosional" id="hambatan_emosional" value="1" <?php if($hambatan_emosional=="1") echo 'checked="checked"'; ?> />&nbsp;Gangguan Emosional
		<input type="checkbox" name="hambatan_jasmani" id="hambatan_jasmani" value="1" <?php if($hambatan_jasmani=="1") echo 'checked="checked"'; ?> />&nbsp;Batasan jasmani & kognitif<br />
		<input type="checkbox" name="hambatan_kepercayaan" id="hambatan_kepercayaan" value="1" <?php if($hambatan_kepercayaan=="1") echo 'checked="checked"'; ?> />&nbsp;Kepercayaan pasien & keluarga
		<input type="checkbox" name="hambatan_bahasa" id="hambatan_bahasa" value="1" <?php if($hambatan_bahasa=="1") echo 'checked="checked"'; ?> />&nbsp;Hambatan bahasa
		<input type="checkbox" name="hambatan_pendidikan" id="hambatan_pendidikan" value="1" <?php if($hambatan_pendidikan=="1") echo 'checked="checked"'; ?> />&nbsp;Tingkat pendidikan
		<input type="checkbox" name="hambatan_motivasi" id="hambatan_motivasi" value="1" <?php if($hambatan_motivasi=="1") echo 'checked="checked"'; ?> />&nbsp;Motivasi belajar
		<input type="checkbox" name="hambatan_proses_fikir" id="hambatan_proses_fikir" value="1" <?php if($hambatan_proses_fikir=="1") echo 'checked="checked"'; ?> />&nbsp;Gangguan proses fikir<br />
		<input type="checkbox" name="hambatan_budaya" id="hambatan_budaya" value="1" <?php if($hambatan_budaya=="1") echo 'checked="checked"'; ?> />&nbsp;Perbedaan budaya
		<input type="checkbox" name="hambatan_lainnya" id="hambatan_lainnya" value="1" <?php if($hambatan_lainnya=="1") echo 'checked="checked"'; ?> />&nbsp;Lainnya <input type="text" name="hambatan_lainnya_ket" id="hambatan_lainnya_ket" value="<?php echo $hambatan_lainnya_ket; ?>" class="text_dt" size="40" />
	</td>
</tr>
<tr>
    <td>Bicara</td>
	<td><input type="radio" name="bicara" id="bicara" value="1" <?php if($bicara=="1") echo 'checked="checked"'; ?> />&nbsp;Normal
	<input type="radio" name="bicara" id="bicara2" value="2" <?php if($bicara=="2") echo 'checked="checked"'; ?> />&nbsp;Ada hambatan</td>
</tr>
<tr>
    <td>Agama</td>
	<td>
		<input type="radio" name="agama" id="agama" value="1" <?php if($agama=="1") echo 'checked="checked"'; ?> />&nbsp;Islam
		<input type="radio" name="agama" id="agama2" value="2" <?php if($agama=="2") echo 'checked="checked"'; ?> />&nbsp;Katholik
		<input type="radio" name="agama" id="agama3" value="3" <?php if($agama=="3") echo 'checked="checked"'; ?> />&nbsp;Protestan
		<input type="radio" name="agama" id="agama4" value="4" <?php if($agama=="4") echo 'checked="checked"'; ?> />&nbsp;Budha
		<input type="radio" name="agama" id="agama5" value="5" <?php if($agama=="5") echo 'checked="checked"'; ?> />&nbsp;Hindu
		<input type="radio" name="agama" id="agama6" value="6" <?php if($agama=="6") echo 'checked="checked"'; ?> />&nbsp;Lainnya <input type="text" name="agama_ket" id="agama_ket" value="<?php echo $agama_ket; ?>" class="text_dt" size="40" /></td>
</tr>
<tr>
    <td>Nilai/ budaya yang dianut</td>
	<td>
		<input type="checkbox" name="budaya_pantangan_makan" id="budaya_pantangan_makan" value="1" <?php if($budaya_pantangan_makan=="1") echo 'checked="checked"'; ?> />&nbsp;Pantangan makanan <input type="text" name="budaya_pantangan_makan_ket" id="budaya_pantangan_makan_ket" value="<?php echo $budaya_pantangan_makan_ket; ?>" class="text_dt" size="40" /><br />
		<input type="checkbox" name="budaya_jam_makan" id="budaya_jam_makan" value="1" <?php if($budaya_jam_makan=="1") echo 'checked="checked"'; ?> />&nbsp;Jam makan <input type="text" name="budaya_jam_makan_ket" id="budaya_jam_makan_ket" value="<?php echo $budaya_jam_makan_ket; ?>" class="text_dt" size="40" /><br />
		<input type="checkbox" name="budaya_lainnya" id="budaya_lainnya" value="1" <?php if($budaya_lainnya=="1") echo 'checked="checked"'; ?> />&nbsp;Lainnya <input type="text" name="budaya_lainnya_ket" id="budaya_lainnya_ket" value="<?php echo $budaya_lainnya_ket; ?>" class="text_dt" size="40" /><br />
		<input type="checkbox" name="budaya_tidakada" id="budaya_tidakada" value="1" <?php if($budaya_tidakada=="1") echo 'checked="checked"'; ?> />&nbsp;Tidak ada
		</td>
</tr>
<tr>
    <td>Bahasa sehari-hari</td>
	<td>
		<input type="checkbox" name="bahasa_indonesia" id="bahasa_indonesia" value="1" <?php if($bahasa_indonesia=="1") echo 'checked="checked"'; ?> />&nbsp;Indonesia
		<input type="radio" name="bahasa_indonesia_aktif_pasif" id="bahasa_indonesia_aktif_pasif" value="1" <?php if($bahasa_indonesia_aktif_pasif=="1") echo 'checked="checked"'; ?> />&nbsp;Aktif
		<input type="radio" name="bahasa_indonesia_aktif_pasif" id="bahasa_indonesia_aktif_pasif2" value="2" <?php if($bahasa_indonesia_aktif_pasif=="2") echo 'checked="checked"'; ?> />&nbsp;Pasif<br />
		<input type="checkbox" name="bahasa_daerah" id="bahasa_daerah" value="1" <?php if($bahasa_daerah=="1") echo 'checked="checked"'; ?> />&nbsp;Daerah <input type="text" name="bahasa_daerah_ket" id="bahasa_daerah_ket" value="<?php echo $bahasa_daerah_ket; ?>" class="text_dt" size="40" /><br />
		<input type="checkbox" name="bahasa_inggris" id="bahasa_inggris" value="1" <?php if($bahasa_inggris=="1") echo 'checked="checked"'; ?> />&nbsp;Inggris
		<input type="radio" name="bahasa_inggris_aktif_pasif" id="bahasa_inggris_aktif_pasif" value="1" <?php if($bahasa_inggris_aktif_pasif=="1") echo 'checked="checked"'; ?> />&nbsp;Aktif
		<input type="radio" name="bahasa_inggris_aktif_pasif" id="bahasa_inggris_aktif_pasif2" value="2" <?php if($bahasa_inggris_aktif_pasif=="2") echo 'checked="checked"'; ?> />&nbsp;Pasif<br />
		<input type="checkbox" name="bahasa_lainnya" id="bahasa_lainnya" value="1" <?php if($bahasa_lainnya=="1") echo 'checked="checked"'; ?> />&nbsp;Lainnya <input type="text" name="bahasa_lainnya_ket" id="bahasa_lainnya_ket" value="<?php echo $bahasa_lainnya_ket; ?>" class="text_dt" size="40" /> 
		</td>
</tr>
<tr>
    <td>Tingkat pendidikan</td>
		<td>
		<input type="radio" name="pendidikan" id="pendidikan" value="1" <?php if($pendidikan=="1") echo 'checked="checked"'; ?> />&nbsp;SD
		<input type="radio" name="pendidikan" id="pendidikan2" value="2" <?php if($pendidikan=="2") echo 'checked="checked"'; ?> />&nbsp;SMP
		<input type="radio" name="pendidikan" id="pendidikan3" value="3" <?php if($pendidikan=="3") echo 'checked="checked"'; ?> />&nbsp;SMA
		<input type="radio" name="pendidikan" id="pendidikan4" value="4" <?php if($pendidikan=="4") echo 'checked="checked"'; ?> />&nbsp;Diploma
		<input type="radio" name="pendidikan" id="pendidikan5" value="5" <?php if($pendidikan=="5") echo 'checked="checked"'; ?> />&nbsp;S1
		<input type="radio" name="pendidikan" id="pendidikan6" value="6" <?php if($pendidikan=="6") echo 'checked="checked"'; ?> />&nbsp;S2/ S3
		</td>
</tr>
<tr>
    <td>Perlu penerjemah</td>
		<td>
		<input type="radio" name="penerjemah" id="penerjemah" value="1" <?php if($penerjemah=="1") echo 'checked="checked"'; ?> />&nbsp;Tidak
		<input type="radio" name="penerjemah" id="penerjemah2" value="2" <?php if($penerjemah=="2") echo 'checked="checked"'; ?> />&nbsp;Ya <input type="text" name="penerjemah_ket" id="penerjemah_ket" value="<?php echo $penerjemah_ket; ?>" class="text_dt" size="40" />
		</td>
</tr>
<tr>
    <td>Bahasa isarat</td>
	<td>
	<input type="radio" name="bahasa_isarat" id="bahasa_isarat" value="1" <?php if($bahasa_isarat=="1") echo 'checked="checked"'; ?> />&nbsp;Tidak
	<input type="radio" name="bahasa_isarat" id="bahasa_isarat2" value="2" <?php if($bahasa_isarat=="2") echo 'checked="checked"'; ?> />&nbsp;Ya <input type="text" name="bahasa_isarat_ket" id="bahasa_isarat_ket" value="<?php echo $bahasa_isarat_ket; ?>" class="text_dt" size="40" />
	</td>
</tr>
<tr>
    <td>Hambatan emosional</td>
	<td>
	<input type="radio" name="emosional" id="emosional" value="1" <?php if($emosional=="1") echo 'checked="checked"'; ?> />&nbsp;Tidak
	<input type="radio" name="emosional" id="emosional2" value="2" <?php if($emosional=="2") echo 'checked="checked"'; ?> />&nbsp;Ya <input type="text" name="emosional_ket" id="emosional_ket" value="<?php echo $emosional_ket; ?>" class="text_dt" size="40" />
	</td>
</tr>
<tr>
    <td>Hambatan didalam motivasi</td>
	<td>
	<input type="radio" name="motivasi" id="motivasi" value="1" <?php if($motivasi=="1") echo 'checked="checked"'; ?> />&nbsp;Tidak
	<input type="radio" name="motivasi" id="motivasi2" value="2" <?php if($motivasi=="2") echo 'checked="checked"'; ?> />&nbsp;Ya <input type="text" name="motivasi_ket" id="motivasi_ket" value="<?php echo $motivasi_ket; ?>" class="text_dt" size="40" />
	</td>
</tr>
<tr>
    <td>Potensial kebutuhan pembelajaran</td>
	<td>
	<input type="checkbox" name="pembelajaran_penyakit" id="pembelajaran_penyakit" value="1" <?php if($pembelajaran_penyakit=="1") echo 'checked="checked"'; ?> />&nbsp;Proses penyakit
	<input type="checkbox" name="pembelajaran_pengobatan" id="pembelajaran_pengobatan" value="1" <?php if($pembelajaran_pengobatan=="1") echo 'checked="checked"'; ?> />&nbsp;Pengobatan/ tindakan
	<input type="checkbox" name="pembelajaran_diit" id="pembelajaran_diit" value="1" <?php if($pembelajaran_diit=="1") echo 'checked="checked"'; ?> />&nbsp;Diit & nutrisi
	<input type="checkbox" name="pembelajaran_terapi" id="pembelajaran_terapi" value="1" <?php if($pembelajaran_terapi=="1") echo 'checked="checked"'; ?> />&nbsp;Terapi/ obat/ interaksi obat
	<input type="checkbox" name="pembelajaran_alatmedis" id="pembelajaran_alatmedis" value="1" <?php if($pembelajaran_alatmedis=="1") echo 'checked="checked"'; ?> />&nbsp;Penggunaan peralatan medis<br />
	<input type="checkbox" name="pembelajaran_nyeri" id="pembelajaran_nyeri" value="1" <?php if($pembelajaran_nyeri=="1") echo 'checked="checked"'; ?> />&nbsp;Manajemen nyeri
	<input type="checkbox" name="pembelajaran_rehabilitasi" id="pembelajaran_rehabilitasi" value="1" <?php if($pembelajaran_rehabilitasi=="1") echo 'checked="checked"'; ?> />&nbsp;Tehnik rehabilitasi
	<input type="checkbox" name="pembelajaran_perawatan" id="pembelajaran_perawatan" value="1" <?php if($pembelajaran_perawatan=="1") echo 'checked="checked"'; ?> />&nbsp;Perawatan di rumah<br />
	<input type="checkbox" name="pembelajaran_lainnya" id="pembelajaran_lainnya" value="1" <?php if($pembelajaran_lainnya=="1") echo 'checked="checked"'; ?> />&nbsp;Lainnya <input type="text" name="pembelajaran_lainnya_ket" id="pembelajaran_lainnya_ket" value="<?php echo $pembelajaran_lainnya_ket; ?>" class="text_dt" size="40" />
	</td>
</tr>
</table>
<table border="0" class="tableData">
	<tr>
		<th rowspan="2" width="120px">Tanggal</th>
		<th rowspan="2">Isi Edukasi</th>
		<th colspan="3" rowspan="2">Ruangan, Tingkat Pemahaman<br />Lama Edukasi</th>
		<th rowspan="2">Profesi</th>
		<th rowspan="2">Metode</th>
		<th rowspan="2">Penerima<br />Pendidikan</th>
		<th rowspan="2">Evaluasi Response</th>
		<th colspan="2">Nama &amp; Tandatangan </th>
	</tr>
	<tr>
	  <th>Pemberi Edukasi </th>
      <th>Penerima Edukasi </th>
  </tr>
	<?php 
	$x = 1;
	while($x <= 41){
	?>
	<tr>
	  <td rowspan="2"><input type="text" name="tgl_edu_<?php echo $x; ?>" id="tgl_edu_<?php echo $x; ?>" style="width:70px;" class="text_dt" 
	  value="<?php if(isset($isi_edukasi[$x])) echo $tanggal[$x]; ?>" />
	  <img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu<?php echo $x; ?>')"/></td>
      <td rowspan="2" width="80px"><input type="checkbox" name="isi_edukasi_<?php echo $x; ?>"  
	  <?php if(isset($isi_edukasi[$x])) echo 'checked="checked"'; ?> value="<?php echo $x; ?>" />
	  <?php if(($x == 20) or ($x == 21) or ($x == 24) or ($x == 20) or ($x > 29)){ 
			if(isset($isi_edukasi[$x])){ ?>
				<br />
				<textarea name="isi_edukasi_des_<?php echo $x; ?>" style="height:50px;width:140px;" class="text_dt" ><?php echo $isi_edukasi_des[$x]; ?></textarea> 
			<?php }else{ ?>
				<br />
				<textarea name="isi_edukasi_des_<?php echo $x; ?>" style="height:50px;width:140px;" class="text_dt" ><?php echo $isi_edu_arr[$x]; ?></textarea> 
			<?php }	
	  }else{
		  echo $isi_edu_arr[$x];
	  }?>	  </td>
      <td rowspan="2"><select name="ruang_edu_<?php echo $x; ?>" class="text_dt" style="width:80px;" >
					<?php $i = 0;
					while($i < sizeof($ruang_arr)){ ?>
					<option value="<?php echo $ruang_arr_id[$i]; ?>"
					<?php if(isset($isi_edukasi[$x])){
						if($ruang_arr_id[$i] == $ruangan[$x]) echo 'selected="selected"';
					}else{
						if($ruang_arr_id[$i] == $_SESSION['SES_SIMRS_UNIT_ID']) echo 'selected="selected"';
					} 
					?>
					><?php echo $ruang_arr[$i]; ?></option>
					<?php $i++; } ?>
					</select></td>
      <td rowspan="2"><select name="pemahaman_edu_<?php echo $x; ?>" class="text_dt" style="width:80px;" >
					<option value="1" <?php if(isset($isi_edukasi[$x]) and ($pemahaman[$x] == '1')) echo 'selected="selected"'; ?> >Edukasi Pertama</option>
					<option value="2" <?php if(isset($isi_edukasi[$x]) and ($pemahaman[$x] == '2')) echo 'selected="selected"'; ?> >Re-Edukasi ke 2, ke 3 atau lebih</option>
					</select></td>
      <td width="105px"><select name="jam_edu_1_<?php echo $x; ?>" style="width:50px;" class="text_dt" >
			<?php $jamx = $jam;
				if(isset($isi_edukasi[$x])) $jamx = $jam_1[$x];
				echo getJam($jamx); ?>
			</select>
			<select name="menit_edu_1_<?php echo $x; ?>" style="width:50px;" class="text_dt" >
			<?php $menitx = $menit;
				if(isset($isi_edukasi[$x])) $menitx = $menit_1[$x];
				echo getMenit($menitx);  ?>
			</select></td>
      <td rowspan="2"><input type="text" name="profesi_edu_<?php echo $x; ?>" value="<?php if(isset($isi_edukasi[$x])) echo $profesi[$x];  ?>" class="text_dt" style="width:80px;" /></td>
      <td rowspan="2">
		<select name="metode_edu_<?php echo $x; ?>" class="text_dt" style="width:80px;" >
				<option value="1" <?php if(isset($isi_edukasi[$x]) and ($metode[$x] == '1')) echo 'selected="selected"'; ?> >Diskusi</option>
				<option value="2" <?php if(isset($isi_edukasi[$x]) and ($metode[$x] == '2')) echo 'selected="selected"'; ?> >Peragaan</option>
				<option value="3" <?php if(isset($isi_edukasi[$x]) and ($metode[$x] == '3')) echo 'selected="selected"'; ?> >Selebaran</option>
				<option value="4" <?php if(isset($isi_edukasi[$x]) and ($metode[$x] == '4')) echo 'selected="selected"'; ?> >Audio Visual</option>
		</select>	  </td>
      <td rowspan="2">
		<select name="penerima_edu_<?php echo $x; ?>" class="text_dt" style="width:80px;" >
				<option value="1" <?php if(isset($isi_edukasi[$x]) and ($penerima[$x] == '1')) echo 'selected="selected"'; ?> >Pasien</option>
				<option value="2" <?php if(isset($isi_edukasi[$x]) and ($penerima[$x] == '2')) echo 'selected="selected"'; ?> >Suami</option>
				<option value="3" <?php if(isset($isi_edukasi[$x]) and ($penerima[$x] == '3')) echo 'selected="selected"'; ?> >Isteri</option>
				<option value="4" <?php if(isset($isi_edukasi[$x]) and ($penerima[$x] == '4')) echo 'selected="selected"'; ?> >Ayah</option>
				<option value="5" <?php if(isset($isi_edukasi[$x]) and ($penerima[$x] == '5')) echo 'selected="selected"'; ?> >Ibu</option>
				<option value="6" <?php if(isset($isi_edukasi[$x]) and ($penerima[$x] == '6')) echo 'selected="selected"'; ?> >Anak laki-laki</option>
				<option value="7" <?php if(isset($isi_edukasi[$x]) and ($penerima[$x] == '7')) echo 'selected="selected"'; ?> >Anak perempuan</option>
				<option value="8" <?php if(isset($isi_edukasi[$x]) and ($penerima[$x] == '8')) echo 'selected="selected"'; ?> >Lain-lain</option>
		</select>	  </td>
      <td rowspan="2">
		<select name="evaluasi_edu_<?php echo $x; ?>" class="text_dt" style="width:80px;" >
				<option value="1" <?php if(isset($isi_edukasi[$x]) and ($evaluasi[$x] == '1')) echo 'selected="selected"'; ?> >Tidak respon sama sekali (tidak antusia dlm belajar)</option>
				<option value="2" <?php if(isset($isi_edukasi[$x]) and ($evaluasi[$x] == '2')) echo 'selected="selected"'; ?> >Tidak paham (ingin belajar tap kesulitan mengerti)</option>
				<option value="3" <?php if(isset($isi_edukasi[$x]) and ($evaluasi[$x] == '3')) echo 'selected="selected"'; ?> >Paham hal yang diajarkan, tapi tdk bisa menjelaskan</option>
				<option value="4" <?php if(isset($isi_edukasi[$x]) and ($evaluasi[$x] == '4')) echo 'selected="selected"'; ?> >Dapat menjelaskan, tetapi harus dibantu edukator</option>
				<option value="5" <?php if(isset($isi_edukasi[$x]) and ($evaluasi[$x] == '5')) echo 'selected="selected"'; ?> >Dapat menjelaskan tanpa dibantu edukator</option>
		</select>	  </td>
      <td><input type="text" name="pemberi_edu_<?php echo $x; ?>" value="<?php if(isset($isi_edukasi[$x])) echo $pemberi_edukasi[$x];  ?>" class="text_dt" style="width:80px;" /></td>
      <td><input type="text" name="pemberi_edu_2_<?php echo $x; ?>" value="<?php if(isset($isi_edukasi[$x])) echo $pemberi_edukasi_2[$x];  ?>" class="text_dt" style="width:80px;" /></td>
  </tr>
	<tr>
	  <td width="105px"><select name="jam_edu_2_<?php echo $x; ?>" style="width:50px;" class="text_dt" >
			<?php $jamx = $jam;
				if(isset($isi_edukasi[$x])) $jamx = $jam_2[$x];
				echo getJam($jamx); ?>
			</select>
			<select name="menit_edu_2_<?php echo $x; ?>" style="width:50px;" class="text_dt" >
			<?php $menitx = $menit;
				if(isset($isi_edukasi[$x])) $menitx = $menit_2[$x];
				echo getMenit($menitx);  ?>
			</select></td>
	  <td><input type="text" name="penerima_edu_<?php echo $x; ?>" value="<?php if(isset($isi_edukasi[$x])) echo $penerima_edukasi[$x];  ?>" class="text_dt" style="width:80px;" /></td>
      <td><input type="text" name="penerima_edu_2_<?php echo $x; ?>" value="<?php if(isset($isi_edukasi[$x])) echo $penerima_edukasi_2[$x];  ?>" class="text_dt" style="width:80px;" /></td>
  </tr>
	<?php 
	$x++; } ?>
<tr>
	<td colspan="11" align="right">
	<?php if($irja_final == ''){ ?>
			<input type="button" value="simpan" class="myButton1" onclick="simpan();"/>
			<?php if(!empty($idx)){ 
				$sql_view_rm = 'SELECT FILE_ID FROM t_rm_dokumen_file
						WHERE JNS_PERAWATAN = "1"
						AND NOMR = "' . $nomr . '"
						AND RAWAT_ID = "' . $idx . '"
						AND JENIS_DOKUMEN_ID = "10"
						ORDER BY FILE_ID DESC LIMIT 1';
				$get_view_rm = mysql_query($sql_view_rm) or die(mysql_error());		
				$dat_view_rm = mysql_fetch_assoc($get_view_rm);
			?>
				<input type="button" value="lihat" class="myButton1" onclick="window.open('index.php?flex=<?php echo $dat_view_rm['FILE_ID']; ?>', '_blank');" />
			<?php } } ?>
	</td>
</tr>	
</table>
</form>
<script>

function simpan(){
	_haschange = false;
	$('#formedukasi').submit();
}	
</script>