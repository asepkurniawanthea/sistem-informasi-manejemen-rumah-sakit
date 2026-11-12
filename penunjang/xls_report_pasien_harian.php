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

$qry_kunjungan = 'SELECT CASE WHEN t_ipenunjang.JNS_ORDER = "APS" THEN "APS"
							WHEN t_ipenunjang.JNS_ORDER = "IRJ" OR t_ipenunjang.JNS_ORDER = "HRJ" THEN "Rawat Jalan" 
							WHEN t_ipenunjang.JNS_ORDER = "IRN" OR t_ipenunjang.JNS_ORDER = "HRI" THEN "Rawat Inap"
						  END AS JNS_ORDER,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%Y/%m/%d") AS TANGGAL,';

$qry_jaminan = 'SELECT DISTINCT m_jaminan.JAMINAN_ID, m_jaminan.NAMA_JAMINAN 
				FROM m_jaminan 
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN t_ipenunjang ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				WHERE STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL AND t_ipenunjang_tarif.ST_BATAL IS NULL
				AND t_ipenunjang_tarif.UNIT_PENUNJANG_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '"
				AND t_ipenunjang_tarif.ST_PERIKSA = "1"
				ORDER BY m_jaminan.PENDAFTARAN DESC, m_jaminan.URUT ASC';
$get_jaminan = mysql_query($qry_jaminan) or die(mysql_error());
$i = 1;
$field_name = array();
while($dat_jaminan = mysql_fetch_array($get_jaminan)){
	$qry_kunjungan = $qry_kunjungan . ' COUNT(DISTINCT CASE WHEN t_ipenunjang.JNS_ORDER = "APS" 
													AND t_ipenunjang_tarif.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
													AND t_ipenunjang.ST_BARU = "1"
												THEN t_ipenunjang_tarif.NO_SJP
												WHEN (t_ipenunjang.JNS_ORDER = "IRJ" OR t_ipenunjang.JNS_ORDER = "HRJ") 
													AND t_ipenunjang_tarif.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
													AND t_irja.ST_BARU = "1"
												THEN t_ipenunjang_tarif.NO_SJP 
												WHEN (t_ipenunjang.JNS_ORDER = "IRN" OR t_ipenunjang.JNS_ORDER = "HRI") 
													AND t_ipenunjang_tarif.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
												THEN NULL
												END) AS FIELD_BR_' . $i . ',
										COUNT(DISTINCT CASE WHEN t_ipenunjang.JNS_ORDER = "APS" 
													AND t_ipenunjang_tarif.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
													AND t_ipenunjang.ST_BARU <> "1"
												THEN t_ipenunjang_tarif.NO_SJP
												WHEN (t_ipenunjang.JNS_ORDER = "IRJ" OR t_ipenunjang.JNS_ORDER = "HRJ")
													AND t_ipenunjang_tarif.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
													AND t_irja.ST_BARU <> "1"
												THEN t_ipenunjang_tarif.NO_SJP 
												WHEN (t_ipenunjang.JNS_ORDER = "IRN" OR t_ipenunjang.JNS_ORDER = "HRI") 
													AND t_ipenunjang_tarif.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
												THEN t_ipenunjang_tarif.NO_SJP
												END) AS FIELD_LM_' . $i . ',		
										COUNT(DISTINCT CASE WHEN t_ipenunjang.JNS_ORDER = "APS" 
													AND t_ipenunjang_tarif.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
													AND t_ipenunjang.JNS_KELAMIN = "L"
												THEN t_ipenunjang_tarif.NO_SJP
												WHEN t_ipenunjang.JNS_ORDER <> "APS" 
													AND t_ipenunjang_tarif.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
													AND m_pasien.JNS_KELAMIN = "L"
												THEN t_ipenunjang_tarif.NO_SJP END) AS FIELD_LK_' . $i . ',
										COUNT(DISTINCT CASE WHEN t_ipenunjang.JNS_ORDER = "APS" 
													AND t_ipenunjang_tarif.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
													AND t_ipenunjang.JNS_KELAMIN = "P"
												THEN t_ipenunjang_tarif.NO_SJP
												WHEN t_ipenunjang.JNS_ORDER <> "APS" 
													AND t_ipenunjang_tarif.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
													AND m_pasien.JNS_KELAMIN = "P"
												THEN t_ipenunjang_tarif.NO_SJP END) AS FIELD_PR_' . $i . ',
										COUNT(DISTINCT CASE WHEN t_ipenunjang_tarif.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '"
										THEN t_ipenunjang_tarif.NO_SJP END) AS FIELD_JM_' . $i . ',';
	$field_name[$i] = $dat_jaminan['NAMA_JAMINAN']; 									
