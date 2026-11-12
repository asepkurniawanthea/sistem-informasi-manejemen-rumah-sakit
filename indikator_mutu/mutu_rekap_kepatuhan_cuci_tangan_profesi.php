<style>
.list_isi{
	height:550px;
}
</style>
<?php
$connect = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
mysql_select_db($database_5, $connect) or die(mysql_error());

$tgl_1 = '';
if (isset($_SESSION['rekapcucitanganprofesi_tgl_1']))
    $tgl_1 = $_SESSION['rekapcucitanganprofesi_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['rekapcucitanganprofesi_tgl_1']))
    $tgl_2 = $_SESSION['rekapcucitanganprofesi_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['rekapcucitanganprofesi_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['rekapcucitanganprofesi_tgl_2'] = $_GET['tgl_2'];
}

$fasilitas = '';
if (isset($_SESSION['rekapcucitanganprofesi_fasilitas']))
		$fasilitas = $_SESSION['rekapcucitanganprofesi_fasilitas'];

if (isset($_GET['fasilitas'])) {
    $fasilitas = $_GET['fasilitas'];
	$_SESSION['rekapcucitanganprofesi_fasilitas'] = $fasilitas;
}
$periode = '';
if (isset($_SESSION['rekapcucitanganprofesi_periode']))
		$periode = $_SESSION['rekapcucitanganprofesi_periode'];

if (isset($_GET['periode'])) {
    $periode = $_GET['periode'];
	$_SESSION['rekapcucitanganprofesi_periode'] = $periode;
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
			<td align="right" colspan="2">&nbsp;</td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/></td>
			<td>Periode</td>
			<td><select name="periode" class="text_dt" style="width:210px;">
				<option value=""> - </option>
				<option value="1">Sebelum Intervensi</option>
				<option value="2">Setelah Intervensi</option>
			</select></td>		
			<td align="right" colspan="2">
			<input type="submit" value="cari" class="myButton" />
			</td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_pemantauan = 'SELECT v_mkct.NOMOR_SESI,
						SUM(CASE WHEN t_mkct.PROFESI_1 = "1" THEN v_mkct.PELUANG END) AS PELUANG_PROFESI_1, 
						SUM(CASE WHEN t_mkct.PROFESI_2 = "1" THEN v_mkct.PELUANG END) AS PELUANG_PROFESI_2, 
						SUM(CASE WHEN t_mkct.PROFESI_3 = "1" THEN v_mkct.PELUANG END) AS PELUANG_PROFESI_3, 
						SUM(CASE WHEN t_mkct.PROFESI_4 = "1" THEN v_mkct.PELUANG END) AS PELUANG_PROFESI_4, 
						SUM(CASE WHEN t_mkct.PROFESI_1 = "1" AND v_mkct.CUCI_TANGAN_HR = "1" THEN 1 END) AS HR_PROFESI_1, 
						SUM(CASE WHEN t_mkct.PROFESI_2 = "1" AND v_mkct.CUCI_TANGAN_HR = "1" THEN 1 END) AS HR_PROFESI_2, 
						SUM(CASE WHEN t_mkct.PROFESI_3 = "1" AND v_mkct.CUCI_TANGAN_HR = "1" THEN 1 END) AS HR_PROFESI_3, 
						SUM(CASE WHEN t_mkct.PROFESI_4 = "1" AND v_mkct.CUCI_TANGAN_HR = "1" THEN 1 END) AS HR_PROFESI_4, 
						SUM(CASE WHEN t_mkct.PROFESI_1 = "1" AND v_mkct.CUCI_TANGAN_HW = "1" THEN 1 END) AS HW_PROFESI_1, 
						SUM(CASE WHEN t_mkct.PROFESI_2 = "1" AND v_mkct.CUCI_TANGAN_HW = "1" THEN 1 END) AS HW_PROFESI_2, 
						SUM(CASE WHEN t_mkct.PROFESI_3 = "1" AND v_mkct.CUCI_TANGAN_HW = "1" THEN 1 END) AS HW_PROFESI_3, 
						SUM(CASE WHEN t_mkct.PROFESI_4 = "1" AND v_mkct.CUCI_TANGAN_HW = "1" THEN 1 END) AS HW_PROFESI_4 
						FROM (
							SELECT mkct.KEPATUHAN_CUCI_TANGAN_ID, 
							MAX(CASE WHEN SUBSTRING_INDEX(mkctp.KATEGORI_PROFESI,".",1) = "1" THEN 1 END) AS PROFESI_1, 
							MAX(CASE WHEN SUBSTRING_INDEX(mkctp.KATEGORI_PROFESI,".",1) = "2" THEN 1 END) AS PROFESI_2, 
							MAX(CASE WHEN SUBSTRING_INDEX(mkctp.KATEGORI_PROFESI,".",1) = "3" THEN 1 END) AS PROFESI_3,
							MAX(CASE WHEN SUBSTRING_INDEX(mkctp.KATEGORI_PROFESI,".",1) = "2" THEN 1 END) AS PROFESI_4 	
							FROM mutu_kepatuhan_cuci_tangan mkct
							LEFT JOIN mutu_kepatuhan_cuci_tangan_profesi mkctp
							ON (mkct.KEPATUHAN_CUCI_TANGAN_ID = mkctp.KEPATUHAN_CUCI_TANGAN_ID)
							WHERE mkct.TANGGAL >= ' . $tgl_filter_1 . '
							AND mkct.TANGGAL <= ' . $tgl_filter_2 . '
							GROUP BY mkct.KEPATUHAN_CUCI_TANGAN_ID
						) t_mkct 
						INNER JOIN mutu_kepatuhan_cuci_tangan v_mkct
						ON (t_mkct.KEPATUHAN_CUCI_TANGAN_ID = v_mkct.KEPATUHAN_CUCI_TANGAN_ID)
						WHERE 1';
if(!empty($periode)){
	$qry_pemantauan = $qry_pemantauan . ' AND v_mkct.PERIODE LIKE "%' . $periode . '%"';
}
if(!empty($fasilitas)){
	$qry_pemantauan = $qry_pemantauan . ' AND v_mkct.FASILITAS LIKE "%' . $fasilitas . '%"';
}
$qry_pemantauan = $qry_pemantauan . ' GROUP BY v_mkct.NOMOR_SESI
					ORDER BY v_mkct.NOMOR_SESI';

$extparam = '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&fasilitas=' . $fasilitas . '&periode=' . $periode;
?>
<table border="1" class="tableData" id="tfhover" >
    <tr>
    <th rowspan="2">No</th>
	<th rowspan="2">Sesi</th>
    <th colspan="3">Perawat/ Bidan</th>
    <th colspan="3">Dokter</th>
    <th colspan="3">Tenaga Kesehatan Lain</th>
    <th colspan="3">Penunjang</th>
    <th colspan="3">Total Persesi</th>
  </tr>
  <tr>
    <th>Peluang</th>
    <th>HW</th>
    <th>HR</th>
    <th>Peluang</th>
    <th>HW</th>
    <th>HR</th>
    <th>Peluang</th>
    <th>HW</th>
    <th>HR</th>
    <th>Peluang</th>
    <th>HW</th>
    <th>HR</th>
    <th>Peluang</th>
    <th>HW</th>
    <th>HR</th>
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
            <td align="center"><?php echo $data['NOMOR_SESI']; ?></td>
			<td align="center"><?php echo $data['PELUANG_PROFESI_1']; ?></td>
			<td align="center"><?php echo $data['HR_PROFESI_1']; ?></td>
			<td align="center"><?php echo $data['HW_PROFESI_1']; ?></td>
			<td align="center"><?php echo $data['PELUANG_PROFESI_2']; ?></td>
			<td align="center"><?php echo $data['HR_PROFESI_2']; ?></td>
			<td align="center"><?php echo $data['HW_PROFESI_2']; ?></td>
			<td align="center"><?php echo $data['PELUANG_PROFESI_3']; ?></td>
			<td align="center"><?php echo $data['HR_PROFESI_3']; ?></td>
			<td align="center"><?php echo $data['HW_PROFESI_3']; ?></td>
			<td align="center"><?php echo $data['PELUANG_PROFESI_4']; ?></td>
			<td align="center"><?php echo $data['HR_PROFESI_4']; ?></td>
			<td align="center"><?php echo $data['HW_PROFESI_4']; ?></td>
			<td align="center"><?php  ?></td>
			<td align="center"><?php  ?></td>
			<td align="center"><?php  ?></td>
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