<?php
if (isset($_POST['irna_id']) and $pam == '29'){
	mysql_query('UPDATE t_irna SET PAM = "29" WHERE IRNA_ID = "' . $_POST['irna_id'] . '"') or die(mysql_error());
	
	$st_save = true;
	if($st_save){
		$st_final = 'NULL';
		if(isset($_POST['final'])) $st_final = '"1"';

		$pemeriksaan = array('pm_keadaan_umum'=>replace_quote($_POST['pm_keadaan_umum']),
						'pm_td'=>replace_quote($_POST['pm_td']),
						'pm_gcs_e'=>replace_quote($_POST['pm_gcs_e']),
						'pm_gcs_m'=>replace_quote($_POST['pm_gcs_m']),
						'pm_gcs_v'=>replace_quote($_POST['pm_gcs_v']),
						'pm_nadi'=>replace_quote($_POST['pm_nadi']),
						'pm_suhu'=>replace_quote($_POST['pm_suhu']),
						'pm_nadi_teratur'=>((isset($_POST['pm_nadi_teratur'])) ? $_POST['pm_nadi_teratur'] : ''),
						'pm_tb'=>replace_quote($_POST['pm_tb']),
						'pm_bb'=>replace_quote($_POST['pm_bb']),
						'pm_rr'=>replace_quote($_POST['pm_rr']));
		$pemeriksaan = json_encode($pemeriksaan);
		$pemeriksaan = str_replace('"','|',$pemeriksaan);	
		
		$pemeriksaan_mt = array('visus_l'=>replace_quote($_POST['visus_l']),
						'visus_r'=>replace_quote($_POST['visus_r']),
						'koreksi_l'=>replace_quote($_POST['koreksi_l']),
						'koreksi_r'=>replace_quote($_POST['koreksi_r']),
						'adisi_l'=>replace_quote($_POST['adisi_l']),
						'adisi_r'=>replace_quote($_POST['adisi_r']),
						'kedudukan_l'=>replace_quote($_POST['kedudukan_l']),
						'kedudukan_r'=>replace_quote($_POST['kedudukan_r']),
						'palpebra_l'=>replace_quote($_POST['palpebra_l']),
						'palpebra_r'=>replace_quote($_POST['palpebra_r']),
						'conjuctiva_l'=>replace_quote($_POST['conjuctiva_l']),
						'conjuctiva_r'=>replace_quote($_POST['conjuctiva_r']),
						'kornea_l'=>replace_quote($_POST['kornea_l']),
						'kornea_r'=>replace_quote($_POST['kornea_r']),
						'bmd_l'=>replace_quote($_POST['bmd_l']),
						'bmd_r'=>replace_quote($_POST['bmd_r']),
						'pupil_l'=>replace_quote($_POST['pupil_l']),
						'pupil_r'=>replace_quote($_POST['pupil_r']),
						'iris_l'=>replace_quote($_POST['iris_l']),
						'iris_r'=>replace_quote($_POST['iris_r']),
						'lensa_l'=>replace_quote($_POST['lensa_l']),
						'lensa_r'=>replace_quote($_POST['lensa_r']),
						'vitreous_l'=>replace_quote($_POST['vitreous_l']),
						'vitreous_r'=>replace_quote($_POST['vitreous_r']),
						'fundus_l'=>replace_quote($_POST['fundus_l']),
						'fundus_r'=>replace_quote($_POST['fundus_r']),
						'tbm_l'=>replace_quote($_POST['tbm_l']),
						'tbm_r'=>replace_quote($_POST['tbm_r']),
						'pandang_l'=>replace_quote($_POST['pandang_l']),
						'pandang_r'=>replace_quote($_POST['pandang_r']),
						'normal'=>((isset($_POST['normal'])) ? $_POST['normal'] : ''),
						'red_green'=>((isset($_POST['red_green'])) ? $_POST['red_green'] : ''),
						'buta_warna'=>((isset($_POST['buta_warna'])) ? $_POST['buta_warna'] : ''));
		$pemeriksaan_mt = json_encode($pemeriksaan_mt);
		$pemeriksaan_mt = str_replace('"','|',$pemeriksaan_mt);
		
		$hasil_pemeriksaan_penunjang = replace_quote($_POST['hasil_pemeriksaan_penunjang']);
		$hasil_pemeriksaan_penunjang = str_replace(' \n ','<br>',$hasil_pemeriksaan_penunjang);
	
		mysql_query('UPDATE t_irna_pengkajian_awal_medis_mata 
			SET ANAMNESIS_KELUHAN_UTAMA = "' . replace_quote($_POST['anamnesis_keluhan_utama']) . '",
			ANAMNESIS_RIWAYAT_PENYAKIT_SEKARANG = "' . replace_quote($_POST['anamnesis_riwayat_penyakit_sekarang']) . '",
			ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU = "' . replace_quote($_POST['anamnesis_riwayat_penyakit_dahulu']) . '",
			ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA = "' . replace_quote($_POST['anamnesis_riwayat_penyakit_keluarga']) . '",
			PEMERIKSAAN = "' . $pemeriksaan . '",
			PEMERIKSAAN_MATA = "' . $pemeriksaan_mt . '",
			HASIL_PEMERIKSAAN_PENUNJANG = "' . $hasil_pemeriksaan_penunjang . '",
			RENCANA_TATALAKSANA = "' . replace_quote($_POST['rencana_tatalaksana']) . '",
			RENCANA_TATALAKSANA_NON_FARMAKA = "' . replace_quote($_POST['rencana_tatalaksana_non_farmaka']) . '",
			TGL_ASSESMENT = NOW(),
			FINAL = ' . $st_final . ',
			REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '"
			WHERE IRNA_ID = "' . $_POST['irna_id'] . '"') or die(mysql_error());
	
		mysql_query('DELETE FROM t_irna_alergi WHERE IRNA_ID = "' . $_POST['irna_id'] . '"') or die(mysql_error());
		mysql_query('INSERT INTO t_irna_alergi(IRNA_ID,ALERGI) VALUES("' . $_POST['irna_id'] . '","' . replace_quote($_POST['anamnesis_alergi']) . '")') or die(mysql_error());
		
		mysql_query('DELETE FROM t_irna_diagnosa WHERE IRNA_ID = "' . $_POST['irna_id'] . '"') or die(mysql_error());
		$d=0;
		while($d <= 7){
			if(!empty($_POST['diagnosa_'. $d])){
					$diagnosa = replace_quote($_POST['diagnosa_'. $d]);
				
				mysql_query('INSERT INTO t_irna_diagnosa (IRNA_ID,DIAGNOSA_ORDER,DIAGNOSA) 
					VALUES("' . $_POST['irna_id'] . '","' . $d . '","' . $diagnosa . '")') or die(mysql_error());
			}
		$d++;
		}
	
		mysql_query('UPDATE t_irna SET ST_CREATE_ERM_PAM = NULL WHERE IRNA_ID = "' . $_POST['irna_id'] . '"') or die(mysql_error());
		/*
		include('edoc_rekammedik/new/erm_create_pengkajian_awal_medis_mata_ranap.php');
		erm_pengkajian_awal_medis_mata_ranap($_POST['irna_id'],$_POST['ls_assesment'],$_POST['tgl_skr'],$_POST['ls_final']);
		*/
		?>
		<script language="JavaScript" >
			alert('Simpan Pengkajian Awal Medis Berhasil.');
			window.location = "<?php echo currentUrl(); ?>";
		</script>
		<?php 
	}else{
		$msg_info = 'Harus Oleh Dokter DPJP.';
	}	
}

$qry_pasien = 'SELECT IRNA_ID,ANAMNESIS_KELUHAN_UTAMA,ANAMNESIS_RIWAYAT_PENYAKIT_SEKARANG,ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU,
			ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA,PEMERIKSAAN,PEMERIKSAAN_MATA,PEMERIKSAAN_MATA_GBR,PEMERIKSAAN_MATA_GBR_FUNDUS,
			PEMERIKSAAN_MATA_GBM_L,PEMERIKSAAN_MATA_GBM_R,HASIL_PEMERIKSAAN_PENUNJANG,
			RENCANA_TATALAKSANA,RENCANA_TATALAKSANA_NON_FARMAKA,
			FINAL,DATE_FORMAT(TGL_ASSESMENT,"%d/%m/%Y") AS TGL_ASSESMENT,
			DATE_FORMAT(NOW(),"%d/%m/%Y") AS TGL_SKR,
			REGISTER,DATE_FORMAT(TGL_ASSESMENT,"%d-%m-%Y %H:%i") AS REGISTER_DT
			FROM t_irna_pengkajian_awal_medis_mata
			WHERE IRNA_ID = "' . $idx . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$idx_pam = $dat_pasien['IRNA_ID'];
$anamnesis_keluhan_utama = $dat_pasien['ANAMNESIS_KELUHAN_UTAMA'];
$anamnesis_riwayat_penyakit_sekarang = $dat_pasien['ANAMNESIS_RIWAYAT_PENYAKIT_SEKARANG'];
$anamnesis_riwayat_penyakit_dahulu = $dat_pasien['ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU'];
$anamnesis_riwayat_penyakit_keluarga = $dat_pasien['ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA'];
$pemeriksaan_fisik = str_replace('|','"',$dat_pasien['PEMERIKSAAN']);
$pemeriksaan_fisik = preg_replace('/\r|\n/','\n',trim($pemeriksaan_fisik));
$pemeriksaan_fisik = json_decode($pemeriksaan_fisik,true);
$pemeriksaan_mata = str_replace('|','"',$dat_pasien['PEMERIKSAAN_MATA']);
$pemeriksaan_mata = preg_replace('/\r|\n/','\n',trim($pemeriksaan_mata));
$pemeriksaan_mata = json_decode($pemeriksaan_mata,true);
$pemeriksaan_mata_gbr = $dat_pasien['PEMERIKSAAN_MATA_GBR'];
$pemeriksaan_mata_gbr_fundus = $dat_pasien['PEMERIKSAAN_MATA_GBR_FUNDUS'];
$pemeriksaan_mata_gbm_l = $dat_pasien['PEMERIKSAAN_MATA_GBM_L'];
$pemeriksaan_mata_gbm_r = $dat_pasien['PEMERIKSAAN_MATA_GBM_R'];
$hasil_pemeriksaan_penunjang = $dat_pasien['HASIL_PEMERIKSAAN_PENUNJANG'];
$rencana_tatalaksana = $dat_pasien['RENCANA_TATALAKSANA'];
$rencana_tatalaksana_non_farmaka = $dat_pasien['RENCANA_TATALAKSANA_NON_FARMAKA'];
$final_mata = $dat_pasien['FINAL'];
$tgl_assesment = $dat_pasien['TGL_ASSESMENT'];
$tgl_skr = $dat_pasien['TGL_SKR'];
$register_mata = $dat_pasien['REGISTER'] . ' ' . $dat_pasien['REGISTER_DT'];

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

$qry_alergi = 'SELECT ALERGI FROM t_irna_alergi WHERE IRNA_ID = "' . $idx . '"';
$get_alergi = mysql_query($qry_alergi) or die(mysql_error());	
$dat_alergi = mysql_fetch_assoc($get_alergi);
$anamnesis_alergi = $dat_alergi['ALERGI'];
?>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#diagnosa_8").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 760});
		jQuery("#diagnosa_9").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 760});
		jQuery("#diagnosa_10").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 760});
		jQuery("#diagnosa_11").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 760});
		jQuery("#diagnosa_12").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 760});
		jQuery("#diagnosa_13").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 760});
		jQuery("#diagnosa_14").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 760});
		jQuery("#diagnosa_15").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 760});
    });
