<style>
.list_isi{
	height:550px;
}
</style>
<?php
function setVal($vl){
	$ret = $vl;
	if($vl == '') $ret = 'NA';
	return $ret;
}
$tahun = date('Y');
if (isset($_SESSION['rkip_tahun']))
    $tahun = $_SESSION['rkip_tahun'];
$bulan = date('m');
if (isset($_SESSION['rkip_tahun']))
    $bulan = $_SESSION['rkip_bulan'];
if (isset($_GET['tahun'])) {
    $tahun = $_GET['tahun'];
    $_SESSION['rkip_tahun'] = $_GET['tahun'];
}
if (isset($_GET['bulan'])) {
    $bulan = $_GET['bulan'];
    $_SESSION['rkip_bulan'] = $_GET['bulan'];
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
$qry_pasien = '	SELECT CASE WHEN WEEK(TGL_OBSERVASI,5) - WEEK(DATE_SUB(TGL_OBSERVASI, 
					INTERVAL DAYOFMONTH(TGL_OBSERVASI)-1 DAY),5)+1 = 1 THEN "Minggu 1"
						WHEN WEEK(TGL_OBSERVASI,5) - WEEK(DATE_SUB(TGL_OBSERVASI, 
					INTERVAL DAYOFMONTH(TGL_OBSERVASI)-1 DAY),5)+1 = 2 THEN "Minggu 2"
						WHEN WEEK(TGL_OBSERVASI,5) - WEEK(DATE_SUB(TGL_OBSERVASI, 
					INTERVAL DAYOFMONTH(TGL_OBSERVASI)-1 DAY),5)+1 = 3 THEN "Minggu 3"
						WHEN WEEK(TGL_OBSERVASI,5) - WEEK(DATE_SUB(TGL_OBSERVASI, 
					INTERVAL DAYOFMONTH(TGL_OBSERVASI)-1 DAY),5)+1 = 4 THEN "Minggu 4"
						WHEN WEEK(TGL_OBSERVASI,5) - WEEK(DATE_SUB(TGL_OBSERVASI, 
					INTERVAL DAYOFMONTH(TGL_OBSERVASI)-1 DAY),5)+1 = 5 THEN "Minggu 5"
					END AS PEKAN,
				mun.NAMA_UNIT,mur.NAMA_RUANG,
				SUM(PEMBERIAN_OBAT) AS PEMBERIAN_OBAT,
				SUM(PEMBERIAN_NUTRISI) AS PEMBERIAN_NUTRISI,
				SUM(PEMBERIAN_DARAH)AS PEMBERIAN_DARAH,
				SUM(PENGAMBILAN_SPESIMEN) AS PENGAMBILAN_SPESIMEN,
				SUM(SEBELUM_TINDAKAN) AS SEBELUM_TINDAKAN
				FROM (
					SELECT t_kip.RAWAT_ID,
					t_kip.TGL_OBSERVASI,
					t_kip.UNIT_ID,
					t_kip.RUANG_ID,
					t_kip.PEMBERIAN_OBAT,
					t_kip.PEMBERIAN_NUTRISI,	
					t_kip.PEMBERIAN_DARAH,
					t_kip.PENGAMBILAN_SPESIMEN,
					t_kip.SEBELUM_TINDAKAN
					FROM (
						SELECT irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
						mkj.TGL_OBSERVASI,
						mkj.UNIT_ID,
						NULL AS RUANG_ID,
						CASE WHEN mkj.SEBELUM_PEMBERIAN_OBAT <> 2 THEN mkj.SEBELUM_PEMBERIAN_OBAT END AS PEMBERIAN_OBAT,
						NULL AS PEMBERIAN_NUTRISI,	
						CASE WHEN mkj.SEBELUM_TRANSFUSI <> 2 THEN mkj.SEBELUM_TRANSFUSI END AS PEMBERIAN_DARAH,
						NULL AS PENGAMBILAN_SPESIMEN,
						CASE WHEN mkj.SEBELUM_TINDAKAN <> 2 THEN mkj.SEBELUM_TINDAKAN END AS SEBELUM_TINDAKAN
						FROM db_simrs.t_irja irj
						INNER JOIN db_repository.mutu_kepatuhan_identifikasi_irj_igd mkj
						ON (irj.IRJA_ID = mkj.RAWAT_ID)
						WHERE DATE_FORMAT(mkj.TGL_OBSERVASI,"%Y") = "' . $tahun . '"
						AND DATE_FORMAT(mkj.TGL_OBSERVASI,"%m") = "' . $bulan . '"
						UNION ALL
						SELECT irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
						mki.TGL_OBSERVASI,
						NULL AS UNIT_ID,
						mki.RUANG_ID,
						CASE WHEN mki.SEBELUM_PEMBERIAN_OBAT <> 2 THEN mki.SEBELUM_PEMBERIAN_OBAT END AS PEMBERIAN_OBAT,
						NULL AS PEMBERIAN_NUTRISI,	
						CASE WHEN mki.SEBELUM_TRANSFUSI <> 2 THEN mki.SEBELUM_TRANSFUSI END AS PEMBERIAN_DARAH,
						NULL AS PENGAMBILAN_SPESIMEN,
						CASE WHEN mki.SEBELUM_TINDAKAN <> 2 THEN mki.SEBELUM_TINDAKAN END AS SEBELUM_TINDAKAN
						FROM db_simrs.t_irna irn
						INNER JOIN db_repository.mutu_kepatuhan_identifikasi_iri mki
						ON (irn.IRNA_ID = mki.RAWAT_ID)
						WHERE DATE_FORMAT(mki.TGL_OBSERVASI,"%Y") = "' . $tahun . '"
						AND DATE_FORMAT(mki.TGL_OBSERVASI,"%m") = "' . $bulan . '"
						UNION ALL
						SELECT irp.IRJA_ID AS RAWAT_ID,irp.NOMR,
						mkp.TGL_OBSERVASI,
						mkp.UNIT_ID,
						NULL AS RUANG_ID,
						NULL AS PEMBERIAN_OBAT,
						CASE WHEN mkp.UNIT_ID IN (18) AND mkp.SEBELUM_TINDAKAN <> 2 THEN mkp.SEBELUM_TINDAKAN END AS PEMBERIAN_NUTRISI,	
						NULL AS PEMBERIAN_DARAH,
						CASE WHEN mkp.UNIT_ID IN (45,17) AND mkp.SEBELUM_TINDAKAN <> 2 THEN mkp.SEBELUM_TINDAKAN END AS PENGAMBILAN_SPESIMEN,
						CASE WHEN mkp.UNIT_ID IN (31,41,51,47,52,40) AND mkp.SEBELUM_TINDAKAN <> 2 THEN mkp.SEBELUM_TINDAKAN END AS SEBELUM_TINDAKAN
						FROM db_simrs.t_irja irp
						INNER JOIN db_repository.mutu_kepatuhan_identifikasi_ipenunjang mkp
						ON (irp.IRJA_ID = mkp.RAWAT_ID)
						WHERE mkp.JNS_ORDER <> "APS" 
						AND DATE_FORMAT(mkp.TGL_OBSERVASI,"%Y") = "' . $tahun . '"
						AND DATE_FORMAT(mkp.TGL_OBSERVASI,"%m") = "' . $bulan . '"
					) t_kip
					UNION ALL
					SELECT mkp.RAWAT_ID,
					mkp.TGL_OBSERVASI,
					mkp.UNIT_ID,
					NULL AS RUANG_ID,
					NULL AS PEMBERIAN_OBAT,
					CASE WHEN mkp.UNIT_ID IN (18) AND mkp.SEBELUM_TINDAKAN <> 2 THEN mkp.SEBELUM_TINDAKAN END AS PEMBERIAN_NUTRISI,	
					NULL AS PEMBERIAN_DARAH,
					CASE WHEN mkp.UNIT_ID IN (45,17) AND mkp.SEBELUM_TINDAKAN <> 2 THEN mkp.SEBELUM_TINDAKAN END AS PENGAMBILAN_SPESIMEN,
					CASE WHEN mkp.UNIT_ID IN (31,41,51,47,52,40) AND mkp.SEBELUM_TINDAKAN <> 2 THEN mkp.SEBELUM_TINDAKAN END AS SEBELUM_TINDAKAN
					FROM db_repository.mutu_kepatuhan_identifikasi_ipenunjang mkp
					WHERE mkp.JNS_ORDER = "APS" 
					AND DATE_FORMAT(mkp.TGL_OBSERVASI,"%Y") = "' . $tahun . '"
					AND DATE_FORMAT(mkp.TGL_OBSERVASI,"%m") = "' . $bulan . '"
				) x_kip
				LEFT JOIN db_simrs.m_unit mun ON (x_kip.UNIT_ID = mun.UNIT_ID)
				LEFT JOIN db_simrs.m_ruang mur ON (x_kip.RUANG_ID = mur.RUANG_ID)
				GROUP BY mun.NAMA_UNIT,mur.NAMA_RUANG,PEKAN
				ORDER BY mun.NAMA_UNIT,mur.NAMA_RUANG,PEKAN';
