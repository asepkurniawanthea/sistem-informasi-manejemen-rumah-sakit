<?php
$arr_poli[1] = 'INT'; //penyakit dalam
$arr_poli[2] = 'OBG'; //kebidanan & kandungan
$arr_poli[3] = 'ANA'; //poli anak
$arr_poli[4] = 'BED'; //bedah umum
$arr_poli[5] = 'GIG'; //gigi
$arr_poli[6] = 'JIW'; //kesehatan jiwa
$arr_poli[8] = 'ANT'; //anestesi
$arr_poli[9] = 'IGD'; //igd
$arr_poli[17] = 'RAD'; //radiologi NO
$arr_poli[18] = 'GIZ'; //gizi NO
$arr_poli[29] = 'MAT'; //mata
$arr_poli[30] = 'PAR'; //paru
$arr_poli[31] = 'IRM'; //fisioterapi
$arr_poli[34] = 'IRM'; //rehab medik
$arr_poli[35] = 'KLT'; //kusta
//$arr_poli[35] = 'LAY'; //kusta
$arr_poli[36] = 'ORT'; //orthopedi
$arr_poli[37] = 'BDP'; //bedah plastik
$arr_poli[38] = 'HAM'; //poli umum NO
$arr_poli[40] = 'IRM'; //terapi wicara
$arr_poli[41] = 'IRM'; //okupasi terapi
$arr_poli[42] = 'IRM'; //protesa
$arr_poli[43] = 'SAR'; //saraf
$arr_poli[44] = 'KLT'; //kulit & kelamin
$arr_poli[45] = 'LAB'; //laboratorium NO
$arr_poli[47] = 'IRM'; //psikologi
$arr_poli[48] = 'IRM'; //rehabilitasi sosial
$arr_poli[49] = 'IRM'; //rehabilitasi karya
$arr_poli[50] = ''; //rawat inap NO
$arr_poli[51] = 'IRM'; //perawatan luka
$arr_poli[52] = 'EKG'; //r ekg/eeg/usg NO
$arr_poli[53] = 'OBG'; //kb
$arr_poli[54] = 'ELK'; //eksekutif alamanda
$arr_poli[55] = 'HDL'; //hemodialisa
$arr_poli[56] = 'BED'; //kamar operasi
$arr_poli[57] = 'THT'; //THT
$arr_poli[58] = '006'; //GERIATRI
$arr_poli[60] = 'JAN'; //JANTUNG DAN PEMBULUH DARAH

$arr_eksekutif = array(54); 

function sendData($url,$content,$method){
	global $rs_account;
	
	date_default_timezone_set('UTC');
	$tm_stamp 	= strval(time()-strtotime('1970-01-01 00:00:00'));
	$signature 	= hash_hmac('sha256', $rs_account['id'] . '&' . $tm_stamp, $rs_account['key'], true);
	$ec_signature = base64_encode($signature);
		
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch,CURLOPT_HEADER, false);
	curl_setopt($ch,CURLOPT_ENCODING, '');
	curl_setopt($ch,CURLOPT_USERAGENT, 'rsk-sitanala');
	curl_setopt($ch,CURLOPT_AUTOREFERER, true);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,30);
	curl_setopt($ch,CURLOPT_TIMEOUT, 5);
	curl_setopt($ch,CURLOPT_MAXREDIRS, 10);
	if($method == 'POST'){
		curl_setopt($ch,CURLOPT_POST, true);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$content);
	}else if($method == 'GET'){
		curl_setopt($ch,CURLOPT_POST, false);
	}else{
		curl_setopt($ch,CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$content);
	}	
	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch,CURLOPT_VERBOSE, true);
	curl_setopt($ch,CURLOPT_HTTPHEADER, array(
		'X-cons-id : '	. $rs_account['id'],
		'X-timestamp : '	. $tm_stamp,
		'X-signature : '	. $ec_signature,
		'Content-Type: Application/x-www-form-urlencoded'
	));
	
	$output = curl_exec($ch);
	
	return $output;	
}	

$ws_host	= 'https://' . $bpjs_host . '/new-vclaim-rest/';
	
