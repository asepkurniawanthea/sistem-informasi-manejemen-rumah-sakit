<?php
$pasien = $_POST['pasien'];

$nomr = $_POST['nomr'];
$irja_id = $_POST['irja_id'];
$jenis_bayar_id = $_POST['jenis_bayar_id'];
$no_peserta = $_POST['no_peserta'];
$ambil_resep = '';
if(isset($_POST['ambil_resep'])) $ambil_resep = $_POST['ambil_resep'];

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
}	

if($jenis_bayar_id == '9' or $jenis_bayar_id == '14') $no_sep = $no_peserta;

$karcis = '1';
$konsultasi = '1';
if($ambil_resep == '1') $konsultasi = '';
if((in_array($unit_id,getArrUnitIGD())) and in_array($jenis_bayar_id,getArrNonJaminan())) $konsultasi = '';
if(in_array($unit_id,getArrIrjaNonKonsul())) $konsultasi = '';

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

if($pasien != 'mcu'){
//umum, kusta, igd

if (empty($unit_id))
    $_err = $_err . 'Klinik Tujuan Harus Diisi. \n';
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

if($pasien == 'igd'){
	$jam_triage = $_POST['tgl_triage'] . ' ' . $_POST['jm_trg'] . ':' . $_POST['mt_trg'];  
	if (empty($_POST['tgl_triage']) or empty($_POST['jm_trg']) or empty($_POST['mt_trg']))
		$_err = $_err . 'Jam Triage Harus Diisi. \n';
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
	
		//antrian
		$jml_antrian = 0;
		$q_antrian = 'SELECT COUNT(IRJA_ID) AS JML_ANTRIAN
				FROM t_irja
				WHERE UNIT_ID = "' . $unit_id . '"
				AND PEGAWAI_ID = "' . $pegawai_id . '"
				AND TANGGAL_DAFTAR = CURRENT_DATE()
				AND NO_PENDAFTARAN IS NOT NULL';
		$g_antrian = mysql_query($q_antrian) or die(mysql_error());
		$d_antrian = mysql_fetch_assoc($g_antrian);
		if($d_antrian['JML_ANTRIAN'] != ''){
			$jml_antrian += $d_antrian['JML_ANTRIAN'];
		}
		
		$connect_8 = mysql_connect($hostname_8, $username_8, $password_8) or die(mysql_error());
		mysql_select_db($database_8, $connect_8) or die(mysql_error());	
		
		$q_antrian = 'SELECT COUNT(DAFTAR_ID) AS JML_ANTRIAN
				FROM t_daftar_rj
				WHERE TGL_RENCANA_KUNJUNGAN = CURRENT_DATE()
				AND UNIT = "' . $unit_id . '"
				AND DOKTER = "' . $pegawai_id . '"
				AND KODE_VERIFIKASI IS NOT NULL';
		$g_antrian = mysql_query($q_antrian) or die(mysql_error());
		$d_antrian = mysql_fetch_assoc($g_antrian);
		if($d_antrian['JML_ANTRIAN'] != ''){
			$jml_antrian += $d_antrian['JML_ANTRIAN'];
		}
		
		$no_antrian = $jml_antrian + 1; 
		
		$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
		mysql_select_db($database, $connect) or die(mysql_error());
		//
		
		$q_kunjungan = 'SELECT COUNT(IRJA_ID) AS CN FROM t_irja WHERE NOMR = "' . $nomr . '"
						AND NO_PENDAFTARAN IS NOT NULL AND ST_BATAL IS NULL
						AND DATE_FORMAT(TANGGAL_DAFTAR,"%m%Y") = DATE_FORMAT(NOW(),"%m%Y")';
		$g_kunjungan = mysql_query($q_kunjungan) or die(mysql_error());
		$d_kunjungan = mysql_fetch_assoc($g_kunjungan);
		$kunj_baru = '1';
		if($d_kunjungan['CN'] > 0) $kunj_baru = ''; 
		
        $st_save = mysql_query('UPDATE t_irja SET UNIT_ID = "' . $unit_id . '",PEGAWAI_ID = "' . $pegawai_id . '",
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
						KASUS_POLISI = "' . $kasus_polisi . '",AMBIL_RESEP = "' . $ambil_resep . '", 
						JAM_TRIAGE = STR_TO_DATE("' . $jam_triage . ':01' . '","%d/%m/%Y %H:%i:%s"),
						ONLINE_ID = "' . $no_antrian . '"
						WHERE IRJA_ID = "' . $irja_id . '"') or die(mysql_error());
						
		//edoc rekam medic
		/*include('edoc_rekammedik/edoc_main.php');
		create_pdf_identitas($irja_id,'RJ');
		create_pdf_ringkasan_kunjungan_rawat_jalan($irja_id);*/
		//	
			
        if ($st_save) {
            $no_bayar = 'NULL';
			$st_bayar = 'NULL';
			if(!in_array($jenis_bayar_id,getArrNonJaminan())){
				$no_bayar = '"' . getNomorHarian('Kasir') . '"';
				$st_bayar = '"Lunas"';
			}
			$nomor = getNomorHarian('Tarif');
			//karcis
			if($karcis == '1'){
				if(in_array($unit_id,getArrIrjaEksekutif())){
					$kode_tarif = '92001';
				}else{
					$kode_tarif = '01001';
				}
				$sql_tarif_karcis = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tarif . '" AND ST_AKTIF = "1"';
				$get_tarif_karcis = mysql_query($sql_tarif_karcis) or die(mysql_error());
				$dat_tarif_karcis = mysql_fetch_assoc($get_tarif_karcis);
				$tarif_karcis_id = $dat_tarif_karcis['TARIF_ID'];
				mysql_query('INSERT INTO t_irja_tarif(IRJA_ID,TGL_TARIF,TARIF_ID,KUANTITI,NO_TARIF,NO_PEMBAYARAN,DESKRIPSI,
						ST_BAYAR,JENIS_BAYAR_ID,USER_PENDAFTARAN,ST_PRINT)
						VALUES("' . $irja_id . '",NOW(),"' . $tarif_karcis_id . '",1,"' . $nomor . '", ' . $no_bayar . ',
						"Karcis & Konsultasi",' . $st_bayar . ',"' . $jenis_bayar_id . '","' . $user_name . '",NULL)') or die(mysql_error());	
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
				mysql_query('INSERT INTO t_irja_tarif(IRJA_ID,TGL_TARIF,TARIF_ID,KUANTITI,NO_TARIF,NO_PEMBAYARAN,DESKRIPSI,
						ST_BAYAR,JENIS_BAYAR_ID,USER_PENDAFTARAN,ST_PRINT)
						VALUES("' . $irja_id . '",NOW(),"' . $tarif_konsul_id . '",1,"' . $nomor . '", ' . $no_bayar . ',
						"Karcis & Konsultasi",' . $st_bayar . ',"' . $jenis_bayar_id . '","' . $user_name . '",NULL)') or die(mysql_error());	
			}
			}
    }
}
}
//end umum, igd, kusta
}else{
	//mcu
	include('pendaftaran/pendaftaran_save_daftar_mcu.php');
}

