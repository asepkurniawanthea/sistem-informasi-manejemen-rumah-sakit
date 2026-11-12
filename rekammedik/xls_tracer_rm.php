<?php
include('./config/config.php');
include('./shared/connect_db.php');
include('./shared/function.php');

$tgl_1 = '';
$tgl_2 = '';
$unit_id = '';
$ruang_id = '';
if (isset($_POST['tgl_1'])){
    $tgl_1 = $_POST['tgl_1'];
	$tgl_2 = $_POST['tgl_2'];
	$unit_id = $_POST['unit_id'];
	$ruang_id = $_POST['ruang_id'];
}   

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}	

$qry_kunjungan = 'SELECT t_rm_tracer.RM_TRACER_ID,t_irja.TANGGAL_DAFTAR,m_pasien.NOMR,m_pasien.NAMA_PASIEN,
				m_unit.NAMA_UNIT,t_rm_tracer.RM_KIRIM,t_rm_tracer.RM_USER_KIRIM,t_rm_tracer.RM_KETERANGAN_KIRIM,
				t_rm_tracer.IRJA_TERIMA,t_rm_tracer.IRJA_USER_TERIMA,t_rm_tracer.IRJA_KETERANGAN_TERIMA,
				m_ruang.NAMA_RUANG,
				t_rm_tracer.ADMS_TERIMA,t_rm_tracer.ADMS_USER_TERIMA,t_rm_tracer.ADMS_KETERANGAN_TERIMA,
				m_ruang2.NAMA_RUANG AS NAMA_RUANG_TERIMA,
				t_rm_tracer.RM_TERIMA,t_rm_tracer.RM_USER_TERIMA,
				t_rm_tracer.RM_KETERANGAN_TERIMA,m_pasien_pulang.KET_PASIEN_PULANG,
				m_pasien_pulang2.KET_PASIEN_PULANG AS KET_PASIEN_PULANG_RANAP,
				t_irja.PASIEN_KELUAR,t_irna.PASIEN_KELUAR AS PASIEN_KELUAR_RANAP
				FROM t_irja
				INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN t_rm_tracer ON (t_irja.IRJA_ID = t_rm_tracer.IRJA_ID)
				LEFT JOIN m_pasien_pulang ON (t_irja.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID)
				LEFT JOIN t_irna ON (t_irja.IRJA_ID = t_irna.IRNA_ID)
				LEFT JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				LEFT JOIN m_ruang m_ruang2 ON (t_rm_tracer.ADMS_TERIMA_RUANG_ID = m_ruang2.RUANG_ID)
				LEFT JOIN m_pasien_pulang m_pasien_pulang2 ON (t_irna.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID)
				WHERE 1 AND t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2;
	
if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_kunjungan = $qry_kunjungan . ' AND CONCAT(m_pasien.NOMR,m_pasien.NAMA_PASIEN) LIKE "%' . $searchkey . '%"';
}

if(!empty($unit_id)){
	$qry_kunjungan = $qry_kunjungan . ' AND t_irja.UNIT_ID = "' . $unit_id . '"';
}

if(!empty($ruang_id)){
	$qry_kunjungan = $qry_kunjungan . ' AND t_irna.RUANG_ID = "' . $ruang_id . '"';
}	

$qry_kunjungan = $qry_kunjungan . ' ORDER BY m_pasien.NAMA_PASIEN,m_pasien.NOMR';
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());	
?>
<table border="1" >
<tr>
	<th colspan="13" >Report Tracer RM Dr <?php echo $tgl_1; ?> Sd <?php echo $tgl_2; ?></th>
</tr>
  <tr>
    <th>No</th>
        <th>Tanggal Masuk</th>
		<th>Tanggal Keluar</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
		<th>RM Kirim</th>
		<th>Klinik</th>
        <th>Klinik Terima</th>
		<th>Pasien Pulang</th>
        <th>Ranap</th>
		<th>Ranap Terima</th>
		<th>Pasien Pulang</th>
        <th>RM Terima</th>
  </tr>
<?php $no = 1; 
while($data = mysql_fetch_array($get_kunjungan)){ ?>  
  <tr>
    <td scope="row" align="center"><?php echo $no; ?></td>
    <td align="center"><?php echo changeDateFormat($data['TANGGAL_DAFTAR']); ?></td>
			<td align="center"><?php if(!empty($data['IRNA_ID'])){ 
										echo changeDateFormat($data['PASIEN_KELUAR_RANAP']);
									}else{
										echo changeDateFormat($data['PASIEN_KELUAR']);
									} ?></td>
            <td align="center"><?php echo formatNoMR($data['NOMR']); ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td align="center"><?php echo $data['RM_KIRIM']; ?></td>
			<td><?php echo $data['NAMA_UNIT']; ?></td>
            <td align="center"><?php echo $data['IRJA_TERIMA']; ?></td>
			<td><?php echo $data['KET_PASIEN_PULANG']; ?></td>
			<td><?php echo $data['NAMA_RUANG']; ?></td>
			<td align="center"><?php echo $data['ADMS_TERIMA'] . '<br />' . $data['NAMA_RUANG_TERIMA']; ?></td>
			<td align="center"><?php echo $data['KET_PASIEN_PULANG_RANAP']; ?></td>
            <td align="center"><?php echo $data['RM_TERIMA']; ?></td>
  </tr>
 <?php $no++; } ?> 
</table>