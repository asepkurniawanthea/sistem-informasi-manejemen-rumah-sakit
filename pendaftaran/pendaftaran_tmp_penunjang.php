<?php
$qry_tarif = 'SELECT * FROM (SELECT DISTINCT "1" AS JNT,t_ipenunjang.NO_ORDER,t_ipenunjang_tarif.PENUNJANG_TARIF_ID,m_tarif.KODE_TARIF,
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
				AND m_tarif.NAMA_TARIF <> "Karcis"
				AND m_tarif_group.UNIT_ID = "' . $unit_id . '"
				AND t_ipenunjang_tarif.NO_TARIF IS NULL
				UNION
				SELECT DISTINCT "2" AS JNT,t_ipenunjang.NO_ORDER AS NO_ORDER,t_ipenunjang_tarif.PENUNJANG_TARIF_ID,m_tarif.KODE_TARIF,
				m_tarif.NAMA_TARIF AS NAMA_TARIF,m_unit.NAMA_UNIT AS NAMA_UNIT,
				m_tarif.SATUAN,	m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang_tarif.NO_TARIF AS NO_TARIF,t_ipenunjang_tarif.ST_BAYAR,
				"" AS ST_PERIKSA,t_ipenunjang.DESKRIPSI,"" AS ST_DIAGNOSA,"" AS CH_REPORT
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_unit ON (m_tarif.UNIT_ID = m_unit.UNIT_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $rawat_id . '" AND t_ipenunjang.JNS_ORDER = "IRJ" 
				AND m_tarif.UNIT_ID = "' . $unit_id . '"
				AND t_ipenunjang_tarif.NO_TARIF IS NULL)
				t_order 
				ORDER BY NO_ORDER,NAMA_TARIF_GROUP,NAMA_TARIF';
$get_tarif = mysql_query($qry_tarif) or die(mysql_error());
?>
<tr>
    <th width="30">No</th>
	<th width="100">Nomor</th>
	<th>Jenis Pemeriksaan</th>
    <th>Nama Pemeriksaan</th>
	<th>Unit</th>
    <th>Tarif (Rp.)</th>
    <th width="60">Option</th>
</tr>
<?
if(($unit_id != 17) && ($unit_id != 45) && ($unit_id != 52)){
	if($tgl_daftar_rujuk != getDateSkr()){
		
		$sql_kunj_penunjang = 'SELECT SUM(KUNJ) AS KUNJ FROM (SELECT COUNT(t_ipenunjang.PENUNJANG_ID) AS KUNJ
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							WHERE t_ipenunjang.NOMR = "' . $nomr . '"
							AND t_ipenunjang.JNS_ORDER = "IRJ"
							AND DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") = "' . getDateSkr() . '"
							AND (t_ipenunjang_tarif.UNIT_PENUNJANG_ID = "31" OR t_ipenunjang_tarif.UNIT_PENUNJANG_ID = "41"
							OR t_ipenunjang_tarif.UNIT_PENUNJANG_ID = "51" OR t_ipenunjang_tarif.UNIT_PENUNJANG_ID = "47"
							OR t_ipenunjang_tarif.UNIT_PENUNJANG_ID = "40")
							AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
							AND t_ipenunjang_tarif.ST_BATAL IS NULL
							UNION
							SELECT COUNT(t_irja.IRJA_ID) AS KUNJ
							FROM t_irja
							WHERE t_irja.NOMR = "' . $nomr . '"
							AND DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") = "' . getDateSkr() . '"
							AND t_irja.NO_PENDAFTARAN IS NOT NULL
							AND t_irja.ST_BATAL IS NULL) t_tran';
		$get_kunj_penunjang = mysql_query($sql_kunj_penunjang) or die(mysql_error());
		$dat_kunj_penunjang = mysql_fetch_assoc($get_kunj_penunjang);
		
		if($dat_kunj_penunjang['KUNJ'] == 0){
		$sql_karcis = 'SELECT TARIF_ID,TARIF_NON_KELAS FROM m_tarif WHERE KODE_TARIF = "01001" AND ST_AKTIF = "1"';
		$get_karcis = mysql_query($sql_karcis) or die(mysql_error());
		$dat_karcis = mysql_fetch_assoc($get_karcis);
		$harga_karcis =  $dat_karcis['TARIF_NON_KELAS'];
		$id_karcis =  $dat_karcis['TARIF_ID'];
?>
	
	<tr>
        <td align="center">1</td>
		<td align="center">-</td>
        <td>Registrasi</td>
		<td>Karcis</td>
		<td>&nbsp;</td>
		<td align="right"><?php echo currFormat($harga_karcis); ?></td>
        <td align="center">
		<input type="checkbox" name="tarif1" id="karcis" value="<?php echo $id_karcis; ?>" onclick="JavaScript : centang_opt('karcis',<?php echo $harga_karcis; ?>);" checked="checked" />
		<script type="text/javascript">
			centang_opt('karcis',<?php echo $harga_karcis; ?>);
		</script>
		</td>
    </tr>
		<?php }
	}
}
$i = 2;
$total = 0;
$nomor = '';
while ($dat_tarif = mysql_fetch_array($get_tarif)) {
    ?>
    <tr>
        <td align="center"><?php echo $i; ?></td>
		<td align="center"><?php if($nomor != $dat_tarif['NO_ORDER']) { echo $dat_tarif['NO_ORDER']; $nomor = $dat_tarif['NO_ORDER']; }  ?></td>
        <td><?php echo $dat_tarif['NAMA_TARIF_GROUP']; ?></td>
		<td><?php echo $dat_tarif['NAMA_TARIF']; ?></td>
		<td><?php echo $dat_tarif['NAMA_UNIT']; ?></td>
		<td align="right"><?php echo currFormat($dat_tarif['TARIF_NON_KELAS']); ?></td>
        <td align="center">
		<?php if(empty($dat_tarif['NO_TARIF'])){ ?>
		<input type="hidden" name="jnt<?php echo $i; ?>" value="<?php echo $dat_tarif['JNT']; ?>" />
		<input type="checkbox" name="tarif<?php echo $i; ?>" id="tarif<?php echo $i; ?>" value="<?php echo $dat_tarif['PENUNJANG_TARIF_ID']; ?>" onclick="JavaScript : centang_opt('<?php echo 'tarif'. $i; ?>',<?php echo $dat_tarif['TARIF_NON_KELAS']; ?>);" />
		<?php } ?>
		</td>
    </tr>
    <?php
	$total = $total + $dat_tarif['TARIF_NON_KELAS'];
    $i++;
	}
?>