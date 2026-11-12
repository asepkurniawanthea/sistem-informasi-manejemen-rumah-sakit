<?php
$tgl_1 = '';
if (isset($_SESSION['radiologisearchorder_tgl_1']))
    $tgl_1 = $_SESSION['radiologisearchorder_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['radiologisearchorder_tgl_1']))
    $tgl_2 = $_SESSION['radiologisearchorder_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['radiologisearchorder_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['radiologisearchorder_tgl_2'] = $_GET['tgl_2'];
}

$ruang_id = '';
if (isset($_SESSION['radiologisearchorder_ruang_id']))
		$ruang_id = $_SESSION['radiologisearchorder_ruang_id'];

if (isset($_GET['ruang_id'])) {
    $ruang_id = $_GET['ruang_id'];
	$_SESSION['radiologisearchorder_ruang_id'] = $ruang_id;
}
$unit_id = '';
if (isset($_SESSION['radiologisearchorder_unit_id']))
		$unit_id = $_SESSION['radiologisearchorder_unit_id'];

if (isset($_GET['unit_id'])) {
    $unit_id = $_GET['unit_id'];
	$_SESSION['radiologisearchorder_unit_id'] = $unit_id;
}

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}	
?>
<form name="search" method="get" action="index.php">
    <table class="tableform" border="0" >
        <tr>
            <td>Tanggal</td>
            <td><input type="text" name="tgl_1" id="tgl_1" value="<?php echo $tgl_1; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
			<td>Poliklinik</td>
			<td> <select name="unit_id" id="unit_id" class="text_dt" style="width:228px;">
                    <option value=""> - </option>
                    <?php echo getUnit('umumigd',$unit_id); ?>
                </select></td>	
			<td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/>
            </td>	
			<td>Ruang</td>
			<td><select name="ruang_id" id="ruang_id" class="text_dt" style="width:228px;">
			<option value=""> - </option>
			<?php echo getRuangRawat($ruang_id); ?>
            </select></td>	
			<td colspan="2" align="right"><input type="submit" value="cari" class="myButton" />
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" />
			</td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_kunjungan = 'SELECT DISTINCT t_order.*,
				CASE WHEN t_order.JNS_ORDER <> "APS" THEN m_pasien.NAMA_PASIEN ELSE t_ipenunjang.NAMA_PASIEN END AS NAMA_PASIEN,
				CASE WHEN t_order.JNS_ORDER <> "APS" THEN m_pasien.TGL_LAHIR ELSE t_ipenunjang.TGL_LAHIR END AS TGL_LAHIR,
				CASE WHEN t_order.JNS_ORDER <> "APS" THEN m_pasien.ALAMAT ELSE t_ipenunjang.ALAMAT END AS ALAMAT,
				CASE WHEN t_order.JNS_ORDER <> "APS" THEN m_pegawai.NAMA_PEGAWAI ELSE t_ipenunjang.PENGIRIM END AS NAMA_PEGAWAI, 
				m_jaminan.NAMA_JAMINAN,CONCAT(m_ruang.NAMA_RUANG," Kls ",m_ruang.KELAS_RAWAT) AS NAMA_RUANG,
				m_unit.NAMA_UNIT,t_ipenunjang.INSTANSI_PENGIRIM,t_order.NAMA_TARIF
				FROM (
				SELECT t_ipenunjang.RAWAT_ID AS PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.NOMR,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang.JNS_ORDER,
				t_ipenunjang.UNIT_ID,NULL AS RUANG_ID,
				SUM(CASE WHEN t_ipenunjang_tarif.ST_PERIKSA IS NULL THEN 1 ELSE 0 END) AS ST_PERIKSA,
				SUM(CASE WHEN m_tarif_group.RADIOLOGI_CITO = "1" THEN 1 ELSE 0 END) AS CITO,
				t_ipenunjang_tarif.USER_PERIKSA,t_ipenunjang_tarif.TANGGAL_DAFTAR AS F_ORDER,
				t_irja.ST_BARU,t_ipenunjang.MCU,t_ipenunjang_tarif.JENIS_BAYAR_ID,
				"" AS EXT_NAMA_UNIT,t_ipenunjang.PEGAWAI_ID,
				m_tarif.NAMA_TARIF
 				FROM t_ipenunjang
				INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_ipenunjang.JNS_ORDER = "IRJ"
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
				OR m_tarif.UNIT_ID = "17")
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
				AND t_ipenunjang_tarif.ST_BATAL IS NULL
				GROUP BY t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_TARIF,m_tarif.NAMA_TARIF
				UNION
				SELECT t_ipenunjang.RAWAT_ID AS PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.NOMR,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang.JNS_ORDER,
				t_ipenunjang.UNIT_ID,NULL AS RUANG_ID,
				SUM(CASE WHEN t_ipenunjang_tarif.ST_PERIKSA IS NULL THEN 1 ELSE 0 END) AS ST_PERIKSA,
				SUM(CASE WHEN m_tarif_group.RADIOLOGI_CITO = "1" THEN 1 ELSE 0 END) AS CITO,
				t_ipenunjang_tarif.USER_PERIKSA,t_ipenunjang_tarif.TANGGAL_DAFTAR AS F_ORDER,
				t_irja.ST_BARU,t_ipenunjang.MCU,t_ipenunjang_tarif.JENIS_BAYAR_ID,
				"Hemodialisa" AS EXT_NAMA_UNIT,t_ipenunjang.PEGAWAI_ID,m_tarif.NAMA_TARIF
				FROM t_ipenunjang
				INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_ipenunjang.JNS_ORDER = "HRJ"
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
				OR m_tarif.UNIT_ID = "17")
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
				AND t_ipenunjang_tarif.ST_BATAL IS NULL
				GROUP BY t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_TARIF,m_tarif.NAMA_TARIF
				
				UNION
				SELECT t_ipenunjang.RAWAT_ID AS PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.NOMR,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang.JNS_ORDER,
				t_ipenunjang.UNIT_ID,NULL AS RUANG_ID,
				SUM(CASE WHEN t_ipenunjang_tarif.ST_PERIKSA IS NULL THEN 1 ELSE 0 END) AS ST_PERIKSA,
				SUM(CASE WHEN m_tarif_group.RADIOLOGI_CITO = "1" THEN 1 ELSE 0 END) AS CITO,
				t_ipenunjang_tarif.USER_PERIKSA,t_ipenunjang_tarif.TANGGAL_DAFTAR AS F_ORDER,
				t_irja.ST_BARU,t_ipenunjang.MCU,t_ipenunjang_tarif.JENIS_BAYAR_ID,
				"Kamar Operasi" AS EXT_NAMA_UNIT,t_ipenunjang.PEGAWAI_ID,m_tarif.NAMA_TARIF
				FROM t_ipenunjang
				INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_ipenunjang.JNS_ORDER = "ORJ"
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
				OR m_tarif.UNIT_ID = "17")
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
				AND t_ipenunjang_tarif.ST_BATAL IS NULL
				GROUP BY t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_TARIF,m_tarif.NAMA_TARIF
				UNION
				SELECT t_ipenunjang.RAWAT_ID AS PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.NOMR,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang.JNS_ORDER,
				NULL AS UNIT_ID,t_ipenunjang.RUANG_ID,
				SUM(CASE WHEN t_ipenunjang_tarif.ST_PERIKSA IS NULL THEN 1 ELSE 0 END) AS ST_PERIKSA,
				SUM(CASE WHEN m_tarif_group.RADIOLOGI_CITO = "1" THEN 1 ELSE 0 END) AS CITO,
				t_ipenunjang_tarif.USER_PERIKSA,t_ipenunjang_tarif.TANGGAL_DAFTAR AS F_ORDER,
				"" AS ST_BARU, "" AS MCU,t_ipenunjang_tarif.JENIS_BAYAR_ID,
				"Kamar Operasi" AS EXT_NAMA_UNIT,t_ipenunjang.PEGAWAI_ID,m_tarif.NAMA_TARIF
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_ipenunjang.JNS_ORDER = "ORI"
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
				OR m_tarif.UNIT_ID = "17")
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
				AND t_ipenunjang_tarif.ST_BATAL IS NULL
				GROUP BY t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_TARIF,m_tarif.NAMA_TARIF
				
				UNION
				SELECT t_ipenunjang.RAWAT_ID AS PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.NOMR,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang.JNS_ORDER,
				NULL AS UNIT_ID,t_ipenunjang.RUANG_ID,
				SUM(CASE WHEN t_ipenunjang_tarif.ST_PERIKSA IS NULL THEN 1 ELSE 0 END) AS ST_PERIKSA,
				SUM(CASE WHEN m_tarif_group.RADIOLOGI_CITO = "1" THEN 1 ELSE 0 END) AS CITO,
				t_ipenunjang_tarif.USER_PERIKSA,t_ipenunjang_tarif.TANGGAL_DAFTAR AS F_ORDER,
				"" AS ST_BARU, "" AS MCU,t_ipenunjang_tarif.JENIS_BAYAR_ID,
				"" AS EXT_NAMA_UNIT,t_ipenunjang.PEGAWAI_ID,m_tarif.NAMA_TARIF
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_ipenunjang.JNS_ORDER = "IRN"
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
				OR m_tarif.UNIT_ID = "17")
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
				AND t_ipenunjang_tarif.ST_BATAL IS NULL
				GROUP BY t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_TARIF,m_tarif.NAMA_TARIF
				UNION
				SELECT t_ipenunjang.RAWAT_ID AS PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.NOMR,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang.JNS_ORDER,
				NULL AS UNIT_ID,t_ipenunjang.RUANG_ID,
				SUM(CASE WHEN t_ipenunjang_tarif.ST_PERIKSA IS NULL THEN 1 ELSE 0 END) AS ST_PERIKSA,
				SUM(CASE WHEN m_tarif_group.RADIOLOGI_CITO = "1" THEN 1 ELSE 0 END) AS CITO,
				t_ipenunjang_tarif.USER_PERIKSA,t_ipenunjang_tarif.TANGGAL_DAFTAR AS F_ORDER,
				"" AS ST_BARU, "" AS MCU,t_ipenunjang_tarif.JENIS_BAYAR_ID,
				"Hemodialisa" AS EXT_NAMA_UNIT,t_ipenunjang.PEGAWAI_ID,m_tarif.NAMA_TARIF
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_ipenunjang.JNS_ORDER = "HRI"
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
				OR m_tarif.UNIT_ID = "17")
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
				AND t_ipenunjang_tarif.ST_BATAL IS NULL
				GROUP BY t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_TARIF,m_tarif.NAMA_TARIF
				UNION
				SELECT t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.NO_PASIEN_PENUNJANG AS NOMR,"" AS RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang.JNS_ORDER,
				NULL AS UNIT_ID,NULL AS RUANG_ID,
				SUM(CASE WHEN t_ipenunjang_tarif.ST_PERIKSA IS NULL THEN 1 ELSE 0 END) AS ST_PERIKSA,
				SUM(CASE WHEN m_tarif_group.RADIOLOGI_CITO = "1" THEN 1 ELSE 0 END) AS CITO,
				t_ipenunjang_tarif.USER_PERIKSA,t_ipenunjang_tarif.TANGGAL_DAFTAR AS F_ORDER,
				"" AS ST_BARU, "" AS MCU,t_ipenunjang_tarif.JENIS_BAYAR_ID,
				"" AS EXT_NAMA_UNIT,NULL AS PEGAWAI_ID,m_tarif.NAMA_TARIF
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_ipenunjang.JNS_ORDER = "APS"
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
				OR m_tarif.UNIT_ID = "17")
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
				AND t_ipenunjang_tarif.ST_BATAL IS NULL
				GROUP BY t_ipenunjang.PENUNJANG_ID,m_tarif.NAMA_TARIF
				) t_order 
				INNER JOIN m_jaminan ON (t_order.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				LEFT JOIN m_pasien ON (t_order.NOMR = m_pasien.NOMR)
				LEFT JOIN m_unit ON (t_order.UNIT_ID = m_unit.UNIT_ID)
				LEFT JOIN m_ruang ON (t_order.RUANG_ID = m_ruang.RUANG_ID)
				LEFT JOIN m_pegawai ON (t_order.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN t_ipenunjang ON (t_order.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID
					AND t_ipenunjang.JNS_ORDER = "APS")
				WHERE 1';
		
if (!empty($ruang_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_order.RUANG_ID = "' . $ruang_id . '" AND 
			(t_order.JNS_ORDER = "IRN" OR t_order.JNS_ORDER = "HRI" OR t_order.JNS_ORDER = "ORI")';
}
if (!empty($unit_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_order.UNIT_ID = "' . $unit_id . '" AND 
			(t_order.JNS_ORDER = "IRJ" OR t_order.JNS_ORDER = "HRJ" OR t_order.JNS_ORDER = "ORJ")';
}

$qry_kunjungan = $qry_kunjungan . ' ORDER BY F_ORDER';
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());
?>
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
        <th>Tanggal Order</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
        <th>Tanggal Lahir</th>
        <th>Alamat</th>
        <th>Klinik/Ruang/Instansi</th>
		 <th>Dokter Pengirim</th>
        <th>Pembayaran</th>
		 <th>Pemeriksaan</th>
		 <th colspan="2">Cito/Status</th>
    </tr>
    <?
    $no = 1;
    while ($data = mysql_fetch_array($get_kunjungan)) {
        $id = $data['PENUNJANG_ID'];
        ?>
        <tr>
            <td align="center"><? echo $no; ?></td>
            <td align="center"><?php echo $data['TANGGAL_DAFTAR']; ?></td>
            <td align="center"><?php if(strlen($data['NOMR']) == 6){ echo formatNoMR($data['NOMR']); }else{ echo $data['NOMR']; } ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td align="center"><?php echo changeDateFormat($data['TGL_LAHIR']); ?></td>
            <td><?php echo $data['ALAMAT']; ?></td>
            <td><?php $nama_unit = $data['NAMA_UNIT'];
			if($nama_unit == '') $nama_unit = $data['NAMA_RUANG'];
			if($nama_unit == '') $nama_unit = $data['INSTANSI_PENGIRIM'];
			if($data['EXT_NAMA_UNIT'] != '') $nama_unit .= '-' . $data['EXT_NAMA_UNIT'];
			echo $nama_unit; ?></td>
			<td><?php echo $data['NAMA_PEGAWAI']; ?></td>
			<td><?php echo $data['NAMA_JAMINAN'];  ?></td>
			<td><?php echo $data['NAMA_TARIF'];  ?></td>
			<td align="center"><?php if($data['CITO'] > 0) echo '&radic;'; ?></td>
			<td align="center"><?php if($data['ST_PERIKSA'] == 0) echo 'Selesai'; ?></td>
        </tr>
        <?
	$no++;
   }
    ?>
</table>
<form id="xls_export" name="xls_export" method="post">
   <input type="hidden" name="page_to_excel" value="1" />
   <input type="hidden" name="tgl_1" value="<?php echo $tgl_1; ?>" />
   <input type="hidden" name="tgl_2" value="<?php echo $tgl_2; ?>" />
   <input type="hidden" name="unit_id" value="<?php echo $unit_id; ?>" />
   <input type="hidden" name="ruang_id" value="<?php echo $ruang_id; ?>" />
   <input type="hidden" name="xlsfile" value="radiologi/xls_report_data_pasien.php" />
   <input type="hidden" name="xlsname" value="rpt_report_data_pasien.xls" />            
</form>