</script>
<form name="formperiksa_29" id="formperiksa_29" method="post" action="http://<?php echo $_SERVER['SERVER_NAME']; ?>/nsimrs/index.php?link=74ac04efa30ba0f5fb861758cbad5b3a&smn=kjam&idx=<?php echo $idx; ?>" >
    <input type="hidden" name="idx" id="idx" value="<?php echo $idx_pam; ?>" />	
	<input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />	
	<input type="hidden" name="ls_assesment" id="ls_assesment" value="<?php echo $tgl_assesment; ?>" />	
	<input type="hidden" name="ls_final" id="ls_final" value="<?php echo $final; ?>" />	
	<input type="hidden" name="tgl_skr" id="tgl_skr" value="<?php echo $tgl_skr; ?>" />
	<input type="hidden" name="pam" id="pam" value="29" />
	<table border="0" align="center" style="position:static; " width="90%">
        <tr>
			<td colspan="8">ANAMNESIS</td>
		</tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">Keluhan Utama</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><textarea name="anamnesis_keluhan_utama" class="text_dt10" ><?php echo $anamnesis_keluhan_utama; ?></textarea></td>
		</tr>	
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Riwayat Penyakit Sekarang</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="anamnesis_riwayat_penyakit_sekarang" class="text_dt10" ><?php echo $anamnesis_riwayat_penyakit_sekarang; ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Riwayat Penyakit Dahulu<br />dan Terapinya</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="anamnesis_riwayat_penyakit_dahulu" class="text_dt10" ><?php echo $anamnesis_riwayat_penyakit_dahulu; ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Riwayat Penyakit Keluarga</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="anamnesis_riwayat_penyakit_keluarga" class="text_dt10" ><?php echo $anamnesis_riwayat_penyakit_keluarga; ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Alergi</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="anamnesis_alergi" class="text_dt10" ><?php echo $anamnesis_alergi; ?></textarea></td>
		</tr>
		<tr>
			<td colspan="8">PEMERIKSAAN</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Keadaan Umum</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="pm_keadaan_umum" value="<?php echo ((isset($pemeriksaan_fisik['pm_keadaan_umum'])) ? $pemeriksaan_fisik['pm_keadaan_umum'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>	
		<tr>	
			<td>&nbsp;</td>	
			<td>TD</td>
			<td>:</td>
			<td width="200px"><input type="text" name="pm_td" value="<?php echo ((isset($pemeriksaan_fisik['pm_td'])) ? $pemeriksaan_fisik['pm_td'] : ''); ?>" class="text_dt" >&nbsp;mmHg</td>
			<td width="130px">&nbsp;</td>
			<td width="95px">GCS</td>
			<td>:</td>
			<td>E&nbsp;<input type="text" name="pm_gcs_e" value="<?php echo ((isset($pemeriksaan_fisik['pm_gcs_e'])) ? $pemeriksaan_fisik['pm_gcs_e'] : ''); ?>" class="text_dt" style="width:80px;" >
			M&nbsp;<input type="text" name="pm_gcs_m" value="<?php echo ((isset($pemeriksaan_fisik['pm_gcs_m'])) ? $pemeriksaan_fisik['pm_gcs_m'] : ''); ?>" class="text_dt" style="width:80px;" >
			V&nbsp;<input type="text" name="pm_gcs_v" value="<?php echo ((isset($pemeriksaan_fisik['pm_gcs_v'])) ? $pemeriksaan_fisik['pm_gcs_v'] : ''); ?>" class="text_dt" style="width:80px;" ></td>
		</tr>
		<tr>	
			<td>&nbsp;</td>			
			<td>Nadi</td>
			<td>:</td>
			<td><input type="text" name="pm_nadi" value="<?php echo ((isset($pemeriksaan_fisik['pm_nadi'])) ? $pemeriksaan_fisik['pm_nadi'] : ''); ?>" class="text_dt" >&nbsp;/menit</td>
			<td>&nbsp;</td>
			<td>Suhu</td>
			<td>:</td>
			<td><input type="text" name="pm_suhu" value="<?php echo ((isset($pemeriksaan_fisik['pm_suhu'])) ? $pemeriksaan_fisik['pm_suhu'] : ''); ?>" class="text_dt" >&nbsp;<span>&#8451;</span></td>
		</tr>
		<tr>	
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><input type="radio" name="pm_nadi_teratur" value="1" class="text_dt" <?php echo ((isset($pemeriksaan_fisik['pm_nadi_teratur']) and $pemeriksaan_fisik['pm_nadi_teratur']=='1') ? 'checked' : ''); ?>>&nbsp;Teratur
				&nbsp;<input type="radio" name="pm_nadi_teratur" value="2" class="text_dt" <?php echo ((isset($pemeriksaan_fisik['pm_nadi_teratur']) and $pemeriksaan_fisik['pm_nadi_teratur']=='2') ? 'checked' : ''); ?>>&nbsp;Tidak Teratur</td>
			<td>&nbsp;</td>
			<td>TB</td>
			<td>:</td>
			<td><input type="text" name="pm_tb" value="<?php echo ((isset($pemeriksaan_fisik['pm_tb'])) ? $pemeriksaan_fisik['pm_tb'] : ''); ?>" class="text_dt" >&nbsp;cm</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>RR</td>
			<td>:</td>
			<td><input type="text" name="pm_rr" value="<?php echo ((isset($pemeriksaan_fisik['pm_rr'])) ? $pemeriksaan_fisik['pm_rr'] : ''); ?>" class="text_dt" ></td>
			<td>&nbsp;</td>
			<td>BB</td>
			<td>:</td>
			<td><input type="text" name="pm_bb" value="<?php echo ((isset($pemeriksaan_fisik['pm_bb'])) ? $pemeriksaan_fisik['pm_bb'] : ''); ?>" class="text_dt" >&nbsp;kg</td>
		</tr>
		<tr>
			<td colspan="8"></td>
		</tr>
		<tr>
			<td colspan="8">
				<table width="95%" border="0">
				<tr>
						<td colspan="5" align="center">
							<canvas id="canvas_29" style="border:5px;"></canvas>
							<button type="button" class="button clear" onclick="undoCanvas_29();" style="width:770px;">Undo</button>
							<button type="button" class="button clear" onclick="clearCanvas_29();" style="width:120px;">Clear</button>
							<br/>
							<canvas id="canvas2" style="border:5px;"></canvas>
							<button type="button" class="button clear" onclick="undoCanvas2();" style="width:770px;">Undo</button>
							<button type="button" class="button clear" onclick="clearCanvas2();" style="width:120px;">Clear</button>
						</td>
					</tr>
					<tr>
						<td width="35%" align="center"><input type="text" name="visus_l" class="text_dt" style="width:420px;" value="<?php echo ((isset($pemeriksaan_mata['visus_l'])) ? $pemeriksaan_mata['visus_l'] : ''); ?>"></td>
						<td align="center">&nbsp;</td>
						<td align="center">Visus</td>
						<td align="center">&nbsp;</td>
						<td width="35%" align="center"><input type="text" name="visus_r" class="text_dt" style="width:420px;" value="<?php echo ((isset($pemeriksaan_mata['visus_r'])) ? $pemeriksaan_mata['visus_r'] : ''); ?>"></td>
					</tr>
					<tr>
						<td width="35%" align="center"><input type="text" name="koreksi_l" class="text_dt" style="width:420px;" value="<?php echo ((isset($pemeriksaan_mata['koreksi_l'])) ? $pemeriksaan_mata['koreksi_l'] : ''); ?>"></td>
						<td align="center">&nbsp;</td>
						<td align="center">Koreksi</td>
						<td align="center">&nbsp;</td>
						<td width="35%" align="center"><input type="text" name="koreksi_r" class="text_dt" style="width:420px;" value="<?php echo ((isset($pemeriksaan_mata['koreksi_r'])) ? $pemeriksaan_mata['koreksi_r'] : ''); ?>"></td>
					</tr>
					<tr>
						<td width="35%" align="center"><input type="text" name="adisi_l" class="text_dt" style="width:420px;" value="<?php echo ((isset($pemeriksaan_mata['adisi_l'])) ? $pemeriksaan_mata['adisi_l'] : ''); ?>"></td>
						<td align="center">&nbsp;</td>
						<td align="center">Adisi</td>
						<td align="center">&nbsp;</td>
						<td width="35%" align="center"><input type="text" name="adisi_r" class="text_dt" style="width:420px;" value="<?php echo ((isset($pemeriksaan_mata['adisi_r'])) ? $pemeriksaan_mata['adisi_r'] : ''); ?>"></td>
					</tr>
					<tr>
						<td width="35%" align="center">
							<canvas id="canvas3" style="border:5px;"></canvas><br/>
							<button type="button" class="button clear" onclick="undoCanvas3();" style="width:50px;">Undo</button>
							<button type="button" class="button clear" onclick="clearCanvas3();" style="width:50px;">Clear</button>
						</td>
						<td align="center">&nbsp;</td>
						<td align="center">Gerakan Bola Mata</td>
						<td align="center">&nbsp;</td>
						<td width="35%" align="center">
							<canvas id="canvas4" style="border:5px;"></canvas><br/>
							<button type="button" class="button clear" onclick="undoCanvas4();" style="width:50px;">Undo</button>
							<button type="button" class="button clear" onclick="clearCanvas4();" style="width:50px;">Clear</button>
						</td>
					</tr>
					<tr>
						<td width="35%" align="center"><input type="text" name="kedudukan_l" class="text_dt" style="width:420px;" value="<?php echo ((isset($pemeriksaan_mata['kedudukan_l'])) ? $pemeriksaan_mata['kedudukan_l'] : ''); ?>"></td>
						<td align="center">&nbsp;</td>
						<td align="center">Kedudukan</td>
						<td align="center">&nbsp;</td>
						<td width="35%" align="center"><input type="text" name="kedudukan_r" class="text_dt" style="width:420px;" value="<?php echo ((isset($pemeriksaan_mata['kedudukan_r'])) ? $pemeriksaan_mata['kedudukan_r'] : ''); ?>"></td>
					</tr>
					<tr>
						<td width="35%" align="center"><input type="text" name="palpebra_l" class="text_dt" style="width:420px;" value="<?php echo ((isset($pemeriksaan_mata['palpebra_l'])) ? $pemeriksaan_mata['palpebra_l'] : ''); ?>"></td>
						<td align="center">&nbsp;</td>
						<td align="center">Palpebra</td>
						<td align="center">&nbsp;</td>
						<td width="35%" align="center"><input type="text" name="palpebra_r" class="text_dt" style="width:420px;" value="<?php echo ((isset($pemeriksaan_mata['palpebra_r'])) ? $pemeriksaan_mata['palpebra_r'] : ''); ?>"></td>
					</tr>
					<tr>
						<td width="35%" align="center"><input type="text" name="conjuctiva_l" class="text_dt" style="width:420px;" value="<?php echo ((isset($pemeriksaan_mata['conjuctiva_l'])) ? $pemeriksaan_mata['conjuctiva_l'] : ''); ?>"></td>
						<td align="center">&nbsp;</td>
						<td align="center">Conjuctiva</td>
						<td align="center">&nbsp;</td>
						<td width="35%" align="center"><input type="text" name="conjuctiva_r" class="text_dt" style="width:420px;" value="<?php echo ((isset($pemeriksaan_mata['conjuctiva_r'])) ? $pemeriksaan_mata['conjuctiva_r'] : ''); ?>"></td>
					</tr>
					<tr>
						<td width="35%" align="center"><input type="text" name="kornea_l" class="text_dt" style="width:420px;" value="<?php echo ((isset($pemeriksaan_mata['kornea_l'])) ? $pemeriksaan_mata['kornea_l'] : ''); ?>"></td>
						<td align="center">&nbsp;</td>
						<td align="center">Kornea</td>
						<td align="center">&nbsp;</td>
						<td width="35%" align="center"><input type="text" name="kornea_r" class="text_dt" style="width:420px;" value="<?php echo ((isset($pemeriksaan_mata['kornea_r'])) ? $pemeriksaan_mata['kornea_r'] : ''); ?>"></td>
					</tr>
					<tr>
						<td width="35%" align="center"><input type="text" name="bmd_l" class="text_dt" style="width:420px;" value="<?php echo ((isset($pemeriksaan_mata['bmd_l'])) ? $pemeriksaan_mata['bmd_l'] : ''); ?>"></td>
						<td align="center">&nbsp;</td>
						<td align="center">Bilik Mata Depan</td>
						<td align="center">&nbsp;</td>
						<td width="35%" align="center"><input type="text" name="bmd_r" class="text_dt" style="width:420px;" value="<?php echo ((isset($pemeriksaan_mata['bmd_r'])) ? $pemeriksaan_mata['bmd_r'] : ''); ?>"></td>
					</tr>
					<tr>
						<td width="35%" align="center"><input type="text" name="pupil_l" class="text_dt" style="width:420px;" value="<?php echo ((isset($pemeriksaan_mata['pupil_l'])) ? $pemeriksaan_mata['pupil_l'] : ''); ?>"></td>
						<td align="center">&nbsp;</td>
						<td align="center">Pupil</td>
						<td align="center">&nbsp;</td>
						<td width="35%" align="center"><input type="text" name="pupil_r" class="text_dt" style="width:420px;" value="<?php echo ((isset($pemeriksaan_mata['pupil_r'])) ? $pemeriksaan_mata['pupil_r'] : ''); ?>"></td>
					</tr>
					<tr>
						<td width="35%" align="center"><input type="text" name="iris_l" class="text_dt" style="width:420px;" value="<?php echo ((isset($pemeriksaan_mata['iris_l'])) ? $pemeriksaan_mata['iris_l'] : ''); ?>"></td>
						<td align="center">&nbsp;</td>
						<td align="center">Iris</td>
						<td align="center">&nbsp;</td>
						<td width="35%" align="center"><input type="text" name="iris_r" class="text_dt" style="width:420px;" value="<?php echo ((isset($pemeriksaan_mata['iris_r'])) ? $pemeriksaan_mata['iris_r'] : ''); ?>"></td>
					</tr>
					<tr>
						<td width="35%" align="center"><input type="text" name="lensa_l" class="text_dt" style="width:420px;" value="<?php echo ((isset($pemeriksaan_mata['lensa_l'])) ? $pemeriksaan_mata['lensa_l'] : ''); ?>"></td>
						<td align="center">&nbsp;</td>
						<td align="center">Lensa</td>
						<td align="center">&nbsp;</td>
						<td width="35%" align="center"><input type="text" name="lensa_r" class="text_dt" style="width:420px;" value="<?php echo ((isset($pemeriksaan_mata['lensa_r'])) ? $pemeriksaan_mata['lensa_r'] : ''); ?>"></td>
					</tr>
					<tr>
						<td width="35%" align="center"><input type="text" name="vitreous_l" class="text_dt" style="width:420px;" value="<?php echo ((isset($pemeriksaan_mata['vitreous_l'])) ? $pemeriksaan_mata['vitreous_l'] : ''); ?>"></td>
						<td align="center">&nbsp;</td>
						<td align="center">Vitreous</td>
						<td align="center">&nbsp;</td>
						<td width="35%" align="center"><input type="text" name="vitreous_r" class="text_dt" style="width:420px;" value="<?php echo ((isset($pemeriksaan_mata['vitreous_r'])) ? $pemeriksaan_mata['vitreous_r'] : ''); ?>"></td>
					</tr>
					<tr>
						<td width="35%" align="center"><input type="text" name="fundus_l" class="text_dt" style="width:420px;" value="<?php echo ((isset($pemeriksaan_mata['fundus_l'])) ? $pemeriksaan_mata['fundus_l'] : ''); ?>"></td>
						<td align="center">&nbsp;</td>
						<td align="center">Fundus</td>
						<td align="center">&nbsp;</td>
						<td width="35%" align="center"><input type="text" name="fundus_r" class="text_dt" style="width:420px;" value="<?php echo ((isset($pemeriksaan_mata['fundus_r'])) ? $pemeriksaan_mata['fundus_r'] : ''); ?>"></td>
					</tr>
					<tr>
						<td width="35%" align="center"><input type="text" name="tbm_l" class="text_dt" style="width:420px;" value="<?php echo ((isset($pemeriksaan_mata['tbm_l'])) ? $pemeriksaan_mata['tbm_l'] : ''); ?>"></td>
						<td align="center">&nbsp;</td>
						<td align="center">Tekanan Bola Mata</td>
						<td align="center">&nbsp;</td>
						<td width="35%" align="center"><input type="text" name="tbm_r" class="text_dt" style="width:420px;" value="<?php echo ((isset($pemeriksaan_mata['tbm_r'])) ? $pemeriksaan_mata['tbm_r'] : ''); ?>"></td>
					</tr>
					<tr>
						<td width="35%" align="center"><input type="text" name="pandang_l" class="text_dt" style="width:420px;" value="<?php echo ((isset($pemeriksaan_mata['pandang_l'])) ? $pemeriksaan_mata['pandang_l'] : ''); ?>"></td>
						<td align="center">&nbsp;</td>
						<td align="center">Lapang Pandang</td>
						<td align="center">&nbsp;</td>
						<td width="35%" align="center"><input type="text" name="pandang_r" class="text_dt" style="width:420px;" value="<?php echo ((isset($pemeriksaan_mata['pandang_r'])) ? $pemeriksaan_mata['pandang_r'] : ''); ?>"></td>
					</tr>
				</table>
			</td>
		</tr>
		 <tr>
            <td valign="top" colspan="2">Tes Buta Warna</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="checkbox" name="normal" value="1" <?php echo ((isset($pemeriksaan_mata['normal']) and $pemeriksaan_mata['normal'] == '1') ? 'checked' : ''); ?> />&nbsp;Normal&nbsp;&nbsp;
							<input type="checkbox" name="red_green" value="1" <?php echo ((isset($pemeriksaan_mata['red_green']) and $pemeriksaan_mata['red_green'] == '1') ? 'checked' : ''); ?> />&nbsp;Red Green Deficiency&nbsp;&nbsp;
							<input type="checkbox" name="buta_warna" value="1" <?php echo ((isset($pemeriksaan_mata['buta_warna']) and $pemeriksaan_mata['buta_warna'] == '1') ? 'checked' : ''); ?> />&nbsp;Buta Warna Total</td>
        </tr>
		<tr>
			<td colspan="8"></td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5">&nbsp;</td>
        </tr>
        <tr>
            <td valign="top" colspan="2">Hasil Pemeriksaan Penunjang</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="hasil_pemeriksaan_penunjang" class="text_dt11" ><?php echo $hasil_pemeriksaan_penunjang; ?></textarea></td>
        </tr>
		<tr>
            <td valign="top" colspan="2" rowspan="4">Diagnosa</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="diagnosa_0" id="diagnosa_8" value="<?php echo ((isset($diagnosa[0])) ? $diagnosa[0] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td valign="top">&nbsp;</td>
			<td colspan="5"><input type="text" name="diagnosa_1" id="diagnosa_9" value="<?php echo ((isset($diagnosa[1])) ? $diagnosa[1] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td valign="top">&nbsp;</td>
			<td colspan="5"><input type="text" name="diagnosa_2" id="diagnosa_10" value="<?php echo ((isset($diagnosa[2])) ? $diagnosa[2] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td valign="top">&nbsp;</td>
			<td colspan="5"><input type="text" name="diagnosa_3" id="diagnosa_11" value="<?php echo ((isset($diagnosa[3])) ? $diagnosa[3] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
            <td valign="top" colspan="2" rowspan="4">Diagnosa Banding</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="diagnosa_4" id="diagnosa_12" value="<?php echo ((isset($diagnosa[4])) ? $diagnosa[4] : ''); ?>" class="text_dt" style="width:755px;" ></td></tr>
			<tr><td>&nbsp;</td><td colspan="5"><input type="text" name="diagnosa_5" id="diagnosa_13" value="<?php echo ((isset($diagnosa[5])) ? $diagnosa[5] : ''); ?>" class="text_dt" style="width:755px;" ></td></tr>
			<tr><td>&nbsp;</td><td colspan="5"><input type="text" name="diagnosa_6" id="diagnosa_14" value="<?php echo ((isset($diagnosa[6])) ? $diagnosa[6] : ''); ?>" class="text_dt" style="width:755px;" ></td></tr>
			<tr><td>&nbsp;</td><td colspan="5"><input type="text" name="diagnosa_7" id="diagnosa_15" value="<?php echo ((isset($diagnosa[7])) ? $diagnosa[7] : ''); ?>" class="text_dt" style="width:755px;" ></td></tr>
		
		<tr>
            <td valign="top" colspan="2">Rencana Tatalaksana Farmaka</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="rencana_tatalaksana" class="text_dt11" style="height:200px;"><?php echo $rencana_tatalaksana; ?></textarea></td>
        </tr>
		<tr>
            <td valign="top" colspan="2">Rencana Tatalaksana Non Farmaka</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="rencana_tatalaksana_non_farmaka" class="text_dt11" style="height:200px;"><?php echo $rencana_tatalaksana_non_farmaka; ?></textarea></td>
        </tr>
        <tr>
            <td colspan="8">&nbsp;</td>
        </tr>
        <tr><td colspan="8" align="right" >
			Update : <?php echo $register_mata; ?>
			<input type="checkbox" name="final" id="final" value="1" <?php echo (($final_mata == '1') ? 'checked' : ''); ?> />&nbsp;Final&nbsp;&nbsp;&nbsp;&nbsp;
			<?php if(isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])){ ?>
				<?php if($final_mata == '1'){ ?>
					<?php if($dokter_pjawab == $_SESSION['SES_SIMRS_PEGAWAI_ID']){ ?>
						<input type="button" value="simpan" class="myButton1" onclick="simpan_29();"/>
					<?php } ?>
				<?php }else{ ?>
					<input type="button" value="simpan" class="myButton1" onclick="simpan_29();"/>
				<?php } ?>
			<?php } ?>
		
			<?php if(!empty($idx)){ 
				$sql_view_rm = 'SELECT FILE_ID FROM t_rm_dokumen_file
						WHERE JNS_PERAWATAN = "2"
						AND NOMR = "' . $nomr . '"
						AND RAWAT_ID = "' . $idx . '"
						AND JENIS_DOKUMEN_ID = "23"
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
	<?php if($final_mata == '1'){ ?>
		<?php if($dokter_pjawab != $_SESSION['SES_SIMRS_PEGAWAI_ID']){ ?>
			$(':input').attr('readonly','readonly');
		<?php } ?>
	<?php } ?>
<?php }else{ ?>
	$(':input').attr('readonly','readonly');
<?php } ?>

