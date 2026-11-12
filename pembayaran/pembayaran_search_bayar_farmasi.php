<?php
$tgl_1 = '';
if (isset($_SESSION['pembayaransearchbayarfarmasi_tgl_1']))
    $tgl_1 = $_SESSION['pembayaransearchbayarfarmasi_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['pembayaransearchbayarfarmasi_tgl_1']))
    $tgl_2 = $_SESSION['pembayaransearchbayarfarmasi_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['pembayaransearchbayarfarmasi_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['pembayaransearchbayarfarmasi_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['pembayaransearchbayarfarmasi_searchkey']))
		$searchkey = $_SESSION['pembayaransearchbayarfarmasi_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['pembayaransearchbayarfarmasi_searchkey'] = $searchkey;
}

$jaminan = '';
if (isset($_SESSION['pembayaransearchbayarfarmasi_jaminan']))
		$jaminan = $_SESSION['pembayaransearchbayarfarmasi_jaminan'];

if (isset($_GET['jaminan'])) {
    $jaminan = $_GET['jaminan'];
	$_SESSION['pembayaransearchbayarfarmasi_jaminan'] = $jaminan;
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
			<td><input type="text" name="searchkey" id="searchkey" style="width:220px;" value="<?php echo $searchkey; ?>" class="text_dt"/></td>	
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/>
            </td>	
			<td>Jenis Pembayaran</td>
			<td><select name="jaminan" id="jaminan" class="text_dt" style="width:228px;">
                    <option value=""> - </option>
                    <?php echo getJnsBayar($jaminan,''); ?>
                </select></td>
			<td><input type="submit" value="cari" class="myButton" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
mysql_select_db($database_3, $connect_3) or die(mysql_error());

$searchkey_filter = '';
$jaminan_filter = '';
if(!empty($searchkey))
	$searchkey_filter = ' AND CONCAT(t_tran.NAMA_PELANGGAN,t_tran.NIK) LIKE "%' . $searchkey . '%"';
if(!empty($jaminan))
	$jaminan_filter = ' AND t_tran.JAMINAN_ID = "' . $jaminan . '"';
 $qry_farmasi = 'SELECT * FROM (SELECT t_rajal_resep.RAJAL_ID AS FARMASI_ID, 
				DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y") AS TANGGAL_KELUAR,
				t_farmasi_apotik_pengeluaran.JENIS_PENGELUARAN,t_farmasi_apotik_pengeluaran.NIK,
				t_farmasi_apotik_pengeluaran.NAMA_PELANGGAN,t_farmasi_apotik_pengeluaran.ALAMAT,
				t_farmasi_apotik_pengeluaran.INSTANSI_PENGIRIM,m_jaminan.NAMA_JAMINAN,
				t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR AS TGL_TRANS,
				t_farmasi_apotik_pengeluaran.JAMINAN_ID,
				SUM(CASE WHEN t_farmasi_apotik_pengeluaran.JAMINAN_ID = 1 AND t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN IS NULL THEN 1 END) AS ST_BAYAR
				FROM t_farmasi_apotik_pengeluaran
				INNER JOIN t_rajal_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_rajal_resep.NO_RESEP)
				AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_rajal_resep.NO_PENGELUARAN)
				LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengeluaran.JAMINAN_ID = m_jaminan.JAMINAN_ID)
				WHERE t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL 
				AND t_farmasi_apotik_pengeluaran.JENIS_PENGELUARAN = "1"
				AND t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR >= ' . $tgl_filter_1 . '
				AND t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR <= ' . $tgl_filter_2 . '
				GROUP BY t_rajal_resep.RAJAL_ID, t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,
				t_farmasi_apotik_pengeluaran.JENIS_PENGELUARAN,t_farmasi_apotik_pengeluaran.NIK,
				t_farmasi_apotik_pengeluaran.NAMA_PELANGGAN,t_farmasi_apotik_pengeluaran.ALAMAT,
				t_farmasi_apotik_pengeluaran.INSTANSI_PENGIRIM,m_jaminan.NAMA_JAMINAN	
				UNION
				SELECT t_ranap_resep.RANAP_ID AS FARMASI_ID, 
				DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y") AS TANGGAL_KELUAR,
				t_farmasi_apotik_pengeluaran.JENIS_PENGELUARAN,t_farmasi_apotik_pengeluaran.NIK,
				t_farmasi_apotik_pengeluaran.NAMA_PELANGGAN,t_farmasi_apotik_pengeluaran.ALAMAT,
				t_farmasi_apotik_pengeluaran.INSTANSI_PENGIRIM,m_jaminan.NAMA_JAMINAN,
				t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR AS TGL_TRANS,
				t_farmasi_apotik_pengeluaran.JAMINAN_ID,
				SUM(CASE WHEN t_farmasi_apotik_pengeluaran.JAMINAN_ID = 1 AND t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN IS NULL THEN 1 END) AS ST_BAYAR
				FROM t_farmasi_apotik_pengeluaran
				INNER JOIN t_ranap_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_ranap_resep.NO_RESEP)
				AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_ranap_resep.NO_PENGELUARAN)
				LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengeluaran.JAMINAN_ID = m_jaminan.JAMINAN_ID)
				WHERE t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL 
				AND t_farmasi_apotik_pengeluaran.JENIS_PENGELUARAN = "2"
				AND t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR >= ' . $tgl_filter_1 . '
				AND t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR <= ' . $tgl_filter_2 . '
				GROUP BY t_ranap_resep.RANAP_ID, t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,
				t_farmasi_apotik_pengeluaran.JENIS_PENGELUARAN,t_farmasi_apotik_pengeluaran.NIK,
				t_farmasi_apotik_pengeluaran.NAMA_PELANGGAN,t_farmasi_apotik_pengeluaran.ALAMAT,
				t_farmasi_apotik_pengeluaran.INSTANSI_PENGIRIM,m_jaminan.NAMA_JAMINAN
				UNION
				SELECT t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID AS FARMASI_ID, 
				DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y") AS TANGGAL_KELUAR,
				t_farmasi_apotik_pengeluaran.JENIS_PENGELUARAN,t_farmasi_apotik_pengeluaran.NIK,
				t_farmasi_apotik_pengeluaran.NAMA_PELANGGAN,t_farmasi_apotik_pengeluaran.ALAMAT,
				t_farmasi_apotik_pengeluaran.INSTANSI_PENGIRIM,"Umum" AS NAMA_JAMINAN,
				t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR AS TGL_TRANS,
				"1" AS JAMINAN_ID,
				SUM(CASE WHEN t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN IS NULL THEN 1 END) AS ST_BAYAR
				FROM t_farmasi_apotik_pengeluaran
				INNER JOIN t_penjualan_resep ON (t_farmasi_apotik_pengeluaran.NO_RESEP = t_penjualan_resep.NO_RESEP)
				AND (t_farmasi_apotik_pengeluaran.NO_PENGELUARAN = t_penjualan_resep.NO_PENGELUARAN)
				WHERE t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL 
				AND t_farmasi_apotik_pengeluaran.JENIS_PENGELUARAN = "3"
				AND t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR >= ' . $tgl_filter_1 . '
				AND t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR <= ' . $tgl_filter_2 . '
				GROUP BY t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID, t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,
				t_farmasi_apotik_pengeluaran.JENIS_PENGELUARAN,t_farmasi_apotik_pengeluaran.NIK,
				t_farmasi_apotik_pengeluaran.NAMA_PELANGGAN,t_farmasi_apotik_pengeluaran.ALAMAT,
				t_farmasi_apotik_pengeluaran.INSTANSI_PENGIRIM
				) t_tran 
				WHERE 1
				' . $searchkey_filter . '
				' . $jaminan_filter . '
				ORDER BY TGL_TRANS';
	
$extparam = '&jaminan=' . $jaminan . '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2;
$action = '<a href="index.php?link=' . md5('pembayarandetailbayarfarmasi') . '&idx=###&jns=$$$" >detail</a>';
include('pembayaran/pembayaran_list_bayar_farmasi.php');
?>
