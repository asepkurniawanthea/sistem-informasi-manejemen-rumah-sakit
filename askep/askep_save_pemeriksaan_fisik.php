<?php
$_err = '';
$irna_id = $_POST['irna_id'];
$tensi_id = $_POST['tensi_id'];
$user_name = currentUser();

$sql_cek_no_rawat = 'SELECT ST_ASKEP FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
$get_cek_no_rawat = mysql_query($sql_cek_no_rawat) or die(mysql_error());
$dat_cek_no_rawat = mysql_fetch_assoc($get_cek_no_rawat);
if (empty($dat_cek_no_rawat['ST_ASKEP'])  or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
	if (empty($_err)) {
	
	$tanggal ='';
	$nadi_suhu ='';
	$pernafasan='';
	$tekanan_darah='';
	$berat_tinggi_badan='';
	
	for($i=1;$i<8;$i++){
		if(isset($_POST['tanggal_' . $i])) {
			$tanggal = $tanggal . $_POST['tanggal_' . $i] . '|';
		}else{
			$tanggal = $tanggal . '|';
		}
	}

	for($i=1;$i<981;$i++){
		if(isset($_POST['nadi_suhu_' . $i])) {
			$nadi_suhu = $nadi_suhu . $_POST['nadi_suhu_' . $i] . '|';
		}else{
			$nadi_suhu = $nadi_suhu . '|';
		}
	}	
	
	for($i=1;$i<29;$i++){
		if(isset($_POST['pernafasan_' . $i])) {
			$pernafasan = $pernafasan . $_POST['pernafasan_' . $i] . '|';
		}else{
			$pernafasan = $pernafasan . '|';
		}
	}
	
	for($i=1;$i<15;$i++){
		if(isset($_POST['tekanan_darah_' . $i])) {
			$tekanan_darah = $tekanan_darah . $_POST['tekanan_darah_' . $i] . '|';
		}else{
			$tekanan_darah = $tekanan_darah . '|';
		}
	}
	
	for($i=1;$i<8;$i++){
		if(isset($_POST['berat_tinggi_badan_' . $i])) {
			$berat_tinggi_badan = $berat_tinggi_badan . $_POST['berat_tinggi_badan_' . $i] . '|';
		}else{
			$berat_tinggi_badan = $berat_tinggi_badan . '|';
		}
	}

	if(empty($tensi_id)){
		mysql_query('INSERT INTO t_irna_askep_tensi_nafas_nadi_suhu (TENSI_ID,TANGGAL,NADI_SUHU,PERNAFASAN,TEKANAN_DARAH,BERAT_TINGGI_BADAN,USER_ASKEP) 
					VALUES ("'.$irna_id.'","'.$tanggal.'","'.$nadi_suhu.'","'.$pernafasan.'","'.$tekanan_darah.'","'.$berat_tinggi_badan.'",
					"'.$user_name.'")') or die(mysql_error());
	}else{
		mysql_query('UPDATE t_irna_askep_tensi_nafas_nadi_suhu SET TANGGAL = "'.$tanggal.'",NADI_SUHU = "'.$nadi_suhu.'",PERNAFASAN = "'.$pernafasan.'",
					TEKANAN_DARAH = "'.$tekanan_darah.'",BERAT_TINGGI_BADAN = "'.$berat_tinggi_badan.'",USER_ASKEP = "'.$user_name.'"
					WHERE TENSI_ID = "'.$tensi_id.'"') or die(mysql_error());
	}
	
?>
<script language="JavaScript" >
	alert('Simpan Data Tensi-Nafas-Suhu-Nadi Berhasil.');
	window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=tnsn&idx=<?php echo $_GET['idx']; ?>";
</script>
<?php		
		}else{
			$msg_info = $_err;
		}
	}
?>