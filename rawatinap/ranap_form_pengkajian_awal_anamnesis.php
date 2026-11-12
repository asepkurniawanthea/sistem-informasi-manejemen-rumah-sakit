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

$sql_alergi = 'SELECT t_irja_alergi.IRJA_ALERGI_ID,t_irja_alergi.IRJA_ID,t_irja_alergi.ALERGI
				 FROM t_irja_alergi 
				 WHERE t_irja_alergi.IRJA_ID = "' . $irja_id . '"';
$get_alergi = mysql_query($sql_alergi) or die(mysql_error());	

if(!empty($anamnesis) and ($anam_count == 1)){
	$alergi = '';
	if(mysql_num_rows($get_alergi) > 0){
		$alergi = '<br />&nbsp;&nbsp;Alergi : ';
		while($dat_alergi = mysql_fetch_array($get_alergi)){
				$alergi = $alergi . $dat_alergi['ALERGI'] . ',';
		}
		$alergi = substr($alergi,0,strlen($alergi) - 1);
	}	

echo ':&nbsp;' . setIfNull($anamnesis . $alergi); 
}else{ ?>
	<table border="0" width="100%">
		<tr>
			<td width="180px">Keluhan Utama</td>
			<td width="10px">:</td>
			<td colspan="5"><?php echo setIfNull($p_anamnesis[1]); ?></td>
		</tr>	
		<tr>
			<td>Riwayat Penyakit Sekarang</td>
			<td>:</td>
			<td colspan="5"><?php echo setIfNull($p_anamnesis[2]); ?></td>
		</tr>
		<tr>
			<td>Riwayat Penyakit Dahulu<br />dan Terapinya</td>
			<td>:</td>
			<td colspan="5"><?php echo setIfNull($p_anamnesis[3]); ?></td>
		</tr>
		<tr>
			<td>Riwayat Penyakit Keluarga</td>
			<td>:</td>
			<td colspan="5"><?php echo setIfNull($p_anamnesis[4]); ?></td>
		</tr>
	<?php if(mysql_num_rows($get_alergi) == 0){  ?>
		<tr>
			<td>Alergi</td>
			<td>:</td>
			<td colspan="5">-</td>
		</tr>
	<?php }else{ 
		$d = 1;
		while($dat_alergi = mysql_fetch_array($get_alergi)){
		if($d == 1){ ?>
			<tr>
				<td>Alergi</td>
				<td>:</td>
				<td colspan="5"><?php echo $dat_alergi['ALERGI']; ?></td>
			</tr>
		<?php }else{ ?>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan="5"><?php echo $dat_alergi['ALERGI']; ?></td>
			</tr>
		<?php }
		$d++; }	
		} ?>	
	</table>					
<?php } ?>