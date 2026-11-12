<?php
$tgl_1 = '';
if (isset($_SESSION['pembayaranreportrekapbayar_tgl_1']))
    $tgl_1 = $_SESSION['pembayaranreportrekapbayar_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['pembayaranreportrekapbayar_tgl_1']))
    $tgl_2 = $_SESSION['pembayaranreportrekapbayar_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['pembayaranreportrekapbayar_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['pembayaranreportrekapbayar_tgl_2'] = $_GET['tgl_2'];
}

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}

$cash = '';
if (isset($_SESSION['pembayaranreportrekapbayar_cash']))
    $cash = $_SESSION['pembayaranreportrekapbayar_cash'];

if (isset($_GET['cash'])) {
    $cash = $_GET['cash'];
    $_SESSION['pembayaranreportrekapbayar_cash'] = $_GET['cash'];
}

$rekening = '';
if (isset($_SESSION['pembayaranreportrekapbayar_rekening']))
    $rekening = $_SESSION['pembayaranreportrekapbayar_rekening'];

if (isset($_GET['rekening'])) {
    $rekening = $_GET['rekening'];
    $_SESSION['pembayaranreportrekapbayar_rekening'] = $_GET['rekening'];
}	

$jns_bayar = '1';
if (isset($_SESSION['pembayaranreportrekapbayar_jns_bayar']))
    $jns_bayar = $_SESSION['pembayaranreportrekapbayar_jns_bayar'];

if (isset($_GET['jns_bayar'])) {
    $jns_bayar = $_GET['jns_bayar'];
    $_SESSION['pembayaranreportrekapbayar_jns_bayar'] = $_GET['jns_bayar'];
}

$arr_cash = getCash();
$arr_rekening = getRekening();
?>
<form name="search" method="get" action="index.php">
    <table class="tableform" border="0" >
         <tr>
            <td>Penyetor</td>
            <td><?php echo $_SESSION['SES_SIMRS_NAMA_PEGAWAI']; ?></td>
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
            <td align="right">&nbsp;</td>
		</tr>
			<tr>
			<td>Pembayaran</td>
            <td>
			<?php $arr_jenis_bayar = getArrJnsBayar();
				foreach($arr_jenis_bayar as $row){
					if(in_array($row['id'],getArrNonJaminan())){
						echo '<input type="radio" name="jns_bayar" value="' . $row['id'] . '" ' . (($jns_bayar == $row['id']) ? 'checked' : '') . ' />&nbsp;' . $row['nama'] . '&nbsp;&nbsp;';
					}
				}
			?>	
			</td>	
			<td>&nbsp;</td>
            <td align="right">&nbsp;</td>
		</tr>
		<tr>
			<td>Umum</td>
            <td>
            	<?php
            		echo '<select name="cash" class="text_dt" style="width:140px;" >';
					echo '<option value=""> - </option>';
					foreach ($arr_cash as $row) {
						echo '<option value="' . $row['kode'] . '" ' . (($cash == $row['kode']) ? 'selected' : '') . '>' . $row['deskripsi'] . '</option>';
					}
					echo '</select>';
            	?>
            </td>	
			<td>&nbsp;</td>
            <td align="right">&nbsp;</td>
		</tr>
		<tr>
			<td>Rekening</td>
            <td>
            	<?php
            		echo '<select name="rekening" class="text_dt" style="width:140px;" >';
					echo '<option value=""> - </option>';
					foreach ($arr_rekening as $row) {
						echo '<option value="' . $row['kode'] . '" ' . (($rekening == $row['kode']) ? 'selected' : '') .  '>' . $row['kode'] . '</option>';
					}
					echo '</select>';
            	?>
            </td>	
			<td>&nbsp;</td>
            <td align="right"><input type="submit" value="cari" class="myButton" />&nbsp;
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
	<input type="hidden" name="kasir" value="<?php echo $_REQUEST['kasir']; ?>" />
