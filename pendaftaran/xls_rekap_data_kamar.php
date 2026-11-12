<?php
include('./config/config.php');
include('./shared/connect_db.php');
include('./shared/function.php');

$qry_kunjungan = 'SELECT m_ruang.RUANG_ID,m_ruang.NAMA_RUANG,m_ruang.KELAS_RAWAT,
							m_ruang.JNS_PERAWATAN,m_ruang.DESKRIPSI,m_ruang.JML_TMP_TIDUR,
							SUM(t_ruang.JML_TMP_TIDUR_LK) AS JML_TMP_TIDUR_LK,
							SUM(t_ruang.JML_TMP_TIDUR_PR) AS JML_TMP_TIDUR_PR,
							SUM(t_ruang.JML_TMP_TIDUR_LKPR) AS JML_TMP_TIDUR_LKPR,
							SUM(t_ruang.JML_TMP_TIDUR_ISI_LK) AS JML_TMP_TIDUR_ISI_LK,
							SUM(t_ruang.JML_TMP_TIDUR_ISI_PR) AS JML_TMP_TIDUR_ISI_PR,
							SUM(t_ruang.JML_TMP_TIDUR_BOOKING_LK) AS JML_TMP_TIDUR_BOOKING_LK,
							SUM(t_ruang.JML_TMP_TIDUR_BOOKING_PR) AS JML_TMP_TIDUR_BOOKING_PR
							FROM m_ruang
							LEFT JOIN (
								SELECT m_ruang_detail.RUANG_ID,
								CASE WHEN m_ruang_detail.LK_PR = "LK" THEN 1 ELSE 0 END AS JML_TMP_TIDUR_LK,
								CASE WHEN m_ruang_detail.LK_PR = "PR" THEN 1 ELSE 0 END AS JML_TMP_TIDUR_PR,
								CASE WHEN m_ruang_detail.LK_PR = "LKPR" THEN 1 ELSE 0 END AS JML_TMP_TIDUR_LKPR,
								0 AS JML_TMP_TIDUR_ISI_LK,
								0 AS JML_TMP_TIDUR_ISI_PR,
								0 AS JML_TMP_TIDUR_BOOKING_LK,
								0 AS JML_TMP_TIDUR_BOOKING_PR
								FROM m_ruang_detail								
								UNION ALL
								SELECT t_irna.RUANG_ID,
								0 AS JML_TMP_TIDUR_LK,
								0 AS JML_TMP_TIDUR_PR,
								0 AS JML_TMP_TIDUR_LKPR,
								CASE WHEN m_pasien.JNS_KELAMIN = "L" AND t_irna.PASIEN_MASUK IS NOT NULL THEN 1 ELSE 0 END AS JML_TMP_TIDUR_ISI_LK,
								CASE WHEN m_pasien.JNS_KELAMIN = "P" AND t_irna.PASIEN_MASUK IS NOT NULL THEN 1 ELSE 0 END AS JML_TMP_TIDUR_ISI_PR,
								CASE WHEN m_pasien.JNS_KELAMIN = "L" AND t_irna.PASIEN_MASUK IS NULL THEN 1 ELSE 0 END AS JML_TMP_TIDUR_BOOKING_LK,
								CASE WHEN m_pasien.JNS_KELAMIN = "P" AND t_irna.PASIEN_MASUK IS NULL THEN 1 ELSE 0 END AS JML_TMP_TIDUR_BOOKING_PR
								FROM t_irna
								INNER JOIN m_pasien
								ON (t_irna.NOMR = m_pasien.NOMR)
								WHERE t_irna.ST_PULANG IS NULL 
								AND t_irna.ST_BATAL IS NULL 
								AND t_irna.NO_PENDAFTARAN IS NOT NULL
							) t_ruang
							ON (m_ruang.RUANG_ID = t_ruang.RUANG_ID)
							WHERE m_ruang.ST_AKTIF = "1"
							GROUP BY m_ruang.RUANG_ID
							ORDER BY m_ruang.NAMA_RUANG,m_ruang.KELAS_RAWAT';
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());	
?>
<table border="1" >
	<tr>
		<th colspan="16">Data Kamar</th>
	</tr>
	 <tr>
            <th width="10" rowspan="2">No</th>
			<th rowspan="2">Nama Ruang</th>
			<th rowspan="2">Kelas</th>
			<th rowspan="2">Perawatan</th>
			<th rowspan="2">Deskripsi</th>
			<th colspan="4">Tempat Tidur</th>
			<th colspan="3">Terisi</th>
			<th colspan="3">Booking</th>
			<th rowspan="2">Ketersediaan</th>
		</tr>
        <tr>
		  <th>Jumlah</th>		
          <th>Lk</th>
          <th>Pr</th>
          <th>Lk/Pr</th>
		  <th>Jumlah</th>		
          <th>Lk</th>
          <th>Pr</th>
		  <th>Jumlah</th>
		  <th>Lk</th>
          <th>Pr</th>
		  <!--<th>Jumlah</th>
		  <th>Lk</th>
          <th>Pr</th>-->
        </tr>
 <?php $no = 1; 
