<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tgl_1 = '';
if (isset($_SESSION['reportsearchrekaptindakan_tgl_1']))
    $tgl_1 = $_SESSION['reportsearchrekaptindakan_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['reportsearchrekaptindakan_tgl_1']))
    $tgl_2 = $_SESSION['reportsearchrekaptindakan_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['reportsearchrekaptindakan_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['reportsearchrekaptindakan_tgl_2'] = $_GET['tgl_2'];
}

$unit_id = '';
if (isset($_SESSION['reportsearchrekaptindakan_unit_id']))
		$unit_id = $_SESSION['reportsearchrekaptindakan_unit_id'];

if (isset($_GET['unit_id'])) {
    $unit_id = $_GET['unit_id'];
	$_SESSION['reportsearchrekaptindakan_unit_id'] = $unit_id;
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
			<td>Poliklinik</td>
			<td><select name="unit_id" class="text_dt" >
				<option value=""> - </option>
				<?php echo getUnit('irja',$unit_id); ?>
			</select></td>	
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
	$qry_filter = ' WHERE t_tindakan.UNIT_ID = "' . $unit_id . '" ';	

$qry_kunjungan = 'SELECT * FROM (
						SELECT "01" AS URUT,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.NAMA_TARIF,
						m_tarif.KODE_TARIF,SUM(t_irja_tarif.KUANTITI) AS KUANTITI,
						t_irja.UNIT_ID,m_unit.NAMA_UNIT,
						"" AS NAMA_PEGAWAI,
						"" AS PELAKSANA
						FROM t_irja
						INNER JOIN t_irja_tarif ON (t_irja.IRJA_ID = t_irja_tarif.IRJA_ID)
						INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
						INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						WHERE t_irja_tarif.NO_TARIF IS NOT NULL AND t_irja_tarif.ST_BAYAR <> "Batal"
						AND t_irja.ST_BATAL IS NULL	
						AND m_tarif_group.KODE_TARIF_GROUP = "01" 
						AND STR_TO_DATE(DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . '
						AND STR_TO_DATE(DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
						GROUP BY m_tarif_group.NAMA_TARIF_GROUP,m_tarif.NAMA_TARIF,
						m_tarif.KODE_TARIF,t_irja.UNIT_ID,m_unit.NAMA_UNIT
						UNION
						SELECT "02" AS URUT,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.NAMA_TARIF,
						m_tarif.KODE_TARIF,SUM(t_irja_tarif.KUANTITI) AS KUANTITI,
						t_irja.UNIT_ID,m_unit.NAMA_UNIT,
						m_pegawai.NAMA_PEGAWAI,
						"" AS PELAKSANA
						FROM t_irja
						INNER JOIN t_irja_tarif ON (t_irja.IRJA_ID = t_irja_tarif.IRJA_ID)
						INNER JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
						INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
						INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						WHERE t_irja_tarif.NO_TARIF IS NOT NULL AND t_irja_tarif.ST_BAYAR <> "Batal"
						AND t_irja.ST_BATAL IS NULL	
						AND (m_tarif_group.KODE_TARIF_GROUP = "02" OR m_tarif_group.KODE_TARIF_GROUP = "09")
						AND STR_TO_DATE(DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . '
						AND STR_TO_DATE(DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
						GROUP BY m_tarif_group.NAMA_TARIF_GROUP,m_tarif.NAMA_TARIF,
						m_tarif.KODE_TARIF,t_irja.UNIT_ID,m_unit.NAMA_UNIT,
						m_pegawai.NAMA_PEGAWAI
						UNION
						SELECT "03" AS URUT,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.NAMA_TARIF,
						m_tarif.KODE_TARIF,SUM(t_irja_tarif.KUANTITI) AS KUANTITI,
						t_irja.UNIT_ID,m_unit.NAMA_UNIT,
						m_pegawai.NAMA_PEGAWAI,
						m_pegawai1.NAMA_PEGAWAI AS PELAKSANA
						FROM t_irja
						INNER JOIN t_irja_tarif ON (t_irja.IRJA_ID = t_irja_tarif.IRJA_ID)
						INNER JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
						INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
						INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						LEFT JOIN m_pegawai m_pegawai1 ON (t_irja_tarif.PEGAWAI_ID = m_pegawai1.PEGAWAI_ID)
						WHERE t_irja_tarif.NO_TARIF IS NOT NULL AND t_irja_tarif.ST_BAYAR <> "Batal"
						AND t_irja.ST_BATAL IS NULL	
						AND m_tarif_group.LABORATORIUM <> "1" 
						AND m_tarif_group.LABORATORIUM_CITO <> "1"
						AND m_tarif_group.RADIOLOGI <> "1" 
						AND m_tarif_group.RADIOLOGI_CITO <> "1"
						AND m_tarif_group.KODE_TARIF_GROUP <> "01"
						AND m_tarif_group.KODE_TARIF_GROUP <> "02"
						AND m_tarif_group.KODE_TARIF_GROUP <> "09"
						AND STR_TO_DATE(DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . '
						AND STR_TO_DATE(DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
						GROUP BY m_tarif_group.NAMA_TARIF_GROUP,m_tarif.NAMA_TARIF,
						m_tarif.KODE_TARIF,t_irja.UNIT_ID,m_unit.NAMA_UNIT,
						m_pegawai.NAMA_PEGAWAI,m_pegawai1.NAMA_PEGAWAI) t_tindakan
						' . $qry_filter . '
						ORDER BY URUT,KODE_TARIF,NAMA_UNIT,NAMA_PEGAWAI,PELAKSANA';
$extparam = '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&unit_id=' . $unit_id;
?>
<table class="tableData">
	<tr>
		<th width="30">No</th>
		<th>Poliklinik</th>
		<th width="80">Kode</th>
		<th>Jenis Kegiatan</th>
		<th>Dokter Penanggung Jawab</th>
		<th>Pelaksana</th>
		<th width="50">Jumlah</th>
	</tr>

<?php 
$no = 0;
	$pager = new PS_Pagination($connect, $qry_kunjungan, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($dat_kunjungan = mysql_fetch_array($rs)) {
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
		<td><?php echo $dat_kunjungan['NAMA_UNIT']; ?></td>
		<td align="center"><?php echo $dat_kunjungan['KODE_TARIF']; ?></td>
		<td><?php echo $dat_kunjungan['NAMA_TARIF'] . ' (' . $dat_kunjungan['NAMA_TARIF_GROUP'] . ')'; ?></td>
		<td><?php echo $dat_kunjungan['NAMA_PEGAWAI']; ?></td>
		<td><?php echo $dat_kunjungan['PELAKSANA']; ?></td>
		<td align="right"><?php echo currFormat($dat_kunjungan['KUANTITI']); ?></td>
	</tr>
<?php } ?>
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
                    <input type="hidden" name="unit_id" value="<?php echo $unit_id; ?>" />
                    <input type="hidden" name="xlsfile" value="report/xls_report_volume_kegiatan_irja.php" />
                    <input type="hidden" name="xlsname" value="rpt_volume_kegiatan.xls" />            
        </form>