<style>
html {
	background:url(image/bg_pattern1.jpg);

}
</style>
<?php 
$irna_id = $_GET['idx'];
if (isset($_POST['irna_id']))
    include('rawatinap/ranap_save_diagnosa.php');

if (isset($_GET['idg']))
    include('rawatinap/ranap_del_add_diagnosa.php');
?>
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />
	<input type="hidden" name="diagmasuk" id="diagmasuk" value="1" />
    <table class="tableData" id="tfhover" >
        <?php include('rawatinap/ranap_tmp_diagnosa.php'); ?>        
    </table>
	<table width="100%">
	<tr>
            <td colspan="5" align="right">
			<a href="#" onclick="window.open('index.php?popup=ranapformdiagnosa&idx=<?php echo $irna_id; ?>&diagmasuk=1','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=250')" ><input type="button" value="tambah" class="myButton1" /></a>
			<input type="hidden" name="cnr" value="<?php echo $i; ?>" />
			<input type="submit" name="simpan" value="simpan" class="myButton1" /></td>	
        </tr>
	</table>
</form>