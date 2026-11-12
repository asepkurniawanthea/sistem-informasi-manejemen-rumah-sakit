<style>
html {
	background:url(image/bg_pattern1.jpg);

}
</style>
<?php
$pegawai_id = $_GET['pelaksana'];
$irja_id = $_GET['idx'];
$tarif_id = $_GET['idt'];
$unit_id = $_GET['unit'];
$jns_order = $_GET['ord'];
$idxord = $_GET['idxord'];
$deskripsi = '';
if($jns_order == ''){
	$sql_tindakan = 'SELECT HASIL_DIAGNOSA FROM t_irja_tarif
		WHERE IRJA_TARIF_ID = "' . $tarif_id . '"';
}else{
	$sql_tindakan = 'SELECT HASIL_DIAGNOSA FROM t_hemodialisa_tarif
		WHERE HEMODIALISA_TARIF_ID = "' . $tarif_id . '"';
}		
$get_tindakan = mysql_query($sql_tindakan) or die(mysql_error());	
$dat_tindakan = mysql_fetch_assoc($get_tindakan);
$deskripsi = $dat_tindakan['HASIL_DIAGNOSA'];

if (isset($_POST['irja_id'])) {
	$pegawai_id = $_POST['pegawai_id'];
	$deskripsi = $_POST['deskripsi'];
	
    if(empty($jns_order)){
		mysql_query('UPDATE t_irja_tarif SET PEGAWAI_ID = "' . $pegawai_id . '",
					HASIL_DIAGNOSA = "' . $deskripsi . '"	
					WHERE IRJA_TARIF_ID = "' . $tarif_id . '"') or die(mysql_error());				
	}else{
		mysql_query('UPDATE t_hemodialisa_tarif SET PEGAWAI_ID = "' . $pegawai_id . '",
					HASIL_DIAGNOSA = "' . $deskripsi . '"	
					WHERE HEMODIALISA_TARIF_ID = "' . $tarif_id . '"') or die(mysql_error());					
	}

	if(trim($deskripsi) != ''){
		
		if(empty($jns_order)){
			mysql_query('UPDATE t_irja_tarif SET ST_CREATE_ERM = NULL	
				WHERE IRJA_TARIF_ID = "' . $tarif_id . '"') or die(mysql_error());	
		}else{
			mysql_query('UPDATE t_hemodialisa_tarif SET ST_CREATE_ERM = NULL	
				WHERE HEMODIALISA_TARIF_ID = "' . $tarif_id . '"') or die(mysql_error());
		}		
		/*
		include('lib/vendor/autoload.php');
		include('lib/html2openxml/HTMLtoOpenXML.php');
		include('edoc_rekammedik/new/erm_create_tindakan_hemodialisa.php');
		erm_tindakan_hemodialisa($irja_id,$tarif_id,$jns_order,$idxord);	
		*/
		
	}else{
		$jns_perawatan = '1';
		if($jns_order == 'IRN') $jns_perawatan = '2';
		mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE RAWAT_ID = "' . $idxord . '"
				AND JNS_PERAWATAN = "' . $jns_perawatan . '"
				AND JENIS_DOKUMEN_ID = "38"
				' . (($jns_order != '') ? 'AND ORDER_PENUNJANG = "' . $idx . '-' . $tarif_id . '"' : 
				'AND ORDER_PENUNJANG = "' . $tarif_id . '"')) or die(mysql_error());
	}				
	?>
	<script language="JavaScript" >
		opener.location.reload();
		window.close();
    </script>
	<?php
}
?>
<body>


<div class="div_menu" style=" height:auto; position:relative; padding:0px; padding-top:3px; padding-bottom:3px; border:1px solid #999; border-radius:5px; margin:5px; margin-top:7px; background-color:#C8EFAD;">
<form name="formedit" action="<?php echo currentURL(); ?>" method="post" >
    <table border="0" width="95%" cellpadding="0" cellspacing="0" align="center">
        <tr><td colspan="2">&nbsp;</td></tr>						
        <tr>
            <td>Pelaksana Tindakan</td>
			<td>
			<select name="pegawai_id" class="text_dt" style="width:250px" >
			<?php echo getUserRawatJalan($pegawai_id, $_SESSION['SES_SIMRS_UNIT_ID'], $_SESSION['SES_SIMRS_MODUL_ID']); ?>
			</select></td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
            <td>Hasil Pemeriksaan</td>
			<td>
				<textarea name="deskripsi" class="text_dt" style="width:600px;height:400px;"><?php echo $deskripsi; ?></textarea>
			</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td colspan="2" align="right"><input type="submit" value="simpan" class="myButton1" />&nbsp;
                <a href="#" onclick="window.close();" /><input type="button" name="selesai" value="tutup" class="myButton1" /></a></td>
	</tr>
	
	</table>
    <input type="hidden" name="irja_id" value="<?php echo $irja_id; ?>" />
	<input type="hidden" name="tarif_id" value="<?php echo $tarif_id; ?>" />
</form>
</div>
</body>