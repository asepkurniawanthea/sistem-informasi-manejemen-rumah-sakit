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

$qry_kunjungan = 'SELECT m_tarif.NAMA_TARIF, m_tarif_group.NAMA_TARIF_GROUP, ';

$qry_jaminan = 'SELECT DISTINCT m_jaminan.JAMINAN_ID, m_jaminan.NAMA_JAMINAN 
				FROM m_jaminan 
				INNER JOIN t_ipenunjang ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif_group.KODE_TARIF_GROUP = m_tarif.KODE_TARIF_GROUP)
				WHERE STR_TO_DATE(DATE_FORMAT(t_ipenunjang.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				AND t_ipenunjang.NO_PENDAFTARAN IS NOT NULL AND t_ipenunjang.ST_BATAL IS NULL
				AND (t_ipenunjang.ST_BAYAR IS NULL OR t_ipenunjang.ST_BAYAR = "Lunas")
				AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1") 
				ORDER BY PENDAFTARAN DESC, URUT ASC';
$get_jaminan = mysql_query($qry_jaminan) or die(mysql_error());
$i = 1;
$field_name = array();
while($dat_jaminan = mysql_fetch_array($get_jaminan)){
	$qry_kunjungan = $qry_kunjungan . ' COUNT(CASE WHEN t_ipenunjang.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
										THEN t_ipenunjang_tarif.PENUNJANG_TARIF_ID END) AS FIELD_JMTRF_' . $i . ',
										SUM(CASE WHEN t_ipenunjang.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
										THEN t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS END) AS FIELD_BYTRF_' . $i . ',';
	$field_name[$i] = $dat_jaminan['NAMA_JAMINAN']; 									
$i++;	
}
	$qry_kunjungan = $qry_kunjungan . 'COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS TOT_JMTRF,
				SUM(t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS TOT_BYTRF
				FROM t_ipenunjang
				INNER JOIN m_unit ON (m_unit.UNIT_ID = t_ipenunjang.UNIT_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif_group.KODE_TARIF_GROUP = m_tarif.KODE_TARIF_GROUP)
				WHERE STR_TO_DATE(DATE_FORMAT(t_ipenunjang.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				AND t_ipenunjang.NO_PENDAFTARAN IS NOT NULL AND t_ipenunjang.ST_BATAL IS NULL
				AND (t_ipenunjang.ST_BAYAR IS NULL OR t_ipenunjang.ST_BAYAR = "Lunas")
				AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1") 
				GROUP BY m_tarif.NAMA_TARIF, m_tarif_group.NAMA_TARIF_GROUP
				ORDER BY m_tarif.NAMA_TARIF,m_tarif_group.NAMA_TARIF_GROUP';
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());
?>
<table width="100%" border="1" >
	<tr>
		<th colspan="<?php echo 4 + (2 *($i-1)); ?>">Laporan Penerimaan Instalasi Penunjang Laboratorium Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>	
  <tr>
    <th rowspan="3" width="5">No</th>
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
 <?php $no = 1;
	$rs = mysql_query($qry_kunjungan) or die(mysql_error());
    while ($data = mysql_fetch_array($rs)) { ?>  
  <tr>
    <td scope="row" align="center"><?php echo $no; ?></td>
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
 <?php $no++; } ?> 
</table>