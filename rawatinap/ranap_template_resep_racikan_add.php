<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#resep").autocomplete("index.php?autocomp=autocompklinikfarmasi",{width: 450});
    });
</script>
<?php
$resep_id = '';
$racikan = '';
$racikan_lain = '';
$nama_racikan = '';
$dosis = '';
$dosis_lain = '';
$satuan_dosis = '';
$satuan_lain = '';
$waktu_pakai = '';
$waktu_lain = '';

$generik = '';
$psikotropika = '';

$resep = '';
$jumlah = '';

$arr_nama_racikan = getResepNamaRacikan();
$arr_aturan_pakai = getResepAturanPakai();
$arr_satuan_resep = getResepSatuan();
$arr_waktu_pakai = getResepWaktuPakai();

$arr_nrc = array();
$arr_atp = array();
$arr_str = array();
$arr_wkp = array();

if(isset($_POST['tambahracikan'])){
	include('rawatinap/ranap_save_add_template_resep_racikan.php');
}
?>
<body>
<div class="div_menu" style=" height:auto; position:relative; padding:0px; padding-top:3px; padding-bottom:3px; border:1px solid #999; border-radius:5px; margin:5px; margin-top:7px; background-color:#C8EFAD;">
<form name="formedit" method="post" >
	<table class="tableform" border="0" width="100%">	
				<tr><td width="200">Nama Resep</td>
					<td><input type="text" name="nama_racikan" id="nama_racikan" class="text_dt" 
					value="<?php echo $nama_racikan; ?>" style="width:450px" /></td></tr>
				<tr><td width="200">Racikan</td>
					<td><?php foreach($arr_nama_racikan as $idx=>$row){ ?>
						<input type="checkbox" name="racikan_<?php echo $idx; ?>" class="text_dt" value="<?php echo $idx; ?>" 
						<?php
							foreach($arr_nrc as $xrow){
								if(is_numeric($xrow)){
									if($xrow == $idx) echo 'checked="checked"';
								}else{
									$racikan_lain = $xrow;
								}  	
							}
						?>
						/><?php echo $row; ?>&nbsp;
					<?php } ?>&nbsp;&nbsp;<input type="text" name="racikan_lain" id="racikan_lain" class="text_dt" value="<?php echo $racikan_lain; ?>" style="width:200px" >
					</td></tr>	
				<tr><td>Aturan Pakai</td>
					<td><?php foreach($arr_aturan_pakai as $idx=>$row){ ?>
						<input type="checkbox" name="dosis_<?php echo $idx; ?>" class="text_dt" value="<?php echo $idx; ?>" 
						<?php
							foreach($arr_atp as $xrow){
								if(is_numeric($xrow)){
									if($xrow == $idx) echo 'checked="checked"'; 
								}else{
									$dosis_lain = $xrow;	
								}	
							}
						?>
						/><?php echo $row; ?>&nbsp;
					<?php } ?>&nbsp;&nbsp;<input type="text" name="dosis_lain" id="dosis_lain" class="text_dt" value="<?php echo $dosis_lain; ?>" style="width:200px" ></td>
				</tr>
				<tr><td>&nbsp;</td>
					<td><?php foreach($arr_satuan_resep as $idx=>$row){ ?>
						<input type="checkbox" name="satuan_<?php echo $idx; ?>" class="text_dt" value="<?php echo $idx; ?>" 
						<?php
							foreach($arr_str as $xrow){
								if(is_numeric($xrow)){
									if($xrow == $idx) echo 'checked="checked"'; 
								}else{
									$satuan_lain = $xrow;	
								}	
							}
						?>
						/><?php echo $row; ?>&nbsp;
					<?php } ?>&nbsp;&nbsp;<input type="text" name="satuan_lain" id="satuan_lain" class="text_dt" value="<?php echo $satuan_lain; ?>" style="width:200px" ></td>
				</tr>
				<tr><td>Waktu Pakai</td>
					<td><?php foreach($arr_waktu_pakai as $idx=>$row){ ?>
						<input type="checkbox" name="waktu_<?php echo $idx; ?>" class="text_dt" value="<?php echo $idx; ?>" 
						<?php
							foreach($arr_wkp as $xrow){
								if(is_numeric($xrow)){
									if($xrow == $idx) echo 'checked="checked"'; 
								}else{
									$waktu_lain = $xrow;	
								}	
							}
						?>
						/><?php echo $row; ?>&nbsp;
					<?php } ?>&nbsp;&nbsp;<input type="text" name="waktu_lain" id="waktu_lain" class="text_dt" value="<?php echo $waktu_lain; ?>" style="width:200px" ></td>
				</tr>
				<tr><td>&nbsp;</td><td>Generik&nbsp;&nbsp;<input type="checkbox" name="generik" id="generik" value="1" <?php if ($generik == '1') echo 'checked="checked"'; ?> />&nbsp;&nbsp;
					Psikotropika&nbsp;&nbsp;<input type="checkbox" name="psikotropika" id="psikotropika" value="1" <?php if ($psikotropika == '1') echo 'checked="checked"'; ?> />
					</td></tr>	
				<tr><td>&nbsp;</td><td align="right"></td></tr>	
				<tr><td width="200">Nama Obat</td>
					<td><input type="text" name="resep" id="resep" class="text_dt" value="<?php echo $resep; ?>" style="width:450px" onblur="Javascript : get_satuan(this.value); return false;" /></td></tr>
				<tr><td>Jumlah</td>
					<td><input type="text" name="jumlah" id="jumlah" class="text_dt" value="<?php echo $jumlah; ?>" style="width:100px" >&nbsp;<span id="satuan" ></span></td></tr>	
				<tr><td>&nbsp;</td><td align="right">
					<input type="submit" name="tambahracikan" value="tambah" class="myButton1" />
					</td></tr>
			</table>
	<input type="hidden" name="resep_id" value="<?php echo $resep_id; ?>" />
