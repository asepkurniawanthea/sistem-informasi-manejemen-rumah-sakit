<?php
$penunjang_id = $_POST['penunjang_id'];
$rawat_id = $_POST['rawat_id'];
$user_name = currentUser();

$jenis_bayar_id = $_SESSION['jenis_bayar_id_' . $rawat_id];
$no_peserta = $_SESSION['no_peserta_' . $rawat_id];
$tgl_daftar = $_SESSION['tgl_daftar_' . $rawat_id];
$tgl_daftar_rujuk = $_SESSION['tgl_daftar_rujuk_' . $rawat_id];
$tanggal_sep = $_SESSION['tanggal_sep_' . $rawat_id];

$unit_id = $_SESSION['unit_id_' . $rawat_id]; 
$pegawai_id = $_SESSION['pegawai_id_' . $rawat_id]; 
$no_sep = $_SESSION['no_sep_' . $rawat_id]; 
$jkn_tgl_rujuk = $_SESSION['jkn_tgl_rujuk_' . $rawat_id]; 
$jkn_no_rujuk = $_SESSION['jkn_no_rujuk_' . $rawat_id]; 
$jkn_asal_rujukan = $_SESSION['jkn_asal_rujukan_' . $rawat_id]; 
$jkn_kd_pkk = $_SESSION['jkn_kd_pkk_' . $rawat_id]; 
$jkn_nama_pkk = $_SESSION['jkn_nama_pkk_' . $rawat_id]; 
$jkn_diagnosa = $_SESSION['jkn_diagnosa_' . $rawat_id]; 
$jkn_catatan = $_SESSION['jkn_catatan_' . $rawat_id]; 
$jkn_pbi_nonpbi = $_SESSION['jkn_pbi_nonpbi_' . $rawat_id]; 
$jkn_cob = $_SESSION['jkn_cob_' . $rawat_id]; 
$jkn_katarak = $_SESSION['jkn_katarak_' . $rawat_id]; 
$jkn_nosurat_skdp = $_SESSION['jkn_nosurat_skdp_' . $rawat_id]; 
$jkn_dpjp_skdp = $_SESSION['jkn_dpjp_skdp_' . $rawat_id]; 
$jkn_nama_dpjp_skdp = $_SESSION['jkn_nama_dpjp_skdp_' . $rawat_id]; 
$jkn_spesialis_dpjp_skdp = $_SESSION['jkn_spesialis_dpjp_skdp_' . $rawat_id]; 
$dokter_pengirim = $_SESSION['dokter_pengirim_' . $rawat_id]; 

$nomor_order = getNomorBulanan('IPENUNJANG');
$no_bayar = 'NULL';
$st_bayar = 'NULL';
if(!in_array($jenis_bayar_id,getArrNonJaminan())){
	$no_bayar = '"' . getNomorHarian('Kasir') . '"';
	$st_bayar = '"Lunas"';
}

$nomor = getNomorHarian('Tarif');
$no_sjp = getNomorHarian('SJP');

if(isset($_POST['karcis'])){
	mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI) 
			VALUES("' . $penunjang_id . '","' . $_POST['karcis'] . '",1)') or die(mysql_error());
}		

mysql_query('UPDATE t_ipenunjang_tarif 
			SET TANGGAL_DAFTAR = NOW(),
			UNIT_PENUNJANG_ID = "' . $unit_id . '",
			JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
			ST_BAYAR = ' . $st_bayar . ',
			NO_TARIF = "' . $nomor . '",
			NO_SJP = "' . $no_sjp . '",
			NO_PEMBAYARAN = ' . $no_bayar . ',
			SHIFT_PENDAFTARAN = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
			USER_PENDAFTARAN = "' . $user_name . '",
			ST_TPP = "1",
			PEGAWAI_PERIKSA_ID = "' . $pegawai_id . '",
			NO_SEP = "' . $no_sep . '",
			TANGGAL_SEP = ' . fieldDate($tanggal_sep) . ',
			NO_PESERTA = "' . $no_peserta . '",
			JKN_TGL_RUJUK = ' . fieldDate($jkn_tgl_rujuk) . ',
			JKN_NO_RUJUK = "' . $jkn_no_rujuk . '",
			JKN_KD_PKK = "' . $jkn_kd_pkk . '",
			JKN_NAMA_PKK = "' . $jkn_nama_pkk . '",
			JKN_CATATAN = "' . $jkn_catatan . '",
			JKN_DIAGNOSA = "' . $jkn_diagnosa . '",
			JKN_POLIKLINIK = "",
			JKN_KELAS_RAWAT = "",
			JKN_PBI_NONPBI = "' . $jkn_pbi_nonpbi . '",
			JKN_ASAL_RUJUKAN = "' . $jkn_asal_rujukan . '",
			JKN_COB = "' . $jkn_cob . '",
			JKN_KATARAK = "' . $jkn_katarak . '",
			JKN_NOSURAT_SKDP = "' . $jkn_nosurat_skdp . '",
			JKN_DPJP_SKDP = "' . $jkn_dpjp_skdp . '",
			JKN_NAMA_DPJP_SKDP = "' . $jkn_nama_dpjp_skdp . '",
			JKN_SPESIALISASI_DPJP_SKDP = "' . $jkn_spesialis_dpjp_skdp . '"
			WHERE PENUNJANG_ID =  "' . $penunjang_id . '"') or die(mysql_error());		
			
	mysql_query('UPDATE t_ipenunjang 
		SET NO_ORDER = "' . $nomor_order . '", 
		PEGAWAI_ID = "' . $dokter_pengirim . '",
		TANGGAL_ORDER = NOW(),
		JENIS_BAYAR_ID = "' . $jenis_bayar_id . '"
		WHERE PENUNJANG_ID = "' . $penunjang_id . '"') or die(mysql_error());
	
	if($unit_id == '45'){
		include('lis/simrs2lis.php');
		lis_create_order($rawat_id,$nomor_order,'IRJ');
	}		
?>
<script language="JavaScript" >
	var p_sjp = 'yes';
	var p_sep = 'no';
		
	<?php if($jenis_bayar_id == '12'){ ?>
		if(confirm('Print Juga SEP?')){
			p_sep = 'yes';
		}
	<?php } ?>
		
	window.open('http://localhost/nsimrs_print/print_pembayaran_karcis_penunjang.php?idx=<?php echo $rawat_id; ?>&no=<?php echo $nomor; ?>&sjp=' + p_sjp + '&jn=&sep=' + p_sep,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
	window.location = "index.php?link=<?php echo md5('pendaftaranviewpenunjang'); ?>&idx=<?php echo $rawat_id; ?>&no=<?php echo $nomor; ?>&opt=1";
</script> 					