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

$qry_pasien = 'SELECT DISTINCT * FROM (SELECT t_operasi.OPERASI_ID,t_operasi.NO_ORDER,
				DATE_FORMAT(t_operasi.TANGGAL_PELAKSANAAN_OPERASI,"%d/%m/%Y %H:%i %H:%i") AS TANGGAL_PELAKSANAAN_OPERASI,
				DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y") AS TANGGAL_OPERASI,
				DATE_FORMAT(t_operasi.JAM_OPERASI,"%H:%i") AS JAM_OPERASI,
				m_pasien.NAMA_PASIEN,t_operasi.NOMR,m_pasien.TGL_LAHIR,
				t_operasi.PERUBAHAN_JADWAL,t_operasi.KETERANGAN_PERUBAHAN_JADWAL,
				CASE WHEN t_operasi.CARA_DIRAWAT = "1" THEN "Elektif"
					WHEN t_operasi.CARA_DIRAWAT = "2" THEN "Emerbency" END AS CARA_DIRAWAT
				FROM t_operasi
				INNER JOIN t_irja ON (t_operasi.RAWAT_ID = t_irja.IRJA_ID)
				INNER JOIN m_pasien ON (t_operasi.NOMR = m_pasien.NOMR)
				WHERE t_operasi.ST_APPROVE = "1" 
				AND t_operasi.JNS_ORDER = "IRJ"
				AND t_operasi.NO_PENDAFTARAN IS NOT NULL
				AND STR_TO_DATE(DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				UNION
				SELECT t_operasi.OPERASI_ID,t_operasi.NO_ORDER,
				DATE_FORMAT(t_operasi.TANGGAL_PELAKSANAAN_OPERASI,"%d/%m/%Y %H:%i") AS TANGGAL_PELAKSANAAN_OPERASI,
				DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y") AS TANGGAL_OPERASI,
				DATE_FORMAT(t_operasi.JAM_OPERASI,"%H:%i") AS JAM_OPERASI,
				m_pasien.NAMA_PASIEN,t_operasi.NOMR,m_pasien.TGL_LAHIR,
				t_operasi.PERUBAHAN_JADWAL,t_operasi.KETERANGAN_PERUBAHAN_JADWAL,
				CASE WHEN t_operasi.CARA_DIRAWAT = "1" THEN "Elektif"
					WHEN t_operasi.CARA_DIRAWAT = "2" THEN "Emerbency" END AS CARA_DIRAWAT
				FROM t_operasi
				INNER JOIN t_irna ON (t_operasi.RAWAT_ID = t_irna.IRNA_ID)
				INNER JOIN m_pasien ON (t_operasi.NOMR = m_pasien.NOMR)
				WHERE t_operasi.ST_APPROVE = "1"  
				AND t_operasi.JNS_ORDER = "IRN"
				AND t_operasi.NO_PENDAFTARAN IS NOT NULL
				AND STR_TO_DATE(DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				UNION
				SELECT t_operasi.OPERASI_ID,t_operasi.NO_ORDER,
				DATE_FORMAT(t_operasi.TANGGAL_PELAKSANAAN_OPERASI,"%d/%m/%Y %H:%i") AS TANGGAL_PELAKSANAAN_OPERASI,
				DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y") AS TANGGAL_OPERASI,
				DATE_FORMAT(t_operasi.JAM_OPERASI,"%H:%i") AS JAM_OPERASI,
				t_operasi.NAMA_PASIEN,t_operasi.NO_PASIEN_OPERASI AS NOMR,t_operasi.TGL_LAHIR,
				t_operasi.PERUBAHAN_JADWAL,t_operasi.KETERANGAN_PERUBAHAN_JADWAL,
				CASE WHEN t_operasi.CARA_DIRAWAT = "1" THEN "Elektif"
					WHEN t_operasi.CARA_DIRAWAT = "2" THEN "Emerbency" END AS CARA_DIRAWAT
				FROM t_operasi
				WHERE t_operasi.ST_APPROVE = "1"  
				AND t_operasi.JNS_ORDER = "APS"
				AND t_operasi.NO_PENDAFTARAN IS NOT NULL
				AND STR_TO_DATE(DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				) t_order WHERE 1 AND CARA_DIRAWAT = "Elektif"';

if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_pasien = $qry_pasien . ' AND CONCAT(t_order.NOMR,t_order.NAMA_PASIEN) LIKE "%' . $searchkey . '%" ';
}
$qry_pasien = $qry_pasien . ' ORDER BY t_order.OPERASI_ID';
?>
<table border="1" >
	<tr>
		<th colspan="9">Penundaan Waktu Operasi Elektif Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>
    <tr>
        <th>No</th>
		<th>Tanggal</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
        <th>Tanggal Lahir</th>
		<!--<th>Cara Dirawat</th>-->
		<th>Waktu<br />Jadwal Operasi</th>
		<th>Waktu<br />Pelaksanaan Operasi</th>
		<th>Jadwal<br />Berubah</th>
		<th>Keterangan</th>
    </tr>
    <?
    $no = 0;
	$rs = mysql_query($qry_pasien) or die(mysql_error());
     while ($data = mysql_fetch_array($rs)) {
        $id = $data['OPERASI_ID'];
        ?>
        <tr>
            <td align="center"><?php echo $no + 1; ?></td>
            <td align="center"><?php echo $data['TANGGAL_OPERASI']; ?></td>
            <td align="center"><?php echo formatNoMR($data['NOMR']); ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td align="center"><?php echo $data['TGL_LAHIR']; ?></td>
			<!--<td><?php echo $data['CARA_DIRAWAT']; ?></td>-->
			<td align="center"><?php echo $data['TANGGAL_OPERASI'] . ' ' . $data['JAM_OPERASI']; ?></td>
			<td align="center"><?php echo $data['TANGGAL_PELAKSANAAN_OPERASI']; ?></td>
			<td align="center"><?php if($data['PERUBAHAN_JADWAL'] == '1') echo '&radic;'; ?></td>
			<td><?php echo $data['KETERANGAN_PERUBAHAN_JADWAL']; ?></td>
        </tr>
        <?
    $no++; }
    ?>
</table>
