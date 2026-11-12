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
			<td>Nomor MR/ Nama Pasien</td>
			<td><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt" size="24"/></td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/>            </td>	
			<td>&nbsp;</td>
			<td align="right"><input name="submit" type="submit" class="myButton" value="cari" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_filter = '';
if(currentModul() == 'klinik' or currentModul() == 'igd' or currentModul() == 'kusta'){
	$qry_filter = 'AND t_irja.UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '"';
}
$qry_kunjungan = 'SELECT t_rm_tracer.RM_TRACER_ID,t_irja.TANGGAL_DAFTAR,m_pasien.NOMR,m_pasien.NAMA_PASIEN,
				m_unit.NAMA_UNIT,t_rm_tracer.RM_KIRIM,t_rm_tracer.RM_USER_KIRIM,t_rm_tracer.RM_KETERANGAN_KIRIM,
				t_rm_tracer.IRJA_TERIMA,t_rm_tracer.IRJA_USER_TERIMA,t_rm_tracer.IRJA_KETERANGAN_TERIMA,
				m_ruang.NAMA_RUANG,
				t_rm_tracer.ADMS_TERIMA,t_rm_tracer.ADMS_USER_TERIMA,t_rm_tracer.ADMS_KETERANGAN_TERIMA,
				m_ruang2.NAMA_RUANG AS NAMA_RUANG_TERIMA,
				t_rm_tracer.RM_TERIMA,t_rm_tracer.RM_USER_TERIMA,
				t_rm_tracer.RM_KETERANGAN_TERIMA,m_pasien_pulang.KET_PASIEN_PULANG,
				m_pasien_pulang2.KET_PASIEN_PULANG AS KET_PASIEN_PULANG_RANAP
				FROM t_irja
				INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN t_rm_tracer ON (t_irja.IRJA_ID = t_rm_tracer.IRJA_ID)
				LEFT JOIN m_pasien_pulang ON (t_irja.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID)
				LEFT JOIN t_irna ON (t_irja.IRJA_ID = t_irna.IRNA_ID)
				LEFT JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				LEFT JOIN m_ruang m_ruang2 ON (t_rm_tracer.ADMS_TERIMA_RUANG_ID = m_ruang2.RUANG_ID)
				LEFT JOIN m_pasien_pulang m_pasien_pulang2 ON (t_irna.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID)
				WHERE 1 ' . $qry_filter . ' 
				AND t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2;
	
if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_kunjungan = $qry_kunjungan . ' AND CONCAT(m_pasien.NOMR,m_pasien.NAMA_PASIEN) LIKE "%' . $searchkey . '%"';
}	

$qry_kunjungan = $qry_kunjungan . ' ORDER BY m_pasien.NAMA_PASIEN,m_pasien.NOMR';

$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2;
$action = '<a href="index.php?link=' . md5('pendaftaranviewdaftar') . '&idx=###" >detail</a>';
include('rekammedik/rm_list_penerimaan_unit.php');
?>
