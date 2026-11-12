<?php
$_err = '';
$irna_id = $_POST['irna_id'];
$numeric_rating_scale_id = $_POST['numeric_rating_scale_id'];
$user_name = currentUser();

$sql_cek_no_rawat = 'SELECT ST_ASKEP FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
$get_cek_no_rawat = mysql_query($sql_cek_no_rawat) or die(mysql_error());
$dat_cek_no_rawat = mysql_fetch_assoc($get_cek_no_rawat);
if (empty($dat_cek_no_rawat['ST_ASKEP'])  or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
	if (empty($_err)) {
	
	$skor ='';
	$perawat ='';
	$tanggal ='';
	
	for($i=1;$i<10;$i++){
		if(isset($_POST['skor_' . $i])) {
			$skor = $skor . $_POST['skor_' . $i] . '|';
		}else{
			$skor = $skor . '|';
		}
	}

	for($i=1;$i<10;$i++){
		if(isset($_POST['perawat_' . $i])) {
			$perawat = $perawat . $_POST['perawat_' . $i] . '|';
		}else{
			$perawat = $perawat . '|';
		}
	}	
	
	for($i=1;$i<10;$i++){
		if(isset($_POST['tanggal_' . $i])) {
			$tanggal = $tanggal . $_POST['tanggal_' . $i] . '|';
		}else{
			$tanggal = $tanggal . '|';
		}
	}

	if(empty($numeric_rating_scale_id)){
		mysql_query('INSERT INTO t_irna_askep_numeric_rating_scale (NUMERIC_RATING_SCALE_ID,SKOR,PERAWAT,TANGGAL,USER_ASKEP) 
					VALUES ("'.$irna_id.'","'.$skor.'","'.$perawat.'","'.$tanggal.'","'.$user_name.'")') or die(mysql_error());
	}else{
		mysql_query('UPDATE t_irna_askep_numeric_rating_scale SET SKOR = "'.$skor.'",PERAWAT = "'.$perawat.'",
					TANGGAL = "'.$tanggal.'",USER_ASKEP = "'.$user_name.'"
					WHERE NUMERIC_RATING_SCALE_ID = "'.$numeric_rating_scale_id.'"') or die(mysql_error());
	}
	
?>
<script language="JavaScript" >
	alert('Simpan Data Numeric Rating Scale Berhasil.');
	window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=nrwb&idx=<?php echo $_GET['idx']; ?>";
</script>
<?php		
		}else{
			$msg_info = $_err;
		}
	}
?>