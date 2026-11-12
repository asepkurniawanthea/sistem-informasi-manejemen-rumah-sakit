<?php

function formatNoMR($nomr) {
    $str1 = substr($nomr, 0, 2);
    $str2 = substr($nomr, 2, 2);
    $str3 = substr($nomr, 4, 2);
    return $str1 . '.' . $str2 . '.' . $str3;
}

function getNoMR($khusus = '0') {
	$last_nomr = '';
	$sql = 'SELECT MAX(CONVERT(NOMR, SIGNED)) + 1 AS LAST_NOMR FROM m_pasien WHERE CONVERT(NOMR, SIGNED) < 600000';
	$get = mysql_query($sql) or die(mysql_error());
	$dat = mysql_fetch_assoc($get);
	if($dat['LAST_NOMR'] < 600000){
		$last_nomr = $dat['LAST_NOMR'];
	}else{
		$sql2 = 'SELECT MAX(CONVERT(NOMR, SIGNED)) + 1 AS LAST_NOMR FROM m_pasien WHERE CONVERT(NOMR, SIGNED) > 599999';
		$get2 = mysql_query($sql2) or die(mysql_error());
		$dat2 = mysql_fetch_assoc($get2);
		$last_nomr = $dat2['LAST_NOMR'];
	}
	$nomr = substr('000000', 0, 6 - strlen($last_nomr)) . $last_nomr;
    return $nomr;
}

function getNoPasienPenunjang() {
	$last_nomor = 0;
	$sql = 'SELECT m_app_max_nomor.MAX_NOMOR
			FROM m_app_max_nomor
			WHERE m_app_max_nomor.SURAT = "ID Penunjang"';
	$get = mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($get) > 0){
		$dat = mysql_fetch_assoc($get);
		$last_nomor = $dat['MAX_NOMOR'] + 1;
		mysql_query('UPDATE m_app_max_nomor SET MAX_NOMOR = ' . $last_nomor . ' WHERE SURAT = "ID Penunjang"') or die(mysql_error());
	}else{
		mysql_query('INSERT INTO m_app_max_nomor(MAX_NOMOR,SURAT)
				VALUES(1,"ID Penunjang")') or die(mysql_error());
		$last_nomor = 1;			
	}
	$no_penunjang = date('Y') . substr('0000', 0, 4 - strlen($last_nomor)) . $last_nomor;
    return $no_penunjang;
}

function getNomorBulanan($surat) {
    $sql = 'SELECT MAX_NOMOR,TAHUN,BULAN,DATE_FORMAT(NOW(), "%d") AS HARI FROM m_app_max_nomor WHERE TAHUN = DATE_FORMAT(NOW(), "%Y") AND BULAN = DATE_FORMAT(NOW(), "%m") AND SURAT = "' . $surat . '"';
    $rsl = mysql_query($sql);
    $nosurat = '';
    if (mysql_num_rows($rsl) > 0) {
        $dat = mysql_fetch_assoc($rsl);
        mysql_query('UPDATE m_app_max_nomor SET MAX_NOMOR = MAX_NOMOR + 1 WHERE TAHUN = DATE_FORMAT(NOW(), "%Y") AND BULAN = DATE_FORMAT(NOW(), "%m") AND SURAT = "' . $surat . '"') or die(mysql_error());
        $no = $dat['MAX_NOMOR'] + 1;
        $tgl = substr($dat['TAHUN'], 2, 2) . $dat['BULAN'] . $dat['HARI'];
        $nosurat = $tgl . substr('00000', 1, 5 - strlen($no)) . $no;
    } else {
        $sql = 'SELECT DATE_FORMAT(NOW(), "%Y") AS TAHUN, DATE_FORMAT(NOW(), "%m") AS BULAN, DATE_FORMAT(NOW(), "%d") AS HARI FROM DUAL';
        $rsl = mysql_query($sql);
        $dat = mysql_fetch_assoc($rsl);
        mysql_query('INSERT INTO m_app_max_nomor VALUES(1,DATE_FORMAT(NOW(), "%Y"),DATE_FORMAT(NOW(), "%m"),"-" ,"' . $surat . '")');
        $nosurat = substr($dat['TAHUN'], 2, 2) . $dat['BULAN'] . $dat['HARI'] . '00001';
    }
    return $nosurat;
}

