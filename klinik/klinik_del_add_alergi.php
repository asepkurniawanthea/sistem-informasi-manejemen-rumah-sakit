<?php
if (!isset($_GET['hapus'])) {
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $_GET['nmg']; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=alrg&idx=<?php echo $_GET['idx']; ?>&idg=<?php echo $_GET['idg']; ?>&hapus=1";
        }else{
			window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=alrg&idx=<?php echo $_GET['idx']; ?>";
		}
    </script>
    <?php
}
if (isset($_GET['hapus'])) {
    $sql_cek_no_klinik = 'SELECT NO_KLINIK FROM t_irja WHERE IRJA_ID = "' . $_GET['idx'] . '"';
	$get_cek_no_klinik = mysql_query($sql_cek_no_klinik) or die(mysql_error());
	$dat_cek_no_klinik = mysql_fetch_assoc($get_cek_no_klinik);
	if (empty($dat_cek_no_klinik['NO_KLINIK']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
		mysql_query('DELETE FROM t_irja_alergi WHERE IRJA_ALERGI_ID = "' . $_GET['idg'] . '"');
	}	
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=alrg&idx=<?php echo $_GET['idx']; ?>";
    </script>
    <?php
}
?>