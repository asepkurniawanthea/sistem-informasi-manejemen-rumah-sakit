<?php
if (!isset($_GET['hapus'])) {
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $_GET['nmr']; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=cppn&idx=<?php echo $_GET['idx']; ?>&idrc=<?php echo $_GET['idrc']; ?>&hapus=1";
        }else{
			window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=cppn&idx=<?php echo $_GET['idx']; ?>";
		}
    </script>
    <?php
}
if (isset($_GET['hapus'])) {
		mysql_query('DELETE FROM t_irja_perkembangan WHERE IRJA_PERKEMBANGAN_ID = "' . $_GET['idrc'] . '"');
		
		include('lib/vendor/autoload.php');
		include('lib/html2openxml/HTMLtoOpenXML.php');
		include('edoc_rekammedik/new/erm_create_perkembangan_pasien_terintegrasi.php');
		erm_perkembangan_pasien_terintegrasi($_GET['idx']);
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=cppn&idx=<?php echo $_GET['idx']; ?>";
    </script>
    <?php
}
?>