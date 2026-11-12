<?php
function replace_newline($str){
	$ret = preg_replace('/\r|\n/','\n',trim($str));
	$ret = str_replace('\n','<br>',$ret);
	$ret = str_replace('<br><br>','<br>',$ret);
	return $ret;
}

function erm_pemeriksaan_mcu_jiwa($idx){
	global $rmfile_path, $app_path;

	$checked = '<w:sym w:font="Wingdings" w:char="F0FE"/>';
    $unChecked = '<w:sym w:font="Wingdings" w:char="F0A8"/>';
	
	$templateklinik = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\surat_keterangan-pemeriksaan_jiwa.docx');
	
	$qry_pasien = 'SELECT t_irja.IRJA_ID,t_irja.NOMR,t_irja.PEGAWAI_ID,m_pegawai.NAMA_PEGAWAI,
				t_irja.ASAL_PASIEN_ID,t_irja.KET_ASAL_PASIEN,t_irja.UNIT_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				DATE_FORMAT(t_irja.PASIEN_MASUK,"%d-%m-%Y %H:%i") AS PASIEN_MASUK,t_irja.JENIS_BAYAR_ID,m_pasien.NO_TELEPON,
				DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_unit.NAMA_UNIT,t_irja.UNIT_ID,m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,
				m_kelurahan.NAMA_KELURAHAN,m_kecamatan.NAMA_KECAMATAN,
				m_kota.NAMA_KOTA,m_pasien.TMP_LAHIR,m_agama.NAMA_AGAMA,m_pasien.ST_KAWIN,
				m_pegawai.NIP,m_pegawai.SIP,m_pegawai_tipe.KET_TIPE_PEGAWAI,
				m_pendidikan.NAMA_PENDIDIKAN,m_pasien.PEKERJAAN
				FROM t_irja
				INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
				LEFT JOIN m_agama ON (m_pasien.AGAMA_ID = m_agama.AGAMA_ID)
				LEFT JOIN m_pegawai_tipe ON (m_pegawai.TIPE_PEGAWAI_ID = m_pegawai_tipe.TIPE_PEGAWAI_ID)
				LEFT JOIN m_pendidikan ON (m_pasien.PENDIDIKAN_ID = m_pendidikan.PENDIDIKAN_ID)
				WHERE t_irja.IRJA_ID = "' . $idx . '"';			
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
	$jabatan = $dat_pasien['KET_TIPE_PEGAWAI'];
	
	$agama = $dat_pasien['NAMA_AGAMA'];
	$pendidikan = $dat_pasien['NAMA_PENDIDIKAN'];
	$pekerjaan = $dat_pasien['PEKERJAAN'];
	
	$st_kawin[''] = '';
	$st_kawin['1'] = 'Belum Kawin';
	$st_kawin['2'] = 'Kawin';
	$st_kawin['3'] = 'Janda/ Duda';
	$kawin = $st_kawin[$dat_pasien['ST_KAWIN']];

	$umur = getUmurDaftar($tgl_lahir,$tgl_daftar);
	$nip = $dat_pasien['NIP'];
	$sip = $dat_pasien['SIP'];
	
	$templateklinik->setValue('nama_pasien', htmlspecialchars($nama_pasien));
	$templateklinik->setValue('tmp_lahir', htmlspecialchars($tmp_lahir));
	$templateklinik->setValue('tgl_lahir', $tgl_lahir);
	$templateklinik->setValue('jns_kelamin', $jns_kelamin);
	$templateklinik->setValue('alamat', htmlspecialchars($alamat_pasien));
	if($alamat_pasien_rt != ''){
		$templateklinik->setValue('alamat_rt', htmlspecialchars('RT. ' . $alamat_pasien_rt . 'RW. ' . $alamat_pasien_rw));
	}	
	$templateklinik->setValue('alamat_kelurahan', htmlspecialchars($kelurahan));
	$templateklinik->setValue('alamat_kec', htmlspecialchars($kecamatan));
	$templateklinik->setValue('alamat_kota', htmlspecialchars($kota));
	
	$templateklinik->setValue('agama', htmlspecialchars($agama));
	$templateklinik->setValue('st_kawin', htmlspecialchars($kawin));
	$templateklinik->setValue('pendidikan', htmlspecialchars($pendidikan));
	$templateklinik->setValue('pekerjaan', htmlspecialchars($pekerjaan));
	
	$templateklinik->setValue('nama_dokter', htmlspecialchars($nama_dokter));
	$templateklinik->setValue('nip', $nip);
	$templateklinik->setValue('sip', $sip);
	$templateklinik->setValue('jabatan', $jabatan);	
	
	$qry_transfer = 'SELECT IRJA_MCU_ID,PEM_PSIKOPATOLOGI,PEM_KEPRIBADIAN,PEM_KECERDASAN,PEM_FUNGSI_EKSEKUTIF,NOMOR,KEPERLUAN,
			REGISTER,DATE_FORMAT(TGL_ASSESMENT,"%d-%m-%Y") AS TGL_ASSESMENT,
			DAYNAME(TGL_ASSESMENT) AS HARI
			FROM t_irja_pemeriksaan_mcu_jiwa
			WHERE IRJA_MCU_ID = "' . $idx . '"';		
	$get_transfer = mysql_query($qry_transfer) or die(mysql_error());
	$dat_transfer = mysql_fetch_assoc($get_transfer);
	$pem_psikopatologi = $dat_transfer['PEM_PSIKOPATOLOGI'];
	$pem_kepribadian = $dat_transfer['PEM_KEPRIBADIAN'];
	$pem_kecerdasan = $dat_transfer['PEM_KECERDASAN'];
	$pem_fungsi_eksekutif = $dat_transfer['PEM_FUNGSI_EKSEKUTIF'];
	$nomor = $dat_transfer['NOMOR'];
	$keperluan = $dat_transfer['KEPERLUAN'];
	$nama_hari = $dat_transfer['HARI'];
	
	$tgl_assesment = $dat_transfer['TGL_ASSESMENT'];
	
	$templateklinik->setValue('keperluan', htmlspecialchars($keperluan));
	$templateklinik->setValue('nomor', htmlspecialchars($nomor));	
	$templateklinik->setValue('kecerdasan', htmlspecialchars($pem_kecerdasan));	
	
	if($pem_psikopatologi == '1'){
		$templateklinik->setValue('psi_ditemukan', 'DITEMUKAN');	
		$templateklinik->setValue('psi_ditemukan_2', '');	
		$templateklinik->setValue('psi_tdk_ditemukan', '');	
		$templateklinik->setValue('psi_tdk_ditemukan_2', 'TIDAK DITEMUKAN');	
	}

	if($pem_psikopatologi == '2'){
		$templateklinik->setValue('psi_ditemukan', '');	
		$templateklinik->setValue('psi_ditemukan_2', 'DITEMUKAN');	
		$templateklinik->setValue('psi_tdk_ditemukan', 'TIDAK DITEMUKAN');	
		$templateklinik->setValue('psi_tdk_ditemukan_2', '');	
	}

	if($pem_kepribadian == '1'){
		$templateklinik->setValue('kpr_ditemukan', 'DITEMUKAN');	
		$templateklinik->setValue('kpr_ditemukan_2', '');	
		$templateklinik->setValue('kpr_tdk_ditemukan', '');	
		$templateklinik->setValue('kpr_tdk_ditemukan_2', 'TIDAK DITEMUKAN');	
	}

	if($pem_kepribadian == '2'){
		$templateklinik->setValue('kpr_ditemukan', '');	
		$templateklinik->setValue('kpr_ditemukan_2', 'DITEMUKAN');	
		$templateklinik->setValue('kpr_tdk_ditemukan', 'TIDAK DITEMUKAN');	
		$templateklinik->setValue('kpr_tdk_ditemukan_2', '');	
	}

	if($pem_fungsi_eksekutif == '1'){
		$templateklinik->setValue('eks_ditemukan', 'DITEMUKAN');	
		$templateklinik->setValue('eks_ditemukan_2', '');	
		$templateklinik->setValue('eks_tdk_ditemukan', '');	
		$templateklinik->setValue('eks_tdk_ditemukan_2', 'TIDAK DITEMUKAN');	
	}

	if($pem_fungsi_eksekutif == '2'){
		$templateklinik->setValue('eks_ditemukan', '');	
		$templateklinik->setValue('eks_ditemukan_2', 'DITEMUKAN');	
		$templateklinik->setValue('eks_tdk_ditemukan', 'TIDAK DITEMUKAN');	
		$templateklinik->setValue('eks_tdk_ditemukan_2', '');	
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
	$templateklinik->setValue('tanggal', $hari . ' ' . $bulan[$arr_tgl_assesment[1]] . ' ' . $arr_tgl_assesment[2]);
	
	if(strtolower($nama_hari) == 'monday') $nama_hari = 'Senin';
	if(strtolower($nama_hari) == 'tuesday') $nama_hari = 'Selasa';
	if(strtolower($nama_hari) == 'wednesday') $nama_hari = 'Rabu';
	if(strtolower($nama_hari) == 'thursday') $nama_hari = 'Kamis';
	if(strtolower($nama_hari) == 'friday') $nama_hari = 'Jumat';
	if(strtolower($nama_hari) == 'saturday') $nama_hari = 'Sabtu';
	if(strtolower($nama_hari) == 'sunday') $nama_hari = 'Minggu';
	$templateklinik->setValue('nama_hari', $nama_hari);
	
	if(!file_exists($rmfile_path . '/pdf/1/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/pdf/1/' . $nomr . '/' . $idx, 0700, true);
	}

	if(!file_exists($rmfile_path . '/doc/1/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/doc/1/' . $nomr . '/' . $idx, 0700, true);
	}
	
	$nama_file = $nomr . '_' . $idx . '_58';	
	$templateklinik->saveAs($rmfile_path . '/doc/1/' . $nomr . '/' . $idx . '/' . $nama_file . '.docx');
	
	mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE RAWAT_ID = "' . $idx . '"
				AND JNS_PERAWATAN = "1"
				AND JENIS_DOKUMEN_ID = "58"
				AND NAMA_FILE = "' . $nama_file . '.pdf"') or die(mysql_error());
	mysql_query('INSERT INTO t_rm_dokumen_file(JENIS_DOKUMEN_ID,NOMR,RAWAT_ID,JNS_PERAWATAN,NAMA_FILE,ST_SISTEM,TANGGAL) 		
				VALUES("58","' . $nomr . '","' . $idx . '","1","' . $nama_file . '.pdf","1",STR_TO_DATE("' . $tgl_daftar . '","%d/%m/%Y"))') or die(mysql_error());
	
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