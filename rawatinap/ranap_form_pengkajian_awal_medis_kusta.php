<?php
if (isset($_POST['irna_id']) and $pam == '35'){
	mysql_query('UPDATE t_irna SET PAM = "35" WHERE IRNA_ID = "' . $_POST['irna_id'] . '"') or die(mysql_error());
	
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
						'pm_kepala'=>replace_quote($_POST['pm_kepala']),
						'pm_bb'=>replace_quote($_POST['pm_bb']),
						'pm_leher'=>replace_quote($_POST['pm_leher']),
						'pm_rr'=>replace_quote($_POST['pm_rr']),
						'pm_jantung'=>replace_quote($_POST['pm_jantung']),
						'pm_paru'=>replace_quote($_POST['pm_paru']),
						'pm_abdomen'=>replace_quote($_POST['pm_abdomen']),
						'pm_extremitas'=>replace_quote($_POST['pm_extremitas']));
		$pemeriksaan = json_encode($pemeriksaan);
		$pemeriksaan = str_replace('"','|',$pemeriksaan);	
		
		$hasil_pemeriksaan_penunjang = $_POST['hasil_pemeriksaan_penunjang'];
		$hasil_pemeriksaan_penunjang = str_replace(' \n ','<br>',$hasil_pemeriksaan_penunjang);
	
		mysql_query('UPDATE t_irna_pengkajian_awal_medis_kusta 
				SET ANAMNESIS_KELUHAN_UTAMA = "' . replace_quote($_POST['anamnesis_keluhan_utama']) . '",
				ANAMNESIS_RIWAYAT_PENYAKIT_SEKARANG = "' . replace_quote($_POST['anamnesis_riwayat_penyakit_sekarang']) . '",
				ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU = "' . replace_quote($_POST['anamnesis_riwayat_penyakit_dahulu']) . '",
				ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA = "' . replace_quote($_POST['anamnesis_riwayat_penyakit_keluarga']) . '",
				ANAMNESIS_RIWAYAT_KONTAK = "' . replace_quote($_POST['anamnesis_riwayat_kontak']) . '",
				ANAMNESIS_RIWAYAT_PENGOBATAN = "' . replace_quote($_POST['anamnesis_riwayat_pengobatan']) . '",
				PEMERIKSAAN = "' . $pemeriksaan . '",
				STATUS_LOKALIS = "' . replace_quote($_POST['status_lokalis']) . '",
				PEMERIKSAN_SARAF_TEPI = "' . replace_quote($_POST['pemeriksaan_saraf_tepi']) . '",
				HASIL_PEMERIKSAAN_PENUNJANG = "' . replace_quote($_POST['hasil_pemeriksaan_penunjang']) . '",
				RENCANA_TATALAKSANA = "' . replace_quote($_POST['rencana_tatalaksana']) . '",
				RENCANA_TATALAKSANA_NON_FARMAKA = "' . replace_quote($_POST['rencana_tatalaksana_non_farmaka']) . '",
				CATATAN_TANDA_PERUBAHAN_KULIT_SARAF = "' . replace_quote($_POST['catatan_perubahan_kulit_saraf']) . '",
				TGL_ASSESMENT = NOW(),
				FINAL = ' . $st_final . ',
				REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '"
				WHERE IRNA_ID = "' . $_POST['irna_id'] . '"') or die(mysql_error());
	
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
		
		mysql_query('DELETE FROM t_irna_alergi WHERE IRNA_ID = "' . $_POST['irna_id'] . '"') or die(mysql_error());
		mysql_query('INSERT INTO t_irna_alergi(IRNA_ID,ALERGI) VALUES("' . $_POST['irna_id'] . '","' . replace_quote($_POST['anamnesis_alergi']) . '")') or die(mysql_error());
	
		mysql_query('UPDATE t_irna SET ST_CREATE_ERM_PAM = NULL WHERE IRNA_ID = "' . $_POST['irna_id'] . '"') or die(mysql_error());
		/*
		include('edoc_rekammedik/new/erm_create_pengkajian_awal_medis_kusta_ranap.php');
		erm_pengkajian_awal_medis_kusta_ranap($_POST['irna_id'],$_SESSION['SES_SIMRS_NAMA_PEGAWAI'],'');
		*/
		?>
		<script language="JavaScript" >
			alert('Simpan Pengkajian Awal Medis Kusta Berhasil.');
			window.location = "<?php echo currentUrl(); ?>";
		</script>
		<?php 
	}else{
		$msg_info = 'Harus Oleh Dokter DPJP.';
	}	
}

