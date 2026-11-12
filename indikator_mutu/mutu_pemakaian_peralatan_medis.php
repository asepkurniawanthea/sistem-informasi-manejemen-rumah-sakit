<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tgl_1 = '';
if (isset($_SESSION['pemakaianalatmedis_tgl_1']))
    $tgl_1 = $_SESSION['pemakaianalatmedis_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['pemakaianalatmedis_tgl_1']))
    $tgl_2 = $_SESSION['pemakaianalatmedis_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['pemakaianalatmedis_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['pemakaianalatmedis_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['pemakaianalatmedis_searchkey']))
		$searchkey = $_SESSION['pemakaianalatmedis_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['pemakaianalatmedis_searchkey'] = $searchkey;
}

$ruang_id = '';
if (isset($_SESSION['pemakaianalatmedis_ruang_id']))
		$ruang_id = $_SESSION['pemakaianalatmedis_ruang_id'];

if (isset($_GET['ruang_id'])) {
    $ruang_id = $_GET['ruang_id'];
	$_SESSION['pemakaianalatmedis_ruang_id'] = $ruang_id;
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
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/></td>
			<td>Ruang Rawat</td>
			<td><select name="ruang_id" class="text_dt" style="width:210px;">
				<option value=""> - </option>
				<?php echo getBangsal($ruang_id); ?>
			</select></td>		
			<td align="right" colspan="2"><input type="submit" value="cari" class="myButton" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_pasien = 'SELECT TANGGAL,NOMR,NAMA_PASIEN,NO_FOR_SUR,NAMA_RUANG,
				SUM(ETT) AS ETT,
				SUM(CVL) AS CVL,
				SUM(IVL) AS IVL,
				SUM(UC) AS UC,
				SUM(PEMAKAIAN_ANTIBIOTIKA) AS PEMAKAIAN_ANTIBIOTIKA,
				SUM(PEMERIKSAAN_KULTUR) AS PEMERIKSAAN_KULTUR
				FROM (
					SELECT irn.IRNA_ID,irn.NOMR,psn.NAMA_PASIEN,
					api.NO_FOR_SUR,rng.NAMA_RUANG,rng.BANGSAL,
					alm.TANGGAL,
					CASE WHEN alm.ETT = "1" THEN 1 
						WHEN alm.ETT IS NULL THEN 0 END AS ETT,
					CASE WHEN alm.CVL = "1" THEN 1 
						WHEN alm.CVL IS NULL THEN 0 END AS CVL,
					CASE WHEN alm.IVL = "1" THEN 1 
						WHEN alm.IVL IS NULL THEN 0 END AS IVL,
					CASE WHEN alm.UC = "1" THEN 1 
						WHEN alm.UC IS NULL THEN 0 END AS UC,	
					CASE WHEN SUBSTRING_INDEX(api.PEMAKAIAN_ANTIBIOTIKA, "|", 1) = "1" THEN 1 END AS PEMAKAIAN_ANTIBIOTIKA,
					CASE WHEN SUBSTRING_INDEX(api.PEMERIKSAAN_KULTUR, "|", 1) = "1"
						OR SUBSTRING_INDEX(SUBSTRING_INDEX(api.PEMERIKSAAN_KULTUR, "|", 2),"|",1) = "1"
						OR SUBSTRING_INDEX(SUBSTRING_INDEX(api.PEMERIKSAAN_KULTUR, "|", -2),"|",-1) = "1" 
						OR SUBSTRING_INDEX(api.PEMERIKSAAN_KULTUR, "|", -1) = "1" THEN 1 END AS PEMERIKSAAN_KULTUR
					FROM t_irna irn
					INNER JOIN m_pasien psn
					ON (irn.NOMR = psn.NOMR)
					INNER JOIN t_irna_askep_pengendalian_infeksi api 
					ON (irn.IRNA_ID = api.PENGENDALIAN_INFEKSI_ID)
					INNER JOIN t_irna_askep_pengendalian_infeksi_alat_medis alm 
					ON (api.PENGENDALIAN_INFEKSI_ID = alm.PENGENDALIAN_INFEKSI_ID)
					LEFT JOIN m_ruang rng
					ON (irn.RUANG_ID = rng.RUANG_ID)
					WHERE alm.TANGGAL >= ' . $tgl_filter_1 . '
					AND alm.TANGGAL <= ' . $tgl_filter_2 . '
				) t_alm
				WHERE 1 ';

if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_pasien = $qry_pasien . ' AND CONCAT(NOMR,NAMA_PASIEN) LIKE "%' . $searchkey . '%" ';
}	
if (!empty($ruang_id)) {
    $qry_pasien = $qry_pasien . ' AND BANGSAL = "' . $ruang_id . '" ';
}
$qry_pasien = $qry_pasien . 'GROUP BY TANGGAL,NOMR,NAMA_PASIEN,NO_FOR_SUR
				ORDER BY TANGGAL,NOMR';

$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&ruang_id=' . $ruang_id;
?>
<table border="1" class="tableData" id="tfhover" >
     <tr>
        <th rowspan="2">No</th>
		<th rowspan="2">Tanggal</th>
        <th rowspan="2">Nomor MR</th>
        <th rowspan="2">Nama Pasien</th>
		<th rowspan="2">Unit - Ruang</th>
        <th colspan="4">Pemakaian Alat </th>
		<th rowspan="2">Kultur</th>
        <th rowspan="2">Antibiotika</th>
        <th rowspan="2">Keterangan</th>
    </tr>
    <tr>
      <th>ETT<br />ventilasi mekanik</th>
      <th>CVL<br />intra vena<br />cateter sentral</th>
      <th>IVL<br />intra vena<br />cateter perifer</th>
      <th>UC<br />kateter urine</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_pasien, 20, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
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
			<td align="center"><?php echo formatNoMR($data['NOMR']); ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
			<td><?php echo $data['NAMA_RUANG']; ?></td>
            <td align="center"><?php if($data['ETT'] > 0) echo '&radic;'; ?></td>
			<td align="center"><?php if($data['CVL'] > 0) echo '&radic;'; ?></td>
			<td align="center"><?php if($data['IVL'] > 0) echo '&radic;'; ?></td>
			<td align="center"><?php if($data['UC'] > 0) echo '&radic;'; ?></td>
			<td align="center"><?php if($data['PEMAKAIAN_ANTIBIOTIKA'] > 0) echo '&radic;'; ?></td>
			<td align="center"><?php if($data['PEMERIKSAAN_KULTUR'] > 0) echo '&radic;'; ?></td>
			<td>&nbsp;</td>
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