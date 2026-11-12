<style>
html {
	background:url(image/bg_pattern1.jpg);

}
</style>
<?php 
function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = str_replace('|','!',$str);
	$ret = htmlspecialchars($ret);
	return $ret;
}

if (isset($_POST['perencanaan_id'])){
	if($jns_order == ''){
		if(empty($_POST['perencanaan_id'])){
			mysql_query('INSERT INTO t_irja_post_hd_dan_perencanaan_pulang (
				IRJA_ID,BB,UFG,KTV,OBAT,TINDAKAN_HD_BERIKUTNYA,RENCANA_KONSULTASI,
				RENCANA_PEMERIKSAAN_PENUNJANG,RENCANA_LAIN)
				VALUES("' . $_POST['idx'] . '",
				"' . replace_quote($_POST['bb']) . '",
				"' . replace_quote($_POST['ufg']) . '",
				"' . replace_quote($_POST['ktv']) . '",
				"' . replace_quote($_POST['obat']) . '",
				"' . replace_quote($_POST['hd_berikut']) . '",
				"' . replace_quote($_POST['konsultasi']) . '",
				"' . replace_quote($_POST['penunjang']) . '",
				"' . replace_quote($_POST['rencana_lain']) . '")') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_irja_post_hd_dan_perencanaan_pulang 
				SET BB = "' . replace_quote($_POST['bb']) . '",
				UFG = "' . replace_quote($_POST['ufg']) . '",
				KTV = "' . replace_quote($_POST['ktv']) . '", 
				OBAT = "' . replace_quote($_POST['obat']) . '",
				TINDAKAN_HD_BERIKUTNYA = "' . replace_quote($_POST['hd_berikut']) . '",
				RENCANA_KONSULTASI = "' . replace_quote($_POST['konsultasi']) . '",
				RENCANA_PEMERIKSAAN_PENUNJANG = "' . replace_quote($_POST['penunjang']) . '",
				RENCANA_LAIN = "' . replace_quote($_POST['rencana_lain']) . '"
				WHERE IRJA_ID = "' . $_POST['perencanaan_id'] . '"') or die(mysql_error());	
		}	

		mysql_query('UPDATE t_irja_pemantauan_intradialitik SET ST_CREATE_ERM = NULL 
			WHERE IRJA_ID = "' . $_POST['idx'] . '"') or die(mysql_error());	
	}else{
		if(empty($_POST['perencanaan_id'])){
			mysql_query('INSERT INTO t_hemodialisa_post_hd_dan_perencanaan_pulang (
				HEMODIALISA_ID,BB,UFG,KTV,OBAT,TINDAKAN_HD_BERIKUTNYA,RENCANA_KONSULTASI,
				RENCANA_PEMERIKSAAN_PENUNJANG,RENCANA_LAIN)
				VALUES("' . $_POST['idx'] . '",
				"' . replace_quote($_POST['bb']) . '",
				"' . replace_quote($_POST['ufg']) . '",
				"' . replace_quote($_POST['ktv']) . '",
				"' . replace_quote($_POST['obat']) . '",
				"' . replace_quote($_POST['hd_berikut']) . '",
				"' . replace_quote($_POST['konsultasi']) . '",
				"' . replace_quote($_POST['penunjang']) . '",
				"' . replace_quote($_POST['rencana_lain']) . '")') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_hemodialisa_post_hd_dan_perencanaan_pulang 
				SET BB = "' . replace_quote($_POST['bb']) . '",
				UFG = "' . replace_quote($_POST['ufg']) . '",
				KTV = "' . replace_quote($_POST['ktv']) . '", 
				OBAT = "' . replace_quote($_POST['obat']) . '",
				TINDAKAN_HD_BERIKUTNYA = "' . replace_quote($_POST['hd_berikut']) . '",
				RENCANA_KONSULTASI = "' . replace_quote($_POST['konsultasi']) . '",
				RENCANA_PEMERIKSAAN_PENUNJANG = "' . replace_quote($_POST['penunjang']) . '",
				RENCANA_LAIN = "' . replace_quote($_POST['rencana_lain']) . '"
				WHERE HEMODIALISA_ID = "' . $_POST['perencanaan_id'] . '"') or die(mysql_error());	
		}	
		
		mysql_query('UPDATE t_hemodialisa_pemantauan_intradialitik SET ST_CREATE_ERM = NULL 
			WHERE HEMODIALISA_ID = "' . $_POST['idx'] . '"') or die(mysql_error());	
	}
	
	/*
	include('lib/vendor/autoload.php');
	include('lib/html2openxml/HTMLtoOpenXML.php');
	include('edoc_rekammedik/new/erm_create_pemantauan_intradialitik.php');
	erm_pemantauan_intradialitik($_POST['idx'],$jns_order,$_POST['idxord']);
	*/
	?>
	<script language="JavaScript" >
        alert('Simpan Data Post HD & Perencanaan Pulang Berhasil.');
		window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=pshd&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $jns_order; ?>";
	</script>	
<?php } 

if($jns_order == ''){
	$sql_posthd = 'SELECT IRJA_ID AS HEMODIALISA_ID,BB,UFG,KTV,OBAT,TINDAKAN_HD_BERIKUTNYA,RENCANA_KONSULTASI,RENCANA_PEMERIKSAAN_PENUNJANG,RENCANA_LAIN
		FROM t_irja_post_hd_dan_perencanaan_pulang
		WHERE IRJA_ID = "' . $idx . '"';
}else{
	$sql_posthd = 'SELECT HEMODIALISA_ID,BB,UFG,KTV,OBAT,TINDAKAN_HD_BERIKUTNYA,RENCANA_KONSULTASI,RENCANA_PEMERIKSAAN_PENUNJANG,RENCANA_LAIN
		FROM t_hemodialisa_post_hd_dan_perencanaan_pulang
		WHERE HEMODIALISA_ID = "' . $idx . '"';
}	
$get_posthd = mysql_query($sql_posthd) or die(mysql_error());
$dat_posthd = mysql_fetch_assoc($get_posthd);
$perencanaan_id = $dat_posthd['HEMODIALISA_ID'];
$bb = $dat_posthd['BB'];
$ufg = $dat_posthd['UFG'];
$ktv = $dat_posthd['KTV'];
$obat = $dat_posthd['OBAT'];	
$hd_berikut = $dat_posthd['TINDAKAN_HD_BERIKUTNYA'];	
$konsultasi = $dat_posthd['RENCANA_KONSULTASI'];	
$penunjang = $dat_posthd['RENCANA_PEMERIKSAAN_PENUNJANG'];	
$rencana_lain = $dat_posthd['RENCANA_LAIN'];	
?>
<form name="formedit" id="formedit" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="idx" id="idx" value="<?php echo $idx; ?>" />
	<input type="hidden" name="perencanaan_id" id="perencanaan_id" value="<?php echo $perencanaan_id; ?>" />
	<input type="hidden" name="idxord" id="idxord" value="<?php echo $idxord; ?>" />
	<input type="hidden" name="jns_perawatan" id="jns_perawatan" value="<?php echo $jns_perawatan; ?>" />
	<table border="0" width="90%">
	<tr>
    <td>Post HD</td>
	<td valign="top">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
   </tr>
   <tr>
    <td>&nbsp;</td>
	<td valign="top">BB Post HD</td>
    <td colspan="2"><input type="text" name="bb" id="bb" value="<?php echo $bb; ?>" class="text_dt" style="width:500px;" ></td>
   </tr>
  <tr>
    <td>&nbsp;</td>
	<td valign="top">UFG</td>
    <td colspan="2"><input type="text" name="ufg" id="ufg" value="<?php echo $ufg; ?>" class="text_dt" style="width:500px;" ></td>
   </tr>
   <tr>
    <td>&nbsp;</td>
	<td valign="top">Kt/v</td>
    <td colspan="2"><input type="text" name="ktv" id="ktv" value="<?php echo $ktv; ?>" class="text_dt" style="width:500px;" ></td>
   </tr>
    <tr>
    <td>&nbsp;</td>
	<td valign="top">Obat</td>
    <td colspan="2"><textarea name="obat" id="obat" rows="3" class="text_dt2" ><?php echo $obat; ?></textarea></td>
  </tr>
   <tr>
    <td>&nbsp;</td>
	<td valign="top">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Perencanaan Pulang</td>
	<td valign="top">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
   </tr>
   <tr>
    <td>&nbsp;</td>
	<td valign="top">Hari dan Tanggal tindakan HD berikutnya</td>
    <td colspan="2"><textarea name="hd_berikut" id="hd_berikut" rows="3" class="text_dt2" ><?php echo $hd_berikut; ?></textarea></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
	<td valign="top">Rencana Konsultasi</td>
    <td colspan="2"><textarea name="konsultasi" id="konsultasi" rows="3" class="text_dt2" ><?php echo $konsultasi; ?></textarea></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
	<td valign="top">Rencana Pemeriksaan Penunjang</td>
    <td colspan="2"><textarea name="penunjang" id="penunjang" rows="3" class="text_dt2" ><?php echo $penunjang; ?></textarea></td>
  </tr>
   <tr>
    <td>&nbsp;</td>
	<td valign="top">Lain-lain</td>
    <td colspan="2"><textarea name="rencana_lain" id="rencana_lain" rows="3" class="text_dt2" ><?php echo $rencana_lain; ?></textarea></td>
  </tr>
   <tr>
    <td>&nbsp;</td>
	<td valign="top">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php if($hemodialisa_final == '' and (isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])
				or isPerawat($_SESSION['SES_SIMRS_TIPE_PEGAWAI']))){ ?>
				<input type="button" name="simpan" value="simpan" class="myButton1" onclick="simpan_pemantauan();" />
		<?php if(!empty($pemantauan_id)){ 
				$sql_view_rm = 'SELECT FILE_ID FROM t_rm_dokumen_file
						WHERE JNS_PERAWATAN = "' . $jns_perawatan . '"
						AND NOMR = "' . $nomr . '"
						AND RAWAT_ID = "' . $idxord . '"
						' . (($jns_order != '') ? 'AND ORDER_PENUNJANG = "' . $idx . '"' : 'AND ORDER_PENUNJANG IS NULL') . '
						AND JENIS_DOKUMEN_ID = "33"
						ORDER BY FILE_ID DESC LIMIT 1';
				$get_view_rm = mysql_query($sql_view_rm) or die(mysql_error());		
				$dat_view_rm = mysql_fetch_assoc($get_view_rm);
			?>
				<input type="button" value="lihat" class="myButton1" onclick="window.open('index.php?flex=<?php echo $dat_view_rm['FILE_ID']; ?>', '_blank');" />			
				<?php } } ?>
	</td>
    <td>&nbsp;</td>
  </tr>
  </table>
</form>
<script>
function simpan_pemantauan(){
	_haschange = false;
	$('#formedit').submit();
}	
</script>