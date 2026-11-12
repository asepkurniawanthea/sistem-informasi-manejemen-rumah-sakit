<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tgl_1 = '';
if (isset($_SESSION['askepsearchpasienperiksa_tgl_1']))
    $tgl_1 = $_SESSION['askepsearchpasienperiksa_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['askepsearchpasienperiksa_tgl_1']))
    $tgl_2 = $_SESSION['askepsearchpasienperiksa_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['askepsearchpasienperiksa_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['askepsearchpasienperiksa_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['askepsearchpasienperiksa_searchkey']))
		$searchkey = $_SESSION['askepsearchpasienperiksa_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['askepsearchpasienperiksa_searchkey'] = $searchkey;
}
$jaminan_id = '';
if (isset($_SESSION['askepsearchpasienperiksa_jaminan_id']))
		$jaminan_id = $_SESSION['askepsearchpasienperiksa_jaminan_id'];

if (isset($_GET['jaminan_id'])) {
    $jaminan_id = $_GET['jaminan_id'];
	$_SESSION['askepsearchpasienperiksa_jaminan_id'] = $jaminan_id;
}

$ruang_id = '';
if (isset($_SESSION['askepsearchpasienperiksa_ruang_id']))
		$ruang_id = $_SESSION['askepsearchpasienperiksa_ruang_id'];

if (isset($_GET['ruang_id'])) {
    $ruang_id = $_GET['ruang_id'];
	$_SESSION['askepsearchpasienperiksa_ruang_id'] = $ruang_id;
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
			<td>Ruang Rawat</td>
			<td><select name="ruang_id" class="text_dt" >
				<option value=""> - </option>
				<?php echo getRuangRawat1($ruang_id); ?>
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
			<td align="right" colspan="2"><input type="submit" value="cari" class="myButton" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_kunjungan = 'SELECT t_irna.IRNA_ID, t_irna.NOMR,DATE_FORMAT(t_irna.PASIEN_MASUK,"%d/%m/%Y %H:%i:%s") AS PASIEN_MASUK,
	DATE_FORMAT(t_irna.PASIEN_KELUAR,"%d/%m/%Y %H:%i:%s") AS PASIEN_KELUAR,
	m_ruang.NAMA_RUANG,m_jaminan.NAMA_JAMINAN,t_irna.NO_TMP_TIDUR,
	m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NAMA_IBU,
	t_irna.USER_IRNA,m_pegawai.NAMA_PEGAWAI,m_pasien_pulang.KET_PASIEN_PULANG,t_irna.NO_RAWAT,
	m_ruang.KELAS_RAWAT,t_irna.ST_ASKEP
	FROM t_irna
	INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR) 
	LEFT JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
	LEFT JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
	LEFT JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
	LEFT JOIN m_pasien_pulang ON (t_irna.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID)
	WHERE t_irna.PASIEN_MASUK IS NOT NULL
	AND t_irna.ST_PINDAH IS NULL	
	AND ((STR_TO_DATE(DATE_FORMAT(t_irna.PASIEN_MASUK,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . '
	AND STR_TO_DATE(DATE_FORMAT(t_irna.PASIEN_MASUK,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . ')
	OR t_irna.ST_PULANG IS NULL)';
	
if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_kunjungan = $qry_kunjungan . ' AND CONCAT(m_pasien.NOMR,m_pasien.NAMA_PASIEN) LIKE "%' . $searchkey . '%"';
}	
if (!empty($jaminan_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_irna.JENIS_BAYAR_ID = "' . $jaminan_id . '"';
}

if (!empty($ruang_id)) {
    //$qry_kunjungan = $qry_kunjungan . ' AND t_irna.RUANG_ID = "' . $ruang_id . '"';
	$qry_kunjungan = $qry_kunjungan . ' AND m_ruang.NAMA_RUANG LIKE "%' . $ruang_id . '"';
}

$qry_kunjungan = $qry_kunjungan . 'ORDER BY t_irna.IRNA_ID';

$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&jaminan_id=' . $jaminan_id . '&ruang_id=' . $ruang_id;;
include('askep/askep_list_pasien.php');
?>
