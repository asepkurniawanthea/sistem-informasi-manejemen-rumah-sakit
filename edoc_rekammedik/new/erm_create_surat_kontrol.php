<?php
function replace_newline($str){
	$ret = preg_replace('/\r|\n/','\n',trim($str));
	$ret = str_replace('\n','<br>',$ret);
	$ret = str_replace('<br><br>','<br>',$ret);
	return $ret;
}

function erm_surat_kontrol($idx,$rawat){
	global $rmfile_path, $app_path;

	$checked = '<w:sym w:font="Wingdings" w:char="F0FE"/>';
    $unChecked = '<w:sym w:font="Wingdings" w:char="F0A8"/>';
	
	$templateklinik = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\surat_kontrol.docx');
	
	if($rawat == '1'){
		$qry_pasien = 'SELECT t_irja.IRJA_ID,t_irja.NOMR,t_irja.PEGAWAI_ID,m_pegawai.NAMA_PEGAWAI,
				t_irja.ASAL_PASIEN_ID,t_irja.KET_ASAL_PASIEN,t_irja.UNIT_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				DATE_FORMAT(t_irja.PASIEN_MASUK,"%d-%m-%Y %H:%i") AS PASIEN_MASUK,t_irja.JENIS_BAYAR_ID,m_pasien.NO_TELEPON,
				DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_unit.NAMA_UNIT,t_irja.UNIT_ID,m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,
				m_kelurahan.NAMA_KELURAHAN,m_kecamatan.NAMA_KECAMATAN,
				m_kota.NAMA_KOTA
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
	if($rawat == '2'){
		$qry_pasien = 'SELECT t_irna.IRNA_ID AS IRJA_ID,t_irna.NOMR,t_irna.PEGAWAI_ID,m_pegawai.NAMA_PEGAWAI,
				NULL AS ASAL_PASIEN_ID,"" AS KET_ASAL_PASIEN,
				t_irna.RUANG_ID AS UNIT_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,
				m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				DATE_FORMAT(t_irna.PASIEN_MASUK,"%d-%m-%Y %H:%i") AS PASIEN_MASUK,
				t_irna.JENIS_BAYAR_ID,m_pasien.NO_TELEPON,
				DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_ruang.NAMA_RUANG AS NAMA_UNIT,m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,
				m_kelurahan.NAMA_KELURAHAN,m_kecamatan.NAMA_KECAMATAN,
				m_kota.NAMA_KOTA
				FROM t_irna
				INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
				WHERE t_irna.IRNA_ID = "' . $idx . '"';
	}	
	$get_pasien = mysql_query($qry_pasien);
	$dat_pasien = mysql_fetch_assoc($get_pasien);
	$nomr = $dat_pasien['NOMR'];
	$nama_pasien = $dat_pasien['NAMA_PASIEN'];
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

	$irja_id = $dat_pasien['IRJA_ID'];
	$pegawai_id = $dat_pasien['PEGAWAI_ID'];
	$asal_pasien_id = $dat_pasien['ASAL_PASIEN_ID'];
	$ket_asal_pasien = $dat_pasien['KET_ASAL_PASIEN'];
	$pasien_masuk = $dat_pasien['PASIEN_MASUK'];

	$no_telepon = $dat_pasien['NO_TELEPON'];
	$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];
	$nama_unit = $dat_pasien['NAMA_UNIT'];
	$nama_dokter = $dat_pasien['NAMA_PEGAWAI'];
	$unit_id = $dat_pasien['UNIT_ID'];

	$umur = getUmurDaftar($tgl_lahir,$tgl_daftar);
	
	if($rawat == '1'){
		$qry_transfer = 'SELECT IRJA_KONTROL_ID,PENERIMA,t_irja_kontrol.UNIT_ID,
			DATE_FORMAT(TGL_KONTROL,"%d-%m-%Y") AS TGL_KONTROL,
			TERAPI_PULANG,PANTANGAN,BOLEH_DILAKUKAN,
			TDK_BOLEH_DILAKUKAN,INSTRUKSI,
			DATE_FORMAT(TGL_ASSESMENT,"%d-%m-%Y %H:%i") AS TGL_ASSESMENT,
			m_unit.NAMA_UNIT
			FROM t_irja_kontrol
			LEFT JOIN m_unit
			ON (t_irja_kontrol.UNIT_ID = m_unit.UNIT_ID)
			WHERE IRJA_KONTROL_ID = "' . $idx . '"';
	}
	if($rawat == '2'){
		$qry_transfer = 'SELECT IRNA_KONTROL_ID,PENERIMA,t_irna_kontrol.UNIT_ID,
			DATE_FORMAT(TGL_KONTROL,"%d-%m-%Y") AS TGL_KONTROL,
			TERAPI_PULANG,PANTANGAN,BOLEH_DILAKUKAN,
			TDK_BOLEH_DILAKUKAN,INSTRUKSI,
			DATE_FORMAT(TGL_ASSESMENT,"%d-%m-%Y %H:%i") AS TGL_ASSESMENT,
			m_unit.NAMA_UNIT
			FROM t_irna_kontrol
			LEFT JOIN m_unit
			ON (t_irna_kontrol.UNIT_ID = m_unit.UNIT_ID)
			WHERE IRNA_KONTROL_ID = "' . $idx . '"';
	}	
	$get_transfer = mysql_query($qry_transfer) or die(mysql_error());
	$dat_transfer = mysql_fetch_assoc($get_transfer);
	$penerima = $dat_transfer['PENERIMA'];
	$unit_penerima = $dat_transfer['NAMA_UNIT'];
	$tgl_kontrol = $dat_transfer['TGL_KONTROL'];
	$terapi_pulang = $dat_transfer['TERAPI_PULANG'];
	$pantangan = $dat_transfer['PANTANGAN'];
	$boleh_dilakukan = $dat_transfer['BOLEH_DILAKUKAN'];
	$tdk_boleh_dilakukan = $dat_transfer['TDK_BOLEH_DILAKUKAN'];
	$instruksi = $dat_transfer['INSTRUKSI'];
	$tgl_assesment = $dat_transfer['TGL_ASSESMENT'];
		
	$templateklinik->setValue('nama_dokter', htmlspecialchars($nama_dokter));		
	$templateklinik->setValue('nomor_rm', formatNomr($nomr));	
	$templateklinik->setValue('nama_pasien', htmlspecialchars($nama_pasien));
	$templateklinik->setValue('tgl_lahir', $tgl_lahir);
	$templateklinik->setValue('jenis_kelamin', $jns_kelamin);
	$templateklinik->setValue('unit', htmlspecialchars($nama_unit));
	
	$templateklinik->setValue('penerima', htmlspecialchars($penerima));
	$templateklinik->setValue('unit_penerima', htmlspecialchars($unit_penerima));
	$templateklinik->setValue('no_telepon', htmlspecialchars($no_telepon));
		
	$templateklinik->setValue('tgl_kontrol', $tgl_kontrol);
	
	$alamat = replace_newline($alamat_pasien);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($alamat);
	$templateklinik->setValue('alamat', $toOpenXML);
	
	$terapi_pulang = replace_newline($terapi_pulang);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($terapi_pulang);
	$templateklinik->setValue('terapi_pulang', $toOpenXML);
	
	$instruksi = replace_newline($instruksi);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($instruksi);
	$templateklinik->setValue('instruksi', $toOpenXML);
	
	$pantangan = replace_newline($pantangan);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($pantangan);
	$templateklinik->setValue('pantangan', $toOpenXML);
	
	$boleh_dilakukan = replace_newline($boleh_dilakukan);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($boleh_dilakukan);
	$templateklinik->setValue('blh_dilakukan', $toOpenXML);
	
	$tdk_boleh_dilakukan = replace_newline($tdk_boleh_dilakukan);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($tdk_boleh_dilakukan);
	$templateklinik->setValue('tdk_blh_dilakukan', $toOpenXML);
	
	$diagnosa = '';
	if($rawat == '1'){
		$qry_diagnosa = 'SELECT DIAGNOSA_ORDER,DIAGNOSA
			FROM t_irja_diagnosa
			WHERE IRJA_ID = "' . $idx . '"
			AND DIAGNOSA_ORDER <= 3
			ORDER BY DIAGNOSA_ORDER';
	}
	if($rawat == '2'){
		$qry_diagnosa = 'SELECT DIAGNOSA_ORDER,DIAGNOSA
			FROM t_irna_diagnosa
			WHERE IRNA_ID = "' . $idx . '"
			AND DIAGNOSA_ORDER <= 3
			ORDER BY DIAGNOSA_ORDER';
	}	
	$get_diagnosa = mysql_query($qry_diagnosa) or die(mysql_error());
	while($dat_diagnosa= mysql_fetch_array($get_diagnosa)){
		$diagnosa .= $dat_diagnosa['DIAGNOSA'] . ','; 
	}		
	$templateklinik->setValue('diagnosa', htmlspecialchars(substr($diagnosa,0,strlen($diagnosa)-1)));
	
	$tanggal = '';
	$pukul = '';
	$arr_tgl_assesment = explode(' ',$tgl_assesment);
	if(sizeof($arr_tgl_assesment) == 2){
		$tanggal = $arr_tgl_assesment[0];
		$pukul = $arr_tgl_assesment[1];
	}	
	$templateklinik->setValue('tanggal', $tanggal);
	
	if(!file_exists($rmfile_path . '/pdf/' . $rawat . '/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/pdf/' . $rawat . '/' . $nomr . '/' . $idx, 0700, true);
	}

	if(!file_exists($rmfile_path . '/doc/' . $rawat . '/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/doc/' . $rawat . '/' . $nomr . '/' . $idx, 0700, true);
	}
	
	$nama_file = $nomr . '_' . $idx . '_47';	
	$templateklinik->saveAs($rmfile_path . '/doc/' . $rawat . '/' . $nomr . '/' . $idx . '/' . $nama_file . '.docx');
	
	mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE RAWAT_ID = "' . $idx . '"
				AND JNS_PERAWATAN = "' . $rawat . '"
				AND JENIS_DOKUMEN_ID = "47"
				AND NAMA_FILE = "' . $nama_file . '.pdf"') or die(mysql_error());
	mysql_query('INSERT INTO t_rm_dokumen_file(JENIS_DOKUMEN_ID,NOMR,RAWAT_ID,JNS_PERAWATAN,NAMA_FILE,ST_SISTEM,TANGGAL) 		
				VALUES("47","' . $nomr . '","' . $idx . '","' . $rawat . '","' . $nama_file . '.pdf","1",STR_TO_DATE("' . $tgl_daftar . '","%d/%m/%Y"))') or die(mysql_error());
	
	$source_file = $rmfile_path . '/doc/' . $rawat . '/' . $nomr . '/' . $idx . '/' . $nama_file . '.docx';			
	$source_file = str_replace('/','\\',$source_file);
	$target_file = $rmfile_path . '/pdf/' . $rawat . '/' . $nomr . '/' . $idx . '/' . $nama_file . '.pdf';
	$target_file = str_replace('/','\\',$target_file);
	
	try{
		$word = new COM("Word.Application") or die ("Could not initialise Object.");
		$word->Visible = 0;
		$word->DisplayAlerts = 0;
		$word->Documents->Open($source_file);
		if(file_exists($target_file)){
			unlink($target_file);
		}
		$word->ActiveDocument->ExportAsFixedFormat($target_file, 17, false, 0, 0, 0, 0, 7, true, true, 2, true, true, false);
		$word->Quit(false);
		unset($word);
	} catch (Exception $e) {
		echo $e;
	}
	
	$templateklinik2 = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\surat_kontrol_min.docx');
	$templateklinik2->setValue('nama_dokter', htmlspecialchars($nama_dokter));		
	$templateklinik2->setValue('nomor_rm', formatNomr($nomr));	
	$templateklinik2->setValue('nama_pasien', htmlspecialchars($nama_pasien));
	$templateklinik2->setValue('tgl_lahir', $tgl_lahir);
	$templateklinik2->setValue('jenis_kelamin', $jns_kelamin);
	
	$templateklinik2->setValue('penerima', htmlspecialchars($penerima));
	$templateklinik2->setValue('unit_penerima', htmlspecialchars($unit_penerima));
	$templateklinik2->setValue('umur', htmlspecialchars($umur));
	
	$alamat = replace_newline($alamat_pasien);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($alamat);
	$templateklinik2->setValue('alamat_pasien', $toOpenXML);
	
	$templateklinik2->setValue('diagnosa', htmlspecialchars(substr($diagnosa,0,strlen($diagnosa)-1)));
	$templateklinik2->setValue('no_telepon', htmlspecialchars($no_telepon));
	$templateklinik2->setValue('tgl_kontrol', $tgl_kontrol);
	$templateklinik2->setValue('tanggal', $tanggal);
	
	$nama_file = $nomr . '_' . $idx . '_48';	
	$templateklinik2->saveAs($rmfile_path . '/doc/' . $rawat . '/' . $nomr . '/' . $idx . '/' . $nama_file . '.docx');
	
	mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE RAWAT_ID = "' . $idx . '"
				AND JNS_PERAWATAN = "' . $rawat . '"
				AND JENIS_DOKUMEN_ID = "48"
				AND NAMA_FILE = "' . $nama_file . '.pdf"') or die(mysql_error());
	mysql_query('INSERT INTO t_rm_dokumen_file(JENIS_DOKUMEN_ID,NOMR,RAWAT_ID,JNS_PERAWATAN,NAMA_FILE,ST_SISTEM,TANGGAL) 		
				VALUES("48","' . $nomr . '","' . $idx . '","1","' . $nama_file . '.pdf","1",STR_TO_DATE("' . $tgl_daftar . '","%d/%m/%Y"))') or die(mysql_error());
	
	$source_file = $rmfile_path . '/doc/' . $rawat . '/' . $nomr . '/' . $idx . '/' . $nama_file . '.docx';			
	$source_file = str_replace('/','\\',$source_file);
	$target_file = $rmfile_path . '/pdf/' . $rawat . '/' . $nomr . '/' . $idx . '/' . $nama_file . '.pdf';
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