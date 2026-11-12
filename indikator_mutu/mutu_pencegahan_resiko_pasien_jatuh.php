<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tgl_1 = '';
if (isset($_SESSION['pencegahanjatuh_tgl_1']))
    $tgl_1 = $_SESSION['pencegahanjatuh_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['pencegahanjatuh_tgl_1']))
    $tgl_2 = $_SESSION['pencegahanjatuh_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['pencegahanjatuh_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['pencegahanjatuh_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['pencegahanjatuh_searchkey']))
		$searchkey = $_SESSION['pencegahanjatuh_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['pencegahanjatuh_searchkey'] = $searchkey;
}

$ruang_id = '';
if (isset($_SESSION['pencegahanjatuh_ruang_id']))
		$ruang_id = $_SESSION['pencegahanjatuh_ruang_id'];

if (isset($_GET['ruang_id'])) {
    $ruang_id = $_GET['ruang_id'];
	$_SESSION['pencegahanjatuh_ruang_id'] = $ruang_id;
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
			<td>Nomor MR/ Nama Pasien</td>
            <td><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt" style="width:200px;"/></td>	
			<td>&nbsp;</td>
			<td>&nbsp;</td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')" /></td>
			<td>Ruang Rawat</td>
			<td><select name="ruang_id" class="text_dt" style="width:210px;">
				<option value=""> - </option>
				<?php echo getBangsal($ruang_id); ?>
			</select></td>		
			<td align="right" colspan="2"><input type="submit" value="cari" class="myButton" />
			<a href="index.php?link=66499cefa9bb8f4fbd934d9ab146cc07" >
			<input type="button" value="pemantauan baru" class="myButton1" /></a>
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>
			</td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_pasien = 'SELECT rsj.PASIEN_JATUH_ID,
			DATE_FORMAT(rsj.TANGGAL,"%d/%m/%Y") AS TANGGAL,
			rsj.RAWAT_ID,psn.NOMR,psn.NAMA_PASIEN,
			rsj.RUANG_ID,
			CONCAT(un.NAMA_RUANG,"-",un.KELAS_RAWAT) AS NAMA_RUANG,
			rsj.ASSESMENT,rsj.GRADING,
			CASE WHEN rsj.GELANG_KUNING = "1" THEN "Ya"
				WHEN rsj.GELANG_KUNING = "2" THEN "Tdk"
				WHEN rsj.GELANG_KUNING = "3" THEN "NA"
			END AS GELANG_KUNING,
			CASE WHEN rsj.SEGITIGA_KUNING = "1" THEN "Ya"
				WHEN rsj.SEGITIGA_KUNING = "2" THEN "Tdk"
				WHEN rsj.SEGITIGA_KUNING = "3" THEN "NA"
			END AS SEGITIGA_KUNING,
			CASE WHEN rsj.PAGAR_TT = "1" THEN "Ya"
				WHEN rsj.PAGAR_TT = "2" THEN "Tdk"
				WHEN rsj.PAGAR_TT = "3" THEN "NA"
			END AS PAGAR_TT,
			CASE WHEN rsj.EDUKASI = "1" THEN "Ya"
				WHEN rsj.EDUKASI = "2" THEN "Tdk"
				WHEN rsj.EDUKASI = "3" THEN "NA"
			END AS EDUKASI,
			CASE WHEN rsj.JATUH = "1" THEN "Ya"
				WHEN rsj.JATUH = "2" THEN "Tdk"
				WHEN rsj.JATUH = "3" THEN "NA"
			END AS JATUH,
			rsj.PENGUMPUL_DATA
			FROM db_repository.mutu_pencegahan_resiko_pasien_jatuh rsj
			INNER JOIN db_simrs.t_irna irn ON (irn.IRNA_ID = rsj.RAWAT_ID) 
			INNER JOIN db_simrs.m_pasien psn ON (irn.NOMR = psn.NOMR) 
			LEFT JOIN db_simrs.m_ruang un ON (un.RUANG_ID = rsj.RUANG_ID)	
			WHERE STR_TO_DATE(DATE_FORMAT(rsj.TANGGAL,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . '
			AND STR_TO_DATE(DATE_FORMAT(rsj.TANGGAL,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2;

if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_pasien = $qry_pasien . ' AND CONCAT(psn.NOMR,psn.NAMA_PASIEN) LIKE "%' . $searchkey . '%" ';
}
if (!empty($ruang_id)) {
    $qry_pasien = $qry_pasien . ' AND un.BANGSAL = "' . $ruang_id . '" ';
}	
$qry_pasien = $qry_pasien . 'ORDER BY rsj.PASIEN_JATUH_ID';

$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&ruang_id=' . $ruang_id;
?>
<form name="formedukasi">
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th rowspan="2">No</th>
		<th rowspan="2">Tanggal</th>
        <th rowspan="2">Nomor MR</th>
        <th rowspan="2">Nama Pasien</th>
        <th rowspan="2">Ruang Rawat</th>
		<th rowspan="2">Assesment<br />Jatuh Awal</br >dan Ulang</th>
		<th rowspan="2">Grading<br />Resiko</br >Jatuh</th>
        <th colspan="4">Pencegahan Jatuh</th>
		<th rowspan="2">Jatuh</th>
		<!--<th rowspan="2" width="100px">Register</th>-->
    </tr>
    <tr>
      <th>Gelang<br />Kuning</th>
      <th>Segitiga<br />Kuning</th>
	  <th>Pagar<br />Tmp Tidur</th>
	  <th>Edukasi</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_pasien, 20, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
        $id = $data['RAWAT_ID'];
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
            <td align="center"><?php echo formatNoMR($data['NOMR']); ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td><?php echo $data['NAMA_RUANG']; ?></td>
			<td><?php echo $data['ASSESMENT']; ?></td>
			<td><?php echo $data['GRADING']; ?></td>
			<td align="center">
				<?php echo $data['GELANG_KUNING']; ?></td>
			</td>
			<td align="center">
				<?php echo $data['SEGITIGA_KUNING']; ?></td>
			</td>
			<td align="center">
				<?php echo $data['PAGAR_TT']; ?></td>
			</td>
			<td align="center">
				<?php echo $data['EDUKASI']; ?></td>
			</td>
			<td align="center">
				<?php echo $data['JATUH']; ?></td>
			</td>
			<!--<td><?php echo $data['PENGUMPUL_DATA']; ?></td>-->
        </tr>
        <?
    }
    ?>
</table>
</form>
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
<form id="xls_export" name="xls_export" method="post">
                    <input type="hidden" name="page_to_excel" value="1" />
                    <input type="hidden" name="tgl_1" value="<?php echo $tgl_1; ?>" />
                    <input type="hidden" name="tgl_2" value="<?php echo $tgl_2; ?>" />
					<input type="hidden" name="ruang_id" value="<?php echo $ruang_id; ?>" />
                    <input type="hidden" name="searchkey" value="<?php echo $searchkey; ?>" />
                    <input type="hidden" name="xlsfile" value="indikator_mutu/xls_mutu_pencegahan_resiko_pasien_jatuh.php" />
                    <input type="hidden" name="xlsname" value="rpt_mutu_pencegahan_resiko_pasien_jatuh.xls" />            
        </form>		