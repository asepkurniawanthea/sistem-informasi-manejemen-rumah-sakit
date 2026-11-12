<?php
$tgl_1 = '';
if (isset($_SESSION['pendaftaranreportrekapkunjungan_tgl_1']))
    $tgl_1 = $_SESSION['pendaftaranreportrekapkunjungan_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['pendaftaranreportrekapkunjungan_tgl_1']))
    $tgl_2 = $_SESSION['pendaftaranreportrekapkunjungan_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['pendaftaranreportrekapkunjungan_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['pendaftaranreportrekapkunjungan_tgl_2'] = $_GET['tgl_2'];
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
$qry_kunjungan = 'SELECT UNIT_ID,NAMA_UNIT, ';
$qry_jaminan = 'SELECT JAMINAN_ID, NAMA_JAMINAN FROM m_jaminan ORDER BY PENDAFTARAN DESC, URUT ASC';
$get_jaminan = mysql_query($qry_jaminan) or die(mysql_error());
$i = 1;
while($dat_jaminan = mysql_fetch_array($get_jaminan)){
	$qry_kunjungan = $qry_kunjungan . ' SUM(FIELD' . $i . ') AS FIELD' . $i . ',';
$i++;	
}

$qry_kunjungan = $qry_kunjungan . 'SUM(TOTAL) AS TOTAL FROM (SELECT m_unit.UNIT_ID,m_unit.NAMA_UNIT, ';

$qry_jaminan = 'SELECT JAMINAN_ID, NAMA_JAMINAN FROM m_jaminan ORDER BY PENDAFTARAN DESC, URUT ASC';
$get_jaminan = mysql_query($qry_jaminan) or die(mysql_error());
$i = 1;
$j = 1;
$field_name = array();
while($dat_jaminan = mysql_fetch_array($get_jaminan)){
	$qry_kunjungan = $qry_kunjungan . ' COUNT(DISTINCT CASE WHEN t_ipenunjang_tarif.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
										THEN t_ipenunjang_tarif.NO_SJP END) AS FIELD' . $i . ',';
	$field_name[$i] = $dat_jaminan['NAMA_JAMINAN']; 									
$i++; $j++;	
}
	$qry_kunjungan = $qry_kunjungan . 'COUNT(DISTINCT CASE WHEN t_ipenunjang_tarif.JENIS_BAYAR_ID IS NOT NULL THEN t_ipenunjang_tarif.NO_SJP END) AS TOTAL
				FROM m_unit
				LEFT JOIN t_ipenunjang_tarif ON (m_unit.UNIT_ID = t_ipenunjang_tarif.UNIT_PENUNJANG_ID
				AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL AND t_ipenunjang_tarif.ST_BATAL = "1"
				AND t_ipenunjang_tarif.ST_TPP = "1"
				AND t_ipenunjang_tarif.PENUNJANG_ID NOT IN 
				(SELECT x.PENUNJANG_ID FROM t_ipenunjang x WHERE 
					x.MCU IN ("mcu1","mcu2","mcu3","mcu4","mcu5","mcu6","mcu7")))
				LEFT JOIN t_ipenunjang ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID AND t_ipenunjang.JNS_ORDER = "IRJ")
				LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE m_unit.PENUNJANG = "pnj"
				GROUP BY m_unit.UNIT_ID,m_unit.NAMA_UNIT) t_tran
				GROUP BY UNIT_ID,NAMA_UNIT';	
			
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());	
?>
<table width="100%" border="1" class="tableData" id="tfhover">
  <tr>
    <th rowspan="2" width="5">No</th>
    <th rowspan="2">Penunjang</th>
    <th colspan="<?php echo $i-1; ?>">Jenis Pembayaran</th><th rowspan="2">Total</th>
  </tr>
  <tr>
    <?php
	$x = 1;
	while($x < $j){
		echo '<th>' . $field_name[$x] . '</th>';
	$x++;
	}
	?>
  </tr>
 <?php $no = 1; 
 $total = 0;
while($dat_kunjungan = mysql_fetch_array($get_kunjungan)){ ?>  
  <tr>
    <td scope="row" align="center"><?php echo $no; ?></td>
    <td><?php echo $dat_kunjungan['NAMA_UNIT']; ?></td>
    <?php
	$x = 1;
	while($x < $j){
		echo '<td align="right">' . currFormat($dat_kunjungan['FIELD'. $x]) . '</td>';
	$x++;
	}
	?>
    <td align="right"><?php echo currFormat($dat_kunjungan['TOTAL']); 
	$total = $total + $dat_kunjungan['TOTAL']; ?></td>
  </tr>
 <?php $no++; } ?> 
   <tr>
	<td colspan="<?php echo $i+1; ?>" align="right">Total :&nbsp;&nbsp;</td>
	<td align="right"><?php echo currFormat($total); ?></td>
  </tr> 
</table>

