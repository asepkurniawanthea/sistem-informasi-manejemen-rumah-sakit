<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#diagnosa").autocomplete("index.php?autocomp=autocompranapdiagnosa",{width: 500});
    });
</script>
<style>
html {
	background:url(image/bg_pattern1.jpg);

}
</style>
<?php
$temp_icd_code = '';
$diagmasuk = '';
if(isset($_GET['diagmasuk'])) $diagmasuk = '1';
 
if (isset($_POST['irna_id'])) include('rawatinap/ranap_save_add_diagnosa.php');
?>
<body>
<div class="div_menu" style=" height:auto; position:relative; padding:0px; padding-top:3px; padding-bottom:3px; border:1px solid #999; border-radius:5px; margin:5px; margin-top:7px; background-color:#C8EFAD;">
<form name="formedit" action="<?php echo currentURL(); ?>" method="post" >
    <table border="0" width="95%" cellpadding="0" cellspacing="0" align="center">
        <tr><td colspan="2">&nbsp;</td></tr>						
        <tr>
            <td colspan="2" align="center"><input type="text" name="q" id="diagnosa" size="77" value="<?php echo $temp_icd_code; ?>" class="text_dt"  /></td></tr>
		<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td colspan="2" align="right"><input type="submit" value="tambah" class="myButton1" />&nbsp;
                <a href="#" onclick="window.close();" /><input type="button" name="selesai" value="tutup" class="myButton1" /></a></td>
	</tr>
	
	</table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
    <input type="hidden" name="irna_id" value="<?php echo $_REQUEST['idx']; ?>" />
</form>
<div id="ad"></div>		
</div>
</body>