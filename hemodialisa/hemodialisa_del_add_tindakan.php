<?php
if (!isset($_GET['hapus'])) {
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $_GET['nmk']; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=tndk&idx=<?php echo $_GET['idx']; ?>&idk=<?php echo $_GET['idk']; ?>&ord=<?php echo $_GET['ord']; ?>&hapus=1";
        }else{
			window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=tndk&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>";
		}
    </script>
    <?php
}
if (isset($_GET['hapus'])) {
	if(empty($_GET['ord'])){
		mysql_query('DELETE FROM t_irja_tarif WHERE IRJA_TARIF_ID = "' . $_GET['idk'] . '"');
		mysql_query('UPDATE t_irja SET USER_IRJA = "' . $user_name . '" 
					WHERE IRJA_ID = "' . $_GET['idx'] . '"') or die(mysql_error());	
	}else{
		mysql_query('DELETE FROM t_hemodialisa_tarif WHERE HEMODIALISA_TARIF_ID = "' . $_GET['idk'] . '"');
		mysql_query('UPDATE t_hemodialisa SET USER_IRJA = "' . $user_name . '" 
					WHERE HEMODIALISA_ID = "' . $_GET['idx'] . '"') or die(mysql_error());	
	}		
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=tndk&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>";
    </script>
    <?php
}
?>