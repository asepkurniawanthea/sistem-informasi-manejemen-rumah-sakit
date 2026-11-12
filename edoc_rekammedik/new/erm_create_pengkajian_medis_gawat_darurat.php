<?php
function replace_newline($str){
	$ret = preg_replace('/\r|\n/','\n',trim($str));
	$ret = str_replace('\n','<br>',$ret);
	$ret = str_replace('<br><br>','<br>',$ret);
	return $ret;
}

function erm_pengkajian_medis_gawat_darurat($idx,$ls_assesment='',$tgl_skr='',$final=''){
	global $rmfile_path, $app_path;

	$checked = '<w:sym w:font="Wingdings" w:char="F0FE"/>';
    $unChecked = '<w:sym w:font="Wingdings" w:char="F0A8"/>';
	
	$templateklinik = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\pengkajian_medis_gawat_darurat.docx');
	
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

	$umur = getUmurDaftar($tgl_lahir,$tgl_daftar);
	
	$qry_pengkajian = 'SELECT IRJA_ID,TRIASE,
			DATE_FORMAT(PEMERIKSAAN_DOKTER_PUKUL,"%H") AS JAM_PEMERIKSAAN,
			DATE_FORMAT(PEMERIKSAAN_DOKTER_PUKUL,"%i") AS MENIT_PEMERIKSAAN,
			DATE_FORMAT(SELESAI_PUKUL,"%H") AS JAM_SELESAI,
			DATE_FORMAT(SELESAI_PUKUL,"%i") AS MENIT_SELESAI,
			SUBYEKTIF,OBYEKTIF,PEMERIKSAAN_PENUNJANG,ASSESMENT,PLANNING,
			DATE_FORMAT(TGL_ASSESMENT,"%d-%m-%Y %H:%i") AS TGL_ASSESMENT,
			m_pegawai.NAMA_PEGAWAI
			FROM t_igd_pengkajian_medis
			LEFT JOIN m_pegawai ON (t_igd_pengkajian_medis.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
			WHERE IRJA_ID = "' . $idx . '"';
	$get_pengkajian = mysql_query($qry_pengkajian) or die(mysql_error());
	$dat_pengkajian = mysql_fetch_assoc($get_pengkajian);
	$idx_pengkajian = $dat_pengkajian['IRJA_ID'];

	$jam_pemeriksaan = $dat_pengkajian['JAM_PEMERIKSAAN']; 
	$menit_pemeriksaan = $dat_pengkajian['MENIT_PEMERIKSAAN']; 

	$jam_selesai = $dat_pengkajian['JAM_SELESAI']; 
	$menit_selesai = $dat_pengkajian['MENIT_SELESAI']; 
	$nama_dokter = $dat_pengkajian['NAMA_PEGAWAI']; 
	$tgl_assesment = $dat_pengkajian['TGL_ASSESMENT']; 

	$triase = str_replace('|','"',$dat_pengkajian['TRIASE']);
	$triase = preg_replace('/\r|\n/','\n',trim($triase));
	$triase = json_decode($triase,true);

	$subyektif = str_replace('|','"',$dat_pengkajian['SUBYEKTIF']);
	$subyektif = preg_replace('/\r|\n/','\n',trim($subyektif));
	$subyektif = json_decode($subyektif,true);

	$obyektif = str_replace('|','"',$dat_pengkajian['OBYEKTIF']);
	$obyektif = preg_replace('/\r|\n/','\n',trim($obyektif));
	$obyektif = json_decode($obyektif,true);

	$pemeriksaan_penunjang = str_replace('|','"',$dat_pengkajian['PEMERIKSAAN_PENUNJANG']);
	$pemeriksaan_penunjang = preg_replace('/\r|\n/','\n',trim($pemeriksaan_penunjang));
	$pemeriksaan_penunjang = json_decode($pemeriksaan_penunjang,true);

	$assesment = str_replace('|','"',$dat_pengkajian['ASSESMENT']);
	$assesment = preg_replace('/\r|\n/','\n',trim($assesment));
	$assesment = json_decode($assesment,true);

	$planning = str_replace('|','"',$dat_pengkajian['PLANNING']);
	$planning = preg_replace('/\r|\n/','\n',trim($planning));
	$planning = json_decode($planning,true);
	
	$templateklinik->setValue('nomor_rm', formatNomr($nomr));
	$templateklinik->setValue('nama_pasien', htmlspecialchars($nama_pasien));
	$templateklinik->setValue('tgl_lahir', htmlspecialchars($tgl_lahir));
	$templateklinik->setValue('jenis_kelamin', htmlspecialchars($jns_kelamin));
	$templateklinik->setValue('unit', htmlspecialchars($nama_unit));
	$templateklinik->setValue('tgl_masuk', $pasien_masuk);
	$templateklinik->setValue('tgl_assesment', $tgl_assesment);
	$templateklinik->setValue('nama_dokter', htmlspecialchars($nama_dokter));
	$templateklinik->setValue('dicetak_oleh', '');
	
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
	
	$templateklinik->setValue('jam_pemeriksaan_dokter', htmlspecialchars($jam_pemeriksaan . ':' . $menit_pemeriksaan));
	
	$anamnesis_keluhan_utama = replace_newline($subyektif['keluhan']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($anamnesis_keluhan_utama);
	$templateklinik->setValue('keluhan_utama', $toOpenXML);
	
	$templateklinik->setValue('keadaan_umum', htmlspecialchars($obyektif['keadaan_umum']));
	$templateklinik->setValue('td', htmlspecialchars($obyektif['td']));
	$templateklinik->setValue('nadi', htmlspecialchars($obyektif['nadi']));
	$templateklinik->setValue('rr', htmlspecialchars($obyektif['rr']));
	$templateklinik->setValue('kepala', htmlspecialchars($obyektif['kepala']));
	$templateklinik->setValue('leher', htmlspecialchars($obyektif['leher']));
	$templateklinik->setValue('jantung', htmlspecialchars($obyektif['jantung']));
	$templateklinik->setValue('paru', htmlspecialchars($obyektif['paru']));
	$templateklinik->setValue('suhu', htmlspecialchars($obyektif['suhu']));
	$templateklinik->setValue('abdomen', htmlspecialchars($obyektif['abdomen']));
	$templateklinik->setValue('extremitas', htmlspecialchars($obyektif['extremitas']));
	$templateklinik->setValue('status_lokalis', htmlspecialchars($obyektif['status_lokalis']));
	
	$gcs = 'E : ' . $obyektif['gcs_e'] . ' M : ' . $obyektif['gcs_m'] . ' V : ' . $obyektif['gcs_v'];
	$templateklinik->setValue('gcs', htmlspecialchars($gcs));
	
	$pem_ekg = replace_newline($pemeriksaan_penunjang['ekg']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($pem_ekg);
	$templateklinik->setValue('pem_ekg', $toOpenXML);
	
	$pem_rad = replace_newline($pemeriksaan_penunjang['radiologi']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($pem_rad);
	$templateklinik->setValue('pem_rad', $toOpenXML);
	
	$pem_lab = replace_newline($pemeriksaan_penunjang['laboratorium']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($pem_lab);
	$templateklinik->setValue('pem_lab', $toOpenXML);
	
	$penatalaksanaan = replace_newline($planning['penatalaksanaan']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($penatalaksanaan);
	$templateklinik->setValue('penatalaksanaan', $toOpenXML);
	
	$pengobatan = replace_newline($planning['pengobatan']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($pengobatan);
	$templateklinik->setValue('pengobatan', $toOpenXML);
	
	$rencana_tindakan = replace_newline($planning['tindakan']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($rencana_tindakan);
	$templateklinik->setValue('rencana_tindakan', $toOpenXML);
	
	$konsultasi = replace_newline($planning['konsultasi']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($konsultasi);
	$templateklinik->setValue('konsultasi', $toOpenXML);
	
	$templateklinik->setValue('jam_selesai', htmlspecialchars($jam_selesai . ':' . $menit_selesai));
		
	$qry_diagnosa = 'SELECT DIAGNOSA_ORDER,DIAGNOSA
		FROM t_irja_diagnosa
		WHERE IRJA_ID = "' . $idx . '"
		AND DIAGNOSA_ORDER <= 3
		ORDER BY DIAGNOSA_ORDER';
	$get_diagnosa = mysql_query($qry_diagnosa) or die(mysql_error());
	$j_row = mysql_num_rows($get_diagnosa);
	if($j_row > 0){
		$templateklinik->cloneRow('dno', $j_row);
		$d=1;
		while($dat_diagnosa= mysql_fetch_array($get_diagnosa)){
			if($d==1) {
				$templateklinik->setValue('dno#' . $d,'');
				$templateklinik->setValue('dj#' . $d,':');
				$templateklinik->setValue('dhd#' . $d,'Diagnosa');
			}else{
				$templateklinik->setValue('dno#' . $d,'');
				$templateklinik->setValue('dj#' . $d,'');
				$templateklinik->setValue('dhd#' . $d,'');
			}		
		$templateklinik->setValue('dtx#' . $d,'- ' . htmlspecialchars($dat_diagnosa['DIAGNOSA']));
		$d++;
		}
	}else{
		$templateklinik->setValue('dno','');
		$templateklinik->setValue('dj',':');
		$templateklinik->setValue('dhd','Diagnosa');
		$templateklinik->setValue('dtx','');
	}		
	
	$qry_diagnosa = 'SELECT DIAGNOSA_ORDER,DIAGNOSA
		FROM t_irja_diagnosa
		WHERE IRJA_ID = "' . $idx . '"
		AND DIAGNOSA_ORDER >= 4
		ORDER BY DIAGNOSA_ORDER';
	$get_diagnosa = mysql_query($qry_diagnosa) or die(mysql_error());
	$j_row = mysql_num_rows($get_diagnosa);
	if($j_row > 0){
		$templateklinik->cloneRow('dni', $j_row);
		$d=1;
		while($dat_diagnosa= mysql_fetch_array($get_diagnosa)){
			if($d==1) {
				$templateklinik->setValue('dni#' . $d,'');
				$templateklinik->setValue('dk#' . $d,':');
				$templateklinik->setValue('dhe#' . $d,'Diagnosa Banding');
			}else{
				$templateklinik->setValue('dni#' . $d,'');
				$templateklinik->setValue('dk#' . $d,'');
				$templateklinik->setValue('dhe#' . $d,'');
			}		
			$templateklinik->setValue('dty#' . $d,'- ' . htmlspecialchars($dat_diagnosa['DIAGNOSA']));
		$d++;
		}
	}else{
		$templateklinik->setValue('dni','');
		$templateklinik->setValue('dk',':');
		$templateklinik->setValue('dhe','Diagnosa Banding');
		$templateklinik->setValue('dty','');
	}		
	
	if(!file_exists($rmfile_path . '/pdf/1/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/pdf/1/' . $nomr . '/' . $idx, 0700, true);
	}

	if(!file_exists($rmfile_path . '/doc/1/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/doc/1/' . $nomr . '/' . $idx, 0700, true);
	}
	
	$nama_file = $nomr . '_' . $idx . '_42';	
	/*
	if($final == '1' and $ls_assesment != $tgl_skr){
		$qry_rev = 'SELECT COUNT(FILE_ID) + 1 AS REV FROM t_rm_dokumen_file
			WHERE RAWAT_ID = "' . $idx . '"
			AND JNS_PERAWATAN = "1"
			AND JENIS_DOKUMEN_ID = "42"';
		$get_rev = mysql_query($qry_rev) or die(mysql_error());
		$dat_rev = mysql_fetch_assoc($get_rev);
		$nama_file .= '_' . $dat_rev['REV'];	
	}
	*/
	$templateklinik->saveAs($rmfile_path . '/doc/1/' . $nomr . '/' . $idx . '/' . $nama_file . '.docx');
	
	mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE RAWAT_ID = "' . $idx . '"
				AND JNS_PERAWATAN = "1"
				AND JENIS_DOKUMEN_ID = "42"
				AND NAMA_FILE = "' . $nama_file . '.pdf"') or die(mysql_error());
	mysql_query('INSERT INTO t_rm_dokumen_file(JENIS_DOKUMEN_ID,NOMR,RAWAT_ID,JNS_PERAWATAN,NAMA_FILE,ST_SISTEM,TANGGAL) 		
				VALUES("42","' . $nomr . '","' . $idx . '","1","' . $nama_file . '.pdf","1",STR_TO_DATE("' . $tgl_daftar . '","%d/%m/%Y"))') or die(mysql_error());
	
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