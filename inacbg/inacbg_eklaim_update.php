<?php
if(isset($_GET['nomr']) && isset($_GET['nosep']) && isset($_GET['tanggal']) && isset($_GET['jenis_bayar']) && isset($_GET['idx']) && isset($_GET['jnsrawat']) && isset($_GET['mh'])){
$idx_rawat = $_GET['idx'];
$svrmh = $_GET['mh'];
$nomr = $_GET['nomr'];
$jns_bayar = $_GET['jenis_bayar'];
$tanggal = $_GET['tanggal'];

$arr_discharge_status[1] = '1';
$arr_discharge_status[2] = '2';
$arr_discharge_status[3] = '4';
$arr_discharge_status[4] = '5';
$arr_discharge_status[5] = '2';
$arr_discharge_status[6] = '2';
$arr_discharge_status[7] = '5';
$arr_discharge_status[8] = '4';
$arr_discharge_status[9] = '3';
$arr_discharge_status[10] = '5';
$arr_discharge_status[11] = '5';
$arr_discharge_status[12] = '2';
$arr_discharge_status[13] = '1';
$arr_discharge_status[14] = '1';
$arr_discharge_status[''] = '1';

$arr_payor_id[1] = '1';
$arr_payor_id[2] = '3';
$arr_payor_id[3] = '3';
$arr_payor_id[5] = '1';
$arr_payor_id[8] = '3';
$arr_payor_id[9] = '5';
$arr_payor_id[10] = '8';
$arr_payor_id[11] = '3';
$arr_payor_id[12] = '3';
$arr_payor_id[13] = '8';
$arr_payor_id[14] = '7';
$arr_payor_id[15] = '3';
$arr_payor_id[16] = '1';

$arr_payor_cd[1] = 'PASIEN BAYAR';
$arr_payor_cd[2] = 'JKN';
$arr_payor_cd[3] = 'JKN';
$arr_payor_cd[5] = 'PASIEN BAYAR';
$arr_payor_cd[8] = 'JKN';
$arr_payor_cd[9] = 'JAMKESDA';
$arr_payor_cd[10] = 'JAMKESDA 3';
$arr_payor_cd[11] = 'JKN';
$arr_payor_cd[12] = 'JKN';
$arr_payor_cd[13] = 'JAMKESDA 3';
$arr_payor_cd[14] = 'JAMKESDA 2';
$arr_payor_cd[15] = 'JKN';
$arr_payor_cd[16] = 'PASIEN BAYAR';

//kode tarif group
$report_id = '11';

$arr_prosedur_non_bedah = array();
$arr_prosedur_bedah = array();
$arr_konsultasi = array();
$arr_tenaga_ahli = array();
$arr_keperawatan = array();
$arr_penunjang = array();
$arr_radiologi = array();
$arr_laboratorium = array();
$arr_pelayanan_darah = array();
$arr_rehabilitasi = array();
$arr_kamar = array();
$arr_sewa_alat = array();
$arr_eksekutif = array();

$arr_intensif = array('HCU','ICU','NICU','PICU','ICCU');
$arr_semua = array();

$arr_obat = array();
$arr_obat_kronis = array();
$arr_obat_kemoterapi = array();
$arr_alkes = array();
$arr_bmhp = array();
$arr_semua_obat = array();

$qry = 'SELECT t_filter_report_tarif.KODE_TARIF_GROUP,t_filter_report_tarif.NAMA_TARIF_FILTER,
		t_filter_report_tarif.LEVEL_DT
		FROM t_filter_report_tarif
		WHERE t_filter_report_tarif.REPORT_ID = "' . $report_id . '"';
$get = mysql_query($qry) or die(mysql_error());
while($dat = mysql_fetch_array($get)){
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'prosedur non bedah' and $dat['LEVEL_DT'] == '1') array_push($arr_prosedur_non_bedah,$dat['KODE_TARIF_GROUP']);
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'prosedur bedah' and $dat['LEVEL_DT'] == '1') array_push($arr_prosedur_bedah,$dat['KODE_TARIF_GROUP']);
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'konsultasi' and $dat['LEVEL_DT'] == '1') array_push($arr_konsultasi,$dat['KODE_TARIF_GROUP']);
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'tenaga ahli' and $dat['LEVEL_DT'] == '1') array_push($arr_tenaga_ahli,$dat['KODE_TARIF_GROUP']);
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'keperawatan' and $dat['LEVEL_DT'] == '1') array_push($arr_keperawatan,$dat['KODE_TARIF_GROUP']);
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'penunjang' and $dat['LEVEL_DT'] == '1') array_push($arr_penunjang,$dat['KODE_TARIF_GROUP']);
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'radiologi' and $dat['LEVEL_DT'] == '1') array_push($arr_radiologi,$dat['KODE_TARIF_GROUP']);
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'laboratorium' and $dat['LEVEL_DT'] == '1') array_push($arr_laboratorium,$dat['KODE_TARIF_GROUP']);
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'pelayanan darah' and $dat['LEVEL_DT'] == '1') array_push($arr_pelayanan_darah,$dat['KODE_TARIF_GROUP']);
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'rehabilitasi' and $dat['LEVEL_DT'] == '1') array_push($arr_rehabilitasi,$dat['KODE_TARIF_GROUP']);
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'kamar' and $dat['LEVEL_DT'] == '1') array_push($arr_kamar,$dat['KODE_TARIF_GROUP']);
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'sewa alat' and $dat['LEVEL_DT'] == '1') array_push($arr_sewa_alat,$dat['KODE_TARIF_GROUP']);
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'eksekutif' and $dat['LEVEL_DT'] == '1') array_push($arr_eksekutif,$dat['KODE_TARIF_GROUP']);
	if($dat['LEVEL_DT'] == '1') array_push($arr_semua,$dat['KODE_TARIF_GROUP']);
}

$qry = 'SELECT t_filter_report_obat.KODE_GROUP,t_filter_report_obat.NAMA_FILTER,
		t_filter_report_obat.LEVEL_DT
		FROM t_filter_report_obat
		WHERE t_filter_report_obat.REPORT_ID = "' . $report_id . '"';
$get = mysql_query($qry) or die(mysql_error());
while($dat = mysql_fetch_array($get)){
	if(strtolower($dat['NAMA_FILTER']) == 'obat' and $dat['LEVEL_DT'] == '1') array_push($arr_obat,$dat['KODE_GROUP']);
	if(strtolower($dat['NAMA_FILTER']) == 'obat kronis' and $dat['LEVEL_DT'] == '2') array_push($arr_obat_kronis,$dat['KODE_GROUP']);
	if(strtolower($dat['NAMA_FILTER']) == 'obat kemoterapi' and $dat['LEVEL_DT'] == '2') array_push($arr_obat_kemoterapi,$dat['KODE_GROUP']);
	if(strtolower($dat['NAMA_FILTER']) == 'alkes' and $dat['LEVEL_DT'] == '1') array_push($arr_alkes,$dat['KODE_GROUP']);
	if(strtolower($dat['NAMA_FILTER']) == 'bmhp' and $dat['LEVEL_DT'] == '1') array_push($arr_bmhp,$dat['KODE_GROUP']);
	if($dat['LEVEL_DT'] == '1') array_push($arr_semua_obat,$dat['KODE_GROUP']);
}

$nomor_sep_lama = '';
$nomor_sep = $_GET['nosep'];
$nomor_kartu = '';
$tgl_masuk = '';
$tgl_pulang = '';
$jenis_rawat = $_GET['jnsrawat'];
$kelas_rawat = '';
$adl_sub_acute = '';
$adl_chronic = '';
$icu_indikator = '';
$icu_los = '';
$ventilator_hour = '';
$upgrade_class_ind = '0';
$upgrade_class_class = '';
$upgrade_class_los = '';
$add_payment_pct = '';
$birth_weight = '';
$discharge_status = '';
$diagnosa = '';
$procedure = '';

// $tarif_rs
$tarif_rs = 0;
$prosedur_non_bedah = 0;
$prosedur_bedah = 0;
$konsultasi = 0;
$tenaga_ahli = 0;
$keperawatan = 0;
$penunjang = 0;
$radiologi = 0;
$laboratorium = 0;
$pelayanan_darah = 0;
$rehabilitasi = 0;
$kamar = 0;
$rawat_intensif = 0;
$obat = 0;
$obat_kronis = 0;
$obat_kemoterapi = 0;
$alkes = 0;
$bmhp = 0;
$sewa_alat = 0;

$temp_tarif_rs = 0;
// end tarif rs
$pemulasaraan_jenazah = '';
$kantong_jenazah 	= '';
$peti_jenazah 		= '';
$plastik_erat 		= '';
$desinfektan_jenazah = '';
$mobil_jenazah 		= '';
$desinfektan_mobil_jenazah = '';
$covid19_status_cd 	= '';
$nomor_kartu_t 		= '';
$episodes 			= '';
$covid19_cc_ind 	= ''; 
$tarif_poli_eks = 0;
$nama_dokter = '';
$kode_tarif = '';
$payor_id = $arr_payor_id[$jns_bayar];
$payor_cd = $arr_payor_cd[$jns_bayar];
$cob_cd = '';
$coder_nik = '';
if(isset($_SESSION['SES_SIMRS_CODER_NIK'])) $coder_nik = $_SESSION['SES_SIMRS_CODER_NIK']; 

$sql_claim = 'SELECT NO_SEP FROM t_cbg_claim WHERE RAWAT_ID = "' . $idx_rawat . '"
				AND JNS_RAWAT = "' . $jenis_rawat . '"';
$get_claim = mysql_query($sql_claim) or die(mysql_error());				
$dat_claim = mysql_fetch_assoc($get_claim);
$nomor_sep_lama = $dat_claim['NO_SEP'];

