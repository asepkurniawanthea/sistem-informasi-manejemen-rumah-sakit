<?php
$_err = '';
$irna_id = $_POST['irna_id'];
$catatan_keperawatan_id = $_POST['catatan_keperawatan_id'];
$tanggal = $_POST['tanggal'] . ' ' . $_POST['jam'] . ':' . $_POST['menit'];
$soap = $_POST['soap'];
$perawat = $_POST['perawat'];
$user_name = currentUser();

$sql_cek_no_rawat = 'SELECT ST_ASKEP FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
$get_cek_no_rawat = mysql_query($sql_cek_no_rawat) or die(mysql_error());
$dat_cek_no_rawat = mysql_fetch_assoc($get_cek_no_rawat);
if (empty($dat_cek_no_rawat['ST_ASKEP'])  or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
	if (empty($_err)) {
		if(empty($catatan_keperawatan_id)){
			mysql_query('INSERT INTO t_irna_askep_catatan_keperawatan (IRNA_ID,TANGGAL,SOAP,PERAWAT,USER_ASKEP) 
						VALUES ("'.$irna_id.'",STR_TO_DATE("'.$tanggal.'","%d/%m/%Y %H:%i"),"'.$soap.'",
						"'.$perawat.'","'.$user_name.'")') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_irna_askep_catatan_keperawatan SET TANGGAL = STR_TO_DATE("'.$tanggal.'","%d/%m/%Y %H:%i"),
						SOAP = "'.$soap.'",PERAWAT = "'.$perawat.'",USER_ASKEP = "'.$user_name.'",
						ST_CREATE_ERM = NULL
						WHERE CATATAN_KEPERAWATAN_ID = "'.$catatan_keperawatan_id.'"') or die(mysql_error());
		}
?>
<script language="JavaScript" >
	alert('Simpan Data Catatan Keperawatan Berhasil.');
	window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=ctkp&idx=<?php echo $_GET['idx']; ?>";
</script>
<?php		
		}else{
			$msg_info = $_err;
		}
}
?>