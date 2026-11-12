<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#resep").autocomplete("index.php?autocomp=autocompranapfarmasi",{width: 450});
    });
	
	jQuery(document).ready(function() {
        jQuery("#dosis").autocomplete("index.php?autocomp=autocompranapfarmasidosis",{width: 205});
    });
	
	jQuery(document).ready(function() {
        jQuery("#jumlah").autocomplete("index.php?autocomp=autocompranapfarmasijumlah",{width: 205});
    });
</script>
<?php
$nama_obat = '';
$jumlah = '';
$dosis = '';
$frekuensi = '';
$cara_pemberian = '';
if(isset($_POST['tambah'])) include('rawatinap/ranap_save_terapi_pulang.php');
?>
<body>
<div class="div_menu" style=" height:auto; position:relative; padding:0px; padding-top:3px; padding-bottom:3px; border:1px solid #999; border-radius:5px; margin:5px; margin-top:7px; background-color:#C8EFAD;">
<form name="formedit" method="post" >
    <table class="tableform" border="0" width="100%">	
		<tr><td width="200">Nama Obat</td>
            <td><input type="text" name="nama_obat" id="resep" class="text_dt" value="<?php echo $nama_obat; ?>" style="width:450px" onblur="Javascript : get_satuan(this.value); return false;" /></td></tr>
		<tr><td>Jumlah</td>
            <td><input type="text" name="jumlah" id="jumlah" class="text_dt" value="<?php echo $jumlah; ?>" style="width:150px" >&nbsp;<span id="satuan" ></span></td></tr>	
		<tr><td>Dosis</td>
            <td><input type="text" name="dosis" id="dosis" class="text_dt" value="<?php echo $dosis; ?>" style="width:200px" ></td></tr>
		<tr><td>Frekuensi</td>
            <td><input type="text" name="frekuensi" id="frekuensi" class="text_dt" value="<?php echo $frekuensi; ?>" style="width:200px" ></td></tr>
		<tr><td>Cara Pemberian</td>
            <td><input type="text" name="cara_pemberian" id="cara_pemberian" class="text_dt" value="<?php echo $cara_pemberian; ?>" style="width:200px" ></td></tr>	
        <tr><td>&nbsp;</td><td align="right">
                <input type="submit" name="tambah" value="tambah" class="myButton1" />&nbsp;
                <a href="#" onclick="window.close();" /><input type="button" name="tutup" value="tutup" class="myButton1" /></a>
            </td></tr>
    </table>
	<input type="hidden" name="irna_id" value="<?php echo $_GET['idx']; ?>" />
</form>
</div>