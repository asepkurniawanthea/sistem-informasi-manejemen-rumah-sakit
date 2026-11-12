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

$connect = mysql_connect($hostname_4, $username_4, $password_4) or die(mysql_error());
mysql_select_db($database_4, $connect) or die(mysql_error());

$qry_antrian = 'SELECT TRANS_ID,DATE_FORMAT(PRINT_TIME,"%H:%i:%s") AS JAM_DATANG,
                DATE_FORMAT(CALL_TIME,"%H:%i:%s") AS JAM_PANGGIL, WAITING_TIME,
                DATE_format(PRINT_TIME,"%d/%m/%Y") AS TGL_DATANG,
                KODE_COUNTER,CONCAT(NO_ANTRIAN_GROUP,"-",NO_ANTRIAN) AS NO_ANTRI,
                TIMEDIFF(CALL_TIME,PRINT_TIME) AS RESPONSE_TIME_TPP,
                NAMA_USER FROM t_trans WHERE NO_SHOW IS NULL AND SKIP IS NULL AND 
				DATE(PRINT_TIME) >= ' . $tgl_filter_1 . ' AND DATE(PRINT_TIME) <= ' . $tgl_filter_2 . '';

if (!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_antrian = $qry_antrian . ' AND NAMA_USER LIKE "%' . $searchkey . '%" ';
}	

$qry_antrian = $qry_antrian . 'ORDER BY t_trans.NO_ANTRIAN_GROUP,NO_ANTRIAN';

$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2;
?>
<table border="1" >
	<tr>
		<th colspan="9">Waktu Tunggu Pendaftaran Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>
    <tr>
        <th>No</th>
		<th>Tanggal</th>
        <th>Nomor Antrian</th>
        <th>Kode Counter</th>
        <th>Nama Petugas</th>
		<th>Jam Ambil Antrian</th>
        <th>Jam Panggil Antrian</th>
		<th>Response Time TPP</th>
    </tr>
    <?
    $no = 0;
	$rs = mysql_query($qry_antrian) or die(mysql_error());
     while ($data = mysql_fetch_array($rs)) {
        $id = $data['TRANS_ID'];
        ?>
        <tr>
            <td align="center"><?php echo $no + 1; ?></td>
            <td align="center"><?php echo $data['TGL_DATANG']; ?></td>
            <td align="center"><?php echo $data['NO_ANTRI']; ?></td>
            <td align="center"><?php echo $data['KODE_COUNTER']; ?></td>
            <td>
                <?php 
                $kata = $data['NAMA_USER'];
                $nama_user = subStr($kata,11);
                echo $nama_user; 
                ?></td>
			<td align="center"><?php echo $data['JAM_DATANG']; ?></td>
			<td align="center"><?php echo $data['JAM_PANGGIL']; ?></td>
			<td align="center"><?php echo $data['RESPONSE_TIME_TPP']; ?></td>
        </tr>
        <?
    $no++; }
    ?>
</table>
