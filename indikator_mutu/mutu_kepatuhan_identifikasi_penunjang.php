<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tgl_1 = '';
if (isset($_SESSION['kepatuhanidentifikasipenunjang_tgl_1']))
    $tgl_1 = $_SESSION['kepatuhanidentifikasipenunjang_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['kepatuhanidentifikasipenunjang_tgl_1']))
    $tgl_2 = $_SESSION['kepatuhanidentifikasipenunjang_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['kepatuhanidentifikasipenunjang_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['kepatuhanidentifikasipenunjang_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['kepatuhanidentifikasipenunjang_searchkey']))
		$searchkey = $_SESSION['kepatuhanidentifikasipenunjang_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['kepatuhanidentifikasipenunjang_searchkey'] = $searchkey;
}

$unit_id = '';
if(currentModul() == 'monitoring mutu'){
	if (isset($_SESSION['kepatuhanidentifikasipenunjang_unit_id']))
			$unit_id = $_SESSION['kepatuhanidentifikasipenunjang_unit_id'];

	if (isset($_GET['unit_id'])) {
		$unit_id = $_GET['unit_id'];
		$_SESSION['kepatuhanidentifikasipenunjang_unit_id'] = $unit_id;
	}
}else{
	if(currentModul() == 'laboratorium') $unit_id = '45';
	if(currentModul() == 'radiologi') $unit_id = '17';
	if(currentModul() == 'penunjang') $unit_id = $_SESSION['SES_SIMRS_UNIT_ID'];
}	

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}

$tgl_skr = date('d/m/Y');		
?>
<form name="search" method="get" action="index.php">
    <table class="tableform" border="0">
		<tr>
            <td>Tanggal</td>
            <td><input type="text" name="tgl_1" id="tgl_1" value="<?php echo $tgl_1; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
			<td>Nomor MR/ Nama Pasien</td>
            <td><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt" style="width:200px;"/></td>	
			<td>&nbsp;</td>
			<td>&nbsp;</td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')" /></td>
			<td>Unit - Penunjang</td>
			<td><select name="unit_id" class="text_dt" style="width:210px;"
				<?php if(currentModul() != 'monitoring mutu') echo 'disabled="disabled"'; ?> >
				<option value=""> - </option>
				<?php echo getUnit('pnj',$unit_id); ?>
			</select></td>		
			<td align="right" colspan="2"><input type="submit" value="cari" class="myButton" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_pasien = 'SELECT t_ifp.*,mun.NAMA_UNIT AS UNIT_PENUNJANG,
				dbr.SEBELUM_TINDAKAN,dbr.PENGUMPUL_DATA,
				dbr.KEPATUHAN_IDENTIFIKASI_ID,
				DATE_FORMAT(dbr.TGL_OBSERVASI,"%d/%m/%Y") AS TGL_OBSERVASI,
				CASE WHEN t_ifp.JNS_ORDER = "APS" THEN x_tip.NAMA_PASIEN
					ELSE psn.NAMA_PASIEN END AS NAMA_PASIEN,
				CASE WHEN t_ifp.JNS_ORDER = "APS" 
						THEN DATE_FORMAT(x_tip.TGL_LAHIR,"%d/%m/%Y")
					ELSE DATE_FORMAT(psn.TGL_LAHIR,"%d/%m/%Y") END AS TGL_LAHIR,
				CASE WHEN t_ifp.JNS_ORDER = "APS" THEN x_tip.INSTANSI_PENGIRIM
					ELSE x_un.NAMA_UNIT END AS NAMA_UNIT_PENGIRIM,
				x_ur.NAMA_RUANG AS NAMA_RUANG_PENGIRIM	
				FROM (
				SELECT tip.RAWAT_ID AS PENUNJANG_ID,45 AS UNIT_ID,tip.JNS_ORDER,
				tipt.NO_TARIF, 
				DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				tip.NOMR,
				tip.UNIT_ID AS UNIT_ID_PENGIRIM,
				NULL AS RUANG_ID_PENGIRIM,
				"" EXT_NAMA_UNIT
				FROM db_simrs.t_ipenunjang tip
				INNER JOIN db_simrs.t_ipenunjang_tarif tipt ON (tip.PENUNJANG_ID = tipt.PENUNJANG_ID)
				INNER JOIN db_simrs.m_tarif mtr ON (tipt.TARIF_ID = mtr.TARIF_ID)
				INNER JOIN db_simrs.m_tarif_group mtrg ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
				WHERE tip.JNS_ORDER = "IRJ"
				AND tipt.NO_TARIF IS NOT NULL
				AND (mtrg.LABORATORIUM = "1" OR mtrg.LABORATORIUM_CITO = "1")
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				AND tipt.ST_BATAL IS NULL
				GROUP BY tip.RAWAT_ID,tipt.NO_TARIF
				UNION
				SELECT tip.RAWAT_ID AS PENUNJANG_ID,45 AS UNIT_ID,tip.JNS_ORDER,
				tipt.NO_TARIF, 
				DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				tip.NOMR,
				tip.UNIT_ID AS UNIT_ID_PENGIRIM,
				NULL AS RUANG_ID_PENGIRIM,
				"Hemodialisa" EXT_NAMA_UNIT
				FROM db_simrs.t_ipenunjang tip
				INNER JOIN db_simrs.t_ipenunjang_tarif tipt ON (tip.PENUNJANG_ID = tipt.PENUNJANG_ID)
				INNER JOIN db_simrs.m_tarif mtr ON (tipt.TARIF_ID = mtr.TARIF_ID)
				INNER JOIN db_simrs.m_tarif_group mtrg ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
				WHERE tip.JNS_ORDER = "HRJ"
				AND tipt.NO_TARIF IS NOT NULL
				AND (mtrg.LABORATORIUM = "1" OR mtrg.LABORATORIUM_CITO = "1")
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				AND tipt.ST_BATAL IS NULL
				GROUP BY tip.RAWAT_ID,tipt.NO_TARIF
				UNION
				SELECT tip.RAWAT_ID AS PENUNJANG_ID,45 AS UNIT_ID,tip.JNS_ORDER,
				tipt.NO_TARIF, 
				DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				tip.NOMR,
				tip.UNIT_ID AS UNIT_ID_PENGIRIM,
				NULL AS RUANG_ID_PENGIRIM,
				"Kamar Operasi" EXT_NAMA_UNIT
				FROM db_simrs.t_ipenunjang tip
				INNER JOIN db_simrs.t_ipenunjang_tarif tipt ON (tip.PENUNJANG_ID = tipt.PENUNJANG_ID)
				INNER JOIN db_simrs.m_tarif mtr ON (tipt.TARIF_ID = mtr.TARIF_ID)
				INNER JOIN db_simrs.m_tarif_group mtrg ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
				WHERE tip.JNS_ORDER = "ORJ"
				AND tipt.NO_TARIF IS NOT NULL
				AND (mtrg.LABORATORIUM = "1" OR mtrg.LABORATORIUM_CITO = "1")
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				AND tipt.ST_BATAL IS NULL
				GROUP BY tip.RAWAT_ID,tipt.NO_TARIF
				UNION
				SELECT tip.RAWAT_ID AS PENUNJANG_ID,45 AS UNIT_ID,tip.JNS_ORDER,
				tipt.NO_TARIF, 
				DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				tip.NOMR,
				NULL AS UNIT_ID_PENGIRIM,
				tip.RUANG_ID AS RUANG_ID_PENGIRIM,
				"Kamar Operasi" EXT_NAMA_UNIT
				FROM db_simrs.t_ipenunjang tip
				INNER JOIN db_simrs.t_ipenunjang_tarif tipt ON (tip.PENUNJANG_ID = tipt.PENUNJANG_ID)
				INNER JOIN db_simrs.m_tarif mtr ON (tipt.TARIF_ID = mtr.TARIF_ID)
				INNER JOIN db_simrs.m_tarif_group mtrg ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
				WHERE tip.JNS_ORDER = "ORI"
				AND tipt.NO_TARIF IS NOT NULL
				AND (mtrg.LABORATORIUM = "1" OR mtrg.LABORATORIUM_CITO = "1")
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				AND tipt.ST_BATAL IS NULL
				GROUP BY tip.RAWAT_ID,tipt.NO_TARIF
				UNION
				SELECT tip.RAWAT_ID AS PENUNJANG_ID,45 AS UNIT_ID,tip.JNS_ORDER,
				tipt.NO_TARIF, 
				DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				tip.NOMR,
				NULL AS UNIT_ID_PENGIRIM,
				tip.RUANG_ID AS RUANG_ID_PENGIRIM,
				"" EXT_NAMA_UNIT
				FROM db_simrs.t_ipenunjang tip
				INNER JOIN db_simrs.t_ipenunjang_tarif tipt ON (tip.PENUNJANG_ID = tipt.PENUNJANG_ID)
				INNER JOIN db_simrs.m_tarif mtr ON (tipt.TARIF_ID = mtr.TARIF_ID)
				INNER JOIN db_simrs.m_tarif_group mtrg ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
				WHERE tip.JNS_ORDER = "IRN"
				AND tipt.NO_TARIF IS NOT NULL
				AND (mtrg.LABORATORIUM = "1" OR mtrg.LABORATORIUM_CITO = "1")
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				AND tipt.ST_BATAL IS NULL
				GROUP BY tip.RAWAT_ID,tipt.NO_TARIF
				UNION
				SELECT tip.RAWAT_ID AS PENUNJANG_ID,45 AS UNIT_ID,tip.JNS_ORDER,
				tipt.NO_TARIF, 
				DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				tip.NOMR,
				NULL AS UNIT_ID_PENGIRIM,
				tip.RUANG_ID AS RUANG_ID_PENGIRIM,
				"Hemodialisa" EXT_NAMA_UNIT
				FROM db_simrs.t_ipenunjang tip
				INNER JOIN db_simrs.t_ipenunjang_tarif tipt ON (tip.PENUNJANG_ID = tipt.PENUNJANG_ID)
				INNER JOIN db_simrs.m_tarif mtr ON (tipt.TARIF_ID = mtr.TARIF_ID)
				INNER JOIN db_simrs.m_tarif_group mtrg ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
				WHERE tip.JNS_ORDER = "HRI"
				AND tipt.NO_TARIF IS NOT NULL
				AND (mtrg.LABORATORIUM = "1" OR mtrg.LABORATORIUM_CITO = "1")
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				AND tipt.ST_BATAL IS NULL
				GROUP BY tip.RAWAT_ID,tipt.NO_TARIF
				UNION
				SELECT tip.PENUNJANG_ID,45 AS UNIT_ID,tip.JNS_ORDER,
				tipt.NO_TARIF,
				DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				tip.NO_PASIEN_PENUNJANG AS NOMR,
				NULL AS UNIT_ID_PENGIRIM,
				NULL AS RUANG_ID_PENGIRIM,
				"" EXT_NAMA_UNIT
				FROM db_simrs.t_ipenunjang tip
				INNER JOIN db_simrs.t_ipenunjang_tarif tipt ON (tip.PENUNJANG_ID = tipt.PENUNJANG_ID)
				INNER JOIN db_simrs.m_tarif mtr ON (tipt.TARIF_ID = mtr.TARIF_ID)
				INNER JOIN db_simrs.m_tarif_group mtrg ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
				WHERE tip.JNS_ORDER = "APS"
				AND tipt.NO_TARIF IS NOT NULL
				AND (mtrg.LABORATORIUM = "1" OR mtrg.LABORATORIUM_CITO = "1")
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				AND tipt.ST_BATAL IS NULL
				GROUP BY tip.PENUNJANG_ID
				
				UNION
				SELECT tip.RAWAT_ID AS PENUNJANG_ID,17 AS UNIT_ID,tip.JNS_ORDER,
				tipt.NO_TARIF, 
				DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				tip.NOMR,
				tip.UNIT_ID AS UNIT_ID_PENGIRIM,
				NULL AS RUANG_ID_PENGIRIM,
				"" AS EXT_NAMA_UNIT
				FROM db_simrs.t_ipenunjang tip
				INNER JOIN db_simrs.t_ipenunjang_tarif tipt ON (tip.PENUNJANG_ID = tipt.PENUNJANG_ID)
				INNER JOIN db_simrs.m_tarif mtr ON (tipt.TARIF_ID = mtr.TARIF_ID)
				INNER JOIN db_simrs.m_tarif_group mtrg ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
				WHERE tip.JNS_ORDER = "IRJ"
				AND tipt.NO_TARIF IS NOT NULL
				AND (mtrg.RADIOLOGI = "1" OR mtrg.RADIOLOGI_CITO = "1")
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				AND tipt.ST_BATAL IS NULL
				GROUP BY tip.RAWAT_ID,tipt.NO_TARIF
				UNION
				SELECT tip.RAWAT_ID AS PENUNJANG_ID,17 AS UNIT_ID,tip.JNS_ORDER,
				tipt.NO_TARIF, 
				DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				tip.NOMR,
				NULL AS UNIT_ID_PENGIRIM,
				tip.RUANG_ID AS RUANG_ID_PENGIRIM,
				"" AS EXT_NAMA_UNIT
				FROM db_simrs.t_ipenunjang tip
				INNER JOIN db_simrs.t_ipenunjang_tarif tipt ON (tip.PENUNJANG_ID = tipt.PENUNJANG_ID)
				INNER JOIN db_simrs.m_tarif mtr ON (tipt.TARIF_ID = mtr.TARIF_ID)
				INNER JOIN db_simrs.m_tarif_group mtrg ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
				WHERE tip.JNS_ORDER = "IRN"
				AND tipt.NO_TARIF IS NOT NULL
				AND (mtrg.RADIOLOGI = "1" OR mtrg.RADIOLOGI_CITO = "1")
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				AND tipt.ST_BATAL IS NULL
				GROUP BY tip.RAWAT_ID,tipt.NO_TARIF
				UNION
				SELECT tip.PENUNJANG_ID,17 AS UNIT_ID,tip.JNS_ORDER,
				tipt.NO_TARIF,
				DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				tip.NO_PASIEN_PENUNJANG AS NOMR,
				NULL AS UNIT_ID_PENGIRIM,
				NULL AS RUANG_ID_PENGIRIM,
				"" AS EXT_NAMA_UNIT
				FROM db_simrs.t_ipenunjang tip
				INNER JOIN db_simrs.t_ipenunjang_tarif tipt ON (tip.PENUNJANG_ID = tipt.PENUNJANG_ID)
				INNER JOIN db_simrs.m_tarif mtr ON (tipt.TARIF_ID = mtr.TARIF_ID)
				INNER JOIN db_simrs.m_tarif_group mtrg ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
				WHERE tip.JNS_ORDER = "APS"
				AND tipt.NO_TARIF IS NOT NULL
				AND (mtrg.RADIOLOGI = "1" OR mtrg.RADIOLOGI_CITO = "1")
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				AND tipt.ST_BATAL IS NULL
				GROUP BY tip.PENUNJANG_ID
				UNION
				SELECT tip.RAWAT_ID AS PENUNJANG_ID,17 AS UNIT_ID,tip.JNS_ORDER,
				tipt.NO_TARIF, 
				DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				tip.NOMR,
				tip.UNIT_ID AS UNIT_ID_PENGIRIM,
				NULL AS RUANG_ID_PENGIRIM,
				"Hemodialisa" AS EXT_NAMA_UNIT
				FROM db_simrs.t_ipenunjang tip
				INNER JOIN db_simrs.t_ipenunjang_tarif tipt ON (tip.PENUNJANG_ID = tipt.PENUNJANG_ID)
				INNER JOIN db_simrs.m_tarif mtr ON (tipt.TARIF_ID = mtr.TARIF_ID)
				INNER JOIN db_simrs.m_tarif_group mtrg ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
				WHERE tip.JNS_ORDER = "HRJ"
				AND tipt.NO_TARIF IS NOT NULL
				AND (mtrg.RADIOLOGI = "1" OR mtrg.RADIOLOGI_CITO = "1")
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				AND tipt.ST_BATAL IS NULL
				GROUP BY tip.RAWAT_ID,tipt.NO_TARIF
				UNION
				SELECT tip.RAWAT_ID AS PENUNJANG_ID,17 AS UNIT_ID,tip.JNS_ORDER,
				tipt.NO_TARIF, 
				DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				tip.NOMR,
				NULL AS UNIT_ID_PENGIRIM,
				tip.RUANG_ID AS RUANG_ID_PENGIRIM,
				"Hemodialisa" AS EXT_NAMA_UNIT
				FROM db_simrs.t_ipenunjang tip
				INNER JOIN db_simrs.t_ipenunjang_tarif tipt ON (tip.PENUNJANG_ID = tipt.PENUNJANG_ID)
				INNER JOIN db_simrs.m_tarif mtr ON (tipt.TARIF_ID = mtr.TARIF_ID)
				INNER JOIN db_simrs.m_tarif_group mtrg ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
				WHERE tip.JNS_ORDER = "HRI"
				AND tipt.NO_TARIF IS NOT NULL
				AND (mtrg.RADIOLOGI = "1" OR mtrg.RADIOLOGI_CITO = "1")
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				AND tipt.ST_BATAL IS NULL
				GROUP BY tip.RAWAT_ID,tipt.NO_TARIF
				UNION
				SELECT tip.RAWAT_ID AS PENUNJANG_ID,17 AS UNIT_ID,tip.JNS_ORDER,
				tipt.NO_TARIF, 
				DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				tip.NOMR,
				tip.UNIT_ID AS UNIT_ID_PENGIRIM,
				NULL AS RUANG_ID_PENGIRIM,
				"Kamar Operasi" AS EXT_NAMA_UNIT
				FROM db_simrs.t_ipenunjang tip
				INNER JOIN db_simrs.t_ipenunjang_tarif tipt ON (tip.PENUNJANG_ID = tipt.PENUNJANG_ID)
				INNER JOIN db_simrs.m_tarif mtr ON (tipt.TARIF_ID = mtr.TARIF_ID)
				INNER JOIN db_simrs.m_tarif_group mtrg ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
				WHERE tip.JNS_ORDER = "ORJ"
				AND tipt.NO_TARIF IS NOT NULL
				AND (mtrg.RADIOLOGI = "1" OR mtrg.RADIOLOGI_CITO = "1")
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				AND tipt.ST_BATAL IS NULL
				GROUP BY tip.RAWAT_ID,tipt.NO_TARIF
				UNION
				SELECT tip.RAWAT_ID AS PENUNJANG_ID,17 AS UNIT_ID,tip.JNS_ORDER,
				tipt.NO_TARIF, 
				DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				tip.NOMR,
				NULL AS UNIT_ID_PENGIRIM,
				tip.RUANG_ID AS RUANG_ID_PENGIRIM,
				"Kamar Operasi" AS EXT_NAMA_UNIT
				FROM db_simrs.t_ipenunjang tip
				INNER JOIN db_simrs.t_ipenunjang_tarif tipt ON (tip.PENUNJANG_ID = tipt.PENUNJANG_ID)
				INNER JOIN db_simrs.m_tarif mtr ON (tipt.TARIF_ID = mtr.TARIF_ID)
				INNER JOIN db_simrs.m_tarif_group mtrg ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
				WHERE tip.JNS_ORDER = "ORI"
				AND tipt.NO_TARIF IS NOT NULL
				AND (mtrg.RADIOLOGI = "1" OR mtrg.RADIOLOGI_CITO = "1")
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				AND tipt.ST_BATAL IS NULL
				GROUP BY tip.RAWAT_ID,tipt.NO_TARIF
				
				UNION
				SELECT tip.PENUNJANG_ID,tipt.UNIT_PENUNJANG_ID AS UNIT_ID,
				tip.JNS_ORDER,
				tipt.NO_SJP AS NO_TARIF, 
				DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				tip.NOMR,
				tip.UNIT_ID AS UNIT_ID_PENGIRIM,
				NULL AS RUANG_ID_PENGIRIM,
				"" AS EXT_NAMA_UNIT
				FROM db_simrs.t_ipenunjang tip
				INNER JOIN db_simrs.t_ipenunjang_tarif tipt ON (tip.PENUNJANG_ID = tipt.PENUNJANG_ID)
				INNER JOIN db_simrs.m_tarif mtr ON (tipt.TARIF_ID = mtr.TARIF_ID)
				INNER JOIN db_simrs.m_tarif_group mtrg ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
				WHERE tip.JNS_ORDER = "IRJ"
				AND tipt.NO_TARIF IS NOT NULL
				AND (mtrg.PENUNJANG = "1" OR mtr.UNIT_ID IS NOT NULL OR mtr.UNIT_ID <> "")
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				GROUP BY tip.PENUNJANG_ID,tipt.NO_SJP
				UNION
				SELECT tip.PENUNJANG_ID,tipt.UNIT_PENUNJANG_ID AS UNIT_ID,
				tip.JNS_ORDER,
				tipt.NO_SJP AS NO_TARIF, 
				DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				tip.NOMR,
				NULL AS UNIT_ID_PENGIRIM,
				tip.RUANG_ID AS RUANG_ID_PENGIRIM,
				"" AS EXT_NAMA_UNIT
				FROM db_simrs.t_ipenunjang tip
				INNER JOIN db_simrs.t_ipenunjang_tarif tipt ON (tip.PENUNJANG_ID = tipt.PENUNJANG_ID)
				INNER JOIN db_simrs.m_tarif mtr ON (tipt.TARIF_ID = mtr.TARIF_ID)
				INNER JOIN db_simrs.m_tarif_group mtrg ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
				WHERE tip.JNS_ORDER = "IRN"
				AND tipt.NO_TARIF IS NOT NULL
				AND (mtrg.PENUNJANG = "1" OR mtr.UNIT_ID IS NOT NULL OR mtr.UNIT_ID <> "")
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				GROUP BY tip.PENUNJANG_ID,tipt.NO_SJP
				UNION
				SELECT tip.PENUNJANG_ID,tipt.UNIT_PENUNJANG_ID AS UNIT_ID,
				tip.JNS_ORDER,
				tipt.NO_SJP AS NO_TARIF, 
				DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				tip.NO_PASIEN_PENUNJANG AS NOMR,
				NULL AS UNIT_ID_PENGIRIM,
				NULL AS RUANG_ID_PENGIRIM,
				"" AS EXT_NAMA_UNIT
				FROM db_simrs.t_ipenunjang tip
				INNER JOIN db_simrs.t_ipenunjang_tarif tipt ON (tip.PENUNJANG_ID = tipt.PENUNJANG_ID)
				INNER JOIN db_simrs.m_tarif mtr ON (tipt.TARIF_ID = mtr.TARIF_ID)
				INNER JOIN db_simrs.m_tarif_group mtrg ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
				WHERE tip.JNS_ORDER = "APS"
				AND tipt.NO_TARIF IS NOT NULL
				AND (mtrg.PENUNJANG = "1" OR mtr.UNIT_ID IS NOT NULL OR mtr.UNIT_ID <> "")
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				GROUP BY tip.PENUNJANG_ID,tipt.NO_SJP
				UNION
				SELECT tip.PENUNJANG_ID,tipt.UNIT_PENUNJANG_ID AS UNIT_ID,
				tip.JNS_ORDER,
				tipt.NO_SJP AS NO_TARIF, 
				DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				tip.NOMR,
				tip.UNIT_ID AS UNIT_ID_PENGIRIM,
				NULL AS RUANG_ID_PENGIRIM,
				"Hemodialisa" AS EXT_NAMA_UNIT
				FROM db_simrs.t_ipenunjang tip
				INNER JOIN db_simrs.t_ipenunjang_tarif tipt ON (tip.PENUNJANG_ID = tipt.PENUNJANG_ID)
				INNER JOIN db_simrs.m_tarif mtr ON (tipt.TARIF_ID = mtr.TARIF_ID)
				INNER JOIN db_simrs.m_tarif_group mtrg ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
				WHERE tip.JNS_ORDER = "HRJ"
				AND tipt.NO_TARIF IS NOT NULL
				AND (mtrg.PENUNJANG = "1" OR mtr.UNIT_ID IS NOT NULL OR mtr.UNIT_ID <> "")
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				GROUP BY tip.PENUNJANG_ID,tipt.NO_SJP
				UNION
				SELECT tip.PENUNJANG_ID,tipt.UNIT_PENUNJANG_ID AS UNIT_ID,
				tip.JNS_ORDER,
				tipt.NO_SJP AS NO_TARIF, 
				DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				tip.NOMR,
				NULL AS UNIT_ID_PENGIRIM,
				tip.RUANG_ID AS RUANG_ID_PENGIRIM,
				"Hemodialisa" AS EXT_NAMA_UNIT
				FROM db_simrs.t_ipenunjang tip
				INNER JOIN db_simrs.t_ipenunjang_tarif tipt ON (tip.PENUNJANG_ID = tipt.PENUNJANG_ID)
				INNER JOIN db_simrs.m_tarif mtr ON (tipt.TARIF_ID = mtr.TARIF_ID)
				INNER JOIN db_simrs.m_tarif_group mtrg ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
				WHERE tip.JNS_ORDER = "HRI"
				AND tipt.NO_TARIF IS NOT NULL
				AND (mtrg.PENUNJANG = "1" OR mtr.UNIT_ID IS NOT NULL OR mtr.UNIT_ID <> "")
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				GROUP BY tip.PENUNJANG_ID,tipt.NO_SJP
				) t_ifp
				INNER JOIN db_simrs.m_unit mun ON (t_ifp.UNIT_ID = mun.UNIT_ID)
				LEFT JOIN db_simrs.m_unit x_un ON (t_ifp.UNIT_ID_PENGIRIM = x_un.UNIT_ID)
				LEFT JOIN db_simrs.m_ruang x_ur ON (t_ifp.RUANG_ID_PENGIRIM = x_ur.RUANG_ID)
				LEFT JOIN db_simrs.m_pasien psn ON (t_ifp.NOMR = psn.NOMR)
				LEFT JOIN db_simrs.t_ipenunjang x_tip ON (t_ifp.PENUNJANG_ID = x_tip.PENUNJANG_ID AND t_ifp.JNS_ORDER = "APS"
					AND x_tip.JNS_ORDER = "APS")
				LEFT JOIN db_repository.mutu_kepatuhan_identifikasi_ipenunjang dbr
				ON (
					t_ifp.PENUNJANG_ID = dbr.RAWAT_ID
					AND t_ifp.UNIT_ID = dbr.UNIT_ID
					AND t_ifp.JNS_ORDER = dbr.JNS_ORDER
					AND t_ifp.NO_TARIF = dbr.NO_ORDER
				)
				WHERE 1';

if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_pasien = $qry_pasien . ' AND CONCAT(t_ifp.NOMR,t_ifp.NAMA_PASIEN) LIKE "%' . $searchkey . '%" ';
}
if (!empty($unit_id)) {
    $qry_pasien = $qry_pasien . ' AND t_ifp.UNIT_ID = "' . $unit_id . '" ';
}	
$qry_pasien = $qry_pasien . ' ORDER BY t_ifp.PENUNJANG_ID';

$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&unit_id=' . $unit_id;
?>
<form name="formedukasi">
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
		<th>Tanggal</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
        <th>Tanggal Lahir</th>
        <th>Pengirim</th>
		<th>Unit - Penunjang</th>
        <th>Dilakukan Identifikasi Sebelum<br />
          Tindakan/<br />
		  Pengambilan Sample/<br />
		  Pemberian Nutrisi</th>
		<th width="125px">Tgl Observasi</th>
		<th width="100px">Register</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_pasien, 20, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
        $id = $data['PENUNJANG_ID'];
        ?>
        <tr>
            <td align="center"><?
    $no = ($no + 1);
    if (isset($_GET['page'])) {
        if ($_GET['page'] == 0) {
            $hal = 0;
        } else {
            $hal = $_GET['page'] - 1;
        }
    } else {
        $hal = 0;
    }
    echo ($hal * 20) + $no;
        ?></td>
            <td align="center"><?php echo $data['TANGGAL_DAFTAR']; ?></td>
            <td align="center"><?php if(strlen($data['NOMR']) == 6) {
					echo formatNoMR($data['NOMR']);
				}else{
					echo $data['NOMR'];
				}?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td align="center"><?php echo $data['TGL_LAHIR']; ?></td>
            <td><?php $nama_unit =  $data['NAMA_UNIT_PENGIRIM'];
					if($nama_unit == '') $nama_unit= $data['NAMA_RUANG_PENGIRIM'];	
					if($data['EXT_NAMA_UNIT'] != '') $nama_unit .= $data['EXT_NAMA_UNIT'];
					echo $nama_unit; ?></td>
			<td><?php echo $data['UNIT_PENUNJANG']; ?></td>
			<td align="center">
				<input type="radio" name="tndk<?php echo $no; ?>" id="tndk<?php echo $no; ?>"
				value="<?php echo $data['PENUNJANG_ID'] . '|' . $data['KEPATUHAN_IDENTIFIKASI_ID'] . '|' . $data['UNIT_ID'] . '|' . $data['JNS_ORDER'] . '|' . $data['NO_TARIF'] . '|1'; ?>"
				<?php if($data['SEBELUM_TINDAKAN'] == '1') echo 'checked="checked"'; ?>
				onclick="JavaScript : centang_opt('tndk<?php echo $no; ?>',this.value,'tndk','usr<?php echo $no; ?>',
				'tgl_edu_<?php echo $no; ?>');"
				/>&nbsp;Ya&nbsp;&nbsp;
				<input type="radio" name="tndk<?php echo $no; ?>" id="tndk<?php echo $no; ?>1"
				value="<?php echo $data['PENUNJANG_ID'] . '|' . $data['KEPATUHAN_IDENTIFIKASI_ID'] . '|' . $data['UNIT_ID'] . '|' . $data['JNS_ORDER'] . '|' . $data['NO_TARIF'] . '|0'; ?>"
				<?php if($data['SEBELUM_TINDAKAN'] == '0') echo 'checked="checked"'; ?>
				onclick="JavaScript : centang_opt('tndk<?php echo $no; ?>1',this.value,'tndk','usr<?php echo $no; ?>',
				'tgl_edu_<?php echo $no; ?>');"
				/>&nbsp;Tdk&nbsp;&nbsp;
				<input type="radio" name="tndk<?php echo $no; ?>" id="tndk<?php echo $no; ?>2"
				value="<?php echo $data['PENUNJANG_ID'] . '|' . $data['KEPATUHAN_IDENTIFIKASI_ID'] . '|' . $data['UNIT_ID'] . '|' . $data['JNS_ORDER'] . '|' . $data['NO_TARIF'] . '|2'; ?>"
				<?php if($data['SEBELUM_TINDAKAN'] == '2') echo 'checked="checked"'; ?>
				onclick="JavaScript : centang_opt('tndk<?php echo $no; ?>2',this.value,'tndk','usr<?php echo $no; ?>',
				'tgl_edu_<?php echo $no; ?>');"
				/>&nbsp;NA
			</td>
			<td><input type="text" name="tgl_edu_<?php echo $no; ?>" id="tgl_edu_<?php echo $no; ?>" size="10" class="text_dt"
				value="<?php $tgl_observasi = $data['TGL_OBSERVASI'];  
							if($tgl_observasi == '' or $tgl_observasi == '00/00/0000') $tgl_observasi = $tgl_skr;
							echo $tgl_observasi; ?>" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu<?php echo $no; ?>')" /></td>
			<td><div id="usr<?php echo $no; ?>"><?php echo $data['PENGUMPUL_DATA']; ?></div></td>
        </tr>
        <?
    }
    ?>
</table>
</form>
<table width="100%" border="0" height="50%" class="tableNav" >
            <tr >
                <td align="right" valign="middle" >
                    <div style="background-color:#fff; height:80%; width:30%">
                        <table width="100%" align="center" height="100%" class="tableNavSub">
                            <tr>
								<td align="center">
                                    <?php
                                    echo $pager->renderSummary();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?php
                                    echo $pager->renderFirst();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderPrev();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderNav();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderNext();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderLast();
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>

                </td>
            </tr>
        </table>
<div id="msg_ta"></div>		
<script language="JavaScript" >
function centang_opt(ck,id,fl,usr,dt){
	$.ajax({
		url: '/nsimrs/index.php?ajaxrequest=identifikasipenunjang',
		type: 'POST',
		async : false,
		data: {
			idx	: id,
			field : fl,
			dtx : document.getElementById(dt).value
		},
		success: function(data) {
			document.getElementById(usr).innerHTML = data;
		},
		timeout: 60
	});
}
</script>			