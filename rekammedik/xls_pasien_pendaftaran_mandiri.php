<?php
include('./config/config.php');
include('./shared/connect_db.php');
include('./shared/function.php');

$tgl_1 = '';
if (isset($_POST['tgl_1'])) $tgl_1 = $_GET['tgl_1'];
$tgl_2 = '';    
if (isset($_GET['tgl_2'])) $tgl_2 = $_GET['tgl_2'];
$unit_id = '';
if (isset($_POST['unit_id'])) $unit_id = $_POST['unit_id'];
$jaminan_id = '';
if (isset($_POST['jaminan_id'])) $jaminan_id = $_POST['jaminan_id'];
$verifikasi = '';
if (isset($_POST['verifikasi'])) $verifikasi = $_POST['verifikasi'];

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}	

$arr_unit = array();
$get_unit = mysql_query('SELECT * FROM m_unit') or die(mysql_error());
while($dat_unit = mysql_fetch_array($get_unit)){
		$arr_unit[$dat_unit['UNIT_ID']] = $dat_unit['NAMA_UNIT'];
}

$arr_jaminan = array();
$arr_jaminan[0] = '-';
$get_jaminan = mysql_query('SELECT * FROM m_jaminan') or die(mysql_error());
while($dat_jaminan = mysql_fetch_array($get_jaminan)){
		$arr_jaminan[$dat_jaminan['JAMINAN_ID']] = $dat_jaminan['NAMA_JAMINAN'];
}

$arr_dokter = array();
$get_dokter = mysql_query('SELECT * FROM m_pegawai') or die(mysql_error());
$arr_dokter[0] = '-';
while($dat_dokter = mysql_fetch_array($get_dokter)){
		$arr_dokter[$dat_dokter['PEGAWAI_ID']] = $dat_dokter['NAMA_PEGAWAI'];
}

