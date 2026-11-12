<?php
$irna_id = $_POST['irna_id'];
$pegawai_id = $_POST['pegawai_id'];
$pegawai_rawat_id = $_POST['pegawai_rawat_id'];
$pegawai_rawat_id_2 = $_POST['pegawai_rawat_id_2'];
$pegawai_rawat_id_3 = $_POST['pegawai_rawat_id_3'];
$pegawai_rawat_id_4 = $_POST['pegawai_rawat_id_4'];
$pegawai_rawat_id_5 = $_POST['pegawai_rawat_id_5'];
$pegawai_rawat_id_6 = $_POST['pegawai_rawat_id_6'];
$pasien_masuk = $_POST['pasien_masuk'];
$ruang_id = $_POST['ruang_id'];
$tmp_tidur = $_POST['tmp_tidur'];

$nomr = $_POST['nomr'];
$jenis_bayar_id = $_POST['jenis_bayar_id'];
$tgl_daftar_irja = $_POST['tgl_daftar_irja'];

$log_pindah_id = $_POST['log_pindah_id'];
$user_name = currentUser();

$_err = '';
if (empty($pegawai_id))
    $_err = $_err . 'Dokter Penanggungjawab Harus Diisi. \n';
if (empty($ruang_id))
    $_err = $_err . 'Ruang Rawat Harus Diisi. \n';
//if (empty($tmp_tidur))
    //$_err = $_err . 'Nomor Tempat Tidur Harus Diisi. \n';

