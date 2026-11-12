<?php
$tahun = date("Y");
if (isset($_SESSION['pendaftaranreportrekapkunjungan_tahun']))
    $tahun = $_SESSION['pendaftaranreportrekapkunjungan_tahun'];
$bulan = date("m");
if (isset($_SESSION['pendaftaranreportrekapkunjungan_bulan']))
    $bulan = $_SESSION['pendaftaranreportrekapkunjungan_bulan'];
if (isset($_GET['tahun'])) {
    $tahun = $_GET['tahun'];
    $_SESSION['pendaftaranreportrekapkunjungan_tahun'] = $_GET['tahun'];
}
if (isset($_GET['bulan'])) {
    $bulan = $_GET['bulan'];
    $_SESSION['pendaftaranreportrekapkunjungan_bulan'] = $_GET['bulan'];
}

?>
<form name="search" method="get" action="index.php">
    <table class="tableform" border="0" >
        <tr>
            <td>Tahun</td>
            <td><select name="tahun" id="tahun" class="text_dt">
			<option value="2020" <? if($tahun=="2020") echo "selected"?>>2020</option>
			<option value="2021" <? if($tahun=="2021") echo "selected"?>>2021</option>
			<option value="2022" <? if($tahun=="2022") echo "selected"?>>2022</option>
			<option value="2023" <? if($tahun=="2023") echo "selected"?>>2023</option>
			<option value="2024" <? if($tahun=="2024") echo "selected"?>>2024</option>
			<option value="2025" <? if($tahun=="2025") echo "selected"?>>2025</option>
			</select></td>
       </tr>
		<tr>
			<td>Bulan</td>
            <td><select name="bulan" id="bulan" class="text_dt">
			<option value="01" <? if($bulan=="01") echo"selected"?>>Januri</option>
			<option value="02" <? if($bulan=="02") echo"selected"?>>Febuari</option>
			<option value="03" <? if($bulan=="03") echo"selected"?>>Maret</option>
			<option value="04" <? if($bulan=="04") echo"selected"?>>April</option>
			<option value="05" <? if($bulan=="05") echo"selected"?>>Mei</option>
			<option value="06" <? if($bulan=="06") echo"selected"?>>Juni</option>
			<option value="07" <? if($bulan=="07") echo"selected"?>>Juli</option>
			<option value="08" <? if($bulan=="08") echo"selected"?>>Agustus</option>
			<option value="09" <? if($bulan=="09") echo"selected"?>>September</option>
			<option value="10" <? if($bulan=="10") echo"selected"?>>Oktober</option>
			<option value="11" <? if($bulan=="11") echo"selected"?>>Nopember</option>
			<option value="12" <? if($bulan=="12") echo"selected"?>>Desember</option>
			</select></td>
			<td>&nbsp;</td>
            <td align="right"><input type="submit" value="cari" class="myButton" />&nbsp;
			<!--
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>
			-->
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$arr_icu_tekanan_negatif_ventilator = '87';
$arr_isolasi_tekanan_negatif = '86,88,47,97';
$arr_isolasi_non_tekanan_negatif = '89';

$qry_kunjungan = 'SELECT t_rawat_mn.TANGGAL_DAFTAR,
SUM(t_rawat_mn.ICU_TEKANAN_NEGATIF_VENTILATOR_SUSPECT_LAKI) AS ICU_TEKANAN_NEGATIF_VENTILATOR_SUSPECT_LAKI,
SUM(t_rawat_mn.ICU_TEKANAN_NEGATIF_VENTILATOR_SUSPECT_PEREMPUAN) AS ICU_TEKANAN_NEGATIF_VENTILATOR_SUSPECT_PEREMPUAN,
SUM(t_rawat_mn.ICU_TEKANAN_NEGATIF_TANPA_VENTILATOR_SUSPECT_LAKI) AS ICU_TEKANAN_NEGATIF_TANPA_VENTILATOR_SUSPECT_LAKI,
SUM(t_rawat_mn.ICU_TEKANAN_NEGATIF_TANPA_VENTILATOR_SUSPECT_PEREMPUAN) AS ICU_TEKANAN_NEGATIF_TANPA_VENTILATOR_SUSPECT_PEREMPUAN,
SUM(t_rawat_mn.ICU_NON_TEKANAN_NEGATIF_VENTILATOR_SUSPECT_LAKI) AS ICU_NON_TEKANAN_NEGATIF_VENTILATOR_SUSPECT_LAKI,
SUM(t_rawat_mn.ICU_NON_TEKANAN_NEGATIF_VENTILATOR_SUSPECT_PEREMPUAN) AS ICU_NON_TEKANAN_NEGATIF_VENTILATOR_SUSPECT_PEREMPUAN,
SUM(t_rawat_mn.ICU_NON_TEKANAN_NEGATIF_TANPA_VENTILATOR_SUSPECT_LAKI) AS ICU_NON_TEKANAN_NEGATIF_TANPA_VENTILATOR_SUSPECT_LAKI,
SUM(t_rawat_mn.ICU_NON_TEKANAN_NEGATIF_TANPA_VENTILATOR_SUSPECT_PEREMPUAN) AS ICU_NON_TEKANAN_NEGATIF_TANPA_VENTILATOR_SUSPECT_PEREMPUAN,
SUM(t_rawat_mn.ISOLASI_TEKANAN_NEGATIF_SUSPECT_LAKI) AS ISOLASI_TEKANAN_NEGATIF_SUSPECT_LAKI,
SUM(t_rawat_mn.ISOLASI_TEKANAN_NEGATIF_SUSPECT_PEREMPUAN) AS ISOLASI_TEKANAN_NEGATIF_SUSPECT_PEREMPUAN,
SUM(t_rawat_mn.ISOLASI_NON_TEKANAN_NEGATIF_SUSPECT_LAKI) AS ISOLASI_NON_TEKANAN_NEGATIF_SUSPECT_LAKI,
SUM(t_rawat_mn.ISOLASI_NON_TEKANAN_NEGATIF_SUSPECT_PEREMPUAN) AS ISOLASI_NON_TEKANAN_NEGATIF_SUSPECT_PEREMPUAN,

