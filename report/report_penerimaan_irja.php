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

$unit_id = '';
if (isset($_SESSION['reportrekappenerimaan_unit_id']))
		$unit_id = $_SESSION['reportrekappenerimaan_unit_id'];

if (isset($_GET['unit_id'])) {
    $unit_id = $_GET['unit_id'];
	$_SESSION['reportrekappenerimaan_unit_id'] = $unit_id;
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
			<td>Poliklinik</td>	
			<td><select name="unit_id" class="text_dt" >
				<option value=""> - </option>
				<?php echo getUnit('umum',$unit_id); ?>
			</select></td>	
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
$qry_filter = '';
if(!empty($unit_id))
	$qry_filter = 'AND t_irja.UNIT_ID = "' . $unit_id . '" ';

$qry_kunjungan = 'SELECT m_unit.UNIT_ID,m_unit.NAMA_UNIT, m_tarif.NAMA_TARIF, m_tarif_group.NAMA_TARIF_GROUP, ';

$qry_jaminan = 'SELECT DISTINCT m_jaminan.JAMINAN_ID, m_jaminan.NAMA_JAMINAN 
				FROM m_jaminan 
				INNER JOIN t_irja ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN t_irja_tarif ON (t_irja.IRJA_ID = t_irja_tarif.IRJA_ID)
				WHERE t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
				' . $qry_filter . ' AND t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL
				AND t_irja.UNIT_ID <> 35 AND t_irja.UNIT_ID <> 9
				AND t_irja_tarif.NO_TARIF IS NOT NULL
				AND (t_irja_tarif.ST_BAYAR IS NULL OR t_irja_tarif.ST_BAYAR = "Lunas") 
				ORDER BY PENDAFTARAN DESC, URUT ASC';
$get_jaminan = mysql_query($qry_jaminan) or die(mysql_error());
$i = 1;
$field_name = array();
while($dat_jaminan = mysql_fetch_array($get_jaminan)){
	$qry_kunjungan = $qry_kunjungan . ' COUNT(CASE WHEN t_irja.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
										THEN t_irja_tarif.IRJA_TARIF_ID END) AS FIELD_JMTRF_' . $i . ',
										SUM(CASE WHEN t_irja.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
										THEN t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS END) AS FIELD_BYTRF_' . $i . ',';
	$field_name[$i] = $dat_jaminan['NAMA_JAMINAN']; 									
$i++;	
}
	$qry_kunjungan = $qry_kunjungan . 'COUNT(t_irja_tarif.IRJA_TARIF_ID) AS TOT_JMTRF,
				SUM(t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS TOT_BYTRF
				FROM t_irja
				INNER JOIN m_unit ON (m_unit.UNIT_ID = t_irja.UNIT_ID)
				INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN t_irja_tarif ON (t_irja.IRJA_ID = t_irja_tarif.IRJA_ID)
				INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif_group.KODE_TARIF_GROUP = m_tarif.KODE_TARIF_GROUP)
				WHERE t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
				' . $qry_filter . ' AND t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL
				AND t_irja.UNIT_ID <> 35 AND t_irja.UNIT_ID <> 9
				AND t_irja_tarif.NO_TARIF IS NOT NULL
				AND (t_irja_tarif.ST_BAYAR IS NULL OR t_irja_tarif.ST_BAYAR = "Lunas")
				GROUP BY m_unit.UNIT_ID,m_unit.NAMA_UNIT, m_tarif.NAMA_TARIF, m_tarif_group.NAMA_TARIF_GROUP
				ORDER BY m_unit.NAMA_UNIT,m_tarif.NAMA_TARIF,m_tarif_group.NAMA_TARIF_GROUP';
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());	
?>
<table width="100%" border="1" class="tableData" id="tfhover">
  <tr>
    <th rowspan="3" width="5">No</th>
    <th rowspan="3">Poliklinik</th>
	<th rowspan="3">Nama Tarif</th>
    <th colspan="<?php echo 2 *($i-1); ?>">Jenis Pembayaran</th><th rowspan="2" colspan="2">Total</th>
  </tr>
  <tr>
    <?php
	$x = 1;
	while($x < $i){
		echo '<th colspan="2">' . $field_name[$x] . '</th>';
	$x++;
	}
	?>
  </tr>
  <tr>
    <?php
	$x = 1;
	while($x < $i){
	?>
		<th>Jumlah</th>
		<th>Bayar</th>
	<?php
	$x++;
	}
	?>
		<th>Jumlah</th>
		<th>Bayar</th>
  </tr>
 <?php $no = 0;
	$extparam = '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&unit_id=' . $unit_id;
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
    <td><?php echo $data['NAMA_UNIT']; ?></td>
	<td><?php echo $data['NAMA_TARIF'] . ' (' . $data['NAMA_TARIF_GROUP'] . ')'; ?></td>
    <?php
	$x = 1;
	while($x < $i){
		echo '<td align="right">' . currFormat($data['FIELD_JMTRF_'. $x]) . '</td>';
		echo '<td align="right">' . currFormat($data['FIELD_BYTRF_'. $x]) . '</td>';
	$x++;
	}
	?>
    <td align="right"><?php echo currFormat($data['TOT_JMTRF']); ?></td>
	<td align="right"><?php echo currFormat($data['TOT_BYTRF']); ?></td>
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
                    <input type="hidden" name="unit_id" value="<?php echo $unit_id; ?>" />
                    <input type="hidden" name="xlsfile" value="report/xls_report_penerimaan_irja.php" />
                    <input type="hidden" name="xlsname" value="rpt_report_penerimaan_irja.xls" />            
        </form>
