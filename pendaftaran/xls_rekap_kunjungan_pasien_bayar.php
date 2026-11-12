<?php
include('./config/config.php');
include('./shared/connect_db.php');
include('./shared/function.php');

$tgl_1 = '';
if (isset($_POST['tgl_1']))
    $tgl_1 = $_POST['tgl_1'];
$tgl_2 = '';
if (isset($_POST['tgl_1']))
    $tgl_2 = $_POST['tgl_2'];

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}	

$qry_kunjungan = 'SELECT * FROM (SELECT m_unit.UNIT_ID,m_unit.NAMA_UNIT, ';

$qry_jaminan = 'SELECT JAMINAN_ID, NAMA_JAMINAN FROM m_jaminan ORDER BY PENDAFTARAN DESC, URUT ASC';
$get_jaminan = mysql_query($qry_jaminan) or die(mysql_error());
$i = 1;
$field_name = array();
while($dat_jaminan = mysql_fetch_array($get_jaminan)){
	$qry_kunjungan = $qry_kunjungan . ' COUNT(CASE WHEN t_irja.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
										THEN t_irja.IRJA_ID END) AS FIELD' . $i . ',';
	$field_name[$i] = $dat_jaminan['NAMA_JAMINAN']; 									
$i++;	
}
	$qry_kunjungan = $qry_kunjungan . 'COUNT(t_irja.IRJA_ID) AS TOTAL
				FROM m_unit
				LEFT JOIN t_irja ON (m_unit.UNIT_ID = t_irja.UNIT_ID
				AND t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
				AND t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL)
				LEFT JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE m_unit.IRJA IN ("umum","kusta","igd","mcu")
				GROUP BY m_unit.UNIT_ID,m_unit.NAMA_UNIT
				) t_order ORDER BY NAMA_UNIT';
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());	
?>
<table border="1" >
	<tr>
		<th colspan="<?php echo $i+2-1; ?>">Laporan Kunjungan Pasien Rawat Jalan Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>
	  <tr>
    <th rowspan="2" width="5">No</th>
    <th rowspan="2">Poliklinik</th>
    <th colspan="<?php echo $i-1; ?>">Jenis Pembayaran</th><th rowspan="2">Total</th>
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
 <?php $no = 1;
$total = 0; 
while($dat_kunjungan = mysql_fetch_array($get_kunjungan)){ ?>  
  <tr>
    <td scope="row" align="center"><?php echo $no; ?></td>
    <td><?php echo $dat_kunjungan['NAMA_UNIT']; ?></td>
    <?php
	$x = 1;
	while($x < $i){
		echo '<td align="right">' . currFormat($dat_kunjungan['FIELD'. $x]) . '</td>';
	$x++;
	}
	?>
    <td align="right"><?php echo currFormat($dat_kunjungan['TOTAL']); 
	$total = $total + $dat_kunjungan['TOTAL']; ?></td>
  </tr>
 <?php $no++; } ?> 
  <tr>
	<td colspan="16" align="right">Total :&nbsp;&nbsp;</td>
	<td align="right"><?php echo currFormat($total); ?></td>
  </tr>
</table>