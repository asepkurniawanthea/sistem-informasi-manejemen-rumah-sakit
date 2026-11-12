<?php
$searchkey = '';
if (isset($_SESSION['hemodialisatemplateresep_searchkey']))
		$searchkey = $_SESSION['hemodialisatemplateresep_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['hemodialisatemplateresep_searchkey'] = $searchkey;
}

$qry_resep = 'SELECT t_hemodialisa_template_resep.HEMODIALISA_TEMPLATE_RESEP_ID,t_hemodialisa_template_resep.NAMA_RESEP,
			t_hemodialisa_template_resep.DOSIS,t_hemodialisa_template_resep.GENERIK,
			t_hemodialisa_template_resep.PSIKOTROPIKA
			FROM t_hemodialisa_template_resep
			WHERE t_hemodialisa_template_resep.PEGAWAI_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '"
			AND t_hemodialisa_template_resep.RACIKAN = "1"';
if(!empty($searchkey)) $qry_resep = $qry_resep . ' AND t_hemodialisa_template_resep.NAMA_RESEP LIKE = "' . $searchkey . '"'; 			
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
				&nbsp;<a href="index.php?link=<?php echo md5('hemodialisatemplateresepadd'); ?>"><input type="button" value="tambah" class="myButton" /></a>
			</td>			
        </tr> 
	</table>
<div id="tabdata">	
<table class="tableData" id="tfhover">
<tr>
    <th width="30">No</th>
	<th>Nama Resep Racikan</th>
	<th>Aturan Pakai</th>
	<th>Nama Obat</th>
	<th>Jumlah</th>
	<th>Satuan</th>
    <th width="60">Generik</th>
	<th width="60">Psikotropika</th>
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
		<td><?php echo $dat_resep['DOSIS']; ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td align="center"><?php if($dat_resep['GENERIK'] == '1') echo '&radic;'; ?></td>
		<td align="center"><?php if($dat_resep['PSIKOTROPIKA'] == '1') echo '&radic;'; ?></td>
		<td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
        <td align="center"><a href="#" onclick="JavaScript: del_template('<?php echo $dat_resep['HEMODIALISA_TEMPLATE_RESEP_ID']; ?>'); open_location(); return false;" >hapus</a></td>
    </tr>
    <?php
			$sql_racikan = 'SELECT t_hemodialisa_template_resep_racikan.HEMODIALISA_TEMPLATE_RESEP_RACIKAN_ID,
							t_hemodialisa_template_resep_racikan.RESEP,t_hemodialisa_template_resep_racikan.PERSEDIAAN_ID,
							t_hemodialisa_template_resep_racikan.JUMLAH_KELUAR,t_hemodialisa_template_resep_racikan.SATUAN,
							t_hemodialisa_template_resep_racikan.FORMULARIUM,t_hemodialisa_template_resep_racikan.FORMULARIUM_NASIONAL
							FROM t_hemodialisa_template_resep_racikan
							WHERE t_hemodialisa_template_resep_racikan.HEMODIALISA_TEMPLATE_RESEP_ID = "' . $dat_resep['HEMODIALISA_TEMPLATE_RESEP_ID'] . '"';
			$get_racikan = mysql_query($sql_racikan) or die(mysql_error());
			while($dat_racikan = mysql_fetch_array($get_racikan)){
			?>
			 <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><?php echo $dat_racikan['RESEP']; ?></td>
				<td><?php echo $dat_racikan['JUMLAH_KELUAR']; ?></td>
				<td><?php echo $dat_racikan['SATUAN']; ?></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
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
		MyAjaxRequest('tabdata','index.php?ajaxrequest=hemodialisadeltemplateresep&resep_id=' + id);
	}	
}
</script>