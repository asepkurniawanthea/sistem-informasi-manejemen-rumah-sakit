<?php
include('C:/xampp/htdocs/nsimrs/config/config.php');
include('C:/xampp/htdocs/nsimrs/shared/connect_db.php');

$ws_host = 'https://new-api.bpjs-kesehatan.go.id';
//$ws_host = 'https://dvlp.bpjs-kesehatan.go.id:8888';

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
		'X-cons-id:' . $rs_account['id'],
		'X-timestamp:' . $tm_stamp,
		'X-signature:' . $ec_signature,
		'Content-Type:application/json'
	));
	
	$output = curl_exec($ch);
	
	return $output;	
}

//get ruang
$response = @sendData($ws_host . '/aplicaresws/rest/bed/read/' . $rs_account['code'] . '/1/50','','GET'); 
$json_response = json_decode($response,true);
$json_ruang = $json_response['response']['list']; 

//delete
/*
$response = @sendData($ws_host . '/aplicaresws/rest/bed/delete/' . $rs_account['code'],'{ "kodekelas":"VIP", 
    "koderuang":"VIP"
  }','POST');
*/  
  
$arr_kelas = array();
$arr_nama_ruang = array();
$arr_kode_ruang = array();
if(is_array($json_ruang)){
	foreach($json_ruang as $value){
		$kode_ruang = strtoupper($value['koderuang'] . $value['kodekelas']);
		$arr_kelas[$kode_ruang] = $value['kodekelas'];
		$arr_nama_ruang[$kode_ruang] = $value['namaruang'];
		$arr_kode_ruang[$kode_ruang] = $value['koderuang'];
	}	
} 

$qry_ruang = 'SELECT m_ruang.KODE_RUANG_BPJS,
			SUM(m_ruang.JML_TMP_TIDUR) AS KAPASITAS,
			(
				SELECT COUNT(t_irna.IRNA_ID) 
				FROM t_irna 
				WHERE t_irna.RUANG_ID = m_ruang.RUANG_ID 
				AND t_irna.ST_PULANG IS NULL 
				AND t_irna.ST_BATAL IS NULL 
				AND t_irna.NO_PENDAFTARAN IS NOT NULL
			) AS TERISI
			FROM m_ruang
			WHERE m_ruang.ST_AKTIF = "1"
			GROUP BY m_ruang.KODE_RUANG_BPJS
			';
$get_ruang = mysql_query($qry_ruang) or die(mysql_error());
while($dat_ruang = mysql_fetch_array($get_ruang)){
	$kode_ruang_simrs = strtoupper($dat_ruang['KODE_RUANG_BPJS']);
	if(isset($arr_nama_ruang[$kode_ruang_simrs])){
		$tersedia = $dat_ruang['KAPASITAS'] - $dat_ruang['TERISI'];
		if($tersedia < 0) $tersedia = 0;
			//new ruang
			/*
			$response = @sendData($ws_host . '/aplicaresws/rest/bed/create/' . $rs_account['code'],'{ 
				"kodekelas":"' . $arr_kelas[$kode_ruang_simrs] . '", 
				"koderuang":"' . $arr_kode_ruang[$kode_ruang_simrs] . '", 
				"namaruang":"' . $arr_nama_ruang[$kode_ruang_simrs] . '", 
				"kapasitas":"' . $dat_ruang['KAPASITAS'] . '", 
				"tersedia":"' . $tersedia . '",
				"tersediapria":"0", 
				"tersediawanita":"0", 
				"tersediapriawanita":"0"
		   }','POST');
		   */
		   
		   //update
		   
				$response = @sendData($ws_host . '/aplicaresws/rest/bed/update/' . $rs_account['code'],'{ 
				"kodekelas":"' . $arr_kelas[$kode_ruang_simrs] . '", 
				"koderuang":"' . $arr_kode_ruang[$kode_ruang_simrs] . '", 
				"namaruang":"' . $arr_nama_ruang[$kode_ruang_simrs] . '", 
				"kapasitas":"' . $dat_ruang['KAPASITAS'] . '", 
				"tersedia":"' . $tersedia . '",
				"tersediapria":"0", 
				"tersediawanita":"0", 
				"tersediapriawanita":"0"
		   }','POST');
		   
	}	   
}			
?>