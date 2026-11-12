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
				DATE_FORMAT(kdb.TGL_OBSERVASI,"%d/%m/%Y") AS TANGGAL,
				psn.NAMA_PASIEN,top.NOMR,
				CASE WHEN kdb.SEBELUM_TINDAKAN = "1" THEN "Ya"
					WHEN kdb.SEBELUM_TINDAKAN = "2" THEN "Tdk"
					WHEN kdb.SEBELUM_TINDAKAN = "3" THEN "NA" END AS SEBELUM_TINDAKAN,
				CASE WHEN kdb.SEBELUM_PEMBERIAN_OBAT = "1" THEN "Ya"
					WHEN kdb.SEBELUM_PEMBERIAN_OBAT = "2" THEN "Tdk"
					WHEN kdb.SEBELUM_PEMBERIAN_OBAT = "3" THEN "NA" END AS SEBELUM_PEMBERIAN_OBAT,
				CASE WHEN kdb.SEBELUM_TRANSFUSI = "1" THEN "Ya"
					WHEN kdb.SEBELUM_TRANSFUSI = "2" THEN "Tdk"
					WHEN kdb.SEBELUM_TRANSFUSI = "3" THEN "NA" END AS SEBELUM_TRANSFUSI,
				kdb.PENGUMPUL_DATA
				FROM db_repository.mutu_kepatuhan_identifikasi_pasien_bedah kdb 
				INNER JOIN db_simrs.t_operasi top ON (kdb.RAWAT_ID = top.RAWAT_ID) 
				INNER JOIN db_simrs.t_irja irj ON (top.RAWAT_ID = irj.IRJA_ID)
				INNER JOIN db_simrs.m_pasien psn ON (top.NOMR = psn.NOMR)
				WHERE top.JNS_ORDER = "IRJ"
				AND kdb.JNS_ORDER = "IRJ"
				AND STR_TO_DATE(DATE_FORMAT(kdb.TGL_OBSERVASI,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(kdb.TGL_OBSERVASI,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				UNION
				SELECT kdb.OPERASI_ID,
				DATE_FORMAT(kdb.TGL_OBSERVASI,"%d/%m/%Y") AS TANGGAL,
				psn.NAMA_PASIEN,top.NOMR,
				CASE WHEN kdb.SEBELUM_TINDAKAN = "1" THEN "Ya"
					WHEN kdb.SEBELUM_TINDAKAN = "2" THEN "Tdk"
					WHEN kdb.SEBELUM_TINDAKAN = "3" THEN "NA" END AS SEBELUM_TINDAKAN,
				CASE WHEN kdb.SEBELUM_PEMBERIAN_OBAT = "1" THEN "Ya"
					WHEN kdb.SEBELUM_PEMBERIAN_OBAT = "2" THEN "Tdk"
					WHEN kdb.SEBELUM_PEMBERIAN_OBAT = "3" THEN "NA" END AS SEBELUM_PEMBERIAN_OBAT,
				CASE WHEN kdb.SEBELUM_TRANSFUSI = "1" THEN "Ya"
					WHEN kdb.SEBELUM_TRANSFUSI = "2" THEN "Tdk"
					WHEN kdb.SEBELUM_TRANSFUSI = "3" THEN "NA" END AS SEBELUM_TRANSFUSI,
				kdb.PENGUMPUL_DATA
				FROM db_repository.mutu_kepatuhan_identifikasi_pasien_bedah kdb 
				INNER JOIN db_simrs.t_operasi top ON (kdb.RAWAT_ID = top.RAWAT_ID) 
				INNER JOIN db_simrs.t_irna irn ON (top.RAWAT_ID = irn.IRNA_ID)
				INNER JOIN db_simrs.m_pasien psn ON (top.NOMR = psn.NOMR)
				WHERE top.JNS_ORDER = "IRN"
				AND kdb.JNS_ORDER = "IRN"
				AND STR_TO_DATE(DATE_FORMAT(kdb.TGL_OBSERVASI,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(kdb.TGL_OBSERVASI,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				) t_order';

if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_pasien = $qry_pasien . ' AND CONCAT(t_order.NOMR,t_order.NAMA_PASIEN) LIKE "%' . $searchkey . '%" ';
}
$qry_pasien = $qry_pasien . ' ORDER BY t_order.OPERASI_ID';
?>
<table border="1" >
	<tr>
		<th colspan="7">Kepatuhan Identifikasi Pasien Bedah Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>
    <tr>
        <th rowspan="2">No</th>
		<th rowspan="2">Tanggal</th>
        <th rowspan="2">Nomor MR</th>
        <th rowspan="2">Nama Pasien</th>
		<th colspan="3">Dilakukan Identifikasi</th>
    </tr>
	<tr>
      <th>Sebelum<br />Tindakan</th>
      <th>Sebelum<br />Pemberian Obat</th>
      <th>Sebelum<br />Pemberian Transfusi</th>
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
			<td align="center">
				<?php echo $data['SEBELUM_TINDAKAN']; ?></td>
			</td>
			<td align="center">
				<?php echo $data['SEBELUM_PEMBERIAN_OBAT']; ?></td>
			</td>
			<td align="center">
				<?php echo $data['SEBELUM_TRANSFUSI']; ?></td>
        </tr>
        </tr>
        <?
    $no++; }
    ?>
</table>
