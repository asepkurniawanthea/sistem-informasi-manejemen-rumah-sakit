<?php
include('./config/config.php');
include('./shared/connect_db.php');
include('./shared/function.php');

$tgl_1 = $_POST['tgl_1'];
$tgl_2 = $_POST['tgl_2'];
$ruang_id = $_POST['ruang_id'];
$searchkey = $_POST['searchkey'];

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}	

$qry_pasien = 'SELECT mki.KEPATUHAN_IDENTIFIKASI_ID, 
				DATE_FORMAT(mki.TGL_OBSERVASI,"%d/%m/%Y") AS TANGGAL,
				CASE WHEN mki.SEBELUM_TINDAKAN = "1" THEN "Ya"
					WHEN mki.SEBELUM_TINDAKAN = "2" THEN "Tdk"
					WHEN mki.SEBELUM_TINDAKAN = "3" THEN "NA" END AS SEBELUM_TINDAKAN,
				CASE WHEN mki.SEBELUM_PEMBERIAN_OBAT = "1" THEN "Ya"
					WHEN mki.SEBELUM_PEMBERIAN_OBAT = "2" THEN "Tdk"
					WHEN mki.SEBELUM_PEMBERIAN_OBAT = "3" THEN "NA" END AS SEBELUM_PEMBERIAN_OBAT,
				CASE WHEN mki.SEBELUM_PENGAMBILAN_SAMPLE = "1" THEN "Ya"
					WHEN mki.SEBELUM_PENGAMBILAN_SAMPLE = "2" THEN "Tdk"
					WHEN mki.SEBELUM_PENGAMBILAN_SAMPLE = "3" THEN "NA" END AS SEBELUM_PENGAMBILAN_SAMPLE,
				CASE WHEN mki.SEBELUM_PEMBERIAN_NUTRISI = "1" THEN "Ya"
					WHEN mki.SEBELUM_PEMBERIAN_NUTRISI = "2" THEN "Tdk"
					WHEN mki.SEBELUM_PEMBERIAN_NUTRISI = "3" THEN "NA" END AS SEBELUM_PEMBERIAN_NUTRISI,
				CASE WHEN mki.SEBELUM_TRANSFUSI = "1" THEN "Ya"
					WHEN mki.SEBELUM_TRANSFUSI = "2" THEN "Tdk"
					WHEN mki.SEBELUM_TRANSFUSI = "3" THEN "NA" END AS SEBELUM_TRANSFUSI,
				mki.PENGUMPUL_DATA,
				irn.IRNA_ID,irn.NOMR, 
				CONCAT(un.NAMA_RUANG,"-",un.KELAS_RAWAT) AS NAMA_RUANG,
				un.RUANG_ID,psn.NAMA_PASIEN,
				DATE_FORMAT(psn.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR
				FROM db_repository.mutu_kepatuhan_identifikasi_iri mki
				INNER JOIN db_simrs.t_irna irn ON (irn.IRNA_ID = mki.RAWAT_ID) 
				INNER JOIN db_simrs.m_pasien psn ON (irn.NOMR = psn.NOMR) 
				LEFT JOIN db_simrs.m_ruang un ON (irn.RUANG_ID = un.RUANG_ID)	
				WHERE STR_TO_DATE(DATE_FORMAT(mki.TGL_OBSERVASI,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . '
				AND STR_TO_DATE(DATE_FORMAT(mki.TGL_OBSERVASI,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2;

if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_pasien = $qry_pasien . ' AND CONCAT(psn.NOMR,psn.NAMA_PASIEN) LIKE "%' . $searchkey . '%" ';
}
if (!empty($ruang_id)) {
    $qry_pasien = $qry_pasien . ' AND un.BANGSAL = "' . $ruang_id . '" ';
}	
$qry_pasien = $qry_pasien . 'ORDER BY mki.KEPATUHAN_IDENTIFIKASI_ID';
?>
<table border="1" >
	<tr>
		<th colspan="11">Ketepatan Identifikasi Pasien Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>
    <tr>
        <th rowspan="2">No</th>
		<th rowspan="2">Tanggal</th>
        <th rowspan="2">Nomor MR</th>
        <th rowspan="2">Nama Pasien</th>
        <th rowspan="2">Tanggal Lahir</th>
        <th rowspan="2">Ruang Rawat</th>
        <th colspan="5">Dilakukan Identifikasi</th>
		<!--<th rowspan="2" width="100px">Register</th>-->
    </tr>
    <tr>
      <th>Sebelum<br />Tindakan</th>
      <th>Sebelum<br />Pemberian Obat</th>
	  <th>Sebelum<br />Pengambilan Sample</th>
	  <th>Sebelum<br />Pemberian Nutrisi</th>
      <th>Sebelum<br />Pemberian Transfusi</th>
    </tr>
    <?
    $no = 0;
	$rs = mysql_query($qry_pasien) or die(mysql_error());
     while ($data = mysql_fetch_array($rs)) {
        $id = $data['IRNA_ID'];
        ?>
        <tr>
            <td align="center"><?php echo $no + 1; ?></td>
            <td align="center"><?php echo $data['TANGGAL']; ?></td>
            <td align="center"><?php echo formatNoMR($data['NOMR']); ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td align="center"><?php echo $data['TGL_LAHIR']; ?></td>
            <td><?php echo $data['NAMA_RUANG']; ?></td>
			<td align="center">
				<?php echo $data['SEBELUM_TINDAKAN']; ?></td>
			</td>
			<td align="center">
				<?php echo $data['SEBELUM_PEMBERIAN_OBAT']; ?></td>
			</td>
			<td align="center">
				<?php echo $data['SEBELUM_PENGAMBILAN_SAMPLE']; ?></td>
			</td>
			<td align="center">
				<?php echo $data['SEBELUM_PEMBERIAN_NUTRISI']; ?></td>
			</td>
			<td align="center">
				<?php echo $data['SEBELUM_TRANSFUSI']; ?></td>
			<!--<td><?php echo $data['PENGUMPUL_DATA']; ?></td>-->
        </tr>
        <?
    $no++; }
    ?>
</table>
