<?php
$pasien_pulang_id = $_POST['pasien_pulang_id'];
$irna_id = $_POST['irna_id'];
$ket_pasien_pulang = $_POST['ket_pasien_pulang'];
$pasien_keadaan_pulang_id = $_POST['pasien_keadaan_pulang_id'];
$tempat_rujukan = $_POST['tempat_rujukan'];
$lanjut_pengobatan = $_POST['lanjut_pengobatan'];
$tanggal_kontrol = $_POST['tanggal_kontrol'];
$komplikasi = $_POST['komplikasi'];
$cara_dirawat = '';
$user_name = currentUser();

$tgl_keluar = $_POST['tgl_keluar'];
$jam_keluar = $_POST['jam_keluar'];
$menit_keluar = $_POST['menit_keluar'];

$pasien_keluar = $tgl_keluar . ' ' . $jam_keluar . ':' . $menit_keluar . ':01';  

$_err = '';
if (empty($pasien_pulang_id))
    $_err = $_err . 'Status Pasien Pulang Harus Diisi. \n';
if (empty($pasien_keadaan_pulang_id))
    $_err = $_err . 'Keadaan Pulang Harus Diisi. \n';

if (empty($_err)) {
		$sql_cek_no_ranap = 'SELECT NO_RAWAT,NOMR,
							RUANG_ID,PEGAWAI_ID,PEGAWAI_RAWAT_ID,
							PEGAWAI_RAWAT_ID_2,PEGAWAI_RAWAT_ID_3,
							DATE_FORMAT(NOW(),"%Y-%m-%d %H:%i:%s") AS TANGGAL_PULANG,
							DATE_FORMAT(PASIEN_MASUK,"%d-%m-%Y %H:%i:%s") AS TANGGAL_MASUK,
							JENIS_BAYAR_ID,NO_SEP
							FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
		$get_cek_no_ranap = mysql_query($sql_cek_no_ranap) or die(mysql_error());
		$dat_cek_no_ranap = mysql_fetch_assoc($get_cek_no_ranap);
		if (empty($dat_cek_no_ranap['NO_RAWAT'])  or $_SESSION['SES_SIMRS_ADMIN'] == '1') {	
		$tanggal_pulang = $dat_cek_no_ranap['TANGGAL_PULANG'];
		$tanggal_masuk = $dat_cek_no_ranap['TANGGAL_MASUK'];
		$nosep = $dat_cek_no_ranap['NO_SEP'];
        $no_ranap = 'NULL';
		if(isset($_POST['selesai'])) $no_ranap = getNomorBulanan('IRNA');
			mysql_query('UPDATE t_irna SET PASIEN_PULANG_ID = "' . $pasien_pulang_id . '", PASIEN_KELUAR = ' . fieldDatetime($pasien_keluar) . ',
				ST_PULANG = "1", KET_PASIEN_PULANG = "' . $ket_pasien_pulang . '",NO_RAWAT = ' . $no_ranap . ',
				USER_IRNA = "' . $user_name . '",KEADAAN_PULANG_ID = "' . $pasien_keadaan_pulang_id . '",
				TEMPAT_RUJUKAN = "' . $tempat_rujukan . '",LANJUT_PENGOBATAN = "' . $lanjut_pengobatan . '",
				TGL_KONTROL_POLIKLINIK = STR_TO_DATE("' . $tanggal_kontrol . '","%d/%m/%Y"),
				KOMPLIKASI = "' . $komplikasi . '",CARA_DIRAWAT = "' . $cara_dirawat . '"
				WHERE IRNA_ID = "' . $irna_id  . '"') or die(mysql_error());
			
				$qry_pindah = 'SELECT DATE_FORMAT(t_irna_log.TANGGAL_MASUK,"%d-%m-%Y %H:%i:%s") AS TANGGAL_MASUK
							 FROM t_irna_log
							 WHERE t_irna_log.IRNA_ID = "' . $irna_id . '"
							 AND t_irna_log.JNS_UPDATE = "R"
							 AND t_irna_log.TANGGAL_MASUK IS NOT NULL
							 ORDER BY t_irna_log.TANGGAL_MASUK DESC LIMIT 1';
				$get_pindah = mysql_query($qry_pindah) or die(mysql_error());
				if(mysql_num_rows($get_pindah) > 0){
					$dat_pindah = mysql_fetch_assoc($get_pindah);
					$tanggal_masuk = $dat_pindah['TANGGAL_MASUK']; 
				}
			
				mysql_query('DELETE FROM t_irna_log WHERE IRNA_ID = "' . $irna_id . '" AND KETERANGAN_PINDAH = "Pasien Keluar"') or die(mysql_error());	
			
				mysql_query('INSERT INTO t_irna_log(IRNA_ID,NOMR,TANGGAL_UPDATE,JNS_UPDATE,
						RUANG_ID_ASAL,PEGAWAI_ID,PEGAWAI_RAWAT_ID,
						PEGAWAI_RAWAT_ID_2,PEGAWAI_RAWAT_ID_3,
						KETERANGAN_PINDAH,USER_IRNA,JENIS_BAYAR_ID,
						TANGGAL_KELUAR,PASIEN_PULANG_ID,PASIEN_KEADAAN_ID,LAMA_DIRAWAT)
						VALUES("' . $irna_id . '","' . $dat_cek_no_ranap['NOMR'] . '",NOW(),"R",
						"' . $dat_cek_no_ranap['RUANG_ID'] . '","' . $dat_cek_no_ranap['PEGAWAI_ID'] . '",
						"' . $dat_cek_no_ranap['PEGAWAI_RAWAT_ID'] . '","' . $dat_cek_no_ranap['PEGAWAI_RAWAT_ID_2'] . '",
						"' . $dat_cek_no_ranap['PEGAWAI_RAWAT_ID_3'] . '","Pasien Keluar","' . $user_name . '",
						"' . $dat_cek_no_ranap['JENIS_BAYAR_ID'] . '",' . fieldDatetime($pasien_keluar) . ',
						"' . $pasien_pulang_id . '","' . $pasien_keadaan_pulang_id . '",
						DATEDIFF(' . fieldDatetime($pasien_keluar) . ',' . fieldDatetime($tanggal_masuk) . '))') or die(mysql_error());	
		if($jns_pembayaran == 'JKN'){
			echo '<script language="JavaScript" >
					updatePulang("' . $nosep . '","' . $tanggal_pulang . '",0);
				</script>';
		}	
		}
	//edoc rekam medic
	include('edoc_rekammedik/edoc_main.php');
	create_pdf_pengkajian_awal($irna_id,'RI');
	create_pdf_resume_medis($irna_id);
	create_pdf_resep($irna_id,'RI');
	create_pdf_catatan_perkembangan_pasien($irna_id,'RI');
	create_pdf_pemberian_edukasi($irna_id,'RI');
	create_pdf_rencana_pemulangan($irna_id,'RI');
	create_pdf_rekonsiliasi_obat($irna_id);
	create_pdf_asuhan_keperawatan_rawat_inap($irna_id);
	create_pdf_ringkasan_riwayat_masuk_keluar_rawat_inap($irna_id);
	create_pdf_farmasi($irna_id,'RI');
	$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
	mysql_select_db($database, $connect) or die(mysql_error());
	//			
    ?>
    <script language="JavaScript" >
		alert('Simpan Data Pasien Pulang Berhasil.');
		window.location = "<?php echo currentUrl(); ?>";
    </script>
    <?php
} else {
    $msg_info = $_err;
}
?>