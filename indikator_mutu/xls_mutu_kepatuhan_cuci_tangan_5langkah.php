<?php
include('./config/config.php');
include('./shared/connect_db.php');
include('./shared/function.php');

$tgl_1 = $_POST['tgl_1'];
$tgl_2 = $_POST['tgl_2'];

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}	

$qry_pasien = 'SELECT * FROM (SELECT mkc.KEPATUHAN_CUCITANGAN_ID,
				mkc.PEGAWAI_ID,pgw.NAMA_PEGAWAI,
				mkc.LANGKAH_1,mkc.LANGKAH_2,mkc.LANGKAH_3,mkc.LANGKAH_4,
				mkc.LANGKAH_5,
				DATE_FORMAT(mkc.TANGGAL,"%d/%m/%Y") AS TANGGAL,
				mkc.PENGUMPUL_DATA
				FROM db_repository.mutu_kepatuhan_cuci_tangan_5langkah mkc
				INNER JOIN db_simrs.m_pegawai pgw
				ON (mkc.PEGAWAI_ID = pgw.PEGAWAI_ID)
				WHERE mkc.TANGGAL >= ' . $tgl_filter_1 . '
				AND mkc.TANGGAL <= ' . $tgl_filter_2 . '
				AND mkc.APP_ID = "1"
				UNION ALL
				SELECT mkc.KEPATUHAN_CUCITANGAN_ID,
				mkc.PEGAWAI_ID,pgw.NAMA_PEGAWAI,
				mkc.LANGKAH_1,mkc.LANGKAH_2,mkc.LANGKAH_3,mkc.LANGKAH_4,
				mkc.LANGKAH_5,
				DATE_FORMAT(mkc.TANGGAL,"%d/%m/%Y") AS TANGGAL,
				mkc.PENGUMPUL_DATA
				FROM db_repository.mutu_kepatuhan_cuci_tangan_5langkah mkc
				INNER JOIN db_inventorirs.m_pegawai pgw
				ON (mkc.PEGAWAI_ID = pgw.PEGAWAI_ID)
				WHERE mkc.TANGGAL >= ' . $tgl_filter_1 . '
				AND mkc.TANGGAL <= ' . $tgl_filter_2 . '
				AND mkc.APP_ID = "2"
				) t_observasi
				ORDER BY KEPATUHAN_CUCITANGAN_ID';
?>
<table border="1" >
	<tr>
		<th colspan="8">Kepatuhan Cuci Tangan Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	<tr>
		<th>No</th>
		<th>Tanggal</th>
		<th>Nama Petugas</th>
        <th>Langkah 1</th>
		<th>Langkah 2</th>
		<th>Langkah 3</th>
		<th>Langkah 4</th>
		<th>Langkah 5</th>
    </tr>
    <?
    $no = 0;
	$rs = mysql_query($qry_pasien) or die(mysql_error());
     while ($data = mysql_fetch_array($rs)) {
        ?>
        <tr>
            <td align="center"><?php echo $no + 1; ?></td>
            <td align="center"><?php echo $data['TANGGAL']; ?></td>
			<td><?php echo $data['NAMA_PEGAWAI']; ?></td>
			<td align="center"><?php echo $data['LANGKAH_1']; ?></td>
			<td align="center"><?php echo $data['LANGKAH_2']; ?></td>
			<td align="center"><?php echo $data['LANGKAH_3']; ?></td>
			<td align="center"><?php echo $data['LANGKAH_4']; ?></td>
			<td align="center"><?php echo $data['LANGKAH_5']; ?></td>
        </tr>
        <?
    $no++; }
    ?>
</table>
