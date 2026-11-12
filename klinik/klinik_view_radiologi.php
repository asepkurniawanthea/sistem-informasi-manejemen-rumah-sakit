<?php 
$irja_id = $_GET['idx'];
?>
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
	<input type="hidden" name="nomr" id="nomr" value="<?php echo $nomr; ?>" />
    <table class="tableData" id="tfhover" >
	<?php if($unit_id != '9'){ ?>
        <?php include('klinik/klinik_tmp_radiologi.php'); ?>
        <tr>
            <td colspan="5" align="right">Total Rp.&nbsp;&nbsp;<?php echo currFormat($total); ?> </td>
			<td colspan="4">&nbsp;</td>
        </tr>
    </table>	
		<?php }else{ ?>
		<?php include('klinik/klinik_tmp_radiologi_igd.php'); ?>
		</table>
		<?php } ?>
</form>