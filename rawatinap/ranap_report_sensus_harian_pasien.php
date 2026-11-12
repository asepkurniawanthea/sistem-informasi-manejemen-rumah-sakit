<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tgl_1 = '';
if (isset($_SESSION['ranapsearchsensuspasienharian_tgl_1']))
    $tgl_1 = $_SESSION['ranapsearchsensuspasienharian_tgl_1'];

if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
	$_SESSION['ranapsearchsensuspasienharian_tgl_1'] = $tgl_1;
}

$ruang_id = '';
if (isset($_SESSION['ranapsearchsensuspasienharian_ruang_id']))
		$ruang_id = $_SESSION['ranapsearchsensuspasienharian_ruang_id'];

if (isset($_GET['ruang_id'])) {
    $ruang_id = $_GET['ruang_id'];
	$_SESSION['ranapsearchsensuspasienharian_ruang_id'] = $ruang_id;
}

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}

$sql_pasien_kemarian = 'SELECT SUM(CASE WHEN t_irna.DEWASA_ANAK_BAYI = "DW" AND m_pasien.JNS_KELAMIN = "L" THEN 1 ELSE 0 END) AS DEWASA_LK,
								SUM(CASE WHEN t_irna.DEWASA_ANAK_BAYI = "DW" AND m_pasien.JNS_KELAMIN = "P" THEN 1 ELSE 0 END) AS DEWASA_PR,
								SUM(CASE WHEN t_irna.DEWASA_ANAK_BAYI = "AN" AND m_pasien.JNS_KELAMIN = "L" THEN 1 ELSE 0 END) AS ANAK_LK,
								SUM(CASE WHEN t_irna.DEWASA_ANAK_BAYI = "AN" AND m_pasien.JNS_KELAMIN = "P" THEN 1 ELSE 0 END) AS ANAK_PR,
								SUM(CASE WHEN t_irna.DEWASA_ANAK_BAYI = "BY" AND m_pasien.JNS_KELAMIN = "L" THEN 1 ELSE 0 END) AS BAYI_LK,
								SUM(CASE WHEN t_irna.DEWASA_ANAK_BAYI = "BY" AND m_pasien.JNS_KELAMIN = "P" THEN 1 ELSE 0 END) AS BAYI_PR,
								COUNT(t_irna.IRNA_ID) AS TOTAL
							FROM t_irna
							INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
							INNER JOIN t_irna_opname ON (t_irna.IRNA_ID = t_irna_opname.IRNA_ID)
							WHERE t_irna_opname.TANGGAL_OPNAME = DATE_ADD(' . $tgl_filter_1 . ',INTERVAL -1 DAY)';
if(!empty($ruang_id)) $sql_pasien_kemarian .= ' AND t_irna_opname.RUANG_ID = "' . $ruang_id . '"';
$get_pasien_kemarian = mysql_query($sql_pasien_kemarian) or die(mysql_error());
$dat_pasien_kemarin = mysql_fetch_assoc($get_pasien_kemarian);
$pasien_kemarin_dewasa_lk = $dat_pasien_kemarin['DEWASA_LK'];
$pasien_kemarin_dewasa_pr = $dat_pasien_kemarin['DEWASA_PR'];
$pasien_kemarin_anak_lk = $dat_pasien_kemarin['ANAK_LK'];
$pasien_kemarin_anak_pr = $dat_pasien_kemarin['ANAK_PR'];
$pasien_kemarin_bayi_lk = $dat_pasien_kemarin['BAYI_LK'];
$pasien_kemarin_bayi_pr = $dat_pasien_kemarin['BAYI_PR']; 							
$jumlah_pasien_kemarin = $dat_pasien_kemarin['TOTAL']; 							

$sql_pasien_masuk = 'SELECT SUM(CASE WHEN t_irna.DEWASA_ANAK_BAYI = "DW" AND m_pasien.JNS_KELAMIN = "L" THEN 1 ELSE 0 END) AS DEWASA_LK,
								SUM(CASE WHEN t_irna.DEWASA_ANAK_BAYI = "DW" AND m_pasien.JNS_KELAMIN = "P" THEN 1 ELSE 0 END) AS DEWASA_PR,
								SUM(CASE WHEN t_irna.DEWASA_ANAK_BAYI = "AN" AND m_pasien.JNS_KELAMIN = "L" THEN 1 ELSE 0 END) AS ANAK_LK,
								SUM(CASE WHEN t_irna.DEWASA_ANAK_BAYI = "AN" AND m_pasien.JNS_KELAMIN = "P" THEN 1 ELSE 0 END) AS ANAK_PR,
								SUM(CASE WHEN t_irna.DEWASA_ANAK_BAYI = "BY" AND m_pasien.JNS_KELAMIN = "L" THEN 1 ELSE 0 END) AS BAYI_LK,
								SUM(CASE WHEN t_irna.DEWASA_ANAK_BAYI = "BY" AND m_pasien.JNS_KELAMIN = "P" THEN 1 ELSE 0 END) AS BAYI_PR,
								COUNT(t_irna.IRNA_ID) AS TOTAL
							FROM t_irna_log
							INNER JOIN t_irna ON (t_irna_log.IRNA_ID = t_irna.IRNA_ID)
							INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
							WHERE t_irna_log.JNS_UPDATE = "R"
							AND STR_TO_DATE(DATE_FORMAT(t_irna_log.TANGGAL_MASUK,"%d%m%Y"),"%d%m%Y") = ' . $tgl_filter_1 . '						
							AND t_irna_log.RUANG_ID_ASAL IS NULL';
if(!empty($ruang_id)) $sql_pasien_masuk	.= ' AND t_irna_log.RUANG_ID_BARU = "' . $ruang_id . '"';
$get_pasien_masuk = mysql_query($sql_pasien_masuk) or die(mysql_error());
$dat_pasien_masuk = mysql_fetch_assoc($get_pasien_masuk);
$pasien_masuk_dewasa_lk = $dat_pasien_masuk['DEWASA_LK'];	
$pasien_masuk_dewasa_pr = $dat_pasien_masuk['DEWASA_PR'];	
$pasien_masuk_anak_lk = $dat_pasien_masuk['ANAK_LK'];	
$pasien_masuk_anak_pr = $dat_pasien_masuk['ANAK_PR'];	
$pasien_masuk_bayi_lk = $dat_pasien_masuk['BAYI_LK'];	
$pasien_masuk_bayi_pr = $dat_pasien_masuk['BAYI_PR'];	
$jumlah_pasien_masuk = $dat_pasien_masuk['TOTAL'];

