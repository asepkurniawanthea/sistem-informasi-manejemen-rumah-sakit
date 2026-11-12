<style>
.list_isi{
	height:550px;
}
</style>
<?php
if (isset($_GET['idi'])){
	if (!isset($_GET['hapus'])) {
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $_GET['nmi']; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_GET['link']; ?>&idi=<?php echo $_GET['idi']; ?>&hapus=1";
        }else{
			window.location = "index.php?link=<?php echo $_GET['link']; ?>";
		}
    </script>
    <?php
}

	if (isset($_GET['hapus'])) {
		mysql_query('DELETE FROM db_repository.mutu_waktu_lapor_hasil_laboratorium WHERE WAKTU_LAPOR_ID = "' . $_GET['idi'] . '"') or die(mysql_error());
		
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>";
    </script>
    <?php
	}
}
$tgl_1 = '';
if (isset($_SESSION['whlklab_tgl_1']))
    $tgl_1 = $_SESSION['whlklab_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['whlklab_tgl_1']))
    $tgl_2 = $_SESSION['whlklab_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['whlklab_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['whlklab_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['whlklab_searchkey']))
		$searchkey = $_SESSION['whlklab_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['whlklab_searchkey'] = $searchkey;
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
			<a href="index.php?link=fe205be5e6d33e7249069721ec8af707" >
			<input type="button" value="pemantauan baru" class="myButton1" /></a>
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>		
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_pasien = 'SELECT mlb.WAKTU_LAPOR_ID,mlb.RAWAT_ID,mlb.NOMR,mlb.NO_TARIF,
			mlb.FORM_HASIL,DATE_FORMAT(mlb.TGL_HASIL,"%d/%m/%Y") AS TGL_HASIL,
			CASE WHEN TIME_TO_SEC(
				TIMEDIFF(mlb.TGL_LAPOR,mlb.TGL_HASIL)
			) <= 1800 THEN TIMEDIFF(mlb.TGL_LAPOR,mlb.TGL_HASIL) END AS WL_30,
			CASE WHEN TIME_TO_SEC(
				TIMEDIFF(mlb.TGL_LAPOR,mlb.TGL_HASIL)
			) > 1800 THEN TIMEDIFF(mlb.TGL_LAPOR,mlb.TGL_HASIL) END AS WL_31,
			mlb.PENGUMPUL_DATA,mlb.KETERANGAN
			FROM db_repository.mutu_waktu_lapor_hasil_laboratorium mlb
			WHERE STR_TO_DATE(DATE_FORMAT(mlb.TGL_LAPOR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . '
			AND STR_TO_DATE(DATE_FORMAT(mlb.TGL_LAPOR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2;

if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_pasien = $qry_pasien . ' AND CONCAT(t_lab.NOMR,t_lab.NAMA_PASIEN) LIKE "%' . $searchkey . '%" ';
}
	
$qry_pasien = $qry_pasien . ' ORDER BY mlb.NO_TARIF';

$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2;
?>
<form name="formedukasi">
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th rowspan="2">No</th>
		<th rowspan="2">Tanggal</th>
        <th rowspan="2">Nomor MR</th>
        <th colspan="2">Waktu Tunggu</th>
		<th rowspan="2">Keterangan</th>
		<th rowspan="2">Action</th>
    </tr>
    <tr>
      <th><= 30 menit</th>
      <th>> 30 menit</th>
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
            <td align="center"><?php echo $data['TGL_HASIL']; ?></td>
            <td align="center"><?php if(strlen($data['NOMR']) == 6) {
					echo formatNoMR($data['NOMR']);
				}else{
					echo $data['NOMR'];
				}?></td>
            <td align="center"><?php echo $data['WL_30']; ?></td>
			<td align="center"><?php echo $data['WL_31']; ?></td>
			<td><?php echo $data['KETERANGAN']; ?></td>
            <td>
				<a href="<?php echo currentUrl(); ?>&idi=<?php echo $data['WAKTU_LAPOR_ID']; ?>&nmi=<?php echo $data['NOMR']; ?>" >hapus</a>
			</td>
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
                    <input type="hidden" name="searchkey" value="<?php echo $searchkey; ?>" />
                    <input type="hidden" name="xlsfile" value="indikator_mutu/xls_waktu_lapor_kritis_laboratorium.php" />
                    <input type="hidden" name="xlsname" value="rpt_waktu_lapor_kritis_laboratorium.xls" />            
        </form>				