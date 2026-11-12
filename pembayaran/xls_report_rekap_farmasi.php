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

$cash = '';
if (isset($_POST['cash']))
    $cash = $_POST['cash'];

$rekening = '';
if (isset($_POST['rekening']))
    $rekening = $_POST['rekening'];

$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
mysql_select_db($database_3, $connect_3) or die(mysql_error());
$qry_kunjungan = 'SELECT fms.FARMASI_PENGELUARAN_APOTIK_ID,
						fms.NIK,
						fms.NAMA_PELANGGAN,
						DATE_FORMAT(fms.TANGGAL_KELUAR,"%d-%m-%Y") AS TGL_MASUK,
						DATE_FORMAT(fms.TANGGAL_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
						fms.INSTANSI_PENGIRIM,
						"-" AS TARIF_ID,
						"-" AS NAMA_TARIF_GROUP,
						"Resep" AS NAMA_TARIF,
						"APS" AS PASIEN,
						CAST(DATE_FORMAT(fms.TANGGAL_BAYAR,"%H") AS UNSIGNED) AS TGL_BAYAR,
						fms.SHIFT_PEMBAYARAN AS SHIFT,
						UPPER(SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1)) AS USER_KASIR,
						COUNT(DISTINCT fms.NO_PENGELUARAN) AS KUANTITI,
						SUM(fmsd.JUMLAH_KELUAR * fmsd.HARGA_JUAL) AS HARGA
						FROM db_inventorirs.t_farmasi_apotik_pengeluaran fms
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran_detail fmsd
						ON (fms.FARMASI_PENGELUARAN_APOTIK_ID = fmsd.FARMASI_PENGELUARAN_ID)
						WHERE fms.NO_PENGELUARAN IS NOT NULL
						AND fms.JENIS_PENGELUARAN = "3"
						AND fms.ST_BATAL IS NULL
						AND DATE(fms.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
						AND DATE(fms.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . '
						' . (($cash != '') ? ' AND fms.KODE_CASH = "' . $cash . '" ' : '') . ' 
						' . (($rekening != '') ? ' AND fms.KODE_REKENING = "' . $rekening . '" ' : '') . ' 
						AND UPPER(SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1)) = "' . strtoupper($_SESSION['SES_SIMRS_NAMA_PEGAWAI']) . '"
						GROUP BY fms.FARMASI_PENGELUARAN_APOTIK_ID,
						DATE_FORMAT(fms.TANGGAL_BAYAR,"%H"),
						fms.SHIFT_PEMBAYARAN';
?>
<table border="1" >
<tr>
		<th colspan="19">Laporan Penerimaan Farmasi Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>
	<tr>
		<th align="center" colspan="19">Penyetor : <?php echo $_SESSION['SES_SIMRS_NAMA_PEGAWAI']; ?></th>
	</tr>
       <tr>
     <th rowspan="2">No</th>
     <th rowspan="2">No Pasien</th>
     <th rowspan="2">Nama Pasien </th>
     <th rowspan="2">Tgl Masuk </th>
     <th rowspan="2">Tgl Keluar </th>
     <th rowspan="2">Unit</th>
     <th rowspan="2">Group Tarif</th>
     <th rowspan="2">Tarif</th>
     <th rowspan="2">Bayar</th>
     <th colspan="5">Jumlah</th>
     <th colspan="5">Rupiah</th>
   </tr>
  <tr>
    <th>Shift 1 </th>
    <th>Shift 2 </th>
    <th>Shift 3 AM</th>
	<th>Shift 3 PM</th>
	<th>-</th>
    <th>Shift 1 </th>
    <th>Shift 2</th>
    <th>Shift 3 AM</th>
	<th>Shift 3 PM</th>
	<th>-</th>
  </tr>
    <?
       $no = 1; 
$jumlah_1 = 0;
$jumlah_2 = 0;
$jumlah_3 = 0;
$jumlah_4 = 0;
$jumlah_5 = 0;

$rupiah_1 = 0;
$rupiah_2 = 0;
$rupiah_3 = 0;
$rupiah_4 = 0;
$rupiah_5 = 0;
	$rs = mysql_query($qry_kunjungan) or die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
	?>
	<tr>
	<td scope="row" align="center"><?php echo $no; ?></td>
	<td>-</td>
    <td><?php echo $data['NAMA_PELANGGAN']; ?></td>
	<td><?php echo $data['TGL_MASUK']; ?></td>
	<td><?php echo $data['TGL_KELUAR']; ?></td>
	<td><?php echo $data['INSTANSI_PENGIRIM']; ?></td>
	<td><?php echo $data['NAMA_TARIF_GROUP']; ?></td>
	<td><?php echo $data['NAMA_TARIF']; ?></td>
	<td><?php echo $data['PASIEN']; ?></td>
	<?php
	$sub_jumlah_1 = 0; 
	$sub_jumlah_2 = 0;
	$sub_jumlah_3 = 0;
	$sub_jumlah_4 = 0;
	$sub_jumlah_5 = 0;
	
	$sub_rupiah_1 = 0; 
	$sub_rupiah_2 = 0;
	$sub_rupiah_3 = 0;
	$sub_rupiah_4 = 0;
	$sub_rupiah_5 = 0;
	
	if($data['SHIFT'] != '0' and $data['SHIFT'] != ''){
		if($data['SHIFT'] == '1'){
			$sub_jumlah_1 = $data['KUANTITI'];
			$sub_rupiah_1 = $data['HARGA'];
			$jumlah_1 += $data['KUANTITI'];
			$rupiah_1 += $data['HARGA'];
		}

		if($data['SHIFT'] == '2'){
			$sub_jumlah_2 = $data['KUANTITI'];
			$sub_rupiah_2 = $data['HARGA'];
			$jumlah_2 += $data['KUANTITI'];
			$rupiah_2 += $data['HARGA'];
		}	
		
		if($data['SHIFT'] == '3'){
			if($data['TGL_BAYAR'] <= 12){
				$sub_jumlah_3 = $data['KUANTITI'];
				$sub_rupiah_3 = $data['HARGA'];
				$jumlah_3 += $data['KUANTITI'];
				$rupiah_3 += $data['HARGA'];
			}else{
				$sub_jumlah_4 = $data['KUANTITI'];
				$sub_rupiah_4 = $data['HARGA'];
				$jumlah_4 += $data['KUANTITI'];
				$rupiah_4 += $data['HARGA'];
			}	
		}
	}else{
		$sub_jumlah_5 = $data['KUANTITI'];
		$sub_rupiah_5 = $data['HARGA'];
		$jumlah_5 += $data['KUANTITI'];
		$rupiah_5 += $data['HARGA'];
	}
	?>
    <td align="right"><?php echo currFormat($sub_jumlah_1); ?></td>
	<td align="right"><?php echo currFormat($sub_jumlah_2); ?></td>
	<td align="right"><?php echo currFormat($sub_jumlah_3); ?></td>
	<td align="right"><?php echo currFormat($sub_jumlah_4); ?></td>
	<td align="right"><?php echo currFormat($sub_jumlah_5); ?></td>
	<td align="right"><?php echo currFormat($sub_rupiah_1); ?></td>
	<td align="right"><?php echo currFormat($sub_rupiah_2); ?></td>
	<td align="right"><?php echo currFormat($sub_rupiah_3); ?></td>
	<td align="right"><?php echo currFormat($sub_rupiah_4); ?></td>
	<td align="right"><?php echo currFormat($sub_rupiah_5); ?></td>
  </tr>
        <?
    $no++; }
    ?>
 <tr>
     <td colspan="9" align="right">Total :&nbsp;&nbsp;</td>
	<td align="right"><?php echo currFormat($jumlah_1); ?></td>
	<td align="right"><?php echo currFormat($jumlah_2); ?></td>
	<td align="right"><?php echo currFormat($jumlah_3); ?></td>
	<td align="right"><?php echo currFormat($jumlah_4); ?></td>
	<td align="right"><?php echo currFormat($jumlah_5); ?></td>
	<td align="right"><?php echo currFormat($rupiah_1); ?></td>
	<td align="right"><?php echo currFormat($rupiah_2); ?></td>
	<td align="right"><?php echo currFormat($rupiah_3); ?></td>
	<td align="right"><?php echo currFormat($rupiah_4); ?></td>
	<td align="right"><?php echo currFormat($rupiah_5); ?></td>
  </tr>
</table>
