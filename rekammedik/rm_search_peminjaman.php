<?php
$tgl_1 = '';
if (isset($_SESSION['rmsearchpeminjaman_tgl_1']))
    $tgl_1 = $_SESSION['rmsearchpeminjaman_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['rmsearchpeminjaman_tgl_1']))
    $tgl_2 = $_SESSION['rmsearchpeminjaman_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['rmsearchpeminjaman_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['rmsearchpeminjaman_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['rmsearchpeminjaman_searchkey']))
		$searchkey = $_SESSION['rmsearchpeminjaman_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['rmsearchpeminjaman_searchkey'] = $searchkey;
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
<form name="searchkunjungan" method="get" action="index.php">
    <table class="tableform" >
        <tr>
            <td>Tanggal</td>
            <td><input type="text" name="tgl_1" id="tgl_1" value="<?php echo $tgl_1; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar2')"/>
            </td>
			 <td>Nomor MR</td>
            <td><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt" /></td>
        </tr>
        <tr>
            <td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar3')"/></td>
			<td colspan="2" align="right"><input type="submit" value="cari" class="myButton1" />
			<a href="index.php?link=<?php echo md5('rmformpeminjaman'); ?>" ><input type="button" value="peminjaman baru" class="myButton1" /></a></td>	
        </tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_kunjungan = 'SELECT t_rm_peminjaman_buku.PEMINJAMAN_RM_ID,t_rm_peminjaman_buku.NOMR,m_pasien.NAMA_PASIEN,
					t_rm_peminjaman_buku.NAMA_PEMINJAM,t_rm_peminjaman_buku.NIK,t_rm_peminjaman_buku.NO_TELEPON,t_rm_peminjaman_buku.INSTANSI,
					DATE_FORMAT(t_rm_peminjaman_buku.TGL_PINJAM,"%d-%m-%Y %H:%i:%s") AS TGL_PINJAM,t_rm_peminjaman_buku.KET_PINJAM,
					DATE_FORMAT(t_rm_peminjaman_buku.TGL_KEMBALI,"%d-%m-%Y %H:%i:%s") AS TGL_KEMBALI,t_rm_peminjaman_buku.KET_KEMBALI,
					t_rm_peminjaman_buku.USER_RM
					FROM t_rm_peminjaman_buku
					LEFT JOIN m_pasien ON (t_rm_peminjaman_buku.NOMR = m_pasien.NOMR)
					WHERE t_rm_peminjaman_buku.TGL_KEMBALI IS NULL 
					OR (STR_TO_DATE(DATE_FORMAT(t_rm_peminjaman_buku.TGL_PINJAM,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' AND STR_TO_DATE(DATE_FORMAT(t_rm_peminjaman_buku.TGL_PINJAM,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . ')';
if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_kunjungan = $qry_kunjungan . ' AND CONCAT(m_pasien.NOMR,m_pasien.NAMA_PASIEN) LIKE "%' . $searchkey . '%"';
}	
$qry_kunjungan = $qry_kunjungan . ' ORDER BY t_rm_peminjaman_buku.TGL_PINJAM ASC';

$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2;
$action = '<a href="index.php?link=' . md5('pendaftaranviewdaftar') . '&idx=###" >detail</a>';
include('rekammedik/rm_list_peminjaman.php');					
?>