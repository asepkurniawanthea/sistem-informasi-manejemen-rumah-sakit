<?php
ini_set('display_errors', 1);
include('C:/xampp/htdocs/nsimrs/config/config.php');
include('C:/xampp/htdocs/nsimrs/shared/connect_db.php');

date_default_timezone_set('Asia/Jakarta');
$tanggal = date('Y-m-d');
$file_log = 'C:/xampp/htdocs/nsimrs/cronjob/log/sirs_v2_bed_' . $tanggal . '.txt';

$arr_kamar=array("1"=>"VVIP/ Super VIP",
"2"=>"VIP",
"3"=>"Kelas I",
"4"=>"Kelas II",
"5"=>"Kelas III",
"6"=>"ICU",
"7"=>"HCU",
"8"=>"ICCU/ICVCU",
"9"=>"RICU",
"10"=>"NICU",
"11"=>"PICU",
"12"=>"Isolasi",
"13"=>"Non Kelas",
"14"=>"Perinatologi",
"24"=>"ICU Tekanan Negatif dengan Ventilator",
"25"=>"ICU Tekanan Negatif tanpa Ventilator",
"26"=>"ICU Tanpa Tekanan Negatif Dengan Ventilator",
"27"=>"ICU Tanpa Tekanan Negatif Tanpa Ventilator",
"28"=>"Isolasi Tekanan Negatif",
"29"=>"Isolasi Tanpa Tekanan Negatif",
"30"=>"NICU Khusus Covid",
"31"=>"PICU Khusus Covid");

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

$qry_kamar = 'SELECT m_ruang.KODE_RUANG_YANKES,count(m_ruang.RUANG_ID) AS JML_RUANG,
			SUM(m_ruang.JML_TMP_TIDUR) AS JML_TMP_TIDUR,
			SUM(t_ruang.JML_TMP_ISI) AS JML_TMP_ISI
			FROM m_ruang
			LEFT JOIN (
				SELECT COUNT(t_irna.IRNA_ID) AS JML_TMP_ISI,
				t_irna.RUANG_ID
				FROM t_irna
				WHERE t_irna.ST_PULANG IS NULL 
				AND t_irna.ST_BATAL IS NULL AND t_irna.NO_PENDAFTARAN IS NOT NULL
				GROUP BY t_irna.RUANG_ID
			) t_ruang
			ON (m_ruang.RUANG_ID = t_ruang.RUANG_ID)
			WHERE m_ruang.ST_AKTIF = "1"
			AND m_ruang.BANGSAL <> "IGD"
			GROUP BY m_ruang.KODE_RUANG_YANKES
			ORDER BY m_ruang.KODE_RUANG_YANKES';
$get_kamar = mysql_query($qry_kamar) or die(mysql_error());	

$log_content = '';
while($dat_kamar = mysql_fetch_array($get_kamar)){  

	$rr_covid = '0'; 
	if(in_array($dat_kamar['KODE_RUANG_YANKES'], array('24','25','26','27','28','29','30','31'))) $rr_covid = '1';

	$content = '{"id_tt": "' . $dat_kamar['KODE_RUANG_YANKES'] . '","ruang":"' . $arr_kamar[$dat_kamar['KODE_RUANG_YANKES']] . '",jumlah_ruang": "' . $dat_kamar['JML_RUANG'] . '","jumlah":"' . $dat_kamar['JML_TMP_TIDUR'] . '","terpakai": "' . $dat_kamar['JML_TMP_ISI'] . '","prepare":"0","prepare_plan":"0","covid":"' . $rr_covid . '"}';
	$response = sendDataPut("http://sirs.kemkes.go.id/fo/index.php/Fasyankes",$content);
		if(!empty($response)){
			$log_content .= $response . '\n';	
		}
	sleep(5);	
}

file_put_contents($file_log,$log_content,FILE_APPEND | LOCK_EX);
?>