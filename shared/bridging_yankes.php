<?php
if(isset($_GET['sirskemkes'])){
	ini_set('display_errors', 1);
	include('C:/xampp/htdocs/nsimrs/config/config.php');
	include('C:/xampp/htdocs/nsimrs/shared/connect_db.php');

	$ws_url = 'http://sirs.kemkes.go.id/fo/index.php/LapV2/';

	function sendData($url,$content){
		date_default_timezone_set('UTC');
		$tm_stamp 	= strval(time()-strtotime('1970-01-01 00:00:00'));
		
		$res = '';
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_POST, true);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$content);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch,CURLOPT_HTTPHEADER, array(
			"X-rs-id: 3671032",
			"X-pass: S!rs2020!!",
			"X-Timestamp: $tm_stamp",
			"Content-Type: x-www-form-urlencoded"
		));
		$res = curl_exec($ch);
		return $res;	
	}
	
	function sendDataPut($url,$content){
		date_default_timezone_set('UTC');
		$tm_stamp 	= strval(time()-strtotime('1970-01-01 00:00:00'));
		
		$res = '';
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_CUSTOMREQUEST,"PUT");
		curl_setopt($ch,CURLOPT_POSTFIELDS,$content);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch,CURLOPT_HTTPHEADER, array(
			"X-rs-id: 3671032",
			"X-pass: S!rs2020!!",
			"X-Timestamp: $tm_stamp",
			"Content-Type: x-www-form-urlencoded"
		));
		$res = curl_exec($ch);
		return $res;	
	}

	function deleteData($url){
		date_default_timezone_set('UTC');
		$tm_stamp 	= strval(time()-strtotime('1970-01-01 00:00:00'));
		
		$res = '';
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_CUSTOMREQUEST,"DELETE");
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch,CURLOPT_HTTPHEADER, array(
			"X-rs-id: 3671032",
			"X-pass: S!rs2020!!",
			"X-Timestamp: $tm_stamp",
			"Content-Type: x-www-form-urlencoded",
			"User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.167 Safari/537.36"
		));
		$res = curl_exec($ch);
		return $res;	
	}
	
	 switch ($_GET['sirskemkes']) {
		  case 'pasienmasuk' :
		  $content = '{"tanggal": "' . $_POST['tanggal'] . '","igd_suspect_l": "' . $_POST['igd_suspect_l'] . '","igd_suspect_p":"' . $_POST['igd_suspect_p'] . '","igd_confirm_l": "' . $_POST['igd_confirm_l'] . '","igd_confirm_p": "' . $_POST['igd_confirm_p'] . '","rj_suspect_l": "' . $_POST['rj_suspect_l'] . '","rj_suspect_p": "' . $_POST['rj_suspect_p'] . '","rj_confirm_l": "' . $_POST['rj_confirm_l'] . '","rj_confirm_p": "' . $_POST['rj_confirm_p'] . '","ri_suspect_l": "' . $_POST['ri_suspect_l'] . '","ri_suspect_p": "' . $_POST['ri_suspect_p'] . '","ri_confirm_l": "' . $_POST['ri_confirm_l'] . '","ri_confirm_p": "' . $_POST['ri_confirm_p'] . '"}';
		  
		  $response = sendData($ws_url . 'PasienMasuk',$content);
			if(!empty($response)){
			
					echo $response;	
			}	
		  break;
		  
		  case 'Fasyankes' :
		  $content = '{"id_tt": "' . $_POST['id_tt'] . '","jumlah_ruang": "' . $_POST['jumlah_ruang'] . '","jumlah":"' . $_POST['jumlah'] . '","terpakai": "' . $_POST['terpakai'] . '"}';
		  
		  $response = sendDataPut("http://sirs.kemkes.go.id/fo/index.php/Fasyankes",$content);
			if(!empty($response)){
			
					echo $response;	
			}	
		  break;
		  
		  case 'pasiendirawatkomorbid' :
		  $content = '{"tanggal":"' . $_POST['tanggal'] . '",
		  "icu_dengan_ventilator_suspect_l":"0",
		  "icu_dengan_ventilator_suspect_p":"0",
		  "icu_dengan_ventilator_confirm_l":"0",
		  "icu_dengan_ventilator_confirm_p":"0",
		  "icu_tanpa_ventilator_suspect_l":"0",
		  "icu_tanpa_ventilator_suspect_p":"0",
		  "icu_tanpa_ventilator_confirm_l":"0",
		  "icu_tanpa_ventilator_confirm_p":"0",
		  "icu_tekanan_negatif_dengan_ventilator_suspect_l":"' . $_POST['icu_tekanan_negatif_dengan_ventilator_suspect_l'] . '",
		  "icu_tekanan_negatif_dengan_ventilator_suspect_p":"' . $_POST['icu_tekanan_negatif_dengan_ventilator_suspect_p'] . '",
		  "icu_tekanan_negatif_dengan_ventilator_confirm_l":"' . $_POST['icu_tekanan_negatif_dengan_ventilator_confirm_l'] . '",
		  "icu_tekanan_negatif_dengan_ventilator_confirm_p":"' . $_POST['icu_tekanan_negatif_dengan_ventilator_confirm_p'] . '",
		  "icu_tekanan_negatif_tanpa_ventilator_suspect_l":"0",
		  "icu_tekanan_negatif_tanpa_ventilator_suspect_p":"0",
		  "icu_tekanan_negatif_tanpa_ventilator_confirm_l":"0",
		  "icu_tekanan_negatif_tanpa_ventilator_confirm_p":"0",
		  "isolasi_tekanan_negatif_suspect_l":"' . $_POST['isolasi_tekanan_negatif_suspect_l'] . '",
		  "isolasi_tekanan_negatif_suspect_p":"' . $_POST['isolasi_tekanan_negatif_suspect_p'] . '",
		  "isolasi_tekanan_negatif_confirm_l":"' . $_POST['isolasi_tekanan_negatif_confirm_l'] . '",
		  "isolasi_tekanan_negatif_confirm_p":"' . $_POST['isolasi_tekanan_negatif_confirm_p'] . '",
		  "isolasi_tanpa_tekanan_negatif_suspect_l":"' . $_POST['isolasi_tanpa_tekanan_negatif_suspect_l'] . '",
		  "isolasi_tanpa_tekanan_negatif_suspect_p":"' . $_POST['isolasi_tanpa_tekanan_negatif_suspect_p'] . '",
		  "isolasi_tanpa_tekanan_negatif_confirm_l":"' . $_POST['isolasi_tanpa_tekanan_negatif_confirm_l'] . '",
		  "isolasi_tanpa_tekanan_negatif_confirm_p":"' . $_POST['isolasi_tanpa_tekanan_negatif_confirm_p'] . '",
		  "nicu_khusus_covid_l":"0",
		  "nicu_khusus_covid_p":"0",
		  "nicu_khusus_covid_l":"0",
		  "nicu_khusus_covid_p":"0",
		  "picu_khusus_covid_l":"0",
		  "picu_khusus_covid_p":"0",
		  "picu_khusus_covid_l":"0",
		  "picu_khusus_covid_p":"0"
		  }';
		  
		  $response = sendData($ws_url . 'PasienDirawatKomorbid',$content);
			if(!empty($response)){
			
					echo $response;	
			}	
		  break;
		  
		  case 'pasiendirawattanpakomorbid' :
		  $content = '{"tanggal":"' . $_POST['tanggal'] . '",
		  "icu_dengan_ventilator_suspect_l":"0",
		  "icu_dengan_ventilator_suspect_p":"0",
		  "icu_dengan_ventilator_confirm_l":"0",
		  "icu_dengan_ventilator_confirm_p":"0",
		  "icu_tanpa_ventilator_suspect_l":"0",
		  "icu_tanpa_ventilator_suspect_p":"0",
		  "icu_tanpa_ventilator_confirm_l":"0",
		  "icu_tanpa_ventilator_confirm_p":"0",
		  "icu_tekanan_negatif_dengan_ventilator_suspect_l":"' . $_POST['icu_tekanan_negatif_dengan_ventilator_suspect_l'] . '",
		  "icu_tekanan_negatif_dengan_ventilator_suspect_p":"' . $_POST['icu_tekanan_negatif_dengan_ventilator_suspect_p'] . '",
		  "icu_tekanan_negatif_dengan_ventilator_confirm_l":"' . $_POST['icu_tekanan_negatif_dengan_ventilator_confirm_l'] . '",
		  "icu_tekanan_negatif_dengan_ventilator_confirm_p":"' . $_POST['icu_tekanan_negatif_dengan_ventilator_confirm_p'] . '",
		  "icu_tekanan_negatif_tanpa_ventilator_suspect_l":"0",
		  "icu_tekanan_negatif_tanpa_ventilator_suspect_p":"0",
		  "icu_tekanan_negatif_tanpa_ventilator_confirm_l":"0",
		  "icu_tekanan_negatif_tanpa_ventilator_confirm_p":"0",
		  "isolasi_tekanan_negatif_suspect_l":"' . $_POST['isolasi_tekanan_negatif_suspect_l'] . '",
		  "isolasi_tekanan_negatif_suspect_p":"' . $_POST['isolasi_tekanan_negatif_suspect_p'] . '",
		  "isolasi_tekanan_negatif_confirm_l":"' . $_POST['isolasi_tekanan_negatif_confirm_l'] . '",
		  "isolasi_tekanan_negatif_confirm_p":"' . $_POST['isolasi_tekanan_negatif_confirm_p'] . '",
		  "isolasi_tanpa_tekanan_negatif_suspect_l":"' . $_POST['isolasi_tanpa_tekanan_negatif_suspect_l'] . '",
		  "isolasi_tanpa_tekanan_negatif_suspect_p":"' . $_POST['isolasi_tanpa_tekanan_negatif_suspect_p'] . '",
		  "isolasi_tanpa_tekanan_negatif_confirm_l":"' . $_POST['isolasi_tanpa_tekanan_negatif_confirm_l'] . '",
		  "isolasi_tanpa_tekanan_negatif_confirm_p":"' . $_POST['isolasi_tanpa_tekanan_negatif_confirm_p'] . '",
		  "nicu_khusus_covid_l":"0",
		  "nicu_khusus_covid_p":"0",
		  "nicu_khusus_covid_l":"0",
		  "nicu_khusus_covid_p":"0",
		  "picu_khusus_covid_l":"0",
		  "picu_khusus_covid_p":"0",
		  "picu_khusus_covid_l":"0",
		  "picu_khusus_covid_p":"0"
		  }';
		  
		  $response = sendData($ws_url . 'PasienDirawatTanpaKomorbid',$content);
			if(!empty($response)){
			
					echo $response;	
			}	
		  break;
	 }	 

}
?>