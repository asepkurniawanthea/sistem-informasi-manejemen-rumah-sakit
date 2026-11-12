<?php
include('./config/config.php');
include('./shared/connect_db.php');
include('./shared/function.php');

$tgl_1 = $_POST['tgl_1'];
$tgl_2 = $_POST['tgl_2'];

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}	

$qry_pasien = 'SELECT mkf.KEPATUHAN_FORMULARIUM_ID,
				mkf.RAWAT_ID,mkf.NOMR,
				mkf.FORMULARIUM,mkf.NON_FORMULARIUM,
				DATE_FORMAT(mkf.TANGGAL,"%d/%m/%Y") AS TANGGAL,
				mkf.KETERANGAN,mkf.PENGUMPUL_DATA
				FROM db_repository.mutu_kepatuhan_formularium mkf
				WHERE STR_TO_DATE(DATE_FORMAT(mkf.TANGGAL,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . '
				AND STR_TO_DATE(DATE_FORMAT(mkf.TANGGAL,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2;
?>
<table border="1" >
	<tr>
		<th colspan="6">Kepatuhan Penggunaan Formularium Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	<tr>
        <th rowspan="2">No</th>
		<th rowspan="2">Tanggal</th>
		<th rowspan="2">Nomor MR</th>
        <th colspan="2">Kepatuhan Formularium Nas/ RS</th>
		<th rowspan="2">Keterangan</th> 
	</tr>
    <tr>
      <th>Sesuai Formularium Nas/ RS</th>
      <th>Tidak Sesuai Formularium Nas/ RS</th>
    </tr>
    <?
    $no = 0;
	$rs = mysql_query($qry_pasien) or die(mysql_error());
     while ($data = mysql_fetch_array($rs)) {
        ?>
        <tr>
            <td align="center"><?php echo $no + 1; ?></td>
             <td align="center"><?php echo $data['TANGGAL']; ?></td>
			<td><?php echo formatNomr($data['NOMR']); ?></td>
			<td align="right"><?php echo currFormat($data['FORMULARIUM']); ?></td>
			<td align="right"><?php echo currFormat($data['NON_FORMULARIUM']); ?></td>
			<td><?php echo $data['KETERANGAN']; ?></td>
        </tr>
        <?
    $no++; }
    ?>
</table>
