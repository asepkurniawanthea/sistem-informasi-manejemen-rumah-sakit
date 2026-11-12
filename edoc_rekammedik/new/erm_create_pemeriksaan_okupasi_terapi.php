<?php
function erm_pemeriksaan_okupasi_terapi($idx){
	global $rmfile_path, $app_path;

	$checked = '<w:sym w:font="Wingdings" w:char="F0FE"/>';
    $unChecked = '<w:sym w:font="Wingdings" w:char="F0A8"/>';
	
	$templateklinik = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\pemeriksaan_okupasi_terapi.docx');
	
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
	
	$qry_pengkajian = 'SELECT IRJA_ID,RIWAYAT_PENYAKIT,PEMERIKSAAN_AKTIFITAS_SEHARI_HARI,PEMERIKSAAN_AKTIFITAS_BEKERJA,
			PEMERIKSAAN_AKTIFITAS_WAKTU_LUANG,PEMERIKSAAN_AKTIFITAS_MOTORIK,PEMERIKSAAN_AKTIFITAS_SENSORIK,
			INTERVENSI_OKUPASI_TERAPI,DATE_FORMAT(TGL_ASSESMENT,"%d-%m-%Y %H:%i") AS TGL_ASSESMENT
			FROM t_pemeriksaan_okupasi_terapi
			WHERE IRJA_ID = "' . $idx . '"';
	$get_pengkajian = mysql_query($qry_pengkajian) or die(mysql_error());
	$dat_pengkajian = mysql_fetch_assoc($get_pengkajian);
	$idx = $dat_pengkajian['IRJA_ID'];
	
	$riwayat_penyakit = str_replace('|','"',$dat_pengkajian['RIWAYAT_PENYAKIT']);
	$riwayat_penyakit = preg_replace('/\r|\n/','\n',trim($riwayat_penyakit));
	$riwayat_penyakit = json_decode($riwayat_penyakit,true);
	
	$aktivitas_sehari = str_replace('|','"',$dat_pengkajian['PEMERIKSAAN_AKTIFITAS_SEHARI_HARI']);
	$riwayat_penyakit = preg_replace('/\r|\n/','\n',trim($riwayat_penyakit));
	$aktivitas_sehari = json_decode($aktivitas_sehari,true);
	
	$aktivitas_bekerja = str_replace('|','"',$dat_pengkajian['PEMERIKSAAN_AKTIFITAS_BEKERJA']);
	$riwayat_penyakit = preg_replace('/\r|\n/','\n',trim($riwayat_penyakit));
	$aktivitas_bekerja = json_decode($aktivitas_bekerja,true);
	
	$aktivitas_luang = str_replace('|','"',$dat_pengkajian['PEMERIKSAAN_AKTIFITAS_WAKTU_LUANG']);
	$riwayat_penyakit = preg_replace('/\r|\n/','\n',trim($riwayat_penyakit));
	$aktivitas_luang = json_decode($aktivitas_luang,true);
	
	$aktivitas_motorik = str_replace('|','"',$dat_pengkajian['PEMERIKSAAN_AKTIFITAS_MOTORIK']);
	$riwayat_penyakit = preg_replace('/\r|\n/','\n',trim($riwayat_penyakit));
	$aktivitas_motorik = json_decode($aktivitas_motorik,true);
	
	$aktivitas_sensorik = str_replace('|','"',$dat_pengkajian['PEMERIKSAAN_AKTIFITAS_SENSORIK']);
	$riwayat_penyakit = preg_replace('/\r|\n/','\n',trim($riwayat_penyakit));
	$aktivitas_sensorik = json_decode($aktivitas_sensorik,true);
	
	$intervensi_okupasi = str_replace('|','"',$dat_pengkajian['INTERVENSI_OKUPASI_TERAPI']);
	$riwayat_penyakit = preg_replace('/\r|\n/','\n',trim($riwayat_penyakit));
	$intervensi_okupasi = json_decode($intervensi_okupasi,true);
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
	
	$templateklinik->setValue('informasi_subyektif', htmlspecialchars($riwayat_penyakit['rpenyakit_is']));
	$templateklinik->setValue('informasi_obyektif', htmlspecialchars($riwayat_penyakit['rpenyakit_io']));
	$templateklinik->setValue('problem_okupasi_terapi', htmlspecialchars($riwayat_penyakit['rpenyakit_pr']));
	
	$templateklinik->setValue('bhs_1', htmlspecialchars($aktivitas_sehari['berhias_01']));
	$templateklinik->setValue('bhs_2', htmlspecialchars($aktivitas_sehari['berhias_02']));
	$templateklinik->setValue('bhs_3', htmlspecialchars($aktivitas_sehari['berhias_03']));
	$templateklinik->setValue('bhs_4', htmlspecialchars($aktivitas_sehari['berhias_04']));
	$templateklinik->setValue('bhs_5', htmlspecialchars($aktivitas_sehari['berhias_05']));
	$templateklinik->setValue('bhs_6', htmlspecialchars($aktivitas_sehari['berhias_06']));
	$templateklinik->setValue('bhs_ket', htmlspecialchars($aktivitas_sehari['berhias_ket']));
	
	$templateklinik->setValue('gsg_1', htmlspecialchars($aktivitas_sehari['gigi_01']));
	$templateklinik->setValue('gsg_2', htmlspecialchars($aktivitas_sehari['gigi_02']));
	$templateklinik->setValue('gsg_3', htmlspecialchars($aktivitas_sehari['gigi_03']));
	$templateklinik->setValue('gsg_4', htmlspecialchars($aktivitas_sehari['gigi_04']));
	$templateklinik->setValue('gsg_5', htmlspecialchars($aktivitas_sehari['gigi_05']));
	$templateklinik->setValue('gsg_6', htmlspecialchars($aktivitas_sehari['gigi_06']));
	$templateklinik->setValue('gsg_ket', htmlspecialchars($aktivitas_sehari['gigi_ket']));
	
	$templateklinik->setValue('mnd_1', htmlspecialchars($aktivitas_sehari['mandi_01']));
	$templateklinik->setValue('mnd_2', htmlspecialchars($aktivitas_sehari['mandi_02']));
	$templateklinik->setValue('mnd_3', htmlspecialchars($aktivitas_sehari['mandi_03']));
	$templateklinik->setValue('mnd_4', htmlspecialchars($aktivitas_sehari['mandi_04']));
	$templateklinik->setValue('mnd_5', htmlspecialchars($aktivitas_sehari['mandi_05']));
	$templateklinik->setValue('mnd_6', htmlspecialchars($aktivitas_sehari['mandi_06']));
	$templateklinik->setValue('mnd_ket', htmlspecialchars($aktivitas_sehari['mandi_ket']));
	
	$templateklinik->setValue('pkn_1', htmlspecialchars($aktivitas_sehari['berpakaian_01']));
	$templateklinik->setValue('pkn_2', htmlspecialchars($aktivitas_sehari['berpakaian_02']));
	$templateklinik->setValue('pkn_3', htmlspecialchars($aktivitas_sehari['berpakaian_03']));
	$templateklinik->setValue('pkn_4', htmlspecialchars($aktivitas_sehari['berpakaian_04']));
	$templateklinik->setValue('pkn_5', htmlspecialchars($aktivitas_sehari['berpakaian_05']));
	$templateklinik->setValue('pkn_6', htmlspecialchars($aktivitas_sehari['berpakaian_06']));
	$templateklinik->setValue('pkn_ket', htmlspecialchars($aktivitas_sehari['berpakaian_ket']));
	
	$templateklinik->setValue('bab_1', htmlspecialchars($aktivitas_sehari['bab_01']));
	$templateklinik->setValue('bab_2', htmlspecialchars($aktivitas_sehari['bab_02']));
	$templateklinik->setValue('bab_3', htmlspecialchars($aktivitas_sehari['bab_03']));
	$templateklinik->setValue('bab_4', htmlspecialchars($aktivitas_sehari['bab_04']));
	$templateklinik->setValue('bab_5', htmlspecialchars($aktivitas_sehari['bab_05']));
	$templateklinik->setValue('bab_6', htmlspecialchars($aktivitas_sehari['bab_06']));
	$templateklinik->setValue('bab_ket', htmlspecialchars($aktivitas_sehari['bab_ket']));
	
	$templateklinik->setValue('mkn_1', htmlspecialchars($aktivitas_sehari['makan_01']));
	$templateklinik->setValue('mkn_2', htmlspecialchars($aktivitas_sehari['makan_02']));
	$templateklinik->setValue('mkn_3', htmlspecialchars($aktivitas_sehari['makan_03']));
	$templateklinik->setValue('mkn_4', htmlspecialchars($aktivitas_sehari['makan_04']));
	$templateklinik->setValue('mkn_5', htmlspecialchars($aktivitas_sehari['makan_05']));
	$templateklinik->setValue('mkn_6', htmlspecialchars($aktivitas_sehari['makan_06']));
	$templateklinik->setValue('mkn_ket', htmlspecialchars($aktivitas_sehari['makan_ket']));
	
	$templateklinik->setValue('ssl_1', htmlspecialchars($aktivitas_sehari['sosialisasi_01']));
	$templateklinik->setValue('ssl_2', htmlspecialchars($aktivitas_sehari['sosialisasi_02']));
	$templateklinik->setValue('ssl_3', htmlspecialchars($aktivitas_sehari['sosialisasi_03']));
	$templateklinik->setValue('ssl_4', htmlspecialchars($aktivitas_sehari['sosialisasi_04']));
	$templateklinik->setValue('ssl_5', htmlspecialchars($aktivitas_sehari['sosialisasi_05']));
	$templateklinik->setValue('ssl_6', htmlspecialchars($aktivitas_sehari['sosialisasi_06']));
	$templateklinik->setValue('ssl_ket', htmlspecialchars($aktivitas_sehari['sosialisasi_ket']));
	
	$templateklinik->setValue('kmn_1', htmlspecialchars($aktivitas_sehari['komunikasi_01']));
	$templateklinik->setValue('kmn_2', htmlspecialchars($aktivitas_sehari['komunikasi_02']));
	$templateklinik->setValue('kmn_3', htmlspecialchars($aktivitas_sehari['komunikasi_03']));
	$templateklinik->setValue('kmn_4', htmlspecialchars($aktivitas_sehari['komunikasi_04']));
	$templateklinik->setValue('kmn_5', htmlspecialchars($aktivitas_sehari['komunikasi_05']));
	$templateklinik->setValue('kmn_6', htmlspecialchars($aktivitas_sehari['komunikasi_06']));
	$templateklinik->setValue('kmn_ket', htmlspecialchars($aktivitas_sehari['komunikasi_ket']));
	
	$templateklinik->setValue('mbl_1', htmlspecialchars($aktivitas_sehari['mobilitas_01']));
	$templateklinik->setValue('mbl_2', htmlspecialchars($aktivitas_sehari['mobilitas_02']));
	$templateklinik->setValue('mbl_3', htmlspecialchars($aktivitas_sehari['mobilitas_03']));
	$templateklinik->setValue('mbl_4', htmlspecialchars($aktivitas_sehari['mobilitas_04']));
	$templateklinik->setValue('mbl_5', htmlspecialchars($aktivitas_sehari['mobilitas_05']));
	$templateklinik->setValue('mbl_6', htmlspecialchars($aktivitas_sehari['mobilitas_06']));
	$templateklinik->setValue('mbl_ket', htmlspecialchars($aktivitas_sehari['mobilitas_ket']));
	
	$templateklinik->setValue('sks_1', htmlspecialchars($aktivitas_sehari['seksual_01']));
	$templateklinik->setValue('sks_2', htmlspecialchars($aktivitas_sehari['seksual_02']));
	$templateklinik->setValue('sks_3', htmlspecialchars($aktivitas_sehari['seksual_03']));
	$templateklinik->setValue('sks_4', htmlspecialchars($aktivitas_sehari['seksual_04']));
	$templateklinik->setValue('sks_5', htmlspecialchars($aktivitas_sehari['seksual_05']));
	$templateklinik->setValue('sks_6', htmlspecialchars($aktivitas_sehari['seksual_06']));
	$templateklinik->setValue('sks_ket', htmlspecialchars($aktivitas_sehari['seksual_ket']));
	
	$templateklinik->setValue('mrt_1', htmlspecialchars($aktivitas_bekerja['rumah_01']));
	$templateklinik->setValue('mrt_2', htmlspecialchars($aktivitas_bekerja['rumah_02']));
	$templateklinik->setValue('mrt_3', htmlspecialchars($aktivitas_bekerja['rumah_03']));
	$templateklinik->setValue('mrt_4', htmlspecialchars($aktivitas_bekerja['rumah_04']));
	$templateklinik->setValue('mrt_5', htmlspecialchars($aktivitas_bekerja['rumah_05']));
	$templateklinik->setValue('mrt_6', htmlspecialchars($aktivitas_bekerja['rumah_06']));
	$templateklinik->setValue('mrt_ket', htmlspecialchars($aktivitas_bekerja['rumah_ket']));
	
	$templateklinik->setValue('skl_1', htmlspecialchars($aktivitas_bekerja['sekolah_01']));
	$templateklinik->setValue('skl_2', htmlspecialchars($aktivitas_bekerja['sekolah_02']));
	$templateklinik->setValue('skl_3', htmlspecialchars($aktivitas_bekerja['sekolah_03']));
	$templateklinik->setValue('skl_4', htmlspecialchars($aktivitas_bekerja['sekolah_04']));
	$templateklinik->setValue('skl_5', htmlspecialchars($aktivitas_bekerja['sekolah_05']));
	$templateklinik->setValue('skl_6', htmlspecialchars($aktivitas_bekerja['sekolah_06']));
	$templateklinik->setValue('skl_ket', htmlspecialchars($aktivitas_bekerja['sekolah_ket']));
	
	$templateklinik->setValue('bkr_1', htmlspecialchars($aktivitas_bekerja['bekerja_01']));
	$templateklinik->setValue('bkr_2', htmlspecialchars($aktivitas_bekerja['bekerja_02']));
	$templateklinik->setValue('bkr_3', htmlspecialchars($aktivitas_bekerja['bekerja_03']));
	$templateklinik->setValue('bkr_4', htmlspecialchars($aktivitas_bekerja['bekerja_04']));
	$templateklinik->setValue('bkr_5', htmlspecialchars($aktivitas_bekerja['bekerja_05']));
	$templateklinik->setValue('bkr_6', htmlspecialchars($aktivitas_bekerja['bekerja_06']));
	$templateklinik->setValue('bkr_ket', htmlspecialchars($aktivitas_bekerja['bekerja_ket']));
	
	$templateklinik->setValue('lsr_1', htmlspecialchars($aktivitas_luang['kinerja_01']));
	$templateklinik->setValue('lsr_2', htmlspecialchars($aktivitas_luang['kinerja_02']));
	$templateklinik->setValue('lsr_3', htmlspecialchars($aktivitas_luang['kinerja_03']));
	$templateklinik->setValue('lsr_4', htmlspecialchars($aktivitas_luang['kinerja_04']));
	$templateklinik->setValue('lsr_5', htmlspecialchars($aktivitas_luang['kinerja_05']));
	$templateklinik->setValue('lsr_6', htmlspecialchars($aktivitas_luang['kinerja_06']));
	$templateklinik->setValue('lsr_ket', htmlspecialchars($aktivitas_luang['kinerja_ket']));
	
	$templateklinik->setValue('eks_1', htmlspecialchars($aktivitas_luang['eksporasi_01']));
	$templateklinik->setValue('eks_2', htmlspecialchars($aktivitas_luang['eksporasi_02']));
	$templateklinik->setValue('eks_3', htmlspecialchars($aktivitas_luang['eksporasi_03']));
	$templateklinik->setValue('eks_4', htmlspecialchars($aktivitas_luang['eksporasi_04']));
	$templateklinik->setValue('eks_5', htmlspecialchars($aktivitas_luang['eksporasi_05']));
	$templateklinik->setValue('eks_6', htmlspecialchars($aktivitas_luang['eksporasi_06']));
	$templateklinik->setValue('eks_ket', htmlspecialchars($aktivitas_luang['eksporasi_ket']));
	
	$templateklinik->setValue('ksr_1', htmlspecialchars($aktivitas_motorik['m_kasar_01']));
	$templateklinik->setValue('ksr_2', htmlspecialchars($aktivitas_motorik['m_kasar_02']));
	$templateklinik->setValue('ksr_3', htmlspecialchars($aktivitas_motorik['m_kasar_03']));
	$templateklinik->setValue('ksr_4', htmlspecialchars($aktivitas_motorik['m_kasar_04']));
	$templateklinik->setValue('ksr_5', htmlspecialchars($aktivitas_motorik['m_kasar_05']));
	$templateklinik->setValue('ksr_6', htmlspecialchars($aktivitas_motorik['m_kasar_06']));
	$templateklinik->setValue('ksr_ket', htmlspecialchars($aktivitas_motorik['m_kasar_ket']));
	
	$templateklinik->setValue('mrg_1', htmlspecialchars($aktivitas_motorik['miring_01']));
	$templateklinik->setValue('mrg_2', htmlspecialchars($aktivitas_motorik['miring_02']));
	$templateklinik->setValue('mrg_3', htmlspecialchars($aktivitas_motorik['miring_03']));
	$templateklinik->setValue('mrg_4', htmlspecialchars($aktivitas_motorik['miring_04']));
	$templateklinik->setValue('mrg_5', htmlspecialchars($aktivitas_motorik['miring_05']));
	$templateklinik->setValue('mrg_6', htmlspecialchars($aktivitas_motorik['miring_06']));
	$templateklinik->setValue('mrg_ket', htmlspecialchars($aktivitas_motorik['miring_ket']));
	
	$templateklinik->setValue('ddk_1', htmlspecialchars($aktivitas_motorik['duduk_01']));
	$templateklinik->setValue('ddk_2', htmlspecialchars($aktivitas_motorik['duduk_02']));
	$templateklinik->setValue('ddk_3', htmlspecialchars($aktivitas_motorik['duduk_03']));
	$templateklinik->setValue('ddk_4', htmlspecialchars($aktivitas_motorik['duduk_04']));
	$templateklinik->setValue('ddk_5', htmlspecialchars($aktivitas_motorik['duduk_05']));
	$templateklinik->setValue('ddk_6', htmlspecialchars($aktivitas_motorik['duduk_06']));
	$templateklinik->setValue('ddk_ket', htmlspecialchars($aktivitas_motorik['duduk_ket']));
	
	$templateklinik->setValue('bdr_1', htmlspecialchars($aktivitas_motorik['berdiri_01']));
	$templateklinik->setValue('bdr_2', htmlspecialchars($aktivitas_motorik['berdiri_02']));
	$templateklinik->setValue('bdr_3', htmlspecialchars($aktivitas_motorik['berdiri_03']));
	$templateklinik->setValue('bdr_4', htmlspecialchars($aktivitas_motorik['berdiri_04']));
	$templateklinik->setValue('bdr_5', htmlspecialchars($aktivitas_motorik['berdiri_05']));
	$templateklinik->setValue('bdr_6', htmlspecialchars($aktivitas_motorik['berdiri_06']));
	$templateklinik->setValue('bdr_ket', htmlspecialchars($aktivitas_motorik['berdiri_ket']));
	
	$templateklinik->setValue('bjl_1', htmlspecialchars($aktivitas_motorik['duduk_01']));
	$templateklinik->setValue('bjl_2', htmlspecialchars($aktivitas_motorik['duduk_02']));
	$templateklinik->setValue('bjl_3', htmlspecialchars($aktivitas_motorik['duduk_03']));
	$templateklinik->setValue('bjl_4', htmlspecialchars($aktivitas_motorik['duduk_04']));
	$templateklinik->setValue('bjl_5', htmlspecialchars($aktivitas_motorik['duduk_05']));
	$templateklinik->setValue('bjl_6', htmlspecialchars($aktivitas_motorik['duduk_06']));
	$templateklinik->setValue('bjl_ket', htmlspecialchars($aktivitas_motorik['duduk_ket']));
	
	$templateklinik->setValue('hls_1', htmlspecialchars($aktivitas_motorik['m_halus_01']));
	$templateklinik->setValue('hls_2', htmlspecialchars($aktivitas_motorik['m_halus_02']));
	$templateklinik->setValue('hls_3', htmlspecialchars($aktivitas_motorik['m_halus_03']));
	$templateklinik->setValue('hls_4', htmlspecialchars($aktivitas_motorik['m_halus_04']));
	$templateklinik->setValue('hls_5', htmlspecialchars($aktivitas_motorik['m_halus_05']));
	$templateklinik->setValue('hls_6', htmlspecialchars($aktivitas_motorik['m_halus_06']));
	$templateklinik->setValue('hls_ket', htmlspecialchars($aktivitas_motorik['m_halus_ket']));
	
	$templateklinik->setValue('rch_1', htmlspecialchars($aktivitas_motorik['reach_01']));
	$templateklinik->setValue('rch_2', htmlspecialchars($aktivitas_motorik['reach_02']));
	$templateklinik->setValue('rch_3', htmlspecialchars($aktivitas_motorik['reach_03']));
	$templateklinik->setValue('rch_4', htmlspecialchars($aktivitas_motorik['reach_04']));
	$templateklinik->setValue('rch_5', htmlspecialchars($aktivitas_motorik['reach_05']));
	$templateklinik->setValue('rch_6', htmlspecialchars($aktivitas_motorik['reach_06']));
	$templateklinik->setValue('rch_ket', htmlspecialchars($aktivitas_motorik['reach_ket']));
	
	$templateklinik->setValue('grs_1', htmlspecialchars($aktivitas_motorik['grasp_01']));
	$templateklinik->setValue('grs_2', htmlspecialchars($aktivitas_motorik['grasp_02']));
	$templateklinik->setValue('grs_3', htmlspecialchars($aktivitas_motorik['grasp_03']));
	$templateklinik->setValue('grs_4', htmlspecialchars($aktivitas_motorik['grasp_04']));
	$templateklinik->setValue('grs_5', htmlspecialchars($aktivitas_motorik['grasp_05']));
	$templateklinik->setValue('grs_6', htmlspecialchars($aktivitas_motorik['grasp_06']));
	$templateklinik->setValue('grs_ket', htmlspecialchars($aktivitas_motorik['grasp_ket']));
	
	$templateklinik->setValue('hok_1', htmlspecialchars($aktivitas_motorik['hook_01']));
	$templateklinik->setValue('hok_2', htmlspecialchars($aktivitas_motorik['hook_02']));
	$templateklinik->setValue('hok_3', htmlspecialchars($aktivitas_motorik['hook_03']));
	$templateklinik->setValue('hok_4', htmlspecialchars($aktivitas_motorik['hook_04']));
	$templateklinik->setValue('hok_5', htmlspecialchars($aktivitas_motorik['hook_05']));
	$templateklinik->setValue('hok_6', htmlspecialchars($aktivitas_motorik['hook_06']));
	$templateklinik->setValue('hok_ket', htmlspecialchars($aktivitas_motorik['hook_ket']));
	
	$templateklinik->setValue('pwr_1', htmlspecialchars($aktivitas_motorik['power_01']));
	$templateklinik->setValue('pwr_2', htmlspecialchars($aktivitas_motorik['power_02']));
	$templateklinik->setValue('pwr_3', htmlspecialchars($aktivitas_motorik['power_03']));
	$templateklinik->setValue('pwr_4', htmlspecialchars($aktivitas_motorik['power_04']));
	$templateklinik->setValue('pwr_5', htmlspecialchars($aktivitas_motorik['power_05']));
	$templateklinik->setValue('pwr_6', htmlspecialchars($aktivitas_motorik['power_06']));
	$templateklinik->setValue('pwr_ket', htmlspecialchars($aktivitas_motorik['power_ket']));
	
	$templateklinik->setValue('ltr_1', htmlspecialchars($aktivitas_motorik['lateral_01']));
	$templateklinik->setValue('ltr_2', htmlspecialchars($aktivitas_motorik['lateral_02']));
	$templateklinik->setValue('ltr_3', htmlspecialchars($aktivitas_motorik['lateral_03']));
	$templateklinik->setValue('ltr_4', htmlspecialchars($aktivitas_motorik['lateral_04']));
	$templateklinik->setValue('ltr_5', htmlspecialchars($aktivitas_motorik['lateral_05']));
	$templateklinik->setValue('ltr_6', htmlspecialchars($aktivitas_motorik['lateral_06']));
	$templateklinik->setValue('ltr_ket', htmlspecialchars($aktivitas_motorik['lateral_ket']));
	
	$templateklinik->setValue('pad_1', htmlspecialchars($aktivitas_motorik['pad_01']));
	$templateklinik->setValue('pad_2', htmlspecialchars($aktivitas_motorik['pad_02']));
	$templateklinik->setValue('pad_3', htmlspecialchars($aktivitas_motorik['pad_03']));
	$templateklinik->setValue('pad_4', htmlspecialchars($aktivitas_motorik['pad_04']));
	$templateklinik->setValue('pad_5', htmlspecialchars($aktivitas_motorik['pad_05']));
	$templateklinik->setValue('pad_6', htmlspecialchars($aktivitas_motorik['pad_06']));
	$templateklinik->setValue('pad_ket', htmlspecialchars($aktivitas_motorik['pad_ket']));
	
	$templateklinik->setValue('jaw_1', htmlspecialchars($aktivitas_motorik['three_01']));
	$templateklinik->setValue('jaw_2', htmlspecialchars($aktivitas_motorik['three_02']));
	$templateklinik->setValue('jaw_3', htmlspecialchars($aktivitas_motorik['three_03']));
	$templateklinik->setValue('jaw_4', htmlspecialchars($aktivitas_motorik['three_04']));
	$templateklinik->setValue('jaw_5', htmlspecialchars($aktivitas_motorik['three_05']));
	$templateklinik->setValue('jaw_6', htmlspecialchars($aktivitas_motorik['three_06']));
	$templateklinik->setValue('jaw_ket', htmlspecialchars($aktivitas_motorik['three_ket']));
	
	$templateklinik->setValue('tip_1', htmlspecialchars($aktivitas_motorik['tip_01']));
	$templateklinik->setValue('tip_2', htmlspecialchars($aktivitas_motorik['tip_02']));
	$templateklinik->setValue('tip_3', htmlspecialchars($aktivitas_motorik['tip_03']));
	$templateklinik->setValue('tip_4', htmlspecialchars($aktivitas_motorik['tip_04']));
	$templateklinik->setValue('tip_5', htmlspecialchars($aktivitas_motorik['tip_05']));
	$templateklinik->setValue('tip_6', htmlspecialchars($aktivitas_motorik['tip_06']));
	$templateklinik->setValue('tip_ket', htmlspecialchars($aktivitas_motorik['tip_ket']));
	
	$templateklinik->setValue('sph_1', htmlspecialchars($aktivitas_motorik['speherical_01']));
	$templateklinik->setValue('sph_2', htmlspecialchars($aktivitas_motorik['speherical_02']));
	$templateklinik->setValue('sph_3', htmlspecialchars($aktivitas_motorik['speherical_03']));
	$templateklinik->setValue('sph_4', htmlspecialchars($aktivitas_motorik['speherical_04']));
	$templateklinik->setValue('sph_5', htmlspecialchars($aktivitas_motorik['speherical_05']));
	$templateklinik->setValue('sph_6', htmlspecialchars($aktivitas_motorik['speherical_06']));
	$templateklinik->setValue('sph_ket', htmlspecialchars($aktivitas_motorik['speherical_ket']));
	
	$templateklinik->setValue('cyl_1', htmlspecialchars($aktivitas_motorik['cylindrical_01']));
	$templateklinik->setValue('cyl_2', htmlspecialchars($aktivitas_motorik['cylindrical_02']));
	$templateklinik->setValue('cyl_3', htmlspecialchars($aktivitas_motorik['cylindrical_03']));
	$templateklinik->setValue('cyl_4', htmlspecialchars($aktivitas_motorik['cylindrical_04']));
	$templateklinik->setValue('cyl_5', htmlspecialchars($aktivitas_motorik['cylindrical_05']));
	$templateklinik->setValue('cyl_6', htmlspecialchars($aktivitas_motorik['cylindrical_06']));
	$templateklinik->setValue('cyl_ket', htmlspecialchars($aktivitas_motorik['cylindrical_ket']));
	
	$templateklinik->setValue('dis_1', htmlspecialchars($aktivitas_motorik['disc_01']));
	$templateklinik->setValue('dis_2', htmlspecialchars($aktivitas_motorik['disc_02']));
	$templateklinik->setValue('dis_3', htmlspecialchars($aktivitas_motorik['disc_03']));
	$templateklinik->setValue('dis_4', htmlspecialchars($aktivitas_motorik['disc_04']));
	$templateklinik->setValue('dis_5', htmlspecialchars($aktivitas_motorik['disc_05']));
	$templateklinik->setValue('dis_6', htmlspecialchars($aktivitas_motorik['disc_06']));
	$templateklinik->setValue('dis_ket', htmlspecialchars($aktivitas_motorik['disc_ket']));
	
	
	$templateklinik->setValue('mnp_1', htmlspecialchars($aktivitas_motorik['manipulasi_01']));
	$templateklinik->setValue('mnp_2', htmlspecialchars($aktivitas_motorik['manipulasi_02']));
	$templateklinik->setValue('mnp_3', htmlspecialchars($aktivitas_motorik['manipulasi_03']));
	$templateklinik->setValue('mnp_4', htmlspecialchars($aktivitas_motorik['manipulasi_04']));
	$templateklinik->setValue('mnp_5', htmlspecialchars($aktivitas_motorik['manipulasi_05']));
	$templateklinik->setValue('mnp_6', htmlspecialchars($aktivitas_motorik['manipulasi_06']));
	$templateklinik->setValue('mnp_ket', htmlspecialchars($aktivitas_motorik['manipulasi_ket']));
	
	$templateklinik->setValue('mmt_1', htmlspecialchars($aktivitas_motorik['memutar_01']));
	$templateklinik->setValue('mmt_2', htmlspecialchars($aktivitas_motorik['memutar_02']));
	$templateklinik->setValue('mmt_3', htmlspecialchars($aktivitas_motorik['memutar_03']));
	$templateklinik->setValue('mmt_4', htmlspecialchars($aktivitas_motorik['memutar_04']));
	$templateklinik->setValue('mmt_5', htmlspecialchars($aktivitas_motorik['memutar_05']));
	$templateklinik->setValue('mmt_6', htmlspecialchars($aktivitas_motorik['memutar_06']));
	$templateklinik->setValue('mmt_ket', htmlspecialchars($aktivitas_motorik['memutar_ket']));
	
	$templateklinik->setValue('bnd_1', htmlspecialchars($aktivitas_motorik['benda_01']));
	$templateklinik->setValue('bnd_2', htmlspecialchars($aktivitas_motorik['benda_02']));
	$templateklinik->setValue('bnd_3', htmlspecialchars($aktivitas_motorik['benda_03']));
	$templateklinik->setValue('bnd_4', htmlspecialchars($aktivitas_motorik['benda_04']));
	$templateklinik->setValue('bnd_5', htmlspecialchars($aktivitas_motorik['benda_05']));
	$templateklinik->setValue('bnd_6', htmlspecialchars($aktivitas_motorik['benda_06']));
	$templateklinik->setValue('bnd_ket', htmlspecialchars($aktivitas_motorik['benda_ket']));
	
	$templateklinik->setValue('cry_1', htmlspecialchars($aktivitas_motorik['carry_01']));
	$templateklinik->setValue('cry_2', htmlspecialchars($aktivitas_motorik['carry_02']));
	$templateklinik->setValue('cry_3', htmlspecialchars($aktivitas_motorik['carry_03']));
	$templateklinik->setValue('cry_4', htmlspecialchars($aktivitas_motorik['carry_04']));
	$templateklinik->setValue('cry_5', htmlspecialchars($aktivitas_motorik['carry_05']));
	$templateklinik->setValue('cry_6', htmlspecialchars($aktivitas_motorik['carry_06']));
	$templateklinik->setValue('cry_ket', htmlspecialchars($aktivitas_motorik['carry_ket']));
	
	$templateklinik->setValue('vlt_1', htmlspecialchars($aktivitas_motorik['voluntary_01']));
	$templateklinik->setValue('vlt_2', htmlspecialchars($aktivitas_motorik['voluntary_02']));
	$templateklinik->setValue('vlt_3', htmlspecialchars($aktivitas_motorik['voluntary_03']));
	$templateklinik->setValue('vlt_4', htmlspecialchars($aktivitas_motorik['voluntary_04']));
	$templateklinik->setValue('vlt_5', htmlspecialchars($aktivitas_motorik['voluntary_05']));
	$templateklinik->setValue('vlt_6', htmlspecialchars($aktivitas_motorik['voluntary_06']));
	$templateklinik->setValue('vlt_ket', htmlspecialchars($aktivitas_motorik['voluntary_ket']));
	
	$templateklinik->setValue('sdr_1', htmlspecialchars($aktivitas_motorik['melepas_01']));
	$templateklinik->setValue('sdr_2', htmlspecialchars($aktivitas_motorik['melepas_02']));
	$templateklinik->setValue('sdr_3', htmlspecialchars($aktivitas_motorik['melepas_03']));
	$templateklinik->setValue('sdr_4', htmlspecialchars($aktivitas_motorik['melepas_04']));
	$templateklinik->setValue('sdr_5', htmlspecialchars($aktivitas_motorik['melepas_05']));
	$templateklinik->setValue('sdr_6', htmlspecialchars($aktivitas_motorik['melepas_06']));
	$templateklinik->setValue('sdr_ket', htmlspecialchars($aktivitas_motorik['melepas_ket']));
	
	$templateklinik->setValue('blt_1', htmlspecialchars($aktivitas_motorik['bilateral_01']));
	$templateklinik->setValue('blt_2', htmlspecialchars($aktivitas_motorik['bilateral_02']));
	$templateklinik->setValue('blt_3', htmlspecialchars($aktivitas_motorik['bilateral_03']));
	$templateklinik->setValue('blt_4', htmlspecialchars($aktivitas_motorik['bilateral_04']));
	$templateklinik->setValue('blt_5', htmlspecialchars($aktivitas_motorik['bilateral_05']));
	$templateklinik->setValue('blt_6', htmlspecialchars($aktivitas_motorik['bilateral_06']));
	$templateklinik->setValue('blt_ket', htmlspecialchars($aktivitas_motorik['bilateral_ket']));
	
	$templateklinik->setValue('ssk_1', htmlspecialchars($aktivitas_sensorik['sensorik_01']));
	$templateklinik->setValue('ssk_2', htmlspecialchars($aktivitas_sensorik['sensorik_02']));
	$templateklinik->setValue('ssk_3', htmlspecialchars($aktivitas_sensorik['sensorik_03']));
	$templateklinik->setValue('ssk_4', htmlspecialchars($aktivitas_sensorik['sensorik_04']));
	$templateklinik->setValue('ssk_5', htmlspecialchars($aktivitas_sensorik['sensorik_05']));
	$templateklinik->setValue('ssk_6', htmlspecialchars($aktivitas_sensorik['sensorik_06']));
	$templateklinik->setValue('ssk_ket', htmlspecialchars($aktivitas_sensorik['sensorik_ket']));
	
	$templateklinik->setValue('tkl_1', htmlspecialchars($aktivitas_sensorik['taktil_01']));
	$templateklinik->setValue('tkl_2', htmlspecialchars($aktivitas_sensorik['taktil_02']));
	$templateklinik->setValue('tkl_3', htmlspecialchars($aktivitas_sensorik['taktil_03']));
	$templateklinik->setValue('tkl_4', htmlspecialchars($aktivitas_sensorik['taktil_04']));
	$templateklinik->setValue('tkl_5', htmlspecialchars($aktivitas_sensorik['taktil_05']));
	$templateklinik->setValue('tkl_6', htmlspecialchars($aktivitas_sensorik['taktil_06']));
	$templateklinik->setValue('tkl_ket', htmlspecialchars($aktivitas_sensorik['taktil_ket']));
	
	$templateklinik->setValue('stg_1', htmlspecialchars($aktivitas_sensorik['stereogonis_01']));
	$templateklinik->setValue('stg_2', htmlspecialchars($aktivitas_sensorik['stereogonis_02']));
	$templateklinik->setValue('stg_3', htmlspecialchars($aktivitas_sensorik['stereogonis_03']));
	$templateklinik->setValue('stg_4', htmlspecialchars($aktivitas_sensorik['stereogonis_04']));
	$templateklinik->setValue('stg_5', htmlspecialchars($aktivitas_sensorik['stereogonis_05']));
	$templateklinik->setValue('stg_6', htmlspecialchars($aktivitas_sensorik['stereogonis_06']));
	$templateklinik->setValue('stg_ket', htmlspecialchars($aktivitas_sensorik['stereogonis_ket']));
	
	$templateklinik->setValue('kgf_1', htmlspecialchars($aktivitas_sensorik['kognitif_01']));
	$templateklinik->setValue('kgf_2', htmlspecialchars($aktivitas_sensorik['kognitif_02']));
	$templateklinik->setValue('kgf_3', htmlspecialchars($aktivitas_sensorik['kognitif_03']));
	$templateklinik->setValue('kgf_4', htmlspecialchars($aktivitas_sensorik['kognitif_04']));
	$templateklinik->setValue('kgf_5', htmlspecialchars($aktivitas_sensorik['kognitif_05']));
	$templateklinik->setValue('kgf_6', htmlspecialchars($aktivitas_sensorik['kognitif_06']));
	$templateklinik->setValue('kgf_ket', htmlspecialchars($aktivitas_sensorik['kognitif_ket']));
	
	$templateklinik->setValue('mtv_1', htmlspecialchars($aktivitas_sensorik['motivasi_01']));
	$templateklinik->setValue('mtv_2', htmlspecialchars($aktivitas_sensorik['motivasi_02']));
	$templateklinik->setValue('mtv_3', htmlspecialchars($aktivitas_sensorik['motivasi_03']));
	$templateklinik->setValue('mtv_4', htmlspecialchars($aktivitas_sensorik['motivasi_04']));
	$templateklinik->setValue('mtv_5', htmlspecialchars($aktivitas_sensorik['motivasi_05']));
	$templateklinik->setValue('mtv_6', htmlspecialchars($aktivitas_sensorik['motivasi_06']));
	$templateklinik->setValue('mtv_ket', htmlspecialchars($aktivitas_sensorik['motivasi_ket']));
	
	$templateklinik->setValue('ats_1', htmlspecialchars($aktivitas_sensorik['atensi_01']));
	$templateklinik->setValue('ats_2', htmlspecialchars($aktivitas_sensorik['atensi_02']));
	$templateklinik->setValue('ats_3', htmlspecialchars($aktivitas_sensorik['atensi_03']));
	$templateklinik->setValue('ats_4', htmlspecialchars($aktivitas_sensorik['atensi_04']));
	$templateklinik->setValue('ats_5', htmlspecialchars($aktivitas_sensorik['atensi_05']));
	$templateklinik->setValue('ats_6', htmlspecialchars($aktivitas_sensorik['atensi_06']));
	$templateklinik->setValue('ats_ket', htmlspecialchars($aktivitas_sensorik['atensi_ket']));
	
	$templateklinik->setValue('pbm_1', htmlspecialchars($aktivitas_sensorik['problem_01']));
	$templateklinik->setValue('pbm_2', htmlspecialchars($aktivitas_sensorik['problem_02']));
	$templateklinik->setValue('pbm_3', htmlspecialchars($aktivitas_sensorik['problem_03']));
	$templateklinik->setValue('pbm_4', htmlspecialchars($aktivitas_sensorik['problem_04']));
	$templateklinik->setValue('pbm_5', htmlspecialchars($aktivitas_sensorik['problem_05']));
	$templateklinik->setValue('pbm_6', htmlspecialchars($aktivitas_sensorik['problem_06']));
	$templateklinik->setValue('pbm_ket', htmlspecialchars($aktivitas_sensorik['problem_ket']));
	
	$templateklinik->setValue('rtg_1', htmlspecialchars($aktivitas_sensorik['rentang_01']));
	$templateklinik->setValue('rtg_2', htmlspecialchars($aktivitas_sensorik['rentang_02']));
	$templateklinik->setValue('rtg_3', htmlspecialchars($aktivitas_sensorik['rentang_03']));
	$templateklinik->setValue('rtg_4', htmlspecialchars($aktivitas_sensorik['rentang_04']));
	$templateklinik->setValue('rtg_5', htmlspecialchars($aktivitas_sensorik['rentang_05']));
	$templateklinik->setValue('rtg_6', htmlspecialchars($aktivitas_sensorik['rentang_06']));
	$templateklinik->setValue('rtg_ket', htmlspecialchars($aktivitas_sensorik['rentang_ket']));
	
	$templateklinik->setValue('rtg_1', htmlspecialchars($aktivitas_sensorik['rentang_01']));
	$templateklinik->setValue('rtg_2', htmlspecialchars($aktivitas_sensorik['rentang_02']));
	$templateklinik->setValue('rtg_3', htmlspecialchars($aktivitas_sensorik['rentang_03']));
	$templateklinik->setValue('rtg_4', htmlspecialchars($aktivitas_sensorik['rentang_04']));
	$templateklinik->setValue('rtg_5', htmlspecialchars($aktivitas_sensorik['rentang_05']));
	$templateklinik->setValue('rtg_6', htmlspecialchars($aktivitas_sensorik['rentang_06']));
	$templateklinik->setValue('rtg_ket', htmlspecialchars($aktivitas_sensorik['rentang_ket']));
	
	$templateklinik->setValue('jangka_panjang', htmlspecialchars($intervensi_okupasi['intenvensi_jp']));
	$templateklinik->setValue('jangka_pendek', htmlspecialchars($intervensi_okupasi['intenvensi_jk']));
	$templateklinik->setValue('alat_bantu', htmlspecialchars($intervensi_okupasi['intenvensi_ab']));
	$templateklinik->setValue('adaptasi_aktifitas', htmlspecialchars($intervensi_okupasi['intenvensi_aa']));
	
	if(!file_exists($rmfile_path . '/pdf/1/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/pdf/1/' . $nomr . '/' . $idx, 0700, true);
	}

	if(!file_exists($rmfile_path . '/doc/1/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/doc/1/' . $nomr . '/' . $idx, 0700, true);
	}
	
	$nama_file = $nomr . '_' . $idx . '_26';	
	$templateklinik->saveAs($rmfile_path . '/doc/1/' . $nomr . '/' . $idx . '/' . $nama_file . '.docx');
	
	mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE RAWAT_ID = "' . $idx . '"
				AND JNS_PERAWATAN = "1"
				AND JENIS_DOKUMEN_ID = "26"
				AND NAMA_FILE = "' . $nama_file . '.pdf"') or die(mysql_error());
	mysql_query('INSERT INTO t_rm_dokumen_file(JENIS_DOKUMEN_ID,NOMR,RAWAT_ID,JNS_PERAWATAN,NAMA_FILE,ST_SISTEM) 		
				VALUES("26","' . $nomr . '","' . $idx . '","1","' . $nama_file . '.pdf","1")') or die(mysql_error());
	
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