if(isset($_POST['request'])){
	$response = '';
		
	switch($_POST['request']){
		
		case 'getPeserta' :
			$tgl_sep = date('Y-m-d');
			$url = $ws_host . 'Peserta/nokartu/' . $_POST['no_peserta'] . '/tglSEP/' . $tgl_sep; 	
			if($_POST['option'] == 2) $url = $ws_host . 'Peserta/nik/' . $_POST['no_peserta'] . '/tglSEP/' . $tgl_sep; 	
			$response = @sendData($url,'','GET');		
			break;
			
		case 'getDetail' :
		
			$tgl_sep = date('Y-m-d');
			$url = $ws_host . 'Peserta/nokartu/' . $_POST['no_peserta'] . '/tglSEP/' . $tgl_sep; 	
			if($_POST['option'] == 2) $url = $ws_host . 'Peserta/nik/' . $_POST['no_peserta'] . '/tglSEP/' . $tgl_sep; 	
			$response = @sendData($url,'','GET');	
			$json_response = json_decode($response,true);
			$json_peserta = $json_response['response']['peserta']; 
			
			$vw_response = '<table width="80%" border="0" class="tableData" >';
												
								foreach($json_peserta as $key => $value){
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
				$response = $vw_response;
			break;
			
		case 'createSEP' :
		
			$url = $ws_host . 'SEP/1.1/insert'; 
			$arr_post = array();
			$eks = '0';
			foreach($_POST as $key => $value){
				if(is_array($value)){
					foreach($value as $key2 => $value2){
						if($key2 == 'tujuan'){
							if(in_array($value2,$arr_eksekutif)) $eks = '1';  
							$arr_post[$key]['tujuan'] = $arr_poli[$value2];
						}else if($key2 == 'eksekutif'){
							$arr_post[$key]['eksekutif'] = $eks;
						}else{	
							$arr_post[$key][$key2] = $value2;
						}
					}
				}else{
					if($key != 'request'){
						if($key == 'ppkPelayanan'){
							$arr_post['ppkPelayanan'] = $rs_account['code'];
						}else if($key == 'user'){
							$arr_post['user'] = $rs_account['user'];
						}else{	
							$arr_post[$key] = $value;
						}	
					}
				}	
			}
			
			$data = array('request' => array('t_sep' => $arr_post));
			$fcontent = json_encode($data);
			$response = @sendData($url,$fcontent,'POST');		
			
			break;
			
		case 'updateSEP' :
		
			$url = $ws_host . 'Sep/Update'; 
			$arr_post = array();
			$eks = '0';
			foreach($_POST as $key => $value){
				if(is_array($value)){
					foreach($value as $key2 => $value2){
						if($key2 == 'tujuan'){
							if(in_array($value2,$arr_eksekutif)) $eks = '1';  
							$arr_post[$key]['tujuan'] = $arr_poli[$value2];
						}else if($key2 == 'eksekutif'){
							$arr_post[$key]['eksekutif'] = $eks;
						}else{	
							$arr_post[$key][$key2] = $value2;
						}
					}
				}else{
					if($key != 'request'){
						if($key == 'user'){
							$arr_post['user'] = $rs_account['user'];
						}else{	
							$arr_post[$key] = $value;
						}	
					}
				}	
			}
			
			$data = array('request' => array('t_sep' => $arr_post));
			$fcontent = json_encode($data);
			$response = @sendData($url,$fcontent,'PUT');		
			
			break;	
			
		case 'deleteSEP' :
		
			$url = $ws_host . 'SEP/Delete'; 
			$arr_post = array();
			foreach($_POST as $key => $value){
				if($key != 'request'){
					if($key == 'user'){
						$arr_post['user'] = $rs_account['user'];
					}else{	
						$arr_post[$key] = $value;
					}	
				}
			}
			
			$data = array('request' => array('t_sep' => $arr_post));
			$fcontent = json_encode($data);
			$response = @sendData($url,$fcontent,'DELETE');		
			
			break;		
			
		case 'updatePulang' :
		
			$url = $ws_host . 'Sep/updtglplg'; 
			$arr_post = array();
			foreach($_POST as $key => $value){
				if($key != 'request'){
					if($key == 'user'){
						$arr_post['user'] = $rs_account['user'];
					}else{	
						$arr_post[$key] = $value;
					}	
				}
			}
			
			$data = array('request' => array('t_sep' => $arr_post));
			$fcontent = json_encode($data);
			$response = @sendData($url,$fcontent,'PUT');		
			
			break;			
			
		case 'updatePulangPaksa' :
		
			$url = $ws_host . 'Sep/updtglplg'; 
			$arr_post = array();
			foreach($_POST as $key => $value){
				if($key != 'request'){
					if($key == 'user'){
						$arr_post['user'] = $rs_account['user'];
					}else{	
						if($key == 'noSep'){
							$sep = '';
							$msg_sep = strtoupper($value);
							$arr_msg_sep = explode('NO.SEP',$msg_sep);
							if(sizeof($arr_msg_sep) > 0){
								$msg_sep = trim($arr_msg_sep[1]);
								$arr_sep = explode(' ',$msg_sep);
								if(sizeof($arr_sep) > 0){
									$sep = $arr_sep[0];
								}
							}
							$arr_post['noSep'] = $sep;
						}else{
							$arr_post[$key] = $value;
						}	
					}	
				}
			}
			
			$data = array('request' => array('t_sep' => $arr_post));
			$fcontent = json_encode($data);
			$response = @sendData($url,$fcontent,'PUT');		
			
			break;
			
			case 'getListNorujukan' :
			
			$url = $ws_host . 'Rujukan/RS/List/Peserta/' . $_POST['no_peserta'];
			$response = @sendData($url,'','GET');
			$json_response = json_decode($response,true);
			$json_rujukan = $json_response['response']['rujukan'];
			$arr_response = array();
			if(is_array($json_rujukan)){
				foreach($json_rujukan as $value){
					array_push($arr_response,$value['noKunjungan']);
					//$arr_response[] = $value['noKunjungan'];
				}	
			}
			
			$url = $ws_host . 'Rujukan/List/Peserta/' . $_POST['no_peserta'];
			$response = @sendData($url,'','GET');
			$json_response = json_decode($response,true);
			$json_rujukan = $json_response['response']['rujukan'];
			if(is_array($json_rujukan)){
				foreach($json_rujukan as $value){
					array_push($arr_response,$value['noKunjungan']);
					//$arr_response[] = $value['noKunjungan'];
				}	
			}
			$response = json_encode($arr_response); 
			
			break;
			
			case 'getRujukan' :
			
			$url = $ws_host . 'Rujukan/RS/' . $_POST['nomor_rujuk'];
			$response = @sendData($url,'','GET');		
			$_SESSION['SES_SIMRS_DETAIL_RUJUKAN'] = $_POST['nomor_rujuk'] . '||' . $response; 	
			break;
			
			case 'noSkdp' :
			$sql = 'SELECT MAX_NOMOR FROM m_app_max_nomor WHERE TAHUN = DATE_FORMAT(NOW(), "%Y") AND SURAT = "Nomor SKDP"';
			$rsl = mysql_query($sql);
			$nosurat = '';
			if (mysql_num_rows($rsl) > 0) {
				$dat = mysql_fetch_assoc($rsl);
				mysql_query('UPDATE m_app_max_nomor SET MAX_NOMOR = MAX_NOMOR + 1 WHERE TAHUN = DATE_FORMAT(NOW(), "%Y") AND SURAT = "Nomor SKDP"') or die(mysql_error());
				$no = $dat['MAX_NOMOR'] + 1;
				$nosurat = substr('000000', 1, 6 - strlen($no)) . $no;
			} else {
				mysql_query('INSERT INTO m_app_max_nomor VALUES(1,DATE_FORMAT(NOW(), "%Y"),"-","-" ,"Nomor SKDP")');
				$nosurat = '000001';
			}
			$response = $nosurat;
			
			break;
	}
	echo $response;
}	

if(isset($_GET['ref'])){
	switch($_GET['ref']){
		
		case 'faskes' :
			$q = strtolower($_GET['q']);
			if (strlen($q) < 1) return;
			$url = $ws_host . 'referensi/faskes/' . $q . '/' . $_GET['jns'];
			$response = @sendData($url,'','GET');
			
			$json_response = json_decode($response,true);
			$json_faskes = $json_response['response']['faskes'];
			if(is_array($json_faskes)){
				foreach($json_faskes as $value){
					echo $value['kode'] . '--' . $value['nama'] . " \n ";
				}	
			}	
		
		break;
		
		case 'propinsi' :
			$q = strtolower($_GET['q']);
			if (strlen($q) < 1) return;
			$url = $ws_host . 'referensi/propinsi';
			$response = @sendData($url,'','GET');
			
			$json_response = json_decode($response,true);
			$json_propinsi = $json_response['response']['list'];
			if(is_array($json_propinsi)){
				foreach($json_propinsi as $value){
					if (stripos($value['kode'] . $value['nama'], $q) !== false){
						echo $value['kode'] . '--' . $value['nama'] . " \n ";
					}
				}	
			}	
		
		break;
		
		case 'kota' :
			$q = strtolower($_GET['q']);
			$propinsi = $_GET['propinsi'];
			if (strlen($q) < 1 or $propinsi < 1) return;
			
			$arr_propinsi = explode('--',$propinsi);
			$url = $ws_host . 'referensi/kabupaten/propinsi/' . $arr_propinsi[0];
			$response = @sendData($url,'','GET');
			
			$json_response = json_decode($response,true);
			$json_kota = $json_response['response']['list'];
			if(is_array($json_kota)){
				foreach($json_kota as $value){
					if (stripos($value['kode'] . $value['nama'], $q) !== false){
						echo $value['kode'] . '--' . $value['nama'] . " \n ";
					}	
				}	
			}	
		
		break;
		
		case 'kecamatan' :
			$q = strtolower($_GET['q']);
			$kota = $_GET['kota'];
			if (strlen($q) < 1 or $kota < 1) return;
			
			$arr_kota = explode('--',$kota);
			$url = $ws_host . 'referensi/kecamatan/kabupaten/' . $arr_kota[0];
			$response = @sendData($url,'','GET');
			
			$json_response = json_decode($response,true);
			$json_kecamatan = $json_response['response']['list'];
			if(is_array($json_kecamatan)){
				foreach($json_kecamatan as $value){
					if (stripos($value['kode'] . $value['nama'], $q) !== false){
						echo $value['kode'] . '--' . $value['nama'] . " \n ";
					}	
				}	
			}	
		
		break;	
			
		case 'spesialis' :
			if(!isset($_SESSION['SES_SIMRS_DPJP_SPESIALIS']) or $_SESSION['SES_SIMRS_DPJP_SPESIALIS'] == ''){
				$url = $ws_host . 'referensi/spesialistik';
				$response = @sendData($url,'','GET');
				$_SESSION['SES_SIMRS_DPJP_SPESIALIS'] = $response;
				echo $response;
			}else{
				echo $_SESSION['SES_SIMRS_DPJP_SPESIALIS'];
			}	
		
		break;
		
		case 'dpjp' :
			$q = strtolower($_GET['q']);
			//$pelayanan = $_GET['pelayanan'];
			$pelayanan = '1';
			$spesialisasi = $_GET['spesialisasi'];
			if (strlen($q) < 1 or $spesialisasi < 1) return;
			
			$url = $ws_host . 'referensi/dokter/pelayanan/' . $pelayanan . '/tglPelayanan/' . date('Y-m-d') . '/Spesialis/' . $spesialisasi;
			$response = @sendData($url,'','GET');
			
			$json_response = json_decode($response,true);
			$json_dpjp = $json_response['response']['list'];
			if(is_array($json_dpjp)){
				foreach($json_dpjp as $value){
					if (stripos($value['kode'] . $value['nama'], $q) !== false){
						echo $value['kode'] . '--' . $value['nama'] . " \n ";
					}	
				}	
			}	
		
		break;
	}	
}	
?>