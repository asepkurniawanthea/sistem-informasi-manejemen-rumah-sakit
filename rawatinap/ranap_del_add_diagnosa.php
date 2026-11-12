<?php
if (!isset($_GET['hapus'])) {
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $_GET['nmg']; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=dgns&idx=<?php echo $_GET['idx']; ?>&idg=<?php echo $_GET['idg']; ?>&hapus=1";
        }else{
			window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=dgns&idx=<?php echo $_GET['idx']; ?>";
		}
    </script>
    <?php
}
if (isset($_GET['hapus'])) {
    $sql_cek_no_ranap = 'SELECT NO_RAWAT FROM t_irna WHERE IRNA_ID = "' . $_GET['idx'] . '"';
	$get_cek_no_ranap = mysql_query($sql_cek_no_ranap) or die(mysql_error());
	$dat_cek_no_ranap = mysql_fetch_assoc($get_cek_no_ranap);
	if (empty($dat_cek_no_ranap['NO_RAWAT']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
		mysql_query('DELETE FROM t_irna_diagnosa WHERE IRNA_DIAGNOSA_ID = "' . $_GET['idg'] . '"');
		$qry_tmp = 'SELECT * FROM t_irna_diagnosa WHERE IRNA_ID = "' . $_GET['idx'] . '"
				ORDER BY DIAGNOSA_ORDER';
		$get_tmp = mysql_query($qry_tmp);
		$i = 0;
		while ($dat_tmp = mysql_fetch_array($get_tmp)) {
			mysql_query('UPDATE t_irna_diagnosa SET DIAGNOSA_ORDER = "' . $i . '"
				WHERE IRNA_DIAGNOSA_ID = "' . $dat_tmp['IRNA_DIAGNOSA_ID'] . '"');
			$i++;
		}
	}	
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=dgns&idx=<?php echo $_GET['idx']; ?>";
    </script>
    <?php
}
?>