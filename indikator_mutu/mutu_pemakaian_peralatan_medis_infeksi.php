<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tgl_1 = '';
if (isset($_SESSION['pemakaianalatmedisinfeksi_tgl_1']))
    $tgl_1 = $_SESSION['pemakaianalatmedisinfeksi_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['pemakaianalatmedisinfeksi_tgl_1']))
    $tgl_2 = $_SESSION['pemakaianalatmedisinfeksi_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['pemakaianalatmedisinfeksi_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['pemakaianalatmedisinfeksi_tgl_2'] = $_GET['tgl_2'];
}

$ruang_id = '';
if (isset($_SESSION['pemakaianalatmedisinfeksi_ruang_id']))
		$ruang_id = $_SESSION['pemakaianalatmedisinfeksi_ruang_id'];

if (isset($_GET['ruang_id'])) {
    $ruang_id = $_GET['ruang_id'];
	$_SESSION['pemakaianalatmedisinfeksi_ruang_id'] = $ruang_id;
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
			<td>Ruang Rawat</td>
            <td><select name="ruang_id" class="text_dt" style="width:210px;">
				<option value=""> - </option>
				<?php echo getBangsal($ruang_id); ?>
			</select></td>	
			<td>&nbsp;</td>
			<td>&nbsp;</td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/></td>
			<td>&nbsp;</td>
			<td align="right"><input type="submit" value="cari" class="myButton" /></td>		
			<td align="right" colspan="2">&nbsp;</td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$arr_kosong = '"NA","-",""';
$qry_pasien = 'SELECT TANGGAL,NAMA_RUANG,
				COUNT(DISTINCT ETT) AS ETT,
				COUNT(DISTINCT CVL) AS CVL,
				COUNT(DISTINCT IVL) AS IVL,
				COUNT(DISTINCT UC) AS UC,
				COUNT(DISTINCT PEMAKAIAN_ANTIBIOTIKA) AS PEMAKAIAN_ANTIBIOTIKA,
				COUNT(DISTINCT PEMERIKSAAN_KULTUR) AS PEMERIKSAAN_KULTUR,
				COUNT(DISTINCT VAP) AS VAP,
				COUNT(DISTINCT BAKTEREMIA) AS BAKTEREMIA,
				COUNT(DISTINCT PLEBITIS) AS PLEBITIS,
				COUNT(DISTINCT SALURAN_KEMIH) AS SALURAN_KEMIH
				FROM (
					SELECT irn.IRNA_ID,irn.NOMR,psn.NAMA_PASIEN,
					api.NO_FOR_SUR,rng.NAMA_RUANG,rng.BANGSAL,
					alm.TANGGAL,
					CASE WHEN alm.ETT = "1" THEN irn.IRNA_ID END AS ETT,
					CASE WHEN alm.CVL = "1" THEN irn.IRNA_ID END AS CVL,
					CASE WHEN alm.IVL = "1" THEN irn.IRNA_ID END AS IVL,
					CASE WHEN alm.UC = "1" THEN irn.IRNA_ID END AS UC,	
					CASE WHEN SUBSTRING_INDEX(api.PEMAKAIAN_ANTIBIOTIKA, "|", 1) = "1" THEN irn.IRNA_ID END AS PEMAKAIAN_ANTIBIOTIKA,
					CASE WHEN SUBSTRING_INDEX(api.PEMERIKSAAN_KULTUR, "|", 1) = "1"
						OR SUBSTRING_INDEX(SUBSTRING_INDEX(api.PEMERIKSAAN_KULTUR, "|", 2),"|",1) = "1"
						OR SUBSTRING_INDEX(SUBSTRING_INDEX(api.PEMERIKSAAN_KULTUR, "|", -2),"|",-1) = "1" 
						OR SUBSTRING_INDEX(api.PEMERIKSAAN_KULTUR, "|", -1) = "1" THEN irn.IRNA_ID END AS PEMERIKSAAN_KULTUR,
					CASE WHEN TRIM(api.VAP) NOT IN (' . $arr_kosong . ') THEN irn.IRNA_ID END AS VAP,
					CASE WHEN TRIM(api.BAKTEREMIA) NOT IN (' . $arr_kosong . ') THEN irn.IRNA_ID END AS BAKTEREMIA,
					CASE WHEN TRIM(api.PLEBITIS) NOT IN (' . $arr_kosong . ') THEN irn.IRNA_ID END AS PLEBITIS,
					CASE WHEN TRIM(api.SALURAN_KEMIH) NOT IN (' . $arr_kosong . ') THEN irn.IRNA_ID END AS SALURAN_KEMIH
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
if (!empty($ruang_id)) {
    $qry_pasien = $qry_pasien . ' AND BANGSAL = "' . $ruang_id . '" ';
}
$qry_pasien = $qry_pasien . 'GROUP BY TANGGAL,NAMA_RUANG
			ORDER BY TANGGAL,NAMA_RUANG';

$extparam = '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&ruang_id=' . $ruang_id;
?>
<table border="1" class="tableData" id="tfhover" >
     <tr>
        <th rowspan="2">No</th>
		<th rowspan="2">Tanggal</th>
		<th rowspan="2">Unit - Ruang</th>
		<th colspan="8">Jumlah Pasien</th>
	</tr>
    <tr>
      <th>ETT</th>
      <th>CVL</th>
      <th>IVL</th>
      <th>UC</th>
      <th>VAP</th>
      <th>BAKTEREMIA</th>
      <th>PLEBITIS</th>
      <th>ISK</th>
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
			<td><?php echo $data['NAMA_RUANG']; ?></td>
			<td align="right"><?php echo currFormat($data['ETT']); ?></td>
			<td align="right"><?php echo currFormat($data['CVL']); ?></td>
			<td align="right"><?php echo currFormat($data['IVL']); ?></td>
			<td align="right"><?php echo currFormat($data['UC']); ?></td>
			<td align="right"><?php echo currFormat($data['VAP']); ?></td>
			<td align="right"><?php echo currFormat($data['BAKTEREMIA']); ?></td>
			<td align="right"><?php echo currFormat($data['PLEBITIS']); ?></td>
			<td align="right"><?php echo currFormat($data['SALURAN_KEMIH']); ?></td>
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