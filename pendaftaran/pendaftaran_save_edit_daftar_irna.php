<?php
$irna_id = $_POST['irna_id'];
$batal = '0';
$st_edit = $_POST['st_edit'];
$nomr = $_POST['nomr'];

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
			SELECT "TND" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,
			trf.TARIF_ID,trf.KUANTITI,trf.KELAS_RAWAT
			FROM db_simrs.t_irna irn
			INNER JOIN db_simrs.t_irna_tarif trf
			ON (irn.IRNA_ID = trf.IRNA_ID
			AND trf.NO_TARIF IS NOT NULL 
			AND trf.ST_BAYAR = "Lunas")
			WHERE irn.IRNA_ID = "' . $irna_id . '" 
			UNION ALL
			SELECT "PNJ" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,
			pnjtf.TARIF_ID,pnjtf.KUANTITI,"" AS KELAS_RAWAT
			FROM db_simrs.t_irna irn
			INNER JOIN db_simrs.t_ipenunjang pnj
			ON (irn.IRNA_ID = pnj.RAWAT_ID)
			INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
			ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
			AND pnjtf.NO_TARIF IS NOT NULL
			AND pnjtf.ST_BATAL IS NULL
			AND pnjtf.ST_BAYAR = "Lunas")
			WHERE irn.IRNA_ID = "' . $irna_id . '" 
			AND (pnj.JNS_ORDER = "IRN" OR pnj.JNS_ORDER = "HRI" OR pnj.JNS_ORDER = "ORI")
			UNION ALL
			SELECT "AMB" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,
			tfamb.TARIF_ID,tfamb.KUANTITI,"" AS KELAS_RAWAT
			FROM db_simrs.t_irna irn
			INNER JOIN db_simrs.t_ambulance_tarif tfamb
			ON (irn.IRNA_ID = tfamb.RAWAT_ID
			AND tfamb.NO_TARIF IS NOT NULL 
			AND tfamb.ST_BAYAR = "Lunas")
			WHERE irn.IRNA_ID = "' . $irna_id . '" 
			AND tfamb.JNS_ORDER = "IRN"
			UNION ALL
			SELECT "HMD" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,
			hmdtf.TARIF_ID,hmdtf.KUANTITI,"" AS KELAS_RAWAT
			FROM db_simrs.t_irna irn
			INNER JOIN db_simrs.t_hemodialisa hmd
			ON (irn.IRNA_ID = hmd.RAWAT_ID)
			INNER JOIN db_simrs.t_hemodialisa_tarif hmdtf
			ON (hmd.HEMODIALISA_ID = hmdtf.HEMODIALISA_ID
			AND hmdtf.NO_TARIF IS NOT NULL
			AND hmdtf.ST_BAYAR = "Lunas")
			WHERE irn.IRNA_ID = "' . $irna_id . '" 
			AND hmd.JNS_ORDER = "IRN"
			UNION ALL
			SELECT "OPR" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,
			optf.TARIF_ID,optf.KUANTITI,optf.KELAS_RAWAT
			FROM db_simrs.t_irna irn
			INNER JOIN db_simrs.t_operasi opr
			ON (irn.IRNA_ID = opr.RAWAT_ID)
			INNER JOIN db_simrs.t_operasi_tarif optf
			ON (opr.OPERASI_ID = optf.OPERASI_ID
			AND optf.NO_TARIF IS NOT NULL
			AND optf.ST_BAYAR = "Lunas"
			AND (opr.ST_MASUK = "2" OR opr.JNS_ORDER = "IRN"))
			WHERE irn.IRNA_ID = "' . $irna_id . '" 
			-- end rawat inap
		) t_bayar_l1
		INNER JOIN db_simrs.m_tarif mtr
		ON (t_bayar_l1.TARIF_ID = mtr.TARIF_ID)
		INNER JOIN db_simrs.m_tarif_group mtrg
		ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
		GROUP BY t_bayar_l1.PASIEN,
		t_bayar_l1.RAWAT_ID,
		mtr.TARIF_ID
					
		-- farmasi rawat inap
		UNION ALL
		SELECT * FROM (
			SELECT irn.IRNA_ID AS RAWAT_ID,
			COUNT(DISTINCT fms.NO_PENGELUARAN) AS KUANTITI,
			SUM(fmsd.JUMLAH_KELUAR * fmsd.HARGA_JUAL) AS HARGA
			FROM db_simrs.t_irna irn
			INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran fms
			ON (irn.IRNA_ID = fms.RANAP_ID AND fms.NO_PENGELUARAN IS NOT NULL
			AND fms.JENIS_PENGELUARAN = "2"
			AND fms.NO_PEMBAYARAN IS NOT NULL)
			INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran_detail fmsd
			ON (fms.FARMASI_PENGELUARAN_APOTIK_ID = fmsd.FARMASI_PENGELUARAN_ID)
			WHERE irn.IRNA_ID = "' . $irna_id . '" 
			GROUP BY irn.IRNA_ID
			-- end farmasi rawat inap
		) t_bayar_l0
		) t_bayar_l2';
