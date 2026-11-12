<?php
$searchkey = '';
if (isset($_SESSION['pendaftarandatapasien_searchkey']))
		$searchkey = $_SESSION['pendaftarandatapasien_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['pendaftarandatapasien_searchkey'] = $searchkey;
}

$alamat = '';
if (isset($_SESSION['pendaftarandatapasien_alamat']))
		$alamat = $_SESSION['pendaftarandatapasien_alamat'];

if (isset($_GET['alamat'])) {
    $alamat = $_GET['alamat'];
	$_SESSION['pendaftarandatapasien_alamat'] = $alamat;
}

$nama_ibu = '';
if (isset($_SESSION['pendaftarandatapasien_nama_ibu']))
		$nama_ibu = $_SESSION['pendaftarandatapasien_nama_ibu'];

if (isset($_GET['nama_ibu'])) {
    $nama_ibu = $_GET['nama_ibu'];
	$_SESSION['pendaftarandatapasien_nama_ibu'] = $nama_ibu;
}
?>
<form name="searchpasien" method="get" action="index.php">
    <table class="tableform" >
        <tr>
            <td>Nomor MR/ Nama Pasien</td>
            <td><input type="text" name="searchkey" id="searchkey" class="text_dt" value="<?php echo $searchkey; ?>" size="30" /></td>
        </tr>
		<tr>
            <td>Alamat/ Kelurahan /Kecamatan</td>
            <td><input type="text" name="alamat" id="alamat" class="text_dt" value="<?php echo $alamat; ?>" size="30" /></td>
        </tr>
		<tr>
            <td>Nama Ibu</td>
            <td><input type="text" name="nama_ibu" id="nama_ibu" class="text_dt" value="<?php echo $nama_ibu; ?>" size="30" /></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td align="right"><input type="submit" value="cari" class="myButton" />
			</td>
        </tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<?php
    $searchkey = str_replace(' ', '%', $searchkey);
	$alamat = str_replace(' ', '%', $alamat);
	$searchpasien = '';
	if(!empty($searchkey)){
		 $searchpasien = ' AND CONCAT(m_pasien.NOMR,m_pasien.NAMA_PASIEN) LIKE "%' . $searchkey . '%"';
	}
	if(!empty($alamat)){
		 $searchpasien = $searchpasien . ' AND CONCAT(m_pasien.ALAMAT,m_kelurahan.NAMA_KELURAHAN,m_kecamatan.NAMA_KECAMATAN) LIKE "%' . $alamat . '%"';
	}
	if(!empty($nama_ibu)){
		 $searchpasien = $searchpasien . ' AND m_pasien.NAMA_IBU LIKE "%' . $nama_ibu . '%"';
	}
	$qry_pasien = 'SELECT m_pasien.PASIEN_ID, m_pasien.NOMR,m_pasien.NAMA_PASIEN,
				  m_pasien.TMP_LAHIR, m_pasien.TGL_LAHIR, m_pasien.JNS_KELAMIN,
				  m_pasien.ALAMAT, m_pasien.ALAMAT_RT, m_pasien.ALAMAT_RW, m_pasien.NAMA_IBU, 
				  m_kelurahan.NAMA_KELURAHAN, m_kecamatan.NAMA_KECAMATAN, m_kota.NAMA_KOTA,
				  m_pasien.USER_PENDAFTARAN
				  FROM m_pasien 
				  LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				  LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				  LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
				  WHERE 1 ' . $searchpasien;
	if($searchpasien != '') $qry_pasien .= ' ORDER BY m_pasien.NAMA_PASIEN, m_pasien.NOMR';

$extparam = '&searchkey=' . $searchkey;
$action = '<a href="index.php?link=' . md5('pendaftaranviewpasien') . '&nomr=###" >detail</a>';
include('pasien/pasien_list.php');
?>
