<?php
if (!isset($_GET['hapus'])) {
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $_GET['nmp']; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=lbrm&idx=<?php echo $_GET['idx']; ?>&idp=<?php echo $_GET['idp']; ?>&hapus=1";
        }else{
			window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=lbrm&idx=<?php echo $_GET['idx']; ?>";
		}
    </script>
    <?php
}
if (isset($_GET['hapus'])) {
		
		mysql_query('DELETE FROM t_ipenunjang_tarif WHERE PENUNJANG_ID = "' . $_GET['idp'] . '"') or die(mysql_error());
		mysql_query('DELETE FROM t_ipenunjang WHERE PENUNJANG_ID = "' . $_GET['idp'] . '"') or die(mysql_error());
		
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=lbrm&idx=<?php echo $_GET['idx']; ?>";
    </script>
    <?php
}
?>