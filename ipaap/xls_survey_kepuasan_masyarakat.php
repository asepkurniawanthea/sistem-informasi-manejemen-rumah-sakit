<?php
include('./config/config.php');
include('./shared/connect_db.php');
include('./shared/function.php');

$tgl_1 = '';
if (isset($_POST['tgl_1']))
    $tgl_1 = $_POST['tgl_1'];
$tgl_2 = '';
if (isset($_POST['tgl_1']))
    $tgl_2 = $_POST['tgl_2'];

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

$qry_survey = 'SELECT ID_SURVEY,DATE_FORMAT(TANGGAL,"%d-%m-%Y") AS TANGGAL,JNS_KELAMIN,UMUR,PEMBIAYAAN,POLIKLINIK_RUANG,
	SURVEY_1,SURVEY_2,SURVEY_3,SURVEY_4,SURVEY_5,SURVEY_6,SURVEY_7,SURVEY_8,SURVEY_9,SURVEY_10,UNIQ_STR
	FROM t_survey_kepuasan
	WHERE DATE(TANGGAL) >= ' . $tgl_filter_1 . '
	AND DATE(TANGGAL) <= ' . $tgl_filter_2 . '
	ORDER BY ID_SURVEY';
?>
<table border="1" >
	<tr>
		<th colspan="16">Survey Kepuasan Masyarakat Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>
    <tr>
        <th rowspan="2">No</th>
        <th rowspan="2">Tanggal</th>
        <th rowspan="2">Jns Kelamin</th>
        <th rowspan="2">Umur</th>
        <th rowspan="2">Pembiayaan</th>
        <th rowspan="2">Poliklinik/ Ruang</th>
		<th colspan="10">Survey</th>
    </tr>
	<tr>
		<th>1</th>
		<th>2</th>
		<th>3</th>
		<th>4</th>
		<th>5</th>
		<th>6</th>
		<th>7</th>
		<th>8</th>
		<th>9</th>
		<th>10</th>
	</tr>
    <?
    $no = 1; 
	$rs = mysql_query($qry_survey) or die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
	?>
	<tr>
	<td scope="row" align="center"><?php echo $no; ?></td>
	<td align="center"><?php echo $data['TANGGAL']; ?></td>
            <td><?php echo $data['JNS_KELAMIN']; ?></td>
			<td><?php echo $data['UMUR']; ?></td>
			<td><?php echo $data['PEMBIAYAAN']; ?></td>
			<td><?php echo $data['POLIKLINIK_RUANG']; ?></td>
			<td><?php echo $data['SURVEY_1']; ?></td>
			<td><?php echo $data['SURVEY_2']; ?></td>
			<td><?php echo $data['SURVEY_3']; ?></td>
			<td><?php echo $data['SURVEY_4']; ?></td>
			<td><?php echo $data['SURVEY_5']; ?></td>
			<td><?php echo $data['SURVEY_6']; ?></td>
			<td><?php echo $data['SURVEY_7']; ?></td>
			<td><?php echo $data['SURVEY_8']; ?></td>
			<td><?php echo $data['SURVEY_9']; ?></td>
			<td><?php echo $data['SURVEY_10']; ?></td>
  </tr>
        <?
    $no++; }
    ?>
</table>
