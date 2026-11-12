<?php
ini_set('display_errors', 1);

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
		"X-pass: 827ccb0eea8a706c4c34a16891f84e7b",
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
		"X-pass: 827ccb0eea8a706c4c34a16891f84e7b",
		"X-Timestamp: $tm_stamp",
		"Content-Type: x-www-form-urlencoded",
		"User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.167 Safari/537.36"
	));
	$res = curl_exec($ch);
	return $res;	
}

function cariString($search,$filename){
	$ret = '';
	$file = file($filename);
	foreach($file as $line){
    if(strpos($line, $search) !== false)
		$ret = $line;
	}
	return $ret;
}

include('C:/xampp/htdocs/nsimrs/config/config.php');
include('C:/xampp/htdocs/nsimrs/shared/connect_db.php');

date_default_timezone_set('Asia/Jakarta');
$tanggal = date('Y-m-d');
$bulan = date('Y-m');
$bulan2 = date('n');
$tahun = date('Y');
$jam_modified = date('H:i:s');

//kunjungan
$sql = 'SELECT COUNT(CASE WHEN t_irja.UNIT_ID = 9 THEN t_irja.IRJA_ID END) AS KUNJ_IGD,
		COUNT(CASE WHEN t_irja.UNIT_ID <> 9 THEN t_irja.IRJA_ID END) AS KUNJ_UMUM
		FROM t_irja 
		WHERE DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y-%m-%d") = "' . $tanggal . '"
		AND (t_irja.ST_BATAL IS NULL OR t_irja.ST_BATAL = "")';
$get = mysql_query($sql) or die(mysql_error());
$dat = mysql_fetch_assoc($get);
$kunj_igd = $dat['KUNJ_IGD'];		
$kunj_umum = $dat['KUNJ_UMUM'];
		
$sql = 'SELECT COUNT(t_irna_opname.IRNA_ID) AS PASIEN_AWAL
		FROM t_irna_opname
		WHERE DATE_FORMAT(t_irna_opname.TANGGAL_OPNAME,"%Y-%m-%d") = DATE_FORMAT(DATE_ADD(STR_TO_DATE("' . $tanggal . '","%Y-%m-%d"),INTERVAL -1 DAY),"%Y-%m-%d")';
$get = mysql_query($sql) or die(mysql_error());
$dat = mysql_fetch_assoc($get);		
$pasien_awal = $dat['PASIEN_AWAL'];

$sql = 'SELECT COUNT(t_irna_log.IRNA_ID) AS PASIEN_MASUK
		FROM t_irna_log
		WHERE DATE_FORMAT(t_irna_log.TANGGAL_MASUK,"%Y-%m-%d") = DATE_FORMAT(DATE_ADD(STR_TO_DATE("' . $tanggal . '","%Y-%m-%d"),INTERVAL -1 DAY),"%Y-%m-%d")
		AND t_irna_log.JNS_UPDATE = "R"
		AND t_irna_log.RUANG_ID_ASAL IS NULL';		
$get = mysql_query($sql) or die(mysql_error());
$dat = mysql_fetch_assoc($get);		
$pasien_masuk = $dat['PASIEN_MASUK'];

$pasien_ranap = $pasien_awal + $pasien_masuk;

$file = 'C:/xampp/htdocs/nsimrs/cronjob/log/dashboard_kunjungan_' . $tanggal . '.txt';
$url = '';
$content = '';
$update = false;
if(!file_exists($file)){
	$url = 'http://103.74.143.46/sirsservice/kunjungan';	
	$content = '{"tanggal":"' . $tanggal . '","kunjungan_rj":"' . $kunj_umum . '","kunjungan_igd":"' . $kunj_igd . '","pasien_ri":"' . $pasien_ranap . '"}';
}else{
	$kode_kirim = cariString('idkirim',$file);
	if($kode_kirim == ''){
		$kode_ex_kirim = cariString('idexkirim',$file);
		if($kode_ex_kirim != ''){
			$arr_kode_ex_kirim = explode(':',$kode_ex_kirim);
			$url = 'http://103.74.143.46/sirsservice/kunjungan?kode=' . $arr_kode_ex_kirim[1];
			$res = deleteData($url);
			$json_res = json_decode($res,true);	
			if(isset($json_res['kode']) and $json_res['kode'] == '200'){
				$file_contents = file_get_contents($file);
				$file_contents = str_replace('idexkirim','xxxxxxxxxxxx',$file_contents);
				file_put_contents($file,$file_contents);	
			}
		}
		$url = 'http://103.74.143.46/sirsservice/kunjungan';	
		$content = '{"tanggal":"' . $tanggal . '","kunjungan_rj":"' . $kunj_umum . '","kunjungan_igd":"' . $kunj_igd . '","pasien_ri":"' . $pasien_ranap . '"}';
	}else{
		$arr_kode_kirim = explode(':',$kode_kirim);
		$url = 'http://103.74.143.46/sirsservice/updatekunjungan';	
		$content = '{"kode_kirim":"' . $arr_kode_kirim[1] . '","tanggal":"' . $tanggal . '","kunjungan_rj":"' . $kunj_umum . '","kunjungan_igd":"' . $kunj_igd . '","pasien_ri":"' . $pasien_ranap . '"}';
		$update = true;
	}
}		

$response = sendData($url,$content);
if(!empty($response)){
	$error = false;
	$json_response = json_decode($response,true);
	$fileopen = fopen($file, 'a') or die('Cant open file.');
	fwrite($fileopen, $jam_modified . ' ' . $content . ' - ' . $response . " \n");
	if($update == false){
		if(isset($json_response['kode']) and isset($json_response['kode_kirim']) and $json_response['kode'] == '200'){
			fwrite($fileopen, 'idkirim:' . $json_response['kode_kirim'] . " \n");
		}
	}else{
		if(!isset($json_response['kode']) and $json_response['kode'] != '200') $error = true;	
	}
	fclose($fileopen);
		
	if($error){
		$file_contents = file_get_contents($file);
		$file_contents = str_replace('idkirim','idexkirim',$file_contents);
		file_put_contents($file,$file_contents);
	}
}

//rujukan
$sql = 'SELECT COUNT(CASE WHEN t_irja.ASAL_PASIEN_ID = 2 OR t_irja.ASAL_PASIEN_ID = 3 THEN t_irja.IRJA_ID END) AS PASIEN_RUJUKAN,
		COUNT(CASE WHEN t_irja.RUJUK_BALIK = "1" THEN t_irja.IRJA_ID END) AS RUJUK_BALIK
		FROM t_irja 
		WHERE DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y-%m-%d") = "' . $tanggal . '"
		AND (t_irja.ST_BATAL IS NULL OR t_irja.ST_BATAL = "")';