if($jenis_rawat == '2'){
	/** rawat jalan **/
	$sql_rawat = 'SELECT t_irja.NO_PESERTA,CONCAT(DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y-%m-%d")," 12:00:00") AS TGL_MASUK,
				CONCAT(DATE_FORMAT(t_irja.PASIEN_KELUAR,"%Y-%m-%d")," 12:00:00") AS TGL_PULANG,
				CASE WHEN t_irja.UNIT_ID IN (54) THEN "1" ELSE "3" END AS KELAS_RAWAT,m_pasien.BERAT_LAHIR,
				t_irja.PASIEN_PULANG_ID,m_pegawai.NAMA_PEGAWAI,m_pasien.NAMA_PASIEN,
				CASE WHEN t_irja.UNIT_ID = 35 THEN "BP" ELSE "CP" END KODE_TARIF
				FROM t_irja
				INNER JOIN m_pasien
				ON (t_irja.NOMR = m_pasien.NOMR)	
				INNER JOIN m_pegawai 
				ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_irja.IRJA_ID = "' . $idx_rawat . '"';
	$get_rawat = mysql_query($sql_rawat) or die(mysql_error());
	$dat_rawat = mysql_fetch_assoc($get_rawat);
	$nama_pasien = $dat_rawat['NAMA_PASIEN'];
	$nomor_kartu = $dat_rawat['NO_PESERTA'];
	$tgl_masuk = $dat_rawat['TGL_MASUK'];
	$tgl_pulang = $dat_rawat['TGL_PULANG'];
	if(empty($tgl_pulang)) $tgl_pulang = $tgl_masuk; 
	$kelas_rawat = $dat_rawat['KELAS_RAWAT'];
	$birth_weight = $dat_rawat['BERAT_LAHIR'];
	$discharge_status = $arr_discharge_status[$dat_rawat['PASIEN_PULANG_ID']];
	$nama_dokter = $dat_rawat['NAMA_PEGAWAI'];
	$kode_tarif = $dat_rawat['KODE_TARIF'];	
	
	$sql_diagnosa = 'SELECT t_irja_diagnosa.DIAGNOSA,t_irja_diagnosa.ICD_CODE
				FROM t_irja_diagnosa
				INNER JOIN t_irja
				ON (t_irja_diagnosa.IRJA_ID = t_irja.IRJA_ID)
				WHERE t_irja.NOMR = "' . $nomr . '"
				AND t_irja.JENIS_BAYAR_ID = "' . $jns_bayar . '"
				AND DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y-%m-%d") = "' . $tanggal . '"
				AND t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL
				ORDER BY t_irja_diagnosa.IRJA_ID,t_irja_diagnosa.DIAGNOSA_ORDER';
	$get_diagnosa = mysql_query($sql_diagnosa) or die(mysql_error());
	while($dat_diagnosa = mysql_fetch_array($get_diagnosa)){
		if(!empty($dat_diagnosa['ICD_CODE'])){
			$diagnosa = $diagnosa . trim($dat_diagnosa['ICD_CODE']) . '#';
		}else{
			$diagnosa = $diagnosa . trim($dat_diagnosa['DIAGNOSA']) . '#';
		}
	}
	$diagnosa = substr($diagnosa,0,strlen($diagnosa) - 1);			

	$sql_tindakan = 'SELECT t_irja_tarif.ICD_CODE,
					m_tarif.KODE_TARIF,
					m_tarif.TARIF_NON_KELAS AS TARIF,
					m_tarif.KODE_TARIF_GROUP
					FROM t_irja_tarif
					INNER JOIN m_tarif 
					ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN t_irja
					ON (t_irja_tarif.IRJA_ID = t_irja.IRJA_ID)
					WHERE t_irja.NOMR = "' . $nomr . '"
					AND t_irja.JENIS_BAYAR_ID = "' . $jns_bayar . '"
					AND DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y-%m-%d") = "' . $tanggal . '"
					AND t_irja.NO_PENDAFTARAN IS NOT NULL 
					AND t_irja.ST_BATAL IS NULL
					AND t_irja_tarif.NO_TARIF IS NOT NULL
					AND t_irja_tarif.ST_BAYAR = "Lunas"
					AND (m_tarif.MCU IS NULL OR m_tarif.MCU = "")';
	$get_tindakan = mysql_query($sql_tindakan) or die(mysql_error());
	while($dat_tindakan = mysql_fetch_array($get_tindakan)){
		if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_semua)){
				if(!empty($dat_tindakan['ICD_CODE'])){
					$procedure = $procedure . trim($dat_tindakan['ICD_CODE']) . '#';
				}else{
					$procedure = $procedure . trim($dat_tindakan['KODE_TARIF']) . '#';
				}
		}
		//breakdown tarif_rs
			if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_prosedur_non_bedah)) $prosedur_non_bedah = $prosedur_non_bedah + $dat_tindakan['TARIF'];
			if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_prosedur_bedah)) $prosedur_bedah = $prosedur_bedah + $dat_tindakan['TARIF'];
			if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_konsultasi)) $konsultasi = $konsultasi + $dat_tindakan['TARIF'];
			if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_tenaga_ahli)) $tenaga_ahli = $tenaga_ahli + $dat_tindakan['TARIF'];
			if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_keperawatan)) $keperawatan = $keperawatan + $dat_tindakan['TARIF'];
			if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_penunjang)) $penunjang = $penunjang + $dat_tindakan['TARIF'];
			if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_radiologi)) $radiologi = $radiologi + $dat_tindakan['TARIF'];
			if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_laboratorium)) $laboratorium = $laboratorium + $dat_tindakan['TARIF'];
			if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_pelayanan_darah)) $pelayanan_darah = $pelayanan_darah + $dat_tindakan['TARIF'];
			if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_rehabilitasi)) $rehabilitasi = $rehabilitasi + $dat_tindakan['TARIF'];
			if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_kamar)) $kamar = $kamar + $dat_tindakan['TARIF'];
			if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_sewa_alat)) $sewa_alat = $sewa_alat + $dat_tindakan['TARIF'];
			if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_eksekutif)) $tarif_poli_eks = $tarif_poli_eks + $dat_tindakan['TARIF'];
		//
		$temp_tarif_rs = $temp_tarif_rs + $dat_tindakan['TARIF'];
	}				
					
	$sql_penunjang = 'SELECT t_ipenunjang_tarif.ICD_CODE,
					m_tarif.KODE_TARIF,
					m_tarif.TARIF_NON_KELAS AS TARIF,
					m_tarif.KODE_TARIF_GROUP
					FROM t_ipenunjang_tarif
					INNER JOIN m_tarif 
					ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN t_ipenunjang 
					ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
					INNER JOIN t_irja 
					ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
					WHERE t_irja.NOMR = "' . $nomr . '"
					AND t_irja.JENIS_BAYAR_ID = "' . $jns_bayar . '"
					AND DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y-%m-%d") = "' . $tanggal . '"
					AND t_irja.NO_PENDAFTARAN IS NOT NULL 
					AND t_irja.ST_BATAL IS NULL 
					AND (t_ipenunjang.JNS_ORDER = "IRJ" 
						OR t_ipenunjang.JNS_ORDER = "HRJ"
						OR t_ipenunjang.JNS_ORDER = "ORJ")
					AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
					AND t_ipenunjang_tarif.ST_BATAL IS NULL
					AND t_ipenunjang_tarif.ST_BAYAR = "Lunas"
					AND (m_tarif.MCU = "" OR m_tarif.MCU IS NULL)';	
	$get_penunjang = mysql_query($sql_penunjang) or die(mysql_error());
	while($dat_penunjang = mysql_fetch_array($get_penunjang)){
		if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_semua)){
			if(!empty($dat_penunjang['ICD_CODE'])){
				$procedure = $procedure . trim($dat_penunjang['ICD_CODE']) . '#';
			}else{
				$procedure = $procedure . trim($dat_penunjang['KODE_TARIF']) . '#';
			}
		}
		//breakdown tarif_rs
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_prosedur_non_bedah)) $prosedur_non_bedah = $prosedur_non_bedah + $dat_penunjang['TARIF'];
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_prosedur_bedah)) $prosedur_bedah = $prosedur_bedah + $dat_penunjang['TARIF'];
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_konsultasi)) $konsultasi = $konsultasi + $dat_penunjang['TARIF'];
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_tenaga_ahli)) $tenaga_ahli = $tenaga_ahli + $dat_penunjang['TARIF'];
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_keperawatan)) $keperawatan = $keperawatan + $dat_penunjang['TARIF'];
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_penunjang)) $penunjang = $penunjang + $dat_penunjang['TARIF'];
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_radiologi)) $radiologi = $radiologi + $dat_penunjang['TARIF'];
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_laboratorium)) $laboratorium = $laboratorium + $dat_penunjang['TARIF'];
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_pelayanan_darah)) $pelayanan_darah = $pelayanan_darah + $dat_penunjang['TARIF'];
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_rehabilitasi)) $rehabilitasi = $rehabilitasi + $dat_penunjang['TARIF'];
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_kamar)) $kamar = $kamar + $dat_penunjang['TARIF'];
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_sewa_alat)) $sewa_alat = $sewa_alat + $dat_penunjang['TARIF'];
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_eksekutif)) $tarif_poli_eks = $tarif_poli_eks + $dat_penunjang['TARIF'];
		//
		$temp_tarif_rs = $temp_tarif_rs + $dat_penunjang['TARIF'];
	}

	$sql_operasi = 'SELECT t_operasi_tarif.ICD_CODE,
					m_tarif.KODE_TARIF,
					CASE WHEN m_tarif_group.NON_KELAS = "1" THEN m_tarif.TARIF_NON_KELAS
					ELSE	
						CASE WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "3" THEN m_tarif.TARIF_KELAS_3 
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "2" THEN m_tarif.TARIF_KELAS_2
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "1" THEN m_tarif.TARIF_KELAS_1
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "UTAMA" THEN m_tarif.TARIF_KELAS_UTAMA
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "VIP" THEN m_tarif.TARIF_KELAS_UTAMA
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "UTAMA 2" THEN m_tarif.TARIF_KELAS_UTAMA_2
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "VVIP" THEN m_tarif.TARIF_KELAS_UTAMA_2
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "HCU" THEN m_tarif.TARIF_HCU
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "ICU" THEN m_tarif.TARIF_ICU
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "NICU" THEN m_tarif.TARIF_NICU
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "PICU" THEN m_tarif.TARIF_PICU
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "ICCU" THEN m_tarif.TARIF_ICCU
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "PERINA" THEN m_tarif.TARIF_PERINA
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "BAYI SEHAT" THEN m_tarif.TARIF_KELAS_PERINA_SEHAT
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "BAYI SAKIT" THEN m_tarif.TARIF_KELAS_PERINA_SAKIT
						END 
					END AS TARIF,
					m_tarif.KODE_TARIF_GROUP
					FROM t_operasi_tarif
					INNER JOIN m_tarif 
					ON (t_operasi_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group
					ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					INNER JOIN t_operasi 
					ON (t_operasi_tarif.OPERASI_ID = t_operasi.OPERASI_ID)
					INNER JOIN t_irja 
					ON (t_operasi.RAWAT_ID = t_irja.IRJA_ID)
					WHERE t_irja.NOMR = "' . $nomr . '"
					AND t_irja.JENIS_BAYAR_ID = "' . $jns_bayar . '"
					AND DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y-%m-%d") = "' . $tanggal . '"
					AND t_operasi.JNS_ORDER = "IRJ" AND t_operasi.ST_MASUK = "1"
					AND t_operasi_tarif.NO_TARIF IS NOT NULL
					AND t_operasi_tarif.ST_BAYAR = "Lunas"';
	$get_operasi = mysql_query($sql_operasi) or die(mysql_error());
	while($dat_operasi = mysql_fetch_array($get_operasi)){
		if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_semua)){
			if(!empty($dat_operasi['ICD_CODE'])){
				$procedure = $procedure . trim($dat_operasi['ICD_CODE']) . '#';
			}else{
				$procedure = $procedure . trim($dat_operasi['KODE_TARIF']) . '#';
			}
		}	
		//breakdown tarif_rs
			if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_prosedur_non_bedah)) $prosedur_non_bedah = $prosedur_non_bedah + $dat_operasi['TARIF'];
			if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_prosedur_bedah)) $prosedur_bedah = $prosedur_bedah + $dat_operasi['TARIF'];
			if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_konsultasi)) $konsultasi = $konsultasi + $dat_operasi['TARIF'];
			if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_tenaga_ahli)) $tenaga_ahli = $tenaga_ahli + $dat_operasi['TARIF'];
			if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_keperawatan)) $keperawatan = $keperawatan + $dat_operasi['TARIF'];
			if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_penunjang)) $penunjang = $penunjang + $dat_operasi['TARIF'];
			if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_radiologi)) $radiologi = $radiologi + $dat_operasi['TARIF'];
			if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_laboratorium)) $laboratorium = $laboratorium + $dat_operasi['TARIF'];
			if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_pelayanan_darah)) $pelayanan_darah = $pelayanan_darah + $dat_operasi['TARIF'];
			if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_rehabilitasi)) $rehabilitasi = $rehabilitasi + $dat_operasi['TARIF'];
			if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_kamar)) $kamar = $kamar + $dat_operasi['TARIF'];
			if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_sewa_alat)) $sewa_alat = $sewa_alat + $dat_operasi['TARIF'];
			if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_eksekutif)) $tarif_poli_eks = $tarif_poli_eks + $dat_operasi['TARIF'];
		//
		$temp_tarif_rs = $temp_tarif_rs + $dat_operasi['TARIF'];
	}
	$procedure = substr($procedure,0,strlen($procedure) - 1);	
					
	$sql_hemodialisa = 'SELECT t_hemodialisa_tarif.ICD_CODE,
					m_tarif.KODE_TARIF,
					m_tarif.TARIF_NON_KELAS AS TARIF,
					m_tarif.KODE_TARIF_GROUP
					FROM t_hemodialisa_tarif
					INNER JOIN m_tarif 
					ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN t_hemodialisa 
					ON (t_hemodialisa_tarif.HEMODIALISA_ID = t_hemodialisa.HEMODIALISA_ID)
					INNER JOIN t_irja 
					ON (t_hemodialisa.RAWAT_ID = t_irja.IRJA_ID)
					WHERE t_irja.NOMR = "' . $nomr . '"
					AND t_irja.JENIS_BAYAR_ID = "' . $jns_bayar . '"
					AND DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y-%m-%d") = "' . $tanggal . '"
					AND t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL 
					AND t_hemodialisa.JNS_ORDER = "IRJ"
					AND t_hemodialisa_tarif.NO_TARIF IS NOT NULL
					AND t_hemodialisa_tarif.ST_BATAL IS NULL
					AND t_hemodialisa_tarif.ST_BAYAR = "Lunas"';
	$get_hemodialisa = mysql_query($sql_hemodialisa) or die(mysql_error());
	while($dat_hemodialisa = mysql_fetch_array($get_hemodialisa)){
		if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_semua)){
			if(!empty($dat_hemodialisa['ICD_CODE'])){
				$procedure = $procedure . trim($dat_hemodialisa['ICD_CODE']) . '#';
			}else{
				$procedure = $procedure . trim($dat_hemodialisa['KODE_TARIF']) . '#';
			}
		}	
		//breakdown tarif_rs
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_prosedur_non_bedah)) $prosedur_non_bedah = $prosedur_non_bedah + $dat_hemodialisa['TARIF'];
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_prosedur_bedah)) $prosedur_bedah = $prosedur_bedah + $dat_hemodialisa['TARIF'];
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_konsultasi)) $konsultasi = $konsultasi + $dat_hemodialisa['TARIF'];
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_tenaga_ahli)) $tenaga_ahli = $tenaga_ahli + $dat_hemodialisa['TARIF'];
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_keperawatan)) $keperawatan = $keperawatan + $dat_hemodialisa['TARIF'];
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_penunjang)) $penunjang = $penunjang + $dat_hemodialisa['TARIF'];
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_radiologi)) $radiologi = $radiologi + $dat_hemodialisa['TARIF'];
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_laboratorium)) $laboratorium = $laboratorium + $dat_hemodialisa['TARIF'];
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_pelayanan_darah)) $pelayanan_darah = $pelayanan_darah + $dat_hemodialisa['TARIF'];
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_rehabilitasi)) $rehabilitasi = $rehabilitasi + $dat_hemodialisa['TARIF'];
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_kamar)) $kamar = $kamar + $dat_hemodialisa['TARIF'];
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_sewa_alat)) $sewa_alat = $sewa_alat + $dat_hemodialisa['TARIF'];
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_eksekutif)) $tarif_poli_eks = $tarif_poli_eks + $dat_hemodialisa['TARIF'];
		//
		$temp_tarif_rs = $temp_tarif_rs + $dat_hemodialisa['TARIF'];
	}
	$procedure = substr($procedure,0,strlen($procedure) - 1);

	$sql_ambulance = 'SELECT "" AS ICD_CODE,
					m_tarif.KODE_TARIF,
					m_tarif.TARIF_NON_KELAS AS TARIF,
					m_tarif.KODE_TARIF_GROUP
					FROM t_ambulance_tarif
					INNER JOIN m_tarif 
					ON (t_ambulance_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN t_irja
					ON (t_ambulance_tarif.RAWAT_ID = t_irja.IRJA_ID)
					WHERE t_irja.NOMR = "' . $nomr . '"
					AND t_irja.JENIS_BAYAR_ID = "' . $jns_bayar . '"
					AND DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y-%m-%d") = "' . $tanggal . '"
					AND t_irja.NO_PENDAFTARAN IS NOT NULL 
					AND t_irja.ST_BATAL IS NULL
					AND t_ambulance_tarif.JNS_ORDER = "IRJ" 
					AND t_ambulance_tarif.NO_TARIF IS NOT NULL
					AND t_ambulance_tarif.ST_BAYAR = "Lunas"';
	$get_ambulance = mysql_query($sql_ambulance) or die(mysql_error());
	while($dat_ambulance = mysql_fetch_array($get_ambulance)){
		if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_semua)){
				if(!empty($dat_ambulance['ICD_CODE'])){
					$procedure = $procedure . trim($dat_ambulance['ICD_CODE']) . '#';
				}else{
					$procedure = $procedure . trim($dat_ambulance['KODE_TARIF']) . '#';
				}
		}
		//breakdown tarif_rs
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_prosedur_non_bedah)) $prosedur_non_bedah = $prosedur_non_bedah + $dat_ambulance['TARIF'];
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_prosedur_bedah)) $prosedur_bedah = $prosedur_bedah + $dat_ambulance['TARIF'];
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_konsultasi)) $konsultasi = $konsultasi + $dat_ambulance['TARIF'];
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_tenaga_ahli)) $tenaga_ahli = $tenaga_ahli + $dat_ambulance['TARIF'];
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_keperawatan)) $keperawatan = $keperawatan + $dat_ambulance['TARIF'];
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_penunjang)) $penunjang = $penunjang + $dat_ambulance['TARIF'];
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_radiologi)) $radiologi = $radiologi + $dat_ambulance['TARIF'];
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_laboratorium)) $laboratorium = $laboratorium + $dat_ambulance['TARIF'];
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_pelayanan_darah)) $pelayanan_darah = $pelayanan_darah + $dat_ambulance['TARIF'];
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_rehabilitasi)) $rehabilitasi = $rehabilitasi + $dat_ambulance['TARIF'];
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_kamar)) $kamar = $kamar + $dat_ambulance['TARIF'];
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_sewa_alat)) $sewa_alat = $sewa_alat + $dat_ambulance['TARIF'];
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_eksekutif)) $tarif_poli_eks = $tarif_poli_eks + $dat_ambulance['TARIF'];
		//
		$temp_tarif_rs = $temp_tarif_rs + $dat_ambulance['TARIF'];
	}
	$procedure = substr($procedure,0,strlen($procedure) - 1);	
					
	$ls_irja_id = '0,';
	$sql_irja_id = 'SELECT IRJA_ID FROM t_irja
					WHERE NOMR = "' . $nomr . '"
					AND JENIS_BAYAR_ID = "' . $jns_bayar . '"
					AND DATE_FORMAT(TANGGAL_DAFTAR,"%Y-%m-%d") = "' . $tanggal . '"
					AND NO_PENDAFTARAN IS NOT NULL AND ST_BATAL IS NULL';
	$get_irja_id = mysql_query($sql_irja_id) or die(mysql_error());
	while($dat_irja_id = mysql_fetch_array($get_irja_id)){
		$ls_irja_id = $ls_irja_id . $dat_irja_id['IRJA_ID'] . ',';
	}
	$ls_irja_id = substr($ls_irja_id,0,strlen($ls_irja_id) - 1);
	
	$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
	mysql_select_db($database_3, $connect_3) or die(mysql_error());

	$sql_farmasi = 'SELECT t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,
					SUM((t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR * t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL)
					- ((t_farmasi_apotik_pengeluaran.PERSEN_JAMINAN/100) * 
					(t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR * t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL))) AS HARGA,
					m_persediaan_farmasi.ALKES,
					m_persediaan_farmasi.PERSEDIAAN_GROUP_ID,
					m_persediaan_farmasi.PERSEDIAAN_KATEGORI_ID
					FROM t_rajal_resep 
					INNER JOIN t_rajal_resep_detail ON (t_rajal_resep.RAJAL_RESEP_ID = t_rajal_resep_detail.RAJAL_RESEP_ID)
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_rajal_resep_detail.RAJAL_RESEP_DETAIL_ID = t_farmasi_apotik_pengeluaran_detail.RAJAL_RESEP_DETAIL_ID)
					INNER JOIN t_farmasi_apotik_pengeluaran ON (t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID = t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID)
					INNER JOIN m_persediaan_farmasi ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					WHERE t_rajal_resep.RAJAL_ID IN (' . $ls_irja_id . ')
					AND t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR > 0
					GROUP BY t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID';	
	$get_farmasi = mysql_query($sql_farmasi) or die(mysql_error());
	while($dat_farmasi = mysql_fetch_array($get_farmasi)){
		if(in_array($dat_farmasi['PERSEDIAAN_GROUP_ID'],$arr_obat)) $obat = $obat + $dat_farmasi['HARGA'];
		if(in_array($dat_farmasi['PERSEDIAAN_GROUP_ID'],$arr_alkes)) $alkes = $alkes + $dat_farmasi['HARGA'];
		if(in_array($dat_farmasi['PERSEDIAAN_GROUP_ID'],$arr_bmhp)) $bmhp = $bmhp + $dat_farmasi['HARGA'];
		
		if(in_array($dat_farmasi['PERSEDIAAN_KATEGORI_ID'],$arr_obat_kemoterapi)) $obat_kemoterapi = $obat_kemoterapi + $dat_farmasi['HARGA'];
		if(in_array($dat_farmasi['PERSEDIAAN_KATEGORI_ID'],$arr_obat_kronis)) $obat_kronis = $obat_kronis + $dat_farmasi['HARGA'];
		
		$temp_tarif_rs = $temp_tarif_rs + $dat_farmasi['HARGA'];
	}	
	
	$obat = $obat - $obat_kemoterapi - $obat_kronis;
	//** end rawat jalan **//				
}else{
	//** rawat inap **//
	$sql_rawat = 'SELECT t_irna.NO_PESERTA,
				CASE WHEN t_irja.PASIEN_MASUK IS NOT NULL THEN DATE_FORMAT(t_irja.PASIEN_MASUK,"%Y-%m-%d") 
				ELSE DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y-%m-%d") END AS TGL_MASUK,
				DATE_FORMAT(t_irna.PASIEN_KELUAR,"%Y-%m-%d %H:%i:%s") AS TGL_PULANG,
				t_irna.KELAS_JAMINAN AS KELAS_RAWAT,
				m_pasien.BERAT_LAHIR,
				t_irna.PASIEN_PULANG_ID,
				m_pegawai.NAMA_PEGAWAI,
				m_pasien.NAMA_PASIEN,
				CASE WHEN UPPER(m_ruang.JNS_PERAWATAN) = "KUSTA" THEN "BP" 
				ELSE "CP" END KODE_TARIF,
				m_kelas_rawat.BOBOT AS BOBOT_JAMINAN,
				m_kelas_rawat2.BOBOT AS BOBOT_RAWAT,
				DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y-%m-%d") AS TGL_DAFTAR,
				t_irna.ST_CODING_ERM
				FROM t_irna
				INNER JOIN m_pasien
				ON (t_irna.NOMR = m_pasien.NOMR)	
				INNER JOIN m_pegawai 
				ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				INNER JOIN m_ruang
				ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN t_irja
				ON (t_irna.IRNA_ID = t_irja.IRJA_ID)
				LEFT JOIN m_kelas_rawat 
				ON (t_irna.KELAS_JAMINAN = m_kelas_rawat.KELAS_RAWAT)
				LEFT JOIN m_kelas_rawat m_kelas_rawat2
				ON (t_irna.KELAS_RAWAT = m_kelas_rawat2.KELAS_RAWAT)
				WHERE t_irna.IRNA_ID = "' . $idx_rawat . '"';
	$get_rawat = mysql_query($sql_rawat) or die(mysql_error());
	$dat_rawat = mysql_fetch_assoc($get_rawat);
	$nama_pasien = $dat_rawat['NAMA_PASIEN'];
	$nomor_kartu = $dat_rawat['NO_PESERTA'];
	$tgl_masuk = $dat_rawat['TGL_MASUK'];
	$tgl_pulang = $dat_rawat['TGL_PULANG'];
	$kelas_rawat = $dat_rawat['KELAS_RAWAT'];
	$birth_weight = $dat_rawat['BERAT_LAHIR'];
	$discharge_status = $arr_discharge_status[$dat_rawat['PASIEN_PULANG_ID']];
	$nama_dokter = $dat_rawat['NAMA_PEGAWAI'];
	$kode_tarif = $dat_rawat['KODE_TARIF'];
	$tgl_daftar = $dat_rawat['TGL_DAFTAR'];
	$st_coding = $dat_rawat['ST_CODING_ERM'];

	if(!empty($dat_rawat['BOBOT_JAMINAN']) and !empty($dat_rawat['BOBOT_RAWAT'])){
		if($dat_rawat['BOBOT_RAWAT'] > $dat_rawat['BOBOT_JAMINAN']) $upgrade_class_ind = '1';
	}	
		
	if($st_coding == ''){
		$sql_diagnosa = 'SELECT * FROM 
				(SELECT t_irja_diagnosa.DIAGNOSA,t_irja_diagnosa.ICD_CODE,
				t_irja_diagnosa.DIAGNOSA_ORDER,1 AS ORD_RAWAT
				FROM t_irja_diagnosa
				INNER JOIN t_irja
				ON (t_irja_diagnosa.IRJA_ID = t_irja.IRJA_ID)
				WHERE t_irja.NOMR = "' . $nomr . '"
				AND t_irja.JENIS_BAYAR_ID = "' . $jns_bayar . '"
				AND DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y-%m-%d") = "' . $tgl_daftar . '"
				AND t_irja.NO_PENDAFTARAN IS NOT NULL 
				AND t_irja.ST_BATAL IS NULL
				AND t_irja_diagnosa.DIAGNOSA_ORDER < 4
				UNION
				SELECT t_irna_diagnosa.DIAGNOSA,t_irna_diagnosa.ICD_CODE,
				t_irna_diagnosa.DIAGNOSA_ORDER,2 AS ORD_RAWAT
				FROM t_irna_diagnosa
				WHERE t_irna_diagnosa.IRNA_ID = "' . $idx_rawat . '"
				AND t_irna_diagnosa.DIAGNOSA_ORDER < 4
				) t_diagnosa
				ORDER BY ORD_RAWAT,DIAGNOSA_ORDER';
	}else{
		$sql_diagnosa = 'SELECT * FROM 
				(SELECT t_irja_diagnosa.DIAGNOSA,t_irja_diagnosa.ICD_CODE,
				t_irja_diagnosa.DIAGNOSA_ORDER,1 AS ORD_RAWAT
				FROM t_irja_diagnosa
				INNER JOIN t_irja
				ON (t_irja_diagnosa.IRJA_ID = t_irja.IRJA_ID)
				WHERE t_irja.NOMR = "' . $nomr . '"
				AND t_irja.JENIS_BAYAR_ID = "' . $jns_bayar . '"
				AND DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y-%m-%d") = "' . $tgl_daftar . '"
				AND t_irja.NO_PENDAFTARAN IS NOT NULL 
				AND t_irja.ST_BATAL IS NULL
				AND t_irja_diagnosa.DIAGNOSA_ORDER < 4
				UNION
				SELECT t_irna_diagnosa_pulang.DIAGNOSA,t_irna_diagnosa_pulang.ICD_CODE,
				t_irna_diagnosa_pulang.DIAGNOSA_ORDER,2 AS ORD_RAWAT
				FROM t_irna_diagnosa_pulang
				WHERE t_irna_diagnosa_pulang.IRNA_ID = "' . $idx_rawat . '"
				AND t_irna_diagnosa_pulang.DIAGNOSA_ORDER < 4
				) t_diagnosa
				ORDER BY ORD_RAWAT,DIAGNOSA_ORDER';
	}			
	$get_diagnosa = mysql_query($sql_diagnosa) or die(mysql_error());
	while($dat_diagnosa = mysql_fetch_array($get_diagnosa)){
		if(!empty($dat_diagnosa['ICD_CODE'])){
			$diagnosa = $diagnosa . trim($dat_diagnosa['ICD_CODE']) . '#';
		}else{
			$diagnosa = $diagnosa . trim($dat_diagnosa['DIAGNOSA']) . '#';
		}
	}
	$diagnosa = substr($diagnosa,0,strlen($diagnosa) - 1);

	//irj
	$sql_tindakan = 'SELECT t_irja_tarif.ICD_CODE,
					m_tarif.KODE_TARIF,
					m_tarif.TARIF_NON_KELAS AS TARIF,
					m_tarif.KODE_TARIF_GROUP
					FROM t_irja_tarif
					INNER JOIN m_tarif 
					ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN t_irja
					ON (t_irja_tarif.IRJA_ID = t_irja.IRJA_ID)
					WHERE t_irja.NOMR = "' . $nomr . '"
					AND t_irja.JENIS_BAYAR_ID = "' . $jns_bayar . '"
					AND DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y-%m-%d") = "' . $tgl_daftar . '"
					AND t_irja.NO_PENDAFTARAN IS NOT NULL 
					AND t_irja.ST_BATAL IS NULL
					AND t_irja_tarif.NO_TARIF IS NOT NULL
					AND t_irja_tarif.ST_BAYAR = "Lunas"
					AND (m_tarif.MCU IS NULL OR m_tarif.MCU = "")';
	$get_tindakan = mysql_query($sql_tindakan) or die(mysql_error());
	while($dat_tindakan = mysql_fetch_array($get_tindakan)){
		if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_semua)){
				if(!empty($dat_tindakan['ICD_CODE'])){
					$procedure = $procedure . trim($dat_tindakan['ICD_CODE']) . '#';
				}else{
					$procedure = $procedure . trim($dat_tindakan['KODE_TARIF']) . '#';
				}
		}
		//breakdown tarif_rs
			if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_prosedur_non_bedah)) $prosedur_non_bedah = $prosedur_non_bedah + $dat_tindakan['TARIF'];
			if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_prosedur_bedah)) $prosedur_bedah = $prosedur_bedah + $dat_tindakan['TARIF'];
			if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_konsultasi)) $konsultasi = $konsultasi + $dat_tindakan['TARIF'];
			if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_tenaga_ahli)) $tenaga_ahli = $tenaga_ahli + $dat_tindakan['TARIF'];
			if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_keperawatan)) $keperawatan = $keperawatan + $dat_tindakan['TARIF'];
			if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_penunjang)) $penunjang = $penunjang + $dat_tindakan['TARIF'];
			if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_radiologi)) $radiologi = $radiologi + $dat_tindakan['TARIF'];
			if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_laboratorium)) $laboratorium = $laboratorium + $dat_tindakan['TARIF'];
			if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_pelayanan_darah)) $pelayanan_darah = $pelayanan_darah + $dat_tindakan['TARIF'];
			if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_rehabilitasi)) $rehabilitasi = $rehabilitasi + $dat_tindakan['TARIF'];
			if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_kamar)) $kamar = $kamar + $dat_tindakan['TARIF'];
			if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_sewa_alat)) $sewa_alat = $sewa_alat + $dat_tindakan['TARIF'];
			if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_eksekutif)) $tarif_poli_eks = $tarif_poli_eks + $dat_tindakan['TARIF'];
		//
		$temp_tarif_rs = $temp_tarif_rs + $dat_tindakan['TARIF'];
	}				
					
	$sql_penunjang = 'SELECT t_ipenunjang_tarif.ICD_CODE,
					m_tarif.KODE_TARIF,
					m_tarif.TARIF_NON_KELAS AS TARIF,
					m_tarif.KODE_TARIF_GROUP
					FROM t_ipenunjang_tarif
					INNER JOIN m_tarif 
					ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN t_ipenunjang 
					ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
					INNER JOIN t_irja 
					ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
					WHERE t_irja.NOMR = "' . $nomr . '"
					AND t_irja.JENIS_BAYAR_ID = "' . $jns_bayar . '"
					AND DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y-%m-%d") = "' . $tgl_daftar . '"
					AND t_irja.NO_PENDAFTARAN IS NOT NULL 
					AND t_irja.ST_BATAL IS NULL 
					AND (t_ipenunjang.JNS_ORDER = "IRJ" 
						OR t_ipenunjang.JNS_ORDER = "HRJ"
						OR t_ipenunjang.JNS_ORDER = "ORJ")
					AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
					AND t_ipenunjang_tarif.ST_BATAL IS NULL
					AND t_ipenunjang_tarif.ST_BAYAR = "Lunas"
					AND (m_tarif.MCU = "" OR m_tarif.MCU IS NULL)';	
	$get_penunjang = mysql_query($sql_penunjang) or die(mysql_error());
	while($dat_penunjang = mysql_fetch_array($get_penunjang)){
		if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_semua)){
			if(!empty($dat_penunjang['ICD_CODE'])){
				$procedure = $procedure . trim($dat_penunjang['ICD_CODE']) . '#';
			}else{
				$procedure = $procedure . trim($dat_penunjang['KODE_TARIF']) . '#';
			}
		}
		//breakdown tarif_rs
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_prosedur_non_bedah)) $prosedur_non_bedah = $prosedur_non_bedah + $dat_penunjang['TARIF'];
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_prosedur_bedah)) $prosedur_bedah = $prosedur_bedah + $dat_penunjang['TARIF'];
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_konsultasi)) $konsultasi = $konsultasi + $dat_penunjang['TARIF'];
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_tenaga_ahli)) $tenaga_ahli = $tenaga_ahli + $dat_penunjang['TARIF'];
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_keperawatan)) $keperawatan = $keperawatan + $dat_penunjang['TARIF'];
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_penunjang)) $penunjang = $penunjang + $dat_penunjang['TARIF'];
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_radiologi)) $radiologi = $radiologi + $dat_penunjang['TARIF'];
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_laboratorium)) $laboratorium = $laboratorium + $dat_penunjang['TARIF'];
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_pelayanan_darah)) $pelayanan_darah = $pelayanan_darah + $dat_penunjang['TARIF'];
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_rehabilitasi)) $rehabilitasi = $rehabilitasi + $dat_penunjang['TARIF'];
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_kamar)) $kamar = $kamar + $dat_penunjang['TARIF'];
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_sewa_alat)) $sewa_alat = $sewa_alat + $dat_penunjang['TARIF'];
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_eksekutif)) $tarif_poli_eks = $tarif_poli_eks + $dat_penunjang['TARIF'];
		//
		$temp_tarif_rs = $temp_tarif_rs + $dat_penunjang['TARIF'];
	}

	$sql_operasi = 'SELECT t_operasi_tarif.ICD_CODE,
					m_tarif.KODE_TARIF,
					CASE WHEN m_tarif_group.NON_KELAS = "1" THEN m_tarif.TARIF_NON_KELAS
					ELSE	
						CASE WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "3" THEN m_tarif.TARIF_KELAS_3 
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "2" THEN m_tarif.TARIF_KELAS_2
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "1" THEN m_tarif.TARIF_KELAS_1
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "UTAMA" THEN m_tarif.TARIF_KELAS_UTAMA
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "VIP" THEN m_tarif.TARIF_KELAS_UTAMA
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "UTAMA 2" THEN m_tarif.TARIF_KELAS_UTAMA_2
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "VVIP" THEN m_tarif.TARIF_KELAS_UTAMA_2
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "HCU" THEN m_tarif.TARIF_HCU
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "ICU" THEN m_tarif.TARIF_ICU
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "NICU" THEN m_tarif.TARIF_NICU
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "PICU" THEN m_tarif.TARIF_PICU
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "ICCU" THEN m_tarif.TARIF_ICCU
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "PERINA" THEN m_tarif.TARIF_PERINA
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "BAYI SEHAT" THEN m_tarif.TARIF_KELAS_PERINA_SEHAT
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "BAYI SAKIT" THEN m_tarif.TARIF_KELAS_PERINA_SAKIT
						END 
					END AS TARIF,
					m_tarif.KODE_TARIF_GROUP
					FROM t_operasi_tarif
					INNER JOIN m_tarif 
					ON (t_operasi_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group
					ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					INNER JOIN t_operasi 
					ON (t_operasi_tarif.OPERASI_ID = t_operasi.OPERASI_ID)
					INNER JOIN t_irja 
					ON (t_operasi.RAWAT_ID = t_irja.IRJA_ID)
					WHERE t_irja.NOMR = "' . $nomr . '"
					AND t_irja.JENIS_BAYAR_ID = "' . $jns_bayar . '"
					AND DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y-%m-%d") = "' . $tgl_daftar . '"
					AND t_operasi.JNS_ORDER = "IRJ" AND t_operasi.ST_MASUK = "1"
					AND t_operasi_tarif.NO_TARIF IS NOT NULL
					AND t_operasi_tarif.ST_BAYAR = "Lunas"';
	$get_operasi = mysql_query($sql_operasi) or die(mysql_error());
	while($dat_operasi = mysql_fetch_array($get_operasi)){
		if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_semua)){
			if(!empty($dat_operasi['ICD_CODE'])){
				$procedure = $procedure . trim($dat_operasi['ICD_CODE']) . '#';
			}else{
				$procedure = $procedure . trim($dat_operasi['KODE_TARIF']) . '#';
			}
		}	
		//breakdown tarif_rs
			if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_prosedur_non_bedah)) $prosedur_non_bedah = $prosedur_non_bedah + $dat_operasi['TARIF'];
			if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_prosedur_bedah)) $prosedur_bedah = $prosedur_bedah + $dat_operasi['TARIF'];
			if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_konsultasi)) $konsultasi = $konsultasi + $dat_operasi['TARIF'];
			if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_tenaga_ahli)) $tenaga_ahli = $tenaga_ahli + $dat_operasi['TARIF'];
			if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_keperawatan)) $keperawatan = $keperawatan + $dat_operasi['TARIF'];
			if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_penunjang)) $penunjang = $penunjang + $dat_operasi['TARIF'];
			if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_radiologi)) $radiologi = $radiologi + $dat_operasi['TARIF'];
			if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_laboratorium)) $laboratorium = $laboratorium + $dat_operasi['TARIF'];
			if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_pelayanan_darah)) $pelayanan_darah = $pelayanan_darah + $dat_operasi['TARIF'];
			if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_rehabilitasi)) $rehabilitasi = $rehabilitasi + $dat_operasi['TARIF'];
			if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_kamar)) $kamar = $kamar + $dat_operasi['TARIF'];
			if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_sewa_alat)) $sewa_alat = $sewa_alat + $dat_operasi['TARIF'];
			if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_eksekutif)) $tarif_poli_eks = $tarif_poli_eks + $dat_operasi['TARIF'];
		//
		$temp_tarif_rs = $temp_tarif_rs + $dat_operasi['TARIF'];
	}
	$procedure = substr($procedure,0,strlen($procedure) - 1);	
					
	$sql_hemodialisa = 'SELECT t_hemodialisa_tarif.ICD_CODE,
					m_tarif.KODE_TARIF,
					m_tarif.TARIF_NON_KELAS AS TARIF,
					m_tarif.KODE_TARIF_GROUP
					FROM t_hemodialisa_tarif
					INNER JOIN m_tarif 
					ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN t_hemodialisa 
					ON (t_hemodialisa_tarif.HEMODIALISA_ID = t_hemodialisa.HEMODIALISA_ID)
					INNER JOIN t_irja 
					ON (t_hemodialisa.RAWAT_ID = t_irja.IRJA_ID)
					WHERE t_irja.NOMR = "' . $nomr . '"
					AND t_irja.JENIS_BAYAR_ID = "' . $jns_bayar . '"
					AND DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y-%m-%d") = "' . $tgl_daftar . '"
					AND t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL 
					AND t_hemodialisa.JNS_ORDER = "IRJ"
					AND t_hemodialisa_tarif.NO_TARIF IS NOT NULL
					AND t_hemodialisa_tarif.ST_BATAL IS NULL
					AND t_hemodialisa_tarif.ST_BAYAR = "Lunas"';
	$get_hemodialisa = mysql_query($sql_hemodialisa) or die(mysql_error());
	while($dat_hemodialisa = mysql_fetch_array($get_hemodialisa)){
		if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_semua)){
			if(!empty($dat_hemodialisa['ICD_CODE'])){
				$procedure = $procedure . trim($dat_hemodialisa['ICD_CODE']) . '#';
			}else{
				$procedure = $procedure . trim($dat_hemodialisa['KODE_TARIF']) . '#';
			}
		}	
		//breakdown tarif_rs
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_prosedur_non_bedah)) $prosedur_non_bedah = $prosedur_non_bedah + $dat_hemodialisa['TARIF'];
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_prosedur_bedah)) $prosedur_bedah = $prosedur_bedah + $dat_hemodialisa['TARIF'];
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_konsultasi)) $konsultasi = $konsultasi + $dat_hemodialisa['TARIF'];
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_tenaga_ahli)) $tenaga_ahli = $tenaga_ahli + $dat_hemodialisa['TARIF'];
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_keperawatan)) $keperawatan = $keperawatan + $dat_hemodialisa['TARIF'];
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_penunjang)) $penunjang = $penunjang + $dat_hemodialisa['TARIF'];
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_radiologi)) $radiologi = $radiologi + $dat_hemodialisa['TARIF'];
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_laboratorium)) $laboratorium = $laboratorium + $dat_hemodialisa['TARIF'];
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_pelayanan_darah)) $pelayanan_darah = $pelayanan_darah + $dat_hemodialisa['TARIF'];
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_rehabilitasi)) $rehabilitasi = $rehabilitasi + $dat_hemodialisa['TARIF'];
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_kamar)) $kamar = $kamar + $dat_hemodialisa['TARIF'];
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_sewa_alat)) $sewa_alat = $sewa_alat + $dat_hemodialisa['TARIF'];
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_eksekutif)) $tarif_poli_eks = $tarif_poli_eks + $dat_hemodialisa['TARIF'];
		//
		$temp_tarif_rs = $temp_tarif_rs + $dat_hemodialisa['TARIF'];
	}
	$procedure = substr($procedure,0,strlen($procedure) - 1);

	$sql_ambulance = 'SELECT "" AS ICD_CODE,
					m_tarif.KODE_TARIF,
					m_tarif.TARIF_NON_KELAS AS TARIF,
					m_tarif.KODE_TARIF_GROUP
					FROM t_ambulance_tarif
					INNER JOIN m_tarif 
					ON (t_ambulance_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN t_irja
					ON (t_ambulance_tarif.RAWAT_ID = t_irja.IRJA_ID)
					WHERE t_irja.NOMR = "' . $nomr . '"
					AND t_irja.JENIS_BAYAR_ID = "' . $jns_bayar . '"
					AND DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y-%m-%d") = "' . $tgl_daftar . '"
					AND t_irja.NO_PENDAFTARAN IS NOT NULL 
					AND t_irja.ST_BATAL IS NULL
					AND t_ambulance_tarif.JNS_ORDER = "IRJ" 
					AND t_ambulance_tarif.NO_TARIF IS NOT NULL
					AND t_ambulance_tarif.ST_BAYAR = "Lunas"';
	$get_ambulance = mysql_query($sql_ambulance) or die(mysql_error());
	while($dat_ambulance = mysql_fetch_array($get_ambulance)){
		if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_semua)){
				if(!empty($dat_ambulance['ICD_CODE'])){
					$procedure = $procedure . trim($dat_ambulance['ICD_CODE']) . '#';
				}else{
					$procedure = $procedure . trim($dat_ambulance['KODE_TARIF']) . '#';
				}
		}
		//breakdown tarif_rs
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_prosedur_non_bedah)) $prosedur_non_bedah = $prosedur_non_bedah + $dat_ambulance['TARIF'];
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_prosedur_bedah)) $prosedur_bedah = $prosedur_bedah + $dat_ambulance['TARIF'];
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_konsultasi)) $konsultasi = $konsultasi + $dat_ambulance['TARIF'];
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_tenaga_ahli)) $tenaga_ahli = $tenaga_ahli + $dat_ambulance['TARIF'];
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_keperawatan)) $keperawatan = $keperawatan + $dat_ambulance['TARIF'];
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_penunjang)) $penunjang = $penunjang + $dat_ambulance['TARIF'];
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_radiologi)) $radiologi = $radiologi + $dat_ambulance['TARIF'];
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_laboratorium)) $laboratorium = $laboratorium + $dat_ambulance['TARIF'];
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_pelayanan_darah)) $pelayanan_darah = $pelayanan_darah + $dat_ambulance['TARIF'];
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_rehabilitasi)) $rehabilitasi = $rehabilitasi + $dat_ambulance['TARIF'];
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_kamar)) $kamar = $kamar + $dat_ambulance['TARIF'];
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_sewa_alat)) $sewa_alat = $sewa_alat + $dat_ambulance['TARIF'];
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_eksekutif)) $tarif_poli_eks = $tarif_poli_eks + $dat_ambulance['TARIF'];
		//
		$temp_tarif_rs = $temp_tarif_rs + $dat_ambulance['TARIF'];
	}
	$procedure = substr($procedure,0,strlen($procedure) - 1);	
					
	$ls_irja_id = '0,';
	$sql_irja_id = 'SELECT IRJA_ID FROM t_irja
					WHERE NOMR = "' . $nomr . '"
					AND JENIS_BAYAR_ID = "' . $jns_bayar . '"
					AND DATE_FORMAT(TANGGAL_DAFTAR,"%Y-%m-%d") = "' . $tgl_daftar . '"
					AND NO_PENDAFTARAN IS NOT NULL AND ST_BATAL IS NULL';
	$get_irja_id = mysql_query($sql_irja_id) or die(mysql_error());
	while($dat_irja_id = mysql_fetch_array($get_irja_id)){
		$ls_irja_id = $ls_irja_id . $dat_irja_id['IRJA_ID'] . ',';
	}
	$ls_irja_id = substr($ls_irja_id,0,strlen($ls_irja_id) - 1);
	
	$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
	mysql_select_db($database_3, $connect_3) or die(mysql_error());

	$sql_farmasi = 'SELECT t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,
					SUM((t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR * t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL)
					- ((t_farmasi_apotik_pengeluaran.PERSEN_JAMINAN/100) * 
					(t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR * t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL))) AS HARGA,
					m_persediaan_farmasi.ALKES,
					m_persediaan_farmasi.PERSEDIAAN_GROUP_ID,
					m_persediaan_farmasi.PERSEDIAAN_KATEGORI_ID
					FROM t_rajal_resep 
					INNER JOIN t_rajal_resep_detail ON (t_rajal_resep.RAJAL_RESEP_ID = t_rajal_resep_detail.RAJAL_RESEP_ID)
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_rajal_resep_detail.RAJAL_RESEP_DETAIL_ID = t_farmasi_apotik_pengeluaran_detail.RAJAL_RESEP_DETAIL_ID)
					INNER JOIN t_farmasi_apotik_pengeluaran ON (t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID = t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID)
					INNER JOIN m_persediaan_farmasi ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					WHERE t_rajal_resep.RAJAL_ID IN (' . $ls_irja_id . ')
					AND t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR > 0
					GROUP BY t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID';	
	$get_farmasi = mysql_query($sql_farmasi) or die(mysql_error());
	while($dat_farmasi = mysql_fetch_array($get_farmasi)){
		if(in_array($dat_farmasi['PERSEDIAAN_GROUP_ID'],$arr_obat)) $obat = $obat + $dat_farmasi['HARGA'];
		if(in_array($dat_farmasi['PERSEDIAAN_GROUP_ID'],$arr_alkes)) $alkes = $alkes + $dat_farmasi['HARGA'];
		if(in_array($dat_farmasi['PERSEDIAAN_GROUP_ID'],$arr_bmhp)) $bmhp = $bmhp + $dat_farmasi['HARGA'];
		
		if(in_array($dat_farmasi['PERSEDIAAN_KATEGORI_ID'],$arr_obat_kemoterapi)) $obat_kemoterapi = $obat_kemoterapi + $dat_farmasi['HARGA'];
		if(in_array($dat_farmasi['PERSEDIAAN_KATEGORI_ID'],$arr_obat_kronis)) $obat_kronis = $obat_kronis + $dat_farmasi['HARGA'];
		
		$temp_tarif_rs = $temp_tarif_rs + $dat_farmasi['HARGA'];
	}
	
	$obat = $obat - $obat_kemoterapi - $obat_kronis;
	//end irj	

	$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
	mysql_select_db($database, $connect) or die(mysql_error());
	
	$sql_tindakan = 'SELECT t_irna_tarif.ICD_CODE,m_tarif.KODE_TARIF,
					t_irna_tarif.KELAS_RAWAT,
					CASE WHEN m_tarif_group.NON_KELAS = "1" THEN m_tarif.TARIF_NON_KELAS
						ELSE	
							CASE WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "3" THEN m_tarif.TARIF_KELAS_3 
								WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "2" THEN m_tarif.TARIF_KELAS_2
								WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "1" THEN m_tarif.TARIF_KELAS_1
								WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "UTAMA" THEN m_tarif.TARIF_KELAS_UTAMA
								WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "VIP" THEN m_tarif.TARIF_KELAS_UTAMA
								WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "UTAMA 2" THEN m_tarif.TARIF_KELAS_UTAMA_2
								WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "VVIP" THEN m_tarif.TARIF_KELAS_UTAMA_2
								WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "HCU" THEN m_tarif.TARIF_HCU
								WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "ICU" THEN m_tarif.TARIF_ICU
								WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "NICU" THEN m_tarif.TARIF_NICU
								WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "PICU" THEN m_tarif.TARIF_PICU
								WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "ICCU" THEN m_tarif.TARIF_ICCU
								WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "PERINA" THEN m_tarif.TARIF_PERINA
								WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "BAYI SEHAT" THEN m_tarif.TARIF_KELAS_PERINA_SEHAT
								WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "BAYI SAKIT" THEN m_tarif.TARIF_KELAS_PERINA_SAKIT
							END 
					END AS TARIF,
					m_tarif.KODE_TARIF_GROUP
					FROM t_irna_tarif
					INNER JOIN m_tarif
					ON (t_irna_tarif.TARIF_ID =  m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group
					ON (m_tarif.KODE_TARIF_GROUP =  m_tarif_group.KODE_TARIF_GROUP)
					WHERE t_irna_tarif.IRNA_ID = "' . $idx_rawat . '"
					AND t_irna_tarif.NO_TARIF IS NOT NULL
					AND t_irna_tarif.ST_BAYAR = "Lunas"';
	$get_tindakan = mysql_query($sql_tindakan) or die(mysql_error());
	while($dat_tindakan = mysql_fetch_array($get_tindakan)){
		if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_semua)){
			if(!empty($dat_tindakan['ICD_CODE'])){
				$procedure = $procedure . trim($dat_tindakan['ICD_CODE']) . '#';
			}else{
				$procedure = $procedure . trim($dat_tindakan['KODE_TARIF']) . '#';
			}
		}
		//breakdown tarif_rs
			if(in_array($dat_tindakan['KELAS_RAWAT'],$arr_intensif)){
				if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_semua)) $rawat_intensif = $rawat_intensif + $dat_tindakan['TARIF'];
			}else{
				if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_prosedur_non_bedah)) $prosedur_non_bedah = $prosedur_non_bedah + $dat_tindakan['TARIF'];
				if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_prosedur_bedah)) $prosedur_bedah = $prosedur_bedah + $dat_tindakan['TARIF'];
				if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_konsultasi)) $konsultasi = $konsultasi + $dat_tindakan['TARIF'];
				if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_tenaga_ahli)) $tenaga_ahli = $tenaga_ahli + $dat_tindakan['TARIF'];
				if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_keperawatan)) $keperawatan = $keperawatan + $dat_tindakan['TARIF'];
				if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_penunjang)) $penunjang = $penunjang + $dat_tindakan['TARIF'];
				if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_radiologi)) $radiologi = $radiologi + $dat_tindakan['TARIF'];
				if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_laboratorium)) $laboratorium = $laboratorium + $dat_tindakan['TARIF'];
				if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_pelayanan_darah)) $pelayanan_darah = $pelayanan_darah + $dat_tindakan['TARIF'];
				if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_rehabilitasi)) $rehabilitasi = $rehabilitasi + $dat_tindakan['TARIF'];
				if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_kamar)) $kamar = $kamar + $dat_tindakan['TARIF'];
				if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_sewa_alat)) $sewa_alat = $sewa_alat + $dat_tindakan['TARIF'];
				if(in_array($dat_tindakan['KODE_TARIF_GROUP'],$arr_eksekutif)) $tarif_poli_eks = $tarif_poli_eks + $dat_tindakan['TARIF'];
			}
			
			$temp_tarif_rs = $temp_tarif_rs + $dat_tindakan['TARIF'];
		//	
	}				
	
	$sql_penunjang = 'SELECT t_ipenunjang_tarif.ICD_CODE,
					m_tarif.KODE_TARIF,
					m_tarif.TARIF_NON_KELAS AS TARIF,
					m_tarif.KODE_TARIF_GROUP
					FROM t_ipenunjang_tarif
					INNER JOIN m_tarif 
					ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN t_ipenunjang 
					ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
					WHERE t_ipenunjang.RAWAT_ID = "' . $idx_rawat . '"
					AND (t_ipenunjang.JNS_ORDER = "IRN" 
					OR t_ipenunjang.JNS_ORDER = "HRI" 
					OR t_ipenunjang.JNS_ORDER = "ORI") 
					AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
					AND t_ipenunjang_tarif.ST_BATAL IS NULL
					AND t_ipenunjang_tarif.ST_BAYAR = "Lunas"';	
	$get_penunjang = mysql_query($sql_penunjang) or die(mysql_error());
	while($dat_penunjang = mysql_fetch_array($get_penunjang)){
		if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_semua)){
			if(!empty($dat_penunjang['ICD_CODE'])){
				$procedure = $procedure . trim($dat_penunjang['ICD_CODE']) . '#';
			}else{
				$procedure = $procedure . trim($dat_penunjang['KODE_TARIF']) . '#';
			}
		}	
		//breakdown tarif_rs
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_prosedur_non_bedah)) $prosedur_non_bedah = $prosedur_non_bedah + $dat_penunjang['TARIF'];
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_prosedur_bedah)) $prosedur_bedah = $prosedur_bedah + $dat_penunjang['TARIF'];
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_konsultasi)) $konsultasi = $konsultasi + $dat_penunjang['TARIF'];
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_tenaga_ahli)) $tenaga_ahli = $tenaga_ahli + $dat_penunjang['TARIF'];
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_keperawatan)) $keperawatan = $keperawatan + $dat_penunjang['TARIF'];
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_penunjang)) $penunjang = $penunjang + $dat_penunjang['TARIF'];
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_radiologi)) $radiologi = $radiologi + $dat_penunjang['TARIF'];
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_laboratorium)) $laboratorium = $laboratorium + $dat_penunjang['TARIF'];
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_pelayanan_darah)) $pelayanan_darah = $pelayanan_darah + $dat_penunjang['TARIF'];
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_rehabilitasi)) $rehabilitasi = $rehabilitasi + $dat_penunjang['TARIF'];
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_kamar)) $kamar = $kamar + $dat_penunjang['TARIF'];
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_sewa_alat)) $sewa_alat = $sewa_alat + $dat_penunjang['TARIF'];
			if(in_array($dat_penunjang['KODE_TARIF_GROUP'],$arr_eksekutif)) $tarif_poli_eks = $tarif_poli_eks + $dat_penunjang['TARIF'];
		//
		$temp_tarif_rs = $temp_tarif_rs + $dat_penunjang['TARIF'];
	}					
	
	$sql_operasi = 'SELECT t_operasi_tarif.ICD_CODE,
					m_tarif.KODE_TARIF,
					t_operasi_tarif.KELAS_RAWAT,
					CASE WHEN m_tarif_group.NON_KELAS = "1" THEN m_tarif.TARIF_NON_KELAS
						ELSE	
							CASE WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "3" THEN m_tarif.TARIF_KELAS_3 
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "2" THEN m_tarif.TARIF_KELAS_2
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "1" THEN m_tarif.TARIF_KELAS_1
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "UTAMA" THEN m_tarif.TARIF_KELAS_UTAMA
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "VIP" THEN m_tarif.TARIF_KELAS_UTAMA
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "UTAMA 2" THEN m_tarif.TARIF_KELAS_UTAMA_2
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "VVIP" THEN m_tarif.TARIF_KELAS_UTAMA_2
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "HCU" THEN m_tarif.TARIF_HCU
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "ICU" THEN m_tarif.TARIF_ICU
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "NICU" THEN m_tarif.TARIF_NICU
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "PICU" THEN m_tarif.TARIF_PICU
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "ICCU" THEN m_tarif.TARIF_ICCU
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "PERINA" THEN m_tarif.TARIF_PERINA
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "BAYI SEHAT" THEN m_tarif.TARIF_KELAS_PERINA_SEHAT
								WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "BAYI SAKIT" THEN m_tarif.TARIF_KELAS_PERINA_SAKIT
							END 
					END AS TARIF,
					m_tarif.KODE_TARIF_GROUP
					FROM t_operasi_tarif
					INNER JOIN m_tarif 
					ON (t_operasi_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group
					ON (m_tarif.KODE_TARIF_GROUP =  m_tarif_group.KODE_TARIF_GROUP)
					INNER JOIN t_operasi 
					ON (t_operasi_tarif.OPERASI_ID = t_operasi.OPERASI_ID)
					WHERE t_operasi.RAWAT_ID = "' . $idx_rawat . '"
					AND (t_operasi.JNS_ORDER = "IRN" OR t_operasi.ST_MASUK = "2")
					AND t_operasi_tarif.NO_TARIF IS NOT NULL
					AND t_operasi_tarif.ST_BAYAR = "Lunas"';
	$get_operasi = mysql_query($sql_operasi) or die(mysql_error());
	while($dat_operasi = mysql_fetch_array($get_operasi)){
		if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_semua)){
			if(!empty($dat_operasi['ICD_CODE'])){
				$procedure = $procedure . trim($dat_operasi['ICD_CODE']) . '#';
			}else{
				$procedure = $procedure . trim($dat_operasi['KODE_TARIF']) . '#';
			}
		}	
		//breakdown tarif_rs
			//if(in_array($dat_operasi['KELAS_RAWAT'],$arr_intensif)){
			//	if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_semua)) $rawat_intensif = $rawat_intensif + $dat_operasi['TARIF'];
			//}else{
				if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_prosedur_non_bedah)) $prosedur_non_bedah = $prosedur_non_bedah + $dat_operasi['TARIF'];
				if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_prosedur_bedah)) $prosedur_bedah = $prosedur_bedah + $dat_operasi['TARIF'];
				if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_konsultasi)) $konsultasi = $konsultasi + $dat_operasi['TARIF'];
				if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_tenaga_ahli)) $tenaga_ahli = $tenaga_ahli + $dat_operasi['TARIF'];
				if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_keperawatan)) $keperawatan = $keperawatan + $dat_operasi['TARIF'];
				if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_penunjang)) $penunjang = $penunjang + $dat_operasi['TARIF'];
				if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_radiologi)) $radiologi = $radiologi + $dat_operasi['TARIF'];
				if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_laboratorium)) $laboratorium = $laboratorium + $dat_operasi['TARIF'];
				if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_pelayanan_darah)) $pelayanan_darah = $pelayanan_darah + $dat_operasi['TARIF'];
				if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_rehabilitasi)) $rehabilitasi = $rehabilitasi + $dat_operasi['TARIF'];
				if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_kamar)) $kamar = $kamar + $dat_operasi['TARIF'];
				if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_sewa_alat)) $sewa_alat = $sewa_alat + $dat_operasi['TARIF'];
				if(in_array($dat_operasi['KODE_TARIF_GROUP'],$arr_eksekutif)) $tarif_poli_eks = $tarif_poli_eks + $dat_operasi['TARIF'];
			//}
		//
		$temp_tarif_rs = $temp_tarif_rs + $dat_operasi['TARIF'];
	}
	$procedure = substr($procedure,0,strlen($procedure) - 1);
	
	$sql_hemodialisa = 'SELECT t_hemodialisa_tarif.ICD_CODE,
					m_tarif.KODE_TARIF,
					m_tarif.TARIF_NON_KELAS AS TARIF,
					m_tarif.KODE_TARIF_GROUP
					FROM t_hemodialisa_tarif
					INNER JOIN m_tarif 
					ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN t_hemodialisa 
					ON (t_hemodialisa_tarif.HEMODIALISA_ID = t_hemodialisa.HEMODIALISA_ID)
					WHERE t_hemodialisa.RAWAT_ID = "' . $idx_rawat . '"
					AND t_hemodialisa.JNS_ORDER = "IRN"
					AND t_hemodialisa_tarif.NO_TARIF IS NOT NULL
					AND t_hemodialisa_tarif.ST_BATAL IS NULL
					AND t_hemodialisa_tarif.ST_BAYAR = "Lunas"';
	$get_hemodialisa = mysql_query($sql_hemodialisa) or die(mysql_error());
	while($dat_hemodialisa = mysql_fetch_array($get_hemodialisa)){
		if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_semua)){
			if(!empty($dat_hemodialisa['ICD_CODE'])){
				$procedure = $procedure . trim($dat_hemodialisa['ICD_CODE']) . '#';
			}else{
				$procedure = $procedure . trim($dat_hemodialisa['KODE_TARIF']) . '#';
			}
		}	
		//breakdown tarif_rs
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_prosedur_non_bedah)) $prosedur_non_bedah = $prosedur_non_bedah + $dat_hemodialisa['TARIF'];
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_prosedur_bedah)) $prosedur_bedah = $prosedur_bedah + $dat_hemodialisa['TARIF'];
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_konsultasi)) $konsultasi = $konsultasi + $dat_hemodialisa['TARIF'];
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_tenaga_ahli)) $tenaga_ahli = $tenaga_ahli + $dat_hemodialisa['TARIF'];
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_keperawatan)) $keperawatan = $keperawatan + $dat_hemodialisa['TARIF'];
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_penunjang)) $penunjang = $penunjang + $dat_hemodialisa['TARIF'];
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_radiologi)) $radiologi = $radiologi + $dat_hemodialisa['TARIF'];
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_laboratorium)) $laboratorium = $laboratorium + $dat_hemodialisa['TARIF'];
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_pelayanan_darah)) $pelayanan_darah = $pelayanan_darah + $dat_hemodialisa['TARIF'];
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_rehabilitasi)) $rehabilitasi = $rehabilitasi + $dat_hemodialisa['TARIF'];
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_kamar)) $kamar = $kamar + $dat_hemodialisa['TARIF'];
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_sewa_alat)) $sewa_alat = $sewa_alat + $dat_hemodialisa['TARIF'];
			if(in_array($dat_hemodialisa['KODE_TARIF_GROUP'],$arr_eksekutif)) $tarif_poli_eks = $tarif_poli_eks + $dat_hemodialisa['TARIF'];
		//
		$temp_tarif_rs = $temp_tarif_rs + $dat_hemodialisa['TARIF'];
	}
	$procedure = substr($procedure,0,strlen($procedure) - 1);	
		
	$sql_ambulance = 'SELECT "" AS ICD_CODE,
					m_tarif.KODE_TARIF,
					m_tarif.TARIF_NON_KELAS AS TARIF,
					m_tarif.KODE_TARIF_GROUP
					FROM t_ambulance_tarif
					INNER JOIN m_tarif 
					ON (t_ambulance_tarif.TARIF_ID = m_tarif.TARIF_ID)
					WHERE t_ambulance_tarif.RAWAT_ID = "' . $idx_rawat . '"
					AND t_ambulance_tarif.JNS_ORDER = "IRN"
					AND t_ambulance_tarif.NO_TARIF IS NOT NULL
					AND t_ambulance_tarif.ST_BAYAR = "Lunas"';
	$get_ambulance = mysql_query($sql_ambulance) or die(mysql_error());
	while($dat_ambulance = mysql_fetch_array($get_ambulance)){
		if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_semua)){
				if(!empty($dat_ambulance['ICD_CODE'])){
					$procedure = $procedure . trim($dat_ambulance['ICD_CODE']) . '#';
				}else{
					$procedure = $procedure . trim($dat_ambulance['KODE_TARIF']) . '#';
				}
		}
		//breakdown tarif_rs
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_prosedur_non_bedah)) $prosedur_non_bedah = $prosedur_non_bedah + $dat_ambulance['TARIF'];
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_prosedur_bedah)) $prosedur_bedah = $prosedur_bedah + $dat_ambulance['TARIF'];
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_konsultasi)) $konsultasi = $konsultasi + $dat_ambulance['TARIF'];
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_tenaga_ahli)) $tenaga_ahli = $tenaga_ahli + $dat_ambulance['TARIF'];
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_keperawatan)) $keperawatan = $keperawatan + $dat_ambulance['TARIF'];
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_penunjang)) $penunjang = $penunjang + $dat_ambulance['TARIF'];
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_radiologi)) $radiologi = $radiologi + $dat_ambulance['TARIF'];
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_laboratorium)) $laboratorium = $laboratorium + $dat_ambulance['TARIF'];
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_pelayanan_darah)) $pelayanan_darah = $pelayanan_darah + $dat_ambulance['TARIF'];
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_rehabilitasi)) $rehabilitasi = $rehabilitasi + $dat_ambulance['TARIF'];
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_kamar)) $kamar = $kamar + $dat_ambulance['TARIF'];
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_sewa_alat)) $sewa_alat = $sewa_alat + $dat_ambulance['TARIF'];
			if(in_array($dat_ambulance['KODE_TARIF_GROUP'],$arr_eksekutif)) $tarif_poli_eks = $tarif_poli_eks + $dat_ambulance['TARIF'];
		//
		$temp_tarif_rs = $temp_tarif_rs + $dat_ambulance['TARIF'];
	}	
	
	$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
	mysql_select_db($database_3, $connect_3) or die(mysql_error());	
					
	$sql_farmasi = 'SELECT t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,
					SUM((t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR * t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL)
					- ((t_farmasi_apotik_pengeluaran.PERSEN_JAMINAN/100) * 
					(t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR * t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL))) AS HARGA,
					m_persediaan_farmasi.ALKES,
					m_persediaan_farmasi.PERSEDIAAN_GROUP_ID,
					m_persediaan_farmasi.PERSEDIAAN_KATEGORI_ID
					FROM t_ranap_resep 
					INNER JOIN t_ranap_resep_detail ON (t_ranap_resep.RANAP_RESEP_ID = t_ranap_resep_detail.RANAP_RESEP_ID)
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_ranap_resep_detail.RANAP_RESEP_DETAIL_ID = t_farmasi_apotik_pengeluaran_detail.RANAP_RESEP_DETAIL_ID)
					INNER JOIN t_farmasi_apotik_pengeluaran ON (t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID = t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID)
					INNER JOIN m_persediaan_farmasi ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					WHERE t_ranap_resep.RANAP_ID = "' . $idx_rawat . '"
					AND t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR > 0
					GROUP BY t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID';
	$get_farmasi = mysql_query($sql_farmasi) or die(mysql_error());
	while($dat_farmasi = mysql_fetch_array($get_farmasi)){
		if(in_array($dat_farmasi['PERSEDIAAN_GROUP_ID'],$arr_obat)) $obat = $obat + $dat_farmasi['HARGA'];
		if(in_array($dat_farmasi['PERSEDIAAN_GROUP_ID'],$arr_alkes)) $alkes = $alkes + $dat_farmasi['HARGA'];
		if(in_array($dat_farmasi['PERSEDIAAN_GROUP_ID'],$arr_bmhp)) $bmhp = $bmhp + $dat_farmasi['HARGA'];
		
		if(in_array($dat_farmasi['PERSEDIAAN_KATEGORI_ID'],$arr_obat_kemoterapi)) $obat_kemoterapi = $obat_kemoterapi + $dat_farmasi['HARGA'];
		if(in_array($dat_farmasi['PERSEDIAAN_KATEGORI_ID'],$arr_obat_kronis)) $obat_kronis = $obat_kronis + $dat_farmasi['HARGA'];
		
		$temp_tarif_rs = $temp_tarif_rs + $dat_farmasi['HARGA'];
	}	
	
	$obat = $obat - $obat_kemoterapi - $obat_kronis;
	//** end rawat inap **/				
}

