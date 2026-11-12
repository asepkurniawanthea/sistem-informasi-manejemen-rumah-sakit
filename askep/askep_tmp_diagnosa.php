<?php
$qry_askep_diagnosa = 'SELECT 
  t_irna_askep_diagnosa.IRNA_ASKEP_DIAGNOSA_ID,
  t_irna_askep_diagnosa.IRNA_ID,
  DATE_FORMAT(t_irna_askep_diagnosa.TGL_DIAGNOSA,"%d/%m/%Y %H:%i") AS TGL_DIAGNOSA,
  t_irna_askep_diagnosa.DOMAIN,
  t_irna_askep_diagnosa.DIAGNOSIS,
  t_irna_askep_diagnosa.DAFTAR_GEJALA,
  t_irna_askep_diagnosa.DAFTAR_ETIOLOGI,
  t_irna_askep_diagnosa.PEGAWAI_ID,
  t_irna_askep_diagnosa.NO_ASKEP,
  t_irna_askep_diagnosa.USER_RANAP
FROM
  t_irna_askep_diagnosa
WHERE IRNA_ID = "' . $irna_id . '"';
$get_askep_diagnosa = mysql_query($qry_askep_diagnosa) or die(mysql_error());
?>
<tr>
     <th width="30">No</th>
	<th width="100">Tanggal</th>
	<th>Domain</th>
	<th>Diagnosa Keperawatan</th>
	<th>Daftar Gejala -Batasan Karakteristik</th>
	<th>Daftar Etiologi - Faktor Resiko</th>
	<th width="100">Status</th>
    <th width="100">Option</th>
</tr>
<?php
$i = 1;
while ($dat_askep_diagnosa = mysql_fetch_array($get_askep_diagnosa)) {
    ?>
    <tr>
        <td align="center"><?php echo $i; ?></td>
		<td><?php echo $dat_askep_diagnosa['TGL_DIAGNOSA']; ?></td>
		<td><?php echo $dat_askep_diagnosa['DOMAIN']; ?></td>
		<td><?php echo $dat_askep_diagnosa['DIAGNOSIS']; ?></td>
		<td><?php echo $dat_askep_diagnosa['DAFTAR_GEJALA']; ?></td>
		<td><?php echo $dat_askep_diagnosa['DAFTAR_ETIOLOGI']; ?></td>
		<td align="center"><?php if(empty($dat_askep_diagnosa['NO_ASKEP'])) echo ' Belum Disimpan'; ?></td>
        <td align="center">
		<a href="<?php echo currentUrl(); ?>&idd=<?php echo $dat_askep_diagnosa['IRNA_ASKEP_DIAGNOSA_ID']; ?>&nmr=<?php echo $dat_askep_diagnosa['DOMAIN']; ?>" >hapus</a>
		</td>
    </tr>
<?php    
   $i++;
}
?>