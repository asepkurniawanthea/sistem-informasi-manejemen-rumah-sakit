<?php
include('./config/config.php');
include('./shared/connect_db.php');
include('./shared/function.php');

$tgl_1 = $_POST['tgl_1'];
$tgl_2 = $_POST['tgl_2'];
$searchkey = $_POST['searchkey'];
$unit_id = $_POST['unit_id'];

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}	

$connect = mysql_connect($hostname_4, $username_4, $password_4) or die(mysql_error());
mysql_select_db($database_4, $connect) or die(mysql_error());

$arr_jam_datang = array();
$arr_jam_daftar = array();
$qry_antrian = 'SELECT cs.TRANS_ID, 
				DATE_FORMAT(cs.PRINT_TIME,"%H:%i:%s") AS JAM_DATANG,
				DATE_FORMAT(cs.TRANS_END_TIME,"%H:%i:%s") AS JAM_DAFTAR
				FROM t_trans cs
				WHERE DATE(cs.PRINT_TIME) >= ' . $tgl_filter_1 . ' 
				AND DATE(cs.PRINT_TIME) <= ' . $tgl_filter_2;
$get_antrian = mysql_query($qry_antrian) or die(mysql_error());
while($dat_antrian = mysql_fetch_array($get_antrian)){
	$arr_jam_datang[$dat_antrian['TRANS_ID']] = $dat_antrian['JAM_DATANG'];	
	$arr_jam_daftar[$dat_antrian['TRANS_ID']] = $dat_antrian['JAM_DAFTAR'];	
}	

$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
mysql_select_db($database, $connect) or die(mysql_error());

$qry_pasien = 'SELECT irj.IRJA_ID,irj.NOMR, 
				DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d/%m/%Y") AS TGL_MASUK,
				un.NAMA_UNIT,psn.NAMA_PASIEN,
				DATE_FORMAT(psn.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
				DATE_FORMAT(irj.TGL_TRANS,"%H:%i:%s") AS JAM_DAFTAR_SIMRS,
				DATE_FORMAT(irj.PASIEN_MASUK,"%H:%i:%s") AS JAM_DILAYANI_SIMRS,
				TIMEDIFF(irj.PASIEN_MASUK,irj.TGL_TRANS) AS RESPONSE_TIME_POLI,
				irj.ONLINE_ID
				FROM t_irja irj
				INNER JOIN m_pasien psn ON (irj.NOMR = psn.NOMR) 
				LEFT JOIN m_unit un ON (irj.UNIT_ID = un.UNIT_ID)	
				WHERE irj.NO_PENDAFTARAN IS NOT NULL AND irj.ST_BATAL IS NULL 
				AND irj.UNIT_ID <> 9
				AND irj.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND irj.TANGGAL_DAFTAR <= ' . $tgl_filter_2;

if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_pasien = $qry_pasien . ' AND CONCAT(psn.NOMR,psn.NAMA_PASIEN) LIKE "%' . $searchkey . '%" ';
}
if(!empty($unit_id)){
	$qry_pasien = $qry_pasien . ' AND irj.UNIT_ID = "' . $unit_id . '" ';
}	
$qry_pasien = $qry_pasien . 'ORDER BY irj.IRJA_ID';
?>
<table border="1" >
	<tr>
		<th colspan="9">Waktu Tunggu Rawat Jalan Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>
    <tr>
         <th>No</th>
		<th>Tanggal</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
        <th>Tanggal Lahir</th>
		<th>Unit - Klinik</th>
		<th>Jam Daftar</th>
        <th>Jam Dilayani</th>
		<th>Response Time Dokter</th>
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
			<td><?php echo $data['NAMA_UNIT']; ?></td>
			<td align="center"><?php if(isset($arr_jam_daftar[$data['ONLINE_ID']]) and $arr_jam_daftar[$data['ONLINE_ID']] != ''){
				echo $arr_jam_daftar[$data['ONLINE_ID']];
			}else{		
				echo $data['JAM_DAFTAR_SIMRS']; 
			} ?></td>
			<td align="center"><?php echo $data['JAM_DILAYANI_SIMRS']; ?></td>
			<td align="center"><?php if(isset($arr_jam_daftar[$data['ONLINE_ID']]) and $arr_jam_daftar[$data['ONLINE_ID']] != ''){
				$checkTime = strtotime($arr_jam_daftar[$data['ONLINE_ID']]);
				$loginTime = strtotime($data['JAM_DILAYANI_SIMRS']);
				$diff = $loginTime - $checkTime;
				$hours = floor($diff / 3600);
				$mins = floor($diff / 60 % 60);
				$secs = floor($diff % 60);
				echo sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
			}else{		
				echo $data['RESPONSE_TIME_POLI']; 
			} ?></td>
        </tr>
        <?
    $no++; }
    ?>
</table>
