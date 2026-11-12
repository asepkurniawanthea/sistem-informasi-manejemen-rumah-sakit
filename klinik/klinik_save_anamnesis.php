<?php
$irja_id = $_POST['irja_id'];
if(isset($_POST['anamnesis'])){
	$anamnesis = $_POST['anamnesis'];
}else if(isset($_POST['p_anamnesis_1'])){
	
	$l = 1;
	$anamnesis = '';
	while($l <= 4){
		$anamnesis = $anamnesis . $_POST['p_anamnesis_' . $l] . '|*|';	
		$l++;
	}
}	

if(isset($_POST['pemeriksaan_fisik'])){
	$pemeriksaan_fisik = $_POST['pemeriksaan_fisik'];	
}else if(isset($_POST['p_fisik_1'])){
	
	$y = 1;
	$pemeriksaan_fisik = '';
	while($y <= 62){
		if(isset($_POST['p_fisik_' . $y])){
			$pemeriksaan_fisik = $pemeriksaan_fisik . $_POST['p_fisik_' . $y] . '|*|';  
			$p_fisik[$y] = $_POST['p_fisik_' . $y];
		}else{
			$pemeriksaan_fisik = $pemeriksaan_fisik . '|*|';
		}
	$y++;
	}
}

$pemeriksaan_penunjang = $_POST['pemeriksaan_penunjang'];
$status_lokalis = $_POST['status_lokalis'];
$user_name = currentUser();

$_err = '';
/*$anam = $anamnesis . $pemeriksaan_fisik . $pemeriksaan_penunjang . $status_lokalis;
if (empty($anam))
    $_err = $_err . 'Anamnesis Harus Diisi. \n';*/

if (empty($_err)) {
		$sql_cek_no_klinik = 'SELECT NO_KLINIK FROM t_irja WHERE IRJA_ID = "' . $irja_id . '"';
		$get_cek_no_klinik = mysql_query($sql_cek_no_klinik) or die(mysql_error());
		$dat_cek_no_klinik = mysql_fetch_assoc($get_cek_no_klinik);
		if (empty($dat_cek_no_klinik['NO_KLINIK']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {	
			mysql_query('UPDATE t_irja SET ANAMNESIS = "' . $anamnesis . '", PEMERIKSAAN_FISIK = "' . $pemeriksaan_fisik . '",
				PEMERIKSAAN_PENUNJANG = "' . $pemeriksaan_penunjang . '",STATUS_LOKALIS = "' . $status_lokalis . '",
				USER_IRJA = "' . $user_name . '"
				WHERE IRJA_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());	
		}	
?>
<script language="JavaScript" >
	alert('Simpan Data Anamnesis Berhasil.');
	window.location = "<?php echo currentUrl(); ?>";
</script>
<?php		
} else {
    $msg_info = $_err;
	}
?>