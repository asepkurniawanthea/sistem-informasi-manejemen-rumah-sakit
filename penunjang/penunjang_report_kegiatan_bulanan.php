<?php
$tgl_1 = '';
if (isset($_SESSION['penunjangrekaptindakanbulanan_tgl_1']))
    $tgl_1 = $_SESSION['penunjangrekaptindakanbulanan_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['penunjangrekaptindakanbulanan_tgl_1']))
    $tgl_2 = $_SESSION['penunjangrekaptindakanbulanan_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['penunjangrekaptindakanbulanan_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['penunjangrekaptindakanbulanan_tgl_2'] = $_GET['tgl_2'];
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
$qry_kunjungan = 'SELECT m_tarif.NAMA_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%Y/%m") AS TANGGAL_DAFTAR,
					COUNT(DISTINCT CASE WHEN DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d") = "01" THEN t_ipenunjang_tarif.NO_TARIF END) AS FIELD_01,
					COUNT(DISTINCT CASE WHEN DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d") = "02" THEN t_ipenunjang_tarif.NO_TARIF END) AS FIELD_02,
					COUNT(DISTINCT CASE WHEN DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d") = "03" THEN t_ipenunjang_tarif.NO_TARIF END) AS FIELD_03,
					COUNT(DISTINCT CASE WHEN DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d") = "04" THEN t_ipenunjang_tarif.NO_TARIF END) AS FIELD_04,
					COUNT(DISTINCT CASE WHEN DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d") = "05" THEN t_ipenunjang_tarif.NO_TARIF END) AS FIELD_05,
					COUNT(DISTINCT CASE WHEN DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d") = "06" THEN t_ipenunjang_tarif.NO_TARIF END) AS FIELD_06,
					COUNT(DISTINCT CASE WHEN DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d") = "07" THEN t_ipenunjang_tarif.NO_TARIF END) AS FIELD_07,
					COUNT(DISTINCT CASE WHEN DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d") = "08" THEN t_ipenunjang_tarif.NO_TARIF END) AS FIELD_08,
					COUNT(DISTINCT CASE WHEN DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d") = "09" THEN t_ipenunjang_tarif.NO_TARIF END) AS FIELD_09,
					COUNT(DISTINCT CASE WHEN DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d") = "10" THEN t_ipenunjang_tarif.NO_TARIF END) AS FIELD_10,
					
					COUNT(DISTINCT CASE WHEN DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d") = "11" THEN t_ipenunjang_tarif.NO_TARIF END) AS FIELD_11,
					COUNT(DISTINCT CASE WHEN DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d") = "12" THEN t_ipenunjang_tarif.NO_TARIF END) AS FIELD_12,
					COUNT(DISTINCT CASE WHEN DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d") = "13" THEN t_ipenunjang_tarif.NO_TARIF END) AS FIELD_13,
					COUNT(DISTINCT CASE WHEN DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d") = "14" THEN t_ipenunjang_tarif.NO_TARIF END) AS FIELD_14,
					COUNT(DISTINCT CASE WHEN DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d") = "15" THEN t_ipenunjang_tarif.NO_TARIF END) AS FIELD_15,
					COUNT(DISTINCT CASE WHEN DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d") = "16" THEN t_ipenunjang_tarif.NO_TARIF END) AS FIELD_16,
					COUNT(DISTINCT CASE WHEN DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d") = "17" THEN t_ipenunjang_tarif.NO_TARIF END) AS FIELD_17,
					COUNT(DISTINCT CASE WHEN DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d") = "18" THEN t_ipenunjang_tarif.NO_TARIF END) AS FIELD_18,
					COUNT(DISTINCT CASE WHEN DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d") = "19" THEN t_ipenunjang_tarif.NO_TARIF END) AS FIELD_19,
					COUNT(DISTINCT CASE WHEN DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d") = "20" THEN t_ipenunjang_tarif.NO_TARIF END) AS FIELD_20,
					
					COUNT(DISTINCT CASE WHEN DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d") = "21" THEN t_ipenunjang_tarif.NO_TARIF END) AS FIELD_21,
					COUNT(DISTINCT CASE WHEN DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d") = "22" THEN t_ipenunjang_tarif.NO_TARIF END) AS FIELD_22,
					COUNT(DISTINCT CASE WHEN DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d") = "23" THEN t_ipenunjang_tarif.NO_TARIF END) AS FIELD_23,
					COUNT(DISTINCT CASE WHEN DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d") = "24" THEN t_ipenunjang_tarif.NO_TARIF END) AS FIELD_24,
					COUNT(DISTINCT CASE WHEN DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d") = "25" THEN t_ipenunjang_tarif.NO_TARIF END) AS FIELD_25,
					COUNT(DISTINCT CASE WHEN DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d") = "26" THEN t_ipenunjang_tarif.NO_TARIF END) AS FIELD_26,
					COUNT(DISTINCT CASE WHEN DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d") = "27" THEN t_ipenunjang_tarif.NO_TARIF END) AS FIELD_27,
					COUNT(DISTINCT CASE WHEN DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d") = "28" THEN t_ipenunjang_tarif.NO_TARIF END) AS FIELD_28,
					COUNT(DISTINCT CASE WHEN DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d") = "29" THEN t_ipenunjang_tarif.NO_TARIF END) AS FIELD_29,
					COUNT(DISTINCT CASE WHEN DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d") = "30" THEN t_ipenunjang_tarif.NO_TARIF END) AS FIELD_30,
					COUNT(DISTINCT CASE WHEN DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d") = "31" THEN t_ipenunjang_tarif.NO_TARIF END) AS FIELD_31,
					COUNT(DISTINCT t_ipenunjang_tarif.NO_TARIF) AS TOTAL		
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				WHERE STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL AND t_ipenunjang_tarif.ST_BATAL IS NULL
				AND t_ipenunjang_tarif.ST_PERIKSA = "1"
				AND t_ipenunjang_tarif.UNIT_PENUNJANG_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '"
				AND m_tarif.KODE_TARIF_GROUP <> "01" 
				GROUP BY m_tarif.NAMA_TARIF,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%Y/%m")
				ORDER BY DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%Y/%m"),m_tarif.NAMA_TARIF';
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());	

?>
<table width="100%" border="1" class="tableData" id="tfhover">
  <tr>
    <th rowspan="2" width="5">No</th>
	<th rowspan="2">Nama Pemeriksaan</th>
	<th rowspan="2">Bulan</th>
    <th colspan="31">Tanggal</th><th rowspan="2">Total</th>
  </tr>
  <tr>
    <th>01</th>
	<th>02</th>
	<th>03</th>
	<th>04</th>
	<th>05</th>
	<th>06</th>
	<th>07</th>
	<th>08</th>
	<th>09</th>
	<th>10</th>
	<th>11</th>
	<th>12</th>
	<th>13</th>
	<th>14</th>
	<th>15</th>
	<th>16</th>
	<th>17</th>
	<th>18</th>
	<th>19</th>
	<th>20</th>
	<th>21</th>
	<th>22</th>
	<th>23</th>
	<th>24</th>
	<th>25</th>
	<th>26</th>
	<th>27</th>
	<th>28</th>
	<th>29</th>
	<th>30</th>
	<th>31</th>
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
	<td><?php echo $data['NAMA_TARIF']; ?></td>	
	<td><?php echo $data['TANGGAL_DAFTAR']; ?></td>	
	<td align="right"><?php echo currFormat($data['FIELD_01']); ?></td>
	<td align="right"><?php echo currFormat($data['FIELD_02']); ?></td>
	<td align="right"><?php echo currFormat($data['FIELD_03']); ?></td>
	<td align="right"><?php echo currFormat($data['FIELD_04']); ?></td>
	<td align="right"><?php echo currFormat($data['FIELD_05']); ?></td>
	<td align="right"><?php echo currFormat($data['FIELD_06']); ?></td>
	<td align="right"><?php echo currFormat($data['FIELD_07']); ?></td>
	<td align="right"><?php echo currFormat($data['FIELD_08']); ?></td>
	<td align="right"><?php echo currFormat($data['FIELD_09']); ?></td>
	<td align="right"><?php echo currFormat($data['FIELD_10']); ?></td>
	<td align="right"><?php echo currFormat($data['FIELD_11']); ?></td>
	<td align="right"><?php echo currFormat($data['FIELD_12']); ?></td>
	<td align="right"><?php echo currFormat($data['FIELD_13']); ?></td>
	<td align="right"><?php echo currFormat($data['FIELD_14']); ?></td>
	<td align="right"><?php echo currFormat($data['FIELD_15']); ?></td>
	<td align="right"><?php echo currFormat($data['FIELD_16']); ?></td>
	<td align="right"><?php echo currFormat($data['FIELD_17']); ?></td>
	<td align="right"><?php echo currFormat($data['FIELD_18']); ?></td>
	<td align="right"><?php echo currFormat($data['FIELD_19']); ?></td>
	<td align="right"><?php echo currFormat($data['FIELD_20']); ?></td>
	<td align="right"><?php echo currFormat($data['FIELD_21']); ?></td>
	<td align="right"><?php echo currFormat($data['FIELD_22']); ?></td>
	<td align="right"><?php echo currFormat($data['FIELD_23']); ?></td>
	<td align="right"><?php echo currFormat($data['FIELD_24']); ?></td>
	<td align="right"><?php echo currFormat($data['FIELD_25']); ?></td>
	<td align="right"><?php echo currFormat($data['FIELD_26']); ?></td>
	<td align="right"><?php echo currFormat($data['FIELD_27']); ?></td>
	<td align="right"><?php echo currFormat($data['FIELD_28']); ?></td>
	<td align="right"><?php echo currFormat($data['FIELD_29']); ?></td>
	<td align="right"><?php echo currFormat($data['FIELD_30']); ?></td>
	<td align="right"><?php echo currFormat($data['FIELD_31']); ?></td>
    <td align="right"><?php echo currFormat($data['TOTAL']); ?></td>
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
                    <input type="hidden" name="xlsfile" value="penunjang/xls_report_kegiatan_bulanan.php" />
                    <input type="hidden" name="xlsname" value="rpt_kegiatan_bulanan.xls" />            
        </form>
