<?php
$_err = '';
	
$id_perencanaan_sedasi = $_POST['id_perencanaan_sedasi'];
if(isset($_POST['sedasi']))
	$sedasi = $_POST['sedasi'];
$ket_sedasi = $_POST['ket_sedasi'];
if(isset($_POST['ga']))
	$ga = $_POST['ga'];
$ket_ga = $_POST['ket_ga'];
if(isset($_POST['regional']))
	$regional = $_POST['regional'];
if(isset($_POST['ket_regional']))
	$ket_regional = $_POST['ket_regional'];
if(isset($_POST['lain_lain']))
	$lain_lain = $_POST['lain_lain'];
$ket_lain_lain = $_POST['ket_lain_lain'];
if(isset($_POST['tehnik_khusus']))
	$tehnik_khusus = $_POST['tehnik_khusus'];
if(isset($_POST['monitoring']))
	$monitoring = $_POST['monitoring'];
$ket_monitoring_ekg_lead = $_POST['ket_monitoring_ekg_lead'];
$ket_monitoring_cvp = $_POST['ket_monitoring_cvp'];
$ket_monitoring_arteri_line = $_POST['ket_monitoring_arteri_line'];
if(isset($_POST['alat_khusus']))
	$alat_khusus = $_POST['alat_khusus'];
$ket_alat_khusus_lain_lain = $_POST['ket_alat_khusus_lain_lain'];
if(isset($_POST['pasca_anestesi']))
	$pasca_anestesi = $_POST['pasca_anestesi'];
$ket_pasca_anestesi_aps = $_POST['ket_pasca_anestesi_aps'];
$pra_anestesi_mulai_tanggal = $_POST['pra_anestesi_mulai_tanggal'];
$pra_anestesi_mulai_jam = $_POST['pra_anestesi_mulai_jam'];
$pra_anestesi_mulai_menit = $_POST['pra_anestesi_mulai_menit'];
$pra_anestesi_medikasi_tanggal = $_POST['pra_anestesi_medikasi_tanggal'];
$pra_anestesi_medikasi_jam = $_POST['pra_anestesi_medikasi_jam'];
$pra_anestesi_medikasi_menit = $_POST['pra_anestesi_medikasi_menit'];
$pra_anestesi_kamar_bedah_tanggal = $_POST['pra_anestesi_kamar_bedah_tanggal'];
$pra_anestesi_kamar_bedah_jam = $_POST['pra_anestesi_kamar_bedah_jam'];
$pra_anestesi_kamar_bedah_menit = $_POST['pra_anestesi_kamar_bedah_menit'];
$pra_anestesi_ren_operasi_tanggal = $_POST['pra_anestesi_ren_operasi_tanggal'];
$pra_anestesi_ren_operasi_jam = $_POST['pra_anestesi_ren_operasi_jam'];
$pra_anestesi_ren_operasi_menit = $_POST['pra_anestesi_ren_operasi_menit'];
$catatan_pra_anestesi = $_POST['catatan_pra_anestesi'];
$dokter_dpjp_anestesi = $_POST['dokter_dpjp_anestesi'];
	
$user_name = currentUser();
$operasi_id = $_POST['operasi_id'];

