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
		mysql_query('UPDATE t_irja_resep
					SET ST_RESEP_TEMP = ST_RESEP,NO_RESEP_TEMP = NO_RESEP,
					TGL_RESEP_TEMP = TGL_RESEP,PEGAWAI_ID_TEMP = PEGAWAI_ID
					WHERE IRJA_ID = "' . $_GET['idx'] . '" AND NO_RESEP = "' . $_GET['idu'] . '"') or die(mysql_error());
		
		mysql_query('UPDATE t_irja_resep
					SET ST_RESEP = NULL,NO_RESEP = NULL,PEGAWAI_ID = NULL
					WHERE IRJA_ID = "' . $_GET['idx'] . '" AND NO_RESEP = "' . $_GET['idu'] . '"') or die(mysql_error());
					
		mysql_query('UPDATE t_irja SET USER_IRJA = "' . $user_name . '" 
					WHERE IRJA_ID = "' . $_GET['idx'] . '"') or die(mysql_error());				
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=resp&idx=<?php echo $_GET['idx']; ?>";
    </script>
    <?php
}
?>