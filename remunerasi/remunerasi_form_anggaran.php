<?php
$connect = mysql_connect($hostname_7, $username_7, $password_7) or die(mysql_error());
mysql_select_db($database_7, $connect) or die(mysql_error());

if(isset($_POST['simpan'])){
	$cnr = $_POST['cnr'];
	$y = 1;
	while($y <= $cnr){
		mysql_query('UPDATE r_remun_anggaran SET TAHUN = "' . $_POST['tahun_' . $y] . '",
					BULAN = "' . $_POST['bulan_' . $y] . '",
					JUMLAH_ANGGARAN = "' . $_POST['jumlah_' . $y] . '",
					PAGU_REMUNERASI = "' . $_POST['anggaran_' . $y] . '",
					PERSEN_PEMBAGIAN = "' . $_POST['persen_' . $y] . '"
					WHERE ANGGARAN_ID = "' . $_POST['anggaran_id_' . $y] . '"') or die(mysql_error());
	$y++;
	}
	
	if(isset($_POST['anggaran_new'])){
		mysql_query('INSERT INTO r_remun_anggaran(TAHUN,BULAN,JUMLAH_ANGGARAN,PAGU_REMUNERASI,PERSEN_PEMBAGIAN) 
					VALUES("' . $_POST['tahun_new'] . '","' . $_POST['bulan_new'] . '",
					"' . $_POST['jumlah_new'] . '","' . $_POST['anggaran_new'] . '","' . $_POST['persen_new'] . '")') or die(mysql_error());
	}
	
	?>
		<script language="JavaScript" >
			alert('Data Anggaran Berhasil Disimpan.');
            window.location = "<?php echo currentUrl(); ?>";
		</script>
	<?php
}

if (isset($_GET['idx'])) {
    mysql_query('DELETE FROM r_remun_anggaran WHERE ANGGARAN_ID = "' . $_GET['idx'] . '"') or die(mysql_error());
    $msg_info = 'Hapus Data Berhasil.';
}

if (isset($_GET['idf'])) {
    $idf = $_GET['idf'];
	$nmf = $_GET['nmf'];
    ?>
    <script language="JavaScript" >
        if(confirm("<?php echo $nmf; ?> dihapus?")){
            window.location = "index.php?link=<?php echo $_REQUEST['link']; ?>&idx=<?php echo $idf; ?>";
        }
    </script>
    <?php
}

$qry_remun = 'SELECT r_remun_anggaran.ANGGARAN_ID,r_remun_anggaran.TAHUN,
			r_remun_anggaran.BULAN,r_remun_anggaran.JUMLAH_ANGGARAN,
			r_remun_anggaran.PAGU_REMUNERASI,r_remun_anggaran.PERSEN_PEMBAGIAN
			FROM r_remun_anggaran
			ORDER BY r_remun_anggaran.TAHUN DESC,BULAN DESC'; 
?>
<br />
<form name="formx" id="formx" method="post">
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
		<th>Tahun</th>
		<th>Bulan</th>
		<th>Anggaran</th>
		<th>PIR</th>
		<th>Pembagian %</th>
		<th>Option</th>
    </tr>
    <?
    $x = 1;	
	$rs = mysql_query($qry_remun) or die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
    $id = $data['ANGGARAN_ID'];
        ?>
        <tr>
            <td align="center"><?php echo $x; ?>
			<input type="hidden" name="anggaran_id_<?php echo $x; ?>" value="<?php echo $id; ?>" /></td>
            <td align="center"><select name="tahun_<?php echo $x; ?>" class="text_dt" style="width:120px;" >
				<option value=""> - </option>
				<option value="2016" <?php if($data['TAHUN'] == '2016') echo 'selected="selected"'; ?> >2016</option>
				<option value="2017" <?php if($data['TAHUN'] == '2017') echo 'selected="selected"'; ?> >2017</option>
				<option value="2018" <?php if($data['TAHUN'] == '2018') echo 'selected="selected"'; ?> >2018</option>
				<option value="2019" <?php if($data['TAHUN'] == '2019') echo 'selected="selected"'; ?> >2019</option>
				<option value="2020" <?php if($data['TAHUN'] == '2020') echo 'selected="selected"'; ?> >2020</option>
			</select></td>
			<td align="center"><select name="bulan_<?php echo $x; ?>" class="text_dt" style="width:120px;" >
				<option value=""> - </option>
				<option value="01" <?php if($data['BULAN'] == '01') echo 'selected="selected"'; ?> >Januari</option>
				<option value="02" <?php if($data['BULAN'] == '02') echo 'selected="selected"'; ?> >Pebruari</option>
				<option value="03" <?php if($data['BULAN'] == '03') echo 'selected="selected"'; ?> >Maret</option>
				<option value="04" <?php if($data['BULAN'] == '04') echo 'selected="selected"'; ?> >April</option>
				<option value="05" <?php if($data['BULAN'] == '05') echo 'selected="selected"'; ?> >Mei</option>
				<option value="06" <?php if($data['BULAN'] == '06') echo 'selected="selected"'; ?> >Juni</option>
				<option value="07" <?php if($data['BULAN'] == '07') echo 'selected="selected"'; ?> >Juli</option>
				<option value="08" <?php if($data['BULAN'] == '08') echo 'selected="selected"'; ?> >Agustus</option>
				<option value="09" <?php if($data['BULAN'] == '09') echo 'selected="selected"'; ?> >September</option>
				<option value="10" <?php if($data['BULAN'] == '10') echo 'selected="selected"'; ?> >Oktober</option>
				<option value="11" <?php if($data['BULAN'] == '11') echo 'selected="selected"'; ?> >Nopember</option>
				<option value="12" <?php if($data['BULAN'] == '12') echo 'selected="selected"'; ?> >Desember</option>
			</select></td>
			<td align="center"><input type="text" name="anggaran_<?php echo $x; ?>" class="text_dt" style="text-align:right;" size="25" value="<?php echo $data['PAGU_REMUNERASI']; ?>" /></td>
			<td align="center"><input type="text" name="jumlah_<?php echo $x; ?>" class="text_dt" style="text-align:right;" size="25" value="<?php echo $data['JUMLAH_ANGGARAN']; ?>" /></td>
			<td align="center"><input type="text" name="persen_<?php echo $x; ?>" class="text_dt" style="text-align:right;" size="25" value="<?php echo $data['PERSEN_PEMBAGIAN']; ?>" /></td>
			<td align="center">
			<a href="index.php?link=<?php echo $_REQUEST['link']; ?>&idf=<?php echo $id; ?>&nmf=<?php echo $data['TAHUN']; ?>">hapus</a>
			</td>
	</tr>
	<?php $x++; } ?>
	<tr>
			<td align="center"><input type="checkbox" name="anggaran_new" value="1" /></td>
			<td align="center"><select name="tahun_new" class="text_dt" style="width:120px;" >
				<option value=""> - </option>
				<option value="2016" >2016</option>
				<option value="2017" >2017</option>
				<option value="2018" >2018</option>
				<option value="2019" >2019</option>
				<option value="2020" >2020</option>
			</select></td>
			<td align="center"><select name="bulan_new" class="text_dt" style="width:120px;" >
				<option value=""> - </option>
				<option value="01" >Januari</option>
				<option value="02" >Pebruari</option>
				<option value="03" >Maret</option>
				<option value="04" >April</option>
				<option value="05" >Mei</option>
				<option value="06" >Juni</option>
				<option value="07" >Juli</option>
				<option value="08" >Agustus</option>
				<option value="09" >September</option>
				<option value="10" >Oktober</option>
				<option value="11" >Nopember</option>
				<option value="12" >Desember</option>
			</select></td>
			<td align="center"><input type="text" name="anggaran_new" class="text_dt" style="text-align:right;" size="25" value="" /></td>
			<td align="center"><input type="text" name="jumlah_new" class="text_dt" style="text-align:right;" size="25" value="" /></td>
			<td align="center"><input type="text" name="persen_new" class="text_dt" style="text-align:right;" size="25" value="" /></td>
			<td align="center">&nbsp;</td>
	</tr>		
	<tr>
		<td colspan="9" align="right">
		<input type="submit" name="simpan" value="simpan" class="myButton1" />
		</td>
	</tr>
</table>
<input type="hidden" name="cnr" value="<?php echo $x - 1; ?>"  />
</form>