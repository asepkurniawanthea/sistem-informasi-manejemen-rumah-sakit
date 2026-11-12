<?php
function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = str_replace('|','!',$str);
	$ret = preg_replace('~\r\n?~', "\n", $ret);
	$ret = htmlspecialchars($ret);
	return $ret;
}
	
if (isset($_POST['irja_id'])){
	$st_save = true;
	if(!isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])) $st_save = false;
	if($st_save){
		$st_final = 'NULL';
		if(isset($_POST['final'])) $st_final = '"1"';
		
		$triase = array('triage_emergency'=>((isset($_POST['triage_emergency'])) ? $_POST['triage_emergency'] : ''),
						'triage_urgent'=>((isset($_POST['triage_urgent'])) ? $_POST['triage_urgent'] : ''),
						'triage_non_urgent'=>((isset($_POST['triage_non_urgent'])) ? $_POST['triage_non_urgent'] : ''),
						'triage_false_emergency'=>((isset($_POST['triage_false_emergency'])) ? $_POST['triage_false_emergency'] : ''),
						'triage_doa'=>((isset($_POST['triage_doa'])) ? $_POST['triage_doa'] : ''));
		$triase = json_encode($triase);
		$triase = str_replace('"','|',$triase);
		
		$subyektif = array('keluhan'=>replace_quote($_POST['keluhan']));
		$subyektif = json_encode($subyektif);
		$subyektif = str_replace('"','|',$subyektif);

		$obyektif = array('keadaan_umum'=>replace_quote($_POST['keadaan_umum']),
						'td'=>replace_quote($_POST['td']),
						'gcs_e'=>replace_quote($_POST['gcs_e']),
						'gcs_m'=>replace_quote($_POST['gcs_m']),
						'gcs_v'=>replace_quote($_POST['gcs_v']),
						'nadi'=>replace_quote($_POST['nadi']),
						'suhu'=>replace_quote($_POST['suhu']),
						'kepala'=>replace_quote($_POST['kepala']),
						'leher'=>replace_quote($_POST['leher']),
						'rr'=>replace_quote($_POST['rr']),
						'jantung'=>replace_quote($_POST['jantung']),
						'paru'=>replace_quote($_POST['paru']),
						'abdomen'=>replace_quote($_POST['abdomen']),
						'extremitas'=>replace_quote($_POST['extremitas']),
						'status_lokalis'=>replace_quote($_POST['status_lokalis']));
		$obyektif = json_encode($obyektif);
		$obyektif = str_replace('"','|',$obyektif);
		
		$pemeriksaan_penunjang = array('ekg'=>replace_quote($_POST['ekg']),
									'laboratorium'=>replace_quote($_POST['laboratorium']),
									'radiologi'=>replace_quote($_POST['radiologi']));
		$pemeriksaan_penunjang = json_encode($pemeriksaan_penunjang);
		$pemeriksaan_penunjang = str_replace('"','|',$pemeriksaan_penunjang);
		
		$assesment = array('diagnosa_0'=>replace_quote($_POST['diagnosa_0']),
							'diagnosa_1'=>replace_quote($_POST['diagnosa_1']),
							'diagnosa_2'=>replace_quote($_POST['diagnosa_2']),
							'diagnosa_3'=>replace_quote($_POST['diagnosa_3']),
							'diagnosa_4'=>replace_quote($_POST['diagnosa_4']),
							'diagnosa_5'=>replace_quote($_POST['diagnosa_5']),
							'diagnosa_6'=>replace_quote($_POST['diagnosa_6']),
							'diagnosa_7'=>replace_quote($_POST['diagnosa_7']));
		$assesment = json_encode($assesment);
		$assesment = str_replace('"','|',$assesment);
		
		$planning = array('penatalaksanaan'=>replace_quote($_POST['penatalaksanaan']),
							'pengobatan'=>replace_quote($_POST['pengobatan']),
							'tindakan'=>replace_quote($_POST['tindakan']),
							'konsultasi'=>replace_quote($_POST['konsultasi']));
		$planning = json_encode($planning);
		$planning = str_replace('"','|',$planning);
	
		if(empty($_POST['idx_pengkajian'])){		
			mysql_query('INSERT INTO t_igd_pengkajian_medis (IRJA_ID,TRIASE,PEMERIKSAAN_DOKTER_PUKUL,
				SELESAI_PUKUL,SUBYEKTIF,OBYEKTIF,PEMERIKSAAN_PENUNJANG,ASSESMENT,PLANNING,
				TGL_ASSESMENT,FINAL,REGISTER,PEGAWAI_ID) 
				VALUES ("' . $_POST['irja_id'] . '","' . $triase . '",
				STR_TO_DATE("' . $_POST['jam_pemeriksaan'] . ':' . $_POST['menit_pemeriksaan'] . '","%H:%i"),
				STR_TO_DATE("' . $_POST['jam_selesai'] . ':' . $_POST['menit_selesai'] . '","%H:%i"),
				"' . $subyektif . '","' . $obyektif . '","' . $pemeriksaan_penunjang . '",
				"' . $assesment . '","' . $planning . '",
				NOW(),' . $st_final . ',"' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
				"' . $_SESSION['SES_SIMRS_PEGAWAI_ID'] . '")') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_igd_pengkajian_medis 
				SET TRIASE = "' . $triase . '",
				PEMERIKSAAN_DOKTER_PUKUL = STR_TO_DATE("' . $_POST['jam_pemeriksaan'] . ':' . $_POST['menit_pemeriksaan'] . '","%H:%i"),
				SELESAI_PUKUL = STR_TO_DATE("' . $_POST['jam_selesai'] . ':' . $_POST['menit_selesai'] . '","%H:%i"),
				SUBYEKTIF = "' . $subyektif . '",
				OBYEKTIF = "' . $obyektif . '",
				PEMERIKSAAN_PENUNJANG = "' . $pemeriksaan_penunjang . '",
				ASSESMENT = "' . $assesment . '",
				PLANNING = "' . $planning . '",
				TGL_ASSESMENT = NOW(),
				FINAL = ' . $st_final . ',
				REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
				PEGAWAI_ID = "' . $_SESSION['SES_SIMRS_PEGAWAI_ID'] . '",
				ST_CREATE_ERM = NULL
				WHERE IRJA_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());
		}
		
		mysql_query('DELETE FROM t_irja_diagnosa WHERE IRJA_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());
		$d=0;
		while($d <= 7){
			if(!empty($_POST['diagnosa_'. $d])){
				$diagnosa = replace_quote($_POST['diagnosa_'. $d]);
				mysql_query('INSERT INTO t_irja_diagnosa (IRJA_ID,DIAGNOSA_ORDER,DIAGNOSA) 
					VALUES("' . $_POST['irja_id'] . '","' . $d . '","' . $diagnosa . '")') or die(mysql_error());
			}
		$d++;
		}
	
		/*
		include('lib/vendor/autoload.php');
		include('lib/vendor/autoload.php');
		include('lib/html2openxml/HTMLtoOpenXML.php');
		include('edoc_rekammedik/new/erm_create_pengkajian_medis_gawat_darurat.php');
		erm_pengkajian_medis_gawat_darurat($_POST['irja_id'],$_POST['ls_assesment'],$_POST['tgl_skr'],$_POST['ls_final']);
		*/
		?>
		<script language="JavaScript" >
			alert('Simpan Pengkajian Medis Gawat Darurat Berhasil.');
			window.location = "<?php echo currentUrl(); ?>";
		</script>
		<?php 
	}else{
		$msg_info = 'Harus Oleh Dokter DPJP.';
	}	
}

