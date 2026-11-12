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

$connect = mysql_connect($hostname_8, $username_8, $password_8) or die(mysql_error());
mysql_select_db($database_8, $connect) or die(mysql_error());
$qry_kunjungan = 'SELECT * FROM (
	SELECT "1" AS DAFTAR,d.DAFTAR_ID,d.CUSTOMER_ID,d.MEMBER_ID,
	m.NOMR,m.NAMA_PASIEN,m.TMP_LAHIR,
	DATE_FORMAT(m.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,
	m.AGAMA,m.JNS_KELAMIN,m.NAMA_IBU,m.ALAMAT,m.RD_NOMR,
	m.NO_CONTACT,m.EMAIL,
	DATE_FORMAT(d.TGL_RENCANA_KUNJUNGAN,"%d-%m-%Y") AS TGL_RENCANA_KUNJUNGAN,
	61 AS KLINIK_ID,d.MCU_ID,d.DOKTER AS DOKTER_ID,
	"1" CARA_BAYAR,d.JAM_LAYANAN,d.NO_ANTRIAN,d.ST_BAYAR,
	DATE_FORMAT(d.TGL_DAFTAR,"%d-%m-%Y") AS TGL_DAFTAR,
	d.USER_VERIFIKASI,"" AS USER_KASIR_VERIFIKASI
	FROM t_daftar_mcu d
	INNER JOIN m_customer c
	ON (d.CUSTOMER_ID = c.CUSTOMER_ID)
	INNER JOIN m_customer_member m
	ON (d.MEMBER_ID = m.MEMBER_ID)
	WHERE DATE(d.TGL_RENCANA_KUNJUNGAN) >= ' . $tgl_filter_1 . ' 
	AND DATE(d.TGL_RENCANA_KUNJUNGAN) <= ' . $tgl_filter_2 . '
	UNION ALL
	SELECT "2" AS DAFTAR,d.DAFTAR_ID,d.CUSTOMER_ID,d.MEMBER_ID,
	m.NOMR,m.NAMA_PASIEN,m.TMP_LAHIR,
	DATE_FORMAT(m.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,
	m.AGAMA,m.JNS_KELAMIN,m.NAMA_IBU,m.ALAMAT,m.RD_NOMR,
	m.NO_CONTACT,m.EMAIL,
	DATE_FORMAT(d.TGL_RENCANA_KUNJUNGAN,"%d-%m-%Y") AS TGL_RENCANA_KUNJUNGAN,
	UNIT AS KLINIK_ID,"" AS MCU_ID,d.DOKTER AS DOKTER_ID,
	d.PEMBAYARAN AS CARA_BAYAR,d.JAM_LAYANAN,d.NO_ANTRIAN,d.ST_BAYAR,
	DATE_FORMAT(d.TGL_DAFTAR,"%d-%m-%Y") AS TGL_DAFTAR,
	d.USER_VERIFIKASI,d.USER_KASIR_VERIFIKASI
	FROM t_daftar_rj d
	INNER JOIN m_customer c
	ON (d.CUSTOMER_ID = c.CUSTOMER_ID)
	INNER JOIN m_customer_member m
	ON (d.MEMBER_ID = m.MEMBER_ID)
	WHERE DATE(d.TGL_RENCANA_KUNJUNGAN) >= ' . $tgl_filter_1 . ' 
	AND DATE(d.TGL_RENCANA_KUNJUNGAN) <= ' . $tgl_filter_2 . '
	) t_daftar WHERE 1 ';
	
if (!empty($unit_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_daftar.KLINIK_ID = "' . $unit_id . '"';
}
if (!empty($jaminan_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_daftar.CARA_BAYAR = "' . $jaminan_id . '"';
}
if (!empty($nama_pasien)) {
    $qry_kunjungan = $qry_kunjungan . ' AND (t_daftar.NAMA_PASIEN LIKE "%' . $nama_pasien . '%" OR t_daftar.NOMR = "%' . $nama_pasien . '%")';
}

if (!empty($ruang_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND m_ruang.BANGSAL = "' . $ruang_id . '"';
}

$qry_kunjungan = $qry_kunjungan . 'ORDER BY t_daftar.NAMA_PASIEN';
?>
<table border="1" >
	<tr>
		<th colspan="15">Laporan Pasien SIIJAPIN Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>
    <tr>
     <th rowspan="2">No</th>
        <th colspan="2">Tanggal</th>
		<th rowspan="2">Nomor MR</th>
        <th rowspan="2">Nama Pasien</th>
        <th rowspan="2">Tanggal Lahir</th>
        <th rowspan="2">Jenis Kelamin</th>
        <th rowspan="2">Alamat</th>
		<th rowspan="2">No Telepon</th>
		<th rowspan="2">Email</th>
        <th rowspan="2">Klinik/Unit</th>
		<th rowspan="2">Dokter</th>
		<th rowspan="2">Paket MCU</th>
		<th rowspan="2">Estimasi<br />Dilayani</th>
        <th rowspan="2">Pembayaran</th>
		<th rowspan="2">Status</th>
		<th rowspan="2">Register</th>
		
  </tr>
  <tr>
		<th>Daftar<br />Online </th>		
		<th>Rencana<br />Kunjungan</th>
    </tr>
    <?
    $no = 1; 
	$rs = mysql_query($qry_kunjungan) or die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
	?>
	<tr>
	<td scope="row" align="center"><?php echo $no; ?></td>
	 <td align="center"><?php echo $data['TGL_DAFTAR']; ?></td>
			<td align="center"><?php echo $data['TGL_RENCANA_KUNJUNGAN']; ?></td>
            <td align="center"><?php if($data['NOMR'] == ''){
							if($data['RD_NOMR'] == '2') echo 'Lupa NOMR';
							if($data['RD_NOMR'] == '3') echo 'Pasien Baru';
						}else{
							echo formatNoMR($data['NOMR']); 
						} ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td align="center"><?php echo $data['TGL_LAHIR']; ?></td>
            <td><?php echo jenisKelamin($data['JNS_KELAMIN']); ?></td>
            <td><?php echo $data['ALAMAT']; ?></td>
			<td><?php $no_telepon = $data['NO_CONTACT'];
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
					echo '<div onclick="openwhatsapp(' . $no_telepon_baru . ');"><img src="image/whatsapp.png" width="15" height="15" style="float:left;">&nbsp;' . $no_telepon . '</div>';	
				}else{
					echo $no_telepon;
				} ?></td>
			<td><?php $arr_email = explode('@',$data['EMAIL']);
					if(sizeof($arr_email) == '2'){
						echo $arr_email[0] . '<br />@' . $arr_email[1];
					}else{
						$data['EMAIL'];	
					} ?></td>	
            <td><?php echo ((isset($arr_unit[$data['KLINIK_ID']])) ? $arr_unit[$data['KLINIK_ID']] : ''); ?></td>
			<td><?php echo ((isset($arr_dokter[$data['DOKTER_ID']])) ? $arr_dokter[$data['DOKTER_ID']] : ''); ?></td>
			<td><?php echo ((isset($arr_mcu[$data['MCU_ID']])) ? $arr_mcu[$data['MCU_ID']] : ''); ?></td>
            <td><?php echo $data['JAM_LAYANAN'] . '/ ' . $data['NO_ANTRIAN']; ?></td>
			<td><?php echo ((isset($arr_jaminan[$data['CARA_BAYAR']])) ? $arr_jaminan[$data['CARA_BAYAR']] : ''); ?></td>
			<td><?php if($data['CARA_BAYAR'] == '1'){ 
					if($data['ST_BAYAR'] == '1') echo 'Lunas'; 
					if($data['ST_BAYAR'] == '') echo 'Menunggu Bayar'; 
				}else{
					echo 'Lunas';
			}?></td>
			<td><?php if(currentModul() == 'pendaftaran' or currentModul() == 'ipapp') echo $data['USER_VERIFIKASI'];
					if(currentModul() == 'kasir') echo $data['USER_KASIR_VERIFIKASI'];
			?></td>
			</tr>
        <?
    $no++; }
    ?>
</table>
