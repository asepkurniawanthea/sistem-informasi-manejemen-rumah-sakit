<?php
$tgl_1 = '';
if (isset($_SESSION['rmsearchtracer_tgl_1']))
    $tgl_1 = $_SESSION['rmsearchtracer_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['rmsearchtracer_tgl_1']))
    $tgl_2 = $_SESSION['rmsearchtracer_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['rmsearchtracer_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['rmsearchtracer_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['rmsearchtracer_searchkey']))
		$searchkey = $_SESSION['rmsearchtracer_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['rmsearchtracer_searchkey'] = $searchkey;
}
$unit_id = '';
if (isset($_SESSION['rmsearchtracer_unit_id']))
		$unit_id = $_SESSION['rmsearchtracer_unit_id'];

if (isset($_GET['unit_id'])) {
    $unit_id = $_GET['unit_id'];
	$_SESSION['rmsearchtracer_unit_id'] = $unit_id;
}
$ruang_id = '';
if (isset($_SESSION['rmsearchtracer_ruang_id']))
		$ruang_id = $_SESSION['rmsearchtracer_ruang_id'];

if (isset($_GET['ruang_id'])) {
    $ruang_id = $_GET['ruang_id'];
	$_SESSION['rmsearchtracer_ruang_id'] = $ruang_id;
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
			<td>Klinik/ Unit</td>
			<td><select name="unit_id" id="unit_id" class="text_dt" style="width:180px;">
			<option value=""> - </option>
			<?php echo getUnit('irjp',$unit_id); ?>
            </select></td>	
			<td>Nomor MR/ Nama Pasien</td>
			<td><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt" size="24"/></td>	
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/>            </td>	
			<td>Ruang</td>
			<td><select name="ruang_id" id="ruang_id" class="text_dt" style="width:180px;">
			<option value=""> - </option>
			<?php echo getRuangRawat($ruang_id); ?>
            </select></td>	
            <td align="right" colspan="2"><input name="submit" type="submit" class="myButton" value="cari" />
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_kunjungan = 'SELECT t_kunjungan.*, 
				m_pasien.NOMR,m_pasien.NAMA_PASIEN,
				m_unit.NAMA_UNIT,
				m_ruang.NAMA_RUANG,
				m_ruang2.NAMA_RUANG AS NAMA_RUANG_TERIMA,
				m_pasien_pulang.KET_PASIEN_PULANG,
				m_pasien_pulang2.KET_PASIEN_PULANG AS KET_PASIEN_PULANG_RANAP
				FROM (
					SELECT t_rm_tracer.RM_TRACER_ID,
					t_irja.TANGGAL_DAFTAR,
					t_rm_tracer.RM_KIRIM,
					t_rm_tracer.RM_USER_KIRIM,
					t_rm_tracer.RM_KETERANGAN_KIRIM,
					t_rm_tracer.IRJA_TERIMA,
					t_rm_tracer.IRJA_USER_TERIMA,
					t_rm_tracer.IRJA_KETERANGAN_TERIMA,
					t_rm_tracer.ADMS_TERIMA,
					t_rm_tracer.ADMS_USER_TERIMA,
					t_rm_tracer.ADMS_KETERANGAN_TERIMA,
					t_rm_tracer.RM_TERIMA,
					t_rm_tracer.RM_USER_TERIMA,
					t_rm_tracer.RM_KETERANGAN_TERIMA,
					t_irja.PASIEN_KELUAR,
					t_irna.PASIEN_KELUAR AS PASIEN_KELUAR_RANAP,
					t_irja.NOMR,
					t_irja.UNIT_ID,
					t_irna.RUANG_ID,
					t_irja.PASIEN_PULANG_ID,
					t_irna.PASIEN_PULANG_ID AS PASIEN_PULANG_ID_RANAP,
					t_rm_tracer.ADMS_TERIMA_RUANG_ID,
					t_irja.IRJA_ID AS RAWAT_ID	
					FROM t_irja
					INNER JOIN t_rm_tracer ON (t_irja.IRJA_ID = t_rm_tracer.IRJA_ID)
					LEFT JOIN t_irna ON (t_irja.IRJA_ID = t_irna.IRNA_ID)
					WHERE 1 AND t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' 
					AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
					
					UNION ALL
					
					SELECT CONCAT("p",t_rm_tracer.RM_TRACER_ID) AS RM_TRACER_ID,
					STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d-%m-%Y"),"%d-%m-%Y") AS TANGGAL_DAFTAR,
					t_rm_tracer.RM_KIRIM,
					t_rm_tracer.RM_USER_KIRIM,
					t_rm_tracer.RM_KETERANGAN_KIRIM,
					t_rm_tracer.IRJA_TERIMA,
					t_rm_tracer.IRJA_USER_TERIMA,
					t_rm_tracer.IRJA_KETERANGAN_TERIMA,
					t_rm_tracer.ADMS_TERIMA,
					t_rm_tracer.ADMS_USER_TERIMA,
					t_rm_tracer.ADMS_KETERANGAN_TERIMA,
					t_rm_tracer.RM_TERIMA,
					t_rm_tracer.RM_USER_TERIMA,
					t_rm_tracer.RM_KETERANGAN_TERIMA,
					NULL AS PASIEN_KELUAR,
					NULL AS PASIEN_KELUAR_RANAP,
					t_ipenunjang.NOMR,
					t_ipenunjang_tarif.UNIT_PENUNJANG_ID AS UNIT_ID,
					NULL AS RUANG_ID,
					NULL AS PASIEN_PULANG_ID,
					NULL AS PASIEN_PULANG_ID_RANAP,
					t_rm_tracer.ADMS_TERIMA_RUANG_ID,
					CONCAT("p",t_ipenunjang.PENUNJANG_ID) AS RAWAT_ID	
					FROM t_ipenunjang
					INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
					INNER JOIN t_rm_tracer ON (t_ipenunjang.PENUNJANG_ID = t_rm_tracer.PENUNJANG_ID)
					WHERE t_ipenunjang.JNS_ORDER = "IRJ"
					AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
					AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
					AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
					AND t_ipenunjang_tarif.ST_BATAL IS NULL
					AND t_ipenunjang_tarif.UNIT_PENUNJANG_ID IN (18,31,40,41,42,47,51,52)
					GROUP BY t_ipenunjang.RAWAT_ID,t_ipenunjang.PENUNJANG_ID
				) t_kunjungan
				INNER JOIN m_pasien ON (t_kunjungan.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_kunjungan.UNIT_ID = m_unit.UNIT_ID)
				LEFT JOIN m_ruang ON (t_kunjungan.RUANG_ID = m_ruang.RUANG_ID)
				LEFT JOIN m_ruang m_ruang2 ON (t_kunjungan.ADMS_TERIMA_RUANG_ID = m_ruang2.RUANG_ID)
				LEFT JOIN m_pasien_pulang ON (t_kunjungan.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID)
				LEFT JOIN m_pasien_pulang m_pasien_pulang2 ON (t_kunjungan.PASIEN_PULANG_ID_RANAP = m_pasien_pulang.PASIEN_PULANG_ID)
				WHERE 1 ';
	
if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_kunjungan = $qry_kunjungan . ' AND CONCAT(m_pasien.NOMR,m_pasien.NAMA_PASIEN) LIKE "%' . $searchkey . '%"';
}

if(!empty($unit_id)){
	$qry_kunjungan = $qry_kunjungan . ' AND t_kunjungan.UNIT_ID = "' . $unit_id . '"';
}

if(!empty($ruang_id)){
	$qry_kunjungan = $qry_kunjungan . ' AND t_kunjungan.RUANG_ID = "' . $ruang_id . '"';
}	

$qry_kunjungan = $qry_kunjungan . ' ORDER BY m_pasien.NAMA_PASIEN,m_pasien.NOMR';

$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&unit_id=' . $unit_id . '&ruang_id=' . $ruang_id;
$action = '<a href="index.php?link=' . md5('pendaftaranviewdaftar') . '&idx=###" >detail</a>';
include('rekammedik/rm_list_tracer.php');
?>
