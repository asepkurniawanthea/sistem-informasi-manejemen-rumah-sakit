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
			<td>&nbsp;</td>	
			<td>&nbsp;</td>	
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
$qry_kunjungan = 'SELECT DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y/%m") AS TANGGAL_DAFTAR,
				t_irja_diagnosa.DIAGNOSA,
				CONCAT(m_icd_x.ICD_CODE," ",m_icd_x.DESKRIPSI) AS ICD,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "01" THEN 1 END) AS D_01,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "02" THEN 1 END) AS D_02,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "03" THEN 1 END) AS D_03,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "04" THEN 1 END) AS D_04,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "05" THEN 1 END) AS D_05,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "06" THEN 1 END) AS D_06,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "07" THEN 1 END) AS D_07,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "08" THEN 1 END) AS D_08,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "09" THEN 1 END) AS D_09,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "10" THEN 1 END) AS D_10,	
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "11" THEN 1 END) AS D_11,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "12" THEN 1 END) AS D_12,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "13" THEN 1 END) AS D_13,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "14" THEN 1 END) AS D_14,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "15" THEN 1 END) AS D_15,	
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "16" THEN 1 END) AS D_16,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "17" THEN 1 END) AS D_17,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "18" THEN 1 END) AS D_18,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "19" THEN 1 END) AS D_19,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "20" THEN 1 END) AS D_20,	
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "21" THEN 1 END) AS D_21,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "22" THEN 1 END) AS D_22,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "23" THEN 1 END) AS D_23,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "24" THEN 1 END) AS D_24,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "25" THEN 1 END) AS D_25,	
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "26" THEN 1 END) AS D_26,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "27" THEN 1 END) AS D_27,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "28" THEN 1 END) AS D_28,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "29" THEN 1 END) AS D_29,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "30" THEN 1 END) AS D_30,		
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "31" THEN 1 END) AS D_31		
				FROM t_irja
				INNER JOIN t_irja_diagnosa ON (t_irja.IRJA_ID = t_irja_diagnosa.IRJA_ID)
				LEFT JOIN m_icd_x ON (t_irja_diagnosa.ICD_CODE = m_icd_x.ICD_CODE)
				WHERE t_irja.UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '"
				AND t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . '
				AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
				GROUP BY DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y/%m"),CONCAT(m_icd_x.ICD_CODE," ",m_icd_x.DESKRIPSI),t_irja_diagnosa.DIAGNOSA';
				
$qry_hemodialisa = 'SELECT DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%Y/%m") AS TANGGAL_DAFTAR,
				t_hemodialisa_diagnosa.DIAGNOSA,
				CONCAT(m_icd_x.ICD_CODE," ",m_icd_x.DESKRIPSI) AS ICD,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "01" THEN 1 END) AS D_01,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "02" THEN 1 END) AS D_02,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "03" THEN 1 END) AS D_03,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "04" THEN 1 END) AS D_04,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "05" THEN 1 END) AS D_05,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "06" THEN 1 END) AS D_06,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "07" THEN 1 END) AS D_07,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "08" THEN 1 END) AS D_08,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "09" THEN 1 END) AS D_09,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "10" THEN 1 END) AS D_10,	
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "11" THEN 1 END) AS D_11,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "12" THEN 1 END) AS D_12,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "13" THEN 1 END) AS D_13,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "14" THEN 1 END) AS D_14,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "15" THEN 1 END) AS D_15,	
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "16" THEN 1 END) AS D_16,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "17" THEN 1 END) AS D_17,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "18" THEN 1 END) AS D_18,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "19" THEN 1 END) AS D_19,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "20" THEN 1 END) AS D_20,	
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "21" THEN 1 END) AS D_21,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "22" THEN 1 END) AS D_22,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "23" THEN 1 END) AS D_23,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "24" THEN 1 END) AS D_24,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "25" THEN 1 END) AS D_25,	
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "26" THEN 1 END) AS D_26,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "27" THEN 1 END) AS D_27,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "28" THEN 1 END) AS D_28,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "29" THEN 1 END) AS D_29,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "30" THEN 1 END) AS D_30,		
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "31" THEN 1 END) AS D_31		
				FROM t_hemodialisa
				INNER JOIN t_hemodialisa_diagnosa ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_diagnosa.HEMODIALISA_ID)
				LEFT JOIN m_icd_x ON (t_hemodialisa_diagnosa.ICD_CODE = m_icd_x.ICD_CODE)
				WHERE STR_TO_DATE(DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . '
				AND STR_TO_DATE(DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				GROUP BY DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%Y/%m"),CONCAT(m_icd_x.ICD_CODE," ",m_icd_x.DESKRIPSI),t_hemodialisa_diagnosa.DIAGNOSA';				
$qry_report = 'SELECT TANGGAL_DAFTAR, DIAGNOSA, ICD,
				SUM(D_01) AS D_01,
				SUM(D_02) AS D_02,
				SUM(D_03) AS D_03,
				SUM(D_04) AS D_04,
				SUM(D_05) AS D_05,
				SUM(D_06) AS D_06,
				SUM(D_07) AS D_07,
				SUM(D_08) AS D_08,
				SUM(D_09) AS D_09,
				SUM(D_10) AS D_10,
				SUM(D_11) AS D_11,
				SUM(D_12) AS D_12,
				SUM(D_13) AS D_13,
				SUM(D_14) AS D_14,
				SUM(D_15) AS D_15,
				SUM(D_16) AS D_16,
				SUM(D_17) AS D_17,
				SUM(D_18) AS D_18,
				SUM(D_19) AS D_19,
				SUM(D_20) AS D_20,
				SUM(D_21) AS D_21,
				SUM(D_22) AS D_22,
				SUM(D_23) AS D_23,
				SUM(D_24) AS D_24,
				SUM(D_25) AS D_25,
				SUM(D_26) AS D_26,
				SUM(D_27) AS D_27,
				SUM(D_28) AS D_28,
				SUM(D_29) AS D_29,
				SUM(D_30) AS D_30,
				SUM(D_31) AS D_31
			FROM(' . $qry_kunjungan . ' UNION ' . $qry_hemodialisa . ') t_report
			GROUP BY TANGGAL_DAFTAR, DIAGNOSA, ICD
			ORDER BY TANGGAL_DAFTAR, DIAGNOSA, ICD';
	
$extparam = '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&unit_id=' . $unit_id;
include('hemodialisa/hemodialisa_list_report_penyakit_harian.php');
?>
