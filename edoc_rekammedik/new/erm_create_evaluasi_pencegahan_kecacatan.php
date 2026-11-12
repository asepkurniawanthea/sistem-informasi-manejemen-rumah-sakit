<?php
function erm_evaluasi_pencegahan_kecacatan($idx){
	global $rmfile_path, $app_path;

	$checked = '<w:sym w:font="Wingdings" w:char="F0FE"/>';
    $unChecked = '<w:sym w:font="Wingdings" w:char="F0A8"/>';
	
	$templateklinik = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\evaluasi_pencegahan_kecacatan.docx');
	
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
	$tgn_lahir = $dat_pasien['TGL_LAHIR'];
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
	$tgn_daftar = $dat_pasien['TANGGAL_DAFTAR'];
	$nama_unit = $dat_pasien['NAMA_UNIT'];
	$nama_dokter = $dat_pasien['NAMA_PEGAWAI'];

	$umur = getUmurDaftar($tgn_lahir,$tgn_daftar);
	
	$qry_pengkajian = 'SELECT IRJA_ID,TANGGAL,LAGOPHTHALMUS,ULNARIS,MEDIANUS,RADIALIS,OTOT_TANGAN,PERONEUS,TIBIALIS,OTOT_KAKI,
			KECACATAN_GBR,KECACATAN,
			DATE_FORMAT(TGL_ASSESMENT,"%d-%m-%Y %H:%i") AS TGL_ASSESMENT
			FROM t_irja_evaluasi_pencegahan_kecacatan
			WHERE IRJA_ID = "' . $idx . '"';
	$get_pengkajian = mysql_query($qry_pengkajian) or die(mysql_error());
	$dat_pengkajian = mysql_fetch_assoc($get_pengkajian);
	$idx = $dat_pengkajian['IRJA_ID'];
	
	$tanggal = str_replace('|','"',$dat_pengkajian['TANGGAL']);
	$tanggal = preg_replace('/\r|\n/','\n',trim($tanggal));
	$tanggal = json_decode($tanggal,true);
	
	$lagophthalmus = str_replace('|','"',$dat_pengkajian['LAGOPHTHALMUS']);
	$lagophthalmus = preg_replace('/\r|\n/','\n',trim($lagophthalmus));
	$lagophthalmus = json_decode($lagophthalmus,true);
	
	$ulnaris = str_replace('|','"',$dat_pengkajian['ULNARIS']);
	$ulnaris = preg_replace('/\r|\n/','\n',trim($ulnaris));
	$ulnaris = json_decode($ulnaris,true);
	
	$medianus = str_replace('|','"',$dat_pengkajian['MEDIANUS']);
	$medianus = preg_replace('/\r|\n/','\n',trim($medianus));
	$medianus = json_decode($medianus,true);
	
	$radialis = str_replace('|','"',$dat_pengkajian['RADIALIS']);
	$radialis = preg_replace('/\r|\n/','\n',trim($radialis));
	$radialis = json_decode($radialis,true);
	
	$otot_tangan = str_replace('|','"',$dat_pengkajian['OTOT_TANGAN']);
	$otot_tangan = preg_replace('/\r|\n/','\n',trim($otot_tangan));
	$otot_tangan = json_decode($otot_tangan,true);
	
	$poroneus = str_replace('|','"',$dat_pengkajian['PERONEUS']);
	$poroneus = preg_replace('/\r|\n/','\n',trim($poroneus));
	$poroneus = json_decode($poroneus,true);
	
	$tibialis = str_replace('|','"',$dat_pengkajian['TIBIALIS']);
	$tibialis = preg_replace('/\r|\n/','\n',trim($tibialis));
	$tibialis = json_decode($tibialis,true);
	
	$otot_kaki = str_replace('|','"',$dat_pengkajian['OTOT_KAKI']);
	$otot_kaki = preg_replace('/\r|\n/','\n',trim($otot_kaki));
	$otot_kaki = json_decode($otot_kaki,true);
	
	$kecacatan = str_replace('|','"',$dat_pengkajian['KECACATAN']);
	$kecacatan = preg_replace('/\r|\n/','\n',trim($kecacatan));
	$kecacatan = json_decode($kecacatan,true);
	
	$kecacatan_gbr = $dat_pengkajian['KECACATAN_GBR'];
	$tgn_assesment = $dat_pengkajian['TGL_ASSESMENT'];
	
	$templateklinik->setValue('nomor_rm', formatNomr($nomr));
	$templateklinik->setValue('nama_pasien', htmlspecialchars($nama_pasien));
	$templateklinik->setValue('tgl_lahir', htmlspecialchars($tgn_lahir));
	$templateklinik->setValue('jenis_kelamin', htmlspecialchars($jns_kelamin));
	$templateklinik->setValue('unit', htmlspecialchars($nama_unit));
	$templateklinik->setValue('tgl_masuk', $pasien_masuk);
	$templateklinik->setValue('tgl_assesment', $tgn_assesment);
	$templateklinik->setValue('nama_dokter', htmlspecialchars($nama_dokter));
	$templateklinik->setValue('dicetak_oleh', '');
	
	$templateklinik->setValue('tgl_1', htmlspecialchars($tanggal['01']));
	$templateklinik->setValue('tgl_2', htmlspecialchars($tanggal['02']));
	$templateklinik->setValue('tgl_3', htmlspecialchars($tanggal['03']));
	$templateklinik->setValue('tgl_4', htmlspecialchars($tanggal['04']));
	
	$templateklinik->setValue('lgp_1', htmlspecialchars($lagophthalmus['01']));
	$templateklinik->setValue('lgp_2', htmlspecialchars($lagophthalmus['02']));
	$templateklinik->setValue('lgp_3', htmlspecialchars($lagophthalmus['03']));
	$templateklinik->setValue('lgp_4', htmlspecialchars($lagophthalmus['04']));
	
	$templateklinik->setValue('uln_1', htmlspecialchars($ulnaris['01']));
	$templateklinik->setValue('uln_2', htmlspecialchars($ulnaris['02']));
	$templateklinik->setValue('uln_3', htmlspecialchars($ulnaris['03']));
	$templateklinik->setValue('uln_4', htmlspecialchars($ulnaris['04']));
	
	$templateklinik->setValue('mdn_1', htmlspecialchars($medianus['01']));
	$templateklinik->setValue('mdn_2', htmlspecialchars($medianus['02']));
	$templateklinik->setValue('mdn_3', htmlspecialchars($medianus['03']));
	$templateklinik->setValue('mdn_4', htmlspecialchars($medianus['04']));
	
	$templateklinik->setValue('rdl_1', htmlspecialchars($radialis['01']));
	$templateklinik->setValue('rdl_2', htmlspecialchars($radialis['02']));
	$templateklinik->setValue('rdl_3', htmlspecialchars($radialis['03']));
	$templateklinik->setValue('rdl_4', htmlspecialchars($radialis['04']));
	
	$templateklinik->setValue('tgn_1', htmlspecialchars($otot_tangan['01']));
	$templateklinik->setValue('tgn_2', htmlspecialchars($otot_tangan['02']));
	$templateklinik->setValue('tgn_3', htmlspecialchars($otot_tangan['03']));
	$templateklinik->setValue('tgn_4', htmlspecialchars($otot_tangan['04']));
	
	$templateklinik->setValue('prn_1', htmlspecialchars($poroneus['01']));
	$templateklinik->setValue('prn_2', htmlspecialchars($poroneus['02']));
	$templateklinik->setValue('prn_3', htmlspecialchars($poroneus['03']));
	$templateklinik->setValue('prn_4', htmlspecialchars($poroneus['04']));
	
	$templateklinik->setValue('pst_1', htmlspecialchars($tibialis['01']));
	$templateklinik->setValue('pst_2', htmlspecialchars($tibialis['02']));
	$templateklinik->setValue('pst_3', htmlspecialchars($tibialis['03']));
	$templateklinik->setValue('pst_4', htmlspecialchars($tibialis['04']));
	
	$templateklinik->setValue('kki_1', htmlspecialchars($otot_kaki['01']));
	$templateklinik->setValue('kki_2', htmlspecialchars($otot_kaki['02']));
	$templateklinik->setValue('kki_3', htmlspecialchars($otot_kaki['03']));
	$templateklinik->setValue('kki_4', htmlspecialchars($otot_kaki['04']));
	
	$templateklinik->setValue('cct_1', htmlspecialchars($kecacatan['01']));
	$templateklinik->setValue('cct_2', htmlspecialchars($kecacatan['02']));
	$templateklinik->setValue('cct_3', htmlspecialchars($kecacatan['03']));
	$templateklinik->setValue('cct_4', htmlspecialchars($kecacatan['04']));
	
	$gambar_path = $app_path . 'nsimrs\\edoc_rekammedik\\new\\pencegahan_kecacatan2.jpg';
	if(file_exists($rmfile_path . '\\pengkajian_awal_medik_kusta\\'. $nomr . '_1_epk_' . $idx . '.jpg')){
		$gambar_path = $rmfile_path . '\\pengkajian_awal_medik_kusta\\'. $nomr . '_1_epk_' . $idx . '.jpg';
	}
	$templateklinik->setImageValue('gambar', array('path' => $gambar_path, 'width' => 100, 'height' => 550, 'ratio' => true));
	
	if(!file_exists($rmfile_path . '/pdf/1/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/pdf/1/' . $nomr . '/' . $idx, 0700, true);
	}

	if(!file_exists($rmfile_path . '/doc/1/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/doc/1/' . $nomr . '/' . $idx, 0700, true);
	}
	
	$nama_file = $nomr . '_' . $idx . '_29';	
	$templateklinik->saveAs($rmfile_path . '/doc/1/' . $nomr . '/' . $idx . '/' . $nama_file . '.docx');
	
	mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE RAWAT_ID = "' . $idx . '"
				AND JNS_PERAWATAN = "1"
				AND JENIS_DOKUMEN_ID = "29"
				AND NAMA_FILE = "' . $nama_file . '.pdf"') or die(mysql_error());
	mysql_query('INSERT INTO t_rm_dokumen_file(JENIS_DOKUMEN_ID,NOMR,RAWAT_ID,JNS_PERAWATAN,NAMA_FILE,ST_SISTEM) 		
				VALUES("29","' . $nomr . '","' . $idx . '","1","' . $nama_file . '.pdf","1")') or die(mysql_error());
	
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