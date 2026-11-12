<?php
function replace_newline($str){
	$ret = preg_replace('/\r|\n/','\n',trim($str));
	$ret = str_replace('\n','<br>',$ret);
	$ret = str_replace('<br><br>','<br>',$ret);
	return $ret;
}

function erm_transfer_pasien($idx,$rawat,$in_eks){
	global $rmfile_path, $app_path;

	$checked = '<w:sym w:font="Wingdings" w:char="F0FE"/>';
    $unChecked = '<w:sym w:font="Wingdings" w:char="F0A8"/>';
	
	if($in_eks == 'I') $templateklinik = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\transfer_pasien_internal.docx');
	if($in_eks == 'E') $templateklinik = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\transfer_pasien_eksternal.docx');
	
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

	if($rawat == '2'){
		$qry_pasien = 'SELECT t_irna.IRNA_ID AS IRJA_ID,t_irna.NOMR,t_irna.PEGAWAI_ID,m_pegawai.NAMA_PEGAWAI,
				NULL AS ASAL_PASIEN_ID,"" AS KET_ASAL_PASIEN,
				t_irna.RUANG_ID AS UNIT_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,
				m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				DATE_FORMAT(t_irna.PASIEN_MASUK,"%d-%m-%Y %H:%i") AS PASIEN_MASUK,
				t_irna.JENIS_BAYAR_ID,m_pasien.NO_TELEPON,
				DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_ruang.NAMA_RUANG AS NAMA_UNIT,m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,
				m_kelurahan.NAMA_KELURAHAN,m_kecamatan.NAMA_KECAMATAN,
				m_kota.NAMA_KOTA
				FROM t_irna
				INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
				WHERE t_irna.IRNA_ID = "' . $idx . '"';
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
		$qry_transfer = 'SELECT IRJA_TRANSFER_ID,PENERIMA,UNIT_PENERIMA,ALAMAT,TELEPON,KONTAK,ALASAN_MASUK,
			ALASAN_TRANSFER,KETERANGAN,INPUS,OBAT,TINDAKAN,KONDISI_PASIEN,DIET,MOBILISASI,EDUKASI,
			CARA_TRANSPORTASI,KONDISI_PASIEN_SELAMA_TRANSFER,HASIL_LABORATORIUM,HASIL_RADIOLOGI,
			HASIL_PENUNJANG,OBAT_PARENTERAL,OBAT_ORAL,BARANG_LAIN,
			DATE_FORMAT(TGL_ASSESMENT,"%d-%m-%Y %H:%i") AS TGL_ASSESMENT
			FROM t_irja_transfer_pasien
			WHERE IRJA_TRANSFER_ID = "' . $idx . '"
			AND INTERNAL_EKSTERNAL = "' . $in_eks . '"';
	}
	if($rawat == '2'){
		$qry_transfer = 'SELECT IRNA_TRANSFER_ID,PENERIMA,UNIT_PENERIMA,ALAMAT,TELEPON,KONTAK,ALASAN_MASUK,
			ALASAN_TRANSFER,KETERANGAN,INPUS,OBAT,TINDAKAN,KONDISI_PASIEN,DIET,MOBILISASI,EDUKASI,
			CARA_TRANSPORTASI,KONDISI_PASIEN_SELAMA_TRANSFER,HASIL_LABORATORIUM,HASIL_RADIOLOGI,
			HASIL_PENUNJANG,OBAT_PARENTERAL,OBAT_ORAL,BARANG_LAIN,
			DATE_FORMAT(TGL_ASSESMENT,"%d-%m-%Y %H:%i") AS TGL_ASSESMENT
			FROM t_irna_transfer_pasien
			WHERE IRNA_TRANSFER_ID = "' . $idx . '"
			AND INTERNAL_EKSTERNAL = "' . $in_eks . '"';
	}	
	$get_transfer = mysql_query($qry_transfer) or die(mysql_error());
	$dat_transfer = mysql_fetch_assoc($get_transfer);
	$penerima = $dat_transfer['PENERIMA'];
	$unit_penerima = $dat_transfer['UNIT_PENERIMA'];
	$alamat = $dat_transfer['ALAMAT'];
	$telepon = $dat_transfer['TELEPON'];
	$kontak = $dat_transfer['KONTAK'];
	$alasan_masuk = $dat_transfer['ALASAN_MASUK'];
	$alasan_transfer = $dat_transfer['ALASAN_TRANSFER'];
	$keterangan = $dat_transfer['KETERANGAN'];
	$inpus = $dat_transfer['INPUS'];
	$obat = $dat_transfer['OBAT'];
	$tindakan = $dat_transfer['TINDAKAN'];

	$kondisi_pasien = str_replace('|','"',$dat_transfer['KONDISI_PASIEN']);
	$kondisi_pasien = preg_replace('/\r|\n/','\n',trim($kondisi_pasien));
	$kondisi_pasien = json_decode($kondisi_pasien,true);

	$diet = $dat_transfer['DIET'];
	$mobilisasi = $dat_transfer['MOBILISASI'];
	$edukasi = $dat_transfer['EDUKASI'];
	$cara_transportasi = $dat_transfer['CARA_TRANSPORTASI'];

	$kondisi_pasien_selama_transfer = str_replace('|','"',$dat_transfer['KONDISI_PASIEN_SELAMA_TRANSFER']);
	$kondisi_pasien_selama_transfer = preg_replace('/\r|\n/','\n',trim($kondisi_pasien_selama_transfer));
	$kondisi_pasien_selama_transfer = json_decode($kondisi_pasien_selama_transfer,true);

	$hasil_laboratorium = $dat_transfer['HASIL_LABORATORIUM'];
	$hasil_radiologi = $dat_transfer['HASIL_RADIOLOGI'];
	$hasil_penunjang = $dat_transfer['HASIL_PENUNJANG'];
	$obat_parenteral = $dat_transfer['OBAT_PARENTERAL'];
	$obat_oral = $dat_transfer['OBAT_ORAL'];
	$barang_lain = $dat_transfer['BARANG_LAIN'];
	$tgl_assesment = $dat_transfer['TGL_ASSESMENT'];
	
	$asal_pasien = '';
	if($rawat == '1'){
		if($unit_id == '9' or $unit_id == '64') $asal_pasien = $nama_unit;
		if($unit_id != '9' and $unit_id != '64') $asal_pasien = 'Poliklinik ' . $nama_unit;
	}
	if($rawat == '2'){
		$asal_pasien = $nama_unit;
	}	
	$templateklinik->setValue('asal_pasien', htmlspecialchars($asal_pasien));
	$templateklinik->setValue('nama_penerima', htmlspecialchars($penerima));
	$templateklinik->setValue('unit_penerima', htmlspecialchars($unit_penerima));
	
	$alamat = replace_newline($alamat);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($alamat);
	$templateklinik->setValue('alamat', $toOpenXML);
	
	$templateklinik->setValue('telepon', htmlspecialchars($telepon));
	$templateklinik->setValue('kontak', htmlspecialchars($kontak));
	
	$templateklinik->setValue('nama_pasien', htmlspecialchars($nama_pasien));
	$templateklinik->setValue('tgl_lahir', htmlspecialchars($tgl_lahir));
	$templateklinik->setValue('alamat_pasien', htmlspecialchars($alamat_pasien));
	$templateklinik->setValue('jns_kelamin', htmlspecialchars($jns_kelamin));
	$templateklinik->setValue('rt_rw', htmlspecialchars($alamat_pasien_rt . '/' . $alamat_pasien_rw));
	$templateklinik->setValue('kelurahan', htmlspecialchars($kelurahan));
	$templateklinik->setValue('kecamatan', htmlspecialchars($kecamatan));
	$templateklinik->setValue('wilayah', htmlspecialchars($kota));
	$templateklinik->setValue('kode_pos', htmlspecialchars(''));
	
	$alasan_masuk = replace_newline($alasan_masuk);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($alasan_masuk);
	$templateklinik->setValue('alasan_masuk', $toOpenXML);
	
	if($rawat == '1'){
		$qry_diagnosa = 'SELECT DIAGNOSA_ORDER,DIAGNOSA
			FROM t_irja_diagnosa
			WHERE IRJA_ID = "' . $idx . '"
			AND DIAGNOSA_ORDER <= 3
			ORDER BY DIAGNOSA_ORDER';
	}
	if($rawat == '2'){
		$qry_diagnosa = 'SELECT DIAGNOSA_ORDER,DIAGNOSA
			FROM t_irna_diagnosa
			WHERE IRNA_ID = "' . $idx . '"
			AND DIAGNOSA_ORDER <= 3
			ORDER BY DIAGNOSA_ORDER';
	}	
	$get_diagnosa = mysql_query($qry_diagnosa) or die(mysql_error());
	$j_row = mysql_num_rows($get_diagnosa);
	if($j_row > 0){
		$templateklinik->cloneRow('dhd', $j_row);
		$d=1;
		while($dat_diagnosa= mysql_fetch_array($get_diagnosa)){
			if($d==1) {
				$templateklinik->setValue('dhd#' . $d,'Diagnosa');
			}else{
				$templateklinik->setValue('dhd#' . $d,'');
			}		
		$templateklinik->setValue('dtx#' . $d,': ' . htmlspecialchars($dat_diagnosa['DIAGNOSA']));
		$d++;
		}
	}else{
		$templateklinik->setValue('dhd','Diagnosa');
		$templateklinik->setValue('dtx',':');
	}		
	
	if($rawat == '1'){
		$qry_diagnosa = 'SELECT DIAGNOSA_ORDER,DIAGNOSA
			FROM t_irja_diagnosa
			WHERE IRJA_ID = "' . $idx . '"
			AND DIAGNOSA_ORDER >= 4
			ORDER BY DIAGNOSA_ORDER';
	}		
	$get_diagnosa = mysql_query($qry_diagnosa) or die(mysql_error());
	$j_row = mysql_num_rows($get_diagnosa);
	if($j_row > 0){
		$templateklinik->cloneRow('dhe', $j_row);
		$d=1;
		while($dat_diagnosa= mysql_fetch_array($get_diagnosa)){
			if($d==1) {
				$templateklinik->setValue('dhe#' . $d,'Diagnosa Banding');
			}else{
				$templateklinik->setValue('dhe#' . $d,'');
			}		
			$templateklinik->setValue('dty#' . $d,': ' . htmlspecialchars($dat_diagnosa['DIAGNOSA']));
		$d++;
		}
	}else{
		$templateklinik->setValue('dhe','Diagnosa Banding');
		$templateklinik->setValue('dty',':');
	}		
	
	if($alasan_transfer == '1'){
		$templateklinik->setValue('al_1',$checked);
		$templateklinik->setValue('al_2',$unChecked);
		$templateklinik->setValue('al_3',$unChecked);
		$templateklinik->setValue('al_4',$unChecked);
	}	
	if($alasan_transfer == '2'){
		$templateklinik->setValue('al_1',$unChecked);
		$templateklinik->setValue('al_2',$checked);
		$templateklinik->setValue('al_3',$unChecked);
		$templateklinik->setValue('al_4',$unChecked);
	}
	if($alasan_transfer == '3'){
		$templateklinik->setValue('al_1',$unChecked);
		$templateklinik->setValue('al_2',$unChecked);
		$templateklinik->setValue('al_3',$checked);
		$templateklinik->setValue('al_4',$unChecked);
	}
	if($alasan_transfer == '4'){
		$templateklinik->setValue('al_1',$unChecked);
		$templateklinik->setValue('al_2',$unChecked);
		$templateklinik->setValue('al_3',$unChecked);
		$templateklinik->setValue('al_4',$checked);
	}
	if($alasan_transfer == ''){
		$templateklinik->setValue('al_1',$unChecked);
		$templateklinik->setValue('al_2',$unChecked);
		$templateklinik->setValue('al_3',$unChecked);
		$templateklinik->setValue('al_4',$unChecked);
	}
	
	$keterangan = replace_newline($keterangan);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($keterangan);
	$templateklinik->setValue('keterangan', $toOpenXML);
	
	$inpus = replace_newline($inpus);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($inpus);
	$templateklinik->setValue('infus', $toOpenXML);
	
	$obat = replace_newline($obat);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($obat);
	$templateklinik->setValue('obat', $toOpenXML);
	
	$tindakan = replace_newline($tindakan);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($tindakan);
	$templateklinik->setValue('tindakan', $toOpenXML);
	
	if($kondisi_pasien['kp_kesadaran'] == ''){
		$templateklinik->setValue('ks_1',$unChecked);
		$templateklinik->setValue('ks_2',$unChecked);
		$templateklinik->setValue('ks_3',$unChecked);
		$templateklinik->setValue('ks_4',$unChecked);
	}
	if($kondisi_pasien['kp_kesadaran'] == '1'){
		$templateklinik->setValue('ks_1',$checked);
		$templateklinik->setValue('ks_2',$unChecked);
		$templateklinik->setValue('ks_3',$unChecked);
		$templateklinik->setValue('ks_4',$unChecked);
	}
	if($kondisi_pasien['kp_kesadaran'] == '2'){
		$templateklinik->setValue('ks_1',$unChecked);
		$templateklinik->setValue('ks_2',$checked);
		$templateklinik->setValue('ks_3',$unChecked);
		$templateklinik->setValue('ks_4',$unChecked);
	}
	if($kondisi_pasien['kp_kesadaran'] == '3'){
		$templateklinik->setValue('ks_1',$unChecked);
		$templateklinik->setValue('ks_2',$unChecked);
		$templateklinik->setValue('ks_3',$checked);
		$templateklinik->setValue('ks_4',$unChecked);
	}
	if($kondisi_pasien['kp_kesadaran'] == '4'){
		$templateklinik->setValue('ks_1',$unChecked);
		$templateklinik->setValue('ks_2',$unChecked);
		$templateklinik->setValue('ks_3',$unChecked);
		$templateklinik->setValue('ks_4',$checked);
	}
	
	$templateklinik->setValue('gcs','E : ' . $kondisi_pasien['kp_gcs_e'] . ' M : ' . $kondisi_pasien['kp_gcs_m'] . ' V : ' . $kondisi_pasien['kp_gcs_v']);
	$templateklinik->setValue('td',$kondisi_pasien['kp_td']);
	$templateklinik->setValue('nadi',$kondisi_pasien['kp_nadi']);
	$templateklinik->setValue('nafas',$kondisi_pasien['kp_nafas']);
	$templateklinik->setValue('suhu',$kondisi_pasien['kp_suhu']);
	$templateklinik->setValue('oksigen',$kondisi_pasien['kp_oksigen']);
	$templateklinik->setValue('cairan',$kondisi_pasien['kp_cairan']);
	$templateklinik->setValue('transfusi',$kondisi_pasien['kp_transfusi']);
	
	if($kondisi_pasien['kp_cateter'] == ''){
		$templateklinik->setValue('ct_ada',$unChecked);
		$templateklinik->setValue('ct_tdk',$unChecked);
	}
	if($kondisi_pasien['kp_cateter'] == '1'){
		$templateklinik->setValue('ct_ada',$checked);
		$templateklinik->setValue('ct_tdk',$unChecked);
	}
	if($kondisi_pasien['kp_cateter'] == '2'){
		$templateklinik->setValue('ct_ada',$unChecked);
		$templateklinik->setValue('ct_tdk',$checked);
	}
	$templateklinik->setValue('ct_pmk',$kondisi_pasien['kp_cateter_ke']);
	$templateklinik->setValue('ct_tanggal', 'tanggal ' . $kondisi_pasien['kp_cateter_tgl'] . ' pukul ' . $kondisi_pasien['kp_cateter_pkl']);
	
	$diet = replace_newline($diet);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($diet);
	$templateklinik->setValue('diet', $toOpenXML);
	
	$mobilisasi = replace_newline($mobilisasi);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($mobilisasi);
	$templateklinik->setValue('mobilisasi', $toOpenXML);
	
	$edukasi = replace_newline($edukasi);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($edukasi);
	$templateklinik->setValue('edukasi', $toOpenXML);
	
	if($cara_transportasi == ''){
		$templateklinik->setValue('ct_1',$unChecked);
		$templateklinik->setValue('ct_2',$unChecked);
		$templateklinik->setValue('ct_3',$unChecked);
		$templateklinik->setValue('ct_4',$unChecked);
		$templateklinik->setValue('ct_5',$unChecked);
	}
	if($cara_transportasi == '1'){
		$templateklinik->setValue('ct_1',$checked);
		$templateklinik->setValue('ct_2',$unChecked);
		$templateklinik->setValue('ct_3',$unChecked);
		$templateklinik->setValue('ct_4',$unChecked);
		$templateklinik->setValue('ct_5',$unChecked);
	}
	if($cara_transportasi == '2'){
		$templateklinik->setValue('ct_1',$unChecked);
		$templateklinik->setValue('ct_2',$checked);
		$templateklinik->setValue('ct_3',$unChecked);
		$templateklinik->setValue('ct_4',$unChecked);
		$templateklinik->setValue('ct_5',$unChecked);
	}
	if($cara_transportasi == '3'){
		$templateklinik->setValue('ct_1',$unChecked);
		$templateklinik->setValue('ct_2',$unChecked);
		$templateklinik->setValue('ct_3',$checked);
		$templateklinik->setValue('ct_4',$unChecked);
		$templateklinik->setValue('ct_5',$unChecked);
	}
	if($cara_transportasi == '4'){
		$templateklinik->setValue('ct_1',$unChecked);
		$templateklinik->setValue('ct_2',$unChecked);
		$templateklinik->setValue('ct_3',$unChecked);
		$templateklinik->setValue('ct_4',$checked);
		$templateklinik->setValue('ct_5',$unChecked);
	}
	if($cara_transportasi == '5'){
		$templateklinik->setValue('ct_1',$unChecked);
		$templateklinik->setValue('ct_2',$unChecked);
		$templateklinik->setValue('ct_3',$unChecked);
		$templateklinik->setValue('ct_4',$unChecked);
		$templateklinik->setValue('ct_5',$checked);
	}
	
	if($kondisi_pasien_selama_transfer['kpst_kesadaran'] == ''){
		$templateklinik->setValue('kst_1',$unChecked);
		$templateklinik->setValue('kst_2',$unChecked);
		$templateklinik->setValue('kst_3',$unChecked);
		$templateklinik->setValue('kst_4',$unChecked);
	}
	if($kondisi_pasien_selama_transfer['kpst_kesadaran'] == '1'){
		$templateklinik->setValue('kst_1',$checked);
		$templateklinik->setValue('kst_2',$unChecked);
		$templateklinik->setValue('kst_3',$unChecked);
		$templateklinik->setValue('kst_4',$unChecked);
	}
	if($kondisi_pasien_selama_transfer['kpst_kesadaran'] == '2'){
		$templateklinik->setValue('kst_1',$unChecked);
		$templateklinik->setValue('kst_2',$checked);
		$templateklinik->setValue('kst_3',$unChecked);
		$templateklinik->setValue('kst_4',$unChecked);
	}
	if($kondisi_pasien_selama_transfer['kpst_kesadaran'] == '3'){
		$templateklinik->setValue('kst_1',$unChecked);
		$templateklinik->setValue('kst_2',$unChecked);
		$templateklinik->setValue('kst_3',$checked);
		$templateklinik->setValue('kst_4',$unChecked);
	}
	if($kondisi_pasien_selama_transfer['kpst_kesadaran'] == '4'){
		$templateklinik->setValue('kst_1',$unChecked);
		$templateklinik->setValue('kst_2',$unChecked);
		$templateklinik->setValue('kst_3',$unChecked);
		$templateklinik->setValue('kst_4',$checked);
	}
	
	$templateklinik->setValue('gcst','E : ' . $kondisi_pasien_selama_transfer['kpst_gcs_e'] . ' M : ' . $kondisi_pasien_selama_transfer['kpst_gcs_m'] . ' V : ' . $kondisi_pasien_selama_transfer['kpst_gcs_v']);
	$templateklinik->setValue('tdt',$kondisi_pasien_selama_transfer['kpst_td']);
	$templateklinik->setValue('nadit',$kondisi_pasien_selama_transfer['kpst_nadi']);
	$templateklinik->setValue('nafast',$kondisi_pasien_selama_transfer['kpst_nafas']);
	$templateklinik->setValue('suhut',$kondisi_pasien_selama_transfer['kpst_suhu']);
	
	$hasil_laboratorium = replace_newline($hasil_laboratorium);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($hasil_laboratorium);
	$templateklinik->setValue('hasil_lab', $toOpenXML);
	
	$hasil_penunjang = replace_newline($hasil_penunjang);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($hasil_penunjang);
	$templateklinik->setValue('hasil_penunjang', $toOpenXML);
	
	$hasil_radiologi = replace_newline($hasil_radiologi);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($hasil_radiologi);
	$templateklinik->setValue('hasil_radiologi', $toOpenXML);
	
	$obat_parenteral = replace_newline($obat_parenteral);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($obat_parenteral);
	$templateklinik->setValue('obat_parenteral', $toOpenXML);
	
	$obat_oral = replace_newline($obat_oral);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($obat_oral);
	$templateklinik->setValue('obat_oral', $toOpenXML);
	
	$barang_lain = replace_newline($barang_lain);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($barang_lain);
	$templateklinik->setValue('barang_lainnya', $toOpenXML);
	
	$tanggal = '';
	$pukul = '';
	$arr_tgl_assesment = explode(' ',$tgl_assesment);
	if(sizeof($arr_tgl_assesment) == 2){
		$tanggal = $arr_tgl_assesment[0];
		$pukul = $arr_tgl_assesment[1];
	}	
	$templateklinik->setValue('tanggal', $tanggal);
	$templateklinik->setValue('pkl', $pukul);
	$templateklinik->setValue('yg_menyerahkan', $nama_dokter);
	$templateklinik->setValue('yg_menerima', $penerima);
	
	if(!file_exists($rmfile_path . '/pdf/' . $rawat . '/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/pdf/' . $rawat . '/' . $nomr . '/' . $idx, 0700, true);
	}

	if(!file_exists($rmfile_path . '/doc/' . $rawat . '/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/doc/' . $rawat . '/' . $nomr . '/' . $idx, 0700, true);
	}
	
	$jns_dokumen = '45';
	if($in_eks == 'E') $jns_dokumen = '46';
	
	$nama_file = $nomr . '_' . $idx . '_' . $jns_dokumen;	
	$templateklinik->saveAs($rmfile_path . '/doc/' . $rawat . '/' . $nomr . '/' . $idx . '/' . $nama_file . '.docx');
	
	mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE RAWAT_ID = "' . $idx . '"
				AND JNS_PERAWATAN = "' . $rawat . '"
				AND JENIS_DOKUMEN_ID = "' . $jns_dokumen . '"
				AND NAMA_FILE = "' . $nama_file . '.pdf"') or die(mysql_error());
	mysql_query('INSERT INTO t_rm_dokumen_file(JENIS_DOKUMEN_ID,NOMR,RAWAT_ID,JNS_PERAWATAN,NAMA_FILE,ST_SISTEM,TANGGAL) 		
				VALUES("' . $jns_dokumen . '","' . $nomr . '","' . $idx . '","' . $rawat . '","' . $nama_file . '.pdf","1",STR_TO_DATE("' . $tgl_daftar . '","%d/%m/%Y"))') or die(mysql_error());
	
	$source_file = $rmfile_path . '/doc/' . $rawat . '/' . $nomr . '/' . $idx . '/' . $nama_file . '.docx';			
	$source_file = str_replace('/','\\',$source_file);
	$target_file = $rmfile_path . '/pdf/' . $rawat . '/' . $nomr . '/' . $idx . '/' . $nama_file . '.pdf';
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