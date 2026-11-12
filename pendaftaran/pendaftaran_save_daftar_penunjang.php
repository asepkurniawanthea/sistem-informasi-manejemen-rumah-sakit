<?php
$jenis_bayar_id = $_POST['jenis_bayar_id'];
$no_peserta = $_POST['no_peserta'];
$tgl_daftar = $_POST['tgl_daftar'];
$tgl_daftar_rujuk = $_POST['tgl_daftar_rujuk'];

$tanggal_sep = '';
$tgl_status = $_POST['tgl_status'];
if($tgl_status == '1'){
	$tanggal_sep = $tgl_daftar_rujuk;
}else{
	$tanggal_sep = $tgl_daftar; 
}

$_SESSION['jenis_bayar_id_' . $rawat_id] =  $jenis_bayar_id; 
$_SESSION['no_peserta_' . $rawat_id] =  $no_peserta;
$_SESSION['tgl_daftar_' . $rawat_id] =  $tgl_daftar;
$_SESSION['tgl_daftar_rujuk_' . $rawat_id] =  $tgl_daftar_rujuk;
$_SESSION['tanggal_sep_' . $rawat_id] =  $tanggal_sep;

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
$jkn_nosurat_skdp = '';
$jkn_dpjp_skdp = '';
$jkn_nama_dpjp_skdp = '';
$jkn_spesialis_dpjp_skdp = '';

$dokter_pengirim = $_POST['dokter_pengirim'];

if($jenis_bayar_id != '12'){
	$unit_id = $_POST['unit_id'];
	$pegawai_id = $_POST['pegawai_id'];
	$no_sep = $_POST['no_sep'];
}else{	
	$unit_id = $_POST['jkn_unit_id'];
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
	$jkn_nosurat_skdp = $_POST['jkn_nosurat_skdp'];
	$arr_dpjp = explode('--',$_POST['jkn_dpjp_skdp']);
	if(sizeof($arr_dpjp) > 0){
		$jkn_dpjp_skdp = $arr_dpjp[0];
		$jkn_nama_dpjp_skdp = $arr_dpjp[1];
	}	
	$jkn_spesialis_dpjp_skdp = $_POST['spesialisasi_dpjp'];
	
	$nama_pasien = $_POST['jkn_nama_pasien'];
	$tgl_lahir = $_POST['jkn_tgl_lahir'];
	$jns_kelamin = $_POST['jns_kelamin'];
}

$_SESSION['unit_id_' . $rawat_id] =  $unit_id; 
$_SESSION['pegawai_id_' . $rawat_id] =  $pegawai_id; 
$_SESSION['no_sep_' . $rawat_id] =  $no_sep; 
$_SESSION['jkn_tgl_rujuk_' . $rawat_id] =  $jkn_tgl_rujuk; 
$_SESSION['jkn_no_rujuk_' . $rawat_id] =  $jkn_no_rujuk; 
$_SESSION['jkn_asal_rujukan_' . $rawat_id] =  $jkn_asal_rujukan; 
$_SESSION['jkn_kd_pkk_' . $rawat_id] =  $jkn_kd_pkk; 
$_SESSION['jkn_nama_pkk_' . $rawat_id] =  $jkn_nama_pkk; 
$_SESSION['jkn_diagnosa_' . $rawat_id] =  $jkn_diagnosa; 
$_SESSION['jkn_catatan_' . $rawat_id] =  $jkn_catatan; 
$_SESSION['jkn_pbi_nonpbi_' . $rawat_id] =  $jkn_pbi_nonpbi; 
$_SESSION['jkn_cob_' . $rawat_id] =  $jkn_cob; 
$_SESSION['jkn_katarak_' . $rawat_id] =  $jkn_katarak; 
$_SESSION['jkn_nosurat_skdp_' . $rawat_id] =  $jkn_nosurat_skdp; 
$_SESSION['jkn_dpjp_skdp_' . $rawat_id] =  $jkn_dpjp_skdp; 
$_SESSION['jkn_nama_dpjp_skdp_' . $rawat_id] =  $jkn_nama_dpjp_skdp; 
$_SESSION['jkn_spesialis_dpjp_skdp_' . $rawat_id] =  $jkn_spesialis_dpjp_skdp; 
$_SESSION['dokter_pengirim_' . $rawat_id] =  $dokter_pengirim; 

$_err = '';
if (empty($unit_id))
    $_err = $_err . 'Penunjang Tujuan Harus Diisi. \n';
if (empty($jenis_bayar_id))
    $_err = $_err . 'Jenis Pembayaran Harus Diisi. \n';	
if (empty($dokter_pengirim))
    $_err = $_err . 'Dokter Pengirim Harus Diisi. \n';

if(empty($_err)){	
	mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID,DESKRIPSI,PEGAWAI_ID,
			NOMR,UNIT_ID,USER_ORDER,JENIS_BAYAR_ID) VALUES(
			"PNJ","IRJ","' . $rawat_id . '","Penunjang (Pendaftaran)","' . $pegawai_id_rujuk . '",
			"' . $nomr . '","' . $unit_id_rujuk . '","' . $user_name . '","' . $jenis_bayar_id . '")') or die(mysql_error());
								
			$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
							FROM t_ipenunjang 
							WHERE t_ipenunjang.JNS_PENUNJANG = "PNJ" 
							AND t_ipenunjang.JNS_ORDER = "IRJ"
							AND t_ipenunjang.RAWAT_ID = "' . $rawat_id . '" 
							AND t_ipenunjang.DESKRIPSI = "Penunjang (Pendaftaran)"
							AND t_ipenunjang.NO_ORDER IS NULL
							ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
			$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
			$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
			$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];
	?>
	<script language="JavaScript" >
        window.location = "index.php?link=d78b4f6176e2a0804e3f37f3d5d2fbd7&idx=<?php echo $penunjang_id; ?>";
    </script> 
	<?php 	
} else {
    $msg_info = $_err;
}
?>