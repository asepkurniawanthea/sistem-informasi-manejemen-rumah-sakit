<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tgl_1 = '';
if (isset($_SESSION['kliniksearchpermintaangizi_tgl_1']))
    $tgl_1 = $_SESSION['kliniksearchpermintaangizi_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['kliniksearchpermintaangizi_tgl_1']))
    $tgl_2 = $_SESSION['kliniksearchpermintaangizi_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['kliniksearchpermintaangizi_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['kliniksearchpermintaangizi_tgl_2'] = $_GET['tgl_2'];
}

$nomr = '';
if (isset($_SESSION['kliniksearchpermintaangizi_nomr']))
		$nomr = $_SESSION['kliniksearchpermintaangizi_nomr'];

if (isset($_GET['nomr'])) {
    $nomr = $_GET['nomr'];
	$_SESSION['kliniksearchpermintaangizi_nomr'] = $nomr;
}

$jam = '';
if (isset($_SESSION['kliniksearchpermintaangizi_jam']))
		$jam = $_SESSION['kliniksearchpermintaangizi_jam'];

if (isset($_GET['jam'])) {
    $jam = $_GET['jam'];
	$_SESSION['kliniksearchpermintaangizi_jam'] = $jam;
}
$menit = '';
if (isset($_SESSION['kliniksearchpermintaangizi_menit']))
		$menit = $_SESSION['kliniksearchpermintaangizi_menit'];

if (isset($_GET['menit'])) {
    $menit = $_GET['menit'];
	$_SESSION['kliniksearchpermintaangizi_menit'] = $menit;
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
			<td><input type="text" name="nomr" class="text_dt" value="<?php echo $nomr; ?>"/></td>
			<td>&nbsp;</td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/></td>
			<td>Jam Makan</td>
			<td><select name="jam" id="jam_makan" style="width:50px;" class="text_dt" >
			<option value=""> - </option>
			<?php echo getJam($jam); ?>
			</select>
			:
			<select name="menit" id="menit_makan" style="width:50px;" class="text_dt" >
			<option value=""> - </option>
			<?php echo getMenit($menit); ?>
			</select></td>
			<td><input type="submit" value="cari" class="myButton" />
			<a href="index.php?link=<?php echo md5('klinikformpermintaanmakan'); ?>"><input type="button" value="permintaan baru" class="myButton" /></a></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_menugizi = 'SELECT t_makan.GIZI_PERMINTAAN_ID, 
				DATE_FORMAT(t_makan.TANGGAL_PERMINTAAN,"%d-%m-%Y") AS TANGGAL_PERMINTAAN,
				t_irja.IRJA_ID,t_irja.NOMR,m_pasien.NAMA_PASIEN,
				m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,
				t_makan.DIAGNOSA,
				t_makan.ALERGI,
				t_makan.DIET,
				t_makan.VEGETARIAN,
				t_makan.PUASA,
				t_makan.JENIS_MAKAN,
				t_makan.WAKTU_MAKAN,
				t_makan.USER_UNIT
				FROM db_simrs.t_irja
				INNER JOIN db_simrs.m_pasien ON (t_irja.NOMR = m_pasien.NOMR) 
				LEFT JOIN db_inventorirs.t_gizi_permintaan_makan_rajal t_makan ON (t_irja.IRJA_ID = t_makan.RAJAL_ID)
				WHERE t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL	
				AND t_irja.PASIEN_KELUAR IS NULL 
				AND t_irja.UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '"
				AND t_makan.NO_PERMINTAAN IS NOT NULL
				AND t_makan.TANGGAL_PERMINTAAN >= ' . $tgl_filter_1 . '
				AND t_makan.TANGGAL_PERMINTAAN <= ' . $tgl_filter_2 . '
				' . (($jam != '' and $menit != '') ? 'AND t_makan.WAKTU_MAKAN = "' . $jam . ':' . $menit . '"' : '') . '
				' . (($nomr != '') ? 'AND t_irja.NOMR = "' . $nomr . '"' : '') . '
				ORDER BY t_makan.TANGGAL_PERMINTAAN,t_makan.WAKTU_MAKAN,m_pasien.NAMA_PASIEN';

$extparam = '&nomr=' . $nomr . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2;
include('klinik/klinik_list_permintaan_makan.php');
?>
