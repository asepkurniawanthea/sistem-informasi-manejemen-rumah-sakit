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
            <td align="right"><input type="submit" value="cari" class="myButton" />&nbsp;
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_kunjungan = 'SELECT m_unit.UNIT_ID,m_unit.NAMA_UNIT AS NAMA_UNIT_PENGIRIM,
	m_pegawai.NAMA_PEGAWAI AS NAMA_PEGAWAI_PENGIRIM,m_pegawai2.NAMA_PEGAWAI AS DOKTER_OPERASI,';

$qry_jaminan = 'SELECT JAMINAN_ID, NAMA_JAMINAN FROM m_jaminan ORDER BY PENDAFTARAN DESC, URUT ASC';
$get_jaminan = mysql_query($qry_jaminan) or die(mysql_error());
$i = 1;
$j = 1;
$field_name = array();
while($dat_jaminan = mysql_fetch_array($get_jaminan)){
	$qry_kunjungan = $qry_kunjungan . ' COUNT(CASE WHEN t_operasi.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
										THEN t_operasi.OPERASI_ID END) AS FIELD' . $i . ',';
	$field_name[$i] = $dat_jaminan['NAMA_JAMINAN']; 									
$i++; $j++;	
}
	$qry_kunjungan = $qry_kunjungan . 'COUNT(t_operasi.OPERASI_ID) AS TOTAL
				FROM t_operasi
				INNER JOIN m_unit ON (t_operasi.UNIT_ID = m_unit.UNIT_ID)
				LEFT JOIN m_pegawai ON (t_operasi.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_operasi.PEGAWAI_PELAKSANA_ID = m_pegawai2.PEGAWAI_ID)
				WHERE t_operasi.JNS_ORDER = "IRJ"
				AND t_operasi.NO_ORDER IS NOT NULL
				AND t_operasi.NO_PENDAFTARAN IS NOT NULL
				AND t_operasi.ST_APPROVE = "1"
				AND STR_TO_DATE(DATE_FORMAT(t_operasi.TGL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(t_operasi.TGL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				GROUP BY m_unit.UNIT_ID,m_unit.NAMA_UNIT,m_pegawai.NAMA_PEGAWAI,m_pegawai2.NAMA_PEGAWAI';	
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());	
?>
<table width="100%" border="1" class="tableData" id="tfhover">
  <tr>
    <th rowspan="2" width="5">No</th>
	<th rowspan="2">Asal Pasien</th>
	<th rowspan="2">Dokter Pengirim</th>
	<th rowspan="2">Dokter Operasi</th>
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
	<td><?php echo $dat_kunjungan['NAMA_UNIT_PENGIRIM']; ?></td>
	<td><?php echo $dat_kunjungan['NAMA_PEGAWAI_PENGIRIM']; ?></td>
	<td><?php echo $dat_kunjungan['DOKTER_OPERASI']; ?></td>
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
	<td colspan="<?php echo $x + 3; ?>" align="right">Total :&nbsp;&nbsp;</td>
	<td align="right"><?php echo currFormat($total); ?></td>
  </tr> 
</table>
<form id="xls_export" name="xls_export" method="post">
            <input type="hidden" name="page_to_excel" value="1" />
            <input type="hidden" name="tgl_1" value="<?php echo $tgl_1; ?>" />
            <input type="hidden" name="tgl_2" value="<?php echo $tgl_2; ?>" />
            <input type="hidden" name="xlsfile" value="pendaftaran/xls_rekap_pasien_operasi.php" />
            <input type="hidden" name="xlsname" value="rpt_pasien_operasi.xls" />            
        </form>
