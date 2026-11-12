<?php
$_err = '';
	
$procedure_safety_id = $_POST['procedure_safety_id'];
if(isset($_POST['kelengkapan_tim']))
	$kelengkapan_tim = $_POST['kelengkapan_tim'];
if(isset($_POST['peran_tim']))
	$peran_tim = $_POST['peran_tim'];
if(isset($_POST['antibiotik_propilaksis']))
	$antibiotik_propilaksis = $_POST['antibiotik_propilaksis'];

$diberikan_jam = $_POST['diberikan_jam'];
$diberikan_menit = $_POST['diberikan_menit'];

if(isset($_POST['antisipasi_kritis']))
	$antisipasi_kritis = $_POST['antisipasi_kritis'];
$antisipasi_kritis_mulai_jam = $_POST['antisipasi_kritis_mulai_jam'];
$antisipasi_kritis_mulai_menit = $_POST['antisipasi_kritis_mulai_menit'];
$antisipasi_kritis_selesai_jam = $_POST['antisipasi_kritis_selesai_jam'];
$antisipasi_kritis_selesai_menit = $_POST['antisipasi_kritis_selesai_menit'];
if(isset($_POST['antisipasi_kritis2']))
	$antisipasi_kritis2 = $_POST['antisipasi_kritis2'];
if(isset($_POST['cek_sterilisasi']))
	$cek_sterilisasi = $_POST['cek_sterilisasi'];
if(isset($_POST['kesiapan_peralatan']))
	$kesiapan_peralatan = $_POST['kesiapan_peralatan'];
if(isset($_POST['foto_radiologi']))
	$foto_radiologi = $_POST['foto_radiologi'];
$keterangan = $_POST['keterangan'];
$perawat = $_POST['perawat'];
$jns_antibiotik = $_POST['jns_antibiotik'];
$ket_kesiapan_peralatan = $_POST['ket_kesiapan_peralatan'];
	
$user_name = currentUser();
$operasi_id = $_POST['operasi_id'];

if (isset($_POST['simpan'])) {
		
    $sql_cek_no_operasi = 'SELECT NO_OPERASI FROM t_operasi WHERE OPERASI_ID = "' . $operasi_id . '"';
	$get_cek_no_operasi = mysql_query($sql_cek_no_operasi) or die(mysql_error());
	$dat_cek_no_operasi = mysql_fetch_assoc($get_cek_no_operasi);
	if (empty($dat_cek_no_operasi['NO_OPERASI']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
	
	$_err = '';
	if (empty($kelengkapan_tim))
		$_err = $_err . 'Kelengkapan Tim Harus Diisi. \n';
	if (empty($peran_tim))
		$_err = $_err . 'Menyebutkan Peran Tim Harus Diisi. \n';
	if (empty($antibiotik_propilaksis))
		$_err = $_err . 'Pemberian Antibiotik Propilaksis Harus Diisi. \n';
	if (empty($antisipasi_kritis))
		$_err = $_err . 'Tindakan Beresiko Tinggi Harus Diisi. \n';
	if (empty($antisipasi_kritis2))
		$_err = $_err . 'Antisipasi Pendarahan Harus Diisi. \n';
	if (empty($cek_sterilisasi))
		$_err = $_err . 'Cek Sterilisasi Harus Diisi. \n';
	if (empty($kesiapan_peralatan))
		$_err = $_err . 'Kesiapan Peralatan Harus Diisi. \n';
	if (empty($foto_radiologi))
		$_err = $_err . 'Pemasangan Foto Radiologi Harus Diisi. \n';
	if (empty($perawat))
		$_err = $_err . 'Perawat Penanggungjawab Harus Diisi. \n';
	
	if (empty($_err)) {
		if(empty($procedure_safety_id)){
			mysql_query('INSERT INTO t_operasi_prosedure_safety(OPERASI_ID,KELENGKAPAN_TIM,PERAN_TIM,
						ANTIBIOTIK_PROPILAKSIS,JNS_ANTIBIOTIK,DIBERIKAN_JAM,ANTISIPASI_KRITIS,
						ANTISIPASI_KRITIS_MULAI,ANTISIPASI_KRITIS_SELESAI,ANTISIPASI_KRITIS2,CEK_STERILISASI,
						KESIAPAN_PERALATAN,KET_KESIAPAN_PERALATAN,FOTO_RADIOLOGI,KETERANGAN,
						PERAWAT,USER_OPERASI) VALUES("' . $operasi_id . '","' . $kelengkapan_tim . '",
						"' . $peran_tim . '","' . $antibiotik_propilaksis . '","' . $jns_antibiotik . '","' . $diberikan_jam . ':' . $diberikan_menit . '",
						"' . $antisipasi_kritis . '","' . $antisipasi_kritis_mulai_jam . ':' . $antisipasi_kritis_mulai_menit . '","' . $antisipasi_kritis_selesai_jam . ':' . $antisipasi_kritis_selesai_menit . '",
						"' . $antisipasi_kritis2 . '","' . $cek_sterilisasi . '","' . $kesiapan_peralatan . '","' . $ket_kesiapan_peralatan . '",
						"' . $foto_radiologi . '","' . $keterangan . '","' . $perawat . '","' . $user_name . '")') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_operasi_prosedure_safety SET KELENGKAPAN_TIM = "' . $kelengkapan_tim . '",
						  PERAN_TIM = "' . $peran_tim . '",
						  ANTIBIOTIK_PROPILAKSIS = "' . $antibiotik_propilaksis . '",
						  JNS_ANTIBIOTIK = "' . $jns_antibiotik . '",
						  DIBERIKAN_JAM = "' . $diberikan_jam . ':' . $diberikan_menit . '",
						  ANTISIPASI_KRITIS = "' . $antisipasi_kritis . '",
						  ANTISIPASI_KRITIS_MULAI = "' . $antisipasi_kritis_mulai_jam . ':' . $antisipasi_kritis_mulai_menit . '",
						  ANTISIPASI_KRITIS_SELESAI = "' . $antisipasi_kritis_selesai_jam . ':' . $antisipasi_kritis_selesai_menit . '",
						  ANTISIPASI_KRITIS2 = "' . $antisipasi_kritis2 . '",
						  CEK_STERILISASI = "' . $cek_sterilisasi . '",
						  KESIAPAN_PERALATAN = "' . $kesiapan_peralatan . '",
						  KET_KESIAPAN_PERALATAN = "' . $ket_kesiapan_peralatan . '",
						  FOTO_RADIOLOGI = "' . $foto_radiologi . '",
						  KETERANGAN = "' . $keterangan . '",
						  PERAWAT = "' . $perawat . '",
						  USER_OPERASI = "' . $user_name . '"
						 WHERE PROCEDURE_SAFETY_ID = "' . $procedure_safety_id . '"') or die(mysql_error());
		}			  
?>
<script language="JavaScript" >
	alert('Simpan Data Prosedure Safety Berhasil.');
	window.location = "<?php echo currentUrl(); ?>";
</script>
<?php			
		}else{
			$msg_info = $_err;
		}
	}
}
?>