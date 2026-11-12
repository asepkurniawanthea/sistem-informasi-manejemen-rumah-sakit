<?php
function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = str_replace('|','!',$str);
	$ret = htmlspecialchars($ret);
	return $ret;
}

if (isset($_POST['irna_id'])){
	$st_save = true;
	if($st_save){
		$st_final = 'NULL';
		if(isset($_POST['final'])) $st_final = '"1"';

		$status_pasien_pulang = array('keadaan'=>((isset($_POST['keadaan_pulang'])) ? $_POST['keadaan_pulang'] : ''),
						'lanjut'=>((isset($_POST['lanjut_pengobatan'])) ? $_POST['lanjut_pengobatan'] : ''),
						'lanjut_ket'=>replace_quote($_POST['lanjut_pengobatan_ket']),
						'kontrol'=>replace_quote($_POST['kontrol']));
		$status_pasien_pulang = json_encode($status_pasien_pulang);
		$status_pasien_pulang = str_replace('"','|',$status_pasien_pulang);
		
		if(empty($_POST['idx'])){		
			mysql_query('INSERT INTO t_irna_resume_medis (IRNA_ID,ALASAN_DIRAWAT,RINGKASAN_RIWAYAT_PENYAKIT,PEMERIKSAAN_FISIK,
				PEMERIKSAAN_PENUNJANG,PEMERIKSAAN_LABORATORIUM,PEMERIKSAAN_RADIOLOGI,
				TERAPI,HASIL_KONSULTASI,TINDAKAN,ALERGI,HASIL_LABORATORIUM,DIET,FOLLOW_UP,STATUS_KELUAR,
				TERAPI_PULANG,TIM_DOKTER,SEBAB_KEMATIAN,TRANSPORTASI_PULANG,TUJUAN_PULANG,
				TGL_ASSESMENT,FINAL,REGISTER) 
				VALUES ("' . $_POST['irna_id'] . '","' . replace_quote($_POST['alasan_dirawat']) . '",
				"' . replace_quote($_POST['ringkasan_riwayat_penyakit']) . '",
				"' . replace_quote($_POST['pemeriksaan_fisik']) . '",
				"' . replace_quote($_POST['pemeriksaan_penunjang']) . '",
				"' . replace_quote($_POST['pemeriksaan_laboratorium']) . '",
				"' . replace_quote($_POST['pemeriksaan_radiologi']) . '",
				"' . replace_quote($_POST['terapi']) . '",
				"' . replace_quote($_POST['hasil_konsultasi']) . '",
				"' . replace_quote($_POST['tindakan']) . '",
				"' . replace_quote($_POST['alergi']) . '",
				"' . replace_quote($_POST['hasil_laboratorium']) . '",
				"' . replace_quote($_POST['diet']) . '",
				"' . replace_quote($_POST['follow_up']) . '",
				"' . $status_pasien_pulang . '",
				"' . replace_quote($_POST['terapi_pulang']) . '",
				"' . ((isset($_POST['tim_dokter'])) ? '1':'') . '",
				"' . replace_quote($_POST['sebab_kematian']) . '",
				"' . ((isset($_POST['transportasi_pulang'])) ? $_POST['transportasi_pulang'] : '') . '",
				"' . ((isset($_POST['tujuan_pulang'])) ? $_POST['tujuan_pulang'] : '') . '",
				NOW(),' . $st_final . ',"' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '")') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_irna_resume_medis 
				SET ALASAN_DIRAWAT = "' . replace_quote($_POST['alasan_dirawat']) . '",
				RINGKASAN_RIWAYAT_PENYAKIT = "' . replace_quote($_POST['ringkasan_riwayat_penyakit']) . '",
				PEMERIKSAAN_FISIK = "' . replace_quote($_POST['pemeriksaan_fisik']) . '",
				PEMERIKSAAN_PENUNJANG = "' . replace_quote($_POST['pemeriksaan_penunjang']) . '",
				PEMERIKSAAN_LABORATORIUM = "' . replace_quote($_POST['pemeriksaan_laboratorium']) . '",
				PEMERIKSAAN_RADIOLOGI = "' . replace_quote($_POST['pemeriksaan_radiologi']) . '",
				TERAPI = "' . replace_quote($_POST['terapi']) . '",
				HASIL_KONSULTASI = "' . replace_quote($_POST['hasil_konsultasi']) . '",
				TINDAKAN = "' . replace_quote($_POST['tindakan']) . '",
				ALERGI = "' . replace_quote($_POST['alergi']) . '",
				HASIL_LABORATORIUM = "' . replace_quote($_POST['hasil_laboratorium']) . '",
				DIET = "' . replace_quote($_POST['diet']) . '",
				FOLLOW_UP = "' . replace_quote($_POST['follow_up']) . '",
				STATUS_KELUAR = "' . $status_pasien_pulang . '",
				TERAPI_PULANG = "' . replace_quote($_POST['terapi_pulang']) . '",
				TIM_DOKTER = "' . ((isset($_POST['tim_dokter'])) ? '1':'') . '",
				SEBAB_KEMATIAN = "' . replace_quote($_POST['sebab_kematian']) . '",
				TRANSPORTASI_PULANG = "' . ((isset($_POST['transportasi_pulang'])) ? $_POST['transportasi_pulang'] : '') . '",
				TUJUAN_PULANG = "' . ((isset($_POST['tujuan_pulang'])) ? $_POST['tujuan_pulang'] : '') . '",
				TGL_ASSESMENT = NOW(),
				FINAL = ' . $st_final . ',
				REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '"
				WHERE IRNA_ID = "' . $_POST['irna_id'] . '"') or die(mysql_error());
		}
		
		mysql_query('UPDATE t_irna SET PASIEN_PULANG_ID = "' . ((isset($_POST['keadaan_pulang'])) ? $_POST['keadaan_pulang'] : '') . '", 
				LANJUT_PENGOBATAN = "' . ((isset($_POST['lanjut_pengobatan'])) ? $_POST['lanjut_pengobatan'] : '') . '",
				TGL_KONTROL_POLIKLINIK = STR_TO_DATE("' . $_POST['kontrol'] . '","%d/%m/%Y"),
				ST_CREATE_ERM_RM = NULL
				WHERE IRNA_ID = "' . $_POST['irna_id']  . '"') or die(mysql_error());
	
		mysql_query('DELETE FROM t_irna_diagnosa_pulang WHERE IRNA_ID = "' . $_POST['irna_id'] . '"') or die(mysql_error());
		$d=0;
		while($d <= 7){
			if(!empty($_POST['diagnosa_'. $d])){
				$icd_code = '';
				$diagnosa = replace_quote($_POST['diagnosa_'. $d]);
				$arr_diagnosa = explode('--',$diagnosa);
				if(sizeof($arr_diagnosa) == 2){
					$icd_code = $arr_diagnosa[0];
					$diagnosa = $arr_diagnosa[1];
				}
				mysql_query('INSERT INTO t_irna_diagnosa_pulang (IRNA_ID,DIAGNOSA_ORDER,DIAGNOSA,ICD_CODE) 
					VALUES("' . $_POST['irna_id'] . '","' . $d . '","' . $diagnosa . '","' . $icd_code . '")') or die(mysql_error());
			}
		$d++;
		}
		
		/*
		include('lib/vendor/autoload.php');
		include('lib/html2openxml/HTMLtoOpenXML.php');
		include('edoc_rekammedik/new/erm_create_resume_medis.php');
		erm_resume_medis($_POST['irna_id'],$_POST['ls_assesment'],$_POST['tgl_skr'],$_POST['ls_final']);
		*/
		?>
		<script language="JavaScript" >
			alert('Simpan Resume Medis Berhasil.');
			window.location = "<?php echo currentUrl(); ?>";
		</script>
		<?php 
	}else{
		$msg_info = 'Harus Oleh Dokter DPJP.';
	}	
}
$qry_pasien = 'SELECT IRNA_ID,ALASAN_DIRAWAT,RINGKASAN_RIWAYAT_PENYAKIT,PEMERIKSAAN_FISIK,PEMERIKSAAN_PENUNJANG,
			PEMERIKSAAN_LABORATORIUM,PEMERIKSAAN_RADIOLOGI,TERAPI,
			HASIL_KONSULTASI,ALERGI,HASIL_LABORATORIUM,DIET,FOLLOW_UP,STATUS_KELUAR,TERAPI_PULANG,
			FINAL,DATE_FORMAT(TGL_ASSESMENT,"%d/%m/%Y") AS TGL_ASSESMENT,
			DATE_FORMAT(NOW(),"%d/%m/%Y") AS TGL_SKR,
			TINDAKAN,TIM_DOKTER,SEBAB_KEMATIAN,TRANSPORTASI_PULANG,TUJUAN_PULANG,
			REGISTER,DATE_FORMAT(TGL_ASSESMENT,"%d-%m-%Y %H:%i") AS REGISTER_DT
			FROM t_irna_resume_medis
			WHERE IRNA_ID = "' . $idx . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$idx_rsm = $dat_pasien['IRNA_ID'];
$alasan_dirawat = $dat_pasien['ALASAN_DIRAWAT'];
$ringkasan_riwayat_penyakit = $dat_pasien['RINGKASAN_RIWAYAT_PENYAKIT'];
$pemeriksaan_fisik = $dat_pasien['PEMERIKSAAN_FISIK'];
$pemeriksaan_penunjang = $dat_pasien['PEMERIKSAAN_PENUNJANG'];
$pemeriksaan_laboratorium = $dat_pasien['PEMERIKSAAN_LABORATORIUM'];
$pemeriksaan_radiologi = $dat_pasien['PEMERIKSAAN_RADIOLOGI'];
$terapi = $dat_pasien['TERAPI'];
$hasil_konsultasi = $dat_pasien['HASIL_KONSULTASI'];
$alergi = $dat_pasien['ALERGI'];
$hasil_laboratorium = $dat_pasien['HASIL_LABORATORIUM'];
$diet = $dat_pasien['DIET'];
$tindakan = $dat_pasien['TINDAKAN'];
$follow_up = $dat_pasien['FOLLOW_UP'];
$terapi_pulang = $dat_pasien['TERAPI_PULANG'];
$sebab_kematian = $dat_pasien['SEBAB_KEMATIAN'];
$transportasi_pulang = $dat_pasien['TRANSPORTASI_PULANG'];
$tujuan_pulang = $dat_pasien['TUJUAN_PULANG'];
$status_keluar = str_replace('|','"',$dat_pasien['STATUS_KELUAR']);
$status_keluar = preg_replace('/\r|\n/','\n',trim($status_keluar));
$status_keluar = json_decode($status_keluar,true);

$keadaan_pulang = ((isset($status_keluar['keadaan'])) ? $status_keluar['keadaan'] : '');
$lanjut_pengobatan = ((isset($status_keluar['lanjut'])) ? $status_keluar['lanjut'] : '');
$lanjut_pengobatan_ket = ((isset($status_keluar['lanjut_ket'])) ? $status_keluar['lanjut_ket'] : '');
$tgl_kontrol = ((isset($status_keluar['kontrol'])) ? $status_keluar['kontrol'] : '');

$tim_dokter = $dat_pasien['TIM_DOKTER'];
$final = $dat_pasien['FINAL'];
$tgl_assesment = $dat_pasien['TGL_ASSESMENT'];
$tgl_skr = $dat_pasien['TGL_SKR'];
$register = $dat_pasien['REGISTER'] . ' ' . $dat_pasien['REGISTER_DT'];

$qry_diagnosa = 'SELECT DIAGNOSA_ORDER,DIAGNOSA,ICD_CODE
		FROM t_irna_diagnosa_pulang
		WHERE IRNA_ID = "' . $idx . '"
		ORDER BY DIAGNOSA_ORDER';
$get_diagnosa = mysql_query($qry_diagnosa) or die(mysql_error());
if(mysql_num_rows($get_diagnosa) > 0){
	$d=0;
	$diagnosa = array();
	while($dat_diagnosa= mysql_fetch_array($get_diagnosa)){
		if($dat_diagnosa['ICD_CODE'] != ''){
			$diagnosa[$dat_diagnosa['DIAGNOSA_ORDER']]=$dat_diagnosa['ICD_CODE'] . '--' . $dat_diagnosa['DIAGNOSA'];
		}else{
			$diagnosa[$dat_diagnosa['DIAGNOSA_ORDER']]=$dat_diagnosa['DIAGNOSA'];
		}	
	$d++;
	}
}else{
	$qry_diagnosa = 'SELECT DIAGNOSA_ORDER,DIAGNOSA
		FROM t_irna_diagnosa
		WHERE IRNA_ID = "' . $idx . '"
		ORDER BY DIAGNOSA_ORDER';
	$get_diagnosa = mysql_query($qry_diagnosa) or die(mysql_error());
	$d=0;
	$diagnosa = array();
	while($dat_diagnosa= mysql_fetch_array($get_diagnosa)){
		$diagnosa[$dat_diagnosa['DIAGNOSA_ORDER']]=$dat_diagnosa['DIAGNOSA'];
	$d++;
	}
}	

if($pam == '38' or $pam == '') $qry_pengkajian_awal = 'SELECT ANAMNESIS_RIWAYAT_PENYAKIT_SEKARANG,PEMERIKSAAN AS PEMERIKSAAN_FISIK,RENCANA_TATALAKSANA AS TERAPI FROM t_irna_pengkajian_awal_medis WHERE IRNA_ID = "' . $idx . '"';
if($pam == '5') $qry_pengkajian_awal = 'SELECT ANAMNESIS_RIWAYAT_PENYAKIT_SEKARANG,PEMERIKSAAN AS PEMERIKSAAN_FISIK,TERAPI FROM t_irna_pengkajian_awal_medis_gigi WHERE IRNA_ID = "' . $idx . '"';
if($pam == '29') $qry_pengkajian_awal = 'SELECT ANAMNESIS_RIWAYAT_PENYAKIT_SEKARANG,PEMERIKSAAN AS PEMERIKSAAN_FISIK,RENCANA_TATALAKSANA AS TERAPI FROM t_irna_pengkajian_awal_medis_mata WHERE IRNA_ID = "' . $idx . '"';
if($pam == '35') $qry_pengkajian_awal = 'SELECT ANAMNESIS_RIWAYAT_PENYAKIT_SEKARANG,PEMERIKSAAN AS PEMERIKSAAN_FISIK,RENCANA_TATALAKSANA AS TERAPI FROM t_irna_pengkajian_awal_medis_kusta WHERE IRNA_ID = "' . $idx . '"';
$get_pengkajian_awal = mysql_query($qry_pengkajian_awal) or die(mysql_error());
$dat_pengkajian_awal = mysql_fetch_assoc($get_pengkajian_awal);
$pkj_ringkasan_riwayat_penyakit = $dat_pengkajian_awal['ANAMNESIS_RIWAYAT_PENYAKIT_SEKARANG'];
$pkj_pemeriksaan_fisik = str_replace('|','"',$dat_pengkajian_awal['PEMERIKSAAN_FISIK']);
$pkj_pemeriksaan_fisik = preg_replace('/\r|\n/','\n',trim($pkj_pemeriksaan_fisik));
$pkj_pemeriksaan_fisik = json_decode($pkj_pemeriksaan_fisik,true);
$pkj_terapi = $dat_pengkajian_awal['TERAPI'];

$pkj_pemeriksaan_fisik_des = 'Keadaan umum : ' . ((isset($pkj_pemeriksaan_fisik['pm_keadaan_umum'])) ? $pkj_pemeriksaan_fisik['pm_keadaan_umum'] : '') . ', '; 
$pkj_pemeriksaan_fisik_des .= 'TD : ' . ((isset($pkj_pemeriksaan_fisik['pm_td'])) ? $pkj_pemeriksaan_fisik['pm_td'] : '') . 'mmHg, ';	
$pkj_pemeriksaan_fisik_des .= 'GCS : E' . ((isset($pkj_pemeriksaan_fisik['pm_gcs_e'])) ? $pkj_pemeriksaan_fisik['pm_gcs_e'] : '') . ' M' . ((isset($pkj_pemeriksaan_fisik['pm_gcs_m'])) ? $pkj_pemeriksaan_fisik['pm_gcs_m'] : '') . ' V' . ((isset($pkj_pemeriksaan_fisik['pm_gcs_v'])) ? $pkj_pemeriksaan_fisik['pm_gcs_v'] : '') . ', ';
$pkj_pemeriksaan_fisik_des .= 'Nadi : ' . ((isset($pkj_pemeriksaan_fisik['pm_nadi'])) ? $pkj_pemeriksaan_fisik['pm_nadi'] : '') . '/menit ' . ((isset($pemeriksaan_fisik['pm_nadi_teratur']) and $pemeriksaan_fisik['pm_nadi_teratur']=='1') ? 'Teratur' : '') . ((isset($pemeriksaan_fisik['pm_nadi_teratur']) and $pemeriksaan_fisik['pm_nadi_teratur']=='2') ? 'Tidak teratur' : '') .  ', ';	
$pkj_pemeriksaan_fisik_des .= 'Suhu : ' . ((isset($pkj_pemeriksaan_fisik['pm_suhu'])) ? $pkj_pemeriksaan_fisik['pm_suhu'] : '') . '&#8451;, ';		
$pkj_pemeriksaan_fisik_des .= 'TB : ' . ((isset($pkj_pemeriksaan_fisik['pm_tb'])) ? $pkj_pemeriksaan_fisik['pm_tb'] : '') . 'cm, ';
$pkj_pemeriksaan_fisik_des .= 'BB : ' . ((isset($pkj_pemeriksaan_fisik['pm_bb'])) ? $pkj_pemeriksaan_fisik['pm_bb'] : '') . 'kg, ';
$pkj_pemeriksaan_fisik_des .= 'RR : ' . ((isset($pkj_pemeriksaan_fisik['pm_rr'])) ? $pkj_pemeriksaan_fisik['pm_rr'] : '') . 'x/menit, ';
$pkj_pemeriksaan_fisik_des .= 'Kepala : ' . ((isset($pkj_pemeriksaan_fisik['pm_kepala'])) ? $pkj_pemeriksaan_fisik['pm_kepala'] : '') . ', ';
$pkj_pemeriksaan_fisik_des .= 'Leher : ' . ((isset($pkj_pemeriksaan_fisik['pm_leher'])) ? $pkj_pemeriksaan_fisik['pm_leher'] : '') . ', ';
$pkj_pemeriksaan_fisik_des .= 'Jantung : ' . ((isset($pkj_pemeriksaan_fisik['pm_jantung'])) ? $pkj_pemeriksaan_fisik['pm_jantung'] : '') . ', ';
$pkj_pemeriksaan_fisik_des .= 'Paru : ' . ((isset($pkj_pemeriksaan_fisik['pm_paru'])) ? $pkj_pemeriksaan_fisik['pm_paru'] : '') . ', ';
$pkj_pemeriksaan_fisik_des .= 'Abdomen : ' . ((isset($pkj_pemeriksaan_fisik['pm_abdomen'])) ? $pkj_pemeriksaan_fisik['pm_abdomen'] : '') . ', ';
$pkj_pemeriksaan_fisik_des .= 'Extremitas : ' . ((isset($pkj_pemeriksaan_fisik['pm_extremitas'])) ? $pkj_pemeriksaan_fisik['pm_extremitas'] : '');
?>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#diagnosa_0").autocomplete("index.php?autocomp=autocompresumemedisdiagnosa",{width: 760});
		jQuery("#diagnosa_1").autocomplete("index.php?autocomp=autocompresumemedisdiagnosa",{width: 760});
		jQuery("#diagnosa_2").autocomplete("index.php?autocomp=autocompresumemedisdiagnosa",{width: 760});
		jQuery("#diagnosa_3").autocomplete("index.php?autocomp=autocompresumemedisdiagnosa",{width: 760});
		jQuery("#diagnosa_4").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 760});
		jQuery("#diagnosa_5").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 760});
		jQuery("#diagnosa_6").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 760});
		jQuery("#diagnosa_7").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 760});
    });
