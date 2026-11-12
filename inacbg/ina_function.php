<?php 
$arr_discharge_status[1] = '1';
$arr_discharge_status[2] = '2';
$arr_discharge_status[3] = '4';
$arr_discharge_status[4] = '5';
$arr_discharge_status[5] = '2';
$arr_discharge_status[6] = '2';
$arr_discharge_status[7] = '5';
$arr_discharge_status[8] = '4';
$arr_discharge_status[9] = '3';
$arr_discharge_status[10] = '5';
$arr_discharge_status[11] = '5';
$arr_discharge_status[12] = '2';
$arr_discharge_status[13] = '1';
$arr_discharge_status[14] = '1';
$arr_discharge_status[''] = '5';

$arr_payor_id[1] = '1';
$arr_payor_id[2] = '3';
$arr_payor_id[3] = '3';
$arr_payor_id[5] = '1';
$arr_payor_id[8] = '3';
$arr_payor_id[9] = '5';
$arr_payor_id[10] = '7';
$arr_payor_id[11] = '3';
$arr_payor_id[12] = '3';
$arr_payor_id[13] = '8';
$arr_payor_id[14] = '7';
$arr_payor_id[15] = '3';
$arr_payor_id[16] = '1';

$arr_payor_cd[1] = 'PASIEN BAYAR';
$arr_payor_cd[2] = 'JKN';
$arr_payor_cd[3] = 'JKN';
$arr_payor_cd[5] = 'PASIEN BAYAR';
$arr_payor_cd[8] = 'JKN';
$arr_payor_cd[9] = 'JAMKESDA';
$arr_payor_cd[10] = 'JAMKESDA 2';
$arr_payor_cd[11] = 'JKN';
$arr_payor_cd[12] = 'JKN';
$arr_payor_cd[13] = 'JAMKESDA 3';
$arr_payor_cd[14] = 'JAMKESDA 2';
$arr_payor_cd[15] = 'JKN';
$arr_payor_cd[16] = 'PASIEN BAYAR';

function saveLog($sfilename,$scontent){
	$jam_modified = date('H:i:s');
	$tgl_modified = date('Y-m-d');
	$file = fopen('C:/xampp/htdocs/nsimrs/cronjob/log/ina_' . $sfilename . '_' . $tgl_modified . '.txt', 'a') or die('Cant open file.');
	fwrite($file, $jam_modified . ' ' . $scontent . PHP_EOL);
	fclose($file);
}

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

function buat_klaim($nomor_kartu,$nomor_sep,$nomor_rm,$nama_pasien,$tgl_lahir,$gender,$idx,$jenis_rawat){
	global $inacbgs_host;
	
	$ret = '';
	
	$url = 'http://' . $inacbgs_host . '/simrs2inacbg/index.php?method=new_claim&svrmh=0';
	$content = array('nomor_kartu' => $nomor_kartu,
					'nomor_sep' => $nomor_sep,
					'nomor_rm' => $nomor_rm,
					'nama_pasien' => $nama_pasien,
					'tgl_lahir' => $tgl_lahir . ' 12:00:00',
					'gender' => $gender);
	$response = @sendData($url,http_build_query($content));
	$json_response = json_decode($response,true);
	$f_status = false;
	if(isset($json_response['metadata']['code'])){
		$ret = $json_response['metadata']['code'];
		if($ret == '200'){
			$f_status = true;
			mysql_query('INSERT INTO t_cbg_claim(RAWAT_ID,NO_SEP,NOMR,NO_PESERTA,
						NAMA_PASIEN,TGL_LAHIR,JNS_KELAMIN,JNS_RAWAT,KLAIM_BARU,USER_CASEMIX)
						VALUES("' . $idx . '","' . $nomor_sep . '","' . $nomor_rm . '",
						"' . $nomor_kartu . '","' . $nama_pasien . '",STR_TO_DATE("' . $tgl_lahir . '","%Y-%m-%d"),
						"' . $gender . '","' . $jenis_rawat . '","1","system")') or die(mysql_error());
		}
	}else{
		$ret = $response; 
	}	
	
	if($f_status == false) saveLog($jenis_rawat . 'B',$nomor_sep . ' - ' . $response);
	
	return $ret;
}

