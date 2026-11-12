<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tgl_1 = '';
if (isset($_SESSION['ranapsearchpasienkeluarmasuk_tgl_1']))
    $tgl_1 = $_SESSION['ranapsearchpasienkeluarmasuk_tgl_1'];

if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
	$_SESSION['ranapsearchpasienkeluarmasuk_tgl_1'] = $tgl_1;
}

$ruang_id = '';
if (isset($_SESSION['ranapsearchpasienkeluarmasuk_ruang_id']))
		$ruang_id = $_SESSION['ranapsearchpasienkeluarmasuk_ruang_id'];

if (isset($_GET['ruang_id'])) {
    $ruang_id = $_GET['ruang_id'];
	$_SESSION['ranapsearchpasienkeluarmasuk_ruang_id'] = $ruang_id;
}

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}	
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
        <th>No</th>
		<th>Masuk Ruang Rawat</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
        <th>Jenis Kelamin</th>
		<th>Umur</th>
        <th>Pembayaran</th>
        <th>Jam Masuk</th>
		<th>Diagnosa<br />Awal Medis</th>
		<th>Masuk Dari</th>
		<th>Type MH</th>
		<th>Terapi</th>
		<th>Alamat</th>
    </tr>
<?php
$qry_ruang = '';
if(!empty($ruang_id)) $qry_ruang = 'AND t_irna_log.RUANG_ID_BARU = "' . $ruang_id . '"';
$qry_masuk = 'SELECT t_irna.NOMR,m_pasien.NAMA_PASIEN,m_pasien.JNS_KELAMIN,
					DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
					DATE_FORMAT(t_irna_log.TANGGAL_MASUK,"%d/%m/%Y") AS TANGGAL_MASUK,
					DATE_FORMAT(t_irna_log.TANGGAL_MASUK,"%d/%m/%Y %h:%i:%s") AS JAM_MASUK,
					m_jaminan.NAMA_JAMINAN,t_irna.DIAGNOSA_AWAL,
					m_ruang.NAMA_RUANG AS MASUK_DARI,"" AS TYPE_MH,"" AS TERAPI,
					m_pasien.ALAMAT,CONCAT(m_ruang2.NAMA_RUANG,"-",m_ruang2.KELAS_RAWAT) AS NAMA_RUANG
					FROM t_irna_log
					INNER JOIN t_irna ON (t_irna_log.IRNA_ID = t_irna.IRNA_ID)
					INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
					INNER JOIN m_ruang m_ruang2 ON (t_irna_log.RUANG_ID_BARU = m_ruang2.RUANG_ID)
					LEFT JOIN m_jaminan ON (t_irna_log.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
					LEFT JOIN m_ruang ON (t_irna_log.RUANG_ID_ASAL = m_ruang.RUANG_ID)
					WHERE t_irna_log.JNS_UPDATE = "R"
					' . $qry_ruang . '
					AND STR_TO_DATE(DATE_FORMAT(t_irna_log.TANGGAL_MASUK,"%d%m%Y"),"%d%m%Y") = ' . $tgl_filter_1 . '
					ORDER BY t_irna_log.TANGGAL_MASUK';
$get_masuk = mysql_query($qry_masuk) or die(mysql_error());
$no = 1;
while($dat_masuk = mysql_fetch_array($get_masuk)){
	?>
	<tr>
		<td><?php echo $no; ?></td>
		<td><?php echo $dat_masuk['NAMA_RUANG']; ?></td>
        <td><?php echo formatNomr($dat_masuk['NOMR']); ?></td>
        <td><?php echo $dat_masuk['NAMA_PASIEN']; ?></td>
        <td><?php echo jenisKelamin($dat_masuk['JNS_KELAMIN']); ?></td>
		<td><?php echo getUmurDaftar($dat_masuk['TGL_LAHIR'],$dat_masuk['TANGGAL_MASUK']) . ' (' . $dat_masuk['TGL_LAHIR'] . ')'; ?></td>
        <td><?php echo $dat_masuk['NAMA_JAMINAN']; ?></td>
        <td><?php echo $dat_masuk['JAM_MASUK']; ?></td>
		<td><?php echo $dat_masuk['DIAGNOSA_AWAL']; ?></td>
		<td><?php echo $dat_masuk['MASUK_DARI']; ?></td>
		<td><?php echo $dat_masuk['TYPE_MH']; ?></td>
		<td><?php echo $dat_masuk['TERAPI']; ?></td>
		<td><?php echo $dat_masuk['ALAMAT']; ?></td>
	</tr>
	<?php
$no++; }	
?>	
	<tr>
		<td colspan="13">&nbsp;</td>
	</tr>
    <tr>
        <th>No</th>
		<th>Keluar Ruang Rawat</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
        <th>Jenis Kelamin</th>
		<th>Umur</th>
        <th>Pembayaran</th>
        <th>Jam Masuk</th>
		<th>Diagnosa<br />Akhir Medis</th>
		<th>Jumlah Hari<br />Perawatan</th>
		<th>Type MH</th>
		<th>Terapi</th>
		<th>Keluar Karena</th>
    </tr>
<?php
$qry_ruang = '';
if(!empty($ruang_id)) $qry_ruang = 'AND t_irna_log.RUANG_ID_ASAL = "' . $ruang_id . '"';
$qry_keluar = 'SELECT IRNA_ID,NOMR,NAMA_PASIEN,JNS_KELAMIN,
					DATE_FORMAT(TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
					DATE_FORMAT(TANGGAL_MASUK,"%d/%m/%Y") AS TANGGAL_MASUK,
					DATE_FORMAT(TANGGAL_MASUK,"%d/%m/%Y %h:%i:%s") AS JAM_MASUK,
					DATE_FORMAT(TANGGAL_KELUAR,"%d/%m/%Y") AS TANGGAL_KELUAR,
					DATEDIFF(TANGGAL_KELUAR, TANGGAL_MASUK) AS JML_PERAWATAN,
					NAMA_JAMINAN,DIAGNOSA_AWAL,
					TYPE_MH,TERAPI,ALAMAT,t_log.NAMA_RUANG,
					KET_PASIEN_PULANG,m_ruang.NAMA_RUANG AS RUANG_TUJUAN
				FROM (SELECT t_irna.IRNA_ID,t_irna.NOMR,m_pasien.NAMA_PASIEN,m_pasien.JNS_KELAMIN,m_pasien.TGL_LAHIR,
						(SELECT t.TANGGAL_MASUK FROM t_irna_log t 
							WHERE t.IRNA_ID = t_irna_log.IRNA_ID
							AND t.RUANG_ID_BARU = t_irna_log.RUANG_ID_ASAL
							AND t.JNS_UPDATE = "R"
							AND t.IRNA_LOG_ID < t_irna_log.IRNA_LOG_ID
							ORDER BY t.TANGGAL_MASUK DESC LIMIT 1) AS TANGGAL_MASUK,
						CASE WHEN t_irna_log.RUANG_ID_BARU IS NULL THEN NULL
							ELSE (SELECT t.RUANG_ID_BARU FROM t_irna_log t 
							WHERE t.IRNA_ID = t_irna_log.IRNA_ID
							AND t.RUANG_ID_ASAL = t_irna_log.RUANG_ID_ASAL
							AND t.JNS_UPDATE = "R"
							AND t.IRNA_LOG_ID > t_irna_log.IRNA_LOG_ID
							ORDER BY t.TANGGAL_MASUK ASC LIMIT 1) END AS RUANG_ID_TUJUAN,	
						m_jaminan.NAMA_JAMINAN,t_irna.DIAGNOSA_AWAL,
						"" AS TYPE_MH,"" AS TERAPI,m_pasien.ALAMAT,
						CONCAT(m_ruang.NAMA_RUANG,"-",m_ruang.KELAS_RAWAT) AS NAMA_RUANG,
						t_irna_log.TANGGAL_KELUAR,
						CASE WHEN t_irna_log.RUANG_ID_BARU IS NULL THEN m_pasien_pulang.KET_PASIEN_PULANG
							ELSE "" END AS KET_PASIEN_PULANG
					FROM t_irna_log
					INNER JOIN t_irna ON (t_irna_log.IRNA_ID = t_irna.IRNA_ID)
					INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
					INNER JOIN m_ruang ON (t_irna_log.RUANG_ID_ASAL = m_ruang.RUANG_ID)
					LEFT JOIN m_jaminan ON (t_irna_log.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
					LEFT JOIN m_pasien_pulang ON (t_irna_log.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID)
					WHERE t_irna_log.JNS_UPDATE = "R"
					' . $qry_ruang . '
					AND STR_TO_DATE(DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%d%m%Y"),"%d%m%Y") = ' . $tgl_filter_1 . '
				) t_log
				LEFT JOIN m_ruang ON (t_log.RUANG_ID_TUJUAN = m_ruang.RUANG_ID)
				ORDER BY t_log.TANGGAL_MASUK';
$get_keluar = mysql_query($qry_keluar) or die(mysql_error());
$no = 1;
while($dat_keluar = mysql_fetch_array($get_keluar)){
	?>
	<tr>
		<td><?php echo $no; ?></td>
		<td><?php echo $dat_keluar['NAMA_RUANG']; ?></td>
        <td><?php echo formatNomr($dat_keluar['NOMR']); ?></td>
        <td><?php echo $dat_keluar['NAMA_PASIEN']; ?></td>
        <td><?php echo jenisKelamin($dat_keluar['JNS_KELAMIN']); ?></td>
		<td><?php echo getUmurDaftar($dat_keluar['TGL_LAHIR'],$dat_keluar['TANGGAL_MASUK']) . ' (' . $dat_keluar['TGL_LAHIR'] . ')'; ?></td>
        <td><?php echo $dat_keluar['NAMA_JAMINAN']; ?></td>
        <td><?php echo $dat_keluar['JAM_MASUK']; ?></td>
		<td><?php 
			$diagnosa = '';
			$sql_diag = 'SELECT t_irna_diagnosa_pulang.DIAGNOSA,t_irna_diagnosa_pulang.IRNA_DIAGNOSA_PULANG_ID,
					CASE WHEN TRIM(t_irna_diagnosa_pulang.DIAGNOSA) = TRIM(m_icd_x.DESKRIPSI) THEN t_irna_diagnosa_pulang.ICD_CODE
					ELSE CONCAT(t_irna_diagnosa_pulang.ICD_CODE,"--",m_icd_x.DESKRIPSI) END AS ICD
					FROM t_irna_diagnosa_pulang
					LEFT JOIN m_icd_x ON (t_irna_diagnosa_pulang.ICD_CODE = m_icd_x.ICD_CODE)
					WHERE t_irna_diagnosa_pulang.IRNA_ID = "' . $dat_keluar['IRNA_ID'] . '"
					ORDER BY t_irna_diagnosa_pulang.DIAGNOSA_ORDER';
			$get_diag = mysql_query($sql_diag) or die(mysql_error());
			while($dat_diag = mysql_fetch_array($get_diag)){
				 $diagnosa = $diagnosa . '-' . $dat_diag['DIAGNOSA'] . ' ' . $dat_diag['ICD'] . '<br />';
			}
			echo substr($diagnosa,0,strlen($diagnosa)-6);	
		?></td>
		<td align="right"><?php echo $dat_keluar['JML_PERAWATAN']; ?></td>
		<td><?php echo $dat_keluar['TYPE_MH']; ?></td>
		<td><?php echo $dat_keluar['TERAPI']; ?></td>
		<td><?php if($dat_keluar['RUANG_TUJUAN'] != ''){
						echo 'Pindah Ke ' . $dat_keluar['RUANG_TUJUAN']; 
					}else{
						echo $dat_keluar['KET_PASIEN_PULANG'];
				} ?></td>
	</tr>
	<?php
$no++; }	
?>	
	<tr>
		<td colspan="13">&nbsp;</td>
	</tr>
    <tr>
        <th>No</th>
		<th>Keluar Ruang Rawat</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
        <th>Jenis Kelamin</th>
		<th>Umur</th>
        <th>Pembayaran</th>
        <th>Jam Masuk</th>
		<th colspan="4">Alasan Dirujuk</th>
		<th>Tempat Rujukan</th>
    </tr>
<?php
$qry_ruang = '';
if(!empty($ruang_id)) $qry_ruang = 'AND t_irna_log.RUANG_ID_ASAL = "' . $ruang_id . '"';
$qry_rujuk = 'SELECT NOMR,NAMA_PASIEN,JNS_KELAMIN,
					DATE_FORMAT(TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
					DATE_FORMAT(TANGGAL_MASUK,"%d/%m/%Y") AS TANGGAL_MASUK,
					DATE_FORMAT(TANGGAL_MASUK,"%d/%m/%Y %h:%i:%s") AS JAM_MASUK,
					DATE_FORMAT(TANGGAL_KELUAR,"%d/%m/%Y") AS TANGGAL_KELUAR,
					DATEDIFF(TANGGAL_KELUAR, TANGGAL_MASUK) AS JML_PERAWATAN,
					NAMA_JAMINAN,DIAGNOSA_AWAL,
					TYPE_MH,TERAPI,ALAMAT,NAMA_RUANG,
					KET_PASIEN_PULANG,TEMPAT_RUJUKAN
				FROM (SELECT t_irna.NOMR,m_pasien.NAMA_PASIEN,m_pasien.JNS_KELAMIN,m_pasien.TGL_LAHIR,
						(SELECT t.TANGGAL_MASUK FROM t_irna_log t 
							WHERE t.IRNA_ID = t_irna_log.IRNA_ID
							AND t.RUANG_ID_BARU = t_irna_log.RUANG_ID_ASAL
							AND t.JNS_UPDATE = "R"
							AND t.IRNA_LOG_ID < t_irna_log.IRNA_LOG_ID
							ORDER BY t.TANGGAL_MASUK DESC LIMIT 1) AS TANGGAL_MASUK,
						m_jaminan.NAMA_JAMINAN,t_irna.DIAGNOSA_AWAL,
						"" AS TYPE_MH,"" AS TERAPI,m_pasien.ALAMAT,
						CONCAT(m_ruang.NAMA_RUANG,"-",m_ruang.KELAS_RAWAT) AS NAMA_RUANG,
						t_irna_log.TANGGAL_KELUAR,t_irna.KET_PASIEN_PULANG,t_irna.TEMPAT_RUJUKAN
					FROM t_irna_log
					INNER JOIN t_irna ON (t_irna_log.IRNA_ID = t_irna.IRNA_ID)
					INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
					INNER JOIN m_ruang ON (t_irna_log.RUANG_ID_ASAL = m_ruang.RUANG_ID)
					LEFT JOIN m_jaminan ON (t_irna_log.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
					WHERE t_irna_log.JNS_UPDATE = "R"
					' . $qry_ruang . '
					AND STR_TO_DATE(DATE_FORMAT(t_irna_log.TANGGAL_KELUAR,"%d%m%Y"),"%d%m%Y") = ' . $tgl_filter_1 . '
					AND t_irna_log.PASIEN_PULANG_ID = 6
				) t_log
				ORDER BY t_log.TANGGAL_MASUK';
$get_rujuk = mysql_query($qry_rujuk) or die(mysql_error());
$no = 1;
while($dat_rujuk = mysql_fetch_array($get_rujuk)){
	?>
	<tr>
		<td><?php echo $no; ?></td>
		<td><?php echo $dat_rujuk['NAMA_RUANG']; ?></td>
        <td><?php echo formatNomr($dat_rujuk['NOMR']); ?></td>
        <td><?php echo $dat_rujuk['NAMA_PASIEN']; ?></td>
        <td><?php echo jenisKelamin($dat_rujuk['JNS_KELAMIN']); ?></td>
		<td><?php echo getUmurDaftar($dat_rujuk['TGL_LAHIR'],$dat_rujuk['TANGGAL_MASUK']) . ' (' . $dat_rujuk['TGL_LAHIR'] . ')'; ?></td>
        <td><?php echo $dat_rujuk['NAMA_JAMINAN']; ?></td>
        <td><?php echo $dat_rujuk['JAM_MASUK']; ?></td>
		<td colspan="4"><?php echo $dat_rujuk['KET_PASIEN_PULANG']; ?></td>
		<td><?php echo $dat_rujuk['TEMPAT_RUJUKAN']; ?></td>
	</tr>
	<?php
$no++; }	
?>	
</table>
<form id="xls_export" name="xls_export" method="post">
    <input type="hidden" name="page_to_excel" value="1" />
    <input type="hidden" name="tgl_1" value="<?php echo $tgl_1; ?>" />
    <input type="hidden" name="ruang_id" value="<?php echo $ruang_id; ?>" />
    <input type="hidden" name="xlsfile" value="rawatinap/xls_report_pasien_masuk_keluar.php" />
    <input type="hidden" name="xlsname" value="rpt_pasien_masuk_keluar.xls" />            
</form>