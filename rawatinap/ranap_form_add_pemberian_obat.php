<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#nama_obat").autocomplete("index.php?autocomp=autocompranapfarmasi",{width: 450});
    });
	jQuery(document).ready(function() {
        jQuery("#dosis").autocomplete("index.php?autocomp=autocompranapdosispemberianobat",{width: 450});
    });
	jQuery(document).ready(function() {
        jQuery("#dosis").autocomplete("index.php?autocomp=autocompranapstatusdosispemberianobat",{width: 450});
    });
	function get_satuan(resep){
		MyAjaxRequest('satuan','index.php?ajaxrequest=kliniksatuanresep&resep=' + resep);
	}
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
$insidentil = '';
$obat_dari_luar = '';
$obat_resep = '';
$nama_obat = '';
$dosis = '';
$status_dosis = '';

$pegawai_id = $_SESSION['SES_SIMRS_PEGAWAI_ID'];

if (isset($_POST['irna_id'])) {
    include('rawatinap/ranap_save_add_pemberian_obat.php');
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
			<td>&nbsp;</td>
			<td><input type="checkbox" name="insidentil" value="1" <?php if($insidentil == '1') echo 'checked="checked"'; ?> />Insidentil</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="checkbox" name="obat_resep" value="1" <?php if($obat_resep == '1') echo 'checked="checked"'; ?> />Resep</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="checkbox" name="obat_dari_luar" value="1" <?php if($obat_dari_luar == '1') echo 'checked="checked"'; ?> />Obat Dari Luar</td>
		</tr>
        <tr>
			<td>Nama Obat/BHP</td>
            <td><input type="text" name="nama_obat" id="nama_obat" value="<?php echo $nama_obat; ?>" class="text_dt" size="71" onblur="Javascript : get_satuan(this.value); return false;" /></td>
		</tr>
		<tr>
			<td>Dosis</td>
            <td><input type="text" name="dosis" id="dosis" class="text_dt" size="10" value="<?php echo $dosis; ?>" />&nbsp;<span id="satuan" ></td>
		</tr>
		<tr>
			<td>Status Dosis</td>
            <td><input type="text" name="status_dosis" id="status_dosis" class="text_dt" size="60" value="<?php echo $status_dosis; ?>" /></td>
		</tr>
		<tr>
			<td>Petugas</td>
            <td><select name="pegawai_id" class="text_dt" >
			<option value="" > -- </option>
			<?php echo getPelaksanaRanap($pegawai_id, $_SESSION['SES_SIMRS_UNIT_ID']); ?>
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