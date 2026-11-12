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

$qry_kunjungan = 'SELECT m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER,';

$qry_jaminan = 'SELECT DISTINCT m_jaminan.JAMINAN_ID, m_jaminan.NAMA_JAMINAN 
				FROM m_jaminan 
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN t_ipenunjang ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				WHERE DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL AND t_ipenunjang_tarif.ST_BATAL IS NULL
				ORDER BY m_jaminan.PENDAFTARAN DESC, m_jaminan.URUT ASC';
$get_jaminan = mysql_query($qry_jaminan) or die(mysql_error());
$i = 1;
$field_name = array();
while($dat_jaminan = mysql_fetch_array($get_jaminan)){
	$qry_kunjungan = $qry_kunjungan . ' COUNT(DISTINCT CASE WHEN t_ipenunjang_tarif.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
														THEN t_ipenunjang_tarif.NO_TARIF END) AS FIELD_JM_' . $i . ',';
	$field_name[$i] = $dat_jaminan['NAMA_JAMINAN']; 									
$i++;	
}
	$qry_kunjungan = $qry_kunjungan . 'COUNT(DISTINCT t_ipenunjang_tarif.NO_TARIF) AS TOTAL		
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				WHERE DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL AND t_ipenunjang_tarif.ST_BATAL IS NULL
				AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
				OR m_tarif.UNIT_ID = "45") 
				GROUP BY m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER
				ORDER BY m_tarif_pemeriksaan.CH_REPORT,m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER';
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());	
?>
<table width="100%" border="1" >
	<tr>
		<th colspan="<?php echo 1 + (1 *($i-1)); ?>">Laporan Kegiatan Laboratorium Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>	
  <tr>
  <th rowspan="2" width="5">No</th>
	<th rowspan="2">Nama Pemeriksaan</th>
    <th colspan="<?php echo 1 *($i-1); ?>">Jenis Pembayaran</th><th>Total</th>
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
	$rs = mysql_query($qry_kunjungan) or die(mysql_error());
    while ($data = mysql_fetch_array($rs)) { ?>  
  <tr>
    <td scope="row" align="center"><?php echo $no; ?></td>
    <td><?php echo $data['NAMA_PEMERIKSAAN_ORDER']; ?></td>	
    <?php
	$x = 1;
	while($x < $i){
		echo '<td align="right">' . currFormat($data['FIELD_JM_'. $x]) . '</td>';
	$x++;
	}
	?>
<td align="right"><?php echo currFormat($data['TOTAL']); ?></td>
  </tr>
 <?php $no++; } ?> 
</table>