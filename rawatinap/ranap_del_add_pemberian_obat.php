<?php
if (!isset($_GET['hapus'])) {
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $_GET['nmo']; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=cpob&idx=<?php echo $_GET['idx']; ?>&ido=<?php echo $_GET['ido']; ?>&hapus=1";
        }else{
			window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=cpob&idx=<?php echo $_GET['idx']; ?>";
		}
    </script>
    <?php
}
if (isset($_GET['hapus'])) {
    $sql_cek_no_ranap = 'SELECT NO_RAWAT FROM t_irna WHERE IRNA_ID = "' . $_GET['idx'] . '"';
	$get_cek_no_ranap = mysql_query($sql_cek_no_ranap) or die(mysql_error());
	$dat_cek_no_ranap = mysql_fetch_assoc($get_cek_no_ranap);
	if (empty($dat_cek_no_ranap['NO_RAWAT']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
		mysql_query('DELETE FROM t_irna_pemberian_obat WHERE PEMBERIAN_OBAT_ID = "' . $_GET['ido'] . '"');
	}	
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=cpob&idx=<?php echo $_GET['idx']; ?>";
    </script>
    <?php
}
?>