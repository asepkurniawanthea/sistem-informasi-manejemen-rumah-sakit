<?php
function inacbg_create_sep($rawat,$id,$no_sep,$jenis_bayar){
	global $eklaim_arsip_path;

	if($rawat == '2' and $jenis_bayar == '12'){
		$templatesep = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\sep_rawat_jalan.docx');
		$qry_sep = 'SELECT t_irja.IRJA_ID,DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d-%m-%Y") AS TANGGAL_DAFTAR,
			t_irja.NO_SEP,t_irja.NO_PESERTA,m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,
			CASE WHEN m_pasien.JNS_KELAMIN = "L" THEN "Laki-laki" WHEN m_pasien.JNS_KELAMIN = "P" THEN "Perempuan"
			END AS JNS_KELAMIN,
			m_unit.NAMA_UNIT,t_irja.JKN_DIAGNOSA,t_irja.JKN_CATATAN,t_irja.JKN_NAMA_PKK,t_irja.JKN_PBI_NONPBI,
			t_irja.JKN_KELAS_RAWAT,DATE_FORMAT(t_irja.JKN_TGL_RUJUK,"%d-%m-%Y") AS JKN_TGL_RUJUK,
			t_irja.JKN_NO_RUJUK,t_irja.JKN_ASAL_RUJUKAN,t_irja.JKN_COB,t_irja.JKN_KATARAK,
			t_irja.JKN_NOSURAT_SKDP,t_irja.JKN_SPESIALISASI_DPJP_SKDP,t_irja.JKN_NAMA_DPJP_SKDP,
			t_irja.KECELAKAAN,t_irja.JKN_SUPLESI,
			DATE_FORMAT(t_irja.TGL_KEJADIAN_KECELAKAAN,"%d-%m-%Y") AS TGL_KEJADIAN_KECELAKAAN,
			t_irja.JKN_NO_SEP_SUPLESI,
			t_irja.NAMA_LOKASI_KECELAKAAN_KECAMATAN,
			t_irja.NAMA_LOKASI_KECELAKAAN_KABUPATEN,
			t_irja.NAMA_LOKASI_KECELAKAAN_PROPINSI,
			t_irja.KETERANGAN_KECELAKAAN,
			t_irja.JKN_PENJAMIN	
			FROM t_irja
			INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
			INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
			WHERE t_irja.IRJA_ID = "' . $id . '"';
		$get_sep = mysql_query($qry_sep) or die(mysql_error());
		$dat_sep = mysql_fetch_assoc($get_sep);
		$templatesep->setValue('nomor_sep', htmlspecialchars($dat_sep['NO_SEP']));
		$templatesep->setValue('tanggal_sep', htmlspecialchars($dat_sep['TANGGAL_DAFTAR']));
		$templatesep->setValue('no_kartu', htmlspecialchars($dat_sep['NO_PESERTA']));
		$templatesep->setValue('kelas', htmlspecialchars($dat_sep['JKN_KELAS_RAWAT']));
		$templatesep->setValue('jenis_peserta', htmlspecialchars($dat_sep['JKN_PBI_NONPBI']));
		$templatesep->setValue('nama_peserta', htmlspecialchars($dat_sep['NAMA_PASIEN']));
		$templatesep->setValue('tanggal_lahir', htmlspecialchars($dat_sep['TGL_LAHIR']));
		$templatesep->setValue('jenis_kelamin', htmlspecialchars($dat_sep['JNS_KELAMIN']));
		$templatesep->setValue('tanggal_rujukan', htmlspecialchars($dat_sep['JKN_TGL_RUJUK']));
		$templatesep->setValue('no_rujukan', htmlspecialchars($dat_sep['JKN_NO_RUJUK']));
		$templatesep->setValue('jenis_faskes', 'Tk. ' . htmlspecialchars($dat_sep['JKN_ASAL_RUJUKAN']));
		$templatesep->setValue('nama_faskes', htmlspecialchars($dat_sep['JKN_NAMA_PKK']));
		$templatesep->setValue('diagnosa', htmlspecialchars($dat_sep['JKN_DIAGNOSA']));
		$templatesep->setValue('catatan', htmlspecialchars($dat_sep['JKN_CATATAN']));
		$templatesep->setValue('poli_tujuan', htmlspecialchars($dat_sep['NAMA_UNIT']));
		if($dat_sep['JKN_COB'] == '1'){
			$templatesep->setValue('cob', 'Ya');	
		}else{
			$templatesep->setValue('cob', '');	
		}
		if($dat_sep['JKN_KATARAK'] == '1'){
			$templatesep->setValue('katarak', 'Ya');	
		}else{
			$templatesep->setValue('katarak', '');	
		}
		$templatesep->setValue('no_surat_skdp', htmlspecialchars($dat_sep['JKN_NOSURAT_SKDP']));
		$templatesep->setValue('spesialisasi', htmlspecialchars($dat_sep['JKN_SPESIALISASI_DPJP_SKDP']));
		$templatesep->setValue('dpjp', htmlspecialchars($dat_sep['JKN_NAMA_DPJP_SKDP']));
		if($dat_sep['KECELAKAAN'] != ''){
			$templatesep->setValue('pasien_kecelakaan', 'Ya');	
		}else{
			$templatesep->setValue('pasien_kecelakaan', '');	
		}
		if($dat_sep['JKN_SUPLESI'] == '1'){
			$templatesep->setValue('suplesi', 'Ya');	
		}else{
			$templatesep->setValue('suplesi', '');	
		}
		$templatesep->setValue('tanggal_kejadian', htmlspecialchars($dat_sep['TGL_KEJADIAN_KECELAKAAN']));
		$templatesep->setValue('no_sep_suplesi', htmlspecialchars($dat_sep['JKN_NO_SEP_SUPLESI']));
		$lokasi_kecelakaan = '';
		if($dat_sep['NAMA_LOKASI_KECELAKAAN_KECAMATAN'] != '') $lokasi_kecelakaan .= $dat_sep['NAMA_LOKASI_KECELAKAAN_KECAMATAN'] . ' ';
		if($dat_sep['NAMA_LOKASI_KECELAKAAN_KABUPATEN'] != '') $lokasi_kecelakaan .= $dat_sep['NAMA_LOKASI_KECELAKAAN_KABUPATEN'] . ' ';
		if($dat_sep['NAMA_LOKASI_KECELAKAAN_PROPINSI'] != '') $lokasi_kecelakaan .= $dat_sep['NAMA_LOKASI_KECELAKAAN_PROPINSI'];
		$templatesep->setValue('lokasi_kecelakaan', htmlspecialchars($lokasi_kecelakaan));
		$templatesep->setValue('keterangan_kecelakaan', htmlspecialchars($dat_sep['KETERANGAN_KECELAKAAN']));
		$templatesep->setValue('penjamin', htmlspecialchars($dat_sep['JKN_PENJAMIN']));
		
		$templatesep->saveAs($eklaim_arsip_path . '/doc/' . $no_sep . '/01_sep.docx');
	}else if($rawat == '1' and $jenis_bayar == '12'){
		$templatesep = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\sep_rawat_inap.docx');
		$qry_sep = 'SELECT t_irna.IRNA_ID,DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d-%m-%Y") AS TANGGAL_DAFTAR,
			t_irna.NO_SEP,t_irna.NO_PESERTA,m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,
			CASE WHEN m_pasien.JNS_KELAMIN = "L" THEN "Laki-laki" WHEN m_pasien.JNS_KELAMIN = "P" THEN "Perempuan"
			END AS JNS_KELAMIN,
			m_ruang.NAMA_RUANG,t_irna.JKN_DIAGNOSA,t_irna.JKN_CATATAN,t_irna.JKN_NAMA_PKK,t_irna.JKN_PBI_NONPBI,
			t_irna.JKN_KELAS_RAWAT,t_irna.KELAS_RAWAT,
			DATE_FORMAT(t_irna.JKN_TGL_RUJUK,"%d-%m-%Y") AS JKN_TGL_RUJUK,
			t_irna.JKN_NO_RUJUK,t_irna.JKN_ASAL_RUJUKAN,t_irna.JKN_COB,t_irna.JKN_KATARAK,
			t_irna.JKN_NOSURAT_SKDP,t_irna.JKN_SPESIALISASI_DPJP_SKDP,t_irna.JKN_NAMA_DPJP_SKDP,
			t_irna.KECELAKAAN,t_irna.JKN_SUPLESI,
			DATE_FORMAT(t_irna.TGL_KEJADIAN_KECELAKAAN,"%d-%m-%Y") AS TGL_KEJADIAN_KECELAKAAN,
			t_irna.JKN_NO_SEP_SUPLESI,
			t_irna.NAMA_LOKASI_KECELAKAAN_KECAMATAN,
			t_irna.NAMA_LOKASI_KECELAKAAN_KABUPATEN,
			t_irna.NAMA_LOKASI_KECELAKAAN_PROPINSI,
			t_irna.KETERANGAN_KECELAKAAN,
			t_irna.JKN_PENJAMIN	
			FROM t_irna
			INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
			INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
			WHERE t_irna.IRNA_ID = "' . $id . '"';
		$get_sep = mysql_query($qry_sep) or die(mysql_error());
		$dat_sep = mysql_fetch_assoc($get_sep);
		$templatesep->setValue('nomor_sep', htmlspecialchars($dat_sep['NO_SEP']));
		$templatesep->setValue('tanggal_sep', htmlspecialchars($dat_sep['TANGGAL_DAFTAR']));
		$templatesep->setValue('no_kartu', htmlspecialchars($dat_sep['NO_PESERTA']));
		$templatesep->setValue('kelas', htmlspecialchars($dat_sep['JKN_KELAS_RAWAT']));
		$templatesep->setValue('jenis_peserta', htmlspecialchars($dat_sep['JKN_PBI_NONPBI']));
		$templatesep->setValue('nama_peserta', htmlspecialchars($dat_sep['NAMA_PASIEN']));
		$templatesep->setValue('tanggal_lahir', htmlspecialchars($dat_sep['TGL_LAHIR']));
		$templatesep->setValue('jenis_kelamin', htmlspecialchars($dat_sep['JNS_KELAMIN']));
		$templatesep->setValue('tanggal_rujukan', htmlspecialchars($dat_sep['JKN_TGL_RUJUK']));
		$templatesep->setValue('no_rujukan', htmlspecialchars($dat_sep['JKN_NO_RUJUK']));
		$templatesep->setValue('jenis_faskes', 'Tk. ' . htmlspecialchars($dat_sep['JKN_ASAL_RUJUKAN']));
		$templatesep->setValue('nama_faskes', htmlspecialchars($dat_sep['JKN_NAMA_PKK']));
		$templatesep->setValue('diagnosa', htmlspecialchars($dat_sep['JKN_DIAGNOSA']));
		$templatesep->setValue('catatan', htmlspecialchars($dat_sep['JKN_CATATAN']));
		$templatesep->setValue('poli_tujuan', htmlspecialchars($dat_sep['NAMA_RUANG']));
		$templatesep->setValue('kelas_rawat', htmlspecialchars($dat_sep['KELAS_RAWAT']));
		if($dat_sep['JKN_COB'] == '1'){
			$templatesep->setValue('cob', 'Ya');	
		}else{
			$templatesep->setValue('cob', '');	
		}
		if($dat_sep['JKN_KATARAK'] == '1'){
			$templatesep->setValue('katarak', 'Ya');	
		}else{
			$templatesep->setValue('katarak', '');	
		}
		$templatesep->setValue('no_surat_skdp', htmlspecialchars($dat_sep['JKN_NOSURAT_SKDP']));
		$templatesep->setValue('spesialisasi', htmlspecialchars($dat_sep['JKN_SPESIALISASI_DPJP_SKDP']));
		$templatesep->setValue('dpjp', htmlspecialchars($dat_sep['JKN_NAMA_DPJP_SKDP']));
		if($dat_sep['KECELAKAAN'] != ''){
			$templatesep->setValue('pasien_kecelakaan', 'Ya');	
		}else{
			$templatesep->setValue('pasien_kecelakaan', '');	
		}
		if($dat_sep['JKN_SUPLESI'] == '1'){
			$templatesep->setValue('suplesi', 'Ya');	
		}else{
			$templatesep->setValue('suplesi', '');	
		}
		$templatesep->setValue('tanggal_kejadian', htmlspecialchars($dat_sep['TGL_KEJADIAN_KECELAKAAN']));
		$templatesep->setValue('no_sep_suplesi', htmlspecialchars($dat_sep['JKN_NO_SEP_SUPLESI']));
		$lokasi_kecelakaan = '';
		if($dat_sep['NAMA_LOKASI_KECELAKAAN_KECAMATAN'] != '') $lokasi_kecelakaan .= $dat_sep['NAMA_LOKASI_KECELAKAAN_KECAMATAN'] . ' ';
		if($dat_sep['NAMA_LOKASI_KECELAKAAN_KABUPATEN'] != '') $lokasi_kecelakaan .= $dat_sep['NAMA_LOKASI_KECELAKAAN_KABUPATEN'] . ' ';
		if($dat_sep['NAMA_LOKASI_KECELAKAAN_PROPINSI'] != '') $lokasi_kecelakaan .= $dat_sep['NAMA_LOKASI_KECELAKAAN_PROPINSI'];
		$templatesep->setValue('lokasi_kecelakaan', htmlspecialchars($lokasi_kecelakaan));
		$templatesep->setValue('keterangan_kecelakaan', htmlspecialchars($dat_sep['KETERANGAN_KECELAKAAN']));
		$templatesep->setValue('penjamin', htmlspecialchars($dat_sep['JKN_PENJAMIN']));
		
		$templatesep->saveAs($eklaim_arsip_path . '/doc/' . $no_sep . '/01_sep.docx');
	}
	
	if($jenis_bayar == '12'){
		try{
			$source_file = $eklaim_arsip_path . '/doc/' . $no_sep . '/01_sep.docx';
			$target_file = $eklaim_arsip_path . '/pdf/' . $no_sep . '/01_sep.pdf';
		
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
	}
}	
?>