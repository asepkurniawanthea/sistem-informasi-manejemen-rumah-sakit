<?php
$tgl_1 = '';
if (isset($_SESSION['penunjangsearchorder_tgl_1']))
    $tgl_1 = $_SESSION['penunjangsearchorder_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['penunjangsearchorder_tgl_1']))
    $tgl_2 = $_SESSION['penunjangsearchorder_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['penunjangsearchorder_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['penunjangsearchorder_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['penunjangsearchorder_searchkey']))
		$searchkey = $_SESSION['penunjangsearchorder_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['penunjangsearchorder_searchkey'] = $searchkey;
}
$ruang_id = '';
if (isset($_SESSION['penunjangsearchorder_ruang_id']))
		$ruang_id = $_SESSION['penunjangsearchorder_ruang_id'];

if (isset($_GET['ruang_id'])) {
    $ruang_id = $_GET['ruang_id'];
	$_SESSION['penunjangsearchorder_ruang_id'] = $ruang_id;
}
$unit_id = '';
if (isset($_SESSION['penunjangsearchorder_unit_id']))
		$unit_id = $_SESSION['penunjangsearchorder_unit_id'];

if (isset($_GET['unit_id'])) {
    $unit_id = $_GET['unit_id'];
	$_SESSION['penunjangsearchorder_unit_id'] = $unit_id;
}
$penunjang_id = '';
if (isset($_SESSION['penunjangsearchorder_penunjang_id']))
		$penunjang_id = $_SESSION['penunjangsearchorder_penunjang_id'];

if (isset($_GET['penunjang_id'])) {
    $penunjang_id = $_GET['penunjang_id'];
	$_SESSION['penunjangsearchorder_penunjang_id'] = $penunjang_id;
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
                    <?php echo getUnit('umumigd',$unit_id); ?>
                </select></td>	
			<td>Unit</td>
            <td><select name="penunjang_id" id="penunjang_id" style="width:228px;" class="text_dt" >
                    <option value="" > - </option>
                    <option value="31" <?php if($penunjang_id == '31') echo 'selected="selected"'; ?> >Fisioterapi</option> 
					<option value="41" <?php if($penunjang_id == '41') echo 'selected="selected"'; ?> >Okupasi Terapi</option>  
					<option value="47" <?php if($penunjang_id == '47') echo 'selected="selected"'; ?> >Psikologi</option> 
					<option value="40" <?php if($penunjang_id == '40') echo 'selected="selected"'; ?> >Terapi Wicara</option>
					<option value="42" <?php if($penunjang_id == '42') echo 'selected="selected"'; ?> >Prothesa</option>
                </select></td>
			<td>&nbsp;</td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/>
            </td>	
			<td>Ruang</td>
			<td><select name="ruang_id" id="ruang_id" class="text_dt" style="width:228px;">
			<option value=""> - </option>
			<?php echo getBangsal($ruang_id); ?>
            </select></td>	
			<td>Nomor MR/ Nama Pasien</td>
			<td><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt" style="width:220px;"/></td>
			<td><input type="submit" value="cari" class="myButton" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_kunjungan = 'SELECT DISTINCT * FROM (SELECT t_ipenunjang.PENUNJANG_ID,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				m_unit.NAMA_UNIT,"" AS BANGSAL,m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.UNIT_ID,
				SUM(CASE WHEN t_ipenunjang_tarif.ST_PERIKSA = "1" THEN 1 ELSE 0 END) AS ST_PERIKSA,
				t_ipenunjang_tarif.USER_PERIKSA,t_ipenunjang_tarif.NO_SJP,
				t_ipenunjang.MCU,m_unit2.NAMA_UNIT AS NAMA_PENUNJANG,t_ipenunjang_tarif.UNIT_PENUNJANG_ID
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				INNER JOIN m_unit m_unit2 ON (t_ipenunjang_tarif.UNIT_PENUNJANG_ID = m_unit2.UNIT_ID)
				WHERE t_ipenunjang.JNS_ORDER = "IRJ"
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang_tarif.UNIT_PENUNJANG_ID IN (31,41,47,40,42)  
				AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				GROUP BY t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_SJP
				UNION
				SELECT t_ipenunjang.PENUNJANG_ID,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_ruang.NAMA_RUANG," Kelas",m_ruang.KELAS_RAWAT) AS NAMA_UNIT,m_ruang.BANGSAL,
				m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.RUANG_ID AS UNIT_ID,
				SUM(CASE WHEN t_ipenunjang_tarif.ST_PERIKSA = "1" THEN 1 ELSE 0 END) AS ST_PERIKSA,
				t_ipenunjang_tarif.USER_PERIKSA,t_ipenunjang_tarif.NO_SJP,
				t_ipenunjang.MCU,m_unit2.NAMA_UNIT AS NAMA_PENUNJANG,t_ipenunjang_tarif.UNIT_PENUNJANG_ID
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				INNER JOIN m_unit m_unit2 ON (t_ipenunjang_tarif.UNIT_PENUNJANG_ID = m_unit2.UNIT_ID)
				WHERE t_ipenunjang.JNS_ORDER = "IRN"
				AND t_ipenunjang_tarif.UNIT_PENUNJANG_ID IN (31,41,47,40,42)   
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				GROUP BY t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_SJP
				UNION
				SELECT t_ipenunjang.PENUNJANG_ID,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.NAMA_PASIEN,t_ipenunjang.NO_PASIEN_PENUNJANG AS NOMR,t_ipenunjang.TGL_LAHIR,t_ipenunjang.ALAMAT,
				t_ipenunjang.INSTANSI_PENGIRIM AS NAMA_UNIT,"" AS BANGSAL,m_jaminan.NAMA_JAMINAN, "" AS RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang.PENGIRIM AS NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,"" AS UNIT_ID,
				SUM(CASE WHEN t_ipenunjang_tarif.ST_PERIKSA = "1" THEN 1 ELSE 0 END) AS ST_PERIKSA,
				t_ipenunjang_tarif.USER_PERIKSA,t_ipenunjang_tarif.NO_SJP,
				t_ipenunjang.MCU,m_unit2.NAMA_UNIT AS NAMA_PENUNJANG,t_ipenunjang_tarif.UNIT_PENUNJANG_ID
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_unit m_unit2 ON (t_ipenunjang_tarif.UNIT_PENUNJANG_ID = m_unit2.UNIT_ID)
				WHERE t_ipenunjang.JNS_ORDER = "APS"
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang_tarif.UNIT_PENUNJANG_ID IN (31,41,47,40,42)  
				AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				GROUP BY t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_SJP
				UNION
				SELECT t_ipenunjang.PENUNJANG_ID,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_unit.NAMA_UNIT,"-Hemodialisa") AS NAMA_UNIT,"" AS BANGSAL,m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.UNIT_ID,
				SUM(CASE WHEN t_ipenunjang_tarif.ST_PERIKSA = "1" THEN 1 ELSE 0 END) AS ST_PERIKSA,
				t_ipenunjang_tarif.USER_PERIKSA,t_ipenunjang_tarif.NO_SJP,
				t_ipenunjang.MCU,m_unit2.NAMA_UNIT AS NAMA_PENUNJANG,t_ipenunjang_tarif.UNIT_PENUNJANG_ID
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				INNER JOIN m_unit m_unit2 ON (t_ipenunjang_tarif.UNIT_PENUNJANG_ID = m_unit2.UNIT_ID)
				WHERE t_ipenunjang.JNS_ORDER = "HRJ"
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang_tarif.UNIT_PENUNJANG_ID IN (31,41,47,40,42)   
				AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				GROUP BY t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_SJP
				UNION
				SELECT t_ipenunjang.PENUNJANG_ID,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_ruang.NAMA_RUANG," Kelas",m_ruang.KELAS_RAWAT,"-Hemodialisa") AS NAMA_UNIT,m_ruang.BANGSAL,
				m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.RUANG_ID AS UNIT_ID,
				SUM(CASE WHEN t_ipenunjang_tarif.ST_PERIKSA = "1" THEN 1 ELSE 0 END) AS ST_PERIKSA,
				t_ipenunjang_tarif.USER_PERIKSA,t_ipenunjang_tarif.NO_SJP,
				t_ipenunjang.MCU,m_unit2.NAMA_UNIT AS NAMA_PENUNJANG,t_ipenunjang_tarif.UNIT_PENUNJANG_ID
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				INNER JOIN m_unit m_unit2 ON (t_ipenunjang_tarif.UNIT_PENUNJANG_ID = m_unit2.UNIT_ID)
				WHERE t_ipenunjang.JNS_ORDER = "HRI"
				AND t_ipenunjang_tarif.UNIT_PENUNJANG_ID IN (31,41,47,40,42)  
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				GROUP BY t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_SJP
				) t_order WHERE 1';
	
if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_kunjungan = $qry_kunjungan . ' AND CONCAT(t_order.NOMR,t_order.NAMA_PASIEN) LIKE "%' . $searchkey . '%"';
}	
if (!empty($ruang_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_order.BANGSAL = "' . $ruang_id . '" AND t_order.JNS_ORDER = "IRN"';
}
if (!empty($unit_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_order.UNIT_ID = "' . $unit_id . '" AND t_order.JNS_ORDER = "IRJ"';
}
if (!empty($penunjang_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_order.UNIT_PENUNJANG_ID = "' . $penunjang_id . '"';
}
if($_SESSION['SES_SIMRS_UNIT_ID'] != '34'){
	$qry_kunjungan = $qry_kunjungan . ' AND t_order.JNS_ORDER = "XYZ"';
}

$qry_kunjungan = $qry_kunjungan . ' ORDER BY TANGGAL_DAFTAR';

$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&ruang_id=' . $ruang_id . '&unit_id=' . $unit_id;
$action = '<a href="index.php?link=' . md5('penunjangformpemeriksaan') . '&idx=###" >proses</a>';
include('klinik/klinik_list_pasien_penunjang_rehabmedik.php');
?>
