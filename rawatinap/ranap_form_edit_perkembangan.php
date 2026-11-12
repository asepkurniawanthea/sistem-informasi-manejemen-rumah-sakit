<style>
html {
	background:url(image/bg_pattern1.jpg);

}
</style>
<?php
if (isset($_POST['irna_perkembangan_id'])) {
    include('rawatinap/ranap_save_edit_add_perkembangan.php');
}

$idx=$_GET['idx'];
$idc=$_GET['idc'];
$sql_cek_no_ranap1 = 'SELECT DATE_FORMAT(t_irna_perkembangan.TANGGAL_PERIKSA,"%d/%m%/%Y") AS TANGGAL_PERIKSA,
					DATE_FORMAT(t_irna_perkembangan.TANGGAL_PERIKSA,"%H") AS JAM,
					DATE_FORMAT(t_irna_perkembangan.TANGGAL_PERIKSA,"%i") AS MENIT,
					t_irna_perkembangan.CATATAN,t_irna_perkembangan.PEGAWAI_ID
					FROM t_irna_perkembangan
					WHERE IRNA_ID = "' . $idx . '" AND IRNA_PERKEMBANGAN_ID="' .$idc. '"';
$get_cek_no_ranap1 = mysql_query($sql_cek_no_ranap1) or die(mysql_error());
$dat_cek_no_ranap1 = mysql_fetch_array($get_cek_no_ranap1);
?>
<body>
<div class="div_menu" style=" height:auto; position:relative; padding:0px; padding-top:3px; padding-bottom:3px; border:1px solid #999; border-radius:5px; margin:5px; margin-top:7px; background-color:#C8EFAD;">
<form name="formedit" action="<?php echo currentURL(); ?>" method="post" >
    <table border="0" width="95%" cellpadding="0" cellspacing="0" align="center">
        <tr><td colspan="2">&nbsp;</td></tr>						
		<tr>
			<td width="100px;">Tanggal</td>
            <td>
			<input type="text" name="tgl" id="tgl_1" class="text_dt" size="10" value="<?php echo $dat_cek_no_ranap1['TANGGAL_PERIKSA']; ?>" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar11')"/>
			<select name="jam" id="jam" style="width:50px;" class="text_dt" >
			<?php echo getJam($dat_cek_no_ranap1['JAM']); ?>
			</select>
			<select name="menit" id="menit" style="width:50px;" class="text_dt" >
			<?php echo getMenit($dat_cek_no_ranap1['MENIT']); ?>
			</select>
			</td>
		</tr>
        <tr>
			<td>Catatan</td>
            <td><textarea name="catatan" id="catatan" class="text_dt3" /><?php echo $dat_cek_no_ranap1['CATATAN']; ?></textarea></td>
		</tr>
		<tr>
			<td>Petugas</td>
            <td><select name="pegawai_id" class="text_dt" >
			<option value="" > -- </option>
			<?php echo getPelaksanaRanap($dat_cek_no_ranap1['PEGAWAI_ID'], $_SESSION['SES_SIMRS_UNIT_ID']); ?>
			</select></td>
		</tr>	
		<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td colspan="2" align="right"><input type="submit" value="simpan" class="myButton1" />&nbsp;
                <a href="#" onclick="window.close();" /><input type="button" name="selesai" value="batal" class="myButton1" /></a></td>
	</tr>
	</table>
    <input type="hidden" name="irna_perkembangan_id" value="<?php echo $_REQUEST['idc']; ?>" />
	<input type="hidden" name="irna_id" value="<?php echo $_REQUEST['idx']; ?>" />
</form>
<div id="ad"></div>		
</div>
</body>