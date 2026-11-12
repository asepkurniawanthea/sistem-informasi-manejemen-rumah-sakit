<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tgl_1 = '';
if (isset($_SESSION['wtirj_tgl_1']))
    $tgl_1 = $_SESSION['wtirj_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['wtirj_tgl_1']))
    $tgl_2 = $_SESSION['wtirj_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['wtirj_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['wtirj_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['wtirj_searchkey']))
		$searchkey = $_SESSION['wtirj_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['wtirj_searchkey'] = $searchkey;
}

$unit_id = '';
if (isset($_SESSION['wtirj_unit_id']))
		$unit_id = $_SESSION['wtirj_unit_id'];

if (isset($_GET['unit_id'])) {
    $unit_id = $_GET['unit_id'];
	$_SESSION['wtirj_unit_id'] = $unit_id;
}

if(currentModul() != 'monitoring mutu') $unit_id = $_SESSION['SES_SIMRS_UNIT_ID'];

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
			<td>Nomor MR/ Nama Pasien</td>
            <td><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt" style="width:200px;"/></td>	
			<td>&nbsp;</td>
			<td>&nbsp;</td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')" /></td>
			<td>Poliklinik</td>
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
			<td><input type="submit" value="cari" class="myButton" />
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

$arr_jam_datang = array();
$arr_jam_daftar = array();
$qry_antrian = 'SELECT cs.TRANS_ID, 
				DATE_FORMAT(cs.PRINT_TIME,"%H:%i:%s") AS JAM_DATANG,
				DATE_FORMAT(cs.TRANS_END_TIME,"%H:%i:%s") AS JAM_DAFTAR
				FROM t_trans cs
				WHERE DATE(cs.PRINT_TIME) >= ' . $tgl_filter_1 . ' 
				AND DATE(cs.PRINT_TIME) <= ' . $tgl_filter_2;
$get_antrian = mysql_query($qry_antrian) or die(mysql_error());
while($dat_antrian = mysql_fetch_array($get_antrian)){
	$arr_jam_datang[$dat_antrian['TRANS_ID']] = $dat_antrian['JAM_DATANG'];	
	$arr_jam_daftar[$dat_antrian['TRANS_ID']] = $dat_antrian['JAM_DAFTAR'];	
}	

$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
mysql_select_db($database, $connect) or die(mysql_error());

$qry_pasien = 'SELECT irj.IRJA_ID,irj.NOMR, 
				DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d/%m/%Y") AS TGL_MASUK,
				un.NAMA_UNIT,psn.NAMA_PASIEN,
				DATE_FORMAT(psn.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
				DATE_FORMAT(irj.TGL_TRANS,"%H:%i:%s") AS JAM_DAFTAR_SIMRS,
				DATE_FORMAT(irj.PASIEN_MASUK,"%H:%i:%s") AS JAM_DILAYANI_SIMRS,
				TIMEDIFF(irj.PASIEN_MASUK,irj.TGL_TRANS) AS RESPONSE_TIME_POLI,
				irj.ONLINE_ID
				FROM t_irja irj
				INNER JOIN m_pasien psn ON (irj.NOMR = psn.NOMR) 
				LEFT JOIN m_unit un ON (irj.UNIT_ID = un.UNIT_ID)	
				WHERE irj.NO_PENDAFTARAN IS NOT NULL AND irj.ST_BATAL IS NULL 
				AND irj.UNIT_ID <> 9
				AND irj.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND irj.TANGGAL_DAFTAR <= ' . $tgl_filter_2;

if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_pasien = $qry_pasien . ' AND CONCAT(psn.NOMR,psn.NAMA_PASIEN) LIKE "%' . $searchkey . '%" ';
}
if(!empty($unit_id)){
	$qry_pasien = $qry_pasien . ' AND irj.UNIT_ID = "' . $unit_id . '" ';
}	
$qry_pasien = $qry_pasien . 'ORDER BY irj.IRJA_ID';

$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2;
?>
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
		<th>Tanggal</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
        <th>Tanggal Lahir</th>
		<th>Unit - Klinik</th>
		<th>Jam Daftar</th>
        <th>Jam Dilayani</th>
		<th>Response Time Dokter</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_pasien, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
        $id = $data['IRJA_ID'];
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
            <td align="center"><?php echo $data['TGL_MASUK']; ?></td>
            <td align="center"><?php echo formatNoMR($data['NOMR']); ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td align="center"><?php echo $data['TGL_LAHIR']; ?></td>
			<td><?php echo $data['NAMA_UNIT']; ?></td>
			<td align="center"><?php if(isset($arr_jam_daftar[$data['ONLINE_ID']]) and $arr_jam_daftar[$data['ONLINE_ID']] != ''){
				echo $arr_jam_daftar[$data['ONLINE_ID']];
			}else{		
				echo $data['JAM_DAFTAR_SIMRS']; 
			} ?></td>
			<td align="center"><?php echo $data['JAM_DILAYANI_SIMRS']; ?></td>
			<td align="center"><?php if(isset($arr_jam_daftar[$data['ONLINE_ID']]) and $arr_jam_daftar[$data['ONLINE_ID']] != ''){
				$checkTime = strtotime($arr_jam_daftar[$data['ONLINE_ID']]);
				$loginTime = strtotime($data['JAM_DILAYANI_SIMRS']);
				$diff = $loginTime - $checkTime;
				$hours = floor($diff / 3600);
				$mins = floor($diff / 60 % 60);
				$secs = floor($diff % 60);
				echo sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
			}else{		
				echo $data['RESPONSE_TIME_POLI']; 
			} ?></td>
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
					<input type="hidden" name="unit_id" value="<?php echo $unit_id; ?>" />
                    <input type="hidden" name="xlsfile" value="indikator_mutu/xls_waktu_tunggu_irj.php" />
                    <input type="hidden" name="xlsname" value="rpt_waktu_tunggu_irj.xls" />            
        </form>