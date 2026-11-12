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
			mysql_query('INSERT INTO t_irja_pemeriksaan_mcu_skd (IRJA_MCU_ID,PEMERIKSAAN_FISIK,PEMERIKSAAN_MENTAL,
			PEMERIKSAAN_RADIOLOGI,PEMERIKSAAN_LABORATORIUM,
			PEMERIKSAAN_EKG,SEHAT,TB,BB,TD,NADI,TGL_ASSESMENT,REGISTER,NOMOR,TGL_BERLAKU,
			KEPERLUAN) 
				VALUES ("' . $_POST['irja_id'] . '",
				"' . ((isset($_POST['pemeriksaan_fisik'])) ? $_POST['pemeriksaan_fisik'] : '') . '",
				"' . ((isset($_POST['pemeriksaan_mental'])) ? $_POST['pemeriksaan_mental'] : '') . '",
				"' . ((isset($_POST['pemeriksaan_radiologi'])) ? $_POST['pemeriksaan_radiologi'] : '') . '",
				"' . ((isset($_POST['pemeriksaan_laboratorium'])) ? $_POST['pemeriksaan_laboratorium'] : '') . '",
				"' . ((isset($_POST['pemeriksaan_ekg'])) ? $_POST['pemeriksaan_ekg'] : '') . '",
				"' . ((isset($_POST['sehat'])) ? $_POST['sehat'] : '') . '",
				"' . replace_quote($_POST['pm_tb']) . '",
				"' . replace_quote($_POST['pm_bb']) . '",
				"' . replace_quote($_POST['pm_td']) . '",
				"' . replace_quote($_POST['pm_nadi']) . '",
				NOW(),"' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
				"' . replace_quote($_POST['nomor']) . '",
				STR_TO_DATE("' . $_POST['tgl_berlaku'] . '","%d/%m/%Y"),
				"' . replace_quote($_POST['keperluan']) . '")') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_irja_pemeriksaan_mcu_skd 
				SET PEMERIKSAAN_FISIK = "' . ((isset($_POST['pemeriksaan_fisik'])) ? $_POST['pemeriksaan_fisik'] : '') . '", 
				PEMERIKSAAN_MENTAL = "' . ((isset($_POST['pemeriksaan_mental'])) ? $_POST['pemeriksaan_mental'] : '') . '",
				PEMERIKSAAN_RADIOLOGI = "' . ((isset($_POST['pemeriksaan_radiologi'])) ? $_POST['pemeriksaan_radiologi'] : '') . '",
				PEMERIKSAAN_LABORATORIUM = "' . ((isset($_POST['pemeriksaan_laboratorium'])) ? $_POST['pemeriksaan_laboratorium'] : '') . '",
				PEMERIKSAAN_EKG = "' . ((isset($_POST['pemeriksaan_ekg'])) ? $_POST['pemeriksaan_ekg'] : '') . '",
				SEHAT = "' . ((isset($_POST['sehat'])) ? $_POST['sehat'] : '') . '",
				TB = "' . replace_quote($_POST['pm_tb']) . '",
				BB = "' . replace_quote($_POST['pm_bb']) . '",
				TD = "' . replace_quote($_POST['pm_td']) . '",
				NADI = "' . replace_quote($_POST['pm_nadi']) . '",
				TGL_ASSESMENT = NOW(),
				REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
				ST_CREATE_ERM = NULL,
				NOMOR = "' . replace_quote($_POST['nomor']) . '",
				TGL_BERLAKU = STR_TO_DATE("' . $_POST['tgl_berlaku'] . '","%d/%m/%Y"),
				KEPERLUAN = "' . replace_quote($_POST['keperluan']) . '"
				WHERE IRJA_MCU_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());
		}
		
		?>
		<script language="JavaScript" >
			alert('Simpan Surat Keterangan Dokter Berhasil.');
			window.location = "<?php echo currentUrl(); ?>";
		</script>
		<?php 
	}else{
		$msg_info = 'Harus Oleh Dokter DPJP.';
	}	
}
$qry_pasien = 'SELECT IRJA_MCU_ID,PEMERIKSAAN_FISIK,PEMERIKSAAN_MENTAL,PEMERIKSAAN_RADIOLOGI,PEMERIKSAAN_LABORATORIUM,
			PEMERIKSAAN_EKG,SEHAT,TB,BB,TD,NADI,NOMOR,DATE_FORMAT(TGL_BERLAKU,"%d/%m/%Y") AS TGL_BERLAKU,
			KEPERLUAN
			FROM t_irja_pemeriksaan_mcu_skd
			WHERE IRJA_MCU_ID = "' . $_GET['idx'] . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$idx = $dat_pasien['IRJA_MCU_ID'];
$pemeriksaan_fisik = $dat_pasien['PEMERIKSAAN_FISIK'];
$pemeriksaan_mental = $dat_pasien['PEMERIKSAAN_MENTAL'];
$pemeriksaan_radiologi = $dat_pasien['PEMERIKSAAN_RADIOLOGI'];
$pemeriksaan_laboratorium = $dat_pasien['PEMERIKSAAN_LABORATORIUM'];
$pemeriksaan_ekg = $dat_pasien['PEMERIKSAAN_EKG'];
$sehat = $dat_pasien['SEHAT'];
$pm_tb = $dat_pasien['TB'];
$pm_bb = $dat_pasien['BB'];
$pm_td = $dat_pasien['TD'];
$pm_nadi = $dat_pasien['NADI'];
$nomor = $dat_pasien['NOMOR'];
$tgl_berlaku = $dat_pasien['TGL_BERLAKU'];
$keperluan = $dat_pasien['KEPERLUAN'];

