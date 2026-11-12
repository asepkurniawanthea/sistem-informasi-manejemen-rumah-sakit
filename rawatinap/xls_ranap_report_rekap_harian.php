<?php
include('./config/config.php');
include('./shared/connect_db.php');
include('./shared/function.php');

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

$tahun = '';
if (isset($_POST['tahun']))
    $tahun = $_POST['tahun'];
$bulan = '';
if (isset($_POST['bulan']))
    $bulan = $_POST['bulan'];
$ruang_id = '';
if (isset($_POST['ruang_id']))
    $ruang_id = $_POST['ruang_id'];

?>
<table border="1" class="tableData" id="tfhover">
<tr>
	<th colspan="14">Rekap Harian Pasien Bulan <?php echo $arr_bulan[$bulan]; ?> Tahun <?php echo $tahun; ?></th>
</tr>	
  <tr>
    <th rowspan="2">Tanggal</th>
    <th rowspan="2">Pasien Awal </th>
    <th rowspan="2">Pasien Masuk </th>
    <th rowspan="2">Pasien Pindahan </th>
    <th rowspan="2">Jumlah (2+3+4) </th>
    <th rowspan="2">Pasien Dipindahkan </th>
    <th rowspan="2">Pasien Keluar Hidup </th>
    <th rowspan="2"><p>Pasien Mati (9+10)</p>    </th>
    <th colspan="2">Perincian Pasien Mati </th>
    <th rowspan="2">Jumlah (6+7+8) </th>
    <th rowspan="2">Jumlah Lama Dirawat </th>
    <th rowspan="2">Pasien Keluar/Masuk<br />Pada Hari Yang Sama </th>
    <th rowspan="2">Pasien Sisa<br />(Yang Masih Dirawat) </th>
  </tr>
  <tr>
    <th>&lt;48 Jam </th>
    <th>&#8805;48 Jam </th>
  </tr>
  <tr>
	<th>1</th>
	<th>2</th>
	<th>3</th>
	<th>4</th>
	<th>5</th>
	<th>6</th>
	<th>7</th>
	<th>8</th>
	<th>9</th>
	<th>10</th>
	<th>11</th>
	<th>12</th>
	<th>13</th>
	<th>14</th>
  </tr>
<?php 
function stNol($v){
	$ret = 0;
	if($v != '') $ret = $v;
	return $ret;
}
$qry_pasien_awal = 'SELECT "0" AS DY,
					COUNT(t_irna_opname.IRNA_ID) AS JML_PASIEN
					FROM t_irna_opname
					WHERE DATE_FORMAT(t_irna_opname.TANGGAL_OPNAME,"%d/%m/%Y") = DATE_FORMAT(DATE_ADD(STR_TO_DATE("01/' . $bulan . '/' . $tahun . '","%d/%m/%Y"),INTERVAL -1 DAY),"%d/%m/%Y")';
if(!empty($ruang_id)) $qry_pasien_awal .= ' AND t_irna_opname.RUANG_ID = "' . $ruang_id . '"';					
$qry_pasien_awal .= 'UNION
					SELECT DATE_FORMAT(t_irna_opname.TANGGAL_OPNAME,"%e") AS DY,
					COUNT(t_irna_opname.IRNA_ID) AS JML_PASIEN
					FROM t_irna_opname
					WHERE DATE_FORMAT(t_irna_opname.TANGGAL_OPNAME,"%m/%Y") = "' . $bulan . '/' . $tahun . '"';
if(!empty($ruang_id)) $qry_pasien_awal .= ' AND t_irna_opname.RUANG_ID = "' . $ruang_id . '"';
$qry_pasien_awal .= ' GROUP BY t_irna_opname.TANGGAL_OPNAME';										
$get_pasien_awal = mysql_query($qry_pasien_awal) or die(mysql_error());

$qry_pasien_masuk = 'SELECT DATE_FORMAT(t_irna_log.TANGGAL_MASUK,"%e") AS DY,
					COUNT(t_irna_log.IRNA_ID) AS JML_PASIEN
					FROM t_irna_log
					WHERE DATE_FORMAT(t_irna_log.TANGGAL_MASUK,"%m/%Y") = "' . $bulan . '/' . $tahun . '"
					AND t_irna_log.JNS_UPDATE = "R"
					AND t_irna_log.RUANG_ID_ASAL IS NULL';
