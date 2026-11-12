<?php
function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = str_replace('|','!',$str);
	$ret = htmlspecialchars($ret);
	return $ret;
}
	
if (isset($_POST['idx'])){
	$st_save = true;
	if($st_save){
		$gelang_pasien = array('terpasang'=>((isset($_POST['gelang_pasien'])) ? $_POST['gelang_pasien'] : ''),
						'gelang_pasien_ket'=>replace_quote($_POST['gelang_pasien_ket']));
		$gelang_pasien = json_encode($gelang_pasien);
		$gelang_pasien = str_replace('"','|',$gelang_pasien);
		
		$alergi = array('ada_alergi'=>((isset($_POST['alergi'])) ? $_POST['alergi'] : ''),
						'alergi_ket'=>replace_quote($_POST['alergi_ket']),
						'gelang_alergi'=>((isset($_POST['gelang_alergi'])) ? $_POST['gelang_alergi'] : ''),
						'gelang_alergi_ket'=>replace_quote($_POST['gelang_alergi_ket']));
		$alergi = json_encode($alergi);
		$alergi = str_replace('"','|',$alergi);
		
		$akses_vaskular = array('cimino'=>((isset($_POST['akses_vaskular_cimino'])) ? $_POST['akses_vaskular_cimino'] : ''),
						'femoral'=>((isset($_POST['akses_vaskular_femoral'])) ? $_POST['akses_vaskular_femoral'] : ''),
						'double'=>((isset($_POST['akses_vaskular_double'])) ? $_POST['akses_vaskular_double'] : ''),
						'lain'=>((isset($_POST['akses_vaskular_lain'])) ? $_POST['akses_vaskular_lain'] : ''),
						'ket'=>replace_quote($_POST['akses_vaskular_ket']),
						'lokasi'=>replace_quote($_POST['akses_vaskular_lokasi']),
						'tanda_infeksi'=>((isset($_POST['akses_vaskular_tanda_infeksi'])) ? $_POST['akses_vaskular_tanda_infeksi'] : ''),
						'aneurisma'=>((isset($_POST['akses_vaskular_aneurisma'])) ? $_POST['akses_vaskular_aneurisma'] : ''),
						'thrill'=>((isset($_POST['akses_vaskular_thrill'])) ? $_POST['akses_vaskular_thrill'] : ''),
						'bruit'=>((isset($_POST['akses_vaskular_bruit'])) ? $_POST['akses_vaskular_bruit'] : ''),
						'lain_ket'=>replace_quote($_POST['akses_vaskular_ket']),
						'lumen_arteri'=>replace_quote($_POST['akses_vaskular_lumen_arteri']),
						'lumen_vena'=>replace_quote($_POST['akses_vaskular_lumen_vena']),
						'heparin_arteri'=>replace_quote($_POST['akses_vaskular_heparin_arteri']),
						'heparin_vena'=>replace_quote($_POST['akses_vaskular_heparin_vena']),
						'antibiotik_arteri'=>replace_quote($_POST['akses_vaskular_antibiotik_arteri']),
						'antibiotik_vena'=>replace_quote($_POST['akses_vaskular_antibiotik_vena']));
		$akses_vaskular = json_encode($akses_vaskular);
		$akses_vaskular = str_replace('"','|',$akses_vaskular);
		
		$mesin_hemodialisis = array('no'=>replace_quote($_POST['mesin_hemodialisis_no']),
						'wtp'=>replace_quote($_POST['mesin_hemodialisis_wtp']));
		$mesin_hemodialisis = json_encode($mesin_hemodialisis);
		$mesin_hemodialisis = str_replace('"','|',$mesin_hemodialisis);
		
		$dialisat = array('bicarbonat'=>((isset($_POST['dialisat_bicarbonat'])) ? $_POST['dialisat_bicarbonat'] : ''),
						'acid'=>((isset($_POST['dialisat_acid'])) ? $_POST['dialisat_acid'] : ''),
						'suhu'=>replace_quote($_POST['dialisat_suhu']));
		$dialisat = json_encode($dialisat);
		$dialisat = str_replace('"','|',$dialisat);
		
		$dialiser = array('model'=>replace_quote($_POST['dialiser_model']),
						'lowflux'=>((isset($_POST['dialiser_lowflux'])) ? $_POST['dialiser_lowflux'] : ''),
						'baru'=>((isset($_POST['dialiser_baru'])) ? $_POST['dialiser_baru'] : ''));
		$dialiser = json_encode($dialiser);
		$dialiser = str_replace('"','|',$dialiser);
		
		$bb_kering = array('bb'=>replace_quote($_POST['bb_kering']));
		$bb_kering = json_encode($bb_kering);
		$bb_kering = str_replace('"','|',$bb_kering);

		$resep_hd = array('lama'=>replace_quote($_POST['resep_hd_lama']),
						'ufg'=>replace_quote($_POST['resep_hd_ufg']),
						'qb'=>replace_quote($_POST['resep_hd_qb']),
						'heparin_reguler'=>((isset($_POST['resep_hd_heparin_reguler'])) ? $_POST['resep_hd_heparin_reguler'] : ''),
						'heparin_minimal'=>((isset($_POST['resep_hd_heparin_minimal'])) ? $_POST['resep_hd_heparin_minimal'] : ''),
						'heparin_free'=>((isset($_POST['resep_hd_heparin_free'])) ? $_POST['resep_hd_heparin_free'] : ''),
						'heparin_ec'=>replace_quote($_POST['resep_hd_heparin_ec']),
						'total'=>replace_quote($_POST['resep_hd_total']),
						'bolus'=>replace_quote($_POST['resep_hd_bolus']),
						'sirkulasi'=>replace_quote($_POST['resep_hd_sirkulasi']),
						'kontinyu'=>replace_quote($_POST['resep_hd_kontinyu']));
		$resep_hd = json_encode($resep_hd);
		$resep_hd = str_replace('"','|',$resep_hd);
		
		if($jns_order == ''){
			if(empty($_POST['pemantauan_id'])){		
				mysql_query('INSERT INTO t_irja_pemantauan_hemodialisis (IRJA_ID,GELANG_PASIEN,ALERGI,AKSES_VASKULAR,
					MESIN_HEMODIALISIS,DIALISAT,DIALISER,BB_KERING,RESEP_HD,TGL_ASSESMENT,REGISTER) 
					VALUES ("' . $_POST['idx'] . '","' . $gelang_pasien . '","' . $alergi . '",
					"' . $akses_vaskular . '","' . $mesin_hemodialisis . '","' . $dialisat . '",
					"' . $dialiser . '","' . $bb_kering . '","' . $resep_hd . '",
					NOW(),"' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '")') or die(mysql_error());
					
			}else{
					
				mysql_query('UPDATE t_irja_pemantauan_hemodialisis 
					SET GELANG_PASIEN = "' . $gelang_pasien . '",
					ALERGI = "' . $alergi . '",
					AKSES_VASKULAR = "' . $akses_vaskular . '",
					MESIN_HEMODIALISIS = "' . $mesin_hemodialisis . '",
					DIALISAT = "' . $dialisat . '",
					DIALISER = "' . $dialiser . '",
					BB_KERING = "' . $bb_kering . '",
					RESEP_HD = "' . $resep_hd . '",
					TGL_ASSESMENT = NOW(),
					REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
					ST_CREATE_ERM = NULL
					WHERE IRJA_ID = "' . $_POST['pemantauan_id'] . '"') or die(mysql_error());	
			}
			
		}else{

			if(empty($_POST['pemantauan_id'])){		
				mysql_query('INSERT INTO t_hemodialisa_pemantauan_hemodialisis (HEMODIALISA_ID,GELANG_PASIEN,ALERGI,AKSES_VASKULAR,
					MESIN_HEMODIALISIS,DIALISAT,DIALISER,BB_KERING,RESEP_HD,TGL_ASSESMENT,REGISTER) 
					VALUES ("' . $_POST['idx'] . '","' . $gelang_pasien . '","' . $alergi . '",
					"' . $akses_vaskular . '","' . $mesin_hemodialisis . '","' . $dialisat . '",
					"' . $dialiser . '","' . $bb_kering . '","' . $resep_hd . '",
					NOW(),"' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '")') or die(mysql_error());
			}else{
				mysql_query('UPDATE t_hemodialisa_pemantauan_hemodialisis 
					SET GELANG_PASIEN = "' . $gelang_pasien . '",
					ALERGI = "' . $alergi . '",
					AKSES_VASKULAR = "' . $akses_vaskular . '",
					MESIN_HEMODIALISIS = "' . $mesin_hemodialisis . '",
					DIALISAT = "' . $dialisat . '",
					DIALISER = "' . $dialiser . '",
					BB_KERING = "' . $bb_kering . '",
					RESEP_HD = "' . $resep_hd . '",
					TGL_ASSESMENT = NOW(),
					REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
					ST_CREATE_ERM = NULL
					WHERE HEMODIALISA_ID = "' . $_POST['pemantauan_id'] . '"') or die(mysql_error());
			}
		}	
	
		/*
		include('lib/vendor/autoload.php');
		include('lib/html2openxml/HTMLtoOpenXML.php');
		include('edoc_rekammedik/new/erm_create_pemantauan_hemodialisa_harian.php');
		erm_pemantauan_hemodialisa_harian($_POST['idx'],$jns_order,$_POST['idxord']);
		*/
		?>
		<script language="JavaScript" >
			alert('Simpan Pemantauan Pelaksanaan Hemodialisis Harian Berhasil.');
			window.location = "<?php echo currentUrl(); ?>";
		</script>
		<?php 
	}else{
		$msg_info = 'Harus Oleh Dokter DPJP.';
	}	
}

if($jns_order == ''){
	$qry_pasien = 'SELECT IRJA_ID AS HEMODIALISA_ID,GELANG_PASIEN,AKSES_VASKULAR,
			MESIN_HEMODIALISIS,DIALISAT,DIALISER,BB_KERING,RESEP_HD,ALERGI,
			DATE_FORMAT(TGL_ASSESMENT,"%d/%m/%Y") AS TGL_ASSESMENT
			FROM t_irja_pemantauan_hemodialisis
			WHERE IRJA_ID = "' . $idx . '"';
	$qry_alergi = 'SELECT ALERGI FROM t_irja_alergi WHERE IRJA_ID = "' . $idx . '"';		
}else{
	$qry_pasien = 'SELECT HEMODIALISA_ID,GELANG_PASIEN,AKSES_VASKULAR,
			MESIN_HEMODIALISIS,DIALISAT,DIALISER,BB_KERING,RESEP_HD,ALERGI,
			DATE_FORMAT(TGL_ASSESMENT,"%d/%m/%Y") AS TGL_ASSESMENT
			FROM t_hemodialisa_pemantauan_hemodialisis
			WHERE HEMODIALISA_ID = "' . $idx . '"';
	$qry_alergi = 'SELECT ALERGI FROM t_hemodialisa_alergi WHERE HEMODIALISA_ID = "' . $idx . '"';				
}	
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$gelang_pasien = str_replace('|','"',$dat_pasien['GELANG_PASIEN']);
$gelang_pasien = preg_replace('/\r|\n/','\n',trim($gelang_pasien));
$gelang_pasien = json_decode($gelang_pasien,true);
$alergi = str_replace('|','"',$dat_pasien['ALERGI']);
$alergi = preg_replace('/\r|\n/','\n',trim($alergi));
$alergi = json_decode($alergi,true);
$akses_vaskular = str_replace('|','"',$dat_pasien['AKSES_VASKULAR']);
$akses_vaskular = preg_replace('/\r|\n/','\n',trim($akses_vaskular));
$akses_vaskular = json_decode($akses_vaskular,true);
$mesin_hemodialisis = str_replace('|','"',$dat_pasien['MESIN_HEMODIALISIS']);
$mesin_hemodialisis = preg_replace('/\r|\n/','\n',trim($mesin_hemodialisis));
$mesin_hemodialisis = json_decode($mesin_hemodialisis,true);
$dialisat = str_replace('|','"',$dat_pasien['DIALISAT']);
$dialisat = preg_replace('/\r|\n/','\n',trim($dialisat));
$dialisat = json_decode($dialisat,true);
$dialiser = str_replace('|','"',$dat_pasien['DIALISER']);
$dialiser = preg_replace('/\r|\n/','\n',trim($dialiser));
$dialiser = json_decode($dialiser,true);
$bb_kering = str_replace('|','"',$dat_pasien['BB_KERING']);
$bb_kering = preg_replace('/\r|\n/','\n',trim($bb_kering));
$bb_kering = json_decode($bb_kering,true);
$resep_hd = str_replace('|','"',$dat_pasien['RESEP_HD']);
$resep_hd = preg_replace('/\r|\n/','\n',trim($resep_hd));
$resep_hd = json_decode($resep_hd,true);
$pemantauan_id = $dat_pasien['HEMODIALISA_ID']; 

/*$get_alergi = mysql_query($qry_alergi) or die(mysql_error());	
$dat_alergi = mysql_fetch_assoc($get_alergi);
$alergi = $dat_alergi['ALERGI'];*/
?>
<form name="formperiksa" id="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="idx" id="idx" value="<?php echo $idx; ?>" />	
	<input type="hidden" name="pemantauan_id" id="pemantauan_id" value="<?php echo $pemantauan_id; ?>" />
	<input type="hidden" name="idxord" id="idxord" value="<?php echo $idxord; ?>" />
	<input type="hidden" name="jns_perawatan" id="jns_perawatan" value="<?php echo $jns_perawatan; ?>" />	
	<table border="0" align="center" style="position:static; " width="90%">
		<tr>
			<td colspan="2" valign="top" width="220px">Gelang Identitas Pasien</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><input type="radio" name="gelang_pasien" value="1" class="text_dt" <?php echo ((isset($gelang_pasien['terpasang']) and $gelang_pasien['terpasang']=='1') ? 'checked' : ''); ?>>&nbsp;Sudah terpasang</td>
		</tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">&nbsp;</td>
			<td valign="top" width="10px">&nbsp;</td>
			<td valign="top"><input type="radio" name="gelang_pasien" value="2" class="text_dt" <?php echo ((isset($gelang_pasien['terpasang']) and $gelang_pasien['terpasang']=='2') ? 'checked' : ''); ?>>&nbsp;Belum terpasang, alasan</td>
			<td colspan="4">
			<textarea name="gelang_pasien_ket" class="text_dt3" style="height:50px;" ><?php if(isset($gelang_pasien['gelang_pasien_ket'])) echo $gelang_pasien['gelang_pasien_ket']; ?></textarea></td>
		</tr>			
		<tr>
			<td colspan="2" valign="top" width="220px">Riwayat Alergi</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><input type="radio" name="alergi" value="1" class="text_dt" <?php echo ((isset($alergi['ada_alergi']) and $alergi['ada_alergi']=='1') ? 'checked' : ''); ?>>&nbsp;Ya
			<input type="radio" name="alergi" value="2" class="text_dt" <?php echo ((isset($alergi['ada_alergi']) and $alergi['ada_alergi']=='2') ? 'checked' : ''); ?>>&nbsp;Tidak</td>
		</tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">&nbsp;</td>
			<td valign="top" width="10px">&nbsp;</td>
			<td valign="top">Bila Ya, sebutkan</td>
			<td colspan="4">
			<textarea name="alergi_ket" class="text_dt3" ><?php if(isset($alergi['alergi_ket'])) echo $alergi['alergi_ket']; ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" width="220px">Gelang Alergi</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><input type="radio" name="gelang_alergi" value="1" class="text_dt" <?php echo ((isset($alergi['gelang_alergi']) and $alergi['gelang_alergi']=='1') ? 'checked' : ''); ?>>&nbsp;Sudah terpasang</td>
		</tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">&nbsp;</td>
			<td valign="top" width="10px">&nbsp;</td>
			<td valign="top"><input type="radio" name="gelang_alergi" value="2" class="text_dt" <?php echo ((isset($alergi['gelang_alergi']) and $alergi['gelang_alergi']=='2') ? 'checked' : ''); ?>>&nbsp;Belum terpasang, alasan</td>
			<td colspan="4">
			<textarea name="gelang_alergi_ket" class="text_dt3" style="height:50px;" ><?php if(isset($alergi['gelang_alergi_ket'])) echo $alergi['gelang_alergi_ket']; ?></textarea></td>
		</tr>
		<tr>
			<td colspan="2" valign="top" width="220px">Akses Vaskular</td>
			<td valign="top" width="10px">&nbsp;</td>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" width="220px">Jenis</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><input type="checkbox" name="akses_vaskular_cimino" value="1" class="text_dt" <?php echo ((isset($akses_vaskular['cimino']) and $akses_vaskular['cimino']=='1') ? 'checked' : ''); ?>>&nbsp;Fistula AV (Cimino)
			<input type="checkbox" name="akses_vaskular_femoral" value="1" class="text_dt" <?php echo ((isset($akses_vaskular['femoral']) and $akses_vaskular['femoral']=='1') ? 'checked' : ''); ?>>&nbsp;Femoral
			<input type="checkbox" name="akses_vaskular_double" value="1" class="text_dt" <?php echo ((isset($akses_vaskular['double']) and $akses_vaskular['double']=='1') ? 'checked' : ''); ?>>&nbsp;Double Lumen Catheter</td>
		</tr>	
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">&nbsp;</td>
			<td valign="top" width="10px">&nbsp;</td>
			<td valign="top"><input type="checkbox" name="akses_vaskular_lain" value="1" class="text_dt" <?php echo ((isset($akses_vaskular['lain']) and $akses_vaskular['lain']=='1') ? 'checked' : ''); ?>>&nbsp;Lain-lain, sebutkan</td>
			<td colspan="4">
			<textarea name="akses_vaskular_ket" class="text_dt3" style="height:50px;" ><?php if(isset($akses_vaskular['ket'])) echo $akses_vaskular['ket']; ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" width="220px">Lokasi</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><input type="text" name="akses_vaskular_lokasi" value="<?php if(isset($akses_vaskular['lokasi'])) echo $akses_vaskular['lokasi']; ?>" class="text_dt" style="width:685px;"></td>
		</tr>		
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">Kondisi</td>
			<td valign="top" width="10px">&nbsp;</td>
			<td valign="top">Tanda Infeksi</td>
			<td colspan="4"><input type="radio" name="akses_vaskular_tanda_infeksi" value="1" class="text_dt" <?php echo ((isset($akses_vaskular['tanda_infeksi']) and $akses_vaskular['tanda_infeksi']=='1') ? 'checked' : ''); ?>>&nbsp;Ya
			<input type="radio" name="akses_vaskular_tanda_infeksi" value="2" class="text_dt" <?php echo ((isset($akses_vaskular['tanda_infeksi']) and $akses_vaskular['tanda_infeksi']=='2') ? 'checked' : ''); ?>>&nbsp;Tidak</td>
		</tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">&nbsp;</td>
			<td valign="top" width="10px">&nbsp;</td>
			<td valign="top">Aneurisma</td>
			<td colspan="4"><input type="radio" name="akses_vaskular_aneurisma" value="1" class="text_dt" <?php echo ((isset($akses_vaskular['aneurisma']) and $akses_vaskular['aneurisma']=='1') ? 'checked' : ''); ?>>&nbsp;Ya
			<input type="radio" name="akses_vaskular_aneurisma" value="2" class="text_dt" <?php echo ((isset($akses_vaskular['aneurisma']) and $akses_vaskular['aneurisma']=='2') ? 'checked' : ''); ?>>&nbsp;Tidak</td>
		</tr>	
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">&nbsp;</td>
			<td valign="top" width="10px">&nbsp;</td>
			<td valign="top">Thrill (AV Fistula)</td>
			<td colspan="4"><input type="radio" name="akses_vaskular_thrill" value="1" class="text_dt" <?php echo ((isset($akses_vaskular['thrill']) and $akses_vaskular['thrill']=='1') ? 'checked' : ''); ?>>&nbsp;Ya
			<input type="radio" name="akses_vaskular_thrill" value="2" class="text_dt" <?php echo ((isset($akses_vaskular['thrill']) and $akses_vaskular['thrill']=='2') ? 'checked' : ''); ?>>&nbsp;Tidak</td>
		</tr>	
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">&nbsp;</td>
			<td valign="top" width="10px">&nbsp;</td>
			<td valign="top">Bruit (AV Fistula)</td>
			<td colspan="4"><input type="radio" name="akses_vaskular_bruit" value="1" class="text_dt" <?php echo ((isset($akses_vaskular['bruit']) and $akses_vaskular['bruit']=='1') ? 'checked' : ''); ?>>&nbsp;Ya
			<input type="radio" name="akses_vaskular_bruit" value="2" class="text_dt" <?php echo ((isset($akses_vaskular['bruit']) and $akses_vaskular['bruit']=='2') ? 'checked' : ''); ?>>&nbsp;Tidak</td>
		</tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">&nbsp;</td>
			<td valign="top" width="10px">&nbsp;</td>
			<td valign="top">Lain-lain</td>
			<td colspan="4"><textarea name="akses_vaskular_lain_ket" class="text_dt3" style="height:50px;" ><?php if(isset($akses_vaskular['lain_ket'])) echo $akses_vaskular['lain_ket']; ?></textarea></td>
		</tr>		
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">&nbsp;</td>
			<td valign="top" width="10px">&nbsp;</td>
			<td valign="top" colspan="5">Untuk Tunnerl dan Double Lumen Catheter :</td>
		</tr>	
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">&nbsp;</td>
			<td valign="top" width="10px">&nbsp;</td>
			<td valign="top">Ukuran Lumen</td>
			<td colspan="2" width="220px">Arteri <input type="text" name="akses_vaskular_lumen_arteri" value="<?php if(isset($akses_vaskular['lumen_arteri'])) echo $akses_vaskular['lumen_arteri']; ?>" class="text_dt" style="width:150px;">&nbsp;cm</td>
			<td colspan="2">Vena <input type="text" name="akses_vaskular_lumen_vena" value="<?php if(isset($akses_vaskular['lumen_vena'])) echo $akses_vaskular['lumen_vena']; ?>" class="text_dt" style="width:150px;">&nbsp;cm</td>
		</tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">&nbsp;</td>
			<td valign="top" width="10px">&nbsp;</td>
			<td valign="top">Heparin Lock</td>
			<td colspan="2" width="220px">Arteri <input type="text" name="akses_vaskular_heparin_arteri" value="<?php if(isset($akses_vaskular['heparin_arteri'])) echo $akses_vaskular['heparin_arteri']; ?>" class="text_dt" style="width:150px;">&nbsp;cc</td>
			<td colspan="2">Vena <input type="text" name="akses_vaskular_heparin_vena" value="<?php if(isset($akses_vaskular['heparin_vena'])) echo $akses_vaskular['heparin_vena']; ?>" class="text_dt" style="width:150px;">&nbsp;cc</td>
		</tr>
	<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">&nbsp;</td>
			<td valign="top" width="10px">&nbsp;</td>
			<td valign="top">Antibiotik Lock</td>
			<td colspan="2" width="220px">Arteri <input type="text" name="akses_vaskular_antibiotik_arteri" value="<?php if(isset($akses_vaskular['antibiotik_arteri'])) echo $akses_vaskular['antibiotik_arteri']; ?>" class="text_dt" style="width:150px;">&nbsp;cc</td>
			<td colspan="2">Vena <input type="text" name="akses_vaskular_antibiotik_vena" value="<?php if(isset($akses_vaskular['antibiotik_vena'])) echo $akses_vaskular['antibiotik_vena']; ?>" class="text_dt" style="width:150px;">&nbsp;cc</td>
		</tr>	
	<tr>
			<td colspan="2" valign="top" width="220px">Mesin Hemodialis</td>
			<td valign="top" width="10px">:</td>
			<td valign="top">Nomor Mesin</td>
			<td colspan="3"><input type="text" name="mesin_hemodialisis_no" value="<?php if(isset($mesin_hemodialisis['no'])) echo $mesin_hemodialisis['no']; ?>" class="text_dt" style="width:250px;"></td>
		</tr>
		<tr>
			<td colspan="2" valign="top" width="220px">&nbsp;</td>
			<td valign="top" width="10px">&nbsp;</td>
			<td valign="top">Nomor WTP</td>
			<td colspan="3"><input type="text" name="mesin_hemodialisis_wtp" value="<?php if(isset($mesin_hemodialisis['wtp'])) echo $mesin_hemodialisis['wtp']; ?>" class="text_dt" style="width:250px;"></td>
		</tr>	
		<tr>
			<td colspan="2">Dialisat</td>
			<td valign="top" width="10px">:</td>
			<td><input type="checkbox" name="dialisat_bicarbonat" value="1" class="text_dt" <?php echo ((isset($dialisat['bicarbonat']) and $dialisat['bicarbonat']=='1') ? 'checked' : ''); ?>>&nbsp;Bicarbonat
			<input type="checkbox" name="dialisat_acid" value="1" class="text_dt" <?php echo ((isset($dialisat['acid']) and $dialisat['acid']=='1') ? 'checked' : ''); ?>>&nbsp;Acid</td>
			<td colspan="3">Suhu 
			<input type="text" name="dialisat_suhu" value="<?php if(isset($dialisat['suhu'])) echo $dialisat['suhu']; ?>" class="text_dt" style="width:215px;">&nbsp;<span>&#8451;</span></td>
		</tr>	
		<tr>
			<td colspan="2">Dialiser</td>
			<td valign="top" width="10px">:</td>
			<td>Model</td>
			<td colspan="3">
			<input type="text" name="dialiser_model" value="<?php if(isset($dialiser['model'])) echo $dialiser['model']; ?>" class="text_dt" style="width:250px;"></span></td>
		</tr>	
		<tr>
			<td colspan="2">&nbsp;</td>
			<td valign="top" width="10px">&nbsp;</td>
			<td colspan="5"><input type="radio" name="dialiser_lowflux" value="1" class="text_dt" <?php echo ((isset($dialiser['lowflux']) and $dialiser['lowflux']=='1') ? 'checked' : ''); ?>>&nbsp;Low Flux
			<input type="radio" name="dialiser_lowflux" value="2" class="text_dt" <?php echo ((isset($dialiser['lowflux']) and $dialiser['lowflux']=='2') ? 'checked' : ''); ?>>&nbsp;High Flux</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
			<td valign="top" width="10px">&nbsp;</td>
			<td colspan="5"><input type="radio" name="dialiser_baru" value="1" class="text_dt" <?php echo ((isset($dialiser['baru']) and $dialiser['baru']=='1') ? 'checked' : ''); ?>>&nbsp; Baru
			<input type="radio" name="dialiser_baru" value="2" class="text_dt" <?php echo ((isset($dialiser['baru']) and $dialiser['baru']=='2') ? 'checked' : ''); ?>>&nbsp;Reuse</td>
		</tr>
		<tr>
			<td colspan="2" valign="top" width="220px">BB Kering</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="5"><input type="text" name="bb_kering" value="<?php if(isset($bb_kering['bb'])) echo $bb_kering['bb']; ?>" class="text_dt" style="width:250px;">&nbsp;kg</td>
		</tr>	
		<tr>
			<td colspan="2" valign="top" width="220px">Resep HD</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">&nbsp;</td>
			<td valign="top" width="10px">&nbsp;</td>
			<td valign="top">Lama HD</td>
			<td colspan="2" width="220px"><input type="text" name="resep_hd_lama" value="<?php if(isset($resep_hd['lama'])) echo $resep_hd['lama']; ?>" class="text_dt" style="width:150px;">&nbsp;jam</td>
			<td colspan="2">&nbsp;</td>
		</tr>	
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">&nbsp;</td>
			<td valign="top" width="10px">&nbsp;</td>
			<td valign="top">Ultrafiltration Goal (UFG)</td>
			<td colspan="2" width="220px"><input type="text" name="resep_hd_ufg" value="<?php if(isset($resep_hd['ufg'])) echo $resep_hd['ufg']; ?>" class="text_dt" style="width:150px;">&nbsp;mL</td>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">&nbsp;</td>
			<td valign="top" width="10px">&nbsp;</td>
			<td valign="top">Blood Flow Rate (Qb)</td>
			<td colspan="2" width="220px"><input type="text" name="resep_hd_qb" value="<?php if(isset($resep_hd['qb'])) echo $resep_hd['qb']; ?>" class="text_dt" style="width:150px;">&nbsp;mL/menit</td>
			<td colspan="2">&nbsp;</td>
		</tr>	
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">&nbsp;</td>
			<td valign="top" width="10px">&nbsp;</td>
			<td valign="top">Heparin</td>
			<td colspan="4" width="220px"><input type="checkbox" name="resep_hd_heparin_reguler" value="1" class="text_dt" <?php echo ((isset($resep_hd['heparin_reguler']) and $resep_hd['heparin_reguler']=='1') ? 'checked' : ''); ?>>&nbsp;Reguler
			<input type="checkbox" name="resep_hd_heparin_minimal" value="1" class="text_dt" <?php echo ((isset($resep_hd['heparin_minimal']) and $resep_hd['heparin_minimal']=='1') ? 'checked' : ''); ?>>&nbsp;Minimal
			<input type="checkbox" name="resep_hd_heparin_free" value="1" class="text_dt" <?php echo ((isset($resep_hd['heparin_free']) and $resep_hd['heparin_free']=='1') ? 'checked' : ''); ?>>&nbsp;Free, ec
			<input type="text" name="resep_hd_heparin_ec" value="<?php if(isset($resep_hd['heparin_ec'])) echo $resep_hd['heparin_ec']; ?>" class="text_dt" style="width:260px;"></td>
		</tr>	
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">&nbsp;</td>
			<td valign="top" width="10px">&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td colspan="4" width="220px">Total&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="resep_hd_total" value="<?php if(isset($resep_hd['total'])) echo $resep_hd['total']; ?>" class="text_dt" style="width:180px;">&nbsp;IU</td>
		</tr>	
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">&nbsp;</td>
			<td valign="top" width="10px">&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td colspan="4" width="220px">Bolus&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="resep_hd_bolus" value="<?php if(isset($resep_hd['bolus'])) echo $resep_hd['bolus']; ?>" class="text_dt" style="width:180px;">&nbsp;IU</td>
		</tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">&nbsp;</td>
			<td valign="top" width="10px">&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td colspan="4" width="220px">Sirkulasi&nbsp;&nbsp;<input type="text" name="resep_hd_sirkulasi" value="<?php if(isset($resep_hd['sirkulasi'])) echo $resep_hd['sirkulasi']; ?>" class="text_dt" style="width:180px;">&nbsp;IU</td>
		</tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">&nbsp;</td>
			<td valign="top" width="10px">&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td colspan="4" width="220px">Kontinyu <input type="text" name="resep_hd_kontinyu" value="<?php if(isset($resep_hd['kontinyu'])) echo $resep_hd['kontinyu']; ?>" class="text_dt" style="width:180px;">&nbsp;IU</td>
		</tr>
        <tr>
            <td colspan="8">&nbsp;</td>
        </tr>
        <tr><td colspan="8" align="right" >
			<?php if($hemodialisa_final == '' and (isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])
				or isPerawat($_SESSION['SES_SIMRS_TIPE_PEGAWAI']))){ ?>
			<input type="button" value="simpan" class="myButton1" onclick="simpan();"/>
			<?php if(!empty($pemantauan_id)){ 
				$sql_view_rm = 'SELECT FILE_ID FROM t_rm_dokumen_file
						WHERE JNS_PERAWATAN = "' . $jns_perawatan . '"
						AND NOMR = "' . $nomr . '"
						AND RAWAT_ID = "' . $idxord . '"
						AND JENIS_DOKUMEN_ID = "32"
						' . (($jns_order != '') ? 'AND ORDER_PENUNJANG = "' . $idx . '"' : 'AND ORDER_PENUNJANG IS NULL') . '
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