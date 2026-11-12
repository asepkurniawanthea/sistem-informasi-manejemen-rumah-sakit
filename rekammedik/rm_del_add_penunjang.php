<?php
if (!isset($_GET['hapus'])) {
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $_GET['nmp']; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=dgns&idx=<?php echo $_GET['idx']; ?>&idp=<?php echo $_GET['idp']; ?>&hapus=1";
        }else{
			window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=dgns&idx=<?php echo $_GET['idx']; ?>";
		}
    </script>
    <?php
}
if (isset($_GET['hapus'])) {
	if (currentModul() == 'rekam medik' and $_SESSION['SES_SIMRS_ADMIN'] == '1') {
		
		$sql_penunjang = 'SELECT t_ipenunjang_tarif.PENUNJANG_ID FROM t_ipenunjang_tarif
				WHERE t_ipenunjang_tarif.PENUNJANG_TARIF_ID = "' . $_GET['idp'] . '"';
		$get_penunjang = mysql_query($sql_penunjang) or die(mysql_error());
		$dat_penunjang = mysql_fetch_assoc($get_penunjang);
		$penunjang_id = $dat_penunjang['PENUNJANG_ID']; 
		
		mysql_query('DELETE FROM t_ipenunjang_tarif WHERE PENUNJANG_TARIF_ID = "' . $_GET['idp'] . '"') or die(mysql_error());
		
		$sql_penunjang = 'SELECT t_ipenunjang_tarif.PENUNJANG_TARIF_ID FROM t_ipenunjang_tarif
				WHERE t_ipenunjang_tarif.PENUNJANG_ID = "' . $penunjang_id . '"';
		$get_penunjang = mysql_query($sql_penunjang) or die(mysql_error());
		if(mysql_num_rows($get_penunjang) == 0){
			mysql_query('DELETE FROM t_ipenunjang WHERE PENUNJANG_ID = "' . $penunjang_id . '"') or die(mysql_error());
		}
	}	
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=dgns&idx=<?php echo $_GET['idx']; ?>";
    </script>
    <?php
}
?>