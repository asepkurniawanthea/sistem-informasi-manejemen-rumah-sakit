<?php
function erm_lembar_fisioterapi($idx,$pnj,$ord,$sjp){
	global $rmfile_path, $app_path;
	
	$templateklinik = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\lembar_fisioterapi.docx');
	
$ord = strtolower($ord);
$jns_perawatan = '';
if($ord == 'irj'){
	$jns_perawatan = '1';
	$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d-%m-%Y") AS TANGGAL_DAFTAR,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,m_pasien.ALAMAT,
				m_unit.NAMA_UNIT,m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,
				t_ipenunjang_tarif.ST_PERIKSA,t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID,t_ipenunjang_tarif.HASIL_DIAGNOSA,
				t_ipenunjang.HEMODIALISA_ID,t_ipenunjang_tarif.ST_FINAL,t_ipenunjang.JENIS_BAYAR_ID,
				t_ipenunjang_tarif.TANGGAL_MASUK
				FROM t_ipenunjang
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				WHERE t_ipenunjang.JNS_ORDER = "IRJ"
				AND t_ipenunjang_tarif.NO_SJP = "' . $sjp . '"
				AND t_ipenunjang.PENUNJANG_ID = "' . $pnj . '"';
}else if($ord == 'irn'){
	$jns_perawatan = '2';
	$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d-%m-%Y") AS TANGGAL_DAFTAR,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_ruang.NAMA_RUANG," Kelas",m_ruang.KELAS_RAWAT) AS NAMA_UNIT,
				m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.RUANG_ID AS UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,
				t_ipenunjang_tarif.ST_PERIKSA,t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID,t_ipenunjang_tarif.HASIL_DIAGNOSA,
				t_ipenunjang.HEMODIALISA_ID,t_ipenunjang_tarif.ST_FINAL,t_ipenunjang.JENIS_BAYAR_ID,
				t_ipenunjang_tarif.TANGGAL_MASUK
				FROM t_ipenunjang
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				WHERE t_ipenunjang.JNS_ORDER = "IRN"
				AND t_ipenunjang_tarif.NO_SJP = "' . $sjp . '"
				AND t_ipenunjang.PENUNJANG_ID = "' . $pnj . '"';
}else if($ord == 'aps'){
	$jns_perawatan = '1';
	$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d-%m-%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.NAMA_PASIEN,t_ipenunjang.NO_PASIEN_PENUNJANG AS NOMR,DATE_FORMAT(t_ipenunjang.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,t_ipenunjang.ALAMAT,
				t_ipenunjang.INSTANSI_PENGIRIM AS NAMA_UNIT,m_jaminan.NAMA_JAMINAN,t_ipenunjang.PENUNJANG_ID AS RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang.PENGIRIM AS NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,"" AS UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,t_ipenunjang.JNS_KELAMIN,t_ipenunjang.NIK,
				t_ipenunjang_tarif.ST_PERIKSA,t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID,t_ipenunjang_tarif.HASIL_DIAGNOSA,
				t_ipenunjang.HEMODIALISA_ID,t_ipenunjang_tarif.ST_FINAL,t_ipenunjang.JENIS_BAYAR_ID,
				t_ipenunjang_tarif.TANGGAL_MASUK
				FROM t_ipenunjang
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				WHERE t_ipenunjang.JNS_ORDER = "APS"
				AND t_ipenunjang_tarif.NO_SJP = "' . $sjp . '"
				AND t_ipenunjang.PENUNJANG_ID = "' . $pnj . '"';
}else if($ord == 'hrj'){
	$jns_perawatan = '1';
	$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d-%m-%Y") AS TANGGAL_DAFTAR,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_unit.NAMA_UNIT,"-Hemodialisa") AS NAMA_UNIT,m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,
				t_ipenunjang_tarif.ST_PERIKSA,t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID,t_ipenunjang_tarif.HASIL_DIAGNOSA,
				t_ipenunjang.HEMODIALISA_ID,t_ipenunjang_tarif.ST_FINAL,t_ipenunjang.JENIS_BAYAR_ID,
				t_ipenunjang_tarif.TANGGAL_MASUK
				FROM t_ipenunjang
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				WHERE t_ipenunjang.JNS_ORDER = "HRJ"
				AND t_ipenunjang_tarif.NO_SJP = "' . $sjp . '"
				AND t_ipenunjang.PENUNJANG_ID = "' . $pnj . '"';
}else if($ord == 'hri'){
	$jns_perawatan = '2';
	$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d-%m-%Y") AS TANGGAL_DAFTAR,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_ruang.NAMA_RUANG," Kelas",m_ruang.KELAS_RAWAT,"-Hemodialisa") AS NAMA_UNIT,
				m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.RUANG_ID AS UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,
				t_ipenunjang_tarif.ST_PERIKSA,t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID,t_ipenunjang_tarif.HASIL_DIAGNOSA,
				t_ipenunjang.HEMODIALISA_ID,t_ipenunjang_tarif.ST_FINAL,t_ipenunjang.JENIS_BAYAR_ID,
				t_ipenunjang_tarif.TANGGAL_MASUK
				FROM t_ipenunjang
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				WHERE t_ipenunjang.JNS_ORDER = "HRI"
				AND t_ipenunjang_tarif.NO_SJP = "' . $sjp . '"
				AND t_ipenunjang.PENUNJANG_ID = "' . $pnj . '"';				
}				
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$nomr = $dat_pasien['NOMR'];
$nama_pasien = $dat_pasien['NAMA_PASIEN'];
$tgl_lahir = $dat_pasien['TGL_LAHIR'];
$jns_kelamin = jenisKelamin($dat_pasien['JNS_KELAMIN']);

$pegawai_id = $dat_pasien['NAMA_PEGAWAI'];
$nama_unit = $dat_pasien['NAMA_UNIT'];
$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];
$rawat_id = $dat_pasien['RAWAT_ID'];

$templateklinik->setValue('nomor_rm', formatNomr($nomr));
$templateklinik->setValue('nama_pasien', htmlspecialchars($nama_pasien));
$templateklinik->setValue('tgl_lahir', htmlspecialchars($tgl_lahir));
$templateklinik->setValue('jenis_kelamin', htmlspecialchars($jns_kelamin));
$templateklinik->setValue('unit', htmlspecialchars($nama_unit));
	
$qry_perkembangan = 'SELECT DATE_FORMAT(TANGGAL,"%d-%m-%Y") AS TANGGAL,
		PEMERIKSAAN_DAN_EVALUASI,TERAPI,TK_CACAT,NAMA_PEGAWAI
	FROM t_pemeriksaan_fisioterapi
	LEFT JOIN m_pegawai ON (t_pemeriksaan_fisioterapi.FISIOTERAPIST = m_pegawai.PEGAWAI_ID)
	WHERE RAWAT_ID = "' . $rawat_id . '"';
$get_perkembangan = mysql_query($qry_perkembangan) or die(mysql_error());
if(mysql_num_rows($get_perkembangan) > 0){
	$templateklinik->cloneRow('tgl', mysql_num_rows($get_perkembangan));
	$x = 1;
	while($dat_perkembangan = mysql_fetch_array($get_perkembangan)){
		$templateklinik->setValue('tgl#' . $x, htmlspecialchars($dat_perkembangan['TANGGAL']));
		$templateklinik->setValue('pemeriksaan#' . $x, htmlspecialchars($dat_perkembangan['PEMERIKSAAN_DAN_EVALUASI']));
		$templateklinik->setValue('terapi#' . $x, htmlspecialchars($dat_perkembangan['TERAPI']));
		$templateklinik->setValue('tk_cacat#' . $x, htmlspecialchars($dat_perkembangan['TK_CACAT']));
		$templateklinik->setValue('fisioterapist#' . $x, htmlspecialchars($dat_perkembangan['NAMA_PEGAWAI']));
		$x++;	
	}	
}else{
	$templateklinik->setValue('tgl', '');
	$templateklinik->setValue('pemeriksaan', '');
	$templateklinik->setValue('terapi', '');
	$templateklinik->setValue('tk_cacat', '');
	$templateklinik->setValue('fisioterapist', '');
}		
	
if(!file_exists($rmfile_path . '/pdf/1/' . $nomr . '/' . $idx)){
	@mkdir($rmfile_path . '/pdf/1/' . $nomr . '/' . $idx, 0700, true);
}

if(!file_exists($rmfile_path . '/doc/1/' . $nomr . '/' . $idx)){
	@mkdir($rmfile_path . '/doc/1/' . $nomr . '/' . $idx, 0700, true);
}
	
$nama_file = $nomr . '_' . $rawat_id . '_' . $pnj . '_' . $sjp . '_27';	
$templateklinik->saveAs($rmfile_path . '/doc/1/' . $nomr . '/' . $idx . '/' . $nama_file . '.docx');
	
mysql_query('DELETE FROM t_rm_dokumen_file 
		WHERE RAWAT_ID = "' . $rawat_id . '"
		AND JNS_PERAWATAN = "' . $jns_perawatan . '"
		AND JENIS_DOKUMEN_ID = "27"
		AND NAMA_FILE = "' . $nama_file . '.pdf"') or die(mysql_error());
mysql_query('INSERT INTO t_rm_dokumen_file(JENIS_DOKUMEN_ID,NOMR,RAWAT_ID,JNS_PERAWATAN,NAMA_FILE,ST_SISTEM) 		
		VALUES("27","' . $nomr . '","' . $rawat_id . '","' . $jns_perawatan . '","' . $nama_file . '.pdf","1")') or die(mysql_error());
	
$source_file = $rmfile_path . '/doc/' . $jns_perawatan . '/' . $nomr . '/' . $rawat_id . '/' . $nama_file . '.docx';			
$source_file = str_replace('/','\\',$source_file);
$target_file = $rmfile_path . '/pdf/' . $jns_perawatan . '/' . $nomr . '/' . $rawat_id . '/' . $nama_file . '.pdf';
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