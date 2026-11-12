<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tgl_1 = '';
if (isset($_SESSION['kliniksearchtriase_tgl_1']))
    $tgl_1 = $_SESSION['kliniksearchtriase_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['kliniksearchtriase_tgl_1']))
    $tgl_2 = $_SESSION['kliniksearchtriase_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['kliniksearchtriase_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['kliniksearchtriase_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['kliniksearchtriase_searchkey']))
		$searchkey = $_SESSION['kliniksearchtriase_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['kliniksearchtriase_searchkey'] = $searchkey;
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
            <td>Tanggal</td>
            <td><input type="text" name="tgl_1" id="tgl_1" value="<?php echo $tgl_1; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
			<td>Nama Pasien</td>
            <td><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt"/></td>
			<td></td>
			<td>&nbsp;</td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/></td>
			<td>&nbsp;</td>
			<td><input type="submit" value="cari" class="myButton" />
			<a href="index.php?link=61d85988374990d2bbb0ced59a74a7cc&idx=">
			<input type="button" value="tambah pasien" class="myButton" />
			</a></td>		
            <td align="right" colspan="2"></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_kunjungan = 'SELECT TRIASE_ID,NAMA_PASIEN,JNS_KELAMIN,TGL_LAHIR,IRJA_ID,
			DATE_FORMAT(WAKTU_KUNJUNGAN,"%d-%m-%Y %H:%i") AS WAKTU_KUNJUNGAN,
			ASSESMENT,TINDAK_LANJUT,REGISTER
			FROM t_igd_triase
			WHERE STR_TO_DATE(DATE_FORMAT(WAKTU_KUNJUNGAN,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . '
			AND STR_TO_DATE(DATE_FORMAT(WAKTU_KUNJUNGAN,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2;
	if(!empty($searchkey)){
		$searchkey = str_replace(' ', '%', $searchkey);
		$qry_kunjungan = $qry_kunjungan . ' AND NAMA_PASIEN LIKE "%' . $searchkey . '%"';
	}		
	$qry_kunjungan = $qry_kunjungan . ' ORDER BY TRIASE_ID';
$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2;
?>
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
        <th>Tanggal Kunjungan</th>
        <th>Nama Pasien</th>
        <th>Tanggal Lahir</th>
        <th>Jenis Kelamin</th>
		<th>Assesment</th>
		<th>Tindak Lanjut</th>
		<th width="120">Register</th>
        <th width="120">Option</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_kunjungan, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
        $id = $data['TRIASE_ID'];
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
            <td align="center"><?php echo $data['WAKTU_KUNJUNGAN']; ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td align="center"><?php echo changeDateFormat($data['TGL_LAHIR']); ?></td>
            <td><?php echo jenisKelamin($data['JNS_KELAMIN']); ?></td>
            <td><?php if($data['ASSESMENT'] == '1') echo 'Emergent';
					if($data['ASSESMENT'] == '2') echo 'Urgent';
					if($data['ASSESMENT'] == '3') echo 'Non Urgent'; ?></td>
			<td><?php if($data['TINDAK_LANJUT'] == '1') echo 'Periksa ke ruang pelayanan non urgent';
					if($data['TINDAK_LANJUT'] == '2') echo 'Perawatan ke ruang observasi pasien semi kritis (Urgent)';
					if($data['TINDAK_LANJUT'] == '3') echo 'Perawatan ke ruang resusitasi/ kritis (Emergent)'; ?></td>		
			<td><?php echo $data['REGISTER']; ?></td>
            <td align="center">
				<a href="index.php?link=61d85988374990d2bbb0ced59a74a7cc&idx=<?php echo $data['TRIASE_ID']; ?>" >triase</a>
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
