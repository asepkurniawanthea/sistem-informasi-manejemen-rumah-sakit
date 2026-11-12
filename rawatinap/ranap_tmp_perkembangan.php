<?php
$qry_perkembangan = 'SELECT t_irna_perkembangan.IRNA_PERKEMBANGAN_ID,t_irna_perkembangan.IRNA_ID,t_irna_perkembangan.CATATAN,
				 t_irna_perkembangan.TANGGAL_PERIKSA,m_pegawai.NAMA_PEGAWAI,t_irna_perkembangan.IRNA_PERKEMBANGAN_ID
				 FROM t_irna_perkembangan 
				 LEFT JOIN m_pegawai ON (t_irna_perkembangan.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				 WHERE t_irna_perkembangan.IRNA_ID = "' . $irna_id . '"
				ORDER BY t_irna_perkembangan.IRNA_PERKEMBANGAN_ID DESC';
$get_perkembangan = mysql_query($qry_perkembangan);
?>
<tr>
    <th width="40">No</th>
    <th width="150">Tanggal</th>
	<th>Catatan</th>
	<th width="150">Petugas</th>
    <th width="100">Option</th>
</tr>
<?php
$i = 1;
while ($dat_perkembangan = mysql_fetch_array($get_perkembangan)) {
    ?>
    <tr>
        <td align="center"><?php echo $i; ?></td>
        <td align="center"><?php echo $dat_perkembangan['TANGGAL_PERIKSA']; ?></td>
		<td><?php echo $dat_perkembangan['CATATAN']; ?></td>
		<td><?php echo $dat_perkembangan['NAMA_PEGAWAI']; ?></td>
        <td align="center">
		<?php if($_REQUEST['link'] != md5('ranapviewpasienperiksa')){ ?>
			<a href="#" onclick="window.open('index.php?popup=ranapformeditperkembangan&idx=<?php echo $irna_id; ?>&idc=<?php echo $dat_perkembangan['IRNA_PERKEMBANGAN_ID']; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=250')" >ubah</a>
			<a href="<?php echo currentUrl(); ?>&idc=<?php echo $dat_perkembangan['IRNA_PERKEMBANGAN_ID']; ?>&ctt=<?php echo $dat_perkembangan['CATATAN']; ?>" >hapus</a>
		<?php } ?>
		</td>
    </tr>
    <?php
    $i++;
}
?>