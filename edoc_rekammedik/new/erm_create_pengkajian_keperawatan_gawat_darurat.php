<?php
function replace_newline($str){
	$ret = preg_replace('/\r|\n/','\n',trim($str));
	$ret = str_replace('\n','<br>',$ret);
	$ret = str_replace('<br><br>','<br>',$ret);
	return $ret;
}

function erm_pengkajian_keperawatan_gawat_darurat($idx,$ls_assesment='',$tgl_skr='',$final=''){
	global $rmfile_path, $app_path;

	$checked = '<w:sym w:font="Wingdings" w:char="F0FE"/>';
    $unChecked = '<w:sym w:font="Wingdings" w:char="F0A8"/>';
	
	$templateklinik = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\pengkajian_keperawatan_gawat_darurat.docx');
	
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
	
	$qry_pengkajian = 'SELECT IRJA_ID,
			DATE_FORMAT(SELESAI_PUKUL,"%H") AS JAM_SELESAI,
			DATE_FORMAT(SELESAI_PUKUL,"%i") AS MENIT_SELESAI,
			TRIASE,RIWAYAT_MASUK,RIWAYAT_PENYAKIT,GENERAL_IMPRESSION,TANDA_VITAL,
			RESIKO_PASIEN_JATUH,RESIKO_PASIEN_DEKUBITUS,STATUS_KEHAMILAN,
			PEMERIKSAAN_PENUNJANG,DIAGNOSA_KEPERAWATAN,RENCANA_KEPERAWATAN,
			INTERVENSI_KEPERAWATAN,IMPLEMENTASI_KEPERAWATAN,PEMBERIAN_INFUS_OBAT,
			EVALUASI_KEPERAWATAN,FOLLOWUP,
			DATE_FORMAT(TGL_ASSESMENT,"%d-%m-%Y %H:%i") AS TGL_ASSESMENT,
			NAMA_PEGAWAI
			FROM t_igd_pengkajian_keperawatan
			INNER JOIN m_pegawai ON (t_igd_pengkajian_keperawatan.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
			WHERE IRJA_ID = "' . $idx . '"';
	$get_pengkajian = mysql_query($qry_pengkajian) or die(mysql_error());
	$dat_pasien = mysql_fetch_assoc($get_pengkajian);
	$idx_pengkajian = $dat_pasien['IRJA_ID'];
	
	$jam_selesai = $dat_pasien['JAM_SELESAI']; 
	$menit_selesai = $dat_pasien['MENIT_SELESAI']; 
	$nama_perawat = $dat_pasien['NAMA_PEGAWAI']; 

	$triase = str_replace('|','"',$dat_pasien['TRIASE']);
	$triase = preg_replace('/\r|\n/','\n',trim($triase));
	$triase = json_decode($triase,true);

	$riwayat_masuk = str_replace('|','"',$dat_pasien['RIWAYAT_MASUK']);
	$riwayat_masuk = preg_replace('/\r|\n/','\n',trim($riwayat_masuk));
	$riwayat_masuk = json_decode($riwayat_masuk,true);

	$riwayat_penyakit = str_replace('|','"',$dat_pasien['RIWAYAT_PENYAKIT']);
	$riwayat_penyakit = preg_replace('/\r|\n/','\n',trim($riwayat_penyakit));
	$riwayat_penyakit = json_decode($riwayat_penyakit,true);

	$general_impression = str_replace('|','"',$dat_pasien['GENERAL_IMPRESSION']);
	$general_impression = preg_replace('/\r|\n/','\n',trim($general_impression));
	$general_impression = json_decode($general_impression,true);

	$tanda_vital = str_replace('|','"',$dat_pasien['TANDA_VITAL']);
	$tanda_vital = preg_replace('/\r|\n/','\n',trim($tanda_vital));
	$tanda_vital = json_decode($tanda_vital,true);

	$risiko_pasien_jatuh = str_replace('|','"',$dat_pasien['RESIKO_PASIEN_JATUH']);
	$risiko_pasien_jatuh = preg_replace('/\r|\n/','\n',trim($risiko_pasien_jatuh));
	$risiko_pasien_jatuh = json_decode($risiko_pasien_jatuh,true);

	$risiko_pasien_dekubitus = str_replace('|','"',$dat_pasien['RESIKO_PASIEN_DEKUBITUS']);
	$risiko_pasien_dekubitus = preg_replace('/\r|\n/','\n',trim($risiko_pasien_dekubitus));
	$risiko_pasien_dekubitus = json_decode($risiko_pasien_dekubitus,true);

	$status_kehamilan = str_replace('|','"',$dat_pasien['STATUS_KEHAMILAN']);
	$status_kehamilan = preg_replace('/\r|\n/','\n',trim($status_kehamilan));
	$status_kehamilan = json_decode($status_kehamilan,true);

	$pemeriksaan_penunjang = str_replace('|','"',$dat_pasien['PEMERIKSAAN_PENUNJANG']);
	$pemeriksaan_penunjang = preg_replace('/\r|\n/','\n',trim($pemeriksaan_penunjang));
	$pemeriksaan_penunjang = json_decode($pemeriksaan_penunjang,true);

	$diagnosa_keperawatan = str_replace('|','"',$dat_pasien['DIAGNOSA_KEPERAWATAN']);
	$diagnosa_keperawatan = preg_replace('/\r|\n/','\n',trim($diagnosa_keperawatan));
	$diagnosa_keperawatan = json_decode($diagnosa_keperawatan,true);

	$rencana_keperawatan = $dat_pasien['RENCANA_KEPERAWATAN'];

	$intervensi_keperawatan = str_replace('|','"',$dat_pasien['INTERVENSI_KEPERAWATAN']);
	$intervensi_keperawatan = preg_replace('/\r|\n/','\n',trim($intervensi_keperawatan));
	$intervensi_keperawatan = json_decode($intervensi_keperawatan,true);

	$implementasi_keperawatan = str_replace('|','"',$dat_pasien['IMPLEMENTASI_KEPERAWATAN']);
	$implementasi_keperawatan = preg_replace('/\r|\n/','\n',trim($implementasi_keperawatan));
	$implementasi_keperawatan = json_decode($implementasi_keperawatan,true);

	$infus_obat = str_replace('|','"',$dat_pasien['PEMBERIAN_INFUS_OBAT']);
	$infus_obat = preg_replace('/\r|\n/','\n',trim($infus_obat));
	$infus_obat = json_decode($infus_obat,true);

	$evaluasi_keperawatan = str_replace('|','"',$dat_pasien['EVALUASI_KEPERAWATAN']);
	$evaluasi_keperawatan = preg_replace('/\r|\n/','\n',trim($evaluasi_keperawatan));
	$evaluasi_keperawatan = json_decode($evaluasi_keperawatan,true);

	$followup = str_replace('|','"',$dat_pasien['FOLLOWUP']);
	$followup = preg_replace('/\r|\n/','\n',trim($followup));
	$followup = json_decode($followup,true);
	
	if($triase['triage_emergency'] == '1'){
		$templateklinik->setValue('emg',$checked);
	}else{
		$templateklinik->setValue('emg',$unChecked);
	}

	if($triase['triage_urgent'] == '1'){
		$templateklinik->setValue('urg',$checked);
	}else{
		$templateklinik->setValue('urg',$unChecked);
	}	
	
	if($triase['triage_non_urgent'] == '1'){
		$templateklinik->setValue('nur',$checked);
	}else{
		$templateklinik->setValue('nur',$unChecked);
	}	
	
	if($triase['triage_false_emergency'] == '1'){
		$templateklinik->setValue('fls',$checked);
	}else{
		$templateklinik->setValue('fls',$unChecked);
	}	
	
	if($triase['triage_doa'] == '1'){
		$templateklinik->setValue('doa',$checked);
	}else{
		$templateklinik->setValue('doa',$unChecked);
	}	
	
	if($riwayat_masuk['informasi_dapat'] == '1'){
		$templateklinik->setValue('auto_anam',$checked);
		$templateklinik->setValue('hetero_anam',$unChecked);
	}else if($riwayat_masuk['informasi_dapat'] == '2'){
		$templateklinik->setValue('auto_anam',$unChecked);
		$templateklinik->setValue('hetero_anam',$checked);	
	}else{
		$templateklinik->setValue('auto_anam',$unChecked);
		$templateklinik->setValue('hetero_anam',$unChecked);	
	}	
	
	if($riwayat_masuk['cara_masuk'] == '1'){
		$templateklinik->setValue('cm_jalan',$checked);
		$templateklinik->setValue('cm_bantuan',$unChecked);	
		$templateklinik->setValue('cm_kursi',$unChecked);
		$templateklinik->setValue('cm_tidur',$unChecked);	
	}else if($riwayat_masuk['cara_masuk'] == '2'){
		$templateklinik->setValue('cm_jalan',$unChecked);
		$templateklinik->setValue('cm_bantuan',$checked);	
		$templateklinik->setValue('cm_kursi',$unChecked);
		$templateklinik->setValue('cm_tidur',$unChecked);
	}else if($riwayat_masuk['cara_masuk'] == '3'){
		$templateklinik->setValue('cm_jalan',$unChecked);
		$templateklinik->setValue('cm_bantuan',$unChecked);	
		$templateklinik->setValue('cm_kursi',$checked);
		$templateklinik->setValue('cm_tidur',$unChecked);	
	}else if($riwayat_masuk['cara_masuk'] == '4'){
		$templateklinik->setValue('cm_jalan',$unChecked);
		$templateklinik->setValue('cm_bantuan',$unChecked);	
		$templateklinik->setValue('cm_kursi',$unChecked);
		$templateklinik->setValue('cm_tidur',$checked);			
	}else{
		$templateklinik->setValue('cm_jalan',$unChecked);
		$templateklinik->setValue('cm_bantuan',$unChecked);	
		$templateklinik->setValue('cm_kursi',$unChecked);
		$templateklinik->setValue('cm_tidur',$unChecked);	
	}	

	if($riwayat_masuk['asal_masuk'] == '1'){
		$templateklinik->setValue('non_rujukan',$checked);
		$templateklinik->setValue('rujukan',$unChecked);		
	}else if($riwayat_masuk['asal_masuk'] == '2'){
		$templateklinik->setValue('non_rujukan',$unChecked);
		$templateklinik->setValue('rujukan',$checked);	
	}else{
		$templateklinik->setValue('non_rujukan',$unChecked);
		$templateklinik->setValue('rujukan',$unChecked);	
	}		
		
	$templateklinik->setValue('nam_anam', htmlspecialchars($riwayat_masuk['anamnesa_nama']));	
	$templateklinik->setValue('hub_anam', htmlspecialchars($riwayat_masuk['anamnesa_hubungan']));	
	
	$riwayat_penyakit_skr = replace_newline($riwayat_penyakit['sekarang']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($riwayat_penyakit_skr);
	$templateklinik->setValue('riwayat_penyakit_skr', $toOpenXML);
	
	$riwayat_penyakit_dhl = replace_newline($riwayat_penyakit['dahulu']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($riwayat_penyakit_dhl);
	$templateklinik->setValue('riwayat_penyakit_dahulu', $toOpenXML);
	
	$riwayat_penyakit_obat = replace_newline($riwayat_penyakit['pengobatan']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($riwayat_penyakit_obat);
	$templateklinik->setValue('riwayat_pengobatan_sebelumnya', $toOpenXML);
	
	$templateklinik->setValue('tb', htmlspecialchars($riwayat_penyakit['rp_tb']));	
	$templateklinik->setValue('bb', htmlspecialchars($riwayat_penyakit['rp_bb']));

	$keluhan_utama = replace_newline($general_impression['keluhan_utama']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($keluhan_utama);
	$templateklinik->setValue('keluhan_utama', $toOpenXML);	
	
	$mekanisme_cedera = replace_newline($general_impression['mekanisme_cedera']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($mekanisme_cedera);
	$templateklinik->setValue('mekanisme_cedera', $toOpenXML);	
	
	if($general_impression['orientasi'] == '1'){
		$templateklinik->setValue('or_baik',$checked);
		$templateklinik->setValue('or_tdkbaik',$unChecked);
	}else if($general_impression['orientasi'] == '2'){
		$templateklinik->setValue('or_tdkbaik',$unChecked);
		$templateklinik->setValue('hetero_anam',$checked);	
	}else{
		$templateklinik->setValue('or_baik',$unChecked);
		$templateklinik->setValue('or_tdkbaik',$unChecked);	
	}	
	
	$gcs = 'E : ' . $tanda_vital['gcs_e'] . ' M : ' . $tanda_vital['gcs_m'] . ' V : ' . $tanda_vital['gcs_v'];
	$templateklinik->setValue('gcs', htmlspecialchars($gcs));
	$templateklinik->setValue('spo', htmlspecialchars($tanda_vital['spo']));
	$templateklinik->setValue('td', htmlspecialchars($tanda_vital['td']));
	$templateklinik->setValue('reflex_cahaya', htmlspecialchars($tanda_vital['reflex_cahaya_l'] . '/' . $tanda_vital['reflex_cahaya_r']));
	$templateklinik->setValue('nafas', htmlspecialchars($tanda_vital['nafas']));
	$templateklinik->setValue('suhu', htmlspecialchars($tanda_vital['suhu']));
	$templateklinik->setValue('nadi', htmlspecialchars($tanda_vital['nadi']));
	$templateklinik->setValue('akral', htmlspecialchars($tanda_vital['akral']));
	
	if($tanda_vital['nadi_reguler'] == '1'){
		$templateklinik->setValue('nadi_reg',$checked);
		$templateklinik->setValue('nadi_irreg',$unChecked);
	}else if($tanda_vital['nadi_reguler'] == '2'){
		$templateklinik->setValue('nadi_reg',$unChecked);
		$templateklinik->setValue('nadi_irreg',$checked);	
	}else{
		$templateklinik->setValue('nadi_reg',$unChecked);
		$templateklinik->setValue('nadi_irreg',$unChecked);	
	}	
	
	if($tanda_vital['respon'] == '1'){
		$templateklinik->setValue('rs_alr',$checked);
		$templateklinik->setValue('rs_vbl',$unChecked);
		$templateklinik->setValue('rs_un',$unChecked);
	}else if($tanda_vital['respon'] == '2'){
		$templateklinik->setValue('rs_alr',$unChecked);
		$templateklinik->setValue('rs_vbl',$checked);
		$templateklinik->setValue('rs_un',$unChecked);
	}else if($tanda_vital['respon'] == '3'){
		$templateklinik->setValue('rs_alr',$unChecked);
		$templateklinik->setValue('rs_vbl',$unChecked);
		$templateklinik->setValue('rs_un',$checked);	
	}else{
		$templateklinik->setValue('rs_alr',$unChecked);
		$templateklinik->setValue('rs_vbl',$unChecked);
		$templateklinik->setValue('rs_un',$unChecked);	
	}	
	
	if($tanda_vital['kesadaran'] == '1'){
		$templateklinik->setValue('sd_cm',$checked);
		$templateklinik->setValue('sd_deli',$unChecked);
		$templateklinik->setValue('sd_som',$unChecked);
		$templateklinik->setValue('sd_sop',$unChecked);
		$templateklinik->setValue('sd_com',$unChecked);
	}else if($tanda_vital['kesadaran'] == '1'){
		$templateklinik->setValue('sd_cm',$unChecked);
		$templateklinik->setValue('sd_deli',$checked);
		$templateklinik->setValue('sd_som',$unChecked);
		$templateklinik->setValue('sd_sop',$unChecked);
		$templateklinik->setValue('sd_com',$unChecked);
	}else if($tanda_vital['kesadaran'] == '1'){
		$templateklinik->setValue('sd_cm',$unChecked);
		$templateklinik->setValue('sd_deli',$unChecked);
		$templateklinik->setValue('sd_som',$checked);
		$templateklinik->setValue('sd_sop',$unChecked);
		$templateklinik->setValue('sd_com',$unChecked);
	}else if($tanda_vital['kesadaran'] == '1'){
		$templateklinik->setValue('sd_cm',$unChecked);
		$templateklinik->setValue('sd_deli',$unChecked);
		$templateklinik->setValue('sd_som',$unChecked);
		$templateklinik->setValue('sd_sop',$checked);
		$templateklinik->setValue('sd_com',$unChecked);
	}else if($tanda_vital['kesadaran'] == '1'){
		$templateklinik->setValue('sd_cm',$unChecked);
		$templateklinik->setValue('sd_deli',$unChecked);
		$templateklinik->setValue('sd_som',$unChecked);
		$templateklinik->setValue('sd_sop',$unChecked);
		$templateklinik->setValue('sd_com',$checked);
	}else{
		$templateklinik->setValue('sd_cm',$unChecked);
		$templateklinik->setValue('sd_deli',$unChecked);
		$templateklinik->setValue('sd_som',$unChecked);
		$templateklinik->setValue('sd_sop',$unChecked);
		$templateklinik->setValue('sd_com',$unChecked);
	}	

	$templateklinik->setValue('gcs_e', htmlspecialchars($tanda_vital['gcs_e2']));	
	$templateklinik->setValue('gcs_v', htmlspecialchars($tanda_vital['gcs_v2']));	
	$templateklinik->setValue('gcs_m', htmlspecialchars($tanda_vital['gcs_m2']));	
	
	if($tanda_vital['pupil'] == '1'){
		$templateklinik->setValue('pp_iso',$checked);
		$templateklinik->setValue('pp_uni',$unChecked);
		$templateklinik->setValue('pp_pin',$unChecked);
		$templateklinik->setValue('pp_lain',$unChecked);
	}else if($tanda_vital['pupil'] == '2'){
		$templateklinik->setValue('pp_iso',$unChecked);
		$templateklinik->setValue('pp_uni',$checked);
		$templateklinik->setValue('pp_pin',$unChecked);
		$templateklinik->setValue('pp_lain',$unChecked);
	}else if($tanda_vital['pupil'] == '3'){
		$templateklinik->setValue('pp_iso',$unChecked);
		$templateklinik->setValue('pp_uni',$unChecked);
		$templateklinik->setValue('pp_pin',$checked);
		$templateklinik->setValue('pp_lain',$unChecked);
	}else if($tanda_vital['pupil'] == '4'){
		$templateklinik->setValue('pp_iso',$unChecked);
		$templateklinik->setValue('pp_uni',$unChecked);
		$templateklinik->setValue('pp_pin',$unChecked);
		$templateklinik->setValue('pp_lain',$checked);
	}else{
		$templateklinik->setValue('pp_iso',$unChecked);
		$templateklinik->setValue('pp_uni',$unChecked);
		$templateklinik->setValue('pp_pin',$unChecked);
		$templateklinik->setValue('pp_lain',$unChecked);
	}	
	
	$templateklinik->setValue('pp_lain_ket', htmlspecialchars($tanda_vital['pupil_ket']));	
			
	if($tanda_vital['reflex_cahaya'] == '1'){
		$templateklinik->setValue('ch_ada',$checked);
		$templateklinik->setValue('ch_tdk',$unChecked);
	}else if($tanda_vital['reflex_cahaya'] == '2'){
		$templateklinik->setValue('ch_ada',$unChecked);
		$templateklinik->setValue('ch_tdk',$checked);
	}else{
		$templateklinik->setValue('ch_ada',$unChecked);
		$templateklinik->setValue('ch_tdk',$unChecked);
	}
	
	if($tanda_vital['crt'] == '1'){
		$templateklinik->setValue('cr_m2',$checked);
		$templateklinik->setValue('cr_l2',$unChecked);
	}else if($tanda_vital['crt'] == '2'){
		$templateklinik->setValue('cr_m2',$unChecked);
		$templateklinik->setValue('cr_l2',$checked);
	}else{
		$templateklinik->setValue('cr_m2',$unChecked);
		$templateklinik->setValue('cr_l2',$unChecked);
	}
	
	if($tanda_vital['sianosis'] == '1'){
		$templateklinik->setValue('si_ya',$checked);
		$templateklinik->setValue('si_tdk',$unChecked);
	}else if($tanda_vital['sianosis'] == '2'){
		$templateklinik->setValue('si_ya',$unChecked);
		$templateklinik->setValue('si_tdk',$checked);
	}else{
		$templateklinik->setValue('si_ya',$unChecked);
		$templateklinik->setValue('si_tdk',$unChecked);
	}
	
	if($tanda_vital['nadi_teraba'] == '1'){
		$templateklinik->setValue('nd_tr',$checked);
		$templateklinik->setValue('nd_tdk',$unChecked);
	}else if($tanda_vital['nadi_teraba'] == '2'){
		$templateklinik->setValue('nd_tr',$unChecked);
		$templateklinik->setValue('nd_tdk',$checked);
	}else{
		$templateklinik->setValue('nd_tr',$unChecked);
		$templateklinik->setValue('nd_tdk',$unChecked);
	}
	
	if($tanda_vital['sesak_nafas'] == '1'){
		$templateklinik->setValue('sn_ada',$checked);
		$templateklinik->setValue('sn_na',$unChecked);
		$templateklinik->setValue('sn_rr',$unChecked);
	}else if($tanda_vital['sesak_nafas'] == '2'){
		$templateklinik->setValue('sn_ada',$unChecked);
		$templateklinik->setValue('sn_na',$checked);
		$templateklinik->setValue('sn_rr',$unChecked);
	}else if($tanda_vital['sesak_nafas'] == '3'){
		$templateklinik->setValue('sn_ada',$unChecked);
		$templateklinik->setValue('sn_na',$unChecked);
		$templateklinik->setValue('sn_rr',$checked);	
	}else{
		$templateklinik->setValue('sn_ada',$unChecked);
		$templateklinik->setValue('sn_na',$unChecked);
		$templateklinik->setValue('sn_rr',$unChecked);	
	}
	
	$templateklinik->setValue('sn_rr_ket', htmlspecialchars($tanda_vital['sesak_nafas_ket']));	
	
	if($tanda_vital['jalan_nafas'] == '1'){
		$templateklinik->setValue('jn_paten',$checked);
		$templateklinik->setValue('jn_tdk',$unChecked);
	}else if($tanda_vital['jalan_nafas'] == '2'){
		$templateklinik->setValue('jn_paten',$unChecked);
		$templateklinik->setValue('jn_tdk',$checked);
	}else{
		$templateklinik->setValue('jn_paten',$unChecked);
		$templateklinik->setValue('jn_tdk',$unChecked);
	}
	
	if($tanda_vital['obstruksi'] == '1'){
		$templateklinik->setValue('ob_lidah',$checked);
		$templateklinik->setValue('ob_cair',$unChecked);
		$templateklinik->setValue('ob_asing',$unChecked);
		$templateklinik->setValue('ob_na',$unChecked);
	}else if($tanda_vital['obstruksi'] == '2'){
		$templateklinik->setValue('ob_lidah',$unChecked);
		$templateklinik->setValue('ob_cair',$checked);
		$templateklinik->setValue('ob_asing',$unChecked);
		$templateklinik->setValue('ob_na',$unChecked);
	}else if($tanda_vital['obstruksi'] == '3'){
		$templateklinik->setValue('ob_lidah',$unChecked);
		$templateklinik->setValue('ob_cair',$unChecked);
		$templateklinik->setValue('ob_asing',$checked);
		$templateklinik->setValue('ob_na',$unChecked);
	}else if($tanda_vital['obstruksi'] == '4'){
		$templateklinik->setValue('ob_lidah',$unChecked);
		$templateklinik->setValue('ob_cair',$unChecked);
		$templateklinik->setValue('ob_asing',$unChecked);
		$templateklinik->setValue('ob_na',$checked);		
	}else{
		$templateklinik->setValue('ob_lidah',$unChecked);
		$templateklinik->setValue('ob_cair',$unChecked);
		$templateklinik->setValue('ob_asing',$unChecked);
		$templateklinik->setValue('ob_na',$unChecked);		
	}
	
	if($tanda_vital['suara_nafas'] == '1'){
		$templateklinik->setValue('sn_sno',$checked);
		$templateklinik->setValue('sn_grugling',$unChecked);
	}else if($tanda_vital['suara_nafas'] == '2'){
		$templateklinik->setValue('sn_sno',$unChecked);
		$templateklinik->setValue('sn_grugling',$checked);
	}else{
		$templateklinik->setValue('sn_sno',$unChecked);
		$templateklinik->setValue('sn_grugling',$unChecked);
	}
	
	if($tanda_vital['gerakan_dada'] == '1'){
		$templateklinik->setValue('gd_si',$checked);
		$templateklinik->setValue('gd_asi',$unChecked);
	}else if($tanda_vital['gerakan_dada'] == '2'){
		$templateklinik->setValue('gd_si',$unChecked);
		$templateklinik->setValue('gd_asi',$checked);
	}else{
		$templateklinik->setValue('gd_si',$unChecked);
		$templateklinik->setValue('gd_asi',$unChecked);
	}
	
	if($tanda_vital['irama_nafas'] == '1'){
		$templateklinik->setValue('in_cpt',$checked);
		$templateklinik->setValue('in_dkl',$unChecked);
		$templateklinik->setValue('in_nor',$unChecked);
	}else if($tanda_vital['irama_nafas'] == '2'){
		$templateklinik->setValue('in_cpt',$unChecked);
		$templateklinik->setValue('in_dkl',$checked);
		$templateklinik->setValue('in_nor',$unChecked);
	}else if($tanda_vital['irama_nafas'] == '3'){
		$templateklinik->setValue('in_cpt',$unChecked);
		$templateklinik->setValue('in_dkl',$unChecked);
		$templateklinik->setValue('in_nor',$checked);	
	}else{
		$templateklinik->setValue('in_cpt',$unChecked);
		$templateklinik->setValue('in_dkl',$unChecked);
		$templateklinik->setValue('in_nor',$unChecked);	
	}
	
	if($tanda_vital['pola_nafas'] == '1'){
		$templateklinik->setValue('pl_ter',$checked);
		$templateklinik->setValue('pl_tdk',$unChecked);
	}else if($tanda_vital['pola_nafas'] == '2'){
		$templateklinik->setValue('pl_ter',$unChecked);
		$templateklinik->setValue('pl_tdk',$checked);
	}else{
		$templateklinik->setValue('pl_ter',$unChecked);
		$templateklinik->setValue('pl_tdk',$unChecked);
	}
	
	if($tanda_vital['retraksi_otot'] == '1'){
		$templateklinik->setValue('od_ada',$checked);
		$templateklinik->setValue('od_na',$unChecked);
	}else if($tanda_vital['retraksi_otot'] == '2'){
		$templateklinik->setValue('od_ada',$unChecked);
		$templateklinik->setValue('od_na',$checked);
	}else{
		$templateklinik->setValue('od_ada',$unChecked);
		$templateklinik->setValue('od_na',$unChecked);
	}
	
	if($tanda_vital['pendarahan'] == '1'){
		$templateklinik->setValue('dr_ya',$checked);
		$templateklinik->setValue('dr_tdk',$unChecked);
	}else if($tanda_vital['pendarahan'] == '2'){
		$templateklinik->setValue('dr_ya',$unChecked);
		$templateklinik->setValue('dr_tdk',$checked);
	}else{
		$templateklinik->setValue('dr_ya',$unChecked);
		$templateklinik->setValue('dr_tdk',$unChecked);
	}
	
	if($tanda_vital['deformitas'] == '1'){
		$templateklinik->setValue('df_ya',$checked);
		$templateklinik->setValue('df_tdk',$unChecked);
	}else if($tanda_vital['deformitas'] == '2'){
		$templateklinik->setValue('df_ya',$unChecked);
		$templateklinik->setValue('df_tdk',$checked);
	}else{
		$templateklinik->setValue('df_ya',$unChecked);
		$templateklinik->setValue('df_tdk',$unChecked);
	}
	
	if($tanda_vital['contusio'] == '1'){
		$templateklinik->setValue('co_ya',$checked);
		$templateklinik->setValue('co_tdk',$unChecked);
	}else if($tanda_vital['contusio'] == '2'){
		$templateklinik->setValue('co_ya',$unChecked);
		$templateklinik->setValue('co_tdk',$checked);
	}else{
		$templateklinik->setValue('co_ya',$unChecked);
		$templateklinik->setValue('co_tdk',$unChecked);
	}
	
	if($tanda_vital['abrasi'] == '1'){
		$templateklinik->setValue('br_ya',$checked);
		$templateklinik->setValue('br_tdk',$unChecked);
	}else if($tanda_vital['abrasi'] == '2'){
		$templateklinik->setValue('br_ya',$unChecked);
		$templateklinik->setValue('br_tdk',$checked);
	}else{
		$templateklinik->setValue('br_ya',$unChecked);
		$templateklinik->setValue('br_tdk',$unChecked);
	}
	
	if($tanda_vital['penetrasi'] == '1'){
		$templateklinik->setValue('pt_ya',$checked);
		$templateklinik->setValue('pt_tdk',$unChecked);
	}else if($tanda_vital['penetrasi'] == '2'){
		$templateklinik->setValue('pt_ya',$unChecked);
		$templateklinik->setValue('pt_tdk',$checked);
	}else{
		$templateklinik->setValue('pt_ya',$unChecked);
		$templateklinik->setValue('pt_tdk',$unChecked);
	}
	
	if($tanda_vital['leserasi'] == '1'){
		$templateklinik->setValue('ls_ya',$checked);
		$templateklinik->setValue('ls_tdk',$unChecked);
	}else if($tanda_vital['leserasi'] == '2'){
		$templateklinik->setValue('ls_ya',$unChecked);
		$templateklinik->setValue('ls_tdk',$checked);
	}else{
		$templateklinik->setValue('ls_ya',$unChecked);
		$templateklinik->setValue('ls_tdk',$unChecked);
	}
	
	if($tanda_vital['edema'] == '1'){
		$templateklinik->setValue('dm_ya',$checked);
		$templateklinik->setValue('dm_tdk',$unChecked);
	}else if($tanda_vital['edema'] == '2'){
		$templateklinik->setValue('dm_ya',$unChecked);
		$templateklinik->setValue('dm_tdk',$checked);
	}else{
		$templateklinik->setValue('dm_ya',$unChecked);
		$templateklinik->setValue('dm_tdk',$unChecked);
	}
	
	if($tanda_vital['kejang'] == '1'){
		$templateklinik->setValue('jg_ya',$checked);
		$templateklinik->setValue('jg_tdk',$unChecked);
	}else if($tanda_vital['kejang'] == '2'){
		$templateklinik->setValue('jg_ya',$unChecked);
		$templateklinik->setValue('jg_tdk',$checked);
	}else{
		$templateklinik->setValue('jg_ya',$unChecked);
		$templateklinik->setValue('jg_tdk',$unChecked);
	}
	
	$templateklinik->setValue('lama_kejang', htmlspecialchars($tanda_vital['lama_kejang']));	
	$templateklinik->setValue('skala_nyeri', htmlspecialchars($tanda_vital['skala_nyeri']));
	$templateklinik->setValue('lama_nyeri', htmlspecialchars($tanda_vital['lama_nyeri']));
	$templateklinik->setValue('pemicu_nyeri', htmlspecialchars($tanda_vital['pemicu_nyeri']));
	$templateklinik->setValue('penghilang_nyeri', htmlspecialchars($tanda_vital['pengurang_nyeri']));

	if($tanda_vital['frekuensi_nyeri'] == '1'){
		$templateklinik->setValue('fr_jrg',$checked);
		$templateklinik->setValue('fr_hlg',$unChecked);
		$templateklinik->setValue('fr_trs',$unChecked);
	}else if($tanda_vital['frekuensi_nyeri'] == '2'){
		$templateklinik->setValue('fr_jrg',$unChecked);
		$templateklinik->setValue('fr_hlg',$checked);
		$templateklinik->setValue('fr_trs',$unChecked);
	}else if($tanda_vital['frekuensi_nyeri'] == '3'){
		$templateklinik->setValue('fr_jrg',$unChecked);
		$templateklinik->setValue('fr_hlg',$unChecked);
		$templateklinik->setValue('fr_trs',$checked);	
	}else{
		$templateklinik->setValue('fr_jrg',$unChecked);
		$templateklinik->setValue('fr_hlg',$unChecked);
		$templateklinik->setValue('fr_trs',$unChecked);
	}	
	
	if($tanda_vital['nyeri_menjalar'] == '1'){
		$templateklinik->setValue('mj_tdk',$checked);
		$templateklinik->setValue('mj_ya',$unChecked);
	}else if($tanda_vital['nyeri_menjalar'] == '2'){
		$templateklinik->setValue('mj_tdk',$unChecked);
		$templateklinik->setValue('mj_ya',$checked);
	}else{
		$templateklinik->setValue('mj_tdk',$unChecked);
		$templateklinik->setValue('mj_ya',$unChecked);
	}
	
	if($tanda_vital['kualitas_nyeri'] == '1'){
		$templateklinik->setValue('ny_tmp',$checked);
		$templateklinik->setValue('ny_tajam',$unChecked);
		$templateklinik->setValue('ny_pns',$unChecked);
	}else if($tanda_vital['kualitas_nyeri'] == '2'){
		$templateklinik->setValue('ny_tmp',$unChecked);
		$templateklinik->setValue('ny_tajam',$checked);
		$templateklinik->setValue('ny_pns',$unChecked);
	}else if($tanda_vital['kualitas_nyeri'] == '3'){
		$templateklinik->setValue('ny_tmp',$unChecked);
		$templateklinik->setValue('ny_tajam',$unChecked);
		$templateklinik->setValue('ny_pns',$checked);	
	}else{
		$templateklinik->setValue('ny_tmp',$unChecked);
		$templateklinik->setValue('ny_tajam',$unChecked);
		$templateklinik->setValue('ny_pns',$unChecked);	
	}
	
	if($tanda_vital['pengkajian_fungsi'] == '1'){
		$templateklinik->setValue('as_mdr',$checked);
		$templateklinik->setValue('as_btn',$unChecked);
	}else if($tanda_vital['pengkajian_fungsi'] == '2'){
		$templateklinik->setValue('as_mdr',$unChecked);
		$templateklinik->setValue('as_btn',$checked);
	}else{
		$templateklinik->setValue('as_mdr',$unChecked);
		$templateklinik->setValue('as_btn',$unChecked);
	}
	
	$keluhan_tambahan = replace_newline($tanda_vital['keluhan_tambahan']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($keluhan_tambahan);
	$templateklinik->setValue('keluhan_tambahan', $toOpenXML);	
	
	if($risiko_pasien_jatuh['pasien_jatuh_1'] == '1'){
		$templateklinik->setValue('jatuh_ya',$checked);
		$templateklinik->setValue('jatuh_tdk',$unChecked);
	}else if($risiko_pasien_jatuh['pasien_jatuh_1'] == '2'){
		$templateklinik->setValue('jatuh_ya',$unChecked);
		$templateklinik->setValue('jatuh_tdk',$checked);
	}else{
		$templateklinik->setValue('jatuh_ya',$unChecked);
		$templateklinik->setValue('jatuh_tdk',$unChecked);
	}
	
	if($risiko_pasien_jatuh['pasien_jatuh_2'] == '1'){
		$templateklinik->setValue('bantu_ya',$checked);
		$templateklinik->setValue('bantu_tdk',$unChecked);
	}else if($risiko_pasien_jatuh['pasien_jatuh_2'] == '2'){
		$templateklinik->setValue('bantu_ya',$unChecked);
		$templateklinik->setValue('bantu_tdk',$checked);
	}else{
		$templateklinik->setValue('bantu_ya',$unChecked);
		$templateklinik->setValue('bantu_tdk',$unChecked);
	}
	
	if($risiko_pasien_jatuh['pasien_jatuh_3'] == '1'){
		$templateklinik->setValue('jalan_ya',$checked);
		$templateklinik->setValue('jalan_tdk',$unChecked);
	}else if($risiko_pasien_jatuh['pasien_jatuh_3'] == '2'){
		$templateklinik->setValue('jalan_ya',$unChecked);
		$templateklinik->setValue('jalan_tdk',$checked);
	}else{
		$templateklinik->setValue('jalan_ya',$unChecked);
		$templateklinik->setValue('jalan_tdk',$unChecked);
	}
	
	if($risiko_pasien_jatuh['intervensi_pasien_jatuh_1'] == '1'){
		$templateklinik->setValue('psg_pagar',$checked);
	}else{
		$templateklinik->setValue('psg_pagar',$unChecked);
	}
	
	if($risiko_pasien_jatuh['intervensi_pasien_jatuh_2'] == '1'){
		$templateklinik->setValue('edk_penc',$checked);
	}else{
		$templateklinik->setValue('edk_penc',$unChecked);
	}
	
	if($risiko_pasien_jatuh['intervensi_pasien_jatuh_3'] == '1'){
		$templateklinik->setValue('psg_sign',$checked);
	}else{
		$templateklinik->setValue('psg_sign',$unChecked);
	}
	
	if($risiko_pasien_dekubitus['pasien_dekubitus_1'] == '1'){
		$templateklinik->setValue('roda_ya',$checked);
		$templateklinik->setValue('roda_tdk',$unChecked);
	}else if($risiko_pasien_dekubitus['pasien_dekubitus_1'] == '2'){
		$templateklinik->setValue('roda_ya',$unChecked);
		$templateklinik->setValue('roda_tdk',$checked);
	}else{
		$templateklinik->setValue('roda_ya',$unChecked);
		$templateklinik->setValue('roda_tdk',$unChecked);
	}
	
	if($risiko_pasien_dekubitus['pasien_dekubitus_2'] == '1'){
		$templateklinik->setValue('ink_ya',$checked);
		$templateklinik->setValue('ink_tdk',$unChecked);
	}else if($risiko_pasien_dekubitus['pasien_dekubitus_2'] == '2'){
		$templateklinik->setValue('ink_ya',$unChecked);
		$templateklinik->setValue('ink_tdk',$checked);
	}else{
		$templateklinik->setValue('ink_ya',$unChecked);
		$templateklinik->setValue('ink_tdk',$unChecked);
	}
	
	if($risiko_pasien_dekubitus['pasien_dekubitus_3'] == '1'){
		$templateklinik->setValue('dek_ya',$checked);
		$templateklinik->setValue('dek_tdk',$unChecked);
	}else if($risiko_pasien_dekubitus['pasien_dekubitus_3'] == '2'){
		$templateklinik->setValue('dek_ya',$unChecked);
		$templateklinik->setValue('dek_tdk',$checked);
	}else{
		$templateklinik->setValue('dek_ya',$unChecked);
		$templateklinik->setValue('dek_tdk',$unChecked);
	}
	
	if($risiko_pasien_dekubitus['pasien_dekubitus_4'] == '1'){
		$templateklinik->setValue('65_ya',$checked);
		$templateklinik->setValue('65_tdk',$unChecked);
	}else if($risiko_pasien_dekubitus['pasien_dekubitus_4'] == '2'){
		$templateklinik->setValue('65_ya',$unChecked);
		$templateklinik->setValue('65_tdk',$checked);
	}else{
		$templateklinik->setValue('65_ya',$unChecked);
		$templateklinik->setValue('65_tdk',$unChecked);
	}
	
	if($risiko_pasien_dekubitus['pasien_dekubitus_5'] == '1'){
		$templateklinik->setValue('perk_ya',$checked);
		$templateklinik->setValue('perk_tdk',$unChecked);
	}else if($risiko_pasien_dekubitus['pasien_dekubitus_5'] == '2'){
		$templateklinik->setValue('perk_ya',$unChecked);
		$templateklinik->setValue('perk_tdk',$checked);
	}else{
		$templateklinik->setValue('perk_ya',$unChecked);
		$templateklinik->setValue('perk_tdk',$unChecked);
	}
	
	if($status_kehamilan['hamil'] == '1'){
		$templateklinik->setValue('hamil_tdk',$checked);
		$templateklinik->setValue('hamil_ya',$unChecked);
	}else if($status_kehamilan['hamil'] == '2'){
		$templateklinik->setValue('hamil_tdk',$unChecked);
		$templateklinik->setValue('hamil_ya',$checked);
	}else{
		$templateklinik->setValue('hamil_tdk',$unChecked);
		$templateklinik->setValue('hamil_ya',$unChecked);
	}	
	
	$templateklinik->setValue('gravida', htmlspecialchars($status_kehamilan['gravida']));
	$templateklinik->setValue('hpht', htmlspecialchars($status_kehamilan['hpht']));
	$templateklinik->setValue('para', htmlspecialchars($status_kehamilan['para']));
	$templateklinik->setValue('abortus', htmlspecialchars($status_kehamilan['abortus']));
	
	if($pemeriksaan_penunjang['radiologi'] == '1'){
		$templateklinik->setValue('pnj_rad',$checked);
	}else{
		$templateklinik->setValue('pnj_rad',$unChecked);
	}
	
	if($pemeriksaan_penunjang['radiologi_1'] == '1'){
		$templateklinik->setValue('pnj_thr',$checked);
	}else{
		$templateklinik->setValue('pnj_thr',$unChecked);
	}
	
	if($pemeriksaan_penunjang['radiologi_2'] == '1'){
		$templateklinik->setValue('pnj_pel',$checked);
	}else{
		$templateklinik->setValue('pnj_pel',$unChecked);
	}
	
	if($pemeriksaan_penunjang['laboratorium'] == '1'){
		$templateklinik->setValue('pnj_lab',$checked);
	}else{
		$templateklinik->setValue('pnj_lab',$unChecked);
	}
	
	if($pemeriksaan_penunjang['usg'] == '1'){
		$templateklinik->setValue('pnj_usg',$checked);
	}else{
		$templateklinik->setValue('pnj_usg',$unChecked);
	}
	
	if($pemeriksaan_penunjang['ekg'] == '1'){
		$templateklinik->setValue('pnj_ekg',$checked);
	}else{
		$templateklinik->setValue('pnj_ekg',$unChecked);
	}
	
	if($pemeriksaan_penunjang['lain_lain'] == '1'){
		$templateklinik->setValue('pnj_lain',$checked);
	}else{
		$templateklinik->setValue('pnj_lain',$unChecked);
	}
	
	if($diagnosa_keperawatan['diagkep_1'] == '1'){
		$templateklinik->setValue('diag_1',$checked);
	}else{
		$templateklinik->setValue('diag_1',$unChecked);
	}
	
	if($diagnosa_keperawatan['diagkep_2'] == '1'){
		$templateklinik->setValue('diag_2',$checked);
	}else{
		$templateklinik->setValue('diag_2',$unChecked);
	}
	
	if($diagnosa_keperawatan['diagkep_3'] == '1'){
		$templateklinik->setValue('diag_3',$checked);
	}else{
		$templateklinik->setValue('diag_3',$unChecked);
	}
	
	if($diagnosa_keperawatan['diagkep_4'] == '1'){
		$templateklinik->setValue('diag_4',$checked);
	}else{
		$templateklinik->setValue('diag_4',$unChecked);
	}
	
	if($diagnosa_keperawatan['diagkep_5'] == '1'){
		$templateklinik->setValue('diag_5',$checked);
	}else{
		$templateklinik->setValue('diag_5',$unChecked);
	}
	
	if($diagnosa_keperawatan['diagkep_6'] == '1'){
		$templateklinik->setValue('diag_6',$checked);
	}else{
		$templateklinik->setValue('diag_6',$unChecked);
	}
	
	if($diagnosa_keperawatan['diagkep_7'] == '1'){
		$templateklinik->setValue('diag_7',$checked);
	}else{
		$templateklinik->setValue('diag_7',$unChecked);
	}
	
	if($diagnosa_keperawatan['diagkep_8'] == '1'){
		$templateklinik->setValue('diag_8',$checked);
	}else{
		$templateklinik->setValue('diag_8',$unChecked);
	}
	
	if($diagnosa_keperawatan['diagkep_9'] == '1'){
		$templateklinik->setValue('diag_9',$checked);
	}else{
		$templateklinik->setValue('diag_9',$unChecked);
	}
	
	if($diagnosa_keperawatan['diagkep_10'] == '1'){
		$templateklinik->setValue('diag_10',$checked);
	}else{
		$templateklinik->setValue('diag_10',$unChecked);
	}
	
	if($diagnosa_keperawatan['diagkep_11'] == '1'){
		$templateklinik->setValue('diag_11',$checked);
	}else{
		$templateklinik->setValue('diag_11',$unChecked);
	}
	
	if($diagnosa_keperawatan['diagkep_12'] == '1'){
		$templateklinik->setValue('diag_12',$checked);
	}else{
		$templateklinik->setValue('diag_12',$unChecked);
	}
	
	if($diagnosa_keperawatan['diagkep_13'] == '1'){
		$templateklinik->setValue('diag_13',$checked);
	}else{
		$templateklinik->setValue('diag_13',$unChecked);
	}
	
	if($diagnosa_keperawatan['diagkep_14'] == '1'){
		$templateklinik->setValue('diag_14',$checked);
	}else{
		$templateklinik->setValue('diag_14',$unChecked);
	}
	
	if($diagnosa_keperawatan['diagkep_15'] == '1'){
		$templateklinik->setValue('diag_15',$checked);
	}else{
		$templateklinik->setValue('diag_15',$unChecked);
	}
	
	if($diagnosa_keperawatan['diagkep_16'] == '1'){
		$templateklinik->setValue('diag_16',$checked);
	}else{
		$templateklinik->setValue('diag_16',$unChecked);
	}
	
	$templateklinik->setValue('diag_17', htmlspecialchars($diagnosa_keperawatan['diagkep_17']));
	
	$rencana_keperawatan = replace_newline($rencana_keperawatan);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($rencana_keperawatan);
	$templateklinik->setValue('perencanaan_keperawatan', $toOpenXML);
	
	if($intervensi_keperawatan['intkep_1'] == '1'){
		$templateklinik->setValue('int_1',$checked);
	}else{
		$templateklinik->setValue('int_1',$unChecked);
	}
	
	if($intervensi_keperawatan['intkep_2'] == '1'){
		$templateklinik->setValue('int_2',$checked);
	}else{
		$templateklinik->setValue('int_2',$unChecked);
	}
	
	if($intervensi_keperawatan['intkep_3'] == '1'){
		$templateklinik->setValue('int_3',$checked);
	}else{
		$templateklinik->setValue('int_3',$unChecked);
	}
	
	if($intervensi_keperawatan['intkep_4'] == '1'){
		$templateklinik->setValue('int_4',$checked);
	}else{
		$templateklinik->setValue('int_4',$unChecked);
	}
	
	if($intervensi_keperawatan['intkep_5'] == '1'){
		$templateklinik->setValue('int_5',$checked);
	}else{
		$templateklinik->setValue('int_5',$unChecked);
	}
	
	if($intervensi_keperawatan['intkep_6'] == '1'){
		$templateklinik->setValue('int_6',$checked);
	}else{
		$templateklinik->setValue('int_6',$unChecked);
	}
	
	if($intervensi_keperawatan['intkep_7'] == '1'){
		$templateklinik->setValue('int_7',$checked);
	}else{
		$templateklinik->setValue('int_7',$unChecked);
	}
	
	if($intervensi_keperawatan['intkep_8'] == '1'){
		$templateklinik->setValue('int_8',$checked);
	}else{
		$templateklinik->setValue('int_8',$unChecked);
	}
	
	if($intervensi_keperawatan['intkep_9'] == '1'){
		$templateklinik->setValue('int_9',$checked);
	}else{
		$templateklinik->setValue('int_9',$unChecked);
	}
	
	if($intervensi_keperawatan['intkep_10'] == '1'){
		$templateklinik->setValue('int_10',$checked);
	}else{
		$templateklinik->setValue('int_10',$unChecked);
	}
	
	if($intervensi_keperawatan['intkep_11'] == '1'){
		$templateklinik->setValue('int_11',$checked);
	}else{
		$templateklinik->setValue('int_11',$unChecked);
	}
	
	if($intervensi_keperawatan['intkep_12'] == '1'){
		$templateklinik->setValue('int_12',$checked);
	}else{
		$templateklinik->setValue('int_12',$unChecked);
	}
	
	if($intervensi_keperawatan['intkep_13'] == '1'){
		$templateklinik->setValue('int_13',$checked);
	}else{
		$templateklinik->setValue('int_13',$unChecked);
	}
	
	if($intervensi_keperawatan['intkep_14'] == '1'){
		$templateklinik->setValue('int_14',$checked);
	}else{
		$templateklinik->setValue('int_14',$unChecked);
	}
	
	if($intervensi_keperawatan['intkep_15'] == '1'){
		$templateklinik->setValue('int_15',$checked);
	}else{
		$templateklinik->setValue('int_15',$unChecked);
	}
	
	if($intervensi_keperawatan['intkep_16'] == '1'){
		$templateklinik->setValue('int_16',$checked);
	}else{
		$templateklinik->setValue('int_16',$unChecked);
	}
	
	if($intervensi_keperawatan['intkep_1_1'] == '1'){
		$templateklinik->setValue('int_1_ht',$checked);
		$templateklinik->setValue('int_1_jt',$unChecked);
	}else if($intervensi_keperawatan['intkep_1_1'] == '2'){
		$templateklinik->setValue('int_1_ht',$unChecked);
		$templateklinik->setValue('int_1_jt',$checked);	
	}else{
		$templateklinik->setValue('int_1_ht',$unChecked);
		$templateklinik->setValue('int_1_jt',$unChecked);	
	}
	
	$templateklinik->setValue('int_5_jm', htmlspecialchars($intervensi_keperawatan['intkep_5_1']));
	$templateklinik->setValue('int_5_via', htmlspecialchars($intervensi_keperawatan['intkep_5_2']));
	$templateklinik->setValue('int_17', htmlspecialchars($intervensi_keperawatan['intkep_17']));
	
	$arr_impkep_pukul = array();
	$arr_impkep_tindakan = array();
	$arr_impkep_perawat = array();
	$x = 1;
	$y = 1;
	while($x < 14){
		if(trim($implementasi_keperawatan['impkep_pukul_' . $x]) != '' 
				or trim($implementasi_keperawatan['impkep_tindakan_' . $x]) != ''
					or trim($implementasi_keperawatan['impkep_nama_' . $x]) != ''){
					
			$arr_impkep_pukul[$y] = $implementasi_keperawatan['impkep_pukul_' . $x];
			$arr_impkep_tindakan[$y] = $implementasi_keperawatan['impkep_tindakan_' . $x];
			$arr_impkep_perawat[$y] = $implementasi_keperawatan['impkep_nama_' . $x];
			$y++;
		}					
	$x++;
	}
	
	$jml_row = sizeof($arr_impkep_pukul);
	$templateklinik->cloneRow('imp_pukul', $jml_row);
	
	$z = 1;
	while($z <= $jml_row){
		$templateklinik->setValue('imp_pukul#' . $z, htmlspecialchars($arr_impkep_pukul[$z]));
		$templateklinik->setValue('imp_tindakan#' . $z, htmlspecialchars($arr_impkep_tindakan[$z]));
		$templateklinik->setValue('imp_nama#' . $z, htmlspecialchars($arr_impkep_perawat[$z]));
	$z++;
	}	
	
	$arr_imfobat_pukul = array();
	$arr_imfobat_namaobat = array();
	$arr_imfobat_dosis = array();
	$arr_imfobat_rute = array();
	$arr_imfobat_pemeriksa = array();
	$arr_imfobat_pemberi = array();
	$x = 1;
	$y = 1;
	while($x < 14){
		if(trim($infus_obat['infus_obat_pukul_' . $x]) != '' 
				or trim($infus_obat['infus_obat_nama_' . $x]) != ''
					or trim($infus_obat['infus_obat_dosis_' . $x]) != ''
						or trim($infus_obat['infus_obat_rute_' . $x]) != ''
							or trim($infus_obat['infus_obat_periksa_' . $x]) != ''
								or trim($infus_obat['infus_obat_beri_' . $x]) != ''){
					
			$arr_imfobat_pukul[$y] = $infus_obat['infus_obat_pukul_' . $x];
			$arr_imfobat_namaobat[$y] = $infus_obat['infus_obat_nama_' . $x];
			$arr_imfobat_dosis[$y] = $infus_obat['infus_obat_dosis_' . $x];
			$arr_imfobat_rute[$y] = $infus_obat['infus_obat_rute_' . $x];
			$arr_imfobat_pemeriksa[$y] = $infus_obat['infus_obat_periksa_' . $x];
			$arr_imfobat_pemberi[$y] = $infus_obat['infus_obat_beri_' . $x];
			$y++;
		}					
	$x++;
	}
	
	$jml_row = sizeof($arr_imfobat_pukul);
	$templateklinik->cloneRow('pm_pukul', $jml_row);
	
	$z = 1;
	while($z <= $jml_row){
		$templateklinik->setValue('pm_pukul#' . $z, htmlspecialchars($arr_imfobat_pukul[$z]));
		$templateklinik->setValue('pm_nama#' . $z, htmlspecialchars($arr_imfobat_namaobat[$z]));
		$templateklinik->setValue('pm_dosis#' . $z, htmlspecialchars($arr_imfobat_dosis[$z]));
		$templateklinik->setValue('pm_rute#' . $z, htmlspecialchars($arr_imfobat_rute[$z]));
		$templateklinik->setValue('pm_periksa#' . $z, htmlspecialchars($arr_imfobat_pemeriksa[$z]));
		$templateklinik->setValue('pm_beri#' . $z, htmlspecialchars($arr_imfobat_pemberi[$z]));
	$z++;
	}	
	
	$evalkep_subjective = replace_newline($evaluasi_keperawatan['subjective']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($evalkep_subjective);
	$templateklinik->setValue('eva_subjective', $toOpenXML);
	
	$evalkep_objective = replace_newline($evaluasi_keperawatan['objective']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($evalkep_objective);
	$templateklinik->setValue('eva_objective', $toOpenXML);
	
	$evalkep_assesmen = replace_newline($evaluasi_keperawatan['eva_assesment']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($evalkep_assesmen);
	$templateklinik->setValue('eva_assesment', $toOpenXML);
	
	$evalkep_planning = replace_newline($evaluasi_keperawatan['eva_planning']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($evalkep_planning);
	$templateklinik->setValue('eva_planning', $toOpenXML);
	
	$eva_gcs = 'E : ' . $evaluasi_keperawatan['eva_gcs_e'] . ' M : ' . $evaluasi_keperawatan['eva_gcs_m'] . ' V : ' . $evaluasi_keperawatan['eva_gcs_v']; 
	$templateklinik->setValue('eva_gcs', htmlspecialchars($eva_gcs));
	$templateklinik->setValue('eva_spo', htmlspecialchars($evaluasi_keperawatan['eva_spo']));
	$templateklinik->setValue('eva_td', htmlspecialchars($evaluasi_keperawatan['eva_td']));
	
	$eva_ref = $evaluasi_keperawatan['eva_reflex_cahaya_l'] . '/' . $evaluasi_keperawatan['eva_reflex_cahaya_r']; 
	$templateklinik->setValue('eva_reflex_cahaya', htmlspecialchars($eva_ref));
	$templateklinik->setValue('eva_nafas', htmlspecialchars($evaluasi_keperawatan['eva_nafas']));
	$templateklinik->setValue('eva_suhu', htmlspecialchars($evaluasi_keperawatan['eva_suhu']));
	$templateklinik->setValue('eva_nadi', htmlspecialchars($evaluasi_keperawatan['eva_nadi']));
	$templateklinik->setValue('eva_akral', htmlspecialchars($evaluasi_keperawatan['eva_akral']));
	
	if($evaluasi_keperawatan['eva_nadi_reguler'] == '1'){
		$templateklinik->setValue('eva_nadi_reg',$checked);
		$templateklinik->setValue('eva_nadi_irreg',$unChecked);
	}else if($intervensi_keperawatan['intkep_1_1'] == '2'){
		$templateklinik->setValue('eva_nadi_reg',$unChecked);
		$templateklinik->setValue('eva_nadi_irreg',$checked);	
	}else{
		$templateklinik->setValue('eva_nadi_reg',$unChecked);
		$templateklinik->setValue('eva_nadi_irreg',$unChecked);		
	}
	
	if($followup['masuk_rs'] == '1'){
		$templateklinik->setValue('masuk_rs',$checked);
	}else{
		$templateklinik->setValue('masuk_rs',$unChecked);
	}
	
	$templateklinik->setValue('nama_ruang', htmlspecialchars($followup['masuk_ruang']));
	$templateklinik->setValue('petugas_penerima', htmlspecialchars($followup['petugas_penerima']));
	
	if($followup['tindakan_lanjutan'] == '1'){
		$templateklinik->setValue('tindakan_tl',$checked);
	}else{
		$templateklinik->setValue('tindakan_tl',$unChecked);
	}
	
	if($followup['tindakan_lanjutan_ok'] == '1'){
		$templateklinik->setValue('tl_operasi',$checked);
	}else{
		$templateklinik->setValue('tl_operasi',$unChecked);
	}
	
	if($followup['tindakan_lanjutan_opd'] == '1'){
		$templateklinik->setValue('tl_opd',$checked);
	}else{
		$templateklinik->setValue('tl_opd',$unChecked);
	}
	
	if($followup['tindakan_lanjutan_kb'] == '1'){
		$templateklinik->setValue('tl_kb',$checked);
	}else{
		$templateklinik->setValue('tl_kb',$unChecked);
	}
	
	if($followup['tindakan_lanjutan_hd'] == '1'){
		$templateklinik->setValue('tl_hd',$checked);
	}else{
		$templateklinik->setValue('tl_hd',$unChecked);
	}
	
	if($followup['rujuk_ke_rs'] == '1'){
		$templateklinik->setValue('rujuk_rs',$checked);
	}else{
		$templateklinik->setValue('rujuk_rs',$unChecked);
	}
	
	$templateklinik->setValue('nama_rs_rujuk', htmlspecialchars($followup['rujuk_ke_rs_nama']));
	
	if($followup['dipulangkan'] == '1'){
		$templateklinik->setValue('plg',$checked);
	}else{
		$templateklinik->setValue('plg',$unChecked);
	}
	
	$templateklinik->setValue('jam_pulang', htmlspecialchars($followup['dipulangkan_pukul']));
	
	if($followup['meninggal'] == '1'){
		$templateklinik->setValue('mng',$checked);
	}else{
		$templateklinik->setValue('mng',$unChecked);
	}
	
	$templateklinik->setValue('jam_meninggal', htmlspecialchars($followup['meninggal_pukul']));
	
	if($followup['doa'] == '1'){
		$templateklinik->setValue('f_doa',$checked);
	}else{
		$templateklinik->setValue('f_doa',$unChecked);
	}
	
	if($followup['transportasi_pl'] == '1'){
		$templateklinik->setValue('tr_pribadi',$checked);
		$templateklinik->setValue('tr_ambulan',$unChecked);
		$templateklinik->setValue('tr_jenazah',$unChecked);
	}else if($followup['transportasi_pl'] == '2'){
		$templateklinik->setValue('tr_pribadi',$unChecked);
		$templateklinik->setValue('tr_ambulan',$checked);
		$templateklinik->setValue('tr_jenazah',$unChecked);
	}else if($followup['transportasi_pl'] == '3'){
		$templateklinik->setValue('tr_pribadi',$unChecked);
		$templateklinik->setValue('tr_ambulan',$unChecked);
		$templateklinik->setValue('tr_jenazah',$checked);	
	}else{
		$templateklinik->setValue('tr_pribadi',$unChecked);
		$templateklinik->setValue('tr_ambulan',$unChecked);
		$templateklinik->setValue('tr_jenazah',$unChecked);		
	}
	
	if($followup['pendidikan_pl_makan'] == '1'){
		$templateklinik->setValue('pend_makan',$checked);
	}else{
		$templateklinik->setValue('pend_makan',$unChecked);
	}
	
	if($followup['pendidikan_pl_diet'] == '1'){
		$templateklinik->setValue('pend_diet',$checked);
	}else{
		$templateklinik->setValue('pend_diet',$unChecked);
	}
	
	if($followup['pendidikan_pl_bersih'] == '1'){
		$templateklinik->setValue('pend_bersih',$checked);
	}else{
		$templateklinik->setValue('pend_bersih',$unChecked);
	}
	
	if($followup['pendidikan_pl_lain'] == '1'){
		$templateklinik->setValue('pend_lain',$checked);
	}else{
		$templateklinik->setValue('pend_lain',$unChecked);
	}
	
	$templateklinik->setValue('pend_lain_ket', htmlspecialchars($followup['pendidikan_pl_lain_ket']));
	
	if($followup['followup_ya'] == '1'){
		$templateklinik->setValue('fu_ya',$checked);
		$templateklinik->setValue('fu_tdk',$unChecked);
	}else if($followup['followup_ya'] == '2'){
		$templateklinik->setValue('fu_ya',$unChecked);
		$templateklinik->setValue('fu_tdk',$checked);	
	}else{
		$templateklinik->setValue('fu_ya',$unChecked);
		$templateklinik->setValue('fu_tdk',$unChecked);	
	}
	
	$templateklinik->setValue('tanggal_fu', htmlspecialchars($followup['followup_tgl']));
	$templateklinik->setValue('nama_poli', htmlspecialchars($followup['poliklinik']));
	
	$hasilfu = replace_newline($followup['followup_hsl']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($hasilfu);
	$templateklinik->setValue('hasil_fu', $toOpenXML);
	
	$templateklinik->setValue('jam_selesai', htmlspecialchars($jam_selesai . ':' . $menit_selesai));
	$templateklinik->setValue('nama_perawat', htmlspecialchars($nama_perawat));
	
	if(!file_exists($rmfile_path . '/pdf/1/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/pdf/1/' . $nomr . '/' . $idx, 0700, true);
	}

	if(!file_exists($rmfile_path . '/doc/1/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/doc/1/' . $nomr . '/' . $idx, 0700, true);
	}
	
	$nama_file = $nomr . '_' . $idx . '_41';	
	
	/*
	if($final == '1' and $ls_assesment != $tgl_skr){
		$qry_rev = 'SELECT COUNT(FILE_ID) + 1 AS REV FROM t_rm_dokumen_file
			WHERE RAWAT_ID = "' . $idx . '"
			AND JNS_PERAWATAN = "1"
			AND JENIS_DOKUMEN_ID = "41"';
		$get_rev = mysql_query($qry_rev) or die(mysql_error());
		$dat_rev = mysql_fetch_assoc($get_rev);
		$nama_file .= '_' . $dat_rev['REV'];	
	}
	*/
	
	$templateklinik->saveAs($rmfile_path . '/doc/1/' . $nomr . '/' . $idx . '/' . $nama_file . '.docx');
	
	mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE RAWAT_ID = "' . $idx . '"
				AND JNS_PERAWATAN = "1"
				AND JENIS_DOKUMEN_ID = "41"
				AND NAMA_FILE = "' . $nama_file . '.pdf"') or die(mysql_error());
	mysql_query('INSERT INTO t_rm_dokumen_file(JENIS_DOKUMEN_ID,NOMR,RAWAT_ID,JNS_PERAWATAN,NAMA_FILE,ST_SISTEM,TANGGAL) 		
				VALUES("41","' . $nomr . '","' . $idx . '","1","' . $nama_file . '.pdf","1",STR_TO_DATE("' . $tgl_daftar . '","%d/%m/%Y"))') or die(mysql_error());
	
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