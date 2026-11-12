<?php
$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
mysql_select_db($database_3, $connect_3) or die(mysql_error());

$tgl_1 = '';
if (isset($_SESSION['pembayaransearchpengembalianfarmasi_tgl_1']))
    $tgl_1 = $_SESSION['pembayaransearchpengembalianfarmasi_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['pembayaransearchpengembalianfarmasi_tgl_1']))
    $tgl_2 = $_SESSION['pembayaransearchpengembalianfarmasi_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['pembayaransearchpengembalianfarmasi_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['pembayaransearchpengembalianfarmasi_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['pembayaransearchpengembalianfarmasi_searchkey']))
		$searchkey = $_SESSION['pembayaransearchpengembalianfarmasi_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['pembayaransearchpengembalianfarmasi_searchkey'] = $searchkey;
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
			<td><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt"/></td>	
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/>
            </td>	
			<td colspan="2" align="right"><input type="submit" value="cari" class="myButton" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$searchkey_filter = '';
if(!empty($searchkey))
	$searchkey_filter = ' AND CONCAT(t_farmasi_apotik_pengembalian_resep.NAMA_PASIEN,t_farmasi_apotik_pengembalian_resep.NOMR) LIKE "%' . $searchkey . '%"';
$qry_farmasi = 'SELECT DATE_FORMAT(t_farmasi_apotik_pengembalian_resep.TANGGAL_KEMBALI,"%d/%m/%Y") AS TANGGAL_KEMBALI,
					t_farmasi_apotik_pengembalian_resep.NOMR,t_farmasi_apotik_pengembalian_resep.NAMA_PASIEN,t_farmasi_apotik_pengembalian_resep.DOKTER_PENGIRIM,
					t_farmasi_apotik_pengembalian_resep.INSTANSI_PENGIRIM,t_farmasi_apotik_pengembalian_resep.FARMASI_PENGEMBALIAN_APOTIK_ID,
					t_farmasi_apotik_pengembalian_resep.USER_APOTIK,m_jaminan.NAMA_JAMINAN,t_farmasi_apotik_pengembalian_resep.ALAMAT,
					t_farmasi_apotik_pengembalian_resep.JENIS_PENGEMBALIAN,t_farmasi_apotik_pengembalian_resep.NO_PEMBAYARAN,
					t_farmasi_apotik_pengembalian_resep.ST_BATAL
					FROM t_farmasi_apotik_pengembalian_resep  
					INNER JOIN t_farmasi_apotik_pengembalian_resep_detail ON (t_farmasi_apotik_pengembalian_resep.FARMASI_PENGEMBALIAN_APOTIK_ID = t_farmasi_apotik_pengembalian_resep_detail.FARMASI_PENGEMBALIAN_ID)
					LEFT JOIN m_jaminan ON (t_farmasi_apotik_pengembalian_resep.JAMINAN_ID = m_jaminan.JAMINAN_ID)
					WHERE t_farmasi_apotik_pengembalian_resep.NO_PENGEMBALIAN IS NOT NULL 
					AND t_farmasi_apotik_pengembalian_resep.JENIS_PENGEMBALIAN = "2"
					AND t_farmasi_apotik_pengembalian_resep.TANGGAL_KEMBALI >= ' . $tgl_filter_1 . '
					AND t_farmasi_apotik_pengembalian_resep.TANGGAL_KEMBALI <= ' . $tgl_filter_2 . '
					' . $searchkey_filter . '
					GROUP BY DATE_FORMAT(t_farmasi_apotik_pengembalian_resep.TANGGAL_KEMBALI,"%d/%m/%Y"),
					t_farmasi_apotik_pengembalian_resep.NOMR,
					t_farmasi_apotik_pengembalian_resep.NAMA_PASIEN,t_farmasi_apotik_pengembalian_resep.DOKTER_PENGIRIM,
					t_farmasi_apotik_pengembalian_resep.INSTANSI_PENGIRIM,t_farmasi_apotik_pengembalian_resep.FARMASI_PENGEMBALIAN_APOTIK_ID,
					t_farmasi_apotik_pengembalian_resep.USER_APOTIK,m_jaminan.NAMA_JAMINAN,t_farmasi_apotik_pengembalian_resep.ALAMAT
					ORDER BY t_farmasi_apotik_pengembalian_resep.TANGGAL_KEMBALI, t_farmasi_apotik_pengembalian_resep.NAMA_PASIEN';
	
$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2;
$action = '<a href="index.php?link=' . md5('pembayarandetailpengembalianfarmasi') . '&idx=###&jns=$$$" >detail</a>';
include('pembayaran/pembayaran_list_pengembalian_farmasi.php');
?>
