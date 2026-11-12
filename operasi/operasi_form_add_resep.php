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
$racikan = '';
if(isset($_GET['racikan'])) $racikan = '1';
$resep = '';
$jumlah = '';
$dosis = '';
$dosis_lain = '';
$satuan_dosis = '';
$satuan_lain = '';
$waktu_pakai = '';
$waktu_lain = '';

$nama_racikan = '';
$racikan_lain = '';

$generik = '';
$psikotropika = '';
$resep_id = '';

$arr_aturan_pakai = getResepAturanPakai();
$arr_satuan_resep = getResepSatuan();
$arr_waktu_pakai = getResepWaktuPakai();
$arr_nama_racikan = getResepNamaRacikan();

$arr_atp = array();
$arr_str = array();
$arr_wkp = array();
$arr_nrc = array();

if(isset($_POST['tambah'])){
	include('operasi/operasi_save_add_resep.php');
}
if(isset($_POST['tambahracikan'])){
	include('operasi/operasi_save_add_resep_racikan.php');
}
?>
<body>
<div class="div_menu" style=" height:auto; position:relative; padding:0px; padding-top:3px; padding-bottom:3px; border:1px solid #999; border-radius:5px; margin:5px; margin-top:7px; background-color:#C8EFAD;">
<form name="formedit" method="post" >
	<table width="100%" border="0">
	<tr>
		<td width="15">&nbsp;</td>
		<td>Racikan&nbsp;&nbsp;<input type="checkbox" name="racikan" id="racikan" value="1" onclick="JavaScript : racikan_opt();" <?php if ($racikan == '1') echo 'checked="checked"'; ?> /></td>
	</tr>
	</table>
	<?php if(!isset($_GET['racikan'])){ ?>
    <table class="tableform" border="0" width="100%">	
		<tr><td width="100">Nama Obat</td>
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
		<tr><td>&nbsp;</td>
			<td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td><td>Generik&nbsp;&nbsp;<input type="checkbox" name="generik" id="generik" value="1" <?php if ($generik == '1') echo 'checked="checked"'; ?> />&nbsp;&nbsp;
		Psikotropika&nbsp;&nbsp;<input type="checkbox" name="psikotropika" id="psikotropika" value="1" <?php if ($psikotropika == '1') echo 'checked="checked"'; ?> />
			</td></tr>	
        <tr><td>&nbsp;</td><td align="right">
                <input type="submit" name="tambah" value="tambah" class="myButton1" />&nbsp;
                <a href="#" onclick="window.close();" /><input type="button" name="batal" value="tutup" class="myButton1" /></a>
            </td></tr>
    </table>
	<?php }else{ ?>
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
					<td><input type="text" name="resep" id="resep" class="text_dt" value="<?php echo $resep; ?>" style="width:450px" onblur="Javascript : get_satuan(this.value); return false;" /></td></tr>
				<tr><td>Jumlah</td>
					<td><input type="text" name="jumlah" id="jumlah" class="text_dt" value="<?php echo $jumlah; ?>" style="width:100px" >&nbsp;<span id="satuan" ></span></td></tr>	
				<tr><td>&nbsp;</td><td align="right">
					<input type="submit" name="tambahracikan" value="tambah" class="myButton1" />&nbsp;
                <a href="#" onclick="window.close();" /><input type="button" name="batal" value="tutup" class="myButton1" /></a>
					</td></tr>
			</table>
	<?php } ?>
	<input type="hidden" name="operasi_id" value="<?php echo $_GET['idx']; ?>" />
	<input type="hidden" name="nomr" value="<?php echo $_GET['nomr']; ?>" />
	<input type="hidden" name="resep_id" value="<?php echo $resep_id; ?>" />
