<?php
function replace_newline($str){
	$ret = preg_replace('/\r|\n/','\n',trim($str));
	$ret = str_replace('\n','<br>',$ret);
	$ret = str_replace('<br><br>','<br>',$ret);
	return $ret;
}

function erm_pemeriksaan_bth($idx){
	global $rmfile_path, $app_path;

	$checked = '<w:sym w:font="Wingdings" w:char="F0FE"/>';
    $unChecked = '<w:sym w:font="Wingdings" w:char="F0A8"/>';
	
	$templateklinik = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\pemeriksaan_koh.docx');
	
	$qry_pasien = 'SELECT t_irna.IRNA_ID,t_irna.NOMR,t_irna.PEGAWAI_ID,m_pegawai.NAMA_PEGAWAI,
				t_irna.RUANG_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,
				DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,m_pasien.JNS_KELAMIN,
				m_pasien.ALAMAT,m_pasien.NIK,
				DATE_FORMAT(t_irna.PASIEN_MASUK,"%d-%m-%Y %H:%i") AS PASIEN_MASUK,t_irna.JENIS_BAYAR_ID,m_pasien.NO_TELEPON,
				DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_ruang.NAMA_RUANG AS NAMA_UNIT,t_irna.RUANG_ID,m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,
				m_kelurahan.NAMA_KELURAHAN,m_kecamatan.NAMA_KECAMATAN,
				m_kota.NAMA_KOTA,m_pasien.TMP_LAHIR,m_agama.NAMA_AGAMA,m_pasien.ST_KAWIN,
				m_pegawai.NIP,m_pegawai.SIP
				FROM t_irna
				INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
				LEFT JOIN m_agama ON (m_pasien.AGAMA_ID = m_agama.AGAMA_ID)
				WHERE t_irna.IRNA_ID = "' . $idx . '"';			
	$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
	$dat_pasien = mysql_fetch_assoc($get_pasien);
	$nomr = $dat_pasien['NOMR'];
	$nama_pasien = $dat_pasien['NAMA_PASIEN'];
	$tmp_lahir = $dat_pasien['TMP_LAHIR'];
	$tgl_lahir = $dat_pasien['TGL_LAHIR'];
	$jns_kelamin = jenisKelamin($dat_pasien['JNS_KELAMIN']);
	$alamat_pasien = $dat_pasien['ALAMAT'];
	$alamat_pasien_rt = $dat_pasien['ALAMAT_RT'];
	$alamat_pasien_rw = $dat_pasien['ALAMAT_RW'];
	$kecamatan = $dat_pasien['NAMA_KECAMATAN'];
	$kelurahan = $dat_pasien['NAMA_KELURAHAN'];
	$kota = $dat_pasien['NAMA_KOTA'];
	$nik = $dat_pasien['NIK'];
	$jns_pembayaran = $dat_pasien['NAMA_JAMINAN'];
	$jenis_bayar_id = $dat_pasien['JENIS_BAYAR_ID'];

	$irna_id = $dat_pasien['IRNA_ID'];
	$pegawai_id = $dat_pasien['PEGAWAI_ID'];
	$pasien_masuk = $dat_pasien['PASIEN_MASUK'];

	$no_telepon = $dat_pasien['NO_TELEPON'];
	$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];
	$nama_unit = $dat_pasien['NAMA_UNIT'];
	$unit_id = $dat_pasien['RUANG_ID'];
	
	$agama = $dat_pasien['NAMA_AGAMA'];
	
	$st_kawin[''] = '';
	$st_kawin['1'] = 'Belum Kawin';
	$st_kawin['2'] = 'Kawin';
	$st_kawin['3'] = 'Janda/ Duda';
	$kawin = $st_kawin[$dat_pasien['ST_KAWIN']];

	$umur = getUmurDaftar($tgl_lahir,$tgl_daftar);
	$nip = $dat_pasien['NIP'];
	$sip = $dat_pasien['SIP'];
	
	$templateklinik->setValue('nomor_rm', formatNomr($nomr));
	$templateklinik->setValue('nama_pasien', htmlspecialchars($nama_pasien));
	$templateklinik->setValue('tgl_lahir', $tgl_lahir);
	$templateklinik->setValue('jenis_kelamin', $jns_kelamin);
	$templateklinik->setValue('unit', htmlspecialchars($nama_unit));
	
	$qry_transfer = 'SELECT IRNA_ID,KUPING_TELINGA_KANAN,KUPING_TELINGA_KIRI,DAHI,DAGU,JARI_TENGAH_TANGAN_KANAN,
			JARI_TENGAH_TANGAN_KIRI,PEMERIKSAAN_LAIN,
			REGISTER,DATE_FORMAT(TGL_ASSESMENT,"%d-%m-%Y") AS TGL_ASSESMENT,
			NAMA_PEGAWAI
			FROM t_irna_pemeriksaan_koh
			LEFT JOIN m_pegawai ON (t_irna_pemeriksaan_koh.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
			WHERE IRNA_ID = "' . $idx . '"';		
	$get_transfer = mysql_query($qry_transfer) or die(mysql_error());
	$dat_transfer = mysql_fetch_assoc($get_transfer);
	
	$nama_dokter = $dat_transfer['NAMA_PEGAWAI'];
	$templateklinik->setValue('nama_dokter', htmlspecialchars($nama_dokter));
	
	$kuping_telinga_kanan = str_replace('|','"',$dat_transfer['KUPING_TELINGA_KANAN']);
	$kuping_telinga_kanan = preg_replace('/\r|\n/','\n',trim($kuping_telinga_kanan));
	$kuping_telinga_kanan = json_decode($kuping_telinga_kanan,true);

	$p_ktk = ((isset($kuping_telinga_kanan['p_ktk']) ? $kuping_telinga_kanan['p_ktk'] : ''));
	$p_ktk_bi = ((isset($kuping_telinga_kanan['p_ktk_bi']) ? $kuping_telinga_kanan['p_ktk_bi'] : ''));
	$p_ktk_mi = ((isset($kuping_telinga_kanan['p_ktk_mi']) ? $kuping_telinga_kanan['p_ktk_mi'] : ''));
	$p_ktk_s = ((isset($kuping_telinga_kanan['p_ktk_s']) ? $kuping_telinga_kanan['p_ktk_s'] : ''));
	$p_ktk_f = ((isset($kuping_telinga_kanan['p_ktk_f']) ? $kuping_telinga_kanan['p_ktk_f'] : ''));
	$p_ktk_g = ((isset($kuping_telinga_kanan['p_ktk_g']) ? $kuping_telinga_kanan['p_ktk_g'] : ''));
	
	if($p_ktk == '1'){
		$templateklinik->setValue('sl1', $checked);
	}else{
		$templateklinik->setValue('sl1', $unChecked);
	}	

	$kuping_telinga_kiri = str_replace('|','"',$dat_transfer['KUPING_TELINGA_KIRI']);
	$kuping_telinga_kiri = preg_replace('/\r|\n/','\n',trim($kuping_telinga_kiri));
	$kuping_telinga_kiri = json_decode($kuping_telinga_kiri,true);

	$p_ktr = ((isset($kuping_telinga_kiri['p_ktr']) ? $kuping_telinga_kiri['p_ktr'] : ''));
	$p_ktr_bi = ((isset($kuping_telinga_kiri['p_ktr_bi']) ? $kuping_telinga_kiri['p_ktr_bi'] : ''));
	$p_ktr_mi = ((isset($kuping_telinga_kiri['p_ktr_mi']) ? $kuping_telinga_kiri['p_ktr_mi'] : ''));
	$p_ktr_s = ((isset($kuping_telinga_kiri['p_ktr_s']) ? $kuping_telinga_kiri['p_ktr_s'] : ''));
	$p_ktr_f = ((isset($kuping_telinga_kiri['p_ktr_f']) ? $kuping_telinga_kiri['p_ktr_f'] : ''));
	$p_ktr_g = ((isset($kuping_telinga_kiri['p_ktr_g']) ? $kuping_telinga_kiri['p_ktr_g'] : ''));

	$dahi = str_replace('|','"',$dat_transfer['DAHI']);
	$dahi = preg_replace('/\r|\n/','\n',trim($dahi));
	$dahi = json_decode($dahi,true);

	$p_dh = ((isset($dahi['p_dh']) ? $dahi['p_dh'] : ''));
	$p_dh_bi = ((isset($dahi['p_dh_bi']) ? $dahi['p_dh_bi'] : ''));
	$p_dh_mi = ((isset($dahi['p_dh_mi']) ? $dahi['p_dh_mi'] : ''));
	$p_dh_s = ((isset($dahi['p_dh_s']) ? $dahi['p_dh_s'] : ''));
	$p_dh_f = ((isset($dahi['p_dh_f']) ? $dahi['p_dh_f'] : ''));
	$p_dh_g = ((isset($dahi['p_dh_g']) ? $dahi['p_dh_g'] : ''));

	$dagu = str_replace('|','"',$dat_transfer['DAGU']);
	$dagu = preg_replace('/\r|\n/','\n',trim($dagu));
	$dagu = json_decode($dagu,true);

	$p_dg = ((isset($dagu['p_dg']) ? $dagu['p_dg'] : ''));
	$p_dg_bi = ((isset($dagu['p_dg_bi']) ? $dagu['p_dg_bi'] : ''));
	$p_dg_mi = ((isset($dagu['p_dg_mi']) ? $dagu['p_dg_mi'] : ''));
	$p_dg_s = ((isset($dagu['p_dg_s']) ? $dagu['p_dg_s'] : ''));
	$p_dg_f = ((isset($dagu['p_dg_f']) ? $dagu['p_dg_f'] : ''));
	$p_dg_g = ((isset($dagu['p_dg_g']) ? $dagu['p_dg_g'] : ''));

	$jari_tengah_tangan_kanan = str_replace('|','"',$dat_transfer['JARI_TENGAH_TANGAN_KANAN']);
	$jari_tengah_tangan_kanan = preg_replace('/\r|\n/','\n',trim($jari_tengah_tangan_kanan));
	$jari_tengah_tangan_kanan = json_decode($jari_tengah_tangan_kanan,true);

	$p_jtk = ((isset($jari_tengah_tangan_kanan['p_jtk']) ? $jari_tengah_tangan_kanan['p_jtk'] : ''));
	$p_jtk_bi = ((isset($jari_tengah_tangan_kanan['p_jtk_bi']) ? $jari_tengah_tangan_kanan['p_jtk_bi'] : ''));
	$p_jtk_mi = ((isset($jari_tengah_tangan_kanan['p_jtk_mi']) ? $jari_tengah_tangan_kanan['p_jtk_mi'] : ''));
	$p_jtk_s = ((isset($jari_tengah_tangan_kanan['p_jtk_s']) ? $jari_tengah_tangan_kanan['p_jtk_s'] : ''));
	$p_jtk_f = ((isset($jari_tengah_tangan_kanan['p_jtk_f']) ? $jari_tengah_tangan_kanan['p_jtk_f'] : ''));
	$p_jtk_g = ((isset($jari_tengah_tangan_kanan['p_jtk_g']) ? $jari_tengah_tangan_kanan['p_jtk_g'] : ''));

	$jari_tengah_tangan_kiri = str_replace('|','"',$dat_transfer['JARI_TENGAH_TANGAN_KIRI']);
	$jari_tengah_tangan_kiri = preg_replace('/\r|\n/','\n',trim($jari_tengah_tangan_kiri));
	$jari_tengah_tangan_kiri = json_decode($jari_tengah_tangan_kiri,true);

	$p_jtr = ((isset($jari_tengah_tangan_kiri['p_jtr']) ? $jari_tengah_tangan_kiri['p_jtr'] : ''));
	$p_jtr_bi = ((isset($jari_tengah_tangan_kiri['p_jtr_bi']) ? $jari_tengah_tangan_kiri['p_jtr_bi'] : ''));
	$p_jtr_mi = ((isset($jari_tengah_tangan_kiri['p_jtr_mi']) ? $jari_tengah_tangan_kiri['p_jtr_mi'] : ''));
	$p_jtr_s = ((isset($jari_tengah_tangan_kiri['p_jtr_s']) ? $jari_tengah_tangan_kiri['p_jtr_s'] : ''));
	$p_jtr_f = ((isset($jari_tengah_tangan_kiri['p_jtr_f']) ? $jari_tengah_tangan_kiri['p_jtr_f'] : ''));
	$p_jtr_g = ((isset($jari_tengah_tangan_kiri['p_jtr_g']) ? $jari_tengah_tangan_kiri['p_jtr_g'] : ''));
	
	$pemeriksaan_lain = $dat_transfer['PEMERIKSAAN_LAIN'];
	$templateklinik->setValue('pemeriksaan_lain', $pemeriksaan_lain);
	
	if($p_ktk == '1'){
		$templateklinik->setValue('sl1', $checked);
	}else{
		$templateklinik->setValue('sl1', $unChecked);
	}
	
	if($p_ktr == '1'){
		$templateklinik->setValue('sl2', $checked);
	}else{
		$templateklinik->setValue('sl2', $unChecked);
	}
	
	$templateklinik->setValue('sl3', htmlspecialchars($p_dg));
	$templateklinik->setValue('sl4', htmlspecialchars($p_dh));
	$templateklinik->setValue('sl5', htmlspecialchars($p_jtk));
	$templateklinik->setValue('sl6', htmlspecialchars($p_jtr));
	
	$templateklinik->setValue('sl1_bi', $p_ktk_bi);
	$templateklinik->setValue('sl1_mi', $p_ktk_mi);
	$templateklinik->setValue('sl1_s', $p_ktk_s);
	$templateklinik->setValue('sl1_f', $p_ktk_f);
	$templateklinik->setValue('sl1_g', $p_ktk_g);
	
	$templateklinik->setValue('sl2_bi', $p_ktr_bi);
	$templateklinik->setValue('sl2_mi', $p_ktr_mi);
	$templateklinik->setValue('sl2_s', $p_ktr_s);
	$templateklinik->setValue('sl2_f', $p_ktr_f);
	$templateklinik->setValue('sl2_g', $p_ktr_g);
	
	$templateklinik->setValue('sl3_bi', $p_dh_bi);
	$templateklinik->setValue('sl3_mi', $p_dh_mi);
	$templateklinik->setValue('sl3_s', $p_dh_s);
	$templateklinik->setValue('sl3_f', $p_dh_f);
	$templateklinik->setValue('sl3_g', $p_dh_g);
	
	$templateklinik->setValue('sl4_bi', $p_dg_bi);
	$templateklinik->setValue('sl4_mi', $p_dg_mi);
	$templateklinik->setValue('sl4_s', $p_dg_s);
	$templateklinik->setValue('sl4_f', $p_dg_f);
	$templateklinik->setValue('sl4_g', $p_dg_g);
	
	$templateklinik->setValue('sl5_bi', $p_jtk_bi);
	$templateklinik->setValue('sl5_mi', $p_jtk_mi);
	$templateklinik->setValue('sl5_s', $p_jtk_s);
	$templateklinik->setValue('sl5_f', $p_jtk_f);
	$templateklinik->setValue('sl5_g', $p_jtk_g);
	
	$templateklinik->setValue('sl6_bi', $p_jtr_bi);
	$templateklinik->setValue('sl6_mi', $p_jtr_mi);
	$templateklinik->setValue('sl6_s', $p_jtr_s);
	$templateklinik->setValue('sl6_f', $p_jtr_f);
	$templateklinik->setValue('sl6_g', $p_jtr_g);
	
	if(!file_exists($rmfile_path . '/pdf/2/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/pdf/2/' . $nomr . '/' . $idx, 0700, true);
	}

	if(!file_exists($rmfile_path . '/doc/2/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/doc/2/' . $nomr . '/' . $idx, 0700, true);
	}
	
	$nama_file = $nomr . '_' . $idx . '_63';	
	$templateklinik->saveAs($rmfile_path . '/doc/2/' . $nomr . '/' . $idx . '/' . $nama_file . '.docx');
	
	mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE RAWAT_ID = "' . $idx . '"
				AND JNS_PERAWATAN = "2"
				AND JENIS_DOKUMEN_ID = "63"
				AND NAMA_FILE = "' . $nama_file . '.pdf"') or die(mysql_error());
	mysql_query('INSERT INTO t_rm_dokumen_file(JENIS_DOKUMEN_ID,NOMR,RAWAT_ID,JNS_PERAWATAN,NAMA_FILE,ST_SISTEM,TANGGAL) 		
				VALUES("63","' . $nomr . '","' . $idx . '","2","' . $nama_file . '.pdf","1",STR_TO_DATE("' . $tgl_daftar . '","%d/%m/%Y"))') or die(mysql_error());
	
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