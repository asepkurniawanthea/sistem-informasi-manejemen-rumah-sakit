<?php
function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = str_replace('|','!',$str);
	$ret = htmlspecialchars($ret);
	return $ret;
}
	
if (isset($_POST['irna_id'])){
	if(empty($_POST['idx'])){		
			mysql_query('INSERT INTO t_irna_kontrol (IRNA_KONTROL_ID,PENERIMA,UNIT_ID,TGL_KONTROL,
				TERAPI_PULANG,PANTANGAN,BOLEH_DILAKUKAN,TDK_BOLEH_DILAKUKAN,TGL_ASSESMENT,REGISTER,INSTRUKSI) 
				VALUES ("' . $_POST['irna_id'] . '","' . $_POST['penerima'] . '","' . $_POST['unit_penerima'] . '",
				STR_TO_DATE("' . $_POST['tgl_kontrol'] . '","%d/%m/%Y"),"' . replace_quote($_POST['terapi_pulang']) . '",
				"' . replace_quote($_POST['pantangan']) . '","' . replace_quote($_POST['boleh_dilakukan']) . '",
				"' . replace_quote($_POST['tdk_boleh_dilakukan']) . '",NOW(),"' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
				"' . replace_quote($_POST['instruksi']) . '")') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_irna_kontrol 
				SET PENERIMA = "' . $_POST['penerima'] . '",
				UNIT_ID = "' . $_POST['unit_penerima'] . '",
				TGL_KONTROL = STR_TO_DATE("' . $_POST['tgl_kontrol'] . '","%d/%m/%Y"),
				TERAPI_PULANG = "' . replace_quote($_POST['terapi_pulang']) . '",
				PANTANGAN = "' . replace_quote($_POST['pantangan']) . '",
				BOLEH_DILAKUKAN = "' . replace_quote($_POST['boleh_dilakukan']) . '",
				TDK_BOLEH_DILAKUKAN = "' . replace_quote($_POST['tdk_boleh_dilakukan']) . '",
				TGL_ASSESMENT = NOW(),
				REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
				INSTRUKSI = "' . replace_quote($_POST['instruksi']) . '",
				ST_CREATE_ERM = NULL
				WHERE IRNA_KONTROL_ID = "' . $_POST['irna_id'] . '"') or die(mysql_error());
		}

		?>
		<script language="JavaScript" >
			alert('Simpan Surat Kontrol dan Tindak Lanjut Pasien Pulang Berhasil.');
			window.location = "<?php echo currentUrl(); ?>";
		</script>
		<?php 	
}
$qry_pasien = 'SELECT IRNA_KONTROL_ID,PENERIMA,UNIT_ID,DATE_FORMAT(TGL_KONTROL,"%d/%m/%Y") AS TGL_KONTROL,
			TERAPI_PULANG,PANTANGAN,BOLEH_DILAKUKAN,
			TDK_BOLEH_DILAKUKAN,INSTRUKSI
			FROM t_irna_kontrol
			WHERE IRNA_KONTROL_ID = "' . $_GET['idx'] . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$idx = $dat_pasien['IRNA_KONTROL_ID'];
$penerima = $dat_pasien['PENERIMA'];
$unit_penerima = $dat_pasien['UNIT_ID'];
$tgl_kontrol = $dat_pasien['TGL_KONTROL'];
$terapi_pulang = $dat_pasien['TERAPI_PULANG'];
$pantangan = $dat_pasien['PANTANGAN'];
$boleh_dilakukan = $dat_pasien['BOLEH_DILAKUKAN'];
$tdk_boleh_dilakukan = $dat_pasien['TDK_BOLEH_DILAKUKAN'];
$instruksi = $dat_pasien['INSTRUKSI'];

$qry_diagnosa = 'SELECT DIAGNOSA_ORDER,DIAGNOSA
		FROM t_irna_diagnosa
		WHERE IRNA_ID = "' . $_GET['idx'] . '"
		ORDER BY DIAGNOSA_ORDER';
$get_diagnosa = mysql_query($qry_diagnosa) or die(mysql_error());
$d=0;
$diagnosa = array();
while($dat_diagnosa= mysql_fetch_array($get_diagnosa)){
	$diagnosa[$dat_diagnosa['DIAGNOSA_ORDER']]=$dat_diagnosa['DIAGNOSA'];
$d++;
}
?>
<form name="formedit" id="formedit" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="idx" id="idx" value="<?php echo $idx; ?>" />	
	<input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />	
	<table border="0" align="center" style="position:static; " width="90%">
        <tr>
			<td colspan="8">Penerima</td>
		</tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">Nama</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><input type="text" name="penerima" value="<?php echo $penerima; ?>" class="text_dt" style="width:228px;" /></td>
		</tr>	
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Di Unit</td>
			<td valign="top">:</td>
			<td colspan="5"><select name="unit_penerima" id="unit_penerima" style="width:235px;" class="text_dt">
                    <option value="" > - </option>
                    <?php echo getUnit('irja',$unit_penerima); ?>
                </select></td>
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
			<td valign="top" colspan="2">Tanggal Kontrol</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="tgl_kontrol" id="tgl_3" class="text_dt" size="10" value="<?php echo $tgl_kontrol; ?>" readonly="readonly" onblur="false_kan();" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar11')"/></td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Terapi Saat Pulang</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="terapi_pulang" class="text_dt10" ><?php echo $terapi_pulang; ?></textarea></td>
        </tr>
		<tr>
			<td valign="top" colspan="2" width="220px">Instruksi tindak lanjut di rumah</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><textarea name="instruksi" class="text_dt10" ><?php echo $instruksi; ?></textarea></td>
		</tr>	
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">Pantangan</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><textarea name="pantangan" class="text_dt10" ><?php echo $pantangan; ?></textarea></td>
		</tr>	
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">Hal yang boleh dilakukan</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><textarea name="boleh_dilakukan" class="text_dt10" ><?php echo $boleh_dilakukan; ?></textarea></td>
		</tr>	
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">Hal yang tidak boleh dilakukan</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><textarea name="tdk_boleh_dilakukan" class="text_dt10" ><?php echo $tdk_boleh_dilakukan; ?></textarea></td>
		</tr>	
        <tr>
            <td colspan="8">&nbsp;</td>
        </tr>
        <tr><td colspan="8" align="right" >
			<?php if($irna_final == ''){ ?>
			<input type="button" value="simpan" class="myButton1" onclick="simpan();"/>
			<?php if(!empty($idx)){ 
				$sql_view_rm = 'SELECT FILE_ID FROM t_rm_dokumen_file
						WHERE JNS_PERAWATAN = "2"
						AND NOMR = "' . $nomr . '"
						AND RAWAT_ID = "' . $idx . '"
						AND JENIS_DOKUMEN_ID = "47"
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
	$('#formedit').submit();
}	
</script>