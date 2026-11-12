<?php
$tgl_1 = '';
if (isset($_SESSION['laboratoriumrekaptindakan_tgl_1']))
    $tgl_1 = $_SESSION['laboratoriumrekaptindakan_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['laboratoriumrekaptindakan_tgl_1']))
    $tgl_2 = $_SESSION['laboratoriumrekaptindakan_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['laboratoriumrekaptindakan_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['laboratoriumrekaptindakan_tgl_2'] = $_GET['tgl_2'];
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
$qry_kunjungan = 'SELECT m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER,';

$qry_jaminan = 'SELECT DISTINCT m_jaminan.JAMINAN_ID, m_jaminan.NAMA_JAMINAN 
				FROM m_jaminan 
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN t_ipenunjang ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				WHERE STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL AND t_ipenunjang_tarif.ST_BATAL IS NULL
				AND t_ipenunjang_tarif.ST_PERIKSA = "1"
				ORDER BY m_jaminan.PENDAFTARAN DESC, m_jaminan.URUT ASC';
$get_jaminan = mysql_query($qry_jaminan) or die(mysql_error());
$i = 1;
$field_name = array();
while($dat_jaminan = mysql_fetch_array($get_jaminan)){
	$qry_kunjungan = $qry_kunjungan . ' COUNT(DISTINCT CASE WHEN t_ipenunjang.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
														THEN t_ipenunjang_tarif.NO_TARIF END) AS FIELD_JM_' . $i . ',';
	$field_name[$i] = $dat_jaminan['NAMA_JAMINAN']; 									
$i++;	
}
	$qry_kunjungan = $qry_kunjungan . 'COUNT(DISTINCT t_ipenunjang_tarif.NO_TARIF) AS TOTAL		
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				WHERE STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL AND t_ipenunjang_tarif.ST_BATAL IS NULL
				AND t_ipenunjang_tarif.ST_PERIKSA = "1"
				AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
				OR m_tarif.UNIT_ID = "45") 
				GROUP BY m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER
				ORDER BY m_tarif_pemeriksaan.CH_REPORT,m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER';
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());	

?>
<table width="100%" border="1" class="tableData" id="tfhover">
  <tr>
    <th rowspan="2" width="5">No</th>
	<th rowspan="2">Nama Pemeriksaan</th>
    <th colspan="<?php echo 1 *($i-1); ?>">Jenis Pembayaran</th><th rowspan="2">Total</th>
  </tr>
  <tr>
    <?php
	$x = 1;
	while($x < $i){
		echo '<th>' . $field_name[$x] . '</th>';
	$x++;
	}
	?>
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
	<td><?php echo $data['NAMA_PEMERIKSAAN_ORDER']; ?></td>	
    <?php
	$x = 1;
	while($x < $i){
		echo '<td align="right">' . currFormat($data['FIELD_JM_'. $x]) . '</td>';
	$x++;
	}
	?>
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
                    <input type="hidden" name="xlsfile" value="laboratorium/xls_report_tindakan_pemeriksaan.php" />
                    <input type="hidden" name="xlsname" value="rpt_kegiatan.xls" />            
        </form>
