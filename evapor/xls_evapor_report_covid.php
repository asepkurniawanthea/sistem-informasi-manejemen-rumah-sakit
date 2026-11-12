<?php
include('./config/config.php');
include('./shared/connect_db.php');
include('./shared/function.php');

$tgl_1 = '';
if (isset($_POST['tgl_1']))
    $tgl_1 = $_POST['tgl_1'];
$tgl_2 = '';
if (isset($_POST['tgl_1']))
    $tgl_2 = $_POST['tgl_2'];
/*$searchkey = '';
if (isset($_POST['searchkey']))
    $searchkey = $_POST['searchkey'];
$jaminan_id = '';
if (isset($_POST['jaminan_id']))
    $jaminan_id = $_POST['jaminan_id'];
$ruang_id = '';
if (isset($_POST['ruang_id']))
    $ruang_id = $_POST['ruang_id'];*/

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}	
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
	
/*
if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	//$qry_kunjungan = $qry_kunjungan . ' AND CONCAT(m_pasien.NOMR,m_pasien.NAMA_PASIEN) LIKE "%' . $searchkey . '%"';
}	
if (!empty($jaminan_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_irna.JENIS_BAYAR_ID = "' . $jaminan_id . '"';
}

if (!empty($ruang_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND m_ruang.BANGSAL = "' . $ruang_id . '"';
}

$qry_kunjungan = $qry_kunjungan . 'ORDER BY t_irna.IRNA_ID';
*/

?>
<table border="1" >
	<tr>
		<th colspan="15">Laporan Pasien Covid19 <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>
    <tr>
    <th>No</th>
        <th>Ruang Rawat</th>
        <th>Inisial Nama</th>
        <th>Usia</th>
        <th>Gender</th>
        <th>Riwayat Pekerjaan</th>
        <th>Severity Level</th>
        <th>Varian</th>
        <th>Komorbid</th>
        <th>Hasil Rontgen</th>
        <th>Hasil SGTF</th>
        <th>Terapi</th>
        <th>Tgl Masuk RS</th>
        <th>Tgl Masuk ICU</th>
        <th>Status Pasien Saat Ini</th>
        <th>LOS</th>
        <th>Status Vaksin</th>
        <th>Tgl Vaksin</th>
        <th>Tgl Pengambilan Sample WGS</th>
        <th>Tgl Pengiriman Sample WGS</th>
        <th>Tgl Keluar Hasil WGS</th>
        <th>Hasil WGS</th>
  </tr>
    <?
    $no = 1; 
	$rs = mysql_query($qry_kunjungan) or die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
	?>
	<tr>
	<td scope="row" align="center"><?php echo $no; ?></td>
	 <td><?php echo $data['NAMA_RUANG']; ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <?php
                $tgl_lahir=$data['TGL_LAHIR'];
                $tgl_daftar=$data['TANGGAL_DAFTAR'];
                $umur = getUmurDaftar($tgl_lahir,$tgl_daftar);
            ?>
            <td><?php echo $umur; ?></td>
            <td><?php echo jenisKelamin($data['JNS_KELAMIN']); ?></td>
            <td><?php echo $data['RIWAYAT_PEKERJAAN'];?></td>
            <td><?php echo $data['SEVERITY_LEVEL'];?></td>
            <td><?php echo $data['VARIAN'];?></td>
            <?php if($data['ST_COVID19_KOMORBIT'] == "2"){
                        $komorbid="Komorbid";
                    }else{
                        $komorbid="Non Komorbid";
                    }
                 
            ?>
            <td><?php echo $komorbid;?></td>
            <td><?php echo $data['PEMERIKSAAN_RADIOLOGI'];?></td>
            <td><?php echo $data['HASIL_SGTF'];?></td>
            <td><?php echo $data['TERAPI'];?></td>
            <td><?php echo $data['TANGGAL_DAFTAR'];?></td>
            <td><?php echo $data['TGL_ICU'];?></td>
            <td><?php echo $data['STATUS_PASIEN'];?></td>
            <td><?php echo $data['LOS'];?></td>
            <td><?php echo $data['STATUS_VAKSIN'];?></td>
            <td><?php echo $data['TGL_VAKSIN'];?></td>
            <td><?php echo $data['TGL_AMBIL_WGS'];?></td>
            <td><?php echo $data['TGL_KIRIM_WGS'];?></td>
            <td><?php echo $data['TGL_KELUAR_WGS'];?></td>
            <td><?php echo $data['HASIL_WGS'];?></td>
  </tr>
        <?
    $no++; }
    ?>
</table>
