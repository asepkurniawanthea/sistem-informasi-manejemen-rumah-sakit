<?php
function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = str_replace('|','!',$str);
	$ret = htmlspecialchars($ret);
	return $ret;
}
	
if (isset($_POST['irja_id'])){
	
	
	if(empty($_POST['idx'])){		
			mysql_query('INSERT INTO t_irja_hiv_rujukan (IRJA_HIV_ID,ALAMAT_PENERIMA,INSTANSI_PENERIMA,TELEPON_FAX,
			PELAYANAN_LAIN,CATATAN_KHUSUS,NAMA_PETUGAS,TELEPON_PETUGAS,TGL_ASSESMENT,REGISTER) 
				VALUES ("' . $_POST['irja_id'] . '","' . replace_quote($_POST['alamat_penerima']) . '",
				"' . replace_quote($_POST['instansi_penerima']) . '","' . replace_quote($_POST['telepon']) . '",
				"' . replace_quote($_POST['pelayanan_lain']) . '","' . replace_quote($_POST['catatan_khusus']) . '",
				"' . replace_quote($_POST['nama_petugas']) . '","' . replace_quote($_POST['telepon_petugas']) . '",
				NOW(),"' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '")') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_irja_hiv_rujukan 
				SET ALAMAT_PENERIMA = "' . replace_quote($_POST['alamat_penerima']) . '",
				INSTANSI_PENERIMA = "' . replace_quote($_POST['instansi_penerima']) . '",
				TELEPON_FAX = "' . replace_quote($_POST['telepon']) . '",
				PELAYANAN_LAIN = "' . replace_quote($_POST['pelayanan_lain']) . '",
				CATATAN_KHUSUS = "' . replace_quote($_POST['catatan_khusus']) . '",
				NAMA_PETUGAS = "' . replace_quote($_POST['nama_petugas']) . '",
				TELEPON_PETUGAS = "' . replace_quote($_POST['telepon_petugas']) . '",
				TGL_ASSESMENT = NOW(),
				REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
				ST_CREATE_ERM = NULL
				WHERE IRJA_HIV_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());
		}

		?>
		<script language="JavaScript" >
			alert('Simpan Rujukan Pasien HIV Berhasil.');
			window.location = "<?php echo currentUrl(); ?>";
		</script>
		<?php 	
}
$qry_pasien = 'SELECT IRJA_HIV_ID,ALAMAT_PENERIMA,INSTANSI_PENERIMA,TELEPON_FAX,PELAYANAN_LAIN,CATATAN_KHUSUS,
			NAMA_PETUGAS,TELEPON_PETUGAS,
			DATE_FORMAT(TGL_ASSESMENT,"%d/%m/%Y") AS TGL_ASSESMENT,
			REGISTER
			FROM t_irja_hiv_rujukan
			WHERE IRJA_HIV_ID = "' . $_GET['idx'] . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$idx = $dat_pasien['IRJA_HIV_ID'];
$alamat_penerima = $dat_pasien['ALAMAT_PENERIMA'];
$instansi_penerima = $dat_pasien['INSTANSI_PENERIMA'];
$telepon = $dat_pasien['TELEPON_FAX'];
$pelayanan_lain = $dat_pasien['PELAYANAN_LAIN'];
$catatan_khusus = $dat_pasien['CATATAN_KHUSUS'];
$nama_petugas = $dat_pasien['NAMA_PETUGAS'];
$telepon_petugas = $dat_pasien['TELEPON_PETUGAS'];
?>
<form name="formperiksa" id="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="idx" id="idx" value="<?php echo $idx; ?>" />	
	<input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />	
	<table border="0" align="center" style="position:static; " width="90%">
        <tr>
			<td colspan="8">PENERIMA RUJUKAN</td>
		</tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">Nama Instansi</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><input type="text" name="instansi_penerima" value="<?php echo $instansi_penerima; ?>" class="text_dt" style="width:500px;" /></td>
		</tr>	
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Alamat</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="alamat_penerima" class="text_dt10" ><?php echo $alamat_penerima; ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Telepon/ Fax</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="telepon" value="<?php echo $telepon; ?>" class="text_dt" style="width:500px;" /></td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Pelayanan Lain</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="pelayanan_lain" class="text_dt10" ><?php echo $pelayanan_lain; ?></textarea></td>
        </tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Catatan Khusus</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="catatan_khusus" class="text_dt10" ><?php echo $catatan_khusus; ?></textarea></td>
        </tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Nama Petugas</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="nama_petugas" value="<?php echo $nama_petugas; ?>" class="text_dt" style="width:500px;" /></td>
        </tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Telepon Petugas</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="telepon_petugas" value="<?php echo $telepon_petugas; ?>" class="text_dt" style="width:500px;" /></td>
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
						AND JENIS_DOKUMEN_ID = "54"
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