<?php
function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = str_replace('|',"!",$str);
	$ret = htmlspecialchars($ret);
	return $ret;
}
	
if (isset($_POST['irja_id'])){
	$st_save = true;
	if($st_save){

		$pemeriksaan_fisik = array('pm_keadaan_umum'=>replace_quote($_POST['pm_keadaan_umum']),
						'pm_tanda_vital'=>replace_quote($_POST['pm_tanda_vital']),
						'pm_td'=>replace_quote($_POST['pm_td']),
						'pm_nadi'=>replace_quote($_POST['pm_nadi']),
						'pm_rr'=>replace_quote($_POST['pm_rr']),
						'pm_tb'=>replace_quote($_POST['pm_tb']),
						'pm_bb'=>replace_quote($_POST['pm_bb']),
						'pm_bmi'=>replace_quote($_POST['pm_bmi']));
		$pemeriksaan_fisik = json_encode($pemeriksaan_fisik);
		$pemeriksaan_fisik = str_replace('"','|',$pemeriksaan_fisik);
		
		$pemeriksaan_kepala = array('pk_kepala'=>replace_quote($_POST['pk_kepala']),
						'pk_mata'=>replace_quote($_POST['pk_mata']),
						'pk_tht'=>replace_quote($_POST['pk_tht']),
						'pk_leher'=>replace_quote($_POST['pk_leher']));
		$pemeriksaan_kepala = json_encode($pemeriksaan_kepala);
		$pemeriksaan_kepala = str_replace('"','|',$pemeriksaan_kepala);
		
		$pemeriksaan_thorax = array('pt_dada'=>replace_quote($_POST['pt_dada']),
						'pt_inspeksi'=>replace_quote($_POST['pt_inspeksi']),
						'pt_palpasi'=>replace_quote($_POST['pt_palpasi']),
						'pt_auskultasi'=>replace_quote($_POST['pt_auskultasi']),
						'pt_cor'=>replace_quote($_POST['pt_cor']),
						'pt_pulmo'=>replace_quote($_POST['pt_pulmo']));
		$pemeriksaan_thorax = json_encode($pemeriksaan_thorax);
		$pemeriksaan_thorax = str_replace('"','|',$pemeriksaan_thorax);
		
		$pemeriksaan_abdomen = array('pa_inspeksi'=>replace_quote($_POST['pa_inspeksi']),
						'pa_abdomen'=>replace_quote($_POST['pa_abdomen']),
						'pa_palpasi'=>replace_quote($_POST['pa_palpasi']),
						'pa_hepar'=>replace_quote($_POST['pa_hepar']),
						'pa_lien'=>replace_quote($_POST['pa_lien']),
						'pa_auskultasi'=>replace_quote($_POST['pa_auskultasi']));
		$pemeriksaan_abdomen = json_encode($pemeriksaan_abdomen);
		$pemeriksaan_abdomen = str_replace('"','|',$pemeriksaan_abdomen);
		
		$pemeriksaan_ekstremitas = array('pe_ekstremitas'=>replace_quote($_POST['pe_ekstremitas']),
						'pe_lain'=>replace_quote($_POST['pe_lain']));
		$pemeriksaan_ekstremitas = json_encode($pemeriksaan_ekstremitas);
		$pemeriksaan_ekstremitas = str_replace('"','|',$pemeriksaan_ekstremitas);
		
		$pemeriksaan_laboratorium = array('plab_darah'=>replace_quote($_POST['plab_darah']),
						'plab_urin'=>replace_quote($_POST['plab_urin']),
						'plab_kimia'=>replace_quote($_POST['plab_kimia']),
						'plab_gds'=>replace_quote($_POST['plab_gds']),
						'plab_sgot'=>replace_quote($_POST['plab_sgot']),
						'plab_ureum'=>replace_quote($_POST['plab_ureum']),
						'plab_kolesterol'=>replace_quote($_POST['plab_kolesterol']),
						'plab_hbsag'=>replace_quote($_POST['plab_hbsag']),
						'plab_hiv'=>replace_quote($_POST['plab_hiv']));
		$pemeriksaan_laboratorium = json_encode($pemeriksaan_laboratorium);
		$pemeriksaan_laboratorium = str_replace('"','|',$pemeriksaan_laboratorium);
	
		if(empty($_POST['idx'])){		
			mysql_query('INSERT INTO t_irja_pemeriksaan_mcu (IRJA_MCU_ID,KELUHAN,RIWAYAT_PENYAKIT,RIWAYAT_PENYAKIT_KELUARGA,
				PEMERIKSAAN_FISIK,PEMERIKSAAN_FISIK_KEPALA,PEMERIKSAAN_FISIK_THORAX,PEMERIKSAAN_FISIK_ABDOMEN,
				PEMERIKSAAN_FISIK_EKSTRIMITAS,PEMERIKSAAN_LABORATORIUM,PEMERIKSAAN_KARDIOLOGI,PEMERIKSAAN_RADIOLOGI,
				PEMERIKSAAN_MATA,PEMERIKSAAN_LAIN,RESUME,KESIMPULAN,CATATAN,TGL_ASSESMENT,REGISTER,NOMOR) 
				VALUES ("' . $_POST['irja_id'] . '",
				"' . replace_quote($_POST['keluhan']) . '",
				"' . replace_quote($_POST['riwayat_penyakit_dahulu']) . '",
				"' . replace_quote($_POST['riwayat_penyakit_keluarga']) . '",
				"' . $pemeriksaan_fisik . '","' . $pemeriksaan_kepala . '",
				"' . $pemeriksaan_thorax . '","' . $pemeriksaan_abdomen . '",
				"' . $pemeriksaan_ekstremitas . '","' . $pemeriksaan_laboratorium . '",
				"' . replace_quote($_POST['pem_kardiologi']) . '",
				"' . replace_quote($_POST['pem_radiologi']) . '",
				"' . replace_quote($_POST['pem_mata']) . '",
				"' . replace_quote($_POST['pem_lain']) . '",
				"' . replace_quote($_POST['resume']) . '",
				"' . replace_quote($_POST['kesimpulan']) . '",
				"' . replace_quote($_POST['catatan']) . '",
				NOW(),"' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
				"' . replace_quote($_POST['nomor']) . '")') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_irja_pemeriksaan_mcu 
				SET KELUHAN = "' . replace_quote($_POST['keluhan']) . '",
				RIWAYAT_PENYAKIT = "' . replace_quote($_POST['riwayat_penyakit_dahulu']) . '",
				RIWAYAT_PENYAKIT_KELUARGA = "' . replace_quote($_POST['riwayat_penyakit_keluarga']) . '",
				PEMERIKSAAN_FISIK = "' . $pemeriksaan_fisik . '",
				PEMERIKSAAN_FISIK_KEPALA = "' . $pemeriksaan_kepala . '",
				PEMERIKSAAN_FISIK_THORAX = "' . $pemeriksaan_thorax . '",
				PEMERIKSAAN_FISIK_ABDOMEN = "' . $pemeriksaan_abdomen . '",
				PEMERIKSAAN_FISIK_EKSTRIMITAS = "' . $pemeriksaan_ekstremitas . '",
				PEMERIKSAAN_LABORATORIUM = "' . $pemeriksaan_laboratorium . '",
				PEMERIKSAAN_KARDIOLOGI = "' . replace_quote($_POST['pem_kardiologi']) . '",
				PEMERIKSAAN_RADIOLOGI = "' . replace_quote($_POST['pem_radiologi']) . '",
				PEMERIKSAAN_MATA = "' . replace_quote($_POST['pem_mata']) . '",
				PEMERIKSAAN_LAIN = "' . replace_quote($_POST['pem_lain']) . '",
				RESUME = "' . replace_quote($_POST['resume']) . '",
				KESIMPULAN = "' . replace_quote($_POST['kesimpulan']) . '",
				CATATAN = "' . replace_quote($_POST['catatan']) . '",
				TGL_ASSESMENT = NOW(),
				REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
				ST_CREATE_ERM = NULL,
				NOMOR = "' . replace_quote($_POST['nomor']) . '"
				WHERE IRJA_MCU_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());
		}
		
		?>
		<script language="JavaScript" >
			alert('Simpan Pemeriksaan MCU Berhasil.');
			window.location = "<?php echo currentUrl(); ?>";
		</script>
		<?php 
	}else{
		$msg_info = 'Harus Oleh Dokter DPJP.';
	}	
}
$qry_pasien = 'SELECT IRJA_MCU_ID,KELUHAN,RIWAYAT_PENYAKIT,RIWAYAT_PENYAKIT_KELUARGA,PEMERIKSAAN_FISIK,
			PEMERIKSAAN_FISIK_KEPALA,PEMERIKSAAN_FISIK_THORAX,PEMERIKSAAN_FISIK_ABDOMEN,PEMERIKSAAN_FISIK_EKSTRIMITAS,
			PEMERIKSAAN_LABORATORIUM,PEMERIKSAAN_KARDIOLOGI,PEMERIKSAAN_RADIOLOGI,PEMERIKSAAN_MATA,PEMERIKSAAN_LAIN,
			RESUME,KESIMPULAN,CATATAN,NOMOR
			FROM t_irja_pemeriksaan_mcu
			WHERE IRJA_MCU_ID = "' . $_GET['idx'] . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$idx = $dat_pasien['IRJA_MCU_ID'];