$total_tmp_tidur = 0;
$total_tmp_tidur_isi = 0;
$total_tmp_tidur_booking = 0;
$total_tmp_tidur_tersedia = 0;
while($dat = mysql_fetch_array($get_kunjungan)){ 

		$total_tmp_tidur = $total_tmp_tidur + $dat['JML_TMP_TIDUR']; 
		$total_tmp_tidur_isi = $total_tmp_tidur_isi + $dat['JML_TMP_TIDUR_ISI_LK'] + $dat['JML_TMP_TIDUR_ISI_PR']; 
		$total_tmp_tidur_booking = $total_tmp_tidur_booking + $dat['JML_TMP_TIDUR_BOOKING_LK'] + $dat['JML_TMP_TIDUR_BOOKING_PR']; 
		$tersedia = $dat['JML_TMP_TIDUR'] - ($dat['JML_TMP_TIDUR_ISI_LK'] + $dat['JML_TMP_TIDUR_ISI_PR'] + $dat['JML_TMP_TIDUR_BOOKING_LK'] + $dat['JML_TMP_TIDUR_BOOKING_PR']);
		$total_tmp_tidur_tersedia = $total_tmp_tidur_tersedia + $tersedia;
		
		$jumlah_kamar_lk = $dat['JML_TMP_TIDUR_LK'];
		$jumlah_kamar_pr = $dat['JML_TMP_TIDUR_PR'];
		$jumlah_kamar_lkpr = $dat['JML_TMP_TIDUR_LKPR'];
								
		$jumlah_pasien_lk = $dat['JML_TMP_TIDUR_ISI_LK'];
		$jumlah_pasien_pr = $dat['JML_TMP_TIDUR_ISI_PR'];
		?>
  <tr>
    <td align="center"><?php echo $no; ?></td>
	<?php
            echo '<td>' . $dat['NAMA_RUANG'] . '</td>';
            echo '<td align="center">' . $dat['KELAS_RAWAT'] . '</td>';
			echo '<td>' . $dat['JNS_PERAWATAN'] . '</td>';
			echo '<td>' . $dat['DESKRIPSI'] . '</td>';
			echo '<td align="right">' . $dat['JML_TMP_TIDUR'] . '</td>';
			echo '<td align="right">' . $dat['JML_TMP_TIDUR_LK'] . '</td>';
			echo '<td align="right">' . $dat['JML_TMP_TIDUR_PR'] . '</td>';
			echo '<td align="right">' . $dat['JML_TMP_TIDUR_LKPR'] . '</td>';
			echo '<td align="right">' . ($dat['JML_TMP_TIDUR_ISI_LK'] + $dat['JML_TMP_TIDUR_ISI_PR']) . '</td>';
			echo '<td align="right">' . $dat['JML_TMP_TIDUR_ISI_LK'] . '</td>';
			echo '<td align="right">' . $dat['JML_TMP_TIDUR_ISI_PR'] . '</td>';
			echo '<td align="right">' . ($dat['JML_TMP_TIDUR_BOOKING_LK'] + $dat['JML_TMP_TIDUR_BOOKING_PR']) . '</td>';
			echo '<td align="right">' . $dat['JML_TMP_TIDUR_BOOKING_LK'] . '</td>';
			echo '<td align="right">' . $dat['JML_TMP_TIDUR_BOOKING_PR'] . '</td>';
			echo '<td align="right">' . (($tersedia > 0) ? $tersedia : 0) . '</td>';
			//echo '<td align="right">' . (($tersedia_kamar_lk > 0) ? $tersedia_kamar_lk : 0) . '</td>';
			//echo '<td align="right">' . (($tersedia_kamar_pr > 0) ? $tersedia_kamar_pr : 0) . '</td>';
			echo '</tr>';
	?>		
  </tr>
 <?php $no++; } ?> 
  <tr>
	<td colspan="5" align="center">Total</td>
	<td colspan="4" align="center"><?php echo currFormat($total_tmp_tidur); ?></td>
	<td colspan="3" align="center"><?php echo currFormat($total_tmp_tidur_isi); ?></td>
	<td colspan="3" align="center"><?php echo currFormat($total_tmp_tidur_booking); ?></td>
	<td align="center"><?php echo currFormat($total_tmp_tidur_tersedia); ?></td>
  </tr>
