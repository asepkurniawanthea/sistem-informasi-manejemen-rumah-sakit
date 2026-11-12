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
			mysql_query('INSERT INTO t_irja_pemeriksaan_mcu_mata (IRJA_MCU_ID,KEADAAN_MATA,PEMERIKSAAN_MATA_TP_KOREKSI_OD,PEMERIKSAAN_MATA_TP_KOREKSI_OS,
			PEMERIKSAAN_MATA_DG_KOREKSI_OD,PEMERIKSAAN_MATA_DG_KOREKSI_OS,TEST_BUTA_WARNA,HASIL_TES_BUTA_WARNA,
			HASIL_TES_BUTA_WARNA_TOTAL,TGL_ASSESMENT,REGISTER,KEPERLUAN,NOMOR) 
				VALUES ("' . $_POST['irja_id'] . '",
				"' . replace_quote($_POST['keadaan_mata']) . '",
				"' . replace_quote($_POST['pem_mata_tpk_od']) . '",
				"' . replace_quote($_POST['pem_mata_tpk_os']) . '",
				"' . replace_quote($_POST['pem_mata_dgk_od']) . '",
				"' . replace_quote($_POST['pem_mata_dgk_os']) . '",
				"' . replace_quote($_POST['tes_buta_warna']) . '",
				"' . ((isset($_POST['hasil_tes_buta_warna'])) ? $_POST['hasil_tes_buta_warna'] : '') . '",
				"' . ((isset($_POST['hasil_tes_buta_warna_total'])) ? $_POST['hasil_tes_buta_warna_total'] : '') . '",
				NOW(),"' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
				"' . replace_quote($_POST['keperluan']) . '","' . replace_quote($_POST['nomor']) . '")') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_irja_pemeriksaan_mcu_mata 
				SET KEADAAN_MATA = "' . replace_quote($_POST['keadaan_mata']) . '",
				PEMERIKSAAN_MATA_TP_KOREKSI_OD = "' . replace_quote($_POST['pem_mata_tpk_od']) . '",
				PEMERIKSAAN_MATA_TP_KOREKSI_OS = "' . replace_quote($_POST['pem_mata_tpk_os']) . '",
				PEMERIKSAAN_MATA_DG_KOREKSI_OD = "' . replace_quote($_POST['pem_mata_dgk_od']) . '",
				PEMERIKSAAN_MATA_DG_KOREKSI_OS = "' . replace_quote($_POST['pem_mata_dgk_os']) . '",
				TEST_BUTA_WARNA = "' . replace_quote($_POST['tes_buta_warna']) . '",
				HASIL_TES_BUTA_WARNA = "' . ((isset($_POST['hasil_tes_buta_warna'])) ? $_POST['hasil_tes_buta_warna'] : '') . '",
				HASIL_TES_BUTA_WARNA_TOTAL = "' . ((isset($_POST['hasil_tes_buta_warna_total'])) ? $_POST['hasil_tes_buta_warna_total'] : '') . '",
				TGL_ASSESMENT = NOW(),
				REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
				ST_CREATE_ERM = NULL,
				KEPERLUAN = "' . replace_quote($_POST['keperluan']) . '",
				NOMOR = "' . replace_quote($_POST['nomor']) . '"
				WHERE IRJA_MCU_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());
		}
		
		?>
		<script language="JavaScript" >
			alert('Simpan Surat Keterangan Pemeriksaan Kesehatan Mata Berhasil.');
			window.location = "<?php echo currentUrl(); ?>";
		</script>
		<?php 
	}else{
		$msg_info = 'Harus Oleh Dokter DPJP.';
	}	
}
$qry_pasien = 'SELECT IRJA_MCU_ID,KEADAAN_MATA,PEMERIKSAAN_MATA_TP_KOREKSI_OD,PEMERIKSAAN_MATA_TP_KOREKSI_OS,
			PEMERIKSAAN_MATA_DG_KOREKSI_OD,PEMERIKSAAN_MATA_DG_KOREKSI_OS,TEST_BUTA_WARNA,HASIL_TES_BUTA_WARNA,
			HASIL_TES_BUTA_WARNA_TOTAL,KEPERLUAN,NOMOR
			FROM t_irja_pemeriksaan_mcu_mata
			WHERE IRJA_MCU_ID = "' . $_GET['idx'] . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$idx = $dat_pasien['IRJA_MCU_ID'];
$keadaan_mata = $dat_pasien['KEADAAN_MATA'];
$pem_mata_tpk_od = $dat_pasien['PEMERIKSAAN_MATA_TP_KOREKSI_OD'];
$pem_mata_tpk_os = $dat_pasien['PEMERIKSAAN_MATA_TP_KOREKSI_OS'];

$pem_mata_dgk_od = $dat_pasien['PEMERIKSAAN_MATA_DG_KOREKSI_OD'];
$pem_mata_dgk_os = $dat_pasien['PEMERIKSAAN_MATA_DG_KOREKSI_OS'];

$tes_buta_warna = $dat_pasien['TEST_BUTA_WARNA'];
$hasil_tes_buta_warna = $dat_pasien['HASIL_TES_BUTA_WARNA'];
$hasil_tes_buta_warna_total = $dat_pasien['HASIL_TES_BUTA_WARNA_TOTAL'];
$keperluan = $dat_pasien['KEPERLUAN'];
$nomor = $dat_pasien['NOMOR'];
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
			<td>Mata dalam keadaan</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="keadaan_mata" value="<?php echo $keadaan_mata; ?>" class="text_dt" style="width:500px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Tajam Pemeriksaan</td>
			<td>&nbsp;</td>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;&nbsp;&nbsp;Tanpa Kontras</td>
			<td>&nbsp;</td>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;&nbsp;&nbsp;- OD</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="pem_mata_tpk_od" value="<?php echo $pem_mata_tpk_od; ?>" class="text_dt" style="width:500px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;&nbsp;&nbsp;- OS</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="pem_mata_tpk_os" value="<?php echo $pem_mata_tpk_os; ?>" class="text_dt" style="width:500px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;&nbsp;&nbsp;Dengan Kontras</td>
			<td>&nbsp;</td>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;&nbsp;&nbsp;- OD</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="pem_mata_dgk_od" value="<?php echo $pem_mata_dgk_od; ?>" class="text_dt" style="width:500px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;&nbsp;&nbsp;- OS</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="pem_mata_dgk_os" value="<?php echo $pem_mata_dgk_os; ?>" class="text_dt" style="width:500px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Tes Buta Warna (ishihara book)</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="tes_buta_warna" value="<?php echo $tes_buta_warna; ?>" class="text_dt" style="width:500px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="radio" name="hasil_tes_buta_warna" value="1" <?php if($hasil_tes_buta_warna == '1') echo 'checked'; ?> />&nbsp;Normal</td>
			<td>&nbsp;</td>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="radio" name="hasil_tes_buta_warna" value="2" <?php if($hasil_tes_buta_warna == '2') echo 'checked'; ?> />&nbsp;Buta Warna</td>
			<td>&nbsp;</td>
			<td colspan="5"><input type="radio" name="hasil_tes_buta_warna_total" value="1" <?php if($hasil_tes_buta_warna_total == '1') echo 'checked'; ?> />&nbsp;Total&nbsp;&nbsp;&nbsp;
			<input type="radio" name="hasil_tes_buta_warna_total" value="2" <?php if($hasil_tes_buta_warna_total == '2') echo 'checked'; ?> />&nbsp;Partial</td>
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
						AND JENIS_DOKUMEN_ID = "58"
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