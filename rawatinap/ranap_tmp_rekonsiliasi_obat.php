<?php
$qry_rekonsiliasi_obat = 'SELECT t_irna_rekonsiliasi_obat.REKONSILIASI_ID,t_irna_rekonsiliasi_obat.NAMA_OBAT,
						t_irna_rekonsiliasi_obat.DOSIS,t_irna_rekonsiliasi_obat.FREKUENSI,t_irna_rekonsiliasi_obat.RUTE_PEMBERIAN,
						t_irna_rekonsiliasi_obat.TGL_MULAI,t_irna_rekonsiliasi_obat.TGL_STOP,
						t_irna_rekonsiliasi_obat.DILANJUTKAN_SELAMA_PERAWATAN,t_irna_rekonsiliasi_obat.DILANJUTKAN_SAAT_PULANG
						FROM t_irna_rekonsiliasi_obat
						WHERE t_irna_rekonsiliasi_obat.IRNA_ID = "' . $_GET['idx'] . '"';
$get_rekonsiliasi_obat = mysql_query($qry_rekonsiliasi_obat);
?>
<tr>
    <th width="40" rowspan="2">No</th>
    <th rowspan="2">Daftar Nama Obat</th>
	<th rowspan="2">Dosis (mg, ml,mcrogram,<br />gram, unit)</th>
	<th rowspan="2">Frekuensi</th>
	<th rowspan="2">Rute Pemberian</th>
	<th colspan="2">Tanggal</th>
	<th rowspan="2">Obat Dilanjutkan<br />Selama Perawatan </th>
	<th rowspan="2">Obat Dilanjutkan<br />Saat Pasien Pulang </th>
	<th width="100" rowspan="2">Option</th>
</tr>
<tr>
  <th>Mulai</th>
  <th>Stop</th>
</tr>
<?php
$i = 1;
while ($dat_rekonsiliasi_obat = mysql_fetch_array($get_rekonsiliasi_obat)) {
    ?>
    <tr>
        <td align="center"><?php echo $i; ?></td>
        <td><?php echo $dat_rekonsiliasi_obat['NAMA_OBAT']; ?></td>
		<td><?php echo $dat_rekonsiliasi_obat['DOSIS']; ?></td>
		<td><?php echo $dat_rekonsiliasi_obat['FREKUENSI']; ?></td>
		<td><?php echo $dat_rekonsiliasi_obat['RUTE_PEMBERIAN']; ?></td>
		<td><?php echo $dat_rekonsiliasi_obat['TGL_MULAI']; ?></td>
		<td><?php echo $dat_rekonsiliasi_obat['TGL_STOP']; ?></td>
		<td align="center"><?php if($dat_rekonsiliasi_obat['DILANJUTKAN_SELAMA_PERAWATAN'] == '1') echo '&radic;'; ?></td>
		<td align="center"><?php if($dat_rekonsiliasi_obat['DILANJUTKAN_SAAT_PULANG'] == '1') echo '&radic;'; ?></td>
		<td align="center"><a href="<?php echo currentUrl(); ?>&idro=<?php echo $dat_rekonsiliasi_obat['REKONSILIASI_ID']; ?>&ronm=<?php echo $dat_rekonsiliasi_obat['NAMA_OBAT']; ?>" >hapus</a></td>
    </tr>
<?php    
    $i++;
}
?>