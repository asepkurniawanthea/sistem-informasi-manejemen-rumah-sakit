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
$tanggal = date('d/m/Y');
$jam = date('H');
$menit = date('i');

if (isset($_POST['irna_id'])) {
    include('rawatinap/ranap_save_add_catatan_keluar_masuk.php');
}
?>
<body>
<div class="div_menu" style=" height:auto; position:relative; padding:0px; padding-top:3px; padding-bottom:3px; border:1px solid #999; border-radius:5px; margin:5px; margin-top:7px; background-color:#C8EFAD;">
<form name="formedit" action="<?php echo currentURL(); ?>" method="post" >
    <table border="0" width="95%" cellpadding="0" cellspacing="0" align="center">
        <tr><td colspan="2">&nbsp;</td></tr>						
		<tr>
			<td width="200px;">Tanggal</td>
            <td>
			<input type="text" name="tanggal" id="tgl_1" class="text_dt" size="10" value="<?php echo $tanggal; ?>" readonly="readonly" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar11')"/>
			<select name="jam" id="jam" style="width:50px;" class="text_dt" >
			<?php echo getJam($jam); ?>
			</select>
			<select name="menit" id="menit" style="width:50px;" class="text_dt" >
			<?php echo getMenit($menit); ?>
			</select>
			</td>
		</tr>
        <tr>
			<td>Intake/Output</td>
            <td><input type="text" name="jenis_keluar_masuk" id="jenis_keluar_masuk" class="text_dt" size="40"/></td>
		</tr>
		<tr>
			<td>Catatan</td>
            <td><textarea name="catatan" class="text_dt3" ></textarea></td>
		</tr>
		<tr>
			<td>Petugas</td>
            <td><select name="pegawai_id" class="text_dt" >
			<option value="" > -- </option>
			<?php echo getPelaksanaRanap($_SESSION['SES_SIMRS_PEGAWAI_ID'], $_SESSION['SES_SIMRS_UNIT_ID']); ?>
			</select></td>
		</tr>	
		<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td colspan="2" align="right"><input type="submit" value="tambah" class="myButton1" />&nbsp;
                <a href="#" onclick="window.close();" /><input type="button" name="selesai" value="tutup" class="myButton1" /></a></td>
	</tr>
	</table>
    <input type="hidden" name="irna_id" value="<?php echo $_REQUEST['idx']; ?>" />
</form>
<div id="ad"></div>		
</div>
</body>