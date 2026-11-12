<?php
if (!isset($_GET['hapus'])) {
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $_GET['nmk']; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=phmd&idx=<?php echo $_GET['idx']; ?>&idk=<?php echo $_GET['idk']; ?>&hapus=1";
        }else{
			window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=phmd&idx=<?php echo $_GET['idx']; ?>";
		}
    </script>
    <?php
}
if (isset($_GET['hapus'])) {
	mysql_query('DELETE FROM t_hemodialisa WHERE HEMODIALISA_ID = "' . $_GET['idk'] . '"') or die(mysql_error());
	
	mysql_query('UPDATE t_irja SET USER_IRJA = "' . $user_name . '" 
					WHERE IRJA_ID = "' . $_GET['idx'] . '"') or die(mysql_error());	
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=phmd&idx=<?php echo $_GET['idx']; ?>";
    </script>
    <?php
}
?>