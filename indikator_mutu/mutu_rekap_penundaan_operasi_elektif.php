<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tahun = date('Y');
if (isset($_SESSION['phroprs_tahun']))
    $tahun = $_SESSION['phroprs_tahun'];
$bulan = date('m');
if (isset($_SESSION['phroprs_tahun']))
    $bulan = $_SESSION['phroprs_bulan'];
if (isset($_GET['tahun'])) {
    $tahun = $_GET['tahun'];
    $_SESSION['phroprs_tahun'] = $_GET['tahun'];
}
if (isset($_GET['bulan'])) {
    $bulan = $_GET['bulan'];
    $_SESSION['phroprs_bulan'] = $_GET['bulan'];
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
$qry_pasien = 'SELECT TANGGAL_OPERASI, 
				COUNT(CASE WHEN PERUBAHAN_JADWAL = "1" THEN OPERASI_ID END) AS JADWAL_BERUBAH,
				COUNT(OPERASI_ID) AS JML_OPERASI
				FROM (
					SELECT t_operasi.OPERASI_ID,t_operasi.NO_ORDER,
					DATE_FORMAT(t_operasi.TANGGAL_PELAKSANAAN_OPERASI,"%d/%m/%Y %H:%i %H:%i") AS TANGGAL_PELAKSANAAN_OPERASI,
					DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y") AS TANGGAL_OPERASI,
					DATE_FORMAT(t_operasi.JAM_OPERASI,"%H:%i") AS JAM_OPERASI,
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
					AND DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%m") = "' . $bulan . '"
					UNION
					SELECT t_operasi.OPERASI_ID,t_operasi.NO_ORDER,
					DATE_FORMAT(t_operasi.TANGGAL_PELAKSANAAN_OPERASI,"%d/%m/%Y %H:%i") AS TANGGAL_PELAKSANAAN_OPERASI,
					DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y") AS TANGGAL_OPERASI,
					DATE_FORMAT(t_operasi.JAM_OPERASI,"%H:%i") AS JAM_OPERASI,
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
					AND DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%m") = "' . $bulan . '"
					UNION
					SELECT t_operasi.OPERASI_ID,t_operasi.NO_ORDER,
					DATE_FORMAT(t_operasi.TANGGAL_PELAKSANAAN_OPERASI,"%d/%m/%Y %H:%i") AS TANGGAL_PELAKSANAAN_OPERASI,
					DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y") AS TANGGAL_OPERASI,
					DATE_FORMAT(t_operasi.JAM_OPERASI,"%H:%i") AS JAM_OPERASI,
					t_operasi.NAMA_PASIEN,t_operasi.NO_PASIEN_OPERASI AS NOMR,t_operasi.TGL_LAHIR,
					t_operasi.PERUBAHAN_JADWAL,t_operasi.KETERANGAN_PERUBAHAN_JADWAL,
					CASE WHEN t_operasi.CARA_DIRAWAT = "1" THEN "Elektif"
						WHEN t_operasi.CARA_DIRAWAT = "2" THEN "Emerbency" END AS CARA_DIRAWAT
					FROM t_operasi
					WHERE t_operasi.ST_APPROVE = "1"  
					AND t_operasi.JNS_ORDER = "APS"
					AND t_operasi.NO_PENDAFTARAN IS NOT NULL
					AND DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%Y") = "' . $tahun . '" 
					AND DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%m") = "' . $bulan . '"
				) t_order WHERE CARA_DIRAWAT = "Elektif"
				GROUP BY TANGGAL_OPERASI
				ORDER BY TANGGAL_OPERASI';
?>
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
		<th>Tanggal</th>
        <th>Jumlah Jadwal Operasi<br />Yang Berubah</th>
        <th>Jumlah Operasi Elektuf</th>
        <th>Keterangan</th>
    </tr>
    <?
	$x = 1;
    $get_pasien = mysql_query($qry_pasien) or die(mysql_error());
    while ($dat_pasien = mysql_fetch_array($get_pasien)){ ?>
			<td align="center"><?php echo $x; ?></td>
            <td align="center"><?php echo $dat_pasien['TANGGAL_OPERASI']; ?></td>
			<td align="right"><?php echo currFormat($dat_pasien['JADWAL_BERUBAH']); ?></td>
			<td align="right"><?php echo currFormat($dat_pasien['JML_OPERASI']); ?></td>
			<td>&nbsp;</td>
        </tr>
        <?
    $x++;
	}
    ?>
</table>		