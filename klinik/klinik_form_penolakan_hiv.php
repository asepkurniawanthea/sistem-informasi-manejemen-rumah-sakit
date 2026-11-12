<?php
function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = str_replace('|','!',$str);
	$ret = htmlspecialchars($ret);
	return $ret;
}
	
if (isset($_POST['irja_id'])){
	if(empty($_POST['idx'])){		
			mysql_query('INSERT INTO t_irja_hiv_penolakan_pemeriksaan (IRJA_HIV_ID,TGL_PEMERIKSAAN,TGL_ASSESMENT,REGISTER) 
				VALUES ("' . $_POST['irja_id'] . '",
				STR_TO_DATE("' . $_POST['tgl_kontrol'] . '","%d/%m/%Y"),
				NOW(),
				"' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '")') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_irja_hiv_penolakan_pemeriksaan 
				SET TGL_PEMERIKSAAN = STR_TO_DATE("' . $_POST['tgl_kontrol'] . '","%d/%m/%Y"),
				TGL_ASSESMENT = NOW(),
				REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
				ST_CREATE_ERM = NULL
				WHERE IRJA_HIV_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());
		}

		?>
		<script language="JavaScript" >
			alert('Simpan Penolakan Test HIV Berhasil.');
			window.location = "<?php echo currentUrl(); ?>";
		</script>
		<?php 	
}
$qry_pasien = 'SELECT IRJA_HIV_ID,DATE_FORMAT(TGL_PEMERIKSAAN,"%d/%m/%Y") AS TGL_PEMERIKSAAN,TGL_ASSESMENT,REGISTER
			FROM t_irja_hiv_penolakan_pemeriksaan
			WHERE IRJA_HIV_ID = "' . $_GET['idx'] . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$idx = $dat_pasien['IRJA_HIV_ID'];
$tgl_kontrol = $dat_pasien['TGL_PEMERIKSAAN'];
?>
<form name="formedit" id="formedit" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="idx" id="idx" value="<?php echo $idx; ?>" />	
	<input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />	
	<table border="0" align="center" style="position:static; " width="30%">
		<tr>
			<td valign="top" colspan="2">Tanggal Pemeriksaan</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="tgl_kontrol" id="tgl_3" class="text_dt" size="10" value="<?php echo $tgl_kontrol; ?>" readonly="readonly" onblur="false_kan();" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar11')"/></td>
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
						AND JENIS_DOKUMEN_ID = "51"
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