if (empty($_err)) {
	if(empty($log_pindah_id)){
		mysql_query('UPDATE t_irna SET PEGAWAI_ID = "' . $pegawai_id . '",PASIEN_MASUK = NOW(),
			USER_IRNA = "' . $user_name . '",
			RUANG_ID = "' . $ruang_id . '",NO_TMP_TIDUR = "' . $tmp_tidur . '",
			PEGAWAI_RAWAT_ID = "' . $pegawai_rawat_id . '",
			PEGAWAI_RAWAT_ID_2 = "' . $pegawai_rawat_id_2 . '",
			PEGAWAI_RAWAT_ID_3 = "' . $pegawai_rawat_id_3 . '",
			PEGAWAI_RAWAT_ID_4 = "' . $pegawai_rawat_id_4 . '",
			PEGAWAI_RAWAT_ID_5 = "' . $pegawai_rawat_id_5 . '",
			PEGAWAI_RAWAT_ID_6 = "' . $pegawai_rawat_id_6 . '",
			NEW_RM = "1"
			WHERE IRNA_ID = "' . $_POST['irna_id'] . '"') or die(mysql_error());
					
		mysql_query('INSERT INTO t_irna_log(IRNA_ID,NOMR,TANGGAL_UPDATE,JNS_UPDATE,
			RUANG_ID_BARU,PEGAWAI_ID,PEGAWAI_RAWAT_ID,PEGAWAI_RAWAT_ID_2,PEGAWAI_RAWAT_ID_3,
			KETERANGAN_PINDAH,TANGGAL_MASUK,USER_IRNA,JENIS_BAYAR_ID)
			VALUES("' . $_POST['irna_id'] . '","' . $nomr . '",NOW(),"R",
			"' . $ruang_id . '","' . $pegawai_id . '","' . $pegawai_rawat_id . '",
			"' . $pegawai_rawat_id_2 . '","' . $pegawai_rawat_id_3 . '","Pasien Masuk",
			NOW(),"' . $user_name . '","' . $jenis_bayar_id . '")') or die(mysql_error());
			
		mysql_query('INSERT INTO t_irna_opname(TANGGAL_OPNAME,IRNA_ID,NOMR,RUANG_ID,NO_TMP_TIDUR) 
				VALUES(NOW(),"' . $_POST['irna_id'] . '","' . $nomr . '","' . $ruang_id . '",
				"' . $tmp_tidur . '")') or die(mysql_error());	
						
						
		//akomodasi
		/*
		$sql_rawat = 'SELECT NO_RAWAT,NOMR,JENIS_BAYAR_ID,LOG_PINDAH_ID,
			m_ruang.KELAS_RAWAT,KELAS_JAMINAN,t_irna.RUANG_ID
			FROM t_irna
			INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)		
			WHERE IRNA_ID = "' . $_POST['irna_id'] . '"';
		$get_rawat = mysql_query($sql_rawat) or die(mysql_error());
		$dat_rawat = mysql_fetch_assoc($get_rawat);	
						
		mysql_query('DELETE t_irna_tarif 
			FROM t_irna_tarif 
			INNER JOIN m_tarif 
			ON (t_irna_tarif.TARIF_ID = m_tarif.TARIF_ID)
			WHERE t_irna_tarif.IRNA_ID = "' . $_POST['irna_id'] . '"
			AND m_tarif.KODE_TARIF = "51001"
			AND DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d%m%Y") = DATE_FORMAT(NOW(),"%d%m%Y")') or die(mysql_error());
						
			$sql_tarif = 'SELECT TARIF_ID FROM m_tarif 
				WHERE KODE_TARIF = "51001"
				AND ST_AKTIF = "1"';
			$get_tarif = mysql_query($sql_tarif) or die(mysql_error());
			$dat_tarif = mysql_fetch_assoc($get_tarif);
			$tarif_id = $dat_tarif['TARIF_ID'];
								
			$no_bayar = 'NULL';
			$st_bayar = 'NULL';
			if(!in_array($jenis_bayar_id,getArrNonJaminan())){
				$no_bayar = '"' . getNomorHarian('Kasir') . '"';
				$st_bayar = '"Lunas"';
			}
			
			$nomor = getNomorHarian('Tarif');
			$skr = getDatetimeSkr();
			if($jenis_bayar_id == '12' or $jenis_bayar_id == '5' or $jenis_bayar_id == '13'){
				$sql_tgl_rawat = 'SELECT DATE_FORMAT(vdate.SELECTED_DATE,"%d/%m/%Y") AS SELECTED_DATE
					FROM (SELECT ADDDATE("1970-01-01",T4.I*10000 + T3.I*1000 + T2.I*100 + T1.I*10 + T0.I) SELECTED_DATE FROM
						(SELECT 0 I UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) T0,
						(SELECT 0 I UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) T1,
						(SELECT 0 I UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) T2,
						(SELECT 0 I UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) T3,
						(SELECT 0 I UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) T4
					) vdate
				WHERE vdate.SELECTED_DATE
				BETWEEN STR_TO_DATE("' . $tgl_daftar_irja . '","%d/%m/%Y") 
				AND STR_TO_DATE(DATE_FORMAT(NOW(),"%d/%m/%Y"),"%d/%m/%Y")';
				$get_tgl_rawat = mysql_query($sql_tgl_rawat) or die(mysql_error());
				while($dat_tgl_rawat = mysql_fetch_array($get_tgl_rawat)){
					
					$sql_cek_tarif = 'SELECT tr.IRJA_TARIF_ID 
								FROM t_irja_tarif tr
								INNER JOIN m_tarif mt
								ON (tr.TARIF_ID = mt.TARIF_ID)
								WHERE tr.IRJA_ID = "' . $_POST['irna_id'] . '"
								AND tr.NO_TARIF IS NOT NULL
								AND DATE_FORMAT(tr.TGL_TARIF,"%d/%m/%Y") = "' . $dat_tgl_rawat['SELECTED_DATE'] . '"
								AND mt.KODE_TARIF = "200001"';
					$get_cek_tarif = mysql_query($sql_cek_tarif) or die(mysql_error());
					if(mysql_num_rows($get_cek_tarif) == 0){	
						mysql_query('INSERT INTO t_irna_tarif(IRNA_ID,TARIF_ID,KUANTITI,DESKRIPSI,KELAS_RAWAT,RUANG_ID,
								NO_TARIF,NO_PEMBAYARAN,TGL_TARIF,ST_BAYAR,KELAS_JAMINAN,JENIS_BAYAR_ID) 
								VALUES("' . $_POST['irna_id'] . '","' . $tarif_id . '",1,"Tindakan (Ruang Rawat)",
								"' . $dat_rawat['KELAS_RAWAT'] . '","' . $dat_rawat['RUANG_ID'] . '","' . $nomor . '",' . $no_bayar . ',
								STR_TO_DATE("' . $skr . '","%d/%m/%Y %H:%i:%s"),' . $st_bayar . ',"' . $dat_rawat['KELAS_JAMINAN'] . '","' . $dat_rawat['JENIS_BAYAR_ID'] . '")') or die(mysql_error());	
					}			
				}
				
			}else{
				mysql_query('INSERT INTO t_irna_tarif(IRNA_ID,TARIF_ID,KUANTITI,DESKRIPSI,KELAS_RAWAT,RUANG_ID,
					NO_TARIF,NO_PEMBAYARAN,TGL_TARIF,ST_BAYAR,KELAS_JAMINAN,JENIS_BAYAR_ID) 
					VALUES("' . $_POST['irna_id'] . '","' . $tarif_id . '",1,"Tindakan (Ruang Rawat)",
					"' . $dat_rawat['KELAS_RAWAT'] . '","' . $dat_rawat['RUANG_ID'] . '","' . $nomor . '",' . $no_bayar . ',
					NOW(),' . $st_bayar . ',"' . $dat_rawat['KELAS_JAMINAN'] . '","' . $dat_rawat['JENIS_BAYAR_ID'] . '")') or die(mysql_error());
			}
		*/	
		//end akomodasi					
	}else{
		mysql_query('INSERT INTO t_irna_log(IRNA_ID,NOMR,TANGGAL_UPDATE,JNS_UPDATE,
			RUANG_ID_BARU,PEGAWAI_ID,PEGAWAI_RAWAT_ID,PEGAWAI_RAWAT_ID_2,PEGAWAI_RAWAT_ID_3,
			KETERANGAN_PINDAH,TANGGAL_MASUK,USER_IRNA,JENIS_BAYAR_ID,
			RUANG_ID_ASAL)
			VALUES("' . $_POST['irna_id'] . '","' . $nomr . '",NOW(),"R",
			"' . $ruang_id . '","' . $pegawai_id . '","' . $pegawai_rawat_id . '",
			"' . $pegawai_rawat_id_2 . '","' . $pegawai_rawat_id_3 . '","Pasien Masuk",
			NOW(),"' . $user_name . '","' . $jenis_bayar_id . '",
			(SELECT l.RUANG_ID_ASAL FROM t_irna_log l WHERE l.IRNA_LOG_ID = "' . $log_pindah_id . '"))') or die(mysql_error());
					
		mysql_query('UPDATE t_irna SET PEGAWAI_ID = "' . $pegawai_id . '",
			RUANG_ID = "' . $ruang_id . '",NO_TMP_TIDUR = "' . $tmp_tidur . '",
			PEGAWAI_RAWAT_ID = "' . $pegawai_rawat_id . '",
			PEGAWAI_RAWAT_ID_2 = "' . $pegawai_rawat_id_2 . '",
			PEGAWAI_RAWAT_ID_3 = "' . $pegawai_rawat_id_3 . '",
			PEGAWAI_RAWAT_ID_4 = "' . $pegawai_rawat_id_4 . '",
			PEGAWAI_RAWAT_ID_5 = "' . $pegawai_rawat_id_5 . '",
			PEGAWAI_RAWAT_ID_6 = "' . $pegawai_rawat_id_6 . '",
			ST_PINDAH = NULL, USER_IRNA = "' . $user_name . '",
			LOG_PINDAH_ID = NULL
			WHERE IRNA_ID = "' . $_POST['irna_id'] . '"') or die(mysql_error());
	}		
?>
       <script language="JavaScript" >
            alert('Simpan Pasien Masuk Berhasil.');
			window.location = "index.php?link=<?php echo md5('ranapformpasienperiksa'); ?>&idx=<?php echo $_POST['irna_id']; ?>";
        </script>
<?php
} else {
    $msg_info = $_err;
}
?>