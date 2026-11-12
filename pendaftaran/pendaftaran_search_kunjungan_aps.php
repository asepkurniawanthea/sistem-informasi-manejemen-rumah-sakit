<?php
$tgl_1 = '';
if (isset($_SESSION['pendaftaransearchkunjpenunjang_tgl_1']))
    $tgl_1 = $_SESSION['pendaftaransearchkunjpenunjang_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['pendaftaransearchkunjpenunjang_tgl_1']))
    $tgl_2 = $_SESSION['pendaftaransearchkunjpenunjang_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['pendaftaransearchkunjpenunjang_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['pendaftaransearchkunjpenunjang_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['pendaftaransearchkunjpenunjang_searchkey']))
		$searchkey = $_SESSION['pendaftaransearchkunjpenunjang_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['pendaftaransearchkunjpenunjang_searchkey'] = $searchkey;
}
$unit_id = '';
if (isset($_SESSION['pendaftaransearchkunjpenunjang_unit_id']))
		$unit_id = $_SESSION['pendaftaransearchkunjpenunjang_unit_id'];

if (isset($_GET['unit_id'])) {
    $unit_id = $_GET['unit_id'];
	$_SESSION['pendaftaransearchkunjpenunjang_unit_id'] = $unit_id;
}
$jaminan_id = '';
if (isset($_SESSION['pendaftaransearchkunjpenunjang_jaminan_id']))
		$jaminan_id = $_SESSION['pendaftaransearchkunjpenunjang_jaminan_id'];

if (isset($_GET['jaminan_id'])) {
    $jaminan_id = $_GET['jaminan_id'];
	$_SESSION['pendaftaransearchkunjpenunjang_jaminan_id'] = $jaminan_id;
}
$shift_id = '';
if (isset($_SESSION['pendaftaransearchkunjpenunjang_shift_id']))
		$shift_id = $_SESSION['pendaftaransearchkunjpenunjang_shift_id'];

if (isset($_GET['shift_id'])) {
    $shift_id = $_GET['shift_id'];
	$_SESSION['pendaftaransearchkunjpenunjang_shift_id'] = $shift_id;
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
			<td>Nomor APS/ Nama Pasien</td>
            <td colspan="2"><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt"/></td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/>            </td>	
			<td>Unit Penunjang</td>
			<td><select name="unit_id" id="unit_id" class="text_dt" style="width:228px;">
			<option value=""> - </option>
			<?php echo getUnit('pnj',$unit_id); ?>
            </select></td>	
			<td>Shift</td>
			<td><select name="shift_id" id="shift_id" class="text_dt" style="width:80px;" >
				<option value=""> - </option>
				<option value="1" <?php if($shift_id == '1') echo 'selected="selected"'; ?> >1</option>
				<option value="2" <?php if($shift_id == '2') echo 'selected="selected"'; ?> >2</option>
				<option value="3" <?php if($shift_id == '3') echo 'selected="selected"'; ?> >3</option>
			  </select></td>
            <td align="right"><input name="submit" type="submit" class="myButton" value="cari" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_kunjungan = 'SELECT * FROM (SELECT "1" AS JNS_P,t_ipenunjang.PENUNJANG_ID, t_ipenunjang.RAWAT_ID,
	t_ipenunjang.NO_PASIEN_PENUNJANG AS NOMR,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
	m_unit.NAMA_UNIT,m_jaminan.NAMA_JAMINAN,t_ipenunjang_tarif.UNIT_PENUNJANG_ID,
	t_ipenunjang.NAMA_PASIEN,t_ipenunjang.TGL_LAHIR,t_ipenunjang.JNS_KELAMIN,
	t_ipenunjang.ALAMAT,t_ipenunjang.INSTANSI_PENGIRIM AS NAMA_UNIT_PENGIRIM,
	t_ipenunjang.PENGIRIM AS NAMA_PEGAWAI,t_ipenunjang_tarif.USER_PENDAFTARAN,t_ipenunjang_tarif.NO_SJP,
	t_ipenunjang.JNS_ORDER,t_ipenunjang.JENIS_BAYAR_ID,t_ipenunjang.NAMA_IBU
	FROM t_ipenunjang
	INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID) 
	LEFT JOIN m_unit m_unit_pengirim ON (t_ipenunjang.UNIT_ID = m_unit_pengirim.UNIT_ID)
	LEFT JOIN m_unit ON (t_ipenunjang_tarif.UNIT_PENUNJANG_ID = m_unit.UNIT_ID)
	LEFT JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
	LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
	WHERE t_ipenunjang_tarif.NO_TARIF IS NOT NULL AND t_ipenunjang_tarif.ST_BATAL IS NULL
	AND t_ipenunjang.JNS_ORDER = "APS"
	AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
	AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
	GROUP BY t_ipenunjang.PENUNJANG_ID, t_ipenunjang.RAWAT_ID, t_ipenunjang_tarif.NO_SJP) t_tran WHERE 1';
	
if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_kunjungan = $qry_kunjungan . ' AND CONCAT(NOMR,NAMA_PASIEN) LIKE "%' . $searchkey . '%"';
}	
if (!empty($unit_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND UNIT_PENUNJANG_ID = "' . $unit_id . '"';
}

if (!empty($jaminan_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND JENIS_BAYAR_ID = "' . $jaminan_id . '"';
}

$qry_kunjungan = $qry_kunjungan . ' ORDER BY NAMA_PASIEN,NOMR';

$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&unit_id=' . $unit_id . '&jaminan_id=' . $jaminan_id . '&shift_id=' . $shift_id;
$action = '<a href="index.php?link=' . md5('pendaftaranviewdaftaraps') . '&idx=###" >detail</a>';
include('pendaftaran/pendaftaran_list_kunjungan_aps.php');
?>
