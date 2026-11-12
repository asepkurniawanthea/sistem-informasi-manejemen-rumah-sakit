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

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}	

$qry_kunjungan = 'SELECT UNIT_ID,NAMA_UNIT,NAMA_UNIT_PENGIRIM,NAMA_PEGAWAI,DPJP, ';
$qry_jaminan = 'SELECT JAMINAN_ID, NAMA_JAMINAN FROM m_jaminan ORDER BY PENDAFTARAN DESC, URUT ASC';
$get_jaminan = mysql_query($qry_jaminan) or die(mysql_error());
$i = 1;
while($dat_jaminan = mysql_fetch_array($get_jaminan)){
	$qry_kunjungan = $qry_kunjungan . ' SUM(FIELD' . $i . ') AS FIELD' . $i . ',';
$i++;	
}

$qry_kunjungan = $qry_kunjungan . 'SUM(TOTAL) AS TOTAL FROM (SELECT m_unit.UNIT_ID,m_unit.NAMA_UNIT,
CASE WHEN t_ipenunjang.JNS_ORDER = "IRJ" THEN m_unit2.NAMA_UNIT
	WHEN t_ipenunjang.JNS_ORDER = "IRN" THEN m_ruang.NAMA_RUANG
	ELSE "APS" END AS NAMA_UNIT_PENGIRIM, 
	m_pegawai.NAMA_PEGAWAI,m_pegawai2.NAMA_PEGAWAI AS DPJP,';

$qry_jaminan = 'SELECT JAMINAN_ID, NAMA_JAMINAN FROM m_jaminan ORDER BY PENDAFTARAN DESC, URUT ASC';
$get_jaminan = mysql_query($qry_jaminan) or die(mysql_error());
$i = 1;
$j = 1;
$field_name = array();
while($dat_jaminan = mysql_fetch_array($get_jaminan)){
	$qry_kunjungan = $qry_kunjungan . ' COUNT(DISTINCT CASE WHEN t_ipenunjang_tarif.JENIS_BAYAR_ID = "' . $dat_jaminan['JAMINAN_ID'] . '" 
										THEN t_ipenunjang_tarif.NO_SJP END) AS FIELD' . $i . ',';
	$field_name[$i] = $dat_jaminan['NAMA_JAMINAN']; 									
$i++; $j++;	
}
	$qry_kunjungan = $qry_kunjungan . 'COUNT(DISTINCT CASE WHEN t_ipenunjang_tarif.JENIS_BAYAR_ID IS NOT NULL THEN t_ipenunjang_tarif.NO_SJP END) AS TOTAL
				FROM m_unit
				LEFT JOIN t_ipenunjang_tarif ON (m_unit.UNIT_ID = t_ipenunjang_tarif.UNIT_PENUNJANG_ID
				AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . ' 
				AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL AND t_ipenunjang_tarif.ST_BATAL IS NULL)
				LEFT JOIN t_ipenunjang ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
				LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				LEFT JOIN m_unit m_unit2 ON (t_ipenunjang.UNIT_ID = m_unit2.UNIT_ID AND t_ipenunjang.JNS_ORDER = "IRJ")	
				LEFT JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID AND t_ipenunjang.JNS_ORDER = "IRN")	
				LEFT JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = m_pegawai2.PEGAWAI_ID)
				WHERE m_unit.PENUNJANG = "pnj"
				GROUP BY m_unit.UNIT_ID,m_unit.NAMA_UNIT,NAMA_UNIT_PENGIRIM,m_pegawai.NAMA_PEGAWAI,DPJP) t_tran
				GROUP BY UNIT_ID,NAMA_UNIT,NAMA_UNIT_PENGIRIM,NAMA_PEGAWAI,DPJP';	
			
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());	
?>
<table border="1" >
<tr>
	<th colspan="<?php echo $i + 5; ?>" >Report Kunjungan Penunjang Dr <?php echo $tgl_1; ?> Sd <?php echo $tgl_2; ?></th>
</tr>
  <tr>
    <th rowspan="2" width="5">No</th>
    <th rowspan="2">Penunjang</th>
	<th rowspan="2">Asal Pasien</th>
	<th rowspan="2">Dokter Pengirim</th>
	<th rowspan="2">Dokter Penanggungjawab</th>
    <th colspan="<?php echo $i-1; ?>">Jenis Pembayaran</th><th rowspan="2">Total</th>
  </tr>
  <tr>
    <?php
	$x = 1;
	while($x < $j){
		echo '<th>' . $field_name[$x] . '</th>';
	$x++;
	}
	?>
  </tr>
 <?php $no = 1; 
 $total = 0;
while($dat_kunjungan = mysql_fetch_array($get_kunjungan)){ ?>  
  <tr>
    <td scope="row" align="center"><?php echo $no; ?></td>
    <td><?php echo $dat_kunjungan['NAMA_UNIT']; ?></td>
	<td><?php echo $dat_kunjungan['NAMA_UNIT_PENGIRIM']; ?></td>
	<td><?php echo $dat_kunjungan['NAMA_PEGAWAI']; ?></td>
	<td><?php echo $dat_kunjungan['DPJP']; ?></td>
    <?php
	$x = 1;
	while($x < $j){
		echo '<td align="right">' . currFormat($dat_kunjungan['FIELD'. $x]) . '</td>';
	$x++;
	}
	?>
    <td align="right"><?php echo currFormat($dat_kunjungan['TOTAL']); 
	$total = $total + $dat_kunjungan['TOTAL']; ?></td>
  </tr>
 <?php $no++; } ?> 
   <tr>
	<td colspan="<?php echo $x + 4; ?>" align="right">Total :&nbsp;&nbsp;</td>
	<td align="right"><?php echo currFormat($total); ?></td>
  </tr> 
</table>