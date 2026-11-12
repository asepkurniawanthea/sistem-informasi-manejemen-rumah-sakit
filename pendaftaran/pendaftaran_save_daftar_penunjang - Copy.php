<?php
					
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
									JKN_SPESIALISASI_DPJP_SKDP = "' . $jkn_spesialis_dpjp_skdp . '",
									ST_PRINT = "1"
									WHERE PENUNJANG_TARIF_ID =  "' . $tarif_id . '"') or die(mysql_error());
							$sql_penunjang_id = 'SELECT pn.PENUNJANG_ID,pn.NO_ORDER 
												FROM t_ipenunjang_tarif ti 
												INNER JOIN t_ipenunjang pn
												ON (ti.PENUNJANG_ID = pn.PENUNJANG_ID)
												WHERE ti.PENUNJANG_TARIF_ID =  "' . $tarif_id . '"';
							$get_penunjang_id = mysql_query($sql_penunjang_id) or die(mysql_error());
							$dat_penunjang_id = mysql_fetch_assoc($get_penunjang_id);
							$penunjang_id = $dat_penunjang_id['PENUNJANG_ID'];
							$xnomor_order = $dat_penunjang_id['NO_ORDER'];
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
		} 
		
		if($unit_id == '45'){
			include('lis/simrs2lis.php');
			lis_create_order($rawat_id,$xnomor_order,'IRJ');
		}	
		
		
	 ?>
		
		<script language="JavaScript" >
		var p_sjp = 'no';
		var p_sep = 'no';
		//if(confirm('Print Juga SJP?')){
		 p_sjp = 'yes';
		//}
		
		<?php if($jenis_bayar_id == '12'){ ?>
			if(confirm('Print Juga SEP?')){
				p_sep = 'yes';
			}
		<?php } ?>
		
		<?php if($penunjang_id != ''){ ?>
			window.open('http://localhost/nsimrs_print/print_pembayaran_karcis_penunjang.php?idx=<?php echo $rawat_id; ?>&no=<?php echo $nomor; ?>&sjp=' + p_sjp + '&jn=<?php echo $jns_t; ?>&sep=' + p_sep,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
			window.location = "index.php?link=<?php echo md5('pendaftaranviewpenunjang'); ?>&idx=<?php echo $rawat_id; ?>&no=<?php echo $nomor; ?>&opt=1";
		<?php }else{ ?>
			window.open('http://localhost/nsimrs_print/print_pembayaran_karcis_penunjang.php?idx=<?php echo $rawat_id; ?>&no=<?php echo $nomor; ?>&sjp=' + p_sjp + '&jn=<?php echo $jns_t; ?>&sep=' + p_sep,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
			window.location = "index.php?link=<?php echo md5('pendaftaranviewpenunjang'); ?>&idx=<?php echo $rawat_id; ?>&no=<?php echo $nomor; ?>&opt=1";
		<?php } ?>
		</script> 
<?php	}	

} else {
    $msg_info = $_err;
}
?>