</script>
<form name="search" id="search" method="post">
    <input type="hidden" name="idx" id="idx" value="<?php echo $idx_rsm; ?>" />	
	<input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />	
	<input type="hidden" name="ls_assesment" id="ls_assesment" value="<?php echo $tgl_assesment; ?>" />	
	<input type="hidden" name="ls_final" id="ls_final" value="<?php echo $final; ?>" />	
	<input type="hidden" name="tgl_skr" id="tgl_skr" value="<?php echo $tgl_skr; ?>" />
	<table border="0" align="center" style="position:static; " width="90%">
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">Tanggal Masuk</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><?php echo ((in_array($pasien_masuk_un,getArrUnitIGD())) ? $pasien_masuk_rs : $pasien_masuk_rg); ?></td>
		</tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">Tanggal Keluar</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><?php echo $pasien_keluar_rg; ?></td>
		</tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">Dokter yang mengirim</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><?php echo $nama_dokter_rj; ?></td>
		</tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">Dokter yang merawat (DPJP)</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><?php echo $nama_dokter; ?></td>
		</tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">Rawat Tim Dokter</td>
			<td valign="top" width="10px">:</td>
			<td width="50px;"><input type="checkbox" name="tim_dokter" value="1" <?php if($tim_dokter == '1') echo 'checked'; ?> />&nbsp;Ya</td>
			<td colspan="4"><?php $dokter_merawat = '';
			if($nama_dokter_rawat != '') $dokter_merawat = $nama_dokter_rawat . ', ';
			if($nama_dokter_rawat_2 != '') $dokter_merawat .= $nama_dokter_rawat_2 . ', ';
			if($nama_dokter_rawat_3 != '') $dokter_merawat .= $nama_dokter_rawat_3 . ', ';
			echo 'Oleh : ' . substr($dokter_merawat,0,strlen($dokter_merawat) -2); ?></td>
		</tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">Penanggung jawab pembayaran</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><?php echo $jns_pembayaran; ?></td>
		</tr>
		<?php 
			$diagnosis = '';
			$qry_diagnosis = 'SELECT DIAGNOSA_ORDER,DIAGNOSA
				FROM t_irna_diagnosa
				WHERE IRNA_ID = "' . $idx . '"
				AND DIAGNOSA_ORDER <= 3
				ORDER BY DIAGNOSA_ORDER';
			$get_diagnosis = mysql_query($qry_diagnosis) or die(mysql_error());
			while($dat_diagnosis = mysql_fetch_array($get_diagnosis)){
				$diagnosis .= $dat_diagnosis['DIAGNOSA'] . ',';	
			}
			$diagnosis = substr($diagnosis,0,strlen($diagnosis)-1);
		?>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">Diagnosis</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><?php echo $diagnosis; ?></td>
		</tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">Alasan Masuk Dirawat</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><textarea name="alasan_dirawat" class="text_dt10" ><?php echo $alasan_dirawat; ?></textarea></td>
		</tr>	
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Ringkasan Riwayat Penyakit</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="ringkasan_riwayat_penyakit" class="text_dt11" ><?php echo (($ringkasan_riwayat_penyakit == '') ? $pkj_ringkasan_riwayat_penyakit : $ringkasan_riwayat_penyakit); ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Pemeriksaan Fisik</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="pemeriksaan_fisik" class="text_dt11" ><?php echo (($pemeriksaan_fisik == '') ? $pkj_pemeriksaan_fisik_des : $pemeriksaan_fisik); ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Pemeriksaan Penunjang/ Diagnostik Terpenting</td>
			<td valign="top">:</td>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Laboratorium</td>
			<td colspan="5"><textarea name="pemeriksaan_laboratorium" class="text_dt11" ><?php echo $pemeriksaan_laboratorium; ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Radiologi</td>
			<td colspan="5"><textarea name="pemeriksaan_radiologi" class="text_dt11" ><?php echo $pemeriksaan_radiologi; ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Penunjang Lain</td>
			<td colspan="5"><textarea name="pemeriksaan_penunjang" class="text_dt11" ><?php echo $pemeriksaan_penunjang; ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Terapi/ Pengobatan Selama di RS. Sitanala</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="terapi" class="text_dt11" ><?php echo (($terapi == '') ? $pkj_terapi : $terapi); ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Hasil Konsultasi</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="hasil_konsultasi" class="text_dt11" ><?php echo $hasil_konsultasi; ?></textarea></td>
		</tr>
		<tr>
            <td>&nbsp;</td>
			<td valign="top" rowspan="4">Diagnosa</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="diagnosa_0" id="diagnosa_0" value="<?php echo ((isset($diagnosa[0])) ? $diagnosa[0] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5"><input type="text" name="diagnosa_1" id="diagnosa_1" value="<?php echo ((isset($diagnosa[1])) ? $diagnosa[1] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5"><input type="text" name="diagnosa_2" id="diagnosa_2" value="<?php echo ((isset($diagnosa[2])) ? $diagnosa[2] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5"><input type="text" name="diagnosa_3" id="diagnosa_3" value="<?php echo ((isset($diagnosa[3])) ? $diagnosa[3] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
            <td valign="top" rowspan="4">Diagnosa Banding</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="diagnosa_4" id="diagnosa_4" value="<?php echo ((isset($diagnosa[4])) ? $diagnosa[4] : ''); ?>" class="text_dt" style="width:755px;" ></td></tr>
			<tr><td>&nbsp;</td><td>&nbsp;</td><td colspan="5"><input type="text" name="diagnosa_5" id="diagnosa_5" value="<?php echo ((isset($diagnosa[5])) ? $diagnosa[5] : ''); ?>" class="text_dt" style="width:755px;" ></td></tr>
			<tr><td>&nbsp;</td><td>&nbsp;</td><td colspan="5"><input type="text" name="diagnosa_6" id="diagnosa_6" value="<?php echo ((isset($diagnosa[6])) ? $diagnosa[6] : ''); ?>" class="text_dt" style="width:755px;" ></td></tr>
			<tr><td>&nbsp;</td><td>&nbsp;</td><td colspan="5"><input type="text" name="diagnosa_7" id="diagnosa_7" value="<?php echo ((isset($diagnosa[7])) ? $diagnosa[7] : ''); ?>" class="text_dt" style="width:755px;" ></td></tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Penyebab Kematian (Secara Klinis)</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="sebab_kematian" class="text_dt11" ><?php echo $sebab_kematian; ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Tindakan/ Prosedur</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="tindakan" class="text_dt11" ><?php echo $tindakan; ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Alergi</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="alergi" class="text_dt11" ><?php echo $alergi; ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Hasil Laboratorium belum selesai (pending)</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="hasil_laboratorium" class="text_dt11" ><?php echo $hasil_laboratorium; ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Diet</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="diet" class="text_dt11" ><?php echo $diet; ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Intruksi/ Anjuran dan Edukasi (Follow Up)</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="follow_up" class="text_dt11" ><?php echo $follow_up; ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Kondisi Waktu Keluar</td>
			<td valign="top">:</td>
			<td colspan="5">
			<?php
				$qry_pulang = 'SELECT * FROM m_pasien_pulang WHERE IRNA = "1"';
				$get_pulang = mysql_query($qry_pulang) or die(mysql_error());
				while($dat_pulang = mysql_fetch_array($get_pulang)){ ?>
					<input type="radio" name="keadaan_pulang" value="<?php echo $dat_pulang['PASIEN_PULANG_ID']; ?>" <?php if($keadaan_pulang == $dat_pulang['PASIEN_PULANG_ID']) echo 'checked'; ?> />&nbsp;<?php echo $dat_pulang['KET_PASIEN_PULANG']; ?>&nbsp;&nbsp;&nbsp;	
			<?php	
			}
			?>	
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Pengobatan Dilanjutkan</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="radio" name="lanjut_pengobatan" value="1" <?php if($lanjut_pengobatan == '1') echo 'checked'; ?> />&nbsp;Poliklinik&nbsp;&nbsp;&nbsp;
			<input type="radio" name="lanjut_pengobatan" value="2" <?php if($lanjut_pengobatan == '2') echo 'checked'; ?> />&nbsp;RS Lain&nbsp;&nbsp;&nbsp;
			<input type="radio" name="lanjut_pengobatan" value="3" <?php if($lanjut_pengobatan == '3') echo 'checked'; ?> />&nbsp;Puskesmas&nbsp;&nbsp;&nbsp;
			<input type="radio" name="lanjut_pengobatan" value="4" <?php if($lanjut_pengobatan == '4') echo 'checked'; ?> />&nbsp;Dokter Luar&nbsp;&nbsp;&nbsp;
			<input type="radio" name="lanjut_pengobatan" value="5" <?php if($lanjut_pengobatan == '5') echo 'checked'; ?> />&nbsp;<input type="text" name="lanjut_pengobatan_ket" class="text_dt" style="width:200px;" value="<?php echo $lanjut_pengobatan_ket; ?>" /></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Tanggal Kontrol Poliklinik</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="kontrol" id="tgl_1" class="text_dt" value="<?php echo $tgl_kontrol; ?>" /><img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Terapi Pulang</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="terapi_pulang" class="text_dt11" ><?php echo $terapi_pulang; ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Transportasi Pulang</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="radio" name="transportasi_pulang" value="1" <?php if($transportasi_pulang == '1') echo 'checked'; ?> />&nbsp;Kendaraan Pribadi&nbsp;&nbsp;&nbsp;
			<input type="radio" name="transportasi_pulang" value="2" <?php if($transportasi_pulang == '2') echo 'checked'; ?> />&nbsp;Kendaraan Umum&nbsp;&nbsp;&nbsp;
			<input type="radio" name="transportasi_pulang" value="3" <?php if($transportasi_pulang == '3') echo 'checked'; ?> />&nbsp;Ambulance&nbsp;&nbsp;&nbsp;
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Tujuan Pulang</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="radio" name="tujuan_pulang" value="1" <?php if($tujuan_pulang == '1') echo 'checked'; ?> />&nbsp;Rumah&nbsp;&nbsp;&nbsp;
			<input type="radio" name="tujuan_pulang" value="2" <?php if($tujuan_pulang == '2') echo 'checked'; ?> />&nbsp;Yayasan/ Panti&nbsp;&nbsp;&nbsp;
			<input type="radio" name="tujuan_pulang" value="3" <?php if($tujuan_pulang == '3') echo 'checked'; ?> />&nbsp;Lembaga Pemasyarakatan&nbsp;&nbsp;&nbsp;
			</td>
		</tr>
        <tr>
            <td colspan="8">&nbsp;</td>
        </tr>
        <tr><td colspan="8" align="right" >
			Update : <?php echo $register; ?>
			<input type="checkbox" name="final" id="final" value="1" <?php echo (($final == '1') ? 'checked' : ''); ?> />&nbsp;Final&nbsp;&nbsp;&nbsp;&nbsp;
			<?php if(isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])){ ?>
				<?php if($final == '1'){ ?>
					<?php if($dokter_pjawab == $_SESSION['SES_SIMRS_PEGAWAI_ID']){ ?>
						<input type="button" value="simpan" class="myButton1" onclick="simpan();"/>
					<?php } ?>
				<?php }else{ ?>
					<input type="button" value="simpan" class="myButton1" onclick="simpan();"/>
				<?php } ?>
			<?php } ?>
		
			<?php if(!empty($idx)){ 
				$sql_view_rm = 'SELECT FILE_ID FROM t_rm_dokumen_file
						WHERE JNS_PERAWATAN = "2"
						AND NOMR = "' . $nomr . '"
						AND RAWAT_ID = "' . $idx . '"
						AND JENIS_DOKUMEN_ID = "17"
						ORDER BY FILE_ID DESC LIMIT 1';
				$get_view_rm = mysql_query($sql_view_rm) or die(mysql_error());		
				$dat_view_rm = mysql_fetch_assoc($get_view_rm);
			?>
				<input type="button" value="lihat" class="myButton1" onclick="window.open('index.php?flex=<?php echo $dat_view_rm['FILE_ID']; ?>', '_blank');" />
			<?php } ?>
			</td>
        </tr>
    </table>
