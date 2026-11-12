<?php
include('./config/config.php');
include('./shared/connect_db.php');
include('./shared/function.php');
include('./shared/enum_function.php');
?>
<table border="1">
	<tr>
        <th colspan="4">Master Tarif</th>
   </tr>
   <tr>
		<th>No</th>
        <th>Kode</th>
        <th>Nama Tarif</th>
		<th>Group</th>
		<th>Non_Kelas</th>
		<th>Kelas_3</th>
		<th>Kelas_2</th>
		<th>Kelas_1</th>
		<th>Kelas_Utama<br />(VIP)</th>
		<th>Kelas_Utama_2<br />(VVIP)</th>
		<th>HCU</th>
		<th>ICU</th>
		<th>NICU</th>
		<th>PICU</th>
		<th>ICCU</th>
		<th>Perina</th>
		<th>Perina_Sehat</th>
		<th>Perina_Sakit</th>
  </tr>
<?php 
$qry = 'SELECT m_tarif.*,m_tarif_group.NAMA_TARIF_GROUP
		FROM m_tarif 
		LEFT JOIN m_tarif_group ON (m_tarif_group.KODE_TARIF_GROUP = m_tarif.KODE_TARIF_GROUP)
		WHERE m_tarif.ST_AKTIF = "1" 
		ORDER BY m_tarif_group.NAMA_TARIF_GROUP,m_tarif.NAMA_TARIF';	
							
$no = 1;					
$get = mysql_query($qry) or die(mysql_error());
while($dat = mysql_fetch_array($get)){ ?>
	<tr>
	<td align="center"><?php echo $no; ?></td>
	<td align="center"><?php echo $dat['KODE_TARIF']; ?></td>
	<td><?php echo $dat['NAMA_TARIF']; ?></td>
	<td><?php echo $dat['NAMA_TARIF_GROUP']; ?></td>
	<td align="right"><?php echo currFormat($dat['TARIF_NON_KELAS']); ?></td>
	<td align="right"><?php echo currFormat($dat['TARIF_KELAS_3']); ?></td>
	<td align="right"><?php echo currFormat($dat['TARIF_KELAS_2']); ?></td>
	<td align="right"><?php echo currFormat($dat['TARIF_KELAS_1']); ?></td>
	<td align="right"><?php echo currFormat($dat['TARIF_KELAS_UTAMA']); ?></td>
	<td align="right"><?php echo currFormat($dat['TARIF_KELAS_UTAMA_2']); ?></td>
	<td align="right"><?php echo currFormat($dat['TARIF_HCU']); ?></td>
	<td align="right"><?php echo currFormat($dat['TARIF_ICU']); ?></td>
	<td align="right"><?php echo currFormat($dat['TARIF_NICU']); ?></td>
	<td align="right"><?php echo currFormat($dat['TARIF_PICU']); ?></td>
	<td align="right"><?php echo currFormat($dat['TARIF_ICCU']); ?></td>
	<td align="right"><?php echo currFormat($dat['TARIF_PERINA']); ?></td>
	<td align="right"><?php echo currFormat($dat['TARIF_KELAS_PERINA_SEHAT']); ?></td>
	<td align="right"><?php echo currFormat($dat['TARIF_KELAS_PERINA_SAKIT']); ?></td>
	</tr>
<?php	
	$no++;
}