</table>

<?php
$qry_kunjungan = 'SELECT m_ruang.RUANG_ID,m_ruang.NAMA_RUANG,m_ruang.KELAS_RAWAT,
				t_irna.IRNA_ID,DATE_FORMAT(t_irna.PASIEN_MASUK,"%d-%m-%Y") AS PASIEN_MASUK,
				m_pasien.NOMR,m_pasien.NAMA_PASIEN
				FROM m_ruang
				INNER JOIN t_irna
				ON (m_ruang.RUANG_ID = t_irna.RUANG_ID)
				INNER JOIN m_pasien
				ON (t_irna.NOMR = m_pasien.NOMR)
				WHERE m_ruang.ST_AKTIF = "1" 
				AND t_irna.ST_PULANG IS NULL 
				AND t_irna.ST_BATAL IS NULL 
				AND t_irna.NO_PENDAFTARAN IS NOT NULL
				AND t_irna.PASIEN_MASUK IS NOT NULL
				ORDER BY m_ruang.NAMA_RUANG,m_ruang.KELAS_RAWAT,
				t_irna.PASIEN_MASUK';
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());	
?>
<table border="1" >
	<tr>
		<th colspan="6">Data Pasien Dirawat</th>
	</tr>
	 <tr>
            <th>No</th>
			<th>Nama Ruang</th>
			<th>Kelas</th>
			<th>Masuk Dirawat</th>
			<th>Nomor MR</th>
			<th>Nama Pasien</th>
	
	</tr>
 <?php $no = 1; 
while($dat = mysql_fetch_array($get_kunjungan)){ ?>
  <tr>
    <td align="center"><?php echo $no; ?></td>
	<?php
            echo '<td>' . $dat['NAMA_RUANG'] . '</td>';
            echo '<td align="center">' . $dat['KELAS_RAWAT'] . '</td>';
			echo '<td align="center">' . $dat['PASIEN_MASUK'] . '</td>';
			echo '<td align="center">' . formatNoMR($dat['NOMR']) . '</td>';
			echo '<td>' . $dat['NAMA_PASIEN'] . '</td>';
			echo '</tr>';
	?>		
  </tr>
 <?php $no++; } 
 
$qry_kunjungan = 'SELECT m_ruang.RUANG_ID,m_ruang.NAMA_RUANG,m_ruang.KELAS_RAWAT,
				t_irna.IRNA_ID,DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d-%m-%Y") AS TANGGAL_DAFTAR,
				m_pasien.NOMR,m_pasien.NAMA_PASIEN
				FROM m_ruang
				INNER JOIN t_irna
				ON (m_ruang.RUANG_ID = t_irna.RUANG_ID)
				INNER JOIN m_pasien
				ON (t_irna.NOMR = m_pasien.NOMR)
				WHERE m_ruang.ST_AKTIF = "1" 
				AND t_irna.ST_PULANG IS NULL 
				AND t_irna.ST_BATAL IS NULL 
				AND t_irna.NO_PENDAFTARAN IS NOT NULL
				AND t_irna.PASIEN_MASUK IS NULL
				ORDER BY m_ruang.NAMA_RUANG,m_ruang.KELAS_RAWAT,
				t_irna.PASIEN_MASUK';
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());	
?>
<table border="1" >
	<tr>
		<th colspan="6">Data Pasien Booking</th>
	</tr>
	 <tr>
            <th>No</th>
			<th>Nama Ruang</th>
			<th>Kelas</th>
			<th>Tanggal Booking</th>
			<th>Nomor MR</th>
			<th>Nama Pasien</th>
	
	</tr>
 <?php $no = 1; 
while($dat = mysql_fetch_array($get_kunjungan)){ ?>
  <tr>
    <td align="center"><?php echo $no; ?></td>
	<?php
            echo '<td>' . $dat['NAMA_RUANG'] . '</td>';
            echo '<td align="center">' . $dat['KELAS_RAWAT'] . '</td>';
			echo '<td align="center">' . $dat['TANGGAL_DAFTAR'] . '</td>';
			echo '<td align="center">' . formatNoMR($dat['NOMR']) . '</td>';
			echo '<td>' . $dat['NAMA_PASIEN'] . '</td>';
			echo '</tr>';
	?>		
  </tr>
 <?php $no++; } ?>