<?php
$connect = mysql_connect($hostname_7, $username_7, $password_7) or die(mysql_error());
mysql_select_db($database_7, $connect) or die(mysql_error());

if(isset($_POST['simpan'])){
	$cnr = $_POST['cnr'];
	$y = 1;
	while($y <= $cnr){
		
		$a_nip = '';
		$a_nama = '';
		$arr_pegawai = explode('--',$_POST['nip_' . $y]);
		if(sizeof($arr_pegawai) >= 2){
			$a_nip = $arr_pegawai[0];
			$a_nama = $arr_pegawai[1];
		}else{
			$a_nip = $_POST['nip_' . $y];
			$a_nama = $_POST['nama_' . $y];
		}
		
		$level = $_POST['level_ke_' . $y];
		$level_unit = $_POST['dibawah_unit_' . $y];
		mysql_query('UPDATE r_unit_kerja SET UNIT_KERJA = "' . strtoupper($_POST['unit_' . $y]) . '",
					NIP_KEPALA = "' . $a_nip . '",
					NAMA_KEPALA = "' . $a_nama . '",
					LEVEL_KE = "' . $level . '",
					LEVEL_DIATAS = "' . $level_unit . '"
					WHERE UNIT_KERJA_ID = "' . $_POST['unit_id_' . $y] . '"') or die(mysql_error());
	$y++;
	}
	
	if(isset($_POST['unit_new'])){
		$n_nip = '';
		$n_nama = '';
		$arr_pegawai = explode('--',$_POST['nip_new']);
		if(sizeof($arr_pegawai) >= 2){
			$n_nip = $arr_pegawai[0];
			$n_nama = $arr_pegawai[1];
		}else{
			$n_nip = $_POST['nip_new'];
			$n_nama = $_POST['nama_new'];
		}
		
		$level_ke = $_POST['level_ke_new'];
		$level_unit = $_POST['level_unit_new'];
		
		mysql_query('INSERT INTO r_unit_kerja(UNIT_KERJA,NIP_KEPALA,NAMA_KEPALA,LEVEL_KE,LEVEL_DIATAS)
				VALUES("' . strtoupper($_POST['unit_kerja_new']) . '","' . $n_nip . '","' . $n_nama . '",
				"' . $level_ke . '","' . $level_unit . '")') or die(mysql_error());
	}
	
	?>
		 <script language="JavaScript" >
			alert('Data Unit Kerja Berhasil Disimpan.');
            window.location = "<?php echo currentUrl(); ?>";
		</script>
	<?php
}

if (isset($_GET['idx'])) {
    mysql_query('DELETE FROM r_unit_kerja WHERE UNIT_KERJA_ID = "' . $_GET['idx'] . '"') or die(mysql_error());
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

$arr_unit = array();

$qry_remun = 'SELECT r_unit_kerja.UNIT_KERJA_ID,r_unit_kerja.UNIT_KERJA,
			r_unit_kerja.NIP_KEPALA,r_unit_kerja.NAMA_KEPALA,
			r_unit_kerja.LEVEL_KE,r_unit_kerja.LEVEL_DIATAS
			FROM r_unit_kerja ORDER BY r_unit_kerja.UNIT_KERJA'; 
$rs = mysql_query($qry_remun) or die(mysql_error());
while($rw = mysql_fetch_array($rs)){
		
	$arr_unit[$rw['UNIT_KERJA_ID']] = $rw['UNIT_KERJA']; 
}			
?>
<br />
<form name="formx" id="formx" method="post">
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
		<th>Unit Kerja</th>
		<th>Nama Kepala</th>
		<th>NIP</th>
		<th>Level Ke</th>
		<th>Dibawah Unit</th>
		<th>Option</th>
    </tr>
    <?
    $x = 1;	
    mysql_data_seek($rs,0);
	while ($data = mysql_fetch_array($rs)) {
        $id = $data['UNIT_KERJA_ID'];
        ?>
        <tr>
            <td align="center"><?php echo $x; ?>
			<input type="hidden" name="unit_id_<?php echo $x; ?>" value="<?php echo $id; ?>" />
			</td>
            <td align="center"><input type="text" name="unit_<?php echo $x; ?>" class="text_dt" size="40" value="<?php echo $data['UNIT_KERJA']; ?>" /></td>
			<td align="center"><input type="text" name="nama_<?php echo $x; ?>" class="text_dt" size="40" value="<?php echo $data['NAMA_KEPALA']; ?>" /></td>
			<td align="center"><input type="text" name="nip_<?php echo $x; ?>" id="nip_<?php echo $x; ?>" class="text_dt" size="40" value="<?php echo $data['NIP_KEPALA']; ?>" /></td>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#nip_<?php echo $x; ?>").autocomplete("index.php?autocomp=mspegawai",{width: 400});
				});
			</script>
			<td><select name="level_ke_<?php echo $x; ?>" class="text_dt">
				<option value="">-</option>
				<option value="1" <?php if($data['LEVEL_KE'] == '1') echo 'selected'; ?> >1</option>
				<option value="2" <?php if($data['LEVEL_KE'] == '2') echo 'selected'; ?> >2</option>
				<option value="3" <?php if($data['LEVEL_KE'] == '3') echo 'selected'; ?> >3</option>
				<option value="4" <?php if($data['LEVEL_KE'] == '4') echo 'selected'; ?> >4</option>
				<option value="5" <?php if($data['LEVEL_KE'] == '5') echo 'selected'; ?> >5</option>
				<option value="6" <?php if($data['LEVEL_KE'] == '6') echo 'selected'; ?> >6</option>
			</select></td>
			<td><select name="dibawah_unit_<?php echo $x; ?>" class="text_dt">
				<option value="">-</option>
				<?php foreach($arr_unit as $key => $value){ ?>
					<option value="<?php echo $key; ?>" <?php if($data['LEVEL_DIATAS'] == $key) echo 'selected'; ?> ><?php echo $value; ?></option>
				<?php } ?>
			</select></td>
			<td align="center">
			<a href="index.php?link=<?php echo $_REQUEST['link']; ?>&idf=<?php echo $id; ?>&nmf=<?php echo $data['UNIT_KERJA']; ?>">hapus</a>
			</td>
	</tr>
	<?php $x++; } ?>
	<tr>
			<td align="center"><input type="checkbox" name="unit_new" value="1" /></td>
		    <td align="center"><input type="text" name="unit_kerja_new" class="text_dt" size="40" /></td>
			<td align="center"><input type="text" name="nama_new" class="text_dt" size="40" /></td>
			<td align="center"><input type="text" name="nip_new" id="nip_new" class="text_dt" size="40" />
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#nip_new").autocomplete("index.php?autocomp=mspegawai",{width: 400});
				});
			</script>
			</td>
			<td>
			<select name="level_ke_new" class="text_dt">
				<option value="">-</option>
				<option value="1" <?php if($data['LEVEL_KE'] == '1') echo 'selected'; ?> >1</option>
				<option value="2" <?php if($data['LEVEL_KE'] == '2') echo 'selected'; ?> >2</option>
				<option value="3" <?php if($data['LEVEL_KE'] == '3') echo 'selected'; ?> >3</option>
				<option value="4" <?php if($data['LEVEL_KE'] == '4') echo 'selected'; ?> >4</option>
				<option value="5" <?php if($data['LEVEL_KE'] == '5') echo 'selected'; ?> >5</option>
				<option value="6" <?php if($data['LEVEL_KE'] == '6') echo 'selected'; ?> >6</option>
			</select></td>
			<td><select name="level_unit_new" class="text_dt">
				<option value="">-</option>
				<?php foreach($arr_unit as $key => $value){ ?>
					<option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
				<?php } ?>
			</select></td>
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