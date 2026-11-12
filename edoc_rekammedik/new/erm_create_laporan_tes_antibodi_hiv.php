<?php
function replace_newline($str){
	$ret = preg_replace('/\r|\n/','\n',trim($str));
	$ret = str_replace('\n','<br>',$ret);
	$ret = str_replace('<br><br>','<br>',$ret);
	return $ret;
}

function erm_laporan_tes_antibodi_hiv($idx,$rawat){
	global $rmfile_path, $app_path;

	$checked = '<w:sym w:font="Wingdings" w:char="F0FE"/>';
    $unChecked = '<w:sym w:font="Wingdings" w:char="F0A8"/>';
	
	$templateklinik = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\laporan_tes_antibodi_hiv.docx');
	
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
		$qry_transfer = 'SELECT IRJA_HIV_ID,KODE_PASIEN,TEST_1,TEST_2,TEST_3,TEST_4,TEST_5,
			HASIL_TEST_1,HASIL_TEST_2,HASIL_TEST_3,HASIL_TEST_4,HASIL_TEST_5,TGL_ASSESMENT,REGISTER,
			DATE_FORMAT(TGL_PASIEN,"%d-%m-%Y") AS TGL_PASIEN,HASIL_AKHIR,
			REGISTER,DATE_FORMAT(TGL_ASSESMENT,"%d-%m-%Y") AS TGL_ASSESMENT
			FROM t_irja_hiv_laporan_lab
			WHERE IRJA_HIV_ID = "' . $idx . '"';
	}		
	$get_transfer = mysql_query($qry_transfer) or die(mysql_error());
	$dat_transfer = mysql_fetch_assoc($get_transfer);
	$reagen_1 = $dat_transfer['TEST_1'];
	$reagen_2 = $dat_transfer['TEST_2'];
	$reagen_3 = $dat_transfer['TEST_3'];
	$reagen_4 = $dat_transfer['TEST_4'];
	$reagen_5 = $dat_transfer['TEST_5'];
	$hasil_reagen_1 = $dat_transfer['HASIL_TEST_1'];
	$hasil_reagen_2 = $dat_transfer['HASIL_TEST_2'];
	$hasil_reagen_3 = $dat_transfer['HASIL_TEST_3'];
	$hasil_reagen_4 = $dat_transfer['HASIL_TEST_4'];
	$hasil_reagen_5 = $dat_transfer['HASIL_TEST_5'];
	$hasil_akhir = $dat_transfer['HASIL_AKHIR'];
	$kode_pasien = $dat_transfer['KODE_PASIEN'];
	$tgl_pasien = $dat_transfer['TGL_PASIEN'];
	$tgl_assesment = $dat_transfer['TGL_ASSESMENT'];
	
	$templateklinik->setValue('nomor_rm', $nomr);
	$templateklinik->setValue('nama_pasien', htmlspecialchars($nama_pasien));
	$templateklinik->setValue('tgl_lahir', $tgl_lahir);
	$templateklinik->setValue('jenis_kelamin', $jns_kelamin);
	$templateklinik->setValue('unit', htmlspecialchars($nama_unit));
	$templateklinik->setValue('no_telepon', htmlspecialchars($no_telepon));
	$templateklinik->setValue('alamat', htmlspecialchars($alamat_pasien));
	
	
	$templateklinik->setValue('nama_dokter', htmlspecialchars($nama_dokter));
	
	$templateklinik->setValue('kode_pasien', htmlspecialchars($kode_pasien));
	$templateklinik->setValue('tgl_pasien', $tgl_pasien);
	
	$cn = 0;
	if($reagen_1 != '') $cn++;
	if($reagen_2 != '') $cn++;
	if($reagen_3 != '') $cn++;
	if($reagen_4 != '') $cn++;
	if($reagen_5 != '') $cn++;
	
	if($cn == 0){
		$templateklinik->setValue('reagensia', '');
		$templateklinik->setValue('hasil', '');
	}else{
		$templateklinik->cloneRow('reagensia', $cn);
		$r = 1;
		if($reagen_1 != ''){
			$templateklinik->setValue('reagensia#' . $r, $r . '.' . $reagen_1);
			if($hasil_reagen_1 == ''){
				$templateklinik->setValue('hasil#' . $r,$unChecked . ' Non Reaktif   ' . $unChecked . ' Reaktif');
			}
			if($hasil_reagen_1 == '1'){
				$templateklinik->setValue('hasil#' . $r,$checked . ' Non Reaktif   ' . $unChecked . ' Reaktif');
			}
			if($hasil_reagen_1 == '2'){
				$templateklinik->setValue('hasil#' . $r,$unChecked . ' Non Reaktif   ' . $checked . ' Reaktif');
			}	
			$r++;
		}
		if($reagen_2 != ''){
			$templateklinik->setValue('reagensia#' . $r, $r . '.' . $reagen_2);
			if($hasil_reagen_2 == ''){
				$templateklinik->setValue('hasil#' . $r,$unChecked . ' Non Reaktif   ' . $unChecked . ' Reaktif');
			}
			if($hasil_reagen_2 == '1'){
				$templateklinik->setValue('hasil#' . $r,$checked . ' Non Reaktif   ' . $unChecked . ' Reaktif');
			}
			if($hasil_reagen_2 == '2'){
				$templateklinik->setValue('hasil#' . $r,$unChecked . ' Non Reaktif   ' . $checked . ' Reaktif');
			}	
			$r++;
		}
		if($reagen_3 != ''){
			$templateklinik->setValue('reagensia#' . $r, $r . '.' . $reagen_3);
			if($hasil_reagen_3 == ''){
				$templateklinik->setValue('hasil#' . $r,$unChecked . ' Non Reaktif   ' . $unChecked . ' Reaktif');
			}
			if($hasil_reagen_3 == '1'){
				$templateklinik->setValue('hasil#' . $r,$checked . ' Non Reaktif   ' . $unChecked . ' Reaktif');
			}
			if($hasil_reagen_3 == '2'){
				$templateklinik->setValue('hasil#' . $r,$unChecked . ' Non Reaktif   ' . $checked . ' Reaktif');
			}
			$r++;
		}
		if($reagen_4 != ''){
			$templateklinik->setValue('reagensia#' . $r, $r . '.' . $reagen_4);
			if($hasil_reagen_4 == ''){
				$templateklinik->setValue('hasil#' . $r,$unChecked . ' Non Reaktif   ' . $unChecked . ' Reaktif');
			}
			if($hasil_reagen_4 == '1'){
				$templateklinik->setValue('hasil#' . $r,$checked . ' Non Reaktif   ' . $unChecked . ' Reaktif');
			}
			if($hasil_reagen_4 == '2'){
				$templateklinik->setValue('hasil#' . $r,$unChecked . ' Non Reaktif   ' . $checked . ' Reaktif');
			}
			$r++;
		}	
		if($reagen_5 != ''){
			$templateklinik->setValue('reagensia#' . $r, $r . '.' . $reagen_5);
			if($hasil_reagen_5 == ''){
				$templateklinik->setValue('hasil#' . $r,$unChecked . ' Non Reaktif   ' . $unChecked . ' Reaktif');
			}
			if($hasil_reagen_5 == '1'){
				$templateklinik->setValue('hasil#' . $r,$checked . ' Non Reaktif   ' . $unChecked . ' Reaktif');
			}
			if($hasil_reagen_5 == '2'){
				$templateklinik->setValue('hasil#' . $r,$unChecked . ' Non Reaktif   ' . $checked . ' Reaktif');
			}
			$r++;
		}
	}	
	
	if($hasil_akhir == ''){
		$templateklinik->setValue('ha_1', $unChecked);
		$templateklinik->setValue('ha_2', $unChecked);
		$templateklinik->setValue('ha_3', $unChecked);
	}
	if($hasil_akhir == '1'){
		$templateklinik->setValue('ha_1', $checked);
		$templateklinik->setValue('ha_2', $unChecked);
		$templateklinik->setValue('ha_3', $unChecked);
	}	
	if($hasil_akhir == '2'){
		$templateklinik->setValue('ha_1', $unChecked);
		$templateklinik->setValue('ha_2', $checked);
		$templateklinik->setValue('ha_3', $unChecked);
	}
	if($hasil_akhir == '3'){
		$templateklinik->setValue('ha_1', $unChecked);
		$templateklinik->setValue('ha_2', $unChecked);
		$templateklinik->setValue('ha_3', $checked);
	}
	
	if(!file_exists($rmfile_path . '/pdf/1/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/pdf/1/' . $nomr . '/' . $idx, 0700, true);
	}

	if(!file_exists($rmfile_path . '/doc/1/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/doc/1/' . $nomr . '/' . $idx, 0700, true);
	}
	
	$nama_file = $nomr . '_' . $idx . '_53';	
	$templateklinik->saveAs($rmfile_path . '/doc/1/' . $nomr . '/' . $idx . '/' . $nama_file . '.docx');
	
	mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE RAWAT_ID = "' . $idx . '"
				AND JNS_PERAWATAN = "1"
				AND JENIS_DOKUMEN_ID = "53"
				AND NAMA_FILE = "' . $nama_file . '.pdf"') or die(mysql_error());
	mysql_query('INSERT INTO t_rm_dokumen_file(JENIS_DOKUMEN_ID,NOMR,RAWAT_ID,JNS_PERAWATAN,NAMA_FILE,ST_SISTEM,TANGGAL) 		
				VALUES("53","' . $nomr . '","' . $idx . '","1","' . $nama_file . '.pdf","1",STR_TO_DATE("' . $tgl_daftar . '","%d/%m/%Y"))') or die(mysql_error());
	
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