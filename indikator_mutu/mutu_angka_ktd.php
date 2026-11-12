<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tgl_1 = '';
if (isset($_SESSION['angkaktd_tgl_1']))
    $tgl_1 = $_SESSION['angkaktd_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['angkaktd_tgl_1']))
    $tgl_2 = $_SESSION['angkaktd_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['angkaktd_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['angkaktd_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['angkaktd_searchkey']))
		$searchkey = $_SESSION['angkaktd_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['angkaktd_searchkey'] = $searchkey;
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
			<td>&nbsp;</td>
			<td><input type="submit" value="cari" class="myButton" />
			<a href="index.php?link=638d64d93e359aaeb2d42ad7554cb3ec" >
			<input type="button" value="pemantauan baru" class="myButton1" /></a>
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>
			<td>&nbsp;</td>		
			<td align="right" colspan="2">&nbsp;</td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_pasien = 'SELECT DISTINCT * FROM (SELECT kdb.OPERASI_ID,
				DATE_FORMAT(kdb.TANGGAL,"%d/%m/%Y") AS TANGGAL,
				psn.NAMA_PASIEN,top.NOMR,
				kdb.DIAGNOSA,
				kdb.KTD,
				kdb.KETERANGAN
				FROM db_repository.mutu_angka_ktd kdb 
				INNER JOIN db_simrs.t_operasi top ON (kdb.RAWAT_ID = top.RAWAT_ID) 
				INNER JOIN db_simrs.t_irja irj ON (top.RAWAT_ID = irj.IRJA_ID)
				INNER JOIN db_simrs.m_pasien psn ON (top.NOMR = psn.NOMR)
				WHERE top.JNS_ORDER = "IRJ"
				AND kdb.JNS_ORDER = "IRJ"
				AND STR_TO_DATE(DATE_FORMAT(kdb.TANGGAL,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(kdb.TANGGAL,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				UNION
				SELECT kdb.OPERASI_ID,
				DATE_FORMAT(kdb.TANGGAL,"%d/%m/%Y") AS TANGGAL,
				psn.NAMA_PASIEN,top.NOMR,
				kdb.DIAGNOSA,
				kdb.KTD,
				kdb.KETERANGAN
				FROM db_repository.mutu_angka_ktd kdb 
				INNER JOIN db_simrs.t_operasi top ON (kdb.RAWAT_ID = top.RAWAT_ID) 
				INNER JOIN db_simrs.t_irna irn ON (top.RAWAT_ID = irn.IRNA_ID)
				INNER JOIN db_simrs.m_pasien psn ON (top.NOMR = psn.NOMR)
				WHERE top.JNS_ORDER = "IRN"
				AND kdb.JNS_ORDER = "IRN"
				AND STR_TO_DATE(DATE_FORMAT(kdb.TANGGAL,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(kdb.TANGGAL,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				) t_order';

if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_pasien = $qry_pasien . ' AND CONCAT(t_order.NOMR,t_order.NAMA_PASIEN) LIKE "%' . $searchkey . '%" ';
}
$qry_pasien = $qry_pasien . ' ORDER BY t_order.OPERASI_ID';

$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2;
?>
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
		<th>Tanggal</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
        <th>Diagnosa</th>
		<th>KTD</th>
		<th>Keterangan</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_pasien, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
        $id = $data['OPERASI_ID'];
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
    echo ($hal * 10) + $no; ?></td>
            <td align="center"><?php echo $data['TANGGAL']; ?></td>
            <td align="center"><?php echo formatNoMR($data['NOMR']); ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
			<td><?php echo $data['DIAGNOSA']; ?></td>
			<td align="center"><?php if($data['KTD'] == '1') echo 'Ya'; ?></td>
			<td><?php echo $data['KETERANGAN']; ?></td>
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
<form id="xls_export" name="xls_export" method="post">
                    <input type="hidden" name="page_to_excel" value="1" />
                    <input type="hidden" name="tgl_1" value="<?php echo $tgl_1; ?>" />
                    <input type="hidden" name="tgl_2" value="<?php echo $tgl_2; ?>" />
                    <input type="hidden" name="searchkey" value="<?php echo $searchkey; ?>" />
                    <input type="hidden" name="xlsfile" value="indikator_mutu/xls_mutu_angka_ktd.php" />
                    <input type="hidden" name="xlsname" value="rpt_mutu_angka_ktd.xls" />            
        </form>		