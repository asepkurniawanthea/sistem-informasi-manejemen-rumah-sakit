<?php
$tgl_1 = '';
if (isset($_SESSION['rmsearchirna_tgl_1']))
    $tgl_1 = $_SESSION['rmsearchirna_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['rmsearchirna_tgl_1']))
    $tgl_2 = $_SESSION['rmsearchirna_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['rmsearchirna_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['rmsearchirna_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['rmsearchirna_searchkey']))
		$searchkey = $_SESSION['rmsearchirna_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['rmsearchirna_searchkey'] = $searchkey;
}
$ruang_id = '';
if (isset($_SESSION['rmsearchirna_ruang_id']))
		$ruang_id = $_SESSION['rmsearchirna_ruang_id'];

if (isset($_GET['ruang_id'])) {
    $ruang_id = $_GET['ruang_id'];
	$_SESSION['rmsearchirna_ruang_id'] = $ruang_id;
}
$jaminan_id = '';
if (isset($_SESSION['rmsearchirna_jaminan_id']))
		$jaminan_id = $_SESSION['rmsearchirna_jaminan_id'];

if (isset($_GET['jaminan_id'])) {
    $jaminan_id = $_GET['jaminan_id'];
	$_SESSION['rmsearchirna_jaminan_id'] = $jaminan_id;
}
$shift_id = '';
if (isset($_SESSION['rmsearchirna_shift_id']))
		$shift_id = $_SESSION['rmsearchirna_shift_id'];

if (isset($_GET['shift_id'])) {
    $shift_id = $_GET['shift_id'];
	$_SESSION['rmsearchirna_shift_id'] = $shift_id;
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
			<td>Jenis Pembayaran</td>
			<td> <select name="jaminan_id" id="jaminan_id" class="text_dt" style="width:228px;">
                    <option value=""> - </option>
                    <?php echo getJnsBayar($jaminan_id,''); ?>
                </select></td>	
			<td>Nomor MR/ Nama Pasien</td>
            <td colspan="2"><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt"/></td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/>            </td>	
			<td>Ruang</td>
			<td><select name="ruang_id" id="ruang_id" class="text_dt" style="width:228px;">
			<option value=""> - </option>
			<?php echo getRuangRawat($ruang_id); ?>
            </select></td>	
			<td>Shift</td>
			<td><select name="shift_id" id="shift_id" class="text_dt" style="width:80px;" >
				<option value=""> - </option>
				<option value="1" <?php if($shift_id == '1') echo 'selected="selected"'; ?> >1</option>
				<option value="2" <?php if($shift_id == '2') echo 'selected="selected"'; ?> >2</option>
				<option value="3" <?php if($shift_id == '3') echo 'selected="selected"'; ?> >3</option>
			  </select></td>
            <td align="right"><input name="submit" type="submit" class="myButton" value="cari" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_kunjungan = 'SELECT t_tran.IRNA_ID,t_tran.NOMR,t_tran.TANGGAL_DAFTAR,m_ruang.NAMA_RUANG,m_ruang.KELAS_RAWAT,
						m_jaminan.NAMA_JAMINAN,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,
						m_pasien.ALAMAT,t_tran.USER_RM,t_tran.JENIS_BAYAR_ID,t_tran.RUANG_ID,
						SUM(t_tran.JML_DIAGNOSA) AS JML_DIAGNOSA,
						SUM(t_tran.JML_ICD_10) AS JML_ICD_10,
						MAX(t_tran.ST_CODING) AS ST_CODING 
						FROM (SELECT t_irna.IRNA_ID AS IRNA_ID, 
							t_irna.NOMR AS NOMR, 
							t_irna.TANGGAL_DAFTAR AS TANGGAL_DAFTAR,
							t_irna.USER_RM AS USER_RM,
							t_irna.JENIS_BAYAR_ID AS JENIS_BAYAR_ID,
							t_irna.RUANG_ID AS RUANG_ID,
							COUNT(t_irna_diagnosa.IRNA_DIAGNOSA_ID) AS JML_DIAGNOSA,
							SUM(CASE WHEN LENGTH(TRIM(t_irna_diagnosa.ICD_CODE)) > 0 THEN 1 ELSE 0 END) AS JML_ICD_10,
							t_irna.ST_CODING AS ST_CODING,
							t_irna.SHIFT_ID
							FROM t_irna
							LEFT JOIN t_irna_diagnosa ON (t_irna.IRNA_ID = t_irna_diagnosa.IRNA_ID)
							WHERE t_irna.NO_PENDAFTARAN IS NOT NULL AND t_irna.ST_BATAL IS NULL
							AND t_irna.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND t_irna.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
							GROUP BY t_irna.IRNA_ID,t_irna.NOMR,t_irna.TANGGAL_DAFTAR
							UNION ALL
							SELECT t_irna.IRNA_ID AS IRNA_ID, 
							t_irna.NOMR AS NOMR, 
							t_irna.TANGGAL_DAFTAR AS TANGGAL_DAFTAR,
							t_irna.USER_RM AS USER_RM,
							t_irna.JENIS_BAYAR_ID AS JENIS_BAYAR_ID,
							t_irna.RUANG_ID AS RUANG_ID,
							COUNT(t_hemodialisa_diagnosa.HEMODIALISA_DIAGNOSA_ID) AS JML_DIAGNOSA,
							SUM(CASE WHEN LENGTH(TRIM(t_hemodialisa_diagnosa.ICD_CODE)) > 0 THEN 1 ELSE 0 END) AS JML_ICD_10,
							t_irna.ST_CODING AS ST_CODING,
							t_irna.SHIFT_ID
							FROM t_irna
							INNER JOIN t_hemodialisa ON (t_irna.IRNA_ID = t_hemodialisa.RAWAT_ID)
							LEFT JOIN t_hemodialisa_diagnosa ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_diagnosa.HEMODIALISA_ID)
							WHERE t_irna.NO_PENDAFTARAN IS NOT NULL AND t_irna.ST_BATAL IS NULL
							AND t_irna.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND t_irna.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
							AND t_hemodialisa.JNS_ORDER = "IRN"
							AND t_hemodialisa.NO_ORDER IS NOT NULL AND t_hemodialisa.ST_BATAL IS NULL
							GROUP BY t_irna.IRNA_ID,t_irna.NOMR,t_irna.TANGGAL_DAFTAR
							) t_tran 
							LEFT JOIN m_ruang ON (t_tran.RUANG_ID = m_ruang.RUANG_ID)
							LEFT JOIN m_pasien ON (t_tran.NOMR = m_pasien.NOMR)
							LEFT JOIN m_jaminan ON (t_tran.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
							WHERE 1 ';
	
if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_kunjungan = $qry_kunjungan . ' AND CONCAT(t_tran.NOMR,m_pasien.NAMA_PASIEN) LIKE "%' . $searchkey . '%"';
}	
if (!empty($ruang_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_tran.RUANG_ID = "' . $ruang_id . '"';
}
if (!empty($jaminan_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_tran.JENIS_BAYAR_ID = "' . $jaminan_id . '"';
}
if (!empty($shift_id)) {
    $qry_kunjungan = $qry_kunjungan . ' t_tran.AND SHIFT_ID = "' . $shift_id . '"';
}

$qry_kunjungan = $qry_kunjungan . ' GROUP BY t_tran.IRNA_ID ORDER BY m_pasien.NAMA_PASIEN';

$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&ruang_id=' . $ruang_id . '&jaminan_id=' . $jaminan_id . '&shift_id=' . $shift_id;;
$action = '<a href="index.php?link=' . md5('pendaftaranviewdaftar') . '&idx=###" >detail</a>';
include('rekammedik/rm_list_icd_irna.php');
?>
