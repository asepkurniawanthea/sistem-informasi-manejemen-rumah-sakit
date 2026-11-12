<?php
$_err = '';
$irja_id = $_POST['irja_id'];
$user_name = currentUser();
$jenis_bayar_id = $_POST['jenis_bayar_id'];

$sql_jenis_bayar = 'SELECT PEGAWAI_ID,JENIS_BAYAR_ID FROM t_irja WHERE IRJA_ID = "' . $irja_id . '"';
$get_jenis_bayar = mysql_query($sql_jenis_bayar) or die(mysql_error());
$dat_jenis_bayar = mysql_fetch_assoc($get_jenis_bayar);
$jenis_bayar_id = $dat_jenis_bayar['JENIS_BAYAR_ID'];
$pegawai_id = $dat_jenis_bayar['PEGAWAI_ID'];
$tanggal = '';
if(currentModul() == 'igd') $tanggal = $_POST['tanggal'] . ' ' . $_POST['jam'] . ':' . $_POST['menit'];

if (isset($_POST['simpan'])) {
    $_err = '';
	if (empty($_err)) {
		$no_bayar = 'NULL';
		$st_bayar = 'NULL';
		if(!in_array($jenis_bayar_id,getArrNonJaminan())){
			$no_bayar = '"' . getNomorHarian('Kasir') . '"';
			$st_bayar = '"Lunas"';
		}
		$deskripsi = 'Tindakan Di Poliklinik';
		if (currentModul() == 'igd') $deskripsi = 'Tindakan Di IGD';
		$nomor = getNomorHarian('Tarif');
		
		mysql_query('UPDATE t_irja_tarif SET NO_TARIF = "' . $nomor . '", 
					' . ((currentModul() == 'igd') ? 'TGL_TARIF = ' . fieldDatetime($tanggal) . ',' : '') . '
					NO_PEMBAYARAN = ' . $no_bayar . ',
					ST_BAYAR = ' . $st_bayar . ',
					JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
					USER_PENDAFTARAN = "' . $user_name . '"
					WHERE IRJA_ID = "' . $irja_id . '" AND NO_TARIF IS NULL
					AND DESKRIPSI = "' . $deskripsi . '"') or die(mysql_error());
		mysql_query('UPDATE t_irja SET USER_IRJA = "' . $user_name . '" 
					WHERE IRJA_ID = "' . $irja_id . '"') or die(mysql_error());
					
		$sql_cek_paket = 'SELECT * FROM t_irja_tarif
						WHERE IRJA_ID = "' . $irja_id . '" 
						AND NO_TARIF IS NULL
						AND DESKRIPSI = "Paket Skrining Covid-19"';
		$get_cek_paket = mysql_query($sql_cek_paket) or die(mysql_error());
		if(mysql_num_rows($get_cek_paket) > 0){
			$no_bayar = 'NULL';
			$st_bayar = 'NULL';
			if(!in_array($jenis_bayar_id,getArrNonJaminan())){
				$no_bayar = '"' . getNomorHarian('Kasir') . '"';
				$st_bayar = '"Lunas"';
			}
			$nomor = getNomorHarian('Tarif');	
			$no_sjp = getNomorHarian('SJP');
			$nomor_order = getNomorBulanan('IPENUNJANG');
			mysql_query('UPDATE t_irja_tarif SET NO_TARIF = "' . $nomor . '", 
					NO_PEMBAYARAN = ' . $no_bayar . ',
					ST_BAYAR = ' . $st_bayar . ',
					JENIS_BAYAR_ID = "' . $jenis_bayar_id . '"
					WHERE IRJA_ID = "' . $irja_id . '" 
					AND NO_TARIF IS NULL
					AND DESKRIPSI = "Paket Skrining Covid-19"') or die(mysql_error());
					
			$sql_penj_id = 'SELECT PENUNJANG_ID FROM t_ipenunjang
							WHERE RAWAT_ID = "' . $irja_id . '" 
							AND t_ipenunjang.JNS_PENUNJANG = "LAB" 
							AND t_ipenunjang.JNS_ORDER = "IRJ"
							AND NO_ORDER IS NULL
							AND DESKRIPSI = "Paket Skrining Covid-19"';
			$get_penj_id = mysql_query($sql_penj_id) or die(mysql_error());
			while($dat_penj_id = mysql_fetch_array($get_penj_id)){
				$penj_id = $dat_penj_id['PENUNJANG_ID']; 
				mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_DAFTAR = NOW(),
							UNIT_PENUNJANG_ID = "45",
							ST_BAYAR = ' . $st_bayar . ',NO_TARIF = "' . $nomor . '",NO_SJP = "' . $no_sjp . '",
							NO_PEMBAYARAN = ' . $no_bayar . ',JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
							USER_PENDAFTARAN = "' . $user_name . '"
							WHERE PENUNJANG_ID =  "' . $penj_id . '"') or die(mysql_error());
			}	
			
			mysql_query('UPDATE t_ipenunjang SET NO_ORDER = "' . $nomor_order . '", 
					PEGAWAI_ID = "' . $pegawai_id . '",
					NOMR = "' . $nomr . '",TANGGAL_ORDER = NOW(),
					UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '",
					JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",USER_ORDER = "' . $user_name . '"
					WHERE RAWAT_ID = "' . $irja_id . '" 
					AND t_ipenunjang.JNS_PENUNJANG = "LAB" 
					AND t_ipenunjang.JNS_ORDER = "IRJ"
					AND NO_ORDER IS NULL
					AND DESKRIPSI = "Paket Skrining Covid-19"') or die(mysql_error());	

			$sql_penj_id = 'SELECT PENUNJANG_ID FROM t_ipenunjang
							WHERE RAWAT_ID = "' . $irja_id . '" 
							AND t_ipenunjang.JNS_PENUNJANG = "RAD" 
							AND t_ipenunjang.JNS_ORDER = "IRJ"
							AND NO_ORDER IS NULL
							AND DESKRIPSI = "Paket Skrining Covid-19"';
			$get_penj_id = mysql_query($sql_penj_id) or die(mysql_error());
			while($dat_penj_id = mysql_fetch_array($get_penj_id)){
				$penj_id = $dat_penj_id['PENUNJANG_ID']; 
				mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_DAFTAR = NOW(),
							UNIT_PENUNJANG_ID = "17",
							ST_BAYAR = ' . $st_bayar . ',NO_TARIF = "' . $nomor . '",NO_SJP = "' . $no_sjp . '",
							NO_PEMBAYARAN = ' . $no_bayar . ',JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
							USER_PENDAFTARAN = "' . $user_name . '"
							WHERE PENUNJANG_ID =  "' . $penj_id . '"') or die(mysql_error());
			}	
			
			mysql_query('UPDATE t_ipenunjang SET NO_ORDER = "' . $nomor_order . '", 
					PEGAWAI_ID = "' . $pegawai_id . '",
					NOMR = "' . $nomr . '",TANGGAL_ORDER = NOW(),
					UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '",
					JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",USER_ORDER = "' . $user_name . '"
					WHERE RAWAT_ID = "' . $irja_id . '" 
					AND t_ipenunjang.JNS_PENUNJANG = "RAD" 
					AND t_ipenunjang.JNS_ORDER = "IRJ"
					AND NO_ORDER IS NULL
					AND DESKRIPSI = "Paket Skrining Covid-19"') or die(mysql_error());	

			$sql_penj_id = 'SELECT PENUNJANG_ID FROM t_ipenunjang
							WHERE RAWAT_ID = "' . $irja_id . '" 
							AND t_ipenunjang.JNS_PENUNJANG = "EKG" 
							AND t_ipenunjang.JNS_ORDER = "IRJ"
							AND NO_ORDER IS NULL
							AND DESKRIPSI = "Paket Skrining Covid-19"';
			$get_penj_id = mysql_query($sql_penj_id) or die(mysql_error());
			while($dat_penj_id = mysql_fetch_array($get_penj_id)){
				$penj_id = $dat_penj_id['PENUNJANG_ID']; 
				mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_DAFTAR = NOW(),
							UNIT_PENUNJANG_ID = "52",
							ST_BAYAR = ' . $st_bayar . ',NO_TARIF = "' . $nomor . '",NO_SJP = "' . $no_sjp . '",
							NO_PEMBAYARAN = ' . $no_bayar . ',JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
							USER_PENDAFTARAN = "' . $user_name . '"
							WHERE PENUNJANG_ID =  "' . $penj_id . '"') or die(mysql_error());
			}	
			
			mysql_query('UPDATE t_ipenunjang SET NO_ORDER = "' . $nomor_order . '", 
					PEGAWAI_ID = "' . $pegawai_id . '",
					NOMR = "' . $nomr . '",TANGGAL_ORDER = NOW(),
					UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '",
					JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",USER_ORDER = "' . $user_name . '"
					WHERE RAWAT_ID = "' . $irja_id . '" 
					AND t_ipenunjang.JNS_PENUNJANG = "EKG" 
					AND t_ipenunjang.JNS_ORDER = "IRJ"
					AND NO_ORDER IS NULL
					AND DESKRIPSI = "Paket Skrining Covid-19"') or die(mysql_error());	

			include('lis/simrs2lis.php');
			lis_create_order($irja_id,$nomor_order,'IRJ');				
		}			
?>
<script language="JavaScript" >
	alert('Simpan Data Tindakan Berhasil.');
	window.location = "<?php echo currentUrl(); ?>";
</script>
<?php		
		}else{
			$msg_info = $_err;
		}
}
?>