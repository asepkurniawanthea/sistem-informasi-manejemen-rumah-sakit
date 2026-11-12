<?php
$qry_keluar_masuk = 'SELECT DISTINCT t_irna_askep_catatan_keluar_masuk.IRNA_ID,
					DATE_FORMAT(t_irna_askep_catatan_keluar_masuk.TANGGAL,"%d/%m/%Y") AS TANGGAL
					FROM t_irna_askep_catatan_keluar_masuk
					WHERE t_irna_askep_catatan_keluar_masuk.IRNA_ID = "' . $irna_id . '"
					ORDER BY t_irna_askep_catatan_keluar_masuk.TANGGAL';
$get_keluar_masuk = mysql_query($qry_keluar_masuk);
?>
<tr>
    <th width="40">No</th>
    <th width="70">Tanggal</th>
	<th width="50">Pukul</th>
	<th>Jenis Keluar Masuk</th>
	<th>Catatan</th>
	<th width="130">Petugas</th>
    <th width="100">Option</th>
</tr>
<?php
$i = 1;
while ($dat_keluar_masuk = mysql_fetch_array($get_keluar_masuk)) {
    ?>
    <tr>
        <td align="center"><?php echo $i; ?></td>
        <td align="center"><?php echo $dat_keluar_masuk['TANGGAL']; ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
    </tr>
    <?php
		$sql_keluar_masuk_detail = 'SELECT t_irna_askep_catatan_keluar_masuk.KELUAR_MASUK_ID,t_irna_askep_catatan_keluar_masuk.IRNA_ID,
										DATE_FORMAT(t_irna_askep_catatan_keluar_masuk.TANGGAL,"%H:%i:%s") AS JAM,
										t_irna_askep_catatan_keluar_masuk.JENIS_KELUAR_MASUK,t_irna_askep_catatan_keluar_masuk.CATATAN,
										m_pegawai.NAMA_PEGAWAI
										FROM t_irna_askep_catatan_keluar_masuk
										LEFT JOIN m_pegawai ON (t_irna_askep_catatan_keluar_masuk.PERAWAT = m_pegawai.PEGAWAI_ID)
										WHERE t_irna_askep_catatan_keluar_masuk.IRNA_ID = "' . $irna_id . '"
										AND DATE_FORMAT(t_irna_askep_catatan_keluar_masuk.TANGGAL,"%d/%m/%Y") = "' . $dat_keluar_masuk['TANGGAL'] . '"
										ORDER BY DATE_FORMAT(t_irna_askep_catatan_keluar_masuk.TANGGAL,"%H:%i:%s")';
		$get_keluar_masuk_detail = mysql_query($sql_keluar_masuk_detail) or die(mysql_error());	
		$j = 1;
		while($dat_keluar_masuk_detail = mysql_fetch_array($get_keluar_masuk_detail)){
			?>
			<tr>
			<td align="center">&nbsp;</td>
			<td align="center">&nbsp;</td>
			<td><?php echo $dat_keluar_masuk_detail['JAM']; ?></td>
			<td><?php echo $dat_keluar_masuk_detail['JENIS_KELUAR_MASUK']; ?></td>
			<td><?php echo $dat_keluar_masuk_detail['CATATAN']; ?></td>
			<td><?php echo $dat_keluar_masuk_detail['NAMA_PEGAWAI']; ?></td>
			<td align="center">
			<a href="<?php echo currentUrl(); ?>&idce=<?php echo $dat_keluar_masuk_detail['KELUAR_MASUK_ID']; ?>&nmce=<?php echo $dat_keluar_masuk_detail['JENIS_KELUAR_MASUK']; ?>" >ubah</a>
			<a href="<?php echo currentUrl(); ?>&idc=<?php echo $dat_keluar_masuk_detail['KELUAR_MASUK_ID']; ?>&nmc=<?php echo $dat_keluar_masuk_detail['JENIS_KELUAR_MASUK']; ?>" >hapus</a>
			</td>
			</tr>	
			<?php
			$j++;
		}
    $i++;
}
?>