SUM(t_rawat_mn.ICU_TEKANAN_NEGATIF_VENTILATOR_CONFIRM_LAKI) AS ICU_TEKANAN_NEGATIF_VENTILATOR_CONFIRM_LAKI,
SUM(t_rawat_mn.ICU_TEKANAN_NEGATIF_VENTILATOR_CONFIRM_PEREMPUAN) AS ICU_TEKANAN_NEGATIF_VENTILATOR_CONFIRM_PEREMPUAN,
SUM(t_rawat_mn.ICU_TEKANAN_NEGATIF_TANPA_VENTILATOR_CONFIRM_LAKI) AS ICU_TEKANAN_NEGATIF_TANPA_VENTILATOR_CONFIRM_LAKI,
SUM(t_rawat_mn.ICU_TEKANAN_NEGATIF_TANPA_VENTILATOR_CONFIRM_PEREMPUAN) AS ICU_TEKANAN_NEGATIF_TANPA_VENTILATOR_CONFIRM_PEREMPUAN,
SUM(t_rawat_mn.ICU_NON_TEKANAN_NEGATIF_VENTILATOR_CONFIRM_LAKI) AS ICU_NON_TEKANAN_NEGATIF_VENTILATOR_CONFIRM_LAKI,
SUM(t_rawat_mn.ICU_NON_TEKANAN_NEGATIF_VENTILATOR_CONFIRM_PEREMPUAN) AS ICU_NON_TEKANAN_NEGATIF_VENTILATOR_CONFIRM_PEREMPUAN,
SUM(t_rawat_mn.ICU_NON_TEKANAN_NEGATIF_TANPA_VENTILATOR_CONFIRM_LAKI) AS ICU_NON_TEKANAN_NEGATIF_TANPA_VENTILATOR_CONFIRM_LAKI,
SUM(t_rawat_mn.ICU_NON_TEKANAN_NEGATIF_TANPA_VENTILATOR_CONFIRM_PEREMPUAN) AS ICU_NON_TEKANAN_NEGATIF_TANPA_VENTILATOR_CONFIRM_PEREMPUAN,
SUM(t_rawat_mn.ISOLASI_TEKANAN_NEGATIF_CONFIRM_LAKI) AS ISOLASI_TEKANAN_NEGATIF_CONFIRM_LAKI,
SUM(t_rawat_mn.ISOLASI_TEKANAN_NEGATIF_CONFIRM_PEREMPUAN) AS ISOLASI_TEKANAN_NEGATIF_CONFIRM_PEREMPUAN,
SUM(t_rawat_mn.ISOLASI_NON_TEKANAN_NEGATIF_CONFIRM_LAKI) AS ISOLASI_NON_TEKANAN_NEGATIF_CONFIRM_LAKI,
SUM(t_rawat_mn.ISOLASI_NON_TEKANAN_NEGATIF_CONFIRM_PEREMPUAN) AS ISOLASI_NON_TEKANAN_NEGATIF_CONFIRM_PEREMPUAN
FROM(

	SELECT DATE_FORMAT(t_irna_opname.TANGGAL_OPNAME,"%Y-%m-%d") AS TANGGAL_DAFTAR,
	COUNT(case when t_irna.ruang_id in (' . $arr_icu_tekanan_negatif_ventilator . ') and m_pasien.jns_kelamin="L" and ST_COVID19="1" then t_irna_opname.IRNA_ID end) AS ICU_TEKANAN_NEGATIF_VENTILATOR_SUSPECT_LAKI,
	COUNT(case when t_irna.ruang_id in (' . $arr_icu_tekanan_negatif_ventilator . ') and m_pasien.jns_kelamin="L" and ST_COVID19="2" then t_irna_opname.IRNA_ID end) AS ICU_TEKANAN_NEGATIF_VENTILATOR_CONFIRM_LAKI,
	COUNT(case when t_irna.ruang_id in (' . $arr_icu_tekanan_negatif_ventilator . ') and m_pasien.jns_kelamin="P" and ST_COVID19="1" then t_irna_opname.IRNA_ID end) AS ICU_TEKANAN_NEGATIF_VENTILATOR_SUSPECT_PEREMPUAN,
	COUNT(case when t_irna.ruang_id in (' . $arr_icu_tekanan_negatif_ventilator . ') and m_pasien.jns_kelamin="P" and ST_COVID19="2" then t_irna_opname.IRNA_ID end) AS ICU_TEKANAN_NEGATIF_VENTILATOR_CONFIRM_PEREMPUAN,
	0 AS ICU_TEKANAN_NEGATIF_TANPA_VENTILATOR_SUSPECT_LAKI,
	0 AS ICU_TEKANAN_NEGATIF_TANPA_VENTILATOR_CONFIRM_LAKI,
	0 AS ICU_TEKANAN_NEGATIF_TANPA_VENTILATOR_SUSPECT_PEREMPUAN,
	0 AS ICU_TEKANAN_NEGATIF_TANPA_VENTILATOR_CONFIRM_PEREMPUAN,
	0 AS ICU_NON_TEKANAN_NEGATIF_VENTILATOR_SUSPECT_LAKI,
	0 AS ICU_NON_TEKANAN_NEGATIF_VENTILATOR_CONFIRM_LAKI,
	0 AS ICU_NON_TEKANAN_NEGATIF_VENTILATOR_SUSPECT_PEREMPUAN,
	0 AS ICU_NON_TEKANAN_NEGATIF_VENTILATOR_CONFIRM_PEREMPUAN,
	0 AS ICU_NON_TEKANAN_NEGATIF_TANPA_VENTILATOR_SUSPECT_LAKI,
	0 AS ICU_NON_TEKANAN_NEGATIF_TANPA_VENTILATOR_CONFIRM_LAKI,
	0 AS ICU_NON_TEKANAN_NEGATIF_TANPA_VENTILATOR_SUSPECT_PEREMPUAN,
	0 AS ICU_NON_TEKANAN_NEGATIF_TANPA_VENTILATOR_CONFIRM_PEREMPUAN,
	COUNT(case when t_irna.ruang_id in (' . $arr_isolasi_tekanan_negatif . ') and m_pasien.jns_kelamin="L" and ST_COVID19="1" then t_irna_opname.IRNA_ID end) AS ISOLASI_TEKANAN_NEGATIF_SUSPECT_LAKI,
	COUNT(case when t_irna.ruang_id in (' . $arr_isolasi_tekanan_negatif . ') and m_pasien.jns_kelamin="L" and ST_COVID19="2" then t_irna_opname.IRNA_ID end) AS ISOLASI_TEKANAN_NEGATIF_CONFIRM_LAKI,
	COUNT(case when t_irna.ruang_id in (' . $arr_isolasi_tekanan_negatif . ') and m_pasien.jns_kelamin="P" and ST_COVID19="1" then t_irna_opname.IRNA_ID end) AS ISOLASI_TEKANAN_NEGATIF_SUSPECT_PEREMPUAN,
	COUNT(case when t_irna.ruang_id in (' . $arr_isolasi_tekanan_negatif . ') and m_pasien.jns_kelamin="P" and ST_COVID19="2" then t_irna_opname.IRNA_ID end) AS ISOLASI_TEKANAN_NEGATIF_CONFIRM_PEREMPUAN,
	COUNT(case when t_irna.ruang_id in (' . $arr_isolasi_non_tekanan_negatif . ') and m_pasien.jns_kelamin="L" and ST_COVID19="1" then t_irna_opname.IRNA_ID end) AS ISOLASI_NON_TEKANAN_NEGATIF_SUSPECT_LAKI,
	COUNT(case when t_irna.ruang_id in (' . $arr_isolasi_non_tekanan_negatif . ') and m_pasien.jns_kelamin="L" and ST_COVID19="2" then t_irna_opname.IRNA_ID end) AS ISOLASI_NON_TEKANAN_NEGATIF_CONFIRM_LAKI,
	COUNT(case when t_irna.ruang_id in (' . $arr_isolasi_non_tekanan_negatif . ') and m_pasien.jns_kelamin="P" and ST_COVID19="1" then t_irna_opname.IRNA_ID end) AS ISOLASI_NON_TEKANAN_NEGATIF_SUSPECT_PEREMPUAN,
	COUNT(case when t_irna.ruang_id in (' . $arr_isolasi_non_tekanan_negatif . ') and m_pasien.jns_kelamin="P" and ST_COVID19="2" then t_irna_opname.IRNA_ID end) AS ISOLASI_NON_TEKANAN_NEGATIF_CONFIRM_PEREMPUAN
	FROM t_irna_opname 
	inner join t_irna on (t_irna_opname.irna_id=t_irna.irna_id)
	inner join m_pasien on (t_irna.nomr=m_pasien.nomr)
	WHERE DATE_FORMAT(t_irna_opname.TANGGAL_OPNAME,"%m/%Y") = "' . $bulan . '/' . $tahun . '"
	and t_irna.ruang_id in (' . $arr_icu_tekanan_negatif_ventilator . ',' . $arr_isolasi_tekanan_negatif . ',' . $arr_isolasi_non_tekanan_negatif . ')
	and t_irna.ST_COVID19_KOMORBIT="1"
	group by DATE_FORMAT(t_irna_opname.TANGGAL_OPNAME,"%Y-%m-%d") 
	
	UNION ALL
	
	SELECT DATE_FORMAT(t_rawat.TANGGAL_MASUK,"%Y-%m-%d") AS TANGGAL_DAFTAR,
	COUNT(CASE WHEN t_irna.RUANG_ID IN (' . $arr_icu_tekanan_negatif_ventilator . ') AND m_pasien.JNS_KELAMIN="L" and ST_COVID19="1" THEN t_rawat.IRNA_ID END) AS ICU_TEKANAN_NEGATIF_VENTILATOR_SUSPECT_LAKI,
	COUNT(CASE WHEN t_irna.RUANG_ID IN (' . $arr_icu_tekanan_negatif_ventilator . ') AND m_pasien.JNS_KELAMIN="L" and ST_COVID19="2" THEN t_rawat.IRNA_ID END) AS ICU_TEKANAN_NEGATIF_VENTILATOR_CONFIRM_LAKI,
	COUNT(CASE WHEN t_irna.RUANG_ID IN (' . $arr_icu_tekanan_negatif_ventilator . ') AND m_pasien.JNS_KELAMIN="P" and ST_COVID19="1" THEN t_rawat.IRNA_ID END) AS ICU_TEKANAN_NEGATIF_VENTILATOR_SUSPECT_PEREMPUAN,
	COUNT(CASE WHEN t_irna.RUANG_ID IN (' . $arr_icu_tekanan_negatif_ventilator . ') AND m_pasien.JNS_KELAMIN="P" and ST_COVID19="2" THEN t_rawat.IRNA_ID END) AS ICU_TEKANAN_NEGATIF_VENTILATOR_CONFIRM_PEREMPUAN,
	0 AS ICU_TEKANAN_NEGATIF_TANPA_VENTILATOR_SUSPECT_LAKI,
	0 AS ICU_TEKANAN_NEGATIF_TANPA_VENTILATOR_CONFIRM_LAKI,
	0 AS ICU_TEKANAN_NEGATIF_TANPA_VENTILATOR_SUSPECT_PEREMPUAN,
	0 AS ICU_TEKANAN_NEGATIF_TANPA_VENTILATOR_CONFIRM_PEREMPUAN,
	0 AS ICU_NON_TEKANAN_NEGATIF_VENTILATOR_SUSPECT_LAKI,
	0 AS ICU_NON_TEKANAN_NEGATIF_VENTILATOR_CONFIRM_LAKI,
	0 AS ICU_NON_TEKANAN_NEGATIF_VENTILATOR_SUSPECT_PEREMPUAN,
	0 AS ICU_NON_TEKANAN_NEGATIF_VENTILATOR_CONFIRM_PEREMPUAN,
	0 AS ICU_NON_TEKANAN_NEGATIF_TANPA_VENTILATOR_SUSPECT_LAKI,
	0 AS ICU_NON_TEKANAN_NEGATIF_TANPA_VENTILATOR_CONFIRM_LAKI,
	0 AS ICU_NON_TEKANAN_NEGATIF_TANPA_VENTILATOR_SUSPECT_PEREMPUAN,
	0 AS ICU_NON_TEKANAN_NEGATIF_TANPA_VENTILATOR_CONFIRM_PEREMPUAN,
	COUNT(CASE WHEN t_irna.RUANG_ID IN (' . $arr_isolasi_tekanan_negatif . ') AND m_pasien.JNS_KELAMIN="L" AND ST_COVID19="1" THEN t_rawat.IRNA_ID END) AS ISOLASI_TEKANAN_NEGATIF_SUSPECT_LAKI,
	COUNT(CASE WHEN t_irna.RUANG_ID IN (' . $arr_isolasi_tekanan_negatif . ') AND m_pasien.JNS_KELAMIN="L" AND ST_COVID19="2" THEN t_rawat.IRNA_ID END) AS ISOLASI_TEKANAN_NEGATIF_CONFIRM_LAKI,
	COUNT(CASE WHEN t_irna.RUANG_ID IN (' . $arr_isolasi_tekanan_negatif . ') AND m_pasien.JNS_KELAMIN="P" AND ST_COVID19="1" THEN t_rawat.IRNA_ID END) AS ISOLASI_TEKANAN_NEGATIF_SUSPECT_PEREMPUAN,
	COUNT(CASE WHEN t_irna.RUANG_ID IN (' . $arr_isolasi_tekanan_negatif . ') AND m_pasien.JNS_KELAMIN="P" AND ST_COVID19="2" THEN t_rawat.IRNA_ID END) AS ISOLASI_TEKANAN_NEGATIF_CONFIRM_PEREMPUAN,
	COUNT(CASE WHEN t_irna.RUANG_ID IN (' . $arr_isolasi_non_tekanan_negatif . ') AND m_pasien.JNS_KELAMIN="L" AND ST_COVID19="1" THEN t_rawat.IRNA_ID END) AS ISOLASI_NON_TEKANAN_NEGATIF_SUSPECT_LAKI,
	COUNT(CASE WHEN t_irna.RUANG_ID IN (' . $arr_isolasi_non_tekanan_negatif . ') AND m_pasien.JNS_KELAMIN="L" AND ST_COVID19="2" THEN t_rawat.IRNA_ID END) AS ISOLASI_NON_TEKANAN_NEGATIF_CONFIRM_LAKI,
	COUNT(CASE WHEN t_irna.RUANG_ID IN (' . $arr_isolasi_non_tekanan_negatif . ') AND m_pasien.JNS_KELAMIN="P" AND ST_COVID19="1" THEN t_rawat.IRNA_ID END) AS ISOLASI_NON_TEKANAN_NEGATIF_SUSPECT_PEREMPUAN,
	COUNT(CASE WHEN t_irna.RUANG_ID IN (' . $arr_isolasi_non_tekanan_negatif . ') AND m_pasien.JNS_KELAMIN="P" AND ST_COVID19="2" THEN t_rawat.IRNA_ID END) AS ISOLASI_NON_TEKANAN_NEGATIF_CONFIRM_PEREMPUAN
	FROM (
		SELECT t_irna_log.IRNA_ID,
			(SELECT t.TANGGAL_MASUK FROM t_irna_log t 
			WHERE t.IRNA_ID = t_irna_log.IRNA_ID
			AND t.RUANG_ID_BARU = t_irna_log.RUANG_ID_ASAL
			AND t.JNS_UPDATE = "R"
			AND t.IRNA_LOG_ID < t_irna_log.IRNA_LOG_ID
			ORDER BY t.TANGGAL_MASUK DESC LIMIT 1) AS TANGGAL_MASUK,
			t_irna_log.TANGGAL_KELUAR
		FROM t_irna_log
		WHERE DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m/%Y") = "' . $bulan . '/' . $tahun . '"
		AND t_irna_log.JNS_UPDATE = "R"
		AND t_irna_log.RUANG_ID_BARU IS NULL
	) t_rawat
	INNER JOIN t_irna ON (t_rawat.IRNA_ID = t_irna.IRNA_ID)
	INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
	WHERE DATE_FORMAT(t_rawat.TANGGAL_MASUK,"%d%m%Y") = DATE_FORMAT(t_rawat.TANGGAL_KELUAR,"%d%m%Y")
	AND t_irna.RUANG_ID IN (' . $arr_icu_tekanan_negatif_ventilator . ',' . $arr_isolasi_tekanan_negatif . ',' . $arr_isolasi_non_tekanan_negatif . ')
	AND t_irna.ST_COVID19_KOMORBIT = "1"
	GROUP BY DATE_FORMAT(t_rawat.TANGGAL_MASUK,"%Y-%m-%d")
) t_rawat_mn
GROUP BY t_rawat_mn.TANGGAL_DAFTAR';
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());	
?>
<table width="100%" border="1" class="tableData" id="tfhover">
  <tr>
     <th rowspan="3" width="5">No</th>
    <th rowspan="3">Tanggal</th>
    <th colspan="4" scope="col">Jml ICU Tekanan Negatif dengan Ventilator</th>
    <th colspan="4" scope="col">Jml ICU Tekanan Negatif tanpa Ventilator</th>
    <th colspan="4" scope="col">Jml ICU Tanpa Tekanan Negatif dengan Ventilator</th>
	<th colspan="4" scope="col">Jml ICU Tanpa Tekanan Negatif Tanpa Ventilator</th>
	<th colspan="4" scope="col">Jml Isolasi Tekanan Negatif</th>
	<th colspan="4" scope="col">Jml Isolasi Tanpa Tekanan Negatif</th>
    <th rowspan="3" scope="col">Action</th>
  </tr>
  <tr>
    <th colspan="2">Suspect</th>
    <th colspan="2">Comfirm</th>
	<th colspan="2">Suspect</th>
    <th colspan="2">Comfirm</th>
	<th colspan="2">Suspect</th>
    <th colspan="2">Comfirm</th>
	<th colspan="2">Suspect</th>
    <th colspan="2">Comfirm</th>
    <th colspan="2">Suspect</th>
    <th colspan="2">Comfirm</th>
    <th colspan="2">Suspect</th>
    <th colspan="2">Comfirm</th>
  </tr>
  <tr>
    <th >L</th>
    <th >P</th>
	<th >L</th>
    <th >P</th>
	<th >L</th>
    <th >P</th>
	<th >L</th>
    <th >P</th>
	<th >L</th>
    <th >P</th>
	<th >L</th>
    <th >P</th>
	<th >L</th>
    <th >P</th>
    <th >L</th>
    <th >P</th>
	<th >L</th>
    <th >P</th>
    <th >L</th>
    <th >P</th>
	<th >L</th>
    <th >P</th>
	<th >L</th>
    <th >P</th>
  </tr>
