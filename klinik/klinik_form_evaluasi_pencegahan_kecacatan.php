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
		$arr_tanggal = array('01'=>replace_quote($_POST['tanggal_01']),
						'02'=>replace_quote($_POST['tanggal_02']),
						'03'=>replace_quote($_POST['tanggal_03']),
						'04'=>replace_quote($_POST['tanggal_04']));
		$arr_tanggal = json_encode($arr_tanggal);
		$arr_tanggal = str_replace('"','|',$arr_tanggal);	
		
		$arr_lagophthalmus = array('01'=>replace_quote($_POST['lagophthalmus_01']),
						'02'=>replace_quote($_POST['lagophthalmus_02']),
						'03'=>replace_quote($_POST['lagophthalmus_03']),
						'04'=>replace_quote($_POST['lagophthalmus_04']));
		$arr_lagophthalmus = json_encode($arr_lagophthalmus);
		$arr_lagophthalmus = str_replace('"','|',$arr_lagophthalmus);	
		
		$arr_ulnaris = array('01'=>replace_quote($_POST['ulnaris_01']),
						'02'=>replace_quote($_POST['ulnaris_02']),
						'03'=>replace_quote($_POST['ulnaris_03']),
						'04'=>replace_quote($_POST['ulnaris_04']));
		$arr_ulnaris = json_encode($arr_ulnaris);
		$arr_ulnaris = str_replace('"','|',$arr_ulnaris);	
		
		$arr_medianus = array('01'=>replace_quote($_POST['medianus_01']),
						'02'=>replace_quote($_POST['medianus_02']),
						'03'=>replace_quote($_POST['medianus_03']),
						'04'=>replace_quote($_POST['medianus_04']));
		$arr_medianus = json_encode($arr_medianus);
		$arr_medianus = str_replace('"','|',$arr_medianus);	
		
		$arr_radialis = array('01'=>replace_quote($_POST['radialis_01']),
						'02'=>replace_quote($_POST['radialis_02']),
						'03'=>replace_quote($_POST['radialis_03']),
						'04'=>replace_quote($_POST['radialis_04']));
		$arr_radialis = json_encode($arr_radialis);
		$arr_radialis = str_replace('"','|',$arr_radialis);	
		
		$arr_otot_tangan = array('01'=>replace_quote($_POST['otot_tangan_01']),
						'02'=>replace_quote($_POST['otot_tangan_02']),
						'03'=>replace_quote($_POST['otot_tangan_03']),
						'04'=>replace_quote($_POST['otot_tangan_04']));
		$arr_otot_tangan = json_encode($arr_otot_tangan);
		$arr_otot_tangan = str_replace('"','|',$arr_otot_tangan);	
		
		$arr_poroneus = array('01'=>replace_quote($_POST['poroneus_01']),
						'02'=>replace_quote($_POST['poroneus_02']),
						'03'=>replace_quote($_POST['poroneus_03']),
						'04'=>replace_quote($_POST['poroneus_04']));
		$arr_poroneus = json_encode($arr_poroneus);
		$arr_poroneus = str_replace('"','|',$arr_poroneus);	
		
		$arr_tibialis = array('01'=>replace_quote($_POST['tibialis_01']),
						'02'=>replace_quote($_POST['tibialis_02']),
						'03'=>replace_quote($_POST['tibialis_03']),
						'04'=>replace_quote($_POST['tibialis_04']));
		$arr_tibialis = json_encode($arr_tibialis);
		$arr_tibialis = str_replace('"','|',$arr_tibialis);	
		
		$arr_otot_kaki = array('01'=>replace_quote($_POST['otot_kaki_01']),
						'02'=>replace_quote($_POST['otot_kaki_02']),
						'03'=>replace_quote($_POST['otot_kaki_03']),
						'04'=>replace_quote($_POST['otot_kaki_04']));
		$arr_otot_kaki = json_encode($arr_otot_kaki);
		$arr_otot_kaki = str_replace('"','|',$arr_otot_kaki);	
		
		$arr_kecacatan = array('01'=>replace_quote($_POST['kecacatan_01']),
						'02'=>replace_quote($_POST['kecacatan_02']),
						'03'=>replace_quote($_POST['kecacatan_03']),
						'04'=>replace_quote($_POST['kecacatan_04']));
		$arr_kecacatan = json_encode($arr_kecacatan);
		$arr_kecacatan = str_replace('"','|',$arr_kecacatan);	
		
		mysql_query('UPDATE t_pencegahan_kecacatan 
				SET TANGGAL = "' . $arr_tanggal . '",
				LAGOPHTHALMUS = "' . $arr_lagophthalmus . '",
				ULNARIS = "' . $arr_ulnaris . '",
				MEDIANUS = "' . $arr_medianus . '",
				RADIALIS = "' . $arr_radialis . '",
				OTOT_TANGAN = "' . $arr_otot_tangan . '",
				PERONEUS = "' . $arr_poroneus . '",
				TIBIALIS = "' . $arr_tibialis . '",
				OTOT_KAKI = "' . $arr_otot_kaki . '",
				KECACATAN  = "' . $arr_kecacatan . '",
				TGL_ASSESMENT  = NOW(),
				REGISTER = "'. $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] .'",
				ST_CREATE_ERM = NULL
				WHERE IRJA_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());
				
		/*
		include('lib/vendor/autoload.php');
		include('edoc_rekammedik/new/erm_create_evaluasi_pencegahan_kecacatan.php');
		erm_evaluasi_pencegahan_kecacatan($_POST['irja_id']);			
		*/
		?>
		<script language="JavaScript" >
			alert('Simpan Evaluasi Pencegahan Kecacatan Berhasil.');
			window.location = "<?php echo currentUrl(); ?>";
		</script>
		<?php 
	}else{
		$msg_info = 'Harus Oleh Dokter DPJP.';
	}	
}

