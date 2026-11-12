<?php
function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = str_replace('|','!',$str);
	$ret = htmlspecialchars($ret);
	return $ret;
}
	
if (isset($_POST['irna_id'])){
			/*
			mysql_query('UPDATE t_irna_pemeriksaan_sitopatologi 
				SET NO_SEDIAAN = "' . replace_quote($_POST['no_sediaan']) . '",
				TGL_DITERIMA = STR_TO_DATE("' . $_POST['tgl_diterima'] . '","%d/%m/%Y"),
				NAMA_DOKTER = "' . replace_quote($_POST['nama_dokter']) . '",
				NAMA_BAGIAN = "' . replace_quote($_POST['nama_bagian']) . '",
				NAMA_RS = "' . replace_quote($_POST['nama_rs']) . '",
				ALAMAT_RS = "' . replace_quote($_POST['alamat_rs']) . '",
				BERASAL_DARI = "' . replace_quote($_POST['berasal_dari']) . '",
				DIAGNOSA_KLINIK = "' . replace_quote($_POST['diagnosa_klinik']) . '",
				PEM_HISTOPATOLOGI_TGL = STR_TO_DATE("' . $_POST['pem_histopatologi_tgl'] . '","%d/%m/%Y"),
				PEM_HISTOPATOLOGI_NO = "' . replace_quote($_POST['pem_histopatologi_no']) . '",
				PEM_HISTOPATOLOGI_DI = "' . replace_quote($_POST['pem_histopatologi_di']) . '",
				KETERANGAN = "' . replace_quote($_POST['keterangan']) . '",
				TGL_ASSESMENT = NOW(),
				REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
				ST_CREATE_ERM = NULL,
				BANGSA = "' . replace_quote($_POST['bangsa']) . '"
				WHERE IRNA_ID = "' . $_POST['irna_id'] . '"') or die(mysql_error());
			*/
			
			mysql_query('UPDATE t_irna_pemeriksaan_sitopatologi 
				SET BERASAL_DARI = "' . replace_quote($_POST['berasal_dari']) . '",
				DIAGNOSA_KLINIK = "' . replace_quote($_POST['diagnosa_klinik']) . '",
				PEM_HISTOPATOLOGI_TGL = STR_TO_DATE("' . $_POST['pem_histopatologi_tgl'] . '","%d/%m/%Y"),
				PEM_HISTOPATOLOGI_NO = "' . replace_quote($_POST['pem_histopatologi_no']) . '",
				PEM_HISTOPATOLOGI_DI = "' . replace_quote($_POST['pem_histopatologi_di']) . '",
				KETERANGAN = "' . replace_quote($_POST['keterangan']) . '",
				TGL_ASSESMENT = NOW(),
				REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
				ST_CREATE_ERM = NULL,
				BANGSA = "' . replace_quote($_POST['bangsa']) . '",
				PEGAWAI_ID = "' . replace_quote($_POST['pegawai_id']) . '"
				WHERE IRNA_ID = "' . $_POST['irna_id'] . '"') or die(mysql_error());

		?>
		<script language="JavaScript" >
			alert('Simpan Pemeriksaan Histopatologik/ Sitopatologik Berhasil.');
			window.location = "<?php echo currentUrl(); ?>";
		</script>
		<?php 	
}
$qry_pasien = 'SELECT IRNA_ID,NO_SEDIAAN,DATE_FORMAT(TGL_DITERIMA,"%d/%m/%Y") AS TGL_DITERIMA,
			NAMA_DOKTER,NAMA_BAGIAN,NAMA_RS,ALAMAT_RS,BERASAL_DARI,DIAGNOSA_KLINIK,
			DATE_FORMAT(PEM_HISTOPATOLOGI_TGL,"%d/%m/%Y") AS PEM_HISTOPATOLOGI_TGL,PEM_HISTOPATOLOGI_NO,
			PEM_HISTOPATOLOGI_DI,KETERANGAN,BANGSA,DIAGNOSA_GBR
			FROM t_irna_pemeriksaan_sitopatologi
			WHERE IRNA_ID = "' . $_GET['idx'] . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$idx = $dat_pasien['IRNA_ID'];
$no_sediaan = $dat_pasien['NO_SEDIAAN'];
$tgl_diterima = $dat_pasien['TGL_DITERIMA'];
$nama_dokter = $dat_pasien['NAMA_DOKTER'];
$nama_bagian = $dat_pasien['NAMA_BAGIAN'];
$nama_rs = $dat_pasien['NAMA_RS'];
$alamat_rs = $dat_pasien['ALAMAT_RS'];
$berasal_dari = $dat_pasien['BERASAL_DARI'];
$diagnosa_klinik = $dat_pasien['DIAGNOSA_KLINIK'];
$pem_histopatologi_tgl = $dat_pasien['PEM_HISTOPATOLOGI_TGL'];
$pem_histopatologi_no = $dat_pasien['PEM_HISTOPATOLOGI_NO'];
$pem_histopatologi_di = $dat_pasien['PEM_HISTOPATOLOGI_DI'];
$keterangan = $dat_pasien['KETERANGAN'];
$bangsa = $dat_pasien['BANGSA'];
$diagnosa_gbr = $dat_pasien['DIAGNOSA_GBR'];

if($idx == ''){
	$qry_diagnosa = 'SELECT DIAGNOSA_ORDER,DIAGNOSA
		FROM t_irna_diagnosa
		WHERE IRNA_ID = "' . $_GET['idx'] . '"
		ORDER BY DIAGNOSA_ORDER';
	$get_diagnosa = mysql_query($qry_diagnosa) or die(mysql_error());
	$diagnosa = '';
	while($dat_diagnosa= mysql_fetch_array($get_diagnosa)){
		$diagnosa.=$dat_diagnosa['DIAGNOSA'] . ',';
	}
	$diagnosa_klinik = substr($diagnosa,0,strlen($diagnosa)-1);
}	
?>
<form name="formedit" id="formedit" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="idx" id="idx" value="<?php echo $idx; ?>" />	
	<input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />	
	<table border="0" align="center" style="position:static; " width="90%">
        <!--
		<tr>
			<td colspan="8">PENERIMA</td>
		</tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">No Sediaan</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><input type="text" name="no_sediaan" value="<?php echo $no_sediaan; ?>" class="text_dt" style="width:300px;" /></td>
		</tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">Tgl Diterima</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><input type="text" name="tgl_diterima" id="tgl_1" class="text_dt" size="10" value="<?php echo $tgl_diterima; ?>" readonly="readonly" onblur="false_kan();" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar8')"/></td>
		</tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">Dokter</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><input type="text" name="nama_dokter" value="<?php echo $nama_dokter; ?>" class="text_dt" style="width:300px;" /></td>
		</tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">Bagian</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><input type="text" name="nama_bagian" value="<?php echo $nama_bagian; ?>" class="text_dt" style="width:300px;" /></td>
		</tr>	
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">Rumah Sakit</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><input type="text" name="nama_rs" value="<?php echo $nama_rs; ?>" class="text_dt" style="width:300px;" /></td>
		</tr>		
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Alamat</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="alamat_rs" class="text_dt10" ><?php echo $alamat_rs; ?></textarea></td>
		</tr>
		-->
		<tr>
            <td valign="top" colspan="2" width="200px;">Berasal Dari</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="berasal_dari" class="text_dt10" ><?php echo $berasal_dari; ?></textarea></td>
        </tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Diagnosa Klinik</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="diagnosa_klinik" class="text_dt10" ><?php echo $diagnosa_klinik; ?></textarea></td>
        </tr>
		<tr>	
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="5" align="center">
				<div id="signature-pad" class="signature-pad">
					<canvas style="width:760px;height:500px;"></canvas>
				</div>
				<button type="button" class="button clear" onclick="clearCanvas();" style="width:760px;">Clear</button>
			</td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Keterangan</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="keterangan" class="text_dt10" ><?php echo $keterangan; ?></textarea></td>
        </tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Pernah dilakukan Pemeriksaan</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5">&nbsp;</td>
        </tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">Tanggal</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><input type="text" name="pem_histopatologi_tgl" id="tgl_2" class="text_dt" size="10" value="<?php echo $pem_histopatologi_tgl; ?>" readonly="readonly" onblur="false_kan();" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar9')"/></td>
		</tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">Nomor</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><input type="text" name="pem_histopatologi_no" value="<?php echo $pem_histopatologi_no; ?>" class="text_dt" style="width:300px;" /></td>
		</tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">Di</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><input type="text" name="pem_histopatologi_di" value="<?php echo $pem_histopatologi_di; ?>" class="text_dt" style="width:500px;" /></td>
		</tr>
		<tr>
			<td colspan="2" valign="top" width="220px">Bangsa/ Suku</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><input type="text" name="bangsa" value="<?php echo $bangsa; ?>" class="text_dt" style="width:500px;" /></td>
		</tr>
        <tr>
            <td colspan="8">*<i>Mohon item pemeriksaan laboratoriumnya diisi di Perm. Laboratorium</i></td>
        </tr>
        <tr><td colspan="8" align="right" >
			<?php if($irna_final == ''){ ?>
			<?php if(!isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])){ ?>
			Dokter Pengirim&nbsp;&nbsp;<select name="pegawai_id" id="pegawai_id" style="width:228px;" class="text_dt" onblur="false_kan();" >
                    <option value="" > - </option>
                    <?php echo getDokterRanap($pegawai_id); ?>
                </select>&nbsp;&nbsp;&nbsp;&nbsp;
			<?php }else{ ?>
			<input type="hidden" name="pegawai_id" id="pegawai_id" value="<?php echo $_SESSION['SES_SIMRS_PEGAWAI_ID']; ?>" />
			<?php } ?>
			<input type="button" value="simpan" class="myButton1" onclick="simpan();"/>
			<?php if(!empty($idx)){ 
				$sql_view_rm = 'SELECT FILE_ID FROM t_rm_dokumen_file
						WHERE JNS_PERAWATAN = "2"
						AND NOMR = "' . $nomr . '"
						AND RAWAT_ID = "' . $idx . '"
						AND JENIS_DOKUMEN_ID = "62"
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
<script src="script/signature/js/app_2.js"></script>
<script>
<?php 
	if(empty($diagnosa_gbr)){
		$path_image = $app_path . 'nsimrs/edoc_rekammedik/new/pemeriksaan_histopatologi.jpg';
		$type = pathinfo($path_image, PATHINFO_EXTENSION);
		$data = file_get_contents($path_image);
		$image = 'data:image/' . $type . ';base64,' . base64_encode($data);	
	}else{
		$path_image = $rmfile_path . '/pemeriksaan_histopatologi/' . $diagnosa_gbr;
		$type = pathinfo($path_image, PATHINFO_EXTENSION);
		$data = file_get_contents($path_image);
		$image = 'data:image/' . $type . ';base64,' . base64_encode($data);	
	}		
	
	$path_image = $app_path . 'nsimrs/edoc_rekammedik/new/pemeriksaan_histopatologi.jpg';
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
			url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/index.php?ajaxrequest=ranapaddhistopatologi',
			data: { img: image,
				idx : '<?php echo $idx; ?>',
				irna_id : '<?php echo $irna_id; ?>',
				nomr : '<?php echo $nomr; ?>'
				},
			cache: false,
			success: function(data) {
				
				if (data != ''){ 
					if(data == 'ok'){
						 $("#formedit").submit();
					}else{
						alert(data);
					}		
				}	
				
			},});	
}	

defaultCanvas();
</script>