$get = mysql_query($sql) or die(mysql_error());
$dat = mysql_fetch_assoc($get);
$rujukan = $dat['PASIEN_RUJUKAN'];		
$rujuk_balik = $dat['RUJUK_BALIK'];

$file = 'C:/xampp/htdocs/nsimrs/cronjob/log/dashboard_rujukan_' . $tanggal . '.txt';
$url = '';
$content = '';
$update = false;
if(!file_exists($file)){
	$url = 'http://103.74.143.46/sirsservice/rujukan';	
	$content = '{"tanggal":"' . $tanggal . '","jumlah_rujukan":"' . $rujukan . '","jumlah_rujuk_balik":"' . $rujuk_balik . '"}';
}else{
	$kode_kirim = cariString('idkirim',$file);
	if($kode_kirim == ''){
		$kode_ex_kirim = cariString('idexkirim',$file);
		if($kode_ex_kirim != ''){
			$arr_kode_ex_kirim = explode(':',$kode_ex_kirim);
			$url = 'http://103.74.143.46/sirsservice/rujukan?kode=' . $arr_kode_ex_kirim[1];
			$res = deleteData($url);
			$json_res = json_decode($res,true);	
			if(isset($json_res['kode']) and $json_res['kode'] == '200'){
				$file_contents = file_get_contents($file);
				$file_contents = str_replace('idexkirim','xxxxxxxxxxxx',$file_contents);
				file_put_contents($file,$file_contents);	
			}
		}
		$url = 'http://103.74.143.46/sirsservice/rujukan';	
		$content = '{"tanggal":"' . $tanggal . '","jumlah_rujukan":"' . $rujukan . '","jumlah_rujuk_balik":"' . $rujuk_balik . '"}';
	}else{
		$arr_kode_kirim = explode(':',$kode_kirim);
		$url = 'http://103.74.143.46/sirsservice/updaterujukan';	
		$content = '{"kode_kirim":"' . $arr_kode_kirim[1] . '","tanggal":"' . $tanggal . '","jumlah_rujukan":"' . $rujukan . '","jumlah_rujuk_balik":"' . $rujuk_balik . '"}';
		$update = true;
	}
}		

$response = sendData($url,$content);
if(!empty($response)){
		$error = false;
		$json_response = json_decode($response,true);
		$fileopen = fopen($file, 'a') or die('Cant open file.');
		fwrite($fileopen, $jam_modified . ' ' . $content . ' - ' . $response . " \n");
		if($update == false){
			if(isset($json_response['kode']) and isset($json_response['response']) and $json_response['kode'] == '200'){
				fwrite($fileopen, 'idkirim:' . $json_response['response'] . " \n");
			}
		}else{
			if(!isset($json_response['kode']) and $json_response['kode'] != '200') $error = true;	
		}
		fclose($fileopen);
		
		if($error){
			$file_contents = file_get_contents($file);
			$file_contents = str_replace('idkirim','idexkirim',$file_contents);
			file_put_contents($file,$file_contents);
		}
}

//top 10 rujukan
$sql = 'SELECT KODE_ICD,JML_PASIEN
		FROM (SELECT COUNT(t_irja.IRJA_ID) AS JML_PASIEN,
		m_icd_x.ICD_CODE AS KODE_ICD
		FROM t_irja
		INNER JOIN t_irja_diagnosa ON (t_irja.IRJA_ID = t_irja_diagnosa.IRJA_ID)
		INNER JOIN m_icd_x ON (t_irja_diagnosa.ICD_CODE = m_icd_x.ICD_CODE)	
		WHERE DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y-%m") = "' . $bulan . '"
		AND (t_irja.ST_BATAL IS NULL OR t_irja.ST_BATAL = "")
		AND (t_irja.ASAL_PASIEN_ID = 2 OR t_irja.ASAL_PASIEN_ID = 3)
		AND t_irja_diagnosa.DIAGNOSA_ORDER = 0
		GROUP BY m_icd_x.ICD_CODE
		) t_penyakit
		ORDER BY JML_PASIEN DESC LIMIT 10';
$get = mysql_query($sql) or die(mysql_error());
$penyakit = array();
$i = 0;
while($dat = mysql_fetch_array($get)){
	$penyakit[$i] = array('kode_icd_10'=>$dat['KODE_ICD'],'jumlah'=>$dat['JML_PASIEN']);
$i++;
}	
$json_penyakit = json_encode($penyakit);

$file = 'C:/xampp/htdocs/nsimrs/cronjob/log/dashboard_top10rujukan_' . $bulan . '.txt';
$url = '';
$content = '';
$update = false;
if(!file_exists($file)){
	$url = 'http://103.74.143.46/sirsservice/toptenrujukan';	
	$content = '{"bulan":"' . $bulan2 . '","tahun":"' . $tahun . '","dirujuk":' . $json_penyakit . '}';
}else{
	$kode_kirim = cariString('idkirim',$file);
	if($kode_kirim == ''){
		$kode_ex_kirim = cariString('idexkirim',$file);
		if($kode_ex_kirim != ''){
			$arr_kode_ex_kirim = explode(':',$kode_ex_kirim);
			$url = 'http://103.74.143.46/sirsservice/toptenrujukan?kode=' . $arr_kode_ex_kirim[1];
			$res = deleteData($url);
			$json_res = json_decode($res,true);	
			if(isset($json_res['kode']) and $json_res['kode'] == '200'){
				$file_contents = file_get_contents($file);
				$file_contents = str_replace('idexkirim','xxxxxxxxxxxx',$file_contents);
				file_put_contents($file,$file_contents);	
			}
		}
		$url = 'http://103.74.143.46/sirsservice/toptenrujukan';	
		$content = '{"bulan":"' . $bulan2 . '","tahun":"' . $tahun . '","dirujuk":' . $json_penyakit . '}';
	}else{
		$arr_kode_kirim = explode(':',$kode_kirim);
		$url = 'http://103.74.143.46/sirsservice/updatetoptenrujukan';	
		$content = '{"bulan":"' . $bulan2 . '","tahun":"' . $tahun . '","dirujuk":' . $json_penyakit . ',"kode_kirim":"' . $arr_kode_kirim[1] . '"}';
		$update = true;
	}
}		

$response = sendData($url,$content);
if(!empty($response)){
	$error = false;
	$json_response = json_decode($response,true);
	$fileopen = fopen($file, 'a') or die('Cant open file.');
	fwrite($fileopen, $jam_modified . ' ' . $content . ' - ' . $response . " \n");
	if($update == false){
		if(isset($json_response['kode']) and isset($json_response['kode_kirim']) and $json_response['kode'] == '200'){
			fwrite($fileopen, 'idkirim:' . $json_response['kode_kirim'] . " \n");
		}
	}else{
		if(!isset($json_response['kode']) and $json_response['kode'] != '200') $error = true;	
	}
	fclose($fileopen);
		
	if($error){
		$file_contents = file_get_contents($file);
		$file_contents = str_replace('idkirim','idexkirim',$file_contents);
		file_put_contents($file,$file_contents);
	}
}


