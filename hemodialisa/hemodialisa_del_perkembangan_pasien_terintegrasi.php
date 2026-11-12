<?php
if (!isset($_GET['hapus'])) {
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $_GET['nmr']; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=cppn&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>&idrc=<?php echo $_GET['idrc']; ?>&hapus=1";
        }else{
			window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=cppn&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>";
		}
    </script>
    <?php
}
if (isset($_GET['hapus'])) {
		if($jns_order == ''){
			mysql_query('DELETE FROM t_irja_perkembangan WHERE IRJA_PERKEMBANGAN_ID = "' . $_GET['idrc'] . '"');
		}else{
			mysql_query('DELETE FROM t_hemodialisa_perkembangan WHERE HEMODIALISA_PERKEMBANGAN_ID = "' . $_GET['idrc'] . '"');
		}	
		
		include('lib/vendor/autoload.php');
		include('lib/html2openxml/HTMLtoOpenXML.php');
		include('edoc_rekammedik/new/erm_create_perkembangan_pasien_terintegrasi.php');
		erm_perkembangan_pasien_terintegrasi($idxord);
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=cppn&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>";
    </script>
    <?php
}
?>