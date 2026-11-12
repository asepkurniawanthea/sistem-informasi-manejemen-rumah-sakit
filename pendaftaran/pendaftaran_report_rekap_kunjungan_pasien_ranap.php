<?php
$tgl_1 = '';
if (isset($_SESSION['pendaftaranreportrekapranap_tgl_1']))
    $tgl_1 = $_SESSION['pendaftaranreportrekapranap_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['pendaftaranreportrekapranap_tgl_1']))
    $tgl_2 = $_SESSION['pendaftaranreportrekapranap_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['pendaftaranreportrekapranap_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['pendaftaranreportrekapranap_tgl_2'] = $_GET['tgl_2'];
}

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}	
?>
<form name="search" method="get" action="index.php">
    <table class="tableform" border="0" >
        <tr>
            <td>Tanggal</td>
            <td><input type="text" name="tgl_1" id="tgl_1" value="<?php echo $tgl_1; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
       </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/>
            </td>	
			<td>&nbsp;</td>
            <td align="right"><input type="submit" value="cari" class="myButton" />&nbsp;
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_kunjungan = 'SELECT m_ruang.RUANG_ID,m_ruang.NAMA_RUANG,m_ruang.KELAS_RAWAT,m_pegawai.NAMA_PEGAWAI,
				COUNT(CASE WHEN m_pasien.JNS_KELAMIN = "L" THEN t_irna.IRNA_ID END) AS JNS_KEL_LK,
				COUNT(CASE WHEN m_pasien.JNS_KELAMIN = "P" THEN t_irna.IRNA_ID END) AS JNS_KEL_PR,
				COUNT(CASE WHEN t_irja.UNIT_ID = "9" THEN t_irna.IRNA_ID END) AS ASAL_PASIEN_IGD,
				COUNT(CASE WHEN t_irja.UNIT_ID <> "9" AND t_irja.UNIT_ID <> "35"  THEN t_irna.IRNA_ID END) AS ASAL_PASIEN_PK,
				COUNT(CASE WHEN t_irja.UNIT_ID = "35" THEN t_irna.IRNA_ID END) AS ASAL_PASIEN_KS,
				COUNT(t_irna.IRNA_ID) AS TOTAL
				FROM m_ruang
				LEFT JOIN t_irna ON (m_ruang.RUANG_ID = t_irna.RUANG_ID
				AND t_irna.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND t_irna.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
				AND t_irna.NO_PENDAFTARAN IS NOT NULL AND t_irna.ST_BATAL IS NULL)
				LEFT JOIN t_irja ON (t_irna.IRNA_ID = t_irja.IRJA_ID)
				LEFT JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				LEFT JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)				
				WHERE m_ruang.ST_AKTIF = "1"
				GROUP BY m_ruang.RUANG_ID,m_pegawai.NAMA_PEGAWAI 
				ORDER BY m_ruang.NAMA_RUANG';
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());	
?>
<table width="100%" border="1" class="tableData" id="tfhover">
  <tr>
     <th rowspan="2" width="5">No</th>
    <th rowspan="2">Ruang Rawat</th>
	<th rowspan="2">Dokter Penanggungjawab</th>
    <th colspan="2" scope="col">Jenis Kelamin</th>
    <th colspan="3" scope="col">Asal Pasien</th>
    <th rowspan="2" scope="col">Total</th>
  </tr>
  <tr>
    <th >Laki-laki</th>
    <th >Perempuan</th>
    <th>IGD</th>
    <th>Poliklinik</th>
    <th>Kusta</th>
	</tr>
<?php $no = 1; 
$total = 0;
while($dat_kunjungan = mysql_fetch_array($get_kunjungan)){ ?>  
  <tr>
    <td scope="row" align="center"><?php echo $no; ?></td>
    <td><?php echo $dat_kunjungan['NAMA_RUANG'] . ' ' . $dat_kunjungan['KELAS_RAWAT']; ?></td>
	<td><?php echo $dat_kunjungan['NAMA_PEGAWAI']; ?></td>
    <td align="right"><?php echo currFormat($dat_kunjungan['JNS_KEL_LK']); ?></td>
    <td align="right"><?php echo currFormat($dat_kunjungan['JNS_KEL_PR']); ?></td>
    <td align="right"><?php echo currFormat($dat_kunjungan['ASAL_PASIEN_IGD']); ?></td>
    <td align="right"><?php echo currFormat($dat_kunjungan['ASAL_PASIEN_PK']); ?></td>
    <td align="right"><?php echo currFormat($dat_kunjungan['ASAL_PASIEN_KS']); ?></td>
    <td align="right"><?php echo currFormat($dat_kunjungan['TOTAL']); 
	$total = $total + $dat_kunjungan['TOTAL']; ?></td>
  </tr>
 <?php $no++; } ?>
<tr>
	<td colspan="8" align="right">Total :&nbsp;&nbsp;</td>
	<td align="right"><?php echo currFormat($total); ?></td>
  </tr> 
</table>
<form id="xls_export" name="xls_export" method="post">
            <input type="hidden" name="page_to_excel" value="1" />
            <input type="hidden" name="tgl_1" value="<?php echo $tgl_1; ?>" />
            <input type="hidden" name="tgl_2" value="<?php echo $tgl_2; ?>" />
            <input type="hidden" name="xlsfile" value="pendaftaran/xls_rekap_pasien_ranap.php" />
            <input type="hidden" name="xlsname" value="rpt_pasien_ranap.xls" />            
        </form>
