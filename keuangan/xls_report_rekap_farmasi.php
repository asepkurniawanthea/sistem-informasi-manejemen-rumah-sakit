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

$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
mysql_select_db($database_3, $connect_3) or die(mysql_error());

$qry_filter_user = '';
if(!empty($penyetor)){
	$qry_filter_user = 'AND t_farmasi_apotik_pengeluaran.USER_PEMBAYARAN LIKE "%' . $penyetor . '"';
}

$qry_kunjungan = 'SELECT t_trans.*,m_persediaan_farmasi.NAMA_PERSEDIAAN FROM (SELECT t_farmasi_apotik_pengeluaran.JENIS_PENGELUARAN,
				t_farmasi_apotik_pengeluaran.UNIT_ID,
				t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,
				t_farmasi_apotik_pengeluaran_detail.HARGA_BELI,
				t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,
				SUM(CASE WHEN t_farmasi_apotik_pengeluaran.SHIFT_PEMBAYARAN = "1" THEN t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR END) AS BAYAR_SHIFT_1,
				SUM(CASE WHEN t_farmasi_apotik_pengeluaran.SHIFT_PEMBAYARAN = "2" THEN t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR END) AS BAYAR_SHIFT_2,
				SUM(CASE WHEN t_farmasi_apotik_pengeluaran.SHIFT_PEMBAYARAN = "3" AND CAST(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_BAYAR,"%H") AS UNSIGNED) <= 12 THEN t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR END) AS BAYAR_SHIFT_3,
				SUM(CASE WHEN t_farmasi_apotik_pengeluaran.SHIFT_PEMBAYARAN = "3" AND CAST(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_BAYAR,"%H") AS UNSIGNED) >= 18 THEN t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR END) AS BAYAR_SHIFT_3_B
				FROM t_farmasi_apotik_pengeluaran
				INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
				INNER JOIN t_rajal_resep_detail ON (t_farmasi_apotik_pengeluaran_detail.RAJAL_RESEP_DETAIL_ID = t_rajal_resep_detail.RAJAL_RESEP_DETAIL_ID)
				WHERE  t_farmasi_apotik_pengeluaran.JAMINAN_ID = "1" AND t_farmasi_apotik_pengeluaran.ST_BATAL IS NULL
				AND t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN IS NOT NULL
				AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_BAYAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_BAYAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				AND t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR > 0	
				' . $qry_filter_user . ' 
				AND t_farmasi_apotik_pengeluaran.JENIS_PENGELUARAN = "1"
				GROUP BY t_farmasi_apotik_pengeluaran.JENIS_PENGELUARAN,
				t_farmasi_apotik_pengeluaran.UNIT_ID,
				t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,
				t_farmasi_apotik_pengeluaran_detail.HARGA_BELI,
				t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL
				UNION
				SELECT t_farmasi_apotik_pengeluaran.JENIS_PENGELUARAN,
				t_farmasi_apotik_pengeluaran.UNIT_ID,
				t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,
				t_farmasi_apotik_pengeluaran_detail.HARGA_BELI,
				t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,
				SUM(CASE WHEN t_farmasi_apotik_pengeluaran.SHIFT_PEMBAYARAN = "1" THEN t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR END) AS BAYAR_SHIFT_1,
				SUM(CASE WHEN t_farmasi_apotik_pengeluaran.SHIFT_PEMBAYARAN = "2" THEN t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR END) AS BAYAR_SHIFT_2,
				SUM(CASE WHEN t_farmasi_apotik_pengeluaran.SHIFT_PEMBAYARAN = "3" AND CAST(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_BAYAR,"%H") AS UNSIGNED) <= 12 THEN t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR END) AS BAYAR_SHIFT_3,
				SUM(CASE WHEN t_farmasi_apotik_pengeluaran.SHIFT_PEMBAYARAN = "3" AND CAST(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_BAYAR,"%H") AS UNSIGNED) >= 18 THEN t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR END) AS BAYAR_SHIFT_3_B
				FROM t_farmasi_apotik_pengeluaran
				INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
				INNER JOIN t_ranap_resep_detail ON (t_farmasi_apotik_pengeluaran_detail.RANAP_RESEP_DETAIL_ID = t_ranap_resep_detail.RANAP_RESEP_DETAIL_ID)
				WHERE  t_farmasi_apotik_pengeluaran.JAMINAN_ID = "1" AND t_farmasi_apotik_pengeluaran.ST_BATAL IS NULL
				AND t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN IS NOT NULL
				AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_BAYAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_BAYAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '	
				AND t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR > 0	
				' . $qry_filter_user . ' 
				AND t_farmasi_apotik_pengeluaran.JENIS_PENGELUARAN = "2"
				GROUP BY t_farmasi_apotik_pengeluaran.JENIS_PENGELUARAN,
				t_farmasi_apotik_pengeluaran.UNIT_ID,
				t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,
				t_farmasi_apotik_pengeluaran_detail.HARGA_BELI,
				t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL
				UNION
				SELECT t_farmasi_apotik_pengeluaran.JENIS_PENGELUARAN,
				t_farmasi_apotik_pengeluaran.UNIT_ID,
				t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,
				t_farmasi_apotik_pengeluaran_detail.HARGA_BELI,
				t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,
				SUM(CASE WHEN t_farmasi_apotik_pengeluaran.SHIFT_PEMBAYARAN = "1" THEN t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR END) AS BAYAR_SHIFT_1,
				SUM(CASE WHEN t_farmasi_apotik_pengeluaran.SHIFT_PEMBAYARAN = "2" THEN t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR END) AS BAYAR_SHIFT_2,
				SUM(CASE WHEN t_farmasi_apotik_pengeluaran.SHIFT_PEMBAYARAN = "3" AND CAST(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_BAYAR,"%H") AS UNSIGNED) <= 12 THEN t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR END) AS BAYAR_SHIFT_3,
				SUM(CASE WHEN t_farmasi_apotik_pengeluaran.SHIFT_PEMBAYARAN = "3" AND CAST(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_BAYAR,"%H") AS UNSIGNED) >= 18 THEN t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR END) AS BAYAR_SHIFT_3_B
				FROM t_farmasi_apotik_pengeluaran
				INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
				INNER JOIN t_penjualan_resep_detail ON (t_farmasi_apotik_pengeluaran_detail.PENJUALAN_RESEP_DETAIL_ID = t_penjualan_resep_detail.PENJUALAN_RESEP_DETAIL_ID)
				WHERE t_farmasi_apotik_pengeluaran.ST_BATAL IS NULL
				AND t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN IS NOT NULL
				AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_BAYAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_BAYAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				AND t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR > 0					
				' . $qry_filter_user . ' 
				AND t_farmasi_apotik_pengeluaran.JENIS_PENGELUARAN = "3"
				GROUP BY t_farmasi_apotik_pengeluaran.JENIS_PENGELUARAN,
				t_farmasi_apotik_pengeluaran.UNIT_ID,
				t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,
				t_farmasi_apotik_pengeluaran_detail.HARGA_BELI,
				t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL) t_trans
				INNER JOIN m_persediaan_farmasi ON (t_trans.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)';
