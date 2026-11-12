<?php
$qry_tarif = 'SELECT * FROM (
				SELECT DISTINCT 0 AS DS, NULL AS PENUNJANG_ID,t_ipenunjang.NO_ORDER,
				DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_ORDER,
				t_ipenunjang_tarif.PENUNJANG_TARIF_ID,m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF,m_tarif.SATUAN,
				m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang_tarif.NO_TARIF,t_ipenunjang_tarif.ST_BAYAR,
				m_pegawai.NAMA_PEGAWAI,t_ipenunjang_tarif.ST_PERIKSA,
				t_ipenunjang.DESKRIPSI,t_ipenunjang_tarif.ST_DIAGNOSA,
				"1" AS ST,t_ipenunjang_tarif.TANGGAL_PERIKSA
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $irja_id . '" 
				AND t_ipenunjang.JNS_ORDER = "IRJ" 
				AND m_tarif_group.PENUNJANG = "1"
				AND m_tarif_group.UNIT_ID IN (51,40,41,47,31,42) 
				UNION ALL
				SELECT SUM(t_ipenunjang_tarif.KUANTITI) AS DS,t_ipenunjang.PENUNJANG_ID,
				CONCAT(t_ipenunjang.NO_ORDER," ",m_unit.NAMA_UNIT) AS NO_ORDER,
				DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_ORDER,
				t_ipenunjang_tarif.PENUNJANG_TARIF_ID,m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF,m_tarif.SATUAN,
				m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang_tarif.NO_TARIF,t_ipenunjang_tarif.ST_BAYAR,
				m_pegawai.NAMA_PEGAWAI,t_ipenunjang_tarif.ST_PERIKSA,
				t_ipenunjang.DESKRIPSI,t_ipenunjang_tarif.ST_DIAGNOSA,
				"2" AS ST,t_ipenunjang_tarif.TANGGAL_PERIKSA	
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_unit ON (t_ipenunjang_tarif.UNIT_PENUNJANG_ID = m_unit.UNIT_ID)
				LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				LEFT JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_ipenunjang.RAWAT_ID = "' . $irja_id . '"
				AND t_ipenunjang.JNS_ORDER = "IRJ" 
				AND m_unit.PENUNJANG = "pnj"
				AND m_unit.UNIT_ID IN (51,40,41,47,31,42)
				GROUP BY t_ipenunjang.PENUNJANG_ID,CONCAT(t_ipenunjang.NO_ORDER," ",m_unit.NAMA_UNIT),
				DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER,"%d/%m/%Y"),
				t_ipenunjang_tarif.ST_BAYAR,m_pegawai.NAMA_PEGAWAI
				HAVING SUM(t_ipenunjang_tarif.KUANTITI) = 0
				) t_order ORDER BY NO_ORDER';
$get_tarif = mysql_query($qry_tarif) or die(mysql_error());
?>
<tr>
    <th width="30">No</th>
	<th width="100">Nomor</th>
	<th>Jenis Pemeriksaan</th>
    <th>Nama Pemeriksaan</th>
    <th>Tarif (Rp.)</th>
	<th>Pelaksana</th>
	<th>Hasil</th>
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
		<td align="center"><?php if($nomor != $dat_tarif['NO_ORDER']) { echo $dat_tarif['NO_ORDER']; $nomor = $dat_tarif['NO_ORDER']; }  ?></td>
        <td><?php echo $dat_tarif['NAMA_TARIF_GROUP']; ?></td>
		<td><?php echo $dat_tarif['NAMA_TARIF']; ?></td>
		<td align="right"><?php echo currFormat($dat_tarif['TARIF_NON_KELAS']); ?></td>
		<td><?php echo $dat_tarif['NAMA_PEGAWAI']; ?></td>
		<td align="center">&nbsp;</td>
		<td align="center"><?php echo $dat_tarif['ST_BAYAR']; if(empty($dat_tarif['NO_ORDER'])) echo ' Belum Disimpan'; ?></td>
        <td align="center" width="110"><?php if($dat_tarif['TANGGAL_PERIKSA'] == ''){ ?>
		<?php if($irja_final == '' and (!in_array($jenis_bayar_id,array('1','18')) or empty($dat_tarif['NO_PEMBAYARAN']))){ ?>
			<a href="<?php echo currentUrl(); ?>&idk=<?php echo $dat_tarif['PENUNJANG_TARIF_ID']; ?>&nmk=<?php echo $dat_tarif['NAMA_TARIF']; ?>" >hapus</a>
		<?php } } ?></td>
    </tr>
    <?php
	$total = $total + $dat_tarif['TARIF_NON_KELAS'];
    $i++;
	}
?>