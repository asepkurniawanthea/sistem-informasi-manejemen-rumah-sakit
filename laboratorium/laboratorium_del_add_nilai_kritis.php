<?php
if (!isset($_GET['hapus'])) {
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $_GET['nmg']; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_GET['link']; ?>&idg=<?php echo $_GET['idg']; ?>&hapus=1";
        }else{
			window.location = "index.php?link=<?php echo $_GET['link']; ?>&idg=<?php echo $_GET['idg']; ?>";
		}
    </script>
    <?php
}
if (isset($_GET['hapus'])) {
    mysql_query('DELETE FROM m_nilai_kritis_laboratorium WHERE NILAI_KRITIS_ID = "' . $_GET['idg'] . '"');
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>";
    </script>
    <?php
}
?>