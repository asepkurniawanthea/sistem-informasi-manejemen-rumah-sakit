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
		
		$hasil_pemeriksaan_penunjang = replace_quote($_POST['hasil_pemeriksaan_penunjang']);
		$hasil_pemeriksaan_penunjang = str_replace(' \n ','<br>',$hasil_pemeriksaan_penunjang);
	
		if(empty($_POST['idx'])){		
			mysql_query('INSERT INTO t_irja_pengkajian_awal_medis (IRJA_ID,ANAMNESIS_KELUHAN_UTAMA,ANAMNESIS_RIWAYAT_PENYAKIT_SEKARANG,
				ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU,ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA,PEMERIKSAAN,STATUS_LOKALIS,
				HASIL_PEMERIKSAAN_PENUNJANG,RENCANA_TATALAKSANA,RENCANA_TATALAKSANA_NON_FARMAKA,
				TGL_ASSESMENT,FINAL,REGISTER) 
				VALUES ("' . $_POST['irja_id'] . '","' . replace_quote($_POST['anamnesis_keluhan_utama']) . '",
				"' . replace_quote($_POST['anamnesis_riwayat_penyakit_sekarang']) . '",
				"' . replace_quote($_POST['anamnesis_riwayat_penyakit_dahulu']) . '",
				"' . replace_quote($_POST['anamnesis_riwayat_penyakit_keluarga']) . '",
				"' . $pemeriksaan . '","' . replace_quote($_POST['status_lokalis']) . '",
				"' . $hasil_pemeriksaan_penunjang . '",
				"' . replace_quote($_POST['rencana_tatalaksana']) . '",
				"' . replace_quote($_POST['rencana_tatalaksana_non_farmaka']) . '",
				NOW(),' . $st_final . ',"' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '")') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_irja_pengkajian_awal_medis 
				SET ANAMNESIS_KELUHAN_UTAMA = "' . replace_quote($_POST['anamnesis_keluhan_utama']) . '",
				ANAMNESIS_RIWAYAT_PENYAKIT_SEKARANG = "' . replace_quote($_POST['anamnesis_riwayat_penyakit_sekarang']) . '",
				ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU = "' . replace_quote($_POST['anamnesis_riwayat_penyakit_dahulu']) . '",
				ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA = "' . replace_quote($_POST['anamnesis_riwayat_penyakit_keluarga']) . '",
				PEMERIKSAAN = "' . $pemeriksaan . '",
				STATUS_LOKALIS = "' . replace_quote($_POST['status_lokalis']) . '",
				HASIL_PEMERIKSAAN_PENUNJANG = "' . $hasil_pemeriksaan_penunjang . '",
				RENCANA_TATALAKSANA = "' . replace_quote($_POST['rencana_tatalaksana']) . '",
				RENCANA_TATALAKSANA_NON_FARMAKA = "' . replace_quote($_POST['rencana_tatalaksana_non_farmaka']) . '",
				TGL_ASSESMENT = NOW(),
				FINAL = ' . $st_final . ',
				REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
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
		
		mysql_query('DELETE FROM t_irja_alergi WHERE IRJA_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());
		mysql_query('INSERT INTO t_irja_alergi(IRJA_ID,ALERGI) VALUES("' . $_POST['irja_id'] . '","' . replace_quote($_POST['anamnesis_alergi']) . '")') or die(mysql_error());
	
		/*
		include('lib/vendor/autoload.php');
		include('lib/html2openxml/HTMLtoOpenXML.php');
		include('edoc_rekammedik/new/erm_create_pengkajian_awal_medis_umum.php');
		erm_pengkajian_awal_medis_umum($_POST['irja_id'],$_POST['ls_assesment'],$_POST['tgl_skr'],$_POST['ls_final']);
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
$qry_pasien = 'SELECT IRJA_ID,ANAMNESIS_KELUHAN_UTAMA,ANAMNESIS_RIWAYAT_PENYAKIT_SEKARANG,ANAMNESIS_RIWAYAT_PENYAKIT_DAHULU,
			ANAMNESIS_RIWAYAT_PENYAKIT_KELUARGA,PEMERIKSAAN,STATUS_LOKALIS,HASIL_PEMERIKSAAN_PENUNJANG, 
			RENCANA_TATALAKSANA,RENCANA_TATALAKSANA_NON_FARMAKA,
			FINAL,DATE_FORMAT(TGL_ASSESMENT,"%d/%m/%Y") AS TGL_ASSESMENT,
			DATE_FORMAT(NOW(),"%d/%m/%Y") AS TGL_SKR
			FROM t_irja_pengkajian_awal_medis
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
$status_lokalis = $dat_pasien['STATUS_LOKALIS'];
$hasil_pemeriksaan_penunjang = $dat_pasien['HASIL_PEMERIKSAAN_PENUNJANG'];
$rencana_tatalaksana = $dat_pasien['RENCANA_TATALAKSANA'];
$rencana_tatalaksana_non_farmaka = $dat_pasien['RENCANA_TATALAKSANA_NON_FARMAKA'];
$final = $dat_pasien['FINAL'];
$tgl_assesment = $dat_pasien['TGL_ASSESMENT'];
$tgl_skr = $dat_pasien['TGL_SKR'];

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

$qry_alergi = 'SELECT ALERGI FROM t_irja_alergi WHERE IRJA_ID = "' . $_GET['idx'] . '"';
$get_alergi = mysql_query($qry_alergi) or die(mysql_error());	
$dat_alergi = mysql_fetch_assoc($get_alergi);
$anamnesis_alergi = $dat_alergi['ALERGI'];
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
			<td width="250px"><input type="text" name="pm_td" value="<?php echo ((isset($pemeriksaan_fisik['pm_td'])) ? $pemeriksaan_fisik['pm_td'] : ''); ?>" class="text_dt" >&nbsp;mmHg</td>
			<td width="80px">&nbsp;</td>
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
			<td colspan="4"><input type="text" name="pm_jantung" value="<?php echo ((isset($pemeriksaan_fisik['pm_jantung'])) ? $pemeriksaan_fisik['pm_jantung'] : ''); ?>" class="text_dt" style="width:500px;"></td>
		</tr>
		<tr>	
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>Paru</td> 
			<td colspan="4"><input type="text" name="pm_paru" value="<?php echo ((isset($pemeriksaan_fisik['pm_paru'])) ? $pemeriksaan_fisik['pm_paru'] : ''); ?>" class="text_dt" style="width:500px;" ></td>
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
            <td valign="top" colspan="2">Hasil Pemeriksaan Penunjang</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="hasil_pemeriksaan_penunjang" class="text_dt11" ><?php echo $hasil_pemeriksaan_penunjang; ?></textarea></td>
        </tr>
		<tr>
            <td valign="top" colspan="2" rowspan="4">Diagnosa</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="diagnosa_0" id="diagnosa_0" value="<?php echo ((isset($diagnosa[0])) ? $diagnosa[0] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td valign="top">&nbsp;</td>
			<td colspan="5"><input type="text" name="diagnosa_1" id="diagnosa_1" value="<?php echo ((isset($diagnosa[1])) ? $diagnosa[1] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td valign="top">&nbsp;</td>
			<td colspan="5"><input type="text" name="diagnosa_2" id="diagnosa_2" value="<?php echo ((isset($diagnosa[2])) ? $diagnosa[2] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td valign="top">&nbsp;</td>
			<td colspan="5"><input type="text" name="diagnosa_3" id="diagnosa_3" value="<?php echo ((isset($diagnosa[3])) ? $diagnosa[3] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
            <td valign="top" colspan="2" rowspan="4">Diagnosa Banding</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="diagnosa_4" id="diagnosa_4" value="<?php echo ((isset($diagnosa[4])) ? $diagnosa[4] : ''); ?>" class="text_dt" style="width:755px;" ></td></tr>
			<tr><td>&nbsp;</td><td colspan="5"><input type="text" name="diagnosa_5" id="diagnosa_5" value="<?php echo ((isset($diagnosa[5])) ? $diagnosa[5] : ''); ?>" class="text_dt" style="width:755px;" ></td></tr>
			<tr><td>&nbsp;</td><td colspan="5"><input type="text" name="diagnosa_6" id="diagnosa_6" value="<?php echo ((isset($diagnosa[6])) ? $diagnosa[6] : ''); ?>" class="text_dt" style="width:755px;" ></td></tr>
			<tr><td>&nbsp;</td><td colspan="5"><input type="text" name="diagnosa_7" id="diagnosa_7" value="<?php echo ((isset($diagnosa[7])) ? $diagnosa[7] : ''); ?>" class="text_dt" style="width:755px;" ></td></tr>
		
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
			<?php if(isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI']) and $pegawai_id == $_SESSION['SES_SIMRS_PEGAWAI_ID'] and $irja_final == ''){ ?>
			<input type="checkbox" name="final" id="final" value="1" <?php echo (($final == '1') ? 'checked' : ''); ?> />&nbsp;Final&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button" value="simpan" class="myButton1" onclick="simpan();"/>
			<?php if(!empty($idx)){ 
				$sql_view_rm = 'SELECT FILE_ID FROM t_rm_dokumen_file
						WHERE JNS_PERAWATAN = "1"
						AND NOMR = "' . $nomr . '"
						AND RAWAT_ID = "' . $idx . '"
						AND JENIS_DOKUMEN_ID = "3"
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