<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tahun = date('Y');
if (isset($_SESSION['ranapsearchrekapvisit_tahun']))
    $tahun = $_SESSION['ranapsearchrekapvisit_tahun'];
$bulan = date('m');
if (isset($_SESSION['ranapsearchrekapvisit_tahun']))
    $bulan = $_SESSION['ranapsearchrekapvisit_bulan'];
if (isset($_GET['tahun'])) {
    $tahun = $_GET['tahun'];
    $_SESSION['ranapsearchrekapvisit_tahun'] = $_GET['tahun'];
}
if (isset($_GET['bulan'])) {
    $bulan = $_GET['bulan'];
    $_SESSION['ranapsearchrekapvisit_bulan'] = $_GET['bulan'];
}

$ruang_id = '';
if (isset($_SESSION['ranapsearchrekapvisit_ruang_id']))
		$ruang_id = $_SESSION['ranapsearchrekapvisit_ruang_id'];

if (isset($_GET['ruang_id'])) {
    $ruang_id = $_GET['ruang_id'];
	$_SESSION['ranapsearchrekapvisit_ruang_id'] = $ruang_id;
}
?>
<form name="search" method="get" action="index.php">
    <table class="tableform" border="0" >
        <tr>
            <td>Tahun</td>
            <td><select name="tahun" class="text_dt" style="width:100px;" >
				<option value="2016" <?php if($tahun == '2016') echo 'selected="selected"'; ?> >2016</option>
				<option value="2017" <?php if($tahun == '2017') echo 'selected="selected"'; ?> >2017</option>
				<option value="2018" <?php if($tahun == '2018') echo 'selected="selected"'; ?> >2018</option>
				<option value="2019" <?php if($tahun == '2019') echo 'selected="selected"'; ?> >2019</option>
				<option value="2020" <?php if($tahun == '2020') echo 'selected="selected"'; ?> >2020</option>
				<option value="2021" <?php if($tahun == '2021') echo 'selected="selected"'; ?> >2021</option>
				<option value="2022" <?php if($tahun == '2022') echo 'selected="selected"'; ?> >2022</option>
			</select></td>
			<td>Ruang Rawat</td>
			<td><select name="ruang_id" class="text_dt" style="width:260px;">
				<option value=""> - </option>
				<?php echo getBangsal($ruang_id); ?>
			</select>	
        </tr>
		<tr>
			<td>Bulan</td>
            <td><select name="bulan" class="text_dt" style="width:100px;" >
				<option value="01" <?php if($bulan == '01') echo 'selected="selected"'; ?> >Januari</option>
				<option value="02" <?php if($bulan == '02') echo 'selected="selected"'; ?> >Pebruari</option>
				<option value="03" <?php if($bulan == '03') echo 'selected="selected"'; ?> >Maret</option>
				<option value="04" <?php if($bulan == '04') echo 'selected="selected"'; ?> >April</option>
				<option value="05" <?php if($bulan == '05') echo 'selected="selected"'; ?> >Mei</option>
				<option value="06" <?php if($bulan == '06') echo 'selected="selected"'; ?> >Juni</option>
				<option value="07" <?php if($bulan == '07') echo 'selected="selected"'; ?> >Juli</option>
				<option value="08" <?php if($bulan == '08') echo 'selected="selected"'; ?> >Agustus</option>
				<option value="09" <?php if($bulan == '09') echo 'selected="selected"'; ?> >September</option>
				<option value="10" <?php if($bulan == '10') echo 'selected="selected"'; ?> >Oktober</option>
				<option value="11" <?php if($bulan == '11') echo 'selected="selected"'; ?> >Nopember</option>
				<option value="12" <?php if($bulan == '12') echo 'selected="selected"'; ?> >Desember</option>
			</select></td>
            <td colspan="2" align="right"><input type="submit" value="cari" class="myButton" />&nbsp;
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_filter_ruang = '';
if(!empty($ruang_id))
	$qry_filter_ruang = 'AND m_ruang.BANGSAL = "' . $ruang_id . '" ';	
$qry_rawat = 'SELECT COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "01" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_01,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "02" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_02,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "03" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_03,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "04" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_04,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "05" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_05,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "06" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_06,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "07" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_07,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "08" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_08,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "09" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_09,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "10" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_10,
				
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "11" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_11,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "12" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_12,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "13" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_13,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "14" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_14,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "15" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_15,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "16" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_16,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "17" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_17,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "18" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_18,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "19" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_19,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "20" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_20,
				
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "21" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_21,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "22" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_22,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "23" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_23,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "24" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_24,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "25" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_25,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "26" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_26,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "27" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_27,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "28" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_28,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "29" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_29,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "30" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_30,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "31" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_31,
				COUNT(t_irna_tarif.IRNA_TARIF_ID) AS JUMLAH,
				m_pegawai.NAMA_PEGAWAI
				FROM t_irna_tarif
				INNER JOIN m_tarif ON (t_irna_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN t_irna ON (t_irna_tarif.IRNA_ID = t_irna.IRNA_ID)
				INNER JOIN m_ruang ON (t_irna_tarif.RUANG_ID = m_ruang.RUANG_ID)
				LEFT JOIN m_pegawai ON (t_irna_tarif.PEGAWAI_PELAKSANA_ID = m_pegawai.PEGAWAI_ID)
				WHERE DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%Y") = ' . $tahun . '
				AND DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%m") = ' . $bulan . '
				AND t_irna_tarif.NO_TARIF IS NOT NULL AND t_irna_tarif.ST_BAYAR <> "Batal"
				AND t_irna.ST_BATAL IS NULL AND m_tarif.KODE_TARIF_GROUP IN ("52")
				' . $qry_filter_ruang . '
				GROUP BY m_pegawai.NAMA_PEGAWAI
				ORDER BY m_pegawai.NAMA_PEGAWAI';
$extparam = '&tahun=' . $tahun . '&bulan=' . $bulan;
include('rawatinap/ranap_list_report_visit_dokter.php');
?>
