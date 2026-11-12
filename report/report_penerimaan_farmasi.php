<?php
$tgl_1 = '';
if (isset($_SESSION['reportrekappenerimaan_tgl_1']))
    $tgl_1 = $_SESSION['reportrekappenerimaan_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['reportrekappenerimaan_tgl_1']))
    $tgl_2 = $_SESSION['reportrekappenerimaan_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['reportrekappenerimaan_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['reportrekappenerimaan_tgl_2'] = $_GET['tgl_2'];
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
    <table class="tableform" border="0" >
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
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/>
            </td>	
			<td>&nbsp;</td>
            <td align="right"><input type="submit" value="cari" class="myButton" />&nbsp;
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
mysql_select_db($database_3, $connect_3) or die(mysql_error());

$qry_kunjungan = 'SELECT CASE WHEN t_farmasi_apotik_pengeluaran.JAMINAN_ID IS NULL THEN 1 ELSE t_farmasi_apotik_pengeluaran.JAMINAN_ID END AS JAMINAN_ID,
					CASE WHEN t_farmasi_apotik_pengeluaran.JAMINAN_ID IS NULL THEN "Umum" ELSE m_jaminan.NAMA_JAMINAN END AS NAMA_JAMINAN,
					SUM(CASE WHEN t_farmasi_apotik_pengeluaran.JENIS_PENGELUARAN = "1" THEN
						(t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL * t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR) 
						- (t_farmasi_apotik_pengeluaran.PERSEN_JAMINAN / 100) * 
						(t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL * t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR) END) AS HARGA_IRJA,
					SUM(CASE WHEN t_farmasi_apotik_pengeluaran.JENIS_PENGELUARAN = "2" THEN
						(t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL * t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR) 
						- (t_farmasi_apotik_pengeluaran.PERSEN_JAMINAN / 100) * 
						(t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL * t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR) END) AS HARGA_IRNA,	
					SUM(CASE WHEN t_farmasi_apotik_pengeluaran.JENIS_PENGELUARAN = "3" THEN
						t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL * t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR END) AS HARGA_PNJ
					FROM t_farmasi_apotik_pengeluaran  
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
					LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengeluaran.JAMINAN_ID = m_jaminan.JAMINAN_ID)
					WHERE t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
					AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
					GROUP BY JAMINAN_ID';
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());	
?>
<table width="100%" border="1" class="tableData" id="tfhover">
  <tr>
    <th rowspan="2" width="5">No</th>
	<th rowspan="2">Nama Jaminan</th>
    <th colspan="3">Resep</th><th rowspan="2">Total</th>
  </tr>
  <tr>
    <th>Rawat Jalan & IGD</th>
	<th>Rawat Inap</th>
	<th>Penjualan Mandiri</th>
  </tr>
 <?php $no = 0;
	$extparam = '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2;
	$pager = new PS_Pagination($connect, $qry_kunjungan, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) { ?>  
  <tr>
    <td scope="row" align="center"><?
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
    echo ($hal * 10) + $no;
        ?></td>	
    <td><?php echo $data['NAMA_JAMINAN']; ?></td>
    <td align="right"><?php echo currFormat($data['HARGA_IRJA']); ?></td>
	<td align="right"><?php echo currFormat($data['HARGA_IRNA']); ?></td>
	<td align="right"><?php echo currFormat($data['HARGA_PNJ']); ?></td>
	<td align="right"><?php echo currFormat($data['HARGA_PNJ'] + $data['HARGA_IRNA'] + $data['HARGA_IRJA']); ?></td>
  </tr>
 <?php } ?> 
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
                    <input type="hidden" name="xlsfile" value="report/xls_report_penerimaan_farmasi.php" />
                    <input type="hidden" name="xlsname" value="rpt_report_penerimaan_farmasi.xls" />            
        </form>
