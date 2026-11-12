<?php
include('D:/xampp564/htdocs/nsimrs/config/config.php');
include('D:/xampp564/htdocs/nsimrs/shared/connect_db.php');
include('D:/xampp564/htdocs/nsimrs/shared/function.php');

$connect = mysql_connect($hostname_4, $username_4, $password_4) or die(mysql_error());
mysql_select_db($database_4, $connect) or die(mysql_error());

$qry_cek_daftar = 'SELECT DAFTAR_ID,CUSTOMER_ID,MEMBER_ID,NOMR,NAMA_PASIEN,TMP_LAHIR,
		DATE_FORMAT(TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,AGAMA,JNS_KELAMIN,NAMA_IBU,ALAMAT,
		DATE_FORMAT(TGL_RENCANA_KUNJUNGAN,"%d-%m-%Y") AS TGL_RENCANA_KUNJUNGAN,KLINIK_ID,
		MCU_ID,DOKTER_ID,HANYA_AMBIL_RESEP,CARA_BAYAR,METODE_BAYAR,
		DATE_FORMAT(TGL_BAYAR,"%d-%m-%Y %H:%i:%s") AS TGL_BAYAR,NO_CONTACT,
		NO_BPJS,NIK,VIRTUAL_ACCOUNT,USER_VERIF,USER_BAYAR,JAM_LAYANAN
		FROM t_daftar_irja_online
		WHERE STATUS_BAYAR = "1" AND STATUS_VERIF = "1"
		AND TRX_ID IS NULL';
$get_cek_daftar = mysql_query($qry_cek_daftar) or die(mysql_error());

$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
mysql_select_db($database, $connect) or die(mysql_error());

while($dat_cek_daftar = mysql_fetch_array($get_cek_daftar)){
	$daftar_id = $dat_cek_daftar['DAFTAR_ID'];
	$customer_id = $dat_cek_daftar['CUSTOMER_ID'];
	$member_id = $dat_cek_daftar['MEMBER_ID'];
	$nomr = $dat_cek_daftar['NOMR'];
	$nama_pasien = $dat_cek_daftar['NAMA_PASIEN'];
	$tmp_lahir = $dat_cek_daftar['TMP_LAHIR'];
	$tgl_lahir = $dat_cek_daftar['TGL_LAHIR'];
	$agama = $dat_cek_daftar['AGAMA'];
	$jns_kelamin = $dat_cek_daftar['JNS_KELAMIN'];
	$nama_ibu = $dat_cek_daftar['NAMA_IBU'];
	$alamat = $dat_cek_daftar['ALAMAT'];
	$tgl_kunjungan = $dat_cek_daftar['TGL_RENCANA_KUNJUNGAN'];
	$klinik = $dat_cek_daftar['KLINIK_ID'];
	$mcu = $dat_cek_daftar['MCU_ID'];
	$dokter = $dat_cek_daftar['DOKTER_ID'];
	$ambil_resep = $dat_cek_daftar['HANYA_AMBIL_RESEP'];
	$cara_bayar = $dat_cek_daftar['CARA_BAYAR'];
	$metode_bayar = $dat_cek_daftar['METODE_BAYAR'];
	$tgl_bayar = $dat_cek_daftar['TGL_BAYAR'];
	$no_kontak = $dat_cek_daftar['NO_CONTACT'];
	$no_bpjs = $dat_cek_daftar['NO_BPJS'];
	$nik = $dat_cek_daftar['NIK'];
	$virtual_account = $dat_cek_daftar['VIRTUAL_ACCOUNT'];
	$user_verif = $dat_cek_daftar['USER_VERIF'];
	$user_bayar = $dat_cek_daftar['USER_BAYAR'];
	$jam_layanan = $dat_cek_daftar['JAM_LAYANAN'];
	
	$st_baru = '';
	if($nomr != ''){
		mysql_query('UPDATE m_pasien 
				SET NAMA_PASIEN = "' . strtoupper($nama_pasien) . '",
				TMP_LAHIR = "' . $tmp_lahir . '",
				TGL_LAHIR = STR_TO_DATE("' . $tgl_lahir . '","%d-%m-%Y"),
				JNS_KELAMIN = "' . $jns_kelamin . '",
				AGAMA_ID = "' . $agama . '",
				ALAMAT = "' . $alamat . '",
				NO_TELEPON = "' . $no_kontak . '",
				NAMA_IBU = "' . $nama_ibu . '",
				NIK = "' . $nik . '",
				USER_PENDAFTARAN = "' . $user_verif . '"
				WHERE NOMR = "' . $nomr . '"') or die(mysql_error());
	}else{
		$st_baru = '1';
		$khusus = '';
		if($klinik == '35') $khusus = '1';
		
		$nomr = getNoMR();
		mysql_query('INSERT INTO m_pasien (NOMR,NAMA_PASIEN,TMP_LAHIR,TGL_LAHIR,JNS_KELAMIN,AGAMA_ID,
			ALAMAT,NO_TELEPON,NAMA_IBU,NIK,KHUSUS,USER_PENDAFTARAN) 
			VALUES ("' . $nomr . '","' . strtoupper($nama_pasien) . '","' . $tmp_lahir . '",
			STR_TO_DATE("' . $tgl_lahir . '","%d-%m-%Y"),"' . $jns_kelamin . '","' . $agama . '",
			"' . $alamat . '","' . $no_kontak . '","' . $nama_ibu . '","' . $nik . '",
			"' . $khusus . '","' . $user_verif . '")') or die(mysql_error());	
		
	}		
	
	$no_sjp = getNomorHarian('SJP');
	$no_pendaftaran = getNomorBulanan('IRJA');
	
	$qry_kunjungan = 'SELECT COUNT(IRJA_ID) AS CN FROM t_irja 
			WHERE NOMR = "' . $nomr . '"
			AND NO_PENDAFTARAN IS NOT NULL 
			AND ST_BATAL IS NULL
			AND DATE_FORMAT(TANGGAL_DAFTAR,"%m%Y") = DATE_FORMAT(STR_TO_DATE("' . $tgl_kunjungan . '","%d-%m-%Y"),"%m%Y")';
	$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());
	$dat_kunjungan = mysql_fetch_assoc($get_kunjungan);
	$kunj_baru = '1';
	if($dat_kunjungan['CN'] > 0) $kunj_baru = ''; 
	
	$no_bayar = '"' . getNomorHarian('Kasir') . '"';
	$st_bayar = '"Lunas"';
	$nomor = getNomorHarian('Tarif');
	
	mysql_query('INSERT INTO t_irja (NOMR,TANGGAL_DAFTAR,ST_BARU,
		JENIS_BAYAR_ID,NO_PESERTA,UNIT_ID,PEGAWAI_ID,ASAL_PASIEN_ID,KET_ASAL_PASIEN,
		AMBIL_RESEP,NO_SJP,KUNJ_BARU,NO_PENDAFTARAN,USER_PENDAFTARAN,MCU) 
		VALUES("' . $nomr . '",STR_TO_DATE("' . $tgl_kunjungan . '","%d-%m-%Y"),"' . $st_baru . '",
		"' . $cara_bayar . '","' . $no_bpjs . '","' . $klinik . '","' . $dokter . '","1","",
		"' . $ambil_resep . '","' . $no_sjp . '","' . $kunj_baru . '","' . $no_pendaftaran . '",
		"' . $user_verif . '","' . $mcu . '")') or die(mysql_error());
			
	$qry_last_irja = 'SELECT IRJA_ID FROM t_irja 
		WHERE NOMR = "' . $nomr . '"
		ORDER BY IRJA_ID DESC LIMIT 1';	
	$get_last_irja = mysql_query($qry_last_irja) or die(mysql_error());
	$dat_last_irja = mysql_fetch_assoc($get_last_irja);
	$irja_id = $dat_last_irja['IRJA_ID'];
	
	$connect = mysql_connect($hostname_4, $username_4, $password_4) or die(mysql_error());
	mysql_select_db($database_4, $connect) or die(mysql_error());
			
	if($klinik != '61'){	
		
		$qry_tarif = 'SELECT TARIF_ID FROM t_daftar_irja_tarif WHERE DAFTAR_ID = "' . $daftar_id . '"';
		$get_tarif = mysql_query($qry_tarif) or die(mysql_error());
		
		$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
		mysql_select_db($database, $connect) or die(mysql_error());
		
		while($dat_tarif = mysql_fetch_array($get_tarif)){
			mysql_query('INSERT INTO t_irja_tarif(IRJA_ID,TGL_TARIF,TARIF_ID,KUANTITI,
				NO_TARIF,NO_PEMBAYARAN,DESKRIPSI,
				ST_BAYAR,JENIS_BAYAR_ID,USER_KASIR,ST_PRINT,TGL_BAYAR)
				VALUES("' . $irja_id . '",STR_TO_DATE("' . $tgl_kunjungan . ' ' . $jam_layanan . '","%d-%m-%Y %H:%i:%s"),
				"' . $dat_tarif['TARIF_ID'] . '",1,"' . $nomor . '", ' . $no_bayar . ',
				"Karcis & Konsultasi",' . $st_bayar . ',"' . $cara_bayar . '",
				"' . $user_bayar . '",NULL,STR_TO_DATE("' . $tgl_bayar . '","%d-%m-%Y %H:%i:%s"))') or die(mysql_error());	
		}	
			
	}else{
			
			$arr_mcu_s = '0,';
			$qry_tarif = 'SELECT TARIF_ID FROM t_daftar_irja_tarif WHERE DAFTAR_ID = "' . $daftar_id . '"';
			$get_tarif = mysql_query($qry_tarif) or die(mysql_error());
			while($dat_tarif = mysql_fetch_array($get_tarif)){
				$arr_mcu_s .= $dat_tarif['TARIF_ID'] . ',';
			}
			$arr_mcu_s = substr($arr_mcu_s,0,strlen($arr_mcu_s) - 1);
			
			$arr_tindakan = array();
			$arr_laboratorium = array();	
			$arr_radiologi = array();
			$arr_ekgusg = array();	

			$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
			mysql_select_db($database, $connect) or die(mysql_error());	
			
			$get_tarif = mysql_query('SELECT m_tarif.TARIF_ID,m_tarif.KODE_TARIF,m_tarif_group.LABORATORIUM,
				m_tarif_group.LABORATORIUM_CITO,m_tarif_group.RADIOLOGI,m_tarif_group.RADIOLOGI_CITO,
				m_tarif.UNIT_ID,m_tarif.NAMA_TARIF
				FROM m_tarif
				INNER JOIN m_tarif_group 
				ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE m_tarif.TARIF_ID IN (' . $arr_mcu_s . ')') or die(mysql_error());		
			
			while($dat_tarif = mysql_fetch_array($get_tarif)){
				if($dat_tarif['LABORATORIUM'] == '' and $dat_tarif['LABORATORIUM_CITO'] == ''
					and $dat_tarif['RADIOLOGI'] == '' and $dat_tarif['RADIOLOGI_CITO'] == ''
					and ($dat_tarif['UNIT_ID'] == '' or $dat_tarif['UNIT_ID'] == '0')) array_push($arr_tindakan,$dat_tarif['TARIF_ID']);
					
				if($dat_tarif['LABORATORIUM'] == '1' or $dat_tarif['LABORATORIUM_CITO'] == '1' 
					or $dat_tarif['UNIT_ID'] == '45') array_push($arr_laboratorium,$dat_tarif['TARIF_ID']);
				if($dat_tarif['RADIOLOGI'] == '1' or $dat_tarif['RADIOLOGI_CITO'] == '1'
					or $dat_tarif['UNIT_ID'] == '17') array_push($arr_radiologi,$dat_tarif['TARIF_ID']);
				if($dat_tarif['UNIT_ID'] == '52') array_push($arr_ekgusg,$dat_tarif['TARIF_ID']); 	
			}
			
			$nomor_order = getNomorBulanan('IPENUNJANG');
			
			if(sizeof($arr_tindakan) > 0){
				foreach($arr_tindakan as $tarif){
					$kuantiti = '0';
					if($tarif == $mcu) $kuantiti = '1';
					mysql_query('INSERT INTO t_irja_tarif(IRJA_ID,TGL_TARIF,TARIF_ID,KUANTITI,NO_TARIF,NO_PEMBAYARAN,
							DESKRIPSI,ST_BAYAR,JENIS_BAYAR_ID,USER_KASIR,ST_PRINT,TGL_BAYAR)
							VALUES("' . $irja_id . '",STR_TO_DATE("' . $tgl_kunjungan . ' ' . $jam_layanan . '","%d-%m-%Y %H:%i:%s"),
							"' . $tarif . '","' . $kuantiti . '","' . $nomor . '", ' . $no_bayar . ',
							"Paket MCU",' . $st_bayar . ',"' . $cara_bayar . '","' . $user_bayar . '",NULL,
							STR_TO_DATE("' . $tgl_bayar . '","%d-%m-%Y %H:%i:%s"))') or die(mysql_error());	
				}
			}	
			
			if(sizeof($arr_laboratorium) > 0){
				mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID,NO_ORDER,DESKRIPSI,PEGAWAI_ID,
						NOMR,TANGGAL_ORDER,UNIT_ID,JENIS_BAYAR_ID,MCU) VALUES(
						"LAB","IRJ","' . $irja_id . '","' . $nomor_order . '","Paket MCU",
						"' . $dokter . '","' . $nomr . '",STR_TO_DATE("' . $tgl_kunjungan . ' ' . $jam_layanan . '","%d-%m-%Y %H:%i:%s"),
						"61","' . $cara_bayar . '","' . $mcu . '")') or die(mysql_error());
				$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "LAB" 
									AND t_ipenunjang.JNS_ORDER = "IRJ"
									AND t_ipenunjang.RAWAT_ID = "' . $irja_id . '" 
									AND t_ipenunjang.NO_ORDER = "' . $nomor_order . '"
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
				$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
				$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
				$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
								
				foreach($arr_laboratorium as $tarif){
					mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI,ST_PRINT) 
						VALUES("' . $penunjang_id . '","' . $tarif . '",0,NULL)') or die(mysql_error());
				}
				
				mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_DAFTAR = STR_TO_DATE("' . $tgl_kunjungan . ' ' . $jam_layanan . '","%d-%m-%Y %H:%i:%s"),
						UNIT_PENUNJANG_ID = "45",JENIS_BAYAR_ID = "' . $cara_bayar . '",
						ST_BAYAR = ' . $st_bayar . ',NO_TARIF = "' . $nomor . '",NO_SJP = "' . $no_sjp . '",
						NO_PEMBAYARAN = ' . $no_bayar . ',ST_TPP = "1",
						PEGAWAI_PERIKSA_ID = NULL,USER_KASIR = "' . $user_bayar . '",
						TANGGAL_BAYAR = STR_TO_DATE("' . $tgl_bayar . '","%d-%m-%Y %H:%i:%s")
						WHERE PENUNJANG_ID =  "' . $penunjang_id . '"') or die(mysql_error());
									
				//include('lis/simrs2lis.php');
				//lis_create_order($irja_id,$nomor_order,'IRJ');						
			}
			
			if(sizeof($arr_radiologi) > 0){
				mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID,NO_ORDER,DESKRIPSI,PEGAWAI_ID,
						NOMR,TANGGAL_ORDER,UNIT_ID,JENIS_BAYAR_ID,MCU) VALUES(
						"RAD","IRJ","' . $irja_id . '","' . $nomor_order . '","Paket MCU",
						"' . $dokter . '","' . $nomr . '",STR_TO_DATE("' . $tgl_kunjungan . ' ' . $jam_layanan . '","%d-%m-%Y %H:%i:%s"),
						"61","' . $cara_bayar . '","' . $mcu . '")') or die(mysql_error());
				$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
						FROM t_ipenunjang 
						WHERE t_ipenunjang.JNS_PENUNJANG = "RAD" 
						AND t_ipenunjang.JNS_ORDER = "IRJ"
						AND t_ipenunjang.RAWAT_ID = "' . $irja_id . '" 
						AND t_ipenunjang.NO_ORDER = "' . $nomor_order . '"
						ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
				$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
				$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
				$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
								
				foreach($arr_radiologi as $tarif){
					mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI,ST_PRINT) 
						VALUES("' . $penunjang_id . '","' . $tarif . '",0,NULL)') or die(mysql_error());
				}
				mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_DAFTAR = STR_TO_DATE("' . $tgl_kunjungan . ' ' . $jam_layanan . '","%d-%m-%Y %H:%i:%s"),
						UNIT_PENUNJANG_ID = "17",JENIS_BAYAR_ID = "' . $cara_bayar . '",
						ST_BAYAR = ' . $st_bayar . ',NO_TARIF = "' . $nomor . '",NO_SJP = "' . $no_sjp . '",
						NO_PEMBAYARAN = ' . $no_bayar . ',ST_TPP = "1",
						PEGAWAI_PERIKSA_ID = NULL,USER_KASIR = "' . $user_bayar . '",
						TANGGAL_BAYAR = STR_TO_DATE("' . $tgl_bayar . '","%d-%m-%Y %H:%i:%s")
						WHERE PENUNJANG_ID =  "' . $penunjang_id . '"') or die(mysql_error());
			}
			
			if(sizeof($arr_ekgusg) > 0){
				mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID,NO_ORDER,DESKRIPSI,PEGAWAI_ID,
						NOMR,TANGGAL_ORDER,UNIT_ID,JENIS_BAYAR_ID,MCU) VALUES(
						"EKG","IRJ","' . $irja_id . '","' . $nomor_order . '","Paket MCU",
						"' . $dokter . '","' . $nomr . '",STR_TO_DATE("' . $tgl_kunjungan . ' ' . $jam_layanan . '","%d-%m-%Y %H:%i:%s"),
						"61","' . $cara_bayar . '","' . $mcu . '")') or die(mysql_error());
				$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
						FROM t_ipenunjang 
						WHERE t_ipenunjang.JNS_PENUNJANG = "EKG" 
						AND t_ipenunjang.JNS_ORDER = "IRJ"
						AND t_ipenunjang.RAWAT_ID = "' . $irja_id . '" 
						AND t_ipenunjang.NO_ORDER = "' . $nomor_order . '"
						ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
				$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
				$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
				$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
								
				foreach($arr_ekgusg as $tarif){
					mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI,ST_PRINT) 
						VALUES("' . $penunjang_id . '","' . $tarif . '",0,NULL)') or die(mysql_error());
				}
				mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_DAFTAR = STR_TO_DATE("' . $tgl_kunjungan . ' ' . $jam_layanan . '","%d-%m-%Y %H:%i:%s"),
						UNIT_PENUNJANG_ID = "52",JENIS_BAYAR_ID = "' . $cara_bayar . '",
						ST_BAYAR = ' . $st_bayar . ',NO_TARIF = "' . $nomor . '",NO_SJP = "' . $no_sjp . '",
						NO_PEMBAYARAN = ' . $no_bayar . ',ST_TPP = "1",
						PEGAWAI_PERIKSA_ID = NULL,USER_KASIR = "' . $user_bayar . '",
						TANGGAL_BAYAR = STR_TO_DATE("' . $tgl_bayar . '","%d-%m-%Y %H:%i:%s")
						WHERE PENUNJANG_ID =  "' . $penunjang_id . '"') or die(mysql_error());
			}
		
	}	

	$connect = mysql_connect($hostname_4, $username_4, $password_4) or die(mysql_error());
	mysql_select_db($database_4, $connect) or die(mysql_error());
		
	mysql_query('UPDATE t_daftar_irja_online SET TRX_ID = "' . $irja_id . '",
		NOMR = "' . $nomr . '"
		WHERE DAFTAR_ID = "' . $daftar_id . '"') or die(mysql_error());	
					
}	
?>