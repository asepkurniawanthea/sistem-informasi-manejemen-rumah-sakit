<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tgl_1 = '';
if (isset($_SESSION['kliniksearchpasiendaftar_tgl_1']))
    $tgl_1 = $_SESSION['kliniksearchpasiendaftar_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['kliniksearchpasiendaftar_tgl_1']))
    $tgl_2 = $_SESSION['kliniksearchpasiendaftar_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['kliniksearchpasiendaftar_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['kliniksearchpasiendaftar_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['kliniksearchpasiendaftar_searchkey']))
		$searchkey = $_SESSION['kliniksearchpasiendaftar_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['kliniksearchpasiendaftar_searchkey'] = $searchkey;
}
$jaminan_id = '';
if (isset($_SESSION['kliniksearchpasiendaftar_jaminan_id']))
		$jaminan_id = $_SESSION['kliniksearchpasiendaftar_jaminan_id'];

if (isset($_GET['jaminan_id'])) {
    $jaminan_id = $_GET['jaminan_id'];
	$_SESSION['kliniksearchpasiendaftar_jaminan_id'] = $jaminan_id;
}

$pegawai_id = '';
if (isset($_SESSION['kliniksearchpasiendaftar_pegawai_id']))
		$pegawai_id = $_SESSION['kliniksearchpasiendaftar_pegawai_id'];

if (isset($_GET['pegawai_id'])) {
    $pegawai_id = $_GET['pegawai_id'];
	$_SESSION['kliniksearchpasiendaftar_pegawai_id'] = $pegawai_id;
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
    <table class="tableform" border="0">
        <tr>
            <td>Tanggal</td>
            <td><input type="text" name="tgl_1" id="tgl_1" value="<?php echo $tgl_1; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
			<td>Nomor MR/ Nama Pasien</td>
            <td><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt"/></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/></td>
			<td>Dokter Pelaksana</td>
			<td><select name="pegawai_id" class="text_dt" >
				<option value=""> - </option>
				<?php echo getDokter($pegawai_id,$_SESSION['SES_SIMRS_UNIT_ID']); ?>
			</select></td>		
            <td align="right" colspan="2"><input type="submit" value="cari" class="myButton" />&nbsp;
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" />
			</td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_kunjungan = 'SELECT t_irja.IRJA_ID, t_irja.TANGGAL_DAFTAR,
	t_irja.NOMR,m_pasien.NAMA_PASIEN,t_irja.KUSTA_MDT_MULAI,
	m_pasien.TGL_LAHIR,
	CASE WHEN (DATEDIFF(t_irja.TANGGAL_DAFTAR, m_pasien.TGL_LAHIR)/365) >= 14 
		THEN "Dewasa" ELSE "Anak" END AS USIA,
	CASE WHEN t_irja.KUSTA_TYPE = "NR" THEN "1" ELSE "0" END AS NR,	
	CASE WHEN t_irja.KUSTA_TYPE = "TT" THEN "1" ELSE "0" END AS TT,
	CASE WHEN t_irja.KUSTA_TYPE = "BT" THEN "1" ELSE "0" END AS BT,
	CASE WHEN t_irja.KUSTA_TYPE = "BB" THEN "1" ELSE "0" END AS BB,
	CASE WHEN t_irja.KUSTA_TYPE = "BL" THEN "1" ELSE "0" END AS BL,
	CASE WHEN t_irja.KUSTA_TYPE = "LL" THEN "1" ELSE "0" END AS LL,
	CASE WHEN t_irja.KUSTA_TYPE = "OM" THEN "1" ELSE "0" END AS OBSERVASI,
	CASE WHEN t_irja.KUSTA_TYPE = "NM" THEN "1" ELSE "0" END AS NON_MH,
	m_kota.NAMA_KOTA,m_pegawai.NAMA_PEGAWAI,t_irja.KUSTA_RFT_COT,
	CASE WHEN t_irja.POD = "1" THEN "1" END AS POD_TANPA_CACAT,
	CASE WHEN t_irja.POD = "2" THEN "1" END AS POD_CACAT_TK1,
	CASE WHEN t_irja.POD = "3" THEN "1" END AS POD_CACAT_TK2,
	m_propinsi.NAMA_PROPINSI,
	t_irja.KUSTA_PENYAKIT_LAIN,
	t_irja.KUSTA_OPNAME,t_irja.KUSTA_KETERANGAN_OPNAME,
	t_irja.KUSTA_KUNJUNGAN,
	m_pasien_pulang.KET_PASIEN_PULANG,
	(
		SELECT COUNT(xrj.IRJA_ID)
		FROM t_irja xrj
		WHERE xrj.NOMR = t_irja.NOMR 
		AND xrj.UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '"
		AND DATE_FORMAT(xrj.TANGGAL_DAFTAR,"%m%Y") = DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m%Y")
		AND xrj.IRJA_ID < t_irja.IRJA_ID	
	) AS JML_KUNJUNGAN	
	FROM t_irja
	INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR) 
	LEFT JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)	
	LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)	
	LEFT JOIN m_propinsi ON (m_pasien.PROPINSI_ID = m_propinsi.PROPINSI_ID)	
	LEFT JOIN m_pasien_pulang ON (t_irja.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID)	
	WHERE t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL 
	AND t_irja.UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '"
	AND t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . '
	AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2;
	
if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_kunjungan = $qry_kunjungan . ' AND CONCAT(m_pasien.NOMR,m_pasien.NAMA_PASIEN) LIKE "%' . $searchkey . '%"';
}	
if (!empty($jaminan_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_irja.JENIS_BAYAR_ID = "' . $jaminan_id . '"';
}
if (!empty($pegawai_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_irja.PEGAWAI_ID = "' . $pegawai_id . '"';
}	
	$qry_kunjungan = $qry_kunjungan . 'ORDER BY t_irja.IRJA_ID';

$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&jaminan_id=' . $jaminan_id . '&pegawai_id=' . $pegawai_id;
include('klinik/klinik_list_pasien_harian_kusta.php');
?>
