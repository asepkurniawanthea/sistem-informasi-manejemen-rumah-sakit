<?php
if (!isset($_GET['hapus'])) {
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $_GET['nmk']; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=lbrm&idx=<?php echo $_GET['idx']; ?>&idk=<?php echo $_GET['idk']; ?>&hapus=1";
        }else{
			window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=lbrm&idx=<?php echo $_GET['idx']; ?>";
		}
    </script>
    <?php
}
if (isset($_GET['hapus'])) {
		$sql_lab = 'SELECT t_ipenunjang_tarif.PENUNJANG_ID,t_ipenunjang.NO_ORDER 
				FROM t_ipenunjang_tarif
				INNER JOIN t_ipenunjang ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
				WHERE t_ipenunjang_tarif.PENUNJANG_TARIF_ID = "' . $_GET['idk'] . '"';
		$get_lab = mysql_query($sql_lab) or die(mysql_error());
		$dat_lab = mysql_fetch_assoc($get_lab);
		$penunjang_id = $dat_lab['PENUNJANG_ID']; 
		mysql_query('DELETE FROM t_ipenunjang_tarif WHERE PENUNJANG_TARIF_ID = "' . $_GET['idk'] . '"') or die(mysql_error());
		
		include('lis/simrs2lis.php');
		
		$sql_lab = 'SELECT t_ipenunjang_tarif.PENUNJANG_TARIF_ID FROM t_ipenunjang_tarif
				WHERE t_ipenunjang_tarif.PENUNJANG_ID = "' . $penunjang_id . '"';
		$get_lab = mysql_query($sql_lab) or die(mysql_error());
		if(mysql_num_rows($get_lab) == 0){
			mysql_query('DELETE FROM t_ipenunjang WHERE PENUNJANG_ID = "' . $penunjang_id . '"') or die(mysql_error());
			lis_cancel_order($_GET['idx'],$dat_lab['NO_ORDER']);
		}else{
			lis_update_order($_GET['idx'],$dat_lab['NO_ORDER'],'IRJ');
		}
		
		mysql_query('UPDATE t_irja SET USER_IRJA = "' . $user_name . '" 
					WHERE IRJA_ID = "' . $_GET['idx'] . '"') or die(mysql_error());	
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=lbrm&idx=<?php echo $_GET['idx']; ?>";
    </script>
    <?php
}
?>