<?php
function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = str_replace('|','!',$str);
	$ret = htmlspecialchars($ret);
	return $ret;
}
	
if (isset($_POST['irja_id'])){
	$pemeriksaan = array('kp_kesadaran'=>((isset($_POST['kp_kesadaran'])) ? $_POST['kp_kesadaran'] : ''),
				'kp_td'=>replace_quote($_POST['kp_td']),
				'kp_nadi'=>replace_quote($_POST['kp_nadi']),
				'kp_nafas'=>replace_quote($_POST['kp_nafas']),
				'kp_suhu'=>replace_quote($_POST['kp_suhu']));
	$pemeriksaan = json_encode($pemeriksaan);			
	$pemeriksaan = str_replace('"','|',$pemeriksaan);
	
	$pemeriksaan_saat_rujuk = array('kpr_kesadaran'=>((isset($_POST['kpr_kesadaran'])) ? $_POST['kpr_kesadaran'] : ''),
				'kpr_td'=>replace_quote($_POST['kpr_td']),
				'kpr_nadi'=>replace_quote($_POST['kpr_nadi']),
				'kpr_nafas'=>replace_quote($_POST['kpr_nafas']),
				'kpr_suhu'=>replace_quote($_POST['kpr_suhu']),
				'kpr_urine'=>replace_quote($_POST['kpr_urine']),
				'kpr_cairan_hilang'=>replace_quote($_POST['kpr_cairan_hilang']));
	$pemeriksaan_saat_rujuk = json_encode($pemeriksaan_saat_rujuk);			
	$pemeriksaan_saat_rujuk = str_replace('"','|',$pemeriksaan_saat_rujuk);
	
	
	if(empty($_POST['idx'])){		
			mysql_query('INSERT INTO t_irja_rujukan (IRJA_RUJUKAN_ID,PENERIMA,UNIT_PENERIMA,ALAMAT_PENERIMA,ANAMNESA_SINGKAT,
			PEMERIKSAAN,LAMPIR_LABORATORIUM,LAMPIR_ROTGEN,LAMPIR_EKG,LAMPIR_DARAH,TERAPI_OBAT,
			TERAPI_CAIRAN,TERAPI_LAIN,PEMERIKSAAN_SAAT_RUJUK,
			TGL_ASSESMENT,REGISTER) 
				VALUES ("' . $_POST['irja_id'] . '","' . $_POST['penerima'] . '","' . $_POST['unit_penerima'] . '",
				"' . replace_quote($_POST['alamat_penerima']) . '","' . replace_quote($_POST['anamnesa']) . '",
				"' . $pemeriksaan . '",
				"' . ((isset($_POST['lampir_lab'])) ? $_POST['lampir_lab'] : '') . '",
				"' . ((isset($_POST['lampir_rotgen'])) ? $_POST['lampir_rotgen'] : '') . '",
				"' . ((isset($_POST['lampir_ekg'])) ? $_POST['lampir_ekg'] : '') . '",
				"' . ((isset($_POST['lampir_darah'])) ? $_POST['lampir_darah'] : '') . '",
				"' . replace_quote($_POST['terapi_obat']) . '","' . replace_quote($_POST['terapi_cairan']) . '",
				"' . replace_quote($_POST['terapi_lain']) . '",
				"' . $pemeriksaan_saat_rujuk . '",NOW(),"' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '")') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_irja_rujukan 
				SET PENERIMA = "' . $_POST['penerima'] . '",
				UNIT_PENERIMA = "' . $_POST['unit_penerima'] . '",
				ALAMAT_PENERIMA = "' . replace_quote($_POST['alamat_penerima']) . '",
				ANAMNESA_SINGKAT = "' . replace_quote($_POST['anamnesa']) . '",
				PEMERIKSAAN = "' . $pemeriksaan . '",
				LAMPIR_LABORATORIUM = "' . ((isset($_POST['lampir_lab'])) ? $_POST['lampir_lab'] : '') . '",
				LAMPIR_ROTGEN = "' . ((isset($_POST['lampir_rotgen'])) ? $_POST['lampir_rotgen'] : '') . '",
				LAMPIR_EKG = "' . ((isset($_POST['lampir_ekg'])) ? $_POST['lampir_ekg'] : '') . '",
				LAMPIR_DARAH = "' . ((isset($_POST['lampir_darah'])) ? $_POST['lampir_darah'] : '') . '",
				TERAPI_OBAT = "' . replace_quote($_POST['terapi_obat']) . '",
				TERAPI_CAIRAN = "' . replace_quote($_POST['terapi_cairan']) . '",
				TERAPI_LAIN = "' . replace_quote($_POST['terapi_lain']) . '",
				PEMERIKSAAN_SAAT_RUJUK = "' . $pemeriksaan_saat_rujuk . '",
				TGL_ASSESMENT = NOW(),
				REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
				ST_CREATE_ERM = NULL
				WHERE IRJA_RUJUKAN_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());
		}

		?>
		<script language="JavaScript" >
			alert('Simpan Transfer Eksternal Berhasil.');
			window.location = "<?php echo currentUrl(); ?>";
		</script>
		<?php 	
}
$qry_pasien = 'SELECT IRJA_RUJUKAN_ID,PENERIMA,UNIT_PENERIMA,ALAMAT_PENERIMA,ANAMNESA_SINGKAT,
			PEMERIKSAAN,LAMPIR_LABORATORIUM,LAMPIR_ROTGEN,LAMPIR_EKG,LAMPIR_DARAH,TERAPI_OBAT,
			TERAPI_CAIRAN,TERAPI_LAIN,PEMERIKSAAN_SAAT_RUJUK,
			DATE_FORMAT(TGL_ASSESMENT,"%d/%m/%Y") AS TGL_ASSESMENT,
			REGISTER
			FROM t_irja_rujukan
			WHERE IRJA_RUJUKAN_ID = "' . $_GET['idx'] . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$idx = $dat_pasien['IRJA_RUJUKAN_ID'];
