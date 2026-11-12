<?php
include('./config/config.php');
include('./shared/connect_db.php');
include('./shared/function.php');

$tgl_1 = '';
if (isset($_POST['tgl_1'])) $tgl_1 = $_GET['tgl_1'];
$tgl_2 = '';    
if (isset($_GET['tgl_2'])) $tgl_2 = $_GET['tgl_2'];
$nama = '';
if (isset($_POST['nama'])) $nama = $_POST['nama'];

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
$qry_kunjungan = 'SELECT d.DAFTAR_ID,
	d.CUSTOMER_ID,
	d.MEMBER_ID,
	d.NAMA_PASIEN,
	d.TMP_LAHIR,
	DATE_FORMAT(d.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,
	d.JNS_KELAMIN,
	d.ALAMAT,
	d.PEKERJAAN,
	DATE_FORMAT(d.TGL_RENCANA_KUNJUNGAN,"%d-%m-%Y") AS TGL_RENCANA_KUNJUNGAN,
	d.NO_CONTACT,
	d.NIK,
	DATE_FORMAT(d.TGL_DAFTAR,"%d-%m-%Y") AS TGL_DAFTAR,
	d.ST_SELESAI,
	d.REGISTER
	FROM t_daftar_vaksin_online d
	WHERE DATE(d.TGL_RENCANA_KUNJUNGAN) >= ' . $tgl_filter_1 . 
	' AND DATE(d.TGL_RENCANA_KUNJUNGAN) <= ' . $tgl_filter_2;
	
if (!empty($nama)) {
    $qry_kunjungan = $qry_kunjungan . ' AND CONCAT(d.NAMA_PASIEN,d.NO_CONTACT,d.NIK) LIKE "%' . $nama . '%"';
}
$qry_kunjungan = $qry_kunjungan . ' ORDER BY d.NAMA_PASIEN';
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());	
?>
<table border="1" >
<tr>
	<th colspan="13" >Pendaftaran Mandiri Vaksin Dr <?php echo $tgl_1; ?> Sd <?php echo $tgl_2; ?></th>
</tr>
      <tr>
        <th rowspan="2">No</th>
        <th colspan="2">Tanggal</th>
        <th rowspan="2">Nama</th>
		<th rowspan="2">Tmp Lahir</th>
        <th rowspan="2">Tgl Lahir</th>
        <th rowspan="2">Jns Kelamin</th>
        <th rowspan="2">Alamat</th>
		<th rowspan="2">No Telepon</th>
		<th rowspan="2">No KTP</th>
		<th rowspan="2">Pekerjaan</th>
		<th rowspan="2">Status</th>
		<th rowspan="2">Register</th>
    </tr>
    <tr>
		<th>Daftar<br />Online </th>		
		<th>Rencana<br />Divaksin</th>
    </tr>
<?php $no = 1; 
while($data = mysql_fetch_array($get_kunjungan)){ ?>  
  <tr>
  <td scope="row" align="center"><?php echo $no; ?></td>
   	<td align="center"><?php echo $data['TGL_DAFTAR']; ?></td>
			<td align="center"><?php echo $data['TGL_RENCANA_KUNJUNGAN']; ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
			<td><?php echo $data['TMP_LAHIR']; ?></td>
            <td align="center"><?php echo $data['TGL_LAHIR']; ?></td>
            <td><?php echo jenisKelamin($data['JNS_KELAMIN']); ?></td>
            <td><?php echo $data['ALAMAT']; ?></td>
			<td>'<?php $no_telepon = $data['NO_CONTACT'];
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
				} ?></td>
			<td>'<?php echo $data['NIK']; ?></td>	
			<td><?php echo $data['PEKERJAAN']; ?></td>
            <td><?php if($data['ST_SELESAI'] == '1') echo 'Selesai'; ?></td>
			<td><?php echo $data['REGISTER']; ?></td>
  </tr>
 <?php $no++; } ?> 
</table>