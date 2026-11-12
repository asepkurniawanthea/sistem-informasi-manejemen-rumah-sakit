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
	
$penyetor = '';
if (isset($_POST['penyetor']))
		$penyetor = $_POST['penyetor'];		

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}	

$qry_filter_user = '';
if(!empty($penyetor)){
	$qry_filter_user = 'AND t_ipenunjang_tarif.USER_KASIR LIKE "%' . $penyetor . '"';
}

$qry_kunjungan = 'SELECT * FROM (SELECT m_tarif.TARIF_ID,m_tarif.NAMA_TARIF,m_tarif_group.NAMA_TARIF_GROUP,m_unit.NAMA_UNIT,
				CASE WHEN t_ipenunjang.JNS_ORDER = "APS" THEN "APS" ELSE m_unit2.NAMA_UNIT END AS UNIT_PENGIRIM,
				SUM(CASE WHEN t_ipenunjang_tarif.SHIFT_KASIR = "1" THEN t_ipenunjang_tarif.KUANTITI ELSE 0 END) AS JUMLAH_TARIF_1,
				SUM(CASE WHEN t_ipenunjang_tarif.SHIFT_KASIR = "2" THEN t_ipenunjang_tarif.KUANTITI ELSE 0 END) AS JUMLAH_TARIF_2,
				SUM(CASE WHEN t_ipenunjang_tarif.SHIFT_KASIR = "3" AND CAST(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_BAYAR,"%H") AS UNSIGNED) <= 12 THEN t_ipenunjang_tarif.KUANTITI ELSE 0 END) AS JUMLAH_TARIF_3,
				SUM(CASE WHEN t_ipenunjang_tarif.SHIFT_KASIR = "3" AND CAST(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_BAYAR,"%H") AS UNSIGNED) >= 18 THEN t_ipenunjang_tarif.KUANTITI ELSE 0 END) AS JUMLAH_TARIF_3_B,
				SUM(CASE WHEN t_ipenunjang_tarif.SHIFT_KASIR = "1" THEN t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS ELSE 0 END) AS JUMLAH_RUPIAH_1,
				SUM(CASE WHEN t_ipenunjang_tarif.SHIFT_KASIR = "2" THEN t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS ELSE 0 END) AS JUMLAH_RUPIAH_2,
				SUM(CASE WHEN t_ipenunjang_tarif.SHIFT_KASIR = "3" AND CAST(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_BAYAR,"%H") AS UNSIGNED) <= 12 THEN t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS ELSE 0 END) AS JUMLAH_RUPIAH_3,
				SUM(CASE WHEN t_ipenunjang_tarif.SHIFT_KASIR = "3" AND CAST(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_BAYAR,"%H") AS UNSIGNED) >= 18 THEN t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS ELSE 0 END) AS JUMLAH_RUPIAH_3_B
				FROM t_ipenunjang 
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_unit ON (t_ipenunjang_tarif.UNIT_PENUNJANG_ID = m_unit.UNIT_ID)
				LEFT JOIN m_unit m_unit2 ON (t_ipenunjang.UNIT_ID = m_unit2.UNIT_ID)
				WHERE t_ipenunjang_tarif.JENIS_BAYAR_ID = "1" AND t_ipenunjang_tarif.ST_BATAL IS NULL
				AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_BAYAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_BAYAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '	
				AND t_ipenunjang_tarif.ST_BAYAR = "Lunas" 
				' . $qry_filter_user . '
				AND m_tarif.KODE_TARIF_GROUP = "01"
				GROUP BY m_tarif.TARIF_ID,m_tarif.NAMA_TARIF,m_tarif_group.NAMA_TARIF_GROUP,m_unit.NAMA_UNIT,
				UNIT_PENGIRIM
				UNION
				SELECT m_tarif.TARIF_ID,m_tarif.NAMA_TARIF,m_tarif_group.NAMA_TARIF_GROUP,m_unit.NAMA_UNIT,
				CASE WHEN t_ipenunjang.JNS_ORDER = "APS" THEN "APS" ELSE m_unit2.NAMA_UNIT END AS UNIT_PENGIRIM,
				SUM(CASE WHEN t_ipenunjang_tarif.SHIFT_KASIR = "1" THEN t_ipenunjang_tarif.KUANTITI ELSE 0 END) AS JUMLAH_TARIF_1,
				SUM(CASE WHEN t_ipenunjang_tarif.SHIFT_KASIR = "2" THEN t_ipenunjang_tarif.KUANTITI ELSE 0 END) AS JUMLAH_TARIF_2,
				SUM(CASE WHEN t_ipenunjang_tarif.SHIFT_KASIR = "3" AND CAST(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_BAYAR,"%H") AS UNSIGNED) <= 12 THEN t_ipenunjang_tarif.KUANTITI ELSE 0 END) AS JUMLAH_TARIF_3,
				SUM(CASE WHEN t_ipenunjang_tarif.SHIFT_KASIR = "3" AND CAST(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_BAYAR,"%H") AS UNSIGNED) >= 18 THEN t_ipenunjang_tarif.KUANTITI ELSE 0 END) AS JUMLAH_TARIF_3_B,
				SUM(CASE WHEN t_ipenunjang_tarif.SHIFT_KASIR = "1" THEN t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS ELSE 0 END) AS JUMLAH_RUPIAH_1,
				SUM(CASE WHEN t_ipenunjang_tarif.SHIFT_KASIR = "2" THEN t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS ELSE 0 END) AS JUMLAH_RUPIAH_2,
				SUM(CASE WHEN t_ipenunjang_tarif.SHIFT_KASIR = "3" AND CAST(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_BAYAR,"%H") AS UNSIGNED) <= 12 THEN t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS ELSE 0 END) AS JUMLAH_RUPIAH_3,
				SUM(CASE WHEN t_ipenunjang_tarif.SHIFT_KASIR = "3" AND CAST(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_BAYAR,"%H") AS UNSIGNED) >= 18 THEN t_ipenunjang_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS ELSE 0 END) AS JUMLAH_RUPIAH_3_B
				FROM t_ipenunjang 
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_unit ON (t_ipenunjang_tarif.UNIT_PENUNJANG_ID = m_unit.UNIT_ID)
				LEFT JOIN m_unit m_unit2 ON (t_ipenunjang.UNIT_ID = m_unit2.UNIT_ID)
				WHERE t_ipenunjang_tarif.JENIS_BAYAR_ID = "1" AND t_ipenunjang_tarif.ST_BATAL IS NULL
				AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_BAYAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_BAYAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '	
				AND t_ipenunjang_tarif.ST_BAYAR = "Lunas" 
				' . $qry_filter_user . '
				AND m_tarif.KODE_TARIF_GROUP <> "01" 
				GROUP BY m_tarif.TARIF_ID,m_tarif.NAMA_TARIF,m_tarif_group.NAMA_TARIF_GROUP,m_unit.NAMA_UNIT,
				UNIT_PENGIRIM
				) t_penerimaan
				ORDER BY NAMA_UNIT,TARIF_ID';
