<?php
$tgl_1 = '';
if (isset($_SESSION['pembayaranreportrekapbayar_tgl_1']))
    $tgl_1 = $_SESSION['pembayaranreportrekapbayar_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['pembayaranreportrekapbayar_tgl_1']))
    $tgl_2 = $_SESSION['pembayaranreportrekapbayar_tgl_2'];
	
$penyetor = '';
if (isset($_SESSION['pembayaranreportrekapbayar_penyetor']))
    $penyetor = $_SESSION['pembayaranreportrekapbayar_penyetor'];	
	
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['pembayaranreportrekapbayar_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['pembayaranreportrekapbayar_tgl_2'] = $_GET['tgl_2'];
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
	<input type="hidden" name="kasir" value="<?php echo $_REQUEST['kasir']; ?>" />
</form>
<br />
<?php

$qry_filter_user = '';
if(!empty($penyetor)){
	$qry_filter_user = 'AND t_irna_tarif.USER_KASIR LIKE "%' . $penyetor . '"';
}

$qry_kunjungan = 'SELECT m_tarif.TARIF_ID,m_tarif.NAMA_TARIF,m_tarif_group.NAMA_TARIF_GROUP,
				SUM(CASE WHEN t_irna.KELAS_RAWAT = "3" AND t_irna_tarif.SHIFT_ID = "1" 
					THEN t_irna_tarif.KUANTITI ELSE 0 END) AS JUMLAH_SHIFT_1_KELAS_3,
				SUM(CASE WHEN t_irna.KELAS_RAWAT = "2" AND t_irna_tarif.SHIFT_ID = "1" 
					THEN t_irna_tarif.KUANTITI ELSE 0 END) AS JUMLAH_SHIFT_1_KELAS_2,
				SUM(CASE WHEN t_irna.KELAS_RAWAT = "1" AND t_irna_tarif.SHIFT_ID = "1" 
					THEN t_irna_tarif.KUANTITI ELSE 0 END) AS JUMLAH_SHIFT_1_KELAS_1,
				SUM(CASE WHEN t_irna.KELAS_RAWAT = "Utama" AND t_irna_tarif.SHIFT_ID = "1" 
					THEN t_irna_tarif.KUANTITI ELSE 0 END) AS JUMLAH_SHIFT_1_KELAS_UTAMA,	
				
				SUM(CASE WHEN t_irna.KELAS_RAWAT = "3" AND t_irna_tarif.SHIFT_ID = "2" 
					THEN t_irna_tarif.KUANTITI ELSE 0 END) AS JUMLAH_SHIFT_2_KELAS_3,
				SUM(CASE WHEN t_irna.KELAS_RAWAT = "2" AND t_irna_tarif.SHIFT_ID = "2" 
					THEN t_irna_tarif.KUANTITI ELSE 0 END) AS JUMLAH_SHIFT_2_KELAS_2,
				SUM(CASE WHEN t_irna.KELAS_RAWAT = "1" AND t_irna_tarif.SHIFT_ID = "2" 
					THEN t_irna_tarif.KUANTITI ELSE 0 END) AS JUMLAH_SHIFT_2_KELAS_1,
				SUM(CASE WHEN t_irna.KELAS_RAWAT = "Utama" AND t_irna_tarif.SHIFT_ID = "2" 
					THEN t_irna_tarif.KUANTITI ELSE 0 END) AS JUMLAH_SHIFT_2_KELAS_UTAMA,
					
				SUM(CASE WHEN t_irna.KELAS_RAWAT = "3" AND t_irna_tarif.SHIFT_ID = "3" 
					AND CAST(DATE_FORMAT(t_irna_tarif.TGL_BAYAR,"%H") AS UNSIGNED) <= 12 
					THEN t_irna_tarif.KUANTITI ELSE 0 END) AS JUMLAH_SHIFT_3_KELAS_3,
				SUM(CASE WHEN t_irna.KELAS_RAWAT = "3" AND t_irna_tarif.SHIFT_ID = "3" 
					AND CAST(DATE_FORMAT(t_irna_tarif.TGL_BAYAR,"%H") AS UNSIGNED) >= 18 
					THEN t_irna_tarif.KUANTITI ELSE 0 END) AS JUMLAH_SHIFT_3_KELAS_3_B,	
				SUM(CASE WHEN t_irna.KELAS_RAWAT = "2" AND t_irna_tarif.SHIFT_ID = "3"
					AND CAST(DATE_FORMAT(t_irna_tarif.TGL_BAYAR,"%H") AS UNSIGNED) <= 12 
					THEN t_irna_tarif.KUANTITI ELSE 0 END) AS JUMLAH_SHIFT_3_KELAS_2,
				SUM(CASE WHEN t_irna.KELAS_RAWAT = "2" AND t_irna_tarif.SHIFT_ID = "3"
					AND CAST(DATE_FORMAT(t_irna_tarif.TGL_BAYAR,"%H") AS UNSIGNED) >= 18 
					THEN t_irna_tarif.KUANTITI ELSE 0 END) AS JUMLAH_SHIFT_3_KELAS_2_B,	
				SUM(CASE WHEN t_irna.KELAS_RAWAT = "1" AND t_irna_tarif.SHIFT_ID = "3" 
					AND CAST(DATE_FORMAT(t_irna_tarif.TGL_BAYAR,"%H") AS UNSIGNED) <= 12 
					THEN t_irna_tarif.KUANTITI ELSE 0 END) AS JUMLAH_SHIFT_3_KELAS_1,
				SUM(CASE WHEN t_irna.KELAS_RAWAT = "1" AND t_irna_tarif.SHIFT_ID = "3" 
					AND CAST(DATE_FORMAT(t_irna_tarif.TGL_BAYAR,"%H") AS UNSIGNED) >= 18 
					THEN t_irna_tarif.KUANTITI ELSE 0 END) AS JUMLAH_SHIFT_3_KELAS_1_B,	
				SUM(CASE WHEN t_irna.KELAS_RAWAT = "Utama" AND t_irna_tarif.SHIFT_ID = "3"
					AND CAST(DATE_FORMAT(t_irna_tarif.TGL_BAYAR,"%H") AS UNSIGNED) <= 12 
					THEN t_irna_tarif.KUANTITI ELSE 0 END) AS JUMLAH_SHIFT_3_KELAS_UTAMA,	
				SUM(CASE WHEN t_irna.KELAS_RAWAT = "Utama" AND t_irna_tarif.SHIFT_ID = "3"
					AND CAST(DATE_FORMAT(t_irna_tarif.TGL_BAYAR,"%H") AS UNSIGNED) >= 18 
					THEN t_irna_tarif.KUANTITI ELSE 0 END) AS JUMLAH_SHIFT_3_KELAS_UTAMA_B,	
					
				SUM(CASE WHEN t_irna.KELAS_RAWAT = "3" AND t_irna_tarif.SHIFT_ID = "1" 
					THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_KELAS_3 ELSE 0 END) AS BAYAR_SHIFT_1_KELAS_3,
				SUM(CASE WHEN t_irna.KELAS_RAWAT = "2" AND t_irna_tarif.SHIFT_ID = "1" 
					THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_KELAS_2 ELSE 0 END) AS BAYAR_SHIFT_1_KELAS_2,
				SUM(CASE WHEN t_irna.KELAS_RAWAT = "1" AND t_irna_tarif.SHIFT_ID = "1" 
					THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_KELAS_1 ELSE 0 END) AS BAYAR_SHIFT_1_KELAS_1,
				SUM(CASE WHEN t_irna.KELAS_RAWAT = "Utama" AND t_irna_tarif.SHIFT_ID = "1" 
					THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_KELAS_UTAMA ELSE 0 END) AS BAYAR_SHIFT_1_KELAS_UTAMA,	
				
				SUM(CASE WHEN t_irna.KELAS_RAWAT = "3" AND t_irna_tarif.SHIFT_ID = "2" 
					THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_KELAS_3 ELSE 0 END) AS BAYAR_SHIFT_2_KELAS_3,
				SUM(CASE WHEN t_irna.KELAS_RAWAT = "2" AND t_irna_tarif.SHIFT_ID = "2" 
					THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_KELAS_2 ELSE 0 END) AS BAYAR_SHIFT_2_KELAS_2,
				SUM(CASE WHEN t_irna.KELAS_RAWAT = "1" AND t_irna_tarif.SHIFT_ID = "2" 
					THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_KELAS_1 ELSE 0 END) AS BAYAR_SHIFT_2_KELAS_1,
				SUM(CASE WHEN t_irna.KELAS_RAWAT = "Utama" AND t_irna_tarif.SHIFT_ID = "2" 
					THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_KELAS_UTAMA ELSE 0 END) AS BAYAR_SHIFT_2_KELAS_UTAMA,
					
				SUM(CASE WHEN t_irna.KELAS_RAWAT = "3" AND t_irna_tarif.SHIFT_ID = "3" 
					AND CAST(DATE_FORMAT(t_irna_tarif.TGL_BAYAR,"%H") AS UNSIGNED) <= 12 
					THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_KELAS_3 ELSE 0 END) AS BAYAR_SHIFT_3_KELAS_3,
				SUM(CASE WHEN t_irna.KELAS_RAWAT = "3" AND t_irna_tarif.SHIFT_ID = "3" 
					AND CAST(DATE_FORMAT(t_irna_tarif.TGL_BAYAR,"%H") AS UNSIGNED) >= 18 
					THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_KELAS_3 ELSE 0 END) AS BAYAR_SHIFT_3_KELAS_3_B,	
				SUM(CASE WHEN t_irna.KELAS_RAWAT = "2" AND t_irna_tarif.SHIFT_ID = "3" 
					AND CAST(DATE_FORMAT(t_irna_tarif.TGL_BAYAR,"%H") AS UNSIGNED) <= 12 	
					THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_KELAS_2 ELSE 0 END) AS BAYAR_SHIFT_3_KELAS_2,
				SUM(CASE WHEN t_irna.KELAS_RAWAT = "2" AND t_irna_tarif.SHIFT_ID = "3" 
					AND CAST(DATE_FORMAT(t_irna_tarif.TGL_BAYAR,"%H") AS UNSIGNED) >= 18 	
					THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_KELAS_2 ELSE 0 END) AS BAYAR_SHIFT_3_KELAS_2_B,	
				SUM(CASE WHEN t_irna.KELAS_RAWAT = "1" AND t_irna_tarif.SHIFT_ID = "3" 
					AND CAST(DATE_FORMAT(t_irna_tarif.TGL_BAYAR,"%H") AS UNSIGNED) <= 12 	
					THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_KELAS_1 ELSE 0 END) AS BAYAR_SHIFT_3_KELAS_1,
				SUM(CASE WHEN t_irna.KELAS_RAWAT = "1" AND t_irna_tarif.SHIFT_ID = "3" 
					AND CAST(DATE_FORMAT(t_irna_tarif.TGL_BAYAR,"%H") AS UNSIGNED) >= 18 	
					THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_KELAS_1 ELSE 0 END) AS BAYAR_SHIFT_3_KELAS_1_B,	
				SUM(CASE WHEN t_irna.KELAS_RAWAT = "Utama" AND t_irna_tarif.SHIFT_ID = "3" 
					AND CAST(DATE_FORMAT(t_irna_tarif.TGL_BAYAR,"%H") AS UNSIGNED) <= 12 	
					THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_KELAS_UTAMA ELSE 0 END) AS BAYAR_SHIFT_3_KELAS_UTAMA,
				SUM(CASE WHEN t_irna.KELAS_RAWAT = "Utama" AND t_irna_tarif.SHIFT_ID = "3" 
					AND CAST(DATE_FORMAT(t_irna_tarif.TGL_BAYAR,"%H") AS UNSIGNED) >= 18 	
					THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_KELAS_UTAMA ELSE 0 END) AS BAYAR_SHIFT_3_KELAS_UTAMA		
				FROM t_irna 
				INNER JOIN t_irna_tarif ON (t_irna.IRNA_ID = t_irna_tarif.IRNA_ID)
				INNER JOIN m_tarif ON (t_irna_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_irna.JENIS_BAYAR_ID = "1" AND t_irna.ST_BATAL IS NULL
				AND STR_TO_DATE(DATE_FORMAT(t_irna_tarif.TGL_BAYAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(t_irna_tarif.TGL_BAYAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '	
				' . $qry_filter_user . '
				AND t_irna_tarif.ST_BAYAR = "Lunas" 
				GROUP BY m_tarif.TARIF_ID,m_tarif.NAMA_TARIF,m_tarif_group.NAMA_TARIF_GROUP';
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());	
?>
<table width="100%" border="1" class="tableData" id="tfhover">
    <tr>
    <th rowspan="3">No</th>
    <th rowspan="3">Tarif</th>
	<th rowspan="3">Group Tarif</th>
	<th colspan="8" >Shift 1 </th>
    <th colspan="8" >Shift 2 </th>
    <th colspan="8">Shift 3 Am</th>
	<th colspan="8">Shift 3 Pm</th>
    <th rowspan="3">Total</th>
  </tr>
  <tr>
    <th colspan="2" >Kelas Utama </th>
	<th colspan="2" >Kelas 1 </th>
    <th colspan="2" >Kelas 2 </th>
    <th colspan="2" >Kelas 3 </th>
    <th colspan="2" >Kelas Utama </th>
    <th colspan="2" >Kelas 1 </th>
    <th colspan="2" >Kelas 2 </th>
    <th colspan="2" >Kelas 3 </th>
    <th colspan="2">Kelas Utama </th>
    <th colspan="2">Kelas 1 </th>
    <th colspan="2">Kelas 2 </th>
    <th colspan="2">Kelas 3 </th>
    <th colspan="2">Kelas Utama </th>
	<th colspan="2">Kelas 1 </th>
    <th colspan="2">Kelas 2 </th>
    <th colspan="2">Kelas 3 </th>
  </tr>
  <tr>
    <th >Jml</th>
    <th >Rp</th>
    <th >Jml</th>
    <th >Rp</th>
    <th >Jml</th>
    <th >Rp</th>
    <th >Jml</th>
    <th >Rp</th>
    <th >Jml</th>
    <th >Rp</th>
    <th >Jml</th>
    <th >Rp</th>
    <th >Jml</th>
    <th >Rp</th>
    <th >Jml</th>
    <th >Rp</th>
    <th>Jml</th>
    <th>Rp</th>
    <th>Jml</th>
    <th>Rp</th>
    <th>Jml</th>
    <th>Rp</th>
    <th>Jml</th>
    <th>Rp</th>
    <th>Jml</th>
    <th>Rp</th>
    <th>Jml</th>
    <th>Rp</th>
    <th>Jml</th>
    <th>Rp</th>
    <th>Jml</th>
    <th>Rp</th>
  </tr>
<?php $no = 1; 
$total = 0;
while($data = mysql_fetch_array($get_kunjungan)){ ?>  
  <tr>
    <td scope="row" align="center"><?php echo $no; ?></td>
    <td><?php echo $data['NAMA_TARIF']; ?></td>
	<td><?php echo $data['NAMA_TARIF_GROUP']; ?></td>
	<td align="right"><?php echo currFormat($data['JUMLAH_SHIFT_1_KELAS_UTAMA']); ?></td>
	<td align="right"><?php echo currFormat($data['BAYAR_SHIFT_1_KELAS_UTAMA']); ?></td>
	<td align="right"><?php echo currFormat($data['JUMLAH_SHIFT_1_KELAS_1']); ?></td>
	<td align="right"><?php echo currFormat($data['BAYAR_SHIFT_1_KELAS_1']); ?></td>
	<td align="right"><?php echo currFormat($data['JUMLAH_SHIFT_1_KELAS_2']); ?></td>
	<td align="right"><?php echo currFormat($data['BAYAR_SHIFT_1_KELAS_2']); ?></td>
	<td align="right"><?php echo currFormat($data['JUMLAH_SHIFT_1_KELAS_3']); ?></td>
	<td align="right"><?php echo currFormat($data['BAYAR_SHIFT_1_KELAS_3']); ?></td>
	
	<td align="right"><?php echo currFormat($data['JUMLAH_SHIFT_2_KELAS_UTAMA']); ?></td>
	<td align="right"><?php echo currFormat($data['BAYAR_SHIFT_2_KELAS_UTAMA']); ?></td>
	<td align="right"><?php echo currFormat($data['JUMLAH_SHIFT_2_KELAS_1']); ?></td>
	<td align="right"><?php echo currFormat($data['BAYAR_SHIFT_2_KELAS_1']); ?></td>
	<td align="right"><?php echo currFormat($data['JUMLAH_SHIFT_2_KELAS_2']); ?></td>
	<td align="right"><?php echo currFormat($data['BAYAR_SHIFT_2_KELAS_2']); ?></td>
	<td align="right"><?php echo currFormat($data['JUMLAH_SHIFT_2_KELAS_3']); ?></td>
	<td align="right"><?php echo currFormat($data['BAYAR_SHIFT_2_KELAS_3']); ?></td>
	
	<td align="right"><?php echo currFormat($data['JUMLAH_SHIFT_3_KELAS_UTAMA']); ?></td>
	<td align="right"><?php echo currFormat($data['BAYAR_SHIFT_3_KELAS_UTAMA']); ?></td>
	<td align="right"><?php echo currFormat($data['JUMLAH_SHIFT_3_KELAS_1']); ?></td>
	<td align="right"><?php echo currFormat($data['BAYAR_SHIFT_3_KELAS_1']); ?></td>
	<td align="right"><?php echo currFormat($data['JUMLAH_SHIFT_3_KELAS_2']); ?></td>
	<td align="right"><?php echo currFormat($data['BAYAR_SHIFT_3_KELAS_2']); ?></td>
	<td align="right"><?php echo currFormat($data['JUMLAH_SHIFT_3_KELAS_3']); ?></td>
	<td align="right"><?php echo currFormat($data['BAYAR_SHIFT_3_KELAS_3']); ?></td>
	
	<td align="right"><?php echo currFormat($data['JUMLAH_SHIFT_3_KELAS_UTAMA_B']); ?></td>
	<td align="right"><?php echo currFormat($data['BAYAR_SHIFT_3_KELAS_UTAMA_B']); ?></td>
	<td align="right"><?php echo currFormat($data['JUMLAH_SHIFT_3_KELAS_1_B']); ?></td>
	<td align="right"><?php echo currFormat($data['BAYAR_SHIFT_3_KELAS_1_B']); ?></td>
	<td align="right"><?php echo currFormat($data['JUMLAH_SHIFT_3_KELAS_2_B']); ?></td>
	<td align="right"><?php echo currFormat($data['BAYAR_SHIFT_3_KELAS_2_B']); ?></td>
	<td align="right"><?php echo currFormat($data['JUMLAH_SHIFT_3_KELAS_3_B']); ?></td>
	<td align="right"><?php echo currFormat($data['BAYAR_SHIFT_3_KELAS_3_B']); ?></td>
	
    <td align="right">
	<?php echo currFormat($data['BAYAR_SHIFT_1_KELAS_3'] + $data['BAYAR_SHIFT_1_KELAS_2'] + $data['BAYAR_SHIFT_1_KELAS_1']
		+ $data['BAYAR_SHIFT_1_KELAS_UTAMA'] + $data['BAYAR_SHIFT_2_KELAS_3'] + $data['BAYAR_SHIFT_2_KELAS_2']
		+ $data['BAYAR_SHIFT_2_KELAS_1'] + $data['BAYAR_SHIFT_2_KELAS_UTAMA'] + $data['BAYAR_SHIFT_3_KELAS_3']
		+ $data['BAYAR_SHIFT_3_KELAS_2'] + $data['BAYAR_SHIFT_3_KELAS_1'] + $data['BAYAR_SHIFT_3_KELAS_UTAMA']
		+ $data['BAYAR_SHIFT_3_KELAS_3_B']
		+ $data['BAYAR_SHIFT_3_KELAS_2_B'] + $data['BAYAR_SHIFT_3_KELAS_1_B'] + $data['BAYAR_SHIFT_3_KELAS_UTAMA_B']);
	$total = $total +$data['BAYAR_SHIFT_1_KELAS_3'] + $data['BAYAR_SHIFT_1_KELAS_2'] + $data['BAYAR_SHIFT_1_KELAS_1']
		+ $data['BAYAR_SHIFT_1_KELAS_UTAMA'] + $data['BAYAR_SHIFT_2_KELAS_3'] + $data['BAYAR_SHIFT_2_KELAS_2']
		+ $data['BAYAR_SHIFT_2_KELAS_1'] + $data['BAYAR_SHIFT_2_KELAS_UTAMA'] + $data['BAYAR_SHIFT_3_KELAS_3']
		+ $data['BAYAR_SHIFT_3_KELAS_2'] + $data['BAYAR_SHIFT_3_KELAS_1'] + $data['BAYAR_SHIFT_3_KELAS_UTAMA']
		+ $data['BAYAR_SHIFT_3_KELAS_3_B']
		+ $data['BAYAR_SHIFT_3_KELAS_2_B'] + $data['BAYAR_SHIFT_3_KELAS_1_B'] + $data['BAYAR_SHIFT_3_KELAS_UTAMA_B']; ?></td>
  </tr>
 <?php $no++; } ?> 
 <tr>
    <td colspan="35" align="right">Total :&nbsp;&nbsp;</td>
	<td align="right"><?php echo currFormat($total); ?></td>
  </tr>
</table>
<form id="xls_export" name="xls_export" method="post">
    <input type="hidden" name="page_to_excel" value="1" />
    <input type="hidden" name="tgl_1" value="<?php echo $tgl_1; ?>" />
    <input type="hidden" name="tgl_2" value="<?php echo $tgl_2; ?>" />
	<input type="hidden" name="penyetor" value="<?php echo $penyetor; ?>" />
    <input type="hidden" name="xlsfile" value="keuangan/xls_report_rekap_ranap.php" />
    <input type="hidden" name="xlsname" value="rpt_rekap_penerimaan_ranap.xls" />            
</form>
