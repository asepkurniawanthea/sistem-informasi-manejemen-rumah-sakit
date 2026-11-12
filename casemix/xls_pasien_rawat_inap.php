<?php
include('./config/config.php');
include('./shared/connect_db.php');
echo $_GET[''];
include('./shared/function.php');

$tgl_1 = '';
if (isset($_SESSION['pendaftaransearchirna_tgl_1']))
    $tgl_1 = $_SESSION['pendaftaransearchirna_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['pendaftaransearchirna_tgl_1']))
    $tgl_2 = $_SESSION['pendaftaransearchirna_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['pendaftaransearchirna_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['pendaftaransearchirna_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['pendaftaransearchirna_searchkey']))
		$searchkey = $_SESSION['pendaftaransearchirna_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['pendaftaransearchirna_searchkey'] = $searchkey;
}
$ruang_id = '';
if (isset($_SESSION['pendaftaransearchirna_unit_id']))
		$ruang_id = $_SESSION['pendaftaransearchirna_unit_id'];

if (isset($_GET['unit_id'])) {
    $ruang_id = $_GET['unit_id'];
	$_SESSION['pendaftaransearchirna_unit_id'] = $ruang_id;
}
$jaminan_id = '';
if (isset($_SESSION['pendaftaransearchirna_jaminan_id']))
		$jaminan_id = $_SESSION['pendaftaransearchirna_jaminan_id'];

if (isset($_GET['jaminan_id'])) {
    $jaminan_id = $_GET['jaminan_id'];
	$_SESSION['pendaftaransearchirna_jaminan_id'] = $jaminan_id;
}
$shift_id = '';
if (isset($_SESSION['pendaftaransearchirna_shift_id']))
		$shift_id = $_SESSION['pendaftaransearchirna_shift_id'];

if (isset($_GET['shift_id'])) {
    $shift_id = $_GET['shift_id'];
	$_SESSION['pendaftaransearchirna_shift_id'] = $shift_id;
}
$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}	

$qry = 'SELECT t_irna.IRNA_ID, t_irna.NOMR, t_irna.TANGGAL_DAFTAR,
	m_ruang.NAMA_RUANG,m_jaminan.NAMA_JAMINAN,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NAMA_IBU,
	t_irna.USER_PENDAFTARAN,m_pasien_pulang.KET_PASIEN_PULANG,t_irna.ST_PULANG,t_irna.KELAS_RAWAT
	FROM t_irna
	INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR) 
	LEFT JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
	LEFT JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
	LEFT JOIN m_pasien_pulang ON (t_irna.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID) 
	WHERE t_irna.NO_PENDAFTARAN IS NOT NULL AND t_irna.ST_BATAL IS NULL
	AND (t_irna.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND t_irna.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . ')';
	
if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry = $qry . ' AND CONCAT(m_pasien.NOMR,m_pasien.NAMA_PASIEN) LIKE "%' . $searchkey . '%"';
}	
if (!empty($ruang_id)) {
    $qry = $qry . ' AND t_irna.RUANG_ID = "' . $ruang_id . '"';
}

if (!empty($jaminan_id)) {
    $qry = $qry . ' AND t_irna.JENIS_BAYAR_ID = "' . $jaminan_id . '"';
}

$qry = $qry . ' ORDER BY m_pasien.NAMA_PASIEN,m_pasien.NOMR';	
?>
<table width="100%" border="1" >
	<tr>
		<th colspan="13">Pasien Rawat Inap Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>	
	<tr>
        <th>No</th>
        <th>Tanggal Daftar</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
        <th>Tanggal Lahir</th>
        <th>Jenis Kelamin</th>
        <th>Nama Ibu</th>
        <th>Alamat</th>
        <th>Ruang</th>
		<th>Kelas</th>
        <th>Pembayaran</th>
		<th>Pulang</th>
		<th>Berkas Kembali</th>
    </tr>
	<?php $rs = mysql_query($qry) or die(mysql_error());
			$i = 1;
			while ($data = mysql_fetch_array($rs)) {
	?>
        <tr>
            <td align="center"><?php echo $i; ?></td>
            <td align="center"><?php echo changeDateFormat($data['TANGGAL_DAFTAR']); ?></td>
            <td align="center"><?php echo formatNoMR($data['NOMR']); ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td align="center"><?php echo changeDateFormat($data['TGL_LAHIR']); ?></td>
            <td><?php echo jenisKelamin($data['JNS_KELAMIN']); ?></td>
            <td><?php echo $data['NAMA_IBU']; ?></td>
            <td><?php echo $data['ALAMAT']; ?></td>
            <td><?php echo $data['NAMA_RUANG']; ?></td>
			<td align="center"><?php echo $data['KELAS_RAWAT']; ?></td>
			<td><?php echo $data['NAMA_JAMINAN']; ?></td>
			<td><?php if($data['ST_PULANG'] == '1') echo 'v'; ?></td>
			<td>&nbsp;</td>
        </tr>
	<?php $i++;
	} ?>	
</table>
