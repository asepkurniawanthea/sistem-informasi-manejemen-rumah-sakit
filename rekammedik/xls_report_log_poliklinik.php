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

$searchkey = '';
if (isset($_POST['searchkey']))
		$searchkey = $_POST['searchkey'];

$pegawai_id = '';
if (isset($_POST['pegawai_id']))
		$pegawai_id = $_POST['pegawai_id'];

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}	

$qry_kunjungan = 'SELECT * FROM (SELECT t_irja.IRJA_ID AS LOG_ID, t_irja.NOMR, t_irja.TANGGAL_DAFTAR,
	m_pasien.NAMA_PASIEN,t_irja.USER_IRJA AS PETUGAS,t_irja.ST_BATAL,
	CASE WHEN t_irja.UNIT_ID = 9 THEN "IGD" ELSE CONCAT("Rawat Jalan", " (",m_unit.NAMA_UNIT,")") END AS NAMA_PELAYANAN,
	m_pegawai.NAMA_PEGAWAI
	FROM t_irja
	INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
	INNER JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)	
	LEFT JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
	WHERE t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL
	AND t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
	UNION	
	SELECT t_irna.IRNA_ID AS LOG_ID, t_irna.NOMR, t_irna.TANGGAL_DAFTAR,
	m_pasien.NAMA_PASIEN,t_irna.USER_IRNA AS PETUGAS,t_irna.ST_BATAL,CONCAT("Rawat Inap", " (",m_ruang.NAMA_RUANG,")") AS NAMA_PELAYANAN,
	m_pegawai.NAMA_PEGAWAI
	FROM t_irna
	INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR) 
	INNER JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
	LEFT JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
	WHERE t_irna.NO_PENDAFTARAN IS NOT NULL AND t_irna.ST_BATAL IS NULL
	AND t_irna.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND t_irna.TANGGAL_DAFTAR <= ' . $tgl_filter_2 .'
	) t_log WHERE 1';
	
if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_kunjungan = $qry_kunjungan . ' AND CONCAT(NOMR,NAMA_PASIEN) LIKE "%' . $searchkey . '%"';
}	
if (!empty($pegawai_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND PETUGAS LIKE "%' . $pegawai_id . '"';
}

$qry_kunjungan = $qry_kunjungan . ' ORDER BY TANGGAL_DAFTAR,NAMA_PASIEN';
?>
<table border="1">
	<tr>
        <th colspan="7">Report Log Poliklinik</th>
	</tr>	
    <tr>
        <th>No</th>
        <th>Tanggal Daftar</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
        <th>Jenis Rawat</th>
		<th>Dokter</th>
		<th width="160">Petugas Register</th>
    </tr>
    <?
    $no = 0;
    $rs = mysql_query($qry_kunjungan) or die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
        $id = $data['LOG_ID'];
        ?>
        <tr>
            <td align="center"><?
			$no = ($no + 1);
			echo $no;
        ?></td>
           <td align="center"><?php echo changeDateFormat($data['TANGGAL_DAFTAR']); ?></td>
            <td align="center"><?php echo formatNoMR($data['NOMR']); ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td><?php echo $data['NAMA_PELAYANAN']; ?></td>
			<td><?php echo $data['NAMA_PEGAWAI']; ?></td>
			<td><?php 
			$user_poliklinik_array = explode('|', $data['PETUGAS']);
			$user_poliklinik = $user_poliklinik_array[1];
			echo $user_poliklinik; ?></td>
        </tr>
        <?
    }
    ?>
</table>