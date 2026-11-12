<?php
function erm_pemeriksaan_saraf_otot($idx){
	global $rmfile_path, $app_path;

	$checked = '<w:sym w:font="Wingdings" w:char="F0FE"/>';
    $unChecked = '<w:sym w:font="Wingdings" w:char="F0A8"/>';
	
	$templateklinik = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\pemeriksaan_saraf_dan_otot.docx');
	
	$qry_pasien = 'SELECT t_irja.IRJA_ID,t_irja.NOMR,t_irja.PEGAWAI_ID,m_pegawai.NAMA_PEGAWAI,
				t_irja.ASAL_PASIEN_ID,t_irja.KET_ASAL_PASIEN,t_irja.UNIT_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				DATE_FORMAT(t_irja.PASIEN_MASUK,"%d-%m-%Y %H:%i") AS PASIEN_MASUK,t_irja.JENIS_BAYAR_ID,m_pasien.NO_TELEPON,
				DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_unit.NAMA_UNIT
				FROM t_irja
				INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_irja.IRJA_ID = "' . $idx . '"';
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
	$pegawai_id = $dat_pasien['PEGAWAI_ID'];
	$asal_pasien_id = $dat_pasien['ASAL_PASIEN_ID'];
	$ket_asal_pasien = $dat_pasien['KET_ASAL_PASIEN'];
	$pasien_masuk = $dat_pasien['PASIEN_MASUK'];

	$no_telepon = $dat_pasien['NO_TELEPON'];
	$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];
	$nama_unit = $dat_pasien['NAMA_UNIT'];
	$nama_dokter = $dat_pasien['NAMA_PEGAWAI'];

	$umur = getUmurDaftar($tgl_lahir,$tgl_daftar);
	
	$qry_pengkajian = 'SELECT IRJA_ID,TANGGAL,PENILAI,PEMERIKSAAN_SARAF_KAKI,PEMERIKSAAN_OTOT_KAKI,TEST_RASA_KAKI,
			KELEMAHAN_OTOT_KAKI,PEMERIKSAAN_SARAF_MUKA,PEMERIKSAAN_OTOT_MUKA,PEMERIKSAAN_SARAF_TANGAN,
			PEMERIKSAAN_OTOT_TANGAN,TEST_RASA_TANGAN,SAKIT_SARAF_TANGAN,KELEMAHAN_OTOT_TANGAN,
			DATE_FORMAT(TGL_ASSESMENT,"%d-%m-%Y %H:%i") AS TGL_ASSESMENT
			FROM t_pemeriksaan_saraf_dan_otot
			WHERE IRJA_ID = "' . $idx . '"';
	$get_pengkajian = mysql_query($qry_pengkajian) or die(mysql_error());
	$dat_pengkajian = mysql_fetch_assoc($get_pengkajian);
	$idx = $dat_pengkajian['IRJA_ID'];
	$tanggal = str_replace('|','"',$dat_pengkajian['TANGGAL']);
	$tanggal = preg_replace('/\r|\n/','\n',trim($tanggal));
	$tanggal = json_decode($tanggal,true);
	
	$penilai = str_replace('|','"',$dat_pengkajian['PENILAI']);
	$penilai = preg_replace('/\r|\n/','\n',trim($penilai));
	$penilai = json_decode($penilai,true);
	
	$pem_saraf_kaki = str_replace('|','"',$dat_pengkajian['PEMERIKSAAN_SARAF_KAKI']);
	$pem_saraf_kaki = preg_replace('/\r|\n/','\n',trim($pem_saraf_kaki));
	$pem_saraf_kaki = json_decode($pem_saraf_kaki,true);
	
	$pem_otot_kaki = str_replace('|','"',$dat_pengkajian['PEMERIKSAAN_OTOT_KAKI']);
	$pem_otot_kaki = preg_replace('/\r|\n/','\n',trim($pem_otot_kaki));
	$pem_otot_kaki = json_decode($pem_otot_kaki,true);
	
	$test_rasa_kaki = $dat_pengkajian['TEST_RASA_KAKI'];
	$kelemahan_otot_kaki = $dat_pengkajian['KELEMAHAN_OTOT_KAKI'];
	
	$pem_saraf_muka = str_replace('|','"',$dat_pengkajian['PEMERIKSAAN_SARAF_MUKA']);
	$pem_saraf_muka = preg_replace('/\r|\n/','\n',trim($pem_saraf_muka));
	$pem_saraf_muka = json_decode($pem_saraf_muka,true);
	
	$pem_otot_muka = str_replace('|','"',$dat_pengkajian['PEMERIKSAAN_OTOT_MUKA']);
	$pem_otot_muka = preg_replace('/\r|\n/','\n',trim($pem_otot_muka));
	$pem_otot_muka = json_decode($pem_otot_muka,true);
	
	$pem_saraf_tangan = str_replace('|','"',$dat_pengkajian['PEMERIKSAAN_SARAF_TANGAN']);
	$pem_saraf_tangan = preg_replace('/\r|\n/','\n',trim($pem_saraf_tangan));
	$pem_saraf_tangan = json_decode($pem_saraf_tangan,true);
	
	$pem_otot_tangan = str_replace('|','"',$dat_pengkajian['PEMERIKSAAN_OTOT_TANGAN']);
	$pem_otot_tangan = preg_replace('/\r|\n/','\n',trim($pem_otot_tangan));
	$pem_otot_tangan = json_decode($pem_otot_tangan,true);
	
	$test_rasa_tangan = $dat_pengkajian['TEST_RASA_TANGAN'];
	$rasa_sakit_pada_saraf = $dat_pengkajian['SAKIT_SARAF_TANGAN'];
	$kelemahan_otot = $dat_pengkajian['KELEMAHAN_OTOT_TANGAN'];
	$tgl_assesment = $dat_pengkajian['TGL_ASSESMENT'];
	
	$templateklinik->setValue('nomor_rm', formatNomr($nomr));
	$templateklinik->setValue('nama_pasien', htmlspecialchars($nama_pasien));
	$templateklinik->setValue('tgl_lahir', htmlspecialchars($tgl_lahir));
	$templateklinik->setValue('jenis_kelamin', htmlspecialchars($jns_kelamin));
	$templateklinik->setValue('unit', htmlspecialchars($nama_unit));
	$templateklinik->setValue('tgl_masuk', $pasien_masuk);
	$templateklinik->setValue('tgl_assesment', $tgl_assesment);
	$templateklinik->setValue('nama_dokter', htmlspecialchars($nama_dokter));
	$templateklinik->setValue('dicetak_oleh', '');
	
	$templateklinik->setValue('tgl_1', htmlspecialchars($tanggal['01']));
	$templateklinik->setValue('tgl_2', htmlspecialchars($tanggal['02']));
	$templateklinik->setValue('tgl_3', htmlspecialchars($tanggal['03']));
	$templateklinik->setValue('tgl_4', htmlspecialchars($tanggal['04']));
	$templateklinik->setValue('tgl_5', htmlspecialchars($tanggal['05']));
	$templateklinik->setValue('tgl_6', htmlspecialchars($tanggal['06']));
	$templateklinik->setValue('tgl_7', htmlspecialchars($tanggal['07']));
	$templateklinik->setValue('tgl_8', htmlspecialchars($tanggal['08']));
	$templateklinik->setValue('tgl_9', htmlspecialchars($tanggal['09']));
	$templateklinik->setValue('tgl_10', htmlspecialchars($tanggal['10']));
	$templateklinik->setValue('tgl_11', htmlspecialchars($tanggal['11']));
	$templateklinik->setValue('tgl_12', htmlspecialchars($tanggal['12']));
	
	$templateklinik->setValue('pnl_1', htmlspecialchars($penilai['01']));
	$templateklinik->setValue('pnl_2', htmlspecialchars($penilai['02']));
	$templateklinik->setValue('pnl_3', htmlspecialchars($penilai['03']));
	$templateklinik->setValue('pnl_4', htmlspecialchars($penilai['04']));
	$templateklinik->setValue('pnl_5', htmlspecialchars($penilai['05']));
	$templateklinik->setValue('pnl_6', htmlspecialchars($penilai['06']));
	$templateklinik->setValue('pnl_7', htmlspecialchars($penilai['07']));
	$templateklinik->setValue('pnl_8', htmlspecialchars($penilai['08']));
	$templateklinik->setValue('pnl_9', htmlspecialchars($penilai['09']));
	$templateklinik->setValue('pnl_10', htmlspecialchars($penilai['10']));
	$templateklinik->setValue('pnl_11', htmlspecialchars($penilai['11']));
	$templateklinik->setValue('pnl_12', htmlspecialchars($penilai['12']));
	
	$templateklinik->setValue('cmn_1', htmlspecialchars($pem_saraf_kaki['common_01']));
	$templateklinik->setValue('cmn_2', htmlspecialchars($pem_saraf_kaki['common_02']));
	$templateklinik->setValue('cmn_3', htmlspecialchars($pem_saraf_kaki['common_03']));
	$templateklinik->setValue('cmn_4', htmlspecialchars($pem_saraf_kaki['common_04']));
	$templateklinik->setValue('cmn_5', htmlspecialchars($pem_saraf_kaki['common_05']));
	$templateklinik->setValue('cmn_6', htmlspecialchars($pem_saraf_kaki['common_06']));
	$templateklinik->setValue('cmn_7', htmlspecialchars($pem_saraf_kaki['common_07']));
	$templateklinik->setValue('cmn_8', htmlspecialchars($pem_saraf_kaki['common_08']));
	$templateklinik->setValue('cmn_9', htmlspecialchars($pem_saraf_kaki['common_09']));
	$templateklinik->setValue('cmn_10', htmlspecialchars($pem_saraf_kaki['common_10']));
	$templateklinik->setValue('cmn_11', htmlspecialchars($pem_saraf_kaki['common_11']));
	$templateklinik->setValue('cmn_12', htmlspecialchars($pem_saraf_kaki['common_12']));
	
	$templateklinik->setValue('tbl_1', htmlspecialchars($pem_saraf_kaki['posterior_01']));
	$templateklinik->setValue('tbl_2', htmlspecialchars($pem_saraf_kaki['posterior_02']));
	$templateklinik->setValue('tbl_3', htmlspecialchars($pem_saraf_kaki['posterior_03']));
	$templateklinik->setValue('tbl_4', htmlspecialchars($pem_saraf_kaki['posterior_04']));
	$templateklinik->setValue('tbl_5', htmlspecialchars($pem_saraf_kaki['posterior_05']));
	$templateklinik->setValue('tbl_6', htmlspecialchars($pem_saraf_kaki['posterior_06']));
	$templateklinik->setValue('tbl_7', htmlspecialchars($pem_saraf_kaki['posterior_07']));
	$templateklinik->setValue('tbl_8', htmlspecialchars($pem_saraf_kaki['posterior_08']));
	$templateklinik->setValue('tbl_9', htmlspecialchars($pem_saraf_kaki['posterior_09']));
	$templateklinik->setValue('tbl_10', htmlspecialchars($pem_saraf_kaki['posterior_10']));
	$templateklinik->setValue('tbl_11', htmlspecialchars($pem_saraf_kaki['posterior_11']));
	$templateklinik->setValue('tbl_12', htmlspecialchars($pem_saraf_kaki['posterior_12']));
	
	$templateklinik->setValue('ant_1', htmlspecialchars($pem_otot_kaki['anterior_01']));
	$templateklinik->setValue('ant_2', htmlspecialchars($pem_otot_kaki['anterior_02']));
	$templateklinik->setValue('ant_3', htmlspecialchars($pem_otot_kaki['anterior_03']));
	$templateklinik->setValue('ant_4', htmlspecialchars($pem_otot_kaki['anterior_04']));
	$templateklinik->setValue('ant_5', htmlspecialchars($pem_otot_kaki['anterior_05']));
	$templateklinik->setValue('ant_6', htmlspecialchars($pem_otot_kaki['anterior_06']));
	$templateklinik->setValue('ant_7', htmlspecialchars($pem_otot_kaki['anterior_07']));
	$templateklinik->setValue('ant_8', htmlspecialchars($pem_otot_kaki['anterior_08']));
	$templateklinik->setValue('ant_9', htmlspecialchars($pem_otot_kaki['anterior_09']));
	$templateklinik->setValue('ant_10', htmlspecialchars($pem_otot_kaki['anterior_10']));
	$templateklinik->setValue('ant_11', htmlspecialchars($pem_otot_kaki['anterior_11']));
	$templateklinik->setValue('ant_12', htmlspecialchars($pem_otot_kaki['anterior_12']));
	
	$templateklinik->setValue('prn_1', htmlspecialchars($pem_otot_kaki['brevis_01']));
	$templateklinik->setValue('prn_2', htmlspecialchars($pem_otot_kaki['brevis_02']));
	$templateklinik->setValue('prn_3', htmlspecialchars($pem_otot_kaki['brevis_03']));
	$templateklinik->setValue('prn_4', htmlspecialchars($pem_otot_kaki['brevis_04']));
	$templateklinik->setValue('prn_5', htmlspecialchars($pem_otot_kaki['brevis_05']));
	$templateklinik->setValue('prn_6', htmlspecialchars($pem_otot_kaki['brevis_06']));
	$templateklinik->setValue('prn_7', htmlspecialchars($pem_otot_kaki['brevis_07']));
	$templateklinik->setValue('prn_8', htmlspecialchars($pem_otot_kaki['brevis_08']));
	$templateklinik->setValue('prn_9', htmlspecialchars($pem_otot_kaki['brevis_09']));
	$templateklinik->setValue('prn_10', htmlspecialchars($pem_otot_kaki['brevis_10']));
	$templateklinik->setValue('prn_11', htmlspecialchars($pem_otot_kaki['brevis_11']));
	$templateklinik->setValue('prn_12', htmlspecialchars($pem_otot_kaki['brevis_12']));
	
	$templateklinik->setValue('ext_1', htmlspecialchars($pem_otot_kaki['hallucis_01']));
	$templateklinik->setValue('ext_2', htmlspecialchars($pem_otot_kaki['hallucis_02']));
	$templateklinik->setValue('ext_3', htmlspecialchars($pem_otot_kaki['hallucis_03']));
	$templateklinik->setValue('ext_4', htmlspecialchars($pem_otot_kaki['hallucis_04']));
	$templateklinik->setValue('ext_5', htmlspecialchars($pem_otot_kaki['hallucis_05']));
	$templateklinik->setValue('ext_6', htmlspecialchars($pem_otot_kaki['hallucis_06']));
	$templateklinik->setValue('ext_7', htmlspecialchars($pem_otot_kaki['hallucis_07']));
	$templateklinik->setValue('ext_8', htmlspecialchars($pem_otot_kaki['hallucis_08']));
	$templateklinik->setValue('ext_9', htmlspecialchars($pem_otot_kaki['hallucis_09']));
	$templateklinik->setValue('ext_10', htmlspecialchars($pem_otot_kaki['hallucis_10']));
	$templateklinik->setValue('ext_11', htmlspecialchars($pem_otot_kaki['hallucis_11']));
	$templateklinik->setValue('ext_12', htmlspecialchars($pem_otot_kaki['hallucis_12']));
	
	$templateklinik->setValue('pst_1', htmlspecialchars($pem_otot_kaki['tibialis_01']));
	$templateklinik->setValue('pst_2', htmlspecialchars($pem_otot_kaki['tibialis_02']));
	$templateklinik->setValue('pst_3', htmlspecialchars($pem_otot_kaki['tibialis_03']));
	$templateklinik->setValue('pst_4', htmlspecialchars($pem_otot_kaki['tibialis_04']));
	$templateklinik->setValue('pst_5', htmlspecialchars($pem_otot_kaki['tibialis_05']));
	$templateklinik->setValue('pst_6', htmlspecialchars($pem_otot_kaki['tibialis_06']));
	$templateklinik->setValue('pst_7', htmlspecialchars($pem_otot_kaki['tibialis_07']));
	$templateklinik->setValue('pst_8', htmlspecialchars($pem_otot_kaki['tibialis_08']));
	$templateklinik->setValue('pst_9', htmlspecialchars($pem_otot_kaki['tibialis_09']));
	$templateklinik->setValue('pst_10', htmlspecialchars($pem_otot_kaki['tibialis_10']));
	$templateklinik->setValue('pst_11', htmlspecialchars($pem_otot_kaki['tibialis_11']));
	$templateklinik->setValue('pst_12', htmlspecialchars($pem_otot_kaki['tibialis_12']));
	
	$templateklinik->setValue('grt_1', htmlspecialchars($pem_saraf_muka['aurikularis_01']));
	$templateklinik->setValue('grt_2', htmlspecialchars($pem_saraf_muka['aurikularis_02']));
	$templateklinik->setValue('grt_3', htmlspecialchars($pem_saraf_muka['aurikularis_03']));
	$templateklinik->setValue('grt_4', htmlspecialchars($pem_saraf_muka['aurikularis_04']));
	$templateklinik->setValue('grt_5', htmlspecialchars($pem_saraf_muka['aurikularis_05']));
	$templateklinik->setValue('grt_6', htmlspecialchars($pem_saraf_muka['aurikularis_06']));
	$templateklinik->setValue('grt_7', htmlspecialchars($pem_saraf_muka['aurikularis_07']));
	$templateklinik->setValue('grt_8', htmlspecialchars($pem_saraf_muka['aurikularis_08']));
	$templateklinik->setValue('grt_9', htmlspecialchars($pem_saraf_muka['aurikularis_09']));
	$templateklinik->setValue('grt_10', htmlspecialchars($pem_saraf_muka['aurikularis_10']));
	$templateklinik->setValue('grt_11', htmlspecialchars($pem_saraf_muka['aurikularis_11']));
	$templateklinik->setValue('grt_12', htmlspecialchars($pem_saraf_muka['aurikularis_12']));
	
	$templateklinik->setValue('orb_1', htmlspecialchars($pem_otot_muka['orbcularis_01']));
	$templateklinik->setValue('orb_2', htmlspecialchars($pem_otot_muka['orbcularis_02']));
	$templateklinik->setValue('orb_3', htmlspecialchars($pem_otot_muka['orbcularis_03']));
	$templateklinik->setValue('orb_4', htmlspecialchars($pem_otot_muka['orbcularis_04']));
	$templateklinik->setValue('orb_5', htmlspecialchars($pem_otot_muka['orbcularis_05']));
	$templateklinik->setValue('orb_6', htmlspecialchars($pem_otot_muka['orbcularis_06']));
	$templateklinik->setValue('orb_7', htmlspecialchars($pem_otot_muka['orbcularis_07']));
	$templateklinik->setValue('orb_8', htmlspecialchars($pem_otot_muka['orbcularis_08']));
	$templateklinik->setValue('orb_9', htmlspecialchars($pem_otot_muka['orbcularis_09']));
	$templateklinik->setValue('orb_10', htmlspecialchars($pem_otot_muka['orbcularis_10']));
	$templateklinik->setValue('orb_11', htmlspecialchars($pem_otot_muka['orbcularis_11']));
	$templateklinik->setValue('orb_12', htmlspecialchars($pem_otot_muka['orbcularis_12']));
	
	$templateklinik->setValue('ors_1', htmlspecialchars($pem_otot_muka['oris_01']));
	$templateklinik->setValue('ors_2', htmlspecialchars($pem_otot_muka['oris_02']));
	$templateklinik->setValue('ors_3', htmlspecialchars($pem_otot_muka['oris_03']));
	$templateklinik->setValue('ors_4', htmlspecialchars($pem_otot_muka['oris_04']));
	$templateklinik->setValue('ors_5', htmlspecialchars($pem_otot_muka['oris_05']));
	$templateklinik->setValue('ors_6', htmlspecialchars($pem_otot_muka['oris_06']));
	$templateklinik->setValue('ors_7', htmlspecialchars($pem_otot_muka['oris_07']));
	$templateklinik->setValue('ors_8', htmlspecialchars($pem_otot_muka['oris_08']));
	$templateklinik->setValue('ors_9', htmlspecialchars($pem_otot_muka['oris_09']));
	$templateklinik->setValue('ors_10', htmlspecialchars($pem_otot_muka['oris_10']));
	$templateklinik->setValue('ors_11', htmlspecialchars($pem_otot_muka['oris_11']));
	$templateklinik->setValue('ors_12', htmlspecialchars($pem_otot_muka['oris_12']));
	
	$templateklinik->setValue('lgp_1', htmlspecialchars($pem_otot_muka['lagophthalmus_01']));
	$templateklinik->setValue('lgp_2', htmlspecialchars($pem_otot_muka['lagophthalmus_02']));
	$templateklinik->setValue('lgp_3', htmlspecialchars($pem_otot_muka['lagophthalmus_03']));
	$templateklinik->setValue('lgp_4', htmlspecialchars($pem_otot_muka['lagophthalmus_04']));
	$templateklinik->setValue('lgp_5', htmlspecialchars($pem_otot_muka['lagophthalmus_05']));
	$templateklinik->setValue('lgp_6', htmlspecialchars($pem_otot_muka['lagophthalmus_06']));
	$templateklinik->setValue('lgp_7', htmlspecialchars($pem_otot_muka['lagophthalmus_07']));
	$templateklinik->setValue('lgp_8', htmlspecialchars($pem_otot_muka['lagophthalmus_08']));
	$templateklinik->setValue('lgp_9', htmlspecialchars($pem_otot_muka['lagophthalmus_09']));
	$templateklinik->setValue('lgp_10', htmlspecialchars($pem_otot_muka['lagophthalmus_10']));
	$templateklinik->setValue('lgp_11', htmlspecialchars($pem_otot_muka['lagophthalmus_11']));
	$templateklinik->setValue('lgp_12', htmlspecialchars($pem_otot_muka['lagophthalmus_12']));
	
	$templateklinik->setValue('kdm_1', htmlspecialchars($pem_otot_muka['kedip_mata_01']));
	$templateklinik->setValue('kdm_2', htmlspecialchars($pem_otot_muka['kedip_mata_02']));
	$templateklinik->setValue('kdm_3', htmlspecialchars($pem_otot_muka['kedip_mata_03']));
	$templateklinik->setValue('kdm_4', htmlspecialchars($pem_otot_muka['kedip_mata_04']));
	$templateklinik->setValue('kdm_5', htmlspecialchars($pem_otot_muka['kedip_mata_05']));
	$templateklinik->setValue('kdm_6', htmlspecialchars($pem_otot_muka['kedip_mata_06']));
	$templateklinik->setValue('kdm_7', htmlspecialchars($pem_otot_muka['kedip_mata_07']));
	$templateklinik->setValue('kdm_8', htmlspecialchars($pem_otot_muka['kedip_mata_08']));
	$templateklinik->setValue('kdm_9', htmlspecialchars($pem_otot_muka['kedip_mata_09']));
	$templateklinik->setValue('kdm_10', htmlspecialchars($pem_otot_muka['kedip_mata_10']));
	$templateklinik->setValue('kdm_11', htmlspecialchars($pem_otot_muka['kedip_mata_11']));
	$templateklinik->setValue('kdm_12', htmlspecialchars($pem_otot_muka['kedip_mata_12']));
	
	$templateklinik->setValue('uln_1', htmlspecialchars($pem_saraf_tangan['ulnaris_01']));
	$templateklinik->setValue('uln_2', htmlspecialchars($pem_saraf_tangan['ulnaris_02']));
	$templateklinik->setValue('uln_3', htmlspecialchars($pem_saraf_tangan['ulnaris_03']));
	$templateklinik->setValue('uln_4', htmlspecialchars($pem_saraf_tangan['ulnaris_04']));
	$templateklinik->setValue('uln_5', htmlspecialchars($pem_saraf_tangan['ulnaris_05']));
	$templateklinik->setValue('uln_6', htmlspecialchars($pem_saraf_tangan['ulnaris_06']));
	$templateklinik->setValue('uln_7', htmlspecialchars($pem_saraf_tangan['ulnaris_07']));
	$templateklinik->setValue('uln_8', htmlspecialchars($pem_saraf_tangan['ulnaris_08']));
	$templateklinik->setValue('uln_9', htmlspecialchars($pem_saraf_tangan['ulnaris_09']));
	$templateklinik->setValue('uln_10', htmlspecialchars($pem_saraf_tangan['ulnaris_10']));
	$templateklinik->setValue('uln_11', htmlspecialchars($pem_saraf_tangan['ulnaris_11']));
	$templateklinik->setValue('uln_12', htmlspecialchars($pem_saraf_tangan['ulnaris_12']));
	
	$templateklinik->setValue('mdn_1', htmlspecialchars($pem_saraf_tangan['medianus_01']));
	$templateklinik->setValue('mdn_2', htmlspecialchars($pem_saraf_tangan['medianus_02']));
	$templateklinik->setValue('mdn_3', htmlspecialchars($pem_saraf_tangan['medianus_03']));
	$templateklinik->setValue('mdn_4', htmlspecialchars($pem_saraf_tangan['medianus_04']));
	$templateklinik->setValue('mdn_5', htmlspecialchars($pem_saraf_tangan['medianus_05']));
	$templateklinik->setValue('mdn_6', htmlspecialchars($pem_saraf_tangan['medianus_06']));
	$templateklinik->setValue('mdn_7', htmlspecialchars($pem_saraf_tangan['medianus_07']));
	$templateklinik->setValue('mdn_8', htmlspecialchars($pem_saraf_tangan['medianus_08']));
	$templateklinik->setValue('mdn_9', htmlspecialchars($pem_saraf_tangan['medianus_09']));
	$templateklinik->setValue('mdn_10', htmlspecialchars($pem_saraf_tangan['medianus_10']));
	$templateklinik->setValue('mdn_11', htmlspecialchars($pem_saraf_tangan['medianus_11']));
	$templateklinik->setValue('mdn_12', htmlspecialchars($pem_saraf_tangan['medianus_12']));
	
	$templateklinik->setValue('rdl_1', htmlspecialchars($pem_saraf_tangan['radialis_01']));
	$templateklinik->setValue('rdl_2', htmlspecialchars($pem_saraf_tangan['radialis_02']));
	$templateklinik->setValue('rdl_3', htmlspecialchars($pem_saraf_tangan['radialis_03']));
	$templateklinik->setValue('rdl_4', htmlspecialchars($pem_saraf_tangan['radialis_04']));
	$templateklinik->setValue('rdl_5', htmlspecialchars($pem_saraf_tangan['radialis_05']));
	$templateklinik->setValue('rdl_6', htmlspecialchars($pem_saraf_tangan['radialis_06']));
	$templateklinik->setValue('rdl_7', htmlspecialchars($pem_saraf_tangan['radialis_07']));
	$templateklinik->setValue('rdl_8', htmlspecialchars($pem_saraf_tangan['radialis_08']));
	$templateklinik->setValue('rdl_9', htmlspecialchars($pem_saraf_tangan['radialis_09']));
	$templateklinik->setValue('rdl_10', htmlspecialchars($pem_saraf_tangan['radialis_10']));
	$templateklinik->setValue('rdl_11', htmlspecialchars($pem_saraf_tangan['radialis_11']));
	$templateklinik->setValue('rdl_12', htmlspecialchars($pem_saraf_tangan['radialis_12']));
	
	$templateklinik->setValue('abd_1', htmlspecialchars($pem_otot_tangan['digiti_01']));
	$templateklinik->setValue('abd_2', htmlspecialchars($pem_otot_tangan['digiti_02']));
	$templateklinik->setValue('abd_3', htmlspecialchars($pem_otot_tangan['digiti_03']));
	$templateklinik->setValue('abd_4', htmlspecialchars($pem_otot_tangan['digiti_04']));
	$templateklinik->setValue('abd_5', htmlspecialchars($pem_otot_tangan['digiti_05']));
	$templateklinik->setValue('abd_6', htmlspecialchars($pem_otot_tangan['digiti_06']));
	$templateklinik->setValue('abd_7', htmlspecialchars($pem_otot_tangan['digiti_07']));
	$templateklinik->setValue('abd_8', htmlspecialchars($pem_otot_tangan['digiti_08']));
	$templateklinik->setValue('abd_9', htmlspecialchars($pem_otot_tangan['digiti_09']));
	$templateklinik->setValue('abd_10', htmlspecialchars($pem_otot_tangan['digiti_10']));
	$templateklinik->setValue('abd_11', htmlspecialchars($pem_otot_tangan['digiti_11']));
	$templateklinik->setValue('abd_12', htmlspecialchars($pem_otot_tangan['digiti_12']));
	
	$templateklinik->setValue('drs_1', htmlspecialchars($pem_otot_tangan['dorsal_01']));
	$templateklinik->setValue('drs_2', htmlspecialchars($pem_otot_tangan['dorsal_02']));
	$templateklinik->setValue('drs_3', htmlspecialchars($pem_otot_tangan['dorsal_03']));
	$templateklinik->setValue('drs_4', htmlspecialchars($pem_otot_tangan['dorsal_04']));
	$templateklinik->setValue('drs_5', htmlspecialchars($pem_otot_tangan['dorsal_05']));
	$templateklinik->setValue('drs_6', htmlspecialchars($pem_otot_tangan['dorsal_06']));
	$templateklinik->setValue('drs_7', htmlspecialchars($pem_otot_tangan['dorsal_07']));
	$templateklinik->setValue('drs_8', htmlspecialchars($pem_otot_tangan['dorsal_08']));
	$templateklinik->setValue('drs_9', htmlspecialchars($pem_otot_tangan['dorsal_09']));
	$templateklinik->setValue('drs_10', htmlspecialchars($pem_otot_tangan['dorsal_10']));
	$templateklinik->setValue('drs_11', htmlspecialchars($pem_otot_tangan['dorsal_11']));
	$templateklinik->setValue('drs_12', htmlspecialchars($pem_otot_tangan['dorsal_12']));
	
	$templateklinik->setValue('lmb_1', htmlspecialchars($pem_otot_tangan['lumbrical_01']));
	$templateklinik->setValue('lmb_2', htmlspecialchars($pem_otot_tangan['lumbrical_02']));
	$templateklinik->setValue('lmb_3', htmlspecialchars($pem_otot_tangan['lumbrical_03']));
	$templateklinik->setValue('lmb_4', htmlspecialchars($pem_otot_tangan['lumbrical_04']));
	$templateklinik->setValue('lmb_5', htmlspecialchars($pem_otot_tangan['lumbrical_05']));
	$templateklinik->setValue('lmb_6', htmlspecialchars($pem_otot_tangan['lumbrical_06']));
	$templateklinik->setValue('lmb_7', htmlspecialchars($pem_otot_tangan['lumbrical_07']));
	$templateklinik->setValue('lmb_8', htmlspecialchars($pem_otot_tangan['lumbrical_08']));
	$templateklinik->setValue('lmb_9', htmlspecialchars($pem_otot_tangan['lumbrical_09']));
	$templateklinik->setValue('lmb_10', htmlspecialchars($pem_otot_tangan['lumbrical_10']));
	$templateklinik->setValue('lmb_11', htmlspecialchars($pem_otot_tangan['lumbrical_11']));
	$templateklinik->setValue('lmb_12', htmlspecialchars($pem_otot_tangan['lumbrical_12']));
	
	$templateklinik->setValue('plc_1', htmlspecialchars($pem_otot_tangan['pollicis_01']));
	$templateklinik->setValue('plc_2', htmlspecialchars($pem_otot_tangan['pollicis_02']));
	$templateklinik->setValue('plc_3', htmlspecialchars($pem_otot_tangan['pollicis_03']));
	$templateklinik->setValue('plc_4', htmlspecialchars($pem_otot_tangan['pollicis_04']));
	$templateklinik->setValue('plc_5', htmlspecialchars($pem_otot_tangan['pollicis_05']));
	$templateklinik->setValue('plc_6', htmlspecialchars($pem_otot_tangan['pollicis_06']));
	$templateklinik->setValue('plc_7', htmlspecialchars($pem_otot_tangan['pollicis_07']));
	$templateklinik->setValue('plc_8', htmlspecialchars($pem_otot_tangan['pollicis_08']));
	$templateklinik->setValue('plc_9', htmlspecialchars($pem_otot_tangan['pollicis_09']));
	$templateklinik->setValue('plc_10', htmlspecialchars($pem_otot_tangan['pollicis_10']));
	$templateklinik->setValue('plc_11', htmlspecialchars($pem_otot_tangan['pollicis_11']));
	$templateklinik->setValue('plc_12', htmlspecialchars($pem_otot_tangan['pollicis_12']));
	
	$templateklinik->setValue('bri_1', htmlspecialchars($pem_otot_tangan['lumbrical2_01']));
	$templateklinik->setValue('bri_2', htmlspecialchars($pem_otot_tangan['lumbrical2_02']));
	$templateklinik->setValue('bri_3', htmlspecialchars($pem_otot_tangan['lumbrical2_03']));
	$templateklinik->setValue('bri_4', htmlspecialchars($pem_otot_tangan['lumbrical2_04']));
	$templateklinik->setValue('bri_5', htmlspecialchars($pem_otot_tangan['lumbrical2_05']));
	$templateklinik->setValue('bri_6', htmlspecialchars($pem_otot_tangan['lumbrical2_06']));
	$templateklinik->setValue('bri_7', htmlspecialchars($pem_otot_tangan['lumbrical2_07']));
	$templateklinik->setValue('bri_8', htmlspecialchars($pem_otot_tangan['lumbrical2_08']));
	$templateklinik->setValue('bri_9', htmlspecialchars($pem_otot_tangan['lumbrical2_09']));
	$templateklinik->setValue('bri_10', htmlspecialchars($pem_otot_tangan['lumbrical2_10']));
	$templateklinik->setValue('bri_11', htmlspecialchars($pem_otot_tangan['lumbrical2_11']));
	$templateklinik->setValue('bri_12', htmlspecialchars($pem_otot_tangan['lumbrical2_12']));
	
	$templateklinik->setValue('crp_1', htmlspecialchars($pem_otot_tangan['carpi_01']));
	$templateklinik->setValue('crp_2', htmlspecialchars($pem_otot_tangan['carpi_02']));
	$templateklinik->setValue('crp_3', htmlspecialchars($pem_otot_tangan['carpi_03']));
	$templateklinik->setValue('crp_4', htmlspecialchars($pem_otot_tangan['carpi_04']));
	$templateklinik->setValue('crp_5', htmlspecialchars($pem_otot_tangan['carpi_05']));
	$templateklinik->setValue('crp_6', htmlspecialchars($pem_otot_tangan['carpi_06']));
	$templateklinik->setValue('crp_7', htmlspecialchars($pem_otot_tangan['carpi_07']));
	$templateklinik->setValue('crp_8', htmlspecialchars($pem_otot_tangan['carpi_08']));
	$templateklinik->setValue('crp_9', htmlspecialchars($pem_otot_tangan['carpi_09']));
	$templateklinik->setValue('crp_10', htmlspecialchars($pem_otot_tangan['carpi_10']));
	$templateklinik->setValue('crp_11', htmlspecialchars($pem_otot_tangan['carpi_11']));
	$templateklinik->setValue('crp_12', htmlspecialchars($pem_otot_tangan['carpi_12']));
	
	$templateklinik->setValue('dgt_1', htmlspecialchars($pem_otot_tangan['minimi_01']));
	$templateklinik->setValue('dgt_2', htmlspecialchars($pem_otot_tangan['minimi_02']));
	$templateklinik->setValue('dgt_3', htmlspecialchars($pem_otot_tangan['minimi_03']));
	$templateklinik->setValue('dgt_4', htmlspecialchars($pem_otot_tangan['minimi_04']));
	$templateklinik->setValue('dgt_5', htmlspecialchars($pem_otot_tangan['minimi_05']));
	$templateklinik->setValue('dgt_6', htmlspecialchars($pem_otot_tangan['minimi_06']));
	$templateklinik->setValue('dgt_7', htmlspecialchars($pem_otot_tangan['minimi_07']));
	$templateklinik->setValue('dgt_8', htmlspecialchars($pem_otot_tangan['minimi_08']));
	$templateklinik->setValue('dgt_9', htmlspecialchars($pem_otot_tangan['minimi_09']));
	$templateklinik->setValue('dgt_10', htmlspecialchars($pem_otot_tangan['minimi_10']));
	$templateklinik->setValue('dgt_11', htmlspecialchars($pem_otot_tangan['minimi_11']));
	$templateklinik->setValue('dgt_12', htmlspecialchars($pem_otot_tangan['minimi_12']));
	
	$templateklinik->setValue('brp_lama', htmlspecialchars($kelemahan_otot_kaki));
	$templateklinik->setValue('rasa_sakit', htmlspecialchars($rasa_sakit_pada_saraf));
	$templateklinik->setValue('kelemahan_otot', htmlspecialchars($kelemahan_otot));
	
	$gambar_path = $app_path . 'nsimrs\\edoc_rekammedik\\new\\pemeriksaan_saraf_d_otot.jpg';
	if(file_exists($rmfile_path . '\\pengkajian_awal_medik_kusta\\'. $nomr . '_1_pso_kaki_' . $idx . '.jpg')){
		$gambar_path = $rmfile_path . '\\pengkajian_awal_medik_kusta\\'. $nomr . '_1_pso_kaki_' . $idx . '.jpg';
	}
	$templateklinik->setImageValue('gambar_1', array('path' => $gambar_path, 'width' => 600, 'height' => 550, 'ratio' => true));
	
	$gambar_path = $app_path . 'nsimrs\\edoc_rekammedik\\new\\pemeriksaan_saraf_d_otot.jpg';
	if(file_exists($rmfile_path . '\\pengkajian_awal_medik_kusta\\'. $nomr . '_1_pso_tangan_' . $idx . '.jpg')){
		$gambar_path = $rmfile_path . '\\pengkajian_awal_medik_kusta\\'. $nomr . '_1_pso_tangan_' . $idx . '.jpg';
	}
	$templateklinik->setImageValue('gambar_2', array('path' => $gambar_path, 'width' => 600, 'height' => 550, 'ratio' => true));
	
	if(!file_exists($rmfile_path . '/pdf/1/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/pdf/1/' . $nomr . '/' . $idx, 0700, true);
	}

	if(!file_exists($rmfile_path . '/doc/1/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/doc/1/' . $nomr . '/' . $idx, 0700, true);
	}
	
	$nama_file = $nomr . '_' . $idx . '_28';	
	$templateklinik->saveAs($rmfile_path . '/doc/1/' . $nomr . '/' . $idx . '/' . $nama_file . '.docx');
	
	mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE RAWAT_ID = "' . $idx . '"
				AND JNS_PERAWATAN = "1"
				AND JENIS_DOKUMEN_ID = "28"
				AND NAMA_FILE = "' . $nama_file . '.pdf"') or die(mysql_error());
	mysql_query('INSERT INTO t_rm_dokumen_file(JENIS_DOKUMEN_ID,NOMR,RAWAT_ID,JNS_PERAWATAN,NAMA_FILE,ST_SISTEM) 		
				VALUES("28","' . $nomr . '","' . $idx . '","1","' . $nama_file . '.pdf","1")') or die(mysql_error());
	
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