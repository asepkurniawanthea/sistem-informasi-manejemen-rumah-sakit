<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tgl_1 = '';
if (isset($_SESSION['clinicalpathway_tgl_1']))
    $tgl_1 = $_SESSION['clinicalpathway_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['clinicalpathway_tgl_1']))
    $tgl_2 = $_SESSION['clinicalpathway_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['clinicalpathway_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['clinicalpathway_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['clinicalpathway_searchkey']))
		$searchkey = $_SESSION['clinicalpathway_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['clinicalpathway_searchkey'] = $searchkey;
}

$ruang_id = '';
if (isset($_SESSION['clinicalpathway_ruang_id']))
		$ruang_id = $_SESSION['clinicalpathway_ruang_id'];

if (isset($_GET['ruang_id'])) {
    $ruang_id = $_GET['ruang_id'];
	$_SESSION['clinicalpathway_ruang_id'] = $ruang_id;
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
			<a href="index.php?link=c2bdd700b43c4b17506f9bcdbdb832fa" >
			<input type="button" value="pemantauan baru" class="myButton1" /></a>
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>
			</td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_pasien = 'SELECT kcp.CLINICAL_PATHWAY_ID,kcp.RAWAT_ID,
			kcp.RUANG_ID,kcp.PENGKAJIAN,kcp.OBAT,
			kcp.PENUNJANG,kcp.DIET,kcp.EDUKASI,
			DATE_FORMAT(kcp.TANGGAL,"%d/%m/%Y") AS TANGGAL,
			kcp.PENGUMPUL_DATA,
			psn.NOMR,psn.NAMA_PASIEN,
			CONCAT(un.NAMA_RUANG,"-",un.KELAS_RAWAT) AS NAMA_RUANG
			FROM db_repository.mutu_kepatuhan_clinical_pathway kcp	
			INNER JOIN db_simrs.t_irna irn ON (irn.IRNA_ID = kcp.RAWAT_ID) 
			INNER JOIN db_simrs.m_pasien psn ON (irn.NOMR = psn.NOMR) 
			LEFT JOIN db_simrs.m_ruang un ON (un.RUANG_ID = kcp.RUANG_ID)
			WHERE kcp.TANGGAL >= ' . $tgl_filter_1 . '
			AND kcp.TANGGAL <= ' . $tgl_filter_2;

if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_pasien = $qry_pasien . ' AND CONCAT(psn.NOMR,psn.NAMA_PASIEN) LIKE "%' . $searchkey . '%" ';
}
if (!empty($ruang_id)) {
    $qry_pasien = $qry_pasien . ' AND un.BANGSAL = "' . $ruang_id . '" ';
}	
$qry_pasien = $qry_pasien . 'ORDER BY kcp.CLINICAL_PATHWAY_ID';

$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&ruang_id=' . $ruang_id;
?>
<form name="formedukasi">
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
		<th>Tanggal</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
        <th>Ruang Rawat</th>
        <th>Pengkajian</th>
		<th>Obat</th>
		<th>Penunjang</th>
		<th>Diet</th>
		<th>Edukasi</th>
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
			<td align="center">
				<?php if($data['PENGKAJIAN'] == '1') echo 'Ya'; ?>
			</td>
			<td align="center">
				<?php if($data['OBAT'] == '1') echo 'Ya'; ?>
			</td>
			<td align="center">
				<?php if($data['PENUNJANG'] == '1') echo 'Ya'; ?>
			</td>
			<td align="center">
				<?php if($data['DIET'] == '1') echo 'Ya'; ?>
			</td>
			<td align="center">
				<?php if($data['EDUKASI'] == '1') echo 'Ya'; ?>
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
                    <input type="hidden" name="xlsfile" value="indikator_mutu/xls_mutu_kepatuhan_clinical_pathway.php" />
                    <input type="hidden" name="xlsname" value="rpt_mutu_kepatuhan_clinical_pathway.xls" />            
        </form>		