$qry_pasien = 'SELECT IRNA_ID,ANAMNESIS_KELUHAN_UTAMA,ANAMNESIS_RIWAYAT_PENYAKIT_SEKARANG,ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU,
			ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA,ANAMNESIS_RIWAYAT_KONTAK,ANAMNESIS_RIWAYAT_PENGOBATAN,
			PEMERIKSAAN,STATUS_LOKALIS,PEMERIKSAN_SARAF_TEPI,HASIL_PEMERIKSAAN_PENUNJANG, 
			RENCANA_TATALAKSANA,RENCANA_TATALAKSANA_NON_FARMAKA,
			TANDA_PERUBAHAN_KULIT_SARAF,CATATAN_TANDA_PERUBAHAN_KULIT_SARAF,KODE_TANDA_KELAINAN, 
			FINAL,DATE_FORMAT(TGL_ASSESMENT,"%d/%m/%Y") AS TGL_ASSESMENT,
			DATE_FORMAT(NOW(),"%d/%m/%Y") AS TGL_SKR,
			REGISTER,DATE_FORMAT(TGL_ASSESMENT,"%d-%m-%Y %H:%i") AS REGISTER_DT
			FROM t_irna_pengkajian_awal_medis_kusta
			WHERE IRNA_ID = "' . $idx . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$idx_pam = $dat_pasien['IRNA_ID'];
$anamnesis_keluhan_utama = $dat_pasien['ANAMNESIS_KELUHAN_UTAMA'];
$anamnesis_riwayat_penyakit_sekarang = $dat_pasien['ANAMNESIS_RIWAYAT_PENYAKIT_SEKARANG'];
$anamnesis_riwayat_penyakit_dahulu = $dat_pasien['ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU'];
$anamnesis_riwayat_penyakit_keluarga = $dat_pasien['ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA'];
$anamnesis_riwayat_kontak = $dat_pasien['ANAMNESIS_RIWAYAT_KONTAK'];
$anamnesis_riwayat_pengobatan = $dat_pasien['ANAMNESIS_RIWAYAT_PENGOBATAN'];
$pemeriksaan_fisik = str_replace('|','"',$dat_pasien['PEMERIKSAAN']);
$pemeriksaan_fisik = preg_replace('/\r|\n/','\n',trim($pemeriksaan_fisik));
$pemeriksaan_fisik = json_decode($pemeriksaan_fisik,true);
$status_lokalis = $dat_pasien['STATUS_LOKALIS'];
$pemeriksaan_saraf_tepi = $dat_pasien['PEMERIKSAN_SARAF_TEPI'];
$hasil_pemeriksaan_penunjang = $dat_pasien['HASIL_PEMERIKSAAN_PENUNJANG'];
$rencana_tatalaksana = $dat_pasien['RENCANA_TATALAKSANA'];
$rencana_tatalaksana_non_farmaka = $dat_pasien['RENCANA_TATALAKSANA_NON_FARMAKA'];
$tanda_perubahan_kulit_saraf = $dat_pasien['TANDA_PERUBAHAN_KULIT_SARAF'];
$catatan_perubahan_kulit_saraf = $dat_pasien['CATATAN_TANDA_PERUBAHAN_KULIT_SARAF'];
$kode_tanda_kelainan = $dat_pasien['KODE_TANDA_KELAINAN'];
$final_kusta = $dat_pasien['FINAL'];
$tgl_assesment = $dat_pasien['TGL_ASSESMENT'];
$tgl_skr = $dat_pasien['TGL_SKR'];
$register_kusta = $dat_pasien['REGISTER'] . ' ' . $dat_pasien['REGISTER_DT'];

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
        jQuery("#diagnosa_16").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 760});
		jQuery("#diagnosa_17").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 760});
		jQuery("#diagnosa_18").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 760});
		jQuery("#diagnosa_19").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 760});
		jQuery("#diagnosa_20").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 760});
		jQuery("#diagnosa_21").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 760});
		jQuery("#diagnosa_22").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 760});
		jQuery("#diagnosa_23").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 760});
    });
