<?php
$irna_id = $_POST['irna_id'];
$catatan = $_POST['catatan'];
$tanggal = $_POST['tanggal'] . ' ' . $_POST['jam'] . ':' . $_POST['menit'] . ':01';
$pegawai_id = $_POST['pegawai_id'];

$sql_cek_no_ranap = 'SELECT NO_RAWAT FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
$get_cek_no_ranap = mysql_query($sql_cek_no_ranap) or die(mysql_error());
$dat_cek_no_ranap = mysql_fetch_assoc($get_cek_no_ranap);

if (empty($dat_cek_no_ranap['NO_RAWAT']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {		       
	mysql_query('INSERT INTO t_irna_perkembangan(IRNA_ID,TANGGAL_PERIKSA,CATATAN,PEGAWAI_ID)
				VALUES("' . $irna_id . '",' . fieldDatetime($tanggal) . ',"' . $catatan . '",
				"' . $pegawai_id . '")') or die(mysql_error());
			 
}

?>
 <script language="JavaScript" >
		setTimeout(opener.location.reload(), 3000);
</script>
