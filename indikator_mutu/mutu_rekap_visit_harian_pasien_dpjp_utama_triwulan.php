<style>
.list_isi{
	height:550px;
}
</style>
<?php
include('shared/array_filter_report_tarif.php');
$arr_visite = getStringArrayFilter('visite');

$tahun = date('Y');
if (isset($_SESSION['visithariandpjp_tahun']))
    $tahun = $_SESSION['visithariandpjp_tahun'];
if (isset($_GET['tahun'])) {
    $tahun = $_GET['tahun'];
    $_SESSION['visithariandpjp_tahun'] = $_GET['tahun'];
}

$dokter_id = '';
if (isset($_SESSION['visithariandpjp_dokter_id']))
		$dokter_id = $_SESSION['visithariandpjp_dokter_id'];
	
if (isset($_GET['dokter_id'])) {
    $dokter_id = $_GET['dokter_id'];
	$_SESSION['visithariandpjp_dokter_id'] = $dokter_id;
}

$arr_bulan['01'] = 'Januari';	
$arr_bulan['02'] = 'Februari';	
$arr_bulan['03'] = 'Maret';	
$arr_bulan['04'] = 'April';	
$arr_bulan['05'] = 'Mei';	
$arr_bulan['06'] = 'Juni';	
$arr_bulan['07'] = 'Juli';	
$arr_bulan['08'] = 'Agustus';	
$arr_bulan['09'] = 'September';	
$arr_bulan['10'] = 'Oktober';	
$arr_bulan['11'] = 'Nopember';	
$arr_bulan['12'] = 'Desember';	
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
        </tr>
		<tr>
		<td>Dokter</td>
			<td><select name="dokter_id" class="text_dt" style="width:210px;">
				<option value=""> - </option>
				<?php echo getDokterRanap($dokter_id); ?>
			</select></td>		
		</tr>	
		<tr>
			<td>&nbsp;</td>
            <td><input type="submit" value="cari" class="myButton" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_pasien = 'SELECT DATE_FORMAT(x_vst.TGL_TARIF,"%m") AS BULAN,
				COUNT(DISTINCT	
					CASE WHEN (CONVERT(x_vst.JAM_TARIF,UNSIGNED INTEGER) * 60) 
						+ CONVERT(x_vst.MENIT_TARIF,UNSIGNED INTEGER) < 660 THEN x_vst.IRNA_TARIF_ID END 
					) AS VISIT_L11,
				COUNT(DISTINCT	
					CASE WHEN (CONVERT(x_vst.JAM_TARIF,UNSIGNED INTEGER) * 60) 
						+ CONVERT(x_vst.MENIT_TARIF,UNSIGNED INTEGER) >= 660 
						AND (CONVERT(x_vst.JAM_TARIF,UNSIGNED INTEGER) * 60) 
						+ CONVERT(x_vst.MENIT_TARIF,UNSIGNED INTEGER) <= 780
						THEN x_vst.IRNA_TARIF_ID END 
					) AS VISIT_B1113,	
				COUNT(DISTINCT	
					CASE WHEN (CONVERT(x_vst.JAM_TARIF,UNSIGNED INTEGER) * 60) 
						+ CONVERT(x_vst.MENIT_TARIF,UNSIGNED INTEGER) > 780 THEN x_vst.IRNA_TARIF_ID END 
					) AS VISIT_M13,		
				COUNT(DISTINCT x_vst.IRNA_TARIF_ID) AS J_VISIT
				FROM (
					SELECT t_vst.IRNA_TARIF_ID,
					t_vst.IRNA_ID,
					STR_TO_DATE(DATE_FORMAT(t_vst.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") AS TGL_TARIF,
					SUBSTRING_INDEX(DATE_FORMAT(t_vst.TGL_TARIF,"%H:%i"),":",1) AS JAM_TARIF,
					SUBSTRING_INDEX(DATE_FORMAT(t_vst.TGL_TARIF,"%H:%i"),":",-1) AS MENIT_TARIF,
					t_vst.PEGAWAI_ID,
					t_vst.RUANG_ID,
					t_irna.PEGAWAI_ID AS DPJP_UTAMA,
					t_irna.PASIEN_KELUAR,
					t_irna_log.PEGAWAI_ID AS DPJP_UTAMA_PINDAH,
					t_irna_log.TANGGAL_UPDATE AS TGL_KELUAR_PINDAH
					FROM (	
						SELECT t_irna_tarif.IRNA_TARIF_ID,
						t_irna_tarif.IRNA_ID,
						t_irna_tarif.TGL_TARIF,
						CASE WHEN t_irna_tarif.PEGAWAI_PELAKSANA_ID IS NOT NULL AND t_irna_tarif.PEGAWAI_PELAKSANA_ID <> 0
								THEN t_irna_tarif.PEGAWAI_PELAKSANA_ID ELSE t_irna_tarif.PEGAWAI_ID
						END AS PEGAWAI_ID,
						t_irna_tarif.RUANG_ID
						FROM t_irna_tarif
						INNER JOIN m_tarif
						ON (t_irna_tarif.TARIF_ID = m_tarif.TARIF_ID) 
						WHERE DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%Y") = "' . $tahun . '"  
						AND t_irna_tarif.NO_TARIF IS NOT NULL
						AND (t_irna_tarif.ST_BAYAR = "" OR t_irna_tarif.ST_BAYAR = "Lunas") 
						AND m_tarif.KODE_TARIF_GROUP IN (' . $arr_visite . ')
					) t_vst	
					LEFT JOIN t_irna ON (t_vst.IRNA_ID = t_irna.IRNA_ID AND t_vst.PEGAWAI_ID = t_irna.PEGAWAI_ID)
					LEFT JOIN t_irna_log ON (t_vst.IRNA_ID = t_irna_log.IRNA_ID
						AND t_vst.PEGAWAI_ID = t_irna_log.PEGAWAI_ID
						AND t_irna_log.JNS_UPDATE = "R" 
						AND t_irna_log.RUANG_ID_ASAL IS NOT NULL
						AND t_irna_log.RUANG_ID_BARU IS NOT NULL 
						AND t_irna_log.TANGGAL_KELUAR IS NOT NULL)	
					WHERE 1
				) x_vst
				INNER JOIN t_irna ON (x_vst.IRNA_ID = t_irna.IRNA_ID)
				INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (x_vst.RUANG_ID = m_ruang.RUANG_ID)
				WHERE 1 AND (x_vst.DPJP_UTAMA IS NOT NULL OR (x_vst.DPJP_UTAMA_PINDAH IS NOT NULL
								AND x_vst.TGL_TARIF <= x_vst.TGL_KELUAR_PINDAH))';
if (!empty($dokter_id)) {
    $qry_pasien = $qry_pasien . ' AND x_vst.DPJP_UTAMA = "' . $dokter_id . '" ';
}								
$qry_pasien .= 'GROUP BY DATE_FORMAT(x_vst.TGL_TARIF,"%m")			
				ORDER BY DATE_FORMAT(x_vst.TGL_TARIF,"%m")';
?>
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th rowspan="2">No</th>
		<th rowspan="2">Bulan</th>
	  <th colspan="6">Waktu Visite</th>
		<th rowspan="2">Jumlah Visit</th>
  </tr>
  <tr>
    <th>< 11.00</th>
    <th>%</th>
    <th>11.00 - 13.00</th>
    <th>%</th>
    <th>> 13.00</th>
    <th>%</th>
  </tr>
    <?
    $no = 1;
    $get_pasien = mysql_query($qry_pasien) or die(mysql_error());
	while($data = mysql_fetch_array($get_pasien)){
	?>
            <td align="center"><?php echo $no; ?></td>
			<td><?php echo $arr_bulan[$data['BULAN']]; ?></td>
            <td align="right"><?php echo currFormat($data['VISIT_L11']); ?></td>
			<td align="right"><?php $persenl11 = ($data['VISIT_L11'] / $data['J_VISIT']) * 100;
								echo currFormat($persenl11); ?></td>
			<td align="right"><?php echo currFormat($data['VISIT_B1113']); ?></td>
			<td align="right"><?php $persenb1113 = ($data['VISIT_B1113'] / $data['J_VISIT']) * 100;
								echo currFormat($persenb1113); ?></td>
			<td align="right"><?php echo currFormat($data['VISIT_M13']); ?></td>
			<td align="right"><?php $persenm13 = ($data['VISIT_M13'] / $data['J_VISIT']) * 100;
								echo currFormat($persenm13); ?></td>						
			<td align="right"><?php echo currFormat($data['J_VISIT']); ?></td>
        </tr>
        <?
    $no++;
	}
    ?>
</table>