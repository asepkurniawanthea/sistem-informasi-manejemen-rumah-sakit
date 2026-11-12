<?php
$qry_tarif = 'SELECT t_irna_tarif.IRNA_TARIF_ID,m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF,m_tarif.SATUAN,
				m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
				m_tarif.TARIF_KELAS_3, m_tarif.TARIF_KELAS_2, m_tarif.TARIF_KELAS_1, m_tarif.TARIF_KELAS_UTAMA,
				m_tarif.TARIF_KELAS_PERINA_SEHAT, m_tarif.TARIF_KELAS_PERINA_SAKIT, m_tarif.TARIF_HCU,
				t_irna_tarif.ICD_CODE,t_irna_tarif.KELAS_RAWAT,
				t_irna_tarif.NO_PEMBAYARAN,t_irna_tarif.NO_TARIF,t_irna_tarif.ST_BAYAR,t_irna_tarif.USER_KASIR,
				m_tarif_group.NON_KELAS
				FROM t_irna_tarif
				INNER JOIN m_tarif ON (t_irna_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_irna_tarif.IRNA_ID = "' . $irna_id . '"
				AND t_irna_tarif.NO_TARIF IS NULL AND t_irna_tarif.DESKRIPSI = "Tindakan (Kasir)"
				ORDER BY t_irna_tarif.NO_TARIF,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.NAMA_TARIF';
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
		<td align="right"><?php 
		$tarif = 0;
		if(strtoupper($dat_tarif['KELAS_RAWAT']) == '1') $tarif = $dat_tarif['TARIF_KELAS_1'];
		if(strtoupper($dat_tarif['KELAS_RAWAT']) == '2') $tarif = $dat_tarif['TARIF_KELAS_2'];
		if(strtoupper($dat_tarif['KELAS_RAWAT']) == '3') $tarif = $dat_tarif['TARIF_KELAS_3'];
		if(strtoupper($dat_tarif['KELAS_RAWAT']) == 'UTAMA') $tarif = $dat_tarif['TARIF_KELAS_UTAMA'];
		if(strtoupper($dat_tarif['KELAS_RAWAT']) == 'VIP') $tarif = $dat_tarif['TARIF_KELAS_UTAMA'];
		if(strtoupper($dat_tarif['KELAS_RAWAT']) == 'PERINA SEHAT') $tarif = $dat_tarif['TARIF_KELAS_PERINA_SEHAT'];
		if(strtoupper($dat_tarif['KELAS_RAWAT']) == 'PERINA SAKIT') $tarif = $dat_tarif['TARIF_KELAS_PERINA_SAKIT'];
		if(strtoupper($dat_tarif['KELAS_RAWAT']) == 'HCU') $tarif = $dat_tarif['TARIF_HCU'];
		if(strtoupper($dat_tarif['NON_KELAS']) == '1') $tarif = $dat_tarif['TARIF_NON_KELAS']; 
		echo currFormat($tarif);
		?></td>
		<td align="center"><?php echo $dat_tarif['ST_BAYAR']; if(empty($dat_tarif['NO_TARIF'])) echo ' Belum Disimpan'; ?></td>
        <td align="center">
		<?php if($jenis_bayar_id == '1' and empty($dat_tarif['NO_PEMBAYARAN'])){ ?>
		<a href="<?php echo currentUrl(); ?>&idk=<?php echo $dat_tarif['IRNA_TARIF_ID']; ?>&nmk=<?php echo $dat_tarif['NAMA_TARIF']; ?>" >hapus</a>
		<?php }else if($jenis_bayar_id != '1'){ ?>
		<a href="<?php echo currentUrl(); ?>&idk=<?php echo $dat_tarif['IRNA_TARIF_ID']; ?>&nmk=<?php echo $dat_tarif['NAMA_TARIF']; ?>" >hapus</a>
		<?php } ?></td>
    </tr>
    <?php
	$total = $total + $tarif;
    $i++;
	}
?>