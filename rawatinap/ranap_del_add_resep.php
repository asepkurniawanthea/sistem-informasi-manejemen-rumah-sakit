<?php
if (!isset($_GET['hapus'])) {
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $_GET['nmr']; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=resp&idx=<?php echo $_GET['idx']; ?>&idr=<?php echo $_GET['idr']; ?>&hapus=1";
        }else{
			window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=resp&idx=<?php echo $_GET['idx']; ?>";
		}
    </script>
    <?php
}
if (isset($_GET['hapus'])) {
		$sql_racikan = 'SELECT IRNA_RESEP_RACIKAN_ID FROM t_irna_resep_racikan WHERE IRNA_RESEP_ID = "' . $_GET['idr'] . '"';
		$get_racikan = mysql_query($sql_racikan) or die(mysql_error());
		if(mysql_num_rows($get_racikan) > 0){
			mysql_query('DELETE FROM t_irna_resep_racikan WHERE IRNA_RESEP_ID = "' . $_GET['idr'] . '"');
		}
		mysql_query('DELETE FROM t_irna_resep WHERE IRNA_RESEP_ID = "' . $_GET['idr'] . '"');
		
		mysql_query('UPDATE t_irna SET USER_IRNA = "' . $user_name . '",
				ST_CREATE_ERM_RESEP = NULL
				WHERE IRNA_ID = "' . $_GET['idx'] . '"') or die(mysql_error());
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=resp&idx=<?php echo $_GET['idx']; ?>";
    </script>
    <?php
}
?>