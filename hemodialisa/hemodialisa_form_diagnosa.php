<style>
html {
	background:url(image/bg_pattern1.jpg);

}
</style>
<?php 
$irja_id = $_GET['idx'];
if($status_anamnesis == '1'){

if (isset($_POST['irja_id']))
    include('hemodialisa/hemodialisa_save_diagnosa.php');

if (isset($_GET['idg']))
    include('hemodialisa/hemodialisa_del_add_diagnosa.php');			
?>
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
	<input type="hidden" name="jns_order" id="jns_order" value="<?php echo $jns_order; ?>" />
    <table class="tableData" id="tfhover" >
        <?php include('hemodialisa/hemodialisa_tmp_diagnosa.php'); ?>        
    </table>
	<table width="100%">
	<tr>
            <td colspan="5" align="right">
			<a href="#" onclick="window.open('index.php?popup=hemodialisaformdiagnosa&idx=<?php echo $irja_id; ?>&ord=<?php echo $jns_order; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=520')" ><input type="button" value="tambah" class="myButton1" /></a>
			<input type="hidden" name="cnr" value="<?php echo $i; ?>" />
			<input type="submit" name="simpan" value="simpan" class="myButton1" /></td>	
        </tr>
	</table>
</form>
<?php }else{ ?>
 <script language="JavaScript" >
    window.location = "index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&idx=<?php echo $irja_id; ?>&ord=<?php echo $jns_order; ?>";
 </script>
<?php } ?>