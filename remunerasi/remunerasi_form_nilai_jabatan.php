<?php
$connect = mysql_connect($hostname_7, $username_7, $password_7) or die(mysql_error());
mysql_select_db($database_7, $connect) or die(mysql_error());

if(isset($_POST['simpan'])){
	$cnr = $_POST['cnr'];
	$y = 1;
	while($y <= $cnr){
		mysql_query('UPDATE r_remun_nilai_jabatan SET CORP_GRADE = "' . $_POST['grade_' . $y] . '",
					NILAI_JAB_MIN = "' . $_POST['nilai_jab_min_' . $y] . '",NILAI_JAB_MAX = "' . $_POST['nilai_jab_max_' . $y] . '",
					NILAI_JAB = "' . $_POST['nilai_jab_' . $y] . '",JND = "' . $_POST['jnd_' . $y] . '"
					WHERE NILAI_JABATAN_ID = "' . $_POST['nilai_id_' . $y] . '"') or die(mysql_error());
	$y++;
	}
	
	if(isset($_POST['nilai_new'])){
		mysql_query('INSERT INTO r_remun_nilai_jabatan(CORP_GRADE,NILAI_JAB_MIN,NILAI_JAB_MAX,NILAI_JAB,JND)
				VALUES("' . $_POST['grade_new'] . '","' . $_POST['nilai_jab_min_new'] . '",
				"' . $_POST['nilai_jab_max_new'] . '","' . $_POST['nilai_jab_new'] . '","' . $_POST['jnd_new'] . '")') or die(mysql_error());
	}
	
	?>
		 <script language="JavaScript" >
			alert('Data Nilai Jabatan Berhasil Disimpan.');
            window.location = "<?php echo currentUrl(); ?>";
		</script>
	<?php
}

if (isset($_GET['idx'])) {
    mysql_query('DELETE FROM r_remun_nilai_jabatan WHERE NILAI_JABATAN_ID = "' . $_GET['idx'] . '"') or die(mysql_error());
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

$qry_remun = 'SELECT r_remun_nilai_jabatan.NILAI_JABATAN_ID,r_remun_nilai_jabatan.CORP_GRADE,
			r_remun_nilai_jabatan.NILAI_JAB_MIN,r_remun_nilai_jabatan.NILAI_JAB_MAX,
			r_remun_nilai_jabatan.NILAI_JAB,r_remun_nilai_jabatan.JND
			FROM r_remun_nilai_jabatan
			ORDER BY r_remun_nilai_jabatan.CORP_GRADE DESC'; 
?>
<br />
<form name="formx" id="formx" method="post">
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
		<th>Corporate Grade</th>
        <th>Nilai Jab</th>
		<th>Nilai Jab Min</th>
		<th>Nilai Jab Max</th>
		<th>JND (%)</th>
		<th>Option</th>
    </tr>
    <?
    $x = 1;	
    $rs = mysql_query($qry_remun) or die(mysql_error());
	while ($data = mysql_fetch_array($rs)) {
        $id = $data['NILAI_JABATAN_ID'];
        ?>
        <tr>
            <td align="center"><?php echo $x; ?>
			<input type="hidden" name="nilai_id_<?php echo $x; ?>" value="<?php echo $id; ?>" />
			</td>
            <td align="center"><input type="text" name="grade_<?php echo $x; ?>" class="text_dt" style="text-align:right;" size="20" value="<?php echo $data['CORP_GRADE']; ?>" /></td>
			<td align="center"><input type="text" name="nilai_jab_<?php echo $x; ?>" class="text_dt" style="text-align:right;" size="20" value="<?php echo $data['NILAI_JAB']; ?>" /></td>
			<td align="center"><input type="text" name="nilai_jab_min_<?php echo $x; ?>" class="text_dt" style="text-align:right;" size="20" value="<?php echo $data['NILAI_JAB_MIN']; ?>" /></td>
			<td align="center"><input type="text" name="nilai_jab_max_<?php echo $x; ?>" class="text_dt" style="text-align:right;" size="20" value="<?php echo $data['NILAI_JAB_MAX']; ?>" /></td>
            <td align="center"><input type="text" name="jnd_<?php echo $x; ?>" class="text_dt" style="text-align:right;" size="20" value="<?php echo $data['JND']; ?>" /></td>
			<td align="center">
			<a href="index.php?link=<?php echo $_REQUEST['link']; ?>&idf=<?php echo $id; ?>&nmf=<?php echo $data['CORP_GRADE']; ?>">hapus</a>
			</td>
	</tr>
	<?php $x++; } ?>
	<tr>
			<td align="center"><input type="checkbox" name="nilai_new" value="1" /></td>
		    <td align="center"><input type="text" name="grade_new" class="text_dt" style="text-align:right;" size="20" /></td>
			<td align="center"><input type="text" name="nilai_jab_new" class="text_dt" style="text-align:right;" size="20" /></td>
			<td align="center"><input type="text" name="nilai_jab_min_new" class="text_dt" style="text-align:right;" size="20" /></td>
			<td align="center"><input type="text" name="nilai_jab_max_new" class="text_dt" style="text-align:right;" size="20" /></td>
            <td align="center"><input type="text" name="jnd_new" class="text_dt" style="text-align:right;" size="20" /></td>
			<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="7" align="right">
		<input type="submit" name="simpan" value="simpan" class="myButton1" />
		</td>
	</tr>
</table>
<input type="hidden" name="cnr" value="<?php echo $x - 1; ?>"  />
</form>