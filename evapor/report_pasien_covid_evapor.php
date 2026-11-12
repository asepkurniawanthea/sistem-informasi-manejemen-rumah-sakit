<style>
.list_isi{
	height:550px;
}
</style>

<?php
$tgl_1 = '';
if (isset($_SESSION['ranapsearchpasienperiksa_tgl_1']))
    $tgl_1 = $_SESSION['ranapsearchpasienperiksa_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['ranapsearchpasienperiksa_tgl_1']))
    $tgl_2 = $_SESSION['ranapsearchpasienperiksa_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['ranapsearchpasienperiksa_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['ranapsearchpasienperiksa_tgl_2'] = $_GET['tgl_2'];
}

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}

/*$searchkey = '';
if (isset($_SESSION['pembayaransearchaps_searchkey']))
		$searchkey = $_SESSION['pembayaransearchaps_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['pembayaransearchaps_searchkey'] = $searchkey;
}*/

?>
<form name="search" method="get" action="index.php">
    <table class="tableform" >
        <tr>
            <td>Tanggal</td>
            <td><input type="text" name="tgl_1" id="tgl_1" value="<?php echo $tgl_1; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
            <td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/></td>
			<!--<td> Nama Pasien</td>
			<td><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt" />-->
			
			<td><input type="submit" value="cari" class="myButton" />&nbsp;
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_kunjungan = 'SELECT t_irna.IRNA_ID, t_irna.NOMR,DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
            DATE_FORMAT(t_irna.PASIEN_KELUAR,"%d/%m/%Y %H:%i:%s") AS PASIEN_KELUAR,m_ruang.RUANG_ID,t_irna.ST_COVID19,t_irna.ST_COVID19_KOMORBIT,
            m_ruang.NAMA_RUANG,m_jaminan.NAMA_JAMINAN,t_irna.NO_TMP_TIDUR,t_irna_laporan_covid.USIA,t_irna_laporan_covid.RIWAYAT_PEKERJAAN,
            t_irna_laporan_covid.SEVERITY_LEVEL,t_irna_laporan_covid.VARIAN,t_irna_laporan_covid.KOMORBID,t_irna_laporan_covid.HASIL_RONTGEN,
            t_irna_laporan_covid.HASIL_SGTF,t_irna_laporan_covid.TERAPI,DATE_FORMAT(t_irna_laporan_covid.TGL_ICU, "%d/%m/%Y") AS TGL_ICU,
            t_irna_laporan_covid.STATUS_PASIEN,DATEDIFF(t_irna.PASIEN_KELUAR,t_irna.TANGGAL_DAFTAR) AS LOS,t_irna_laporan_covid.STATUS_VAKSIN,DATE_FORMAT(t_irna_laporan_covid.TGL_VAKSIN, "%d/%m/%Y") AS TGL_VAKSIN,
            DATE_FORMAT(t_irna_laporan_covid.TGL_AMBIL_WGS, "%d/%m/%Y") AS TGL_AMBIL_WGS,DATE_FORMAT(t_irna_laporan_covid.TGL_KIRIM_WGS, "%d/%m/%Y") AS TGL_KIRIM_WGS,
            DATE_FORMAT(t_irna_laporan_covid.TGL_KELUAR_WGS,"%d/%m/%Y") AS TGL_KELUAR_WGS,t_irna_laporan_covid.HASIL_WGS,
            m_pasien.NAMA_PASIEN,date_format(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NAMA_IBU,m_pasien.NOMR,m_pasien.PASIEN_ID,
            t_irna.USER_IRNA,m_pegawai.NAMA_PEGAWAI,m_pasien_pulang.KET_PASIEN_PULANG,t_irna.NO_RAWAT,
            m_ruang.KELAS_RAWAT,t_irna.ST_PINDAH,t_irna.PASIEN_MASUK,t_irna.ST_PULANG,t_irna_resume_medis.PEMERIKSAAN_RADIOLOGI
            FROM t_irna
            INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR) 
            LEFT JOIN t_irna_laporan_covid ON (t_irna_laporan_covid.IRNA_ID = t_irna.IRNA_ID)
            LEFT JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
            LEFT JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
            LEFT JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
            LEFT JOIN m_pasien_pulang ON (t_irna.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID)
            LEFT JOIN t_irna_resume_medis ON (t_irna_resume_medis.IRNA_ID = t_irna.IRNA_ID)
            WHERE t_irna.NO_PENDAFTARAN IS NOT NULL AND t_irna.ST_BATAL IS NULL	AND (m_ruang.RUANG_ID="47"
			OR m_ruang.RUANG_ID="101" or m_ruang.RUANG_ID="87" or m_ruang.RUANG_ID="86")
            AND ((DATE(t_irna.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' AND DATE(t_irna.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . ')
            OR t_irna.ST_PULANG IS NULL)';
				
/*if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_kunjungan = $qry_kunjungan . ' AND CONCAT(t_irna.IRNA_ID,m_pasien.NAMA_PASIEN) LIKE "%' . $searchkey . '%"';
}			
				
if($searchkey != '') $qry_kunjungan = $qry_kunjungan . ' ORDER BY m_pasien.NAMA_PASIEN,t_irna.IRNA_ID';*/
				
//$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 ;;
$extparam = '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 ;

//$action = '<a href="index.php?link=ae31dfb0a2bce5010204c6c1bdc2c1bd&no_irna=###" >ubah</a>';
/*$action = '<a href="report/report_form_coba.php" >Ubah</a>';*/
include('evapor/evapor_list_report_covid.php');
?>
