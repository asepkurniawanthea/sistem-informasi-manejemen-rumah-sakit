<?php
function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = str_replace('|','!',$str);
	$ret = htmlspecialchars($ret);
	return $ret;
}
	
if (isset($_POST['irja_id'])){
	if(empty($_POST['idx'])){		
			mysql_query('INSERT INTO t_irja_keterangan_sakit (IRJA_ID,CUTI_MULAI,CUTI_SAMPAI,
				SEBAB_CUTI,TGL_ASSESMENT,REGISTER,NOMOR) 
				VALUES ("' . $_POST['irja_id'] . '",STR_TO_DATE("' . $_POST['cuti_mulai'] . '","%d/%m/%Y"),
				STR_TO_DATE("' . $_POST['cuti_sampai'] . '","%d/%m/%Y"),
				"' . ((isset($_POST['sebab_cuti'])) ? $_POST['sebab_cuti'] : '') . '",
				NOW(),"' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
				"' . replace_quote($_POST['nomor']) . '")') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_irja_keterangan_sakit 
				SET CUTI_MULAI = STR_TO_DATE("' . $_POST['cuti_mulai'] . '","%d/%m/%Y"),
				CUTI_SAMPAI = STR_TO_DATE("' . $_POST['cuti_sampai'] . '","%d/%m/%Y"),
				SEBAB_CUTI = "' . ((isset($_POST['sebab_cuti'])) ? $_POST['sebab_cuti'] : '') . '",
				TGL_ASSESMENT = NOW(),
				REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
				ST_CREATE_ERM = NULL,
				NOMOR = "' . replace_quote($_POST['nomor']) . '"
				WHERE IRJA_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());
		}

		?>
		<script language="JavaScript" >
			alert('Simpan Surat Keterangan Sakit Berhasil.');
			window.location = "<?php echo currentUrl(); ?>";
		</script>
		<?php 	
}
$qry_pasien = 'SELECT IRJA_ID,
			DATE_FORMAT(CUTI_MULAI,"%d/%m/%Y") AS CUTI_MULAI,
			DATE_FORMAT(CUTI_SAMPAI,"%d/%m/%Y") AS CUTI_SAMPAI,
			SEBAB_CUTI,DATEDIFF(CUTI_SAMPAI,CUTI_MULAI) + 1 AS HARI,
			NOMOR
			FROM t_irja_keterangan_sakit
			WHERE IRJA_ID = "' . $_GET['idx'] . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$idx = $dat_pasien['IRJA_ID'];
$cuti_mulai = $dat_pasien['CUTI_MULAI'];
$cuti_sampai = $dat_pasien['CUTI_SAMPAI'];
$sebab_cuti = $dat_pasien['SEBAB_CUTI'];
$hari = $dat_pasien['HARI'];
$nomor = $dat_pasien['NOMOR'];
?>
<form name="formedit" id="formedit" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="idx" id="idx" value="<?php echo $idx; ?>" />	
	<input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />	
	<table border="0" align="center" style="position:static; " width="90%">
		<tr>
			<td colspan="2">Nomor</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="nomor" value="<?php echo $nomor; ?>" class="text_dt" style="width:200px;" ></td>
		</tr>
		<tr>
            <td colspan="8">&nbsp;</td>
        </tr>
		<tr>
			<td valign="top" colspan="2">Tanggal Mulai Cuti</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="cuti_mulai" id="tgl_1" class="text_dt" size="10" value="<?php echo $cuti_mulai; ?>" readonly="readonly" onblur="false_kan();" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar8')"/></td>
		</tr>
		<tr>
			<td valign="top" colspan="2">Sampai Dengan</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="cuti_sampai" id="tgl_2" class="text_dt" size="10" value="<?php echo $cuti_sampai; ?>" readonly="readonly" onblur="false_kan();" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar9')"/></td>
		</tr>
		<tr>
			<td valign="top" colspan="2">Hari</td>
			<td valign="top">:</td>
			<td colspan="5"><?php echo $hari; ?></td>
		</tr>
		<tr>
			<td valign="top" colspan="2">Sebab Cuti</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="radio" name="sebab_cuti" value="1" <?php if($sebab_cuti == '1') echo 'checked'; ?> />&nbsp;Sakit&nbsp;&nbsp;&nbsp;
			<input type="radio" name="sebab_cuti" value="2" <?php if($sebab_cuti == '2') echo 'checked'; ?> />&nbsp;Melahirkan</td>
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
						AND JENIS_DOKUMEN_ID = "60"
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