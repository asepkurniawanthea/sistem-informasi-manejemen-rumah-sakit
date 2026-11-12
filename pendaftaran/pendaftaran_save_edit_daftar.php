<?php
$irja_id = $_POST['irja_id'];
$st_edit = $_POST['st_edit'];
$batal = '0';
$nomor = '';
$ambil_resep = '';
if(isset($_POST['ambil_resep'])) $ambil_resep = $_POST['ambil_resep'];
$jenis_bayar_id_ls = $_POST['jenis_bayar_id_ls'];
$unit_id_ls = $_POST['unit_id_ls'];
$tipe_pegawai_id_ls = $_POST['tipe_pegawai_id_ls'];
$st_rujukan = '';

if(isset($_POST['st_batal'])){
$_err = '';
$st_batal = true;
$qry_pembayaran = 'SELECT SUM(KUANTITI) AS KUANTITI,SUM(HARGA) AS HARGA FROM (
	SELECT t_bayar_l1.RAWAT_ID,
	SUM(t_bayar_l1.KUANTITI) AS KUANTITI,
	SUM(CASE WHEN mtrg.NON_KELAS = "1" OR t_bayar_l1.KELAS_RAWAT = ""
		THEN t_bayar_l1.KUANTITI * mtr.TARIF_NON_KELAS
		ELSE	
			CASE WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "3" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_3 
				WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "2" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_2
				WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "1" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_1
				WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "UTAMA" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA
				WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "VIP" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA
				WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "UTAMA 2" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
				WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "VVIP" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
				WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "HCU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_HCU
				WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "ICU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_ICU
				WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "NICU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_NICU
				WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "PICU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_PICU
				WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "ICCU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_ICCU
				WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "PERINA" THEN t_bayar_l1.KUANTITI * mtr.TARIF_PERINA
				WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "BAYI SEHAT" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_PERINA_SEHAT
				WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "BAYI SAKIT" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_PERINA_SAKIT
			END 
	END) AS HARGA
	FROM (
			SELECT "TND" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,
			trf.TARIF_ID,trf.KUANTITI,"" AS KELAS_RAWAT
			FROM db_simrs.t_irja irj
			INNER JOIN db_simrs.t_irja_tarif trf
			ON (irj.IRJA_ID = trf.IRJA_ID
			AND trf.NO_TARIF IS NOT NULL 
			AND trf.ST_BAYAR = "Lunas")
			WHERE irj.IRJA_ID = "' . $irja_id . '"
			' . ((!in_array($jenis_bayar_id_ls,getArrNonJaminan())) ? 'AND trf.DESKRIPSI NOT IN ("Konsultasi","Karcis & Konsultasi")' : '') . '	
			UNION ALL
			SELECT "PNJ" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,
			pnjtf.TARIF_ID,pnjtf.KUANTITI,"" AS KELAS_RAWAT
			FROM db_simrs.t_irja irj
			INNER JOIN db_simrs.t_ipenunjang pnj
			ON (irj.IRJA_ID = pnj.RAWAT_ID)
			INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
			ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
			AND pnjtf.NO_TARIF IS NOT NULL
			AND pnjtf.ST_BATAL IS NULL
			AND pnjtf.ST_BAYAR = "Lunas")
			WHERE irj.IRJA_ID = "' . $irja_id . '" 
			AND (pnj.JNS_ORDER = "IRJ" OR pnj.JNS_ORDER = "HRJ" OR pnj.JNS_ORDER = "ORJ") 
			UNION ALL
			SELECT "AMB" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,
			tfamb.TARIF_ID,tfamb.KUANTITI,"" AS KELAS_RAWAT
			FROM db_simrs.t_irja irj
			INNER JOIN db_simrs.t_ambulance_tarif tfamb
			ON (irj.IRJA_ID = tfamb.RAWAT_ID
			AND tfamb.NO_TARIF IS NOT NULL 
			AND tfamb.ST_BAYAR = "Lunas")
			WHERE irj.IRJA_ID = "' . $irja_id . '" 
			AND tfamb.JNS_ORDER = "IRJ"
			UNION ALL
			SELECT "HMD" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,
			hmdtf.TARIF_ID,hmdtf.KUANTITI,"" AS KELAS_RAWAT
			FROM db_simrs.t_irja irj
			INNER JOIN db_simrs.t_hemodialisa hmd
			ON (irj.IRJA_ID = hmd.RAWAT_ID)
			INNER JOIN db_simrs.t_hemodialisa_tarif hmdtf
			ON (hmd.HEMODIALISA_ID = hmdtf.HEMODIALISA_ID
			AND hmdtf.NO_TARIF IS NOT NULL
			AND hmdtf.ST_BAYAR = "Lunas")
			WHERE irj.IRJA_ID = "' . $irja_id . '" 
			AND hmd.JNS_ORDER = "IRJ"	
			UNION ALL
			SELECT "OPR" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,
			optf.TARIF_ID,optf.KUANTITI,"3" AS KELAS_RAWAT
			FROM db_simrs.t_irja irj
			INNER JOIN db_simrs.t_operasi opr
			ON (irj.IRJA_ID = opr.RAWAT_ID
			AND opr.ST_MASUK = "1"
			AND opr.JNS_ORDER = "IRJ")
			INNER JOIN db_simrs.t_operasi_tarif optf
			ON (opr.OPERASI_ID = optf.OPERASI_ID
			AND optf.NO_TARIF IS NOT NULL
			AND optf.ST_BAYAR = "Lunas")
			WHERE irj.IRJA_ID = "' . $irja_id . '" 
	) t_bayar_l1
	INNER JOIN db_simrs.m_tarif mtr
	ON (t_bayar_l1.TARIF_ID = mtr.TARIF_ID)
	INNER JOIN db_simrs.m_tarif_group mtrg
	ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
	WHERE mtr.MCU IS NULL OR mtr.MCU = ""
	GROUP BY t_bayar_l1.PASIEN,
	t_bayar_l1.RAWAT_ID,
	mtr.TARIF_ID
				
	UNION ALL
	SELECT * FROM (
		SELECT irj.IRJA_ID AS RAWAT_ID,
		COUNT(DISTINCT fms.NO_PENGELUARAN) AS KUANTITI,
		SUM(fmsd.JUMLAH_KELUAR * fmsd.HARGA_JUAL) AS HARGA
		FROM db_simrs.t_irja irj
		INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran fms
		ON (irj.IRJA_ID = fms.RAJAL_ID AND fms.NO_PENGELUARAN IS NOT NULL
		AND fms.JENIS_PENGELUARAN = "1"
		AND fms.NO_PEMBAYARAN IS NOT NULL)
		INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran_detail fmsd
		ON (fms.FARMASI_PENGELUARAN_APOTIK_ID = fmsd.FARMASI_PENGELUARAN_ID)
		WHERE irj.IRJA_ID = "' . $irja_id . '" 
		GROUP BY irj.IRJA_ID
		) t_bayar_l0
	) t_bayar_l2';
