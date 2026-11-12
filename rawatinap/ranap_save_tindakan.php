<?php
$_err = '';
$irna_id = $_POST['irna_id'];
$user_name = currentUser();
$jenis_bayar_id = $_POST['jenis_bayar_id'];
$pegawai_id = $_POST['pegawai_id'];
$ruang_id = $_POST['ruang_id'];
$kelas_rawat = $_POST['kelas_rawat'];
$kelas_jaminan = $_POST['kelas_jaminan'];
$tanggal = $_POST['tanggal'] . ' ' . $_POST['jam'] . ':' . $_POST['menit'];

$sql_jenis_bayar = 'SELECT JENIS_BAYAR_ID FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
$get_jenis_bayar = mysql_query($sql_jenis_bayar) or die(mysql_error());
$dat_jenis_bayar = mysql_fetch_assoc($get_jenis_bayar);
$jenis_bayar_id = $dat_jenis_bayar['JENIS_BAYAR_ID'];

if (isset($_POST['simpan'])) {
    $_err = '';
	if (empty($_err)) {
		$no_bayar = 'NULL';
		$st_bayar = 'NULL';
		if(!in_array($jenis_bayar_id,getArrNonJaminan())){
			$no_bayar = '"' . getNomorHarian('Kasir') . '"';
			$st_bayar = '"Lunas"';
		}
		$deskripsi = 'Tindakan (Ruang Rawat)';
		$nomor = getNomorHarian('Tarif');	
					
		if(isset($_POST['ruang_id_tindakan']) and $_POST['ruang_id_tindakan'] != ''){
			mysql_query('UPDATE t_irna_tarif SET NO_TARIF = "' . $nomor . '", NO_PEMBAYARAN = ' . $no_bayar . ',
					PEGAWAI_ID = "' . $pegawai_id . '",
					TGL_TARIF = ' . fieldDatetime($tanggal) . ',
					ST_BAYAR = ' . $st_bayar . ',
					KELAS_JAMINAN = "' . $kelas_jaminan . '",
					JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
					RUANG_ID = "' . $_POST['ruang_id_tindakan'] . '",
					KELAS_RAWAT = (SELECT KELAS_RAWAT FROM m_ruang WHERE RUANG_ID = "' . $_POST['ruang_id_tindakan'] . '")
					WHERE IRNA_ID = "' . $irna_id . '" AND NO_TARIF IS NULL
					AND DESKRIPSI = "' . $deskripsi . '"') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_irna_tarif SET NO_TARIF = "' . $nomor . '", NO_PEMBAYARAN = ' . $no_bayar . ',
					PEGAWAI_ID = "' . $pegawai_id . '",
					TGL_TARIF = ' . fieldDatetime($tanggal) . ',
					ST_BAYAR = ' . $st_bayar . ',
					KELAS_JAMINAN = "' . $kelas_jaminan . '",
					JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
					RUANG_ID = "' . $ruang_id . '"
					WHERE IRNA_ID = "' . $irna_id . '" AND NO_TARIF IS NULL
					AND DESKRIPSI = "' . $deskripsi . '"') or die(mysql_error());
		}		
		mysql_query('UPDATE t_irna SET USER_IRNA = "' . $user_name . '" WHERE IRNA_ID = "' . $irna_id . '"') or die(mysql_error());
		
		$sql_cek_paket = 'SELECT * FROM t_irna_tarif
						WHERE IRNA_ID = "' . $irna_id . '" 
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
			mysql_query('UPDATE t_irna_tarif SET NO_TARIF = "' . $nomor . '", NO_PEMBAYARAN = ' . $no_bayar . ',
					PEGAWAI_ID = "' . $pegawai_id . '",
					TGL_TARIF = ' . fieldDatetime($tanggal) . ',
					ST_BAYAR = ' . $st_bayar . ',
					KELAS_JAMINAN = "' . $kelas_jaminan . '",
					JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
					RUANG_ID = "' . $ruang_id . '"
					WHERE IRNA_ID = "' . $irna_id . '" AND NO_TARIF IS NULL
					AND DESKRIPSI = "Paket Skrining Covid-19"') or die(mysql_error());
					
			$sql_penj_id = 'SELECT PENUNJANG_ID FROM t_ipenunjang
							WHERE RAWAT_ID = "' . $irna_id . '" 
							AND t_ipenunjang.JNS_PENUNJANG = "LAB" 
							AND t_ipenunjang.JNS_ORDER = "IRN"
							AND NO_ORDER IS NULL
							AND DESKRIPSI = "Paket Skrining Covid-19"';
			$get_penj_id = mysql_query($sql_penj_id) or die(mysql_error());
			while($dat_penj_id = mysql_fetch_array($get_penj_id)){
				$penj_id = $dat_penj_id['PENUNJANG_ID']; 
				mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_DAFTAR = ' . fieldDatetime($tanggal) . ',
							UNIT_PENUNJANG_ID = "45",
							ST_BAYAR = ' . $st_bayar . ',NO_TARIF = "' . $nomor . '",NO_SJP = "' . $no_sjp . '",
							NO_PEMBAYARAN = ' . $no_bayar . ',JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
							USER_PENDAFTARAN = "' . $user_name . '"
							WHERE PENUNJANG_ID =  "' . $penj_id . '"') or die(mysql_error());
			}	
			
			mysql_query('UPDATE t_ipenunjang SET NO_ORDER = "' . $nomor_order . '", 
					PEGAWAI_ID = "' . $pegawai_id . '",
					NOMR = "' . $nomr . '",TANGGAL_ORDER = NOW(),
					UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '",RUANG_ID = "' . $ruang_id . '",
					JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",USER_ORDER = "' . $user_name . '"
					WHERE RAWAT_ID = "' . $irna_id . '" 
					AND t_ipenunjang.JNS_PENUNJANG = "LAB" 
					AND t_ipenunjang.JNS_ORDER = "IRN"
					AND NO_ORDER IS NULL
					AND DESKRIPSI = "Paket Skrining Covid-19"') or die(mysql_error());	

			$sql_penj_id = 'SELECT PENUNJANG_ID FROM t_ipenunjang
							WHERE RAWAT_ID = "' . $irna_id . '" 
							AND t_ipenunjang.JNS_PENUNJANG = "RAD" 
							AND t_ipenunjang.JNS_ORDER = "IRN"
							AND NO_ORDER IS NULL
							AND DESKRIPSI = "Paket Skrining Covid-19"';
			$get_penj_id = mysql_query($sql_penj_id) or die(mysql_error());
			while($dat_penj_id = mysql_fetch_array($get_penj_id)){
				$penj_id = $dat_penj_id['PENUNJANG_ID']; 
				mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_DAFTAR = ' . fieldDatetime($tanggal) . ',
							UNIT_PENUNJANG_ID = "17",
							ST_BAYAR = ' . $st_bayar . ',NO_TARIF = "' . $nomor . '",NO_SJP = "' . $no_sjp . '",
							NO_PEMBAYARAN = ' . $no_bayar . ',JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
							USER_PENDAFTARAN = "' . $user_name . '"
							WHERE PENUNJANG_ID =  "' . $penj_id . '"') or die(mysql_error());
			}	
			
			mysql_query('UPDATE t_ipenunjang SET NO_ORDER = "' . $nomor_order . '", 
					PEGAWAI_ID = "' . $pegawai_id . '",
					NOMR = "' . $nomr . '",TANGGAL_ORDER = NOW(),
					UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '",RUANG_ID = "' . $ruang_id . '",
					JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",USER_ORDER = "' . $user_name . '"
					WHERE RAWAT_ID = "' . $irna_id . '" 
					AND t_ipenunjang.JNS_PENUNJANG = "RAD" 
					AND t_ipenunjang.JNS_ORDER = "IRN"
					AND NO_ORDER IS NULL
					AND DESKRIPSI = "Paket Skrining Covid-19"') or die(mysql_error());	

			$sql_penj_id = 'SELECT PENUNJANG_ID FROM t_ipenunjang
							WHERE RAWAT_ID = "' . $irna_id . '" 
							AND t_ipenunjang.JNS_PENUNJANG = "EKG" 
							AND t_ipenunjang.JNS_ORDER = "IRN"
							AND NO_ORDER IS NULL
							AND DESKRIPSI = "Paket Skrining Covid-19"';
			$get_penj_id = mysql_query($sql_penj_id) or die(mysql_error());
			while($dat_penj_id = mysql_fetch_array($get_penj_id)){
				$penj_id = $dat_penj_id['PENUNJANG_ID']; 
				mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_DAFTAR = ' . fieldDatetime($tanggal) . ',
							UNIT_PENUNJANG_ID = "52",
							ST_BAYAR = ' . $st_bayar . ',NO_TARIF = "' . $nomor . '",NO_SJP = "' . $no_sjp . '",
							NO_PEMBAYARAN = ' . $no_bayar . ',JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
							USER_PENDAFTARAN = "' . $user_name . '"
							WHERE PENUNJANG_ID =  "' . $penj_id . '"') or die(mysql_error());
			}	
			
			mysql_query('UPDATE t_ipenunjang SET NO_ORDER = "' . $nomor_order . '", 
					PEGAWAI_ID = "' . $pegawai_id . '",
					NOMR = "' . $nomr . '",TANGGAL_ORDER = NOW(),
					UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '",RUANG_ID = "' . $ruang_id . '",
					JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",USER_ORDER = "' . $user_name . '"
					WHERE RAWAT_ID = "' . $irna_id . '" 
					AND t_ipenunjang.JNS_PENUNJANG = "EKG" 
					AND t_ipenunjang.JNS_ORDER = "IRN"
					AND NO_ORDER IS NULL
					AND DESKRIPSI = "Paket Skrining Covid-19"') or die(mysql_error());	

			include('lis/simrs2lis.php');
			lis_create_order($irna_id,$nomor_order,'IRN');				
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