$nomor = $dat_pasien['NOMOR'];
$keluhan = $dat_pasien['KELUHAN'];
$riwayat_penyakit_dahulu = $dat_pasien['RIWAYAT_PENYAKIT'];
$riwayat_penyakit_keluarga = $dat_pasien['RIWAYAT_PENYAKIT_KELUARGA'];

$pemeriksaan_fisik = str_replace('|','"',$dat_pasien['PEMERIKSAAN_FISIK']);
$pemeriksaan_fisik = preg_replace('/\r|\n/','\n',trim($pemeriksaan_fisik));
$pemeriksaan_fisik = json_decode($pemeriksaan_fisik,true);

$pemeriksaan_kepala = str_replace('|','"',$dat_pasien['PEMERIKSAAN_FISIK_KEPALA']);
$pemeriksaan_kepala = preg_replace('/\r|\n/','\n',trim($pemeriksaan_kepala));
$pemeriksaan_kepala = json_decode($pemeriksaan_kepala,true);

$pemeriksaan_thorax = str_replace('|','"',$dat_pasien['PEMERIKSAAN_FISIK_THORAX']);
$pemeriksaan_thorax = preg_replace('/\r|\n/','\n',trim($pemeriksaan_thorax));
$pemeriksaan_thorax = json_decode($pemeriksaan_thorax,true);

