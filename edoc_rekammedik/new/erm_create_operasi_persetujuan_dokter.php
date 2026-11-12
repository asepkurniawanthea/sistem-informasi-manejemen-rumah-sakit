<?php
function replace_newline($str){
	$ret = preg_replace('/\r|\n/','\n',trim($str));
	$ret = str_replace('\n','<br>',$ret);
	$ret = str_replace('<br><br>','<br>',$ret);
	return $ret;
}

function erm_operasi_persetujuan_dokter($idx,$ls_assesment='',$tgl_skr='',$final=''){
	global $rmfile_path, $app_path;

	$checked = '<w:sym w:font="Wingdings" w:char="F0FE"/>';
    $unChecked = '<w:sym w:font="Wingdings" w:char="F0A8"/>';
	
	$templateklinik = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\persetujuan_tindakan_kedokteran.docx');
	
	$qry_pasien = 'SELECT t_irna.IRNA_ID,t_irna.NOMR,t_irna.PEGAWAI_ID,m_pegawai.NAMA_PEGAWAI,t_irna.RUANG_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
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

	$irja_id = $dat_pasien['IRNA_ID'];
	$pegawai_id = $dat_pasien['PEGAWAI_ID'];
	$pasien_masuk = $dat_pasien['PASIEN_MASUK'];

	$no_telepon = $dat_pasien['NO_TELEPON'];
	$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];
	$nama_unit = $dat_pasien['NAMA_RUANG'];
	$nama_dokter = $dat_pasien['NAMA_PEGAWAI'];

	$umur = getUmurDaftar($tgl_lahir,$tgl_daftar);
	
	$templateklinik->setValue('nomor_rm', formatNomr($nomr));
	$templateklinik->setValue('nama_pasien', htmlspecialchars($nama_pasien));
	$templateklinik->setValue('tgl_lahir', htmlspecialchars($tgl_lahir));
	$templateklinik->setValue('jenis_kelamin', htmlspecialchars($jns_kelamin));
	$templateklinik->setValue('unit', htmlspecialchars($nama_unit));
	$templateklinik->setValue('tgl_masuk', $pasien_masuk);
	$templateklinik->setValue('nama_dokter', htmlspecialchars($nama_dokter));
	$templateklinik->setValue('umr_p', htmlspecialchars($umur));
	$templateklinik->setValue('alamat_p', htmlspecialchars($alamat));
	
	$qry_persetujuan = 'SELECT PERSETUJUAN_DOKTER_ID,OPERASI_ID,DATE_FORMAT(TANGGAL_PERSETUJUAN,"%d-%m-%Y %H:%i") AS TGL_PERSETUJUAN,
						PEMBERI_INFORMASI,PENERIMA_INFORMASI,NAMA_PENERIMA_INFORMASI,HUB_KELUARGA,ALAMAT,JNS_KEL,UMUR,DIAG_WD_DD,DASAR_DIAG,
						TIND_DOKTER,TIND_DOKTER_SEKUNDER,INDIKASI_TINDK,TATA_CARA,TUJUAN,RESIKO,KOMPLIKASI,PRONOSIS,ALT_RESIKO,
						PENYELAMATAN_PASIEN,LAIN_LAIN,TIND_DOKTER1,PERSETUJUAN,SAKSI_1,SAKSI_2,USER_OPERASI,NAMA_PEGAWAI
						FROM t_operasi_persetujuan_dokter
						INNER JOIN m_pegawai ON (t_operasi_persetujuan_dokter.PEMBERI_INFORMASI = m_pegawai.PEGAWAI_ID)
						WHERE IRNA_ID = "' . $idx . '"';
	$get_persetujuan = mysql_query($qry_persetujuan) or die(mysql_error());
	$dat_persetujuan = mysql_fetch_assoc($get_persetujuan);
	$tata_cara=$dat_persetujuan['TATA_CARA'];
	$penyelamatan_pasien=$dat_persetujuan['PENYELAMATAN_PASIEN'];
	$setuju = explode('|',$dat_persetujuan['PERSETUJUAN']);
	//$setuju = str_replace('|','"',$dat_persetujuan['PERSETUJUAN']);
	//$setuju = preg_replace('/\r|\n/','\n',trim($setuju));
	//$setuju = json_decode($setuju,true);
	
	$idx = $dat_persetujuan['IRNA_ID'];

	$templateklinik->setValue('tgl_assesment', $dat_persetujuan['TGL_PERSETUJUAN']);
	$templateklinik->setValue('dicetak_oleh', '');
	$templateklinik->setValue('nama_perawat', htmlspecialchars($dat_persetujuan['NAMA_PEGAWAI']));
	$templateklinik->setValue('penerima_informasi', htmlspecialchars($dat_persetujuan['NAMA_PENERIMA_INFORMASI']));
	$templateklinik->setValue('diagnosis', htmlspecialchars($dat_persetujuan['DIAG_WD_DD']));
	$templateklinik->setValue('dasar_diagnosis',htmlspecialchars($dat_persetujaun['DASAR_DIAG']));
	$templateklinik->setValue('tindakan_kedokteran', htmlspecialchars($dat_persetujaun['TIND_DOKTER']));
	$templateklinik->setValue('tindakan_kedokteran_sekunder', htmlspecialchars($dat_persetujaun['TIND_DOKTER_SEKUNDER']));
	$templateklinik->setValue('indikasi_tindakan', htmlspecialchars($dat_persetujuan['INDIKASI_TINDK']));
	$templateklinik->setValue('setuju', htmlspecialchars($setuju));

	if($tata_cara == '1'){
		$templateklinik->setValue('sedasi',$checked);
		$templateklinik->setValue('uraian',$unChecked);
	}else if($tata_cara == '2'){
		$templateklinik->setValue('sedasi',$unChecked);
		$templateklinik->setValue('uraian',$checked);
	}	
	
	$templateklinik->setValue('tujuan', htmlspecialchars($dat_persetujuan['TUJUAN']));
	$templateklinik->setValue('resiko', htmlspecialchars($dat_persetujuan['RESIKO']));
	$templateklinik->setValue('komplikasi', htmlspecialchars($dat_persetujuan['KOMPLIKASI']));
	$templateklinik->setValue('pronosis', htmlspecialchars($dat_persetujuan['PRONOSIS']));
	
	if($alt_resiko['alt_resiko']=='1'){
		$templateklinik->setValue('alt_resiko',$checked);
	}else{
		$templateklinik->setValue('alt_resiko',$unChecked);
	}

	if($penyelamatan_pasien=='1'){
		$templateklinik->setValue('perluasan',$checked);
		$templateklinik->setValue('konsultasi',$unChecked);
		$templateklinik->setValue('resusitasi',$unChecked);
	}else if($penyelamatan_pasien=='2'){
		$templateklinik->setValue('perluasan',$unChecked);
		$templateklinik->setValue('konsultasi',$checked);
		$templateklinik->setValue('resusitasi',$unChecked);
	}else if($penyelamatan_pasien=='3'){
		$templateklinik->setValue('perluasan',$unChecked);
		$templateklinik->setValue('konsultasi',$unChecked);
		$templateklinik->setValue('resusitasi',$checked);
	}

	$templateklinik->setValue('lain_lain', htmlspecialchars($dat_persetujuan['LAIN_LAIN']));
	$templateklinik->setValue('umur', htmlspecialchars($dat_persetujuan['umur']));
	
	if($dat_persetujuan['JNS_KEL']=='L'){
		$templateklinik->setValue('jns_kelamin', 'Laki-laki');
	}else{
		$templateklinik->setValue('jns_kelamin','Perempuan');
	}
	
	$templateklinik->setValue('alamat', htmlspecialchars($dat_persetujuan['ALAMAT']));
	$templateklinik->setValue('hub_keluarga', htmlspecialchars($dat_persetujuan['HUB_KELUARGA']));
	$templateklinik->setValue('saksi_1', htmlspecialchars($dat_persetujuan['SAKSI_1']));
	$templateklinik->setValue('saksi_2', htmlspecialchars($dat_persetujuan['SAKSI_2']));
		
	if($setuju['setuju'] == '1'){
		$templateklinik->setValue('setuju',$checked);
	}else{
		$templateklinik->setValue('setuju',$unChecked);
	}		
	

	if(!file_exists($rmfile_path . '/pdf/2/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/pdf/2/' . $nomr . '/' . $idx, 0700, true);
	}

	if(!file_exists($rmfile_path . '/doc/2/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/doc/2/' . $nomr . '/' . $idx, 0700, true);
	}
	
	$nama_file = $nomr . '_' . $idx . '_69';	
	/*
	if($final == '1' and $ls_assesment != $tgl_skr){
		$qry_rev = 'SELECT COUNT(FILE_ID) + 1 AS REV FROM t_rm_dokumen_file
			WHERE RAWAT_ID = "' . $idx . '"
			AND JNS_PERAWATAN = "1"
			AND JENIS_DOKUMEN_ID = "25"';
		$get_rev = mysql_query($qry_rev) or die(mysql_error());
		$dat_rev = mysql_fetch_assoc($get_rev);
		$nama_file .= '_' . $dat_rev['REV'];	
	}
	*/
	$templateklinik->saveAs($rmfile_path . '/doc/2/' . $nomr . '/' . $idx . '/' . $nama_file . '.docx');
	
	mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE RAWAT_ID = "' . $idx . '"
				AND JNS_PERAWATAN = "2"
				AND JENIS_DOKUMEN_ID = "69"
				AND NAMA_FILE = "' . $nama_file . '.pdf"') or die(mysql_error());
	mysql_query('INSERT INTO t_rm_dokumen_file(JENIS_DOKUMEN_ID,NOMR,RAWAT_ID,JNS_PERAWATAN,NAMA_FILE,ST_SISTEM,TANGGAL) 		
				VALUES("69","' . $nomr . '","' . $idx . '","2","' . $nama_file . '.pdf","1",STR_TO_DATE("' . $tgl_daftar . '","%d/%m/%Y"))') or die(mysql_error());
	
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