$jam = date('H');
$menit = date('i');

$qry_pasien = 'SELECT IRJA_ID,TRIASE,
			DATE_FORMAT(PEMERIKSAAN_DOKTER_PUKUL,"%H") AS JAM_PEMERIKSAAN,
			DATE_FORMAT(PEMERIKSAAN_DOKTER_PUKUL,"%i") AS MENIT_PEMERIKSAAN,
			DATE_FORMAT(SELESAI_PUKUL,"%H") AS JAM_SELESAI,
			DATE_FORMAT(SELESAI_PUKUL,"%i") AS MENIT_SELESAI,
			SUBYEKTIF,OBYEKTIF,PEMERIKSAAN_PENUNJANG,ASSESMENT,PLANNING,
			FINAL,DATE_FORMAT(TGL_ASSESMENT,"%d/%m/%Y") AS TGL_ASSESMENT,
			DATE_FORMAT(NOW(),"%d/%m/%Y") AS TGL_SKR
			FROM t_igd_pengkajian_medis
			WHERE IRJA_ID = "' . $_GET['idx'] . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$idx_pengkajian = $dat_pasien['IRJA_ID'];

$jam_pemeriksaan = $dat_pasien['JAM_PEMERIKSAAN']; 
$menit_pemeriksaan = $dat_pasien['MENIT_PEMERIKSAAN']; 

