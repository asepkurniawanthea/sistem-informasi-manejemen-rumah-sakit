<?php
function replace_newline($str){
	$ret = preg_replace('/\r|\n/','\n',trim($str));
	$ret = str_replace('\n','<br>',$ret);
	$ret = str_replace('<br><br>','<br>',$ret);
	return $ret;
}

function erm_resume_medis($idx,$ls_assesment,$tgl_skr,$final){
	global $rmfile_path, $app_path;

	$checked = '<w:sym w:font="Wingdings" w:char="F0FE"/>';
    $unChecked = '<w:sym w:font="Wingdings" w:char="F0A8"/>';
	
	$templateklinik = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\resume_medis.docx');
	
	$qry_pasien = 'SELECT t_irja.NOMR,m_pasien.NAMA_PASIEN,
				DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				m_pegawai.NAMA_PEGAWAI AS DOKTER_PENGIRIM,m_pegawai2.NAMA_PEGAWAI AS DOKTER_MERAWAT,
				CONCAT(m_ruang.NAMA_RUANG," KELAS ",m_ruang.KELAS_RAWAT) AS NAMA_RUANG,
				DATE_FORMAT(t_irna.PASIEN_MASUK,"%d-%m-%Y %H:%i") AS PASIEN_MASUK,
				DATE_FORMAT(t_irna.PASIEN_KELUAR,"%d-%m-%Y %H:%i") AS PASIEN_KELUAR,
				DATE_FORMAT(t_irna.PASIEN_KELUAR,"%d-%m-%Y") AS PASIEN_KELUAR_2,
				DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_jaminan.NAMA_JAMINAN,m_pegawai3.NAMA_PEGAWAI AS DOKTER_RAWAT_1,
				m_pegawai4.NAMA_PEGAWAI AS DOKTER_RAWAT_2,m_pegawai5.NAMA_PEGAWAI AS DOKTER_RAWAT_3,
				DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d-%m-%Y") AS PASIEN_MASUK_RS,
				t_irja.UNIT_ID AS PASIEN_MASUK_UN
				FROM t_irja
				INNER JOIN t_irna ON (t_irja.IRJA_ID = t_irna.IRNA_ID)
				INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_irna.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai3 ON (t_irna.PEGAWAI_RAWAT_ID = m_pegawai3.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai4 ON (t_irna.PEGAWAI_RAWAT_ID_2 = m_pegawai4.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai5 ON (t_irna.PEGAWAI_RAWAT_ID_3 = m_pegawai5.PEGAWAI_ID)
				WHERE t_irja.IRJA_ID = "' . $idx . '"';
	$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
	$dat_pasien = mysql_fetch_assoc($get_pasien);
	$nomr = $dat_pasien['NOMR'];
	$nama_pasien = $dat_pasien['NAMA_PASIEN'];
	$tgl_lahir = $dat_pasien['TGL_LAHIR'];
	$jns_kelamin = jenisKelamin($dat_pasien['JNS_KELAMIN']);
	$jns_pembayaran = $dat_pasien['NAMA_JAMINAN'];
	$nama_ruang = $dat_pasien['NAMA_RUANG'];

	if(in_array($dat_pasien['PASIEN_MASUK_UN'],getArrUnitIGD())){
		$pasien_masuk = $dat_pasien['PASIEN_MASUK_RS'];
	}else{
		$pasien_masuk = $dat_pasien['PASIEN_MASUK'];
	}
	
	$pasien_keluar = $dat_pasien['PASIEN_KELUAR'];
	$pasien_keluar_2 = $dat_pasien['PASIEN_KELUAR_2'];

	$nama_ruang = $dat_pasien['NAMA_RUANG'];
	$nama_dokter_pengirim = $dat_pasien['DOKTER_PENGIRIM'];
	$nama_dokter_merawat = $dat_pasien['DOKTER_MERAWAT'];
	$tim_dokter_merawat_1 = $dat_pasien['DOKTER_RAWAT_1'];
	$tim_dokter_merawat_2 = $dat_pasien['DOKTER_RAWAT_2'];
	$tim_dokter_merawat_3 = $dat_pasien['DOKTER_RAWAT_3'];
	
	$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];

	$templateklinik->setValue('nomor_rm', formatNomr($nomr));
	$templateklinik->setValue('nama_pasien', htmlspecialchars($nama_pasien));
	$templateklinik->setValue('tgl_lahir', htmlspecialchars($tgl_lahir));
	$templateklinik->setValue('jenis_kelamin', htmlspecialchars($jns_kelamin));
	$templateklinik->setValue('nama_unit', htmlspecialchars($nama_ruang));
	$templateklinik->setValue('tgl_masuk', $pasien_masuk);
	$templateklinik->setValue('tgl_keluar', $pasien_keluar);
	$templateklinik->setValue('dokter_pengirim', htmlspecialchars($nama_dokter_pengirim));
	$templateklinik->setValue('dokter_merawat', htmlspecialchars($nama_dokter_merawat));
	$templateklinik->setValue('pembayaran', htmlspecialchars($jns_pembayaran));
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
	
	$qry_pengkajian = 'SELECT IRNA_ID,ALASAN_DIRAWAT,RINGKASAN_RIWAYAT_PENYAKIT,PEMERIKSAAN_FISIK,
			PEMERIKSAAN_PENUNJANG,TERAPI,TINDAKAN,
			HASIL_KONSULTASI,ALERGI,HASIL_LABORATORIUM,DIET,FOLLOW_UP,STATUS_KELUAR,TERAPI_PULANG,
			SIGNATUR,DATE_FORMAT(TGL_ASSESMENT,"%d-%m-%Y %H:%i") AS TGL_ASSESMENT,
			TIM_DOKTER,PEMERIKSAAN_LABORATORIUM,PEMERIKSAAN_RADIOLOGI,SEBAB_KEMATIAN,
			TRANSPORTASI_PULANG,TUJUAN_PULANG,
			REGISTER
			FROM t_irna_resume_medis_clm
			WHERE IRNA_ID = "' . $idx . '"';
	$get_pengkajian = mysql_query($qry_pengkajian) or die(mysql_error());
	$dat_pengkajian = mysql_fetch_assoc($get_pengkajian);
	$idx = $dat_pengkajian['IRNA_ID'];
	$alasan_dirawat = $dat_pengkajian['ALASAN_DIRAWAT'];
	$ringkasan_riwayat_penyakit = $dat_pengkajian['RINGKASAN_RIWAYAT_PENYAKIT'];
	$pemeriksaan_fisik = $dat_pengkajian['PEMERIKSAAN_FISIK'];
	$pemeriksaan_penunjang = $dat_pengkajian['PEMERIKSAAN_PENUNJANG'];
	$pemeriksaan_laboratorium = $dat_pengkajian['PEMERIKSAAN_LABORATORIUM'];
	$pemeriksaan_radiologi = $dat_pengkajian['PEMERIKSAAN_RADIOLOGI'];
	$terapi = $dat_pengkajian['TERAPI'];
	$hasil_konsultasi = $dat_pengkajian['HASIL_KONSULTASI'];
	$alergi = $dat_pengkajian['ALERGI'];
	$tindakan = $dat_pengkajian['TINDAKAN'];
	$hasil_laboratorium = $dat_pengkajian['HASIL_LABORATORIUM'];
	$diet = $dat_pengkajian['DIET'];
	$sebab_kematian = $dat_pengkajian['SEBAB_KEMATIAN'];
	$transportasi_pulang = $dat_pengkajian['TRANSPORTASI_PULANG'];
	$tujuan_pulang = $dat_pengkajian['TUJUAN_PULANG'];
	$follow_up = $dat_pengkajian['FOLLOW_UP'];
	$tim_dokter = $dat_pengkajian['TIM_DOKTER'];
	$terapi_pulang = $dat_pengkajian['TERAPI_PULANG'];
	$tgl_assesment = $dat_pengkajian['TGL_ASSESMENT'];
	$status_keluar = str_replace('|','"',$dat_pengkajian['STATUS_KELUAR']);
	$status_keluar = preg_replace('/\r|\n/','\n',trim($status_keluar));
	$status_keluar = json_decode($status_keluar,true);
	
	$keadaan_pulang = ((isset($status_keluar['keadaan'])) ? $status_keluar['keadaan'] : '');
	$lanjut_pengobatan = ((isset($status_keluar['lanjut'])) ? $status_keluar['lanjut'] : '');
	$lanjut_pengobatan_ket = ((isset($status_keluar['lanjut_ket'])) ? $status_keluar['lanjut_ket'] : '');
	$tgl_kontrol = ((isset($status_keluar['kontrol'])) ? $status_keluar['kontrol'] : '');
	
	$templateklinik->setValue('nama_dokter', htmlspecialchars($nama_dokter_merawat));
	if($tim_dokter == '1'){
		$templateklinik->setValue('timdokter_ya', $checked);
		$templateklinik->setValue('timdokter_tdk', $unChecked);
		$tim_dokter_oleh = '';
		if($tim_dokter_merawat_1 != '') $tim_dokter_oleh = $tim_dokter_merawat_1 . '<br>';
		if($tim_dokter_merawat_2 != '') $tim_dokter_oleh .= $tim_dokter_merawat_2 . '<br>';
		if($tim_dokter_merawat_3 != '') $tim_dokter_oleh .= $tim_dokter_merawat_3 . '<br>';
		
		$tim_dokter_oleh =  'Oleh :<br>' . substr($tim_dokter_oleh,0,strlen($tim_dokter_oleh)-4);
		$tim_dokter_oleh = replace_newline($tim_dokter_oleh);
		$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($tim_dokter_oleh);
		$templateklinik->setValue('timdokter_oleh', $toOpenXML);
	}else{
		$templateklinik->setValue('timdokter_ya', $unChecked);
		$templateklinik->setValue('timdokter_tdk', $checked);
		$templateklinik->setValue('timdokter_oleh', '');
	}

	if($transportasi_pulang == ''){
		$templateklinik->setValue('transportasi_ku', $unChecked);
		$templateklinik->setValue('transportasi_kp', $unChecked);
		$templateklinik->setValue('transportasi_ab', $unChecked);
	}
	if($transportasi_pulang == '1'){
		$templateklinik->setValue('transportasi_ku', $checked);
		$templateklinik->setValue('transportasi_kp', $unChecked);
		$templateklinik->setValue('transportasi_ab', $unChecked);
	}
	if($transportasi_pulang == '2'){
		$templateklinik->setValue('transportasi_ku', $unChecked);
		$templateklinik->setValue('transportasi_kp', $checked);
		$templateklinik->setValue('transportasi_ab', $unChecked);
	}	
	if($transportasi_pulang == '3'){
		$templateklinik->setValue('transportasi_ku', $unChecked);
		$templateklinik->setValue('transportasi_kp', $unChecked);
		$templateklinik->setValue('transportasi_ab', $checked);
	}
	
	if($tujuan_pulang == ''){
		$templateklinik->setValue('tujuan_pulang_ru', $unChecked);
		$templateklinik->setValue('tujuan_pulang_ys', $unChecked);
		$templateklinik->setValue('tujuan_pulang_lp', $unChecked);
	}
	if($tujuan_pulang == '1'){
		$templateklinik->setValue('tujuan_pulang_ru', $checked);
		$templateklinik->setValue('tujuan_pulang_ys', $unChecked);
		$templateklinik->setValue('tujuan_pulang_lp', $unChecked);
	}
	if($tujuan_pulang == '2'){
		$templateklinik->setValue('tujuan_pulang_ru', $unChecked);
		$templateklinik->setValue('tujuan_pulang_ys', $checked);
		$templateklinik->setValue('tujuan_pulang_lp', $unChecked);
	}	
	if($tujuan_pulang == '3'){
		$templateklinik->setValue('tujuan_pulang_ru', $unChecked);
		$templateklinik->setValue('tujuan_pulang_ys', $unChecked);
		$templateklinik->setValue('tujuan_pulang_lp', $checked);
	}
	
	$templateklinik->setValue('tgl_assesment', $pasien_keluar_2);
	
	$alasan_dirawat = replace_newline($alasan_dirawat);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($alasan_dirawat);
	$templateklinik->setValue('alasan_dirawat', $toOpenXML);
	
	$ringkasan_riwayat_penyakit = replace_newline($ringkasan_riwayat_penyakit);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($ringkasan_riwayat_penyakit);
	$templateklinik->setValue('ringkasan_riwayat_penyakit', $toOpenXML);
	
	$pemeriksaan_fisik = replace_newline($pemeriksaan_fisik);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($pemeriksaan_fisik);
	$templateklinik->setValue('pemeriksaan_fisik', $toOpenXML);
	
	$pemeriksaan_laboratorium = replace_newline($pemeriksaan_laboratorium);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($pemeriksaan_laboratorium);
	$templateklinik->setValue('pemeriksaan_laboratorium', $toOpenXML);
	
	$pemeriksaan_radiologi = replace_newline($pemeriksaan_radiologi);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($pemeriksaan_radiologi);
	$templateklinik->setValue('pemeriksaan_radiologi', $toOpenXML);
	
	$pemeriksaan_penunjang = replace_newline($pemeriksaan_penunjang);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($pemeriksaan_penunjang);
	$templateklinik->setValue('pemeriksaan_penunjang', $toOpenXML);
	
	$terapi = replace_newline($terapi);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($terapi);
	$templateklinik->setValue('terapi', $toOpenXML);
	
	$hasil_konsultasi = replace_newline($hasil_konsultasi);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($hasil_konsultasi);
	$templateklinik->setValue('hasil_konsultasi', $toOpenXML);
	
	$alergi = replace_newline($alergi);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($alergi);
	$templateklinik->setValue('alergi', $toOpenXML);
	
	$tindakan = replace_newline($tindakan);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($tindakan);
	$templateklinik->setValue('tindakan', $toOpenXML);
	
	$hasil_laboratorium = replace_newline($hasil_laboratorium);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($hasil_laboratorium);
	$templateklinik->setValue('hasil_laboratorium', $toOpenXML);
	
	$diet = replace_newline($diet);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($diet);
	$templateklinik->setValue('diet', $toOpenXML);
	
	$sebab_kematian = replace_newline($sebab_kematian);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($sebab_kematian);
	$templateklinik->setValue('sebab_kematian', $toOpenXML);
	
	$follow_up = replace_newline($follow_up);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($follow_up);
	$templateklinik->setValue('follow_up', $toOpenXML);
	
	$terapi_pulang = replace_newline($terapi_pulang);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($terapi_pulang);
	$templateklinik->setValue('terapi_pulang', $toOpenXML);
	
	$tgl_kontrol = replace_newline($tgl_kontrol);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($tgl_kontrol);
	$templateklinik->setValue('tanggal_kontrol', $toOpenXML);
	
	$qry_diagnosa = 'SELECT DIAGNOSA_ORDER,DIAGNOSA
		FROM t_irna_diagnosa_pulang_clm
		WHERE IRNA_ID = "' . $idx . '"
		AND DIAGNOSA_ORDER <= 3
		ORDER BY DIAGNOSA_ORDER';
	$get_diagnosa = mysql_query($qry_diagnosa) or die(mysql_error());
	$j_row = mysql_num_rows($get_diagnosa);
	if($j_row > 0){
		$templateklinik->cloneRow('dhd', $j_row);
		$d=1;
		while($dat_diagnosa= mysql_fetch_array($get_diagnosa)){
			if($d==1) {
				$templateklinik->setValue('dj#' . $d,':');
				$templateklinik->setValue('dhd#' . $d,'Diagnosa');
			}else{
				$templateklinik->setValue('dj#' . $d,'');
				$templateklinik->setValue('dhd#' . $d,'');
			}		
		$templateklinik->setValue('dtx#' . $d,'- ' . htmlspecialchars($dat_diagnosa['DIAGNOSA']));
		$d++;
		}
	}else{
		$templateklinik->setValue('dj',':');
		$templateklinik->setValue('dhd','Diagnosa');
		$templateklinik->setValue('dtx','');
	}		
	
	$qry_diagnosa = 'SELECT DIAGNOSA_ORDER,DIAGNOSA
		FROM t_irna_diagnosa_pulang_clm
		WHERE IRNA_ID = "' . $idx . '"
		AND DIAGNOSA_ORDER >= 4
		ORDER BY DIAGNOSA_ORDER';
	$get_diagnosa = mysql_query($qry_diagnosa) or die(mysql_error());
	$j_row = mysql_num_rows($get_diagnosa);
	if($j_row > 0){
		$templateklinik->cloneRow('dhe', $j_row);
		$d=1;
		while($dat_diagnosa= mysql_fetch_array($get_diagnosa)){
			if($d==1) {
				$templateklinik->setValue('dk#' . $d,':');
				$templateklinik->setValue('dhe#' . $d,'Diagnosa Banding');
			}else{
				$templateklinik->setValue('dk#' . $d,'');
				$templateklinik->setValue('dhe#' . $d,'');
			}		
			$templateklinik->setValue('dty#' . $d,'- ' . htmlspecialchars($dat_diagnosa['DIAGNOSA']));
		$d++;
		}
	}else{
		$templateklinik->setValue('dk',':');
		$templateklinik->setValue('dhe','Diagnosa Banding');
		$templateklinik->setValue('dty','');
	}	

	$keadaan_pulang_v = '';
	$qry_pulang = 'SELECT * FROM m_pasien_pulang WHERE IRNA = "1"';
	$get_pulang = mysql_query($qry_pulang) or die(mysql_error());
	while($dat_pulang = mysql_fetch_array($get_pulang)){
		if($keadaan_pulang == $dat_pulang['PASIEN_PULANG_ID']){
			$keadaan_pulang_v .= $checked . '&nbsp;' . $dat_pulang['KET_PASIEN_PULANG'] . '&nbsp;&nbsp;&nbsp;';
		}else{
			$keadaan_pulang_v .= $unChecked . '&nbsp;' . $dat_pulang['KET_PASIEN_PULANG'] . '&nbsp;&nbsp;&nbsp;';
		}
				
	}	
	
	$arr_lanjut_pengobatan = array('1'=>'Poliklinik',
						'2'=>'RS Lain',
						'3'=>'Puskesmas',
						'4'=>'Dokter Luar',
						'5'=>'');
	$lanjut_pengobatan_v = '';					
	foreach($arr_lanjut_pengobatan as $key => $value){
		if($lanjut_pengobatan == $key){
			if($value != ''){
				$lanjut_pengobatan_v .= $checked . '&nbsp;' . $value . '&nbsp;&nbsp;&nbsp;';
			}else{
				$lanjut_pengobatan_v .= $checked . '&nbsp;' . $lanjut_pengobatan_ket . '&nbsp;&nbsp;&nbsp;';
			}	
		}else{
			if($value != ''){
				$lanjut_pengobatan_v .= $unChecked . '&nbsp;' . $value . '&nbsp;&nbsp;&nbsp;';
			}else{
				$lanjut_pengobatan_v .= $unChecked . '&nbsp;' . $lanjut_pengobatan_ket . '&nbsp;&nbsp;&nbsp;';
			}	
		}
	}	
	
	$keadaan_pulang_v = replace_newline($keadaan_pulang_v);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($keadaan_pulang_v);
	$templateklinik->setValue('kondisi_keluar', $toOpenXML);
	
	$lanjut_pengobatan_v = replace_newline($lanjut_pengobatan_v);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($lanjut_pengobatan_v);
	$templateklinik->setValue('pengobatan_dilanjutkan', $toOpenXML);
	
	if(!file_exists($rmfile_path . '/pdf/2/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/pdf/2/' . $nomr . '/' . $idx, 0700, true);
	}

	if(!file_exists($rmfile_path . '/doc/2/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/doc/2/' . $nomr . '/' . $idx, 0700, true);
	}
	
	$nama_file = $nomr . '_' . $idx . '_68';	
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
				AND JENIS_DOKUMEN_ID = "68"
				AND NAMA_FILE = "' . $nama_file . '.pdf"') or die(mysql_error());
	mysql_query('INSERT INTO t_rm_dokumen_file(JENIS_DOKUMEN_ID,NOMR,RAWAT_ID,JNS_PERAWATAN,NAMA_FILE,ST_SISTEM,TANGGAL) 		
				VALUES("68","' . $nomr . '","' . $idx . '","2","' . $nama_file . '.pdf","1",STR_TO_DATE("' . $tgl_daftar . '","%d/%m/%Y"))') or die(mysql_error());
	
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