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
	$qry_filter = 'AND (t_irna.PEGAWAI_ID = "' . $pegawai_id . '" OR t_irna_tarif.PEGAWAI_ID = "' . $pegawai_id . '") ';
if(!empty($unit_id))
	$qry_filter = 'AND t_irna.UNIT_ID = "' . $unit_id . '" ';	

$qry_kunjungan = 'SELECT DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d/%m/%Y") AS TANGGAL,
				m_ruang.NAMA_RUANG,m_pasien.NOMR,m_pasien.NAMA_PASIEN,
				m_pegawai.NAMA_PEGAWAI,m_tarif.NAMA_TARIF,m_tarif_group.NAMA_TARIF_GROUP,
				SUM(t_irna_tarif.KUANTITI) AS KUANTITI,
				m_jaminan.NAMA_JAMINAN,m_pegawai1.NAMA_PEGAWAI AS PELAKSANA,
				DATE_FORMAT(t_irna.PASIEN_MASUK,"%d/%m/%Y %H:%i:%s") AS PASIEN_MASUK,
				DATE_FORMAT(t_irna.PASIEN_KELUAR,"%d/%m/%Y %H:%i:%s") AS PASIEN_KELUAR,
				m_pasien_pulang.KET_PASIEN_PULANG,
				CASE WHEN m_tarif_group.NON_KELAS = "1" OR t_irna_tarif.KELAS_RAWAT = ""
					THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS
				ELSE	
					CASE WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "3" THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_KELAS_3 
						WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "2" THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_KELAS_2
						WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "1" THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_KELAS_1
						WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "UTAMA" THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_KELAS_UTAMA
						WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "VIP" THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_KELAS_UTAMA
						WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "UTAMA 2" THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_KELAS_UTAMA_2
						WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "VVIP" THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_KELAS_UTAMA_2
						WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "HCU" THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_HCU
						WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "ICU" THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_ICU
						WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "NICU" THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_NICU
						WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "PICU" THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_PICU
						WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "ICCU" THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_ICCU
						WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "PERINA" THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_PERINA
						WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "BAYI SEHAT" THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_KELAS_PERINA_SEHAT
						WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "BAYI SAKIT" THEN t_irna_tarif.KUANTITI * m_tarif.TARIF_KELAS_PERINA_SAKIT
					END 
				END AS HARGA
				FROM t_irna
				INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				INNER JOIN t_irna_tarif ON (t_irna.IRNA_ID = t_irna_tarif.IRNA_ID)
				INNER JOIN m_tarif ON (t_irna_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				INNER JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_ruang ON (t_irna_tarif.RUANG_ID = m_ruang.RUANG_ID)
				LEFT JOIN m_pegawai m_pegawai1 ON (t_irna_tarif.PEGAWAI_PELAKSANA_ID = m_pegawai1.PEGAWAI_ID)
				LEFT JOIN m_pasien_pulang ON (t_irna.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID)
				WHERE STR_TO_DATE(DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . '
				AND STR_TO_DATE(DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . ' 
				' . $qry_filter_dokter . $qry_filter_ruang . '
				AND t_irna_tarif.NO_TARIF IS NOT NULL AND t_irna_tarif.ST_BAYAR <> "Batal"
				AND t_irna.ST_BATAL IS NULL AND m_tarif.KODE_TARIF_GROUP NOT IN ("51")	 
				GROUP BY DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d/%m/%Y"),m_ruang.NAMA_RUANG,m_pasien.NOMR,m_pasien.NAMA_PASIEN,
				m_pegawai.NAMA_PEGAWAI,m_tarif.NAMA_TARIF,m_tarif_group.NAMA_TARIF_GROUP,
				m_jaminan.NAMA_JAMINAN,m_pegawai1.NAMA_PEGAWAI,
				DATE_FORMAT(t_irna.PASIEN_MASUK,"%d/%m/%Y %H:%i:%s"),
				DATE_FORMAT(t_irna.PASIEN_KELUAR,"%d/%m/%Y %H:%i:%s"),
				m_pasien_pulang.KET_PASIEN_PULANG
				ORDER BY m_ruang.NAMA_RUANG,m_pegawai.NAMA_PEGAWAI,m_pasien.NOMR,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.NAMA_TARIF';
?>
<table border="1" >
	<tr>
		<th colspan="10">Laporan Kegiatan Tindakan Di Rawat Inap Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>
    <tr>
        <th>No</th>
		<th>Tanggal</th>
		<th>Poliranap</th>
		<th>No MR</th>
		<th>Nama Pasien</th>
        <th>Pengirim</th>
        <th>Jenis Tindakan</th>
		<th>Jumlah</th>
		<?php if(currentModul() == 'keuangan'){ ?>
		<th>Harga</th>
		<?php } ?>
        <th>Jaminan</th>
        <th>Pelaksana</th>
    </tr>
    <?
    $no = 1;
	$rs = mysql_query($qry_kunjungan) or die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
	?>
			<td><?php echo $no; ?></td>
			<td><?php echo $data['TANGGAL']; ?></td>
            <td><?php echo $data['NAMA_UNIT']; ?></td>
			<td><?php echo formatNomr($data['NOMR']); ?></td>
			<td><?php echo $data['NAMA_PASIEN']; ?></td>
			<td><?php echo $data['NAMA_PEGAWAI']; ?></td>
			<td><?php echo $data['NAMA_TARIF'] . ' (' . $data['NAMA_TARIF_GROUP'] . ')'; ?></td>
			<td align="right"><?php echo currFormat($data['KUANTITI']); ?></td>
			<?php if(currentModul() == 'keuangan'){ ?>
				<td align="right"><?php echo currFormat($data['HARGA']); ?></td>
			<?php } ?>
			<td><?php echo $data['NAMA_JAMINAN']; ?></td>
			<td><?php echo $data['PELAKSANA']; ?></td>
        </tr>
        <?
    $no++; }
    ?>
</table>
