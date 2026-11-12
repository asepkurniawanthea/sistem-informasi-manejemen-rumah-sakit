<?php
include('./config/config.php');
include('./shared/connect_db.php');
include('./shared/function.php');

$tgl_1 = $_POST['tgl_1'];
$tgl_2 = $_POST['tgl_2'];
$nomr = $_POST['nomr'];
$ruang_id = $_POST['ruang_id'];	
$jaminan_id = $_POST['jaminan_id'];	
$nosep = $_POST['nosep'];	

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}	

if($tgl_1 == '') $tgl_1 = date('d-m-Y');
if($tgl_2 == '') $tgl_2 = date('d-m-Y');
?>
<table border="1">
	<tr>
        <th colspan="14">Report Klaim Rawat Inap Tanggal <?php echo $tgl_1; ?> S/d <?php echo $tgl_2; ?></th>
   </tr>
   <tr>
        <th>No</th>
        <th>Tanggal<br />Masuk</th>
		<th>Tanggal<br />Keluar</th>
        <th>Nomor<br />MR</th>
		<th>Nomor SEP</th>
        <th>Nama Pasien</th>
        <th>Ruang</th>
		<th>Dokter</th>
        <th>Pembayaran</th>
		<th>Diagnosa</th>
		<th>Tarif RS</th>
		<th>Tarif Inacbg</th>
		<th>Selisih</th>
		<th>Klaim<br />Final</th>
    </tr>
<?php $no = 1; 
$qry_klaim = 'SELECT CASE WHEN t_irja.PASIEN_MASUK IS NOT NULL 
		THEN DATE_FORMAT(t_irja.PASIEN_MASUK,"%Y-%m-%d") 
		ELSE DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y-%m-%d") END AS TANGGAL_MASUK,
	DATE_FORMAT(t_irna.PASIEN_KELUAR,"%Y-%m-%d") AS TANGGAL_KELUAR,
	CASE WHEN t_irna.JENIS_BAYAR_ID = 12 THEN t_irna.NO_SEP ELSE t_irna.NO_SJP END AS NO_SEP,
	t_irna.NOMR,m_pasien.NAMA_PASIEN,CONCAT(m_ruang.NAMA_RUANG,"-",m_ruang.KELAS_RAWAT) AS NAMA_RUANG,
	m_pegawai.NAMA_PEGAWAI,m_jaminan.NAMA_JAMINAN,t_cbg_claim.DIAGNOSA,t_cbg_claim.TARIF_RS,
	t_cbg_claim.TARIF_CBG_KELAS_1,t_cbg_claim.TARIF_CBG_KELAS_2,t_cbg_claim.TARIF_CBG_KELAS_3,
	t_cbg_claim.KLAIM_FINAL,t_irna.NO_PESERTA,t_irna.JENIS_BAYAR_ID,t_irna.KELAS_JAMINAN,
	t_irna.IRNA_ID
	FROM t_irna 
	INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
	INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
	INNER JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
	INNER JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
	INNER JOIN t_irja ON (t_irna.IRNA_ID = t_irja.IRJA_ID)
	LEFT JOIN t_cbg_claim ON (t_irna.IRNA_ID = t_cbg_claim.RAWAT_ID AND t_cbg_claim.JNS_RAWAT = 1)
	WHERE t_irna.NO_PENDAFTARAN IS NOT NULL AND t_irna.ST_BATAL IS NULL 
	AND STR_TO_DATE(DATE_FORMAT(t_irna.PASIEN_KELUAR,"%Y-%m-%d"),"%Y-%m-%d") >= ' . $tgl_filter_1 . ' 
	AND STR_TO_DATE(DATE_FORMAT(t_irna.PASIEN_KELUAR,"%Y-%m-%d"),"%Y-%m-%d") <= ' . $tgl_filter_2 . '';
if(!empty($nomr)){
	$nomr = str_replace(' ', '%', $nomr);
	$qry_klaim = $qry_klaim . ' AND CONCAT(m_pasien.NOMR,m_pasien.NAMA_PASIEN) LIKE "%' . $nomr . '%"';
}	
if (!empty($ruang_id)) {
    $qry_klaim = $qry_klaim . ' AND m_ruang.NAMA_RUANG LIKE "%' . $ruang_id . '%"';
}
if (!empty($jaminan_id)) {
    $qry_klaim = $qry_klaim . ' AND t_irna.JENIS_BAYAR_ID = "' . $jaminan_id . '"';
}
if (!empty($nosep)) {
    $qry_klaim = $qry_klaim . ' AND t_irna.NO_SEP = "' . $nosep . '"';
}
$qry_klaim = $qry_klaim . ' ORDER BY m_pasien.NAMA_PASIEN,m_pasien.NOMR';
$get_klaim = mysql_query($qry_klaim) or die(mysql_error());	
while($dat_klaim = mysql_fetch_array($get_klaim)){ ?>  
  <tr>
    <td align="center"><?php echo $no; ?></td>
	<td align="center"><?php echo changeDateFormat($dat_klaim['TANGGAL_MASUK']); ?></td>
			<td align="center"><?php echo changeDateFormat($dat_klaim['TANGGAL_KELUAR']); ?></td>
            <td align="center"><?php echo formatNoMR($dat_klaim['NOMR']); ?></td>
			<td><?php echo $dat_klaim['NO_SEP']; ?></td>
            <td><?php echo $dat_klaim['NAMA_PASIEN']; ?></td>
            <td><?php echo $dat_klaim['NAMA_RUANG']; ?></td>
            <td><?php echo $dat_klaim['NAMA_PEGAWAI']; ?></td>
            <td><?php echo $dat_klaim['NAMA_JAMINAN']; ?></td>
			<td><?php echo $dat_klaim['DIAGNOSA']; ?></td>
			<?php $tarif_cbg = 0;
			if($dat_klaim['KELAS_JAMINAN'] == '3') $tarif_cbg = $dat_klaim['TARIF_CBG_KELAS_3'];
			if($dat_klaim['KELAS_JAMINAN'] == '2') $tarif_cbg = $dat_klaim['TARIF_CBG_KELAS_2'];
			if($dat_klaim['KELAS_JAMINAN'] == '1') $tarif_cbg = $dat_klaim['TARIF_CBG_KELAS_1'];	?>
			<td align="right"><?php echo currFormat($dat_klaim['TARIF_RS']); ?></td>
			<td align="right"><?php echo currFormat($tarif_cbg); ?></td>
			<td align="right"><?php echo currFormat($tarif_cbg - $dat_klaim['TARIF_RS']); ?></td>
            <td align="center"><?php if($dat_klaim['KLAIM_FINAL'] == '1') echo '&radic;'; ?></td>
	</tr>
<?php $no++;
} ?>	
</table>
