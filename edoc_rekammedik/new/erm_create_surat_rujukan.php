<?php
function replace_newline($str){
	$ret = preg_replace('/\r|\n/','\n',trim($str));
	$ret = str_replace('\n','<br>',$ret);
	$ret = str_replace('<br><br>','<br>',$ret);
	return $ret;
}

function erm_surat_rujukan($idx,$rawat){
	global $rmfile_path, $app_path;

	$checked = '<w:sym w:font="Wingdings" w:char="F0FE"/>';
    $unChecked = '<w:sym w:font="Wingdings" w:char="F0A8"/>';
	
	$templateklinik = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\surat_rujukan.docx');
	
	if($rawat == '1'){
		$qry_pasien = 'SELECT t_irja.IRJA_ID,t_irja.NOMR,t_irja.PEGAWAI_ID,m_pegawai.NAMA_PEGAWAI,
				t_irja.ASAL_PASIEN_ID,t_irja.KET_ASAL_PASIEN,t_irja.UNIT_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				DATE_FORMAT(t_irja.PASIEN_MASUK,"%d-%m-%Y %H:%i") AS PASIEN_MASUK,t_irja.JENIS_BAYAR_ID,m_pasien.NO_TELEPON,
				DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_unit.NAMA_UNIT,t_irja.UNIT_ID,m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,
				m_kelurahan.NAMA_KELURAHAN,m_kecamatan.NAMA_KECAMATAN,
				m_kota.NAMA_KOTA,m_pasien.TMP_LAHIR
				FROM t_irja
				INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
				WHERE t_irja.IRJA_ID = "' . $idx . '"';
	}			
	$get_pasien = mysql_query($qry_pasien);
	$dat_transfer = mysql_fetch_assoc($get_pasien);
	$nomr = $dat_transfer['NOMR'];
	$nama_pasien = $dat_transfer['NAMA_PASIEN'];
	$tgl_lahir = $dat_transfer['TGL_LAHIR'];
	$tmp_lahir = $dat_transfer['TMP_LAHIR'];
	$jns_kelamin = jenisKelamin($dat_transfer['JNS_KELAMIN']);
	$alamat_pasien = $dat_transfer['ALAMAT'];
	$alamat_pasien_rt = $dat_transfer['ALAMAT_RT'];
	$alamat_pasien_rw = $dat_transfer['ALAMAT_RW'];
	$kecamatan = $dat_transfer['NAMA_KECAMATAN'];
	$kelurahan = $dat_transfer['NAMA_KELURAHAN'];
	$kota = $dat_transfer['NAMA_KOTA'];
	$nik = $dat_transfer['NIK'];
	$jns_pembayaran = $dat_transfer['NAMA_JAMINAN'];
	$jenis_bayar_id = $dat_transfer['JENIS_BAYAR_ID'];

	$irja_id = $dat_transfer['IRJA_ID'];
	$pegawai_id = $dat_transfer['PEGAWAI_ID'];
	$asal_pasien_id = $dat_transfer['ASAL_PASIEN_ID'];
	$ket_asal_pasien = $dat_transfer['KET_ASAL_PASIEN'];
	$pasien_masuk = $dat_transfer['PASIEN_MASUK'];

	$no_telepon = $dat_transfer['NO_TELEPON'];
	$tgl_daftar = $dat_transfer['TANGGAL_DAFTAR'];
	$nama_unit = $dat_transfer['NAMA_UNIT'];
	$nama_dokter = $dat_transfer['NAMA_PEGAWAI'];
	$unit_id = $dat_transfer['UNIT_ID'];

	$umur = getUmurDaftar($tgl_lahir,$tgl_daftar);
	
	if($rawat == '1'){
		$qry_transfer = 'SELECT IRJA_RUJUKAN_ID,PENERIMA,UNIT_PENERIMA,ALAMAT_PENERIMA,ANAMNESA_SINGKAT,
			PEMERIKSAAN,LAMPIR_LABORATORIUM,LAMPIR_ROTGEN,LAMPIR_EKG,LAMPIR_DARAH,TERAPI_OBAT,TERAPI_CAIRAN,
			TERAPI_LAIN,PEMERIKSAAN_SAAT_RUJUK,
			DATE_FORMAT(TGL_ASSESMENT,"%d-%m-%Y %H:%i") AS TGL_ASSESMENT,REGISTER
			FROM t_irja_rujukan
			WHERE IRJA_RUJUKAN_ID = "' . $idx . '"';
	}		
	$get_transfer = mysql_query($qry_transfer) or die(mysql_error());
	$dat_transfer = mysql_fetch_assoc($get_transfer);
	$penerima = $dat_transfer['PENERIMA'];
	$unit_penerima = $dat_transfer['UNIT_PENERIMA'];
	$alamat_penerima = $dat_transfer['ALAMAT_PENERIMA'];
	$anamnesa = $dat_transfer['ANAMNESA_SINGKAT'];

	$pemeriksaan = str_replace('|','"',$dat_transfer['PEMERIKSAAN']);
	$pemeriksaan = preg_replace('/\r|\n/','\n',trim($pemeriksaan));
	$pemeriksaan = json_decode($pemeriksaan,true);

	$lampir_lab = $dat_transfer['LAMPIR_LABORATORIUM'];
	$lampir_rotgen = $dat_transfer['LAMPIR_ROTGEN'];
	$lampir_ekg = $dat_transfer['LAMPIR_EKG'];
	$lampir_darah = $dat_transfer['LAMPIR_DARAH'];

	$terapi_obat = $dat_transfer['TERAPI_OBAT'];
	$terapi_cairan = $dat_transfer['TERAPI_CAIRAN'];
	$terapi_lain = $dat_transfer['TERAPI_LAIN'];

	$pemeriksaan_saat_rujuk = str_replace('|','"',$dat_transfer['PEMERIKSAAN_SAAT_RUJUK']);
	$pemeriksaan_saat_rujuk = preg_replace('/\r|\n/','\n',trim($pemeriksaan_saat_rujuk));
	$pemeriksaan_saat_rujuk = json_decode($pemeriksaan_saat_rujuk,true);

	$tgl_assesment = $dat_transfer['TGL_ASSESMENT'];
	
	$templateklinik->setValue('penerima', htmlspecialchars($penerima));
	$templateklinik->setValue('unit_penerima', htmlspecialchars($unit_penerima));
	$templateklinik->setValue('alamat_penerima', htmlspecialchars($alamat_penerima));
		
	$templateklinik->setValue('nama_dokter', htmlspecialchars($nama_dokter));			
	$templateklinik->setValue('nama_pasien', htmlspecialchars($nama_pasien));
	$templateklinik->setValue('tgl_lahir', htmlspecialchars($tmp_lahir) . '/ ' . $tgl_lahir);
	$templateklinik->setValue('jns_kelamin', $jns_kelamin);
	$alamat_pasien = $alamat_pasien;
	if($alamat_pasien_rt != '') $alamat_pasien .= ' RT. ' . $alamat_pasien_rt;
	if($alamat_pasien_rw != '') $alamat_pasien .= ' RW. ' . $alamat_pasien_rw;
	if($kelurahan != '') $alamat_pasien .= ' ' . $kelurahan;
	if($kecamatan != '') $alamat_pasien .= ' ' . $kecamatan;
	if($kota != '') $alamat_pasien .= ' ' . $kota;
	$templateklinik->setValue('alamat_pasien', htmlspecialchars($alamat_pasien));
	$arr_tgl_assesment = explode(' ',$tgl_assesment);
	$tgl_rujuk = '';
	$jam_rujuk = '';
	if(sizeof($arr_tgl_assesment) == 2){
		$tgl_rujuk = $arr_tgl_assesment[0];
		$jam_rujuk = $arr_tgl_assesment[1];
	}	
	$templateklinik->setValue('waktu_dirujuk', 'Tanggal ' . $tgl_rujuk . ' Jam ' . $jam_rujuk);
	$templateklinik->setValue('tanggal', $tgl_rujuk);
		
	
	$anamnesa = replace_newline($anamnesa);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($anamnesa);
	$templateklinik->setValue('anamnesa', $toOpenXML);
	
	$pemeriksaan_nya = 'Kesadaran : ' . $pemeriksaan['kp_kesadaran'] . '<br>';
	$pemeriksaan_nya .= 'TD : ' . $pemeriksaan['kp_td'] . ' mmHg&nbsp;&nbsp;&nbsp;Nadi : ' . $pemeriksaan['kp_nadi'] . ' x/menit<br>';
	$pemeriksaan_nya .= 'Pernafasan : ' . $pemeriksaan['kp_nafas'] . 'x/menit&nbsp;&nbsp;&nbsp;Suhu : ' . $pemeriksaan['kp_suhu'] . ' <span>&#8451;</span>';
	
	$pemeriksaan_nya = replace_newline($pemeriksaan_nya);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($pemeriksaan_nya);
	$templateklinik->setValue('pemeriksaan', $toOpenXML);
	
	$diagnosa = '';
	if($rawat == '1'){
		$qry_diagnosa = 'SELECT DIAGNOSA_ORDER,DIAGNOSA
			FROM t_irja_diagnosa
			WHERE IRJA_ID = "' . $idx . '"
			AND DIAGNOSA_ORDER <= 3
			ORDER BY DIAGNOSA_ORDER';
	}		
	$get_diagnosa = mysql_query($qry_diagnosa) or die(mysql_error());
	while($dat_diagnosa= mysql_fetch_array($get_diagnosa)){
		$diagnosa .= $dat_diagnosa['DIAGNOSA'] . ','; 
	}		
	$templateklinik->setValue('diagnosis', htmlspecialchars(substr($diagnosa,0,strlen($diagnosa)-1)));
	
	if($lampir_lab == '1'){
		$templateklinik->setValue('lb_1',$checked);
		$templateklinik->setValue('lb_2',$unChecked);
	}
	if($lampir_lab == '2'){
		$templateklinik->setValue('lb_1',$unChecked);
		$templateklinik->setValue('lb_2',$checked);
	}
	if($lampir_lab == ''){
		$templateklinik->setValue('lb_1',$unChecked);
		$templateklinik->setValue('lb_2',$unChecked);
	}
	
	if($lampir_rotgen == '1'){
		$templateklinik->setValue('lr_1',$checked);
		$templateklinik->setValue('lr_2',$unChecked);
	}
	if($lampir_rotgen == '2'){
		$templateklinik->setValue('lr_1',$unChecked);
		$templateklinik->setValue('lr_2',$checked);
	}
	if($lampir_rotgen == ''){
		$templateklinik->setValue('lr_1',$unChecked);
		$templateklinik->setValue('lr_2',$unChecked);
	}

	if($lampir_ekg == '1'){
		$templateklinik->setValue('le_1',$checked);
		$templateklinik->setValue('le_2',$unChecked);
	}
	if($lampir_ekg == '2'){
		$templateklinik->setValue('le_1',$unChecked);
		$templateklinik->setValue('le_2',$checked);
	}
	if($lampir_ekg == ''){
		$templateklinik->setValue('le_1',$unChecked);
		$templateklinik->setValue('le_2',$unChecked);
	}

	if($lampir_darah == '1'){
		$templateklinik->setValue('lc_1',$checked);
		$templateklinik->setValue('lc_2',$unChecked);
	}
	if($lampir_darah == '2'){
		$templateklinik->setValue('lc_1',$unChecked);
		$templateklinik->setValue('lc_2',$checked);
	}
	if($lampir_darah == ''){
		$templateklinik->setValue('lc_1',$unChecked);
		$templateklinik->setValue('lc_2',$unChecked);
	}

	$terapi_obat = replace_newline($terapi_obat);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($terapi_obat);
	$templateklinik->setValue('terapi_obat', $toOpenXML);	
	
	$terapi_cairan = replace_newline($terapi_cairan);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($terapi_cairan);
	$templateklinik->setValue('terapi_cairan', $toOpenXML);	
	
	$terapi_lain = replace_newline($terapi_lain);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($terapi_lain);
	$templateklinik->setValue('terapi_lain', $toOpenXML);
	
	$pemeriksaan_srj = 'Kesadaran : ' . $pemeriksaan_saat_rujuk['kpr_kesadaran'] . '<br>';
	$pemeriksaan_srj .= 'TD : ' . $pemeriksaan_saat_rujuk['kpr_td'] . ' mmHg&nbsp;&nbsp;&nbsp;Nadi : ' . $pemeriksaan_saat_rujuk['kpr_nadi'] . ' x/menit<br>';
	$pemeriksaan_srj .= 'Pernafasan : ' . $pemeriksaan_saat_rujuk['kpr_nafas'] . 'x/menit&nbsp;&nbsp;&nbsp;Suhu : ' . $pemeriksaan_saat_rujuk['kpr_suhu'] . ' <span>&#8451;</span>';
	
	$pemeriksaan_srj = replace_newline($pemeriksaan_srj);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($pemeriksaan_srj);
	$templateklinik->setValue('pemeriksaan_saat_rujuk', $toOpenXML);
	
	$templateklinik->setValue('urine', $pemeriksaan_saat_rujuk['kpr_urine']);
	$templateklinik->setValue('cairan_hilang', $pemeriksaan_saat_rujuk['kpr_cairan_hilang']);
	
	if(!file_exists($rmfile_path . '/pdf/1/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/pdf/1/' . $nomr . '/' . $idx, 0700, true);
	}

	if(!file_exists($rmfile_path . '/doc/1/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/doc/1/' . $nomr . '/' . $idx, 0700, true);
	}
	
	$nama_file = $nomr . '_' . $idx . '_47';	
	$templateklinik->saveAs($rmfile_path . '/doc/1/' . $nomr . '/' . $idx . '/' . $nama_file . '.docx');
	
	mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE RAWAT_ID = "' . $idx . '"
				AND JNS_PERAWATAN = "1"
				AND JENIS_DOKUMEN_ID = "47"
				AND NAMA_FILE = "' . $nama_file . '.pdf"') or die(mysql_error());
	mysql_query('INSERT INTO t_rm_dokumen_file(JENIS_DOKUMEN_ID,NOMR,RAWAT_ID,JNS_PERAWATAN,NAMA_FILE,ST_SISTEM,TANGGAL) 		
				VALUES("47","' . $nomr . '","' . $idx . '","1","' . $nama_file . '.pdf","1",STR_TO_DATE("' . $tgl_daftar . '","%d/%m/%Y"))') or die(mysql_error());
	
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