$jam_selesai = $dat_pasien['JAM_SELESAI']; 
$menit_selesai = $dat_pasien['MENIT_SELESAI']; 

$triase = str_replace('|','"',$dat_pasien['TRIASE']);
$triase = preg_replace('/\r|\n/','\n',trim($triase));
$triase = json_decode($triase,true);

$subyektif = str_replace('|','"',$dat_pasien['SUBYEKTIF']);
$subyektif = preg_replace('/\r|\n/','\n',trim($subyektif));
$subyektif = json_decode($subyektif,true);

$obyektif = str_replace('|','"',$dat_pasien['OBYEKTIF']);
$obyektif = preg_replace('/\r|\n/','\n',trim($obyektif));
$obyektif = json_decode($obyektif,true);

$pemeriksaan_penunjang = str_replace('|','"',$dat_pasien['PEMERIKSAAN_PENUNJANG']);
$pemeriksaan_penunjang = preg_replace('/\r|\n/','\n',trim($pemeriksaan_penunjang));
$pemeriksaan_penunjang = json_decode($pemeriksaan_penunjang,true);

$assesment = str_replace('|','"',$dat_pasien['ASSESMENT']);
$assesment = preg_replace('/\r|\n/','\n',trim($assesment));
$assesment = json_decode($assesment,true);

$planning = str_replace('|','"',$dat_pasien['PLANNING']);
$planning = preg_replace('/\r|\n/','\n',trim($planning));
$planning = json_decode($planning,true);

$final = $dat_pasien['FINAL'];
$tgl_assesment = $dat_pasien['TGL_ASSESMENT'];
$tgl_skr = $dat_pasien['TGL_SKR'];
?>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#diagnosa_0").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 760});
		jQuery("#diagnosa_1").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 760});
		jQuery("#diagnosa_2").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 760});
		jQuery("#diagnosa_3").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 760});
		jQuery("#diagnosa_4").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 760});
		jQuery("#diagnosa_5").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 760});
		jQuery("#diagnosa_6").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 760});
		jQuery("#diagnosa_7").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 760});
    });
