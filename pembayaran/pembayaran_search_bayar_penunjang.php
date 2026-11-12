<?php
$tgl_1 = '';
if (isset($_SESSION['pembayaransearchbayarpenunjang_tgl_1']))
    $tgl_1 = $_SESSION['pembayaransearchbayarpenunjang_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['pembayaransearchbayarpenunjang_tgl_1']))
    $tgl_2 = $_SESSION['pembayaransearchbayarpenunjang_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['pembayaransearchbayarpenunjang_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['pembayaransearchbayarpenunjang_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['pembayaransearchbayarpenunjang_searchkey']))
		$searchkey = $_SESSION['pembayaransearchbayarpenunjang_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['pembayaransearchbayarpenunjang_searchkey'] = $searchkey;
}

$jaminan = '';
if (isset($_SESSION['pembayaransearchbayarpenunjang_jaminan']))
		$jaminan = $_SESSION['pembayaransearchbayarpenunjang_jaminan'];

if (isset($_GET['jaminan'])) {
    $jaminan = $_GET['jaminan'];
	$_SESSION['pembayaransearchbayarpenunjang_jaminan'] = $jaminan;
}

$unit_id = '';
if (isset($_SESSION['pembayaransearchbayarpenunjang_unit_id']))
		$unit_id = $_SESSION['pembayaransearchbayarpenunjang_unit_id'];

if (isset($_GET['unit_id'])) {
    $unit_id = $_GET['unit_id'];
	$_SESSION['pembayaransearchbayarpenunjang_unit_id'] = $unit_id;
}

$penunjang_id = '';
if (isset($_SESSION['pembayaransearchbayarpenunjang_penunjang_id']))
		$penunjang_id = $_SESSION['pembayaransearchbayarpenunjang_penunjang_id'];

if (isset($_GET['penunjang_id'])) {
    $penunjang_id = $_GET['penunjang_id'];
	$_SESSION['pembayaransearchbayarpenunjang_penunjang_id'] = $penunjang_id;
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
			<td>Poliklinik</td>
			<td> <select name="unit_id" id="unit_id" class="text_dt" style="width:200px;">
                    <option value=""> - </option>
                    <?php echo getUnit('umumigd',$unit_id); ?>
                </select></td>	
			<td>Nomor MR/ Nama Pasien</td>
            <td><input type="text" name="searchkey" id="searchkey" style="width:220px;" value="<?php echo $searchkey; ?>" class="text_dt"/></td>
			<td></td>
		</tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/>
            </td>	
			<td>Penunjang</td>
			<td> <select name="penunjang_id" id="penunjang_id" class="text_dt" style="width:200px;">
                    <option value=""> - </option>
                    <?php echo getUnit('pnj',$penunjang_id); ?>
                </select></td>	
			<td>Jenis Pembayaran</td>
			<td><select name="jaminan" id="jaminan" class="text_dt" style="width:228px;">
                    <option value=""> - </option>
                    <?php echo getJnsBayar($jaminan,''); ?>
                </select></td>
			<!--
			<a href="index.php?link=<?php echo md5('pembayaransearchpasienaps'); ?>" ><input type="button" value="atas permintaan sendiri" class="myButton" /></a>
			-->
			</td>
			<td><input type="submit" value="cari" class="myButton" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_kunjungan = 'SELECT "1" AS JNS_P,t_ipenunjang.PENUNJANG_ID, t_ipenunjang.RAWAT_ID,
	CASE WHEN t_ipenunjang.JNS_ORDER = "APS" THEN t_ipenunjang.NO_PASIEN_PENUNJANG ELSE t_ipenunjang.NOMR END AS NOMR,
	DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
	m_unit.NAMA_UNIT,m_jaminan.NAMA_JAMINAN,
	t_ipenunjang_tarif.UNIT_PENUNJANG_ID,
	CASE WHEN t_ipenunjang.JNS_ORDER = "APS" THEN t_ipenunjang.NAMA_PASIEN ELSE m_pasien.NAMA_PASIEN END AS NAMA_PASIEN,
	CASE WHEN t_ipenunjang.JNS_ORDER = "APS" THEN t_ipenunjang.TGL_LAHIR ELSE m_pasien.TGL_LAHIR END AS TGL_LAHIR,
	CASE WHEN t_ipenunjang.JNS_ORDER = "APS" THEN t_ipenunjang.JNS_KELAMIN ELSE m_pasien.JNS_KELAMIN END AS JNS_KELAMIN,
	CASE WHEN t_ipenunjang.JNS_ORDER = "APS" THEN t_ipenunjang.ALAMAT ELSE m_pasien.ALAMAT END AS ALAMAT,
	CASE WHEN t_ipenunjang.JNS_ORDER = "APS" THEN t_ipenunjang.INSTANSI_PENGIRIM ELSE m_unit_pengirim.NAMA_UNIT END AS NAMA_UNIT_PENGIRIM,
	CASE WHEN t_ipenunjang.JNS_ORDER = "APS" THEN t_ipenunjang.PENGIRIM ELSE m_pegawai.NAMA_PEGAWAI END AS NAMA_PEGAWAI,
	t_ipenunjang_tarif.USER_PENDAFTARAN,t_ipenunjang_tarif.NO_TARIF,t_ipenunjang.JNS_ORDER,
	SUM(CASE WHEN t_ipenunjang_tarif.NO_PEMBAYARAN IS NULL THEN 1 ELSE 0 END) AS STATUS_PEMBAYARAN,
	t_ipenunjang_tarif.NO_SJP
	FROM t_ipenunjang
	INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID) 
	LEFT JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
	LEFT JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR) 
	LEFT JOIN m_unit m_unit_pengirim ON (t_ipenunjang.UNIT_ID = m_unit_pengirim.UNIT_ID)
	LEFT JOIN m_unit ON (t_ipenunjang_tarif.UNIT_PENUNJANG_ID = m_unit.UNIT_ID)
	LEFT JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
	LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
	WHERE t_ipenunjang_tarif.NO_TARIF IS NOT NULL AND t_ipenunjang_tarif.ST_BATAL IS NULL
	AND (t_ipenunjang.JNS_ORDER = "IRJ" OR t_ipenunjang.JNS_ORDER = "APS")
	AND (m_tarif.MCU = "" OR m_tarif.MCU IS NULL) 
	AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
	AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) <= ' . $tgl_filter_2;
	
	
if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_kunjungan = $qry_kunjungan . ' AND (CONCAT(m_pasien.NOMR,m_pasien.NAMA_PASIEN) LIKE "%' . $searchkey . '%"
		OR CONCAT(t_ipenunjang.NO_PASIEN_PENUNJANG,t_ipenunjang.NAMA_PASIEN) LIKE "%' . $searchkey . '%")';
}	
if (!empty($penunjang_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_ipenunjang_tarif.UNIT_PENUNJANG_ID = "' . $penunjang_id . '"';
}

if (!empty($unit_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_ipenunjang.UNIT_ID = "' . $unit_id . '"';
}

if (!empty($jaminan)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_ipenunjang_tarif.JENIS_BAYAR_ID = "' . $jaminan . '"';
}

$qry_kunjungan = $qry_kunjungan . ' GROUP BY t_ipenunjang.RAWAT_ID, t_ipenunjang_tarif.NO_SJP  
									ORDER BY m_pasien.NAMA_PASIEN,m_pasien.NOMR';

$extparam = '&jaminan=' . $jaminan . '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&unit_id=' . $unit_id;
$action = '<a href="index.php?link=' . md5('pembayarandetailbayarpenunjang') . '&idx=###" >detail</a>';
include('pembayaran/pembayaran_list_bayar_penunjang.php');
?>
