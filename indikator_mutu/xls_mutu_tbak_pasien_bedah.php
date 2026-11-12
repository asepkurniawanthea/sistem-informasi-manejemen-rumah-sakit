<?php
include('./config/config.php');
include('./shared/connect_db.php');
include('./shared/function.php');

$tgl_1 = $_POST['tgl_1'];
$tgl_2 = $_POST['tgl_2'];
$searchkey = $_POST['searchkey'];

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}	

$qry_pasien = 'SELECT DISTINCT * FROM (SELECT kdb.OPERASI_ID,
				DATE_FORMAT(kdb.TANGGAL,"%d/%m/%Y") AS TANGGAL,
				psn.NAMA_PASIEN,top.NOMR,
				CASE WHEN kdb.APP_ID = "1" THEN
					(SELECT pgw.NAMA_PEGAWAI FROM db_simrs.m_pegawai pgw
					WHERE pgw.PEGAWAI_ID = kdb.PENELEPON_ID)
					WHEN kdb.APP_ID = "2" THEN
					(SELECT pgw2.NAMA_PEGAWAI FROM db_inventorirs.m_pegawai pgw2
					WHERE pgw2.PEGAWAI_ID = kdb.PENELEPON_ID)
				END AS PENELEPON,
				CASE WHEN kdb.APP_ID = "1" THEN
					(SELECT pgw3.NAMA_PEGAWAI FROM db_simrs.m_pegawai pgw3
					WHERE pgw3.PEGAWAI_ID = kdb.PENERIMA_TELEPON_ID)
					WHEN kdb.APP_ID = "2" THEN
					(SELECT pgw4.NAMA_PEGAWAI FROM db_inventorirs.m_pegawai pgw4
					WHERE pgw4.PEGAWAI_ID = kdb.PENERIMA_TELEPON_ID)
				END AS PENERIMA,
				kdb.VERIFIKASI_24JAM,
				kdb.PENGUMPUL_DATA
				FROM db_repository.mutu_tbak_pasien_bedah kdb 
				INNER JOIN db_simrs.t_operasi top ON (kdb.RAWAT_ID = top.RAWAT_ID) 
				INNER JOIN db_simrs.t_irja irj ON (top.RAWAT_ID = irj.IRJA_ID)
				INNER JOIN db_simrs.m_pasien psn ON (top.NOMR = psn.NOMR)
				WHERE top.JNS_ORDER = "IRJ"
				AND kdb.JNS_ORDER = "IRJ"
				AND STR_TO_DATE(DATE_FORMAT(kdb.TANGGAL,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(kdb.TANGGAL,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				UNION
				SELECT kdb.OPERASI_ID,
				DATE_FORMAT(kdb.TANGGAL,"%d/%m/%Y") AS TANGGAL,
				psn.NAMA_PASIEN,top.NOMR,
				CASE WHEN kdb.APP_ID = "1" THEN
					(SELECT pgw.NAMA_PEGAWAI FROM db_simrs.m_pegawai pgw
					WHERE pgw.PEGAWAI_ID = kdb.PENELEPON_ID)
					WHEN kdb.APP_ID = "2" THEN
					(SELECT pgw2.NAMA_PEGAWAI FROM db_inventorirs.m_pegawai pgw2
					WHERE pgw2.PEGAWAI_ID = kdb.PENELEPON_ID)
				END AS PENELEPON,
				CASE WHEN kdb.APP_ID = "1" THEN
					(SELECT pgw3.NAMA_PEGAWAI FROM db_simrs.m_pegawai pgw3
					WHERE pgw3.PEGAWAI_ID = kdb.PENERIMA_TELEPON_ID)
					WHEN kdb.APP_ID = "2" THEN
					(SELECT pgw4.NAMA_PEGAWAI FROM db_inventorirs.m_pegawai pgw4
					WHERE pgw4.PEGAWAI_ID = kdb.PENERIMA_TELEPON_ID)
				END AS PENERIMA,
				kdb.VERIFIKASI_24JAM,
				kdb.PENGUMPUL_DATA
				FROM db_repository.mutu_tbak_pasien_bedah kdb 
				INNER JOIN db_simrs.t_operasi top ON (kdb.RAWAT_ID = top.RAWAT_ID) 
				INNER JOIN db_simrs.t_irna irn ON (top.RAWAT_ID = irn.IRNA_ID)
				INNER JOIN db_simrs.m_pasien psn ON (top.NOMR = psn.NOMR)
				WHERE top.JNS_ORDER = "IRN"
				AND kdb.JNS_ORDER = "IRN"
				AND STR_TO_DATE(DATE_FORMAT(kdb.TANGGAL,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(kdb.TANGGAL,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				) t_order';

if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_pasien = $qry_pasien . ' AND CONCAT(t_order.NOMR,t_order.NAMA_PASIEN) LIKE "%' . $searchkey . '%" ';
}
$qry_pasien = $qry_pasien . ' ORDER BY t_order.OPERASI_ID';
?>
<table border="1" >
	<tr>
		<th colspan="7">TBAK Pasien Bedah Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>
    <tr>
        <th>No</th>
		<th>Tanggal</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
		<th>Petugas Yang Telpon</th>
		<th>Petugas Penerima Telpon</th>
		<th>Verifikasi<br />< 24 jam</th>
    </tr>
    <?
    $no = 0;
	$rs = mysql_query($qry_pasien) or die(mysql_error());
     while ($data = mysql_fetch_array($rs)) {
        $id = $data['OPERASI_ID'];
        ?>
        <tr>
            <td align="center"><?php echo $no + 1; ?></td>
            <td align="center"><?php echo $data['TANGGAL']; ?></td>
            <td align="center"><?php echo formatNoMR($data['NOMR']); ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
			<td><?php echo $data['PENELEPON']; ?></td>
			<td><?php echo $data['PENERIMA']; ?></td>
			<td align="center"><?php if($data['VERIFIKASI_24JAM'] == '1') echo 'Ya'; ?></td>
        </tr>
        <?
    $no++; }
    ?>
</table>
