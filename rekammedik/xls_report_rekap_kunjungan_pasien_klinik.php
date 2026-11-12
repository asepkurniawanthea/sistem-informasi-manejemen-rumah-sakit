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

$qry_kunjungan = 'SELECT m_unit.UNIT_ID,m_unit.NAMA_UNIT,m_pegawai.NAMA_PEGAWAI,
				COUNT(CASE WHEN m_pasien.JNS_KELAMIN = "L" THEN t_irja.IRJA_ID END) AS JNS_KEL_LK,
				COUNT(CASE WHEN m_pasien.JNS_KELAMIN = "P" THEN t_irja.IRJA_ID END) AS JNS_KEL_PR,
				COUNT(CASE WHEN t_irja.ASAL_PASIEN_ID = "1" THEN t_irja.IRJA_ID END) AS ASAL_PASIEN_DS,
				COUNT(CASE WHEN t_irja.ASAL_PASIEN_ID = "2" THEN t_irja.IRJA_ID END) AS ASAL_PASIEN_PK,
				COUNT(CASE WHEN t_irja.ASAL_PASIEN_ID = "3" THEN t_irja.IRJA_ID END) AS ASAL_PASIEN_RS,
				COUNT(CASE WHEN t_irja.ASAL_PASIEN_ID = "4" THEN t_irja.IRJA_ID END) AS ASAL_PASIEN_LN,
				COUNT(CASE WHEN t_irja.ST_BARU = "1" THEN t_irja.IRJA_ID END) AS KUNJ_BARU,
				COUNT(CASE WHEN t_irja.ST_BARU <> "1" THEN t_irja.IRJA_ID END) AS KUNJ_LAMA,
				COUNT(CASE WHEN t_irja.ST_RUJUKAN = "1" THEN t_irja.IRJA_ID END) AS MINTA_RUJUKAN,
				COUNT(t_irja.IRJA_ID) AS TOTAL
				FROM m_unit
				LEFT JOIN t_irja ON (m_unit.UNIT_ID = t_irja.UNIT_ID
				AND t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
				AND t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL)
				LEFT JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR) 
				LEFT JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE m_unit.IRJA IS NOT NULL
				GROUP BY m_unit.UNIT_ID,m_unit.NAMA_UNIT,m_pegawai.NAMA_PEGAWAI
				ORDER BY m_unit.NAMA_UNIT';
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());	
?>
<table border="1">
<tr>
        <th colspan="13">Report Kunjungan Rawat Jalan Dr <?php echo $tgl_1; ?> Sd <?php echo $tgl_2; ?></th>
	</tr>
  <tr>
     <th rowspan="2" width="5">No</th>
    <th rowspan="2">Poliklinik</th>
	<th rowspan="2">Dokter Penanggungjawab</th>
    <th colspan="2" scope="col">Jenis Kelamin</th>
    <th colspan="4" scope="col">Asal Pasien</th>
    <th colspan="2" scope="col">Kunjungan</th>
    <th rowspan="2" scope="col">Rujukan</th>
    <th rowspan="2" scope="col">Total</th>
  </tr>
  <tr>
    <th >Laki-laki</th>
    <th >Perempuan</th>
    <th>Datang Sendiri </th>
    <th>Puskesmas</th>
    <th>Rumah Sakit </th>
    <th>Lainnya</th>
    <th>Pasien Baru</th>
    <th>Pasien Lama</th>
  </tr>
<?php $no = 1; 
$total = 0;
while($dat_kunjungan = mysql_fetch_array($get_kunjungan)){ ?>  
  <tr>
    <td scope="row" align="center"><?php echo $no; ?></td>
    <td><?php echo $dat_kunjungan['NAMA_UNIT']; ?></td>
	<td><?php echo $dat_kunjungan['NAMA_PEGAWAI']; ?></td>
    <td align="right"><?php echo currFormat($dat_kunjungan['JNS_KEL_LK']); ?></td>
    <td align="right"><?php echo currFormat($dat_kunjungan['JNS_KEL_PR']); ?></td>
    <td align="right"><?php echo currFormat($dat_kunjungan['ASAL_PASIEN_DS']); ?></td>
    <td align="right"><?php echo currFormat($dat_kunjungan['ASAL_PASIEN_PK']); ?></td>
    <td align="right"><?php echo currFormat($dat_kunjungan['ASAL_PASIEN_RS']); ?></td>
    <td align="right"><?php echo currFormat($dat_kunjungan['ASAL_PASIEN_LN']); ?></td>
    <td align="right"><?php echo currFormat($dat_kunjungan['KUNJ_BARU']); ?></td>
    <td align="right"><?php echo currFormat($dat_kunjungan['KUNJ_LAMA']); ?></td>
    <td align="right"><?php echo currFormat($dat_kunjungan['MINTA_RUJUKAN']); ?></td>
    <td align="right"><?php echo currFormat($dat_kunjungan['TOTAL']); 
	$total = $total + $dat_kunjungan['TOTAL'];?></td>
  </tr>
 <?php $no++; } ?> 
 <tr>
	<td colspan="12" align="right">Total :&nbsp;&nbsp;</td>
	<td align="right"><?php echo currFormat($total); ?></td>
  </tr>
</table>