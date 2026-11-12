<?php
if (empty($unit_id))
		$_err = $_err . 'Paket MCU Harus Diisi. \n';
	if (empty($jenis_bayar_id))
		$_err = $_err . 'Jenis Pembayaran Harus Diisi. \n';
	if ($jenis_bayar_id != '1'){	
		if (empty($no_peserta))
		$_err = $_err . 'Nomor Peserta Harus Diisi. \n';	
	}		
	if (empty($asal_pasien_id))
		$_err = $_err . 'Asal Pasien Harus Diisi. \n';	
	if ($asal_pasien_id != '1'){
		if (empty($ket_asal_pasien))
		$_err = $_err . 'Keterangan Asal Pasien Harus Diisi. \n';	
	}	

	$sql_cek_no_pendaftaran = 'SELECT NO_PENDAFTARAN FROM t_irja WHERE IRJA_ID = "' . $irja_id . '"';
	$get_cek_no_pendaftaran = mysql_query($sql_cek_no_pendaftaran) or die(mysql_error());
	$dat_cek_no_pendaftaran = mysql_fetch_assoc($get_cek_no_pendaftaran);

    $st_save = true;
	if(empty($dat_cek_no_pendaftaran['NO_PENDAFTARAN'])){
	if (empty($_err)) {
    if (!empty($_POST['irja_id'])) {
		$no_sjp = getNomorHarian('SJP');
		$no_pendaftaran = getNomorBulanan('IRJA');
		
		$q_kunjungan = 'SELECT COUNT(IRJA_ID) AS CN FROM t_irja WHERE NOMR = "' . $nomr . '"
						AND NO_PENDAFTARAN IS NOT NULL AND ST_BATAL IS NULL
						AND DATE_FORMAT(TANGGAL_DAFTAR,"%m%Y") = DATE_FORMAT(NOW(),"%m%Y")';
		$g_kunjungan = mysql_query($q_kunjungan) or die(mysql_error());
		$d_kunjungan = mysql_fetch_assoc($g_kunjungan);
		$kunj_baru = '1';
		if($d_kunjungan['CN'] > 0) $kunj_baru = ''; 
        $st_save = mysql_query('UPDATE t_irja SET UNIT_ID = "1",PEGAWAI_ID = "' . $pegawai_id . '",
						JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",ASAL_PASIEN_ID = "' . $asal_pasien_id . '",
						KET_ASAL_PASIEN = "' . $ket_asal_pasien . '",NO_PESERTA = "' . $no_peserta . '",NO_SEP = "' . $no_sep . '",NO_SJP = "' . $no_sjp . '",
						P_JAWAB_NAMA = "' . $p_jawab_nama . '",P_JAWAB_NO_TELP = "' . $p_jawab_no_telp . '",P_JAWAB_ALAMAT = "' . $p_jawab_alamat . '",P_JAWAB_ALAMAT_RT = "' . $p_jawab_alamat_rt . '",
						P_JAWAB_ALAMAT_RW = "' . $p_jawab_alamat_rw . '",P_JAWAB_KELURAHAN_ID = "' . $p_jawab_kelurahan_id . '",P_JAWAB_KECAMATAN_ID = "' . $p_jawab_kecamatan_id . '",
						P_JAWAB_KOTA_ID = "' . $p_jawab_kota_id . '",P_JAWAB_PROPINSI_ID = "' . $p_jawab_propinsi_id . '",P_JAWAB_HUBUNGAN = "' . $p_jawab_hubungan . '",
						USER_PENDAFTARAN = "' . $user_name . '",NO_PENDAFTARAN = "' . $no_pendaftaran . '",
						JKN_TGL_RUJUK = STR_TO_DATE("' . $jkn_tgl_rujuk . '","%d/%m/%Y"),JKN_NO_RUJUK = "' . $jkn_no_rujuk . '",
						JKN_KD_PKK = "' . $jkn_kd_pkk . '",JKN_NAMA_PKK = "' . $jkn_nama_pkk . '",JKN_CATATAN = "' . $jkn_catatan . '",
						JKN_DIAGNOSA = "' . $jkn_diagnosa . '",JKN_POLIKLINIK = "' . $jkn_poliklinik . '",
						JKN_PBI_NONPBI = "' . $jkn_pbi_nonpbi . '",JKN_ASAL_RUJUKAN = "' . $jkn_asal_rujukan . '",
						JKN_COB = "' . $jkn_cob . '",JKN_PENJAMIN = "' . $jkn_penjamin . '",JKN_KATARAK = "' . $jkn_katarak . '",
						JKN_SUPLESI = "' . $jkn_suplesi . '",JKN_NO_SEP_SUPLESI = "' . $jkn_nosep_suplesi . '",JKN_NOSURAT_SKDP = "' . $jkn_nosurat_skdp . '",
						JKN_DPJP_SKDP = "' . $jkn_dpjp_skdp . '",JKN_NAMA_DPJP_SKDP = "' . $jkn_nama_dpjp_skdp . '",
						JKN_SPESIALISASI_DPJP_SKDP = "' . $jkn_spesialis_dpjp_skdp . '",KD_LOKASI_KECELAKAAN_PROPINSI = "' . $kd_lokasi_kecelakaan_propinsi . '",
						NAMA_LOKASI_KECELAKAAN_PROPINSI = "' . $nama_lokasi_kecelakaan_propinsi . '",KD_LOKASI_KECELAKAAN_KABUPATEN = "' . $kd_lokasi_kecelakaan_kota . '",
						NAMA_LOKASI_KECELAKAAN_KABUPATEN = "' . $nama_lokasi_kecelakaan_kota . '",KD_LOKASI_KECELAKAAN_KECAMATAN = "' . $kd_lokasi_kecelakaan_kecamatan . '",
						NAMA_LOKASI_KECELAKAAN_KECAMATAN = "' . $nama_lokasi_kecelakaan_kecamatan . '",TGL_KEJADIAN_KECELAKAAN = STR_TO_DATE("' . $tgl_kejadian_kecelakaan . '","%d/%m/%Y"),
						KETERANGAN_KECELAKAAN = "' . $keterangan_kecelakaan . '",KECELAKAAN = "' . $pasien_kecelakaan . '",KUNJ_BARU = "' . $kunj_baru . '",
						KASUS_POLISI = "' . $kasus_polisi . '"
						WHERE IRJA_ID = "' . $irja_id . '"') or die(mysql_error());
				//edoc rekam medic
				include('edoc_rekammedik/edoc_main.php');
				create_pdf_identitas($irja_id,'RJ');
				create_pdf_ringkasan_kunjungan_rawat_jalan($irja_id);
				//	
				
        if ($st_save) {
            $no_bayar_pdalam = 'NULL';
			$no_bayar_mata = 'NULL';
			$no_bayar_rad = 'NULL';
			$no_bayar_lab = 'NULL';
			$no_bayar_ekg = 'NULL';
			$st_bayar = 'NULL';
			if($jenis_bayar_id <> '1'){
				$no_bayar_pdalam = '"' . getNomorHarian('Kasir') . '"';
				$no_bayar_mata = '"' . getNomorHarian('Kasir') . '"';
				$no_bayar_rad = '"' . getNomorHarian('Kasir') . '"';
				$no_bayar_lab = '"' . getNomorHarian('Kasir') . '"';
				$no_bayar_ekg = '"' . getNomorHarian('Kasir') . '"';
				$st_bayar = '"Lunas"';
			}
			$nomor_pdalam = getNomorHarian('Tarif');
			$nomor_mata = getNomorHarian('Tarif');
			$nomor_rad = getNomorHarian('Tarif');
			$nomor_lab = getNomorHarian('Tarif');
			$nomor_ekg = getNomorHarian('Tarif');
			if($unit_id == 'mcu1'){
				//mcu paket A
				//pendaftaran
				$sql_tarif_karcis = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "102001" AND ST_AKTIF = "1"';
				$get_tarif_karcis = mysql_query($sql_tarif_karcis) or die(mysql_error());
				$dat_tarif_karcis = mysql_fetch_assoc($get_tarif_karcis);
				$tarif_karcis_id = $dat_tarif_karcis['TARIF_ID'];
				mysql_query('INSERT INTO t_irja_tarif(IRJA_ID,TGL_TARIF,TARIF_ID,KUANTITI,NO_TARIF,NO_PEMBAYARAN,DESKRIPSI,ST_BAYAR,
						JENIS_BAYAR_ID,USER_PENDAFTARAN)
						VALUES("' . $irja_id . '",NOW(),"' . $tarif_karcis_id . '",1,"' . $nomor_pdalam . '", ' . $no_bayar_pdalam . ',"Karcis & Konsultasi",' . $st_bayar . ',"' . $jenis_bayar_id . '","' . $user_name . '")') or die(mysql_error());				
				//konsultasi & pemeriksaan fisik
				$sql_tarif_konsul = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "102003" AND ST_AKTIF = "1"';
				$get_tarif_konsul = mysql_query($sql_tarif_konsul) or die(mysql_error());
				$dat_tarif_konsul = mysql_fetch_assoc($get_tarif_konsul);
				$tarif_konsul_id = $dat_tarif_konsul['TARIF_ID'];
				mysql_query('INSERT INTO t_irja_tarif(IRJA_ID,TGL_TARIF,TARIF_ID,KUANTITI,NO_TARIF,NO_PEMBAYARAN,DESKRIPSI,ST_BAYAR,
							JENIS_BAYAR_ID,USER_PENDAFTARAN)
							VALUES("' . $irja_id . '",NOW(),"' . $tarif_konsul_id . '",1,"' . $nomor_pdalam . '", ' . $no_bayar_pdalam . ',"Karcis & Konsultasi",' . $st_bayar . ',"' . $jenis_bayar_id . '","' . $user_name . '")') or die(mysql_error());	
				$sql_tarif_pemeriksaan = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "102002" AND ST_AKTIF = "1"';
				$get_tarif_pemeriksaan = mysql_query($sql_tarif_pemeriksaan) or die(mysql_error());
				$dat_tarif_pemeriksaan = mysql_fetch_assoc($get_tarif_pemeriksaan);
				$tarif_pemeriksaan_id = $dat_tarif_pemeriksaan['TARIF_ID'];
				mysql_query('INSERT INTO t_irja_tarif(IRJA_ID,TGL_TARIF,TARIF_ID,KUANTITI,NO_TARIF,NO_PEMBAYARAN,DESKRIPSI,ST_BAYAR,
							JENIS_BAYAR_ID,USER_PENDAFTARAN)
							VALUES("' . $irja_id . '",NOW(),"' . $tarif_pemeriksaan_id . '",1,"' . $nomor_pdalam . '", ' . $no_bayar_pdalam . ',"Karcis & Konsultasi",' . $st_bayar . ',"' . $jenis_bayar_id . '","' . $user_name . '")') or die(mysql_error());	
				
				$sql_tarif_konsul = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "102004" AND ST_AKTIF = "1"';
				$get_tarif_konsul = mysql_query($sql_tarif_konsul) or die(mysql_error());
				$dat_tarif_konsul = mysql_fetch_assoc($get_tarif_konsul);
				$tarif_konsul_id = $dat_tarif_konsul['TARIF_ID'];
				mysql_query('INSERT INTO t_irja_tarif(IRJA_ID,TGL_TARIF,TARIF_ID,KUANTITI,NO_TARIF,NO_PEMBAYARAN,DESKRIPSI,ST_BAYAR,
							JENIS_BAYAR_ID,USER_PENDAFTARAN)
							VALUES("' . $max_irja_id . '",NOW(),"' . $tarif_konsul_id . '",1,"' . $nomor_mata . '", ' . $no_bayar_mata . ',"Karcis & Konsultasi",' . $st_bayar . ',"' . $jenis_bayar_id . '","' . $user_name . '")') or die(mysql_error());	
				//laboratorium
				$deskripsi = 'Penunjang (Pendaftaran)';
				$nomor_order = getNomorBulanan('IPENUNJANG');
				mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID,NO_ORDER,DESKRIPSI,PEGAWAI_ID,
								NOMR,TANGGAL_ORDER,UNIT_ID,USER_ORDER,JENIS_BAYAR_ID,MCU) VALUES(
								"PNJ","IRJ","' . $irja_id . '","' . $nomor_order . '","' . $deskripsi . '",
								"596","' . $nomr . '",NOW(),"1","' . $user_name . '","' . $jenis_bayar_id . '",
								"' . $unit_id . '")') or die(mysql_error());
				$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "PNJ" AND t_ipenunjang.JNS_ORDER = "IRJ"
									AND t_ipenunjang.RAWAT_ID = "' . $irja_id . '" AND t_ipenunjang.NO_ORDER = "' . $nomor_order . '"
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
				$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
				$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
				$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];	
				
				$sql_tarif_lab = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "102005" AND ST_AKTIF = "1"';
				$get_tarif_lab = mysql_query($sql_tarif_lab) or die(mysql_error());
				$dat_tarif_lab = mysql_fetch_assoc($get_tarif_lab);
				$tarif_lab_id = $dat_tarif_lab['TARIF_ID'];
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $penunjang_id . '","' . $tarif_lab_id . '",1)') or die(mysql_error());
				$sql_tarif_lab = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "102006" AND ST_AKTIF = "1"';
				$get_tarif_lab = mysql_query($sql_tarif_lab) or die(mysql_error());
				$dat_tarif_lab = mysql_fetch_assoc($get_tarif_lab);
				$tarif_lab_id = $dat_tarif_lab['TARIF_ID'];
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $penunjang_id . '","' . $tarif_lab_id . '",1)') or die(mysql_error());
				mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_DAFTAR = NOW(),
									UNIT_PENUNJANG_ID = "45",JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
									ST_BAYAR = ' . $st_bayar . ',NO_TARIF = "' . $nomor_lab . '",NO_SJP = "' . $no_sjp . '",
									NO_PEMBAYARAN = ' . $no_bayar_lab . ',
									SHIFT_PENDAFTARAN = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",USER_PENDAFTARAN = "' . $user_name . '",
									ST_TPP = "1",PEGAWAI_PERIKSA_ID = NULL,
									NO_SEP = "' . $no_sep . '",TANGGAL_SEP = NOW(),
									NO_PESERTA = "' . $no_peserta . '",JKN_TGL_RUJUK = ' . fieldDate($jkn_tgl_rujuk) . ',
									JKN_NO_RUJUK = "' . $jkn_no_rujuk . '",JKN_KD_PKK = "' . $jkn_kd_pkk . '",
									JKN_NAMA_PKK = "' . $jkn_nama_pkk . '",JKN_CATATAN = "' . $jkn_catatan . '",
									JKN_DIAGNOSA = "' . $jkn_diagnosa . '",JKN_POLIKLINIK = "' . $jkn_poliklinik . '",
									JKN_KELAS_RAWAT = NULL,JKN_PBI_NONPBI = "' . $jkn_pbi_nonpbi . '",
									JKN_ASAL_RUJUKAN = "' . $jkn_asal_rujukan . '",JKN_COB = "' . $jkn_cob . '",
									JKN_PENJAMIN = "' . $jkn_penjamin . '"
									WHERE PENUNJANG_ID =  "' . $penunjang_id . '"') or die(mysql_error());
				//radiologi
				$nomor_order = getNomorBulanan('IPENUNJANG');
				mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID,NO_ORDER,DESKRIPSI,PEGAWAI_ID,
								NOMR,TANGGAL_ORDER,UNIT_ID,USER_ORDER,JENIS_BAYAR_ID,MCU) VALUES(
								"PNJ","IRJ","' . $irja_id . '","' . $nomor_order . '","' . $deskripsi . '",
								"596","' . $nomr . '",NOW(),"1","' . $user_name . '","' . $jenis_bayar_id . '",
								"' . $unit_id . '")') or die(mysql_error());
				$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "PNJ" AND t_ipenunjang.JNS_ORDER = "IRJ"
									AND t_ipenunjang.RAWAT_ID = "' . $irja_id . '" AND t_ipenunjang.NO_ORDER = "' . $nomor_order . '"
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
				$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
				$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
				$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];
				$sql_tarif_rad = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "102007" AND ST_AKTIF = "1"';
				$get_tarif_rad = mysql_query($sql_tarif_rad) or die(mysql_error());
				$dat_tarif_rad = mysql_fetch_assoc($get_tarif_rad);
				$tarif_rad_id = $dat_tarif_rad['TARIF_ID'];
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $penunjang_id . '","' . $tarif_rad_id . '",1)') or die(mysql_error());
				mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_DAFTAR = NOW(),
									UNIT_PENUNJANG_ID = "17",JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
									ST_BAYAR = ' . $st_bayar . ',NO_TARIF = "' . $nomor_rad . '",NO_SJP = "' . $no_sjp . '",
									NO_PEMBAYARAN = ' . $no_bayar_rad . ',
									SHIFT_PENDAFTARAN = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",USER_PENDAFTARAN = "' . $user_name . '",
									ST_TPP = "1",PEGAWAI_PERIKSA_ID = NULL,
									NO_SEP = "' . $no_sep . '",TANGGAL_SEP = NOW(),
									NO_PESERTA = "' . $no_peserta . '",JKN_TGL_RUJUK = ' . fieldDate($jkn_tgl_rujuk) . ',
									JKN_NO_RUJUK = "' . $jkn_no_rujuk . '",JKN_KD_PKK = "' . $jkn_kd_pkk . '",
									JKN_NAMA_PKK = "' . $jkn_nama_pkk . '",JKN_CATATAN = "' . $jkn_catatan . '",
									JKN_DIAGNOSA = "' . $jkn_diagnosa . '",JKN_POLIKLINIK = "' . $jkn_poliklinik . '",
									JKN_KELAS_RAWAT = NULL,JKN_PBI_NONPBI = "' . $jkn_pbi_nonpbi . '",
									JKN_ASAL_RUJUKAN = "' . $jkn_asal_rujukan . '",JKN_COB = "' . $jkn_cob . '",
									JKN_PENJAMIN = "' . $jkn_penjamin . '"
									WHERE PENUNJANG_ID =  "' . $penunjang_id . '"') or die(mysql_error());
				//ruang tindakan
				$nomor_order = getNomorBulanan('IPENUNJANG');
				mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID,NO_ORDER,DESKRIPSI,PEGAWAI_ID,
								NOMR,TANGGAL_ORDER,UNIT_ID,USER_ORDER,JENIS_BAYAR_ID,MCU) VALUES(
								"PNJ","IRJ","' . $irja_id . '","' . $nomor_order . '","' . $deskripsi . '",
								"596","' . $nomr . '",NOW(),"1","' . $user_name . '","' . $jenis_bayar_id . '",
								"' . $unit_id . '")') or die(mysql_error());
				$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "PNJ" AND t_ipenunjang.JNS_ORDER = "IRJ"
									AND t_ipenunjang.RAWAT_ID = "' . $irja_id . '" AND t_ipenunjang.NO_ORDER = "' . $nomor_order . '"
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
				$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
				$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
				$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];
				$sql_tarif_ekg = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "102008" AND ST_AKTIF = "1"';
				$get_tarif_ekg = mysql_query($sql_tarif_ekg) or die(mysql_error());
				$dat_tarif_ekg = mysql_fetch_assoc($get_tarif_ekg);
				$tarif_ekg_id = $dat_tarif_ekg['TARIF_ID'];
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $penunjang_id . '","' . $tarif_ekg_id . '",1)') or die(mysql_error());
				mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_DAFTAR = NOW(),
									UNIT_PENUNJANG_ID = "52",JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
									ST_BAYAR = ' . $st_bayar . ',NO_TARIF = "' . $nomor_ekg . '",NO_SJP = "' . $no_sjp . '",
									NO_PEMBAYARAN = ' . $no_bayar_ekg . ',
									SHIFT_PENDAFTARAN = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",USER_PENDAFTARAN = "' . $user_name . '",
									ST_TPP = "1",PEGAWAI_PERIKSA_ID = NULL,
									NO_SEP = "' . $no_sep . '",TANGGAL_SEP = NOW(),
									NO_PESERTA = "' . $no_peserta . '",JKN_TGL_RUJUK = ' . fieldDate($jkn_tgl_rujuk) . ',
									JKN_NO_RUJUK = "' . $jkn_no_rujuk . '",JKN_KD_PKK = "' . $jkn_kd_pkk . '",
									JKN_NAMA_PKK = "' . $jkn_nama_pkk . '",JKN_CATATAN = "' . $jkn_catatan . '",
									JKN_DIAGNOSA = "' . $jkn_diagnosa . '",JKN_POLIKLINIK = "' . $jkn_poliklinik . '",
									JKN_KELAS_RAWAT = NULL,JKN_PBI_NONPBI = "' . $jkn_pbi_nonpbi . '",
									JKN_ASAL_RUJUKAN = "' . $jkn_asal_rujukan . '",JKN_COB = "' . $jkn_cob . '",
									JKN_PENJAMIN = "' . $jkn_penjamin . '"
									WHERE PENUNJANG_ID =  "' . $penunjang_id . '"') or die(mysql_error());
			//end mcu paket A
			}
			if($unit_id == 'mcu2'){
				//mcu paket B
				//pendaftaran
				$sql_tarif_karcis = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "103001" AND ST_AKTIF = "1"';
				$get_tarif_karcis = mysql_query($sql_tarif_karcis) or die(mysql_error());
				$dat_tarif_karcis = mysql_fetch_assoc($get_tarif_karcis);
				$tarif_karcis_id = $dat_tarif_karcis['TARIF_ID'];
				mysql_query('INSERT INTO t_irja_tarif(IRJA_ID,TGL_TARIF,TARIF_ID,KUANTITI,NO_TARIF,NO_PEMBAYARAN,DESKRIPSI,ST_BAYAR,
						JENIS_BAYAR_ID,USER_PENDAFTARAN)
						VALUES("' . $irja_id . '",NOW(),"' . $tarif_karcis_id . '",1,"' . $nomor_pdalam . '", ' . $no_bayar_pdalam . ',"Karcis & Konsultasi",' . $st_bayar . ',"' . $jenis_bayar_id . '","' . $user_name . '")') or die(mysql_error());				
				//konsultasi & pemeriksaan fisik
				$sql_tarif_konsul = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "103003" AND ST_AKTIF = "1"';
				$get_tarif_konsul = mysql_query($sql_tarif_konsul) or die(mysql_error());
				$dat_tarif_konsul = mysql_fetch_assoc($get_tarif_konsul);
				$tarif_konsul_id = $dat_tarif_konsul['TARIF_ID'];
				mysql_query('INSERT INTO t_irja_tarif(IRJA_ID,TGL_TARIF,TARIF_ID,KUANTITI,NO_TARIF,NO_PEMBAYARAN,DESKRIPSI,ST_BAYAR,
							JENIS_BAYAR_ID,USER_PENDAFTARAN)
							VALUES("' . $irja_id . '",NOW(),"' . $tarif_konsul_id . '",1,"' . $nomor_pdalam . '", ' . $no_bayar_pdalam . ',"Karcis & Konsultasi",' . $st_bayar . ',"' . $jenis_bayar_id . '","' . $user_name . '")') or die(mysql_error());	
				$sql_tarif_pemeriksaan = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "103002" AND ST_AKTIF = "1"';
				$get_tarif_pemeriksaan = mysql_query($sql_tarif_pemeriksaan) or die(mysql_error());
				$dat_tarif_pemeriksaan = mysql_fetch_assoc($get_tarif_pemeriksaan);
				$tarif_pemeriksaan_id = $dat_tarif_pemeriksaan['TARIF_ID'];
				mysql_query('INSERT INTO t_irja_tarif(IRJA_ID,TGL_TARIF,TARIF_ID,KUANTITI,NO_TARIF,NO_PEMBAYARAN,DESKRIPSI,ST_BAYAR,
							JENIS_BAYAR_ID,USER_PENDAFTARAN)
							VALUES("' . $irja_id . '",NOW(),"' . $tarif_pemeriksaan_id . '",1,"' . $nomor_pdalam . '", ' . $no_bayar_pdalam . ',"Karcis & Konsultasi",' . $st_bayar . ',"' . $jenis_bayar_id . '","' . $user_name . '")') or die(mysql_error());	
				
				$sql_tarif_konsul = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "103004" AND ST_AKTIF = "1"';
				$get_tarif_konsul = mysql_query($sql_tarif_konsul) or die(mysql_error());
				$dat_tarif_konsul = mysql_fetch_assoc($get_tarif_konsul);
				$tarif_konsul_id = $dat_tarif_konsul['TARIF_ID'];
				mysql_query('INSERT INTO t_irja_tarif(IRJA_ID,TGL_TARIF,TARIF_ID,KUANTITI,NO_TARIF,NO_PEMBAYARAN,DESKRIPSI,ST_BAYAR,
							JENIS_BAYAR_ID,USER_PENDAFTARAN)
							VALUES("' . $max_irja_id . '",NOW(),"' . $tarif_konsul_id . '",1,"' . $nomor_mata . '", ' . $no_bayar_mata . ',"Karcis & Konsultasi",' . $st_bayar . ',"' . $jenis_bayar_id . '","' . $user_name . '")') or die(mysql_error());	
				//laboratorium
				$deskripsi = 'Penunjang (Pendaftaran)';
				$nomor_order = getNomorBulanan('IPENUNJANG');
				mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID,NO_ORDER,DESKRIPSI,PEGAWAI_ID,
								NOMR,TANGGAL_ORDER,UNIT_ID,USER_ORDER,JENIS_BAYAR_ID,MCU) VALUES(
								"PNJ","IRJ","' . $irja_id . '","' . $nomor_order . '","' . $deskripsi . '",
								"596","' . $nomr . '",NOW(),"1","' . $user_name . '","' . $jenis_bayar_id . '",
								"' . $unit_id . '")') or die(mysql_error());
				$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "PNJ" AND t_ipenunjang.JNS_ORDER = "IRJ"
									AND t_ipenunjang.RAWAT_ID = "' . $irja_id . '" AND t_ipenunjang.NO_ORDER = "' . $nomor_order . '"
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
				$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
				$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
				$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];	
				
				$sql_tarif_lab = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "103005" AND ST_AKTIF = "1"';
				$get_tarif_lab = mysql_query($sql_tarif_lab) or die(mysql_error());
				$dat_tarif_lab = mysql_fetch_assoc($get_tarif_lab);
				$tarif_lab_id = $dat_tarif_lab['TARIF_ID'];
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $penunjang_id . '","' . $tarif_lab_id . '",1)') or die(mysql_error());
				$sql_tarif_lab = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "103006" AND ST_AKTIF = "1"';
				$get_tarif_lab = mysql_query($sql_tarif_lab) or die(mysql_error());
				$dat_tarif_lab = mysql_fetch_assoc($get_tarif_lab);
				$tarif_lab_id = $dat_tarif_lab['TARIF_ID'];
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $penunjang_id . '","' . $tarif_lab_id . '",1)') or die(mysql_error());
				$sql_tarif_lab = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "103007" AND ST_AKTIF = "1"';
				$get_tarif_lab = mysql_query($sql_tarif_lab) or die(mysql_error());
				$dat_tarif_lab = mysql_fetch_assoc($get_tarif_lab);
				$tarif_lab_id = $dat_tarif_lab['TARIF_ID'];
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $penunjang_id . '","' . $tarif_lab_id . '",1)') or die(mysql_error());
				$sql_tarif_lab = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "103008" AND ST_AKTIF = "1"';
				$get_tarif_lab = mysql_query($sql_tarif_lab) or die(mysql_error());
				$dat_tarif_lab = mysql_fetch_assoc($get_tarif_lab);
				$tarif_lab_id = $dat_tarif_lab['TARIF_ID'];
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $penunjang_id . '","' . $tarif_lab_id . '",1)') or die(mysql_error());
				$sql_tarif_lab = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "103009" AND ST_AKTIF = "1"';
				$get_tarif_lab = mysql_query($sql_tarif_lab) or die(mysql_error());
				$dat_tarif_lab = mysql_fetch_assoc($get_tarif_lab);
				$tarif_lab_id = $dat_tarif_lab['TARIF_ID'];
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $penunjang_id . '","' . $tarif_lab_id . '",1)') or die(mysql_error());
				$sql_tarif_lab = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "103010" AND ST_AKTIF = "1"';
				$get_tarif_lab = mysql_query($sql_tarif_lab) or die(mysql_error());
				$dat_tarif_lab = mysql_fetch_assoc($get_tarif_lab);
				$tarif_lab_id = $dat_tarif_lab['TARIF_ID'];
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $penunjang_id . '","' . $tarif_lab_id . '",1)') or die(mysql_error());
				$sql_tarif_lab = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "103011" AND ST_AKTIF = "1"';
				$get_tarif_lab = mysql_query($sql_tarif_lab) or die(mysql_error());
				$dat_tarif_lab = mysql_fetch_assoc($get_tarif_lab);
				$tarif_lab_id = $dat_tarif_lab['TARIF_ID'];
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $penunjang_id . '","' . $tarif_lab_id . '",1)') or die(mysql_error());
				$sql_tarif_lab = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "103012" AND ST_AKTIF = "1"';
				$get_tarif_lab = mysql_query($sql_tarif_lab) or die(mysql_error());
				$dat_tarif_lab = mysql_fetch_assoc($get_tarif_lab);
				$tarif_lab_id = $dat_tarif_lab['TARIF_ID'];
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $penunjang_id . '","' . $tarif_lab_id . '",1)') or die(mysql_error());
				mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_DAFTAR = NOW(),
									UNIT_PENUNJANG_ID = "45",JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
									ST_BAYAR = ' . $st_bayar . ',NO_TARIF = "' . $nomor_lab . '",NO_SJP = "' . $no_sjp . '",
									NO_PEMBAYARAN = ' . $no_bayar_lab . ',
									SHIFT_PENDAFTARAN = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",USER_PENDAFTARAN = "' . $user_name . '",
									ST_TPP = "1",PEGAWAI_PERIKSA_ID = NULL,
									NO_SEP = "' . $no_sep . '",TANGGAL_SEP = NOW(),
									NO_PESERTA = "' . $no_peserta . '",JKN_TGL_RUJUK = ' . fieldDate($jkn_tgl_rujuk) . ',
									JKN_NO_RUJUK = "' . $jkn_no_rujuk . '",JKN_KD_PKK = "' . $jkn_kd_pkk . '",
									JKN_NAMA_PKK = "' . $jkn_nama_pkk . '",JKN_CATATAN = "' . $jkn_catatan . '",
									JKN_DIAGNOSA = "' . $jkn_diagnosa . '",JKN_POLIKLINIK = "' . $jkn_poliklinik . '",
									JKN_KELAS_RAWAT = NULL,JKN_PBI_NONPBI = "' . $jkn_pbi_nonpbi . '",
									JKN_ASAL_RUJUKAN = "' . $jkn_asal_rujukan . '",JKN_COB = "' . $jkn_cob . '",
									JKN_PENJAMIN = "' . $jkn_penjamin . '"
									WHERE PENUNJANG_ID =  "' . $penunjang_id . '"') or die(mysql_error());
				//radiologi
				$nomor_order = getNomorBulanan('IPENUNJANG');
				mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID,NO_ORDER,DESKRIPSI,PEGAWAI_ID,
								NOMR,TANGGAL_ORDER,UNIT_ID,USER_ORDER,JENIS_BAYAR_ID,MCU) VALUES(
								"PNJ","IRJ","' . $irja_id . '","' . $nomor_order . '","' . $deskripsi . '",
								"596","' . $nomr . '",NOW(),"1","' . $user_name . '","' . $jenis_bayar_id . '",
								"' . $unit_id . '")') or die(mysql_error());
				$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "PNJ" AND t_ipenunjang.JNS_ORDER = "IRJ"
									AND t_ipenunjang.RAWAT_ID = "' . $irja_id . '" AND t_ipenunjang.NO_ORDER = "' . $nomor_order . '"
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
				$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
				$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
				$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];
				$sql_tarif_rad = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "103013" AND ST_AKTIF = "1"';
				$get_tarif_rad = mysql_query($sql_tarif_rad) or die(mysql_error());
				$dat_tarif_rad = mysql_fetch_assoc($get_tarif_rad);
				$tarif_rad_id = $dat_tarif_rad['TARIF_ID'];
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $penunjang_id . '","' . $tarif_rad_id . '",1)') or die(mysql_error());
				mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_DAFTAR = NOW(),
									UNIT_PENUNJANG_ID = "17",JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
									ST_BAYAR = ' . $st_bayar . ',NO_TARIF = "' . $nomor_rad . '",NO_SJP = "' . $no_sjp . '",
									NO_PEMBAYARAN = ' . $no_bayar_rad . ',
									SHIFT_PENDAFTARAN = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",USER_PENDAFTARAN = "' . $user_name . '",
									ST_TPP = "1",PEGAWAI_PERIKSA_ID = NULL,
									NO_SEP = "' . $no_sep . '",TANGGAL_SEP = NOW(),
									NO_PESERTA = "' . $no_peserta . '",JKN_TGL_RUJUK = ' . fieldDate($jkn_tgl_rujuk) . ',
									JKN_NO_RUJUK = "' . $jkn_no_rujuk . '",JKN_KD_PKK = "' . $jkn_kd_pkk . '",
									JKN_NAMA_PKK = "' . $jkn_nama_pkk . '",JKN_CATATAN = "' . $jkn_catatan . '",
									JKN_DIAGNOSA = "' . $jkn_diagnosa . '",JKN_POLIKLINIK = "' . $jkn_poliklinik . '",
									JKN_KELAS_RAWAT = NULL,JKN_PBI_NONPBI = "' . $jkn_pbi_nonpbi . '",
									JKN_ASAL_RUJUKAN = "' . $jkn_asal_rujukan . '",JKN_COB = "' . $jkn_cob . '",
									JKN_PENJAMIN = "' . $jkn_penjamin . '"
									WHERE PENUNJANG_ID =  "' . $penunjang_id . '"') or die(mysql_error());
				//ruang tindakan
				$nomor_order = getNomorBulanan('IPENUNJANG');
				mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID,NO_ORDER,DESKRIPSI,PEGAWAI_ID,
								NOMR,TANGGAL_ORDER,UNIT_ID,USER_ORDER,JENIS_BAYAR_ID,MCU) VALUES(
								"PNJ","IRJ","' . $irja_id . '","' . $nomor_order . '","' . $deskripsi . '",
								"596","' . $nomr . '",NOW(),"1","' . $user_name . '","' . $jenis_bayar_id . '",
								"' . $unit_id . '")') or die(mysql_error());
				$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "PNJ" AND t_ipenunjang.JNS_ORDER = "IRJ"
									AND t_ipenunjang.RAWAT_ID = "' . $irja_id . '" AND t_ipenunjang.NO_ORDER = "' . $nomor_order . '"
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
				$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
				$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
				$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
				$sql_tarif_ekg = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "103014" AND ST_AKTIF = "1"';
				$get_tarif_ekg = mysql_query($sql_tarif_ekg) or die(mysql_error());
				$dat_tarif_ekg = mysql_fetch_assoc($get_tarif_ekg);
				$tarif_ekg_id = $dat_tarif_ekg['TARIF_ID'];
				mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) VALUES("' . $penunjang_id . '","' . $tarif_ekg_id . '",1)') or die(mysql_error());
				mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_DAFTAR = NOW(),
									UNIT_PENUNJANG_ID = "52",JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
									ST_BAYAR = ' . $st_bayar . ',NO_TARIF = "' . $nomor_ekg . '",NO_SJP = "' . $no_sjp . '",
									NO_PEMBAYARAN = ' . $no_bayar_ekg . ',
									SHIFT_PENDAFTARAN = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",USER_PENDAFTARAN = "' . $user_name . '",
									ST_TPP = "1",PEGAWAI_PERIKSA_ID = NULL,
									NO_SEP = "' . $no_sep . '",TANGGAL_SEP = NOW(),
									NO_PESERTA = "' . $no_peserta . '",JKN_TGL_RUJUK = ' . fieldDate($jkn_tgl_rujuk) . ',
									JKN_NO_RUJUK = "' . $jkn_no_rujuk . '",JKN_KD_PKK = "' . $jkn_kd_pkk . '",
									JKN_NAMA_PKK = "' . $jkn_nama_pkk . '",JKN_CATATAN = "' . $jkn_catatan . '",
									JKN_DIAGNOSA = "' . $jkn_diagnosa . '",JKN_POLIKLINIK = "' . $jkn_poliklinik . '",
									JKN_KELAS_RAWAT = NULL,JKN_PBI_NONPBI = "' . $jkn_pbi_nonpbi . '",
									JKN_ASAL_RUJUKAN = "' . $jkn_asal_rujukan . '",JKN_COB = "' . $jkn_cob . '",
									JKN_PENJAMIN = "' . $jkn_penjamin . '"
									WHERE PENUNJANG_ID =  "' . $penunjang_id . '"') or die(mysql_error());
			//end mcu paket B
			}
		}
    }
}
}
?>