function update_klaim($nomor_sep,$nomor_kartu,$tgl_masuk,$tgl_pulang,$jenis_rawat,$kelas_rawat,$birth_weight,
						$discharge_status,$nama_dokter,$kode_tarif,$jenis_bayar_id,$coder_nik,$idx,$nomr){
	global $inacbgs_host;
	global $arr_discharge_status;
	global $arr_payor_id;
	global $arr_payor_cd;
	
	global $hostname_3; 
	global $username_3;
	global $password_3;
	global $database_3; 
	
	global $hostname; 
	global $username;
	global $password;
	global $database; 

	$ret = '';
	$tanggal = $tgl_masuk;
	
	$url = 'http://' . $inacbgs_host . '/simrs2inacbg/index.php?method=set_claim_data&nomor_sep=' . $nomor_sep . '&svrmh=0';
	
	$adl_sub_acute = '';
	$adl_chronic = '';
	$icu_indikator = '';
	$icu_los = '';
	$ventilator_hour = '';
	$upgrade_class_ind = '0';
	$upgrade_class_class = '';
	$upgrade_class_los = '';
	$add_payment_pct = '';
	$diagnosa = '';
	$procedure = '';
	$tarif_rs = 0;
	$tarif_poli_eks = 0;
	$cob_cd = '';
	
	if($jenis_rawat == '2'){
		//** instalasi rawat jalan **/
		$tgl_masuk = $tgl_masuk . ' 12:00:00';
		if(empty($tgl_pulang)) {
			$tgl_pulang = $tgl_masuk;
		}else{
			$tgl_pulang = $tgl_pulang . ' 12:00:00';
		}	
		
		/** diagnosa **/
		$sql_diagnosa = 'SELECT t_irja_diagnosa.DIAGNOSA,t_irja_diagnosa.ICD_CODE
				FROM t_irja_diagnosa
				INNER JOIN t_irja
				ON (t_irja_diagnosa.IRJA_ID = t_irja.IRJA_ID)
				WHERE t_irja.NOMR = "' . $nomr . '"
				AND t_irja.JENIS_BAYAR_ID = "' . $jenis_bayar_id . '"
				AND DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y-%m-%d") = "' . $tanggal . '"
				AND t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL
				ORDER BY t_irja_diagnosa.IRJA_ID,t_irja_diagnosa.DIAGNOSA_ORDER';
		$get_diagnosa = mysql_query($sql_diagnosa) or die(mysql_error());
		while($dat_diagnosa = mysql_fetch_array($get_diagnosa)){
			if(!empty($dat_diagnosa['ICD_CODE'])){
				$diagnosa = $diagnosa . trim($dat_diagnosa['ICD_CODE']) . '#';
			}
		}
		
		if(!empty($diagnosa)) $diagnosa = substr($diagnosa,0,strlen($diagnosa) - 1);
		
		//** procedure **/
		$sql_tindakan = 'SELECT t_irja_tarif.ICD_CODE,m_tarif.KODE_TARIF,m_tarif.TARIF_NON_KELAS AS TARIF
					FROM t_irja_tarif
					INNER JOIN m_tarif 
					ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN t_irja
					ON (t_irja_tarif.IRJA_ID = t_irja.IRJA_ID)
					WHERE t_irja.NOMR = "' . $nomr . '"
					AND t_irja.JENIS_BAYAR_ID = "' . $jenis_bayar_id . '"
					AND DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y-%m-%d") = "' . $tanggal . '"
					AND t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL
					AND t_irja_tarif.NO_TARIF IS NOT NULL
					AND t_irja_tarif.ST_BATAL IS NULL
					AND t_irja_tarif.ST_BAYAR <> "Batal"
					AND m_tarif.KODE_TARIF_GROUP <> "01"';
					
		$sql_penunjang = 'SELECT t_ipenunjang_tarif.ICD_CODE,m_tarif.KODE_TARIF,m_tarif.TARIF_NON_KELAS AS TARIF
					FROM t_ipenunjang_tarif
					INNER JOIN m_tarif 
					ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN t_ipenunjang 
					ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
					INNER JOIN t_irja 
					ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
					WHERE t_irja.NOMR = "' . $nomr . '"
					AND t_irja.JENIS_BAYAR_ID = "' . $jenis_bayar_id . '"
					AND DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y-%m-%d") = "' . $tanggal . '"
					AND t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL 
					AND t_ipenunjang.JNS_ORDER = "IRJ"
					AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
					AND t_ipenunjang_tarif.ST_BATAL IS NULL
					AND t_ipenunjang_tarif.ST_BAYAR <> "Batal"
					AND m_tarif.KODE_TARIF_GROUP <> "01"';		
					
		$sql_hemodialisa = 'SELECT t_hemodialisa_tarif.ICD_CODE,m_tarif.KODE_TARIF,m_tarif.TARIF_NON_KELAS AS TARIF
					FROM t_hemodialisa_tarif
					INNER JOIN m_tarif 
					ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN t_hemodialisa 
					ON (t_hemodialisa_tarif.HEMODIALISA_ID = t_hemodialisa.HEMODIALISA_ID)
					INNER JOIN t_irja 
					ON (t_hemodialisa.RAWAT_ID = t_irja.IRJA_ID)
					WHERE t_irja.NOMR = "' . $nomr . '"
					AND t_irja.JENIS_BAYAR_ID = "' . $jenis_bayar_id . '"
					AND DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y-%m-%d") = "' . $tanggal . '"
					AND t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL 
					AND t_hemodialisa.JNS_ORDER = "IRJ"
					AND t_hemodialisa_tarif.NO_TARIF IS NOT NULL
					AND t_hemodialisa_tarif.ST_BATAL IS NULL
					AND t_hemodialisa_tarif.ST_BAYAR <> "Batal"
					AND m_tarif.KODE_TARIF_GROUP <> "01"';
					
		$get_tindakan = mysql_query($sql_tindakan) or die(mysql_error());
		while($dat_tindakan = mysql_fetch_array($get_tindakan)){
			if(!empty($dat_tindakan['ICD_CODE'])){
				$procedure = $procedure . trim($dat_tindakan['ICD_CODE']) . '#';
			}
			$tarif_rs = $tarif_rs + $dat_tindakan['TARIF'];
		}

		$get_penunjang = mysql_query($sql_penunjang) or die(mysql_error());
		while($dat_penunjang = mysql_fetch_array($get_penunjang)){
			if(!empty($dat_penunjang['ICD_CODE'])){
				$procedure = $procedure . trim($dat_penunjang['ICD_CODE']) . '#';
			}
			$tarif_rs = $tarif_rs + $dat_penunjang['TARIF'];
		}

		$get_hemodialisa = mysql_query($sql_hemodialisa) or die(mysql_error());
		while($dat_hemodialisa = mysql_fetch_array($get_hemodialisa)){
			if(!empty($dat_hemodialisa['ICD_CODE'])){
				$procedure = $procedure . trim($dat_hemodialisa['ICD_CODE']) . '#';
			}
			$tarif_rs = $tarif_rs + $dat_hemodialisa['TARIF'];
		}
		
		if(!empty($procedure)) $procedure = substr($procedure,0,strlen($procedure) - 1);			
			
		//** farmasi **/
		$ls_irja_id = '';
		$sql_irja_id = 'SELECT IRJA_ID FROM t_irja
					WHERE NOMR = "' . $nomr . '"
					AND JENIS_BAYAR_ID = "' . $jenis_bayar_id . '"
					AND DATE_FORMAT(TANGGAL_DAFTAR,"%Y-%m-%d") = "' . $tanggal . '"
					AND NO_PENDAFTARAN IS NOT NULL AND ST_BATAL IS NULL';
		$get_irja_id = mysql_query($sql_irja_id) or die(mysql_error());
		while($dat_irja_id = mysql_fetch_array($get_irja_id)){
			$ls_irja_id = $ls_irja_id . $dat_irja_id['IRJA_ID'] . ',';
		};
		
		if(!empty($ls_irja_id)) $ls_irja_id = substr($ls_irja_id,0,strlen($ls_irja_id) - 1);
		
		$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
		mysql_select_db($database_3, $connect_3) or die(mysql_error());
		
		$sql_farmasi = 'SELECT t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,
					SUM((t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR * t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL)
					- ((t_farmasi_apotik_pengeluaran.PERSEN_JAMINAN/100) * 
					(t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR * t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL))) AS HARGA
					FROM t_rajal_resep 
					INNER JOIN t_rajal_resep_detail ON (t_rajal_resep.RAJAL_RESEP_ID = t_rajal_resep_detail.RAJAL_RESEP_ID)
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_rajal_resep_detail.RAJAL_RESEP_DETAIL_ID = t_farmasi_apotik_pengeluaran_detail.RAJAL_RESEP_DETAIL_ID)
					INNER JOIN t_farmasi_apotik_pengeluaran ON (t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID = t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID)
					INNER JOIN m_persediaan_farmasi ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					WHERE t_rajal_resep.RAJAL_ID IN (' . $ls_irja_id . ')
					AND t_rajal_resep.HEMODIALISA_ID IS NULL
					AND t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR > 0
					GROUP BY t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID';	
		$get_farmasi = mysql_query($sql_farmasi) or die(mysql_error());
		while($dat_farmasi = mysql_fetch_array($get_farmasi)){
			$tarif_rs = $tarif_rs + $dat_farmasi['HARGA'];
		};

		$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
		mysql_select_db($database, $connect) or die(mysql_error());		
		
	}else{
		//** instalasi rawat inap **/
		
		/** diagnosa **/
		$sql_diagnosa = 'SELECT * FROM 
				(SELECT t_irja_diagnosa.DIAGNOSA,t_irja_diagnosa.ICD_CODE,
				t_irja_diagnosa.DIAGNOSA_ORDER,1 AS ORD_RAWAT
				FROM t_irja_diagnosa
				WHERE t_irja_diagnosa.IRJA_ID = "' . $idx . '"
				UNION
				SELECT t_irna_diagnosa.DIAGNOSA,t_irna_diagnosa.ICD_CODE,
				t_irna_diagnosa.DIAGNOSA_ORDER,2 AS ORD_RAWAT
				FROM t_irna_diagnosa
				WHERE t_irna_diagnosa.IRNA_ID = "' . $idx . '") t_diagnosa
				ORDER BY ORD_RAWAT,DIAGNOSA_ORDER';
		$get_diagnosa = mysql_query($sql_diagnosa) or die(mysql_error());
		while($dat_diagnosa = mysql_fetch_array($get_diagnosa)){
			if(!empty($dat_diagnosa['ICD_CODE'])){
				$diagnosa = $diagnosa . trim($dat_diagnosa['ICD_CODE']) . '#';
			}
		}	

		if(!empty($diagnosa)) $diagnosa = substr($diagnosa,0,strlen($diagnosa) - 1);	

		/** procedure **/
		$sql_tindakan = 'SELECT t_irja_tarif.ICD_CODE,m_tarif.KODE_TARIF,m_tarif.TARIF_NON_KELAS AS TARIF,
					0 AS BOBOT_JAMINAN,0 AS BOBOT_RAWAT
					FROM t_irja_tarif
					INNER JOIN m_tarif 
					ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN t_irja
					ON (t_irja_tarif.IRJA_ID = t_irja.IRJA_ID)
					WHERE t_irja.IRJA_ID = "' . $idx . '"
					AND t_irja_tarif.NO_TARIF IS NOT NULL
					AND t_irja_tarif.ST_BATAL IS NULL
					AND t_irja_tarif.ST_BAYAR <> "Batal"
					AND m_tarif.KODE_TARIF_GROUP <> "01"
					UNION 
					SELECT t_irna_tarif.ICD_CODE,m_tarif.KODE_TARIF,
					CASE WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "3" THEN m_tarif.TARIF_KELAS_3
					WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "2" THEN m_tarif.TARIF_KELAS_2
					WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "1" THEN m_tarif.TARIF_KELAS_1
					WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "UTAMA" THEN m_tarif.TARIF_KELAS_UTAMA
					WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "VIP" THEN m_tarif.TARIF_KELAS_UTAMA
					WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "BAYI SEHAT" THEN m_tarif.TARIF_KELAS_PERINA_SEHAT
					WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "BAYI SAKIT" THEN m_tarif.TARIF_KELAS_PERINA_SAKIT
					WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "HCU" THEN m_tarif.TARIF_HCU 
					END AS TARIF,
					m_kelas_rawat.BOBOT AS BOBOT_JAMINAN,
					m_kelas_rawat2.BOBOT AS BOBOT_RAWAT
					FROM t_irna_tarif
					INNER JOIN m_tarif 
					ON (t_irna_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN t_irna
					ON (t_irna_tarif.IRNA_ID = t_irna.IRNA_ID)
					LEFT JOIN m_kelas_rawat 
					ON (t_irna_tarif.KELAS_JAMINAN = m_kelas_rawat.KELAS_RAWAT)
					LEFT JOIN m_kelas_rawat m_kelas_rawat2
					ON (t_irna_tarif.KELAS_RAWAT = m_kelas_rawat2.KELAS_RAWAT)
					WHERE t_irna.IRNA_ID = "' . $idx . '"
					AND t_irna_tarif.NO_TARIF IS NOT NULL
					AND t_irna_tarif.ST_BAYAR <> "Batal"
					AND m_tarif.KODE_TARIF_GROUP <> "01"';
					
		$sql_penunjang = 'SELECT t_ipenunjang_tarif.ICD_CODE,m_tarif.KODE_TARIF,m_tarif.TARIF_NON_KELAS AS TARIF
					FROM t_ipenunjang_tarif
					INNER JOIN m_tarif 
					ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN t_ipenunjang 
					ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
					INNER JOIN t_irja 
					ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
					WHERE t_irja.IRJA_ID = "' . $idx . '"
					AND t_ipenunjang.JNS_ORDER = "IRJ"
					AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
					AND t_ipenunjang_tarif.ST_BATAL IS NULL
					AND t_ipenunjang_tarif.ST_BAYAR <> "Batal"
					AND m_tarif.KODE_TARIF_GROUP <> "01"
					UNION
					SELECT t_ipenunjang_tarif.ICD_CODE,m_tarif.KODE_TARIF,m_tarif.TARIF_NON_KELAS AS TARIF
					FROM t_ipenunjang_tarif
					INNER JOIN m_tarif 
					ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN t_ipenunjang 
					ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
					INNER JOIN t_irna 
					ON (t_ipenunjang.RAWAT_ID = t_irna.IRNA_ID)
					WHERE t_irna.IRNA_ID = "' . $idx . '"
					AND t_ipenunjang.JNS_ORDER = "IRN"
					AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
					AND t_ipenunjang_tarif.ST_BATAL IS NULL
					AND t_ipenunjang_tarif.ST_BAYAR <> "Batal"
					AND m_tarif.KODE_TARIF_GROUP <> "01"';		
					
		$sql_hemodialisa = 'SELECT t_hemodialisa_tarif.ICD_CODE,m_tarif.KODE_TARIF,m_tarif.TARIF_NON_KELAS AS TARIF
					FROM t_hemodialisa_tarif
					INNER JOIN m_tarif 
					ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN t_hemodialisa 
					ON (t_hemodialisa_tarif.HEMODIALISA_ID = t_hemodialisa.HEMODIALISA_ID)
					INNER JOIN t_irja 
					ON (t_hemodialisa.RAWAT_ID = t_irja.IRJA_ID)
					WHERE t_irja.IRJA_ID = "' . $idx . '"
					AND t_hemodialisa.JNS_ORDER = "IRJ"
					AND t_hemodialisa_tarif.NO_TARIF IS NOT NULL
					AND t_hemodialisa_tarif.ST_BATAL IS NULL
					AND t_hemodialisa_tarif.ST_BAYAR <> "Batal"
					AND m_tarif.KODE_TARIF_GROUP <> "01"
					UNION
					SELECT t_hemodialisa_tarif.ICD_CODE,m_tarif.KODE_TARIF,m_tarif.TARIF_NON_KELAS AS TARIF
					FROM t_hemodialisa_tarif
					INNER JOIN m_tarif 
					ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN t_hemodialisa 
					ON (t_hemodialisa_tarif.HEMODIALISA_ID = t_hemodialisa.HEMODIALISA_ID)
					INNER JOIN t_irna 
					ON (t_hemodialisa.RAWAT_ID = t_irna.IRNA_ID)
					WHERE t_irna.IRNA_ID = "' . $idx . '"
					AND t_hemodialisa.JNS_ORDER = "IRN"
					AND t_hemodialisa_tarif.NO_TARIF IS NOT NULL
					AND t_hemodialisa_tarif.ST_BATAL IS NULL
					AND t_hemodialisa_tarif.ST_BAYAR <> "Batal"
					AND m_tarif.KODE_TARIF_GROUP <> "01"';
					
		$get_tindakan = mysql_query($sql_tindakan) or die(mysql_error());
		while($dat_tindakan = mysql_fetch_array($get_tindakan)){
			if(!empty($dat_tindakan['ICD_CODE'])){
				$procedure = $procedure . trim($dat_tindakan['ICD_CODE']) . '#';
			}
			$tarif_rs = $tarif_rs + $dat_tindakan['TARIF'];
			if(!empty($dat_tindakan['BOBOT_JAMINAN']) and !empty($dat_tindakan['BOBOT_RAWAT'])){
				if($dat_tindakan['BOBOT_RAWAT'] > $dat_tindakan['BOBOT_JAMINAN']) $upgrade_class_ind = '1';
			}
		}
		
		$get_penunjang = mysql_query($sql_penunjang) or die(mysql_error());
		while($dat_penunjang = mysql_fetch_array($get_penunjang)){
			if(!empty($dat_penunjang['ICD_CODE'])){
				$procedure = $procedure . trim($dat_penunjang['ICD_CODE']) . '#';
			}
			$tarif_rs = $tarif_rs + $dat_penunjang['TARIF'];
		}
		
		$get_hemodialisa = mysql_query($sql_hemodialisa) or die(mysql_error());
		while($dat_hemodialisa = mysql_fetch_array($get_hemodialisa)){
			if(!empty($dat_hemodialisa['ICD_CODE'])){
				$procedure = $procedure . trim($dat_hemodialisa['ICD_CODE']) . '#';
			}
			$tarif_rs = $tarif_rs + $dat_hemodialisa['TARIF'];
		}
		
		if(!empty($procedure)) $procedure = substr($procedure,0,strlen($procedure) - 1);

		/** farmasi **/
		$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
		mysql_select_db($database_3, $connect_3) or die(mysql_error());	
			
		$sql_farmasi = 'SELECT t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,
					SUM((t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR * t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL)
					- ((t_farmasi_apotik_pengeluaran.PERSEN_JAMINAN/100) * 
					(t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR * t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL))) AS HARGA
					FROM t_rajal_resep 
					INNER JOIN t_rajal_resep_detail ON (t_rajal_resep.RAJAL_RESEP_ID = t_rajal_resep_detail.RAJAL_RESEP_ID)
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_rajal_resep_detail.RAJAL_RESEP_DETAIL_ID = t_farmasi_apotik_pengeluaran_detail.RAJAL_RESEP_DETAIL_ID)
					INNER JOIN t_farmasi_apotik_pengeluaran ON (t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID = t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID)
					INNER JOIN m_persediaan_farmasi ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					WHERE t_rajal_resep.RAJAL_ID = "' . $idx . '"
					AND t_rajal_resep.HEMODIALISA_ID IS NULL
					AND t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR > 0
					GROUP BY t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID
					UNION
					SELECT t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,
					SUM((t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR * t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL)
					- ((t_farmasi_apotik_pengeluaran.PERSEN_JAMINAN/100) * 
					(t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR * t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL))) AS HARGA
					FROM t_ranap_resep 
					INNER JOIN t_ranap_resep_detail ON (t_ranap_resep.RANAP_RESEP_ID = t_ranap_resep_detail.RANAP_RESEP_ID)
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_ranap_resep_detail.RANAP_RESEP_DETAIL_ID = t_farmasi_apotik_pengeluaran_detail.RANAP_RESEP_DETAIL_ID)
					INNER JOIN t_farmasi_apotik_pengeluaran ON (t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID = t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID)
					INNER JOIN m_persediaan_farmasi ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					WHERE t_ranap_resep.RANAP_ID = "' . $idx . '"
					AND t_ranap_resep.HEMODIALISA_ID IS NULL
					AND t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR > 0
					GROUP BY t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID';
		$get_farmasi = mysql_query($sql_farmasi) or die(mysql_error());
		while($dat_farmasi = mysql_fetch_array($get_farmasi)){
			$tarif_rs = $tarif_rs + $dat_farmasi['HARGA'];
		}

		$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
		mysql_select_db($database, $connect) or die(mysql_error());							
	}
	$content = array('nomor_sep' => $nomor_sep,
					'nomor_kartu' => $nomor_kartu,
					'tgl_masuk' => $tgl_masuk,
					'tgl_pulang' => $tgl_pulang,
					'jenis_rawat' => $jenis_rawat,
					'kelas_rawat' => $kelas_rawat,
					'adl_sub_acute' => $adl_sub_acute,
					'adl_chronic' => $adl_chronic,
					'icu_indikator' => $icu_indikator,
					'icu_los' => $icu_los,
					'ventilator_hour' => $ventilator_hour,
					'upgrade_class_ind' => $upgrade_class_ind,
					'upgrade_class_class' => $upgrade_class_class,
					'upgrade_class_los' => $upgrade_class_los,
					'add_payment_pct' => $add_payment_pct,
					'birth_weight' => $birth_weight,
					'discharge_status' => $arr_discharge_status[$discharge_status],
					'diagnosa' => $diagnosa,
					'procedure' => $procedure,
					'tarif_rs' => $tarif_rs,
					'tarif_poli_eks' => $tarif_poli_eks,
					'nama_dokter' => $nama_dokter,
					'kode_tarif' => $kode_tarif,
					'payor_id' => $arr_payor_id[$jenis_bayar_id],
					'payor_cd' => $arr_payor_cd[$jenis_bayar_id],
					'cob_cd' => $cob_cd,
					'coder_nik' => $coder_nik);
	$response = @sendData($url,http_build_query($content));
	$json_response = json_decode($response,true);
	$f_status = false;
	if(isset($json_response['metadata']['code'])){
		$ret = $json_response['metadata']['code'];
		if($ret == '200'){
			$f_status = true;
			mysql_query('UPDATE t_cbg_claim SET UPDATE_KLAIM = "1",DIAGNOSA = "' . $diagnosa . '",
						TARIF_RS = "' . $tarif_rs . '",JAMINAN_ID = "' . $jenis_bayar_id . '",
						TANGGAL = STR_TO_DATE("' . $tgl_masuk . '","%Y-%m-%d"),
						KELAS_RAWAT = "' . $kelas_rawat . '",KELAS_RS = "' . $kode_tarif . '",
						USER_CASEMIX = "system"
						WHERE RAWAT_ID = "' . $idx . '" AND JNS_RAWAT = "' . $jenis_rawat . '"') or die(mysql_error());
		}				
	}else{
		$ret = $response; 
	}

	if($f_status == false) saveLog($jenis_rawat . 'U',$nomor_sep . ' - ' . $response);
	
	return $ret;
}

