<?php
$tgl_1 = '';
if (isset($_SESSION['pembayaransearchbayar_tgl_1']))
    $tgl_1 = $_SESSION['pembayaransearchbayar_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['pembayaransearchbayar_tgl_1']))
    $tgl_2 = $_SESSION['pembayaransearchbayar_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['pembayaransearchbayar_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['pembayaransearchbayar_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['pembayaransearchbayar_searchkey']))
		$searchkey = $_SESSION['pembayaransearchbayar_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['pembayaransearchbayar_searchkey'] = $searchkey;
}
$unit_id = '';
if (isset($_SESSION['pembayaransearchbayar_unit_id']))
		$unit_id = $_SESSION['pembayaransearchbayar_unit_id'];

if (isset($_GET['unit_id'])) {
    $unit_id = $_GET['unit_id'];
	$_SESSION['pembayaransearchbayar_unit_id'] = $unit_id;
}
$ruang_id = '';
if (isset($_SESSION['pembayaransearchbayar_ruang_id']))
		$ruang_id = $_SESSION['pembayaransearchbayar_ruang_id'];

if (isset($_GET['ruang_id'])) {
    $ruang_id = $_GET['ruang_id'];
	$_SESSION['pembayaransearchbayar_ruang_id'] = $ruang_id;
}
$jaminan_id = '';
if (isset($_SESSION['pembayaransearchbayar_jaminan_id']))
		$jaminan_id = $_SESSION['pembayaransearchbayar_jaminan_id'];

if (isset($_GET['jaminan_id'])) {
    $jaminan_id = $_GET['jaminan_id'];
	$_SESSION['pembayaransearchbayar_jaminan_id'] = $jaminan_id;
}

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}	

$kasir = 'umum';
if(isset($_GET['kasir'])){
$kasir = $_GET['kasir'];
	if($kasir == 'igd') $unit_id = '9';
	if($kasir == 'kusta') $unit_id = '35';
}	
?>
<form name="search" method="get" action="index.php">
    <table class="tableform" border="0" >
        <tr>
            <td>Tanggal</td>
            <td><input type="text" name="tgl_1" id="tgl_1" value="<?php echo $tgl_1; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
			<td>Klinik</td>
			<td> 
			<select name="unit_id" id="unit_id" class="text_dt" style="width:228px;">
			<option value=""> - </option>
			<?php echo getUnit('umumigd',$unit_id); ?>
            </select></td>	
			<td>Jenis Pembayaran</td>
            <td><select name="jaminan_id" id="jaminan_id" class="text_dt" style="width:228px;">
                    <option value=""> - </option>
                    <?php echo getJnsBayar($jaminan_id,''); ?>
                </select></td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/>
            </td>	
			<td>Ruang</td>
			<td><select name="ruang_id" id="ruang_id" class="text_dt" style="width:228px;">
			<option value=""> - </option>
			<?php echo getRuangRawat($ruang_id); ?>
            </select></td>	
			<td>Nomor MR/ Nama Pasien</td>
            <td><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt"/>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="cari" class="myButton" />
			</td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_kunjungan = 'SELECT * FROM (SELECT t_irja.IRJA_ID, t_irja.NOMR, t_irja.TANGGAL_DAFTAR,
				m_unit.NAMA_UNIT,m_jaminan.NAMA_JAMINAN,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,
				m_pasien.ALAMAT,t_irja.ST_BARU,t_irja.ST_RUJUKAN,
				SUM(CASE WHEN t_ambulance_tarif.NO_PEMBAYARAN IS NULL THEN 1 ELSE 0 END) AS STATUS_PEMBAYARAN,
				t_irja.UNIT_ID,"" AS RUANG_ID,
				t_irja.JENIS_BAYAR_ID AS JENIS_BAYAR_ID,
				"irj" AS JNS_ORDER
				FROM t_irja
				INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR) 
				LEFT JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				LEFT JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				LEFT JOIN t_ambulance_tarif ON (t_irja.IRJA_ID = t_ambulance_tarif.RAWAT_ID 
					AND t_ambulance_tarif.JNS_ORDER = "IRJ" AND t_ambulance_tarif.NO_TARIF IS NOT NULL)
				WHERE t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL
				AND t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
				GROUP BY t_irja.IRJA_ID, t_irja.NOMR, t_irja.TANGGAL_DAFTAR,
				m_unit.NAMA_UNIT,m_jaminan.NAMA_JAMINAN,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,
				m_pasien.ALAMAT 
				UNION ALL
				SELECT t_irna.IRNA_ID AS IRJA_ID, t_irna.NOMR, t_irna.TANGGAL_DAFTAR,
				CONCAT(m_ruang.NAMA_RUANG," ",t_irna.KELAS_RAWAT) AS NAMA_UNIT,m_jaminan.NAMA_JAMINAN,m_pasien.NAMA_PASIEN,
				m_pasien.TGL_LAHIR,m_pasien.ALAMAT,"" AS ST_BARU, "" AS ST_RUJUKAN,
				SUM(CASE WHEN t_ambulance_tarif.NO_PEMBAYARAN IS NULL THEN 1 ELSE 0 END) AS STATUS_PEMBAYARAN,
				"" AS UNIT_ID,t_irna.RUANG_ID,
				t_irna.JENIS_BAYAR_ID,
				"irn" AS JNS_ORDER
				FROM t_irna
				INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR) 
				LEFT JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				LEFT JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				LEFT JOIN t_ambulance_tarif ON (t_irna.IRNA_ID = t_ambulance_tarif.RAWAT_ID 
					AND t_ambulance_tarif.JNS_ORDER = "IRN" IS NOT NULL AND t_ambulance_tarif.NO_TARIF IS NOT NULL)
				WHERE t_irna.NO_PENDAFTARAN IS NOT NULL AND t_irna.ST_BATAL IS NULL 
				AND t_irna.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND t_irna.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
				GROUP BY t_irna.NOMR, t_irna.TANGGAL_DAFTAR,
				t_irna.NO_PENDAFTARAN
				) t_daftar 
				WHERE 1';
	
if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_kunjungan = $qry_kunjungan . ' AND CONCAT(t_daftar.NOMR,t_daftar.NAMA_PASIEN) LIKE "%' . $searchkey . '%"';
}	
if (!empty($unit_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_daftar.UNIT_ID = "' . $unit_id . '"';
}
if (!empty($ruang_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_daftar.RUANG_ID = "' . $ruang_id . '"';
}
if (!empty($jaminan_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_daftar.JENIS_BAYAR_ID = "' . $jaminan_id . '"';
}

$qry_kunjungan = $qry_kunjungan . ' ORDER BY t_daftar.NAMA_PASIEN,t_daftar.NOMR';
			
$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&unit_id=' . $unit_id . '&jaminan_id=' . $jaminan_id . '&kasir=' . $kasir;
include('pembayaran/pembayaran_list_bayar_ambulance.php');
?>
