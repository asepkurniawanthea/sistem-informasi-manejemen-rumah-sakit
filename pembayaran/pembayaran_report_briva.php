<?php
$tgl_1 = '';
if (isset($_SESSION['pembayaranreportbriva_tgl_1']))
    $tgl_1 = $_SESSION['pembayaranreportbriva_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['pembayaranreportbriva_tgl_1']))
    $tgl_2 = $_SESSION['pembayaranreportbriva_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['pembayaranreportbriva_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['pembayaranreportbriva_tgl_2'] = $_GET['tgl_2'];
}	
?>
<form name="search" method="get" action="index.php">
    <table class="tableform" border="0" >
        <tr>
            <td>Tanggal</td>
            <td><input type="text" name="tgl_1" id="tgl_1" value="<?php echo $tgl_1; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
       </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/>
            </td>	
			<td>&nbsp;</td>
            <td align="right"><input type="submit" value="cari" class="myButton" />&nbsp;
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$client_id = '7QwwT7sgCIt0Gq9vLohw1RymC6gAuOPv';
$client_secret = 'vlj5sZMjXDwcWy9b';
$institution_code = 'XGR087308W0';
$briva_no = '13055';
$main_url = 'https://partner.api.bri.co.id';

$connect = mysql_connect($hostname_8, $username_8, $password_8) or die(mysql_error());
mysql_select_db($database_8, $connect) or die(mysql_error());

function create_token(){
	global $client_id;
	global $client_secret;
	global $institution_code;
	global $briva_no;
	global $main_url;

	$data = 'client_id=' . $client_id . '&client_secret=' . $client_secret;
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$main_url . '/oauth/client_credential/accesstoken?grant_type=client_credentials');
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch,CURLOPT_HEADER, false);
	curl_setopt($ch,CURLOPT_ENCODING, '');
	curl_setopt($ch,CURLOPT_AUTOREFERER, true);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,30);
	curl_setopt($ch,CURLOPT_TIMEOUT, 60);
	curl_setopt($ch,CURLOPT_MAXREDIRS, 10);
	curl_setopt($ch,CURLOPT_POST, true);
	curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch,CURLOPT_VERBOSE, true);
	$response = curl_exec($ch);
		
	return $response;
}

