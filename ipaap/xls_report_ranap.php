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
$jaminan_id = '';
if (isset($_POST['jaminan_id']))
    $jaminan_id = $_POST['jaminan_id'];
$ruang_id = '';
if (isset($_POST['ruang_id']))
    $ruang_id = $_POST['ruang_id'];

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}	

$qry_kunjungan = 'SELECT t_irna.IRNA_ID, t_irna.NOMR,
	DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d-%m-%Y") AS PASIEN_MASUK,
	DATE_FORMAT(t_irna.PASIEN_KELUAR,"%d-%m-%Y") AS PASIEN_KELUAR,
	m_ruang.NAMA_RUANG,
	m_jaminan.NAMA_JAMINAN,
	t_irna_kontrol.TGL_KONTROL,
	t_irna.NO_TMP_TIDUR,
	t_irna.NO_PESERTA,
	m_pasien.NAMA_PASIEN,
	DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,
	m_pasien.JNS_KELAMIN,
	m_pasien.ALAMAT,
	m_pasien.ALAMAT_RT,
	m_pasien.ALAMAT_RW,
	m_pasien.NAMA_IBU,
	m_pasien.NO_TELEPON,
	m_pegawai.NAMA_PEGAWAI,
	m_pasien_pulang.KET_PASIEN_PULANG,
	m_ruang.KELAS_RAWAT,
	t_irna.ST_PINDAH,
	m_kelurahan.NAMA_KELURAHAN,
	m_kecamatan.NAMA_KECAMATAN,
	m_kota.NAMA_KOTA
	FROM t_irna
	INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR) 
	LEFT JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
	LEFT JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
	LEFT JOIN t_irna_kontrol ON (t_irna.IRNA_ID = t_irna_kontrol.IRNA_KONTROL_ID)
	LEFT JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
	LEFT JOIN m_pasien_pulang ON (t_irna.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID)
	LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
	LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
	LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
	WHERE t_irna.NO_PENDAFTARAN IS NOT NULL 
	AND t_irna.ST_BATAL IS NULL	
	AND ((STR_TO_DATE(DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . '
	AND STR_TO_DATE(DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . ')
	OR t_irna.ST_PULANG IS NULL)';
	
if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_kunjungan = $qry_kunjungan . ' AND CONCAT(m_pasien.NOMR,m_pasien.NAMA_PASIEN) LIKE "%' . $searchkey . '%"';
}	
if (!empty($jaminan_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_irna.JENIS_BAYAR_ID = "' . $jaminan_id . '"';
}

if (!empty($ruang_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND m_ruang.BANGSAL = "' . $ruang_id . '"';
}

$qry_kunjungan = $qry_kunjungan . 'ORDER BY t_irna.IRNA_ID';
?>
<table border="1" >
	<tr>
		<th colspan="15">Laporan Pasien Rawat Inap Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>
    <tr>
    <th>No</th>
		<th>Masuk</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
        <th>Tanggal Lahir</th>
		<th>Tanggal Kontrol</th>
        <th>Jenis Kelamin</th>
		<th>Alamat</th>
		<th>No Telepon</th>
        <th>Pembayaran</th>
		<th>No Kartu</th>
		<th>Ruang</th>
		<th>Kelas</th>
		<th>Dokter</th>
		<th>Keluar</th>
		<th>Status Pulang</th>
  </tr>
    <?
    $no = 1; 
	$rs = mysql_query($qry_kunjungan) or die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
	?>
	<tr>
	<td scope="row" align="center"><?php echo $no; ?></td>
	 <td align="center"><?php echo $data['PASIEN_MASUK']; ?></td>
            <td align="center"><?php echo formatNoMR($data['NOMR']); ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td align="center"><?php echo changeDateFormat($data['TGL_LAHIR']); ?></td>
			<td align="center"><?php echo changeDateFormat($data['TGL_KONTROL']); ?></td>
            <td><?php echo jenisKelamin($data['JNS_KELAMIN']); ?></td>
			<td><?php $alamat = ''; 
				if($data['ALAMAT'] != '') $alamat .= $data['ALAMAT'];
				if($data['ALAMAT_RT'] != '') $alamat .= ' Rt.' . $data['ALAMAT_RT'];
				if($data['ALAMAT_RW'] != '') $alamat .= ' Rw.' . $data['ALAMAT_RW'];
				if($data['NAMA_KELURAHAN'] != '') $alamat .= ' ' . $data['NAMA_KELURAHAN'];
				if($data['NAMA_KECAMATAN'] != '') $alamat .= ' ' . $data['NAMA_KECAMATAN'];
				if($data['NAMA_KOTA'] != '') $alamat .= ' ' . $data['NAMA_KOTA'];
				echo $alamat; ?></td>
			<td><?php 
			$no_telepon = $data['NO_TELEPON'];
			$no_telepon_baru = '';
			if(strlen($no_telepon) >= 10){
				if(substr($no_telepon,0,2) == '08'){
					$no_telepon_baru = '628' . substr($no_telepon,2,strlen($no_telepon) - 2);
				}else if(substr($no_telepon,0,4) == '+628'){
					$no_telepon_baru = substr($no_telepon,1,strlen($no_telepon) - 1);	
				}else{
					$no_telepon_baru = $no_telepon;
				}	
			}	
			if(substr($no_telepon_baru,0,3) == '628'){
				echo $no_telepon;	
			}else{
				echo $no_telepon;
			}
			?></td>
            <td><?php echo $data['NAMA_JAMINAN']; ?></td>
			<td><?php echo $data['NO_PESERTA']; ?></td>
			<td><?php echo $data['NAMA_RUANG']; ?></td>
			<td align="center"><?php echo $data['KELAS_RAWAT']; ?></td>
			<td><?php echo $data['NAMA_PEGAWAI']; ?></td>
			<td align="center"><?php echo $data['PASIEN_KELUAR']; ?></td>
			<td><?php echo $data['KET_PASIEN_PULANG']; ?></td>
  </tr>
        <?
    $no++; }
    ?>
</table>