?>
<table border="1" >
	<tr>
		<th colspan="12">Laporan Penerimaan Instalasi Penunjang Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>
	<tr>
		<th align="center" colspan="12">Penyetor : <?php echo $penyetor; ?></th>
	</tr>
   <tr>
    <th rowspan="2">No</th>
	<th rowspan="2">Unit</th>
	<th rowspan="2">Pengirim</th>
    <th rowspan="2">Tarif</th>
	<th rowspan="2">Group Tarif</th>
    <th colspan="4">Jumlah</th>
    <th colspan="4">Rupiah</th>
  </tr>
    <tr>
    <th>Shift 1 </th>
    <th>Shift 2 </th>
    <th>Shift 3 Am</th>
	<th>Shift 3 Pm</th>
    <th>Shift 1 </th>
    <th>Shift 2</th>
    <th>Shift 3 Am</th>
	<th>Shift 3 Pm</th>
  </tr>
    <?
    $no = 1;
	$total_1 = 0;
	$total_2 = 0;
	$total_3 = 0;
	$total_3_b = 0;
	$rs = mysql_query($qry_kunjungan) or die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
	?>
	<tr>
   <td scope="row" align="center"><?php echo $no; ?></td>
	<td><?php echo $data['NAMA_UNIT']; ?></td>
	<td><?php echo $data['UNIT_PENGIRIM']; ?></td>
    <td><?php echo $data['NAMA_TARIF']; ?></td>
	<td><?php echo $data['NAMA_TARIF_GROUP']; ?></td>
    <td align="right"><?php echo currFormat($data['JUMLAH_TARIF_1']); ?></td>
	<td align="right"><?php echo currFormat($data['JUMLAH_TARIF_2']); ?></td>
	<td align="right"><?php echo currFormat($data['JUMLAH_TARIF_3']); ?></td>
	<td align="right"><?php echo currFormat($data['JUMLAH_TARIF_3_B']); ?></td>
    <td align="right"><?php echo currFormat($data['JUMLAH_RUPIAH_1']); 
	$total_1 = $total_1 + $data['JUMLAH_RUPIAH_1']; ?></td>
	<td align="right"><?php echo currFormat($data['JUMLAH_RUPIAH_2']); 
	$total_2 = $total_2 + $data['JUMLAH_RUPIAH_2']; ?></td>
	<td align="right"><?php echo currFormat($data['JUMLAH_RUPIAH_3']); 
	$total_3 = $total_3 + $data['JUMLAH_RUPIAH_3']; ?></td>
	<td align="right"><?php echo currFormat($data['JUMLAH_RUPIAH_3_B']); 
	$total_3_b = $total_3_b + $data['JUMLAH_RUPIAH_3_B']; ?></td>
  </tr>
        <?
    $no++; }
    ?>
	 <tr>
    <td colspan="9" align="right">Total :&nbsp;&nbsp;</td>
	<td align="right"><?php echo currFormat($total_1); ?></td>
	<td align="right"><?php echo currFormat($total_2); ?></td>
	<td align="right"><?php echo currFormat($total_3); ?></td>
	<td align="right"><?php echo currFormat($total_3_b); ?></td>
  </tr> 
</table>
