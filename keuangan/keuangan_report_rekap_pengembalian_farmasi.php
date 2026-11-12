<?php
$tgl_1 = '';
if (isset($_SESSION['pembayaranreportrekapbayarfarmasi_tgl_1']))
    $tgl_1 = $_SESSION['pembayaranreportrekapbayarfarmasi_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['pembayaranreportrekapbayarfarmasi_tgl_1']))
    $tgl_2 = $_SESSION['pembayaranreportrekapbayarfarmasi_tgl_2'];
	
$penyetor = '';
if (isset($_SESSION['pembayaranreportrekapbayar_penyetor']))
    $penyetor = $_SESSION['pembayaranreportrekapbayar_penyetor'];	
	
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['pembayaranreportrekapbayarfarmasi_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['pembayaranreportrekapbayarfarmasi_tgl_2'] = $_GET['tgl_2'];
}

if (isset($_GET['penyetor'])) {
    $penyetor = $_GET['penyetor'];
    $_SESSION['pembayaranreportrekapbayar_penyetor'] = $_GET['penyetor'];
}

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}	
?>
<form name="search" method="get" action="index.php">
    <table class="tableform" border="0" >
         <tr>
            <td>Penyetor</td>
            <td><select name="penyetor" class="text_dt" style="width:228px;" >
			<option value="" > - </option>
			<?php $sql = 'SELECT DISTINCT m_pegawai.NAMA_PEGAWAI
						FROM m_app_modul
						INNER JOIN m_app_user ON (m_app_modul.MODUL_ID = m_app_user.MODUL_ID)
						INNER JOIN m_pegawai ON (m_app_user.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
						WHERE m_app_modul.NAMA_MODUL = "Kasir"
						ORDER BY m_pegawai.NAMA_PEGAWAI';
				  $get = mysql_query($sql) or die(mysql_error());	 
				  while($dat = mysql_fetch_array($get)){
					?>
					<option value="<?php echo $dat['NAMA_PEGAWAI']; ?>" <?php if($penyetor == $dat['NAMA_PEGAWAI']) echo 'selected="selected"'; ?>><?php echo $dat['NAMA_PEGAWAI']; ?></option>
					<?php
				  }
				  ?>
			</select></td>
       </tr>
		<tr>
            <td>Tanggal</td>
            <td><input type="text" name="tgl_1" id="tgl_1" value="<?php echo $tgl_1; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
       </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/>
            </td>	
			<td>&nbsp;</td>
            <td align="right"><input type="submit" value="cari" class="myButton" />
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
mysql_select_db($database_3, $connect_3) or die(mysql_error());

$qry_filter_user = '';
if(!empty($penyetor)){
	$qry_filter_user = 'AND t_farmasi_apotik_pengembalian_resep.USER_PEMBAYARAN LIKE "%' . $penyetor . '"';
}

$qry_kunjungan = 'SELECT t_trans.*,m_persediaan_farmasi.NAMA_PERSEDIAAN FROM (
				SELECT t_farmasi_apotik_pengembalian_resep.JENIS_PENGEMBALIAN,
				t_farmasi_apotik_pengembalian_resep.UNIT_ID,
				t_farmasi_apotik_pengembalian_resep_detail.PERSEDIAAN_ID,
				t_farmasi_apotik_pengembalian_resep_detail.HARGA_BELI,
				t_farmasi_apotik_pengembalian_resep_detail.HARGA_JUAL,
				SUM(CASE WHEN t_farmasi_apotik_pengembalian_resep.SHIFT_PEMBAYARAN = "1" THEN t_farmasi_apotik_pengembalian_resep_detail.JUMLAH_KEMBALI END) AS BAYAR_SHIFT_1,
				SUM(CASE WHEN t_farmasi_apotik_pengembalian_resep.SHIFT_PEMBAYARAN = "2" THEN t_farmasi_apotik_pengembalian_resep_detail.JUMLAH_KEMBALI END) AS BAYAR_SHIFT_2,
				SUM(CASE WHEN t_farmasi_apotik_pengembalian_resep.SHIFT_PEMBAYARAN = "3" AND CAST(DATE_FORMAT(t_farmasi_apotik_pengembalian_resep.TANGGAL_BAYAR,"%H") AS UNSIGNED) <= 12 THEN t_farmasi_apotik_pengembalian_resep_detail.JUMLAH_KEMBALI END) AS BAYAR_SHIFT_3,
				SUM(CASE WHEN t_farmasi_apotik_pengembalian_resep.SHIFT_PEMBAYARAN = "3" AND CAST(DATE_FORMAT(t_farmasi_apotik_pengembalian_resep.TANGGAL_BAYAR,"%H") AS UNSIGNED) >= 18 THEN t_farmasi_apotik_pengembalian_resep_detail.JUMLAH_KEMBALI END) AS BAYAR_SHIFT_3_B
				FROM t_farmasi_apotik_pengembalian_resep
				INNER JOIN t_farmasi_apotik_pengembalian_resep_detail ON (t_farmasi_apotik_pengembalian_resep.FARMASI_PENGEMBALIAN_APOTIK_ID = t_farmasi_apotik_pengembalian_resep_detail.FARMASI_PENGEMBALIAN_ID)
				INNER JOIN t_ranap_resep_detail ON (t_farmasi_apotik_pengembalian_resep_detail.RANAP_RESEP_DETAIL_ID = t_ranap_resep_detail.RANAP_RESEP_DETAIL_ID)
				WHERE  t_farmasi_apotik_pengembalian_resep.JAMINAN_ID = "1" AND t_farmasi_apotik_pengembalian_resep.ST_BATAL IS NULL
				AND t_farmasi_apotik_pengembalian_resep.NO_PEMBAYARAN IS NOT NULL
				AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengembalian_resep.TANGGAL_BAYAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(t_farmasi_apotik_pengembalian_resep.TANGGAL_BAYAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '	
				AND t_farmasi_apotik_pengembalian_resep_detail.JUMLAH_KEMBALI > 0	
				' . $qry_filter_user . ' 
				AND t_farmasi_apotik_pengembalian_resep.JENIS_PENGEMBALIAN = "2"
				GROUP BY t_farmasi_apotik_pengembalian_resep.JENIS_PENGEMBALIAN,
				t_farmasi_apotik_pengembalian_resep.UNIT_ID,
				t_farmasi_apotik_pengembalian_resep_detail.PERSEDIAAN_ID,
				t_farmasi_apotik_pengembalian_resep_detail.HARGA_BELI,
				t_farmasi_apotik_pengembalian_resep_detail.HARGA_JUAL
				) t_trans
				INNER JOIN m_persediaan_farmasi ON (t_trans.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
				ORDER BY JENIS_PENGEMBALIAN,UNIT_ID,NAMA_PERSEDIAAN';
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());	
?>
<table width="100%" border="1" class="tableData" id="tfhover">
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
<?php $no = 1; 
$total_shift_1 = 0;
$total_shift_2 = 0;
$total_shift_3 = 0;
$total_shift_3b = 0;
while($data = mysql_fetch_array($get_kunjungan)){ ?>  
  <tr>
    <td scope="row" align="center"><?php echo $no; ?></td>
    <td><?php if($data['JENIS_PENGEMBALIAN'] == '1') echo 'Rawat Jalan'; if($data['JENIS_PENGEMBALIAN'] == '2') echo 'Rawat Inap'; if($data['JENIS_PENGEMBALIAN'] == '3') echo 'Penjualan Mandiri';?></td>
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
 <?php $no++; } ?>
<tr>
    <td colspan="5" align="right">Total :&nbsp;&nbsp;</td>
	<td colspan="2">&nbsp;</td>
	<td colspan="2" align="right"><?php echo currFormat($total_shift_1); ?></td>
	<td colspan="2" align="right"><?php echo currFormat($total_shift_2); ?></td>
	<td colspan="2" align="right"><?php echo currFormat($total_shift_3); ?></td>
	<td colspan="2" align="right"><?php echo currFormat($total_shift_3b); ?></td>
  </tr>  
</table>
<form id="xls_export" name="xls_export" method="post">
    <input type="hidden" name="page_to_excel" value="1" />
    <input type="hidden" name="tgl_1" value="<?php echo $tgl_1; ?>" />
    <input type="hidden" name="tgl_2" value="<?php echo $tgl_2; ?>" />
	<input type="hidden" name="penyetor" value="<?php echo $penyetor; ?>" />
    <input type="hidden" name="xlsfile" value="keuangan/xls_report_rekap_pengembalian_farmasi.php" />
    <input type="hidden" name="xlsname" value="rpt_rekap_pengembalian_farmasi.xls" />            
</form>
