<?php
function replace_newline($str){
	$ret = preg_replace('/\r|\n/','\n',trim($str));
	$ret = str_replace('\n','<br>',$ret);
	$ret = str_replace('<br><br>','<br>',$ret);
	return $ret;
}

function erm_pemeriksaan_sitopatologi($idx){
	global $rmfile_path, $app_path;

	$checked = '<w:sym w:font="Wingdings" w:char="F0FE"/>';
    $unChecked = '<w:sym w:font="Wingdings" w:char="F0A8"/>';
	
	$templateklinik = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\pemeriksaan_histopatologi.docx');
	
	$qry_pasien = 'SELECT t_irna.IRNA_ID,t_irna.NOMR,t_irna.PEGAWAI_ID,m_pegawai.NAMA_PEGAWAI,
				t_irna.RUANG_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,
				m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				DATE_FORMAT(t_irna.PASIEN_MASUK,"%d-%m-%Y %H:%i") AS PASIEN_MASUK,t_irna.JENIS_BAYAR_ID,m_pasien.NO_TELEPON,
				DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_ruang.NAMA_RUANG,m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,
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
	$get_pasien = mysql_query($qry_pasien);
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

	$irja_id = $dat_pasien['IRNA_ID'];
	$pegawai_id = $dat_pasien['PEGAWAI_ID'];
	$pasien_masuk = $dat_pasien['PASIEN_MASUK'];

	$no_telepon = $dat_pasien['NO_TELEPON'];
	$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];
	$nama_unit = $dat_pasien['NAMA_RUANG'];
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
	
	$templateklinik->setValue('nama_pasien', htmlspecialchars($nama_pasien));
	
	$arr_umur = explode('tahun',$umur);
	$templateklinik->setValue('umur', $arr_umur[0] . ' tahun  /' . $jns_kelamin);
	$templateklinik->setValue('nomor_rm', formatNomr($nomr));
	
	$qry_transfer = 'SELECT IRNA_ID,BANGSA,NO_SEDIAAN,TGL_DITERIMA,NAMA_DOKTER,NAMA_BAGIAN,NAMA_RS,
			ALAMAT_RS,BERASAL_DARI,DIAGNOSA_KLINIK,PEM_HISTOPATOLOGI_TGL,PEM_HISTOPATOLOGI_NO,
			PEM_HISTOPATOLOGI_DI,KETERANGAN,DIAGNOSA_GBR,
			REGISTER,DATE_FORMAT(TGL_ASSESMENT,"%d-%m-%Y") AS TGL_ASSESMENT,
			NAMA_PEGAWAI
			FROM t_irna_pemeriksaan_sitopatologi
			INNER JOIN m_pegawai ON (t_irna_pemeriksaan_sitopatologi.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
			WHERE IRNA_ID = "' . $idx . '"';		
	$get_transfer = mysql_query($qry_transfer) or die(mysql_error());
	$dat_transfer = mysql_fetch_assoc($get_transfer);
	$no_sediaan = $dat_transfer['NO_SEDIAAN'];
	$tgl_diterima = $dat_transfer['TGL_DITERIMA'];
	
	$nama_dokter = $dat_transfer['NAMA_PEGAWAI'];
	$templateklinik->setValue('nama_dokter_sitanala', htmlspecialchars($nama_dokter));
		
	$nama_bagian = $dat_transfer['NAMA_BAGIAN'];
	$berasal_dari = $dat_transfer['BERASAL_DARI'];
	$diagnosa_klinik = $dat_transfer['DIAGNOSA_KLINIK'];
	$pem_histopatologi_tgl = $dat_transfer['PEM_HISTOPATOLOGI_TGL'];
	$pem_histopatologi_no = $dat_transfer['PEM_HISTOPATOLOGI_NO'];
	$pem_histopatologi_di = $dat_transfer['PEM_HISTOPATOLOGI_DI'];
	$keterangan = $dat_transfer['KETERANGAN'];
	$bangsa = $dat_transfer['BANGSA'];
	
	$tgl_assesment = $dat_transfer['TGL_ASSESMENT'];
	
	$templateklinik->setValue('nomor_sediaan', htmlspecialchars($no_sediaan));
	$templateklinik->setValue('tgl_diterima', htmlspecialchars($tgl_diterima));
	$templateklinik->setValue('nama_dokter', htmlspecialchars($nama_dokter));
	$templateklinik->setValue('bagian', htmlspecialchars($nama_bagian));
	$templateklinik->setValue('rs', htmlspecialchars('RSUP. Dr. Sitanala'));
	$templateklinik->setValue('alamat', htmlspecialchars('Jl. DR. Sitanala No.99, Karang Sari, Kec. Neglasari, Kota Tangerang, Banten 15121'));
	$templateklinik->setValue('suku', htmlspecialchars($bangsa));
	
	$berasal_dari = replace_newline($berasal_dari);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($berasal_dari);
	$templateklinik->setValue('berasal_dari', $toOpenXML);
	
	$diagnosa_klinik = replace_newline($diagnosa_klinik);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($diagnosa_klinik);
	$templateklinik->setValue('diagnosa_klinik', $toOpenXML);
	
	$keterangan = replace_newline($keterangan);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($keterangan);
	$templateklinik->setValue('keterangan', $toOpenXML);
	
	if($pem_histopatologi_tgl != ''){
		$templateklinik->setValue('tgl_pemeriksaan_sitopatologi', htmlspecialchars($pem_histopatologi_tgl));
	}else{
		$templateklinik->setValue('tgl_pemeriksaan_sitopatologi', '.........');
	}

	if($pem_histopatologi_no != ''){
		$templateklinik->setValue('nomor', htmlspecialchars($pem_histopatologi_no));
	}else{
		$templateklinik->setValue('nomor', '.........');
	}	
	
	if($pem_histopatologi_di != ''){
		$templateklinik->setValue('di', htmlspecialchars($pem_histopatologi_di));
	}else{
		$templateklinik->setValue('di', '.........');
	}
	
	$bulan['01'] = 'Januari';
	$bulan['02'] = 'Februari';
	$bulan['03'] = 'Maret';
	$bulan['04'] = 'April';
	$bulan['05'] = 'Mei';
	$bulan['06'] = 'Juni';
	$bulan['07'] = 'Juli';
	$bulan['08'] = 'Agustus';
	$bulan['09'] = 'September';
	$bulan['10'] = 'Oktober';
	$bulan['11'] = 'Nopember';
	$bulan['12'] = 'Desember';
	
	$arr_tgl_assesment = explode('-',$tgl_assesment);
	$hari = $arr_tgl_assesment[0] * 1;
	$templateklinik->setValue('tgl_periksa', $hari . ' ' . $bulan[$arr_tgl_assesment[1]] . ' ' . $arr_tgl_assesment[2]);
	
	$gambar_path = $app_path . 'nsimrs\\edoc_rekammedik\\new\\pemeriksaan_histopatologi.jpg';
	if(file_exists($rmfile_path . '\\pemeriksaan_histopatologi\\'. $nomr . '_2_his_' . $idx . '.jpg')){
		$gambar_path = $rmfile_path . '\\pemeriksaan_histopatologi\\'. $nomr . '_2_his_' . $idx . '.jpg';
	}
	$templateklinik->setImageValue('gambar', array('path' => $gambar_path, 'width' => 500, 'height' => 750, 'ratio' => true));
	
	if(!file_exists($rmfile_path . '/pdf/2/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/pdf/2/' . $nomr . '/' . $idx, 0700, true);
	}

	if(!file_exists($rmfile_path . '/doc/2/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/doc/2/' . $nomr . '/' . $idx, 0700, true);
	}
	
	$nama_file = $nomr . '_' . $idx . '_62';	
	echo $rmfile_path . '/doc/2/' . $nomr . '/' . $idx . '/' . $nama_file . '.docx' . "\n";
	$templateklinik->saveAs($rmfile_path . '/doc/2/' . $nomr . '/' . $idx . '/' . $nama_file . '.docx');
	
	mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE RAWAT_ID = "' . $idx . '"
				AND JNS_PERAWATAN = "2"
				AND JENIS_DOKUMEN_ID = "62"
				AND NAMA_FILE = "' . $nama_file . '.pdf"') or die(mysql_error());
	mysql_query('INSERT INTO t_rm_dokumen_file(JENIS_DOKUMEN_ID,NOMR,RAWAT_ID,JNS_PERAWATAN,NAMA_FILE,ST_SISTEM,TANGGAL) 		
				VALUES("62","' . $nomr . '","' . $idx . '","2","' . $nama_file . '.pdf","1",STR_TO_DATE("' . $tgl_daftar . '","%d/%m/%Y"))') or die(mysql_error());
	
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