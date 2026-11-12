<?php 
$irna_id = $_GET['idx'];
?>
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />
	<input type="hidden" name="nomr" id="nomr" value="<?php echo $nomr; ?>" />
    <table class="tableData" id="tfhover" >
		<?php include('rawatinap/ranap_tmp_radiologi.php'); ?>
		</table>
		<table width="100%">	
        <tr>
            <td colspan="9" align="right">&nbsp;</td>	
        </tr>
		</table>
</form>