$tarif_rs = $prosedur_non_bedah + $prosedur_bedah + $konsultasi + $tenaga_ahli + $keperawatan + $penunjang + $radiologi +
			$laboratorium + $pelayanan_darah + $rehabilitasi + $kamar + $rawat_intensif + $obat + $obat_kronis + 
			$obat_kemoterapi + $alkes + $bmhp + $sewa_alat + $tarif_poli_eks; 				
?>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<table width="100%" border="0">
	<tr>
		<td>Nomor MR</td><td>:</td><td><?php echo formatNoMR($nomr); ?></td>
		<td>Nama Pasien</td><td>:</td><td><?php echo $nama_pasien; ?></td>
	</tr>
	<tr>
		<td>Nomor SEP Baru</td><td>:</td><td><input type="text" name="nomor_sep" id="nomor_sep" value="<?php echo $nomor_sep; ?>" class="text_dt" size="30"/></td>
		<td>Nomor SEP Lama</td><td>:</td><td><input type="text" name="nomor_sep_lama" id="nomor_sep_lama" value="<?php echo $nomor_sep_lama; ?>" class="text_dt" size="30"/></td>
	</tr>
	<tr>
		<td>Nomor Kartu</td><td>:</td><td><input type="text" name="nomor_kartu" id="nomor_kartu" value="<?php echo $nomor_kartu; ?>" class="text_dt" size="30"/></td>
		<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
	</tr>
	<tr>
		<td>Tanggal Masuk</td><td>:</td><td><input type="text" name="tgl_masuk" id="tgl_masuk" value="<?php echo $tgl_masuk; ?>" class="text_dt" size="30"/></td>
		<td>Tanggal Pulang</td><td>:</td><td><input type="text" name="tgl_pulang" id="tgl_pulang" value="<?php echo $tgl_pulang; ?>" class="text_dt" size="30"/><td>
	</tr>	
	<tr>
		<td>Jenis Rawat</td><td>:</td><td><input type="text" name="jenis_rawat" id="jenis_rawat" value="<?php echo $jenis_rawat; ?>" class="text_dt" size="30"/></td>
		<td>Kelas Rawat</td><td>:</td><td><input type="text" name="kelas_rawat" id="kelas_rawat" value="<?php echo $kelas_rawat; ?>" class="text_dt" size="30"/><td>
	</tr>
	<tr>
		<td>Adl Sub Acute</td><td>:</td><td>
		<select name="adl_sub_acute" id="adl_sub_acute" class="text_dt" style="width:210px;">
		<option value="" <?php if($adl_sub_acute == '') echo 'selected="selected"'; ?> ></option>
		<?php
		$asa = 12;
		while($asa <=60){ ?>	
		<option value="<?php echo $asa; ?>" <?php if($adl_sub_acute == $asa) echo 'selected="selected"'; ?> ><?php echo $asa; ?></option>
		<?php $asa++; } ?>
		</select>
		</td>
		<td>Adl Chronic</td><td>:</td>
		<td>
		<select name="adl_chronic" id="adl_chronic" class="text_dt" style="width:210px;">
		<option value="" <?php if($adl_chronic == '') echo 'selected="selected"'; ?> ></option>
		<?php
		$ach = 12;
		while($ach <=60){ ?>	
		<option value="<?php echo $ach; ?>" <?php if($adl_chronic == $ach) echo 'selected="selected"'; ?> ><?php echo $ach; ?></option>
		<?php $ach++; } ?>
		</select>
		</td>
	</tr>
	<tr>
		<td>ICU Indikator</td><td>:</td><td><input type="text" name="icu_indikator" id="icu_indikator" value="<?php echo $icu_indikator; ?>" class="text_dt" size="30"/></td>
		<td>ICU Los</td><td>:</td><td><input type="text" name="icu_los" id="icu_los" value="<?php echo $icu_los; ?>" class="text_dt" size="30"/></td>
	</tr>
	
	<tr>
		<td>Ventilator Hour</td><td>:</td><td><input type="text" name="ventilator_hour" id="ventilator_hour" value="<?php echo $ventilator_hour; ?>" class="text_dt" size="30"/></td>
		<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
	</tr>
	<tr>
		<td>Upgrade Class Ind</td><td>:</td><td><input type="text" name="upgrade_class_ind" id="upgrade_class_ind" value="<?php echo $upgrade_class_ind; ?>" class="text_dt" size="30"/></td>
		<td>Upgrade Class Class</td><td>:</td><td><input type="text" name="upgrade_class_class" id="upgrade_class_class" value="<?php echo $upgrade_class_class; ?>" class="text_dt" size="30"/></td>
	</tr>
	<tr>
		<td>Upgrade Class Los</td><td>:</td><td><input type="text" name="upgrade_class_los" id="upgrade_class_los" value="<?php echo $upgrade_class_los; ?>" class="text_dt" size="30"/></td>
		<td>Add Payment Pct</td><td>:</td><td><input type="text" name="add_payment_pct" id="add_payment_pct" value="<?php echo $add_payment_pct; ?>" class="text_dt" size="30"/></td>
	</tr>
	<tr>
		<td>Birth Weight</td><td>:</td><td><input type="text" name="birth_weight" id="birth_weight" value="<?php echo $birth_weight; ?>" class="text_dt" size="30"/></td>
		<td>Discharge Status</td><td>:</td><td><input type="text" name="discharge_status" id="discharge_status" value="<?php echo $discharge_status; ?>" class="text_dt" size="30"/></td>
	</tr>		
	<tr>
		<td>Diagnosa</td><td>:</td><td colspan="4"><input type="text" name="diagnosa" id="diagnosa" value="<?php echo $diagnosa; ?>" class="text_dt" size="100"/></td>
	</tr>		
	<tr>
		<td>Procedure</td><td>:</td><td colspan="4"><input type="text" name="procedure" id="procedure" value="<?php echo $procedure; ?>" class="text_dt" size="100"/></td>
	</tr>	
	<tr>
		<td valign="top">Tarif RS</td><td valign="top">:</td><td colspan="4"><table width="90%" border="0">
          <tr>
            <td width="25%"><div onclick="open_def_report('prosedur non bedah','1');" style="cursor: pointer;" title="Klik untuk definisi">Procedure Non Bedah</div></td>
            <td width="25%"><input type="text" name="prosedur_non_bedah" id="prosedur_non_bedah" value="<?php echo $prosedur_non_bedah; ?>" class="text_dt" size="30"/></td>
            <td width="25%"><div onclick="open_def_report('prosedur bedah','1');" style="cursor: pointer;" title="Klik untuk definisi">Procedure Bedah</div></td>
            <td width="25%"><input type="text" name="prosedur_bedah" id="prosedur_bedah" value="<?php echo $prosedur_bedah; ?>" class="text_dt" size="30"/></td>
          </tr>
          <tr>
            <td><div onclick="open_def_report('konsultasi','1');" style="cursor: pointer;" title="Klik untuk definisi">Konsultasi</div></td>
            <td><input type="text" name="konsultasi" id="konsultasi" value="<?php echo $konsultasi; ?>" class="text_dt" size="30"/></td>
            <td><div onclick="open_def_report('tenaga ahli','1');" style="cursor: pointer;" title="Klik untuk definisi">Tenaga Ahli</div></td>
            <td><input type="text" name="tenaga_ahli" id="tenaga_ahli" value="<?php echo $tenaga_ahli; ?>" class="text_dt" size="30"/></td>
          </tr>
          <tr>
            <td><div onclick="open_def_report('keperawatan','1');" style="cursor: pointer;" title="Klik untuk definisi">Keperawatan</div></td>
            <td><input type="text" name="keperawatan" id="keperawatan" value="<?php echo $keperawatan; ?>" class="text_dt" size="30"/></td>
            <td><div onclick="open_def_report('penunjang','1');" style="cursor: pointer;" title="Klik untuk definisi">Penunjang</div></td>
            <td><input type="text" name="penunjang" id="penunjang" value="<?php echo $penunjang; ?>" class="text_dt" size="30"/></td>
          </tr>
          <tr>
            <td><div onclick="open_def_report('radiologi','1');" style="cursor: pointer;" title="Klik untuk definisi">Radiologi</div></td>
            <td><input type="text" name="radiologi" id="radiologi" value="<?php echo $radiologi; ?>" class="text_dt" size="30"/></td>
            <td><div onclick="open_def_report('laboratorium','1');" style="cursor: pointer;" title="Klik untuk definisi">Laboratorium</div></td>
            <td><input type="text" name="laboratorium" id="laboratorium" value="<?php echo $laboratorium; ?>" class="text_dt" size="30"/></td>
          </tr>
          <tr>
            <td><div onclick="open_def_report('pelayanan darah','1');" style="cursor: pointer;" title="Klik untuk definisi">Pelayanan Darah</div></td>
            <td><input type="text" name="pelayanan_darah" id="pelayanan_darah" value="<?php echo $pelayanan_darah; ?>" class="text_dt" size="30"/></td>
            <td><div onclick="open_def_report('rehabilitasi','1');" style="cursor: pointer;" title="Klik untuk definisi">Rehabilitasi</div></td>
            <td><input type="text" name="rehabilitasi" id="rehabilitasi" value="<?php echo $rehabilitasi; ?>" class="text_dt" size="30"/></td>
          </tr>
          <tr>
            <td><div onclick="open_def_report('kamar','1');" style="cursor: pointer;" title="Klik untuk definisi">Kamar</div></td>
            <td><input type="text" name="kamar" id="kamar" value="<?php echo $kamar; ?>" class="text_dt" size="30"/></td>
            <td>Rawat Intensif</td>
            <td><input type="text" name="rawat_intensif" id="rawat_intensif" value="<?php echo $rawat_intensif; ?>" class="text_dt" size="30"/></td>
          </tr>
          <tr>
            <td><div onclick="open_def_report_obat('obat','1');" style="cursor: pointer;" title="Klik untuk definisi">Obat</div></td>
            <td><input type="text" name="obat" id="obat" value="<?php echo $obat; ?>" class="text_dt" size="30"/></td>
            <td><div onclick="open_def_report_obat('obat kronis','2');" style="cursor: pointer;" title="Klik untuk definisi">Obat Kronis</div></td>
            <td><input type="text" name="obat_kronis" id="obat_kronis" value="<?php echo $obat_kronis; ?>" class="text_dt" size="30"/></td>
          </tr>
		  <tr>
            <td><div onclick="open_def_report_obat('obat kemoterapi','2');" style="cursor: pointer;" title="Klik untuk definisi">Obat Kemoterapi</div></td>
            <td><input type="text" name="obat_kemoterapi" id="obat_kemoterapi" value="<?php echo $obat_kemoterapi; ?>" class="text_dt" size="30"/></td>
            <td><div onclick="open_def_report_obat('alkes','1');" style="cursor: pointer;" title="Klik untuk definisi">Alkes</div></td>
            <td><input type="text" name="alkes" id="alkes" value="<?php echo $alkes; ?>" class="text_dt" size="30"/></td>
          </tr>
          <tr>
            <td><div onclick="open_def_report_obat('bmhp','1');" style="cursor: pointer;" title="Klik untuk definisi">BMHP</div></td>
            <td><input type="text" name="bmhp" id="bmhp" value="<?php echo $bmhp; ?>" class="text_dt" size="30"/></td>
            <td><div onclick="open_def_report('sewa alat','1');" style="cursor: pointer;" title="Klik untuk definisi">Sewa Alat</div></td>
            <td><input type="text" name="sewa_alat" id="sewa_alat" value="<?php echo $sewa_alat; ?>" class="text_dt" size="30"/></td>
          </tr>
		  <tr>
            <td><div onclick="open_def_report('eksekutif','1');" style="cursor: pointer;" title="Klik untuk definisi">Tarif Poli Eks</div></td>
            <td><input type="text" name="tarif_poli_eks" id="tarif_poli_eks" value="<?php echo $tarif_poli_eks; ?>" class="text_dt" size="30"/></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
	</tr>
	<tr>
		<td>Total Tarif RS</td><td>:</td><td><input type="text" name="tarif_rs" id="tarif_rs" value="<?php echo $tarif_rs; ?>" class="text_dt" size="30" readonly/></td>
		<td colspan="3"><?php if($tarif_rs != $temp_tarif_rs) echo '(' . $temp_tarif_rs . ' ? )'; ?></td>
	</tr>
	<tr>
		<td valign="top">Covid-19</td><td valign="top">:</td><td colspan="4"><table width="90%" border="0">
		<tr>
		<td width="25%">Pemulasaraan Jenazah</td>
		<td width="25%"><input type="checkbox" name="pemulasaraan_jenazah" id="pemulasaraan_jenazah" value="1" <?php if($pemulasaraan_jenazah == '1') echo 'checked'; ?> /></td>
		<td width="25%">Kantong Jenazah</td><td width="25%"><input type="checkbox" name="kantong_jenazah" id="kantong_jenazah" value="1" <?php if($kantong_jenazah == '1') echo 'checked'; ?> /></td>
	</tr>
	<tr>
		<td>Peti Jenazah</td>
		<td><input type="checkbox" name="peti_jenazah" id="peti_jenazah" value="1" <?php if($peti_jenazah == '1') echo 'checked'; ?> /></td>
		<td>Plastik Erat</td>
		<td><input type="checkbox" name="plastik_erat" id="plastik_erat" value="1" <?php if($plastik_erat == '1') echo 'checked'; ?> /></td>
	</tr>
	<tr>
		<td>Desinfektan Jenazah</td>
		<td><input type="checkbox" name="desinfektan_jenazah" id="desinfektan_jenazah" value="1" <?php if($desinfektan_jenazah == '1') echo 'checked'; ?> /></td>
		<td>Mobil Jenazah</td><td><input type="checkbox" name="mobil_jenazah" id="mobil_jenazah" value="1" <?php if($mobil_jenazah == '1') echo 'checked'; ?> /></td>
	</tr>
	<tr>
		<td>Desinfektan Mobil Jenazah</td>
		<td><input type="checkbox" name="desinfektan_mobil_jenazah" id="desinfektan_mobil_jenazah" value="1" <?php if($desinfektan_mobil_jenazah == '1') echo 'checked'; ?> /></td>
		<td>&nbsp;</td><td>&nbsp;</td>
	</tr>
	<tr>
		<td>Status</td>
		<td><select name="covid19_status_cd" id="covid19_status_cd" class="text_dt" style="width:210px;">
		<option value=""></option>
		<option value="1" <?php if($covid19_status_cd == '1') echo 'selected="selected"'; ?> >ODP</option>
		<option value="2" <?php if($covid19_status_cd == '2') echo 'selected="selected"'; ?> >PDP</option>
		<option value="3" <?php if($covid19_status_cd == '3') echo 'selected="selected"'; ?> >Terkonfirmasi Positif</option>
		</select></td>
		<td>&nbsp;</td><td>&nbsp;</td>
	</tr>
	<tr>
		<td>Nomor Kartu</td>
		<td><select name="nomor_kartu_t" id="nomor_kartu_t" class="text_dt" style="width:210px;">
		<option value=""></option>
		<option value="nik" <?php if($nomor_kartu_t == 'nik') echo 'selected="selected"'; ?> >NIK</option>
		<option value="kitas" <?php if($nomor_kartu_t == 'kitas') echo 'selected="selected"'; ?> >KITAS/ KITAP</option>
		<option value="paspor" <?php if($nomor_kartu_t == 'paspor') echo 'selected="selected"'; ?> >Passport</option>
		<option value="kartu_jkn" <?php if($nomor_kartu_t == 'kartu_jkn') echo 'selected="selected"'; ?> >JKN</option>
		<option value="lainnya" <?php if($nomor_kartu_t == 'lainnya') echo 'selected="selected"'; ?> >Lainnya</option>
		</select></td>
		<td>&nbsp;</td><td>&nbsp;</td>
	</tr>
	 <tr>
            <td>Episodes</td>
            <td colspan="3"><input type="text" name="episodes" id="episodes" value="<?php echo $episodes; ?>" class="text_dt" size="60"/></td>
          </tr>
	<tr>
		<td>Comorbidity/ Complexity</td>
		<td><input type="checkbox" name="covid19_cc_ind" id="covid19_cc_ind" value="1" <?php if($covid19_cc_ind == '1') echo 'checked'; ?> /></td>
		<td>&nbsp;</td><td>&nbsp;</td>
	</tr>	  
		</table></td>
	</tr>	
	<tr>
		<td>Nama Dokter</td><td>:</td><td><input type="text" name="nama_dokter" id="nama_dokter" value="<?php echo $nama_dokter; ?>" class="text_dt" size="30"/></td>
		<td>Kode Tarif</td><td>:</td>
		<td>
		<select name="kode_tarif" id="kode_tarif" class="text_dt" style="width:210px;">
		<option value="CP" <?php if($kode_tarif == 'CP') echo 'selected="selected"'; ?> >CP</option>
		<option value="BP" <?php if($kode_tarif == 'BP') echo 'selected="selected"'; ?> >BP</option>
		<option value="AP" <?php if($kode_tarif == 'AP') echo 'selected="selected"'; ?> >AP</option>
		</select>
		</td>
	</tr>
	<tr>
		<td>Payor Id</td><td>:</td><td><input type="text" name="payor_id" id="payor_id" value="<?php echo $payor_id; ?>" class="text_dt" size="30"/></td>
		<td>Payor CD</td><td>:</td><td><input type="text" name="payor_cd" id="payor_cd" value="<?php echo $payor_cd; ?>" class="text_dt" size="30"/></td>
	</tr>
	<tr>
		<td>Cob CD</td><td>:</td><td>
		<select name="cob_cd" id="cob_cd" class="text_dt" style="width:210px;">
		<option value="#" <?php if($cob_cd == '') echo 'selected="selected"'; ?> ></option>
		<option value="0001" <?php if($cob_cd == '0001') echo 'selected="selected"'; ?> >MANDIRI INHEALTH</option>
		</select>
		</td>
		<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
	</tr>
	<tr>
		<td>Coder NIK</td><td>:</td><td>
		<input type="text" name="coder_nik" id="coder_nik" value="<?php echo $coder_nik; ?>" class="text_dt" size="30"/>
		</td>
		<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
	</tr>	
