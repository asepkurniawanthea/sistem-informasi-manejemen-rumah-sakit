<?php
$qry_tarif = 'SELECT DISTINCT t_hemodialisa.HEMODIALISA_ID,DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_ORDER,
			t_hemodialisa.NO_ORDER,t_hemodialisa.PEGAWAI_ID,t_hemodialisa.USER_ORDER,m_pegawai.NAMA_PEGAWAI,
			t_hemodialisa.PEGAWAI_PERIKSA_ID
			FROM t_hemodialisa
			INNER JOIN m_pegawai ON (t_hemodialisa.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
			WHERE t_hemodialisa.JNS_ORDER = "IRJ"
			AND t_hemodialisa.RAWAT_ID = "' . $idx . '"';
$get_tarif = mysql_query($qry_tarif) or die(mysql_error());
?>
<tr>
    <th width="30">No</th>
	<th width="100">Tanggal</th>
	<th width="150">Nomor</th>
	<th width="150">Pengirim</th>
    <th colspan="3">Nama Pemeriksaan</th>
    <th>Tarif (Rp.)</th>
	<th>Pelaksana</th>
	<th width="100">Status</th>
    <th width="100">Option</th>
</tr>
<?php
$i = 1;
while ($dat_tarif = mysql_fetch_array($get_tarif)) {
    ?>
    <tr>
        <td align="center"><?php echo $i; ?></td>	
		<td align="center"><?php echo $dat_tarif['TANGGAL_ORDER']; ?></td>
		<td align="center"><?php echo $dat_tarif['NO_ORDER']; ?></td>
		<td><?php echo $dat_tarif['NAMA_PEGAWAI']; ?></td>
		<td colspan="3">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td>&nbsp;</td>
		<td align="center">&nbsp;</td>
        <td align="center">
		<?php if(empty($dat_tarif['PEGAWAI_PERIKSA_ID'])){?> 
			<a href="<?php echo currentUrl(); ?>&idk=<?php echo $dat_tarif['HEMODIALISA_ID']; ?>&nmk=<?php echo $dat_tarif['NO_ORDER']; ?>" >hapus</a>
		<?php } ?>
		</td>
    </tr>
    <?php
		$qry_det_tarif = 'SELECT t_hemodialisa_tarif.HEMODIALISA_TARIF_ID,m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF,m_tarif.SATUAN,
				m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
				t_hemodialisa_tarif.NO_PEMBAYARAN,t_hemodialisa_tarif.NO_TARIF,
				m_pegawai.NAMA_PEGAWAI,t_hemodialisa_tarif.PEGAWAI_ID,
				t_hemodialisa_tarif.ST_BAYAR
				FROM t_hemodialisa
				INNER JOIN t_hemodialisa_tarif ON (t_hemodialisa_tarif.HEMODIALISA_ID = t_hemodialisa.HEMODIALISA_ID)
				INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				LEFT JOIN m_pegawai ON (t_hemodialisa_tarif.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_hemodialisa.RAWAT_ID = "' . $idx . '" AND t_hemodialisa.JNS_ORDER = "IRJ"
				AND t_hemodialisa_tarif.HEMODIALISA_ID = "' . $dat_tarif['HEMODIALISA_ID'] . '"';		
		$get_det_tarif = mysql_query($qry_det_tarif) or die(mysql_error());
		$y = 1;
		$total = 0;
		while($dat_det_tarif = mysql_fetch_array($get_det_tarif)){
		?>
		<tr>
        <td colspan="4">&nbsp;</td>	
		<td width="10"><?php echo $y; ?></td>
		<td colspan="2"><?php echo $dat_det_tarif['NAMA_TARIF'] . ' (' . $dat_det_tarif['NAMA_TARIF_GROUP'] . ')'; ?></td>
		<td align="right"><?php echo currFormat($dat_det_tarif['TARIF_NON_KELAS']); ?></td>
		<td><?php echo $dat_det_tarif['NAMA_PEGAWAI']; ?></td>
		<td><?php echo $dat_det_tarif['ST_BAYAR']; ?></td>
        <td align="center" width="110">&nbsp;
		</td>
    </tr>
		<?php
		$y++; $total = $total + $dat_det_tarif['TARIF_NON_KELAS']; 
		}
		?>
		<tr>
		<td align="right" colspan="8">Total : Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($total); ?></td>
		<td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
    </tr>
		<?php
    $i++;
	}
?>