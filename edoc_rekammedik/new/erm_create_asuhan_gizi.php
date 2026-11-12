<?php
function replace_newline($str){
	$ret = preg_replace('/\r|\n/','\n',trim($str));
	$ret = str_replace('\n','<br>',$ret);
	$ret = str_replace('<br><br>','<br>',$ret);
	return $ret;
}

function erm_asuhan_gizi($idx,$asuhan_id,$ls_assesment,$tgl_skr,$final){
	global $rmfile_path, $app_path;

	$checked = '<w:sym w:font="Wingdings" w:char="F0FE"/>';
    $unChecked = '<w:sym w:font="Wingdings" w:char="F0A8"/>';
	
	$templateklinik = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\asuhan_gizi.docx');
	
	$qry_pasien = 'SELECT t_irna.NOMR,m_pasien.NAMA_PASIEN,
				DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,m_pasien.JNS_KELAMIN,
				m_pasien.ALAMAT,m_pasien.NIK,m_pegawai.NAMA_PEGAWAI AS DOKTER_MERAWAT,
				CONCAT(m_ruang.NAMA_RUANG," KELAS ",m_ruang.KELAS_RAWAT) AS NAMA_RUANG,
				DATE_FORMAT(t_irna.PASIEN_MASUK,"%d-%m-%Y %H:%i") AS PASIEN_MASUK,
				DATE_FORMAT(t_irna.PASIEN_KELUAR,"%d-%m-%Y %H:%i") AS PASIEN_KELUAR,
				DATE_FORMAT(t_irna.PASIEN_KELUAR,"%d-%m-%Y") AS PASIEN_KELUAR_2,
				DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_jaminan.NAMA_JAMINAN
				FROM t_irna
				INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				LEFT JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_irna.IRNA_ID = "' . $idx . '"';
	$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
	$dat_pasien = mysql_fetch_assoc($get_pasien);
	$nomr = $dat_pasien['NOMR'];
	$nama_pasien = $dat_pasien['NAMA_PASIEN'];
	$tgl_lahir = $dat_pasien['TGL_LAHIR'];
	$jns_kelamin = jenisKelamin($dat_pasien['JNS_KELAMIN']);
	$jns_pembayaran = $dat_pasien['NAMA_JAMINAN'];
	$nama_ruang = $dat_pasien['NAMA_RUANG'];
	$nama_dokter_merawat = $dat_pasien['DOKTER_MERAWAT'];

	$pasien_masuk = $dat_pasien['PASIEN_MASUK'];
	$pasien_keluar = $dat_pasien['PASIEN_KELUAR'];
	$pasien_keluar_2 = $dat_pasien['PASIEN_KELUAR_2'];
	$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];

	$templateklinik->setValue('nomor_rm', formatNomr($nomr));
	$templateklinik->setValue('nama_pasien', htmlspecialchars($nama_pasien));
	$templateklinik->setValue('tgl_lahir', htmlspecialchars($tgl_lahir));
	$templateklinik->setValue('jenis_kelamin', htmlspecialchars($jns_kelamin));
	$templateklinik->setValue('nama_unit', htmlspecialchars($nama_ruang));
	$templateklinik->setValue('dicetak_oleh', '');
	
	$diagnosis = '';
	$qry_diagnosa = 'SELECT DIAGNOSA_ORDER,DIAGNOSA
		FROM t_irna_diagnosa
		WHERE IRNA_ID = "' . $idx . '"
		AND DIAGNOSA_ORDER <= 3
		ORDER BY DIAGNOSA_ORDER';
	$get_diagnosa = mysql_query($qry_diagnosa) or die(mysql_error());
	while($dat_diagnosa = mysql_fetch_array($get_diagnosa)){
		$diagnosis .= $dat_diagnosa['DIAGNOSA'] . ',';	
	}
	$diagnosis = substr($diagnosis,0,strlen($diagnosis)-1);
	$templateklinik->setValue('diagnosis', htmlspecialchars($diagnosis));
	
	$qry_asuhan = 'SELECT IRNA_ASUHAN_ID,ANTROPOMETRI,BIOKIMIA,KLINIK,RIWAYAT_GIZI,RIWAYAT_PERSONAL,DIAGNOSA_GIZI,
				INTERVENSI_GIZI,MONITORING_EVALUASI,DATE_FORMAT(TGL_ASSESMENT,"%d-%m-%Y") AS TGL_ASSESMENT,
				pg.NAMA_PEGAWAI
				FROM t_irna_asuhan_gizi
				LEFT JOIN db_inventorirs.m_pegawai pg
				ON (t_irna_asuhan_gizi.PEGAWAI_ID = pg.PEGAWAI_ID)
				WHERE IRNA_ASUHAN_ID = "' . $asuhan_id . '"';
	$get_asuhan = mysql_query($qry_asuhan) or die(mysql_error());
	$dat_asuhan = mysql_fetch_assoc($get_asuhan);
	$antropometri = str_replace('|','"',$dat_asuhan['ANTROPOMETRI']);
	$antropometri = preg_replace('/\r|\n/','\n',trim($antropometri));
	$antropometri = json_decode($antropometri,true);
	$biokomia = $dat_asuhan['BIOKIMIA'];
	$klinik = $dat_asuhan['KLINIK'];
	$riwayat_gizi = $dat_asuhan['RIWAYAT_GIZI'];
	$riwayat_personal = $dat_asuhan['RIWAYAT_PERSONAL'];
	$diagnosa_gizi = $dat_asuhan['DIAGNOSA_GIZI'];
	$intervensi_gizi = str_replace('|','"',$dat_asuhan['INTERVENSI_GIZI']);
	$intervensi_gizi = preg_replace('/\r|\n/','\n',trim($intervensi_gizi));
	$intervensi_gizi = json_decode($intervensi_gizi,true);
	$monitoring = $dat_asuhan['MONITORING_EVALUASI'];
	$tanggal = $dat_asuhan['TGL_ASSESMENT'];
	$ahli_gizi = $dat_asuhan['NAMA_PEGAWAI'];
	
	$templateklinik->setValue('tanggal', $tanggal);
	$templateklinik->setValue('ahli_gizi', $ahli_gizi);
	
	$bb = ((isset($antropometri['bb'])) ? $antropometri['bb'] : '');
	$tb = ((isset($antropometri['tb'])) ? $antropometri['tb'] : '');
	$lila = ((isset($antropometri['lila'])) ? $antropometri['lila'] : '');
	$tilut = ((isset($antropometri['tilut'])) ? $antropometri['tilut'] : '');
	$imt = ((isset($antropometri['imt'])) ? $antropometri['imt'] : '');
	$status_gizi = ((isset($antropometri['status_gizi'])) ? $antropometri['status_gizi'] : '');
	
	$tujuan = ((isset($intervensi_gizi['tujuan'])) ? $intervensi_gizi['tujuan'] : '');
	$intervensi = ((isset($intervensi_gizi['intervensi'])) ? $intervensi_gizi['intervensi'] : '');
	$konseling = ((isset($intervensi_gizi['konseling'])) ? $intervensi_gizi['konseling'] : '');
	
	$templateklinik->setValue('bb', $bb);
	$templateklinik->setValue('tb', $tb);
	$templateklinik->setValue('lila', $lila);
	$templateklinik->setValue('tilut', $tilut);
	$templateklinik->setValue('imt', $imt);
	$templateklinik->setValue('status_gizi', $status_gizi);
	
	$biokomia = replace_newline($biokomia);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($biokomia);
	$templateklinik->setValue('biokimia', $toOpenXML);
	
	$klinik = replace_newline($klinik);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($klinik);
	$templateklinik->setValue('klinik', $toOpenXML);
	
	$riwayat_gizi = replace_newline($riwayat_gizi);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($riwayat_gizi);
	$templateklinik->setValue('riwayat_gizi', $toOpenXML);
	
	$riwayat_personal = replace_newline($riwayat_personal);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($riwayat_personal);
	$templateklinik->setValue('riwayat_personal', $toOpenXML);
	
	$diagnosa_gizi = replace_newline($diagnosa_gizi);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($diagnosa_gizi);
	$templateklinik->setValue('diagnosa_gizi', $toOpenXML);
	
	$tujuan = replace_newline($tujuan);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($tujuan);
	$templateklinik->setValue('tujuan', $toOpenXML);
	
	$intervensi = replace_newline($intervensi);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($intervensi);
	$templateklinik->setValue('intervensi', $toOpenXML);
	
	$konseling = replace_newline($konseling);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($konseling);
	$templateklinik->setValue('konseling', $toOpenXML);
	
	$monitoring = replace_newline($monitoring);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($monitoring);
	$templateklinik->setValue('monitoring', $toOpenXML);
	
	if(!file_exists($rmfile_path . '/pdf/2/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/pdf/2/' . $nomr . '/' . $idx, 0700, true);
	}

	if(!file_exists($rmfile_path . '/doc/2/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/doc/2/' . $nomr . '/' . $idx, 0700, true);
	}
	
	$nama_file = $nomr . '_' . $idx . '_44_' . $asuhan_id;	
	/*
	if($final == '1' and $ls_assesment != $tgl_skr){
		$qry_rev = 'SELECT COUNT(FILE_ID) + 1 AS REV FROM t_rm_dokumen_file
			WHERE RAWAT_ID = "' . $idx . '"
			AND JNS_PERAWATAN = "2"
			AND JENIS_DOKUMEN_ID = "17"';
		$get_rev = mysql_query($qry_rev) or die(mysql_error());
		$dat_rev = mysql_fetch_assoc($get_rev);
		$nama_file .= '_' . $dat_rev['REV'];	
	}
	*/
	$templateklinik->saveAs($rmfile_path . '/doc/2/' . $nomr . '/' . $idx . '/' . $nama_file . '.docx');
	
	mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE RAWAT_ID = "' . $idx . '"
				AND JNS_PERAWATAN = "2"
				AND JENIS_DOKUMEN_ID = "44"
				AND NAMA_FILE = "' . $nama_file . '.pdf"') or die(mysql_error());
	mysql_query('INSERT INTO t_rm_dokumen_file(JENIS_DOKUMEN_ID,NOMR,RAWAT_ID,JNS_PERAWATAN,NAMA_FILE,ST_SISTEM,TANGGAL) 		
				VALUES("44","' . $nomr . '","' . $idx . '","2","' . $nama_file . '.pdf","1",STR_TO_DATE("' . $tgl_daftar . '","%d/%m/%Y"))') or die(mysql_error());
	
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