if (isset($_POST['simpan'])) {
		
    $sql_cek_no_operasi = 'SELECT NO_OPERASI FROM t_operasi WHERE OPERASI_ID = "' . $operasi_id . '"';
	$get_cek_no_operasi = mysql_query($sql_cek_no_operasi) or die(mysql_error());
	$dat_cek_no_operasi = mysql_fetch_assoc($get_cek_no_operasi);
	if (empty($dat_cek_no_operasi['NO_OPERASI']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
	
	$_err = '';
	$thnk = $sedasi . $ga . $regional . $lain_lain;
	if (empty($thnk))
		$_err = $_err . 'Teknik Anestesia dan Sedasi Harus Diisi. \n';
	if (empty($tehnik_khusus))
		$_err = $_err . 'Tehnik Khusus Harus Diisi. \n';
	if (empty($monitoring))
		$_err = $_err . 'Monitoring Propilaksis Harus Diisi. \n';
	if (empty($alat_khusus))
		$_err = $_err . 'Alat Khusus Harus Diisi. \n';
	if (empty($pasca_anestesi))
		$_err = $_err . 'Perawatan Pasca Anestesia Harus Diisi. \n';
	if (empty($pra_anestesi_mulai_tanggal) or empty($pra_anestesi_mulai_jam) or empty($pra_anestesi_mulai_menit))
		$_err = $_err . 'Puasa Mulai Harus Diisi. \n';
	if (empty($pra_anestesi_medikasi_tanggal) or empty($pra_anestesi_medikasi_jam) or empty($pra_anestesi_medikasi_menit))
		$_err = $_err . 'Pre Medikasi Harus Diisi. \n';
	if (empty($pra_anestesi_kamar_bedah_tanggal) or empty($pra_anestesi_kamar_bedah_jam) or empty($pra_anestesi_kamar_bedah_menit))
		$_err = $_err . 'Transportasi ke Kamar Bedah Harus Diisi. \n';
	if (empty($pra_anestesi_ren_operasi_tanggal) or empty($pra_anestesi_ren_operasi_jam) or empty($pra_anestesi_ren_operasi_menit))
		$_err = $_err . 'Rencana Operasi Harus Diisi. \n';
	if (empty($dokter_dpjp_anestesi))
		$_err = $_err . 'DPJP Anestesiologi Harus Diisi. \n';
	
	if (empty($_err)) {
		if(empty($id_perencanaan_sedasi)){
			mysql_query('INSERT INTO t_operasi_perencanaan_sedasi(ID_OPERASI,SEDASI,KET_SEDASI,GA,KET_GA,
						REGIONAL,KET_REGIONAL,LAIN_LAIN,KET_LAIN_LAIN,TEHNIK_KHUSUS,MONITORING,
						KET_MONITORING_EKG_LEAD,KET_MONITORING_CVP,KET_MONITORING_ARTERI_LINE,ALAT_KHUSUS,
						KET_ALAT_KHUSUS_LAIN_LAIN,PASCA_ANESTESI,KET_PASCA_ANESTESI_APS,PRA_ANESTESI_MULAI,
						PRA_ANESTESI_MEDIKASI,PRA_ANESTESI_KAMAR_BEDAH,PRA_ANESTESI_REN_OPERASI,CATATAN_PRA_ANESTESI,
						DOKTER_DPJP_ANESTESI,USER_OPERASI) VALUES("' . $operasi_id. '","' .$sedasi. '",
						"' .$ket_sedasi. '","' .$ga. '","' .$ket_ga. '","' .$regional. '","' .$ket_regional. '",
						"' .$lain_lain. '","' .$ket_lain_lain. '","' .$tehnik_khusus. '","' .$monitoring. '",
						"' .$ket_monitoring_ekg_lead. '","' .$ket_monitoring_cvp. '","' .$ket_monitoring_arteri_line. '","' .$alat_khusus. '",
						"' .$ket_alat_khusus_lain_lain. '","' .$pasca_anestesi. '","' .$ket_pasca_anestesi_aps. '",
						' .fieldDatetime($pra_anestesi_mulai_tanggal . ' ' . $pra_anestesi_mulai_jam . ':' . $pra_anestesi_mulai_menit) .  ',
						' .fieldDatetime($pra_anestesi_medikasi_tanggal . ' ' . $pra_anestesi_medikasi_jam . ':' . $pra_anestesi_medikasi_menit) .  ',
						' .fieldDatetime($pra_anestesi_kamar_bedah_tanggal . ' ' . $pra_anestesi_kamar_bedah_jam . ':' . $pra_anestesi_kamar_bedah_menit) .  ',
						' .fieldDatetime($pra_anestesi_ren_operasi_tanggal . ' ' . $pra_anestesi_ren_operasi_jam . ':' . $pra_anestesi_ren_operasi_menit) .  ',
						"' .$catatan_pra_anestesi. '","' .$dokter_dpjp_anestesi. '","' .$user_name . '")') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_operasi_perencanaan_sedasi
							  SET SEDASI = "' . $sedasi  . '",
							  KET_SEDASI = "' . $ket_sedasi  . '",
							  GA = "' . $ga  . '",
							  KET_GA = "' . $ket_ga  . '",
							  REGIONAL = "' . $regional  . '",
							  KET_REGIONAL = "' . $ket_regional  . '",
							  LAIN_LAIN = "' . $lain_lain  . '",
							  KET_LAIN_LAIN = "' . $ket_lain_lain  . '",
							  TEHNIK_KHUSUS = "' . $tehnik_khusus  . '",
							  MONITORING = "' . $monitoring  . '",
							  KET_MONITORING_EKG_LEAD = "' . $ket_monitoring_ekg_lead  . '",
							  KET_MONITORING_CVP = "' . $ket_monitoring_cvp  . '",
							  KET_MONITORING_ARTERI_LINE = "' . $ket_monitoring_arteri_line  . '",
							  ALAT_KHUSUS = "' . $alat_khusus  . '",
							  KET_ALAT_KHUSUS_LAIN_LAIN = "' . $ket_alat_khusus_lain_lain  . '",
							  PASCA_ANESTESI = "' . $pasca_anestesi  . '",
							  KET_PASCA_ANESTESI_APS = "' . $ket_pasca_anestesi_aps  . '",
							  PRA_ANESTESI_MULAI = ' .fieldDatetime($pra_anestesi_mulai_tanggal . ' ' . $pra_anestesi_mulai_jam . ':' . $pra_anestesi_mulai_menit) .  ',
							  PRA_ANESTESI_MEDIKASI = ' .fieldDatetime($pra_anestesi_medikasi_tanggal . ' ' . $pra_anestesi_medikasi_jam . ':' . $pra_anestesi_medikasi_menit) .  ',
							  PRA_ANESTESI_KAMAR_BEDAH = ' .fieldDatetime($pra_anestesi_kamar_bedah_tanggal . ' ' . $pra_anestesi_kamar_bedah_jam . ':' . $pra_anestesi_kamar_bedah_menit) .  ',
							  PRA_ANESTESI_REN_OPERASI = ' .fieldDatetime($pra_anestesi_ren_operasi_tanggal . ' ' . $pra_anestesi_ren_operasi_jam . ':' . $pra_anestesi_ren_operasi_menit) .  ',
							  CATATAN_PRA_ANESTESI = "' . $catatan_pra_anestesi  . '",
							  DOKTER_DPJP_ANESTESI = "' . $dokter_dpjp_anestesi  . '",
							  USER_OPERASI = "' . $user_name  . '"
							  WHERE ID_PERENCANAAN_SEDASI = "' . $id_perencanaan_sedasi . '"') or die(mysql_error());
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