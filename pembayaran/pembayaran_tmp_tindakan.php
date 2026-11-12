<?php
$qry_tarif = 'SELECT t_irja_tarif.IRJA_TARIF_ID,m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF,m_tarif.SATUAN,
				m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,t_irja_tarif.ICD_CODE,
				t_irja_tarif.NO_PEMBAYARAN,t_irja_tarif.NO_TARIF,t_irja_tarif.ST_BAYAR,t_irja_tarif.USER_KASIR
				FROM t_irja_tarif
				INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_irja_tarif.IRJA_ID = "' . $irja_id . '"
				AND m_tarif_group.KODE_TARIF_GROUP <> "01"  
				AND t_irja_tarif.NO_TARIF IS NULL AND t_irja_tarif.DESKRIPSI = "Tindakan (Kasir)"
				ORDER BY t_irja_tarif.NO_TARIF,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.NAMA_TARIF';
$get_tarif = mysql_query($qry_tarif);
?>
<tr>
    <th width="30">No</th>
	<th width="100">Nomor</th>
	<th>Jenis Tindakan</th>
    <th>Nama Tindakan</th>
    <th>Tarif (Rp.)</th>
	<th width="100">Status</th>
    <th width="100">Option</th>
</tr>
<?php
$i = 1;
$total = 0;
$nomor = '';
while ($dat_tarif = mysql_fetch_array($get_tarif)) {
    ?>
    <tr>
        <td align="center"><?php echo $i; ?></td>
		<td align="center"><?php if($nomor != $dat_tarif['NO_TARIF']) { echo $dat_tarif['NO_TARIF']; $nomor = $dat_tarif['NO_TARIF']; }  ?></td>
        <td><?php echo $dat_tarif['NAMA_TARIF_GROUP']; ?></td>
		<td><?php echo $dat_tarif['NAMA_TARIF']; ?></td>
		<td align="right"><?php echo currFormat($dat_tarif['TARIF_NON_KELAS']); ?></td>
		<td align="center"><?php echo $dat_tarif['ST_BAYAR']; if(empty($dat_tarif['NO_TARIF'])) echo ' Belum Disimpan'; ?></td>
        <td align="center">
		<?php if($jenis_bayar_id == '1' and empty($dat_tarif['NO_PEMBAYARAN'])){ ?>
		<a href="<?php echo currentUrl(); ?>&idk=<?php echo $dat_tarif['IRJA_TARIF_ID']; ?>&nmk=<?php echo $dat_tarif['NAMA_TARIF']; ?>" >hapus</a>
		<?php }else if($jenis_bayar_id != '1'){ ?>
		<a href="<?php echo currentUrl(); ?>&idk=<?php echo $dat_tarif['IRJA_TARIF_ID']; ?>&nmk=<?php echo $dat_tarif['NAMA_TARIF']; ?>" >hapus</a>
		<?php } ?></td>
    </tr>
    <?php
	$total = $total + $dat_tarif['TARIF_NON_KELAS'];
    $i++;
	}
?>