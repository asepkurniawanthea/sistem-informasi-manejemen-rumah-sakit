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

$pegawai_id = '';
if (isset($_POST['pegawai_id']))
		$pegawai_id = $_POST['pegawai_id'];	

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}	

$qry_kunjungan = 'SELECT t_irja.IRJA_ID, t_irja.TANGGAL_DAFTAR,
	t_irja.NOMR,m_pasien.NAMA_PASIEN,t_irja.KUSTA_MDT_MULAI,
	m_pasien.TGL_LAHIR,
	CASE WHEN (DATEDIFF(t_irja.TANGGAL_DAFTAR, m_pasien.TGL_LAHIR)/365) >= 14 THEN 1 END AS DEWASA,
	CASE WHEN (DATEDIFF(t_irja.TANGGAL_DAFTAR, m_pasien.TGL_LAHIR)/365) < 14 THEN 1 END AS ANAK,
	CASE WHEN t_irja.KUSTA_TYPE = "NR" THEN "1" ELSE "0" END AS NR,	
	CASE WHEN t_irja.KUSTA_TYPE = "TT" THEN "1" ELSE "0" END AS TT,
	CASE WHEN t_irja.KUSTA_TYPE = "BT" THEN "1" ELSE "0" END AS BT,
	CASE WHEN t_irja.KUSTA_TYPE = "BB" THEN "1" ELSE "0" END AS BB,
	CASE WHEN t_irja.KUSTA_TYPE = "BL" THEN "1" ELSE "0" END AS BL,
	CASE WHEN t_irja.KUSTA_TYPE = "LL" THEN "1" ELSE "0" END AS LL,
	CASE WHEN t_irja.KUSTA_TYPE = "OM" THEN "1" ELSE "0" END AS OBSERVASI,
	CASE WHEN t_irja.KUSTA_TYPE = "NM" THEN "1" ELSE "0" END AS NON_MH,
	m_kota.NAMA_KOTA,m_pegawai.NAMA_PEGAWAI,t_irja.KUSTA_RFT_COT,
	CASE WHEN t_irja.POD = "1" THEN "1" END AS POD_TANPA_CACAT,
	CASE WHEN t_irja.POD = "2" THEN "1" END AS POD_CACAT_TK1,
	CASE WHEN t_irja.POD = "3" THEN "1" END AS POD_CACAT_TK2,
	m_propinsi.NAMA_PROPINSI,
	t_irja.KUSTA_PENYAKIT_LAIN,
	t_irja.KUSTA_OPNAME,t_irja.KUSTA_KETERANGAN_OPNAME,
	t_irja.KUSTA_KUNJUNGAN,
	m_pasien_pulang.KET_PASIEN_PULANG,
	(
		SELECT COUNT(xrj.IRJA_ID)
		FROM t_irja xrj
		WHERE xrj.NOMR = t_irja.NOMR 
		AND xrj.UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '"
		AND DATE_FORMAT(xrj.TANGGAL_DAFTAR,"%m%Y") = DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m%Y")
		AND xrj.IRJA_ID < t_irja.IRJA_ID	
	) AS JML_KUNJUNGAN
	FROM t_irja
	INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR) 
	LEFT JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)	
	LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)	
	LEFT JOIN m_propinsi ON (m_pasien.PROPINSI_ID = m_propinsi.PROPINSI_ID)	
	LEFT JOIN m_pasien_pulang ON (t_irja.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID)	
	WHERE t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL 
	AND t_irja.UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '"
	AND t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . '
	AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2;
	
