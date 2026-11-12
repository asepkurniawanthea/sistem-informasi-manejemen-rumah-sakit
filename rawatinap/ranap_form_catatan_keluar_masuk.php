<style>
html {
	background:url(image/bg_pattern1.jpg);

}
</style>
<?php 
$irna_id = $_GET['idx'];

if (isset($_GET['ido']))
    include('rawatinap/ranap_del_add_catatan_keluar_masuk.php');

$irna_id = $_GET['idx'];
?>
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />
    <table class="tableData" id="tfhover" >
        <?php include('rawatinap/ranap_tmp_catatan_keluar_masuk.php'); ?>        
    </table>
	<table width="100%">
	<tr>
            <td colspan="5" align="right">
			<a href="#" onclick="window.open('index.php?popup=ranapformcatatankeluarmasuk&idx=<?php echo $irna_id; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=350')" ><input type="button" value="tambah" class="myButton1" /></a>
			</td>	
        </tr>
	</table>
</form>