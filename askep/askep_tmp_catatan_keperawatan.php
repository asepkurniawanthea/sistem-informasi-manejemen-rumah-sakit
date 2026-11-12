<?php
$qry_catatan = 'SELECT DISTINCT IRNA_ID,
						DATE_FORMAT(TANGGAL,"%d/%m/%Y") AS TANGGAL
						FROM t_irna_askep_catatan_keperawatan
						LEFT JOIN m_pegawai ON (t_irna_askep_catatan_keperawatan.PERAWAT = m_pegawai.PEGAWAI_ID)
						WHERE IRNA_ID = "' . $irna_id . '"
						ORDER BY TANGGAL';
$get_catatan = mysql_query($qry_catatan) or die(mysql_error());
?>
<tr>
	<th width="40">No</th>
    <th width="70">Tanggal</th>
	<th width="50">Pukul</th>
	<th>Implementasi dan Evaluasi Keperawatan (SOAP)</th>
	<th width="130">Petugas</th>
	<th width="100">Option</th>
</tr>
<?php
$i = 1;
while ($dat_catatan = mysql_fetch_array($get_catatan)) {
    ?>
    <tr>
        <td align="center"><?php echo $i; ?></td>
        <td align="center"><?php echo $dat_catatan['TANGGAL']; ?></td>
		<td align="center">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
    </tr>
<?php   
		$qry_catatan_detail = 'SELECT CATATAN_KEPERAWATAN_ID,IRNA_ID,
						DATE_FORMAT(TANGGAL,"%d/%m/%Y") AS TANGGAL,
						DATE_FORMAT(TANGGAL,"%H:%i") AS JAM,
						SOAP,PERAWAT,USER_ASKEP,NAMA_PEGAWAI
						FROM t_irna_askep_catatan_keperawatan
						LEFT JOIN m_pegawai ON (t_irna_askep_catatan_keperawatan.PERAWAT = m_pegawai.PEGAWAI_ID)
						WHERE IRNA_ID = "' . $irna_id . '"
						AND DATE_FORMAT(TANGGAL,"%d/%m/%Y") = "' . $dat_catatan['TANGGAL'] . '"
						ORDER BY DATE_FORMAT(TANGGAL,"%H:%i")';
		$get_catatan_detail = mysql_query($qry_catatan_detail) or die(mysql_error());				
		$j = 1;
		while ($dat_catatan_detail = mysql_fetch_array($get_catatan_detail)) { ?>
		<tr>
        <td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
		<td align="center"><?php echo $dat_catatan_detail['JAM']; ?></td>
		<td><?php echo $dat_catatan_detail['SOAP']; ?></td>
		<td><?php echo $dat_catatan_detail['NAMA_PEGAWAI']; ?></td>
		<td>
		<?php if($irna_final == ''){ ?>
		<a href="<?php echo currentUrl(); ?>&idce=<?php echo $dat_catatan_detail['CATATAN_KEPERAWATAN_ID']; ?>&nmce=<?php echo $dat_catatan_detail['TANGGAL'] . ' ' . $dat_catatan_detail['JAM']; ?>" >ubah</a>
		<a href="<?php echo currentUrl(); ?>&idc=<?php echo $dat_catatan_detail['CATATAN_KEPERAWATAN_ID']; ?>&nmc=<?php echo $dat_catatan_detail['TANGGAL'] . ' ' . $dat_catatan_detail['JAM']; ?>" >hapus</a>
		<?php } ?>
		</td>
    </tr>
		<?php $j++; }	
    $i++;
}
?>