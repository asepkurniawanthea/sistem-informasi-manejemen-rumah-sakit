<style>
.list_isi{
	height:550px;
}
</style>
<?php
$connect = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
mysql_select_db($database_5, $connect) or die(mysql_error());

$tgl_1 = '';
if (isset($_SESSION['cucitangan_tgl_1']))
    $tgl_1 = $_SESSION['cucitangan_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['cucitangan_tgl_1']))
    $tgl_2 = $_SESSION['cucitangan_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['cucitangan_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['cucitangan_tgl_2'] = $_GET['tgl_2'];
}

$ruangan = '';
if (isset($_SESSION['cucitangan_ruangan']))
		$ruangan = $_SESSION['cucitangan_ruangan'];

if (isset($_GET['ruangan'])) {
    $ruangan = $_GET['ruangan'];
	$_SESSION['cucitangan_ruangan'] = $ruangan;
}
$fasilitas = '';
if (isset($_SESSION['cucitangan_fasilitas']))
		$fasilitas = $_SESSION['cucitangan_fasilitas'];

if (isset($_GET['fasilitas'])) {
    $fasilitas = $_GET['fasilitas'];
	$_SESSION['cucitangan_fasilitas'] = $fasilitas;
}
$unit_pelayanan = '';
if (isset($_SESSION['cucitangan_unit_pelayanan']))
		$unit_pelayanan = $_SESSION['cucitangan_unit_pelayanan'];

if (isset($_GET['unit_pelayanan'])) {
    $unit_pelayanan = $_GET['unit_pelayanan'];
	$_SESSION['cucitangan_unit_pelayanan'] = $unit_pelayanan;
}

$pelayanan = '';
if (isset($_SESSION['cucitangan_pelayanan']))
		$pelayanan = $_SESSION['cucitangan_pelayanan'];

if (isset($_GET['pelayanan'])) {
    $pelayanan = $_GET['pelayanan'];
	$_SESSION['cucitangan_pelayanan'] = $pelayanan;
}

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}	
?>
<form name="search" method="get" action="index.php">
    <table class="tableform" border="0">
		<tr>
            <td>Tanggal</td>
            <td><input type="text" name="tgl_1" id="tgl_1" value="<?php echo $tgl_1; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
			<td>Fasilitas</td>
            <td><select name="fasilitas" class="text_dt" style="width:210px;">
				<option value=""> - </option>
				<?php $qry_unit = 'SELECT DISTINCT FASILITAS
								FROM mutu_kepatuhan_cuci_tangan 
								ORDER BY FASILITAS'; 
				$get_unit = mysql_query($qry_unit) or die(mysql_error());			
				while($dat_unit = mysql_fetch_array($get_unit)){
					if($dat_unit['FASILITAS'] != ''){
						$select = '';
						if($dat_unit['FASILITAS'] == $fasilitas) $select = 'selected="selected"';
						echo '<option value="' . $dat_unit['FASILITAS'] . '" ' . $select . ' >' . $dat_unit['FASILITAS'] . '</option>';
					}	
				}?>
			</select></td>
			<td>Ruangan</td>
            <td><select name="ruangan" class="text_dt" style="width:210px;">
				<option value=""> - </option>
				<?php $qry_unit = 'SELECT DISTINCT RUANGAN
								FROM mutu_kepatuhan_cuci_tangan 
								ORDER BY RUANGAN'; 
				$get_unit = mysql_query($qry_unit) or die(mysql_error());			
				while($dat_unit = mysql_fetch_array($get_unit)){
					if($dat_unit['RUANGAN'] != ''){
						$select = '';
						if($dat_unit['RUANGAN'] == $ruangan) $select = 'selected="selected"';
						echo '<option value="' . $dat_unit['RUANGAN'] . '" ' . $select . ' >' . $dat_unit['RUANGAN'] . '</option>';
					}	
				}?>
			</select></td>	
			<td>&nbsp;</td>
			<td>&nbsp;</td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/></td>
			<td>Pelayanan</td>
			<td><select name="pelayanan" class="text_dt" style="width:210px;">
				<option value=""> - </option>
				<?php $qry_unit = 'SELECT DISTINCT PELAYANAN
								FROM mutu_kepatuhan_cuci_tangan 
								ORDER BY PELAYANAN'; 
				$get_unit = mysql_query($qry_unit) or die(mysql_error());			
				while($dat_unit = mysql_fetch_array($get_unit)){
					if($dat_unit['PELAYANAN'] != ''){
						$select = '';
						if($dat_unit['PELAYANAN'] == $pelayanan) $select = 'selected="selected"';
						echo '<option value="' . $dat_unit['PELAYANAN'] . '" ' . $select . ' >' . $dat_unit['PELAYANAN'] . '</option>';
					}	
				}?>
			</select>
			<td>Unit Pelayanan</td>
			<td><select name="unit_pelayanan" class="text_dt" style="width:210px;">
				<option value=""> - </option>
				<?php $qry_unit = 'SELECT DISTINCT UNIT_PELAYANAN
								FROM mutu_kepatuhan_cuci_tangan 
								ORDER BY UNIT_PELAYANAN'; 
				$get_unit = mysql_query($qry_unit) or die(mysql_error());			
				while($dat_unit = mysql_fetch_array($get_unit)){
					if($dat_unit['UNIT_PELAYANAN'] != ''){
						$select = '';
						if($dat_unit['UNIT_PELAYANAN'] == $unit_pelayanan) $select = 'selected="selected"';
						echo '<option value="' . $dat_unit['UNIT_PELAYANAN'] . '" ' . $select . ' >' . $dat_unit['UNIT_PELAYANAN'] . '</option>';
					}	
				}?>
			</select></td>		
			<td align="right" colspan="2">
			<input type="submit" value="cari" class="myButton" />
			<a href="index.php?link=4a707cd185a3d47a583a3dd5c122c7c7&baru=1" >
				<input type="button" value="pemantauan baru" class="myButton1" /></a>
			</td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_pemantauan = 'SELECT mutu_kepatuhan_cuci_tangan.KEPATUHAN_CUCI_TANGAN_ID,
			mutu_kepatuhan_cuci_tangan.FASILITAS,mutu_kepatuhan_cuci_tangan.PELAYANAN,
			mutu_kepatuhan_cuci_tangan.RUANGAN,mutu_kepatuhan_cuci_tangan.UNIT_PELAYANAN,
			CASE WHEN mutu_kepatuhan_cuci_tangan.PERIODE = "1" THEN "Sebelum Intervensi"
				WHEN mutu_kepatuhan_cuci_tangan.PERIODE = "2" THEN "Setelah Intervensi"
			END AS PERIODE,
			DATE_FORMAT(mutu_kepatuhan_cuci_tangan.TANGGAL,"%d/%m/%Y") AS TANGGAL,
			mutu_kepatuhan_cuci_tangan.NOMOR_SESI,
			mutu_kepatuhan_cuci_tangan.NAMA_OBSERVER,
			mutu_kepatuhan_cuci_tangan.LEMBAR_KE,
			mutu_kepatuhan_cuci_tangan.NOMOR,
			mutu_kepatuhan_cuci_tangan.REGISTER
			FROM mutu_kepatuhan_cuci_tangan
			WHERE mutu_kepatuhan_cuci_tangan.TANGGAL >= ' . $tgl_filter_1 . '
			AND mutu_kepatuhan_cuci_tangan.TANGGAL <= ' . $tgl_filter_2 . '';
