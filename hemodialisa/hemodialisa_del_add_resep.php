<?php
if (!isset($_GET['hapus'])) {
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $_GET['nmr']; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=resp&idx=<?php echo $_GET['idx']; ?>&idr=<?php echo $_GET['idr']; ?>&ord=<?php echo $_GET['ord']; ?>&hapus=1";
        }else{
			window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=resp&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>";
		}
    </script>
    <?php
}
if (isset($_GET['hapus'])) {
	if(empty($_GET['ord'])){
			$sql_racikan = 'SELECT IRJA_RESEP_RACIKAN_ID FROM t_irja_resep_racikan WHERE IRJA_RESEP_ID = "' . $_GET['idr'] . '"';
			$get_racikan = mysql_query($sql_racikan) or die(mysql_error());
			if(mysql_num_rows($get_racikan) > 0){
				mysql_query('DELETE FROM t_irja_resep_racikan WHERE IRJA_RESEP_ID = "' . $_GET['idr'] . '"');
			}
			mysql_query('DELETE FROM t_irja_resep WHERE IRJA_RESEP_ID = "' . $_GET['idr'] . '"');
			mysql_query('UPDATE t_irja SET USER_IRJA = "' . $user_name . '" WHERE IRJA_ID = "' . $irja_id . '"') or die(mysql_error());
			
	}else{
			$sql_racikan = 'SELECT HEMODIALISA_RESEP_RACIKAN_ID FROM t_hemodialisa_resep_racikan WHERE HEMODIALISA_RESEP_ID = "' . $_GET['idr'] . '"';
			$get_racikan = mysql_query($sql_racikan) or die(mysql_error());
			if(mysql_num_rows($get_racikan) > 0){
				mysql_query('DELETE FROM t_hemodialisa_resep_racikan WHERE HEMODIALISA_RESEP_ID = "' . $_GET['idr'] . '"');
			}
			mysql_query('DELETE FROM t_hemodialisa_resep WHERE HEMODIALISA_RESEP_ID = "' . $_GET['idr'] . '"');
			mysql_query('UPDATE t_hemodialisa SET USER_IRJA = "' . $user_name . '" WHERE HEMODIALISA_ID = "' . $irja_id . '"') or die(mysql_error());
	}	
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=resp&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>";
    </script>
    <?php
}
?>