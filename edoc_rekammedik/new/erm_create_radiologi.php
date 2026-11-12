<?php
function replace_newline($str){
	$ret = str_replace('<br />','<br>',$str);
	$ret = preg_replace('/\r|\n/','\n',trim($ret));
	$ret = str_replace('\n','<br>',$ret);
	$new_line = htmlspecialchars('<br>');
	$ret = str_replace($new_line,'<br>',$ret);
	$ret = str_replace('<br><br>','<br>',$ret);
	$ret = str_replace('<ul>','',$ret);
	$ret = str_replace('</li>','',$ret);
	$ret = str_replace('</ul>','',$ret);
	$ret = str_replace('<li>','<br>-&nbsp;',$ret);
	return $ret;
}

function erm_radiologi($idx,$ord,$by){
	global $rmfile_path;

	$templaterad = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\radiologi.docx');
	
	if($ord == 'irj'){
		$jns_perawatan = '1';
		$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d-%m-%Y %H:%i") AS TANGGAL_DAFTAR,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR2,
				DATE_FORMAT(t_ipenunjang_tarif_pemeriksaan.TGL_DIAGNOSA,"%d-%m-%Y %H:%i") AS TANGGAL_DIAGNOSA,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				m_unit.NAMA_UNIT,m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,m_pasien.NO_TELEPON,
				m_pasien.NAMA_SUAMI_ISTERI,t_ipenunjang_tarif_pemeriksaan.HASIL_DIAGNOSA,
				m_pegawai2.NAMA_PEGAWAI AS DOKTER_DIAGNOSA,t_ipenunjang_tarif.JENIS_FOTO,
				m_pegawai_tipe.KET_TIPE_PEGAWAI,t_ipenunjang_tarif_pemeriksaan.REVISI
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN t_ipenunjang_tarif_pemeriksaan ON (t_ipenunjang_tarif.PENUNJANG_TARIF_ID = t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang_tarif_pemeriksaan.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
				LEFT JOIN m_pegawai_tipe ON (m_pegawai2.TIPE_PEGAWAI_ID = m_pegawai_tipe.TIPE_PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_ORDER = "IRJ"
				AND t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_PEMERIKSAAN_ID = "' . $idx . '"';
	}else if($ord == 'irn'){
		$jns_perawatan = '2';
		$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d-%m-%Y %H:%i") AS TANGGAL_DAFTAR,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR2,
				DATE_FORMAT(t_ipenunjang_tarif_pemeriksaan.TGL_DIAGNOSA,"%d-%m-%Y %H:%i") AS TANGGAL_DIAGNOSA,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_ruang.NAMA_RUANG," Kelas",m_ruang.KELAS_RAWAT) AS NAMA_UNIT,
				m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,
				t_ipenunjang.RUANG_ID AS UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,m_pasien.NO_TELEPON,
				m_pasien.NAMA_SUAMI_ISTERI,t_ipenunjang_tarif_pemeriksaan.HASIL_DIAGNOSA,
				m_pegawai2.NAMA_PEGAWAI AS DOKTER_DIAGNOSA,t_ipenunjang_tarif.JENIS_FOTO,
				m_pegawai_tipe.KET_TIPE_PEGAWAI,t_ipenunjang_tarif_pemeriksaan.REVISI
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN t_ipenunjang_tarif_pemeriksaan ON (t_ipenunjang_tarif.PENUNJANG_TARIF_ID = t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang_tarif_pemeriksaan.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
				LEFT JOIN m_pegawai_tipe ON (m_pegawai2.TIPE_PEGAWAI_ID = m_pegawai_tipe.TIPE_PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_ORDER = "IRN"
				AND t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_PEMERIKSAAN_ID = "' . $idx . '"';
	}else if($ord == 'aps'){
		$jns_perawatan = '1';
		$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d-%m-%Y %H:%i") AS TANGGAL_DAFTAR,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR2,
				DATE_FORMAT(t_ipenunjang_tarif_pemeriksaan.TGL_DIAGNOSA,"%d-%m-%Y %H:%i") AS TANGGAL_DIAGNOSA,
				t_ipenunjang.NAMA_PASIEN,t_ipenunjang.NO_PASIEN_PENUNJANG AS NOMR,t_ipenunjang.TGL_LAHIR,t_ipenunjang.ALAMAT,
				t_ipenunjang.INSTANSI_PENGIRIM AS NAMA_UNIT,m_jaminan.NAMA_JAMINAN, "" AS RAWAT_ID,
				t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang.PENGIRIM AS NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,"" AS UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,t_ipenunjang.JNS_KELAMIN,t_ipenunjang.NIK,t_ipenunjang.NO_TELEPON,
				t_ipenunjang.NAMA_SUAMI_ISTERI,t_ipenunjang_tarif_pemeriksaan.HASIL_DIAGNOSA,
				m_pegawai2.NAMA_PEGAWAI AS DOKTER_DIAGNOSA,t_ipenunjang_tarif.JENIS_FOTO,
				m_pegawai_tipe.KET_TIPE_PEGAWAI,t_ipenunjang_tarif_pemeriksaan.REVISI
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN t_ipenunjang_tarif_pemeriksaan ON (t_ipenunjang_tarif.PENUNJANG_TARIF_ID = t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang_tarif_pemeriksaan.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
				LEFT JOIN m_pegawai_tipe ON (m_pegawai2.TIPE_PEGAWAI_ID = m_pegawai_tipe.TIPE_PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_ORDER = "APS"
				AND t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_PEMERIKSAAN_ID = "' . $idx . '"';
	}else if($ord == 'hrj'){
		$jns_perawatan = '1';
		$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d-%m-%Y %H:%i") AS TANGGAL_DAFTAR,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR2,
				DATE_FORMAT(t_ipenunjang_tarif_pemeriksaan.TGL_DIAGNOSA,"%d-%m-%Y %H:%i") AS TANGGAL_DIAGNOSA,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_unit.NAMA_UNIT,"-Hemodialisa") AS NAMA_UNIT,
				m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,m_pasien.NO_TELEPON,
				m_pasien.NAMA_SUAMI_ISTERI,t_ipenunjang_tarif_pemeriksaan.HASIL_DIAGNOSA,
				m_pegawai2.NAMA_PEGAWAI AS DOKTER_DIAGNOSA,t_ipenunjang_tarif.JENIS_FOTO,
				m_pegawai_tipe.KET_TIPE_PEGAWAI,t_ipenunjang.HEMODIALISA_ID,
				t_ipenunjang_tarif_pemeriksaan.REVISI
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN t_ipenunjang_tarif_pemeriksaan ON (t_ipenunjang_tarif.PENUNJANG_TARIF_ID = t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang_tarif_pemeriksaan.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
				LEFT JOIN m_pegawai_tipe ON (m_pegawai2.TIPE_PEGAWAI_ID = m_pegawai_tipe.TIPE_PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_ORDER = "HRJ"
				AND t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_PEMERIKSAAN_ID = "' . $idx . '"';
	}else if($ord == 'hri'){
		$jns_perawatan = '2';
		$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d-%m-%Y %H:%i") AS TANGGAL_DAFTAR,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR2,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_ruang.NAMA_RUANG," Kelas",m_ruang.KELAS_RAWAT,"-Hemodialisa") AS NAMA_UNIT,
				m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.RUANG_ID AS UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,m_pasien.NO_TELEPON,
				m_pasien.NAMA_SUAMI_ISTERI,t_ipenunjang_tarif_pemeriksaan.HASIL_DIAGNOSA,
				m_pegawai2.NAMA_PEGAWAI AS DOKTER_DIAGNOSA,t_ipenunjang_tarif.JENIS_FOTO,
				m_pegawai_tipe.KET_TIPE_PEGAWAI,t_ipenunjang.HEMODIALISA_ID,
				t_ipenunjang_tarif_pemeriksaan.REVISI
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN t_ipenunjang_tarif_pemeriksaan ON (t_ipenunjang_tarif.PENUNJANG_TARIF_ID = t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang_tarif_pemeriksaan.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
				LEFT JOIN m_pegawai_tipe ON (m_pegawai2.TIPE_PEGAWAI_ID = m_pegawai_tipe.TIPE_PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_ORDER = "HRI"
				AND t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_PEMERIKSAAN_ID = "' . $idx . '"';
	}else if($ord == 'orj'){
		$jns_perawatan = '1';
		$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d-%m-%Y %H:%i") AS TANGGAL_DAFTAR,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR2,
				INNER JOIN t_ipenunjang_tarif_pemeriksaan ON (t_ipenunjang_tarif.PENUNJANG_TARIF_ID = t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_ID)
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_unit.NAMA_UNIT,"-Kamar Operasi") AS NAMA_UNIT,m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,m_pasien.NO_TELEPON,
				m_pasien.NAMA_SUAMI_ISTERI,t_ipenunjang_tarif_pemeriksaan.HASIL_DIAGNOSA,
				m_pegawai2.NAMA_PEGAWAI AS DOKTER_DIAGNOSA,t_ipenunjang_tarif.JENIS_FOTO,
				m_pegawai_tipe.KET_TIPE_PEGAWAI,t_ipenunjang_tarif_pemeriksaan.REVISI
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN t_ipenunjang_tarif_pemeriksaan ON (t_ipenunjang_tarif.PENUNJANG_TARIF_ID = t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang_tarif_pemeriksaan.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
				LEFT JOIN m_pegawai_tipe ON (m_pegawai2.TIPE_PEGAWAI_ID = m_pegawai_tipe.TIPE_PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_ORDER = "ORJ"
				AND t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_PEMERIKSAAN_ID = "' . $idx . '"';
	}else if($ord == 'ori'){
		$jns_perawatan = '2';
		$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d-%m-%Y %H:%i") AS TANGGAL_DAFTAR,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR2,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_ruang.NAMA_RUANG," Kelas",m_ruang.KELAS_RAWAT,"-Kamar Operasi") AS NAMA_UNIT,
				m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.RUANG_ID AS UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,m_pasien.NO_TELEPON,
				m_pasien.NAMA_SUAMI_ISTERI,t_ipenunjang_tarif_pemeriksaan.HASIL_DIAGNOSA,
				m_pegawai2.NAMA_PEGAWAI AS DOKTER_DIAGNOSA,t_ipenunjang_tarif.JENIS_FOTO,
				m_pegawai_tipe.KET_TIPE_PEGAWAI,t_ipenunjang_tarif_pemeriksaan.REVISI
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN t_ipenunjang_tarif_pemeriksaan ON (t_ipenunjang_tarif.PENUNJANG_TARIF_ID = t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang_tarif_pemeriksaan.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
				LEFT JOIN m_pegawai_tipe ON (m_pegawai2.TIPE_PEGAWAI_ID = m_pegawai_tipe.TIPE_PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_ORDER = "ORI"
				AND t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_PEMERIKSAAN_ID = "' . $idx . '"';									
	}				
	$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
	$dat_rad = mysql_fetch_assoc($get_pasien);
	$nomr = formatNomr($dat_rad['NOMR']);
	$nama_pasien = $dat_rad['NAMA_PASIEN'];
	$tgl_lahir = changeDateFormat($dat_rad['TGL_LAHIR']);
	$jns_kelamin = $dat_rad['JNS_KELAMIN'];
	$alamat = $dat_rad['ALAMAT'];
	$nik = $dat_rad['NIK'];
	$jns_pembayaran = $dat_rad['NAMA_JAMINAN'];

	$penunjang_id = $dat_rad['PENUNJANG_ID'];
	$pegawai_id = $dat_rad['NAMA_PEGAWAI'];
	$nama_unit = $dat_rad['NAMA_UNIT'];
	$tgl_daftar = $dat_rad['TANGGAL_DAFTAR'];
	$tgl_daftar2 = $dat_rad['TANGGAL_DAFTAR2'];
	$rawat_id = $dat_rad['RAWAT_ID'];

	$no_telepon = $dat_rad['NO_TELEPON']; 
	$umur = getUmurDaftar($tgl_lahir,$tgl_daftar2);
	$nama_suami_isteri = $dat_rad['NAMA_SUAMI_ISTERI'];

	$tanggal_diagnosa = $dat_rad['TANGGAL_DIAGNOSA'];
	$hasil_diagnosa = $dat_rad['HASIL_DIAGNOSA'];
	$dokter_diagnosa = $dat_rad['DOKTER_DIAGNOSA'];
	$jenis_foto = $dat_rad['JENIS_FOTO'];
	$tipe_pegawai = $dat_rad['KET_TIPE_PEGAWAI'];
	
	$nomor = $dat_rad['NO_TARIF'];
	$rev = $dat_rad['REVISI'];
	
	if($ord == 'irj' or $ord == 'orj'){
		$qry_diagnosa = 'SELECT t_irja_diagnosa.DIAGNOSA,
								CASE WHEN TRIM(t_irja_diagnosa.DIAGNOSA) = TRIM(m_icd_x.DESKRIPSI) THEN t_irja_diagnosa.ICD_CODE
								ELSE CONCAT(t_irja_diagnosa.ICD_CODE,"--",m_icd_x.DESKRIPSI) END AS ICD
								FROM t_irja_diagnosa
								LEFT JOIN m_icd_x ON (t_irja_diagnosa.ICD_CODE = m_icd_x.ICD_CODE)
								WHERE t_irja_diagnosa.IRJA_ID = "' . $rawat_id . '"
								ORDER BY t_irja_diagnosa.DIAGNOSA_ORDER';
	} else if($ord == 'irn' or $ord == 'ori'){
		$qry_diagnosa = 'SELECT t_irna_diagnosa.DIAGNOSA,
								CASE WHEN TRIM(t_irna_diagnosa.DIAGNOSA) = TRIM(m_icd_x.DESKRIPSI) THEN t_irna_diagnosa.ICD_CODE
								ELSE CONCAT(t_irna_diagnosa.ICD_CODE,"--",m_icd_x.DESKRIPSI) END AS ICD
								FROM t_irna_diagnosa
								LEFT JOIN m_icd_x ON (t_irna_diagnosa.ICD_CODE = m_icd_x.ICD_CODE)
								WHERE t_irna_diagnosa.IRNA_ID = "' . $rawat_id . '"
								ORDER BY t_irna_diagnosa.DIAGNOSA_ORDER';
	} else if($ord == 'aps'){
		$qry_diagnosa = 'SELECT t_ipenunjang.DIAGNOSA_PENGIRIM AS DIAGNOSA, "" AS ICD
								FROM t_ipenunjang WHERE PENUNJANG_ID = "' . $idx. '"';
	} else if($ord == 'hrj'){
		$qry_diagnosa = 'SELECT t_hemodialisa_diagnosa.DIAGNOSA,
								CASE WHEN TRIM(t_hemodialisa_diagnosa.DIAGNOSA) = TRIM(m_icd_x.DESKRIPSI) THEN t_hemodialisa_diagnosa.ICD_CODE
								ELSE CONCAT(t_hemodialisa_diagnosa.ICD_CODE,"--",m_icd_x.DESKRIPSI) END AS ICD
								FROM t_hemodialisa_diagnosa
								LEFT JOIN m_icd_x ON (t_hemodialisa_diagnosa.ICD_CODE = m_icd_x.ICD_CODE)
								WHERE t_hemodialisa_diagnosa.HEMODIALISA_ID = "' . $hemodialisa_id . '"
								ORDER BY t_hemodialisa_diagnosa.DIAGNOSA_ORDER';
	} else if($ord == 'hri'){
		$qry_diagnosa = 'SELECT t_hemodialisa_diagnosa.DIAGNOSA,
								CASE WHEN TRIM(t_hemodialisa_diagnosa.DIAGNOSA) = TRIM(m_icd_x.DESKRIPSI) THEN t_hemodialisa_diagnosa.ICD_CODE
								ELSE CONCAT(t_hemodialisa_diagnosa.ICD_CODE,"--",m_icd_x.DESKRIPSI) END AS ICD
								FROM t_hemodialisa_diagnosa
								LEFT JOIN m_icd_x ON (t_hemodialisa_diagnosa.ICD_CODE = m_icd_x.ICD_CODE)
								WHERE t_hemodialisa_diagnosa.HEMODIALISA_ID = "' . $hemodialisa_id . '"
								ORDER BY t_hemodialisa_diagnosa.DIAGNOSA_ORDER';					
	}

	$diagnosa = '';
	$d = 1;
	$get_diagnosa = mysql_query($qry_diagnosa) or die(mysql_error());
	while($dat_diagnosa = mysql_fetch_array($get_diagnosa)){
		$diagnosa .= ' ' . $d . '. ' . trim($dat_diagnosa['DIAGNOSA']);
		if(trim($dat_diagnosa['ICD']) != '') $diagnosa .= ' (' . trim($dat_diagnosa['ICD']) . ')';
		$diagnosa .= ',';
		$d++;
	}

	if($diagnosa != '') $diagnosa = substr($diagnosa,0,strlen($diagnosa)-1);
	
	$templaterad->setValue('nama_pasien', htmlspecialchars($nama_pasien));
	$templaterad->setValue('nomor_mr', $nomr);
	$templaterad->setValue('umur', htmlspecialchars($umur));
	$templaterad->setValue('alamat', htmlspecialchars($alamat . ' ' . $no_telepon));
	$templaterad->setValue('tanggal', $tgl_daftar);
	
	$templaterad->setValue('dokter_pengirim', htmlspecialchars('Yth. ' . $pegawai_id));
	$templaterad->setValue('unit_pengirim', htmlspecialchars($nama_unit));
	$templaterad->setValue('diagnosa_klinis', htmlspecialchars('Klinis : ' . $diagnosa));
	
	$hasil_diagnosa = replace_newline($hasil_diagnosa);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($hasil_diagnosa);
	$templaterad->setValue('diagnosa',$toOpenXML);
	
	$templaterad->setValue('dokter_diagnosa', htmlspecialchars($dokter_diagnosa));
	$templaterad->setValue('spesialis', htmlspecialchars($tipe_pegawai));
	
		
	if(!file_exists($rmfile_path . '/pdf/' . $jns_perawatan . '/' . $dat_rad['NOMR'] . '/' . $rawat_id)){
		@mkdir($rmfile_path . '/pdf/' . $jns_perawatan . '/' . $dat_rad['NOMR'] . '/' . $rawat_id, 0700, true);
	}

	if(!file_exists($rmfile_path . '/doc/' . $jns_perawatan . '/' . $dat_rad['NOMR'] . '/' . $rawat_id)){
		@mkdir($rmfile_path . '/doc/' . $jns_perawatan . '/' . $dat_rad['NOMR'] . '/' . $rawat_id, 0700, true);
	}
	
	$nama_file = $dat_rad['NOMR'] . '_' . strtoupper($ord) . $rawat_id . '_6_' . $nomor . '_' . $idx . '_' . $rev;	
	$templaterad->saveAs($rmfile_path . '/doc/' . $jns_perawatan . '/' . $dat_rad['NOMR'] . '/' . $rawat_id . '/' . $nama_file . '.docx');
	mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE RAWAT_ID = "' . $rawat_id . '"
				AND JNS_PERAWATAN = "' . $jns_perawatan . '"
				AND JENIS_DOKUMEN_ID = "6"
				AND ORDER_PENUNJANG = "' . strtoupper($ord) . $nomor . $idx . $rev . '"') or die(mysql_error());
	mysql_query('INSERT INTO t_rm_dokumen_file(JENIS_DOKUMEN_ID,NOMR,RAWAT_ID,JNS_PERAWATAN,NAMA_FILE,ST_SISTEM,
				ORDER_PENUNJANG,TANGGAL) VALUES("6","' . $dat_rad['NOMR'] . '","' . $rawat_id . '","' . $jns_perawatan . '",
				"' . $nama_file . '.pdf","1","' . strtoupper($ord) . $nomor . $idx . $rev . '",
				STR_TO_DATE("' . $dat_rad['TANGGAL_DAFTAR2'] . '","%d/%m/%Y"))') or die(mysql_error());	

	$source_file = $rmfile_path . '/doc/' . $jns_perawatan . '/' . $dat_rad['NOMR'] . '/' . $rawat_id . '/' . $nama_file . '.docx';			
	$source_file = str_replace('/','\\',$source_file);
	$target_file = $rmfile_path . '/pdf/' . $jns_perawatan . '/' . $dat_rad['NOMR'] . '/' . $rawat_id . '/' . $nama_file . '.pdf';
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