<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tgl_1 = '';
if (isset($_SESSION['ranapsearchrekaptindakan_tgl_1']))
    $tgl_1 = $_SESSION['ranapsearchrekaptindakan_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['ranapsearchrekaptindakan_tgl_1']))
    $tgl_2 = $_SESSION['ranapsearchrekaptindakan_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['ranapsearchrekaptindakan_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['ranapsearchrekaptindakan_tgl_2'] = $_GET['tgl_2'];
}

$unit_id = '';
if (isset($_SESSION['ranapsearchrekaptindakan_unit_id']))
		$unit_id = $_SESSION['ranapsearchrekaptindakan_unit_id'];

if (isset($_GET['unit_id'])) {
    $unit_id = $_GET['unit_id'];
	$_SESSION['ranapsearchrekaptindakan_unit_id'] = $unit_id;
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
			<?php if(currentModul() != 'ranap' and currentModul() != 'kusta' and currentModul() != 'igd'){ ?>	
			<td>Poliranap</td>	
			<td><select name="unit_id" class="text_dt" >
				<option value=""> - </option>
				<?php echo getUnit($unit_id,'irna'); ?>
			</select></td>	
			<?php } ?>
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
if(currentModul() == 'ranap' or currentModul() == 'igd' or currentModul() == 'kusta')
	$qry_filter = 'AND t_irna.UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '" ';
if(!empty($unit_id))
	$qry_filter = 'AND t_irna.UNIT_ID = "' . $unit_id . '" ';	

$qry_kunjungan = 'SELECT m_unit.NAMA_UNIT, DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%Y/%m") AS TANGGAL_DAFTAR,
				t_irna_diagnosa.DIAGNOSA,
				CONCAT(m_icd_x.ICD_CODE," ",m_icd_x.DESKRIPSI) AS ICD,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "01" THEN 1 END) AS D_01,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "02" THEN 1 END) AS D_02,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "03" THEN 1 END) AS D_03,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "04" THEN 1 END) AS D_04,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "05" THEN 1 END) AS D_05,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "06" THEN 1 END) AS D_06,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "07" THEN 1 END) AS D_07,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "08" THEN 1 END) AS D_08,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "09" THEN 1 END) AS D_09,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "10" THEN 1 END) AS D_10,	
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "11" THEN 1 END) AS D_11,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "12" THEN 1 END) AS D_12,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "13" THEN 1 END) AS D_13,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "14" THEN 1 END) AS D_14,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "15" THEN 1 END) AS D_15,	
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "16" THEN 1 END) AS D_16,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "17" THEN 1 END) AS D_17,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "18" THEN 1 END) AS D_18,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "19" THEN 1 END) AS D_19,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "20" THEN 1 END) AS D_20,	
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "21" THEN 1 END) AS D_21,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "22" THEN 1 END) AS D_22,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "23" THEN 1 END) AS D_23,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "24" THEN 1 END) AS D_24,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "25" THEN 1 END) AS D_25,	
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "26" THEN 1 END) AS D_26,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "27" THEN 1 END) AS D_27,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "28" THEN 1 END) AS D_28,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "29" THEN 1 END) AS D_29,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "30" THEN 1 END) AS D_30,		
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "31" THEN 1 END) AS D_31		
				FROM t_irna
				INNER JOIN m_unit ON (t_irna.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN t_irna_diagnosa ON (t_irna.IRNA_ID = t_irna_diagnosa.IRNA_ID)
				' . $qry_filter . '
				AND t_irna.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . '
				AND t_irna.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
				LEFT JOIN m_icd_x ON (t_irna_diagnosa.ICD_CODE = m_icd_x.ICD_CODE)
				GROUP BY m_unit.NAMA_UNIT,DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%Y/%m"),CONCAT(m_icd_x.ICD_CODE," ",m_icd_x.DESKRIPSI),t_irna_diagnosa.DIAGNOSA
				ORDER BY m_unit.NAMA_UNIT,DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%Y/%m"),t_irna_diagnosa.ICD_CODE';
	
$extparam = '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&unit_id=' . $unit_id;
include('rawatinap/ranap_list_report_penyakit_harian.php');
?>
