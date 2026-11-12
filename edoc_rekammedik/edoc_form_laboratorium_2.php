<?php
$edoc_diagnosa = '';
$sm = true;
if ($nama_pemeriksaan_group != $dat_hasil['NAMA_PEMERIKSAAN_GROUP']) {
    $nama_pemeriksaan_group = $dat_hasil['NAMA_PEMERIKSAAN_GROUP'];
	$sm = false;
}

if ($dat_hasil['CH_LEVEL'] != '1' and !empty($dat_hasil['NAMA_PEMERIKSAAN_GROUP']) and $sm == false) {
    if($dat_hasil['REPORT_FORMAT'] == '2'){ 
		$edoc_diagnosa = $edoc_diagnosa . '
		<tr>
		<td>&nbsp;</td>
        <td colspan="3"><strong>' . $dat_hasil['NAMA_PEMERIKSAAN_GROUP'] . '</strong></td>';
		
		$edoc_diagnosa = $edoc_diagnosa . '
			<td><table width="100%" border="0" class="tbc">
				<tr>
				<td width="20%" align="center" style="border-right:1px solid black; ">Bi</td>
				<td width="20%" align="center" style="border-right:1px solid black; ">Mi</td>
				<td width="20%" align="center" style="border-right:1px solid black; ">S (%)</td>
				<td width="20%" align="center" style="border-right:1px solid black; ">F (%)</td>
				<td width="20%" align="center">G (%)</td>
				</tr>
				</table></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>';
	}else{ 
		$edoc_diagnosa = $edoc_diagnosa . '
		<tr>
		<td>&nbsp;</td>
        <td colspan="6"><strong>' . $dat_hasil['NAMA_PEMERIKSAAN_GROUP'] . '</strong></td>';
	}
    $edoc_diagnosa = $edoc_diagnosa . '
		</tr>
        <tr>
        <td>&nbsp;</td>
		<td align="center" width="25">' . $z . '</td>
		<td colspan="2">' . $dat_hasil['NAMA_PEMERIKSAAN'] . '&nbsp;' . ((cekNilaiRujukan($dat_hasil['HASIL_DIAGNOSA'],$dat_hasil['NILAI_RUJUKAN']) == false) ? '<font color="#FF0000">***</font>' : '') . '</td>';
    if($dat_hasil['REPORT_FORMAT'] == '2'){
		$hasil_diagnosa_a = '';
		$hasil_diagnosa_b = '';
		$hasil_diagnosa_c = '';
		$hasil_diagnosa_d = '';
		$hasil_diagnosa_e = '';
		$hasil_diagnosa_array = explode('|!|',$dat_hasil['HASIL_DIAGNOSA']);
		if(sizeof($hasil_diagnosa_array) == 5){
			$hasil_diagnosa_a = $hasil_diagnosa_array[0];
			$hasil_diagnosa_b = $hasil_diagnosa_array[1];
			$hasil_diagnosa_c = $hasil_diagnosa_array[2];
			$hasil_diagnosa_d = $hasil_diagnosa_array[3];
			$hasil_diagnosa_e = $hasil_diagnosa_array[4];
		} 
		$edoc_diagnosa = $edoc_diagnosa . '
			<td><table width="100%" border="0" class="tbc">
				<tr>
				<td  width="20%">' . $hasil_diagnosa_a . '</td>
				<td  width="20%">' . $hasil_diagnosa_b . '</td>
				<td  width="20%">' . $hasil_diagnosa_c . '</td>
				<td  width="20%">' . $hasil_diagnosa_d . '</td>
				<td  width="20%">' . $hasil_diagnosa_e . '</td>
				</tr>
				</table></td>
			<td>' . extractRujukanLab($dat_hasil['NILAI_RUJUKAN']) . '</td>
			<td>' . $dat_hasil['METHODE'] . '</td>';
	}else{ 
		$edoc_diagnosa = $edoc_diagnosa . '
			<td>' . $dat_hasil['HASIL_DIAGNOSA'] . '</td>
			<td>' . extractRujukanLab($dat_hasil['NILAI_RUJUKAN']) . '</td>
			<td>' . $dat_hasil['METHODE'] . '</td>';		
	} 
    $edoc_diagnosa = $edoc_diagnosa . '</tr>';
 } else { 
    $edoc_diagnosa = $edoc_diagnosa . '
		<tr>
		<td>&nbsp;</td>
		<td align="center" width="25">' . $z . '</td>';
		if ($dat_hasil['CH_LEVEL'] == '1') { 
            $edoc_diagnosa = $edoc_diagnosa . '<td colspan="2"><strong>' . $dat_hasil['NAMA_PEMERIKSAAN'] . '</strong>&nbsp;' . ((cekNilaiRujukan($dat_hasil['HASIL_DIAGNOSA'],$dat_hasil['NILAI_RUJUKAN']) == false) ? '<font color="#FF0000">***</font>' : '') . '</td>';
        } else {
            $edoc_diagnosa = $edoc_diagnosa . '<td colspan="2">'  . $dat_hasil['NAMA_PEMERIKSAAN'] . '&nbsp;' . ((cekNilaiRujukan($dat_hasil['HASIL_DIAGNOSA'],$dat_hasil['NILAI_RUJUKAN']) == false) ? '<font color="#FF0000">***</font>' : '') . '</td>';
        }
		if($dat_hasil['REPORT_FORMAT'] == '2'){ 
			$hasil_diagnosa_a = '';
			$hasil_diagnosa_b = '';
			$hasil_diagnosa_c = '';
			$hasil_diagnosa_d = '';
			$hasil_diagnosa_e = '';
			$hasil_diagnosa_array = explode('|!|',$dat_hasil['HASIL_DIAGNOSA']);
			if(sizeof($hasil_diagnosa_array) == 5){
				$hasil_diagnosa_a = $hasil_diagnosa_array[0];
				$hasil_diagnosa_b = $hasil_diagnosa_array[1];
				$hasil_diagnosa_c = $hasil_diagnosa_array[2];
				$hasil_diagnosa_d = $hasil_diagnosa_array[3];
				$hasil_diagnosa_e = $hasil_diagnosa_array[4];
			} 
			$edoc_diagnosa = $edoc_diagnosa . '
				<td><table width="100%" border="0" class="tbc">
					<tr>
					<td width="20%">' . $hasil_diagnosa_a . '</td>
					<td width="20%">' . $hasil_diagnosa_b . '</td>
					<td width="20%">' . $hasil_diagnosa_c . '</td>
					<td width="20%">' . $hasil_diagnosa_d . '</td>
					<td width="20%">' . $hasil_diagnosa_e . '</td>
					</tr>
					</table></td>
				<td>' . extractRujukanLab($dat_hasil['NILAI_RUJUKAN']) . '</td>
				<td>' . $dat_hasil['METHODE'] . '</td>';									
		}else{ 
			$edoc_diagnosa = $edoc_diagnosa . '
				<td>' . $dat_hasil['HASIL_DIAGNOSA'] . '</td>
				<td>' . extractRujukanLab($dat_hasil['NILAI_RUJUKAN']) . '</td>
				<td>' . $dat_hasil['METHODE'] . '</td>';		
		} 
    $edoc_diagnosa = $edoc_diagnosa . '</tr>';	
} 

echo $edoc_diagnosa;
?>