<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#resep").autocomplete("index.php?autocomp=autocompklinikfarmasi",{width: 450});
    });
</script>
<?php
$no_resep = '';
$nama_resep = '';
$resep = '';
$jumlah = '';
$dosis = '';
$dosis_lain = '';
$satuan_dosis = '';
$satuan_lain = '';
$waktu_pakai = '';
$waktu_lain = '';
$generik = '';
$psikotropika = '';

$arr_aturan_pakai = getResepAturanPakai();
$arr_satuan_resep = getResepSatuan();
$arr_waktu_pakai = getResepWaktuPakai();

$arr_atp = array();
$arr_str = array();
$arr_wkp = array();

if(isset($_POST['tambahracikan'])){
	include('operasi/operasi_save_add_template_resep.php');
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
					<td><input type="text" name="jumlah" id="jumlah" class="text_dt" value="<?php echo $jumlah; ?>" style="width:100px" >&nbsp;<span id="satuan" ></span></td></tr>	
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
				<tr><td>&nbsp;</td><td align="right">
					<input type="submit" name="tambahracikan" value="tambah" class="myButton1" />
					</td></tr>
			</table>
	<input type="hidden" name="no_resep" value="<?php echo $no_resep; ?>" />
</form>
</div>
<?php
if(!empty($no_resep)){
$sql_racikan = 'SELECT *
				FROM t_irna_template_resep
				WHERE NO_TEMPLATE = "' . $no_resep . '"';
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
	<th>Aturan Pakai</th>
	<th>Waktu Pakai</th>
	<th>Generik</th>
	<th>Psikotropika</th>
	<th>Option</th>
</tr>
<?php $zx= 1; while($dat_racikan = mysql_fetch_array($get_racikan)){ ?>
<tr>
	<td width="20px" align="center"><?php echo $zx; ?></td>
	<td><?php echo $dat_racikan['RESEP']; ?></td>
	<td width="100"><?php echo $dat_racikan['JUMLAH_KELUAR'] . ' ' . $dat_racikan['SATUAN']; ?></td>
	<td width="100"><?php $arr_atp = explode('|',$dat_racikan['DOSIS']);
						$atp = '';
						foreach($arr_atp as $row){
							if(is_numeric($row)){
								$atp .= $arr_aturan_pakai[$row] . ',';
							}else{
								$atp .= $row . ',';
							}
						}
						echo substr($atp,0,strlen($atp)-1);
						
						$arr_str = explode('|',$dat_racikan['SATUAN_DOSIS']);
						$str = '';
						foreach($arr_str as $row){
							if(is_numeric($row)){
								$str .= $arr_satuan_resep[$row] . ',';
							}else{
								$str .= $row . ',';
							}
						}
						echo ' ' . substr($str,0,strlen($str)-1);
	?></td>
	<td width="100"><?php $arr_wkp = explode('|',$dat_racikan['WAKTU_PAKAI']);
						$wkp = '';
						foreach($arr_wkp as $row){
							if(is_numeric($row)){
								$wkp .= $arr_waktu_pakai[$row] . ',';
							}else{
								$wkp .= $row . ',';
							}
						}
						$wkp = substr($wkp,0,strlen($wkp)-1);
						echo str_replace('Bila perlu,','Bila perlu ',$wkp); 
	?></td>
	<td align="center"><?php if($dat_racikan['GENERIK'] == '1') echo '&radic;'; ?></td>
	<td align="center"><?php if($dat_racikan['PSIKOTROPIKA'] == '1') echo '&radic;'; ?></td>
	<td width="10"><a href="#" onclick="javascript : MyAjaxRequest('tbl_racikan','index.php?ajaxrequest=operasideltemplateobat&resep_id=<?php echo $dat_racikan['IRNA_TEMPLATE_RESEP_ID']; ?>&no_resep=<?php echo $dat_racikan['NO_TEMPLATE']; ?>');return false;" >hapus</a></td>
</tr>
<?php $zx++; } ?>
<tr>
	<td colspan="8" align="right"><input type="button" value="selesai" class="myButton1" onclick="JavaScript : selesai_racikan();" /></td>
</tr>
</table>
</div>
</div>
<?php } } ?>
</body>
<script language="JavaScript" >
function selesai_racikan(){
	window.location = "index.php?link=<?php echo md5('operasitemplateresepobat'); ?>";
}

function get_satuan(resep){
	MyAjaxRequest('satuan','index.php?ajaxrequest=kliniksatuanresep&resep=' + resep);
}
</script>