if(!empty($ruang_id)) $qry_pasien_masuk .= ' AND t_irna_log.RUANG_ID_BARU = "' . $ruang_id . '"';
$qry_pasien_masuk .= ' GROUP BY DATE_FORMAT(t_irna_log.TANGGAL_MASUK,"%e")';										
$get_pasien_masuk = mysql_query($qry_pasien_masuk) or die(mysql_error());

$qry_pasien_pindahan = 'SELECT DATE_FORMAT(t_irna_log.TANGGAL_MASUK,"%e") AS DY,
					COUNT(t_irna_log.IRNA_ID) AS JML_PASIEN
					FROM t_irna_log
					WHERE DATE_FORMAT(t_irna_log.TANGGAL_MASUK,"%m/%Y") = "' . $bulan . '/' . $tahun . '"
					AND t_irna_log.JNS_UPDATE = "R"
					AND t_irna_log.RUANG_ID_ASAL IS NOT NULL';
if(!empty($ruang_id)) $qry_pasien_pindahan .= ' AND t_irna_log.RUANG_ID_BARU = "' . $ruang_id . '"';
$qry_pasien_pindahan .= ' GROUP BY DATE_FORMAT(t_irna_log.TANGGAL_MASUK,"%e")';										
$get_pasien_pindahan = mysql_query($qry_pasien_pindahan) or die(mysql_error());

$qry_pasien_dipindahkan = 'SELECT DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%e") AS DY,
					COUNT(t_irna_log.IRNA_ID) AS JML_PASIEN
					FROM t_irna_log
					WHERE DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m/%Y") = "' . $bulan . '/' . $tahun . '"
					AND t_irna_log.JNS_UPDATE = "R"
					AND t_irna_log.RUANG_ID_BARU IS NOT NULL';
if(!empty($ruang_id)) $qry_pasien_dipindahkan .= ' AND t_irna_log.RUANG_ID_ASAL = "' . $ruang_id . '"';
$qry_pasien_dipindahkan .= ' GROUP BY DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%e")';										
$get_pasien_dipindahkan = mysql_query($qry_pasien_dipindahkan) or die(mysql_error());

$qry_pasien_keluar_hidup = 'SELECT DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%e") AS DY,
					COUNT(t_irna_log.IRNA_ID) AS JML_PASIEN
					FROM t_irna_log
					WHERE DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m/%Y") = "' . $bulan . '/' . $tahun . '"
					AND t_irna_log.JNS_UPDATE = "R"
					AND t_irna_log.RUANG_ID_BARU IS NULL
					AND (t_irna_log.PASIEN_PULANG_ID = 1 OR t_irna_log.PASIEN_PULANG_ID = 6 OR t_irna_log.PASIEN_PULANG_ID = 7
							OR t_irna_log.PASIEN_PULANG_ID = 9 OR t_irna_log.PASIEN_PULANG_ID = 14)';
if(!empty($ruang_id)) $qry_pasien_keluar_hidup .= ' AND t_irna_log.RUANG_ID_ASAL = "' . $ruang_id . '"';
$qry_pasien_keluar_hidup .= ' GROUP BY DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%e")';										
$get_pasien_keluar_hidup = mysql_query($qry_pasien_keluar_hidup) or die(mysql_error());

$qry_pasien_keluar_mati = 'SELECT DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%e") AS DY,
					COUNT(t_irna_log.IRNA_ID) AS JML_PASIEN
					FROM t_irna_log
					WHERE DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m/%Y") = "' . $bulan . '/' . $tahun . '"
					AND t_irna_log.JNS_UPDATE = "R"
					AND t_irna_log.RUANG_ID_BARU IS NULL
					AND (t_irna_log.PASIEN_PULANG_ID = 3 OR t_irna_log.PASIEN_PULANG_ID = 8)';
if(!empty($ruang_id)) $qry_pasien_keluar_mati .= ' AND t_irna_log.RUANG_ID_ASAL = "' . $ruang_id . '"';
$qry_pasien_keluar_mati .= ' GROUP BY DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%e")';										
$get_pasien_keluar_mati = mysql_query($qry_pasien_keluar_mati) or die(mysql_error());

