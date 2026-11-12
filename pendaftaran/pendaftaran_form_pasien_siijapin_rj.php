<?php if(isset($_GET['id'])){ 
$id = $_GET['id'];
$jam = date('H:i:s');

$arr_unit = array();
$arr_unit[0] = '-';
$get_unit = mysql_query('SELECT * FROM m_unit WHERE IRJA IN ("umum","kusta") ORDER BY NAMA_UNIT') or die(mysql_error());
while($dat_unit = mysql_fetch_array($get_unit)){
		$arr_unit[$dat_unit['UNIT_ID']] = $dat_unit['NAMA_UNIT'];
}

$arr_jaminan = array();
$arr_jaminan[0] = '-';
$get_jaminan = mysql_query('SELECT * FROM m_jaminan ORDER BY NAMA_JAMINAN') or die(mysql_error());
while($dat_jaminan = mysql_fetch_array($get_jaminan)){
		$arr_jaminan[$dat_jaminan['JAMINAN_ID']] = $dat_jaminan['NAMA_JAMINAN'];
}

$arr_dokter = array();
$get_dokter = mysql_query('SELECT * FROM m_pegawai WHERE TIPE_PEGAWAI_ID IN (1,2,3,4,18) ORDER BY NAMA_PEGAWAI') or die(mysql_error());
$arr_dokter[0] = '-';
while($dat_dokter = mysql_fetch_array($get_dokter)){
		$arr_dokter[$dat_dokter['PEGAWAI_ID']] = $dat_dokter['NAMA_PEGAWAI'];
}

$connect = mysql_connect($hostname_8, $username_8, $password_8) or die(mysql_error());
mysql_select_db($database_8, $connect) or die(mysql_error());	

if(isset($_POST['simpan']) and isset($_POST['verif'])){
	if($_POST['rd_nomr'] == '2' and $_POST['nomr'] == ''){ ?>
		<script language="JavaScript" >
		alert('Bukan Pasien Baru. No MR Belum Diisi.');
		</script>
	<?php 
	}else{
		$khusus = '';
		if($_POST['klinik'] == '35') $khusus = '1';
			
		$st_baru = '';	
		$nomr = $_POST['nomr'];
		if($_POST['rd_nomr'] == '3'){
			$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
			mysql_select_db($database, $connect) or die(mysql_error());	
			$nomr = getNoMR($khusus);
			$st_baru = '1';
			$connect = mysql_connect($hostname_8, $username_8, $password_8) or die(mysql_error());
			mysql_select_db($database_8, $connect) or die(mysql_error());	
		}
		
		if(currentModul() == 'pendaftaran' or currentModul() == 'ipapp'){
			
			mysql_query('UPDATE m_customer_member
					SET NOMR = "' . $nomr . '",
					NAMA_PASIEN = "' . $_POST['nama_pasien'] . '",
					TMP_LAHIR = "' . $_POST['tmp_lahir'] . '",
					TGL_LAHIR = STR_TO_DATE("' . $_POST['tgl_lahir'] . '","%d-%m-%Y"),
					AGAMA = "' . $_POST['agama'] . '",
					JNS_KELAMIN = "' . $_POST['jns_kelamin'] . '",
					NAMA_IBU = "' . $_POST['nama_ibu'] . '",
					ALAMAT = "' . $_POST['alamat'] . '",
					NIK = "' . $_POST['nik'] . '",
					PEKERJAAN = "' . $_POST['pekerjaan'] . '",
					RD_NOMR = "1"
					WHERE MEMBER_ID = "' . $_POST['id_member'] . '"') or die(mysql_error());			
					
			if($_POST['cara_bayar'] != '1'){
				mysql_query('UPDATE t_daftar_rj
					SET TGL_RENCANA_KUNJUNGAN = STR_TO_DATE("' . str_replace('/','-',$_POST['tgl_minta']) . '","%d-%m-%Y"),
					UNIT = "' . $_POST['klinik'] . '",
					DOKTER = "' . $_POST['dokter'] . '",
					AMBIL_RESEP = "' . ((isset($_POST['ambil_resep'])) ? '1':'') . '",
					USER_VERIFIKASI = "' . $user_name . '",
					TGL_PRINT = NOW()
					WHERE DAFTAR_ID = "' . $_POST['id_daftar'] . '"') or die(mysql_error());
			}else{
				if($_POST['status_bayar'] == ''){
					mysql_query('UPDATE t_daftar_rj
						SET TGL_RENCANA_KUNJUNGAN = STR_TO_DATE("' . str_replace('/','-',$_POST['tgl_minta']) . '","%d-%m-%Y"),
						UNIT = "' . $_POST['klinik'] . '",
						DOKTER = "' . $_POST['dokter'] . '",
						AMBIL_RESEP = "' . ((isset($_POST['ambil_resep'])) ? '1':'') . '",
						USER_VERIFIKASI = "' . $user_name . '",
						TGL_PRINT = NOW()
						WHERE DAFTAR_ID = "' . $_POST['id_daftar'] . '"') or die(mysql_error());
				}	
			}
			
			if($_POST['cara_bayar'] != '1'){
				//daftar simrs
				$qry_daftar_n = 'SELECT d.DAFTAR_ID,d.CUSTOMER_ID,d.MEMBER_ID,
					m.NOMR,m.NAMA_PASIEN,m.TMP_LAHIR,
					DATE_FORMAT(m.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,
					m.AGAMA,m.JNS_KELAMIN,m.NAMA_IBU,m.ALAMAT,m.RD_NOMR,
					m.NO_CONTACT,m.EMAIL,m.NIK,
					DATE_FORMAT(d.TGL_RENCANA_KUNJUNGAN,"%d-%m-%Y") AS TGL_RENCANA_KUNJUNGAN,
					d.UNIT AS KLINIK_ID,d.DOKTER AS DOKTER_ID,
					d.PEMBAYARAN AS CARA_BAYAR,d.JAM_LAYANAN,d.NO_ANTRIAN,d.ST_BAYAR,
					DATE_FORMAT(d.TGL_DAFTAR,"%d-%m-%Y") AS TGL_DAFTAR,
					d.USER_VERIFIKASI,d.FOTO_RUJUKAN,
					m.NO_PESERTA,m.FOTO_NIK,m.FOTO_KK,m.FOTO_PESERTA,
					m.PEKERJAAN,d.AMBIL_RESEP,d.JUMLAH_BAYAR,d.IRJA_ID
					FROM t_daftar_rj d
					INNER JOIN m_customer c
					ON (d.CUSTOMER_ID = c.CUSTOMER_ID)
					INNER JOIN m_customer_member m
					ON (d.MEMBER_ID = m.MEMBER_ID)
					WHERE d.DAFTAR_ID = "' . $_POST['id_daftar'] . '"';
				$get_daftar_n = mysql_query($qry_daftar_n) or die(mysql_error());
				$dat_daftar_n = mysql_fetch_assoc($get_daftar_n);
				
				$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
				mysql_select_db($database, $connect) or die(mysql_error());	
				
				$qry_cek_pasien = 'SELECT PASIEN_ID FROM m_pasien WHERE NOMR = "' . $dat_daftar_n['NOMR'] . '"';
				$get_cek_pasien = mysql_query($qry_cek_pasien) or die(mysql_error());
				if(mysql_num_rows($get_cek_pasien) == 0){
					mysql_query('INSERT INTO m_pasien (NOMR,NAMA_PASIEN,TMP_LAHIR,TGL_LAHIR,JNS_KELAMIN,
						AGAMA_ID,PEKERJAAN,ALAMAT,NO_TELEPON,NAMA_IBU,NIK,KHUSUS,USER_PENDAFTARAN) 
						VALUES ("' . $dat_daftar_n['NOMR'] . '","' . strtoupper($dat_daftar_n['NAMA_PASIEN']) . '",
						"' . $dat_daftar_n['TMP_LAHIR'] . '",STR_TO_DATE("' . $dat_daftar_n['TGL_LAHIR'] . '","%d-%m-%Y"),
						"' . $dat_daftar_n['JNS_KELAMIN'] . '","' . $dat_daftar_n['AGAMA'] . '",
						"' . $dat_daftar_n['PEKERJAAN'] . '","' . $dat_daftar_n['ALAMAT'] . '",
						"' . $dat_daftar_n['NO_CONTACT'] . '","' . $dat_daftar_n['NAMA_IBU'] . '",
						"' . $dat_daftar_n['NIK'] . '","' . $khusus . '","' . $user_name . '")') or die(mysql_error());	
				}else{	
					mysql_query('UPDATE m_pasien SET NAMA_PASIEN = "' . strtoupper($dat_daftar_n['NAMA_PASIEN']) . '",
						TMP_LAHIR = "' . $dat_daftar_n['TMP_LAHIR'] . '",TGL_LAHIR = STR_TO_DATE("' . $dat_daftar_n['TGL_LAHIR'] . '","%d-%m-%Y"),
						JNS_KELAMIN = "' . $dat_daftar_n['JNS_KELAMIN'] . '",AGAMA_ID = "' . $dat_daftar_n['AGAMA'] . '",
						PEKERJAAN = "' . $dat_daftar_n['PEKERJAAN'] . '",ALAMAT = "' . $dat_daftar_n['ALAMAT'] . '",
						NO_TELEPON = "' . $dat_daftar_n['NO_CONTACT'] . '",NAMA_IBU = "' . $dat_daftar_n['NAMA_IBU'] . '",
						NIK = "' . $dat_daftar_n['NIK'] . '",
						KHUSUS = "' . $khusus . '", USER_PENDAFTARAN = "' . $user_name . '"
						WHERE NOMR = "' . $dat_daftar_n['NOMR'] . '"') or die(mysql_error());
				}
				
				$no_peserta_jkn = '';
				if($dat_daftar_n['CARA_BAYAR'] == '12') $no_peserta_jkn = $dat_daftar_n['NO_PESERTA'];
				$no_sjp = getNomorHarian('SJP');
				$no_pendaftaran = getNomorBulanan('IRJA');
				
				$qry_kunjungan = 'SELECT COUNT(IRJA_ID) AS CN FROM t_irja WHERE NOMR = "' . $dat_daftar_n['NOMR'] . '"
						AND NO_PENDAFTARAN IS NOT NULL AND ST_BATAL IS NULL
						AND DATE_FORMAT(TANGGAL_DAFTAR,"%m%Y") = DATE_FORMAT(NOW(),"%m%Y")';
				$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());
				$dat_kunjungan = mysql_fetch_assoc($get_kunjungan);
				$kunj_baru = '1';
				if($dat_kunjungan['CN'] > 0) $kunj_baru = ''; 
		
				mysql_query('INSERT INTO t_irja (NOMR,TANGGAL_DAFTAR,ST_BARU,UNIT_ID,PEGAWAI_ID,
						JENIS_BAYAR_ID,NO_PESERTA,NO_SJP,NO_PENDAFTARAN,KUNJ_BARU,ONLINE_ID,
						AMBIL_RESEP,USER_PENDAFTARAN,ASAL_PASIEN_ID) VALUES ("' . $dat_daftar_n['NOMR'] . '",
						STR_TO_DATE("' . $dat_daftar_n['TGL_RENCANA_KUNJUNGAN'] . '","%d-%m-%Y"),
						"' . $st_baru . '","' . $dat_daftar_n['KLINIK_ID'] . '","' . $dat_daftar_n['DOKTER_ID'] . '",
						"' . $dat_daftar_n['CARA_BAYAR'] . '","' . $no_peserta_jkn . '","' . $no_sjp . '",
						"' . $no_pendaftaran . '","' . $kunj_baru . '","' . $dat_daftar_n['NO_ANTRIAN'] . '",
						"' . $dat_daftar_n['AMBIL_RESEP'] . '","' . $user_name . '","2")') or die(mysql_error());
				
				$qry_ls_daftar = 'SELECT IRJA_ID FROM t_irja 
						WHERE NOMR = "' . $dat_daftar_n['NOMR'] . '"
						ORDER BY IRJA_ID DESC LIMIT 1';
				$get_ls_daftar = mysql_query($qry_ls_daftar) or die(mysql_error());
				$dat_ls_daftar = mysql_fetch_assoc($get_ls_daftar);
				$irja_id = $dat_ls_daftar['IRJA_ID'];	
						
				$karcis = '1';
				$konsultasi = '1';
				if($dat_daftar_n['AMBIL_RESEP'] == '1') $konsultasi = '';
				if(in_array($dat_daftar_n['KLINIK_ID'],getArrIrjaNonKonsul())) $konsultasi = '';		
				
				$no_bayar = '"' . getNomorHarian('Kasir') . '"';
				$st_bayar = '"Lunas"';
				$nomor = getNomorHarian('Tarif');
				
				//karcis
				if($karcis == '1'){
					if(in_array($dat_daftar_n['KLINIK_ID'],getArrIrjaEksekutif())){
						$kode_tarif = '92001';
					}else{
						$kode_tarif = '01001';
					}
					$sql_tarif_karcis = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tarif . '" AND ST_AKTIF = "1"';
					$get_tarif_karcis = mysql_query($sql_tarif_karcis) or die(mysql_error());
					$dat_tarif_karcis = mysql_fetch_assoc($get_tarif_karcis);
					$tarif_karcis_id = $dat_tarif_karcis['TARIF_ID'];
					mysql_query('INSERT INTO t_irja_tarif(IRJA_ID,TGL_TARIF,TARIF_ID,KUANTITI,NO_TARIF,
						NO_PEMBAYARAN,DESKRIPSI,ST_BAYAR,JENIS_BAYAR_ID,USER_PENDAFTARAN)
						VALUES("' . $irja_id . '",STR_TO_DATE("' . $dat_daftar_n['TGL_RENCANA_KUNJUNGAN'] . ' ' . $jam . '","%d-%m-%Y %H:%i:%s"),
						"' . $tarif_karcis_id . '",1,"' . $nomor . '", ' . $no_bayar . ',"Karcis & Konsultasi",
						' . $st_bayar . ',"' . $dat_daftar_n['CARA_BAYAR'] . '","' . $user_name . '")') or die(mysql_error());	
				}			
				
				//konsultasi
				if($konsultasi == '1'){
					$sql_dokter_tipe = 'SELECT TIPE_PEGAWAI_ID FROM m_pegawai WHERE PEGAWAI_ID = "' . $dat_daftar_n['DOKTER_ID'] . '"';
					$get_dokter_tipe = mysql_query($sql_dokter_tipe) or die(mysql_error());
					$dat_dokter_tipe = mysql_fetch_assoc($get_dokter_tipe);
					$dokter_tipe = $dat_dokter_tipe['TIPE_PEGAWAI_ID']; 
					if(in_array($dat_daftar_n['KLINIK_ID'],getArrUnitIGD())){
						if($dokter_tipe == '2'){
							$kode_tarif_konsul = '09001';
						}else{
							$kode_tarif_konsul = '09002';
						}
					}else if(in_array($dat_daftar_n['KLINIK_ID'],getArrIrjaEksekutif())){
						if($dokter_tipe == '1'){
							$kode_tarif_konsul = '93002';
						}else if($dokter_tipe == '2'){
							$kode_tarif_konsul = '93001';
						}else if($dokter_tipe == '3'){
							$kode_tarif_konsul = '93003';
						}else if($dokter_tipe == '4'){
							$kode_tarif_konsul = '93004';
						}else if($dokter_tipe == '18'){
							$kode_tarif_konsul = '93005';	
						}
					}else{
						if($dokter_tipe == '1'){
							$kode_tarif_konsul = '02002';
						}else if($dokter_tipe == '2'){
							$kode_tarif_konsul = '02001';
						}else if($dokter_tipe == '3'){
							$kode_tarif_konsul = '02003';
						}else if($dokter_tipe == '4'){
							$kode_tarif_konsul = '02004';
						}else if($dokter_tipe == '9'){
							$kode_tarif_konsul = '02005';
						}else if($dokter_tipe == '18'){
							$kode_tarif_konsul = '93005';	
						}	
					}
				
					$sql_tarif_konsul = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tarif_konsul . '" AND ST_AKTIF = "1"';
					$get_tarif_konsul = mysql_query($sql_tarif_konsul) or die(mysql_error());
					$dat_tarif_konsul = mysql_fetch_assoc($get_tarif_konsul);
					$tarif_konsul_id = $dat_tarif_konsul['TARIF_ID'];
					mysql_query('INSERT INTO t_irja_tarif(IRJA_ID,TGL_TARIF,TARIF_ID,KUANTITI,NO_TARIF,NO_PEMBAYARAN,DESKRIPSI,
							ST_BAYAR,JENIS_BAYAR_ID,USER_PENDAFTARAN)
							VALUES("' . $irja_id . '",STR_TO_DATE("' . $dat_daftar_n['TGL_RENCANA_KUNJUNGAN'] . ' ' . $jam . '","%d-%m-%Y %H:%i:%s"),
							"' . $tarif_konsul_id . '",1,"' . $nomor . '", ' . $no_bayar . ',"Karcis & Konsultasi",
							' . $st_bayar . ',"' . $dat_daftar_n['CARA_BAYAR'] . '","' . $user_name . '")') or die(mysql_error());	
				}
				//end daftar simrs
				
				$connect = mysql_connect($hostname_8, $username_8, $password_8) or die(mysql_error());
				mysql_select_db($database_8, $connect) or die(mysql_error());	
				
				mysql_query('UPDATE t_daftar_rj SET IRJA_ID = "' . $irja_id . '"
					WHERE DAFTAR_ID = "' . $_POST['id_daftar'] . '"') or die(mysql_error());
			}	
		}
		
		if(currentModul() == 'kasir'){
			if($_POST['rd_nomr'] == '3'){
				mysql_query('UPDATE m_customer_member
					SET NOMR = "' . $nomr . '",
					NAMA_PASIEN = "' . $_POST['nama_pasien'] . '",
					TMP_LAHIR = "' . $_POST['tmp_lahir'] . '",
					TGL_LAHIR = STR_TO_DATE("' . $_POST['tgl_lahir'] . '","%d-%m-%Y"),
					AGAMA = "' . $_POST['agama'] . '",
					JNS_KELAMIN = "' . $_POST['jns_kelamin'] . '",
					NAMA_IBU = "' . $_POST['nama_ibu'] . '",
					ALAMAT = "' . $_POST['alamat'] . '",
					NIK = "' . $_POST['nik'] . '",
					PEKERJAAN = "' . $_POST['pekerjaan'] . '",
					RD_NOMR = "1"
					WHERE MEMBER_ID = "' . $_POST['id_member'] . '"') or die(mysql_error());			
			}	
			//daftar simrs
			$qry_daftar_n = 'SELECT d.DAFTAR_ID,d.CUSTOMER_ID,d.MEMBER_ID,
				m.NOMR,m.NAMA_PASIEN,m.TMP_LAHIR,
				DATE_FORMAT(m.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,
				m.AGAMA,m.JNS_KELAMIN,m.NAMA_IBU,m.ALAMAT,m.RD_NOMR,
				m.NO_CONTACT,m.EMAIL,m.NIK,
				DATE_FORMAT(d.TGL_RENCANA_KUNJUNGAN,"%d-%m-%Y") AS TGL_RENCANA_KUNJUNGAN,
				d.UNIT AS KLINIK_ID,d.DOKTER AS DOKTER_ID,
				d.PEMBAYARAN AS CARA_BAYAR,d.JAM_LAYANAN,d.NO_ANTRIAN,d.ST_BAYAR,
				DATE_FORMAT(d.TGL_DAFTAR,"%d-%m-%Y") AS TGL_DAFTAR,
				d.USER_VERIFIKASI,d.FOTO_RUJUKAN,
				m.NO_PESERTA,m.FOTO_NIK,m.FOTO_KK,m.FOTO_PESERTA,
				m.PEKERJAAN,d.AMBIL_RESEP,d.JUMLAH_BAYAR,d.IRJA_ID
				FROM t_daftar_rj d
				INNER JOIN m_customer c
				ON (d.CUSTOMER_ID = c.CUSTOMER_ID)
				INNER JOIN m_customer_member m
				ON (d.MEMBER_ID = m.MEMBER_ID)
				WHERE d.DAFTAR_ID = "' . $_POST['id_daftar'] . '"';
			$get_daftar_n = mysql_query($qry_daftar_n) or die(mysql_error());
			$dat_daftar_n = mysql_fetch_assoc($get_daftar_n);
				
			$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
			mysql_select_db($database, $connect) or die(mysql_error());	
				
			$qry_cek_pasien = 'SELECT PASIEN_ID FROM m_pasien WHERE NOMR = "' . $dat_daftar_n['NOMR'] . '"';
			$get_cek_pasien = mysql_query($qry_cek_pasien) or die(mysql_error());
			if(mysql_num_rows($get_cek_pasien) == 0){
				mysql_query('INSERT INTO m_pasien (NOMR,NAMA_PASIEN,TMP_LAHIR,TGL_LAHIR,JNS_KELAMIN,
					AGAMA_ID,PEKERJAAN,ALAMAT,NO_TELEPON,NAMA_IBU,NIK,KHUSUS,USER_PENDAFTARAN) 
					VALUES ("' . $dat_daftar_n['NOMR'] . '","' . strtoupper($dat_daftar_n['NAMA_PASIEN']) . '",
					"' . $dat_daftar_n['TMP_LAHIR'] . '",STR_TO_DATE("' . $dat_daftar_n['TGL_LAHIR'] . '","%d-%m-%Y"),
					"' . $dat_daftar_n['JNS_KELAMIN'] . '","' . $dat_daftar_n['AGAMA'] . '",
					"' . $dat_daftar_n['PEKERJAAN'] . '","' . $dat_daftar_n['ALAMAT'] . '",
					"' . $dat_daftar_n['NO_CONTACT'] . '","' . $dat_daftar_n['NAMA_IBU'] . '",
					"' . $dat_daftar_n['NIK'] . '","' . $khusus . '","' . $user_name . '")') or die(mysql_error());	
			}else{	
				mysql_query('UPDATE m_pasien SET NAMA_PASIEN = "' . strtoupper($dat_daftar_n['NAMA_PASIEN']) . '",
					TMP_LAHIR = "' . $dat_daftar_n['TMP_LAHIR'] . '",TGL_LAHIR = STR_TO_DATE("' . $dat_daftar_n['TGL_LAHIR'] . '","%d-%m-%Y"),
					JNS_KELAMIN = "' . $dat_daftar_n['JNS_KELAMIN'] . '",AGAMA_ID = "' . $dat_daftar_n['AGAMA'] . '",
					PEKERJAAN = "' . $dat_daftar_n['PEKERJAAN'] . '",ALAMAT = "' . $dat_daftar_n['ALAMAT'] . '",
					NO_TELEPON = "' . $dat_daftar_n['NO_CONTACT'] . '",NAMA_IBU = "' . $dat_daftar_n['NAMA_IBU'] . '",
					NIK = "' . $dat_daftar_n['NIK'] . '",
					KHUSUS = "' . $khusus . '", USER_PENDAFTARAN = "' . $user_name . '"
					WHERE NOMR = "' . $dat_daftar_n['NOMR'] . '"') or die(mysql_error());
			}
				
			$no_peserta_jkn = '';
			$no_sjp = getNomorHarian('SJP');
			$no_pendaftaran = getNomorBulanan('IRJA');
				
			$qry_kunjungan = 'SELECT COUNT(IRJA_ID) AS CN FROM t_irja WHERE NOMR = "' . $dat_daftar_n['NOMR'] . '"
					AND NO_PENDAFTARAN IS NOT NULL AND ST_BATAL IS NULL
					AND DATE_FORMAT(TANGGAL_DAFTAR,"%m%Y") = DATE_FORMAT(NOW(),"%m%Y")';
			$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());
			$dat_kunjungan = mysql_fetch_assoc($get_kunjungan);
			$kunj_baru = '1';
			if($dat_kunjungan['CN'] > 0) $kunj_baru = ''; 
		
			mysql_query('INSERT INTO t_irja (NOMR,TANGGAL_DAFTAR,ST_BARU,UNIT_ID,PEGAWAI_ID,
					JENIS_BAYAR_ID,NO_PESERTA,NO_SJP,NO_PENDAFTARAN,KUNJ_BARU,ONLINE_ID,
					AMBIL_RESEP,USER_PENDAFTARAN,ASAL_PASIEN_ID) VALUES ("' . $dat_daftar_n['NOMR'] . '",
					STR_TO_DATE("' . $dat_daftar_n['TGL_RENCANA_KUNJUNGAN'] . '","%d-%m-%Y"),
					"' . $st_baru . '","' . $dat_daftar_n['KLINIK_ID'] . '","' . $dat_daftar_n['DOKTER_ID'] . '",
					"' . $dat_daftar_n['CARA_BAYAR'] . '","' . $no_peserta_jkn . '","' . $no_sjp . '",
					"' . $no_pendaftaran . '","' . $kunj_baru . '","' . $dat_daftar_n['NO_ANTRIAN'] . '",
					"' . $dat_daftar_n['AMBIL_RESEP'] . '","' . $user_name . '","1")') or die(mysql_error());
				
			$qry_ls_daftar = 'SELECT IRJA_ID FROM t_irja 
					WHERE NOMR = "' . $dat_daftar_n['NOMR'] . '"
					ORDER BY IRJA_ID DESC LIMIT 1';
			$get_ls_daftar = mysql_query($qry_ls_daftar) or die(mysql_error());
			$dat_ls_daftar = mysql_fetch_assoc($get_ls_daftar);
			$irja_id = $dat_ls_daftar['IRJA_ID'];	
						
			$karcis = '1';
			$konsultasi = '1';
			if($dat_daftar_n['AMBIL_RESEP'] == '1') $konsultasi = '';
			if(in_array($dat_daftar_n['KLINIK_ID'],getArrIrjaNonKonsul())) $konsultasi = '';		
				
			$no_bayar = '"' . getNomorHarian('Kasir') . '"';
			$st_bayar = '"Lunas"';
			$nomor = getNomorHarian('Tarif');
				
			//karcis
			if($karcis == '1'){
				if(in_array($dat_daftar_n['KLINIK_ID'],getArrIrjaEksekutif())){
					$kode_tarif = '92001';
				}else{
					$kode_tarif = '01001';
				}
				$sql_tarif_karcis = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tarif . '" AND ST_AKTIF = "1"';
				$get_tarif_karcis = mysql_query($sql_tarif_karcis) or die(mysql_error());
				$dat_tarif_karcis = mysql_fetch_assoc($get_tarif_karcis);
				$tarif_karcis_id = $dat_tarif_karcis['TARIF_ID'];
				mysql_query('INSERT INTO t_irja_tarif(IRJA_ID,TGL_TARIF,TARIF_ID,KUANTITI,NO_TARIF,
					NO_PEMBAYARAN,DESKRIPSI,ST_BAYAR,JENIS_BAYAR_ID,USER_PENDAFTARAN,USER_KASIR,
					TGL_BAYAR) VALUES("' . $irja_id . '",
					STR_TO_DATE("' . $dat_daftar_n['TGL_RENCANA_KUNJUNGAN'] . ' ' . $jam . '","%d-%m-%Y %H:%i:%s"),
					"' . $tarif_karcis_id . '",1,"' . $nomor . '", ' . $no_bayar . ',"Karcis & Konsultasi",
					' . $st_bayar . ',"' . $dat_daftar_n['CARA_BAYAR'] . '","' . $user_name . '",
					"' . $user_name . '",NOW())') or die(mysql_error());	
			}			
				
			//konsultasi
			if($konsultasi == '1'){
				$sql_dokter_tipe = 'SELECT TIPE_PEGAWAI_ID FROM m_pegawai WHERE PEGAWAI_ID = "' . $dat_daftar_n['DOKTER_ID'] . '"';
				$get_dokter_tipe = mysql_query($sql_dokter_tipe) or die(mysql_error());
				$dat_dokter_tipe = mysql_fetch_assoc($get_dokter_tipe);
				$dokter_tipe = $dat_dokter_tipe['TIPE_PEGAWAI_ID']; 
				if(in_array($dat_daftar_n['KLINIK_ID'],getArrUnitIGD())){
					if($dokter_tipe == '2'){
						$kode_tarif_konsul = '09001';
					}else{
						$kode_tarif_konsul = '09002';
					}
				}else if(in_array($dat_daftar_n['KLINIK_ID'],getArrIrjaEksekutif())){
					if($dokter_tipe == '1'){
						$kode_tarif_konsul = '93002';
					}else if($dokter_tipe == '2'){
						$kode_tarif_konsul = '93001';
					}else if($dokter_tipe == '3'){
						$kode_tarif_konsul = '93003';
					}else if($dokter_tipe == '4'){
						$kode_tarif_konsul = '93004';
					}else if($dokter_tipe == '18'){
						$kode_tarif_konsul = '93005';	
					}
				}else{
					if($dokter_tipe == '1'){
						$kode_tarif_konsul = '02002';
					}else if($dokter_tipe == '2'){
						$kode_tarif_konsul = '02001';
					}else if($dokter_tipe == '3'){
						$kode_tarif_konsul = '02003';
					}else if($dokter_tipe == '4'){
						$kode_tarif_konsul = '02004';
					}else if($dokter_tipe == '9'){
						$kode_tarif_konsul = '02005';
					}else if($dokter_tipe == '18'){
						$kode_tarif_konsul = '93005';	
					}	
				}
				
				$sql_tarif_konsul = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tarif_konsul . '" AND ST_AKTIF = "1"';
				$get_tarif_konsul = mysql_query($sql_tarif_konsul) or die(mysql_error());
				$dat_tarif_konsul = mysql_fetch_assoc($get_tarif_konsul);
				$tarif_konsul_id = $dat_tarif_konsul['TARIF_ID'];
				mysql_query('INSERT INTO t_irja_tarif(IRJA_ID,TGL_TARIF,TARIF_ID,KUANTITI,NO_TARIF,NO_PEMBAYARAN,DESKRIPSI,
						ST_BAYAR,JENIS_BAYAR_ID,USER_PENDAFTARAN,USER_KASIR,TGL_BAYAR)
						VALUES("' . $irja_id . '",
						STR_TO_DATE("' . $dat_daftar_n['TGL_RENCANA_KUNJUNGAN'] . ' ' . $jam . '","%d-%m-%Y %H:%i:%s"),
						"' . $tarif_konsul_id . '",1,"' . $nomor . '", ' . $no_bayar . ',"Karcis & Konsultasi",
						' . $st_bayar . ',"' . $dat_daftar_n['CARA_BAYAR'] . '","' . $user_name . '",
						"' . $user_name . '",NOW())') or die(mysql_error());	
			}
			//end daftar simrs
				
			$connect = mysql_connect($hostname_8, $username_8, $password_8) or die(mysql_error());
			mysql_select_db($database_8, $connect) or die(mysql_error());

			mysql_query('UPDATE t_daftar_rj
					SET ST_BAYAR = "1",
					TGL_BAYAR = NOW(),
					USER_KASIR_VERIFIKASI = "' . $user_name . '",
					IRJA_ID = "' . $irja_id . '",
					TGL_PRINT = NOW()
					WHERE DAFTAR_ID = "' . $_POST['id_daftar'] . '"') or die(mysql_error());	
		}
		?>
		<script language="JavaScript" >
		alert('Simpan Data Berhasil.');
		</script>
		<?php
	}	
}	
	
$qry_daftar = 'SELECT d.DAFTAR_ID,d.CUSTOMER_ID,d.MEMBER_ID,
	m.NOMR,m.NAMA_PASIEN,m.TMP_LAHIR,
	DATE_FORMAT(m.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,
	m.AGAMA,m.JNS_KELAMIN,m.NAMA_IBU,m.ALAMAT,m.RD_NOMR,
	m.NO_CONTACT,m.EMAIL,m.NIK,
	DATE_FORMAT(d.TGL_RENCANA_KUNJUNGAN,"%d-%m-%Y") AS TGL_RENCANA_KUNJUNGAN,
	d.UNIT AS KLINIK_ID,d.DOKTER AS DOKTER_ID,
	d.PEMBAYARAN AS CARA_BAYAR,d.JAM_LAYANAN,d.NO_ANTRIAN,d.ST_BAYAR,
	DATE_FORMAT(d.TGL_DAFTAR,"%d-%m-%Y") AS TGL_DAFTAR,
	d.USER_VERIFIKASI,d.USER_KASIR_VERIFIKASI,d.FOTO_RUJUKAN,
	m.NO_PESERTA,m.FOTO_NIK,m.FOTO_KK,m.FOTO_PESERTA,
	m.PEKERJAAN,d.AMBIL_RESEP,d.JUMLAH_BAYAR,d.IRJA_ID
	FROM t_daftar_rj d
	INNER JOIN m_customer c
	ON (d.CUSTOMER_ID = c.CUSTOMER_ID)
	INNER JOIN m_customer_member m
	ON (d.MEMBER_ID = m.MEMBER_ID)
	WHERE d.DAFTAR_ID = "' . $id . '"';
$get_daftar = mysql_query($qry_daftar) or die(mysql_error());
$dat_daftar = mysql_fetch_assoc($get_daftar);
?>
<form name="pendaftaranedit" method="post" action="<?php echo currentUrl(); ?>" >
<div style=" height:auto; padding:15px; ">
	<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
	<!-- data pasien -->
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Nomor Medical Record</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left">
		<input type="text" name="nomr" value="<?php echo $dat_daftar['NOMR']; ?>" class="text_dt" style="width:150px;" <?php if($dat_daftar['RD_NOMR'] == '1' or $dat_daftar['RD_NOMR'] == '3') echo 'readonly'; ?> />
	</div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left">
		<input type="text" name="nama_pasien" value="<?php echo $dat_daftar['NAMA_PASIEN']; ?>" class="text_dt" size="30" />
	</div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Nama Pasien</div><br><br>

	<div style=" width:250px; float:left; text-indent:25px; " align="left">Tempat Lahir</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left">
		<input type="text" name="tmp_lahir" value="<?php echo $dat_daftar['TMP_LAHIR']; ?>" class="text_dt" size="30" />
	</div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left">
		<input type="text" name="tgl_lahir" value="<?php echo $dat_daftar['TGL_LAHIR']; ?>" class="text_dt" style="width:150px;" />
	</div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Tanggal Lahir</div><br><br>

	<div style=" width:250px; float:left; text-indent:25px; " align="left">Jenis Kelamin</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left">
		<select name="jns_kelamin" class="text_dt" style="width:160px;" >
			<option value="L" <?php if($dat_daftar['JNS_KELAMIN'] == 'L') echo 'selected'; ?> >Laki-laki</option>
			<option value="P" <?php if($dat_daftar['JNS_KELAMIN'] == 'P') echo 'selected'; ?> >Perempuan</option>
		</select>
	</div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left">
		<select name="agama" class="text_dt" style="width:160px;" >
			<option value="1" <?php if($dat_daftar['AGAMA'] == '1') echo 'selected'; ?> >Islam</option>
			<option value="2" <?php if($dat_daftar['AGAMA'] == '2') echo 'selected'; ?> >Kristen</option>
			<option value="3" <?php if($dat_daftar['AGAMA'] == '3') echo 'selected'; ?> >Katholik</option>
			<option value="4" <?php if($dat_daftar['AGAMA'] == '4') echo 'selected'; ?> >Hindu</option>
			<option value="5" <?php if($dat_daftar['AGAMA'] == '5') echo 'selected'; ?> >Budha</option>
			<option value="6" <?php if($dat_daftar['AGAMA'] == '6') echo 'selected'; ?> >Lain-lain</option>
		</select>
	</div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Agama</div><br><br>

	<div style=" width:250px; float:left; text-indent:25px; " align="left">Nama Ibu</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left">
		<input type="text" name="nama_ibu" value="<?php echo $dat_daftar['NAMA_IBU']; ?>" class="text_dt" size="30" />
	</div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left">
		<input type="text" name="nik" value="<?php echo $dat_daftar['NIK']; ?>" class="text_dt" size="30" />
	</div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">NIK</div><br><br>

	<div style=" width:250px; float:left; text-indent:25px; " align="left">Alamat</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left">
		<textarea name="alamat" class="text_dt6"><?php echo $dat_daftar['ALAMAT']; ?></textarea>
	</div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left">
		<input type="text" name="pekerjaan" value="<?php echo $dat_daftar['PEKERJAAN']; ?>" class="text_dt" size="30" />
	</div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Pekerjaan</div><br><br><br><br><br>
	</div>


	<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
	<!-- rencana kunjungan -->
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Tanggal Kunjungan</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left">
		<input type="text" name="tgl_minta" id="tgl_daftar" value="<?php echo $dat_daftar['TGL_RENCANA_KUNJUNGAN']; ?>" class="text_dt" style="width:150px;" />
		<img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar10')"/>
	</div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>

	<div style=" width:250px; float:left; text-indent:25px; " align="left">Klinik/ Unit</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left">
		<select name="klinik" class="text_dt" style="width:230px;" >
		<?php foreach($arr_unit as $key=>$value){ ?>
			<option value="<?php echo $key; ?>" <?php if($key==$dat_daftar['KLINIK_ID']) echo 'selected'; ?> ><?php echo $value; ?></option>
		<?php } ?>
		</select>
	</div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left">
	<select name="dokter" class="text_dt" style="width:230px;" >
		<?php foreach($arr_dokter as $key=>$value){ ?>
			<option value="<?php echo $key; ?>" <?php if($key==$dat_daftar['DOKTER_ID']) echo 'selected'; ?> ><?php echo $value; ?></option>
		<?php } ?>
		</select></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Dokter</div><br><br>
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Hanya Ambil Resep</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left">
		<input type="checkbox" name="ambil_resep" value="1" <?php echo $dat_daftar['AMBIL_RESEP']; ?> />&nbsp;Ya
	</div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Pembayaran</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left">
		<?php foreach($arr_jaminan as $key=>$value){ 
			if($dat_daftar['CARA_BAYAR'] == $key){
				echo $value;
				break;
			}	
		} ?>
	</div>
	<?php if($dat_daftar['CARA_BAYAR'] == '12'){ ?>
	<div style=" width:250px; float:right; text-indent:5px; " align="left">
	<?php echo $dat_daftar['NO_PESERTA']; ?>&nbsp;&nbsp;
	<button type="button" onClick="showPeserta()" class="myButton1" id="pesertaDetail" >cek no peserta</button>
	
	</div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">No Peserta</div><br/>
	
	<script>
		function showPeserta() {
			window.open('index.php?popup=seppesertadetail&no_peserta=<?php echo $dat_daftar['NO_PESERTA']; ?>&opt=1','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=500,height=600');
		}
	</script>
	
	<?php }else{ ?>
	<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br>
	<?php } ?>
	
	<?php if($dat_daftar['CARA_BAYAR'] == '1'){ ?>
	<br/>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Jumlah Bayar</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left">
		<?php echo currFormat($dat_daftar['JUMLAH_BAYAR']); ?>
	</div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left">
	<?php if($dat_daftar['ST_BAYAR'] == '1'){
			echo 'Lunas';
		}else{
			echo 'Menunggu Pembayaran';
		}
		?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Status</div><br><br>
	<?php } ?>
	<br/>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Foto Dokumen</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:700px; float:left; text-indent:5px;" align="left">
		<table width="100%" border="0">
			<tr>
				<td>
				<?php
					if($dat_daftar['FOTO_NIK'] != ''){
						$path = 'http://192.168.1.5/get_image/index.php?img=' . $dat_daftar['FOTO_NIK'];
						$type = pathinfo($path, PATHINFO_EXTENSION);
						$data = file_get_contents($path);
						$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
						echo '<a target="_blank" href="index.php?link=62839c4894b94a294407971dfd446a14&img=' . $dat_daftar['FOTO_NIK'] . '" style="padding:5px;"><img style="border:solid 2px;" src="' . $base64 . '" width="50px;" height="50px;" alt="KTP" title="KTP"></a>';
					}
					
					if($dat_daftar['FOTO_KK'] != ''){
						$path = 'http://192.168.1.5/get_image/index.php?img=' . $dat_daftar['FOTO_KK'];
						$type = pathinfo($path, PATHINFO_EXTENSION);
						$data = file_get_contents($path);
						$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
						echo '<a target="_blank" href="index.php?link=62839c4894b94a294407971dfd446a14&img=' . $dat_daftar['FOTO_KK'] . '" style="padding:5px;"><img style="border:solid 2px;" src="' . $base64 . '" width="50px;" height="50px;" alt="Kartu Keluarga" title="Kartu Keluarga"></a>';
					}
					
					if($dat_daftar['CARA_BAYAR'] != '1' and $dat_daftar['FOTO_PESERTA'] != ''){
						$path = 'http://192.168.1.5/get_image/index.php?img=' . $dat_daftar['FOTO_PESERTA'];
						$type = pathinfo($path, PATHINFO_EXTENSION);
						$data = file_get_contents($path);
						$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
						echo '<a target="_blank" href="index.php?link=62839c4894b94a294407971dfd446a14&img=' . $dat_daftar['FOTO_PESERTA'] . '" style="padding:5px;"><img style="border:solid 2px;" src="' . $base64 . '" width="50px;" height="50px;" alt="Kartu Peserta" title="Kartu Peserta"></a>';
					}
					
					if($dat_daftar['FOTO_RUJUKAN'] != ''){
						$path = 'http://192.168.1.5/get_image/index.php?img=' . $dat_daftar['FOTO_RUJUKAN'];
						$type = pathinfo($path, PATHINFO_EXTENSION);
						$data = file_get_contents($path);
						$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
						echo '<a target="_blank" href="index.php?link=62839c4894b94a294407971dfd446a14&img=' . $dat_daftar['FOTO_RUJUKAN'] . '" style="padding:5px;"><img style="border:solid 2px;" src="' . $base64 . '" width="50px;" height="50px;" alt="Surat Rujukan" title="Surat Rujukan"></a>';
					}
				?>
				</td>
			</tr>
		</table>
	</div>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:left; ">&nbsp;</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left">&nbsp;
	</div><br/><br/><br/></br/>
	</div>
<?php
$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
mysql_select_db($database, $connect) or die(mysql_error());	
				
$sql_tarif = 'SELECT TARIF_ID,TARIF_NON_KELAS FROM m_tarif WHERE KODE_TARIF = "01003" AND ST_AKTIF = "1"';
$get_tarif = mysql_query($sql_tarif) or die(mysql_error());
$dat_tarif = mysql_fetch_assoc($get_tarif);
$tarif_kartu = $dat_tarif['TARIF_NON_KELAS'];
$tarif_id = $dat_tarif['TARIF_ID'];

$sql_tarif_konsul = 'SELECT NO_TARIF FROM t_irja_tarif WHERE IRJA_ID = "' . $dat_daftar['IRJA_ID'] . '"
	AND DESKRIPSI = "Karcis & Konsultasi"';
$get_tarif_konsul = mysql_query($sql_tarif_konsul) or die(mysql_error());
$dat_tarif_konsul = mysql_fetch_assoc($get_tarif_konsul);
$no_tarif_konsul = $dat_tarif_konsul['NO_TARIF'];
?>	
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<table width="100%" border="0">
<tr>
	<td width="20%" align="right">
		<input type="hidden" name="id_daftar" value="<?php echo $dat_daftar['DAFTAR_ID']; ?>" />
		<input type="hidden" name="id_member" value="<?php echo $dat_daftar['MEMBER_ID']; ?>" />
		<input type="hidden" name="cara_bayar" value="<?php echo $dat_daftar['CARA_BAYAR']; ?>" />
		<input type="hidden" name="status_bayar" value="<?php echo $dat_daftar['ST_BAYAR']; ?>" />
		<input type="hidden" name="rd_nomr" value="<?php echo $dat_daftar['RD_NOMR']; ?>" />
		
		<?php if((currentModul() == 'pendaftaran' or currentModul() == 'ipapp') 
				and $dat_daftar['USER_VERIFIKASI'] == ''){ ?>
		<input type="checkbox" name="verif" value="1" />&nbsp;Verif&nbsp;&nbsp;	
		<input type="submit" name="simpan" value="simpan" class="myButton1" />
		<?php } ?>
		<?php if(currentModul() == 'kasir' and $dat_daftar['USER_KASIR_VERIFIKASI'] == '' 
			and $dat_daftar['CARA_BAYAR'] == '1'){ ?>
		<input type="checkbox" name="verif" value="1" />&nbsp;Verif Bayar&nbsp;&nbsp;	
		<input type="submit" name="simpan" value="simpan" class="myButton1" />
		<?php } ?>
		<?php if($dat_daftar['NOMR'] != '' and $dat_daftar['IRJA_ID'] != ''){ ?>
		<a href="#" onclick='javascript : cetak_sjp(); return false;'  ><input type="button" value="cetak kwitansi & sjp" class="myButton" /></a>
		<a href="#" onclick="javascript : cetak_kartu('<?php echo formatNoMR($dat_daftar['NOMR']); ?>','<?php echo $dat_daftar['NAMA_PASIEN']; ?>','','<?php echo $dat_daftar['JNS_KELAMIN']; ?>','<?php echo $dat_daftar['TGL_LAHIR']; ?>');return false;" ><input type="button" value="cetak kartu pasien" class="myButton1" /></a>
        <a href="#" onclick='javascript : cetak_label("<?php echo str_replace("'","`",$dat_daftar['NAMA_PASIEN']) . '","' . formatNoMR($dat_daftar['NOMR']) . '","' . jenisKelamin($dat_daftar['JNS_KELAMIN']) . '","' . $dat_daftar['TGL_LAHIR'] . '","' . $dat_daftar['IRJA_ID']; ?>"); return false;'  ><input type="button" value="cetak label" class="myButton" /></a>
		<script>
		function cetak_kartu(nomr,nama,alamat,jnskel,tgllahir){
			if(confirm('Kartu Pasien Dikenakan Biaya, Lanjutkan?')){
				MyAjaxRequest('bayar','index.php?ajaxrequest=addtarifkartupasien&idx=' + <?php echo $dat_daftar['IRJA_ID']; ?> + '&tarif=' + <?php echo $tarif_id; ?> + '&bayar=' + <?php echo $dat_daftar['CARA_BAYAR']; ?>);
				window.open("pdf/kartupasien.php?nomr="+ nomr +"&nama="+ nama +"&alamat="+ alamat +"&jnskel="+ jnskel +"&tgllahir="+ tgllahir,"Kartu Pasien");
			}
		}
		function cetak_label(nama,nomr,jnskel,tanggal,idx){
			window.open('http://localhost/nsimrs_print/print_label.php?nama=' + nama + '&nomr=' + nomr + '&jnskel=' + jnskel + '&tanggal=' + tanggal + '&idx=' + idx,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
		}

		function cetak_sjp(){
			var p_sjp = 'yes';
			var p_resep = 'no';
			var p_sep = 'no';
			window.open('http://localhost/nsimrs_print/print_pembayaran_karcis.php?idx=<?php echo $dat_daftar['IRJA_ID']; ?>&no=<?php echo $no_tarif_konsul; ?>&sjp=' + p_sjp + '&resep=' + p_resep + '&sep=' + p_sep,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220'); 	
		}		
		</script>
		<?php } ?>
		<a href="index.php?link=498e1df887d6c3ae2d99b909814e36c1&id=<?php echo $_GET['id']; ?>"><input type="button" value="selesai" class="myButton1" /></a>
	</td>
</tr>
</table>
</div>
</div>	
</form>
<?php } ?>