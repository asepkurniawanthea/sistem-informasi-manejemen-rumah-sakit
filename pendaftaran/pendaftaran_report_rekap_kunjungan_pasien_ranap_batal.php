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
            <td align="right"><input type="submit" value="cari" class="myButton" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_ranap = 'SELECT DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_irna.NOMR,m_pasien.NAMA_PASIEN,CONCAT(m_ruang.NAMA_RUANG," ",m_ruang.KELAS_RAWAT) AS NAMA_RUANG,
				m_jaminan.NAMA_JAMINAN,t_irna.USER_PENDAFTARAN,t_irna.KETERANGAN_BATAL
				FROM t_irna
				INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_irna.ST_BATAL = "1" 
				AND t_irna.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' 
				AND t_irna.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
				ORDER BY m_pasien.NAMA_PASIEN';			
$get_ranap = mysql_query($qry_ranap) or die(mysql_error());	
?>
<table width="100%" border="1" class="tableData" id="tfhover">
<tr>
    <th>No</th>
    <th>Tanggal</th>
	<th>Nomr</th>
	<th>Nama Pasien</th>
	<th>Ruang</th>
	<th>Pembayaran</th>
	<th>Keterangan Batal</th>
	<th>Regiter</th>
</tr>
<?php $no = 1; 
$total = 0;
while($dat_ranap = mysql_fetch_array($get_ranap)){ ?>  
  <tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $dat_ranap['TANGGAL_DAFTAR']; ?></td>
	<td><?php echo formatNomr($dat_ranap['NOMR']); ?></td>
	<td><?php echo $dat_ranap['NAMA_PASIEN']; ?></td>
	<td><?php echo $dat_ranap['NAMA_RUANG']; ?></td>
	<td><?php echo $dat_ranap['NAMA_JAMINAN']; ?></td>
	<td><?php echo $dat_ranap['KETERANGAN_BATAL']; ?></td>
	<td><?php echo $dat_ranap['USER_PENDAFTARAN']; ?></td>
  </tr>
 <?php $no++; } ?> 
</table>

