<?php
$st_ubah_sep = '';
if(isset($_POST['ubah_sep'])) $st_ubah_sep = '1'; 

$unit_id = $_POST['unit_id'];
$pegawai_id = $_POST['pegawai_id'];
$jenis_bayar_id = $_POST['jenis_bayar_id'];
$no_peserta = $_POST['no_peserta'];
$cn_px = $_POST['cnt_p'];
$no = $_POST['no'];

$tgl_daftar = $_POST['tgl_daftar'];
$tgl_daftar_rujuk = $_POST['tgl_daftar_rujuk'];
$tanggal_sep = $tgl_daftar;

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
	if (empty($unit_id))
		$_err = $_err . 'Penunjang Tujuan Harus Diisi. \n';
	if (empty($jenis_bayar_id))
		$_err = $_err . 'Jenis Pembayaran Harus Diisi. \n';	
	
	/*if($st_ubah_sep == ''){
		$xl = 2;
		$xl_st = false;
		while($xl < $cn_px){
			if(isset($_POST['tarif' . $xl])) $xl_st = true;  
			$xl++;
		}

		if($unit_id == 31 or $unit_id == 41 or $unit_id == 51 or $unit_id == 47 or $unit_id == 40){
			if(!isset($_POST['tarif1']) and ($tgl_daftar != $tgl_daftar_rujuk)){
				$_err = $_err . 'Item Karcis Harus Dipilih. \n';	
			}
		}else{
			if($xl_st == false) 
				$_err = $_err . 'Item Pemeriksaan Harus Dipilih. \n';	
		}	
	}*/	