$qry_pasien = 'SELECT IRJA_ID,TANGGAL,LAGOPHTHALMUS,ULNARIS,MEDIANUS,RADIALIS,OTOT_TANGAN,PERONEUS,TIBIALIS,OTOT_KAKI,
			KECACATAN_GBR,KECACATAN
			FROM t_pencegahan_kecacatan
			WHERE IRJA_ID = "' . $_GET['idx'] . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$idx = $dat_pasien['IRJA_ID'];

$tanggal = str_replace('|','"',$dat_pasien['TANGGAL']);
$tanggal = preg_replace('/\r|\n/','\n',trim($tanggal));
$tanggal = json_decode($tanggal,true);

$lagophthalmus = str_replace('|','"',$dat_pasien['LAGOPHTHALMUS']);
$lagophthalmus = preg_replace('/\r|\n/','\n',trim($lagophthalmus));
$lagophthalmus = json_decode($lagophthalmus,true);

$ulnaris = str_replace('|','"',$dat_pasien['ULNARIS']);
$ulnaris = preg_replace('/\r|\n/','\n',trim($ulnaris));
$ulnaris = json_decode($ulnaris,true);

$medianus = str_replace('|','"',$dat_pasien['MEDIANUS']);
$medianus = preg_replace('/\r|\n/','\n',trim($medianus));
$medianus = json_decode($medianus,true);

$radialis = str_replace('|','"',$dat_pasien['RADIALIS']);
$radialis = preg_replace('/\r|\n/','\n',trim($radialis));
$radialis = json_decode($radialis,true);

$otot_tangan = str_replace('|','"',$dat_pasien['OTOT_TANGAN']);
$otot_tangan = preg_replace('/\r|\n/','\n',trim($otot_tangan));
$otot_tangan = json_decode($otot_tangan,true);

$poroneus = str_replace('|','"',$dat_pasien['PERONEUS']);
$poroneus = preg_replace('/\r|\n/','\n',trim($poroneus));
$poroneus = json_decode($poroneus,true);

$tibialis = str_replace('|','"',$dat_pasien['TIBIALIS']);
$tibialis = preg_replace('/\r|\n/','\n',trim($tibialis));
$tibialis = json_decode($tibialis,true);

