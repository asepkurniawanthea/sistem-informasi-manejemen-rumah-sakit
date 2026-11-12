<?php
if (!isset($_GET['hapus'])) {
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $_GET['nmr']; ?>] diubah?")){
            window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=resp&idx=<?php echo $_GET['idx']; ?>&idu=<?php echo $_GET['idu']; ?>&hapus=1";
        }else{
			window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=resp&idx=<?php echo $_GET['idx']; ?>";
		}
    </script>
    <?php
}
if (isset($_GET['hapus'])) {
    $sql_cek_no_klinik = 'SELECT NO_RAWAT FROM t_operasi WHERE OPERASI_ID = "' . $_GET['idx'] . '"';
	$get_cek_no_klinik = mysql_query($sql_cek_no_klinik) or die(mysql_error());
	$dat_cek_no_klinik = mysql_fetch_assoc($get_cek_no_klinik);
	if (empty($dat_cek_no_klinik['NO_RAWAT']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
		mysql_query('UPDATE t_operasi_resep
					SET ST_RESEP_TEMP = ST_RESEP,NO_RESEP_TEMP = NO_RESEP,
					TGL_RESEP_TEMP = TGL_RESEP,PEGAWAI_ID_TEMP = PEGAWAI_ID
					WHERE OPERASI_ID = "' . $_GET['idx'] . '" AND NO_RESEP = "' . $_GET['idu'] . '"') or die(mysql_error());
		
		mysql_query('UPDATE t_operasi_resep
					SET ST_RESEP = NULL,NO_RESEP = NULL,PEGAWAI_ID = NULL
					WHERE OPERASI_ID = "' . $_GET['idx'] . '" AND NO_RESEP = "' . $_GET['idu'] . '"') or die(mysql_error());			
	}	
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=resp&idx=<?php echo $_GET['idx']; ?>";
    </script>
    <?php
}
?>