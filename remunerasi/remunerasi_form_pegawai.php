<?php
$connect = mysql_connect($hostname_7, $username_7, $password_7) or die(mysql_error());
mysql_select_db($database_7, $connect) or die(mysql_error());

$searchkey = '';
if(isset($_SESSION['renum_searckey'])){
	$searchkey = $_SESSION['renum_searckey'];
}

$unit_kerja = '';
if(isset($_SESSION['renum_unit_kerja'])){
	$unit_kerja = $_SESSION['renum_unit_kerja'];
}

if (isset($_POST['cari'])) {
    $searchkey = $_POST['searchkey'];
	$_SESSION['renum_searckey'] = $_POST['searchkey'];
	
	$unit_kerja = $_POST['unit_kerja'];
	$_SESSION['renum_unit_kerja'] = $_POST['unit_kerja'];
}

$sql_search = '';
if(!empty($searchkey)){
	$sql_search = 'AND CONCAT(r_pegawai_ori.NAMA_PEGAWAI,r_pegawai_ori.NIP) LIKE "%' . $searchkey . '%"';
}

if(!empty($unit_kerja)){
	$sql_search .= 'AND r_pegawai_ori.UNIT_KERJA_ID = "' . $unit_kerja . '"';
}

if(isset($_POST['simpan'])){
	$cnr = $_POST['cnr'];
	$y = 1;
	while($y <= $cnr){
		$id = trim($_POST['id_' . $y]);
		$nip = trim($_POST['nip_' . $y]);
		$nama = trim($_POST['nama_' . $y]);
		$golongan = trim($_POST['golongan_' . $y]);
		$jabatan = trim($_POST['jabatan_' . $y]);
		$pendidikan = trim($_POST['pendidikan_' . $y]);
		$alamat = trim($_POST['alamat_' . $y]);
		$jabatan_idx = trim($_POST['jabatan_idx_' . $y]);
		$unit = trim($_POST['unit_' . $y]);
		
		mysql_query('UPDATE r_pegawai_ori SET NIP = "' . $nip . '",
					NAMA_PEGAWAI = "' . $nama . '",
					GOLONGAN = "' . $golongan . '",
					JABATAN = "' . $jabatan . '",
					PENDIDIKAN = "' . $pendidikan . '",
					ALAMAT = "' . $alamat . '",
					JABATAN_ID = "' . $jabatan_idx . '",
					UNIT_KERJA_ID = "' . $unit . '"
					WHERE NIP = "' . $id . '"') or die(mysql_error());
		
		if(isset($_POST['ppabp_' . $y]) or isset($_POST['psdm_' . $y])){
			$markah = 'NULL';
			if(isset($_POST['ppabp_' . $y])) $markah = '"' . $_POST['ppabp_' . $y] . '"';
			if(isset($_POST['psdm_' . $y])) $markah = '"' . $_POST['psdm_' . $y] . '"';
			
			mysql_query('UPDATE r_pegawai_ori SET MARK_SBG = ' . $markah . '
					WHERE NIP = "' . $id . '"') or die(mysql_error());
		}	
		
	$y++;
	}
	
	?>
		<script language="JavaScript" >
			alert('Data Pegawai Berhasil Disimpan.');
            window.location = "<?php echo currentUrl(); ?>";
		</script>
	<?php
}

$arr_unit = array();
$qry_unit = 'SELECT r_unit_kerja.UNIT_KERJA_ID,r_unit_kerja.UNIT_KERJA
			FROM r_unit_kerja
			ORDER BY UNIT_KERJA';
$get_unit = mysql_query($qry_unit) or die(mysql_error());
while($dat_unit = mysql_fetch_array($get_unit)){
	$arr_unit[$dat_unit['UNIT_KERJA_ID']] = $dat_unit['UNIT_KERJA']; 
}

$arr_jabatan = array();
$qry_jabatan = 'SELECT r_jabatan.JABATAN_ID,r_jabatan.JABATAN,r_jabatan.JABATAN_DESC
			FROM r_jabatan
			ORDER BY JABATAN';
$get_jabatan = mysql_query($qry_jabatan) or die(mysql_error());
while($dat_jabatan = mysql_fetch_array($get_jabatan)){
	$arr_jabatan[$dat_jabatan['JABATAN_ID']] = $dat_jabatan['JABATAN'] . ' | ' . $dat_jabatan['JABATAN_DESC']; 
}

$qry_remun = 'SELECT * 
			FROM r_pegawai_ori
			WHERE 1		
			' . $sql_search . '
			ORDER BY NAMA_PEGAWAI'; 
?>
<form name="searchpegawai" method="post" action="<?php currentURL(); ?>">
    <table class="tableform" border="0" >
        <tr>
            <td>Unit Kerja</td>
            <td><select name="unit_kerja" class="text_dt" style="width:180px;" >
				<option value=""> - </option>
				<?php foreach($arr_unit as $key => $nilai){ ?>
					<option value="<?php echo $key; ?>" <?php if($unit_kerja == $key) echo 'selected="selected"'; ?> ><?php echo $nilai; ?></option>
				<?php } ?>	
				</select></td>
			<td>&nbsp;</td>
        </tr>
		<tr>
			<td>Nama Pegawai</td>
            <td><input type="text" name="searchkey" class="text_dt" id="searchkey" value="<?php echo $searchkey; ?>" style="width:170px;" /></td>
			<td><input type="submit" name="cari" value="cari" class="myButton1" /></td>
        </tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<form name="formx" id="formx" method="post" action="<?php currentURL(); ?>">
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th rowspan="2">No</th>
		<th rowspan="2">NIP</th>
		<th rowspan="2">Nama Pegawai</th>
		<th rowspan="2">Golongan</th>
        <th rowspan="2">Jabatan</th>
		<th rowspan="2">Pendidikan</th>
		<th rowspan="2">Alamat</th>
		<th rowspan="2">Index Jabatan</th>
		<th rowspan="2">Unit Kerja</th>
		<th colspan="2">Markah<br/>Slip Gaji</th>
    </tr>
	<tr>
		<th>PPABP</th>
		<th>PSDM</th>
	</tr>
    <?
    $x = 1;	
	$no = 0;
    $pager = new PS_Pagination($connect, $qry_remun, 10, 5, '&searchkey=' . $searchkey, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs) die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
    $id = $data['NIP'];
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
					echo ($hal * 10) + $no;
        ?>
			<input type="hidden" name="id_<?php echo $x; ?>" value="<?php echo $id; ?>" />
			<td align="center"><input type="text" name="nip_<?php echo $x; ?>" class="text_dt" size="20" value="<?php echo $data['NIP']; ?>" /></td>
			<td align="center"><input type="text" name="nama_<?php echo $x; ?>" class="text_dt" size="35" value="<?php echo $data['NAMA_PEGAWAI']; ?>" /></td>
			<td align="center"><input type="text" name="golongan_<?php echo $x; ?>" class="text_dt" size="30" value="<?php echo $data['GOLONGAN']; ?>" /></td>
			<td align="center"><input type="text" name="jabatan_<?php echo $x; ?>" class="text_dt" size="30" value="<?php echo $data['JABATAN']; ?>" /></td>
			<td align="center"><input type="text" name="pendidikan_<?php echo $x; ?>" class="text_dt" size="30" value="<?php echo $data['PENDIDIKAN']; ?>" /></td>
			<td align="center"><textarea name="alamat_<?php echo $x; ?>" class="text_dt6" rows="3"><?php echo $data['ALAMAT']; ?></textarea></td>
			<td><select name="jabatan_idx_<?php echo $x; ?>" class="text_dt" style="width:140px;" >
				<option value=""> - </option>
				<?php foreach($arr_jabatan as $key => $nilai){ ?>
					<option value="<?php echo $key; ?>" <?php if($data['JABATAN_ID'] == $key) echo 'selected="selected"'; ?> ><?php echo $nilai; ?></option>
				<?php } ?>	
			</select></td>
			<td><select name="unit_<?php echo $x; ?>" class="text_dt" style="width:160px;" >
				<option value=""> - </option>
				<?php foreach($arr_unit as $key => $nilai){ ?>
					<option value="<?php echo $key; ?>" <?php if($data['UNIT_KERJA_ID'] == $key) echo 'selected="selected"'; ?> ><?php echo $nilai; ?></option>
				<?php } ?>	
			</select></td>
			<td><input type="checkbox" name="ppabp_<?php echo $x; ?>" value="BGPPABP" <?php if($data['MARK_SBG'] == 'BGPPABP') echo 'checked'; ?> /></td>
			<td><input type="checkbox" name="psdm_<?php echo $x; ?>" value="KPSDM"  <?php if($data['MARK_SBG'] == 'KPSDM') echo 'checked'; ?> /></td>
	</tr>
	<?php $x++; } ?>
	<tr>
		<td colspan="11" align="right">
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