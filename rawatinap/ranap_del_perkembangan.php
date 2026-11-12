<?php
if (!isset($_GET['hapus'])) {
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $_GET['nmr']; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=prkb&idx=<?php echo $_GET['idx']; ?>&idrc=<?php echo $_GET['idrc']; ?>&hapus=1";
        }else{
			window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=prkb&idx=<?php echo $_GET['idx']; ?>";
		}
    </script>
    <?php
}
if (isset($_GET['hapus'])) {
    $sql_cek_no_klinik = 'SELECT NO_RAWAT FROM t_irna WHERE IRNA_ID = "' . $_GET['idx'] . '"';
	$get_cek_no_klinik = mysql_query($sql_cek_no_klinik) or die(mysql_error());
	$dat_cek_no_klinik = mysql_fetch_assoc($get_cek_no_klinik);
	if (empty($dat_cek_no_klinik['NO_RAWAT']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
		mysql_query('DELETE FROM t_irna_perkembangan WHERE IRNA_PERKEMBANGAN_ID = "' . $_GET['idrc'] . '"');
	}	
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=prkb&idx=<?php echo $_GET['idx']; ?>";
    </script>
    <?php
}
?>