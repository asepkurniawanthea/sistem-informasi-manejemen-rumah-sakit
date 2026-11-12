<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tgl_1 = '';
if (isset($_SESSION['ert_tgl_1']))
    $tgl_1 = $_SESSION['ert_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['ert_tgl_1']))
    $tgl_2 = $_SESSION['ert_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['ert_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['ert_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['ert_searchkey']))
		$searchkey = $_SESSION['ert_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['ert_searchkey'] = $searchkey;
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
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')" /></td>
			<td>&nbsp;</td>
			<td><input type="submit" value="cari" class="myButton" />
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>		
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_pasien = 'SELECT irj.IRJA_ID,irj.NOMR, 
				DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d/%m/%Y") AS TGL_MASUK,
				DATE_FORMAT(irj.PASIEN_KELUAR,"%d/%m/%Y") AS TGL_KELUAR,
				un.NAMA_UNIT,psn.NAMA_PASIEN,
				DATE_FORMAT(psn.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
				DATE_FORMAT(irj.JAM_TRIAGE,"%d/%m/%Y %H:%i:%s") AS JAM_DATANG_SIMRS,
				DATE_FORMAT(irj.PASIEN_MASUK,"%d/%m/%Y %H:%i:%s") AS JAM_DILAYANI_SIMRS,
				TIMEDIFF(irj.PASIEN_MASUK,irj.JAM_TRIAGE) AS RESPONSE_TIME_SIMRS
				FROM db_simrs.t_irja irj
				INNER JOIN db_simrs.m_pasien psn ON (irj.NOMR = psn.NOMR) 
				LEFT JOIN db_simrs.m_unit un ON (irj.UNIT_ID = un.UNIT_ID)	
				WHERE irj.NO_PENDAFTARAN IS NOT NULL AND irj.ST_BATAL IS NULL 
				AND irj.UNIT_ID = 9 
				AND irj.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND irj.TANGGAL_DAFTAR <= ' . $tgl_filter_2;

if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_pasien = $qry_pasien . ' AND CONCAT(psn.NOMR,psn.NAMA_PASIEN) LIKE "%' . $searchkey . '%" ';
}	
$qry_pasien = $qry_pasien . 'ORDER BY irj.IRJA_ID';

$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2;
?>
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
		<th>Tanggal</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
        <th>Tanggal Lahir</th>
        <th>Jam Datang</th>
        <th>Jam Dilayani</th>
		<th>Response Time</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_pasien, 20, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
        $id = $data['IRJA_ID'];
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
            <td align="center"><?php echo $data['TGL_MASUK']; ?></td>
            <td align="center"><?php echo formatNoMR($data['NOMR']); ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td align="center"><?php echo $data['TGL_LAHIR']; ?></td>
            <td align="center"><?php echo $data['JAM_DATANG_SIMRS']; ?></td>
			<td align="center"><?php echo $data['JAM_DILAYANI_SIMRS']; ?></td>
			<td align="center"><?php echo $data['RESPONSE_TIME_SIMRS']; ?></td>
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
                    <input type="hidden" name="xlsfile" value="indikator_mutu/xls_emergency_response_time.php" />
                    <input type="hidden" name="xlsname" value="rpt_emergency_response_time.xls" />            
        </form>				