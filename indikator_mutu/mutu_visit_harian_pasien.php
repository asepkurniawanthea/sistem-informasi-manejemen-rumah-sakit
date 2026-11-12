<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tgl_1 = '';
if (isset($_SESSION['visitharian_tgl_1']))
    $tgl_1 = $_SESSION['visitharian_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['visitharian_tgl_1']))
    $tgl_2 = $_SESSION['visitharian_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['visitharian_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['visitharian_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['visitharian_searchkey']))
		$searchkey = $_SESSION['visitharian_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['visitharian_searchkey'] = $searchkey;
}

$ruang_id = '';
if (isset($_SESSION['visitharian_ruang_id']))
		$ruang_id = $_SESSION['visitharian_ruang_id'];

if (isset($_GET['ruang_id'])) {
    $ruang_id = $_GET['ruang_id'];
	$_SESSION['visitharian_ruang_id'] = $ruang_id;
}

$j_tanggal = '1';
if (isset($_SESSION['visitharian_j_tanggal']))
		$j_tanggal = $_SESSION['visitharian_j_tanggal'];

if (isset($_GET['j_tanggal'])) {
    $j_tanggal = $_GET['j_tanggal'];
	$_SESSION['visitharian_j_tanggal'] = $j_tanggal;
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
    <table class="tableform" border="0">
        <tr>
            <td colspan="2"><input type="radio" name="j_tanggal" value="1" <?php if($j_tanggal == '1') echo 'checked="checked"'; ?>/>&nbsp;Tanggal Masuk
			&nbsp;&nbsp;<input type="radio" name="j_tanggal" value="2" <?php if($j_tanggal == '2') echo 'checked="checked"'; ?> />&nbsp;Tanggal Keluar</td>
			<td>&nbsp;</td>
            <td>&nbsp;</td>	
			<td>&nbsp;</td>
			<td>&nbsp;</td>
        </tr>
		<tr>
            <td>Tanggal</td>
            <td><input type="text" name="tgl_1" id="tgl_1" value="<?php echo $tgl_1; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
			<td>Nomor MR/ Nama Pasien</td>
            <td><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt" style="width:200px;"/></td>	
			<td>&nbsp;</td>
			<td>&nbsp;</td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/></td>
			<td>Ruang Rawat</td>
			<td><select name="ruang_id" class="text_dt" style="width:210px;">
				<option value=""> - </option>
				<?php echo getBangsal($ruang_id); ?>
			</select></td>		
			<td align="right" colspan="2"><input type="submit" value="cari" class="myButton" />
			<a href="index.php?link=4f3243e2a1e3d1014bd3291d355b7be3" >
			<input type="button" value="tutup" class="myButton1" /></a></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$tgl_filter_irna = '';
if($j_tanggal == '1'){
	$tgl_filter_irna = 'AND t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2;
}else{
	$tgl_filter_irna = 'AND STR_TO_DATE(DATE_FORMAT(t_irna.PASIEN_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(t_irna.PASIEN_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2;			
}
$qry_pasien = 'SELECT t_rawat.RAWAT_ID,t_rawat.NOMR,m_pasien.NAMA_PASIEN,
				DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
				DATE_FORMAT(t_rawat.TANGGAL_DAFTAR,"%d/%m/%Y") AS TGL_MASUK,
				DATE_FORMAT(t_rawat.PASIEN_KELUAR,"%d/%m/%Y") AS TGL_KELUAR,
				m_pasien.JNS_KELAMIN,m_unit.NAMA_UNIT,m_ruang.NAMA_RUANG
				FROM (SELECT t_irja.IRJA_ID AS RAWAT_ID,t_irja.NOMR,
					t_irja.TANGGAL_DAFTAR,t_irna.PASIEN_KELUAR,
					t_irja.UNIT_ID,t_irna.RUANG_ID
					FROM t_irja
					INNER JOIN t_irna ON (t_irja.IRJA_ID = t_irna.IRNA_ID)
					WHERE 1 ' . $tgl_filter_irna . '
					AND t_irna.NO_PENDAFTARAN IS NOT NULL 
					AND t_irna.ST_BATAL IS NULL
				) t_rawat
				INNER JOIN m_pasien ON (t_rawat.NOMR = m_pasien.NOMR)
				LEFT JOIN m_unit ON (t_rawat.UNIT_ID = m_unit.UNIT_ID)
				LEFT JOIN m_ruang ON (t_rawat.RUANG_ID = m_ruang.RUANG_ID)
				WHERE 1 ';

if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_pasien = $qry_pasien . ' AND CONCAT(m_pasien.NOMR,m_pasien.NAMA_PASIEN) LIKE "%' . $searchkey . '%" ';
}	
if (!empty($ruang_id)) {
    $qry_pasien = $qry_pasien . ' AND m_ruang.BANGSAL = "' . $ruang_id . '" ';
}
$qry_pasien = $qry_pasien . 'ORDER BY t_rawat.RAWAT_ID';

$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&ruang_id=' . $ruang_id;
?>
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
		<th>Tgl Masuk</th>
		<th>Tgl Keluar</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
        <th>Jenis Kelamin</th>
		<th>Umur</th>
        <th>Unit - Ruang</th>
        <th>Option</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_pasien, 20, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
        $id = $data['RAWAT_ID'];
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
    echo ($hal * 20) + $no;
        ?></td>
            <td align="center"><?php echo $data['TGL_MASUK']; ?></td>
			<td align="center"><?php echo $data['TGL_KELUAR']; ?></td>
            <td align="center"><?php echo formatNoMR($data['NOMR']); ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td><?php echo jenisKelamin($data['JNS_KELAMIN']); ?></td>
			<td><?php echo getUmurDaftar($data['TGL_LAHIR'],$data['TGL_MASUK']); ?></td>
            <td><?php $nama_unit = $data['NAMA_UNIT'];
			if($data['NAMA_RUANG'] != '') $nama_unit .= '-' . $data['NAMA_RUANG']; 
			echo $nama_unit; ?></td>
			<td align="center">
				<a href="index.php?link=48d7eaf999756ac9411f48de50fed8ed&idx=<?php echo $data['RAWAT_ID']; ?>">lihat</a>
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