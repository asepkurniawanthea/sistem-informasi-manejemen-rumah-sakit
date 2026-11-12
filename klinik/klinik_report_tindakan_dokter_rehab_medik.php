<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tgl_1 = '';
if (isset($_SESSION['kliniksearchrekaptindakan_tgl_1']))
    $tgl_1 = $_SESSION['kliniksearchrekaptindakan_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['kliniksearchrekaptindakan_tgl_1']))
    $tgl_2 = $_SESSION['kliniksearchrekaptindakan_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['kliniksearchrekaptindakan_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['kliniksearchrekaptindakan_tgl_2'] = $_GET['tgl_2'];
}

$unit_id = '';
if (isset($_SESSION['kliniksearchrekaptindakan_unit_id']))
		$unit_id = $_SESSION['kliniksearchrekaptindakan_unit_id'];

if (isset($_GET['unit_id'])) {
    $unit_id = $_GET['unit_id'];
	$_SESSION['kliniksearchrekaptindakan_unit_id'] = $unit_id;
}

$pegawai_id = '';
if (isset($_SESSION['kliniksearchrekaptindakan_pegawai_id']))
		$pegawai_id = $_SESSION['kliniksearchrekaptindakan_pegawai_id'];

if (isset($_GET['pegawai_id'])) {
    $pegawai_id = $_GET['pegawai_id'];
	$_SESSION['kliniksearchrekaptindakan_pegawai_id'] = $pegawai_id;
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
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/></td>
            <td colspan="2" align="right"><input type="submit" value="cari" class="myButton" />&nbsp;
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_filter = '';
if(!empty($unit_id))
	$qry_filter = 'AND t_ipenunjang_tarif.UNIT_PENUNJANG_ID = "' . $unit_id . '" ';	

$qry_kunjungan = 'SELECT t_ipenunjang.JNS_ORDER,t_ipenunjang_tarif.NO_SJP,t_ipenunjang.PENUNJANG_ID,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_unit.NAMA_UNIT,
				CASE WHEN t_ipenunjang.JNS_ORDER = "APS" THEN t_ipenunjang.NO_PASIEN_PENUNJANG 
				ELSE t_ipenunjang.NOMR END AS NOMR,
				CASE WHEN t_ipenunjang.JNS_ORDER = "APS" THEN t_ipenunjang.NAMA_PASIEN 
				ELSE m_pasien.NAMA_PASIEN END AS NAMA_PASIEN,
				CASE WHEN t_ipenunjang.JNS_ORDER = "APS" THEN t_ipenunjang.PENGIRIM 
				ELSE m_unit2.NAMA_UNIT END AS NAMA_UNIT,
				CASE WHEN t_ipenunjang.JNS_ORDER <> "APS" THEN m_ruang.NAMA_RUANG END AS NAMA_RUANG,
				m_pegawai.NAMA_PEGAWAI,
				m_tarif_group.NAMA_TARIF_GROUP,
				m_tarif.NAMA_TARIF,
				m_jaminan.NAMA_JAMINAN,
				m_pegawai2.NAMA_PEGAWAI AS PEMERIKSA,
				SUM(t_ipenunjang_tarif.KUANTITI) AS JUMLAH		
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_unit ON (t_ipenunjang_tarif.UNIT_PENUNJANG_ID = m_unit.UNIT_ID)
				LEFT JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				LEFT JOIN m_unit m_unit2 ON (t_ipenunjang.UNIT_ID = m_unit2.UNIT_ID)
				LEFT JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
				LEFT JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai2.PEGAWAI_ID)
				WHERE DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
				' . $qry_filter . '
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL 
				AND t_ipenunjang_tarif.ST_BATAL IS NULL
				AND t_ipenunjang_tarif.ST_PERIKSA = "1"
				AND t_ipenunjang_tarif.UNIT_PENUNJANG_ID IN (41,42,47,31,40)
				AND m_tarif.KODE_TARIF_GROUP <> "01" 
				' . (($_SESSION['SES_SIMRS_UNIT_ID'] == '34') ? '' : ' AND t_ipenunjang.JNS_ORDER = "999" ') . '
				GROUP BY t_ipenunjang.JNS_ORDER,t_ipenunjang_tarif.NO_SJP,t_ipenunjang.PENUNJANG_ID,
				m_tarif_group.NAMA_TARIF_GROUP,m_tarif.NAMA_TARIF
				ORDER BY t_ipenunjang.PENUNJANG_ID';
	
$extparam = '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2; ?>
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
		<th>Tanggal</th>
		<th>Unit</th>
		<th>No MR</th>
		<th>Nama Pasien</th>
		<th>Unit Pengirim</th>
        <th>Dokter</th>
		<th>Jenis Tindakan</th>
		<th>Jumlah</th>
        <th>Jaminan</th>
        <th>Pemeriksa</th>
    </tr>
    <?
    $no = 0;
	$pager = new PS_Pagination($connect, $qry_kunjungan, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
        $id = '';
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
			<td><?php echo $data['TANGGAL_DAFTAR']; ?></td>
            <td><?php echo $data['NAMA_UNIT']; ?></td>
			<td><?php echo formatNomr($data['NOMR']); ?></td>
			<td><?php echo $data['NAMA_PASIEN']; ?></td>
			<td><?php echo ((!empty($data['NAMA_RUANG'])) ? $data['NAMA_RUANG'] : $data['NAMA_UNIT']) ; ?></td>
			<td><?php echo $data['NAMA_PEGAWAI']; ?></td>
			<td><?php echo $data['NAMA_TARIF'] . ' (' . $data['NAMA_TARIF_GROUP'] . ')'; ?></td>
			<td align="right"><?php echo currFormat($data['JUMLAH']); ?></td>
			<td><?php echo $data['NAMA_JAMINAN']; ?></td>
			<td><?php echo $data['PEMERIKSA']; ?></td>
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
                    <input type="hidden" name="xlsfile" value="klinik/xls_report_tindakan_dokter_rehab_medik.php" />
                    <input type="hidden" name="xlsname" value="rpt_tindakan_rehab_medik.xls" />            
        </form>
