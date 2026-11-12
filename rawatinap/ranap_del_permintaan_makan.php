<?php
if (!isset($_GET['hapus'])) {
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $_GET['nmp']; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_GET['link']; ?>&nop=<?php echo $_GET['nop']; ?>&hapus=1";
        }else{
			window.location = "index.php?link=<?php echo $_GET['link']; ?>&nop=<?php echo $_GET['nop']; ?>";
		}
    </script>
    <?php
}
if (isset($_GET['hapus'])) {
	$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
	mysql_select_db($database_3, $connect_3) or die(mysql_error());

    mysql_query('DELETE FROM t_gizi_permintaan WHERE NO_PERMINTAAN = "' . $_GET['nop'] . '"');	
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>";
    </script>
    <?php
}
?>