</form>
<script>
<?php if(isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])){ ?>
	<?php if($final == '1'){ ?>
		<?php if($dokter_pjawab != $_SESSION['SES_SIMRS_PEGAWAI_ID']){ ?>
			$(':input').attr('readonly','readonly');
		<?php } ?>
	<?php } ?>
<?php }else{ ?>
	$(':input').attr('readonly','readonly');
<?php } ?>

function simpan(){
	_haschange = false;
	/*
	var isValid = true;
	if(document.getElementsByName("alasan_dirawat")[0].value == '') isValid = false;
	if(document.getElementsByName("ringkasan_riwayat_penyakit")[0].value == '') isValid = false;
	if(document.getElementsByName("pemeriksaan_fisik")[0].value == '') isValid = false;
	if(document.getElementsByName("pemeriksaan_penunjang")[0].value == '') isValid = false;
	if(document.getElementsByName("pemeriksaan_laboratorium")[0].value == '') isValid = false;
	if(document.getElementsByName("pemeriksaan_radiologi")[0].value == '') isValid = false;
	if(document.getElementsByName("terapi")[0].value == '') isValid = false;
	if(document.getElementsByName("hasil_konsultasi")[0].value == '') isValid = false;
	if(document.getElementsByName("sebab_kematian")[0].value == '') isValid = false;
	if(document.getElementsByName("diagnosa_0")[0].value == '') isValid = false;
	if(document.getElementsByName("tindakan")[0].value == '') isValid = false;
	if(document.getElementsByName("alergi")[0].value == '') isValid = false;
	if(document.getElementsByName("hasil_laboratorium")[0].value == '') isValid = false;
	if(document.getElementsByName("diet")[0].value == '') isValid = false;
	if(document.getElementsByName("follow_up")[0].value == '') isValid = false;
	var kp = document.getElementsByName("keadaan_pulang");
	var slKp = '';
	for(var i = 0; i < kp.length; i++) {
		if(kp[i].checked)
			slKp = kp[i].value;
	}
	if(slKp == '') isValid = false;
	
	var lp = document.getElementsByName("lanjut_pengobatan");
	var slLp = '';
	for(var i = 0; i < lp.length; i++) {
		if(lp[i].checked)
			slLp = lp[i].value;
	}
	if(slLp == '') isValid = false;
	if(slLp == '5' && document.getElementsByName("lanjut_pengobatan_ket")[0].value == '') isValid = false;
	if(document.getElementsByName("kontrol")[0].value == '') isValid = false;
	if(document.getElementsByName("terapi_pulang")[0].value == '') isValid = false;
	
	if(isValid){
		
	*/	
		$('#search').submit();
	/*
	}else{
		alert('Isian Resume Medis Belum Lengkap.');
	}
	*/	
}	
</script>