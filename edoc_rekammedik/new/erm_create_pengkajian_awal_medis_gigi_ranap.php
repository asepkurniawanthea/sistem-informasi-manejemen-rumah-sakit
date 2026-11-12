<?php
function erm_pengkajian_awal_medis_gigi_ranap($idx,$ls_assesment,$tgl_skr,$final){
	global $rmfile_path, $app_path;

	$checked = '<w:sym w:font="Wingdings" w:char="F0FE"/>';
    $unChecked = '<w:sym w:font="Wingdings" w:char="F0A8"/>';
	
	$templateklinik = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\pengkajian_awal_medis_gigi.docx');
	
	$qry_pasien = 'SELECT t_irna.IRNA_ID,t_irna.NOMR,t_irna.PEGAWAI_ID,m_pegawai.NAMA_PEGAWAI,
				t_irna.ruang_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,
				m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
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

	$irna_id = $dat_pasien['IRNA_ID'];
	$pegawai_id = $dat_pasien['PEGAWAI_ID'];
	$pasien_masuk = $dat_pasien['PASIEN_MASUK'];

	$no_telepon = $dat_pasien['NO_TELEPON'];
	$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];
	$nama_unit = $dat_pasien['NAMA_RUANG'];
	$nama_dokter = $dat_pasien['NAMA_PEGAWAI'];

	$umur = getUmurDaftar($tgl_lahir,$tgl_daftar);
	
	$qry_pengkajian = 'SELECT IRNA_ID,ANAMNESIS_KELUHAN_UTAMA,ANAMNESIS_RIWAYAT_PENYAKIT_SEKARANG,
			ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU,ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA,PEMERIKSAAN,ODONTOGRAM,
			ODONTOGRAM_GBR,PEMERIKSAAN_GIGI,RENCANA_TERAPI,TERAPI,TERAPI_NON_FARMAKA,
			SIGNATUR,DATE_FORMAT(TGL_ASSESMENT,"%d-%m-%Y %H:%i") AS TGL_ASSESMENT,
			REGISTER
			FROM t_irna_pengkajian_awal_medis_gigi
			WHERE IRNA_ID = "' . $idx . '"';
	$get_pengkajian = mysql_query($qry_pengkajian) or die(mysql_error());
	$dat_pengkajian = mysql_fetch_assoc($get_pengkajian);
	$idx = $dat_pengkajian['IRNA_ID'];
	$anamnesis_keluhan_utama = $dat_pengkajian['ANAMNESIS_KELUHAN_UTAMA'];
	$anamnesis_riwayat_penyakit_sekarang = $dat_pengkajian['ANAMNESIS_RIWAYAT_PENYAKIT_SEKARANG'];
	$anamnesis_riwayat_penyakit_dahulu = $dat_pengkajian['ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU'];
	$anamnesis_riwayat_penyakit_keluarga = $dat_pengkajian['ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA'];
	$pemeriksaan_fisik = str_replace('|','"',$dat_pengkajian['PEMERIKSAAN']);
	$pemeriksaan_fisik = preg_replace('/\r|\n/','\n',trim($pemeriksaan_fisik));
	$pemeriksaan_fisik = json_decode($pemeriksaan_fisik,true);
	
	$odontogram = str_replace('|','"',$dat_pengkajian['ODONTOGRAM']);
	$odontogram = preg_replace('/\r|\n/','\n',trim($odontogram));
	$odontogram = json_decode($odontogram,true);
	
	$pemeriksaan_gigi = str_replace('|','"',$dat_pengkajian['PEMERIKSAAN_GIGI']);
	$pemeriksaan_gigi = preg_replace('/\r|\n/','\n',trim($pemeriksaan_gigi));
	$pemeriksaan_gigi = json_decode($pemeriksaan_gigi,true);
	$rencana_tatalaksana = $dat_pengkajian['RENCANA_TERAPI'];
	$terapi = $dat_pengkajian['TERAPI'];
	$terapi_non_farmaka = $dat_pengkajian['TERAPI_NON_FARMAKA'];
	$tgl_assesment = $dat_pengkajian['TGL_ASSESMENT'];
	
	$qry_diagnosa = 'SELECT DIAGNOSA_ORDER,DIAGNOSA
		FROM t_irna_diagnosa
		WHERE IRNA_ID = "' . $idx . '"
		ORDER BY DIAGNOSA_ORDER';
	$get_diagnosa = mysql_query($qry_diagnosa) or die(mysql_error());
	$dat_diagnosa= mysql_fetch_assoc($get_diagnosa);
	$diagnosa = $dat_diagnosa['DIAGNOSA'];	
	
	$qry_alergi = 'SELECT ALERGI FROM t_irna_alergi WHERE IRNA_ID = "' . $idx . '"';
	$get_alergi = mysql_query($qry_alergi) or die(mysql_error());	
	$dat_alergi = mysql_fetch_assoc($get_alergi);
	$anamnesis_alergi = $dat_alergi['ALERGI'];
	
	$templateklinik->setValue('nomor_rm', formatNomr($nomr));
	$templateklinik->setValue('nama_pasien', htmlspecialchars($nama_pasien));
	$templateklinik->setValue('tgl_lahir', htmlspecialchars($tgl_lahir));
	$templateklinik->setValue('jenis_kelamin', htmlspecialchars($jns_kelamin));
	$templateklinik->setValue('unit', htmlspecialchars($nama_unit));
	$templateklinik->setValue('tgl_masuk', $pasien_masuk);
	$templateklinik->setValue('tgl_assesment', $tgl_assesment);
	$templateklinik->setValue('nama_dokter', htmlspecialchars($nama_dokter));
	$templateklinik->setValue('dicetak_oleh', '');
	
	$anamnesis_keluhan_utama = replace_newline($anamnesis_keluhan_utama);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($anamnesis_keluhan_utama);
	$templateklinik->setValue('keluhan_utama',$toOpenXML);
	
	$anamnesis_riwayat_penyakit_sekarang = replace_newline($anamnesis_riwayat_penyakit_sekarang);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($anamnesis_riwayat_penyakit_sekarang);
	$templateklinik->setValue('riwayat_penyakit_sekarang',$toOpenXML);
	
	$anamnesis_riwayat_penyakit_dahulu = replace_newline($anamnesis_riwayat_penyakit_dahulu);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($anamnesis_riwayat_penyakit_dahulu);
	$templateklinik->setValue('riwayat_penyakit_dahulu', $toOpenXML);
	
	$anamnesis_riwayat_penyakit_keluarga = replace_newline($anamnesis_riwayat_penyakit_keluarga);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($anamnesis_riwayat_penyakit_keluarga);
	$templateklinik->setValue('riwayat_penyakit_keluarga',$toOpenXML);
	
	$anamnesis_alergi = replace_newline($anamnesis_alergi);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($anamnesis_alergi);
	$templateklinik->setValue('alergi', $toOpenXML);
	
	$templateklinik->setValue('keadaan_umum', htmlspecialchars($pemeriksaan_fisik['pm_keadaan_umum']));
	$templateklinik->setValue('td', htmlspecialchars($pemeriksaan_fisik['pm_td']));
	$templateklinik->setValue('gcs', htmlspecialchars('E ' . $pemeriksaan_fisik['pm_gcs_e'] . ' M ' . $pemeriksaan_fisik['pm_gcs_m'] . ' V ' . $pemeriksaan_fisik['pm_gcs_v']));
	$templateklinik->setValue('nadi', htmlspecialchars($pemeriksaan_fisik['pm_nadi']));
	$templateklinik->setValue('suhu', htmlspecialchars($pemeriksaan_fisik['pm_suhu']));
	if($pemeriksaan_fisik['pm_nadi_teratur'] == '') {
		$templateklinik->setValue('nadi_teratur',$unChecked);
		$templateklinik->setValue('nadi_tdk_teratur',$unChecked);
	}	
	if($pemeriksaan_fisik['pm_nadi_teratur'] == '1') {
		$templateklinik->setValue('nadi_teratur',$checked);
		$templateklinik->setValue('nadi_tdk_teratur',$unChecked);
		/*$templateklinik->setValue('nadi_teratur','<w:r w:rsidRPr="00B56C8B"><w:t>Teratur</w:t></w:r><w:r><w:t>/</w:t></w:r><w:bookmarkStart w:id="0" w:name="_GoBack"/><w:r w:rsidRPr="00B56C8B"><w:rPr><w:strike/></w:rPr><w:t>Tidak Teratur</w:t></w:r>');*/
	}
	if($pemeriksaan_fisik['pm_nadi_teratur'] == '2') {
		/*$templateklinik->setValue('nadi_teratur','<w:r w:rsidRPr="00F832B4"><w:rPr><w:strike/></w:rPr><w:t>Teratur</w:t></w:r><w:bookmarkEnd w:id="0"/><w:proofErr w:type="spellEnd"/><w:r><w:t>/</w:t></w:r><w:proofErr w:type="spellStart"/><w:r><w:t>Tidak</w:t></w:r><w:proofErr w:type="spellEnd"/><w:r><w:t xml:space="preserve"> </w:t></w:r><w:proofErr w:type="spellStart"/><w:r><w:t>Teratur</w:t></w:r>');*/
		$templateklinik->setValue('nadi_teratur',$unChecked);
		$templateklinik->setValue('nadi_tdk_teratur',$checked);
	}
	$templateklinik->setValue('tb', htmlspecialchars($pemeriksaan_fisik['pm_tb']));
	$templateklinik->setValue('bb', htmlspecialchars($pemeriksaan_fisik['pm_bb']));
	$templateklinik->setValue('rr', htmlspecialchars($pemeriksaan_fisik['pm_rr']));
	
	$templateklinik->setValue('p_18', htmlspecialchars($odontogram['p_18']));
	$templateklinik->setValue('p_17', htmlspecialchars($odontogram['p_17']));
	$templateklinik->setValue('p_16', htmlspecialchars($odontogram['p_16']));
	
	$templateklinik->setValue('p_15', htmlspecialchars($odontogram['p_15']));
	$templateklinik->setValue('p_14', htmlspecialchars($odontogram['p_14']));
	$templateklinik->setValue('p_13', htmlspecialchars($odontogram['p_13']));
	$templateklinik->setValue('p_12', htmlspecialchars($odontogram['p_12']));
	$templateklinik->setValue('p_11', htmlspecialchars($odontogram['p_11']));
	
	$templateklinik->setValue('p_41', htmlspecialchars($odontogram['p_41']));
	$templateklinik->setValue('p_42', htmlspecialchars($odontogram['p_42']));
	$templateklinik->setValue('p_43', htmlspecialchars($odontogram['p_43']));
	$templateklinik->setValue('p_44', htmlspecialchars($odontogram['p_44']));
	$templateklinik->setValue('p_45', htmlspecialchars($odontogram['p_45']));
	
	$templateklinik->setValue('p_46', htmlspecialchars($odontogram['p_46']));
	$templateklinik->setValue('p_47', htmlspecialchars($odontogram['p_47']));
	$templateklinik->setValue('p_48', htmlspecialchars($odontogram['p_48']));
	
	$templateklinik->setValue('p_28', htmlspecialchars($odontogram['p_28']));
	$templateklinik->setValue('p_27', htmlspecialchars($odontogram['p_27']));
	$templateklinik->setValue('p_26', htmlspecialchars($odontogram['p_26']));
	
	$templateklinik->setValue('p_25', htmlspecialchars($odontogram['p_25']));
	$templateklinik->setValue('p_24', htmlspecialchars($odontogram['p_24']));
	$templateklinik->setValue('p_23', htmlspecialchars($odontogram['p_23']));
	$templateklinik->setValue('p_22', htmlspecialchars($odontogram['p_22']));
	$templateklinik->setValue('p_21', htmlspecialchars($odontogram['p_21']));
	
	$templateklinik->setValue('p_31', htmlspecialchars($odontogram['p_31']));
	$templateklinik->setValue('p_32', htmlspecialchars($odontogram['p_32']));
	$templateklinik->setValue('p_33', htmlspecialchars($odontogram['p_33']));
	$templateklinik->setValue('p_34', htmlspecialchars($odontogram['p_34']));
	$templateklinik->setValue('p_35', htmlspecialchars($odontogram['p_35']));
	
	$templateklinik->setValue('p_36', htmlspecialchars($odontogram['p_36']));
	$templateklinik->setValue('p_37', htmlspecialchars($odontogram['p_37']));
	$templateklinik->setValue('p_38', htmlspecialchars($odontogram['p_38']));
	
	$gambar_path = $app_path . 'nsimrs\\edoc_rekammedik\\new\\pemeriksaan_gigi.jpg';
	if(file_exists($rmfile_path . '\\\pemeriksaan_gigi\\'. $nomr . '_2_odontogram_' . $idx . '.jpg')){
		$gambar_path = $rmfile_path . '\\\pemeriksaan_gigi\\'. $nomr . '_2_odontogram_' . $idx . '.jpg';
	}
	$templateklinik->setImageValue('gbr', array('path' => $gambar_path, 'width' => 400, 'height' => 400, 'ratio' => true));
	
	if($pemeriksaan_gigi['normal_bite'] == '1') {
		$templateklinik->setValue('oc_norm',$checked);
	}else{
		$templateklinik->setValue('oc_norm',$unChecked);
	}
	if($pemeriksaan_gigi['cross_bite'] == '1') {
		$templateklinik->setValue('oc_cros',$checked);
	}else{
		$templateklinik->setValue('oc_cros',$unChecked);
	}
	if($pemeriksaan_gigi['steep_bite'] == '1') {
		$templateklinik->setValue('oc_steep',$checked);
	}else{
		$templateklinik->setValue('oc_steep',$unChecked);
	}
	
	if($pemeriksaan_gigi['torus_tidak'] == '1') {
		$templateklinik->setValue('tor_tdk',$checked);
	}else{
		$templateklinik->setValue('tor_tdk',$unChecked);
	}
	if($pemeriksaan_gigi['torus_kecil'] == '1') {
		$templateklinik->setValue('tor_kcl',$checked);
	}else{
		$templateklinik->setValue('tor_kcl',$unChecked);
	}
	if($pemeriksaan_gigi['torus_sedang'] == '1') {
		$templateklinik->setValue('tor_sdg',$checked);
	}else{
		$templateklinik->setValue('tor_sdg',$unChecked);
	}
	if($pemeriksaan_gigi['torus_besar'] == '1') {
		$templateklinik->setValue('tor_bsr',$checked);
	}else{
		$templateklinik->setValue('tor_bsr',$unChecked);
	}
	if($pemeriksaan_gigi['torus_multiple'] == '1') {
		$templateklinik->setValue('tor_mtp',$checked);
	}else{
		$templateklinik->setValue('tor_mtp',$unChecked);
	}
	
	if($pemeriksaan_gigi['mandibularis_tidak'] == '1') {
		$templateklinik->setValue('man_tdk',$checked);
	}else{
		$templateklinik->setValue('man_tdk',$unChecked);
	}
	if($pemeriksaan_gigi['mandibularis_sisikiri'] == '1') {
		$templateklinik->setValue('man_kr',$checked);
	}else{
		$templateklinik->setValue('man_kr',$unChecked);
	}
	if($pemeriksaan_gigi['mandibularis_sisikanan'] == '1') {
		$templateklinik->setValue('man_kn',$checked);
	}else{
		$templateklinik->setValue('man_kn',$unChecked);
	}
	if($pemeriksaan_gigi['mandibularis_duasisi'] == '1') {
		$templateklinik->setValue('man_kd',$checked);
	}else{
		$templateklinik->setValue('man_kd',$unChecked);
	}
	
	if($pemeriksaan_gigi['palatum_dalam'] == '1') {
		$templateklinik->setValue('pl_dlm',$checked);
	}else{
		$templateklinik->setValue('pl_dlm',$unChecked);
	}
	if($pemeriksaan_gigi['palatum_sedang'] == '1') {
		$templateklinik->setValue('pl_sdg',$checked);
	}else{
		$templateklinik->setValue('pl_sdg',$unChecked);
	}
	if($pemeriksaan_gigi['palatum_rendah'] == '1') {
		$templateklinik->setValue('pl_rdh',$checked);
	}else{
		$templateklinik->setValue('pl_rdh',$unChecked);
	}
	
	if($pemeriksaan_gigi['spnt_tdk'] == '1') {
		$templateklinik->setValue('st_tidak',$checked);
	}else{
		$templateklinik->setValue('st_tidak',$unChecked);
	}
	if($pemeriksaan_gigi['spnt_ada'] == '1') {
		$templateklinik->setValue('st_ada',$checked);
	}else{
		$templateklinik->setValue('st_ada',$unChecked);
	}
	$templateklinik->setValue('st_ket',htmlspecialchars($pemeriksaan_gigi['spnt_ket']));
	
	if($pemeriksaan_gigi['diastema_tdk'] == '1') {
		$templateklinik->setValue('di_tidak',$checked);
	}else{
		$templateklinik->setValue('di_tidak',$unChecked);
	}
	if($pemeriksaan_gigi['diastema_ada'] == '1') {
		$templateklinik->setValue('di_ada',$checked);
	}else{
		$templateklinik->setValue('di_ada',$unChecked);
	}
	$templateklinik->setValue('di_ket',htmlspecialchars($pemeriksaan_gigi['diastema_ket']));
	
	if($pemeriksaan_gigi['anomali_tdk'] == '1') {
		$templateklinik->setValue('gg_tidak',$checked);
	}else{
		$templateklinik->setValue('gg_tidak',$unChecked);
	}
	if($pemeriksaan_gigi['anomali_ada'] == '1') {
		$templateklinik->setValue('gg_ada',$checked);
	}else{
		$templateklinik->setValue('gg_ada',$unChecked);
	}
	$templateklinik->setValue('gg_ket',htmlspecialchars($pemeriksaan_gigi['anomali_ket']));
	$templateklinik->setValue('pem_lain',htmlspecialchars($pemeriksaan_gigi['lainlain']));
	
	$diagnosa = replace_newline($diagnosa);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($diagnosa);
	$templateklinik->setValue('diagnosis',$toOpenXML);
	
	$rencana_tatalaksana = replace_newline($rencana_tatalaksana);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($rencana_tatalaksana);
	$templateklinik->setValue('rencana_tatalaksana',$toOpenXML);
	
	$terapi = replace_newline($terapi);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($terapi);
	$templateklinik->setValue('terapi',$toOpenXML);
	
	$terapi_non_farmaka = replace_newline($terapi_non_farmaka);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($terapi_non_farmaka);
	$templateklinik->setValue('terapi_non_farmaka',$toOpenXML);
	
	if(!file_exists($rmfile_path . '/pdf/2/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/pdf/2/' . $nomr . '/' . $idx, 0700, true);
	}

	if(!file_exists($rmfile_path . '/doc/2/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/doc/2/' . $nomr . '/' . $idx, 0700, true);
	}
	
	$nama_file = $nomr . '_' . $idx . '_24';	
	/*
	if($final == '1' and $ls_assesment != $tgl_skr){
		$qry_rev = 'SELECT COUNT(FILE_ID) + 1 AS REV FROM t_rm_dokumen_file
			WHERE RAWAT_ID = "' . $idx . '"
			AND JNS_PERAWATAN = "2"
			AND JENIS_DOKUMEN_ID = "24"';
		$get_rev = mysql_query($qry_rev) or die(mysql_error());
		$dat_rev = mysql_fetch_assoc($get_rev);
		$nama_file .= '_' . $dat_rev['REV'];	
	}
	*/
	$templateklinik->saveAs($rmfile_path . '/doc/2/' . $nomr . '/' . $idx . '/' . $nama_file . '.docx');
	
	mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE RAWAT_ID = "' . $idx . '"
				AND JNS_PERAWATAN = "2"
				AND JENIS_DOKUMEN_ID = "24"
				AND NAMA_FILE = "' . $nama_file . '.pdf"') or die(mysql_error());
	mysql_query('INSERT INTO t_rm_dokumen_file(JENIS_DOKUMEN_ID,NOMR,RAWAT_ID,JNS_PERAWATAN,NAMA_FILE,ST_SISTEM,TANGGAL) 		
				VALUES("24","' . $nomr . '","' . $idx . '","2","' . $nama_file . '.pdf","1",STR_TO_DATE("' . $tgl_daftar . '","%d/%m/%Y"))') or die(mysql_error());
	
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