$pemeriksaan_abdomen = str_replace('|','"',$dat_pasien['PEMERIKSAAN_FISIK_ABDOMEN']);
$pemeriksaan_abdomen = preg_replace('/\r|\n/','\n',trim($pemeriksaan_abdomen));
$pemeriksaan_abdomen = json_decode($pemeriksaan_abdomen,true);

$pemeriksaan_ekstremitas = str_replace('|','"',$dat_pasien['PEMERIKSAAN_FISIK_EKSTRIMITAS']);
$pemeriksaan_ekstremitas = preg_replace('/\r|\n/','\n',trim($pemeriksaan_ekstremitas));
$pemeriksaan_ekstremitas = json_decode($pemeriksaan_ekstremitas,true);

$pemeriksaan_laboratorium = str_replace('|','"',$dat_pasien['PEMERIKSAAN_LABORATORIUM']);
$pemeriksaan_laboratorium = preg_replace('/\r|\n/','\n',trim($pemeriksaan_laboratorium));
$pemeriksaan_laboratorium = json_decode($pemeriksaan_laboratorium,true);

$pem_kardiologi = $dat_pasien['PEMERIKSAAN_KARDIOLOGI'];
$pem_radiologi = $dat_pasien['PEMERIKSAAN_RADIOLOGI'];
$pem_mata = $dat_pasien['PEMERIKSAAN_MATA'];
$pem_lain = $dat_pasien['PEMERIKSAAN_LAIN'];

