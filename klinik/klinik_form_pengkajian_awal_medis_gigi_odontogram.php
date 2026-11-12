<?php
if (isset($_POST['irja_id'])){
	$st_save = true;
	if(!isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])) $st_save = false;
	if($pegawai_id != $_SESSION['SES_SIMRS_PEGAWAI_ID']) $st_save = false;
	if($st_save){
		$st_final = 'NULL';
		if(isset($_POST['final'])) $st_final = '"1"';

		$pemeriksaan = array('pm_keadaan_umum'=>$_POST['pm_keadaan_umum'],
						'pm_td'=>$_POST['pm_td'],
						'pm_gcs_e'=>$_POST['pm_gcs_e'],
						'pm_gcs_m'=>$_POST['pm_gcs_m'],
						'pm_gcs_v'=>$_POST['pm_gcs_v'],
						'pm_nadi'=>$_POST['pm_nadi'],
						'pm_suhu'=>$_POST['pm_suhu'],
						'pm_nadi_teratur'=>((isset($_POST['pm_nadi_teratur'])) ? $_POST['pm_nadi_teratur'] : ''),
						'pm_tb'=>$_POST['pm_tb'],
						'pm_kepala'=>$_POST['pm_kepala'],
						'pm_bb'=>$_POST['pm_bb'],
						'pm_leher'=>$_POST['pm_leher'],
						'pm_rr'=>$_POST['pm_rr'],
						'pm_jantung'=>$_POST['pm_jantung'],
						'pm_paru'=>$_POST['pm_paru'],
						'pm_abdomen'=>$_POST['pm_abdomen'],
						'pm_extremitas'=>$_POST['pm_extremitas']);
		$pemeriksaan = json_encode($pemeriksaan);
		$pemeriksaan = str_replace('"','|',$pemeriksaan);	
	
		if(empty($_POST['idx'])){				
			mysql_query('INSERT INTO t_irja_pengkajian_awal_medis_gigi (IRJA_ID,ANAMNESIS_KELUHAN_UTAMA,ANAMNESIS_RIWAYAT_PENYAKIT_SEKARANG,
				ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU,ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA,ANAMNESIS_ALERGI,PEMERIKSAAN,STATUS_LOKALIS,
				HASIL_PEMERIKSAAN_PENUNJANG,RENCANA_TATALAKSANA,TGL_ASSESMENT,FINAL,REGISTER) VALUES ("' . $_POST['irja_id'] . '",
				"' . $_POST['anamnesis_keluhan_utama'] . '","' . $_POST['anamnesis_riwayat_penyakit_sekarang'] . '",
				"' . $_POST['anamnesis_riwayat_penyakit_dahulu'] . '","' . $_POST['anamnesis_riwayat_penyakit_keluarga'] . '",
				"' . $_POST['anamnesis_alergi'] . '","' . $pemeriksaan . '","' . $_POST['status_lokalis'] . '",
				"' . $_POST['hasil_pemeriksaan_penunjang'] . '","' . $_POST['rencana_tatalaksana'] . '",NOW(),
				' . $st_final . ',"' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '")') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_irja_pengkajian_awal_medis_gigi 
				SET ANAMNESIS_KELUHAN_UTAMA = "' . $_POST['anamnesis_keluhan_utama'] . '",
				ANAMNESIS_RIWAYAT_PENYAKIT_SEKARANG = "' . $_POST['anamnesis_riwayat_penyakit_sekarang'] . '",
				ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU = "' . $_POST['anamnesis_riwayat_penyakit_dahulu'] . '",
				ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA = "' . $_POST['anamnesis_riwayat_penyakit_keluarga'] . '",
				ANAMNESIS_ALERGI = "' . $_POST['anamnesis_alergi'] . '",
				PEMERIKSAAN = "' . $pemeriksaan . '",
				STATUS_LOKALIS = "' . $_POST['status_lokalis'] . '",
				HASIL_PEMERIKSAAN_PENUNJANG = "' . $_POST['hasil_pemeriksaan_penunjang'] . '",
				RENCANA_TATALAKSANA = "' . $_POST['rencana_tatalaksana'] . '",
				TGL_ASSESMENT = NOW(),
				FINAL = ' . $st_final . ',
				REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '"
				WHERE IRJA_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());
		}
	
		mysql_query('DELETE FROM t_irja_diagnosa WHERE IRJA_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());
		$d=0;
		while($d <= 7){
			if(!empty($_POST['diagnosa_'. $d])){
				mysql_query('INSERT INTO t_irja_diagnosa (IRJA_ID,DIAGNOSA_ORDER,DIAGNOSA) 
					VALUES("' . $_POST['irja_id'] . '","' . $d . '","' . $_POST['diagnosa_'. $d] . '")') or die(mysql_error());
			}
		$d++;
		}
	
		/*include('lib/vendor/autoload.php');
		include('edoc_rekammedik/new/erm_create_pengkajian_awal_medis_kusta.php');
		erm_pengkajian_awal_medis_kusta($_POST['irja_id'],$_SESSION['SES_SIMRS_NAMA_PEGAWAI'],'');*/
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
			PEMERIKSAAN,ODONTOGRAM,PEMERIKSAAN_GIGI,RENCANA_TERAPI,FINAL,REGISTER,SIGNATUR
			FROM t_irja_pengkajian_awal_medis_gigi
			WHERE IRJA_ID = "' . $_GET['idx'] . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$idx = $dat_pasien['IRJA_ID'];
$anamnesis_keluhan_utama = $dat_pasien['ANAMNESIS_KELUHAN_UTAMA'];
$anamnesis_riwayat_penyakit_sekarang = $dat_pasien['ANAMNESIS_RIWAYAT_PENYAKIT_SEKARANG'];
$anamnesis_riwayat_penyakit_dahulu = $dat_pasien['ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU'];
$anamnesis_riwayat_penyakit_keluarga = $dat_pasien['ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA'];
$anamnesis_alergi = '';//$dat_pasien['ANAMNESIS_ALERGI'];
$pemeriksaan_fisik = str_replace('|','"',$dat_pasien['PEMERIKSAAN']);
$pemeriksaan_fisik = json_decode($pemeriksaan_fisik,true);
$pemeriksaan_mata = str_replace('|','"',$dat_pasien['PEMERIKSAAN_GIGI']);
$pemeriksaan_mata = json_decode($pemeriksaan_mata,true);
$odontogram = $dat_pasien['ODONTOGRAM'];
$rencana_tatalaksana = $dat_pasien['RENCANA_TERAPI'];
$final = $dat_pasien['FINAL'];
$register = $dat_pasien['REGISTER'];

$qry_diagnosa = 'SELECT DIAGNOSA_ORDER,DIAGNOSA
		FROM t_irja_diagnosa
		WHERE IRJA_ID = "' . $_GET['idx'] . '"
		ORDER BY DIAGNOSA_ORDER';
$get_diagnosa = mysql_query($qry_diagnosa) or die(mysql_error());
$d=0;
$diagnosa = array();
while($dat_diagnosa= mysql_fetch_array($get_diagnosa)){
	$diagnosa[$dat_diagnosa['DIAGNOSA_ORDER']]=$dat_diagnosa['DIAGNOSA'];
$d++;
}	
?>
<!--<link rel="stylesheet" href="lib/odontogram/public/css/style.css">-->
<!--<link rel="stylesheet" href="lib/odontogram/public/css/jquery.svg.css">-->
<link rel="stylesheet" href="lib/odontogram/public/css/odontograma.css">
<script src="lib/odontogram/public/js/modernizr-2.0.6.min.js"></script>
<script>
var dental_diag = [];
</script>
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="idx" id="idx" value="<?php echo $idx; ?>" />	
	<input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />	
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
				<div id="container">
    <div id="main" role="main">      
      <div id="tratamiento">
        <h2>Diagnosa</h2>
        <select 
          data-bind=" options: tratamientosPosibles, 
                      value: tratamientoSeleccionado, 
                      optionsText: function(item){ return item.nombre; },
                      optionsCaption: 'Seleccione un tratamiento...'">
        </select>
        <ul data-bind="foreach: tratamientosAplicados">
          <li>
            P<span data-bind="text: diente.id"></span><span data-bind="text: cara"></span>
            -            
            <span data-bind="text: tratamiento.nombre"></span>
            | 
            <a href="#" data-bind="click: $parent.quitarTratamiento" style="color: red;">Remove</a>
          </li>
        </ul>
      </div>
      <div id="odontograma-wrapper">
        <h2>Odontogram</h2>
        <div id="odontograma"></div>
      </div>      
    </div>
    <footer>
      
    </footer>
  </div>
			</td>
		</tr>
		<tr>
            <td valign="top" colspan="2">Occulasi</td>
			<td valign="top">:</td>
			<td colspan="5">
					<input type="checkbox" name="normal_bite" value="1" <?php echo ((isset($pemeriksaan_mata['normal_bite']) and $pemeriksaan_mata['normal_bite'] == '1') ? 'checked' : ''); ?> />&nbsp;Normal Bite&nbsp;&nbsp;
							<input type="checkbox" name="cross_bite" value="1" <?php echo ((isset($pemeriksaan_mata['cross_bite']) and $pemeriksaan_mata['cross_bite'] == '1') ? 'checked' : ''); ?> />&nbsp;Cross Bite&nbsp;&nbsp;
							<input type="checkbox" name="steep_bite" value="1" <?php echo ((isset($pemeriksaan_mata['steep_bite']) and $pemeriksaan_mata['steep_bite'] == '1') ? 'checked' : ''); ?> />&nbsp;Steep Bite
			</td>
        </tr>
		<tr>
            <td valign="top" colspan="2">Torus Palatinus</td>
			<td valign="top">:</td>
			<td colspan="5">
					<input type="checkbox" name="torus_tidak" value="1" <?php echo ((isset($pemeriksaan_mata['torus_tidak']) and $pemeriksaan_mata['torus_tidak'] == '1') ? 'checked' : ''); ?> />&nbsp;Tidak ada&nbsp;&nbsp;
							<input type="checkbox" name="torus_kecil" value="1" <?php echo ((isset($pemeriksaan_mata['torus_kecil']) and $pemeriksaan_mata['torus_kecil'] == '1') ? 'checked' : ''); ?> />&nbsp;Kecil&nbsp;&nbsp;
							<input type="checkbox" name="torus_sedang" value="1" <?php echo ((isset($pemeriksaan_mata['torus_sedang']) and $pemeriksaan_mata['torus_sedang'] == '1') ? 'checked' : ''); ?> />&nbsp;Sedang&nbsp;&nbsp;
							<input type="checkbox" name="torus_besar" value="1" <?php echo ((isset($pemeriksaan_mata['torus_besar']) and $pemeriksaan_mata['torus_besar'] == '1') ? 'checked' : ''); ?> />&nbsp;Besar&nbsp;&nbsp;
							<input type="checkbox" name="torus_multiple" value="1" <?php echo ((isset($pemeriksaan_mata['torus_multiple']) and $pemeriksaan_mata['torus_multiple'] == '1') ? 'checked' : ''); ?> />&nbsp;Multiple
			</td>
        </tr>
		<tr>
            <td valign="top" colspan="2">Torus Mandibularis</td>
			<td valign="top">:</td>
			<td colspan="5">
					<input type="checkbox" name="mandibularis_tidak" value="1" <?php echo ((isset($pemeriksaan_mata['mandibularis_tidak']) and $pemeriksaan_mata['mandibularis_tidak'] == '1') ? 'checked' : ''); ?> />&nbsp;Tidak ada&nbsp;&nbsp;
							<input type="checkbox" name="mandibularis_sisikiri" value="1" <?php echo ((isset($pemeriksaan_mata['mandibularis_sisikiri']) and $pemeriksaan_mata['mandibularis_sisikiri'] == '1') ? 'checked' : ''); ?> />&nbsp;Sisi kiri&nbsp;&nbsp;
							<input type="checkbox" name="mandibularis_sisikanan" value="1" <?php echo ((isset($pemeriksaan_mata['mandibularis_sisikanan']) and $pemeriksaan_mata['mandibularis_sisikanan'] == '1') ? 'checked' : ''); ?> />&nbsp;Sisi kanan&nbsp;&nbsp;
							<input type="checkbox" name="mandibularis_duasisi" value="1" <?php echo ((isset($pemeriksaan_mata['mandibularis_duasisi']) and $pemeriksaan_mata['mandibularis_duasisi'] == '1') ? 'checked' : ''); ?> />&nbsp;Kedua sisi
			</td>
        </tr>
		<tr>
            <td valign="top" colspan="2">Palatum</td>
			<td valign="top">:</td>
			<td colspan="5">
					<input type="checkbox" name="palatum_dalam" value="1" <?php echo ((isset($pemeriksaan_mata['palatum_dalam']) and $pemeriksaan_mata['palatum_dalam'] == '1') ? 'checked' : ''); ?> />&nbsp;Dalam&nbsp;&nbsp;
							<input type="checkbox" name="palatum_sedang" value="1" <?php echo ((isset($pemeriksaan_mata['palatum_sedang']) and $pemeriksaan_mata['palatum_sedang'] == '1') ? 'checked' : ''); ?> />&nbsp;Sedang&nbsp;&nbsp;
							<input type="checkbox" name="palatum_rendah" value="1" <?php echo ((isset($pemeriksaan_mata['palatum_rendah']) and $pemeriksaan_mata['palatum_rendah'] == '1') ? 'checked' : ''); ?> />&nbsp;rendah
			</td>
        </tr>
		<tr>
            <td valign="top" colspan="2">Supernumerary Teeth</td>
			<td valign="top">:</td>
			<td colspan="5">
					<input type="checkbox" name="spnt_tdk" value="1" <?php echo ((isset($pemeriksaan_mata['spnt_tdk']) and $pemeriksaan_mata['spnt_tdk'] == '1') ? 'checked' : ''); ?> />&nbsp;Tidak ada&nbsp;&nbsp;
					<input type="checkbox" name="spnt_ada" value="1" <?php echo ((isset($pemeriksaan_mata['spnt_ada']) and $pemeriksaan_mata['spnt_ada'] == '1') ? 'checked' : ''); ?> />&nbsp;Ada&nbsp;&nbsp;
					<input type="text" name="spnt_ket" value="<?php echo ((isset($pemeriksaan_mata['spnt_ket'])) ? $pemeriksaan_mata['spnt_ket'] : ''); ?>" class="text_dt" style="width:605px;">		
			</td>
        </tr>
		<tr>
            <td valign="top" colspan="2">Diastema</td>
			<td valign="top">:</td>
			<td colspan="5">
					<input type="checkbox" name="diastema_tdk" value="1" <?php echo ((isset($pemeriksaan_mata['diastema_tdk']) and $pemeriksaan_mata['diastema_tdk'] == '1') ? 'checked' : ''); ?> />&nbsp;Tidak ada&nbsp;&nbsp;
					<input type="checkbox" name="diastema_ada" value="1" <?php echo ((isset($pemeriksaan_mata['diastema_ada']) and $pemeriksaan_mata['diastema_ada'] == '1') ? 'checked' : ''); ?> />&nbsp;Ada&nbsp;&nbsp;
					<input type="text" name="diastema_ket" value="<?php echo ((isset($pemeriksaan_mata['diastema_ket'])) ? $pemeriksaan_mata['diastema_ket'] : ''); ?>" class="text_dt" style="width:605px;">		
			</td>
        </tr>
		<tr>
            <td valign="top" colspan="2">Gigi Anomali</td>
			<td valign="top">:</td>
			<td colspan="5">
					<input type="checkbox" name="anomali_tdk" value="1" <?php echo ((isset($pemeriksaan_mata['anomali_tdk']) and $pemeriksaan_mata['anomali_tdk'] == '1') ? 'checked' : ''); ?> />&nbsp;Tidak ada&nbsp;&nbsp;
					<input type="checkbox" name="anomali_ada" value="1" <?php echo ((isset($pemeriksaan_mata['anomali_ada']) and $pemeriksaan_mata['anomali_ada'] == '1') ? 'checked' : ''); ?> />&nbsp;Ada&nbsp;&nbsp;
					<input type="text" name="anomali_ket" value="<?php echo ((isset($pemeriksaan_mata['anomali_ket'])) ? $pemeriksaan_mata['anomali_ket'] : ''); ?>" class="text_dt" style="width:605px;">		
			</td>
        </tr>
		<tr>
            <td valign="top" colspan="2">Lain-lain</td>
			<td valign="top">:</td>
			<td colspan="5">
					<input type="text" name="lainlain" value="<?php echo ((isset($pemeriksaan_mata['lainlain'])) ? $pemeriksaan_mata['lainlain'] : ''); ?>" class="text_dt" style="width:755px;">		
			</td>
        </tr>
        <tr>
            <td colspan="8">&nbsp;</td>
        </tr>
		<tr>
            <td valign="top" colspan="2" rowspan="4">Diagnosa Utama</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="diagnosa_0" value="<?php echo ((isset($diagnosa[0])) ? $diagnosa[0] : ''); ?>" class="text_dt" style="width:755px;" ></td></tr>
			<tr><td>&nbsp;</td><td colspan="5"><input type="text" name="diagnosa_1" value="<?php echo ((isset($diagnosa[1])) ? $diagnosa[1] : ''); ?>" class="text_dt" style="width:755px;" ></td></tr>
			<tr><td>&nbsp;</td><td colspan="5"><input type="text" name="diagnosa_2" value="<?php echo ((isset($diagnosa[2])) ? $diagnosa[2] : ''); ?>" class="text_dt" style="width:755px;" ></td></tr>
			<tr><td>&nbsp;</td><td colspan="5"><input type="text" name="diagnosa_3" value="<?php echo ((isset($diagnosa[3])) ? $diagnosa[3] : ''); ?>" class="text_dt" style="width:755px;" ></td></tr>
		<tr>
            <td valign="top" colspan="2" rowspan="4">Diagnosa Banding</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="diagnosa_4" value="<?php echo ((isset($diagnosa[4])) ? $diagnosa[4] : ''); ?>" class="text_dt" style="width:755px;" ></td></tr>
			<tr><td>&nbsp;</td><td colspan="5"><input type="text" name="diagnosa_5" value="<?php echo ((isset($diagnosa[5])) ? $diagnosa[5] : ''); ?>" class="text_dt" style="width:755px;" ></td></tr>
			<tr><td>&nbsp;</td><td colspan="5"><input type="text" name="diagnosa_6" value="<?php echo ((isset($diagnosa[6])) ? $diagnosa[6] : ''); ?>" class="text_dt" style="width:755px;" ></td></tr>
			<tr><td>&nbsp;</td><td colspan="5"><input type="text" name="diagnosa_7" value="<?php echo ((isset($diagnosa[7])) ? $diagnosa[7] : ''); ?>" class="text_dt" style="width:755px;" ></td></tr>
		
		<tr>
            <td valign="top" colspan="2">Rencana Terapi</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="rencana_tatalaksana" class="text_dt11" style="height:400px;"><?php echo $rencana_tatalaksana; ?></textarea></td>
        </tr>
        <tr>
            <td colspan="8">&nbsp;</td>
        </tr>
        <tr><td colspan="8" align="right" >
			<?php if(isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI']) and $pegawai_id == $_SESSION['SES_SIMRS_PEGAWAI_ID']){ ?>
			<input type="checkbox" name="final" value="1" <?php echo (($final == '1') ? 'checked' : ''); ?> />
			<input type="button" value="simpan" class="myButton1" onclick="simpan();" />
			<input type="button" value="lihat" class="myButton1" />
			<?php } ?>
			</td>
        </tr>
    </table>
</form>
<canvas id="canvas" width="800" height="400"></canvas>
<div id="png-container"></div>
<script defer src="lib/odontogram/public/js/jquery-1.7.1.min.js"></script>
  <script defer src="lib/odontogram/public/js/plugins.js"></script>
  <script defer src="lib/odontogram/public/js/jquery-ui-1.8.17.custom.min.js"></script>
  <script defer src="lib/odontogram/public/js/jquery.tmpl.js"></script>
  <script defer src="lib/odontogram/public/js/knockout-2.0.0.js"></script>
  <script defer src="lib/odontogram/public/js/jquery.svg.min.js"></script>  
  <script defer src="lib/odontogram/public/js/jquery.svggraph.min.js"></script>  
  <script defer src="lib/odontogram/public/js/odontograma.js"></script>
  <script defer src="script/d3.v3.min.js"></script>
  <script>
	function simpan(){
		console.log(dental_diag);
		
		var svgString = new XMLSerializer().serializeToString(document.querySelector('odontograma'));

		var canvas = document.getElementById("canvas");
		var ctx = canvas.getContext("2d");
		var DOMURL = self.URL || self.webkitURL || self;
		var img = new Image();
		var svg = new Blob([svgString], {type: "image/svg+xml;charset=utf-8"});
		var url = DOMURL.createObjectURL(svg);
		img.onload = function() {
			ctx.drawImage(img, 0, 0);
			var png = canvas.toDataURL("image/png");
			document.querySelector('#png-container').innerHTML = '<img src="'+png+'"/>';
			DOMURL.revokeObjectURL(png);
		};
		img.src = url;
	}
  </script>