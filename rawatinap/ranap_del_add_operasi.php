<?php
if (!isset($_GET['hapus'])) {
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $_GET['nmo']; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=oprs&idx=<?php echo $_GET['idx']; ?>&iop=<?php echo $_GET['iop']; ?>&hapus=1";
        }else{
			window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=oprs&idx=<?php echo $_GET['idx']; ?>";
		}
    </script>
    <?php
}
if (isset($_GET['hapus'])) {
		mysql_query('DELETE FROM t_operasi WHERE OPERASI_ID = "' . $_GET['iop'] . '"') or die(mysql_error());
	
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=oprs&idx=<?php echo $_GET['idx']; ?>";
    </script>
    <?php
}
?>