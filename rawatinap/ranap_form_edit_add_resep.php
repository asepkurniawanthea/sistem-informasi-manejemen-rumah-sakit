<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#resep").autocomplete("index.php?autocomp=autocompranapfarmasi",{width: 450});
    });
	
	jQuery(document).ready(function() {
        jQuery("#racikan").autocomplete("index.php?autocomp=autocompranapfarmasi",{width: 450});
    });
	
	jQuery(document).ready(function() {
        jQuery("#jumlah").autocomplete("index.php?autocomp=autocompranapfarmasijumlah",{width: 205});
    });
</script>
<?php
$arr_aturan_pakai = getResepAturanPakai();
$arr_satuan_resep = getResepSatuan();
$arr_waktu_pakai = getResepWaktuPakai();
$arr_nama_racikan = getResepNamaRacikan();

$arr_atp = array();
$arr_str = array();
$arr_wkp = array();
$arr_nrc = array();

$resep_tp = $_GET['tpr'];
if($resep_tp != '3'){
	$qry_resep = 'SELECT t_irna_resep.IRNA_RESEP_ID,t_irna_resep.RESEP,t_irna_resep.DOSIS,t_irna_resep.JUMLAH,t_irna_resep.GENERIK,t_irna_resep.PSIKOTROPIKA,
				t_irna_resep.SATUAN_DOSIS,t_irna_resep.WAKTU_PAKAI,t_irna_resep.SATUAN
				FROM t_irna_resep
				WHERE t_irna_resep.IRNA_RESEP_ID = "' . $_GET['idr'] . '"';
}else{
	$qry_resep = 'SELECT t_irna_resep_racikan.RESEP,t_irna_resep_racikan.JUMLAH,IRNA_RESEP_RACIKAN_ID AS IRNA_RESEP_ID,"" AS DOSIS,"" AS GENERIK,"" AS PSIKOTROPIKA,
				t_irna_resep_racikan.SATUAN
				FROM t_irna_resep_racikan
				WHERE t_irna_resep_racikan.IRNA_RESEP_RACIKAN_ID = "' . $_GET['idr'] . '"';
}				
$get_resep = mysql_query($qry_resep) or die(mysql_error());
$dat_resep = mysql_fetch_assoc($get_resep);
				
$resep = $dat_resep['RESEP'];
$dosis = $dat_resep['DOSIS'];
$jumlah = $dat_resep['JUMLAH'];
$psikotropika = $dat_resep['PSIKOTROPIKA'];
$generik = $dat_resep['GENERIK'];
$resep_id = $dat_resep['IRNA_RESEP_ID'];
$satuan = $dat_resep['SATUAN'];
$resep_tp = $_GET['tpr'];

$dosis_lain = '';
$satuan_lain = '';
$waktu_lain = '';
$racikan_lain = '';

if($resep_tp != '3'){
	$satuan_dosis = $dat_resep['SATUAN_DOSIS'];
	$waktu_pakai = $dat_resep['WAKTU_PAKAI'];
	$arr_str = explode('|',$satuan_dosis);
	$arr_wkp = explode('|',$waktu_pakai);
}

$arr_atp = explode('|',$dosis);
$arr_nrc = explode('|',$resep);

if(isset($_POST['simpan'])){
	include('rawatinap/ranap_save_edit_add_resep.php');
}
?>
<body>
<div class="div_menu" style=" height:auto; position:relative; padding:0px; padding-top:3px; padding-bottom:3px; border:1px solid #999; border-radius:5px; margin:5px; margin-top:7px; background-color:#C8EFAD;">
<form name="formedit" method="post" >
<?php if($resep_tp == '1'){ ?>	
	<table class="tableform" border="0" width="100%">	
		<tr><td width="100">Nama Obat</td>
            <td><input type="text" name="resep" id="resep" class="text_dt" value="<?php echo $resep; ?>" style="width:450px" onblur="Javascript : get_satuan(this.value); return false;" /></td></tr>
		<tr><td>Jumlah</td>
            <td><input type="text" name="jumlah" id="jumlah" class="text_dt" value="<?php echo $jumlah; ?>" style="width:100px" >&nbsp;<span id="satuan" ><?php echo $satuan; ?></span></td></tr>	
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
		<tr><td>&nbsp;</td>
			<td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td><td>Generik&nbsp;&nbsp;<input type="checkbox" name="generik" id="generik" value="1" <?php if ($generik == '1') echo 'checked="checked"'; ?> />&nbsp;&nbsp;
		Psikotropika&nbsp;&nbsp;<input type="checkbox" name="psikotropika" id="psikotropika" value="1" <?php if ($psikotropika == '1') echo 'checked="checked"'; ?> />
			</td></tr>
        <tr><td>&nbsp;</td><td align="right">
                <input type="submit" name="simpan" value="simpan" class="myButton1" />&nbsp;
                <a href="#" onclick="window.close();" /><input type="button" name="batal" value="tutup" class="myButton1" /></a>
            </td></tr>
    </table>
<?php }else if($resep_tp == '2'){ ?>
		<table class="tableform" border="0" width="100%">	
				<tr><td width="100">Racikan</td>
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
					<?php } ?>&nbsp;&nbsp;<input type="text" name="dosis_lain" id="dosis_lain" class="text_dt" value="<?php echo $dosis_lain; ?>" style="width:200px" ></td></tr>
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
				<tr><td width="100">Nama Obat</td>
					<td><input type="text" name="resep" id="resep" class="text_dt" style="width:450px" onblur="Javascript : get_satuan(this.value); return false;" /></td></tr>
				<tr><td>Jumlah</td>
					<td><input type="text" name="jumlah" id="jumlah" class="text_dt" style="width:100px" >&nbsp;<span id="satuan" ></span></td></tr>	
				<tr><td>&nbsp;</td><td align="right"></td></tr>	
				<tr><td>&nbsp;</td><td align="right">
					<input type="submit" name="simpan" value="simpan" class="myButton1" />&nbsp;
                <a href="#" onclick="window.close();" /><input type="button" name="batal" value="tutup" class="myButton1" /></a>
					</td></tr>
			</table>
<?php }	else if($resep_tp == '3'){ ?>
			<table class="tableform" border="0" width="100%">	
				<tr><td width="200">Nama Obat</td>
					<td><input type="text" name="resep" id="resep" class="text_dt" value="<?php echo $resep; ?>" style="width:450px" onblur="Javascript : get_satuan(this.value); return false;" /></td></tr>
				<tr><td>Jumlah</td>
					<td><input type="text" name="jumlah" id="jumlah" class="text_dt" value="<?php echo $jumlah; ?>" style="width:100px" >&nbsp;<span id="satuan" ><?php echo $satuan; ?></span></td></tr>	
				<tr><td>&nbsp;</td><td align="right">
					<input type="submit" name="simpan" value="simpan" class="myButton1" />&nbsp;
                <a href="#" onclick="window.close();" /><input type="button" name="batal" value="tutup" class="myButton1" /></a>
					</td></tr>
			</table>
<?php } ?>
	<input type="hidden" name="resep_id" value="<?php echo $resep_id; ?>" />
	<input type="hidden" name="irna_id" value="<?php echo $irna_id; ?>" />
	<input type="hidden" name="resep_tp" value="<?php echo $resep_tp; ?>" />
</form>
</div>
</body>