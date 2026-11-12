<?php
$qry_pemberian_obat = 'SELECT DISTINCT t_irna_pemberian_obat.IRNA_ID,
					DATE_FORMAT(t_irna_pemberian_obat.TANGGAL,"%d/%m/%Y") AS TANGGAL
					FROM t_irna_pemberian_obat
					WHERE t_irna_pemberian_obat.IRNA_ID = "' . $irna_id . '"
					ORDER BY t_irna_pemberian_obat.TANGGAL';
$get_pemberian_obat = mysql_query($qry_pemberian_obat);
?>
<tr>
    <th width="40">No</th>
    <th width="100">Tanggal</th>
	<th width="100" colspan="2">Jam</th>
	<th>Nama Obat/BHP</th>
	<th>Dosis</th>
	<th>Satuan</th>
	<th>Status Dosis</th>
	<th>Insidentil</th>
	<th>Resep</th>
	<th>Dari Luar</th>
	<th>Form RS</th>
	<th>Form Nas</th>
	<th>Harga (Rp.)</th>
	<th width="150">Petugas</th>
    <th width="100">Option</th>
</tr>
<?php
$i = 1;
while ($dat_pemberian_obat = mysql_fetch_array($get_pemberian_obat)) {
    ?>
    <tr>
        <td align="center"><?php echo $i; ?></td>
        <td align="center"><?php echo $dat_pemberian_obat['TANGGAL']; ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
    </tr>
    <?php
		$sql_pemberian_obat_detail = 'SELECT t_irna_pemberian_obat.PEMBERIAN_OBAT_ID,t_irna_pemberian_obat.IRNA_ID,
										DATE_FORMAT(t_irna_pemberian_obat.TANGGAL,"%H:%i:%s") AS JAM,
										t_irna_pemberian_obat.OBAT_DR_LUAR,t_irna_pemberian_obat.INSIDENTIL,
										t_irna_pemberian_obat.RESEP,t_irna_pemberian_obat.NAMA_PERSEDIAAN,
										t_irna_pemberian_obat.JENIS_PERSEDIAAN,t_irna_pemberian_obat.SATUAN,
										t_irna_pemberian_obat.JUMLAH_KELUAR,m_pegawai.NAMA_PEGAWAI,
										t_irna_pemberian_obat.DOSIS,t_irna_pemberian_obat.STATUS_DOSIS,
										t_irna_pemberian_obat.FORMULARIUM,t_irna_pemberian_obat.FORMULARIUM_NASIONAL,
										t_irna_pemberian_obat.HARGA_JUAL
										FROM t_irna_pemberian_obat
										LEFT JOIN m_pegawai ON (t_irna_pemberian_obat.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
										WHERE t_irna_pemberian_obat.IRNA_ID = "' . $irna_id . '"
										AND DATE_FORMAT(t_irna_pemberian_obat.TANGGAL,"%d/%m/%Y") = "' . $dat_pemberian_obat['TANGGAL'] . '"
										ORDER BY t_irna_pemberian_obat.TANGGAL';
		$get_pemberian_obat_detail = mysql_query($sql_pemberian_obat_detail) or die(mysql_error());	
		$j = 1;
		$total = 0;
		while($dat_pemberian_obat_detail = mysql_fetch_array($get_pemberian_obat_detail)){
			?>
			<tr>
			<td align="center">&nbsp;</td>
			<td align="center">&nbsp;</td>
			<td align="center"><?php echo $j; ?></td>
			<td><?php echo $dat_pemberian_obat_detail['JAM']; ?></td>
			<td><?php echo $dat_pemberian_obat_detail['NAMA_PERSEDIAAN']; ?></td>
			<td><?php echo $dat_pemberian_obat_detail['DOSIS']; ?></td>
			<td><?php echo $dat_pemberian_obat_detail['SATUAN']; ?></td>
			<td><?php echo $dat_pemberian_obat_detail['STATUS_DOSIS']; ?></td>
			<td align="center"><?php if($dat_pemberian_obat_detail['INSIDENTIL'] == '1') { echo "&radic;"; } ?></td>
			<td align="center"><?php if($dat_pemberian_obat_detail['RESEP'] == '1') { echo "&radic;"; } ?></td>
			<td align="center"><?php if($dat_pemberian_obat_detail['OBAT_DR_LUAR'] == '1') { echo "&radic;"; } ?></td>
			<td align="center"><?php if($dat_pemberian_obat_detail['FORMULARIUM'] == '1') { echo "&radic;"; } ?></td>
			<td align="center"><?php if($dat_pemberian_obat_detail['FORMULARIUM_NASIONAL'] == '1') { echo "&radic;"; } ?></td>
			<td align="right"><?php if(($dat_pemberian_obat_detail['OBAT_DR_LUAR'] != '1') and ($dat_pemberian_obat_detail['RESEP'] != '1')){ 
						echo currFormat($dat_pemberian_obat_detail['JUMLAH_KELUAR'] * $dat_pemberian_obat_detail['HARGA_JUAL']); 
						$total = $total + ($dat_pemberian_obat_detail['JUMLAH_KELUAR'] * $dat_pemberian_obat_detail['HARGA_JUAL']); } ?></td>
			<td><?php echo $dat_pemberian_obat_detail['NAMA_PEGAWAI']; ?></td>
			<td align="center">
			<?php if($_REQUEST['link'] != md5('ranapviewpasienperiksa')){ ?>
			<a href="#" onclick="window.open('index.php?popup=ranapformeditpemberianobat&idx=<?php echo $irna_id; ?>&idc=<?php echo $dat_pemberian_obat_detail['PEMBERIAN_OBAT_ID']; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=350')" >Edit</a>
			<a href="<?php echo currentUrl(); ?>&ido=<?php echo $dat_pemberian_obat_detail['PEMBERIAN_OBAT_ID']; ?>&nmo=<?php echo $dat_pemberian_obat_detail['NAMA_PERSEDIAAN']; ?>" >hapus</a>
			<?php } ?>
			</td>
			</tr>	
			<?php
			$j++;
		}
    $i++;
}
?>