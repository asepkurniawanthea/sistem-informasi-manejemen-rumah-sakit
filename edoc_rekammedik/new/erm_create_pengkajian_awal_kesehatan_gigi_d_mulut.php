<?php
function replace_newline($str){
	$ret = preg_replace('/\r|\n/','\n',trim($str));
	$ret = str_replace('\n','<br>',$ret);
	$ret = str_replace('<br><br>','<br>',$ret);
	return $ret;
}

function erm_pengkajian_awal_kesehatan_gigi_d_mulut($idx,$ls_assesment='',$tgl_skr='',$final=''){
	global $rmfile_path, $app_path;

	$checked = '<w:sym w:font="Wingdings" w:char="F0FE"/>';
    $unChecked = '<w:sym w:font="Wingdings" w:char="F0A8"/>';
	
	$templateklinik = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\pengkajian_awal_kesehatan_gigi_d_mulut.docx');
	
	$qry_pasien = 'SELECT t_irja.IRJA_ID,t_irja.NOMR,t_irja.PEGAWAI_ID,m_pegawai.NAMA_PEGAWAI,
				t_irja.ASAL_PASIEN_ID,t_irja.KET_ASAL_PASIEN,t_irja.UNIT_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				DATE_FORMAT(t_irja.PASIEN_MASUK,"%d-%m-%Y %H:%i") AS PASIEN_MASUK,t_irja.JENIS_BAYAR_ID,m_pasien.NO_TELEPON,
				DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_unit.NAMA_UNIT
				FROM t_irja
				INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_irja.IRJA_ID = "' . $idx . '"';
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
	
	$qry_pengkajian = 'SELECT IRJA_ASKEP_ID,KELUHAN_UTAMA,TANDA_VITAL,ANTROPOMETRI,STATUS_FUNGSIONAL,NYERI,RIWAYAT_KESEHATAN_UMUM,
				RIWAYAT_KESEHATAN_GIGI_MULUT,RIWAYAT_ALERGI,DIAGNOSA,IMPELEMENTASI,EVALUASI,
				USER_KLINIK,DATE_FORMAT(TGL_ASSESMENT,"%d-%m-%Y %H:%i") AS TGL_ASSESMENT,
				NAMA_PEGAWAI
				FROM t_irja_pengkajian_awal_kesehatan_mulut
				INNER JOIN m_pegawai ON (t_irja_pengkajian_awal_kesehatan_mulut.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE IRJA_ASKEP_ID = "' . $idx . '"';
	$get_pengkajian = mysql_query($qry_pengkajian) or die(mysql_error());
	$dat_pengkajian = mysql_fetch_assoc($get_pengkajian);
	$idx = $dat_pengkajian['IRJA_ASKEP_ID'];
	$templateklinik->setValue('tgl_assesment', $dat_pengkajian['TGL_ASSESMENT']);
	$templateklinik->setValue('dicetak_oleh', '');
	$templateklinik->setValue('nama_perawat', htmlspecialchars($dat_pengkajian['NAMA_PEGAWAI']));
	
	$keluhan_utama = $dat_pengkajian['KELUHAN_UTAMA'];
	$alergi = $dat_pengkajian['RIWAYAT_ALERGI'];
	 
	$tanda_vital = str_replace('|','"',$dat_pengkajian['TANDA_VITAL']);
	$tanda_vital = preg_replace('/\r|\n/','\n',trim($tanda_vital));
	$tanda_vital = json_decode($tanda_vital,true);

	$antropometri = str_replace('|','"',$dat_pengkajian['ANTROPOMETRI']);
	$antropometri = preg_replace('/\r|\n/','\n',trim($antropometri));
	$antropometri = json_decode($antropometri,true);

	$status_fungsional = str_replace('|','"',$dat_pengkajian['STATUS_FUNGSIONAL']);
	$status_fungsional = preg_replace('/\r|\n/','\n',trim($status_fungsional));
	$status_fungsional = json_decode($status_fungsional,true);

	$nyeri = str_replace('|','"',$dat_pengkajian['NYERI']);
	$nyeri = preg_replace('/\r|\n/','\n',trim($nyeri));
	$nyeri = json_decode($nyeri,true);

	$kesehatan_umum = str_replace('|','"',$dat_pengkajian['RIWAYAT_KESEHATAN_UMUM']);
	$kesehatan_umum = preg_replace('/\r|\n/','\n',trim($kesehatan_umum));
	$kesehatan_umum = json_decode($kesehatan_umum,true);

	$kesehatan_mulut = str_replace('|','"',$dat_pengkajian['RIWAYAT_KESEHATAN_GIGI_MULUT']);
	$kesehatan_mulut = preg_replace('/\r|\n/','\n',trim($kesehatan_mulut));
	$kesehatan_mulut = json_decode($kesehatan_mulut,true);

	$diagnosa = str_replace('|','"',$dat_pengkajian['DIAGNOSA']);
	$diagnosa = preg_replace('/\r|\n/','\n',trim($diagnosa));
	$diagnosa = json_decode($diagnosa,true);

	$implementasi = str_replace('|','"',$dat_pengkajian['IMPELEMENTASI']);
	$implementasi = preg_replace('/\r|\n/','\n',trim($implementasi));
	$implementasi = json_decode($implementasi,true);

	$evaluasi = str_replace('|','"',$dat_pengkajian['EVALUASI']);
	$evaluasi = preg_replace('/\r|\n/','\n',trim($evaluasi));
	$evaluasi = json_decode($evaluasi,true);
	
	$keluhan_utama = replace_newline($keluhan_utama);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($keluhan_utama);
	$templateklinik->setValue('keluhan_utama',$toOpenXML);
	
	$alergi = replace_newline($alergi);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($alergi);
	$templateklinik->setValue('alergi',$toOpenXML);
	
	$templateklinik->setValue('tekanan_darah',htmlspecialchars($tanda_vital['td']));
	$templateklinik->setValue('frek_nafas',htmlspecialchars($tanda_vital['rr']));
	$templateklinik->setValue('suhu_tubuh',htmlspecialchars($tanda_vital['suhu']));
	$templateklinik->setValue('frek_nadi',htmlspecialchars($tanda_vital['nadi']));
	
	$templateklinik->setValue('bb',htmlspecialchars($antropometri['bb']));
	$templateklinik->setValue('tb',htmlspecialchars($antropometri['tb']));
	
	$templateklinik->setValue('alat_bantu',htmlspecialchars($status_fungsional['alat_bantu']));
	$templateklinik->setValue('prothesa',htmlspecialchars($status_fungsional['prothesa']));
	$templateklinik->setValue('cacat_tubuh',htmlspecialchars($status_fungsional['cacat']));
	
	if($status_fungsional['adl'] == '1'){
		$templateklinik->setValue('adl_1',$checked);
		$templateklinik->setValue('adl_2',$unChecked);
	}else if($status_fungsional['adl'] == '2'){
		$templateklinik->setValue('adl_1',$unChecked);
		$templateklinik->setValue('adl_2',$checked);
	}else{
		$templateklinik->setValue('adl_1',$unChecked);
		$templateklinik->setValue('adl_2',$unChecked);
	}	
	
	if($status_fungsional['jatuh'] == '1'){
		$templateklinik->setValue('jatuh_1',$checked);
		$templateklinik->setValue('jatuh_2',$unChecked);
		$templateklinik->setValue('jatuh_3',$unChecked);
	}else if($status_fungsional['adl'] == '2'){
		$templateklinik->setValue('jatuh_1',$unChecked);
		$templateklinik->setValue('jatuh_2',$checked);
		$templateklinik->setValue('jatuh_3',$unChecked);
	}else if($status_fungsional['adl'] == '3'){
		$templateklinik->setValue('jatuh_1',$unChecked);
		$templateklinik->setValue('jatuh_2',$unChecked);
		$templateklinik->setValue('jatuh_3',$checked);	
	}else{
		$templateklinik->setValue('jatuh_1',$unChecked);
		$templateklinik->setValue('jatuh_2',$unChecked);
		$templateklinik->setValue('jatuh_3',$unChecked);
	}	
	
	$templateklinik->setValue('score_jatuh',htmlspecialchars($status_fungsional['score'] - 1));
	
	if($status_fungsional['tindakan_edukasi'] == '1'){
		$templateklinik->setValue('tindakan_1',$checked);
	}else{
		$templateklinik->setValue('tindakan_1',$unChecked);
	}	
	
	if($status_fungsional['pita_kuning'] == '1'){
		$templateklinik->setValue('tindakan_2',$checked);
	}else{
		$templateklinik->setValue('tindakan_2',$unChecked);
	}
	
	if($nyeri['rasa'] == '1'){
		$templateklinik->setValue('rasa_nyeri_1',$checked);
		$templateklinik->setValue('rasa_nyeri_2',$unChecked);
	}else if($nyeri['rasa'] == '2'){
		$templateklinik->setValue('rasa_nyeri_1',$unChecked);
		$templateklinik->setValue('rasa_nyeri_2',$checked);
	}else{
		$templateklinik->setValue('rasa_nyeri_1',$unChecked);
		$templateklinik->setValue('rasa_nyeri_2',$unChecked);
	}
	
	$templateklinik->setValue('skor_nyeri',htmlspecialchars($nyeri['skor']));
	$templateklinik->setValue('durasi_nyeri',htmlspecialchars($nyeri['durasi']));
	$templateklinik->setValue('frekuensi_nyeri',htmlspecialchars($nyeri['frekuensi']));
	
	if($nyeri['berdenyut'] == '1'){
		$templateklinik->setValue('karakter_nyeri_1',$checked);
	}else{
		$templateklinik->setValue('karakter_nyeri_1',$unChecked);
	}	
	if($nyeri['ngilu'] == '1'){
		$templateklinik->setValue('karakter_nyeri_2',$checked);
	}else{
		$templateklinik->setValue('karakter_nyeri_2',$unChecked);
	}
	if($nyeri['tertusuk'] == '1'){
		$templateklinik->setValue('karakter_nyeri_3',$checked);
	}else{
		$templateklinik->setValue('karakter_nyeri_3',$unChecked);
	}
	if($nyeri['tertekan'] == '1'){
		$templateklinik->setValue('karakter_nyeri_4',$checked);
	}else{
		$templateklinik->setValue('karakter_nyeri_4',$unChecked);
	}
	if($nyeri['tajam'] == '1'){
		$templateklinik->setValue('karakter_nyeri_5',$checked);
	}else{
		$templateklinik->setValue('karakter_nyeri_5',$unChecked);
	}
	
	if($kesehatan_umum['sistemik_hipertensi'] == '1'){
		$templateklinik->setValue('sis_hipertensi',$checked);
	}else{
		$templateklinik->setValue('sis_hipertensi',$unChecked);
	}
	if($kesehatan_umum['sistemik_kardiovaskular'] == '1'){
		$templateklinik->setValue('sis_kardiovaskular',$checked);
	}else{
		$templateklinik->setValue('sis_kardiovaskular',$unChecked);
	}
	if($kesehatan_umum['sistemik_diabetes'] == '1'){
		$templateklinik->setValue('sis_diabetes',$checked);
	}else{
		$templateklinik->setValue('sis_diabetes',$unChecked);
	}
	if($kesehatan_umum['sistemik_keldarah'] == '1'){
		$templateklinik->setValue('sis_keldarah',$checked);
	}else{
		$templateklinik->setValue('sis_keldarah',$unChecked);
	}
	$templateklinik->setValue('sis_lain',htmlspecialchars($kesehatan_umum['sistemik']));
	
	if($kesehatan_umum['sistemik_r'] == '1'){
		$templateklinik->setValue('sistemik_tidak',$checked);
		$templateklinik->setValue('sistemik_ya',$unChecked);
	}else if($kesehatan_umum['sistemik_r'] == '2'){
		$templateklinik->setValue('sistemik_tidak',$unChecked);
		$templateklinik->setValue('sistemik_ya',$checked);
	}else{
		$templateklinik->setValue('sistemik_tidak',$unChecked);
		$templateklinik->setValue('sistemik_ya',$unChecked);
	}
	
	if($kesehatan_umum['khusus_cp'] == '1'){
		$templateklinik->setValue('khu_cp',$checked);
	}else{
		$templateklinik->setValue('khu_cp',$unChecked);
	}
	if($kesehatan_umum['khusus_dsindrome'] == '1'){
		$templateklinik->setValue('khu_dsindrome',$checked);
	}else{
		$templateklinik->setValue('khu_dsindrome',$unChecked);
	}
	if($kesehatan_umum['khusus_gds'] == '1'){
		$templateklinik->setValue('khu_gds',$checked);
	}else{
		$templateklinik->setValue('khu_gds',$unChecked);
	}
	
	if($kesehatan_umum['khusus_r'] == '1'){
		$templateklinik->setValue('khusus_tidak',$checked);
		$templateklinik->setValue('khusus_ya',$unChecked);
	}else if($kesehatan_umum['khusus_r'] == '2'){
		$templateklinik->setValue('khusus_tidak',$unChecked);
		$templateklinik->setValue('khusus_ya',$checked);
	}else{
		$templateklinik->setValue('khusus_tidak',$unChecked);
		$templateklinik->setValue('khusus_ya',$unChecked);
	}
	
	$templateklinik->setValue('khu_lain',htmlspecialchars($kesehatan_umum['khusus']));
	
	if($kesehatan_umum['obat_rutin'] == '1'){
		$templateklinik->setValue('obat_rutin',$checked);
	}else{
		$templateklinik->setValue('obat_rutin',$unChecked);
	}
	if($kesehatan_umum['obat_kemoterapi'] == '1'){
		$templateklinik->setValue('obat_kemoterapi',$checked);
	}else{
		$templateklinik->setValue('obat_kemoterapi',$unChecked);
	}
	if($kesehatan_umum['obat_radiasi'] == '1'){
		$templateklinik->setValue('obat_radiasi',$checked);
	}else{
		$templateklinik->setValue('obat_radiasi',$unChecked);
	}
	if($kesehatan_umum['obat_medika'] == '1'){
		$templateklinik->setValue('obat_medikasi',$checked);
	}else{
		$templateklinik->setValue('obat_medikasi',$unChecked);
	}
	
	$templateklinik->setValue('obat_lain',htmlspecialchars($kesehatan_umum['obat']));
	
	if($kesehatan_umum['obat_r'] == '1'){
		$templateklinik->setValue('obat_tidak',$checked);
		$templateklinik->setValue('obat_ya',$unChecked);
	}else if($kesehatan_umum['obat_r'] == '2'){
		$templateklinik->setValue('obat_tidak',$unChecked);
		$templateklinik->setValue('obat_ya',$checked);
	}else{
		$templateklinik->setValue('obat_tidak',$unChecked);
		$templateklinik->setValue('obat_ya',$unChecked);
	}
	
	if($kesehatan_umum['alkohol_a'] == '1'){
		$templateklinik->setValue('alkohol_a',$checked);
	}else{
		$templateklinik->setValue('alkohol_a',$unChecked);
	}
	if($kesehatan_umum['alkohol_merokok'] == '1'){
		$templateklinik->setValue('alkohol_merokok',$checked);
	}else{
		$templateklinik->setValue('alkohol_merokok',$unChecked);
	}
	if($kesehatan_umum['alkohol_narkoba'] == '1'){
		$templateklinik->setValue('alkohol_narkoba',$checked);
	}else{
		$templateklinik->setValue('alkohol_narkoba',$unChecked);
	}
	
	$templateklinik->setValue('alkohol_lain',htmlspecialchars($kesehatan_umum['alkohol']));
	
	if($kesehatan_umum['alkohol_r'] == '1'){
		$templateklinik->setValue('alkohol_tidak',$checked);
		$templateklinik->setValue('alkohol_ya',$unChecked);
	}else if($kesehatan_umum['alkohol_r'] == '2'){
		$templateklinik->setValue('alkohol_tidak',$unChecked);
		$templateklinik->setValue('alkohol_ya',$checked);
	}else{
		$templateklinik->setValue('alkohol_tidak',$unChecked);
		$templateklinik->setValue('alkohol_ya',$unChecked);
	}
	
	if($kesehatan_umum['alergi_r'] == '1'){
		$templateklinik->setValue('alergi_tidak',$checked);
		$templateklinik->setValue('alergi_ya',$unChecked);
	}else if($kesehatan_umum['alergi_r'] == '2'){
		$templateklinik->setValue('alergi_tidak',$unChecked);
		$templateklinik->setValue('alergi_ya',$checked);
	}else{
		$templateklinik->setValue('alergi_tidak',$unChecked);
		$templateklinik->setValue('alergi_ya',$unChecked);
	}
	
	if($kesehatan_umum['hormonal_kehamilan'] == '1'){
		$templateklinik->setValue('hormonal_kehamilan',$checked);
	}else{
		$templateklinik->setValue('hormonal_kehamilan',$unChecked);
	}
	if($kesehatan_umum['hormonal_menopouse'] == '1'){
		$templateklinik->setValue('hormonal_menopouse',$checked);
	}else{
		$templateklinik->setValue('hormonal_menopouse',$unChecked);
	}
	if($kesehatan_umum['hormonal_puberty'] == '1'){
		$templateklinik->setValue('hormonal_puberti',$checked);
	}else{
		$templateklinik->setValue('hormonal_puberti',$unChecked);
	}
	
	$templateklinik->setValue('hormonal_lain',htmlspecialchars($kesehatan_umum['hormonal']));
	
	if($kesehatan_umum['hormonal_r'] == '1'){
		$templateklinik->setValue('hormonal_tidak',$checked);
		$templateklinik->setValue('hormonal_ya',$unChecked);
	}else if($kesehatan_umum['hormonal_r'] == '2'){
		$templateklinik->setValue('hormonal_tidak',$unChecked);
		$templateklinik->setValue('hormonal_ya',$checked);
	}else{
		$templateklinik->setValue('hormonal_tidak',$unChecked);
		$templateklinik->setValue('hormonal_ya',$unChecked);
	}
	
	if($kesehatan_umum['berat_r'] == '1'){
		$templateklinik->setValue('badan_tidak',$checked);
		$templateklinik->setValue('badan_ya',$unChecked);
	}else if($kesehatan_umum['berat_r'] == '2'){
		$templateklinik->setValue('badan_tidak',$unChecked);
		$templateklinik->setValue('badan_ya',$checked);
	}else{
		$templateklinik->setValue('badan_tidak',$unChecked);
		$templateklinik->setValue('badan_ya',$unChecked);
	}
	
	if($kesehatan_umum['makan_r'] == '1'){
		$templateklinik->setValue('makan_tidak',$checked);
		$templateklinik->setValue('makan_ya',$unChecked);
	}else if($kesehatan_umum['makan_r'] == '2'){
		$templateklinik->setValue('makan_tidak',$unChecked);
		$templateklinik->setValue('makan_ya',$checked);
	}else{
		$templateklinik->setValue('makan_tidak',$unChecked);
		$templateklinik->setValue('makan_ya',$unChecked);
	}
	
	if($kesehatan_mulut['manis'] == '1'){
		$templateklinik->setValue('manis_tidak',$checked);
		$templateklinik->setValue('manis_ya',$unChecked);
	}else if($kesehatan_mulut['manis'] == '2'){
		$templateklinik->setValue('manis_tidak',$unChecked);
		$templateklinik->setValue('manis_ya',$checked);
	}else{
		$templateklinik->setValue('manis_tidak',$unChecked);
		$templateklinik->setValue('manis_ya',$unChecked);
	}
	
	if($kesehatan_mulut['berserat'] == '1'){
		$templateklinik->setValue('berserat_tidak',$unChecked);
		$templateklinik->setValue('berserat_ya',$checked);
	}else if($kesehatan_mulut['berserat'] == '2'){
		$templateklinik->setValue('berserat_tidak',$checked);
		$templateklinik->setValue('berserat_ya',$unChecked);
	}else{
		$templateklinik->setValue('berserat_tidak',$unChecked);
		$templateklinik->setValue('berserat_ya',$unChecked);
	}
	
	if($kesehatan_mulut['sikat'] == '1'){
		$templateklinik->setValue('sikat_tidak',$unChecked);
		$templateklinik->setValue('sikat_ya',$checked);
	}else if($kesehatan_mulut['sikat'] == '2'){
		$templateklinik->setValue('sikat_tidak',$checked);
		$templateklinik->setValue('sikat_ya',$unChecked);
	}else{
		$templateklinik->setValue('sikat_tidak',$unChecked);
		$templateklinik->setValue('sikat_ya',$unChecked);
	}
	
	if($kesehatan_mulut['buruk'] == '1'){
		$templateklinik->setValue('buruk_tidak',$checked);
		$templateklinik->setValue('buruk_ya',$unChecked);
	}else if($kesehatan_mulut['buruk'] == '2'){
		$templateklinik->setValue('buruk_tidak',$unChecked);
		$templateklinik->setValue('buruk_ya',$checked);
	}else{
		$templateklinik->setValue('buruk_tidak',$unChecked);
		$templateklinik->setValue('buruk_ya',$unChecked);
	}
	
	if($kesehatan_mulut['periksa'] == '1'){
		$templateklinik->setValue('periksa_ya',$checked);
		$templateklinik->setValue('periksa_kecendrungan',$unChecked);
		$templateklinik->setValue('periksa_tidak',$unChecked);
	}else if($kesehatan_mulut['periksa'] == '2'){
		$templateklinik->setValue('periksa_ya',$unChecked);
		$templateklinik->setValue('periksa_kecendrungan',$checked);
		$templateklinik->setValue('periksa_tidak',$unChecked);
	}else if($kesehatan_mulut['periksa'] == '3'){
		$templateklinik->setValue('periksa_ya',$unChecked);
		$templateklinik->setValue('periksa_kecendrungan',$unChecked);
		$templateklinik->setValue('periksa_tidak',$checked);	
	}else{
		$templateklinik->setValue('periksa_ya',$unChecked);
		$templateklinik->setValue('periksa_kecendrungan',$unChecked);
		$templateklinik->setValue('periksa_tidak',$unChecked);
	}
	
	if($kesehatan_mulut['risiko'] == '1'){
		$templateklinik->setValue('risiko_rendah',$checked);
		$templateklinik->setValue('risiko_cenderung',$unChecked);
		$templateklinik->setValue('risiko_tinggi',$unChecked);
	}else if($kesehatan_mulut['risiko'] == '2'){
		$templateklinik->setValue('risiko_rendah',$unChecked);
		$templateklinik->setValue('risiko_cenderung',$checked);
		$templateklinik->setValue('risiko_tinggi',$unChecked);
	}else if($kesehatan_mulut['risiko'] == '3'){
		$templateklinik->setValue('risiko_rendah',$unChecked);
		$templateklinik->setValue('risiko_cenderung',$unChecked);
		$templateklinik->setValue('risiko_tinggi',$checked);	
	}else{
		$templateklinik->setValue('risiko_rendah',$unChecked);
		$templateklinik->setValue('risiko_cenderung',$unChecked);
		$templateklinik->setValue('risiko_tinggi',$unChecked);
	}
	
	for($i=1; $i <= 8; $i++){
		if($diagnosa['diag_' . $i] == '1'){
			$templateklinik->setValue('diagnosa_' . $i,$checked);
		}else{
			$templateklinik->setValue('diagnosa_' . $i,$unChecked);
		}
	}

	for($i=1; $i <= 7; $i++){
		if($implementasi['impl_' . $i] == '1'){
			$templateklinik->setValue('implementasi_' . $i,$checked);
		}else{
			$templateklinik->setValue('implementasi_' . $i,$unChecked);
		}
	}

	for($i=1; $i <= 5; $i++){
		if($evaluasi['eval_' . $i] == '1'){
			$templateklinik->setValue('evaluasi_' . $i,$checked);
		}else{
			$templateklinik->setValue('evaluasi_' . $i,$unChecked);
		}
	}	
	
	if(!file_exists($rmfile_path . '/pdf/1/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/pdf/1/' . $nomr . '/' . $idx, 0700, true);
	}

	if(!file_exists($rmfile_path . '/doc/1/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/doc/1/' . $nomr . '/' . $idx, 0700, true);
	}
	
	$nama_file = $nomr . '_' . $idx . '_30';	
	/*
	if($final == '1' and $ls_assesment != $tgl_skr){
		$qry_rev = 'SELECT COUNT(FILE_ID) + 1 AS REV FROM t_rm_dokumen_file
			WHERE RAWAT_ID = "' . $idx . '"
			AND JNS_PERAWATAN = "1"
			AND JENIS_DOKUMEN_ID = "30"';
		$get_rev = mysql_query($qry_rev) or die(mysql_error());
		$dat_rev = mysql_fetch_assoc($get_rev);
		$nama_file .= '_' . $dat_rev['REV'];	
	}
	*/
	$templateklinik->saveAs($rmfile_path . '/doc/1/' . $nomr . '/' . $idx . '/' . $nama_file . '.docx');
	
	mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE RAWAT_ID = "' . $idx . '"
				AND JNS_PERAWATAN = "1"
				AND JENIS_DOKUMEN_ID = "30"
				AND NAMA_FILE = "' . $nama_file . '.pdf"') or die(mysql_error());
	mysql_query('INSERT INTO t_rm_dokumen_file(JENIS_DOKUMEN_ID,NOMR,RAWAT_ID,JNS_PERAWATAN,NAMA_FILE,ST_SISTEM,TANGGAL) 		
				VALUES("30","' . $nomr . '","' . $idx . '","1","' . $nama_file . '.pdf","1",STR_TO_DATE("' . $tgl_daftar . '","%d/%m/%Y"))') or die(mysql_error());
	
	$source_file = $rmfile_path . '/doc/1/' . $nomr . '/' . $idx . '/' . $nama_file . '.docx';			
	$source_file = str_replace('/','\\',$source_file);
	$target_file = $rmfile_path . '/pdf/1/' . $nomr . '/' . $idx . '/' . $nama_file . '.pdf';
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