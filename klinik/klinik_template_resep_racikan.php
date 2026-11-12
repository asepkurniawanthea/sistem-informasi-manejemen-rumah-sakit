<?php
$searchkey = '';
if (isset($_SESSION['kliniktemplateresep_searchkey']))
		$searchkey = $_SESSION['kliniktemplateresep_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['kliniktemplateresep_searchkey'] = $searchkey;
}

$arr_nama_racikan = getResepNamaRacikan();
$arr_aturan_pakai = getResepAturanPakai();
$arr_satuan_resep = getResepSatuan();
$arr_waktu_pakai = getResepWaktuPakai();

$qry_resep = 'SELECT *
			FROM t_irja_template_resep
			WHERE PEGAWAI_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '"
			AND RACIKAN = "1"';
if(!empty($searchkey)) $qry_resep = $qry_resep . ' AND t_irja_template_resep.NAMA_RESEP LIKE = "' . $searchkey . '"'; 			
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
				&nbsp;<a href="index.php?link=<?php echo md5('kliniktemplateresepadd'); ?>"><input type="button" value="tambah" class="myButton" /></a>
			</td>			
        </tr> 
	</table>
<div id="tabdata">
<table class="tableData" id="tfhover">
<tr>
    <th width="30">No</th>
	<th>Nama Resep</th>
	<th>Nama Racikan</th>
	<th>Aturan Pakai</th>
	<th>Waktu Pakai</th>
	<th>Generik</th>
	<th>Psikotropika</th>
	<th>Nama Obat</th>
	<th>Jumlah</th>
	<th>Satuan</th>
	<th>Form RS</th>
	<th>Form Nas</th>
    <th width="100">Option</th>
</tr>
<?php
$i = 1;
while ($dat_resep = mysql_fetch_array($get_resep)) {
    ?>
    <tr>
        <td align="center"><?php echo $i; ?></td>
        <td><?php echo $dat_resep['NAMA_RESEP']; ?></td>
		<td><?php $arr_nmr = explode('|',$dat_resep['NAMA_RACIKAN']);
						$nmr = '';
						foreach($arr_nmr as $row){
							if(is_numeric($row)){
								$nmr .= $arr_nama_racikan[$row] . ',';
							}else{
								$nmr .= $row . ',';
							}
						}
						echo substr($nmr,0,strlen($nmr)-1); ?></td>
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
		<td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
        <td align="center"><a href="#" onclick="JavaScript: del_template('<?php echo $dat_resep['IRJA_TEMPLATE_RESEP_ID']; ?>'); open_location(); return false;" >hapus</a></td>
    </tr>
    <?php
			$sql_racikan = 'SELECT *
							FROM t_irja_template_resep_racikan
							WHERE IRJA_TEMPLATE_RESEP_ID = "' . $dat_resep['IRJA_TEMPLATE_RESEP_ID'] . '"';
			$get_racikan = mysql_query($sql_racikan) or die(mysql_error());
			while($dat_racikan = mysql_fetch_array($get_racikan)){
			?>
			 <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><?php echo $dat_racikan['RESEP']; ?></td>
				<td><?php echo $dat_racikan['JUMLAH_KELUAR']; ?></td>
				<td><?php echo $dat_racikan['SATUAN']; ?></td>
				<td align="center"><?php if($dat_racikan['FORMULARIUM'] == '1') echo '&radic;'; ?></td>
				<td align="center"><?php if($dat_racikan['FORMULARIUM_NASIONAL'] == '1') echo '&radic;'; ?></td>
				<td align="center">&nbsp;</td>
			</tr>
			<?php
			}	
		$i++; }
?>
</table>
</div>
</form>
<script language="JavaScript" >
function del_template(id){
	if(confirm('Yakin Dihapus?')){
		MyAjaxRequest('tabdata','index.php?ajaxrequest=klinikdeltemplateresep&resep_id=' + id);
	}	
}
</script>