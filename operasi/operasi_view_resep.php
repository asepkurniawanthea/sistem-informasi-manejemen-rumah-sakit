<?php 
$irna_id = $_GET['idx'];
?>
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="operasi_id" id="operasi_id" value="<?php echo $operasi_id; ?>" />
    <table class="tableData" id="tfhover" >
		<?php include('operasi/operasi_tmp_resep.php'); ?>
		<table width="100%" >
        <tr>
            <td colspan="12" align="right">&nbsp;</td>	
        </tr>
		    </table>
</form>