$sql_pasien_pindahan = 'SELECT SUM(CASE WHEN t_irna.DEWASA_ANAK_BAYI = "DW" AND m_pasien.JNS_KELAMIN = "L" THEN 1 ELSE 0 END) AS DEWASA_LK,
								SUM(CASE WHEN t_irna.DEWASA_ANAK_BAYI = "DW" AND m_pasien.JNS_KELAMIN = "P" THEN 1 ELSE 0 END) AS DEWASA_PR,
								SUM(CASE WHEN t_irna.DEWASA_ANAK_BAYI = "AN" AND m_pasien.JNS_KELAMIN = "L" THEN 1 ELSE 0 END) AS ANAK_LK,
								SUM(CASE WHEN t_irna.DEWASA_ANAK_BAYI = "AN" AND m_pasien.JNS_KELAMIN = "P" THEN 1 ELSE 0 END) AS ANAK_PR,
								SUM(CASE WHEN t_irna.DEWASA_ANAK_BAYI = "BY" AND m_pasien.JNS_KELAMIN = "L" THEN 1 ELSE 0 END) AS BAYI_LK,
								SUM(CASE WHEN t_irna.DEWASA_ANAK_BAYI = "BY" AND m_pasien.JNS_KELAMIN = "P" THEN 1 ELSE 0 END) AS BAYI_PR,
								COUNT(t_irna.IRNA_ID) AS TOTAL
							FROM t_irna_log
							INNER JOIN t_irna ON (t_irna_log.IRNA_ID = t_irna.IRNA_ID)
							INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
							WHERE t_irna_log.JNS_UPDATE = "R"
							AND STR_TO_DATE(DATE_FORMAT(t_irna_log.TANGGAL_MASUK,"%d%m%Y"),"%d%m%Y") = ' . $tgl_filter_1 . '						
							AND t_irna_log.RUANG_ID_ASAL IS NOT NULL';	
if(!empty($ruang_id)) $sql_pasien_pindahan	.= ' AND t_irna_log.RUANG_ID_BARU = "' . $ruang_id . '"';							
$get_pasien_pindahan = mysql_query($sql_pasien_pindahan) or die(mysql_error());
$dat_pasien_pindahan = mysql_fetch_assoc($get_pasien_pindahan);
$pasien_pindahan_dewasa_lk = $dat_pasien_pindahan['DEWASA_LK'];	
$pasien_pindahan_dewasa_pr = $dat_pasien_pindahan['DEWASA_PR'];	
$pasien_pindahan_anak_lk = $dat_pasien_pindahan['ANAK_LK'];	
$pasien_pindahan_anak_pr = $dat_pasien_pindahan['ANAK_PR'];	
$pasien_pindahan_bayi_lk = $dat_pasien_pindahan['BAYI_LK'];	
$pasien_pindahan_bayi_pr = $dat_pasien_pindahan['BAYI_PR'];	
$jumlah_pasien_pindahan = $dat_pasien_pindahan['TOTAL'];

$jml_dewasa_lk = $pasien_kemarin_dewasa_lk + $pasien_masuk_dewasa_lk + $pasien_pindahan_dewasa_lk;
$jml_dewasa_pr = $pasien_kemarin_dewasa_pr + $pasien_masuk_dewasa_pr + $pasien_pindahan_dewasa_pr;

$jml_anak_lk = $pasien_kemarin_anak_lk + $pasien_masuk_anak_lk + $pasien_pindahan_anak_lk;
$jml_anak_pr = $pasien_kemarin_anak_pr + $pasien_masuk_anak_pr + $pasien_pindahan_anak_pr;

$jml_bayi_lk = $pasien_kemarin_bayi_lk + $pasien_masuk_bayi_lk + $pasien_pindahan_bayi_lk;
$jml_bayi_pr = $pasien_kemarin_bayi_pr + $pasien_masuk_bayi_pr + $pasien_pindahan_bayi_pr;

