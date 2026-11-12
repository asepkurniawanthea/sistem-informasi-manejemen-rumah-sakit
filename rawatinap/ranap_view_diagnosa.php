<style>
html {
	background:url(image/bg_pattern1.jpg);

}
</style>
<?php 
$irna_id = $_GET['idx'];
?>
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />
    <table class="tableData" id="tfhover" >
        <?php include('rawatinap/ranap_tmp_diagnosa.php'); ?>        
    </table>
	<table width="100%">
	<tr>
            <td colspan="5" align="right">&nbsp;</td>	
        </tr>
	</table>
</form>