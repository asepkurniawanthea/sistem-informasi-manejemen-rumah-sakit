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
	
		if(empty($_POST['idx'])){		
			mysql_query('INSERT INTO t_irja_pemeriksaan_mcu_narkoba (IRJA_MCU_ID,TERDETEKSI,PEMERIKSAAN_AMPETAMIN,PEMERIKSAAN_MARIJUANA,
			PEMERIKSAAN_MORFIN,PEMERIKSAAN_METHAPHETAMIN,PEMERIKSAAN_COCAIN,PEMERIKSAAN_BENZODIASEPIN,TGL_ASSESMENT,REGISTER,
			NOMOR,KEPERLUAN) 
				VALUES ("' . $_POST['irja_id'] . '",
				"' . ((isset($_POST['terdeteksi'])) ? $_POST['terdeteksi'] : '') . '",
				"' . ((isset($_POST['pemeriksaan_ampetamin'])) ? $_POST['pemeriksaan_ampetamin'] : '') . '",
				"' . ((isset($_POST['pemeriksaan_marijuana'])) ? $_POST['pemeriksaan_marijuana'] : '') . '",
				"' . ((isset($_POST['pemeriksaan_morfin'])) ? $_POST['pemeriksaan_morfin'] : '') . '",
				"' . ((isset($_POST['pemeriksaan_methapethamin'])) ? $_POST['pemeriksaan_methapethamin'] : '') . '",
				"' . ((isset($_POST['pemeriksaan_cocain'])) ? $_POST['pemeriksaan_cocain'] : '') . '",
				"' . ((isset($_POST['pemeriksaan_benzodiasepin'])) ? $_POST['pemeriksaan_benzodiasepin'] : '') . '",
				NOW(),"' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
				"' . replace_quote($_POST['nomor']) . '","' . replace_quote($_POST['keperluan']) . '")') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_irja_pemeriksaan_mcu_narkoba 
				SET TERDETEKSI = "' . ((isset($_POST['terdeteksi'])) ? $_POST['terdeteksi'] : '') . '",
				PEMERIKSAAN_AMPETAMIN = "' . ((isset($_POST['pemeriksaan_ampetamin'])) ? $_POST['pemeriksaan_ampetamin'] : '') . '",
				PEMERIKSAAN_MARIJUANA = "' . ((isset($_POST['pemeriksaan_marijuana'])) ? $_POST['pemeriksaan_marijuana'] : '') . '",
				PEMERIKSAAN_MORFIN = "' . ((isset($_POST['pemeriksaan_morfin'])) ? $_POST['pemeriksaan_morfin'] : '') . '",
				PEMERIKSAAN_METHAPHETAMIN = "' . ((isset($_POST['pemeriksaan_methapethamin'])) ? $_POST['pemeriksaan_methapethamin'] : '') . '",
				PEMERIKSAAN_COCAIN = "' . ((isset($_POST['pemeriksaan_cocain'])) ? $_POST['pemeriksaan_cocain'] : '') . '",
				PEMERIKSAAN_BENZODIASEPIN = "' . ((isset($_POST['pemeriksaan_benzodiasepin'])) ? $_POST['pemeriksaan_benzodiasepin'] : '') . '",
				TGL_ASSESMENT = NOW(),
				REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
				ST_CREATE_ERM = NULL,
				NOMOR = "' . replace_quote($_POST['nomor']) . '",
				KEPERLUAN = "' . replace_quote($_POST['keperluan']) . '"
				WHERE IRJA_MCU_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());
		}
		
		?>
		<script language="JavaScript" >
			alert('Simpan Surat Keterangan Bebas Narkoba Berhasil.');
			window.location = "<?php echo currentUrl(); ?>";
		</script>
		<?php 
	}else{
		$msg_info = 'Harus Oleh Dokter DPJP.';
	}	
}
$qry_pasien = 'SELECT IRJA_MCU_ID,TERDETEKSI,PEMERIKSAAN_AMPETAMIN,PEMERIKSAAN_MARIJUANA,
			PEMERIKSAAN_MORFIN,PEMERIKSAAN_METHAPHETAMIN,PEMERIKSAAN_COCAIN,PEMERIKSAAN_BENZODIASEPIN,
			NOMOR,KEPERLUAN
			FROM t_irja_pemeriksaan_mcu_narkoba
			WHERE IRJA_MCU_ID = "' . $_GET['idx'] . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$idx = $dat_pasien['IRJA_MCU_ID'];
$pemeriksaan_ampetamin = $dat_pasien['PEMERIKSAAN_AMPETAMIN'];
$pemeriksaan_marijuana = $dat_pasien['PEMERIKSAAN_MARIJUANA'];
$pemeriksaan_morfin = $dat_pasien['PEMERIKSAAN_MORFIN'];
$pemeriksaan_methapethamin = $dat_pasien['PEMERIKSAAN_METHAPHETAMIN'];
$pemeriksaan_cocain = $dat_pasien['PEMERIKSAAN_COCAIN'];
$pemeriksaan_benzodiasepin = $dat_pasien['PEMERIKSAAN_BENZODIASEPIN'];
$terdeteksi = $dat_pasien['TERDETEKSI'];	
$nomor = $dat_pasien['NOMOR'];
$keperluan = $dat_pasien['KEPERLUAN'];
?>
<form name="formperiksa" id="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="idx" id="idx" value="<?php echo $idx; ?>" />	
	<input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
	<table border="0" align="center" style="position:static; " width="70%">
		<tr>
			<td colspan="2">Nomor</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="nomor" value="<?php echo $nomor; ?>" class="text_dt" style="width:200px;" ></td>
		</tr>
		<tr>
			<td colspan="2">Keperluan</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="keperluan" value="<?php echo $keperluan; ?>" class="text_dt" style="width:300px;" ></td>
		</tr>
		<tr>
            <td colspan="8">&nbsp;</td>
        </tr>
		<tr>
			<td colspan="8">PEMERIKSAAN</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Dinyatakan</td>
			<td>:</td>
			<td colspan="5"><input type="radio" name="terdeteksi" value="1" <?php if($terdeteksi == '1') echo 'checked'; ?> />&nbsp;Tidak Terdeteksi&nbsp;&nbsp;&nbsp;
				<input type="radio" name="terdeteksi" value="2" <?php if($terdeteksi == '2') echo 'checked'; ?> />&nbsp;Terdeteksi</td>
		</tr>
		<tr>
			<td>&nbsp;</td>	
			<td>&nbsp;</td>	
			<td>&nbsp;</td>	
			<td colspan="5"><input type="checkbox" name="pemeriksaan_ampetamin" value="1" <?php if($pemeriksaan_ampetamin == '1') echo 'checked'; ?> />&nbsp;Gol Amphetamin&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="pemeriksaan_marijuana" value="1" <?php if($pemeriksaan_marijuana == '1') echo 'checked'; ?> />&nbsp;Marijuana&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="pemeriksaan_morfin" value="1" <?php if($pemeriksaan_morfin == '1') echo 'checked'; ?> />&nbsp;Morfin&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="pemeriksaan_methapethamin" value="1" <?php if($pemeriksaan_methapethamin == '1') echo 'checked'; ?> />&nbsp;Methamphetamin&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="pemeriksaan_cocain" value="1" <?php if($pemeriksaan_cocain == '1') echo 'checked'; ?> />&nbsp;Cocain&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="pemeriksaan_benzodiasepin" value="1" <?php if($pemeriksaan_benzodiasepin == '1') echo 'checked'; ?> />&nbsp;Benzodiasepin
			</td>
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
						AND JENIS_DOKUMEN_ID = "57"
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