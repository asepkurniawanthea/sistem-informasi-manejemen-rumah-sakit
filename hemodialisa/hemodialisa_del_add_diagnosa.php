<?php
if (!isset($_GET['hapus'])) {
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $_GET['nmg']; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=dgns&idx=<?php echo $_GET['idx']; ?>&idg=<?php echo $_GET['idg']; ?>&ord=<?php echo $_GET['ord']; ?>&hapus=1";
        }else{
			window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=dgns&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>";
		}
    </script>
    <?php
}
if (isset($_GET['hapus'])) {
	
	$jns_order = $_GET['ord'];
	if(empty($jns_order)){
	
		$sql_cek_no_klinik = 'SELECT NO_KLINIK FROM t_irja WHERE IRJA_ID = "' . $_GET['idx'] . '"';
		$get_cek_no_klinik = mysql_query($sql_cek_no_klinik) or die(mysql_error());
		$dat_cek_no_klinik = mysql_fetch_assoc($get_cek_no_klinik);
		if (empty($dat_cek_no_klinik['NO_KLINIK']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
			mysql_query('DELETE FROM t_irja_diagnosa WHERE IRJA_DIAGNOSA_ID = "' . $_GET['idg'] . '"');
			$qry_tmp = 'SELECT * FROM t_irja_diagnosa WHERE IRJA_ID = "' . $_GET['idx'] . '"
					ORDER BY DIAGNOSA_ORDER';
			$get_tmp = mysql_query($qry_tmp);
			$i = 0;
			while ($dat_tmp = mysql_fetch_array($get_tmp)) {
				mysql_query('UPDATE t_irja_diagnosa SET DIAGNOSA_ORDER = "' . $i . '"
					WHERE IRJA_DIAGNOSA_ID = "' . $dat_tmp['IRJA_DIAGNOSA_ID'] . '"');
				$i++;
			}
		}
		}else{
			
			$sql_cek_no_klinik = 'SELECT NO_KLINIK FROM t_hemodialisa WHERE HEMODIALISA_ID = "' . $_GET['idx'] . '"';
			$get_cek_no_klinik = mysql_query($sql_cek_no_klinik) or die(mysql_error());
			$dat_cek_no_klinik = mysql_fetch_assoc($get_cek_no_klinik);
			if (empty($dat_cek_no_klinik['NO_KLINIK']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
				mysql_query('DELETE FROM t_hemodialisa_diagnosa WHERE HEMODIALISA_DIAGNOSA_ID = "' . $_GET['idg'] . '"');
				$qry_tmp = 'SELECT * FROM t_hemodialisa_diagnosa WHERE HEMODIALISA_ID = "' . $_GET['idx'] . '"
						ORDER BY DIAGNOSA_ORDER';
				$get_tmp = mysql_query($qry_tmp);
				$i = 0;
				while ($dat_tmp = mysql_fetch_array($get_tmp)) {
					mysql_query('UPDATE t_hemodialisa_diagnosa SET DIAGNOSA_ORDER = "' . $i . '"
						WHERE HEMODIALISA_DIAGNOSA_ID = "' . $dat_tmp['HEMODIALISA_DIAGNOSA_ID'] . '"');
					$i++;
				}			
		}		
	}	
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=dgns&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>";
    </script>
    <?php
}
?>