if(empty($_err)){
	$st_ok = 1;	

	if(isset($_POST['cnt_p'])){
		
		$reg_user = $user_name;
		$jns_t = 1;
		
		if($st_ubah_sep == ''){
			/*
			$cnt_p = $_POST['cnt_p'];
			$l = 2;
			
			$no_bayar = 'NULL';
			$st_bayar = 'NULL';
			if($jenis_bayar_id <> '1'){
				$no_bayar = '"' . getNomorHarian('Kasir') . '"';
				$st_bayar = '"Lunas"';
			}
			$nomor = getNomorHarian('Tarif');
			$no_sjp = getNomorHarian('SJP');
			
			$penunjang_id = '';	
			if($xl_st == false){
			
						$deskripsi = 'Penunjang (Pendaftaran)';
						$nomor_order = getNomorBulanan('IPENUNJANG');
			
						mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID,NO_ORDER,DESKRIPSI,PEGAWAI_ID,
									NOMR,TANGGAL_ORDER,UNIT_ID,USER_ORDER,JENIS_BAYAR_ID) VALUES(
									"PNJ","IRJ","' . $rawat_id . '","' . $nomor_order . '","' . $deskripsi . '",
									"' . $pegawai_id_rujuk . '","' . $nomr . '",NOW(),"' . $unit_id_rujuk . '",
									"' . $user_name . '","' . $jenis_bayar_id . '")') or die(mysql_error());
									
						$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
										FROM t_ipenunjang 
										WHERE t_ipenunjang.JNS_PENUNJANG = "PNJ" AND t_ipenunjang.JNS_ORDER = "IRJ"
										AND t_ipenunjang.RAWAT_ID = "' . $rawat_id . '" AND t_ipenunjang.NO_ORDER = "' . $nomor_order . '"
										ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
						$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
						$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
						$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];
						
						if(!isset($_POST['tarif1'])){
							mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI,TANGGAL_DAFTAR,UNIT_PENUNJANG_ID,
										JENIS_BAYAR_ID,ST_BAYAR,NO_TARIF,NO_SJP,NO_PEMBAYARAN,SHIFT_PENDAFTARAN,USER_PENDAFTARAN,
										ST_TPP,PEGAWAI_PERIKSA_ID,NO_SEP,TANGGAL_SEP,NO_PESERTA,JKN_TGL_RUJUK,JKN_NO_RUJUK,
										JKN_KD_PKK,JKN_NAMA_PKK,JKN_CATATAN,JKN_DIAGNOSA,JKN_POLIKLINIK,JKN_KELAS_RAWAT,JKN_PBI_NONPBI,
										JKN_ASAL_RUJUKAN,JKN_COB,JKN_KATARAK,JKN_NOSURAT_SKDP,JKN_DPJP_SKDP,
										JKN_NAMA_DPJP_SKDP,JKN_SPESIALISASI_DPJP_SKDP,ST_PRINT) 
										VALUES("' . $penunjang_id . '","0",0,NOW(),"' . $unit_id . '","' . $jenis_bayar_id . '",
										' . $st_bayar . ',"' . $nomor . '","' . $no_sjp . '",' . $no_bayar . ',"' . $_SESSION['SES_SIMRS_SHIFT'] . '",
										"' . $reg_user . '","1","' . $pegawai_id . '","' . $no_sep . '",' . fieldDate($tanggal_sep) . ',
										"' . $no_peserta . '",' . fieldDate($jkn_tgl_rujuk) . ',"' . $jkn_no_rujuk . '",
										"' . $jkn_kd_pkk . '","' . $jkn_nama_pkk . '","' . $jkn_catatan . '","' . $jkn_diagnosa . '",
										"' . $jkn_poliklinik . '","' . $jkn_kelas_rawat . '","' . $jkn_pbi_nonpbi . '",
										"' . $jkn_asal_rujukan . '","' . $jkn_cob . '","' . $jkn_katarak . '","' . $jkn_nosurat_skdp . '",
										"' . $jkn_dpjp_skdp . '","' . $jkn_nama_dpjp_skdp . '","' . $jkn_spesialis_dpjp_skdp . '","1")') or die(mysql_error());
						}	
			
			}else{

				mysql_query('UPDATE t_ipenunjang_tarif SET NO_TARIF = NULL,NO_SJP = NULL WHERE NO_SJP = "' . $no . '"') or die(mysql_error());
					while($l < $cnt_p){
						if(isset($_POST['tarif' . $l])){
							$jnt = $_POST['jnt' . $l];
							$tarif_id = $_POST['tarif' . $l];

								mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_DAFTAR = NOW(),
										UNIT_PENUNJANG_ID = "' . $unit_id . '",JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
										ST_BAYAR = ' . $st_bayar . ',NO_TARIF = "' . $nomor . '",NO_SJP = "' . $no_sjp . '",
										NO_PEMBAYARAN = ' . $no_bayar . ',
										SHIFT_PENDAFTARAN = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",USER_PENDAFTARAN = "' . $reg_user . '",
										ST_TPP = "1",PEGAWAI_PERIKSA_ID = "' . $pegawai_id . '",
										NO_SEP = "' . $no_sep . '",TANGGAL_SEP = ' . fieldDate($tanggal_sep) . ',
										NO_PESERTA = "' . $no_peserta . '",JKN_TGL_RUJUK = ' . fieldDate($jkn_tgl_rujuk) . ',
										JKN_NO_RUJUK = "' . $jkn_no_rujuk . '",JKN_KD_PKK = "' . $jkn_kd_pkk . '",
										JKN_NAMA_PKK = "' . $jkn_nama_pkk . '",JKN_CATATAN = "' . $jkn_catatan . '",
										JKN_DIAGNOSA = "' . $jkn_diagnosa . '",JKN_POLIKLINIK = "' . $jkn_poliklinik . '",
										JKN_KELAS_RAWAT = "' . $jkn_kelas_rawat . '",JKN_PBI_NONPBI = "' . $jkn_pbi_nonpbi . '",
										JKN_ASAL_RUJUKAN = "' . $jkn_asal_rujukan . '",JKN_COB = "' . $jkn_cob . '",
										JKN_KATARAK = "' . $jkn_katarak . '",JKN_NOSURAT_SKDP = "' . $jkn_nosurat_skdp . '",
										JKN_DPJP_SKDP = "' . $jkn_dpjp_skdp . '",JKN_NAMA_DPJP_SKDP = "' . $jkn_nama_dpjp_skdp . '",
										JKN_SPESIALISASI_DPJP_SKDP = "' . $jkn_spesialis_dpjp_skdp . '"
										WHERE PENUNJANG_TARIF_ID =  "' . $tarif_id . '"') or die(mysql_error());
								$sql_penunjang_id = 'SELECT PENUNJANG_ID FROM t_ipenunjang_tarif WHERE PENUNJANG_TARIF_ID =  "' . $tarif_id . '"';
								$get_penunjang_id = mysql_query($sql_penunjang_id) or die(mysql_error());
								$dat_penunjang_id = mysql_fetch_assoc($get_penunjang_id);
								$penunjang_id = $dat_penunjang_id['PENUNJANG_ID'];
							
						}	
					$l++;
					}
			}		
			
			if(isset($_POST['tarif1'])){
				$tarif_id = $_POST['tarif1'];

					mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,UNIT_PENUNJANG_ID,TARIF_ID,KUANTITI,TANGGAL_DAFTAR,ST_BAYAR,
							NO_TARIF,NO_SJP,NO_PEMBAYARAN,SHIFT_PENDAFTARAN,USER_PENDAFTARAN,ST_TPP,NO_SEP,TANGGAL_SEP,
							NO_PESERTA,JKN_TGL_RUJUK,JKN_NO_RUJUK,JKN_KD_PKK,JKN_NAMA_PKK,JKN_CATATAN,JKN_DIAGNOSA,
							JKN_POLIKLINIK,JKN_KELAS_RAWAT,JKN_PBI_NONPBI,JENIS_BAYAR_ID,PEGAWAI_PERIKSA_ID,
							JKN_ASAL_RUJUKAN,JKN_COB,JKN_KATARAK,JKN_NOSURAT_SKDP,JKN_DPJP_SKDP,
							JKN_NAMA_DPJP_SKDP,JKN_SPESIALISASI_DPJP_SKDP,ST_PRINT)
							VALUES("' . $penunjang_id . '","' . $unit_id . '","' . $tarif_id . '",
							1,NOW(),' . $st_bayar . ',"' . $nomor . '","' . $no_sjp . '",
							' . $no_bayar . ',"' . $_SESSION['SES_SIMRS_SHIFT'] . '","' . $reg_user . '","1",
							"' . $no_sep . '",' . fieldDate($tanggal_sep) . ',
							"' . $no_peserta . '",' . fieldDate($jkn_tgl_rujuk) . ',"' . $jkn_no_rujuk . '","' . $jkn_kd_pkk . '",
							"' . $jkn_nama_pkk . '","' . $jkn_catatan . '","' . $jkn_diagnosa . '","' . $jkn_poliklinik . '",
							"' . $jkn_kelas_rawat . '","' . $jkn_pbi_nonpbi . '",
							"' . $jenis_bayar_id . '","' . $pegawai_id . '",
							"' . $jkn_asal_rujukan . '","' . $jkn_cob . '",
							"' . $jkn_katarak . '","' . $jkn_nosurat_skdp . '",
							"' . $jkn_dpjp_skdp . '","' . $jkn_nama_dpjp_skdp . '",
							"' . $jkn_spesialis_dpjp_skdp . '","1")') or die(mysql_error());
		?>
		<script language="JavaScript" >
		var p_sjp = 'no';
		var p_sep = 'no';
		if(confirm('Print Juga SJP?')){
		 p_sjp = 'yes';
		}
		
		<?php if($jenis_bayar_id == '12'){ ?>
			if(confirm('Print Juga SEP?')){
				p_sep = 'yes';
			}
		<?php } ?>
		
		<?php if($penunjang_id != ''){ ?>
			window.open('http://localhost/nsimrs_print/print_pembayaran_karcis_penunjang.php?idx=<?php echo $rawat_id; ?>&no=<?php echo $nomor; ?>&sjp=' + p_sjp + '&jn=<?php echo $jns_t; ?>&sep=' + p_sep,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
			window.location = "index.php?link=<?php echo md5('pendaftaranlistpenunjang'); ?>&idx=<?php echo $rawat_id; ?>&no=<?php echo $nomor; ?>&opt=1";
		<?php }else{ ?>
			window.open('http://localhost/nsimrs_print/print_pembayaran_karcis_penunjang.php?idx=<?php echo $rawat_id; ?>&no=<?php echo $nomor; ?>&sjp=' + p_sjp + '&jn=<?php echo $jns_t; ?>&sep=' + p_sep,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
			window.location = "index.php?link=<?php echo md5('pendaftaranlistpenunjang'); ?>&idx=<?php echo $rawat_id; ?>&no=<?php echo $nomor; ?>&opt=1";
		<?php } ?>
		</script>
		<?php	
				
			}*/ 
		}else{
			//ubah sep aja
			$nomor = $no;
			$cnt_p = $_POST['cnt_p'];
			$l = 1;
			while($l < $cnt_p){
				if(isset($_POST['tarif' . $l])){
					$tarif_id = $_POST['tarif' . $l];
					mysql_query('UPDATE t_ipenunjang_tarif SET SHIFT_PENDAFTARAN = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
										USER_PENDAFTARAN = "' . $reg_user . '",
										NO_SEP = "' . $no_sep . '",
										TANGGAL_SEP = ' . fieldDate($tanggal_sep) . ',
										NO_PESERTA = "' . $no_peserta . '",
										JKN_TGL_RUJUK = ' . fieldDate($jkn_tgl_rujuk) . ',
										JKN_NO_RUJUK = "' . $jkn_no_rujuk . '",
										JKN_KD_PKK = "' . $jkn_kd_pkk . '",
										JKN_NAMA_PKK = "' . $jkn_nama_pkk . '",
										JKN_CATATAN = "' . $jkn_catatan . '",
										JKN_DIAGNOSA = "' . $jkn_diagnosa . '",
										JKN_POLIKLINIK = "' . $jkn_poliklinik . '",
										JKN_KELAS_RAWAT = "' . $jkn_kelas_rawat . '",
										JKN_PBI_NONPBI = "' . $jkn_pbi_nonpbi . '",
										JKN_ASAL_RUJUKAN = "' . $jkn_asal_rujukan . '",
										JKN_COB = "' . $jkn_cob . '",
										JKN_KATARAK = "' . $jkn_katarak . '",
										JKN_NOSURAT_SKDP = "' . $jkn_nosurat_skdp . '",
										JKN_DPJP_SKDP = "' . $jkn_dpjp_skdp . '",
										JKN_NAMA_DPJP_SKDP = "' . $jkn_nama_dpjp_skdp . '",
										JKN_SPESIALISASI_DPJP_SKDP = "' . $jkn_spesialis_dpjp_skdp . '"
										WHERE PENUNJANG_TARIF_ID =  "' . $tarif_id . '"') or die(mysql_error());
					$sql_penunjang_id = 'SELECT PENUNJANG_ID FROM t_ipenunjang_tarif WHERE PENUNJANG_TARIF_ID =  "' . $tarif_id . '"';
					$get_penunjang_id = mysql_query($sql_penunjang_id) or die(mysql_error());
					$dat_penunjang_id = mysql_fetch_assoc($get_penunjang_id);
					$penunjang_id = $dat_penunjang_id['PENUNJANG_ID'];					
				}	
			$l++;
			}
		?>
		<script>
		var p_sjp = 'no';
		var p_sep = 'no';
		if(confirm('Print Juga SJP?')){
		 p_sjp = 'yes';
		}
		
		<?php if($jenis_bayar_id == '12'){ ?>
			if(confirm('Print Juga SEP?')){
				p_sep = 'yes';
			}
		<?php } ?>
		
		window.open('http://localhost/nsimrs_print/print_pembayaran_karcis_penunjang_edit.php?idx=<?php echo $rawat_id; ?>&no=<?php echo $_GET['no']; ?>&sjp=' + p_sjp + '&jn=1&sep=' + p_sep,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
		window.location = "index.php?link=<?php echo md5('pendaftaranlistpenunjang'); ?>&idx=<?php echo $rawat_id; ?>&no=<?php echo $nomor; ?>&opt=1";
		</script>
		<?php	
		}	 
	}	

} else {
    $msg_info = $_err;
}
?>