$resume = $dat_pasien['RESUME'];
$kesimpulan = $dat_pasien['KESIMPULAN'];
$catatan = $dat_pasien['CATATAN'];
?>
<form name="formperiksa" id="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="idx" id="idx" value="<?php echo $idx; ?>" />	
	<input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
	<table border="0" align="center" style="position:static; " width="90%">
		<tr>
			<td colspan="2">Nomor</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="nomor" value="<?php echo $nomor; ?>" class="text_dt" style="width:200px;" ></td>
		</tr>
		<tr>
            <td colspan="8">&nbsp;</td>
        </tr>
        <tr>
			<td colspan="8">ANAMNESIS</td>
		</tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">Keluhan</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><textarea name="keluhan" class="text_dt10" ><?php echo $keluhan; ?></textarea></td>
		</tr>	
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Riwayat Penyakit Terdahulu</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="riwayat_penyakit_dahulu" class="text_dt10" ><?php echo $riwayat_penyakit_dahulu; ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Riwayat Penyakit Keluarga</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="riwayat_penyakit_keluarga" class="text_dt10" ><?php echo $riwayat_penyakit_keluarga; ?></textarea></td>
		</tr>
		<tr>
			<td colspan="8">PEMERIKSAAN FISIK</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Keadaan Umum</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="pm_keadaan_umum" value="<?php echo ((isset($pemeriksaan_fisik['pm_keadaan_umum'])) ? $pemeriksaan_fisik['pm_keadaan_umum'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Tanda Vital</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="pm_tanda_vital" value="<?php echo ((isset($pemeriksaan_fisik['pm_tanda_vital'])) ? $pemeriksaan_fisik['pm_tanda_vital'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>	
		<tr>	
			<td>&nbsp;</td>	
			<td>Tekanan Darah</td>
			<td>:</td>
			<td width="250px"><input type="text" name="pm_td" value="<?php echo ((isset($pemeriksaan_fisik['pm_td'])) ? $pemeriksaan_fisik['pm_td'] : ''); ?>" class="text_dt" >&nbsp;mmHg</td>
			<td width="130px">&nbsp;</td>
			<td width="95px">&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>	
			<td>&nbsp;</td>			
			<td>Nadi</td>
			<td>:</td>
			<td><input type="text" name="pm_nadi" value="<?php echo ((isset($pemeriksaan_fisik['pm_nadi'])) ? $pemeriksaan_fisik['pm_nadi'] : ''); ?>" class="text_dt" >&nbsp;x/menit</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>	
			<td>&nbsp;</td>			
			<td>Nafas</td>
			<td>:</td>
			<td><input type="text" name="pm_rr" value="<?php echo ((isset($pemeriksaan_fisik['pm_rr'])) ? $pemeriksaan_fisik['pm_rr'] : ''); ?>" class="text_dt" >&nbsp;x/menit</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>	
			<td>&nbsp;</td>			
			<td>Tinggi Badan</td>
			<td>:</td>
			<td><input type="text" name="pm_tb" value="<?php echo ((isset($pemeriksaan_fisik['pm_tb'])) ? $pemeriksaan_fisik['pm_tb'] : ''); ?>" class="text_dt" >&nbsp;cm</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>	
			<td>&nbsp;</td>			
			<td>Berat Badan</td>
			<td>:</td>
			<td><input type="text" name="pm_bb" value="<?php echo ((isset($pemeriksaan_fisik['pm_bb'])) ? $pemeriksaan_fisik['pm_bb'] : ''); ?>" class="text_dt" >&nbsp;kg</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>	
			<td>&nbsp;</td>			
			<td>BMI</td>
			<td>:</td>
			<td><input type="text" name="pm_bmi" value="<?php echo ((isset($pemeriksaan_fisik['pm_bmi'])) ? $pemeriksaan_fisik['pm_bmi'] : ''); ?>" class="text_dt" >&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Kepala</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="pk_kepala" value="<?php echo ((isset($pemeriksaan_kepala['pk_kepala'])) ? $pemeriksaan_kepala['pk_kepala'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;&nbsp;Mata</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="pk_mata" value="<?php echo ((isset($pemeriksaan_kepala['pk_mata'])) ? $pemeriksaan_kepala['pk_mata'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;&nbsp;THT</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="pk_tht" value="<?php echo ((isset($pemeriksaan_kepala['pk_tht'])) ? $pemeriksaan_kepala['pk_tht'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;&nbsp;Leher</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="pk_leher" value="<?php echo ((isset($pemeriksaan_kepala['pk_leher'])) ? $pemeriksaan_kepala['pk_leher'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Thorax/ Dada</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="pt_dada" value="<?php echo ((isset($pemeriksaan_thorax['pt_dada'])) ? $pemeriksaan_thorax['pt_dada'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;&nbsp;Inspeksi</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="pt_inspeksi" value="<?php echo ((isset($pemeriksaan_thorax['pt_inspeksi'])) ? $pemeriksaan_thorax['pt_inspeksi'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;&nbsp;Palpasi</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="pt_palpasi" value="<?php echo ((isset($pemeriksaan_thorax['pt_palpasi'])) ? $pemeriksaan_thorax['pt_palpasi'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;&nbsp;Auskultasi</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="pt_auskultasi" value="<?php echo ((isset($pemeriksaan_thorax['pt_auskultasi'])) ? $pemeriksaan_thorax['pt_auskultasi'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;&nbsp;&nbsp;- COR</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="pt_cor" value="<?php echo ((isset($pemeriksaan_thorax['pt_cor'])) ? $pemeriksaan_thorax['pt_cor'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;&nbsp;&nbsp;- Pulmo</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="pt_pulmo" value="<?php echo ((isset($pemeriksaan_thorax['pt_pulmo'])) ? $pemeriksaan_thorax['pt_pulmo'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Abdomen</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="pa_abdomen" value="<?php echo ((isset($pemeriksaan_abdomen['pa_abdomen'])) ? $pemeriksaan_abdomen['pa_abdomen'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;&nbsp;Inspeksi</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="pa_inspeksi" value="<?php echo ((isset($pemeriksaan_abdomen['pa_inspeksi'])) ? $pemeriksaan_abdomen['pa_inspeksi'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;&nbsp;Palpasi</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="pa_palpasi" value="<?php echo ((isset($pemeriksaan_abdomen['pa_palpasi'])) ? $pemeriksaan_abdomen['pa_palpasi'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;&nbsp;&nbsp;- Hepar</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="pa_hepar" value="<?php echo ((isset($pemeriksaan_abdomen['pa_hepar'])) ? $pemeriksaan_abdomen['pa_hepar'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;&nbsp;&nbsp;- Lien</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="pa_lien" value="<?php echo ((isset($pemeriksaan_abdomen['pa_lien'])) ? $pemeriksaan_abdomen['pa_lien'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;&nbsp;Auskultasi</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="pa_auskultasi" value="<?php echo ((isset($pemeriksaan_abdomen['pa_auskultasi'])) ? $pemeriksaan_abdomen['pa_auskultasi'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Ekstremitas</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="pe_ekstremitas" value="<?php echo ((isset($pemeriksaan_ekstremitas['pe_ekstremitas'])) ? $pemeriksaan_ekstremitas['pe_ekstremitas'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Lain-lain</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="pe_lain" value="<?php echo ((isset($pemeriksaan_ekstremitas['pe_lain'])) ? $pemeriksaan_ekstremitas['pe_lain'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
            <td colspan="8">&nbsp;</td>
        </tr>
		<tr>
			<td colspan="8">PEMERIKSAAN PENUNJANG</td>
		</tr>
		<tr>
			<td colspan="8">LABORATORIUM</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Darah Lengkap</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="plab_darah" value="<?php echo ((isset($pemeriksaan_laboratorium['plab_darah'])) ? $pemeriksaan_laboratorium['plab_darah'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Urin Lengkap</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="plab_urin" value="<?php echo ((isset($pemeriksaan_laboratorium['plab_urin'])) ? $pemeriksaan_laboratorium['plab_urin'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Kimia Darah</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="plab_kimia" value="<?php echo ((isset($pemeriksaan_laboratorium['plab_kimia'])) ? $pemeriksaan_laboratorium['plab_kimia'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>GDS</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="plab_gds" value="<?php echo ((isset($pemeriksaan_laboratorium['plab_gds'])) ? $pemeriksaan_laboratorium['plab_gds'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>SGOT/ SGPT</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="plab_sgot" value="<?php echo ((isset($pemeriksaan_laboratorium['plab_sgot'])) ? $pemeriksaan_laboratorium['plab_sgot'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Ureum</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="plab_ureum" value="<?php echo ((isset($pemeriksaan_laboratorium['plab_ureum'])) ? $pemeriksaan_laboratorium['plab_ureum'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Kolesterol</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="plab_kolesterol" value="<?php echo ((isset($pemeriksaan_laboratorium['plab_kolesterol'])) ? $pemeriksaan_laboratorium['plab_kolesterol'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>HbSAg</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="plab_hbsag" value="<?php echo ((isset($pemeriksaan_laboratorium['plab_hbsag'])) ? $pemeriksaan_laboratorium['plab_hbsag'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>HIV</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="plab_hiv" value="<?php echo ((isset($pemeriksaan_laboratorium['plab_hiv'])) ? $pemeriksaan_laboratorium['plab_hiv'] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
            <td colspan="8">&nbsp;</td>
        </tr>
		<tr>
			<td COLSPAN="2">KARDIOLOGI</td>
			<td>:</td>
			<td colspan="5"><textarea name="pem_kardiologi" class="text_dt10" ><?php echo $pem_kardiologi; ?></textarea></td>
        </tr>
		<tr>
			<td COLSPAN="2">RADIOLOGI</td>
			<td>:</td>
			<td colspan="5"><textarea name="pem_radiologi" class="text_dt10" ><?php echo $pem_radiologi; ?></textarea></td>
        </tr>
		<tr>
			<td COLSPAN="2">Mata</td>
			<td>:</td>
			<td colspan="5"><textarea name="pem_mata" class="text_dt10" ><?php echo $pem_mata; ?></textarea></td>
		</tr>	
		<tr>
			<td COLSPAN="2">Lain-lain</td>
			<td>:</td>
			<td colspan="5"><textarea name="pem_lain" class="text_dt10" ><?php echo $pem_lain; ?></textarea></td>
		</tr>
		<tr>
            <td colspan="8">&nbsp;</td>
        </tr>
		<tr>
			<td COLSPAN="2">Resume</td>
			<td>:</td>
			<td colspan="5"><textarea name="resume" class="text_dt10" ><?php echo $resume; ?></textarea></td>
        </tr>
		<tr>
			<td COLSPAN="2">Kesimpulan</td>
			<td>:</td>
			<td colspan="5"><textarea name="kesimpulan" class="text_dt10" ><?php echo $kesimpulan; ?></textarea></td>
        </tr>	
		<tr>
			<td COLSPAN="2">Catatan</td>
			<td>:</td>
			<td colspan="5"><textarea name="catatan" class="text_dt10" ><?php echo $catatan; ?></textarea></td>
        </tr>		
        <tr>
            <td colspan="8">&nbsp;</td>
        </tr>
        <tr><td colspan="8" align="right" >
			<?php if($irja_final == ''){ ?>
			<input type="button" value="simpan" class="myButton1" onclick="simpan();"/>
			<?php if(!empty($idx)){ 
				$sql_view_rm = 'SELECT FILE_ID FROM t_rm_dokumen_file
						WHERE JNS_PERAWATAN = "1"
						AND NOMR = "' . $nomr . '"
						AND RAWAT_ID = "' . $idx . '"
						AND JENIS_DOKUMEN_ID = "55"
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

function simpan(){
	_haschange = false;
	$('#formperiksa').submit();
}	
</script>