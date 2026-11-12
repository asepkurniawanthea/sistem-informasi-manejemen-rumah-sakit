<?php
function replace_newline($str){
	$ret = preg_replace('/\r|\n/','\n',trim($str));
	$ret = str_replace('\n','<br>',$ret);
	$ret = str_replace('<br><br>','<br>',$ret);
	return $ret;
}

function erm_rencana_pemulangan($idx,$irj){
	global $rmfile_path, $app_path;

	$checked = '<w:sym w:font="Wingdings" w:char="F0FE"/>';
    $unChecked = '<w:sym w:font="Wingdings" w:char="F0A8"/>';
	
	$templateklinik = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\rencana_pemulangan.docx');
	
	$jns_perawatan = '2';
		
		if($irj == '1'){
			$jns_perawatan = '1';
			$qry_pasien = 'SELECT t_irja.IRJA_ID,t_irja.NOMR,
				m_jaminan.NAMA_JAMINAN,t_irja.JENIS_BAYAR_ID,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,
				m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,m_pasien.NO_TELEPON,
				DATE_FORMAT(t_irja.PASIEN_MASUK,"%d-%m-%Y %H:%i") AS PASIEN_MASUK,
				DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_unit.NAMA_UNIT
				FROM t_irja
				INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				WHERE t_irja.IRJA_ID = "' . $idx . '"';
		}else{
			$qry_pasien = 'SELECT t_irna.IRNA_ID AS IRJA_ID,t_irna.NOMR,
				m_jaminan.NAMA_JAMINAN,t_irna.JENIS_BAYAR_ID,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,
				m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,m_pasien.NO_TELEPON,
				DATE_FORMAT(t_irna.PASIEN_MASUK,"%d-%m-%Y %H:%i") AS PASIEN_MASUK,
				DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_ruang.NAMA_RUANG AS NAMA_UNIT
				FROM t_irna
				INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				WHERE t_irna.IRJA_ID = "' . $idx . '"';	
		}		
	$get_pasien = mysql_query($qry_pasien);
	$dat_pasien = mysql_fetch_assoc($get_pasien);
	$nomr = $dat_pasien['NOMR'];
	$nama_pasien = $dat_pasien['NAMA_PASIEN'];
	$tgl_lahir = $dat_pasien['TGL_LAHIR'];
	$jns_kelamin = jenisKelamin($dat_pasien['JNS_KELAMIN']);
	$alamat = $dat_pasien['ALAMAT'];
	$nik = $dat_pasien['NIK'];
	$jns_pembayaran = $dat_pasien['NAMA_JAMINAN'];
	$jenis_bayar_id = $dat_pasien['JENIS_BAYAR_ID'];

	$irja_id = $dat_pasien['IRJA_ID'];
	$pasien_masuk = $dat_pasien['PASIEN_MASUK'];

	$no_telepon = $dat_pasien['NO_TELEPON'];
	$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];
	$nama_unit = $dat_pasien['NAMA_UNIT'];

	$umur = getUmurDaftar($tgl_lahir,$tgl_daftar);
	
	$templateklinik->setValue('nomor_rm', formatNomr($nomr));
	$templateklinik->setValue('nama_pasien', htmlspecialchars($nama_pasien));
	$templateklinik->setValue('tgl_lahir', htmlspecialchars($tgl_lahir));
	$templateklinik->setValue('jenis_kelamin', htmlspecialchars($jns_kelamin));
	$templateklinik->setValue('unit', htmlspecialchars($nama_unit));
	$templateklinik->setValue('tgl_masuk', $pasien_masuk);
	
	if($irj == '1'){
		$qry_rencana = 'SELECT IRJA_ID,RENCANA_PULANG,t_igd_rencana_pulang.PEGAWAI_ID,PEGAWAI_ID_2,
			DATE_FORMAT(TGL_ASSESMENT,"%d-%m-%Y %H:%i") AS TGL_ASSESMENT,
			md.NAMA_PEGAWAI AS NAMA_DOKTER,mp.NAMA_PEGAWAI AS NAMA_PERAWAT
			FROM t_igd_rencana_pulang
			LEFT JOIN m_pegawai md ON (t_igd_rencana_pulang.PEGAWAI_ID = md.PEGAWAI_ID)
			LEFT JOIN m_pegawai mp ON (t_igd_rencana_pulang.PEGAWAI_ID_2 = mp.PEGAWAI_ID)
			WHERE IRJA_ID = "' . $idx . '"';
	}else{
		$qry_rencana = 'SELECT IRNA_ID AS IRJA_ID,RENCANA_PULANG,t_irna_rencana_pulang.PEGAWAI_ID,PEGAWAI_ID_2,
			DATE_FORMAT(TGL_ASSESMENT,"%d-%m-%Y %H:%i") AS TGL_ASSESMENT,
			md.NAMA_PEGAWAI AS NAMA_DOKTER,mp.NAMA_PEGAWAI AS NAMA_PERAWAT
			FROM t_irna_rencana_pulang
			LEFT JOIN m_pegawai md ON (t_irna_rencana_pulang.PEGAWAI_ID = md.PEGAWAI_ID)
			LEFT JOIN m_pegawai mp ON (t_irna_rencana_pulang.PEGAWAI_ID_2 = mp.PEGAWAI_ID)
			WHERE IRNA_ID = "' . $idx . '"';
	}
	
	$get_rencana = mysql_query($qry_rencana) or die(mysql_error());
	$dat_rencana = mysql_fetch_assoc($get_rencana);
	$idx = $dat_rencana['IRJA_ID'];
	
	$templateklinik->setValue('tgl_assesment', $dat_rencana['TGL_ASSESMENT']);
	$templateklinik->setValue('dicetak_oleh', '');
	$templateklinik->setValue('nama_dokter', htmlspecialchars($dat_rencana['NAMA_DOKTER']));
	$templateklinik->setValue('nama_perawat', htmlspecialchars($dat_rencana['NAMA_PERAWAT']));
	
	$rencana_pulang = str_replace('|','"',$dat_rencana['RENCANA_PULANG']);
	$rencana_pulang = preg_replace('/\r|\n/','\n',trim($rencana_pulang));
	$rencana_pulang = json_decode($rencana_pulang,true);
	
	if($rencana_pulang['1_a'] == '1'){
		$templateklinik->setValue('1a_y',$checked);
		$templateklinik->setValue('1a_t',$unChecked);
	}else if($rencana_pulang['1_a'] == '2'){
		$templateklinik->setValue('1a_y',$unChecked);
		$templateklinik->setValue('1a_t',$checked);
	}else{
		$templateklinik->setValue('1a_y',$unChecked);
		$templateklinik->setValue('1a_t',$unChecked);
	}		
	
	if($rencana_pulang['1_b'] == '1'){
		$templateklinik->setValue('1b_y',$checked);
		$templateklinik->setValue('1b_t',$unChecked);
	}else if($rencana_pulang['1_b'] == '2'){
		$templateklinik->setValue('1b_y',$unChecked);
		$templateklinik->setValue('1b_t',$checked);
	}else{
		$templateklinik->setValue('1b_y',$unChecked);
		$templateklinik->setValue('1b_t',$unChecked);
	}	
	
	if($rencana_pulang['1_c'] == '1'){
		$templateklinik->setValue('1c_y',$checked);
		$templateklinik->setValue('1c_t',$unChecked);
	}else if($rencana_pulang['1_c'] == '2'){
		$templateklinik->setValue('1c_y',$unChecked);
		$templateklinik->setValue('1c_t',$checked);
	}else{
		$templateklinik->setValue('1c_y',$unChecked);
		$templateklinik->setValue('1c_t',$unChecked);
	}	
	
	if($rencana_pulang['1_d'] == '1'){
		$templateklinik->setValue('1d_y',$checked);
		$templateklinik->setValue('1d_t',$unChecked);
	}else if($rencana_pulang['1_d'] == '2'){
		$templateklinik->setValue('1d_y',$unChecked);
		$templateklinik->setValue('1d_t',$checked);
	}else{
		$templateklinik->setValue('1d_y',$unChecked);
		$templateklinik->setValue('1d_t',$unChecked);
	}	
	
	if($rencana_pulang['2_a'] == '1'){
		$templateklinik->setValue('2a_y',$checked);
		$templateklinik->setValue('2a_t',$unChecked);
	}else if($rencana_pulang['2_a'] == '2'){
		$templateklinik->setValue('2a_y',$unChecked);
		$templateklinik->setValue('2a_t',$checked);
	}else{
		$templateklinik->setValue('2a_y',$unChecked);
		$templateklinik->setValue('2a_t',$unChecked);
	}	
	
	if($rencana_pulang['2_b'] == '1'){
		$templateklinik->setValue('2b_y',$checked);
		$templateklinik->setValue('2b_t',$unChecked);
	}else if($rencana_pulang['2_b'] == '2'){
		$templateklinik->setValue('2b_y',$unChecked);
		$templateklinik->setValue('2b_t',$checked);
	}else{
		$templateklinik->setValue('2b_y',$unChecked);
		$templateklinik->setValue('2b_t',$unChecked);
	}	
	
	if($rencana_pulang['2_c'] == '1'){
		$templateklinik->setValue('2c_y',$checked);
		$templateklinik->setValue('2c_t',$unChecked);
	}else if($rencana_pulang['2_c'] == '2'){
		$templateklinik->setValue('2c_y',$unChecked);
		$templateklinik->setValue('2c_t',$checked);
	}else{
		$templateklinik->setValue('2c_y',$unChecked);
		$templateklinik->setValue('2c_t',$unChecked);
	}	
	
	if($rencana_pulang['2_d1'] == '1'){
		$templateklinik->setValue('2d1_y',$checked);
		$templateklinik->setValue('2d1_t',$unChecked);
	}else if($rencana_pulang['2_d1'] == '2'){
		$templateklinik->setValue('2d1_y',$unChecked);
		$templateklinik->setValue('2d1_t',$checked);
	}else{
		$templateklinik->setValue('2d1_y',$unChecked);
		$templateklinik->setValue('2d1_t',$unChecked);
	}	
	
	if($rencana_pulang['2_d2'] == '1'){
		$templateklinik->setValue('2d2_y',$checked);
		$templateklinik->setValue('2d2_t',$unChecked);
	}else if($rencana_pulang['2_d2'] == '2'){
		$templateklinik->setValue('2d2_y',$unChecked);
		$templateklinik->setValue('2d2_t',$checked);
	}else{
		$templateklinik->setValue('2d2_y',$unChecked);
		$templateklinik->setValue('2d2_t',$unChecked);
	}	
	
	if($rencana_pulang['2_d3'] == '1'){
		$templateklinik->setValue('2d3_y',$checked);
		$templateklinik->setValue('2d3_t',$unChecked);
	}else if($rencana_pulang['2_d3'] == '2'){
		$templateklinik->setValue('2d3_y',$unChecked);
		$templateklinik->setValue('2d3_t',$checked);
	}else{
		$templateklinik->setValue('2d3_y',$unChecked);
		$templateklinik->setValue('2d3_t',$unChecked);
	}	
	
	if($rencana_pulang['2_d4'] == '1'){
		$templateklinik->setValue('2d4_y',$checked);
		$templateklinik->setValue('2d4_t',$unChecked);
	}else if($rencana_pulang['2_d4'] == '2'){
		$templateklinik->setValue('2d4_y',$unChecked);
		$templateklinik->setValue('2d4_t',$checked);
	}else{
		$templateklinik->setValue('2d4_y',$unChecked);
		$templateklinik->setValue('2d4_t',$unChecked);
	}	
	
	$templateklinik->setValue('2d4_ket', htmlspecialchars($rencana_pulang['2_d4_ket']));
	
	if($rencana_pulang['2_e'] == '1'){
		$templateklinik->setValue('2e_y',$checked);
		$templateklinik->setValue('2e_t',$unChecked);
	}else if($rencana_pulang['2_e'] == '2'){
		$templateklinik->setValue('2e_y',$unChecked);
		$templateklinik->setValue('2e_t',$checked);
	}else{
		$templateklinik->setValue('2e_y',$unChecked);
		$templateklinik->setValue('2e_t',$unChecked);
	}	
	
	if($rencana_pulang['3_a'] == '1'){
		$templateklinik->setValue('3a_y',$checked);
		$templateklinik->setValue('3a_t',$unChecked);
	}else if($rencana_pulang['3_a'] == '2'){
		$templateklinik->setValue('3a_y',$unChecked);
		$templateklinik->setValue('3a_t',$checked);
	}else{
		$templateklinik->setValue('3a_y',$unChecked);
		$templateklinik->setValue('3a_t',$unChecked);
	}	
	
	if($rencana_pulang['3_b'] == '1'){
		$templateklinik->setValue('3b_y',$checked);
		$templateklinik->setValue('3b_t',$unChecked);
	}else if($rencana_pulang['3_b'] == '2'){
		$templateklinik->setValue('3b_y',$unChecked);
		$templateklinik->setValue('3b_t',$checked);
	}else{
		$templateklinik->setValue('3b_y',$unChecked);
		$templateklinik->setValue('3b_t',$unChecked);
	}	
	
	if($rencana_pulang['3_c'] == '1'){
		$templateklinik->setValue('3c_y',$checked);
		$templateklinik->setValue('3c_t',$unChecked);
	}else if($rencana_pulang['3_c'] == '2'){
		$templateklinik->setValue('3c_y',$unChecked);
		$templateklinik->setValue('3c_t',$checked);
	}else{
		$templateklinik->setValue('3c_y',$unChecked);
		$templateklinik->setValue('3c_t',$unChecked);
	}	
	
	if($rencana_pulang['3_d'] == '1'){
		$templateklinik->setValue('3d_y',$checked);
		$templateklinik->setValue('3d_t',$unChecked);
	}else if($rencana_pulang['3_d'] == '2'){
		$templateklinik->setValue('3d_y',$unChecked);
		$templateklinik->setValue('3d_t',$checked);
	}else{
		$templateklinik->setValue('3d_y',$unChecked);
		$templateklinik->setValue('3d_t',$unChecked);
	}	
	
	if($rencana_pulang['3_e'] == '1'){
		$templateklinik->setValue('3e_y',$checked);
		$templateklinik->setValue('3e_t',$unChecked);
	}else if($rencana_pulang['3_e'] == '2'){
		$templateklinik->setValue('3e_y',$unChecked);
		$templateklinik->setValue('3e_t',$checked);
	}else{
		$templateklinik->setValue('3e_y',$unChecked);
		$templateklinik->setValue('3e_t',$unChecked);
	}	
	
	if($rencana_pulang['3_f'] == '1'){
		$templateklinik->setValue('3f_y',$checked);
		$templateklinik->setValue('3f_t',$unChecked);
	}else if($rencana_pulang['3_f'] == '2'){
		$templateklinik->setValue('3f_y',$unChecked);
		$templateklinik->setValue('3f_t',$checked);
	}else{
		$templateklinik->setValue('3f_y',$unChecked);
		$templateklinik->setValue('3f_t',$unChecked);
	}	
	
	if($rencana_pulang['3_g1'] == '1'){
		$templateklinik->setValue('3g1_y',$checked);
		$templateklinik->setValue('3g1_t',$unChecked);
	}else if($rencana_pulang['3_g1'] == '2'){
		$templateklinik->setValue('3g1_y',$unChecked);
		$templateklinik->setValue('3g1_t',$checked);
	}else{
		$templateklinik->setValue('3g1_y',$unChecked);
		$templateklinik->setValue('3g1_t',$unChecked);
	}	
	
	if($rencana_pulang['3_g2'] == '1'){
		$templateklinik->setValue('3g2_y',$checked);
		$templateklinik->setValue('3g2_t',$unChecked);
	}else if($rencana_pulang['3_g2'] == '2'){
		$templateklinik->setValue('3g2_y',$unChecked);
		$templateklinik->setValue('3g2_t',$checked);
	}else{
		$templateklinik->setValue('3g2_y',$unChecked);
		$templateklinik->setValue('3g2_t',$unChecked);
	}	
	
	if($rencana_pulang['3_g3'] == '1'){
		$templateklinik->setValue('3g3_y',$checked);
		$templateklinik->setValue('3g3_t',$unChecked);
	}else if($rencana_pulang['3_g3'] == '2'){
		$templateklinik->setValue('3g3_y',$unChecked);
		$templateklinik->setValue('3g3_t',$checked);
	}else{
		$templateklinik->setValue('3g3_y',$unChecked);
		$templateklinik->setValue('3g3_t',$unChecked);
	}	
	
	if($rencana_pulang['3_h1'] == '1'){
		$templateklinik->setValue('3h1_y',$checked);
		$templateklinik->setValue('3h1_t',$unChecked);
	}else if($rencana_pulang['3_h1'] == '2'){
		$templateklinik->setValue('3h1_y',$unChecked);
		$templateklinik->setValue('3h1_t',$checked);
	}else{
		$templateklinik->setValue('3h1_y',$unChecked);
		$templateklinik->setValue('3h1_t',$unChecked);
	}	
	
	if($rencana_pulang['3_h2'] == '1'){
		$templateklinik->setValue('3h2_y',$checked);
		$templateklinik->setValue('3h2_t',$unChecked);
	}else if($rencana_pulang['3_h2'] == '2'){
		$templateklinik->setValue('3h2_y',$unChecked);
		$templateklinik->setValue('3h2_t',$checked);
	}else{
		$templateklinik->setValue('3h2_y',$unChecked);
		$templateklinik->setValue('3h2_t',$unChecked);
	}	
	
	if($rencana_pulang['3_h3'] == '1'){
		$templateklinik->setValue('3h3_y',$checked);
		$templateklinik->setValue('3h3_t',$unChecked);
	}else if($rencana_pulang['3_h3'] == '2'){
		$templateklinik->setValue('3h3_y',$unChecked);
		$templateklinik->setValue('3h3_t',$checked);
	}else{
		$templateklinik->setValue('3h3_y',$unChecked);
		$templateklinik->setValue('3h3_t',$unChecked);
	}	
	
	if($rencana_pulang['3_h4'] == '1'){
		$templateklinik->setValue('3h4_y',$checked);
		$templateklinik->setValue('3h4_t',$unChecked);
	}else if($rencana_pulang['3_h4'] == '2'){
		$templateklinik->setValue('3h4_y',$unChecked);
		$templateklinik->setValue('3h4_t',$checked);
	}else{
		$templateklinik->setValue('3h4_y',$unChecked);
		$templateklinik->setValue('3h4_t',$unChecked);
	}		
	
	$templateklinik->setValue('3h4_ket', htmlspecialchars($rencana_pulang['3_h4_ket']));
	
	if($rencana_pulang['4_a'] == '1'){
		$templateklinik->setValue('4a_y',$checked);
		$templateklinik->setValue('4a_t',$unChecked);
	}else if($rencana_pulang['4_a'] == '2'){
		$templateklinik->setValue('4a_y',$unChecked);
		$templateklinik->setValue('4a_t',$checked);
	}else{
		$templateklinik->setValue('4a_y',$unChecked);
		$templateklinik->setValue('4a_t',$unChecked);
	}	
	
	if($rencana_pulang['4_b'] == '1'){
		$templateklinik->setValue('4b_y',$checked);
		$templateklinik->setValue('4b_t',$unChecked);
	}else if($rencana_pulang['4_b'] == '2'){
		$templateklinik->setValue('4b_y',$unChecked);
		$templateklinik->setValue('4b_t',$checked);
	}else{
		$templateklinik->setValue('4b_y',$unChecked);
		$templateklinik->setValue('4b_t',$unChecked);
	}	
	
	if($rencana_pulang['4_c'] == '1'){
		$templateklinik->setValue('4c_y',$checked);
		$templateklinik->setValue('4c_t',$unChecked);
	}else if($rencana_pulang['4_c'] == '2'){
		$templateklinik->setValue('4c_y',$unChecked);
		$templateklinik->setValue('4c_t',$checked);
	}else{
		$templateklinik->setValue('4c_y',$unChecked);
		$templateklinik->setValue('4c_t',$unChecked);
	}	
	
	if($rencana_pulang['4_d'] == '1'){
		$templateklinik->setValue('4d_y',$checked);
		$templateklinik->setValue('4d_t',$unChecked);
	}else if($rencana_pulang['4_d'] == '2'){
		$templateklinik->setValue('4d_y',$unChecked);
		$templateklinik->setValue('4d_t',$checked);
	}else{
		$templateklinik->setValue('4d_y',$unChecked);
		$templateklinik->setValue('4d_t',$unChecked);
	}	
	
	if($rencana_pulang['4_e'] == '1'){
		$templateklinik->setValue('4e_y',$checked);
		$templateklinik->setValue('4e_t',$unChecked);
	}else if($rencana_pulang['4_e'] == '2'){
		$templateklinik->setValue('4e_y',$unChecked);
		$templateklinik->setValue('4e_t',$checked);
	}else{
		$templateklinik->setValue('4e_y',$unChecked);
		$templateklinik->setValue('4e_t',$unChecked);
	}	
	
	if($rencana_pulang['4_f'] == '1'){
		$templateklinik->setValue('4f_y',$checked);
		$templateklinik->setValue('4f_t',$unChecked);
	}else if($rencana_pulang['4_f'] == '2'){
		$templateklinik->setValue('4f_y',$unChecked);
		$templateklinik->setValue('4f_t',$checked);
	}else{
		$templateklinik->setValue('4f_y',$unChecked);
		$templateklinik->setValue('4f_t',$unChecked);
	}	
	
	$templateklinik->setValue('4f_ket', htmlspecialchars($rencana_pulang['4_f_ket']));
	
	if($rencana_pulang['5_a'] == '1'){
		$templateklinik->setValue('5a_y',$checked);
		$templateklinik->setValue('5a_t',$unChecked);
	}else if($rencana_pulang['5_a'] == '2'){
		$templateklinik->setValue('5a_y',$unChecked);
		$templateklinik->setValue('5a_t',$checked);
	}else{
		$templateklinik->setValue('5a_y',$unChecked);
		$templateklinik->setValue('5a_t',$unChecked);
	}	
	
	if($rencana_pulang['5_b'] == '1'){
		$templateklinik->setValue('5b_y',$checked);
		$templateklinik->setValue('5b_t',$unChecked);
	}else if($rencana_pulang['5_b'] == '2'){
		$templateklinik->setValue('5b_y',$unChecked);
		$templateklinik->setValue('5b_t',$checked);
	}else{
		$templateklinik->setValue('5b_y',$unChecked);
		$templateklinik->setValue('5b_t',$unChecked);
	}	
	
	if($rencana_pulang['5_c'] == '1'){
		$templateklinik->setValue('5c_y',$checked);
		$templateklinik->setValue('5c_t',$unChecked);
	}else if($rencana_pulang['5_c'] == '2'){
		$templateklinik->setValue('5c_y',$unChecked);
		$templateklinik->setValue('5c_t',$checked);
	}else{
		$templateklinik->setValue('5c_y',$unChecked);
		$templateklinik->setValue('5c_t',$unChecked);
	}	
	
	if($rencana_pulang['5_d'] == '1'){
		$templateklinik->setValue('5d_y',$checked);
		$templateklinik->setValue('5d_t',$unChecked);
	}else if($rencana_pulang['5_d'] == '2'){
		$templateklinik->setValue('5d_y',$unChecked);
		$templateklinik->setValue('5d_t',$checked);
	}else{
		$templateklinik->setValue('5d_y',$unChecked);
		$templateklinik->setValue('5d_t',$unChecked);
	}	
	
	if($rencana_pulang['5_e'] == '1'){
		$templateklinik->setValue('5e_y',$checked);
		$templateklinik->setValue('5e_t',$unChecked);
	}else if($rencana_pulang['5_e'] == '2'){
		$templateklinik->setValue('5e_y',$unChecked);
		$templateklinik->setValue('5e_t',$checked);
	}else{
		$templateklinik->setValue('5e_y',$unChecked);
		$templateklinik->setValue('5e_t',$unChecked);
	}	
	
	if($rencana_pulang['5_f'] == '1'){
		$templateklinik->setValue('5f_y',$checked);
		$templateklinik->setValue('5f_t',$unChecked);
	}else if($rencana_pulang['5_f'] == '2'){
		$templateklinik->setValue('5f_y',$unChecked);
		$templateklinik->setValue('5f_t',$checked);
	}else{
		$templateklinik->setValue('5f_y',$unChecked);
		$templateklinik->setValue('5f_t',$unChecked);
	}	
	
	if($rencana_pulang['5_g'] == '1'){
		$templateklinik->setValue('5g_y',$checked);
		$templateklinik->setValue('5g_t',$unChecked);
	}else if($rencana_pulang['5_g'] == '2'){
		$templateklinik->setValue('5g_y',$unChecked);
		$templateklinik->setValue('5g_t',$checked);
	}else{
		$templateklinik->setValue('5g_y',$unChecked);
		$templateklinik->setValue('5g_t',$unChecked);
	}	
	
	$templateklinik->setValue('5g_ket', htmlspecialchars($rencana_pulang['5_g_ket']));
	
	if($rencana_pulang['6_a'] == '1'){
		$templateklinik->setValue('6a_y',$checked);
		$templateklinik->setValue('6a_t',$unChecked);
	}else if($rencana_pulang['6_a'] == '2'){
		$templateklinik->setValue('6a_y',$unChecked);
		$templateklinik->setValue('6a_t',$checked);
	}else{
		$templateklinik->setValue('6a_y',$unChecked);
		$templateklinik->setValue('6a_t',$unChecked);
	}	
	
	if($rencana_pulang['6_b'] == '1'){
		$templateklinik->setValue('6b_y',$checked);
		$templateklinik->setValue('6b_t',$unChecked);
	}else if($rencana_pulang['6_b'] == '2'){
		$templateklinik->setValue('6b_y',$unChecked);
		$templateklinik->setValue('6b_t',$checked);
	}else{
		$templateklinik->setValue('6b_y',$unChecked);
		$templateklinik->setValue('6b_t',$unChecked);
	}	
	
	if($rencana_pulang['6_c'] == '1'){
		$templateklinik->setValue('6c_y',$checked);
		$templateklinik->setValue('6c_t',$unChecked);
	}else if($rencana_pulang['6_c'] == '2'){
		$templateklinik->setValue('6c_y',$unChecked);
		$templateklinik->setValue('6c_t',$checked);
	}else{
		$templateklinik->setValue('6c_y',$unChecked);
		$templateklinik->setValue('6c_t',$unChecked);
	}	
	
	if($rencana_pulang['7_a'] == '1'){
		$templateklinik->setValue('7a_y',$checked);
		$templateklinik->setValue('7a_t',$unChecked);
	}else if($rencana_pulang['7_a'] == '2'){
		$templateklinik->setValue('7a_y',$unChecked);
		$templateklinik->setValue('7a_t',$checked);
	}else{
		$templateklinik->setValue('7a_y',$unChecked);
		$templateklinik->setValue('7a_t',$unChecked);
	}	
	
	if($rencana_pulang['7_b'] == '1'){
		$templateklinik->setValue('7b_y',$checked);
		$templateklinik->setValue('7b_t',$unChecked);
	}else if($rencana_pulang['7_b'] == '2'){
		$templateklinik->setValue('7b_y',$unChecked);
		$templateklinik->setValue('7b_t',$checked);
	}else{
		$templateklinik->setValue('7b_y',$unChecked);
		$templateklinik->setValue('7b_t',$unChecked);
	}	
	
	if($rencana_pulang['7_c'] == '1'){
		$templateklinik->setValue('7c_y',$checked);
		$templateklinik->setValue('7c_t',$unChecked);
	}else if($rencana_pulang['7_c'] == '2'){
		$templateklinik->setValue('7c_y',$unChecked);
		$templateklinik->setValue('7c_t',$checked);
	}else{
		$templateklinik->setValue('7c_y',$unChecked);
		$templateklinik->setValue('7c_t',$unChecked);
	}	
	
	if($rencana_pulang['8_a'] == '1'){
		$templateklinik->setValue('8a_y',$checked);
		$templateklinik->setValue('8a_t',$unChecked);
	}else if($rencana_pulang['8_a'] == '2'){
		$templateklinik->setValue('8a_y',$unChecked);
		$templateklinik->setValue('8a_t',$checked);
	}else{
		$templateklinik->setValue('8a_y',$unChecked);
		$templateklinik->setValue('8a_t',$unChecked);
	}	
	
	if($rencana_pulang['8_b'] == '1'){
		$templateklinik->setValue('8b_y',$checked);
		$templateklinik->setValue('8b_t',$unChecked);
	}else if($rencana_pulang['8_b'] == '2'){
		$templateklinik->setValue('8b_y',$unChecked);
		$templateklinik->setValue('8b_t',$checked);
	}else{
		$templateklinik->setValue('8b_y',$unChecked);
		$templateklinik->setValue('8b_t',$unChecked);
	}	
	
	if($rencana_pulang['8_c'] == '1'){
		$templateklinik->setValue('8c_y',$checked);
		$templateklinik->setValue('8c_t',$unChecked);
	}else if($rencana_pulang['8_c'] == '2'){
		$templateklinik->setValue('8c_y',$unChecked);
		$templateklinik->setValue('8c_t',$checked);
	}else{
		$templateklinik->setValue('8c_y',$unChecked);
		$templateklinik->setValue('8c_t',$unChecked);
	}	
	
	$templateklinik->setValue('8c_ket', htmlspecialchars($rencana_pulang['8_c_ket']));
	
	$tindak_lanjut = replace_newline($rencana_pulang['tl']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($tindak_lanjut);
	$templateklinik->setValue('tl', $toOpenXML);
	
	if(!file_exists($rmfile_path . '/pdf/' . $jns_perawatan . '/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/pdf/' . $jns_perawatan . '/' . $nomr . '/' . $idx, 0700, true);
	}

	if(!file_exists($rmfile_path . '/doc/' . $jns_perawatan . '/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/doc/' . $jns_perawatan . '/' . $nomr . '/' . $idx, 0700, true);
	}
	
	$nama_file = $nomr . '_' . $idx . '_11';	
	$templateklinik->saveAs($rmfile_path . '/doc/' . $jns_perawatan . '/' . $nomr . '/' . $idx . '/' . $nama_file . '.docx');
	
	mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE RAWAT_ID = "' . $idx . '"
				AND JNS_PERAWATAN = "' . $jns_perawatan . '"
				AND JENIS_DOKUMEN_ID = "11"
				AND NAMA_FILE = "' . $nama_file . '.pdf"') or die(mysql_error());
	mysql_query('INSERT INTO t_rm_dokumen_file(JENIS_DOKUMEN_ID,NOMR,RAWAT_ID,JNS_PERAWATAN,NAMA_FILE,ST_SISTEM,TANGGAL) 		
				VALUES("11","' . $nomr . '","' . $idx . '","' . $jns_perawatan . '","' . $nama_file . '.pdf","1",STR_TO_DATE("' . $tgl_daftar . '","%d/%m/%Y"))') or die(mysql_error());
	
	$source_file = $rmfile_path . '/doc/' . $jns_perawatan . '/' . $nomr . '/' . $idx . '/' . $nama_file . '.docx';			
	$source_file = str_replace('/','\\',$source_file);
	$target_file = $rmfile_path . '/pdf/' . $jns_perawatan . '/' . $nomr . '/' . $idx . '/' . $nama_file . '.pdf';
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