<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tgl_1 = '';
if (isset($_SESSION['kliniksearchpasienperiksa_tgl_1']))
    $tgl_1 = $_SESSION['kliniksearchpasienperiksa_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['kliniksearchpasienperiksa_tgl_1']))
    $tgl_2 = $_SESSION['kliniksearchpasienperiksa_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['kliniksearchpasienperiksa_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['kliniksearchpasienperiksa_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['kliniksearchpasienperiksa_searchkey']))
		$searchkey = $_SESSION['kliniksearchpasienperiksa_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['kliniksearchpasienperiksa_searchkey'] = $searchkey;
}
$jaminan_id = '';
if (isset($_SESSION['kliniksearchpasienperiksa_jaminan_id']))
		$jaminan_id = $_SESSION['kliniksearchpasienperiksa_jaminan_id'];

if (isset($_GET['jaminan_id'])) {
    $jaminan_id = $_GET['jaminan_id'];
	$_SESSION['kliniksearchpasienperiksa_jaminan_id'] = $jaminan_id;
}

$unit_id = '';
if (isset($_SESSION['kliniksearchpasienperiksa_unit_id']))
		$unit_id = $_SESSION['kliniksearchpasienperiksa_unit_id'];

if (isset($_GET['unit_id'])) {
    $unit_id = $_GET['unit_id'];
	$_SESSION['kliniksearchpasienperiksa_unit_id'] = $unit_id;
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
    <table class="tableform" >
        <tr>
            <td>Tanggal</td>
            <td><input type="text" name="tgl_1" id="tgl_1" value="<?php echo $tgl_1; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
			<td>Nomor MR/ Nama Pasien</td>
            <td><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt"/></td>	
			<td>Poliklinik/ Ruang</td>
			<td><select name="unit_id" id="unit_id" class="text_dt" style="width:228px;">
			<option value=""> - </option>
			<?php echo getUnit('umumigd',$unit_id); ?>
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
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_kunjungan = 'SELECT t_irja.IRJA_ID,t_irja.NOMR,
	DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d-%m-%Y") AS PASIEN_MASUK,
	DATE_FORMAT(t_irja.PASIEN_KELUAR,"%d-%m-%Y") AS PASIEN_KELUAR,
	t_irja.ST_BARU AS ST_BARU_LAMA,
	t_irja.NO_PESERTA,
	m_unit.NAMA_UNIT,
	m_jaminan.NAMA_JAMINAN,
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
	m_kelurahan.NAMA_KELURAHAN,
	m_kecamatan.NAMA_KECAMATAN,
	m_kota.NAMA_KOTA
	FROM t_irja
	INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR) 
	LEFT JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
	LEFT JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
	LEFT JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
	LEFT JOIN m_pasien_pulang ON (t_irja.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID)
	LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
	LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
	LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
	WHERE t_irja.NO_PENDAFTARAN IS NOT NULL 
	AND t_irja.ST_BATAL IS NULL 
	AND (t_irja.ST_BARU = "" OR t_irja.ST_BARU = "0")
	AND STR_TO_DATE(DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . '
	AND STR_TO_DATE(DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2;
	
if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_kunjungan = $qry_kunjungan . ' AND CONCAT(m_pasien.NOMR,m_pasien.NAMA_PASIEN) LIKE "%' . $searchkey . '%"';
}	
if (!empty($jaminan_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_irja.JENIS_BAYAR_ID = "' . $jaminan_id . '"';
}

if (!empty($unit_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_irja.UNIT_ID = "' . $unit_id . '"';
}

$qry_kunjungan = $qry_kunjungan . 'ORDER BY t_irja.IRJA_ID';

$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&jaminan_id=' . $jaminan_id . '&unit_id=' . $unit_id;;
include('ipaap/ipaap_list_pasien_lama.php');
?>