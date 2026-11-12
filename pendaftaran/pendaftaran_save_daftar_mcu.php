<?php
	if (empty($unit_id))
		$_err = $_err . 'Paket MCU Harus Diisi. \n';
	if (empty($pegawai_id))
		$_err = $_err . 'Dokter Harus Diisi. \n';
	if (empty($jenis_bayar_id))
		$_err = $_err . 'Jenis Pembayaran Harus Diisi. \n';
	if (!in_array($jenis_bayar_id,getArrNonJaminan())){	
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
	
			$no_antrian = 1;
			$q_antrian = 'SELECT COUNT(IRJA_ID) AS JML_ANTRIAN,
				MAX(ONLINE_ID) AS NO_ANTRIAN
				FROM t_irja
				WHERE UNIT_ID = "61"
				AND TANGGAL_DAFTAR = CURRENT_DATE()
				AND NO_PENDAFTARAN IS NOT NULL';
			$g_antrian = mysql_query($q_antrian) or die(mysql_error());
			$d_antrian = mysql_fetch_assoc($g_antrian);
			if($d_antrian['NO_ANTRIAN'] != ''){
				$no_antrian = $d_antrian['NO_ANTRIAN'] + 1;
			}		
			
			mysql_query('UPDATE t_irja SET UNIT_ID = "61",PEGAWAI_ID = "' . $pegawai_id . '",
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
						KASUS_POLISI = "' . $kasus_polisi . '",MCU = "' . $unit_id . '",
						ONLINE_ID = "' . $no_antrian . '"
						WHERE IRJA_ID = "' . $irja_id . '"') or die(mysql_error());
				//edoc rekam medic
				/*include('edoc_rekammedik/edoc_main.php');
				create_pdf_identitas($irja_id,'RJ');
				create_pdf_ringkasan_kunjungan_rawat_jalan($irja_id);*/
				//		
			
			if($ambil_resep != '1'){
				 $arr_mcu_s = '"00000",';
				 $sql = 'SELECT KODE_TARIF FROM m_tarif WHERE TARIF_ID = "' . $unit_id . '"';
				 $get = mysql_query($sql) or die(mysql_error());
				 $dat = mysql_fetch_assoc($get);
				 $arr_mcu_s .= '"' . $dat['KODE_TARIF'] . '",';
				 $sql = 'SELECT KODE_TARIF FROM m_tarif WHERE KODE_TARIF LIKE "MCU' . $dat['KODE_TARIF'] . '%"';
				 $get = mysql_query($sql) or die(mysql_error());
				 while($dat = mysql_fetch_array($get)){
					$arr_mcu_s .= '"' . $dat['KODE_TARIF'] . '",'; 
				 }
				 $arr_mcu_s = substr($arr_mcu_s,0,strlen($arr_mcu_s) - 1);
			}else{
				$arr_mcu_s = '"01001"';
			}	
			
			$arr_tindakan = array();
			$arr_laboratorium = array();	
			$arr_radiologi = array();
			$arr_ekgusg = array();		
			
			$get_tarif = mysql_query('SELECT m_tarif.TARIF_ID,m_tarif.KODE_TARIF,m_tarif_group.LABORATORIUM,
						m_tarif_group.LABORATORIUM_CITO,m_tarif_group.RADIOLOGI,m_tarif_group.RADIOLOGI_CITO,
						m_tarif.UNIT_ID,m_tarif.NAMA_TARIF
						FROM m_tarif
						INNER JOIN m_tarif_group 
						ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						WHERE m_tarif.KODE_TARIF IN (' . $arr_mcu_s . ') 
						AND (m_tarif.MCU = "1" OR m_tarif.ST_AKTIF = "1")') or die(mysql_error());		
			
			while($dat_tarif = mysql_fetch_array($get_tarif)){
				if($dat_tarif['LABORATORIUM'] == '' and $dat_tarif['LABORATORIUM_CITO'] == ''
					and $dat_tarif['RADIOLOGI'] == '' and $dat_tarif['RADIOLOGI_CITO'] == ''
					and ($dat_tarif['UNIT_ID'] == '' or $dat_tarif['UNIT_ID'] == '0')) array_push($arr_tindakan,$dat_tarif['TARIF_ID']);
					
				if($dat_tarif['LABORATORIUM'] == '1' or $dat_tarif['LABORATORIUM_CITO'] == '1' 
					or $dat_tarif['UNIT_ID'] == '45') array_push($arr_laboratorium,$dat_tarif['TARIF_ID']);
				if($dat_tarif['RADIOLOGI'] == '1' or $dat_tarif['RADIOLOGI_CITO'] == '1'
					or $dat_tarif['UNIT_ID'] == '17') array_push($arr_radiologi,$dat_tarif['TARIF_ID']);
				if($dat_tarif['UNIT_ID'] == '52') array_push($arr_ekgusg,$dat_tarif['TARIF_ID']); 	
			}
			
			$no_bayar = 'NULL';
			$st_bayar = 'NULL';
			if(!in_array($jenis_bayar_id,getArrNonJaminan())){
				$no_bayar = '"' . getNomorHarian('Kasir') . '"';
				$st_bayar = '"Lunas"';
			}
			$nomor = getNomorHarian('Tarif');
			$tgl_tarif = 'STR_TO_DATE("' . getDatetimeSkr() . '","%d/%m/%Y %H:%i:%s")';	
			$nomor_order = getNomorBulanan('IPENUNJANG');
			
			if(sizeof($arr_tindakan) > 0){
				foreach($arr_tindakan as $tarif){
					$kuantiti = '0';
					if($tarif == $unit_id) $kuantiti = '1';
					mysql_query('INSERT INTO t_irja_tarif(IRJA_ID,TGL_TARIF,TARIF_ID,KUANTITI,NO_TARIF,NO_PEMBAYARAN,
							DESKRIPSI,ST_BAYAR,JENIS_BAYAR_ID,USER_PENDAFTARAN,ST_PRINT)
							VALUES("' . $irja_id . '",' . $tgl_tarif . ',"' . $tarif . '","' . $kuantiti . '","' . $nomor . '", ' . $no_bayar . ',
							"Paket MCU",' . $st_bayar . ',"' . $jenis_bayar_id . '","' . $user_name . '",NULL)') or die(mysql_error());	
				}
			}	
			
			if(sizeof($arr_laboratorium) > 0){
				mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID,NO_ORDER,DESKRIPSI,PEGAWAI_ID,
								NOMR,TANGGAL_ORDER,UNIT_ID,USER_ORDER,JENIS_BAYAR_ID,MCU) VALUES(
								"LAB","IRJ","' . $irja_id . '","' . $nomor_order . '","Paket MCU",
								"' . $pegawai_id . '","' . $nomr . '",' . $tgl_tarif . ',"61","' . $user_name . '",
								"' . $jenis_bayar_id . '","' . $unit_id . '")') or die(mysql_error());
				$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "LAB" 
									AND t_ipenunjang.JNS_ORDER = "IRJ"
									AND t_ipenunjang.RAWAT_ID = "' . $irja_id . '" 
									AND t_ipenunjang.NO_ORDER = "' . $nomor_order . '"
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
				$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
				$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
				$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
								
				foreach($arr_laboratorium as $tarif){
					mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI,ST_PRINT) 
						VALUES("' . $penunjang_id . '","' . $tarif . '",0,NULL)') or die(mysql_error());
				}
				
				mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_DAFTAR = ' . $tgl_tarif . ',
									UNIT_PENUNJANG_ID = "45",JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
									ST_BAYAR = ' . $st_bayar . ',NO_TARIF = "' . $nomor . '",NO_SJP = "' . $no_sjp . '",
									NO_PEMBAYARAN = ' . $no_bayar . ',
									SHIFT_PENDAFTARAN = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",USER_PENDAFTARAN = "' . $user_name . '",
									ST_TPP = "1",PEGAWAI_PERIKSA_ID = NULL,NO_SEP = "' . $no_sep . '",TANGGAL_SEP = ' . $tgl_tarif . ',
									NO_PESERTA = "' . $no_peserta . '",JKN_TGL_RUJUK = ' . fieldDate($jkn_tgl_rujuk) . ',
									JKN_NO_RUJUK = "' . $jkn_no_rujuk . '",JKN_KD_PKK = "' . $jkn_kd_pkk . '",
									JKN_NAMA_PKK = "' . $jkn_nama_pkk . '",JKN_CATATAN = "' . $jkn_catatan . '",
									JKN_DIAGNOSA = "' . $jkn_diagnosa . '",JKN_POLIKLINIK = "' . $jkn_poliklinik . '",
									JKN_KELAS_RAWAT = NULL,JKN_PBI_NONPBI = "' . $jkn_pbi_nonpbi . '",
									JKN_ASAL_RUJUKAN = "' . $jkn_asal_rujukan . '",JKN_COB = "' . $jkn_cob . '",
									JKN_PENJAMIN = "' . $jkn_penjamin . '",JKN_KATARAK = "' . $jkn_katarak . '",
									JKN_NOSURAT_SKDP = "' . $jkn_nosurat_skdp . '",JKN_DPJP_SKDP = "' . $jkn_dpjp_skdp . '",
									JKN_NAMA_DPJP_SKDP = "' . $jkn_nama_dpjp_skdp . '",JKN_SPESIALISASI_DPJP_SKDP = "' . $jkn_spesialis_dpjp_skdp . '"
									WHERE PENUNJANG_ID =  "' . $penunjang_id . '"') or die(mysql_error());
									
				include('lis/simrs2lis.php');
				lis_create_order($irja_id,$nomor_order,'IRJ');						
			}
			
			if(sizeof($arr_radiologi) > 0){
				mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID,NO_ORDER,DESKRIPSI,PEGAWAI_ID,
								NOMR,TANGGAL_ORDER,UNIT_ID,USER_ORDER,JENIS_BAYAR_ID,MCU) VALUES(
								"RAD","IRJ","' . $irja_id . '","' . $nomor_order . '","Paket MCU",
								"' . $pegawai_id . '","' . $nomr . '",' . $tgl_tarif . ',"61","' . $user_name . '",
								"' . $jenis_bayar_id . '","' . $unit_id . '")') or die(mysql_error());
				$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "RAD" 
									AND t_ipenunjang.JNS_ORDER = "IRJ"
									AND t_ipenunjang.RAWAT_ID = "' . $irja_id . '" 
									AND t_ipenunjang.NO_ORDER = "' . $nomor_order . '"
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
				$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
				$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
				$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
								
				foreach($arr_radiologi as $tarif){
					mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI,ST_PRINT) 
						VALUES("' . $penunjang_id . '","' . $tarif . '",0,NULL)') or die(mysql_error());
				}
				mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_DAFTAR = ' . $tgl_tarif . ',
									UNIT_PENUNJANG_ID = "17",JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
									ST_BAYAR = ' . $st_bayar . ',NO_TARIF = "' . $nomor . '",NO_SJP = "' . $no_sjp . '",
									NO_PEMBAYARAN = ' . $no_bayar . ',
									SHIFT_PENDAFTARAN = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",USER_PENDAFTARAN = "' . $user_name . '",
									ST_TPP = "1",PEGAWAI_PERIKSA_ID = NULL,NO_SEP = "' . $no_sep . '",TANGGAL_SEP = ' . $tgl_tarif . ',
									NO_PESERTA = "' . $no_peserta . '",JKN_TGL_RUJUK = ' . fieldDate($jkn_tgl_rujuk) . ',
									JKN_NO_RUJUK = "' . $jkn_no_rujuk . '",JKN_KD_PKK = "' . $jkn_kd_pkk . '",
									JKN_NAMA_PKK = "' . $jkn_nama_pkk . '",JKN_CATATAN = "' . $jkn_catatan . '",
									JKN_DIAGNOSA = "' . $jkn_diagnosa . '",JKN_POLIKLINIK = "' . $jkn_poliklinik . '",
									JKN_KELAS_RAWAT = NULL,JKN_PBI_NONPBI = "' . $jkn_pbi_nonpbi . '",
									JKN_ASAL_RUJUKAN = "' . $jkn_asal_rujukan . '",JKN_COB = "' . $jkn_cob . '",
									JKN_PENJAMIN = "' . $jkn_penjamin . '",JKN_KATARAK = "' . $jkn_katarak . '",
									JKN_NOSURAT_SKDP = "' . $jkn_nosurat_skdp . '",JKN_DPJP_SKDP = "' . $jkn_dpjp_skdp . '",
									JKN_NAMA_DPJP_SKDP = "' . $jkn_nama_dpjp_skdp . '",JKN_SPESIALISASI_DPJP_SKDP = "' . $jkn_spesialis_dpjp_skdp . '"
									WHERE PENUNJANG_ID =  "' . $penunjang_id . '"') or die(mysql_error());
			}
			
			if(sizeof($arr_ekgusg) > 0){
				mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID,NO_ORDER,DESKRIPSI,PEGAWAI_ID,
								NOMR,TANGGAL_ORDER,UNIT_ID,USER_ORDER,JENIS_BAYAR_ID,MCU) VALUES(
								"EKG","IRJ","' . $irja_id . '","' . $nomor_order . '","Paket MCU",
								"' . $pegawai_id . '","' . $nomr . '",' . $tgl_tarif . ',"61","' . $user_name . '",
								"' . $jenis_bayar_id . '","' . $unit_id . '")') or die(mysql_error());
				$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "EKG" 
									AND t_ipenunjang.JNS_ORDER = "IRJ"
									AND t_ipenunjang.RAWAT_ID = "' . $irja_id . '" 
									AND t_ipenunjang.NO_ORDER = "' . $nomor_order . '"
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
				$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
				$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
				$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
								
				foreach($arr_ekgusg as $tarif){
					mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI,ST_PRINT) 
						VALUES("' . $penunjang_id . '","' . $tarif . '",0,NULL)') or die(mysql_error());
				}
				mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_DAFTAR = ' . $tgl_tarif . ',
									UNIT_PENUNJANG_ID = "52",JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
									ST_BAYAR = ' . $st_bayar . ',NO_TARIF = "' . $nomor . '",NO_SJP = "' . $no_sjp . '",
									NO_PEMBAYARAN = ' . $no_bayar . ',
									SHIFT_PENDAFTARAN = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",USER_PENDAFTARAN = "' . $user_name . '",
									ST_TPP = "1",PEGAWAI_PERIKSA_ID = NULL,NO_SEP = "' . $no_sep . '",TANGGAL_SEP = ' . $tgl_tarif . ',
									NO_PESERTA = "' . $no_peserta . '",JKN_TGL_RUJUK = ' . fieldDate($jkn_tgl_rujuk) . ',
									JKN_NO_RUJUK = "' . $jkn_no_rujuk . '",JKN_KD_PKK = "' . $jkn_kd_pkk . '",
									JKN_NAMA_PKK = "' . $jkn_nama_pkk . '",JKN_CATATAN = "' . $jkn_catatan . '",
									JKN_DIAGNOSA = "' . $jkn_diagnosa . '",JKN_POLIKLINIK = "' . $jkn_poliklinik . '",
									JKN_KELAS_RAWAT = NULL,JKN_PBI_NONPBI = "' . $jkn_pbi_nonpbi . '",
									JKN_ASAL_RUJUKAN = "' . $jkn_asal_rujukan . '",JKN_COB = "' . $jkn_cob . '",
									JKN_PENJAMIN = "' . $jkn_penjamin . '",JKN_KATARAK = "' . $jkn_katarak . '",
									JKN_NOSURAT_SKDP = "' . $jkn_nosurat_skdp . '",JKN_DPJP_SKDP = "' . $jkn_dpjp_skdp . '",
									JKN_NAMA_DPJP_SKDP = "' . $jkn_nama_dpjp_skdp . '",JKN_SPESIALISASI_DPJP_SKDP = "' . $jkn_spesialis_dpjp_skdp . '"
									WHERE PENUNJANG_ID =  "' . $penunjang_id . '"') or die(mysql_error());
			}
		
    }
}
}
?>