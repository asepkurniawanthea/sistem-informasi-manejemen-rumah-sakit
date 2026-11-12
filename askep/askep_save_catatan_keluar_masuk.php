<?php
$_err = '';
$irna_id = $_POST['irna_id'];
$keluar_masuk_id = $_POST['keluar_masuk_id'];
$tanggal = $_POST['tanggal'] . ' ' . $_POST['jam'] . ':' . $_POST['menit'];
$jenis_keluar_masuk = $_POST['jenis_keluar_masuk'];
$catatan = $_POST['catatan'];
$perawat = $_POST['perawat'];
$user_name = currentUser();

$sql_cek_no_rawat = 'SELECT ST_ASKEP FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
$get_cek_no_rawat = mysql_query($sql_cek_no_rawat) or die(mysql_error());
$dat_cek_no_rawat = mysql_fetch_assoc($get_cek_no_rawat);
if (empty($dat_cek_no_rawat['ST_ASKEP'])  or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
	if (empty($_err)) {
		if(empty($keluar_masuk_id)){
			mysql_query('INSERT INTO t_irna_askep_catatan_keluar_masuk (IRNA_ID,TANGGAL,JENIS_KELUAR_MASUK,CATATAN,PERAWAT,USER_ASKEP) 
						VALUES ("'.$irna_id.'",STR_TO_DATE("'.$tanggal.'","%d/%m/%Y %H:%i"),"'.$jenis_keluar_masuk.'","'.$catatan.'",
						"'.$perawat.'","'.$user_name.'")') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_irna_askep_catatan_keluar_masuk SET TANGGAL = STR_TO_DATE("'.$tanggal.'","%d/%m/%Y %H:%i"),
					JENIS_KELUAR_MASUK = "'.$jenis_keluar_masuk.'",CATATAN = "'.$catatan.'",
					PERAWAT = "'.$perawat.'",USER_ASKEP = "'.$user_name.'"
					WHERE KELUAR_MASUK_ID = "'.$keluar_masuk_id.'"') or die(mysql_error());
		}
?>
<script language="JavaScript" >
	alert('Simpan Data Catatan Intake/ Output Berhasil.');
	window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=ckmb&idx=<?php echo $_GET['idx']; ?>";
</script>
<?php		
		}else{
			$msg_info = $_err;
		}
}
?>