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

$qry_kunjungan = 'SELECT t_irja.TANGGAL_DAFTAR,
	COUNT(t_irja.IRJA_ID) AS TOTAL, 
	SUM(CASE WHEN (DATEDIFF(t_irja.TANGGAL_DAFTAR, m_pasien.TGL_LAHIR)/365) >= 14 
		THEN 1 ELSE 0 END) AS DEWASA,
	SUM(CASE WHEN (DATEDIFF(t_irja.TANGGAL_DAFTAR, m_pasien.TGL_LAHIR)/365) < 14 
		THEN 1 ELSE 0 END) AS ANAK,
	SUM(CASE WHEN m_pasien.JNS_KELAMIN = "L" THEN 1 ELSE 0 END) AS LK,
	SUM(CASE WHEN m_pasien.JNS_KELAMIN = "P" THEN 1 ELSE 0 END) AS PR,
	SUM(CASE WHEN (SELECT COUNT(t.IRJA_ID) AS CN FROM t_irja t 
		WHERE t.NOMR = t_irja.NOMR AND t.IRJA_ID < t_irja.IRJA_ID) = 0
		THEN 1 ELSE 0 END) AS PASIEN_BR,
	SUM(CASE WHEN t_irja.KUSTA_TYPE = "NR" THEN 1 ELSE 0 END) AS NR,	
	SUM(CASE WHEN t_irja.KUSTA_TYPE = "TT" THEN 1 ELSE 0 END) AS TT,
	SUM(CASE WHEN t_irja.KUSTA_TYPE = "BT" THEN 1 ELSE 0 END) AS BT,
	SUM(CASE WHEN t_irja.KUSTA_TYPE = "BB" THEN 1 ELSE 0 END) AS BB,
	SUM(CASE WHEN t_irja.KUSTA_TYPE = "BL" THEN 1 ELSE 0 END) AS BL,
	SUM(CASE WHEN t_irja.KUSTA_TYPE = "LL" THEN 1 ELSE 0 END) AS LL,
	SUM(CASE WHEN t_irja.KUSTA_TYPE = "OM" THEN 1 ELSE 0 END) AS OBSERVASI,
	SUM(CASE WHEN t_irja.KUSTA_TYPE = "NM" THEN 1 ELSE 0 END) AS NON_MH,
	SUM(CASE WHEN t_irja.KUSTA_RFT_COT IS NOT NULL THEN 1 ELSE 0 END) AS RFT,
	SUM(CASE WHEN t_irja.KUSTA_KUNJUNGAN = 1 THEN 1 ELSE 0 END) AS PERTAMA, 	 	
	SUM(CASE WHEN t_irja.KUSTA_OPNAME = "1" THEN 1 ELSE 0 END) AS OPNAME 	
	FROM t_irja
	INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR) 
	WHERE t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL  
	AND t_irja.UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '"
	AND t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . '
	AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
	GROUP BY t_irja.TANGGAL_DAFTAR
	ORDER BY t_irja.TANGGAL_DAFTAR';
	
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());	
?>
<table width="100%" border="1" >
	<tr>
		<th colspan="15">Laporan Kunjungan Pasien Harian Kusta Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>	
  <tr>
        <th rowspan="2">No</th>
        <th rowspan="2">Tanggal Daftar</th>
        <th rowspan="2">Dewasa</th>
        <th rowspan="2">Anak</th>
        <th rowspan="2">Pasien Baru</th>
        <th rowspan="2">Laki-laki</th>
        <th rowspan="2">Perempuan</th>
        <th colspan="3">PB</th>
		<th colspan="3">MB</th>
		<th rowspan="2">Observasi</th>
		<th rowspan="2">Non MH</th>
        <th rowspan="2">RFT (COT) </th>
		<th rowspan="2">Kunjungan Pertama</th>
        <th rowspan="2">Opname</th>
    </tr>
	 <tr>
        <th>N</th>
		<th>TT</th>
		<th>BT</th>
		<th>BB</th>
        <th>BL</th>
        <th>LL</th>
    </tr>
 <?php $no = 1;
	$tot_dewasa = 0;
	$tot_anak = 0;
	$tot_pasien_br = 0;
	$tot_lk = 0;
	$tot_pr = 0;
	$tot_nr = 0;
	$tot_tt = 0;
	$tot_bt = 0;
	$tot_bb = 0;
	$tot_bl = 0;
	$tot_ll = 0;
	$tot_observasi = 0;
	$tot_non_mh = 0;
	$tot_rft = 0;
	$tot_pertama = 0;
	$tot_opname = 0;
	$total = 0;
	$rs = mysql_query($qry_kunjungan) or die(mysql_error());
    while ($data = mysql_fetch_array($rs)) { ?>  
  <tr>
    <td scope="row" align="center"><?php echo $no; ?></td>
    <td align="center"><?php echo changeDateFormat($data['TANGGAL_DAFTAR']); ?></td>
            <td align="right"><?php echo $data['DEWASA']; ?></td>
			<td align="right"><?php echo $data['ANAK']; ?></td>
			<td align="right"><?php echo $data['PASIEN_BR']; ?></td>
			<td align="right"><?php echo $data['LK']; ?></td>
			<td align="right"><?php echo $data['PR']; ?></td>
			<td align="right"><?php echo $data['NR']; ?></td>
			<td align="right"><?php echo $data['TT']; ?></td>
			<td align="right"><?php echo $data['BT']; ?></td>
			<td align="right"><?php echo $data['BB']; ?></td>
			<td align="right"><?php echo $data['BL']; ?></td>
			<td align="right"><?php echo $data['LL']; ?></td>
			<td align="right"><?php echo $data['OBSERVASI']; ?></td>
			<td align="right"><?php echo $data['NON_MH']; ?></td>
			<td align="right"><?php echo $data['RFT']; ?></td>
			<td align="right"><?php echo $data['PERTAMA']; ?></td>
			<td align="right"><?php echo $data['OPNAME']; ?></td>
 <?php $no++; 
		$tot_dewasa = $tot_dewasa + $data['DEWASA'];
		$tot_anak = $tot_anak + $data['ANAK'];
		$tot_pasien_br = $tot_pasien_br + $data['PASIEN_BR'];
		$tot_lk = $tot_lk + $data['LK'];
		$tot_pr = $tot_pr + $data['PR'];
		$tot_nr = $tot_nr + $data['NR'];
		$tot_tt = $tot_tt + $data['TT'];
		$tot_bt = $tot_bt + $data['BT'];
		$tot_bb = $tot_bb + $data['BB'];
		$tot_bl = $tot_bl + $data['BL'];
		$tot_ll = $tot_ll + $data['LL'];
		$tot_observasi = $tot_observasi + $data['OBSERVASI']; 
		$tot_non_mh = $tot_non_mh + $data['NON_MH']; 
		$tot_rft = $tot_rft + $data['RFT'];
		$tot_opname = $tot_opname + $data['OPNAME'];
		$tot_pertama = $tot_pertama + $data['PERTAMA'];
		$total = $total + $data['TOTAL'];
 } ?> 
