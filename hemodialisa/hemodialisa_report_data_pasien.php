<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tgl_1 = '';
if (isset($_SESSION['hemodialisasearchpasiendaftar_tgl_1']))
    $tgl_1 = $_SESSION['hemodialisasearchpasiendaftar_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['hemodialisasearchpasiendaftar_tgl_1']))
    $tgl_2 = $_SESSION['hemodialisasearchpasiendaftar_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['hemodialisasearchpasiendaftar_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['hemodialisasearchpasiendaftar_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['hemodialisasearchpasiendaftar_searchkey']))
		$searchkey = $_SESSION['hemodialisasearchpasiendaftar_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['hemodialisasearchpasiendaftar_searchkey'] = $searchkey;
}
$jaminan_id = '';
if (isset($_SESSION['hemodialisasearchpasiendaftar_jaminan_id']))
		$jaminan_id = $_SESSION['hemodialisasearchpasiendaftar_jaminan_id'];

if (isset($_GET['jaminan_id'])) {
    $jaminan_id = $_GET['jaminan_id'];
	$_SESSION['hemodialisasearchpasiendaftar_jaminan_id'] = $jaminan_id;
}

$pegawai_id = '';
if (isset($_SESSION['hemodialisasearchpasiendaftar_pegawai_id']))
		$pegawai_id = $_SESSION['hemodialisasearchpasiendaftar_pegawai_id'];

if (isset($_GET['pegawai_id'])) {
    $pegawai_id = $_GET['pegawai_id'];
	$_SESSION['hemodialisasearchpasiendaftar_pegawai_id'] = $pegawai_id;
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
			<td>Dokter Pelaksana</td>
			<td><select name="pegawai_id" class="text_dt" >
				<option value=""> - </option>
				<?php echo getDokter($pegawai_id,$_SESSION['SES_SIMRS_UNIT_ID']); ?>
			</select></td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/></td>
			<td>Jenis Pembayaran</td>
			<td> <select name="jaminan_id" id="jaminan_id" class="text_dt" style="width:150px;">
                    <option value=""> - </option>
                    <?php echo getJnsBayar($jaminan_id,''); ?>
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
$qry_kunjungan = 'SELECT * FROM (SELECT t_irja.IRJA_ID, t_irja.NOMR, t_irja.TANGGAL_DAFTAR,
	t_irja.ST_BARU AS ST_BARU_LAMA,m_unit.NAMA_UNIT,m_jaminan.NAMA_JAMINAN,
	m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NAMA_IBU,
	t_irja.USER_IRJA_MASUK,m_pegawai.NAMA_PEGAWAI,DATE_FORMAT(t_irja.PASIEN_MASUK,"%d/%m/%Y %H:%i:%s") AS PASIEN_MASUK,
	DATE_FORMAT(t_irja.PASIEN_KELUAR,"%d/%m/%Y %H:%i:%s") AS PASIEN_KELUAR,
	t_irja.POD,t_irja.JENIS_BAYAR_ID,t_irja.PEGAWAI_ID,"" AS PENGIRIM
	FROM t_irja
	INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR) 
	LEFT JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
	LEFT JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
	LEFT JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)	
	WHERE t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL 
	AND t_irja.UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '"
	AND t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . '
	AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
	UNION
	SELECT t_hemodialisa.HEMODIALISA_ID AS IRJA_ID, t_hemodialisa.NOMR, t_hemodialisa.TANGGAL_ORDER AS TANGGAL_DAFTAR,
	t_hemodialisa.ST_BARU AS ST_BARU_LAMA,m_unit.NAMA_UNIT,m_jaminan.NAMA_JAMINAN,
	m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NAMA_IBU,
	t_hemodialisa.USER_IRJA_MASUK,m_pegawai.NAMA_PEGAWAI,DATE_FORMAT(t_hemodialisa.PASIEN_MASUK,"%d/%m/%Y %H:%i:%s") AS PASIEN_MASUK,
	DATE_FORMAT(t_hemodialisa.PASIEN_KELUAR,"%d/%m/%Y %H:%i:%s") AS PASIEN_KELUAR,
	"" AS POD,t_hemodialisa.JENIS_BAYAR_ID,t_hemodialisa.PEGAWAI_PERIKSA_ID AS PEGAWAI_ID,
	CASE WHEN t_hemodialisa.JNS_ORDER = "IRJ" THEN m_unit.NAMA_UNIT
		WHEN t_hemodialisa.JNS_ORDER = "IRN" THEN m_ruang.NAMA_RUANG
	END AS PENGIRIM	
	FROM t_hemodialisa
	INNER JOIN m_pasien ON (t_hemodialisa.NOMR = m_pasien.NOMR) 
	LEFT JOIN m_unit ON (t_hemodialisa.UNIT_ID = m_unit.UNIT_ID)
	LEFT JOIN m_ruang ON (t_hemodialisa.RUANG_ID = m_ruang.RUANG_ID)
	LEFT JOIN m_jaminan ON (t_hemodialisa.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
	LEFT JOIN m_pegawai ON (t_hemodialisa.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)	
	WHERE t_hemodialisa.NO_ORDER IS NOT NULL AND t_hemodialisa.ST_BATAL IS NULL 
	AND t_hemodialisa.PASIEN_MASUK IS NOT NULL
	AND (t_hemodialisa.JNS_ORDER = "IRJ" OR t_hemodialisa.JNS_ORDER = "IRN")  	
	AND STR_TO_DATE(DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),"%d/%m/%Y")  >= ' . $tgl_filter_1 . '
	AND STR_TO_DATE(DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
	) t_hemodialisa';
	
if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_kunjungan = $qry_kunjungan . ' AND CONCAT(t_hemodialisa.NOMR,t_hemodialisa.NAMA_PASIEN) LIKE "%' . $searchkey . '%"';
}	
if (!empty($jaminan_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_hemodialisa.JENIS_BAYAR_ID = "' . $jaminan_id . '"';
}
if (!empty($pegawai_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_hemodialisa.PEGAWAI_ID = "' . $pegawai_id . '"';
}	
	$qry_kunjungan = $qry_kunjungan . ' ORDER BY t_hemodialisa.TANGGAL_DAFTAR';

$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&jaminan_id=' . $jaminan_id . '&pegawai_id=' . $pegawai_id;
include('hemodialisa/hemodialisa_list_data_pasien.php');
?>
