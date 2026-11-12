<?php 
$irna_id = $_GET['idx'];
?>
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <table class="tableData" id="tfhover" >
		<?php include('rawatinap/ranap_tmp_penunjang.php'); ?>
		</table>
</form>
<?php }else{ ?>
 <script language="JavaScript" >
    window.location = "index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&smn=dgns&idx=<?php echo $irna_id; ?>";
 </script>
<?php } ?>