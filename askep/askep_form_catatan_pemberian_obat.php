<style>
html {
	background:url(image/bg_pattern1.jpg);

}
</style>
<?php 
$irna_id = $_GET['idx'];

if (isset($_POST['irna_id'])){
	$dokter_new = $_POST['dokter_new'];
	$obat_new = $_POST['obat_new'];
	$dosis_new = $_POST['dosis_new'];
	$aturan_new = $_POST['aturan_new'];
	if(!empty($_POST['dokter_new']) or !empty($_POST['obat_new']) 
		or !empty($_POST['dosis_new']) or !empty($_POST['aturan_new'])){
			$nama_dokter = '';
			if(!empty($_POST['dokter_new'])){
				$sql_dokter = 'SELECT NAMA_PEGAWAI FROM m_pegawai WHERE PEGAWAI_ID = "' . $_POST['dokter_new'] . '"';
				$get_dokter = mysql_query($sql_dokter) or die(mysql_error());
				$dat_dokter = mysql_fetch_assoc($get_dokter);
				$nama_dokter = $dat_dokter['NAMA_PEGAWAI'];
			}	
			mysql_query('INSERT INTO t_irna_askep_pemberian_obat (DOKTER,NAMA_OBAT,DOSIS,ATURAN_PAKAI,IRNA_ID,CATATAN)
				VALUES ("' . $nama_dokter . '","' . $_POST['obat_new'] . '","' . $_POST['dosis_new'] . '",
				"' . $_POST['aturan_new'] . '","' . $_POST['irna_id'] . '","' . $_POST['catatan'] . '")') or die(mysql_error());
	}	

	$cn_row = $_POST['cn_row'];	
	$y = 1;
	while($y < $cn_row){
		$id_pem = $_POST['pemb_id_' . $y];
		$id_pem_det = $_POST['pemb_id_det_' . $y];
		mysql_query('UPDATE t_irna_askep_pemberian_obat SET DOKTER = "' . $_POST['dokter_' . $y] . '",
			NAMA_OBAT = "' . $_POST['obat_' . $y] . '",
			DOSIS = "' . $_POST['dosis_' . $y] . '",
			ATURAN_PAKAI = "' . $_POST['aturan_' . $y] . '",
			CATATAN = "' . $_POST['catatan'] . '"
			WHERE PEMBERIAN_OBAT_ID = "' . $_POST['pemb_id_' . $y] . '"') or die(mysql_error());
		
		if($id_pem_det != ''){
			mysql_query('UPDATE t_irna_askep_pemberian_obat_detail 
				SET TANGGAL = STR_TO_DATE("' . $_POST['tanggal'] . '","%d/%m/%Y"),
				JAM_1 = "' . $_POST['jam1_' . $y] . ':' . $_POST['menit1_' . $y] . '",
				JAM_2 = "' . $_POST['jam2_' . $y] . ':' . $_POST['menit2_' . $y] . '",
				JAM_3 = "' . $_POST['jam3_' . $y] . ':' . $_POST['menit3_' . $y] . '",
				JAM_4 = "' . $_POST['jam4_' . $y] . ':' . $_POST['menit4_' . $y] . '",
				KETERANGAN = "' . $_POST['keterangan_' . $y] . '",
				REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
				PERAWAT_1 = "' . $_POST['perawat_1'] . '",
				PERAWAT_2 = "' . $_POST['perawat_2'] . '",
				PERAWAT_3 = "' . $_POST['perawat_3'] . '",
				PERAWAT_4 = "' . $_POST['perawat_4'] . '",
				ST_CREATE_ERM = NULL
				WHERE PEMBERIAN_OBAT_DETAIL_ID = "' . $_POST['pemb_id_det_' . $y] . '"') or die(mysql_error());
		}else{
			mysql_query('INSERT INTO t_irna_askep_pemberian_obat_detail
				(PEMBERIAN_OBAT_ID,TANGGAL,JAM_1,JAM_2,JAM_3,JAM_4,KETERANGAN,REGISTER,
				PERAWAT_1,PERAWAT_2,PERAWAT_3,PERAWAT_4)
				VALUES ("' . $_POST['pemb_id_' . $y] . '",
				STR_TO_DATE("' . $_POST['tanggal'] . '","%d/%m/%Y"),
				"' . $_POST['jam1_' . $y] . ':' . $_POST['menit1_' . $y] . '",
				"' . $_POST['jam2_' . $y] . ':' . $_POST['menit2_' . $y] . '",
				"' . $_POST['jam3_' . $y] . ':' . $_POST['menit3_' . $y] . '",
				"' . $_POST['jam4_' . $y] . ':' . $_POST['menit4_' . $y] . '",
				"' . $_POST['keterangan_' . $y] . '",
				"' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
				"' . $_POST['perawat_1'] . '",
				"' . $_POST['perawat_2'] . '",
				"' . $_POST['perawat_3'] . '",
				"' . $_POST['perawat_4'] . '")') or die(mysql_error());
		}		
		$y++;
	}	
	?>
	<script language="JavaScript" >
        alert('Simpan Data Catatan Pemberian Obat Berhasil.');
		window.location = "<?php echo currentUrl(); ?>";
    </script>	
	<?php
}	
?>
<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery("#obat").autocomplete("index.php?autocomp=autocompaskepfarmasi",{width: 450});
});
</script>

<?php
$sql_pemberian_obat = 'SELECT DISTINCT DATE_FORMAT(d.TANGGAL,"%d/%m/%Y") AS TANGGAL,
	DATE_FORMAT(d.TANGGAL,"%d%m%Y") AS TANGGAL_LNK
	FROM t_irna_askep_pemberian_obat o
	INNER JOIN t_irna_askep_pemberian_obat_detail d
	ON (o.PEMBERIAN_OBAT_ID = d.PEMBERIAN_OBAT_ID)
	WHERE o.IRNA_ID = "' . $irna_id . '"';
$get_pemberian_obat = mysql_query($sql_pemberian_obat) or die(mysql_error());	
if(mysql_num_rows($get_pemberian_obat) > 0){
?>
<table width="100%" border="1" class="tableData">
<tr>
<?php
$st_tr = '';
$x = 1;
while($dat_pemberian_obat = mysql_fetch_array($get_pemberian_obat)){ 
	echo '<td align="center"><a href="index.php?link=' . $_GET['link'] . '&smn=ctpo&idx=' . $_GET['idx'] . '&tgl=' . $dat_pemberian_obat['TANGGAL_LNK'] . '">' . $dat_pemberian_obat['TANGGAL'] . '</a></td>';
	if($x == 10){
		echo '</tr><tr>';
		$st_tr = '1';
		$x = 1;
	}	
	$x++;
} 
if($x < 10){
	$z = $x;
	while($z < 12){
		echo '<td align="center">&nbsp;</td>';
	$z++;
	}	
}	
if($st_tr == '') echo '</tr>';
?>
</table></br>
<?php } 
$ada_data = '';
$catatan = '';
$perawat_1 = '';
$perawat_2 = '';
$perawat_3 = '';
$perawat_4 = '';
$tanggal = date('d/m/Y');
if(isset($_GET['tgl'])){
	$tanggal = substr($_GET['tgl'],0,2) . '/' . substr($_GET['tgl'],2,2) . '/' . substr($_GET['tgl'],4,4);  
}	
?>
<form name="formedukasi" id="formedukasi" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />
    <table width="100%" border="1" class="tableData">
  <tr>
    <th>No</th>
    <th>Dokter</th>
    <th>Obat/ Injeksi </th>
    <th>Dosis</th>
    <th>Aturai Pakai </th>
    <th colspan="4">Jadwal Pemberian/ Tanggal <input type="text" name="tanggal" id="tgl_edu_1" value="<?php echo $tanggal; ?>" class="text_dt" style="width:80px;" />
	<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu1')"/></th>
    <th>Keterangan</th>
  </tr>
  <?php 
	$sql_pemberian_obat_ls = 'SELECT o.DOKTER,o.NAMA_OBAT,o.DOSIS,o.ATURAN_PAKAI,o.CATATAN,
		d.JAM_1,d.JAM_2,d.JAM_3,d.JAM_4,d.PERAWAT_1,d.PERAWAT_2,d.PERAWAT_3,d.PERAWAT_4,
		d.KETERANGAN,o.PEMBERIAN_OBAT_ID,d.PEMBERIAN_OBAT_DETAIL_ID
		FROM t_irna_askep_pemberian_obat o
		LEFT JOIN t_irna_askep_pemberian_obat_detail d
		ON (o.PEMBERIAN_OBAT_ID = d.PEMBERIAN_OBAT_ID AND d.TANGGAL = STR_TO_DATE("' . $tanggal . '","%d/%m/%Y"))
		WHERE o.IRNA_ID = "' . $irna_id . '"';
	$i = 1;
	$get_pemberian_obat_ls = mysql_query($sql_pemberian_obat_ls) or die(mysql_error());
	while($dat_pemberian_obat_ls = mysql_fetch_array($get_pemberian_obat_ls)){ 
		$catatan = $dat_pemberian_obat_ls['CATATAN'];
		$arr_jam_1 = explode(':',$dat_pemberian_obat_ls['JAM_1']);
		$arr_jam_2 = explode(':',$dat_pemberian_obat_ls['JAM_2']);
		$arr_jam_3 = explode(':',$dat_pemberian_obat_ls['JAM_3']);
		$arr_jam_4 = explode(':',$dat_pemberian_obat_ls['JAM_4']);
		
		$perawat_1 = $dat_pemberian_obat_ls['PERAWAT_1'];
		$perawat_2 = $dat_pemberian_obat_ls['PERAWAT_2'];
		$perawat_3 = $dat_pemberian_obat_ls['PERAWAT_3'];
		$perawat_4 = $dat_pemberian_obat_ls['PERAWAT_4'];
		if($dat_pemberian_obat_ls['PEMBERIAN_OBAT_DETAIL_ID'] != '') $ada_data = '1';
		?>
		<tr>
		<td><?php echo $i; ?>
		<input type="hidden" name="pemb_id_<?php echo $i; ?>" value="<?php echo $dat_pemberian_obat_ls['PEMBERIAN_OBAT_ID']; ?>" />
		<input type="hidden" name="pemb_id_det_<?php echo $i; ?>" value="<?php echo $dat_pemberian_obat_ls['PEMBERIAN_OBAT_DETAIL_ID']; ?>" />
		</td>
		<td><input type="text" name="dokter_<?php echo $i; ?>" style="width:105px;" class="text_dt" value="<?php echo $dat_pemberian_obat_ls['DOKTER']; ?>" /></td>
		<td><input type="text" name="obat_<?php echo $i; ?>" style="width:200px;" class="text_dt" value="<?php echo $dat_pemberian_obat_ls['NAMA_OBAT']; ?>" /></td>
	<td><input type="text" name="dosis_<?php echo $i; ?>" style="width:100px;" class="text_dt" value="<?php echo $dat_pemberian_obat_ls['DOSIS']; ?>" /></td>
    <td><input type="text" name="aturan_<?php echo $i; ?>" style="width:100px;" class="text_dt" value="<?php echo $dat_pemberian_obat_ls['ATURAN_PAKAI']; ?>" /></td>
	<td><select name="jam1_<?php echo $i; ?>" style="width:50px;" class="text_dt" >
			<?php echo getJam(((isset($arr_jam_1[0])) ? $arr_jam_1[0] : '')); ?>
			</select>:
			<select name="menit1_<?php echo $i; ?>" style="width:50px;" class="text_dt" >
			<?php echo getMenit(((isset($arr_jam_1[1])) ? $arr_jam_1[1] : '')); ?>
			</select></td>
	<td><select name="jam2_<?php echo $i; ?>" style="width:50px;" class="text_dt" >
			<?php echo getJam(((isset($arr_jam_2[0])) ? $arr_jam_2[0] : '')); ?>
			</select>:
			<select name="menit2_<?php echo $i; ?>" style="width:50px;" class="text_dt" >
			<?php echo getMenit(((isset($arr_jam_2[1])) ? $arr_jam_2[1] : '')); ?>
			</select></td>
	<td><select name="jam3_<?php echo $i; ?>" style="width:50px;" class="text_dt" >
			<?php echo getJam(((isset($arr_jam_3[0])) ? $arr_jam_3[0] : '')); ?>
			</select>:
			<select name="menit3_<?php echo $i; ?>" style="width:50px;" class="text_dt" >
			<?php echo getMenit(((isset($arr_jam_3[1])) ? $arr_jam_3[1] : '')); ?>
			</select></td>
	<td><select name="jam4_<?php echo $i; ?>" style="width:50px;" class="text_dt" >
			<?php echo getJam(((isset($arr_jam_4[0])) ? $arr_jam_4[0] : '')); ?>
			</select>:
			<select name="menit4_<?php echo $i; ?>" style="width:50px;" class="text_dt" >
			<?php echo getMenit(((isset($arr_jam_4[1])) ? $arr_jam_4[1] : '')); ?>
			</select></td>
	<td><input type="text" name="keterangan_<?php echo $i; ?>" style="width:150px;" class="text_dt" value="<?php echo $dat_pemberian_obat_ls['KETERANGAN']; ?>" /></td>
	</tr>
  <?php $i++;
  } ?>
  <tr>
	<td align="center">&nbsp;
	<input type="hidden" name="cn_row" value="<?php echo $i; ?>" /></td>
    <td><select name="dokter_new" style="width:112px;" class="text_dt" >
			<option value=""> - </option>
			<?php echo getDokterRanap(''); ?>
			</select></td>
    <td><input type="text" name="obat_new" id="obat" style="width:200px;" class="text_dt" value="" /></td>
	<td><input type="text" name="dosis_new" style="width:100px;" class="text_dt" value="" /></td>
    <td><input type="text" name="aturan_new" style="width:100px;" class="text_dt" value="" /></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
 </tr>
<tr>
	<td colspan="2">Perawat</td>
    <td colspan="3">&nbsp;</td>
    <td><select name="perawat_1" class="text_dt" style="width:105px" >
			<?php echo getUserRawatInap($perawat_1, ''); ?>
			</select></td>
	<td><select name="perawat_2" class="text_dt" style="width:105px" >
			<?php echo getUserRawatInap($perawat_2, ''); ?>
			</select></td>
    <td><select name="perawat_3" class="text_dt" style="width:105px" >
			<?php echo getUserRawatInap($perawat_3, ''); ?>
			</select></td>
	<td><select name="perawat_4" class="text_dt" style="width:105px" >
			<?php echo getUserRawatInap($perawat_4, ''); ?>
			</select></td>
	<td>&nbsp;</td>		
 </tr> 
 <tr>
	<td colspan="2">Catatan</td>
	<td colspan="8">
	<textarea name="catatan" class="text_dt5"><?php echo $catatan; ?></textarea>
	</td>
 </tr>
    <tr>
            <td colspan="27" align="right">
			<?php if($irna_final == ''){ ?>
			<input type="button" value="simpan" onclick="simpan();" class="myButton1" />
			<?php if(!empty($ada_data)){ 
				$sql_view_rm = 'SELECT FILE_ID FROM t_rm_dokumen_file
						WHERE JNS_PERAWATAN = "2"
						AND NOMR = "' . $nomr . '"
						AND RAWAT_ID = "' . $irna_id . '"
						AND JENIS_DOKUMEN_ID = "65"
						ORDER BY FILE_ID DESC LIMIT 1';
				$get_view_rm = mysql_query($sql_view_rm) or die(mysql_error());		
				$dat_view_rm = mysql_fetch_assoc($get_view_rm);
			?>
			<input type="button" value="lihat" class="myButton1" onclick="window.open('index.php?flex=<?php echo $dat_view_rm['FILE_ID']; ?>', '_blank');" />
				<?php } } ?>
			</td>	
        </tr>
</table>
</form>
<script>
function simpan(){
	_haschange = false;
	$('#formedukasi').submit();
}	
</script>