<?php
include('./config/config.php');
include('./shared/connect_db.php');
include('./shared/function.php');
include('./shared/enum_function.php');

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

$arr_igd = '0,';
foreach(getArrUnitIGD() as $row){
	$arr_igd .= $row . ',';
}
$arr_igd = substr($arr_igd,0,strlen($arr_igd) - 1);	

$arr_nonjaminan = '0,';
foreach(getArrNonJaminan() as $row){
	$arr_nonjaminan .= $row . ',';
}
$arr_nonjaminan = substr($arr_nonjaminan,0,strlen($arr_nonjaminan)-1);	

$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
mysql_select_db($database_3, $connect_3) or die(mysql_error());
$qry_kunjungan = 'SELECT "FMS" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,
						igd.NOMR,psn.NAMA_PASIEN,
						fms.JAMINAN_ID AS JENIS_BAYAR_ID,
						"IGD" AS NAMA_UNIT,
						DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
						DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
						fms.SHIFT_PEMBAYARAN AS SHIFT,
						COUNT(DISTINCT fms.NO_PENGEMBALIAN) AS KUANTITI,
						SUM(fmsd.HARGA_JUAL * fmsd.JUMLAH_KEMBALI) AS HARGA
						FROM db_inventorirs.t_farmasi_apotik_pengembalian_resep fms 
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengembalian_resep_detail fmsd
						ON (fms.FARMASI_PENGEMBALIAN_APOTIK_ID = fmsd.FARMASI_PENGEMBALIAN_ID)
						INNER JOIN db_simrs.t_irja igd
						ON (igd.IRJA_ID = fms.RAJAL_ID AND fms.NO_PENGEMBALIAN IS NOT NULL
						AND fms.JENIS_PENGEMBALIAN = "1")
						INNER JOIN db_simrs.m_pasien psn
						ON (igd.NOMR = psn.NOMR)
						WHERE igd.NO_PENDAFTARAN IS NOT NULL 
						AND igd.ST_BATAL IS NULL
						AND igd.UNIT_ID IN (' . $arr_igd . ')
						AND DATE(fms.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
						AND DATE(fms.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . '
						AND fms.JAMINAN_ID = "1"
						AND fms.NO_PEMBAYARAN IS NOT NULL
						AND UPPER(SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1)) = "' . strtoupper($_SESSION['SES_SIMRS_NAMA_PEGAWAI']) . '"
						GROUP BY igd.IRJA_ID,
						fms.SHIFT_PEMBAYARAN
						-- end pengembalian igd	
						
						-- pengembalian rawat jalan
						UNION ALL
						SELECT "FMS" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,
						irj.NOMR,psn.NAMA_PASIEN,
						fms.JAMINAN_ID AS JENIS_BAYAR_ID,
						unt.NAMA_UNIT AS NAMA_UNIT,
						DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
						DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
						fms.SHIFT_PEMBAYARAN AS SHIFT,
						COUNT(DISTINCT fms.NO_PENGEMBALIAN) AS KUANTITI,
						SUM(fmsd.HARGA_JUAL * fmsd.JUMLAH_KEMBALI) AS HARGA
						FROM db_inventorirs.t_farmasi_apotik_pengembalian_resep fms 
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengembalian_resep_detail fmsd
						ON (fms.FARMASI_PENGEMBALIAN_APOTIK_ID = fmsd.FARMASI_PENGEMBALIAN_ID)
						INNER JOIN db_simrs.t_irja irj
						ON (irj.IRJA_ID = fms.RAJAL_ID AND fms.NO_PENGEMBALIAN IS NOT NULL
						AND fms.JENIS_PENGEMBALIAN = "1")
						INNER JOIN db_simrs.m_pasien psn
						ON (irj.NOMR = psn.NOMR)
						INNER JOIN db_simrs.m_unit unt
						ON (irj.UNIT_ID = unt.UNIT_ID)
						WHERE irj.NO_PENDAFTARAN IS NOT NULL 
						AND irj.ST_BATAL IS NULL
						AND irj.UNIT_ID NOT IN (' . $arr_igd . ')
						AND DATE(fms.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
						AND DATE(fms.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . '
						AND fms.JAMINAN_ID = "1"
						AND fms.NO_PEMBAYARAN IS NOT NULL
						AND UPPER(SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1)) = "' . strtoupper($_SESSION['SES_SIMRS_NAMA_PEGAWAI']) . '"
						GROUP BY irj.IRJA_ID,
						fms.SHIFT_PEMBAYARAN
						-- end pengembalian rawat jalan
						
						-- pengembalian rawat inap
						UNION ALL
						SELECT "FMS" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,
						irn.NOMR,psn.NAMA_PASIEN,
						fms.JAMINAN_ID AS JENIS_BAYAR_ID,
						rng.NAMA_RUANG AS NAMA_UNIT,
						DATE_FORMAT(irn.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
						DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
						fms.SHIFT_PEMBAYARAN AS SHIFT,
						COUNT(DISTINCT fms.NO_PENGEMBALIAN) AS KUANTITI,
						SUM(fmsd.HARGA_JUAL * fmsd.JUMLAH_KEMBALI) AS HARGA
						FROM db_inventorirs.t_farmasi_apotik_pengembalian_resep fms 
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengembalian_resep_detail fmsd
						ON (fms.FARMASI_PENGEMBALIAN_APOTIK_ID = fmsd.FARMASI_PENGEMBALIAN_ID)
						INNER JOIN db_simrs.t_irna irn
						ON (irn.IRNA_ID = fms.RANAP_ID AND fms.NO_PENGEMBALIAN IS NOT NULL
						AND fms.JENIS_PENGEMBALIAN = "2")
						INNER JOIN db_simrs.m_pasien psn
						ON (irn.NOMR = psn.NOMR)
						INNER JOIN db_simrs.m_ruang rng
						ON (irn.RUANG_ID = rng.RUANG_ID)
						WHERE irn.NO_PENDAFTARAN IS NOT NULL 
						AND irn.ST_BATAL IS NULL
						AND DATE(fms.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
						AND DATE(fms.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . '
						AND fms.JAMINAN_ID = "1"
						AND fms.NO_PEMBAYARAN IS NOT NULL
						AND UPPER(SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1)) = "' . strtoupper($_SESSION['SES_SIMRS_NAMA_PEGAWAI']) . '"
						GROUP BY irn.IRNA_ID,
						fms.SHIFT_PEMBAYARAN';
?>
<table border="1" >
	<tr>
		<th colspan="19">Laporan Pengembalian Resep Instalasi Farmasi Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>
	<tr>
		<th align="center" colspan="7">Penyetor : <?php echo $_SESSION['SES_SIMRS_NAMA_PEGAWAI']; ?></th>
	</tr>
 <tr>
     <th rowspan="2">No</th>
     <th rowspan="2">NoMR</th>
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
	<td align="center"><?php echo formatNomr($data['NOMR']); ?></td>
    <td><?php echo $data['NAMA_PASIEN']; ?></td>
	<td><?php echo $data['TGL_MASUK']; ?></td>
	<td><?php echo $data['TGL_KELUAR']; ?></td>
	<td><?php echo $data['NAMA_UNIT']; ?></td>
	<td>-</td>
	<td>Resep</td>
	<td>FMS</td>
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
