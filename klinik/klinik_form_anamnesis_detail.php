<?php
$p_anamnesis[1] = '';
$p_anamnesis[2] = '';
$p_anamnesis[3] = '';
$p_anamnesis[4] = '';
$p_anamnesis_array = explode('|*|',$anamnesis);
$anam_count = sizeof($p_anamnesis_array); 
if($anam_count >= 4){
	$x = 1;
	while($x <= 4){
		$p_anamnesis[$x] = $p_anamnesis_array[$x - 1]; 	
	$x++;
	}
} 
if(!empty($anamnesis) and ($anam_count == 1)){
?>
<textarea class="text_dt2" name="anamnesis" id="anamnesis" cols="80" rows="5"><?php echo $anamnesis; ?></textarea>    
<?php }else{ ?>
	<table border="0" width="100%">
		<tr>
			<td>Keluhan Utama</td>
			<td>:</td>
			<td colspan="5"><textarea name="p_anamnesis_1" class="text_dt5" ><?php echo $p_anamnesis[1]; ?></textarea></td>
		</tr>	
		<tr>
			<td>Riwayat Penyakit Sekarang</td>
			<td>:</td>
			<td colspan="5"><textarea name="p_anamnesis_2" class="text_dt5" ><?php echo $p_anamnesis[2]; ?></textarea></td>
		</tr>
		<tr>
			<td>Riwayat Penyakit Dahulu<br />dan Terapinya</td>
			<td>:</td>
			<td colspan="5"><textarea name="p_anamnesis_3" class="text_dt5" ><?php echo $p_anamnesis[3]; ?></textarea></td>
		</tr>
		<tr>
			<td>Riwayat Penyakit Keluarga</td>
			<td>:</td>
			<td colspan="5"><textarea name="p_anamnesis_4" class="text_dt5" ><?php echo $p_anamnesis[4]; ?></textarea></td>
		</tr>	
	</table>					
<?php } ?>