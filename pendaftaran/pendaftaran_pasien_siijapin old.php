<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tgl_1 = '';
if (isset($_SESSION['rmsearch_siijapin_tgl_1']))
    $tgl_1 = $_SESSION['rmsearch_siijapin_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['rmsearch_siijapin_tgl_1']))
    $tgl_2 = $_SESSION['rmsearch_siijapin_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['rmsearch_siijapin_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['rmsearch_siijapin_tgl_2'] = $_GET['tgl_2'];
}

$unit_id = '';
if (isset($_SESSION['rmsearch_siijapin_unit_id']))
		$unit_id = $_SESSION['rmsearch_siijapin_unit_id'];

if (isset($_GET['unit_id'])) {
    $unit_id = $_GET['unit_id'];
	$_SESSION['rmsearch_siijapin_unit_id'] = $unit_id;
}
$jaminan_id = '';
if (isset($_SESSION['rmsearch_siijapin_jaminan_id']))
		$jaminan_id = $_SESSION['rmsearch_siijapin_jaminan_id'];

if (isset($_GET['jaminan_id'])) {
    $jaminan_id = $_GET['jaminan_id'];
	$_SESSION['rmsearch_siijapin_jaminan_id'] = $jaminan_id;
}

$nama_pasien = '';
if (isset($_SESSION['rmsearch_siijapin_nama_pasien']))
		$nama_pasien = $_SESSION['rmsearch_siijapin_nama_pasien'];

if (isset($_GET['nama_pasien'])) {
    $nama_pasien = $_GET['nama_pasien'];
	$_SESSION['rmsearch_siijapin_nama_pasien'] = $nama_pasien;
}

$verifikasi = '';
if (isset($_SESSION['rmsearch_siijapin_verifikasi']))
	$verifikasi = $_SESSION['rmsearch_siijapin_verifikasi'];

if (isset($_GET['verifikasi'])) {
    $verifikasi = $_GET['verifikasi'];
	$_SESSION['rmsearch_siijapin_verifikasi'] = $verifikasi;
}

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}

$arr_unit = array();
$arr_unit[0] = '-';
$get_unit = mysql_query('SELECT * FROM m_unit') or die(mysql_error());
while($dat_unit = mysql_fetch_array($get_unit)){
		$arr_unit[$dat_unit['UNIT_ID']] = $dat_unit['NAMA_UNIT'];
}

$arr_jaminan = array();
$arr_jaminan[0] = '-';
$get_jaminan = mysql_query('SELECT * FROM m_jaminan') or die(mysql_error());
while($dat_jaminan = mysql_fetch_array($get_jaminan)){
		$arr_jaminan[$dat_jaminan['JAMINAN_ID']] = $dat_jaminan['NAMA_JAMINAN'];
}

$arr_dokter = array();
$get_dokter = mysql_query('SELECT * FROM m_pegawai WHERE TIPE_PEGAWAI_ID IN (1,2,3,4,18)') or die(mysql_error());
$arr_dokter[0] = '-';
while($dat_dokter = mysql_fetch_array($get_dokter)){
		$arr_dokter[$dat_dokter['PEGAWAI_ID']] = $dat_dokter['NAMA_PEGAWAI'];
}

$arr_mcu = array();
$get_mcu = mysql_query('SELECT TARIF_ID,NAMA_TARIF FROM m_tarif WHERE KODE_TARIF_GROUP = "120"') or die(mysql_error());
$arr_mcu[0] = '-';
while($dat_mcu = mysql_fetch_array($get_mcu)){
		$arr_mcu[$dat_mcu['TARIF_ID']] = $dat_mcu['NAMA_TARIF'];
}
?>
<form name="search" method="get" action="index.php">
    <table class="tableform" border="0" >
        <tr>
            <td>Tanggal</td>
            <td><input type="text" name="tgl_1" id="tgl_1" value="<?php echo $tgl_1; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
			<td>Jenis Pembayaran</td>
			<td> <select name="jaminan_id" id="jaminan_id" class="text_dt" style="width:228px;">
                    <option value=""> - </option>
                    <?php echo getJnsBayar($jaminan_id,''); ?>
                </select></td>	
            <td colspan="3">
				<?php if(currentModul() == 'ipapp'){ ?>
					<select name="verifikasi" id="verifikasi" class="text_dt" style="width:228px;">
						<option value=""> - </option>
						<option value="1" <?php if($verifikasi == '1') echo 'selected="selected"'; ?>>Sudah Verifikasi</option>
						<option value="2" <?php if($verifikasi == '2') echo 'selected="selected"'; ?>>Belum Verifikasi</option>
					</select>
				<?php } ?>
			</td>
			<td>Nomr/ Nama Pasien</td>
			<td><input type="text" name="nama_pasien" id="nama_pasien" value="<?php echo $nama_pasien; ?>" style="width:228px;" class="text_dt" /></td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/>            </td>	
			<td>Klinik</td>
			<td><select name="unit_id" id="unit_id" class="text_dt" style="width:228px;">
			<option value=""> - </option>
			<?php echo getUnit('irja',$unit_id); ?>
            </select></td>	
			<td></td>
			<td></td>
            <td align="right" colspan="3"><input name="submit" type="submit" class="myButton" value="cari" />
			<!--<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" />-->
			</td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$connect = mysql_connect($hostname_8, $username_8, $password_8) or die(mysql_error());