const canvas_29 = document.getElementById("canvas_29");
const canvas2 = document.getElementById("canvas2");
const canvas3 = document.getElementById("canvas3");
const canvas4 = document.getElementById("canvas4");

var context_29 = canvas_29.getContext("2d");;
var context2 = canvas2.getContext("2d");
var context3 = canvas3.getContext("2d");
var context4 = canvas4.getContext("2d");

var cPushArray_29 = new Array();
var cPushArray2 = new Array();
var cPushArray3 = new Array();
var cPushArray4 = new Array();

var cStep_29 = -1;
var cStep2 = -1;
var cStep3 = -1;
var cStep4 = -1;

function Draw_29(x, y, isDown) {
    if (isDown) {
        context_29.beginPath();
        context_29.strokeStyle = 'blue';
        context_29.lineWidth = 3;
        context_29.lineJoin = "round";
        context_29.moveTo(lastX, lastY);
        context_29.lineTo(x, y);
        context_29.closePath();
        context_29.stroke();
    }
    lastX = x;
    lastY = y;
}

function Draw2(x, y, isDown) {
    if (isDown) {
        context2.beginPath();
        context2.strokeStyle = 'blue';
        context2.lineWidth = 3;
        context2.lineJoin = "round";
        context2.moveTo(lastX, lastY);
        context2.lineTo(x, y);
        context2.closePath();
        context2.stroke();
    }
    lastX = x;
    lastY = y;
}

