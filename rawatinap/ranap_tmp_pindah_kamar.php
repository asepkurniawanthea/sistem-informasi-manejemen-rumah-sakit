<?php
$qry_kamar = 'SELECT DATE_FORMAT(t_log.TANGGAL_KELUAR,"%d-%m-%Y %H:%i:%s") AS TANGGAL_KELUAR,
			DATE_FORMAT(t_log.TANGGAL_MASUK,"%d-%m-%Y %H:%i:%s") AS TANGGAL_MASUK,
			t_log.KETERANGAN_PINDAH,t_log.NAMA_RUANG,t_log.KELAS_RAWAT,
			t_log.NAMA_PEGAWAI,t_log.NAMA_PEGAWAI AS PERAWAT_1, t_log.NAMA_PEGAWAI AS PERAWAT_2,
			t_log.NAMA_PEGAWAI AS PERAWAT_3,DATEDIFF(t_log.TANGGAL_KELUAR,t_log.TANGGAL_MASUK) AS LAMA_DIRAWAT,
			t_log.IRNA_LOG_ID,t_log.ADA_LOG_BARU
			FROM (
				SELECT t_irna_log.IRNA_LOG_ID,t_irna_log.TANGGAL_KELUAR,t_irna_log.KETERANGAN_PINDAH,
				m_ruang.NAMA_RUANG,m_ruang.KELAS_RAWAT,m_pegawai.NAMA_PEGAWAI,
				m_pegawai2.NAMA_PEGAWAI AS PERAWAT_1, m_pegawai3.NAMA_PEGAWAI AS PERAWAT_2,
				m_pegawai4.NAMA_PEGAWAI AS PERAWAT_3,
				(SELECT t.TANGGAL_MASUK FROM t_irna_log t 
					WHERE t.IRNA_ID = t_irna_log.IRNA_ID
					AND t.RUANG_ID_BARU = t_irna_log.RUANG_ID_ASAL
					AND t.JNS_UPDATE = "R"
					AND t.IRNA_LOG_ID < t_irna_log.IRNA_LOG_ID
					ORDER BY t.TANGGAL_MASUK DESC LIMIT 1
				) AS TANGGAL_MASUK,
				(SELECT t.IRNA_LOG_ID FROM t_irna_log t 
					WHERE t.IRNA_ID = t_irna_log.IRNA_ID
					AND t.JNS_UPDATE = "R"
					AND t.IRNA_LOG_ID > t_irna_log.IRNA_LOG_ID
					AND t.TANGGAL_MASUK IS NOT NULL 
					ORDER BY t.IRNA_LOG_ID LIMIT 1
				) AS ADA_LOG_BARU
				 FROM t_irna_log
				 LEFT JOIN m_ruang ON (t_irna_log.RUANG_ID_ASAL = m_ruang.RUANG_ID)
				 LEFT JOIN m_pegawai ON (t_irna_log.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				 LEFT JOIN m_pegawai m_pegawai2 ON (t_irna_log.PEGAWAI_RAWAT_ID = m_pegawai2.PEGAWAI_ID)
				 LEFT JOIN m_pegawai m_pegawai3 ON (t_irna_log.PEGAWAI_RAWAT_ID_2 = m_pegawai3.PEGAWAI_ID)
				 LEFT JOIN m_pegawai m_pegawai4 ON (t_irna_log.PEGAWAI_RAWAT_ID_3 = m_pegawai4.PEGAWAI_ID)
				 WHERE t_irna_log.IRNA_ID = "' . $irna_id . '"
				 AND t_irna_log.JNS_UPDATE = "R"
				 AND t_irna_log.RUANG_ID_ASAL IS NOT NULL
				 AND t_irna_log.RUANG_ID_BARU IS NOT NULL
				 AND t_irna_log.TANGGAL_KELUAR IS NOT NULL
			) t_log	 
			ORDER BY t_log.TANGGAL_KELUAR';
$get_kamar = mysql_query($qry_kamar) or die(mysql_error());
?>
<tr>
    <th width="30">No</th>
	<th width="150">Tanggal Masuk</th>
	<th width="150">Tanggal Keluar</th>
	<th>Ruang Rawat/ Kelas</th>
	<th>Dokter Penanggungjawab</th>
	<th>Dokter Yang Merawat</th>
	<th>Keterangan</th>
	<th width="100">Lama Dirawat<br />(Hari)</th>
	<th width="100">Option</th>
</tr>
<?php
$i = 1;
$cn = mysql_num_rows($get_kamar);
while ($dat_kamar = mysql_fetch_array($get_kamar)) {
	$perawat = '';
	if(!empty($dat_kamar['PERAWAT_1'])) $perawat = $dat_kamar['PERAWAT_1'];
 	if(!empty($dat_kamar['PERAWAT_2'])) $perawat = $perawat . ', ' . $dat_kamar['PERAWAT_2'];
	if(!empty($dat_kamar['PERAWAT_3'])) $perawat = $perawat . ', ' . $dat_kamar['PERAWAT_3'];
    ?>
    <tr>
        <td align="center"><?php echo $i; ?></td>
		<td><?php echo $dat_kamar['TANGGAL_MASUK']; ?></td>
		<td><?php echo $dat_kamar['TANGGAL_KELUAR']; ?></td>
		<td><?php echo $dat_kamar['NAMA_RUANG'] . '/' . $dat_kamar['KELAS_RAWAT']; ?></td>
        <td><?php echo $dat_kamar['NAMA_PEGAWAI']; ?></td>
		<td><?php echo $perawat; ?></td>
		<td><?php echo $dat_kamar['KETERANGAN_PINDAH']; ?></td>
		<td align="center"><?php echo $dat_kamar['LAMA_DIRAWAT']; ?></td>
		<td align="center">
		<?php if($irna_final == ''){ ?>
		<?php if($i == $cn and $dat_kamar['ADA_LOG_BARU'] == ''){ 
		$idlog = $dat_kamar['IRNA_LOG_ID'];
		?>
		<a href="index.php?link=<?php echo $_GET['link']; ?>&smn=pndh&idx=<?php echo $_GET['idx']; ?>&idlog=<?php echo $dat_kamar['IRNA_LOG_ID']; ?>" >ubah</a>
		<?php } ?>
		<?php } ?>
		</td>
    </tr>
<?php    
    $i++;
	}
?>