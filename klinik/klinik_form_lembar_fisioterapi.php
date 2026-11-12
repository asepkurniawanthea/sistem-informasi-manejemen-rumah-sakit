<style>
html {
	background:url(image/bg_pattern1.jpg);

}
</style>
<?php 
$sql_perkembangan = 'SELECT DATE_FORMAT(TANGGAL,"%d-%m-%Y") AS TANGGAL,
				NOMR,PEMERIKSAAN_DAN_EVALUASI,TERAPI,TK_CACAT,NAMA_PEGAWAI
			FROM t_pemeriksaan_fisioterapi
			LEFT JOIN m_pegawai ON (t_pemeriksaan_fisioterapi.FISIOTERAPIST = m_pegawai.PEGAWAI_ID)
			WHERE NOMR = "' . $nomr . '"';
$get_perkembangan = mysql_query($sql_perkembangan) or die(mysql_error());
?>
<table class="tableData" id="tfhover" >
<tr>
	<th>Tanggal</th>
	<th>Pemeriksaan dan Evaluasi</th>
	<th>Terapi</th>
	<th>Tk. Cacat</th>
	<th>Fisioterapist</th>
</tr>
<?php while($dat_perkembangan = mysql_fetch_array($get_perkembangan)){ ?>
	<tr>
		<td><?php echo $dat_perkembangan['TANGGAL']; ?></td>
		<td><?php echo $dat_perkembangan['PEMERIKSAAN_DAN_EVALUASI']; ?></td>
		<td><?php echo $dat_perkembangan['TERAPI']; ?></td>
		<td><?php echo $dat_perkembangan['TK_CACAT']; ?></td>
		<td><?php echo $dat_perkembangan['NAMA_PEGAWAI']; ?></td>
	</tr>
<?php } ?>
</table>