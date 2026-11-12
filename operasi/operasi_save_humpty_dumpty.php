<?php
$_err = '';
	
$hunpty_dumpty_id = $_POST['hunpty_dumpty_id'];

$usia_min_3_skor = '0';
if(isset($_POST['usia_min_3_skor'])) $usia_min_3_skor = $_POST['usia_min_3_skor'];
$usia_3_7_skor = '0';
if(isset($_POST['usia_3_7_skor'])) $usia_3_7_skor = $_POST['usia_3_7_skor'];
$usia_7_13_skor = '0';
if(isset($_POST['usia_7_13_skor'])) $usia_7_13_skor = $_POST['usia_7_13_skor'];
$usia_max_13_skor = '0';
if(isset($_POST['usia_max_13_skor'])) $usia_max_13_skor = $_POST['usia_max_13_skor'];
$jns_kel_l_skor = '0';
if(isset($_POST['jns_kel_l_skor'])) $jns_kel_l_skor = $_POST['jns_kel_l_skor'];
$jns_kel_p_skor = '0';
if(isset($_POST['jns_kel_p_skor'])) $jns_kel_p_skor = $_POST['jns_kel_p_skor'];
$diagnosis_neurologi_skor = '0';
if(isset($_POST['diagnosis_neurologi_skor'])) $diagnosis_neurologi_skor = $_POST['diagnosis_neurologi_skor'];
$perubahan_oksigenasi_skor = '0';
if(isset($_POST['perubahan_oksigenasi_skor'])) $perubahan_oksigenasi_skor = $_POST['perubahan_oksigenasi_skor'];
$gangguan_perilaku_skor = '0';
if(isset($_POST['gangguan_perilaku_skor'])) $gangguan_perilaku_skor = $_POST['gangguan_perilaku_skor'];
$diagnosis_lainya_skor = '0';
if(isset($_POST['diagnosis_lainya_skor'])) $diagnosis_lainya_skor = $_POST['diagnosis_lainya_skor'];
$sadar_keterbatasan_diri_skor = '0';
if(isset($_POST['sadar_keterbatasan_diri_skor'])) $sadar_keterbatasan_diri_skor = $_POST['sadar_keterbatasan_diri_skor'];
$lupa_keterbatasan_diri_skor = '0';
if(isset($_POST['lupa_keterbatasan_diri_skor'])) $lupa_keterbatasan_diri_skor = $_POST['lupa_keterbatasan_diri_skor'];
$orientasi_baik_skor = '0';
if(isset($_POST['orientasi_baik_skor'])) $orientasi_baik_skor = $_POST['orientasi_baik_skor'];
$riwayat_jatuh_bayi_skor = '0';
if(isset($_POST['riwayat_jatuh_bayi_skor'])) $riwayat_jatuh_bayi_skor = $_POST['riwayat_jatuh_bayi_skor'];
$alat_bantu_skor = '0';
if(isset($_POST['alat_bantu_skor'])) $alat_bantu_skor = $_POST['alat_bantu_skor'];
$tmp_tidur_standar_skor = '0';
if(isset($_POST['tmp_tidur_standar_skor'])) $tmp_tidur_standar_skor = $_POST['tmp_tidur_standar_skor'];
$rawat_jalan_skor = '0';
if(isset($_POST['rawat_jalan_skor'])) $rawat_jalan_skor = $_POST['rawat_jalan_skor'];
$response_24_jam_skor = '0';
if(isset($_POST['response_24_jam_skor'])) $response_24_jam_skor = $_POST['response_24_jam_skor'];
$response_48_jam_skor = '0';
if(isset($_POST['response_48_jam_skor'])) $response_48_jam_skor = $_POST['response_48_jam_skor'];
$response_48_jam_max_skor = '0';
if(isset($_POST['response_48_jam_max_skor'])) $response_48_jam_max_skor = $_POST['response_48_jam_max_skor'];
$multiple_obat_skor = '0';
if(isset($_POST['multiple_obat_skor'])) $multiple_obat_skor = $_POST['multiple_obat_skor'];
$satu_obat_skor = '0';
if(isset($_POST['satu_obat_skor'])) $satu_obat_skor = $_POST['satu_obat_skor'];
$medikasi_lain_skor = '0';
if(isset($_POST['medikasi_lain_skor'])) $medikasi_lain_skor = $_POST['medikasi_lain_skor'];
	
$user_name = currentUser();
$operasi_id = $_POST['operasi_id'];

