<?php
$tgl_1 = '';
if (isset($_SESSION['pembayaranreportrekapbayar_tgl_1']))
    $tgl_1 = $_SESSION['pembayaranreportrekapbayar_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['pembayaranreportrekapbayar_tgl_1']))
    $tgl_2 = $_SESSION['pembayaranreportrekapbayar_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['pembayaranreportrekapbayar_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['pembayaranreportrekapbayar_tgl_2'] = $_GET['tgl_2'];
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
            <td align="right"><input type="submit" value="cari" class="myButton" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_kunjungan = 'SELECT m_unit.UNIT_ID,m_unit.NAMA_UNIT,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "1" THEN t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS ELSE 0 END) AS BAYAR_SHIFT_1,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "2" THEN t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS ELSE 0 END) AS BAYAR_SHIFT_2,
				SUM(CASE WHEN t_irja_tarif.SHIFT_ID = "3" THEN t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS ELSE 0 END) AS BAYAR_SHIFT_3
				FROM m_unit
				LEFT JOIN t_irja ON (m_unit.UNIT_ID = t_irja.UNIT_ID AND t_irja.JENIS_BAYAR_ID = "1" AND t_irja.ST_BATAL IS NULL)
				LEFT JOIN t_irja_tarif ON (t_irja.IRJA_ID = t_irja_tarif.IRJA_ID AND t_irja_tarif.NO_PEMBAYARAN IS NOT NULL
				AND t_irja_tarif.ST_BAYAR = "Lunas"
				AND STR_TO_DATE(DATE_FORMAT(t_irja_tarif.TGL_BAYAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' AND STR_TO_DATE(DATE_FORMAT(t_irja_tarif.TGL_BAYAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . ')
				LEFT JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
				WHERE m_unit.IRJA IS NOT NULL
				GROUP BY m_unit.UNIT_ID,m_unit.NAMA_UNIT ORDER BY m_unit.NAMA_UNIT';
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());	
?>
<table width="100%" border="1" class="tableData" id="tfhover">
  
  <tr>
    <th width="10">No</th>
    <th>Poliklinik</th>
    <th >Shift 1 </th>
    <th >Shift 2 </th>
    <th>Shift 3 </th>
    <th>Total</th>
  </tr>
<?php $no = 1; 
while($dat_kunjungan = mysql_fetch_array($get_kunjungan)){ ?>  
  <tr>
    <td scope="row" align="center"><?php echo $no; ?></td>
    <td><?php echo $dat_kunjungan['NAMA_UNIT']; ?></td>
    <td align="right"><?php echo currFormat($dat_kunjungan['BAYAR_SHIFT_1']); ?></td>
    <td align="right"><?php echo currFormat($dat_kunjungan['BAYAR_SHIFT_2']); ?></td>
    <td align="right"><?php echo currFormat($dat_kunjungan['BAYAR_SHIFT_3']); ?></td>
    <td align="right"><?php echo currFormat($dat_kunjungan['BAYAR_SHIFT_1'] + $dat_kunjungan['BAYAR_SHIFT_2'] + $dat_kunjungan['BAYAR_SHIFT_3']); ?></td>
  </tr>
 <?php $no++; } ?> 
</table>

