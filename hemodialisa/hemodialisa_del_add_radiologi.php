<?php
if (!isset($_GET['hapus'])) {
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $_GET['nmk']; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=rdlg&idx=<?php echo $_GET['idx']; ?>&idk=<?php echo $_GET['idk']; ?>&ord=<?php echo $_GET['ord']; ?>&hapus=1";
        }else{
			window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=rdlg&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>";
		}
    </script>
    <?php
}
if (isset($_GET['hapus'])) {
    if(empty($_GET['ord'])){
		$sql_cek_no_klinik = 'SELECT NO_KLINIK FROM t_irja WHERE IRJA_ID = "' . $_GET['idx'] . '"';
	}else{
		$sql_cek_no_klinik = 'SELECT NO_KLINIK FROM t_hemodialisa WHERE HEMODIALISA_ID = "' . $_GET['idx'] . '"';
	}	
	$get_cek_no_klinik = mysql_query($sql_cek_no_klinik) or die(mysql_error());
	$dat_cek_no_klinik = mysql_fetch_assoc($get_cek_no_klinik);
	if (empty($dat_cek_no_klinik['NO_KLINIK']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
		$sql_lab = 'SELECT t_ipenunjang_tarif.PENUNJANG_ID FROM t_ipenunjang_tarif
				WHERE t_ipenunjang_tarif.PENUNJANG_TARIF_ID = "' . $_GET['idk'] . '"';
		$get_lab = mysql_query($sql_lab) or die(mysql_error());
		$dat_lab = mysql_fetch_assoc($get_lab);
		$penunjang_id = $dat_lab['PENUNJANG_ID']; 
		
		mysql_query('DELETE FROM t_ipenunjang_tarif WHERE PENUNJANG_TARIF_ID = "' . $_GET['idk'] . '"') or die(mysql_error());
		
		$sql_lab = 'SELECT t_ipenunjang_tarif.PENUNJANG_TARIF_ID FROM t_ipenunjang_tarif
				WHERE t_ipenunjang_tarif.PENUNJANG_ID = "' . $penunjang_id . '"';
		$get_lab = mysql_query($sql_lab) or die(mysql_error());
		if(mysql_num_rows($get_lab) == 0){
			mysql_query('DELETE FROM t_ipenunjang WHERE PENUNJANG_ID = "' . $penunjang_id . '"') or die(mysql_error());
		}
	}	
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=rdlg&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>";
    </script>
    <?php
}
?>