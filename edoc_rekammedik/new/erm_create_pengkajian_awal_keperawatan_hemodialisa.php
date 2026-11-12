<?php
function replace_newline($str){
	$ret = preg_replace('/\r|\n/','\n',trim($str));
	$ret = str_replace('\n','<br>',$ret);
	$ret = str_replace('<br><br>','<br>',$ret);
	return $ret;
}

function erm_pengkajian_awal_keperawatan_hemodialisa($idx,$ls_assesment='',$tgl_skr='',$final='',$jns_order,$idxord){
	global $rmfile_path, $app_path;

	$checked = '<w:sym w:font="Wingdings" w:char="F0FE"/>';
    $unChecked = '<w:sym w:font="Wingdings" w:char="F0A8"/>';
	
	$jns_perawatan = '1';
	if($jns_order == 'IRN') $jns_perawatan = '2'; 
	
	$templateklinik = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\pengkajian_awal_keperawatan_rawat_jalan.docx');
	
	if($jns_order == ''){
		$qry_pasien = 'SELECT t_irja.IRJA_ID,t_irja.NOMR,t_irja.PEGAWAI_ID,m_pegawai.NAMA_PEGAWAI,
				t_irja.ASAL_PASIEN_ID,t_irja.KET_ASAL_PASIEN,t_irja.UNIT_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				DATE_FORMAT(t_irja.PASIEN_MASUK,"%d-%m-%Y %H:%i") AS PASIEN_MASUK,t_irja.JENIS_BAYAR_ID,m_pasien.NO_TELEPON,
				DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				"Hemodialisa" AS NAMA_UNIT
				FROM t_irja
				INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_irja.IRJA_ID = "' . $idx . '"';
				
		$qry_pengkajian = 'SELECT IRJA_ASKEP_ID,KELUHAN_UTAMA,RIWAYAT_PENYAKIT,RIWAYAT_PENYAKIT_KELUARGA,GENOGRAM,
			TEKANAN_DARAH,FREKUENSI_NAFAS,SUHU_TUBUH,FREKUENSI_NADI,BERAT_BADAN,TINGGI_BADAN,
			PEMERIKSA_FISIK_TERKAIT_KELUHAN,HUBUNGAN_KELUARGA,STATUS_PSIKOLOGIS,STATUS_PSIKOLOGIS_BUNUH_DIRI,
			KETERANGAN_STATUS_PSIKOLOGIS,PENURUNAN_BERAT_BADAN,TIDAK_NAFSU_MAKAN,DIAGNOSIS_KHUSUS,
			DIAGNOSA_KHUSUS_DM,DIAGNOSA_KHUSUS_KEMOTERAPI,DIAGNOSA_KHUSUS_HEMODIALISA,DIAGNOSA_KHUSUS_GERIATRI,
			DIAGNOSA_KHUSUS_IMUNITAS,DIAGNOSA_KHUSUS_LAIN,KETERANGAN_DIAGNOSIS_KHUSUS,STATUS_FUNGSIONAL,
			KETERANGAN_STATUS_FUNGSIONAL,KETERANGAN_STATUS_FUNGSIONAL_KETERGANTUNGAN,CARA_BERJALAN,CARA_DUDUK,RESIKO_JATUH,
			KETERANGAN_RESIKO_JATUH,NYERI,SKALA_NYERI,LOKASI_NYERI,DURASI_NYERI,FREKUENSI_NYERI,NYERI_HILANG,
			KETERANGAN_NYERI_HILANG,STATUS_NYERI_HILANG,KETERANGAN_STATUS_NYERI_HILANG,RIWAYAT_ALERGI_OBAT,
			DIAGNOSA_KEPERAWATAN,RENCANA_KEPERAWATAN,IMPELEMENTASI_KEPERAWATAN,EVALUASI_KEPERAWATAN,
			USER_KLINIK,DATE_FORMAT(TGL_ASSESMENT,"%d-%m-%Y %H:%i") AS TGL_ASSESMENT,
			PEMICU_NYERI,KUALITAS_NYERI,NAMA_PEGAWAI
			FROM t_irja_askep
			LEFT JOIN m_pegawai ON (t_irja_askep.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
			WHERE IRJA_ASKEP_ID = "' . $idx . '"';		
	}else{
		$qry_pasien = 'SELECT t_hemodialisa.HEMODIALISA_ID AS IRJA_ID,t_hemodialisa.NOMR,
				t_hemodialisa.PEGAWAI_PERIKSA_ID AS PEGAWAI_ID,m_pegawai.NAMA_PEGAWAI,
				"" AS ASAL_PASIEN_ID,"" AS KET_ASAL_PASIEN,t_hemodialisa.UNIT_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				DATE_FORMAT(t_hemodialisa.PASIEN_MASUK,"%d-%m-%Y %H:%i") AS PASIEN_MASUK,t_hemodialisa.JENIS_BAYAR_ID,m_pasien.NO_TELEPON,
				DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				"Hemodialisa" AS NAMA_UNIT
				FROM t_hemodialisa
				INNER JOIN m_pasien ON (t_hemodialisa.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_hemodialisa.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_pegawai ON (t_hemodialisa.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_hemodialisa.HEMODIALISA_ID = "' . $idx . '"';
				
		$qry_pengkajian = 'SELECT HEMODIALISA_ASKEP_ID AS IRJA_ASKEP_ID,KELUHAN_UTAMA,RIWAYAT_PENYAKIT,RIWAYAT_PENYAKIT_KELUARGA,GENOGRAM,
			TEKANAN_DARAH,FREKUENSI_NAFAS,SUHU_TUBUH,FREKUENSI_NADI,BERAT_BADAN,TINGGI_BADAN,
			PEMERIKSA_FISIK_TERKAIT_KELUHAN,HUBUNGAN_KELUARGA,STATUS_PSIKOLOGIS,STATUS_PSIKOLOGIS_BUNUH_DIRI,
			KETERANGAN_STATUS_PSIKOLOGIS,PENURUNAN_BERAT_BADAN,TIDAK_NAFSU_MAKAN,DIAGNOSIS_KHUSUS,
			DIAGNOSA_KHUSUS_DM,DIAGNOSA_KHUSUS_KEMOTERAPI,DIAGNOSA_KHUSUS_HEMODIALISA,DIAGNOSA_KHUSUS_GERIATRI,
			DIAGNOSA_KHUSUS_IMUNITAS,DIAGNOSA_KHUSUS_LAIN,KETERANGAN_DIAGNOSIS_KHUSUS,STATUS_FUNGSIONAL,
			KETERANGAN_STATUS_FUNGSIONAL,KETERANGAN_STATUS_FUNGSIONAL_KETERGANTUNGAN,CARA_BERJALAN,CARA_DUDUK,RESIKO_JATUH,
			KETERANGAN_RESIKO_JATUH,NYERI,SKALA_NYERI,LOKASI_NYERI,DURASI_NYERI,FREKUENSI_NYERI,NYERI_HILANG,
			KETERANGAN_NYERI_HILANG,STATUS_NYERI_HILANG,KETERANGAN_STATUS_NYERI_HILANG,RIWAYAT_ALERGI_OBAT,
			DIAGNOSA_KEPERAWATAN,RENCANA_KEPERAWATAN,IMPELEMENTASI_KEPERAWATAN,EVALUASI_KEPERAWATAN,
			USER_KLINIK,DATE_FORMAT(TGL_ASSESMENT,"%d-%m-%Y %H:%i") AS TGL_ASSESMENT,
			PEMICU_NYERI,KUALITAS_NYERI,NAMA_PEGAWAI
			FROM t_hemodialisa_askep
			LEFT JOIN m_pegawai ON (t_hemodialisa_askep.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
			WHERE HEMODIALISA_ASKEP_ID = "' . $idx . '"';		
	}			
	$get_pasien = mysql_query($qry_pasien);
	$dat_pasien = mysql_fetch_assoc($get_pasien);
	$nomr = $dat_pasien['NOMR'];
	$nama_pasien = $dat_pasien['NAMA_PASIEN'];
	$tgl_lahir = $dat_pasien['TGL_LAHIR'];
	$jns_kelamin = jenisKelamin($dat_pasien['JNS_KELAMIN']);
	$alamat = $dat_pasien['ALAMAT'];
	$nik = $dat_pasien['NIK'];
	$jns_pembayaran = $dat_pasien['NAMA_JAMINAN'];
	$jenis_bayar_id = $dat_pasien['JENIS_BAYAR_ID'];

	$irja_id = $dat_pasien['IRJA_ID'];
	$pegawai_id = $dat_pasien['PEGAWAI_ID'];
	$asal_pasien_id = $dat_pasien['ASAL_PASIEN_ID'];
	$ket_asal_pasien = $dat_pasien['KET_ASAL_PASIEN'];
	$pasien_masuk = $dat_pasien['PASIEN_MASUK'];

	$no_telepon = $dat_pasien['NO_TELEPON'];
	$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];
	$nama_unit = $dat_pasien['NAMA_UNIT'];
	$nama_dokter = $dat_pasien['NAMA_PEGAWAI'];

	$umur = getUmurDaftar($tgl_lahir,$tgl_daftar);
	
	$templateklinik->setValue('nomor_rm', formatNomr($nomr));
	$templateklinik->setValue('nama_pasien', htmlspecialchars($nama_pasien));
	$templateklinik->setValue('tgl_lahir', htmlspecialchars($tgl_lahir));
	$templateklinik->setValue('jenis_kelamin', htmlspecialchars($jns_kelamin));
	$templateklinik->setValue('unit', htmlspecialchars($nama_unit));
	$templateklinik->setValue('tgl_masuk', $pasien_masuk);
	$templateklinik->setValue('nama_dokter', htmlspecialchars($nama_dokter));
	
	if($jenis_bayar_id == '12') {
		$templateklinik->setValue('byr_jkn',$checked);
		$templateklinik->setValue('byr_jamkesda',$unChecked);
		$templateklinik->setValue('byr_kts',$unChecked);
		$templateklinik->setValue('byr_umum',$unChecked);
		$templateklinik->setValue('byr_lain',$unChecked);
	}else if($jenis_bayar_id == '13') {
		$templateklinik->setValue('byr_lain',$unChecked);	
		$templateklinik->setValue('byr_jamkesda',$checked);
		$templateklinik->setValue('byr_kts',$unChecked);
		$templateklinik->setValue('byr_umum',$unChecked);
		$templateklinik->setValue('byr_lain',$unChecked);
	}else if($jenis_bayar_id == '14') {
		$templateklinik->setValue('byr_jkn',$unChecked);
		$templateklinik->setValue('byr_jamkesda',$unChecked);
		$templateklinik->setValue('byr_kts',$checked);
		$templateklinik->setValue('byr_umum',$unChecked);
		$templateklinik->setValue('byr_lain',$unChecked);
	}else if($jenis_bayar_id == '1') {
		$templateklinik->setValue('byr_jkn',$unChecked);
		$templateklinik->setValue('byr_jamkesda',$unChecked);
		$templateklinik->setValue('byr_kts',$unChecked);
		$templateklinik->setValue('byr_umum',$checked);
		$templateklinik->setValue('byr_lain',$unChecked);
	}else{ 
		$templateklinik->setValue('byr_jkn',$unChecked);
		$templateklinik->setValue('byr_jamkesda',$unChecked);
		$templateklinik->setValue('byr_kts',$unChecked);
		$templateklinik->setValue('byr_umum',$unChecked);
		$templateklinik->setValue('byr_lain',$checked);
	}
	
	$get_pengkajian = mysql_query($qry_pengkajian) or die(mysql_error());
	$dat_pengkajian = mysql_fetch_assoc($get_pengkajian);
	$idx = $dat_pengkajian['IRJA_ASKEP_ID'];
	
	$templateklinik->setValue('tgl_assesment', $dat_pengkajian['TGL_ASSESMENT']);
	$templateklinik->setValue('dicetak_oleh', '');
	$templateklinik->setValue('nama_perawat', htmlspecialchars($dat_pengkajian['NAMA_PEGAWAI']));
	
	$keluhan_utama = replace_newline($dat_pengkajian['KELUHAN_UTAMA']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($keluhan_utama);
	$templateklinik->setValue('keluhan_utama', $toOpenXML);
	
	$riwayat_penyakit_dahulu = replace_newline($dat_pengkajian['RIWAYAT_PENYAKIT']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($riwayat_penyakit_dahulu);
	$templateklinik->setValue('riwayat_penyakit_dahulu', $toOpenXML);
	
	$riwayat_penyakit_keluarga = replace_newline($dat_pengkajian['RIWAYAT_PENYAKIT_KELUARGA']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($riwayat_penyakit_keluarga);
	$templateklinik->setValue('riwayat_penyakit_keluarga', $toOpenXML);
	
	$templateklinik->setValue('tekanan_darah', htmlspecialchars($dat_pengkajian['TEKANAN_DARAH']));
	$templateklinik->setValue('frek_nafas', htmlspecialchars($dat_pengkajian['FREKUENSI_NAFAS']));
	$templateklinik->setValue('suhu_tubuh', htmlspecialchars($dat_pengkajian['SUHU_TUBUH']));
	$templateklinik->setValue('frek_nadi', htmlspecialchars($dat_pengkajian['FREKUENSI_NADI']));
	$templateklinik->setValue('bb', htmlspecialchars($dat_pengkajian['BERAT_BADAN']));
	$templateklinik->setValue('tb', htmlspecialchars($dat_pengkajian['TINGGI_BADAN']));
	
	$pemeriksaan_fisik = replace_newline($dat_pengkajian['PEMERIKSA_FISIK_TERKAIT_KELUHAN']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($pemeriksaan_fisik);
	$templateklinik->setValue('pemeriksaan_fisik', $toOpenXML);
	
	if($dat_pengkajian['HUBUNGAN_KELUARGA'] == 'Baik') {
		$templateklinik->setValue('hub_baik',$checked);
		$templateklinik->setValue('hub_tdk_baik',$unChecked);
	}else if($dat_pengkajian['HUBUNGAN_KELUARGA'] == 'Tidak Baik') {
		$templateklinik->setValue('hub_baik',$unChecked);
		$templateklinik->setValue('hub_tdk_baik',$checked);	
	}else{
		$templateklinik->setValue('hub_baik',$unChecked);
		$templateklinik->setValue('hub_tdk_baik',$unChecked);
	}

	if($dat_pengkajian['STATUS_PSIKOLOGIS'] == 'Tenang') {
		$templateklinik->setValue('psi_tenang',$checked);
		$templateklinik->setValue('psi_cemas',$unChecked);
		$templateklinik->setValue('psi_takut',$unChecked);
		$templateklinik->setValue('psi_marah',$unChecked);
		$templateklinik->setValue('psi_sedih',$unChecked);
		$templateklinik->setValue('psi_bd',$unChecked);
		$templateklinik->setValue('psi_lain',$unChecked);
	}else if($dat_pengkajian['STATUS_PSIKOLOGIS'] == 'Cemas'){
		$templateklinik->setValue('psi_tenang',$unChecked);
		$templateklinik->setValue('psi_cemas',$checked);
		$templateklinik->setValue('psi_takut',$unChecked);
		$templateklinik->setValue('psi_marah',$unChecked);
		$templateklinik->setValue('psi_sedih',$unChecked);
		$templateklinik->setValue('psi_bd',$unChecked);
		$templateklinik->setValue('psi_lain',$unChecked);
	}else if($dat_pengkajian['STATUS_PSIKOLOGIS'] == 'Takut'){
		$templateklinik->setValue('psi_tenang',$unChecked);
		$templateklinik->setValue('psi_cemas',$unChecked);
		$templateklinik->setValue('psi_takut',$checked);
		$templateklinik->setValue('psi_marah',$unChecked);
		$templateklinik->setValue('psi_sedih',$unChecked);
		$templateklinik->setValue('psi_bd',$unChecked);
		$templateklinik->setValue('psi_lain',$unChecked);
	}else if($dat_pengkajian['STATUS_PSIKOLOGIS'] == 'Marah'){
		$templateklinik->setValue('psi_tenang',$unChecked);
		$templateklinik->setValue('psi_cemas',$unChecked);
		$templateklinik->setValue('psi_takut',$unChecked);
		$templateklinik->setValue('psi_marah',$checked);
		$templateklinik->setValue('psi_sedih',$unChecked);
		$templateklinik->setValue('psi_bd',$unChecked);
		$templateklinik->setValue('psi_lain',$unChecked);
	}else if($dat_pengkajian['STATUS_PSIKOLOGIS'] == 'Sedih'){
		$templateklinik->setValue('psi_tenang',$unChecked);
		$templateklinik->setValue('psi_cemas',$unChecked);
		$templateklinik->setValue('psi_takut',$unChecked);
		$templateklinik->setValue('psi_marah',$unChecked);
		$templateklinik->setValue('psi_sedih',$checked);
		$templateklinik->setValue('psi_bd',$unChecked);
		$templateklinik->setValue('psi_lain',$unChecked);
	}else if($dat_pengkajian['STATUS_PSIKOLOGIS'] == 'Kecendrungan Bunuh'){
		$templateklinik->setValue('psi_tenang',$unChecked);
		$templateklinik->setValue('psi_cemas',$unChecked);
		$templateklinik->setValue('psi_takut',$unChecked);
		$templateklinik->setValue('psi_marah',$unChecked);
		$templateklinik->setValue('psi_sedih',$unChecked);
		$templateklinik->setValue('psi_bd',$checked);
		$templateklinik->setValue('psi_lain',$unChecked);
	}else if($dat_pengkajian['STATUS_PSIKOLOGIS'] == 'Lain-lain'){	
		$templateklinik->setValue('psi_tenang',$unChecked);
		$templateklinik->setValue('psi_cemas',$unChecked);
		$templateklinik->setValue('psi_takut',$unChecked);
		$templateklinik->setValue('psi_marah',$unChecked);
		$templateklinik->setValue('psi_sedih',$unChecked);
		$templateklinik->setValue('psi_bd',$unChecked);
		$templateklinik->setValue('psi_lain',$checked);
	}else{
		$templateklinik->setValue('psi_tenang',$unChecked);
		$templateklinik->setValue('psi_cemas',$unChecked);
		$templateklinik->setValue('psi_takut',$unChecked);
		$templateklinik->setValue('psi_marah',$unChecked);
		$templateklinik->setValue('psi_sedih',$unChecked);
		$templateklinik->setValue('psi_bd',$unChecked);
		$templateklinik->setValue('psi_lain',$unChecked);
	}	
	
	$templateklinik->setValue('psi_lapor',htmlspecialchars($dat_pengkajian['STATUS_PSIKOLOGIS_BUNUH_DIRI']));
	
	$psi_ket_lain = replace_newline($dat_pengkajian['KETERANGAN_STATUS_PSIKOLOGIS']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($psi_ket_lain);
	$templateklinik->setValue('psi_ket_lain', $toOpenXML);
	
	if($dat_pengkajian['PENURUNAN_BERAT_BADAN'] == 'Tidak Ada'){
		$templateklinik->setValue('pen_bb_tdk',$checked);
		$templateklinik->setValue('pen_bb_tdk_yakin',$unChecked);
		$templateklinik->setValue('pen_ya',$unChecked);
		$templateklinik->setValue('pen_bb_1',$unChecked);
		$templateklinik->setValue('pen_bb_6',$unChecked);
		$templateklinik->setValue('pen_bb_11',$unChecked);
		$templateklinik->setValue('pen_bb_15',$unChecked);
		$templateklinik->setValue('pen_bb_0',$unChecked);
	}else if($dat_pengkajian['PENURUNAN_BERAT_BADAN'] == 'Tidak Yakin'){
		$templateklinik->setValue('pen_bb_tdk',$unChecked);
		$templateklinik->setValue('pen_bb_tdk_yakin',$checked);
		$templateklinik->setValue('pen_ya',$unChecked);
		$templateklinik->setValue('pen_bb_1',$unChecked);
		$templateklinik->setValue('pen_bb_6',$unChecked);
		$templateklinik->setValue('pen_bb_11',$unChecked);
		$templateklinik->setValue('pen_bb_15',$unChecked);
		$templateklinik->setValue('pen_bb_0',$unChecked);
	}else if($dat_pengkajian['PENURUNAN_BERAT_BADAN'] == 'Ada|1 - 5 kg'){
		$templateklinik->setValue('pen_bb_tdk',$unChecked);
		$templateklinik->setValue('pen_bb_tdk_yakin',$unChecked);
		$templateklinik->setValue('pen_ya',$checked);
		$templateklinik->setValue('pen_bb_1',$checked);
		$templateklinik->setValue('pen_bb_6',$unChecked);
		$templateklinik->setValue('pen_bb_11',$unChecked);
		$templateklinik->setValue('pen_bb_15',$unChecked);
		$templateklinik->setValue('pen_bb_0',$unChecked);
	}else if($dat_pengkajian['PENURUNAN_BERAT_BADAN'] == 'Ada|6 - 10 kg'){
		$templateklinik->setValue('pen_bb_tdk',$unChecked);
		$templateklinik->setValue('pen_bb_tdk_yakin',$unChecked);
		$templateklinik->setValue('pen_ya',$checked);
		$templateklinik->setValue('pen_bb_1',$unChecked);
		$templateklinik->setValue('pen_bb_6',$checked);
		$templateklinik->setValue('pen_bb_11',$unChecked);
		$templateklinik->setValue('pen_bb_15',$unChecked);
		$templateklinik->setValue('pen_bb_0',$unChecked);
	}else if($dat_pengkajian['PENURUNAN_BERAT_BADAN'] == 'Ada|- 15 kg'){
		$templateklinik->setValue('pen_bb_tdk',$unChecked);
		$templateklinik->setValue('pen_bb_tdk_yakin',$unChecked);
		$templateklinik->setValue('pen_ya',$checked);
		$templateklinik->setValue('pen_bb_1',$unChecked);
		$templateklinik->setValue('pen_bb_6',$unChecked);
		$templateklinik->setValue('pen_bb_11',$checked);
		$templateklinik->setValue('pen_bb_15',$unChecked);
		$templateklinik->setValue('pen_bb_0',$unChecked);
	}else if($dat_pengkajian['PENURUNAN_BERAT_BADAN'] == 'Ada|> 15 kg'){
		$templateklinik->setValue('pen_bb_tdk',$unChecked);
		$templateklinik->setValue('pen_bb_tdk_yakin',$unChecked);
		$templateklinik->setValue('pen_ya',$checked);
		$templateklinik->setValue('pen_bb_1',$unChecked);
		$templateklinik->setValue('pen_bb_6',$unChecked);
		$templateklinik->setValue('pen_bb_11',$unChecked);
		$templateklinik->setValue('pen_bb_15',$checked);
		$templateklinik->setValue('pen_bb_0',$unChecked);
	}else if($dat_pengkajian['PENURUNAN_BERAT_BADAN'] == 'Ada|Tidak Tahu'){
		$templateklinik->setValue('pen_bb_tdk',$unChecked);
		$templateklinik->setValue('pen_bb_tdk_yakin',$unChecked);
		$templateklinik->setValue('pen_ya',$checked);
		$templateklinik->setValue('pen_bb_1',$unChecked);
		$templateklinik->setValue('pen_bb_6',$unChecked);
		$templateklinik->setValue('pen_bb_11',$unChecked);
		$templateklinik->setValue('pen_bb_15',$unChecked);
		$templateklinik->setValue('pen_bb_0',$checked);
	}else{
		$templateklinik->setValue('pen_bb_tdk',$unChecked);
		$templateklinik->setValue('pen_bb_tdk_yakin',$unChecked);
		$templateklinik->setValue('pen_ya',$unChecked);
		$templateklinik->setValue('pen_bb_1',$unChecked);
		$templateklinik->setValue('pen_bb_6',$unChecked);
		$templateklinik->setValue('pen_bb_11',$unChecked);
		$templateklinik->setValue('pen_bb_15',$unChecked);
		$templateklinik->setValue('pen_bb_0',$unChecked);
	}	
	
	if($dat_pengkajian['TIDAK_NAFSU_MAKAN'] == 'Tidak'){
		$templateklinik->setValue('asupan_mkn_tdk',$checked);
		$templateklinik->setValue('asupan_mkn_ya',$unChecked);
	}else if($dat_pengkajian['TIDAK_NAFSU_MAKAN'] == 'Ya'){
		$templateklinik->setValue('asupan_mkn_tdk',$unChecked);
		$templateklinik->setValue('asupan_mkn_ya',$checked);	
	}else{
		$templateklinik->setValue('asupan_mkn_tdk',$unChecked);
		$templateklinik->setValue('asupan_mkn_ya',$unChecked);
	}		
	
	$skor = 0;
	if($dat_pengkajian['PENURUNAN_BERAT_BADAN'] == 'Tidak Ada') $skor = $skor + 0;
	if($dat_pengkajian['PENURUNAN_BERAT_BADAN'] == 'Tidak Yakin') $skor = $skor + 2;
	if($dat_pengkajian['PENURUNAN_BERAT_BADAN'] == 'Ada|1 - 5 kg') $skor = $skor + 1;
	if($dat_pengkajian['PENURUNAN_BERAT_BADAN'] == 'Ada|6 - 10 kg') $skor = $skor + 2;
	if($dat_pengkajian['PENURUNAN_BERAT_BADAN'] == 'Ada|- 15 kg') $skor = $skor + 3;
	if($dat_pengkajian['PENURUNAN_BERAT_BADAN'] == 'Ada|> 15 kg') $skor = $skor + 4;
	if($dat_pengkajian['PENURUNAN_BERAT_BADAN'] == 'Ada|Tidak Tahu') $skor = $skor + 2;
	if($dat_pengkajian['TIDAK_NAFSU_MAKAN'] == 'Tidak') $skor = $skor + 0;
	if($dat_pengkajian['TIDAK_NAFSU_MAKAN'] == 'Ya') $skor = $skor + 1;
	$templateklinik->setValue('skor',$skor);
	
	if($dat_pengkajian['DIAGNOSIS_KHUSUS'] == 'Ya'){
		$templateklinik->setValue('diag_ya',$checked);
		$templateklinik->setValue('diag_tidak',$unChecked);
	}else if($dat_pengkajian['DIAGNOSIS_KHUSUS'] == 'tidak'){
		$templateklinik->setValue('diag_ya',$unChecked);
		$templateklinik->setValue('diag_tidak',$checked);	
	}else{
		$templateklinik->setValue('diag_ya',$unChecked);
		$templateklinik->setValue('diag_tidak',$unChecked);
	}		
	
	if($dat_pengkajian['DIAGNOSA_KHUSUS_DM'] == '1'){
		$templateklinik->setValue('diag_dm',$checked);
	}else{
		$templateklinik->setValue('diag_dm',$unChecked);
	}

	if($dat_pengkajian['DIAGNOSA_KHUSUS_KEMOTERAPI'] == '1'){
		$templateklinik->setValue('diag_kemo',$checked);
	}else{
		$templateklinik->setValue('diag_kemo',$unChecked);
	}	
	
	if($dat_pengkajian['DIAGNOSA_KHUSUS_HEMODIALISA'] == '1'){
		$templateklinik->setValue('diag_hemo',$checked);
	}else{
		$templateklinik->setValue('diag_hemo',$unChecked);
	}
	
	if($dat_pengkajian['DIAGNOSA_KHUSUS_GERIATRI'] == '1'){
		$templateklinik->setValue('diag_geri',$checked);
	}else{
		$templateklinik->setValue('diag_geri',$unChecked);
	}
	
	if($dat_pengkajian['DIAGNOSA_KHUSUS_IMUNITAS'] == '1'){
		$templateklinik->setValue('diag_imm',$checked);
	}else{
		$templateklinik->setValue('diag_imm',$unChecked);
	}
	
	if($dat_pengkajian['DIAGNOSA_KHUSUS_LAIN'] == '1'){
		$templateklinik->setValue('diag_lain',$checked);
	}else{
		$templateklinik->setValue('diag_lain',$unChecked);
	}
	
	$templateklinik->setValue('diag_sebutkan',htmlspecialchars($dat_pengkajian['KETERANGAN_DIAGNOSIS_KHUSUS']));
	
	if($dat_pengkajian['STATUS_FUNGSIONAL'] == 'Mandiri'){
		$templateklinik->setValue('sf_mandiri',$checked);
		$templateklinik->setValue('sf_bantuan',$unChecked);
		$templateklinik->setValue('sf_ketergantungan',$unChecked);
	}else if($dat_pengkajian['STATUS_FUNGSIONAL'] == 'Perlu Bantuan'){	
		$templateklinik->setValue('sf_mandiri',$unChecked);
		$templateklinik->setValue('sf_bantuan',$checked);
		$templateklinik->setValue('sf_ketergantungan',$unChecked);
	}else if($dat_pengkajian['STATUS_FUNGSIONAL'] == 'Ketergantungan Total'){	
		$templateklinik->setValue('sf_mandiri',$unChecked);
		$templateklinik->setValue('sf_bantuan',$unChecked);
		$templateklinik->setValue('sf_ketergantungan',$checked);
	}else{
		$templateklinik->setValue('sf_mandiri',$unChecked);
		$templateklinik->setValue('sf_bantuan',$unChecked);
		$templateklinik->setValue('sf_ketergantungan',$unChecked);
	}
	
	$templateklinik->setValue('sf_keterangan',htmlspecialchars($dat_pengkajian['KETERANGAN_STATUS_FUNGSIONAL']));
	$templateklinik->setValue('sf_pukul',htmlspecialchars($dat_pengkajian['KETERANGAN_STATUS_FUNGSIONAL_KETERGANTUNGAN']));
	
	if($dat_pengkajian['CARA_BERJALAN'] == 'Ya'){
		$templateklinik->setValue('jatuh_ya',$checked);
		$templateklinik->setValue('jatuh_tdk',$unChecked);
	}else if($dat_pengkajian['CARA_BERJALAN'] == 'Tidak'){
		$templateklinik->setValue('jatuh_ya',$unChecked);
		$templateklinik->setValue('jatuh_tdk',$checked);	
	}else{
		$templateklinik->setValue('jatuh_ya',$unChecked);
		$templateklinik->setValue('jatuh_tdk',$unChecked);
	}
	
	if($dat_pengkajian['CARA_DUDUK'] == 'Ya'){
		$templateklinik->setValue('duduk_ya',$checked);
		$templateklinik->setValue('duduk_tdk',$unChecked);
	}else if($dat_pengkajian['CARA_DUDUK'] == 'Tidak'){
		$templateklinik->setValue('duduk_ya',$unChecked);
		$templateklinik->setValue('duduk_tdk',$checked);	
	}else{
		$templateklinik->setValue('duduk_ya',$unChecked);
		$templateklinik->setValue('duduk_tdk',$unChecked);
	}
	
	$hasil_resiko = '';
	if(($dat_pengkajian['CARA_BERJALAN'] == 'Tidak') and ($dat_pengkajian['CARA_DUDUK'] == 'Tidak')) $hasil_resiko = 'Tidak Berisiko';
	if(($dat_pengkajian['CARA_BERJALAN'] == 'Ya') and ($dat_pengkajian['CARA_DUDUK'] == 'Ya')) $hasil_resiko = 'Risiko Tinggi';
	if(($dat_pengkajian['CARA_BERJALAN'] == 'Tidak') and ($dat_pengkajian['CARA_DUDUK'] == 'Ya')) $hasil_resiko = 'Risiko Rendah';
	if(($dat_pengkajian['CARA_BERJALAN'] == 'Ya') and ($dat_pengkajian['CARA_DUDUK'] == 'Tidak')) $hasil_resiko = 'Risiko Rendah';
	
	if($hasil_resiko == 'Tidak Berisiko'){
		$templateklinik->setValue('resiko_tdk',$checked);
		$templateklinik->setValue('resiko_tinggi',$unChecked);
		$templateklinik->setValue('resiko_rendah',$unChecked);
	}else if($hasil_resiko == 'Risiko Tinggi'){
		$templateklinik->setValue('resiko_tdk',$unChecked);
		$templateklinik->setValue('resiko_tinggi',$checked);
		$templateklinik->setValue('resiko_rendah',$unChecked);	
	}else if($hasil_resiko == 'Risiko Rendah'){
		$templateklinik->setValue('resiko_tdk',$unChecked);
		$templateklinik->setValue('resiko_tinggi',$unChecked);
		$templateklinik->setValue('resiko_rendah',$checked);	
	}else{
		$templateklinik->setValue('resiko_tdk',$unChecked);
		$templateklinik->setValue('resiko_tinggi',$unChecked);
		$templateklinik->setValue('resiko_rendah',$unChecked);
	}
	
	if($dat_pengkajian['RESIKO_JATUH'] == 'Ya'){
		$templateklinik->setValue('dbd_ya',$checked);
		$templateklinik->setValue('dbd_tidak',$unChecked);
	}else if($dat_pengkajian['RESIKO_JATUH'] == 'Tidak'){
		$templateklinik->setValue('dbd_ya',$unChecked);
		$templateklinik->setValue('dbd_tidak',$checked);	
	}else{
		$templateklinik->setValue('dbd_ya',$unChecked);
		$templateklinik->setValue('dbd_tidak',$unChecked);
	}
	
	$templateklinik->setValue('dbd_pukul',htmlspecialchars($dat_pengkajian['KETERANGAN_RESIKO_JATUH']));
	
	if($dat_pengkajian['NYERI'] == 'Tidak Ada'){
		$templateklinik->setValue('sk_tidak',$checked);
		$templateklinik->setValue('sk_kronis',$unChecked);
		$templateklinik->setValue('sk_akut',$unChecked);
	}else if($dat_pengkajian['NYERI'] == 'Nyeri Kronis'){
		$templateklinik->setValue('sk_tidak',$unChecked);
		$templateklinik->setValue('sk_kronis',$checked);
		$templateklinik->setValue('sk_akut',$unChecked);
	}else if($dat_pengkajian['NYERI'] == 'Nyeri Akut'){
		$templateklinik->setValue('sk_tidak',$unChecked);
		$templateklinik->setValue('sk_kronis',$unChecked);
		$templateklinik->setValue('sk_akut',$checked);		
	}else{
		$templateklinik->setValue('sk_tidak',$unChecked);
		$templateklinik->setValue('sk_kronis',$unChecked);
		$templateklinik->setValue('sk_akut',$unChecked);
	}
	
	$templateklinik->setValue('onset',$dat_pengkajian['FREKUENSI_NYERI']);
	$templateklinik->setValue('pemicu',$dat_pengkajian['PEMICU_NYERI']);
	$templateklinik->setValue('kualitas',$dat_pengkajian['KUALITAS_NYERI']);
	$templateklinik->setValue('lokasi',$dat_pengkajian['LOKASI_NYERI']);
	$templateklinik->setValue('skala',$dat_pengkajian['SKALA_NYERI']);
	
	if($dat_pengkajian['NYERI_HILANG'] == 'Minum Obat'){
		$templateklinik->setValue('ny_obat',$checked);
		$templateklinik->setValue('ny_musik',$unChecked);
		$templateklinik->setValue('ny_ist',$unChecked);
		$templateklinik->setValue('ny_posisi',$unChecked);
		$templateklinik->setValue('ny_lain',$unChecked);
	}else if($dat_pengkajian['NYERI_HILANG'] == 'Mendengar Musik'){
		$templateklinik->setValue('ny_obat',$unChecked);
		$templateklinik->setValue('ny_musik',$checked);
		$templateklinik->setValue('ny_ist',$unChecked);
		$templateklinik->setValue('ny_posisi',$unChecked);
		$templateklinik->setValue('ny_lain',$unChecked);
	}else if($dat_pengkajian['NYERI_HILANG'] == 'Berubah Posisi'){
		$templateklinik->setValue('ny_obat',$unChecked);
		$templateklinik->setValue('ny_musik',$unChecked);
		$templateklinik->setValue('ny_ist',$unChecked);
		$templateklinik->setValue('ny_posisi',$checked);
		$templateklinik->setValue('ny_lain',$unChecked);
	}else if($dat_pengkajian['NYERI_HILANG'] == 'Istirahat'){
		$templateklinik->setValue('ny_obat',$unChecked);
		$templateklinik->setValue('ny_musik',$unChecked);
		$templateklinik->setValue('ny_ist',$checked);
		$templateklinik->setValue('ny_posisi',$unChecked);
		$templateklinik->setValue('ny_lain',$unChecked);
	}else if($dat_pengkajian['NYERI_HILANG'] == 'Lain-lain'){
		$templateklinik->setValue('ny_obat',$unChecked);
		$templateklinik->setValue('ny_musik',$unChecked);
		$templateklinik->setValue('ny_ist',$unChecked);
		$templateklinik->setValue('ny_posisi',$unChecked);
		$templateklinik->setValue('ny_lain',$checked);	
	}else{
		$templateklinik->setValue('ny_obat',$unChecked);
		$templateklinik->setValue('ny_musik',$unChecked);
		$templateklinik->setValue('ny_ist',$unChecked);
		$templateklinik->setValue('ny_posisi',$unChecked);
		$templateklinik->setValue('ny_lain',$unChecked);
	}	
	
	$ny_ket = replace_newline($dat_pengkajian['KETERANGAN_NYERI_HILANG']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($ny_ket);
	$templateklinik->setValue('ny_ket', $toOpenXML);
	
	if($dat_pengkajian['STATUS_NYERI_HILANG'] == 'Ya'){
		$templateklinik->setValue('dokter_ya',$checked);
		$templateklinik->setValue('dokter_tidak',$unChecked);
	}else if($dat_pengkajian['STATUS_NYERI_HILANG'] == 'Tidak'){
		$templateklinik->setValue('dokter_ya',$unChecked);
		$templateklinik->setValue('dokter_tidak',$checked);	
	}else{
		$templateklinik->setValue('dokter_ya',$unChecked);
		$templateklinik->setValue('dokter_tidak',$unChecked);
	}		
	
	$templateklinik->setValue('dokter_pukul',htmlspecialchars($dat_pengkajian['KETERANGAN_STATUS_NYERI_HILANG']));
	
	$alergi_obat = replace_newline($dat_pengkajian['RIWAYAT_ALERGI_OBAT']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($alergi_obat);
	$templateklinik->setValue('alergi_obat',$toOpenXML);
	
	$diagnosa_keperawatan = replace_newline($dat_pengkajian['DIAGNOSA_KEPERAWATAN']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($diagnosa_keperawatan);
	$templateklinik->setValue('diagnosa_keperawatan', $toOpenXML);
	
	$rencana_keperawatan = replace_newline($dat_pengkajian['RENCANA_KEPERAWATAN']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($rencana_keperawatan);
	$templateklinik->setValue('rencana_keperawatan',$toOpenXML);
	
	$implementasi_keperawatan = replace_newline($dat_pengkajian['IMPELEMENTASI_KEPERAWATAN']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($implementasi_keperawatan);
	$templateklinik->setValue('implementasi_keperawatan',$toOpenXML);
	
	$evaluasi_keperawatan = replace_newline($dat_pengkajian['EVALUASI_KEPERAWATAN']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($evaluasi_keperawatan);
	$templateklinik->setValue('evaluasi_keperawatan',$toOpenXML);
	
	if(!file_exists($rmfile_path . '/pdf/1/' . $nomr . '/' . $idxord)){
		@mkdir($rmfile_path . '/pdf/1/' . $nomr . '/' . $idxord, 0700, true);
	}

	if(!file_exists($rmfile_path . '/doc/1/' . $nomr . '/' . $idxord)){
		@mkdir($rmfile_path . '/doc/1/' . $nomr . '/' . $idxord, 0700, true);
	}
	
	$nama_file = $nomr . '_' . $idxord . $idx . '_36';	
	/*
	if($final == '1' and $ls_assesment != $tgl_skr){
		$qry_rev = 'SELECT COUNT(FILE_ID) + 1 AS REV FROM t_rm_dokumen_file
			WHERE RAWAT_ID = "' . $idxord . '"
			AND JNS_PERAWATAN = "' . $jns_perawatan . '"
			' . (($jns_order != '') ? 'AND ORDER_PENUNJANG = "' . $idx . '"' : '') . '
			AND JENIS_DOKUMEN_ID = "8"';
		$get_rev = mysql_query($qry_rev) or die(mysql_error());
		$dat_rev = mysql_fetch_assoc($get_rev);
		$nama_file .= '_' . $dat_rev['REV'];	
	}
	*/
	$templateklinik->saveAs($rmfile_path . '/doc/1/' . $nomr . '/' . $idxord . '/' . $nama_file . '.docx');
	
	mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE RAWAT_ID = "' . $idxord . '"
				AND JNS_PERAWATAN = "' . $jns_perawatan . '"
				AND JENIS_DOKUMEN_ID = "36"
				' . (($jns_order != '') ? 'AND ORDER_PENUNJANG = "' . $idx . '"' : 'AND ORDER_PENUNJANG IS NULL') . '
				AND NAMA_FILE = "' . $nama_file . '.pdf"') or die(mysql_error());
	mysql_query('INSERT INTO t_rm_dokumen_file(JENIS_DOKUMEN_ID,
				NOMR,
				RAWAT_ID,
				JNS_PERAWATAN,
				ORDER_PENUNJANG,
				NAMA_FILE,
				ST_SISTEM,
				TANGGAL) 		
				VALUES("36",
				"' . $nomr . '",
				"' . $idxord . '",
				"' . $jns_perawatan . '",
				' . (($jns_order != '') ? '"' . $idx . '"' : 'NULL') . ',
				"' . $nama_file . '.pdf",
				"1",
				STR_TO_DATE("' . $tgl_daftar . '","%d/%m/%Y"))') or die(mysql_error());
	
	$source_file = $rmfile_path . '/doc/1/' . $nomr . '/' . $idxord . '/' . $nama_file . '.docx';			
	$source_file = str_replace('/','\\',$source_file);
	$target_file = $rmfile_path . '/pdf/1/' . $nomr . '/' . $idxord . '/' . $nama_file . '.pdf';
	$target_file = str_replace('/','\\',$target_file);
	
	try{
		$word = new COM("Word.Application") or die ("Could not initialise Object.");
		$word->Visible = 0;
		$word->DisplayAlerts = 0;
		$word->Documents->Open($source_file,false,true);
		if(file_exists($target_file)){
			unlink($target_file);
		}
		$word->ActiveDocument->ExportAsFixedFormat($target_file, 17, false, 0, 0, 0, 0, 7, true, true, 2, true, true, false);
		$word->Quit(false);
		unset($word);
	} catch (Exception $e) {
		echo $e;
	}
	
}	
?>