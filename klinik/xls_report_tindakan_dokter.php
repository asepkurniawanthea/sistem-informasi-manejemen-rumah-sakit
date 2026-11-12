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

$pegawai_id = '';
if (isset($_POST['pegawai_id']))
		$pegawai_id = $_POST['pegawai_id'];

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}	

$qry_filter = '';
if(!empty($pegawai_id))
	$qry_filter = 'AND (t_irja.PEGAWAI_ID = "' . $pegawai_id . '" OR t_irja_tarif.PEGAWAI_ID = "' . $pegawai_id . '") ';
if(!empty($unit_id))
	$qry_filter = 'AND t_irja.UNIT_ID = "' . $unit_id . '" ';	

$qry_kunjungan = 'SELECT DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y") AS TANGGAL,m_unit.NAMA_UNIT,m_pasien.NOMR,m_pasien.NAMA_PASIEN,
				m_pegawai.NAMA_PEGAWAI,m_tarif.NAMA_TARIF,m_tarif_group.NAMA_TARIF_GROUP,SUM(t_irja_tarif.KUANTITI) AS KUANTITI,
				m_jaminan.NAMA_JAMINAN,m_pegawai1.NAMA_PEGAWAI AS PELAKSANA,
				DATE_FORMAT(t_irja.PASIEN_MASUK,"%d/%m/%Y %H:%i:%s") AS PASIEN_MASUK,
				DATE_FORMAT(t_irja.PASIEN_KELUAR,"%d/%m/%Y %H:%i:%s") AS PASIEN_KELUAR,
				m_pasien_pulang.KET_PASIEN_PULANG,m_tarif.TARIF_NON_KELAS
				FROM t_irja
				INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
				INNER JOIN t_irja_tarif ON (t_irja.IRJA_ID = t_irja_tarif.IRJA_ID)
				INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				LEFT JOIN m_pegawai m_pegawai1 ON (t_irja_tarif.PEGAWAI_ID = m_pegawai1.PEGAWAI_ID)
				LEFT JOIN m_pasien_pulang ON (t_irja.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID)
				WHERE STR_TO_DATE(DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . '
				AND STR_TO_DATE(DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . ' 
				' . $qry_filter . '
				AND t_irja_tarif.NO_TARIF IS NOT NULL AND t_irja_tarif.ST_BAYAR <> "Batal"
				AND t_irja.ST_BATAL IS NULL AND m_tarif.KODE_TARIF_GROUP NOT IN ("01","92")	 
				GROUP BY DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),m_unit.NAMA_UNIT,m_pasien.NOMR,m_pasien.NAMA_PASIEN,
				m_pegawai.NAMA_PEGAWAI,m_tarif.NAMA_TARIF,m_tarif_group.NAMA_TARIF_GROUP,
				m_jaminan.NAMA_JAMINAN,m_pegawai1.NAMA_PEGAWAI,
				DATE_FORMAT(t_irja.PASIEN_MASUK,"%d/%m/%Y %H:%i:%s"),
				DATE_FORMAT(t_irja.PASIEN_KELUAR,"%d/%m/%Y %H:%i:%s"),
				m_pasien_pulang.KET_PASIEN_PULANG,m_tarif.TARIF_NON_KELAS
				ORDER BY m_unit.NAMA_UNIT,m_pegawai.NAMA_PEGAWAI,m_pasien.NOMR,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.NAMA_TARIF';
?>
<table border="1" >
	<tr>
		<th colspan="10">Laporan Kegiatan Tindakan Di Poliklinik Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>
    <tr>
        <th>No</th>
		<th>Tanggal</th>
		<th>Masuk</th>
		<th>Klinik</th>
		<th>No MR</th>
		<th>Nama Pasien</th>
        <th>Dokter</th>
        <th>Jenis Tindakan</th>
		<th>Jumlah</th>
		<?php if(currentModul() == 'keuangan'){ ?>
		<th>Harga</th>
		<?php } ?>
        <th>Jaminan</th>
        <th>Pelaksana</th>
		<th>Keluar</th>
		<th>Status</th>
    </tr>
    <?
    $no = 1;
	$rs = mysql_query($qry_kunjungan) or die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
	?>
			<td><?php echo $no; ?></td>
			<td><?php echo $data['TANGGAL']; ?></td>
			<td><?php echo $data['PASIEN_MASUK']; ?></td>
            <td><?php echo $data['NAMA_UNIT']; ?></td>
			<td><?php echo formatNomr($data['NOMR']); ?></td>
			<td><?php echo $data['NAMA_PASIEN']; ?></td>
			<td><?php echo $data['NAMA_PEGAWAI']; ?></td>
			<td><?php echo $data['NAMA_TARIF'] . ' (' . $data['NAMA_TARIF_GROUP'] . ')'; ?></td>
			<td align="right"><?php echo currFormat($data['KUANTITI']); ?></td>
			<?php if(currentModul() == 'keuangan'){ ?>
			<td align="right"><?php echo currFormat($data['KUANTITI'] * $data['TARIF_NON_KELAS']); ?></td>
			<?php } ?>
			<td><?php echo $data['NAMA_JAMINAN']; ?></td>
			<td><?php echo $data['PELAKSANA']; ?></td>
			<td><?php echo $data['PASIEN_KELUAR']; ?></td>
			<td><?php echo $data['KET_PASIEN_PULANG']; ?></td>
        </tr>
        <?
    $no++; }
    ?>
</table>
