<style>
.list_isi{
	height:550px;
}
</style>
<?php
$connect = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
mysql_select_db($database_5, $connect) or die(mysql_error());

$tgl_1 = '';
if (isset($_SESSION['apd_tgl_1']))
    $tgl_1 = $_SESSION['apd_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['apd_tgl_1']))
    $tgl_2 = $_SESSION['apd_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['apd_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['apd_tgl_2'] = $_GET['tgl_2'];
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
			<td>&nbsp;</td>
			<td>&nbsp;</td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/></td>
			<td align="right" colspan="2">
			<input type="submit" value="cari" class="myButton" />
			<a href="index.php?link=b8e0daff37ca6b57d89ff0b23d234b89&baru=1" >
				<input type="button" value="pemantauan baru" class="myButton1" />
				<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></a>
			</td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_pemantauan = 'SELECT * FROM (SELECT mkc.APD_ID,
				mkc.PEGAWAI_ID,pgw.NAMA_PEGAWAI,
				mkc.PENGGUNAAN_APD,
				DATE_FORMAT(mkc.TANGGAL,"%d/%m/%Y") AS TANGGAL,
				mkc.PENGUMPUL_DATA,
				mkc.KETERANGAN
				FROM db_repository.mutu_penggunaan_apd mkc
				INNER JOIN db_simrs.m_pegawai pgw
				ON (mkc.PEGAWAI_ID = pgw.PEGAWAI_ID)
				WHERE mkc.TANGGAL >= ' . $tgl_filter_1 . '
				AND mkc.TANGGAL <= ' . $tgl_filter_2 . '
				AND mkc.APP_ID = "1"
				UNION ALL
				SELECT mkc.APD_ID,
				mkc.PEGAWAI_ID,pgw.NAMA_PEGAWAI,
				mkc.PENGGUNAAN_APD,
				DATE_FORMAT(mkc.TANGGAL,"%d/%m/%Y") AS TANGGAL,
				mkc.PENGUMPUL_DATA,
				mkc.KETERANGAN
				FROM db_repository.mutu_penggunaan_apd mkc
				INNER JOIN db_inventorirs.m_pegawai pgw
				ON (mkc.PEGAWAI_ID = pgw.PEGAWAI_ID)
				WHERE mkc.TANGGAL >= ' . $tgl_filter_1 . '
				AND mkc.TANGGAL <= ' . $tgl_filter_2 . '
				AND mkc.APP_ID = "2"
				) t_observasi
				ORDER BY APD_ID';
$extparam = '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2;
?>
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
		<th>Tanggal</th>
		<th>Nama Petugas</th>
        <th>Penggunaan APD</th>
		<th>Keterangan</th>
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
			<td><?php echo $data['NAMA_PEGAWAI']; ?></td>
			<td align="center"><?php if($data['PENGGUNAAN_APD'] == '1') echo 'Lengkap'; ?></td>
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
					<input type="hidden" name="xlsfile" value="indikator_mutu/xls_mutu_penggunaan_apd.php" />
                    <input type="hidden" name="xlsname" value="rpt_mutu_kepatuhan_cuci_tangan.xls" />            
        </form>		