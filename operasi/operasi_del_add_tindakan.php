<?php
if (!isset($_GET['hapus'])) {
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $_GET['nmk']; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=tndk&idx=<?php echo $_GET['idx']; ?>&idk=<?php echo $_GET['idk']; ?>&msk=<?php echo $_GET['msk']; ?>&hapus=1";
        }else{
			window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=tndk&idx=<?php echo $_GET['idx']; ?>&msk=<?php echo $_GET['msk']; ?>";
		}
    </script>
    <?php
}
if (isset($_GET['hapus'])) {
    $sql_cek_no_ranap = 'SELECT NO_OPERASI FROM t_operasi WHERE OPERASI_ID = "' . $_GET['idx'] . '"';
	$get_cek_no_ranap = mysql_query($sql_cek_no_ranap) or die(mysql_error());
	$dat_cek_no_ranap = mysql_fetch_assoc($get_cek_no_ranap);
	if (empty($dat_cek_no_ranap['NO_OPERASI']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
		mysql_query('DELETE FROM t_operasi_tarif WHERE OPERASI_TARIF_ID = "' . $_GET['idk'] . '"');
	}	
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=tndk&idx=<?php echo $_GET['idx']; ?>&msk=<?php echo $_GET['msk']; ?>";
    </script>
    <?php
}
?>