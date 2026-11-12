<?php
$tgl_1 = '';
if (isset($_SESSION['pendaftaranreportrekapkunjungan_tgl_1']))
    $tgl_1 = $_SESSION['pendaftaranreportrekapkunjungan_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['pendaftaranreportrekapkunjungan_tgl_1']))
    $tgl_2 = $_SESSION['pendaftaranreportrekapkunjungan_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['pendaftaranreportrekapkunjungan_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['pendaftaranreportrekapkunjungan_tgl_2'] = $_GET['tgl_2'];
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
    <table class="tableform" border="0" >
        <tr>
            <td>Tanggal</td>
            <td><input type="text" name="tgl_1" id="tgl_1" value="<?php echo $tgl_1; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
			<td>&nbsp;</td>	
			<td>&nbsp;</td>	
       </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/>
            </td>	
			<td>&nbsp;</td>
            <td align="right"><input type="submit" value="cari" class="myButton" />&nbsp;
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_kunjungan = 'SELECT DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y/%m/%d") AS TANGGAL,m_pegawai.NAMA_PEGAWAI,';
$qry_hemodialisa = 'SELECT DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%Y/%m/%d") AS TANGGAL,m_pegawai.NAMA_PEGAWAI,';

$qry_jaminan = 'SELECT DISTINCT * FROM (SELECT DISTINCT m_jaminan.JAMINAN_ID, m_jaminan.NAMA_JAMINAN,
				m_jaminan.PENDAFTARAN,m_jaminan.URUT
				FROM m_jaminan 
				INNER JOIN t_irja ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
				AND t_irja.UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '" AND t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL
				UNION
				SELECT DISTINCT m_jaminan.JAMINAN_ID, m_jaminan.NAMA_JAMINAN,
				m_jaminan.PENDAFTARAN,m_jaminan.URUT
				FROM m_jaminan 
				INNER JOIN t_hemodialisa ON (t_hemodialisa.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE STR_TO_DATE(DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				AND t_hemodialisa.PASIEN_MASUK IS NOT NULL AND t_hemodialisa.NO_ORDER IS NOT NULL AND t_hemodialisa.ST_BATAL IS NULL
				) t_daftar
				ORDER BY PENDAFTARAN DESC, URUT ASC';
$get_jaminan = mysql_query($qry_jaminan) or die(mysql_error());
$i = 1;
$field_name = array();
$qry_sum = '';
while($dat_jaminan = mysql_fetch_array($get_jaminan)){
	$qry_kunjungan = $qry_kunjungan . ' COUNT(CASE WHEN t_irja.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
										AND t_irja.ST_BARU = "1"
										THEN t_irja.IRJA_ID END) AS FIELD_BR_' . $i . ',
										COUNT(CASE WHEN t_irja.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
										AND t_irja.ST_BARU <> "1"
										THEN t_irja.IRJA_ID END) AS FIELD_LM_' . $i . ',
										COUNT(CASE WHEN t_irja.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
										AND m_pasien.JNS_KELAMIN = "L"
										THEN t_irja.IRJA_ID END) AS FIELD_LK_' . $i . ',
										COUNT(CASE WHEN t_irja.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
										AND m_pasien.JNS_KELAMIN = "P"
										THEN t_irja.IRJA_ID END) AS FIELD_PR_' . $i . ',
										COUNT(CASE WHEN t_irja.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '"
										THEN t_irja.IRJA_ID END) AS FIELD_JM_' . $i . ',';									
	$qry_hemodialisa = $qry_hemodialisa . ' COUNT(CASE WHEN t_hemodialisa.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
										AND t_hemodialisa.ST_BARU = "1"
										THEN t_hemodialisa.HEMODIALISA_ID END) AS FIELD_BR_' . $i . ',
										COUNT(CASE WHEN t_hemodialisa.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
										AND t_hemodialisa.ST_BARU <> "1"
										THEN t_hemodialisa.HEMODIALISA_ID END) AS FIELD_LM_' . $i . ',
										COUNT(CASE WHEN t_hemodialisa.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
										AND m_pasien.JNS_KELAMIN = "L"
										THEN t_hemodialisa.HEMODIALISA_ID END) AS FIELD_LK_' . $i . ',
										COUNT(CASE WHEN t_hemodialisa.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
										AND m_pasien.JNS_KELAMIN = "P"
										THEN t_hemodialisa.HEMODIALISA_ID END) AS FIELD_PR_' . $i . ',
										COUNT(CASE WHEN t_hemodialisa.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '"
										THEN t_hemodialisa.HEMODIALISA_ID END) AS FIELD_JM_' . $i . ',';
	$qry_sum = $qry_sum . ' SUM(FIELD_BR_' . $i . ') AS FIELD_BR_' . $i . ',
							SUM(FIELD_LM_' . $i . ') AS FIELD_LM_' . $i . ',
							SUM(FIELD_LK_' . $i . ') AS FIELD_LK_' . $i . ',
							SUM(FIELD_PR_' . $i . ') AS FIELD_PR_' . $i . ',
							SUM(FIELD_JM_' . $i . ') AS FIELD_JM_' . $i . ',';										
	$field_name[$i] = $dat_jaminan['NAMA_JAMINAN']; 									
$i++;	
}
	$qry_kunjungan = $qry_kunjungan . 'COUNT(CASE WHEN t_irja.ST_BARU = "1" THEN t_irja.IRJA_ID END) AS TOT_BR,
				COUNT(CASE WHEN t_irja.ST_BARU <> "1" THEN t_irja.IRJA_ID END) AS TOT_LM,
				COUNT(CASE WHEN m_pasien.JNS_KELAMIN = "L" THEN t_irja.IRJA_ID END) AS TOT_LK,
				COUNT(CASE WHEN m_pasien.JNS_KELAMIN = "P" THEN t_irja.IRJA_ID END) AS TOT_PR,
				COUNT(t_irja.IRJA_ID) AS TOTAL
				FROM t_irja
				INNER JOIN m_pasien ON (m_pasien.NOMR = t_irja.NOMR)
				INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
				AND t_irja.UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '" AND t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL
				GROUP BY DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y/%m/%d"),m_pegawai.NAMA_PEGAWAI';
				
	$qry_hemodialisa = $qry_hemodialisa . 'COUNT(CASE WHEN t_hemodialisa.ST_BARU = "1" THEN t_hemodialisa.HEMODIALISA_ID END) AS TOT_BR,
				COUNT(CASE WHEN t_hemodialisa.ST_BARU <> "1" THEN t_hemodialisa.HEMODIALISA_ID END) AS TOT_LM,
				COUNT(CASE WHEN m_pasien.JNS_KELAMIN = "L" THEN t_hemodialisa.HEMODIALISA_ID END) AS TOT_LK,
				COUNT(CASE WHEN m_pasien.JNS_KELAMIN = "P" THEN t_hemodialisa.HEMODIALISA_ID END) AS TOT_PR,
				COUNT(t_hemodialisa.HEMODIALISA_ID) AS TOTAL
				FROM t_hemodialisa
				INNER JOIN m_pasien ON (m_pasien.NOMR = t_hemodialisa.NOMR)
				INNER JOIN m_jaminan ON (t_hemodialisa.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_pegawai ON (t_hemodialisa.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
				WHERE STR_TO_DATE(DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				AND t_hemodialisa.NO_ORDER IS NOT NULL AND t_hemodialisa.ST_BATAL IS NULL
				AND t_hemodialisa.PASIEN_MASUK IS NOT NULL
				GROUP BY DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%Y/%m/%d"),m_pegawai.NAMA_PEGAWAI';	
$qry_report = 'SELECT TANGGAL,NAMA_PEGAWAI,
				' . $qry_sum . '
				SUM(TOT_BR) AS TOT_BR,
				SUM(TOT_LM) AS TOT_LM,
				SUM(TOT_LK) AS TOT_LK,
				SUM(TOT_PR) AS TOT_PR,
				SUM(TOTAL) AS TOTAL
				FROM (' . $qry_kunjungan . ' UNION ' . $qry_hemodialisa . ') t_report
				GROUP BY TANGGAL,NAMA_PEGAWAI
				ORDER BY TANGGAL,NAMA_PEGAWAI';
$get_kunjungan = mysql_query($qry_report) or die(mysql_error());	
?>
<table width="100%" border="1" class="tableData" id="tfhover">
  <tr>
    <th rowspan="3" width="5">No</th>
	<th rowspan="3">Dokter</th>
	<th rowspan="3">Tanggal</th>
    <th colspan="<?php echo 5 *($i-1); ?>">Jenis Pembayaran</th><th rowspan="2" colspan="5">Total</th>
  </tr>
  <tr>
  <?php 
	$x = 1;
	while($x < $i){
		echo '<th colspan="5">' . $field_name[$x] . '</th>';
	$x++;
	}
	?>
  </tr>
  <tr>
    <?php
	$x = 1;
	while($x < $i){
	?>
		<th>Br</th>
		<th>Lm</th>
		<th>Lk</th>
		<th>Pr</th>
		<th>Jml</th>
	<?php
	$x++;
	}
	?>
		<th>Br</th>
		<th>Lm</th>
		<th>Lk</th>
		<th>Pr</th>
		<th>Jml</th>
  </tr>
 <?php $no = 0;
	$extparam = '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2;
	$pager = new PS_Pagination($connect, $qry_report, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) { ?>  
  <tr>
    <td scope="row" align="center"><?
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
	<td><?php echo $data['NAMA_PEGAWAI']; ?></td>
	<td><?php echo $data['TANGGAL']; ?></td>
	<?php 
	$x = 1;
	while($x < $i){
		echo '<td align="right">' . currFormat($data['FIELD_BR_'. $x]) . '</td>';
		echo '<td align="right">' . currFormat($data['FIELD_LM_'. $x]) . '</td>';
		echo '<td align="right">' . currFormat($data['FIELD_LK_'. $x]) . '</td>';
		echo '<td align="right">' . currFormat($data['FIELD_PR_'. $x]) . '</td>';
		echo '<td align="right">' . currFormat($data['FIELD_JM_'. $x]) . '</td>';
	$x++;
	}
	?>
    <td align="right"><?php echo currFormat($data['TOT_BR']); ?></td>
	<td align="right"><?php echo currFormat($data['TOT_LM']); ?></td>
	<td align="right"><?php echo currFormat($data['TOT_LK']); ?></td>
	<td align="right"><?php echo currFormat($data['TOT_PR']); ?></td>
	<td align="right"><?php echo currFormat($data['TOTAL']); ?></td>
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
					<input type="hidden" name="xlsfile" value="hemodialisa/xls_report_pasien_jaminan.php" />
                    <input type="hidden" name="xlsname" value="rpt_pasien_harian.xls" />            
        </form>
