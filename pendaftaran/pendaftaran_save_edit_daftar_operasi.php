<?php
$operasi_id = $_POST['operasi_id'];
$unit_id = $_POST['unit_id'];
$pegawai_id = $_POST['pegawai_id'];
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

$_err = '';
if (empty($jenis_bayar_id))
    $_err = $_err . 'Jenis Pembayaran Harus Diisi. \n';	
	
if(empty($_err)){
    $reg_user = $user_name;
	mysql_query('UPDATE t_operasi SET JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
					NO_SEP = "' . $no_sep . '",TANGGAL_SEP = ' . fieldDate($tanggal_sep) . ',
					NO_PESERTA = "' . $no_peserta . '",JKN_TGL_RUJUK = ' . fieldDate($jkn_tgl_rujuk) . ',
					JKN_NO_RUJUK = "' . $jkn_no_rujuk . '",JKN_KD_PKK = "' . $jkn_kd_pkk . '",
					JKN_NAMA_PKK = "' . $jkn_nama_pkk . '",JKN_CATATAN = "' . $jkn_catatan . '",
					JKN_DIAGNOSA = "' . $jkn_diagnosa . '",JKN_POLIKLINIK = "' . $jkn_poliklinik . '",
					JKN_KELAS_RAWAT = "' . $jkn_kelas_rawat . '",JKN_PBI_NONPBI = "' . $jkn_pbi_nonpbi . '",
					JKN_ASAL_RUJUKAN = "' . $jkn_asal_rujukan . '",JKN_COB = "' . $jkn_cob . '",
					JKN_KATARAK = "' . $jkn_katarak . '",JKN_NOSURAT_SKDP = "' . $jkn_nosurat_skdp . '",
					JKN_DPJP_SKDP = "' . $jkn_dpjp_skdp . '",JKN_NAMA_DPJP_SKDP = "' . $jkn_nama_dpjp_skdp . '",
					JKN_SPESIALISASI_DPJP_SKDP = "' . $jkn_spesialis_dpjp_skdp . '",
					USER_DAFTAR = "' . $reg_user . '"
					WHERE OPERASI_ID = "' . $operasi_id . '"') or die(mysql_error());
	?>
		
		<script language="JavaScript" >
		var p_sjp = 'no';
		var p_sep = 'no';
		var p_karcis = 'no';
		if(confirm('Print Juga SJP?')){
		 p_sjp = 'yes';
		}
		window.open('http://localhost/nsimrs_print/print_pembayaran_karcis_operasi.php?idx=<?php echo $operasi_id; ?>&no=x&sjp=' + p_sjp + '&karcis=' + p_karcis + '&sep=' + p_sep,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
		window.location = "index.php?link=<?php echo md5('pendaftaranviewdaftaroperasi'); ?>&idx=<?php echo $operasi_id; ?>&opt=1";
		</script> 
<?php	

} else {
    $msg_info = $_err;
}
?>