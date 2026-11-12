<?php
include('./config/config.php');
include('./shared/connect_db.php');
include('./shared/function.php');

$tgl_1 = '';
if (isset($_POST['tgl_1']))
    $tgl_1 = $_POST['tgl_1'];
$tgl_2 = '';

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}

$sql = 'SELECT m_ruang.RUANG_ID,m_ruang.NAMA_RUANG,m_ruang.KELAS_RAWAT,m_ruang.JML_TMP_TIDUR,m_ruang.JNS_PERAWATAN,
				m_ruang.DESKRIPSI,t_tran.JUMLAH_RAWAT
				FROM m_ruang
				LEFT JOIN 
				(
					SELECT t_irna.RUANG_ID,COUNT(t_irna.IRNA_ID) AS JUMLAH_RAWAT
					FROM t_irna
					WHERE t_irna.NO_PENDAFTARAN IS NOT NULL AND t_irna.ST_BATAL IS NULL 
					AND t_irna.TANGGAL_DAFTAR <= ' . $tgl_filter_1 . ' 
					AND (t_irna.PASIEN_KELUAR IS NULL OR STR_TO_DATE(DATE_FORMAT(t_irna.PASIEN_KELUAR,"%d/%m/%Y"),"%d/%m/%Y")
						>= ' . $tgl_filter_1 . ')
					GROUP BY t_irna.RUANG_ID	
				) t_tran
				ON (m_ruang.RUANG_ID = t_tran.RUANG_ID)';
		$sql = $sql . ' ORDER BY m_ruang.NAMA_RUANG';
?>
<table border="1" >
<tr>
	<th colspan="8" >Report Ketersediaan Ruang Rawat Tanggal <?php echo $tgl_1; ?></th>
</tr>
   <tr>
            <th width="10" rowspan="2">No</th>
			<th rowspan="2">Nama Ruang</th>
			<th rowspan="2">Kelas</th>
			<th rowspan="2">Perawatan</th>
			<th rowspan="2">Deskripsi</th>
			<th colspan="3">Tempat Tidur </th>
		</tr>
  <tr>
    <th>Jumlah</th>
    <th>Isi (Jml Pasien Dirawat) </th>
    <th>Kosong</th>
  </tr>
<?php $no = 1; 
$rs = mysql_query($sql) or die(mysql_error());
while($dat = mysql_fetch_array($rs)){ 
			echo '<tr>';
            echo '<td align="center">' . $no . '</td>';
            echo '<td>' . $dat['NAMA_RUANG'] . '</td>';
            echo '<td align="center">' . $dat['KELAS_RAWAT'] . '</td>';
			echo '<td>' . $dat['JNS_PERAWATAN'] . '</td>';
			echo '<td>' . $dat['DESKRIPSI'] . '</td>';
			echo '<td align="right">' . $dat['JML_TMP_TIDUR'] . '</td>';
			echo '<td align="right">' . $dat['JUMLAH_RAWAT'] . '</td>';
			$kosong = $dat['JML_TMP_TIDUR'] - $dat['JUMLAH_RAWAT'];
			echo '<td align="right">' . $kosong . '</td>';
 $no++; } ?> 
</table>