$penerima = $dat_pasien['PENERIMA'];
$unit_penerima = $dat_pasien['UNIT_PENERIMA'];
$alamat_penerima = $dat_pasien['ALAMAT_PENERIMA'];
$anamnesa = $dat_pasien['ANAMNESA_SINGKAT'];

$pemeriksaan = str_replace('|','"',$dat_pasien['PEMERIKSAAN']);
$pemeriksaan = preg_replace('/\r|\n/','\n',trim($pemeriksaan));
$pemeriksaan = json_decode($pemeriksaan,true);

$lampir_lab = $dat_pasien['LAMPIR_LABORATORIUM'];
$lampir_rotgen = $dat_pasien['LAMPIR_ROTGEN'];
$lampir_ekg = $dat_pasien['LAMPIR_EKG'];
$lampir_darah = $dat_pasien['LAMPIR_DARAH'];

$terapi_obat = $dat_pasien['TERAPI_OBAT'];
$terapi_cairan = $dat_pasien['TERAPI_CAIRAN'];
$terapi_lain = $dat_pasien['TERAPI_LAIN'];

$pemeriksaan_saat_rujuk = str_replace('|','"',$dat_pasien['PEMERIKSAAN_SAAT_RUJUK']);
$pemeriksaan_saat_rujuk = preg_replace('/\r|\n/','\n',trim($pemeriksaan_saat_rujuk));
$pemeriksaan_saat_rujuk = json_decode($pemeriksaan_saat_rujuk,true);

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
<form name="formperiksa" id="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="idx" id="idx" value="<?php echo $idx; ?>" />	
	<input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />	
	<table border="0" align="center" style="position:static; " width="90%">
        <tr>
			<td colspan="8">PENERIMA</td>
		</tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">Nama</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><input type="text" name="penerima" value="<?php echo $penerima; ?>" class="text_dt" style="width:500px;" /></td>
		</tr>	
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Di RS</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="unit_penerima" value="<?php echo $unit_penerima; ?>" class="text_dt" style="width:500px;" /></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Alamat</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="alamat_penerima" class="text_dt10" ><?php echo $alamat_penerima; ?></textarea></td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Anamnesa Singkat</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="anamnesa" class="text_dt10" ><?php echo $anamnesa; ?></textarea></td>
        </tr>
		<tr>
			<td colspan="8">Pemeriksaan</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Kesadaran</td>
			<td>:</td>
			<td colspan="5">
				<input type="text" name="kp_kesadaran" value="<?php echo ((isset($pemeriksaan['kp_kesadaran'])) ? $pemeriksaan['kp_kesadaran'] : ''); ?>" class="text_dt" style="width:500px;" /></td>
		</tr>	
		<tr>	
			<td>&nbsp;</td>	
			<td>TD</td>
			<td>:</td>
			<td width="220px"><input type="text" name="kp_td" value="<?php echo ((isset($pemeriksaan['kp_td'])) ? $pemeriksaan['kp_td'] : ''); ?>" class="text_dt" >&nbsp;mmHg</td>
			<td width="130px">&nbsp;</td>
			<td width="95px">Nadi</td>
			<td>:</td>
			<td><input type="text" name="kp_nadi" value="<?php echo ((isset($pemeriksaan['kp_nadi'])) ? $pemeriksaan['kp_nadi'] : ''); ?>" class="text_dt" >&nbsp;x/menit</td>
		</tr>
		<tr>	
			<td>&nbsp;</td>			
			<td>Pernafasan</td>
			<td>:</td>
			<td><input type="text" name="kp_nafas" value="<?php echo ((isset($pemeriksaan['kp_nafas'])) ? $pemeriksaan['kp_nafas'] : ''); ?>" class="text_dt" >&nbsp;x/menit</td>
			<td>&nbsp;</td>
			<td>Suhu</td>
			<td>:</td>
			<td><input type="text" name="kp_suhu" value="<?php echo ((isset($pemeriksaan['kp_suhu'])) ? $pemeriksaan['kp_suhu'] : ''); ?>" class="text_dt" >&nbsp;<span>&#8451;</span></td>
		</tr>
		<tr>
            <td valign="top" colspan="2" rowspan="4">Diagnosa</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="diagnosa_0" id="diagnosa_0" value="<?php echo ((isset($diagnosa[0])) ? $diagnosa[0] : ''); ?>" class="text_dt" style="width:755px;" readonly ></td>
		</tr>
		<tr>
			<td valign="top">&nbsp;</td>
			<td colspan="5"><input type="text" name="diagnosa_1" id="diagnosa_1" value="<?php echo ((isset($diagnosa[1])) ? $diagnosa[1] : ''); ?>" class="text_dt" style="width:755px;" readonly ></td>
		</tr>
		<tr>
			<td valign="top">&nbsp;</td>
			<td colspan="5"><input type="text" name="diagnosa_2" id="diagnosa_2" value="<?php echo ((isset($diagnosa[2])) ? $diagnosa[2] : ''); ?>" class="text_dt" style="width:755px;" readonly ></td>
		</tr>
		<tr>
			<td valign="top">&nbsp;</td>
			<td colspan="5"><input type="text" name="diagnosa_3" id="diagnosa_3" value="<?php echo ((isset($diagnosa[3])) ? $diagnosa[3] : ''); ?>" class="text_dt" style="width:755px;" readonly ></td>
		</tr>
		<tr>
            <td valign="top" colspan="2" rowspan="4">Diagnosa Banding</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="diagnosa_4" id="diagnosa_4" value="<?php echo ((isset($diagnosa[4])) ? $diagnosa[4] : ''); ?>" class="text_dt" style="width:755px;" readonly ></td></tr>
			<tr><td>&nbsp;</td><td colspan="5"><input type="text" name="diagnosa_5" id="diagnosa_5" value="<?php echo ((isset($diagnosa[5])) ? $diagnosa[5] : ''); ?>" class="text_dt" style="width:755px;" readonly ></td></tr>
			<tr><td>&nbsp;</td><td colspan="5"><input type="text" name="diagnosa_6" id="diagnosa_6" value="<?php echo ((isset($diagnosa[6])) ? $diagnosa[6] : ''); ?>" class="text_dt" style="width:755px;" readonly ></td></tr>
			<tr><td>&nbsp;</td><td colspan="5"><input type="text" name="diagnosa_7" id="diagnosa_7" value="<?php echo ((isset($diagnosa[7])) ? $diagnosa[7] : ''); ?>" class="text_dt" style="width:755px;" readonly ></td></tr>
		<tr>
			<td colspan="8">Pemeriksaan penunjang diagnosis</td>
		</tr>	
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">Laboratorium</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><input type="checkbox" name="lampir_lab" value="1" <?php if($lampir_lab == '1') echo 'checked'; ?> />&nbsp;Terlampir</td>
		</tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">Foto Rontgen</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><input type="checkbox" name="lampir_rotgen" value="1" <?php if($lampir_rotgen == '1') echo 'checked'; ?> />&nbsp;Terlampir</td>
		</tr>	
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">EKG</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><input type="checkbox" name="lampir_ekg" value="1" <?php if($lampir_ekg == '1') echo 'checked'; ?> />&nbsp;Terlampir</td>
		</tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">Contoh Darah</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><input type="checkbox" name="lampir_darah" value="1" <?php if($lampir_darah == '1') echo 'checked'; ?> />&nbsp;Terlampir</td>
		</tr>	
		<tr>
			<td colspan="8">Terapi yang diberikan</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Obat</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="terapi_obat" class="text_dt10" ><?php echo $terapi_obat; ?></textarea></td>
		</tr>	
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Cairan</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="terapi_cairan" class="text_dt10" ><?php echo $terapi_cairan; ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Lain-lain</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="terapi_lain" class="text_dt10" ><?php echo $terapi_lain; ?></textarea></td>
		</tr>
		<tr>
			<td colspan="8">Kesadaran saat dirujuk</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Kesadaran</td>
			<td>:</td>
			<td colspan="5">
				<input type="text" name="kpr_kesadaran" value="<?php echo ((isset($pemeriksaan_saat_rujuk['kpr_kesadaran'])) ? $pemeriksaan_saat_rujuk['kpr_kesadaran'] : ''); ?>" class="text_dt" style="width:500px;" /></td>
		</tr>	
		<tr>	
			<td>&nbsp;</td>	
			<td>TD</td>
			<td>:</td>
			<td width="220px"><input type="text" name="kpr_td" value="<?php echo ((isset($pemeriksaan_saat_rujuk['kpr_td'])) ? $pemeriksaan_saat_rujuk['kpr_td'] : ''); ?>" class="text_dt" >&nbsp;mmHg</td>
			<td width="130px">&nbsp;</td>
			<td width="95px">Nadi</td>
			<td>:</td>
			<td><input type="text" name="kpr_nadi" value="<?php echo ((isset($pemeriksaan_saat_rujuk['kpr_nadi'])) ? $pemeriksaan_saat_rujuk['kpr_nadi'] : ''); ?>" class="text_dt" >&nbsp;x/menit</td>
		</tr>
		<tr>	
			<td>&nbsp;</td>			
			<td>Pernafasan</td>
			<td>:</td>
			<td><input type="text" name="kpr_nafas" value="<?php echo ((isset($pemeriksaan_saat_rujuk['kpr_nafas'])) ? $pemeriksaan_saat_rujuk['kpr_nafas'] : ''); ?>" class="text_dt" >&nbsp;x/menit</td>
			<td>&nbsp;</td>
			<td>Suhu</td>
			<td>:</td>
			<td><input type="text" name="kpr_suhu" value="<?php echo ((isset($pemeriksaan_saat_rujuk['kpr_suhu'])) ? $pemeriksaan_saat_rujuk['kpr_suhu'] : ''); ?>" class="text_dt" >&nbsp;<span>&#8451;</span></td>
		</tr>
		<tr>	
			<td>&nbsp;</td>			
			<td>Produksi urine</td>
			<td>:</td>
			<td colspan="3"><input type="text" name="kpr_urine" value="<?php echo ((isset($pemeriksaan_saat_rujuk['kpr_urine'])) ? $pemeriksaan_saat_rujuk['kpr_urine'] : ''); ?>" class="text_dt" >&nbsp;jml pendarahan/ cairan yang hilang</td>
			<td>:</td>
			<td><input type="text" name="kpr_cairan_hilang" value="<?php echo ((isset($pemeriksaan_saat_rujuk['kpr_cairan_hilang'])) ? $pemeriksaan_saat_rujuk['kpr_cairan_hilang'] : ''); ?>" class="text_dt" >&nbsp;ml</td>
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
						AND JENIS_DOKUMEN_ID = "49"
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