function grouping_klaim($nomor_sep,$idx,$jenis_rawat){
	global $inacbgs_host;
	
	$ret = '';
	
	$url = 'http://' . $inacbgs_host . '/simrs2inacbg/index.php?method=grouper&stage=1&svrmh=0';
	$content = array('nomor_sep' => $nomor_sep);
	$response = @sendData($url,http_build_query($content));
	$json_response = json_decode($response,true);
	$f_status_stage1 = false;
	if(isset($json_response['metadata']['code'])){
		$ret = $json_response['metadata']['code'];
		if($ret == '200'){
			$f_status_stage1 = true;
			$str_response = str_replace('"','&quot;',$response);				
			mysql_query('UPDATE t_cbg_claim SET GROUPER_STAGE_1 = "1",GROUPER_STAGE_1_RESPONSE = "' . $str_response . '",
						USER_CASEMIX = "system"
						WHERE RAWAT_ID = "' . $idx . '" AND JNS_RAWAT = "' . $jenis_rawat . '"') or die(mysql_error());
						
			//** extract grouping stage 1 response **/
			$special_cmg_option = '';
			foreach($json_response as $key => $value){
				if($key != 'metadata'){
					if($key == 'special_cmg_option'){										
						if(is_array($value)){
							foreach($value as $key_l2 => $value_l2){
								if(is_array($value_l2)){
									$cmg = $json_response['special_cmg_option'][$key_l2]['code'];
									if(!empty($cmg)) $special_cmg_option = $special_cmg_option . $json_response['special_cmg_option'][$key_l2]['code'] . '#';			
								}	
							}
						}
					}
				}	
			}

			if(!empty($special_cmg_option)){
				$special_cmg_option = substr($special_cmg_option,0,strlen($special_cmg_option) - 1);
				
				$url = 'http://' . $inacbgs_host . '/simrs2inacbg/index.php?method=grouper&stage=2&svrmh=0';
				$content = array('nomor_sep' => $nomor_sep,
								'special_cmg' => $special_cmg_option);
				$response = @sendData($url,http_build_query($content));
				$json_response = json_decode($response,true);
				$f_status_stage2 = false;
				if(isset($json_response['metadata']['code'])){
					$ret = $json_response['metadata']['code'];
					if($ret == '200'){
						$f_status_stage2 = true;
						$str_response = str_replace('"','&quot;',$response);
						mysql_query('UPDATE t_cbg_claim SET GROUPER_STAGE_2 = "1",GROUPER_STAGE_2_RESPONSE = "' . $str_response . '",
									USER_CASEMIX = "' . currentUser() . '"
									WHERE RAWAT_ID = "' . $idx . '" AND JNS_RAWAT = "' . $jenis_rawat . '"') or die(mysql_error());
					}	
				}else{
					$ret = $response;
				}
				
				if($f_status_stage2 == false) saveLog($jenis_rawat . 'G2',$nomor_sep . ' - ' . $response);
			}	
		}
	}else{
		$ret = $response; 
	}

	if($f_status_stage1 == false) saveLog($jenis_rawat . 'G1',$nomor_sep . ' - ' . $response);
	
	return $ret;
}

function final_klaim($nomor_sep,$idx,$jenis_rawat,$coder_nik){
	global $inacbgs_host;
	
	$ret = '';
	
	$url = 'http://' . $inacbgs_host . '/simrs2inacbg/index.php?method=claim_final&svrmh=0';
	$content = array('nomor_sep' => $nomor_sep,
					'coder_nik' => $coder_nik);
	$response = @sendData($url,http_build_query($content));
	$json_response = json_decode($response,true);
	$f_status = false;
	if(isset($json_response['metadata']['code'])){
		$ret = $json_response['metadata']['code'];
		if($ret == '200'){
			$f_status = true;	
			mysql_query('UPDATE t_cbg_claim SET KLAIM_FINAL = "1",USER_CASEMIX = "system"
					WHERE RAWAT_ID = "' . $idx . '" AND JNS_RAWAT = "' . $jenis_rawat . '"') or die(mysql_error());
		}	
	}

	if($f_status == false) saveLog($jenis_rawat . 'F',$nomor_sep . ' - ' . $response);
	
	return $ret;
}	

function detail_klaim($nomor_sep,$idx,$jenis_rawat){
	global $inacbgs_host;
	
	$ret = '';
	
	$url = 'http://' . $inacbgs_host . '/simrs2inacbg/index.php?method=get_claim_data&svrmh=0';
	$content = array('nomor_sep' => $nomor_sep);
	$response = @sendData($url,http_build_query($content));
	$json_response = json_decode($response,true);
	$f_status = false;
	if(isset($json_response['metadata']['code'])){
		$ret = $json_response['metadata']['code'];
		if($ret == '200'){
			$f_status = true;	
			if(isset($json_response['response']['data']['grouper']['tarif_alt'][0]['tarif_inacbg']))
					$tarif_kelas_1 = $json_response['response']['data']['grouper']['tarif_alt'][0]['tarif_inacbg'];
			if(isset($json_response['response']['data']['grouper']['tarif_alt'][1]['tarif_inacbg']))
					$tarif_kelas_2 = $json_response['response']['data']['grouper']['tarif_alt'][1]['tarif_inacbg'];
			if(isset($json_response['response']['data']['grouper']['tarif_alt'][2]['tarif_inacbg']))
					$tarif_kelas_3 = $json_response['response']['data']['grouper']['tarif_alt'][2]['tarif_inacbg'];
								
			mysql_query('UPDATE t_cbg_claim SET TARIF_CBG_KELAS_1 = "' . $tarif_kelas_1 . '",
						TARIF_CBG_KELAS_2 = "' . $tarif_kelas_2 . '",TARIF_CBG_KELAS_3 = "' . $tarif_kelas_3 . '"
						WHERE RAWAT_ID = "' . $idx . '" AND JNS_RAWAT = "' . $jenis_rawat . '"') or die(mysql_error());
		}	
	}

	if($f_status == false) saveLog($jenis_rawat . 'D',$nomor_sep . ' - ' . $response);
	
	return $ret;
}
?>