<?php
$tgl_1 = '';
if (isset($_SESSION['rmsearchirja_tgl_1']))
    $tgl_1 = $_SESSION['rmsearchirja_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['rmsearchirja_tgl_1']))
    $tgl_2 = $_SESSION['rmsearchirja_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['rmsearchirja_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['rmsearchirja_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['rmsearchirja_searchkey']))
		$searchkey = $_SESSION['rmsearchirja_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['rmsearchirja_searchkey'] = $searchkey;
}
$unit_id = '';
if (isset($_SESSION['rmsearchirja_unit_id']))
		$unit_id = $_SESSION['rmsearchirja_unit_id'];

if (isset($_GET['unit_id'])) {
    $unit_id = $_GET['unit_id'];
	$_SESSION['rmsearchirja_unit_id'] = $unit_id;
}
$jaminan_id = '';
if (isset($_SESSION['rmsearchirja_jaminan_id']))
		$jaminan_id = $_SESSION['rmsearchirja_jaminan_id'];

if (isset($_GET['jaminan_id'])) {
    $jaminan_id = $_GET['jaminan_id'];
	$_SESSION['rmsearchirja_jaminan_id'] = $jaminan_id;
}
$shift_id = '';
if (isset($_SESSION['rmsearchirja_shift_id']))
		$shift_id = $_SESSION['rmsearchirja_shift_id'];

if (isset($_GET['shift_id'])) {
    $shift_id = $_GET['shift_id'];
	$_SESSION['rmsearchirja_shift_id'] = $shift_id;
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
			<td>Klinik</td>
			<td><select name="unit_id" id="unit_id" class="text_dt" style="width:228px;">
			<option value=""> - </option>
			<?php echo getUnit('irjp',$unit_id); ?>
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

$qry_kunjungan = 'SELECT t_tran.IRJA_ID,t_tran.NOMR,t_tran.TANGGAL_DAFTAR,t_tran.ST_BARU_LAMA,t_tran.ST_RUJUKAN,
						m_unit.NAMA_UNIT,m_jaminan.NAMA_JAMINAN,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,
						m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,t_tran.USER_RM,t_tran.JENIS_BAYAR_ID,t_tran.UNIT_ID,
						SUM(t_tran.JML_DIAGNOSA) AS JML_DIAGNOSA,
						SUM(t_tran.JML_ICD_10) AS JML_ICD_10,
						MAX(t_tran.ST_CODING) AS ST_CODING
						FROM (SELECT t_irja.IRJA_ID AS IRJA_ID, 
							t_irja.NOMR AS NOMR, 
							t_irja.TANGGAL_DAFTAR AS TANGGAL_DAFTAR,
							CASE t_irja.ST_BARU WHEN "1" THEN "v" END AS ST_BARU_LAMA,
							CASE t_irja.ST_RUJUKAN WHEN "1" THEN "v" END AS ST_RUJUKAN,
							t_irja.UNIT_ID AS UNIT_ID,			
							t_irja.JENIS_BAYAR_ID AS JENIS_BAYAR_ID,
							t_irja.USER_RM AS USER_RM,
							t_irja.ST_CODING AS ST_CODING,
							COUNT(t_irja_diagnosa.IRJA_DIAGNOSA_ID) AS JML_DIAGNOSA,
							SUM(CASE WHEN LENGTH(TRIM(t_irja_diagnosa.ICD_CODE)) > 0 THEN 1 ELSE 0 END) AS JML_ICD_10,
							t_irja.SHIFT_ID
							FROM t_irja
							LEFT JOIN t_irja_diagnosa ON (t_irja.IRJA_ID = t_irja_diagnosa.IRJA_ID)
							WHERE t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL
							AND t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
							GROUP BY t_irja.IRJA_ID,t_irja.NOMR,t_irja.TANGGAL_DAFTAR
							
							UNION ALL

							SELECT t_irja.IRJA_ID AS IRJA_ID, 
							t_irja.NOMR AS NOMR, 
							t_irja.TANGGAL_DAFTAR AS TANGGAL_DAFTAR,
							CASE t_irja.ST_BARU WHEN "1" THEN "v" END AS ST_BARU_LAMA,
							CASE t_irja.ST_RUJUKAN WHEN "1" THEN "v" END AS ST_RUJUKAN,
							t_irja.UNIT_ID AS UNIT_ID,
							t_irja.JENIS_BAYAR_ID AS JENIS_BAYAR_ID,							
							t_irja.USER_RM AS USER_RM,
							t_irja.ST_CODING AS ST_CODING,
							COUNT(t_hemodialisa_diagnosa.HEMODIALISA_DIAGNOSA_ID) AS JML_DIAGNOSA,
							SUM(CASE WHEN LENGTH(TRIM(t_hemodialisa_diagnosa.ICD_CODE)) > 0 THEN 1 ELSE 0 END) AS JML_ICD_10,
							t_irja.SHIFT_ID
							FROM t_irja
							INNER JOIN t_hemodialisa ON (t_irja.IRJA_ID = t_hemodialisa.RAWAT_ID)
							LEFT JOIN t_hemodialisa_diagnosa ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_diagnosa.HEMODIALISA_ID)
							WHERE t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL
							AND t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
							AND t_hemodialisa.JNS_ORDER = "IRJ"
							AND t_hemodialisa.NO_ORDER IS NOT NULL AND t_hemodialisa.ST_BATAL IS NULL
							GROUP BY t_irja.IRJA_ID,t_irja.NOMR,t_irja.TANGGAL_DAFTAR

							UNION ALL
							SELECT DISTINCT CONCAT("p",t_ipenunjang.PENUNJANG_ID) AS RAWAT_ID, 
							t_ipenunjang.NOMR AS NOMR, 
							t_ipenunjang_tarif.TANGGAL_DAFTAR AS TANGGAL_DAFTAR, 
							"" AS ST_BARU_LAMA, 
							"" AS ST_RUJUKAN, 
							t_ipenunjang_tarif.UNIT_PENUNJANG_ID AS UNIT_ID, 
							t_ipenunjang_tarif.JENIS_BAYAR_ID AS JENIS_BAYAR_ID, 
							"" AS USER_RM, 
							"" AS ST_CODING, 
							0 AS JML_DIAGNOSA, 
							0 AS JML_ICD_10, 
							"" SHIFT_ID 
							FROM t_ipenunjang
							LEFT JOIN t_ipenunjang_tarif 
							ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							WHERE t_ipenunjang_tarif.ST_BATAL IS NULL
							AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
							AND t_ipenunjang.JNS_ORDER = "IRJ"
							AND t_ipenunjang.NO_ORDER IS NOT NULL
							AND t_ipenunjang_tarif.UNIT_PENUNJANG_ID IN (18,31,40,41,42,47,51,52)
							GROUP BY t_ipenunjang.PENUNJANG_ID,t_ipenunjang.NOMR,t_ipenunjang_tarif.TANGGAL_DAFTAR
							) t_tran
							LEFT JOIN m_unit ON (t_tran.UNIT_ID = m_unit.UNIT_ID)
							LEFT JOIN m_pasien ON (t_tran.NOMR = m_pasien.NOMR)
							LEFT JOIN m_jaminan ON (t_tran.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
							WHERE 1';
	
if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_kunjungan = $qry_kunjungan . ' AND CONCAT(m_pasien.NOMR,m_pasien.NAMA_PASIEN) LIKE "%' . $searchkey . '%"';
}	
if (!empty($unit_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_tran.UNIT_ID = "' . $unit_id . '"';
}
if (!empty($jaminan_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_tran.JENIS_BAYAR_ID = "' . $jaminan_id . '"';
}
if (!empty($shift_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_tran.SHIFT_ID = "' . $shift_id . '"';
}

$qry_kunjungan = $qry_kunjungan . ' GROUP BY t_tran.IRJA_ID ORDER BY t_tran.TANGGAL_DAFTAR';

$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&unit_id=' . $unit_id . '&jaminan_id=' . $jaminan_id . '&shift_id=' . $shift_id;;
$action = '';
include('rekammedik/rm_list_icd_irja.php');
?>