if(!empty($_POST['ol_daftar_id'])){
	$connect_4 = mysql_connect($hostname_4, $username_4, $password_4) or die(mysql_error());
	mysql_select_db($database_4, $connect_4) or die(mysql_error());
	
	mysql_query('UPDATE t_trans 
			SET ST_DAFTAR = "1",
			TRANS_END_TIME = NOW(),
			TRANSACTION_TIME = TIME_TO_SEC(TIMEDIFF(NOW(), CALL_TIME)),
			IRJA_ID = "' . $irja_id . '"
			WHERE TRANS_ID = "' . $_POST['ol_daftar_id'] . '"') or die(mysql_error());	
						
	$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
	mysql_select_db($database, $connect) or die(mysql_error());	
}	
if (empty($_err)) {
	$link = '';
		if($pasien == 'igd') $link = 'pendaftaranviewigd';
		if($pasien == 'umum') $link = 'pendaftaranviewpoliklinik';
		if($pasien == 'kusta') $link = 'pendaftaranviewkusta';
		if($pasien == 'mcu') $link = 'pendaftaranviewmcu';
        ?>
        <script language="JavaScript" >
		var p_sjp = 'no';
		var p_resep = 'no';
		var p_sep = 'no';
		//if(confirm('Print Juga SJP?')){
		 p_sjp = 'yes';
		//}
		<?php if($jenis_bayar_id == '12' and !empty($no_sep)){ ?>
		if(confirm('Print Juga SEP?')){
		 p_sep = 'yes';
		}
		<?php } 
		if($pasien != 'mcu'){
		?>
		window.open('http://localhost/nsimrs_print/print_pembayaran_karcis.php?idx=<?php echo $irja_id; ?>&no=<?php echo $nomor; ?>&sjp=' + p_sjp + '&resep=' + p_resep + '&sep=' + p_sep,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220'); 
        <?php }else{ ?>
		window.open('http://localhost/nsimrs_print/print_pembayaran_karcis_mcu.php?idx=<?php echo $irja_id; ?>&no=<?php echo $nomor; ?>&sjp=' + p_sjp + '&resep=' + p_resep + '&sep=' + p_sep,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220'); 
		<?php }
		?>
		window.location = "index.php?link=<?php echo md5($link); ?>&idx=<?php echo $irja_id; ?>&pasien=<?php echo $pasien; ?>";
        </script>
		<?php
} else {
    $msg_info = $_err;
}
?>