if (isset($_POST['simpan'])) {
		
    $sql_cek_no_operasi = 'SELECT NO_OPERASI FROM t_operasi WHERE OPERASI_ID = "' . $operasi_id . '"';
	$get_cek_no_operasi = mysql_query($sql_cek_no_operasi) or die(mysql_error());
	$dat_cek_no_operasi = mysql_fetch_assoc($get_cek_no_operasi);
	if (empty($dat_cek_no_operasi['NO_OPERASI']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
	
	$_err = '';
	if (empty($_err)) {
		if(empty($hunpty_dumpty_id)){
			mysql_query('INSERT INTO t_operasi_humpty_dumpty(OPERASI_ID,USIA_MIN_3_SKOR,USIA_3_7_SKOR,
					USIA_7_13_SKOR,USIA_MAX_13_SKOR,JNS_KEL_L_SKOR,JNS_KEL_P_SKOR,DIAGNOSIS_NEUROLOGI_SKOR,
					PERUBAHAN_OKSIGENASI_SKOR,GANGGUAN_PERILAKU_SKOR,DIAGNOSIS_LAINYA_SKOR,SADAR_KETERBATASAN_DIRI_SKOR,
					LUPA_KETERBATASAN_DIRI_SKOR,ORIENTASI_BAIK_SKOR,RIWAYAT_JATUH_BAYI_SKOR,ALAT_BANTU_SKOR,
					TMP_TIDUR_STANDAR_SKOR,RAWAT_JALAN_SKOR,RESPONSE_24_JAM_SKOR,RESPONSE_48_JAM_SKOR,RESPONSE_48_JAM_MAX_SKOR,
					MULTIPLE_OBAT_SKOR,SATU_OBAT_SKOR,MEDIKASI_LAIN_SKOR,USER_OPERASI) VALUES(
					"' . $operasi_id. '","' . $usia_min_3_skor. '","' . $usia_3_7_skor. '",
					"' . $usia_7_13_skor. '","' . $usia_max_13_skor. '","' . $jns_kel_l_skor. '",
					"' . $jns_kel_p_skor. '","' . $diagnosis_neurologi_skor. '","' . $perubahan_oksigenasi_skor. '",
					"' . $gangguan_perilaku_skor. '","' . $diagnosis_lainya_skor. '","' . $sadar_keterbatasan_diri_skor. '",
					"' . $lupa_keterbatasan_diri_skor. '","' . $orientasi_baik_skor. '","' . $riwayat_jatuh_bayi_skor. '",
					"' . $alat_bantu_skor. '","' . $tmp_tidur_standar_skor. '","' . $rawat_jalan_skor. '",
					"' . $response_24_jam_skor. '","' . $response_48_jam_skor. '","' . $response_48_jam_max_skor. '",
					"' . $multiple_obat_skor. '","' . $satu_obat_skor. '","' . $medikasi_lain_skor. '","' . $user_name . '")') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_operasi_humpty_dumpty SET
					  USIA_MIN_3_SKOR = "' . $usia_min_3_skor . '",
					  USIA_3_7_SKOR = "' . $usia_3_7_skor . '",
					  USIA_7_13_SKOR = "' . $usia_7_13_skor . '",
					  USIA_MAX_13_SKOR = "' . $usia_max_13_skor . '",
					  JNS_KEL_L_SKOR = "' . $jns_kel_l_skor . '",
					  JNS_KEL_P_SKOR = "' . $jns_kel_p_skor . '",
					  DIAGNOSIS_NEUROLOGI_SKOR = "' . $diagnosis_neurologi_skor . '",
					  PERUBAHAN_OKSIGENASI_SKOR = "' . $perubahan_oksigenasi_skor . '",
					  GANGGUAN_PERILAKU_SKOR = "' . $gangguan_perilaku_skor . '",
					  DIAGNOSIS_LAINYA_SKOR = "' . $diagnosis_lainya_skor . '",
					  SADAR_KETERBATASAN_DIRI_SKOR = "' . $sadar_keterbatasan_diri_skor . '",
					  LUPA_KETERBATASAN_DIRI_SKOR = "' . $lupa_keterbatasan_diri_skor . '",
					  ORIENTASI_BAIK_SKOR = "' . $orientasi_baik_skor . '",
					  RIWAYAT_JATUH_BAYI_SKOR = "' . $riwayat_jatuh_bayi_skor . '",
					  ALAT_BANTU_SKOR = "' . $alat_bantu_skor . '",
					  TMP_TIDUR_STANDAR_SKOR = "' . $tmp_tidur_standar_skor . '",
					  RAWAT_JALAN_SKOR = "' . $rawat_jalan_skor . '",
					  RESPONSE_24_JAM_SKOR = "' . $response_24_jam_skor . '",
					  RESPONSE_48_JAM_SKOR = "' . $response_48_jam_skor . '",
					  RESPONSE_48_JAM_MAX_SKOR = "' . $response_48_jam_max_skor . '",
					  MULTIPLE_OBAT_SKOR = "' . $multiple_obat_skor . '",
					  SATU_OBAT_SKOR = "' . $satu_obat_skor . '",
					  MEDIKASI_LAIN_SKOR = "' . $medikasi_lain_skor . '",
					  USER_OPERASI = "' . $user_name . '"
					  WHERE HUNPTY_DUMPTY_ID = "' . $hunpty_dumpty_id . '"') or die(mysql_error());
		}			  
?>
<script language="JavaScript" >
	alert('Simpan Data Resiko Jatuh Berhasil.');
	window.location = "<?php echo currentUrl(); ?>";
</script>
<?php			
		}else{
			$msg_info = $_err;
		}
	}
}
?>