//top 10 penyakit rawat jalan bulanan
$sql = 'SELECT KODE_ICD,JML_PASIEN
		FROM (SELECT COUNT(t_irja.IRJA_ID) AS JML_PASIEN,
		m_icd_x.ICD_CODE AS KODE_ICD
		FROM t_irja
		INNER JOIN t_irja_diagnosa ON (t_irja.IRJA_ID = t_irja_diagnosa.IRJA_ID)
		INNER JOIN m_icd_x ON (t_irja_diagnosa.ICD_CODE = m_icd_x.ICD_CODE)	
		WHERE DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y-%m") = "' . $bulan . '"
		AND (t_irja.ST_BATAL IS NULL OR t_irja.ST_BATAL = "")
		AND t_irja_diagnosa.DIAGNOSA_ORDER = 0
		GROUP BY m_icd_x.ICD_CODE
		) t_penyakit
		ORDER BY JML_PASIEN DESC LIMIT 10';
$get = mysql_query($sql) or die(mysql_error());
$penyakit = array();
$i = 0;
while($dat = mysql_fetch_array($get)){
	$penyakit[$i] = array('kode_icd_10'=>$dat['KODE_ICD'],'jumlah'=>$dat['JML_PASIEN']);
$i++;
}	
$json_penyakit = json_encode($penyakit);

$file = 'C:/xampp/htdocs/nsimrs/cronjob/log/dashboard_top10penyakit_rajal_' . $bulan . '.txt';
$url = '';
$content = '';
$update = false;
if(!file_exists($file)){
	$url = 'http://103.74.143.46/sirsservice/toptenrajal';	
	$content = '{"bulan":"' . $bulan2 . '","tahun":"' . $tahun . '","rawat_jalan":' . $json_penyakit . '}';
}else{
	$kode_kirim = cariString('idkirim',$file);
	if($kode_kirim == ''){
		$kode_ex_kirim = cariString('idexkirim',$file);
		if($kode_ex_kirim != ''){
			$arr_kode_ex_kirim = explode(':',$kode_ex_kirim);
			$url = 'http://103.74.143.46/sirsservice/toptenrajal?kode=' . $arr_kode_ex_kirim[1];
			$res = deleteData($url);
			$json_res = json_decode($res,true);	
			if(isset($json_res['kode']) and $json_res['kode'] == '200'){
				$file_contents = file_get_contents($file);
				$file_contents = str_replace('idexkirim','xxxxxxxxxxxx',$file_contents);
				file_put_contents($file,$file_contents);	
			}
		}
		$url = 'http://103.74.143.46/sirsservice/toptenrajal';	
		$content = '{"bulan":"' . $bulan2 . '","tahun":"' . $tahun . '","rawat_jalan":' . $json_penyakit . '}';
	}else{
		$arr_kode_kirim = explode(':',$kode_kirim);
		$url = 'http://103.74.143.46/sirsservice/updatetoptenrajal';	
		$content = '{"bulan":"' . $bulan2 . '","tahun":"' . $tahun . '","rawat_jalan":' . $json_penyakit . ',"kode_kirim":"' . $arr_kode_kirim[1] . '"}';
		$update = true;
	}
}		

$response = sendData($url,$content);
if(!empty($response)){
	$error = false;
	$json_response = json_decode($response,true);
	$fileopen = fopen($file, 'a') or die('Cant open file.');
	fwrite($fileopen, $jam_modified . ' ' . $content . ' - ' . $response . " \n");
	if($update == false){
		if(isset($json_response['kode']) and isset($json_response['kode_kirim']) and $json_response['kode'] == '200'){
			fwrite($fileopen, 'idkirim:' . $json_response['kode_kirim'] . " \n");
		}
	}else{
		if(!isset($json_response['kode']) and $json_response['kode'] != '200') $error = true;	
	}
	fclose($fileopen);
		
	if($error){
		$file_contents = file_get_contents($file);
		$file_contents = str_replace('idkirim','idexkirim',$file_contents);
		file_put_contents($file,$file_contents);
	}
}

//top 10 penyakit rawat jalan tahunan
$sql = 'SELECT KODE_ICD,JML_PASIEN
		FROM (SELECT COUNT(t_irja.IRJA_ID) AS JML_PASIEN,
		m_icd_x.ICD_CODE AS KODE_ICD
		FROM t_irja
		INNER JOIN t_irja_diagnosa ON (t_irja.IRJA_ID = t_irja_diagnosa.IRJA_ID)
		INNER JOIN m_icd_x ON (t_irja_diagnosa.ICD_CODE = m_icd_x.ICD_CODE)	
		WHERE DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y") = "' . $tahun . '"
		AND (t_irja.ST_BATAL IS NULL OR t_irja.ST_BATAL = "")
		AND t_irja_diagnosa.DIAGNOSA_ORDER = 0
		GROUP BY m_icd_x.ICD_CODE
		) t_penyakit
		ORDER BY JML_PASIEN DESC LIMIT 10';
$get = mysql_query($sql) or die(mysql_error());
$penyakit = array();
$i = 0;
while($dat = mysql_fetch_array($get)){
	$penyakit[$i] = array('kode_icd_10'=>$dat['KODE_ICD'],'jumlah'=>$dat['JML_PASIEN']);
$i++;
}	
$json_penyakit = json_encode($penyakit);

$file = 'C:/xampp/htdocs/nsimrs/cronjob/log/dashboard_top10penyakit_rajal_tahunan_' . $bulan . '.txt';
$url = '';
$content = '';
$update = false;
if(!file_exists($file)){
	$url = 'http://103.74.143.46/sirsservice/toptenrajal';	
	$content = '{"tahun":"' . $tahun . '","rawat_jalan":' . $json_penyakit . '}';
}else{
	$kode_kirim = cariString('idkirim',$file);
	if($kode_kirim == ''){
		$kode_ex_kirim = cariString('idexkirim',$file);
		if($kode_ex_kirim != ''){
			$arr_kode_ex_kirim = explode(':',$kode_ex_kirim);
			$url = 'http://103.74.143.46/sirsservice/toptenrajal?kode=' . $arr_kode_ex_kirim[1];
			$res = deleteData($url);
			$json_res = json_decode($res,true);	
			if(isset($json_res['kode']) and $json_res['kode'] == '200'){
				$file_contents = file_get_contents($file);
				$file_contents = str_replace('idexkirim','xxxxxxxxxxxx',$file_contents);
				file_put_contents($file,$file_contents);	
			}
		}
		$url = 'http://103.74.143.46/sirsservice/toptenrajal';	
		$content = '{"tahun":"' . $tahun . '","rawat_jalan":' . $json_penyakit . '}';
	}else{
		$arr_kode_kirim = explode(':',$kode_kirim);
		$url = 'http://103.74.143.46/sirsservice/updatetoptenrajal';	
		$content = '{"tahun":"' . $tahun . '","rawat_jalan":' . $json_penyakit . ',"kode_kirim":"' . $arr_kode_kirim[1] . '"}';
		$update = true;
	}
}		

