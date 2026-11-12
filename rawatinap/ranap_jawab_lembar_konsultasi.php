<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tgl_1 = '';
if (isset($_SESSION['jawabkonsul_tgl_1']))
    $tgl_1 = $_SESSION['jawabkonsul_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['jawabkonsul_tgl_1']))
    $tgl_2 = $_SESSION['jawabkonsul_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['jawabkonsul_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['jawabkonsul_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['jawabkonsul_searchkey']))
		$searchkey = $_SESSION['jawabkonsul_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['jawabkonsul_searchkey'] = $searchkey;
}

$dpjp = '';
if (isset($_SESSION['jawabkonsul_dpjp']))
		$dpjp = $_SESSION['jawabkonsul_dpjp'];

if (isset($_GET['dpjp'])) {
    $dpjp = $_GET['dpjp'];
	$_SESSION['jawabkonsul_dpjp'] = $dpjp;
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
            <td><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt" style="width:200px;" /></td>	
			<td>&nbsp;</td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/></td>
			<td>Dokter Pengirim</td>
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
$qry_kunjungan = 'SELECT DATE_FORMAT(TGL_ASSESMENT,"%d/%m/%Y") AS TANGGAL_DAFTAR, 
		t_konsul.NOMR,m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
		m_pasien.JNS_KELAMIN,m_unit.NAMA_UNIT,m_ruang.NAMA_RUANG,m_jaminan.NAMA_JAMINAN,
		t_konsul.REGISTER,t_konsul.KONSUL_ID,t_konsul.RWT,m_pegawai.NAMA_PEGAWAI,
		t_konsul.RAWAT_ID
		FROM (
		SELECT t_irja_lembar_konsul.IRJA_KONSUL_ID AS KONSUL_ID,
		t_irja_lembar_konsul.IRJA_ID AS RAWAT_ID,
		t_irja_lembar_konsul.PEGAWAI_ID,
		t_irja_lembar_konsul.PEGAWAI_ID_PENGIRIM,
		t_irja_lembar_konsul.TGL_ASSESMENT,
		t_irja_lembar_konsul.REGISTER,
		t_irja.NOMR,
		t_irja.UNIT_ID,
		NULL AS RUANG_ID,
		t_irja.JENIS_BAYAR_ID,
		"1" AS RWT
		FROM t_irja_lembar_konsul
		INNER JOIN t_irja
		ON (t_irja_lembar_konsul.IRJA_ID = t_irja.IRJA_ID)
		WHERE DATE(t_irja_lembar_konsul.TGL_ASSESMENT) >= ' . $tgl_filter_1 . '
		AND DATE(t_irja_lembar_konsul.TGL_ASSESMENT) <= ' . $tgl_filter_2 . '
		AND t_irja_lembar_konsul.PEGAWAI_ID = "' . $_SESSION['SES_SIMRS_PEGAWAI_ID'] . '"
		UNION ALL
		SELECT t_irna_lembar_konsul.IRNA_KONSUL_ID AS KONSUL_ID,
		t_irna_lembar_konsul.IRNA_ID AS RAWAT_ID,
		t_irna_lembar_konsul.PEGAWAI_ID,
		t_irna_lembar_konsul.PEGAWAI_ID_PENGIRIM,
		t_irna_lembar_konsul.TGL_ASSESMENT,
		t_irna_lembar_konsul.REGISTER,
		t_irna.NOMR,
		NULL AS UNIT_ID,
		t_irna.RUANG_ID,
		t_irna.JENIS_BAYAR_ID,
		"2" AS RWT
		FROM t_irna_lembar_konsul
		INNER JOIN t_irna
		ON (t_irna_lembar_konsul.IRNA_ID = t_irna.IRNA_ID)
		WHERE DATE(t_irna_lembar_konsul.TGL_ASSESMENT) >= ' . $tgl_filter_1 . '
		AND DATE(t_irna_lembar_konsul.TGL_ASSESMENT) <= ' . $tgl_filter_2 . '
		AND t_irna_lembar_konsul.PEGAWAI_ID = "' . $_SESSION['SES_SIMRS_PEGAWAI_ID'] . '"
		) t_konsul
		INNER JOIN m_pasien ON (t_konsul.NOMR = m_pasien.NOMR) 
		LEFT JOIN m_unit ON (t_konsul.UNIT_ID = m_unit.UNIT_ID)
		LEFT JOIN m_ruang ON (t_konsul.RUANG_ID = m_ruang.RUANG_ID)
		LEFT JOIN m_jaminan ON (t_konsul.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
		LEFT JOIN m_pegawai ON (t_konsul.PEGAWAI_ID_PENGIRIM = m_pegawai.PEGAWAI_ID)
		WHERE 1 ';
	
if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_kunjungan = $qry_kunjungan . ' AND CONCAT(m_pasien.NOMR,m_pasien.NAMA_PASIEN) LIKE "%' . $searchkey . '%"';
}	

if (!empty($dpjp)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_konsul.PEGAWAI_ID_PENGIRIM = "' . $dpjp . '"';
}

$qry_kunjungan = $qry_kunjungan . 'ORDER BY t_konsul.KONSUL_ID';

$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&dpjp=' . $dpjp;;
?>
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
		<th>Tgl Kirim</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
        <th>Tanggal Lahir</th>
        <th>Jenis Kelamin</th>
		<th>Pembayaran</th>
		<th>Ruang/ Unit</th>
		<th>Dokter Pengirim</th>
		<th width="120">Register</th>
        <th width="60">Option</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_kunjungan, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
        $id = $data['KONSUL_ID'];
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
        $nama_unit = $data['NAMA_UNIT'];
		if($data['NAMA_UNIT'] == '') $nama_unit = $data['NAMA_RUANG'];
		?></td>
            <td align="center"><?php echo $data['TANGGAL_DAFTAR']; ?></td>
            <td align="center"><?php echo formatNoMR($data['NOMR']); ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td align="center"><?php echo $data['TGL_LAHIR']; ?></td>
            <td><?php echo jenisKelamin($data['JNS_KELAMIN']); ?></td>
			<td><?php echo $data['NAMA_JAMINAN']; ?></td>
			<td><?php echo $nama_unit; ?></td>
			<td><?php echo $data['NAMA_PEGAWAI']; ?></td>
			<td><?php echo $data['REGISTER']; ?></td>
            <td align="center">
			<a href="index.php?link=77a6af0e2428ace1495828853d2378dc&idx=<?php echo $data['RAWAT_ID']; ?>&rwt=<?php echo $data['RWT']; ?>&ksl=<?php echo $data['KONSUL_ID']; ?>" >jawab</a>
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
?>