function Draw3(x, y, isDown) {
    if (isDown) {
        context3.beginPath();
        context3.strokeStyle = 'blue';
        context3.lineWidth = 3;
        context3.lineJoin = "round";
        context3.moveTo(lastX, lastY);
        context3.lineTo(x, y);
        context3.closePath();
        context3.stroke();
    }
    lastX = x;
    lastY = y;
}

function Draw4(x, y, isDown) {
    if (isDown) {
        context4.beginPath();
        context4.strokeStyle = 'blue';
        context4.lineWidth = 3;
        context4.lineJoin = "round";
        context4.moveTo(lastX, lastY);
        context4.lineTo(x, y);
        context4.closePath();
        context4.stroke();
    }
    lastX = x;
    lastY = y;
}

function clearCanvas_29(){
	if(confirm('Bersihkan ?')){
		var img_ori = new Image();
		img_ori.onload = function(){
			context_29.drawImage(img_ori,0,0,896,200); // Or at whatever offset you like
		};
		img_ori.src = "edoc_rekammedik/new/pemeriksaan_mata.jpg";
		cPush_29();
	}	
}

function clearCanvas2(){
	if(confirm('Bersihkan ?')){
		var img_ori = new Image();
		img_ori.onload = function(){
			context2.drawImage(img_ori,0,0,896,350); // Or at whatever offset you like
		};
		img_ori.src = "edoc_rekammedik/new/pemeriksaan_mata_fundus.jpg";
		cPush2();
	}	
}

