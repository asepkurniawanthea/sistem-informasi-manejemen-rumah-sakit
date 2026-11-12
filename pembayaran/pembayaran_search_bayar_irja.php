<?php
$tgl_1 = '';
if (isset($_SESSION['pembayaransearchbayar_tgl_1']))
    $tgl_1 = $_SESSION['pembayaransearchbayar_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['pembayaransearchbayar_tgl_1']))
    $tgl_2 = $_SESSION['pembayaransearchbayar_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['pembayaransearchbayar_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['pembayaransearchbayar_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['pembayaransearchbayar_searchkey']))
		$searchkey = $_SESSION['pembayaransearchbayar_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['pembayaransearchbayar_searchkey'] = $searchkey;
}
$unit_id = '';
if (isset($_SESSION['pembayaransearchbayar_unit_id']))
		$unit_id = $_SESSION['pembayaransearchbayar_unit_id'];

if (isset($_GET['unit_id'])) {
    $unit_id = $_GET['unit_id'];
	$_SESSION['pembayaransearchbayar_unit_id'] = $unit_id;
}
$jaminan_id = '';
if (isset($_SESSION['pembayaransearchbayar_jaminan_id']))
		$jaminan_id = $_SESSION['pembayaransearchbayar_jaminan_id'];

if (isset($_GET['jaminan_id'])) {
    $jaminan_id = $_GET['jaminan_id'];
	$_SESSION['pembayaransearchbayar_jaminan_id'] = $jaminan_id;
}

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}	

$kasir = 'umum';
if(isset($_GET['kasir'])){
	$kasir = $_GET['kasir'];
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
            <td><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt"/></td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/>
            </td>	
			<td>Klinik</td>
			<td><select name="unit_id" id="unit_id" class="text_dt" style="width:228px;">
			<option value=""> - </option>
			<?php if($kasir == 'igd') echo getUnit('igd',$unit_id);
				  if($kasir == 'kusta') echo getUnit('kusta',$unit_id);
				  if($kasir == 'umum') echo getUnit('umummcu',$unit_id); ?>
            </select></td>	
			<td>&nbsp;</td>
            <td align="right"><input type="submit" value="cari" class="myButton" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
	<input type="hidden" name="kasir" value="<?php echo $kasir; ?>" />
</form>
<br />
<?php
$qry_kunjungan = 'SELECT * FROM (SELECT t_irja.IRJA_ID, t_irja.NOMR, t_irja.TANGGAL_DAFTAR,
				m_unit.NAMA_UNIT,m_jaminan.NAMA_JAMINAN,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,
				m_pasien.ALAMAT,t_irja.ST_BARU,t_irja.ST_RUJUKAN,
				t_irja.ST_LUNAS AS STATUS_PEMBAYARAN,
				t_irja.UNIT_ID,
				t_irja.JENIS_BAYAR_ID,
				t_irna.IRNA_ID,
				t_irna.PASIEN_MASUK
				FROM t_irja
				INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR) 
				LEFT JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				LEFT JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				LEFT JOIN t_irna ON (t_irja.IRJA_ID = t_irna.IRNA_ID)
				WHERE t_irja.NO_PENDAFTARAN IS NOT NULL 
				AND t_irja.ST_BATAL IS NULL	
				AND t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
				) t_daftar 
				WHERE t_daftar.PASIEN_MASUK IS NULL';
	
if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_kunjungan = $qry_kunjungan . ' AND CONCAT(t_daftar.NOMR,t_daftar.NAMA_PASIEN) LIKE "%' . $searchkey . '%"';
}	
if (!empty($unit_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_daftar.UNIT_ID = "' . $unit_id . '"';
}
if (!empty($jaminan_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_daftar.JENIS_BAYAR_ID = "' . $jaminan_id . '"';
}

if($kasir == 'umum') $qry_kunjungan = $qry_kunjungan . ' AND t_daftar.UNIT_ID <> "9" AND t_daftar.UNIT_ID <> "64" AND t_daftar.UNIT_ID <> "35"';
if($kasir == 'igd') $qry_kunjungan = $qry_kunjungan . ' AND (t_daftar.UNIT_ID = "9" OR t_daftar.UNIT_ID = "64")';
if($kasir == 'kusta') $qry_kunjungan = $qry_kunjungan . ' AND t_daftar.UNIT_ID = "35"';

$qry_kunjungan = $qry_kunjungan . ' ORDER BY t_daftar.NAMA_PASIEN,t_daftar.NOMR';
			
if($kasir == 'igd') $link = 'pembayarandetailbayarigd';
if($kasir == 'kusta') $link = 'pembayarandetailbayarkusta';
if($kasir == 'umum') $link = 'pembayarandetailbayarpoliklinik';
$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&unit_id=' . $unit_id . '&jaminan_id=' . $jaminan_id . '&kasir=' . $kasir;
$action = '<a href="index.php?link=' . md5($link) . '&idx=###&kasir=' . $_GET['kasir'] . '" >detail</a>';
include('pembayaran/pembayaran_list_bayar_irja.php');
?>