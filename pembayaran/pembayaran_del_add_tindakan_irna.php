<?php
if (!isset($_GET['hapus'])) {
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $_GET['nmk']; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=tndk&idx=<?php echo $_GET['idx']; ?>&idk=<?php echo $_GET['idk']; ?>&hapus=1";
        }else{
			window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=tndk&idx=<?php echo $_GET['idx']; ?>";
		}
    </script>
    <?php
}
if (isset($_GET['hapus'])) {
    $sql_cek_no_rawat = 'SELECT ST_PULANG FROM t_irna WHERE IRNA_ID = "' . $_GET['idx'] . '"';
	$get_cek_no_rawat = mysql_query($sql_cek_no_rawat) or die(mysql_error());
	$dat_cek_no_rawat = mysql_fetch_assoc($get_cek_no_rawat);
	if ($dat_cek_no_rawat['ST_PULANG'] != '1' or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
		mysql_query('DELETE FROM t_irna_tarif WHERE IRNA_TARIF_ID = "' . $_GET['idk'] . '"');
	}	
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=tndk&idx=<?php echo $_GET['idx']; ?>";
    </script>
    <?php
}
?>