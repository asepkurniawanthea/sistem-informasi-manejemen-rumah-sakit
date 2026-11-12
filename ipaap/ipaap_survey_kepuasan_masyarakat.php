<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tgl_1 = '';
if (isset($_SESSION['kliniksearchpasienperiksa_tgl_1']))
    $tgl_1 = $_SESSION['kliniksearchpasienperiksa_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['kliniksearchpasienperiksa_tgl_1']))
    $tgl_2 = $_SESSION['kliniksearchpasienperiksa_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['kliniksearchpasienperiksa_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['kliniksearchpasienperiksa_tgl_2'] = $_GET['tgl_2'];
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
			<td>&nbsp;</td>
			<td>&nbsp;</td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/></td>
			<td><input type="submit" value="cari" class="myButton" />&nbsp;
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>
			<td>&nbsp;</td>		
			<td align="right" colspan="2">&nbsp;</td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$connect = mysql_connect($hostname_4, $username_4, $password_4) or die(mysql_error());
mysql_select_db($database_4, $connect) or die(mysql_error());	

$qry_survey = 'SELECT ID_SURVEY,DATE_FORMAT(TANGGAL,"%d-%m-%Y") AS TANGGAL,JNS_KELAMIN,UMUR,PEMBIAYAAN,POLIKLINIK_RUANG,
	SURVEY_1,SURVEY_2,SURVEY_3,SURVEY_4,SURVEY_5,SURVEY_6,SURVEY_7,SURVEY_8,SURVEY_9,SURVEY_10,UNIQ_STR
	FROM t_survey_kepuasan
	WHERE DATE(TANGGAL) >= ' . $tgl_filter_1 . '
	AND DATE(TANGGAL) <= ' . $tgl_filter_2 . '
	ORDER BY ID_SURVEY';
	
$extparam = '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2;
include('ipaap/ipaap_list_survey_kepuasan_masyarakat.php');
?>