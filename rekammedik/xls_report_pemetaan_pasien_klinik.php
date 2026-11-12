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

$qry_kunjungan = 'SELECT t_irja.NOMR,t_irja.TANGGAL_DAFTAR,
				m_unit.NAMA_UNIT,
				m_pasien.ALAMAT,m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,m_propinsi.NAMA_PROPINSI,
				m_kota.NAMA_KOTA,m_kecamatan.NAMA_KECAMATAN,m_kelurahan.NAMA_KELURAHAN,
				m_jaminan.NAMA_JAMINAN,m_pasien.TMP_LAHIR,m_pasien.TGL_LAHIR,
				m_pasien.JNS_KELAMIN,m_pasien.NAMA_PASIEN
				FROM t_irja
				  INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				  INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
				  INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				  LEFT JOIN m_propinsi ON (m_pasien.PROPINSI_ID = m_propinsi.PROPINSI_ID)
				  LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
				  LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				  LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				WHERE t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
				AND t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL';	
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());	
?>
<table border="1" >
<tr>
	<th colspan="14" >Report Pemetaan Pasien Rawat Jalan Dr <?php echo $tgl_1; ?> Sd <?php echo $tgl_2; ?></th>
</tr>
  <tr>
    <th width="5">No</th>
    <th>Tanggal</th>
	<th>Poliklinik</th>
	<th>NOMR</th>
	<th>Nama Pasien</th>
	<th>Tmp Lahir</th>
	<th>Tgl Lahir</th>
	<th>Jns Kel</th>
	<th>Propinsi</th>
	<th>Kota</th>
	<th>Kecamatan</th>
	<th>Kelurahan</th>
	<th>Alamat Rt/Rw</th>
	<th>Jaminan</th>
  </tr>
<?php $no = 1; 
while($dat_kunjungan = mysql_fetch_array($get_kunjungan)){ ?>  
  <tr>
    <td scope="row" align="center"><?php echo $no; ?></td>
    <td><?php echo $dat_kunjungan['TANGGAL_DAFTAR']; ?></td>
	<td><?php echo $dat_kunjungan['NAMA_UNIT']; ?></td>
    <td><?php echo formatNomr($dat_kunjungan['NOMR']); ?></td>
	<td><?php echo $dat_kunjungan['NAMA_PASIEN']; ?></td>
	<td><?php echo $dat_kunjungan['TMP_LAHIR']; ?></td>
	<td><?php echo $dat_kunjungan['TGL_LAHIR']; ?></td>
	<td><?php echo $dat_kunjungan['JNS_KELAMIN']; ?></td>
	<td><?php echo $dat_kunjungan['NAMA_PROPINSI']; ?></td>
	<td><?php echo $dat_kunjungan['NAMA_KOTA']; ?></td>
	<td><?php echo $dat_kunjungan['NAMA_KECAMATAN']; ?></td>
	<td><?php echo $dat_kunjungan['NAMA_KELURAHAN']; ?></td>
	<td><?php echo $dat_kunjungan['ALAMAT'] . ' ' . $dat_kunjungan['ALAMAT_RT'] . '/' . $dat_kunjungan['ALAMAT_RW']; ?></td>
	<td><?php echo $dat_kunjungan['NAMA_JAMINAN']; ?></td>
  </tr>
 <?php $no++; } ?> 
</table>