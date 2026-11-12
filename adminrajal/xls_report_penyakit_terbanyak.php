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

$unit_id = '';
if (isset($_POST['unit_id']))
    $unit_id = $_POST['unit_id'];

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}	

$qry_kunjungan = 'SELECT * FROM (
		SELECT m_unit.UNIT_ID,m_unit.NAMA_UNIT,
		m_icd_x.ICD_CODE,m_icd_x.DESKRIPSI,
		CASE WHEN t_irja_diagnosa.KASUS_BARU = "1" THEN "Baru" END AS KASUS_BARU,
		COUNT(DISTINCT t_irja.IRJA_ID) AS JML_PASIEN
		FROM m_unit
		INNER JOIN t_irja ON (m_unit.UNIT_ID = t_irja.UNIT_ID)
		INNER JOIN t_irja_diagnosa ON (t_irja.IRJA_ID = t_irja_diagnosa.IRJA_ID)
		INNER JOIN m_icd_x ON (t_irja_diagnosa.ICD_CODE = m_icd_x.ICD_CODE)
		WHERE m_unit.IRJA IN ("umum","kusta","mcu","igd") 
		AND t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . '
		AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
		AND t_irja.NO_PENDAFTARAN IS NOT NULL 
		AND t_irja.ST_BATAL IS NULL
		AND t_irja_diagnosa.DIAGNOSA_ORDER < 4
		' . (($unit_id != '') ? ' AND t_irja.UNIT_ID = "' . $unit_id . '"' : '') . '
		GROUP BY m_unit.UNIT_ID,m_unit.NAMA_UNIT,
		m_icd_x.ICD_CODE,m_icd_x.DESKRIPSI,
		KASUS_BARU
		) t_diag
		ORDER BY JML_PASIEN DESC';
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());	
?>
<table width="100%" border="1" >
	<tr>
		<th colspan="5">Laporan Penyakit Terbanyak Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>	
  <tr>
         <th>No</th>
        <th>ICD Code</th>
        <th>Diagnosa Penyakit</th>
        <th>Jumlah</th>
        <th>Kasus Baru</th>
    </tr>
 <?php $no = 1;
	$rs = mysql_query($qry_kunjungan) or die(mysql_error());
    while ($data = mysql_fetch_array($rs)) { ?>  
  <tr>
    <td align="center"><?php echo $no; ?></td>
	 <td><?php echo $data['ICD_CODE']; ?></td>
	 <td><?php echo $data['DESKRIPSI']; ?></td>
	 <td align="right"><?php echo $data['JML_PASIEN']; ?></td>
	 <td><?php echo $data['KASUS_BARU']; ?></td>
        </tr>
 <?php $no++; } ?> 
</table>