<?php
$_err = '';
$irna_id = $_POST['irna_id'];
$morse_fall_scale_id = $_POST['morse_fall_scale_id'];
$user_name = currentUser();

$sql_cek_no_rawat = 'SELECT ST_ASKEP FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
$get_cek_no_rawat = mysql_query($sql_cek_no_rawat) or die(mysql_error());
$dat_cek_no_rawat = mysql_fetch_assoc($get_cek_no_rawat);
if (empty($dat_cek_no_rawat['ST_ASKEP'])  or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
	if (empty($_err)) {
	
	$riwayat_jatuh = '';
	$diagnosis_sekunder = '';
	$alat_bantu = '';
	$terpasang_infus = '';
	$gaya_berjalan = '';
	$status_mental = '';
	$perawat = '';
	
	for($i=1;$i<11;$i++){
		if(isset($_POST['riwayat_jatuh_' . $i])) {
			$riwayat_jatuh = $riwayat_jatuh . $_POST['riwayat_jatuh_' . $i] . '|';
		}else{
			$riwayat_jatuh = $riwayat_jatuh . '|';
		}

		if(isset($_POST['diagnosis_sekunder_' . $i])) {
			$diagnosis_sekunder = $diagnosis_sekunder . $_POST['diagnosis_sekunder_' . $i] . '|';
		}else{
			$diagnosis_sekunder = $diagnosis_sekunder . '|';
		}	
		
		if(isset($_POST['alat_bantu_' . $i])) {
			$alat_bantu = $alat_bantu . $_POST['alat_bantu_' . $i] . '|';
		}else{
			$alat_bantu = $alat_bantu . '|';
		}	
		
		if(isset($_POST['terpasang_infus_' . $i])) {
			$terpasang_infus = $terpasang_infus . $_POST['terpasang_infus_' . $i] . '|';
		}else{
			$terpasang_infus = $terpasang_infus . '|';
		}

		if(isset($_POST['gaya_berjalan_' . $i])) {
			$gaya_berjalan = $gaya_berjalan . $_POST['gaya_berjalan_' . $i] . '|';
		}else{
			$gaya_berjalan = $gaya_berjalan . '|';
		}

		if(isset($_POST['status_mental_' . $i])) {
			$status_mental = $status_mental . $_POST['status_mental_' . $i] . '|';
		}else{
			$status_mental = $status_mental . '|';
		}	
		
		if(isset($_POST['perawat_' . $i])) {
			$perawat = $perawat . $_POST['perawat_' . $i] . '|';
		}else{
			$perawat = $perawat . '|';
		}	
	}	

	if(empty($morse_fall_scale_id)){
		mysql_query('INSERT INTO t_irna_askep_morse_fall_scale (MORSE_FALL_SCALE_ID,RIWAYAT_JATUH,DIAGNOSIS_SEKUNDER,ALAT_BANTU,
					TERPASANG_INFUS,GAYA_BERJALAN,STATUS_MENTAL,USER_ASKEP,PERAWAT) VALUES ("'.$irna_id.'",
					"'.$riwayat_jatuh.'","'.$diagnosis_sekunder.'","'.$alat_bantu.'","'.$terpasang_infus.'","'.$gaya_berjalan.'",
					"'.$status_mental.'","'.$user_name.'","'.$perawat.'")') or die(mysql_error());
	}else{
		mysql_query('UPDATE t_irna_askep_morse_fall_scale SET RIWAYAT_JATUH = "'.$riwayat_jatuh.'",
					DIAGNOSIS_SEKUNDER = "'.$diagnosis_sekunder.'",
					ALAT_BANTU = "'.$alat_bantu.'",
					TERPASANG_INFUS = "'.$terpasang_infus.'",
					GAYA_BERJALAN = "'.$gaya_berjalan.'",
					STATUS_MENTAL = "'.$status_mental.'",
					USER_ASKEP = "'.$user_name.'",
					PERAWAT = "'.$perawat.'"
					WHERE MORSE_FALL_SCALE_ID = "'.$morse_fall_scale_id.'"') or die(mysql_error());
	}
	
?>
<script language="JavaScript" >
	alert('Simpan Data Morse Fall Scale Berhasil.');
	window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=mfsc&idx=<?php echo $_GET['idx']; ?>";
</script>
<?php		
		}else{
			$msg_info = $_err;
		}
	}
?>