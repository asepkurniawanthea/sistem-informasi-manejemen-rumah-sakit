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

$qry_pasien = 'SELECT irj.IRJA_ID,irj.NOMR, 
				DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d/%m/%Y") AS TGL_MASUK,
				DATE_FORMAT(irj.PASIEN_KELUAR,"%d/%m/%Y") AS TGL_KELUAR,
				un.NAMA_UNIT,psn.NAMA_PASIEN,
				DATE_FORMAT(psn.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
				DATE_FORMAT(irj.JAM_TRIAGE,"%d/%m/%Y %H:%i:%s") AS JAM_DATANG_SIMRS,
				DATE_FORMAT(irj.PASIEN_MASUK,"%d/%m/%Y %H:%i:%s") AS JAM_DILAYANI_SIMRS,
				TIMEDIFF(irj.PASIEN_MASUK,irj.JAM_TRIAGE) AS RESPONSE_TIME_SIMRS
				FROM db_simrs.t_irja irj
				INNER JOIN db_simrs.m_pasien psn ON (irj.NOMR = psn.NOMR) 
				LEFT JOIN db_simrs.m_unit un ON (irj.UNIT_ID = un.UNIT_ID)	
				WHERE irj.NO_PENDAFTARAN IS NOT NULL AND irj.ST_BATAL IS NULL 
				AND irj.UNIT_ID = 9 
				AND irj.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND irj.TANGGAL_DAFTAR <= ' . $tgl_filter_2;

if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_pasien = $qry_pasien . ' AND CONCAT(psn.NOMR,psn.NAMA_PASIEN) LIKE "%' . $searchkey . '%" ';
}	
$qry_pasien = $qry_pasien . 'ORDER BY irj.IRJA_ID';
?>
<table border="1" >
	<tr>
		<th colspan="8">Emergency Response Time Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>
    <tr>
        <th>No</th>
		<th>Tanggal</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
        <th>Tanggal Lahir</th>
        <th>Jam Datang</th>
        <th>Jam Dilayani</th>
		<th>Response Time</th>
    </tr>
    <?
    $no = 0;
	$rs = mysql_query($qry_pasien) or die(mysql_error());
     while ($data = mysql_fetch_array($rs)) {
        $id = $data['IRJA_ID'];
        ?>
        <tr>
            <td align="center"><?php echo $no + 1; ?></td>
            <td align="center"><?php echo $data['TGL_MASUK']; ?></td>
            <td align="center"><?php echo formatNoMR($data['NOMR']); ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td align="center"><?php echo $data['TGL_LAHIR']; ?></td>
            <td align="center"><?php echo $data['JAM_DATANG_SIMRS']; ?></td>
			<td align="center"><?php echo $data['JAM_DILAYANI_SIMRS']; ?></td>
			<td align="center"><?php echo $data['RESPONSE_TIME_SIMRS']; ?></td>
        </tr>
        <?
    $no++; }
    ?>
</table>
