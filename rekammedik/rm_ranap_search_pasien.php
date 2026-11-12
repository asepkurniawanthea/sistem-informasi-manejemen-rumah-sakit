<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tgl_1 = '';
if (isset($_SESSION['rmranapsearchpasienperiksa_tgl_1']))
    $tgl_1 = $_SESSION['rmranapsearchpasienperiksa_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['rmranapsearchpasienperiksa_tgl_1']))
    $tgl_2 = $_SESSION['rmranapsearchpasienperiksa_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['rmranapsearchpasienperiksa_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['rmranapsearchpasienperiksa_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['rmranapsearchpasienperiksa_searchkey']))
		$searchkey = $_SESSION['rmranapsearchpasienperiksa_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['rmranapsearchpasienperiksa_searchkey'] = $searchkey;
}
$jaminan_id = '';
if (isset($_SESSION['rmranapsearchpasienperiksa_jaminan_id']))
		$jaminan_id = $_SESSION['rmranapsearchpasienperiksa_jaminan_id'];

if (isset($_GET['jaminan_id'])) {
    $jaminan_id = $_GET['jaminan_id'];
	$_SESSION['rmranapsearchpasienperiksa_jaminan_id'] = $jaminan_id;
}

$dpjp = '';
if (isset($_SESSION['rmranapsearchpasienperiksa_dpjp']))
		$dpjp = $_SESSION['rmranapsearchpasienperiksa_dpjp'];

if (isset($_GET['dpjp'])) {
    $dpjp = $_GET['dpjp'];
	$_SESSION['rmranapsearchpasienperiksa_dpjp'] = $dpjp;
}

$ruang_id = '';
if($_SESSION['SES_SIMRS_BANGSAL'] == ''){
	if (isset($_SESSION['rmranapsearchpasienperiksa_ruang_id']))
		$ruang_id = $_SESSION['rmranapsearchpasienperiksa_ruang_id'];

	if (isset($_GET['ruang_id'])) {
		$ruang_id = $_GET['ruang_id'];
		$_SESSION['rmranapsearchpasienperiksa_ruang_id'] = $ruang_id;
	}
}else{
	$ruang_id = $_SESSION['SES_SIMRS_BANGSAL'];
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
    <table class="tableform" >
        <tr>
            <td>Tanggal</td>
            <td><input type="text" name="tgl_1" id="tgl_1" value="<?php echo $tgl_1; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
			<td>Nomor MR/ Nama Pasien</td>
            <td><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt"/></td>	
			<td>Ruang Rawat</td>
			<td><select name="ruang_id" class="text_dt" style="width:200px;">
				<option value=""> - </option>
				<?php echo getBangsal($ruang_id); ?>
			</select></td>
			<td>&nbsp;</td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/></td>
			<td>Jenis Pembayaran</td>
			<td> <select name="jaminan_id" id="jaminan_id" class="text_dt" style="width:150px;">
                    <option value=""> - </option>
                    <?php echo getJnsBayar($jaminan_id,''); ?>
                </select></td>
			<td>Dokter DPJP</td>		
			<td><select name="dpjp" class="text_dt" style="width:200px;" >
				<option value=""> - </option>
				<?php echo getDokterRanap($dpjp); ?>
			</select></td>
			<td><input type="submit" value="cari" class="myButton" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_kunjungan = 'SELECT t_irna.IRNA_ID, t_irna.NOMR,DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
	DATE_FORMAT(t_irna.PASIEN_KELUAR,"%d/%m/%Y %H:%i:%s") AS PASIEN_KELUAR,
	m_ruang.NAMA_RUANG,m_jaminan.NAMA_JAMINAN,t_irna.NO_TMP_TIDUR,
	m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NAMA_IBU,
	t_irna.USER_IRNA,m_pegawai.NAMA_PEGAWAI,m_pasien_pulang.KET_PASIEN_PULANG,t_irna.NO_RAWAT,
	m_ruang.KELAS_RAWAT,t_irna.ST_PINDAH,t_irna.PASIEN_MASUK,t_irna.ST_PULANG
	FROM t_irna
	INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR) 
	LEFT JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
	LEFT JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
	LEFT JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
	LEFT JOIN m_pasien_pulang ON (t_irna.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID)
	WHERE t_irna.NO_PENDAFTARAN IS NOT NULL AND t_irna.ST_BATAL IS NULL	
	AND ((DATE(t_irna.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . '
	AND DATE(t_irna.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . ')
	OR t_irna.ST_PULANG IS NULL)';
	
if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_kunjungan = $qry_kunjungan . ' AND CONCAT(m_pasien.NOMR,m_pasien.NAMA_PASIEN) LIKE "%' . $searchkey . '%"';
}	

if (!empty($jaminan_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_irna.JENIS_BAYAR_ID = "' . $jaminan_id . '"';
}

if (!empty($dpjp)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_irna.PEGAWAI_ID = "' . $dpjp . '"';
}

if (!empty($ruang_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND m_ruang.BANGSAL = "' . $ruang_id . '"';
}

$qry_kunjungan = $qry_kunjungan . 'ORDER BY t_irna.IRNA_ID';

$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&jaminan_id=' . $jaminan_id . '&ruang_id=' . $ruang_id;;
?>
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
		<th>Daftar</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
        <th>Tanggal Lahir</th>
        <th>Jenis Kelamin</th>
        <th>Pembayaran</th>
		<th>Ruang</th>
		<th>Kelas</th>
		<th>Tmp Tidur</th>
		<th>Dokter DPJP</th>
		<th>Booking/ Pindahan/ Pulang</th>
		<th>Keluar</th>
		<th>Status Pulang</th>
		<th width="120">Register</th>
        <th width="80">Option</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_kunjungan, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
        $id = $data['IRNA_ID'];
        ?>
        <tr>
            <td align="center"><?
    $no = ($no + 1);
    if (isset($_GET['page'])) {
        if ($_GET['page'] == 0) {
            $hal = 0;
        } else {
            $hal = $_GET['page'] - 1;
        }
    } else {
        $hal = 0;
    }
    echo ($hal * 10) + $no;
        ?></td>
            <td align="center"><?php echo $data['TANGGAL_DAFTAR']; ?></td>
            <td align="center"><?php echo formatNoMR($data['NOMR']); ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td align="center"><?php echo changeDateFormat($data['TGL_LAHIR']); ?></td>
            <td><?php echo jenisKelamin($data['JNS_KELAMIN']); ?></td>
            <td><?php echo $data['NAMA_JAMINAN']; ?></td>
			<td><?php echo $data['NAMA_RUANG']; ?></td>
			<td align="center"><?php echo $data['KELAS_RAWAT']; ?></td>
			<td align="center"><?php echo $data['NO_TMP_TIDUR']; ?></td>
			<td><?php echo $data['NAMA_PEGAWAI']; ?></td>
			<td><?php $status_p = ''; 
				if($data['PASIEN_MASUK'] == '') $status_p = 'Booking'; 
				if($data['ST_PINDAH'] == '1') $status_p = 'Pindahan'; 
				if($data['ST_PULANG'] == '1') $status_p = 'Pulang'; 
				echo $status_p; ?></td>
			<td align="center"><?php echo $data['PASIEN_KELUAR']; ?></td>
			<td><?php echo $data['KET_PASIEN_PULANG']; ?></td>
			<td><?php echo $data['USER_IRNA']; ?></td>
            <td align="center">
			<a href="index.php?link=9ee15413722c4887553cfc17db87d251&idx=<?php echo $data['IRNA_ID']; ?>" >ubah rm</a>
			</td>
        </tr>
        <?
    }
    ?>
</table>
<table width="100%" border="0" height="50%" class="tableNav" >
            <tr >
                <td align="right" valign="middle" >
                    <div style="background-color:#fff; height:80%; width:30%">
                        <table width="100%" align="center" height="100%" class="tableNavSub">
                            <tr>
								<td align="center">
                                    <?php
                                    echo $pager->renderSummary();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?php
                                    echo $pager->renderFirst();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderPrev();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderNav();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderNext();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderLast();
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>

                </td>
            </tr>
        </table>