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

$jaminan_id = '';
if (isset($_POST['jaminan_id']))
		$jaminan_id = $_POST['jaminan_id'];
$unit_id = '';
if (isset($_POST['unit_id']))
		$unit_id = $_POST['unit_id'];	

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}	

$qry_kunjungan = 'SELECT DISTINCT t_order.*,
				CASE WHEN t_order.JNS_ORDER <> "APS" THEN m_pasien.NAMA_PASIEN ELSE t_ipenunjang.NAMA_PASIEN END AS NAMA_PASIEN,
				CASE WHEN t_order.JNS_ORDER <> "APS" THEN m_pasien.TGL_LAHIR ELSE t_ipenunjang.TGL_LAHIR END AS TGL_LAHIR,
				CASE WHEN t_order.JNS_ORDER <> "APS" THEN m_pasien.JNS_KELAMIN ELSE t_ipenunjang.JNS_KELAMIN END AS JNS_KELAMIN,
				CASE WHEN t_order.JNS_ORDER <> "APS" THEN m_pasien.ALAMAT ELSE t_ipenunjang.ALAMAT END AS ALAMAT,
				CASE WHEN t_order.JNS_ORDER <> "APS" THEN m_pegawai.NAMA_PEGAWAI ELSE t_ipenunjang.PENGIRIM END AS NAMA_PEGAWAI, 
				m_jaminan.NAMA_JAMINAN,CONCAT(m_ruang.NAMA_RUANG," Kls ",m_ruang.KELAS_RAWAT) AS NAMA_RUANG,
				m_unit.NAMA_UNIT,t_ipenunjang.INSTANSI_PENGIRIM
				FROM (
				SELECT t_ipenunjang.PENUNJANG_ID,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_MASUK,"%d/%m/%Y %H:%i:%s") AS TANGGAL_MASUK,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d/%m/%Y %H:%i:%s") AS TANGGAL_PERIKSA,
				t_ipenunjang.NOMR,
				t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang.PEGAWAI_ID,t_ipenunjang.JNS_ORDER,
				t_ipenunjang.UNIT_ID,NULL AS RUANG_ID,
				SUM(CASE WHEN t_ipenunjang_tarif.ST_PERIKSA = "1" THEN 1 ELSE 0 END) AS ST_PERIKSA,
				t_ipenunjang_tarif.USER_PERIKSA,t_ipenunjang_tarif.NO_SJP,
				t_ipenunjang.MCU,t_ipenunjang.JENIS_BAYAR_ID,
				"" AS EXT_NAMA_UNIT,t_ipenunjang_tarif.UNIT_PENUNJANG_ID,
				t_ipenunjang.JNS_KELAMIN,
				t_ipenunjang.ST_BARU	
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				WHERE t_ipenunjang.JNS_ORDER = "IRJ"
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang_tarif.UNIT_PENUNJANG_ID IN (31,41,47,40,42)  
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
				GROUP BY t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_SJP
				UNION
				SELECT t_ipenunjang.PENUNJANG_ID,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_MASUK,"%d/%m/%Y %H:%i:%s") AS TANGGAL_MASUK,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d/%m/%Y %H:%i:%s") AS TANGGAL_PERIKSA,
				t_ipenunjang.NOMR,
				t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang.PEGAWAI_ID,t_ipenunjang.JNS_ORDER,
				NULL AS UNIT_ID,t_ipenunjang.RUANG_ID,
				SUM(CASE WHEN t_ipenunjang_tarif.ST_PERIKSA = "1" THEN 1 ELSE 0 END) AS ST_PERIKSA,
				t_ipenunjang_tarif.USER_PERIKSA,t_ipenunjang_tarif.NO_SJP,
				t_ipenunjang.MCU,t_ipenunjang.JENIS_BAYAR_ID,
				"" AS EXT_NAMA_UNIT,t_ipenunjang_tarif.UNIT_PENUNJANG_ID,
				t_ipenunjang.JNS_KELAMIN,
				t_ipenunjang.ST_BARU				
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				WHERE t_ipenunjang.JNS_ORDER = "IRN"
				AND t_ipenunjang_tarif.UNIT_PENUNJANG_ID IN (31,41,47,40,42)  
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
				GROUP BY t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_SJP
				UNION
				SELECT t_ipenunjang.PENUNJANG_ID,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_MASUK,"%d/%m/%Y %H:%i:%s") AS TANGGAL_MASUK,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d/%m/%Y %H:%i:%s") AS TANGGAL_PERIKSA,
				t_ipenunjang.NO_PASIEN_PENUNJANG AS NOMR,
				"" AS RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,NULL AS PEGAWAI_ID,t_ipenunjang.JNS_ORDER,
				NULL AS UNIT_ID,NULL AS RUANG_ID,
				SUM(CASE WHEN t_ipenunjang_tarif.ST_PERIKSA = "1" THEN 1 ELSE 0 END) AS ST_PERIKSA,
				t_ipenunjang_tarif.USER_PERIKSA,t_ipenunjang_tarif.NO_SJP,
				t_ipenunjang.MCU,t_ipenunjang.JENIS_BAYAR_ID,
				"" AS EXT_NAMA_UNIT,t_ipenunjang_tarif.UNIT_PENUNJANG_ID,
				t_ipenunjang.JNS_KELAMIN,
				t_ipenunjang.ST_BARU	
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				WHERE t_ipenunjang.JNS_ORDER = "APS"
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang_tarif.UNIT_PENUNJANG_ID IN (31,41,47,40,42)  
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
				GROUP BY t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_SJP
				UNION
				SELECT t_ipenunjang.PENUNJANG_ID,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_MASUK,"%d/%m/%Y %H:%i:%s") AS TANGGAL_MASUK,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d/%m/%Y %H:%i:%s") AS TANGGAL_PERIKSA,
				t_ipenunjang.NOMR,
				t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang.PEGAWAI_ID,t_ipenunjang.JNS_ORDER,
				t_ipenunjang.UNIT_ID, NULL AS RUANG_ID,
				SUM(CASE WHEN t_ipenunjang_tarif.ST_PERIKSA = "1" THEN 1 ELSE 0 END) AS ST_PERIKSA,
				t_ipenunjang_tarif.USER_PERIKSA,t_ipenunjang_tarif.NO_SJP,
				t_ipenunjang.MCU,t_ipenunjang.JENIS_BAYAR_ID,
				"Hemodialisa" AS EXT_NAMA_UNIT,t_ipenunjang_tarif.UNIT_PENUNJANG_ID,
				t_ipenunjang.JNS_KELAMIN,
				t_ipenunjang.ST_BARU	
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				WHERE t_ipenunjang.JNS_ORDER = "HRJ"
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang_tarif.UNIT_PENUNJANG_ID IN (31,41,47,40,42)  
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
				GROUP BY t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_SJP
				UNION
				SELECT t_ipenunjang.PENUNJANG_ID,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_MASUK,"%d/%m/%Y %H:%i:%s") AS TANGGAL_MASUK,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d/%m/%Y %H:%i:%s") AS TANGGAL_PERIKSA,
				t_ipenunjang.NOMR,
				t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang.PEGAWAI_ID,t_ipenunjang.JNS_ORDER,
				NULL AS UNIT_ID,t_ipenunjang.RUANG_ID,
				SUM(CASE WHEN t_ipenunjang_tarif.ST_PERIKSA = "1" THEN 1 ELSE 0 END) AS ST_PERIKSA,
				t_ipenunjang_tarif.USER_PERIKSA,t_ipenunjang_tarif.NO_SJP,
				t_ipenunjang.MCU,t_ipenunjang.JENIS_BAYAR_ID,
				"Hemodialisa" AS EXT_NAMA_UNIT,t_ipenunjang_tarif.UNIT_PENUNJANG_ID,
				t_ipenunjang.JNS_KELAMIN,
				t_ipenunjang.ST_BARU
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				WHERE t_ipenunjang.JNS_ORDER = "HRI"
				AND t_ipenunjang_tarif.UNIT_PENUNJANG_ID IN (31,41,47,40,42)  
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
				GROUP BY t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_SJP
				) t_order 
				INNER JOIN m_jaminan ON (t_order.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				LEFT JOIN m_pasien ON (t_order.NOMR = m_pasien.NOMR)
				LEFT JOIN m_unit ON (t_order.UNIT_PENUNJANG_ID = m_unit.UNIT_ID)
				LEFT JOIN m_ruang ON (t_order.RUANG_ID = m_ruang.RUANG_ID)
				LEFT JOIN m_pegawai ON (t_order.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN t_ipenunjang ON (t_order.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID
					AND t_ipenunjang.JNS_ORDER = "APS")
				WHERE 1';
	
if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_kunjungan = $qry_kunjungan . ' AND CONCAT(t_order.NOMR,m_pasien.NAMA_PASIEN) LIKE "%' . $searchkey . '%"';
}	
if (!empty($unit_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_order.UNIT_PENUNJANG_ID = "' . $unit_id . '"';
}
if (!empty($jaminan_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_order.JENIS_BAYAR_ID = "' . $jaminan_id . '"';
}

$qry_kunjungan = $qry_kunjungan . ' ORDER BY TANGGAL_DAFTAR';
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());	
?>
<table width="100%" border="1" >
	<tr>
		<th colspan="13">Laporan Data Pasien Rehab Medik Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>	
  <tr>
       <th>No</th>
        <th>Tanggal Daftar</th>
		<th>Unit</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
        <th>Tanggal Lahir</th>
        <th>Jenis Kelamin</th>
        <th>Alamat</th>
        <th>Kunjungan<br />Baru</th>
        <th>Pembayaran</th>
		<th>Dokter</th>
		<th>Masuk</th>
        <th>Keluar</th>
    </tr>
 <?php $no = 1;
	$rs = mysql_query($qry_kunjungan) or die(mysql_error());
    while ($data = mysql_fetch_array($rs)) { ?>  
  <tr>
    <td scope="row" align="center"><?php echo $no; ?></td>
   <td align="center"><?php echo $data['TANGGAL_DAFTAR']; ?></td>
			<td><?php echo $data['NAMA_UNIT']; ?></td>
            <td align="center"><?php echo formatNoMR($data['NOMR']); ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td align="center"><?php echo changeDateFormat($data['TGL_LAHIR']); ?></td>
            <td><?php echo jenisKelamin($data['JNS_KELAMIN']); ?></td>
            <td><?php echo $data['ALAMAT']; ?></td>
            <td align="center"><?php if($data['ST_BARU'] == '1') echo '&radic;'; ?></td>
            <td><?php echo $data['NAMA_JAMINAN']; ?></td>
			<td><?php echo $data['NAMA_PEGAWAI']; ?></td>
			<td align="center"><?php echo $data['TANGGAL_MASUK']; ?></td>
			<td align="center"><?php echo $data['TANGGAL_PERIKSA']; ?></td>
        </tr>
 <?php $no++; } ?> 
</table>