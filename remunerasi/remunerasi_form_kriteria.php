<?php
$connect = mysql_connect($hostname_7, $username_7, $password_7) or die(mysql_error());
mysql_select_db($database_7, $connect) or die(mysql_error());

if(isset($_POST['simpan'])){
	$cnr = $_POST['cnr'];
	$y = 1;
	while($y <= $cnr){
		mysql_query('UPDATE r_remun_kriteria_kinerja SET KRITERIA = "' . $_POST['kriteria_' . $y] . '",
					BOBOT = "' . $_POST['bobot_' . $y] . '"
					WHERE KRITERIA_KINERJA_ID = "' . $_POST['kriteria_id_' . $y] . '"') or die(mysql_error());
	$y++;
	}
	
	if(isset($_POST['kriteria_new'])){
		mysql_query('INSERT INTO r_remun_kriteria_kinerja(KRITERIA,BOBOT)
				VALUES("' . $_POST['kriteria_nama_new'] . '","' . $_POST['bobot_new'] . '")') or die(mysql_error());
	}
	?>
	<script language="JavaScript" >
			alert('Data Kriteria Berhasil Disimpan.');
            window.location = "<?php echo currentUrl(); ?>";
		</script>
	<?php
}

if (isset($_GET['idx'])) {
    mysql_query('DELETE FROM r_remun_kriteria_kinerja WHERE KRITERIA_KINERJA_ID = "' . $_GET['idx'] . '"') or die(mysql_error());
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

$qry_remun = 'SELECT r_remun_kriteria_kinerja.KRITERIA_KINERJA_ID,r_remun_kriteria_kinerja.KRITERIA,
			r_remun_kriteria_kinerja.BOBOT
			FROM r_remun_kriteria_kinerja ORDER BY r_remun_kriteria_kinerja.KRITERIA_KINERJA_ID'; 
?>
<br />
<form name="formx" id="formx" method="post">
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
		<th>Kriteria</th>
		<th>Bobot</th>
		<th>Option</th>
    </tr>
    <?
    $x = 1;	
    $rs = mysql_query($qry_remun) or die(mysql_error());
	while ($data = mysql_fetch_array($rs)) {
        $id = $data['KRITERIA_KINERJA_ID'];
        ?>
        <tr>
            <td align="center"><?php echo $x; ?>
			<input type="hidden" name="kriteria_id_<?php echo $x; ?>" value="<?php echo $id; ?>" />
			</td>
            <td align="center"><input type="text" name="kriteria_<?php echo $x; ?>" class="text_dt" size="40" value="<?php echo $data['KRITERIA']; ?>" /></td>
			<td align="center"><input type="text" name="bobot_<?php echo $x; ?>" class="text_dt" size="20" value="<?php echo $data['BOBOT']; ?>" /></td>
			<td align="center">
			<a href="index.php?link=<?php echo $_REQUEST['link']; ?>&idf=<?php echo $id; ?>&nmf=<?php echo $data['KRITERIA']; ?>">hapus</a>
			</td>
	</tr>
	<?php $x++; } ?>
	<tr>
			<td align="center"><input type="checkbox" name="kriteria_new" value="1" /></td>
		    <td align="center"><input type="text" name="kriteria_nama_new" class="text_dt" size="40" /></td>
			<td align="center"><input type="text" name="bobot_new" class="text_dt" size="20" /></td>
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