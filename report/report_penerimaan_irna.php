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
$qry_kunjungan = 'SELECT m_tarif.NAMA_TARIF, m_tarif_group.NAMA_TARIF_GROUP, ';

$qry_jaminan = 'SELECT DISTINCT m_jaminan.JAMINAN_ID, m_jaminan.NAMA_JAMINAN 
				FROM m_jaminan 
				INNER JOIN t_irna ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN t_irna_tarif ON (t_irna.IRNA_ID = t_irna_tarif.IRNA_ID)
				WHERE STR_TO_DATE(DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				AND t_irna.NO_PENDAFTARAN IS NOT NULL AND t_irna.ST_BATAL IS NULL
				AND t_irna_tarif.NO_TARIF IS NOT NULL
				AND (t_irna_tarif.ST_BAYAR IS NULL OR t_irna_tarif.ST_BAYAR = "Lunas") 
				ORDER BY PENDAFTARAN DESC, URUT ASC';
$get_jaminan = mysql_query($qry_jaminan) or die(mysql_error());
$i = 1;
$field_name = array();
while($dat_jaminan = mysql_fetch_array($get_jaminan)){
	$qry_kunjungan = $qry_kunjungan . ' COUNT(CASE WHEN t_irna.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
										AND t_irna.KELAS_RAWAT = "3"	
										THEN t_irna_tarif.IRNA_TARIF_ID END) AS FIELD_3_JMTRF_' . $i . ',
										SUM(CASE WHEN t_irna.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
										AND t_irna.KELAS_RAWAT = "3"
										THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_KELAS_3 END) AS FIELD_3_BYTRF_' . $i . ',
										COUNT(CASE WHEN t_irna.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
										AND t_irna.KELAS_RAWAT = "2"	
										THEN t_irna_tarif.IRNA_TARIF_ID END) AS FIELD_2_JMTRF_' . $i . ',
										SUM(CASE WHEN t_irna.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
										AND t_irna.KELAS_RAWAT = "2"
										THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_KELAS_2 END) AS FIELD_2_BYTRF_' . $i . ',
										COUNT(CASE WHEN t_irna.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
										AND t_irna.KELAS_RAWAT = "1"	
										THEN t_irna_tarif.IRNA_TARIF_ID END) AS FIELD_1_JMTRF_' . $i . ',
										SUM(CASE WHEN t_irna.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
										AND t_irna.KELAS_RAWAT = "1"
										THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_KELAS_1 END) AS FIELD_1_BYTRF_' . $i . ',
										COUNT(CASE WHEN t_irna.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
										AND t_irna.KELAS_RAWAT = "Utama"	
										THEN t_irna_tarif.IRNA_TARIF_ID END) AS FIELD_U_JMTRF_' . $i . ',
										SUM(CASE WHEN t_irna.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
										AND t_irna.KELAS_RAWAT = "Utama"
										THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_KELAS_UTAMA END) AS FIELD_U_BYTRF_' . $i . ',';
	$field_name[$i] = $dat_jaminan['NAMA_JAMINAN']; 									
$i++;	
}
	$qry_kunjungan = $qry_kunjungan . 'COUNT(CASE WHEN t_irna.KELAS_RAWAT = "3" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TOT_3_JMTRF,
				SUM(CASE WHEN t_irna.KELAS_RAWAT = "3" THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_KELAS_3 END) AS TOT_3_BYTRF,
				COUNT(CASE WHEN t_irna.KELAS_RAWAT = "2" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TOT_2_JMTRF,
				SUM(CASE WHEN t_irna.KELAS_RAWAT = "2" THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_KELAS_2 END) AS TOT_2_BYTRF,
				COUNT(CASE WHEN t_irna.KELAS_RAWAT = "1" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TOT_1_JMTRF,
				SUM(CASE WHEN t_irna.KELAS_RAWAT = "1" THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_KELAS_1 END) AS TOT_1_BYTRF,
				COUNT(CASE WHEN t_irna.KELAS_RAWAT = "Utama" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TOT_U_JMTRF,
				SUM(CASE WHEN t_irna.KELAS_RAWAT = "Utama" THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_KELAS_UTAMA END) AS TOT_U_BYTRF
				FROM t_irna
				INNER JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN t_irna_tarif ON (t_irna.IRNA_ID = t_irna_tarif.IRNA_ID)
				INNER JOIN m_tarif ON (t_irna_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif_group.KODE_TARIF_GROUP = m_tarif.KODE_TARIF_GROUP)
				WHERE STR_TO_DATE(DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				AND t_irna.NO_PENDAFTARAN IS NOT NULL AND t_irna.ST_BATAL IS NULL
				AND t_irna_tarif.NO_TARIF IS NOT NULL
				AND (t_irna_tarif.ST_BAYAR IS NULL OR t_irna_tarif.ST_BAYAR = "Lunas")
				GROUP BY m_tarif.NAMA_TARIF, m_tarif_group.NAMA_TARIF_GROUP
				ORDER BY m_tarif.NAMA_TARIF,m_tarif_group.NAMA_TARIF_GROUP';
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());	
?>
<table width="100%" border="1" class="tableData" id="tfhover">
  <tr>
    <th rowspan="3" width="5">No</th>
	<th rowspan="3">Nama Tarif</th>
    <th colspan="<?php echo 8 *($i-1); ?>">Jenis Pembayaran</th><th rowspan="2" colspan="8">Total</th>
  </tr>
  <tr>
    <?php
	$x = 1;
	while($x < $i){
		echo '<th colspan="8">' . $field_name[$x] . '</th>';
	$x++;
	}
	?>
  </tr>
  <tr>
    <?php
	$x = 1;
	while($x < $i){
	?>
		<th>Jml 3</th>
		<th>Byr 3</th>
		<th>Jml 2</th>
		<th>Byr 2</th>
		<th>Jml 1</th>
		<th>Byr 1</th>
		<th>Jml Utm</th>
		<th>Byr Utm</th>
	<?php
	$x++;
	}
	?>
		<th>Jml 3</th>
		<th>Byr 3</th>
		<th>Jml 2</th>
		<th>Byr 2</th>
		<th>Jml 1</th>
		<th>Byr 1</th>
		<th>Jml Utm</th>
		<th>Byr Utm</th>
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
	<td><?php echo $data['NAMA_TARIF'] . ' (' . $data['NAMA_TARIF_GROUP'] . ')'; ?></td>
    <?php
	$x = 1;
	while($x < $i){
		echo '<td align="right">' . currFormat($data['FIELD_3_JMTRF_'. $x]) . '</td>';
		echo '<td align="right">' . currFormat($data['FIELD_3_BYTRF_'. $x]) . '</td>';
		echo '<td align="right">' . currFormat($data['FIELD_2_JMTRF_'. $x]) . '</td>';
		echo '<td align="right">' . currFormat($data['FIELD_2_BYTRF_'. $x]) . '</td>';
		echo '<td align="right">' . currFormat($data['FIELD_1_JMTRF_'. $x]) . '</td>';
		echo '<td align="right">' . currFormat($data['FIELD_1_BYTRF_'. $x]) . '</td>';
		echo '<td align="right">' . currFormat($data['FIELD_U_JMTRF_'. $x]) . '</td>';
		echo '<td align="right">' . currFormat($data['FIELD_U_BYTRF_'. $x]) . '</td>';
	$x++;
	}
	?>
    <td align="right"><?php echo currFormat($data['TOT_3_JMTRF']); ?></td>
	<td align="right"><?php echo currFormat($data['TOT_3_BYTRF']); ?></td>
	<td align="right"><?php echo currFormat($data['TOT_2_JMTRF']); ?></td>
	<td align="right"><?php echo currFormat($data['TOT_2_BYTRF']); ?></td>
	<td align="right"><?php echo currFormat($data['TOT_1_JMTRF']); ?></td>
	<td align="right"><?php echo currFormat($data['TOT_1_BYTRF']); ?></td>
	<td align="right"><?php echo currFormat($data['TOT_U_JMTRF']); ?></td>
	<td align="right"><?php echo currFormat($data['TOT_U_BYTRF']); ?></td>
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
                    <input type="hidden" name="xlsfile" value="report/xls_report_penerimaan_irna.php" />
                    <input type="hidden" name="xlsname" value="rpt_report_penerimaan_irna.xls" />            
        </form>
