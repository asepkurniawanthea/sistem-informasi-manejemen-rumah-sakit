<?php
if (!isset($_GET['hapus'])) {
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $_GET['flnm']; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_GET['link']; ?>&flid=<?php echo $_GET['flid']; ?>&flnm=<?php echo $_GET['flnm']; ?>&hapus=1";
        }else{
			window.location = "index.php?link=<?php echo $_GET['link']; ?>&flid=<?php echo $_GET['flid']; ?>";
		}
    </script>
    <?php
}
if (isset($_GET['hapus'])) {
  	mysql_query('DELETE FROM t_rm_dokumen_file WHERE FILE_ID = "' . $_GET['flid'] . '"');	
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>";
    </script>
    <?php
}
?>