<style>
html {
	background:url(image/bg_pattern1.jpg);

}
</style>
<?php 
$nomr = $_GET['nomr'];
$rpt = $_GET['rpt'];
$grp = $_GET['grp'];
$pmr = $_GET['pmr'];
$pemeriksaan = $_GET['rpt'];
if($grp != '') $pemeriksaan .= '-' . $grp;
if($pmr != '') $pemeriksaan .= '-' . $pmr;
?>
	Pemeriksaan : <?php echo $pemeriksaan; ?> 
	<br>
    <table class="tableData" id="tfhover" >
        <tr>
			<th>Tanggal</th>
			<th>Hasil</th>
			<th>Satuan</th>
			<th>Rujukan</th>
			<th>Methode</th>
		</tr>        
<?php
$sql_riwayat = 'SELECT t_ipenunjang_tarif.TANGGAL_PERIKSA,
  t_ipenunjang_tarif_pemeriksaan.HASIL_DIAGNOSA,
  t_ipenunjang_tarif_pemeriksaan.NILAI_RUJUKAN,
  t_ipenunjang_tarif_pemeriksaan.SATUAN,
  t_ipenunjang_tarif_pemeriksaan.METHODE
FROM
  t_ipenunjang
  INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
  INNER JOIN t_ipenunjang_tarif_pemeriksaan ON (t_ipenunjang_tarif.PENUNJANG_TARIF_ID = t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_ID)
  INNER JOIN m_tarif_pemeriksaan ON (t_ipenunjang_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID = m_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID)
  WHERE t_ipenunjang.NOMR = "' . $nomr . '"
  AND m_tarif_pemeriksaan.CH_REPORT = "' . $rpt . '"
  AND m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_GROUP = "' . $grp . '"
  AND m_tarif_pemeriksaan.NAMA_PEMERIKSAAN = "' . $pmr . '"
  ORDER BY t_ipenunjang_tarif.TANGGAL_PERIKSA';
$get_riwayat = mysql_query($sql_riwayat) or die(mysql_error());
while($dat_riwayat = mysql_fetch_array($get_riwayat)){
$rujukan = $dat_riwayat['NILAI_RUJUKAN'];
$rujukan_array = explode('|',$dat_riwayat['NILAI_RUJUKAN']);
if(count($rujukan_array) > 1) $rujukan = $rujukan_array[1]; 
?>
	<tr>
		<td><?php echo $dat_riwayat['TANGGAL_PERIKSA']; ?></td>
		<td><?php echo $dat_riwayat['HASIL_DIAGNOSA']; ?></td>
		<td><?php echo $dat_riwayat['SATUAN']; ?></td>
		<td><?php echo $rujukan; ?></td>
		<td><?php echo $dat_riwayat['METHODE']; ?></td>
	</tr>
<?php
}  
?>		
    </table>