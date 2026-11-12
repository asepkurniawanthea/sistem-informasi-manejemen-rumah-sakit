<style>
html {
	background:url(image/bg_pattern1.jpg);

}
</style>
<?php 
$irja_id = $_GET['idx'];

$sql_perkembangan = 'SELECT t_irja_perkembangan.IRJA_PERKEMBANGAN_ID,t_irja_perkembangan.TANGGAL,
					t_irja_perkembangan.PEMBERI_ASUHAN,t_irja_perkembangan.HASIL_ASESMEN,t_irja_perkembangan.INTRUKSI_PPA,
					t_irja_perkembangan.VERIFIKASI_DPJP,m_pegawai.NAMA_PEGAWAI
					FROM t_irja_perkembangan
					LEFT JOIN m_pegawai 
					ON (t_irja_perkembangan.PEMBERI_ASUHAN = m_pegawai.PEGAWAI_ID)
					WHERE t_irja_perkembangan.IRJA_ID = "' . $irja_id . '"';
$get_perkembangan = mysql_query($sql_perkembangan) or die(mysql_error());
?>
<table class="tableData" id="tfhover" >
<tr>
	<th>Tanggal<br />& Pukul</th>
	<th>Profesional<br />Pemberi Asuhan</th>
	<th>Hasil Asesmen-IAR<br />Penatalaksana Pasien (SOAP/ ADIME)</th>
	<th>Intruksi PPA<br />(Termasuk Pasca Bedah)</th>
	<th>Verifikasi DPJP</th>
</tr>
<?php while($dat_perkembangan = mysql_fetch_array($get_perkembangan)){ ?>
	<tr>
		<td><?php echo $dat_perkembangan['TANGGAL']; ?></td>
		<td><?php echo $dat_perkembangan['NAMA_PEGAWAI']; ?></td>
		<td><?php echo $dat_perkembangan['HASIL_ASESMEN']; ?></td>
		<td><?php echo $dat_perkembangan['INTRUKSI_PPA']; ?></td>
		<td><?php echo $dat_perkembangan['VERIFIKASI_DPJP']; ?></td>
	</tr>
<?php } ?>
</table>