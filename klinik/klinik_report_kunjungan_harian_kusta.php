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
			<td>&nbsp;</td>
            <td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/></td>
			<td>&nbsp;</td>
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
$qry_kunjungan = 'SELECT t_irja.TANGGAL_DAFTAR,
	COUNT(t_irja.IRJA_ID) AS TOTAL, 
	SUM(CASE WHEN (DATEDIFF(t_irja.TANGGAL_DAFTAR, m_pasien.TGL_LAHIR)/365) >= 14 
		THEN 1 ELSE 0 END) AS DEWASA,
	SUM(CASE WHEN (DATEDIFF(t_irja.TANGGAL_DAFTAR, m_pasien.TGL_LAHIR)/365) < 14 
		THEN 1 ELSE 0 END) AS ANAK,
	SUM(CASE WHEN m_pasien.JNS_KELAMIN = "L" THEN 1 ELSE 0 END) AS LK,
	SUM(CASE WHEN m_pasien.JNS_KELAMIN = "P" THEN 1 ELSE 0 END) AS PR,
	SUM(CASE WHEN (SELECT COUNT(t.IRJA_ID) AS CN FROM t_irja t 
		WHERE t.NOMR = t_irja.NOMR AND t.IRJA_ID < t_irja.IRJA_ID) = 0
		THEN 1 ELSE 0 END) AS PASIEN_BR,
	SUM(CASE WHEN t_irja.KUSTA_TYPE = "NR" THEN 1 ELSE 0 END) AS NR,	
	SUM(CASE WHEN t_irja.KUSTA_TYPE = "TT" THEN 1 ELSE 0 END) AS TT,
	SUM(CASE WHEN t_irja.KUSTA_TYPE = "BT" THEN 1 ELSE 0 END) AS BT,
	SUM(CASE WHEN t_irja.KUSTA_TYPE = "BB" THEN 1 ELSE 0 END) AS BB,
	SUM(CASE WHEN t_irja.KUSTA_TYPE = "BL" THEN 1 ELSE 0 END) AS BL,
	SUM(CASE WHEN t_irja.KUSTA_TYPE = "LL" THEN 1 ELSE 0 END) AS LL,
	SUM(CASE WHEN t_irja.KUSTA_TYPE = "OM" THEN 1 ELSE 0 END) AS OBSERVASI,
	SUM(CASE WHEN t_irja.KUSTA_TYPE = "NM" THEN 1 ELSE 0 END) AS NON_MH,
	SUM(CASE WHEN t_irja.KUSTA_RFT_COT IS NOT NULL THEN 1 ELSE 0 END) AS RFT,
	SUM(CASE WHEN t_irja.KUSTA_KUNJUNGAN = 1 THEN 1 ELSE 0 END) AS PERTAMA, 	 	
	SUM(CASE WHEN t_irja.KUSTA_OPNAME = "1" THEN 1 ELSE 0 END) AS OPNAME 	
	FROM t_irja
	INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR) 
	WHERE t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL 
	AND t_irja.UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '"
	AND t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . '
	AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
	GROUP BY t_irja.TANGGAL_DAFTAR
	ORDER BY t_irja.TANGGAL_DAFTAR';
	

$extparam = '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2;
include('klinik/klinik_list_kunjungan_pasien_harian_kusta.php');
?>
