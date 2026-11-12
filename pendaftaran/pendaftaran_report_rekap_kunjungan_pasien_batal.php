<?php
$tgl_1 = '';
if (isset($_SESSION['pendaftaranreportrekapkunjungan_tgl_1']))
    $tgl_1 = $_SESSION['pendaftaranreportrekapkunjungan_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['pendaftaranreportrekapkunjungan_tgl_1']))
    $tgl_2 = $_SESSION['pendaftaranreportrekapkunjungan_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['pendaftaranreportrekapkunjungan_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['pendaftaranreportrekapkunjungan_tgl_2'] = $_GET['tgl_2'];
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
$qry_kunjungan = 'SELECT DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_irja.NOMR,m_pasien.NAMA_PASIEN,m_unit.NAMA_UNIT,m_jaminan.NAMA_JAMINAN,
				t_irja.USER_PENDAFTARAN,t_irja.KETERANGAN_BATAL
				FROM t_irja
				INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_irja.ST_BATAL = "1" 
				AND t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' 
				AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
				ORDER BY m_pasien.NAMA_PASIEN';			
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());	
?>
<table width="100%" border="1" class="tableData" id="tfhover">
<tr>
    <th>No</th>
    <th>Tanggal</th>
	<th>Nomr</th>
	<th>Nama Pasien</th>
	<th>Poliklinik</th>
	<th>Pembayaran</th>
	<th>Keterangan Batal</th>
	<th>Regiter</th>
</tr>
<?php $no = 1; 
$total = 0;
while($dat_kunjungan = mysql_fetch_array($get_kunjungan)){ ?>  
  <tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $dat_kunjungan['TANGGAL_DAFTAR']; ?></td>
	<td><?php echo formatNomr($dat_kunjungan['NOMR']); ?></td>
	<td><?php echo $dat_kunjungan['NAMA_PASIEN']; ?></td>
	<td><?php echo $dat_kunjungan['NAMA_UNIT']; ?></td>
	<td><?php echo $dat_kunjungan['NAMA_JAMINAN']; ?></td>
	<td><?php echo $dat_kunjungan['KETERANGAN_BATAL']; ?></td>
	<td><?php echo $dat_kunjungan['USER_PENDAFTARAN']; ?></td>
  </tr>
 <?php $no++; } ?> 
</table>

