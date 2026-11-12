<?php
$qry_pemeriksaan = 'SELECT t_irna_pemeriksaan_fisik.IRNA_PEMERIKSAAN_FISIK_ID,t_irna_pemeriksaan_fisik.IRNA_ID,
					DATE_FORMAT(t_irna_pemeriksaan_fisik.TANGGAL_PERIKSA,"%d-%m-%Y %H:%i") AS TANGGAL_PERIKSA,
					t_irna_pemeriksaan_fisik.FREKUENSI_NADI,t_irna_pemeriksaan_fisik.SUHU,
					t_irna_pemeriksaan_fisik.PERNAFASAN,t_irna_pemeriksaan_fisik.TEKANAN_DARAH_A,
					t_irna_pemeriksaan_fisik.TEKANAN_DARAH_B,t_irna_pemeriksaan_fisik.BERAT_BADAN,t_irna_pemeriksaan_fisik.TINGGI_BADAN,
					m_pegawai.NAMA_PEGAWAI
					FROM t_irna_pemeriksaan_fisik
					LEFT JOIN m_pegawai ON (t_irna_pemeriksaan_fisik.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
					WHERE t_irna_pemeriksaan_fisik.IRNA_ID = "' . $irna_id . '"
					ORDER BY t_irna_pemeriksaan_fisik.TANGGAL_PERIKSA';
$get_pemeriksaan = mysql_query($qry_pemeriksaan) or die(mysql_error());
?>
<tr>
    <th width="40">No</th>
    <th width="150">Tanggal</th>
	<th>Tensi (mmHg)</th>
	<th>Nafas (x/menit)</th>
	<th>Suhu (oC)</th>
	<th>Nadi (x/Menit)</th>
	<th>Brt. Badan (Kg)</th>
	<th>Tng. Badan (Cm)</th>
	<th width="150">Petugas</th>
    <th width="100">Option</th>
</tr>
<?php
$i = 1;
while ($dat_pemeriksaan = mysql_fetch_array($get_pemeriksaan)) {
    ?>
    <tr>
        <td align="center"><?php echo $i; ?></td>
        <td align="center"><?php echo $dat_pemeriksaan['TANGGAL_PERIKSA']; ?></td>
		<td><?php echo $dat_pemeriksaan['TEKANAN_DARAH_A'] . '/' . $dat_pemeriksaan['TEKANAN_DARAH_B']; ?></td>
		<td><?php echo $dat_pemeriksaan['PERNAFASAN']; ?></td>
		<td><?php echo $dat_pemeriksaan['SUHU']; ?></td>
		<td><?php echo $dat_pemeriksaan['FREKUENSI_NADI']; ?></td>
		<td><?php echo $dat_pemeriksaan['BERAT_BADAN']; ?></td>
		<td><?php echo $dat_pemeriksaan['TINGGI_BADAN']; ?></td>
		<td><?php echo $dat_pemeriksaan['NAMA_PEGAWAI']; ?></td>
        <td align="center">
		<?php if($_REQUEST['link'] != md5('ranapviewpasienperiksa')){ ?>
			<a href="#" onclick="window.open('index.php?popup=ranapformeditpemeriksaanfisik&idx=<?php echo $irna_id; ?>&idc=<?php echo $dat_pemeriksaan['IRNA_PEMERIKSAAN_FISIK_ID']; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=270')" >Edit</a>
			<a href="<?php echo currentUrl(); ?>&idc=<?php echo $dat_pemeriksaan['IRNA_PEMERIKSAAN_FISIK_ID']; ?>&ctt=<?php echo $dat_pemeriksaan['TANGGAL_PERIKSA']; ?>" >Hapus</a>
		<?php } ?>
		</td>
    </tr>
    <?php
    $i++;
}
?>