</script>
<form name="formperiksa_35" id="formperiksa_35" method="post" action="http://<?php echo $_SERVER['SERVER_NAME']; ?>/nsimrs/index.php?link=74ac04efa30ba0f5fb861758cbad5b3a&smn=kjam&idx=<?php echo $idx; ?>" >
    <input type="hidden" name="idx" id="idx" value="<?php echo $idx_pam; ?>" />	
	<input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />	
	<input type="hidden" name="ls_assesment" id="ls_assesment" value="<?php echo $tgl_assesment; ?>" />	
	<input type="hidden" name="ls_final" id="ls_final" value="<?php echo $final; ?>" />	
	<input type="hidden" name="tgl_skr" id="tgl_skr" value="<?php echo $tgl_skr; ?>" />
	<input type="hidden" name="pam" id="pam" value="35" />
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
			<td>&nbsp;</td>
			<td valign="top" >Riwayat Kontak</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="anamnesis_riwayat_kontak" class="text_dt10" ><?php echo $anamnesis_riwayat_kontak; ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Riwayat Pengobatan Kusta Sebelumnya</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="anamnesis_riwayat_pengobatan" class="text_dt10" ><?php echo $anamnesis_riwayat_pengobatan; ?></textarea></td>
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
			<td>Kepala</td>
			<td>:</td>
			<td><input type="text" name="pm_kepala" value="<?php echo ((isset($pemeriksaan_fisik['pm_kepala'])) ? $pemeriksaan_fisik['pm_kepala'] : ''); ?>" class="text_dt" ></td>
			<td>&nbsp;</td>
			<td>BB</td>
			<td>:</td>
			<td><input type="text" name="pm_bb" value="<?php echo ((isset($pemeriksaan_fisik['pm_bb'])) ? $pemeriksaan_fisik['pm_bb'] : ''); ?>" class="text_dt" >&nbsp;kg</td>
		</tr>
		<tr>	
			<td>&nbsp;</td>
			<td>Leher</td>
			<td>:</td>
			<td><input type="text" name="pm_leher" value="<?php echo ((isset($pemeriksaan_fisik['pm_leher'])) ? $pemeriksaan_fisik['pm_leher'] : ''); ?>" class="text_dt" ></td>
			<td>&nbsp;</td>
			<td>RR</td>
			<td>:</td>
			<td><input type="text" name="pm_rr" value="<?php echo ((isset($pemeriksaan_fisik['pm_rr'])) ? $pemeriksaan_fisik['pm_rr'] : ''); ?>" class="text_dt" >&nbsp;x/menit</td>
		</tr>
		<tr>	
			<td>&nbsp;</td>
			<td>Dada</td>
			<td>:</td>
			<td>Jantung</td>
			<td colspan="4"><input type="text" name="pm_jantung" value="<?php echo ((isset($pemeriksaan_fisik['pm_jantung'])) ? $pemeriksaan_fisik['pm_jantung'] : ''); ?>" class="text_dt" style="width:550px;"></td>
		</tr>
		<tr>	
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>Paru</td> 
			<td colspan="4"><input type="text" name="pm_paru" value="<?php echo ((isset($pemeriksaan_fisik['pm_paru'])) ? $pemeriksaan_fisik['pm_paru'] : ''); ?>" class="text_dt" style="width:550px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Abdomen</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="pm_abdomen" value="<?php echo ((isset($pemeriksaan_fisik['pm_abdomen'])) ? $pemeriksaan_fisik['pm_abdomen'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Extremitas</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="pm_extremitas" value="<?php echo ((isset($pemeriksaan_fisik['pm_extremitas'])) ? $pemeriksaan_fisik['pm_extremitas'] : ''); ?>" class="text_dt" style="width:755px;"></td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Status Lokalis</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="status_lokalis" class="text_dt11" ><?php echo $status_lokalis; ?></textarea></td>
        </tr>
		<tr>
            <td valign="top" colspan="2">Pemeriksaan Saraf Tepi</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="pemeriksaan_saraf_tepi" class="text_dt11" ><?php echo $pemeriksaan_saraf_tepi; ?></textarea></td>
        </tr>
        <tr>
            <td valign="top" colspan="2">Hasil Pemeriksaan Penunjang</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="hasil_pemeriksaan_penunjang" class="text_dt11" ><?php echo $hasil_pemeriksaan_penunjang; ?></textarea></td>
        </tr>
		<tr>
            <td valign="top" colspan="2" rowspan="4">Diagnosa</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="diagnosa_0" id="diagnosa_16" value="<?php echo ((isset($diagnosa[0])) ? $diagnosa[0] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td valign="top">&nbsp;</td>
			<td colspan="5"><input type="text" name="diagnosa_1" id="diagnosa_17" value="<?php echo ((isset($diagnosa[1])) ? $diagnosa[1] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td valign="top">&nbsp;</td>
			<td colspan="5"><input type="text" name="diagnosa_2" id="diagnosa_18" value="<?php echo ((isset($diagnosa[2])) ? $diagnosa[2] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td valign="top">&nbsp;</td>
			<td colspan="5"><input type="text" name="diagnosa_3" id="diagnosa_19" value="<?php echo ((isset($diagnosa[3])) ? $diagnosa[3] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
            <td valign="top" colspan="2" rowspan="4">Diagnosa Banding</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="diagnosa_4" id="diagnosa_20" value="<?php echo ((isset($diagnosa[4])) ? $diagnosa[4] : ''); ?>" class="text_dt" style="width:755px;" ></td></tr>
			<tr><td>&nbsp;</td><td colspan="5"><input type="text" name="diagnosa_5" id="diagnosa_21" value="<?php echo ((isset($diagnosa[5])) ? $diagnosa[5] : ''); ?>" class="text_dt" style="width:755px;" ></td></tr>
			<tr><td>&nbsp;</td><td colspan="5"><input type="text" name="diagnosa_6" id="diagnosa_22" value="<?php echo ((isset($diagnosa[6])) ? $diagnosa[6] : ''); ?>" class="text_dt" style="width:755px;" ></td></tr>
			<tr><td>&nbsp;</td><td colspan="5"><input type="text" name="diagnosa_7" id="diagnosa_23" value="<?php echo ((isset($diagnosa[7])) ? $diagnosa[7] : ''); ?>" class="text_dt" style="width:755px;" ></td></tr>
		
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
		<tr>
            <td valign="top" colspan="8">Berilah tanda-tanda kelainan pada gambar tubuh ini &nbsp;&nbsp;:</td>
        </tr>
	   <tr>
			<td valign="top" colspan="2">&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5" align="center">
				<canvas id="canvas_35" style="border:5px;"></canvas>
				<button type="button" class="button clear" onclick="undoCanvas_35();" style="width:770px;">Undo</button>
				<button type="button" class="button clear" onclick="clearCanvas_35();" style="width:120px;">Clear</button>
				<br/><br/>
				<table border="0">
					<tr>
						<td><input type="radio" name="simbol" id="simbol_9" value="1" />&nbsp;<img src="edoc_rekammedik/new/kusta/kusta_1_ket.jpg" width="20px" height="20px">&nbsp;Hypo Pigmentasi</td>
						<td><input type="radio" name="simbol" id="simbol_10" value="2" />&nbsp;<img src="edoc_rekammedik/new/kusta/kusta_2_ket.jpg" width="20px" height="20px">&nbsp;Hypo/ Anaesthesia</td>
						<td><input type="radio" name="simbol" id="simbol_11" value="3" />&nbsp;<img src="edoc_rekammedik/new/kusta/kusta_3_ket.jpg" width="20px" height="20px">&nbsp;Kelainan di kulit dengan batas tegas<br/></td>
					</tr>	
					<tr>
						<td colspan="3"><input type="radio" name="simbol" id="simbol_12" value="4" />&nbsp;<img src="edoc_rekammedik/new/kusta/kusta_4_ket.jpg" width="20px" height="20px">&nbsp;Kelainan kulit dengan hypo Pigmentasi dan Hypo/ Anaesthesia dengan batas tegas<br/></td>
					</tr>
					<tr>
						<td><input type="radio" name="simbol" id="simbol_13" value="5" />&nbsp;<img src="edoc_rekammedik/new/kusta/kusta_5_ket.jpg" width="20px" height="20px">&nbsp;Kelainan di kulit difus dan rata</td>
						<td><input type="radio" name="simbol" id="simbol_14" value="6" />&nbsp;<img src="edoc_rekammedik/new/kusta/kusta_6_ket.jpg" width="20px" height="20px">&nbsp;Infeksi yang difus</td>
						<td><input type="radio" name="simbol" id="simbol_15" value="7" />&nbsp;<img src="edoc_rekammedik/new/kusta/kusta_7_ket.jpg" width="20px" height="20px">&nbsp;Tonjolan (Papel, Nodule)<br/></td>
					</tr>
					<tr>
						<td><input type="radio" name="simbol" id="simbol_16" value="8" />&nbsp;<img src="edoc_rekammedik/new/kusta/kusta_8_ket.jpg" width="20px" height="20px">&nbsp;Penebalan urat saraf</td>
						<td><input type="radio" name="simbol" id="simbol_17" value="9" />&nbsp;<img src="edoc_rekammedik/new/kusta/kusta_9_ket.jpg" width="20px" height="20px">&nbsp;Alis mata rontok (Madarosis)</td>
						<td><input type="radio" name="simbol" id="simbol_18" value="10" />&nbsp;<img src="edoc_rekammedik/new/kusta/kusta_10_ket.jpg" width="20px" height="20px">&nbsp;Hidung pelana (Penyok)<br/></td>
					</tr>
					<tr>
						<td><input type="radio" name="simbol" id="simbol_19" value="11" />&nbsp;<img src="edoc_rekammedik/new/kusta/kusta_11_ket.jpg" width="20px" height="20px">&nbsp;Kontraktur</td>
						<td colspan="2"><input type="radio" name="simbol" id="simbol_20" value="12" />&nbsp;<img src="edoc_rekammedik/new/kusta/kusta_12_ket.jpg" width="20px" height="20px">&nbsp;Hilangnya jari-jari atau bagian dari anggota gerak (Mutilasi)<br/></td>
					</tr>
					<tr>
						<td><input type="radio" name="simbol" id="simbol_21" value="13" />&nbsp;<img src="edoc_rekammedik/new/kusta/kusta_13_ket.jpg" width="20px" height="20px">&nbsp;Atrophy otot</td>
						<td><input type="radio" name="simbol" id="simbol_22" value="14" />&nbsp;<img src="edoc_rekammedik/new/kusta/kusta_14_ket.jpg" width="20px" height="20px">&nbsp;Ulkus Trophis</td>
						<td><input type="radio" name="simbol" id="simbol_23" value="15" />&nbsp;<img src="edoc_rekammedik/new/kusta/kusta_15_ket.jpg" width="20px" height="20px">&nbsp;Drop foot, Wrist drop</td>
					</tr>
					<tr>
						<td colspan="2"><input type="radio" name="simbol" id="simbol_24" value="16" />&nbsp;<img src="edoc_rekammedik/new/kusta/kusta_16_ket.jpg" width="20px" height="20px">&nbsp;Pembesaran buah dada pada penderita laki-laki (Ginaccomasti)</td>
						<td><input type="radio" name="simbol" id="simbol_25" value="17" />&nbsp;<img src="edoc_rekammedik/new/kusta/kusta_17_ket.jpg" width="20px" height="20px">&nbsp;Perut bekas infiltrat (sigaret paper) yang tidak aktif lagi</td>
					</tr>
					<tr>
						<td><input type="radio" name="simbol" id="simbol_26" value="18" />&nbsp;<img src="edoc_rekammedik/new/kusta/kusta_18_ket.jpg" width="20px" height="20px">&nbsp;Pembesaran Testis</td>
						<td><input type="radio" name="simbol" id="simbol_27" value="19" />&nbsp;<img src="edoc_rekammedik/new/kusta/kusta_19_ket.jpg" width="20px" height="20px">&nbsp;Logof talmus</td>
						<td><input type="radio" name="simbol" id="simbol_28" value="20" checked />&nbsp;Bebas</td>
					</tr>
				</table>
				<br/>
			</td>
		</tr>
		<tr>
            <td valign="top" colspan="2">Catatan</td>
			<td valign="top">:</td>
			<td colspan="5" align="center"><textarea name="catatan_perubahan_kulit_saraf" id="catatan_perubahan_kulit_saraf" class="text_dt11" style="height:200px;width:896px;"><?php echo $catatan_perubahan_kulit_saraf; ?></textarea></td>
        </tr>
		<tr>
            <td colspan="8">&nbsp;</td>
        </tr>
        <tr><td colspan="8" align="right" >
			Update : <?php echo $register_kusta; ?>
			<input type="checkbox" name="final" id="final" value="1" <?php echo (($final_kusta == '1') ? 'checked' : ''); ?> />&nbsp;Final&nbsp;&nbsp;&nbsp;&nbsp;
			<?php if(isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])){ ?>
				<?php if($final_kusta == '1'){ ?>
					<?php if($dokter_pjawab == $_SESSION['SES_SIMRS_PEGAWAI_ID']){ ?>
						<input type="button" value="simpan" class="myButton1" onclick="simpan_35();"/>
					<?php } ?>
				<?php }else{ ?>
					<input type="button" value="simpan" class="myButton1" onclick="simpan_35();"/>
				<?php } ?>
			<?php } ?>
		
			<?php if(!empty($idx)){ 
				$sql_view_rm = 'SELECT FILE_ID FROM t_rm_dokumen_file
						WHERE JNS_PERAWATAN = "2"
						AND NOMR = "' . $nomr . '"
						AND RAWAT_ID = "' . $idx . '"
						AND JENIS_DOKUMEN_ID = "22"
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
	<?php if($final_kusta == '1'){ ?>
		<?php if($dokter_pjawab != $_SESSION['SES_SIMRS_PEGAWAI_ID']){ ?>
			$(':input').attr('readonly','readonly');
		<?php } ?>
	<?php } ?>
<?php }else{ ?>
	$(':input').attr('readonly','readonly');
<?php } ?>

