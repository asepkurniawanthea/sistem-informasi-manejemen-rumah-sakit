<?php
include('./config/config.php');
include('./shared/connect_db.php');
include('./shared/function.php');

$tgl_1 = $_POST['tgl_1'];
$tgl_2 = $_POST['tgl_2'];
$dokter_id = $_POST['dokter_id'];
$ruang_id = $_POST['ruang_id'];

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}	

$qry_pasien = 'SELECT vst.VISIT_DOKTER_ID, 
				DATE_FORMAT(vst.TANGGAL,"%d/%m/%Y") AS TANGGAL,
				DATE_FORMAT(vst.TANGGAL,"%H:%i") AS JAM,
				pgw.NAMA_PEGAWAI AS NAMA_DOKTER,
				rng.NAMA_RUANG,
				vst.KETERANGAN
				FROM db_repository.mutu_kepatuhan_jam_visit_dokter vst
				INNER JOIN db_simrs.m_pegawai pgw ON (vst.PEGAWAI_ID = pgw.PEGAWAI_ID)
				INNER JOIN db_simrs.m_ruang rng ON (vst.RUANG_ID = rng.RUANG_ID)
				WHERE STR_TO_DATE(DATE_FORMAT(vst.TANGGAL,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . '
				AND STR_TO_DATE(DATE_FORMAT(vst.TANGGAL,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2;	
if (!empty($ruang_id)) {
    $qry_pasien = $qry_pasien . ' AND rng.BANGSAL = "' . $ruang_id . '" ';
}
if (!empty($dokter_id)) {
    $qry_pasien = $qry_pasien . ' AND vst.PEGAWAI_ID = "' . $dokter_id . '" ';
}

$qry_pasien = $qry_pasien . ' ORDER BY vst.TANGGAL';
?>
<table border="1" >
	<tr>
		<th colspan="7">Visit Dokter Spesialis Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>
    <tr>
        <th rowspan="2">No</th>
		<th rowspan="2">Tanggal</th>
        <th rowspan="2">Unit - Ruang</th>
		<th rowspan="2">Nama Dokter</th>
		<th colspan="2">Waktu Visite</th>
		<th rowspan="2">Keterangan</th>
    </tr>
	  <tr>
      <th>< 11.00</th>
	  <th>> 11.00</th>
    </tr>
    <?
    $no = 0;
	$rs = mysql_query($qry_pasien) or die(mysql_error());
     while ($data = mysql_fetch_array($rs)) {
        ?>
        <tr>
            <td align="center"><?php echo $no + 1; ?></td>
            <td align="center"><?php echo $data['TANGGAL']; ?></td>
            <td><?php echo $data['NAMA_RUANG']; ?></td>
			<td><?php echo $data['NAMA_DOKTER']; ?></td>
			<?php
			$jam_visite_1 = '';
			$jam_visite_2 = '';
			$arr_waktu_visite = explode(':',$data['JAM']);
			if(sizeof($arr_waktu_visite) == 2){
				$waktu_visite = ($arr_waktu_visite[0] * 60) + $arr_waktu_visite[1];
				if($waktu_visite <= 660) $jam_visite_1 =  $data['JAM'];	
				if($waktu_visite > 660) $jam_visite_2 =  $data['JAM'];	
			}	
		?>	
        <td align="center"><?php echo $jam_visite_1; ?></td>
		<td align="center"><?php echo $jam_visite_2; ?></td>
        <td><?php echo $data['KETERANGAN']; ?></td>
        </tr>
        <?
    $no++; }
    ?>
</table>
