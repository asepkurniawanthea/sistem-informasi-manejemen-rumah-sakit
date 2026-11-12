<?php
$tgl_1 = '';
$searchkey = '';
if (isset($_SESSION['pendaftaransearchrujukan_searchkey']))
		$searchkey = $_SESSION['pendaftaransearchrujukan_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['pendaftaransearchrujukan_searchkey'] = $searchkey;
}
$unit_id = '';
if (isset($_SESSION['pendaftaransearchrujukan_unit_id']))
		$unit_id = $_SESSION['pendaftaransearchrujukan_unit_id'];

if (isset($_GET['unit_id'])) {
    $unit_id = $_GET['unit_id'];
	$_SESSION['pendaftaransearchrujukan_unit_id'] = $unit_id;
}

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}	
?>
<form name="search" method="get" action="index.php">
    <table class="tableform" border="0" >
        <tr>
        	<td>Klinik</td>
			<td><select name="unit_id" id="unit_id" class="text_dt" style="width:228px;">
			<option value=""> - </option>
			<?php echo getUnit('umumigd',$unit_id); ?>
            </select></td>	
		<tr>	
			<td>Nomor MR/ Nama Pasien</td>
            <td><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt"/>
			&nbsp;&nbsp;&nbsp;<input type="submit" value="cari" class="myButton" /></td>
        </tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_kunjungan = 'SELECT t_irja.IRJA_ID, t_irja.NOMR, t_irja.TANGGAL_DAFTAR,t_irja.RUJUKAN_UNIT_ID,
	m_unit.NAMA_UNIT,m_jaminan.NAMA_JAMINAN,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NAMA_IBU,
	t_irja.USER_IRJA
	FROM t_irja
	INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR) 
	LEFT JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
	LEFT JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
	WHERE t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL
	AND t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1;
	
if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_kunjungan = $qry_kunjungan . ' AND CONCAT(m_pasien.NOMR,m_pasien.NAMA_PASIEN) LIKE "%' . $searchkey . '%"';
}	
if (!empty($unit_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_irja.UNIT_ID = "' . $unit_id . '"';
}

$qry_kunjungan = $qry_kunjungan . ' ORDER BY m_pasien.NAMA_PASIEN,m_pasien.NOMR';

$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&unit_id=' . $unit_id;
$action = '<a href="index.php?link=' . md5('pendaftaranformdaftarrujuk') . '&idx=###" >daftar rujuk</a>';
include('pendaftaran/pendaftaran_list_kunjungan_rujukan.php');
?>
