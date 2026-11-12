<?php
$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
mysql_select_db($database_3, $connect_3) or die(mysql_error());

$qry_resep = 'SELECT DISTINCT DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y") AS TGL_RESEP,
		t_ranap_resep.NO_RESEP,t_ranap_resep.RANAP_RESEP_ID
		FROM t_ranap_resep 
		INNER JOIN t_ranap_resep_detail ON (t_ranap_resep.RANAP_RESEP_ID = t_ranap_resep_detail.RANAP_RESEP_ID)
		INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_ranap_resep_detail.RANAP_RESEP_DETAIL_ID = t_farmasi_apotik_pengeluaran_detail.RANAP_RESEP_DETAIL_ID)
		INNER JOIN t_farmasi_apotik_pengeluaran ON (t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID = t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID)
		INNER JOIN m_persediaan_farmasi ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
		INNER JOIN m_persediaan_group ON (m_persediaan_farmasi.PERSEDIAAN_GROUP_ID = m_persediaan_group.PERSEDIAAN_GROUP_ID)
		WHERE t_ranap_resep.RANAP_ID = "' . $irna_id . '"
		AND t_ranap_resep.HEMODIALISA_ID IS NULL';
$get_resep = mysql_query($qry_resep) or die(mysql_error());
?>
<tr>
    <th width="30">No</th>
	<th width="100">Tanggal</th>
	<th width="100">Nomor</th>
	<th>Nama Obat/ BHP</th>
	<th width="150">Jumlah</th>
	<th width="150">Satuan</th>
	<th width="60">Alkes</th>
	<th width="60">Racikan</th>
	<th width="60">Generik</th>
</tr>
<?php
$i = 1;
while ($dat_resep = mysql_fetch_array($get_resep)) {
    ?>
    <tr>
        <td align="center"><?php echo $i; ?></td>
		<td><?php echo $dat_resep['TGL_RESEP']; ?></td>
		<td><?php echo $dat_resep['NO_RESEP']; ?></td>
        <td colspan="2">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
    </tr>
    <?php
			$qry_det_resep = 'SELECT t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,
		SUM(t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR) AS JUMLAH_KELUAR,
		t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.PERSEN_JAMINAN,
		m_persediaan_farmasi.NAMA_PERSEDIAAN,m_persediaan_farmasi.SATUAN,
		t_ranap_resep_detail.RACIKAN,t_ranap_resep_detail.NAMA_RACIKAN,
		CASE WHEN t_ranap_resep_detail.RACIKAN = "1" THEN CONCAT(t_ranap_resep_detail.NAMA_RACIKAN," (", m_persediaan_farmasi.NAMA_PERSEDIAAN,")") 
		ELSE m_persediaan_farmasi.NAMA_PERSEDIAAN END AS PERSEDIAAN,
		CASE WHEN t_ranap_resep_detail.GENERIK = "1" THEN "v" END AS GENERIK,
		CASE WHEN m_persediaan_farmasi.ALKES = "1" THEN "v" END AS ALKES,
		SUM((t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR * t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL)
		- ((t_farmasi_apotik_pengeluaran.PERSEN_JAMINAN/100) * 
		(t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR * t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL))) AS HARGA_TOTAL,
		t_ranap_resep.NO_RESEP
		FROM t_ranap_resep 
		INNER JOIN t_ranap_resep_detail ON (t_ranap_resep.RANAP_RESEP_ID = t_ranap_resep_detail.RANAP_RESEP_ID)
		INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_ranap_resep_detail.RANAP_RESEP_DETAIL_ID = t_farmasi_apotik_pengeluaran_detail.RANAP_RESEP_DETAIL_ID)
		INNER JOIN t_farmasi_apotik_pengeluaran ON (t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID = t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID)
		INNER JOIN m_persediaan_farmasi ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
		INNER JOIN m_persediaan_group ON (m_persediaan_farmasi.PERSEDIAAN_GROUP_ID = m_persediaan_group.PERSEDIAAN_GROUP_ID)
		WHERE t_ranap_resep.RANAP_ID = "' . $irna_id . '" AND t_ranap_resep.NO_RESEP = "' . $dat_resep['NO_RESEP'] . '" 
		AND t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR > 0
		AND t_ranap_resep.HEMODIALISA_ID IS NULL
		GROUP BY t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,
		t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,t_farmasi_apotik_pengeluaran.PERSEN_JAMINAN,
		m_persediaan_farmasi.NAMA_PERSEDIAAN,m_persediaan_farmasi.SATUAN,
		t_ranap_resep_detail.RACIKAN,t_ranap_resep_detail.NAMA_RACIKAN,t_ranap_resep.NO_RESEP
		ORDER BY PERSEDIAAN ASC';			
			$get_det_resep = mysql_query($qry_det_resep) or die(mysql_error());
			$y = 1;
			while($dat_det_resep = mysql_fetch_array($get_det_resep)){
			?>
			<tr>
			<td colspan="2">&nbsp;</td>
			<td width="30" align="center"><?php echo $y; ?></td>
			<td><?php echo $dat_det_resep['NAMA_PERSEDIAAN']; ?></td>
			<td align="right"><?php echo $dat_det_resep['JUMLAH_KELUAR']; ?></td>
			<td><?php echo $dat_det_resep['SATUAN']; ?></td>
			<td align="center"><?php if($dat_det_resep['ALKES'] == '1') echo '&radic;'; ?></td>
			<td align="center"><?php if($dat_det_resep['RACIKAN'] == '1') echo '&radic;'; ?></td>
			<td align="center"><?php if($dat_det_resep['GENERIK'] == '1') echo '&radic;'; ?></td>
			</tr>
			<?php			
			$y++; }
    $i++;
	}
?>