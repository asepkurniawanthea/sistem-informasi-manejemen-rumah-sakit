<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#resep").autocomplete("index.php?autocomp=autocomphemodialisafarmasialergi",{width: 450});
    });
</script>
<?php
$alergi = '';
if(isset($_POST['tambah'])){
	include('hemodialisa/hemodialisa_save_add_alergi.php');
}
?>
<body>
<div class="div_menu" style=" height:auto; position:relative; padding:0px; padding-top:3px; padding-bottom:3px; border:1px solid #999; border-radius:5px; margin:5px; margin-top:7px; background-color:#C8EFAD;">
<form name="formedit" method="post" >
    <table class="tableform" border="0" width="100%">	
		<tr><td width="400">Alergi/ Nama Obat</td>
            <td><input type="text" name="alergi" id="resep" class="text_dt" value="<?php echo $alergi; ?>" style="width:400px" onblur="Javascript : get_satuan(this.value); return false;" /></td></tr>	
        <tr><td>&nbsp;</td><td align="right">
                <input type="submit" name="tambah" value="tambah" class="myButton1" />&nbsp;
                <a href="#" onclick="window.close();" /><input type="button" name="batal" value="tutup" class="myButton1" /></a>
            </td></tr>
    </table>
	<input type="hidden" name="irja_id" value="<?php echo $_GET['idx']; ?>" />
	<input type="hidden" name="jns_order" value="<?php echo $_GET['ord']; ?>" />
</form>
</div>
</body>