<?php $no = 1; 
$total = 0;
while($dat_kunjungan = mysql_fetch_array($get_kunjungan)){ ?>  
  <tr>
    <td scope="row" align="center"><?php echo $no; ?></td>
    <td><?php echo $dat_kunjungan['TANGGAL_DAFTAR']; ?></td>
    <td align="right"><?php echo currFormat($dat_kunjungan['ICU_TEKANAN_NEGATIF_VENTILATOR_SUSPECT_LAKI']); ?></td>
	<td align="right"><?php echo currFormat($dat_kunjungan['ICU_TEKANAN_NEGATIF_VENTILATOR_CONFIRM_LAKI']); ?></td>
	<td align="right"><?php echo currFormat($dat_kunjungan['ICU_TEKANAN_NEGATIF_VENTILATOR_SUSPECT_PEREMPUAN']); ?></td>
	<td align="right"><?php echo currFormat($dat_kunjungan['ICU_TEKANAN_NEGATIF_VENTILATOR_CONFIRM_PEREMPUAN']); ?></td>
	<td align="right"><?php echo currFormat($dat_kunjungan['ICU_TEKANAN_NEGATIF_TANPA_VENTILATOR_SUSPECT_LAKI']); ?></td>
	<td align="right"><?php echo currFormat($dat_kunjungan['ICU_TEKANAN_NEGATIF_TANPA_VENTILATOR_CONFIRM_LAKI']); ?></td>
    <td align="right"><?php echo currFormat($dat_kunjungan['ICU_TEKANAN_NEGATIF_TANPA_VENTILATOR_SUSPECT_PEREMPUAN']); ?></td>
	<td align="right"><?php echo currFormat($dat_kunjungan['ICU_TEKANAN_NEGATIF_TANPA_VENTILATOR_CONFIRM_PEREMPUAN']); ?></td>
	<td align="right"><?php echo currFormat($dat_kunjungan['ICU_NON_TEKANAN_NEGATIF_VENTILATOR_SUSPECT_LAKI']); ?></td>
	<td align="right"><?php echo currFormat($dat_kunjungan['ICU_NON_TEKANAN_NEGATIF_VENTILATOR_CONFIRM_LAKI']); ?></td>
	<td align="right"><?php echo currFormat($dat_kunjungan['ICU_NON_TEKANAN_NEGATIF_VENTILATOR_SUSPECT_PEREMPUAN']); ?></td>
	<td align="right"><?php echo currFormat($dat_kunjungan['ICU_NON_TEKANAN_NEGATIF_VENTILATOR_CONFIRM_PEREMPUAN']); ?></td>
	<td align="right"><?php echo currFormat($dat_kunjungan['ICU_NON_TEKANAN_NEGATIF_TANPA_VENTILATOR_SUSPECT_LAKI']); ?></td>
	<td align="right"><?php echo currFormat($dat_kunjungan['ICU_NON_TEKANAN_NEGATIF_TANPA_VENTILATOR_CONFIRM_LAKI']); ?></td>
	<td align="right"><?php echo currFormat($dat_kunjungan['ICU_NON_TEKANAN_NEGATIF_TANPA_VENTILATOR_SUSPECT_PEREMPUAN']); ?></td>
	<td align="right"><?php echo currFormat($dat_kunjungan['ICU_NON_TEKANAN_NEGATIF_TANPA_VENTILATOR_CONFIRM_PEREMPUAN']); ?></td>
	<td align="right"><?php echo currFormat($dat_kunjungan['ISOLASI_TEKANAN_NEGATIF_SUSPECT_LAKI']); ?></td>
	<td align="right"><?php echo currFormat($dat_kunjungan['ISOLASI_TEKANAN_NEGATIF_CONFIRM_LAKI']); ?></td>
    <td align="right"><?php echo currFormat($dat_kunjungan['ISOLASI_TEKANAN_NEGATIF_SUSPECT_PEREMPUAN']); ?></td>
	<td align="right"><?php echo currFormat($dat_kunjungan['ISOLASI_TEKANAN_NEGATIF_CONFIRM_PEREMPUAN']); ?></td>
	<td align="right"><?php echo currFormat($dat_kunjungan['ISOLASI_NON_TEKANAN_NEGATIF_SUSPECT_LAKI']); ?></td>
	<td align="right"><?php echo currFormat($dat_kunjungan['ISOLASI_NON_TEKANAN_NEGATIF_CONFIRM_LAKI']); ?></td>
	<td align="right"><?php echo currFormat($dat_kunjungan['ISOLASI_NON_TEKANAN_NEGATIF_SUSPECT_PEREMPUAN']); ?></td>
	<td align="right"><?php echo currFormat($dat_kunjungan['ISOLASI_NON_TEKANAN_NEGATIF_CONFIRM_PEREMPUAN']); ?></td>
	<td width="100px" align="center"><input type="button" value="kirim" class="myButton"
	onclick="kirim('<?php echo $dat_kunjungan['TANGGAL_DAFTAR']; ?>',
	<?php echo $dat_kunjungan['ICU_TEKANAN_NEGATIF_VENTILATOR_SUSPECT_LAKI']; ?>,
	<?php echo $dat_kunjungan['ICU_TEKANAN_NEGATIF_VENTILATOR_CONFIRM_LAKI']; ?>,
	<?php echo $dat_kunjungan['ICU_TEKANAN_NEGATIF_VENTILATOR_SUSPECT_PEREMPUAN']; ?>,
	<?php echo $dat_kunjungan['ICU_TEKANAN_NEGATIF_VENTILATOR_CONFIRM_PEREMPUAN']; ?>,
	<?php echo $dat_kunjungan['ICU_TEKANAN_NEGATIF_TANPA_VENTILATOR_SUSPECT_LAKI']; ?>,
	<?php echo $dat_kunjungan['ICU_TEKANAN_NEGATIF_TANPA_VENTILATOR_CONFIRM_LAKI']; ?>,
	<?php echo $dat_kunjungan['ICU_TEKANAN_NEGATIF_TANPA_VENTILATOR_SUSPECT_PEREMPUAN']; ?>,
	<?php echo $dat_kunjungan['ICU_TEKANAN_NEGATIF_TANPA_VENTILATOR_CONFIRM_PEREMPUAN']; ?>,
	<?php echo $dat_kunjungan['ICU_NON_TEKANAN_NEGATIF_VENTILATOR_SUSPECT_LAKI']; ?>,
	<?php echo $dat_kunjungan['ICU_NON_TEKANAN_NEGATIF_VENTILATOR_CONFIRM_LAKI']; ?>,
	<?php echo $dat_kunjungan['ICU_NON_TEKANAN_NEGATIF_VENTILATOR_SUSPECT_PEREMPUAN']; ?>,
	<?php echo $dat_kunjungan['ICU_NON_TEKANAN_NEGATIF_VENTILATOR_CONFIRM_PEREMPUAN']; ?>,
	<?php echo $dat_kunjungan['ICU_NON_TEKANAN_NEGATIF_TANPA_VENTILATOR_SUSPECT_LAKI']; ?>,
	<?php echo $dat_kunjungan['ICU_NON_TEKANAN_NEGATIF_TANPA_VENTILATOR_CONFIRM_LAKI']; ?>,
	<?php echo $dat_kunjungan['ICU_NON_TEKANAN_NEGATIF_TANPA_VENTILATOR_SUSPECT_PEREMPUAN']; ?>,
	<?php echo $dat_kunjungan['ICU_NON_TEKANAN_NEGATIF_TANPA_VENTILATOR_CONFIRM_PEREMPUAN']; ?>,
	<?php echo $dat_kunjungan['ISOLASI_TEKANAN_NEGATIF_SUSPECT_LAKI']; ?>,
	<?php echo $dat_kunjungan['ISOLASI_TEKANAN_NEGATIF_CONFIRM_LAKI']; ?>,
	<?php echo $dat_kunjungan['ISOLASI_TEKANAN_NEGATIF_SUSPECT_PEREMPUAN']; ?>,
	<?php echo $dat_kunjungan['ISOLASI_TEKANAN_NEGATIF_CONFIRM_PEREMPUAN']; ?>,
	<?php echo $dat_kunjungan['ISOLASI_NON_TEKANAN_NEGATIF_SUSPECT_LAKI']; ?>,
	<?php echo $dat_kunjungan['ISOLASI_NON_TEKANAN_NEGATIF_CONFIRM_LAKI']; ?>,
	<?php echo $dat_kunjungan['ISOLASI_NON_TEKANAN_NEGATIF_SUSPECT_PEREMPUAN']; ?>,
	<?php echo $dat_kunjungan['ISOLASI_NON_TEKANAN_NEGATIF_CONFIRM_PEREMPUAN']; ?>);"></td>
  </tr>
 <?php $no++; } ?> 