</script>
<form name="formperiksa" id="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="idx_pengkajian" id="idx_pengkajian" value="<?php echo $idx_pengkajian; ?>" />	
	<input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />	
	<input type="hidden" name="ls_assesment" id="ls_assesment" value="<?php echo $tgl_assesment; ?>" />	
	<input type="hidden" name="ls_final" id="ls_final" value="<?php echo $final; ?>" />	
	<input type="hidden" name="tgl_skr" id="tgl_skr" value="<?php echo $tgl_skr; ?>" />
	<table border="0" align="center" style="position:static; " width="90%">
        <tr>
			<td valign="top" width="220px" colspan="2">Triage</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5">
				<input type="checkbox" name="triage_emergency" value="1" 
				<?php echo ((isset($triase['triage_emergency']) and $triase['triage_emergency'] == '1') ? 'checked' : ''); ?> />Emergency
				<input type="checkbox" name="triage_urgent" value="1" 
				<?php echo ((isset($triase['triage_urgent']) and $triase['triage_urgent'] == '1') ? 'checked' : ''); ?> />Urgent
				<input type="checkbox" name="triage_non_urgent" value="1" 
				<?php echo ((isset($triase['triage_non_urgent']) and $triase['triage_non_urgent'] == '1') ? 'checked' : ''); ?> />Non Urgent
				<input type="checkbox" name="triage_false_emergency" value="1" 
				<?php echo ((isset($triase['triage_false_emergency']) and $triase['triage_false_emergency'] == '1') ? 'checked' : ''); ?> />False Emergency
				<input type="checkbox" name="triage_doa" value="1" 
				<?php echo ((isset($triase['triage_doa']) and $triase['triage_doa'] == '1') ? 'checked' : ''); ?> />D.O.A
			</td>
		</tr>	
		<tr>
			<td valign="top" width="220px" colspan="2">Pemeriksaan Dokter, pukul</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><select name="jam_pemeriksaan" id="jam_pemeriksaan" style="width:50px;" class="text_dt" >
			<?php echo getJam((($jam_pemeriksaan != '') ? $jam_pemeriksaan : $jam)); ?>
			</select>
			<select name="menit_pemeriksaan" id="menit_pemeriksaan" style="width:50px;" class="text_dt" >
			<?php echo getMenit((($menit_pemeriksaan != '') ? $menit_pemeriksaan : $menit)); ?>
			</select></td>
		</tr>
		<tr>
			<td valign="top" width="220px" colspan="2">Selesai pukul</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><select name="jam_selesai" id="jam_selesai" style="width:50px;" class="text_dt" >
			<?php echo getJam((($jam_selesai != '') ? $jam_selesai : $jam)); ?>
			</select>
			<select name="menit_selesai" id="menit_selesai" style="width:50px;" class="text_dt" >
			<?php echo getMenit((($menit_selesai != '') ? $menit_selesai : $menit)); ?>
			</select></td>
		</tr>
		<tr>
            <td colspan="8">&nbsp;</td>
        </tr>
		<tr>
			<td colspan="8">Subjective</td>
		</tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">Keluhan Utama</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><textarea name="keluhan" id="keluhan" cols="80" rows="5" class="text_dt2"><?php echo ((isset($subyektif['keluhan'])) ? $subyektif['keluhan'] : ''); ?></textarea></td>
		</tr>	
		<tr>
			<td colspan="8">Objective</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Keadaan Umum</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="keadaan_umum" value="<?php echo ((isset($obyektif['keadaan_umum'])) ? $obyektif['keadaan_umum'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>	
		<tr>	
			<td>&nbsp;</td>	
			<td>TD</td>
			<td>:</td>
			<td width="200px"><input type="text" name="td" value="<?php echo ((isset($obyektif['td'])) ? $obyektif['td'] : ''); ?>" class="text_dt" >&nbsp;mmHg</td>
			<td width="130px">&nbsp;</td>
			<td width="95px">GCS</td>
			<td>:</td>
			<td>E&nbsp;<input type="text" name="gcs_e" value="<?php echo ((isset($obyektif['gcs_e'])) ? $obyektif['gcs_e'] : ''); ?>" class="text_dt" style="width:80px;" >
			M&nbsp;<input type="text" name="gcs_m" value="<?php echo ((isset($obyektif['gcs_m'])) ? $obyektif['gcs_m'] : ''); ?>" class="text_dt" style="width:80px;" >
			V&nbsp;<input type="text" name="gcs_v" value="<?php echo ((isset($obyektif['gcs_v'])) ? $obyektif['gcs_v'] : ''); ?>" class="text_dt" style="width:80px;" ></td>
		</tr>
		<tr>	
			<td>&nbsp;</td>			
			<td>Nadi</td>
			<td>:</td>
			<td><input type="text" name="nadi" value="<?php echo ((isset($obyektif['nadi'])) ? $obyektif['nadi'] : ''); ?>" class="text_dt" >&nbsp;/menit</td>
			<td>&nbsp;</td>
			<td>Suhu</td>
			<td>:</td>
			<td><input type="text" name="suhu" value="<?php echo ((isset($obyektif['suhu'])) ? $obyektif['suhu'] : ''); ?>" class="text_dt" >&nbsp;<span>&#8451;</span></td>
		</tr>
		<tr>	
			<td>&nbsp;</td>			
			<td>RR</td>
			<td>:</td>
			<td><input type="text" name="rr" value="<?php echo ((isset($obyektif['rr'])) ? $obyektif['rr'] : ''); ?>" class="text_dt" >&nbsp;/menit</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Kepala</td>
			<td>:</td>
			<td><input type="text" name="kepala" value="<?php echo ((isset($obyektif['kepala'])) ? $obyektif['kepala'] : ''); ?>" class="text_dt" ></td>
			<td>&nbsp;</td>
			<td>Leher</td>
			<td>:</td>
			<td><input type="text" name="leher" value="<?php echo ((isset($obyektif['leher'])) ? $obyektif['leher'] : ''); ?>" class="text_dt" ></td>
		</tr>
		<tr>	
			<td>&nbsp;</td>
			<td>Thorax</td>
			<td>:</td>
			<td>Jantung</td>
			<td colspan="4"><input type="text" name="jantung" value="<?php echo ((isset($obyektif['jantung'])) ? $obyektif['jantung'] : ''); ?>" class="text_dt" style="width:550px;"></td>
		</tr>
		<tr>	
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>Paru</td> 
			<td colspan="4"><input type="text" name="paru" value="<?php echo ((isset($obyektif['paru'])) ? $obyektif['paru'] : ''); ?>" class="text_dt" style="width:550px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Abdomen</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="abdomen" value="<?php echo ((isset($obyektif['abdomen'])) ? $obyektif['abdomen'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Extremitas</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="extremitas" value="<?php echo ((isset($obyektif['extremitas'])) ? $obyektif['extremitas'] : ''); ?>" class="text_dt" style="width:755px;"></td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Status Lokalis</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="status_lokalis" value="<?php echo ((isset($obyektif['status_lokalis'])) ? $obyektif['status_lokalis'] : ''); ?>" class="text_dt" style="width:755px;"></td>
        </tr>
		<tr>
            <td colspan="8">&nbsp;</td>
        </tr>
        <tr>
            <td valign="top" colspan="2">Hasil Pemeriksaan Penunjang</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5">&nbsp;</td>
        </tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top">EKG</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="ekg" class="text_dt11" ><?php echo ((isset($pemeriksaan_penunjang['ekg'])) ? $pemeriksaan_penunjang['ekg'] : ''); ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top">Radiologi</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="radiologi" class="text_dt11" ><?php echo ((isset($pemeriksaan_penunjang['radiologi'])) ? $pemeriksaan_penunjang['radiologi'] : ''); ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top">Laboratorium</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="laboratorium" class="text_dt11" ><?php echo ((isset($pemeriksaan_penunjang['laboratorium'])) ? $pemeriksaan_penunjang['laboratorium'] : ''); ?></textarea></td>
		</tr>
		<tr>
            <td valign="top" colspan="2">Assesment</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5">&nbsp;</td>
        </tr>
		<tr>
            <td>&nbsp;</td>
			<td valign="top">Diagnosa</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="diagnosa_0" id="diagnosa_0" value="<?php echo ((isset($assesment['diagnosa_0'])) ? $assesment['diagnosa_0'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td valign="top">&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5"><input type="text" name="diagnosa_1" id="diagnosa_1" value="<?php echo ((isset($assesment['diagnosa_1'])) ? $assesment['diagnosa_1'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td valign="top">&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5"><input type="text" name="diagnosa_2" id="diagnosa_2" value="<?php echo ((isset($assesment['diagnosa_2'])) ? $assesment['diagnosa_2'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td valign="top">&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5"><input type="text" name="diagnosa_3" id="diagnosa_3" value="<?php echo ((isset($assesment['diagnosa_3'])) ? $assesment['diagnosa_3'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
            <td>&nbsp;</td>
			<td valign="top">Diagnosa Banding</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="diagnosa_4" id="diagnosa_4" value="<?php echo ((isset($assesment['diagnosa_4'])) ? $assesment['diagnosa_4'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td valign="top">&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5"><input type="text" name="diagnosa_5" id="diagnosa_5" value="<?php echo ((isset($assesment['diagnosa_5'])) ? $assesment['diagnosa_5'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td valign="top">&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5"><input type="text" name="diagnosa_6" id="diagnosa_6" value="<?php echo ((isset($assesment['diagnosa_6'])) ? $assesment['diagnosa_6'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td valign="top">&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5"><input type="text" name="diagnosa_7" id="diagnosa_7" value="<?php echo ((isset($assesment['diagnosa_7'])) ? $assesment['diagnosa_7'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
            <td valign="top" colspan="2">Planning</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5">&nbsp;</td>
        </tr>
		<tr>
            <td>&nbsp;</td>
			<td valign="top">Penatalaksanaan</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="penatalaksanaan" class="text_dt11" style="height:120px;"><?php echo ((isset($planning['penatalaksanaan'])) ? $planning['penatalaksanaan'] : ''); ?></textarea></td>
        </tr>
		<tr>
            <td>&nbsp;</td>
			<td valign="top">Pengobatan</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="pengobatan" class="text_dt11" style="height:120px;"><?php echo ((isset($planning['pengobatan'])) ? $planning['pengobatan'] : ''); ?></textarea></td>
        </tr>
		<tr>
            <td>&nbsp;</td>
			<td valign="top">Rencana Tindakan</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="tindakan" class="text_dt11" style="height:120px;"><?php echo ((isset($planning['tindakan'])) ? $planning['tindakan'] : ''); ?></textarea></td>
        </tr>
		<tr>
            <td>&nbsp;</td>
			<td valign="top">Konsultasi</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="konsultasi" class="text_dt11" style="height:120px;"><?php echo ((isset($planning['konsultasi'])) ? $planning['konsultasi'] : ''); ?></textarea></td>
        </tr>
        <tr>
            <td colspan="8">&nbsp;</td>
        </tr>
        <tr><td colspan="8" align="right" >
			<?php if(isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI']) and $irja_final == ''){ ?>
			<input type="checkbox" name="final" id="final" value="1" <?php echo (($final == '1') ? 'checked' : ''); ?> />&nbsp;Final&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button" value="simpan" class="myButton1" onclick="simpan();"/>
			<?php if(!empty($idx_pengkajian)){ 
				$sql_view_rm = 'SELECT FILE_ID FROM t_rm_dokumen_file
						WHERE JNS_PERAWATAN = "1"
						AND NOMR = "' . $nomr . '"
						AND RAWAT_ID = "' . $idx . '"
						AND JENIS_DOKUMEN_ID = "42"
						ORDER BY FILE_ID DESC LIMIT 1';
				$get_view_rm = mysql_query($sql_view_rm) or die(mysql_error());		
				$dat_view_rm = mysql_fetch_assoc($get_view_rm);
			?>
				<input type="button" value="lihat" class="myButton1" onclick="window.open('index.php?flex=<?php echo $dat_view_rm['FILE_ID']; ?>', '_blank');" />
			<?php } } ?>
			</td>
        </tr>
    </table>
</form>
<script>
<?php if(!isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])){ ?>
$(':input').attr('readonly','readonly');
<?php } ?>

function simpan(){
	_haschange = false;
	
	if($('#idx').val() != ''){
		if($('#ls_final').val() == '1'){
			if($('#ls_assesment').val() != $('#tgl_skr').val()){
				if(confirm('Revisi ?')){
					$('#formperiksa').submit();
				}	
			}else{
				$('#formperiksa').submit();
			}	
		}else{
			if($("#final").is(':checked')){
				if(confirm('Final ?')){
					$('#formperiksa').submit();
				}
			}else{
				$('#formperiksa').submit();
			}
		}
	}else{
		if($("#final").is(':checked')){
			if(confirm('Final ?')){
				$('#formperiksa').submit();
			}
		}else{
			$('#formperiksa').submit();
		}	
	}
}	
</script>