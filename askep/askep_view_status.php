<?php 
$irna_id = $_GET['idx'];
$qry_askep = 'SELECT ST_ASKEP FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
$get_askep = mysql_query($qry_askep) or die(mysql_error());
$dat_askep = mysql_fetch_assoc($get_askep);
$st_askep = $dat_askep['ST_ASKEP']; 
?>
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />
		<table width="100%" >
        <tr>
            <td colspan="12" align="center">	
			<input type="checkbox" name="st_askep" value="1" <?php if($st_askep == '1') echo 'checked="checked"'; ?> />&nbsp;Selesai</td>	
        </tr>
		</table>
</form>