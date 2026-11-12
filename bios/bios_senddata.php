<?php
function sendToBiosData($endpoint,$method='GET',$token,$content=''){	
	
	$url = 'https://api.bios.liveprod.cloud/' . $endpoint;	
	
	$header = array (
		'Content-Type:application/json',
		'Accept:application/json',
		'Authorization:Bearer ' . $token
		);

	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
	//curl_setopt($ch,CURLOPT_HEADER, true);
	curl_setopt($ch,CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch,CURLOPT_AUTOREFERER, true);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,30);
	curl_setopt($ch,CURLOPT_TIMEOUT, 60);
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
	
	$output = curl_exec($ch);
	
	return $output;	
}

function sendToBiosLogin(){
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,'https://api.bios.liveprod.cloud/auth');
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
	//curl_setopt($ch,CURLOPT_HEADER, true);
	curl_setopt($ch,CURLOPT_AUTOREFERER, true);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,30);
	curl_setopt($ch,CURLOPT_TIMEOUT, 60);
	curl_setopt($ch,CURLOPT_MAXREDIRS, 10);
	curl_setopt($ch,CURLOPT_POST, true);
	curl_setopt($ch,CURLOPT_POSTFIELDS,'{ "username" : "novalbakri23@gmail.com",
		"password" : "kustasitanala_421%" }');	
	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch,CURLOPT_VERBOSE, true);
	
	$output = curl_exec($ch);
	//echo curl_errno($ch);
	return $output;	
}

?>