<!-- <tr>
	<td colspan="14" align="right">Total :&nbsp;&nbsp;</td>
	<td align="right"><?php echo currFormat($total); ?></td>
  </tr>-->
</table>
<form id="xls_export" name="xls_export" method="post">
            <input type="hidden" name="page_to_excel" value="1" />
            <input type="hidden" name="tahun" value="<?php echo $tahun; ?>" />
            <input type="hidden" name="bulan" value="<?php echo $bulan; ?>" />
            <input type="hidden" name="xlsfile" value="pendaftaran/xls_rekap_kunjungan_pasien_klinik.php" />
            <input type="hidden" name="xlsname" value="rpt_kunjungan_pasien_klinik.xls" />            
        </form>
<script>
function kirim( vtanggal,
vicu_tekanan_negatif_ventilator_suspect_l,
vicu_tekanan_negatif_ventilator_suspect_p,
vicu_tekanan_negatif_ventilator_confirm_l,
vicu_tekanan_negatif_ventilator_confirm_p,
vicu_tekanan_negatif_tanpa_ventilator_suspect_l,
vicu_tekanan_negatif_tanpa_ventilator_suspect_p,
vicu_tekanan_negatif_tanpa_ventilator_confirm_l,
vicu_tekanan_negatif_tanpa_ventilator_confirm_p,
vicu_non_tekanan_negatif_ventilator_suspect_l,
vicu_non_tekanan_negatif_ventilator_suspect_p,
vicu_non_tekanan_negatif_ventilator_confirm_l,
vicu_non_tekanan_negatif_ventilator_confirm_p,
vicu_non_tekanan_negatif_tanpa_ventilator_suspect_l,
vicu_non_tekanan_negatif_tanpa_ventilator_suspect_p,
vicu_non_tekanan_negatif_tanpa_ventilator_confirm_l,
vicu_non_tekanan_negatif_tanpa_ventilator_confirm_p,
visolasi_tekanan_negatif_suspect_l,
visolasi_tekanan_negatif_suspect_p,
visolasi_tekanan_negatif_confirm_l,
visolasi_tekanan_negatif_confirm_p,
visolasi_non_tekanan_negatif_suspect_l,
visolasi_non_tekanan_negatif_suspect_p,
visolasi_non_tekanan_negatif_confirm_l,
visolasi_non_tekanan_negatif_confirm_p){

$.ajax({
  type: "POST",
  url: "http://<?php echo $_SERVER['HTTP_HOST'];?>/nsimrs/shared/bridging_yankes.php?sirskemkes=pasiendirawattanpakomorbid",
  data: {tanggal:vtanggal,
  icu_tekanan_negatif_ventilator_suspect_l:vicu_tekanan_negatif_ventilator_suspect_l,
  icu_tekanan_negatif_ventilator_suspect_p:vicu_tekanan_negatif_ventilator_suspect_p,
  icu_tekanan_negatif_ventilator_confirm_l:vicu_tekanan_negatif_ventilator_confirm_l,
  icu_tekanan_negatif_ventilator_confirm_p:vicu_tekanan_negatif_ventilator_confirm_p,
  icu_tekanan_negatif_tanpa_ventilator_suspect_l:vicu_tekanan_negatif_tanpa_ventilator_suspect_l,
  icu_tekanan_negatif_tanpa_ventilator_suspect_p:vicu_tekanan_negatif_tanpa_ventilator_suspect_p,
  icu_tekanan_negatif_tanpa_ventilator_confirm_l:vicu_tekanan_negatif_tanpa_ventilator_confirm_l,
  icu_tekanan_negatif_tanpa_ventilator_confirm_p:vicu_tekanan_negatif_tanpa_ventilator_confirm_p,
  icu_non_tekanan_negatif_ventilator_suspect_l:vicu_non_tekanan_negatif_ventilator_suspect_l,
  icu_non_tekanan_negatif_ventilator_suspect_p:vicu_non_tekanan_negatif_ventilator_suspect_p,
  icu_non_tekanan_negatif_ventilator_confirm_l:vicu_non_tekanan_negatif_ventilator_confirm_l,
  icu_non_tekanan_negatif_ventilator_confirm_p:vicu_non_tekanan_negatif_ventilator_confirm_p,
  icu_non_tekanan_negatif_tanpa_ventilator_suspect_l:vicu_non_tekanan_negatif_tanpa_ventilator_suspect_l,
  icu_non_tekanan_negatif_tanpa_ventilator_suspect_p:vicu_non_tekanan_negatif_tanpa_ventilator_suspect_p,
  icu_non_tekanan_negatif_tanpa_ventilator_confirm_l:vicu_non_tekanan_negatif_tanpa_ventilator_confirm_l,
  icu_non_tekanan_negatif_tanpa_ventilator_confirm_p:vicu_non_tekanan_negatif_tanpa_ventilator_confirm_p,
  isolasi_tekanan_negatif_suspect_l:visolasi_tekanan_negatif_suspect_l,
  isolasi_tekanan_negatif_suspect_p:visolasi_tekanan_negatif_suspect_p,
  isolasi_tekanan_negatif_confirm_l:visolasi_tekanan_negatif_confirm_l,
  isolasi_tekanan_negatif_confirm_p:visolasi_tekanan_negatif_confirm_p,
  isolasi_non_tekanan_negatif_suspect_l:visolasi_non_tekanan_negatif_suspect_l,
  isolasi_non_tekanan_negatif_suspect_p:visolasi_non_tekanan_negatif_suspect_p,
  isolasi_non_tekanan_negatif_confirm_l:visolasi_non_tekanan_negatif_confirm_l,
  isolasi_non_tekanan_negatif_confirm_p:visolasi_non_tekanan_negatif_confirm_p},
  success: function(data) {
                           alert (data);
                            }
}); return false
}
</script>
