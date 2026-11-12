<?php
$irja_id_rujuk = $_POST['irja_id_rujuk'];
$nomr = $_POST['nomr'];
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

$diagnosa_awal = $_POST['diagnosa_awal'];

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

if($jenis_bayar_id == '9' or $jenis_bayar_id == '14') $no_sep = $no_peserta;

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
		$no_sjp = getNomorHarian('SJP');
		$no_pendaftaran = getNomorBulanan('IRNA');
        $st_save = mysql_query('INSERT INTO t_irna(IRNA_ID,NOMR,TANGGAL_DAFTAR,RUANG_ID,NO_TMP_TIDUR,DIAGNOSA_AWAL,PEGAWAI_ID,
							JENIS_BAYAR_ID,NO_PESERTA,NO_SEP,NO_SJP,P_JAWAB_NAMA,P_JAWAB_NO_TELP,P_JAWAB_ALAMAT,P_JAWAB_ALAMAT_RT,
							P_JAWAB_ALAMAT_RW,P_JAWAB_KELURAHAN_ID,P_JAWAB_KECAMATAN_ID,P_JAWAB_KOTA_ID,P_JAWAB_PROPINSI_ID,
							P_JAWAB_HUBUNGAN,NO_PENDAFTARAN,USER_PENDAFTARAN,SHIFT_ID,KELAS_RAWAT,
							JKN_TGL_RUJUK,JKN_NO_RUJUK,JKN_KD_PKK,JKN_NAMA_PKK,
							JKN_CATATAN,JKN_DIAGNOSA,JKN_POLIKLINIK,JKN_KELAS_RAWAT,JKN_PBI_NONPBI,KELAS_JAMINAN,
							KECELAKAAN,KASUS_POLISI,JKN_ASAL_RUJUKAN,JKN_COB,JKN_PENJAMIN,JKN_KATARAK,
							JKN_SUPLESI,JKN_NO_SEP_SUPLESI,JKN_NOSURAT_SKDP,JKN_DPJP_SKDP,
							JKN_NAMA_DPJP_SKDP,JKN_SPESIALISASI_DPJP_SKDP,KD_LOKASI_KECELAKAAN_PROPINSI,
							NAMA_LOKASI_KECELAKAAN_PROPINSI,KD_LOKASI_KECELAKAAN_KABUPATEN,
							NAMA_LOKASI_KECELAKAAN_KABUPATEN,KD_LOKASI_KECELAKAAN_KECAMATAN,
							NAMA_LOKASI_KECELAKAAN_KECAMATAN,TGL_KEJADIAN_KECELAKAAN,KETERANGAN_KECELAKAAN)
							VALUES("' . $irja_id_rujuk . '","' . $nomr . '",NOW(),"' . $ruang_id . '","' . $tmp_tidur . '",
							"' . $diagnosa_awal . '","' . $pegawai_id . '","' . $jenis_bayar_id . '","' . $no_peserta . '",
							"' . $no_sep . '","' . $no_sjp . '","' . $p_jawab_nama . '","' . $p_jawab_no_telp . '","' . $p_jawab_alamat . '","' . $p_jawab_alamat_rt . '","' . $p_jawab_alamat_rw . '",
								"' . $p_jawab_kelurahan_id . '","' . $p_jawab_kecamatan_id . '","' . $p_jawab_kota_id . '","' . $p_jawab_propinsi_id . '",
								"' . $p_jawab_hubungan . '","' . $no_pendaftaran . '","' . currentUser() . '","' . $_SESSION['SES_SIMRS_SHIFT'] . '",
							"' . $kelas_rawat . '",STR_TO_DATE("' . $jkn_tgl_rujuk . '","%d/%m/%Y"),"' . $jkn_no_rujuk . '","' . $jkn_kd_pkk . '",
							"' . $jkn_nama_pkk . '","' . $jkn_catatan . '","' . $jkn_diagnosa . '","' . $jkn_poliklinik . '",
							"' . $kelas_jaminan . '","' . $jkn_pbi_nonpbi . '","' . $kelas_jaminan . '",
							"' . $pasien_kecelakaan . '","' . $kasus_polisi . '","' . $jkn_asal_rujukan . '","' . $jkn_cob . '","' . $jkn_penjamin . '",
							"' . $jkn_katarak . '","' . $jkn_suplesi . '","' . $jkn_nosep_suplesi . '","' . $jkn_nosurat_skdp . '",
							"' . $jkn_dpjp_skdp . '","' . $jkn_nama_dpjp_skdp . '","' . $jkn_spesialis_dpjp_skdp . '",
							"' . $kd_lokasi_kecelakaan_propinsi . '","' . $nama_lokasi_kecelakaan_propinsi . '",
							"' . $kd_lokasi_kecelakaan_kota . '","' . $nama_lokasi_kecelakaan_kota . '",
							"' . $kd_lokasi_kecelakaan_kecamatan . '","' . $nama_lokasi_kecelakaan_kecamatan . '",
							STR_TO_DATE("' . $tgl_kejadian_kecelakaan . '","%d/%m/%Y"),"' . $keterangan_kecelakaan . '")') or die(mysql_error());
        if ($st_save) {
				//cek kamar operasi
				mysql_query('UPDATE t_operasi
					SET RUANG_ID = "' . $ruang_id . '", 
					KELAS_RAWAT = "' . $kelas_rawat . '",
					KELAS_JAMINAN = "' . $kelas_jaminan . '",
					JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
					NO_PENDAFTARAN = "' . $no_pendaftaran . '",
					ST_MASUK = "2"
					WHERE RAWAT_ID = "' . $irja_id_rujuk . '"
					AND JNS_ORDER = "IRJ" 
					AND ST_APPROVE = "1"
					AND TANGGAL_OPERASI >= CURRENT_DATE()') or die(mysql_error());	
			}
		}
if (empty($_err)) {
	
	//edoc rekam medic
	/*include('edoc_rekammedik/edoc_main.php');
	create_pdf_identitas($irja_id_rujuk,'RI');
	create_pdf_ringkasan_masuk_rawat_inap($irja_id_rujuk);*/
	//	
	$link = 'pendaftaranviewrawatinap';
    ?>
        <script language="JavaScript" >
		var p_sjp = 'no';
		//if(confirm('Print SJP?')){
		 p_sjp = 'yes';
		//}
		var p_sep = 'no';
		<?php if($jenis_bayar_id == '12'){ ?>
		if(confirm('Print SEP?')){
		 p_sep = 'yes';
		}
		<?php } ?>
		window.open('http://localhost/nsimrs_print/print_sjp_irna.php?idx=<?php echo $irja_id_rujuk; ?>&sjp=' + p_sjp + '&sep=' + p_sep,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
		window.location = "index.php?link=<?php echo md5($link); ?>&idx=<?php echo $irja_id_rujuk; ?>";
        </script> 
        <?php
} else {
    $msg_info = $_err;
}
?>