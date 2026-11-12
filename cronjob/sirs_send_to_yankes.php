<?php
ini_set('display_errors', 1);
date_default_timezone_set('Asia/Jakarta');

$user_yankes = '3671032';
$password_yankes = md5('12345');

$user_local = 'admin';
$password_local = '12sitanala345';

function getData($url,$user,$password){
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch,CURLOPT_HTTPHEADER, array(
		'x-user: ' . $user,
		'x-password: ' . $password
	));
	$server_output = curl_exec($ch);
	
	return $server_output;
}

function sendData($url,$user,$password,$content){
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
	curl_setopt($ch,CURLOPT_HTTPHEADER, array(
		'X-rs-id: ' . $user,
		'X-pass: ' . $password,
		'Content-Type: application/xml'
	));
	$server_output = curl_exec($ch);
	
	if(!empty($server_output)){
		$jam_modified = date('H:i:s');
		$tgl_modified = date('Y-m-d');
		$file = fopen('C:/xampp/htdocs/nsimrs/cronjob/log/' . $tgl_modified . '.txt', 'a') or die('Cant open file.');
		fwrite($file, $jam_modified . ' ' . $url . ' - ' . $server_output . " \n");
		fclose($file);
	}	
}

$tanggal = date('j-n-Y');
$bulan = date('n-Y');

$irj = getData('http://localhost/sirsservice/irj?tanggal=' . $tanggal,$user_local,$password_local);
$igd = getData('http://localhost/sirsservice/igd?tanggal=' . $tanggal,$user_local,$password_local);
$iri = getData('http://localhost/sirsservice/iri?tanggal=' . $tanggal,$user_local,$password_local);

$bed = getData('http://localhost/sirsservice/bed_monitor',$user_local,$password_local);

$diagnosa_irj = getData('http://localhost/sirsservice/diagnosa_irj?bulan=' . $bulan,$user_local,$password_local);
$diagnosa_iri = getData('http://localhost/sirsservice/diagnosa_iri?bulan=' . $bulan,$user_local,$password_local);

sendData('http://sirs.yankes.kemkes.go.id/sirsservice/irj/' . $tanggal,$user_yankes,$password_yankes,$irj);
sendData('http://sirs.yankes.kemkes.go.id/sirsservice/igd/' . $tanggal,$user_yankes,$password_yankes,$igd);
sendData('http://sirs.yankes.kemkes.go.id/sirsservice/iri/' . $tanggal,$user_yankes,$password_yankes,$iri);

sendData('http://sirs.yankes.kemkes.go.id/sirsservice/ranap',$user_yankes,$password_yankes,$bed);

sendData('http://sirs.yankes.kemkes.go.id/sirsservice/diagnosa_irj/' . $bulan,$user_yankes,$password_yankes,$diagnosa_irj);
sendData('http://sirs.yankes.kemkes.go.id/sirsservice/diagnosa_iri/' . $bulan,$user_yankes,$password_yankes,$diagnosa_iri);

?>