function getNomorHarian($surat) {
    $sql = 'SELECT MAX_NOMOR,TAHUN,BULAN,HARI FROM m_app_max_nomor WHERE TAHUN = DATE_FORMAT(NOW(), "%Y") AND BULAN = DATE_FORMAT(NOW(), "%m") AND HARI = DATE_FORMAT(NOW(), "%d") AND SURAT = "' . $surat . '"';
    $rsl = mysql_query($sql);
    $nosurat = '';
    if (mysql_num_rows($rsl) > 0) {
        $dat = mysql_fetch_assoc($rsl);
        mysql_query('UPDATE m_app_max_nomor SET MAX_NOMOR = MAX_NOMOR + 1 WHERE TAHUN = DATE_FORMAT(NOW(), "%Y") AND BULAN = DATE_FORMAT(NOW(), "%m") AND HARI = DATE_FORMAT(NOW(), "%d") AND SURAT = "' . $surat . '"') or die(mysql_error());
        $no = $dat['MAX_NOMOR'] + 1;
        $tgl = substr($dat['TAHUN'], 2, 2) . $dat['BULAN'] . $dat['HARI'];
        $nosurat = $tgl . substr('0000', 1, 4 - strlen($no)) . $no;
    } else {
        $sql = 'SELECT DATE_FORMAT(NOW(), "%Y") AS TAHUN, DATE_FORMAT(NOW(), "%m") AS BULAN, DATE_FORMAT(NOW(), "%d") AS HARI FROM DUAL';
        $rsl = mysql_query($sql);
        $dat = mysql_fetch_assoc($rsl);
        mysql_query('INSERT INTO m_app_max_nomor VALUES(1,DATE_FORMAT(NOW(), "%Y"),DATE_FORMAT(NOW(), "%m"),DATE_FORMAT(NOW(), "%d"), "' . $surat . '")');
        $nosurat = substr($dat['TAHUN'], 2, 2) . $dat['BULAN'] . $dat['HARI'] . '0001';
    }
    return $nosurat;
}

function getTarifGroup($tr) {
    $sql = 'SELECT KODE_TARIF_GROUP FROM m_tarif WHERE KODE_TARIF = "' . $tr . '"';
    $rsl = mysql_query($sql);
    $ret = mysql_fetch_assoc($rsl);

    return $ret['KODE_TARIF_GROUP'];
}

function getShift() {
    $sql = 'SELECT SHIFT_ID,SHIFT FROM m_app_shift
            WHERE (TIME_TO_SEC(START_TIME) / 60) <=  (TIME_TO_SEC(NOW())/60) 
            AND (TIME_TO_SEC(END_TIME) / 60) >=  (TIME_TO_SEC(NOW())/60)';
    $rsl = mysql_query($sql);
    $dat = mysql_fetch_assoc($rsl);
    $ret = $dat['SHIFT'];
    return $ret;
}

function getNow() {
    $sql = 'SELECT NOW() AS TANGGAL FROM DUAL';
    $rsl = mysql_query($sql);
    $dat = mysql_fetch_assoc($rsl);
    return $dat['TANGGAL'];
}

function getDateSkr() {
    $sql = 'SELECT DATE_FORMAT(NOW(), "%d/%m/%Y") AS TANGGAL FROM DUAL';
    $rsl = mysql_query($sql);
    $dat = mysql_fetch_assoc($rsl);
    return $dat['TANGGAL'];
}

function getDatetimeSkr() {
    $sql = 'SELECT DATE_FORMAT(NOW(), "%d/%m/%Y %H:%i:%s") AS TANGGAL FROM DUAL';
    $rsl = mysql_query($sql);
    $dat = mysql_fetch_assoc($rsl);
    return $dat['TANGGAL'];
}

function fieldDatetime($x) {
    if (!empty($x)) {
        $x = str_replace('-', '/', $x);
        $ret = 'STR_TO_DATE("' . $x . '", "%d/%m/%Y %H:%i:%s")';
    } else {
        $ret = 'NULL';
    }
    return $ret;
}

function fieldDate($x) {
    if (!empty($x)) {
        $x = str_replace('-', '/', $x);
        $ret = 'STR_TO_DATE("' . $x . '", "%d/%m/%Y")';
    } else {
        $ret = 'NULL';
    }
    return $ret;
}

