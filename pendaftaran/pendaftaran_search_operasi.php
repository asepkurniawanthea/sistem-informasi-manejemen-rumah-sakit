<?php
$tgl_1 = '';
if (isset($_SESSION['operasisearchorder_tgl_1']))
    $tgl_1 = $_SESSION['operasisearchorder_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['operasisearchorder_tgl_1']))
    $tgl_2 = $_SESSION['operasisearchorder_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['operasisearchorder_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['operasisearchorder_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['operasisearchorder_searchkey']))
		$searchkey = $_SESSION['operasisearchorder_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['operasisearchorder_searchkey'] = $searchkey;
}

$unit_id = '';
if (isset($_SESSION['operasisearchorder_unit_id']))
		$unit_id = $_SESSION['operasisearchorder_unit_id'];

if (isset($_GET['unit_id'])) {
    $unit_id = $_GET['unit_id'];
	$_SESSION['operasisearchorder_unit_id'] = $unit_id;
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
			<td>Poliklinik</td>
			<td> <select name="unit_id" id="unit_id" class="text_dt" style="width:228px;">
                    <option value=""> - </option>
                    <?php echo getUnit('umumkusta',$unit_id); ?>
                </select></td>	
			<td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/>
            </td>	
			<td>Nomor MR/ Nama Pasien</td>
			<td><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt" style="width:200px;"/></td>	
			<td colspan="2" align="right"><input type="submit" value="cari" class="myButton" />
			</td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
 $qry_kunjungan = 'SELECT t_operasi.OPERASI_ID,t_operasi.NO_ORDER,
				DATE_FORMAT(t_operasi.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_ORDER,
				DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y") AS TANGGAL_OPERASI,
				m_pasien.NAMA_PASIEN,t_operasi.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				m_pasien.JNS_KELAMIN,m_jaminan.NAMA_JAMINAN,
				m_unit.NAMA_UNIT,t_operasi.RAWAT_ID,
				m_pegawai.NAMA_PEGAWAI,t_operasi.JNS_ORDER,t_operasi.UNIT_ID,
				t_operasi.TANGGAL_ORDER AS F_ORDER,
				t_operasi.ST_APPROVE,t_operasi.ST_OPERASI,
				m_pegawai2.NAMA_PEGAWAI AS DOKTER_OPERASI,
				t_operasi.USER_ORDER
				FROM t_operasi
				INNER JOIN t_irja ON (t_operasi.RAWAT_ID = t_irja.IRJA_ID)
				INNER JOIN m_pasien ON (t_operasi.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_operasi.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				LEFT JOIN m_pegawai ON (t_operasi.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_operasi.PEGAWAI_PELAKSANA_ID = m_pegawai2.PEGAWAI_ID)
				WHERE t_operasi.JNS_ORDER = "IRJ"
				AND t_operasi.NO_ORDER IS NOT NULL
				AND t_operasi.NO_PENDAFTARAN IS NULL
				AND t_operasi.ST_APPROVE = "1"
				AND STR_TO_DATE(DATE_FORMAT(t_operasi.TANGGAL_ORDER,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(t_operasi.TANGGAL_ORDER,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2;
	
if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_kunjungan = $qry_kunjungan . ' AND CONCAT(m_pasien.NOMR,m_pasien.NAMA_PASIEN) LIKE "%' . $searchkey . '%"';
}	
if (!empty($unit_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_operasi.UNIT_ID = "' . $unit_id . '"';
}

$qry_kunjungan = $qry_kunjungan . ' ORDER BY m_pasien.NAMA_PASIEN';

$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&unit_id=' . $unit_id;
$action = '<a href="index.php?link=' . md5('pendaftaranformdaftaroperasi') . '&idx=###" >daftar</a>';
include('pendaftaran/pendaftaran_list_operasi.php');
?>