function clearCanvas3(){
	if(confirm('Bersihkan ?')){
		var img_ori = new Image();
		img_ori.onload = function(){
			context3.drawImage(img_ori,0,0,100,50); // Or at whatever offset you like
		};
		img_ori.src = "edoc_rekammedik/new/pemeriksaan_mata_gbm.jpg";
		cPush3();
	}	
}

function clearCanvas4(){
	if(confirm('Bersihkan ?')){
		var img_ori = new Image();
		img_ori.onload = function(){
			context4.drawImage(img_ori,0,0,100,50); // Or at whatever offset you like
		};
		img_ori.src = "edoc_rekammedik/new/pemeriksaan_mata_gbm.jpg";
		cPush4();
	}	
}

function cPush_29() {
    cStep_29++;
	if (cStep_29 < cPushArray_29.length) { cPushArray_29.length = cStep_29; }
    cPushArray_29.push(canvas_29.toDataURL());
}

function cPush2() {
    cStep2++;
	if (cStep2 < cPushArray2.length) { cPushArray2.length = cStep2; }
    cPushArray2.push(canvas2.toDataURL());
}

function cPush3() {
    cStep3++;
	if (cStep3 < cPushArray3.length) { cPushArray3.length = cStep3; }
    cPushArray3.push(canvas3.toDataURL());
}