$response = sendData($url,$content);
if(!empty($response)){
	$error = false;
	$json_response = json_decode($response,true);
	$fileopen = fopen($file, 'a') or die('Cant open file.');
	fwrite($fileopen, $jam_modified . ' ' . $content . ' - ' . $response . " \n");
	if($update == false){
		if(isset($json_response['kode']) and isset($json_response['kode_kirim']) and $json_response['kode'] == '200'){
			fwrite($fileopen, 'idkirim:' . $json_response['kode_kirim'] . " \n");
		}
	}else{
		if(!isset($json_response['kode']) and $json_response['kode'] != '200') $error = true;	
	}
	fclose($fileopen);
		
	if($error){
		$file_contents = file_get_contents($file);
		$file_contents = str_replace('idkirim','idexkirim',$file_contents);
		file_put_contents($file,$file_contents);
	}
}

//top 10 penyakit rawat inap bulanan
$sql = 'SELECT KODE_ICD,JML_PASIEN
		FROM (SELECT COUNT(t_irna.IRNA_ID) AS JML_PASIEN,
		m_icd_x.ICD_CODE AS KODE_ICD
		FROM t_irna
		INNER JOIN t_irna_diagnosa ON (t_irna.IRNA_ID = t_irna_diagnosa.IRNA_ID)
		INNER JOIN m_icd_x ON (t_irna_diagnosa.ICD_CODE = m_icd_x.ICD_CODE)	
		WHERE DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%Y-%m") = "' . $bulan . '"
		AND (t_irna.ST_BATAL IS NULL OR t_irna.ST_BATAL = "")
		AND t_irna_diagnosa.DIAGNOSA_ORDER = 0
		GROUP BY m_icd_x.ICD_CODE
		) t_penyakit
		ORDER BY JML_PASIEN DESC LIMIT 10';
$get = mysql_query($sql) or die(mysql_error());
$penyakit = array();
$i = 0;
while($dat = mysql_fetch_array($get)){
	$penyakit[$i] = array('kode_icd_10'=>$dat['KODE_ICD'],'jumlah'=>$dat['JML_PASIEN']);
$i++;
}	
$json_penyakit = json_encode($penyakit);

$file = 'C:/xampp/htdocs/nsimrs/cronjob/log/dashboard_top10penyakit_ranap_' . $bulan . '.txt';
$url = '';
$content = '';
$update = false;
if(!file_exists($file)){
	$url = 'http://103.74.143.46/sirsservice/toptenranap';	
	$content = '{"bulan":"' . $bulan2 . '","tahun":"' . $tahun . '","rawat_inap":' . $json_penyakit . '}';
}else{
	$kode_kirim = cariString('idkirim',$file);
	if($kode_kirim == ''){
		$kode_ex_kirim = cariString('idexkirim',$file);
		if($kode_ex_kirim != ''){
			$arr_kode_ex_kirim = explode(':',$kode_ex_kirim);
			$url = 'http://103.74.143.46/sirsservice/toptenranap?kode=' . $arr_kode_ex_kirim[1];
			$res = deleteData($url);
			$json_res = json_decode($res,true);	
			if(isset($json_res['kode']) and $json_res['kode'] == '200'){
				$file_contents = file_get_contents($file);
				$file_contents = str_replace('idexkirim','xxxxxxxxxxxx',$file_contents);
				file_put_contents($file,$file_contents);	
			}
		}
		$url = 'http://103.74.143.46/sirsservice/toptenranap';	
		$content = '{"bulan":"' . $bulan2 . '","tahun":"' . $tahun . '","rawat_inap":' . $json_penyakit . '}';
	}else{
		$arr_kode_kirim = explode(':',$kode_kirim);
		$url = 'http://103.74.143.46/sirsservice/updatetoptenranap';	
		$content = '{"bulan":"' . $bulan2 . '","tahun":"' . $tahun . '","rawat_inap":' . $json_penyakit . ',"kode_kirim":"' . $arr_kode_kirim[1] . '"}';
		$update = true;
	}
}		

$response = sendData($url,$content);
if(!empty($response)){
	$error = false;
	$json_response = json_decode($response,true);
	$fileopen = fopen($file, 'a') or die('Cant open file.');
	fwrite($fileopen, $jam_modified . ' ' . $content . ' - ' . $response . " \n");
	if($update == false){
		if(isset($json_response['kode']) and isset($json_response['kode_kirim']) and $json_response['kode'] == '200'){
			fwrite($fileopen, 'idkirim:' . $json_response['kode_kirim'] . " \n");
		}
	}else{
		if(!isset($json_response['kode']) and $json_response['kode'] != '200') $error = true;	
	}
	fclose($fileopen);
		
	if($error){
		$file_contents = file_get_contents($file);
		$file_contents = str_replace('idkirim','idexkirim',$file_contents);
		file_put_contents($file,$file_contents);
	}
}

//top 10 penyakit rawat inap tahunan
$sql = 'SELECT KODE_ICD,JML_PASIEN
		FROM (SELECT COUNT(t_irna.IRNA_ID) AS JML_PASIEN,
		m_icd_x.ICD_CODE AS KODE_ICD
		FROM t_irna
		INNER JOIN t_irna_diagnosa ON (t_irna.IRNA_ID = t_irna_diagnosa.IRNA_ID)
		INNER JOIN m_icd_x ON (t_irna_diagnosa.ICD_CODE = m_icd_x.ICD_CODE)	
		WHERE DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%Y") = "' . $tahun . '"
		AND (t_irna.ST_BATAL IS NULL OR t_irna.ST_BATAL = "")
		AND t_irna_diagnosa.DIAGNOSA_ORDER = 0
		GROUP BY m_icd_x.ICD_CODE
		) t_penyakit
		ORDER BY JML_PASIEN DESC LIMIT 10';
$get = mysql_query($sql) or die(mysql_error());
$penyakit = array();
$i = 0;
while($dat = mysql_fetch_array($get)){
	$penyakit[$i] = array('kode_icd_10'=>$dat['KODE_ICD'],'jumlah'=>$dat['JML_PASIEN']);
$i++;
}	
$json_penyakit = json_encode($penyakit);

