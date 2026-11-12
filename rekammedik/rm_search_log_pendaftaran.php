<?php
$tgl_1 = '';
if (isset($_SESSION['rmlogpendaftaran_tgl_1']))
    $tgl_1 = $_SESSION['rmlogpendaftaran_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['rmlogpendaftaran_tgl_1']))
    $tgl_2 = $_SESSION['rmlogpendaftaran_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['rmlogpendaftaran_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['rmlogpendaftaran_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['rmlogpendaftaran_searchkey']))
		$searchkey = $_SESSION['rmlogpendaftaran_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['rmlogpendaftaran_searchkey'] = $searchkey;
}
$pegawai_id = '';
if (isset($_SESSION['rmlogpendaftaran_pegawai_id']))
		$pegawai_id = $_SESSION['rmlogpendaftaran_pegawai_id'];

if (isset($_GET['pegawai_id'])) {
    $pegawai_id = $_GET['pegawai_id'];
	$_SESSION['rmlogpendaftaran_pegawai_id'] = $pegawai_id;
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
			<td>Petugas</td>
			<td colspan="3"><select name="pegawai_id" id="pegawai_id" class="text_dt" style="width:298px;" >
				<option value=""> - </option>
				<?php
				$sql_petugas = 'SELECT DISTINCT m_pegawai.NAMA_PEGAWAI
						FROM m_app_user
						INNER JOIN m_pegawai ON (m_app_user.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
						WHERE m_app_user.MODUL_ID = 1 AND m_pegawai.NAMA_PEGAWAI NOT LIKE "%asepkurniawan%"
						ORDER BY m_pegawai.NAMA_PEGAWAI';
				$get_petugas = mysql_query($sql_petugas) or die(mysql_error());
				while($dat_petugas = mysql_fetch_array($get_petugas)){
				?>
				<option value="<?php echo $dat_petugas['NAMA_PEGAWAI']; ?>" <?php if($dat_petugas['NAMA_PEGAWAI'] == $pegawai_id) echo 'selected="selected"'; ?> ><?php echo $dat_petugas['NAMA_PEGAWAI']; ?></option>
				<?php
				}	
				?>
			  </select></td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/>            </td>	
			<td>Nomor MR/ Nama Pasien</td>
            <td colspan="2"><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt"/></td>
            <td align="right"><input name="submit" type="submit" class="myButton" value="cari" />
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_kunjungan = 'SELECT * FROM (SELECT t_irja.IRJA_ID AS LOG_ID, t_irja.NOMR, t_irja.TANGGAL_DAFTAR,
	m_pasien.NAMA_PASIEN,t_irja.USER_PENDAFTARAN,t_irja.ST_BATAL,
	CASE WHEN t_irja.UNIT_ID = 9 THEN "IGD" ELSE CONCAT("Rawat Jalan", " (",m_unit.NAMA_UNIT,")") END AS NAMA_PELAYANAN,
	t_irja.KETERANGAN_BATAL
	FROM t_irja
	INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR) 
	LEFT JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
	WHERE t_irja.NO_PENDAFTARAN IS NOT NULL
	AND t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
	UNION	
	SELECT t_irna.IRNA_ID AS LOG_ID, t_irna.NOMR, t_irna.TANGGAL_DAFTAR,
	m_pasien.NAMA_PASIEN,t_irna.USER_PENDAFTARAN,t_irna.ST_BATAL,CONCAT("Rawat Inap", " (",m_ruang.NAMA_RUANG,")") AS NAMA_PELAYANAN,
	t_irna.KETERANGAN_BATAL
	FROM t_irna
	INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR) 
	LEFT JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
	WHERE t_irna.NO_PENDAFTARAN IS NOT NULL
	AND t_irna.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND t_irna.TANGGAL_DAFTAR <= ' . $tgl_filter_2 .'
	) t_log WHERE 1';
	
if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_kunjungan = $qry_kunjungan . ' AND CONCAT(NOMR,NAMA_PASIEN) LIKE "%' . $searchkey . '%"';
}	
if (!empty($pegawai_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND USER_PENDAFTARAN LIKE "%' . $pegawai_id . '"';
}

$qry_kunjungan = $qry_kunjungan . ' ORDER BY TANGGAL_DAFTAR,NAMA_PASIEN';

$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&pegawai_id=' . $pegawai_id;
$action = '<a href="index.php?link=' . md5('') . '&idx=###" >detail</a>';
include('rekammedik/rm_list_log_pendaftaran.php');
?>
