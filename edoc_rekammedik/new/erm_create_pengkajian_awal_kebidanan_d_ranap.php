<?php
function replace_newline($str){
	$ret = preg_replace('/\r|\n/','\n',trim($str));
	$ret = str_replace('\n','<br>',$ret);
	$ret = str_replace('<br><br>','<br>',$ret);
	return $ret;
}

function erm_pengkajian_awal_kebidanan_d_ranap($idx,$ls_assesment='',$tgl_skr='',$final=''){
	global $rmfile_path, $app_path;

	$checked = '<w:sym w:font="Wingdings" w:char="F0FE"/>';
    $unChecked = '<w:sym w:font="Wingdings" w:char="F0A8"/>';
	
	$templateklinik = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\pengkajian_awal_kebidanan_d_kandungan.docx');
	
	$qry_pasien = 'SELECT t_irna.IRNA_ID,t_irna.NOMR,t_irna.PEGAWAI_ID,m_pegawai.NAMA_PEGAWAI,t_irna.RUANG_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				DATE_FORMAT(t_irna.PASIEN_MASUK,"%d-%m-%Y %H:%i") AS PASIEN_MASUK,t_irna.JENIS_BAYAR_ID,m_pasien.NO_TELEPON,
				DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				CONCAT(m_ruang.NAMA_RUANG," KELAS ",m_ruang.KELAS_RAWAT) AS NAMA_RUANG
				FROM t_irna
				INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_irna.IRNA_ID = "' . $idx . '"';
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

	$irja_id = $dat_pasien['IRNA_ID'];
	$pegawai_id = $dat_pasien['PEGAWAI_ID'];
	//$asal_pasien_id = $dat_pasien['ASAL_PASIEN_ID'];
	//$ket_asal_pasien = $dat_pasien['KET_ASAL_PASIEN'];
	$pasien_masuk = $dat_pasien['PASIEN_MASUK'];

	$no_telepon = $dat_pasien['NO_TELEPON'];
	$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];
	$nama_unit = $dat_pasien['NAMA_RUANG'];
	$nama_dokter = $dat_pasien['NAMA_PEGAWAI'];

	$umur = getUmurDaftar($tgl_lahir,$tgl_daftar);
	
	$templateklinik->setValue('nomor_rm', formatNomr($nomr));
	$templateklinik->setValue('nama_pasien', htmlspecialchars($nama_pasien));
	$templateklinik->setValue('tgl_lahir', htmlspecialchars($tgl_lahir));
	$templateklinik->setValue('jenis_kelamin', htmlspecialchars($jns_kelamin));
	$templateklinik->setValue('unit', htmlspecialchars($nama_unit));
	$templateklinik->setValue('tgl_masuk', $pasien_masuk);
	$templateklinik->setValue('nama_dokter', htmlspecialchars($nama_dokter));
	
	$qry_pengkajian = 'SELECT IRNA_ID,CARA_MASUK,DS_KELUHAN_UTAMA,DS_RIWAYAT_MENSTUASI,DS_RIWAYAT_HAMIL_INI,
			DS_RIWAYAT_KEHAMILAN_TERDAHULU,DS_RIWAYAT_PENYAKIT_DIDERITA,DS_RIWAYAT_PENYAKIT_KELUARGA,
			DS_STATUS_PERKAWINAN,DS_RIWAYAT_SOSIAL_EKONOMI,DS_RIWAYAT_KB,DS_RIWAYAT_GINEKOLOGI,DS_POLA_MAKAN,
			DO_PEMERIKSAAN_UMUM,DO_PEMERIKSAAN_FISIK,DO_PEMERIKSAAN_KHUSUS,DO_PENAPISAN_NYERI,DO_PEMERIKSAAN_PENUNJANG,
			ANALISA_DATA,PENATALAKSANAAN,
			REGISTER,DATE_FORMAT(TGL_ASSESMENT,"%d-%m-%Y %H:%i") AS TGL_ASSESMENT,
			NAMA_PEGAWAI
			FROM t_irna_pengkajian_awal_kandungan
			INNER JOIN m_pegawai ON (t_irna_pengkajian_awal_kandungan.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
			WHERE IRNA_ID = "' . $idx . '"';
	$get_pengkajian = mysql_query($qry_pengkajian) or die(mysql_error());
	$dat_pengkajian = mysql_fetch_assoc($get_pengkajian);
	$idx = $dat_pengkajian['IRNA_ID'];
	$templateklinik->setValue('tgl_assesment', $dat_pengkajian['TGL_ASSESMENT']);
	$templateklinik->setValue('dicetak_oleh', '');
	$templateklinik->setValue('nama_perawat', htmlspecialchars($dat_pengkajian['NAMA_PEGAWAI']));
	
	$cara_masuk = $dat_pengkajian['CARA_MASUK'];
	$ds_keluhan_utama = $dat_pengkajian['DS_KELUHAN_UTAMA'];
	$ds_riwayat_menstruasi = str_replace('|','"',$dat_pengkajian['DS_RIWAYAT_MENSTUASI']);
	$ds_riwayat_menstruasi = preg_replace('/\r|\n/','\n',trim($ds_riwayat_menstruasi));
	$ds_riwayat_menstruasi = json_decode($ds_riwayat_menstruasi,true);
	
	$ds_hamil_ini = str_replace('|','"',$dat_pengkajian['DS_RIWAYAT_HAMIL_INI']);
	$ds_hamil_ini = preg_replace('/\r|\n/','\n',trim($ds_hamil_ini));
	$ds_hamil_ini = json_decode($ds_hamil_ini,true);
	
	$ds_riwayat_hamil_dhl = str_replace('|','"',$dat_pengkajian['DS_RIWAYAT_KEHAMILAN_TERDAHULU']);
	$ds_riwayat_hamil_dhl = preg_replace('/\r|\n/','\n',trim($ds_riwayat_hamil_dhl));
	$ds_riwayat_hamil_dhl = json_decode($ds_riwayat_hamil_dhl,true);
	
	$ds_penyakit = str_replace('|','"',$dat_pengkajian['DS_RIWAYAT_PENYAKIT_DIDERITA']);
	$ds_penyakit = preg_replace('/\r|\n/','\n',trim($ds_penyakit));
	$ds_penyakit = json_decode($ds_penyakit,true);
	$ds_penyakit_keluarga = $dat_pengkajian['DS_RIWAYAT_PENYAKIT_KELUARGA'];
	
	$ds_perkawinan = str_replace('|','"',$dat_pengkajian['DS_STATUS_PERKAWINAN']);
	$ds_perkawinan = preg_replace('/\r|\n/','\n',trim($ds_perkawinan));
	$ds_perkawinan = json_decode($ds_perkawinan,true);
	
	$ds_sosial = str_replace('|','"',$dat_pengkajian['DS_RIWAYAT_SOSIAL_EKONOMI']);
	$ds_sosial = preg_replace('/\r|\n/','\n',trim($ds_sosial));
	$ds_sosial = json_decode($ds_sosial,true);
	
	$ds_kb = str_replace('|','"',$dat_pengkajian['DS_RIWAYAT_KB']);
	$ds_kb = preg_replace('/\r|\n/','\n',trim($ds_kb));
	$ds_kb = json_decode($ds_kb,true);
	
	$ds_ginekologi = str_replace('|','"',$dat_pengkajian['DS_RIWAYAT_GINEKOLOGI']);
	$ds_ginekologi = preg_replace('/\r|\n/','\n',trim($ds_ginekologi));
	$ds_ginekologi = json_decode($ds_ginekologi,true);
	
	$ds_pola_makan = str_replace('|','"',$dat_pengkajian['DS_POLA_MAKAN']);
	$ds_pola_makan = preg_replace('/\r|\n/','\n',trim($ds_pola_makan));
	$ds_pola_makan = json_decode($ds_pola_makan,true);
	
	$do_pemeriksaan_umum = str_replace('|','"',$dat_pengkajian['DO_PEMERIKSAAN_UMUM']);
	$do_pemeriksaan_umum = preg_replace('/\r|\n/','\n',trim($do_pemeriksaan_umum));
	$do_pemeriksaan_umum = json_decode($do_pemeriksaan_umum,true);
	
	$do_pemeriksaan_fisik = str_replace('|','"',$dat_pengkajian['DO_PEMERIKSAAN_FISIK']);
	$do_pemeriksaan_fisik = preg_replace('/\r|\n/','\n',trim($do_pemeriksaan_fisik));
	$do_pemeriksaan_fisik = json_decode($do_pemeriksaan_fisik,true);
	
	$do_pemeriksaan_khusus = str_replace('|','"',$dat_pengkajian['DO_PEMERIKSAAN_KHUSUS']);
	$do_pemeriksaan_khusus = preg_replace('/\r|\n/','\n',trim($do_pemeriksaan_khusus));
	$do_pemeriksaan_khusus = json_decode($do_pemeriksaan_khusus,true);
	
	$do_penapisan_nyeri = str_replace('|','"',$dat_pengkajian['DO_PENAPISAN_NYERI']);
	$do_penapisan_nyeri = preg_replace('/\r|\n/','\n',trim($do_penapisan_nyeri));
	$do_penapisan_nyeri = json_decode($do_penapisan_nyeri,true);
	
	$do_penunjang = str_replace('|','"',$dat_pengkajian['DO_PEMERIKSAAN_PENUNJANG']);
	$do_penunjang = preg_replace('/\r|\n/','\n',trim($do_penunjang));
	$do_penunjang = json_decode($do_penunjang,true);
	$analisa_data = $dat_pengkajian['ANALISA_DATA'];
	$penatalaksanaan = $dat_pengkajian['PENATALAKSANAAN'];
	
	if($cara_masuk == '1'){
		$templateklinik->setValue('msk_irj',$checked);
		$templateklinik->setValue('msk_igd',$unChecked);
		$templateklinik->setValue('msk_klinik',$unChecked);
		$templateklinik->setValue('msk_bersalin',$unChecked);
		$templateklinik->setValue('msk_bidan',$unChecked);
	}else if($cara_masuk == '2'){
		$templateklinik->setValue('msk_irj',$unChecked);
		$templateklinik->setValue('msk_igd',$checked);
		$templateklinik->setValue('msk_klinik',$unChecked);
		$templateklinik->setValue('msk_bersalin',$unChecked);
		$templateklinik->setValue('msk_bidan',$unChecked);
	}else if($cara_masuk == '3'){
		$templateklinik->setValue('msk_irj',$unChecked);
		$templateklinik->setValue('msk_igd',$unChecked);
		$templateklinik->setValue('msk_klinik',$checked);
		$templateklinik->setValue('msk_bersalin',$unChecked);
		$templateklinik->setValue('msk_bidan',$unChecked);	
	}else if($cara_masuk == '4'){
		$templateklinik->setValue('msk_irj',$unChecked);
		$templateklinik->setValue('msk_igd',$unChecked);
		$templateklinik->setValue('msk_klinik',$unChecked);
		$templateklinik->setValue('msk_bersalin',$checked);
		$templateklinik->setValue('msk_bidan',$unChecked);	
	}else if($cara_masuk == '5'){
		$templateklinik->setValue('msk_irj',$unChecked);
		$templateklinik->setValue('msk_igd',$unChecked);
		$templateklinik->setValue('msk_klinik',$unChecked);
		$templateklinik->setValue('msk_bersalin',$unChecked);
		$templateklinik->setValue('msk_bidan',$checked);	
	}else{
		$templateklinik->setValue('msk_irj',$unChecked);
		$templateklinik->setValue('msk_igd',$unChecked);
		$templateklinik->setValue('msk_klinik',$unChecked);
		$templateklinik->setValue('msk_bersalin',$unChecked);
		$templateklinik->setValue('msk_bidan',$unChecked);
	}	
	
	$ds_keluhan_utama = replace_newline($ds_keluhan_utama);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($ds_keluhan_utama);
	$templateklinik->setValue('keluhan_utama',$toOpenXML);
	
	$menstruasi = replace_newline($ds_riwayat_menstruasi['riwayat']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($menstruasi);
	$templateklinik->setValue('riwayat_menstruasi',$toOpenXML);
	$templateklinik->setValue('usia_menarche',htmlspecialchars($ds_riwayat_menstruasi['usia_menarche']));
	$templateklinik->setValue('lama_haid',htmlspecialchars($ds_riwayat_menstruasi['lama_haid']));
	$templateklinik->setValue('jml_darah',htmlspecialchars($ds_riwayat_menstruasi['darah_haid']));
	$templateklinik->setValue('hpht',htmlspecialchars($ds_riwayat_menstruasi['hpht']));
	$templateklinik->setValue('tp',htmlspecialchars($ds_riwayat_menstruasi['tp']));
	
	if($ds_riwayat_menstruasi['dismenorhoe'] == '1'){
		$templateklinik->setValue('dismenorhoe',$checked);
	}else{
		$templateklinik->setValue('dismenorhoe',$unChecked);
	}		
	if($ds_riwayat_menstruasi['spoting'] == '1'){
		$templateklinik->setValue('spoting',$checked);
	}else{
		$templateklinik->setValue('spoting',$unChecked);
	}
	if($ds_riwayat_menstruasi['menorraghia'] == '1'){
		$templateklinik->setValue('menorraghia',$checked);
	}else{
		$templateklinik->setValue('menorraghia',$unChecked);
	}
	if($ds_riwayat_menstruasi['syndrome'] == '1'){
		$templateklinik->setValue('syndrome',$checked);
	}else{
		$templateklinik->setValue('syndrome',$unChecked);
	}
	if($ds_riwayat_menstruasi['metrorhagia'] == '1'){
		$templateklinik->setValue('metrorraghia',$checked);
	}else{
		$templateklinik->setValue('metrorraghia',$unChecked);
	}
	
	$hamil = replace_newline($ds_hamil_ini['riwayat']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($hamil);
	$templateklinik->setValue('riwayat_hamil',$toOpenXML);
	if($ds_hamil_ini['hm_mual'] == '1'){
		$templateklinik->setValue('hm_mual',$checked);
	}else{
		$templateklinik->setValue('hm_mual',$unChecked);
	}	
	if($ds_hamil_ini['hm_muntah'] == '1'){
		$templateklinik->setValue('hm_muntah',$checked);
	}else{
		$templateklinik->setValue('hm_muntah',$unChecked);
	}	
	if($ds_hamil_ini['hm_pendarahan'] == '1'){
		$templateklinik->setValue('hm_darah',$checked);
	}else{
		$templateklinik->setValue('hm_darah',$unChecked);
	}	
	if($ds_hamil_ini['hm_lainlain'] == '1'){
		$templateklinik->setValue('hm_lain',$checked);
	}else{
		$templateklinik->setValue('hm_lain',$unChecked);
	}	
	$templateklinik->setValue('hm_ket',htmlspecialchars($ds_hamil_ini['hm_ket_lainlain']));
	
	if($ds_hamil_ini['ht_pusing'] == '1'){
		$templateklinik->setValue('ht_pusing',$checked);
	}else{
		$templateklinik->setValue('ht_pusing',$unChecked);
	}
	if($ds_hamil_ini['ht_sakit_kepala'] == '1'){
		$templateklinik->setValue('ht_kepala',$checked);
	}else{
		$templateklinik->setValue('ht_kepala',$unChecked);
	}	
	if($ds_hamil_ini['ht_pendarahan'] == '1'){
		$templateklinik->setValue('ht_darah',$checked);
	}else{
		$templateklinik->setValue('ht_darah',$unChecked);
	}	
	if($ds_hamil_ini['ht_lainlain'] == '1'){
		$templateklinik->setValue('ht_lain',$checked);
	}else{
		$templateklinik->setValue('ht_lain',$unChecked);
	}
	$templateklinik->setValue('ht_ket',htmlspecialchars($ds_hamil_ini['ht_ket_lainlain']));
	$templateklinik->setValue('ger_janin_pertama',htmlspecialchars($ds_hamil_ini['gj_pertama']));
	$templateklinik->setValue('ger_janin_terakhir',htmlspecialchars($ds_hamil_ini['gj_terakhir']));
	$templateklinik->setValue('tanda_penyulit',htmlspecialchars($ds_hamil_ini['tanda_penyulit']));
	$templateklinik->setValue('obat_jamu',htmlspecialchars($ds_hamil_ini['obat_jamu']));
	$templateklinik->setValue('keluhan_bak',htmlspecialchars($ds_hamil_ini['keluhan_bak']));
	$templateklinik->setValue('keluhan_bab',htmlspecialchars($ds_hamil_ini['keluhan_bab']));
	$templateklinik->setValue('kekhawatiran_khusus',htmlspecialchars($ds_hamil_ini['kehawatiran']));
	
	$hamil_dl = replace_newline($ds_riwayat_hamil_dhl['riwayat']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($hamil_dl);
	$templateklinik->setValue('riwayat_hamil_terdahulu',$toOpenXML);
	$templateklinik->setValue('ds_rh_g',htmlspecialchars($ds_riwayat_hamil_dhl['ds_rh_g']));
	$templateklinik->setValue('ds_rh_p',htmlspecialchars($ds_riwayat_hamil_dhl['ds_rh_p']));
	$templateklinik->setValue('ds_rh_a',htmlspecialchars($ds_riwayat_hamil_dhl['ds_rh_a']));
	$templateklinik->setValue('ds_rh_hidup',htmlspecialchars($ds_riwayat_hamil_dhl['ds_rh_hidup']));
	
	$templateklinik->setValue('ds_waktu_partus_1',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][1]['ds_waktu_partus']));
	$templateklinik->setValue('ds_tempat_partus_1',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][1]['ds_tempat_partus']));
	$templateklinik->setValue('ds_umur_partus_1',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][1]['ds_umur_partus']));
	$templateklinik->setValue('ds_jenis_partus_1',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][1]['ds_jenis_partus']));
	$templateklinik->setValue('ds_penolong_partus_1',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][1]['ds_penolong_partus']));
	$templateklinik->setValue('ds_penyulit_partus_1',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][1]['ds_penyulit_partus']));
	$templateklinik->setValue('ds_sex_partus_1',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][1]['ds_sex_partus']));
	$templateklinik->setValue('ds_bb_partus_1',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][1]['ds_bb_partus']));
	$templateklinik->setValue('ds_keadaan_partus_1',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][1]['ds_keadaan_partus']));
	
	$templateklinik->setValue('ds_waktu_partus_2',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][2]['ds_waktu_partus']));
	$templateklinik->setValue('ds_tempat_partus_2',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][2]['ds_tempat_partus']));
	$templateklinik->setValue('ds_umur_partus_2',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][2]['ds_umur_partus']));
	$templateklinik->setValue('ds_jenis_partus_2',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][2]['ds_jenis_partus']));
	$templateklinik->setValue('ds_penolong_partus_2',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][2]['ds_penolong_partus']));
	$templateklinik->setValue('ds_penyulit_partus_2',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][2]['ds_penyulit_partus']));
	$templateklinik->setValue('ds_sex_partus_2',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][2]['ds_sex_partus']));
	$templateklinik->setValue('ds_bb_partus_2',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][2]['ds_bb_partus']));
	$templateklinik->setValue('ds_keadaan_partus_2',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][2]['ds_keadaan_partus']));
	
	$templateklinik->setValue('ds_waktu_partus_3',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][3]['ds_waktu_partus']));
	$templateklinik->setValue('ds_tempat_partus_3',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][3]['ds_tempat_partus']));
	$templateklinik->setValue('ds_umur_partus_3',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][3]['ds_umur_partus']));
	$templateklinik->setValue('ds_jenis_partus_3',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][3]['ds_jenis_partus']));
	$templateklinik->setValue('ds_penolong_partus_3',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][3]['ds_penolong_partus']));
	$templateklinik->setValue('ds_penyulit_partus_3',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][3]['ds_penyulit_partus']));
	$templateklinik->setValue('ds_sex_partus_3',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][3]['ds_sex_partus']));
	$templateklinik->setValue('ds_bb_partus_3',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][3]['ds_bb_partus']));
	$templateklinik->setValue('ds_keadaan_partus_3',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][3]['ds_keadaan_partus']));
	
	$templateklinik->setValue('ds_waktu_partus_4',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][4]['ds_waktu_partus']));
	$templateklinik->setValue('ds_tempat_partus_4',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][4]['ds_tempat_partus']));
	$templateklinik->setValue('ds_umur_partus_4',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][4]['ds_umur_partus']));
	$templateklinik->setValue('ds_jenis_partus_4',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][4]['ds_jenis_partus']));
	$templateklinik->setValue('ds_penolong_partus_4',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][4]['ds_penolong_partus']));
	$templateklinik->setValue('ds_penyulit_partus_4',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][4]['ds_penyulit_partus']));
	$templateklinik->setValue('ds_sex_partus_4',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][4]['ds_sex_partus']));
	$templateklinik->setValue('ds_bb_partus_4',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][4]['ds_bb_partus']));
	$templateklinik->setValue('ds_keadaan_partus_4',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][4]['ds_keadaan_partus']));
	
	$templateklinik->setValue('ds_waktu_partus_5',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][5]['ds_waktu_partus']));
	$templateklinik->setValue('ds_tempat_partus_5',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][5]['ds_tempat_partus']));
	$templateklinik->setValue('ds_umur_partus_5',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][5]['ds_umur_partus']));
	$templateklinik->setValue('ds_jenis_partus_5',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][5]['ds_jenis_partus']));
	$templateklinik->setValue('ds_penolong_partus_5',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][5]['ds_penolong_partus']));
	$templateklinik->setValue('ds_penyulit_partus_5',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][5]['ds_penyulit_partus']));
	$templateklinik->setValue('ds_sex_partus_5',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][5]['ds_sex_partus']));
	$templateklinik->setValue('ds_bb_partus_5',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][5]['ds_bb_partus']));
	$templateklinik->setValue('ds_keadaan_partus_5',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][5]['ds_keadaan_partus']));
	
	$templateklinik->setValue('ds_waktu_partus_6',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][6]['ds_waktu_partus']));
	$templateklinik->setValue('ds_tempat_partus_6',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][6]['ds_tempat_partus']));
	$templateklinik->setValue('ds_umur_partus_6',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][6]['ds_umur_partus']));
	$templateklinik->setValue('ds_jenis_partus_6',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][6]['ds_jenis_partus']));
	$templateklinik->setValue('ds_penolong_partus_6',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][6]['ds_penolong_partus']));
	$templateklinik->setValue('ds_penyulit_partus_6',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][6]['ds_penyulit_partus']));
	$templateklinik->setValue('ds_sex_partus_6',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][6]['ds_sex_partus']));
	$templateklinik->setValue('ds_bb_partus_6',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][6]['ds_bb_partus']));
	$templateklinik->setValue('ds_keadaan_partus_6',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][6]['ds_keadaan_partus']));
	
	$templateklinik->setValue('ds_waktu_partus_7',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][7]['ds_waktu_partus']));
	$templateklinik->setValue('ds_tempat_partus_7',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][7]['ds_tempat_partus']));
	$templateklinik->setValue('ds_umur_partus_7',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][7]['ds_umur_partus']));
	$templateklinik->setValue('ds_jenis_partus_7',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][7]['ds_jenis_partus']));
	$templateklinik->setValue('ds_penolong_partus_7',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][7]['ds_penolong_partus']));
	$templateklinik->setValue('ds_penyulit_partus_7',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][7]['ds_penyulit_partus']));
	$templateklinik->setValue('ds_sex_partus_7',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][7]['ds_sex_partus']));
	$templateklinik->setValue('ds_bb_partus_7',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][7]['ds_bb_partus']));
	$templateklinik->setValue('ds_keadaan_partus_7',htmlspecialchars($ds_riwayat_hamil_dhl['partus'][7]['ds_keadaan_partus']));
	
	$penyakit = replace_newline($ds_penyakit['riwayat']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($penyakit);
	$templateklinik->setValue('riwayat_penyakit_operasi',$toOpenXML);
	$templateklinik->setValue('pnh_dirawat',htmlspecialchars($ds_penyakit['pernah_dirawat']));
	$templateklinik->setValue('kpn_dirawat',htmlspecialchars($ds_penyakit['kapan_dirawat']));
	$templateklinik->setValue('dmn_dirawat',htmlspecialchars($ds_penyakit['dimana_dirawat']));
	$templateklinik->setValue('pnh_operasi',htmlspecialchars($ds_penyakit['pernah_operasi']));
	$templateklinik->setValue('kpn_operasi',htmlspecialchars($ds_penyakit['kapan_operasi']));
	$templateklinik->setValue('dmn_operasi',htmlspecialchars($ds_penyakit['dimana_operasi']));
	
	$ds_penyakit_keluarga = replace_newline($ds_penyakit_keluarga);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($ds_penyakit_keluarga);
	$templateklinik->setValue('penyakit_keluarga',$toOpenXML);
	
	if($ds_perkawinan['status_kawin'] == '1'){
		$templateklinik->setValue('kwn_ya',$checked);
		$templateklinik->setValue('kwn_tidak',$unChecked);
	}else if($ds_perkawinan['status_kawin'] == '2'){
		$templateklinik->setValue('kwn_ya',$unChecked);
		$templateklinik->setValue('kwn_tidak',$checked);	
	}else{
		$templateklinik->setValue('kwn_ya',$unChecked);
		$templateklinik->setValue('kwn_tidak',$unChecked);
	}	
	$templateklinik->setValue('jml_kawin',htmlspecialchars($ds_perkawinan['kali_kawin']));
	$templateklinik->setValue('usia_kawin',htmlspecialchars($ds_perkawinan['usia_kawin']));
	
	$templateklinik->setValue('respon_ibu',htmlspecialchars($ds_sosial['respon_ibu']));
	$templateklinik->setValue('pengambilan_keputusan',htmlspecialchars($ds_sosial['keputusan']));
	$templateklinik->setValue('beban_kerja',htmlspecialchars($ds_sosial['beban_kerja']));
	$templateklinik->setValue('tempat_persalinan',htmlspecialchars($ds_sosial['tempat_persalinan']));
	$templateklinik->setValue('penghasilan_keluarga',htmlspecialchars($ds_sosial['penghasilan']));
	
	$templateklinik->setValue('metode_kb',htmlspecialchars($ds_kb['metode_kb']));
	$templateklinik->setValue('lama_kb',htmlspecialchars($ds_kb['lama_kb']));
	$templateklinik->setValue('komplikasi_kb',htmlspecialchars($ds_kb['komplikasi_kb']));
	
	if($ds_ginekologi['infertilitas'] == '1'){
		$templateklinik->setValue('infertilitas',$checked);	
	}else{
		$templateklinik->setValue('infertilitas',$unChecked);
	}	
	if($ds_ginekologi['infeksi_virus'] == '1'){
		$templateklinik->setValue('infeksi_virus',$checked);	
	}else{
		$templateklinik->setValue('infeksi_virus',$unChecked);
	}	
	if($ds_ginekologi['pms'] == '1'){
		$templateklinik->setValue('pms',$checked);	
	}else{
		$templateklinik->setValue('pms',$unChecked);
	}	
	if($ds_ginekologi['endometriosis'] == '1'){
		$templateklinik->setValue('endometriosis',$checked);	
	}else{
		$templateklinik->setValue('endometriosis',$unChecked);
	}	
	if($ds_ginekologi['polip'] == '1'){
		$templateklinik->setValue('polip',$checked);	
	}else{
		$templateklinik->setValue('polip',$unChecked);
	}	
	if($ds_ginekologi['kanker'] == '1'){
		$templateklinik->setValue('kanker',$checked);	
	}else{
		$templateklinik->setValue('kanker',$unChecked);
	}	
	if($ds_ginekologi['operasi_kandungan'] == '1'){
		$templateklinik->setValue('operasi_kandungan',$checked);	
	}else{
		$templateklinik->setValue('operasi_kandungan',$unChecked);
	}	
	if($ds_ginekologi['perkosaan'] == '1'){
		$templateklinik->setValue('perkosaan',$checked);	
	}else{
		$templateklinik->setValue('perkosaan',$unChecked);
	}	
	
	$templateklinik->setValue('pola_makan',htmlspecialchars($ds_pola_makan['pola_makan']));
	$templateklinik->setValue('pola_minum',htmlspecialchars($ds_pola_makan['pola_minum']));
	$templateklinik->setValue('pola_bak',htmlspecialchars($ds_pola_makan['pola_bak']));
	$templateklinik->setValue('bak_warna',htmlspecialchars($ds_pola_makan['warna_bak']));
	$templateklinik->setValue('bak_th',htmlspecialchars($ds_pola_makan['jam_bak']));
	$templateklinik->setValue('pola_bab',htmlspecialchars($ds_pola_makan['pola_bab']));
	$templateklinik->setValue('bab_karakteristik',htmlspecialchars($ds_pola_makan['warna_bab']));
	$templateklinik->setValue('bab_th',htmlspecialchars($ds_pola_makan['jam_bab']));
	$templateklinik->setValue('pola_ist',htmlspecialchars($ds_pola_makan['pola_istirahat']));
	$templateklinik->setValue('tidur_terakhir',htmlspecialchars($ds_pola_makan['jam_tidur']));
	$templateklinik->setValue('pola_psikososial',htmlspecialchars($ds_pola_makan['terima_kehamilan']));
	
	if($ds_pola_makan['alkohol'] == '1'){
		$templateklinik->setValue('mn_alkohol',$checked);	
	}else{
		$templateklinik->setValue('mn_alkohol',$unChecked);
	}	
	if($ds_pola_makan['jamu'] == '1'){
		$templateklinik->setValue('mn_jamu',$checked);	
	}else{
		$templateklinik->setValue('mn_jamu',$unChecked);
	}
	if($ds_pola_makan['kopi'] == '1'){
		$templateklinik->setValue('mn_kopi',$checked);	
	}else{
		$templateklinik->setValue('mn_kopi',$unChecked);
	}
	
	if($ds_pola_makan['dk_suami'] == '1'){
		$templateklinik->setValue('dk_suami',$checked);	
	}else{
		$templateklinik->setValue('dk_suami',$unChecked);
	}
	if($ds_pola_makan['dk_ortu'] == '1'){
		$templateklinik->setValue('dk_ortu',$checked);	
	}else{
		$templateklinik->setValue('dk_ortu',$unChecked);
	}
	if($ds_pola_makan['dk_mertua'] == '1'){
		$templateklinik->setValue('dk_mertua',$checked);	
	}else{
		$templateklinik->setValue('dk_mertua',$unChecked);
	}
	if($ds_pola_makan['dk_kellain'] == '1'){
		$templateklinik->setValue('dk_lain',$checked);	
	}else{
		$templateklinik->setValue('dk_lain',$unChecked);
	}
	
	$templateklinik->setValue('keadaan_umum',htmlspecialchars($do_pemeriksaan_umum['keadaan_umum']));
	$templateklinik->setValue('kesadaran',htmlspecialchars($do_pemeriksaan_umum['kesadaran']));
	$templateklinik->setValue('tekanan_darah',htmlspecialchars($do_pemeriksaan_umum['pem_td']));
	$templateklinik->setValue('frek_nadi',htmlspecialchars($do_pemeriksaan_umum['pem_nadi']));
	$templateklinik->setValue('suhu_tubuh',htmlspecialchars($do_pemeriksaan_umum['pem_suhu']));
	$templateklinik->setValue('frek_nafas',htmlspecialchars($do_pemeriksaan_umum['pem_napas']));
	$templateklinik->setValue('bb_hamil',htmlspecialchars($do_pemeriksaan_umum['pem_bb_sb']));
	$templateklinik->setValue('bb_skr',htmlspecialchars($do_pemeriksaan_umum['pem_bb_sk']));
	$templateklinik->setValue('tb',htmlspecialchars($do_pemeriksaan_umum['pem_tb']));
	$templateklinik->setValue('lila',htmlspecialchars($do_pemeriksaan_umum['pem_lila']));
	
	$templateklinik->setValue('mata_konjungtiva',htmlspecialchars($do_pemeriksaan_fisik['mata_konjuntiva']));
	$templateklinik->setValue('mata_sklera',htmlspecialchars($do_pemeriksaan_fisik['mata_sklera']));
	$templateklinik->setValue('rahang_gigi',htmlspecialchars($do_pemeriksaan_fisik['rahang']));
	$templateklinik->setValue('leher',htmlspecialchars($do_pemeriksaan_fisik['leher']));
	$templateklinik->setValue('pinggang',htmlspecialchars($do_pemeriksaan_fisik['pinggang']));
	if($do_pemeriksaan_fisik['mata_kabur'] == '1'){
		$templateklinik->setValue('mata_kabur',$checked);	
	}else{
		$templateklinik->setValue('mata_kabur',$unChecked);
	}
	if($do_pemeriksaan_fisik['mata_dua'] == '1'){
		$templateklinik->setValue('mata_dua',$checked);	
	}else{
		$templateklinik->setValue('mata_dua',$unChecked);
	}
	if($do_pemeriksaan_fisik['dada_mamae'] == '1'){
		$templateklinik->setValue('dada_mammae',$checked);	
	}else{
		$templateklinik->setValue('dada_mammae',$unChecked);
	}
	if($do_pemeriksaan_fisik['dada_serola'] == '1'){
		$templateklinik->setValue('dada_aerola',$checked);	
	}else{
		$templateklinik->setValue('dada_aerola',$unChecked);
	}
	if($do_pemeriksaan_fisik['dada_tumor'] == '1'){
		$templateklinik->setValue('dada_tumor',$checked);	
	}else{
		$templateklinik->setValue('dada_tumor',$unChecked);
	}
	if($do_pemeriksaan_fisik['dada_kolostrum'] == '1'){
		$templateklinik->setValue('dada_kolostrum',$checked);	
	}else{
		$templateklinik->setValue('dada_kolostrum',$unChecked);
	}
	if($do_pemeriksaan_fisik['dada_puting'] == '1'){
		$templateklinik->setValue('dada_puting',$checked);	
	}else{
		$templateklinik->setValue('dada_puting',$unChecked);
	}
	if($do_pemeriksaan_fisik['ekt_tungkai'] == '1'){
		$templateklinik->setValue('tungkai_simitris',$checked);	
	}else{
		$templateklinik->setValue('tungkai_simitris',$unChecked);
	}
	if($do_pemeriksaan_fisik['ekt_odema'] == '1'){
		$templateklinik->setValue('eks_odema',$checked);	
	}else{
		$templateklinik->setValue('eks_odema',$unChecked);
	}
	if($do_pemeriksaan_fisik['ekt_refleks'] == '1'){
		$templateklinik->setValue('eks_repleks',$checked);	
	}else{
		$templateklinik->setValue('eks_repleks',$unChecked);
	}
	if($do_pemeriksaan_fisik['ekt_varises'] == '1'){
		$templateklinik->setValue('ekt_varises',$checked);	
	}else{
		$templateklinik->setValue('ekt_varises',$unChecked);
	}
	if($do_pemeriksaan_fisik['kar_dyspneu'] == '1'){
		$templateklinik->setValue('kar_dyspneu',$checked);	
	}else{
		$templateklinik->setValue('kar_dyspneu',$unChecked);
	}
	if($do_pemeriksaan_fisik['kar_thacypneu'] == '1'){
		$templateklinik->setValue('kar_thacypneu',$checked);	
	}else{
		$templateklinik->setValue('kar_thacypneu',$unChecked);
	}
	if($do_pemeriksaan_fisik['kar_wheezing'] == '1'){
		$templateklinik->setValue('kar_wheezing',$checked);	
	}else{
		$templateklinik->setValue('kar_wheezing',$unChecked);
	}
	if($do_pemeriksaan_fisik['kar_batuk'] == '1'){
		$templateklinik->setValue('kar_batuk',$checked);	
	}else{
		$templateklinik->setValue('kar_batuk',$unChecked);
	}
	if($do_pemeriksaan_fisik['kar_sputum'] == '1'){
		$templateklinik->setValue('kar_sputum',$checked);	
	}else{
		$templateklinik->setValue('kar_sputum',$unChecked);
	}
	if($do_pemeriksaan_fisik['kar_batuk_darah'] == '1'){
		$templateklinik->setValue('kar_batuk_darah',$checked);	
	}else{
		$templateklinik->setValue('kar_batuk_darah',$unChecked);
	}
	if($do_pemeriksaan_fisik['kar_nyeri'] == '1'){
		$templateklinik->setValue('kar_nyeri_dada',$checked);	
	}else{
		$templateklinik->setValue('kar_nyeri_dada',$unChecked);
	}
	if($do_pemeriksaan_fisik['kar_keringat'] == '1'){
		$templateklinik->setValue('kar_keringat',$checked);	
	}else{
		$templateklinik->setValue('kar_keringat',$unChecked);
	}
	
	if($do_pemeriksaan_khusus['inf_membesar'] == '1'){
		$templateklinik->setValue('ins_membesar',$checked);	
	}else{
		$templateklinik->setValue('ins_membesar',$unChecked);
	}
	if($do_pemeriksaan_khusus['inf_melebar'] == '1'){
		$templateklinik->setValue('ins_melebar',$checked);	
	}else{
		$templateklinik->setValue('ins_melebar',$unChecked);
	}
	if($do_pemeriksaan_khusus['inf_vena'] == '1'){
		$templateklinik->setValue('ins_vena',$checked);	
	}else{
		$templateklinik->setValue('ins_vena',$unChecked);
	}
	if($do_pemeriksaan_khusus['inf_linea'] == '1'){
		$templateklinik->setValue('ins_linea',$checked);	
	}else{
		$templateklinik->setValue('ins_linea',$unChecked);
	}
	if($do_pemeriksaan_khusus['inf_nigra'] == '1'){
		$templateklinik->setValue('ins_nigra',$checked);	
	}else{
		$templateklinik->setValue('ins_nigra',$unChecked);
	}
	if($do_pemeriksaan_khusus['inf_livide'] == '1'){
		$templateklinik->setValue('ins_striae',$checked);	
	}else{
		$templateklinik->setValue('ins_striae',$unChecked);
	}
	if($do_pemeriksaan_khusus['inf_albican'] == '1'){
		$templateklinik->setValue('ins_albican',$checked);	
	}else{
		$templateklinik->setValue('ins_albican',$unChecked);
	}
	if($do_pemeriksaan_khusus['inf_operasi'] == '1'){
		$templateklinik->setValue('ins_luka',$checked);	
	}else{
		$templateklinik->setValue('ins_luka',$unChecked);
	}
	if($do_pemeriksaan_khusus['inf_lain'] == '1'){
		$templateklinik->setValue('ins_lain',$checked);	
	}else{
		$templateklinik->setValue('ins_lain',$unChecked);
	}
	
	$templateklinik->setValue('pal_tfu',htmlspecialchars($do_pemeriksaan_khusus['tfu']));
	$templateklinik->setValue('pal_presentasi',htmlspecialchars($do_pemeriksaan_khusus['persentasi']));
	$templateklinik->setValue('tbj',htmlspecialchars($do_pemeriksaan_khusus['tbj']));
	$templateklinik->setValue('aus_djj',htmlspecialchars($do_pemeriksaan_khusus['djj']));
	$templateklinik->setValue('kontraksi',htmlspecialchars($do_pemeriksaan_khusus['kontraksi']));
	$templateklinik->setValue('kontraksi_detik',htmlspecialchars($do_pemeriksaan_khusus['kontraksi_detik']));
	
	if($do_pemeriksaan_khusus['letak_punggung'] == '1'){
		$templateklinik->setValue('pal_puka',$checked);
		$templateklinik->setValue('pal_puki',$unChecked);	
	}else if($do_pemeriksaan_khusus['letak_punggung'] == '2'){
		$templateklinik->setValue('pal_puka',$unChecked);
		$templateklinik->setValue('pal_puki',$checked);		
	}else{
		$templateklinik->setValue('pal_puka',$unChecked);
		$templateklinik->setValue('pal_puki',$unChecked);
	}
	
	if($do_pemeriksaan_khusus['djj_teratur'] == '1'){
		$templateklinik->setValue('aus_teratur',$checked);
		$templateklinik->setValue('aus_td_teratur',$unChecked);	
	}else if($do_pemeriksaan_khusus['djj_teratur'] == '2'){
		$templateklinik->setValue('aus_teratur',$unChecked);
		$templateklinik->setValue('aus_td_teratur',$checked);		
	}else{
		$templateklinik->setValue('aus_teratur',$unChecked);
		$templateklinik->setValue('aus_td_teratur',$unChecked);
	}
	
	if($do_pemeriksaan_khusus['kontraksi_teratur'] == '1'){
		$templateklinik->setValue('kon_teratur',$checked);
		$templateklinik->setValue('kon_td_teratur',$unChecked);	
	}else if($do_pemeriksaan_khusus['kontraksi_teratur'] == '2'){
		$templateklinik->setValue('kon_teratur',$unChecked);
		$templateklinik->setValue('kon_td_teratur',$checked);		
	}else{
		$templateklinik->setValue('kon_teratur',$unChecked);
		$templateklinik->setValue('kon_td_teratur',$unChecked);
	}
	
	$templateklinik->setValue('ins_per_vaginam',htmlspecialchars($do_pemeriksaan_khusus['vaginam']));
	$templateklinik->setValue('ins_vagina',htmlspecialchars($do_pemeriksaan_khusus['inspekulo']));
	$templateklinik->setValue('vaginal_toucher',htmlspecialchars($do_pemeriksaan_khusus['toucher']));
	$templateklinik->setValue('kesan_panggul',htmlspecialchars($do_pemeriksaan_khusus['kesan_panggul']));
	$templateklinik->setValue('tfu',htmlspecialchars($do_pemeriksaan_khusus['tfu_nifas']));
	$templateklinik->setValue('kontraksi_uterus',htmlspecialchars($do_pemeriksaan_khusus['kon_uterus']));
	$templateklinik->setValue('lochea',htmlspecialchars($do_pemeriksaan_khusus['lochea']));
	$templateklinik->setValue('luka_jalan_lahir',htmlspecialchars($do_pemeriksaan_khusus['jalan_lahir']));
	
	$templateklinik->setValue('skor_nyeri',htmlspecialchars($do_penapisan_nyeri['skor_nyeri']));
	if($do_penapisan_nyeri['nyeri_obat'] == '1'){
		$templateklinik->setValue('ny_obat',$checked);	
	}else{
		$templateklinik->setValue('ny_obat',$unChecked);
	}
	if($do_penapisan_nyeri['nyeri_istirahat'] == '1'){
		$templateklinik->setValue('ny_ist',$checked);	
	}else{
		$templateklinik->setValue('ny_ist',$unChecked);
	}
	if($do_penapisan_nyeri['nyeri_tidur'] == '1'){
		$templateklinik->setValue('ny_posisi',$checked);	
	}else{
		$templateklinik->setValue('ny_posisi',$unChecked);
	}
	
	$templateklinik->setValue('darah_hb',htmlspecialchars($do_penunjang['penunjang_darah']));
	$templateklinik->setValue('hbsag',htmlspecialchars($do_penunjang['penunjang_hbsag']));
	$templateklinik->setValue('protein_urine',htmlspecialchars($do_penunjang['penunjang_protein']));
	$templateklinik->setValue('usg',htmlspecialchars($do_penunjang['penunjang_usg']));
	
	if($do_penunjang['penunjang_janin'] == '1'){
		$templateklinik->setValue('jn_reaktif',$checked);	
		$templateklinik->setValue('jn_tidak_reaktif',$unChecked);	
	}else if($do_penunjang['penunjang_janin'] == '2'){
		$templateklinik->setValue('jn_reaktif',$unChecked);	
		$templateklinik->setValue('jn_tidak_reaktif',$checked);	
	}else{
		$templateklinik->setValue('jn_reaktif',$unChecked);	
		$templateklinik->setValue('jn_tidak_reaktif',$unChecked);	
	}	
	
	$analisa_data = replace_newline($analisa_data);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($analisa_data);
	$templateklinik->setValue('analisa_data',$toOpenXML);
	
	$penatalaksanaan = replace_newline($penatalaksanaan);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($penatalaksanaan);
	$templateklinik->setValue('penatalaksanaan',$toOpenXML);
	
	if(!file_exists($rmfile_path . '/pdf/2/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/pdf/2/' . $nomr . '/' . $idx, 0700, true);
	}

	if(!file_exists($rmfile_path . '/doc/2/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/doc/2/' . $nomr . '/' . $idx, 0700, true);
	}
	
	$nama_file = $nomr . '_' . $idx . '_25';	
	/*
	if($final == '1' and $ls_assesment != $tgl_skr){
		$qry_rev = 'SELECT COUNT(FILE_ID) + 1 AS REV FROM t_rm_dokumen_file
			WHERE RAWAT_ID = "' . $idx . '"
			AND JNS_PERAWATAN = "1"
			AND JENIS_DOKUMEN_ID = "25"';
		$get_rev = mysql_query($qry_rev) or die(mysql_error());
		$dat_rev = mysql_fetch_assoc($get_rev);
		$nama_file .= '_' . $dat_rev['REV'];	
	}
	*/
	$templateklinik->saveAs($rmfile_path . '/doc/2/' . $nomr . '/' . $idx . '/' . $nama_file . '.docx');
	
	mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE RAWAT_ID = "' . $idx . '"
				AND JNS_PERAWATAN = "2"
				AND JENIS_DOKUMEN_ID = "25"
				AND NAMA_FILE = "' . $nama_file . '.pdf"') or die(mysql_error());
	mysql_query('INSERT INTO t_rm_dokumen_file(JENIS_DOKUMEN_ID,NOMR,RAWAT_ID,JNS_PERAWATAN,NAMA_FILE,ST_SISTEM,TANGGAL) 		
				VALUES("25","' . $nomr . '","' . $idx . '","2","' . $nama_file . '.pdf","1",STR_TO_DATE("' . $tgl_daftar . '","%d/%m/%Y"))') or die(mysql_error());
	
	$source_file = $rmfile_path . '/doc/2/' . $nomr . '/' . $idx . '/' . $nama_file . '.docx';			
	$source_file = str_replace('/','\\',$source_file);
	$target_file = $rmfile_path . '/pdf/2/' . $nomr . '/' . $idx . '/' . $nama_file . '.pdf';
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