$file = 'C:/xampp/htdocs/nsimrs/cronjob/log/dashboard_top10penyakit_ranap_tahunan_' . $bulan . '.txt';
$url = '';
$content = '';
$update = false;
if(!file_exists($file)){
	$url = 'http://103.74.143.46/sirsservice/toptenranap';	
	$content = '{"tahun":"' . $tahun . '","rawat_inap":' . $json_penyakit . '}';
}else{
	$kode_kirim = cariString('idkirim',$file);
	if($kode_kirim == ''){
		$kode_ex_kirim = cariString('idexkirim',$file);
		if($kode_ex_kirim != ''){
			$arr_kode_ex_kirim = explode(':',$kode_ex_kirim);
			$url = 'http://103.74.143.46/sirsservice/toptenranap?kode=' . $arr_kode_ex_kirim[1];
			$res = deleteData($url);
			$json_res = json_decode($res,true);	
			if(isset($json_res['kode']) and $json_res['kode'] == '200'){
				$file_contents = file_get_contents($file);
				$file_contents = str_replace('idexkirim','xxxxxxxxxxxx',$file_contents);
				file_put_contents($file,$file_contents);	
			}
		}
		$url = 'http://103.74.143.46/sirsservice/toptenranap';	
		$content = '{"tahun":"' . $tahun . '","rawat_inap":' . $json_penyakit . '}';
	}else{
		$arr_kode_kirim = explode(':',$kode_kirim);
		$url = 'http://103.74.143.46/sirsservice/updatetoptenrajal';	
		$content = '{"tahun":"' . $tahun . '","rawat_inap":' . $json_penyakit . ',"kode_kirim":"' . $arr_kode_kirim[1] . '"}';
		$update = true;
	}
}		

$response = sendData($url,$content);
if(!empty($response)){
	$error = false;
	$json_response = json_decode($response,true);
	$fileopen = fopen($file, 'a') or die('Cant open file.');
	fwrite($fileopen, $jam_modified . ' ' . $content . ' - ' . $response . " \n");
	if($update == false){
		if(isset($json_response['kode']) and isset($json_response['kode_kirim']) and $json_response['kode'] == '200'){
			fwrite($fileopen, 'idkirim:' . $json_response['kode_kirim'] . " \n");
		}
	}else{
		if(!isset($json_response['kode']) and $json_response['kode'] != '200') $error = true;	
	}
	fclose($fileopen);
		
	if($error){
		$file_contents = file_get_contents($file);
		$file_contents = str_replace('idkirim','idexkirim',$file_contents);
		file_put_contents($file,$file_contents);
	}
}

//indikator
$sql = 'SELECT COUNT(t_pasien.IRNA_ID) AS JML_HARI_PERAWATAN
		FROM
		(SELECT t_irna_opname.IRNA_ID
		FROM t_irna_opname 
		WHERE DATE_FORMAT(t_irna_opname.TANGGAL_OPNAME,"%Y-%m") = "' . $bulan . '"
		UNION ALL
		SELECT t_pasien_log.IRNA_ID
		FROM (SELECT t_irna_log.IRNA_ID,
				(SELECT t.TANGGAL_MASUK FROM t_irna_log t 
				WHERE t.IRNA_ID = t_irna_log.IRNA_ID
				AND t.RUANG_ID_BARU = t_irna_log.RUANG_ID_ASAL
				AND t.JNS_UPDATE = "R"
				AND t.IRNA_LOG_ID < t_irna_log.IRNA_LOG_ID
				ORDER BY t.TANGGAL_MASUK DESC LIMIT 1) AS TANGGAL_MASUK,
				t_irna_log.TANGGAL_KELUAR
			FROM t_irna_log
			WHERE DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%Y-%m") = "' . $bulan . '"
			AND t_irna_log.JNS_UPDATE = "R"
			AND t_irna_log.RUANG_ID_BARU IS NULL
			) t_pasien_log
		WHERE DATE_FORMAT(t_pasien_log.TANGGAL_MASUK,"%d%m%Y") = DATE_FORMAT(t_pasien_log.TANGGAL_KELUAR,"%d%m%Y")
		) t_pasien';
$get = mysql_query($sql) or die(mysql_error());
$dat = mysql_fetch_assoc($get);
$jml_hari_perawatan = $dat['JML_HARI_PERAWATAN'];
		
$sql = 'SELECT COUNT(m_ruang_detail.RUANG_DETAIL_ID) AS JML_BED,
		DATE_FORMAT(LAST_DAY(STR_TO_DATE("' . $bulan . '-01","%Y-%m-%d")),"%d") AS LD
		FROM m_ruang
		INNER JOIN m_ruang_detail ON (m_ruang.RUANG_ID = m_ruang_detail.RUANG_ID)';
$get = mysql_query($sql) or die(mysql_error());
$dat = mysql_fetch_assoc($get);
$jml_bed = $dat['JML_BED'];
$jml_hari = $dat['LD'];

$jml_bor = ($jml_hari_perawatan/($jml_bed*$jml_hari))*100;

$sql = 'SELECT SUM(DATEDIFF(t_irna_log.TANGGAL_KELUAR,
							(SELECT t.TANGGAL_MASUK FROM t_irna_log t 
							WHERE t.IRNA_ID = t_irna_log.IRNA_ID
							AND t.JNS_UPDATE = "R"
							AND t.RUANG_ID_BARU IS NOT NULL
							AND t.RUANG_ID_ASAL IS NULL
							ORDER BY t.TANGGAL_MASUK ASC LIMIT 1)) + 1) AS LAMA_DIRAWAT,
		COUNT(DISTINCT t_irna_log.IRNA_ID) AS JML_KELUAR
		FROM t_irna_log
		WHERE t_irna_log.JNS_UPDATE = "R"
		AND t_irna_log.RUANG_ID_BARU IS NULL
		AND DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%Y-%m") = "' . $bulan . '"';
$get = mysql_query($sql) or die(mysql_error());
$dat = mysql_fetch_assoc($get);		
$jml_lama_dirawat = $dat['LAMA_DIRAWAT'];
$jml_pasien_keluar = $dat['JML_KELUAR'];

$jml_avlos = 0;
$jml_toi = 0;
if($jml_pasien_keluar > 0) {
	$jml_avlos = $jml_lama_dirawat/$jml_pasien_keluar;
	$jml_toi = (($jml_bed*$jml_hari)-$jml_hari_perawatan)/$jml_pasien_keluar;
}	
$jml_bto = $jml_pasien_keluar/$jml_bed;

$sql = 'SELECT COUNT(t_irna_log.IRNA_ID) AS JML_MENINGGAL_M48
		FROM t_irna_log
		WHERE t_irna_log.JNS_UPDATE = "R" 
		AND t_irna_log.RUANG_ID_BARU IS NULL
		AND t_irna_log.PASIEN_KEADAAN_ID = 8
		AND DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%Y-%m") = "' . $bulan . '"'; 
