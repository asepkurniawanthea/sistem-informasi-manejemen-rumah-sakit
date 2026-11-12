<?php
if(isset($_GET['no_peserta']) && isset($_GET['opt'])){
?>
<div id="peserta_detail" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<image id="loader" src="/nsimrs/sep/image/loading_circle_green.gif" height="20px" width="20px" />
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<table width="100%" border="0">	
	<tr>
		<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
		<td align="right" width="200px"><input type="button" class="myButton" value="tutup" onclick="window.close();"  /></td>
	</tr>
</table>	
</div>	
<script>
getDetailPeserta('<?php echo $_GET['opt']; ?>','<?php echo $_GET['no_peserta']; ?>');
</script>
<?php } ?>