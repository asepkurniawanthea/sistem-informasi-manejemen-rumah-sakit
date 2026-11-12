<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tahun = date('Y');
if (isset($_SESSION['phroprs_tahun']))
    $tahun = $_SESSION['phroprs_tahun'];

if (isset($_GET['tahun'])) {
    $tahun = $_GET['tahun'];
    $_SESSION['phroprs_tahun'] = $_GET['tahun'];
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
            <td>&nbsp;</td>	
        </tr>
		<tr>
			<td>&nbsp;</td>
            <td><input type="submit" value="cari" class="myButton" /></td>
			<td>&nbsp;</td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_pasien = 'SELECT CASE WHEN DATE_FORMAT(TANGGAL_OPERASI,"%m") = "01" THEN "I" 
							WHEN DATE_FORMAT(TANGGAL_OPERASI,"%m") = "02" THEN "I"
							WHEN DATE_FORMAT(TANGGAL_OPERASI,"%m") = "03" THEN "I"
							WHEN DATE_FORMAT(TANGGAL_OPERASI,"%m") = "04" THEN "II"
							WHEN DATE_FORMAT(TANGGAL_OPERASI,"%m") = "05" THEN "II"
							WHEN DATE_FORMAT(TANGGAL_OPERASI,"%m") = "06" THEN "II"
							WHEN DATE_FORMAT(TANGGAL_OPERASI,"%m") = "07" THEN "III"
							WHEN DATE_FORMAT(TANGGAL_OPERASI,"%m") = "08" THEN "III"
							WHEN DATE_FORMAT(TANGGAL_OPERASI,"%m") = "09" THEN "III"
							WHEN DATE_FORMAT(TANGGAL_OPERASI,"%m") = "10" THEN "IV"
							WHEN DATE_FORMAT(TANGGAL_OPERASI,"%m") = "11" THEN "IV"
							WHEN DATE_FORMAT(TANGGAL_OPERASI,"%m") = "12" THEN "IV"
				END AS TRIWULAN,	
				DATE_FORMAT(TANGGAL_OPERASI,"%m") AS BULAN, 
				COUNT(CASE WHEN PERUBAHAN_JADWAL = "1" THEN OPERASI_ID END) AS JADWAL_BERUBAH,
				COUNT(OPERASI_ID) AS JML_OPERASI
				FROM (
					SELECT t_operasi.OPERASI_ID,t_operasi.NO_ORDER,
					t_operasi.TANGGAL_PELAKSANAAN_OPERASI,
					t_operasi.TANGGAL_OPERASI,
					t_operasi.JAM_OPERASI,
					m_pasien.NAMA_PASIEN,t_operasi.NOMR,m_pasien.TGL_LAHIR,
					t_operasi.PERUBAHAN_JADWAL,t_operasi.KETERANGAN_PERUBAHAN_JADWAL,
					CASE WHEN t_operasi.CARA_DIRAWAT = "1" THEN "Elektif"
						WHEN t_operasi.CARA_DIRAWAT = "2" THEN "Emerbency" END AS CARA_DIRAWAT
					FROM t_operasi
					INNER JOIN t_irja ON (t_operasi.RAWAT_ID = t_irja.IRJA_ID)
					INNER JOIN m_pasien ON (t_operasi.NOMR = m_pasien.NOMR)
					WHERE t_operasi.ST_APPROVE = "1" 
					AND t_operasi.JNS_ORDER = "IRJ"
					AND t_operasi.NO_PENDAFTARAN IS NOT NULL
					AND DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%Y") = "' . $tahun . '" 
					UNION
					SELECT t_operasi.OPERASI_ID,t_operasi.NO_ORDER,
					t_operasi.TANGGAL_PELAKSANAAN_OPERASI,
					t_operasi.TANGGAL_OPERASI,
					t_operasi.JAM_OPERASI,
					m_pasien.NAMA_PASIEN,t_operasi.NOMR,m_pasien.TGL_LAHIR,
					t_operasi.PERUBAHAN_JADWAL,t_operasi.KETERANGAN_PERUBAHAN_JADWAL,
					CASE WHEN t_operasi.CARA_DIRAWAT = "1" THEN "Elektif"
						WHEN t_operasi.CARA_DIRAWAT = "2" THEN "Emerbency" END AS CARA_DIRAWAT
					FROM t_operasi
					INNER JOIN t_irna ON (t_operasi.RAWAT_ID = t_irna.IRNA_ID)
					INNER JOIN m_pasien ON (t_operasi.NOMR = m_pasien.NOMR)
					WHERE t_operasi.ST_APPROVE = "1"  
					AND t_operasi.JNS_ORDER = "IRN"
					AND t_operasi.NO_PENDAFTARAN IS NOT NULL
					AND DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%Y") = "' . $tahun . '" 
					UNION
					SELECT t_operasi.OPERASI_ID,t_operasi.NO_ORDER,
					t_operasi.TANGGAL_PELAKSANAAN_OPERASI,
					t_operasi.TANGGAL_OPERASI,
					t_operasi.JAM_OPERASI,
					t_operasi.NAMA_PASIEN,t_operasi.NO_PASIEN_OPERASI AS NOMR,t_operasi.TGL_LAHIR,
					t_operasi.PERUBAHAN_JADWAL,t_operasi.KETERANGAN_PERUBAHAN_JADWAL,
					CASE WHEN t_operasi.CARA_DIRAWAT = "1" THEN "Elektif"
						WHEN t_operasi.CARA_DIRAWAT = "2" THEN "Emerbency" END AS CARA_DIRAWAT
					FROM t_operasi
					WHERE t_operasi.ST_APPROVE = "1"  
					AND t_operasi.JNS_ORDER = "APS"
					AND t_operasi.NO_PENDAFTARAN IS NOT NULL
					AND DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%Y") = "' . $tahun . '" 
				) t_order WHERE CARA_DIRAWAT = "Elektif"
				GROUP BY TRIWULAN,BULAN
				ORDER BY TRIWULAN,BULAN';
?>
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
		<th>Triwulan</th>
		<th>Bulan</th>
        <th>Jumlah Jadwal Operasi<br />Yang Berubah</th>
        <th>Jumlah Operasi Elektuf</th>
        <th>%</th>
    </tr>
    <?
	$x = 1;
    $get_pasien = mysql_query($qry_pasien) or die(mysql_error());
    while ($dat_pasien = mysql_fetch_array($get_pasien)){ ?>
			<td align="center"><?php echo $x; ?></td>
            <td align="center"><?php echo $dat_pasien['TRIWULAN']; ?></td>
			<td align="center"><?php echo $arr_bulan[$dat_pasien['BULAN']]; ?></td>
			<td align="right"><?php echo currFormat($dat_pasien['JADWAL_BERUBAH']); ?></td>
			<td align="right"><?php echo currFormat($dat_pasien['JML_OPERASI']); ?></td>
			<td align="center"><?php $persen = ($dat_pasien['JADWAL_BERUBAH'] / $dat_pasien['JML_OPERASI']) * 100; 
				echo currFormat($persen); ?></td>
        </tr>
        <?
    $x++;
	}
    ?>
</table>		