$get = mysql_query($sql) or die(mysql_error());
$dat = mysql_fetch_assoc($get);
$jml_pasien_meninggal_m48 = $dat['JML_MENINGGAL_M48'];

$jml_ndr = 0;
if($jml_pasien_keluar > 0) $jml_ndr = ($jml_pasien_meninggal_m48/$jml_pasien_keluar)*1000;

$sql = 'SELECT COUNT(t_irna_log.IRNA_ID) AS JML_MENINGGAL
		FROM t_irna_log
		WHERE t_irna_log.JNS_UPDATE = "R" 
		AND t_irna_log.RUANG_ID_BARU IS NULL
		AND (t_irna_log.PASIEN_PULANG_ID = 3 OR t_irna_log.PASIEN_PULANG_ID = 8)
		AND DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%Y-%m") = "' . $bulan . '"'; 
$get = mysql_query($sql) or die(mysql_error());
$dat = mysql_fetch_assoc($get);
$jml_pasien_meninggal = $dat['JML_MENINGGAL'];		

$jml_gdr = 0;
if($jml_pasien_keluar > 0) $jml_gdr = ($jml_pasien_meninggal/$jml_pasien_keluar)*1000;

$file = 'C:/xampp/htdocs/nsimrs/cronjob/log/dashboard_indikator_' . $bulan . '.txt';
$url = '';
$content = '';
$update = false;
if(!file_exists($file)){
	$url = 'http://103.74.143.46/sirsservice/indikator';	
	$content = '{"periode":"' . $bulan2 . '","bor":"' . $jml_bor . '","alos":"' . $jml_avlos . '","bto":"' . $jml_bto . '","toi":"' . $jml_toi . '","ndr":"' . $jml_ndr . '","gdr":"' . $jml_gdr . '","tahun":"' . $tahun . '"}';
}else{
	$kode_kirim = cariString('idkirim',$file);
	if($kode_kirim == ''){
		$kode_ex_kirim = cariString('idexkirim',$file);
		if($kode_ex_kirim != ''){
			$arr_kode_ex_kirim = explode(':',$kode_ex_kirim);
			$url = 'http://103.74.143.46/sirsservice/indikator?kode=' . $arr_kode_ex_kirim[1];
			$res = deleteData($url);
			$json_res = json_decode($res,true);	
			if(isset($json_res['kode']) and $json_res['kode'] == '200'){
				$file_contents = file_get_contents($file);
				$file_contents = str_replace('idexkirim','xxxxxxxxxxxx',$file_contents);
				file_put_contents($file,$file_contents);	
			}
		}
		$url = 'http://103.74.143.46/sirsservice/indikator';	
		$content = '{"periode":"' . $bulan2 . '","bor":"' . $jml_bor . '","alos":"' . $jml_avlos . '","bto":"' . $jml_bto . '","toi":"' . $jml_toi . '","ndr":"' . $jml_ndr . '","gdr":"' . $jml_gdr . '","tahun":"' . $tahun . '"}';
	}else{
		$arr_kode_kirim = explode(':',$kode_kirim);
		$url = 'http://103.74.143.46/sirsservice/updateindikator';	
		$content = '{"periode":"' . $bulan2 . '","bor":"' . $jml_bor . '","alos":"' . $jml_avlos . '","bto":"' . $jml_bto . '","toi":"' . $jml_toi . '","ndr":"' . $jml_ndr . '","gdr":"' . $jml_gdr . '","kode_kirim":"' . $arr_kode_kirim[1] . '"}';
		$update = true;
	}
}		

$response = sendData($url,$content);
if(!empty($response)){
	$error = false;
	$json_response = json_decode($response,true);
	$fileopen = fopen($file, 'a') or die('Cant open file.');
	fwrite($fileopen, $jam_modified . ' ' . $content . ' - ' . $response . " \n");
	if($update == false){
		if(isset($json_response['kode']) and isset($json_response['kode_kirim']) and $json_response['kode'] == '200'){
			fwrite($fileopen, 'idkirim:' . $json_response['kode_kirim'] . " \n");
		}
	}else{
		if(!isset($json_response['kode']) and $json_response['kode'] != '200') $error = true;	
	}
	fclose($fileopen);
		
	if($error){
		$file_contents = file_get_contents($file);
		$file_contents = str_replace('idkirim','idexkirim',$file_contents);
		file_put_contents($file,$file_contents);
	}
}

//indikator triwulan
$sql = 'SELECT COUNT(t_pasien.IRNA_ID) AS JML_HARI_PERAWATAN
		FROM
		(SELECT t_irna_opname.IRNA_ID
		FROM t_irna_opname 
		WHERE DATE_FORMAT(t_irna_opname.TANGGAL_OPNAME,"%Y-%m") = "' . $bulan . '"
		UNION ALL
		SELECT t_pasien_log.IRNA_ID
		FROM (SELECT t_irna_log.IRNA_ID,
				(SELECT t.TANGGAL_MASUK FROM t_irna_log t 
				WHERE t.IRNA_ID = t_irna_log.IRNA_ID
				AND t.RUANG_ID_BARU = t_irna_log.RUANG_ID_ASAL
				AND t.JNS_UPDATE = "R"
				AND t.IRNA_LOG_ID < t_irna_log.IRNA_LOG_ID
				ORDER BY t.TANGGAL_MASUK DESC LIMIT 1) AS TANGGAL_MASUK,
				t_irna_log.TANGGAL_KELUAR
			FROM t_irna_log';
if($bulan2 == '1' or $bulan2 == '2' or $bulan2 == '3'){			
	$sql .= ' WHERE DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%Y") = "' . $tahun . '"
			AND (DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "01"
			OR DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "02"
			OR DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "03")';
}else if($bulan2 == '4' or $bulan2 == '5' or $bulan2 == '6'){
	$sql .= ' WHERE DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%Y") = "' . $tahun . '"
			AND (DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "04"
			OR DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "05"
			OR DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "06")';
}else if($bulan2 == '7' or $bulan2 == '8' or $bulan2 == '9'){
	$sql .= ' WHERE DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%Y") = "' . $tahun . '"
			AND (DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "07"
			OR DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "08"
			OR DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "09")';
}else if($bulan2 == '10' or $bulan2 == '11' or $bulan2 == '12'){
	$sql .= ' WHERE DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%Y") = "' . $tahun . '"
			AND (DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "10"
			OR DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "11"
			OR DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "12")';			
}	
$sql .= ' AND t_irna_log.JNS_UPDATE = "R"
			AND t_irna_log.RUANG_ID_BARU IS NULL
			) t_pasien_log
		WHERE DATE_FORMAT(t_pasien_log.TANGGAL_MASUK,"%d%m%Y") = DATE_FORMAT(t_pasien_log.TANGGAL_KELUAR,"%d%m%Y")
		) t_pasien';
