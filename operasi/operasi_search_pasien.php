<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tgl_1 = '';
if (isset($_SESSION['operasisearchpasienperiksa_tgl_1']))
    $tgl_1 = $_SESSION['operasisearchpasienperiksa_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['operasisearchpasienperiksa_tgl_1']))
    $tgl_2 = $_SESSION['operasisearchpasienperiksa_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['operasisearchpasienperiksa_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['operasisearchpasienperiksa_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['operasisearchpasienperiksa_searchkey']))
		$searchkey = $_SESSION['operasisearchpasienperiksa_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['operasisearchpasienperiksa_searchkey'] = $searchkey;
}
$jaminan_id = '';
if (isset($_SESSION['operasisearchpasienperiksa_jaminan_id']))
		$jaminan_id = $_SESSION['operasisearchpasienperiksa_jaminan_id'];

if (isset($_GET['jaminan_id'])) {
    $jaminan_id = $_GET['jaminan_id'];
	$_SESSION['operasisearchpasienperiksa_jaminan_id'] = $jaminan_id;
}

$ruang_id = '';
if (isset($_SESSION['operasisearchpasienperiksa_ruang_id']))
		$ruang_id = $_SESSION['operasisearchpasienperiksa_ruang_id'];

if (isset($_GET['ruang_id'])) {
    $ruang_id = $_GET['ruang_id'];
	$_SESSION['operasisearchpasienperiksa_ruang_id'] = $ruang_id;
}

$unit_id = '';
if (isset($_SESSION['operasisearchpasienperiksa_unit_id']))
		$unit_id = $_SESSION['operasisearchpasienperiksa_unit_id'];

if (isset($_GET['unit_id'])) {
    $unit_id = $_GET['unit_id'];
	$_SESSION['operasisearchpasienperiksa_unit_id'] = $unit_id;
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
			<td>Nomor MR/ Nama Pasien</td>
            <td><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt"/></td>	
			<td>Ruang</td>
			<td><select name="ruang_id" id="ruang_id" class="text_dt" style="width:228px;">
			<option value=""> - </option>
			<?php echo getRuangRawat($ruang_id); ?>
            </select></td>
			<td>&nbsp;</td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/></td>
			<td>Jenis Pembayaran</td>
			<td> <select name="jaminan_id" id="jaminan_id" class="text_dt" style="width:150px;">
                    <option value=""> - </option>
                    <?php echo getJnsBayar($jaminan_id,''); ?>
                </select></td>	
			<td>Poliklinik</td>
			<td><select name="unit_id" id="unit_id" class="text_dt" style="width:228px;">
			<option value=""> - </option>
			<?php echo getUnit('umumigd',$unit_id); ?>
            </select></td>	
			<td><input type="submit" value="cari" class="myButton" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_kunjungan = 'SELECT DISTINCT * FROM (SELECT t_operasi.OPERASI_ID,t_operasi.NO_ORDER,
				DATE_FORMAT(t_operasi.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_ORDER,
				DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y") AS TANGGAL_OPERASI,
				DATE_FORMAT(t_operasi.JAM_OPERASI,"%H:%i") AS JAM_OPERASI,
				m_pasien.NAMA_PASIEN,t_operasi.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				m_unit.NAMA_UNIT,t_operasi.RAWAT_ID,
				m_pegawai.NAMA_PEGAWAI,t_operasi.JNS_ORDER,t_operasi.UNIT_ID,
				t_operasi.TANGGAL_OPERASI AS F_ORDER,
				t_operasi.JAM_OPERASI AS J_ORDER,
				t_operasi.ST_APPROVE,t_operasi.ST_OPERASI,
				m_pegawai2.NAMA_PEGAWAI AS DOKTER_OPERASI,
				t_operasi.USER_OPERASI,m_pasien.JNS_KELAMIN,
				m_jaminan.NAMA_JAMINAN,t_operasi.NO_OPERASI,
				(CASE WHEN t_operasi.ST_MASUK = "2" THEN (
					SELECT CONCAT(m_ruang.NAMA_RUANG," Kelas",m_ruang.KELAS_RAWAT)
					FROM t_irna 
					INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
					WHERE t_irna.IRNA_ID = t_operasi.RAWAT_ID
					)
					WHEN t_operasi.ST_MASUK = "1" THEN m_unit.NAMA_UNIT 
				END) AS STATUS_PASIEN,t_operasi.ST_MASUK
				FROM t_operasi
				INNER JOIN t_irja ON (t_operasi.RAWAT_ID = t_irja.IRJA_ID)
				INNER JOIN m_pasien ON (t_operasi.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_operasi.UNIT_ID = m_unit.UNIT_ID)
				LEFT JOIN m_pegawai ON (t_operasi.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_operasi.PEGAWAI_PELAKSANA_ID = m_pegawai2.PEGAWAI_ID)
				LEFT JOIN m_jaminan ON (t_operasi.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_operasi.ST_APPROVE = "1" 
				AND t_operasi.JNS_ORDER = "IRJ"
				AND t_operasi.NO_PENDAFTARAN IS NOT NULL
				AND STR_TO_DATE(DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				UNION
				SELECT t_operasi.OPERASI_ID,t_operasi.NO_ORDER,
				DATE_FORMAT(t_operasi.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_ORDER,
				DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y") AS TANGGAL_OPERASI,
				DATE_FORMAT(t_operasi.JAM_OPERASI,"%H:%i") AS JAM_OPERASI,
				m_pasien.NAMA_PASIEN,t_operasi.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_ruang.NAMA_RUANG," Kelas",m_ruang.KELAS_RAWAT) AS NAMA_UNIT,
				t_operasi.RAWAT_ID,
				m_pegawai.NAMA_PEGAWAI,t_operasi.JNS_ORDER,t_operasi.RUANG_ID AS UNIT_ID,
				t_operasi.TANGGAL_OPERASI AS F_ORDER,
				t_operasi.JAM_OPERASI AS J_ORDER,
				t_operasi.ST_APPROVE,t_operasi.ST_OPERASI,
				m_pegawai2.NAMA_PEGAWAI AS DOKTER_OPERASI,
				t_operasi.USER_OPERASI,m_pasien.JNS_KELAMIN,
				m_jaminan.NAMA_JAMINAN,t_operasi.NO_OPERASI,
				CONCAT(m_ruang2.NAMA_RUANG," Kelas",m_ruang2.KELAS_RAWAT) AS STATUS_PASIEN,
				t_operasi.ST_MASUK
				FROM t_operasi
				INNER JOIN t_irna ON (t_operasi.RAWAT_ID = t_irna.IRNA_ID)
				INNER JOIN m_pasien ON (t_operasi.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_operasi.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_ruang m_ruang2 ON (t_irna.RUANG_ID = m_ruang2.RUANG_ID)
				LEFT JOIN m_pegawai ON (t_operasi.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_operasi.PEGAWAI_PELAKSANA_ID = m_pegawai2.PEGAWAI_ID)
				LEFT JOIN m_jaminan ON (t_operasi.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_operasi.ST_APPROVE = "1"  
				AND t_operasi.JNS_ORDER = "IRN"
				AND t_operasi.NO_PENDAFTARAN IS NOT NULL
				AND STR_TO_DATE(DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				UNION
				SELECT t_operasi.OPERASI_ID,t_operasi.NO_ORDER,
				DATE_FORMAT(t_operasi.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_ORDER,
				DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y") AS TANGGAL_OPERASI,
				DATE_FORMAT(t_operasi.JAM_OPERASI,"%H:%i") AS JAM_OPERASI,
				t_operasi.NAMA_PASIEN,t_operasi.NO_PASIEN_OPERASI AS NOMR,t_operasi.TGL_LAHIR,t_operasi.ALAMAT,
				t_operasi.INSTANSI_PENGIRIM AS NAMA_UNIT,"" AS RAWAT_ID,
				t_operasi.PENGIRIM AS NAMA_PEGAWAI,t_operasi.JNS_ORDER,"" AS UNIT_ID,
				t_operasi.TANGGAL_OPERASI AS F_ORDER,
				t_operasi.JAM_OPERASI AS J_ORDER,
				t_operasi.ST_APPROVE,t_operasi.ST_OPERASI,
				m_pegawai.NAMA_PEGAWAI AS DOKTER_OPERASI,
				t_operasi.USER_OPERASI,t_operasi.JNS_KELAMIN,
				m_jaminan.NAMA_JAMINAN,t_operasi.NO_OPERASI,
				"APS" AS STATUS_PASIEN,t_operasi.ST_MASUK
				FROM t_operasi
				LEFT JOIN m_pegawai ON (t_operasi.PEGAWAI_PELAKSANA_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_jaminan ON (t_operasi.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_operasi.ST_APPROVE = "1"  
				AND t_operasi.JNS_ORDER = "APS"
				AND t_operasi.NO_PENDAFTARAN IS NOT NULL
				AND STR_TO_DATE(DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				) t_order WHERE 1';
	
if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_kunjungan = $qry_kunjungan . ' AND CONCAT(t_order.NOMR,t_order.NAMA_PASIEN) LIKE "%' . $searchkey . '%"';
}	
if (!empty($ruang_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_order.UNIT_ID = "' . $ruang_id . '" AND t_order.JNS_ORDER = "IRN"';
}
if (!empty($unit_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_order.UNIT_ID = "' . $unit_id . '" AND t_order.JNS_ORDER = "IRJ"';
}

$qry_kunjungan = $qry_kunjungan . ' ORDER BY F_ORDER, J_ORDER';

$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&jaminan_id=' . $jaminan_id . '&ruang_id=' . $ruang_id;;
include('operasi/operasi_list_pasien.php');
?>
