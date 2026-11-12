<?php
function replace_newline($str){
	$ret = preg_replace('/\r|\n/','\n',trim($str));
	$ret = str_replace('\n','<br>',$ret);
	$ret = str_replace('<br><br>','<br>',$ret);
	return $ret;
}

function erm_pemeriksaan_mcu($idx){
	global $rmfile_path, $app_path;

	$checked = '<w:sym w:font="Wingdings" w:char="F0FE"/>';
    $unChecked = '<w:sym w:font="Wingdings" w:char="F0A8"/>';
	
	$templateklinik = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\pemeriksaan_mcu.docx');
	
	$qry_pasien = 'SELECT t_irja.IRJA_ID,t_irja.NOMR,t_irja.PEGAWAI_ID,m_pegawai.NAMA_PEGAWAI,
				t_irja.ASAL_PASIEN_ID,t_irja.KET_ASAL_PASIEN,t_irja.UNIT_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				DATE_FORMAT(t_irja.PASIEN_MASUK,"%d-%m-%Y %H:%i") AS PASIEN_MASUK,t_irja.JENIS_BAYAR_ID,m_pasien.NO_TELEPON,
				DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_unit.NAMA_UNIT,t_irja.UNIT_ID,m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,
				m_kelurahan.NAMA_KELURAHAN,m_kecamatan.NAMA_KECAMATAN,
				m_kota.NAMA_KOTA,m_pasien.TMP_LAHIR,m_agama.NAMA_AGAMA,m_pasien.ST_KAWIN,
				m_pegawai.NIP,m_pegawai.SIP
				FROM t_irja
				INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
				LEFT JOIN m_agama ON (m_pasien.AGAMA_ID = m_agama.AGAMA_ID)
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
	$templateklinik->setValue('status_kawin', htmlspecialchars($kawin));
	
	$templateklinik->setValue('nama_dokter', htmlspecialchars($nama_dokter));
	$templateklinik->setValue('nip', $nip);
	$templateklinik->setValue('sip', $sip);
	
	$qry_transfer = 'SELECT IRJA_MCU_ID,NOMOR,KELUHAN,RIWAYAT_PENYAKIT,RIWAYAT_PENYAKIT_KELUARGA,PEMERIKSAAN_FISIK,
			PEMERIKSAAN_FISIK_KEPALA,PEMERIKSAAN_FISIK_THORAX,PEMERIKSAAN_FISIK_ABDOMEN,PEMERIKSAAN_FISIK_EKSTRIMITAS,
			PEMERIKSAAN_LABORATORIUM,PEMERIKSAAN_KARDIOLOGI,PEMERIKSAAN_RADIOLOGI,PEMERIKSAAN_MATA,
			PEMERIKSAAN_LAIN,RESUME,KESIMPULAN,CATATAN,
			REGISTER,DATE_FORMAT(TGL_ASSESMENT,"%d-%m-%Y") AS TGL_ASSESMENT
			FROM t_irja_pemeriksaan_mcu
			WHERE IRJA_MCU_ID = "' . $idx . '"';		
	$get_transfer = mysql_query($qry_transfer) or die(mysql_error());
	$dat_transfer = mysql_fetch_assoc($get_transfer);
	$nomor = $dat_transfer['NOMOR'];
	$keluhan = $dat_transfer['KELUHAN'];
	$riwayat_penyakit_dahulu = $dat_transfer['RIWAYAT_PENYAKIT'];
	$riwayat_penyakit_keluarga = $dat_transfer['RIWAYAT_PENYAKIT_KELUARGA'];

	$pemeriksaan_fisik = str_replace('|','"',$dat_transfer['PEMERIKSAAN_FISIK']);
	$pemeriksaan_fisik = preg_replace('/\r|\n/','\n',trim($pemeriksaan_fisik));
	$pemeriksaan_fisik = json_decode($pemeriksaan_fisik,true);

	$pemeriksaan_kepala = str_replace('|','"',$dat_transfer['PEMERIKSAAN_FISIK_KEPALA']);
	$pemeriksaan_kepala = preg_replace('/\r|\n/','\n',trim($pemeriksaan_kepala));
	$pemeriksaan_kepala = json_decode($pemeriksaan_kepala,true);

	$pemeriksaan_thorax = str_replace('|','"',$dat_transfer['PEMERIKSAAN_FISIK_THORAX']);
	$pemeriksaan_thorax = preg_replace('/\r|\n/','\n',trim($pemeriksaan_thorax));
	$pemeriksaan_thorax = json_decode($pemeriksaan_thorax,true);

	$pemeriksaan_abdomen = str_replace('|','"',$dat_transfer['PEMERIKSAAN_FISIK_ABDOMEN']);
	$pemeriksaan_abdomen = preg_replace('/\r|\n/','\n',trim($pemeriksaan_abdomen));
	$pemeriksaan_abdomen = json_decode($pemeriksaan_abdomen,true);

	$pemeriksaan_ekstremitas = str_replace('|','"',$dat_transfer['PEMERIKSAAN_FISIK_EKSTRIMITAS']);
	$pemeriksaan_ekstremitas = preg_replace('/\r|\n/','\n',trim($pemeriksaan_ekstremitas));
	$pemeriksaan_ekstremitas = json_decode($pemeriksaan_ekstremitas,true);

	$pemeriksaan_laboratorium = str_replace('|','"',$dat_transfer['PEMERIKSAAN_LABORATORIUM']);
	$pemeriksaan_laboratorium = preg_replace('/\r|\n/','\n',trim($pemeriksaan_laboratorium));
	$pemeriksaan_laboratorium = json_decode($pemeriksaan_laboratorium,true);

	$pem_kardiologi = $dat_transfer['PEMERIKSAAN_KARDIOLOGI'];
	$pem_radiologi = $dat_transfer['PEMERIKSAAN_RADIOLOGI'];
	$pem_mata = $dat_transfer['PEMERIKSAAN_MATA'];
	$pem_lain = $dat_transfer['PEMERIKSAAN_LAIN'];

	$resume = $dat_transfer['RESUME'];
	$kesimpulan = $dat_transfer['KESIMPULAN'];
	$catatan = $dat_transfer['CATATAN'];
	
	$tgl_assesment = $dat_transfer['TGL_ASSESMENT'];
	
	$templateklinik->setValue('nomor', htmlspecialchars($nomor));
	$templateklinik->setValue('keluhan', htmlspecialchars($keluhan));
	$templateklinik->setValue('riwayat_penyakit_dahulu', htmlspecialchars($riwayat_penyakit_dahulu));
	$templateklinik->setValue('riwayat_penyakit_keluarga', htmlspecialchars($riwayat_penyakit_keluarga));
	
	$templateklinik->setValue('pm_keadaan_umum', htmlspecialchars(((isset($pemeriksaan_fisik['pm_keadaan_umum'])) ? $pemeriksaan_fisik['pm_keadaan_umum'] : '')));
	$templateklinik->setValue('pm_tanda_vital', htmlspecialchars(((isset($pemeriksaan_fisik['pm_tanda_vital'])) ? $pemeriksaan_fisik['pm_tanda_vital'] : '')));
	$templateklinik->setValue('pm_td', htmlspecialchars(((isset($pemeriksaan_fisik['pm_td'])) ? $pemeriksaan_fisik['pm_td'] : '')));
	$templateklinik->setValue('pm_nadi', htmlspecialchars(((isset($pemeriksaan_fisik['pm_nadi'])) ? $pemeriksaan_fisik['pm_nadi'] : '')));
	$templateklinik->setValue('pm_rr', htmlspecialchars(((isset($pemeriksaan_fisik['pm_rr'])) ? $pemeriksaan_fisik['pm_rr'] : '')));
	
	$templateklinik->setValue('pk_kepala', htmlspecialchars(((isset($pemeriksaan_kepala['pk_kepala'])) ? $pemeriksaan_kepala['pk_kepala'] : '')));
	$templateklinik->setValue('pk_mata', htmlspecialchars(((isset($pemeriksaan_kepala['pk_mata'])) ? $pemeriksaan_kepala['pk_mata'] : '')));
	$templateklinik->setValue('pk_tht', htmlspecialchars(((isset($pemeriksaan_kepala['pk_tht'])) ? $pemeriksaan_kepala['pk_tht'] : '')));
	$templateklinik->setValue('pk_leher', htmlspecialchars(((isset($pemeriksaan_kepala['pk_leher'])) ? $pemeriksaan_kepala['pk_leher'] : '')));
	
	$templateklinik->setValue('pt_dada', htmlspecialchars(((isset($pemeriksaan_thorax['pt_dada'])) ? $pemeriksaan_thorax['pt_dada'] : '')));
	$templateklinik->setValue('pt_inspeksi', htmlspecialchars(((isset($pemeriksaan_thorax['pt_inspeksi'])) ? $pemeriksaan_thorax['pt_inspeksi'] : '')));
	$templateklinik->setValue('pt_palpasi', htmlspecialchars(((isset($pemeriksaan_thorax['pt_palpasi'])) ? $pemeriksaan_thorax['pt_palpasi'] : '')));
	$templateklinik->setValue('pt_auskultasi', htmlspecialchars(((isset($pemeriksaan_thorax['pt_auskultasi'])) ? $pemeriksaan_thorax['pt_auskultasi'] : '')));
	$templateklinik->setValue('pt_cor', htmlspecialchars(((isset($pemeriksaan_thorax['pt_cor'])) ? $pemeriksaan_thorax['pt_cor'] : '')));
	$templateklinik->setValue('pt_pulmo', htmlspecialchars(((isset($pemeriksaan_thorax['pt_pulmo'])) ? $pemeriksaan_thorax['pt_pulmo'] : '')));
	
	$templateklinik->setValue('pa_abdomen', htmlspecialchars(((isset($pemeriksaan_abdomen['pa_abdomen'])) ? $pemeriksaan_abdomen['pa_abdomen'] : '')));
	$templateklinik->setValue('pa_inspeksi', htmlspecialchars(((isset($pemeriksaan_abdomen['pa_inspeksi'])) ? $pemeriksaan_abdomen['pa_inspeksi'] : '')));
	$templateklinik->setValue('pa_palpasi', htmlspecialchars(((isset($pemeriksaan_abdomen['pa_palpasi'])) ? $pemeriksaan_abdomen['pa_palpasi'] : '')));
	$templateklinik->setValue('pa_hepar', htmlspecialchars(((isset($pemeriksaan_abdomen['pa_hepar'])) ? $pemeriksaan_abdomen['pa_hepar'] : '')));
	$templateklinik->setValue('pa_lien', htmlspecialchars(((isset($pemeriksaan_abdomen['pa_lien'])) ? $pemeriksaan_abdomen['pa_lien'] : '')));
	$templateklinik->setValue('pa_auskultasi', htmlspecialchars(((isset($pemeriksaan_abdomen['pa_auskultasi'])) ? $pemeriksaan_abdomen['pa_auskultasi'] : '')));
	
	$templateklinik->setValue('pe_ekstremitas', htmlspecialchars(((isset($pemeriksaan_ekstremitas['pe_ekstremitas'])) ? $pemeriksaan_ekstremitas['pe_ekstremitas'] : '')));
	$templateklinik->setValue('pe_lain', htmlspecialchars(((isset($pemeriksaan_ekstremitas['pe_lain'])) ? $pemeriksaan_ekstremitas['pe_lain'] : '')));
	
	$templateklinik->setValue('plab_darah', htmlspecialchars(((isset($pemeriksaan_laboratorium['plab_darah'])) ? $pemeriksaan_laboratorium['plab_darah'] : '')));
	$templateklinik->setValue('plab_urin', htmlspecialchars(((isset($pemeriksaan_laboratorium['plab_urin'])) ? $pemeriksaan_laboratorium['plab_urin'] : '')));
	$templateklinik->setValue('plab_kimia', htmlspecialchars(((isset($pemeriksaan_laboratorium['plab_kimia'])) ? $pemeriksaan_laboratorium['plab_kimia'] : '')));
	$templateklinik->setValue('plab_gds', htmlspecialchars(((isset($pemeriksaan_laboratorium['plab_gds'])) ? $pemeriksaan_laboratorium['plab_gds'] : '')));
	$templateklinik->setValue('plab_sgot', htmlspecialchars(((isset($pemeriksaan_laboratorium['plab_sgot'])) ? $pemeriksaan_laboratorium['plab_sgot'] : '')));
	$templateklinik->setValue('plab_ureum', htmlspecialchars(((isset($pemeriksaan_laboratorium['plab_ureum'])) ? $pemeriksaan_laboratorium['plab_ureum'] : '')));
	$templateklinik->setValue('plab_kolesterol', htmlspecialchars(((isset($pemeriksaan_laboratorium['plab_kolesterol'])) ? $pemeriksaan_laboratorium['plab_kolesterol'] : '')));
	$templateklinik->setValue('plab_hbsag', htmlspecialchars(((isset($pemeriksaan_laboratorium['plab_hbsag'])) ? $pemeriksaan_laboratorium['plab_hbsag'] : '')));
	$templateklinik->setValue('plab_hiv', htmlspecialchars(((isset($pemeriksaan_laboratorium['plab_hiv'])) ? $pemeriksaan_laboratorium['plab_hiv'] : '')));
	
	$templateklinik->setValue('pem_kardiologi', htmlspecialchars($pem_kardiologi));
	$templateklinik->setValue('pem_radiologi', htmlspecialchars($pem_radiologi));
	$templateklinik->setValue('pem_mata', htmlspecialchars($pem_mata));
	$templateklinik->setValue('pem_lain', htmlspecialchars($pem_lain));
	
	$templateklinik->setValue('resume', htmlspecialchars($resume));
	$templateklinik->setValue('kesimpulan', htmlspecialchars($kesimpulan));
	$templateklinik->setValue('catatan', htmlspecialchars($catatan));
	
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
	
	if(!file_exists($rmfile_path . '/pdf/1/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/pdf/1/' . $nomr . '/' . $idx, 0700, true);
	}

	if(!file_exists($rmfile_path . '/doc/1/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/doc/1/' . $nomr . '/' . $idx, 0700, true);
	}
	
	$nama_file = $nomr . '_' . $idx . '_55';	
	$templateklinik->saveAs($rmfile_path . '/doc/1/' . $nomr . '/' . $idx . '/' . $nama_file . '.docx');
	
	mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE RAWAT_ID = "' . $idx . '"
				AND JNS_PERAWATAN = "1"
				AND JENIS_DOKUMEN_ID = "55"
				AND NAMA_FILE = "' . $nama_file . '.pdf"') or die(mysql_error());
	mysql_query('INSERT INTO t_rm_dokumen_file(JENIS_DOKUMEN_ID,NOMR,RAWAT_ID,JNS_PERAWATAN,NAMA_FILE,ST_SISTEM,TANGGAL) 		
				VALUES("55","' . $nomr . '","' . $idx . '","1","' . $nama_file . '.pdf","1",STR_TO_DATE("' . $tgl_daftar . '","%d/%m/%Y"))') or die(mysql_error());
	
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