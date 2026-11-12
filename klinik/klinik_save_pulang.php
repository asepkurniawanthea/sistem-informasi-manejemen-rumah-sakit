<?php
$pasien_pulang_id = $_POST['pasien_pulang_id'];
$irja_id = $_POST['irja_id'];
$nomr = $_POST['nomr'];
$mt_rujukan = 'NULL';
if(isset($_POST['mt_rujukan'])) $mt_rujukan = '"1"';
$ket_pasien_pulang = $_POST['ket_pasien_pulang'];
$rujukan_unit_id = $_POST['rujukan_unit_id'];
$rujukan_ruang_id = $_POST['rujukan_ruang_id'];
$user_name = currentUser();

$jenis_bayar_id = $_POST['jenis_bayar_id'];
if(isset($_POST['pasien_keadaan_id'])) $pasien_keadaan_id = $_POST['pasien_keadaan_id'];
if(isset($_POST['jns_pelayanan'])) $jns_pelayanan = $_POST['jns_pelayanan'];
if(isset($_POST['rujuk_balik'])) $rujuk_balik = '1';

$_err = '';
if (empty($pasien_pulang_id))
    $_err = $_err . 'Status Pasien Pulang Harus Diisi. \n';

if(!empty($pasien_pulang_id)){
	if($pasien_pulang_id == '5'){
		if(empty($rujukan_unit_id)){
			$_err = $_err . 'Poliklinik Tujuan Harus Diisi. \n';
		}
	}
}	
if (empty($_err)) {
        $no_klinik = 'NULL';
		if(isset($_POST['selesai'])) $no_klinik = getNomorBulanan('IRJA');
			mysql_query('UPDATE t_irja SET PASIEN_PULANG_ID = "' . $pasien_pulang_id . '", PASIEN_KELUAR = NOW(),
					KET_PASIEN_PULANG = "' . $ket_pasien_pulang . '",
					MT_RUJUKAN = ' . $mt_rujukan . ',
					NO_KLINIK = ' . $no_klinik . ',
					USER_IRJA = "' . $user_name . '",
					RUJUKAN_UNIT_ID = "' . $rujukan_unit_id . '",
					RUJUKAN_RUANG_ID = "' . $rujukan_ruang_id . '",
					JNS_PELAYANAN = "' . $jns_pelayanan . '",
					PASIEN_KEADAAN_ID = "' . $pasien_keadaan_id . '",
					RUJUK_BALIK = "' . $rujuk_balik . '",
					ST_CREATE_ERM_RRKRJ = NULL
					WHERE IRJA_ID = "' . $irja_id  . '"') or die(mysql_error());
			
			if(currentModul() == 'casemix'){
				mysql_query('UPDATE t_cbg_tarif_mon_irja
					SET ST_MON = "0",
					USER_CASEMIX = "' . $user_name . '" 
					WHERE IRJA_ID = "' . $irja_id . '"') or die(mysql_error());
			}
			
			if(currentModul() == 'igd'){
				if($pasien_pulang_id == '2' and $rujukan_ruang_id == '104'){
					$no_sjp = getNomorHarian('SJP');
					$no_pendaftaran = getNomorBulanan('IRNA');
		
					$sql_rj = 'SELECT NOMR,JENIS_BAYAR_ID,NO_PESERTA,P_JAWAB_NAMA,P_JAWAB_NO_TELP,P_JAWAB_ALAMAT,P_JAWAB_ALAMAT_RT,
						P_JAWAB_ALAMAT_RW,P_JAWAB_KELURAHAN_ID,P_JAWAB_KECAMATAN_ID,P_JAWAB_KOTA_ID,P_JAWAB_PROPINSI_ID,
						P_JAWAB_HUBUNGAN,JKN_KELAS_RAWAT,KECELAKAAN,KASUS_POLISI
						FROM t_irja WHERE IRJA_ID = "' . $irja_id . '"';
					$get_rj = mysql_query($sql_rj) or die(mysql_error());	
					$dat_rj = mysql_fetch_assoc($get_rj);
					$nomr = $dat_rj['NOMR'];
					$jenis_bayar_id = $dat_rj['JENIS_BAYAR_ID'];
					$no_peserta = $dat_rj['NO_PESERTA'];
					$p_jawab_nama = $dat_rj['P_JAWAB_NAMA'];
					$p_jawab_no_telp = $dat_rj['P_JAWAB_NO_TELP'];
					$p_jawab_alamat = $dat_rj['P_JAWAB_ALAMAT']; 
					$p_jawab_alamat_rt = $dat_rj['P_JAWAB_ALAMAT_RT'];
					$p_jawab_alamat_rw = $dat_rj['P_JAWAB_ALAMAT_RW']; 
					$p_jawab_kelurahan_id = $dat_rj['P_JAWAB_KELURAHAN_ID'];
					$p_jawab_kecamatan_id = $dat_rj['P_JAWAB_KECAMATAN_ID'];
					$p_jawab_kota_id = $dat_rj['P_JAWAB_KOTA_ID'];
					$p_jawab_propinsi_id = $dat_rj['P_JAWAB_PROPINSI_ID'];
					$p_jawab_hubungan = $dat_rj['P_JAWAB_HUBUNGAN'];
					$kelas_jaminan = $dat_rj['JKN_KELAS_RAWAT'];
					$pasien_kecelakaan = $dat_rj['KECELAKAAN'];
					$kasus_polisi = $dat_rj['KASUS_POLISI'];
		
					$st_save = mysql_query('INSERT INTO t_irna(IRNA_ID,NOMR,TANGGAL_DAFTAR,RUANG_ID,PEGAWAI_ID,
							JENIS_BAYAR_ID,NO_PESERTA,NO_SJP,P_JAWAB_NAMA,P_JAWAB_NO_TELP,P_JAWAB_ALAMAT,P_JAWAB_ALAMAT_RT,
							P_JAWAB_ALAMAT_RW,P_JAWAB_KELURAHAN_ID,P_JAWAB_KECAMATAN_ID,P_JAWAB_KOTA_ID,P_JAWAB_PROPINSI_ID,
							P_JAWAB_HUBUNGAN,NO_PENDAFTARAN,USER_PENDAFTARAN,KELAS_JAMINAN,
							KECELAKAAN,KASUS_POLISI)
							VALUES("' . $irja_id . '","' . $nomr . '",NOW(),"' . $rujukan_ruang_id . '","595",
							"' . $jenis_bayar_id . '","' . $no_peserta . '","' . $no_sjp . '","' . $p_jawab_nama . '",
							"' . $p_jawab_no_telp . '","' . $p_jawab_alamat . '","' . $p_jawab_alamat_rt . '",
							"' . $p_jawab_alamat_rw . '","' . $p_jawab_kelurahan_id . '","' . $p_jawab_kecamatan_id . '",
							"' . $p_jawab_kota_id . '","' . $p_jawab_propinsi_id . '","' . $p_jawab_hubungan . '",
							"' . $no_pendaftaran . '","' . currentUser() . '","' . $kelas_jaminan . '",
							"' . $pasien_kecelakaan . '","' . $kasus_polisi . '")') or die(mysql_error());
				}	
			}	
			
			/*include('lib/vendor/autoload.php');
			include('lib/vendor/rkorebrits/htmltoopenxml/Archives/Scripts/HTMLtoOpenXML.php');
			include('edoc_rekammedik/new/erm_create_rrkrj.php');
			erm_create_rrkrj($irja_id,$nomr);*/
				
    ?>
    <script language="JavaScript" >
        alert('Simpan Data Pasien Pulang Berhasil.');
		<?php
		if(currentModul() == 'casemix'){
		?>
		window.location = "index.php?link=<?php echo md5('casemixmonitoringpasienirja'); ?>";
		<?php
		}else{
		?>
		window.location = "<?php echo currentUrl(); ?>";
		<?php } ?>
    </script>
    <?php
} else {
    $msg_info = $_err;
}
?>