<?php
function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = str_replace('|','!',$str);
	$ret = htmlspecialchars($ret);
	return $ret;
}
	
if (isset($_POST['irja_id'])){
	
	if(empty($_POST['idx'])){		
			mysql_query('INSERT INTO t_irja_hiv_permintaan_lab (IRJA_HIV_ID,SETUJU_PERIKSA,RESIKO_TERTULAR,GEJALA_AIDS,KOMENTAR_TAMBAHAN,REGEAN_1,
			REGEAN_2,REGEAN_3,REGEAN_4,REGEAN_5,HASIL_REGEAN_1,HASIL_REGEAN_2,HASIL_REGEAN_3,HASIL_REGEAN_4,
			HASIL_REGEAN_5,HASIL_AKHIR,KODE_PASIEN,TGL_PASIEN,TGL_ASSESMENT,REGISTER) 
				VALUES ("' . $_POST['irja_id'] . '",
				"' . ((isset($_POST['pers_pemeriksaan'])) ? $_POST['pers_pemeriksaan'] : '') . '",
				"' . ((isset($_POST['resiko_tertular'])) ? $_POST['resiko_tertular'] : '') . '",
				"' . ((isset($_POST['gejala_aids'])) ? $_POST['gejala_aids'] : '') . '",
				"' . replace_quote($_POST['komentar_tambahan']) . '",
				"' . replace_quote($_POST['reagen_1']) . '",
				"' . replace_quote($_POST['reagen_2']) . '",
				"' . replace_quote($_POST['reagen_3']) . '",
				"' . replace_quote($_POST['reagen_4']) . '",
				"' . replace_quote($_POST['reagen_5']) . '",
				"' . ((isset($_POST['hasil_reagen_1'])) ? $_POST['hasil_reagen_1'] : '') . '",
				"' . ((isset($_POST['hasil_reagen_2'])) ? $_POST['hasil_reagen_2'] : '') . '",
				"' . ((isset($_POST['hasil_reagen_3'])) ? $_POST['hasil_reagen_3'] : '') . '",
				"' . ((isset($_POST['hasil_reagen_4'])) ? $_POST['hasil_reagen_4'] : '') . '",
				"' . ((isset($_POST['hasil_reagen_5'])) ? $_POST['hasil_reagen_5'] : '') . '",
				"' . replace_quote($_POST['hasil_akhir']) . '",
				"' . replace_quote($_POST['kode_pasien']) . '",
				STR_TO_DATE("' . $_POST['tgl_pasien'] . '","%d/%m/%Y"),
				NOW(),"' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '")') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_irja_hiv_permintaan_lab 
				SET SETUJU_PERIKSA = "' . ((isset($_POST['pers_pemeriksaan'])) ? $_POST['pers_pemeriksaan'] : '') . '",
				RESIKO_TERTULAR = "' . ((isset($_POST['resiko_tertular'])) ? $_POST['resiko_tertular'] : '') . '",
				GEJALA_AIDS = "' . ((isset($_POST['gejala_aids'])) ? $_POST['gejala_aids'] : '') . '",
				KOMENTAR_TAMBAHAN = "' . replace_quote($_POST['komentar_tambahan']) . '",
				REGEAN_1 = "' . replace_quote($_POST['reagen_1']) . '",
				REGEAN_2 = "' . replace_quote($_POST['reagen_2']) . '",
				REGEAN_3 = "' . replace_quote($_POST['reagen_3']) . '",
				REGEAN_4 = "' . replace_quote($_POST['reagen_4']) . '",
				REGEAN_5 = "' . replace_quote($_POST['reagen_5']) . '",
				HASIL_REGEAN_1 = "' . ((isset($_POST['hasil_reagen_1'])) ? $_POST['hasil_reagen_1'] : '') . '",
				HASIL_REGEAN_2 = "' . ((isset($_POST['hasil_reagen_2'])) ? $_POST['hasil_reagen_2'] : '') . '",
				HASIL_REGEAN_3 = "' . ((isset($_POST['hasil_reagen_3'])) ? $_POST['hasil_reagen_3'] : '') . '",
				HASIL_REGEAN_4 = "' . ((isset($_POST['hasil_reagen_4'])) ? $_POST['hasil_reagen_4'] : '') . '",
				HASIL_REGEAN_5 = "' . ((isset($_POST['hasil_reagen_5'])) ? $_POST['hasil_reagen_5'] : '') . '",
				HASIL_AKHIR = "' . replace_quote($_POST['hasil_akhir']) . '",
				KODE_PASIEN = "' . replace_quote($_POST['kode_pasien']) . '",
				TGL_PASIEN = STR_TO_DATE("' . $_POST['tgl_pasien'] . '","%d/%m/%Y"),
				TGL_ASSESMENT = NOW(),
				REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
				ST_CREATE_ERM = NULL
				WHERE IRJA_HIV_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());
		}

		?>
		<script language="JavaScript" >
			alert('Simpan Permintaan Pemeriksaan HIV Berhasil.');
			window.location = "<?php echo currentUrl(); ?>";
		</script>
		<?php 	
}
$qry_pasien = 'SELECT IRJA_HIV_ID,SETUJU_PERIKSA,RESIKO_TERTULAR,GEJALA_AIDS,KOMENTAR_TAMBAHAN,REGEAN_1,
			REGEAN_2,REGEAN_3,REGEAN_4,REGEAN_5,HASIL_REGEAN_1,HASIL_REGEAN_2,HASIL_REGEAN_3,HASIL_REGEAN_4,
			HASIL_REGEAN_5,HASIL_AKHIR,KODE_PASIEN,DATE_FORMAT(TGL_PASIEN,"%d/%m/%Y") AS TGL_PASIEN,
			TGL_ASSESMENT,REGISTER
			FROM t_irja_hiv_permintaan_lab
			WHERE IRJA_HIV_ID = "' . $_GET['idx'] . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$idx = $dat_pasien['IRJA_HIV_ID'];