$get_pembayaran = mysql_query($qry_pembayaran) or die(mysql_error());
$dat_pembayaran = mysql_fetch_assoc($get_pembayaran);
$bayar = $dat_pembayaran['HARGA'];
if($bayar > 0){
	$_err = $_err . 'Tidak Dapat Dibatalkan, Pasien Telah Melakukan Pembayaran (Non Jaminan) Atau Ada Tindakan Selain Konsultasi (Jaminan). \n';
	$st_batal = false;
}

if($st_batal){
	if (empty($_POST['keterangan_batal'])){
		$_err = $_err . 'Keterangan Pembatalan Harus Diisi. \n';
	}else{
		$batal = '1';
		mysql_query('UPDATE t_irja SET ST_BATAL = "1",KETERANGAN_BATAL = "' . $_POST['keterangan_batal'] . '",
					USER_PENDAFTARAN = "' . $user_name . '"
					WHERE IRJA_ID = "' . $irja_id . '"') or die(mysql_error());
		$st_edit = '1';
	}	
}
}else{
	$jenis_bayar_id = $_POST['jenis_bayar_id'];
	$no_peserta = $_POST['no_peserta'];
	
	$jkn_tgl_rujuk = '';
	$jkn_no_rujuk = '';
	$jkn_kd_pkk = '';
	$jkn_nama_pkk = '';
	$jkn_catatan = '';
	$jkn_diagnosa = '';
	$jkn_poliklinik = '';
	$jkn_kelas_rawat = '';
	$jkn_pbi_nonpbi = '';
	$jkn_asal_rujukan = '';
	$jkn_cob = '';
	$jkn_penjamin = '';
	$jkn_katarak = '';
	$jkn_suplesi = '';
	$jkn_nosep_suplesi = '';
	$jkn_nosurat_skdp = '';
	$jkn_dpjp_skdp = '';
	$jkn_nama_dpjp_skdp = '';
	$jkn_spesialis_dpjp_skdp = '';
	
	$pasien_kecelakaan = '';
	$tgl_kejadian_kecelakaan = '';
	$kd_lokasi_kecelakaan_propinsi = '';
	$kd_lokasi_kecelakaan_kota = '';
	$kd_lokasi_kecelakaan_kecamatan = '';
	$nama_lokasi_kecelakaan_propinsi = '';
	$nama_lokasi_kecelakaan_kota = '';
	$nama_lokasi_kecelakaan_kecamatan = '';
	$keterangan_kecelakaan = '';
	$kasus_polisi = '';

	if($jenis_bayar_id != '12'){ 
		$unit_id = $_POST['unit_id'];
		$pegawai_id = $_POST['pegawai_id'];
		$asal_pasien_id = $_POST['asal_pasien_id'];
		$ket_asal_pasien = $_POST['ket_asal_pasien'];
		$no_sep = $_POST['no_sep'];
		
		if(isset($_POST['pasien_kecelakaan_j'])) $pasien_kecelakaan = $_POST['pasien_kecelakaan_j'];
		if(isset($_POST['tgl_kejadian_kecelakaan_j'])) $tgl_kejadian_kecelakaan = $_POST['tgl_kejadian_kecelakaan_j'];
		if(isset($_POST['kd_lokasi_kecelakaan_propinsi_j'])){
			$arr_propinsi = explode('--',$_POST['kd_lokasi_kecelakaan_propinsi_j']);
			if(sizeof($arr_propinsi) > 1){
				$kd_lokasi_kecelakaan_propinsi = $arr_propinsi[0];
				$nama_lokasi_kecelakaan_propinsi = $arr_propinsi[1];
			}
		}
		if(isset($_POST['kd_lokasi_kecelakaan_kota_j'])){
			$arr_kota = explode('--',$_POST['kd_lokasi_kecelakaan_kota_j']);
			if(sizeof($arr_kota) > 1){
				$kd_lokasi_kecelakaan_kota = $arr_kota[0];
				$nama_lokasi_kecelakaan_kota = $arr_kota[1];
			}
		}
		if(isset($_POST['kd_lokasi_kecelakaan_kecamatan_j'])){
			$arr_kecamatan = explode('--',$_POST['kd_lokasi_kecelakaan_kecamatan_j']);
			if(sizeof($arr_kecamatan) > 1){
				$kd_lokasi_kecelakaan_kecamatan = $arr_kecamatan[0];
				$nama_lokasi_kecelakaan_kecamatan = $arr_kecamatan[1];
			}
		}
		if(isset($_POST['keterangan_kecelakaan_j'])) $keterangan_kecelakaan = $_POST['keterangan_kecelakaan_j'];
		if(isset($_POST['kasus_polisi_j'])) $kasus_polisi = $_POST['kasus_polisi_j'];
	}else{
		$jkn_unit_id = $_POST['jkn_unit_id'];
		$unit_id = $jkn_unit_id;
		
		$pegawai_id = $_POST['jkn_pegawai_id'];
		$asal_pasien_id = '2';
		$ket_asal_pasien = '-';
		$no_sep = $_POST['jkn_no_sep'];
	
		$jkn_tgl_rujuk = $_POST['jkn_tgl_rujuk'];
		$jkn_no_rujuk = $_POST['jkn_no_rujuk'];
		$jkn_asal_rujukan = $_POST['jkn_asal_rujukan'];
		$arr_pkk = explode('--',$_POST['jkn_kd_pkk']);
		if(sizeof($arr_pkk) > 1){
			$jkn_kd_pkk = $arr_pkk[0];
			$jkn_nama_pkk = $arr_pkk[1];
		}	
		$arr_diagnosa = explode('--',$_POST['jkn_diagnosa']);
		if(sizeof($arr_diagnosa) > 1){
			$jkn_diagnosa = $arr_diagnosa[0]; 
		}
		$jkn_catatan = $_POST['jkn_catatan'];
		$jkn_pbi_nonpbi = $_POST['jkn_pbi_nonpbi'];
		if(isset($_POST['jkn_cob'])) $jkn_cob = $_POST['jkn_cob'];
		if(isset($_POST['jkn_katarak'])) $jkn_katarak = $_POST['jkn_katarak'];
		if(isset($_POST['pasien_kecelakaan'])) $pasien_kecelakaan = $_POST['pasien_kecelakaan'];
		if(isset($_POST['tgl_kejadian_kecelakaan'])) $tgl_kejadian_kecelakaan = $_POST['tgl_kejadian_kecelakaan'];
		if(isset($_POST['jkn_suplesi'])) $jkn_suplesi = $_POST['jkn_suplesi'];
		if(isset($_POST['jkn_nosep_suplesi'])) $jkn_nosep_suplesi = $_POST['jkn_nosep_suplesi'];
		if(isset($_POST['kd_lokasi_kecelakaan_propinsi'])){
			$arr_propinsi = explode('--',$_POST['kd_lokasi_kecelakaan_propinsi']);
			if(sizeof($arr_propinsi) > 1){
				$kd_lokasi_kecelakaan_propinsi = $arr_propinsi[0];
				$nama_lokasi_kecelakaan_propinsi = $arr_propinsi[1];
			}
		}
		if(isset($_POST['kd_lokasi_kecelakaan_kota'])){
			$arr_kota = explode('--',$_POST['kd_lokasi_kecelakaan_kota']);
			if(sizeof($arr_kota) > 1){
				$kd_lokasi_kecelakaan_kota = $arr_kota[0];
				$nama_lokasi_kecelakaan_kota = $arr_kota[1];
			}
		}
		if(isset($_POST['kd_lokasi_kecelakaan_kecamatan'])){
			$arr_kecamatan = explode('--',$_POST['kd_lokasi_kecelakaan_kecamatan']);
			if(sizeof($arr_kecamatan) > 1){
				$kd_lokasi_kecelakaan_kecamatan = $arr_kecamatan[0];
				$nama_lokasi_kecelakaan_kecamatan = $arr_kecamatan[1];
			}
		}
		if(isset($_POST['keterangan_kecelakaan'])) $keterangan_kecelakaan = $_POST['keterangan_kecelakaan'];
		if(isset($_POST['jkn_penjamin_1'])) $jkn_penjamin_1 = $_POST['jkn_penjamin_1'];
		if(isset($_POST['jkn_penjamin_2'])) $jkn_penjamin_2 = $_POST['jkn_penjamin_2'];
		if(isset($_POST['jkn_penjamin_3'])) $jkn_penjamin_3 = $_POST['jkn_penjamin_3'];
		if(isset($_POST['jkn_penjamin_4'])) $jkn_penjamin_4 = $_POST['jkn_penjamin_4'];
		if($jkn_penjamin_1 !='') $jkn_penjamin = $jkn_penjamin . '1,';
		if($jkn_penjamin_2 !='') $jkn_penjamin = $jkn_penjamin . '2,';
		if($jkn_penjamin_3 !='') $jkn_penjamin = $jkn_penjamin . '3,';
		if($jkn_penjamin_4 !='') $jkn_penjamin = $jkn_penjamin . '4,';
		if($jkn_penjamin != '') $jkn_penjamin = substr($jkn_penjamin,0,strlen($jkn_penjamin) - 1);
		$jkn_nosurat_skdp = $_POST['jkn_nosurat_skdp'];
		$arr_dpjp = explode('--',$_POST['jkn_dpjp_skdp']);
		if(sizeof($arr_dpjp) > 0){
			$jkn_dpjp_skdp = $arr_dpjp[0];
			$jkn_nama_dpjp_skdp = $arr_dpjp[1];
		}	
		$jkn_spesialis_dpjp_skdp = $_POST['spesialisasi_dpjp'];
		if(isset($_POST['kasus_polisi'])) $kasus_polisi = $_POST['kasus_polisi'];
		
		$nama_pasien = $_POST['jkn_nama_pasien'];
		$tgl_lahir = $_POST['jkn_tgl_lahir'];
		$jns_kelamin = $_POST['jns_kelamin'];
	}

	if($jenis_bayar_id == '9' or $jenis_bayar_id == '14') $no_sep = $no_peserta;

	$p_jawab_nama = $_POST['p_jawab_nama'];
	$p_jawab_no_telp = $_POST['p_jawab_no_telp'];
	$p_jawab_alamat = $_POST['p_jawab_alamat'];
	$p_jawab_alamat_rt = $_POST['p_jawab_alamat_rt'];
	$p_jawab_alamat_rw = $_POST['p_jawab_alamat_rw'];
	$p_jawab_kelurahan_id = $_POST['p_jawab_kelurahan_id'];
	$p_jawab_kecamatan_id = $_POST['p_jawab_kecamatan_id'];
	$p_jawab_kota_id = $_POST['p_jawab_kota_id'];
	$p_jawab_propinsi_id = $_POST['p_jawab_propinsi_id'];
	$p_jawab_hubungan = $_POST['p_jawab_hubungan'];

	$st_rujukan = $_POST['st_rujukan'];
	$no_sjp = $_POST['no_sjp'];

	$_err = '';
	if (empty($unit_id))
		$_err = $_err . 'Klinik Tujuan Harus Diisi. \n';
	if (empty($pegawai_id))
		$_err = $_err . 'Dokter Harus Diisi. \n';	
	if (empty($jenis_bayar_id))
		$_err = $_err . 'Jenis Pembayaran Harus Diisi. \n';
	if (!in_array($jenis_bayar_id,getArrNonJaminan())){	
		if (empty($no_peserta))
			$_err = $_err . 'Nomor Peserta Harus Diisi. \n';	
		//if (empty($no_sep))
			//$_err = $_err . 'Nomor SEP Harus Diisi. \n';
	}		
	if (empty($asal_pasien_id))
		$_err = $_err . 'Asal Pasien Harus Diisi. \n';	
	if ($asal_pasien_id != '1'){
		if (empty($ket_asal_pasien))
		$_err = $_err . 'Keterangan Asal Pasien Harus Diisi. \n';	
	}	

    $st_save = true;
	if (empty($_err)) {
    if (!empty($_POST['irja_id'])) {
		if($st_edit == '2'){
			$st_ubah = true;
			$st_bayar = false;
			$st_dokter_beda = false;
			$st_konsul_hilang = false;
			$st_eksekutif_sama = false;
			//semua diubah
			//cek pembayaran
			if(in_array($jenis_bayar_id_ls,getArrNonJaminan())){
				$qry_pembayaran = 'SELECT SUM(KUANTITI) AS KUANTITI,SUM(HARGA) AS HARGA FROM (
					SELECT t_bayar_l1.RAWAT_ID,
					SUM(t_bayar_l1.KUANTITI) AS KUANTITI,
					SUM(CASE WHEN mtrg.NON_KELAS = "1" OR t_bayar_l1.KELAS_RAWAT = ""
						THEN t_bayar_l1.KUANTITI * mtr.TARIF_NON_KELAS
						ELSE	
							CASE WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "3" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_3 
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "2" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_2
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "1" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_1
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "UTAMA" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "VIP" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "UTAMA 2" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "VVIP" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "HCU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_HCU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "ICU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_ICU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "NICU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_NICU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "PICU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_PICU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "ICCU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_ICCU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "PERINA" THEN t_bayar_l1.KUANTITI * mtr.TARIF_PERINA
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "BAYI SEHAT" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_PERINA_SEHAT
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "BAYI SAKIT" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_PERINA_SAKIT
							END 
					END) AS HARGA
					FROM (
							SELECT "TND" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,
							trf.TARIF_ID,trf.KUANTITI,"" AS KELAS_RAWAT
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_irja_tarif trf
							ON (irj.IRJA_ID = trf.IRJA_ID
							AND trf.NO_TARIF IS NOT NULL 
							AND trf.ST_BAYAR = "Lunas")
							WHERE irj.IRJA_ID = "' . $irja_id . '"
							UNION ALL
							SELECT "PNJ" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,
							pnjtf.TARIF_ID,pnjtf.KUANTITI,"" AS KELAS_RAWAT
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_ipenunjang pnj
							ON (irj.IRJA_ID = pnj.RAWAT_ID)
							INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
							ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
							AND pnjtf.NO_TARIF IS NOT NULL
							AND pnjtf.ST_BATAL IS NULL
							AND pnjtf.ST_BAYAR = "Lunas")
							WHERE irj.IRJA_ID = "' . $irja_id . '" 
							AND (pnj.JNS_ORDER = "IRJ" OR pnj.JNS_ORDER = "HRJ" OR pnj.JNS_ORDER = "ORJ") 
							UNION ALL
							SELECT "AMB" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,
							tfamb.TARIF_ID,tfamb.KUANTITI,"" AS KELAS_RAWAT
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_ambulance_tarif tfamb
							ON (irj.IRJA_ID = tfamb.RAWAT_ID
							AND tfamb.NO_TARIF IS NOT NULL 
							AND tfamb.ST_BAYAR = "Lunas")
							WHERE irj.IRJA_ID = "' . $irja_id . '" 
							AND tfamb.JNS_ORDER = "IRJ"
							UNION ALL
							SELECT "HMD" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,
							hmdtf.TARIF_ID,hmdtf.KUANTITI,"" AS KELAS_RAWAT
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_hemodialisa hmd
							ON (irj.IRJA_ID = hmd.RAWAT_ID)
							INNER JOIN db_simrs.t_hemodialisa_tarif hmdtf
							ON (hmd.HEMODIALISA_ID = hmdtf.HEMODIALISA_ID
							AND hmdtf.NO_TARIF IS NOT NULL
							AND hmdtf.ST_BAYAR = "Lunas")
							WHERE irj.IRJA_ID = "' . $irja_id . '" 
							AND hmd.JNS_ORDER = "IRJ"	
							UNION ALL
							SELECT "OPR" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,
							optf.TARIF_ID,optf.KUANTITI,"3" AS KELAS_RAWAT
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_operasi opr
							ON (irj.IRJA_ID = opr.RAWAT_ID
							AND opr.ST_MASUK = "1"
							AND opr.JNS_ORDER = "IRJ")
							INNER JOIN db_simrs.t_operasi_tarif optf
							ON (opr.OPERASI_ID = optf.OPERASI_ID
							AND optf.NO_TARIF IS NOT NULL
							AND optf.ST_BAYAR = "Lunas")
							WHERE irj.IRJA_ID = "' . $irja_id . '" 
					) t_bayar_l1
					INNER JOIN db_simrs.m_tarif mtr
					ON (t_bayar_l1.TARIF_ID = mtr.TARIF_ID)
					INNER JOIN db_simrs.m_tarif_group mtrg
					ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
					WHERE mtr.MCU IS NULL OR mtr.MCU = ""
					GROUP BY t_bayar_l1.PASIEN,
					t_bayar_l1.RAWAT_ID,
					mtr.TARIF_ID
								
					UNION ALL
					SELECT * FROM (
						SELECT irj.IRJA_ID AS RAWAT_ID,
						COUNT(DISTINCT fms.NO_PENGELUARAN) AS KUANTITI,
						SUM(fmsd.JUMLAH_KELUAR * fmsd.HARGA_JUAL) AS HARGA
						FROM db_simrs.t_irja irj
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran fms
						ON (irj.IRJA_ID = fms.RAJAL_ID AND fms.NO_PENGELUARAN IS NOT NULL
						AND fms.JENIS_PENGELUARAN = "1"
						AND fms.NO_PEMBAYARAN IS NOT NULL)
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran_detail fmsd
						ON (fms.FARMASI_PENGELUARAN_APOTIK_ID = fmsd.FARMASI_PENGELUARAN_ID)
						WHERE irj.IRJA_ID = "' . $irja_id . '" 
						GROUP BY irj.IRJA_ID
						) t_bayar_l0
					) t_bayar_l2';
				$get_pembayaran = mysql_query($qry_pembayaran) or die(mysql_error());
				$dat_pembayaran = mysql_fetch_assoc($get_pembayaran);
				$bayar = $dat_pembayaran['HARGA'];
				if($bayar > 0) $st_bayar = true;
				if(!in_array($jenis_bayar_id,getArrNonJaminan()) and $st_bayar){
					$st_ubah = false;
				}	
				
				if($st_ubah){
					$qry_dokter = 'SELECT TIPE_PEGAWAI_ID FROM m_pegawai WHERE PEGAWAI_ID = "' . $pegawai_id . '"';
					$get_dokter = mysql_query($qry_dokter) or die(mysql_error());
					$dat_dokter = mysql_fetch_assoc($get_dokter);
					$tipe_dokter = $dat_dokter['TIPE_PEGAWAI_ID'];
					if($tipe_pegawai_id_ls != $tipe_dokter) $st_dokter_beda = true;	
					if($st_bayar and $st_dokter_beda) $st_ubah = false;
				}	
				
				if($st_ubah){
					if(!in_array($unit_id_ls,getArrUnitIGD()) 
						and !in_array($unit_id_ls,getArrIrjaNonKonsul())
							and (in_array($unit_id,getArrUnitIGD()) 
								or in_array($unit_id,getArrIrjaNonKonsul()))){
									$st_konsul_hilang = true;
									if($st_bayar and $st_konsul_hilang) $st_ubah = false;			
					}
						
				}

				if($st_ubah){
					if((in_array($unit_id_ls,getArrIrjaEksekutif()) 
						and in_array($unit_id,getArrIrjaEksekutif()))
							or (!in_array($unit_id_ls,getArrIrjaEksekutif()) 
								and !in_array($unit_id,getArrIrjaEksekutif()))){	
							$st_eksekutif_sama = true;
							if($st_bayar and $st_eksekutif_sama == false) $st_ubah = false;			
					}				
				}	
			}	
			//end cek pembayaran	
			if($st_ubah){
				$konsultasi = '1';
				if($ambil_resep == '1') $konsultasi = '';
				if(in_array($unit_id,getArrUnitIGD()) and in_array($jenis_bayar_id,getArrNonJaminan())) $konsultasi = '';
				if(in_array($unit_id,getArrIrjaNonKonsul())) $konsultasi = '';
				
				$st_save = mysql_query('UPDATE t_irja SET UNIT_ID = "' . $unit_id . '",PEGAWAI_ID = "' . $pegawai_id . '",
							JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",ASAL_PASIEN_ID = "' . $asal_pasien_id . '",
							KET_ASAL_PASIEN = "' . $ket_asal_pasien . '",NO_PESERTA = "' . $no_peserta . '",NO_SEP = "' . $no_sep . '",
							P_JAWAB_NAMA = "' . $p_jawab_nama . '",P_JAWAB_NO_TELP = "' . $p_jawab_no_telp . '",P_JAWAB_ALAMAT = "' . $p_jawab_alamat . '",P_JAWAB_ALAMAT_RT = "' . $p_jawab_alamat_rt . '",
							P_JAWAB_ALAMAT_RW = "' . $p_jawab_alamat_rw . '",P_JAWAB_KELURAHAN_ID = "' . $p_jawab_kelurahan_id . '",P_JAWAB_KECAMATAN_ID = "' . $p_jawab_kecamatan_id . '",
							P_JAWAB_KOTA_ID = "' . $p_jawab_kota_id . '",P_JAWAB_PROPINSI_ID = "' . $p_jawab_propinsi_id . '",P_JAWAB_HUBUNGAN = "' . $p_jawab_hubungan . '",
							USER_PENDAFTARAN = "' . $user_name . '",
							JKN_TGL_RUJUK = STR_TO_DATE("' . $jkn_tgl_rujuk . '","%d/%m/%Y"),JKN_NO_RUJUK = "' . $jkn_no_rujuk . '",
							JKN_KD_PKK = "' . $jkn_kd_pkk . '",JKN_NAMA_PKK = "' . $jkn_nama_pkk . '",JKN_CATATAN = "' . $jkn_catatan . '",
							JKN_DIAGNOSA = "' . $jkn_diagnosa . '",JKN_POLIKLINIK = "' . $jkn_poliklinik . '",
							JKN_PBI_NONPBI = "' . $jkn_pbi_nonpbi . '",JKN_KELAS_RAWAT = "' . $jkn_kelas_rawat . '",
							JKN_ASAL_RUJUKAN = "' . $jkn_asal_rujukan . '",JKN_COB = "' . $jkn_cob . '",JKN_PENJAMIN = "' . $jkn_penjamin . '",
							JKN_KATARAK = "' . $jkn_katarak . '",JKN_SUPLESI = "' . $jkn_suplesi . '",JKN_NO_SEP_SUPLESI = "' . $jkn_nosep_suplesi . '",JKN_NOSURAT_SKDP = "' . $jkn_nosurat_skdp . '",
							JKN_DPJP_SKDP = "' . $jkn_dpjp_skdp . '",JKN_NAMA_DPJP_SKDP = "' . $jkn_nama_dpjp_skdp . '",
							JKN_SPESIALISASI_DPJP_SKDP = "' . $jkn_spesialis_dpjp_skdp . '",KD_LOKASI_KECELAKAAN_PROPINSI = "' . $kd_lokasi_kecelakaan_propinsi . '",
							NAMA_LOKASI_KECELAKAAN_PROPINSI = "' . $nama_lokasi_kecelakaan_propinsi . '",KD_LOKASI_KECELAKAAN_KABUPATEN = "' . $kd_lokasi_kecelakaan_kota . '",
							NAMA_LOKASI_KECELAKAAN_KABUPATEN = "' . $nama_lokasi_kecelakaan_kota . '",KD_LOKASI_KECELAKAAN_KECAMATAN = "' . $kd_lokasi_kecelakaan_kecamatan . '",
							NAMA_LOKASI_KECELAKAAN_KECAMATAN = "' . $nama_lokasi_kecelakaan_kecamatan . '",TGL_KEJADIAN_KECELAKAAN = STR_TO_DATE("' . $tgl_kejadian_kecelakaan . '","%d/%m/%Y"),
							KETERANGAN_KECELAKAAN = "' . $keterangan_kecelakaan . '",KECELAKAAN = "' . $pasien_kecelakaan . '",KASUS_POLISI = "' . $kasus_polisi . '",
							AMBIL_RESEP = "' . $ambil_resep . '"
							WHERE IRJA_ID = "' . $irja_id . '"') or die(mysql_error());
							
				if($jenis_bayar_id == 12){
					if(!empty($nama_pasien) and !empty($tgl_lahir) and !empty($jns_kelamin)){
						mysql_query('UPDATE m_pasien SET JNS_KELAMIN = "' . $jns_kelamin . '",
						TGL_LAHIR = STR_TO_DATE("' . $tgl_lahir . '","%d/%m/%Y"),
						NAMA_PASIEN = "' . trim($nama_pasien) . '"
						WHERE NOMR = "' . $nomr . '"') or die(mysql_error());
					}
				}			
				
				$sql_ref_kunjungan = 'SELECT m_pegawai.NAMA_PEGAWAI,
										m_unit.NAMA_UNIT,t_irja.JENIS_BAYAR_ID
										FROM t_irja
									INNER JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
									INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
									WHERE t_irja.IRJA_ID = "' . $irja_id . '"';
				$get_ref_kunjungan = mysql_query($sql_ref_kunjungan) or die(mysql_error());
				$dat_ref_kunjungan = mysql_fetch_assoc($get_ref_kunjungan);
				$ref_dokter = $dat_ref_kunjungan['NAMA_PEGAWAI'];
				$ref_unit = $dat_ref_kunjungan['NAMA_UNIT'];
				$ref_jaminan = $dat_ref_kunjungan['JENIS_BAYAR_ID'];
				
				//sis inventori
				$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
				mysql_select_db($database_3, $connect_3) or die(mysql_error());
				
				mysql_query('UPDATE t_farmasi_apotik_pengeluaran
							SET INSTANSI_PENGIRIM = "' . $ref_unit . '",
							JAMINAN_ID = "' . $ref_jaminan . '"
							WHERE JENIS_PENGELUARAN = "1"
							AND RAJAL_ID = "' . $irja_id . '"
							AND (HEMODIALISA_ID IS NULL OR HEMODIALISA_ID = "")') or die(mysql_error());	
							
				mysql_query('UPDATE t_farmasi_apotik_pengeluaran
							SET INSTANSI_PENGIRIM = "' . $ref_unit . '-Hemodialisa' . '",
							JAMINAN_ID = "' . $ref_jaminan . '"
							WHERE JENIS_PENGELUARAN = "1"
							AND RAJAL_ID = "' . $irja_id . '"
							AND HEMODIALISA_ID IS NOT NULL 
							AND HEMODIALISA_ID <> ""') or die(mysql_error());				
				
				if($jenis_bayar_id == 12){
					if(!empty($nama_pasien) and !empty($tgl_lahir) and !empty($jns_kelamin)){
						mysql_query('UPDATE t_farmasi_apotik_pengeluaran
							SET NAMA_PELANGGAN = "' . trim($nama_pasien) . '",
							TGL_LAHIR = STR_TO_DATE("' . $tgl_lahir . '","%d/%m/%Y"),
							JNS_KELAMIN = "' . $jns_kelamin . '"
							WHERE JENIS_PENGELUARAN = "1"
							AND RAJAL_ID = "' . $irja_id . '"') or die(mysql_error());
					}
				}
							
				//
				$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
				mysql_select_db($database, $connect) or die(mysql_error());			
				
				//tindakan
				mysql_query('UPDATE t_irja_tarif SET JENIS_BAYAR_ID = "' . $jenis_bayar_id . '"
							WHERE IRJA_ID = "' . $irja_id . '"') or die(mysql_error());
				//penunjang	
				if(in_array($unit_id,getArrUnitIGD())){
					mysql_query('UPDATE t_ipenunjang_tarif 
							INNER JOIN t_ipenunjang 
							ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
							SET t_ipenunjang_tarif.JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
							t_ipenunjang.UNIT_ID = "' . $unit_id . '",
							t_ipenunjang.JENIS_BAYAR_ID = "' . $jenis_bayar_id . '"
							WHERE t_ipenunjang.RAWAT_ID = "' . $irja_id . '"
							AND (t_ipenunjang.JNS_ORDER ="IRJ" OR t_ipenunjang.JNS_ORDER ="HRJ"
							OR t_ipenunjang.JNS_ORDER ="ORJ")') or die(mysql_error());	
				}else{
					mysql_query('UPDATE t_ipenunjang_tarif 
							INNER JOIN t_ipenunjang 
							ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
							INNER JOIN t_irja
							ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
							SET t_ipenunjang_tarif.JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
							t_ipenunjang.UNIT_ID = "' . $unit_id . '",
							t_ipenunjang.JENIS_BAYAR_ID = "' . $jenis_bayar_id . '"
							WHERE t_ipenunjang.RAWAT_ID = "' . $irja_id . '"
							AND (t_ipenunjang.JNS_ORDER ="IRJ" OR t_ipenunjang.JNS_ORDER ="HRJ"
							OR t_ipenunjang.JNS_ORDER ="ORJ")
							AND DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d-%m-%Y") = DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d-%m-%Y")') or die(mysql_error());	
				}

				//operasi
				if(in_array($unit_id,getArrUnitIGD())){
					mysql_query('UPDATE t_operasi_tarif 
							INNER JOIN t_operasi 
							ON (t_operasi_tarif.OPERASI_ID = t_operasi.OPERASI_ID)
							SET t_operasi_tarif.JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
							t_operasi.UNIT_ID = "' . $unit_id . '",
							t_operasi.JENIS_BAYAR_ID = "' . $jenis_bayar_id . '"
							WHERE t_operasi.RAWAT_ID = "' . $irja_id . '"
							AND t_operasi.JNS_ORDER ="IRJ" 
							AND t_operasi.ST_MASUK ="1"') or die(mysql_error());	
				}else{
					mysql_query('UPDATE t_operasi_tarif 
							INNER JOIN t_operasi 
							ON (t_operasi_tarif.OPERASI_ID = t_operasi.OPERASI_ID)
							INNER JOIN t_irja
							ON (t_operasi.RAWAT_ID = t_irja.IRJA_ID)
							SET t_operasi_tarif.JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
							t_operasi.UNIT_ID = "' . $unit_id . '",
							t_operasi.JENIS_BAYAR_ID = "' . $jenis_bayar_id . '"
							WHERE t_operasi.RAWAT_ID = "' . $irja_id . '"
							AND t_operasi.JNS_ORDER ="IRJ" 
							AND t_operasi.ST_MASUK ="1"
							AND DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d-%m-%Y") = DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d-%m-%Y")') or die(mysql_error());	
				}

				//hemodialisa
				mysql_query('UPDATE t_hemodialisa_tarif 
						INNER JOIN t_hemodialisa 
						ON (t_hemodialisa_tarif.HEMODIALISA_ID = t_hemodialisa.HEMODIALISA_ID)
						SET t_hemodialisa_tarif.JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
						t_hemodialisa.UNIT_ID = "' . $unit_id . '",
						t_hemodialisa.JENIS_BAYAR_ID = "' . $jenis_bayar_id . '"
						WHERE t_hemodialisa.RAWAT_ID = "' . $irja_id . '"
						AND t_hemodialisa.JNS_ORDER ="IRJ"') or die(mysql_error());	
				//ambulance
				mysql_query('UPDATE t_ambulance_tarif SET JENIS_BAYAR_ID = "' . $jenis_bayar_id . '"
						WHERE RAWAT_ID = "' . $irja_id . '" AND JNS_ORDER = "IRJ"') or die(mysql_error());	
							
				if(in_array($unit_id,getArrUnitIGD()) and $unit_id == $unit_id_ls){
				//jika dr IGD ke IGD	
					
				if(in_array($jenis_bayar_id_ls,getArrRencanaJaminan()) 
						and !in_array($jenis_bayar_id,getArrRencanaJaminan())){
					$no_bayar = getNomorHarian('Kasir');
					$st_bayar = 'Lunas';
				
					if($jenis_bayar_id == '1'){
				
							mysql_query('UPDATE t_irja_tarif SET TGL_BAYAR = NOW()
								WHERE IRJA_ID = "' . $irja_id . '"
								AND NO_PEMBAYARAN IS NOT NULL') or die(mysql_error());	
						
							mysql_query('UPDATE t_ipenunjang_tarif 
								INNER JOIN t_ipenunjang 
								ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
								SET t_ipenunjang_tarif.TANGGAL_BAYAR = NOW() 
								WHERE t_ipenunjang.RAWAT_ID = "' . $irja_id . '"
								AND (t_ipenunjang.JNS_ORDER ="IRJ" OR t_ipenunjang.JNS_ORDER ="HRJ"
								OR t_ipenunjang.JNS_ORDER ="ORJ")
								AND t_ipenunjang_tarif.NO_PEMBAYARAN IS NOT NULL') or die(mysql_error());	
					
							mysql_query('UPDATE t_operasi_tarif 
								INNER JOIN t_operasi 
								ON (t_operasi_tarif.OPERASI_ID = t_operasi.OPERASI_ID)
								SET t_operasi_tarif.TGL_BAYAR = NOW()
								WHERE t_operasi.RAWAT_ID = "' . $irja_id . '"
								AND t_operasi.ST_MASUK = "1"
								AND t_operasi_tarif.NO_PEMBAYARAN IS NOT NULL') or die(mysql_error());

							mysql_query('UPDATE t_hemodialisa_tarif 
								INNER JOIN t_hemodialisa 
								ON (t_hemodialisa_tarif.HEMODIALISA_ID = t_hemodialisa.HEMODIALISA_ID)
								SET t_hemodialisa_tarif.TGL_BAYAR = NOW()
								WHERE t_hemodialisa.RAWAT_ID = "' . $irja_id . '"
								AND t_hemodialisa.JNS_ORDER ="IRJ"
								AND t_hemodialisa_tarif.NO_PEMBAYARAN IS NOT NULL') or die(mysql_error());	

							mysql_query('UPDATE t_ambulance_tarif SET TGL_BAYAR = NOW()
								WHERE RAWAT_ID = "' . $irja_id . '" 
								AND JNS_ORDER = "IRJ"
								AND NO_PEMBAYARAN IS NOT NULL') or die(mysql_error());	
				
							mysql_query('UPDATE db_inventorirs.t_farmasi_apotik_pengeluaran
								SET TANGGAL_BAYAR  = NOW()
								WHERE JENIS_PENGELUARAN = "2"
								AND RAJAL_ID = "' . $irja_id . '"
								AND NO_PEMBAYARAN IS NOT NULL') or die(mysql_error());
							
						}else{
					
							mysql_query('UPDATE t_irja_tarif SET NO_PEMBAYARAN = "' . $no_bayar . '",
								ST_BAYAR = "' . $st_bayar . '"
								WHERE IRJA_ID = "' . $irja_id . '"') or die(mysql_error());	
						
							mysql_query('UPDATE t_ipenunjang_tarif 
								INNER JOIN t_ipenunjang 
								ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
								SET t_ipenunjang_tarif.NO_PEMBAYARAN = "' . $no_bayar . '",
								t_ipenunjang_tarif.ST_BAYAR = "' . $st_bayar . '"
								WHERE t_ipenunjang.RAWAT_ID = "' . $irja_id . '"
								AND (t_ipenunjang.JNS_ORDER ="IRJ" OR t_ipenunjang.JNS_ORDER ="HRJ"
								OR t_ipenunjang.JNS_ORDER ="ORJ")') or die(mysql_error());	
					
							mysql_query('UPDATE t_operasi_tarif 
								INNER JOIN t_operasi 
								ON (t_operasi_tarif.OPERASI_ID = t_operasi.OPERASI_ID)
								SET t_operasi_tarif.NO_PEMBAYARAN = "' . $no_bayar . '",
								t_operasi_tarif.ST_BAYAR = "' . $st_bayar . '"
								WHERE t_operasi.RAWAT_ID = "' . $irja_id . '"
								AND t_operasi.ST_MASUK = "1"') or die(mysql_error());

							mysql_query('UPDATE t_hemodialisa_tarif 
								INNER JOIN t_hemodialisa 
								ON (t_hemodialisa_tarif.HEMODIALISA_ID = t_hemodialisa.HEMODIALISA_ID)
								SET t_hemodialisa_tarif.NO_PEMBAYARAN = "' . $no_bayar . '",
								t_hemodialisa_tarif.ST_BAYAR = "' . $st_bayar . '"
								WHERE t_hemodialisa.RAWAT_ID = "' . $irja_id . '"
								AND t_hemodialisa.JNS_ORDER ="IRJ"') or die(mysql_error());	

							mysql_query('UPDATE t_ambulance_tarif SET NO_PEMBAYARAN = "' . $no_bayar . '",
								ST_BAYAR = "' . $st_bayar . '"
								WHERE RAWAT_ID = "' . $irja_id . '" 
								AND JNS_ORDER = "IRJ"') or die(mysql_error());				
						}		
					}
				}else{
					
					if(!in_array($jenis_bayar_id_ls,getArrNonJaminan())
						or ($st_dokter_beda 
							and $st_konsul_hilang 
								and $st_eksekutif_sama == false)){
								
								mysql_query('DELETE t_irja_tarif.* FROM t_irja_tarif
									INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
									WHERE t_irja_tarif.IRJA_ID = "' . $irja_id . '" 
									AND t_irja_tarif.DESKRIPSI = "Karcis & Konsultasi"
									AND m_tarif.KODE_TARIF IN ("92001","01001","09001","09002","93002",
															"93001","93003","93004","02002","02001",
															"02003","02004","02005")') or die(mysql_error());
								$no_bayar = 'NULL';
								$st_bayar = 'NULL';
								if(!in_array($jenis_bayar_id,getArrNonJaminan())){
									$no_bayar = '"' . getNomorHarian('Kasir') . '"';
									$st_bayar = '"Lunas"';
								}
								$nomor = getNomorHarian('Tarif');
								$deskripsi = 'Karcis & Konsultasi';
					
								//karcis	
								if($st_rujukan != '1'){
									if(in_array($unit_id,getArrIrjaEksekutif())){
										$kode_tarif = '92001';
									}else{
										$kode_tarif = '01001';
									}
										
									$sql_tarif_karcis = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tarif . '" AND ST_AKTIF = "1"';
									$get_tarif_karcis = mysql_query($sql_tarif_karcis) or die(mysql_error());
									$dat_tarif_karcis = mysql_fetch_assoc($get_tarif_karcis);
									$tarif_karcis_id = $dat_tarif_karcis['TARIF_ID'];
									
									mysql_query('INSERT INTO t_irja_tarif(IRJA_ID,TGL_TARIF,TARIF_ID,KUANTITI,NO_TARIF,NO_PEMBAYARAN,
											DESKRIPSI,ST_BAYAR,JENIS_BAYAR_ID,USER_PENDAFTARAN,ST_PRINT)
											VALUES("' . $irja_id . '",NOW(),"' . $tarif_karcis_id . '",1,"' . $nomor . '",
											' . $no_bayar . ',"Karcis & Konsultasi",' . $st_bayar . ',"' . $jenis_bayar_id . '",
											"' . $user_name . '",NULL)') or die(mysql_error());	
											
								}			
						
								//konsultasi
								if($konsultasi == '1'){
									$sql_dokter_tipe = 'SELECT TIPE_PEGAWAI_ID FROM m_pegawai WHERE PEGAWAI_ID = "' . $pegawai_id . '"';
									$get_dokter_tipe = mysql_query($sql_dokter_tipe) or die(mysql_error());
									$dat_dokter_tipe = mysql_fetch_assoc($get_dokter_tipe);
									$dokter_tipe = $dat_dokter_tipe['TIPE_PEGAWAI_ID']; 
									if(in_array($unit_id,getArrUnitIGD())){
										if($dokter_tipe == '2'){
											$kode_tarif_konsul = '09001';
										}else{
											$kode_tarif_konsul = '09002';
										}
									}else if(in_array($unit_id,getArrIrjaEksekutif())){
										if($dokter_tipe == '1'){
											$kode_tarif_konsul = '93002';
										}else if($dokter_tipe == '2'){
											$kode_tarif_konsul = '93001';
										}else if($dokter_tipe == '3'){
											$kode_tarif_konsul = '93003';
										}else if($dokter_tipe == '4'){
											$kode_tarif_konsul = '93004';
										}else if($dokter_tipe == '18'){
											$kode_tarif_konsul = '93005';	
										}
									}else{
										if($dokter_tipe == '1'){
											$kode_tarif_konsul = '02002';
										}else if($dokter_tipe == '2'){
											$kode_tarif_konsul = '02001';
										}else if($dokter_tipe == '3'){
											$kode_tarif_konsul = '02003';
										}else if($dokter_tipe == '4'){
											$kode_tarif_konsul = '02004';
										}else if($dokter_tipe == '9'){
											$kode_tarif_konsul = '02005';
										}else if($dokter_tipe == '18'){
											$kode_tarif_konsul = '93005';	
										}
									}
										
									$sql_tarif_konsul = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tarif_konsul . '" AND ST_AKTIF = "1"';
									$get_tarif_konsul = mysql_query($sql_tarif_konsul) or die(mysql_error());
									$dat_tarif_konsul = mysql_fetch_assoc($get_tarif_konsul);
									$tarif_konsul_id = $dat_tarif_konsul['TARIF_ID'];
									mysql_query('INSERT INTO t_irja_tarif(IRJA_ID,TGL_TARIF,TARIF_ID,KUANTITI,NO_TARIF,NO_PEMBAYARAN,
											DESKRIPSI,ST_BAYAR,JENIS_BAYAR_ID,USER_PENDAFTARAN,ST_PRINT)
											VALUES("' . $irja_id . '",NOW(),"' . $tarif_konsul_id . '",1,"' . $nomor . '",
											' . $no_bayar . ',"' . $deskripsi . '",' . $st_bayar . ',"' . $jenis_bayar_id . '",
											"' . $user_name . '",NULL)') or die(mysql_error());	
								}
					}		
				}	
							
			if($unit_id != $unit_id_ls){
				$connect_4 = mysql_connect($hostname_4, $username_4, $password_4) or die(mysql_error());
				mysql_select_db($database_4, $connect_4) or die(mysql_error());
				
				$no_antrian = 1;
				$qry_antrian = 'SELECT MAX_NOMOR FROM t_max_nomor 
							WHERE HEADER = "Antrian-' . $unit_id . '"
							AND SITE_ID = "1"
							AND TANGGAL = CURRENT_DATE()';
				$get_antrian = mysql_query($qry_antrian) or die(mysql_error());
				if(mysql_num_rows($get_antrian) > 0){	
					mysql_query('UPDATE t_max_nomor SET MAX_NOMOR = MAX_NOMOR + 1 
							WHERE HEADER = "Antrian-' . $unit_id . '"
							AND SITE_ID = "1"
							AND TANGGAL = CURRENT_DATE()') or die(mysql_error());
					$dat_antrian = mysql_fetch_assoc($get_antrian);	
					$no_antrian =  $dat_antrian['MAX_NOMOR'] + 1;						
				}else{
					mysql_query('INSERT INTO t_max_nomor (MAX_NOMOR,HEADER,TANGGAL,SITE_ID) 
							VALUES(1,"Antrian-' . $unit_id . '",CURRENT_DATE(),"1")') or die(mysql_error());
				}
				
				$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
				mysql_select_db($database, $connect) or die(mysql_error());	
				
				mysql_query('UPDATE t_irja SET ONLINE_ID = "' . $no_antrian . '" 
					WHERE IRJA_ID = "' . $irja_id . '"') or die(mysql_error());
			}	
			
			}else{
				?>
				<script language="JavaScript" >
				alert('Tidak Dapat Diubah, Pasien Telah Melakukan Pembayaran. \n Silahkan Batalkan Dahulu Di Kasir.');
		        </script> 
			<?php
			}
			//end semua diubah	
		}else if($st_edit == '1'){
			$st_save = mysql_query('UPDATE t_irja SET NO_PESERTA = "' . $no_peserta . '",NO_SEP = "' . $no_sep . '",
							P_JAWAB_NAMA = "' . $p_jawab_nama . '",P_JAWAB_NO_TELP = "' . $p_jawab_no_telp . '",P_JAWAB_ALAMAT = "' . $p_jawab_alamat . '",P_JAWAB_ALAMAT_RT = "' . $p_jawab_alamat_rt . '",
							P_JAWAB_ALAMAT_RW = "' . $p_jawab_alamat_rw . '",P_JAWAB_KELURAHAN_ID = "' . $p_jawab_kelurahan_id . '",P_JAWAB_KECAMATAN_ID = "' . $p_jawab_kecamatan_id . '",
							P_JAWAB_KOTA_ID = "' . $p_jawab_kota_id . '",P_JAWAB_PROPINSI_ID = "' . $p_jawab_propinsi_id . '",P_JAWAB_HUBUNGAN = "' . $p_jawab_hubungan . '",
							USER_PENDAFTARAN = "' . $user_name . '",
							JKN_TGL_RUJUK = STR_TO_DATE("' . $jkn_tgl_rujuk . '","%d/%m/%Y"),JKN_NO_RUJUK = "' . $jkn_no_rujuk . '",
							JKN_KD_PKK = "' . $jkn_kd_pkk . '",JKN_NAMA_PKK = "' . $jkn_nama_pkk . '",JKN_CATATAN = "' . $jkn_catatan . '",
							JKN_DIAGNOSA = "' . $jkn_diagnosa . '",JKN_POLIKLINIK = "' . $jkn_poliklinik . '",
							JKN_PBI_NONPBI = "' . $jkn_pbi_nonpbi . '",JKN_KELAS_RAWAT = "' . $jkn_kelas_rawat . '",
							JKN_ASAL_RUJUKAN = "' . $jkn_asal_rujukan . '",JKN_COB = "' . $jkn_cob . '",JKN_PENJAMIN = "' . $jkn_penjamin . '",
							JKN_KATARAK = "' . $jkn_katarak . '",JKN_SUPLESI = "' . $jkn_suplesi . '",JKN_NO_SEP_SUPLESI = "' . $jkn_nosep_suplesi . '",JKN_NOSURAT_SKDP = "' . $jkn_nosurat_skdp . '",
							JKN_DPJP_SKDP = "' . $jkn_dpjp_skdp . '",JKN_NAMA_DPJP_SKDP = "' . $jkn_nama_dpjp_skdp . '",
							JKN_SPESIALISASI_DPJP_SKDP = "' . $jkn_spesialis_dpjp_skdp . '",KD_LOKASI_KECELAKAAN_PROPINSI = "' . $kd_lokasi_kecelakaan_propinsi . '",
							NAMA_LOKASI_KECELAKAAN_PROPINSI = "' . $nama_lokasi_kecelakaan_propinsi . '",KD_LOKASI_KECELAKAAN_KABUPATEN = "' . $kd_lokasi_kecelakaan_kota . '",
							NAMA_LOKASI_KECELAKAAN_KABUPATEN = "' . $nama_lokasi_kecelakaan_kota . '",KD_LOKASI_KECELAKAAN_KECAMATAN = "' . $kd_lokasi_kecelakaan_kecamatan . '",
							NAMA_LOKASI_KECELAKAAN_KECAMATAN = "' . $nama_lokasi_kecelakaan_kecamatan . '",TGL_KEJADIAN_KECELAKAAN = STR_TO_DATE("' . $tgl_kejadian_kecelakaan . '","%d/%m/%Y"),
							KETERANGAN_KECELAKAAN = "' . $keterangan_kecelakaan . '",KECELAKAAN = "' . $pasien_kecelakaan . '"
							WHERE IRJA_ID = "' . $irja_id . '"') or die(mysql_error());
			if($jenis_bayar_id == 12){
				if(!empty($nama_pasien) and !empty($tgl_lahir) and !empty($jns_kelamin)){
					mysql_query('UPDATE m_pasien SET JNS_KELAMIN = "' . $jns_kelamin . '",
						TGL_LAHIR = STR_TO_DATE("' . $tgl_lahir . '","%d/%m/%Y"),
						NAMA_PASIEN = "' . $nama_pasien . '"
						WHERE NOMR = "' . $nomr . '"') or die(mysql_error());
				}
			}	
	
		}else if($st_edit == '3'){
			$sql_nomor = 'SELECT t_irja_tarif.NO_TARIF FROM t_irja_tarif
					INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
					WHERE t_irja_tarif.IRJA_ID = "' . $irja_id . '" 
					AND m_tarif.KODE_TARIF IN ("92001","01001","09001","09002","93002",
												"93001","93003","93004","02002","02001",
												"02003","02004","02005")';
			$get_nomor = mysql_query($sql_nomor) or die(mysql_error());
			$dat_nomor = mysql_fetch_assoc($get_nomor);
			$nomor = $dat_nomor['NO_TARIF']; 	
       }
    }
 }
}
if (empty($_err)) {
	$link = 'pendaftaranlistkunjungan';
        ?>
        <script language="JavaScript" >
		<?php if($st_edit != '1'){ ?>
		var p_sjp = 'no';
		var p_resep = 'no';
		var p_sep = 'no';
		if(confirm('Print Juga SJP?')){
		 p_sjp = 'yes';
		}
		<?php if($jenis_bayar_id == '12' and !empty($no_sep)){ ?>
		if(confirm('Print Juga SEP?')){
		 p_sep = 'yes';
		}
		<?php } ?>
		
		window.open('http://localhost/nsimrs_print/print_pembayaran_karcis.php?idx=<?php echo $irja_id; ?>&no=<?php echo $nomor; ?>&sjp=' + p_sjp + '&resep=' + p_resep + '&sep=' + p_sep,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
		<?php } ?>
		alert('Simpan Perubahan Data Kunjungan Berhasil.');
		window.location = "index.php?link=<?php echo md5($link); ?>";
        </script> 
        <?php
} else {
    $msg_info = $_err;
}
?>