const canvas_35 = document.getElementById("canvas_35");
var context_35 = canvas_35.getContext('2d'); 
var cPushArray_35 = new Array();
var cStep_35 = -1;

var img9 = new Image();
img9.src = "edoc_rekammedik/new/kusta/kusta_1.png";

var img10 = new Image();
img10.src = "edoc_rekammedik/new/kusta/kusta_2.png";

var img11 = new Image();
img11.src = "edoc_rekammedik/new/kusta/kusta_3.png";

var img12 = new Image();
img12.src = "edoc_rekammedik/new/kusta/kusta_4.png";

var img13 = new Image();
img13.src = "edoc_rekammedik/new/kusta/kusta_5.png";

var img14 = new Image();
img14.src = "edoc_rekammedik/new/kusta/kusta_6.png";

var img15 = new Image();
img15.src = "edoc_rekammedik/new/kusta/kusta_7.png";

var img16 = new Image();
img16.src = "edoc_rekammedik/new/kusta/kusta_8.png";

var img17 = new Image();
img17.src = "edoc_rekammedik/new/kusta/kusta_9.png";

var img18 = new Image();
img18.src = "edoc_rekammedik/new/kusta/kusta_10.png";

var img19 = new Image();
img19.src = "edoc_rekammedik/new/kusta/kusta_11.png";

