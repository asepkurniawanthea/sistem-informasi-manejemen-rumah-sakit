<?php
$qry_tarif = 'SELECT * FROM (SELECT DISTINCT t_ipenunjang.NO_ORDER,t_ipenunjang_tarif.PENUNJANG_TARIF_ID,m_tarif.KODE_TARIF,
				CASE WHEN m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
				OR m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
				THEN m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER ELSE m_tarif.NAMA_TARIF END AS NAMA_TARIF,
				CASE WHEN m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
				THEN "Laboratorium" 
				WHEN m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
				THEN "Radiologi"
				ELSE m_unit.NAMA_UNIT END AS NAMA_UNIT,
				m_tarif.SATUAN,	m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang_tarif.NO_TARIF,t_ipenunjang_tarif.ST_BAYAR,
				t_ipenunjang_tarif.ST_PERIKSA,t_ipenunjang.DESKRIPSI,t_ipenunjang_tarif.ST_DIAGNOSA,
				m_tarif_pemeriksaan.CH_REPORT
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				LEFT JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				LEFT JOIN m_unit ON (m_tarif_group.UNIT_ID = m_unit.UNIT_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $rawat_id . '" AND t_ipenunjang.JNS_ORDER = "IRJ" 
				AND t_ipenunjang_tarif.NO_TARIF = "' . $_GET['no'] . '"
				UNION
				SELECT DISTINCT t_irja_tarif.NO_TARIF AS NO_ORDER,t_irja_tarif.IRJA_TARIF_ID AS PENUNJANG_TARIF_ID,m_tarif.KODE_TARIF,
				m_tarif.NAMA_TARIF,
				m_unit.NAMA_UNIT,
				m_tarif.SATUAN,	m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
				t_irja_tarif.NO_PEMBAYARAN,t_irja_tarif.NO_TARIF_DAFTAR AS NO_TARIF,t_irja_tarif.ST_BAYAR,
				"" AS ST_PERIKSA,t_irja_tarif.DESKRIPSI,t_irja_tarif.ST_DIAGNOSA,"" AS CH_REPORT
				FROM t_irja
				INNER JOIN t_irja_tarif ON (t_irja.IRJA_ID = t_irja_tarif.IRJA_ID)
				INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				LEFT JOIN m_unit ON (m_tarif.UNIT_ID = m_unit.UNIT_ID)
				WHERE t_irja.IRJA_ID = "' . $rawat_id . '"  
				AND t_irja_tarif.NO_TARIF_DAFTAR = "' . $_GET['no'] . '")
				t_tran ORDER BY NO_ORDER,NAMA_TARIF_GROUP,NAMA_TARIF';
$get_tarif = mysql_query($qry_tarif) or die(mysql_error());
?>
<tr>
    <th width="30">No</th>
	<th width="100">Nomor</th>
	<th>Jenis Pemeriksaan</th>
    <th>Nama Pemeriksaan</th>
    <th>Tarif (Rp.)</th>
	<th width="100">Status</th>
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
		<td align="center"><?php echo $dat_tarif['ST_BAYAR']; ?></td>
    </tr>
    <?php
	$total = $total + $dat_tarif['TARIF_NON_KELAS'];
    $i++;
	}
?>