?>
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
		<th>Unit Observasi</th>
		<th>Minggu</th>
        <th>Pemberian Obat</th>
        <th>Pemberian Nutrisi</th>
        <th>Pemberian Darah</th>
		<th>Pengambilan Spesimen</th>
		<th>Sebelum Tindakan</th>
		<th>Denominator</th>
		<th>Skor</th>
    </tr>
    <?
    $no = 1;
    $get_data = mysql_query($qry_pasien) or die(mysql_error());
	while ($data = mysql_fetch_array($get_data)) {
        ?>
        <tr>
            <td align="center"><?php echo $no; ?></td>
			<td><?php $nama_unit = $data['NAMA_UNIT'];
				if($nama_unit == '') $nama_unit = $data['NAMA_RUANG'];
				echo $nama_unit; ?></td>
			<td><?php echo $data['PEKAN']; ?></td>
            <td align="center"><?php echo setVal($data['PEMBERIAN_OBAT']); ?></td>	
			<td align="center"><?php echo setVal($data['PEMBERIAN_NUTRISI']); ?></td>	
			<td align="center"><?php echo setVal($data['PEMBERIAN_DARAH']); ?></td>	
			<td align="center"><?php echo setVal($data['PENGAMBILAN_SPESIMEN']); ?></td>	
			<td align="center"><?php echo setVal($data['SEBELUM_TINDAKAN']); ?></td>	
			<td align="center">
				<?php
					
				?>
			</td>
			<td align="center">
				<?php
					
				?>
			</td>
        </tr>
        <?
    $no++; }
    ?>
</table>	