</form>
</div>
<?php if(isset($_GET['racikan'])){
$sql_racikan = 'SELECT  t_operasi_resep_racikan.OPERASI_RESEP_RACIKAN_ID,t_operasi_resep_racikan.OPERASI_RESEP_ID,
				t_operasi_resep_racikan.RESEP,t_operasi_resep_racikan.JUMLAH,t_operasi_resep_racikan.SATUAN
				FROM t_operasi_resep_racikan WHERE t_operasi_resep_racikan.OPERASI_RESEP_ID = "' . $resep_id . '"';
$get_racikan = mysql_query($sql_racikan) or die(mysql_error());
if(mysql_num_rows($get_racikan) > 0){				
?>
<div id="tbl_racikan" >
<div class="div_menu" style=" height:auto; position:relative; padding:0px; padding-top:3px; padding-bottom:3px; border:1px solid #999; border-radius:5px; margin:5px; margin-top:7px; background-color:#C8EFAD;">
<table width="95%" class="tableData" id="tfhover">
<?php while($dat_racikan = mysql_fetch_array($get_racikan)){ ?>
<tr>
	<td><?php echo $dat_racikan['RESEP']; ?></td>
	<td width="100"><?php echo $dat_racikan['JUMLAH']; ?></td>
	<td width="100"><?php echo $dat_racikan['SATUAN']; ?></td>
	<td width="10"><a href="#" onclick="javascript : MyAjaxRequest('tbl_racikan','index.php?ajaxrequest=operasidelracikan&racikan_id=<?php echo $dat_racikan['OPERASI_RESEP_RACIKAN_ID']; ?>&resep_id=<?php echo $dat_racikan['OPERASI_RESEP_ID']; ?>');return false;" >hapus</a></td>
</tr>
<?php } ?>
<tr>
	<td colspan="4" align="right"><input type="button" value="selesai racikan" class="myButton1" onclick="JavaScript : selesai_racikan();" /></td>
</tr>
</table>
</div>
</div>
<?php } } 
			