if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_kunjungan = $qry_kunjungan . ' AND CONCAT(m_pasien.NOMR,m_pasien.NAMA_PASIEN) LIKE "%' . $searchkey . '%"';
}	
if (!empty($jaminan_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_irja.JENIS_BAYAR_ID = "' . $jaminan_id . '"';
}
if (!empty($pegawai_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_irja.PEGAWAI_ID = "' . $pegawai_id . '"';
}	
	
$qry_kunjungan = $qry_kunjungan . 'ORDER BY t_irja.IRJA_ID';
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());	
?>
<table width="100%" border="1" >
	<tr>
		<th colspan="28">Laporan Pasien Harian Kusta Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>	
   <tr>
        <th rowspan="2">No</th>
        <th rowspan="2">Tgl Daftar</th>
        <th rowspan="2">Nomor MR</th>
        <th rowspan="2">Nama Pasien</th>
        <th rowspan="2">MDT Mulai</th>
		<th rowspan="2">Tgl Lahir</th>
        <th rowspan="2">DWS</th>
		<th rowspan="2">AN</th>
        <th colspan="6">Tipe Kusta </th>
		<th rowspan="2">Observasi</th>
		<th rowspan="2">Non MH</th>
        <th rowspan="2">Kabupaten</th>
		<th rowspan="2">Propinsi</th>
        <th rowspan="2">Dokter</th>
        <th colspan="3">POD</th>
        <th rowspan="2">RFT (COT) </th>
		<th rowspan="2">Penyakit Lain</th>
		<th rowspan="2">KB</th>
		<th rowspan="2">KK</th>
		<th rowspan="2">OP</th>
		<th rowspan="2">Pulang</th>
    </tr>
    <tr>
	  <th>N</th>		
      <th>TT</th>
      <th>BT</th>
      <th>BB</th>
      <th>BL</th>
      <th>LL</th>
      <th>Tanpa Cacat</th>
      <th>Cacat TK 1</th>
      <th>Cacat TK 2</th>
    </tr>
 <?php $no = 1;
	$jml_dewasa = 0;
	$jml_anak = 0;
	$jml_tipe_kusta_n = 0;
	$jml_tipe_kusta_tt = 0;
	$jml_tipe_kusta_bt = 0;
	$jml_tipe_kusta_bb = 0;
	$jml_tipe_kusta_bl = 0;
	$jml_tipe_kusta_ll = 0;
	$jml_observasi = 0;
	$jml_non_mh = 0;
	$jml_kunj_baru = 0;
	$jml_opname = 0;
	$jml_pod1 = 0;
	$jml_pod2 = 0;
	$jml_pod3 = 0;
	
	$rs = mysql_query($qry_kunjungan) or die(mysql_error());
    while ($data = mysql_fetch_array($rs)) { ?>  
  <tr>
    <td scope="row" align="center"><?php echo $no; ?></td>
    <td align="center"><?php echo changeDateFormat($data['TANGGAL_DAFTAR']); ?></td>
            <td align="center"><?php echo formatNoMR($data['NOMR']); ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td align="center"><?php echo changeDateFormat($data['KUSTA_MDT_MULAI']); ?></td>
			<td align="center"><?php echo changeDateFormat($data['TGL_LAHIR']); ?></td>
            <td align="center"><?php echo $data['DEWASA']; ?></td>
			<td align="center"><?php echo $data['ANAK']; ?></td>
			<td align="center"><?php echo $data['NR']; ?></td>
            <td align="center"><?php echo $data['TT']; ?></td>
			<td align="center"><?php echo $data['BT']; ?></td>
			<td align="center"><?php echo $data['BB']; ?></td>
			<td align="center"><?php echo $data['BL']; ?></td>
			<td align="center"><?php echo $data['LL']; ?></td>
			<td align="center"><?php echo $data['OBSERVASI']; ?></td>
			<td align="center"><?php echo $data['NON_MH']; ?></td>
            <td><?php echo $data['NAMA_KOTA']; ?></td>
			<td><?php echo $data['NAMA_PROPINSI']; ?></td>
			<td><?php echo $data['NAMA_PEGAWAI']; ?></td>
			<td><?php echo $data['POD_TANPA_CACAT']; ?></td>
			<td><?php echo $data['POD_CACAT_TK1']; ?></td>
			<td><?php echo $data['POD_CACAT_TK2']; ?></td>
			<td align="center"><?php echo changeDateFormat($data['KUSTA_RFT_COT']); ?></td>
			<td><?php echo $data['KUSTA_PENYAKIT_LAIN']; ?></td>
			<td align="center"><?php echo $data['KUSTA_KUNJUNGAN']; ?></td>
			<td align="center"><?php echo $data['JML_KUNJUNGAN'] + 1; ?></td>
			<td><?php if($data['KUSTA_OPNAME'] == '1') echo $data['KUSTA_KETERANGAN_OPNAME']; ?></td>
			<td><?php echo $data['KET_PASIEN_PULANG']; ?></td></tr>
 <?php
		$jml_dewasa += $data['DEWASA'];
		$jml_anak += $data['ANAK'];
		$jml_tipe_kusta_n += $data['NR'];
		$jml_tipe_kusta_tt += $data['TT'];
		$jml_tipe_kusta_bt += $data['BT'];
		$jml_tipe_kusta_bb += $data['BB'];
		$jml_tipe_kusta_bl += $data['BL'];
		$jml_tipe_kusta_ll += $data['LL'];
		$jml_observasi += $data['OBSERVASI'];
		$jml_non_mh += $data['NON_MH'];
		$jml_kunj_baru += $data['KUSTA_KUNJUNGAN'];
		$jml_opname += $data['KUSTA_OPNAME'];
		$jml_pod1 += $data['POD_TANPA_CACAT'];
		$jml_pod2 += $data['POD_CACAT_TK1'];
		$jml_pod3 += $data['POD_CACAT_TK2'];
	
	$no++; 
 } ?>
<tr>
    <td colspan="6" align="center">Total</td>
    <td align="center"><?php echo $jml_dewasa; ?></td>
	<td align="center"><?php echo $jml_anak; ?></td>
	<td align="center"><?php echo $jml_tipe_kusta_n; ?></td>
    <td align="center"><?php echo $jml_tipe_kusta_tt; ?></td>
	<td align="center"><?php echo $jml_tipe_kusta_bt; ?></td>
	<td align="center"><?php echo $jml_tipe_kusta_bb; ?></td>
	<td align="center"><?php echo $jml_tipe_kusta_bl; ?></td>
	<td align="center"><?php echo $jml_tipe_kusta_bb; ?></td>
	<td align="center"><?php echo $jml_observasi ?></td>
	<td align="center"><?php echo $jml_non_mh; ?></td>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td align="center"><?php echo $jml_pod1; ?></td>
	<td align="center"><?php echo $jml_pod2; ?></td>
	<td align="center"><?php echo $jml_pod3; ?></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td align="center"><?php echo $jml_kunj_baru; ?></td>
	<td>&nbsp;</td>
	<td align="center"><?php echo $jml_opname; ?></td>
	<td>&nbsp;</td>
</tr> 
</table>