var img20 = new Image();
img20.src = "edoc_rekammedik/new/kusta/kusta_12.png";

var img21 = new Image();
img21.src = "edoc_rekammedik/new/kusta/kusta_13.png";

var img22 = new Image();
img22.src = "edoc_rekammedik/new/kusta/kusta_14.png";

var img23 = new Image();
img23.src = "edoc_rekammedik/new/kusta/kusta_15.png";

var img24 = new Image();
img24.src = "edoc_rekammedik/new/kusta/kusta_16.png";

var img25 = new Image();
img25.src = "edoc_rekammedik/new/kusta/kusta_17.png";

var img26 = new Image();
img26.src = "edoc_rekammedik/new/kusta/kusta_18.png";

var img27 = new Image();
img27.src = "edoc_rekammedik/new/kusta/kusta_19.png";

function clearCanvas_35(){
	if(confirm('Bersihkan ?')){
		var img_ori = new Image();
		img_ori.onload = function(){
			context_35.drawImage(img_ori,0,0); // Or at whatever offset you like
		};
		img_ori.src = "edoc_rekammedik/new/pengkajian_awal_medis_kusta_perubahan_kulit_d_urat_saraf.jpg";
		cPush_35();
	}	
}

function cPush_35() {
    cStep_35++;
	if (cStep_35 < cPushArray_35.length) { cPushArray_35.length = cStep_35; }
    cPushArray_35.push(canvas_35.toDataURL());
}

