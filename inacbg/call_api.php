<?php
function sendData($url,$content){
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch,CURLOPT_HEADER, false);
	curl_setopt($ch,CURLOPT_ENCODING, '');
	curl_setopt($ch,CURLOPT_USERAGENT, 'rsk-sitanala');
	curl_setopt($ch,CURLOPT_AUTOREFERER, true);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,30);
	curl_setopt($ch,CURLOPT_TIMEOUT, 60);
	curl_setopt($ch,CURLOPT_MAXREDIRS, 10);
	curl_setopt($ch,CURLOPT_POST, true);
	curl_setopt($ch,CURLOPT_POSTFIELDS,$content);
	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch,CURLOPT_VERBOSE, true);
	$output = curl_exec($ch);
	
	return $output;	
}

if(isset($_GET['method']) and isset($_GET['svrmh'])){ 
	$url = 'http://' . $inacbgs_host . '/simrs2inacbg/index.php?';
	foreach($_GET as $key => $value){
		$url = $url . $key . '=' . $value . '&';
	}
	$url = substr($url,0,strlen($url) - 1);
	
	$content = '';
	foreach($_POST as $key => $value){
		if(is_array($value)){
			$scontent = '';
			foreach($value as $skey => $svalue){
				$scontent = $scontent . $key . '[' . $skey . ']=' . $svalue . '&';	
			}
			$content = $content . $scontent;	
		}else{
			$content = $content . $key . '=' . $value . '&';	
		}
	}
	$content = substr($content,0,strlen($content) - 1);
	$response = @sendData($url,$content);
	
	$method = $_GET['method'];
	
	$ret = '';
	if($response){
		if($response == 'fail'){
			$ret = 'Bridging Gagal.' . PHP_EOL . 'Cek Koneksi Ke Server.';
		}else{
			
			$json_response = json_decode($response,true); 

			if(isset($json_response['metadata']['code'])){
				$kode = $json_response['metadata']['code'];
				$message = $json_response['metadata']['message'];
				
				if($kode == '200'){
							
					switch($method) {
						case 'new_claim':
								
							mysql_query('INSERT INTO t_cbg_claim(RAWAT_ID,NO_SEP,NOMR,NO_PESERTA,
									NAMA_PASIEN,TGL_LAHIR,JNS_KELAMIN,JNS_RAWAT,KLAIM_BARU,USER_CASEMIX)
									VALUES("' . $_POST['idx_rawat'] . '","' . $_POST['nomor_sep'] . '","' . $_POST['nomor_rm'] . '","' . $_POST['nomor_kartu'] . '",
									"' . $_POST['nama_pasien'] . '",STR_TO_DATE("' . $_POST['tgl_lahir'] . '","%Y-%m-%d %H:%i:%s"),"' . $_POST['gender'] . '",
									"' . $_POST['jns_rawat'] . '","1","' . currentUser() . '")') or die(mysql_error());
							$ret = 'Membuat Klaim Baru (' . $_POST['nomor_sep'] . ') Berhasil.';		
							break;	
							
						case 'update_patient':	
						
							mysql_query('UPDATE t_cbg_claim SET NO_PESERTA = "' . $_POST['nomor_kartu'] . '",NO_SEP = "' . $_POST['nomor_sep'] . '",
									NOMR = "' . $_POST['nomor_rm'] . '",NAMA_PASIEN = "' . $_POST['nama_pasien'] . '",
									TGL_LAHIR = STR_TO_DATE("' . $_POST['tgl_lahir'] . '","%Y-%m-%d %H:%i:%s"),JNS_KELAMIN = "' . $_POST['gender'] . '", 
									UPDATE_PASIEN = "1",USER_CASEMIX = "' . currentUser() . '"
									WHERE RAWAT_ID = "' . $_POST['idx_rawat'] . '" AND JNS_RAWAT = "' . $_POST['jns_rawat'] . '"') or die(mysql_error());
							$ret = 'Update Data Pasien (' . $_POST['nomor_sep'] . ') Berhasil.';				
							break;
						
						case 'delete_patient':	
						
							mysql_query('UPDATE t_cbg_claim SET HAPUS_PASIEN = "1",USER_CASEMIX = "' . currentUser() . '"
									WHERE RAWAT_ID = "' . $_POST['idx_rawat'] . '" AND JNS_RAWAT = "' . $_POST['jns_rawat'] . '"') or die(mysql_error());
							$ret = 'Hapus Data Pasien (' . $_POST['nomor_sep'] . ') Berhasil.';						
							break;	
						
						case 'set_claim_data':	
							
							mysql_query('UPDATE t_cbg_claim SET UPDATE_KLAIM = "1",DIAGNOSA = "' . $_POST['diagnosa'] . '",
									TARIF_RS = "' . $_POST['tarif_rsx'] . '",JAMINAN_ID = "' . $_POST['jns_bayar'] . '",
									TANGGAL = STR_TO_DATE("' . $_POST['tgl_masuk'] . '","%d-%m-%Y %H:%i:%s"),
									KELAS_RAWAT = "' . $_POST['kelas_rawat'] . '",KELAS_RS = "' . $_POST['kode_tarif'] . '",
									USER_CASEMIX = "' . currentUser() . '"
									WHERE RAWAT_ID = "' . $_POST['idx_rawat'] . '" AND JNS_RAWAT = "' . $_POST['jns_rawat'] . '"') or die(mysql_error());
							
							$_SESSION['SES_SIMRS_CODER_NIK'] = $_POST['coder_nik'];
							$ret = 'Isi & Update Data Klaim (' . $_POST['nomor_sep'] . ') Berhasil.';				
							break;

						case 'grouper':	
							
							if($_GET['stage'] == 1){
								
								$str_response = str_replace('"','&quot;',$response);
								
								mysql_query('UPDATE t_cbg_claim SET GROUPER_STAGE_1 = "1",GROUPER_STAGE_1_RESPONSE = "' . $str_response . '",
									USER_CASEMIX = "' . currentUser() . '"
									WHERE RAWAT_ID = "' . $_POST['idx_rawat'] . '" AND JNS_RAWAT = "' . $_POST['jns_rawat'] . '"') or die(mysql_error());
								
								$sco_cn = '';
								$vw_response = '<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
												<table width="80%" border="0" class="tableData" >';
												
								foreach($json_response as $key => $value){
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
																		<input type="checkbox" name="sco" value="' . $json_response['special_cmg_option'][$key_l2]['code'] . '" />
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
															<input type="button" class="myButton" value="grouping stage 2" onclick="grouping_st2(' . $_GET['svrmh'] . ')"  />
															<input type="button" class="myButton" value="tutup" onclick="window.close();"  /></td>
														</tr>
													</table></div>';
								$ret = 'Grouping Stage 1 (' . $_POST['nomor_sep'] . ') Berhasil.|' . $vw_response;
									
							}else if($_GET['stage'] == 2){
								$str_response = str_replace('"','&quot;',$response);
								
								mysql_query('UPDATE t_cbg_claim SET GROUPER_STAGE_2 = "1",GROUPER_STAGE_2_RESPONSE = "' . $str_response . '",
									USER_CASEMIX = "' . currentUser() . '"
									WHERE RAWAT_ID = "' . $_POST['idx_rawat'] . '" AND JNS_RAWAT = "' . $_POST['jns_rawat'] . '"') or die(mysql_error());
									
								$vw_response = '<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
												<table width="80%" border="0" class="tableData" >';
												
								foreach($json_response as $key => $value){
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
								$ret = 'Grouping Stage 2 (' . $_POST['nomor_sep'] . ') Berhasil.|' . $vw_response;	
							}		
							break;

						case 'claim_final':	

							$str_response = str_replace('"','&quot;',$response);
								
							mysql_query('UPDATE t_cbg_claim SET KLAIM_FINAL = "1",USER_CASEMIX = "' . currentUser() . '",
									FINAL_KLAIM_RESPONSE = "' . $str_response . '"
									WHERE RAWAT_ID = "' . $_POST['idx_rawat'] . '" AND JNS_RAWAT = "' . $_POST['jns_rawat'] . '"') or die(mysql_error());
							$ret = 'Final Klaim (' . $_POST['nomor_sep'] . ') Berhasil.';			
							break;
								
						case 'reedit_claim':
							
							mysql_query('UPDATE t_cbg_claim SET KLAIM_REEDIT = "1",USER_CASEMIX = "' . currentUser() . '"
									WHERE RAWAT_ID = "' . $_POST['idx_rawat'] . '" AND JNS_RAWAT = "' . $_POST['jns_rawat'] . '"') or die(mysql_error());
							$ret = 'Reedit Klaim (' . $_POST['nomor_sep'] . ') Berhasil.';					
							break;

						case 'send_claim_individual':	

							mysql_query('UPDATE t_cbg_claim SET KLAIM_SEND = "1",USER_CASEMIX = "' . currentUser() . '"
									WHERE RAWAT_ID = "' . $_POST['idx_rawat'] . '" AND JNS_RAWAT = "' . $_POST['jns_rawat'] . '"') or die(mysql_error());
							$tgl_pulang = $json_response['response']['data']['tgl_pulang'];
							$kemkes_dc_status = $json_response['response']['data']['kemkes_dc_Status'];
							$bpjs_dc_status = $json_response['response']['data']['bpjs_dc_Status'];
							$ret = 'Send Klaim (' . $_POST['nomor_sep'] . ') Berhasil.';			
							$ret = $ret . 'Tanggal Pulang : ' . $tgl_pulang . PHP_EOL;	
							$ret = $ret . 'Kemkes Dc Status : ' . $kemkes_dc_status . PHP_EOL;	
							$ret = $ret . 'Bpjs Dc Status : ' . $bpjs_dc_status;	
							break;	
							
						case 'get_claim_data':	
						
							$vw_response = '<table width="80%" border="0" class="tableData" >';
												
								foreach($json_response as $key => $value){
									if($key != 'metadata'){
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
								}
								
								$vw_response = $vw_response . '</table>';
								
								$tarif_kelas_1 = '';
								$tarif_kelas_2 = '';
								$tarif_kelas_3 = '';
								
								if(isset($json_response['response']['data']['grouper']['tarif_alt'][0]['tarif_inacbg']))
									$tarif_kelas_1 = $json_response['response']['data']['grouper']['tarif_alt'][0]['tarif_inacbg'];
								if(isset($json_response['response']['data']['grouper']['tarif_alt'][1]['tarif_inacbg']))
									$tarif_kelas_2 = $json_response['response']['data']['grouper']['tarif_alt'][1]['tarif_inacbg'];
								if(isset($json_response['response']['data']['grouper']['tarif_alt'][2]['tarif_inacbg']))
									$tarif_kelas_3 = $json_response['response']['data']['grouper']['tarif_alt'][2]['tarif_inacbg'];
								
								mysql_query('UPDATE t_cbg_claim SET TARIF_CBG_KELAS_1 = "' . $tarif_kelas_1 . '",
											TARIF_CBG_KELAS_2 = "' . $tarif_kelas_2 . '",TARIF_CBG_KELAS_3 = "' . $tarif_kelas_3 . '"
											WHERE RAWAT_ID = "' . $_POST['idx_rawat'] . '" AND JNS_RAWAT = "' . $_POST['jns_rawat'] . '"') or die(mysql_error());
								$ret = 'Ambil Detail Klaim (' . $_POST['nomor_sep'] . ') Berhasil.|' . $vw_response;	
							break;		

						case 'get_claim_status':
							
							$kd_status_sep = $json_response['response']['kdStatusSep'];
							$nm_status_sep = $json_response['response']['nmStatusSep'];
							$ret = 'Ambil Status Klaim (' . $_POST['nomor_sep'] . ') Berhasil.';			
							$ret = $ret . 'Kode Status SEP : ' . $kd_status_sep . PHP_EOL;	
							$ret = $ret . 'Nama Status SEP : ' . $nm_status_sep;							
							break;
							
						case 'delete_claim':
							
							mysql_query('DELETE FROM t_cbg_claim WHERE RAWAT_ID = "' . $_POST['idx_rawat'] . '" AND JNS_RAWAT = "' . $_POST['jns_rawat'] . '"') or die(mysql_error());
							
							$ret = 'Hapus Klaim (' . $_POST['nomor_sep'] . ') Berhasil.';
							break;
					}		
							
				}else{
					$ret = $message;
				}		
			}else{
				$ret = $response;
			} 
		}
	}else{
		$ret = 'Bridging Gagal.' . PHP_EOL . 'Cek Koneksi Ke Server.';
	}	
		
	echo $ret;
}
?>