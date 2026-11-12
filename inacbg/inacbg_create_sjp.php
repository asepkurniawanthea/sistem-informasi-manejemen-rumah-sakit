<?php
function inacbg_create_sjp($rawat,$id,$no_sep){
	global $eklaim_arsip_path;

	if($rawat == '2'){
		$templatesjp = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\sjp_rawat_jalan.docx');
		$qry_sjp = 'SELECT t_irja.IRJA_ID,t_irja.NO_SJP,m_jaminan.NAMA_JAMINAN,
				t_irja.NO_PESERTA,t_irja.NO_SEP,t_irja.NOMR,m_pasien.NAMA_PASIEN,
				CASE WHEN m_pasien.JNS_KELAMIN = "L" THEN "Laki-laki" WHEN m_pasien.JNS_KELAMIN = "P" THEN "Perempuan"
				END AS JNS_KELAMIN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,
				DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d-%m-%Y") AS TANGGAL_DAFTAR,
				m_pasien.ALAMAT,m_pasien.NO_TELEPON,m_kelurahan.NAMA_KELURAHAN,
				m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,m_unit.NAMA_UNIT,m_pegawai.NAMA_PEGAWAI
				FROM t_irja 
				INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
				LEFT JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
				WHERE t_irja.IRJA_ID = "' . $id . '"';
		$get_sjp = mysql_query($qry_sjp) or die(mysql_error());
		$dat_sjp = mysql_fetch_assoc($get_sjp);
		$templatesjp->setValue('nomor_sjp', htmlspecialchars($dat_sjp['NO_SJP']));
		$templatesjp->setValue('jaminan', htmlspecialchars($dat_sjp['NAMA_JAMINAN']));
		$templatesjp->setValue('no_peserta', htmlspecialchars($dat_sjp['NO_PESERTA']));
		$templatesjp->setValue('sep', htmlspecialchars($dat_sjp['NO_SEP']));
		$templatesjp->setValue('nomor_mr', formatNoMR($dat_sjp['NOMR']));
		$templatesjp->setValue('nama_pasien', htmlspecialchars($dat_sjp['NAMA_PASIEN']));
		$templatesjp->setValue('jenis_kelamin', htmlspecialchars($dat_sjp['JNS_KELAMIN']));
		$templatesjp->setValue('tanggal_lahir', htmlspecialchars($dat_sjp['TGL_LAHIR']));
		$umur = getUmurDaftar($dat_sjp['TGL_LAHIR'],htmlspecialchars($dat_sjp['TANGGAL_DAFTAR']));
		$templatesjp->setValue('umur', htmlspecialchars($umur));
		$templatesjp->setValue('alamat', htmlspecialchars($dat_sjp['ALAMAT'] . '/' . $dat_sjp['NO_TELEPON']));
		$templatesjp->setValue('kelurahan', htmlspecialchars($dat_sjp['NAMA_KELURAHAN']));
		$templatesjp->setValue('kecamatan', htmlspecialchars($dat_sjp['NAMA_KECAMATAN']));
		$templatesjp->setValue('kota', htmlspecialchars($dat_sjp['NAMA_KOTA']));
		$templatesjp->setValue('jenis_rawat', htmlspecialchars(strtoupper($dat_sjp['NAMA_UNIT'])));
		$templatesjp->setValue('nama_dokter', htmlspecialchars(strtoupper($dat_sjp['NAMA_PEGAWAI'])));
		$templatesjp->setValue('tanggal', htmlspecialchars($dat_sjp['TANGGAL_DAFTAR']));
		$templatesjp->setValue('dokter', htmlspecialchars($dat_sjp['NAMA_PEGAWAI']));
			
		$qry_diagnosa = 'SELECT t_irja_diagnosa.DIAGNOSA,t_irja_diagnosa.ICD_CODE
					FROM t_irja_diagnosa
					WHERE t_irja_diagnosa.IRJA_ID = "' . $id . '"
					ORDER BY t_irja_diagnosa.DIAGNOSA_ORDER';
		$get_diagnosa = mysql_query($qry_diagnosa) or die(mysql_error());			
		if(mysql_num_rows($get_diagnosa) > 0){
			$templatesjp->cloneRow('no_diagnosa', mysql_num_rows($get_diagnosa));
			$l = 0;
			while($dat_diagnosa = mysql_fetch_array($get_diagnosa)){
				$templatesjp->setValue('no_diagnosa#' . ($l + 1), ($l + 1));	 
				$templatesjp->setValue('diagnosa#' . ($l + 1), htmlspecialchars($dat_diagnosa['DIAGNOSA']));
				$templatesjp->setValue('icd_diagnosa#' . ($l + 1), htmlspecialchars($dat_diagnosa['ICD_CODE']));
				$l = $l + 1;
			}	
		}else{
			$templatesjp->setValue('no_diagnosa', '');	
			$templatesjp->setValue('diagnosa', '');	
			$templatesjp->setValue('icd_diagnosa', '');	
		}

		$qry_tindakan = 'SELECT m_tarif.NAMA_TARIF,t_irja_tarif.ICD_CODE,
					m_tarif_group.NAMA_TARIF_GROUP
					FROM t_irja_tarif
					INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					WHERE t_irja_tarif.IRJA_ID = "' . $id . '"
					AND t_irja_tarif.NO_TARIF IS NOT NULL
					AND t_irja_tarif.NO_PEMBAYARAN IS NOT NULL
					AND t_irja_tarif.ST_BAYAR = "Lunas"
					AND t_irja_tarif.ST_BATAL IS NULL
					AND m_tarif.KODE_TARIF_GROUP NOT IN ("01")';
		$get_tindakan = mysql_query($qry_tindakan) or die(mysql_error());			
		if(mysql_num_rows($get_tindakan) > 0){
			$templatesjp->cloneRow('no_tindakan', mysql_num_rows($get_tindakan));
			$l = 0;
			while($dat_tindakan = mysql_fetch_array($get_tindakan)){
				$templatesjp->setValue('no_tindakan#' . ($l + 1), ($l + 1));	 
				$templatesjp->setValue('tindakan#' . ($l + 1), htmlspecialchars($dat_tindakan['NAMA_TARIF_GROUP'] . '-' . $dat_tindakan['NAMA_TARIF']));
				$templatesjp->setValue('icd_tindakan#' . ($l + 1), htmlspecialchars($dat_tindakan['ICD_CODE']));
				$l = $l + 1;
			}	
		}else{
			$templatesjp->setValue('no_tindakan', '');	
			$templatesjp->setValue('tindakan', '');	
			$templatesjp->setValue('icd_tindakan', '');	
		}	
	
		$templatesjp->saveAs($eklaim_arsip_path . '/doc/' . $no_sep . '/01_sjp.docx');
	}else if($rawat == '1'){
		$templatesjp = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\sjp_rawat_inap.docx');
		$qry_sjp = 'SELECT t_irna.IRNA_ID,t_irna.NO_SJP,m_jaminan.NAMA_JAMINAN,
				t_irna.NO_PESERTA,t_irna.NO_SEP,t_irna.NOMR,m_pasien.NAMA_PASIEN,
				CASE WHEN m_pasien.JNS_KELAMIN = "L" THEN "Laki-laki" WHEN m_pasien.JNS_KELAMIN = "P" THEN "Perempuan"
				END AS JNS_KELAMIN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,
				DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d-%m-%Y") AS TANGGAL_DAFTAR,
				m_pasien.ALAMAT,m_pasien.NO_TELEPON,m_kelurahan.NAMA_KELURAHAN,
				m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,m_ruang.NAMA_RUANG,
				m_ruang.KELAS_RAWAT,m_pegawai.NAMA_PEGAWAI
				FROM t_irna 
				INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				LEFT JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
				WHERE t_irna.IRNA_ID = "' . $id . '"';
		$get_sjp = mysql_query($qry_sjp) or die(mysql_error());
		$dat_sjp = mysql_fetch_assoc($get_sjp);
		$templatesjp->setValue('nomor_sjp', htmlspecialchars($dat_sjp['NO_SJP']));
		$templatesjp->setValue('jaminan', htmlspecialchars($dat_sjp['NAMA_JAMINAN']));
		$templatesjp->setValue('no_peserta', htmlspecialchars($dat_sjp['NO_PESERTA']));
		$templatesjp->setValue('sep', htmlspecialchars($dat_sjp['NO_SEP']));
		$templatesjp->setValue('nomor_mr', formatNoMR($dat_sjp['NOMR']));
		$templatesjp->setValue('nama_pasien', htmlspecialchars($dat_sjp['NAMA_PASIEN']));
		$templatesjp->setValue('jenis_kelamin', htmlspecialchars($dat_sjp['JNS_KELAMIN']));
		$templatesjp->setValue('tanggal_lahir', htmlspecialchars($dat_sjp['TGL_LAHIR']));
		$umur = getUmurDaftar($dat_sjp['TGL_LAHIR'],htmlspecialchars($dat_sjp['TANGGAL_DAFTAR']));
		$templatesjp->setValue('umur', htmlspecialchars($umur));
		$templatesjp->setValue('alamat', htmlspecialchars($dat_sjp['ALAMAT'] . '/' . $dat_sjp['NO_TELEPON']));
		$templatesjp->setValue('kelurahan', htmlspecialchars($dat_sjp['NAMA_KELURAHAN']));
		$templatesjp->setValue('kecamatan', htmlspecialchars($dat_sjp['NAMA_KECAMATAN']));
		$templatesjp->setValue('kota', htmlspecialchars($dat_sjp['NAMA_KOTA']));
		$templatesjp->setValue('jenis_rawat', htmlspecialchars(strtoupper($dat_sjp['NAMA_RUANG'] . ' Kelas ' . $dat_sjp['KELAS_RAWAT'])));
		$templatesjp->setValue('nama_dokter', htmlspecialchars(strtoupper($dat_sjp['NAMA_PEGAWAI'])));
		$templatesjp->setValue('tanggal', htmlspecialchars($dat_sjp['TANGGAL_DAFTAR']));
		$templatesjp->setValue('dokter', htmlspecialchars($dat_sjp['NAMA_PEGAWAI']));
			
		$qry_diagnosa = 'SELECT t_irna_diagnosa.DIAGNOSA,t_irna_diagnosa.ICD_CODE
					FROM t_irna_diagnosa
					WHERE t_irna_diagnosa.IRNA_ID = "' . $id . '"
					ORDER BY t_irna_diagnosa.DIAGNOSA_ORDER';
		$get_diagnosa = mysql_query($qry_diagnosa) or die(mysql_error());			
		if(mysql_num_rows($get_diagnosa) > 0){
			$templatesjp->cloneRow('no_diagnosa', mysql_num_rows($get_diagnosa));
			$l = 0;
			while($dat_diagnosa = mysql_fetch_array($get_diagnosa)){
				$templatesjp->setValue('no_diagnosa#' . ($l + 1), ($l + 1));	 
				$templatesjp->setValue('diagnosa#' . ($l + 1), htmlspecialchars($dat_diagnosa['DIAGNOSA']));
				$templatesjp->setValue('icd_diagnosa#' . ($l + 1), htmlspecialchars($dat_diagnosa['ICD_CODE']));
				$l = $l + 1;
			}	
		}else{
			$templatesjp->setValue('no_diagnosa', '');	
			$templatesjp->setValue('diagnosa', '');	
			$templatesjp->setValue('icd_diagnosa', '');	
		}

		$qry_tindakan = 'SELECT m_tarif.NAMA_TARIF,t_irna_tarif.ICD_CODE,
					m_tarif_group.NAMA_TARIF_GROUP
					FROM t_irna_tarif
					INNER JOIN m_tarif ON (t_irna_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					WHERE t_irna_tarif.IRNA_ID = "' . $id . '"
					AND t_irna_tarif.NO_TARIF IS NOT NULL
					AND t_irna_tarif.NO_PEMBAYARAN IS NOT NULL
					AND t_irna_tarif.ST_BAYAR = "Lunas"
					AND m_tarif.KODE_TARIF_GROUP NOT IN ("01","51")';
		$get_tindakan = mysql_query($qry_tindakan) or die(mysql_error());			
		if(mysql_num_rows($get_tindakan) > 0){
			$templatesjp->cloneRow('no_tindakan', mysql_num_rows($get_tindakan));
			$l = 0;
			while($dat_tindakan = mysql_fetch_array($get_tindakan)){
				$templatesjp->setValue('no_tindakan#' . ($l + 1), ($l + 1));	 
				$templatesjp->setValue('tindakan#' . ($l + 1), htmlspecialchars($dat_tindakan['NAMA_TARIF_GROUP'] . '-' . $dat_tindakan['NAMA_TARIF']));
				$templatesjp->setValue('icd_tindakan#' . ($l + 1), htmlspecialchars($dat_tindakan['ICD_CODE']));
				$l = $l + 1;
			}	
		}else{
			$templatesjp->setValue('no_tindakan', '');	
			$templatesjp->setValue('tindakan', '');	
			$templatesjp->setValue('icd_tindakan', '');	
		}	
	
		$templatesjp->saveAs($eklaim_arsip_path . '/doc/' . $no_sep . '/01_sjp.docx');
	}
	
	try{
		$source_file = $eklaim_arsip_path . '/doc/' . $no_sep . '/01_sjp.docx';
		$target_file = $eklaim_arsip_path . '/pdf/' . $no_sep . '/01_sjp.pdf';
		
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
?>