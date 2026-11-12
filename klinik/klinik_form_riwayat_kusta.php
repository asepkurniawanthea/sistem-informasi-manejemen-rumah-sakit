<table class="tableData" id="tfhover" >
<?php
$qry_history = 'SELECT DISTINCT 
				Tanggal,Alasan,PELAYANAN,
				DOSIS_ANTIREAKSI,
				DOSIS_LAMPRENE,
				`RFT(COT)` AS RFT_COT,
				BTA_MH_SKR,
				PENYAKITLAIN,
				KETERANGAN
				FROM z_kusta_kunjungan
				WHERE NoMR = "' . $nomr . '"';
$get_histori = mysql_query($qry_history) or die(mysql_error());
?>
<tr>
	<th>No</th>
    <th>Tanggal</th>
	<th>Alasan</th>
	<th>Pelayanan</th>
	<th>Anti Reaksi</th>
	<th>Dosis Lamprene</th>
	<th>RFT (COT)</th>
	<th>BTA Sekarang</th>
</tr>
<?php
$i = 1;
while ($dat_histori = mysql_fetch_array($get_histori)) {
    ?>
    <tr>
        <td align="center"><?php echo $i; ?></td>
		<td><?php echo $dat_histori['Tanggal']; ?></td>
		<td><?php echo $dat_histori['Alasan']; ?></td>
		<td><?php echo $dat_histori['PELAYANAN']; ?></td>
		<td><?php echo $dat_histori['DOSIS_ANTIREAKSI']; ?></td>
		<td><?php echo $dat_histori['DOSIS_LAMPRENE']; ?></td>
		<td><?php echo $dat_histori['RFT_COT']; ?></td>
		<td><?php echo $dat_histori['BTA_MH_SKR']; ?></td>
	</tr>
	<tr>
        <td align="center">&nbsp;</td>
		<td colspan="3"><strong>Penyakit Lain :</strong> <?php echo $dat_histori['PENYAKITLAIN']; ?></td>
		<td colspan="4"><strong>Keterangan :</strong> <?php echo $dat_histori['KETERANGAN']; ?></td>
	</tr>
    <?php
    $i++;
	}
?>
</table>	