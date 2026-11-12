<?php
if (!isset($_GET['hapus'])) {
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $_GET['nmr']; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=resp&idx=<?php echo $_GET['idx']; ?>&idrc=<?php echo $_GET['idrc']; ?>&hapus=1";
        }else{
			window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=resp&idx=<?php echo $_GET['idx']; ?>";
		}
    </script>
    <?php
}
if (isset($_GET['hapus'])) {

		mysql_query('DELETE FROM t_operasi_resep_racikan WHERE OPERASI_RESEP_RACIKAN_ID = "' . $_GET['idrc'] . '"');

    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=resp&idx=<?php echo $_GET['idx']; ?>";
    </script>
    <?php
}
?>