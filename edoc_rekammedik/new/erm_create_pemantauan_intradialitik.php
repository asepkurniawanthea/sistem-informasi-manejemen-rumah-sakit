<?php
function replace_newline($str){
	$ret = preg_replace('/\r|\n/','\n',trim($str));
	$ret = str_replace('\n','<br>',$ret);
	$ret = str_replace('<br><br>','<br>',$ret);
	return $ret;
}

function erm_pemantauan_intradialitik($idx,$jns_order,$idxord){
	global $rmfile_path, $app_path;

	$checked = '<w:sym w:font="Wingdings" w:char="F0FE"/>';
    $unChecked = '<w:sym w:font="Wingdings" w:char="F0A8"/>';
	
	$jns_perawatan = '1';
	if($jns_order == 'IRN') $jns_perawatan = '2'; 
	
	$templateklinik = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\pemantauan_intradialitik.docx');
	
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
	
	$templateklinik->setValue('nomor_rm', formatNomr($nomr));
	$templateklinik->setValue('nama_pasien', htmlspecialchars($nama_pasien));
	$templateklinik->setValue('tgl_lahir', htmlspecialchars($tgl_lahir));
	$templateklinik->setValue('jenis_kelamin', htmlspecialchars($jns_kelamin));
	$templateklinik->setValue('tgl_masuk', $pasien_masuk);
	$templateklinik->setValue('nama_dokter', htmlspecialchars($nama_dokter));
	$templateklinik->setValue('dicetak_oleh', '');
	
	if($jns_order == ''){
		$qry_pemantauan = 'SELECT PEMANTAUAN_ID,
					PRA_HEMODIALISA,
					DATE_FORMAT(JAM,"%d/%m/%Y") AS TANGGAL,
					DATE_FORMAT(JAM,"%H") AS JAM,
					DATE_FORMAT(JAM,"%i") AS MENIT,
					KELUHAN,
					BB_TB,
					KESADARAN,
					TEKANAN_DARAH,
					NAFAS_NADI,
					SUHU,
					QB,
					QD,
					TEKANAN_VENA,
					TMP,
					VOLUME_YANG_DITARIK,
					ASSESMENT,
					NAMA_PEGAWAI,
					DATE_FORMAT(TGL_ASSESMENT,"%d/%m/%Y") AS TGL_ASSESMENT
				FROM t_irja_pemantauan_intradialitik
				LEFT JOIN m_pegawai ON (t_irja_pemantauan_intradialitik.PERAWAT = m_pegawai.PEGAWAI_ID)	
				WHERE IRJA_ID = "' . $idx . '"
				ORDER BY JAM';
	}else{			
		$qry_pemantauan = 'SELECT PEMANTAUAN_ID,
					PRA_HEMODIALISA,
					DATE_FORMAT(JAM,"%d/%m/%Y") AS TANGGAL,
					DATE_FORMAT(JAM,"%H") AS JAM,
					DATE_FORMAT(JAM,"%i") AS MENIT,
					KELUHAN,
					BB_TB,
					KESADARAN,
					TEKANAN_DARAH,
					NAFAS_NADI,
					SUHU,
					QB,
					QD,
					TEKANAN_VENA,
					TMP,
					VOLUME_YANG_DITARIK,
					ASSESMENT,
					NAMA_PEGAWAI,
					DATE_FORMAT(TGL_ASSESMENT,"%d/%m/%Y") AS TGL_ASSESMENT	
				FROM t_hemodialisa_pemantauan_intradialitik 
				LEFT JOIN m_pegawai ON (t_hemodialisa_pemantauan_intradialitik.PERAWAT = m_pegawai.PEGAWAI_ID)
				WHERE HEMODIALISA_ID = "' . $idx . '"
				ORDER BY JAM';
	}			
	$get_pemantauan = mysql_query($qry_pemantauan) or die(mysql_error());
	$arr_jam = array();
	$arr_keluhan = array();
	$arr_bb = array();
	$arr_kesadaran = array();
	$arr_tek_darah = array();
	$arr_nafas = array();
	$arr_suhu = array();
	$arr_qb = array();
	$arr_qd = array();
	$arr_tek_vena = array();
	$arr_tmp = array();
	$arr_volume = array();
	$arr_asesmen = array();
	$arr_perawat = array();
	$tgl_assesment = '';
	$x = 0;
	while($dat_pemantauan = mysql_fetch_array($get_pemantauan)){
		$arr_jam[$x] = $dat_pemantauan['JAM'] . ':' . $dat_pemantauan['MENIT'];
		$arr_keluhan[$x] = $dat_pemantauan['KELUHAN'];
		$arr_bb[$x] = $dat_pemantauan['BB_TB'];
		$arr_kesadaran[$x] = $dat_pemantauan['KESADARAN'];
		$arr_tek_darah[$x] = $dat_pemantauan['TEKANAN_DARAH'];
		$arr_nafas[$x] = $dat_pemantauan['NAFAS_NADI'];
		$arr_suhu[$x] = $dat_pemantauan['SUHU'];
		$arr_qb[$x] = $dat_pemantauan['QB'];
		$arr_qd[$x] = $dat_pemantauan['QD'];
		$arr_tek_vena[$x] = $dat_pemantauan['TEKANAN_VENA'];
		$arr_tmp[$x] = $dat_pemantauan['TMP'];
		$arr_volume[$x] = $dat_pemantauan['VOLUME_YANG_DITARIK'];
		$arr_asesmen[$x] = $dat_pemantauan['ASSESMENT'];
		$arr_perawat[$x] = $dat_pemantauan['NAMA_PEGAWAI'];
		$tgl_assesment = $dat_pemantauan['TGL_ASSESMENT'];
		$x++;	
	}
	
	$i = 0;
	while($i < 7){
		if(isset($arr_jam[$i])){
			$templateklinik->setValue('jm' . $i, htmlspecialchars($arr_jam[$i]));
		}else{
			$templateklinik->setValue('jm' . $i, '');
		}

		if(isset($arr_keluhan[$i])){
			$templateklinik->setValue('kl' . $i, htmlspecialchars($arr_keluhan[$i]));
		}else{
			$templateklinik->setValue('kl' . $i, '');
		}

		if(isset($arr_bb[$i])){
			$templateklinik->setValue('bb' . $i, htmlspecialchars($arr_bb[$i]));
		}else{
			$templateklinik->setValue('bb' . $i, '');
		}

		if(isset($arr_kesadaran[$i])){
			$templateklinik->setValue('ks' . $i, htmlspecialchars($arr_kesadaran[$i]));
		}else{
			$templateklinik->setValue('ks' . $i, '');
		}
		
		if(isset($arr_tek_darah[$i])){
			$templateklinik->setValue('td' . $i, htmlspecialchars($arr_tek_darah[$i]));
		}else{
			$templateklinik->setValue('td' . $i, '');
		}
		
		if(isset($arr_nafas[$i])){
			$templateklinik->setValue('nf' . $i, htmlspecialchars($arr_nafas[$i]));
		}else{
			$templateklinik->setValue('nf' . $i, '');
		}
		
		if(isset($arr_suhu[$i])){
			$templateklinik->setValue('sh' . $i, htmlspecialchars($arr_suhu[$i]));
		}else{
			$templateklinik->setValue('sh' . $i, '');
		}
		
		if(isset($arr_qb[$i])){
			$templateklinik->setValue('qb' . $i, htmlspecialchars($arr_qb[$i]));
		}else{
			$templateklinik->setValue('qb' . $i, '');
		}
		
		if(isset($arr_qd[$i])){
			$templateklinik->setValue('qd' . $i, htmlspecialchars($arr_qd[$i]));
		}else{
			$templateklinik->setValue('qd' . $i, '');
		}
		
		if(isset($arr_tek_vena[$i])){
			$templateklinik->setValue('tv' . $i, htmlspecialchars($arr_tek_vena[$i]));
		}else{
			$templateklinik->setValue('tv' . $i, '');
		}
		
		if(isset($arr_tmp[$i])){
			$templateklinik->setValue('tp' . $i, htmlspecialchars($arr_tmp[$i]));
		}else{
			$templateklinik->setValue('tp' . $i, '');
		}
		
		if(isset($arr_volume[$i])){
			$templateklinik->setValue('vl' . $i, htmlspecialchars($arr_volume[$i]));
		}else{
			$templateklinik->setValue('vl' . $i, '');
		}
		
		if(isset($arr_asesmen[$i])){
			$templateklinik->setValue('as' . $i, htmlspecialchars($arr_asesmen[$i]));
		}else{
			$templateklinik->setValue('as' . $i, '');
		}
		
		if(isset($arr_perawat[$i])){
			$templateklinik->setValue('pr' . $i, htmlspecialchars($arr_perawat[$i]));
		}else{
			$templateklinik->setValue('pr' . $i, '');
		}
		
		$i++;
	}
	
	if($jns_order == ''){
	$sql_posthd = 'SELECT IRJA_ID AS HEMODIALISA_ID,BB,UFG,KTV,OBAT,TINDAKAN_HD_BERIKUTNYA,RENCANA_KONSULTASI,RENCANA_PEMERIKSAAN_PENUNJANG,RENCANA_LAIN
			FROM t_irja_post_hd_dan_perencanaan_pulang
			WHERE IRJA_ID = "' . $idx . '"';
	}else{
		$sql_posthd = 'SELECT HEMODIALISA_ID,BB,UFG,KTV,OBAT,TINDAKAN_HD_BERIKUTNYA,RENCANA_KONSULTASI,RENCANA_PEMERIKSAAN_PENUNJANG,RENCANA_LAIN
			FROM t_hemodialisa_post_hd_dan_perencanaan_pulang
			WHERE HEMODIALISA_ID = "' . $idx . '"';
	}	
	$get_posthd = mysql_query($sql_posthd) or die(mysql_error());
	$dat_posthd = mysql_fetch_assoc($get_posthd);
	$perencanaan_id = $dat_posthd['HEMODIALISA_ID'];
	$bb = $dat_posthd['BB'];
	$ufg = $dat_posthd['UFG'];
	$ktv = $dat_posthd['KTV'];
	$obat = $dat_posthd['OBAT'];	
	$hd_berikut = $dat_posthd['TINDAKAN_HD_BERIKUTNYA'];	
	$konsultasi = $dat_posthd['RENCANA_KONSULTASI'];	
	$penunjang = $dat_posthd['RENCANA_PEMERIKSAAN_PENUNJANG'];	
	$rencana_lain = $dat_posthd['RENCANA_LAIN'];
	
	$templateklinik->setValue('bb_post_hd', htmlspecialchars($bb));
	$templateklinik->setValue('ufg', htmlspecialchars($ufg));
	$templateklinik->setValue('ktv', htmlspecialchars($ktv));
	$templateklinik->setValue('obat', htmlspecialchars($obat));
	$templateklinik->setValue('hd_berikut', htmlspecialchars($hd_berikut));
	$templateklinik->setValue('konsultasi', htmlspecialchars($konsultasi));
	$templateklinik->setValue('penunjang', htmlspecialchars($penunjang));
	$templateklinik->setValue('rencana_lain', htmlspecialchars($rencana_lain));
	
	$templateklinik->setValue('tgl_assesment', $tgl_assesment);
	
	if(!file_exists($rmfile_path . '/pdf/' . $jns_perawatan . '/' . $nomr . '/' . $idxord)){
		@mkdir($rmfile_path . '/pdf/' . $jns_perawatan . '/' . $nomr . '/' . $idxord, 0700, true);
	}

	if(!file_exists($rmfile_path . '/doc/' . $jns_perawatan . '/' . $nomr . '/' . $idxord)){
		@mkdir($rmfile_path . '/doc/' . $jns_perawatan . '/' . $nomr . '/' . $idxord, 0700, true);
	}
	
	$nama_file = $nomr . '_' . $idxord . $idx . '_33';	
	$templateklinik->saveAs($rmfile_path . '/doc/' . $jns_perawatan . '/' . $nomr . '/' . $idxord . '/' . $nama_file . '.docx');
	
	mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE RAWAT_ID = "' . $idxord . '"
				AND JNS_PERAWATAN = "' . $jns_perawatan . '"
				AND JENIS_DOKUMEN_ID = "33"
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
				VALUES("33",
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