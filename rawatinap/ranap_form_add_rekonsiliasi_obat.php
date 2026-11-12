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
$nama_obat = '';
$dosis = '';
$frekuensi = '';
$rute_pemberian = '';
$tanggal_mulai = '';
$tanggal_stop = '';
$selama_perawatan = '';
$saat_pulang = '';

if (isset($_POST['irna_id'])) {
    include('rawatinap/ranap_save_add_rekonsiliasi_obat.php');
}
?>
<body>
<div class="div_menu" style=" height:auto; position:relative; padding:0px; padding-top:3px; padding-bottom:3px; border:1px solid #999; border-radius:5px; margin:5px; margin-top:7px; background-color:#C8EFAD;">
<form name="search" action="<?php echo currentURL(); ?>" method="post" >
    <table border="0" width="95%" cellpadding="0" cellspacing="0" align="center">
        <tr><td colspan="2">&nbsp;</td></tr>						
		<tr>
			<td>Nama Obat</td>
            <td><input type="text" name="nama_obat" id="nama_obat" value="<?php echo $nama_obat; ?>" class="text_dt" size="50" onblur="Javascript : get_satuan(this.value); return false;" /></td>
		</tr>
		<tr>
			<td>Dosis</td>
            <td><input type="text" name="dosis" id="dosis" class="text_dt" value="<?php echo $dosis; ?>" />&nbsp;<span id="satuan" ></td>
		</tr>
		<tr>
			<td>Frekuensi</td>
            <td><input type="text" name="frekuensi" id="frekuensi" class="text_dt" value="<?php echo $frekuensi; ?>" /></td>
		</tr>
		<tr>
			<td>Rute Pemberian</td>
            <td><input type="text" name="rute_pemberian" id="rute_pemberian" class="text_dt" value="<?php echo $rute_pemberian; ?>" /></td>
		</tr>
		<tr>
			<td>Tanggal Mulai</td>
            <td><input type="text" name="tanggal_mulai" id="tgl_1" class="text_dt" value="<?php echo $tanggal_mulai; ?>" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
		</tr>
		<tr>
			<td>Tanggal Stop</td>
            <td><input type="text" name="tanggal_stop" id="tgl_2" class="text_dt" value="<?php echo $tanggal_stop; ?>" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/></td>
		</tr>
		<tr>
			<td>Obat Dilanjutkan Selama Perawatan</td>
			<td><input type="checkbox" name="selama_perawatan" value="1" <?php if($selama_perawatan == '1') echo 'checked="checked"'; ?> />&nbsp;Ya</td>
		</tr>
		<tr>
			<td>Obat Dilanjutkan Saat Pasien Pulang</td>
			<td><input type="checkbox" name="saat_pulang" value="1" <?php if($saat_pulang == '1') echo 'checked="checked"'; ?> />&nbsp;Ya</td>
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