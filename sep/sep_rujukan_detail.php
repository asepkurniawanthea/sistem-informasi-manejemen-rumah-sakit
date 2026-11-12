<?php
if(isset($_GET['no_rujukan'])){
?>
<div id="peserta_detail" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<?php if(isset($_SESSION['SES_SIMRS_DETAIL_RUJUKAN'])){
	$arr_detail_rujukan = explode('||',$_SESSION['SES_SIMRS_DETAIL_RUJUKAN']);
	$norujukan = $arr_detail_rujukan[0];
	if($norujukan == $_GET['no_rujukan']){
		$json_response = json_decode($arr_detail_rujukan[1],true);
		$json_message = $json_response['metaData']['code']; 
		$json_rujukan = $json_response['response']['rujukan']; 
			
		if($json_message == '200'){
			$vw_response = '<table width="80%" border="0" class="tableData" >';
												
								foreach($json_rujukan as $key => $value){
											$key = str_replace('_',' ',$key);
										
											if(is_array($value)){
												$vw_response = $vw_response . '<tr>
															<th colspan="9">' . strtoupper($key) . '</th>
															</tr>';
															
													foreach($value as $key_l2 => $value_l2){
														$key_l2 = str_replace('_',' ',$key_l2);
														
														if(is_array($value_l2)){
															$vw_response = $vw_response . '<tr>
																		<td>&nbsp;</td>
																		<td colspan="8">' . ucwords($key_l2) . '</td>
																		</tr>';
																		
																foreach($value_l2 as $key_l3 => $value_l3){
																	$key_l3 = str_replace('_',' ',$key_l3);
																	
																	if(is_array($value_l3)){
																		$vw_response = $vw_response . '<tr>
																				<td>&nbsp;</td>
																				<td>&nbsp;</td>
																				<td colspan="7">' . ucwords($key_l3) . '</td>
																				</tr>';
																				
																			foreach($value_l3 as $key_l4 => $value_l4){
																				$key_l4 = str_replace('_',' ',$key_l4);
																				
																				if(is_array($value_l4)){
																					$vw_response = $vw_response . '<tr>
																						<td>&nbsp;</td>
																						<td>&nbsp;</td>
																						<td>&nbsp;</td>
																						<td colspan="6">' . ucwords($key_l4) . '</td>
																						</tr>';
																					
																						foreach($value_l4 as $key_l5 => $value_l5){
																							$key_l5 = str_replace('_',' ',$key_l5);
																							
																							if(is_array($value_l5)){
																								$vw_response = $vw_response . '<tr>
																										<td>&nbsp;</td>
																										<td>&nbsp;</td>
																										<td>&nbsp;</td>
																										<td>&nbsp;</td>
																										<td colspan="5">' . ucwords($key_l5) . '</td>
																										</tr>';
																									
																									foreach($value_l5 as $key_l6 => $value_l6){
																										$key_l6 = str_replace('_',' ',$key_l6);
																										
																										if(is_array($value_l6)){
																											$vw_response = $vw_response . '<tr>
																														<td>&nbsp;</td>
																														<td>&nbsp;</td>
																														<td>&nbsp;</td>
																														<td>&nbsp;</td>
																														<td>&nbsp;</td>
																														<td colspan="4">' . ucwords($key_l6) . '</td>
																														</tr>';
																														
																												foreach($value_l6 as $key_l7 => $value_l7){
																													$key_l7 = str_replace('_',' ',$key_l7);
																													
																													if(is_array($value_l7)){
																														$vw_response = $vw_response . '<tr>
																															<td>&nbsp;</td>
																															<td>&nbsp;</td>
																															<td>&nbsp;</td>
																															<td>&nbsp;</td>
																															<td>&nbsp;</td>
																															<td>&nbsp;</td>
																															<td colspan="3">' . ucwords($key_l6) . '</td>
																															</tr>';
																														foreach($value_l7 as $key_l8 => $value_l8){
																															$key_l8 = str_replace('_',' ',$key_l8);
																															
																															$vw_response = $vw_response . '<tr>
																																<td>&nbsp;</td>
																																<td>&nbsp;</td>
																																<td>&nbsp;</td>
																																<td>&nbsp;</td>
																																<td>&nbsp;</td>
																																<td>&nbsp;</td>
																																<td>&nbsp;</td>
																																<td>' . ucwords($key_l8) . '</td>
																																<td>:&nbsp;&nbsp;' . $value_l8 . '</td>
																																</tr>';
																														}	
																														
																													}else{
																														$vw_response = $vw_response . '<tr>
																																<td>&nbsp;</td>
																																<td>&nbsp;</td>
																																<td>&nbsp;</td>
																																<td>&nbsp;</td>
																																<td>&nbsp;</td>
																																<td>&nbsp;</td>
																																<td>' . ucwords($key_l7) . '</td>
																																<td colspan="2">:&nbsp;&nbsp;' . $value_l7 . '</td>
																																</tr>';
																													}
																												}			
																										}else{
																											$vw_response = $vw_response . '<tr>
																												<td>&nbsp;</td>
																												<td>&nbsp;</td>
																												<td>&nbsp;</td>
																												<td>&nbsp;</td>
																												<td>&nbsp;</td>
																												<td>' . ucwords($key_l6) . '</td>
																												<td colspan="3">:&nbsp;&nbsp;' . $value_l6 . '</td>
																												</tr>';
																										}
																									}
																								
																							}else{
																								$vw_response = $vw_response . '<tr>
																									<td>&nbsp;</td>
																									<td>&nbsp;</td>
																									<td>&nbsp;</td>
																									<td>&nbsp;</td>
																									<td>' . ucwords($key_l5) . '</td>
																									<td colspan="4">:&nbsp;&nbsp;' . $value_l5 . '</td>
																									</tr>';
																							}
																						}
																				}else{
																					$vw_response = $vw_response . '<tr>
																							<td>&nbsp;</td>
																							<td>&nbsp;</td>
																							<td>&nbsp;</td>
																							<td>' . ucwords($key_l4) . '</td>
																							<td colspan="5">:&nbsp;&nbsp;' . $value_l4 . '</td>
																							</tr>';
																				}
																			}	
																	
																	}else{
																		$vw_response = $vw_response . '<tr>
																				<td>&nbsp;</td>
																				<td>&nbsp;</td>
																				<td>' . ucwords($key_l3) . '</td>
																				<td colspan="6">:&nbsp;&nbsp;' . $value_l3 . '</td>
																				</tr>';
																	}			
																}		
														}else{
															$vw_response = $vw_response . '<tr>
																		<td>&nbsp;</td>
																		<td>' . ucwords($key_l2) . '</td>
																		<td colspan="7">:&nbsp;&nbsp;' . $value_l2 . '</td>
																		</tr>';
														}		
													}
												
											}else{
												$vw_response = $vw_response . '<tr>
														<td>' . ucwords($key) . '</td>
														<td colspan="8">:&nbsp;&nbsp;' . $value . '</td>
														</tr>';
											}		
								}
								
								$vw_response = $vw_response . '</table>';
				echo $vw_response;
			}else{
				echo $json_response['metaData']['message'];
			}
	}
}
?>
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<table width="100%" border="0">	
	<tr>
		<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
		<td align="right" width="200px"><input type="button" class="myButton" value="tutup" onclick="window.close();"  /></td>
	</tr>
</table>	
</div>	
<?php } ?>