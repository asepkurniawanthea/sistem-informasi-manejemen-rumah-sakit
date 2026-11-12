<?php
if(isset($_GET['nomr']) && isset($_GET['nosep']) && isset($_GET['idx']) && isset($_GET['jnsrawat']) && isset($_GET['mh']) && isset($_GET['nama_pasien'])){
$idx_rawat = $_GET['idx'];
$svrmh = $_GET['mh'];
$nomor_sep = $_GET['nosep'];
$nomr = $_GET['nomr'];
$jenis_rawat = $_GET['jnsrawat'];

$nama_pasien = $_GET['nama_pasien'];
$coder_nik = '';
if(isset($_SESSION['SES_SIMRS_CODER_NIK'])) $coder_nik = $_SESSION['SES_SIMRS_CODER_NIK']; 

$sql_claim = 'SELECT GROUPER_STAGE_1,GROUPER_STAGE_2,GROUPER_STAGE_1_RESPONSE,GROUPER_STAGE_2_RESPONSE
			FROM t_cbg_claim WHERE RAWAT_ID = "' . $idx_rawat . '"
			AND JNS_RAWAT = "' . $jenis_rawat . '"';
$get_claim = mysql_query($sql_claim) or die(mysql_error());
$dat_claim = mysql_fetch_assoc($get_claim);
$grouper_st1_response = $dat_claim['GROUPER_STAGE_1_RESPONSE']; 			
$grouper_st2_response = $dat_claim['GROUPER_STAGE_2_RESPONSE']; 			
?>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<table width="100%" border="0">
	<tr>
		<td>Nomor MR</td><td>:</td><td><?php echo formatNoMR($nomr); ?></td>
		<td>Nama Pasien</td><td>:</td><td><?php echo $nama_pasien; ?></td>
	</tr>
	<tr>
		<td>Nomor SEP</td><td>:</td><td><input type="text" name="nomor_sep" id="nomor_sep" value="<?php echo $nomor_sep; ?>" class="text_dt" size="30"/></td>
		<td>Coder NIK</td><td>:</td><td><input type="text" name="coder_nik" id="coder_nik" value="<?php echo $coder_nik; ?>" class="text_dt" size="30"/></td>
	</tr>	
</table>
<input type="hidden" name="idx_rawat" id="idx_rawat" value="<?php echo $idx_rawat; ?>" />
<input type="hidden" name="jns_rawat" id="jns_rawat" value="<?php echo $jenis_rawat; ?>" />
<input type="hidden" name="svrmh" id="svrmh" value="<?php echo $svrmh; ?>" />
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<table width="100%" border="0">	
	<tr>
		<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
		<td>&nbsp;</td>
		<td align="right"><image id="loader" src="/nsimrs/sep/image/loading_circle_green.gif" height="20px" width="20px" style="display:none" /></td>
		<td align="right" width="200px"><input type="button" class="myButton" value="grouping stage 1" onclick="grouping_st1('<?php echo $nomor_sep; ?>','<?php echo $idx_rawat; ?>','<?php echo $jenis_rawat; ?>','<?php echo $svrmh; ?>');"  />
		<input type="button" class="myButton" value="tutup" onclick="window.close();"  /></td>
	</tr>
</table>	
</div>
<div id="rs_grouping1" >
<?php if(!empty($grouper_st1_response)){ 
$grouper_st1_response = str_replace('&quot;','"',$grouper_st1_response);
$grouper_st1_decode = json_decode($grouper_st1_response,true);
$sco_cn = '';
								$vw_response = '<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
												<table width="80%" border="0" class="tableData" >';
												
								foreach($grouper_st1_decode as $key => $value){
									if($key != 'metadata'){
										if($key == 'special_cmg_option'){
											/* sco */
												$key = str_replace('_',' ',$key);
												
												if(is_array($value)){
												$vw_response = $vw_response . '<tr>
															<th colspan="5">' . strtoupper($key) . '</th>
															</tr>';
															
													foreach($value as $key_l2 => $value_l2){
														$key_l2 = str_replace('_',' ',$key_l2);
														
														if(is_array($value_l2)){
															$vw_response = $vw_response . '<tr>
																		<td>&nbsp;</td>
																		<td colspan="4">
																		<input type="checkbox" name="sco" value="' . $grouper_st1_decode['special_cmg_option'][$key_l2]['code'] . '" />
																		&nbsp;&nbsp;' . $key_l2 . '</td>
																		</tr>';
															$sco_cn = $key_l2;			
																		
																foreach($value_l2 as $key_l3 => $value_l3){
																	$key_l3 = str_replace('_',' ',$key_l3);
																	$vw_response = $vw_response . '<tr>
																				<td>&nbsp;</td>
																				<td>&nbsp;</td>
																				<td>' . ucwords($key_l3) . '</td>
																				<td colspan="2">:&nbsp;&nbsp;' . $value_l3 . '</td>
																				</tr>';
																}		
														}else{
															$vw_response = $vw_response . '<tr>
																		<td>&nbsp;</td>
																		<td>' . ucwords($key_l2) . '</td>
																		<td colspan="3">:&nbsp;&nbsp;' . $value_l2 . '</td>
																		</tr>';
														}		
													}
												
												}else{
													$vw_response = $vw_response . '<tr>
															<td>' . ucwords($key) . '</td>
															<td colspan="4">:&nbsp;&nbsp;' . $value . '</td>
															</tr>';
												}
											/* end sco */
										}else{
											$key = str_replace('_',' ',$key);
										
											if(is_array($value)){
												$vw_response = $vw_response . '<tr>
															<th colspan="5">' . strtoupper($key) . '</th>
															</tr>';
															
													foreach($value as $key_l2 => $value_l2){
														$key_l2 = str_replace('_',' ',$key_l2);
														
														if(is_array($value_l2)){
															$vw_response = $vw_response . '<tr>
																		<td>&nbsp;</td>
																		<td colspan="4">' . ucwords($key_l2) . '</td>
																		</tr>';
																		
																foreach($value_l2 as $key_l3 => $value_l3){
																	$key_l3 = str_replace('_',' ',$key_l3);
																	$vw_response = $vw_response . '<tr>
																				<td>&nbsp;</td>
																				<td>&nbsp;</td>
																				<td>' . ucwords($key_l3) . '</td>
																				<td colspan="2">:&nbsp;&nbsp;' . $value_l3 . '</td>
																				</tr>';
																}		
														}else{
															$vw_response = $vw_response . '<tr>
																		<td>&nbsp;</td>
																		<td>' . ucwords($key_l2) . '</td>
																		<td colspan="3">:&nbsp;&nbsp;' . $value_l2 . '</td>
																		</tr>';
														}		
													}
												
											}else{
												$vw_response = $vw_response . '<tr>
														<td>' . ucwords($key) . '</td>
														<td colspan="4">:&nbsp;&nbsp;' . $value . '</td>
														</tr>';
											}
										}	
									}	
								}
								
								$vw_response = $vw_response . '</table></div>';
								$vw_response = $vw_response . '<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
													<table width="100%" border="0">	
														<tr>
															<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
															<td>&nbsp;</td>
															<td align="right"><image id="loader2" src="/nsimrs/sep/image/loading_circle_green.gif" height="20px" width="20px" style="display:none" /></td>
															<td align="right" width="200px">
															<input type="hidden" name="sco_cn" id="sco_cn" value="' . $sco_cn . '" />
															<input type="button" class="myButton" value="grouping stage 2" onclick="grouping_st2(' . $svrmh . ')"  />
															<input type="button" class="myButton" value="tutup" onclick="window.close();"  /></td>
														</tr>
													</table></div>';
	echo $vw_response;												
} ?>
</div>
<div id="rs_grouping2" >
<?php if(!empty($grouper_st2_response)){ 
$grouper_st2_response = str_replace('&quot;','"',$grouper_st2_response);
$grouper_st2_decode = json_decode($grouper_st2_response,true);
								$vw_response = '<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
												<table width="80%" border="0" class="tableData" >';
												
								foreach($grouper_st2_decode as $key => $value){
									if($key != 'metadata'){
											$key = str_replace('_',' ',$key);
										
											if(is_array($value)){
												$vw_response = $vw_response . '<tr>
															<th colspan="5">' . strtoupper($key) . '</th>
															</tr>';
															
													foreach($value as $key_l2 => $value_l2){
														$key_l2 = str_replace('_',' ',$key_l2);
														
														if(is_array($value_l2)){
															$vw_response = $vw_response . '<tr>
																		<td>&nbsp;</td>
																		<td colspan="4">' . ucwords($key_l2) . '</td>
																		</tr>';
																		
																foreach($value_l2 as $key_l3 => $value_l3){
																	$key_l3 = str_replace('_',' ',$key_l3);
																	
																	if(is_array($value_l3)){
																		$vw_response = $vw_response . '<tr>
																				<td>&nbsp;</td>
																				<td>&nbsp;</td>
																				<td colspan="3">' . ucwords($key_l3) . '</td>
																				</tr>';
																		foreach($value_l3 as $key_l4 => $value_l4){
																			$key_l4 = str_replace('_',' ',$key_l4);
																			
																			$vw_response = $vw_response . '<tr>
																					<td>&nbsp;</td>
																					<td>&nbsp;</td>
																					<td>' . ucwords($key_l4) . '</td>
																					<td colspan="2">:&nbsp;&nbsp;' . $value_l4 . '</td>
																					</tr>';
																		}	
																	}else{
																		$vw_response = $vw_response . '<tr>
																				<td>&nbsp;</td>
																				<td>&nbsp;</td>
																				<td>' . ucwords($key_l3) . '</td>
																				<td colspan="2">:&nbsp;&nbsp;' . $value_l3 . '</td>
																				</tr>';
																	}			
																}		
														}else{
															$vw_response = $vw_response . '<tr>
																		<td>&nbsp;</td>
																		<td>' . ucwords($key_l2) . '</td>
																		<td colspan="3">:&nbsp;&nbsp;' . $value_l2 . '</td>
																		</tr>';
														}		
													}
												
											}else{
												$vw_response = $vw_response . '<tr>
														<td>' . ucwords($key) . '</td>
														<td colspan="4">:&nbsp;&nbsp;' . $value . '</td>
														</tr>';
											}	
									}	
								}
								
								$vw_response = $vw_response . '</table></div>';
	echo $vw_response;							
} ?>
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<table width="100%" border="0">	
	<tr>
		<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
		<td>&nbsp;</td>
		<td align="right"><image id="loader3" src="/nsimrs/sep/image/loading_circle_green.gif" height="20px" width="20px" style="display:none" /></td>
		<td align="right" width="200px"><input type="button" class="myButton" value="final klaim" onclick="klaim_final('<?php echo $svrmh; ?>');klaim_detail('<?php echo $nomor_sep; ?>','<?php echo $svrmh; ?>','<?php echo $idx_rawat; ?>','<?php echo $jenis_rawat; ?>');"  />
		<input type="button" class="myButton" value="tutup" onclick="window.close();"  /></td>
	</tr>
</table>	
<?php } ?>