$qry_pasien_keluar_mati_l48 = 'SELECT DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%e") AS DY,
					COUNT(t_irna_log.IRNA_ID) AS JML_PASIEN
					FROM t_irna_log
					WHERE DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m/%Y") = "' . $bulan . '/' . $tahun . '"
					AND t_irna_log.JNS_UPDATE = "R"
					AND t_irna_log.RUANG_ID_BARU IS NULL
					AND (t_irna_log.PASIEN_KEADAAN_ID = 5 OR t_irna_log.PASIEN_KEADAAN_ID = 6
						OR t_irna_log.PASIEN_KEADAAN_ID = 7 OR t_irna_log.PASIEN_KEADAAN_ID = 9)';
if(!empty($ruang_id)) $qry_pasien_keluar_mati_l48 .= ' AND t_irna_log.RUANG_ID_ASAL = "' . $ruang_id . '"';
$qry_pasien_keluar_mati_l48 .= ' GROUP BY DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%e")';										
$get_pasien_keluar_mati_l48 = mysql_query($qry_pasien_keluar_mati_l48) or die(mysql_error());

$qry_pasien_keluar_mati_m48 = 'SELECT DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%e") AS DY,
					COUNT(t_irna_log.IRNA_ID) AS JML_PASIEN
					FROM t_irna_log
					WHERE DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m/%Y") = "' . $bulan . '/' . $tahun . '"
					AND t_irna_log.JNS_UPDATE = "R"
					AND t_irna_log.RUANG_ID_BARU IS NULL
					AND t_irna_log.PASIEN_KEADAAN_ID = 8';
if(!empty($ruang_id)) $qry_pasien_keluar_mati_m48 .= ' AND t_irna_log.RUANG_ID_ASAL = "' . $ruang_id . '"';
$qry_pasien_keluar_mati_m48 .= ' GROUP BY DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%e")';										
$get_pasien_keluar_mati_m48 = mysql_query($qry_pasien_keluar_mati_m48) or die(mysql_error());

$qry_pasien_lama_dirawat = 'SELECT DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%e") AS DY,
					DATEDIFF(t_irna_log.TANGGAL_KELUAR,
						(SELECT t.TANGGAL_MASUK FROM t_irna_log t 
							WHERE t.IRNA_ID = t_irna_log.IRNA_ID
							AND t.RUANG_ID_BARU = t_irna_log.RUANG_ID_ASAL
							AND t.JNS_UPDATE = "R"
							AND t.IRNA_LOG_ID < t_irna_log.IRNA_LOG_ID
							ORDER BY t.TANGGAL_MASUK DESC LIMIT 1)) AS LAMA_DIRAWAT
					FROM t_irna_log
					WHERE DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%m/%Y") = "' . $bulan . '/' . $tahun . '"
					AND t_irna_log.JNS_UPDATE = "R"
					AND t_irna_log.RUANG_ID_BARU IS NULL';
if(!empty($ruang_id)) $qry_pasien_lama_dirawat .= ' AND t_irna_log.RUANG_ID_ASAL = "' . $ruang_id . '"';
$qry_pasien_lama_dirawat .= ' GROUP BY DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%e")';										
$get_pasien_lama_dirawat = mysql_query($qry_pasien_lama_dirawat) or die(mysql_error());