$pers_pemeriksaan = $dat_pasien['SETUJU_PERIKSA'];
$resiko_tertular = $dat_pasien['RESIKO_TERTULAR'];
$gejala_aids = $dat_pasien['GEJALA_AIDS'];
$komentar_tambahan = $dat_pasien['KOMENTAR_TAMBAHAN'];
$reagen_1 = $dat_pasien['REGEAN_1'];
$reagen_2 = $dat_pasien['REGEAN_2'];
$reagen_3 = $dat_pasien['REGEAN_3'];
$reagen_4 = $dat_pasien['REGEAN_4'];
$reagen_5 = $dat_pasien['REGEAN_5'];
$hasil_reagen_1 = $dat_pasien['HASIL_REGEAN_1'];
$hasil_reagen_2 = $dat_pasien['HASIL_REGEAN_2'];
$hasil_reagen_3 = $dat_pasien['HASIL_REGEAN_3'];
$hasil_reagen_4 = $dat_pasien['HASIL_REGEAN_4'];
$hasil_reagen_5 = $dat_pasien['HASIL_REGEAN_5'];
$hasil_akhir = $dat_pasien['HASIL_AKHIR'];
$kode_pasien = $dat_pasien['KODE_PASIEN'];
$tgl_pasien = $dat_pasien['TGL_PASIEN'];
$tgl_assesment = $dat_pasien['TGL_ASSESMENT'];
?>
<form name="formedit" id="formedit" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="idx" id="idx" value="<?php echo $idx; ?>" />	
	<input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />	
	<table border="0" align="center" style="position:static; " width="90%">
        <tr>
			<td colspan="8">Catatan Medik Pasien</td>
		</tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">Kode Pasien</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><input type="text" name="kode_pasien" value="<?php echo $kode_pasien; ?>" class="text_dt"/></td>
		</tr>	
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Tanggal</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="tgl_pasien" id="tgl_3" class="text_dt" size="10" value="<?php echo $tgl_pasien; ?>" readonly="readonly" onblur="false_kan();" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar11')"/></td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Pasien sudah menandatangani Persetujuan Pemeriksaan</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="radio" name="pers_pemeriksaan" value="1" <?php if($pers_pemeriksaan == '1') echo 'checked'; ?> />&nbsp;Ya&nbsp;&nbsp;&nbsp;
					<input type="radio" name="pers_pemeriksaan" value="2" <?php if($pers_pemeriksaan == '2') echo 'checked'; ?> />&nbsp;Tidak</td>
        </tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Pasien memiliki resiko tertular HIV</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="radio" name="resiko_tertular" value="1" <?php if($resiko_tertular == '1') echo 'checked'; ?> />&nbsp;Ya&nbsp;&nbsp;&nbsp;
					<input type="radio" name="resiko_tertular" value="2" <?php if($resiko_tertular == '2') echo 'checked'; ?> />&nbsp;Tidak</td>
        </tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Pasien menunjukan gejala AIDS</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="radio" name="gejala_aids" value="1" <?php if($gejala_aids == '1') echo 'checked'; ?> />&nbsp;Ya&nbsp;&nbsp;&nbsp;
					<input type="radio" name="gejala_aids" value="2" <?php if($gejala_aids == '2') echo 'checked'; ?> />&nbsp;Tidak</td>
        </tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Komentar Tambahan</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="komentar_tambahan" class="text_dt10" ><?php echo $komentar_tambahan; ?></textarea></td>
        </tr>
		<tr>
			<td colspan="8">Laporan Laboratorium</td>
		</tr>
		<tr>
            <td valign="top" colspan="2">&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td colspan="4">Nama Reagensia</td>
			<td valign="top">Hasil Pemeriksaan</td>
		</tr>
		<tr>
			<td valign="middle" colspan="3" align="right">1.</td>
			<td colspan="4"><input type="text" name="reagen_1" id="reagen_1" value="<?php echo $reagen_1; ?>" class="text_dt" style="width:450px;" ></td>
			<td><input type="radio" name="hasil_reagen_1" value="1" <?php if($hasil_reagen_1 == '1') echo 'checked'; ?> />&nbsp;Non Reaktif&nbsp;&nbsp;&nbsp;
					<input type="radio" name="hasil_reagen_1" value="2" <?php if($hasil_reagen_1 == '2') echo 'checked'; ?> />&nbsp;Reaktif</td>
		</tr>
		<tr>
			<td valign="middle" colspan="3" align="right">2.</td>
			<td colspan="4"><input type="text" name="reagen_2" id="reagen_2" value="<?php echo $reagen_2; ?>" class="text_dt" style="width:450px;" ></td>
			<td><input type="radio" name="hasil_reagen_2" value="1" <?php if($hasil_reagen_2 == '1') echo 'checked'; ?> />&nbsp;Non Reaktif&nbsp;&nbsp;&nbsp;
					<input type="radio" name="hasil_reagen_2" value="2" <?php if($hasil_reagen_2 == '2') echo 'checked'; ?> />&nbsp;Reaktif</td>
		</tr>
		<tr>
			<td valign="middle" colspan="3" align="right">3.</td>
			<td colspan="4"><input type="text" name="reagen_3" id="reagen_3" value="<?php echo $reagen_3; ?>" class="text_dt" style="width:450px;" ></td>
			<td><input type="radio" name="hasil_reagen_3" value="1" <?php if($hasil_reagen_3 == '1') echo 'checked'; ?> />&nbsp;Non Reaktif&nbsp;&nbsp;&nbsp;
					<input type="radio" name="hasil_reagen_3" value="2" <?php if($hasil_reagen_3 == '2') echo 'checked'; ?> />&nbsp;Reaktif</td>
		</tr>
		<tr>
			<td valign="middle" colspan="3" align="right">4.</td>
			<td colspan="4"><input type="text" name="reagen_4" id="reagen_4" value="<?php echo $reagen_4; ?>" class="text_dt" style="width:450px;" ></td>
			<td><input type="radio" name="hasil_reagen_4" value="1" <?php if($hasil_reagen_4 == '1') echo 'checked'; ?> />&nbsp;Non Reaktif&nbsp;&nbsp;&nbsp;
					<input type="radio" name="hasil_reagen_4" value="2" <?php if($hasil_reagen_4 == '2') echo 'checked'; ?> />&nbsp;Reaktif</td>
		</tr>
		<tr>
			<td valign="middle" colspan="3" align="right">5.</td>
			<td colspan="4"><input type="text" name="reagen_5" id="reagen_5" value="<?php echo $reagen_5; ?>" class="text_dt" style="width:450px;" ></td>
			<td><input type="radio" name="hasil_reagen_5" value="1" <?php if($hasil_reagen_5 == '1') echo 'checked'; ?> />&nbsp;Non Reaktif&nbsp;&nbsp;&nbsp;
					<input type="radio" name="hasil_reagen_5" value="2" <?php if($hasil_reagen_5 == '2') echo 'checked'; ?> />&nbsp;Reaktif</td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Hasil Akhir</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="radio" name="hasil_akhir" value="1" <?php if($hasil_akhir == '1') echo 'checked'; ?> />&nbsp;Non Reaktif&nbsp;&nbsp;&nbsp;
					<input type="radio" name="hasil_akhir" value="2" <?php if($hasil_akhir == '2') echo 'checked'; ?> />&nbsp;Reaktif&nbsp;&nbsp;&nbsp;
					<input type="radio" name="hasil_akhir" value="3" <?php if($hasil_akhir == '3') echo 'checked'; ?> />&nbsp;Indeterminate&nbsp;&nbsp;&nbsp;
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
						AND JENIS_DOKUMEN_ID = "52"
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