$get = mysql_query($sql) or die(mysql_error());
$dat = mysql_fetch_assoc($get);
$jml_hari_perawatan = $dat['JML_HARI_PERAWATAN'];
		
$sql = 'SELECT COUNT(m_ruang_detail.RUANG_DETAIL_ID) AS JML_BED
		FROM m_ruang
		INNER JOIN m_ruang_detail ON (m_ruang.RUANG_ID = m_ruang_detail.RUANG_ID)';
$get = mysql_query($sql) or die(mysql_error());
$dat = mysql_fetch_assoc($get);
$jml_bed = $dat['JML_BED'];

if($bulan2 == '1' or $bulan2 == '2' or $bulan2 == '3'){					
	$sql = 'SELECT SUM(LD) AS LD
			FROM (
			SELECT DATE_FORMAT(LAST_DAY(STR_TO_DATE("' . $tahun . '-01-01","%Y-%m-%d")),"%d") AS LD
			UNION ALL
			SELECT DATE_FORMAT(LAST_DAY(STR_TO_DATE("' . $tahun . '-02-01","%Y-%m-%d")),"%d") AS LD
			UNION ALL
			SELECT DATE_FORMAT(LAST_DAY(STR_TO_DATE("' . $tahun . '-03-01","%Y-%m-%d")),"%d") AS LD
		) t_lastday';
}else if($bulan2 == '4' or $bulan2 == '5' or $bulan2 == '6'){					
	$sql = 'SELECT SUM(LD) AS LD
			FROM (
			SELECT DATE_FORMAT(LAST_DAY(STR_TO_DATE("' . $tahun . '-04-01","%Y-%m-%d")),"%d") AS LD
			UNION ALL
			SELECT DATE_FORMAT(LAST_DAY(STR_TO_DATE("' . $tahun . '-05-01","%Y-%m-%d")),"%d") AS LD
			UNION ALL
			SELECT DATE_FORMAT(LAST_DAY(STR_TO_DATE("' . $tahun . '-06-01","%Y-%m-%d")),"%d") AS LD
		) t_lastday';
}else if($bulan2 == '7' or $bulan2 == '8' or $bulan2 == '9'){					
	$sql = 'SELECT SUM(LD) AS LD
			FROM (
			SELECT DATE_FORMAT(LAST_DAY(STR_TO_DATE("' . $tahun . '-07-01","%Y-%m-%d")),"%d") AS LD
			UNION ALL
			SELECT DATE_FORMAT(LAST_DAY(STR_TO_DATE("' . $tahun . '-08-01","%Y-%m-%d")),"%d") AS LD
			UNION ALL
			SELECT DATE_FORMAT(LAST_DAY(STR_TO_DATE("' . $tahun . '-09-01","%Y-%m-%d")),"%d") AS LD
		) t_lastday';
}else if($bulan2 == '10' or $bulan2 == '11' or $bulan2 == '12'){					
	$sql = 'SELECT SUM(LD) AS LD
			FROM (
			SELECT DATE_FORMAT(LAST_DAY(STR_TO_DATE("' . $tahun . '-10-01","%Y-%m-%d")),"%d") AS LD
			UNION ALL
			SELECT DATE_FORMAT(LAST_DAY(STR_TO_DATE("' . $tahun . '-11-01","%Y-%m-%d")),"%d") AS LD
			UNION ALL
			SELECT DATE_FORMAT(LAST_DAY(STR_TO_DATE("' . $tahun . '-12-01","%Y-%m-%d")),"%d") AS LD
		) t_lastday';
}		
$get = mysql_query($sql) or die(mysql_error());
$dat = mysql_fetch_assoc($get);
$jml_hari = $dat['LD'];

$jml_bor = ($jml_hari_perawatan/($jml_bed*$jml_hari))*100;

$sql = 'SELECT SUM(DATEDIFF(t_irna_log.TANGGAL_KELUAR,
							(SELECT t.TANGGAL_MASUK FROM t_irna_log t 
							WHERE t.IRNA_ID = t_irna_log.IRNA_ID
							AND t.JNS_UPDATE = "R"
							AND t.RUANG_ID_BARU IS NOT NULL
							AND t.RUANG_ID_ASAL IS NULL
							ORDER BY t.TANGGAL_MASUK ASC LIMIT 1)) + 1) AS LAMA_DIRAWAT,
		COUNT(DISTINCT t_irna_log.IRNA_ID) AS JML_KELUAR
		FROM t_irna_log
		WHERE t_irna_log.JNS_UPDATE = "R"
		AND t_irna_log.RUANG_ID_BARU IS NULL';
if($bulan2 == '1' or $bulan2 == '2' or $bulan2 == '3'){			
	$sql .= ' AND DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%Y") = "' . $tahun . '"
			AND (DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "01"
			OR DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "02"
			OR DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "03")';
}else if($bulan2 == '4' or $bulan2 == '5' or $bulan2 == '6'){
	$sql .= ' AND DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%Y") = "' . $tahun . '"
			AND (DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "04"
			OR DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "05"
			OR DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "06")';
}else if($bulan2 == '7' or $bulan2 == '8' or $bulan2 == '9'){
	$sql .= ' AND DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%Y") = "' . $tahun . '"
			AND (DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "07"
			OR DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "08"
			OR DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "09")';
}else if($bulan2 == '10' or $bulan2 == '11' or $bulan2 == '12'){
	$sql .= ' AND DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%Y") = "' . $tahun . '"
			AND (DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "10"
			OR DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "11"
			OR DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "12")';			
}
$get = mysql_query($sql) or die(mysql_error());
$dat = mysql_fetch_assoc($get);		
$jml_lama_dirawat = $dat['LAMA_DIRAWAT'];
$jml_pasien_keluar = $dat['JML_KELUAR'];

$jml_avlos = 0;
$jml_toi = 0;
if($jml_pasien_keluar > 0) {
	$jml_avlos = $jml_lama_dirawat/$jml_pasien_keluar;
	$jml_toi = (($jml_bed*$jml_hari)-$jml_hari_perawatan)/$jml_pasien_keluar;
}	
$jml_bto = $jml_pasien_keluar/$jml_bed;

$sql = 'SELECT COUNT(t_irna_log.IRNA_ID) AS JML_MENINGGAL_M48
		FROM t_irna_log
		WHERE t_irna_log.JNS_UPDATE = "R" 
		AND t_irna_log.RUANG_ID_BARU IS NULL
		AND t_irna_log.PASIEN_KEADAAN_ID = 8';	