$connect = mysql_connect($hostname_4, $username_4, $password_4) or die(mysql_error());
mysql_select_db($database_4, $connect) or die(mysql_error());	
$qry_kunjungan = 'SELECT * FROM (
				SELECT t_daftar_irja_online.DAFTAR_ID,t_daftar_irja_online.NOMR,
				t_daftar_irja_online.NAMA_PASIEN,DATE_FORMAT(t_daftar_irja_online.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,
				t_daftar_irja_online.JNS_KELAMIN,t_daftar_irja_online.ALAMAT,
				DATE_FORMAT(t_daftar_irja_online.TGL_RENCANA_KUNJUNGAN,"%d-%m-%Y") AS TGL_RENCANA_KUNJUNGAN,
				DATE_FORMAT(t_daftar_irja_online.TGL_DAFTAR,"%d-%m-%Y") AS TGL_DAFTAR_ONLINE,
				t_daftar_irja_online.KLINIK_ID,t_daftar_irja_online.CARA_BAYAR,t_daftar_irja_online.DOKTER_ID,
				t_daftar_irja_online.PASIEN_BARU,
				t_daftar_irja_online.KODE_VERIFIKASI,
				t_daftar_irja_online.YANKES,
				t_daftar_irja_online.JAM_LAYANAN,
				t_trans.TRANS_ID,t_trans.NO_ANTRIAN,
				DATE_FORMAT(t_trans.PRINT_TIME,"%d-%m-%Y %H:%i:%s") AS TGL_DATANG,0 AS ORD,t_trans.PRINT_TIME,
				t_daftar_irja_online.REMOTE_HOST
				FROM t_daftar_irja_online
				INNER JOIN t_trans ON (t_daftar_irja_online.DAFTAR_ID = t_trans.DAFTAR_ID)
				WHERE t_trans.ST_ORDER = "1"
				AND STR_TO_DATE(DATE_FORMAT(t_trans.PRINT_TIME,"%d%m%Y"),"%d%m%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(t_trans.PRINT_TIME,"%d%m%Y"),"%d%m%Y") <= ' . $tgl_filter_2 . '
				UNION ALL
				SELECT t_daftar_irja_online.DAFTAR_ID,t_daftar_irja_online.NOMR,
				t_daftar_irja_online.NAMA_PASIEN,DATE_FORMAT(t_daftar_irja_online.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,
				t_daftar_irja_online.JNS_KELAMIN,t_daftar_irja_online.ALAMAT,
				DATE_FORMAT(t_daftar_irja_online.TGL_RENCANA_KUNJUNGAN,"%d-%m-%Y") AS TGL_RENCANA_KUNJUNGAN,
				DATE_FORMAT(t_daftar_irja_online.TGL_DAFTAR,"%d-%m-%Y") AS TGL_DAFTAR_ONLINE,
				t_daftar_irja_online.KLINIK_ID,t_daftar_irja_online.CARA_BAYAR,t_daftar_irja_online.DOKTER_ID,
				t_daftar_irja_online.PASIEN_BARU,
				t_daftar_irja_online.KODE_VERIFIKASI,
				t_daftar_irja_online.YANKES,
				t_daftar_irja_online.JAM_LAYANAN,
				NULL AS TRANS_ID,NULL AS NO_ANTRIAN,
				NULL AS TGL_DATANG,1 AS ORD,NULL AS PRINT_TIME,
				t_daftar_irja_online.REMOTE_HOST
				FROM t_daftar_irja_online
				WHERE t_daftar_irja_online.TGL_RENCANA_KUNJUNGAN >= ' . $tgl_filter_1 . ' 
				AND t_daftar_irja_online.TGL_RENCANA_KUNJUNGAN <= ' . $tgl_filter_2 . '
				AND t_daftar_irja_online.DAFTAR_ID NOT IN (
						SELECT t_trans.DAFTAR_ID FROM t_trans WHERE t_trans.ST_ORDER = "1"
						AND t_trans.DAFTAR_ID IS NOT NULL
						ORDER BY t_trans.DAFTAR_ID DESC 
					)
					
				UNION ALL
				SELECT t_daftar_penunjang_online.DAFTAR_ID,t_daftar_penunjang_online.NOMR,
				t_daftar_penunjang_online.NAMA_PASIEN,DATE_FORMAT(t_daftar_penunjang_online.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,
				t_daftar_penunjang_online.JNS_KELAMIN,t_daftar_penunjang_online.ALAMAT,
				DATE_FORMAT(t_daftar_penunjang_online.TGL_RENCANA_KUNJUNGAN,"%d-%m-%Y") AS TGL_RENCANA_KUNJUNGAN,
				DATE_FORMAT(t_daftar_penunjang_online.TGL_DAFTAR,"%d-%m-%Y") AS TGL_DAFTAR_ONLINE,
				t_daftar_penunjang_online.UNIT_PENUNJANG_ID AS KLINIK_ID,t_daftar_penunjang_online.CARA_BAYAR,0 AS DOKTER_ID,
				t_daftar_penunjang_online.PASIEN_BARU,
				t_daftar_penunjang_online.KODE_VERIFIKASI,
				t_daftar_penunjang_online.YANKES,
				t_daftar_penunjang_online.JAM_LAYANAN,
				t_trans.TRANS_ID,t_trans.NO_ANTRIAN,
				DATE_FORMAT(t_trans.PRINT_TIME,"%d-%m-%Y %H:%i:%s") AS TGL_DATANG,0 AS ORD,t_trans.PRINT_TIME,
				t_daftar_penunjang_online.REMOTE_HOST
				FROM t_daftar_penunjang_online
				INNER JOIN t_trans ON (t_daftar_penunjang_online.DAFTAR_ID = t_trans.DAFTAR_ID)
				WHERE t_trans.ST_ORDER = "2"
				AND STR_TO_DATE(DATE_FORMAT(t_trans.PRINT_TIME,"%d%m%Y"),"%d%m%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(t_trans.PRINT_TIME,"%d%m%Y"),"%d%m%Y") <= ' . $tgl_filter_2 . '
				UNION ALL
				SELECT t_daftar_penunjang_online.DAFTAR_ID,t_daftar_penunjang_online.NOMR,
				t_daftar_penunjang_online.NAMA_PASIEN,DATE_FORMAT(t_daftar_penunjang_online.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,
				t_daftar_penunjang_online.JNS_KELAMIN,t_daftar_penunjang_online.ALAMAT,
				DATE_FORMAT(t_daftar_penunjang_online.TGL_RENCANA_KUNJUNGAN,"%d-%m-%Y") AS TGL_RENCANA_KUNJUNGAN,
				DATE_FORMAT(t_daftar_penunjang_online.TGL_DAFTAR,"%d-%m-%Y") AS TGL_DAFTAR_ONLINE,
				t_daftar_penunjang_online.UNIT_PENUNJANG_ID AS KLINIK_ID,t_daftar_penunjang_online.CARA_BAYAR,0 AS DOKTER_ID,
				t_daftar_penunjang_online.PASIEN_BARU,
				t_daftar_penunjang_online.KODE_VERIFIKASI,
				t_daftar_penunjang_online.YANKES,
				t_daftar_penunjang_online.JAM_LAYANAN,
				NULL AS TRANS_ID,NULL AS NO_ANTRIAN,
				NULL AS TGL_DATANG,1 AS ORD,NULL AS PRINT_TIME,
				t_daftar_penunjang_online.REMOTE_HOST
				FROM t_daftar_penunjang_online
				WHERE t_daftar_penunjang_online.TGL_RENCANA_KUNJUNGAN >= ' . $tgl_filter_1 . ' 
				AND t_daftar_penunjang_online.TGL_RENCANA_KUNJUNGAN <= ' . $tgl_filter_2 . '
				AND t_daftar_penunjang_online.DAFTAR_ID NOT IN (
						SELECT t_trans.DAFTAR_ID FROM t_trans WHERE t_trans.ST_ORDER = "2"
						AND t_trans.DAFTAR_ID IS NOT NULL
						ORDER BY t_trans.DAFTAR_ID DESC 
					)	
				) trn
				WHERE 1';
	
if (!empty($unit_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND trn.KLINIK_ID = "' . $unit_id . '"';
}
if (!empty($jaminan_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND trn.CARA_BAYAR = "' . $jaminan_id . '"';
}

if (!empty($verifikasi)) {
	if($verifikasi == '1') $qry_kunjungan = $qry_kunjungan . ' AND trn.PRINT_TIME IS NOT NULL';
	if($verifikasi == '2') $qry_kunjungan = $qry_kunjungan . ' AND trn.PRINT_TIME IS NULL';
}
$qry_kunjungan = $qry_kunjungan . ' ORDER BY trn.ORD,trn.PRINT_TIME';
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());	
?>
<table border="1" >
<tr>
	<th colspan="13" >Pendaftaran Mandiri Pasien Rawat Jalam Dr <?php echo $tgl_1; ?> Sd <?php echo $tgl_2; ?></th>
</tr>
      <tr>
        <th rowspan="2">No</th>
        <th colspan="3">Tanggal</th>
		<th rowspan="2">Nomor MR</th>
        <th rowspan="2">Nama Pasien</th>
        <th rowspan="2">Tanggal Lahir</th>
        <th rowspan="2">Jenis Kelamin</th>
        <th rowspan="2">Alamat</th>
        <th rowspan="2">Klinik/Unit</th>
        <th rowspan="2">Pembayaran</th>
		<th rowspan="2">Dokter-Jam Layanan </th>
		<th rowspan="2">Akses</th>
    </tr>
    <tr>
      <th>Datang</th>
	  <th>Rencana<br />Kunjungan</th>
      <th>Daftar<br />Online </th>
    </tr>
<?php $no = 1; 
while($data = mysql_fetch_array($get_kunjungan)){ ?>  
  <tr>
  <td scope="row" align="center"><?php echo $no; ?></td>
   	<td align="center"><?php echo $data['TGL_DATANG']; ?></td>
			<td align="center"><?php echo $data['TGL_RENCANA_KUNJUNGAN']; ?></td>
			<td align="center"><?php echo $data['TGL_DAFTAR_ONLINE']; ?></td>
            <td align="center"><?php if($data['NOMR'] == ''){
							echo 'Pasien Baru';
						}else{
							echo formatNoMR($data['NOMR']); 
						} ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td align="center"><?php echo $data['TGL_LAHIR']; ?></td>
            <td><?php echo jenisKelamin($data['JNS_KELAMIN']); ?></td>
            <td><?php echo $data['ALAMAT']; ?></td>
            <td><?php echo $arr_unit[$data['KLINIK_ID']]; ?></td>
            <td><?php echo $arr_jaminan[$data['CARA_BAYAR']]; ?></td>
			<td><?php echo $arr_dokter[$data['DOKTER_ID']] . '-' . $data['JAM_LAYANAN']; ?></td>
			<td><?php if($data['YANKES'] == '1'){
							echo 'Yankes';
						}else{
							echo str_replace('Linux','Android/Linux',$data['REMOTE_HOST']);
						}; ?></td>
  </tr>
 <?php $no++; } ?> 
</table>