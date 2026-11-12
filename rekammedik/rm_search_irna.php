<?php
$tgl_1 = '';
if (isset($_SESSION['pendaftaransearchirna_tgl_1']))
    $tgl_1 = $_SESSION['pendaftaransearchirna_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['pendaftaransearchirna_tgl_1']))
    $tgl_2 = $_SESSION['pendaftaransearchirna_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['pendaftaransearchirna_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['pendaftaransearchirna_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['pendaftaransearchirna_searchkey']))
		$searchkey = $_SESSION['pendaftaransearchirna_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['pendaftaransearchirna_searchkey'] = $searchkey;
}
$ruang_id = '';
if (isset($_SESSION['pendaftaransearchirna_unit_id']))
		$ruang_id = $_SESSION['pendaftaransearchirna_unit_id'];

if (isset($_GET['unit_id'])) {
    $ruang_id = $_GET['unit_id'];
	$_SESSION['pendaftaransearchirna_unit_id'] = $ruang_id;
}
$jaminan_id = '';
if (isset($_SESSION['pendaftaransearchirna_jaminan_id']))
		$jaminan_id = $_SESSION['pendaftaransearchirna_jaminan_id'];

if (isset($_GET['jaminan_id'])) {
    $jaminan_id = $_GET['jaminan_id'];
	$_SESSION['pendaftaransearchirna_jaminan_id'] = $jaminan_id;
}
$shift_id = '';
if (isset($_SESSION['pendaftaransearchirna_shift_id']))
		$shift_id = $_SESSION['pendaftaransearchirna_shift_id'];

if (isset($_GET['shift_id'])) {
    $shift_id = $_GET['shift_id'];
	$_SESSION['pendaftaransearchirna_shift_id'] = $shift_id;
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
			<td>Jenis Pembayaran</td>
			<td> <select name="jaminan_id" id="jaminan_id" class="text_dt" style="width:228px;">
                    <option value=""> - </option>
                    <?php echo getJnsBayar($jaminan_id,''); ?>
                </select></td>	
			<td>Nomor MR/ Nama Pasien</td>
            <td colspan="2"><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt"/></td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/>            </td>	
			<td>Ruang</td>
			<td><select name="unit_id" id="unit_id" class="text_dt" style="width:228px;">
			<option value=""> - </option>
			<?php echo getRuangRawat($ruang_id); ?>
            </select></td>	
			<td>&nbsp;</td>
			<td>&nbsp;</td>
            <td align="right"><input name="submit" type="submit" class="myButton" value="cari" />&nbsp;
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_kunjungan = 'SELECT t_irna.IRNA_ID, t_irna.NOMR, t_irna.TANGGAL_DAFTAR,t_irna.PASIEN_KELUAR,
	m_ruang.NAMA_RUANG,m_jaminan.NAMA_JAMINAN,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NAMA_IBU,
	t_irna.USER_PENDAFTARAN,m_pasien_pulang.KET_PASIEN_PULANG,t_irna.ST_PULANG,t_irna.KELAS_RAWAT,
	DATE_FORMAT(t_irna.PASIEN_MASUK,"%d/%m/%Y %H:%i") AS PASIEN_MASUK,m_pegawai.NAMA_PEGAWAI,
	DATEDIFF(t_irna.PASIEN_KELUAR,t_irna.PASIEN_MASUK) + 1 AS LOS,
	t_rm_tracer.RM_TERIMA
	FROM t_irna
	INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR) 
	LEFT JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
	LEFT JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
	LEFT JOIN m_pasien_pulang ON (t_irna.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID) 
	LEFT JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID) 
	LEFT JOIN t_rm_tracer ON (t_irna.IRNA_ID = t_rm_tracer.IRJA_ID)		
	WHERE t_irna.NO_PENDAFTARAN IS NOT NULL AND t_irna.ST_BATAL IS NULL
	AND (t_irna.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND t_irna.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . ')';
	
if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_kunjungan = $qry_kunjungan . ' AND CONCAT(m_pasien.NOMR,m_pasien.NAMA_PASIEN) LIKE "%' . $searchkey . '%"';
}	
if (!empty($ruang_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_irna.RUANG_ID = "' . $ruang_id . '"';
}

if (!empty($jaminan_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_irna.JENIS_BAYAR_ID = "' . $jaminan_id . '"';
}

$qry_kunjungan = $qry_kunjungan . ' GROUP BY t_irna.IRNA_ID 
				ORDER BY m_pasien.NAMA_PASIEN';

$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&unit_id=' . $ruang_id . '&jaminan_id=' . $jaminan_id . '&shift_id=' . $shift_id;
$action = '#';
include('rekammedik/rm_list_irna.php');
?>
