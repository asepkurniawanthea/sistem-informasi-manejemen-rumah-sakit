<?php
if (!isset($_GET['hapus'])) {
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $_GET['nmk']; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=lbrm&idx=<?php echo $_GET['idx']; ?>&msk=<?php echo $_GET['msk']; ?>&idk=<?php echo $_GET['idk']; ?>&hapus=1";
        }else{
			window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=lbrm&idx=<?php echo $_GET['idx']; ?>&msk=<?php echo $_GET['msk']; ?>";
		}
    </script>
    <?php
}
if (isset($_GET['hapus'])) {
    $sql_cek_no_ranap = 'SELECT NO_OPERASI FROM t_operasi WHERE OPERASI_ID = "' . $_GET['idx'] . '"';
	$get_cek_no_ranap = mysql_query($sql_cek_no_ranap) or die(mysql_error());
	$dat_cek_no_ranap = mysql_fetch_assoc($get_cek_no_ranap);
	if (empty($dat_cek_no_ranap['NO_OPERASI']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
		$sql_lab = 'SELECT t_ipenunjang_tarif.PENUNJANG_ID,t_ipenunjang.NO_ORDER,t_ipenunjang.RAWAT_ID,
				t_ipenunjang.JNS_ORDER
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
			lis_cancel_order($dat_lab['RAWAT_ID'],$dat_lab['NO_ORDER']);
		}else{
			lis_update_order($dat_lab['RAWAT_ID'],$dat_lab['NO_ORDER'],$dat_lab['JNS_ORDER']);
		}
	}	
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=lbrm&idx=<?php echo $_GET['idx']; ?>&msk=<?php echo $_GET['msk']; ?>";
    </script>
    <?php
}
?>