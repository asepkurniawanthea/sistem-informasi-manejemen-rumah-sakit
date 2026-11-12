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

$qry_kunjungan = 'SELECT * FROM (
				SELECT t_bayar_l1.PENERIMAAN_LAINLAIN_ID,
				t_bayar_l1.TELEPON,
				t_bayar_l1.NAMA_INSTANSI,
				t_bayar_l1.TANGGAL,
				t_bayar_l1.JENIS_INSTANSI,
				t_bayar_l1.PIC,
				t_bayar_l1.TARIF_ID,
				mtrg.NAMA_TARIF_GROUP,
				mtr.NAMA_TARIF,
				t_bayar_l1.PASIEN,
				NULL AS TGL_BAYAR,
				NULL AS SHIFT,
				t_bayar_l1.KASIR AS USER_KASIR,
				SUM(t_bayar_l1.KUANTITI) AS KUANTITI,
				SUM(t_bayar_l1.KUANTITI * mtr.TARIF_NON_KELAS) AS HARGA
					FROM (
							SELECT "PNL" AS PASIEN,pnl.PENERIMAAN_LAINLAIN_ID,
							pnl.TELEPON,
							pnl.NAMA_INSTANSI,
							pnl.JENIS_INSTANSI,
							pnl.PIC,
							DATE_FORMAT(pnl.TANGGAL,"%d-%m-%Y") AS TANGGAL,
							pnltf.TARIF_ID,pnltf.KUANTITI,
							SUBSTRING_INDEX(pnl.REGISTER,"|",-1) AS KASIR
							FROM db_simkeu.r_penerimaan_lainlain pnl
							INNER JOIN db_simkeu.r_penerimaan_lainlain_tarif pnltf
							ON (pnl.PENERIMAAN_LAINLAIN_ID = pnltf.PENERIMAAN_LAINLAIN_ID)
							WHERE DATE(pnl.TANGGAL) >= ' . $tgl_filter_1 . ' 
							AND DATE(pnl.TANGGAL) <= ' . $tgl_filter_2 . '
							AND pnl.NO_PEMBAYARAN IS NOT NULL
							' . (($cash != '') ? ' AND pnl.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND pnl.KODE_REKENING = "' . $rekening . '" ' : '') . ' 
					) t_bayar_l1
					INNER JOIN db_simrs.m_tarif mtr
					ON (t_bayar_l1.TARIF_ID = mtr.TARIF_ID)
					INNER JOIN db_simrs.m_tarif_group mtrg
					ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
					WHERE UPPER(t_bayar_l1.KASIR) = "' . strtoupper($_SESSION['SES_SIMRS_NAMA_PEGAWAI']) . '"
					GROUP BY t_bayar_l1.PENERIMAAN_LAINLAIN_ID,
					mtr.TARIF_ID
					) t_bayar_l2
					ORDER BY PENERIMAAN_LAINLAIN_ID';
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());					
?>
<table border="1" >
<tr>
		<th colspan="19">Laporan Penerimaan Lain-lain Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>
	<tr>
		<th align="center" colspan="19">Penyetor : <?php echo $_SESSION['SES_SIMRS_NAMA_PEGAWAI']; ?></th>
	</tr>
<tr>
     <th rowspan="2">No</th>
     <th rowspan="2">No Telepon</th>
     <th rowspan="2">Nama Instansi</th>
     <th rowspan="2">PIC</th>
     <th rowspan="2">Tanggal</th>
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
<?php $no = 1; 
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
while($data = mysql_fetch_array($get_kunjungan)){ ?>  
  <tr>
    <td scope="row" align="center"><?php echo $no; ?></td>
	<td><?php echo $data['TELEPON']; ?></td>
    <td><?php echo $data['NAMA_INSTANSI']; ?></td>
	<td><?php echo $data['PIC']; ?></td>
	<td><?php echo $data['TANGGAL']; ?></td>
	<td><?php echo $data['JENIS_INSTANSI']; ?></td>
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
 <?php $no++; } ?> 
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
