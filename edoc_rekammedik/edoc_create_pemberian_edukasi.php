<?php
function create_pdf_pemberian_edukasi($idx,$perawatan){
global $rmfile_path;
global $user_name;	
global $edoc_logo;
global $paper_width;
global $paper_height;
$jenis_document = 'Pemberian Edukasi Terintegrasi Pasien Dan Keluarga';
$id_document = '10';	

if($perawatan == 'RJ'){
	$jns_rawat = '1';
	$qry_pasien = 'SELECT m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,t_irja.UNIT_ID,m_unit.NAMA_UNIT,
					m_pegawai.NAMA_PEGAWAI,"" AS JNS_ORDER, "" AS RAWAT_ID
					FROM t_irja
					INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
					INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
					LEFT JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
					WHERE t_irja.IRJA_ID = "' . $idx . '"';
	$qry_edukasi = 'SELECT IRJA_EDUKASI_ID,HAMBATAN_TIDAKADA,HAMBATAN_PENGLIHATAN,HAMBATAN_PENDENGARAN,HAMBATAN_EMOSIONAL,
					HAMBATAN_JASMANI,HAMBATAN_KEPERCAYAAN,HAMBATAN_BAHASA,HAMBATAN_PENDIDIKAN,HAMBATAN_MOTIVASI,HAMBATAN_PROSES_FIKIR,
					HAMBATAN_BUDAYA,HAMBATAN_LAINNYA,HAMBATAN_LAINNYA_KET,BICARA,AGAMA,AGAMA_KET,BAHASA_INDONESIA,BAHASA_INDONESIA_AKTIF_PASIF,
					BAHASA_DAERAH,BAHASA_DAERAH_KET,BAHASA_INGGRIS,BAHASA_INGGRIS_AKTIF_PASIF,BAHASA_LAINNYA,BAHASA_LAINNYA_KET,
					BUDAYA_PANTANGAN_MAKAN,BUDAYA_PANTANGAN_MAKAN_KET,BUDAYA_JAM_MAKAN,BUDAYA_JAM_MAKAN_KET,BUDAYA_LAINNYA,
					BUDAYA_LAINNYA_KET,BUDAYA_TIDAKADA,PENDIDIKAN,PENERJEMAH,PENERJEMAH_KET,BAHASA_ISARAT,BAHASA_ISARAT_KET,
					EMOSIONAL,EMOSIONAL_KET,MOTIVASI,MOTIVASI_KET,PEMBELAJARAN_PENYAKIT,PEMBELAJARAN_PENGOBATAN,PEMBELAJARAN_DIIT,
					PEMBELAJARAN_TERAPI,PEMBELAJARAN_ALATMEDIS,PEMBELAJARAN_NYERI,PEMBELAJARAN_REHABILITASI,PEMBELAJARAN_PERAWATAN,
					PEMBELAJARAN_LAINNYA,PEMBELAJARAN_LAINNYA_KET
					FROM t_irja_edukasi
					WHERE IRJA_EDUKASI_ID = "' . $idx . '"';
	$qry_edukasi_detail = 'SELECT IRJA_EDUKASI_ID,ISI_EDUKASI_ID,DATE_FORMAT(TANGGAL,"%d/%m/%Y") AS TANGGAL,RUANGAN,TINGKAT_PEMAHAMAN,JAM_1,JAM_2,
					PROFESI,METODE,PENERIMA_PENDIDIKAN,EVALUASI_RESPONSE,PEMBERI_EDUKASI,PENERIMA_EDUKASI,
					PEMBERI_EDUKASI_2,PENERIMA_EDUKASI_2,ISI_EDUKASI_DES
					FROM t_irja_edukasi_detail
					WHERE IRJA_EDUKASI_ID = "' . $idx . '"';				
}else if($perawatan == 'RI'){
	$jns_rawat = '2';
	$qry_pasien = 'SELECT m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,t_irna.RUANG_ID AS UNIT_ID,
					CONCAT(m_ruang.NAMA_RUANG," ",m_ruang.KELAS_RAWAT) AS NAMA_UNIT,
					m_pegawai.NAMA_PEGAWAI,"" AS JNS_ORDER, "" AS RAWAT_ID
					FROM t_irna
					INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
					INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
					LEFT JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
					WHERE t_irna.IRNA_ID = "' . $idx . '"';
	$qry_edukasi = 'SELECT IRNA_EDUKASI_ID,HAMBATAN_TIDAKADA,HAMBATAN_PENGLIHATAN,HAMBATAN_PENDENGARAN,HAMBATAN_EMOSIONAL,
					HAMBATAN_JASMANI,HAMBATAN_KEPERCAYAAN,HAMBATAN_BAHASA,HAMBATAN_PENDIDIKAN,HAMBATAN_MOTIVASI,HAMBATAN_PROSES_FIKIR,
					HAMBATAN_BUDAYA,HAMBATAN_LAINNYA,HAMBATAN_LAINNYA_KET,BICARA,AGAMA,AGAMA_KET,BAHASA_INDONESIA,BAHASA_INDONESIA_AKTIF_PASIF,
					BAHASA_DAERAH,BAHASA_DAERAH_KET,BAHASA_INGGRIS,BAHASA_INGGRIS_AKTIF_PASIF,BAHASA_LAINNYA,BAHASA_LAINNYA_KET,
					BUDAYA_PANTANGAN_MAKAN,BUDAYA_PANTANGAN_MAKAN_KET,BUDAYA_JAM_MAKAN,BUDAYA_JAM_MAKAN_KET,BUDAYA_LAINNYA,
					BUDAYA_LAINNYA_KET,BUDAYA_TIDAKADA,PENDIDIKAN,PENERJEMAH,PENERJEMAH_KET,BAHASA_ISARAT,BAHASA_ISARAT_KET,
					EMOSIONAL,EMOSIONAL_KET,MOTIVASI,MOTIVASI_KET,PEMBELAJARAN_PENYAKIT,PEMBELAJARAN_PENGOBATAN,PEMBELAJARAN_DIIT,
					PEMBELAJARAN_TERAPI,PEMBELAJARAN_ALATMEDIS,PEMBELAJARAN_NYERI,PEMBELAJARAN_REHABILITASI,PEMBELAJARAN_PERAWATAN,
					PEMBELAJARAN_LAINNYA,PEMBELAJARAN_LAINNYA_KET
					FROM t_irna_edukasi
					WHERE IRNA_EDUKASI_ID = "' . $idx . '"';
	$qry_edukasi_detail = 'SELECT IRNA_EDUKASI_ID,ISI_EDUKASI_ID,DATE_FORMAT(TANGGAL,"%d/%m/%Y") AS TANGGAL,RUANGAN,TINGKAT_PEMAHAMAN,JAM_1,JAM_2,
					PROFESI,METODE,PENERIMA_PENDIDIKAN,EVALUASI_RESPONSE,PEMBERI_EDUKASI,PENERIMA_EDUKASI,
					PEMBERI_EDUKASI_2,PENERIMA_EDUKASI_2,ISI_EDUKASI_DES
					FROM t_irna_edukasi_detail
					WHERE IRNA_EDUKASI_ID = "' . $idx . '"';				
}

$get_edukasi = mysql_query($qry_edukasi) or die(mysql_error());
if(mysql_num_rows($get_edukasi) > 0){
	$dat_edukasi = mysql_fetch_assoc($get_edukasi);	
	
	$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
	$dat_pasien = mysql_fetch_assoc($get_pasien);

	$nomr = $dat_pasien['NOMR'];
	$nama_pasien = $dat_pasien['NAMA_PASIEN'];
	$tgl_lahir = $dat_pasien['TGL_LAHIR'];
	$jns_kelamin = $dat_pasien['JNS_KELAMIN'];
	$unit_id = $dat_pasien['NAMA_UNIT'];
	$dokter = $dat_pasien['NAMA_PEGAWAI'];

	$edoc_norm = formatNoMR($nomr);
	$edoc_nama_pasien = $nama_pasien;
	$edoc_tanggal_lahir = changeDateFormat($tgl_lahir);
	$edoc_jenis_kelamin = jenisKelamin($jns_kelamin);
	$edoc_unit = $unit_id;
	$edoc_nama_documen = strtoupper($jenis_document);

	createFolder($nomr);
	$filename = $nomr . '_' . $perawatan . $idx . '_' . $id_document . '.pdf' ;

	$mpdf = new mPDF('utf-8', array($paper_height,$paper_width));
	$mpdf->autoPageBreak = false;
	$mpdf->SetHTMLHeader(setHeader($nomr,$nama_pasien));
	$mpdf->SetHTMLFooter(setFooter($jenis_document));

	$hambatan_tidakada = $dat_edukasi['HAMBATAN_TIDAKADA'];
	$hambatan_penglihatan = $dat_edukasi['HAMBATAN_PENGLIHATAN'];
	$hambatan_pendengaran = $dat_edukasi['HAMBATAN_PENDENGARAN'];
	$hambatan_emosional = $dat_edukasi['HAMBATAN_EMOSIONAL'];
	$hambatan_jasmani = $dat_edukasi['HAMBATAN_JASMANI'];
	$hambatan_kepercayaan = $dat_edukasi['HAMBATAN_KEPERCAYAAN'];
	$hambatan_bahasa = $dat_edukasi['HAMBATAN_BAHASA'];
	$hambatan_pendidikan = $dat_edukasi['HAMBATAN_PENDIDIKAN'];
	$hambatan_motivasi = $dat_edukasi['HAMBATAN_MOTIVASI'];
	$hambatan_proses_fikir = $dat_edukasi['HAMBATAN_PROSES_FIKIR'];
	$hambatan_budaya = $dat_edukasi['HAMBATAN_BUDAYA'];
	$hambatan_lainnya = $dat_edukasi['HAMBATAN_LAINNYA'];
	$hambatan_lainnya_ket = $dat_edukasi['HAMBATAN_LAINNYA_KET'];
	$bicara = $dat_edukasi['BICARA'];
	$agama = $dat_edukasi['AGAMA'];
	$agama_ket = $dat_edukasi['AGAMA_KET'];
	$bahasa_indonesia = $dat_edukasi['BAHASA_INDONESIA'];
	$bahasa_indonesia_aktif_pasif = $dat_edukasi['BAHASA_INDONESIA_AKTIF_PASIF'];
	$bahasa_daerah = $dat_edukasi['BAHASA_DAERAH'];
	$bahasa_daerah_ket = $dat_edukasi['BAHASA_DAERAH_KET'];
	$bahasa_inggris = $dat_edukasi['BAHASA_INGGRIS'];
	$bahasa_inggris_aktif_pasif = $dat_edukasi['BAHASA_INGGRIS_AKTIF_PASIF'];
	$bahasa_lainnya = $dat_edukasi['BAHASA_LAINNYA'];
	$bahasa_lainnya_ket = $dat_edukasi['BAHASA_LAINNYA_KET'];
	$budaya_pantangan_makan = $dat_edukasi['BUDAYA_PANTANGAN_MAKAN'];
	$budaya_pantangan_makan_ket = $dat_edukasi['BUDAYA_PANTANGAN_MAKAN_KET'];
	$budaya_jam_makan = $dat_edukasi['BUDAYA_JAM_MAKAN'];
	$budaya_jam_makan_ket = $dat_edukasi['BUDAYA_JAM_MAKAN_KET'];
	$budaya_lainnya = $dat_edukasi['BUDAYA_LAINNYA'];
	$budaya_lainnya_ket = $dat_edukasi['BUDAYA_LAINNYA_KET'];
	$budaya_tidakada = $dat_edukasi['BUDAYA_TIDAKADA'];
	$pendidikan = $dat_edukasi['PENDIDIKAN'];
	$penerjemah = $dat_edukasi['PENERJEMAH'];
	$penerjemah_ket = $dat_edukasi['PENERJEMAH_KET'];
	$bahasa_isarat = $dat_edukasi['BAHASA_ISARAT'];
	$bahasa_isarat_ket = $dat_edukasi['BAHASA_ISARAT_KET'];
	$emosional = $dat_edukasi['EMOSIONAL'];
	$emosional_ket = $dat_edukasi['EMOSIONAL_KET'];
	$motivasi = $dat_edukasi['MOTIVASI'];
	$motivasi_ket = $dat_edukasi['MOTIVASI_KET'];
	$pembelajaran_penyakit = $dat_edukasi['PEMBELAJARAN_PENYAKIT'];
	$pembelajaran_pengobatan = $dat_edukasi['PEMBELAJARAN_PENGOBATAN'];
	$pembelajaran_diit = $dat_edukasi['PEMBELAJARAN_DIIT'];
	$pembelajaran_terapi = $dat_edukasi['PEMBELAJARAN_TERAPI'];
	$pembelajaran_alatmedis = $dat_edukasi['PEMBELAJARAN_ALATMEDIS'];
	$pembelajaran_nyeri = $dat_edukasi['PEMBELAJARAN_NYERI'];
	$pembelajaran_rehabilitasi = $dat_edukasi['PEMBELAJARAN_REHABILITASI'];
	$pembelajaran_perawatan = $dat_edukasi['PEMBELAJARAN_PERAWATAN'];
	$pembelajaran_lainnya = $dat_edukasi['PEMBELAJARAN_LAINNYA'];
	$pembelajaran_lainnya_ket = $dat_edukasi['PEMBELAJARAN_LAINNYA_KET'];		  

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
	
	$edoc_content = '<style>.tbl tr td {
	   border: 1px solid black;
	   padding-left:1px;
	   padding-bottom:1px;
	   border-collapse: collapse;
	}</style>
	<table border="0" width="100%" cellpadding="0" cellspacing="0" class="tbl" autosize="1" >
	<tr>
		<td width="250px">Kesediaan pasien dan keluarga untuk menerima</td>
		<td>
			<input type="radio" name="kesediaan" id="kesediaan" value="1" />&nbsp;Ya
			<input type="radio" name="kesediaan" id="kesediaan" value="2" />&nbsp;Tidak
		</td>
	</tr>
	<tr>
		<td width="250px">Hambatan Edukasi</td>
		<td>
			<input type="checkbox" name="hambatan_tidakada" id="hambatan_tidakada" value="1" ' . (($hambatan_tidakada=="1") ? 'checked="checked"' : '') . ' />&nbsp;Tidak ada hambatan
			<input type="checkbox" name="hambatan_penglihatan" id="hambatan_penglihatan" value="1" ' . (($hambatan_penglihatan=="1") ? 'checked="checked"' : '') . ' />&nbsp;Gangguan penglihatan
			<input type="checkbox" name="hambatan_pendengaran" id="hambatan_pendengaran" value="1"  ' . (($hambatan_pendengaran=="1") ? 'checked="checked"' : '') . ' />&nbsp;Gangguan pendengaran
			<input type="checkbox" name="hambatan_emosional" id="hambatan_emosional" value="1"  ' . (($hambatan_emosional=="1") ? 'checked="checked"' : '') . ' />&nbsp;Gangguan Emosional
			<input type="checkbox" name="hambatan_jasmani" id="hambatan_jasmani" value="1"  ' . (($hambatan_jasmani=="1") ? 'checked="checked"' : '') . ' />&nbsp;Batasan jasmani & kognitif<br />
			<input type="checkbox" name="hambatan_kepercayaan" id="hambatan_kepercayaan" value="1" ' . (($hambatan_kepercayaan=="1") ? 'checked="checked"' : '') . ' />&nbsp;Kepercayaan pasien & keluarga
			<input type="checkbox" name="hambatan_bahasa" id="hambatan_bahasa" value="1" ' . (($hambatan_bahasa=="1") ? 'checked="checked"' : '') . ' />&nbsp;Hambatan bahasa
			<input type="checkbox" name="hambatan_pendidikan" id="hambatan_pendidikan" value="1" ' . (($hambatan_pendidikan=="1") ? 'checked="checked"' : '') . ' />&nbsp;Tingkat pendidikan
			<input type="checkbox" name="hambatan_motivasi" id="hambatan_motivasi" value="1" ' . (($hambatan_motivasi=="1") ? 'checked="checked"' : '') . ' />&nbsp;Motivasi belajar
			<input type="checkbox" name="hambatan_proses_fikir" id="hambatan_proses_fikir" value="1" ' . (($hambatan_proses_fikir=="1") ? 'checked="checked"' : '') . ' />&nbsp;Gangguan proses fikir<br />
			<input type="checkbox" name="hambatan_budaya" id="hambatan_budaya" value="1" ' . (($hambatan_budaya=="1") ? 'checked="checked"' : '') . ' />&nbsp;Perbedaan budaya
			<input type="checkbox" name="hambatan_lainnya" id="hambatan_lainnya" value="1" ' . (($hambatan_lainnya=="1") ? 'checked="checked"' : '') . ' />&nbsp;Lainnya ' . setGarisIfNull($hambatan_lainnya_ket) . '
		</td>
	</tr>
	<tr>
		<td>Bicara</td>
		<td><input type="radio" name="bicara" id="bicara" value="1" ' . (($bicara=="1") ? 'checked="checked"' : '') . ' />&nbsp;Normal
		<input type="radio" name="bicara" id="bicara2" value="2" ' . (($bicara=="2") ? 'checked="checked"' : '') . ' />&nbsp;Ada hambatan</td>
	</tr>
	<tr>
		<td>Agama</td>
		<td>
			<input type="radio" name="agama" id="agama" value="1" ' . (($agama=="1") ? 'checked="checked"' : '') . ' />&nbsp;Islam
			<input type="radio" name="agama" id="agama2" value="2" ' . (($agama=="2") ? 'checked="checked"' : '') . ' />&nbsp;Katholik
			<input type="radio" name="agama" id="agama3" value="3" ' . (($agama=="3") ? 'checked="checked"' : '') . ' />&nbsp;Protestan
			<input type="radio" name="agama" id="agama4" value="4" ' . (($agama=="4") ? 'checked="checked"' : '') . ' />&nbsp;Budha
			<input type="radio" name="agama" id="agama5" value="5" ' . (($agama=="5") ? 'checked="checked"' : '') . ' />&nbsp;Hindu
			<input type="radio" name="agama" id="agama6" value="6" ' . (($agama=="6") ? 'checked="checked"' : '') . ' />&nbsp;Lainnya ' . setGarisIfNull($agama_ket) . '</td>
	</tr>
	<tr>
		<td>Nilai/ budaya yang dianut</td>
		<td>
			<input type="checkbox" name="budaya_pantangan_makan" id="budaya_pantangan_makan" value="1" ' . (($budaya_pantangan_makan=="1") ? 'checked="checked"' : '') . ' />&nbsp;Pantangan makanan ' . setGarisIfNull($budaya_pantangan_makan_ket) . '<br />
			<input type="checkbox" name="budaya_jam_makan" id="budaya_jam_makan" value="1" ' . (($budaya_jam_makan=="1") ? 'checked="checked"' : '') . ' />&nbsp;Jam makan ' . setGarisIfNull($budaya_jam_makan_ket) . '<br />
			<input type="checkbox" name="budaya_lainnya" id="budaya_lainnya" value="1" ' . (($budaya_lainnya=="1") ? 'checked="checked"' : '') . ' />&nbsp;Lainnya ' . setGarisIfNull($budaya_lainnya_ket) . '<br />
			<input type="checkbox" name="budaya_tidakada" id="budaya_tidakada" value="1" ' . (($budaya_tidakada=="1") ? 'checked="checked"' : '') . ' />&nbsp;Tidak ada
			</td>
	</tr>
	<tr>
		<td>Bahasa sehari-hari</td>
		<td>
			<input type="checkbox" name="bahasa_indonesia" id="bahasa_indonesia" value="1" ' . (($bahasa_indonesia=="1") ? 'checked="checked"' : '') . ' />&nbsp;Indonesia
			<input type="radio" name="bahasa_indonesia_aktif_pasif" id="bahasa_indonesia_aktif_pasif" value="1" ' . (($bahasa_indonesia_aktif_pasif=="1") ? 'checked="checked"' : '') . ' />&nbsp;Aktif
			<input type="radio" name="bahasa_indonesia_aktif_pasif" id="bahasa_indonesia_aktif_pasif2" value="2" ' . (($bahasa_indonesia_aktif_pasif=="2") ? 'checked="checked"' : '') . ' />&nbsp;Pasif<br />
			<input type="checkbox" name="bahasa_daerah" id="bahasa_daerah" value="1" ' . (($bahasa_daerah=="1") ? 'checked="checked"' : '') . ' />&nbsp;Daerah ' . setGarisIfNull($bahasa_daerah_ket) . '<br />
			<input type="checkbox" name="bahasa_inggris" id="bahasa_inggris" value="1" ' . (($bahasa_inggris=="1") ? 'checked="checked"' : '') . ' />&nbsp;Inggris
			<input type="radio" name="bahasa_inggris_aktif_pasif" id="bahasa_inggris_aktif_pasif" value="1" ' . (($bahasa_inggris_aktif_pasif=="1") ? 'checked="checked"' : '') . ' />&nbsp;Aktif
			<input type="radio" name="bahasa_inggris_aktif_pasif" id="bahasa_inggris_aktif_pasif2" value="2" ' . (($bahasa_inggris_aktif_pasif=="2") ? 'checked="checked"' : '') . ' />&nbsp;Pasif<br />
			<input type="checkbox" name="bahasa_lainnya" id="bahasa_lainnya" value="1" ' . (($bahasa_lainnya=="1") ? 'checked="checked"' : '') . ' />&nbsp;Lainnya ' . setGarisIfNull($bahasa_lainnya_ket) . '</td>
	</tr>
	<tr>
		<td>Tingkat pendidikan</td>
			<td>
			<input type="radio" name="pendidikan" id="pendidikan" value="1" ' . (($pendidikan=="1") ? 'checked="checked"' : '') . ' />&nbsp;SD
			<input type="radio" name="pendidikan" id="pendidikan2" value="2" ' . (($pendidikan=="2") ? 'checked="checked"' : '') . ' />&nbsp;SMP
			<input type="radio" name="pendidikan" id="pendidikan3" value="3" ' . (($pendidikan=="3") ? 'checked="checked"' : '') . ' />&nbsp;SMA
			<input type="radio" name="pendidikan" id="pendidikan4" value="4" ' . (($pendidikan=="4") ? 'checked="checked"' : '') . ' />&nbsp;Diploma
			<input type="radio" name="pendidikan" id="pendidikan5" value="5" ' . (($pendidikan=="5") ? 'checked="checked"' : '') . ' />&nbsp;S1
			<input type="radio" name="pendidikan" id="pendidikan6" value="6" ' . (($pendidikan=="6") ? 'checked="checked"' : '') . ' />&nbsp;S2/ S3
			</td>
	</tr>
	<tr>
		<td>Perlu penerjemah</td>
			<td>
			<input type="radio" name="penerjemah" id="penerjemah" value="1" ' . (($penerjemah=="1") ? 'checked="checked"' : '') . ' />&nbsp;Tidak
			<input type="radio" name="penerjemah" id="penerjemah2" value="2" ' . (($penerjemah=="2") ? 'checked="checked"' : '') . ' />&nbsp;Ya ' . setGarisIfNull($penerjemah_ket) . '
			</td>
	</tr>
	<tr>
		<td>Bahasa isarat</td>
		<td>
		<input type="radio" name="bahasa_isarat" id="bahasa_isarat" value="1" ' . (($bahasa_isarat=="1") ? 'checked="checked"' : '') . ' />&nbsp;Tidak
		<input type="radio" name="bahasa_isarat" id="bahasa_isarat2" value="2" ' . (($bahasa_isarat=="2") ? 'checked="checked"' : '') . ' />&nbsp;Ya ' . setGarisIfNull($bahasa_isarat_ket) . '
		</td>
	</tr>
	<tr>
		<td>Hambatan emosional</td>
		<td>
		<input type="radio" name="emosional" id="emosional" value="1" ' . (($emosional=="1") ? 'checked="checked"' : '') . ' />&nbsp;Tidak
		<input type="radio" name="emosional" id="emosional2" value="2" ' . (($emosional=="2") ? 'checked="checked"' : '') . ' />&nbsp;Ya ' . setGarisIfNull($emosional_ket) . '
		</td>
	</tr>
	<tr>
		<td>Hambatan didalam motivasi</td>
		<td>
		<input type="radio" name="motivasi" id="motivasi" value="1" ' . (($motivasi=="1") ? 'checked="checked"' : '') . ' />&nbsp;Tidak
		<input type="radio" name="motivasi" id="motivasi2" value="2" ' . (($motivasi=="2") ? 'checked="checked"' : '') . ' />&nbsp;Ya ' . setGarisIfNull($motivasi_ket) . '
		</td>
	</tr>
	<tr>
		<td>Potensial kebutuhan pembelajaran</td>
		<td>
		<input type="checkbox" name="pembelajaran_penyakit" id="pembelajaran_penyakit" value="1" ' . (($pembelajaran_penyakit=="1") ? 'checked="checked"' : '') . ' />&nbsp;Proses penyakit
		<input type="checkbox" name="pembelajaran_pengobatan" id="pembelajaran_pengobatan" value="1" ' . (($pembelajaran_pengobatan=="1") ? 'checked="checked"' : '') . ' />&nbsp;Pengobatan/ tindakan
		<input type="checkbox" name="pembelajaran_diit" id="pembelajaran_diit" value="1" ' . (($pembelajaran_diit=="1") ? 'checked="checked"' : '') . ' />&nbsp;Diit & nutrisi
		<input type="checkbox" name="pembelajaran_terapi" id="pembelajaran_terapi" value="1" ' . (($pembelajaran_terapi=="1") ? 'checked="checked"' : '') . ' />&nbsp;Terapi/ obat/ interaksi obat
		<input type="checkbox" name="pembelajaran_alatmedis" id="pembelajaran_alatmedis" value="1" ' . (($pembelajaran_alatmedis=="1") ? 'checked="checked"' : '') . ' />&nbsp;Penggunaan peralatan medis<br />
		<input type="checkbox" name="pembelajaran_nyeri" id="pembelajaran_nyeri" value="1" ' . (($pembelajaran_nyeri=="1") ? 'checked="checked"' : '') . ' />&nbsp;Manajemen nyeri
		<input type="checkbox" name="pembelajaran_rehabilitasi" id="pembelajaran_rehabilitasi" value="1" ' . (($pembelajaran_rehabilitasi=="1") ? 'checked="checked"' : '') . ' />&nbsp;Tehnik rehabilitasi
		<input type="checkbox" name="pembelajaran_perawatan" id="pembelajaran_perawatan" value="1" ' . (($pembelajaran_perawatan=="1") ? 'checked="checked"' : '') . ' />&nbsp;Perawatan di rumah<br />
		<input type="checkbox" name="pembelajaran_lainnya" id="pembelajaran_lainnya" value="1" ' . (($pembelajaran_lainnya=="1") ? 'checked="checked"' : '') . ' />&nbsp;Lainnya ' . setGarisIfNull($pembelajaran_lainnya_ket) . '</td>
	</tr>
	</table>';
	
	ob_start();
	include('edoc_rekammedik/edoc_frame_main.php');
	$html = ob_get_contents();
	ob_end_clean();
	$mpdf->WriteHTML($html);
	
	$edoc_first = '<style>.tbl tr td {
	   border: 1px solid black;
	   padding-left:1px;
	   border-collapse: collapse;
	}</style>
	<table width="100%" class="tbl" cellpadding="0" cellspacing="0" autosize="1" >
	<tr>
		<td rowspan="2" width="100px" align="center" bgcolor="#CCCCCC" ><strong>Tanggal</strong></td>
		<td rowspan="2" width="280px" align="center" bgcolor="#CCCCCC" ><strong>Isi Edukasi</strong></td>
		<td colspan="3" rowspan="2" align="center" bgcolor="#CCCCCC" ><strong>Ruangan, Tingkat Pemahaman<br />Lama Edukasi</strong></td>
		<td rowspan="2" align="center" bgcolor="#CCCCCC" ><strong>Profesi</strong></td>
		<td rowspan="2" align="center" bgcolor="#CCCCCC" ><strong>Metode</strong></td>
		<td rowspan="2" align="center" bgcolor="#CCCCCC" ><strong>Penerima<br />Pendidikan</strong></td>
		<td rowspan="2" align="center" bgcolor="#CCCCCC" ><strong>Evaluasi<br />Response</strong></td>
		<td colspan="2" align="center" bgcolor="#CCCCCC" ><strong>Nama &amp; Tandatangan</strong></td>
	</tr>
	<tr>
	  <th align="center" bgcolor="#CCCCCC" ><strong>Pemberi<br />Edukasi</strong></th>
      <th align="center" bgcolor="#CCCCCC" ><strong>Penerima<br />Edukasi</strong></th>
  </tr>';
	$edoc_end = '</table>';
	
	$edoc_main = '';
	$x = 1;
	$y = 1;
	while($x <= 41){
		$edoc_main = $edoc_main . '<tr>
								<td rowspan="2">' . $tanggal[$x] . '</td>
								<td rowspan="2"><input type="checkbox" name="isi_edukasi" ' . ((isset($isi_edukasi[$x])) ? 'checked="checked"' : '') . '/>';
								 if(($x == 20) or ($x == 21) or ($x == 24) or ($x == 20) or ($x > 29)){ 
										if(isset($isi_edukasi[$x])){
											$edoc_main = $edoc_main . $isi_edukasi_des[$x]; 
										}else{ 
											$edoc_main = $edoc_main . $isi_edu_arr[$x]; 
										}	
								  }else{
									  $edoc_main = $edoc_main . $isi_edu_arr[$x];
								  }	  
		$edoc_main = $edoc_main . '</td>
								<td rowspan="2">';
								$i = 0;
								while($i < sizeof($ruang_arr)){
									if(isset($isi_edukasi[$x])){
										if($ruang_arr_id[$i] == $ruangan[$x]) $edoc_main = $edoc_main . setGarisIfNull($ruang_arr[$i]);
									} 
								$i++; }
		$edoc_main = $edoc_main . '</td>
								<td rowspan="2">';
								if(isset($isi_edukasi[$x]) and ($pemahaman[$x] == '1')) $edoc_main = $edoc_main . 'Edukasi Pertama';
								if(isset($isi_edukasi[$x]) and ($pemahaman[$x] == '2')) $edoc_main = $edoc_main . 'Re-Edukasi ke 2, ke 3 atau lebih';
		$edoc_main = $edoc_main . '</td><td>'; 
				
				if(isset($isi_edukasi[$x])) {
					$edoc_main = $edoc_main . $jam_1[$x] . ':' . $menit_1[$x];
				}
		$edoc_main = $edoc_main . '</td>
								<td rowspan="2">';
			if(isset($isi_edukasi[$x])) $edoc_main = $edoc_main . $profesi[$x];
		$edoc_main = $edoc_main . '</td>
								<td rowspan="2">';
			if(isset($isi_edukasi[$x]) and ($metode[$x] == '1')) $edoc_main = $edoc_main . 'Diskusi';
			if(isset($isi_edukasi[$x]) and ($metode[$x] == '2')) $edoc_main = $edoc_main . 'Peragaan';
			if(isset($isi_edukasi[$x]) and ($metode[$x] == '3')) $edoc_main = $edoc_main . 'Selebaran';
			if(isset($isi_edukasi[$x]) and ($metode[$x] == '4')) $edoc_main = $edoc_main . 'Audio Visual';
		$edoc_main = $edoc_main . '</td>
								<td rowspan="2">';	
			if(isset($isi_edukasi[$x]) and ($penerima[$x] == '1')) $edoc_main = $edoc_main . 'Pasien';
			if(isset($isi_edukasi[$x]) and ($penerima[$x] == '2')) $edoc_main = $edoc_main . 'Suami';
			if(isset($isi_edukasi[$x]) and ($penerima[$x] == '3')) $edoc_main = $edoc_main . 'Isteri';
			if(isset($isi_edukasi[$x]) and ($penerima[$x] == '4')) $edoc_main = $edoc_main . 'Ayah';
			if(isset($isi_edukasi[$x]) and ($penerima[$x] == '5')) $edoc_main = $edoc_main . 'Ibu';
			if(isset($isi_edukasi[$x]) and ($penerima[$x] == '6')) $edoc_main = $edoc_main . 'Anak laki-laki';
			if(isset($isi_edukasi[$x]) and ($penerima[$x] == '7')) $edoc_main = $edoc_main . 'Anak perempuan';
			if(isset($isi_edukasi[$x]) and ($penerima[$x] == '8')) $edoc_main = $edoc_main . 'Lain-lain';
		$edoc_main = $edoc_main . '</td>
								<td rowspan="2">';	
			if(isset($isi_edukasi[$x]) and ($evaluasi[$x] == '1')) $edoc_main = $edoc_main . 'Tidak respon sama sekali (tidak antusia dlm belajar)';
			if(isset($isi_edukasi[$x]) and ($evaluasi[$x] == '2')) $edoc_main = $edoc_main . 'Tidak paham (ingin belajar tap kesulitan mengerti)';
			if(isset($isi_edukasi[$x]) and ($evaluasi[$x] == '3')) $edoc_main = $edoc_main . 'Paham hal yang diajarkan, tapi tdk bisa menjelaskan';
			if(isset($isi_edukasi[$x]) and ($evaluasi[$x] == '4')) $edoc_main = $edoc_main . 'Dapat menjelaskan, tetapi harus dibantu edukator';
			if(isset($isi_edukasi[$x]) and ($evaluasi[$x] == '5')) $edoc_main = $edoc_main . 'Dapat menjelaskan tanpa dibantu edukator';
		$edoc_main = $edoc_main . '</td><td>';	
			if(isset($isi_edukasi[$x])) $edoc_main = $edoc_main . $pemberi_edukasi[$x];
		$edoc_main = $edoc_main . '</td><td>';		
			if(isset($isi_edukasi[$x])) $edoc_main = $edoc_main . $pemberi_edukasi_2[$x];
		$edoc_main = $edoc_main . '</td></tr>
								<tr><td width="105px">';	
			if(isset($isi_edukasi[$x])) {
					$edoc_main = $edoc_main . $jam_2[$x] . ':' . $menit_2[$x];
				}							
		$edoc_main = $edoc_main . '</td><td>';
			if(isset($isi_edukasi[$x])) $edoc_main = $edoc_main . $penerima_edukasi[$x];
		$edoc_main = $edoc_main . '</td><td>';
			if(isset($isi_edukasi[$x])) $edoc_main = $edoc_main . $penerima_edukasi_2[$x];	
		$edoc_main = $edoc_main . '</td></tr>';

			if($y == 12){
				$edoc_content_2 = $edoc_first . $edoc_main . $edoc_end;
				$edoc_main = '';
				$y = 0;
				ob_start();
				include('edoc_rekammedik/edoc_frame_add.php');
				$html = ob_get_contents();
				ob_end_clean();
				$mpdf->AddPage('P'); 
				$mpdf->WriteHTML($html);
			}
			$y++;				
	$x++; 
	} 
	
	if($edoc_main != ''){
			$edoc_content_2 = $edoc_first . $edoc_main . $edoc_end;
			ob_start();
			include('edoc_rekammedik/edoc_frame_add.php');
			$html = ob_get_contents();
			ob_end_clean();
			$mpdf->AddPage('P'); 
			$mpdf->WriteHTML($html);	
	}
	
	$mpdf->Output($rmfile_path . '/' . $nomr . '/' . $filename);	
	saveData($nomr,$idx,$jns_rawat,$id_document,$filename,$user_name,'','');
}
}
?>