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

$unit_id = '';
if (isset($_POST['unit_id']))
		$unit_id = $_POST['unit_id'];

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}	

if(!empty($unit_id))
	$qry_filter = 'AND t_irna.UNIT_ID = "' . $unit_id . '" ';

$qry_kunjungan = 'SELECT m_unit.UNIT_ID,m_unit.NAMA_UNIT, DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%Y/%m/%d") AS TANGGAL,';

$qry_jaminan = 'SELECT DISTINCT m_jaminan.JAMINAN_ID, m_jaminan.NAMA_JAMINAN 
				FROM m_jaminan 
				INNER JOIN t_irna ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_irna.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND t_irna.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
				' . $qry_filter . ' AND t_irna.NO_PENDAFTARAN IS NOT NULL AND t_irna.ST_BATAL IS NULL
				ORDER BY PENDAFTARAN DESC, URUT ASC';
$get_jaminan = mysql_query($qry_jaminan) or die(mysql_error());
$i = 1;
$field_name = array();
while($dat_jaminan = mysql_fetch_array($get_jaminan)){
	$qry_kunjungan = $qry_kunjungan . ' COUNT(CASE WHEN t_irna.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
										AND t_irna.ST_BARU = "1"
										THEN t_irna.IRNA_ID END) AS FIELD_BR_' . $i . ',
										COUNT(CASE WHEN t_irna.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
										AND t_irna.ST_BARU <> "1"
										THEN t_irna.IRNA_ID END) AS FIELD_LM_' . $i . ',
										COUNT(CASE WHEN t_irna.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
										AND m_pasien.JNS_KELAMIN = "L"
										THEN t_irna.IRNA_ID END) AS FIELD_LK_' . $i . ',
										COUNT(CASE WHEN t_irna.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
										AND m_pasien.JNS_KELAMIN = "P"
										THEN t_irna.IRNA_ID END) AS FIELD_PR_' . $i . ',
										COUNT(CASE WHEN t_irna.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '"
										THEN t_irna.IRNA_ID END) AS FIELD_JM_' . $i . ',';
	$field_name[$i] = $dat_jaminan['NAMA_JAMINAN']; 									
$i++;	
}
	$qry_kunjungan = $qry_kunjungan . 'COUNT(CASE WHEN t_irna.ST_BARU = "1" THEN t_irna.IRNA_ID END) AS TOT_BR,
				COUNT(CASE WHEN t_irna.ST_BARU <> "1" THEN t_irna.IRNA_ID END) AS TOT_LM,
				COUNT(CASE WHEN m_pasien.JNS_KELAMIN = "L" THEN t_irna.IRNA_ID END) AS TOT_LK,
				COUNT(CASE WHEN m_pasien.JNS_KELAMIN = "P" THEN t_irna.IRNA_ID END) AS TOT_PR,
				COUNT(t_irna.IRNA_ID) AS TOTAL
				FROM t_irna
				INNER JOIN m_unit ON (m_unit.UNIT_ID = t_irna.UNIT_ID)
				INNER JOIN m_pasien ON (m_pasien.NOMR = t_irna.NOMR)
				INNER JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_irna.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND t_irna.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
				' . $qry_filter . ' AND t_irna.NO_PENDAFTARAN IS NOT NULL AND t_irna.ST_BATAL IS NULL
				GROUP BY m_unit.UNIT_ID,m_unit.NAMA_UNIT, DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%Y/%m/%d")
				ORDER BY m_unit.NAMA_UNIT, DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%Y/%m/%d")';
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());	
?>
<table width="100%" border="1" >
	<tr>
		<th colspan="<?php echo 8 + (5 *($i-1)); ?>">Laporan Pasien Harian Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>	
  <tr>
    <th rowspan="3" width="5">No</th>
    <th rowspan="3">Poliklinik</th>
	<th rowspan="3">Tgl</th>
    <th colspan="<?php echo 5 *($i-1); ?>">Jenis Pembayaran</th><th rowspan="2" colspan="5">Total</th>
  </tr>
  <tr>
    <?php
	$x = 1;
	while($x < $i){
		echo '<th colspan="5">' . $field_name[$x] . '</th>';
	$x++;
	}
	?>
  </tr>
  <tr>
    <?php
	$x = 1;
	while($x < $i){
	?>
		<th>Br</th>
		<th>Lm</th>
		<th>Lk</th>
		<th>Pr</th>
		<th>Jml</th>
	<?php
	$x++;
	}
	?>
		<th>Br</th>
		<th>Lm</th>
		<th>Lk</th>
		<th>Pr</th>
		<th>Jml</th>
  </tr>
 <?php $no = 1;
	$rs = mysql_query($qry_kunjungan) or die(mysql_error());
    while ($data = mysql_fetch_array($rs)) { ?>  
  <tr>
    <td scope="row" align="center"><?php echo $no; ?></td>
    <td><?php echo $data['NAMA_UNIT']; ?></td>
	<td><?php echo $data['TANGGAL']; ?></td>
    <?php
	$x = 1;
	while($x < $i){
		echo '<td align="right">' . currFormat($data['FIELD_BR_'. $x]) . '</td>';
		echo '<td align="right">' . currFormat($data['FIELD_LM_'. $x]) . '</td>';
		echo '<td align="right">' . currFormat($data['FIELD_LK_'. $x]) . '</td>';
		echo '<td align="right">' . currFormat($data['FIELD_PR_'. $x]) . '</td>';
		echo '<td align="right">' . currFormat($data['FIELD_JM_'. $x]) . '</td>';
	$x++;
	}
	?>
    <td align="right"><?php echo currFormat($data['TOT_BR']); ?></td>
	<td align="right"><?php echo currFormat($data['TOT_LM']); ?></td>
	<td align="right"><?php echo currFormat($data['TOT_LK']); ?></td>
	<td align="right"><?php echo currFormat($data['TOT_PR']); ?></td>
	<td align="right"><?php echo currFormat($data['TOTAL']); ?></td>
  </tr>
 <?php $no++; } ?> 
</table>