$get_pembayaran = mysql_query($qry_pembayaran) or die(mysql_error());
$dat_pembayaran = mysql_fetch_assoc($get_pembayaran);
$bayar = $dat_pembayaran['HARGA'];
if($bayar > 0){
	$_err = $_err . 'Tidak Dapat Dibatalkan, Pasien Telah Melakukan Pembayaran Atau Ada Tindakan. \n';
	$st_batal = false;
}

if($st_batal){
	if (empty($_POST['keterangan_batal'])){
		$_err = $_err . 'Keterangan Pembatalan Harus Diisi. \n';
	}else{
		$batal = '1';
		mysql_query('UPDATE t_irna SET ST_BATAL = "1",KETERANGAN_BATAL = "' . $_POST['keterangan_batal'] . '",
					PASIEN_MASUK = NULL,
					USER_PENDAFTARAN = "' . $user_name . '"
					WHERE IRNA_ID = "' . $irna_id . '"') or die(mysql_error());
		mysql_query('DELETE FROM t_irna_log
					WHERE IRNA_ID = "' . $irna_id . '"') or die(mysql_error());
		mysql_query('DELETE FROM t_irna_opname
					WHERE IRNA_ID = "' . $irna_id . '"') or die(mysql_error());				
		$st_edit = '1';
	}		
}	


}else{

$jenis_bayar_id = $_POST['jenis_bayar_id'];
$no_peserta = $_POST['no_peserta'];

if($jenis_bayar_id != '12'){
	$ruang_id = $_POST['ruang_id'];
	$tmp_tidur = $_POST['tmp_tidur'];
	$pegawai_id = $_POST['pegawai_id'];	
	$no_sep = $_POST['no_sep'];
	$kelas_jaminan = $_POST['kelas_jaminan'];
	$kelas_rawat = $_POST['kelas_rawat'];
	
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
	$ruang_id = $_POST['jkn_ruang_id'];
	$tmp_tidur = $_POST['jkn_tmp_tidur'];
	$pegawai_id = $_POST['jkn_pegawai_id'];	
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
	
	$jkn_nama_pasien = $_POST['jkn_nama_pasien'];
	$jkn_tgl_lahir = $_POST['jkn_tgl_lahir'];
	$jkn_jns_kelamin = '';
	if(isset($_POST['jkn_jns_kelamin'])) 
		$jkn_jns_kelamin = $_POST['jkn_jns_kelamin'];
	
	if(!empty($jkn_nama_pasien) and !empty($jkn_tgl_lahir) and !empty($jkn_jns_kelamin)){
		mysql_query('UPDATE m_pasien SET NAMA_PASIEN = "' . $jkn_nama_pasien . '",TGL_LAHIR = STR_TO_DATE("' . $jkn_tgl_lahir . '","%d/%m/%Y"),
				JNS_KELAMIN = "' . $jkn_jns_kelamin . '" WHERE NOMR = "' . $nomr . '"') or die(mysql_error());
	}
	
	$kelas_jaminan = $_POST['jkn_kls_rawat'];
	$kelas_rawat = $_POST['jkn_kelas_rawat'];	
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

$_err = '';
if (empty($ruang_id))
    $_err = $_err . 'Ruang Rawat Harus Diisi. \n';
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
if (!in_array($jenis_bayar_id,getArrNonJaminan()) and $jenis_bayar_id != '12'){	
	if (empty($kelas_jaminan))
		$_err = $_err . 'Kelas Peserta Harus Diisi. \n';
}

if($kelas_rawat == ''){
	$_err = $_err . 'Kelas Rawat Harus Diisi. \n';	
}

    $st_save = true;
	if (empty($_err)) {
    if (!empty($_POST['irna_id'])) {
		if($st_edit == '2'){
		
		$sql_log = 'SELECT t_irna.RUANG_ID,t_irna.PEGAWAI_ID,t_irna.JENIS_BAYAR_ID,
				t_irna.NO_PESERTA,t_irna.NO_SEP,t_irna.NO_PENDAFTARAN
				FROM t_irna WHERE t_irna.IRNA_ID = "' . $irna_id . '"';
		$get_log = mysql_query($sql_log) or die(mysql_error());
		$dat_log = mysql_fetch_assoc($get_log); 
		$no_pendaftaran = $dat_log['NO_PENDAFTARAN']; 

		mysql_query('INSERT INTO t_irna_log(IRNA_ID,NOMR,TANGGAL_UPDATE,JNS_UPDATE,
					RUANG_ID_ASAL,PEGAWAI_ID,JENIS_BAYAR_ID,NO_PESERTA,NO_SEP,
					USER_PENDAFTARAN)
					VALUES("' . $irna_id . '","' . $nomr . '",NOW(),"A",
					"' . $dat_log['RUANG_ID'] . '","' . $dat_log['PEGAWAI_ID'] . '",
					"' . $dat_log['JENIS_BAYAR_ID'] . '","' . $dat_log['NO_PESERTA'] . '",
					"' . $dat_log['NO_SEP'] . '","' . $user_name . '")') or die(mysql_error());				 
		
		$st_save = mysql_query('UPDATE t_irna SET RUANG_ID = "' . $ruang_id . '",PEGAWAI_ID = "' . $pegawai_id . '",KELAS_RAWAT = "' . $kelas_rawat . '",
						NO_TMP_TIDUR = "' . $tmp_tidur . '",JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",NO_PESERTA = "' . $no_peserta . '",NO_SEP = "' . $no_sep . '",
						P_JAWAB_NAMA = "' . $p_jawab_nama . '",P_JAWAB_NO_TELP = "' . $p_jawab_no_telp . '",P_JAWAB_ALAMAT = "' . $p_jawab_alamat . '",P_JAWAB_ALAMAT_RT = "' . $p_jawab_alamat_rt . '",
						P_JAWAB_ALAMAT_RW = "' . $p_jawab_alamat_rw . '",P_JAWAB_KELURAHAN_ID = "' . $p_jawab_kelurahan_id . '",P_JAWAB_KECAMATAN_ID = "' . $p_jawab_kecamatan_id . '",
						P_JAWAB_KOTA_ID = "' . $p_jawab_kota_id . '",P_JAWAB_PROPINSI_ID = "' . $p_jawab_propinsi_id . '",P_JAWAB_HUBUNGAN = "' . $p_jawab_hubungan . '",
						USER_PENDAFTARAN = "' . $user_name . '", 
						JKN_TGL_RUJUK = STR_TO_DATE("' . $jkn_tgl_rujuk . '","%d/%m/%Y"),JKN_NO_RUJUK = "' . $jkn_no_rujuk . '",
						JKN_KD_PKK = "' . $jkn_kd_pkk . '",JKN_NAMA_PKK = "' . $jkn_nama_pkk . '",JKN_CATATAN = "' . $jkn_catatan . '",
						JKN_DIAGNOSA = "' . $jkn_diagnosa . '",JKN_POLIKLINIK = "' . $jkn_poliklinik . '",
						JKN_PBI_NONPBI = "' . $jkn_pbi_nonpbi . '",JKN_KELAS_RAWAT = "' . $kelas_jaminan . '",
						JKN_ASAL_RUJUKAN = "' . $jkn_asal_rujukan . '",JKN_COB = "' . $jkn_cob . '",JKN_PENJAMIN = "' . $jkn_penjamin . '",
						JKN_KATARAK = "' . $jkn_katarak . '",JKN_SUPLESI = "' . $jkn_suplesi . '",JKN_NO_SEP_SUPLESI = "' . $jkn_nosep_suplesi . '",JKN_NOSURAT_SKDP = "' . $jkn_nosurat_skdp . '",
						JKN_DPJP_SKDP = "' . $jkn_dpjp_skdp . '",JKN_NAMA_DPJP_SKDP = "' . $jkn_nama_dpjp_skdp . '",
						JKN_SPESIALISASI_DPJP_SKDP = "' . $jkn_spesialis_dpjp_skdp . '",KD_LOKASI_KECELAKAAN_PROPINSI = "' . $kd_lokasi_kecelakaan_propinsi . '",
						NAMA_LOKASI_KECELAKAAN_PROPINSI = "' . $nama_lokasi_kecelakaan_propinsi . '",KD_LOKASI_KECELAKAAN_KABUPATEN = "' . $kd_lokasi_kecelakaan_kota . '",
						NAMA_LOKASI_KECELAKAAN_KABUPATEN = "' . $nama_lokasi_kecelakaan_kota . '",KD_LOKASI_KECELAKAAN_KECAMATAN = "' . $kd_lokasi_kecelakaan_kecamatan . '",
						NAMA_LOKASI_KECELAKAAN_KECAMATAN = "' . $nama_lokasi_kecelakaan_kecamatan . '",TGL_KEJADIAN_KECELAKAAN = STR_TO_DATE("' . $tgl_kejadian_kecelakaan . '","%d/%m/%Y"),
						KETERANGAN_KECELAKAAN = "' . $keterangan_kecelakaan . '",KECELAKAAN = "' . $pasien_kecelakaan . '",KASUS_POLISI = "' . $kasus_polisi . '",
						KELAS_JAMINAN = "' . $kelas_jaminan . '"
						WHERE IRNA_ID = "' . $irna_id . '"') or die(mysql_error());
						
		mysql_query('UPDATE t_irna_tarif SET JENIS_BAYAR_ID = "' . $jenis_bayar_id . '"
							WHERE IRNA_ID = "' . $irna_id . '"') or die(mysql_error());	

		mysql_query('UPDATE t_ipenunjang_tarif 
							INNER JOIN t_ipenunjang 
							ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
							SET t_ipenunjang_tarif.JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
							t_ipenunjang.JENIS_BAYAR_ID = "' . $jenis_bayar_id . '"
							WHERE t_ipenunjang.RAWAT_ID = "' . $irna_id . '"
							AND (t_ipenunjang.JNS_ORDER ="IRN" OR t_ipenunjang.JNS_ORDER ="HRI"
							OR t_ipenunjang.JNS_ORDER ="ORI")') or die(mysql_error());							
						
		$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
		mysql_select_db($database_3, $connect_3) or die(mysql_error());
			
		mysql_query('UPDATE t_farmasi_apotik_pengeluaran
						SET JAMINAN_ID = "' . $jenis_bayar_id . '"
						WHERE JENIS_PENGELUARAN = "2"
						AND RANAP_ID = "' . $irna_id . '"') or die(mysql_error());	
			
		if($jenis_bayar_id == 12){
			if(!empty($jkn_nama_pasien) and !empty($jkn_tgl_lahir) and !empty($jkn_jns_kelamin)){
				mysql_query('UPDATE t_farmasi_apotik_pengeluaran
						SET NAMA_PELANGGAN = "' . trim($jkn_nama_pasien) . '",
						TGL_LAHIR = STR_TO_DATE("' . $jkn_tgl_lahir . '","%d/%m/%Y"),
						JNS_KELAMIN = "' . $jkn_jns_kelamin . '"
						WHERE JENIS_PENGELUARAN = "2"
						AND RANAP_ID = "' . $irna_id . '"') or die(mysql_error());
			}
		}
						
		
		$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
		mysql_select_db($database, $connect) or die(mysql_error());	

		mysql_query('UPDATE t_operasi_tarif 
						INNER JOIN t_operasi 
						ON (t_operasi_tarif.OPERASI_ID = t_operasi.OPERASI_ID)
						SET t_operasi_tarif.KELAS_JAMINAN = "' . $kelas_jaminan . '",
						t_operasi_tarif.JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
						t_operasi.KELAS_JAMINAN = "' . $kelas_jaminan . '",
						t_operasi.JENIS_BAYAR_ID = "' . $jenis_bayar_id . '"
						WHERE t_operasi.RAWAT_ID = "' . $irna_id . '"
						AND t_operasi.ST_MASUK = "2"') or die(mysql_error());					
		
		mysql_query('UPDATE t_hemodialisa_tarif 
						INNER JOIN t_hemodialisa 
						ON (t_hemodialisa_tarif.HEMODIALISA_ID = t_hemodialisa.HEMODIALISA_ID)
						SET t_hemodialisa_tarif.JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
						t_hemodialisa.JENIS_BAYAR_ID = "' . $jenis_bayar_id . '"
						WHERE t_hemodialisa.RAWAT_ID = "' . $irna_id . '"
						AND t_hemodialisa.JNS_ORDER ="IRN"') or die(mysql_error());	
						
		mysql_query('UPDATE t_ambulance_tarif SET JENIS_BAYAR_ID = "' . $jenis_bayar_id . '"
						WHERE RAWAT_ID = "' . $irna_id . '" 
						AND JNS_ORDER = "IRN"') or die(mysql_error());	

		$jenis_bayar_id_ls = $_POST['jenis_bayar_id_ls'];
		if(in_array($jenis_bayar_id_ls,getArrRencanaJaminan()) 
					and !in_array($jenis_bayar_id,getArrRencanaJaminan())){
			$no_bayar = getNomorHarian('Kasir');
			$st_bayar = 'Lunas';
			
			if($jenis_bayar_id == '1'){
			
				mysql_query('UPDATE t_irna_tarif SET TGL_BAYAR = NOW()
					WHERE IRNA_ID = "' . $irna_id . '"
					AND NO_PEMBAYARAN IS NOT NULL') or die(mysql_error());	
					
				mysql_query('UPDATE t_ipenunjang_tarif 
							INNER JOIN t_ipenunjang 
							ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
							SET t_ipenunjang_tarif.TANGGAL_BAYAR = NOW() 
							WHERE t_ipenunjang.RAWAT_ID = "' . $irna_id . '"
							AND (t_ipenunjang.JNS_ORDER ="IRN" OR t_ipenunjang.JNS_ORDER ="HRI"
							OR t_ipenunjang.JNS_ORDER ="ORI")
							AND t_ipenunjang_tarif.NO_PEMBAYARAN IS NOT NULL') or die(mysql_error());	
				
				mysql_query('UPDATE t_operasi_tarif 
						INNER JOIN t_operasi 
						ON (t_operasi_tarif.OPERASI_ID = t_operasi.OPERASI_ID)
						SET t_operasi_tarif.TGL_BAYAR = NOW()
						WHERE t_operasi.RAWAT_ID = "' . $irna_id . '"
						AND t_operasi.ST_MASUK = "2"
						AND t_operasi_tarif.NO_PEMBAYARAN IS NOT NULL') or die(mysql_error());

				mysql_query('UPDATE t_hemodialisa_tarif 
						INNER JOIN t_hemodialisa 
						ON (t_hemodialisa_tarif.HEMODIALISA_ID = t_hemodialisa.HEMODIALISA_ID)
						SET t_hemodialisa_tarif.TGL_BAYAR = NOW()
						WHERE t_hemodialisa.RAWAT_ID = "' . $irna_id . '"
						AND t_hemodialisa.JNS_ORDER ="IRN"
						AND t_hemodialisa_tarif.NO_PEMBAYARAN IS NOT NULL') or die(mysql_error());	

				mysql_query('UPDATE t_ambulance_tarif SET TGL_BAYAR = NOW()
						WHERE RAWAT_ID = "' . $irna_id . '" 
						AND JNS_ORDER = "IRN"
						AND NO_PEMBAYARAN IS NOT NULL') or die(mysql_error());	
			
				mysql_query('UPDATE db_inventorirs.t_farmasi_apotik_pengeluaran
						SET TANGGAL_BAYAR  = NOW()
						WHERE JENIS_PENGELUARAN = "2"
						AND RANAP_ID = "' . $irna_id . '"
						AND NO_PEMBAYARAN IS NOT NULL') or die(mysql_error());
						
			}else{
				
				mysql_query('UPDATE t_irna_tarif SET NO_PEMBAYARAN = "' . $no_bayar . '",
					ST_BAYAR = "' . $st_bayar . '"
					WHERE IRNA_ID = "' . $irna_id . '"') or die(mysql_error());	
					
				mysql_query('UPDATE t_ipenunjang_tarif 
							INNER JOIN t_ipenunjang 
							ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
							SET t_ipenunjang_tarif.NO_PEMBAYARAN = "' . $no_bayar . '",
							t_ipenunjang_tarif.ST_BAYAR = "' . $st_bayar . '"
							WHERE t_ipenunjang.RAWAT_ID = "' . $irna_id . '"
							AND (t_ipenunjang.JNS_ORDER ="IRN" OR t_ipenunjang.JNS_ORDER ="HRI"
							OR t_ipenunjang.JNS_ORDER ="ORI")') or die(mysql_error());	
				
				mysql_query('UPDATE t_operasi_tarif 
						INNER JOIN t_operasi 
						ON (t_operasi_tarif.OPERASI_ID = t_operasi.OPERASI_ID)
						SET t_operasi_tarif.NO_PEMBAYARAN = "' . $no_bayar . '",
						t_operasi_tarif.ST_BAYAR = "' . $st_bayar . '"
						WHERE t_operasi.RAWAT_ID = "' . $irna_id . '"
						AND t_operasi.ST_MASUK = "2"') or die(mysql_error());

				mysql_query('UPDATE t_hemodialisa_tarif 
						INNER JOIN t_hemodialisa 
						ON (t_hemodialisa_tarif.HEMODIALISA_ID = t_hemodialisa.HEMODIALISA_ID)
						SET t_hemodialisa_tarif.NO_PEMBAYARAN = "' . $no_bayar . '",
						t_hemodialisa_tarif.ST_BAYAR = "' . $st_bayar . '"
						WHERE t_hemodialisa.RAWAT_ID = "' . $irna_id . '"
						AND t_hemodialisa.JNS_ORDER ="IRN"') or die(mysql_error());	

				mysql_query('UPDATE t_ambulance_tarif SET NO_PEMBAYARAN = "' . $no_bayar . '",
						ST_BAYAR = "' . $st_bayar . '"
						WHERE RAWAT_ID = "' . $irna_id . '" 
						AND JNS_ORDER = "IRN"') or die(mysql_error());				
			}		
		}		
						
		}else if($st_edit == '1'){
			$st_save = mysql_query('UPDATE t_irna SET NO_PESERTA = "' . $no_peserta . '",NO_SEP = "' . $no_sep . '",
						P_JAWAB_NAMA = "' . $p_jawab_nama . '",P_JAWAB_NO_TELP = "' . $p_jawab_no_telp . '",P_JAWAB_ALAMAT = "' . $p_jawab_alamat . '",P_JAWAB_ALAMAT_RT = "' . $p_jawab_alamat_rt . '",
						P_JAWAB_ALAMAT_RW = "' . $p_jawab_alamat_rw . '",P_JAWAB_KELURAHAN_ID = "' . $p_jawab_kelurahan_id . '",P_JAWAB_KECAMATAN_ID = "' . $p_jawab_kecamatan_id . '",
						P_JAWAB_KOTA_ID = "' . $p_jawab_kota_id . '",P_JAWAB_PROPINSI_ID = "' . $p_jawab_propinsi_id . '",P_JAWAB_HUBUNGAN = "' . $p_jawab_hubungan . '",
						USER_PENDAFTARAN = "' . $user_name . '", 
						JKN_TGL_RUJUK = STR_TO_DATE("' . $jkn_tgl_rujuk . '","%d/%m/%Y"),JKN_NO_RUJUK = "' . $jkn_no_rujuk . '",
						JKN_KD_PKK = "' . $jkn_kd_pkk . '",JKN_NAMA_PKK = "' . $jkn_nama_pkk . '",JKN_CATATAN = "' . $jkn_catatan . '",
						JKN_DIAGNOSA = "' . $jkn_diagnosa . '",JKN_POLIKLINIK = "' . $jkn_poliklinik . '",
						JKN_PBI_NONPBI = "' . $jkn_pbi_nonpbi . '",JKN_KELAS_RAWAT = "' . $kelas_jaminan . '",
						JKN_ASAL_RUJUKAN = "' . $jkn_asal_rujukan . '",JKN_COB = "' . $jkn_cob . '",JKN_PENJAMIN = "' . $jkn_penjamin . '",
						JKN_KATARAK = "' . $jkn_katarak . '",JKN_SUPLESI = "' . $jkn_suplesi . '",JKN_NO_SEP_SUPLESI = "' . $jkn_nosep_suplesi . '",JKN_NOSURAT_SKDP = "' . $jkn_nosurat_skdp . '",
						JKN_DPJP_SKDP = "' . $jkn_dpjp_skdp . '",JKN_NAMA_DPJP_SKDP = "' . $jkn_nama_dpjp_skdp . '",
						JKN_SPESIALISASI_DPJP_SKDP = "' . $jkn_spesialis_dpjp_skdp . '",KD_LOKASI_KECELAKAAN_PROPINSI = "' . $kd_lokasi_kecelakaan_propinsi . '",
						NAMA_LOKASI_KECELAKAAN_PROPINSI = "' . $nama_lokasi_kecelakaan_propinsi . '",KD_LOKASI_KECELAKAAN_KABUPATEN = "' . $kd_lokasi_kecelakaan_kota . '",
						NAMA_LOKASI_KECELAKAAN_KABUPATEN = "' . $nama_lokasi_kecelakaan_kota . '",KD_LOKASI_KECELAKAAN_KECAMATAN = "' . $kd_lokasi_kecelakaan_kecamatan . '",
						NAMA_LOKASI_KECELAKAAN_KECAMATAN = "' . $nama_lokasi_kecelakaan_kecamatan . '",TGL_KEJADIAN_KECELAKAAN = STR_TO_DATE("' . $tgl_kejadian_kecelakaan . '","%d/%m/%Y"),
						KETERANGAN_KECELAKAAN = "' . $keterangan_kecelakaan . '",KECELAKAAN = "' . $pasien_kecelakaan . '",KASUS_POLISI = "' . $kasus_polisi . '"
						WHERE IRNA_ID = "' . $irna_id . '"') or die(mysql_error());
			
		}
    }
 }
}
if (empty($_err)) {
	$link = 'pendaftaranlistrawat';
	function ubahDateFormat($originalDate) {
		$date = new DateTime($originalDate);
		return $date->format('d M Y');
	}
	$rm1=substr($nomr,0,2);
	$rm2=substr($nomr,2,2);
	$rm3=substr($nomr,4,2);
	
	$sql_pasien = 'SELECT m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,
					t_irna.TANGGAL_DAFTAR,m_ruang.NAMA_RUANG,m_pegawai.NAMA_PEGAWAI,t_irna.KELAS_RAWAT
					FROM m_pasien
					INNER JOIN t_irna ON (m_pasien.NOMR = t_irna.NOMR)
					INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
					INNER JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
					WHERE t_irna.IRNA_ID = "' . $irna_id . '"';
	$get_pasien = mysql_query($sql_pasien) or die(mysql_error());
	$dat_pasien = mysql_fetch_assoc($get_pasien);
	
	$nomr = $rm1 . '.' . $rm2 . '.' . $rm3;
	$umur = ubahDateFormat($dat_pasien['TGL_LAHIR']);
	$pasien = $dat_pasien['NAMA_PASIEN'].' ('.strtoupper($dat_pasien['JNS_KELAMIN']).', '.$umur.')';
	$tgl_masuk = $dat_pasien['TANGGAL_DAFTAR'];
	$dokter = $dat_pasien['NAMA_PEGAWAI'];
	$ruang = $dat_pasien['NAMA_RUANG'] . ' Kelas ' . $dat_pasien['KELAS_RAWAT'];
    ?>
    <script language="JavaScript" >
	<?php if($st_edit != '1'){ ?>
	var p_sjp = 'no';
	if(confirm('Print SJP?')){
		p_sjp = 'yes';
	}
	var p_sep = 'no';
		if(confirm('Print SEP?')){
		 p_sep = 'yes';
		}	
	window.open('http://localhost/nsimrs_print/print_sjp_irna.php?idx=<?php echo $irna_id; ?>&sjp=' + p_sjp + '&sep=' + p_sep,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
	window.open("index.php?print=gelangpasien&pasien=<?php echo $pasien; ?>&norm=<?php echo 'MR '.$nomr; ?>&tglmasuk=<?php echo ubahDateFormat($tgl_masuk); ?>&dokter=<?php echo $dokter; ?>&ruangan=<?php echo $ruang; ?>","Gelang Pasien");
	<?php } ?>
	alert('Simpan Perubahan Data Rawat Berhasil.');
	window.location = "index.php?link=<?php echo md5($link); ?>&idx=<?php echo $irna_id; ?>";
	</script> 
    <?php
} else {
    $msg_info = $_err;
}
?>