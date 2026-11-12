<?php
$_err = '';
$irja_id = $_POST['idx'];
$user_name = currentUser();
$jenis_bayar_id = $_POST['jenis_bayar_id'];
$jns_order = $_POST['jns_order'];

$_err = '';
if (isset($_POST['simpan'])) {
	
	if(empty($jns_order)){
		if (empty($_err)) {
			$no_bayar = 'NULL';
			$st_bayar = 'NULL';
			if($jenis_bayar_id != '1' and $jenis_bayar_id != '18'){
				$no_bayar = '"' . getNomorHarian('Kasir') . '"';
				$st_bayar = '"Lunas"';
			}
			$deskripsi = 'Tindakan Di Poliklinik';
			$nomor = getNomorHarian('Tarif');
			mysql_query('UPDATE t_irja_tarif SET NO_TARIF = "' . $nomor . '", NO_PEMBAYARAN = ' . $no_bayar . ',
						ST_BAYAR = ' . $st_bayar . ',
						JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
						USER_PENDAFTARAN = "' . $user_name . '"
						WHERE IRJA_ID = "' . $irja_id . '" AND NO_TARIF IS NULL
						AND DESKRIPSI = "' . $deskripsi . '"') or die(mysql_error());
			mysql_query('UPDATE t_irja SET USER_IRJA = "' . $user_name . '" 
						WHERE IRJA_ID = "' . $irja_id . '"') or die(mysql_error());
		}
	}else{
			if (empty($_err)) {
				$no_bayar = 'NULL';
				$st_bayar = 'NULL';
				if($jenis_bayar_id != '1' and $jenis_bayar_id != '18'){
					$no_bayar = '"' . getNomorHarian('Kasir') . '"';
					$st_bayar = '"Lunas"';
				}
				$deskripsi = 'Tindakan Di Hemodialisa';
				$nomor = getNomorHarian('Tarif');
				
				mysql_query('UPDATE t_hemodialisa_tarif SET NO_TARIF = "' . $nomor . '", NO_PEMBAYARAN = ' . $no_bayar . ',
							ST_BAYAR = ' . $st_bayar . ',
							JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
							USER_DIAGNOSA = "' . $user_name . '"
							WHERE HEMODIALISA_ID = "' . $irja_id . '" AND NO_TARIF IS NULL
							AND DESKRIPSI = "' . $deskripsi . '"') or die(mysql_error());
				mysql_query('UPDATE t_hemodialisa SET USER_IRJA = "' . $user_name . '" 
					WHERE HEMODIALISA_ID = "' . $irja_id . '"') or die(mysql_error());
			}	
		}		
if (empty($_err)) {	
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