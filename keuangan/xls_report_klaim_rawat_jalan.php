<?php
include('./config/config.php');
include('./shared/connect_db.php');
include('./shared/function.php');

$tgl_1 = $_POST['tgl_1'];
$tgl_2 = $_POST['tgl_2'];
$nomr = $_POST['nomr'];
$unit_id = $_POST['unit_id'];	
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
        <th colspan="14">Report Klaim Rawat Jalan & IGD Tanggal <?php echo $tgl_1; ?> S/d <?php echo $tgl_2; ?></th>
   </tr>
   <tr>
        <th>No</th>
        <th>Tanggal<br />Masuk</th>
		<th>Tanggal<br />Keluar</th>
        <th>Nomor<br />MR</th>
		<th>Nomor SEP</th>
        <th>Nama Pasien</th>
        <th>Klinik</th>
		<th>Dokter</th>
        <th>Pembayaran</th>
		<th>Diagnosa</th>
		<th>Tarif RS</th>
		<th>Tarif Inacbg</th>
		<th>Selisih</th>
		<th>Klaim<br />Final</th>
    </tr>
<?php $no = 1; 
$qry_klaim = 'SELECT DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y-%m-%d") AS TANGGAL_MASUK,
	DATE_FORMAT(t_irja.PASIEN_KELUAR,"%Y-%m-%d") AS TANGGAL_KELUAR,
	CASE WHEN t_irja.JENIS_BAYAR_ID = 12 THEN t_irja.NO_SEP ELSE t_irja.NO_SJP END AS NO_SEP,
	t_irja.NOMR,m_pasien.NAMA_PASIEN,m_unit.NAMA_UNIT,m_pegawai.NAMA_PEGAWAI,m_jaminan.NAMA_JAMINAN,
	t_cbg_claim.DIAGNOSA,t_cbg_claim.TARIF_RS,t_cbg_claim.TARIF_CBG_KELAS_3,t_cbg_claim.KLAIM_FINAL,
	x_irj.IRJA_ID,t_irja.NO_PESERTA,t_irja.JENIS_BAYAR_ID,x_irj.JML_PELAYANAN
	FROM 
		(SELECT MIN(irj.IRJA_ID) AS IRJA_ID, COUNT(irj.IRJA_ID) AS JML_PELAYANAN,
		irj.TANGGAL_DAFTAR,irj.NOMR,irj.JENIS_BAYAR_ID 
		FROM t_irja irj 
		WHERE irj.NO_PENDAFTARAN IS NOT NULL AND irj.ST_BATAL IS NULL 
		AND irj.IRJA_ID NOT IN (SELECT t_irna.IRNA_ID FROM t_irna WHERE t_irna.NOMR = irj.NOMR)
		AND irj.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND irj.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
		GROUP BY irj.TANGGAL_DAFTAR,irj.NOMR,irj.JENIS_BAYAR_ID)
	x_irj
	INNER JOIN t_irja ON (x_irj.IRJA_ID = t_irja.IRJA_ID)
	INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
	INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
	INNER JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
	INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
	LEFT JOIN t_cbg_claim ON (x_irj.IRJA_ID = t_cbg_claim.RAWAT_ID AND t_cbg_claim.JNS_RAWAT = 2)
	WHERE 1';
if(!empty($nomr)){
	$nomr = str_replace(' ', '%', $nomr);
	$qry_klaim = $qry_klaim . ' AND CONCAT(m_pasien.NOMR,m_pasien.NAMA_PASIEN) LIKE "%' . $nomr . '%"';
}	
if (!empty($unit_id)) {
    $qry_klaim = $qry_klaim . ' AND t_irja.UNIT_ID = "' . $unit_id . '"';
}
if (!empty($jaminan_id)) {
    $qry_klaim = $qry_klaim . ' AND t_irja.JENIS_BAYAR_ID = "' . $jaminan_id . '"';
}
if (!empty($nosep)) {
    $qry_klaim = $qry_klaim . ' AND t_irja.NO_SEP = "' . $nosep . '"';
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
            <td><?php echo $dat_klaim['NAMA_UNIT']; 
			if($dat_klaim['JML_PELAYANAN'] > 1) echo ' (' . $dat_klaim['JML_PELAYANAN'] . ')'; ?></td>
            <td><?php echo $dat_klaim['NAMA_PEGAWAI']; ?></td>
            <td><?php echo $dat_klaim['NAMA_JAMINAN']; ?></td>
			<td><?php echo $dat_klaim['DIAGNOSA']; ?></td>
			<td align="right"><?php echo currFormat($dat_klaim['TARIF_RS']); ?></td>
			<td align="right"><?php echo currFormat($dat_klaim['TARIF_CBG_KELAS_3']); ?></td>
			<td align="right"><?php echo currFormat($dat_klaim['TARIF_CBG_KELAS_3'] - $dat_klaim['TARIF_RS']); ?></td>
            <td align="center"><?php if($dat_klaim['KLAIM_FINAL'] == '1') echo '&radic;'; ?></td>
	</tr>
<?php $no++;
} ?>	
</table>