function cPush4() {
    cStep4++;
	if (cStep4 < cPushArray4.length) { cPushArray4.length = cStep4; }
    cPushArray4.push(canvas4.toDataURL());
}

function load_29(){
	canvas_29.width = 896; 
	canvas_29.height = 200; 
	
	canvas2.width = 896; 
	canvas2.height = 350;

	canvas3.width = 100; 
	canvas3.height = 50;

	canvas4.width = 100; 
	canvas4.height = 50;	
	
	var img_def = new Image();
	img_def.onload = function(){
		context_29.drawImage(img_def,0,0,896,200); // Or at whatever offset you like
		cPush_29();
	};
	<?php if(trim($pemeriksaan_mata_gbr) != '') { ?>
		img_def.src = 'http://<?php echo $_SERVER['SERVER_NAME']?>/erekammedik/pemeriksaan_mata/<?php echo $pemeriksaan_mata_gbr; ?>';
	<?php }else{ ?>	
		img_def.src = 'edoc_rekammedik/new/pemeriksaan_mata.jpg';
	<?php } ?>
	
	var img_def2 = new Image();
	img_def2.onload = function(){
		context2.drawImage(img_def2,0,0,896,350); // Or at whatever offset you like
		cPush2();
	};
	<?php if(trim($pemeriksaan_mata_gbr_fundus) != '') { ?>
		img_def2.src = 'http://<?php echo $_SERVER['SERVER_NAME']?>/erekammedik/pemeriksaan_mata/<?php echo $pemeriksaan_mata_gbr_fundus; ?>';
	<?php }else{ ?>	
		img_def2.src = 'edoc_rekammedik/new/pemeriksaan_mata_fundus.jpg';
	<?php } ?>
	
	var img_def3 = new Image();
	img_def3.onload = function(){
		context3.drawImage(img_def3,0,0,100,50); // Or at whatever offset you like
		cPush3();
	};
	<?php if(trim($pemeriksaan_mata_gbm_l) != '') { ?>
		img_def3.src = 'http://<?php echo $_SERVER['SERVER_NAME']?>/erekammedik/pemeriksaan_mata/<?php echo $pemeriksaan_mata_gbm_l; ?>';
	<?php }else{ ?>	
		img_def3.src = 'edoc_rekammedik/new/pemeriksaan_mata_gbm.jpg';
	<?php } ?>
	
	var img_def4 = new Image();
	img_def4.onload = function(){
		context4.drawImage(img_def4,0,0,100,50); // Or at whatever offset you like
		cPush4();
	};
	<?php if(trim($pemeriksaan_mata_gbm_r) != '') { ?>
		img_def4.src = 'http://<?php echo $_SERVER['SERVER_NAME']?>/erekammedik/pemeriksaan_mata/<?php echo $pemeriksaan_mata_gbm_r; ?>';
	<?php }else{ ?>	
		img_def4.src = 'edoc_rekammedik/new/pemeriksaan_mata_gbm.jpg';
	<?php } ?>
}

