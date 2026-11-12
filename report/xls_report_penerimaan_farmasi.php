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

$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
mysql_select_db($database_3, $connect_3) or die(mysql_error());

$qry_kunjungan = 'SELECT CASE WHEN t_farmasi_apotik_pengeluaran.JAMINAN_ID IS NULL THEN 1 ELSE t_farmasi_apotik_pengeluaran.JAMINAN_ID END AS JAMINAN_ID,
					CASE WHEN t_farmasi_apotik_pengeluaran.JAMINAN_ID IS NULL THEN "Umum" ELSE m_jaminan.NAMA_JAMINAN END AS NAMA_JAMINAN,
					SUM(CASE WHEN t_farmasi_apotik_pengeluaran.JENIS_PENGELUARAN = "1" THEN
						(t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL * t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR) 
						- (t_farmasi_apotik_pengeluaran.PERSEN_JAMINAN / 100) * 
						(t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL * t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR) END) AS HARGA_IRJA,
					SUM(CASE WHEN t_farmasi_apotik_pengeluaran.JENIS_PENGELUARAN = "2" THEN
						(t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL * t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR) 
						- (t_farmasi_apotik_pengeluaran.PERSEN_JAMINAN / 100) * 
						(t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL * t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR) END) AS HARGA_IRNA,	
					SUM(CASE WHEN t_farmasi_apotik_pengeluaran.JENIS_PENGELUARAN = "3" THEN
						t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL * t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR END) AS HARGA_PNJ
					FROM t_farmasi_apotik_pengeluaran  
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
					LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengeluaran.JAMINAN_ID = m_jaminan.JAMINAN_ID)
					WHERE t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
					AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
					GROUP BY JAMINAN_ID';
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());	
?>
<table width="100%" border="1" >
	<tr>
		<th colspan="6">Laporan Penerimaan Instalasi Farmasi Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>	
  <tr>
   <tr>
    <th rowspan="2" width="5">No</th>
	<th rowspan="2">Nama Jaminan</th>
    <th colspan="3">Resep</th><th rowspan="2">Total</th>
  </tr>
  <tr>
    <th>Rawat Jalan & IGD</th>
	<th>Rawat Inap</th>
	<th>Penjualan Mandiri</th>
  </tr>
 <?php $no = 1;
	$rs = mysql_query($qry_kunjungan) or die(mysql_error());
    while ($data = mysql_fetch_array($rs)) { ?>  
  <tr>
    <td scope="row" align="center"><?php echo $no; ?></td>
     <td><?php echo $data['NAMA_JAMINAN']; ?></td>
    <td align="right"><?php echo currFormat($data['HARGA_IRJA']); ?></td>
	<td align="right"><?php echo currFormat($data['HARGA_IRNA']); ?></td>
	<td align="right"><?php echo currFormat($data['HARGA_PNJ']); ?></td>
	<td align="right"><?php echo currFormat($data['HARGA_PNJ'] + $data['HARGA_IRNA'] + $data['HARGA_IRJA']); ?></td>
  </tr>
 <?php $no++; } ?> 
</table>