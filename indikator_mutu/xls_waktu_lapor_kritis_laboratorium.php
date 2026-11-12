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

$qry_pasien = 'SELECT mlb.WAKTU_LAPOR_ID,mlb.RAWAT_ID,mlb.NOMR,mlb.NO_TARIF,
			mlb.FORM_HASIL,DATE_FORMAT(mlb.TGL_HASIL,"%d/%m/%Y") AS TGL_HASIL,
			CASE WHEN TIME_TO_SEC(
				TIMEDIFF(mlb.TGL_LAPOR,mlb.TGL_HASIL)
			) <= 1800 THEN TIMEDIFF(mlb.TGL_LAPOR,mlb.TGL_HASIL) END AS WL_30,
			CASE WHEN TIME_TO_SEC(
				TIMEDIFF(mlb.TGL_LAPOR,mlb.TGL_HASIL)
			) > 1800 THEN TIMEDIFF(mlb.TGL_LAPOR,mlb.TGL_HASIL) END AS WL_31,
			mlb.PENGUMPUL_DATA,mlb.KETERANGAN
			FROM db_repository.mutu_waktu_lapor_hasil_laboratorium mlb
			WHERE STR_TO_DATE(DATE_FORMAT(mlb.TGL_LAPOR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . '
			AND STR_TO_DATE(DATE_FORMAT(mlb.TGL_LAPOR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2;

if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_pasien = $qry_pasien . ' AND CONCAT(t_lab.NOMR,t_lab.NAMA_PASIEN) LIKE "%' . $searchkey . '%" ';
}
	
$qry_pasien = $qry_pasien . ' ORDER BY mlb.NO_TARIF';
?>
<table border="1" >
	<tr>
		<th colspan="6">Waktu Lapor Hasil Kritis Laboratorium Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>
    <tr>
        <th rowspan="2">No</th>
		<th rowspan="2">Tanggal</th>
        <th rowspan="2">Nomor MR</th>
        <th colspan="2">Waktu Tunggu</th>
		<th rowspan="2">Keterangan</th>
    </tr>
    <tr>
      <th><= 30 menit</th>
      <th>> 30 menit</th>
    </tr>
    <?
    $no = 0;
	$rs = mysql_query($qry_pasien) or die(mysql_error());
     while ($data = mysql_fetch_array($rs)) {
        ?>
        <tr>
            <td align="center"><?php echo $no + 1; ?></td>
            <td align="center"><?php echo $data['TGL_HASIL']; ?></td>
            <td align="center"><?php if(strlen($data['NOMR']) == 6) {
					echo formatNoMR($data['NOMR']);
				}else{
					echo $data['NOMR'];
				}?></td>
            <td align="center"><?php echo $data['WL_30']; ?></td>
			<td align="center"><?php echo $data['WL_31']; ?></td>
			<td><?php echo $data['KETERANGAN']; ?></td>
        </tr>
        <?
    $no++; }
    ?>
</table>
