<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tahun = date('Y');
if (isset($_SESSION['pasiendirawatkeluar_tahun']))
    $tahun = $_SESSION['pasiendirawatkeluar_tahun'];
$bulan = date('m');
if (isset($_SESSION['pasiendirawatkeluar_tahun']))
    $bulan = $_SESSION['pasiendirawatkeluar_bulan'];
if (isset($_GET['tahun'])) {
    $tahun = $_GET['tahun'];
    $_SESSION['pasiendirawatkeluar_tahun'] = $_GET['tahun'];
}
if (isset($_GET['bulan'])) {
    $bulan = $_GET['bulan'];
    $_SESSION['pasiendirawatkeluar_bulan'] = $_GET['bulan'];
}

$ruang_id = '';
if (isset($_SESSION['pasiendirawatkeluar_ruang_id']))
		$ruang_id = $_SESSION['pasiendirawatkeluar_ruang_id'];

if (isset($_GET['ruang_id'])) {
    $ruang_id = $_GET['ruang_id'];
	$_SESSION['pasiendirawatkeluar_ruang_id'] = $ruang_id;
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
			<td>&nbsp;</td>
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
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Ruang Rawat</td>
            <td><select name="ruang_id" class="text_dt" style="width:220px;" >
				<option value=""> - </option>
				<?php echo getRuangRawat($ruang_id); ?>
			</select></td>
            <td align="right"><input type="submit" value="cari" class="myButton" />&nbsp;
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
	$qry_jaminan = 'SELECT m_jaminan.JAMINAN_ID,
					m_jaminan.NAMA_JAMINAN
				FROM m_jaminan
				WHERE m_jaminan.PENDAFTARAN = "1"
				ORDER BY URUT';
	$get_jaminan = mysql_query($qry_jaminan) or die(mysql_error());
	$jrow_umum = mysql_num_rows($get_jaminan);	
?>
<table border="1" class="tableData" id="tfhover">
    <tr>
        <th>No</th>
		<th>Data Kegiatan</th>
        <th>Laki-Laki</th>
		<th>Perempuan</th>
		<?php
			while($dat_jaminan = mysql_fetch_array($get_jaminan)){
				echo '<th>' . strtoupper($dat_jaminan['NAMA_JAMINAN']) . '</th>';
			}
		?>
        <th>Jumlah</th>
    </tr>
	<tr>
		<td align="center">1</td>
		<td>Pasien Awal</td>
		<?php 
			$qry_awal = 'SELECT COUNT(CASE WHEN m_pasien.JNS_KELAMIN = "L" THEN t_irna_opname.IRNA_ID END) AS JML_LK,
						COUNT(CASE WHEN m_pasien.JNS_KELAMIN = "P" THEN t_irna_opname.IRNA_ID END) AS JML_PR,';
			mysql_data_seek($get_jaminan,0);
			while($dat_jaminan = mysql_fetch_array($get_jaminan)){
				$qry_awal .= 'COUNT(CASE WHEN t_irna.JENIS_BAYAR_ID = ' . $dat_jaminan['JAMINAN_ID'] . ' THEN t_irna_opname.IRNA_ID END) AS JAMINAN_' . $dat_jaminan['JAMINAN_ID'] . ',';
			}
			$qry_awal = substr($qry_awal,0,strlen($qry_awal)-1);
			$qry_awal .= ' FROM t_irna_opname
				INNER JOIN t_irna ON (t_irna_opname.IRNA_ID = t_irna.IRNA_ID)
				INNER JOIN m_pasien ON (t_irna_opname.NOMR = m_pasien.NOMR)
				WHERE t_irna_opname.TANGGAL_OPNAME = DATE_ADD(STR_TO_DATE("01/' . $bulan . '/' . $tahun . '","%d/%m/%Y"),INTERVAL -1 DAY)';
			if(!empty($ruang_id)) $qry_awal .= ' AND t_irna_opname.RUANG_ID = "' . $ruang_id . '"';
			$get_awal = mysql_query($qry_awal) or die(mysql_error());
			$total_awal = 0;
			$dat_awal = mysql_fetch_assoc($get_awal);
			echo '<td align="right">' . $dat_awal['JML_LK'] . '</td>';
			echo '<td align="right">' . $dat_awal['JML_PR'] . '</td>';
			mysql_data_seek($get_jaminan,0);
			while($dat_jaminan = mysql_fetch_array($get_jaminan)){
				echo '<td align="right">' . $dat_awal['JAMINAN_' . $dat_jaminan['JAMINAN_ID']] . '</td>';
				$total_awal += $dat_awal['JAMINAN_' . $dat_jaminan['JAMINAN_ID']];
			}	
			echo '<td align="right">' . $total_awal . '</td>';	
		?>
	</tr>
	<tr>
		<td align="center">2</td>
		<td>Pasien Masuk</td>
		<?php 
			$qry_masuk = 'SELECT COUNT(CASE WHEN m_pasien.JNS_KELAMIN = "L" THEN t_irna_log.IRNA_ID END) AS JML_LK,
						COUNT(CASE WHEN m_pasien.JNS_KELAMIN = "P" THEN t_irna_log.IRNA_ID END) AS JML_PR,';
			mysql_data_seek($get_jaminan,0);
			while($dat_jaminan = mysql_fetch_array($get_jaminan)){
				$qry_masuk .= 'COUNT(CASE WHEN t_irna.JENIS_BAYAR_ID = ' . $dat_jaminan['JAMINAN_ID'] . ' THEN t_irna_log.IRNA_ID END) AS JAMINAN_' . $dat_jaminan['JAMINAN_ID'] . ',';
			}
			
			$qry_masuk = substr($qry_masuk,0,strlen($qry_masuk)-1);
			$qry_masuk .= ' FROM t_irna_log
				INNER JOIN t_irna ON (t_irna_log.IRNA_ID = t_irna.IRNA_ID)
				INNER JOIN m_pasien ON (t_irna_log.NOMR = m_pasien.NOMR)
				WHERE t_irna_log.JNS_UPDATE = "R" 
				AND t_irna_log.RUANG_ID_ASAL IS NULL
				AND DATE_FORMAT(t_irna_log.TANGGAL_MASUK,"%m%Y") = "' . $bulan . $tahun . '"';
			if(!empty($ruang_id)) $qry_masuk .= ' AND t_irna_log.RUANG_ID_BARU = "' . $ruang_id . '"';	
			$get_masuk = mysql_query($qry_masuk) or die(mysql_error());
			$total_masuk = 0;
			$dat_masuk = mysql_fetch_assoc($get_masuk);
			echo '<td align="right">' . $dat_masuk['JML_LK'] . '</td>';
			echo '<td align="right">' . $dat_masuk['JML_PR'] . '</td>';
			mysql_data_seek($get_jaminan,0);
			while($dat_jaminan = mysql_fetch_array($get_jaminan)){
				echo '<td align="right">' . $dat_masuk['JAMINAN_' . $dat_jaminan['JAMINAN_ID']] . '</td>';
				$total_masuk += $dat_masuk['JAMINAN_' . $dat_jaminan['JAMINAN_ID']];
			}	
			echo '<td align="right">' . $total_masuk . '</td>';	
		?>
	</tr>
	<tr>
		<td align="center">3</td>
		<td>Jumlah Pasien Awal + Pasien Masuk</td>
		<?php 
			$total_awal_masuk = 0;
			if(mysql_num_rows($get_awal) > 0) mysql_data_seek($get_awal,0);
			if(mysql_num_rows($get_masuk) > 0) mysql_data_seek($get_masuk,0);
			$dat_awal = mysql_fetch_assoc($get_awal);
			$dat_masuk = mysql_fetch_assoc($get_masuk);
			$jml_lk = $dat_awal['JML_LK'] + $dat_masuk['JML_LK'];
			$jml_pr = $dat_awal['JML_PR'] + $dat_masuk['JML_PR'];
			echo '<td align="right">' . $jml_lk . '</td>';
			echo '<td align="right">' . $jml_pr . '</td>';
			mysql_data_seek($get_jaminan,0);
			while($dat_jaminan = mysql_fetch_array($get_jaminan)){
				$jml_jaminan = $dat_awal['JAMINAN_' . $dat_jaminan['JAMINAN_ID']] + $dat_masuk['JAMINAN_' . $dat_jaminan['JAMINAN_ID']];
				echo '<td align="right">' . $jml_jaminan . '</td>';
				$total_awal_masuk += $jml_jaminan;
			}
			echo '<td align="right">' . $total_awal_masuk . '</td>';	
		?>
	</tr>
	<tr>
		<td align="center">4</td>
		<td>Pasien Keluar Hidup + Meninggal</td>
		<?php 
			$qry_keluar = 'SELECT COUNT(CASE WHEN m_pasien.JNS_KELAMIN = "L" THEN t_irna_log.IRNA_ID END) AS JML_LK,
						COUNT(CASE WHEN m_pasien.JNS_KELAMIN = "P" THEN t_irna_log.IRNA_ID END) AS JML_PR,
						COUNT(CASE WHEN m_pasien.JNS_KELAMIN = "L" AND (t_irna_log.PASIEN_PULANG_ID = 3 
							OR t_irna_log.PASIEN_PULANG_ID = 8) THEN t_irna_log.IRNA_ID END) AS JML_MENINGGAL_LK,
						COUNT(CASE WHEN m_pasien.JNS_KELAMIN = "P" AND (t_irna_log.PASIEN_PULANG_ID = 3 
							OR t_irna_log.PASIEN_PULANG_ID = 8) THEN t_irna_log.IRNA_ID END) AS JML_MENINGGAL_PR,
						COUNT(CASE WHEN m_pasien.JNS_KELAMIN = "L" AND (t_irna_log.PASIEN_KEADAAN_ID = 5 
							OR t_irna_log.PASIEN_KEADAAN_ID = 6 OR t_irna_log.PASIEN_KEADAAN_ID = 7 
							OR t_irna_log.PASIEN_KEADAAN_ID = 9) THEN t_irna_log.IRNA_ID END) AS JML_MENINGGAL_L48_LK,
						COUNT(CASE WHEN m_pasien.JNS_KELAMIN = "P" AND (t_irna_log.PASIEN_KEADAAN_ID = 5 
							OR t_irna_log.PASIEN_KEADAAN_ID = 6 OR t_irna_log.PASIEN_KEADAAN_ID = 7 
							OR t_irna_log.PASIEN_KEADAAN_ID = 9) THEN t_irna_log.IRNA_ID END) AS JML_MENINGGAL_L48_PR,		
						COUNT(CASE WHEN m_pasien.JNS_KELAMIN = "L" AND t_irna_log.PASIEN_KEADAAN_ID = 8 
							THEN t_irna_log.IRNA_ID END) AS JML_MENINGGAL_M48_LK,
						COUNT(CASE WHEN m_pasien.JNS_KELAMIN = "P" AND t_irna_log.PASIEN_KEADAAN_ID = 8 
							THEN t_irna_log.IRNA_ID END) AS JML_MENINGGAL_M48_PR,			
						SUM(CASE WHEN m_pasien.JNS_KELAMIN = "L" THEN DATEDIFF(t_irna_log.TANGGAL_KELUAR,
													(SELECT t.TANGGAL_MASUK FROM t_irna_log t 
													WHERE t.IRNA_ID = t_irna_log.IRNA_ID
													AND t.JNS_UPDATE = "R"
													AND t.RUANG_ID_BARU IS NOT NULL
													AND t.RUANG_ID_ASAL IS NULL
													ORDER BY t.TANGGAL_MASUK ASC LIMIT 1)) + 1 ELSE 0 END) AS LOS_LK,
						SUM(CASE WHEN m_pasien.JNS_KELAMIN = "P" THEN DATEDIFF(t_irna_log.TANGGAL_KELUAR,
													(SELECT t.TANGGAL_MASUK FROM t_irna_log t 
													WHERE t.IRNA_ID = t_irna_log.IRNA_ID
													AND t.JNS_UPDATE = "R"
													AND t.RUANG_ID_BARU IS NOT NULL
													AND t.RUANG_ID_ASAL IS NULL
													ORDER BY t.TANGGAL_MASUK ASC LIMIT 1)) + 1 ELSE 0 END) AS LOS_PR,';
			mysql_data_seek($get_jaminan,0);
			while($dat_jaminan = mysql_fetch_array($get_jaminan)){
				$qry_keluar .= 'COUNT(CASE WHEN t_irna.JENIS_BAYAR_ID = ' . $dat_jaminan['JAMINAN_ID'] . ' THEN t_irna_log.IRNA_ID END) AS JAMINAN_' . $dat_jaminan['JAMINAN_ID'] . ',';
				$qry_keluar .= 'COUNT(CASE WHEN t_irna.JENIS_BAYAR_ID = ' . $dat_jaminan['JAMINAN_ID'] . ' 
									AND (t_irna_log.PASIEN_PULANG_ID = 3 OR t_irna_log.PASIEN_PULANG_ID = 8)
									THEN t_irna_log.IRNA_ID END) AS MENINGGAL_JAMINAN_' . $dat_jaminan['JAMINAN_ID'] . ',';
				$qry_keluar .= 'COUNT(CASE WHEN t_irna.JENIS_BAYAR_ID = ' . $dat_jaminan['JAMINAN_ID'] . ' 
									AND (t_irna_log.PASIEN_KEADAAN_ID = 5 OR t_irna_log.PASIEN_KEADAAN_ID = 6 
										OR t_irna_log.PASIEN_KEADAAN_ID = 7 OR t_irna_log.PASIEN_KEADAAN_ID = 9)
									THEN t_irna_log.IRNA_ID END) AS MENINGGAL_L48_JAMINAN_' . $dat_jaminan['JAMINAN_ID'] . ',';					
				$qry_keluar .= 'COUNT(CASE WHEN t_irna.JENIS_BAYAR_ID = ' . $dat_jaminan['JAMINAN_ID'] . ' 
									AND t_irna_log.PASIEN_KEADAAN_ID = 8
									THEN t_irna_log.IRNA_ID END) AS MENINGGAL_M48_JAMINAN_' . $dat_jaminan['JAMINAN_ID'] . ',';										
				$qry_keluar .= 'SUM(CASE WHEN t_irna.JENIS_BAYAR_ID = ' . $dat_jaminan['JAMINAN_ID'] . ' 
										THEN DATEDIFF(t_irna_log.TANGGAL_KELUAR,
													(SELECT t.TANGGAL_MASUK FROM t_irna_log t 
													WHERE t.IRNA_ID = t_irna_log.IRNA_ID
													AND t.JNS_UPDATE = "R"
													AND t.RUANG_ID_BARU IS NOT NULL
													AND t.RUANG_ID_ASAL IS NULL
													ORDER BY t.TANGGAL_MASUK ASC LIMIT 1)) + 1 
										ELSE 0 END) AS LOS_JAMINAN_' . $dat_jaminan['JAMINAN_ID'] . ',';					
			}
			$qry_keluar = substr($qry_keluar,0,strlen($qry_keluar)-1);
			$qry_keluar .= ' FROM t_irna_log
				INNER JOIN t_irna ON (t_irna_log.IRNA_ID = t_irna.IRNA_ID)
				INNER JOIN m_pasien ON (t_irna_log.NOMR = m_pasien.NOMR)
				WHERE t_irna_log.JNS_UPDATE = "R" 
				AND t_irna_log.RUANG_ID_BARU IS NULL
				AND DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m%Y") = "' . $bulan . $tahun . '"';
			if(!empty($ruang_id)) $qry_keluar .= ' AND t_irna_log.RUANG_ID_ASAL = "' . $ruang_id . '"';		
			$get_keluar = mysql_query($qry_keluar) or die(mysql_error());
			$total_keluar = 0;
			$dat_keluar = mysql_fetch_assoc($get_keluar);
			echo '<td align="right">' . $dat_keluar['JML_LK'] . '</td>';
			echo '<td align="right">' . $dat_keluar['JML_PR'] . '</td>';
			mysql_data_seek($get_jaminan,0);
			while($dat_jaminan = mysql_fetch_array($get_jaminan)){
				echo '<td align="right">' . $dat_keluar['JAMINAN_' . $dat_jaminan['JAMINAN_ID']] . '</td>';
				$total_keluar += $dat_keluar['JAMINAN_' . $dat_jaminan['JAMINAN_ID']];
			}	
			echo '<td align="right">' . $total_keluar . '</td>';		
		?>
	</tr>
	<tr>
		<td align="center">5</td>
		<td>Pasien Keluar Meninggal</td>
		<?php 
			$total_keluar = 0;
			mysql_data_seek($get_keluar,0);
			$dat_keluar = mysql_fetch_assoc($get_keluar);
			echo '<td align="right">' . $dat_keluar['JML_MENINGGAL_LK'] . '</td>';
			echo '<td align="right">' . $dat_keluar['JML_MENINGGAL_PR'] . '</td>';
			mysql_data_seek($get_jaminan,0);
			while($dat_jaminan = mysql_fetch_array($get_jaminan)){
				echo '<td align="right">' . $dat_keluar['MENINGGAL_JAMINAN_' . $dat_jaminan['JAMINAN_ID']] . '</td>';
				$total_keluar += $dat_keluar['MENINGGAL_JAMINAN_' . $dat_jaminan['JAMINAN_ID']];
			}	
			echo '<td align="right">' . $total_keluar . '</td>';		
		?>
	</tr>
	<tr>
		<td align="center">6</td>
		<td>Pasien Keluar Meninggal < 48 Jam</td>
		<?php 
			$total_keluar = 0;
			mysql_data_seek($get_keluar,0);
			$dat_keluar = mysql_fetch_assoc($get_keluar);
			echo '<td align="right">' . $dat_keluar['JML_MENINGGAL_L48_LK'] . '</td>';
			echo '<td align="right">' . $dat_keluar['JML_MENINGGAL_L48_PR'] . '</td>';
			mysql_data_seek($get_jaminan,0);
			while($dat_jaminan = mysql_fetch_array($get_jaminan)){
				echo '<td align="right">' . $dat_keluar['MENINGGAL_L48_JAMINAN_' . $dat_jaminan['JAMINAN_ID']] . '</td>';
				$total_keluar += $dat_keluar['MENINGGAL_L48_JAMINAN_' . $dat_jaminan['JAMINAN_ID']];
			}	
			echo '<td align="right">' . $total_keluar . '</td>';				
		?>
	</tr>
	<tr>
		<td align="center">7</td>
		<td>Pasien Keluar Meninggal &#8805; 48 Jam</td>
		<?php 
			$total_keluar = 0;
			mysql_data_seek($get_keluar,0);
			$dat_keluar = mysql_fetch_assoc($get_keluar);
			echo '<td align="right">' . $dat_keluar['JML_MENINGGAL_M48_LK'] . '</td>';
			echo '<td align="right">' . $dat_keluar['JML_MENINGGAL_M48_PR'] . '</td>';
			mysql_data_seek($get_jaminan,0);
			while($dat_jaminan = mysql_fetch_array($get_jaminan)){
				echo '<td align="right">' . $dat_keluar['MENINGGAL_M48_JAMINAN_' . $dat_jaminan['JAMINAN_ID']] . '</td>';
				$total_keluar += $dat_keluar['MENINGGAL_M48_JAMINAN_' . $dat_jaminan['JAMINAN_ID']];
			}	
			echo '<td align="right">' . $total_keluar . '</td>';		
		?>
	</tr>
	<tr>
		<td align="center">8</td>
		<td>Sisa Pasien Akhir Bulan</td>
		<?php 
			$qry_akhirbulan = 'SELECT COUNT(CASE WHEN m_pasien.JNS_KELAMIN = "L" THEN t_irna_opname.IRNA_ID END) AS JML_LK,
						COUNT(CASE WHEN m_pasien.JNS_KELAMIN = "P" THEN t_irna_opname.IRNA_ID END) AS JML_PR,';
			mysql_data_seek($get_jaminan,0);
			while($dat_jaminan = mysql_fetch_array($get_jaminan)){
				$qry_akhirbulan .= 'COUNT(CASE WHEN t_irna.JENIS_BAYAR_ID = ' . $dat_jaminan['JAMINAN_ID'] . ' THEN t_irna_opname.IRNA_ID END) AS JAMINAN_' . $dat_jaminan['JAMINAN_ID'] . ',';
			}
			$qry_akhirbulan = substr($qry_akhirbulan,0,strlen($qry_akhirbulan)-1);
			$qry_akhirbulan .= ' FROM t_irna_opname
				INNER JOIN t_irna ON (t_irna_opname.IRNA_ID = t_irna.IRNA_ID)
				INNER JOIN m_pasien ON (t_irna_opname.NOMR = m_pasien.NOMR)
				WHERE t_irna_opname.TANGGAL_OPNAME = LAST_DAY(STR_TO_DATE("01/' . $bulan . '/' . $tahun . '","%d/%m/%Y"))';
			if(!empty($ruang_id)) $qry_akhirbulan .= ' AND t_irna_opname.RUANG_ID = "' . $ruang_id . '"';
			$get_akhirbulan = mysql_query($qry_akhirbulan) or die(mysql_error());
			$total_akhirbulan = 0;
			$dat_akhirbulan = mysql_fetch_assoc($get_akhirbulan);
			echo '<td align="right">' . $dat_akhirbulan['JML_LK'] . '</td>';
			echo '<td align="right">' . $dat_akhirbulan['JML_PR'] . '</td>';
			mysql_data_seek($get_jaminan,0);
			while($dat_jaminan = mysql_fetch_array($get_jaminan)){
				echo '<td align="right">' . $dat_akhirbulan['JAMINAN_' . $dat_jaminan['JAMINAN_ID']] . '</td>';
				$total_akhirbulan += $dat_akhirbulan['JAMINAN_' . $dat_jaminan['JAMINAN_ID']];
			}	
			echo '<td align="right">' . $total_akhirbulan . '</td>';	
		?>
	</tr>
	<tr>
		<td align="center">9</td>
		<td>Hari Perawatan</td>
		<?php 
			$qry_hari_perawatan = 'SELECT COUNT(CASE WHEN t_pasien.JNS_KELAMIN = "L" THEN t_pasien.IRNA_ID END) AS JML_LK,
						COUNT(CASE WHEN t_pasien.JNS_KELAMIN = "P" THEN t_pasien.IRNA_ID END) AS JML_PR,';
			mysql_data_seek($get_jaminan,0);
			while($dat_jaminan = mysql_fetch_array($get_jaminan)){
				$qry_hari_perawatan .= 'COUNT(CASE WHEN t_pasien.JENIS_BAYAR_ID = ' . $dat_jaminan['JAMINAN_ID'] . ' THEN t_pasien.IRNA_ID END) AS JAMINAN_' . $dat_jaminan['JAMINAN_ID'] . ',';
			}
			$qry_hari_perawatan = substr($qry_hari_perawatan,0,strlen($qry_hari_perawatan)-1);
			$qry_hari_perawatan .= ' FROM 
							(SELECT t_irna_opname.IRNA_ID,m_pasien.JNS_KELAMIN,t_irna.JENIS_BAYAR_ID
							FROM t_irna_opname 
							INNER JOIN t_irna 
							ON (t_irna_opname.IRNA_ID = t_irna.IRNA_ID) 
							INNER JOIN m_pasien 
							ON (t_irna_opname.NOMR = m_pasien.NOMR)
							WHERE DATE_FORMAT(t_irna_opname.TANGGAL_OPNAME,"%m%Y") = "' . $bulan . $tahun . '"';
			if(!empty($ruang_id)) $qry_hari_perawatan .= ' AND t_irna_opname.RUANG_ID = "' . $ruang_id . '"';
			$qry_hari_perawatan .= ' UNION ALL
							SELECT t_pasien_log.IRNA_ID,t_pasien_log.JNS_KELAMIN,t_pasien_log.JENIS_BAYAR_ID
							FROM (SELECT t_irna_log.IRNA_ID,m_pasien.JNS_KELAMIN,t_irna.JENIS_BAYAR_ID,
										(SELECT t.TANGGAL_MASUK FROM t_irna_log t 
										WHERE t.IRNA_ID = t_irna_log.IRNA_ID
										AND t.RUANG_ID_BARU = t_irna_log.RUANG_ID_ASAL
										AND t.JNS_UPDATE = "R"
										AND t.IRNA_LOG_ID < t_irna_log.IRNA_LOG_ID
										ORDER BY t.TANGGAL_MASUK DESC LIMIT 1) AS TANGGAL_MASUK,
								t_irna_log.TANGGAL_KELUAR
								FROM t_irna_log
								INNER JOIN t_irna
								ON (t_irna_log.IRNA_ID = t_irna.IRNA_ID)
								INNER JOIN m_pasien
								ON (t_irna.NOMR = m_pasien.NOMR)
								WHERE DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m%Y") = "' . $bulan . $tahun . '"
								AND t_irna_log.JNS_UPDATE = "R"
								AND t_irna_log.RUANG_ID_BARU IS NULL';
			if(!empty($ruang_id)) $qry_hari_perawatan .= ' AND t_irna_log.RUANG_ID_ASAL = "' . $ruang_id . '"';					
			$qry_hari_perawatan .= ' ) t_pasien_log
							WHERE DATE_FORMAT(t_pasien_log.TANGGAL_MASUK,"%d%m%Y") = DATE_FORMAT(t_pasien_log.TANGGAL_KELUAR,"%d%m%Y")
					) t_pasien';
			$get_hari_perawatan = mysql_query($qry_hari_perawatan) or die(mysql_error());
			$total_hari_perawatan = 0;
			$dat_hari_perawatan = mysql_fetch_assoc($get_hari_perawatan);
			echo '<td align="right">' . $dat_hari_perawatan['JML_LK'] . '</td>';
			echo '<td align="right">' . $dat_hari_perawatan['JML_PR'] . '</td>';
			mysql_data_seek($get_jaminan,0);
			while($dat_jaminan = mysql_fetch_array($get_jaminan)){
				echo '<td align="right">' . $dat_hari_perawatan['JAMINAN_' . $dat_jaminan['JAMINAN_ID']] . '</td>';
				$total_hari_perawatan += $dat_hari_perawatan['JAMINAN_' . $dat_jaminan['JAMINAN_ID']];
			}	
			echo '<td align="right">' . $total_hari_perawatan . '</td>';	
		?>
	</tr>
	<tr>
		<td align="center">10</td>
		<td>LOS (Hari)</td>
		<?php 
			$total_los = 0;
			mysql_data_seek($get_keluar,0);
			$dat_keluar = mysql_fetch_assoc($get_keluar);
			echo '<td align="right">' . $dat_keluar['LOS_LK'] . '</td>';
			echo '<td align="right">' . $dat_keluar['LOS_PR'] . '</td>';
			mysql_data_seek($get_jaminan,0);
			while($dat_jaminan = mysql_fetch_array($get_jaminan)){
				echo '<td align="right">' . $dat_keluar['LOS_JAMINAN_' . $dat_jaminan['JAMINAN_ID']] . '</td>';
				$total_los += $dat_keluar['LOS_JAMINAN_' . $dat_jaminan['JAMINAN_ID']];
			}	
			echo '<td align="right">' . $total_los . '</td>';		
		?>
	</tr>
	<tr>
		<td align="center">11</td>
		<td>BOR (%)</td>
		<?php 
			$qry_bed = 'SELECT m_ruang.RUANG_ID,COUNT(m_ruang_detail.RUANG_DETAIL_ID) AS JML_BED,
						DATE_FORMAT(LAST_DAY(STR_TO_DATE("01' . $bulan . $tahun . '","%d%m%Y")),"%d") AS LD
						FROM m_ruang
						LEFT JOIN m_ruang_detail ON (m_ruang.RUANG_ID = m_ruang_detail.RUANG_ID)
						WHERE m_ruang.ST_AKTIF = "1"
						GROUP BY m_ruang.RUANG_ID';
			$get_bed = mysql_query($qry_bed) or die(mysql_error());
			$arr_bed = array();
			$jml_hari = 0;
			$semua_bed = 0;
			while($dat_bed = mysql_fetch_array($get_bed)){
				$arr_bed[$dat_bed['RUANG_ID']] = $dat_bed['JML_BED'];
				$semua_bed += $dat_bed['JML_BED'];
				$jml_hari = $dat_bed['LD'];	
			}	
			$arr_bed[''] = $semua_bed; 
			
			mysql_data_seek($get_hari_perawatan,0);
			$total_bor = 0;
			$dat_bor = mysql_fetch_assoc($get_hari_perawatan);
			$bor_lk = ($dat_bor['JML_LK'] / ($arr_bed[$ruang_id] * $jml_hari)) * 100;
			$bor_pr = ($dat_bor['JML_PR'] / ($arr_bed[$ruang_id] * $jml_hari)) * 100;
			echo '<td align="right">' . number_format($bor_lk,2) . '</td>';
			echo '<td align="right">' . number_format($bor_pr,2) . '</td>';
			mysql_data_seek($get_jaminan,0);
			while($dat_jaminan = mysql_fetch_array($get_jaminan)){
				$bor = 0;
				if($arr_bed[$ruang_id] > 0){
					$bor = ($dat_bor['JAMINAN_' . $dat_jaminan['JAMINAN_ID']] / ($arr_bed[$ruang_id] * $jml_hari)) * 100;
				}
				echo '<td align="right">' . number_format($bor, 2) . '</td>';
				$total_bor += $dat_bor['JAMINAN_' . $dat_jaminan['JAMINAN_ID']];
			}
			echo '<td align="right">' . number_format(($total_bor / ($arr_bed[$ruang_id] * $jml_hari)) * 100,2) . '</td>';	
		?>
	</tr>
	<tr>
		<td align="center">12</td>
		<td>AvLOS (Hari)</td>
		<?php 
			$total_los = 0;
			$total_keluar = 0;
			mysql_data_seek($get_keluar,0);
			$dat_keluar = mysql_fetch_assoc($get_keluar);
			$avlos_lk = 0;
			$avlos_pr = 0;
			if($dat_keluar['JML_LK'] > 0) $avlos_lk = $dat_keluar['LOS_LK'] / $dat_keluar['JML_LK'];
			if($dat_keluar['JML_PR'] > 0) $avlos_pr = $dat_keluar['LOS_PR'] / $dat_keluar['JML_PR'];
			echo '<td align="right">' . number_format($avlos_lk,2) . '</td>';
			echo '<td align="right">' . number_format($avlos_pr,2) . '</td>';
			mysql_data_seek($get_jaminan,0);
			while($dat_jaminan = mysql_fetch_array($get_jaminan)){
				$avlos = 0;
				if($dat_keluar['JAMINAN_' . $dat_jaminan['JAMINAN_ID']] > 0){
					$avlos = $dat_keluar['LOS_JAMINAN_' . $dat_jaminan['JAMINAN_ID']] / $dat_keluar['JAMINAN_' . $dat_jaminan['JAMINAN_ID']];
				}
				echo '<td align="right">' . number_format($avlos,2) . '</td>';
				$total_keluar += $dat_keluar['JAMINAN_' . $dat_jaminan['JAMINAN_ID']];
				$total_los += $dat_keluar['LOS_JAMINAN_' . $dat_jaminan['JAMINAN_ID']];
			}	
			$avlos = 0;
			if($total_keluar > 0) $avlos = $total_los / $total_keluar;
			echo '<td align="right">' . number_format($avlos,2) . '</td>';		
		?>
	</tr>
	<tr>
		<td align="center">13</td>
		<td>GDR (%)</td>
		<?php 
			$total_meninggal = 0;
			$total_keluar = 0;
			mysql_data_seek($get_keluar,0);
			$dat_keluar = mysql_fetch_assoc($get_keluar);
			$gdr_lk = 0;
			$gdr_pr = 0;
			if($dat_keluar['JML_LK'] > 0) $gdr_lk = ($dat_keluar['JML_MENINGGAL_LK'] / $dat_keluar['JML_LK']) * 1000;
			if($dat_keluar['JML_PR'] > 0) $gdr_pr = ($dat_keluar['JML_MENINGGAL_PR'] / $dat_keluar['JML_PR']) * 1000;
			echo '<td align="right">' . number_format($gdr_lk,2) . '</td>';
			echo '<td align="right">' . number_format($gdr_pr,2) . '</td>';
			mysql_data_seek($get_jaminan,0);
			while($dat_jaminan = mysql_fetch_array($get_jaminan)){
				$gdr = 0;
				if($dat_keluar['JAMINAN_' . $dat_jaminan['JAMINAN_ID']] > 0){
					$gdr = ($dat_keluar['MENINGGAL_JAMINAN_' . $dat_jaminan['JAMINAN_ID']] / $dat_keluar['JAMINAN_' . $dat_jaminan['JAMINAN_ID']]) * 1000;
				}
				echo '<td align="right">' . number_format($gdr,2) . '</td>';
				$total_keluar += $dat_keluar['JAMINAN_' . $dat_jaminan['JAMINAN_ID']];
				$total_meninggal += $dat_keluar['MENINGGAL_JAMINAN_' . $dat_jaminan['JAMINAN_ID']];
			}	
			$gdr = 0;
			if($total_keluar > 0) $gdr = ($total_meninggal / $total_keluar) * 1000;
			echo '<td align="right">' . number_format($gdr,2) . '</td>';		
		?>
	</tr>
	<tr>
		<td align="center">14</td>
		<td>NDR (%)</td>
		<?php 
			$total_meninggal = 0;
			$total_keluar = 0;
			mysql_data_seek($get_keluar,0);
			$dat_keluar = mysql_fetch_assoc($get_keluar);
			$ndr_lk = 0;
			$ndr_pr = 0;
			if($dat_keluar['JML_LK'] > 0) $ndr_lk = ($dat_keluar['JML_MENINGGAL_M48_LK'] / $dat_keluar['JML_LK']) * 1000;
			if($dat_keluar['JML_PR'] > 0) $ndr_pr = ($dat_keluar['JML_MENINGGAL_M48_PR'] / $dat_keluar['JML_PR']) * 1000;
			echo '<td align="right">' . number_format($ndr_lk,2) . '</td>';
			echo '<td align="right">' . number_format($ndr_pr,2) . '</td>';
			mysql_data_seek($get_jaminan,0);
			while($dat_jaminan = mysql_fetch_array($get_jaminan)){
				$ndr = 0;
				if($dat_keluar['JAMINAN_' . $dat_jaminan['JAMINAN_ID']] > 0){
					$ndr = ($dat_keluar['MENINGGAL_M48_JAMINAN_' . $dat_jaminan['JAMINAN_ID']] / $dat_keluar['JAMINAN_' . $dat_jaminan['JAMINAN_ID']]) * 1000;
				}
				echo '<td align="right">' . number_format($ndr,2) . '</td>';
				$total_keluar += $dat_keluar['JAMINAN_' . $dat_jaminan['JAMINAN_ID']];
				$total_meninggal += $dat_keluar['MENINGGAL_M48_JAMINAN_' . $dat_jaminan['JAMINAN_ID']];
			}	
			$ndr = 0;
			if($total_keluar > 0) $ndr = ($total_meninggal / $total_keluar) * 1000;
			echo '<td align="right">' . number_format($ndr,2) . '</td>';
		?>
	</tr>
	<tr>
		<td align="center">15</td>
		<td>BTO (Kali)</td>
		<?php 
			$total_keluar = 0;
			mysql_data_seek($get_keluar,0);
			$dat_keluar = mysql_fetch_assoc($get_keluar);
			$bto_lk = 0;
			$bto_pr = 0;
			if($arr_bed[$ruang_id] > 0) {
				$bto_lk = $dat_keluar['JML_LK'] / $arr_bed[$ruang_id];
				$bto_pr = $dat_keluar['JML_PR'] / $arr_bed[$ruang_id];
			}	
			echo '<td align="right">' . number_format($bto_lk,2) . '</td>';
			echo '<td align="right">' . number_format($bto_pr,2) . '</td>';
			mysql_data_seek($get_jaminan,0);
			while($dat_jaminan = mysql_fetch_array($get_jaminan)){
				$bto = 0;
				if($arr_bed[$ruang_id] > 0){
					$bto = $dat_keluar['JAMINAN_' . $dat_jaminan['JAMINAN_ID']] / $arr_bed[$ruang_id];
				}
				echo '<td align="right">' . number_format($bto,2) . '</td>';
				$total_keluar += $dat_keluar['JAMINAN_' . $dat_jaminan['JAMINAN_ID']];
			}	
			$bto = 0;
			if($arr_bed[$ruang_id] > 0) $bto = $total_keluar / $arr_bed[$ruang_id];
			echo '<td align="right">' . number_format($bto,2) . '</td>';	
		?>
	</tr>
	<tr>
		<td align="center">16</td>
		<td>TOI (Hari)</td>
		<?php 
			$total_keluar = 0;
			$total_hari_perawatan = 0;
			mysql_data_seek($get_keluar,0);
			mysql_data_seek($get_hari_perawatan,0);
			$dat_keluar = mysql_fetch_assoc($get_keluar);
			$dat_hari_perawatan = mysql_fetch_assoc($get_hari_perawatan);
			$toi_lk = (($arr_bed[$ruang_id] * $jml_hari) - $dat_hari_perawatan['JML_LK']) /	$dat_keluar['JML_LK'];
			$toi_pr = (($arr_bed[$ruang_id] * $jml_hari) - $dat_hari_perawatan['JML_PR']) /	$dat_keluar['JML_PR'];
			echo '<td align="right">' . number_format($toi_lk,2) . '</td>';
			echo '<td align="right">' . number_format($toi_pr,2) . '</td>';
			mysql_data_seek($get_jaminan,0);
			while($dat_jaminan = mysql_fetch_array($get_jaminan)){
				$toi = 0;
				if($dat_keluar['JAMINAN_' . $dat_jaminan['JAMINAN_ID']] > 0){
					$toi = (($arr_bed[$ruang_id] * $jml_hari) - $dat_hari_perawatan['JAMINAN_' . $dat_jaminan['JAMINAN_ID']]) / $dat_keluar['JAMINAN_' . $dat_jaminan['JAMINAN_ID']];
				}	
				echo '<td align="right">' . number_format($toi,2) . '</td>';
				$total_keluar += $dat_keluar['JAMINAN_' . $dat_jaminan['JAMINAN_ID']];
				$total_hari_perawatan += $dat_hari_perawatan['JAMINAN_' . $dat_jaminan['JAMINAN_ID']];
			}	
			$toi = (($arr_bed[$ruang_id] * $jml_hari) - $total_hari_perawatan) / $total_keluar;
			echo '<td align="right">' . number_format($toi,2) . '</td>';	
		?>
	</tr>
	<tr>
		<td align="center">17</td>
		<td>Tempat Tidur</td>
		<?php 
			echo '<td align="right">' . $arr_bed[$ruang_id] . '</td>';
			echo '<td align="right">' . $arr_bed[$ruang_id] . '</td>';
			mysql_data_seek($get_jaminan,0);
			while($dat_jaminan = mysql_fetch_array($get_jaminan)){
				echo '<td align="right">' . $arr_bed[$ruang_id] . '</td>';
			}	
			echo '<td align="right">' . $arr_bed[$ruang_id] . '</td>';
		?>
	</tr>
</table>
<form id="xls_export" name="xls_export" method="post">
    <input type="hidden" name="page_to_excel" value="1" />
    <input type="hidden" name="tahun" value="<?php echo $tahun; ?>" />
    <input type="hidden" name="bulan" value="<?php echo $bulan; ?>" />
	<input type="hidden" name="ruang_id" value="<?php echo $ruang_id; ?>" />
    <input type="hidden" name="xlsfile" value="rawatinap/xls_ranap_report_dirawat_dan_keluar.php" />
    <input type="hidden" name="xlsname" value="rpt_dirawat_dan_keluar.xls" />            
</form>	