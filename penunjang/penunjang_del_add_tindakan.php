<?php
if (!isset($_GET['hapus'])) {
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $_GET['nmk']; ?>] dihapus?")){
            window.location = "<?php echo currentUrl(); ?>&idk=<?php echo $_GET['idk']; ?>&hapus=1";
        }else{
			window.location = "<?php echo currentUrl(); ?>";
		}
    </script>
    <?php
}
if (isset($_GET['hapus'])) {
    $sql_cek_no_klinik = 'SELECT t_ipenunjang_tarif.ST_PERIKSA
					FROM t_ipenunjang_tarif
					WHERE t_ipenunjang_tarif.PENUNJANG_ID = "' . $_GET['idx'] . '"
					AND t_ipenunjang_tarif.NO_TARIF = "' . $_GET['no'] . '"
					AND t_ipenunjang_tarif.UNIT_PENUNJANG_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '"
					ORDER BY t_ipenunjang_tarif.PENUNJANG_TARIF_ID ASC LIMIT 1';
		$get_cek_no_klinik = mysql_query($sql_cek_no_klinik) or die(mysql_error());
		$dat_cek_no_klinik = mysql_fetch_assoc($get_cek_no_klinik);
		if (empty($dat_cek_no_klinik['ST_PERIKSA'])  or $_SESSION['SES_SIMRS_ADMIN'] == '1') {	
			mysql_query('DELETE FROM t_ipenunjang_tarif WHERE PENUNJANG_TARIF_ID = "' . $_GET['idk'] . '"') or die(mysql_error());
		}	
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>&no=<?php echo $_GET['no']; ?>";
    </script>
    <?php
}
?>