$i++;	
}
	$qry_kunjungan = $qry_kunjungan . 'COUNT(DISTINCT CASE WHEN t_ipenunjang.JNS_ORDER = "APS" 
												AND t_ipenunjang.ST_BARU = "1" 
												THEN t_ipenunjang_tarif.NO_SJP
												WHEN (t_ipenunjang.JNS_ORDER = "IRJ" OR t_ipenunjang.JNS_ORDER = "HRJ") 
												AND t_irja.ST_BARU = "1" 
												THEN t_ipenunjang_tarif.NO_SJP 
												WHEN (t_ipenunjang.JNS_ORDER = "IRN" OR t_ipenunjang.JNS_ORDER = "HRI")
												THEN NULL 
												END) AS TOT_BR,
										COUNT(DISTINCT CASE WHEN t_ipenunjang.JNS_ORDER = "APS" 
												AND t_ipenunjang.ST_BARU <> "1" 
												THEN t_ipenunjang_tarif.NO_SJP
												WHEN (t_ipenunjang.JNS_ORDER = "IRJ" OR t_ipenunjang.JNS_ORDER = "HRJ") 
												AND t_irja.ST_BARU <> "1"
												THEN t_ipenunjang_tarif.NO_SJP 
												WHEN (t_ipenunjang.JNS_ORDER = "IRN" OR t_ipenunjang.JNS_ORDER = "HRI") 
												THEN t_ipenunjang_tarif.NO_SJP 
												END) AS TOT_LM,		
										COUNT(DISTINCT CASE WHEN t_ipenunjang.JNS_ORDER = "APS" 
												AND t_ipenunjang.JNS_KELAMIN = "L" 
												THEN t_ipenunjang_tarif.NO_SJP
												WHEN t_ipenunjang.JNS_ORDER <> "APS" 
												AND m_pasien.JNS_KELAMIN = "L" 
												THEN t_ipenunjang_tarif.NO_SJP END) AS TOT_LK,
										COUNT(DISTINCT CASE WHEN t_ipenunjang.JNS_ORDER = "APS" 
												AND t_ipenunjang.JNS_KELAMIN = "P" 
												THEN t_ipenunjang_tarif.NO_SJP 
												WHEN t_ipenunjang.JNS_ORDER <> "APS" 
												AND m_pasien.JNS_KELAMIN = "P" 
												THEN t_ipenunjang_tarif.NO_SJP END) AS TOT_PR,
										COUNT(DISTINCT t_ipenunjang_tarif.NO_SJP) AS TOTAL		
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				LEFT JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
				LEFT JOIN m_pasien ON (m_pasien.NOMR = t_ipenunjang.NOMR)
				WHERE STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL AND t_ipenunjang_tarif.ST_BATAL IS NULL
				AND t_ipenunjang_tarif.UNIT_PENUNJANG_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '"
				AND t_ipenunjang_tarif.ST_PERIKSA = "1"
				GROUP BY JNS_ORDER,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%Y/%m/%d")
				ORDER BY JNS_ORDER,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%Y/%m/%d")';
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());	
?>
<table width="100%" border="1" >
	<tr>
		<th colspan="<?php echo 8 + (5 *($i-1)); ?>">Laporan Kunjungan Pasien Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>	
  <tr>
    <th rowspan="3" width="5">No</th>
	<th rowspan="3">Order</th>
	<th rowspan="3">Tanggal</th>
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
    <td><?php echo $data['JNS_ORDER']; ?></td>	
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