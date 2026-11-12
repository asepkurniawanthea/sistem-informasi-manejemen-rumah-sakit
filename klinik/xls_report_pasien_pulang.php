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
	$qry_filter = 'AND t_irja.UNIT_ID = "' . $unit_id . '" ';

$qry_kunjungan = 'SELECT m_unit.UNIT_ID,m_unit.NAMA_UNIT, DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y/%m/%d") AS TANGGAL,m_pegawai.NAMA_PEGAWAI,';

$qry_pulang = 'SELECT DISTINCT m_pasien_pulang.PASIEN_PULANG_ID, m_pasien_pulang.KET_PASIEN_PULANG 
				FROM m_pasien_pulang 
				INNER JOIN t_irja ON (t_irja.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID)
				WHERE t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
				' . $qry_filter . ' AND t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL';
$get_pulang = mysql_query($qry_pulang) or die(mysql_error());
$i = 1;
$field_name = array();
while($dat_pulang = mysql_fetch_array($get_pulang)){
	$qry_kunjungan = $qry_kunjungan . ' COUNT(CASE WHEN t_irja.PASIEN_PULANG_ID = "' . $dat_pulang['PASIEN_PULANG_ID'] . '" 
										AND t_irja.ST_BARU = "1"
										THEN t_irja.IRJA_ID END) AS FIELD_BR_' . $i . ',
										COUNT(CASE WHEN t_irja.PASIEN_PULANG_ID = "' . $dat_pulang['PASIEN_PULANG_ID'] . '" 
										AND t_irja.ST_BARU <> "1"
										THEN t_irja.IRJA_ID END) AS FIELD_LM_' . $i . ',
										COUNT(CASE WHEN t_irja.PASIEN_PULANG_ID = "' . $dat_pulang['PASIEN_PULANG_ID'] . '" 
										AND m_pasien.JNS_KELAMIN = "L"
										THEN t_irja.IRJA_ID END) AS FIELD_LK_' . $i . ',
										COUNT(CASE WHEN t_irja.PASIEN_PULANG_ID = "' . $dat_pulang['PASIEN_PULANG_ID'] . '" 
										AND m_pasien.JNS_KELAMIN = "P"
										THEN t_irja.IRJA_ID END) AS FIELD_PR_' . $i . ',
										COUNT(CASE WHEN t_irja.PASIEN_PULANG_ID = "' . $dat_pulang['PASIEN_PULANG_ID'] . '"
										THEN t_irja.IRJA_ID END) AS FIELD_JM_' . $i . ',';
	$field_name[$i] = $dat_pulang['KET_PASIEN_PULANG']; 									
$i++;	
}
	$qry_kunjungan = $qry_kunjungan . 'COUNT(CASE WHEN t_irja.ST_BARU = "1" THEN t_irja.IRJA_ID END) AS TOT_BR,
				COUNT(CASE WHEN t_irja.ST_BARU <> "1" THEN t_irja.IRJA_ID END) AS TOT_LM,
				COUNT(CASE WHEN m_pasien.JNS_KELAMIN = "L" THEN t_irja.IRJA_ID END) AS TOT_LK,
				COUNT(CASE WHEN m_pasien.JNS_KELAMIN = "P" THEN t_irja.IRJA_ID END) AS TOT_PR,
				COUNT(t_irja.IRJA_ID) AS TOTAL
				FROM t_irja
				INNER JOIN m_unit ON (m_unit.UNIT_ID = t_irja.UNIT_ID)
				INNER JOIN m_pasien ON (m_pasien.NOMR = t_irja.NOMR)
				INNER JOIN m_pasien_pulang ON (t_irja.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID)
				INNER JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
				' . $qry_filter . ' AND t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL
				GROUP BY m_unit.UNIT_ID,m_unit.NAMA_UNIT, DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y/%m/%d"),m_pegawai.NAMA_PEGAWAI
				ORDER BY m_unit.NAMA_UNIT, DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y/%m/%d"),m_pegawai.NAMA_PEGAWAI';
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());		
?>
<table width="100%" border="1" >
	<tr>
		<th colspan="<?php echo 9 + (5 *($i-1)); ?>">Laporan Status Pasien Pulang Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>	
  <tr>
    <th rowspan="3" width="5">No</th>
    <th rowspan="3">Poliklinik</th>
	<th rowspan="3">Dokter</th>
	<th rowspan="3">Tanggal</th>
    <th colspan="<?php echo 5 *($i-1); ?>">Status Pulang</th><th rowspan="2" colspan="5">Total</th>
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
 <?php $no = 0;
    while ($data = mysql_fetch_array($get_kunjungan)) { ?>  
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
	<td><?php echo $data['NAMA_PEGAWAI']; ?></td>
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