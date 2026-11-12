<?php
if (!isset($_GET['hapus'])) {
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $_GET['nmr']; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=dgns&idx=<?php echo $_GET['idx']; ?>&idd=<?php echo $_GET['idd']; ?>&hapus=1";
        }else{
			window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=dgns&idx=<?php echo $_GET['idx']; ?>";
		}
    </script>
    <?php
}
if (isset($_GET['hapus'])) {
    $sql_cek_no_rawat = 'SELECT ST_ASKEP FROM t_irna WHERE IRNA_ID = "' . $_GET['idx'] . '"';
	$get_cek_no_rawat = mysql_query($sql_cek_no_rawat) or die(mysql_error());
	$dat_cek_no_rawat = mysql_fetch_assoc($get_cek_no_rawat);
	if (empty($dat_cek_no_rawat['ST_ASKEP']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
		mysql_query('DELETE FROM t_irna_askep_diagnosa WHERE IRNA_ASKEP_DIAGNOSA_ID = "' . $_GET['idd'] . '"');
	}	
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=dgns&idx=<?php echo $_GET['idx']; ?>";
    </script>
    <?php
}
?>