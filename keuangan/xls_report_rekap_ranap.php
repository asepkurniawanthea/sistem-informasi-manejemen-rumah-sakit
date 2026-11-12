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

$kasir = '';
if (isset($_POST['kasir']))
		$kasir = $_POST['kasir'];
		
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
?>
<table border="1" >
	<tr>
		<th colspan="36">Laporan Penerimaan Rawat Inap Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>
	<tr>
		<th align="center" colspan="36">Penyetor : <?php echo $penyetor; ?></th>
	</tr>
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
    <?
    $no = 1;
	$total = 0;
	$rs = mysql_query($qry_kunjungan) or die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
	?>
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
        <?
    $no++; }
    ?>
 <tr>
    <td colspan="35" align="right">Total :&nbsp;&nbsp;</td>
	<td align="right"><?php echo currFormat($total); ?></td>
  </tr>
</table>
