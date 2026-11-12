<?php
$connect = mysql_connect($hostname_7, $username_7, $password_7) or die(mysql_error());
mysql_select_db($database_7, $connect) or die(mysql_error());

$searchkey = '';
if(isset($_SESSION['renumkeg_searckey'])){
	$searchkey = $_SESSION['renumkeg_searckey'];
}

if (isset($_POST['cari'])) {
    $searchkey = $_POST['searchkey'];
	$_SESSION['renumkeg_searckey'] = $_POST['searchkey'];
}

$sql_search = '';
if(!empty($searchkey)){
	$sql_search = 'AND r_remun_kegiatan_kinerja.UNIT_KERJA_ID = "' . $searchkey . '"';
}

if(isset($_POST['simpan'])){
	$cnr = $_POST['cnr'];
	$y = 1;
	while($y <= $cnr){
		mysql_query('UPDATE r_remun_kegiatan_kinerja SET KRITERIA_KINERJA_ID = "' . $_POST['kriteria_' . $y] . '",
					KEGIATAN = "' . $_POST['kegiatan_' . $y] . '",TARGET = "' . $_POST['target_' . $y] . '",
					UNIT_KERJA_ID = "' . $_POST['unit_kerja_' . $y] . '",TARGET_TAHUN = "' . $_POST['target_tahun_' . $y] . '",
					TARGET_BULAN = "' . $_POST['target_bulan_' . $y] . '",SATUAN = "' . $_POST['satuan_' . $y] . '"
					WHERE KEGIATAN_KINERJA_ID = "' . $_POST['kegiatan_id_' . $y] . '"') or die(mysql_error());
	$y++;
	}
	
	if(isset($_POST['keg_new'])){
		mysql_query('INSERT INTO r_remun_kegiatan_kinerja(KRITERIA_KINERJA_ID,KEGIATAN,
					TARGET,UNIT_KERJA_ID,TARGET_TAHUN,TARGET_BULAN,
					SATUAN) VALUES("' . $_POST['kriteria_new'] . '","' . $_POST['kegiatan_new'] . '",
					"' . $_POST['target_new'] . '","' . $_POST['unit_kerja_new'] . '",
					"' . $_POST['target_tahun_new'] . '","' . $_POST['target_bulan_new'] . '",
					"' . $_POST['satuan_new'] . '")') or die(mysql_error());
	}
}

if (isset($_GET['idx'])) {
    mysql_query('DELETE FROM r_remun_kegiatan_kinerja WHERE KEGIATAN_KINERJA_ID = "' . $_GET['idx'] . '"') or die(mysql_error());
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

$arr_kriteria = array();
$qry_kriteria = 'SELECT r_remun_kriteria_kinerja.KRITERIA_KINERJA_ID,r_remun_kriteria_kinerja.KRITERIA
			FROM r_remun_kriteria_kinerja';
$get_kriteria = mysql_query($qry_kriteria) or die(mysql_error());
while($dat_kriteria = mysql_fetch_array($get_kriteria)){
	$arr_kriteria[$dat_kriteria['KRITERIA_KINERJA_ID']] = $dat_kriteria['KRITERIA']; 
}

$arr_unit = array();
$qry_unit = 'SELECT r_unit_kerja.UNIT_KERJA_ID,r_unit_kerja.UNIT_KERJA
			FROM r_unit_kerja
			ORDER BY UNIT_KERJA';
$get_unit = mysql_query($qry_unit) or die(mysql_error());
while($dat_unit = mysql_fetch_array($get_unit)){
	$arr_unit[$dat_unit['UNIT_KERJA_ID']] = $dat_unit['UNIT_KERJA']; 
}

$qry_remun = 'SELECT r_remun_kegiatan_kinerja.KEGIATAN_KINERJA_ID,r_remun_kegiatan_kinerja.KRITERIA_KINERJA_ID,
			r_remun_kegiatan_kinerja.KEGIATAN,r_remun_kegiatan_kinerja.TARGET,r_remun_kegiatan_kinerja.UNIT_KERJA_ID,
			r_remun_kegiatan_kinerja.TARGET_TAHUN,r_remun_kegiatan_kinerja.TARGET_BULAN,r_remun_kegiatan_kinerja.SATUAN
			FROM r_remun_kegiatan_kinerja
			WHERE 1 ' . $sql_search . ' ORDER BY r_remun_kegiatan_kinerja.UNIT_KERJA_ID,
			r_remun_kegiatan_kinerja.KRITERIA_KINERJA_ID'; 
?>
<br />
<form name="formsearch" id="formsearch" method="post">
<table border="0" width="100%" class="tableNav">
        <tr>
            <td align="right">
                <select name="searchkey" class="text_dt" style="width:160px;" >
				<option value=""> - </option>
				<?php foreach($arr_unit as $key => $unit){ ?>
					<option value="<?php echo $key; ?>" <?php if($searchkey == $key) echo 'selected="selected"'; ?> ><?php echo $unit; ?></option>
				<?php } ?>	
			</select>&nbsp;&nbsp;<input type="submit" name="cari" value="cari" class="myButton" />
            </td>			
        </tr> 
</table>
</form>
<form name="formx" id="formx" method="post">
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
		<th>Unit Kerja</th>
		<th>Kriteria</th>
		<th>Kegiatan</th>
        <th>Target %</th>
		<th>Target<br />Tahun</th>
		<th>Target<br />Bulan</th>
		<th>Satuan</th>
		<th>Option</th>
    </tr>
    <?
    $x = 1;	
	$no = 0;
    $pager = new PS_Pagination($connect, $qry_remun, 5, 5, '&searchkey=' . $searchkey, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs) die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
    $id = $data['KEGIATAN_KINERJA_ID'];
        ?>
        <tr>
            <td align="center"><?
					$no = ($no + 1);
					if (isset($_GET['page'])) {
						if ($_GET['page'] == 0) {
							$hal = 0;
						} else {
							$hal = $_GET['page'] - 1;
						}
					} else {
						$hal = 0;
					}
					echo ($hal * 5) + $no;
        ?>
			<input type="hidden" name="kegiatan_id_<?php echo $x; ?>" value="<?php echo $id; ?>" /></td>
            <td align="center"><select name="unit_kerja_<?php echo $x; ?>" class="text_dt" style="width:160px;" >
				<option value=""> - </option>
				<?php foreach($arr_unit as $key => $nilai){ ?>
					<option value="<?php echo $key; ?>" <?php if($data['UNIT_KERJA_ID'] == $key) echo 'selected="selected"'; ?> ><?php echo $nilai; ?></option>
				<?php } ?>	
			</select></td>
			<td><select name="kriteria_<?php echo $x; ?>" class="text_dt" style="width:160px;" >
				<option value=""> - </option>
				<?php foreach($arr_kriteria as $key => $nilai){ ?>
					<option value="<?php echo $key; ?>" <?php if($data['KRITERIA_KINERJA_ID'] == $key) echo 'selected="selected"'; ?> ><?php echo $nilai; ?></option>
				<?php } ?>	
			</select></td>
			<td align="center"><textarea name="kegiatan_<?php echo $x; ?>" class="text_dt3" ><?php echo $data['KEGIATAN']; ?></textarea></td>
			<td align="center"><input type="text" name="target_<?php echo $x; ?>" class="text_dt" size="5" value="<?php echo $data['TARGET']; ?>" /></td>
			<td align="center"><input type="text" name="target_tahun_<?php echo $x; ?>" class="text_dt" size="5" value="<?php echo $data['TARGET_TAHUN']; ?>" /></td>
			<td align="center"><input type="text" name="target_bulan_<?php echo $x; ?>" class="text_dt" size="5" value="<?php echo $data['TARGET_BULAN']; ?>" /></td>
			<td align="center"><input type="text" name="satuan_<?php echo $x; ?>" class="text_dt" size="10" value="<?php echo $data['SATUAN']; ?>" /></td>
			<td align="center">
			<a href="index.php?link=<?php echo $_REQUEST['link']; ?>&idf=<?php echo $id; ?>&nmf=<?php echo $data['KEGIATAN']; ?>">hapus</a>
			</td>
	</tr>
	<?php $x++; } ?>
	<tr>
			<td align="center"><input type="checkbox" name="keg_new" value="1" /></td>
			<td align="center"><select name="unit_kerja_new" class="text_dt" style="width:120px;" >
				<option value=""> - </option>
				<?php foreach($arr_unit as $key => $nilai){ ?>
					<option value="<?php echo $key; ?>" ><?php echo $nilai; ?></option>
				<?php } ?>	
			</select></td>
			<td><select name="kriteria_new" class="text_dt" style="width:120px;" >
				<option value=""> - </option>
				<?php foreach($arr_kriteria as $key => $nilai){ ?>
					<option value="<?php echo $key; ?>" ><?php echo $nilai; ?></option>
				<?php } ?>	
			</select></td>
			<td align="center"><textarea name="kegiatan_new" class="text_dt3" ></textarea></td>
			<td align="center"><input type="text" name="target_new" class="text_dt" size="5" value="" /></td>
			<td align="center"><input type="text" name="target_tahun_new" class="text_dt" size="5" value="" /></td>
			<td align="center"><input type="text" name="target_bulan_new" class="text_dt" size="5" value="" /></td>
			<td align="center"><input type="text" name="satuan_new" class="text_dt" size="10" value="" /></td>
			<td align="center">&nbsp;</td>
	</tr>		
	<tr>
		<td colspan="9" align="right">
		<input type="submit" name="simpan" value="simpan" class="myButton1" />
		</td>
	</tr>
</table>
<table width="100%" border="0" height="50%" class="tableNav" >
            <tr >
                <td align="right" valign="middle" >
                    <div style="background-color:#fff; height:80%; width:30%">
                        <table width="100%" align="center" height="100%" class="tableNavSub">
                            <tr>
								<td align="center">
                                    <?php
                                    echo $pager->renderSummary();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?php
                                    echo $pager->renderFirst();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderPrev();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderNav();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderNext();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderLast();
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>

                </td>
            </tr>
        </table>
<input type="hidden" name="cnr" value="<?php echo $x - 1; ?>"  />
</form>