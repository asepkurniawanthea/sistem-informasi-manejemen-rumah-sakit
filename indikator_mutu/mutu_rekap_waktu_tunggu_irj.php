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
$qry_pasien = 'SELECT DATE_FORMAT(TANGGAL_DAFTAR,"%m") AS BULAN_MASUK,
				SUM(
					CASE WHEN PRINT_TIME IS NOT NULL
					THEN RESPONSE_TIME_TPP END
				) AS TPP,
				COUNT(
					CASE WHEN PRINT_TIME IS NOT NULL
					THEN IRJA_ID END
				) AS J_TPP,
				SUM(
					CASE WHEN PASIEN_MASUK IS NOT NULL
					THEN RESPONSE_TIME_POLI END
				) AS POLI,
				COUNT(
					CASE WHEN RESPONSE_TIME_POLI IS NOT NULL
					THEN IRJA_ID END
				) AS J_POLI,
				COUNT(IRJA_ID) AS JML_PASIEN
				FROM (
					SELECT irj.IRJA_ID,
					cs.PRINT_TIME,
					irj.TANGGAL_DAFTAR,
					irj.PASIEN_MASUK,
					TIME_TO_SEC(TIMEDIFF(irj.TGL_TRANS,cs.PRINT_TIME)) AS RESPONSE_TIME_TPP,
					TIME_TO_SEC(TIMEDIFF(irj.PASIEN_MASUK,irj.TGL_TRANS)) AS RESPONSE_TIME_POLI,
					TIME_TO_SEC(TIMEDIFF(irj.PASIEN_MASUK,cs.PRINT_TIME)) AS RESPONSE_TIME
					FROM db_simrs.t_irja irj
					LEFT JOIN db_customer_servicers.t_trans cs ON (irj.ONLINE_ID = cs.TRANS_ID) 	
					WHERE irj.NO_PENDAFTARAN IS NOT NULL AND irj.ST_BATAL IS NULL 
					AND irj.UNIT_ID <> 9
					AND DATE_FORMAT(irj.TANGGAL_DAFTAR,"%Y") = "' . $tahun . '"
				) t_rj	
				GROUP BY BULAN_MASUK
				ORDER BY BULAN_MASUK';
?>
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
		<th>Bulan</th>
		<!--<th>Rata-rata Response Time TPP<br />Menit</th>-->
		<th>Rata-rata Response Time Dokter<br />Menit</th>
        <th>Jumlah Pasien</th>
    </tr>
    <?
	$x = 1;
    $get_pasien = mysql_query($qry_pasien) or die(mysql_error());
    while ($dat_pasien = mysql_fetch_array($get_pasien)) {
        ?>
            <td align="center"><?php echo $x; ?></td>
			<td><?php echo $arr_bulan[$dat_pasien['BULAN_MASUK']]; ?></td>
			<!--<td align="right"><?php $response_tpp = 0; 
						if($dat_pasien['J_TPP'] > 0){ 
							$response_tpp = ($dat_pasien['TPP'] / $dat_pasien['J_TPP']) / 60; 
						}	
						echo currFormat($response_tpp); ?></td>-->
			<td align="right"><?php $response_poli = 0; 
						if($dat_pasien['J_POLI'] > 0){ 
							$response_poli = ($dat_pasien['POLI'] / $dat_pasien['J_POLI']) / 60; 
						}	
						echo currFormat($response_poli); ?></td>			
			<td align="right"><?php echo currFormat($dat_pasien['JML_PASIEN']); ?></td>
        </tr>
        <?
    $x++;
	}
    ?>
</table>