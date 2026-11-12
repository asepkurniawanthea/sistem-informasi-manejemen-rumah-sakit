<?php
function replace_newline($str){
	$ret = preg_replace('/\r|\n/','\n',trim($str));
	$ret = str_replace('\n','<br>',$ret);
	$ret = str_replace('<br><br>','<br>',$ret);
	return $ret;
}

function erm_tindakan_hemodialisa($idx,$tarif_id,$jns_order,$idxord){
	global $rmfile_path, $app_path;
	
	$jns_perawatan = '1';
	if($jns_order == 'IRN') $jns_perawatan = '2'; 
	
	$templateklinik = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\tindakan_rawat_jalan.docx');
	
	if($jns_order == ''){
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
	}else{
		$qry_pasien = 'SELECT t_hemodialisa.HEMODIALISA_ID AS IRJA_ID,t_hemodialisa.NOMR,
				t_hemodialisa.PEGAWAI_PERIKSA_ID AS PEGAWAI_ID,m_pegawai.NAMA_PEGAWAI,
				"" AS ASAL_PASIEN_ID,"" AS KET_ASAL_PASIEN,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,m_pasien.JNS_KELAMIN,
				m_pasien.ALAMAT,m_pasien.NIK,
				DATE_FORMAT(t_hemodialisa.PASIEN_MASUK,"%d-%m-%Y %H:%i") AS PASIEN_MASUK,t_hemodialisa.JENIS_BAYAR_ID,
				m_pasien.NO_TELEPON,
				DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				"Hemodialisa" AS NAMA_UNIT
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
	$nama_unit = $dat_pasien['NAMA_UNIT'];
	$nama_dokter = $dat_pasien['NAMA_PEGAWAI'];

	$umur = getUmurDaftar($tgl_lahir,$tgl_daftar);
	
	$templateklinik->setValue('nomor_rm', formatNomr($nomr));
	$templateklinik->setValue('nama_pasien', htmlspecialchars($nama_pasien));
	$templateklinik->setValue('tgl_lahir', htmlspecialchars($tgl_lahir));
	$templateklinik->setValue('jenis_kelamin', htmlspecialchars($jns_kelamin));
	$templateklinik->setValue('unit', htmlspecialchars($nama_unit));
	$templateklinik->setValue('tgl_masuk', $pasien_masuk);
	$templateklinik->setValue('nama_dokter', htmlspecialchars($nama_dokter));
	$templateklinik->setValue('dicetak_oleh', '');
	
	if($jns_order == ''){
		$sql_tindakan = 'SELECT m_tarif.NAMA_TARIF,t_irja_tarif.HASIL_DIAGNOSA,
			m_tarif.KODE_TARIF_GROUP 
			FROM t_irja_tarif
			INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
			WHERE t_irja_tarif.IRJA_TARIF_ID = "' . $tarif_id . '"';
	}else{
		$sql_tindakan = 'SELECT m_tarif.NAMA_TARIF,t_hemodialisa_tarif.HASIL_DIAGNOSA,
			m_tarif.KODE_TARIF_GROUP 
			FROM t_hemodialisa_tarif
			INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
			WHERE t_hemodialisa_tarif.HEMODIALISA_TARIF_ID = "' . $tarif_id . '"';
	}		
	$get_tindakan = mysql_query($sql_tindakan) or die(mysql_error());	
	$dat_tindakan = mysql_fetch_assoc($get_tindakan);
	
	$hasil = replace_newline($dat_tindakan['HASIL_DIAGNOSA']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($hasil);
	$templateklinik->setValue('hasil_tindakan', $toOpenXML);
	
	$nama_tindakan = $dat_tindakan['NAMA_TARIF'];
	if(in_array($dat_tindakan['KODE_TARIF_GROUP'],array('02','09','93'))) $nama_tindakan = 'Konsultasi';
	$templateklinik->setValue('nama_tindakan', htmlspecialchars(strtoupper($nama_tindakan)));
	
	if(!file_exists($rmfile_path . '/pdf/' . $jns_perawatan . '/' . $nomr . '/' . $idxord)){
		@mkdir($rmfile_path . '/pdf/' . $jns_perawatan . '/' . $nomr . '/' . $idxord, 0700, true);
	}

	if(!file_exists($rmfile_path . '/doc/' . $jns_perawatan . '/' . $nomr . '/' . $idxord)){
		@mkdir($rmfile_path . '/doc/' . $jns_perawatan . '/' . $nomr . '/' . $idxord, 0700, true);
	}
	
	$nama_file = $nomr . '_' . $idxord . $idx . $tarif_id . '_38';	
	$templateklinik->saveAs($rmfile_path . '/doc/' . $jns_perawatan . '/' . $nomr . '/' . $idxord . '/' . $nama_file . '.docx');
	
	mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE RAWAT_ID = "' . $idxord . '"
				AND JNS_PERAWATAN = "' . $jns_perawatan . '"
				AND JENIS_DOKUMEN_ID = "38"
				' . (($jns_order != '') ? 'AND ORDER_PENUNJANG = "' . $idx . '-' . $tarif_id . '"' : 
				'AND ORDER_PENUNJANG = "' . $tarif_id . '"') . '
				AND NAMA_FILE = "' . $nama_file . '.pdf"') or die(mysql_error());
	mysql_query('INSERT INTO t_rm_dokumen_file(JENIS_DOKUMEN_ID,
				NOMR,RAWAT_ID,
				JNS_PERAWATAN,
				ORDER_PENUNJANG,
				NAMA_FILE,
				ST_SISTEM,
				TANGGAL,
				NAMA_PENUNJANG) 		
				VALUES("38",
				"' . $nomr . '",
				"' . $idxord . '",
				"1",
				' . (($jns_order != '') ? '"' . $idx . '-' . $tarif_id . '"' : '"' . $tarif_id . '"') . ',
				"' . $nama_file . '.pdf",
				"1",
				STR_TO_DATE("' . $tgl_daftar . '","%d/%m/%Y"),
				"' . $nama_tindakan . '")') or die(mysql_error());
	
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