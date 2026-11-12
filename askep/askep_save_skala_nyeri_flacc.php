<?php
$_err = '';
$irna_id = $_POST['irna_id'];
$flacc_scale_id = $_POST['flacc_scale_id'];
$user_name = currentUser();

$sql_cek_no_rawat = 'SELECT ST_ASKEP FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
$get_cek_no_rawat = mysql_query($sql_cek_no_rawat) or die(mysql_error());
$dat_cek_no_rawat = mysql_fetch_assoc($get_cek_no_rawat);
if (empty($dat_cek_no_rawat['ST_ASKEP'])  or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
	if (empty($_err)) {
	
	$muka ='';
	$kaki ='';
	$aktivitas ='';
	$menangis ='';
	$respon_tubuh ='';
	$perawat ='';
	$tanggal ='';
	
	for($i=1;$i<7;$i++){
		if(isset($_POST['muka_' . $i])) {
			$muka = $muka . $_POST['muka_' . $i] . '|';
		}else{
			$muka = $muka . '|';
		}
		
		if(isset($_POST['kaki_' . $i])) {
			$kaki = $kaki . $_POST['kaki_' . $i] . '|';
		}else{
			$kaki = $kaki . '|';
		}
		
		if(isset($_POST['aktivitas_' . $i])) {
			$aktivitas = $aktivitas . $_POST['aktivitas_' . $i] . '|';
		}else{
			$aktivitas = $aktivitas . '|';
		}
		
		if(isset($_POST['menangis_' . $i])) {
			$menangis = $menangis . $_POST['menangis_' . $i] . '|';
		}else{
			$menangis = $menangis . '|';
		}
		
		if(isset($_POST['respon_tubuh_' . $i])) {
			$respon_tubuh = $respon_tubuh . $_POST['respon_tubuh_' . $i] . '|';
		}else{
			$respon_tubuh = $respon_tubuh . '|';
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

	if(empty($flacc_scale_id)){
		mysql_query('INSERT INTO t_irna_askep_flacc_scale (FLACC_SCALE_ID,MUKA,KAKI,AKTIVITAS,MENANGIS,RESPON_TUBUH,PERAWAT,TANGGAL,USER_ASKEP) 
					VALUES ("'.$irna_id.'","'.$muka.'","'.$kaki.'","'.$aktivitas.'","'.$menangis.'","'.$respon_tubuh.'","'.$perawat.'",
					"'.$tanggal.'","'.$user_name.'")') or die(mysql_error());
	}else{
		mysql_query('UPDATE t_irna_askep_flacc_scale SET MUKA = "'.$muka.'",KAKI = "'.$kaki.'",
					AKTIVITAS = "'.$aktivitas.'",MENANGIS = "'.$menangis.'",RESPON_TUBUH = "'.$respon_tubuh.'",
					PERAWAT = "'.$perawat.'",TANGGAL = "'.$tanggal.'",USER_ASKEP = "'.$user_name.'"
					WHERE FLACC_SCALE_ID = "'.$flacc_scale_id.'"') or die(mysql_error());
	}
	
?>
<script language="JavaScript" >
	alert('Simpan Data FLACC Scale Berhasil.');
	window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=snfl&idx=<?php echo $_GET['idx']; ?>";
</script>
<?php		
		}else{
			$msg_info = $_err;
		}
	}
?>