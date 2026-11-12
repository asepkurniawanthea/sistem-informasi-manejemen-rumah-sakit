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

$qry_kunjungan = 'SELECT m_ruang.RUANG_ID,m_ruang.NAMA_RUANG,m_ruang.KELAS_RAWAT,m_pegawai.NAMA_PEGAWAI,
				COUNT(CASE WHEN m_pasien.JNS_KELAMIN = "L" THEN t_irna.IRNA_ID END) AS JNS_KEL_LK,
				COUNT(CASE WHEN m_pasien.JNS_KELAMIN = "P" THEN t_irna.IRNA_ID END) AS JNS_KEL_PR,
				COUNT(CASE WHEN t_irja.UNIT_ID = "9" THEN t_irna.IRNA_ID END) AS ASAL_PASIEN_IGD,
				COUNT(CASE WHEN t_irja.UNIT_ID <> "9" AND t_irja.UNIT_ID <> "35"  THEN t_irna.IRNA_ID END) AS ASAL_PASIEN_PK,
				COUNT(CASE WHEN t_irja.UNIT_ID = "35" THEN t_irna.IRNA_ID END) AS ASAL_PASIEN_KS,
				COUNT(t_irna.IRNA_ID) AS TOTAL
				FROM m_ruang
				LEFT JOIN t_irna ON (m_ruang.RUANG_ID = t_irna.RUANG_ID
				AND t_irna.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND t_irna.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
				AND t_irna.NO_PENDAFTARAN IS NOT NULL AND t_irna.ST_BATAL IS NULL)
				LEFT JOIN t_irja ON (t_irna.IRNA_ID = t_irja.IRJA_ID)
				LEFT JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				LEFT JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)				
				WHERE m_ruang.ST_AKTIF = "1"
				GROUP BY m_ruang.RUANG_ID,m_pegawai.NAMA_PEGAWAI 
				ORDER BY m_ruang.NAMA_RUANG';
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());	
?>
<table border="1" >
	<tr>
		<th colspan="<?php echo 9; ?>">Laporan Pasien Masuk Rawat Inap Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>
	 <tr>
     <th rowspan="2" width="5">No</th>
    <th rowspan="2">Ruang Rawat</th>
	<th rowspan="2">Dokter Penanggungjawab</th>
    <th colspan="2" scope="col">Jenis Kelamin</th>
    <th colspan="3" scope="col">Asal Pasien</th>
    <th rowspan="2" scope="col">Total</th>
  </tr>
  <tr>
    <th >Laki-laki</th>
    <th >Perempuan</th>
    <th>IGD</th>
    <th>Poliklinik</th>
    <th>Kusta</th>
	</tr>
 <?php $no = 1; 
$total = 0;
while($dat_kunjungan = mysql_fetch_array($get_kunjungan)){ ?>  
  <tr>
    <td scope="row" align="center"><?php echo $no; ?></td>
    <td><?php echo $dat_kunjungan['NAMA_RUANG'] . ' ' . $dat_kunjungan['KELAS_RAWAT']; ?></td>
	<td><?php echo $dat_kunjungan['NAMA_PEGAWAI']; ?></td>
    <td align="right"><?php echo currFormat($dat_kunjungan['JNS_KEL_LK']); ?></td>
    <td align="right"><?php echo currFormat($dat_kunjungan['JNS_KEL_PR']); ?></td>
    <td align="right"><?php echo currFormat($dat_kunjungan['ASAL_PASIEN_IGD']); ?></td>
    <td align="right"><?php echo currFormat($dat_kunjungan['ASAL_PASIEN_PK']); ?></td>
    <td align="right"><?php echo currFormat($dat_kunjungan['ASAL_PASIEN_KS']); ?></td>
    <td align="right"><?php echo currFormat($dat_kunjungan['TOTAL']); 
	$total = $total + $dat_kunjungan['TOTAL']; ?></td>
  </tr>
 <?php $no++; } ?> 
  <tr>
	<td colspan="8" align="right">Total :&nbsp;&nbsp;</td>
	<td align="right"><?php echo currFormat($total); ?></td>
  </tr>
</table>