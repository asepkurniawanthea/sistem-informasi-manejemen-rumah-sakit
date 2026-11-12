<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#resep").autocomplete("index.php?autocomp=autocompklinikfarmasi",{width: 450});
    });
</script>
<?php
$generik = '';
$dosis = '';
$psikotropika = '';
$nama_resep = '';
$no_resep = '';
$resep = '';
$jumlah = '';

if(isset($_POST['tambahracikan'])){
	include('hemodialisa/hemodialisa_save_add_template_resep.php');
}
?>
<body>
<div class="div_menu" style=" height:auto; position:relative; padding:0px; padding-top:3px; padding-bottom:3px; border:1px solid #999; border-radius:5px; margin:5px; margin-top:7px; background-color:#C8EFAD;">
<form name="formedit" method="post" >
	<table class="tableform" border="0" width="100%">	
				<tr><td width="200">Nama Resep</td>
					<td><input type="text" name="nama_resep" id="nama_resep" class="text_dt" value="<?php echo $nama_resep; ?>" style="width:450px" /></td></tr>
									</td></tr>	
				<tr><td>&nbsp;</td><td align="right"></td></tr>	
				
				<tr><td width="200">Nama Obat</td>
					<td><input type="text" name="resep" id="resep" class="text_dt" value="<?php echo $resep; ?>" style="width:450px" onblur="Javascript : get_satuan(this.value); return false;" /></td></tr>
				<tr><td>Jumlah</td>
					<td><input type="text" name="jumlah" id="jumlah" class="text_dt" value="<?php echo $jumlah; ?>" style="width:200px" >&nbsp;<span id="satuan" ></span></td></tr>	
				<tr><td>Aturan Pakai</td>
					<td><input type="text" name="dosis" id="dosis" class="text_dt" value="<?php echo $dosis; ?>"  style="width:200px" ></td></tr>
				<tr><td>&nbsp;</td><td>Generik&nbsp;&nbsp;<input type="checkbox" name="generik" id="generik" value="1" <?php if ($generik == '1') echo 'checked="checked"'; ?> />&nbsp;&nbsp;
					Psikotropika&nbsp;&nbsp;<input type="checkbox" name="psikotropika" id="psikotropika" value="1" <?php if ($psikotropika == '1') echo 'checked="checked"'; ?> />
				<tr><td>&nbsp;</td><td align="right">
					<input type="submit" name="tambahracikan" value="tambah" class="myButton1" />
					</td></tr>
			</table>
	<input type="hidden" name="no_resep" value="<?php echo $no_resep; ?>" />
</form>
</div>
<?php
if(!empty($no_resep)){
$sql_racikan = 'SELECT t_hemodialisa_template_resep.HEMODIALISA_TEMPLATE_RESEP_ID,
				t_hemodialisa_template_resep.RESEP,t_hemodialisa_template_resep.PERSEDIAAN_ID,t_hemodialisa_template_resep.JUMLAH_KELUAR,
				t_hemodialisa_template_resep.SATUAN,t_hemodialisa_template_resep.FORMULARIUM,t_hemodialisa_template_resep.FORMULARIUM_NASIONAL,
				t_hemodialisa_template_resep.NO_TEMPLATE
				FROM t_hemodialisa_template_resep
				WHERE t_hemodialisa_template_resep.NO_TEMPLATE = "' . $no_resep . '"';
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
	<td width="10"><a href="#" onclick="javascript : MyAjaxRequest('tbl_racikan','index.php?ajaxrequest=hemodialisadeltemplateobat&resep_id=<?php echo $dat_racikan['HEMODIALISA_TEMPLATE_RESEP_ID']; ?>&no_resep=<?php echo $dat_racikan['NO_TEMPLATE']; ?>');return false;" >hapus</a></td>
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
	window.location = "index.php?link=<?php echo md5('hemodialisatemplateresepobat'); ?>";
}

function get_satuan(resep){
	MyAjaxRequest('satuan','index.php?ajaxrequest=kliniksatuanresep&resep=' + resep);
}
</script>