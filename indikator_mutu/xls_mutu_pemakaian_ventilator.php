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
				kdb.DIAGNOSA,
				kdb.JNS_OPERASI,
				DATE_FORMAT(kdb.JAM_PEMASANGAN,"%d/%m/%Y %H:%i") AS JAM_PEMASANGAN,
				DATE_FORMAT(kdb.JAM_PELEPASAN,"%d/%m/%Y %H:%i") AS JAM_PELEPASAN,
				TIMEDIFF(kdb.JAM_PELEPASAN,kdb.JAM_PEMASANGAN) AS LAMA
				FROM db_repository.mutu_pemakaian_ventilator kdb 
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
				kdb.DIAGNOSA,
				kdb.JNS_OPERASI,
				DATE_FORMAT(kdb.JAM_PEMASANGAN,"%d/%m/%Y %H:%i") AS JAM_PEMASANGAN,
				DATE_FORMAT(kdb.JAM_PELEPASAN,"%d/%m/%Y %H:%i") AS JAM_PELEPASAN,
				TIMEDIFF(kdb.JAM_PELEPASAN,kdb.JAM_PEMASANGAN) AS LAMA
				FROM db_repository.mutu_pemakaian_ventilator kdb 
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
		<th colspan="9">Pemakaian Ventilator Pasca Operasi Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>
    <tr>
        <th rowspan="2">No</th>
		<th rowspan="2">Tanggal</th>
        <th rowspan="2">Nomor MR</th>
        <th rowspan="2">Nama Pasien</th>
        <th rowspan="2">Diagnosa</th>
		<th rowspan="2">Jenis Operasi</th>
		<th colspan="2">Waktu Pemakaian Ventilator</th>
		<th rowspan="2">Lama Waktu Pemakaian</th>
    </tr>
	<tr>
		<th>Tanggal & Jam<br />Pemasangan</th>
		<th>Tanggal & Jam<br />Pelepasan</th>
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
			<td><?php echo $data['DIAGNOSA']; ?></td>
			<td><?php echo $data['JNS_OPERASI']; ?></td>
			<td align="center"><?php echo $data['JAM_PEMASANGAN']; ?></td>
			<td align="center"><?php echo $data['JAM_PELEPASAN']; ?></td>
			<td align="center"><?php echo $data['LAMA']; ?></td>
        </tr>
        <?
    $no++; }
    ?>
</table>