if($bulan2 == '1' or $bulan2 == '2' or $bulan2 == '3'){			
	$sql .= ' AND DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%Y") = "' . $tahun . '"
			AND (DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "01"
			OR DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "02"
			OR DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "03")';
}else if($bulan2 == '4' or $bulan2 == '5' or $bulan2 == '6'){
	$sql .= ' AND DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%Y") = "' . $tahun . '"
			AND (DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "04"
			OR DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "05"
			OR DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "06")';
}else if($bulan2 == '7' or $bulan2 == '8' or $bulan2 == '9'){
	$sql .= ' AND DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%Y") = "' . $tahun . '"
			AND (DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "07"
			OR DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "08"
			OR DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "09")';
}else if($bulan2 == '10' or $bulan2 == '11' or $bulan2 == '12'){
	$sql .= ' AND DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%Y") = "' . $tahun . '"
			AND (DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "10"
			OR DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "11"
			OR DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "12")';			
}
$get = mysql_query($sql) or die(mysql_error());
$dat = mysql_fetch_assoc($get);
$jml_pasien_meninggal_m48 = $dat['JML_MENINGGAL_M48'];

$jml_ndr = 0;
if($jml_pasien_keluar > 0) $jml_ndr = ($jml_pasien_meninggal_m48/$jml_pasien_keluar)*1000;

$sql = 'SELECT COUNT(t_irna_log.IRNA_ID) AS JML_MENINGGAL
		FROM t_irna_log
		WHERE t_irna_log.JNS_UPDATE = "R" 
		AND t_irna_log.RUANG_ID_BARU IS NULL
		AND (t_irna_log.PASIEN_PULANG_ID = 3 OR t_irna_log.PASIEN_PULANG_ID = 8)';
if($bulan2 == '1' or $bulan2 == '2' or $bulan2 == '3'){			
	$sql .= ' AND DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%Y") = "' . $tahun . '"
			AND (DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "01"
			OR DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "02"
			OR DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "03")';
}else if($bulan2 == '4' or $bulan2 == '5' or $bulan2 == '6'){
	$sql .= ' AND DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%Y") = "' . $tahun . '"
			AND (DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "04"
			OR DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "05"
			OR DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "06")';
}else if($bulan2 == '7' or $bulan2 == '8' or $bulan2 == '9'){
	$sql .= ' AND DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%Y") = "' . $tahun . '"
			AND (DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "07"
			OR DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "08"
			OR DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "09")';
}else if($bulan2 == '10' or $bulan2 == '11' or $bulan2 == '12'){
	$sql .= ' AND DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%Y") = "' . $tahun . '"
			AND (DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "10"
			OR DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "11"
			OR DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m") = "12")';			
}
$get = mysql_query($sql) or die(mysql_error());
$dat = mysql_fetch_assoc($get);
$jml_pasien_meninggal = $dat['JML_MENINGGAL'];		

$jml_gdr = 0;
if($jml_pasien_keluar > 0) $jml_gdr = ($jml_pasien_meninggal/$jml_pasien_keluar)*1000;

if($bulan2 == '1' or $bulan2 == '2' or $bulan2 == '3'){			
	$triwulan = 'tw1';
}else if($bulan2 == '4' or $bulan2 == '5' or $bulan2 == '6'){
	$triwulan = 'tw2';
}else if($bulan2 == '7' or $bulan2 == '8' or $bulan2 == '9'){
	$triwulan = 'tw3';
}else if($bulan2 == '10' or $bulan2 == '11' or $bulan2 == '12'){
	$triwulan = 'tw4';
}

$file = 'C:/xampp/htdocs/nsimrs/cronjob/log/dashboard_indikator_' . $tahun . '-' . $triwulan . '.txt';
$url = '';
$content = '';
$update = false;
if(!file_exists($file)){
	$url = 'http://103.74.143.46/sirsservice/indikator';	
	$content = '{"periode":"' . $triwulan . '","bor":"' . $jml_bor . '","alos":"' . $jml_avlos . '","bto":"' . $jml_bto . '","toi":"' . $jml_toi . '","ndr":"' . $jml_ndr . '","gdr":"' . $jml_gdr . '","tahun":"' . $tahun . '"}';
}else{
	$kode_kirim = cariString('idkirim',$file);
	if($kode_kirim == ''){
		$kode_ex_kirim = cariString('idexkirim',$file);
		if($kode_ex_kirim != ''){
			$arr_kode_ex_kirim = explode(':',$kode_ex_kirim);
			$url = 'http://103.74.143.46/sirsservice/indikator?kode=' . $arr_kode_ex_kirim[1];
			$res = deleteData($url);
			$json_res = json_decode($res,true);	
			if(isset($json_res['kode']) and $json_res['kode'] == '200'){
				$file_contents = file_get_contents($file);
				$file_contents = str_replace('idexkirim','xxxxxxxxxxxx',$file_contents);
				file_put_contents($file,$file_contents);	
			}
		}
		$url = 'http://103.74.143.46/sirsservice/indikator';	
		$content = '{"periode":"' . $triwulan . '","bor":"' . $jml_bor . '","alos":"' . $jml_avlos . '","bto":"' . $jml_bto . '","toi":"' . $jml_toi . '","ndr":"' . $jml_ndr . '","gdr":"' . $jml_gdr . '","tahun":"' . $tahun . '"}';
	}else{
		$arr_kode_kirim = explode(':',$kode_kirim);
		$url = 'http://103.74.143.46/sirsservice/updateindikator';	
		$content = '{"periode":"' . $triwulan . '","bor":"' . $jml_bor . '","alos":"' . $jml_avlos . '","bto":"' . $jml_bto . '","toi":"' . $jml_toi . '","ndr":"' . $jml_ndr . '","gdr":"' . $jml_gdr . '","kode_kirim":"' . $arr_kode_kirim[1] . '"}';
		$update = true;
	}
}		

$response = sendData($url,$content);
if(!empty($response)){
	$error = false;
	$json_response = json_decode($response,true);
	$fileopen = fopen($file, 'a') or die('Cant open file.');
	fwrite($fileopen, $jam_modified . ' ' . $content . ' - ' . $response . " \n");
	if($update == false){
		if(isset($json_response['kode']) and isset($json_response['kode_kirim']) and $json_response['kode'] == '200'){
			fwrite($fileopen, 'idkirim:' . $json_response['kode_kirim'] . " \n");
		}
	}else{
		if(!isset($json_response['kode']) and $json_response['kode'] != '200') $error = true;	
	}
	fclose($fileopen);
		
	if($error){
		$file_contents = file_get_contents($file);
		$file_contents = str_replace('idkirim','idexkirim',$file_contents);
		file_put_contents($file,$file_contents);
	}
}
?>