$otot_kaki = str_replace('|','"',$dat_pasien['OTOT_KAKI']);
$otot_kaki = preg_replace('/\r|\n/','\n',trim($otot_kaki));
$otot_kaki = json_decode($otot_kaki,true);

$kecacatan = str_replace('|','"',$dat_pasien['KECACATAN']);
$kecacatan = preg_replace('/\r|\n/','\n',trim($kecacatan));
$kecacatan = json_decode($kecacatan,true);

$kecacatan_gbr = $dat_pasien['KECACATAN_GBR'];
?>
<form name="formperiksa" id="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="idx" id="idx" value="<?php echo $idx; ?>" />	
	<input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />	
	<table border="0" align="center" style="position:static; " width="100%">
		<tr>	
			<td colspan="8">
				<table width="100%" class="tableData">
					<tr>
						<th colspan="3" align="center"><strong>Deskripsi</strong></th>
						<th align="center"><strong>Tgl/ Jam</strong></th>
						<th align="center"><strong>Tgl/ Jam</strong></th>
						<th align="center"><strong>Tgl/ Jam</strong></th>
						<th align="center"><strong>Tgl/ Jam</strong></th>
					</tr>
					<tr>
						<td colspan="3">&nbsp;</td>
						<td align="center"><input type="text" name="tanggal_01" class="text_dt" style="width:200px;" value="<?php echo ((isset($tanggal['01'])) ? $tanggal['01'] : ''); ?>" /></td>
						<td align="center"><input type="text" name="tanggal_02" class="text_dt" style="width:200px;" value="<?php echo ((isset($tanggal['02'])) ? $tanggal['02'] : ''); ?>" /></td>
						<td align="center"><input type="text" name="tanggal_03" class="text_dt" style="width:200px;" value="<?php echo ((isset($tanggal['03'])) ? $tanggal['03'] : ''); ?>" /></td>
						<td align="center"><input type="text" name="tanggal_04" class="text_dt" style="width:200px;" value="<?php echo ((isset($tanggal['04'])) ? $tanggal['04'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td colspan="7">SYARAF</td>
					</tr>
					<tr>
						<td colspan="3">&nbsp;&nbsp;1. Mata (Lagophthalmus)</td>
						<td><textarea name="lagophthalmus_01" class="text_dt8" rows="3"><?php echo ((isset($lagophthalmus['01'])) ? $lagophthalmus['01'] : ''); ?></textarea></td>
						<td><textarea name="lagophthalmus_02" class="text_dt8" rows="3"><?php echo ((isset($lagophthalmus['02'])) ? $lagophthalmus['02'] : ''); ?></textarea></td>
						<td><textarea name="lagophthalmus_03" class="text_dt8" rows="3"><?php echo ((isset($lagophthalmus['03'])) ? $lagophthalmus['03'] : ''); ?></textarea></td>
						<td><textarea name="lagophthalmus_04" class="text_dt8" rows="3"><?php echo ((isset($lagophthalmus['04'])) ? $lagophthalmus['04'] : ''); ?></textarea></td>
					</tr>
					<tr>
						<td colspan="7">&nbsp;&nbsp;2. Tangan</td>
					</tr>
					<tr>
						<td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;n. ulnaris</td>
						<td><textarea name="ulnaris_01" class="text_dt8" rows="3"><?php echo ((isset($ulnaris['01'])) ? $ulnaris['01'] : ''); ?></textarea></td>
						<td><textarea name="ulnaris_02" class="text_dt8" rows="3"><?php echo ((isset($ulnaris['02'])) ? $ulnaris['02'] : ''); ?></textarea></td>
						<td><textarea name="ulnaris_03" class="text_dt8" rows="3"><?php echo ((isset($ulnaris['03'])) ? $ulnaris['03'] : ''); ?></textarea></td>
						<td><textarea name="ulnaris_04" class="text_dt8" rows="3"><?php echo ((isset($ulnaris['04'])) ? $ulnaris['04'] : ''); ?></textarea></td>
					</tr>
					<tr>
						<td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;n. medianus</td>
						<td><textarea name="medianus_01" class="text_dt8" rows="3"><?php echo ((isset($medianus['01'])) ? $medianus['01'] : ''); ?></textarea></td>
						<td><textarea name="medianus_02" class="text_dt8" rows="3"><?php echo ((isset($medianus['02'])) ? $medianus['02'] : ''); ?></textarea></td>
						<td><textarea name="medianus_03" class="text_dt8" rows="3"><?php echo ((isset($medianus['03'])) ? $medianus['03'] : ''); ?></textarea></td>
						<td><textarea name="medianus_04" class="text_dt8" rows="3"><?php echo ((isset($medianus['04'])) ? $medianus['04'] : ''); ?></textarea></td>
					</tr>
					<tr>
						<td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;n. radialis</td>
						<td><textarea name="radialis_01" class="text_dt8" rows="3"><?php echo ((isset($radialis['01'])) ? $radialis['01'] : ''); ?></textarea></td>
						<td><textarea name="radialis_02" class="text_dt8" rows="3"><?php echo ((isset($radialis['02'])) ? $radialis['02'] : ''); ?></textarea></td>
						<td><textarea name="radialis_03" class="text_dt8" rows="3"><?php echo ((isset($radialis['03'])) ? $radialis['03'] : ''); ?></textarea></td>
						<td><textarea name="radialis_04" class="text_dt8" rows="3"><?php echo ((isset($radialis['04'])) ? $radialis['04'] : ''); ?></textarea></td>
					</tr>
					<tr>
						<td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kekuatan otot tangan</td>
						<td><textarea name="otot_tangan_01" class="text_dt8" rows="3"><?php echo ((isset($otot_tangan['01'])) ? $otot_tangan['01'] : ''); ?></textarea></td>
						<td><textarea name="otot_tangan_02" class="text_dt8" rows="3"><?php echo ((isset($otot_tangan['02'])) ? $otot_tangan['02'] : ''); ?></textarea></td>
						<td><textarea name="otot_tangan_03" class="text_dt8" rows="3"><?php echo ((isset($otot_tangan['03'])) ? $otot_tangan['03'] : ''); ?></textarea></td>
						<td><textarea name="otot_tangan_04" class="text_dt8" rows="3"><?php echo ((isset($otot_tangan['04'])) ? $otot_tangan['04'] : ''); ?></textarea></td>
					</tr>
					<tr>
						<td colspan="7">&nbsp;&nbsp;3. Kaki</td>
					</tr>
					<tr>
						<td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;n. poroneus communis</td>
						<td><textarea name="poroneus_01" class="text_dt8" rows="3"><?php echo ((isset($poroneus['01'])) ? $poroneus['01'] : ''); ?></textarea></td>
						<td><textarea name="poroneus_02" class="text_dt8" rows="3"><?php echo ((isset($poroneus['02'])) ? $poroneus['02'] : ''); ?></textarea></td>
						<td><textarea name="poroneus_03" class="text_dt8" rows="3"><?php echo ((isset($poroneus['03'])) ? $poroneus['03'] : ''); ?></textarea></td>
						<td><textarea name="poroneus_04" class="text_dt8" rows="3"><?php echo ((isset($poroneus['04'])) ? $poroneus['04'] : ''); ?></textarea></td>
					</tr>
					<tr>
						<td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;n. tibialis posterior</td>
						<td><textarea name="tibialis_01" class="text_dt8" rows="3"><?php echo ((isset($tibialis['01'])) ? $tibialis['01'] : ''); ?></textarea></td>
						<td><textarea name="tibialis_02" class="text_dt8" rows="3"><?php echo ((isset($tibialis['02'])) ? $tibialis['02'] : ''); ?></textarea></td>
						<td><textarea name="tibialis_03" class="text_dt8" rows="3"><?php echo ((isset($tibialis['03'])) ? $tibialis['03'] : ''); ?></textarea></td>
						<td><textarea name="tibialis_04" class="text_dt8" rows="3"><?php echo ((isset($tibialis['04'])) ? $tibialis['04'] : ''); ?></textarea></td>
					</tr>
					<tr>
						<td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kekuatan otot kaki</td>
						<td><textarea name="otot_kaki_01" class="text_dt8" rows="3"><?php echo ((isset($otot_kaki['01'])) ? $otot_kaki['01'] : ''); ?></textarea></td>
						<td><textarea name="otot_kaki_02" class="text_dt8" rows="3"><?php echo ((isset($otot_kaki['02'])) ? $otot_kaki['02'] : ''); ?></textarea></td>
						<td><textarea name="otot_kaki_03" class="text_dt8" rows="3"><?php echo ((isset($otot_kaki['03'])) ? $otot_kaki['03'] : ''); ?></textarea></td>
						<td><textarea name="otot_kaki_04" class="text_dt8" rows="3"><?php echo ((isset($otot_kaki['04'])) ? $otot_kaki['04'] : ''); ?></textarea></td>
					</tr>
					<tr>
						<td colspan="7">KECACATAN</td>
					</tr>
					<tr>
						<td colspan="3" align="center"><div id="signature-pad" class="signature-pad">
							<canvas style="width:160px;height:160px;"></canvas>
							</div>
				<button type="button" class="button clear" onclick="clearCanvas();" style="width:160px;">Clear</button></td>
						<td><textarea name="kecacatan_01" class="text_dt8" rows="3"><?php echo ((isset($kecacatan['01'])) ? $kecacatan['01'] : ''); ?></textarea></td>
						<td><textarea name="kecacatan_02" class="text_dt8" rows="3"><?php echo ((isset($kecacatan['02'])) ? $kecacatan['02'] : ''); ?></textarea></td>
						<td><textarea name="kecacatan_03" class="text_dt8" rows="3"><?php echo ((isset($kecacatan['03'])) ? $kecacatan['03'] : ''); ?></textarea></td>
						<td><textarea name="kecacatan_04" class="text_dt8" rows="3"><?php echo ((isset($kecacatan['04'])) ? $kecacatan['04'] : ''); ?></textarea></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="8">&nbsp;</td>
		</tr>
        <tr><td colspan="8" align="right" >
			<?php if($irja_final == ''){ ?>
			<input type="button" value="simpan" class="myButton1" onclick="simpan();" />
			<?php if(!empty($idx)){ 
				$sql_view_rm = 'SELECT FILE_ID FROM t_rm_dokumen_file
						WHERE JNS_PERAWATAN = "1"
						AND NOMR = "' . $nomr . '"
						AND RAWAT_ID = "' . $idx . '"
						AND JENIS_DOKUMEN_ID = "29"
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
<script src="script/signature/js/signature_pad.umd.js"></script>
<script src="script/signature/js/app.js"></script>
<script>
<?php 
	if(empty($kecacatan_gbr)){
		$path_image = $app_path . 'nsimrs/edoc_rekammedik/new/pencegahan_kecacatan2.jpg';
		$type = pathinfo($path_image, PATHINFO_EXTENSION);
		$data = file_get_contents($path_image);
		$image = 'data:image/' . $type . ';base64,' . base64_encode($data);	
	}else{
		$path_image = $rmfile_path . '/pengkajian_awal_medik_kusta/' . $kecacatan_gbr;
		$type = pathinfo($path_image, PATHINFO_EXTENSION);
		$data = file_get_contents($path_image);
		$image = 'data:image/' . $type . ';base64,' . base64_encode($data);	
	}	
	
	$path_image = $app_path . 'nsimrs/edoc_rekammedik/new/pencegahan_kecacatan2.jpg';
	$type = pathinfo($path_image, PATHINFO_EXTENSION);
	$data = file_get_contents($path_image);
	$image_ori = 'data:image/' . $type . ';base64,' . base64_encode($data);	
?>
function clearCanvas(){
	if(confirm('Bersihkan ?')){	
		signaturePad.fromDataURL('<?php echo $image_ori; ?>');
	}
}

function defaultCanvas(){
	signaturePad.fromDataURL('<?php echo $image; ?>');
}

function simpan(){
	_haschange = false;
	
	var image = signaturePad.toDataURL("image/jpg");
	$.ajax({
			type: 'POST',
			url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/index.php?ajaxrequest=klinikaddpencegahankecacatan',
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

defaultCanvas();
</script>