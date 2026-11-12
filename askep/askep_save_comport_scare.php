<?php
$_err = '';
$irna_id = $_POST['irna_id'];
$comport_scale_id = $_POST['comport_scale_id'];
$user_name = currentUser();

$sql_cek_no_rawat = 'SELECT ST_ASKEP FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
$get_cek_no_rawat = mysql_query($sql_cek_no_rawat) or die(mysql_error());
$dat_cek_no_rawat = mysql_fetch_assoc($get_cek_no_rawat);
if (empty($dat_cek_no_rawat['ST_ASKEP'])  or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
	if (empty($_err)) {
	
	$kewaspadaan ='';
	$ketenangan ='';
	$distres_pernapasan ='';
	$menangis ='';
	$pergerakan ='';
	$tonus_otot ='';
	$tegangan_wajah ='';
	$tekanan_darah_basah ='';
	$perawat ='';
	$tanggal ='';
	
	for($i=1;$i<6;$i++){
		if(isset($_POST['kewaspadaan_' . $i])) {
			$kewaspadaan = $kewaspadaan . $_POST['kewaspadaan_' . $i] . '|';
		}else{
			$kewaspadaan = $kewaspadaan . '|';
		}
		
		if(isset($_POST['ketenangan_' . $i])) {
			$ketenangan = $ketenangan . $_POST['ketenangan_' . $i] . '|';
		}else{
			$ketenangan = $ketenangan . '|';
		}
		
		if(isset($_POST['distres_pernapasan_' . $i])) {
			$distres_pernapasan = $distres_pernapasan . $_POST['distres_pernapasan_' . $i] . '|';
		}else{
			$distres_pernapasan = $distres_pernapasan . '|';
		}
		
		if(isset($_POST['menangis_' . $i])) {
			$menangis = $menangis . $_POST['menangis_' . $i] . '|';
		}else{
			$menangis = $menangis . '|';
		}
		
		if(isset($_POST['pergerakan_' . $i])) {
			$pergerakan = $pergerakan . $_POST['pergerakan_' . $i] . '|';
		}else{
			$pergerakan = $pergerakan . '|';
		}
		
		if(isset($_POST['tonus_otot_' . $i])) {
			$tonus_otot = $tonus_otot . $_POST['tonus_otot_' . $i] . '|';
		}else{
			$tonus_otot = $tonus_otot . '|';
		}
		
		if(isset($_POST['tegangan_wajah_' . $i])) {
			$tegangan_wajah = $tegangan_wajah . $_POST['tegangan_wajah_' . $i] . '|';
		}else{
			$tegangan_wajah = $tegangan_wajah . '|';
		}
		
		if(isset($_POST['tekanan_darah_basah_' . $i])) {
			$tekanan_darah_basah = $tekanan_darah_basah . $_POST['tekanan_darah_basah_' . $i] . '|';
		}else{
			$tekanan_darah_basah = $tekanan_darah_basah . '|';
		}
		
		if(isset($_POST['perawat_' . $i])) {
			$perawat = $perawat . $_POST['perawat_' . $i] . '|';
		}else{
			$perawat = $perawat . '|';
		}
		
		if(isset($_POST['tanggal_' . $i])) {
			$tanggal = $tanggal . $_POST['tanggal_' . $i] . '|';
		}else{
			$tanggal = $tanggal . '|';
		}
	}	

	if(empty($comport_scale_id)){
		mysql_query('INSERT INTO t_irna_askep_comport_scale (COMPORT_SCALE_ID,KEWASPADAAN,KETENANGAN,DISTRES_PERNAPASAN,MENANGIS,PERGERAKAN,TONUS_OTOT,
					TEGANGAN_WAJAH,TEKANAN_DARAH_BASAH,TANGGAL,PERAWAT,USER_ASKEP) VALUES ("'.$irna_id.'","'.$kewaspadaan.'",
					"'.$ketenangan.'","'.$distres_pernapasan.'","'.$menangis.'","'.$pergerakan.'","'.$tonus_otot.'",
					"'.$tegangan_wajah.'","'.$tekanan_darah_basah.'","'.$tanggal.'","'.$perawat.'","'.$user_name.'")') or die(mysql_error());
	}else{
		mysql_query('UPDATE t_irna_askep_comport_scale SET KEWASPADAAN = "'.$kewaspadaan.'",
					KETENANGAN = "'.$ketenangan.'",DISTRES_PERNAPASAN = "'.$distres_pernapasan.'",MENANGIS = "'.$menangis.'",
					PERGERAKAN = "'.$pergerakan.'",TONUS_OTOT = "'.$tonus_otot.'",TEGANGAN_WAJAH = "'.$tegangan_wajah.'",
					TEKANAN_DARAH_BASAH = "'.$tekanan_darah_basah.'",TANGGAL = "'.$tanggal.'",PERAWAT = "'.$perawat.'",USER_ASKEP = "'.$user_name.'"
					WHERE COMPORT_SCALE_ID = "'.$comport_scale_id.'"') or die(mysql_error());
	}
	
?>
<script language="JavaScript" >
	alert('Simpan Data Comport Scale Berhasil.');
	window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=cpsc&idx=<?php echo $_GET['idx']; ?>";
</script>
<?php		
		}else{
			$msg_info = $_err;
		}
	}
?>