<?php
if(isset($_GET['idb']) and isset($_GET['batal'])){
	mysql_query('UPDATE t_irna_booking_kamar
					SET ST_BOOKING = "Batal"
					WHERE BOOKING_KAMAR_ID = "' . $_GET['idb'] . '"') or die(mysql_error());
}

$tgl_1 = '';
if (isset($_SESSION['pendaftaransearchbookingkamar_tgl_1']))
    $tgl_1 = $_SESSION['pendaftaransearchbookingkamar_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['pendaftaransearchbookingkamar_tgl_1']))
    $tgl_2 = $_SESSION['pendaftaransearchbookingkamar_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['pendaftaransearchbookingkamar_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['pendaftaransearchbookingkamar_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['pendaftaransearchbookingkamar_searchkey']))
		$searchkey = $_SESSION['pendaftaransearchbookingkamar_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['pendaftaransearchbookingkamar_searchkey'] = $searchkey;
}
$ruang_id = '';
if (isset($_SESSION['pendaftaransearchbookingkamar_unit_id']))
		$ruang_id = $_SESSION['pendaftaransearchbookingkamar_unit_id'];

if (isset($_GET['unit_id'])) {
    $ruang_id = $_GET['unit_id'];
	$_SESSION['pendaftaransearchbookingkamar_unit_id'] = $ruang_id;
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
			<td>Nomor MR/ Nama Pasien</td>
			<td><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt" style="width:220px;" /></td>	
			<td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
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
			<td><input name="submit" type="submit" class="myButton" value="cari" />
				<a href="index.php?link=<?php echo md5('pendaftaranbookingkamarsearchpasien'); ?>"><input name="baru" type="button" class="myButton" value="tambah booking" /></a></td>
			<td>&nbsp;</td>
            <td align="right">&nbsp;</td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_kunjungan = 'SELECT t_irna_booking_kamar.IRNA_ID, t_irna_booking_kamar.NOMR, t_irna_booking_kamar.TANGGAL_BOOKING,
	m_ruang.NAMA_RUANG,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NAMA_IBU,
	t_irna_booking_kamar.USER_PENDAFTARAN,t_irna_booking_kamar.ST_BOOKING,m_ruang.KELAS_RAWAT,t_irna_booking_kamar.EMERGENCY,
	t_irna_booking_kamar.BOOKING_KAMAR_ID,t_irna_booking_kamar.DW_AN_BY
	FROM t_irna_booking_kamar
	INNER JOIN m_pasien ON (t_irna_booking_kamar.NOMR = m_pasien.NOMR) 
	LEFT JOIN m_ruang ON (t_irna_booking_kamar.RUANG_ID = m_ruang.RUANG_ID)
	WHERE (t_irna_booking_kamar.ST_BOOKING IS NULL 
	OR (t_irna_booking_kamar.TANGGAL_BOOKING >= ' . $tgl_filter_1 . ' 
	AND t_irna_booking_kamar.TANGGAL_BOOKING <= ' . $tgl_filter_2 . '))';
	
if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_kunjungan = $qry_kunjungan . ' AND CONCAT(m_pasien.NOMR,m_pasien.NAMA_PASIEN) LIKE "%' . $searchkey . '%"';
}	
if (!empty($ruang_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_irna_booking_kamar.RUANG_ID = "' . $ruang_id . '"';
}

$qry_kunjungan = $qry_kunjungan . ' ORDER BY t_irna_booking_kamar.TANGGAL_BOOKING DESC,m_pasien.NAMA_PASIEN,m_pasien.NOMR';

$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&unit_id=' . $ruang_id;
include('pendaftaran/pendaftaran_list_booking_kamar.php');
?>