function undoCanvas_35(){
	if (cStep_35 > 0) {
        cStep_35--;
		var canvasPic = new Image();
		canvasPic.onload = function(){
			context_35.drawImage(canvasPic,0,0); // Or at whatever offset you like
		};
		canvasPic.src = cPushArray_35[cStep_35 - 1];
    }
}	

function load_35(){
	canvas_35.width = 896; 
	canvas_35.height = 731; 
	
	var img_def = new Image();
	img_def.onload = function(){
		context_35.drawImage(img_def,0,0); // Or at whatever offset you like
	};
	<?php if(trim($tanda_perubahan_kulit_saraf) != '') { ?>
		img_def.src = 'http://<?php echo $_SERVER['SERVER_NAME']?>/erekammedik/pengkajian_awal_medik_kusta/<?php echo $tanda_perubahan_kulit_saraf; ?>';
	<?php }else{ ?>	
		img_def.src = 'edoc_rekammedik/new/pengkajian_awal_medis_kusta_perubahan_kulit_d_urat_saraf.jpg';
	<?php } ?>
}

function simpan_submit_35(){
	var image = canvas_35.toDataURL("image/jpg");	
	$.ajax({
			type: 'POST',
			url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/index.php?ajaxrequest=ranapaddperubahankulitsaraf',
			data: { img: image,
				idx_pam : '<?php echo $idx_pam; ?>',
				irna_id : '<?php echo $irna_id; ?>',
				nomr : '<?php echo $nomr; ?>'
				},
			cache: false,
			success: function(data) {
				
				if (data != ''){ 
					if(data == 'ok'){
						 $("#formperiksa_35").submit();
					}else{
						alert(data);
					}		
				}		
				
			},});	
}

