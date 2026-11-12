<?php
$searchkey = '';
if (isset($_SESSION['pembayaransearchaps_searchkey']))
		$searchkey = $_SESSION['pembayaransearchaps_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['pembayaransearchaps_searchkey'] = $searchkey;
}

$alamat = '';
if (isset($_SESSION['pembayaransearchaps_alamat']))
		$unit_id = $_SESSION['pembayaransearchaps_alamat'];

if (isset($_GET['alamat'])) {
    $alamat = $_GET['alamat'];
	$_SESSION['pembayaransearchaps_alamat'] = $alamat;
}
?>
<form name="search" method="get" action="index.php">
    <table class="tableform" border="0" >
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
			<td>Nomor Penunjang/ Nama Pasien</td>
			<td><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt"/></td>	
			<td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
		<tr>
			<td>&nbsp;</td>
            <td>&nbsp;</td>	
			<td>Alamat</td>
			<td><input type="text" name="alamat" id="alamat" value="<?php echo $alamat; ?>" class="text_dt"/></td>	
			<td colspan="2" align="right"><input type="submit" value="cari" class="myButton" />
			<a href="index.php?link=<?php echo md5('pembayaranformapspasien'); ?>&no_pnj=" ><input type="button" value="pasien penunjang baru" class="myButton" />
			</td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_kunjungan = 'SELECT DISTINCT t_ipenunjang.NO_PASIEN_PENUNJANG,t_ipenunjang.NAMA_PASIEN,
				DATE_FORMAT(t_ipenunjang.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
				t_ipenunjang.JNS_KELAMIN,t_ipenunjang.NAMA_IBU,t_ipenunjang.ALAMAT,
				t_ipenunjang.ALAMAT_RT,t_ipenunjang.ALAMAT_RW,
				m_kelurahan.NAMA_KELURAHAN,m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,
				(SELECT x.USER_ORDER FROM t_ipenunjang x WHERE x.NO_PASIEN_PENUNJANG = NO_PASIEN_PENUNJANG 
				ORDER BY x.PENUNJANG_ID DESC LIMIT 1) AS USER_PENDAFTARAN
				FROM t_ipenunjang
				LEFT JOIN m_kelurahan ON (t_ipenunjang.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				LEFT JOIN m_kecamatan ON (t_ipenunjang.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				LEFT JOIN m_kota ON (t_ipenunjang.KOTA_ID = m_kota.KOTA_ID)
				WHERE t_ipenunjang.JNS_ORDER = "APS"';
	
if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_kunjungan = $qry_kunjungan . ' AND CONCAT(t_ipenunjang.NO_PASIEN_PENUNJANG,t_ipenunjang.NAMA_PASIEN) LIKE "%' . $searchkey . '%"';
}	
if (!empty($alamat)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_ipenunjang.ALAMAT LIKE "%' . $alamat . '"%';
}

$qry_kunjungan = $qry_kunjungan . ' ORDER BY t_ipenunjang.NAMA_PASIEN,t_ipenunjang.NO_PASIEN_PENUNJANG';

$extparam = '&searchkey=' . $searchkey . '&alamat=' . $alamat;
$action = '<a href="index.php?link=' . md5('pembayaranformapspasien') . '&no_pnj=###" >daftar</a>';
include('pembayaran/pembayaran_list_pasien_aps.php');
?>