</form>
<br />
<?php
$qry_kunjungan = 'SELECT * FROM (
				SELECT t_bayar_l1.PENUNJANG_ID,
				t_bayar_l1.NO_PASIEN_PENUNJANG,
				t_bayar_l1.NAMA_PASIEN,
				t_bayar_l1.TGL_MASUK,
				t_bayar_l1.TGL_KELUAR,
				t_bayar_l1.INSTANSI_PENGIRIM,
				t_bayar_l1.TARIF_ID,
				mtrg.NAMA_TARIF_GROUP,
				mtr.NAMA_TARIF,
				t_bayar_l1.PASIEN,
				CAST(t_bayar_l1.TGL_BAYAR AS UNSIGNED) AS TGL_BAYAR,
				t_bayar_l1.SHIFT,
				t_bayar_l1.KASIR AS USER_KASIR,
				SUM(t_bayar_l1.KUANTITI) AS KUANTITI,
				SUM(CASE WHEN mtrg.NON_KELAS = "1" OR t_bayar_l1.KELAS_RAWAT = ""
					THEN t_bayar_l1.KUANTITI * mtr.TARIF_NON_KELAS
					ELSE	
						CASE WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "3" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_3 
							WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "2" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_2
							WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "1" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_1
							WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "UTAMA" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA
							WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "VIP" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA
							WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "UTAMA 2" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
							WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "VVIP" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
							WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "HCU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_HCU
							WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "ICU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_ICU
							WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "NICU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_NICU
							WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "PICU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_PICU
							WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "ICCU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_ICCU
							WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "PERINA" THEN t_bayar_l1.KUANTITI * mtr.TARIF_PERINA
							WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "BAYI SEHAT" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_PERINA_SEHAT
							WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "BAYI SAKIT" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_PERINA_SAKIT
						END 
					END) AS HARGA
					FROM (
							SELECT "PNJ" AS PASIEN,pnj.PENUNJANG_ID,
							pnj.NO_PASIEN_PENUNJANG,
							pnj.NAMA_PASIEN,
							pnj.INSTANSI_PENGIRIM,
							pnj.JENIS_BAYAR_ID,
							DATE_FORMAT(pnj.TANGGAL_ORDER,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(pnj.TANGGAL_ORDER,"%d-%m-%Y") AS TGL_KELUAR,
							pnjtf.TARIF_ID,pnjtf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(pnjtf.USER_KASIR,"|",-1) AS KASIR,
							DATE_FORMAT(pnjtf.TANGGAL_BAYAR,"%H") AS TGL_BAYAR,
							pnjtf.SHIFT_KASIR AS SHIFT
							FROM db_simrs.t_ipenunjang pnj
							INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
							ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
							AND pnjtf.NO_TARIF IS NOT NULL
							AND pnjtf.ST_BATAL IS NULL
							AND pnjtf.ST_BAYAR = "Lunas")
							WHERE DATE(pnjtf.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(pnjtf.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . '
							AND pnj.JNS_ORDER = "APS"
							AND pnj.JENIS_BAYAR_ID = "' . $jns_bayar . '"
							' . (($cash != '') ? ' AND pnjtf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND pnjtf.KODE_REKENING = "' . $rekening . '" ' : '') . ' 
					) t_bayar_l1
					INNER JOIN db_simrs.m_tarif mtr
					ON (t_bayar_l1.TARIF_ID = mtr.TARIF_ID)
					INNER JOIN db_simrs.m_tarif_group mtrg
					ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
					WHERE UPPER(t_bayar_l1.KASIR) = "' . strtoupper($_SESSION['SES_SIMRS_NAMA_PEGAWAI']) . '"
					GROUP BY t_bayar_l1.PENUNJANG_ID,
					mtr.TARIF_ID,
					t_bayar_l1.TGL_BAYAR,
					t_bayar_l1.SHIFT
					) t_bayar_l2
					ORDER BY PENUNJANG_ID';
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());	
?>
<table width="100%" border="1" class="tableData" id="tfhover">
 <tr>
     <th rowspan="2">No</th>
     <th rowspan="2">No Penunjang</th>
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
	<td><?php echo $data['NO_PASIEN_PENUNJANG']; ?></td>
    <td><?php echo $data['NAMA_PASIEN']; ?></td>
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
<form id="xls_export" name="xls_export" method="post">
    <input type="hidden" name="page_to_excel" value="1" />
    <input type="hidden" name="tgl_1" value="<?php echo $tgl_1; ?>" />
    <input type="hidden" name="tgl_2" value="<?php echo $tgl_2; ?>" />
    <input type="hidden" name="cash" value="<?php echo $cash; ?>" />
	<input type="hidden" name="rekening" value="<?php echo $rekening; ?>" />
	<input type="hidden" name="jns_bayar" value="<?php echo $jns_bayar; ?>" />
    <input type="hidden" name="xlsfile" value="pembayaran/xls_report_rekap_penunjang.php" />
    <input type="hidden" name="xlsname" value="rpt_rekap_penerimaan_penunjang.xls" />            
</form>
