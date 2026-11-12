<style>
html {
	background:url(image/bg_pattern1.jpg);

}
</style>
<?php 
$idp = $_GET['idp'];
$nomr = $_GET['nomr'];
?>
    <table class="tableData" id="tfhover" >
        <tr>
			<th>Pemeriksaan</th>
			<th>Tanggal</th>
			<th>Hasil</th>
			<th>Satuan</th>
			<th>Rujukan</th>
			<th>Methode</th>
		</tr>        
<?php
$sql_periksa = 'SELECT DISTINCT m_tarif_pemeriksaan.CH_REPORT,
				m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_GROUP,
				m_tarif_pemeriksaan.NAMA_PEMERIKSAAN
				FROM m_tarif_pemeriksaan
				WHERE m_tarif_pemeriksaan.KODE_TARIF = "' . $idp . '"
				ORDER BY m_tarif_pemeriksaan.CH_REPORT,
				m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_GROUP,
				m_tarif_pemeriksaan.NAMA_PEMERIKSAAN';
$get_periksa = mysql_query($sql_periksa) or die(mysql_error());
while($dat_periksa = mysql_fetch_array($get_periksa)){				

	$sql_riwayat = 'SELECT t_ipenunjang_tarif.TANGGAL_PERIKSA,
		t_ipenunjang_tarif_pemeriksaan.HASIL_DIAGNOSA,
		t_ipenunjang_tarif_pemeriksaan.NILAI_RUJUKAN,
		t_ipenunjang_tarif_pemeriksaan.SATUAN,
		t_ipenunjang_tarif_pemeriksaan.METHODE
		FROM t_ipenunjang
		INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
		INNER JOIN t_ipenunjang_tarif_pemeriksaan ON (t_ipenunjang_tarif.PENUNJANG_TARIF_ID = t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_ID)
		INNER JOIN m_tarif_pemeriksaan ON (t_ipenunjang_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID = m_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID)
		WHERE t_ipenunjang.NOMR = "' . $nomr . '"
		AND m_tarif_pemeriksaan.CH_REPORT = "' . $dat_periksa['CH_REPORT'] . '"
		AND m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_GROUP = "' . $dat_periksa['NAMA_PEMERIKSAAN_GROUP'] . '"
		AND m_tarif_pemeriksaan.NAMA_PEMERIKSAAN = "' . $dat_periksa['NAMA_PEMERIKSAAN'] . '"
		ORDER BY t_ipenunjang_tarif.TANGGAL_PERIKSA';
	$get_riwayat = mysql_query($sql_riwayat) or die(mysql_error());
	while($dat_riwayat = mysql_fetch_array($get_riwayat)){
		$rujukan = $dat_riwayat['NILAI_RUJUKAN'];
		$rujukan_array = explode('|',$dat_riwayat['NILAI_RUJUKAN']);
		if(count($rujukan_array) > 1) $rujukan = $rujukan_array[1]; 
?>
		<tr>
		<td><?php $pemeriksaan = $dat_periksa['CH_REPORT'];
			if($dat_periksa['NAMA_PEMERIKSAAN_GROUP'] != '') $pemeriksaan .= '-' . $dat_periksa['NAMA_PEMERIKSAAN_GROUP'];
			if($dat_periksa['NAMA_PEMERIKSAAN'] != '') $pemeriksaan .= '-' . $dat_periksa['NAMA_PEMERIKSAAN'];
			echo $pemeriksaan; ?></td>
		<td><?php echo $dat_riwayat['TANGGAL_PERIKSA']; ?></td>
		<td><?php echo $dat_riwayat['HASIL_DIAGNOSA']; ?></td>
		<td><?php echo $dat_riwayat['SATUAN']; ?></td>
		<td><?php echo $rujukan; ?></td>
		<td><?php echo $dat_riwayat['METHODE']; ?></td>
		</tr>
<?php
	}  
}
?>		
    </table>