$qry_pasien_keluarmasuk_harisama = 'SELECT DATE_FORMAT(TANGGAL_KELUAR,"%e") AS DY,
								COUNT(DISTINCT IRNA_ID) AS PULANG_HARI_SAMA
								FROM (
									SELECT t_irna_log.IRNA_ID,
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
									AND t_irna_log.RUANG_ID_BARU IS NULL';
if(!empty($ruang_id)) $qry_pasien_keluarmasuk_harisama .= ' AND t_irna_log.RUANG_ID_ASAL = "' . $ruang_id . '"';
$qry_pasien_keluarmasuk_harisama .= ') t_rawat
								WHERE DATE_FORMAT(TANGGAL_MASUK,"%d%m%Y") = DATE_FORMAT(TANGGAL_KELUAR,"%d%m%Y")';
$qry_pasien_keluarmasuk_harisama .= ' GROUP BY DATE_FORMAT(TANGGAL_KELUAR,"%e")';										
$get_pasien_keluarmasuk_harisama = mysql_query($qry_pasien_keluarmasuk_harisama) or die(mysql_error());

$qry_pasien_sisa = 'SELECT DATE_FORMAT(t_irna_opname.TANGGAL_OPNAME,"%e") AS DY,
					COUNT(t_irna_opname.IRNA_ID) AS JML_PASIEN
					FROM t_irna_opname
					WHERE DATE_FORMAT(t_irna_opname.TANGGAL_OPNAME,"%m/%Y") = "' . $bulan . '/' . $tahun . '"';
if(!empty($ruang_id)) $qry_pasien_sisa .= ' AND t_irna_opname.RUANG_ID = "' . $ruang_id . '"';
$qry_pasien_sisa .= ' GROUP BY t_irna_opname.TANGGAL_OPNAME';										
$get_pasien_sisa = mysql_query($qry_pasien_sisa) or die(mysql_error());

$qry_pasien_sisa_perkelas = 'SELECT DATE_FORMAT(t_irna_opname.TANGGAL_OPNAME,"%e") AS DY,
					COUNT(t_irna_opname.IRNA_ID) AS JML_PASIEN
					FROM t_irna_opname
					WHERE DATE_FORMAT(t_irna_opname.TANGGAL_OPNAME,"%m/%Y") = "' . $bulan . '/' . $tahun . '"';
if(!empty($ruang_id)) $qry_pasien_sisa_perkelas .= ' AND t_irna_opname.RUANG_ID = "' . $ruang_id . '"';
$qry_pasien_sisa_perkelas .= ' GROUP BY t_irna_opname.TANGGAL_OPNAME';										
$get_pasien_sisa_perkelas = mysql_query($qry_pasien_sisa_perkelas) or die(mysql_error());

$qry_tanggal = 'SELECT DATE_FORMAT(vdate.TANGGAL,"%e") AS TANGGAL
			FROM (SELECT ADDDATE("1970-01-01",T4.I*10000 + T3.I*1000 + T2.I*100 + T1.I*10 + T0.I) TANGGAL FROM
				(SELECT 0 I UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) T0,
				(SELECT 0 I UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) T1,
				(SELECT 0 I UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) T2,
				(SELECT 0 I UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) T3,
				(SELECT 0 I UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) T4
			) vdate
			WHERE vdate.TANGGAL
			BETWEEN STR_TO_DATE("01/' . $bulan . '/' . $tahun . '","%d/%m/%Y") 
			AND LAST_DAY(STR_TO_DATE("01/' . $bulan . '/' . $tahun . '","%d/%m/%Y"))';
$jml_pasien_awal = 0;		
$jml_pasien_masuk = 0;	
$jml_pasien_pindahan = 0;
$jml_pasien_dipindahkan = 0;
$jml_pasien_keluarhidup = 0;
$jml_pasien_keluarmati = 0;
$jml_pasien_mati_l48 = 0;
$jml_pasien_mati_m48 = 0;
$jml_lama_dirawat = 0;
$jml_keluar_harisama = 0;
$jml_dilayani = 0;
$jml_hari = 0;
$get_tanggal = mysql_query($qry_tanggal) or die(mysql_error());
while($dat_tanggal = mysql_fetch_array($get_tanggal)){
	$vtgl = substr('00',0,2 - strlen($dat_tanggal['TANGGAL'])) . $dat_tanggal['TANGGAL'];
	echo '<tr>';
	echo '<td align="center">' . $vtgl . '</td>';
	$jumlah_pasien_masuk = 0;
	$jumlah_pasien_keluar = 0;
		
	if(mysql_num_rows($get_pasien_awal) > 0) mysql_data_seek($get_pasien_awal,0);
	$st_awal = false;
	while($dat_pasien_awal = mysql_fetch_array($get_pasien_awal)){
		$tgl = $dat_tanggal['TANGGAL'] - 1;
		if($dat_pasien_awal['DY'] == $tgl){
			echo '<td align="right">' . $dat_pasien_awal['JML_PASIEN'] . '</td>';
			$jumlah_pasien_masuk += $dat_pasien_awal['JML_PASIEN'];
			$jml_pasien_awal += $dat_pasien_awal['JML_PASIEN'];
			$st_awal = true;
			break;
		}
	}
	if($st_awal == false) echo '<td align="right">0</td>';
	
	if(mysql_num_rows($get_pasien_masuk) > 0) mysql_data_seek($get_pasien_masuk,0);
	$st_masuk = false;
	while($dat_pasien_masuk = mysql_fetch_array($get_pasien_masuk)){
		if($dat_pasien_masuk['DY'] == $dat_tanggal['TANGGAL']){
			echo '<td align="right">' . $dat_pasien_masuk['JML_PASIEN'] . '</td>';
			$jumlah_pasien_masuk += $dat_pasien_masuk['JML_PASIEN'];
			$jml_pasien_masuk += $dat_pasien_masuk['JML_PASIEN'];
			$st_masuk = true;
			break;
		}
	}
	if($st_masuk == false) echo '<td align="right">0</td>';
	
	if(mysql_num_rows($get_pasien_pindahan) > 0) mysql_data_seek($get_pasien_pindahan,0);
	$st_pindahan = false;
	while($dat_pasien_pindahan = mysql_fetch_array($get_pasien_pindahan)){
		if($dat_pasien_pindahan['DY'] == $dat_tanggal['TANGGAL']){
			echo '<td align="right">' . $dat_pasien_pindahan['JML_PASIEN'] . '</td>';
			$jumlah_pasien_masuk += $dat_pasien_pindahan['JML_PASIEN'];
			$jml_pasien_pindahan += $dat_pasien_pindahan['JML_PASIEN'];
			$st_pindahan = true;
			break;
		}
	}
	if($st_pindahan == false) echo '<td align="right">0</td>';
	echo '<td align="right">' . $jumlah_pasien_masuk . '</td>';
	
	if(mysql_num_rows($get_pasien_dipindahkan) > 0) mysql_data_seek($get_pasien_dipindahkan,0);
	$st_dipindahkan = false;
	while($dat_pasien_dipindahkan = mysql_fetch_array($get_pasien_dipindahkan)){
		if($dat_pasien_dipindahkan['DY'] == $dat_tanggal['TANGGAL']){
			echo '<td align="right">' . $dat_pasien_dipindahkan['JML_PASIEN'] . '</td>';
			$jumlah_pasien_keluar += $dat_pasien_dipindahkan['JML_PASIEN'];
			$jml_pasien_dipindahkan += $dat_pasien_dipindahkan['JML_PASIEN'];
			$st_dipindahkan = true;
			break;
		}
	}
	if($st_dipindahkan == false) echo '<td align="right">0</td>';
	
	if(mysql_num_rows($get_pasien_keluar_hidup) > 0) mysql_data_seek($get_pasien_keluar_hidup,0);
	$st_keluar_hidup = false;
	while($dat_pasien_keluar_hidup = mysql_fetch_array($get_pasien_keluar_hidup)){
		if($dat_pasien_keluar_hidup['DY'] == $dat_tanggal['TANGGAL']){
			echo '<td align="right">' . $dat_pasien_keluar_hidup['JML_PASIEN'] . '</td>';
			$jumlah_pasien_keluar += $dat_pasien_keluar_hidup['JML_PASIEN'];
			$jml_pasien_keluarhidup += $dat_pasien_keluar_hidup['JML_PASIEN'];
			$st_keluar_hidup = true;
			break;
		}
	}
	if($st_keluar_hidup == false) echo '<td align="right">0</td>';
	
	if(mysql_num_rows($get_pasien_keluar_mati) > 0) mysql_data_seek($get_pasien_keluar_mati,0);
	$st_keluar_mati = false;
	while($dat_pasien_keluar_mati = mysql_fetch_array($get_pasien_keluar_mati)){
		if($dat_pasien_keluar_mati['DY'] == $dat_tanggal['TANGGAL']){
			echo '<td align="right">' . $dat_pasien_keluar_mati['JML_PASIEN'] . '</td>';
			$jumlah_pasien_keluar += $dat_pasien_keluar_mati['JML_PASIEN'];
			$jml_pasien_keluarmati += $dat_pasien_keluar_mati['JML_PASIEN'];
			$st_keluar_mati = true;
			break;
		}
	}
	if($st_keluar_mati == false) echo '<td align="right">0</td>';
	
	if(mysql_num_rows($get_pasien_keluar_mati_l48) > 0) mysql_data_seek($get_pasien_keluar_mati_l48,0);
	$st_keluar_mati_l48 = false;
	while($dat_pasien_keluar_mati_l48 = mysql_fetch_array($get_pasien_keluar_mati_l48)){
		if($dat_pasien_keluar_mati_l48['DY'] == $dat_tanggal['TANGGAL']){
			echo '<td align="right">' . $dat_pasien_keluar_mati_l48['JML_PASIEN'] . '</td>';
			$jml_pasien_mati_l48 += $dat_pasien_keluar_mati_l48['JML_PASIEN'];
			$st_keluar_mati_l48 = true;
			break;
		}
	}
	if($st_keluar_mati_l48 == false) echo '<td align="right">0</td>';
	
	if(mysql_num_rows($get_pasien_keluar_mati_m48) > 0) mysql_data_seek($get_pasien_keluar_mati_m48,0);
	$st_keluar_mati_m48 = false;
	while($dat_pasien_keluar_mati_m48 = mysql_fetch_array($get_pasien_keluar_mati_m48)){
		if($dat_pasien_keluar_mati_m48['DY'] == $dat_tanggal['TANGGAL']){
			echo '<td align="right">' . $dat_pasien_keluar_mati_m48['JML_PASIEN'] . '</td>';
			$jml_pasien_mati_m48 += $dat_pasien_keluar_mati_m48['JML_PASIEN'];
			$st_keluar_mati_m48 = true;
			break;
		}
	}
	if($st_keluar_mati_m48 == false) echo '<td align="right">0</td>';
	echo '<td align="right">' . $jumlah_pasien_keluar . '</td>';
	
	if(mysql_num_rows($get_pasien_lama_dirawat) > 0) mysql_data_seek($get_pasien_lama_dirawat,0);
	$st_lama_dirawat = false;
	while($dat_pasien_lama_dirawat = mysql_fetch_array($get_pasien_lama_dirawat)){
		if($dat_pasien_lama_dirawat['DY'] == $dat_tanggal['TANGGAL']){
			echo '<td align="right">' . $dat_pasien_lama_dirawat['LAMA_DIRAWAT'] . '</td>';
			$jml_lama_dirawat += $dat_pasien_lama_dirawat['LAMA_DIRAWAT'];
			$st_lama_dirawat = true;
			break;
		}
	}
	if($st_lama_dirawat == false) echo '<td align="right">0</td>';
	
	if(mysql_num_rows($get_pasien_keluarmasuk_harisama) > 0) mysql_data_seek($get_pasien_keluarmasuk_harisama,0);
	$st_keluarmasuk_harisama = false;
	while($dat_pasien_keluarmasuk_harisama = mysql_fetch_array($get_pasien_keluarmasuk_harisama)){
		if($dat_pasien_keluarmasuk_harisama['DY'] == $dat_tanggal['TANGGAL']){
			echo '<td align="right">' . $dat_pasien_keluarmasuk_harisama['PULANG_HARI_SAMA'] . '</td>';
			$jml_keluar_harisama += $dat_pasien_keluarmasuk_harisama['PULANG_HARI_SAMA'];
			$st_keluarmasuk_harisama = true;
			break;
		}
	}
	if($st_keluarmasuk_harisama == false) echo '<td align="right">0</td>';
	
	if(mysql_num_rows($get_pasien_sisa) > 0) mysql_data_seek($get_pasien_sisa,0);
	$st_sisa = false;
	while($dat_pasien_sisa = mysql_fetch_array($get_pasien_sisa)){
		if($dat_pasien_sisa['DY'] == $dat_tanggal['TANGGAL']){
			echo '<td align="right">' . $dat_pasien_sisa['JML_PASIEN'] . '</td>';
			$jml_dilayani += $dat_pasien_sisa['JML_PASIEN'];
			$st_sisa = true;
			break;
		}
	}
	if($st_sisa == false) echo '<td align="right">0</td>';
	echo '</tr>';
	
	$jml_hari++;
	}			
?>  
<tr>
	<td align="center">Jumlah</td>
	<td align="right"><?php echo $jml_pasien_awal; ?></td>
	<td align="right"><?php echo $jml_pasien_masuk; ?></td>
	<td align="right"><?php echo $jml_pasien_pindahan; ?></td>
	<td align="right"><?php echo $jml_pasien_awal + $jml_pasien_masuk + $jml_pasien_pindahan; ?></td>
	<td align="right"><?php echo $jml_pasien_dipindahkan; ?></td>
	<td align="right"><?php echo $jml_pasien_keluarhidup; ?></td>
	<td align="right"><?php echo $jml_pasien_keluarmati; ?></td>
	<td align="right"><?php echo $jml_pasien_mati_l48; ?></td>
	<td align="right"><?php echo $jml_pasien_mati_m48; ?></td>
	<td align="right"><?php echo $jml_pasien_dipindahkan + $jml_pasien_keluarhidup + $jml_pasien_keluarmati; ?></td>
	<td align="right"><?php echo $jml_lama_dirawat; ?></td>
	<td align="right"><?php echo $jml_keluar_harisama; ?></td>
	<td align="right"><?php echo $jml_dilayani; ?></td>
</tr>
<?php $qry_hari_perawatan = 'SELECT COUNT(IRNA_ID) AS JML_PERAWATAN
								FROM t_irna_opname
								WHERE DATE_FORMAT(TANGGAL_OPNAME,"%m%Y") = "' . $bulan . $tahun . '"';
		if(!empty($ruang_id)) $qry_hari_perawatan .= ' AND RUANG_ID = "' . $ruang_id . '"';
		$get_hari_perawatan = mysql_query($qry_hari_perawatan) or die(mysql_error());
		$dat_hari_perawatan = mysql_fetch_assoc($get_hari_perawatan);
		$jml_hari_perawatan = $dat_hari_perawatan['JML_PERAWATAN'];
		
		$qry_pasien_keluarmasuk_harisama = 'SELECT COUNT(DISTINCT IRNA_ID) AS PULANG_HARI_SAMA
									FROM (
										SELECT t_irna_log.IRNA_ID,
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
										AND t_irna_log.RUANG_ID_BARU IS NULL';
		if(!empty($ruang_id)) $qry_pasien_keluarmasuk_harisama .= ' AND t_irna_log.RUANG_ID_ASAL = "' . $ruang_id . '"';
		$qry_pasien_keluarmasuk_harisama .= ') t_rawat
									WHERE DATE_FORMAT(TANGGAL_MASUK,"%d%m%Y") = DATE_FORMAT(TANGGAL_KELUAR,"%d%m%Y")';
		$get_pasien_keluarmasuk_harisama = mysql_query($qry_pasien_keluarmasuk_harisama) or die(mysql_error());
		$dat_pasien_keluarmasuk_harisama = mysql_fetch_assoc($get_pasien_keluarmasuk_harisama);
		$jml_hari_perawatan += $dat_pasien_keluarmasuk_harisama['PULANG_HARI_SAMA'];
		
		$qry_bed = 'SELECT COUNT(RUANG_DETAIL_ID) AS JMl_BED
				FROM m_ruang_detail
				INNER JOIN m_ruang ON (m_ruang_detail.RUANG_ID = m_ruang.RUANG_ID)
				WHERE ST_AKTIF = "1"';
		if(!empty($ruang_id)) $qry_bed .= ' AND m_ruang.RUANG_ID = "' . $ruang_id . '"';
		$get_bed = mysql_query($qry_bed) or die(mysql_error());
		$dat_bed = mysql_fetch_assoc($get_bed);
		$jml_bed = $dat_bed['JMl_BED'];	?>
<tr>
	<td align="center" colspan="2"><strong>Jumlah Tempat Tidur</strong></td>
	<td align="right"><?php echo $jml_bed; ?></td>	
	<td align="center" colspan="2"><strong>BOR - Bed Occupancy Ratio (%)</strong></td>
	<td align="right"><?php $bor = 0; 
						if($jml_bed > 0) $bor = ($jml_hari_perawatan / ($jml_bed * $jml_hari)) * 100; 
						echo number_format($bor,2); ?></td>
	<td colspan="8">&nbsp;</td>					
</tr>
</table>