$qry_last_resep = 'SELECT DISTINCT t_operasi_resep.NO_RESEP,
	DATE_FORMAT(t_operasi_resep.TGL_RESEP,"%d/%m/%Y") AS TGL_RESEP,
	m_pegawai.NAMA_PEGAWAI
	FROM t_operasi_resep
	LEFT JOIN m_pegawai
	ON (t_operasi_resep.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
	WHERE OPERASI_ID = "' . $_GET['idx'] . '" 
	AND t_operasi_resep.NO_RESEP IS NOT NULL
	ORDER BY t_operasi_resep.TGL_RESEP,t_operasi_resep.NO_RESEP';
$get_last_resep = mysql_query($qry_last_resep) or die(mysql_error());
if(mysql_num_rows($get_last_resep) > 0){ ?>	
<div class="div_menu" style=" height:auto; position:relative; padding:0px; padding-top:3px; padding-bottom:3px; border:1px solid #999; border-radius:5px; margin:5px; margin-top:7px; background-color:#C8EFAD;">
	<table class="tableData" border="0" width="100%">
		<tr><td colspan="7"><strong>Copy Resep</strong></td></tr>	
<?php
	$no = 1;	
	while($dat_last_resep = mysql_fetch_array($get_last_resep)){ ?>
		<tr>
			<td><?php echo $no; ?></td>
			<td colspan="7"><?php echo $dat_last_resep['NO_RESEP'] . ' - ' . $dat_last_resep['TGL_RESEP'] . ' - ' . $dat_last_resep['NAMA_PEGAWAI']; ?></td>
		</tr>	
		<?php $qry_resep = 'SELECT t_operasi_resep.OPERASI_ID,t_operasi_resep.RESEP,t_operasi_resep.RACIKAN,t_operasi_resep.GENERIK,
			t_operasi_resep.NO_RESEP,t_operasi_resep.ST_RESEP,t_operasi_resep.OPERASI_RESEP_ID,
			t_operasi_resep.DOSIS,t_operasi_resep.JUMLAH,t_operasi_resep.PSIKOTROPIKA,
			t_operasi_resep.SATUAN,t_operasi_resep.FORMULARIUM,t_operasi_resep.FORMULARIUM_NASIONAL,
			t_operasi_resep.JUMLAH_KELUAR,t_operasi_resep.HARGA,t_operasi_resep.SATUAN_DOSIS,
			t_operasi_resep.WAKTU_PAKAI
			FROM t_operasi_resep
			WHERE NO_RESEP = "' . $dat_last_resep['NO_RESEP'] . '"
			ORDER BY t_operasi_resep.OPERASI_RESEP_ID';		
			$get_resep = mysql_query($qry_resep) or die(mysql_error());
			$y = 1; 
			$ret = '1';
			while ($dat_resep = mysql_fetch_array($get_resep)){ 
				if($dat_resep['JUMLAH'] == '' and $dat_resep['RACIKAN'] == '') $ret = '2'; 
				if($dat_resep['DOSIS'] == '') $ret = '2'; 
				if($dat_resep['SATUAN_DOSIS'] == '') $ret = '2'; 
				if($dat_resep['WAKTU_PAKAI'] == '') $ret = '2';
					
				$resep = $dat_resep['RESEP'];
				if($dat_resep['RACIKAN'] == '1'){
					$resep = '';
					$arr_nmr = explode('|',$dat_resep['RESEP']);
						foreach($arr_nmr as $row){
							if(is_numeric($row)){
								$resep .= $arr_nama_racikan[$row] . ',';
							}else{
								$resep .= $row . ',';
							}
						}
					$resep = substr($resep,0,strlen($resep)-1); 
				} ?> 
					<tr>
					<td width="10">&nbsp;</td>
					<td><?php echo $resep; ?></td>
					<td align="right"><?php echo $dat_resep['JUMLAH']; ?></td>
					<td><?php echo $dat_resep['SATUAN']; ?></td>
					<td><?php $arr_atp = explode('|',$dat_resep['DOSIS']);
						$atp = '';
						foreach($arr_atp as $row){
							if(is_numeric($row)){
								$atp .= $arr_aturan_pakai[$row] . ',';
							}else{
								$atp .= $row . ',';
							}
						}
						echo substr($atp,0,strlen($atp)-1);
										
						$arr_str = explode('|',$dat_resep['SATUAN_DOSIS']);
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
					<td><?php 
						$arr_wkp = explode('|',$dat_resep['WAKTU_PAKAI']);
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
					<td align="center"><?php if($dat_resep['RACIKAN'] == '1') echo '&radic;'; ?></td>
					</tr>	
					<?php if($dat_resep['RACIKAN'] == '1'){ 
							$sql_racikan = 'SELECT t_operasi_resep_racikan.OPERASI_RESEP_RACIKAN_ID,t_operasi_resep_racikan.RESEP,t_operasi_resep_racikan.JUMLAH,
								t_operasi_resep_racikan.SATUAN,t_operasi_resep_racikan.FORMULARIUM,t_operasi_resep_racikan.FORMULARIUM_NASIONAL,
								t_operasi_resep_racikan.JUMLAH_KELUAR,t_operasi_resep_racikan.HARGA
								FROM t_operasi_resep_racikan 
								WHERE t_operasi_resep_racikan.OPERASI_RESEP_ID = "' . $dat_resep['OPERASI_RESEP_ID'] . '"';
							$get_racikan = mysql_query($sql_racikan) or die(mysql_error());
							while($dat_racikan = mysql_fetch_array($get_racikan)){ 
								if($dat_racikan['JUMLAH'] == '') $ret = '2'; ?>
								<tr>
								<td>&nbsp;</td>
								<td><?php echo $dat_racikan['RESEP']; ?></td>
								<td align="right"><?php echo $dat_racikan['JUMLAH']; ?></td>
								<td><?php echo $dat_racikan['SATUAN']; ?></td>
								<td align="center" colspan="3">&nbsp;</td>
								</tr>
					<?php } }  $y++; } 
					$ret = '1';
					?>
					<tr>
						<td colspan="7" align="right"><a href="#" onclick="JavaScript : copy_resep('<?php echo $_GET['idx']; ?>','<?php echo $dat_last_resep['NO_RESEP'];  ?>','<?php echo $ret;  ?>'); return false;" >copy resep</a>
						</td>
					</tr>
				<?php $no++;
	}
	echo '</table></div>';
}		
	//paket obat 
	$arr_paket_obat = getPaketObat();
	if(sizeof($arr_paket_obat) > 0){
			echo '<div class="div_menu" style=" height:auto; position:relative; padding:0px; padding-top:3px; padding-bottom:3px; border:1px solid #999; border-radius:5px; margin:5px; margin-top:7px; background-color:#C8EFAD;">';
			echo '<table class="tableData" border="0" width="100%">';
			echo '<tr><td colspan="3"><strong>Paket Obat</strong>&nbsp;&nbsp;&nbsp;';
			echo '<select name="paket_obat" class="text_dt" style="width:340px;" onchange="pilih_paket(this.value); return false;">';
			echo '<option value=""> - </option>';
			foreach($arr_paket_obat as $key=>$val){
				echo '<option value="' . $key . '">' . $val . '</option>';
			}
			echo '</select>';
			echo '</th></tr>';
			echo '</table>';
			echo '<div id="paket_obat"></div>';
			echo '</div>';
		}
	//
	
	$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
	mysql_select_db($database, $connect) or die(mysql_error());
	$sql = 'SELECT t_irna_template_resep.NAMA_RESEP,t_irna_template_resep.NO_TEMPLATE,
			SUM(CASE WHEN t_irna_template_resep.RESEP IS NULL OR t_irna_template_resep.RESEP = "" THEN 1 END) AS T_RESEP,
			SUM(CASE WHEN t_irna_template_resep.DOSIS IS NULL OR t_irna_template_resep.DOSIS = "" THEN 1 END) AS T_DOSIS,
			SUM(CASE WHEN t_irna_template_resep.SATUAN_DOSIS IS NULL OR t_irna_template_resep.SATUAN_DOSIS = "" THEN 1 END) AS T_SATUAN_DOSIS,
			SUM(CASE WHEN t_irna_template_resep.WAKTU_PAKAI IS NULL OR t_irna_template_resep.WAKTU_PAKAI = "" THEN 1 END) AS T_WAKTU_PAKAI,
			SUM(CASE WHEN t_irna_template_resep.JUMLAH_KELUAR IS NULL OR t_irna_template_resep.JUMLAH_KELUAR = 0 THEN 1 END) AS T_JUMLAH_KELUAR
			FROM t_irna_template_resep
			WHERE t_irna_template_resep.PEGAWAI_ID = "' . $_SESSION['SES_SIMRS_PEGAWAI_ID'] . '"
			AND t_irna_template_resep.RACIKAN IS NULL
			GROUP BY t_irna_template_resep.NAMA_RESEP,t_irna_template_resep.NO_TEMPLATE';
	$get = mysql_query($sql) or die(mysql_error());
		if(mysql_num_rows($get) > 0){
			echo '<div class="div_menu" style=" height:auto; position:relative; padding:0px; padding-top:3px; padding-bottom:3px; border:1px solid #999; border-radius:5px; margin:5px; margin-top:7px; background-color:#C8EFAD;">';
			echo '<table class="tableData" border="0" width="100%">';
			echo '<tr><td colspan="3"><strong>Template Resep</strong></th></tr>';
			$y = 1;
			while($dat = mysql_fetch_array($get)){
				$ret = '1';
				if($dat['T_RESEP'] > 0 or $dat['T_DOSIS'] > 0 or $dat['T_SATUAN_DOSIS'] > 0 or $dat['T_WAKTU_PAKAI'] > 0 or $dat['T_JUMLAH_KELUAR'] > 0) $ret = '2';
				?>
				<tr>
					<td width="10"><?php echo $y; ?></td>
					<td><?php echo $dat['NAMA_RESEP']; ?></td>
					<td width="20">
					<a href="#" onclick="JavaScript : add_resep('<?php echo $dat['NO_TEMPLATE']; ?>','<?php echo $_GET['idx']; ?>','<?php echo $ret; ?>'); return false;" >tambah</a>	
					</td>
				</tr>
				<?php
			$y++; }
			echo '</table>';
			echo '</div>';
		}		
			
	$sql = 'SELECT t_irna_template_resep.IRNA_TEMPLATE_RESEP_ID,t_irna_template_resep.NAMA_RESEP,
			SUM(CASE WHEN t_irna_template_resep_racikan.RESEP IS NULL OR t_irna_template_resep.RESEP = "" THEN 1 END) AS T_RESEP,
			SUM(CASE WHEN t_irna_template_resep.DOSIS IS NULL OR t_irna_template_resep.DOSIS = "" THEN 1 END) AS T_DOSIS,
			SUM(CASE WHEN t_irna_template_resep.SATUAN_DOSIS IS NULL OR t_irna_template_resep.SATUAN_DOSIS = "" THEN 1 END) AS T_SATUAN_DOSIS,
			SUM(CASE WHEN t_irna_template_resep.WAKTU_PAKAI IS NULL OR t_irna_template_resep.WAKTU_PAKAI = "" THEN 1 END) AS T_WAKTU_PAKAI,
			SUM(CASE WHEN t_irna_template_resep_racikan.JUMLAH_KELUAR IS NULL OR t_irna_template_resep_racikan.JUMLAH_KELUAR = 0 THEN 1 END) AS T_JUMLAH_KELUAR
			FROM t_irna_template_resep
			INNER JOIN t_irna_template_resep_racikan
			ON (t_irna_template_resep.IRNA_TEMPLATE_RESEP_ID = t_irna_template_resep_racikan.IRNA_TEMPLATE_RESEP_ID)
			WHERE t_irna_template_resep.PEGAWAI_ID = "' . $_SESSION['SES_SIMRS_PEGAWAI_ID'] . '"
			AND t_irna_template_resep.RACIKAN = "1"
			GROUP BY t_irna_template_resep.IRNA_TEMPLATE_RESEP_ID,t_irna_template_resep.NAMA_RESEP';
	$get = mysql_query($sql) or die(mysql_error());
		if(mysql_num_rows($get) > 0){
			echo '<div class="div_menu" style=" height:auto; position:relative; padding:0px; padding-top:3px; padding-bottom:3px; border:1px solid #999; border-radius:5px; margin:5px; margin-top:7px; background-color:#C8EFAD;">';
			echo '<table class="tableData" border="0" width="100%">';
			echo '<tr><td colspan="3"><strong>Template Resep Racikan</strong></td></tr>';
			$y = 1;
			while($dat = mysql_fetch_array($get)){
				$ret = '1';
				if($dat['T_RESEP'] > 0 or $dat['T_DOSIS'] > 0 or $dat['T_SATUAN_DOSIS'] > 0 or $dat['T_WAKTU_PAKAI'] > 0 or $dat['T_JUMLAH_KELUAR'] > 0) $ret = '2';
				?>
				<tr>
					<td width="10"><?php echo $y; ?></td>
					<td><?php echo $dat['NAMA_RESEP']; ?></td>
					<td width="20">
					<a href="#" onclick="JavaScript : add_racikan('<?php echo $dat['IRNA_TEMPLATE_RESEP_ID']; ?>','<?php echo $_GET['idx']; ?>','<?php echo $ret; ?>'); return false;" >tambah</a>	
					</td>
				</tr>
				<?php
			$y++; }
			echo '</table>';
			echo '</div>';
		}
?>		
</body>
<script language="JavaScript" >
function racikan_opt(){
	if(document.getElementById("racikan").checked){
		window.location = "index.php?popup=operasiformresep&idx=<?php echo $_GET['idx']; ?>&racikan=1";
	}else{
		window.location = "index.php?popup=operasiformresep&idx=<?php echo $_GET['idx']; ?>";
	}
}

function selesai_racikan(){
	window.location = "index.php?popup=operasiformresep&idx=<?php echo $_GET['idx']; ?>";
	setTimeout(opener.location.reload(), 3000);
}

function get_satuan(resep){
	MyAjaxRequest('satuan','index.php?ajaxrequest=kliniksatuanresep&resep=' + resep);
}

function add_racikan(idresep,idx,ret){
	/*
	if(ret == '2'){
		alert('Isian Resep Tidak Lengkap.');
	}else{	
		MyAjaxRequest('satuan','index.php?ajaxrequest=operasireseptemplateadd&resep=' + idresep + '&idx=' + idx);
		setTimeout(opener.location.reload(), 3000);
	}	*/
}

function add_resep(idresep,idx,ret){
	if(ret == '2'){
		alert('Isian Resep Tidak Lengkap.');
	}else{	
		//MyAjaxRequest('satuan','index.php?ajaxrequest=operasireseptemplateaddobat&resep=' + idresep + '&idx=' + idx);
		setTimeout(opener.location.reload(), 3000);
	}	
}

function copy_resep(idx, idx2, ret){
	if(ret == '2'){
		alert('Isian Resep Tidak Lengkap.');
	}else{
		//MyAjaxRequest('satuan','index.php?ajaxrequest=operasiresepcopy&idx=' + idx + '&idx2=' + idx2);
		alert('Resep Sudah Dicopy.');
		setTimeout(opener.location.reload(), 3000);	
	}
}

function pilih_paket(idx){
	if(idx !== ''){
		//MyAjaxRequest('paket_obat','index.php?ajaxrequest=paketobat&idx=' + idx);
	}
}

function add_paket(cn){
	/*
	var form_data = $('#form_paket').serialize();
	$.ajax({
		type: 'POST',
		url: 'index.php?ajaxrequest=operasiaddpaketobat&cn=' + cn + '&idx=<?php echo $_GET['idx']; ?>', 
		data: form_data,
		cache: false,
		success: function(data) {
			setTimeout(opener.location.reload(), 3000);	
			if(data == '1'){
				alert('Resep Sudah Ditambahkan.');
			}	
	},});*/
}
</script>