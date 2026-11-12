<?php
if (!isset($_GET['hapus'])) {
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $_GET['nmr']; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=resp&idx=<?php echo $_GET['idx']; ?>&idrc=<?php echo $_GET['idrc']; ?>&ord=<?php echo $_GET['ord']; ?>&hapus=1";
        }else{
			window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=resp&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>";
		}
    </script>
    <?php
}
if (isset($_GET['hapus'])) {
	if(empty($_GET['ord'])){
			mysql_query('DELETE FROM t_irja_resep_racikan WHERE IRJA_RESEP_RACIKAN_ID = "' . $_GET['idrc'] . '"');
			mysql_query('UPDATE t_irja SET USER_IRJA = "' . $user_name . '" WHERE IRJA_ID = "' . $irja_id . '"') or die(mysql_error());
    }else{
			mysql_query('DELETE FROM t_hemodialisa_resep_racikan WHERE HEMODIALISA_RESEP_RACIKAN_ID = "' . $_GET['idrc'] . '"');
			mysql_query('UPDATE t_hemodialisa SET USER_IRJA = "' . $user_name . '" WHERE HEMODIALISA_ID = "' . $irja_id . '"') or die(mysql_error());
	}
	?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=resp&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>";
    </script>
    <?php
}
?>