<?php
$tgl_1 = '';
if (isset($_SESSION['rmsearchirja_tgl_1']))
    $tgl_1 = $_SESSION['rmsearchirja_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['rmsearchirja_tgl_1']))
    $tgl_2 = $_SESSION['rmsearchirja_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['rmsearchirja_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['rmsearchirja_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['rmsearchirja_searchkey']))
		$searchkey = $_SESSION['rmsearchirja_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['rmsearchirja_searchkey'] = $searchkey;
}
$unit_id = '';
if (isset($_SESSION['rmsearchirja_unit_id']))
		$unit_id = $_SESSION['rmsearchirja_unit_id'];

if (isset($_GET['unit_id'])) {
    $unit_id = $_GET['unit_id'];
	$_SESSION['rmsearchirja_unit_id'] = $unit_id;
}
$jaminan_id = '';
if (isset($_SESSION['rmsearchirja_jaminan_id']))
		$jaminan_id = $_SESSION['rmsearchirja_jaminan_id'];

if (isset($_GET['jaminan_id'])) {
    $jaminan_id = $_GET['jaminan_id'];
	$_SESSION['rmsearchirja_jaminan_id'] = $jaminan_id;
}
$shift_id = '';
if (isset($_SESSION['rmsearchirja_shift_id']))
		$shift_id = $_SESSION['rmsearchirja_shift_id'];

if (isset($_GET['shift_id'])) {
    $shift_id = $_GET['shift_id'];
	$_SESSION['rmsearchirja_shift_id'] = $shift_id;
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
			<td>Klinik</td>
			<td><select name="unit_id" id="unit_id" class="text_dt" style="width:228px;">
			<option value=""> - </option>
			<?php echo getUnit('irja',$unit_id); ?>
            </select></td>	
			<td>&nbsp;</td>
			<td>&nbsp;</td>
            <td align="right"><input name="submit" type="submit" class="myButton" value="cari" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_kunjungan = 'SELECT t_irja.IRJA_ID, t_irja.NOMR, t_irja.TANGGAL_DAFTAR,
	CASE t_irja.ST_BARU
	WHEN "1" THEN "v" END AS ST_BARU_LAMA,
	CASE t_irja.ST_RUJUKAN
	WHEN "1" THEN "v" END AS ST_RUJUKAN,
	m_unit.NAMA_UNIT,m_jaminan.NAMA_JAMINAN,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NAMA_IBU,
	t_irja.USER_RM,t_irja.PRINT_TRACER,t_irja.PRINT_RRKRJ,t_rm_tracer.RM_TRACER_ID
	FROM t_irja
	INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR) 
	LEFT JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
	LEFT JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
	LEFT JOIN t_rm_tracer ON (t_irja.IRJA_ID = t_rm_tracer.IRJA_ID)
	WHERE t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL 
	AND t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2;
	
if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_kunjungan = $qry_kunjungan . ' AND CONCAT(m_pasien.NOMR,m_pasien.NAMA_PASIEN) LIKE "%' . $searchkey . '%"';
}	
if (!empty($unit_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_irja.UNIT_ID = "' . $unit_id . '"';
}
if (!empty($jaminan_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_irja.JENIS_BAYAR_ID = "' . $jaminan_id . '"';
}
if (!empty($shift_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_irja.SHIFT_ID = "' . $shift_id . '"';
}

$qry_kunjungan = $qry_kunjungan . ' ORDER BY t_irja.IRJA_ID';

$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&unit_id=' . $unit_id . '&jaminan_id=' . $jaminan_id . '&shift_id=' . $shift_id;;
$action = '#';
include('casemix/casemix_list_kunjungan_irja.php');
?>
