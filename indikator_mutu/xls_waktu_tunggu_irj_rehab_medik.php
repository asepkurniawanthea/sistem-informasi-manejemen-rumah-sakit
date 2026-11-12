<?php
include('./config/config.php');
include('./shared/connect_db.php');
include('./shared/function.php');

$tgl_1 = $_POST['tgl_1'];
$tgl_2 = $_POST['tgl_2'];
$searchkey = $_POST['searchkey'];

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}	

$qry_pasien = 'SELECT DISTINCT t_order.*,
				CASE WHEN t_order.JNS_ORDER <> "APS" THEN m_pasien.NAMA_PASIEN ELSE t_ipenunjang.NAMA_PASIEN END AS NAMA_PASIEN,
				CASE WHEN t_order.JNS_ORDER <> "APS" THEN m_pasien.TGL_LAHIR ELSE t_ipenunjang.TGL_LAHIR END AS TGL_LAHIR,
				CASE WHEN t_order.JNS_ORDER <> "APS" THEN m_pasien.ALAMAT ELSE t_ipenunjang.ALAMAT END AS ALAMAT,
				CASE WHEN t_order.JNS_ORDER <> "APS" THEN m_pegawai.NAMA_PEGAWAI ELSE t_ipenunjang.PENGIRIM END AS NAMA_PEGAWAI, 
				m_jaminan.NAMA_JAMINAN,CONCAT(m_ruang.NAMA_RUANG," Kls ",m_ruang.KELAS_RAWAT) AS NAMA_RUANG,
				m_unit.NAMA_UNIT,t_ipenunjang.INSTANSI_PENGIRIM
				FROM (
				SELECT t_ipenunjang.PENUNJANG_ID,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%H:%i:%s") AS JAM_DAFTAR,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_MASUK,"%d/%m/%Y") AS TANGGAL_MASUK,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_MASUK,"%H:%i:%s") AS JAM_MASUK,
				TIMEDIFF(t_ipenunjang_tarif.TANGGAL_MASUK,t_ipenunjang_tarif.TANGGAL_DAFTAR) AS RESPONSE_TIME,
				t_ipenunjang.NOMR,
				t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang.PEGAWAI_ID,t_ipenunjang.JNS_ORDER,
				t_ipenunjang_tarif.UNIT_PENUNJANG_ID AS UNIT_ID,NULL AS RUANG_ID,
				SUM(CASE WHEN t_ipenunjang_tarif.ST_PERIKSA = "1" THEN 1 ELSE 0 END) AS ST_PERIKSA,
				t_ipenunjang_tarif.USER_PERIKSA,t_ipenunjang_tarif.NO_SJP,
				t_ipenunjang.MCU,t_ipenunjang.JENIS_BAYAR_ID,
				"" AS EXT_NAMA_UNIT	
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
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%H:%i:%s") AS JAM_DAFTAR,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_MASUK,"%d/%m/%Y") AS TANGGAL_MASUK,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_MASUK,"%H:%i:%s") AS JAM_MASUK,
				TIMEDIFF(t_ipenunjang_tarif.TANGGAL_MASUK,t_ipenunjang_tarif.TANGGAL_DAFTAR) AS RESPONSE_TIME,
				t_ipenunjang.NOMR,
				t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang.PEGAWAI_ID,t_ipenunjang.JNS_ORDER,
				t_ipenunjang_tarif.UNIT_PENUNJANG_ID AS UNIT_ID,t_ipenunjang.RUANG_ID,
				SUM(CASE WHEN t_ipenunjang_tarif.ST_PERIKSA = "1" THEN 1 ELSE 0 END) AS ST_PERIKSA,
				t_ipenunjang_tarif.USER_PERIKSA,t_ipenunjang_tarif.NO_SJP,
				t_ipenunjang.MCU,t_ipenunjang.JENIS_BAYAR_ID,
				"" AS EXT_NAMA_UNIT	
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
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%H:%i:%s") AS JAM_DAFTAR,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_MASUK,"%d/%m/%Y") AS TANGGAL_MASUK,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_MASUK,"%H:%i:%s") AS JAM_MASUK,
				TIMEDIFF(t_ipenunjang_tarif.TANGGAL_MASUK,t_ipenunjang_tarif.TANGGAL_DAFTAR) AS RESPONSE_TIME,
				t_ipenunjang.NO_PASIEN_PENUNJANG AS NOMR,
				"" AS RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,NULL AS PEGAWAI_ID,t_ipenunjang.JNS_ORDER,
				t_ipenunjang_tarif.UNIT_PENUNJANG_ID AS UNIT_ID,NULL AS RUANG_ID,
				SUM(CASE WHEN t_ipenunjang_tarif.ST_PERIKSA = "1" THEN 1 ELSE 0 END) AS ST_PERIKSA,
				t_ipenunjang_tarif.USER_PERIKSA,t_ipenunjang_tarif.NO_SJP,
				t_ipenunjang.MCU,t_ipenunjang.JENIS_BAYAR_ID,
				"" AS EXT_NAMA_UNIT	
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
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%H:%i:%s") AS JAM_DAFTAR,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_MASUK,"%d/%m/%Y") AS TANGGAL_MASUK,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_MASUK,"%H:%i:%s") AS JAM_MASUK,
				TIMEDIFF(t_ipenunjang_tarif.TANGGAL_MASUK,t_ipenunjang_tarif.TANGGAL_DAFTAR) AS RESPONSE_TIME,
				t_ipenunjang.NOMR,
				t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang.PEGAWAI_ID,t_ipenunjang.JNS_ORDER,
				t_ipenunjang_tarif.UNIT_PENUNJANG_ID AS UNIT_ID, NULL AS RUANG_ID,
				SUM(CASE WHEN t_ipenunjang_tarif.ST_PERIKSA = "1" THEN 1 ELSE 0 END) AS ST_PERIKSA,
				t_ipenunjang_tarif.USER_PERIKSA,t_ipenunjang_tarif.NO_SJP,
				t_ipenunjang.MCU,t_ipenunjang.JENIS_BAYAR_ID,
				"Hemodialisa" AS EXT_NAMA_UNIT	
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
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%H:%i:%s") AS JAM_DAFTAR,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_MASUK,"%d/%m/%Y") AS TANGGAL_MASUK,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_MASUK,"%H:%i:%s") AS JAM_MASUK,
				TIMEDIFF(t_ipenunjang_tarif.TANGGAL_MASUK,t_ipenunjang_tarif.TANGGAL_DAFTAR) AS RESPONSE_TIME,
				t_ipenunjang.NOMR,
				t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang.PEGAWAI_ID,t_ipenunjang.JNS_ORDER,
				t_ipenunjang_tarif.UNIT_PENUNJANG_ID AS UNIT_ID,t_ipenunjang.RUANG_ID,
				SUM(CASE WHEN t_ipenunjang_tarif.ST_PERIKSA = "1" THEN 1 ELSE 0 END) AS ST_PERIKSA,
				t_ipenunjang_tarif.USER_PERIKSA,t_ipenunjang_tarif.NO_SJP,
				t_ipenunjang.MCU,t_ipenunjang.JENIS_BAYAR_ID,
				"Hemodialisa" AS EXT_NAMA_UNIT	
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
				LEFT JOIN m_unit ON (t_order.UNIT_ID = m_unit.UNIT_ID)
				LEFT JOIN m_ruang ON (t_order.RUANG_ID = m_ruang.RUANG_ID)
				LEFT JOIN m_pegawai ON (t_order.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN t_ipenunjang ON (t_order.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID
					AND t_ipenunjang.JNS_ORDER = "APS")
				' . (($_SESSION['SES_SIMRS_UNIT_ID'] == '34') ? ' WHERE 1 ' : ' WHERE t_ipenunjang.JNS_ORDER = "999" ');

if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_pasien = $qry_pasien . ' AND CONCAT(m_pasien.NOMR,m_pasien.NAMA_PASIEN) LIKE "%' . $searchkey . '%" ';
}
	
$qry_pasien = $qry_pasien . 'ORDER BY t_order.PENUNJANG_ID';
?>
<table border="1" >
	<tr>
		<th colspan="9">Waktu Tunggu Rawat Jalan Rehab Medik Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>
    <tr>
         <th>No</th>
		<th>Tanggal</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
        <th>Tanggal Lahir</th>
		<th>Unit - Klinik</th>
		<th>Jam Daftar</th>
        <th>Jam Dilayani</th>
		<th>Response Time Dokter</th>
    </tr>
    <?
    $no = 0;
	$rs = mysql_query($qry_pasien) or die(mysql_error());
     while ($data = mysql_fetch_array($rs)) {
        ?>
        <tr>
            <td align="center"><?php echo $no + 1; ?></td>
             <td align="center"><?php echo $data['TANGGAL_DAFTAR']; ?></td>
            <td align="center"><?php echo ((strlen($data['NOMR']) == 6) ? formatNoMR($data['NOMR']) : $data['NOMR']); ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td align="center"><?php echo $data['TGL_LAHIR']; ?></td>
			<td><?php echo $data['NAMA_UNIT']; ?></td>
			<td align="center"><?php echo $data['JAM_DAFTAR']; ?></td>
			<td align="center"><?php echo $data['JAM_MASUK']; ?></td>
			<td align="center"><?php echo $data['RESPONSE_TIME']; ?></td>
        </tr>
        <?
    $no++; }
    ?>
</table>