function undoCanvas_29() {
    if (cStep_29 > 0) {
        cStep_29--;
        var canvasPic = new Image();
        canvasPic.onload = function(){
			context_29.drawImage(canvasPic,0,0); // Or at whatever offset you like
		};
		canvasPic.src = cPushArray_29[cStep_29 - 1];
    }
}

function undoCanvas2() {
    if (cStep2 > 0) {
        cStep2--;
        var canvasPic = new Image();
        canvasPic.onload = function(){
			context2.drawImage(canvasPic,0,0); // Or at whatever offset you like
		};
		canvasPic.src = cPushArray2[cStep2 - 1];
    }
}

function undoCanvas3() {
    if (cStep3 > 0) {
        cStep3--;
        var canvasPic = new Image();
        canvasPic.onload = function(){
			context3.drawImage(canvasPic,0,0); // Or at whatever offset you like
		};
		canvasPic.src = cPushArray3[cStep3 - 1];
    }
}

function undoCanvas4() {
    if (cStep4 > 0) {
        cStep4--;
        var canvasPic = new Image();
        canvasPic.onload = function(){
			context4.drawImage(canvasPic,0,0); // Or at whatever offset you like
		};
		canvasPic.src = cPushArray4[cStep4 - 1];
    }
}

function simpan_submit_29(){
	var image = canvas_29.toDataURL("image/jpg");	
	var image2 = canvas3.toDataURL("image/jpg");	
	var image3 = canvas4.toDataURL("image/jpg");	
	var image4 = canvas2.toDataURL("image/jpg");	
	$.ajax({
			type: 'POST',
			url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/index.php?ajaxrequest=ranapaddpemeriksaanmata',
			data: { img: image,
				img2: image2,
				img3: image3,
				img4: image4,
				idx_pam : '<?php echo $idx_pam; ?>',
				irna_id : '<?php echo $irna_id; ?>',
				nomr : '<?php echo $nomr; ?>'
				},
			cache: false,
			success: function(data) {
				
				if (data != ''){ 
					if(data == 'ok'){
						 $("#formperiksa_29").submit();
					}else{
						alert(data);
					}		
				}		
			},});	
}

