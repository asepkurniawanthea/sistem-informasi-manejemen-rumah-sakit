<?php
include('./config/config.php');
include('./shared/connect_db.php');
include('./shared/function.php');

$tgl_1 = '';
if (isset($_POST['tgl_1']))
    $tgl_1 = $_POST['tgl_1'];
$tgl_2 = '';
if (isset($_POST['tgl_1']))
    $tgl_2 = $_POST['tgl_2'];

$unit_id = '';
if (isset($_POST['unit_id']))
		$unit_id = $_POST['unit_id'];

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}	

$qry_filter = '';
if(!empty($unit_id))
	$qry_filter = ' WHERE t_tindakan.UNIT_ID = "' . $unit_id . '" ';		

$qry_kunjungan = 'SELECT * FROM (
						SELECT "01" AS URUT,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.NAMA_TARIF,
						m_tarif.KODE_TARIF,SUM(t_irja_tarif.KUANTITI) AS KUANTITI,
						t_irja.UNIT_ID,m_unit.NAMA_UNIT,
						"" AS NAMA_PEGAWAI,
						"" AS PELAKSANA
						FROM t_irja
						INNER JOIN t_irja_tarif ON (t_irja.IRJA_ID = t_irja_tarif.IRJA_ID)
						INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
						INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						WHERE t_irja_tarif.NO_TARIF IS NOT NULL AND t_irja_tarif.ST_BAYAR <> "Batal"
						AND t_irja.ST_BATAL IS NULL	
						AND m_tarif_group.KODE_TARIF_GROUP = "01" 
						AND STR_TO_DATE(DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . '
						AND STR_TO_DATE(DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
						GROUP BY m_tarif_group.NAMA_TARIF_GROUP,m_tarif.NAMA_TARIF,
						m_tarif.KODE_TARIF,t_irja.UNIT_ID,m_unit.NAMA_UNIT
						UNION
						SELECT "02" AS URUT,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.NAMA_TARIF,
						m_tarif.KODE_TARIF,SUM(t_irja_tarif.KUANTITI) AS KUANTITI,
						t_irja.UNIT_ID,m_unit.NAMA_UNIT,
						m_pegawai.NAMA_PEGAWAI,
						"" AS PELAKSANA
						FROM t_irja
						INNER JOIN t_irja_tarif ON (t_irja.IRJA_ID = t_irja_tarif.IRJA_ID)
						INNER JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
						INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
						INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						WHERE t_irja_tarif.NO_TARIF IS NOT NULL AND t_irja_tarif.ST_BAYAR <> "Batal"
						AND t_irja.ST_BATAL IS NULL	
						AND (m_tarif_group.KODE_TARIF_GROUP = "02" OR m_tarif_group.KODE_TARIF_GROUP = "09")
						AND STR_TO_DATE(DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . '
						AND STR_TO_DATE(DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
						GROUP BY m_tarif_group.NAMA_TARIF_GROUP,m_tarif.NAMA_TARIF,
						m_tarif.KODE_TARIF,t_irja.UNIT_ID,m_unit.NAMA_UNIT,
						m_pegawai.NAMA_PEGAWAI
						UNION
						SELECT "03" AS URUT,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.NAMA_TARIF,
						m_tarif.KODE_TARIF,SUM(t_irja_tarif.KUANTITI) AS KUANTITI,
						t_irja.UNIT_ID,m_unit.NAMA_UNIT,
						m_pegawai.NAMA_PEGAWAI,
						m_pegawai1.NAMA_PEGAWAI AS PELAKSANA
						FROM t_irja
						INNER JOIN t_irja_tarif ON (t_irja.IRJA_ID = t_irja_tarif.IRJA_ID)
						INNER JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
						INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
						INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						LEFT JOIN m_pegawai m_pegawai1 ON (t_irja_tarif.PEGAWAI_ID = m_pegawai1.PEGAWAI_ID)
						WHERE t_irja_tarif.NO_TARIF IS NOT NULL AND t_irja_tarif.ST_BAYAR <> "Batal"
						AND t_irja.ST_BATAL IS NULL	
						AND m_tarif_group.LABORATORIUM <> "1" 
						AND m_tarif_group.LABORATORIUM_CITO <> "1"
						AND m_tarif_group.RADIOLOGI <> "1" 
						AND m_tarif_group.RADIOLOGI_CITO <> "1"
						AND m_tarif_group.KODE_TARIF_GROUP <> "01"
						AND m_tarif_group.KODE_TARIF_GROUP <> "02"
						AND m_tarif_group.KODE_TARIF_GROUP <> "09"
						AND STR_TO_DATE(DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . '
						AND STR_TO_DATE(DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
						GROUP BY m_tarif_group.NAMA_TARIF_GROUP,m_tarif.NAMA_TARIF,
						m_tarif.KODE_TARIF,t_irja.UNIT_ID,m_unit.NAMA_UNIT,
						m_pegawai.NAMA_PEGAWAI,m_pegawai1.NAMA_PEGAWAI) t_tindakan
						' . $qry_filter . '
						ORDER BY URUT,KODE_TARIF,NAMA_UNIT,NAMA_PEGAWAI,PELAKSANA';
$extparam = '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&unit_id=' . $unit_id;
?>
<table border="1">
	<tr>
		<td colspan="7">Laporan Volume Kegiatan Di Poliklinik Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></td>
	</tr>
	<tr>
		<th width="30">No</th>
		<th>Poliklinik</th>
		<th width="80">Kode</th>
		<th>Jenis Kegiatan</th>
		<th>Dokter Penanggung Jawab</th>
		<th>Pelaksana</th>
		<th width="50">Jumlah</th>
	</tr>

<?php 
 $no = 1;
	$rs = mysql_query($qry_kunjungan) or die(mysql_error());
    while ($dat_kunjungan = mysql_fetch_array($rs)) {
	
        ?>
		<td><?php echo $no; ?></td>
		<td><?php echo $dat_kunjungan['NAMA_UNIT']; ?></td>
		<td align="center"><?php echo $dat_kunjungan['KODE_TARIF']; ?></td>
		<td><?php echo $dat_kunjungan['NAMA_TARIF'] . ' (' . $dat_kunjungan['NAMA_TARIF_GROUP'] . ')'; ?></td>
		<td><?php echo $dat_kunjungan['NAMA_PEGAWAI']; ?></td>
		<td><?php echo $dat_kunjungan['PELAKSANA']; ?></td>
		<td align="right"><?php echo currFormat($dat_kunjungan['KUANTITI']); ?></td>
	</tr>
<?php $no++; } ?>
</table>