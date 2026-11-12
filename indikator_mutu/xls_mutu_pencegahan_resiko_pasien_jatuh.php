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

$qry_pasien = 'SELECT rsj.PASIEN_JATUH_ID,
			DATE_FORMAT(rsj.TANGGAL,"%d/%m/%Y") AS TANGGAL,
			rsj.RAWAT_ID,psn.NOMR,psn.NAMA_PASIEN,
			rsj.RUANG_ID,
			CONCAT(un.NAMA_RUANG,"-",un.KELAS_RAWAT) AS NAMA_RUANG,
			rsj.ASSESMENT,rsj.GRADING,
			CASE WHEN rsj.GELANG_KUNING = "1" THEN "Ya"
				WHEN rsj.GELANG_KUNING = "2" THEN "Tdk"
				WHEN rsj.GELANG_KUNING = "3" THEN "NA"
			END AS GELANG_KUNING,
			CASE WHEN rsj.SEGITIGA_KUNING = "1" THEN "Ya"
				WHEN rsj.SEGITIGA_KUNING = "2" THEN "Tdk"
				WHEN rsj.SEGITIGA_KUNING = "3" THEN "NA"
			END AS SEGITIGA_KUNING,
			CASE WHEN rsj.PAGAR_TT = "1" THEN "Ya"
				WHEN rsj.PAGAR_TT = "2" THEN "Tdk"
				WHEN rsj.PAGAR_TT = "3" THEN "NA"
			END AS PAGAR_TT,
			CASE WHEN rsj.EDUKASI = "1" THEN "Ya"
				WHEN rsj.EDUKASI = "2" THEN "Tdk"
				WHEN rsj.EDUKASI = "3" THEN "NA"
			END AS EDUKASI,
			CASE WHEN rsj.JATUH = "1" THEN "Ya"
				WHEN rsj.JATUH = "2" THEN "Tdk"
				WHEN rsj.JATUH = "3" THEN "NA"
			END AS JATUH,
			rsj.PENGUMPUL_DATA
			FROM db_repository.mutu_pencegahan_resiko_pasien_jatuh rsj
			INNER JOIN db_simrs.t_irna irn ON (irn.IRNA_ID = rsj.RAWAT_ID) 
			INNER JOIN db_simrs.m_pasien psn ON (irn.NOMR = psn.NOMR) 
			LEFT JOIN db_simrs.m_ruang un ON (un.RUANG_ID = rsj.RUANG_ID)	
			WHERE STR_TO_DATE(DATE_FORMAT(rsj.TANGGAL,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . '
			AND STR_TO_DATE(DATE_FORMAT(rsj.TANGGAL,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2;

if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_pasien = $qry_pasien . ' AND CONCAT(psn.NOMR,psn.NAMA_PASIEN) LIKE "%' . $searchkey . '%" ';
}
if (!empty($ruang_id)) {
    $qry_pasien = $qry_pasien . ' AND un.BANGSAL = "' . $ruang_id . '" ';
}	
$qry_pasien = $qry_pasien . 'ORDER BY rsj.PASIEN_JATUH_ID';
?>
<table border="1" >
	<tr>
		<th colspan="12">Pencegahan Resiko Pasien Jatuh Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>
    <tr>
        <th rowspan="2">No</th>
		<th rowspan="2">Tanggal</th>
        <th rowspan="2">Nomor MR</th>
        <th rowspan="2">Nama Pasien</th>
        <th rowspan="2">Ruang Rawat</th>
		<th rowspan="2">Assesment<br />Jatuh Awal</br >dan Ulang</th>
		<th rowspan="2">Grading<br />Resiko</br >Jatuh</th>
        <th colspan="4">Pencegahan Jatuh</th>
		<th rowspan="2">Jatuh</th>
		<!--<th rowspan="2" width="100px">Register</th>-->
    </tr>
    <tr>
      <th>Gelang<br />Kuning</th>
      <th>Segitiga<br />Kuning</th>
	  <th>Pagar<br />Tmp Tidur</th>
	  <th>Edukasi</th>
    </tr>
    <?
    $no = 0;
	$rs = mysql_query($qry_pasien) or die(mysql_error());
     while ($data = mysql_fetch_array($rs)) {
        ?>
        <tr>
            <td align="center"><?php echo $no + 1; ?></td>
            <td align="center"><?php echo $data['TANGGAL']; ?></td>
            <td align="center"><?php echo formatNoMR($data['NOMR']); ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td><?php echo $data['NAMA_RUANG']; ?></td>
			<td><?php echo $data['ASSESMENT']; ?></td>
			<td><?php echo $data['GRADING']; ?></td>
			<td align="center">
				<?php echo $data['GELANG_KUNING']; ?></td>
			</td>
			<td align="center">
				<?php echo $data['SEGITIGA_KUNING']; ?></td>
			</td>
			<td align="center">
				<?php echo $data['PAGAR_TT']; ?></td>
			</td>
			<td align="center">
				<?php echo $data['EDUKASI']; ?></td>
			</td>
			<td align="center">
				<?php echo $data['JATUH']; ?></td>
			</td>
			<!--<td><?php echo $data['PENGUMPUL_DATA']; ?></td>-->
        </tr>
        <?
    $no++; }
    ?>
</table>