</table>
<input type="hidden" name="idx_rawat" id="idx_rawat" value="<?php echo $idx_rawat; ?>" />
<input type="hidden" name="jns_rawat" id="jns_rawat" value="<?php echo $jenis_rawat; ?>" />
<input type="hidden" name="jns_bayar" id="jns_bayar" value="<?php echo $jns_bayar; ?>" />
<input type="hidden" name="svrmh" id="svrmh" value="<?php echo $svrmh; ?>" />
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<table width="100%" border="0">	
	<tr>
		<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
		<td>&nbsp;</td>
		<td align="right"><image id="loader" src="/nsimrs/sep/image/loading_circle_green.gif" height="20px" width="20px" style="display:none" /></td>
		<td align="right" width="200px"><input type="button" class="myButton" value="isi & update data klaim" onclick="klaim_update('<?php echo $svrmh; ?>');"  />
		<input type="button" class="myButton" value="tutup" onclick="window.close();"  /></td>
	</tr>
</table>	
</div>
<script>
function open_def_report(filter,lvl){
	var win = window.open('index.php?link=cf4b9acb3a3f9ce0bac95e7606adda05&repid=<?php echo $report_id; ?>&repname=Eklaim&nmfilter=' + filter + '&lvl=' + lvl, '_blank');
  win.focus();
}

function open_def_report_obat(filter,lvl){
	var win = window.open('index.php?link=7af2ccfb3cfa39f04efa801b035c3e03&repid=<?php echo $report_id; ?>&repname=Eklaim&nmfilter=' + filter + '&lvl=' + lvl, '_blank');
  win.focus();
}
</script>
<?php } ?>