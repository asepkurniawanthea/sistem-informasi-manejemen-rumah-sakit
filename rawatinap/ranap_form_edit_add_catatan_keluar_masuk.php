<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#jenis_keluar_masuk").autocomplete("index.php?autocomp=autocompranapkeluarmasuk",{width: 260});
    });
</script>
<style>
html {
	background:url(image/bg_pattern1.jpg);

}
</style>
<?php

if (isset($_POST['irna_id'])) {
    include('rawatinap/ranap_save_edit_add_catatan_keluar_masuk.php');
}

$idx = $_GET['idx'];
$idc = $_GET['idc'];

$qry_catatan = 'SELECT DATE_FORMAT(t_irna_catatan_keluar_masuk.TANGGAL,"%d/%m/%Y") AS TANGGAL,
				DATE_FORMAT(t_irna_catatan_keluar_masuk.TANGGAL,"%H") AS JAM,
				DATE_FORMAT(t_irna_catatan_keluar_masuk.TANGGAL,"%i") AS MENIT,
				t_irna_catatan_keluar_masuk.JENIS_KELUAR_MASUK,
				t_irna_catatan_keluar_masuk.CATATAN,
				t_irna_catatan_keluar_masuk.PEGAWAI_ID
				FROM t_irna_catatan_keluar_masuk
				WHERE IRNA_ID = "' . $idx . '" AND t_irna_catatan_keluar_masuk.KELUAR_MASUK_ID = "' . $idc . '"';
$get_catatan = mysql_query($qry_catatan) or die(mysql_error());
$dat_catatan = mysql_fetch_array($get_catatan);
?>
<body>
<div class="div_menu" style=" height:auto; position:relative; padding:0px; padding-top:3px; padding-bottom:3px; border:1px solid #999; border-radius:5px; margin:5px; margin-top:7px; background-color:#C8EFAD;">
<form name="formedit" action="<?php echo currentURL(); ?>" method="post" >
    <table border="0" width="95%" cellpadding="0" cellspacing="0" align="center">
        <tr><td colspan="2">&nbsp;</td></tr>						
		<tr>
			<td width="200px;">Tanggal</td>
            <td>
			<input type="text" name="tanggal" id="tgl_1" class="text_dt" size="10" value="<?php echo $dat_catatan['TANGGAL']; ?>" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar11')"/>
			<select name="jam" id="jam" style="width:50px;" class="text_dt" >
			<?php echo getJam($dat_catatan['JAM']); ?>
			</select>
			<select name="menit" id="menit" style="width:50px;" class="text_dt" >
			<?php echo getMenit($dat_catatan['MENIT']); ?>
			</select>
			</td>
		</tr>
        <tr>
			<td>Intake/Output</td>
            <td><input type="text" name="jenis_keluar_masuk" id="jenis_keluar_masuk" value="<?php echo $dat_catatan['JENIS_KELUAR_MASUK']; ?>" class="text_dt" size="40"/></td>
		</tr>
		<tr>
			<td>Catatan</td>
            <td><textarea name="catatan" class="text_dt3" ><?php echo $dat_catatan['CATATAN']; ?></textarea></td>
		</tr>
		<tr>
			<td>Petugas</td>
            <td><select name="pegawai_id" class="text_dt">
			<option value="" > -- </option>
			<?php echo getPelaksanaRanap($dat_catatan['PEGAWAI_ID'], $_SESSION['SES_SIMRS_UNIT_ID']); ?>
			</select></td>
		</tr>	
		<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td colspan="2" align="right"><input type="submit" value="simpan" class="myButton1" />&nbsp;
                <a href="#" onclick="window.close();" /><input type="button" name="batal" value="tutup" class="myButton1" /></a></td>
	</tr>
	</table>
    <input type="hidden" name="irna_keluar_masuk_id" value="<?php echo $_REQUEST['idc']; ?>" />
	<input type="hidden" name="irna_id" value="<?php echo $_REQUEST['idx']; ?>" />
</form>
<div id="ad"></div>		
</div>
</body>