$sql_pasien_pulang_hidup = 'SELECT SUM(CASE WHEN t_irna.DEWASA_ANAK_BAYI = "DW" AND m_pasien.JNS_KELAMIN = "L" THEN 1 ELSE 0 END) AS DEWASA_LK,
								SUM(CASE WHEN t_irna.DEWASA_ANAK_BAYI = "DW" AND m_pasien.JNS_KELAMIN = "P" THEN 1 ELSE 0 END) AS DEWASA_PR,
								SUM(CASE WHEN t_irna.DEWASA_ANAK_BAYI = "AN" AND m_pasien.JNS_KELAMIN = "L" THEN 1 ELSE 0 END) AS ANAK_LK,
								SUM(CASE WHEN t_irna.DEWASA_ANAK_BAYI = "AN" AND m_pasien.JNS_KELAMIN = "P" THEN 1 ELSE 0 END) AS ANAK_PR,
								SUM(CASE WHEN t_irna.DEWASA_ANAK_BAYI = "BY" AND m_pasien.JNS_KELAMIN = "L" THEN 1 ELSE 0 END) AS BAYI_LK,
								SUM(CASE WHEN t_irna.DEWASA_ANAK_BAYI = "BY" AND m_pasien.JNS_KELAMIN = "P" THEN 1 ELSE 0 END) AS BAYI_PR,
								COUNT(t_irna.IRNA_ID) AS TOTAL
							FROM t_irna_log
							INNER JOIN t_irna ON (t_irna_log.IRNA_ID = t_irna.IRNA_ID)
							INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
							WHERE t_irna_log.JNS_UPDATE = "R"
							AND STR_TO_DATE(DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%d%m%Y"),"%d%m%Y") = ' . $tgl_filter_1 . '						
							AND t_irna_log.RUANG_ID_BARU IS NULL
							AND (t_irna_log.PASIEN_PULANG_ID = 1 OR t_irna_log.PASIEN_PULANG_ID = 6 OR t_irna_log.PASIEN_PULANG_ID = 7
							OR t_irna_log.PASIEN_PULANG_ID = 9 OR t_irna_log.PASIEN_PULANG_ID = 14)';
if(!empty($ruang_id)) $sql_pasien_pulang_hidup	.= ' AND t_irna_log.RUANG_ID_ASAL = "' . $ruang_id . '"';
$get_pasien_pulang_hidup = mysql_query($sql_pasien_pulang_hidup) or die(mysql_error());
$dat_pasien_pulang_hidup = mysql_fetch_assoc($get_pasien_pulang_hidup);
$pasien_pulang_hidup_dewasa_lk = $dat_pasien_pulang_hidup['DEWASA_LK'];
$pasien_pulang_hidup_dewasa_pr = $dat_pasien_pulang_hidup['DEWASA_PR'];
$pasien_pulang_hidup_anak_lk = $dat_pasien_pulang_hidup['ANAK_LK'];
$pasien_pulang_hidup_anak_pr = $dat_pasien_pulang_hidup['ANAK_PR'];
$pasien_pulang_hidup_bayi_lk = $dat_pasien_pulang_hidup['BAYI_LK'];
$pasien_pulang_hidup_bayi_pr = $dat_pasien_pulang_hidup['BAYI_PR'];
$jumlah_pasien_pulang_hidup = $dat_pasien_pulang_hidup['TOTAL'];

$sql_pasien_dipindahkan = 'SELECT SUM(CASE WHEN t_irna.DEWASA_ANAK_BAYI = "DW" AND m_pasien.JNS_KELAMIN = "L" THEN 1 ELSE 0 END) AS DEWASA_LK,
								SUM(CASE WHEN t_irna.DEWASA_ANAK_BAYI = "DW" AND m_pasien.JNS_KELAMIN = "P" THEN 1 ELSE 0 END) AS DEWASA_PR,
								SUM(CASE WHEN t_irna.DEWASA_ANAK_BAYI = "AN" AND m_pasien.JNS_KELAMIN = "L" THEN 1 ELSE 0 END) AS ANAK_LK,
								SUM(CASE WHEN t_irna.DEWASA_ANAK_BAYI = "AN" AND m_pasien.JNS_KELAMIN = "P" THEN 1 ELSE 0 END) AS ANAK_PR,
								SUM(CASE WHEN t_irna.DEWASA_ANAK_BAYI = "BY" AND m_pasien.JNS_KELAMIN = "L" THEN 1 ELSE 0 END) AS BAYI_LK,
								SUM(CASE WHEN t_irna.DEWASA_ANAK_BAYI = "BY" AND m_pasien.JNS_KELAMIN = "P" THEN 1 ELSE 0 END) AS BAYI_PR,
								COUNT(t_irna.IRNA_ID) AS TOTAL
							FROM t_irna_log
							INNER JOIN t_irna ON (t_irna_log.IRNA_ID = t_irna.IRNA_ID)
							INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
							WHERE t_irna_log.JNS_UPDATE = "R"
							AND STR_TO_DATE(DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%d%m%Y"),"%d%m%Y") = ' . $tgl_filter_1 . '						
							AND t_irna_log.RUANG_ID_BARU IS NOT NULL';
if(!empty($ruang_id)) $sql_pasien_dipindahkan	.= ' AND t_irna_log.RUANG_ID_ASAL = "' . $ruang_id . '"';
$get_pasien_dipindahkan = mysql_query($sql_pasien_dipindahkan) or die(mysql_error());
$dat_pasien_dipindahkan = mysql_fetch_assoc($get_pasien_dipindahkan);
$pasien_dipindahkan_dewasa_lk = $dat_pasien_dipindahkan['DEWASA_LK'];
$pasien_dipindahkan_dewasa_pr = $dat_pasien_dipindahkan['DEWASA_PR'];
$pasien_dipindahkan_anak_lk = $dat_pasien_dipindahkan['ANAK_LK'];
$pasien_dipindahkan_anak_pr = $dat_pasien_dipindahkan['ANAK_PR'];
$pasien_dipindahkan_bayi_lk = $dat_pasien_dipindahkan['BAYI_LK'];
$pasien_dipindahkan_bayi_pr = $dat_pasien_dipindahkan['BAYI_PR'];
$jumlah_pasien_dipindahkan = $dat_pasien_dipindahkan['TOTAL'];

$sql_pasien_pulang_meninggal = 'SELECT SUM(CASE WHEN t_irna.DEWASA_ANAK_BAYI = "DW" AND m_pasien.JNS_KELAMIN = "L" THEN 1 ELSE 0 END) AS DEWASA_LK,
								SUM(CASE WHEN t_irna.DEWASA_ANAK_BAYI = "DW" AND m_pasien.JNS_KELAMIN = "P" THEN 1 ELSE 0 END) AS DEWASA_PR,
								SUM(CASE WHEN t_irna.DEWASA_ANAK_BAYI = "AN" AND m_pasien.JNS_KELAMIN = "L" THEN 1 ELSE 0 END) AS ANAK_LK,
								SUM(CASE WHEN t_irna.DEWASA_ANAK_BAYI = "AN" AND m_pasien.JNS_KELAMIN = "P" THEN 1 ELSE 0 END) AS ANAK_PR,
								SUM(CASE WHEN t_irna.DEWASA_ANAK_BAYI = "BY" AND m_pasien.JNS_KELAMIN = "L" THEN 1 ELSE 0 END) AS BAYI_LK,
								SUM(CASE WHEN t_irna.DEWASA_ANAK_BAYI = "BY" AND m_pasien.JNS_KELAMIN = "P" THEN 1 ELSE 0 END) AS BAYI_PR,
								COUNT(t_irna.IRNA_ID) AS TOTAL
							FROM t_irna_log
							INNER JOIN t_irna ON (t_irna_log.IRNA_ID = t_irna.IRNA_ID)
							INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
							WHERE t_irna_log.JNS_UPDATE = "R"
							AND STR_TO_DATE(DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%d%m%Y"),"%d%m%Y") = ' . $tgl_filter_1 . '						
							AND t_irna_log.RUANG_ID_BARU IS NULL
							AND (t_irna_log.PASIEN_PULANG_ID = 3 OR t_irna_log.PASIEN_PULANG_ID = 8)';
if(!empty($ruang_id)) $sql_pasien_pulang_meninggal	.= ' AND t_irna_log.RUANG_ID_ASAL = "' . $ruang_id . '"';
$get_pasien_pulang_meninggal = mysql_query($sql_pasien_pulang_meninggal) or die(mysql_error());
$dat_pasien_pulang_meninggal = mysql_fetch_assoc($get_pasien_pulang_meninggal);
$pasien_pulang_meninggal_dewasa_lk = $dat_pasien_pulang_meninggal['DEWASA_LK'];
$pasien_pulang_meninggal_dewasa_pr = $dat_pasien_pulang_meninggal['DEWASA_PR'];
$pasien_pulang_meninggal_anak_lk = $dat_pasien_pulang_meninggal['ANAK_LK'];
$pasien_pulang_meninggal_anak_pr = $dat_pasien_pulang_meninggal['ANAK_PR'];
$pasien_pulang_meninggal_bayi_lk = $dat_pasien_pulang_meninggal['BAYI_LK'];
$pasien_pulang_meninggal_bayi_pr = $dat_pasien_pulang_meninggal['BAYI_PR'];
$jumlah_pasien_pulang_meninggal = $dat_pasien_pulang_meninggal['TOTAL'];

$jml_dewasa_lk_2 = $pasien_pulang_hidup_dewasa_lk + $pasien_dipindahkan_dewasa_lk + $pasien_pulang_meninggal_dewasa_lk;
$jml_dewasa_pr_2 = $pasien_pulang_hidup_dewasa_pr + $pasien_dipindahkan_dewasa_pr + $pasien_pulang_meninggal_dewasa_pr;

$jml_anak_lk_2 = $pasien_pulang_hidup_anak_lk + $pasien_dipindahkan_anak_lk + $pasien_pulang_meninggal_anak_lk;
$jml_anak_pr_2 = $pasien_pulang_hidup_anak_pr + $pasien_dipindahkan_anak_pr + $pasien_pulang_meninggal_anak_pr;

$jml_bayi_lk_2 = $pasien_pulang_hidup_bayi_lk + $pasien_dipindahkan_bayi_lk + $pasien_pulang_meninggal_bayi_lk;
$jml_bayi_pr_2 = $pasien_pulang_hidup_bayi_pr + $pasien_dipindahkan_bayi_pr + $pasien_pulang_meninggal_bayi_pr;

$sql_pasien_lama_dirawat = 'SELECT SUM(DATEDIFF(TANGGAL_KELUAR_PLHDP,TANGGAL_MASUK_PLHDP)) AS LAMA_RAWAT_PULANG_HIDUP,
								SUM(DATEDIFF(TANGGAL_KELUAR_PLMT,TANGGAL_MASUK_PLMT)) AS LAMA_RAWAT_PULANG_MENINGGAL
								FROM (
									SELECT t_irna_log.IRNA_ID,
										(SELECT t.TANGGAL_MASUK FROM t_irna_log t 
										WHERE t.IRNA_ID = t_irna_log.IRNA_ID
										AND t.RUANG_ID_BARU = t_irna_log.RUANG_ID_ASAL
										AND t.JNS_UPDATE = "R"
										AND t.IRNA_LOG_ID < t_irna_log.IRNA_LOG_ID
										ORDER BY t.TANGGAL_MASUK DESC LIMIT 1) AS TANGGAL_MASUK_PLHDP,
										t_irna_log.TANGGAL_KELUAR AS TANGGAL_KELUAR_PLHDP,
										NULL AS TANGGAL_MASUK_PLMT,
										NULL AS TANGGAL_KELUAR_PLMT
									FROM t_irna_log
									WHERE t_irna_log.JNS_UPDATE = "R"
									AND STR_TO_DATE(DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%d%m%Y"),"%d%m%Y") = ' . $tgl_filter_1 . '						
									AND t_irna_log.RUANG_ID_BARU IS NULL
									AND (t_irna_log.PASIEN_PULANG_ID = 1 OR t_irna_log.PASIEN_PULANG_ID = 6 OR t_irna_log.PASIEN_PULANG_ID = 7
									OR t_irna_log.PASIEN_PULANG_ID = 9 OR t_irna_log.PASIEN_PULANG_ID = 14)';
if(!empty($ruang_id)) $sql_pasien_lama_dirawat	.= ' AND t_irna_log.RUANG_ID_ASAL = "' . $ruang_id . '"';
							
$sql_pasien_lama_dirawat .= 'UNION
							SELECT t_irna_log.IRNA_ID,
							NULL AS TANGGAL_MASUK_PLHDP,
							NULL AS TANGGAL_KELUAR_PLHDP,
							(SELECT t.TANGGAL_MASUK FROM t_irna_log t 
							WHERE t.IRNA_ID = t_irna_log.IRNA_ID
							AND t.RUANG_ID_BARU = t_irna_log.RUANG_ID_ASAL
							AND t.JNS_UPDATE = "R"
							AND t.IRNA_LOG_ID < t_irna_log.IRNA_LOG_ID
							ORDER BY t.TANGGAL_MASUK DESC LIMIT 1) AS TANGGAL_MASUK_PLMT,
							t_irna_log.TANGGAL_KELUAR AS TANGGAL_KELUAR_PLMT
							FROM t_irna_log
							WHERE t_irna_log.JNS_UPDATE = "R"
							AND STR_TO_DATE(DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%d%m%Y"),"%d%m%Y") = ' . $tgl_filter_1 . '						
							AND t_irna_log.RUANG_ID_BARU IS NULL
							AND (t_irna_log.PASIEN_PULANG_ID = 3 OR t_irna_log.PASIEN_PULANG_ID = 8)';
if(!empty($ruang_id)) $sql_pasien_lama_dirawat	.= ' AND t_irna_log.RUANG_ID_ASAL = "' . $ruang_id . '"';							
$sql_pasien_lama_dirawat .= ') t_rawat';
$get_pasien_lama_dirawat = mysql_query($sql_pasien_lama_dirawat) or die(mysql_error());
$dat_pasien_lama_dirawat = mysql_fetch_assoc($get_pasien_lama_dirawat);
$lama_dirawat_pasien_pulang_hidup = $dat_pasien_lama_dirawat['LAMA_RAWAT_PULANG_HIDUP'];
$lama_dirawat_pasien_pulang_meninggal = $dat_pasien_lama_dirawat['LAMA_RAWAT_PULANG_MENINGGAL'];
$jumlah_lama_dirawat = $dat_pasien_lama_dirawat['LAMA_RAWAT_PULANG_HIDUP'] + $dat_pasien_lama_dirawat['LAMA_RAWAT_PULANG_MENINGGAL'];

$sql_pasien_pulang_harisama = 'SELECT COUNT(DISTINCT IRNA_ID) AS PULANG_HARI_SAMA
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
							WHERE t_irna_log.JNS_UPDATE = "R"
							AND t_irna_log.RUANG_ID_BARU IS NULL
							AND STR_TO_DATE(DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%d%m%Y"),"%d%m%Y") = ' . $tgl_filter_1;
if(!empty($ruang_id)) $sql_pasien_pulang_harisama .= ' AND t_irna_log.RUANG_ID_ASAL = "' . $ruang_id . '"';
$sql_pasien_pulang_harisama .= ') t_rawat
						WHERE DATE_FORMAT(TANGGAL_MASUK,"%d%m%Y") = DATE_FORMAT(TANGGAL_KELUAR,"%d%m%Y")';
$get_pasien_pulang_harisama = mysql_query($sql_pasien_pulang_harisama) or die(mysql_error());
$dat_pasien_pulang_harisama = mysql_fetch_assoc($get_pasien_pulang_harisama);
$pasien_masuk_pulang_pada_hari_sama = $dat_pasien_pulang_harisama['PULANG_HARI_SAMA'];

$sql_pasien_sekarang = 'SELECT COUNT(t_irna_opname.IRNA_ID) AS TOTAL
							FROM t_irna_opname 
						WHERE t_irna_opname.TANGGAL_OPNAME = ' . $tgl_filter_1;
if(!empty($ruang_id)) $sql_pasien_sekarang .= ' AND t_irna_opname.RUANG_ID = "' . $ruang_id . '"';
$get_pasien_sekarang = mysql_query($sql_pasien_sekarang) or die(mysql_error());
$dat_pasien_sekarang = mysql_fetch_assoc($get_pasien_sekarang);
$pasien_sekarang = $dat_pasien_sekarang['TOTAL']; 

$sql_pasien_agama = 'SELECT SUM(CASE WHEN m_pasien.AGAMA_ID = 1 THEN 1 ELSE 0 END) AS PASIEN_ISLAM,
							SUM(CASE WHEN m_pasien.AGAMA_ID = 2 THEN 1 ELSE 0 END) AS PASIEN_PROTESTAN,
							SUM(CASE WHEN m_pasien.AGAMA_ID = 3 THEN 1 ELSE 0 END) AS PASIEN_KATHOLIK,
							SUM(CASE WHEN m_pasien.AGAMA_ID = 4 THEN 1 ELSE 0 END) AS PASIEN_HINDU,
							SUM(CASE WHEN m_pasien.AGAMA_ID = 5 THEN 1 ELSE 0 END) AS PASIEN_BUDHA,
							SUM(CASE WHEN m_pasien.AGAMA_ID = 6 THEN 1 ELSE 0 END) AS PASIEN_AGAMA_LAIN
						FROM t_irna_opname
						INNER JOIN t_irna ON (t_irna_opname.IRNA_ID = t_irna.IRNA_ID)
						INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
						WHERE t_irna_opname.TANGGAL_OPNAME = ' . $tgl_filter_1;
if(!empty($ruang_id)) $sql_pasien_agama	.= ' AND t_irna_opname.RUANG_ID = "' . $ruang_id . '"';												
$get_pasien_agama = mysql_query($sql_pasien_agama) or die(mysql_error());
$dat_pasien_agama = mysql_fetch_assoc($get_pasien_agama);
$pasien_islam = $dat_pasien_agama['PASIEN_ISLAM'];
$pasien_protestan = $dat_pasien_agama['PASIEN_PROTESTAN'];
$pasien_katholik = $dat_pasien_agama['PASIEN_KATHOLIK'];
$pasien_hindu = $dat_pasien_agama['PASIEN_HINDU'];
$pasien_budha = $dat_pasien_agama['PASIEN_BUDHA'];
$pasien_agama_lain = $dat_pasien_agama['PASIEN_AGAMA_LAIN'];

$sql_pasien_bangsa = 'SELECT SUM(CASE WHEN t_irna.BANGSA = "INDONESIA" THEN 1 ELSE 0 END) AS PASIEN_INDONESIA,
							SUM(CASE WHEN t_irna.BANGSA = "TIONGHOA" THEN 1 ELSE 0 END) AS PASIEN_TIONGHOA,
							SUM(CASE WHEN t_irna.BANGSA = "ARAB" THEN 1 ELSE 0 END) AS PASIEN_ARAB,
							SUM(CASE WHEN t_irna.BANGSA = "INDIA" THEN 1 ELSE 0 END) AS PASIEN_INDIA,
							SUM(CASE WHEN t_irna.BANGSA = "LAINNYA" THEN 1 ELSE 0 END) AS PASIEN_LAINNYA
						FROM t_irna_opname
						INNER JOIN t_irna ON (t_irna_opname.IRNA_ID = t_irna.IRNA_ID)
						WHERE t_irna_opname.TANGGAL_OPNAME = ' . $tgl_filter_1;
if(!empty($ruang_id)) $sql_pasien_bangsa	.= ' AND t_irna_opname.RUANG_ID = "' . $ruang_id . '"';						
$get_pasien_bangsa = mysql_query($sql_pasien_bangsa) or die(mysql_error());
$dat_pasien_bangsa = mysql_fetch_assoc($get_pasien_bangsa);
$pasien_indonesia = $dat_pasien_bangsa['PASIEN_INDONESIA'];
$pasien_tionghoa = $dat_pasien_bangsa['PASIEN_TIONGHOA'];
$pasien_arab = $dat_pasien_bangsa['PASIEN_ARAB'];
$pasien_india = $dat_pasien_bangsa['PASIEN_INDIA'];
$pasien_ras_lain = $dat_pasien_bangsa['PASIEN_LAINNYA'];

$sql_tempat_tidur = 'SELECT COUNT(TMP_DW) AS TMP_DW,
				COUNT(TMP_AN) AS TMP_AN,
				COUNT(TMP_BY) AS TMP_BY,
				COUNT(TMP_TOTAL) AS TMP_TOTAL,
				COUNT(ISI_DW) AS ISI_DW,
				COUNT(ISI_AN) AS ISI_AN,
				COUNT(ISI_BY) AS ISI_BY,
				COUNT(ISI_TOTAL) AS ISI_TOTAL
				FROM (
					SELECT CASE WHEN m_ruang_detail.DW_AN_BY LIKE "%DW%" THEN m_ruang_detail.RUANG_DETAIL_ID END AS TMP_DW,
						CASE WHEN m_ruang_detail.DW_AN_BY LIKE "%AN%" THEN m_ruang_detail.RUANG_DETAIL_ID END AS TMP_AN,
						CASE WHEN m_ruang_detail.DW_AN_BY LIKE "%BY%" THEN m_ruang_detail.RUANG_DETAIL_ID END AS TMP_BY,
						m_ruang_detail.RUANG_DETAIL_ID AS TMP_TOTAL,
						NULL AS ISI_DW,
						NULL AS ISI_AN,
						NULL AS ISI_BY,
						NULL AS ISI_TOTAL
					FROM m_ruang_detail
					WHERE 1';
if(!empty($ruang_id)) $sql_tempat_tidur	.= ' AND m_ruang_detail.RUANG_ID = "' . $ruang_id . '"';																
$sql_tempat_tidur	.= ' UNION	
					SELECT NULL AS TMP_DW,
						NULL AS TMP_AN,
						NULL AS TMP_BY,
						NULL AS TMP_TOTAL,
						CASE WHEN t_irna.DEWASA_ANAK_BAYI = "DW" THEN t_irna.IRNA_ID END AS ISI_DW,
						CASE WHEN t_irna.DEWASA_ANAK_BAYI = "AN" THEN t_irna.IRNA_ID END AS ISI_AN,
						CASE WHEN t_irna.DEWASA_ANAK_BAYI = "BY" THEN t_irna.IRNA_ID END AS ISI_BY,
						t_irna.IRNA_ID AS ISI_TOTAL
						FROM t_irna
						INNER JOIN t_irna_opname ON (t_irna.IRNA_ID = t_irna_opname.IRNA_ID)
						WHERE t_irna_opname.TANGGAL_OPNAME = ' . $tgl_filter_1;
if(!empty($ruang_id)) $sql_tempat_tidur	.= ' AND t_irna_opname.RUANG_ID = "' . $ruang_id . '"';			
$sql_tempat_tidur	.= ') t_ruang_tersedia';
$get_tempat_tidur = mysql_query($sql_tempat_tidur) or die(mysql_error());
$dat_tempat_tidur = mysql_fetch_assoc($get_tempat_tidur);
$tmp_tidur_tersedia_dewasa = $dat_tempat_tidur['TMP_DW'] - $dat_tempat_tidur['ISI_DW'];
$tmp_tidur_tersedia_anak = $dat_tempat_tidur['TMP_AN'] - $dat_tempat_tidur['ISI_AN'];
$tmp_tidur_tersedia_bayi = $dat_tempat_tidur['TMP_BY'] - $dat_tempat_tidur['ISI_BY'];
$jumlah_tmp_tidur_tersedia = $dat_tempat_tidur['TMP_TOTAL'] - $dat_tempat_tidur['ISI_TOTAL'];
?>
<form name="search" method="get" action="index.php">
    <table class="tableform" border="0">
        <tr>
            <td>Tanggal</td>
            <td><input type="text" name="tgl_1" id="tgl_1" value="<?php echo $tgl_1; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
        </tr>
		<tr>
			<td>Ruang Rawat</td>
            <td><select name="ruang_id" class="text_dt" style="width:220px;" >
				<option value=""> - </option>
				<?php echo getRuangRawat($ruang_id); ?>
			</select></td>
            <td align="right" colspan="2"><input type="submit" value="cari" class="myButton" />&nbsp;
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" />
			</td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<table border="1" class="tableData" id="tfhover" >
    <tr>
    <th colspan="11">RINGKASAN SENSUS (Rincian Pasien Pada Jam : 00.00 WIB) </th>
  </tr>	
  <tr>
    <th rowspan="2">No</th>
    <th colspan="3" rowspan="2">Keterangan</th>
    <th colspan="2">Dewasa</th>
    <th colspan="2">Anak-Anak</th>
    <th colspan="2">Bayi</th>
    <th rowspan="2">Jumlah</th>
  </tr>
  <tr>
    <th>Laki-laki</th>
    <th>Perempuan</th>
    <th>Laki-laki</th>
    <th>Perempuan</th>
    <th>Laki-laki</th>
    <th>Perempuan</th>
  </tr>
  <tr>
    <td><div align="center">1</div></td>
    <td colspan="3">Pasien Kemarian (Hari Sebelumnya) </td>
    <td align="right"><?php echo currFormat($pasien_kemarin_dewasa_lk,0); ?></td>
    <td align="right"><?php echo currFormat($pasien_kemarin_dewasa_pr,0); ?></td>
    <td align="right"><?php echo currFormat($pasien_kemarin_anak_lk,0); ?></td>
    <td align="right"><?php echo currFormat($pasien_kemarin_anak_pr,0); ?></td>
    <td align="right"><?php echo currFormat($pasien_kemarin_bayi_lk,0); ?></td>
	<td align="right"><?php echo currFormat($pasien_kemarin_bayi_pr,0); ?></td>
    <td align="right"><?php echo currFormat($jumlah_pasien_kemarin,0); ?></td>
  </tr>
  <tr>
    <td><div align="center">2</div></td>
    <td colspan="3">Pasien Masuk (Dirawat) </td>
    <td align="right"><?php echo currFormat($pasien_masuk_dewasa_lk,0); ?></td>
    <td align="right"><?php echo currFormat($pasien_masuk_dewasa_pr,0); ?></td>
    <td align="right"><?php echo currFormat($pasien_masuk_anak_lk,0); ?></td>
    <td align="right"><?php echo currFormat($pasien_masuk_anak_pr,0); ?></td>
    <td align="right"><?php echo currFormat($pasien_masuk_bayi_lk,0); ?></td>
	<td align="right"><?php echo currFormat($pasien_masuk_bayi_pr,0); ?></td>
    <td align="right"><?php echo currFormat($jumlah_pasien_masuk,0); ?></td>
  </tr>
  <tr>
    <td><div align="center">3</div></td>
    <td colspan="3">Pasien Pindahan dari Bangsal Lain (Pasien Kembali Dari Cuti) </td>
    <td align="right"><?php echo currFormat($pasien_pindahan_dewasa_lk,0); ?></td>
    <td align="right"><?php echo currFormat($pasien_pindahan_dewasa_pr,0); ?></td>
    <td align="right"><?php echo currFormat($pasien_pindahan_anak_lk,0); ?></td>
    <td align="right"><?php echo currFormat($pasien_pindahan_anak_pr,0); ?></td>
    <td align="right"><?php echo currFormat($pasien_pindahan_bayi_lk,0); ?></td>
	<td align="right"><?php echo currFormat($pasien_pindahan_bayi_pr,0); ?></td>
    <td align="right"><?php echo currFormat($jumlah_pasien_pindahan,0); ?></td>
  </tr>
  <tr>
    <td><div align="center">4</div></td>
    <td colspan="3">Jumlah No. 1 + No. 2 + No. 3 </td>
    <td align="right"><?php echo currFormat($jml_dewasa_lk,0); ?></td>
    <td align="right"><?php echo currFormat($jml_dewasa_pr,0); ?></td>
    <td align="right"><?php echo currFormat($jml_anak_lk,0); ?></td>
    <td align="right"><?php echo currFormat($jml_anak_pr,0); ?></td>
    <td align="right"><?php echo currFormat($jml_bayi_lk,0); ?></td>
    <td align="right"><?php echo currFormat($jml_bayi_pr,0); ?></td>
    <td align="right"><?php echo currFormat($jumlah_pasien_kemarin + $jumlah_pasien_masuk + $jumlah_pasien_pindahan,0); ?></td>
  </tr>
  <tr>
    <td><div align="center">5</div></td>
    <td colspan="3">Pasien Pulang Hidup </td>
    <td align="right"><?php echo currFormat($pasien_pulang_hidup_dewasa_lk,0); ?></td>
    <td align="right"><?php echo currFormat($pasien_pulang_hidup_dewasa_pr,0); ?></td>
    <td align="right"><?php echo currFormat($pasien_pulang_hidup_anak_lk,0); ?></td>
    <td align="right"><?php echo currFormat($pasien_pulang_hidup_anak_pr,0); ?></td>
    <td align="right"><?php echo currFormat($pasien_pulang_hidup_bayi_lk,0); ?></td>
	<td align="right"><?php echo currFormat($pasien_pulang_hidup_bayi_pr,0); ?></td>
    <td align="right"><?php echo currFormat($jumlah_pasien_pulang_hidup,0); ?></td>
  </tr>
  <tr>
    <td><div align="center">6</div></td>
    <td colspan="3">Pasien Dipindahkan Ke Bangsal Lain (Pasien Ijin Cuti) </td>
    <td align="right"><?php echo currFormat($pasien_dipindahkan_dewasa_lk,0); ?></td>
    <td align="right"><?php echo currFormat($pasien_dipindahkan_dewasa_pr,0); ?></td>
    <td align="right"><?php echo currFormat($pasien_dipindahkan_anak_lk,0); ?></td>
    <td align="right"><?php echo currFormat($pasien_dipindahkan_anak_pr,0); ?></td>
    <td align="right"><?php echo currFormat($pasien_dipindahkan_bayi_lk,0); ?></td>
	<td align="right"><?php echo currFormat($pasien_dipindahkan_bayi_pr,0); ?></td>
    <td align="right"><?php echo currFormat($jumlah_pasien_dipindahkan,0); ?></td>
  </tr>
  <tr>
    <td><div align="center">7</div></td>
    <td colspan="3">Pasien Meninggal Dunia </td>
    <td align="right"><?php echo currFormat($pasien_pulang_meninggal_dewasa_lk,0); ?></td>
    <td align="right"><?php echo currFormat($pasien_pulang_meninggal_dewasa_pr,0); ?></td>
    <td align="right"><?php echo currFormat($pasien_pulang_meninggal_anak_lk,0); ?></td>
    <td align="right"><?php echo currFormat($pasien_pulang_meninggal_anak_pr,0); ?></td>
    <td align="right"><?php echo currFormat($pasien_pulang_meninggal_bayi_lk,0); ?></td>
	<td align="right"><?php echo currFormat($pasien_pulang_meninggal_bayi_pr,0); ?></td>
    <td align="right"><?php echo currFormat($jumlah_pasien_pulang_meninggal,0); ?></td>
  </tr>
  <tr>
    <td><div align="center">8</div></td>
    <td colspan="3">Jumlah No. 5 + No. 6 + No. 7 </td>
    <td align="right"><?php echo currFormat($jml_dewasa_lk_2,0); ?></td>
    <td align="right"><?php echo currFormat($jml_dewasa_pr_2,0); ?></td>
    <td align="right"><?php echo currFormat($jml_anak_lk_2,0); ?></td>
    <td align="right"><?php echo currFormat($jml_anak_pr_2,0); ?></td>
    <td align="right"><?php echo currFormat($jml_bayi_lk_2,0); ?></td>
    <td align="right"><?php echo currFormat($jml_bayi_pr_2,0); ?></td>
    <td align="right"><?php echo currFormat($jumlah_pasien_pulang_hidup + $jumlah_pasien_dipindahkan + $jumlah_pasien_pulang_meninggal,0); ?></td>
  </tr>
  <tr>
    <td><div align="center">9</div></td>
    <td colspan="3">Sensus Yang Sesungguhnya = Jumlah Pasien Pada Jam : 00.00 WIB </td>
    <td align="right"><?php echo currFormat($jml_dewasa_lk + $jml_dewasa_lk_2,0); ?></td>
    <td align="right"><?php echo currFormat($jml_dewasa_pr + $jml_dewasa_pr_2,0); ?></td>
    <td align="right"><?php echo currFormat($jml_anak_lk + $jml_anak_lk_2,0); ?></td>
    <td align="right"><?php echo currFormat($jml_anak_pr + $jml_anak_pr_2,0); ?></td>
    <td align="right"><?php echo currFormat($jml_bayi_lk + $jml_bayi_lk_2,0); ?></td>
    <td align="right"><?php echo currFormat($jml_bayi_pr + $jml_bayi_pr_2,0); ?></td>
    <td align="right"><?php echo currFormat(($jumlah_pasien_kemarin + $jumlah_pasien_masuk + $jumlah_pasien_pindahan) -
				($jumlah_pasien_pulang_hidup + $jumlah_pasien_dipindahkan + $jumlah_pasien_pulang_meninggal),0); ?></td>
  </tr>
  <tr>
    <td colspan="11">&nbsp;</td>
  </tr>
  <tr>
    <th colspan="3">Lama Dirawat Dari </th>
    <td rowspan="7">&nbsp;</td>
    <th>No</th>
    <th>Agama</th>
    <th>Jumlah</th>
    <td rowspan="7">&nbsp;</td>
    <th>No</th>
    <th>Bangsa</th>
    <th>Jumlah</th>
  </tr>
  <tr>
    <td align="center">a</td>
    <td>Pasien Yang Pulang Hidup </td>
    <td align="right"><?php echo currFormat($lama_dirawat_pasien_pulang_hidup,0); ?></td>
    <td align="center">1</td>
    <td>Islam</td>
    <td align="right"><?php echo currFormat($pasien_islam,0); ?></td>
    <td align="center">1</td>
    <td>Indonesia</td>
    <td align="right"><?php echo currFormat($pasien_indonesia,0); ?></td>
  </tr>
  <tr>
    <td align="center">b</td>
    <td>Pasien Yang Meninggal </td>
    <td align="right"><?php echo currFormat($lama_dirawat_pasien_pulang_meninggal,0); ?></td>
    <td align="center">2</td>
    <td>Protestan</td>
    <td align="right"><?php echo currFormat($pasien_protestan,0); ?></td>
    <td align="center">2</td>
    <td>Tionghoa</td>
    <td align="right"><?php echo currFormat($pasien_tionghoa,0); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Jumlah</td>
    <td align="right"><?php echo currFormat($jumlah_lama_dirawat,0); ?></td>
    <td align="center">3</td>
    <td>Katholik</td>
    <td align="right"><?php echo currFormat($pasien_katholik,0); ?></td>
    <td align="center">3</td>
    <td>Arab</td>
    <td align="right"><?php echo currFormat($pasien_arab,0); ?></td>
  </tr>
  <tr>
    <th colspan="3">Pasien Masuk &amp; Pulang Pada</th>
    <td align="center">4</td>
    <td>Hindu</td>
    <td align="right"><?php echo currFormat($pasien_hindu,0); ?></td>
    <td align="center">4</td>
    <td>India</td>
    <td align="right"><?php echo currFormat($pasien_india,0); ?></td>
  </tr>
  <tr>
    <td align="center">a</td>
    <td>Hari Yang Sama </td>
    <td align="right"><?php echo currFormat($pasien_masuk_pulang_pada_hari_sama,0); ?></td>
    <td align="center">5</td>
    <td>Budha</td>
    <td align="right"><?php echo currFormat($pasien_budha,0); ?></td>
    <td align="center">5</td>
    <td>Lainnya</td>
    <td align="right"><?php echo currFormat($pasien_ras_lain,0); ?></td>
  </tr>
  <tr>
    <td align="center">b</td>
    <td>Sensus Yang Sesungguhnya </td>
    <td align="right"><?php echo currFormat(($jumlah_pasien_kemarin + $jumlah_pasien_masuk + $jumlah_pasien_pindahan) -
				($jumlah_pasien_pulang_hidup + $jumlah_pasien_dipindahkan + $jumlah_pasien_pulang_meninggal),0); ?></td>
    <td align="center">6</td>
    <td>Lainnya</td>
    <td align="right"><?php echo currFormat($pasien_agama_lain,0); ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Jumlah Pasien Yang Mendapat Pelayanan Di Bangsal </td>
    <td align="right"><?php echo currFormat($pasien_sekarang,0); ?></td>
    <td colspan="8" rowspan="6">&nbsp;</td>
  </tr>
  
  <tr>
    <th colspan="3">Tempat Tidur Yang Tersedia </th>
  </tr>
  <tr>
    <td align="center">a</td>
    <td>Dewasa</td>
    <td align="right"><?php echo currFormat($tmp_tidur_tersedia_dewasa,0); ?></td>
  </tr>
  <tr>
    <td align="center">b</td>
    <td>Anak-anak</td>
    <td align="right"><?php echo currFormat($tmp_tidur_tersedia_anak,0); ?></td>
  </tr>
  <tr>
    <td align="center">c</td>
    <td>Bayi</td>
    <td align="right"><?php echo currFormat($tmp_tidur_tersedia_bayi,0); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Jumlah</td>
    <td align="right"><?php echo currFormat($tmp_tidur_tersedia_anak + $tmp_tidur_tersedia_dewasa + $tmp_tidur_tersedia_bayi,0); ?></td>
  </tr>
</table>
<form id="xls_export" name="xls_export" method="post">
    <input type="hidden" name="page_to_excel" value="1" />
    <input type="hidden" name="tgl_1" value="<?php echo $tgl_1; ?>" />
    <input type="hidden" name="ruang_id" value="<?php echo $ruang_id; ?>" />
    <input type="hidden" name="xlsfile" value="rawatinap/xls_report_sensus_harian_pasien.php" />
    <input type="hidden" name="xlsname" value="rpt_sensus_harian_pasien.xls" />            
</form>