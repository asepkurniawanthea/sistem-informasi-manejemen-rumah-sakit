<?php
$searchkey = '';
$pasien = 'umum';
$_SESSION['mqm_trans_id'] = '';
if(isset($_GET['ol'])) $_SESSION['mqm_trans_id'] = $_GET['ol']; 


if(isset($_GET['pasien'])) $pasien = $_GET['pasien'];
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
            <td align="right"><input type="submit" value="cari" class="myButton" />&nbsp;
			<?php if($pasien == 'igd'){ ?>
			<a href="index.php?link=<?php echo md5('pendaftaranformpasienigd'); ?>&pasien=<?php echo $_GET['pasien']; ?>&baru=1" >
			<input type="button" value="pasien baru" class="myButton1" /></a>
			<?php } else if($pasien == 'kusta'){ ?>
			<a href="index.php?link=<?php echo md5('pendaftaranformpasienkusta'); ?>&pasien=<?php echo $_GET['pasien']; ?>&baru=1" >
			<input type="button" value="pasien baru" class="myButton1" /></a>
			<?php } else if($pasien == 'umum'){ ?>
			<a href="index.php?link=<?php echo md5('pendaftaranformpasienpoliklinik'); ?>&pasien=<?php echo $_GET['pasien']; ?>&baru=1" >
			<input type="button" value="pasien baru" class="myButton1" /></a>
			<?php } else if($pasien == 'mcu'){ ?>
			<a href="index.php?link=<?php echo md5('pendaftaranformpasienmcu'); ?>&pasien=<?php echo $_GET['pasien']; ?>&baru=1" >
			<input type="button" value="pasien baru" class="myButton1" /></a>
			<?php } ?>
			</td>
        </tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
    <input type="hidden" name="pasien" id="pasien" value="<?php echo $pasien; ?>" />
</form>
<script type="text/javascript">
document.getElementById("searchkey").focus();
</script>
<?php
    $searchkey = str_replace(' ', '%', $searchkey);
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
				  m_kelurahan.NAMA_KELURAHAN, m_kecamatan.NAMA_KECAMATAN, m_kota.NAMA_KOTA,m_pasien.USER_PENDAFTARAN
				  FROM m_pasien 
				  LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				  LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				  LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
				  WHERE 1 ' . $searchpasien;
	if($searchpasien != '') $qry_pasien = $qry_pasien . ' ORDER BY m_pasien.NAMA_PASIEN, m_pasien.NOMR';

    $extparam = '&searchkey=' . $searchkey . '&pasien=' . $_GET['pasien'];
	if($pasien == 'igd'){
		$action = '<a href="index.php?link=' . md5('pendaftaranformpasienigd') . '&pasien=igd&nomr=###" >daftar</a>';
	} else if($pasien == 'kusta'){
		$action = '<a href="index.php?link=' . md5('pendaftaranformpasienkusta') . '&pasien=kusta&nomr=###" >daftar</a>';
	} else if($pasien == 'umum'){
		$action = '<a href="index.php?link=' . md5('pendaftaranformpasienpoliklinik') . '&pasien=umum&nomr=###" >daftar</a>';
	} else if($pasien == 'mcu'){
		$action = '<a href="index.php?link=' . md5('pendaftaranformpasienmcu') . '&pasien=mcu&nomr=###" >daftar</a>';
	}	
    include('pasien/pasien_list.php');
?>