function changeDateFormat($originalDate) {
    $x = '';
    if (!empty($originalDate)) {
        $date = new DateTime($originalDate);
        $x = $date->format('d/m/Y');
    }
    return $x;
}

function setTerbilang($x) {
    $abil = array('', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas');
    if ($x < 12)
        return ' ' . $abil[$x];
    elseif ($x < 20)
        return Terbilang($x - 10) . 'belas';
    elseif ($x < 100)
        return Terbilang($x / 10) . ' puluh' . Terbilang($x % 10);
    elseif ($x < 200)
        return ' seratus' . Terbilang($x - 100);
    elseif ($x < 1000)
        return Terbilang($x / 100) . ' ratus' . Terbilang($x % 100);
    elseif ($x < 2000)
        return ' seribu' . Terbilang($x - 1000);
    elseif ($x < 1000000)
        return Terbilang($x / 1000) . ' ribu' . Terbilang($x % 1000);
    elseif ($x < 1000000000)
        return Terbilang($x / 1000000) . ' juta' . Terbilang($x % 1000000);
}

function dateDiff($d1, $d2) {
    $diff = abs(strtotime($d2) - strtotime($d1));
    $a = array();
    $a['years'] = floor($diff / (365 * 60 * 60 * 24));
    $a['months'] = floor(($diff - $a['years'] * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
    $a['days'] = floor(($diff - $a['years'] * 365 * 60 * 60 * 24 - $a['months'] * 30 * 60 * 60 * 24) / (60 * 60 * 24));
    return $a;
}

function getUmur($d1) {
    $x = '';
    if (!empty($d1)) {
        $date = str_replace('-', '/', $d1);
        $dateFormated = explode('/', $date);
        if(count($dateFormated) == 3){
			$date = $dateFormated[2] . '/' . $dateFormated[1] . '/' . $dateFormated[0];
			$cek_date = @mysql_query('SELECT DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(STR_TO_DATE("' . $date . '","%Y/%m/%d"))), "%Y/%m/%d") AS UMUR');
			if($cek_date == false){
				$x = 'Tanggal Lahir Tidak Valid.';
			}else{
				$dat_date = mysql_fetch_assoc($cek_date);
				if(empty($dat_date['UMUR'])){
					$x = 'Tanggal Lahir Tidak Valid.';
				}else{
					$array_date_date = explode('/', $dat_date['UMUR']);
					$tahun = $array_date_date[0] + 0;
					$bulan = $array_date_date[1] + 0;
					$hari = $array_date_date[2] + 0;
					
					if($tahun == 0 && $bulan == 0 && $hari == 0){
						$date_lahir = date($date);
						$umur = dateDiff($date_lahir, getNow());
						$tahun = $umur['years'];
						$bulan = $umur['months'];
						$hari = $umur['days'];
					}
				
					$x = $tahun . ' tahun ' . $bulan . ' bulan ' . $hari . ' hari';
				}
			}	
		}else{
			$x = 'Tanggal Lahir Tidak Valid.';
		}	
    }else{
		$x = 'Tanggal Lahir Tidak Valid.';
	}
    return $x;
}

function getUmurDaftar($d1,$d2) {
    $x = '';
    if (!empty($d1) and !empty($d2)) {
        $date = str_replace('-', '/', $d1);
        $dateFormated = explode('/', $date);
		
		$date2 = str_replace('-', '/', $d2);
        $dateFormated2 = explode('/', $date2);
        if(count($dateFormated) == 3){
			$date = $dateFormated[2] . '/' . $dateFormated[1] . '/' . $dateFormated[0];
			$date2 = $dateFormated2[2] . '/' . $dateFormated2[1] . '/' . $dateFormated2[0];
			$cek_date = @mysql_query('SELECT DATE_FORMAT(FROM_DAYS(TO_DAYS(STR_TO_DATE("' . $date2 . '","%Y/%m/%d"))-TO_DAYS(STR_TO_DATE("' . $date . '","%Y/%m/%d"))), "%Y/%m/%d") AS UMUR');
			if($cek_date == false){
				$x = 'Tanggal Lahir Tidak Valid.';
			}else{
				$dat_date = mysql_fetch_assoc($cek_date);
				if(empty($dat_date['UMUR'])){
					$x = 'Tanggal Lahir Tidak Valid.';
				}else{
					$array_date_date = explode('/', $dat_date['UMUR']);
					$tahun = $array_date_date[0] + 0;
					$bulan = $array_date_date[1] + 0;
					$hari = $array_date_date[2] + 0;
					
					if($tahun == 0 && $bulan == 0 && $hari == 0){
						$date_lahir = date($date);
						$umur = dateDiff($date_lahir, getNow());
						$tahun = $umur['years'];
						$bulan = $umur['months'];
						$hari = $umur['days'];
					}
				
					$x = $tahun . ' tahun ' . $bulan . ' bulan ' . $hari . ' hari';
				}
			}	
		}else{
			$x = 'Tanggal Lahir Tidak Valid.';
		}	
    }else{
		$x = 'Tanggal Lahir Tidak Valid.';
	}
    return $x;
}

function currFormat($value, $dec = 0) {
    $res = '0';
    if ($value > 0)
        $res = number_format($value, $dec, ',', '.');
	 if ($value < 0)
        $res = number_format($value, $dec, ',', '.');	
    return $res;
}

function getIpAddress() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP']; // share internet
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR']; // pass from proxy
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function jenisKelamin($P) {
    $v = '';
    if (strtoupper($P) == 'P') {
        $v = 'Perempuan';
    } else if (strtoupper($P) == 'L') {
        $v = 'Laki - Laki';
    }
    return $v;
}

function statusKawin($P) {
    $v = '';
    if ($P == '1') {
        $v = 'Belum Kawin';
    } else if ($P == '2') {
        $v = 'Kawin';
    } else if ($P == '3') {
        $v = 'Janda/ Duda';
    }
    return $v;
}

function jenPendidikan($P) {
    $v = '';
    if ($P == '1') {
        $v = 'SD';
    } else if ($P == '2') {
        $v = 'SLTP';
    } else if ($P == '3') {
        $v = 'SLTA';
    } else if ($P == '4') {
        $v = 'Akademik';
    } else if ($P == '5') {
        $v = 'Universitas';
    }
    return $v;
}

function writeNum($input, $printer, $ypos, $xpos, $dv) {
    $s = strlen($input);
    $y = $xpos;
    for ($i = 1; $i < $s + 1; $i++) {
        $u = $i * -1;
        printer_draw_text($printer, substr($input, $u, 1), $y, $ypos);
        $y = $y - $dv;
    }
}

function currentURL() {
    global $site;
    $url = str_replace('/' . $site . '/', '', $_SERVER['REQUEST_URI']);
    return $url;
}

function currentModul() {
    $modul = strtolower($_SESSION['SES_SIMRS_NAMA_MODUL']);
    return $modul;
}

function currentUser() {
    $sql = 'SELECT DATE_FORMAT(NOW(), "%y%m%d%H%i") AS TANGGAL FROM DUAL';
    $rsl = mysql_query($sql);
    $dat = mysql_fetch_assoc($rsl);
    $user = $dat['TANGGAL'] . '|' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'];
    return $user;
}

function cekDokterJadwal($unit_id,$pegawai_id,$hari_id){
	$ret = 0;
	$sql = 'SELECT t_dokter_jaga_jadwal.JADWAL_ID
		FROM t_dokter_jaga_jadwal
		WHERE UNIT_ID = "' . $unit_id . '" AND PEGAWAI_ID = "' . $pegawai_id . '" AND HARI_ID = "' . $hari_id . '"';
	$get = mysql_query($sql) or die(mysql_error());
	$ret = mysql_num_rows($get);
return $ret;		
}

function cekDokterJadwalBuka($unit_id,$pegawai_id,$hari_id){
	$ret = 0;
	$sql = 'SELECT t_dokter_jaga_jadwal.JAM_MULAI_PRAKTEK
		FROM t_dokter_jaga_jadwal
		WHERE UNIT_ID = "' . $unit_id . '" AND PEGAWAI_ID = "' . $pegawai_id . '" AND HARI_ID = "' . $hari_id . '"';
	$get = mysql_query($sql) or die(mysql_error());
	$dat = mysql_fetch_assoc($get);
return $dat['JAM_MULAI_PRAKTEK'];		
}

function cekDokterJadwalTutup($unit_id,$pegawai_id,$hari_id){
	$ret = 0;
	$sql = 'SELECT t_dokter_jaga_jadwal.JAM_SELESAI_PRAKTEK
		FROM t_dokter_jaga_jadwal
		WHERE UNIT_ID = "' . $unit_id . '" AND PEGAWAI_ID = "' . $pegawai_id . '" AND HARI_ID = "' . $hari_id . '"';
	$get = mysql_query($sql) or die(mysql_error());
	$dat = mysql_fetch_assoc($get);
return $dat['JAM_SELESAI_PRAKTEK'];		
}

function cekDokterJadwalKuota($unit_id,$pegawai_id,$hari_id){
	$ret = 0;
	$sql = 'SELECT t_dokter_jaga_jadwal.KUOTA
		FROM t_dokter_jaga_jadwal
		WHERE UNIT_ID = "' . $unit_id . '" AND PEGAWAI_ID = "' . $pegawai_id . '" AND HARI_ID = "' . $hari_id . '"';
	$get = mysql_query($sql) or die(mysql_error());
	$dat = mysql_fetch_assoc($get);
return $dat['KUOTA'];		
}

function cekCurrentDay(){
	$ret = '';
	$sql = 'SELECT DATE_FORMAT(NOW(),"%w") AS HARI_INI';
	$get = mysql_query($sql) or die(mysql_error());
	$dat = mysql_fetch_assoc($get);
	$ret = $dat['HARI_INI'];
return $ret;		
}

function getSatuanLaboratorium($group,$periksa){
	$ret = '';
	if(!isset($_SESSION['SES_SIMRS_LABORATORIUM_NILAI_RUJUKAN']) 
			or $_SESSION['SES_SIMRS_LABORATORIUM_NILAI_RUJUKAN'] == ''){
		$return_arr = array();
		$sql = 'SELECT DISTINCT CH_REPORT,NAMA_PEMERIKSAAN,
			SATUAN,METHODE
			FROM m_nilai_rujukan_laboratorium
			WHERE 1
			ORDER BY CH_REPORT,NAMA_PEMERIKSAAN';
		$get = mysql_query($sql) or die(mysql_error());
		while($dat = mysql_fetch_array($get)){
			$row_array['CH_REPORT'] = $dat['CH_REPORT'];
			$row_array['NAMA_PEMERIKSAAN'] = $dat['NAMA_PEMERIKSAAN'];
			$row_array['SATUAN'] = $dat['SATUAN'];
			$row_array['METHODE'] = $dat['METHODE'];
			array_push($return_arr,$row_array);
		}
		$_SESSION['SES_SIMRS_LABORATORIUM_NILAI_RUJUKAN'] = json_encode($return_arr);	
	}
	
	$arr_nilai = json_decode($_SESSION['SES_SIMRS_LABORATORIUM_NILAI_RUJUKAN'],true);
	foreach($arr_nilai as $row){
		if($row['CH_REPORT'] == $group and $row['NAMA_PEMERIKSAAN'] == $periksa){
			$ret = $row['SATUAN'];
			break;
		}
	}	
	
	return $ret;
}

function getMethodeLaboratorium($group,$periksa){
	$ret = '';
	if(!isset($_SESSION['SES_SIMRS_LABORATORIUM_NILAI_RUJUKAN']) 
			or $_SESSION['SES_SIMRS_LABORATORIUM_NILAI_RUJUKAN'] == ''){
		$return_arr = array();
		$sql = 'SELECT DISTINCT CH_REPORT,NAMA_PEMERIKSAAN,
			SATUAN,METHODE
			FROM m_nilai_rujukan_laboratorium
			WHERE 1
			ORDER BY CH_REPORT,NAMA_PEMERIKSAAN';
		$get = mysql_query($sql) or die(mysql_error());
		while($dat = mysql_fetch_array($get)){
			$row_array['CH_REPORT'] = $dat['CH_REPORT'];
			$row_array['NAMA_PEMERIKSAAN'] = $dat['NAMA_PEMERIKSAAN'];
			$row_array['SATUAN'] = $dat['SATUAN'];
			$row_array['METHODE'] = $dat['METHODE'];
			array_push($return_arr,$row_array);
		}
		$_SESSION['SES_SIMRS_LABORATORIUM_NILAI_RUJUKAN'] = json_encode($return_arr);	
	}
	
	$arr_nilai = json_decode($_SESSION['SES_SIMRS_LABORATORIUM_NILAI_RUJUKAN'],true);
	foreach($arr_nilai as $row){
		if($row['CH_REPORT'] == $group and $row['NAMA_PEMERIKSAAN'] == $periksa){
			$ret = $row['METHODE'];
			break;
		}
	}	
	
	return $ret;
}

function getNilaiKritisLaboratorium($group,$periksa){
	$ret = '';
	if(!isset($_SESSION['SES_SIMRS_LABORATORIUM_NILAI_KRITIS']) 
			or $_SESSION['SES_SIMRS_LABORATORIUM_NILAI_KRITIS'] == ''){
		$return_arr = array();
		$sql = 'SELECT DISTINCT CH_REPORT,NAMA_PEMERIKSAAN,
				NILAI_KRITIS_MULAI,NILAI_KRITIS_SAMPAI
			FROM m_nilai_kritis_laboratorium
			WHERE 1
			ORDER BY CH_REPORT,NAMA_PEMERIKSAAN';
		$get = mysql_query($sql) or die(mysql_error());
		while($dat = mysql_fetch_array($get)){
			$row_array['CH_REPORT'] = $dat['CH_REPORT'];
			$row_array['NAMA_PEMERIKSAAN'] = $dat['NAMA_PEMERIKSAAN'];
			$row_array['NILAI_KRITIS_MULAI'] = $dat['NILAI_KRITIS_MULAI'];
			$row_array['NILAI_KRITIS_SAMPAI'] = $dat['NILAI_KRITIS_SAMPAI'];
			array_push($return_arr,$row_array);
		}
		$_SESSION['SES_SIMRS_LABORATORIUM_NILAI_KRITIS'] = json_encode($return_arr);	
	}
	
	$arr_nilai = json_decode($_SESSION['SES_SIMRS_LABORATORIUM_NILAI_KRITIS'],true);
	foreach($arr_nilai as $row){
		if($row['CH_REPORT'] == $group and $row['NAMA_PEMERIKSAAN'] == $periksa){
			$ret = $row['NILAI_KRITIS_MULAI'] . '-' . $row['NILAI_KRITIS_SAMPAI'];
			break;
		}
	}	
	
	return $ret;
}

function getNomorPhoto($nomr) {
    $sql = 'SELECT MAX_NOMOR FROM m_app_max_nomor_photo WHERE NOMR = "' . $nomr . '"';
    $rsl = mysql_query($sql);
    $nosurat = '';
    if (mysql_num_rows($rsl) > 0) {
        $dat = mysql_fetch_assoc($rsl);
        mysql_query('UPDATE m_app_max_nomor_photo SET MAX_NOMOR = MAX_NOMOR + 1 WHERE NOMR = "' . $nomr . '"') or die(mysql_error());
        $no = $dat['MAX_NOMOR'] + 1;
        $nosurat = substr('000', 1, 3 - strlen($no)) . $no;
    } else {
        mysql_query('INSERT INTO m_app_max_nomor_photo VALUES("' . $nomr . '",1)');
        $nosurat = '001';
    }
    return $nosurat;
}

function cekValidDate($tanggal){
	$ret = false;
	
	$tanggal = str_replace('-','/',$tanggal);
	$tanggal_array = explode('/',$tanggal);
	
	if(count($tanggal_array) >= 3){
		$hr = $tanggal_array[0];
		$bl = $tanggal_array[1];
		$th = $tanggal_array[2];
		
		$hr = $hr + 0;
		$bl = $bl + 0;
		$th = $th + 0;
		
		$ret = checkdate($bl, $hr, $th);
	}
	
	return $ret;
}

function getInisial($str) {
    $ret = '';
    foreach (explode(' ', $str) as $word)
        $ret .= strtoupper($word[0]);
    return $ret;
}

function setIfNull($str){
	$ret = '-';
	if(!empty($str)) $ret = $str;
	
	return $ret;
}

function isDokter($tipe_pegawai){
	$ret = false;
	if(in_array($tipe_pegawai,array('1','2','3','18'))) $ret = true;
	return $ret;	
}

function isPerawat($tipe_pegawai){
	$ret = false;
	if(in_array($tipe_pegawai,array('4','5','6','9','16'))) $ret = true;
	return $ret;	
}

?>