if($idx == ''){
	$qry_pasien = 'SELECT IRJA_MCU_ID,KELUHAN,RIWAYAT_PENYAKIT,RIWAYAT_PENYAKIT_KELUARGA,PEMERIKSAAN_FISIK,
			PEMERIKSAAN_FISIK_KEPALA,PEMERIKSAAN_FISIK_THORAX,PEMERIKSAAN_FISIK_ABDOMEN,PEMERIKSAAN_FISIK_EKSTRIMITAS,
			PEMERIKSAAN_LABORATORIUM,PEMERIKSAAN_KARDIOLOGI,PEMERIKSAAN_RADIOLOGI,PEMERIKSAAN_MATA,PEMERIKSAAN_LAIN,
			RESUME,KESIMPULAN,CATATAN
			FROM t_irja_pemeriksaan_mcu
			WHERE IRJA_MCU_ID = "' . $_GET['idx'] . '"';
	$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
	$dat_pasien = mysql_fetch_assoc($get_pasien);
	$pemeriksaan_fisik = str_replace('|','"',$dat_pasien['PEMERIKSAAN_FISIK']);
	$pemeriksaan_fisik = preg_replace('/\r|\n/','\n',trim($pemeriksaan_fisik));
	$pemeriksaan_fisik = json_decode($pemeriksaan_fisik,true);
	if(isset($pemeriksaan_fisik['pm_tb'])) $pm_tb = $pemeriksaan_fisik['pm_tb'];
	if(isset($pemeriksaan_fisik['pm_bb'])) $pm_bb = $pemeriksaan_fisik['pm_bb'];
	if(isset($pemeriksaan_fisik['pm_td'])) $pm_td = $pemeriksaan_fisik['pm_td'];
	if(isset($pemeriksaan_fisik['pm_nadi'])) $pm_nadi = $pemeriksaan_fisik['pm_nadi'];
}	
?>
<form name="formedit" id="formedit" method="post" action="<?php echo currentUrl(); ?>" >
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
			<td colspan="2">Tanggal Berlaku</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="tgl_berlaku" id="tgl_3" class="text_dt" size="10" value="<?php echo $tgl_berlaku; ?>" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar11')"/></td>
		</tr>
		<tr>
            <td colspan="8">&nbsp;</td>
        </tr>
		<tr>
			<td colspan="8">PEMERIKSAAN</td>
		</tr>
		<tr>
			<td>&nbsp;</td>	
			<td>&nbsp;</td>	
			<td>&nbsp;</td>	
			<td colspan="5"><input type="checkbox" name="pemeriksaan_fisik" value="1" <?php if($pemeriksaan_fisik == '1') echo 'checked'; ?> />&nbsp;Fisik&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="pemeriksaan_mental" value="1" <?php if($pemeriksaan_mental == '1') echo 'checked'; ?> />&nbsp;Mental&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="pemeriksaan_radiologi" value="1" <?php if($pemeriksaan_radiologi == '1') echo 'checked'; ?> />&nbsp;Radiologi&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="pemeriksaan_laboratorium" value="1" <?php if($pemeriksaan_laboratorium == '1') echo 'checked'; ?> />&nbsp;Laboratorium&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="pemeriksaan_ekg" value="1" <?php if($pemeriksaan_ekg == '1') echo 'checked'; ?> />&nbsp;EKG
			</td>
		</tr>
		<tr>	
			<td>&nbsp;</td>	
			<td>Tekanan Darah</td>
			<td>:</td>
			<td width="250px"><input type="text" name="pm_td" value="<?php echo $pm_td; ?>" class="text_dt" >&nbsp;mmHg</td>
			<td width="130px">&nbsp;</td>
			<td width="95px">&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>	
			<td>&nbsp;</td>			
			<td>Nadi</td>
			<td>:</td>
			<td><input type="text" name="pm_nadi" value="<?php echo $pm_nadi; ?>" class="text_dt" >&nbsp;x/menit</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>	
			<td>&nbsp;</td>			
			<td>Tinggi Badan</td>
			<td>:</td>
			<td><input type="text" name="pm_tb" value="<?php echo $pm_tb; ?>" class="text_dt" >&nbsp;cm</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>	
			<td>&nbsp;</td>			
			<td>Berat Badan</td>
			<td>:</td>
			<td><input type="text" name="pm_bb" value="<?php echo $pm_bb; ?>" class="text_dt" >&nbsp;kg</td>
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
			<td>Dinyatakan</td>
			<td>:</td>
			<td colspan="5"><input type="radio" name="sehat" value="1" <?php if($sehat == '1') echo 'checked'; ?> />&nbsp;Sehat&nbsp;&nbsp;&nbsp;
				<input type="radio" name="sehat" value="2" <?php if($sehat == '2') echo 'checked'; ?> />&nbsp;Tidak Sehat</td>
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
						AND JENIS_DOKUMEN_ID = "56"
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