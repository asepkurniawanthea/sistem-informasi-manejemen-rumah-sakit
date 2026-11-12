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
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><input type="submit" value="cari" class="myButton" />
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>		
			<td align="right" colspan="2">&nbsp;</td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_pasien = 'SELECT DISTINCT t_order.*,
				CASE WHEN t_order.JNS_ORDER <> "APS" THEN m_pasien.NAMA_PASIEN ELSE t_ipenunjang.NAMA_PASIEN END AS NAMA_PASIEN,
				CASE WHEN t_order.JNS_ORDER <> "APS" THEN m_pasien.TGL_LAHIR ELSE t_ipenunjang.TGL_LAHIR END AS TGL_LAHIR,
				CASE WHEN t_order.JNS_ORDER <> "APS" THEN m_pasien.ALAMAT ELSE t_ipenunjang.ALAMAT END AS ALAMAT,
				CASE WHEN t_order.JNS_ORDER <> "APS" THEN m_pegawai.NAMA_PEGAWAI ELSE t_ipenunjang.PENGIRIM END AS NAMA_PEGAWAI, 
				m_jaminan.NAMA_JAMINAN,CONCAT(m_ruang.NAMA_RUANG," Kls ",m_ruang.KELAS_RAWAT) AS NAMA_RUANG,
				m_unit.NAMA_UNIT,t_ipenunjang.INSTANSI_PENGIRIM
				FROM (
				SELECT t_ipenunjang.PENUNJANG_ID,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%H:%i:%s") AS JAM_DAFTAR,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_MASUK,"%d/%m/%Y") AS TANGGAL_MASUK,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_MASUK,"%H:%i:%s") AS JAM_MASUK,
				TIMEDIFF(t_ipenunjang_tarif.TANGGAL_MASUK,t_ipenunjang_tarif.TANGGAL_DAFTAR) AS RESPONSE_TIME,
				t_ipenunjang.NOMR,
				t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang.PEGAWAI_ID,t_ipenunjang.JNS_ORDER,
				t_ipenunjang_tarif.UNIT_PENUNJANG_ID AS UNIT_ID,NULL AS RUANG_ID,
				SUM(CASE WHEN t_ipenunjang_tarif.ST_PERIKSA = "1" THEN 1 ELSE 0 END) AS ST_PERIKSA,
				t_ipenunjang_tarif.USER_PERIKSA,t_ipenunjang_tarif.NO_SJP,
				t_ipenunjang.MCU,t_ipenunjang.JENIS_BAYAR_ID,
				"" AS EXT_NAMA_UNIT	
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				WHERE t_ipenunjang.JNS_ORDER = "IRJ"
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang_tarif.UNIT_PENUNJANG_ID IN (31,41,47,40,42) 
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
				GROUP BY t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_SJP
				UNION
				SELECT t_ipenunjang.PENUNJANG_ID,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%H:%i:%s") AS JAM_DAFTAR,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_MASUK,"%d/%m/%Y") AS TANGGAL_MASUK,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_MASUK,"%H:%i:%s") AS JAM_MASUK,
				TIMEDIFF(t_ipenunjang_tarif.TANGGAL_MASUK,t_ipenunjang_tarif.TANGGAL_DAFTAR) AS RESPONSE_TIME,
				t_ipenunjang.NOMR,
				t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang.PEGAWAI_ID,t_ipenunjang.JNS_ORDER,
				t_ipenunjang_tarif.UNIT_PENUNJANG_ID AS UNIT_ID,t_ipenunjang.RUANG_ID,
				SUM(CASE WHEN t_ipenunjang_tarif.ST_PERIKSA = "1" THEN 1 ELSE 0 END) AS ST_PERIKSA,
				t_ipenunjang_tarif.USER_PERIKSA,t_ipenunjang_tarif.NO_SJP,
				t_ipenunjang.MCU,t_ipenunjang.JENIS_BAYAR_ID,
				"" AS EXT_NAMA_UNIT	
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				WHERE t_ipenunjang.JNS_ORDER = "IRN"
				AND t_ipenunjang_tarif.UNIT_PENUNJANG_ID IN (31,41,47,40,42) 
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
				GROUP BY t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_SJP
				UNION
				SELECT t_ipenunjang.PENUNJANG_ID,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%H:%i:%s") AS JAM_DAFTAR,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_MASUK,"%d/%m/%Y") AS TANGGAL_MASUK,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_MASUK,"%H:%i:%s") AS JAM_MASUK,
				TIMEDIFF(t_ipenunjang_tarif.TANGGAL_MASUK,t_ipenunjang_tarif.TANGGAL_DAFTAR) AS RESPONSE_TIME,
				t_ipenunjang.NO_PASIEN_PENUNJANG AS NOMR,
				"" AS RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,NULL AS PEGAWAI_ID,t_ipenunjang.JNS_ORDER,
				t_ipenunjang_tarif.UNIT_PENUNJANG_ID AS UNIT_ID,NULL AS RUANG_ID,
				SUM(CASE WHEN t_ipenunjang_tarif.ST_PERIKSA = "1" THEN 1 ELSE 0 END) AS ST_PERIKSA,
				t_ipenunjang_tarif.USER_PERIKSA,t_ipenunjang_tarif.NO_SJP,
				t_ipenunjang.MCU,t_ipenunjang.JENIS_BAYAR_ID,
				"" AS EXT_NAMA_UNIT	
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				WHERE t_ipenunjang.JNS_ORDER = "APS"
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang_tarif.UNIT_PENUNJANG_ID IN (31,41,47,40,42) 
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
				GROUP BY t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_SJP
				UNION
				SELECT t_ipenunjang.PENUNJANG_ID,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%H:%i:%s") AS JAM_DAFTAR,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_MASUK,"%d/%m/%Y") AS TANGGAL_MASUK,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_MASUK,"%H:%i:%s") AS JAM_MASUK,
				TIMEDIFF(t_ipenunjang_tarif.TANGGAL_MASUK,t_ipenunjang_tarif.TANGGAL_DAFTAR) AS RESPONSE_TIME,
				t_ipenunjang.NOMR,
				t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang.PEGAWAI_ID,t_ipenunjang.JNS_ORDER,
				t_ipenunjang_tarif.UNIT_PENUNJANG_ID AS UNIT_ID, NULL AS RUANG_ID,
				SUM(CASE WHEN t_ipenunjang_tarif.ST_PERIKSA = "1" THEN 1 ELSE 0 END) AS ST_PERIKSA,
				t_ipenunjang_tarif.USER_PERIKSA,t_ipenunjang_tarif.NO_SJP,
				t_ipenunjang.MCU,t_ipenunjang.JENIS_BAYAR_ID,
				"Hemodialisa" AS EXT_NAMA_UNIT	
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				WHERE t_ipenunjang.JNS_ORDER = "HRJ"
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang_tarif.UNIT_PENUNJANG_ID IN (31,41,47,40,42) 
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
				GROUP BY t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_SJP
				UNION
				SELECT t_ipenunjang.PENUNJANG_ID,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%H:%i:%s") AS JAM_DAFTAR,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_MASUK,"%d/%m/%Y") AS TANGGAL_MASUK,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_MASUK,"%H:%i:%s") AS JAM_MASUK,
				TIMEDIFF(t_ipenunjang_tarif.TANGGAL_MASUK,t_ipenunjang_tarif.TANGGAL_DAFTAR) AS RESPONSE_TIME,
				t_ipenunjang.NOMR,
				t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang.PEGAWAI_ID,t_ipenunjang.JNS_ORDER,
				t_ipenunjang_tarif.UNIT_PENUNJANG_ID AS UNIT_ID,t_ipenunjang.RUANG_ID,
				SUM(CASE WHEN t_ipenunjang_tarif.ST_PERIKSA = "1" THEN 1 ELSE 0 END) AS ST_PERIKSA,
				t_ipenunjang_tarif.USER_PERIKSA,t_ipenunjang_tarif.NO_SJP,
				t_ipenunjang.MCU,t_ipenunjang.JENIS_BAYAR_ID,
				"Hemodialisa" AS EXT_NAMA_UNIT	
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				WHERE t_ipenunjang.JNS_ORDER = "HRI"
				AND t_ipenunjang_tarif.UNIT_PENUNJANG_ID IN (31,41,47,40,42) 
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
				GROUP BY t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_SJP
				) t_order 
				INNER JOIN m_jaminan ON (t_order.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				LEFT JOIN m_pasien ON (t_order.NOMR = m_pasien.NOMR)
				LEFT JOIN m_unit ON (t_order.UNIT_ID = m_unit.UNIT_ID)
				LEFT JOIN m_ruang ON (t_order.RUANG_ID = m_ruang.RUANG_ID)
				LEFT JOIN m_pegawai ON (t_order.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN t_ipenunjang ON (t_order.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID
					AND t_ipenunjang.JNS_ORDER = "APS")
				' . (($_SESSION['SES_SIMRS_UNIT_ID'] == '34') ? ' WHERE 1 ' : ' WHERE t_ipenunjang.JNS_ORDER = "999" ');

if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_pasien = $qry_pasien . ' AND CONCAT(m_pasien.NOMR,m_pasien.NAMA_PASIEN) LIKE "%' . $searchkey . '%" ';
}

$qry_pasien = $qry_pasien . ' ORDER BY t_order.PENUNJANG_ID';

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
		<th>Response Time</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_pasien, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
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
            <td align="center"><?php echo $data['TANGGAL_DAFTAR']; ?></td>
            <td align="center"><?php echo ((strlen($data['NOMR']) == 6) ? formatNoMR($data['NOMR']) : $data['NOMR']); ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td align="center"><?php echo $data['TGL_LAHIR']; ?></td>
			<td><?php echo $data['NAMA_UNIT']; ?></td>
			<td align="center"><?php echo $data['JAM_DAFTAR']; ?></td>
			<td align="center"><?php echo $data['JAM_MASUK']; ?></td>
			<td align="center"><?php echo $data['RESPONSE_TIME']; ?></td>
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
                    <input type="hidden" name="xlsfile" value="indikator_mutu/xls_waktu_tunggu_irj_rehab_medik.php" />
                    <input type="hidden" name="xlsname" value="rpt_waktu_tunggu_irj_rehab_medik.xls" />            
        </form>