?>
<table border="1" >
	<tr>
		<th colspan="15">Laporan Penerimaan Instalasi Farmasi Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>
	<tr>
		<th align="center" colspan="15">Penyetor : <?php echo $penyetor; ?></th>
	</tr>
   <tr>
    <th rowspan="2">No</th>
    <th rowspan="2">Resep</th>
	<th rowspan="2">Unit</th>
    <th rowspan="2">Kode</th>
    <th rowspan="2">Obat</th>
    <th rowspan="2" >Hrg Beli </th>
    <th rowspan="2" >Hrg Jual </th>
    <th colspan="2" >Shift 1</th>
    <th colspan="2" >Shift 2 </th>
    <th colspan="2">Shift 3 Am</th>
	<th colspan="2">Shift 3 Pm</th>
  </tr>
  <tr>
    <th >Jumlah</th>
    <th >Total</th>
    <th >Jumlah</th>
    <th >Total</th>
    <th>Jumlah</th>
    <th>Total</th>
    <th>Jumlah</th>
    <th>Total</th>
  </tr>
    <?
    $no = 1;
	$total_shift_1 = 0;
	$total_shift_2 = 0;
	$total_shift_3 = 0;
	$total_shift_3b = 0;
	$rs = mysql_query($qry_kunjungan) or die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
	?>
	<tr>
    <td scope="row" align="center"><?php echo $no; ?></td>
    <td><?php if($data['JENIS_PENGELUARAN'] == '1') echo 'Rawat Jalan'; if($data['JENIS_PENGELUARAN'] == '2') echo 'Rawat Inap'; if($data['JENIS_PENGELUARAN'] == '3') echo 'Penjualan Mandiri';?></td>
	<td><?php if($data['UNIT_ID'] == '20') echo 'Depo IRJ'; if($data['UNIT_ID'] == '21') echo 'Depo IGD'; if($data['UNIT_ID'] == '22') echo 'Depo Kusta';?></td>
    <td align="center"><?php echo $data['PERSEDIAAN_ID']; ?></td>
	<td><?php echo $data['NAMA_PERSEDIAAN']; ?></td>
	<td align="right"><?php echo currFormat($data['HARGA_BELI']); ?></td>
	<td align="right"><?php echo currFormat($data['HARGA_JUAL']); ?></td>
	<td align="right"><?php echo currFormat($data['BAYAR_SHIFT_1']); ?></td>
	<td align="right"><?php echo currFormat($data['BAYAR_SHIFT_1'] * $data['HARGA_JUAL']); ?></td>
    <td align="right"><?php echo currFormat($data['BAYAR_SHIFT_2']); ?></td>
	<td align="right"><?php echo currFormat($data['BAYAR_SHIFT_2'] * $data['HARGA_JUAL']); ?></td>
    <td align="right"><?php echo currFormat($data['BAYAR_SHIFT_3']); ?></td>
	<td align="right"><?php echo currFormat($data['BAYAR_SHIFT_3'] * $data['HARGA_JUAL']); ?></td>
	<td align="right"><?php echo currFormat($data['BAYAR_SHIFT_3_B']); ?></td>
	<td align="right"><?php echo currFormat($data['BAYAR_SHIFT_3_B'] * $data['HARGA_JUAL']); ?></td>
    <?php $total_shift_1 = $total_shift_1 + ($data['BAYAR_SHIFT_1'] * $data['HARGA_JUAL']);
		  $total_shift_2 = $total_shift_2 + ($data['BAYAR_SHIFT_2'] * $data['HARGA_JUAL']);
		  $total_shift_3 = $total_shift_3 + ($data['BAYAR_SHIFT_3'] * $data['HARGA_JUAL']);
		  $total_shift_3b = $total_shift_3b + ($data['BAYAR_SHIFT_3_B'] * $data['HARGA_JUAL']);?>
  </tr>
        <?
    $no++; }
    ?>
<tr>
    <td colspan="5" align="right">Total :&nbsp;&nbsp;</td>
	<td colspan="2">&nbsp;</td>
	<td colspan="2" align="right"><?php echo currFormat($total_shift_1); ?></td>
	<td colspan="2" align="right"><?php echo currFormat($total_shift_2); ?></td>
	<td colspan="2" align="right"><?php echo currFormat($total_shift_3); ?></td>
	<td colspan="2" align="right"><?php echo currFormat($total_shift_3b); ?></td>
  </tr>   
</table>