if(!empty($ruangan)){
	$qry_pemantauan = $qry_pemantauan . ' AND RUANGAN LIKE "%' . $ruangan . '%"';
}
if(!empty($unit_pelayanan)){
	$qry_pemantauan = $qry_pemantauan . ' AND UNIT_PELAYANAN LIKE "%' . $unit_pelayanan . '%"';
}
if(!empty($pelayanan)){
	$qry_pemantauan = $qry_pemantauan . ' AND PELAYANAN LIKE "%' . $pelayanan . '%"';
}
if(!empty($fasilitas)){
	$qry_pemantauan = $qry_pemantauan . ' AND FASILITAS LIKE "%' . $fasilitas . '%"';
}

$extparam = '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&unit_pelayanan=' . $unit_pelayanan . '&ruangan=' . $ruangan . '&fasilitas=' . $fasilitas . '&pelayanan=' . $pelayanan;
?>
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
		<th>Tanggal</th>
		<th>Fasilitas</th>
        <th>Pelayanan</th>
		<th>Ruangan</th> 
		<th>Unit Pelayanan</th> 
		<th>Periode</th> 
		<th>Nomor<br />Sesi</th> 
		<th>Nama Observer</th> 
		<th>Lembar<br />Ke</th> 
		<th>Register</th> 
		<th>Option</th> 
	</tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_pemantauan, 20, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
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
    echo ($hal * 20) + $no;
        ?></td>
            <td align="center"><?php echo $data['TANGGAL']; ?></td>
			<td><?php echo $data['FASILITAS']; ?></td>
			<td><?php echo $data['PELAYANAN']; ?></td>
			<td><?php echo $data['RUANGAN']; ?></td>
			<td><?php echo $data['UNIT_PELAYANAN']; ?></td>
			<td><?php echo $data['PERIODE']; ?></td>
			<td align="center"><?php echo $data['NOMOR_SESI']; ?></td>
			<td><?php echo $data['NAMA_OBSERVER']; ?></td>
			<td align="center"><?php echo $data['LEMBAR_KE']; ?></td>
			<td><?php echo $data['REGISTER']; ?></td>
			<td align="center"><a href="index.php?link=4a707cd185a3d47a583a3dd5c122c7c7&idx=<?php echo $data['KEPATUHAN_CUCI_TANGAN_ID']; ?>">
				buka
				</a></td>
        </tr>
        <?
    }
    ?>
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