function get_token() {
	$token = '';
	$qry_token = mysql_query('SELECT TOKEN,APPLICATION_NAME,EXPIRE_IN,
				CASE WHEN EXPIRE_IN > NOW() THEN "1" ELSE "2" END AS ST_TOKEN
				FROM t_briva_token') or die(mysql_error());
	if(mysql_num_rows($qry_token) == 0){
		$response = create_token();
		$json_response = json_decode($response,true);
		if(isset($json_response['access_token'])){
			$token = $json_response['access_token'];
			mysql_query('INSERT INTO t_briva_token (TOKEN,APPLICATION_NAME,EXPIRE_IN)
					VALUES("' . $json_response['access_token'] . '","' . $json_response['application_name'] . '",
					DATE_ADD(NOW(), INTERVAL 48 HOUR))') or die(mysql_error());
			}	
		}else{
			$dat_token = mysql_fetch_assoc($qry_token);
			if($dat_token['ST_TOKEN'] == '1'){
				$token = $dat_token['TOKEN'];
			}else{
				$response = create_token();
				$json_response = json_decode($response,true);
				if(isset($json_response['access_token'])){
					$token = $json_response['access_token'];
					mysql_query('UPDATE t_briva_token SET TOKEN = "' . $json_response['access_token'] . '",
						APPLICATION_NAME = "' . $json_response['application_name'] . '",
						EXPIRE_IN = DATE_ADD(NOW(), INTERVAL 48 HOUR)') or die(mysql_error());
				}
			}		
		}

		return $token;	
}
	
function BRIVAgenerateSignature($path, $verb, $token, $timestamp, $payload, $secret) {
    $payloads = "path=$path&verb=$verb&token=Bearer $token&timestamp=$timestamp&body=$payload";
    $signPayload = hash_hmac('sha256', $payloads, $secret, true);
    return base64_encode($signPayload);
}

if($tgl_1 != '' and $tgl_2 != ''){
	$token = get_token();
	
	mysql_query('DELETE FROM z_report_briva WHERE IP_ADDRESS = "' . getIpAddress() . '"') or die(mysql_error());
	
	$qry_date = 'SELECT DATE_FORMAT(vdate.SELECTED_DATE,"%Y%m%d") AS SELECTED_DATE
				FROM (SELECT ADDDATE("1970-01-01",T4.I*10000 + T3.I*1000 + T2.I*100 + T1.I*10 + T0.I) SELECTED_DATE FROM
				(SELECT 0 I UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) T0,
				(SELECT 0 I UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) T1,
				(SELECT 0 I UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) T2,
				(SELECT 0 I UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) T3,
				(SELECT 0 I UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) T4
				) vdate
				WHERE vdate.SELECTED_DATE >= STR_TO_DATE("' . $tgl_1 . '","%d/%m/%Y")
				AND vdate.SELECTED_DATE <= STR_TO_DATE("' . $tgl_2 . '","%d/%m/%Y")
				ORDER BY vdate.SELECTED_DATE';
	$get_date = mysql_query($qry_date) or die(mysql_error());			
	while($dat_date = mysql_fetch_array($get_date)){
	
		$timestamp = gmdate("Y-m-d\TH:i:s.000\Z");
		$payload = null;
		$path = '/v1/briva/report/' . $institution_code . '/' . $briva_no . '/' . $dat_date['SELECTED_DATE'] . '/' . $dat_date['SELECTED_DATE'];
		$verb = 'GET';
		$base64sign = BRIVAgenerateSignature($path, $verb, $token, $timestamp, $payload, $client_secret);

		$request_headers = array(
			'Authorization:Bearer ' . $token,
			'BRI-Timestamp:' . $timestamp,
			'BRI-Signature:' . $base64sign,
		);
	
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, $main_url . '/v1/briva/report/' . $institution_code . '/' . $briva_no . '/' . $dat_date['SELECTED_DATE'] . '/' . $dat_date['SELECTED_DATE']);
		curl_setopt($ch,CURLOPT_HTTPHEADER, $request_headers);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch,CURLOPT_HEADER, false);
		curl_setopt($ch,CURLOPT_ENCODING, '');
		curl_setopt($ch,CURLOPT_AUTOREFERER, true);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,30);
		curl_setopt($ch,CURLOPT_TIMEOUT, 60);
		curl_setopt($ch,CURLOPT_MAXREDIRS, 10);
		curl_setopt($ch,CURLOPT_POST, false);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET'); 
		curl_setopt($ch,CURLOPT_POSTFIELDS, $payload);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch,CURLOPT_VERBOSE, true);
		$response = curl_exec($ch);
		$json_response = json_decode($response,true);
		if(isset($json_response['status']) and $json_response['status'] == 'true'){
			$json_data = $json_response['data'];
			foreach($json_data as $key=>$value){
				mysql_query('INSERT INTO z_report_briva (TANGGAL,NO_BRIVA,NAMA,JUMLAH,
					TGL_BAYAR,NO_REKENING,KETERANGAN,IP_ADDRESS) VALUES(
					STR_TO_DATE("' . $dat_date['SELECTED_DATE'] . '","%Y%m%d"),
					"' . $value['custCode'] . '","' . $value['nama'] . '",
					"' . $value['amount'] . '",
					STR_TO_DATE("' . str_replace('.000','',$value['paymentDate']) . '","%Y-%m-%d %H:%i:%s"),
					"' . $value['no_rek'] . '","' . $value['keterangan'] . '",
					"' . getIpAddress() . '")') or die(mysql_error());
			}	
		}
	}	

$get_report = mysql_query('SELECT DATE_FORMAT(TANGGAL,"%d-%m-%Y") AS TANGGAL,
					NO_BRIVA,NAMA,JUMLAH,
					DATE_FORMAT(TGL_BAYAR,"%d-%m-%Y %H:%i") AS TGL_BAYAR,
					NO_REKENING,KETERANGAN 
					FROM z_report_briva
					WHERE IP_ADDRESS = "' . getIpAddress() . '"
					ORDER BY NAMA') or die(mysql_error());
?>
<table width="100%" border="1" class="tableData" id="tfhover">
  <tr>
    <th width="10">No</th>
    <th>Tanggal</th>
    <th>No BRIVA</th>
	<th>Nama</th>
	<th>Jumlah</th>
	<th>Tanggal Bayar</th>
	<th>No Rekening</th>
	<th>Keterangan</th>
  </tr>
<?php $no = 1; 
while($dat_report = mysql_fetch_array($get_report)){ ?>  
  <tr>
    <td scope="row" align="center"><?php echo $no; ?></td>
    <td align="center"><?php echo $dat_report['TANGGAL']; ?></td>
	<td align="center"><?php echo $dat_report['NO_BRIVA']; ?></td>
	<td><?php echo $dat_report['NAMA']; ?></td>
    <td align="right"><?php echo currFormat($dat_report['JUMLAH']); ?></td>
	<td align="center"><?php echo $dat_report['TGL_BAYAR']; ?></td>
	<td><?php echo $dat_report['NO_REKENING']; ?></td>
	<td><?php echo $dat_report['KETERANGAN']; ?></td>
  </tr>
 <?php $no++; } ?> 
</table>
<form id="xls_export" name="xls_export" method="post">
    <input type="hidden" name="page_to_excel" value="1" />
    <input type="hidden" name="tgl_1" value="<?php echo $tgl_1; ?>" />
    <input type="hidden" name="tgl_2" value="<?php echo $tgl_2; ?>" />
    <input type="hidden" name="xlsfile" value="pembayaran/xls_report_briva.php" />
    <input type="hidden" name="xlsname" value="rpt_briva.xls" />            
</form>
<?php } ?>