mysql_select_db($database_8, $connect) or die(mysql_error());	
$qry_kunjungan = 'SELECT * FROM (
	SELECT "1" AS DAFTAR,d.DAFTAR_ID,d.CUSTOMER_ID,d.MEMBER_ID,
	m.NOMR,m.NAMA_PASIEN,m.TMP_LAHIR,
	DATE_FORMAT(m.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,
	m.AGAMA,m.JNS_KELAMIN,m.NAMA_IBU,m.ALAMAT,m.RD_NOMR,
	m.NO_CONTACT,m.EMAIL,
	DATE_FORMAT(d.TGL_RENCANA_KUNJUNGAN,"%d-%m-%Y") AS TGL_RENCANA_KUNJUNGAN,
	61 AS KLINIK_ID,d.MCU_ID,d.DOKTER AS DOKTER_ID,
	"1" CARA_BAYAR,d.JAM_LAYANAN,d.NO_ANTRIAN,d.ST_BAYAR,
	DATE_FORMAT(d.TGL_DAFTAR,"%d-%m-%Y") AS TGL_DAFTAR,
	d.USER_VERIFIKASI,"" AS USER_KASIR_VERIFIKASI
	FROM t_daftar_mcu d
	INNER JOIN m_customer c
	ON (d.CUSTOMER_ID = c.CUSTOMER_ID)
	INNER JOIN m_customer_member m
	ON (d.MEMBER_ID = m.MEMBER_ID)
	WHERE DATE(d.TGL_RENCANA_KUNJUNGAN) >= ' . $tgl_filter_1 . ' 
	AND DATE(d.TGL_RENCANA_KUNJUNGAN) <= ' . $tgl_filter_2 . '
	UNION ALL
	SELECT "2" AS DAFTAR,d.DAFTAR_ID,d.CUSTOMER_ID,d.MEMBER_ID,
	m.NOMR,m.NAMA_PASIEN,m.TMP_LAHIR,
	DATE_FORMAT(m.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,
	m.AGAMA,m.JNS_KELAMIN,m.NAMA_IBU,m.ALAMAT,m.RD_NOMR,
	m.NO_CONTACT,m.EMAIL,
	DATE_FORMAT(d.TGL_RENCANA_KUNJUNGAN,"%d-%m-%Y") AS TGL_RENCANA_KUNJUNGAN,
	UNIT AS KLINIK_ID,"" AS MCU_ID,d.DOKTER AS DOKTER_ID,
	d.PEMBAYARAN AS CARA_BAYAR,d.JAM_LAYANAN,d.NO_ANTRIAN,d.ST_BAYAR,
	DATE_FORMAT(d.TGL_DAFTAR,"%d-%m-%Y") AS TGL_DAFTAR,
	d.USER_VERIFIKASI,d.USER_KASIR_VERIFIKASI
	FROM t_daftar_rj d
	INNER JOIN m_customer c
	ON (d.CUSTOMER_ID = c.CUSTOMER_ID)
	INNER JOIN m_customer_member m
	ON (d.MEMBER_ID = m.MEMBER_ID)
	WHERE DATE(d.TGL_RENCANA_KUNJUNGAN) >= ' . $tgl_filter_1 . ' 
	AND DATE(d.TGL_RENCANA_KUNJUNGAN) <= ' . $tgl_filter_2 . '
	) t_daftar WHERE 1 ';
	
if (!empty($unit_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_daftar.KLINIK_ID = "' . $unit_id . '"';
}
if (!empty($jaminan_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_daftar.CARA_BAYAR = "' . $jaminan_id . '"';
}
if (!empty($nama_pasien)) {
    $qry_kunjungan = $qry_kunjungan . ' AND (t_daftar.NAMA_PASIEN LIKE "%' . $nama_pasien . '%" OR t_daftar.NOMR = "%' . $nama_pasien . '%")';
}
$qry_kunjungan = $qry_kunjungan . ' ORDER BY t_daftar.NAMA_PASIEN';

$extparam = '&verifikasi=' . $verifikasi . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&unit_id=' . $unit_id . '&jaminan_id=' . $jaminan_id;
$action = '<a href="index.php?link=' . md5('pendaftaranviewdaftar') . '&idx=###" >detail</a>';
include('pendaftaran/pendaftaran_list_pasien_siijapin.php');
?>