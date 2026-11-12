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

$qry_pasien = 'SELECT * FROM (SELECT mkc.APD_ID,
				mkc.PEGAWAI_ID,pgw.NAMA_PEGAWAI,
				mkc.PENGGUNAAN_APD,
				DATE_FORMAT(mkc.TANGGAL,"%d/%m/%Y") AS TANGGAL,
				mkc.PENGUMPUL_DATA,
				mkc.KETERANGAN
				FROM db_repository.mutu_penggunaan_apd mkc
				INNER JOIN db_simrs.m_pegawai pgw
				ON (mkc.PEGAWAI_ID = pgw.PEGAWAI_ID)
				WHERE mkc.TANGGAL >= ' . $tgl_filter_1 . '
				AND mkc.TANGGAL <= ' . $tgl_filter_2 . '
				AND mkc.APP_ID = "1"
				UNION ALL
				SELECT mkc.APD_ID,
				mkc.PEGAWAI_ID,pgw.NAMA_PEGAWAI,
				mkc.PENGGUNAAN_APD,
				DATE_FORMAT(mkc.TANGGAL,"%d/%m/%Y") AS TANGGAL,
				mkc.PENGUMPUL_DATA,
				mkc.KETERANGAN
				FROM db_repository.mutu_penggunaan_apd mkc
				INNER JOIN db_inventorirs.m_pegawai pgw
				ON (mkc.PEGAWAI_ID = pgw.PEGAWAI_ID)
				WHERE mkc.TANGGAL >= ' . $tgl_filter_1 . '
				AND mkc.TANGGAL <= ' . $tgl_filter_2 . '
				AND mkc.APP_ID = "2"
				) t_observasi
				ORDER BY APD_ID';
?>
<table border="1" >
	<tr>
		<th colspan="5">Penggunaan APD Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>
    <tr>
        <th>No</th>
		<th>Tanggal</th>
		<th>Nama Petugas</th>
        <th>Penggunaan APD</th>
		<th>Keterangan</th>
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
			<td align="center"><?php if($data['PENGGUNAAN_APD'] == '1') echo 'Lengkap'; ?></td>
			<td><?php echo $data['KETERANGAN']; ?></td>
        </tr>
        <?
    $no++; }
    ?>
</table>
