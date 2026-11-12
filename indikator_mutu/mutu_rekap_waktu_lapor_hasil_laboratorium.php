<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tahun = date('Y');
if (isset($_SESSION['whlklab_tahun']))
    $tahun = $_SESSION['whlklab_tahun'];
$bulan = date('m');
if (isset($_SESSION['whlklab_tahun']))
    $bulan = $_SESSION['whlklab_bulan'];
if (isset($_GET['tahun'])) {
    $tahun = $_GET['tahun'];
    $_SESSION['whlklab_tahun'] = $_GET['tahun'];
}
if (isset($_GET['bulan'])) {
    $bulan = $_GET['bulan'];
    $_SESSION['whlklab_bulan'] = $_GET['bulan'];
}
?>
<form name="search" method="get" action="index.php">
    <table class="tableform" border="0">
		<tr>
            <td>Tahun</td>
            <td><select name="tahun" class="text_dt" style="width:180px;" >
				<option value="2018" <?php if($tahun == '2018') echo 'selected="selected"'; ?> >2018</option>
				<option value="2019" <?php if($tahun == '2019') echo 'selected="selected"'; ?> >2019</option>
				<option value="2020" <?php if($tahun == '2020') echo 'selected="selected"'; ?> >2020</option>
				<option value="2021" <?php if($tahun == '2021') echo 'selected="selected"'; ?> >2021</option>
				<option value="2022" <?php if($tahun == '2022') echo 'selected="selected"'; ?> >2022</option>
			</select></td>
			<td>&nbsp;</td>
        </tr>
		<tr>
			<td>Bulan</td>
            <td><select name="bulan" class="text_dt" style="width:180px;">
				<option value="01" <?php if($bulan == '01') echo 'selected="selected"'; ?>>Januari</option>
				<option value="02" <?php if($bulan == '02') echo 'selected="selected"'; ?>>Februari</option>
				<option value="03" <?php if($bulan == '03') echo 'selected="selected"'; ?>>Maret</option>
				<option value="04" <?php if($bulan == '04') echo 'selected="selected"'; ?>>April</option>
				<option value="05" <?php if($bulan == '05') echo 'selected="selected"'; ?>>Mei</option>
				<option value="06" <?php if($bulan == '06') echo 'selected="selected"'; ?>>Juni</option>
				<option value="07" <?php if($bulan == '07') echo 'selected="selected"'; ?>>Juli</option>
				<option value="08" <?php if($bulan == '08') echo 'selected="selected"'; ?>>Agustus</option>
				<option value="09" <?php if($bulan == '09') echo 'selected="selected"'; ?>>September</option>
				<option value="10" <?php if($bulan == '10') echo 'selected="selected"'; ?>>Oktober</option>
				<option value="11" <?php if($bulan == '11') echo 'selected="selected"'; ?>>Nopember</option>
				<option value="12" <?php if($bulan == '12') echo 'selected="selected"'; ?>>Desember</option>
			</select></td>
			<td><input type="submit" value="cari" class="myButton" /></td>		
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_pasien = 'SELECT DATE_FORMAT(t_order.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				SUM(CASE WHEN TIME_TO_SEC(TIMEDIFF(t_order.TANGGAL_LAPOR,t_order.TANGGAL_PERIKSA)) < 1800
					THEN 1 ELSE 0 END) WAKTU_LAPOR_L30,
				SUM(CASE WHEN TIME_TO_SEC(TIMEDIFF(t_order.TANGGAL_LAPOR,t_order.TANGGAL_PERIKSA)) >= 1800
					THEN 1 ELSE 0 END) WAKTU_LAPOR_M30,
				COUNT(*) AS JML_LAPOR	
				FROM (SELECT tip.RAWAT_ID,tipt.NO_TARIF,
					tipt.TANGGAL_DAFTAR,
					tipt.TANGGAL_SAMPLING,
					tipt.TANGGAL_PERIKSA,
					tipt.TANGGAL_LAPOR,
					tip.UNIT_ID,NULL AS RUANG_ID,tip.NOMR,
					"" AS EXT_NAMA_UNIT,mtp.FORM_HASIL,
					GROUP_CONCAT(DISTINCT mtp.CH_REPORT) AS CH_REPORT
					FROM db_simrs.t_ipenunjang tip
					INNER JOIN db_simrs.t_ipenunjang_tarif tipt ON (tip.PENUNJANG_ID = tipt.PENUNJANG_ID)
					INNER JOIN db_simrs.m_tarif mtr ON (tipt.TARIF_ID = mtr.TARIF_ID)
					INNER JOIN db_simrs.m_tarif_group mtrg ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
					INNER JOIN db_simrs.m_tarif_pemeriksaan mtp ON (mtr.KODE_TARIF = mtp.KODE_TARIF)
					WHERE tip.JNS_ORDER = "IRJ"
					AND tipt.NO_TARIF IS NOT NULL
					AND tipt.HASIL_TES_KRITIS = "1" 
					AND DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%Y") = "' . $tahun .'"
					AND DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%m") = "' . $bulan .'"
					AND tipt.ST_BATAL IS NULL
					GROUP BY tip.RAWAT_ID,tipt.NO_TARIF,
					mtp.FORM_HASIL
					UNION
					SELECT tip.RAWAT_ID,tipt.NO_TARIF,
					tipt.TANGGAL_DAFTAR,
					tipt.TANGGAL_SAMPLING,
					tipt.TANGGAL_PERIKSA,
					tipt.TANGGAL_LAPOR,
					tip.UNIT_ID,NULL AS RUANG_ID,tip.NOMR,
					"Hemodialisa" AS EXT_NAMA_UNIT,mtp.FORM_HASIL,
					GROUP_CONCAT(DISTINCT mtp.CH_REPORT) AS CH_REPORT
					FROM t_ipenunjang tip
					INNER JOIN db_simrs.t_ipenunjang_tarif tipt ON (tip.PENUNJANG_ID = tipt.PENUNJANG_ID)
					INNER JOIN db_simrs.m_tarif mtr ON (tipt.TARIF_ID = mtr.TARIF_ID)
					INNER JOIN db_simrs.m_tarif_group mtrg ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
					INNER JOIN db_simrs.m_tarif_pemeriksaan mtp ON (mtr.KODE_TARIF = mtp.KODE_TARIF)
					WHERE tip.JNS_ORDER = "HRJ"
					AND tipt.NO_TARIF IS NOT NULL
					AND tipt.HASIL_TES_KRITIS = "1"
					AND DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%Y") = "' . $tahun .'"
					AND DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%m") = "' . $bulan .'"
					AND tipt.ST_BATAL IS NULL
					GROUP BY tip.RAWAT_ID,tipt.NO_TARIF,
					mtp.FORM_HASIL
					UNION
					SELECT tip.RAWAT_ID,tipt.NO_TARIF,
					tipt.TANGGAL_DAFTAR,
					tipt.TANGGAL_SAMPLING,
					tipt.TANGGAL_PERIKSA,
					tipt.TANGGAL_LAPOR,
					tip.UNIT_ID,NULL AS RUANG_ID,tip.NOMR,
					"Kamar Operasi" AS EXT_NAMA_UNIT,mtp.FORM_HASIL,
					GROUP_CONCAT(DISTINCT mtp.CH_REPORT) AS CH_REPORT
					FROM t_ipenunjang tip
					INNER JOIN db_simrs.t_ipenunjang_tarif tipt ON (tip.PENUNJANG_ID = tipt.PENUNJANG_ID)
					INNER JOIN db_simrs.m_tarif mtr ON (tipt.TARIF_ID = mtr.TARIF_ID)
					INNER JOIN db_simrs.m_tarif_group mtrg ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
					INNER JOIN db_simrs.m_tarif_pemeriksaan mtp ON (mtr.KODE_TARIF = mtp.KODE_TARIF)
					WHERE tip.JNS_ORDER = "ORJ"
					AND tipt.NO_TARIF IS NOT NULL
					AND tipt.HASIL_TES_KRITIS = "1"
					AND DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%Y") = "' . $tahun .'"
					AND DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%m") = "' . $bulan .'"
					AND tipt.ST_BATAL IS NULL
					GROUP BY tip.RAWAT_ID,tipt.NO_TARIF,
					mtp.FORM_HASIL
					UNION
					SELECT tip.RAWAT_ID,tipt.NO_TARIF,
					tipt.TANGGAL_DAFTAR,
					tipt.TANGGAL_SAMPLING,
					tipt.TANGGAL_PERIKSA,
					tipt.TANGGAL_LAPOR,
					NULL AS UNIT_ID,tip.RUANG_ID,tip.NOMR,
					"Kamar Operasi" AS EXT_NAMA_UNIT,mtp.FORM_HASIL,
					GROUP_CONCAT(DISTINCT mtp.CH_REPORT) AS CH_REPORT
					FROM t_ipenunjang tip
					INNER JOIN db_simrs.t_ipenunjang_tarif tipt ON (tip.PENUNJANG_ID = tipt.PENUNJANG_ID)
					INNER JOIN db_simrs.m_tarif mtr ON (tipt.TARIF_ID = mtr.TARIF_ID)
					INNER JOIN db_simrs.m_tarif_group mtrg ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
					INNER JOIN db_simrs.m_tarif_pemeriksaan mtp ON (mtr.KODE_TARIF = mtp.KODE_TARIF)
					WHERE tip.JNS_ORDER = "ORI"
					AND tipt.NO_TARIF IS NOT NULL
					AND tipt.HASIL_TES_KRITIS = "1"
					AND DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%Y") = "' . $tahun .'"
					AND DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%m") = "' . $bulan .'"
					AND tipt.ST_BATAL IS NULL
					GROUP BY tip.RAWAT_ID,tipt.NO_TARIF,
					mtp.FORM_HASIL
					UNION
					SELECT tip.RAWAT_ID,tipt.NO_TARIF,
					tipt.TANGGAL_DAFTAR,
					tipt.TANGGAL_SAMPLING,
					tipt.TANGGAL_PERIKSA,
					tipt.TANGGAL_LAPOR,
					NULL AS UNIT_ID,tip.RUANG_ID,tip.NOMR,
					"" AS EXT_NAMA_UNIT,mtp.FORM_HASIL,
					GROUP_CONCAT(DISTINCT mtp.CH_REPORT) AS CH_REPORT
					FROM t_ipenunjang tip
					INNER JOIN db_simrs.t_ipenunjang_tarif tipt ON (tip.PENUNJANG_ID = tipt.PENUNJANG_ID)
					INNER JOIN db_simrs.m_tarif mtr ON (tipt.TARIF_ID = mtr.TARIF_ID)
					INNER JOIN db_simrs.m_tarif_group mtrg ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
					INNER JOIN db_simrs.m_tarif_pemeriksaan mtp ON (mtr.KODE_TARIF = mtp.KODE_TARIF)
					WHERE tip.JNS_ORDER = "IRN"
					AND tipt.NO_TARIF IS NOT NULL
					AND tipt.HASIL_TES_KRITIS = "1"
					AND DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%Y") = "' . $tahun .'"
					AND DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%m") = "' . $bulan .'"
					AND tipt.ST_BATAL IS NULL
					GROUP BY tip.RAWAT_ID,tipt.NO_TARIF,
					mtp.FORM_HASIL
					UNION
					SELECT tip.RAWAT_ID,tipt.NO_TARIF,
					tipt.TANGGAL_DAFTAR,
					tipt.TANGGAL_SAMPLING,
					tipt.TANGGAL_PERIKSA,
					tipt.TANGGAL_LAPOR,
					NULL AS UNIT_ID,tip.RUANG_ID,tip.NOMR,
					"Hemodialisa" AS EXT_NAMA_UNIT,mtp.FORM_HASIL,
					GROUP_CONCAT(DISTINCT mtp.CH_REPORT) AS CH_REPORT
					FROM t_ipenunjang tip
					INNER JOIN db_simrs.t_ipenunjang_tarif tipt ON (tip.PENUNJANG_ID = tipt.PENUNJANG_ID)
					INNER JOIN db_simrs.m_tarif mtr ON (tipt.TARIF_ID = mtr.TARIF_ID)
					INNER JOIN db_simrs.m_tarif_group mtrg ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
					INNER JOIN db_simrs.m_tarif_pemeriksaan mtp ON (mtr.KODE_TARIF = mtp.KODE_TARIF)
					WHERE tip.JNS_ORDER = "HRI"
					AND tipt.NO_TARIF IS NOT NULL
					AND tipt.HASIL_TES_KRITIS = "1"
					AND DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%Y") = "' . $tahun .'"
					AND DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%m") = "' . $bulan .'"
					AND tipt.ST_BATAL IS NULL
					GROUP BY tip.RAWAT_ID,tipt.NO_TARIF,
					mtp.FORM_HASIL
					UNION
					SELECT tip.PENUNJANG_ID AS RAWAT_ID,tipt.NO_TARIF,
					tipt.TANGGAL_DAFTAR,
					tipt.TANGGAL_SAMPLING,
					tipt.TANGGAL_PERIKSA,
					wlh.TGL_LAPOR AS TANGGAL_LAPOR,
					NULL AS UNIT_ID,NULL AS RUANG_ID,tip.NO_PASIEN_PENUNJANG AS NOMR,
					"" AS EXT_NAMA_UNIT,mtp.FORM_HASIL,
					GROUP_CONCAT(DISTINCT mtp.CH_REPORT) AS CH_REPORT
					FROM t_ipenunjang tip
					INNER JOIN db_simrs.t_ipenunjang_tarif tipt ON (tip.PENUNJANG_ID = tipt.PENUNJANG_ID)
					INNER JOIN db_simrs.m_tarif mtr ON (tipt.TARIF_ID = mtr.TARIF_ID)
					INNER JOIN db_simrs.m_tarif_group mtrg ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
					INNER JOIN db_simrs.m_tarif_pemeriksaan mtp ON (mtr.KODE_TARIF = mtp.KODE_TARIF)
					INNER JOIN db_repository.mutu_waktu_lapor_hasil_laboratorium wlh
					ON (
						tip.PENUNJANG_ID = wlh.RAWAT_ID
						AND tipt.NO_TARIF = wlh.NO_TARIF
						AND mtp.FORM_HASIL = wlh.FORM_HASIL
					)
					WHERE tip.JNS_ORDER = "APS"
					AND tipt.NO_TARIF IS NOT NULL
					AND tipt.HASIL_TES_KRITIS = "1"
					AND DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%Y") = "' . $tahun .'"
					AND DATE_FORMAT(tipt.TANGGAL_DAFTAR,"%m") = "' . $bulan .'"
					AND tipt.ST_BATAL IS NULL
					GROUP BY tip.RAWAT_ID,tipt.NO_TARIF,
					mtp.FORM_HASIL
				) t_order
				GROUP BY DATE_FORMAT(t_order.TANGGAL_DAFTAR,"%d/%m/%Y") 
				ORDER BY t_order.TANGGAL_DAFTAR';
?>
<form name="formedukasi">
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
		<th>Tanggal</th>
         <th>&#60; 30 Menit</th>
		<th>&#8925; 30 Menit</th>
		<th>Keterangan</th>
    </tr>
    <?
    $no = 1;
    $get_pasien = mysql_query($qry_pasien) or die(mysql_error());
    while ($data = mysql_fetch_array($get_pasien)) {
        ?>
        <tr>
            <td align="center"><?php echo $no; ?></td>
            <td align="center"><?php echo $data['TANGGAL_DAFTAR']; ?></td>
            <td align="right"><?php echo currFormat($data['WAKTU_LAPOR_L30']) ?></td>
			<td align="right"><?php echo currFormat($data['WAKTU_LAPOR_M30']) ?></td>
			<td>&nbsp;</td>
        </tr>
        <?
    $no++; }
    ?>
</table>
</form>	