</form>
</div>
<?php
if(!empty($resep_id)){
$sql_racikan = 'SELECT *
				FROM t_irna_template_resep_racikan
				WHERE IRNA_TEMPLATE_RESEP_ID = "' . $resep_id . '"';
$get_racikan = mysql_query($sql_racikan) or die(mysql_error());
if(mysql_num_rows($get_racikan) > 0){				
?>
<div id="tbl_racikan" >
<div class="div_menu" style=" height:auto; position:relative; padding:0px; padding-top:3px; padding-bottom:3px; border:1px solid #999; border-radius:5px; margin:5px; margin-top:7px; background-color:#C8EFAD;">
<table width="95%" class="tableData" id="tfhover">
<tr>
	<th>No</th>
	<th>Nama Obat</th>
	<th>Jumlah</th>
	<th>Option</th>
</tr>
<?php $zx= 1; while($dat_racikan = mysql_fetch_array($get_racikan)){ ?>
<tr>
	<td width="20px" align="center"><?php echo $zx; ?></td>
	<td><?php echo $dat_racikan['RESEP']; ?></td>
	<td width="100"><?php echo $dat_racikan['JUMLAH_KELUAR'] . ' ' . $dat_racikan['SATUAN']; ?></td>
	<td width="10"><a href="#" onclick="javascript : MyAjaxRequest('tbl_racikan','index.php?ajaxrequest=ranapdeltemplateracikan&racikan_id=<?php echo $dat_racikan['IRNA_TEMPLATE_RESEP_RACIKAN_ID']; ?>&resep_id=<?php echo $dat_racikan['IRNA_TEMPLATE_RESEP_ID']; ?>');return false;" >hapus</a></td>
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
	window.location = "index.php?link=<?php echo md5('ranaptemplateresep'); ?>";
}

function get_satuan(resep){
	MyAjaxRequest('satuan','index.php?ajaxrequest=kliniksatuanresep&resep=' + resep);
}
</script>