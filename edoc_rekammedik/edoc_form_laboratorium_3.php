<?php
$edoc_diagnosa = '';
$sm = true;
if ($nama_pemeriksaan_group != $dat_hasil['NAMA_PEMERIKSAAN_GROUP']) {
	$nama_pemeriksaan_group = $dat_hasil['NAMA_PEMERIKSAAN_GROUP'];
    $sm = false;
}

if ($dat_hasil['CH_LEVEL'] != '1' and !empty($dat_hasil['NAMA_PEMERIKSAAN_GROUP']) and $sm == false) {
    $edoc_diagnosa = $edoc_diagnosa . '
        <tr>
        <td width="25">&nbsp;</td>
        <td colspan="5"><strong>' . $dat_hasil['NAMA_PEMERIKSAAN_GROUP'] . '</strong></td>
		</tr>
        <tr>
        <td>&nbsp;</td>
		<td align="center" width="25">' . $z . '</td>
		<td colspan="2">' . $dat_hasil['NAMA_PEMERIKSAAN'] . '</td>
		<td>' . $dat_hasil['HASIL_DIAGNOSA'] . '</td>
		<td>' . $dat_hasil['METHODE'] . '</td>
		</tr>';
} else {  
    $edoc_diagnosa = $edoc_diagnosa . '
		<tr>
		<td width="25">&nbsp;</td>
		<td align="center" width="25">' . $z . '</td>';
        if ($dat_hasil['CH_LEVEL'] == '1') { 
			$edoc_diagnosa = $edoc_diagnosa . '<td colspan="2"><strong>' . $dat_hasil['NAMA_PEMERIKSAAN'] . '</strong></td>';
        } else { 
			$edoc_diagnosa = $edoc_diagnosa . '<td colspan="2">' . $dat_hasil['NAMA_PEMERIKSAAN'] . '&nbsp;</td>';
		} 
    $edoc_diagnosa = $edoc_diagnosa . '
		<td>' . $dat_hasil['HASIL_DIAGNOSA'] . '</td>
		<td>' . $dat_hasil['METHODE'] . '</td>
		</tr>';	
}

echo $edoc_diagnosa; 
?>