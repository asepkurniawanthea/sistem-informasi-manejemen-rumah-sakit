<?php
if(isset($_GET['nomr']) && isset($_GET['nosep']) && isset($_GET['idx']) && isset($_GET['jnsrawat']) && isset($_GET['mh']) && isset($_GET['nama_pasien'])){
$svrmh = $_GET['mh'];
$nomor_sep = $_GET['nosep'];
$nomr = $_GET['nomr'];
$nama_pasien = $_GET['nama_pasien'];
$idx_rawat = $_GET['idx'];
$jns_rawat = $_GET['jnsrawat'];
?>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<table width="100%" border="0">
	<tr>
		<td>Nomor MR</td><td>:</td><td><?php echo formatNoMR($nomr); ?></td>
		<td>Nama Pasien</td><td>:</td><td><?php echo $nama_pasien; ?></td>
	</tr>
	<tr>
		<td>Nomor SEP</td><td>:</td><td><input type="text" name="nomor_sep" id="nomor_sep" value="<?php echo $nomor_sep; ?>" class="text_dt" size="30"/></td>
		<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
	</tr>	
</table>
</div>
<div id="klaim_detail" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<image id="loader3" src="/nsimrs/sep/image/loading_circle_green.gif" height="20px" width="20px" />
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
klaim_detail('<?php echo $nomor_sep; ?>','<?php echo $svrmh; ?>','<?php echo $idx_rawat; ?>','<?php echo $jns_rawat; ?>');
</script>
<?php } ?>