function simpan_29(){
	_haschange = false;
	simpan_submit_29();
}	

$('#canvas_29').mousedown(function (e) {
        mousePressed = true;
        Draw_29(e.pageX - $(this).offset().left, e.pageY - $(this).offset().top, false);
});

$('#canvas_29').mousemove(function (e) {
   if (mousePressed) {
        Draw_29(e.pageX - $(this).offset().left, e.pageY - $(this).offset().top, true);
   }
});

$('#canvas_29').mouseup(function (e) {	
	if (mousePressed) {
        mousePressed = false;
        cPush_29();
    }
});

$('#canvas_29').mouseleave(function (e) {
    if (mousePressed) {
		mousePressed = false;
        cPush_29();
	}
});

//canvas2
$('#canvas2').mousedown(function (e) {
        mousePressed = true;
        Draw2(e.pageX - $(this).offset().left, e.pageY - $(this).offset().top, false);
});

$('#canvas2').mousemove(function (e) {
   if (mousePressed) {
        Draw2(e.pageX - $(this).offset().left, e.pageY - $(this).offset().top, true);
   }
});

$('#canvas2').mouseup(function (e) {	
	if (mousePressed) {
        mousePressed = false;
        cPush2();
    }
});

$('#canvas2').mouseleave(function (e) {
    if (mousePressed) {
		mousePressed = false;
        cPush2();
	}
});

//canvas3
$('#canvas3').mousedown(function (e) {
        mousePressed = true;
        Draw3(e.pageX - $(this).offset().left, e.pageY - $(this).offset().top, false);
});

$('#canvas3').mousemove(function (e) {
   if (mousePressed) {
        Draw3(e.pageX - $(this).offset().left, e.pageY - $(this).offset().top, true);
   }
});

$('#canvas3').mouseup(function (e) {	
	if (mousePressed) {
        mousePressed = false;
        cPush3();
    }
});

$('#canvas3').mouseleave(function (e) {
    if (mousePressed) {
		mousePressed = false;
        cPush3();
	}
});

//canvas4
$('#canvas4').mousedown(function (e) {
        mousePressed = true;
        Draw4(e.pageX - $(this).offset().left, e.pageY - $(this).offset().top, false);
});

$('#canvas4').mousemove(function (e) {
   if (mousePressed) {
        Draw4(e.pageX - $(this).offset().left, e.pageY - $(this).offset().top, true);
   }
});

$('#canvas4').mouseup(function (e) {	
	if (mousePressed) {
        mousePressed = false;
        cPush4();
    }
});

$('#canvas4').mouseleave(function (e) {
    if (mousePressed) {
		mousePressed = false;
        cPush4();
	}
});

load_29();
</script>