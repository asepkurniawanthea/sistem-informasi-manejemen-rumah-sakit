<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tgl_1 = '';
if (isset($_SESSION['kliniksearchpasiendaftar_tgl_1']))
    $tgl_1 = $_SESSION['kliniksearchpasiendaftar_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['kliniksearchpasiendaftar_tgl_1']))
    $tgl_2 = $_SESSION['kliniksearchpasiendaftar_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['kliniksearchpasiendaftar_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['kliniksearchpasiendaftar_tgl_2'] = $_GET['tgl_2'];
}

$unit_id = $_SESSION['SES_SIMRS_UNIT_ID'];
if (isset($_SESSION['kliniksearchpasiendaftar_unit_id']))
		$unit_id = $_SESSION['kliniksearchpasiendaftar_unit_id'];

if (isset($_GET['unit_id'])) {
    $unit_id = $_GET['unit_id'];
	$_SESSION['kliniksearchpasiendaftar_unit_id'] = $unit_id;
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
			<td><?php if(currentModul() == 'admin rawat jalan'){ ?>Poliklinik<?php } ?></td>	
			<td><?php if(currentModul() == 'admin rawat jalan'){ ?><select name="unit_id" class="text_dt" >
				<option value=""> - </option>
				<?php echo getUnit('umumigd',$unit_id); ?>
			</select><?php } ?></td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/></td>
			<td>&nbsp;</td>		
            <td align="right" colspan="2"><input type="submit" value="cari" class="myButton" />&nbsp;
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" />
			</td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry = 'SELECT * FROM (
		SELECT m_unit.UNIT_ID,m_unit.NAMA_UNIT,
		m_icd_x.ICD_CODE,m_icd_x.DESKRIPSI,
		CASE WHEN t_irja_diagnosa.KASUS_BARU = "1" THEN "Baru" END AS KASUS_BARU,
		COUNT(DISTINCT t_irja.IRJA_ID) AS JML_PASIEN
		FROM m_unit
		INNER JOIN t_irja ON (m_unit.UNIT_ID = t_irja.UNIT_ID)
		INNER JOIN t_irja_diagnosa ON (t_irja.IRJA_ID = t_irja_diagnosa.IRJA_ID)
		INNER JOIN m_icd_x ON (t_irja_diagnosa.ICD_CODE = m_icd_x.ICD_CODE)
		WHERE m_unit.IRJA IN ("umum","kusta","mcu","igd") 
		AND t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . '
		AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
		AND t_irja.NO_PENDAFTARAN IS NOT NULL 
		AND t_irja.ST_BATAL IS NULL
		AND t_irja_diagnosa.DIAGNOSA_ORDER < 4
		' . (($unit_id != '') ? ' AND t_irja.UNIT_ID = "' . $unit_id . '"' : '') . '
		GROUP BY m_unit.UNIT_ID,m_unit.NAMA_UNIT,
		m_icd_x.ICD_CODE,m_icd_x.DESKRIPSI,
		KASUS_BARU
		) t_diag
		ORDER BY JML_PASIEN DESC';
?>
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
        <th>ICD Code</th>
        <th>Diagnosa Penyakit</th>
        <th>Jumlah</th>
        <th>Kasus Baru</th>
    </tr>
 <?
    $no = 1;
    $rs = mysql_query($qry) or die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
    ?>
     <tr>
     <td align="center"><?php echo $no; ?></td>
	 <td><?php echo $data['ICD_CODE']; ?></td>
	 <td><?php echo $data['DESKRIPSI']; ?></td>
	 <td align="right"><?php echo $data['JML_PASIEN']; ?></td>
	 <td><?php echo $data['KASUS_BARU']; ?></td>
    </tr>
    <? $no++;
    }
    ?>
</table>
		<form id="xls_export" name="xls_export" method="post">
                    <input type="hidden" name="page_to_excel" value="1" />
                    <input type="hidden" name="tgl_1" value="<?php echo $tgl_1; ?>" />
                    <input type="hidden" name="tgl_2" value="<?php echo $tgl_2; ?>" />
					<input type="hidden" name="unit_id" value="<?php echo $unit_id; ?>" />
                    <input type="hidden" name="xlsfile" value="adminrajal/xls_report_penyakit_terbanyak.php" />
                    <input type="hidden" name="xlsname" value="rpt_pasien.xls" />            
        </form>