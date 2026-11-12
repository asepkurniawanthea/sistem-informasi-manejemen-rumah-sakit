<?php
function getBiosDataRef($ref,$method='GET',$content=''){
		
	$url = '';	
	if($ref == 'kelas') $url = 'http://bios.djpbn.kemenkeu.go.id/web_services/ref_kelas';	
	if($ref == 'akun_penerimaan') $url = 'http://lk.bios.djpbn.kemenkeu.go.id/api/services/getReferensiAkunPenerimaan';	
	if($ref == 'akun_pengeluaran') $url = 'http://lk.bios.djpbn.kemenkeu.go.id/api/services/getReferensiAkunPengeluaran';	
	if($ref == 'kode_rekening') $url = 'http://lk.bios.djpbn.kemenkeu.go.id/api/services/getReferensiJenisRekening';	
	if($ref == 'log') $url = 'http://bios.djpbn.kemenkeu.go.id/web_services/log';	
	
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
?>