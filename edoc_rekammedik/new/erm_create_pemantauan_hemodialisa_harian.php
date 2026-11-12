<?php
function replace_newline($str){
	$ret = preg_replace('/\r|\n/','\n',trim($str));
	$ret = str_replace('\n','<br>',$ret);
	$ret = str_replace('<br><br>','<br>',$ret);
	return $ret;
}

function erm_pemantauan_hemodialisa_harian($idx,$jns_order,$idxord){
	global $rmfile_path, $app_path;

	$checked = '<w:sym w:font="Wingdings" w:char="F0FE"/>';
    $unChecked = '<w:sym w:font="Wingdings" w:char="F0A8"/>';
	
	$jns_perawatan = '1';
	if($jns_order == 'IRN') $jns_perawatan = '2'; 
	
	$templateklinik = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\pemantauan_hemodialisa_harian.docx');
	
	if($jns_order == ''){
		$qry_pasien = 'SELECT t_irja.IRJA_ID,t_irja.NOMR,t_irja.PEGAWAI_ID,m_pegawai.NAMA_PEGAWAI,
				t_irja.ASAL_PASIEN_ID,t_irja.KET_ASAL_PASIEN,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,m_pasien.JNS_KELAMIN,
				m_pasien.ALAMAT,m_pasien.NIK,
				DATE_FORMAT(t_irja.PASIEN_MASUK,"%d-%m-%Y %H:%i") AS PASIEN_MASUK,t_irja.JENIS_BAYAR_ID,
				m_pasien.NO_TELEPON,
				DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR
				FROM t_irja
				INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				LEFT JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_irja.IRJA_ID = "' . $idx . '"';
	}else{
		$qry_pasien = 'SELECT t_hemodialisa.HEMODIALISA_ID AS IRJA_ID,t_hemodialisa.NOMR,
				t_hemodialisa.PEGAWAI_PERIKSA_ID AS PEGAWAI_ID,m_pegawai.NAMA_PEGAWAI,
				"" AS ASAL_PASIEN_ID,"" AS KET_ASAL_PASIEN,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,m_pasien.JNS_KELAMIN,
				m_pasien.ALAMAT,m_pasien.NIK,
				DATE_FORMAT(t_hemodialisa.PASIEN_MASUK,"%d-%m-%Y %H:%i") AS PASIEN_MASUK,t_hemodialisa.JENIS_BAYAR_ID,
				m_pasien.NO_TELEPON,
				DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_DAFTAR
				FROM t_hemodialisa
				INNER JOIN m_pasien ON (t_hemodialisa.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_hemodialisa.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_pegawai ON (t_hemodialisa.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_hemodialisa.HEMODIALISA_ID = "' . $idx . '"';
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
	$nama_dokter = $dat_pasien['NAMA_PEGAWAI'];

	$umur = getUmurDaftar($tgl_lahir,$tgl_daftar);
	
	if($jns_order == ''){
		$qry_pemantauan = 'SELECT IRJA_ID AS HEMODIALISA_ID,GELANG_PASIEN,AKSES_VASKULAR,
			MESIN_HEMODIALISIS,DIALISAT,DIALISER,BB_KERING,RESEP_HD,ALERGI,
			DATE_FORMAT(TGL_ASSESMENT,"%d/%m/%Y") AS TGL_ASSESMENT
			FROM t_irja_pemantauan_hemodialisis
			WHERE IRJA_ID = "' . $idx . '"';		
	}else{
		$qry_pemantauan = 'SELECT HEMODIALISA_ID,GELANG_PASIEN,AKSES_VASKULAR,
			MESIN_HEMODIALISIS,DIALISAT,DIALISER,BB_KERING,RESEP_HD,ALERGI,
			DATE_FORMAT(TGL_ASSESMENT,"%d/%m/%Y") AS TGL_ASSESMENT
			FROM t_hemodialisa_pemantauan_hemodialisis
			WHERE HEMODIALISA_ID = "' . $idx . '"';			
	}	
	
	$get_pemantauan = mysql_query($qry_pemantauan) or die(mysql_error());
	$dat_pemantauan = mysql_fetch_assoc($get_pemantauan);
	$gelang_pasien = str_replace('|','"',$dat_pemantauan['GELANG_PASIEN']);
	$gelang_pasien = preg_replace('/\r|\n/','\n',trim($gelang_pasien));
	$gelang_pasien = json_decode($gelang_pasien,true);
	$alergi = str_replace('|','"',$dat_pemantauan['ALERGI']);
	$alergi = preg_replace('/\r|\n/','\n',trim($alergi));
	$alergi = json_decode($alergi,true);
	$akses_vaskular = str_replace('|','"',$dat_pemantauan['AKSES_VASKULAR']);
	$akses_vaskular = preg_replace('/\r|\n/','\n',trim($akses_vaskular));
	$akses_vaskular = json_decode($akses_vaskular,true);
	$mesin_hemodialisis = str_replace('|','"',$dat_pemantauan['MESIN_HEMODIALISIS']);
	$mesin_hemodialisis = preg_replace('/\r|\n/','\n',trim($mesin_hemodialisis));
	$mesin_hemodialisis = json_decode($mesin_hemodialisis,true);
	$dialisat = str_replace('|','"',$dat_pemantauan['DIALISAT']);
	$dialisat = preg_replace('/\r|\n/','\n',trim($dialisat));
	$dialisat = json_decode($dialisat,true);
	$dialiser = str_replace('|','"',$dat_pemantauan['DIALISER']);
	$dialiser = preg_replace('/\r|\n/','\n',trim($dialiser));
	$dialiser = json_decode($dialiser,true);
	$bb_kering = str_replace('|','"',$dat_pemantauan['BB_KERING']);
	$bb_kering = preg_replace('/\r|\n/','\n',trim($bb_kering));
	$bb_kering = json_decode($bb_kering,true);
	$resep_hd = str_replace('|','"',$dat_pemantauan['RESEP_HD']);
	$resep_hd = preg_replace('/\r|\n/','\n',trim($resep_hd));
	$resep_hd = json_decode($resep_hd,true);
	$tgl_assesment = $dat_pemantauan['TGL_ASSESMENT'];
	
	$templateklinik->setValue('nomor_rm', formatNomr($nomr));
	$templateklinik->setValue('nama_pasien', htmlspecialchars($nama_pasien));
	$templateklinik->setValue('tgl_lahir', htmlspecialchars($tgl_lahir));
	$templateklinik->setValue('jenis_kelamin', htmlspecialchars($jns_kelamin));
	$templateklinik->setValue('tgl_masuk', $pasien_masuk);
	$templateklinik->setValue('tgl_assesment', $tgl_assesment);
	$templateklinik->setValue('nama_dokter', htmlspecialchars($nama_dokter));
	$templateklinik->setValue('dicetak_oleh', '');

	
	if($gelang_pasien['terpasang']=='1'){
		$templateklinik->setValue('gelang_terpasang',$checked);
		$templateklinik->setValue('gelang_blm_terpasang',$unChecked);
	}else if($gelang_pasien['terpasang']=='2'){
		$templateklinik->setValue('gelang_terpasang',$unChecked);
		$templateklinik->setValue('gelang_blm_terpasang',$checked);
	}else{
		$templateklinik->setValue('gelang_terpasang',$unChecked);
		$templateklinik->setValue('gelang_blm_terpasang',$unChecked);
	}	
	
	//$keterangan_gelang = replace_newline(trim($gelang_pasien['gelang_pasien_ket']));
	//$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($keterangan_gelang);
	$templateklinik->setValue('gelang_ket', htmlspecialchars($gelang_pasien['gelang_pasien_ket']));
	
	if($alergi['ada_alergi']=='1'){
		$templateklinik->setValue('ada_alergi',$checked);
		$templateklinik->setValue('tidak_alergi',$unChecked);
	}else if($alergi['ada_alergi']=='2'){
		$templateklinik->setValue('ada_alergi',$unChecked);
		$templateklinik->setValue('tidak_alergi',$checked);
	}else{
		$templateklinik->setValue('ada_alergi',$unChecked);
		$templateklinik->setValue('tidak_alergi',$unChecked);
	}
	
	//$keterangan_alergi = replace_newline($alergi['alergi_ket']);
	//$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($keterangan_alergi);
	$templateklinik->setValue('alergi_ket', htmlspecialchars($alergi['alergi_ket']));
	
	if($alergi['gelang_alergi']=='1'){
		$templateklinik->setValue('ada_gelang_alergi',$checked);
		$templateklinik->setValue('tidak_gelang_alergi',$unChecked);
	}else if($alergi['gelang_alergi']=='2'){
		$templateklinik->setValue('ada_gelang_alergi',$unChecked);
		$templateklinik->setValue('tidak_gelang_alergi',$checked);
	}else{
		$templateklinik->setValue('ada_gelang_alergi',$unChecked);
		$templateklinik->setValue('tidak_gelang_alergi',$unChecked);
	}
	
	//$keterangan_gelang_alergi = replace_newline($alergi['gelang_alergi_ket']);
	//$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($keterangan_gelang_alergi);
	$templateklinik->setValue('gelang_alergi_ket', htmlspecialchars($alergi['gelang_alergi_ket']));
	
	if($akses_vaskular['cimino']=='1'){
		$templateklinik->setValue('cimino',$checked);
	}else{
		$templateklinik->setValue('cimino',$unChecked);
	}
	
	if($akses_vaskular['femoral']=='1'){
		$templateklinik->setValue('femoral',$checked);
	}else{
		$templateklinik->setValue('femoral',$unChecked);
	}
	
	if($akses_vaskular['double']=='1'){
		$templateklinik->setValue('double',$checked);
	}else{
		$templateklinik->setValue('double',$unChecked);
	}
	
	if($akses_vaskular['lain']=='1'){
		$templateklinik->setValue('vaskular_lain',$checked);
	}else{
		$templateklinik->setValue('vaskular_lain',$unChecked);
	}
	
	//$keterangan_vaskular = replace_newline($akses_vaskular['ket']);
	//$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($keterangan_vaskular);
	$templateklinik->setValue('vaskular_ket', htmlspecialchars($akses_vaskular['ket']));
	
	//$lokasi = replace_newline($akses_vaskular['lokasi']);
	//$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($lokasi);
	$templateklinik->setValue('lokasi', htmlspecialchars($akses_vaskular['lokasi']));
	
	if($akses_vaskular['tanda_infeksi']=='1'){
		$templateklinik->setValue('tanda_infeksi_ya',$checked);
		$templateklinik->setValue('tanda_infeksi_tidak',$unChecked);
	}else if($akses_vaskular['tanda_infeksi']=='2'){
		$templateklinik->setValue('tanda_infeksi_ya',$unChecked);
		$templateklinik->setValue('tanda_infeksi_tidak',$checked);
	}else{
		$templateklinik->setValue('tanda_infeksi_ya',$unChecked);
		$templateklinik->setValue('tanda_infeksi_tidak',$unChecked);
	}
	
	if($akses_vaskular['aneurisma']=='1'){
		$templateklinik->setValue('aneurisma_ya',$checked);
		$templateklinik->setValue('aneurisma_tidak',$unChecked);
	}else if($akses_vaskular['aneurisma']=='2'){
		$templateklinik->setValue('aneurisma_ya',$unChecked);
		$templateklinik->setValue('aneurisma_tidak',$checked);
	}else{
		$templateklinik->setValue('aneurisma_ya',$unChecked);
		$templateklinik->setValue('aneurisma_tidak',$unChecked);
	}
	
	if($akses_vaskular['thrill']=='1'){
		$templateklinik->setValue('thrill_ya',$checked);
		$templateklinik->setValue('thrill_tidak',$unChecked);
	}else if($akses_vaskular['thrill']=='2'){
		$templateklinik->setValue('thrill_ya',$unChecked);
		$templateklinik->setValue('thrill_tidak',$checked);
	}else{
		$templateklinik->setValue('thrill_ya',$unChecked);
		$templateklinik->setValue('thrill_tidak',$unChecked);
	}
	
	if($akses_vaskular['bruit']=='1'){
		$templateklinik->setValue('bruit_ya',$checked);
		$templateklinik->setValue('bruit_tidak',$unChecked);
	}else if($akses_vaskular['bruit']=='2'){
		$templateklinik->setValue('bruit_ya',$unChecked);
		$templateklinik->setValue('bruit_tidak',$checked);
	}else{
		$templateklinik->setValue('bruit_ya',$unChecked);
		$templateklinik->setValue('bruit_tidak',$unChecked);
	}
	
	//$vaskular_kondisi_lain = replace_newline($akses_vaskular['lain_ket']);
	//$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($vaskular_kondisi_lain);
	$templateklinik->setValue('vaskular_kondisi_lain', htmlspecialchars($akses_vaskular['lain_ket']));
	
	//$uklumen_arteri = replace_newline($akses_vaskular['lumen_arteri']);
	//$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($uklumen_arteri);
	$templateklinik->setValue('uklumen_arteri', htmlspecialchars($akses_vaskular['lumen_arteri']));
	
	//$uklumen_vena = replace_newline($akses_vaskular['lumen_vena']);
	//$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($uklumen_vena);
	$templateklinik->setValue('uklumen_vena', htmlspecialchars($akses_vaskular['lumen_vena']));
	
	//$heparin_arteri = replace_newline($akses_vaskular['heparin_arteri']);
	//$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($heparin_arteri);
	$templateklinik->setValue('heparin_arteri', htmlspecialchars($akses_vaskular['heparin_arteri']));
	
	//$heparin_vena = replace_newline($akses_vaskular['heparin_vena']);
	//$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($heparin_vena);
	$templateklinik->setValue('heparin_vena', htmlspecialchars($akses_vaskular['heparin_vena']));
	
	//$antibiotik_arteri = replace_newline($akses_vaskular['antibiotik_arteri']);
	//$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($antibiotik_arteri);
	$templateklinik->setValue('antibiotik_arteri', htmlspecialchars($akses_vaskular['antibiotik_arteri']));
	
	//$antibiotik_vena = replace_newline($akses_vaskular['antibiotik_vena']);
	//$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($antibiotik_vena);
	$templateklinik->setValue('antibiotik_vena', htmlspecialchars($akses_vaskular['antibiotik_vena']));
	
	//$no_mesin = replace_newline($mesin_hemodialisis['no']);
	//$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($no_mesin);
	$templateklinik->setValue('no_mesin', htmlspecialchars($mesin_hemodialisis['no']));
	
	//$no_wtp = replace_newline($mesin_hemodialisis['wtp']);
	//$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($no_wtp);
	$templateklinik->setValue('no_wtp', htmlspecialchars($mesin_hemodialisis['wtp']));
	
	if($dialisat['bicarbonat']=='1'){
		$templateklinik->setValue('bicarbonat',$checked);
	}else{
		$templateklinik->setValue('bicarbonat',$unChecked);
	}
	
	if($dialisat['acid']=='1'){
		$templateklinik->setValue('acid',$checked);
	}else{
		$templateklinik->setValue('acid',$unChecked);
	}
	
	//$suhu_dialisat = replace_newline($dialisat['suhu']);
	//$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($suhu_dialisat);
	$templateklinik->setValue('suhu_dialisat', htmlspecialchars($dialisat['suhu']));
	
	//$model_dialiser = replace_newline($dialiser['model']);
	//$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($model_dialiser);
	$templateklinik->setValue('model_dialiser', htmlspecialchars($dialiser['model']));
	
	if($dialiser['lowflux']=='1'){
		$templateklinik->setValue('low_flux',$checked);
		$templateklinik->setValue('high_flux',$unChecked);
	}else if($dialiser['lowflux']=='2'){
		$templateklinik->setValue('low_flux',$unChecked);
		$templateklinik->setValue('high_flux',$checked);	
	}else{
		$templateklinik->setValue('low_flux',$unChecked);
		$templateklinik->setValue('high_flux',$checked);
	}
	
	if($dialiser['baru']=='1'){
		$templateklinik->setValue('dialiser_baru',$checked);
		$templateklinik->setValue('reuse',$unChecked);
	}else if($dialiser['lowflux']=='2'){
		$templateklinik->setValue('dialiser_baru',$unChecked);
		$templateklinik->setValue('reuse',$checked);	
	}else{
		$templateklinik->setValue('dialiser_baru',$unChecked);
		$templateklinik->setValue('reuse',$checked);
	}
	
	//$bb_kering = replace_newline($bb_kering['bb']);
	//$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($bb_kering);
	$templateklinik->setValue('bb_kering', htmlspecialchars($bb_kering['bb']));
	
	//$lama_hd = replace_newline($resep_hd['lama']);
	//$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($lama_hd);
	$templateklinik->setValue('lama_hd', htmlspecialchars($resep_hd['lama']));
	
	//$ufg = replace_newline($resep_hd['ufg']);
	//$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($ufg);
	$templateklinik->setValue('ufg', htmlspecialchars($resep_hd['ufg']));
	
	//$qb = replace_newline($resep_hd['qb']);
	//$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($qb);
	$templateklinik->setValue('qb', htmlspecialchars($resep_hd['qb']));
	
	if($resep_hd['heparin_reguler']=='1'){
		$templateklinik->setValue('heparin_reg',$checked);
	}else{
		$templateklinik->setValue('heparin_reg',$unChecked);
	}
	
	if($resep_hd['heparin_minimal']=='1'){
		$templateklinik->setValue('heparin_min',$checked);
	}else{
		$templateklinik->setValue('heparin_min',$unChecked);
	}
	
	if($resep_hd['heparin_free']=='1'){
		$templateklinik->setValue('heparin_free',$checked);
	}else{
		$templateklinik->setValue('heparin_free',$unChecked);
	}
	
	//$heparin_ec = replace_newline($resep_hd['heparin_ec']);
	//$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($heparin_ec);
	$templateklinik->setValue('heparin_ec', htmlspecialchars($resep_hd['heparin_ec']));
	
	//$total_heparin = replace_newline($resep_hd['total']);
	//$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($total_heparin);
	$templateklinik->setValue('total_heparin', htmlspecialchars($resep_hd['total']));
	
	//$bolus_heparin = replace_newline($resep_hd['bolus']);
	//$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($bolus_heparin);
	$templateklinik->setValue('bolus_heparin', htmlspecialchars($resep_hd['bolus']));
	
	//$sirk_heparin = replace_newline($resep_hd['sirkulasi']);
	//$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($sirk_heparin);
	$templateklinik->setValue('sirk_heparin', htmlspecialchars($resep_hd['sirkulasi']));
	
	//$kont_heparin = replace_newline($resep_hd['kontinyu']);
	//$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($kont_heparin);
	$templateklinik->setValue('kont_heparin', htmlspecialchars($resep_hd['kontinyu']));
	
	
	if(!file_exists($rmfile_path . '/pdf/' . $jns_perawatan . '/' . $nomr . '/' . $idxord)){
		@mkdir($rmfile_path . '/pdf/' . $jns_perawatan . '/' . $nomr . '/' . $idxord, 0700, true);
	}

	if(!file_exists($rmfile_path . '/doc/' . $jns_perawatan . '/' . $nomr . '/' . $idxord)){
		@mkdir($rmfile_path . '/doc/' . $jns_perawatan . '/' . $nomr . '/' . $idxord, 0700, true);
	}
	
	$nama_file = $nomr . '_' . $idxord . $idx . '_32';	
	$templateklinik->saveAs($rmfile_path . '/doc/' . $jns_perawatan . '/' . $nomr . '/' . $idxord . '/' . $nama_file . '.docx');
	
	mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE RAWAT_ID = "' . $idxord . '"
				AND JNS_PERAWATAN = "' . $jns_perawatan . '"
				AND JENIS_DOKUMEN_ID = "32"
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
				VALUES("32",
				"' . $nomr . '",
				"' . $idxord . '",
				"' . $jns_perawatan . '",
				' . (($jns_order != '') ? '"' . $idx . '"' : 'NULL') . ',
				"' . $nama_file . '.pdf",
				"1",
				STR_TO_DATE("' . $tgl_daftar . '","%d/%m/%Y"))') or die(mysql_error());
	
	$source_file = $rmfile_path . '/doc/' . $jns_perawatan . '/' . $nomr . '/' . $idxord . '/' . $nama_file . '.docx';			
	$source_file = str_replace('/','\\',$source_file);
	$target_file = $rmfile_path . '/pdf/' . $jns_perawatan . '/' . $nomr . '/' . $idxord . '/' . $nama_file . '.pdf';
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