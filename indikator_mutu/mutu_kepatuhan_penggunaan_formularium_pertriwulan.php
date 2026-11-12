<style>
.list_isi{
	height:550px;
}
</style>
<?php
$connect = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
mysql_select_db($database_3, $connect) or die(mysql_error());

$tahun = date('Y');
if (isset($_SESSION['rkpfpd_tahun']))
    $tahun = $_SESSION['rkpfpd_tahun'];
if (isset($_GET['tahun'])) {
    $tahun = $_GET['tahun'];
    $_SESSION['rkpfpd_tahun'] = $_GET['tahun'];
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
            <td><select name="tahun" class="text_dt" style="width:100px;" >
				<option value="2018" <?php if($tahun == '2018') echo 'selected="selected"'; ?> >2018</option>
				<option value="2019" <?php if($tahun == '2019') echo 'selected="selected"'; ?> >2019</option>
				<option value="2020" <?php if($tahun == '2020') echo 'selected="selected"'; ?> >2020</option>
				<option value="2021" <?php if($tahun == '2021') echo 'selected="selected"'; ?> >2021</option>
				<option value="2022" <?php if($tahun == '2022') echo 'selected="selected"'; ?> >2022</option>
			</select></td>
        </tr>
		<tr>	
			<td align="right" colspan="2"><input type="submit" value="cari" class="myButton" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_pasien = 'SELECT CASE WHEN BULAN = "01" THEN "I"
						WHEN BULAN = "02" THEN "I"
						WHEN BULAN = "03" THEN "I"
						WHEN BULAN = "04" THEN "II"
						WHEN BULAN = "05" THEN "II"
						WHEN BULAN = "06" THEN "II"
						WHEN BULAN = "07" THEN "III"
						WHEN BULAN = "08" THEN "III"
						WHEN BULAN = "09" THEN "III"
						WHEN BULAN = "10" THEN "IV"
						WHEN BULAN = "11" THEN "IV"
						WHEN BULAN = "12" THEN "IV"
				END AS TRIWULAN, 
				BULAN,
				SUM(FORMULARIUM) AS FORMULARIUM,
				SUM(NON_FORMULARIUM) AS NON_FORMULARIUM,
				SUM(JML_OBAT) AS JML_OBAT,
				COUNT(DISTINCT NO_PENGELUARAN) AS JML_RESEP
				FROM (
					SELECT DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%m") AS BULAN,
					t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.INSTANSI_PENGIRIM,
					COUNT(DISTINCT CASE WHEN m_persediaan_farmasi.FORMULARIUM = "1" 
							OR m_persediaan_farmasi.FORMULARIUM_NASIONAL = "1"
							THEN m_persediaan_farmasi.PERSEDIAAN_ID END) AS FORMULARIUM,
					COUNT(DISTINCT CASE WHEN (m_persediaan_farmasi.FORMULARIUM = ""
							OR m_persediaan_farmasi.FORMULARIUM IS NULL)
							AND (m_persediaan_farmasi.FORMULARIUM_NASIONAL = ""
							OR m_persediaan_farmasi.FORMULARIUM_NASIONAL IS NULL)
							THEN m_persediaan_farmasi.PERSEDIAAN_ID END) AS NON_FORMULARIUM,
					COUNT(DISTINCT m_persediaan_farmasi.PERSEDIAAN_ID) AS JML_OBAT		
					FROM t_farmasi_apotik_pengeluaran  
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN t_rajal_resep_detail ON (t_farmasi_apotik_pengeluaran_detail.RAJAL_RESEP_DETAIL_ID = t_rajal_resep_detail.RAJAL_RESEP_DETAIL_ID)
					INNER JOIN t_rajal_resep ON (t_rajal_resep_detail.RAJAL_RESEP_ID = t_rajal_resep.RAJAL_RESEP_ID)
					INNER JOIN m_persediaan_farmasi ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					WHERE t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL 
					AND t_farmasi_apotik_pengeluaran.JENIS_PENGELUARAN = "1"
					AND DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%Y") = "' . $tahun . '"
					AND (m_persediaan_farmasi.ALKES = "" OR m_persediaan_farmasi.ALKES IS NULL)
					GROUP BY DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%m"),
					t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					t_farmasi_apotik_pengeluaran.INSTANSI_PENGIRIM
					UNION ALL
					SELECT DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%m") AS BULAN,
					t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					TRIM(SUBSTRING_INDEX(t_farmasi_apotik_pengeluaran.INSTANSI_PENGIRIM,"Kelas",1)) INSTANSI_PENGIRIM ,
					COUNT(DISTINCT CASE WHEN m_persediaan_farmasi.FORMULARIUM = "1" 
							OR m_persediaan_farmasi.FORMULARIUM_NASIONAL = "1"
							THEN m_persediaan_farmasi.PERSEDIAAN_ID END) AS FORMULARIUM,
					COUNT(DISTINCT CASE WHEN (m_persediaan_farmasi.FORMULARIUM = ""
							OR m_persediaan_farmasi.FORMULARIUM IS NULL)
							AND (m_persediaan_farmasi.FORMULARIUM_NASIONAL = ""
							OR m_persediaan_farmasi.FORMULARIUM_NASIONAL IS NULL)
							THEN m_persediaan_farmasi.PERSEDIAAN_ID END) AS NON_FORMULARIUM,
					COUNT(DISTINCT m_persediaan_farmasi.PERSEDIAAN_ID) AS JML_OBAT
					FROM t_farmasi_apotik_pengeluaran  
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN t_ranap_resep_detail ON (t_farmasi_apotik_pengeluaran_detail.RANAP_RESEP_DETAIL_ID = t_ranap_resep_detail.RANAP_RESEP_DETAIL_ID)
					INNER JOIN t_ranap_resep ON (t_ranap_resep_detail.RANAP_RESEP_ID = t_ranap_resep.RANAP_RESEP_ID)
					INNER JOIN m_persediaan_farmasi ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					WHERE t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL 
					AND t_farmasi_apotik_pengeluaran.JENIS_PENGELUARAN = "2"
					AND DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%Y") = "' . $tahun . '"
					GROUP BY DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%m"),
					t_farmasi_apotik_pengeluaran.NO_PENGELUARAN,
					TRIM(SUBSTRING_INDEX(t_farmasi_apotik_pengeluaran.INSTANSI_PENGIRIM,"Kelas",1))
				) t_resep
				WHERE 1 GROUP BY BULAN
					ORDER BY BULAN';
?>
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th rowspan="2">No</th>
		<th rowspan="2">Triwulan</th>
		<th rowspan="2">Bulan</th>
        <th colspan="3">Rekapitulasi Hasil Pemantauan</th>
	</tr>
    <tr>
      <th>Sesuai Formularium Nas/ RS</th>
      <th>Jumlah /R</th>
	  <th>%</th>
    </tr>
    <?
     $no = 1;
    $get_pasien = mysql_query($qry_pasien) or die(mysql_error());
    while ($data = mysql_fetch_array($get_pasien)) {
        ?>
        <tr>
            <td align="center"><?php echo $no; ?></td>
			<td align="center"><?php echo $data['TRIWULAN']; ?></td>
            <td><?php echo $arr_bulan[$data['BULAN']]; ?></td>
			<td align="right"><?php echo currFormat($data['FORMULARIUM']); ?></td>
			<td align="right"><?php echo currFormat($data['JML_OBAT']); ?></td>
			<td align="right"><?php $persen =  ($data['FORMULARIUM'] / $data['JML_OBAT']) * 100; 
				echo currFormat($persen); ?></td>
        </tr>
        <?
    $no++;
	}
    ?>
</table>