function simpan_35(){
	_haschange = false;
	simpan_submit_35();
}

function setGambar_35(canvas, event) {
    const rect = canvas.getBoundingClientRect()
    const x = event.clientX - rect.left;
    const y = event.clientY - rect.top;
	
    if(cStep_35 < 0){
		cPush_35();
	}	
	
	if (document.getElementById('simbol_9').checked){
		context_35.drawImage(img9,x-10,y-10,25,25);
	}
	if (document.getElementById('simbol_10').checked){
		context_35.drawImage(img10,x-10,y-10,25,25);
	}
	if (document.getElementById('simbol_11').checked){
		context_35.drawImage(img11,x-10,y-10,40,40);
	}
	if (document.getElementById('simbol_12').checked){
		context_35.drawImage(img12,x-10,y-10,25,25);
	}
	if (document.getElementById('simbol_13').checked){
		context_35.drawImage(img13,x-10,y-10,25,25);
	}
	if (document.getElementById('simbol_14').checked){
		context_35.drawImage(img14,x-10,y-10,25,25);
	}
	if (document.getElementById('simbol_15').checked){
		context_35.drawImage(img15,x-10,y-10,40,40);
	}
	if (document.getElementById('simbol_16').checked){
		context_35.drawImage(img16,x-10,y-10,25,25);
	}
	if (document.getElementById('simbol_17').checked){
		context_35.drawImage(img17,x-10,y-10,30,30);
	}
	if (document.getElementById('simbol_18').checked){
		context_35.drawImage(img18,x-10,y-10,50,50);
	}
	if (document.getElementById('simbol_19').checked){
		context_35.drawImage(img19,x-10,y-10,30,30);
	}
	if (document.getElementById('simbol_20').checked){
		context_35.drawImage(img20,x-10,y-10,50,50);
	}
	if (document.getElementById('simbol_21').checked){
		context_35.drawImage(img21,x-10,y-10,50,50);
	}
	if (document.getElementById('simbol_22').checked){
		context_35.drawImage(img22,x-10,y-10,50,50);
	}
	if (document.getElementById('simbol_23').checked){
		context_35.drawImage(img23,x-10,y-10,50,50);
	}
	if (document.getElementById('simbol_24').checked){
		context_35.drawImage(img24,x-10,y-10,35,35);
	}
	if (document.getElementById('simbol_25').checked){
		context_35.drawImage(img25,x-10,y-10,40,40);
	}
	if (document.getElementById('simbol_26').checked){
		context_35.drawImage(img26,x-10,y-10,35,35);
	}
	if (document.getElementById('simbol_27').checked){
		context_35.drawImage(img27,x-10,y-10,40,40);
	}
	if (document.getElementById('simbol_28').checked){
		context_35.drawImage(img28,x-10,y-10,50,50);
	}	
	cPush_35();
}

function Draw_35(x, y, isDown) {
    if (isDown) {
        context_35.beginPath();
        context_35.strokeStyle = 'red';
        context_35.lineWidth = 3;
        context_35.lineJoin = "round";
        context_35.moveTo(lastX, lastY);
        context_35.lineTo(x, y);
        context_35.closePath();
        context_35.stroke();
    }
    lastX = x;
    lastY = y;
}

canvas_35.addEventListener('mousedown', function(e) {
	if (document.getElementById('simbol_28').checked){
		mousePressed = true;
        Draw_35(e.pageX - $(this).offset().left, e.pageY - $(this).offset().top, false);
    }else{
		setGambar_35(canvas_35, e)
	}	
})

canvas_35.addEventListener('mousemove', function(e) {
	if (mousePressed) {
        Draw_35(e.pageX - $(this).offset().left, e.pageY - $(this).offset().top, true);
   }	
})

canvas_35.addEventListener('mouseup', function(e) {
	if (mousePressed) {
        mousePressed = false;
        cPush_35();
    }	
})

canvas_35.addEventListener('mouseleave', function(e) {
	if (mousePressed) {
		mousePressed = false;
        cPush_35();
	}	
})

load_35();	
</script>