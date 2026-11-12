<?php
function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = str_replace('|','!',$str);
	$ret = htmlspecialchars($ret);
	return $ret;
}

if (isset($_POST['irja_id'])){
	$st_save = true;
	if(!isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])) $st_save = false;
	if($pegawai_id != $_SESSION['SES_SIMRS_PEGAWAI_ID']) $st_save = false;
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
		
		$odontogram = array('p_18'=>replace_quote($_POST['p_18']),
						'p_17'=>replace_quote($_POST['p_17']),
						'p_16'=>replace_quote($_POST['p_16']),
						'p_15'=>replace_quote($_POST['p_15']),
						'p_14'=>replace_quote($_POST['p_14']),
						'p_13'=>replace_quote($_POST['p_13']),
						'p_12'=>replace_quote($_POST['p_12']),
						'p_11'=>replace_quote($_POST['p_11']),
						'p_41'=>replace_quote($_POST['p_41']),
						'p_42'=>replace_quote($_POST['p_42']),
						'p_43'=>replace_quote($_POST['p_43']),
						'p_44'=>replace_quote($_POST['p_44']),
						'p_45'=>replace_quote($_POST['p_45']),
						'p_46'=>replace_quote($_POST['p_46']),
						'p_47'=>replace_quote($_POST['p_47']),
						'p_48'=>replace_quote($_POST['p_48']),
						'p_28'=>replace_quote($_POST['p_28']),
						'p_27'=>replace_quote($_POST['p_27']),
						'p_26'=>replace_quote($_POST['p_26']),
						'p_25'=>replace_quote($_POST['p_25']),
						'p_24'=>replace_quote($_POST['p_24']),
						'p_23'=>replace_quote($_POST['p_23']),
						'p_22'=>replace_quote($_POST['p_22']),
						'p_21'=>replace_quote($_POST['p_21']),
						'p_31'=>replace_quote($_POST['p_31']),
						'p_32'=>replace_quote($_POST['p_32']),
						'p_33'=>replace_quote($_POST['p_33']),
						'p_34'=>replace_quote($_POST['p_34']),
						'p_35'=>replace_quote($_POST['p_35']),
						'p_36'=>replace_quote($_POST['p_36']),
						'p_37'=>replace_quote($_POST['p_37']),
						'p_38'=>replace_quote($_POST['p_38']));
		$odontogram = json_encode($odontogram);
		$odontogram = str_replace('"','|',$odontogram);

		$pemeriksaan_gigi = array('normal_bite'=>((isset($_POST['normal_bite'])) ? $_POST['normal_bite'] : ''),
						'cross_bite'=>((isset($_POST['cross_bite'])) ? $_POST['cross_bite'] : ''),
						'steep_bite'=>((isset($_POST['steep_bite'])) ? $_POST['steep_bite'] : ''),
						'torus_tidak'=>((isset($_POST['torus_tidak'])) ? $_POST['torus_tidak'] : ''),
						'torus_kecil'=>((isset($_POST['torus_kecil'])) ? $_POST['torus_kecil'] : ''),
						'torus_sedang'=>((isset($_POST['torus_sedang'])) ? $_POST['torus_sedang'] : ''),
						'torus_besar'=>((isset($_POST['torus_besar'])) ? $_POST['torus_besar'] : ''),
						'torus_multiple'=>((isset($_POST['torus_multiple'])) ? $_POST['torus_multiple'] : ''),
						'mandibularis_tidak'=>((isset($_POST['mandibularis_tidak'])) ? $_POST['mandibularis_tidak'] : ''),
						'mandibularis_sisikiri'=>((isset($_POST['mandibularis_sisikiri'])) ? $_POST['mandibularis_sisikiri'] : ''),
						'mandibularis_sisikanan'=>((isset($_POST['mandibularis_sisikanan'])) ? $_POST['mandibularis_sisikanan'] : ''),
						'mandibularis_duasisi'=>((isset($_POST['mandibularis_duasisi'])) ? $_POST['mandibularis_duasisi'] : ''),
						'palatum_dalam'=>((isset($_POST['palatum_dalam'])) ? $_POST['palatum_dalam'] : ''),
						'palatum_sedang'=>((isset($_POST['palatum_sedang'])) ? $_POST['palatum_sedang'] : ''),
						'palatum_rendah'=>((isset($_POST['palatum_rendah'])) ? $_POST['palatum_rendah'] : ''),
						'spnt_tdk'=>((isset($_POST['spnt_tdk'])) ? $_POST['spnt_tdk'] : ''),
						'spnt_ada'=>((isset($_POST['spnt_ada'])) ? $_POST['spnt_ada'] : ''),
						'spnt_ket'=>replace_quote($_POST['spnt_ket']),
						'diastema_tdk'=>((isset($_POST['diastema_tdk'])) ? $_POST['diastema_tdk'] : ''),
						'diastema_ada'=>((isset($_POST['diastema_ada'])) ? $_POST['diastema_ada'] : ''),
						'diastema_ket'=>replace_quote($_POST['diastema_ket']),
						'anomali_tdk'=>((isset($_POST['anomali_tdk'])) ? $_POST['anomali_tdk'] : ''),
						'anomali_ada'=>((isset($_POST['anomali_ada'])) ? $_POST['anomali_ada'] : ''),
						'anomali_ket'=>replace_quote($_POST['anomali_ket']),
						'lainlain'=>replace_quote($_POST['lainlain']));
						
		$pemeriksaan_gigi = json_encode($pemeriksaan_gigi);
		$pemeriksaan_gigi = str_replace('"','|',$pemeriksaan_gigi);	
	
		mysql_query('UPDATE t_irja_pengkajian_awal_medis_gigi 
			SET ANAMNESIS_KELUHAN_UTAMA = "' . replace_quote($_POST['anamnesis_keluhan_utama']) . '",
			ANAMNESIS_RIWAYAT_PENYAKIT_SEKARANG = "' . replace_quote($_POST['anamnesis_riwayat_penyakit_sekarang']) . '",
			ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU = "' . replace_quote($_POST['anamnesis_riwayat_penyakit_dahulu']) . '",
			ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA = "' . replace_quote($_POST['anamnesis_riwayat_penyakit_keluarga']) . '",
			PEMERIKSAAN = "' . $pemeriksaan . '",
			PEMERIKSAAN_GIGI = "' . $pemeriksaan_gigi . '",
			ODONTOGRAM = "' . $odontogram . '",
			RENCANA_TERAPI = "' . replace_quote($_POST['rencana_tatalaksana']) . '",
			TERAPI = "' . replace_quote($_POST['terapi']) . '",
			TERAPI_NON_FARMAKA = "' . replace_quote($_POST['terapi_non_farmaka']) . '",
			TGL_ASSESMENT = NOW(),
			FINAL = ' . $st_final . ',
			REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
			ST_CREATE_ERM = NULL
			WHERE IRJA_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());
			
		mysql_query('DELETE FROM t_irja_alergi WHERE IRJA_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());
		mysql_query('INSERT INTO t_irja_alergi(IRJA_ID,ALERGI) VALUES("' . $_POST['irja_id'] . '","' . replace_quote($_POST['anamnesis_alergi']) . '")') or die(mysql_error());	
	
		mysql_query('DELETE FROM t_irja_diagnosa WHERE IRJA_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());
		
		if(!empty($_POST['diagnosa'])){
			$diagnosa = replace_quote($_POST['diagnosa']);	
				
			mysql_query('INSERT INTO t_irja_diagnosa (IRJA_ID,DIAGNOSA_ORDER,DIAGNOSA) 
					VALUES("' . $_POST['irja_id'] . '","0","' . $diagnosa . '")') or die(mysql_error());
		}
	
		/*
		include('lib/vendor/autoload.php');
		include('lib/html2openxml/HTMLtoOpenXML.php');
		include('edoc_rekammedik/new/erm_create_pengkajian_awal_medis_gigi.php');
		erm_pengkajian_awal_medis_gigi($_POST['irja_id'],$_POST['ls_assesment'],$_POST['tgl_skr'],$_POST['ls_final']);
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

$qry_pasien = 'SELECT IRJA_ID,ANAMNESIS_KELUHAN_UTAMA,ANAMNESIS_RIWAYAT_PENYAKIT_SEKARANG,
			ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU,ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA,
			PEMERIKSAAN,ODONTOGRAM,ODONTOGRAM_GBR,PEMERIKSAAN_GIGI,RENCANA_TERAPI,
			TERAPI,TERAPI_NON_FARMAKA,
			FINAL,DATE_FORMAT(TGL_ASSESMENT,"%d/%m/%Y") AS TGL_ASSESMENT,
			DATE_FORMAT(NOW(),"%d/%m/%Y") AS TGL_SKR
			FROM t_irja_pengkajian_awal_medis_gigi
			WHERE IRJA_ID = "' . $_GET['idx'] . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$idx = $dat_pasien['IRJA_ID'];
$anamnesis_keluhan_utama = $dat_pasien['ANAMNESIS_KELUHAN_UTAMA'];
$anamnesis_riwayat_penyakit_sekarang = $dat_pasien['ANAMNESIS_RIWAYAT_PENYAKIT_SEKARANG'];
$anamnesis_riwayat_penyakit_dahulu = $dat_pasien['ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU'];
$anamnesis_riwayat_penyakit_keluarga = $dat_pasien['ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA'];
$pemeriksaan_fisik = str_replace('|','"',$dat_pasien['PEMERIKSAAN']);
$pemeriksaan_fisik = preg_replace('/\r|\n/','\n',trim($pemeriksaan_fisik));
$pemeriksaan_fisik = json_decode($pemeriksaan_fisik,true);
$pemeriksaan_gigi = str_replace('|','"',$dat_pasien['PEMERIKSAAN_GIGI']);
$pemeriksaan_gigi = preg_replace('/\r|\n/','\n',trim($pemeriksaan_gigi));
$pemeriksaan_gigi = json_decode($pemeriksaan_gigi,true);
$odontogram = str_replace('|','"',$dat_pasien['ODONTOGRAM']);
$odontogram = preg_replace('/\r|\n/','\n',trim($odontogram));
$odontogram = json_decode($odontogram,true);
$odontogram_gbr = $dat_pasien['ODONTOGRAM_GBR'];
$rencana_tatalaksana = $dat_pasien['RENCANA_TERAPI'];
$terapi = $dat_pasien['TERAPI'];
$terapi_non_farmaka = $dat_pasien['TERAPI_NON_FARMAKA'];
$final = $dat_pasien['FINAL'];
$tgl_assesment = $dat_pasien['TGL_ASSESMENT'];
$tgl_skr = $dat_pasien['TGL_SKR'];

$qry_diagnosa = 'SELECT DIAGNOSA_ORDER,DIAGNOSA
		FROM t_irja_diagnosa
		WHERE IRJA_ID = "' . $_GET['idx'] . '"
		ORDER BY DIAGNOSA_ORDER';
$get_diagnosa = mysql_query($qry_diagnosa) or die(mysql_error());
$dat_diagnosa= mysql_fetch_assoc($get_diagnosa);
$diagnosa = $dat_diagnosa['DIAGNOSA'];	

$qry_alergi = 'SELECT ALERGI FROM t_irja_alergi WHERE IRJA_ID = "' . $_GET['idx'] . '"';
$get_alergi = mysql_query($qry_alergi) or die(mysql_error());	
$dat_alergi = mysql_fetch_assoc($get_alergi);
$anamnesis_alergi = $dat_alergi['ALERGI'];
?>
<script type="text/javascript" src="script/fancybox/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="script/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
<form name="formperiksa" id="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="idx" id="idx" value="<?php echo $idx; ?>" />	
	<input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
	<input type="hidden" name="ls_assesment" id="ls_assesment" value="<?php echo $tgl_assesment; ?>" />	
	<input type="hidden" name="ls_final" id="ls_final" value="<?php echo $final; ?>" />	
	<input type="hidden" name="tgl_skr" id="tgl_skr" value="<?php echo $tgl_skr; ?>" />	
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
			<td colspan="2"><input type="text" name="pm_rr" value="<?php echo ((isset($pemeriksaan_fisik['pm_rr'])) ? $pemeriksaan_fisik['pm_rr'] : ''); ?>" class="text_dt" >&nbsp;x/menit</td>
			<td>BB</td>
			<td>:</td>
			<td><input type="text" name="pm_bb" value="<?php echo ((isset($pemeriksaan_fisik['pm_bb'])) ? $pemeriksaan_fisik['pm_bb'] : ''); ?>" class="text_dt" >&nbsp;kg</td>
		</tr>
		<tr>
            <td colspan="8">&nbsp;</td>
        </tr>
		<tr>
			<td colspan="8" align="center">
				<table width="90%" border="0">
					<tr>
						<th colspan="3">ODONTOGRAM</th>
					</tr>
					<tr>
						<td><input type="text" name="p_18" value="<?php echo ((isset($odontogram['p_18'])) ? $odontogram['p_18'] : ''); ?>" class="text_dt" style="width:100px;">&nbsp;18</td>
						<td rowspan="10" align="center" width="500px">
							<canvas id="canvas" style="border:5px;"></canvas>
							<button type="button" class="button clear" onclick="undoCanvas();" style="width:520px;">Undo</button>
							<button type="button" class="button clear" onclick="clearCanvas();" style="width:120px;">Clear</button>
						</td>
						<td><input type="text" name="p_28" value="<?php echo ((isset($odontogram['p_28'])) ? $odontogram['p_28'] : ''); ?>" class="text_dt" style="width:100px;">&nbsp;28</td>
					</tr>
					<tr>
						<td><input type="text" name="p_17" value="<?php echo ((isset($odontogram['p_17'])) ? $odontogram['p_17'] : ''); ?>" class="text_dt" style="width:100px;">&nbsp;17</td>
						<td><input type="text" name="p_27" value="<?php echo ((isset($odontogram['p_27'])) ? $odontogram['p_27'] : ''); ?>" class="text_dt" style="width:100px;">&nbsp;27</td>
					</tr>
					<tr>
						<td><input type="text" name="p_16" value="<?php echo ((isset($odontogram['p_16'])) ? $odontogram['p_16'] : ''); ?>" class="text_dt" style="width:100px;">&nbsp;16</td>
						<td><input type="text" name="p_26" value="<?php echo ((isset($odontogram['p_26'])) ? $odontogram['p_26'] : ''); ?>" class="text_dt" style="width:100px;">&nbsp;26</td>
					</tr>
					<tr>
						<td>15(55)&nbsp;<input type="text" name="p_15" value="<?php echo ((isset($odontogram['p_15'])) ? $odontogram['p_15'] : ''); ?>" class="text_dt" style="width:100px;"></td>
						<td>25(65)&nbsp;<input type="text" name="p_25" value="<?php echo ((isset($odontogram['p_25'])) ? $odontogram['p_25'] : ''); ?>" class="text_dt" style="width:100px;"></td>
					</tr>
					<tr>
						<td>14(54)&nbsp;<input type="text" name="p_14" value="<?php echo ((isset($odontogram['p_14'])) ? $odontogram['p_14'] : ''); ?>" class="text_dt" style="width:100px;"></td>
						<td>24(64)&nbsp;<input type="text" name="p_24" value="<?php echo ((isset($odontogram['p_24'])) ? $odontogram['p_24'] : ''); ?>" class="text_dt" style="width:100px;"></td>
					</tr>
					<tr>
						<td>13(53)&nbsp;<input type="text" name="p_13" value="<?php echo ((isset($odontogram['p_13'])) ? $odontogram['p_13'] : ''); ?>" class="text_dt" style="width:100px;"></td>
						<td>23(63)&nbsp;<input type="text" name="p_23" value="<?php echo ((isset($odontogram['p_23'])) ? $odontogram['p_23'] : ''); ?>" class="text_dt" style="width:100px;"></td>
					</tr>
					<tr>
						<td>12(52)&nbsp;<input type="text" name="p_12" value="<?php echo ((isset($odontogram['p_12'])) ? $odontogram['p_12'] : ''); ?>" class="text_dt" style="width:100px;"></td>
						<td>22(62)&nbsp;<input type="text" name="p_22" value="<?php echo ((isset($odontogram['p_22'])) ? $odontogram['p_22'] : ''); ?>" class="text_dt" style="width:100px;"></td>
					</tr>
					<tr>
						<td>11(51)&nbsp;<input type="text" name="p_11" value="<?php echo ((isset($odontogram['p_11'])) ? $odontogram['p_11'] : ''); ?>" class="text_dt" style="width:100px;"></td>
						<td>21(61)&nbsp;<input type="text" name="p_21" value="<?php echo ((isset($odontogram['p_21'])) ? $odontogram['p_21'] : ''); ?>" class="text_dt" style="width:100px;"></td>
					</tr>
					<tr>
						<td>41(81)&nbsp;<input type="text" name="p_41" value="<?php echo ((isset($odontogram['p_41'])) ? $odontogram['p_41'] : ''); ?>" class="text_dt" style="width:100px;"></td>
						<td>31(71)&nbsp;<input type="text" name="p_31" value="<?php echo ((isset($odontogram['p_31'])) ? $odontogram['p_31'] : ''); ?>" class="text_dt" style="width:100px;"></td>
					</tr>
					<tr>
						<td>42(82)&nbsp;<input type="text" name="p_42" value="<?php echo ((isset($odontogram['p_42'])) ? $odontogram['p_42'] : ''); ?>" class="text_dt" style="width:100px;"></td>
						
						<td>32(72)&nbsp;<input type="text" name="p_32" value="<?php echo ((isset($odontogram['p_32'])) ? $odontogram['p_32'] : ''); ?>" class="text_dt" style="width:100px;"></td>
					</tr>
					<tr>
						<td>43(83)&nbsp;<input type="text" name="p_43" value="<?php echo ((isset($odontogram['p_43'])) ? $odontogram['p_43'] : ''); ?>" class="text_dt" style="width:100px;"></td>
						<td rowspan="6" align="center" valign="middle">
							<input type="radio" name="simbol" id="simbol_1" value="1" checked />&nbsp;<img src="edoc_rekammedik/new/gigi/gigi_1_ket.jpg" width="20px" height="20px">&nbsp;Missing
							<input type="radio" name="simbol" id="simbol_2" value="2" />&nbsp;<img src="edoc_rekammedik/new/gigi/gigi_2_ket.jpg" width="20px" height="20px">&nbsp;Unerupted
							<input type="radio" name="simbol" id="simbol_3" value="3" />&nbsp;<img src="edoc_rekammedik/new/gigi/gigi_3_ket.jpg" width="20px" height="20px">&nbsp;Fraktur
							<input type="radio" name="simbol" id="simbol_4" value="4" />&nbsp;<img src="edoc_rekammedik/new/gigi/gigi_4_ket.jpg" width="20px" height="20px">&nbsp;Tambalan<br/>
							<input type="radio" name="simbol" id="simbol_5" value="5" />&nbsp;<img src="edoc_rekammedik/new/gigi/gigi_5_ket.jpg" width="20px" height="20px">&nbsp;Karies
							<input type="radio" name="simbol" id="simbol_6" value="6" />&nbsp;<img src="edoc_rekammedik/new/gigi/gigi_6_ket.jpg" width="20px" height="20px">&nbsp;Bridge
							<input type="radio" name="simbol" id="simbol_7" value="7" />&nbsp;<img src="edoc_rekammedik/new/gigi/gigi_7_ket.jpg" width="20px" height="20px">&nbsp;Calculus
							<input type="radio" name="simbol" id="simbol_8" value="8" />&nbsp;<img src="edoc_rekammedik/new/gigi/gigi_8_ket.jpg" width="20px" height="20px">&nbsp;Sisa Akar
						</td>
						<td>33(73)&nbsp;<input type="text" name="p_33" value="<?php echo ((isset($odontogram['p_33'])) ? $odontogram['p_33'] : ''); ?>" class="text_dt" style="width:100px;"></td>
					</tr>
					<tr>
						<td>44(84)&nbsp;<input type="text" name="p_44" value="<?php echo ((isset($odontogram['p_44'])) ? $odontogram['p_44'] : ''); ?>" class="text_dt" style="width:100px;"></td>
						<td>34(74)&nbsp;<input type="text" name="p_34" value="<?php echo ((isset($odontogram['p_34'])) ? $odontogram['p_34'] : ''); ?>" class="text_dt" style="width:100px;"></td>
					</tr>
					<tr>
						<td>45(85)&nbsp;<input type="text" name="p_45" value="<?php echo ((isset($odontogram['p_45'])) ? $odontogram['p_45'] : ''); ?>" class="text_dt" style="width:100px;"></td>
						<td>35(75)&nbsp;<input type="text" name="p_35" value="<?php echo ((isset($odontogram['p_35'])) ? $odontogram['p_35'] : ''); ?>" class="text_dt" style="width:100px;"></td>
					</tr>
					<tr>
						<td><input type="text" name="p_46" value="<?php echo ((isset($odontogram['p_46'])) ? $odontogram['p_46'] : ''); ?>" class="text_dt" style="width:100px;">&nbsp;46</td>
						<td><input type="text" name="p_36" value="<?php echo ((isset($odontogram['p_36'])) ? $odontogram['p_36'] : ''); ?>" class="text_dt" style="width:100px;">&nbsp;36</td>
					</tr>
					<tr>
						<td><input type="text" name="p_47" value="<?php echo ((isset($odontogram['p_47'])) ? $odontogram['p_47'] : ''); ?>" class="text_dt" style="width:100px;">&nbsp;47</td>
						<td><input type="text" name="p_37" value="<?php echo ((isset($odontogram['p_37'])) ? $odontogram['p_37'] : ''); ?>" class="text_dt" style="width:100px;">&nbsp;37</td>
					</tr>
					<tr>
						<td><input type="text" name="p_48" value="<?php echo ((isset($odontogram['p_48'])) ? $odontogram['p_48'] : ''); ?>" class="text_dt" style="width:100px;">&nbsp;48</td>
						<td><input type="text" name="p_38" value="<?php echo ((isset($odontogram['p_38'])) ? $odontogram['p_38'] : ''); ?>" class="text_dt" style="width:100px;">&nbsp;38</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
            <td valign="top" colspan="2">Occulasi</td>
			<td valign="top">:</td>
			<td colspan="5">
					<input type="checkbox" name="normal_bite" value="1" <?php echo ((isset($pemeriksaan_gigi['normal_bite']) and $pemeriksaan_gigi['normal_bite'] == '1') ? 'checked' : ''); ?> />&nbsp;Normal Bite&nbsp;&nbsp;
							<input type="checkbox" name="cross_bite" value="1" <?php echo ((isset($pemeriksaan_gigi['cross_bite']) and $pemeriksaan_gigi['cross_bite'] == '1') ? 'checked' : ''); ?> />&nbsp;Cross Bite&nbsp;&nbsp;
							<input type="checkbox" name="steep_bite" value="1" <?php echo ((isset($pemeriksaan_gigi['steep_bite']) and $pemeriksaan_gigi['steep_bite'] == '1') ? 'checked' : ''); ?> />&nbsp;Steep Bite
			</td>
        </tr>
		<tr>
            <td valign="top" colspan="2">Torus Palatinus</td>
			<td valign="top">:</td>
			<td colspan="5">
					<input type="checkbox" name="torus_tidak" value="1" <?php echo ((isset($pemeriksaan_gigi['torus_tidak']) and $pemeriksaan_gigi['torus_tidak'] == '1') ? 'checked' : ''); ?> />&nbsp;Tidak ada&nbsp;&nbsp;
							<input type="checkbox" name="torus_kecil" value="1" <?php echo ((isset($pemeriksaan_gigi['torus_kecil']) and $pemeriksaan_gigi['torus_kecil'] == '1') ? 'checked' : ''); ?> />&nbsp;Kecil&nbsp;&nbsp;
							<input type="checkbox" name="torus_sedang" value="1" <?php echo ((isset($pemeriksaan_gigi['torus_sedang']) and $pemeriksaan_gigi['torus_sedang'] == '1') ? 'checked' : ''); ?> />&nbsp;Sedang&nbsp;&nbsp;
							<input type="checkbox" name="torus_besar" value="1" <?php echo ((isset($pemeriksaan_gigi['torus_besar']) and $pemeriksaan_gigi['torus_besar'] == '1') ? 'checked' : ''); ?> />&nbsp;Besar&nbsp;&nbsp;
							<input type="checkbox" name="torus_multiple" value="1" <?php echo ((isset($pemeriksaan_gigi['torus_multiple']) and $pemeriksaan_gigi['torus_multiple'] == '1') ? 'checked' : ''); ?> />&nbsp;Multiple
			</td>
        </tr>
		<tr>
            <td valign="top" colspan="2">Torus Mandibularis</td>
			<td valign="top">:</td>
			<td colspan="5">
					<input type="checkbox" name="mandibularis_tidak" value="1" <?php echo ((isset($pemeriksaan_gigi['mandibularis_tidak']) and $pemeriksaan_gigi['mandibularis_tidak'] == '1') ? 'checked' : ''); ?> />&nbsp;Tidak ada&nbsp;&nbsp;
							<input type="checkbox" name="mandibularis_sisikiri" value="1" <?php echo ((isset($pemeriksaan_gigi['mandibularis_sisikiri']) and $pemeriksaan_gigi['mandibularis_sisikiri'] == '1') ? 'checked' : ''); ?> />&nbsp;Sisi kiri&nbsp;&nbsp;
							<input type="checkbox" name="mandibularis_sisikanan" value="1" <?php echo ((isset($pemeriksaan_gigi['mandibularis_sisikanan']) and $pemeriksaan_gigi['mandibularis_sisikanan'] == '1') ? 'checked' : ''); ?> />&nbsp;Sisi kanan&nbsp;&nbsp;
							<input type="checkbox" name="mandibularis_duasisi" value="1" <?php echo ((isset($pemeriksaan_gigi['mandibularis_duasisi']) and $pemeriksaan_gigi['mandibularis_duasisi'] == '1') ? 'checked' : ''); ?> />&nbsp;Kedua sisi
			</td>
        </tr>
		<tr>
            <td valign="top" colspan="2">Palatum</td>
			<td valign="top">:</td>
			<td colspan="5">
					<input type="checkbox" name="palatum_dalam" value="1" <?php echo ((isset($pemeriksaan_gigi['palatum_dalam']) and $pemeriksaan_gigi['palatum_dalam'] == '1') ? 'checked' : ''); ?> />&nbsp;Dalam&nbsp;&nbsp;
							<input type="checkbox" name="palatum_sedang" value="1" <?php echo ((isset($pemeriksaan_gigi['palatum_sedang']) and $pemeriksaan_gigi['palatum_sedang'] == '1') ? 'checked' : ''); ?> />&nbsp;Sedang&nbsp;&nbsp;
							<input type="checkbox" name="palatum_rendah" value="1" <?php echo ((isset($pemeriksaan_gigi['palatum_rendah']) and $pemeriksaan_gigi['palatum_rendah'] == '1') ? 'checked' : ''); ?> />&nbsp;rendah
			</td>
        </tr>
		<tr>
            <td valign="top" colspan="2">Supernumerary Teeth</td>
			<td valign="top">:</td>
			<td colspan="5">
					<input type="checkbox" name="spnt_tdk" value="1" <?php echo ((isset($pemeriksaan_gigi['spnt_tdk']) and $pemeriksaan_gigi['spnt_tdk'] == '1') ? 'checked' : ''); ?> />&nbsp;Tidak ada&nbsp;&nbsp;
					<input type="checkbox" name="spnt_ada" value="1" <?php echo ((isset($pemeriksaan_gigi['spnt_ada']) and $pemeriksaan_gigi['spnt_ada'] == '1') ? 'checked' : ''); ?> />&nbsp;Ada&nbsp;&nbsp;
					<input type="text" name="spnt_ket" value="<?php echo ((isset($pemeriksaan_gigi['spnt_ket'])) ? $pemeriksaan_gigi['spnt_ket'] : ''); ?>" class="text_dt" style="width:605px;">		
			</td>
        </tr>
		<tr>
            <td valign="top" colspan="2">Diastema</td>
			<td valign="top">:</td>
			<td colspan="5">
					<input type="checkbox" name="diastema_tdk" value="1" <?php echo ((isset($pemeriksaan_gigi['diastema_tdk']) and $pemeriksaan_gigi['diastema_tdk'] == '1') ? 'checked' : ''); ?> />&nbsp;Tidak ada&nbsp;&nbsp;
					<input type="checkbox" name="diastema_ada" value="1" <?php echo ((isset($pemeriksaan_gigi['diastema_ada']) and $pemeriksaan_gigi['diastema_ada'] == '1') ? 'checked' : ''); ?> />&nbsp;Ada&nbsp;&nbsp;
					<input type="text" name="diastema_ket" value="<?php echo ((isset($pemeriksaan_gigi['diastema_ket'])) ? $pemeriksaan_gigi['diastema_ket'] : ''); ?>" class="text_dt" style="width:605px;">		
			</td>
        </tr>
		<tr>
            <td valign="top" colspan="2">Gigi Anomali</td>
			<td valign="top">:</td>
			<td colspan="5">
					<input type="checkbox" name="anomali_tdk" value="1" <?php echo ((isset($pemeriksaan_gigi['anomali_tdk']) and $pemeriksaan_gigi['anomali_tdk'] == '1') ? 'checked' : ''); ?> />&nbsp;Tidak ada&nbsp;&nbsp;
					<input type="checkbox" name="anomali_ada" value="1" <?php echo ((isset($pemeriksaan_gigi['anomali_ada']) and $pemeriksaan_gigi['anomali_ada'] == '1') ? 'checked' : ''); ?> />&nbsp;Ada&nbsp;&nbsp;
					<input type="text" name="anomali_ket" value="<?php echo ((isset($pemeriksaan_gigi['anomali_ket'])) ? $pemeriksaan_gigi['anomali_ket'] : ''); ?>" class="text_dt" style="width:605px;">		
			</td>
        </tr>
		<tr>
            <td valign="top" colspan="2">Lain-lain</td>
			<td valign="top">:</td>
			<td colspan="5">
					<input type="text" name="lainlain" value="<?php echo ((isset($pemeriksaan_gigi['lainlain'])) ? $pemeriksaan_gigi['lainlain'] : ''); ?>" class="text_dt" style="width:755px;">		
			</td>
        </tr>
        <tr>
            <td colspan="8">&nbsp;</td>
        </tr>
		<tr>
            <td valign="top" colspan="2">Diagnosa/ Assesment</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="diagnosa" id="diagnosa" class="text_dt11" style="height:100px;" ><?php echo $diagnosa; ?></textarea></td></tr>
		<tr>
		<tr>
            <td valign="top" colspan="2">&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5"><a href="#" onclick="window.open('index.php?popup=klinikformdiagnosa&idx=<?php echo $irja_id; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=460')">tambah diagnosa</a></td></tr>
		<tr>
            <td valign="top" colspan="2">Rencana Terapi</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="rencana_tatalaksana" class="text_dt11" style="height:200px;"><?php echo $rencana_tatalaksana; ?></textarea></td>
        </tr>
		<tr>
            <td valign="top" colspan="2">Terapi Farmaka</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="terapi" class="text_dt11" style="height:200px;"><?php echo $terapi; ?></textarea></td>
        </tr>
		<tr>
            <td valign="top" colspan="2">Terapi Non Farmaka</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="terapi_non_farmaka" class="text_dt11" style="height:200px;"><?php echo $terapi_non_farmaka; ?></textarea></td>
        </tr>
        <tr>
            <td colspan="8">&nbsp;</td>
        </tr>
        <tr><td colspan="8" align="right" >
			<?php if(isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI']) and $pegawai_id == $_SESSION['SES_SIMRS_PEGAWAI_ID']  and $irja_final == ''){ ?>
			<input type="checkbox" name="final" id="final" value="1" <?php echo (($final == '1') ? 'checked' : ''); ?> />&nbsp;Final&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button" value="simpan" class="myButton1" onclick="simpan();" />
				<?php if(!empty($idx)){ 
				$sql_view_rm = 'SELECT FILE_ID FROM t_rm_dokumen_file
						WHERE JNS_PERAWATAN = "1"
						AND NOMR = "' . $nomr . '"
						AND RAWAT_ID = "' . $idx . '"
						AND JENIS_DOKUMEN_ID = "24"
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
<?php if(!isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI']) 
	or $pegawai_id != $_SESSION['SES_SIMRS_PEGAWAI_ID'] ){ ?>
$(':input').attr('readonly','readonly');
<?php } ?>
const canvas = document.querySelector('canvas');
var context = canvas.getContext('2d'); 
var cPushArray = new Array();
var cStep = -1;

var img1 = new Image();
img1.src = "edoc_rekammedik/new/gigi/gigi_1.png";

var img2 = new Image();
img2.src = "edoc_rekammedik/new/gigi/gigi_2.png";

var img3 = new Image();
img3.src = "edoc_rekammedik/new/gigi/gigi_3.png";

var img4 = new Image();
img4.src = "edoc_rekammedik/new/gigi/gigi_4.png";

var img5 = new Image();
img5.src = "edoc_rekammedik/new/gigi/gigi_5.png";

var img6 = new Image();
img6.src = "edoc_rekammedik/new/gigi/gigi_6.png";

var img7 = new Image();
img7.src = "edoc_rekammedik/new/gigi/gigi_7.png";

var img8 = new Image();
img8.src = "edoc_rekammedik/new/gigi/gigi_8.png";

function clearCanvas(){
	if(confirm('Bersihkan ?')){
		var img_ori = new Image();
		img_ori.onload = function(){
			context.drawImage(img_ori,0,0); // Or at whatever offset you like
		};
		img_ori.src = "edoc_rekammedik/new/pemeriksaan_gigi.png";
		cPush();
	}	
}

function cPush() {
    cStep++;
	if (cStep < cPushArray.length) { cPushArray.length = cStep; }
    cPushArray.push(canvas.toDataURL());
}

function undoCanvas(){
	if (cStep > 0) {
        cStep--;
		var canvasPic = new Image();
		canvasPic.onload = function(){
			context.drawImage(canvasPic,0,0); // Or at whatever offset you like
		};
		canvasPic.src = cPushArray[cStep - 1];
    }
}	

function load(){
	canvas.width = 650; 
	canvas.height = 260; 
	
	var img_def = new Image();
	img_def.onload = function(){
		context.drawImage(img_def,0,0); // Or at whatever offset you like
	};
	<?php if(trim($odontogram_gbr) != '') { ?>
		img_def.src = 'http://<?php echo $_SERVER['SERVER_NAME']?>/erekammedik/pemeriksaan_gigi/<?php echo $odontogram_gbr; ?>';
	<?php }else{ ?>	
		img_def.src = 'edoc_rekammedik/new/pemeriksaan_gigi.png';
	<?php } ?>
}

function simpan_submit(){
	var image = canvas.toDataURL("image/jpg");	
	$.ajax({
			type: 'POST',
			url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/index.php?ajaxrequest=klinikaddpemeriksaangigi',
			data: { img: image,
				idx : '<?php echo $idx; ?>',
				irja_id : '<?php echo $irja_id; ?>',
				nomr : '<?php echo $nomr; ?>'
				},
			cache: false,
			success: function(data) {
				
				if (data != ''){ 
					if(data == 'ok'){
						 $("#formperiksa").submit();
					}else{
						alert(data);
					}		
				}		
			},});	
}

function simpan(){
	_haschange = false;
	
	if($('#idx').val() != ''){
		if($('#ls_final').val() == '1'){
			if($('#ls_assesment').val() != $('#tgl_skr').val()){
				if(confirm('Revisi ?')){
					simpan_submit();
				}	
			}else{
				simpan_submit();
			}	
		}else{
			if($("#final").is(':checked')){
				if(confirm('Final ?')){
					simpan_submit();
				}
			}else{
				simpan_submit();
			}
		}
	}else{
		if($("#final").is(':checked')){
			if(confirm('Final ?')){
				simpan_submit();
			}
		}else{
			simpan_submit();
		}	
	}
}	

function setGambar(canvas, event) {
    const rect = canvas.getBoundingClientRect()
    const x = event.clientX - rect.left;
    const y = event.clientY - rect.top;
	
    if(cStep < 0){
		cPush();
	}	
	
	if (document.getElementById('simbol_1').checked){
		context.drawImage(img1,x-10,y-10,25,25);
	}
	if (document.getElementById('simbol_2').checked){
		context.drawImage(img2,x-10,y-10,25,25);
	}
	if (document.getElementById('simbol_3').checked){
		context.drawImage(img3,x-10,y-10,25,25);
	}
	if (document.getElementById('simbol_4').checked){
		context.drawImage(img4,x-10,y-10,25,25);
	}
	if (document.getElementById('simbol_5').checked){
		context.drawImage(img5,x-10,y-10,25,25);
	}
	if (document.getElementById('simbol_6').checked){
		context.drawImage(img6,x-10,y-10,25,25);
	}
	if (document.getElementById('simbol_7').checked){
		context.drawImage(img7,x-10,y-10,25,25);
	}
	if (document.getElementById('simbol_8').checked){
		context.drawImage(img8,x-10,y-10,25,25);
	}	
	cPush();
}

canvas.addEventListener('mousedown', function(e) {
    setGambar(canvas, e)
})

load();
</script>