<tr>
<td align="center" colspan="2" rowspan="3" style="vertical-align:middle"><strong>Total</strong></td>
            <td align="right"><?php echo $tot_dewasa; ?></td>
			<td align="right"><?php echo $tot_anak; ?></td>
			<td align="right"><?php echo $tot_pasien_br; ?></td>
			<td align="right"><?php echo $tot_lk; ?></td>
			<td align="right"><?php echo $tot_pr; ?></td>
			<td align="right" colspan="3"><?php echo $tot_nr + $tot_tt + $tot_bt; ?></td>
			<td align="right" colspan="3"><?php echo $tot_bb + $tot_bl + $tot_ll; ?></td>
			<td align="right"><?php echo $tot_observasi; ?></td>
			<td align="right"><?php echo $tot_non_mh; ?></td>
			<td align="right"><?php echo $tot_rft; ?></td>
			<td align="right"><?php echo $tot_pertama; ?></td>
			<td align="right"><?php echo $tot_opname; ?></td>
</tr>
<tr>
	<td colspan="16" align="center"><?php echo $total; ?>&nbsp;Kunjungan</td>
</tr>			
<tr>
            <td align="right"><?php echo ($tot_dewasa/$total) * 100; ?></td>
			<td align="right"><?php echo ($tot_anak/$total) * 100; ?></td>
			<td align="right"><?php echo ($tot_pasien_br/$total) * 100; ?></td>
			<td align="right"><?php echo ($tot_lk/$total) * 100; ?></td>
			<td align="right"><?php echo ($tot_pr/$total) * 100; ?></td>
			<?php 
				$tot_pb = $tot_nr + $tot_tt + $tot_bt;
				$tot_mb = $tot_bb + $tot_bl + $tot_ll;
			?>
			<td align="right" colspan="3"><?php echo ($tot_pb/$total) * 100; ?></td>
			<td align="right" colspan="3"><?php echo ($tot_mb/$total) * 100; ?></td>
			<td align="right"><?php echo ($tot_observasi/$total) * 100; ?></td>
			<td align="right"><?php echo ($tot_non_mh/$total) * 100; ?></td>
			<td align="right"><?php echo ($tot_rft/$total) * 100; ?></td>
			<td align="right"><?php echo ($tot_pertama/$total) * 100; ?></td>
			<td align="right"><?php echo ($tot_opname/$total) * 100; ?></td>
</tr>			
 </table>

			