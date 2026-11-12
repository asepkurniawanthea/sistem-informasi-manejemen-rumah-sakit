<?php
function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = str_replace('|',"!",$str);
	$ret = htmlspecialchars($ret);
	return $ret;
}

$penunjang_id = $_POST['penunjang_id'];
$no_sjp = $_POST['no_sjp'];
$hasil_diagnosa = $_POST['hasil_diagnosa'];
$pegawai_id = $_POST['pegawai_id'];
$user_name = currentUser();

$_err = '';
if (empty($hasil_diagnosa))
    $_err = $_err . 'Catatan Harus Diisi. \n';

if (empty($pegawai_id))
    $_err = $_err . 'Pemeriksa Harus Diisi. \n';

if (empty($_err)) {
		$sql_cek_no_klinik = 'SELECT t_ipenunjang_tarif.JENIS_BAYAR_ID,t_ipenunjang_tarif.TANGGAL_DAFTAR,
					t_ipenunjang_tarif.ST_FINAL,t_ipenunjang_tarif.NO_SJP,t_ipenunjang_tarif.SHIFT_PENDAFTARAN,
					t_ipenunjang_tarif.ST_TPP,t_ipenunjang_tarif.NO_PESERTA,t_ipenunjang_tarif.NO_SEP,
					t_ipenunjang_tarif.TANGGAL_SEP,t_ipenunjang_tarif.JKN_TGL_RUJUK,t_ipenunjang_tarif.JKN_NO_RUJUK,
					t_ipenunjang_tarif.JKN_KD_PKK,t_ipenunjang_tarif.JKN_NAMA_PKK,t_ipenunjang_tarif.JKN_CATATAN,
					t_ipenunjang_tarif.JKN_DIAGNOSA,t_ipenunjang_tarif.JKN_POLIKLINIK,t_ipenunjang_tarif.JKN_KELAS_RAWAT,
					t_ipenunjang_tarif.JKN_PBI_NONPBI,t_ipenunjang_tarif.USER_PENDAFTARAN
					FROM t_ipenunjang_tarif
					WHERE t_ipenunjang_tarif.PENUNJANG_ID = "' . $penunjang_id . '"
					AND t_ipenunjang_tarif.NO_SJP = "' . $no_sjp . '"
					AND t_ipenunjang_tarif.UNIT_PENUNJANG_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '"
					ORDER BY t_ipenunjang_tarif.PENUNJANG_TARIF_ID ASC LIMIT 1';
		$get_cek_no_klinik = mysql_query($sql_cek_no_klinik) or die(mysql_error());
		$dat_cek_no_klinik = mysql_fetch_assoc($get_cek_no_klinik);	
		$selesai = 'NULL';
		if(isset($_POST['selesai'])) $selesai = '1';
			
			$no_bayar = 'NULL';
			$st_bayar = 'NULL';
			if($dat_cek_no_klinik['JENIS_BAYAR_ID'] != '1' and $dat_cek_no_klinik['JENIS_BAYAR_ID'] != '18'){
				$no_bayar = '"' . getNomorHarian('Kasir') . '"';
				$st_bayar = '"Lunas"';
			}
			$nomor = getNomorHarian('Tarif');
			
			mysql_query('UPDATE t_ipenunjang_tarif SET JENIS_BAYAR_ID = "' . $dat_cek_no_klinik['JENIS_BAYAR_ID'] . '",
						TANGGAL_DAFTAR = "' . $dat_cek_no_klinik['TANGGAL_DAFTAR'] . '",
						SHIFT_PENUNJANG = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
						NO_SJP = "' . $dat_cek_no_klinik['NO_SJP'] . '",
						SHIFT_PENDAFTARAN = "' . $dat_cek_no_klinik['SHIFT_PENDAFTARAN'] . '",
						ST_TPP = "' . $dat_cek_no_klinik['ST_TPP'] . '",
						NO_PESERTA = "' . $dat_cek_no_klinik['NO_PESERTA'] . '",
						NO_SEP = "' . $dat_cek_no_klinik['NO_SEP'] . '",
						TANGGAL_SEP = "' . $dat_cek_no_klinik['TANGGAL_SEP'] . '",
						JKN_TGL_RUJUK = "' . $dat_cek_no_klinik['JKN_TGL_RUJUK'] . '",
						JKN_NO_RUJUK = "' . $dat_cek_no_klinik['JKN_NO_RUJUK'] . '",
						JKN_KD_PKK = "' . $dat_cek_no_klinik['JKN_KD_PKK'] . '",
						JKN_NAMA_PKK = "' . $dat_cek_no_klinik['JKN_NAMA_PKK'] . '",
						JKN_CATATAN = "' . $dat_cek_no_klinik['JKN_CATATAN'] . '",
						JKN_DIAGNOSA = "' . $dat_cek_no_klinik['JKN_DIAGNOSA'] . '",
						JKN_POLIKLINIK = "' . $dat_cek_no_klinik['JKN_POLIKLINIK'] . '",
						JKN_KELAS_RAWAT = "' . $dat_cek_no_klinik['JKN_KELAS_RAWAT'] . '",
						JKN_PBI_NONPBI = "' . $dat_cek_no_klinik['JKN_PBI_NONPBI'] . '",
						ST_BAYAR = ' . $st_bayar . ',
						NO_PEMBAYARAN = ' . $no_bayar . ',
						NO_TARIF = "' . $nomor . '"
						WHERE PENUNJANG_ID = "' . $penunjang_id . '"
						AND NO_SJP = "' . $no_sjp . '"
						AND UNIT_PENUNJANG_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '"
						AND NO_TARIF IS NULL') or die(mysql_error());
			
			mysql_query('UPDATE t_ipenunjang_tarif SET ST_PERIKSA = "1",
						ST_FINAL = ' . $selesai . ',
						TANGGAL_PERIKSA = NOW(),
						PEGAWAI_PERIKSA_ID = "' . $pegawai_id . '",
						HASIL_DIAGNOSA = "' . $hasil_diagnosa . '",
						USER_PERIKSA = "' . $user_name . '"
						WHERE PENUNJANG_ID = "' . $penunjang_id . '"
						AND NO_SJP = "' . $no_sjp . '"
						AND UNIT_PENUNJANG_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '"') or die(mysql_error());	

			if(isset($_POST['fisio_id'])){
				if(empty($_POST['fisio_id'])){
					mysql_query('INSERT INTO t_pemeriksaan_fisioterapi (RAWAT_ID,PENUNJANG_ID,JNS_ORDER,
						NO_SJP,NOMR,TANGGAL,PEMERIKSAAN_DAN_EVALUASI,TERAPI,TK_CACAT,FISIOTERAPIST,
						TGL_ASSESMENT,REGISTER) VALUES ("' . $_POST['rawat_id'] . '","' . $_POST['penunjang_id'] . '",
						"' . strtoupper($_POST['ord']) . '","' . $_POST['no_sjp'] . '","' . $_POST['nomr'] . '",
						NOW(),"' . replace_quote($_POST['pemeriksaan']) .  '","' . replace_quote($_POST['terapi']) .  '",
						"' . replace_quote($_POST['tk_cacat']) .  '","' . $_POST['pegawai_id'] . '",
						NOW(),"' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '")') or die(mysql_error());
				}else{
					mysql_query('UPDATE t_pemeriksaan_fisioterapi 
						SET PEMERIKSAAN_DAN_EVALUASI = "' . replace_quote($_POST['pemeriksaan']) .  '",
						TERAPI = "' . replace_quote($_POST['pemeriksaan']) .  '",
						TK_CACAT = "' . replace_quote($_POST['pemeriksaan']) .  '",
						FISIOTERAPIST = "' . $_POST['pegawai_id'] . '",
						TGL_ASSESMENT = NOW(),
						REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
						ST_CREATE_ERM = NULL
						WHERE FISIOTERAPI_ID = "' . $_POST['fisio_id'] . '"') or die(mysql_error());
				}		
			}		

	//edoc rekam medic
	//include('edoc_rekammedik/edoc_main.php');	
	//create_pdf_penunjang($_POST['penunjang_id'],$_POST['ord'],$_POST['no_sjp']);		
	//
    ?>
    <script language="JavaScript" >
        alert('Simpan Data Pemeriksaan Penunjang Berhasil.');
		window.location = "<?php echo currentUrl(); ?>";
    </script>
    <?php
} else {
    $msg_info = $_err;
}
?>