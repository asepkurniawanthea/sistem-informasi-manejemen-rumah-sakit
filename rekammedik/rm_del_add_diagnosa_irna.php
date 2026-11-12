<?php
if (!isset($_GET['hapus'])) {
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $_GET['nmg']; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_GET['link']; ?>&idx=<?php echo $_GET['idx']; ?>&idg=<?php echo $_GET['idg']; ?><?php if(isset($_GET['plg'])) echo '&plg=1'; ?>&hapus=1";
        }else{
			window.location = "index.php?link=<?php echo $_GET['link']; ?>&idx=<?php echo $_GET['idx']; ?>";
		}
    </script>
    <?php
}
if (isset($_GET['hapus'])) {
	if (currentModul() == 'rekam medik' and $_SESSION['SES_SIMRS_ADMIN'] == '1') {
		if(!isset($_GET['plg'])){
			mysql_query('DELETE FROM t_irna_diagnosa WHERE IRNA_DIAGNOSA_ID = "' . $_GET['idg'] . '"');
		}else{
			mysql_query('DELETE FROM t_irna_diagnosa_pulang WHERE IRNA_DIAGNOSA_PULANG_ID = "' . $_GET['idg'] . '"');
		}	
	}	
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>&idx=<?php echo $_GET['idx']; ?>";
    </script>
    <?php
}
?>