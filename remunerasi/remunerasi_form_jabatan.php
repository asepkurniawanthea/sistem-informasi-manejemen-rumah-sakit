<?php
$connect = mysql_connect($hostname_7, $username_7, $password_7) or die(mysql_error());
mysql_select_db($database_7, $connect) or die(mysql_error());

if(isset($_POST['simpan'])){
	$cnr = $_POST['cnr'];
	$y = 1;
	while($y <= $cnr){
		mysql_query('UPDATE r_jabatan SET JABATAN = "' . strtoupper($_POST['jabatan_' . $y]) . '",
					JABATAN_DESC = "' . strtoupper($_POST['jabatan_desc_' . $y]) . '",
					NILAI_JABATAN_ID = "' . $_POST['grade_' . $y] . '",
					GAJI_KMK = "' . $_POST['gaji_' . $y] . '",
					INSENTIF_MINIMAL = "' . $_POST['insentif_minimal_' . $y] . '",
					INSENTIF_MAKSIMAL = "' . $_POST['insentif_maksimal_' . $y] . '"
					WHERE JABATAN_ID = "' . $_POST['jabatan_id_' . $y] . '"') or die(mysql_error());
	$y++;
	}
	
	if(isset($_POST['jab_new'])){
		mysql_query('INSERT INTO r_jabatan(JABATAN,NILAI_JABATAN_ID,JABATAN_DESC,GAJI_KMK,INSENTIF_MINIMAL,INSENTIF_MAKSIMAL)
				VALUES("' . strtoupper($_POST['jabatan_new']) . '","' . $_POST['grade_new'] . '",
				"' . strtoupper($_POST['jabatan_desc_new']) . '","' . $_POST['gaji_new'] . '",
				"' . $_POST['insentif_minimal_new'] . '","' . $_POST['insentif_maksimal_new'] . '")') or die(mysql_error());
	}
	
	?>
		 <script language="JavaScript" >
			alert('Data Jabatan Berhasil Disimpan.');
            window.location = "<?php echo currentUrl(); ?>";
		</script>
	<?php
}

if (isset($_GET['idx'])) {
    mysql_query('DELETE FROM r_jabatan WHERE JABATAN_ID = "' . $_GET['idx'] . '"') or die(mysql_error());
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

$arr_nilai = array();
$qry_nilai = 'SELECT r_remun_nilai_jabatan.NILAI_JABATAN_ID,r_remun_nilai_jabatan.CORP_GRADE
			FROM r_remun_nilai_jabatan
			ORDER BY CORP_GRADE DESC';
$get_nilai = mysql_query($qry_nilai) or die(mysql_error());
while($dat_nilai = mysql_fetch_array($get_nilai)){
	$arr_nilai[$dat_nilai['NILAI_JABATAN_ID']] = $dat_nilai['CORP_GRADE']; 
}

$qry_remun = 'SELECT r_jabatan.JABATAN_ID,r_jabatan.JABATAN,r_jabatan.NILAI_JABATAN_ID,
			r_remun_nilai_jabatan.CORP_GRADE,r_jabatan.JABATAN_DESC,r_jabatan.GAJI_KMK,
			r_jabatan.INSENTIF_MINIMAL,r_jabatan.INSENTIF_MAKSIMAL
			FROM r_jabatan
			LEFT JOIN r_remun_nilai_jabatan 
			ON (r_jabatan.NILAI_JABATAN_ID = r_remun_nilai_jabatan.NILAI_JABATAN_ID)
			ORDER BY r_remun_nilai_jabatan.CORP_GRADE DESC'; 
?>
<br />
<form name="formx" id="formx" method="post">
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
		<th>Jabatan</th>
		<th>Jabatan Desc</th>
        <th>Corporate Grade</th>
		<th>Gaji</th>
		<th>Insentif Minimal</th>
		<th>Insentif Maksimal</th>
		<th>Remunerasi Maksimal</th>
		<th>Option</th>
    </tr>
    <?
    $x = 1;	
    $rs = mysql_query($qry_remun) or die(mysql_error());
	while ($data = mysql_fetch_array($rs)) {
        $id = $data['JABATAN_ID'];
        ?>
        <tr>
            <td align="center"><?php echo $x; ?>
			<input type="hidden" name="jabatan_id_<?php echo $x; ?>" value="<?php echo $id; ?>" />
			</td>
            <td align="center"><input type="text" name="jabatan_<?php echo $x; ?>" class="text_dt" size="20" value="<?php echo $data['JABATAN']; ?>" /></td>
			<td align="center"><input type="text" name="jabatan_desc_<?php echo $x; ?>" class="text_dt" size="40" value="<?php echo $data['JABATAN_DESC']; ?>" /></td>
			<td align="center"><select name="grade_<?php echo $x; ?>" class="text_dt" style="width:120px;" >
				<option value=""> - </option>
				<?php foreach($arr_nilai as $key => $nilai){ ?>
					<option value="<?php echo $key; ?>" <?php if($data['NILAI_JABATAN_ID'] == $key) echo 'selected="selected"'; ?> ><?php echo $nilai; ?></option>
				<?php } ?>	
			</select></td>
			<td align="center"><input type="text" name="gaji_<?php echo $x; ?>" class="text_dt" size="20" value="<?php echo $data['GAJI_KMK']; ?>" style="text-align:right;"/></td>
			<td align="center"><input type="text" name="insentif_minimal_<?php echo $x; ?>" class="text_dt" size="20" value="<?php echo $data['INSENTIF_MINIMAL']; ?>" style="text-align:right;"/></td>
			<td align="center"><input type="text" name="insentif_maksimal_<?php echo $x; ?>" class="text_dt" size="20" value="<?php echo $data['INSENTIF_MAKSIMAL']; ?>" style="text-align:right;"/></td>
			<td align="right"><?php echo currFormat($data['GAJI_KMK'] + $data['INSENTIF_MAKSIMAL']); ?></td>
			<td align="center">
			<a href="index.php?link=<?php echo $_REQUEST['link']; ?>&idf=<?php echo $id; ?>&nmf=<?php echo $data['JABATAN']; ?>">hapus</a>
			</td>
	</tr>
	<?php $x++; } ?>
	<tr>
			<td align="center"><input type="checkbox" name="jab_new" value="1" /></td>
		    <td align="center"><input type="text" name="jabatan_new" class="text_dt" size="20" /></td>
			<td align="center"><input type="text" name="jabatan_desc_new" class="text_dt" size="40" /></td>
			<td align="center"><select name="grade_new" class="text_dt" style="width:120px;" >
				<option value=""> - </option>
				<?php foreach($arr_nilai as $key => $nilai){ ?>
					<option value="<?php echo $key; ?>"><?php echo $nilai; ?></option>
				<?php } ?>	
			</select></td>
			<td align="center"><input type="text" name="gaji_new" class="text_dt" size="20" style="text-align:right;" /></td>
			<td align="center"><input type="text" name="insentif_minimal_new" class="text_dt" size="20" style="text-align:right;" /></td>
			<td align="center"><input type="text" name="insentif_maksimal_new" class="text_dt" size="20" style="text-align:right;" /></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="9" align="right">
		<input type="submit" name="simpan" value="simpan" class="myButton1" />
		</td>
	</tr>
</table>
<input type="hidden" name="cnr" value="<?php echo $x - 1; ?>"  />
</form>