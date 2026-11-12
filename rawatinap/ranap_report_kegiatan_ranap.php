<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tahun = date('Y');
if (isset($_SESSION['ranapkegiatan_tahun']))
    $tahun = $_SESSION['ranapkegiatan_tahun'];
$bulan = date('m');
if (isset($_SESSION['ranapkegiatan_tahun']))
    $bulan = $_SESSION['ranapkegiatan_bulan'];
if (isset($_GET['tahun'])) {
    $tahun = $_GET['tahun'];
    $_SESSION['ranapkegiatan_tahun'] = $_GET['tahun'];
}
if (isset($_GET['bulan'])) {
    $bulan = $_GET['bulan'];
    $_SESSION['ranapkegiatan_bulan'] = $_GET['bulan'];
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
            <td colspan="2" align="right"><input type="submit" value="cari" class="myButton" />&nbsp;
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
	$qry_ruang_umum = 'SELECT m_ruang.RUANG_ID,
					CONCAT(TRIM(REPLACE(m_ruang.NAMA_RUANG,"R.R. ",""))," Kelas ",m_ruang.KELAS_RAWAT) AS NAMA_RUANG,
					CASE WHEN UPPER(m_ruang.JNS_PERAWATAN) <> "KUSTA" THEN "UMUM"
					ELSE "KUSTA" END AS JNS_PERAWATAN
				FROM m_ruang
				WHERE m_ruang.ST_AKTIF = "1"
				AND UPPER(m_ruang.JNS_PERAWATAN) <> "KUSTA"
				ORDER BY TRIM(REPLACE(m_ruang.NAMA_RUANG,"R.R. ",""))';
	$get_ruang_umum = mysql_query($qry_ruang_umum) or die(mysql_error());
	$jrow_umum = mysql_num_rows($get_ruang_umum);	
	$qry_ruang_kusta = 'SELECT m_ruang.RUANG_ID,
					CONCAT(TRIM(REPLACE(m_ruang.NAMA_RUANG,"R.R. ",""))," Kelas ",m_ruang.KELAS_RAWAT) AS NAMA_RUANG
				FROM m_ruang
				WHERE m_ruang.ST_AKTIF = "1"
				AND UPPER(m_ruang.JNS_PERAWATAN) = "KUSTA"
				ORDER BY TRIM(REPLACE(m_ruang.NAMA_RUANG,"R.R. ",""))';
	$get_ruang_kusta = mysql_query($qry_ruang_kusta) or die(mysql_error());
	$jrow_kusta = mysql_num_rows($get_ruang_kusta);
?>
<style>
div.vertical
{
 margin-left: -205px;
 position: absolute;
 width: 450px;
 transform: rotate(-90deg);
 -webkit-transform: rotate(-90deg); /* Safari/Chrome */
 -moz-transform: rotate(-90deg); /* Firefox */
 -o-transform: rotate(-90deg); /* Opera */
 -ms-transform: rotate(-90deg); /* IE 9 */
}

th.vertical
{
 height: 220px;
 width: 320px;
 line-height: 14px;
 padding-bottom: 220px;
}
</style>
<table border="1" class="tableData" id="tfhover">
    <tr>
        <th rowspan="3">No</th>
		<th rowspan="3">Kegiatan</th>
        <th colspan="<?php echo $jrow_umum + $jrow_kusta; ?>">Ruang Perawatan </th>
        <th rowspan="3" class="vertical" style="text-align:left;"><div class="vertical">Ruang Rawat Umum</div></th>
        <th rowspan="3" class="vertical" style="text-align:left;"><div class="vertical">Ruang Rawat Kusta</div></th>
		<th rowspan="3" class="vertical" style="text-align:left;"><div class="vertical">Total</div></th>
    </tr>
    <tr>
      <th colspan="<?php echo $jrow_umum; ?>" >Ruang Rawat Umum</th>
      <th colspan="<?php echo $jrow_kusta; ?>" >Ruang Rawat Kusta</th>
    </tr>
    <tr>
      <?php
		while($dat_ruang_umum = mysql_fetch_array($get_ruang_umum)){
			echo '<th class="vertical" style="text-align:left;"><div class="vertical">' . $dat_ruang_umum['NAMA_RUANG'] . '</div></th>';	
		}
		while($dat_ruang_kusta = mysql_fetch_array($get_ruang_kusta)){
			echo '<th class="vertical" style="text-align:left;"><div class="vertical">' . $dat_ruang_kusta['NAMA_RUANG'] . '</div></th>';	
		}
	  ?>
    </tr>
	<tr>
		<td align="center">1</td>
		<td>Pasien Awal</td>
		<?php 
			$qry_awal = 'SELECT ';
			mysql_data_seek($get_ruang_umum,0);
			while($dat_ruang_umum = mysql_fetch_array($get_ruang_umum)){
				$qry_awal .= 'COUNT(CASE WHEN t_irna_opname.RUANG_ID = ' . $dat_ruang_umum['RUANG_ID'] . ' THEN t_irna_opname.IRNA_ID END) AS RUANG_' . $dat_ruang_umum['RUANG_ID'] . ',';
			}
			mysql_data_seek($get_ruang_kusta,0);
			while($dat_ruang_kusta = mysql_fetch_array($get_ruang_kusta)){
				$qry_awal .= 'COUNT(CASE WHEN t_irna_opname.RUANG_ID = ' . $dat_ruang_kusta['RUANG_ID'] . ' THEN t_irna_opname.IRNA_ID END) AS RUANG_' . $dat_ruang_kusta['RUANG_ID'] . ',';
			}
			$qry_awal = substr($qry_awal,0,strlen($qry_awal)-1);
			$qry_awal .= ' FROM t_irna_opname
				WHERE t_irna_opname.TANGGAL_OPNAME = DATE_ADD(STR_TO_DATE("01/' . $bulan . '/' . $tahun . '","%d/%m/%Y"),INTERVAL -1 DAY)';
			$get_awal = mysql_query($qry_awal) or die(mysql_error());
			$total_awal_umum = 0;
			$total_awal_kusta = 0;
			$total_awal = 0;
			while($dat_awal = mysql_fetch_array($get_awal)){
				mysql_data_seek($get_ruang_umum,0);
				while($dat_ruang_umum = mysql_fetch_array($get_ruang_umum)){
					echo '<td align="right">' . $dat_awal['RUANG_' . $dat_ruang_umum['RUANG_ID']] . '</td>';
					$total_awal_umum += $dat_awal['RUANG_' . $dat_ruang_umum['RUANG_ID']];
					$total_awal += $dat_awal['RUANG_' . $dat_ruang_umum['RUANG_ID']];
				}
				mysql_data_seek($get_ruang_kusta,0);
				while($dat_ruang_kusta = mysql_fetch_array($get_ruang_kusta)){
					echo '<td align="right">' . $dat_awal['RUANG_' . $dat_ruang_kusta['RUANG_ID']] . '</td>';
					$total_awal_kusta += $dat_awal['RUANG_' . $dat_ruang_kusta['RUANG_ID']];
					$total_awal += $dat_awal['RUANG_' . $dat_ruang_kusta['RUANG_ID']];
				}	
			}
			echo '<td align="right">' . $total_awal_umum . '</td>';	
			echo '<td align="right">' . $total_awal_kusta . '</td>';	
			echo '<td align="right">' . $total_awal . '</td>';	
		?>
	</tr>
	<tr>
		<td align="center">2</td>
		<td>Pasien Masuk</td>
		<?php 
			$qry_masuk = 'SELECT ';
			mysql_data_seek($get_ruang_umum,0);
			while($dat_ruang_umum = mysql_fetch_array($get_ruang_umum)){
				$qry_masuk .= 'COUNT(CASE WHEN t_irna_log.RUANG_ID_BARU = ' . $dat_ruang_umum['RUANG_ID'] . ' THEN t_irna_log.IRNA_ID END) AS RUANG_' . $dat_ruang_umum['RUANG_ID'] . ',';
			}
			mysql_data_seek($get_ruang_kusta,0);
			while($dat_ruang_kusta = mysql_fetch_array($get_ruang_kusta)){
				$qry_masuk .= 'COUNT(CASE WHEN t_irna_log.RUANG_ID_BARU = ' . $dat_ruang_kusta['RUANG_ID'] . ' THEN t_irna_log.IRNA_ID END) AS RUANG_' . $dat_ruang_kusta['RUANG_ID'] . ',';
			}
			$qry_masuk = substr($qry_masuk,0,strlen($qry_masuk)-1);
			$qry_masuk .= ' FROM t_irna_log
				WHERE t_irna_log.JNS_UPDATE = "R" 
				AND t_irna_log.RUANG_ID_ASAL IS NULL
				AND DATE_FORMAT(t_irna_log.TANGGAL_MASUK,"%m%Y") = "' . $bulan . $tahun . '"';
			$get_masuk = mysql_query($qry_masuk) or die(mysql_error());
			$total_masuk_umum = 0;
			$total_masuk_kusta = 0;
			$total_masuk = 0;
			while($dat_masuk = mysql_fetch_array($get_masuk)){
				mysql_data_seek($get_ruang_umum,0);
				while($dat_ruang_umum = mysql_fetch_array($get_ruang_umum)){
					echo '<td align="right">' . $dat_masuk['RUANG_' . $dat_ruang_umum['RUANG_ID']] . '</td>';
					$total_masuk_umum += $dat_masuk['RUANG_' . $dat_ruang_umum['RUANG_ID']];
					$total_masuk += $dat_masuk['RUANG_' . $dat_ruang_umum['RUANG_ID']];
				}
				mysql_data_seek($get_ruang_kusta,0);
				while($dat_ruang_kusta = mysql_fetch_array($get_ruang_kusta)){
					echo '<td align="right">' . $dat_masuk['RUANG_' . $dat_ruang_kusta['RUANG_ID']] . '</td>';
					$total_masuk_kusta += $dat_masuk['RUANG_' . $dat_ruang_kusta['RUANG_ID']];
					$total_masuk += $dat_masuk['RUANG_' . $dat_ruang_kusta['RUANG_ID']];
				}	
			}
			echo '<td align="right">' . $total_masuk_umum . '</td>';	
			echo '<td align="right">' . $total_masuk_kusta . '</td>';	
			echo '<td align="right">' . $total_masuk . '</td>';	
		?>
	</tr>
	<tr>
		<td align="center">3</td>
		<td>Pasien Keluar Hidup + Meninggal</td>
		<?php 
			$qry_keluar = 'SELECT ';
			mysql_data_seek($get_ruang_umum,0);
			while($dat_ruang_umum = mysql_fetch_array($get_ruang_umum)){
				$qry_keluar .= 'COUNT(CASE WHEN t_irna_log.RUANG_ID_ASAL = ' . $dat_ruang_umum['RUANG_ID'] . ' THEN t_irna_log.IRNA_ID END) AS RUANG_' . $dat_ruang_umum['RUANG_ID'] . ',';
			}
			mysql_data_seek($get_ruang_kusta,0);
			while($dat_ruang_kusta = mysql_fetch_array($get_ruang_kusta)){
				$qry_keluar .= 'COUNT(CASE WHEN t_irna_log.RUANG_ID_ASAL = ' . $dat_ruang_kusta['RUANG_ID'] . ' THEN t_irna_log.IRNA_ID END) AS RUANG_' . $dat_ruang_kusta['RUANG_ID'] . ',';
			}
			$qry_keluar = substr($qry_keluar,0,strlen($qry_keluar)-1);
			$qry_keluar .= ' FROM t_irna_log
				WHERE t_irna_log.JNS_UPDATE = "R" 
				AND t_irna_log.RUANG_ID_BARU IS NULL
				AND DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m%Y") = "' . $bulan . $tahun . '"';
			$get_keluar = mysql_query($qry_keluar) or die(mysql_error());
			$total_keluar_umum = 0;
			$total_keluar_kusta = 0;
			$total_keluar = 0;
			while($dat_keluar = mysql_fetch_array($get_keluar)){
				mysql_data_seek($get_ruang_umum,0);
				while($dat_ruang_umum = mysql_fetch_array($get_ruang_umum)){
					echo '<td align="right">' . $dat_keluar['RUANG_' . $dat_ruang_umum['RUANG_ID']] . '</td>';
					$total_keluar_umum += $dat_keluar['RUANG_' . $dat_ruang_umum['RUANG_ID']];
					$total_keluar += $dat_keluar['RUANG_' . $dat_ruang_umum['RUANG_ID']];
				}
				mysql_data_seek($get_ruang_kusta,0);
				while($dat_ruang_kusta = mysql_fetch_array($get_ruang_kusta)){
					echo '<td align="right">' . $dat_keluar['RUANG_' . $dat_ruang_kusta['RUANG_ID']] . '</td>';
					$total_keluar_kusta += $dat_keluar['RUANG_' . $dat_ruang_kusta['RUANG_ID']];
					$total_keluar += $dat_keluar['RUANG_' . $dat_ruang_kusta['RUANG_ID']];
				}	
			}
			echo '<td align="right">' . $total_keluar_umum . '</td>';	
			echo '<td align="right">' . $total_keluar_kusta . '</td>';	
			echo '<td align="right">' . $total_keluar . '</td>';	
		?>
	</tr>
	<tr>
		<td align="center">4</td>
		<td>Pasien Keluar Meninggal</td>
		<?php 
			$qry_keluar_meninggal = 'SELECT ';
			mysql_data_seek($get_ruang_umum,0);
			while($dat_ruang_umum = mysql_fetch_array($get_ruang_umum)){
				$qry_keluar_meninggal .= 'COUNT(CASE WHEN t_irna_log.RUANG_ID_ASAL = ' . $dat_ruang_umum['RUANG_ID'] . ' THEN t_irna_log.IRNA_ID END) AS RUANG_' . $dat_ruang_umum['RUANG_ID'] . ',';
			}
			mysql_data_seek($get_ruang_kusta,0);
			while($dat_ruang_kusta = mysql_fetch_array($get_ruang_kusta)){
				$qry_keluar_meninggal .= 'COUNT(CASE WHEN t_irna_log.RUANG_ID_ASAL = ' . $dat_ruang_kusta['RUANG_ID'] . ' THEN t_irna_log.IRNA_ID END) AS RUANG_' . $dat_ruang_kusta['RUANG_ID'] . ',';
			}
			$qry_keluar_meninggal = substr($qry_keluar_meninggal,0,strlen($qry_keluar_meninggal)-1);
			$qry_keluar_meninggal .= ' FROM t_irna_log
				WHERE t_irna_log.JNS_UPDATE = "R" 
				AND t_irna_log.RUANG_ID_BARU IS NULL
				AND (t_irna_log.PASIEN_PULANG_ID = 3 OR t_irna_log.PASIEN_PULANG_ID = 8)
				AND DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m%Y") = "' . $bulan . $tahun . '"';
			$get_keluar_meninggal = mysql_query($qry_keluar_meninggal) or die(mysql_error());
			$total_keluar_meninggal_umum = 0;
			$total_keluar_meninggal_kusta = 0;
			$total_keluar_meninggal = 0;
			while($dat_keluar_meninggal = mysql_fetch_array($get_keluar_meninggal)){
				mysql_data_seek($get_ruang_umum,0);
				while($dat_ruang_umum = mysql_fetch_array($get_ruang_umum)){
					echo '<td align="right">' . $dat_keluar_meninggal['RUANG_' . $dat_ruang_umum['RUANG_ID']] . '</td>';
					$total_keluar_meninggal_umum += $dat_keluar_meninggal['RUANG_' . $dat_ruang_umum['RUANG_ID']];
					$total_keluar_meninggal += $dat_keluar_meninggal['RUANG_' . $dat_ruang_umum['RUANG_ID']];
				}
				mysql_data_seek($get_ruang_kusta,0);
				while($dat_ruang_kusta = mysql_fetch_array($get_ruang_kusta)){
					echo '<td align="right">' . $dat_keluar_meninggal['RUANG_' . $dat_ruang_kusta['RUANG_ID']] . '</td>';
					$total_keluar_meninggal_kusta += $dat_keluar_meninggal['RUANG_' . $dat_ruang_kusta['RUANG_ID']];
					$total_keluar_meninggal += $dat_keluar_meninggal['RUANG_' . $dat_ruang_kusta['RUANG_ID']];
				}	
			}
			echo '<td align="right">' . $total_keluar_meninggal_umum . '</td>';	
			echo '<td align="right">' . $total_keluar_meninggal_kusta . '</td>';	
			echo '<td align="right">' . $total_keluar_meninggal . '</td>';	
		?>
	</tr>
	<tr>
		<td align="center">5</td>
		<td>Pasien Meninggal < 48 Jam</td>
		<?php 
			$qry_keluar_meninggal_l48 = 'SELECT ';
			mysql_data_seek($get_ruang_umum,0);
			while($dat_ruang_umum = mysql_fetch_array($get_ruang_umum)){
				$qry_keluar_meninggal_l48 .= 'COUNT(CASE WHEN t_irna_log.RUANG_ID_ASAL = ' . $dat_ruang_umum['RUANG_ID'] . ' THEN t_irna_log.IRNA_ID END) AS RUANG_' . $dat_ruang_umum['RUANG_ID'] . ',';
			}
			mysql_data_seek($get_ruang_kusta,0);
			while($dat_ruang_kusta = mysql_fetch_array($get_ruang_kusta)){
				$qry_keluar_meninggal_l48 .= 'COUNT(CASE WHEN t_irna_log.RUANG_ID_ASAL = ' . $dat_ruang_kusta['RUANG_ID'] . ' THEN t_irna_log.IRNA_ID END) AS RUANG_' . $dat_ruang_kusta['RUANG_ID'] . ',';
			}
			$qry_keluar_meninggal_l48 = substr($qry_keluar_meninggal_l48,0,strlen($qry_keluar_meninggal_l48)-1);
			$qry_keluar_meninggal_l48 .= ' FROM t_irna_log
				WHERE t_irna_log.JNS_UPDATE = "R" 
				AND t_irna_log.RUANG_ID_BARU IS NULL
				AND (t_irna_log.PASIEN_KEADAAN_ID = 5 OR t_irna_log.PASIEN_KEADAAN_ID = 6
					OR t_irna_log.PASIEN_KEADAAN_ID = 7 OR t_irna_log.PASIEN_KEADAAN_ID = 9)
				AND DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m%Y") = "' . $bulan . $tahun . '"';
			$get_keluar_meninggal_l48 = mysql_query($qry_keluar_meninggal_l48) or die(mysql_error());
			$total_keluar_meninggal_l48_umum = 0;
			$total_keluar_meninggal_l48_kusta = 0;
			$total_keluar_meninggal_l48 = 0;
			while($dat_keluar_meninggal_l48 = mysql_fetch_array($get_keluar_meninggal_l48)){
				mysql_data_seek($get_ruang_umum,0);
				while($dat_ruang_umum = mysql_fetch_array($get_ruang_umum)){
					echo '<td align="right">' . $dat_keluar_meninggal_l48['RUANG_' . $dat_ruang_umum['RUANG_ID']] . '</td>';
					$total_keluar_meninggal_l48_umum += $dat_keluar_meninggal_l48['RUANG_' . $dat_ruang_umum['RUANG_ID']];
					$total_keluar_meninggal_l48 += $dat_keluar_meninggal_l48['RUANG_' . $dat_ruang_umum['RUANG_ID']];
				}
				mysql_data_seek($get_ruang_kusta,0);
				while($dat_ruang_kusta = mysql_fetch_array($get_ruang_kusta)){
					echo '<td align="right">' . $dat_keluar_meninggal_l48['RUANG_' . $dat_ruang_kusta['RUANG_ID']] . '</td>';
					$total_keluar_meninggal_l48_kusta += $dat_keluar_meninggal_l48['RUANG_' . $dat_ruang_kusta['RUANG_ID']];
					$total_keluar_meninggal_l48 += $dat_keluar_meninggal_l48['RUANG_' . $dat_ruang_kusta['RUANG_ID']];
				}	
			}
			echo '<td align="right">' . $total_keluar_meninggal_l48_umum . '</td>';	
			echo '<td align="right">' . $total_keluar_meninggal_l48_kusta . '</td>';	
			echo '<td align="right">' . $total_keluar_meninggal_l48 . '</td>';	
		?>
	</tr>
	<tr>
		<td align="center">6</td>
		<td>Pasien Meninggal &#8805; 48 Jam</td>
		<?php 
			$qry_keluar_meninggal_m48 = 'SELECT ';
			mysql_data_seek($get_ruang_umum,0);
			while($dat_ruang_umum = mysql_fetch_array($get_ruang_umum)){
				$qry_keluar_meninggal_m48 .= 'COUNT(CASE WHEN t_irna_log.RUANG_ID_ASAL = ' . $dat_ruang_umum['RUANG_ID'] . ' THEN t_irna_log.IRNA_ID END) AS RUANG_' . $dat_ruang_umum['RUANG_ID'] . ',';
			}
			mysql_data_seek($get_ruang_kusta,0);
			while($dat_ruang_kusta = mysql_fetch_array($get_ruang_kusta)){
				$qry_keluar_meninggal_m48 .= 'COUNT(CASE WHEN t_irna_log.RUANG_ID_ASAL = ' . $dat_ruang_kusta['RUANG_ID'] . ' THEN t_irna_log.IRNA_ID END) AS RUANG_' . $dat_ruang_kusta['RUANG_ID'] . ',';
			}
			$qry_keluar_meninggal_m48 = substr($qry_keluar_meninggal_m48,0,strlen($qry_keluar_meninggal_m48)-1);
			$qry_keluar_meninggal_m48 .= ' FROM t_irna_log
				WHERE t_irna_log.JNS_UPDATE = "R" AND t_irna_log.RUANG_ID_BARU IS NULL
				AND t_irna_log.PASIEN_KEADAAN_ID = 8
				AND DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m%Y") = "' . $bulan . $tahun . '"';
			$get_keluar_meninggal_m48 = mysql_query($qry_keluar_meninggal_m48) or die(mysql_error());
			$total_keluar_meninggal_m48_umum = 0;
			$total_keluar_meninggal_m48_kusta = 0;
			$total_keluar_meninggal_m48 = 0;
			while($dat_keluar_meninggal_m48 = mysql_fetch_array($get_keluar_meninggal_m48)){
				mysql_data_seek($get_ruang_umum,0);
				while($dat_ruang_umum = mysql_fetch_array($get_ruang_umum)){
					echo '<td align="right">' . $dat_keluar_meninggal_m48['RUANG_' . $dat_ruang_umum['RUANG_ID']] . '</td>';
					$total_keluar_meninggal_m48_umum += $dat_keluar_meninggal_m48['RUANG_' . $dat_ruang_umum['RUANG_ID']];
					$total_keluar_meninggal_m48 += $dat_keluar_meninggal_m48['RUANG_' . $dat_ruang_umum['RUANG_ID']];
				}
				mysql_data_seek($get_ruang_kusta,0);
				while($dat_ruang_kusta = mysql_fetch_array($get_ruang_kusta)){
					echo '<td align="right">' . $dat_keluar_meninggal_m48['RUANG_' . $dat_ruang_kusta['RUANG_ID']] . '</td>';
					$total_keluar_meninggal_m48_kusta += $dat_keluar_meninggal_m48['RUANG_' . $dat_ruang_kusta['RUANG_ID']];
					$total_keluar_meninggal_m48 += $dat_keluar_meninggal_m48['RUANG_' . $dat_ruang_kusta['RUANG_ID']];
				}	
			}
			echo '<td align="right">' . $total_keluar_meninggal_m48_umum . '</td>';	
			echo '<td align="right">' . $total_keluar_meninggal_m48_kusta . '</td>';	
			echo '<td align="right">' . $total_keluar_meninggal_m48 . '</td>';	
		?>
	</tr>
	<tr>
		<td align="center">7</td>
		<td>Hari Perawatan (HP)</td>
		<?php 
			$qry_hari_perawatan = 'SELECT ';
			mysql_data_seek($get_ruang_umum,0);
			while($dat_ruang_umum = mysql_fetch_array($get_ruang_umum)){
				$qry_hari_perawatan .= 'COUNT(CASE WHEN t_pasien.RUANG_ID = ' . $dat_ruang_umum['RUANG_ID'] . ' THEN t_pasien.IRNA_ID END) AS RUANG_' . $dat_ruang_umum['RUANG_ID'] . ',';
			}
			mysql_data_seek($get_ruang_kusta,0);
			while($dat_ruang_kusta = mysql_fetch_array($get_ruang_kusta)){
				$qry_hari_perawatan .= 'COUNT(CASE WHEN t_pasien.RUANG_ID = ' . $dat_ruang_kusta['RUANG_ID'] . ' THEN t_pasien.IRNA_ID END) AS RUANG_' . $dat_ruang_kusta['RUANG_ID'] . ',';
			}
			$qry_hari_perawatan = substr($qry_hari_perawatan,0,strlen($qry_hari_perawatan)-1);
			$qry_hari_perawatan .= ' FROM 
							(SELECT t_irna_opname.IRNA_ID,t_irna_opname.RUANG_ID
							FROM t_irna_opname 
							WHERE DATE_FORMAT(t_irna_opname.TANGGAL_OPNAME,"%m/%Y") = "' . $bulan . '/' . $tahun . '"
							UNION ALL
							SELECT t_pasien_log.IRNA_ID,t_pasien_log.RUANG_ID
							FROM (SELECT t_irna_log.IRNA_ID,t_irna_log.RUANG_ID_ASAL AS RUANG_ID,
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
							) t_pasien_log
							WHERE DATE_FORMAT(t_pasien_log.TANGGAL_MASUK,"%d%m%Y") = DATE_FORMAT(t_pasien_log.TANGGAL_KELUAR,"%d%m%Y")
						) t_pasien';
			$get_hari_perawatan = mysql_query($qry_hari_perawatan) or die(mysql_error());
			$total_hari_perawatan_umum = 0;
			$total_hari_perawatan_kusta = 0;
			$total_hari_perawatan = 0;
			while($dat_hari_perawatan = mysql_fetch_array($get_hari_perawatan)){
				mysql_data_seek($get_ruang_umum,0);
				while($dat_ruang_umum = mysql_fetch_array($get_ruang_umum)){
					echo '<td align="right">' . $dat_hari_perawatan['RUANG_' . $dat_ruang_umum['RUANG_ID']] . '</td>';
					$total_hari_perawatan_umum += $dat_hari_perawatan['RUANG_' . $dat_ruang_umum['RUANG_ID']];
					$total_hari_perawatan += $dat_hari_perawatan['RUANG_' . $dat_ruang_umum['RUANG_ID']];
				}
				mysql_data_seek($get_ruang_kusta,0);
				while($dat_ruang_kusta = mysql_fetch_array($get_ruang_kusta)){
					echo '<td align="right">' . $dat_hari_perawatan['RUANG_' . $dat_ruang_kusta['RUANG_ID']] . '</td>';
					$total_hari_perawatan_kusta += $dat_hari_perawatan['RUANG_' . $dat_ruang_kusta['RUANG_ID']];
					$total_hari_perawatan += $dat_hari_perawatan['RUANG_' . $dat_ruang_kusta['RUANG_ID']];
				}	
			}
			echo '<td align="right">' . $total_hari_perawatan_umum . '</td>';	
			echo '<td align="right">' . $total_hari_perawatan_kusta . '</td>';	
			echo '<td align="right">' . $total_hari_perawatan . '</td>';	
		?>
	</tr>
	<tr>
		<td align="center">8</td>
		<td>LOS (Hari)</td>
		<?php 
			$qry_los = 'SELECT ';
			mysql_data_seek($get_ruang_umum,0);
			while($dat_ruang_umum = mysql_fetch_array($get_ruang_umum)){
				$qry_los .= 'SUM(CASE WHEN t_irna_log.RUANG_ID_ASAL = ' . $dat_ruang_umum['RUANG_ID'] . ' 
									THEN DATEDIFF(t_irna_log.TANGGAL_KELUAR,
													(SELECT t.TANGGAL_MASUK FROM t_irna_log t 
													WHERE t.IRNA_ID = t_irna_log.IRNA_ID
													AND t.JNS_UPDATE = "R"
													AND t.RUANG_ID_BARU IS NOT NULL
													AND t.RUANG_ID_ASAL IS NULL
													ORDER BY t.TANGGAL_MASUK ASC LIMIT 1)) + 1
									ELSE 0 END) AS RUANG_' . $dat_ruang_umum['RUANG_ID'] . ',
							COUNT(DISTINCT CASE WHEN t_irna_log.RUANG_ID_ASAL = ' . $dat_ruang_umum['RUANG_ID'] . ' 
									THEN t_irna_log.IRNA_ID END) AS JML_KELUAR_' . $dat_ruang_umum['RUANG_ID'] . ',';
			}
			mysql_data_seek($get_ruang_kusta,0);
			while($dat_ruang_kusta = mysql_fetch_array($get_ruang_kusta)){
				$qry_los .= 'SUM(CASE WHEN t_irna_log.RUANG_ID_ASAL = ' . $dat_ruang_kusta['RUANG_ID'] . ' 
									THEN DATEDIFF(t_irna_log.TANGGAL_KELUAR,
													(SELECT t.TANGGAL_MASUK FROM t_irna_log t 
													WHERE t.IRNA_ID = t_irna_log.IRNA_ID
													AND t.JNS_UPDATE = "R"
													AND t.RUANG_ID_BARU IS NOT NULL
													AND t.RUANG_ID_ASAL IS NULL
													ORDER BY t.TANGGAL_MASUK ASC LIMIT 1)) + 1
									ELSE 0 END) AS RUANG_' . $dat_ruang_kusta['RUANG_ID'] . ',
							COUNT(DISTINCT CASE WHEN t_irna_log.RUANG_ID_ASAL = ' . $dat_ruang_kusta['RUANG_ID'] . ' 
									THEN t_irna_log.IRNA_ID END) AS JML_KELUAR_' . $dat_ruang_kusta['RUANG_ID'] . ',';
			}
			$qry_los = substr($qry_los,0,strlen($qry_los)-1);
			$qry_los .= ' FROM t_irna_log
				WHERE t_irna_log.JNS_UPDATE = "R"
				AND t_irna_log.RUANG_ID_BARU IS NULL
				AND DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m%Y") = "' . $bulan . $tahun . '"';
			$get_los = mysql_query($qry_los) or die(mysql_error());
			$total_los_umum = 0;
			$total_los_kusta = 0;
			$total_los = 0;
			while($dat_los = mysql_fetch_array($get_los)){
				mysql_data_seek($get_ruang_umum,0);
				while($dat_ruang_umum = mysql_fetch_array($get_ruang_umum)){
					echo '<td align="right">' . $dat_los['RUANG_' . $dat_ruang_umum['RUANG_ID']] . '</td>';
					$total_los_umum += $dat_los['RUANG_' . $dat_ruang_umum['RUANG_ID']];
					$total_los += $dat_los['RUANG_' . $dat_ruang_umum['RUANG_ID']];
				}
				mysql_data_seek($get_ruang_kusta,0);
				while($dat_ruang_kusta = mysql_fetch_array($get_ruang_kusta)){
					echo '<td align="right">' . $dat_los['RUANG_' . $dat_ruang_kusta['RUANG_ID']] . '</td>';
					$total_los_kusta += $dat_los['RUANG_' . $dat_ruang_kusta['RUANG_ID']];
					$total_los += $dat_los['RUANG_' . $dat_ruang_kusta['RUANG_ID']];
				}	
			}
			echo '<td align="right">' . $total_los_umum . '</td>';	
			echo '<td align="right">' . $total_los_kusta . '</td>';	
			echo '<td align="right">' . $total_los . '</td>';	
		?>
	</tr>
	<tr>
		<td align="center">9</td>
		<td>BOR (%)</td>
		<?php 
			$qry_bed = 'SELECT m_ruang.RUANG_ID,COUNT(m_ruang_detail.RUANG_DETAIL_ID) AS JML_BED,
						DATE_FORMAT(LAST_DAY(STR_TO_DATE("01' . $bulan . $tahun . '","%d%m%Y")),"%d") AS LD
						FROM m_ruang
						LEFT JOIN m_ruang_detail ON (m_ruang.RUANG_ID = m_ruang_detail.RUANG_ID)
						GROUP BY m_ruang.RUANG_ID';
			$get_bed = mysql_query($qry_bed) or die(mysql_error());
			$arr_bed = array();
			$jml_hari = 0;
			while($dat_bed = mysql_fetch_array($get_bed)){
				$arr_bed[$dat_bed['RUANG_ID']] = $dat_bed['JML_BED'];
				$jml_hari = $dat_bed['LD'];	
			}	
			mysql_data_seek($get_hari_perawatan,0);
			$total_bor_jml_perawatan_umum = 0;
			$total_bor_jml_perawatan_kusta = 0;
			$total_bor_jml_bed_umum = 0;
			$total_bor_jml_bed_kusta = 0;
			while($dat_bor = mysql_fetch_array($get_hari_perawatan)){
				mysql_data_seek($get_ruang_umum,0);
				while($dat_ruang_umum = mysql_fetch_array($get_ruang_umum)){
					$bor = 0;
					if($arr_bed[$dat_ruang_umum['RUANG_ID']] > 0){
						$bor = ($dat_bor['RUANG_' . $dat_ruang_umum['RUANG_ID']] / ($arr_bed[$dat_ruang_umum['RUANG_ID']] * $jml_hari)) * 100;
					}
					echo '<td align="right">' . number_format($bor, 2) . '</td>';
					$total_bor_jml_perawatan_umum += $dat_bor['RUANG_' . $dat_ruang_umum['RUANG_ID']];
					$total_bor_jml_bed_umum += $arr_bed[$dat_ruang_umum['RUANG_ID']];
				}
				mysql_data_seek($get_ruang_kusta,0);
				while($dat_ruang_kusta = mysql_fetch_array($get_ruang_kusta)){
					$bor = 0;
					if($arr_bed[$dat_ruang_kusta['RUANG_ID']] > 0){ 
						$bor = ($dat_bor['RUANG_' . $dat_ruang_kusta['RUANG_ID']] / ($arr_bed[$dat_ruang_kusta['RUANG_ID']] * $jml_hari)) * 100;
					}
					echo '<td align="right">' . number_format($bor, 2) . '</td>';
					$total_bor_jml_perawatan_kusta += $dat_bor['RUANG_' . $dat_ruang_kusta['RUANG_ID']];
					$total_bor_jml_bed_kusta += $arr_bed[$dat_ruang_kusta['RUANG_ID']];
				}	
			}
			echo '<td align="right">' . number_format(($total_bor_jml_perawatan_umum / ($total_bor_jml_bed_umum * $jml_hari)) * 100,2) . '</td>';	
			echo '<td align="right">' . number_format(($total_bor_jml_perawatan_kusta / ($total_bor_jml_bed_kusta * $jml_hari)) * 100,2) . '</td>';	
			echo '<td align="right">' . number_format((($total_bor_jml_perawatan_umum + $total_bor_jml_perawatan_kusta) / (($total_bor_jml_bed_umum + $total_bor_jml_bed_kusta) * $jml_hari)) * 100,2) . '</td>';	
		?>
	</tr>
	<tr>
		<td align="center">10</td>
		<td>AvLOS (Hari)</td>
		<?php 
			$total_los_umum = 0;
			$total_pasien_umum = 0;
			$total_los_kusta = 0;
			$total_pasien_kusta = 0;
			mysql_data_seek($get_los,0);
			while($dat_avlos = mysql_fetch_array($get_los)){
				mysql_data_seek($get_ruang_umum,0);
				while($dat_ruang_umum = mysql_fetch_array($get_ruang_umum)){
					$avlos = 0;
					if($dat_avlos['JML_KELUAR_' . $dat_ruang_umum['RUANG_ID']] > 0){
						$avlos = $dat_avlos['RUANG_' . $dat_ruang_umum['RUANG_ID']] / $dat_avlos['JML_KELUAR_' . $dat_ruang_umum['RUANG_ID']];
					}	
					echo '<td align="right">' . number_format($avlos,2)  . '</td>'; 	
					$total_los_umum += $dat_avlos['RUANG_' . $dat_ruang_umum['RUANG_ID']];
					$total_pasien_umum += $dat_avlos['JML_KELUAR_' . $dat_ruang_umum['RUANG_ID']];
				}
				mysql_data_seek($get_ruang_kusta,0);
				while($dat_ruang_kusta = mysql_fetch_array($get_ruang_kusta)){
					$avlos = 0;
					if($dat_avlos['JML_KELUAR_' . $dat_ruang_kusta['RUANG_ID']] > 0){
						$avlos = $dat_avlos['RUANG_' . $dat_ruang_kusta['RUANG_ID']] / $dat_avlos['JML_KELUAR_' . $dat_ruang_kusta['RUANG_ID']];
					}	
					echo '<td align="right">' . number_format($avlos,2)  . '</td>'; 	
					$total_los_kusta += $dat_avlos['RUANG_' . $dat_ruang_kusta['RUANG_ID']];
					$total_pasien_kusta += $dat_avlos['JML_KELUAR_' . $dat_ruang_kusta['RUANG_ID']];
				}	
			}
			$ttl_1 = 0;
			$ttl_2 = 0;
			$ttl_3 = 0;
			if($total_pasien_umum > 0) $ttl_1 = $total_los_umum / $total_pasien_umum;
			if($total_pasien_kusta > 0) $ttl_2 = $total_los_kusta / $total_pasien_umum;
			if(($total_pasien_umum + $total_pasien_kusta) > 0) $ttl_3 = ($total_los_umum + $total_los_umum) / ($total_pasien_umum + $total_pasien_umum);
			echo '<td align="right">' . number_format($ttl_1,2)  . '</td>';	
			echo '<td align="right">' . number_format($ttl_2,2) . '</td>';	
			echo '<td align="right">' . number_format($ttl_3,2) . '</td>';	
		?>
	</tr>
	<tr>
		<td align="center">11</td>
		<td>GDR (%)</td>
		<?php 
			$total_pasien_meninggal_umum = 0;
			$total_pasien_umum = 0;
			$total_pasien_meninggal_kusta = 0;
			$total_pasien_kusta = 0;
			mysql_data_seek($get_keluar_meninggal,0);
			$dat_keluar_meninggal = mysql_fetch_assoc($get_keluar_meninggal);
			mysql_data_seek($get_keluar,0);
			while($dat_gdr = mysql_fetch_array($get_keluar)){
				mysql_data_seek($get_ruang_umum,0);
				while($dat_ruang_umum = mysql_fetch_array($get_ruang_umum)){
					$gdr = 0;
					if($dat_gdr['RUANG_' . $dat_ruang_umum['RUANG_ID']] > 0){
						$gdr = ($dat_keluar_meninggal['RUANG_' . $dat_ruang_umum['RUANG_ID']] / $dat_gdr['RUANG_' . $dat_ruang_umum['RUANG_ID']]) * 1000;   
					}	
					echo '<td align="right">' . number_format($gdr,2)  . '</td>'; 	
					$total_pasien_meninggal_umum += $dat_keluar_meninggal['RUANG_' . $dat_ruang_umum['RUANG_ID']];
					$total_pasien_umum += $dat_gdr['RUANG_' . $dat_ruang_umum['RUANG_ID']];
				}
				mysql_data_seek($get_ruang_kusta,0);
				while($dat_ruang_kusta = mysql_fetch_array($get_ruang_kusta)){
					$gdr = 0;
					if($dat_gdr['RUANG_' . $dat_ruang_kusta['RUANG_ID']] > 0){
						$gdr = ($dat_keluar_meninggal['RUANG_' . $dat_ruang_kusta['RUANG_ID']] / $dat_gdr['RUANG_' . $dat_ruang_kusta['RUANG_ID']]) * 1000;   
					}	
					echo '<td align="right">' . number_format($gdr,2)  . '</td>'; 	
					$total_pasien_meninggal_kusta += $dat_keluar_meninggal['RUANG_' . $dat_ruang_kusta['RUANG_ID']];
					$total_pasien_kusta += $dat_gdr['RUANG_' . $dat_ruang_kusta['RUANG_ID']];
				}	
			}
			$total_gdr_umum = 0;
			$total_gdr_kusta = 0;
			$total_gdr = 0;
			if($total_pasien_umum > 0) $total_gdr_umum = ($total_pasien_meninggal_umum / $total_pasien_umum) * 1000;
			if($total_pasien_kusta > 0) $total_gdr_kusta = ($total_pasien_meninggal_kusta / $total_pasien_kusta) * 1000;
			if(($total_pasien_umum + $total_pasien_kusta) > 0) $total_gdr = (($total_pasien_meninggal_umum + $total_pasien_meninggal_kusta) / ($total_pasien_umum + $total_pasien_kusta)) * 1000;
			echo '<td align="right">' . number_format($total_gdr_umum,2)  . '</td>';	
			echo '<td align="right">' . number_format($total_gdr_kusta,2) . '</td>';	
			echo '<td align="right">' . number_format($total_gdr,2) . '</td>';	
		?>
	</tr>
	<tr>
		<td align="center">12</td>
		<td>NDR (%)</td>
		<?php 
			$total_pasien_meninggal_umum = 0;
			$total_pasien_umum = 0;
			$total_pasien_meninggal_kusta = 0;
			$total_pasien_kusta = 0;
			mysql_data_seek($get_keluar_meninggal_m48,0);
			$dat_keluar_meninggal = mysql_fetch_assoc($get_keluar_meninggal_m48);
			mysql_data_seek($get_keluar,0);
			while($dat_ndr = mysql_fetch_array($get_keluar)){
				mysql_data_seek($get_ruang_umum,0);
				while($dat_ruang_umum = mysql_fetch_array($get_ruang_umum)){
					$ndr = 0;
					if($dat_ndr['RUANG_' . $dat_ruang_umum['RUANG_ID']] > 0){
						$ndr = ($dat_keluar_meninggal['RUANG_' . $dat_ruang_umum['RUANG_ID']] / $dat_ndr['RUANG_' . $dat_ruang_umum['RUANG_ID']]) * 1000;   
					}	
					echo '<td align="right">' . number_format($ndr,2)  . '</td>'; 	
					$total_pasien_meninggal_umum += $dat_keluar_meninggal['RUANG_' . $dat_ruang_umum['RUANG_ID']];
					$total_pasien_umum += $dat_ndr['RUANG_' . $dat_ruang_umum['RUANG_ID']];
				}
				mysql_data_seek($get_ruang_kusta,0);
				while($dat_ruang_kusta = mysql_fetch_array($get_ruang_kusta)){
					$ndr = 0;
					if($dat_ndr['RUANG_' . $dat_ruang_kusta['RUANG_ID']] > 0){
						$ndr = ($dat_keluar_meninggal['RUANG_' . $dat_ruang_kusta['RUANG_ID']] / $dat_ndr['RUANG_' . $dat_ruang_kusta['RUANG_ID']]) * 1000;   
					}	
					echo '<td align="right">' . number_format($ndr,2)  . '</td>'; 	
					$total_pasien_meninggal_kusta += $dat_keluar_meninggal['RUANG_' . $dat_ruang_kusta['RUANG_ID']];
					$total_pasien_kusta += $dat_ndr['RUANG_' . $dat_ruang_kusta['RUANG_ID']];
				}	
			}
			
			$total_ndr_umum = 0;
			$total_ndr_kusta = 0;
			$total_ndr = 0;
			
			if($total_pasien_umum > 0) $total_ndr_umum = ($total_pasien_meninggal_umum / $total_pasien_umum) * 1000;
			if($total_pasien_kusta > 0) $total_ndr_kusta = ($total_pasien_meninggal_kusta / $total_pasien_kusta) * 1000;
			if(($total_pasien_umum + $total_pasien_kusta) > 0)$total_ndr = (($total_pasien_meninggal_umum + $total_pasien_meninggal_kusta) / ($total_pasien_umum + $total_pasien_kusta)) * 1000;
			echo '<td align="right">' . number_format($total_ndr_umum,2)  . '</td>';	
			echo '<td align="right">' . number_format($total_ndr_kusta,2) . '</td>';	
			echo '<td align="right">' . number_format($total_ndr,2) . '</td>';	
		?>
	</tr>
	<tr>
		<td align="center">13</td>
		<td>BTO (kali)</td>
		<?php 
			$total_pasien_umum = 0;
			$total_bed_umum = 0;
			$total_pasien_kusta = 0;
			$total_bed_kusta = 0;
			mysql_data_seek($get_keluar,0);
			while($dat_bto = mysql_fetch_array($get_keluar)){
				mysql_data_seek($get_ruang_umum,0);
				while($dat_ruang_umum = mysql_fetch_array($get_ruang_umum)){
					$bto = 0;
					if($arr_bed[$dat_ruang_umum['RUANG_ID']] > 0){
						$bto = $dat_bto['RUANG_' . $dat_ruang_umum['RUANG_ID']] / $arr_bed[$dat_ruang_umum['RUANG_ID']];
					}	
					echo '<td align="right">' . number_format($bto,2)  . '</td>'; 	
					$total_pasien_umum += $dat_bto['RUANG_' . $dat_ruang_umum['RUANG_ID']];
					$total_bed_umum += $arr_bed[$dat_ruang_umum['RUANG_ID']];
					 
				}
				mysql_data_seek($get_ruang_kusta,0);
				while($dat_ruang_kusta = mysql_fetch_array($get_ruang_kusta)){
					$bto = 0;
					if($arr_bed[$dat_ruang_kusta['RUANG_ID']] > 0){
						$bto = $dat_bto['RUANG_' . $dat_ruang_kusta['RUANG_ID']] / $arr_bed[$dat_ruang_kusta['RUANG_ID']];
					}	
					echo '<td align="right">' . number_format($bto,2)  . '</td>';
					$total_pasien_kusta += $dat_bto['RUANG_' . $dat_ruang_kusta['RUANG_ID']];
					$total_bed_kusta += $arr_bed[$dat_ruang_kusta['RUANG_ID']]; 	
				}	
			}
			echo '<td align="right">' . number_format($total_pasien_umum / $total_bed_umum,2)  . '</td>';	
			echo '<td align="right">' . number_format($total_pasien_kusta / $total_bed_kusta,2) . '</td>';	
			echo '<td align="right">' . number_format(($total_pasien_umum + $total_pasien_kusta) / ($total_bed_umum + $total_bed_kusta),2) . '</td>';	
		?>
	</tr>
	<tr>
		<td align="center">14</td>
		<td>TOI (hari)</td>
		<?php 
			$total_pasien_umum = 0;
			$total_bed_umum = 0;
			$total_hari_perawatan_umum = 0;
			$total_pasien_kusta = 0;
			$total_bed_kusta = 0;
			$total_hari_perawatan_kusta = 0;
			mysql_data_seek($get_keluar,0);
			mysql_data_seek($get_hari_perawatan,0);
			$dat_hari_perawatan = mysql_fetch_assoc($get_hari_perawatan);
			while($dat_toi = mysql_fetch_array($get_keluar)){
				mysql_data_seek($get_ruang_umum,0);
				while($dat_ruang_umum = mysql_fetch_array($get_ruang_umum)){
					$toi = 0;
					if($dat_toi['RUANG_' . $dat_ruang_umum['RUANG_ID']] > 0){
						$toi = (($arr_bed[$dat_ruang_umum['RUANG_ID']] * $jml_hari) - $dat_hari_perawatan['RUANG_' . $dat_ruang_umum['RUANG_ID']]) / $dat_toi['RUANG_' . $dat_ruang_umum['RUANG_ID']];   
					}	
					echo '<td align="right">' . number_format($toi,2)  . '</td>'; 	
					$total_pasien_umum += $dat_toi['RUANG_' . $dat_ruang_umum['RUANG_ID']];
					$total_bed_umum += $arr_bed[$dat_ruang_umum['RUANG_ID']];
					$total_hari_perawatan_umum += $dat_hari_perawatan['RUANG_' . $dat_ruang_umum['RUANG_ID']]; 
				}
				mysql_data_seek($get_ruang_kusta,0);
				while($dat_ruang_kusta = mysql_fetch_array($get_ruang_kusta)){
					$toi = 0;
					if($dat_toi['RUANG_' . $dat_ruang_kusta['RUANG_ID']] > 0){
						$toi = (($arr_bed[$dat_ruang_kusta['RUANG_ID']] * $jml_hari) - $dat_hari_perawatan['RUANG_' . $dat_ruang_kusta['RUANG_ID']]) / $dat_toi['RUANG_' . $dat_ruang_kusta['RUANG_ID']];   
					}	
					echo '<td align="right">' . number_format($toi,2)  . '</td>'; 	
					$total_pasien_kusta += $dat_toi['RUANG_' . $dat_ruang_kusta['RUANG_ID']];
					$total_bed_kusta += $arr_bed[$dat_ruang_kusta['RUANG_ID']];
					$total_hari_perawatan_kusta += $dat_hari_perawatan['RUANG_' . $dat_ruang_kusta['RUANG_ID']]; 
				}	
			}
			
			$total_toi_umum = 0;
			$total_toi_kusta = 0;
			$total_toi = 0;
			
			if($total_pasien_umum > 0) $total_toi_umum = (($total_bed_umum * $jml_hari) - $total_hari_perawatan_umum) / $total_pasien_umum;
			if($total_pasien_kusta > 0) $total_toi_kusta = (($total_bed_kusta * $jml_hari) - $total_hari_perawatan_kusta) / $total_pasien_kusta;
			if(($total_pasien_umum + $total_pasien_kusta) > 0)$total_toi = ((($total_bed_umum + $total_bed_kusta) * $jml_hari) - ($total_hari_perawatan_umum + $total_hari_perawatan_kusta)) / ($total_pasien_umum + $total_pasien_kusta);
			echo '<td align="right">' . number_format($total_toi_umum,2)  . '</td>';	
			echo '<td align="right">' . number_format($total_toi_kusta,2) . '</td>';	
			echo '<td align="right">' . number_format($total_toi,2) . '</td>';	
		?>
	</tr>
	<tr>
		<td align="center">15</td>
		<td>Tempat Tidur (TT)</td>
		<?php 
			$total_bed_umum = 0;
			$total_bed_kusta = 0;
			mysql_data_seek($get_los,0);
			while($dat_bto = mysql_fetch_array($get_los)){
				mysql_data_seek($get_ruang_umum,0);
				while($dat_ruang_umum = mysql_fetch_array($get_ruang_umum)){	
					echo '<td align="right">' . $arr_bed[$dat_ruang_umum['RUANG_ID']]  . '</td>'; 	
					$total_bed_umum += $arr_bed[$dat_ruang_umum['RUANG_ID']];
				}
				mysql_data_seek($get_ruang_kusta,0);
				while($dat_ruang_kusta = mysql_fetch_array($get_ruang_kusta)){
					$total_bed_kusta += $arr_bed[$dat_ruang_kusta['RUANG_ID']]; 
					echo '<td align="right">' . $arr_bed[$dat_ruang_kusta['RUANG_ID']]  . '</td>'; 	
				}	
			}
			$total_bed = $total_bed_umum + $total_bed_kusta;
			echo '<td align="right">' . $total_bed_umum  . '</td>';	
			echo '<td align="right">' . $total_bed_kusta . '</td>';	
			echo '<td align="right">' . $total_bed . '</td>';	
		?>
	</tr>
</table>
<form id="xls_export" name="xls_export" method="post">
    <input type="hidden" name="page_to_excel" value="1" />
    <input type="hidden" name="tahun" value="<?php echo $tahun; ?>" />
    <input type="hidden" name="bulan" value="<?php echo $bulan; ?>" />
    <input type="hidden" name="xlsfile" value="rawatinap/xls_ranap_report_kegiatan.php" />
    <input type="hidden" name="xlsname" value="rpt_kegiatan_ranap.xls" />            
</form>	