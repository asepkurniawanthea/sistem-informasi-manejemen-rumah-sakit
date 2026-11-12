<?php
$_err = '';
$irja_id = $_POST['irja_id'];
$user_name = currentUser();
$jenis_bayar_id = $_POST['jenis_bayar_id'];
$nomr = $_POST['nomr'];

$_err = '';
if (isset($_POST['simpan'])) {
		if(empty($jns_order)){
			//
			$qry_tmp = 'SELECT * FROM t_ipenunjang WHERE RAWAT_ID = "' . $irja_id . '" 
			AND JNS_PENUNJANG = "RAD" 
			AND JNS_ORDER = "' . $jnsp . '" AND HEMODIALISA_ID IS NULL';
			$get_tmp = mysql_query($qry_tmp);
			if (mysql_num_rows($get_tmp) == 0)
				$_err = 'Radiologi Harus Diisi. \n';
		
    		$sql_cek_no_klinik = 'SELECT NO_KLINIK FROM t_irja WHERE IRJA_ID = "' . $irja_id . '"';
			$deskripsi = 'Radiologi (Poliklinik)';	
			$get_cek_no_klinik = mysql_query($sql_cek_no_klinik) or die(mysql_error());
			$dat_cek_no_klinik = mysql_fetch_assoc($get_cek_no_klinik);
			if (empty($dat_cek_no_klinik['NO_KLINIK'])  or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
				$nomor_order = getNomorBulanan('IPENUNJANG');
				$no_bayar = 'NULL';
				$st_bayar = 'NULL';
				if($jenis_bayar_id <> '1'){
					$no_bayar = '"' . getNomorHarian('Kasir') . '"';
					$st_bayar = '"Lunas"';
				}
				$nomor = getNomorHarian('Tarif');
				$no_sjp = getNomorHarian('SJP');
		
				$penunjang_id = '';
				$reg_user = $user_name;
				$tgl_daftar = getNow();
			
				$sql_penj_id = 'SELECT PENUNJANG_ID FROM t_ipenunjang
							WHERE RAWAT_ID = "' . $irja_id . '" 
							AND t_ipenunjang.JNS_PENUNJANG = "RAD" 
							AND t_ipenunjang.JNS_ORDER = "IRJ"
							AND NO_ORDER IS NULL';
				$get_penj_id = mysql_query($sql_penj_id) or die(mysql_error());
				while($dat_penj_id = mysql_fetch_array($get_penj_id)){
					$penj_id = $dat_penj_id['PENUNJANG_ID']; 
					mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_DAFTAR = "' . $tgl_daftar . '",
							UNIT_PENUNJANG_ID = "17",
							ST_BAYAR = ' . $st_bayar . ',NO_TARIF = "' . $nomor . '",NO_SJP = "' . $no_sjp . '",
							NO_PEMBAYARAN = ' . $no_bayar . ',
							USER_PENDAFTARAN = "' . $reg_user . '",
							JENIS_BAYAR_ID = "' . $jenis_bayar_id . '"
							WHERE PENUNJANG_ID =  "' . $penj_id . '"') or die(mysql_error());
				}	
			
				mysql_query('UPDATE t_ipenunjang SET NO_ORDER = "' . $nomor_order . '", 
					DESKRIPSI = "' . $deskripsi . '",PEGAWAI_ID = (SELECT PEGAWAI_ID FROM t_irja WHERE IRJA_ID = "' . $irja_id . '"),
					NOMR = "' . $nomr . '",TANGGAL_ORDER = NOW(),
					UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '",JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
					USER_ORDER = "' . $user_name . '"
					WHERE RAWAT_ID = "' . $irja_id . '" 
					AND t_ipenunjang.JNS_PENUNJANG = "RAD" 
					AND t_ipenunjang.JNS_ORDER = "IRJ"
					AND NO_ORDER IS NULL') or die(mysql_error());	
			}		
			//
		}else{
			//
			$qry_tmp = 'SELECT * FROM t_ipenunjang WHERE RAWAT_ID = "' . $idxord . '" AND JNS_PENUNJANG = "RAD" AND JNS_ORDER = "' . $jnsp . '" AND HEMODIALISA_ID = "' . $irja_id . '"';
			$get_tmp = mysql_query($qry_tmp);
			if (mysql_num_rows($get_tmp) == 0)
				$_err = 'Radiologi Harus Diisi. \n';
				$sql_cek_no_klinik = 'SELECT NO_KLINIK FROM t_hemodialisa WHERE HEMODIALISA_ID = "' . $irja_id . '"';
				$deskripsi = 'Radiologi (Hemodialisa)';
				$get_cek_no_klinik = mysql_query($sql_cek_no_klinik) or die(mysql_error());
				$dat_cek_no_klinik = mysql_fetch_assoc($get_cek_no_klinik);
				if (empty($dat_cek_no_klinik['NO_KLINIK'])  or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
					$nomor_order = getNomorBulanan('IPENUNJANG');
					mysql_query('UPDATE t_ipenunjang SET NO_ORDER = "' . $nomor_order . '", 
						DESKRIPSI = "' . $deskripsi . '",PEGAWAI_ID = (SELECT PEGAWAI_PERIKSA_ID FROM t_hemodialisa WHERE HEMODIALISA_ID = "' . $irja_id . '"),
						NOMR = "' . $nomr . '",TANGGAL_ORDER = NOW(),
						UNIT_ID = (SELECT UNIT_ID FROM t_hemodialisa WHERE HEMODIALISA_ID = "' . $irja_id . '"),
						RAWAT_ID = (SELECT RAWAT_ID FROM t_hemodialisa WHERE HEMODIALISA_ID = "' . $irja_id . '"),
						RUANG_ID = (SELECT RUANG_ID FROM t_hemodialisa WHERE HEMODIALISA_ID = "' . $irja_id . '"),
						KELAS_RAWAT = (SELECT KELAS_RAWAT FROM t_hemodialisa WHERE HEMODIALISA_ID = "' . $irja_id . '"),
						JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
						USER_ORDER = "' . $user_name . '"
						WHERE RAWAT_ID = "' . $idxord . '" 
						AND t_ipenunjang.JNS_PENUNJANG = "RAD" AND t_ipenunjang.JNS_ORDER = "' . $jnsp . '"
						AND t_ipenunjang.HEMODIALISA_ID = "' . $irja_id . '"') or die(mysql_error());
				
				$no_bayar = 'NULL';
				$st_bayar = 'NULL';
				if($jenis_bayar_id <> '1'){
					$no_bayar = '"' . getNomorHarian('Kasir') . '"';
					$st_bayar = '"Lunas"';
				}
				$nomor = getNomorHarian('Tarif');
				$no_sjp = getNomorHarian('SJP');
			
				$penunjang_id = '';
				$reg_user = $user_name;
				$tgl_daftar = getNow();
				
				$sql_penj_id = 'SELECT PENUNJANG_ID FROM t_ipenunjang
								WHERE RAWAT_ID = "' . $idxord . '" 
								AND t_ipenunjang.JNS_PENUNJANG = "RAD" AND t_ipenunjang.JNS_ORDER = "' . $jnsp . '"
								AND t_ipenunjang.HEMODIALISA_ID = "' . $irja_id . '"
								AND NO_ORDER = "' . $nomor_order . '"';
				$get_penj_id = mysql_query($sql_penj_id) or die(mysql_error());
				while($dat_penj_id = mysql_fetch_array($get_penj_id)){
					$penj_id = $dat_penj_id['PENUNJANG_ID']; 
					mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_DAFTAR = "' . $tgl_daftar . '",
								UNIT_PENUNJANG_ID = "17",
								ST_BAYAR = ' . $st_bayar . ',NO_TARIF = "' . $nomor . '",NO_SJP = "' . $no_sjp . '",
								NO_PEMBAYARAN = ' . $no_bayar . ',
								USER_PENDAFTARAN = "' . $reg_user . '",
								JENIS_BAYAR_ID = "' . $jenis_bayar_id . '"
								WHERE PENUNJANG_ID =  "' . $penj_id . '"') or die(mysql_error());
				}
			}			
			//
		}
	
	if(empty($_err)){
?>
<script language="JavaScript" >
	alert('Simpan Data Order Radiologi Berhasil.');
	window.location = "<?php echo currentUrl(); ?>";
</script>
<?php		
	}else{
		$msg_info = $_err;
	}
}
?>