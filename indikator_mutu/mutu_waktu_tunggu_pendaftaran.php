<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tgl_1 = '';
if (isset($_SESSION['wtipapp_tgl_1']))
    $tgl_1 = $_SESSION['wtipapp_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['wtipapp_tgl_1']))
    $tgl_2 = $_SESSION['wtipapp_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['wtipapp_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['wtipapp_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['wtipapp_searchkey']))
		$searchkey = $_SESSION['wtipapp_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['wtipapp_searchkey'] = $searchkey;
}

$unit_id = '';
if (isset($_SESSION['wtipapp_unit_id']))
		$unit_id = $_SESSION['wtipapp_unit_id'];

if (isset($_GET['unit_id'])) {
    $unit_id = $_GET['unit_id'];
	$_SESSION['wtipapp_unit_id'] = $unit_id;
}

//if(currentModul() != 'monitoring mutu') $unit_id = $_SESSION['SES_SIMRS_UNIT_ID'];

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
			<td>Nama Petugas</td>
            <td><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt" style="width:200px;"/></td>	
			<td>&nbsp;</td>
			<td>&nbsp;</td>
        
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')" /></td>
		<!--	<td>Poliklinik</td>
			<td><select name="unit_id" class="text_dt" style="width:210px;"
				<?php if(currentModul() == 'klinik') echo 'disabled="disabled"'; ?> >
				<option value=""> - </option>
				<?php if(currentModul() == 'monitoring mutu'){
						echo getUnit('umumkusta',$unit_id);
					}else if(currentModul() == 'kusta'){
						echo getUnit('kusta',$_SESSION['SES_SIMRS_UNIT_ID']);
					}else if(currentModul() == 'klinik'){
						echo getUnit('umum',$_SESSION['SES_SIMRS_UNIT_ID']);
					} 
				 ?>
			</select></td>
        -->	<td><input type="submit" value="cari" class="myButton" />
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>		
			<td align="right" colspan="2">&nbsp;</td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php

$connect = mysql_connect($hostname_4, $username_4, $password_4) or die(mysql_error());
mysql_select_db($database_4, $connect) or die(mysql_error());

$qry_antrian = 'SELECT TRANS_ID,DATE_FORMAT(PRINT_TIME,"%H:%i:%s") AS JAM_DATANG,
                DATE_FORMAT(CALL_TIME,"%H:%i:%s") AS JAM_PANGGIL,NO_ANTRIAN,
                DATE_format(PRINT_TIME,"%d/%m/%Y") AS TGL_DATANG,PRINT_TIME,
                KODE_COUNTER,CONCAT(NO_ANTRIAN_GROUP,"-",NO_ANTRIAN) AS NO_ANTRI,
                TIMEDIFF(CALL_TIME,PRINT_TIME) AS RESPONSE_TIME_TPP,
                NAMA_USER FROM t_trans WHERE NO_SHOW IS NULL AND SKIP IS NULL AND 
				DATE(PRINT_TIME) >= ' . $tgl_filter_1 . ' AND DATE(PRINT_TIME) <= ' . $tgl_filter_2 . '';

if (!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_antrian = $qry_antrian . ' AND NAMA_USER LIKE "%' . $searchkey . '%" ';
}	

$qry_antrian = $qry_antrian . 'ORDER BY t_trans.NO_ANTRIAN_GROUP,NO_ANTRIAN';

$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2;
?>
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
		<th>Tanggal</th>
        <th>Nomor Antrian</th>
        <th>Kode Counter</th>
        <th>Nama Petugas TPP</th>
		<th>Jam Ambil Antrian</th>
    <!--    <th>Estimasi Panggil Antrian ( SPM x ( Sisa Antrian-1 ) )</th> -->
        <th>Jam Panggil Antrian</th>
		<th>Response Time TPP</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_antrian, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
        $id = $data['TRANS_ID'];
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
    echo ($hal * 10) + $no; ?></td>
            <td align="center"><?php echo $data['TGL_DATANG']; ?></td>
            <td align="center"><?php echo $data['NO_ANTRI']; ?></td>
            <td align="center"><?php echo $data['KODE_COUNTER']; ?></td>
            <td>
                <?php 
                $kata = $data['NAMA_USER'];
                $nama_user = subStr($kata,11);
                echo $nama_user; 
                ?></td>
			<td align="center"><?php echo $data['JAM_DATANG']; ?></td>
        <!--    <td align="center">
                <?php
                    $time = strtotime($data['PRINT_TIME']);
                    $sisa_antrian = $data['NO_ANTRIAN'] - 1;
                    $estimasi = 7 * 60 * $sisa_antrian;
                    $estimasi = $time + $estimasi;
                    $estimasi = date('H:i:s',$estimasi);
                    
                    echo $estimasi;
                ?>
            </td> -->
			<td align="center"><?php echo $data['JAM_PANGGIL']; ?></td>
			<td align="center"><?php echo $data['RESPONSE_TIME_TPP']; ?></td>
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
<form id="xls_export" name="xls_export" method="post">
                    <input type="hidden" name="page_to_excel" value="1" />
                    <input type="hidden" name="tgl_1" value="<?php echo $tgl_1; ?>" />
                    <input type="hidden" name="tgl_2" value="<?php echo $tgl_2; ?>" />
                    <input type="hidden" name="searchkey" value="<?php echo $searchkey; ?>" />
                    <input type="hidden" name="xlsfile" value="indikator_mutu/xls_waktu_tunggu_pendaftaran.php" />
                    <input type="hidden" name="xlsname" value="rpt_waktu_tunggu_pendaftaran.xls" />            
        </form>