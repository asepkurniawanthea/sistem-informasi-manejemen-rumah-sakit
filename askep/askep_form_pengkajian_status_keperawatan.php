<?php 
$sql_status_keperawatan = 'SELECT t_irna_askep_kajian_status_keperawatan.STATUS_KEPERAWATAN_ID,
							t_irna_askep_kajian_status_keperawatan.KELUHAN_UTAMA
							FROM t_irna_askep_kajian_status_keperawatan
							WHERE t_irna_askep_kajian_status_keperawatan.IRNA_ID = "' . $irna_id . '"';
$get_status_keperawatan = mysql_query($sql_status_keperawatan) or die(mysql_error());	
$dat_status_keperawatan = mysql_fetch_assoc($get_status_keperawatan);
$status_keperawatan_id = $dat_status_keperawatan['STATUS_KEPERAWATAN_ID']; 						
$keluhan_utama = $dat_status_keperawatan['KELUHAN_UTAMA']; 						
?>
<input type="hidden" name="status_keperawatan_id" value="<?php echo $status_keperawatan_id; ?>" />
<table border="0" width="100%">
	<tr>
		<td width="100px">Keluhan Utama</td><td><input type="text" name="keluhan_utama" value="<?php echo $keluhan_utama; ?>" class="text_dt" size="60" /></td>
	</tr>
</table>