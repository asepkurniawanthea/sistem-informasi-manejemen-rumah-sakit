<?php
function replace_newline($str){
	$ret = preg_replace('/\r|\n/','\n',trim($str));
	$ret = str_replace('\n','<br>',$ret);
	$ret = str_replace('<br><br>','<br>',$ret);
	return $ret;
}

function erm_triase_pasien_gawat_darurat($idx){
	global $rmfile_path, $app_path;

	$checked = '<w:sym w:font="Wingdings" w:char="F0FE"/>';
    $unChecked = '<w:sym w:font="Wingdings" w:char="F0A8"/>';
	
	$templateklinik = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\triase_pasien_gawat_darurat.docx');
	
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
	$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
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
	
	$qry_triase = 'SELECT TRIASE_ID,RIWAYAT_KUNJUNGAN,SUBYEKTIF,OBYEKTIF,AIRWAY,BREATHING,
			CIRCULATION,ASSESMENT,TINDAK_LANJUT,t_igd_triase.PEGAWAI_ID,REGISTER,
			DATE_FORMAT(WAKTU_KUNJUNGAN,"%d-%m-%Y") AS TANGGAL_KUNJUNGAN,
			DATE_FORMAT(WAKTU_KUNJUNGAN,"%H:%i") AS JAM_KUNJUNGAN,
			DATE_FORMAT(TGL_ASSESMENT,"%d-%m-%Y %H:%i") AS TGL_ASSESMENT,
			m_pegawai.NAMA_PEGAWAI
			FROM t_igd_triase
			LEFT JOIN m_pegawai ON (t_igd_triase.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
			WHERE IRJA_ID = "' . $idx . '"';	
	$get_triase = mysql_query($qry_triase) or die(mysql_error());
	$dat_triase = mysql_fetch_assoc($get_triase);

	$idx_triase = $dat_triase['TRIASE_ID']; 
	$tanggal_kunjungan = $dat_triase['TANGGAL_KUNJUNGAN']; 
	$jam_kunjungan = $dat_triase['JAM_KUNJUNGAN']; 
	
	$riwayat_kunjungan = str_replace('|','"',$dat_triase['RIWAYAT_KUNJUNGAN']);
	$riwayat_kunjungan = preg_replace('/\r|\n/','\n',trim($riwayat_kunjungan));
	$riwayat_kunjungan = json_decode($riwayat_kunjungan,true);

	$subyektif = str_replace('|','"',$dat_triase['SUBYEKTIF']);
	$subyektif = preg_replace('/\r|\n/','\n',trim($subyektif));
	$subyektif = json_decode($subyektif,true);

	$obyektif = str_replace('|','"',$dat_triase['OBYEKTIF']);
	$obyektif = preg_replace('/\r|\n/','\n',trim($obyektif));
	$obyektif = json_decode($obyektif,true);

	$airway = str_replace('|','"',$dat_triase['AIRWAY']);
	$airway = preg_replace('/\r|\n/','\n',trim($airway));
	$airway = json_decode($airway,true);

	$breathing = str_replace('|','"',$dat_triase['BREATHING']);
	$breathing = preg_replace('/\r|\n/','\n',trim($breathing));
	$breathing = json_decode($breathing,true);

	$circulation = str_replace('|','"',$dat_triase['CIRCULATION']);
	$circulation = preg_replace('/\r|\n/','\n',trim($circulation));
	$circulation = json_decode($circulation,true);

	$asesmen = $dat_triase['ASSESMENT'];
	$tindak_lanjut = $dat_triase['TINDAK_LANJUT'];
	$tgl_triase = $dat_triase['TGL_ASSESMENT'];
	$nama_perawat = $dat_triase['NAMA_PEGAWAI'];
	
	$templateklinik->setValue('tgl_triase', $tgl_triase);
	$templateklinik->setValue('nama_perawat', htmlspecialchars($nama_perawat));
	
	$templateklinik->setValue('tanggal_kunjungan', $tanggal_kunjungan);
	$templateklinik->setValue('jam_kunjungan', $jam_kunjungan);
	
	if($riwayat_kunjungan['rujukan'] == '1'){
		$templateklinik->setValue('dtg_sendiri', $checked);
		$templateklinik->setValue('rjkn_dari', $unChecked);
	}else if($riwayat_kunjungan['rujukan'] == '2'){
		$templateklinik->setValue('dtg_sendiri', $unChecked);
		$templateklinik->setValue('rjkn_dari', $checked);
	}else{
		$templateklinik->setValue('dtg_sendiri', $unChecked);
		$templateklinik->setValue('rjkn_dari', $unChecked);
	}

	if($riwayat_kunjungan['rujukan_dari'] == '1'){
		$templateklinik->setValue('rj_puskesmas', $checked);
		$templateklinik->setValue('rj_perorangan', $unChecked);
		$templateklinik->setValue('rj_rb', $unChecked);
		$templateklinik->setValue('rs_lain', $unChecked);
	}else if($riwayat_kunjungan['rujukan_dari'] == '2'){
		$templateklinik->setValue('rj_puskesmas', $unChecked);
		$templateklinik->setValue('rj_perorangan', $checked);
		$templateklinik->setValue('rj_rb', $unChecked);
		$templateklinik->setValue('rs_lain', $unChecked);
	}else if($riwayat_kunjungan['rujukan_dari'] == '3'){
		$templateklinik->setValue('rj_puskesmas', $unChecked);
		$templateklinik->setValue('rj_perorangan', $unChecked);
		$templateklinik->setValue('rj_rb', $checked);
		$templateklinik->setValue('rs_lain', $unChecked);
	}else if($riwayat_kunjungan['rujukan_dari'] == '4'){
		$templateklinik->setValue('rj_puskesmas', $unChecked);
		$templateklinik->setValue('rj_perorangan', $unChecked);
		$templateklinik->setValue('rj_rb', $unChecked);
		$templateklinik->setValue('rs_lain', $checked);		
	}else{
		$templateklinik->setValue('rj_puskesmas', $unChecked);
		$templateklinik->setValue('rj_perorangan', $unChecked);
		$templateklinik->setValue('rj_rb', $unChecked);
		$templateklinik->setValue('rs_lain', $unChecked);	
	}	
	
	$templateklinik->setValue('diantar_oleh', htmlspecialchars($riwayat_kunjungan['diantar_oleh']));
	$templateklinik->setValue('alat_transportasi', htmlspecialchars($riwayat_kunjungan['transportasi']));
	$templateklinik->setValue('rj_ket', htmlspecialchars($riwayat_kunjungan['rujukan_ket']));
	
	if($riwayat_kunjungan['dikirim_polisi'] == '1'){
		$templateklinik->setValue('krm_polisi', $checked);
	}else{
		$templateklinik->setValue('krm_polisi', $unChecked);
	}

	if($riwayat_kunjungan['visum'] == '1'){
		$templateklinik->setValue('dg_visum', $checked);
		$templateklinik->setValue('tanpa_visum', $unChecked);
	}else if($riwayat_kunjungan['visum'] == '2'){	
		$templateklinik->setValue('dg_visum', $unChecked);
		$templateklinik->setValue('tanpa_visum', $checked);
	}else{
		$templateklinik->setValue('dg_visum', $unChecked);
		$templateklinik->setValue('tanpa_visum', $unChecked);
	}	
	
	$templateklinik->setValue('polisi', htmlspecialchars($riwayat_kunjungan['dikirim_polisi_ket']));
	
	if($riwayat_kunjungan['kasus_trauma'] == '1'){
		$templateklinik->setValue('ks_trauma', $checked);
		$templateklinik->setValue('ks_nontrauma', $unChecked);
	}else if($riwayat_kunjungan['kasus_trauma'] == '2'){	
		$templateklinik->setValue('ks_trauma', $unChecked);
		$templateklinik->setValue('ks_nontrauma', $checked);
	}else{
		$templateklinik->setValue('ks_trauma', $unChecked);
		$templateklinik->setValue('ks_nontrauma', $unChecked);
	}
	
	if($riwayat_kunjungan['trauma_kll'] == '1'){
		$templateklinik->setValue('tr_kll', $checked);
	}else{
		$templateklinik->setValue('tr_kll', $unChecked);
	}		
	
	if($riwayat_kunjungan['trauma_kdrt'] == '1'){
		$templateklinik->setValue('tr_kdrt', $checked);
	}else{
		$templateklinik->setValue('tr_kdrt', $unChecked);
	}	
	
	if($riwayat_kunjungan['trauma_kec'] == '1'){
		$templateklinik->setValue('tr_kec', $checked);
	}else{
		$templateklinik->setValue('tr_kec', $unChecked);
	}	
	
	if($riwayat_kunjungan['trauma_ca'] == '1'){
		$templateklinik->setValue('tr_chi', $checked);
	}else{
		$templateklinik->setValue('tr_chi', $unChecked);
	}	
	
	$keluhan = replace_newline($subyektif['keluhan']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($keluhan);
	$templateklinik->setValue('keluhan', $toOpenXML);
	
	if($subyektif['riwayat_alergi'] == '1'){
		$templateklinik->setValue('alergi_tdk', $checked);
		$templateklinik->setValue('alergi_ada', $unChecked);
	}else if($subyektif['riwayat_alergi'] == '2'){	
		$templateklinik->setValue('alergi_tdk', $unChecked);
		$templateklinik->setValue('alergi_ada', $checked);
	}else{
		$templateklinik->setValue('alergi_tdk', $unChecked);
		$templateklinik->setValue('alergi_ada', $unChecked);
	}
	
	$alergi = replace_newline($subyektif['alergi_ket']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($alergi);
	$templateklinik->setValue('alergi_ket', $toOpenXML);
	
	if($subyektif['keadaan_umum'] == '1'){
		$templateklinik->setValue('ku_baik', $checked);
		$templateklinik->setValue('ku_sedang', $unChecked);
		$templateklinik->setValue('ku_buruk', $unChecked);
	}else if($subyektif['keadaan_umum'] == '2'){	
		$templateklinik->setValue('ku_baik', $unChecked);
		$templateklinik->setValue('ku_sedang', $checked);
		$templateklinik->setValue('ku_buruk', $unChecked);
	}else if($subyektif['keadaan_umum'] == '3'){	
		$templateklinik->setValue('ku_baik', $unChecked);
		$templateklinik->setValue('ku_sedang', $unChecked);
		$templateklinik->setValue('ku_buruk', $checked);	
	}else{
		$templateklinik->setValue('ku_baik', $unChecked);
		$templateklinik->setValue('ku_sedang', $unChecked);
		$templateklinik->setValue('ku_buruk', $unChecked);	
	}
	
	$gcs = 'E : ' . $obyektif['gcs_e'] . ' V : ' . $obyektif['gcs_v'] . ' M : ' . $obyektif['gcs_m']; 	
	$templateklinik->setValue('gcs', htmlspecialchars($gcs));
	$templateklinik->setValue('td', htmlspecialchars($obyektif['tekanan_darah']));
	$templateklinik->setValue('nadi', htmlspecialchars($obyektif['frekuensi_nadi']));
	$templateklinik->setValue('nafas', htmlspecialchars($obyektif['frekuensi_nafas']));
	$templateklinik->setValue('suhu', htmlspecialchars($obyektif['suhu_tubuh']));
	$templateklinik->setValue('bb', htmlspecialchars($obyektif['berat_badan']));
	$templateklinik->setValue('tb', htmlspecialchars($obyektif['tinggi_badan']));
	$templateklinik->setValue('skor_nyeri', htmlspecialchars($obyektif['skor_nyeri']));
	
	if($airway['airway_bebas'] == '1'){
		$templateklinik->setValue('aw_bebas', $checked);
	}else{
		$templateklinik->setValue('aw_bebas', $unChecked);
	}

	if($airway['airway_asing'] == '1'){
		$templateklinik->setValue('aw_asing', $checked);
	}else{
		$templateklinik->setValue('aw_asing', $unChecked);
	}

	if($airway['airway_sputum'] == '1'){
		$templateklinik->setValue('aw_sputum', $checked);
	}else{
		$templateklinik->setValue('aw_sputum', $unChecked);
	}

	if($airway['airway_darah'] == '1'){
		$templateklinik->setValue('aw_darah', $checked);
	}else{
		$templateklinik->setValue('aw_darah', $unChecked);
	}

	if($airway['airway_lidah'] == '1'){
		$templateklinik->setValue('aw_lidah', $checked);
	}else{
		$templateklinik->setValue('aw_lidah', $unChecked);
	}	
	
	if($breathing['breathing_normal'] == '1'){
		$templateklinik->setValue('bt_normal', $checked);
	}else{
		$templateklinik->setValue('bt_normal', $unChecked);
	}	
	
	if($breathing['breathing_tachipneu'] == '1'){
		$templateklinik->setValue('bt_tach', $checked);
	}else{
		$templateklinik->setValue('bt_tach', $unChecked);
	}	
	
	if($breathing['breathing_bradipneu'] == '1'){
		$templateklinik->setValue('bt_brad', $checked);
	}else{
		$templateklinik->setValue('bt_brad', $unChecked);
	}

	if($breathing['breathing_hiperventilasi'] == '1'){
		$templateklinik->setValue('bt_hiper', $checked);
	}else{
		$templateklinik->setValue('bt_hiper', $unChecked);
	}	
	
	if($breathing['breathing_orthopneu'] == '1'){
		$templateklinik->setValue('bt_ort', $checked);
	}else{
		$templateklinik->setValue('bt_ort', $unChecked);
	}

	if($breathing['breathing_apneu'] == '1'){
		$templateklinik->setValue('bt_apn', $checked);
	}else{
		$templateklinik->setValue('bt_apn', $unChecked);
	}

	if($breathing['bunyi_nafas'] == '1'){
		$templateklinik->setValue('bn_wheez', $checked);
		$templateklinik->setValue('bn_stri', $unChecked);
	}else if($breathing['bunyi_nafas'] == '2'){
		$templateklinik->setValue('bn_wheez', $unChecked);
		$templateklinik->setValue('bn_stri', $checked);	
	}else{
		$templateklinik->setValue('bn_wheez', $unChecked);
		$templateklinik->setValue('bn_stri', $unChecked);	
	}	
	
	if($breathing['irama_nafas'] == '1'){
		$templateklinik->setValue('in_teratur', $checked);
		$templateklinik->setValue('in_tdkteratur', $unChecked);
	}else if($breathing['irama_nafas'] == '2'){
		$templateklinik->setValue('in_teratur', $unChecked);
		$templateklinik->setValue('in_tdkteratur', $checked);
	}else{
		$templateklinik->setValue('in_teratur', $unChecked);
		$templateklinik->setValue('in_tdkteratur', $unChecked);	
	}	
	
	if($breathing['paru'] == '1'){
		$templateklinik->setValue('pp_menurun', $checked);
		$templateklinik->setValue('pp_retr', $unChecked);
		$templateklinik->setValue('pp_asimetris', $unChecked);
	}else if($breathing['paru'] == '2'){
		$templateklinik->setValue('pp_menurun', $unChecked);
		$templateklinik->setValue('pp_retr', $checked);
		$templateklinik->setValue('pp_asimetris', $unChecked);
	}else if($breathing['paru'] == '3'){
		$templateklinik->setValue('pp_menurun', $unChecked);
		$templateklinik->setValue('pp_retr', $unChecked);
		$templateklinik->setValue('pp_asimetris', $checked);	
	}else{
		$templateklinik->setValue('pp_menurun', $unChecked);
		$templateklinik->setValue('pp_retr', $unChecked);
		$templateklinik->setValue('pp_asimetris', $unChecked);
	}

	if($breathing['bantu_nafas'] == '1'){
		$templateklinik->setValue('ot_bahu', $checked);
		$templateklinik->setValue('ot_dada', $unChecked);
		$templateklinik->setValue('ot_cup', $unChecked);
		$templateklinik->setValue('ot_perut', $unChecked);
	}else if($breathing['bantu_nafas'] == '2'){
		$templateklinik->setValue('ot_bahu', $unChecked);
		$templateklinik->setValue('ot_dada', $checked);
		$templateklinik->setValue('ot_cup', $unChecked);
		$templateklinik->setValue('ot_perut', $unChecked);
	}else if($breathing['bantu_nafas'] == '3'){
		$templateklinik->setValue('ot_bahu', $unChecked);
		$templateklinik->setValue('ot_dada', $unChecked);
		$templateklinik->setValue('ot_cup', $checked);
		$templateklinik->setValue('ot_perut', $unChecked);
	}else if($breathing['bantu_nafas'] == '4'){
		$templateklinik->setValue('ot_bahu', $unChecked);
		$templateklinik->setValue('ot_dada', $unChecked);
		$templateklinik->setValue('ot_cup', $unChecked);
		$templateklinik->setValue('ot_perut', $checked);	
	}else{
		$templateklinik->setValue('ot_bahu', $unChecked);
		$templateklinik->setValue('ot_dada', $unChecked);
		$templateklinik->setValue('ot_cup', $unChecked);
		$templateklinik->setValue('ot_perut', $unChecked);
	}	
	
	if($circulation['kapiler'] == '1'){
		$templateklinik->setValue('kr_2dt', $checked);
		$templateklinik->setValue('lb_2dt', $unChecked);
	}else if($circulation['kapiler'] == '2'){
		$templateklinik->setValue('kr_2dt', $unChecked);
		$templateklinik->setValue('lb_2dt', $checked);
	}else{
		$templateklinik->setValue('kr_2dt', $unChecked);
		$templateklinik->setValue('lb_2dt', $unChecked);
	}	
	
	if($circulation['ekstremitas'] == '1'){
		$templateklinik->setValue('akr_dingin', $checked);
		$templateklinik->setValue('akr_hangat', $unChecked);
		$templateklinik->setValue('eks_pucat', $unChecked);
		$templateklinik->setValue('eks_sianosis', $unChecked);
	}else if($circulation['ekstremitas'] == '2'){
		$templateklinik->setValue('akr_dingin', $unChecked);
		$templateklinik->setValue('akr_hangat', $checked);
		$templateklinik->setValue('eks_pucat', $unChecked);
		$templateklinik->setValue('eks_sianosis', $unChecked);
	}else if($circulation['ekstremitas'] == '3'){
		$templateklinik->setValue('akr_dingin', $unChecked);
		$templateklinik->setValue('akr_hangat', $unChecked);
		$templateklinik->setValue('eks_pucat', $checked);
		$templateklinik->setValue('eks_sianosis', $unChecked);	
	}else if($circulation['ekstremitas'] == '4'){
		$templateklinik->setValue('akr_dingin', $unChecked);
		$templateklinik->setValue('akr_hangat', $unChecked);
		$templateklinik->setValue('eks_pucat', $unChecked);
		$templateklinik->setValue('eks_sianosis', $checked);		
	}else{
		$templateklinik->setValue('akr_dingin', $unChecked);
		$templateklinik->setValue('akr_hangat', $unChecked);
		$templateklinik->setValue('eks_pucat', $unChecked);
		$templateklinik->setValue('eks_sianosis', $unChecked);
	}	
	
	if($asesmen == '1'){
		$templateklinik->setValue('kt_emergent', $checked);
		$templateklinik->setValue('kt_urgent', $unChecked);
		$templateklinik->setValue('kt_nonurgent', $unChecked);
	}else if($asesmen == '2'){
		$templateklinik->setValue('kt_emergent', $unChecked);
		$templateklinik->setValue('kt_urgent', $checked);
		$templateklinik->setValue('kt_nonurgent', $unChecked);
	}else if($asesmen == '3'){
		$templateklinik->setValue('kt_emergent', $unChecked);
		$templateklinik->setValue('kt_urgent', $unChecked);
		$templateklinik->setValue('kt_nonurgent', $checked);	
	}else{
		$templateklinik->setValue('kt_emergent', $unChecked);
		$templateklinik->setValue('kt_urgent', $unChecked);
		$templateklinik->setValue('kt_nonurgent', $unChecked);
	}	
	
	if($tindak_lanjut == '1'){
		$templateklinik->setValue('tl_nonurgent', $checked);
		$templateklinik->setValue('tl_urgent', $unChecked);
		$templateklinik->setValue('tl_emergent', $unChecked);
	}else if($tindak_lanjut == '2'){
		$templateklinik->setValue('tl_nonurgent', $unChecked);
		$templateklinik->setValue('tl_urgent', $checked);
		$templateklinik->setValue('tl_emergent', $unChecked);
	}else if($tindak_lanjut == '3'){
		$templateklinik->setValue('tl_nonurgent', $unChecked);
		$templateklinik->setValue('tl_urgent', $unChecked);
		$templateklinik->setValue('tl_emergent', $checked);	
	}else{
		$templateklinik->setValue('tl_nonurgent', $unChecked);
		$templateklinik->setValue('tl_urgent', $unChecked);
		$templateklinik->setValue('tl_emergent', $unChecked);
	}	
	
	if(!file_exists($rmfile_path . '/pdf/1/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/pdf/1/' . $nomr . '/' . $idx, 0700, true);
	}

	if(!file_exists($rmfile_path . '/doc/1/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/doc/1/' . $nomr . '/' . $idx, 0700, true);
	}
	
	$nama_file = $nomr . '_' . $idx . '_40';	
	$templateklinik->saveAs($rmfile_path . '/doc/1/' . $nomr . '/' . $idx . '/' . $nama_file . '.docx');
	
	mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE RAWAT_ID = "' . $idx . '"
				AND JNS_PERAWATAN = "1"
				AND JENIS_DOKUMEN_ID = "40"
				AND NAMA_FILE = "' . $nama_file . '.pdf"') or die(mysql_error());
	mysql_query('INSERT INTO t_rm_dokumen_file(JENIS_DOKUMEN_ID,NOMR,RAWAT_ID,JNS_PERAWATAN,NAMA_FILE,ST_SISTEM,TANGGAL) 		
				VALUES("40","' . $nomr . '","' . $idx . '","1","' . $nama_file . '.pdf","1",STR_TO_DATE("' . $tgl_daftar . '","%d/%m/%Y"))') or die(mysql_error());
	
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