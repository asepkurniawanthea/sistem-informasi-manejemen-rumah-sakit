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
			mysql_query('INSERT INTO t_irja_pemeriksaan_mcu_jiwa (IRJA_MCU_ID,PEM_PSIKOPATOLOGI,PEM_KEPRIBADIAN,
				PEM_KECERDASAN,PEM_FUNGSI_EKSEKUTIF,TGL_ASSESMENT,REGISTER,NOMOR,KEPERLUAN) 
				VALUES ("' . $_POST['irja_id'] . '",
				"' . ((isset($_POST['pem_psikopatologi'])) ? $_POST['pem_psikopatologi'] : '') . '",
				"' . ((isset($_POST['pem_kepribadian'])) ? $_POST['pem_kepribadian'] : '') . '",
				"' . replace_quote($_POST['pem_kecerdasan']) . '",
				"' . ((isset($_POST['pem_fungsi_eksekutif'])) ? $_POST['pem_fungsi_eksekutif'] : '') . '",
				NOW(),"' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
				"' . replace_quote($_POST['nomor']) . '",
				"' . replace_quote($_POST['keperluan']) . '")') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_irja_pemeriksaan_mcu_jiwa 
				SET PEM_PSIKOPATOLOGI = "' . ((isset($_POST['pem_psikopatologi'])) ? $_POST['pem_psikopatologi'] : '') . '",
				PEM_KEPRIBADIAN = "' . ((isset($_POST['pem_kepribadian'])) ? $_POST['pem_kepribadian'] : '') . '",
				PEM_KECERDASAN = "' . replace_quote($_POST['pem_kecerdasan']) . '",
				PEM_FUNGSI_EKSEKUTIF = "' . ((isset($_POST['pem_fungsi_eksekutif'])) ? $_POST['pem_fungsi_eksekutif'] : '') . '",
				TGL_ASSESMENT = NOW(),
				REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
				ST_CREATE_ERM = NULL,
				NOMOR = "' . replace_quote($_POST['nomor']) . '",
				KEPERLUAN = "' . replace_quote($_POST['keperluan']) . '"
				WHERE IRJA_MCU_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());
		}
		
		?>
		<script language="JavaScript" >
			alert('Simpan Surat Keterangan Pemeriksaan Kesehatan Jiwa Berhasil.');
			window.location = "<?php echo currentUrl(); ?>";
		</script>
		<?php 
	}else{
		$msg_info = 'Harus Oleh Dokter DPJP.';
	}	
}
$qry_pasien = 'SELECT IRJA_MCU_ID,PEM_PSIKOPATOLOGI,PEM_KEPRIBADIAN,PEM_KECERDASAN,PEM_FUNGSI_EKSEKUTIF,NOMOR,KEPERLUAN
			FROM t_irja_pemeriksaan_mcu_jiwa
			WHERE IRJA_MCU_ID = "' . $_GET['idx'] . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$idx = $dat_pasien['IRJA_MCU_ID'];
$pem_psikopatologi = $dat_pasien['PEM_PSIKOPATOLOGI'];
$pem_kepribadian = $dat_pasien['PEM_KEPRIBADIAN'];
$pem_kecerdasan = $dat_pasien['PEM_KECERDASAN'];
$pem_fungsi_eksekutif = $dat_pasien['PEM_FUNGSI_EKSEKUTIF'];
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
			<td>Psikopatologi</td>
			<td>:</td>
			<td colspan="5"><input type="radio" name="pem_psikopatologi" value="1" <?php if($pem_psikopatologi == '1') echo 'checked'; ?> />&nbsp;Ditemukan&nbsp;&nbsp;&nbsp;
			<input type="radio" name="pem_psikopatologi" value="2" <?php if($pem_psikopatologi == '2') echo 'checked'; ?> />&nbsp;Tidak Ditemukan&nbsp;&nbsp;&nbsp;Gejala
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Kepribadian</td>
			<td>:</td>
			<td colspan="5"><input type="radio" name="pem_kepribadian" value="1" <?php if($pem_kepribadian == '1') echo 'checked'; ?> />&nbsp;Ditemukan&nbsp;&nbsp;&nbsp;
			<input type="radio" name="pem_kepribadian" value="2" <?php if($pem_kepribadian == '2') echo 'checked'; ?> />&nbsp;Tidak Ditemukan&nbsp;&nbsp;&nbsp;Gejala
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Kecerdasan</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="pem_kecerdasan" value="<?php echo $pem_kecerdasan; ?>" class="text_dt" style="width:500px;" >
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Fungsi Eksekutif</td>
			<td>:</td>
			<td colspan="5"><input type="radio" name="pem_fungsi_eksekutif" value="1" <?php if($pem_fungsi_eksekutif == '1') echo 'checked'; ?> />&nbsp;Ditemukan&nbsp;&nbsp;&nbsp;
			<input type="radio" name="pem_fungsi_eksekutif" value="2" <?php if($pem_fungsi_eksekutif == '2') echo 'checked'; ?> />&nbsp;Tidak Ditemukan&nbsp;&nbsp;&nbsp;Gejala
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
						AND JENIS_DOKUMEN_ID = "59"
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