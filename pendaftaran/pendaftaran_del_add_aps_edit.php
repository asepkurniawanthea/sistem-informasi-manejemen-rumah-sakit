<?php
if (!isset($_GET['hapus'])) {
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $_GET['nmk']; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_GET['link']; ?>&idx=<?php echo $_GET['idx']; ?>&idk=<?php echo $_GET['idk']; ?>&no=<?php echo $_GET['no']; ?>&un=<?php echo $un; ?>&in=<?php echo $in; ?>&do=<?php echo $do; ?>&al=<?php echo $al; ?>&te=<?php echo $te; ?>&ta=<?php echo $ta; ?>&di=<?php echo $di; ?>&hapus=1";
        }else{
			window.location = "index.php?link=<?php echo $_GET['link']; ?>&idx=<?php echo $_GET['idx']; ?>&no=<?php echo $_GET['no']; ?>&un=<?php echo $un; ?>&in=<?php echo $in; ?>&do=<?php echo $do; ?>&al=<?php echo $al; ?>&te=<?php echo $te; ?>&ta=<?php echo $ta; ?>&di=<?php echo $di; ?>";
		}
    </script>
    <?php
}
if (isset($_GET['hapus'])) {
				
		mysql_query('DELETE FROM t_ipenunjang_tarif WHERE PENUNJANG_TARIF_ID = "' . $_GET['idk'] . '"') or die(mysql_error());
		
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>&idx=<?php echo $_GET['idx']; ?>&no=<?php echo $_GET['no']; ?>&un=<?php echo $un; ?>&in=<?php echo $in; ?>&do=<?php echo $do; ?>&al=<?php echo $al; ?>&te=<?php echo $te; ?>&ta=<?php echo $ta; ?>&di=<?php echo $di; ?>";
    </script>
    <?php
}
?>