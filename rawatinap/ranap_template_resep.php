<?php
$searchkey = '';
if (isset($_SESSION['ranaptemplateresep_searchkey']))
		$searchkey = $_SESSION['ranaptemplateresep_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['ranaptemplateresep_searchkey'] = $searchkey;
}

$arr_aturan_pakai = getResepAturanPakai();
$arr_satuan_resep = getResepSatuan();
$arr_waktu_pakai = getResepWaktuPakai();

$qry_resep = 'SELECT t_irna_template_resep.IRNA_TEMPLATE_RESEP_ID,t_irna_template_resep.NAMA_RESEP,
			t_irna_template_resep.DOSIS,t_irna_template_resep.GENERIK,
			t_irna_template_resep.PSIKOTROPIKA,t_irna_template_resep.NO_TEMPLATE,
			t_irna_template_resep.RESEP,t_irna_template_resep.JUMLAH_KELUAR,t_irna_template_resep.SATUAN,
			t_irna_template_resep.FORMULARIUM,t_irna_template_resep.FORMULARIUM_NASIONAL,
			t_irna_template_resep.SATUAN_DOSIS,t_irna_template_resep.WAKTU_PAKAI
			FROM t_irna_template_resep
			WHERE t_irna_template_resep.PEGAWAI_ID = "' . $_SESSION['SES_SIMRS_PEGAWAI_ID'] . '"
			AND t_irna_template_resep.RACIKAN IS NULL';
if(!empty($searchkey)) $qry_resep = $qry_resep . ' AND t_irna_template_resep.NAMA_RESEP LIKE = "' . $searchkey . '"'; 			
$qry_resep = $qry_resep . ' ORDER BY t_irna_template_resep.NO_TEMPLATE,t_irna_template_resep.IRNA_TEMPLATE_RESEP_ID';
$get_resep = mysql_query($qry_resep) or die(mysql_error());
?>
<br />
<br />
<form name="form2" method="post" action="index.php">
   <input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />
    <table border="0" width="100%" class="tableNav">
        <tr>
            <td align="right">
                <input type="text" name="searchkey" class="text_dt" id="searchkey" value="<?php echo $searchkey; ?>" />&nbsp;&nbsp;<input type="submit" value="cari" class="myButton" />
				&nbsp;<a href="index.php?link=<?php echo md5('ranaptemplateresepobatadd'); ?>"><input type="button" value="tambah" class="myButton" /></a>
			</td>			
        </tr> 
	</table>
<div id="tabdata">
<table class="tableData" id="tfhover">
<tr>
    <th width="30">No</th>
	<th>Nama Resep</th>
	<th>Nama Obat</th>
	<th>Jumlah</th>
	<th>Satuan</th>
	<th>Aturan Pakai</th>
	<th>Waktu Pakai</th>
    <th>Generik</th>
	<th>Psikotropika</th>
	<th>Form RS</th>
	<th>Form Nas</th>
    <th width="100">Option</th>
</tr>
<?php
$i = 1;
$no_resepx = '';
$no_resepy = '';
$no_resep = '';
while ($dat_resep = mysql_fetch_array($get_resep)) {
    ?>
    <tr>
        <td align="center"><?php if($no_resepy != $dat_resep['NO_TEMPLATE']){
						$no_resepy = $dat_resep['NO_TEMPLATE'];
						echo $i;  
						$i++;
				} ?></td>
        <td><?php if($no_resep != $dat_resep['NO_TEMPLATE']){
						echo $dat_resep['NAMA_RESEP'];  
						$no_resep = $dat_resep['NO_TEMPLATE'];
				} ?></td>
		<td><?php echo $dat_resep['RESEP']; ?></td>
		<td align="right"><?php echo $dat_resep['JUMLAH_KELUAR']; ?></td>
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
		<td>
		<?php $arr_wkp = explode('|',$dat_resep['WAKTU_PAKAI']);
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
	?>
		</td>
		<td align="center"><?php if($dat_resep['GENERIK'] == '1') echo '&radic;'; ?></td>
		<td align="center"><?php if($dat_resep['PSIKOTROPIKA'] == '1') echo '&radic;'; ?></td>
		<td align="center"><?php if($dat_resep['FORMULARIUM'] == '1') echo '&radic;'; ?></td>
		<td align="center"><?php if($dat_resep['FORMULARIUM_NASIONAL'] == '1') echo '&radic;'; ?></td>
        <td align="center">
			<?php if($no_resepx != $dat_resep['NO_TEMPLATE']){ 
				$no_resepx = $dat_resep['NO_TEMPLATE']; ?>
			<a href="#" onclick="JavaScript: del_template('<?php echo $dat_resep['NO_TEMPLATE']; ?>'); open_location(); return false;" >hapus</a>
			<?php } ?>
			</td>
    </tr>
    <?php }
?>
</table>
</div>
</form>
<script language="JavaScript" >
function del_template(id){
	if(confirm('Yakin Dihapus?')){
		MyAjaxRequest('tabdata','index.php?ajaxrequest=ranapdeltemplateresepobat&resep_id=' + id);
	}	
}
</script>