<?php
$tgl_1 = '';
if (isset($_SESSION['radiologisearchdiagnosa_tgl_1']))
    $tgl_1 = $_SESSION['radiologisearchdiagnosa_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['radiologisearchdiagnosa_tgl_1']))
    $tgl_2 = $_SESSION['radiologisearchdiagnosa_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['radiologisearchdiagnosa_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['radiologisearchdiagnosa_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['radiologisearchdiagnosa_searchkey']))
		$searchkey = $_SESSION['radiologisearchdiagnosa_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['radiologisearchdiagnosa_searchkey'] = $searchkey;
}
$ruang_id = '';
if (isset($_SESSION['radiologisearchdiagnosa_ruang_id']))
		$ruang_id = $_SESSION['radiologisearchdiagnosa_ruang_id'];

if (isset($_GET['ruang_id'])) {
    $ruang_id = $_GET['ruang_id'];
	$_SESSION['radiologisearchdiagnosa_ruang_id'] = $ruang_id;
}
$unit_id = '';
if (isset($_SESSION['radiologisearchdiagnosa_unit_id']))
		$unit_id = $_SESSION['radiologisearchdiagnosa_unit_id'];

if (isset($_GET['unit_id'])) {
    $unit_id = $_GET['unit_id'];
	$_SESSION['radiologisearchdiagnosa_unit_id'] = $unit_id;
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
    <table class="tableform" bdiagnosa="0" >
        <tr>
            <td>Tanggal</td>
            <td><input type="text" name="tgl_1" id="tgl_1" value="<?php echo $tgl_1; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" bdiagnosa="0"  onclick="showCal('Calendar6')"/></td>
			<td>Poliklinik</td>
			<td> <select name="unit_id" id="unit_id" class="text_dt" style="width:228px;">
                    <option value=""> - </option>
                    <?php echo getUnit('umumigd',$unit_id); ?>
                </select></td>	
			<td>Nomor MR/ Nama Pasien</td>
            <td><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt"/></td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" bdiagnosa="0"  onclick="showCal('Calendar7')"/>
            </td>	
			<td>Ruang</td>
			<td><select name="ruang_id" id="ruang_id" class="text_dt" style="width:228px;">
			<option value=""> - </option>
			<?php echo getRuangRawat($ruang_id); ?>
            </select></td>	
			<td colspan="2" align="right"><input type="submit" value="cari" class="myButton" />
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
				m_unit.NAMA_UNIT,t_ipenunjang.INSTANSI_PENGIRIM,
				(SELECT pt.ST_DIAGNOSA FROM t_ipenunjang_tarif_pemeriksaan pt
				WHERE pt.PENUNJANG_TARIF_ID = t_order.PENUNJANG_TARIF_ID
				ORDER BY pt.PENUNJANG_TARIF_PEMERIKSAAN_ID
				DESC LIMIT 1) AS ST_DIAGNOSA,
				(SELECT pt.USER_DIAGNOSA FROM t_ipenunjang_tarif_pemeriksaan pt
				WHERE pt.PENUNJANG_TARIF_ID = t_order.PENUNJANG_TARIF_ID
				ORDER BY pt.PENUNJANG_TARIF_PEMERIKSAAN_ID
				DESC LIMIT 1) AS USER_DIAGNOSA
				FROM (
				SELECT t_ipenunjang.RAWAT_ID AS PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.NOMR,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang.JNS_ORDER,
				t_ipenunjang.UNIT_ID,NULL AS RUANG_ID,
				m_tarif_group.RADIOLOGI_CITO AS CITO,
				t_ipenunjang_tarif.TANGGAL_PERIKSA AS F_ORDER,
				t_irja.ST_BARU,t_ipenunjang.MCU,t_ipenunjang_tarif.JENIS_BAYAR_ID,
				"" AS EXT_NAMA_UNIT,t_ipenunjang.PEGAWAI_ID,t_ipenunjang_tarif.PENUNJANG_TARIF_ID,
				m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER
 				FROM t_ipenunjang
				INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF) 
				WHERE t_ipenunjang.JNS_ORDER = "IRJ"
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
				OR m_tarif.UNIT_ID = "17")
				AND DATE(t_ipenunjang_tarif.TANGGAL_PERIKSA) >= ' . $tgl_filter_1 . ' 
				AND DATE(t_ipenunjang_tarif.TANGGAL_PERIKSA) <= ' . $tgl_filter_2 . '
				AND t_ipenunjang_tarif.ST_BATAL IS NULL
				GROUP BY t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_TARIF,t_ipenunjang_tarif.PENUNJANG_TARIF_ID
				UNION
				SELECT t_ipenunjang.RAWAT_ID AS PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.NOMR,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang.JNS_ORDER,
				t_ipenunjang.UNIT_ID,NULL AS RUANG_ID,
				m_tarif_group.RADIOLOGI_CITO AS CITO,
				t_ipenunjang_tarif.TANGGAL_PERIKSA AS F_ORDER,
				t_irja.ST_BARU,t_ipenunjang.MCU,t_ipenunjang_tarif.JENIS_BAYAR_ID,
				"Hemodialisa" AS EXT_NAMA_UNIT,t_ipenunjang.PEGAWAI_ID,t_ipenunjang_tarif.PENUNJANG_TARIF_ID,
				m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER
				FROM t_ipenunjang
				INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF) 
				WHERE t_ipenunjang.JNS_ORDER = "HRJ"
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
				OR m_tarif.UNIT_ID = "17")
				AND DATE(t_ipenunjang_tarif.TANGGAL_PERIKSA) >= ' . $tgl_filter_1 . ' 
				AND DATE(t_ipenunjang_tarif.TANGGAL_PERIKSA) <= ' . $tgl_filter_2 . '
				AND t_ipenunjang_tarif.ST_BATAL IS NULL
				GROUP BY t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_TARIF,t_ipenunjang_tarif.PENUNJANG_TARIF_ID
				
				UNION
				SELECT t_ipenunjang.RAWAT_ID AS PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.NOMR,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang.JNS_ORDER,
				t_ipenunjang.UNIT_ID,NULL AS RUANG_ID,
				m_tarif_group.RADIOLOGI_CITO AS CITO,
				t_ipenunjang_tarif.TANGGAL_PERIKSA AS F_ORDER,
				t_irja.ST_BARU,t_ipenunjang.MCU,t_ipenunjang_tarif.JENIS_BAYAR_ID,
				"Kamar Operasi" AS EXT_NAMA_UNIT,t_ipenunjang.PEGAWAI_ID,t_ipenunjang_tarif.PENUNJANG_TARIF_ID,
				m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER
				FROM t_ipenunjang
				INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF) 
				WHERE t_ipenunjang.JNS_ORDER = "ORJ"
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
				OR m_tarif.UNIT_ID = "17")
				AND DATE(t_ipenunjang_tarif.TANGGAL_PERIKSA) >= ' . $tgl_filter_1 . ' 
				AND DATE(t_ipenunjang_tarif.TANGGAL_PERIKSA) <= ' . $tgl_filter_2 . '
				AND t_ipenunjang_tarif.ST_BATAL IS NULL
				GROUP BY t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_TARIF,t_ipenunjang_tarif.PENUNJANG_TARIF_ID
				UNION
				SELECT t_ipenunjang.RAWAT_ID AS PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.NOMR,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang.JNS_ORDER,
				NULL AS UNIT_ID,t_ipenunjang.RUANG_ID,
				m_tarif_group.RADIOLOGI_CITO AS CITO,
				t_ipenunjang_tarif.TANGGAL_PERIKSA AS F_ORDER,
				"" AS ST_BARU, "" AS MCU,t_ipenunjang_tarif.JENIS_BAYAR_ID,
				"Kamar Operasi" AS EXT_NAMA_UNIT,t_ipenunjang.PEGAWAI_ID,t_ipenunjang_tarif.PENUNJANG_TARIF_ID,
				m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF) 
				WHERE t_ipenunjang.JNS_ORDER = "ORI"
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
				OR m_tarif.UNIT_ID = "17")
				AND DATE(t_ipenunjang_tarif.TANGGAL_PERIKSA) >= ' . $tgl_filter_1 . ' 
				AND DATE(t_ipenunjang_tarif.TANGGAL_PERIKSA) <= ' . $tgl_filter_2 . '
				AND t_ipenunjang_tarif.ST_BATAL IS NULL
				GROUP BY t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_TARIF,t_ipenunjang_tarif.PENUNJANG_TARIF_ID
				
				UNION
				SELECT t_ipenunjang.RAWAT_ID AS PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.NOMR,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang.JNS_ORDER,
				NULL AS UNIT_ID,t_ipenunjang.RUANG_ID,
				m_tarif_group.RADIOLOGI_CITO AS CITO,
				t_ipenunjang_tarif.TANGGAL_PERIKSA AS F_ORDER,
				"" AS ST_BARU, "" AS MCU,t_ipenunjang_tarif.JENIS_BAYAR_ID,
				"" AS EXT_NAMA_UNIT,t_ipenunjang.PEGAWAI_ID,t_ipenunjang_tarif.PENUNJANG_TARIF_ID,
				m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF) 
				WHERE t_ipenunjang.JNS_ORDER = "IRN"
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
				OR m_tarif.UNIT_ID = "17")
				AND DATE(t_ipenunjang_tarif.TANGGAL_PERIKSA) >= ' . $tgl_filter_1 . ' 
				AND DATE(t_ipenunjang_tarif.TANGGAL_PERIKSA) <= ' . $tgl_filter_2 . '
				AND t_ipenunjang_tarif.ST_BATAL IS NULL
				GROUP BY t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_TARIF,t_ipenunjang_tarif.PENUNJANG_TARIF_ID
				UNION
				SELECT t_ipenunjang.RAWAT_ID AS PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.NOMR,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang.JNS_ORDER,
				NULL AS UNIT_ID,t_ipenunjang.RUANG_ID,
				m_tarif_group.RADIOLOGI_CITO AS CITO,
				t_ipenunjang_tarif.TANGGAL_PERIKSA AS F_ORDER,
				"" AS ST_BARU, "" AS MCU,t_ipenunjang_tarif.JENIS_BAYAR_ID,
				"Hemodialisa" AS EXT_NAMA_UNIT,t_ipenunjang.PEGAWAI_ID,t_ipenunjang_tarif.PENUNJANG_TARIF_ID,
				m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF) 
				WHERE t_ipenunjang.JNS_ORDER = "HRI"
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
				OR m_tarif.UNIT_ID = "17")
				AND DATE(t_ipenunjang_tarif.TANGGAL_PERIKSA) >= ' . $tgl_filter_1 . ' 
				AND DATE(t_ipenunjang_tarif.TANGGAL_PERIKSA) <= ' . $tgl_filter_2 . '
				AND t_ipenunjang_tarif.ST_BATAL IS NULL
				GROUP BY t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_TARIF,t_ipenunjang_tarif.PENUNJANG_TARIF_ID
				UNION
				SELECT t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.NO_PASIEN_PENUNJANG AS NOMR,"" AS RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang.JNS_ORDER,
				NULL AS UNIT_ID,NULL AS RUANG_ID,
				m_tarif_group.RADIOLOGI_CITO AS CITO,
				t_ipenunjang_tarif.TANGGAL_PERIKSA AS F_ORDER,
				"" AS ST_BARU, "" AS MCU,t_ipenunjang_tarif.JENIS_BAYAR_ID,
				"" AS EXT_NAMA_UNIT,NULL AS PEGAWAI_ID,t_ipenunjang_tarif.PENUNJANG_TARIF_ID,
				m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF) 
				WHERE t_ipenunjang.JNS_ORDER = "APS"
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
				OR m_tarif.UNIT_ID = "17")
				AND DATE(t_ipenunjang_tarif.TANGGAL_PERIKSA) >= ' . $tgl_filter_1 . ' 
				AND DATE(t_ipenunjang_tarif.TANGGAL_PERIKSA) <= ' . $tgl_filter_2 . '
				AND t_ipenunjang_tarif.ST_BATAL IS NULL
				GROUP BY t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.PENUNJANG_TARIF_ID
				) t_order 
				INNER JOIN m_jaminan ON (t_order.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				LEFT JOIN m_pasien ON (t_order.NOMR = m_pasien.NOMR)
				LEFT JOIN m_unit ON (t_order.UNIT_ID = m_unit.UNIT_ID)
				LEFT JOIN m_ruang ON (t_order.RUANG_ID = m_ruang.RUANG_ID)
				LEFT JOIN m_pegawai ON (t_order.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN t_ipenunjang ON (t_order.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID
					AND t_ipenunjang.JNS_ORDER = "APS")
				WHERE 1';
	
if(!empty($searchkey)){
	$qry_kunjungan = $qry_kunjungan . ' AND (t_order.NOMR LIKE "%' . $searchkey . '%"
										OR m_pasien.NAMA_PASIEN LIKE "%' . $searchkey . '%"
										OR t_ipenunjang.NAMA_PASIEN LIKE "%' . $searchkey . '%")';
}	
if (!empty($ruang_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_order.RUANG_ID = "' . $ruang_id . '" AND 
			(t_order.JNS_ORDER = "IRN" OR t_order.JNS_ORDER = "HRI" OR t_order.JNS_ORDER = "ORI")';
}
if (!empty($unit_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_order.UNIT_ID = "' . $unit_id . '" AND 
			(t_order.JNS_ORDER = "IRJ" OR t_order.JNS_ORDER = "HRJ" OR t_order.JNS_ORDER = "ORJ")';
}

$qry_kunjungan = $qry_kunjungan . ' ORDER BY F_ORDER';

$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&ruang_id=' . $ruang_id . '&unit_id=' . $unit_id;
$action = '<a href="index.php?link=' . md5('radiologiformdiagnosa') . '&idx=###" >proses</a>';
include('radiologi/radiologi_list_diagnosa.php');
?>
