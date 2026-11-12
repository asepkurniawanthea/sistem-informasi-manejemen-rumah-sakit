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
        <td>&nbsp;</td>
        <td colspan="7"><strong>' . $dat_hasil['NAMA_PEMERIKSAAN_GROUP'] . '</strong></td>
        </tr>
        <tr>
		<td>&nbsp;</td>
        <td align="center" width="25">' . $z . '</td>
        <td colspan="2">' . $dat_hasil['NAMA_PEMERIKSAAN'] . '&nbsp;' . ((cekNilaiRujukan($dat_hasil['HASIL_DIAGNOSA'],$dat_hasil['NILAI_RUJUKAN']) == false) ? '<font color="#FF0000">***</font>' : '') . '</td>
        <td>' . $dat_hasil['HASIL_DIAGNOSA'] . '</td>
		<td>' . $dat_hasil['SATUAN'] . '</td>
        <td>' . extractRujukanLab($dat_hasil['NILAI_RUJUKAN']) . '</td>
		<td>' . $dat_hasil['METHODE'] . '</td>
		</tr>';
} else {
	$edoc_diagnosa = $edoc_diagnosa . '	
        <tr>
        <td>&nbsp;</td>
		<td align="center" width="25">' . $z . '</td>';
    if ($dat_hasil['CH_LEVEL'] == '1') { 
        $edoc_diagnosa = $edoc_diagnosa . '<td colspan="2"><strong>' . $dat_hasil['NAMA_PEMERIKSAAN'] . '</strong>&nbsp;' . ((cekNilaiRujukan($dat_hasil['HASIL_DIAGNOSA'],$dat_hasil['NILAI_RUJUKAN']) == false) ? '<font color="#FF0000">***</font>' : '') . '</td>';
    } else { 
        $edoc_diagnosa = $edoc_diagnosa . '<td colspan="2">' . $dat_hasil['NAMA_PEMERIKSAAN'] . '&nbsp;' . ((cekNilaiRujukan($dat_hasil['HASIL_DIAGNOSA'],$dat_hasil['NILAI_RUJUKAN']) == false) ? '<font color="#FF0000">***</font>' : '') . '</td>';
    } 
	
	
    $edoc_diagnosa = $edoc_diagnosa . '<td>' . $dat_hasil['HASIL_DIAGNOSA'] . '</td>
		<td>' . $dat_hasil['SATUAN'] . '</td>
		<td>' . extractRujukanLab($dat_hasil['NILAI_RUJUKAN']) . '</td>
		<td>' . $dat_hasil['METHODE'] . '</td>
		</tr>';
} 

echo $edoc_diagnosa;
?>