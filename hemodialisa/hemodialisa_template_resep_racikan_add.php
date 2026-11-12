<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#resep").autocomplete("index.php?autocomp=autocompklinikfarmasi",{width: 450});
    });
</script>
<?php
$generik = '';
$dosis = '';
$psikotropika = '';
$nama_racikan = '';
$resep_id = '';
$resep = '';
$jumlah = '';

if(isset($_POST['tambahracikan'])){
	include('hemodialisa/hemodialisa_save_add_template_resep_racikan.php');
}
?>
<body>
<div class="div_menu" style=" height:auto; position:relative; padding:0px; padding-top:3px; padding-bottom:3px; border:1px solid #999; border-radius:5px; margin:5px; margin-top:7px; background-color:#C8EFAD;">
<form name="formedit" method="post" >
	<table class="tableform" border="0" width="100%">	
				<tr><td width="200">Nama Resep Racikan</td>
					<td><input type="text" name="nama_racikan" id="nama_racikan" class="text_dt" value="<?php echo $nama_racikan; ?>" style="width:450px" /></td></tr>
				<tr><td>Aturan Pakai</td>
					<td><input type="text" name="dosis" id="dosis" class="text_dt" value="<?php echo $dosis; ?>"  style="width:200px" ></td></tr>
				<tr><td>&nbsp;</td><td>Generik&nbsp;&nbsp;<input type="checkbox" name="generik" id="generik" value="1" <?php if ($generik == '1') echo 'checked="checked"'; ?> />&nbsp;&nbsp;
					Psikotropika&nbsp;&nbsp;<input type="checkbox" name="psikotropika" id="psikotropika" value="1" <?php if ($psikotropika == '1') echo 'checked="checked"'; ?> />
					</td></tr>	
				<tr><td>&nbsp;</td><td align="right"></td></tr>	
				<tr><td width="200">Nama Obat</td>
					<td><input type="text" name="resep" id="resep" class="text_dt" value="<?php echo $resep; ?>" style="width:450px" onblur="Javascript : get_satuan(this.value); return false;" /></td></tr>
				<tr><td>Jumlah</td>
					<td><input type="text" name="jumlah" id="jumlah" class="text_dt" value="<?php echo $jumlah; ?>" style="width:200px" >&nbsp;<span id="satuan" ></span></td></tr>	
				<tr><td>&nbsp;</td><td align="right">
					<input type="submit" name="tambahracikan" value="tambah" class="myButton1" />
					</td></tr>
			</table>
	<input type="hidden" name="resep_id" value="<?php echo $resep_id; ?>" />
</form>
</div>
<?php
if(!empty($resep_id)){
$sql_racikan = 'SELECT t_hemodialisa_template_resep_racikan.HEMODIALISA_TEMPLATE_RESEP_RACIKAN_ID,
				t_hemodialisa_template_resep_racikan.HEMODIALISA_TEMPLATE_RESEP_ID,
				t_hemodialisa_template_resep_racikan.RESEP,t_hemodialisa_template_resep_racikan.PERSEDIAAN_ID,t_hemodialisa_template_resep_racikan.JUMLAH_KELUAR,
				t_hemodialisa_template_resep_racikan.SATUAN,t_hemodialisa_template_resep_racikan.FORMULARIUM,t_hemodialisa_template_resep_racikan.FORMULARIUM_NASIONAL
				FROM t_hemodialisa_template_resep_racikan
				WHERE t_hemodialisa_template_resep_racikan.HEMODIALISA_TEMPLATE_RESEP_ID = "' . $resep_id . '"';
$get_racikan = mysql_query($sql_racikan) or die(mysql_error());
if(mysql_num_rows($get_racikan) > 0){				
?>
<div id="tbl_racikan" >
<div class="div_menu" style=" height:auto; position:relative; padding:0px; padding-top:3px; padding-bottom:3px; border:1px solid #999; border-radius:5px; margin:5px; margin-top:7px; background-color:#C8EFAD;">
<table width="95%" class="tableData" id="tfhover">
<?php $zx= 1; while($dat_racikan = mysql_fetch_array($get_racikan)){ ?>
<tr>
	<td width="20px" align="center"><?php echo $zx; ?></td>
	<td><?php echo $dat_racikan['RESEP']; ?></td>
	<td width="100"><?php echo $dat_racikan['JUMLAH_KELUAR']; ?></td>
	<td width="10"><a href="#" onclick="javascript : MyAjaxRequest('tbl_racikan','index.php?ajaxrequest=hemodialisadeltemplateracikan&racikan_id=<?php echo $dat_racikan['HEMODIALISA_TEMPLATE_RESEP_RACIKAN_ID']; ?>&resep_id=<?php echo $dat_racikan['HEMODIALISA_TEMPLATE_RESEP_ID']; ?>');return false;" >hapus</a></td>
</tr>
<?php $zx++; } ?>
<tr>
	<td colspan="4" align="right"><input type="button" value="selesai" class="myButton1" onclick="JavaScript : selesai_racikan();" /></td>
</tr>
</table>
</div>
</div>
<?php } } ?>
</body>
<script language="JavaScript" >
function selesai_racikan(){
	window.location = "index.php?link=<?php echo md5('hemodialisatemplateresep'); ?>";
}

function get_satuan(resep){
	MyAjaxRequest('satuan','index.php?ajaxrequest=kliniksatuanresep&resep=' + resep);
}
</script>